<?php
session_start();
include("conexion.php");


$modo_edicion = false;
$usuario_editado = [
    'id' => '',
    'nombre' => '',
    'correo' => '',
    'telefono' => ''
];

$mensaje_error = '';
$mensaje_exito = '';



function correoExiste($conn, $correo, $id_excluir = null) {
    if ($id_excluir !== null) {
        $stmt = $conn->prepare("SELECT id FROM usuarios WHERE correo = ? AND id != ?");
        $stmt->bind_param("si", $correo, $id_excluir);
    } else {
        $stmt = $conn->prepare("SELECT id FROM usuarios WHERE correo = ?");
        $stmt->bind_param("s", $correo);
    }
    
    $stmt->execute();
    $resultado = $stmt->get_result();
    $existe = $resultado->num_rows > 0;
    $stmt->close();
    
    return $existe;
}



// Agregar nuevo usuario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["guardar"])) {
    $nombre = trim($_POST["nombre"]);
    $correo = trim($_POST["correo"]);
    $telefono = trim($_POST["telefono"]);
    $contraseña = password_hash($_POST["contraseña"], PASSWORD_DEFAULT);

    // Validaciones básicas
    if (empty($nombre) || empty($correo) || empty($telefono) || empty($_POST["contraseña"])) {
        $mensaje_error = "Todos los campos son obligatorios.";
    } elseif (correoExiste($conn, $correo)) {
        $mensaje_error = "El correo electrónico ya está en uso. Usa otro.";
    } else {
        $stmt = $conn->prepare("INSERT INTO usuarios (nombre, correo, telefono, contraseña) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nombre, $correo, $telefono, $contraseña);
        if ($stmt->execute()) {
           $_SESSION['mensaje_exito'] = "Usuario creado exitosamente.";
header("Location: admin_users.php");
exit();

        } else {
           $_SESSION['mensaje_error'] = "Error al crear el usuario.";

        }
        $stmt->close();
    }
}

// Cargar datos para editar
if (isset($_GET["editar"])) {
    $modo_edicion = true;
    $id = (int) $_GET["editar"];
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    if ($resultado->num_rows > 0) {
        $usuario_editado = $resultado->fetch_assoc();
    } else {
        $mensaje_error = "Usuario no encontrado.";
    }
    $stmt->close();
}

// Actualizar usuario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["actualizar"])) {
    $id = (int) $_POST["id"];
    $nombre = trim($_POST["nombre"]);
    $correo = trim($_POST["correo"]);
    $telefono = trim($_POST["telefono"]);

    // Validaciones básicas
    if (empty($nombre) || empty($correo) || empty($telefono)) {
        $mensaje_error = "Todos los campos son obligatorios.";
    } elseif (correoExiste($conn, $correo, $id)) {
        $mensaje_error = "El correo electrónico ya está en uso por otro usuario.";
    } else {
        $stmt = $conn->prepare("UPDATE usuarios SET nombre=?, correo=?, telefono=? WHERE id=?");
        $stmt->bind_param("sssi", $nombre, $correo, $telefono, $id);
        if ($stmt->execute()) {
            $mensaje_exito = "Usuario actualizado exitosamente.";
            header("Location: admin_users.php");
            exit();
        } else {
            $mensaje_error = "Error al actualizar el usuario.";
        }
        $stmt->close();
    }
}

// Eliminar usuario
if (isset($_GET["eliminar"])) {
    $id = (int) $_GET["eliminar"];
    $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $mensaje_exito = "Usuario eliminado exitosamente.";
    } else {
        $mensaje_error = "Error al eliminar el usuario.";
    }
    $stmt->close();
    header("Location: admin_users.php");
    exit();
}

// Obtener usuarios
$resultado = $conn->query("SELECT * FROM usuarios ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel de Usuarios</title>
  <link rel="stylesheet" href="../CSS/estilos.css">
</head>
<body>

<h1>Panel de Administración de Usuarios</h1> <a href="../../VIEW/Admin.php">← Volver</a>

<?php if(isset($_SESSION['mensaje_error'])): ?>
    <div class="error"><?= htmlspecialchars($_SESSION['mensaje_error']) ?></div>
    <?php unset($_SESSION['mensaje_error']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['mensaje_exito'])): ?>
    <div class="exito"><?= htmlspecialchars($_SESSION['mensaje_exito']) ?></div>
    <?php unset($_SESSION['mensaje_exito']); ?>
<?php endif; ?>


<h2><?= $modo_edicion ? "Editar usuario" : "Agregar nuevo usuario" ?></h2>

<form method="POST" action="admin_users.php">
  <input type="hidden" name="id" value="<?= htmlspecialchars($usuario_editado['id']) ?>">
  <input type="text" name="nombre" placeholder="Nombre del usuario" value="<?= htmlspecialchars($usuario_editado['nombre']) ?>" pattern="[A-Za-zñÑáÁéÉíÍóÓúÚ'- ]+" title="Solo letras y espacios (con acentos)" required>
  <input type="email" name="correo" placeholder="Correo electrónico" value="<?= htmlspecialchars($usuario_editado['correo']) ?>" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" title="Formato: usuario@dominio.com" required>
<input type="tel" name="telefono"
       placeholder="Teléfono (ej: 123-456-7890)"
       value="<?= htmlspecialchars($usuario_editado['telefono']) ?>"
       pattern="\d{3}[- ]?\d{3}[- ]?\d{4}|\d{10}"
       title="Formato: 123-456-7890, 123 456 7890 o 1234567890 (10 dígitos)"
       required>

  <?php if ($modo_edicion): ?>
    <button type="submit" name="actualizar">Actualizar usuario</button>
    <a href="admin_users.php" class="cancelar">Cancelar</a>
  <?php else: ?>
    <input type="password" name="contraseña" placeholder="Contraseña" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,20}$" title="Debe tener entre 8 y 20 caracteres, incluyendo al menos una mayúscula, una minúscula y un número"  required>
    <button type="submit" name="guardar">Guardar usuario</button>
  <?php endif; ?>
</form>

<h2>Lista de usuarios</h2>
<table>
  <thead>
    <tr>
      <th>Nombre</th>
      <th>Email</th>
      <th>Teléfono</th>
      <th>Acciones</th>
    </tr>
  </thead>
  <tbody>
    <?php if ($resultado && $resultado->num_rows > 0): ?>
      <?php while($fila = $resultado->fetch_assoc()): ?>
      <tr>
        <td><?= htmlspecialchars($fila["nombre"]) ?></td>
        <td><?= htmlspecialchars($fila["correo"]) ?></td>
        <td><?= htmlspecialchars($fila["telefono"]) ?></td>
        <td class="acciones">
          <a href="admin_users.php?editar=<?= $fila['id'] ?>">✏️ Editar</a>
          <a href="admin_users.php?eliminar=<?= $fila['id'] ?>" onclick="return confirm('¿Eliminar este usuario?')">🗑️ Eliminar</a>
        </td>
      </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr>
        <td colspan="4">No hay usuarios registrados.</td>
      </tr>
    <?php endif; ?>
  </tbody>
</table>

</body>
</html>

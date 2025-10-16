<?php
include("conexion.php");

$mensaje_exito = '';
$mensaje_error = '';

// Agregar nuevo artículo
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["guardar"])) {
    $nombre = trim($_POST["nombre"]);
    $categoria = trim($_POST["categoria"]);
    $descripcion = trim($_POST["descripcion"]);
    $imagen = trim($_POST["imagen"]);
    $enlace = trim($_POST["enlace"]);
    $precio = trim($_POST["precio"]);

    // Validaciones básicas (puedes expandir)
    if (empty($nombre) || empty($categoria) || empty($descripcion) || empty($imagen) || empty($enlace) || empty($precio)) {
        $mensaje_error = "Todos los campos son obligatorios.";
    } else {
        $sql = "INSERT INTO articulos (nombre, categoria, descripcion, imagen_url, enlace_externo, precio) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $nombre, $categoria, $descripcion, $imagen, $enlace, $precio);
        if ($stmt->execute()) {
            $mensaje_exito = "Artículo agregado exitosamente.";
        } else {
            $mensaje_error = "Error al agregar el artículo.";
        }
        $stmt->close();
    }
}

// Eliminar artículo (con prepared statement para seguridad)
if (isset($_GET["eliminar"])) {
    $id = (int) $_GET["eliminar"]; // Castear a int para seguridad
    $stmt = $conn->prepare("DELETE FROM articulos WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $mensaje_exito = "Artículo eliminado exitosamente.";
    } else {
        $mensaje_error = "Error al eliminar el artículo.";
    }
    $stmt->close();
}

// Obtener artículos
$resultado = $conn->query("SELECT * FROM articulos ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel Administrativo - Artículos</title>
  <link rel="stylesheet" href="../CSS/estilos.css">
</head>
<body>

<h1>Panel Administrativo - Artículos</h1>
<a href="../../VIEW/Admin.php">← Volver</a>

<?php if ($mensaje_error): ?>
  <div class="error"><?= htmlspecialchars($mensaje_error) ?></div>
<?php endif; ?>

<?php if ($mensaje_exito): ?>
  <div class="exito"><?= htmlspecialchars($mensaje_exito) ?></div>
<?php endif; ?>

<h2>Agregar nuevo artículo</h2>
<form method="POST" action="admin.php">
  <input type="text" name="nombre" placeholder="Nombre del artículo" required>
  <small class="ayuda">Nombre descriptivo del producto.</small>
  
  <input type="text" name="categoria" placeholder="Categoría" required>
  <small class="ayuda">Ej: Electrónicos, Ropa, etc.</small>
  
  <textarea name="descripcion" placeholder="Descripción" required></textarea>
  <small class="ayuda">Detalles del artículo (máx. 500 caracteres recomendados).</small>
  
  <input type="url" name="imagen" placeholder="URL de la imagen" required>
  <small class="ayuda">Enlace directo a la imagen (ej: https://ejemplo.com/imagen.jpg).</small>
  
  <input type="url" name="enlace" placeholder="Enlace al producto" required>
  <small class="ayuda">URL donde comprar/ver el producto (ej: https://amazon.com/producto).</small>
  
  <input type="number" name="precio" placeholder="Precio del artículo" step="0.01" min="0" required>
  <small class="ayuda">Precio en números (ej: 29.99).</small>
  
  <button type="submit" name="guardar">Guardar artículo</button>
</form>

<h2>Lista de artículos</h2>
<table>
  <thead>
    <tr>
      <th>Nombre</th>
      <th>Categoría</th>
      <th>Imagen</th>
      <th>Descripción</th>
      <th>Enlace</th>
      <th>Precio</th>
      <th>Acciones</th>
    </tr>
  </thead>
  <tbody>
    <?php if ($resultado && $resultado->num_rows > 0): ?>
      <?php while($fila = $resultado->fetch_assoc()): ?>
      <tr>
        <td><?= htmlspecialchars($fila["nombre"]) ?></td>
        <td><?= htmlspecialchars($fila["categoria"]) ?></td>
        <td><img src="<?= htmlspecialchars($fila["imagen_url"]) ?>" alt="<?= htmlspecialchars($fila["nombre"]) ?>"></td>
        <td><?= htmlspecialchars($fila["descripcion"]) ?></td>
        <td><a href="<?= htmlspecialchars($fila["enlace_externo"]) ?>" target="_blank">Ver</a></td>
        <td>$<?= number_format((float)$fila["precio"], 2) ?></td> <!-- Formateo de precio -->
        <td class="acciones">
          <a href="editar.php?id=<?= $fila['id'] ?>">✏️ Editar</a>
          <a href="admin.php?eliminar=<?= $fila['id'] ?>" onclick="return confirm('¿Eliminar este artículo?')">🗑️ Eliminar</a>
        </td>
      </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr>
        <td colspan="7" class="centrado">No hay artículos registrados.</td>
      </tr>
    <?php endif; ?>
  </tbody>
</table>

</body>
</html>

<?php
include("conexion.php");

// Verificar que haya un ID válido
if (!isset($_GET["id"])) {
  die("ID de artículo no especificado.");
}

$id = $_GET["id"];
$mensaje = "";

// Obtener los datos actuales del artículo
$sql = "SELECT * FROM articulos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$articulo = $resultado->fetch_assoc();
$stmt->close();

if (!$articulo) {
  die("Artículo no encontrado.");
}

// Si se envió el formulario de edición
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["actualizar"])) {
  $nombre = $_POST["nombre"];
  $categoria = $_POST["categoria"];
  $descripcion = $_POST["descripcion"];
  $imagen = $_POST["imagen"];
  $enlace = $_POST["enlace"];
  $precio = $_POST["precio"];

  $sql = "UPDATE articulos SET nombre=?, categoria=?, descripcion=?, imagen_url=?, enlace_externo=?, precio=? WHERE id=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssssssi", $nombre, $categoria, $descripcion, $imagen, $enlace, $precio, $id);
  $stmt->execute();
  $stmt->close();

  $mensaje = "✅ Artículo actualizado correctamente.";
  // Volver a cargar el artículo actualizado
  $resultado = $conn->query("SELECT * FROM articulos WHERE id = $id");
  $articulo = $resultado->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar artículo</title>
  <style>
    body { font-family: sans-serif; padding: 30px; background: #f5f5f5; }
    form { background: white; padding: 20px; border-radius: 6px; max-width: 600px; margin: auto; }
    input, textarea { display: block; width: 100%; margin: 10px 0; padding: 8px; }
    button { padding: 10px 15px; background: #28a745; color: white; border: none; cursor: pointer; }
    .mensaje { background: #d4edda; padding: 10px; margin-bottom: 20px; color: #155724; border-radius: 4px; }
    a.volver { display: inline-block; margin-top: 20px; text-decoration: none; color: #007bff; }
  </style>
</head>
<body>

<h1>Editar Artículo</h1>

<?php if ($mensaje): ?>
  <div class="mensaje"><?= $mensaje ?></div>
<?php endif; ?>

<form method="POST">
  <input type="text" name="nombre" value="<?= htmlspecialchars($articulo["nombre"]) ?>" required>
  <input type="text" name="categoria" value="<?= htmlspecialchars($articulo["categoria"]) ?>" required>
  <textarea name="descripcion" required><?= htmlspecialchars($articulo["descripcion"]) ?></textarea>
  <input type="url" name="imagen" value="<?= htmlspecialchars($articulo["imagen_url"]) ?>" required>
  <input type="url" name="enlace" value="<?= htmlspecialchars($articulo["enlace_externo"]) ?>" required>
  <input type="number" name="precio" value="<?= htmlspecialchars($articulo["precio"]) ?>" required>
  <button type="submit" name="actualizar">Actualizar artículo</button>
</form>

<a href="admin.php" class="volver">← Volver al panel</a>

</body>
</html>


<?php
session_start();
include("../ASSETS/PHP/conexion.php");

if (!isset($_SESSION['cliente'])) {
    die("Debes iniciar sesión para usar el carrito.");
}

$nombre = $_SESSION['cliente'];

// Buscar el id del usuario
$stmt = $conn->prepare("SELECT id FROM usuarios WHERE nombre = ? LIMIT 1");
$stmt->bind_param("s", $nombre);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows === 0) {
    die("Usuario no encontrado.");
}
$user = $res->fetch_assoc();
$user_id = $user['id'];
$stmt->close();

$id = (int)$_GET['id'];

// Buscar producto
$stmt = $conn->prepare("SELECT id, nombre, precio FROM articulos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    die("Producto no encontrado.");
}
$producto = $res->fetch_assoc();
$stmt->close();

// Insertar o actualizar carrito
$stmt = $conn->prepare("
    INSERT INTO carrito (user_id, producto_id, cantidad)
    VALUES (?, ?, 1)
    ON DUPLICATE KEY UPDATE cantidad = cantidad + 1
");
$stmt->bind_param("ii", $user_id, $id);
$stmt->execute();
$stmt->close();

header("Location: Carrito.php");
exit;

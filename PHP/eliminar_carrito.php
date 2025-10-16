<?php
// Iniciar el buffer para evitar errores de encabezados
ob_start();
session_start();
include("conexion.php"); // Ajusta la ruta si es necesario

if (!isset($_SESSION['cliente'])) {
    die("No has iniciado sesión.");
}

if (!isset($_GET['id'])) {
    die("ID de producto no proporcionado.");
}

$producto_id = (int) $_GET['id'];
$cliente = $_SESSION['cliente'];

// Obtener el ID del usuario
$stmt = $conn->prepare("SELECT id FROM usuarios WHERE nombre = ? LIMIT 1");
$stmt->bind_param("s", $cliente);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Usuario no encontrado.");
}

$user = $result->fetch_assoc();
$user_id = $user['id'];
$stmt->close();

// Eliminar el producto del carrito en la base de datos
$stmt = $conn->prepare("DELETE FROM carrito WHERE user_id = ? AND producto_id = ?");
$stmt->bind_param("ii", $user_id, $producto_id);
$stmt->execute();
$stmt->close();

// Redirigir de nuevo al carrito
header("Location: ../../VIEW/Carrito.php");
exit;

// Finalizar el buffer
ob_end_flush();

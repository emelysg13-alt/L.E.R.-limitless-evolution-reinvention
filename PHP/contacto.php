<?php
include ('conexion.php');

$nombre = $_POST['nombre'] ?? '';
$email = $_POST['email'] ?? '';
$mensaje = $_POST['mensaje'] ?? '';


$sql = "INSERT INTO contacto (nombre, email, mensaje) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $nombre, $email, $mensaje);

if ($stmt->execute()) {
    echo "<script>
                alert('Mensaje enviado con éxito. 🌟');
                window.location.href = '../../VIEW/Contacto.php';
              </script>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>

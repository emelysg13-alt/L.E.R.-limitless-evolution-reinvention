<?php

include ('conexion.php');

$nombre = $_POST['Nombre'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];
$contraseña = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);

$sql = "INSERT INTO usuarios (nombre, correo, telefono, contraseña) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $nombre,$correo, $telefono, $contraseña);

if ($stmt->execute()) {
echo "<script>
alert('Registro exitoso');
window.location.href = '../../VIEW/Login.html';
</script>";
} else {
echo "<script>
alert('Error al registrar: " . addslashes($stmt->error) . "');
window.history.back();
</script>";
}

$stmt->close();
$conn->close();
?>



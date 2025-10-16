<?php 
session_start(); 
include('conexion.php'); 

$correo = $_POST['correo'] ?? ''; 
$contraseña = $_POST['contraseña'] ?? ''; 

$sql = "SELECT * FROM administrador WHERE correo = ?"; 
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) { 
    if (password_verify($contraseña, $user['contraseña'])) { 
        $_SESSION['cliente'] = $user['nombre'];
        echo "<script>
                alert('Bienvenida Administradora, " . addslashes($user['nombre']) . "');
                window.location.href = '../../VIEW/Admin.php'; // Redirige a Admin.php
              </script>";
        exit();
    } else {
        echo "<script>
                alert('Contraseña incorrecta.'); // Mensaje de error
                window.history.back();
              </script>";
    }
} else {
    echo "<script>
            alert('Correo no registrado.'); // Mensaje de error
            window.history.back();
          </script>";
}

$stmt->close();
$conn->close();

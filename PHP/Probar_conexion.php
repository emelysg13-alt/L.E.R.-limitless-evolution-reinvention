<?php
$host = "localhost";
$db = "lerxport";  
$user = "root";
$pass = "";            
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("❌ Error de conexión: " . $conn->connect_error);
} else {
    echo "✅ Conexión exitosa a la base de datos '$db'";
}

$conn->close();
?>



  

<?php
session_start();
include '../ASSETS/PHP/conexion.php';

$usuario = $_SESSION['cliente'];

$res = $conn->query("SELECT * FROM loopy WHERE nombre = '$usuario' OR destinatario = '$usuario' ORDER BY fecha ASC");

while ($row = $res->fetch_assoc()) {
  $autor = $row['autor'];
  $mensaje = htmlspecialchars($row['mensaje']);
  $nombre = ($autor === 'loopy') ? 'Loopy 🤖' : htmlspecialchars($row['nombre']);
  $clase = ($autor === 'loopy') ? 'text-success text-start' : 'text-primary text-end';

  echo "<div class='$clase'><strong>$nombre:</strong> $mensaje</div>";
}
?>


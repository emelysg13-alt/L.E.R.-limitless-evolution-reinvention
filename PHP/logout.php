
<?php
session_start();
unset($_SESSION['cliente']);  // Elimina la variable de sesión específica
session_destroy();  // Destruye toda la sesión
header("Location: ../../Página Principal.php");  // Redirige a la página de inicio
exit();
?>
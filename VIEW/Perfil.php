<?php 
session_start(); 
include("../ASSETS/PHP/conexion.php"); 

$datos = null;

if (isset($_SESSION['cliente'])) {
    $nombre = $_SESSION['cliente'];
    $sql = "SELECT * FROM usuarios WHERE nombre = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nombre);
    $stmt->execute();
    $result = $stmt->get_result();
    $datos = $result->fetch_assoc();
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Perfil - LerXport</title>
  <link rel="stylesheet" href="../ASSETS/CSS/Perfil.css" />
  <link href="https://fonts.googleapis.com/css2?family=Antonio&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>

<header>
  <div class="logo">
    <img src="../ASSETS/IMG/Logo.png" alt="Logo de la tienda" />
    <h1>LerXport</h1>
  </div>
  <nav>
    <ul class="menu">
      <li><a href="../Página Principal.php">Inicio</a></li>
     
          <li><a href="../VIEW/Portafolio.php">Cómo funciona LerXport</a></li>
          
      <li class="dropdown">
        <a href="#">Ayuda ▼</a>
        <ul class="submenu">
          <li><a href="../VIEW/Contacto.php">Contacto</a></li>
          <li><a href="../Loopy.php">CHATBOT-Loopy</a></li>
        </ul>
      </li>
      <?php if (isset($_SESSION['cliente'])): ?>
        <li><a href="../ASSETS/PHP/logout.php" class="estrella" title="Cerrar sesión">
          <img src="../ASSETS/IMG/icon.png" alt="Cerrar sesión"></a></li>
      <?php else: ?>
        <li><a href="VIEW/Inicio.html">Ingresar</a></li>
      <?php endif; ?>
    </ul>
  </nav>
</header>

<section id="contacto">
  <h2>Mi Perfil</h2>
  <p>Aquí puedes ver la información asociada a tu cuenta.</p>

  <?php if ($datos): ?>
    <div class="perfil-contenedor">
      <div class="perfil-foto">
        <img src="../ASSETS/IMG/icon.png" alt="Foto de perfil">
      </div>
      <div class="perfil-campo">
        <label>Nombre completo:</label>
        <span><?= htmlspecialchars($datos['nombre']) ?></span>
      </div>
      <div class="perfil-campo">
        <label>Correo electrónico:</label>
        <span><?= htmlspecialchars($datos['correo']) ?></span>
      </div>

      <a href="../VIEW/carrito.php" class="btn carrito-btn">🛒 Ver mi carrito</a>
      <a href="../ASSETS/PHP/logout.php" class="btn">Cerrar Sesión</a>
      

      <div class="perfil-mensaje">
        ¿Deseas actualizar tus datos? Escríbenos desde <a href="../VIEW/Contacto.php">Contáctenos</a> o consulta a nuestro <a href="../Loopy.php">chatbot</a>.
      </div>
    </div>
  <?php else: ?>
    <p>No se encontraron datos del usuario. <a href="Inicio.html">Iniciar sesión</a></p>
  <?php endif; ?>
</section>



<footer>
  <p><strong>© 2025 LerXport - L.E.R.</strong></p>
</footer>

</body>



</html>

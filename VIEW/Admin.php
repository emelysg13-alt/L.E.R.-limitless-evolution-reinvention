
<?php
session_start(); 
include("../ASSETS/PHP/conexion.php"); 

?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Panel de Administración</title>
  <link rel="stylesheet" href="../ASSETS/CSS/Admin.css" />
</head>
<body>

  <div class="panel-container">

    <h1 class="titulo">Panel de Administración L.E.R.</h1>

    <!-- SECCIÓN DE GESTIÓN -->
    <section class="seccion">
      <h2>Gestión</h2>
      <div class="grid">
        <div class="card">
          <h3>Gestión de Mensajes</h3>
          <p>Ver, eliminar mensajes de usuarios</p>
          <a href="../ASSETS/PHP/admin_contacto.php" class="btn">Entrar</a>
        </div>
        <div class="card">
          <h3>Gestión de Artículos</h3>
          <p>Agrega, edita o elimina productos</p>
          <a href="../ASSETS/PHP/admin.php" class="btn">Administrar</a>
        </div>
        <div class="card">
          <h3>Gestión de Usuarios</h3>
          <p>Agrega, edita o elimina USUARIOS</p>
          <a href="../ASSETS/PHP/admin_users.php" class="btn">Entrar</a>
        </div>
        <div class="card">
          <h3>Gestión de Cotizaciones</h3>
          <p>Gestionar las cotizaciones por usuario</p>
          <a href="../ASSETS/PHP/admin_cotizaciones.php" class="btn">Administrar</a>
        </div>
      </div>
    </section>

    <section class="seccion">
      <h2>Chatbot</h2>
      <div class="grid">
        <div class="card">
          <h3>Chatbot FAQ</h3>
          <p>Bot de respuestas frecuentes configurables</p>
          <a href="../Loopy/admin_faq.php" class="btn">Ver FAQ</a>
        </div>
        <div class="card">
          <h3>Chatbot de Soporte</h3>
          <p>Administrar chats</p>
          <a href="../Loopy/admin_chat.php" class="btn">Abrir Chat</a>
        </div>
      </div>
    </section>

    <!-- CERRAR SESIÓN -->
     <?php if (isset($_SESSION['cliente'])): ?>
    <section class="logout">
      <a href="../ASSETS/PHP/logout.php" class="btn logout-btn">Cerrar Sesión</a>
    </section>

    <?php endif; ?>

  </div>

  <footer>
    &copy;2025 LerXport - L.E.R. • Panel de Administración 
  </footer>

</body>
</html>

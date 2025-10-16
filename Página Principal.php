<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>L.E.R.</title>
  <link rel="stylesheet" href="ASSETS/CSS/Style.css">
  <link href="https://fonts.googleapis.com/css2?family=Antonio&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
  <!-- 🔹 ENCABEZADO -->
  <header>
    <div class="logo">
      <img src="ASSETS/IMG/Logo.png" alt="Logo de la tienda" />
      <h1> LerXport</h1>
    </div>
    <nav>
      <ul class="menu">
        <li><a href="Página Principal.php">Inicio</a></li>
      
            <li><a href="VIEW/Catalogo.php">Catálogo</a></li>
          
        </li>
         <?php if (isset($_SESSION['cliente'])): ?>
        <li class="dropdown">
          <a href="#">Ayuda ▼</a>
          <ul class="submenu">
        <li><a href="VIEW/Contacto.php">Contacto</a></li>
        <li><a href="loopy.php">CHATBOT-Loopy</a></li>
</ul>
</li>
<?php else: ?>
  <li class="dropdown">
          <a href="#">Ayuda ▼</a>
          <ul class="submenu">
        <li><a href="VIEW/Contacto.php">Contacto</a></li>
        <li><a href="VIEW/Inicio.html">CHATBOT-Loopy</a></li>
</ul>
</li>


  <?php endif; ?>
            <li><a href="VIEW/Portafolio.php">Cómo funciona LerXport</a></li>
    
        <?php if (isset($_SESSION['cliente'])): ?>
  <li><a href="VIEW/Perfil.php" class="estrella" title="Perfil"> 
    <img src="ASSETS/IMG/icon.png" alt="SS"></a></li>
<?php else: ?>
  <li><a href="VIEW/Inicio.html">Ingresar</a></li>
<?php endif; ?>
      </ul>
    </nav>
  </header>

  <!-- 🔹 SECCIÓN HERO -->
<section class="hero-section">
  <?php if (!isset($_SESSION['cliente'])): ?>
    <!-- hero sin sesión -->
     <div class="hero-content principal">
    <h1>Bienvenido a LerXport, tu espacio creativo. <br>Inicia sesión y accede a un mundo de inspiración, artículos exclusivos y herramientas para potenciar tus ideas</h1>
    
    <a href="VIEW/Inicio.html" class="btn-ver-mas">EXPLORAR</a>
  </div>

  <div class="hero-subcontainer">
    <div class="hero-content secundario">
     <a href="../LER/loopy.html" target ="_blank"> <h2> Loopy </h2> </a> <br>
      <p>Conoce a Loopy 🤖, tu asistente virtual. Te guiará en la plataforma, recomendará artículos y responderá tus dudas para que tus ideas nunca se detengan..</p>
    </div>
    <div class="hero-content secundario">
      <h2>Descubre nuestro catálogo</h2> <br>
      <p> Encuentra artículos seleccionados en colaboración con Vento para inspirarte y mantener tu creatividad en movimiento</p>
      <a href="VIEW/Catalogo.php" class="btn-ver-mas">Ver catálogo</a>
    </div>
  </div>
  <?php else: ?>
    <!-- hero con sesión -->
     <div class="hero-content principal">
    <h1>¡Bienvenid@!</h1>
    <h1>¡Equípate como un profesional! 🏀⚽🏋️‍♂️</h1>
      <p>Descubre los mejores artículos deportivos para cada disciplina.</p>
      <p> <strong>Donde el deporte cruza fronteras, porque el talento no tiene límites<strong></p>
    <a href="VIEW/Portafolio.php" class="btn-ver-mas">Ver más</a>
  </div>
  <?php endif; ?>
</section>

  <!-- 🔹 CONTENIDO PRINCIPAL -->
  <main>
    <section class="beneficios-nuevo">
  <h2>Limitless evolution & Reinvention</h2>
  <div class="beneficios-grid">
    
    <div class="beneficio-card">

      <a href="../LER/index.php"> <img src="../LER/IMG/Logo.png" width="200px"> </a>
  
    </div>
    
  </div>
</section>

    <section class="widgets">
      <?php if (!isset($_SESSION['cliente'])): ?>
      <div class="widget">
        <h3>🕒 Hora Actual</h3>
        <p id="reloj">Cargando...</p> 
        <script src="ASSETS/JS/reloj.js"></script>
      </div>
      <?php else: ?> 

      <div class="widget">
        <h3>Loopy tu CHATBOT</h3>
        <a href="../LER/loopy.html" class="btn-ver-mas">L∞py</a>
      </div>
       <?php endif; ?>


       <?php if (!isset($_SESSION['cliente'])): ?>
      <div class="widget">
        <h3>Inicia sesión o Registrate</h3>
        <a href="VIEW/Inicio.html" class="btn-ubicacion">Ingresar</a>
      </div>
<?php else: ?> 
  <div class="widget">
        <h3> Cerrar Sesión</h3>
        <a href="ASSETS/PHP/logout.php" class="btn-ubicacion">Salir</a>
      </div>
<?php endif; ?>
    </section>
  </main>

 <footer>
  <p><strong>© 2025 LerXport - L.E.R.</strong></p>
</footer>

  <?php if (!isset($_SESSION['cliente'])): ?>
  <div id="pelota" class="pelota"></div>

<style>
  .pelota {
    width: 70px;
    height: 70px;
    background-image: url('ASSETS/IMG/descarga.png');
    background-size: cover;
    border-radius: 50%;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 9999;
  }
</style>

<script src="ASSETS/JS/pelota.js"></script>
<?php else: ?> 
  
 <style>
  .chat-bubble {
  position: fixed;
  bottom: 20px;
  right: 20px;
  background: linear-gradient(135deg, #6a7fdb, #301299);
  color: white;
  font-size: 0; 
  text-decoration: none;
  border-radius: 50%;
  width: 70px; 
  height: 70px;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  z-index: 9999;
  animation: float 3s ease-in-out infinite;
  overflow: hidden;
}

.chat-bubble img {
  width: 140%; 
  height: auto;
}

/* Hover */
.chat-bubble:hover {
  transform: scale(1.1);
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4);
}

/* Animación flotante */
@keyframes float {
  0% { transform: translateY(0px); }
  50% { transform: translateY(-8px); }
  100% { transform: translateY(0px); }
}


  </style>
     <?php endif; ?>

</body>
</html>
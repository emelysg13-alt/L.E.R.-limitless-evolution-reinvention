<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LerXport | Cómo funciona</title>
  <link rel="stylesheet" href="../ASSETS/CSS/Portafolio.css">
    <link href="https://fonts.googleapis.com/css2?family=Antonio&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">

</head>
<body>

  <header>
    <div class="logo">
      <img src="../ASSETS/IMG/Logo.png" alt="Logo LerXport">
      <h1>LerXport</h1>
    </div>
    <nav>
      <ul>
        <li><a href="../Página Principal.php">Inicio</a></li>
        <li><a href="../VIEW/Catalogo.php">Catálogo</a></li>
        <li><a href="../VIEW/Contacto.php">Contacto</a></li>
        <?php if (isset($_SESSION['cliente'])): ?>
  <li><a href="../VIEW/Perfil.php" class="estrella" title="Perfil"> 
    <img src="../ASSETS/IMG/icon.png" alt="SS"></a></li>
<?php else: ?>
  <li><a href="../VIEW/Inicio.html">Ingresar</a></li>
<?php endif; ?>
      </ul>
    </nav>
  </header>

 <main class="contenedor">

    <!-- Bloque funcionamiento -->
    <section id="funcionamiento" class="bloque">
      <h2>Cómo funciona LerXport</h2>
      <p>
        En <strong>LerXport</strong> conectamos eficientemente los productos de 
        <strong>VentoSport</strong> con clientes interesados mediante soluciones digitales.
      </p>
      <p>
        <strong>¿Compro aquí directamente?</strong><br>
        No, LerXport no realiza la venta directa. Canalizamos tus solicitudes al 
        equipo de ventas de VentoSport, quienes se encargarán de la cotización, asesoría 
        y cierre de la compra. Así garantizamos una atención profesional y especializada.
      </p>
    </section>

    <!-- Bloque sobre Vento -->
    <section class="bloque empresa-vento">
      <h2>Sobre VentoSport</h2>
      <div class="vento-info">
        <img src="../ASSETS/IMG/Vento.png" alt="Logo VentoSport" class="logo-vento">
        <p>
          <strong>VentoSport</strong> es una empresa líder en el mercado deportivo, 
          comprometida con ofrecer productos y servicios de alta calidad para atletas 
          y entusiastas del deporte. Su equipo brinda asesoría personalizada y 
          acompañamiento en cada etapa del proceso de compra.
        </p>
      </div>
      <div class="boton-final">
        <a href="https://ventosport.com" target="_blank" class="btn">Ir a VentoSport</a>
      </div>
    </section>

  </main>

  <!-- FOOTER -->
  <footer>
    <p>&copy; 2025 LerXport | Plataforma de promoción deportiva</p>
  </footer>

</body>
</html>
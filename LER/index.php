<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>L.E.R.</title>
  <link href="https://fonts.googleapis.com/css2?family=Garamond:wght@400;700&family=Merriweather:wght@400;700&display=swap" rel="stylesheet">
     <link rel="stylesheet" href="styles.css">
     <link rel="icon" href="IMG/icon.png" type="image/x-icon">

</head>
<body>
  <canvas id="canvas" class="snow"></canvas>

  <header>
    <div class="center-content">
      <div class="logo">
        <img src="IMG/Logo.png" alt="Logo de LER - Empresa de innovación y deporte" />
      </div>

      <nav class="menu">
        <ul>
          <li><a href="QS.html">¿Quiénes somos?</a></li>
          <li><a href="PE.html">¿Por qué elegirnos?</a></li> 
          <li><a href="loopy.html">Loopy</a></li>
          <li><a href="CN.html">Contacta con L.E.R.</a></li>
          <li><a href="#proyectos">Proyectos</a></li>
          <li><a id="toggle-btn" title="Activar modo oscuro">⭒˚.⋆☪˚.⋆</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <main class="contenedor">
   
    <section class="bloque bienvenida">
      <div class="bienvenida-contenido">
        <div class="bienvenida-imagenes">
        <img src="IMG/Loopy.png" alt="1" class="bienvenida-imagen"/>
        <img src="IMG/Logo.png" alt="2" class="bienvenida-imagen"/>
        </div>
        <div class="bienvenida-texto">
          <h2>¡Bienvenido a LER!</h2>
          <strong><p>Limitless Evolution & Reinvention</p></strong>
        </div>
      </div>
    </section>

   
    <section class="bloque que-hacemos">
      <h2>¿Qué hace L.E.R.?</h2>
      <p>En LER no hacen solo software, crean universos. Cada proyecto es un mundo único, guiado por <strong>Loopy</strong>
      su asistente digital que crece contigo <br>
    Elegir <strong>LER</strong> es elegir Evolución, creatividad y tecnología sin <i>Limites</i> </p>
    
    </section>

    
    <section class="bloque proyectos" id="servicios">
      <h2>Servicios</h2>
      <p> LER no solo desarrolla soluciones digitales: garantiza que cada proyecto se pueda defender, demostrar y mantener con evidencia lista para audiencias técnicas y no técnicas.</p>
      <div class="tarjetas-container">
        <div class="tarjeta">
          <h3>Desarrollo y gestión de plataformas digitales</h3>
          <p>Diseño y construcción de sitios y aplicaciones web innovadoras, con enfoque en simplicidad y usabilidad.<br> En LER creamos plataformas que no solo funcionan, sino que también son fáciles de usar y administrar.</p>
          
        </div> 
        <div class="tarjeta">
          <h3>Gestión y administración de bases de datos</h3>
          <p>Organizamos y protegemos la información clave para que siempre esté disponible y segura.</p>
  
        </div>
         <div class="tarjeta">
          <h3>Consultoría en innovación digital</h3>
          <p>Acompañamos a emprendedores y empresas a transformar sus ideas en soluciones digitales prácticas y viables.</p>
          
        </div> 
      </div>
      <br> 
      <div class="tarjetas-container">
        <div class="tarjeta">
          <h3>Diseño de experiencias digitales (UX/UI)</h3>
          <p>Creamos interfaces claras e intuitivas para que cualquier usuario pueda navegar sin complicaciones.</p>
          
        </div> 
        <div class="tarjeta">
          <h3>Creación de manuales y documentación técnica</h3>
          <p>Elaboramos guías claras que ayudan a comprender y usar de forma independiente las soluciones creadas por LER.</p>
       
        </div>
         <div class="tarjeta">
          <h3>Prototipado y validación de ideas digitales</h3>
          <p>Diseñamos versiones de prueba de un proyecto para comprobar su funcionamiento y viabilidad antes de la inversión final.</p>
          
        </div> 
      </div>
    </section>

    <!-- Sección "Explorar Proyectos" con tarjetas -->
    <section class="bloque proyectos" id="proyectos">
      <h2>Explorar Proyectos</h2>
      <div class="tarjetas-container">
       <!-- <div class="tarjeta">
          <h3></h3>
          <p></p>
          <a href="#" class="btn-ver-mas">So soon</a>
        </div> -->
        <div class="tarjeta">
          <h3>El mundo del deporte y movimiento ⚡</h3>
          <p>Descubre las últimas tendencias y tecnologías aplicadas en el desarrollo de equipamiento deportivo de alto rendimiento.</p>
          <a href="../PROSOFT-LerXport/Página Principal.php" class="btn-ver-mas">Explorar</a>
        </div>
        <!-- <div class="tarjeta">
          <h3></h3>
          <p></p>
          <a href="#" class="btn-ver-mas">So soon</a>
        </div> -->
      </div>
    </section>


     
  </main>

  <footer>
    <div class="footer-content">
      <p>© 2025 - L.E.R. Limitless Evolution & Reinvention </p>
    </div>
  </footer>

  <script src="script.js"></script>
</body>
</html>

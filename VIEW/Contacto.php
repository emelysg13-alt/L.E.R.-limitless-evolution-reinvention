<?php session_start(); ?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Contacto - LerXport</title>
    <!-- Ruta CSS desde /VIEW/contacto.html a ASSETS/CSS/contacto.css -->
    <link rel="stylesheet" href="../ASSETS/CSS/contacto.css" />
    
  <link href="https://fonts.googleapis.com/css2?family=Antonio&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
    <!-- 🔹 ENCABEZADO -->
    <header>
        <div class="logo">
            <img src="../ASSETS/IMG/Logo.png" alt="Logo de la tienda" />
            <h1>LerXport</h1>
        </div>
        <nav>
            <ul class="menu">
                <li><a href="../Página Principal.php">Inicio</a></li>

                    
                        <li><a href="../VIEW/Portafolio.php">Cómo funciona LerXport</a></li>
                        
               <?php if (isset($_SESSION['cliente'])): ?>
  <li><a href="../VIEW/Perfil.php" class="estrella" title="Perfil"> 
    <img src="../ASSETS/IMG/icon.png" alt="SS"></a></li>
<?php else: ?>
  <li><a href="../VIEW/Inicio.html">Ingresar</a></li>
<?php endif; ?>

            </ul>
        </nav>
    </header>

    <section id="contacto">
        <h2>¡Contáctanos!</h2>
        <p>Estamos para ayudarte. Completa el formulario y nos pondremos en contacto contigo lo antes posible.</p>

        <form action="../ASSETS/PHP/contacto.php" method="POST" class="formulario-contacto">
            <div class="campo">
                <label for="nombre">Nombre Completo</label>
                <input type="text" id="nombre" name="nombre" required placeholder="Tu nombre completo" />
            </div>

            <div class="campo">
                <label for="email">Correo Electrónico</label>
                <input type="email" id="email" name="email" required placeholder="Tu correo electrónico" />
            </div>

            <div class="campo">
                <label for="mensaje">Mensaje</label>
                <textarea id="mensaje" name="mensaje" required placeholder="Escribe tu mensaje aquí" rows="5"></textarea>
            </div>

            <button type="submit" class="btn">Enviar</button>

            <div class="perfil-mensaje">
         O Escríbenos desde <a href="mailto:ler.projectxo@gmail.com">ler.projectx@gmail.com</a>
      </div>
        </form>
    </section>

    <footer>
        <p><strong> © 2025 LerXport - L.E.R.</strong></p>
    </footer>
</body>
</html>

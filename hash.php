   <?php
   $contraseña = "admin12345"; // La contraseña que quieres hashear
   $contraseña_hash = password_hash($contraseña, PASSWORD_DEFAULT); // Genera el hash
   echo $contraseña_hash; // Muestra el hash
   ?>
   
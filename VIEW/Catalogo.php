<?php session_start(); ?>

<?php
include("../ASSETS/PHP/conexion.php");


$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';
$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';


$sql = "SELECT * FROM articulos WHERE 1";

if (!empty($busqueda)) {
    $sql .= " AND (nombre LIKE '%$busqueda%' OR descripcion LIKE '%$busqueda%')";
}

if (!empty($categoria)) {
    $sql .= " AND categoria = '$categoria'";
}

$sql .= " ORDER BY id DESC";
$resultado = $conn->query($sql);

// Obtener lista de categorías únicas para el filtro
$categorias = $conn->query("SELECT DISTINCT categoria FROM articulos");




?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Catálogo con Filtros</title>
  <link rel="stylesheet" href="../ASSETS/CSS/Catalogo.css" />

  <link href="https://fonts.googleapis.com/css2?family=Antonio&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">

  <link rel="stylesheet" href= "ASSETS/CSS/Catalogo.css" />

  <link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
/>
  <style>

    

    form.filtros {
      display: flex;
      justify-content: center;
      gap: 15px;
      margin-bottom: 30px;
    }

    input[type="text"], select {
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

.btn-buscar {
  background-color:rgb(114, 100, 236);    
  color: #fff;                                 
  padding: 10px 20px;         
  font-size: 16px;           
  border-radius: 25px;      
  cursor: pointer;              
  transition: background-color .3s, transform .2s;
  box-shadow: 0 2px 6px rgba(0,0,0,0.2);
}

.btn-buscar:hover {
  background-color:rgb(56, 27, 189);
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0,0,0,0.3);
}
    
  </style>
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
                <li><a href="../VIEW/Contacto.php">Contacto</a></li>
          
                   
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

<h1>Catálogo de Artículos Deportivos</h1>

<form method="GET" class="filtros">
  <input type="text" name="busqueda" placeholder="Buscar..." value="<?= htmlspecialchars($busqueda) ?>">
  
  <select name="categoria">
    <option value="">Todas las categorías</option>
    <?php while($cat = $categorias->fetch_assoc()): ?>
      <option value="<?= $cat['categoria'] ?>" <?= $categoria == $cat['categoria'] ? 'selected' : '' ?>>
        <?= htmlspecialchars($cat['categoria']) ?>
      </option>
    <?php endwhile; ?>
  </select>

  <button type="submit" class="btn-buscar">🔍 Buscar</button>

</form>


 <div class="swiper">
  <div class="swiper-wrapper">
<?php while($art = $resultado->fetch_assoc()): ?>
   <div class="swiper-slide producto-card"> 
    <img src="<?= htmlspecialchars($art["imagen_url"]) ?>" alt="<?= htmlspecialchars($art["nombre"]) ?>">
    <h3><?= htmlspecialchars($art["nombre"]) ?></h3>
    <p><strong>Categoría:</strong> <?= htmlspecialchars($art["categoria"]) ?></p>
    <p><?= htmlspecialchars($art["descripcion"]) ?></p>
    <a class="btn-catalogo" href="<?= htmlspecialchars($art["enlace_externo"]) ?>" target="_blank">Ver producto</a>
  
  <?php if (isset($_SESSION['cliente'])): ?>
    <a class="btn-catalogo" href="agregar_carrito.php?id=<?= $art['id'] ?>">Agregar al carrito</a>
<?php else: ?>
<?php endif; ?>

  </div>
<?php endwhile; ?>
</div>

 <!-- Paginación y navegación -->
    <div class="swiper-pagination"></div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
  </div>


<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
  const swiper = new Swiper('.swiper', {
    slidesPerView: 1,
    spaceBetween: 20,
    loop: true,
    autoplay: {
      delay: 4000,
      disableOnInteraction: false,
    },
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    breakpoints: {
      640: { slidesPerView: 2 },
      1024: { slidesPerView: 3 },
    }
  });
</script>

    <footer>
        <p><strong> © 2025 LerXport - L.E.R.</strong></p>
    </footer>
</body>
</html>

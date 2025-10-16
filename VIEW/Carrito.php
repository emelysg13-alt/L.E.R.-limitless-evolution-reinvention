<?php
session_start();
include("../ASSETS/PHP/conexion.php");

if (!isset($_SESSION['cliente'])) {
    die("Debes iniciar sesión para ver tu carrito.");
}

$nombre = $_SESSION['cliente'];

// Obtener ID de usuario
$stmt = $conn->prepare("SELECT id FROM usuarios WHERE nombre = ? LIMIT 1");
$stmt->bind_param("s", $nombre);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) die("Usuario no encontrado.");
$user = $result->fetch_assoc();
$user_id = $user['id'];
$stmt->close();

// Manejo de actualización de cantidad
if (isset($_POST['update'])) {
    $producto_id = (int)$_POST['producto_id'];
    $cantidad = max(1, (int)$_POST['cantidad']); // mínimo 1
    $stmt = $conn->prepare("UPDATE carrito SET cantidad = ? WHERE user_id = ? AND producto_id = ?");
    $stmt->bind_param("iii", $cantidad, $user_id, $producto_id);
    $stmt->execute();
    $stmt->close();
    header("Location: carrito.php");
    exit;
}

// Obtener productos del carrito
$stmt = $conn->prepare("
    SELECT a.id, a.nombre, a.precio, c.cantidad
    FROM carrito c
    JOIN articulos a ON c.producto_id = a.id
    WHERE c.user_id = ?
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$carrito = [];
$total = 0;
while ($row = $result->fetch_assoc()) {
    $carrito[$row['id']] = [
        'id' => $row['id'],
        'nombre' => $row['nombre'],
        'precio' => $row['precio'],
        'cantidad' => $row['cantidad']
    ];
}
$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Carrito</title>
    <link rel="stylesheet" href="../ASSETS/CSS/carrito.css" />
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
<li><a href="../VIEW/Catalogo.php">Catálogo</a></li>
                    
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


<div class="carrito-container">
<h1>Carrito de Compras</h1>
<a href="catalogo.php">← Volver</a>
<hr>

<?php if (empty($carrito)): ?>
    <p>No hay productos en el carrito.</p>
<?php else: ?>
    <table border="1" cellpadding="8">
        <tr>
            <th>Producto</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Subtotal</th>
            <th>Acción</th>
        </tr>
        <?php foreach ($carrito as $id => $item): 
            $subtotal = $item['precio'] * $item['cantidad'];
            $total += $subtotal;
        ?>
        <tr>
            <td><?= htmlspecialchars($item['nombre']) ?></td>
            <td>$<?= number_format($item['precio'], 2) ?></td>
            <td>
                <form method="post" style="display:flex; gap:5px;">
                    <input type="hidden" name="producto_id" value="<?= $id ?>">
                    <input type="number" name="cantidad" value="<?= $item['cantidad'] ?>" min="1" style="width:50px;">
                    <button type="submit" name="update">Actualizar</button>
                </form>
            </td>
            <td>$<?= number_format($subtotal, 2) ?></td>
            <td>
                <a href="../ASSETS/PHP/eliminar_carrito.php?id=<?= $id ?>">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <div class="total">Total: <?= number_format($total, 0) ?> COP</div>
    <form method="post" action="../ASSETS/PHP/factura.php">
        <button type="submit">Descargar factura / cotización PDF</button>
    </form>
<?php endif; ?>

</div>

<footer>
    <p><strong> © 2025 LerXport - L.E.R.</strong></p>
        </footer>
</body>
</html>

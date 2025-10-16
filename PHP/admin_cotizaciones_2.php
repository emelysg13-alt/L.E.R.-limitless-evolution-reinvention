<?php
include("conexion.php");

$id_usuario = $_GET['id'] ?? 0;

// Obtener cotizaciones del usuario
$sql = "SELECT productos, fecha, total FROM cotizaciones WHERE id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalles de Cotización</title>
   <link rel="stylesheet" href="../CSS/estilos.css">
</head>
<body>
<div class="container mt-5">
    <h2>Detalles de Cotizaciones</h2>
    <?php while($row = $result->fetch_assoc()): ?>
        <?php 
        $productos = json_decode($row['productos'], true); // Convertir JSON a array
        ?>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio (COP)</th>
                    <th>Subtotal (COP)</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $subtotal_total = 0;
                foreach($productos as $item):
                    $subtotal = $item['precio'] * $item['cantidad'];
                    $subtotal_total += $subtotal;
                ?>
                <tr>
                    <td><?= htmlspecialchars($item['nombre']) ?></td>
                    <td><?= $item['cantidad'] ?></td>
                    <td><?= number_format($item['precio'], 0) ?></td>
                    <td><?= number_format($subtotal, 0) ?></td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3" class="text-end"><b>Total</b></td>
                    <td><b><?= number_format($row['total'], 0) ?></b></td>
                </tr>
            </tbody>
        </table>
        <p><b>Fecha:</b> <?= $row['fecha'] ?></p>
    <?php endwhile; ?>
    <a href="admin_cotizaciones.php" class="btn btn-secondary mt-3">Volver</a>
</div>
</body>
</html>

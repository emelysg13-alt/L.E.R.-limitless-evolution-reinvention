<?php 
include("conexion.php");


// Obtener lista de usuarios con cantidad de cotizaciones


$sql = "SELECT u.id, u.nombre, u.correo, COUNT(c.id) AS total_cotizaciones
        FROM usuarios u
        LEFT JOIN cotizaciones c ON u.id = c.id_usuario
        GROUP BY u.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Cotizaciones - Administrador</title>
    <link rel="stylesheet" href="../CSS/estilos.css">
</head>
<body>
<div class="container mt-5">
    <h2>Usuarios y Cotizaciones</h2>
    <a href="../../VIEW/Admin.php">← Volver</a>
    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Total Cotizaciones</th>
                <th>Detalles</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['nombre']) ?></td>
                <td><?= htmlspecialchars($row['correo']) ?></td>
                <td><?= $row['total_cotizaciones'] ?></td>
                <td>
                    <a href="admin_cotizaciones_2.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Ver</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>

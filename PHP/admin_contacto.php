<?php
include("conexion.php");

// --- Eliminar mensaje ---
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $stmt = $conn->prepare("DELETE FROM contacto WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

// --- Marcar / desmarcar leído ---
if (isset($_GET['toggle'])) {
    $id = intval($_GET['toggle']);
    $stmt = $conn->prepare("SELECT importante FROM contacto WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $nuevo_valor = $row['importante'] ? 0 : 1;
        $stmt_update = $conn->prepare("UPDATE contacto SET importante = ? WHERE id = ?");
        $stmt_update->bind_param("ii", $nuevo_valor, $id);
        $stmt_update->execute();
        $stmt_update->close();
    }
    $stmt->close();
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

// --- Filtrar mensajes ---
$filtro_sql = "";
if (isset($_GET['filtro'])) {
    if ($_GET['filtro'] === 'importantes') {
        $filtro_sql = "AND importante = 1";
    } elseif ($_GET['filtro'] === 'no_leidos') {
        $filtro_sql = "AND importante = 0";
    }
}

// --- Obtener todos los mensajes ---
$res = $conn->query("SELECT * FROM contacto WHERE 1 $filtro_sql ORDER BY fecha DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel de Mensajes</title>
  <link rel="stylesheet" href="../CSS/estilos.css">
  <style>
    body { background: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
    h3 { font-weight: 600; margin-bottom: 1rem; }
    .btn-volver { margin-bottom: 1rem; background-color: #6c63ff; color: white; border: none; transition: 0.3s; padding: 5px 10px; text-decoration: none; display: inline-block; }
    .btn-volver:hover { background-color: #5548e8; }
    table { width: 100%; border-collapse: collapse; background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 0 8px rgba(0,0,0,0.1); }
    th, td { padding: 10px; text-align: center; }
    th { background-color: #6c63ff; color: white; }
    tr:nth-child(even) { background: #f2f2f2; }
    .importante { text-decoration: none; font-weight: bold; }
    .filtro { margin-bottom: 1rem; display: flex; gap: 10px; align-items: center; }
    .btn { padding: 5px 10px; font-size: 0.85rem; }
  </style>
</head>
<body class="container py-4">

<h1>Panel de Administración de Mensajes</h1>
<a href="../../VIEW/Admin.php" class="btn-volver">← Volver</a>

<div class="filtro">
<form method="get" class="d-flex gap-2">
    <select name="filtro">
        <option value="">Todos los mensajes</option>
        <option value="importantes" <?= isset($_GET['filtro']) && $_GET['filtro'] === 'importantes' ? 'selected' : '' ?>>Leídos</option>
        <option value="no_leidos" <?= isset($_GET['filtro']) && $_GET['filtro'] === 'no_leidos' ? 'selected' : '' ?>>No leídos</option>
    </select>
    <button class="btn btn-primary">Filtrar</button>
</form>
</div>

<h2>Lista de Mensajes</h2>
<table>
  <thead>
    <tr>
      <th>Nombre</th>
      <th>Email</th>
      <th>Mensaje</th>
      <th>Fecha</th>
      <th>Acciones</th>
    </tr>
  </thead>
  <tbody>
    <?php if($res && $res->num_rows > 0): ?>
        <?php while($fila = $res->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($fila["nombre"]) ?></td>
          <td><?= htmlspecialchars($fila["email"]) ?></td>
          <td><?= htmlspecialchars($fila["mensaje"]) ?></td>
          <td><?= htmlspecialchars($fila["fecha"]) ?></td>
          <td class="acciones">
            <a href="?eliminar=<?= $fila['id'] ?>" onclick="return confirm('¿Eliminar este mensaje?')">🗑️ Eliminar</a>
            <a href="?toggle=<?= $fila['id'] ?>" class="importante">
              <?= $fila['importante'] ? "⭐ Leído" : "☆ No leído" ?>
            </a>
          </td>
        </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="5">No hay mensajes registrados.</td>
        </tr>
    <?php endif; ?>
  </tbody>
</table>

</body>
</html>

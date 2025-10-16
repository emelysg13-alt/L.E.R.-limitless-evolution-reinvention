<?php
include '../ASSETS/PHP/conexion.php';

// --- Eliminar mensaje ---
if (isset($_POST['delete_id'])) {
    $id = intval($_POST['delete_id']);
    $stmt = $conn->prepare("DELETE FROM loopy WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// --- Marcar / desmarcar importante ---
if (isset($_POST['toggle_id'])) {
    $id = intval($_POST['toggle_id']);
    $stmt = $conn->prepare("SELECT importante FROM loopy WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $nuevo_valor = $row['importante'] ? 0 : 1;
        $stmt_update = $conn->prepare("UPDATE loopy SET importante = ? WHERE id = ?");
        $stmt_update->bind_param("ii", $nuevo_valor, $id);
        $stmt_update->execute();
        $stmt_update->close();
    }
    $stmt->close();

    // REDIRECCIONAR para evitar que se pierda el cambio al recargar
    header("Location: ".$_SERVER['REQUEST_URI']);
    exit();
}

// --- Filtrar mensajes importantes ---
$filtro_sql = isset($_GET['filtro']) && $_GET['filtro'] === 'importantes' ? "AND importante = 1" : "";

// --- Obtener todos los mensajes (más recientes primero) ---
$res = $conn->query("SELECT * FROM loopy WHERE autor IN ('usuario','loopy') $filtro_sql ORDER BY fecha DESC");

// --- Agrupar mensajes por usuario y almacenar la última fecha de mensaje ---
$mensajes_por_usuario = [];
$ultima_fecha_por_usuario = [];

while ($row = $res->fetch_assoc()) {
    $usuario = $row['nombre'] ?: 'Usuario';
    $mensajes_por_usuario[$usuario][] = $row;

    // Guardamos la fecha del último mensaje
    if (!isset($ultima_fecha_por_usuario[$usuario]) || strtotime($row['fecha']) > strtotime($ultima_fecha_por_usuario[$usuario])) {
        $ultima_fecha_por_usuario[$usuario] = $row['fecha'];
    }
}

// --- Ordenar usuarios por el último mensaje (más reciente primero) ---
uasort($mensajes_por_usuario, function($a, $b) {
    $fecha_a = strtotime(end($a)['fecha']);
    $fecha_b = strtotime(end($b)['fecha']);
    return $fecha_b <=> $fecha_a; // Descendente
});
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Historial Chat - Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { background: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
h3 { font-weight: 600; margin-bottom: 1rem; }
.btn-volver { margin-bottom: 1rem; background-color: #6c63ff; color: white; border: none; transition: 0.3s; }
.btn-volver:hover { background-color: #5548e8; }
.table { background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 0 8px rgba(0,0,0,0.1); }
.table-warning { background-color: #fff3cd !important; border-left: 5px solid #ffcc00; }
.table th { background-color: #6c63ff; color: white; text-align: center; }
.btn { font-size: 0.85rem; }
.filtro { margin-bottom: 1rem; display: flex; justify-content: space-between; align-items: center; }
.mensaje { margin-bottom: 0.5rem; }
</style>
</head>
<body class="container py-4">

<a href="../VIEW/Admin.php" class="btn btn-volver">⬅ Volver</a>
<h3>Historial de Conversación con Loopy</h3>

<div class="filtro">
<form method="get" class="d-flex gap-2">
<select name="filtro" class="form-select form-select-sm w-auto">
<option value="">Todos los mensajes</option>
<option value="importantes" <?= isset($_GET['filtro']) && $_GET['filtro'] === 'importantes' ? 'selected' : '' ?>>Solo importantes</option>
</select>
<button class="btn btn-sm btn-primary">Filtrar</button>
</form>
</div>

<?php foreach ($mensajes_por_usuario as $usuario => $mensajes): ?>
<h5><?= htmlspecialchars($usuario) ?></h5>
<table class="table table-bordered align-middle mb-4">
<thead>
<tr>
<th>Fecha</th>
<th>Mensaje</th>
<th>Acciones</th>
</tr>
</thead>
<tbody>
<?php foreach ($mensajes as $row): ?>
<tr<?= $row['importante'] ? ' class="table-warning"' : '' ?>>
<td style="white-space: nowrap;"><?= $row['fecha'] ?></td>
<td>
<div class="d-flex align-items-start gap-2 mensaje">
<span class="fw-bold">
<?= ($row['autor']==='loopy') ? '🤖 Loopy' : '👤 ' . htmlspecialchars($row['nombre'] ?: 'Usuario') ?>
</span>
<div><?= nl2br(htmlspecialchars($row['mensaje'])) ?></div>
</div>
</td>
<td class="d-flex flex-wrap gap-1 justify-content-center">
<form method="post" class="d-inline">
<input type="hidden" name="toggle_id" value="<?= $row['id'] ?>">
<button class="btn btn-sm <?= $row['importante'] ? 'btn-warning' : 'btn-outline-warning' ?>">
<?= $row['importante'] ? '★ Quitar' : '☆ Marcar' ?>
</button>
</form>
<form method="post" class="d-inline">
<input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
<button class="btn btn-sm btn-danger">Eliminar</button>
</form>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<?php endforeach; ?>

</body>
</html>

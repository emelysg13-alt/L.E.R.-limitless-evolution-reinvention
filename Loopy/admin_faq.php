<?php
include '../ASSETS/PHP/conexion.php';

// 🟢 Insertar nueva FAQ
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['nueva'])) {
    $stmt = $conn->prepare("INSERT INTO faq (pregunta_clave, respuesta, palabras_clave, categoria, confianza) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $_POST['pregunta'], $_POST['respuesta'], $_POST['palabras'], $_POST['categoria'], $_POST['confianza']);
    $stmt->execute();
}

// 🟠 Eliminar
if (isset($_GET['eliminar'])) {
    $conn->query("DELETE FROM faq WHERE id=" . intval($_GET['eliminar']));
}

// 🔵 Editar
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['editar'])) {
    $stmt = $conn->prepare("UPDATE faq SET pregunta_clave=?, respuesta=?, palabras_clave=?, categoria=?, confianza=? WHERE id=?");
    $stmt->bind_param("ssssii", $_POST['pregunta'], $_POST['respuesta'], $_POST['palabras'], $_POST['categoria'], $_POST['confianza'], $_POST['id']);
    $stmt->execute();
}

// 🔍 Traer FAQs
$faqs = $conn->query("SELECT * FROM faq ORDER BY id DESC");

// 🧠 ¿Editar una fila específica?
$modoEditar = isset($_GET['edit']);
$faqEditar = null;
if ($modoEditar) {
    $idEditar = intval($_GET['edit']);
    $faqEditar = $conn->query("SELECT * FROM faq WHERE id = $idEditar")->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Admin FAQ</title>
    <link rel="stylesheet" href="style.css">
    <style> /* General */
body {
    background-color: #f8f9fa;
    font-family: 'Segoe UI', sans-serif;
    margin: 0;
    padding: 0;
}

.panel {
    max-width: 1000px;
    margin: 40px auto;
    background: #fff;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

h1, h2 {
    color: #333;
    margin-bottom: 20px;
}

h1 {
    font-size: 2rem;
    display: flex;
    align-items: center;
    gap: 10px;
}

/* Botón Volver */
.btn-volver {
    display: inline-block;
    margin-bottom: 20px;
    padding: 8px 15px;
    background-color: #6c63ff;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    transition: background 0.3s;
}

.btn-volver:hover {
    background-color: #5548e8;
}

/* Formulario */
form {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-bottom: 30px;
}

form input[type="text"],
form input[type="number"],
form textarea {
    padding: 8px 12px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 0.95rem;
    width: 100%;
}

form textarea {
    resize: vertical;
    min-height: 80px;
}

form button {
    padding: 10px 15px;
    background-color: #6c63ff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
    transition: background 0.3s;
}

form button:hover {
    background-color: #5548e8;
}

form a {
    text-decoration: none;
    color: #ff4c4c;
    font-weight: bold;
}

/* Tabla */
table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

table th, table td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: center;
    font-size: 0.9rem;
}

table th {
    background-color: #6c63ff;
    color: white;
}

table tr:nth-child(even) {
    background-color: #f2f2f2;
}

table a {
    text-decoration: none;
    color: #6c63ff;
    font-weight: bold;
    transition: color 0.2s;
}

table a:hover {
    color: #333;
}

/* Resaltar fila de edición */
tr.editing {
    background-color: #fff7e6;
}
</style>
</head>
<body>
<div class="panel">
    <h1>🛠️ Panel de Administración de FAQs</h1>

    <a href="../VIEW/Admin.php" class="btn-volver">← Volver</a>


    <!-- FORMULARIO AGREGAR O EDITAR -->
    <form method="POST">
        <h2><?= $modoEditar ? "✏️ Editar respuesta existente" : "➕ Nueva pregunta frecuente" ?></h2>

        <input type="hidden" name="id" value="<?= $modoEditar ? $faqEditar['id'] : '' ?>">

        <input type="text" name="pregunta" placeholder="Palabra clave principal" value="<?= $modoEditar ? htmlspecialchars($faqEditar['pregunta_clave']) : '' ?>" required>

        <textarea name="respuesta" placeholder="Respuesta del bot" required><?= $modoEditar ? htmlspecialchars($faqEditar['respuesta']) : '' ?></textarea>

        <input type="text" name="palabras" placeholder="Otras palabras clave (coma)" value="<?= $modoEditar ? htmlspecialchars($faqEditar['palabras_clave']) : '' ?>">

        <input type="text" name="categoria" placeholder="Categoría (opcional)" value="<?= $modoEditar ? htmlspecialchars($faqEditar['categoria']) : '' ?>">

        <input type="number" name="confianza" placeholder="Confianza (1-5)" value="<?= $modoEditar ? $faqEditar['confianza'] : 3 ?>">

        <button type="submit" name="<?= $modoEditar ? 'editar' : 'nueva' ?>">
            <?= $modoEditar ? '💾 Guardar cambios' : 'Agregar' ?>
        </button>
        <?php if ($modoEditar): ?>
            <a href="admin_faq.php" style="margin-left: 10px;">❌ Cancelar</a>
        <?php endif; ?>
    </form>

    <!-- TABLA -->
    <h2>📋 Preguntas actuales</h2>
    <table>
        <tr>
            <th>ID</th><th>Clave</th><th>Respuesta</th><th>Palabras clave</th><th>Categoría</th><th>Confianza</th><th>Acción</th>
        </tr>
        <?php while ($row = $faqs->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['pregunta_clave']) ?></td>
                <td><?= htmlspecialchars($row['respuesta']) ?></td>
                <td><?= $row['palabras_clave'] ?></td>
                <td><?= $row['categoria'] ?></td>
                <td><?= $row['confianza'] ?></td>
                <td>
                    <a href="?edit=<?= $row['id'] ?>">✏️ Editar</a> |
                    <a href="?eliminar=<?= $row['id'] ?>" onclick="return confirm('¿Eliminar esta pregunta?')">❌ Eliminar</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>

<?php
ob_start(); // Captura cualquier salida accidental
session_start();
include("conexion.php");
require_once("../TCPDF/tcpdf.php");

date_default_timezone_set('America/Bogota');

if (!isset($_SESSION['cliente'])) die("Debes iniciar sesión.");

$nombre = $_SESSION['cliente'];

// Obtener usuario
$stmt = $conn->prepare("SELECT id FROM usuarios WHERE nombre = ? LIMIT 1");
$stmt->bind_param("s", $nombre);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) die("Usuario no encontrado.");
$user = $result->fetch_assoc();
$user_id = $user['id'];
$stmt->close();

// Obtener carrito
$stmt = $conn->prepare("
    SELECT a.nombre, a.precio, c.cantidad
    FROM carrito c
    JOIN articulos a ON c.producto_id = a.id
    WHERE c.user_id = ?
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$carrito = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Crear PDF con márgenes
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetMargins(15, 20, 15);
$pdf->SetAutoPageBreak(true, 20);
$pdf->AddPage();

// Título
$pdf->SetFont('dejavusans', 'B', 16);
$pdf->Cell(0, 10, 'Factura / Cotización - LerXport', 0, 1, 'C');
$pdf->Ln(5);

// Datos del cliente
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(0, 6, "Cliente: $nombre", 0, 1);
$pdf->Cell(0, 6, "Fecha: " . date('d/m/Y H:i'), 0, 1);
$pdf->Ln(5);



// Contacto en la misma línea (a la derecha)
$pdf->SetFont('helvetica', 'I', 11);
$pdf->Cell(0, 6, 'Contacto: ler.projectx@gmail.com', 0, 1, 'R');
$pdf->Ln(5);


// Tabla productos
$html = '<table border="1" cellpadding="6" cellspacing="0">
<tr style="background-color:#f2f2f2;">
<th><b>Producto</b></th>
<th><b>Precio (COP)</b></th>
<th><b>Cantidad</b></th>
<th><b>Subtotal (COP)</b></th>
</tr>';

$total = 0;
foreach ($carrito as $item) {
    $subtotal = $item['precio'] * $item['cantidad'];
    $total += $subtotal;
    $html .= '<tr>
        <td>' . htmlspecialchars($item['nombre']) . '</td>
        <td>' . number_format($item['precio'], 0) . '</td>
        <td>' . $item['cantidad'] . '</td>
        <td>' . number_format($subtotal, 0) . '</td>
    </tr>';
}

$html .= '</table>';
$pdf->writeHTML($html, true, false, true, false, '');

// Total
$pdf->Ln(5);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 8, 'Total: ' . number_format($total, 0) . ' COP', 0, 1, 'R');

// Logo al final
$logo_path = '../IMG/Logo.jpg';
if(file_exists($logo_path)){
    $pdf->Ln(15); // espacio antes del logo
    $pdf->Image($logo_path, '', null, 50, '', '', '', '', 'C'); // ancho 50, centrado
}







$nombre = $_SESSION['cliente'];// O la forma en que identifiques al usuario


$totalFactura = $total;

$productos = json_encode($carrito); // ✅ convertir carrito a JSON
$stmt = $conn->prepare("INSERT INTO cotizaciones (id_usuario, productos, fecha, total) VALUES (?, ?, NOW(), ?)");
$stmt->bind_param("isd", $user_id, $productos, $totalFactura);
$stmt->execute();
$stmt->close();

// Descargar PDF
$pdf->Output('factura_'.$nombre.'_'.date('YmdHis').'.pdf', 'D');

ob_end_flush();
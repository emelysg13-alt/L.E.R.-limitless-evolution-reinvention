<?php

session_start();
include '../ASSETS/PHP/conexion.php';

function quitarTildes($cadena) {
    $originales = ['á', 'é', 'í', 'ó', 'ú', 'ñ'];
    $sinTildes  = ['a', 'e', 'i', 'o', 'u', 'n'];
    return str_replace($originales, $sinTildes, $cadena);
}

function singularizar($palabra) {
    if (substr($palabra, -2) == 'es') {
        return substr($palabra, 0, -2);
    } elseif (substr($palabra, -1) == 's') {
        return substr($palabra, 0, -1);
    }
    return $palabra;
}



$respuesta = "";
$mensajeUsuario = "";



if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["mensaje"])) {
    $mensajeOriginal = trim($_POST["mensaje"]);
    $mensaje = quitarTildes(strtolower($mensajeOriginal));
    $cliente = $_SESSION["cliente"] ?? "Usuario";

    if (!isset($_SESSION["estado"])) {
        $_SESSION["estado"] = null;
    } }

    $sql = "SELECT * FROM faq ORDER BY confianza DESC";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        $palabras = array_map('trim', explode(',', quitarTildes(strtolower($row['palabras_clave']))));
        array_push($palabras, quitarTildes(strtolower($row['pregunta_clave'])));

        foreach ($palabras as $palabra) {
            if (strpos($mensaje, $palabra) !== false) {
                $respuesta = $row['respuesta'];
                break 2;
            }
        }
    }

 

    


    // 2. Atención al cliente
    // 🟨 Flujo de edición de datos
    if (strpos($mensaje, 'editar#usuario') !== false) {
        $respuesta = "✏️ Por favor escribe tu nombre completo, correo y qué deseas editar. Lo enviaremos al administrador.";
        $_SESSION["estado"] = "esperando_datos_edicion";
    }

    // 🟨 Si el usuario responde con datos de edición
    elseif ($_SESSION["estado"] === "esperando_datos_edicion") {
        $respuesta = "✅ Gracias. Tu solicitud ha sido registrada y será revisada por el administrador.";
        $_SESSION["estado"] = null;
    }


 // 1. Atención al cliente
if (empty($respuesta)) {
    $atencion = ['atencion', 'editar', 'cliente', 'contacto', 'ayuda', 'dato'];
    foreach ($atencion as $palabra) {
        if (strpos($mensaje, $palabra) !== false) {
            $respuesta = "✉️ ¿Buscas atención al cliente?<br>
            <button onclick=\"enviarMensaje('editar#usuario')\" style=\"
                background-color: #5c6bc0; 
                color: white; 
                border: none; 
                padding: 8px 16px; 
                border-radius: 5px; 
                cursor: pointer;
                font-size: 14px;
                transition: background-color 0.3s;
            \" 
            onmouseover=\"this.style.backgroundColor='#3f51b5'\" 
            onmouseout=\"this.style.backgroundColor='#5c6bc0'\">✏️ Editar mis datos</button><br>
            <a href='./VIEW/Contacto.php' target='_blank' style=\"
                display: inline-block;
                background-color: #29b6f6;
                color: white;
                padding: 8px 16px;
                border-radius: 5px;
                text-decoration: none;
                font-size: 14px;
                transition: background-color 0.3s;
            \" 
            onmouseover=\"this.style.backgroundColor='#039be5'\" 
            onmouseout=\"this.style.backgroundColor='#29b6f6'\">📨 Contactar</a>";
            break;
        }
    }
}




 


// 3. Mostrar el catálogo si pregunta
if (empty($respuesta)) {
    $catalogo = ['catalogo', 'producto', 'ver todo', 'articulo'];
    foreach ($catalogo as $palabra) {
        if (strpos($mensaje, $palabra) !== false) {
            $respuesta = "🔍 Aquí puedes ver nuestro catálogo completo:<br>
            <a href='./VIEW/Catalogo.php' target='_blank' style=\"
                display: inline-block;
                background-color: #1e88e5;
                color: white;
                padding: 6px 12px;
                border-radius: 5px;
                text-decoration: none;
                font-size: 14px;
                transition: background-color 0.3s;
            \" 
            onmouseover=\"this.style.backgroundColor='#1565c0'\" 
            onmouseout=\"this.style.backgroundColor='#1e88e5'\">🏷️ Ver catálogo</a>";
            break;
        }
    }
}



// 4. Mostrar el Manual
if (empty($respuesta)) {
    $manual = ['manual', 'instruccion', 'manual de usuario'];
    foreach ($manual as $palabra) {
        if (strpos($mensaje, $palabra) !== false) {
            $respuesta = "📘 Aquí puedes ver nuestro Manual de Usuario:<br>
            <a href='https://drive.google.com/drive/folders/18dKQ-4mSSE2N1zTS0q2xWs0cHjUOr3ke?usp=sharing' target='_blank' style=\"
                display: inline-block;
                background-color: #1e88e5;
                color: white;
                padding: 6px 12px;
                border-radius: 5px;
                text-decoration: none;
                font-size: 14px;
                transition: background-color 0.3s;
            \" 
            onmouseover=\"this.style.backgroundColor='#1565c0'\" 
            onmouseout=\"this.style.backgroundColor='#1e88e5'\">🗂️ Ver Manual de Usuario</a>";
            break;
        }
    }
}

// 5 cotizaciones

if(empty($respuesta)) {
$cotiz = ['cotizacion', 'generar', 'factura', 'carrito'];
foreach ($cotiz as $palabra) {
 if (strpos($mensaje, $palabra) !== false) {
            $respuesta = "Para generar una cotización,
             selecciona los productos que deseas y haz clic en 'Descargar factura / cotización PDF'.<br>
             Es muy sencillo, intentalo! <br>
            <a href='./VIEW/Carrito.php' target='_blank' style=\"
                display: inline-block;
                background-color: #1e88e5;
                color: white;
                padding: 6px 12px;
                border-radius: 5px;
                text-decoration: none;
                font-size: 14px;
                transition: background-color 0.3s;
            \" 
            onmouseover=\"this.style.backgroundColor='#1565c0'\" 
            onmouseout=\"this.style.backgroundColor='#1e88e5'\">🛒 Carrito</a>";
            break;
        }
    }
}




// 6.2
    //  Flujo de Nutricion
    if (strpos($mensaje, 'nutricion#dep') !== false) {
    $respuesta = "<br><br><strong> 🧠 Conocimientos breves: </strong> <br><br>
    <ul style='list-style-type: disc; margin-left: 20px;'>

<li>La nutrición deportiva da energía y ayuda a recuperarte.</li>

<li>Los carbohidratos dan fuerza, las proteínas reparan músculo, y las grasas saludables mantienen equilibrio.</li>

<li>El agua es clave para el rendimiento.</li> </ul><br>

<strong>💡 Tips: </strong> <br><br>
 <ul style='list-style-type: disc; margin-left: 20px;'>
<li>Come 2 h antes de entrenar algo con carbohidratos y proteína.</li>

<li>Bebe agua antes, durante y después del ejercicio.</li>

<li>Después de entrenar, combina proteína + carbohidrato.</li>
<li>No elimines todas las grasas, el cuerpo las necesita.</li>

<li>Evita copiar dietas, cada cuerpo es distinto.</li> </ul>
";
} 
   //Flujo de entrenamiento

    if (strpos($mensaje, 'entrenamiento#fisc') !== false) {
    $respuesta = "<br><br><strong> 🧠 Conocimientos breves: </strong> <br><br>
    <ul style='list-style-type: disc; margin-left: 20px;'>

<li>El entrenamiento mejora fuerza, resistencia y flexibilidad.</li>

<li>El progreso depende de la constancia y el descanso.</li>

<li>Calentar y estirar evita lesiones.</li> </ul><br>

<strong>💡 Tips: </strong> <br><br>
 <ul style='list-style-type: disc; margin-left: 20px;'>
<li>Calienta 5–10 min antes de entrenar.</li>

<li>Usa buena técnica más que peso.</li>

<li>Descansa si hay dolor o cansancio.</li>
<li>Haz movilidad antes y después.</li>

<li>Registra tus progresos.</li> </ul>
";
}

// Flujo de Salud

 if (strpos($mensaje, 'salud#recup') !== false) {
    $respuesta = "<br><br><strong> 🧠 Conocimientos breves: </strong> <br><br>
    <ul style='list-style-type: disc; margin-left: 20px;'>

<li>Dormir y descansar son parte del entrenamiento.</li>

<li>El estrés o sobreesfuerzo afectan el cuerpo.</li>

<li>Escuchar tu cuerpo evita lesiones.</li> </ul><br>

<strong>💡 Tips: </strong> <br><br>
 <ul style='list-style-type: disc; margin-left: 20px;'>
<li>Duerme 7–8 horas diarias.</li>

<li>Haz pausas activas y estira.</li>

<li>No ignores el dolor articular.</li>
<li>Relájate con respiración o meditación.</li>

<li>Si estás muy cansado, descansa.</li> </ul>
";
}


// 6 Tips

if(empty($respuesta)) {
$tips = ['tip', 'consejo', 'conocimiento', 'nutricion', 'salud', 'entrenamiento', 'fisico', 'deportiva'];
foreach ($tips as $palabra) {
 if (strpos($mensaje, $palabra) !== false) {
            $respuesta = "Ohh quieres recibir tips, eso es increible! <br> ¿Sobre qué tema quieres aprender? <br><br>
           <button onclick=\"enviarMensaje('nutricion#dep')\" style=\"
                background-color: #5c6bc0; 
                color: white; 
                border: none; 
                padding: 8px 16px; 
                border-radius: 5px; 
                cursor: pointer;
                font-size: 14px;
                transition: background-color 0.3s;
            \" 
            onmouseover=\"this.style.backgroundColor='#3f51b5'\" 
            onmouseout=\"this.style.backgroundColor='#5c6bc0'\">Nutrición deportiva 🍎</button><br><br>
            <button onclick=\"enviarMensaje('entrenamiento#fisc')\" style=\"
                background-color: #5c6bc0; 
                color: white; 
                border: none; 
                padding: 8px 16px; 
                border-radius: 5px; 
                cursor: pointer;
                font-size: 14px;
                transition: background-color 0.3s;
            \" 
            onmouseover=\"this.style.backgroundColor='#3f51b5'\" 
            onmouseout=\"this.style.backgroundColor='#5c6bc0'\">Entrenamiento físico 🏋️</button><br><br>
            <button onclick=\"enviarMensaje('salud#recup')\" style=\"
                background-color: #5c6bc0; 
                color: white; 
                border: none; 
                padding: 8px 16px; 
                border-radius: 5px; 
                cursor: pointer;
                font-size: 14px;
                transition: background-color 0.3s;
            \" 
            onmouseover=\"this.style.backgroundColor='#3f51b5'\" 
            onmouseout=\"this.style.backgroundColor='#5c6bc0'\">Salud y recuperación ❤️</button><br>" ;
            break;
        }
    }
}











    // 9. Mostrar detalle del artículo al hacer clic en “Este”
    if (empty($respuesta) && strpos($mensaje, 'este#') === 0) {
        $id = intval(substr($mensaje, 5));
        $stmt = $conn->prepare("SELECT nombre, categoria, enlace_externo FROM articulos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $nombre = $row["nombre"];
            $categoria = $row["categoria"];
            $enlace = $row["enlace_externo"];
            $respuesta = "📦 El artículo <strong>$nombre</strong> está en la categoría 
            <span style='color:#1e88e5; font-weight:bold;'>$categoria</span>.<br><br>
            👉 <a href='$enlace' target='_blank'>Ver producto</a><br>
            🏷️ <a href='./VIEW/Catalogo.php' target='_blank'>Ver catálogo</a>";
        } else {
            $respuesta = "❌ No encontré ese artículo.";
        }
    }

    // 8. Confirmación de búsqueda de productos
if ($_SESSION["estado"] === "confirmar_busqueda" && strpos($mensaje, 'si') !== false) {
    $_SESSION["estado"] = null;
    $palabras = $_SESSION["palabras"];
    $sql = "SELECT id, nombre, descripcion FROM articulos";  // Nota: Aunque seleccionas 'descripcion', no la usaremos en la búsqueda
    $result = $conn->query($sql);

    $relacionados = [];
    while ($row = $result->fetch_assoc()) {
        
        $texto = quitarTildes(strtolower($row['nombre']));
        foreach ($palabras as $palabra) {
            if (mb_stripos($texto, $palabra) !== false) {
                $relacionados[] = $row;
                break;
            }
        }
    }

    if (count($relacionados) > 0) {
        $respuesta = "🔍 ¿Te refieres a uno de estos artículos?<br>";
        foreach ($relacionados as $art) {
            $respuesta .= "<div style='margin-bottom: 6px; padding: 4px;'>";
            $respuesta .= "• " . $art["nombre"];
            $respuesta .= " <button onclick=\"enviarMensaje('este#" . $art["id"] . "')\">Este</button>";
            $respuesta .= "</div>";
        }
    } else {
        $respuesta = "😕 No encontré artículos relacionados. Intenta con otra palabra.";
    }
}

    // 7. Detectar intención de producto (preguntar primero)
    if (empty($respuesta)) {
    $palabras = preg_split('/[\s,\.\?¿¡!]+/', $mensaje);
    $palabrasFiltradas = array_filter($palabras, fn($w) => strlen($w) >= 3);
       $palabrasFiltradas = array_map('singularizar', $palabrasFiltradas);

    if (!empty($palabrasFiltradas)) {
        $sql = "SELECT COUNT(*) as total FROM articulos WHERE ";
        $condiciones = [];
        $params = [];
        $types = '';

        foreach ($palabrasFiltradas as $palabra) {
            $condiciones[] = "nombre LIKE ?";
            $params[] = "%$palabra%";
            $types .= 's';
        }

        $sql .= implode(" OR ", $condiciones);

        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param($types, ...$params);
           $stmt->execute();
$result = $stmt->get_result();
if ($result) {
    $row = $result->fetch_assoc();
    if ($row && $row['total'] > 0) {
        $_SESSION["estado"] = "confirmar_busqueda";
        $_SESSION["palabras"] = $palabrasFiltradas;
        $respuesta = '¿Quieres que busque productos relacionados?<br>
        <button onclick="enviarMensaje(\'sí buscar\')">Sí, buscar</button>';
    }
}
$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result) {
        $row = $result->fetch_assoc();
        if ($row && $row['total'] > 0) {
            $_SESSION["estado"] = "confirmar_busqueda";
            $_SESSION["palabras"] = $palabrasFiltradas;
            $respuesta = '¿Quieres que busque productos relacionados?<br>
            <button onclick="enviarMensaje(\'sí buscar\')" style="
                background-color: #5c6bc0;
                color: white;
                border: none;
                padding: 8px 16px;
                border-radius: 5px;
                cursor: pointer;
                font-size: 14px;
                transition: background-color 0.3s;
            "
            onmouseover="this.style.backgroundColor=\'#3f51b5\'"
            onmouseout="this.style.backgroundColor=\'#5c6bc0\'">✅ Sí, buscar</button>';
        }
    }
}





        } else {
            $respuesta = "⚠️ Error SQL: " . $conn->error;
        }
    } else {
        $respuesta = "🔎 Escribe un poco más para poder ayudarte a buscar productos.";
    }
}
    


    if (empty($respuesta)) {
        $respuesta = "😕 No entendí lo que querías decir. Intenta con otra palabra o revisa el catálogo.";
    }

    $stmt = $conn->prepare("INSERT INTO loopy (nombre, mensaje, autor) VALUES (?, ?, 'usuario')");
    $stmt->bind_param("ss", $cliente, $mensajeOriginal);
    $stmt->execute();

    $stmt = $conn->prepare("INSERT INTO loopy (nombre, mensaje, autor, destinatario) VALUES (?, ?, 'loopy', ?)");
    $stmt->bind_param("sss", $cliente, $respuesta, $cliente);
    $stmt->execute();

    $conn->close();
    echo $respuesta;

?>
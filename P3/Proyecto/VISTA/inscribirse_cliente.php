<?php
include "../MODELO/conexion.php";
// Inicializar variables
$nombre_evento = "";
$precio_evento = 0.0;
$nombre_cliente = "";
$apellido_cliente = "";

// Verificar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recuperar y sanitizar datos del formulario
    $id_evento = (int)$_POST['id_evento'];
    $id_cliente = (int)$_POST['id_cliente'];
    $fecha_inscripcion = $_POST['fecha_inscripcion'];
    $precio_evento = (float)$_POST['precio_evento'];
    $pago_abono = (float)$_POST['pago_abono'];
    $estado_pago = $_POST['estado_pago'];
    $notificacion = $_POST['notificacion'];
    $forma_pago = $_POST['forma_pago'];

    // Validar campos necesarios
    if (empty($fecha_inscripcion) || $precio_evento <= 0 || $pago_abono < 0) {
        echo "<script>alert('Por favor, complete todos los campos correctamente.');</script>";
    } else {
        // Preparar e insertar datos
        $stmt = $conn->prepare("INSERT INTO INSCRIBE (ID_EVENTO, ID_CLIENTE, FECHA_INSCRIPCION, PRECIO_EVENTO, PAGO_ABONO, ESTADO_PAGO, NOTIFICACION, FORMA_PAGO) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt === false) {
            die('Error en la preparación de la consulta: ' . $conn->error);
        }

        // Bind parameters
        $stmt->bind_param('iiddssss', $id_evento, $id_cliente, $fecha_inscripcion, $precio_evento, $pago_abono, $estado_pago, $notificacion, $forma_pago);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "<script>alert('Inscripción exitosa'); window.location.href = 'index.php';</script>";
        } else {
            echo "<script>alert('Error en la inscripción: " . $stmt->error . "');</script>";
        }

        // Cerrar la declaración
        $stmt->close();
    }
} else {
    // Recuperar el ID del evento y el ID del cliente desde la URL
    $id_evento = isset($_GET['id_evento']) ? (int)$_GET['id_evento'] : 0;
    $id_cliente = isset($_GET['id_cliente']) ? (int)$_GET['id_cliente'] : 0;

    // Obtener el nombre del evento y el precio del evento desde la base de datos
    if ($id_evento) {
        $stmt = $conn->prepare("SELECT NOMBRE, PRECIO_EVENTO FROM EVENTO WHERE ID_EVENTO = ?");
        $stmt->bind_param('i', $id_evento);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $nombre_evento = $row['NOMBRE'];
            $precio_evento = (float)$row['PRECIO_EVENTO'];
        }

        $stmt->close();
    }

    // Obtener el nombre y apellido del cliente
    if ($id_cliente) {
        $stmt = $conn->prepare("SELECT NOMBRE, APELLIDO FROM CLIENTE WHERE ID_CLIENTE = ?");
        $stmt->bind_param('i', $id_cliente);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $nombre_cliente = $row['NOMBRE'];
            $apellido_cliente = $row['APELLIDO'];
        }

        $stmt->close();
    }
}

// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscripción</title>
    <link rel="stylesheet" href="css/men_res.css">
</head>
<body>
<header class="header">
    <img class="logo" src="img/Logo_CONE.png" alt="Logo">
    <nav class="nav">
        <ul class="barnav" id="navbar">
            <li class="menu"><a href="index.php">Conferencia/Eventos</a></li>
            <li class="menu"><a href="quienes-somos.php">Quiénes somos</a></li>
            <li class="menu" id="menu-var">
                <a href="programar_eventos.php">Programación C|O|N|E</a>
            </li>
            <li class="menu"><a href="FAQ.php">FAQ</a></li>
        </ul>
        <div class="hamburger" id="hamburger" onclick="toggleMenu()">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
    </nav>
</header>

<script>
function toggleMenu() {
    var nav = document.getElementById('navbar');
    nav.classList.toggle('show');
}

function updatePaymentStatus() {
    var precioEvento = parseFloat(document.getElementById('precio_evento').value);
    var pagoAbono = parseFloat(document.getElementById('pago_abono').value);
    var estadoPago = document.getElementById('estado_pago');
    
    if (pagoAbono >= precioEvento) {
        estadoPago.value = 'Pagado';
    } else {
        estadoPago.value = 'Pendiente';
    }
}
</script>

<main>
    <h2 class="mensaje">Inscripción al evento <?php echo htmlspecialchars($nombre_evento); ?></h2>
    <h2 class="mensaje">Cliente: <?php echo htmlspecialchars($nombre_cliente) . ' ' . htmlspecialchars($apellido_cliente); ?></h2>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <input type="hidden" name="id_evento" value="<?php echo htmlspecialchars($id_evento); ?>">
        <input type="hidden" name="id_cliente" value="<?php echo htmlspecialchars($id_cliente); ?>">

        <label for="precio_evento">Precio del Evento:</label>
        <input type="number" id="precio_evento" name="precio_evento" step="0.01" value="<?php echo htmlspecialchars($precio_evento); ?>" readonly><br><br>

        <label for="fecha_inscripcion">Fecha Inscripción:</label>
        <input type="text" id="fecha_inscripcion" name="fecha_inscripcion" readonly><br><br>

        <label for="pago_abono">Cantidad a Abonar:</label>
        <input type="number" id="pago_abono" name="pago_abono" step="0.01" oninput="updatePaymentStatus()"><br><br>

        <label for="estado_pago" readonly>Estado de Pago:</label>
        <select id="estado_pago" name="estado_pago" required>
            <option value="Pendiente">Pendiente</option>
            <option value="Pagado">Pagado</option>
        </select><br><br>

        <label for="notificacion">Notificación:</label>
        <select id="notificacion" name="notificacion" required>
            <option value="Sí">Sí</option>
            <option value="No">No</option>
        </select><br><br>

        <label for="forma_pago">Forma de Pago:</label>
        <select id="forma_pago" name="forma_pago" required>
            <option value="Tarjeta">Tarjeta</option>
            <option value="Efectivo">Efectivo</option>
            <option value="Transferencia">Transferencia</option>
        </select><br><br>

        <input type="submit" value="Inscribirse">
    </form>
</main>

<script>
function obtenerFechaActual() {
    var today = new Date();
    var day = String(today.getDate()).padStart(2, '0');
    var month = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
    var year = today.getFullYear();

    var dateString = year + '-' + month + '-' + day;
    
    document.getElementById('fecha_inscripcion').value = dateString;
}

// Llamar a la función para que se ejecute cuando se cargue la página
window.onload = obtenerFechaActual;
</script>

<footer class="footer">
    <h3 class="suscribirse">Suscríbete</h3>
    <form action="suscripcion.php" method="post" class="form_sus">
        <input class="campo_sus" type="email" name="email" placeholder="Tu correo electrónico">
        <input class="btn_sus" type="submit" value="Suscribirse">
    </form>
</footer>
</body>
</html>

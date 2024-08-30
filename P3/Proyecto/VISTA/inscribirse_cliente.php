<?php
include "../MODELO/conexion.php";

// Inicializar variables
$nombre_evento = "";
$precio_evento = 0.0;
$nombre_cliente = "";
$apellido_cliente = "";

// Recuperar el ID del evento y el ID del cliente desde la URL
$id_evento = isset($_GET['id_evento']) ? (int)$_GET['id_evento'] : 0;
$id_cliente = isset($_GET['id_cliente']) ? (int)$_GET['id_cliente'] : 0;

if ($conn) {
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

    // Cerrar la conexión solo después de realizar todas las operaciones
    $conn->close();
} else {
    die("Error: No se pudo establecer la conexión con la base de datos.");
}

// Obtener la fecha actual
date_default_timezone_set('America/Mexico_City');
$fecha_actual = date("Y-m-d");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscripción</title>
    <link rel="stylesheet" href="css/men_res.css">
    <link rel="stylesheet" href="css/inscribirse_cliente.css">
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

    <form action="../CONTROLADOR/Inscribir_cliente.php" method="post">
        <input type="hidden" name="id_evento" value="<?php echo htmlspecialchars($id_evento); ?>">
        <input type="hidden" name="id_cliente" value="<?php echo htmlspecialchars($id_cliente); ?>">

        <label for="precio_evento">Precio del Evento:</label>
        <input type="number" id="precio_evento" name="precio_evento" step="0.01" value="<?php echo htmlspecialchars($precio_evento); ?>" readonly><br><br>

        <label for="fecha_inscripcion">Fecha Inscripción:</label>
        <input type="text" id="fecha_inscripcion" name="fecha_inscripcion" value="<?= $fecha_actual ?>" readonly><br><br>

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
        <input type="submit" name="Inscribirse" value="Inscribirse">
    </form>
</main>

<!-- Pie de página -->
<footer class="footer">
    <div class="footer-social-links">
        <h5 class="footer-heading">Follow @IEEE</h5>
        <ul class="footer-links">
            <li><a class="twitter" href="https://ieeemce.org/news/">Página oficial de IEEE</a></li>
        </ul>
    </div>

    <div class="footer-social-links">
        <h5 class="footer-heading">Follow @ESPE</h5>
        <ul class="footer-links">
            <li><a class="twitter" href="https://www.espe.edu.ec/">Página oficial de la ESPE</a></li>
        </ul>
    </div>
</footer>
<div class="row">
    <div class="col-md-6">
        <!-- Créditos -->
        <div class="sydney-credits">© Universidad de las Fuerzas Armadas ESPE <br> Todos los derechos reservados 2024</div>
    </div>
    <div class="col-md-6">
        <!-- Otro contenido si es necesario -->
    </div>
</div>

</section>
</body>
</html>

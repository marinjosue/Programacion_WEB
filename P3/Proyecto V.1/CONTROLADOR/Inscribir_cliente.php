<?php
include "../MODELO/conexion.php";

// Recuperar datos del formulario
$id_evento = $_POST['id_evento'];
$id_cliente = $_POST['id_cliente'];
$precio_evento = $_POST['precio_evento'];
$pago_abono = $_POST['pago_abono'];
$estado_pago = $_POST['estado_pago'];
$notificacion = $_POST['notificacion'];
$forma_pago = $_POST['forma_pago'];

// Obtener la fecha actual
$fecha_inscripcion = date('Y-m-d');

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO INSCRIBE (ID_EVENTO, ID_CLIENTE, FECHA_INSCRIPCION, PRECIO_EVENTO, PAGO_ABONO, ESTADO_PAGO, NOTIFICACION, FORMA_PAGO) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
if ($stmt === false) {
    die('Error en la preparación de la consulta: ' . $conn->error);
}

// Bind parameters
$stmt->bind_param('iiddssss', $id_evento, $id_cliente, $precio_evento, $pago_abono, $estado_pago, $notificacion, $forma_pago);

// Ejecutar la consulta
if ($stmt->execute()) {
    echo "<script>alert('Inscripción exitosa'); window.location.href = '../VISTA/index.php';</script>";
} else {
    echo "<script>alert('Error en la inscripción: " . $stmt->error . "');</script>";
}

// Cerrar la declaración y la conexión
$stmt->close();
$conn->close();
?>

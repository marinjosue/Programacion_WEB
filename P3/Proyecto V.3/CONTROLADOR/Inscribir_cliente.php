<?php
include "../MODELO/conexion.php";

if(isset($_REQUEST['Inscribirse'])){
    // Recuperar y sanitizar datos del formulario
    $id_evento = isset($_POST['id_evento']) ? (int)$_POST['id_evento'] : 0;
    $id_cliente = isset($_POST['id_cliente']) ? (int)$_POST['id_cliente'] : 0;
    $fecha_inscripcion = isset($_POST['fecha_inscripcion']) ? $_POST['fecha_inscripcion'] : '';
    $precio_evento = isset($_POST['precio_evento']) ? (float)$_POST['precio_evento'] : 0.0;
    $pago_abono = isset($_POST['pago_abono']) ? (float)$_POST['pago_abono'] : 0.0;
    $estado_pago = isset($_POST['estado_pago']) ? $_POST['estado_pago'] : '';
    $notificacion = isset($_POST['notificacion']) ? $_POST['notificacion'] : '';
    $forma_pago = isset($_POST['forma_pago']) ? $_POST['forma_pago'] : '';

    // Validar campos necesarios
    if (empty($fecha_inscripcion) || $precio_evento <= 0 || $pago_abono < 0) {
        echo "<script>alert('Por favor, complete todos los campos correctamente.');</script>";
    } else {
        // Verificar si ya existe la inscripción
        $check_stmt = $conn->prepare("SELECT * FROM INSCRIBE WHERE ID_EVENTO = ? AND ID_CLIENTE = ?");
        if ($check_stmt === false) {
            die('Error en la preparación de la consulta: ' . $conn->error);
        }

        $check_stmt->bind_param('ii', $id_evento, $id_cliente);
        $check_stmt->execute();
        $result = $check_stmt->get_result();

        if ($result->num_rows > 0) {
            // El cliente ya está inscrito en el evento
            echo "<script>alert('Usted ya está inscrito en este evento.'); window.location.href = '../VISTA/inscribirse_cliente.php';</script>";
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
                echo "<script>alert('Inscripción exitosa'); window.location.href = '../VISTA/index.php';</script>";
            } else {
                echo "<script>alert('Error en la inscripción: " . $stmt->error . "');</script>";
            }

            // Cerrar la declaración
            $stmt->close();
        }

        // Cerrar la consulta de verificación
        $check_stmt->close();
    }
}
// Cerrar la conexión
$conn->close();
?>

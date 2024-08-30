<?php
include "../MODELO/conexion.php";

// Obtener los datos del formulario
$id_evento = $_POST['id_evento'];
$id_cliente = $_POST['id_cliente'];
$abono = $_POST['abono'];

// Consulta para actualizar el abono
$sql = $conn->prepare("
    UPDATE INSCRIBE 
    SET PAGO_ABONO = PAGO_ABONO + ? 
    WHERE ID_EVENTO = ? AND ID_CLIENTE = ?
");

// Enlazar parámetros
$sql->bind_param('iii', $abono, $id_evento, $id_cliente);

// Ejecutar consulta
if ($sql->execute()) {
    // Redireccionar a la página de eventos después de actualizar
    header("Location: ../VISTA/eventos_clientes.php?id_cliente=" . $id_cliente);
    exit();
} else {
    // Manejar error si la consulta falla
    echo "Error al actualizar el abono: " . $sql->error;
}

// Cerrar la conexión
$sql->close();
$conexion->close();
?>

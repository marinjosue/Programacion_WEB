<?php
include "../MODELO/conexion.php";

// Obtener los datos de la URL
$id_evento = $_GET['id_evento'];
$id_cliente = $_GET['id_cliente'];

// Consulta para eliminar la inscripción
$sql =  $conn->prepare("
    DELETE FROM INSCRIBE 
    WHERE ID_EVENTO = ? AND ID_CLIENTE = ?
");

// Enlazar parámetros
$sql->bind_param('ii', $id_evento, $id_cliente);

// Ejecutar consulta
if ($sql->execute()) {
    // Redireccionar a la página de eventos después de eliminar la inscripción
    header("Location: ../VISTA/eventos_clientes.php?id_cliente=" . $id_cliente);
    exit();
} else {
    // Manejar error si la consulta falla
    echo "Error al eliminar la inscripción: " . $sql->error;
}

// Cerrar la conexión
$sql->close();
$conn->close();
?>

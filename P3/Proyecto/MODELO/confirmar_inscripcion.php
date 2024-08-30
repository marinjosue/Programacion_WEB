<?php
include "../MODELO/conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirmar'])) {
    $id_evento = isset($_POST['id_evento']) ? (int)$_POST['id_evento'] : 0;
    $id_INTEGRANTE = isset($_POST['id_INTEGRANTE']) ? (int)$_POST['id_INTEGRANTE'] : 0;
    $fecha_registro = date('Y-m-d');

    // Insertar un nuevo registro en la tabla "registra"
    $insert_stmt = $conn->prepare("INSERT INTO registra (ID_EVENTO, ID_INTEGRANTE, FECHA_REGISTRO) VALUES (?, ?, ?)");
    if ($insert_stmt === false) {
        die('Error en la preparación de la consulta de inserción: ' . $conn->error);
    }
    $insert_stmt->bind_param('iis', $id_evento, $id_INTEGRANTE, $fecha_registro);

    if ($insert_stmt->execute()) {
        echo "<script>alert('Inscripción confirmada.'); window.location.href = 'index.php';</script>";
    } else {
        echo "<script>alert('Error al registrar en el evento.');</script>";
    }

    $insert_stmt->close();
}

$conn->close();
?>


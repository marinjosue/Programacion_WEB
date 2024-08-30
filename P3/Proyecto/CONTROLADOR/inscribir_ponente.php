<?php
include "../MODELO/conexion.php";

if(isset($_REQUEST['Inscribirse'])){
    // Recuperar y sanitizar datos del formulario
    $id_evento = isset($_POST['id_evento']) ? (int)$_POST['id_evento'] : 0;
    $id_cliente = isset($_POST['id_cliente']) ? (int)$_POST['id_cliente'] : 0;

}
// Cerrar la conexión
$conn->close();
?>

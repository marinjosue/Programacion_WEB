<?php
    // Conexión a la base de datos
    $servername = "localhost";
    $username = "root"; // Reemplaza con tu usuario de MySQL
    $password = ""; // Reemplaza con tu contraseña de MySQL
    $dbname = "cone"; // Nombre de la base de datos

    // Crear la conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
?>

<?php
    $host = "localhost";
    $user = "root";
    $password = "";
    $database = "cone";  // Cambia el nombre de la base de datos a "cone"

    $conexion = mysqli_connect($host, $user, $password, $database);

    if (!$conexion) {
        die("Conexión fallida: " . mysqli_connect_error());
    }
?>

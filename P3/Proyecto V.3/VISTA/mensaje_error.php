<?php
session_start(); // Iniciar sesión

// Obtener el mensaje de error si existe
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : 'Error desconocido';

// Limpiar el mensaje de error
unset($_SESSION['error_message']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensaje</title>
    <script>
        function redirigir() {
            alert("<?php echo $error_message; ?>");
            window.location.href = 'login.php';
        }
    </script>
</head>
<body onload="redirigir()">
</body>
</html>

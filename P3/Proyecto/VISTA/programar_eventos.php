<?php
session_start(); // Iniciar sesión

include "../MODELO/conexion.php";

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Consulta SQL para verificar las credenciales
    $stmt = $conn->prepare("SELECT * FROM ORGANIZADOR WHERE EMAIL = ? AND CONTRASENA = ?");
    if ($stmt === false) {
        die('Error en la preparación de la consulta: ' . $conn->error);
    }

    $stmt->bind_param('ss', $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['id_organizador'] = $row['ID_ORGANIZADOR']; // Guardar ID del organizador en sesión
        $_SESSION['nombre_organizador'] = $row['NOMBRE']; // Guardar nombre del organizador en sesión

        // Redirigir a la página de inscripción
        header("Location: crear_evento.php");
        exit();
    } else {
        // Usuario o contraseña incorrectos
        echo "<script>alert('Usuario o contraseña incorrectos');</script>";
    }

    $stmt->close();
}

// Cerrar la conexión
$conn->close();
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ponnte - Inicio de Sesión</title>
    <link rel="stylesheet" href="css/men_res.css">
    <link rel="stylesheet" href="css/loginStyles.css">
</head>
<body>
<!-- Encabezado -->
<header class="header">
    <!-- Logo -->
    <img class="logo" src="img/Logo_CONE.png" alt="Logo">
    <!-- Menú de navegación -->
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
</script>

<main>
    <!-- Contenedor principal -->
    <section class="formaCo">
        <div class="container">
            <h2 class="mensaje">Inicio de Sesión</h2>
            <!-- Formulario de inicio de sesión -->
            <form id="loginForm" method="post">
                <div class="form-group">
                    <label for="username">Usuario</label>
                    <input type="text" name="username" id="username" placeholder="Usuario" minlength="4" maxlength="25" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" name="password" id="password" placeholder="***********" required>
                </div>
                <div class="form-option">
                    <label><input type="checkbox" name="recordar"> Recordar</label>
                    <a href="#" class="Recordatorio">Recuperar contraseña</a>
                </div>
                <button type="submit" class="btn-inicioSesion">Entrar</button>
            </form>
        </div>
    </section>
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
</body>
</html>

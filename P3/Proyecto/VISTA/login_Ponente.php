<?php
include "../MODELO/conexion.php";

// Recuperar el ID del evento y el nombre del evento desde la URL
$id_evento = isset($_GET['id_evento']) ? (int)$_GET['id_evento'] : 0;
$nombre_evento = isset($_GET['nombre_evento']) ? urldecode($_GET['nombre_evento']) : "Evento no especificado";
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
            <li class="menu"><a href="FAQ.php">Cliente/Registro</a></li>
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
    <h2 class="mensaje">Se inscribe en: <?php echo htmlspecialchars($nombre_evento); ?></h2>
    <!-- Contenedor principal -->
    <section class="formaCo">
        <div class="container">
            <h2 class="mensaje">Inicio de Sesión</h2>
            <form id="loginForm" action="../CONTROLADOR/inscribir_ponente.php" method="post">
                <input type="hidden" name="id_evento" value="<?php echo htmlspecialchars($id_evento); ?>">
                <input type="hidden" name="nombre_evento" value="<?php echo htmlspecialchars($nombre_evento); ?>">
                <div class="form-group">
                    <label for="username">Usuario</label>
                    <input type="text" name="username" id="username" placeholder="Usuario" minlength="4"  required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" name="password" id="password" placeholder="***********" required>
                </div>
                <div class="form-option">
                    <label><input type="checkbox" name="recordar"> Recordar</label>
                </div>
                <button type="submit" class="btn-inicioSesion">INSCRIBIRSE</button>
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

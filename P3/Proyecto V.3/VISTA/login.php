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

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['username'];
    $password = $_POST['password'];

    // Consulta SQL para verificar las credenciales
    $sql = "SELECT * FROM CLIENTE WHERE EMAIL = '$email' AND CONTRASENA = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Usuario encontrado, redirigir a la página de conferencias
        header("Location: index.php");
    } else {
        // Usuario o contraseña incorrectos
        echo "<script>alert('Usuario o contraseña incorrectos');</script>";
    }
}

// Cerrar la conexión
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CONFERENCIAS</title>
    <!-- Enlazar al CSS-->
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
                <li class="menu"><a href="index.html">Conferencia</a></li>
                <li class="menu"><a href="Eventos.html">Eventos</a></li>
                <li class="menu"><a href="quienes-somos.html">Quiénes somos</a></li>
                <li class="menu" id="menu-var">
                    <a href="#programacion">Programación C|O|N|E</a>
                    <div class="contact-bar1">
                        <button onclick="window.location.href='programar_eventos.html'">Programar Eventos</button>
                        <button onclick="window.location.href='programar_conferencias.html'">Programar Conferencias</button>
                    </div>
                </li>
                <li class="menu"><a href="login.php">Entrar</a></li>
                <li class="menu"><a href="registrar.php">Registrarse</a></li>
            </ul>
            <div class="hamburger" id="hamburger">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
        </nav>
    </header>
    <main>
        <!-- Contenedor principal -->
        <section class="formaCo">
            <div class="container">
                <h2 class="mensaje">Inicio de Sesión</h2>
                <!-- Diseño del formulario de inicio de sesión -->     
                <form id="loginForm" method="post">
                    <div class="form-group">
                        <label for="username">Usuario</label>
                        <input type="text" name="username" id="username" placeholder="Usuario" minlength="4" maxlength="25" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" name="password" id="password" placeholder="***********" minlength="8" required>
                    </div>
                    <div class="form-option">
                        <label><input type="checkbox" name="recordar">Recordar</label>
                        <a href="#" class="Recordatorio">Recuperar contraseña</a>
                    </div>
                    <button type="submit" class="btn-inicioSesion">ENTRAR</button>
                    <h2 class="mensaje">¿No tienes cuenta?</h2>
                    <button type="submit" class="btn-Registrarse" onclick="redirectToRegistrar()">REGISTRARSE</button>
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
    </section>

    <!-- JavaScript para el menú hamburguesa -->
    <script>
        const hamburger = document.getElementById('hamburger');
        const navbar = document.getElementById('navbar');

        hamburger.addEventListener('click', () => {
            navbar.classList.toggle('show');
        });
    </script>
</body>
</html>

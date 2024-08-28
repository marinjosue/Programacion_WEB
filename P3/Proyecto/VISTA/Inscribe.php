<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>inscribe</title>
    <!-- Enlazar al CSS-->
    <link rel="stylesheet" href="css/men_res.css">
</head>
<body>
   <!-- Encabezado -->
<header class="header">
    <!-- Logo -->
    <img class="logo" src="img/Logo_CONE.png" alt="Logo">
    <!-- Menú de navegación -->
    <nav class="nav">
        <ul class="barnav" id="navbar">
            <li class="menu"><a href="index.php">Conferencia</a></li>
            <li class="menu"><a href="Eventos.php">Eventos</a></li>
            <li class="menu"><a href="quienes-somos.php">Quiénes somos</a></li>
            <li class="menu" id="menu-var">
                <a href="#programacion">Programación C|O|N|E</a>
                <div class="contact-bar1">
                    <button onclick="window.location.href='programar_eventos.php'">Programar Eventos</button>
                    <button onclick="window.location.href='programar_conferencias.php'">Programar Conferencias</button>
                </div>
            </li>
            <li class="menu"><a href="login.php">Entrar</a></li>
            <li class="menu"><a href="registrar.php">Registrarse</a></li>
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

    <!-- Contenido principal -->
    <main>
    <h1>FORMULARIO y crear un css especifico para cada pag</h1>
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
</body>
</html>
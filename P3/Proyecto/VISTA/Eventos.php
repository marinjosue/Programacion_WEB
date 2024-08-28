<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos</title>
    <!-- Enlazar al CSS-->
    <link rel="stylesheet" href="css/men_res.css">
    <link rel="stylesheet" href="css/evento.css">
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


    <!-- Carrusel de imágenes (no se modifica para preservar funcionalidad) -->
    </header>
    <!--Banner/Portada-->
    <div class="imagenes">
    <img class="img" src="img/banner-eventos1.jpg" alt="Imagen">
    <img class="img"src="img/banner-eventos1.png" alt="Imagen">
    <img class="img"src="img/banner-eventos2.png" alt="Imagen">
    <img class="img"src="img/banner-eventos4.png" alt="Imagen">
    <img class="img"src="img/banner-eventos5.jpg" alt="Imagen">
    <img class="img"src="img/banner-eventos6.jpg" alt="Imagen">
    </div>

    <!-- Contenido principal -->
    <main>
        <!--Banner/Portada-->
        <section class="banner">
            <h1 class="title-banner">Conferencias Organizadas Nuevos Eventos</h1>
            <h3 class="title-text">"Te damos la más cordial bienvenida a Conferencias Organizadas, el punto de 
                encuentro para experiencias inspiradoras y conexiones significativas. En nuestro espacio, 
                celebramos la creatividad, el aprendizaje y el intercambio de ideas que transforman el mundo. 
                Desde conferencias de vanguardia hasta eventos especializados, nuestra plataforma ofrece 
                oportunidades únicas para conectar con expertos, descubrir nuevas perspectivas y hacer 
                realidad tus proyectos más innovadores. Únete a nosotros y sé parte de los nuevos encuentros 
                que marcan la diferencia."<h3>
            <a href="#" class="btm-banner">CONTACTO</a>
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
</body>
</html>
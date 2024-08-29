<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CONFERENCIAS</title>
    <link rel="stylesheet" type="text/css" href="css/cssIndex.css">
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

<div class="imagenes">
    <img src="img/img_conf.jpg" alt="Imagen">
    <img src="img/banner2.webp" alt="Imagen">
    <img src="img/banner3.jpeg" alt="Imagen">
    <img src="img/banner3.jpg" alt="Imagen">
    <img src="img/banner4.jpeg" alt="Imagen">
    <img src="img/banner5.jpg" alt="Imagen">
</div>

<main>
    <section class="banner">
        <h1 class="title-banner">Conferencias Organizadas Nuevos Eventos</h1>
        <h3 class="title-text">Te damos la más cordial bienvenida a Conferencias Organizadas, el punto de 
            encuentro para experiencias inspiradoras y conexiones significativas. En nuestro espacio, 
            celebramos la creatividad, el aprendizaje y el intercambio de ideas que transforman el mundo. 
            Desde conferencias de vanguardia hasta eventos especializados, nuestra plataforma ofrece 
            oportunidades únicas para conectar con expertos, descubrir nuevas perspectivas y hacer 
            realidad tus proyectos más innovadores. Únete a nosotros y sé parte de los nuevos encuentros 
            que marcan la diferencia.</h3>
        <a href="#" class="btm-banner">CONTACTO</a>
    </section>
    <section  class="banner_estado"> <h2 class="title-banner">EVENTOS/CONFERENCIAS ACTIVAS</h2></section>
   
    <!-- Contenedor de eventos en grid -->
    <div class="eventos-grid">
    <?php 
// Conexión a la base de datos
        include "../MODELO/conexion.php";

        $sql = "SELECT ID_EVENTO, NOMBRE, FECHA_INICIO, FECHA_FIN, CAPACIDAD, DESCRIPCION FROM EVENTO WHERE ESTADO = 'Activo'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='evento'>";
                    echo "<div class='evento-contenido'>";
                        echo "<h3>" . $row["NOMBRE"] . "</h3>";
                        echo "<p><strong>Fecha Inicio:</strong> " . $row["FECHA_INICIO"] . "</p>";
                        echo "<p><strong>Fecha Fin:</strong> " . $row["FECHA_FIN"] . "</p>";
                        echo "<p><strong>Capacidad:</strong> " . $row["CAPACIDAD"] . "</p>";
                        echo "<p><strong>Descripción:</strong> " . $row["DESCRIPCION"] . "</p>";
                        echo "<a href='identificacion.php?id_evento=" . $row["ID_EVENTO"] . "&nombre_evento=" . urlencode($row["NOMBRE"]) . "' class='btn'>Inscribirse</a>";
                        echo "<a href='informacion_evento.php?id_evento=" . $row["ID_EVENTO"] . "' class='btn'>Información</a>";
                    echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p>No hay eventos activos en este momento.</p>";
        }

        $conn->close();
     ?>

    </div>
</main>


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
        <div class="sydney-credits">© Universidad de las Fuerzas Armadas ESPE <br> Todos los derechos reservados 2024</div>
    </div>
    <div class="col-md-6"></div>
</div>

<script>
    const hamburger = document.getElementById('hamburger');
    const navbar = document.getElementById('navbar');

    hamburger.addEventListener('click', () => {
        navbar.classList.toggle('show');
    });
</script>
</body>
</html>

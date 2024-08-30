<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información del Evento</title>
    <!-- Enlazar al CSS -->
    <link rel="stylesheet" href="css/men_res.css">
    <!-- Boostrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/c4033be41c.js" crossorigin="anonymous"></script>
    <style>
        /* Estilos personalizados */
        .ponente-item {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
        .ponente-item img {
            border-radius: 50%;
            margin-right: 20px;
            width: 100px;
            height: 100px;
            object-fit: cover;
        }
        .ponente-item .details {
            flex-grow: 1;
        }
           @media (max-width: 767px) {
            .hamburger {
                display: flex;
            }
            .barnav {
                display: none;
                flex-direction: column;
                width: 100%;
            }
            .barnav.show {
                display: flex;
            }
            .barnav .menu {
                margin: 10px 0;
            }
        }
    </style>
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

    <!-- Scripts Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Contenido principal -->
    <main class="main">
    <?php
    // Conexión a la base de datos
    include "../MODELO/conexion.php";

    // Obtener el ID del evento desde la URL
    $id_evento = $_GET['id_evento'];

    // Obtener la información del evento
    $sql_evento = "SELECT * FROM EVENTO WHERE ID_EVENTO = $id_evento";
    $result_evento = $conn->query($sql_evento);

    if ($result_evento->num_rows > 0) {
        $evento = $result_evento->fetch_assoc();

        echo "<h2>" . $evento['NOMBRE'] . "</h2>";
        echo "<p><strong>Fecha Inicio:</strong> " . $evento['FECHA_INICIO'] . "</p>";
        echo "<p><strong>Fecha Fin:</strong> " . $evento['FECHA_FIN'] . "</p>";
        echo "<p><strong>Capacidad:</strong> " . $evento['CAPACIDAD'] . "</p>";
        echo "<p><strong>Descripción:</strong> " . $evento['DESCRIPCION'] . "</p>";

        // Obtener los clientes inscritos en el evento
        $sql_clientes = "
            SELECT C.NOMBRE, C.APELLIDO, C.EMAIL, C.TELEFONO
            FROM INSCRIBE AS INSC
            JOIN CLIENTE AS C ON INSC.ID_CLIENTE = C.ID_CLIENTE
            WHERE INSC.ID_EVENTO = $id_evento";
        $result_clientes = $conn->query($sql_clientes);

        if ($result_clientes->num_rows > 0) {
            echo "<h3>Clientes inscritos:</h3>";
            echo "<ul>";
            while ($cliente = $result_clientes->fetch_assoc()) {
                echo "<li>" . $cliente['NOMBRE'] . " " . $cliente['APELLIDO'] . " - " . $cliente['EMAIL'] . "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No hay clientes inscritos.</p>";
        }

        // Obtener los integrantes que registraron el evento
        $sql_integrantes = "
            SELECT I.NOMBRE, I.APELLIDO, I.EMAIL, I.TELEFONO, I.ROL, I.ID_INTEGRANTE
            FROM REGISTRA AS R
            JOIN INTEGRANTE AS I ON R.ID_INTEGRANTE = I.ID_INTEGRANTE
            WHERE R.ID_EVENTO = $id_evento";
        $result_integrantes = $conn->query($sql_integrantes);

        if ($result_integrantes->num_rows > 0) {
            echo "<h3>Ponentes:</h3>";
            echo "<div class='ponentes-list'>";
            while ($integrante = $result_integrantes->fetch_assoc()) {
                $foto_url = "foto/" . $integrante['ID_INTEGRANTE'] . ".png"; 
                echo "<div class='ponente-item'>";
                echo "<img src='$foto_url' alt='Foto de " . $integrante['NOMBRE'] . "' />";
                echo "<div class='details'>";
                echo "<p><strong>" . $integrante['NOMBRE'] . " " . $integrante['APELLIDO'] . "</strong></p>";
                echo "<p>Email: " . $integrante['EMAIL'] . "</p>";
                echo "<p>Teléfono: " . $integrante['TELEFONO'] . "</p>";
                echo "<p>Rol: " . $integrante['ROL'] . "</p>";
                echo "</div>";
                echo "</div>";
            }
            echo "</div>";
        } else {
            echo "<p>No hay ponentes registrados.</p>";
        }

        // Obtener las ubicaciones del evento
         // Obtener las ubicaciones del evento
            $sql_ubicaciones = "
            SELECT U.CANTON, U.PROVINCIA, U.PARROQUIA, U.DIRECCION
            FROM SE_ENCUENTRA AS SE
            JOIN UBICACION AS U ON SE.ID_UBICACION = U.ID_UBICACION
            WHERE SE.ID_EVENTO = $id_evento";
            $result_ubicaciones = $conn->query($sql_ubicaciones);

        if ($result_ubicaciones->num_rows > 0) {
            echo "<h3>Ubicaciones:</h3>";
            echo "<ul>";
            while ($ubicacion = $result_ubicaciones->fetch_assoc()) {
                echo "<li>" . $ubicacion['DIRECCION'] . ", " . $ubicacion['PARROQUIA'] . ", " . $ubicacion['CANTON'] . ", " . $ubicacion['PROVINCIA'] . "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No hay ubicaciones registradas.</p>";
        }
    } else {
        echo "<p>No se encontró el evento.</p>";
    }

    $conn->close();
    ?>
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
    <div class="sydney-credits">© Universidad de las Fuerzas Armadas ESPE <br> Todos los derechos reservados 2024</div>
</footer>

</body>
</html>

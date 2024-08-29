<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informacion</title>
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

    <!-- Contenido principal -->
    <main>
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
        SELECT I.NOMBRE, I.APELLIDO, I.EMAIL, I.TELEFONO, I.ROL
        FROM REGISTRA AS R
        JOIN INTEGRANTE AS I ON R.ID_INTEGRANTE = I.ID_INTEGRANTE
        WHERE R.ID_EVENTO = $id_evento";
    $result_integrantes = $conn->query($sql_integrantes);

    if ($result_integrantes->num_rows > 0) {
        echo "<h3>Ponentes:</h3>";
        echo "<ul>";
        while ($integrante = $result_integrantes->fetch_assoc()) {
            echo "<li>" . $integrante['NOMBRE'] . " " . $integrante['APELLIDO'] . " - " . $integrante['EMAIL'] . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No hay integrantes registrados.</p>";
    }

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
        echo "<p>No hay ubicaciones asociadas.</p>";
    }

    // Obtener los servicios contratados
    $sql_servicios = "
        SELECT S.DESCRIPCION_S, C.CANTIDAD, C.VALOR
        FROM CONTRATA AS C
        JOIN SERVICIO AS S ON C.ID_SERVICIO = S.ID_SERVICIO
        WHERE C.ID_EVENTO = $id_evento";
    $result_servicios = $conn->query($sql_servicios);

    if ($result_servicios->num_rows > 0) {
        echo "<h3>Servicios contratados:</h3>";
        echo "<ul>";
        while ($servicio = $result_servicios->fetch_assoc()) {
            echo "<li>" . $servicio['DESCRIPCION_S'] . " - Cantidad: " . $servicio['CANTIDAD'] . " - Valor: $" . $servicio['VALOR'] . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No hay servicios contratados.</p>";
    }
} else {
    echo "<p>Evento no encontrado.</p>";
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar</title>
    <link rel="stylesheet" href="css/men_res.css">
</head>
<body>
<!-- Encabezado -->
<header class="header">
    <img class="logo" src="img/Logo_CONE.png" alt="Logo">
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

<section class="formaCo">
    <div class="register-container">
        <h2>REGISTRO DE USUARIO</h2>
        <form id="register-form" action="" method="post" onsubmit="return validarFormulario();">
            <div class="form-group">
                <label for="cedula">Cédula</label>
                <input type="text" id="cedula" name="cedula" placeholder="Cédula" pattern="\d{10}" title="Ingrese un número de cédula válido de 10 dígitos" required>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" placeholder="Nombre" pattern="[a-zA-ZáéíóúüÁÉÍÓÚÜñÑ\s]{3,30}" title="Ingrese un nombre válido" required>
            </div>
            <div class="form-group">
                <label for="apellido">Apellido</label>
                <input type="text" id="apellido" name="apellido" placeholder="Apellido" pattern="[a-zA-ZáéíóúüÁÉÍÓÚÜñÑ\s]{3,30}" title="Ingrese un apellido válido" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Correo electrónico" required>
            </div>
            <div class="form-group">
                <label for="contrasena">Contraseña</label>
                <input type="password" id="contrasena" name="contrasena" placeholder="Contraseña" minlength="8" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="tel" id="telefono" name="telefono" placeholder="Teléfono (10 dígitos)" pattern="\d{10}" title="Ingrese un número de teléfono válido de 10 dígitos" required>
            </div>
            <button type="submit" class="btn-registro" id="submit-button">Registrarse</button>
        </form>
    </div>
</section>

<script>
function toggleMenu() {
    var nav = document.getElementById('navbar');
    nav.classList.toggle('show');
}

function validarFormulario() {
    // Validar cédula
    var cedula = document.getElementById('cedula').value;
    if (!validarCedula(cedula)) {
        alert("Cédula inválida. Por favor, ingrese una cédula ecuatoriana válida.");
        return false;
    }

    // Validar nombre y apellido (sin números)
    var nombre = document.getElementById('nombre').value;
    var apellido = document.getElementById('apellido').value;
    var nombreApellidoRegex = /^[a-zA-ZáéíóúüÁÉÍÓÚÜñÑ\s]+$/;

    if (!nombreApellidoRegex.test(nombre)) {
        alert("El nombre no puede contener números.");
        return false;
    }

    if (!nombreApellidoRegex.test(apellido)) {
        alert("El apellido no puede contener números.");
        return false;
    }

    // Validar teléfono (solo números)
    var telefono = document.getElementById('telefono').value;
    var telefonoRegex = /^\d{10}$/;

    if (!telefonoRegex.test(telefono)) {
        alert("El teléfono debe contener solo 10 dígitos numéricos.");
        return false;
    }

    return true;
}

// Redireccionar solo si el formulario se envió correctamente
document.getElementById('register-form').addEventListener('submit', function(event) {
    if (validarFormulario()) {
        event.preventDefault(); // Previene el envío del formulario estándar
        // Si todo está bien, envía el formulario con PHP y redirige
        this.submit();
        window.location.href = 'login.php';
    }
});

function validarCedula(cedula) {
    if (cedula.length != 10) {
        return false;
    }
    var digitos = cedula.split('').map(Number);
    var total = 0;
    for (var i = 0; i < 9; i++) {
        var aux = digitos[i] * (i % 2 === 0 ? 2 : 1);
        if (aux > 9) aux -= 9;
        total += aux;
    }
    var digitoVerificador = (total % 10 === 0) ? 0 : 10 - (total % 10);
    return digitoVerificador === digitos[9];
}
</script>

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
        <div class="sydney-credits">© Universidad de las Fuerzas Armadas ESPE <br> Todos los derechos reservados 2024</div>
    </div>
    <div class="col-md-6">
        <!-- Otro contenido si es necesario -->
    </div>
</div>

<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cone";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validaciones en el servidor
    $cedula = $_POST['cedula'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $contrasena = $_POST['contrasena'];
    $telefono = $_POST['telefono'];

    // Validar cédula
    if (!preg_match('/^\d{10}$/', $cedula) || !validarCedula($cedula)) {
        die("Cédula inválida.");
    }

    // Validar nombre y apellido (sin números)
    if (!preg_match('/^[a-zA-ZáéíóúüÁÉÍÓÚÜñÑ\s]+$/', $nombre)) {
        die("El nombre no puede contener números.");
    }

    if (!preg_match('/^[a-zA-ZáéíóúüÁÉÍÓÚÜñÑ\s]+$/', $apellido)) {
        die("El apellido no puede contener números.");
    }

    // Validar teléfono (solo números)
    if (!preg_match('/^\d{10}$/', $telefono)) {
        die("El teléfono debe contener solo 10 dígitos numéricos.");
    }

    // Verificar si la cédula ya existe
    $check_sql = "SELECT * FROM cliente WHERE CEDULA = ?";
    if ($stmt_check = $conn->prepare($check_sql)) {
        $stmt_check->bind_param("s", $cedula);
        $stmt_check->execute();
        $result = $stmt_check->get_result();

        if ($result->num_rows > 0) {
            // Cédula ya registrada
            echo "<script>alert('Ya existe este usuario registrado.'); window.location.href = 'login.php';</script>";
            exit();
        }

        $stmt_check->close();
    } else {
        echo "Error en la preparación de la consulta de verificación: " . $conn->error;
        exit();
    }

    // Preparar la consulta SQL para insertar nuevos datos
    $sql = "INSERT INTO cliente (CEDULA, NOMBRE, APELLIDO, EMAIL, CONTRASENA, TELEFONO) 
            VALUES (?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        // Vincular los parámetros
        $stmt->bind_param("ssssss", $cedula, $nombre, $apellido, $email, $contrasena, $telefono);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Redirigir a login.php después del registro exitoso
            header("Location: login.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta: " . $conn->error;
    }

    $conn->close();
}

// Función para validar cédula en el servidor
function validarCedula($cedula) {
    if (strlen($cedula) != 10) {
        return false;
    }
    $digitos = array_map('intval', str_split($cedula));
    $total = 0;
    for ($i = 0; $i < 9; $i++) {
        $aux = $digitos[$i] * (($i % 2 === 0) ? 2 : 1);
        if ($aux > 9) $aux -= 9;
        $total += $aux;
    }
    $digitoVerificador = ($total % 10 === 0) ? 0 : 10 - ($total % 10);
    return $digitoVerificador === $digitos[9];
}
?>

</body>
</html>

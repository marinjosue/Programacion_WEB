<?php
session_start(); // Iniciar sesión
include "../MODELO/conexion.php";

// Recuperar ID del evento desde la URL
$id_evento = isset($_GET['update_id']) ? intval($_GET['update_id']) : 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar datos del formulario
    $nombre = trim($_POST['nombre']);
    $fecha_inicio = trim($_POST['fecha_inicio']);
    $fecha_fin = trim($_POST['fecha_fin']);
    $estado = trim($_POST['estado']);
    $precio_evento = trim($_POST['precio_evento']);
    $descripcion = trim($_POST['descripcion']);
    $capacidad = trim($_POST['capacidad']);

    // Consulta SQL para actualizar el evento
    $sql = "UPDATE evento SET NOMBRE = ?, FECHA_INICIO = ?, FECHA_FIN = ?, ESTADO = ?, PRECIO_EVENTO = ?, DESCRIPCION = ?, CAPACIDAD = ? WHERE ID_EVENTO = ?";

    if ($stmt = $conn->prepare($sql)) {
        // Asociar los parámetros
        $stmt->bind_param('sssssssi', $nombre, $fecha_inicio, $fecha_fin, $estado, $precio_evento, $descripcion, $capacidad, $id_evento);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "<script>alert('Evento actualizado exitosamente.'); window.location.href = 'crear_evento.php';</script>";
        } else {
            echo "<script>alert('Error al actualizar el evento: " . $stmt->error . "');</script>";
        }

        $stmt->close();
    } else {
        die('Error en la preparación de la consulta: ' . $conn->error);
    }
}

// Consulta SQL para obtener los detalles del evento
$sql = "SELECT * FROM evento WHERE ID_EVENTO = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param('i', $id_evento);
    $stmt->execute();
    $result = $stmt->get_result();
    $evento = $result->fetch_assoc();
    $stmt->close();
} else {
    die('Error en la preparación de la consulta: ' . $conn->error);
}

// Verificar si el evento existe
if (!$evento) {
    die('Evento no encontrado.');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Evento</title>
    <!-- Incluir Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Incluir CSS personalizado -->
    <link rel="stylesheet" href="css/men_res.css">
</head>
<body>
    <header class="header">
        <img class="logo" src="img/Logo_CONE.png" alt="Logo">
        <nav class="nav">
            <ul class="barnav" id="navbar">
                <li class="menu"><a href="index.php">Conferencia/Eventos</a></li>
                <li class="menu"><a href="quienes-somos.php">Quiénes somos</a></li>
                <li class="menu" id="menu-var">
                    <a href="programar_eventos.php">Programación C|O|N|E</a>
                </li>
                <li class="menu"><a href="FAQ.php">Eventos registrados</a></li>
            </ul>
        </nav>
    </header>

    <main class="container my-4">
        <h1 class="mb-4">Actualizar Evento</h1>
        <form method="post" action="actualizar_evento.php?update_id=<?php echo htmlspecialchars($id_evento); ?>">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo htmlspecialchars($evento['NOMBRE']); ?>" required>
            </div>
            <div class="form-group">
                <label for="fecha_inicio">Fecha de Inicio:</label>
                <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" value="<?php echo htmlspecialchars($evento['FECHA_INICIO']); ?>" required>
            </div>
            <div class="form-group">
                <label for="fecha_fin">Fecha de Fin:</label>
                <input type="date" class="form-control" name="fecha_fin" id="fecha_fin" value="<?php echo htmlspecialchars($evento['FECHA_FIN']); ?>" required>
            </div>
            <div class="form-group">
                <label for="estado">Estado:</label>
                <select class="form-control" name="estado" id="estado" required>
                    <option value="" disabled>Seleccione el estado</option>
                    <option value="Cancelado" <?php echo $evento['ESTADO'] == 'Cancelado' ? 'selected' : ''; ?>>Cancelado</option>
                    <option value="Activado" <?php echo $evento['ESTADO'] == 'Activado' ? 'selected' : ''; ?>>Activado</option>
                    <option value="Programado" <?php echo $evento['ESTADO'] == 'Programado' ? 'selected' : ''; ?>>Programado</option>
                </select>
            </div>
            <div class="form-group">
                <label for="precio_evento">Precio del Evento:</label>
                <input type="number" step="0.01" class="form-control" name="precio_evento" id="precio_evento" value="<?php echo htmlspecialchars($evento['PRECIO_EVENTO']); ?>" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <input type="text" class="form-control" name="descripcion" id="descripcion" value="<?php echo htmlspecialchars($evento['DESCRIPCION']); ?>" required>
            </div>
            <div class="form-group">
                <label for="capacidad">Capacidad:</label>
                <input type="number" class="form-control" name="capacidad" id="capacidad" value="<?php echo htmlspecialchars($evento['CAPACIDAD']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Evento</button>
        </form>
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

    <!-- Incluir jQuery y Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Cerrar la conexión
$conn->close();
?>

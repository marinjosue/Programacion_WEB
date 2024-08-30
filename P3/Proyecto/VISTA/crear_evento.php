<?php
session_start(); // Iniciar sesión
include "../MODELO/conexion.php";

// Recuperar ID y nombre del organizador desde la sesión
$id_organizador = isset($_SESSION['id_organizador']) ? $_SESSION['id_organizador'] : '';
$nombre_organizador = isset($_SESSION['nombre_organizador']) ? $_SESSION['nombre_organizador'] : '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar datos del formulario
    $nombre = trim($_POST['nombre']);
    $fecha_inicio = trim($_POST['fecha_inicio']);
    $fecha_fin = trim($_POST['fecha_fin']);
    $estado = trim($_POST['estado']);
    $precio_evento = trim($_POST['precio_evento']);
    $descripcion = trim($_POST['descripcion']);
    $capacidad = trim($_POST['capacidad']);

    // Consulta SQL para insertar un nuevo evento
    $sql = "INSERT INTO evento (ID_ORGANIZADOR, NOMBRE, FECHA_INICIO, FECHA_FIN, ESTADO, PRECIO_EVENTO, DESCRIPCION, CAPACIDAD) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        // Asociar los parámetros
        $stmt->bind_param('issssssi', $id_organizador, $nombre, $fecha_inicio, $fecha_fin, $estado, $precio_evento, $descripcion, $capacidad);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "<script>alert('Evento creado exitosamente.'); window.location.href = 'crear_evento.php';</script>";
        } else {
            echo "<script>alert('Error al crear el evento: " . $stmt->error . "');</script>";
        }

        $stmt->close();
    } else {
        die('Error en la preparación de la consulta: ' . $conn->error);
    }
}

// Manejar la eliminación de un evento
if (isset($_GET['delete_id'])) {
    $id_evento = intval($_GET['delete_id']);

    // Consulta SQL para eliminar un evento
    $sql = "DELETE FROM evento WHERE ID_EVENTO = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('i', $id_evento);
        try {
            if ($stmt->execute()) {
                echo "<script>alert('Evento eliminado exitosamente.'); window.location.href = 'crear_evento.php';</script>";
            } else {
                throw new Exception('Error al eliminar el evento: ' . $stmt->error);
            }
        } catch (Exception $e) {
            echo "<script>alert('No se puede eliminar el evento debido a restricciones en la base de datos.'); window.location.href = 'crear_evento.php';</script>";
        }
        $stmt->close();
    } else {
        die('Error en la preparación de la consulta: ' . $conn->error);
    }
}

// Consulta SQL para obtener todos los eventos
$sql = "SELECT * FROM evento";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Evento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/c4033be41c.js" crossorigin="anonymous"></script>
    <!-- Incluir CSS personalizado -->
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
                <li class="menu"><a href="FAQ.php">Eventos registrados</a></li>
            </ul>
            <div class="hamburger" id="hamburger" onclick="toggleMenu()">
                <div class="bar"></div>
                <div class="bar"></div>
                <div class="bar"></div>
            </div>
        </nav>
    </header>

    <main class="container my-4">
        <h1 class="mb-4">Bienvenido, <?php echo htmlspecialchars($nombre_organizador); ?>!</h1>
        <h2 class="mb-4">Crear Eventos</h2>
        <form method="post" action="crear_evento.php" class="mb-4">
            <div class="form-group">
                <label for="id_organizador">ID Organizador:</label>
                <input type="number" class="form-control" name="id_organizador" id="id_organizador" value="<?php echo htmlspecialchars($id_organizador); ?>" readonly required>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" name="nombre" id="nombre" required>
            </div>
            <div class="form-group">
                <label for="fecha_inicio">Fecha de Inicio:</label>
                <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" required>
            </div>
            <div class="form-group">
                <label for="fecha_fin">Fecha de Fin:</label>
                <input type="date" class="form-control" name="fecha_fin" id="fecha_fin" required>
            </div>
            <div class="form-group">
                <label for="estado">Estado:</label>
                <select class="form-control" name="estado" id="estado" required>
                    <option value="" disabled selected>Seleccione el estado</option>
                    <option value="Cancelado">Cancelado</option>
                    <option value="Activado">Activado</option>
                    <option value="Programado">Programado</option>
                </select>
            </div>
            <div class="form-group">
                <label for="precio_evento">Precio del Evento:</label>
                <input type="number" step="0.01" class="form-control" name="precio_evento" id="precio_evento" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <input type="text" class="form-control" name="descripcion" id="descripcion" required>
            </div>
            <div class="form-group">
                <label for="capacidad">Capacidad:</label>
                <input type="number" class="form-control" name="capacidad" id="capacidad" required>
            </div>
            <button type="submit" class="btn btn-primary">Crear Evento</button>
        </form>
            <!-- Buscador para la tabla -->
            <h2>Buscar en Tabla</h2>
            <div class="search-container mb-4">
                <input class="form-control search-input" id="searchInput" type="text" placeholder="Buscar en la tabla...">
                <span class="search-icon">
                    <i class="fa-solid fa-search"></i>
                </span>
            </div>


        <!-- Tabla para visualizar eventos -->
        <h2 class="my-4">Lista de Eventos</h2>
        <div style="max-height: 400px; overflow-y: auto;">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID Evento</th>
                        <th>ID Organizador</th>
                        <th>Nombre</th>
                        <th>Fecha de Inicio</th>
                        <th>Fecha de Fin</th>
                        <th>Estado</th>
                        <th>Precio del Evento</th>
                        <th>Descripción</th>
                        <th>Capacidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['ID_EVENTO']); ?></td>
                                <td><?php echo htmlspecialchars($row['ID_ORGANIZADOR']); ?></td>
                                <td><?php echo htmlspecialchars($row['NOMBRE']); ?></td>
                                <td><?php echo htmlspecialchars($row['FECHA_INICIO']); ?></td>
                                <td><?php echo htmlspecialchars($row['FECHA_FIN']); ?></td>
                                <td><?php echo htmlspecialchars($row['ESTADO']); ?></td>
                                <td><?php echo htmlspecialchars($row['PRECIO_EVENTO']); ?></td>
                                <td><?php echo htmlspecialchars($row['DESCRIPCION']); ?></td>
                                <td><?php echo htmlspecialchars($row['CAPACIDAD']); ?></td>
                                <td>
                                <a href="actualizar_evento.php?update_id=<?php echo htmlspecialchars($row['ID_EVENTO']);?>" class="btn btn-warning btn-sm" title="Editar evento">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a href="crear_evento.php?delete_id=<?php echo htmlspecialchars($row['ID_EVENTO']); ?>" class="btn btn-danger btn-sm" title="Eliminar evento" onclick="return confirm('¿Estás seguro de que deseas eliminar este evento?');">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </td>

                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10" class="text-center">No hay eventos disponibles.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
<!-- Scripts Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Incluir Bootstrap JS y dependencias -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <script>
        // Filtrado de la tabla
        document.getElementById('searchInput').addEventListener('keyup', function() {
            var input, filter, table, tr, td, i, j, txtValue;
            input = document.getElementById('searchInput');
            filter = input.value.toLowerCase();
            table = document.querySelector('.table tbody');
            tr = table.getElementsByTagName('tr');

            for (i = 0; i < tr.length; i++) {
                tr[i].style.display = 'none';
                td = tr[i].getElementsByTagName('td');
                for (j = 0; j < td.length; j++) {
                    if (td[j]) {
                        txtValue = td[j].textContent || td[j].innerText;
                        if (txtValue.toLowerCase().indexOf(filter) > -1) {
                            tr[i].style.display = '';
                            break;
                        }
                    }
                }
            }
        });
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
    <div class="sydney-credits">© Universidad de las Fuerzas Armadas ESPE <br> Todos los derechos reservados 2024</div>
</footer>

</body>
<head>
<Style>
.search-container {
    position: relative;
    max-width: 400px;
    margin: auto;
}

.search-input {
    padding-left: 2.5rem; /* Espacio para el ícono */
}

.search-icon {
    position: absolute;
    left: 0.5rem;
    top: 50%;
    transform: translateY(-50%);
    font-size: 1.2rem;
    color: #6c757d; /* Color del ícono */
}

.search-input::placeholder {
    color: #6c757d;
    opacity: 1; /* Para asegurar que el color del placeholder se aplique */
}

    
</Style>

</head>

</html>

<?php
$conn->close();
?>

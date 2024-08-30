<?php
include "../MODELO/conexion.php";

$nombre_evento = isset($_POST['nombre_evento']) ? trim($_POST['nombre_evento']) : 'Evento no especificado';
$email = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Consulta SQL para verificar las credenciales del usuario
    $stmt = $conn->prepare("SELECT ID_INTEGRANTE, NOMBRE, APELLIDO FROM INTEGRANTE WHERE EMAIL = ? AND ROL = ?");
    if ($stmt === false) {
        die('Error en la preparación de la consulta: ' . $conn->error);
    }
    $stmt->bind_param('ss', $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id_INTEGRANTE = $row['ID_INTEGRANTE'];
        $nombre_cliente = $row['NOMBRE'];
        $apellido_cliente = $row['APELLIDO'];

        // Consulta para obtener detalles del evento usando el nombre del evento
        $evento_stmt = $conn->prepare("SELECT * FROM EVENTO WHERE NOMBRE = ?");
        if ($evento_stmt === false) {
            die('Error en la preparación de la consulta: ' . $conn->error);
        }

        $evento_stmt->bind_param('s', $nombre_evento);
        $evento_stmt->execute();
        $evento_result = $evento_stmt->get_result();
        $evento = $evento_result->fetch_assoc();

        if ($evento) {
            $id_evento = $evento['ID_EVENTO'];

            // Verificación si el integrante ya está inscrito en el evento
            $check_inscription_stmt = $conn->prepare("SELECT * FROM REGISTRA WHERE ID_INTEGRANTE = ? AND ID_EVENTO = ?");
            if ($check_inscription_stmt === false) {
                die('Error en la preparación de la consulta: ' . $conn->error);
            }

            $check_inscription_stmt->bind_param('ii', $id_INTEGRANTE, $id_evento);
            $check_inscription_stmt->execute();
            $check_inscription_result = $check_inscription_stmt->get_result();

            if ($check_inscription_result->num_rows > 0) {
                // El integrante ya está inscrito en el evento
                echo "<script>
                        alert('Ya estás inscrito en este evento.');
                        window.location.href = '../VISTA/index.php';
                      </script>";
            } else {
                // Mostrar mensaje de confirmación
                echo "<div class='confirmation-container'>";
                echo "<h2>Confirmación de inscripción</h2>";
                echo "<p><strong>Nombre:</strong> $id_INTEGRANTE: $nombre_cliente $apellido_cliente</p>";
                echo "<p><strong>Evento:</strong> {$evento['NOMBRE']}</p>";
                echo "<p><strong>Id Evento:</strong> {$evento['ID_EVENTO']}</p>";
                echo "<p><strong>Fecha de Inicio:</strong> {$evento['FECHA_INICIO']}</p>";
                echo "<p><strong>Fecha de Fin:</strong> {$evento['FECHA_FIN']}</p>";
                echo "<p><strong>Descripción:</strong> {$evento['DESCRIPCION']}</p>";
                echo "<p><strong>Capacidad:</strong> {$evento['CAPACIDAD']}</p>";

                // Confirmación para proceder con la inscripción
                echo '<form method="post" action="confirmar_inscripcion.php">';
                echo '<input type="hidden" name="id_evento" value="' . htmlspecialchars($evento['ID_EVENTO']) . '">';
                echo '<input type="hidden" name="id_INTEGRANTE" value="' . htmlspecialchars($id_INTEGRANTE) . '">';
                echo '<input type="hidden" name="nombre_evento" value="' . htmlspecialchars($evento['NOMBRE']) . '">';
                echo '<input type="hidden" name="nombre_cliente" value="' . htmlspecialchars($nombre_cliente) . '">';
                echo '<button type="submit" name="confirmar" class="confirm-button">Confirmar inscripción</button>';
                echo '</form>';
                echo "</div>";
            }

            $check_inscription_stmt->close();
        } else {
            echo "<p>Evento no encontrado.</p>";
        }

        $evento_stmt->close();
    } else {
        echo "<script>alert('Usuario o contraseña incorrectos');</script>";
    }

    $stmt->close();
}

$conn->close();

echo "<style>
.confirmation-container {
    width: 50%;
    margin: 0 auto;
    padding: 20px;
    background-color: #f7f7f7;
    border-radius: 8px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    font-family: Arial, sans-serif;
}
.confirmation-container h2 {
    text-align: center;
    color: #333;
}
.confirmation-container p {
    font-size: 16px;
    color: #555;
    margin: 10px 0;
}
.confirm-button {
    display: block;
    width: 100%;
    padding: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
    text-align: center;
    font-size: 16px;
    cursor: pointer;
    margin-top: 20px;
}
.confirm-button:hover {
    background-color: #45a049;
}
</style>";
?>

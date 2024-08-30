<?php
include "../MODELO/conexion.php";

// Obtener el ID del cliente desde la URL
$id_cliente = $_GET['id_cliente'];

// Consulta SQL para obtener los eventos en los que el cliente está inscrito
$sql =$conn->prepare("
    SELECT E.ID_EVENTO, E.NOMBRE, E.FECHA_INICIO, E.FECHA_FIN, E.PRECIO_EVENTO, E.CAPACIDAD, I.PAGO_ABONO 
    FROM EVENTO E
    INNER JOIN INSCRIBE I ON E.ID_EVENTO = I.ID_EVENTO
    WHERE I.ID_CLIENTE = ?");
$sql->bind_param('i', $id_cliente);
$sql->execute();
$result = $sql->get_result();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos Registrados</title>
    <!-- Enlazar CSS y Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/c4033be41c.js" crossorigin="anonymous"></script>
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
            <li class="menu"><a href="FAQ.php">Cliente/Registro</a></li>
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
<main class="container mt-5">
    <h1 class="text-center">Eventos Registrados</h1>
    
    <!-- Formulario para abonar -->
    <div class="row mb-4">
        <div class="col-md-12">
            <form action="../CONTROLADOR/abonar_evento.php" method="POST" class="d-flex justify-content-between">
                <input type="hidden" name="id_cliente" value="<?= $id_cliente ?>">
                <div class="form-group">
                    <label for="id_evento">Selecciona el Evento</label>
                    <select name="id_evento" class="form-control" required>
                        <?php while ($evento = $result->fetch_object()) { ?>
                            <option value="<?= $evento->ID_EVENTO ?>">
                                <?= $evento->NOMBRE ?> (<?= $evento->FECHA_INICIO ?>)
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="abono">Cantidad a Abonar</label>
                    <input type="number" name="abono" class="form-control" required min="1">
                </div>
                <button type="submit" class="btn btn-primary align-self-end">Abonar</button>
            </form>
        </div>
    </div>

    <!-- Campo de búsqueda -->
    <div class="row mb-4">
        <div class="col-md-12">
            <input type="text" id="search" class="form-control" placeholder="Buscar en la tabla...">
        </div>
    </div>

    <!-- Tabla de eventos -->
    <div class="row">
        <div class="col-md-12">
            <table class="table" id="eventosTable">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Fecha Inicio</th>
                        <th scope="col">Fecha Fin</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Capacidad</th>
                        <th scope="col">Abono</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                // Re-ejecutamos la consulta para la tabla
                $sql->execute();
                $result = $sql->get_result();
                while ($datos = $result->fetch_object()) { ?>
                    <tr>
                        <td><?= $datos->ID_EVENTO ?></td>
                        <td><?= $datos->NOMBRE ?></td>
                        <td><?= $datos->FECHA_INICIO ?></td>
                        <td><?= $datos->FECHA_FIN ?></td>
                        <td><?= $datos->PRECIO_EVENTO ?></td>
                        <td><?= $datos->CAPACIDAD ?></td>
                        <td><?= $datos->PAGO_ABONO ?></td>
                        <td>
                            <a href="../CONTROLADOR/eliminar_inscripcion.php?id_evento=<?= $datos->ID_EVENTO ?>&id_cliente=<?= $id_cliente ?>" class="btn btn-small btn-danger">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- Scripts Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script para el buscador -->
<script>
document.getElementById('search').addEventListener('input', function() {
    var filter = this.value.toUpperCase();
    var rows = document.querySelector("#eventosTable tbody").rows;
    
    for (var i = 0; i < rows.length; i++) {
        var firstCol = rows[i].cells[1].textContent.toUpperCase();
        if (firstCol.indexOf(filter) > -1) {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }
    }
});
</script>

</body>
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
</html>
<?php


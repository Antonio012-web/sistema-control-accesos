<?php
include('conexion.php');

// Mostrar registros con JOIN para obtener el nombre del usuario
$sql = "SELECT registros.*, usuarios.nombre FROM registros JOIN usuarios ON registros.usuario_id = usuarios.id";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registros de Entrada y Salida</title>
    <link rel="stylesheet" href="styles.css"> <!-- Se agrega la referencia al archivo CSS externo -->
</head>
<body>
    <h2>Registros de Entrada y Salida</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Fecha Entrada</th>
            <th>Fecha Salida</th>
            <th>Nombre de Usuario</th>
            <th>Acción</th>
        </tr>
        <?php while($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['fecha_entrada']; ?></td>
                <td><?php echo $row['fecha_salida']; ?></td>
                <td><?php echo $row['nombre']; ?></td> <!-- Mostrar el nombre del usuario directamente -->
                <td>
                    <!-- Botón Ver -->
                    <button onclick="openModal(<?php echo $row['id']; ?>, '<?php echo $row['fecha_entrada']; ?>', '<?php echo $row['fecha_salida']; ?>', '<?php echo addslashes($row['nombre']); ?>')">Ver</button>
                    <!-- Botón Eliminar -->
                    <a href="eliminar_registro.php?id=<?php echo $row['id']; ?>" 
                       onclick="return confirm('¿Estás seguro de que deseas eliminar este registro?');">
                       <button>Eliminar</button>
                    </a>
                </td>
            </tr>
        <?php } ?>
    </table>

    <!-- Modal para ver detalles del registro -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h3>Detalles del Registro</h3>
            <p><strong>ID:</strong> <span id="modal-id"></span></p>
            <p><strong>Nombre de Usuario:</strong> <span id="modal-nombre"></span></p>
            <p><strong>Fecha Entrada:</strong> <span id="modal-fecha-entrada"></span></p>
            <p><strong>Fecha Salida:</strong> <span id="modal-fecha-salida"></span></p>
        </div>
    </div>

    <script>
        // Función para abrir el modal
        function openModal(id, fecha_entrada, fecha_salida, nombre) {
            document.getElementById('modal-id').textContent = id;
            document.getElementById('modal-nombre').textContent = nombre;
            document.getElementById('modal-fecha-entrada').textContent = fecha_entrada;
            document.getElementById('modal-fecha-salida').textContent = fecha_salida;

            document.getElementById('myModal').style.display = "block";
        }

        // Función para cerrar el modal
        function closeModal() {
            document.getElementById('myModal').style.display = "none";
        }
    </script>
</body>
</html>

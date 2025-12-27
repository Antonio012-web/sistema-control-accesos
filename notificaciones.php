<?php
include('conexion.php');

// Crear notificación
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['enviar'])) {
    $mensaje = $_POST['mensaje'];
    $numero_usuario = $_POST['numero_usuario'];

    // Verificar si el numero_usuario existe y obtener el id del usuario
    $sql_check = "SELECT id FROM usuarios WHERE numero_usuario = '$numero_usuario'";
    $result_check = $conn->query($sql_check);

    if ($result_check && $result_check->num_rows > 0) {
        // El numero_usuario existe
        $row = $result_check->fetch_assoc();
        $usuario_id = $row['id']; // Obtener el id del usuario correspondiente

        $fecha_envio = date('Y-m-d H:i:s'); // Fecha actual
        $leida = 0; // Marcar como no leída por defecto

        $sql = "INSERT INTO notificaciones (mensaje, usuario_id, fecha_envio, leida)
                VALUES ('$mensaje', '$usuario_id', '$fecha_envio', '$leida')";

        if ($conn->query($sql) === TRUE) {
            echo "<p>Notificación creada exitosamente.</p>";
        } else {
            echo "<p>Error al crear la notificación: " . $conn->error . "</p>";
        }
    } else {
        // El numero_usuario no existe
        echo "<p>Error: El número de usuario no existe.</p>";
    }
}

// Mostrar notificaciones
$sql = "SELECT notificaciones.id, notificaciones.mensaje, usuarios.numero_usuario, notificaciones.fecha_envio, notificaciones.leida 
        FROM notificaciones 
        INNER JOIN usuarios ON notificaciones.usuario_id = usuarios.id";
$result = $conn->query($sql);

// Verificar si la consulta fue exitosa
if (!$result) {
    die("<p>Error en la consulta SQL: " . $conn->error . "</p>");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificaciones</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Gestión de Notificaciones</h2>

    <!-- Formulario para enviar notificaciones -->
    <form action="notificaciones.php" method="POST">
        <textarea name="mensaje" placeholder="Mensaje" required></textarea><br>
        <input type="number" name="numero_usuario" placeholder="Número de usuario" required><br>
        <button type="submit" name="enviar">Enviar Notificación</button>
    </form>

    <h3>Lista de Notificaciones</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Mensaje</th>
                <th>Número de Usuario</th>
                <th>Fecha de Envío</th>
                <th>Leída</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['mensaje']; ?></td>
                        <td><?php echo $row['numero_usuario']; ?></td>
                        <td><?php echo $row['fecha_envio']; ?></td>
                        <td><?php echo $row['leida'] ? 'Sí' : 'No'; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No hay notificaciones registradas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
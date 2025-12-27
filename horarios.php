<?php
include('conexion.php');

// Crear horario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['crear'])) {
    $numero_usuario = $_POST['numero_usuario']; // Usar número de usuario
    $hora_entrada = $_POST['hora_entrada'];
    $hora_salida = $_POST['hora_salida'];
    $dia_semana = $_POST['dia_semana'];

    // Verificar si el número de usuario existe
    $sql_check = "SELECT id FROM usuarios WHERE numero_usuario = '$numero_usuario'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
        $usuario = $result_check->fetch_assoc();
        $usuario_id = $usuario['id'];

        $sql = "INSERT INTO horarios (usuario_id, hora_entrada, hora_salida, dia_semana) 
                VALUES ('$usuario_id', '$hora_entrada', '$hora_salida', '$dia_semana')";

        if ($conn->query($sql) === TRUE) {
            echo "Horario creado exitosamente.";
        } else {
            echo "Error al crear el horario: " . $conn->error;
        }
    } else {
        echo "Error: El número de usuario no existe.";
    }
}

// Mostrar horarios
$sql = "SELECT horarios.id, usuarios.numero_usuario, horarios.hora_entrada, horarios.hora_salida, horarios.dia_semana 
        FROM horarios 
        INNER JOIN usuarios ON horarios.usuario_id = usuarios.id";
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
    <title>Gestión de Horarios</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Gestión de Horarios</h2>

    <!-- Formulario para crear horarios -->
    <form action="horarios.php" method="POST">
        <input type="number" name="numero_usuario" placeholder="Número de Usuario" required><br>
        <input type="time" name="hora_entrada" required><br>
        <input type="time" name="hora_salida" required><br>
        <select name="dia_semana" required>
            <option value="lunes">Lunes</option>
            <option value="martes">Martes</option>
            <option value="miércoles">Miércoles</option>
            <option value="jueves">Jueves</option>
            <option value="viernes">Viernes</option>
        </select><br>
        <button type="submit" name="crear">Crear Horario</button>
    </form>

    <h3>Lista de Horarios</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Número de Usuario</th>
                <th>Hora Entrada</th>
                <th>Hora Salida</th>
                <th>Día</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['numero_usuario']; ?></td>
                        <td><?php echo $row['hora_entrada']; ?></td>
                        <td><?php echo $row['hora_salida']; ?></td>
                        <td><?php echo $row['dia_semana']; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No hay horarios registrados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>

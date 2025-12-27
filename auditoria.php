<?php
include('conexion.php');

// Registrar acción de auditoría
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['registrar'])) {
    $numero_usuario = $_POST['numero_usuario']; // Usar número de usuario
    $accion = $_POST['accion'];
    $detalles = $_POST['detalles'];

    // Verificar si el número de usuario existe
    $sql_check = "SELECT id FROM usuarios WHERE numero_usuario = '$numero_usuario'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
        $usuario = $result_check->fetch_assoc();
        $usuario_id = $usuario['id'];

        $sql = "INSERT INTO auditoria (usuario_id, accion, detalles) 
                VALUES ('$usuario_id', '$accion', '$detalles')";

        if ($conn->query($sql) === TRUE) {
            echo "Acción registrada.";
        } else {
            echo "Error al registrar acción: " . $conn->error;
        } 
    } else {
        echo "Error: El número de usuario no existe.";
    }
}

// Mostrar auditoría
$sql = "SELECT auditoria.id, usuarios.numero_usuario, auditoria.accion, auditoria.detalles 
        FROM auditoria 
        INNER JOIN usuarios ON auditoria.usuario_id = usuarios.id";
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
    <title>Auditoría de Acciones</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Auditoría de Acciones</h2>

    <!-- Formulario para registrar acción -->
    <form action="auditoria.php" method="POST">
        <input type="number" name="numero_usuario" placeholder="Número de Usuario" required><br>
        <input type="text" name="accion" placeholder="Acción" required><br>
        <textarea name="detalles" placeholder="Detalles" required></textarea><br>
        <button type="submit" name="registrar">Registrar Acción</button>
    </form>

    <h3>Registro de Acciones</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Número de Usuario</th>
                <th>Acción</th>
                <th>Detalles</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['numero_usuario']; ?></td>
                        <td><?php echo $row['accion']; ?></td>
                        <td><?php echo $row['detalles']; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No hay acciones registradas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>

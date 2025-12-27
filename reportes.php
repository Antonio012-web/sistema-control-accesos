<?php
include('conexion.php');

// Crear reporte
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['generar'])) {
    $tipo_reporte = $_POST['tipo_reporte'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    $numero_usuario = $_POST['numero_usuario']; // Usar numero_usuario en lugar de usuario_id

    // Verificar si el numero_usuario existe en la tabla usuarios
    $sql_check = "SELECT numero_usuario FROM usuarios WHERE numero_usuario = '$numero_usuario'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
        // El numero_usuario existe, proceder con la inserción
        $sql = "INSERT INTO reportes (tipo_reporte, fecha_inicio, fecha_fin, usuario_id)
                VALUES ('$tipo_reporte', '$fecha_inicio', '$fecha_fin', '$numero_usuario')";

        if ($conn->query($sql) === TRUE) {
            echo "Reporte generado exitosamente.";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        // El numero_usuario no existe
        echo "Error: El número de usuario no existe.";
    }
}

// Mostrar reportes
$sql = "SELECT * FROM reportes";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generación de Reportes</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Generación de Reportes</h2>

    <!-- Formulario para generar reportes -->
    <form action="reportes.php" method="POST">
        <select name="tipo_reporte" required>
            <option value="entrada">Entrada</option>
            <option value="salida">Salida</option>
            <option value="tardanza">Tardanza</option>
        </select><br>
        <input type="date" name="fecha_inicio" required><br>
        <input type="date" name="fecha_fin" required><br>
        <input type="text" name="numero_usuario" placeholder="Número de Usuario" required><br>
        <button type="submit" name="generar">Generar Reporte</button>
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>Tipo de Reporte</th>
            <th>Fecha Inicio</th>
            <th>Fecha Fin</th>
            <th>Número de Usuario</th>
        </tr>
        <?php while($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['tipo_reporte']; ?></td>
                <td><?php echo $row['fecha_inicio']; ?></td>
                <td><?php echo $row['fecha_fin']; ?></td>
                <td><?php echo $row['usuario_id']; ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>

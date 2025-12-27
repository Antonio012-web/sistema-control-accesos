<?php
include('conexion.php');

// Crear rol
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['crear'])) {
    $nombre_rol = $_POST['nombre_rol'];
    $descripcion = $_POST['descripcion'];

    $sql = "INSERT INTO roles (nombre_rol, descripcion) 
            VALUES ('$nombre_rol', '$descripcion')";

    if ($conn->query($sql) === TRUE) {
        echo "Rol creado exitosamente.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Mostrar roles
$sql = "SELECT * FROM roles";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Roles</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Gestión de Roles</h2>

    <!-- Formulario para agregar roles -->
    <form action="roles.php" method="POST">
        <input type="text" name="nombre_rol" placeholder="Nombre del Rol" required><br>
        <textarea name="descripcion" placeholder="Descripción" required></textarea><br>
        <button type="submit" name="crear">Crear Rol</button>
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre del Rol</th>
            <th>Descripción</th>
        </tr>
        <?php while($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nombre_rol']; ?></td>
                <td><?php echo $row['descripcion']; ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>

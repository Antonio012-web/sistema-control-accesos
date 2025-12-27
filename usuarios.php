<?php
include('conexion.php');

// Crear usuario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['crear'])) {
    $nombre = $_POST['nombre'];
    $numero_usuario = $_POST['numero_usuario'];
    $tipo_usuario = $_POST['tipo_usuario'];
    $clave_acceso = password_hash($_POST['clave_acceso'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nombre, numero_usuario, tipo_usuario, clave_acceso) 
            VALUES ('$nombre', '$numero_usuario', '$tipo_usuario', '$clave_acceso')";

    if ($conn->query($sql) === TRUE) {
        echo "Usuario creado exitosamente.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Mostrar usuarios
$sql = "SELECT numero_usuario, nombre, tipo_usuario FROM usuarios";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Gestión de Usuarios</h2>

    <!-- Formulario para agregar usuarios -->
    <form action="usuarios.php" method="POST">
        <input type="text" name="nombre" placeholder="Nombre" required><br>
        <input type="text" name="numero_usuario" placeholder="Número de Usuario" required><br>
        <select name="tipo_usuario" required>
            <option value="alumno">Alumno</option>
            <option value="maestro">Maestro</option>
        </select><br>
        <input type="password" name="clave_acceso" placeholder="Clave de acceso" required><br>
        <button type="submit" name="crear">Crear Usuario</button>
    </form>

    <h3>Lista de Usuarios</h3>
    <table>
        <tr>
            <th>Número de Usuario</th>
            <th>Nombre</th>
            <th>Tipo</th>
            <th>Acción</th>
        </tr>
        <?php while($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['numero_usuario']; ?></td>
                <td><?php echo $row['nombre']; ?></td>
                <td><?php echo $row['tipo_usuario']; ?></td>
                <td><a href="eliminar_usuario.php?numero_usuario=<?php echo $row['numero_usuario']; ?>">Eliminar</a></td>
            </tr>
        <?php } ?>
    </table>

    <script src="usuarios.js"></script>
</body>
</html>

<?php
include('conexion.php');

// Verificar si se ha recibido un ID de registro
if (isset($_GET['id'])) {
    $registro_id = $_GET['id'];

    // Consulta SQL para eliminar el registro
    $sql = "DELETE FROM registros WHERE id = '$registro_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Registro eliminado exitosamente.";
    } else {
        echo "Error al eliminar el registro: " . $conn->error;
    }

    // Redirigir de nuevo a la página principal
    header('Location: registros.php');
}
?>

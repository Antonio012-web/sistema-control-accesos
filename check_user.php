<?php
include 'conexion.php';

if (isset($_POST['numero_usuario'])) {
    $numero_usuario = $_POST['numero_usuario'];

    // Consulta para verificar si hay una entrada registrada y no tiene salida
    $sql = "SELECT * FROM registros WHERE numero_usuario = '$numero_usuario' AND fecha_salida IS NULL";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // El usuario tiene una entrada registrada pero no salida
        echo 'salir';
    } else {
        // El usuario no tiene una entrada registrada
        echo 'entrar';
    }

    $conn->close();
}
?>

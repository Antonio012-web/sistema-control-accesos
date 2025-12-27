<?php
session_start();
include 'conexion.php';

// Establecer la zona horaria correcta si aún no lo has hecho en PHP
date_default_timezone_set('America/Mexico_City');  // Configura la zona horaria de México

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numero_usuario = $_POST['numero_usuario'];  // Obtener el número de usuario ingresado
    $accion = $_POST['accion'];  // Obtener la acción (entrar o salir)
    $fecha_actual = date('Y-m-d H:i:s');  // Formato: '2024-12-07 15:52:41'

    if ($accion == 'entrar') {
        // Registrar entrada con el número de usuario
        $sql = "INSERT INTO registros (numero_usuario, fecha_entrada) VALUES ('$numero_usuario', '$fecha_actual')";

        if ($conn->query($sql) === TRUE) {
            // Mensaje de éxito para entrada
            $_SESSION['mensaje'] = 'Entrada exitosa.';
            $_SESSION['tipo'] = 'exito';
        } else {
            // Mensaje de error para entrada
            $_SESSION['mensaje'] = 'Error al registrar la entrada: ' . $conn->error;
            $_SESSION['tipo'] = 'error';
        }
    } elseif ($accion == 'salir') {
        // Verificar si el usuario tiene una entrada registrada antes de registrar la salida
        $sql_verificar = "SELECT * FROM registros WHERE numero_usuario = '$numero_usuario' AND fecha_salida IS NULL";
        $result_verificar = $conn->query($sql_verificar);

        if ($result_verificar->num_rows > 0) {
            // Si tiene una entrada registrada, registrar la salida
            $sql = "UPDATE registros SET fecha_salida = '$fecha_actual' WHERE numero_usuario = '$numero_usuario' AND fecha_salida IS NULL";

            if ($conn->query($sql) === TRUE) {
                // Mensaje de éxito para salida
                $_SESSION['mensaje'] = 'Salida exitosa.';
                $_SESSION['tipo'] = 'exito';
            } else {
                // Mensaje de error para salida
                $_SESSION['mensaje'] = 'Error al registrar la salida: ' . $conn->error;
                $_SESSION['tipo'] = 'error';
            }
        } else {
            // Si no tiene una entrada registrada, mostrar error
            $_SESSION['mensaje'] = 'No se puede registrar la salida, ya que no tiene entrada registrada.';
            $_SESSION['tipo'] = 'error';
        }
    }

    $conn->close();

    // Redirigimos a index.php para mostrar el mensaje
    header("Location: index.php");
    exit();
}
?>

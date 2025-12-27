<?php
session_start();
include 'conexion.php';

$numero_usuario = '';  // Variable para el número de usuario
$boton_texto = 'Registrar Entrada';  // Texto del botón por defecto

// Verificar si se ha enviado un número de usuario
if (isset($_POST['numero_usuario'])) {
    $numero_usuario = $_POST['numero_usuario'];

    // Consultar si ya hay una entrada registrada para este número de usuario
    $sql = "SELECT * FROM registros WHERE numero_usuario = '$numero_usuario' AND fecha_salida IS NULL";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Si hay una entrada registrada pero no una salida, mostrar "Registrar Salida"
        $boton_texto = 'Registrar Salida';
    } else {
        // Si no hay una entrada registrada, mostrar "Registrar Entrada"
        $boton_texto = 'Registrar Entrada';
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Entrada y Salida</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        
    </script>
</head>
<body>
    <div class="container">
        <h1>Registro de Entrada y Salida</h1>

        <!-- Mostrar alerta si existe en la sesión -->
        <?php
        if (isset($_SESSION['mensaje'])) {
            echo '<div id="alerta" class="alerta ' . $_SESSION['tipo'] . '">' . $_SESSION['mensaje'] . '</div>';
            // Limpiar la sesión para no mostrar el mensaje en futuras visitas
            unset($_SESSION['mensaje']);
            unset($_SESSION['tipo']);
        }
        ?>

        <form action="procesar.php" method="POST">
            <label for="numero_usuario">Número de Usuario:</label>
            <input type="number" id="numero_usuario" name="numero_usuario" required minlength="5" maxlength="5" min="10000" max="99999" placeholder="Ingrese su ID de usuario" pattern="\d{5}" value="<?php echo $numero_usuario; ?>">

            <!-- Botón dinámico con el id para cambiarlo con JS -->
            <button type="submit" id="boton_registro" name="accion" value="entrar">
                <?php echo $boton_texto; ?>
            </button>

            <!-- Campo oculto para manejar la acción (entrada o salida) -->
            <input type="hidden" id="accion" name="accion" value="entrar">
        </form>
    </div>

    <script src="script.js"></script>
</body>
</html>

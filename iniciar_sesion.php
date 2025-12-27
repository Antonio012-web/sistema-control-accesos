<?php
session_start();
include_once 'conexion.php'; // tu archivo que crea $conn

// Opcional: activa esto temporalmente solo si necesitas ver errores en pantalla
// ini_set('display_errors', 1); error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['iniciar_sesion'])) {
    $numero_usuario = trim($_POST['numero_usuario'] ?? '');
    $clave_acceso = $_POST['clave_acceso'] ?? '';

    if ($numero_usuario === '' || $clave_acceso === '') {
        $msg = "Rellena todos los campos.";
    } else {
        if (!isset($conn) || !$conn) {
            error_log("Conexión MySQL no encontrada. Comprueba conexion.php");
            $msg = "Error de conexión. Contacta al administrador.";
        } else {
            // Prepara la consulta
            $stmt = $conn->prepare("SELECT id, nombre, clave_acceso FROM usuarios WHERE numero_usuario = ? LIMIT 1");
            if (!$stmt) {
                error_log("Prepare failed en iniciar_sesion.php: " . $conn->error);
                $msg = "Error del servidor. Intenta más tarde.";
            } else {
                $stmt->bind_param("s", $numero_usuario);
                $stmt->execute();
                $res = $stmt->get_result();

                if ($res && $user = $res->fetch_assoc()) {
                    // Opcional: para depuración (no dejar activo en producción)
                    // error_log("Hash en BD para $numero_usuario: " . $user['clave_acceso']);

                    if (password_verify($clave_acceso, $user['clave_acceso'])) {
                        // Login OK
                        session_regenerate_id(true);
                        $_SESSION['usuario_id'] = $user['id'];
                        $_SESSION['usuario'] = $user['nombre'];
                        // Redirige a panel o la página que quieras
                        header("Location: panel.php");
                        exit();
                    } else {
                        $msg = "Número de usuario o contraseña incorrectos.";
                    }
                } else {
                    $msg = "Número de usuario o contraseña incorrectos.";
                }
                $stmt->close();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Iniciar Sesión</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <h1>Iniciar Sesión</h1>

  <?php if (!empty($msg)): ?>
    <div style="color:red; margin-bottom: 12px;"><?= htmlspecialchars($msg) ?></div>
  <?php endif; ?>

  <form action="iniciar_sesion.php" method="post">
    <input type="text" name="numero_usuario" placeholder="Número de usuario" required>
    <input type="password" name="clave_acceso" placeholder="Contraseña" required>
    <button type="submit" name="iniciar_sesion">Iniciar Sesión</button>
  </form>
</body>
</html>

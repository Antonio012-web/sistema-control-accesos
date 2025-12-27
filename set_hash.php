<?php
include 'conexion.php'; // usa $conn
$numero = '1001';            // cambia si corresponde
$plain_password = '123456';  // contraseña que quieras

$hash = password_hash($plain_password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("UPDATE usuarios SET clave_acceso = ? WHERE numero_usuario = ?");
$stmt->bind_param("ss", $hash, $numero);
if ($stmt->execute()) {
    echo "Hash actualizado para $numero. (Bórralo cuando termines)";
} else {
    echo "Error: " . $conn->error;
}
$stmt->close();
?>

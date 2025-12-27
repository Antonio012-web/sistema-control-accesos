<?php
$hash = '$2y$10$2q1rR2hYwgd0CQpZK0sY8e1OB1p5MNDoAuCEi0aKBslZx2drXr/6W'; // pega aquí el valor real de clave_acceso que viste en la BD
$password = '123456'; // la contraseña que quieres probar

if (password_verify($password, $hash)) {
    echo "password_verify: ¡Coincide!";
} else {
    echo "password_verify: NO coincide.";
}

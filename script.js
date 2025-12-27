
// Función para cambiar el botón de acuerdo al número de usuario
$(document).ready(function() {
    $("#numero_usuario").on("input", function() {
        var numero_usuario = $(this).val();

        if (numero_usuario.length == 5) {  // Solo realizar la consulta si el número tiene 5 dígitos
            $.ajax({
                url: 'check_user.php',
                method: 'POST',
                data: {numero_usuario: numero_usuario},
                success: function(response) {
                    if (response == 'salir') {
                        $("#boton_registro").text("Registrar Salida");
                        $("#accion").val("salir");
                    } else {
                        $("#boton_registro").text("Registrar Entrada");
                        $("#accion").val("entrar");
                    }
                }
            });
        }
    });

    // Desaparecer la alerta después de 5 segundos
    setTimeout(function() {
        $('#alerta').fadeOut();
    }, 5000); // 5000 milisegundos = 5 segundos
});
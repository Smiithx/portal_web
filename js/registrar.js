$(function(){
    var boton = $("#registrar");
    var formulario = $("#form-registro");
    var alerta = $(".alerta");
    var alerta_contenido = $(".alerta .alerta_wrapper");
    var close = $(".close");

    close.on("click",function(){
        alerta.css({display: 'none'});
    });

    boton.on('click',function(e){
        e.preventDefault();
        alerta.css({display: 'none'});
        var datos = new FormData(formulario);
        datos = JSON.stringify(datos);
        var url = '/proyectos/portal_web/admin/usuario_registrar.php';
        console.log(datos);
        $.ajax({
            type: "POST",
            url: url,
            data: datos,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function(respuesta){
                console.log("antes: " +respuesta);
                respuesta = respuesta.parse(respuesta);
                console.log("despues: " + respuesta);
                if(respuesta.error){
                    alerta.css({display: 'block'});
                    alerta_contenido.html(respuesta.error);
                    console.log(respuesta.error);
                }
                /*if(respuesta.success){
                    if(respuesta.registroPublico){
                        var cuerpo = "<h2>Saludos "+ respuesta.nombre +"</h2><img class='img-responsive col-centrar' src='"+ respuesta.rutaSubida +"' alt='Imagen de perfil'><p>Te has registrado correctamente, por favor dale click al botón de abajo para ir a la página de inicio.</p><a href='index.php' class='btn btn-primary'>Login</a>";
                        $("#container-principal").html(cuerpo);
                    }
                }*/
                if(respuesta.test){
                    alerta.css({display: 'block'});
                    alerta_contenido.html(respuesta.test);
                    console.log(respuesta.test);
                    alerta.focus();
                }
            },
            error: function(e){
                alerta.css({display: 'block'});
                alerta_contenido.html(e.responseText);
                console.log(e);
                alerta.focus();
            }
        });
    });
});
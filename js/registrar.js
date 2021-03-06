$(function(){
    var btn_registrar = $("#registrar");
    var formulario = $("#form-registro");
    var alerta = $(".alerta");
    var alerta_contenido = $(".alerta .alerta_wrapper");
    var close = $(".close");
    var foto = $("#foto");

    close.on("click",function(){
        alerta.css({display: 'none'});
    });

    btn_registrar.on('click',function(e){
        e.preventDefault();
        alerta.css({display: 'none'});
        var datos = new FormData(document.getElementById("form-registro"));
        //datos.append("foto",foto.files[0]);
        var url = '/proyectos/portal_web/admin/usuario_registrar.php';
        //var url = '/proyectos/portal_web/test.php';
        console.log(datos);
        $.ajax({
            type: "POST",
            url: url,
            data: datos,
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,
            success: function(respuesta){
                console.log(respuesta);
                if(respuesta.success){
                    if(respuesta.registroPublico){
                        var cuerpo = "<h2>Saludos "+ respuesta.nombre +"</h2><img class='img-responsive col-centrar' src='"+ respuesta.rutaSubida +"' alt='Imagen de perfil'><p>Te has registrado correctamente, por favor dale click al boton de abajo para ir a la pagina de inicio.</p><a href='index.php' class='btn btn-primary'>Login</a>";
                        $(".container-principal").html(cuerpo);
                    }
                }else{
                    alerta.css({display: 'block'});
                    alerta_contenido.html(respuesta.error);
                    console.log(respuesta.error);
                }
            },
            error: function(e){
                alerta.css({display: 'block'});
                alerta_contenido.html(e.responseText);
                console.log("error: ");
                console.log(e.responseText);
                alerta.focus();
            }
        });
    });
});
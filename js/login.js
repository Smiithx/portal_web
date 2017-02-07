$(function(){
    var boton = $("#ingresar");
    var formulario = $("#formulario");
    var img = $(".cargador");
    var alerta = $(".alerta");
    var alerta_contenido = $(".alerta .alerta_wrapper");
    var close = $(".close");
    
    close.on("click",function(){
        alerta.css({display: 'none'});
    });
    
    boton.on('click',function(){
        var datos = formulario.serialize();
        var url = 'login.php';
        $.ajax({
            type: "POST",
            url: url,
            data: datos,
            dataType: "json",
            beforeSend: function(){
                img.css({display: 'block'});
            },
            complete: function(){
                img.css({display: 'none'});
            },
            success: function(respuesta){
                if(respuesta.error){
                    alerta.css({display: 'block'});
                    alerta_contenido.html(respuesta.tipoError);
                }
                if(respuesta.success){
                    $(location).attr('href',respuesta.url);
                }
            },
            error: function(e){
                alerta.css({display: 'block'});
                alerta_contenido.html(e.responseText);
                console.log(e);
            }
        });
    });
});
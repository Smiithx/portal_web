$(function(){
    var logout = $("#logout");

    logout.on("click",function(){
        $.ajax({
            type: "POST",
            url: "../logout.php",
            dataType: "html",
            success: function(respuesta){
                $(location).attr('href',"../index.php");
            },
            error: function(e){
                alerta.css({display: 'block'});
                alerta_contenido.html(e.responseText);
                console.log(e);
            }
        });
    });

});
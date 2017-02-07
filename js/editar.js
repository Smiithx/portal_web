$(function(){
    var modal_editar = $("#modal-editar");
    var form_actualizar = $("#form-actualizar");
    $('[data-toggle=tooltip]').tooltip();
    $(document).on("click","#eliminar",function(e){
        e.preventDefault();
        var id = $(this).parent().parent().attr('data-id');
        $("#modal-confir").modal("show");
        $("#confir-eliminar").attr("data-id",id);
    });
    $(document).on("click","#editar",function(e){
        e.preventDefault();
        var id = $(this).parent().parent().attr('data-id');
        modal_editar.modal("show");
        $.ajax({
            type: "POST",
            url: "info.php",
            data: "data-id="+id,
            dataType: "json",
            success: function(res){
                $("#nombre").attr("placeholder",res.nombre);
                $("#apellido").attr("placeholder",res.apellido);
                $("#email").attr("placeholder",res.email);
                $("#telefono").attr("placeholder",res.telefono);
                $("#direccion").attr("placeholder",res.direccion);
                $("#edad").attr("placeholder",res.edad);
                $("#id").attr("value",id);
            }
        });
    });
    var actualizar_confir = $("#actualizar-confir");
    var actualizar_cancel = $("#actualizar-cancel");
    var eliminar = $("#confir-eliminar");
    var cancel = $("#cancel-delete");
    var error_content = $("#modal-error-content");
    var error_modal = $("#modal-error");
    eliminar.on("click",function(e){
        var id = eliminar.attr("data-id");
        $.ajax({
            type: "POST",
            url: "eliminar.php",
            data: "data-id="+id,
            dataType: "json",
            beforeSend: function(){
                $("#modal-confir").modal("hide");
            },
            success: function(respuesta){
                if(respuesta.estado === 'ok'){
                    $('tr[data-id='+id+']').css({
                        background: 'red',
                        color: 'white'
                    }).slideUp(1000);   
                }else{
                    error_modal.modal("show");
                    error_content.html(respuesta.msg);
                }                
            },
            error: function(e){
                error_modal.modal("show");
                error_content.html(e);
                console.log(e);
            }
        });
    }); 
    cancel.on("click",function(){
        $("#modal-confir").modal("hide");
    });
    actualizar_confir.on("click",function(e){
        e.preventDefault();
        var datos = form_actualizar.serialize();
        var url = 'actualizar.php';
        $.ajax({
            type: "POST",
            url: url,
            data: datos,
            dataType: "json",
            success: function(respuesta){
                if(respuesta.success){
                    modal_editar.modal("hide");
                }else{
                    error_modal.modal("show");
                    error_content.html(respuesta.msg);
                }
            },
            error: function(e){
                error_modal.modal("show");
                error_content.html(e);
                console.log(e);
            }
        });
    });
    actualizar_cancel.on("click",function(e){
        e.preventDefault();
        modal_editar.modal("hide");
    });
});
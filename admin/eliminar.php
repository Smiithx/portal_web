<?php 
require_once "../lib/config.php"; 
require_once "../lib/utilidades.php"; 
spl_autoload_register(function($clase){
    require_once "../lib/$clase.php";
});
$output = array();
if(isset($_POST['data-id'])){

    $eliminar = $_POST['data-id'];
    $db = new database(DB_HOST,DB_USER,DB_PASS,DB_NAME);
    $db->preparar("SELECT email FROM usuarios WHERE idUsuario = ?");
    $db->prep()->bind_param('i',$eliminar);
    $db->ejecutar();
    $db->prep()->bind_result($tmpEmail);
    $db->resultado();
    $db->liberar();

    $db->preparar("DELETE FROM usuarios WHERE idUsuario = ?");
    $db->prep()->bind_param('i',$eliminar);
    $db->ejecutar();
    if($db->filasAfectadas() > 0){
        $db->liberar();
        borrarCarpetas("fotos/$tmpEmail",1);
        $output = ["estado" => "ok", "msg" => "Eliminación correcta"];
    }else{
        $output = ["estado" => "fallido", "msg" => "Hubo un error inesperado, consulta con el administrador"];
    }
    $json = json_encode($output);
    echo $json;
    
}else{
    
}

?>
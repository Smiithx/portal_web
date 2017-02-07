<?php 
require_once "../lib/config.php"; 
require_once "../lib/utilidades.php"; 
spl_autoload_register(function($clase){
    require_once "../lib/$clase.php";
});
$info = new stdClass();
if(isset($_POST['data-id'])){

    $eID = $_POST['data-id'];
    $db = new database(DB_HOST,DB_USER,DB_PASS,DB_NAME);
    $db->preparar("SELECT nombre, apellido, email, telefono, direccion, edad FROM usuarios WHERE idUsuario = ?");
    $db->prep()->bind_param('i',$eID);
    $db->ejecutar();
    $db->prep()->bind_result($enombre, $eapellido, $eemail, $etelefono, $edireccion, $eedad);
    $db->resultado();
    $db->liberar();

    $info->nombre = $enombre;
    $info->apellido = $eapellido;
    $info->email = $eemail; 
    $info->telefono = $etelefono;
    $info->direccion = $edireccion;
    $info->edad = $eedad;

    echo json_encode($info);

}

?>
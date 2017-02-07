<?php  
require_once "lib/config.php"; 
session_start();

if($_POST){
    $output = array();
    spl_autoload_register(function($clase){
        require_once "lib/$clase.php";
    });
    // convierte array en variables
    extract($_POST, EXTR_OVERWRITE);
    if(!empty($email) && !empty($password)){
        $db = new database(DB_HOST,DB_USER,DB_PASS,DB_NAME);
        $expreg = "/^[_a-z0-9]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/";
        if(preg_match($expreg,$email)){
            $validarEmail = $db->validarDatos("email","usuarios",$email);
            if($validarEmail != 0){
                if(strlen($password) <= 72){
                    $db->preparar("SELECT idUsuario, CONCAT(nombre,' ', apellido) nombreCompleto, contrasena, email, rol FROM usuarios WHERE email = '$email'");
                    $db->ejecutar(); 
                    $db->prep()->bind_result($dbID, $dbNombre,$dbPassword,$dbEmail,$dbRol);
                    $db->resultado();
                    $hasher = new PasswordHash(8,FALSE);
                    if($hasher->CheckPassword($password,$dbPassword)){
                        switch($dbRol){
                            case "Administrador":
                                $output = ["success" => true, "url" => "admin/"]; 
                                $_SESSION["id"] = $dbID;
                                $_SESSION["nombre"] = $dbNombre;
                                $_SESSION["rol"] =$dbRol;
                                if($_POST["recordar"] == "true"){
                                    $expire = time()+365*24*60*60;
                                    setcookie("nombre",$_SESSION['nombre'],$expire);
                                    setcookie("id",$_SESSION['id'],$expire);
                                    setcookie("rol",$_SESSION['rol'],$expire);
                                }
                                $db->cerrar();
                                break;
                            case "Usuario": 
                                $output = ["error" => true, "tipoError" => "Pagina en construción."]; 
                                break;
                        }
                    }else{
                        $output = ["error" => true, "tipoError" => "Correo o contraseña incorrecta."]; 
                    }
                }else{
                    $output = ["error" => true, "tipoError" => "La contraseña es demasiado larga."];
                }
            }else{
                $output = ["error" => true, "tipoError" => "Este email no existe, por favor ingrese otro o registrese."];
            }
        }else{
            $output = ["error" => true, "tipoError" => "Email erroneo, por favor ingresa un email valido."];
        }
    }else{
        $output = ["error" => true, "tipoError" => "Los campos nombre, email, contraseña y confirmar contraseña no pueden estar vacios."];
    }
    $json = json_encode($output);
    echo $json;
}
?>
<?php
require_once "../lib/config.php"; 
require_once "../lib/utilidades.php"; 
spl_autoload_register(function($clase){
    require_once "../lib/$clase.php";
});
if($_POST){
    $output = new stdClass();
    // convierte array en variables
    extract($_POST, EXTR_OVERWRITE);
    if(!file_exists("../fotos")){
        mkdir("../fotos",0777);
    }


    $nombre = strtolower($nombre);
    if($nombre && $email && $password && $confirPassword){
        $output->test = '$nombre && $email && $password && $confirPassword';
        $db = new database(DB_HOST,DB_USER,DB_PASS,DB_NAME);
        $expreg = "/^[_a-z0-9]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/";
        if(preg_match($expreg,$email)){
            $output->test = 'if(preg_match($expreg,$email)){';
            if(strlen($password)>6){
                $output->test = 'if(strlen($password)>6){';
                if($password == $confirPassword){
                    $validarEmail = $db->validarDatos("email","usuarios",$email);
                    $output->test = '$validarEmail: '.$validarEmail;
                    if($validarEmail == 0){
                        $output->test = 'foto'.$_FILES["foto"]["name"];
                        $subirFoto = subirFoto($email,1);
                        //$output->test = '$subirFoto: '.$subirFoto.' | $rutaSubida: '.$rutaSubida;
                        if($subirFoto === TRUE){
                            /*
                            $output->test = "subirFoto: true";
                            /*$hasher = new PasswordHash(8,FALSE);
                            $hash = $hasher->HashPassword($password);
                            if(isset($rol)){
                                if($consulta = ($db->preparar("INSERT INTO usuarios VALUES (NULL,'$nombre','$apellido','$email','$hash',$cedula,$telefono,'$direccion',$edad,'$ciudad','$departamento',$codPostal,'$rutaSubida',".time().",'$rol')")) === true){
                                    $db->ejecutar();
                                    $db->liberar();
                                    $output->success = true;
                                    $output->nombre = ucwords($nombre);
                                    $output->rutaSubida = $rutaSubida;
                                }else{
                                    $output->error =$consulta;
                                }
                            }else{
                                if($consulta = ($db->preparar("INSERT INTO usuarios VALUES (NULL,'$nombre','$apellido','$email','$hash',$cedula,$telefono,'$direccion',$edad,'$ciudad','$departamento',$codPostal,'$rutaSubida',".time().",'Usuario')")) === true){
                                    $db->ejecutar();
                                    $db->liberar();
                                    $output->success = true;
                                    $output->nombre = ucwords($nombre);
                                    $output->rutaSubida = $rutaSubida;
                                    $output->registroPublico = true;
                                }else{
                                    $output->error =$consulta;
                                }    
                            }*/
                        }else{
                            $output->error = '$subirFoto: error';
                        }
                    }else{
                        $output->error = "Ese email ya esta registrado. prueba con otro";
                    }
                }else{
                    $output->error = "Las contraseñas no coinciden";
                }
            }else{
                $output->error = "La contraseña debe ser mayor a 6 caracteres";
            }
        }else{
            $output->error = "Email erroneo, por favor ingresa un email valido";
        }
    }else{
        $output->error = "Los campos nombre, email, contraseña y confirmar contraseña no pueden estar vacios.";
    }
    echo json_encode($output);
}

?>
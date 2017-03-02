<?php
error_reporting(0);
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


    $nombre = strtolower($nombre); // convierte el nombre en minusculas
    
    // Verifica que los campos principales no esten vacios
    if($nombre && $email && $password && $confirPassword){
        
        // crea la conexion a la base de datos
        $db = new database(DB_HOST,DB_USER,DB_PASS,DB_NAME);

       // Comprueba si la direccion de correo electronico es correcta 
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            
            // Verifica que la contraseña tenga mas de seis caracteres.
            if(strlen($password)>6){
                
                // verifica que ambos campos de contraseña coincidan
                if($password == $confirPassword){
                    
                    // Verifica que la direccion de correo electronico no se encuentre registrada
                    $validarEmail = $db->validarDatos("email","usuarios",$email);

                    if($validarEmail == 0){
                        
                        // Depurando
                        $subirFoto = subirFoto($email,1);
                        
                        if($subirFoto === TRUE){
                            
                            $hasher = new PasswordHash(8,FALSE);
                            $hash = $hasher->HashPassword($password);
                            if(isset($rol)){
                                if($consulta = ($db->preparar("INSERT INTO usuarios VALUES (NULL,'$nombre','$apellido','$email','$hash',$cedula,$telefono,'$direccion',$edad,'$ciudad','$departamento',$codPostal,'$rutaSubida',".time().",'$rol')")) === true){
                                    $db->ejecutar();
                                    $db->liberar();
                                    $output->success = true;
                                    $output->nombre = ucwords($nombre);
                                    $output->rutaSubida = $rutaSubida;
                                }else{
                                    $output->error = $consulta;
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
                                    $output->error = $consulta;
                                }    
                            }
                        }else{
                            $output->error = "Error: ".$error;
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
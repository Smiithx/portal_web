<?php 
require_once "../lib/config.php"; 
require_once "../lib/gestorErrores.php"; 
require_once "../lib/utilidades.php"; 
require_once "../inc/cabecera.php";
if($_POST["id"]){ 

    spl_autoload_register(function($clase){
        require_once "../lib/$clase.php";
    });
    $db = new database(DB_HOST,DB_USER,DB_PASS,DB_NAME);
    extract($_POST,EXTR_OVERWRITE);
    $db->preparar("SELECT nombre, apellido, email, telefono, direccion, edad FROM usuarios WHERE idUsuario = ?");
    $db->prep()->bind_param('i',$id);
    $db->ejecutar();
    $db->prep()->bind_result($enombre, $eapellido, $eemail, $etelefono, $edireccion, $eedad);
    $db->resultado();
    $db->liberar();
    if(empty($nombre)){
        $nombre = $enombre;
    }
    if(empty($apellido)){
        $apellido = $eapellido;
    }
    if(empty($email)){
        $email = $eemail;
    }
    if(empty($telefono)){
        $telefono = $etelefono;
    }
    if(empty($direccion)){
        $direccion = $edireccion;
    }
    if(empty($edad)){
        $edad = $eedad;
    }
    $ok = false;
    $expreg = "/^[_a-z0-9]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/";
    if(empty($password) && empty($confirPassword)){
        if(preg_match($expreg,$email)){
            if($email != $eemail){
                $validarEmail = $db->validarDatos("email","usuarios",$email);
                if($validarEmail == 0){
                    if(empty($_FILES['foto']['name'])){
                        if(cambiarDireccionImagen($email,$eemail,1)){
                            $db->preparar("UPDATE usuarios SET nombre = ?, apellido = ?, email = ?, telefono = ?, direccion = ?, edad = ?, imagen = ? WHERE idUsuario = ?");
                            $db->prep()->bind_param('sssisisi',$nombre,$apellido,$email,$telefono,$direccion,$edad,$rutaSubida,$id);
                            $db->ejecutar();
                            $db->liberar();
                            $ok = true;
                        }
                    }else{
                        if(cambiarDireccionImagen($email,$eemail,1)){
                            if(cambiarImagen($email, 1)){
                                $db->preparar("UPDATE usuarios SET nombre = ?, apellido = ?, email = ?, telefono = ?, direccion = ?, edad = ?, imagen = ? WHERE idUsuario = ?");
                                $db->prep()->bind_param('sssisisi',$nombre,$apellido,$email,$telefono,$direccion,$edad,$rutaSubida,$id);
                                $db->ejecutar();
                                $db->liberar();
                                $ok = true;
                            }
                        }
                    }
                }else{
                    trigger_error("Esta dirección de correo electronico ya se encuentra regisrada",E_USER_ERROR);
                }
            }else{
                if(empty($_FILES['foto']['name'])){
                    $db->preparar("UPDATE usuarios SET nombre = ?, apellido = ?, telefono = ?, direccion = ?, edad = ? WHERE idUsuario = ?");
                    $db->prep()->bind_param('ssisii',$nombre,$apellido,$telefono,$direccion,$edad,$id);
                    $db->ejecutar();
                    $db->liberar();
                    $ok = true;
                }else{
                    if(cambiarImagen($email,1)){
                        $db->preparar("UPDATE usuarios SET nombre = ?, apellido = ?, email = ?, telefono = ?, direccion = ?, edad = ?, imagen = ? WHERE idUsuario = ?");
                        $db->prep()->bind_param('ssisisi',$nombre,$apellido,$telefono,$direccion,$edad,$rutaSubida,$id);
                        $db->ejecutar();
                        $db->liberar();
                        $ok = true;
                    }    
                }
            }
        }else{
            trigger_error("Email erroneo, por favor ingresa un email valido",E_USER_ERROR);
        }
    }else{
        if(preg_match($expreg,$email)){
            if($email != $eemail){
                $validarEmail = $db->validarDatos("email","usuarios",$email);
                if($validarEmail == 0){
                    if(strlen($password)>6){
                        if($password == $confirPassword){
                            $hasher = new PasswordHash(8,FALSE);
                            $hash = $hasher->HashPassword($password);
                            if(empty($_FILES['foto']['name'])){
                                if(cambiarDireccionImagen($email,$eemail,1)){
                                    $db->preparar("UPDATE usuarios SET nombre = ?, apellido = ?, email = ?, contrasena = ?, telefono = ?, direccion = ?, edad = ?, imagen = ? WHERE idUsuario = ?");
                                    $db->prep()->bind_param('ssssisisi',$nombre,$apellido,$email, $hash,$telefono,$direccion,$edad,$rutaSubida,$id);
                                    $db->ejecutar();
                                    $db->liberar();
                                    $ok = true;
                                }
                            }else{
                                if(cambiarDireccionImagen($email,$eemail,1)){
                                    if(cambiarImagen($email, 1)){
                                        $db->preparar("UPDATE usuarios SET nombre = ?, apellido = ?, email = ?,contrasena = ?, telefono = ?, direccion = ?, edad = ?, imagen = ? WHERE idUsuario = ?");
                                        $db->prep()->bind_param('ssssisisi',$nombre,$apellido,$email,$hash,$telefono,$direccion,$edad,$rutaSubida,$id);
                                        $db->ejecutar();
                                        $db->liberar();
                                        $ok = true;
                                    }
                                }
                            }
                        }else{
                            trigger_error("Las contraseñas no coinciden",E_USER_ERROR);
                        }
                    }else{
                        trigger_error("La contraseña debe ser mayor a 6 caracteres",E_USER_ERROR);    
                    }
                }else{
                    trigger_error("Esta dirección de correo electronico ya se encuentra regisrada",E_USER_ERROR);
                }

            }else{
                if(strlen($password)>6){
                    if($password == $confirPassword){
                        $hasher = new PasswordHash(8,FALSE);
                        $hash = $hasher->HashPassword($password);
                        if(empty($_FILES['foto']['name'])){
                            $db->preparar("UPDATE usuarios SET nombre = ?, apellido = ?, contrasena = ?, telefono = ?, direccion = ?, edad = ? WHERE idUsuario = ?");
                            $db->prep()->bind_param('sssisii',$nombre,$apellido,$hash,$telefono,$direccion,$edad,$id);
                            $db->ejecutar();
                            $db->liberar();
                            $ok = true;
                        }else{
                            if(cambiarImagen($email,1)){
                                $db->preparar("UPDATE usuarios SET nombre = ?, apellido = ?, contrasena = ?, telefono = ?, direccion = ?, edad = ?, imagen = ? WHERE idUsuario = ?");
                                $db->prep()->bind_param('sssisisi',$nombre,$apellido,$hash,$telefono,$direccion,$edad,$rutaSubida,$id);
                                $db->ejecutar();
                                $db->liberar();
                                $ok = true;
                            }    
                        }
                    }else{
                        trigger_error("Las contraseñas no coinciden",E_USER_ERROR);
                    }
                }else{
                    trigger_error("La contraseña debe ser mayor a 6 caracteres",E_USER_ERROR);    
                }
            }
        }else{
            trigger_error("Email erroneo, por favor ingresa un email valido",E_USER_ERROR);
        }
    }
    if($ok):?>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-4 caja text-center col-centrar">
            <h4>Los datos han sidos actualizados exitosamente, serás redireccionado a la página de inicio en 5 seg.</h4>
        </div>
    </div>  
</div>
<?php
    endif;
    header("Refresh:5;url=editar.php?editar=$id");
}
?>
<?php

function subirFoto($nombre, $nivel = 0){
    global $dirSubida, $rutaSubida;    

    $origen = "";

    for($i = 1; $i <= $nivel; $i++){
        $origen .="../";  
    }
    $dirSubida = "{$origen}fotos/$nombre/";
    $foto = $_FILES["foto"];
    
    $nombreFoto = $foto["name"];
    $nombreTmp = $foto["tmp_name"];
    $rutaSubida = "{$dirSubida}profile.png";
    $extArchivo = preg_replace("/image\//","",$foto["type"]);
    return '$extArchivo: '+$extArchivo;
    
    if($extArchivo == "jpeg" || $extArchivo == "png" || $extArchivo == "jpg"){

        if(!file_exists($dirSubida)){
            mkdir($dirSubida,0777);
        }
        if(move_uploaded_file($nombreTmp,$rutaSubida)){
            $rutaSubida = "fotos/$nombre/profile.png";
            return true;
        }else{
            $error = "No se pudo mover el archivo";
        }
    }else{
        $error = "No es un formato de imagen valida";
    }
    return $error;
}

function cambiarImagen($nombre, $nivel = 0){
    $origen = "";
    for($i = 1; $i <= $nivel; $i++){
        $origen .="../"; 
    }
    $dir = "{$origen}fotos/$nombre";  
    $gestor = opendir($dir);
    while(false != ($archivo = readdir($gestor))){
        if($archivo != "." && $archivo != ".." && $archivo != "Thumbs.db" && $archivo != "desktop.ini"){
            unlink("$dir/$archivo");
        }
    }
    closedir($gestor);
    sleep(1);
    return subirFoto($nombre,$nivel);
}

function cambiarDireccionImagen($name, $oldName, $nivel = 0){
    global $rutaSubida;
    $origen = "";
    for($i = 1; $i <= $nivel; $i++){
        $origen .="../";  
    }
    $dir = "{$origen}fotos/$name";
    $oldDir = "{$origen}fotos/$oldName";
    if(rename($oldDir,$dir)){
        $rutaSubida = "fotos/$name/profile.png";
        return true;
    }else{
        trigger_error("Error al renombrar directorio",E_USER_ERROR);
        return false;
    }
}
function borrarCarpetas($dirBase, $nivel = 0){
    $origen = "";
    for($i = 1; $i <= $nivel; $i++){
        $origen .="../";  
    }
    $dir = "{$origen}$dirBase";
    $gestor = opendir($dir);
    while(false != ($archivo = readdir($gestor))){
        if($archivo != "." && $archivo != ".."){
            if(!unlink("$dir/$archivo")){
                borrarCarpetas("$dirBase/$archivo",$nivel);
            }
        }
    }
    closedir($gestor);
    rmdir($dir);
    sleep(1);
}
?>
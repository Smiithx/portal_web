<?php

/*
require 'lib/config.php';

try{
    $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexion exitosa!";
}catch(PDOException $e){
    echo "ERROR: " . $e->getMessage();
}
*/

$output = new stdClass();
extract($_POST, EXTR_OVERWRITE);
if(isset($_FILES['foto'])){
    $output->res = "I have foto";
    $output->name = "It name is: ".$_FILES['foto']['name'];
}else{
    $output->res = "I do not have foto";
}
echo json_encode($output);
<?php
session_start();
if(isset($_COOKIE['nombre'])){
    $time = time();
    $expire = $time-(24*60*60);
    setcookie("nombre",$_SESSION['nombre'],$expire);
    setcookie("id",$_SESSION['id'],$expire);
    setcookie("imagen",$_SESSION['imagen'],$expire);
}
session_unset();
session_destroy();
?>

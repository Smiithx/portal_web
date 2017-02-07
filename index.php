<?php 
session_start();
if((isset($_SESSION["nombre"]) && isset($_SESSION["id"]) && isset($_SESSION['rol']) ) || isset($_COOKIE["nombre"])){
    if(isset($_COOKIE["nombre"])){
        $_SESSION["id"] = $_COOKIE["id"];
        $_SESSION["nombre"] = $_COOKIE["nombre"];
        $_SESSION["rol"] = $_COOKIE["rol"];
    }
    if($_SESSION['rol'] == "Administrador"){
        header("location: admin/");
        exit();
    }
}
require "inc/cabecera.php"; 
?>
<script src="js/login.js"></script>
<div class="container-fluid container-principal">
    <div class="row">
        <div class="col-md-12 text-center">
            <h1>Portal web</h1>
        </div>
    </div>
    <div class='alerta alerta_error'>
        <div class='alerta_icon'>
            <i class='glyphicon glyphicon-remove-sign'></i>
        </div>
        <div class='alerta_wrapper'>
        </div>
        <a href='#' class='close err'><i class='glyphicon glyphicon-remove'></i></a>
    </div>
    <div class="row">
        <div class="col-sm-4 caja col-centrar">
            <form id="formulario" method="POST" role="form">
                <legend>Logueate <img src="img/cargador.gif" alt="loading.." class="cargador"></legend>

                <div class="form-group">                            
                    <input name="email" type="email" class="form-control" id="" placeholder="Correo electronico">
                </div>
                <div class="form-group">                            
                    <input name="password" type="password" class="form-control" id="" placeholder="Contraseña">
                </div>
                <button type="button" id="ingresar" class="btn btn-primary">Ingresar</button>

                <a href="registrarse.php" class="pull-right">Registrarse</a>
                &nbsp;
                <label for="recordar" class="checkbox-inline">
                    <input name="recordar" type="checkbox" value="true" id="recordar">Recuerdame
                </label>
            </form>
        </div>
    </div>  
</div>
<?php require "inc/footer.php"; ?>
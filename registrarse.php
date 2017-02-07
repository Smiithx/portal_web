<?php 
require "inc/cabecera.php"; 
?>
<script src="js/registrar.js"></script>
<div class="container-fluid container-principal">
    <div class="row">
        <div class="col-md-12 text-center">
            <h1>Portal web</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2 caja">
            <div class='alerta alerta_error'>
                <div class='alerta_icon'>
                    <i class='glyphicon glyphicon-remove-sign'></i>
                </div>
                <div class='alerta_wrapper'>
                </div>
                <a href='#' class='close err'><i class='glyphicon glyphicon-remove'></i></a>
            </div>
            <form id="form-registro" action="" enctype="multipart/form-data" method="POST" role="form">
                <legend>Registrate</legend>

                <div class="form-group">                            
                    <input type="text" name="nombre" class="form-control" id="" placeholder="Nombre" value="Neidalis">
                </div>
                <div class="form-group">                            
                    <input type="text" name="apellido" class="form-control" id="" placeholder="Apellidos" value="Urdaneta">
                </div>
                <div class="form-group">                            
                    <input name="email" type="email" class="form-control" id="" placeholder="Correo electronico" value="neidalisurdaneta@gmail.com">
                </div>
                <div class="form-group">                            
                    <input name="password" type="password" class="form-control" id="" placeholder="Contraseña" value="2637375846s">
                </div>
                <div class="form-group">                            
                    <input name="confirPassword" type="password" class="form-control" id="" placeholder="Confirmar contraseña" value="2637375846s">
                </div>
                <div class="form-group">                            
                    <input name="cedula" type="text" class="form-control" id="" placeholder="Cedula" value="19485129">
                </div>
                <div class="form-group">                            
                    <input name="telefono" type="text" class="form-control" id="" placeholder="Telefono" value="02612110011">
                </div>
                <div class="form-group">                            
                    <input name="direccion" type="text" class="form-control" id="" placeholder="Direccion" value="18 de octubre">
                </div>
                <div class="form-group">                            
                    <input name="ciudad" type="text" class="form-control" id="" placeholder="Ciudad" value="maracaibo">
                </div>
                <div class="form-group">                            
                    <input name="edad" type="text" class="form-control" id="" placeholder="Edad" value="25">
                </div>
                <div class="form-group">                            
                    <input name="departamento" type="text" class="form-control" id="" placeholder="Departamento" value="N/A">
                </div>
                <div class="form-group">                            
                    <input name="codPostal" type="text" class="form-control" id="" placeholder="Codigo Postal" value="4001">
                </div>
                <div class="form-group">                            
                    <label for="">Elija su foto de perfil</label>
                    <input name="foto" type="file" class="form-control" id=""/>
                </div>
                <button id="registrar" type="button" class="btn btn-primary">Registrarse</button>
                <a href="index.php" class="pull-right">Login</a>
            </form>
        </div>
    </div>  
</div>
<?php require "inc/footer.php"; ?>
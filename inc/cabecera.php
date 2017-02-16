<?php 
$dir = "http://".$_SERVER['HTTP_HOST'].":".$_SERVER['SERVER_PORT']."/portal_web/";
$archivoActual = $_SERVER["SCRIPT_NAME"];
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Portal</title>
        <script
        src="<?php echo $dir."js/jquery-3.1.1.js"?>"></script>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="<?php echo $dir."css/bootstrap.css"?>"/>

        <!-- Latest compiled and minified JavaScript -->
        <script src="<?php echo $dir."js/bootstrap.js"?>"></script>
        <link rel="stylesheet" href="<?php echo $dir."css/estilo.css"?>">
    </head>
    <body class="<?php if($archivoActual == "/portal_web/index.php" Or $archivoActual == "/portal_web/registrarse.php"){echo 'bg';} ?>"> 
        <?php 
        if($archivoActual != "/portal_web/index.php" && 
           $archivoActual != "/portal_web/registrarse.php" && 
           $archivoActual != "/portal_web/logout.php" && 
           $archivoActual != "/portal_web/login.php" && 
           $archivoActual != "/portal_web/admin/actualizar.php"):
        ?>
        <header>
            <a href="index.php" class="logo">
                <i class="glyphicon glyphicon-fire"></i>
                <span>Portal</span>
            </a>
            <nav class="navbar navbar-default navbar-fixed-top menu">
                <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <?php if($_SESSION['rol'] == "Administrador"): ?>
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <!--<li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>-->
                            <li><a href="#" class="mas"><i class="glyphicon glyphicon-plus-sign"></i></a></li>
                            <li><a href="../admin/editar.php" class="mas"><i class="glyphicon glyphicon-edit"></i></a></li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li id="logout"><a href="#">Cerrar Sesión &nbsp; <i class="glyphicon glyphicon-log-out"></i></a></li>
                        </ul>
                    </div>
                    <?php endif; ?>
                </div>
            </nav>
        </header>
        <?php endif; ?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Portal</title>
        <script
                src="https://code.jquery.com/jquery-3.1.1.min.js"
                integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
                crossorigin="anonymous"></script>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="/proyectos/portal_web/css/estilo.css">
    </head>
    <body class="<?php $archivoActual = $_SERVER["SCRIPT_NAME"]; if($archivoActual == "/proyectos/portal_web/index.php"){echo 'bg';} ?>"> 
        <?php         
        if($archivoActual != "/proyectos/portal_web/index.php" && 
           $archivoActual != "/proyectos/portal_web/registrarse.php" && 
           $archivoActual != "/proyectos/portal_web/logout.php" && 
           $archivoActual != "/proyectos/portal_web/login.php" && 
           $archivoActual != "/proyectos/portal_web/admin/actualizar.php"):
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
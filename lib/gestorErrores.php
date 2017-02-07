<?php
// función de gestión de errores
function miGestorDeErrores($errno, $errstr, $errfile, $errline)
{
    if (!(error_reporting() & $errno)) {
        // Este código de error no está incluido en error_reporting
        return;
    }

    switch ($errno) {
    case E_USER_ERROR:
            echo "<div class='alerta alerta_error'>
                    <div class='alerta_icon'>
                        <i class='glyphicon glyphicon-remove-sign'></i>
                    </div>
                    <div class='alerta_wrapper'>
                        Error: $errstr
                    </div>
                    <a href='#' class='close err'><i class='glyphicon glyphicon-remove'></i></a>
                </div>";
        //exit(1);
        break;

    case E_USER_WARNING:
        echo "<div class='alerta alerta_warning'>
                    <div class='alerta_icon'>
                        <i class='glyphicon glyphicon-warning-sign'></i>
                    </div>
                    <div class='alerta_wrapper'>
                        Error: $errstr
                    </div>
                    <a href='#' class='close err'><i class='glyphicon glyphicon-remove'></i></a>
                </div>";
        break;

    case E_USER_NOTICE:
        echo "<div class='alerta alerta_info'>
                    <div class='alerta_icon'>
                        <i class='glyphicon glyphicon-exclamation-sign'></i>
                    </div>
                    <div class='alerta_wrapper'>
                        $errstr
                    </div>
                    <a href='#' class='close err'><i class='glyphicon glyphicon-remove'></i></a>
                </div>";
        break;

    /*default:
        echo "Tipo de error desconocido: [$errno] $errstr<br />\n";
        break;*/
    }

    /* No ejecutar el gestor de errores interno de PHP */
    return true;
}
set_error_handler("miGestorDeErrores");
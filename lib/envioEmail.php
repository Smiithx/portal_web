<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Email</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <style>
            body{
                padding-top: 70px;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-4 col-sm-offset-4">

                    <?php 
                    if($_POST){
                        extract($_POST,EXTR_OVERWRITE);
                        $para = "smiith17@gmail.com";
                        $cabecera = "From: Desde la web <$para>\n";
                        $cabecera.= "MINE-Version: 1.0\n";
                        $cabecera.= "Content-Type: text/html; charset=utf8\n";
                        $msg = "
                        Nombre: $nombre \n
                        Asunto: $asunto \n
                        Telefono: $telefono \n
                        Email: $email \n
                        Fecha: ".date("d/m/y")." \n
                        Hora: ".date("h:i:s a")." \n
                        IP: ".$_SERVER["REMOTE_ADDR"]." \n
                        Mensaje: $mensaje \n
                        ";
                        $validar = mail($para,$asunto,$msg,$cabecera);
                    }
                    if(isset($validar)):
                        if($validar){
                            echo "El correo fue enviado exitosamente";
                        }else{
                            echo "Hubo un error al enviar el mensaje, por favor intentelo más tarde";
                        }
                    else:
                    ?>

                    <form action="" method="POST" role="form">
                        <legend>Enviar email</legend>
                        <div class="form-group">
                            <label for="nombre"></label>
                            <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre">
                        </div>
                        <div class="form-group">
                            <label for="asunto"></label>
                            <input type="text" id="asunto" name="asunto" class="form-control" placeholder="Assunto">
                        </div>
                        <div class="form-group">
                            <label for="telefono"></label>
                            <input type="text" id="telefono" name="telefono" class="form-control" placeholder="Teléfono">
                        </div>
                        <div class="form-group">
                            <label for="email"></label>
                            <input type="text" id="email" name="email" class="form-control" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label for="mensaje"></label>
                            <textarea type="text" id="mensaje" name="mensaje" class="form-control" placeholder="Mensaje" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </body>
</html>
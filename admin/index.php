<?php 
session_start();
if(!$_SESSION["id"] && !$_SESSION["nombre"] && $_SESSION['rol'] != "Administrador"){
    header("location: ../");
    exit();
}
require "../inc/cabecera.php"; 
require_once "../lib/config.php"; 
require_once "../lib/gestorErrores.php"; 
spl_autoload_register(function($clase){
    require_once "../lib/$clase.php";
});
$fecha = getdate();
$diaN = date("d") - 1;
$anio = date("Y");
$meses =["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Noviembre","Diciembre"];
$diaS = ["Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado"];
$dia2 = $diaS[$fecha['wday']-1];
$mes = $meses[$fecha["mon"]-1];

$db = new database(DB_HOST,DB_USER,DB_PASS,DB_NAME);

$db->preparar("SELECT CONCAT(nombre,' ', apellido) AS nombreCompleto, imagen FROM usuarios WHERE idUsuario = ?");
$db->prep()->bind_param('i',$_SESSION["id"]);
$db->ejecutar();
$db->prep()->bind_result($uNombre,$uImagen);
$db->resultado();
$db->liberar();

?>
<script src="../js/sesion.js"></script>
<div class="izq">
    <div class="perfil">
        <img class="img-responsive img-circle" src='<?php echo "../$uImagen"; ?>' alt="profile.jpg">
    </div>
    <div class="nombre">
        <h4 class="text-center"><?php echo ucwords($uNombre); ?></h4>
    </div>
</div>
<div class="der">
    <div class="container-fluid">
        <div class="cabecera-pagina">
            <h1 class="titulo-pagina">
                Administración
                <small>Bienvenido a la administración del portal</small>
            </h1>
            <div class="fecha pull-right">
                <i class="glyphicon glyphicon-calendar"></i>
                <span><?php echo "$mes $diaN, $anio - $dia2"; ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="panel">
                    <div class="icono bg-rojo">
                        <i class="glyphicon glyphicon-user"></i>
                    </div>
                    <div class="valor">
                        <h1 class="cantidad">
                            <?php
                            $db->preparar("SELECT COUNT(idUsuario) from usuarios");
                            $db->ejecutar();
                            $db->prep()->bind_result($cantUsuarios);
                            $db->resultado();
                            $db->liberar();
                            echo $cantUsuarios;
                            ?>
                        </h1>
                        <p>usuarios</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="panel">
                    <div class="icono bg-azul">
                        <i class="glyphicon glyphicon-user"></i>
                    </div>
                    <div class="valor">
                        <h1 class="cantidad"><?php echo $cantUsuarios; ?></h1>
                        <p>usuarios</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="panel">
                    <div class="icono bg-verde">
                        <i class="glyphicon glyphicon-user"></i>
                    </div>
                    <div class="valor">
                        <h1 class="cantidad"><?php echo $cantUsuarios; ?></h1>
                        <p>usuarios</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="panel">
                    <div class="icono bg-morado">
                        <i class="glyphicon glyphicon-user"></i>
                    </div>
                    <div class="valor">
                        <h1 class="cantidad"><?php echo $cantUsuarios; ?></h1>
                        <p>usuarios</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="caja">
                    <div class="caja-cabecera">
                        <h1>Ultimos usuarios registrados</h1>
                    </div>
                    <hr>
                    <div class="caja-cuerpo">
                        <table class="table table-cell">
                            <thead>
                                <tr>
                                    <th>Ref.</th>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Cédula</th>
                                    <th>Teléfono</th>
                                    <th>Dirección</th>
                                    <th>Edad</th>
                                    <th>Ciudad</th>
                                    <th>Departamento</th>
                                    <th>Codigo postal</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $db->preparar("SELECT CONCAT(nombre,' ', apellido) AS nombreCompleto, email, cedula, telefono, direccion, edad, ciudad, departamento, codigopostal, fecha FROM usuarios ORDER BY fecha DESC LIMIT 10");
                                $db->ejecutar(); 
                                $db->prep()->bind_result($dbNombre,$dbEmail,$dbCedula,$dbTelefono,$dbDireccion,$dbEdad,$dbCiudad,$dbDepartamento,$dbCodigoPostal,$dbFecha);
                                $count = 0;
                                while($db->resultado()){
                                    $count++;
                                    echo "<tr>
                                            <td>$count</td>
                                            <td>$dbNombre</td>
                                            <td>$dbEmail</td>
                                            <td>$dbCedula</td>
                                            <td>$dbTelefono</td>
                                            <td>$dbDireccion</td>
                                            <td>$dbEdad</td>
                                            <td>$dbCiudad</td>
                                            <td>$dbDepartamento</td>
                                            <td>$dbCodigoPostal</td>
                                            <td>".date('d/m/Y',$dbFecha)."</td>
                                        </tr>";
                                }
                                $db->liberar();
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>  
    </div>
</div>

<?php require "../inc/footer.php"; ?>
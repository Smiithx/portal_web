<?php 
session_start();
if(!$_SESSION["id"] && !$_SESSION["nombre"] && $_SESSION['rol'] != "Administrador"){
    header("location: ../");
    exit();
}
require "../inc/cabecera.php"; 
require_once "../lib/config.php"; 
require_once "../lib/gestorErrores.php"; 
require_once "../lib/utilidades.php"; 
spl_autoload_register(function($clase){
    require_once "../lib/$clase.php";
});
$fecha = getdate();
$diaN = date("d") - 1;
$anio = date("Y");
$meses =["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Noviembre","Diciembre"];
$diaS = ["Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado"];
$dia2 = $diaS[$fecha['wday'] - 1 ];
$mes = $meses[$fecha["mon"]-1];

$db = new database(DB_HOST,DB_USER,DB_PASS,DB_NAME);

$db->preparar("SELECT CONCAT(nombre,' ', apellido) nombreCompleto, imagen FROM usuarios WHERE idUsuario = ?");
$db->prep()->bind_param('i',$_SESSION["id"]);
$db->ejecutar();
$db->prep()->bind_result($uNombre,$uImagen);
$db->resultado();
$db->liberar();

?>
<script src="../js/sesion.js"></script>
<script src="../js/editar.js"></script>
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
            <div class="col-sm-12">
                <div class="caja">
                    <div class="caja-cabecera">
                        <h3><i class="glyphicon glyphicon-user"></i> Edita o elimina algún usuario</h3>
                        <div class="col-sm-4 pull-right">
                            <form action="" id="busqueda" method="GET">
                                <div class="input-group">
                                    <input  name="busqueda"type="text" class="form-control" placeholder="Search for...">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="submit">Search</button>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                    <hr>
                    <div class="caja-cuerpo">
                        <table class="table table-cell">
                            <thead>
                                <tr>
                                    <th>#</th>
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
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $porPagina = 5;
                                if(isset($_GET['busqueda']) && !empty($_GET['busqueda'])){
                                    $consulta = "SELECT idUsuario, CONCAT(nombre,' ', apellido) nombreCompleto, email, cedula, telefono, direccion, edad, ciudad, departamento, codigopostal, fecha FROM usuarios WHERE nombre LIKE ";
                                    $camposBusqueda = "";
                                    $busqueda = explode(" ",$_GET['busqueda']);
                                    for($i = 0; $i < count($busqueda); $i++){
                                        if($busqueda[$i] != ''){
                                            if($i != 0){
                                                $camposBusqueda .= ' OR nombre LIKE ';
                                            }
                                            $camposBusqueda .= " '%{$busqueda[$i]}%' ";
                                        }
                                    }
                                    $consulta .= $camposBusqueda;
                                    $consulBusqueda = "SELECT COUNT(idUsuario) FROM usuarios WHERE nombre LIKE $camposBusqueda";
                                    $db->preparar($consulBusqueda);
                                    $db->ejecutar(); 
                                    $db->prep()->bind_result($cUsuarios);
                                    $db->resultado();
                                    $db->liberar();
                                    $paginas = ceil($cUsuarios/$porPagina);
                                    $pagina = (isset($_GET['pagina'])) ? (int)$_GET['pagina'] : 1;
                                    $iniciar = ($pagina -1 ) * $porPagina;

                                    $consulta .=" ORDER BY fecha LIMIT $iniciar, $porPagina";

                                }else{
                                    $db->preparar("SELECT COUNT(idUsuario) FROM usuarios");
                                    $db->ejecutar(); 
                                    $db->prep()->bind_result($cUsuarios);
                                    $db->resultado();
                                    $db->liberar();
                                    $paginas = ceil($cUsuarios/$porPagina);
                                    $pagina = (isset($_GET['pagina'])) ? (int)$_GET['pagina'] : 1;
                                    $iniciar = ($pagina - 1 ) * $porPagina;

                                    $consulta = "SELECT idUsuario,CONCAT(nombre,' ', apellido) nombreCompleto, email, cedula, telefono, direccion, edad, ciudad, departamento, codigopostal, fecha FROM usuarios ORDER BY fecha LIMIT $iniciar,$porPagina";


                                }
                                $db->preparar($consulta);
                                $db->ejecutar(); 
                                $db->prep()->bind_result($dbIdUsuario,$dbNombre,$dbEmail,$dbCedula,$dbTelefono,$dbDireccion,$dbEdad,$dbCiudad,$dbDepartamento,$dbCodigoPostal,$dbFecha);

                                if(isset($_GET['busqueda'])){
                                    if($count > 1){
                                        echo "<h3>$count resultados encontrados</h3>";
                                    }elseif($count == 1){
                                        echo "<h3>$count resultado encontrado</h3>";
                                    }else{
                                        echo "<h3>No se encontraron resultados</h3>";
                                    }
                                }

                                $count = $iniciar;
                                while($db->resultado()){
                                    $count++;
                                    echo "<tr data-id='$dbIdUsuario'> 
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
                                            <td>
                                                <button id='editar' class='btn btn-success acciones' data-toggle='tooltip' title='Editar'><i class='glyphicon glyphicon-edit'></i></button>
                                                <button id='eliminar' class='btn btn-danger acciones' data-toggle='tooltip' title='Eliminar'><i class='glyphicon glyphicon-remove'></i></button>
                                            </td>
                                        </tr>";
                                }
                                $db->liberar();
                                ?>
                            </tbody>
                        </table>
                        <div id="modal-confir" class="modal fade bs-example-modal-sm ventana-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                            <div class="modal-dialog modal-sm" role="document">
                                <div class="modal-content">
                                    <div class="row">
                                        <div class="col-md-12">¿Seguro que deseas eliminarlo?</div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6"><button id="confir-eliminar" class="btn btn-danger">Si</button></div>
                                        <div class="col-md-6"><button id="cancel-delete" class="btn btn-info">No</button></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="modal-error" class="modal fade bs-example-modal-sm ventana-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                            <div class="modal-dialog modal-sm" role="document">
                                <div class="modal-content">
                                    <div class="row">
                                        <div id="modal-error-content" class="col-md-12"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="modal-editar" class="modal fade bs-example-modal-sm ventana-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="row">
                                        <div class="col-sm-12 col-centrar">
                                            <form id="form-actualizar" enctype="multipart/form-data" method="POST" role="form">
                                                <legend>Actualizar datos</legend>
                                                <div class="form-group">                            
                                                    <input type="text" name="nombre" class="form-control" id="nombre" placeholder="">
                                                </div>
                                                <div class="form-group">                            
                                                    <input type="text" name="apellido" class="form-control" id="apellido" placeholder="">
                                                </div>
                                                <div class="form-group">                            
                                                    <input name="email" type="email" class="form-control" id="email" placeholder="">
                                                </div>
                                                <div class="form-group">                            
                                                    <input name="password" type="password" class="form-control" id="" placeholder="Contraseña">
                                                </div>
                                                <div class="form-group">                            
                                                    <input name="confirPassword" type="password" class="form-control" id="" placeholder="Confirmar contraseña">
                                                </div>
                                                <div class="form-group">                            
                                                    <input name="telefono" type="text" class="form-control" id="telefono" placeholder="">
                                                </div>
                                                <div class="form-group">                            
                                                    <input name="direccion" type="text" class="form-control" id="direccion" placeholder="">
                                                </div>
                                                <div class="form-group">                            
                                                    <input name="edad" type="text" class="form-control" id="edad" placeholder="">
                                                </div>
                                                <div class="form-group">                            
                                                    <input name="id" type="hidden" class="form-control" id="id" value="">
                                                </div>
                                                <div class="form-group">                            
                                                    <label for="">Elija su foto de perfil</label>
                                                    <input name="foto" type="file" class="form-control" id=""/>
                                                </div>
                                                <button id="actualizar-confir" type="button" class="btn btn-primary">Actualizar</button>
                                                <button id="actualizar-cancel" type="button" class="btn">Cancelar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        $anterior = $pagina-1;
                        $siguiente = $pagina+1;
                        if(isset($_GET['busqueda'])){
                            $pagAnterior = "?pagina=$anterior&busqueda={$_GET['busqueda']}";
                            $pagSiguiente = "?pagina=$siguiente&busqueda={$_GET['busqueda']}";
                            $pagX = "&busqueda={$_GET['busqueda']}";
                        }else{
                            $pagAnterior = "?pagina=$anterior";                            
                            $pagSiguiente = "?pagina=$siguiente";
                            $pagX = "";
                        }
                        ?>
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                <?php if(!($pagina <=1)): ?>
                                <li>
                                    <a href='<?php echo "$pagAnterior" ?>' aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <?php endif;
                                       if($paginas> 1){
                                           for($x = 1; $x <= $paginas; $x++){
                                               $pagLink = "?pagina=$x".$pagX;
                                               echo ($x == $pagina) ? "<li class='active'><a href='$pagLink'>$x</a></li>" : "<li><a href='$pagLink'>$x</a></li>";
                                           }
                                       }
                                ?>
                                <?php if(!($pagina >= $paginas)): ?>
                                <li>
                                    <a href='<?php echo "$pagSiguiente" ?>' aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>  
    </div>
</div>

<?php require "../inc/footer.php"; ?>
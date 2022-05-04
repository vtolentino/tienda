<?php
session_start();
if($_SESSION["logueado"]==TRUE && $_SESSION["tipo"]==1){
    ?>
<!doctype html>
<html lang="en">
    <?php
        require("head.php");
    ?>
<div class="wrapper">
    <?php
        require("menu.php");
    ?>
    <div class="main-panel">
        <nav class="navbar navbar-default navbar-fixed">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">Usuarios</a>
                </div>
            </div>
        </nav>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <!-- <div class="header">
                                <h4 class="title">Agregar Usuario</h4>
                            </div> -->
                            <div class="content">
                                <form action="usuarios/add.php" method="post" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Usuario</label>
                                                <input type="text" name="usuario" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Contraseña</label>
                                                <input type="password" name="pwd" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tipo Usuario</label>
                                                <select class="form-control" name="tipo">
                                                    <option value="1">ADMIN</option>
                                                    <option value="2" selected>VENDEDOR</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Estado</label>
                                                <select class="form-control" name="estado">
                                                    <option value="0">Baja</option>
                                                    <option value="1" selected>Activo</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" name="enviar"
                                        class="btn btn-secondary btn-fill pull-right">Agregar</button>
                                    <div class="clearfix"></div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <?php                 
                                                if(isset($_GET["mensaje"])){
                                                    $mensaje=$_GET["mensaje"];
                                                    echo "  
                                                    <div class='alert alert-info'>
                                                        <center><a href='#' class='alert-link' >".$mensaje."</a></center>
                                                    </div>";
                                                }
                                                $_GET["mensaje"]='';
                                            ?>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Lista Usuarios</h4>
                                <?php                 
                                    if(isset($_GET["mensaje2"])){
                                        $mensaje2=$_GET["mensaje2"];
                                             echo "  
                                                <div class='alert alert-info'>
                                                    <center><a href='#' class='alert-link' >".$mensaje2."</a></center>
                                                </div>";
                                    }
                                ?>
                            </div>
                            <div class="content">
                                <form  method='GET'>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" name="buscador" class="form-control" placeholder="Introduce aquí el usuario que deseas buscar">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-secondary btn-fill pull-left">Buscar</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            
                                    
                            <div class="content table-full-width">
                                <table class="table table-hover table-striped">
                                    <thead>
                                    	<th>Usuario</th>
                                    	<th>Pwd</th>
                                    	<th>Tipo</th>
                                        <th>Estado</th>
                                        <th>Acción</th>
                                    </thead>
                                    <tbody>
                                    <?php
                                    require("../session/conexion/bd.php");

                                    $auxBuscador="";
							        if(isset($_GET['buscador'])){
								        $auxBuscador=$_GET['buscador'];
							        }

                                    $consulta = "SELECT * FROM Op_Usuarios where usuario like '%$auxBuscador%';";
                                    $resultado=$conexion->query($consulta);
                                    while($fila = $resultado->fetch_array()){
                                        echo "<tr>";
                                        echo "<td>".$fila['usuario']."</td>";  
                                        echo "<td>$ ".$fila['pwd']."</td>"; 
                                        echo "<td>".($fila['tipo']==1?"ADMIN":"VENDEDOR")."</td>";
                                        echo "<td>".($fila['estado']==0?"BAJA":"ACTIVO")."</td>";
                                        echo "<td>".$fila['fecha_utlima_actualizacion']."</td>";
                                        echo "<td>
                                                <a href='edit_usuario.php?idOp_Usuarios=".$fila['idOp_Usuarios']."&usuario=".$fila['usuario']."&pwd=".$fila['pwd']."&tipo=".$fila['tipo']."&estado=".$fila['estado']."' >
                                                    <i class='pe-7s-pen'></i>
                                                </a>
                                                <i>|</i>
                                                <a href='usuarios/eliminar.php?idOp_Usuarios=".$fila['idOp_Usuarios']."'>
                                                    <i class='pe-7s-trash'></i>
                                                </a>
                                            </td>
                                        </tr>"; 

                                    }
                                    $conexion->close();
                                    ?>
                                     
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</html>
<?php
}else{
    header("Location: ../");
}
?>
<script>    
    if(typeof window.history.pushState == 'function') {
        window.history.pushState({}, "Hide", '<?php echo $_SERVER['PHP_SELF'];?>');
    }
</script>
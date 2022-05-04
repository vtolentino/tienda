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
                            <div class="header">
                                <h4 class="title">Editar Usuario</h4>
                            </div>
                            <div class="content">
                                <form action="usuarios/editar.php" method="post" enctype="multipart/form-data">
                                <input style="display: none;" type="text"  name="id" class="form-control" value="<?php echo $_GET['idOp_Usuarios'] ?>">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Usuario</label>
                                                <input type="text" name="usuario" class="form-control" required value="<?php echo $_GET['usuario'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Contraseña</label>
                                                <input type="password" name="pwd" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Contraseña</label>
                                                <select class="form-control" name="tipo">
                                                    <option value="1" <?php echo ($_GET['tipo']==1?"selected":"") ?>>ADMIN</option>
                                                    <option value="2" <?php echo ($_GET['tipo']==2?"selected":"") ?>>VENDEDOR</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Estado</label>
                                                <select class="form-control" name="estado">
                                                    <option value="0" <?php echo ($_GET['estado']==0?"selected":"") ?>>BAJA</option>
                                                    <option value="1" <?php echo ($_GET['estado']==1?"selected":"") ?>>ACTIVO</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" name="enviar"
                                        class="btn btn-secondary btn-fill pull-right">Guardar</button>
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
    // if(typeof window.history.pushState == 'function') {
    //     window.history.pushState({}, "Hide", '<?php echo $_SERVER['PHP_SELF'];?>');
    // }
</script>
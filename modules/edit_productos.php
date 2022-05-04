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
                    <a class="navbar-brand" href="#">Prodcutos</a>
                </div>
            </div>
        </nav>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Editar Productos</h4>
                            </div>
                            <div class="content">
                                <form action="productos/editar.php" method="post" enctype="multipart/form-data">
                                <input style="display: none;" type="text"  name="id" class="form-control" value="<?php echo $_GET['idOp_Productos'] ?>">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Codigo</label>
                                                <input type="text" name="codigo" class="form-control" maxlength="13" value="<?php echo $_GET['codigo'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Nombre</label>
                                                <input type="text" name="nombre" class="form-control" required value="<?php echo $_GET['nombre'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group" style="white-space: pre-line;">
                                                <label><input type="checkbox" name="kilos" id="kilos" onchange="kilos_validacion()" value="" <?php if ($_GET['kilo']) echo "checked"; ?>>Venta por kilos</label>
                                            </div>
                                            <div class="form-group">
                                                <label><input type="checkbox" name="comision" onchange="validation_comision()" id="comision" value="" <?php if ($_GET['comision']) echo "checked"; ?>> Venta con Comision</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2" style="display: none;" id="comisiones">
                                            <div class="form-group">
                                                <label>Comision</label>
                                                <input type="text" name="comision_cantidad" class="form-control" value="<?php echo $_GET['cantidad_comision'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Precio</label>
                                                <input type="text" name="precio" id="precio" class="form-control" required value="<?php echo $_GET['precio'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Cantidad</label>
                                                <input type="text" name="cantidad" class="form-control" required value="<?php echo $_GET['cantidad'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
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
    kilos_validacion()
    function kilos_validacion(){
        if(document.getElementById('kilos').checked){
            document.getElementById('comision').checked =false
            document.getElementById('precio').disabled=false
            $('#comisiones').css("display", "none");
        }
    }
    validation_comision()
    function validation_comision(){
        if(document.getElementById('comision').checked){
            document.getElementById('kilos').checked =false
            $('#comisiones').css("display", "");
            document.getElementById('precio').disabled=true
            document.getElementById('precio').value=0;
        }else{
            document.getElementById('precio').disabled=false
            $('#comisiones').css("display", "none");
        }
    }
</script>
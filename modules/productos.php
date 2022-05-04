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
                    <a class="navbar-brand" href="#">Productos</a>
                </div>
            </div>
        </nav>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <!-- <div class="header">
                                <h4 class="title">Agregar Prodcutos</h4>
                            </div> -->
                            <div class="content">
                                <form action="productos/add.php" method="post" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Codigo</label>
                                                <input type="number" autofocus name="codigo" maxlSength="15" class="form-control" min="0">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Nombre</label>
                                                <input type="text" name="nombre" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group" style="white-space: pre-line;">
                                                <label><input type="checkbox" name="kilos" id="kilos" onchange="kilos_validacion()" value="">Venta por kilos</label>
                                            </div>
                                            <div class="form-group">
                                                <label><input type="checkbox" name="comision" onchange="validation_comision()" id="comision" value="">Venta con Comision</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2" style="display: none;" id="comisiones">
                                            <div class="form-group">
                                                <label>Comision</label>
                                                <input type="text" name="comision_cantidad" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Precio</label>
                                                <input type="text" name="precio" id="precio" min="0" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Cantidad</label>
                                                <input type="number" name="cantidad" min="0" class="form-control" required >
                                            </div>
                                        </div>
                                        <div class="col-md-4">
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
                                                <input type="text" name="buscador" class="form-control" placeholder="Introduce aquí el producto que deseas buscar">
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
                                    	<th>Codigo</th>
                                    	<th>Nombre</th>
                                        <th>Venta por Kilo</th>
                                        <th>Venta con Comision</th>
                                        <th>Cantidad Comision</th>
                                    	<th>Precio</th>
                                        <th>Cantidad</th>
                                        <th>Estado</th>
                                        <th>fecha Ultima Actualizacion</th>
                                        <th>configurar Venta indidual</th>
                                        <th>Acción</th>
                                    </thead>
                                    <tbody>
                                    <?php
                                    require("../session/conexion/bd.php");

                                    $auxBuscador="";
							        if(isset($_GET['buscador'])){
								        $auxBuscador=$_GET['buscador'];
							        }

                                    $consulta = "SELECT * FROM Op_Productos where nombre like '%$auxBuscador%' or codigo like '%$auxBuscador%' order by cantidad;";
                                    $resultado=$conexion->query($consulta);
                                    while($fila = $resultado->fetch_array()){
                                        // echo "<tr>
                                        //         <td>
                                        //             <div class='logo'>
                                        //                 <div class='form-group text-center pt-3'>
                                        //                     <img src='assets/img/".$fila['fotoP']."' class='imghomeletras' />
                                        //                 </div>
                                        //             </div>
                                        //         </td>
                                        // "; 
                                        echo "<tr>";
                                        echo "<td>".$fila['codigo']."</td>";  
                                        echo "<td>".$fila['nombre']."</td>";
                                        echo "<td>".($fila['kilo']==0?'':'Si')."</td>";  
                                        echo "<td>".($fila['comision']==0?'':'Si')."</td>";  
                                        echo "<td>".($fila['comision']==0?'':"$".$fila['cantidad_comision'])."</td>";  
                                        echo "<td>$ ".$fila['precio'].($fila['kilo']==0?'':' Kilo')."</td>";  
                                        echo "<td>".$fila['cantidad']."</td>";
                                        echo "<td>".($fila['estado']==0?"BAJA":"ACTIVO")."</td>";
                                        echo "<td>".$fila['fecha_utlima_actualizacion']."</td>";
                                        echo "<td>".($fila['kilo']==0 && $fila['comision']==0.?"
                                                <a>
                                                    <i onclick='individual({$fila['idOp_Productos']})' class='pe-7s-pen'></i>
                                                </a>":"")."
                                            </td>";
                                        echo "<td>
                                                <a href='edit_productos.php?idOp_Productos=".$fila['idOp_Productos']."&codigo=".$fila['codigo']."&nombre=".$fila['nombre']."&precio=".$fila['precio']."&cantidad=".$fila['cantidad']."&estado=".$fila['estado']."&kilo=".$fila['kilo']."&comision=".$fila['comision']."&cantidad_comision=".$fila['cantidad_comision']."' >
                                                    <i class='pe-7s-pen'></i>
                                                </a>
                                                <i>|</i>
                                                <a href='productos/eliminar.php?idOp_Productos=".$fila['idOp_Productos']."'>
                                                    <i class='pe-7s-trash'></i>
                                                </a>
                                            </td>
                                        </tr>"; 

                                    }
                                    $conexion->close();
                                    ?>
                                     
                                    </tbody>
                                </table>
                                <div class="modal" id="precios_individual">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" onclick="cerrar_precio()" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row" style="display: none;">
                                                    <input type="text" id="id_productos_venta" value="">
                                                    <input type="text" id="id_productos_individual" value="">
                                                </div>
                                                <div class="content" style="text-align: center;font-weight: bolder;">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Contenido de paquete</label>
                                                                <input style="text-align: -webkit-center;" type="number" id="cantidad_total" autofocus  name="recibo" class="form-control" value="" >
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Disponibles en paquete</label>
                                                                <input style="text-align: -webkit-center;" type="number" id="disponibles" autofocus  name="recibo" class="form-control" value="" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Precio individual</label>
                                                                <input style="text-align: -webkit-center;" type="number" id="precio_individual" autofocus  name="recibo" class="form-control" value="" >
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Estado</label>
                                                            <select class="form-control" name="estado_individual" id="estado_individual">
                                                                <option value="0">Baja</option>
                                                                <option value="1" selected>Activo</option>
                                                            </select>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="content">
                                                    <div class="row" >
                                                        <div class="col-md-6">
                                                            <button onclick="cerrar_precio()" class="btn btn-secondary btn-fill pull">Cerrar</button>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <button id="pagar" onclick="terminar_individual()" class="btn btn-secondary btn-fill pull-right">Agregar Venta</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
    function kilos_validacion(){
        if(document.getElementById('kilos').checked){
            document.getElementById('comision').checked =false
            document.getElementById('precio').disabled=false
            $('#comisiones').css("display", "none");
        }
    }
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
    function individual(id) {
        $.ajax({
            type: "POST",
            url: 'productos/consultar.php',
            data: {id:id},
            dataType: "json"
        })
        .done(function(response){
            if(!response.error){
                $("#id_productos_individual").val(response.data.idOp_productosIndividual);
                $("#cantidad_total").val(response.data.cantidad_caja);
                $("#disponibles").val(response.data.disponibles_caja);
                $("#precio_individual").val(response.data.precio_individual);
                $("#estado_individual").val(response.data.estado);
            }else{
                $("#id_productos_individual").val("");
                $("#cantidad_total").val("");
                $("#disponibles").val("");
                $("#precio_individual").val("");
                $("#estado_individual").val("1");
            }
            $("#id_productos_venta").val(id);
            $('#precios_individual').css("display", "block");
        })
    }
    function terminar_individual(id) {

        $("#cantidad_total").val();
        $("#disponibles").val();
        $("#precio_individual").val();
        $("#estado_individual").val();
        $.ajax({
            type: "POST",
            url: 'productos/agregar_individual.php',
            data: {
                id:$("#id_productos_venta").val(),
                id_individual:$("#id_productos_individual").val(),
                cantidad_total:$("#cantidad_total").val(),
                disponibles:$("#disponibles").val(),
                precio_individual:$("#precio_individual").val(),
                estado:$("#estado_individual").val(),
            },
            dataType: "json"
        })
        .done(function(response){
            if (!response.error) {
                alert(response.data)
            }
            location.reload();
            $("#id_productos_individual").val("");
            $("#cantidad_total").val("");
            $("#disponibles").val("");
            $("#precio_individual").val("");
            $("#estado").val("");
            $('#precios_individual').css("display", "");
        })
        
    }
    function cerrar_precio() {
        $('#precios_individual').css("display", "");
        $("#id_productos_venta").val("");
    } 
    if(typeof window.history.pushState == 'function') {
        window.history.pushState({}, "Hide", '<?php echo $_SERVER['PHP_SELF'];?>');
    }
</script>
<?php
session_start();
if($_SESSION["logueado"]==TRUE){
    // session_destroy();
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
                            <a class="navbar-brand" href="#">Reporte</a>
                        </div>
                    </div>
                </nav>
                <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="header">
                                    <h4 class="title">Listas Ventas</h4>
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
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Vendedor</label>
                                                    <select class="form-control" class="mi-selector" name="select_usuarios" id="select_usuarios">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="title">Fecha inicio</label>
                                                    <input type="datetime-local" name="buscador_star" id='buscador_star' class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="title">Fecha final</label>
                                                    <input type="datetime-local" name="buscador_end" id='buscador_end' class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group"></br>
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
                                            <th>Nombre Producto</th>
                                            <th>cantidad Ventidas</th>
                                            <th>Precio por Producto</th>
                                            <th>Precio Total</th>
                                            <th>Fecha Venta</th>
                                            <th>Tipo de venta</th>
                                        </thead>
                                        <tbody>
                                        <?php
                                        require("../session/conexion/bd.php");
                                        $buscador_star=date('Y-m-d').' 00:00:00';
                                        $buscador_end=date('Y-m-d').' 23:59:59';
                                        if(isset($_GET['buscador_star']) && isset($_GET['buscador_end'])){
                                            $buscador_star=str_replace("T"," ",$_GET['buscador_star']);
                                            $buscador_end=str_replace("T"," ",$_GET['buscador_end']);
                                        }
                                        $usuario='';
                                        if(isset($_GET['select_usuarios']) && $_GET['select_usuarios']!=""){
                                            $usuario=' and u.idOp_Usuarios = '.$_GET['select_usuarios'];
                                        }
                                        $consulta="select
                                                        u.usuario,
                                                        if(p.nombre is null,CONCAT(p2.nombre,' sueltos'),p.nombre) nombre,
                                                        v.idOp_Productos,
                                                        vi.idOp_Productos as id_producto_individual, 
                                                        v.cantidad,
                                                        if(p.precio is null,vi.precio_individual,if(p.precio=0,v.precio,p.precio)) precio_individual,
                                                        p.precio as precio_producto,
                                                        v.precio,
                                                        v.Fecha_venta,
                                                        v.tipo,
                                                        if(v.tipo = 1,
                                                        'Venta',
                                                        'Reembolso') tipo_venta,
                                                        p2.nombre as individual_nombre,
                                                        v.idOp_Usuarios
                                                    from
                                                        Op_Ventas v
                                                    inner join Op_Usuarios u on
                                                        u.idOp_Usuarios = v.idOp_Usuarios
                                                    left join Op_Productos p on
                                                        p.idOp_Productos = v.idOp_Productos
                                                    left join Op_productosIndividual vi on
                                                        v.idOp_productosIndividual =vi.idOp_productosIndividual
                                                    left join Op_Productos p2 on
                                                        p2.idOp_Productos =vi.idOp_Productos 
                                                    where
                                                        v.Fecha_venta BETWEEN '{$buscador_star}' and '{$buscador_end}'
                                                        {$usuario}
                                                    order by
                                                        Fecha_venta desc;";
                                        $resultado=$conexion->query($consulta);
                                        $suma_venta=0;
                                        $suma_reembolso=0;
                                        $nuevo_array=[];
                                        while($fila = $resultado->fetch_array()){
                                            if($fila['idOp_Productos']==0){
                                                $fila['idOp_Productos']=$fila['idOp_Productos']."-".$fila['id_producto_individual'];
                                            }
                                            if($fila['precio_producto']==0 && $fila['id_producto_individual']==null){
                                                $fila['precio_individual']=0;
                                            }
                                            if(isset($nuevo_array[$fila['tipo'].$fila['idOp_Productos'].$fila['idOp_Usuarios']])){
                                                // $nuevo_array[$fila['tipo'].$fila['idOp_Productos'].$fila['idOp_Usuarios']]['precio_individual']=$nuevo_array[$fila['tipo'].$fila['idOp_Productos'].$fila['idOp_Usuarios']]['precio_individual']+$fila['precio_individual'];
                                                $nuevo_array[$fila['tipo'].$fila['idOp_Productos'].$fila['idOp_Usuarios']]['precio']=$nuevo_array[$fila['tipo'].$fila['idOp_Productos'].$fila['idOp_Usuarios']]['precio']+$fila['precio'];
                                                $nuevo_array[$fila['tipo'].$fila['idOp_Productos'].$fila['idOp_Usuarios']]['cantidad']=$nuevo_array[$fila['tipo'].$fila['idOp_Productos'].$fila['idOp_Usuarios']]['cantidad']+$fila['cantidad'];
                                            }else{
                                                $nuevo_array[$fila['tipo'].$fila['idOp_Productos'].$fila['idOp_Usuarios']]=$fila;
                                            };
                                        }                                        
                                        foreach ($nuevo_array as $key => $value) {
                                            echo "<tr>";
                                            echo "<td>".$value['usuario']."</td>";  
                                            echo "<td>".$value['nombre']."</td>";
                                            echo "<td>".$value['cantidad']."</td>";  
                                            echo "<td>".$value['precio_individual']."</td>"; 
                                            echo "<td>$ ".$value['precio']."</td>";
                                            echo "<td>".$value['Fecha_venta']."</td>";
                                            echo "<td>".$value['tipo_venta']."</td>";
                                            echo "</tr>";
                                            if($value['tipo']==1){
                                                $suma_venta=$suma_venta+$value['precio'];
                                            }else{
                                                $suma_reembolso=$suma_reembolso+$value['precio'];
                                            }
                                        }

                                        $conexion->close();
                                        ?>
                                            
                                        </tbody>
                                    </table>
                                    <div class="content">
                                        <div class="row">
                                            <div class="col-md-4" style="display: flex;" >
                                                <div class='alert alert-info pull-right'>
                                                    <span>Total de Ventas</span>
                                                </div>
                                                <div class='alert alert-info pull-right'>
                                                    <span><?php echo $suma_venta ?></span>
                                                </div>
                                            </div>
                                            <div class="col-md-4" style="display: flex; place-content: center;" >
                                                <div class='alert alert-info pull-right'>
                                                    <span>Total de Reembolso</span>
                                                </div>
                                                <div class='alert alert-info pull-right'>
                                                    <span><?php echo $suma_reembolso ?></span>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class='alert alert-danger pull-right'>
                                                    <span><?php echo $suma_venta-$suma_reembolso ?></span>
                                                </div>
                                                <div class='alert alert-danger pull-right'>
                                                    <span>Venta General</span>
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
    select_usuarios()
    function select_usuarios() {
        $.ajax({
            type: "POST",
            url: 'ventas/select_usuarios.php',
            data: {},
            dataType: "json"
        })
        .done(function(response){
            if(!response.error){
                var producto_codigo = document.getElementById('select_usuarios');
                let opcion = document.createElement('option');
                opcion.value = "";
                opcion.text = "todos";
                producto_codigo.add(opcion);

                response.data.forEach(function(producto){
                    let opcion = document.createElement('option');
                    opcion.value = producto.idOp_Usuarios;
                    opcion.text = producto.usuario;
                    producto_codigo.add(opcion);    
                })
            }
        })
    }
    if(typeof window.history.pushState == 'function') {
        let today = new Date();
        $('#buscador_star').val(
            today.getFullYear()+'-'+
            (today.getMonth()>9?(today.getMonth()+1):'0'+(today.getMonth()+1))+'-'+
            (today.getDate()>9?today.getDate():'0'+today.getDate())+'T00:00:00'
            
        )
        $('#buscador_end').val(
            today.getFullYear()+'-'+(today.getMonth()>9?(today.getMonth()+1):'0'+(today.getMonth()+1))+'-'+
            (today.getDate()>9?today.getDate():'0'+today.getDate())+'T'+
            today.getHours()+':'+today.getMinutes()+':00')
        window.history.pushState({}, "Hide", '<?php echo $_SERVER['PHP_SELF'];?>');
        
    }
</script>
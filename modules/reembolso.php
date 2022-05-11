<?php
session_start();
if($_SESSION["logueado"]==TRUE){
    ?>
<!doctype html>
<html lang="en">
    <?php
        require("head.php");
    ?>    
<body>
<div class="wrapper">
    <?php
        require("menu.php");
    ?>
    <div class="main-panel">
        <nav class="navbar navbar-default navbar-fixed">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">Reembolso</a>
                </div>
            </div>
        </nav>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="content">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Codigo</label>
                                                <input type="number" id="codigo" autofocus maxlength="13"  name="codigo" class="form-control" value="" >
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-5">
                                            <div class="form-group">
                                                <label>Nombre</label>
                                                <input type="password" name="pwd" class="form-control" required>
                                            </div>
                                        </div> -->
                                    </div>
                                    <div class="row" style="display: none;" id="venta_producto">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label>Nombre</label>
                                                <input type="text" id="nombre" name="nombre" class="form-control" required value="" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Precio</label>
                                                <input type="text" id="precio" name="precio" class="form-control" required value="" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Cantidad</label>
                                                <input type="text" id="cantidad" class="form-control" required value="1">
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <br>
                                            <button id="nuevo" class="btn btn-secondary btn-fill pull-right">Agregar</button>
                                        </div>
                                    </div>
                                    <div class="row" style="display: none;">
                                        <input type="text" id="id" value="">
                                        <input type="text" id="precio" value="">
                                        <input type="text" id="id_productos_venta" value="">
                                        <input type="text" id="id_productos_venta_individual" value="">
                                        <input type="text" id="precio_kilo" value="">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <label>Lista Prodcutos</label>
                                                <select class="form-control" class="mi-selector" name="producto_codigo" id="producto_codigo">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <br>
                                            <button id="agregar_producto" onclick="bottonAgregar()" class="btn btn-secondary btn-fill pull-right">Agregar Producto</button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <label>Lista Prodcutos individuales</label>
                                                <select class="form-control" class="mi-selector" name="producto_codigo_individual" id="producto_codigo_individual">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <br>
                                            <button id="agregar_producto" onclick="bottonAgregarIndividual()" class="btn btn-secondary btn-fill pull-right">Agregar Producto</button>
                                        </div>
                                    </div>
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
                                <div class="header">
                                    <div class="row" >
                                        <div class="col-md-6">
                                            <h4 class="title">Lista de Reembolsos</h4>
                                        </div>
                                        <div class="col-md-6" id="alerta_total">
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="content table-full-width" id="datos_tabla">   
                                </div>
                                <div>
                                    <div class="row" >
                                        <div class="col-md-6">
                                            <button id="limpiar" onclick="limpiar()" class="btn btn-secondary btn-fill pull">LIMPIAR</button>
                                        </div>
                                        <div class="col-md-6">
                                            <button id="pagar" onclick="pagar()"  ng-click="pagarClick(comment)" class="btn btn-secondary btn-fill pull-right">REEMBOLSAR</button>
                                        </div>
                                    </div>
                                </div>
                            </div>                                                
                        </div>
                        <!-- <div class="col-md-12"> -->
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Historial de Reembolsos</h4>
                            </div>
                            <div class="content table-full-width">
                                <table class="table table-hover table-striped">
                                    <thead>
                                    	<th>Usuario</th>
                                    	<th>Nombre Producto</th>
                                    	<th>cantidad Ventidas</th>
                                        <th>Precio Total</th>
                                        <th>Fecha Venta</th>
                                    </thead>
                                    <tbody>
                                    <?php
                                    require("../session/conexion/bd.php");
                                    $auxBuscador=date('y-m-d');
                                    // $consulta = "select
                                    //                 u.usuario,
                                    //                 p.nombre,
                                    //                 v.cantidad,
                                    //                 v.precio,
                                    //                 v.Fecha_venta
                                    //             from
                                    //                 Op_Ventas v
                                    //             inner join Op_Productos p on
                                    //                 p.idOp_Productos = v.idOp_Productos
                                    //             inner join Op_Usuarios u on
                                    //                 u.idOp_Usuarios = v.idOp_Usuarios
                                    //             where v.tipo=2 and v.Fecha_venta BETWEEN '{$auxBuscador} 00:00:00' and '{$auxBuscador} 23:59:59'
                                    //             order by Fecha_venta desc;";
                                    $consulta = "
                                            select
                                                u.usuario,
                                                if(p.nombre is null,CONCAT(p2.nombre,' sueltos'),p.nombre) nombre,
                                                v.cantidad,
                                                if(p.precio is null,vi.precio_individual,p.precio) precio_individual,
                                                v.precio,
                                                v.Fecha_venta,
                                                v.tipo,
                                                if(v.tipo = 1,
                                                'Venta',
                                                'Reembolso') tipo_venta
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
                                                v.tipo=2 and v.Fecha_venta BETWEEN '{$auxBuscador} 00:00:00' and '{$auxBuscador} 23:59:59'
                                            order by
                                                Fecha_venta desc;";
                                    $resultado=$conexion->query($consulta);
                                    $suma_venta=0;
                                    while($fila = $resultado->fetch_array()){
                                        echo "<tr>";
                                        echo "<td>".$fila['usuario']."</td>";  
                                        echo "<td>".$fila['nombre']."</td>";
                                        echo "<td>".$fila['cantidad']."</td>";  
                                        echo "<td>$ ".$fila['precio']."</td>";
                                        echo "<td>".$fila['Fecha_venta']."</td>";
                                        echo "</tr>"; 
                                        $suma_venta=$suma_venta+$fila['precio'];
                                    }
                                    $conexion->close();
                                    ?>
                                     
                                    </tbody>
                                </table>
                                <div class="content">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class='alert alert-danger pull-right'>
                                                <span><?php echo $suma_venta ?></span>
                                            </div>
                                            <div class='alert alert-danger pull-right'>
                                                <span>Total de Reembolsos</span>
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
            <div class="modal" id="myModal" >
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" onclick="cerrar()" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Pagar</h4>
                    </div>
                    <div class="modal-body">
                        <div class="content">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Cantidad a Pagar</label>
                                        <input type="text" id="Tota_modal" class="form-control" value="" disabled>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Recibi</label>
                                        <input type="text" id="recibo" autofocus  name="recibo" class="form-control" value="" >
                                    </div>
                                </div>
                            </div>
                        </div>
                    <!-- </div>
                    <div class="modal-footer"> -->
                        <!-- <button type="button" onclick="cerrar()" class="btn btn-default" data-dismiss="modal">Close</button> -->
                        <div class="content">
                            <div class="row" >
                                <div class="col-md-6">
                                    <button style="display: grid;" onclick="cerrar()" class="btn btn-secondary btn-fill pull">Cerrar</button>
                                </div>
                                <div class="col-md-6">
                                    <button id="pagar" onclick="terminar()" class="btn btn-secondary btn-fill pull-right">Terminar Venta</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    
                </div>
            </div>
            <div class="modal" id="precios_variados" >
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" onclick="cerrar_precio()" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="content" style="text-align: center;font-weight: bolder;">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Precio Vendido</label>
                                            <input style="text-align: -webkit-center;" type="number" id="precio_variado" autofocus  name="recibo" class="form-control" value="" >
                                            <label id="texto_comision">
                                                
                                            </label>
                                            <div class="row" style="display: none;">
                                                <input type="text" id="tiene_comision" value="">
                                                <input type="text" id="comision_cantidad" value="">
                                            </div>
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
                                        <button id="pagar" onclick="terminar_variado()" class="btn btn-secondary btn-fill pull-right">Agregar Venta</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal" id="precios_por_kilo" >
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" onclick="cerrar_venta_kilo()" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="content" style="text-align: center;font-weight: bolder;">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Cantidad Vendida en kilos</label>
                                            <input style="text-align: -webkit-center;" onchange="calcular_venta_kilo()" type="number" id="cantidad_kilo" autofocus  name="cantidad_kilo" class="form-control" value="" >
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Precio a pagar</label>
                                            <input style="text-align: -webkit-center;" type="number" id="precio_kilo_individual" autofocus  name="cantidad_kilo" class="form-control" value="" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="content">
                                <div class="row" >
                                    <div class="col-md-6">
                                        <button onclick="cerrar_venta_kilo()" class="btn btn-secondary btn-fill pull">Cerrar</button>
                                    </div>
                                    <div class="col-md-6">
                                        <button id="pagar" onclick="terminar_venta_por_kilo()" class="btn btn-secondary btn-fill pull-right">Agregar Venta</button>
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
</body>
</html>
<?php
}else{
    header("Location: ../");
}
?>
<script type="text/javascript">
    function calcular_venta_kilo() {
        $('#cantidad_kilo').val()
        var precio_kilo=$("#precio_kilo").val()
        var operacion=precio_kilo*$("#cantidad_kilo").val()
        $("#precio_kilo_individual").val(operacion)
    }
    function cerrar_venta_kilo() {
        $('#precios_por_kilo').css("display", "");
        $("#precio_kilo_individual").val("")
        document.getElementById("codigo").focus();
    }
    function terminar_venta_por_kilo() {
        if($("#cantidad_kilo").val()==""){
            alert('Agregar Cantidad Vendida');
            return
        }
        if($("#precio_kilo_individual").val()==""){
            alert('Agregar Precio');
            return
        }
        // var precio_kilo=$("#precio_kilo").val()
        // var operacion=precio_kilo*$("#cantidad_kilo").val()
        $("#precio").val($("#precio_kilo_individual").val())
        $('#precios_por_kilo').css("display", "");
        agregar()
        document.getElementById("codigo").focus();
    }
    select_individual()
    function select_individual() {
        $.ajax({
            type: "POST",
            url: 'ventas/productos_select_individual.php',
            data: {},
            dataType: "json"
        })
        .done(function(response){
            if(!response.error){
                var producto_codigo = document.getElementById('producto_codigo_individual');
                response.data.forEach(function(producto){
                    let opcion = document.createElement('option');
                    opcion.value = producto.idOp_productosIndividual;
                    opcion.text = producto.nombre+' suelto ('+producto.codigo+')';
                    if(producto.codigo==""){
                        opcion.text = producto.nombre ;
                    }
                    producto_codigo.add(opcion);    
                })
            }
        })
    }
    function bottonAgregarIndividual() {
        $("#id_productos_venta_individual").val(document.getElementById('producto_codigo_individual').value);
        Agregar_productos()
        document.getElementById("codigo").focus();
    }
    window.onload = function() { 
        document.onkeypress = mostrarInformacionCaracter;
        $(function(){
            $("#producto_codigo").select2();
            $("#producto_codigo_individual").select2();
        })
    }
    function mostrarInformacionCaracter(evObject) {
        var msg = ''; var elCaracter = String.fromCharCode(evObject.which);
        if (evObject.which!=0 && evObject.which!=13) {
            msg = 'Tecla pulsada: ' + elCaracter;
        }else { 
            var precios_por_kilo = document.getElementById("precios_por_kilo").style.display;
            var div1 = document.getElementById("myModal").style.display;
            var precios_variados = document.getElementById("precios_variados").style.display;

            // if(div1.style.display=="block"){
            //     terminar_venta_por_kilo
            // }
            // if(div1.style.display=="block"){
            //     terminar()
            // }
            if(precios_por_kilo=="block"){
                terminar_venta_por_kilo()
            }
            if(div1=="block"){
                terminar()
            }
            if(precios_variados=='block'){
                terminar_variado()
            }
            if(precios_por_kilo=="" && div1=="" && precios_variados==""){
                pagar()
            }
            
        }
    }
    function bottonAgregar() {
        $("#id_productos_venta_individual").val('')
        $("#id_productos_venta").val(document.getElementById('producto_codigo').value);
        Agregar_productos()
        document.getElementById("codigo").focus();
    }
    function terminar_variado() {
        if($("#precio_variado").val()==""){
            alert('Agregar Precio');
            return
        }
        $("#precio").val($("#precio_variado").val())
        $('#precios_variados').css("display", "");
        agregar()
        document.getElementById("codigo").focus();
    }
    select()
    function select() {
        $.ajax({
            type: "POST",
            url: 'ventas/productos_select.php',
            data: {},
            dataType: "json"
        })
        .done(function(response){
            if(!response.error){
                var producto_codigo = document.getElementById('producto_codigo');
                response.data.forEach(function(producto){
                    let opcion = document.createElement('option');
                    opcion.value = producto.idOp_Productos;
                    opcion.text = producto.nombre+' ('+producto.codigo+')';
                    if(producto.codigo==""){
                        opcion.text = producto.nombre ;
                    }
                    producto_codigo.add(opcion);    
                })
            }
        })
    }
    function cerrar_precio() {
        $('#precios_variados').css("display", "");
        document.getElementById("codigo").focus();
    }
    function Agregar_productos(params) {
        var vista="consultar_id.php"
        var id=$("#id_productos_venta").val()
        if($("#id_productos_venta_individual").val()!=""){
            vista="consultar_id_individual.php"
            id=$("#id_productos_venta_individual").val()
        }
        if(id!=""){
            $.ajax({
                type: "POST",
                url: 'ventas/'+vista,
                data: {id:id},
                dataType: "json"
            })
            .done(function(response){
                if(!response.error){
                    if(response.data.kilo==0){
                        $("#cantidad").val(1)
                        $("#precio_kilo").val(0);
                        $("#cantidad_kilo").val(0)
                        $("#precio_kilo_individual").val("")
                        $("#texto_comision").html('');
                        $('#tiene_comision').val(0);
                        $('#comision_cantidad').val(0);
                        $("#precio").val(response.data.precio)
                        // $('#venta_producto').css("display", "");
                        // $("#nombre").val(response.data.nombre);
                        // $("#id").val(response.data.idOp_Productos);
                        // $("#precio").val(response.data.precio);
                        // agregar()
                        // $('#venta_producto').css("display", "");
                        $("#nombre").val(response.data.nombre);
                        $("#id").val(response.data.idOp_Productos);
                        if($("#id_productos_venta_individual").val()!=""){
                            $("#id").val("");
                        }
                        // $("#precio").val(response.data.precio);#
                        if(response.data.precio==0 && $("#precio").val()==0){
                            if(response.data.comision==1){
                                $("#texto_comision").html('<a>Laventa tiene una comision de $'+response.data.cantidad_comision+' si es menos de 50</a>');
                                $('#tiene_comision').val(response.data.comision);
                                $('#comision_cantidad').val(response.data.cantidad_comision);
                            }
                            $('#precios_variados').css("display", "block");
                            document.getElementById("precio_variado").focus();
                        }else{
                            if(response.data.precio!=0){
                                $("#cantidad").val(1)
                                $("#precio").val(response.data.precio);
                            }
                            if(response.data.precio_individual!=undefined){
                                $("#cantidad").val(1)
                                $("#precio").val(response.data.precio_individual);
                            }
                            agregar()
                        }
                    }else{
                        $("#nombre").val(response.data.nombre);
                        $("#id").val(response.data.idOp_Productos);
                        $("#precio_kilo").val(response.data.precio);
                        $("#precio").val(response.data.precio);
                        $('#precios_por_kilo').css("display", "block");
                        $("#cantidad_kilo").val("");
                        $("#precio_kilo_individual").val("")
                        document.getElementById("cantidad_kilo").focus();
                    }
                }else{
                    $("#nombre").val("");
                    $("#id").val("");
                    $("#precio").val("");
                    $('#venta_producto').css("display", "none");

                }
                total()
                
            })
        }else{
            $("#nombre").val("");
            $("#id").val("");
            $("#precio").val("");
            $('#venta_producto').css("display", "none");
        }
    }
    // function pagar() {
    //     var tabla = JSON.parse(localStorage.getItem("tabla_reembolso"));
    //     sum=0
    //     if(tabla){
    //         tabla.forEach(element => {
    //             sum=sum+element.precio_total

    //         });
    //     }
    //     if(sum==0){
    //         alert('Favor de Agregar Articulos')
    //         return 
    //     }
    //     $("#Tota_modal").val(sum)
    //     $('#myModal').css("display", "block");

    //     document.getElementById("recibo").focus();
    // }
    function pagar() {
        
        var tabla = JSON.parse(localStorage.getItem("tabla_reembolso"));
        if(!tabla){
            alert('Favor de Agregar Articulos')
            document.getElementById("codigo").focus();
            return 
        }
        sum=0
        if(tabla){
            tabla.forEach(element => {
                sum=sum+parseFloat(element.precio_total)

            });
        }
        $.ajax({
            type: "POST",
            url: 'ventas/ventaFinalReembolso.php',
            data: {datos:tabla},
            dataType: "json"
        })
        .done(function(response){
            alert('Cantidad reembolsada '+ sum)
            $('#myModal').css("display", "");
            limpiar()
        })
    }
    function cerrar() {
        $('#myModal').css("display", "");
    }
    $('#codigo').on('input', function() {
        $("#id_productos_venta_individual").val('')
        if($("#codigo").val().length>=6){
            $.ajax({
                type: "POST",
                url: 'ventas/consultar.php',
                data: {codigo:$("#codigo").val()},
                dataType: "json"
            })
            .done(function(response){
                if(!response.error){
                    $('#venta_producto').css("display", "");
                    $("#nombre").val(response.data.nombre);
                    $("#id").val(response.data.idOp_Productos);
                    $("#precio").val(response.data.precio);
                    if(response.data.kilo==1){
                        $("#codigo").val('')
                        $("#precio_kilo").val(response.data.precio);
                        $('#venta_producto').css("display", "none");
                        $('#precios_por_kilo').css("display", "block");
                        document.getElementById("cantidad_kilo").focus();
                        // Agregar_productos()
                    }else{
                        $("#cantidad_kilo").val(0)
                        $("#precio_kilo").val(0);
                        $("#precio_kilo_individual").val("")
                        agregar()   
                    }
                    // if(response.data.cantidad>0){
                    //     $('#venta_producto').css("display", "");
                    //     $("#nombre").val(response.data.nombre);
                    //     $("#id").val(response.data.idOp_Productos);
                    //     $("#precio").val(response.data.precio);
                    //     agregar()
                    // }else{
                    //     alert('Sin productos');
                    //     $("#codigo").val("");    
                    // }
                }else{
                    $("#nombre").val("");
                    $("#id").val("");
                    $("#precio").val("");
                    $('#venta_producto').css("display", "none");

                }
                total()
                
            })
        }else{
            $("#nombre").val("");
            $("#id").val("");
            $("#precio").val("");
            $('#venta_producto').css("display", "none");
        }
    });
    $('#nuevo').click('button', function() {
        agregar()
    });
    function agregar() {
        var tabla = localStorage.getItem("tabla_reembolso");
        if($("#cantidad").val()==0){
            alert('Agregar Cantidad')
            return
        }
        data={};
        data.id_venta=0;
        data.id_producto=0;
        data.nombre="";
        data.precio=0;
        data.cantidad=0;
        data.precio_total=0;
        tabla=JSON.parse(tabla);
        if(tabla!=null && tabla.length>0 ){
            repetidos=true;
            key="";
            datos_nuevos={};
            tabla.forEach(function(element,i) {
                if($('#tiene_comision').val()==1){
                    return
                }
                if($("#precio_kilo").val()==0 && $("#cantidad_kilo").val()==0){
                    if(element.id_productos_venta_individual!=""){
                        if(element.id_productos_venta_individual==$("#id_productos_venta_individual").val()){
                            repetidos=false;
                            nuevo_producto=$("#precio").val()*$("#cantidad").val();
                            // element.precio_total=element.precio_total+nuevo_producto
                            element.precio_total=($("#precio_kilo_individual").val()=="")?element.precio_total+nuevo_producto:parseFloat(element.precio_total)+parseFloat($("#precio_kilo_individual").val());
                            element.cantidad=parseInt(element.cantidad)+parseInt($("#cantidad").val())
                            datos_nuevos=element;
                            key=i;
                        }
                    }else{
                        if(element.id_producto==$("#id").val()){
                            repetidos=false;
                            nuevo_producto=$("#precio").val()*$("#cantidad").val();
                            // element.precio_total=element.precio_total+nuevo_producto
                            element.precio_total=($("#precio_kilo_individual").val()=="")?element.precio_total+nuevo_producto:parseFloat(element.precio_total)+parseFloat($("#precio_kilo_individual").val());
                            element.cantidad=parseInt(element.cantidad)+parseInt($("#cantidad").val())
                            datos_nuevos=element;
                            key=i;
                        }
                    }
                }else{
                    if(element.id_producto==$("#id").val()){
                        repetidos=false;
                        nuevo_producto=$("#precio_kilo").val()*$("#cantidad_kilo").val();
                        // element.precio_total=element.precio_total+nuevo_producto
                        element.precio_total=($("#precio_kilo_individual").val()=="")?element.precio_total+nuevo_producto:parseFloat(element.precio_total)+parseFloat($("#precio_kilo_individual").val());
                        element.cantidad=parseFloat(element.cantidad)+parseFloat($("#cantidad_kilo").val())
                        datos_nuevos=element;
                        key=i;
                    }
                }
            });
            if(repetidos){
                if($("#precio_kilo").val()==0 && $("#cantidad_kilo").val()==0){
                    data.id_venta=tabla.length+1
                    data.id_producto=$("#id").val();
                    data.id_productos_venta_individual=$("#id_productos_venta_individual").val();
                    data.nombre=$("#nombre").val();
                    // data.precio=$("#precio").val();
                    data.precio=($('#tiene_comision').val()==0?$("#precio").val():($("#precio").val()<50?parseInt($("#precio").val())+parseInt($('#comision_cantidad').val()):$("#precio").val()))
                    data.cantidad=$("#cantidad").val();
                    // data.precio_total=data.precio*$("#cantidad").val();
                    data.precio_total=($("#precio_kilo_individual").val()=="")?data.precio*data.cantidad:$("#precio_kilo_individual").val();
                    data.editar=($('#tiene_comision').val()==0?1:0)
                    tabla.push(data);
                    tabla=JSON.stringify(tabla);
                    localStorage.setItem("tabla_reembolso", tabla);
                }else{
                    data.id_venta=tabla.length+1
                    data.id_producto=$("#id").val();
                    data.id_productos_venta_individual=$("#id_productos_venta_individual").val();
                    data.nombre=$("#nombre").val();
                    data.precio=($("#precio_kilo").val()==0?$("#precio").val():$("#precio_kilo").val());
                    data.cantidad=($("#cantidad_kilo").val()==0?$("#cantidad").val():$("#cantidad_kilo").val());
                    // data.precio_total=data.precio*data.cantidad
                    data.precio_total=($("#precio_kilo_individual").val()=="")?data.precio*data.cantidad:$("#precio_kilo_individual").val();
                    data.editar=0
                    tabla.push(data);
                    tabla=JSON.stringify(tabla);
                    localStorage.setItem("tabla_reembolso", tabla);
                }
            }else{
                
                tabla[key]=datos_nuevos
                tabla=JSON.stringify(tabla);
                localStorage.setItem("tabla_reembolso", tabla);
            } 
        }else{
            if($("#precio_kilo").val()==0 && $("#cantidad_kilo").val()==0){
                data.id_venta= 1;
                data.id_producto=$("#id").val();
                data.id_productos_venta_individual=$("#id_productos_venta_individual").val();
                data.nombre=$("#nombre").val();
                // data.precio=$("#precio").val();
                data.precio=($('#tiene_comision').val()==0?$("#precio").val():($("#precio").val()<50?parseInt($("#precio").val())+parseInt($('#comision_cantidad').val()):$("#precio").val()))
                data.cantidad=$("#cantidad").val();
                data.editar=($('#tiene_comision').val()==0?1:0)
                // data.precio_total=data.precio*$("#cantidad").val();
                data.precio_total=($("#precio_kilo_individual").val()=="")?data.precio*data.cantidad:$("#precio_kilo_individual").val();
                data=JSON.stringify([data]);
                localStorage.setItem("tabla_reembolso", data);
            }else{
                data.id_venta= 1;
                data.id_producto=$("#id").val();
                data.id_productos_venta_individual=$("#id_productos_venta_individual").val();
                data.nombre=$("#nombre").val();
                // data.nombre=$("#nombre").val();
                data.precio=($("#precio_kilo").val()==0?$("#precio").val():$("#precio_kilo").val());
                data.cantidad=($("#cantidad_kilo").val()==0?$("#cantidad").val():$("#cantidad_kilo").val());
                data.editar=0
                // data.precio_total=data.precio*data.cantidad
                data.precio_total=($("#precio_kilo_individual").val()=="")?data.precio*data.cantidad:$("#precio_kilo_individual").val();
                data=JSON.stringify([data]);
                localStorage.setItem("tabla_reembolso", data);
            }
        }
        $("#id").val('')
        $("#codigo").val("");
        $("#nombre").val("");
        $("#cantidad").val("1");
        $("#id").val("");
        $("#precio").val("");
        $('#venta_producto').css("display", "none");
        var tabla = JSON.parse(localStorage.getItem("tabla_reembolso"));
        $.ajax({
            type: "POST",
            url: 'ventas/tabla.php',
            data: {datos:tabla},
            dataType: "json"
        })
        .done(function(response){
            $('#datos_tabla').html(response.html);
            total()
        })
    }
    if(typeof window.history.pushState == 'function') {
        window.history.pushState({}, "Hide", '<?php echo $_SERVER['PHP_SELF'];?>');
    }
    var tabla = JSON.parse(localStorage.getItem("tabla_reembolso"));
    $.ajax({
        type: "POST",
        url: 'ventas/tabla.php',
        data: {datos:tabla},
        dataType: "json"
    })
    .done(function(response){
        $('#datos_tabla').html(response.html);
        total()
    })
    function limpiar() {
        localStorage.removeItem('tabla_reembolso');
        location.reload();
    }
    function eliminar(id) {
        var tabla = JSON.parse(localStorage.getItem("tabla_reembolso"));
        nuevo=[]
        tabla.forEach(element => {
            if(element.id_venta!=id){
                nuevo.push(element)
            }
        });
        contador=1
        nuevo_id=[]
        nuevo.forEach(function(element,i) {
            element.id_venta=contador
            contador++
            nuevo_id.push(element)
        })
        if(nuevo_id.length==0){
            localStorage.removeItem('tabla_reembolso');
        }else{
            data=JSON.stringify(nuevo_id);
            localStorage.setItem("tabla_reembolso", data);   
        }
        $.ajax({
            type: "POST",
            url: 'ventas/tabla.php',
            data: {datos:nuevo_id},
            dataType: "json"
        }).done(function(response){
            $('#datos_tabla').html(response.html);
            document.getElementById("codigo").focus();
            total()
        })
        
    }
    function operaciones(id,cantidad,operacion) {
        var tabla = JSON.parse(localStorage.getItem("tabla_reembolso"));
        nuevo=[]
        key=""

        // tabla.forEach(element => {
        tabla.forEach(function(element,i) {
            if(element.id_venta==id){
               if(operacion){
                    element.cantidad=parseInt(element.cantidad)-parseInt(1)
               }else{
                    element.cantidad=parseInt(element.cantidad)+parseInt(1)
               }
               element.precio_total=element.cantidad*element.precio
            }
            if (element.cantidad!=0) {
                nuevo.push(element)
            }
        });
        contador=1
        nuevo_id=[]
        nuevo.forEach(function(element,i) {
            element.id_venta=contador
            contador++
            nuevo_id.push(element)
        })
        data=JSON.stringify(nuevo_id);
        localStorage.setItem("tabla_reembolso", data);
        $.ajax({
            type: "POST",
            url: 'ventas/tabla.php',
            data: {datos:nuevo_id},
            dataType: "json"
        }).done(function(response){
            $('#datos_tabla').html(response.html);
            document.getElementById("codigo").focus();
            total()
        })
    }
    total()
    function total(){
        var tabla = JSON.parse(localStorage.getItem("tabla_reembolso"));
        sum=0
        if(tabla){
            tabla.forEach(element => {
                sum=parseFloat(sum)+parseFloat(element.precio_total)

            });
        }
        html="<div class='alert alert-danger pull-right'><span>$"+sum+"</span></div><div class='alert alert-danger pull-right'><span>Total de Reembolso</span></div>"
        $('#alerta_total').html(html);
        // $.notify({
        //     icon: "pe-7s-gift",
        //     message: "Welcome to <b>Light Bootstrap Dashboard</b> - a beautiful freebie for every web developer."

        // },{
        //     type: "danger",
        //     placement: {
        //         from: "top",
        //         align: "right"
        //     }
        // });
    }
</script>
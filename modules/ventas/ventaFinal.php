<?php 
session_start();
require("../../session/conexion/bd.php");
$id=array_column($_POST['datos'],'id_producto');
$id=[];
$id_individual=[];
foreach ($_POST['datos'] as $key => $value) {
    if($value['id_productos_venta_individual']==""){
        $id[]=$value['id_producto'];   
    }else{
        $id_individual[]=$value['id_productos_venta_individual'];
    }
}
$id=implode(',', $id);
$insert ="SELECT * FROM Op_Productos where idOp_Productos in (".$id.") ";

$id_individual=implode(',', $id_individual);
$insert_individual ="SELECT * FROM Op_productosIndividual where idOp_productosIndividual in (".$id_individual.") ";

$consulta_individual=[];
if($resultado2 = $conexion->query($insert_individual)) {
    while($filas = $resultado2->fetch_array()){
        $consulta_individual[$filas['idOp_productosIndividual']]=$filas;
    }
}
$consulta=[];
if($resultado = $conexion->query($insert)) {
    while($fila = $resultado->fetch_array()){
        $consulta[$fila['idOp_Productos']]=$fila;
    }
}
$fecha=date('Y-m-d H:i:s');
foreach ($_POST['datos'] as $key => $datos) {
    if($datos['id_productos_venta_individual']==""){
        if(isset($consulta[$datos['id_producto']])){
            $select="Select * from Op_Productos WHERE idOp_Productos={$datos['id_producto']} and comision=1;";
            $resta_comision=0;
            $datos_=[];
            if($resultado_2 = $conexion->query($select)){
                $datos_=$resultado_2->fetch_array();
                if($datos_!=null && count($datos_)>0){
                    $datos['cantidad']=$datos['precio_total'];
                    if($datos['precio_total']<50){
                        $datos['cantidad']=$datos['precio_total']-$datos_['cantidad_comision'];
                        $datos['precio_total']=$datos['cantidad'];
                    }
                    $resta_comision=$datos_['cantidad_comision'];
                }
            }
            if($datos_!=null && count($datos_)>0){
                $cantidad_sobrante=$datos_['cantidad']-$datos['cantidad'];
                $update="UPDATE Op_Productos SET cantidad='{$cantidad_sobrante}' WHERE idOp_Productos={$datos['id_producto']};";
                if($datos_['kilo']==0 && $datos['cantidad']<50){
                    $datos['precio_total']=$datos['precio_total']+$resta_comision;
                }
            }else{
                $cantidad_sobrante=$consulta[$datos['id_producto']]['cantidad']-$datos['cantidad'];
                $update="UPDATE Op_Productos SET cantidad='{$cantidad_sobrante}' WHERE idOp_Productos={$datos['id_producto']};";
            }
            $conexion->query($update);
            $insert="INSERT INTO Op_Ventas (idOp_Productos,idOp_productosIndividual,idOp_Usuarios,cantidad,precio,Fecha_venta,tipo) 
            VALUES ({$datos['id_producto']},0,{$_SESSION["id"]},{$datos['cantidad']},'{$datos['precio_total']}','{$fecha}',1);";
            $conexion->query($insert);
        }
    }else{
        if(isset($consulta_individual[$datos['id_productos_venta_individual']])){
            if($consulta_individual[$datos['id_productos_venta_individual']]['disponibles_caja']>=$datos['cantidad']){
                $cantidad_sobrante=$consulta_individual[$datos['id_productos_venta_individual']]['disponibles_caja']-$datos['cantidad'];
                $update="UPDATE Op_productosIndividual SET disponibles_caja='{$cantidad_sobrante}' WHERE idOp_productosIndividual={$datos['id_productos_venta_individual']};";
                $conexion->query($update);
                $insert="INSERT INTO tiendas.Op_Ventas (idOp_Productos,idOp_productosIndividual,idOp_Usuarios,cantidad,precio,Fecha_venta,tipo) VALUES (0,{$datos['id_productos_venta_individual']},{$_SESSION["id"]},{$datos['cantidad']},'{$datos['precio_total']}','{$fecha}',1);";
                $conexion->query($insert);
            }else{
                $select="Select * from Op_Productos WHERE idOp_Productos={$consulta_individual[$datos['id_productos_venta_individual']]['idOp_Productos']}";
                if($resultado_2 = $conexion->query($select)) {
                    $actualizar=$resultado_2->fetch_array();
                    if($actualizar!=null && count($actualizar)>0){
                        $d=$actualizar['cantidad']-1;
                        $update_producto="UPDATE Op_Productos SET cantidad='{$d}' WHERE idOp_Productos={$consulta_individual[$datos['id_productos_venta_individual']]['idOp_Productos']};";
                        $conexion->query($update_producto);
                    }
                }
                $cantidad_nueva=$consulta_individual[$datos['id_productos_venta_individual']]['disponibles_caja']+$consulta_individual[$datos['id_productos_venta_individual']]['cantidad_caja'];
                $cantidad_sobrante=$cantidad_nueva-$datos['cantidad'];
                $update="UPDATE Op_productosIndividual SET disponibles_caja='{$cantidad_sobrante}' WHERE idOp_productosIndividual={$datos['id_productos_venta_individual']};";

                $conexion->query($update);
                $insert="INSERT INTO Op_Ventas (idOp_Productos,idOp_productosIndividual,idOp_Usuarios,cantidad,precio,Fecha_venta,tipo) 
                VALUES (0,{$datos['id_productos_venta_individual']},{$_SESSION["id"]},{$datos['cantidad']},'{$datos['precio_total']}','{$fecha}',1);";
                $conexion->query($insert);
            }
        }
    }
}
echo json_encode([]);
?>
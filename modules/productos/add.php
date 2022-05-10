<?php
    session_start();    
    if(isset($_POST["enviar"])) {
        require("../../session/conexion/bd.php");
        $kilos="0";
        if(isset($_POST["kilos"])){
            $kilos="1";
        }
        $comision="0";
        $cantidad_comision=0;
        if(isset($_POST["comision"])){
            $comision="1";
            $cantidad_comision=$_POST["comision_cantidad"];
        }
        if($_POST['codigo']!=""){
            $cosultar = "select * from Op_Productos where codigo='{$_POST['codigo']}'";
            $cosultar=$conexion->query($cosultar);
            if($cosultar!=null && count($cosultar->fetch_array())>0){
                $error="El codigo ya existe en los productos";
                Header("Location: ../productos.php?mensaje=".$error."");
                return;
            }
        }
        if($_POST['precio']==""){
            $_POST['precio']=0;
        }
        $fecha=date('Y-m-d H:i:s');
        $insert ="INSERT INTO Op_Productos (codigo,nombre,kilo,cantidad,precio,comision,cantidad_comision,fecha_utlima_actualizacion,estado)
        VALUES ('{$_POST['codigo']}','{$_POST['nombre']}','{$kilos}','{$_POST['cantidad']}','{$_POST['precio']}','{$comision}','{$cantidad_comision}','{$fecha}','{$_POST['estado']}');";
        if($resultado = $conexion->query($insert)) {
            $cosultar = "select * from Op_Productos where codigo='{$_POST['codigo']}' and nombre='{$_POST['nombre']}' and kilo='{$kilos}' and cantidad='{$_POST['cantidad']}' and precio='{$_POST['precio']}' and comision='{$comision}' and cantidad_comision='{$cantidad_comision}' and fecha_utlima_actualizacion='{$fecha}' and estado='{$_POST['estado']}'";
            $cosultar=$conexion->query($cosultar);
            $data=$cosultar->fetch_array();
            if($data!=null && count($data)>0){
                $new_array=[];
                $id=0;
                foreach ($data as $key => $value) {
                    if(!is_numeric($key)){
                        $new_array[$key]=$value;
                    }
                }
                $id=$new_array['idOp_Productos'];
                $new_array=json_encode($new_array);
                $insertar_log="INSERT INTO Trans_Log (Tabla, id, Antes, Despues,idOp_Usuarios, estado, fecha_utlima_actualizacion) VALUES('Op_Productos',{$id}, '{}', '{$new_array}',{$_SESSION['id']}, 1, '{$fecha}');";
                $conexion->query($insertar_log);
            }
            $error="Producto Guardado";
            Header("Location: ../productos.php?mensaje=".$error."");
            return;
        }
    }    
?>
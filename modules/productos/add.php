<?php
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
            $error="Producto Guardado";
            Header("Location: ../productos.php?mensaje=".$error."");
            return;
        }
    }    
?>
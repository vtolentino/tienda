<?php
    if(isset($_POST["enviar"])) {
        require("../../session/conexion/bd.php");
        // $insert ="INSERT INTO Op_Productos (codigo,nombre,cantidad,precio) VALUES ('{$_POST['codigo']}','{$_POST['nombre']}','{$_POST['cantidad']}','{$_POST['precio']}');";
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
        if($_POST['precio']==""){
            $_POST['precio']=0;
        }
        $fecha=date('Y-m-d H:i:s');
        $update="UPDATE Op_Productos SET kilo='{$kilos}',estado='{$_POST['estado']}',comision='{$comision}',cantidad_comision='{$cantidad_comision}',fecha_utlima_actualizacion='{$fecha}',codigo='{$_POST['codigo']}',nombre='{$_POST['nombre']}',cantidad='{$_POST['cantidad']}',precio='{$_POST['precio']}' WHERE idOp_Productos={$_POST['id']};";
        if($resultado = $conexion->query($update)) {
            $error="Producto Guardado";
            Header("Location: ../productos.php?mensaje2=".$error."");
            return;
        }
    }    
?>
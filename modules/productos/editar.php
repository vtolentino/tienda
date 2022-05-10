<?php
    session_start();
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
        $cosultar = "select * from Op_Productos WHERE idOp_Productos={$_POST['id']};";
        $cosultar=$conexion->query($cosultar);
        $data_antes=$cosultar->fetch_array();
        if($data_antes!=null && count($data_antes)>0){
            foreach ($data_antes as $key => $value) {
                if(!is_numeric($key)){
                    $antes_array[$key]=$value;
                }
            }
        }
        $update="UPDATE Op_Productos SET kilo='{$kilos}',estado='{$_POST['estado']}',comision='{$comision}',cantidad_comision='{$cantidad_comision}',fecha_utlima_actualizacion='{$fecha}',codigo='{$_POST['codigo']}',nombre='{$_POST['nombre']}',cantidad='{$_POST['cantidad']}',precio='{$_POST['precio']}' WHERE idOp_Productos={$_POST['id']};";
        if($resultado = $conexion->query($update)) {
            $cosultar = "select * from Op_Productos where idOp_Productos={$_POST['id']};";
            $cosultar=$conexion->query($cosultar);
            $data=$cosultar->fetch_array();
            if($data!=null && count($data)>0){
                $new_array=[];
                foreach ($data as $key => $value) {
                    if(!is_numeric($key)){
                        $new_array[$key]=$value;
                    }
                }
                $new_array=json_encode($new_array);
                $antes_array=json_encode($antes_array);
                $insertar_log="INSERT INTO tiendas.Trans_Log (Tabla, id, Antes, Despues,idOp_Usuarios, estado, fecha_utlima_actualizacion) VALUES('Op_Productos',{$_POST['id']}, '{$antes_array}', '{$new_array}',{$_SESSION['id']}, 1, '{$fecha}');";
                $conexion->query($insertar_log);
            }
            $error="Producto Guardado";
            Header("Location: ../productos.php?mensaje2=".$error."");
            return;
        }
    }    
?>
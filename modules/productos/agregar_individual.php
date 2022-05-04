<?php
    require("../../session/conexion/bd.php");
    $cosultar = "select * from Op_Productos where idOp_Productos='{$_POST['id']}' order by nombre";
    $response=[
        "error"=>true,
        "data"=>[]
    ];
    if($resultado = $conexion->query($cosultar)) {
        $data=$resultado->fetch_array();
        if($data!=null && count($data)>0){
            $response['error']=false;
            if ($_POST['id_individual']=="") {
                $cantidad_sobrante=$data['cantidad']-1;
                $update="UPDATE Op_Productos SET cantidad='{$cantidad_sobrante}' WHERE idOp_Productos={$_POST['id']};";
                $conexion->query($update);
                $insert ="INSERT INTO Op_productosIndividual (idOp_Productos,cantidad_caja,disponibles_caja,precio_individual,estado) 
                VALUES ('{$_POST['id']}','{$_POST['cantidad_total']}','{$_POST['disponibles']}','{$_POST['precio_individual']}','{$_POST['estado']}');";

            }else{
                $insert ="UPDATE Op_productosIndividual 
                        SET disponibles_caja={$_POST['cantidad_total']},precio_individual='{$_POST['precio_individual']}',estado={$_POST['estado']},cantidad_caja={$_POST['disponibles']}
                        WHERE idOp_productosIndividual={$_POST['id_individual']};";
            }
            if($resultado = $conexion->query($insert)) {
                $response['data']="Datos de venta individual guardados";
            }
        }
    }
    echo json_encode($response);
?>
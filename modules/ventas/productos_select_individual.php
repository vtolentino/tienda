<?php
    require("../../session/conexion/bd.php");
    $cosultar = "select * from Op_productosIndividual vi inner join Op_Productos p on p.idOp_Productos=vi.idOp_Productos where vi.estado=1 and p.estado=1 ";
    $response=[
        "error"=>true,
        "data"=>[]
    ];
    $array_nuevo=[];
    if($resultado = $conexion->query($cosultar)) {
        while($data = $resultado->fetch_array()){
            if($data!=null && count($data)>0){
                $response['error']=false;
                $array_nuevo[]=$data;
            }
        }
    }
    $response['data']=$array_nuevo;
    echo json_encode($response);
?>
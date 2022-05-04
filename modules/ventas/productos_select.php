<?php
    require("../../session/conexion/bd.php");
    $cosultar = "select * from Op_Productos where estado=1 order by nombre";
    $response=[
        "error"=>true,
        "data"=>[]
    ];
    $array_nuevo=[];
    if($resultado = $conexion->query($cosultar)) {
        // $data=$resultado->fetch_array();
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
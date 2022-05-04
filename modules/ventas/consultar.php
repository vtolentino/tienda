<?php
    require("../../session/conexion/bd.php");
    $cosultar = "select * from Op_Productos where codigo='{$_POST['codigo']}'";
    $response=[
        "error"=>true,
        "data"=>[]
    ];
    if($resultado = $conexion->query($cosultar)) {
        $data=$resultado->fetch_array();
        if($data!=null && count($data)>0){
            $response['error']=false;
            $response['data']=$data;
        }
    }
    echo json_encode($response);
?>
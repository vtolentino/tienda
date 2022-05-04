<?php
    require("../../session/conexion/bd.php");
    $cosultar = "select * from Op_productosIndividual vi inner join Op_Productos p on p.idOp_Productos=vi.idOp_Productos where vi.estado=1 and idOp_productosIndividual='{$_POST['id']}'";
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
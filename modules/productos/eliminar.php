<?php
    require("../../session/conexion/bd.php");
    $eliminar = "DELETE FROM Op_Productos WHERE idOp_Productos={$_GET['idOp_Productos']};";
    if($resultado = $conexion->query($eliminar)) {
        $error="Producto Eliminado";
        Header("Location: ../productos.php?mensaje2=".$error."");
        return;
    }else{
        $error="Error";
        Header("Location: ../productos.php?mensaje2=".$error."");
        return;
    }
?>
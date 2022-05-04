<?php
    require("../../session/conexion/bd.php");
    $eliminar = "DELETE FROM Op_Usuarios WHERE idOp_Usuarios={$_GET['idOp_Usuarios']};";
    if($resultado = $conexion->query($eliminar)) {
        $error="Usuario Eliminado";
        Header("Location: ../usuarios.php?mensaje2=".$error."");
        return;
    }else{
        $error="Error";
        Header("Location: ../usuarios.php?mensaje2=".$error."");
        return;
    }
?>
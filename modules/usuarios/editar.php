<?php
    if(isset($_POST["enviar"])) {
        require("../../session/conexion/bd.php");
        if(!empty($_POST['pwd'])){
            $_POST['pwd'] = preg_replace('([^A-Za-z0-9_/.-@])', '', $_POST['pwd']);
            $_POST['pwd']=md5($_POST['pwd']);
            $_POST['pwd']="pwd='{$_POST['pwd']}',";
        }
        $_POST['usuario'] = preg_replace('([^A-Za-z0-9_/.-@])', '', $_POST['usuario']);
        // $cosultar = "select * from Op_Usuarios where usuario='{$_POST['usuario']}'";
        // $cosultar=$conexion->query($cosultar);
        
        // if(count($cosultar->fetch_array())>0){
        //     $error="Usuario Existente";
        //     Header("Location: ../edit_usuario.php?mensaje=".$error."");
        //     return;
        // }
        $fecha=date('Y-m-d H:i:s');
        $update="UPDATE tiendas.Op_Usuarios SET {$_POST['pwd']}usuario='{$_POST['usuario']}',tipo={$_POST['tipo']},fecha_utlima_actualizacion='{$fecha}',estado={$_POST['estado']} WHERE idOp_Usuarios={$_POST['id']};";
        if($resultado = $conexion->query($update)) {
            $error="Usuario Guardado";
            Header("Location: ../usuarios.php?mensaje2=".$error."");
            return;
        }
    }    
?>
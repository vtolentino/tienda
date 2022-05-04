<?php
    if(isset($_POST["enviar"])) {
        require("../../session/conexion/bd.php");
        $_POST['pwd'] = preg_replace('([^A-Za-z0-9_/.-@])', '', $_POST['pwd']);
        $_POST['pwd']=md5($_POST['pwd']);
        $_POST['usuario'] = preg_replace('([^A-Za-z0-9_/.-@])', '', $_POST['usuario']);
        $cosultar = "select * from Op_Usuarios where usuario='{$_POST['usuario']}'";
        $cosultar=$conexion->query($cosultar);
        echo '<pre>';
        // print_r($resultado);
        if($cosultar!=null && count($cosultar->fetch_array())>0){
            $error="Usuario Existente";
            Header("Location: ../usuarios.php?mensaje=".$error."");
            return;
        }
        $insert = "INSERT INTO Op_Usuarios (usuario,pwd,tipo)
            VALUES ('{$_POST['usuario']}','{$_POST['pwd']}','{$_POST['tipo']}')";
        if($resultado = $conexion->query($insert)) {
            $error="Usuario Guardado";
            Header("Location: ../usuarios.php?mensaje=".$error."");
            return;
        }
    }    
?>
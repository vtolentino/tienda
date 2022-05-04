<?php
//verifica que los datos sean enviados por un botn llamado "enviar"
try {
    if(isset($_POST["enviar"])) {
        require("../conexion/bd.php");
        //recoleccion de datos
            $loginNombre = $_POST["usuario"];
            $loginPassword = $_POST["pwd"];
            //proivicion y sustitucion de caracteres especiales
            $contra = $loginPassword;
            $texto = preg_replace('([^A-Za-z0-9_/.-@])', '', $contra);
            //echo $texto." ".$loginNombre;
            //cifrado de contraseña(en la base de dato tambien tiene que estar cifrado)
            $contraCam=md5($texto);
            
            //creamos y ejecutamos la consulta
            $consulta = "SELECT * FROM Op_Usuarios WHERE usuario='$loginNombre' AND pwd='$contraCam' AND estado=1";
            if($resultado = $conexion->query($consulta)) {
                //guardamos los datos extraidos de la bd en una variable 
                while($row = $resultado->fetch_array()) {
                    $username = $row["usuario"];
                    $passok = $row["pwd"];
                    $id= $row["idOp_Usuarios"];
                    $tipo= $row["tipo"];
                }
                $resultado->close();
            }
            $conexion->close();
            //comparamos que los datos enviados y los datos guardados sean los mismos
            if(isset($loginNombre) && isset($contraCam)) {
                if($loginNombre == $username && $contraCam == $passok) {
                    /* establecer el limitador de caché a 'private' */
                    session_cache_limiter('private');
                    /* establecer la caducidad de la caché a 30 minutos */
                    session_cache_expire(300);
                    /* iniciar la sesión */
                    session_start();
                    $_SESSION["logueado"] = TRUE;//si todo se cumple se crear varuables globales
                    $_SESSION["id"]=$id;
                    $_SESSION["usr"]=$username;
                    $_SESSION["tipo"]=$tipo;
                    // print_r($_SESSION);
                    // die();
                    Header("Location: ../../modules/ventas.php");
                    // Header("Location: ../../body-admin/home.php");
                }else {
                    //redireccionamos encaso de k los datos no sean iguales
                    $error="Usuario o Contraseña inconrrectos";
                    Header("Location: ../../index.php?error=".$error."");
                }
            }
            //redireccionamos encaso de k los datos no fuesen enviado por el boton "enviar"
    } else {
        header("Location: index.php");
    }
} catch (\Exception $e) {
    echo '<pre>';
    print_r($e->getMessage());
    echo '</pre>';
}
?>
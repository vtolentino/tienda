<?php
$server = "localhost";
$base_datos = "tiendas";
$usuario = "root";
$pwd = "Carlitos-1";
// Create connection
$conexion= mysqli_connect($server, $usuario, $pwd, $base_datos);
// Check connection
if (!$conexion) {
    die("Conexion fallida: " . mysqli_connect_error());
}

?>
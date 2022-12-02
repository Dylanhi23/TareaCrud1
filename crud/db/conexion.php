<?php
// creamos la conexion a la base de datos tarea1

try {
    $llave=mysqli_connect("127.0.0.1", "usuario", "secret0", "tarea1");
}catch(Exception $ex){
    $codigoError=mysqli_connect_errno();
    die("Error codigo = $codError al conectar a la base de datos: ". $ex->getMessage());
}
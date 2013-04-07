<?php
include_once("../databasecon.php");
if (isset($_GET['email'])) {
    $conexion = mysql_connect($host, $username, $password);
    if (!$conexion) {
        die('Error Interno de Base de datos');
    }
    try {
        mysql_select_db($database, $conexion);
        $email = $_GET['email'];
        $result = mysql_query("SELECT count(*) AS contador FROM usuario WHERE correo='" . mysql_real_escape_string($email) . "'",$conexion);
        $row = mysql_fetch_array($result);
        if ($row['contador'] == 1) {
            $result1 = mysql_query("SELECT id,contrasenia FROM usuario WHERE correo='" . mysql_real_escape_string($email) . "'");
            $rw = mysql_fetch_array($result1);
            mysql_query("INSERT INTO solicitud_x_usuario (usuario_id,solicitud_id,hash) VALUES('".mysql_real_escape_string($rw['id'])."',2,'".md5($rw['contrasenia'])."')", $conexion);
        } else {
            echo("No se encontro su cuenta");
        }
    } catch (Exception $e) {
        throw new Exception('Something really gone wrong', 0, $e);
        echo("ocurrio un error interno");
    }
} else {
    echo("No se ha recibido ningun parametro, revise la documentacion");
}
?>
<?php

include_once("../databasecon.php");
if (isset($_GET['hash'])) {
    $conexion = mysql_connect($host, $username, $password);
    if (!$conexion) {
        die('Error Interno de Base de datos');
    }
    try {
        mysql_select_db($database, $conexion);
        $result = mysql_query("SELECT count(*) AS contador FROM solicitud_x_usuario WHERE hash='" . mysql_real_escape_string($_GET['hash']) . "'", $conexion);
        $row = mysql_fetch_array($result);
        if ($row['contador'] == 1) {
            //procesa el hash
            $result1 = mysql_query("SELECT usuario_id,solicitud_id FROM solicitud_x_usuario WHERE hash='" . mysql_real_escape_string($_GET['hash']) . "'", $conexion);
            $rw = mysql_fetch_array($result1);
            $solicitud = $rw['solicitud_id'];
            $usuario = $rw['usuario_id'];
            if ($solicitud == '1') {
                //activar cuenta	
                mysql_query("UPDATE usuario set estado ='activo' WHERE id=" . $usuario, $conexion);
                mysql_query("DELETE FROM solicitud_x_usuario WHERE hash='" . mysql_real_escape_string($_GET['hash']) . "'", $conexion);
            } else if ($solicitud == '2') {
                //recuperar password
                if(isset($_GET['password'])){
                mysql_query("UPDATE usuario set contrasenia ='". mysql_real_escape_string(md5($_GET['password'])) ." ' WHERE id=" . $usuario, $conexion);
                mysql_query("DELETE FROM solicitud_x_usuario WHERE hash='" . mysql_real_escape_string($_GET['hash']) . "'", $conexion);
                }else{
                    echo("Parametros incorrectos,consultar manual");
                }
            }
        } else {
            //no hay hash ya fue procesado
            echo('La peticion ya fue procesada o no existe');
        }
    } catch (Exception $e) {
        throw new Exception('Something really gone wrong', 0, $e);
    }
} else {
    echo("Parametros incorrectos,consultar manual");
}
?>
<?php

include_once("../databasecon.php");
if (isset($_POST['user']) && isset($_POST['password'])) {
    $conexion = mysql_connect($host, $username, $password);
    if (!$conexion) {
        die('Error Interno de Base de datos');
    }
    try {
        mysql_select_db($database, $conexion);
        $usr = $_POST['user'];
        $pwd = $_POST['password'];
        $result = mysql_query("SELECT count(*) AS contador FROM usuario WHERE correo='" . mysql_real_escape_string($usr) . "'",$conexion);
        $row = mysql_fetch_array($result);
        if ($row['contador'] == 1) {
            $result1 = mysql_query("SELECT nombre,dpi,contrasenia,estado FROM usuario WHERE correo='" . mysql_real_escape_string($usr) . "'");
            $rw = mysql_fetch_array($result1);
            if ($rw['estado'] == 'activo') {
                if (trim($rw['contrasenia']) == trim(md5($pwd))) {
                    session_start();
                    $_SESSION['nombre'] = $rw['nombre'];
                    $_SESSION['dpi'] = $rw['dpi'];
                    $_SESSION['correo'] = $usr;
                } else {
                    echo("La combinacion usuario/password no existe");
                }
            } else {
                echo("La cuenta no esta activa, active su cuenta antes de proseguir");
            }
        } else {
            echo("La cuenta no existe.");
        }
    } catch (Exception $e) {
        throw new Exception('Something really gone wrong', 0, $e);
        echo("ocurrio un error interno");
    }
} else {
    echo("No se ha recibido ningun parametro, revise la documentacion");
}
?>
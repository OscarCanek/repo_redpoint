<?php
include_once("../databasecon.php");
if (isset($_POST['iden']) && isset($_POST['name']) && isset($_POST['password']) && isset($_POST['id_pais']) && isset($_POST['email'])) {
    $conexion = mysql_connect($host, $username, $password);
    if (!$conexion) {
        die('Error Interno de Base de datos');
    }
    try {
        mysql_select_db($database, $conexion);
        $dpi = $_POST['iden'];
        $result = mysql_query("SELECT count(*) AS contador FROM usuario WHERE dpi='" . mysql_real_escape_string($dpi) . "' or correo ='".mysql_real_escape_string($_POST['email'])."'",$conexion);
        $row = mysql_fetch_array($result);
        if ($row['contador'] == 0) {
            mysql_query("INSERT INTO usuario (nickname, nombre, dpi, contrasenia, correo, estado, PAIS_id) VALUES ('" . mysql_real_escape_string($_POST['name']) . "', '" .mysql_real_escape_string( $_POST['name']) . "','" . mysql_real_escape_string($dpi). "','" . mysql_real_escape_string(md5($_POST['password'])) . "','" .mysql_real_escape_string( $_POST['email']) . "','inactivo'," . mysql_real_escape_string($_POST['id_pais']). ")", $conexion);
            $result1 = mysql_query("SELECT id FROM usuario WHERE dpi='" . mysql_real_escape_string($dpi) . "'");
            $rw = mysql_fetch_array($result1);
            mysql_query("INSERT INTO solicitud_x_usuario (usuario_id,solicitud_id,hash) VALUES('".mysql_real_escape_string($rw['id'])."',1,'".mysql_real_escape_string(md5($dpi))."')",$conexion)or die("Could not perform select query - " . mysql_error());;
        } else {
            echo("Ya existe un usuario con ese DPI o email, si el DPI es suyo puede enviar un correo a estecorreonoexiste@estedominiotampoco.com");
        }
    } catch (Exception $e) {
        throw new Exception('Something really gone wrong', 0, $e);
        echo("ocurrio un error interno");
    }
} else {
    echo("No se ha recibido ningun parametro, revise la documentacion");
}
?>
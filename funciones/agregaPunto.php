<?php
include_once("../databasecon.php");
session_start();
if (isset($_POST['lat']) && isset($_POST['lon']) && isset($_POST['fec']) && isset($_POST['com']) && isset($_POST['tip']) && isset($_POST['obj'])) {
    $conexion = mysql_connect($host, $username, $password);
    if (!$conexion) {
        die('Error Interno de Base de datos');
    }
    try {
        mysql_select_db($database, $conexion);
		if(isset($_SESSION['correo'])) {
        	$correo = $_SESSION['correo'];
		} else { 
			$correo = 'anonimo@redpoint.com'; 
		}
		$result= mysql_query("SELECT id FROM usuario WHERE correo='" . mysql_real_escape_string($correo) . "'",$conexion) or die(mysql_error());
		$row = mysql_fetch_array($result);
		$idTipoPunto = $_POST['tip'];
		$idUsuario =$row['id'];
		mysql_query("INSERT INTO punto (lat, lng, fecha, activo, usuario_id, tipo_punto_id) VALUES ('" . mysql_real_escape_string($_POST['lat']) . "', '" .mysql_real_escape_string( $_POST['lon']) . "','" . mysql_real_escape_string($_POST['fec']). "','" . mysql_real_escape_string('true') . "','" . $idUsuario . "','" . $idTipoPunto . "')", $conexion) or die(mysql_error());
		mysql_query("INSERT INTO comentario (descripcion, punto_lat, punto_long, punto_fecha) VALUES ('" . mysql_real_escape_string($_POST['com']) . "','" . mysql_real_escape_string($_POST['lat']) . "', '" .mysql_real_escape_string( $_POST['lon']) . "','" . mysql_real_escape_string($_POST['fec']). "')", $conexion) or die(mysql_error());
        
		$objetos = explode(",", $_POST['obj']);
		$contador = 1;
		for($o=0;$o<sizeof($objetos);$o++){
			$objeto = $objetos[$o];
				if($objeto == 'true') { $idObjeto = $contador; 
			
            mysql_query("INSERT INTO detalle_punto (punto_lat, punto_long, punto_fecha, objeto_id) VALUES ('" . mysql_real_escape_string($_POST['lat']) . "', '" . mysql_real_escape_string( $_POST['lon']) . "','" . mysql_real_escape_string($_POST['fec']) . "','" . mysql_real_escape_string($idObjeto) . "')", $conexion) or die(mysql_error());
			}
			$contador = $contador + 1;
		}
    } catch (Exception $e) {
        throw new Exception('Something really gone wrong', 0, $e);
        echo("ocurrio un error interno");
    }
} else {
    echo("No se ha recibido ningun parametro, revise la documentacion");
}
?>
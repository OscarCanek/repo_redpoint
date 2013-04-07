<?php
include_once("../databasecon.php");
if(isset($_POST['lat']) && isset($_POST['lng'])){
	$latitude = $_POST['lat'];
	$longitude = $_POST['lng'];

$conexion = mysql_connect($host, $username, $password);
	if (!$conexion) {
		die('Error Interno de Base de datos');
	}	
	mysql_select_db($database, $conexion);	
	$query = mysql_query("INSERT INTO punto (latitud, longitud,fecha,usuario_id_usuario,tipo_punto_id_tipo_punto) VALUES ("
	. "'" . mysql_real_escape_string($latitude) . "'," 
	. "'" . mysql_real_escape_string($longitude) . "'," 
	. "date(sysdate()),"
	. "1,1)", $conexion) or die(mysql_error());
	echo('success');
}else{
	echo('fail');
	}

?>
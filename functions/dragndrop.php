<?php 
include_once("../databasecon.php"); //cambiar la ruta
$con = mysql_connect($host, $username, $password);
if (isset($_POST['newLat']) && isset($_POST['newLng']) && isset($_POST['oldLat'])&& isset($_POST['oldLng'])) {
    $newLat = $_POST['newLat'];
	$newLng = $_POST['newLng'];
	$oldLat = $_POST['oldLat'];
	$oldLng = $_POST['oldLng'];
    if ($con) {
        //db
        mysql_select_db($database, $con);
        $sqlport = mysql_query("UPDATE punto SET latitud='" . mysql_real_escape_string($newLat) . "', longitud='" . mysql_real_escape_string($newLng) . "' where latitud='". mysql_real_escape_string($oldLat) ."' and longitud='". mysql_real_escape_string($oldLng)."'" , $con) or die(mysql_error());
        mysql_close($con);
		echo 'success';
	} else { echo 'fallo conexion'; }
} else { echo 'fallaron datos'; }
?>
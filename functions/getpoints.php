<?php
include_once("../databasecon.php");
$conexion = mysql_connect($host, $username, $password);
	if (!$conexion) {
		die('Error Interno de Base de datos');
	}	
	mysql_select_db($database, $conexion);	
	$result = mysql_query("select latitud,longitud from punto");
$rown = 0;
while($row = mysql_fetch_array($result))
  {
	  if($rown ==0){
	  $rown++;
	  $texto = "[{\"lat\": ".$row['latitud'] .",\"lng\":".$row['longitud']."}";
	  }else{
	   $texto = $texto .",{\"lat\": ".$row['latitud'] .",\"lng\":".$row['longitud']."}";
	  }
  }
   $texto = $texto ."]";
echo($texto);
?>
<?php
include_once("../databasecon.php");
$conexion = mysql_connect($host, $username, $password);
	if (!$conexion) {
		die('Error Interno de Base de datos');
	}	
	mysql_select_db($database, $conexion);	
	$result = mysql_query("select lat,lng from punto");
$rown = 0;
while($row = mysql_fetch_array($result))
  {
	  if($rown ==0){
	  $rown++;
	  $texto = "[{\"lat\": ".$row['lat'] .",\"lng\":".$row['lng']."}";
	  }else{
	   $texto = $texto .",{\"lat\": ".$row['lat'] .",\"lng\":".$row['lng']."}";
	  }
  }
   $texto = $texto ."]";
echo($texto);
?>
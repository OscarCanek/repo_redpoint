<html>
<head></head>
<style>
body{
	background-color:#FFF;
}
</style>
<?php
//credenciales de conexion a mysql
$host = 'mysql16.000webhost.com';
$user = 'a2350597_rp';
$pass = 'orcs1991';
$db = 'a2350597_rp';

if(isset($_POST['edad'])&&isset($_POST['dpi'])&&isset($_POST['nombre1'])&&isset($_POST['nombre2'])&&isset($_POST['apellido1'])&&isset($_POST['apellido2'])&&isset($_POST['pais'])&&isset($_POST['email'])&&isset($_POST['pw'])&&isset($_POST['correctpw'])){
//loading mysql
$conexion = mysql_connect($host, $user, $pass);
	if (!$conexion) {
		echo("<body onLoad=\"javascript:window.parent.showerror('Error Interno:','Se ha producido un error de base de datos, intentelo mas tarde.')\">"	);
		die('Error Interno de Base de datos');
	}	
	mysql_select_db($db, $conexion);
	
$dpi = $_POST['dpi'];
$n1 = $_POST['nombre1'];
$n2 = $_POST['nombre2'];
$a1 = $_POST['apellido1'];
$a2 = $_POST['apellido2'];
$correo = $_POST['email'];
$pass = $_POST['pw'];
$codPais = $_POST['pais'];

$query = mysql_query("INSERT INTO usuario (dpi, nombre1, nombre2, apellido1, apellido2,correo,contrasena, pais_codigo_pais) VALUE ("
	. "'" . mysql_real_escape_string($dpi) . "'," 
	. "'" . mysql_real_escape_string($n1) . "'," 
	. "'" . mysql_real_escape_string($n2) . "',"
	. "'" . mysql_real_escape_string($a1) . "',"
	. "'" . mysql_real_escape_string($a2) . "',"
	. "'" . mysql_real_escape_string($correo) . "',"
	. "'" . mysql_real_escape_string($pass) . "',"
	. mysql_real_escape_string($codPais) .
	")", $conexion) or die(mysql_error());
$query2 = mysql_query("SELECT nombre1,nombre2,apellido1,apellido2,correo FROM usuario WHERE dpi='$dpi'", $conexion);
$row = mysql_fetch_array( $query2 );
$nombrecompleto = $row['nombre1']." ".$row['nombre2']." ".$row['apellido1']." ".$row['apellido2'];
$correoe = $row['correo'];
$mensaje ="Estimado: $nombrecompleto,<br>Tu registro ha sido exitoso. Para continuar debes verificar tu cuenta.<br> Se ha enviado un correo a: $correoe para que lo hagas.<br>Gracias por utilizar RedPoint.";
//close mysql conection	
echo("<body onLoad=\"javascript:window.parent.showsuccess('Registro Exitoso:','$mensaje')\">"	);
}else{
	$errortext = "No se recibieron los datos";
	$count = 0;
if(!isset($_POST['dpi'])){
	if($count>0){
		$errortext = $errortext.", DPI";
	}else{
		$errortext = $errortext.": DPI";
		$count++;
	}
}
if(!isset($_POST['nombre1'])){
	if($count>0){
		$errortext = $errortext.", Primer Nombre";
	}else{
		$errortext = $errortext.": Primer Nombre";
		$count++;
	}	
}
if(!isset($_POST['nombre2'])){
	if($count>0){
		$errortext = $errortext.", Segundo Nombre";
	}else{
		$errortext = $errortext.": Segundo Nombre";
		$count++;
	}	
}
if(!isset($_POST['apellido1'])){
	if($count>0){
		$errortext = $errortext.", Primer Apellido";
	}else{
		$errortext = $errortext.": Primer Apellido";
		$count++;
	}	
}
if(!isset($_POST['apellido2'])){
	if($count>0){
		$errortext = $errortext.", Segundo Apellido";
	}else{
		$errortext = $errortext.": Segundo Apellido";
		$count++;
	}	
}
if(!isset($_POST['pais'])){
	if($count>0){
		$errortext = $errortext.", Pais";
	}else{
		$errortext = $errortext.": Pais";
		$count++;
	}	
}
if(!isset($_POST['email'])){
	if($count>0){
		$errortext = $errortext.", Correo Electronico";
	}else{
		$errortext = $errortext.": Correo Electronico";
		$count++;
	}	
}
if(!isset($_POST['pw'])){
	if($count>0){
		$errortext = $errortext.", Contrase&ntilde;a";
	}else{
		$errortext = $errortext.": Contrase&ntilde;a";
		$count++;
	}	
}
if(!isset($_POST['correctpw'])){
	if($count>0){
		$errortext = $errortext.", Confirmacion de contrase&ntilde;a";
	}else{
		$errortext = $errortext.": Confirmacion de contrase&ntilde;a";
		$count++;
	}	
}
if(!isset($_POST['edad'])){
	if($count>0){
		$errortext = $errortext.", Edad";
	}else{
		$errortext = $errortext.": Edad";
		$count++;
	}	
}	
$errortext = $errortext.". Trate de registrarse de nuevo, o mas tarde.";
	
echo("<body onLoad=\"javascript:window.parent.showerror('Error Interno:','$errortext')\">"	);

}

?>
</body>
</html>
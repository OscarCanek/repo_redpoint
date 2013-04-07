<?php

//include_once("funciones/funciones.php");
include_once("funciones/prev-funciones.php");
/* Aqui se ejecutaran todas las funciones del sistema, para poder enviar respuesta por ajaz
 * 
 */
$prevfunc = new prevFunciones(); //instancia del prev-funciones funciones antes de estar loggeado
//$func = new Funciones();// funciones al momento de estar loggeado
$accion = strtolower($_POST['accion']);
if ($accion == "login") {
    $usuario = $_POST['username'];
    $contrasenia = $_POST['password'];
    $prevfunc->login($usuario, $contrasenia);
} else if ($accion == "register") {
    $dpi = $_POST['dpi'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $pw1 = $_POST['passwordr'];
    $pw2 = $_POST['vpassword'];
    $pais = $_POST['pais'];
    $prevfunc->register($dpi, $nombre, $email, $pw1, $pw2, $pais);
} else if ($accion == "activate") {
    $cda = $_POST['cda'];
    $prevfunc->activateAccount($cda);
} else if ($accion == "forgot01"){
    $email = $_POST['emails'];
    $prevfunc->passwordRecovery($email);
}else if ($accion=="forgot02"){
    $pw1 = $_POST['pw1'];
    $pw2 = $_POST['pw2'];
    $hash =$_POST['pwcode'];
    $prevfunc->changePassword($hash, $pw1, $pw2);
} else{
    echo($accion);
    echo "El servidor no comprendio la peticion y se nego a completarla";
}
?>

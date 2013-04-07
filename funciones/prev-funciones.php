<?php

include "validaciones.php";
/*
  aqui se concentran todas las funciones que tiene la pagina sin hacer login
 */

class prevFunciones {

    public function register($dpi, $nombre, $email, $pw1, $pw2, $country) {
        //se instancia la clase validacion
        $validator = new validacion();
        //para registrar primero vemos si el dpi es valido
        if ($validator->validaDPI($dpi)) {
            //se verifica que el DPI no exista en la base de datos
            if (!$validator->dpiExists($dpi)) {
                //se verifica que el correo sea valido
                if ($validator->validaEmail($email)) {
                    //se verifica que el correo no exista en la base de datos
                    if (!$validator->emailExists($email)) {
                        //se verifica que el nombre no este vacio
                        if ($validator->validaCampo($nombre)) {
                            //se verifica que las passwords sean identicas
                            if ($validator->validaPasswords($pw1, $pw2)) {
                                //se realiza el registro
                                //inserta en la base de datos el usuario
                                $query = "INSERT INTO usuario (nickname, nombre, dpi, contrasenia, correo, estado, PAIS_id) VALUES ('" . mysql_real_escape_string($nombre) . "', '" . mysql_real_escape_string($nombre) . "','" . mysql_real_escape_string($dpi) . "','" . mysql_real_escape_string(md5($pw1)) . "','" . mysql_real_escape_string($email) . "','inactivo'," . mysql_real_escape_string($country) . ")";
                                $connexion = new conexion();
                                $result = $connexion->doQuery($query);
                                if ($result) {
                                    //como el insert fue exitoso ahora busca el id del usuario
                                    $query = "SELECT id FROM usuario WHERE dpi='" . mysql_real_escape_string($dpi) . "'";
                                    $result = $connexion->doQuery($query);
                                    $rs = mysql_fetch_array($result);
                                    $id = $rs['id'];
                                    //ya que se tiene el id se procede a insertar en peticiones y enviar el correo al usuario
                                    $query = "INSERT INTO solicitud_x_usuario (usuario_id,solicitud_id,hash) VALUES('" . mysql_real_escape_string($id) . "',1,'" . mysql_real_escape_string(md5($dpi)) . "')";
                                    $result = $connexion->doQuery($query);
                                    if ($result) {
                                        $this->sendMail($email, "Su codigo de activacion es el siguiente:" . md5($dpi) . "\r\nIngrese a la pagina principal, luego en iniciar sesion y por ultimo clic en activa tu cuenta.\r\nGracias por ayudarnos a mejorar Guatemala!\r\n\r\nThe Redpoint Team", "Activacion de su cuenta de RedPoint");
                                    }
                                }
                                return $result;
                            } else {
                                echo('Los passwords ingresados son diferentes, o estan vacios');
                                return false;
                            }
                        } else {
                            echo('El nombre ingresado es invalido');
                            return false;
                        }
                    } else {
                        echo('El email ingresado ya ha sido utilizado');
                        return false;
                    }
                } else {
                    echo('El email ingresado es invalido');
                    return false;
                }
            } else {
                echo('El dpi ingresado ya ha sido utilizado');
                return false;
            }
        } else {
            echo('El dpi ingresado es invalido 13 digitos pueden ir separados por espacios');
            return false;
        }
    }

    public function sendMail($to, $message, $subject) {
        $headers = 'From: no-reply@redpoint.herobo.com' . "\r\n" .
                'Reply-To: no-reply@redpoint.herobo.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
        mail($to, $subject, $message, $headers);
    }

    public function login($email, $pass) {
        //se chequea que ambos campos sean validos
        $validator = new validacion();
        if ($validator->validaEmail($email)) {
            if ($validator->validaCampo($pass)) {
                //se verifica que exista el email
                if ($validator->emailExists($email)) {
                    //si existe se verifica la combinacion
                    $conex = new conexion();
                    $query = "SELECT contrasenia,estado FROM usuario WHERE correo='" . mysql_real_escape_string($email) . "'";
                    $result = $conex->doQuery($query);
                    $rs = mysql_fetch_array($result);
                    if ($rs['estado'] == 'activo') {
                        if (trim($rs['contrasenia']) == trim(md5($pass))) {
                            session_start();
                            $_SESSION['correo']=$email;
                            return true;
                        } else {
                            echo("Contraseña invalida");
                            return false;
                        }
                    } else {
                        echo("Su cuenta no esta activa, por favor activela para poder utilizarla");
                    }
                } else {
                    echo("No existe alguna cuenta con este correo");
                    return false;
                }
            } else {
                echo("No introdujo una contraseña");
                return false;
            }
        } else {
            echo("El email introducido no es valido");
            return false;
        }
    }

    public function passwordRecovery($email) {
        //valida que el campo no este vacio
        $validator = new validacion();
        if ($validator->validaEmail($email)) {
            //si el email es valido hay que ver si existe
            if ($validator->emailExists($email)) {
                //si existe se crea una peticion de cambio de contrasenia
                $conex = new conexion();
                $query = "SELECT id,contrasenia FROM usuario WHERE correo='" . mysql_real_escape_string($email) . "'";
                $result = $conex->doQuery($query);
                $rw = mysql_fetch_array($result);
                $query = "INSERT INTO solicitud_x_usuario (usuario_id,solicitud_id,hash) VALUES('" . mysql_real_escape_string($rw['id']) . "',2,'" . md5($rw['contrasenia']) . "')";
                $result = $conex->doQuery($query);
                if ($result) {
                    //se envia el mail
                    $this->sendMail($email, "Ud recibio este mensaje porque pidio recuperar su contraseña, su codigo es: " . md5($rw['contrasenia']) . "\r\nGracias por ayudarnos a cambiar Guatemala!\r\n\r\nThe Redpoint Team.", "Solicitud Cambio de Credenciales");
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getHashType($hash) {
        //valida que el campo no este vacio
        $validator = new validacion();
        if ($validator->validaCampo($hash)) {
            //se verifica que exista el hash
            if ($validator->hashExists($hash)) {
                //si existe se obtiene el tipo;
                $conex = new conexion();
                $query = "SELECT solicitud_id FROM solicitud_x_usuario WHERE hash='" . mysql_real_escape_string($hash) . "'";
                $result = $conex->doQuery($query);
                $rw = mysql_fetch_array($result);
                return $rw['solicitud_id'];
            } else {
                return "hash not exist";
            }
        } else {
            return "invalid hash";
        }
    }

    public function changePassword($hash, $pw1, $pw2) {
        $tipo = $this->getHashType($hash);
        $validator = new validacion();
        if ($tipo == "2" || $tipo == "3") {//en caso que el tipo sea recuperar o cambiar contraseña
            //se obtiene al usuario de la solicitud
            $conex = new conexion();
            $query = "SELECT usuario_id FROM solicitud_x_usuario WHERE hash='" . mysql_real_escape_string($hash) . "'";
            $result = $conex->doQuery($query);
            $rw = mysql_fetch_array($result);
            $usuario = $rw['usuario_id'];
            if ($validator->validaPasswords($pw1, $pw2)) {
                $query = "UPDATE usuario set contrasenia ='" . mysql_real_escape_string(md5($pw2)) . " ' WHERE id=" . $usuario;
                $result = $conex->doQuery($query);
                if ($result) {
                    $query = "DELETE FROM solicitud_x_usuario WHERE hash='" . mysql_real_escape_string($hash) . "'";
                    $result = $conex->doQuery($query);
                    return result;
                } else {
                    echo("en este momento no se puede cambiar tu contraseña, intentalo mas tarde");
                    return false;
                }
            } else {
                echo("los passwords no son iguales, o estan vacios");
                return false;
            }
        } else {
            echo("este hash es invalido para esta operacion");
            return false;
        }
    }

    public function activateAccount($hash) {
        $tipo = $this->getHashType($hash);
        if ($tipo == 1) {//el tipo para activar la cuenta
            //se obtiene al usuario de la solicitud
            $conex = new conexion();
            $query = "SELECT usuario_id FROM solicitud_x_usuario WHERE hash='" . mysql_real_escape_string($hash) . "'";
            $result = $conex->doQuery($query);
            $rw = mysql_fetch_array($result);
            $usuario = $rw['usuario_id'];
            $query = "UPDATE usuario set estado ='activo' WHERE id=" . $usuario;
            $result = $conex->doQuery($query);
            if ($result) {
                $query = "DELETE FROM solicitud_x_usuario WHERE hash='" . mysql_real_escape_string($hash) . "'";
                $result = $conex->doQuery($query);
                return result;
            } else {
                echo ("no se pudo activar su cuenta, pongase en contacto con admin@redpoint.herobo.com");
                return false;
            }
        } else {
            echo ("El hash introducido no es valido para activar su cuenta");
            return false;
        }
    }

}

?>

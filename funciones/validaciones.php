<?php

include_once("conexion.php");
/* Esta pagina php tendra todas las validaciones necesarias para los campos
 */

class validacion {
/*esto es lo que he hecho
 */ 
    public function emailExists($email) {
        /* verifica si el email existe en la base de datos */
        $conex = new conexion();
        $conex->testCon();
        $qry = "SELECT count(*) AS contador FROM usuario WHERE correo='" . mysql_real_escape_string($email) . "'";
        $rs = $conex->doQuery($qry);
        $row = mysql_fetch_array($rs);
        if ($row['contador'] == 0) {
            return false;
        } else {
            return true;
        }
    }
    
    public function hashExists($hash){
        $conex = new conexion();
        $conex->testCon();
        $qry = "SELECT count(*) AS contador FROM solicitud_x_usuario WHERE hash='" . mysql_real_escape_string($hash) . "'";
        $rs = $conex->doQuery($qry);
        $row = mysql_fetch_array($rs);
        if ($row['contador'] == 0) {
            return false;
        } else {
            return true;
        }
    }
    
    public function dpiExists($dpi){
        /* verifica si el DPI existe en la base de datos */
        $conex = new conexion();
        $conex->testCon();
        $qry = "SELECT count(*) AS contador FROM usuario WHERE dpi='" . mysql_real_escape_string($dpi) . "'";
        $rs = $conex->doQuery($qry);
        $row = mysql_fetch_array($rs);
        if ($row['contador'] == 0) {
            return false;
        } else {
            return true;
        }
    }
    public function validaEmail($txt) {
        if ($this->validaCampo($txt)) {
            /* Se valida si el email tiene el formato correcto */
            if (filter_var($txt, FILTER_VALIDATE_EMAIL)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function validaDPI($txt) {
        /* Se valida si el formato del DPI es correcto */
        if ($this->validaCampo($txt)) {
            $txt = str_replace(" ", "", $txt);
            if (strlen($txt) == 13 && is_numeric($txt)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function validaFechaHora($txt) {
        /* Se valida si el campo cumple con los requisitos de fecha y hora necesarios para la BD */
        if ($this->validaCampo($txt)) {
            return true;
        } else {
            return false;
        }
    }

    public function validaCampo($txt) {
        /* Valida que el campo no este vacio o tenga espacios */
        $txt = trim($txt);
        if (strlen($txt) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function validaPasswords($pw1, $pw2) {
        /* valida que las contraseñas sean iguales */
        if ($this->validaCampo($pw1) && $this->validaCampo($pw2)) {
            if ($pw1 == $pw2) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}

?>

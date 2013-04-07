<?php

include 'conexion.php';
/* debe estar loggeado para que se puedan utilizar estas funciones
 * 
 */

class funciones {

    public function getUserData($email) {
        $conex = new conexion();
        //se obtienen los datos del usuario y luego se
        $query = "SELECT nombre,nickname FROM usuario WHERE email='" . mysql_real_escape_string($email) . "'";
        $result = $conex->doQuery($query);
        $rs = mysql_fetch_array($result);
        $user = new usuario();
        $user->setVars($email, $rs['nickname'], $rs['nombre']);
        return $user;
    }

    public function getPointData($lat, $long, $json) {
        $conex = new conexion();
        //se obtienen los objetos del asalto
        $query = "SELECT `objeto`.nombre FROM `detalle_punto`,`objeto` WHERE punto_lat='" . mysql_real_escape_string($lat) . "' and punto_long='" . mysql_real_escape_string($long) . "' and `detalle_punto`.objeto_id = `objeto`.id";
        $result = $conex->doQuery($query);
        $objectlist;
        if ($json) {
            $objectlist = "";
            while ($row = mysql_fetch_array($result)) {
                $object = new objeto($row['nombre']);
                $objectList->insertar($object);
            }
        } else {
            $objectList = new LinkedList();
            while ($row = mysql_fetch_array($result)) {
                $object = new objeto($row['nombre']);
                $objectList->insertar($object);
            }
        }

        //se obtienen los comentarios
        $query = "SELECT descripcion,punto_fecha FROM `comentario` WHERE punto_lat='" . mysql_real_escape_string($lat) . "' and punto_long='" . mysql_real_escape_string($long) . "'";
        $result = $conex->doQuery($query);
        $commentList;
        $data;
        if ($json) {
            
        } else {
            $commentList = new LinkedList();
            while ($row = mysql_fetch_array($result)) {
                $comentario = array();
                $comentario['texto'] = $row['descripcion'];
                $comentario['fecha'] = $row['punto_fecha'];
                $object = new objeto($comentario);
                $objectList->insertar($object);
            }
            $data = array();
            $data['objetos'] = $objectList;
            $data['comentarios'] = $commentList;
        }
        return $data;
    }

    public function getUserPoints($email, $json) {
        $query = "SELECT punto.lat,punto.lng FROM usuario INNER JOIN punto ON punto.usuario_id=usuario.id WHERE usuario.correo='" . mysql_real_escape_string($email) . "'";
        $conex = new conexion();
        $result = $conex->doQuery($query);
//devuelve un json o un linkedlist dependiendo de $json
        if ($json) {
            //devuelve en forma de json
            $rown = 0;
            while ($row = mysql_fetch_array($result)) {
                if ($rown == 0) {
                    $rown++;
                    $texto = "[{\"lat\": " . $row['lat'] . ",\"lng\":" . $row['lng'] . "}";
                } else {
                    $texto = $texto . ",{\"lat\": " . $row['lat'] . ",\"lng\":" . $row['lng'] . "}";
                }
            }
            $texto = $texto . "]";
            return $texto;
        } else {
            //devuelve en forma de LinkedList
            $lista = new LinkedList();
            while ($row = mysql_fetch_array($result)) {
                $punto = new punto();
                $punto->setLatLong($row['lat'], $row['lng']);
                $lista->insertar($punto);
            }
            return $lista;
        }
    }

    public function addPoint($lat, $long, $usrid, $usuarioID, $tipo) {
        
    }

    public function addDetallePunto($lat, $long, $objectID) {
        
    }

    public function addComentarioPunto($lat, $long, $comentario) {
        
    }

}

class usuario {

    protected $email;
    protected $nickname;
    protected $name;

    public function setVars($email, $nickname, $name) {
        $this->email = $email;
        $this->name = $name;
        $this->nickname = $nickname;
    }

    public function getName() {
        return $this->name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getNick() {
        return $this->nickname;
    }

}

class punto {

    protected $lat;
    protected $long;
    protected $comments;
    protected $objects;

    public function __toString() {
        return "(" . $this->lat . "," . $this->long . ")";
    }

    public function setLatLong($lat, $long) {
        $this->lat = $lat;
        $this->long = $long;
    }

}

class objeto {

    protected $value = null;
    protected $_next = null;

    public function __construct($value) {
        $this->value = $value;
    }

    public function setNext($next) {
        $this->_next = $next;
    }

    public function getNext() {
        return $this->_next;
    }

    public function setVal($val) {
        $this->value = $val;
    }

    public function getVal() {
        return $this->value;
    }

}

class LinkedList {

    protected $_head = null;
    protected $_tail = null;

    public function insertar($objeto) {
        if ($this->_head == null) {
            $this->_head = $objeto;
            $this->_tail = $objeto;
            return;
        }
        $this->_tail->setNext($objeto);
        $this->_tail = $objeto;
    }

    public function __toString() {
        $current = $this->_head;
        $output = "";
        while ($current) {
            $output .= $current->getVal() . toString() . "\n";
            $current = $current->getNext();
        }
        return output;
    }

}

?>

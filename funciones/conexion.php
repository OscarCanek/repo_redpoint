<?php
/*
  Esta clase contiene los valores para realizar todas las conexiones de MySQL del proyecto
 */
error_reporting(0);
define("HOST", "localhost");
define("USERNAME", "redpoint_userdb");
define("PASSWORD", "redpointdb");
define("DATABASE", "redpoint_db");

class conexion {

    public function testCon() {
        $conexion = mysql_connect(HOST, USERNAME, PASSWORD);
        if (!$conexion) {
            ?>
            <div class="alert alert-block alert-error">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <h4>Warning!</h4>
                Ocurrio un error interno en el servidor, por favor comunicate con el administrador y proveele este codigo: "SQLCNTCON";
            </div>
            <?php
            mysql_close();
            return false;
        } else {
            mysql_close();
            return true;
        }
    }

    public function doQuery($txt) {
        if ($this->testCon()) {
            $conexion = mysql_connect(HOST, USERNAME, PASSWORD);
            mysql_select_db(DATABASE, $conexion) or die("no bd");
            $result = mysql_query($txt,$conexion) or die("la consulta no se puede realizar");
            mysql_close();
            return $result;
        } 
    }
    
}

?>

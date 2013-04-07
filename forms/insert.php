<?php
include_once '../databasecon.php';
$con = mysql_connect($host, $username, $password);
if (isset($_POST['lat']) && isset($_POST['lng']) && isset($_POST['datetime']) && isset($_POST['idTipoPunto']) && isset($_POST['comentario'])) {
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];
    $datetime = $_POST['datetime'];
    $idTipoPunto = $_POST['idTipoPunto'];
    $comentario = $_POST['comentario'];
    if ($con) {
        //db
        mysql_select_db($database, $con);
        $sqlport = mysql_query("INSERT INTO punto (latitud, longitud, fecha, usuario_id_usuario, tipo_punto_id_tipo_punto, comentario) VALUES ('" . mysql_real_escape_string($lat) . "', '" . mysql_real_escape_string($lng) . "','" . mysql_real_escape_string($datetime) . "', 1, " . mysql_real_escape_string($idTipoPunto) . ", '" . mysql_real_escape_string($comentario) . "')", $con) or die(mysql_error());
        $sql2 = mysql_query("SELECT LAST_INSERT_ID()");
        $algo = mysql_fetch_array($sql2);
        $idPunto = $algo['LAST_INSERT_ID()'];
        for ($i = 1; $i < 7; $i++) {
            if (isset($_POST['c' . $i])) {
                $tmp = $_POST['c' . $i];
                if ($tmp == 'on') {
                    $idContenido = $i;
                    $sqlport = mysql_query("INSERT INTO detalle_punto (punto_id_punto, contenido_id_contenido) VALUES (" . mysql_real_escape_string($idPunto) . ", " . mysql_real_escape_string($idContenido) . ")", $con) or die(mysql_error());
                }
            }
        }
        mysql_close($con);
        ?>
        <html><head></head><body onload="javascript:parent.confirmado(<?php echo($_POST['lat']); ?>,<?php echo($_POST['lng']); ?>);">
                Se ha guardado su punto exitosamente, gracias por utilizar RedPoint, puede cerrar el dialogo.
            </body></html>
        <?php
    } else {
        echo 'fallo conexion';
    }
} else {
    echo 'fallaron datos';
}
?>

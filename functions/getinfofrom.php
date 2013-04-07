<?php
include_once("../databasecon.php"); //cambiar esto si es necesario
$con = mysql_connect($host, $username, $password);
if ($con) {
    mysql_select_db($database, $con);
    $rs = mysql_query("select tp.descripcion as crimen, p.fecha, c.descripcion, comentario from punto p inner join tipo_punto tp on (p.tipo_punto_id_tipo_punto = tp.id_tipo_punto) inner join detalle_punto dp on (p.id_punto = dp.punto_id_punto)  inner join contenido c on (dp.contenido_id_contenido = c.id_contenido) where p.latitud = '" . $_POST['Lat'] . "' and p.longitud = '" . $_POST['Lng'] . "'", $con);
    $rown = 0;
    while ($row = mysql_fetch_array($rs)) {
        if ($rown == 0) {
            
            $texto = "[{\"crimen\":\"" . $row['crimen'] . "\", \"fecha\":\"" . $row['fecha'] . "\", \"comentario\":\"" . $row['comentario'] . "\",\"detalles\":[{\"objeto\":\"" .$row['descripcion']. "\"}";
        } else {
            $texto = $texto . ",{\"objeto\":\"" .$row['descripcion']. "\"}";
        }
        
        $rown++;
    }
    $texto = $texto . "]}]";
    echo($texto);
}
?>

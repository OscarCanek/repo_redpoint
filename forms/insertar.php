<?php
include_once '../databasecon.php';
?>
<html>
    <head>
        <style type="text/css" media="screen">
            body {
                font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
                color: #666;
            }
            h1 {
                margin-top: 0;
                font-size: 20px;
            }
            label {
                font-size: 10px;
                font-weight: bold;
                text-transform: uppercase;
                display: block;
                margin-bottom: 3px;
                clear: both;
            }
        </style>
        <script type="text/javascript" src="../js/jquery-1.8.2.js"></script>
        <link rel="stylesheet" type="text/css" href="../css/dhtmlxcalendar.css"></link>
        <link rel="stylesheet" type="text/css" href="../css/skins/dhtmlxcalendar_dhx_skyblue.css"></link>
        <script src="../js/dhtmlxcalendar.js"></script>
        <script src="../js/jquery.uniform.js" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript" charset="utf-8">
            $(function(){
                $("input, textarea, select, button").uniform();
            });
        </script>
        <link rel="stylesheet" href="../css/uniform.default.css" type="text/css" media="screen">
        <script>
            var myCalendar;
            function doOnLoad() {
                myCalendar = new dhtmlXCalendarObject("calendar");
                myCalendar.setDateFormat("%Y-%m-%d %H:%i:%s");
                parent.resizeIframe(document.body.scrollHeight);                
            }
        </script>
    </head>
    <body onLoad="javascript:doOnLoad();">
    <center>
        <form action="insert.php" method="post" id="insertar" name="insertar">
            <input type="hidden" name="lat" value="<?php echo($_GET['lat']); ?>">
            <input type="hidden" name="lng" value="<?php echo($_GET['lng']); ?>">
            <table>
                <tr><td colspan="2"><h1>Datos del Suceso</h1></td></tr>
                <tr>
                    <td><label>Fecha y Hora del Asalto:</label></td>
                    <td><input id="calendar" type="text" style="width: 260px" name="datetime" ></td>
                </tr>
                <tr><td><label>Tipo de Suceso:</label></td><td>
                        <select style="width: 220px" name="idTipoPunto">
                            <?php
                            $con = mysql_connect($host, $username, $password);
                            if ($con) {
                                mysql_select_db($database, $con);
                                $rs = mysql_query("SELECT id_tipo_punto, descripcion FROM tipo_punto", $con);
                                $rown = 0;
                                while ($row = mysql_fetch_array($rs)) {
                                    if ($rown == 0) {
                                        $texto = "<option value=\"" . $row['id_tipo_punto'] . "\">" . $row['descripcion'] . "</option>";
                                    } else {
                                        $texto = $texto . "<option value=\"" . $row['id_tipo_punto'] . "\">" . $row['descripcion'] . "</option>";
                                    }
                                    $rown++;
                                }
                                echo($texto);
                            }
                            mysql_close($con);
                            ?>
                        </select></td></tr>
                <tr><td colspan="2"><h1>Objetos involucrados</h1></td></tr>
                <?php
                $con = mysql_connect($host, $username, $password);
                if ($con) {
                    mysql_select_db($database, $con);
                    $rs = mysql_query("SELECT id_contenido, descripcion FROM contenido", $con);
                    $rown = 0;
                    while ($row = mysql_fetch_array($rs)) {
                        if ($rown == 0) {
                            $texto = "<tr><td><label>" . $row['descripcion'] . "</label></td><td><input type=\"checkbox\" name=\"c" . $row['id_contenido'] . "\"></td></tr>";
                        } else {
                            $texto = $texto . "<tr><td><label>" . $row['descripcion'] . "</label></td><td><input type=\"checkbox\" name=\"c" . $row['id_contenido'] . "\"></td></tr>";
                        }
                        $rown++;
                    }
                    echo($texto);
                }
                mysql_close($con);
                ?>
                <tr><td colspan="2"><h1>Comentario:</h1></td></tr>
                <tr><td colspan="2"><textarea cols="80" rows="5" name="comentario"></textarea></td></tr>
                <tr><td colspan="2"><center><input type="submit" value="Crear Punto" ></center></td></tr>
            </table>
        </form>
    </body>
</center>
</html>

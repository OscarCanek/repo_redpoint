<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<link rel="stylesheet" type="text/css" href="../css/dhtmlxcalendar.css"></link>
<link href="../css/bootstrap.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="../css/skins/dhtmlxcalendar_dhx_skyblue.css"></link>
        <script src="../js/dhtmlxcalendar.js"></script>
<script>
            var myCalendar;
            function doOnLoad() {
				alert('funciono');
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
                <tr><td colspan="2"><h4>Datos del Suceso</h4></td></tr>
                <tr>
                    <td><label>Fecha y Hora del Asalto:</label></td>
                    <td><input class="input-large" id="calendar" type="text" name="datetime" ></td>
                </tr>
                <tr><td><label>Tipo de Suceso:</label></td><td>
                        <select name="idTipoPunto">

                        </select></td></tr>
                <tr><td colspan="2"><h4>Objetos involucrados</h4></td></tr>

                <tr><td colspan="2"><h4>Comentario:</h4></td></tr>
                <tr><td colspan="2"><textarea cols="100" rows="3" name="comentario" style="margin: 0px 0px 10px; width: 368px; height: 75px;"></textarea></td></tr>
                <tr><td colspan="2"><center><input type="submit" class="btn btn-primary btn-block" value="Crear Punto" ></center></td></tr>
            </table>
        </form>
</body>
</html>
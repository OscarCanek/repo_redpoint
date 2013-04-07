<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<title>Redpoint map v3</title>
<!--Google Maps API-->
<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=true"></script>
<script type="text/javascript" src="js/markerclusterer.js"></script>
<script src="js/bootstrap-modal.js"></script>
<!-- CUSTOM JS -->
<script type="text/javascript" src="js/redpoint.js"></script>
<script src="js/jquery.js"></script>
<style type="text/css">
            html { height: 100% }
            body { height: 100%; margin: 0px; padding: 0px }
            #map_canvas { height: 100% }
</style>
</head>

<body onload="map_initialize()">
        <div id="map_canvas" style="width:100%; height:100%"></div>
</body>
</html>
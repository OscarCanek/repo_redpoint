<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<style type="text/css">
  html { height: 100% }
  body { height: 100%; margin: 0px; padding: 0px }
  #map_canvas { height: 100% }
</style>
<script type="text/javascript"
    src="https://maps.google.com/maps/api/js?sensor=true">
</script>
<script type="text/javascript" src="js/jquery-1.8.2.js"></script>
<script type="text/javascript">
	var map;

  function initialize() {
    var latlng = new google.maps.LatLng(15.30, -90.15);
    
	var myOptions = {
      zoom: 8,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
	
    map = new google.maps.Map(document.getElementById("map_canvas"),
        myOptions);
		
	google.maps.event.addListener(map, 'click', function(event) {
				addMarker(event.latLng);
				toggleBounce();
    });
  }
  
  function addMarker(location) {
  	var marcador = new google.maps.Marker({
		position: location,
		map: map,
		draggable:true,
		animation: google.maps.Animation.DROP
    });
	marcador.addListener('dragstart'
	alert(marcador);
	 $.ajax({
   type: "POST",
   cache: false,
   url: "functions/addpoint.php",
   data: "lat="+location.lat()+"&lng="+location.lng(),
   success: function(msg){
     alert( "Data Saved: " + msg );
   }
 });
  }
  
  var contentString = '<h3>Peligro</h3>'
  
  var infowindow = new google.maps.InfoWindow({
                    content: contentString
                });
  
  google.maps.event.addListener(marcador, 'dblclick', function(event) {
	  			infowindow.setContent(agregarInfoAlMarcador())
              });
			  
  google.maps.event.addListener(marcador, 'mouseover', function(event) {
                  infowindow.open(map, marcador);
                });
  
  function agregarInfoAlMarcador() {
                return '<h3>Peligro</h3>'
  }
  
  function toggleBounce() {
              if (marcador.getAnimation() != null) {
                marcador.setAnimation(null);
              } else {
                marcador.setAnimation(google.maps.Animation.BOUNCE);
              }
            }

</script>
</head>
<body onload="initialize()">
  <div id="map_canvas" style="width:100%; height:100%"></div>
</body>
</html>
var markers = [];
var mc;
var mark1;
function map_initialize() {
    var latlng = new google.maps.LatLng(14.62, -90.52);
    var myOptions = {
        zoom: 14,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        backgroundColor: '#A5BFDD',
        disableDefaultUI: true,
        panControl: false,
        scaleControl: true,
        zoomControl: true,
        mapTypeControl: true,
        disableDoubleClickZoom: true
    };
   map = new google.maps.Map(document.getElementById("map_canvas"),myOptions);
   google.maps.event.addListener(map, 'click', function(event) {
        agregaPunto(event.latLng);
        			
    });
    cargarPuntos();
}
function agregaPunto(location){	
        mark1 = new google.maps.Marker({
        position: location,
        map: map,
        draggable:true,
        animation: google.maps.Animation.DROP
    });
    this.parent.showModal(location.lat(),location.lng());
}
function confirmado(lat,lon){
    mark1.setMap(null);
    latLng = new google.maps.LatLng(lat,lon);
    var marker = new google.maps.Marker({
        position: latLng,
        map: map,
        draggable:false,
        animation: null
    });
    mc.pushMarkerTo_(marker);
    mc.redraw();
}
function cargarPuntos(){
    $.ajax({
        type: "POST",
        cache: false,
        url: "funciones/cargarPuntos.php",
        success: function(msg){
            var json = eval(msg);
            for (var i = 0, length = json.length; i < length; i++) {
                var data = json[i],
                latLng = new google.maps.LatLng(data.lat, data.lng); 
                var marker2 = new google.maps.Marker({
                    position: latLng,
                    map: map
                });
                markers.push(marker2);                
            }
            mc = new MarkerClusterer(map, markers);
        }
    });
   
}
var markers = [];
var mc;
var mark1;
var geocoder;
//variables para la generacion de rutas
var rendererOptions = {
    draggable: true
};
var directionsDisplay;
var directionsService = new google.maps.DirectionsService(); //permite obtener rutas para distintos medios de transporte.
var esRuta = false;
var countPuntosRuta = 0; //contador para saber si es el punto de origen o el de destino de una ruta
var origen;
var destino;
var transporte = 'DRIVING';

function map_initialize() {
    directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions); //procesa los resultados de rutas
    geocoder = new google.maps.Geocoder();
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
    directionsDisplay.setMap(map); //establece sobre que mapa se haran las rutas
    google.maps.event.addListener(directionsDisplay, 'directions_changed', function() {
        alert(directionsDisplay.directions.routes[0].legs[0].distance.text);
        alert(directionsDisplay.directions.routes[0].legs[0].duration.text);
        origen = directionsDisplay.directions.routes[0].legs[0].start_location;
        destino = directionsDisplay.directions.routes[0].legs[0].end_location;
    });
    google.maps.event.addListener(map, 'click', function(event) {
        if(esRuta) {
            if(countPuntosRuta == 0) {
                origen = event.latLng;
                countPuntosRuta++;
            } else {
                destino = event.latLng;
                calcRuta2('DRIVING');
            }
        } else {
            agregaPunto(event.latLng);
        }
    });
// cargarPuntos();
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
function pointFromGeoCode(direccion){
    geocoder.geocode( {
        'address': direccion
    }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            map.setCenter(results[0].geometry.location);
        //var marker = new google.maps.Marker({
        //   map: map,
        //  position: results[0].geometry.location
        //});
        } else {
            alert("Geocode was not successful for the following reason: " + status);
        }
    });
}
//funciones de ruta
function setVarRuta(es) {
    esRuta = es;
}

function getVarRuta() {
    return esRuta;
}

function restablecerVariablesDeRuta() {
    countPuntosRuta = 0;
    origen = null;
    destino = null;
    transporte = 'DRIVING';
}

function setTransporte(trans) {
    transporte = trans;
    calcRuta2();
}
//generar ruta a partir de click en el mapa
function calcRuta2() {
    var request = {
        origin: origen,
        destination: destino,
        travelMode: google.maps.TravelMode[transporte],
        optimizeWaypoints: true,
        provideRouteAlternatives: true
    };
    directionsService.route(request, function(response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);
        }
    });
}

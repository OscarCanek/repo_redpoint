// JavaScript Document
var markers = [];
var mc;
var oldloc;
var si;
var s2;
function map_initialize() {
    var latlng = new google.maps.LatLng(15.30, -90.15);
    var myOptions = {
        zoom: 8,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        backgroundColor: '#A5BFDD',
        disableDefaultUI: true,
        panControl: true,
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

var puntoactual =[]

function agregaPunto(location){	
    var marcador = new google.maps.Marker({
        position: location,
        map: map,
        draggable:true,
        animation: google.maps.Animation.DROP
    });
    
    new Messi("<iframe src='forms/insertar.php?lat="+location.lat()+"&lng="+location.lng()+"' id='messiframe'  width='100%' height='500' scrolling='no' frameborder='0'></iframe>", {
        title: 'Agregar un Punto',
        titleClass: 'anim error',
        modal: true,
        buttons: [{
            id: 0, 
            label: 'He Terminado', 
            val: 'Y'
        }],
        callback: function(val) { 
            marcador.setMap(null);
        }
    });
    

}
function confirmado(lat,lon){
    latLng = new google.maps.LatLng(lat,lon);
    var marker = new google.maps.Marker({
        position: latLng,
        map: map,
        draggable:true,
        animation: null
    });
    var nubesita = new InfoBubble({
        maxWidth: 300
    });
    google.maps.event.addListener(marker,'dragstart',function(event){
        //get key point
        oldloc = event.latLng;
    });
    google.maps.event.addListener(marker,'dragend',function(event){
        //get updated point
        changepoint(event.latLng);
    });
    google.maps.event.addListener(marker,'click',function(event){
        //showwindow
        var info = getInfofor(marker);
        nubesita.removeTab(0);
        nubesita.removeTab(0);
        nubesita.addTab('Comenario', '<div>' + info.pop() + '</div>');
        nubesita.addTab('Informacion', '<div>' + info.pop() + '</div>');
        nubesita.open(map,marker);
        
    });
    mc.pushMarkerTo_(marker);
    mc.redraw();
}

function getInfofor(marker){
    var retorno = [];
    var ll = marker.getPosition();
    $.ajax({
        type: "POST",
        url: "functions/getinfofrom.php",
        cache: false,
        async: false,
        data: {
            Lat:ll.lat(),
            Lng:ll.lng()
        }
    }).done(function(html){
        var json = eval(html);
        s1 ="<table class='bordered'>"
        for (var i = 0, length = json.length; i < length; i++) {
            var data = json[i];
            s1 = s1 + "<tr><td>Crimen:</td><td>"+data.crimen + "</td></tr><tr><td>Fecha:</td><td>" + data.fecha + "</td></tr>";
            s2 = data.comentario;
            for (var j = 0, length2 = data.detalles.length; j < length2; j++) {                   
                var data2 = data.detalles[j];
                if(j==0){
                    s1 = s1+"<tr><td colspan='2'>Objetos Implicados</td></tr>";
                }
                s1 = s1 +"<tr><td colspan='2'>"+ data2.objeto+"</td></tr>";
               
            }
        }
        s1 = s1+"</table>";
    });
    retorno.push(s1);
    retorno.push(s2);
    return retorno;
}

function changepoint(location){
    oldlat = oldloc.lat();
    oldlng = oldloc.lng();
    newlat = location.lat();
    newlng = location.lng();
    $.ajax({
        type: "POST",
        url: "functions/dragndrop.php",
        cache: false,
        data: {
            oldLat:oldlat, 
            oldLng:oldlng,
            newLat:newlat,
            newLng:newlng
        }
    }).done(function(html){
        alert(html);
    });
}

function cargarPuntos(){
    $.ajax({
        type: "POST",
        cache: false,
        url: "functions/getpoints.php",
        success: function(msg){
            var json = eval(msg);
            for (var i = 0, length = json.length; i < length; i++) {
                var data = json[i],
                latLng = new google.maps.LatLng(data.lat, data.lng); 
                var marker2 = new google.maps.Marker({
                    position: latLng,
                    map: map
                });
                
                ponerListener(marker2);
                markers.push(marker2);                
                
            }
            mc = new MarkerClusterer(map, markers);
        }
    });
   
}
function ponerListener(marker2){
    var nubesita = new InfoBubble({
        maxWidth: 300
    });
    google.maps.event.addListener(marker2,'click',function(event){
        //showwindow
        var info = getInfofor(marker2);
        nubesita.removeTab(0);
        nubesita.removeTab(0);
        nubesita.addTab('Comenario', '<div>' + info.pop() + '</div>');
        nubesita.addTab('Informacion', '<div>' + info.pop() + '</div>');
        nubesita.open(map,marker2);
        
    });
    
}
$(document).ready(function(){
    //esconde el mensaje de error
    $("#agregaError").hide();
	$("#successAgrega").hide();

    $("#insertar #submitD").click(function() {
        //esconde el mensaje de error cada vez que se hace click en submit
        $("#agregaError").hide();
        $("#successAgrega").hide();
        //evalua cada uno de los campos
		var txtchk = "";
		for (var i=1;i<6;i++){
			var tmp=$('#c'+i).prop('checked');
			if(i==1){
				txtchk = tmp;
			}else{
				txtchk = txtchk+","+tmp;
				}
		}
		var fechahora = $("input#calendar").val();
		var tipo = $("select#idTipoPunto").val();
		var latitud =  $("input#lat").val();
		var longitud =  $("input#lng").val();
		var comentario = $("#comentariopunto").val();
		 $.ajax({
            type: "POST",
            url: "funciones/agregaPunto.php",
            cache: false,
            data: {
                lat: latitud,
				lon: longitud,
				fec: fechahora,
				com: comentario,
				tip: tipo,
				obj: txtchk			
            }
        }).done(function(html){
            successAddPoint(html,latitud,longitud);
        });
        
    });

    $("#agregaErrorClose").click(function(){
        $("#agregaError").hide();
    });
    return false;
});
function successAddPoint(html,lat,ln){
    if(html.length>0){
        $("#activoErrorText").fadeIn().text(html);
		$("#activoError").show();
    }else{
		$("#successActivo").show();
		document.getElementById('frame').contentWindow.confirmado(lat,ln);
    }
}
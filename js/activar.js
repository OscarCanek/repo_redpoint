$(document).ready(function(){
    //esconde el mensaje de error
    $("#activoError").hide();
	$("#successActivo").hide();

    $("#activoForm #submitH").click(function() {
        //esconde el mensaje de error cada vez que se hace click en submit
        $("#activoError").hide();
        $("#successActivo").hide();
        //evalua cada uno de los campos
        var cda =  $("input#cda").val();
//alert(cda);
        $.ajax({
            type: "GET",
            url: "funciones/processhash.php",
            cache: false,
            data: {
                hash: cda			
            }
        }).done(function(html){
            successActivo(html);
        });
    });

    $("#activoErrorClose").click(function(){
        $("#activoError").hide();
    });
    return false;
});
function successActivo(html){
    if(html.length>0){
        $("#activoErrorText").fadeIn().text(html);
		$("#activoError").show();
    }else{
		$("#successActivo").show();
    }
}


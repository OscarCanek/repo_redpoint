$(document).ready(function(){
    //esconde el mensaje de error
    $("#recupera1Error").hide();
    $("#successRecupera1").hide();
    $("#recupera2Error").hide();
    $("#successRecupera2").hide();
    //escode los otros mensajes de error
	

    $("#recupera1Form #submit").click(function() {
        //esconde el mensaje de error cada vez que se hace click en submit
        $("#recupera1Error").hide();
        $("#successRecupera1").hide();
        //evalua cada uno de los campos
        var mail =  $("input#emails").val();
        var matchmail =/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(mail);
        if(mail.length==0 || matchmail==false){
            $("#recupera1ErrorText").fadeIn().text("El email ingresado es invalido ej: usuario@cuenta.com");
            $("#recupera1Error").show();
            $("input#emails").focus();
            return false;
        }
        $.ajax({
            type: "GET",
            url: "funciones/recuperar.php",
            cache: false,
            data: {
                email: mail			
            }
        }).done(function(html){
            successRecuperar1(html);
        });
    });

    $("#recupera2Form #submitCC").click(function() {
        //esconde el mensaje de error cada vez que se hace click en submit
        $("#recupera2Error").hide();
        $("#successRecupera2").hide();
        //evalua cada uno de los campos
        var cda =  $("input#pwcode").val();
        var pas1 = $("input#pw1").val();
        var pas2 = $("input#pw2").val();
        if(pas1!=pas2||$.trim(pas1).length==0){
            $("#recupera2ErrorText").fadeIn().text("Las contraseñas no coinciden");
            $("#recupera2Error").show();
            $("input#pw1").val("");
            $("input#pw2").val("");
            $("input#pw1").focus();
            return false;
        }
        $.ajax({
            type: "GET",
            url: "funciones/processhash.php",
            cache: false,
            data: {
                hash: cda,
                password: pas2
            }
        }).done(function(html){
            successRecuperar2(html);
        });
    });
    
    $("#recupera1ErrorClose").click(function(){
        $("#recupera1Error").hide();
    });
    $("#recupera2ErrorClose").click(function(){
        $("#recupera2Error").hide();
    });
	
    return false;
});

function successRecuperar1(html){
    if(html.length>0){
        $("#recupera1ErrorText").fadeIn().text(html);
        $("#recupera1Error").show();
    }else{
        $("#successRecupera1").show();
    }
}
function successRecuperar2(html){
    if(html.length>0){
        $("#recupera2ErrorText").fadeIn().text(html);
        $("#recupera2Error").show();
    }else{
        $("#successRecupera2").show();
    }
}
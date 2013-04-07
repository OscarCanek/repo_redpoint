// JavaScript Document
$(document).ready(function(){
    //esconde el mensaje de error
    $("#registroError").hide();
	$("#successRegistro").hide();

    $("#registroForm #submitR").click(function() {
        //esconde el mensaje de error cada vez que se hace click en submit
        $("#registroError").hide();
        $("#successRegistro").hide();
        //evalua cada uno de los campos
        var dpi = $("input#dpi").val();
        if((!isNumber(dpi))||dpi.length!=13){
            $("#registroErrorText").fadeIn().text("Se requiere un DPI correcto (numero de 13 digitos sin espacios)");
            $("#registroError").show();
            $("input#dpi").focus();
            return false;
        }
        var nombre =  $("input#nombre").val();
        if($.trim(nombre).length==0){
            $("#registroErrorText").fadeIn().text("Se requiere un nombre");
            $("#registroError").show();
            $("input#nombre").focus();
            return false;
        }
        var mail =  $("input#email").val();
        var matchmail =/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(mail);
        if(mail.length==0 || matchmail==false){
            $("#registroErrorText").fadeIn().text("El email ingresado es invalido ej: usuario@cuenta.com");
            $("#registroError").show();
            $("input#email").focus();
            return false;
        }
        var pas1 = $("input#passwd").val();
        var pas2 = $("input#vpass").val();
        if(pas1!=pas2||$.trim(pas1).length==0){
            $("#registroErrorText").fadeIn().text("Las contraseñas no coinciden");
            $("#registroError").show();
            $("input#vpass").val("");
            $("input#passwd").val("");
            $("input#passwd").focus();
            return false;
        }
        var pais =  $("select#pais").val();
        //alert(dpi);
        //alert(nombre);
        //alert(mail);
        //alert(pas1);
        //alert(pais);
        $.ajax({
            type: "POST",
            url: "funciones/registro.php",
            cache: false,
            data: {
                iden: dpi, 
                name: nombre,
                email: mail,
                password: pas1,
                id_pais: pais			
            }
        }).done(function(html){
            successRegistro(html);
        });
    });

    $("#registroErrorClose").click(function(){
        $("#registroError").hide();
    });
    return false;
});
function successRegistro(html){
    if(html.length>0){
        $("#registroErrorText").fadeIn().text(html);
		$("#registroError").show();
    }else{
		$("#successRegistro").show();
    }
}
function isNumber (o) {
    return ! isNaN (o-0) && o !== null && o !== "";
}


// JavaScript Document
$(document).ready(function(){
    //esconde el mensaje de error
    $("#loginError").hide();
	$("#successLogin").hide();

    $("#loginForm #submit").click(function() {
		//alert('click');
        //esconde el mensaje de error cada vez que se hace click en submit
        $("#loginError").hide();
        $("#successLogin").hide();
        //evalua cada uno de los campos
        var usr =  $("input#user").val();
        if($.trim(usr).length==0){
            $("#loginErrorText").fadeIn().text("Se requiere un username (tu correo electronico)");
            $("#loginError").show();
            $("input#user").focus();
            return false;
        }
		var pas =  $("input#pass").val();
        if($.trim(pas).length==0){
            $("#loginErrorText").fadeIn().text("Se requiere tu contraseña");
            $("#loginError").show();
            $("input#pass").focus();
            return false;
        }
       
        $.ajax({
            type: "POST",
            url: "funciones/login.php",
            cache: false,
            data: {
                user: usr, 
                password: pas		
            }
        }).done(function(html){
            successLogin(html);
        });
    });

    $("#loginErrorClose").click(function(){
        $("#loginError").hide();
    });
	 $("#successClose").click(function(){
        $("#successLogin").hide();
    });
    return false;
});
function successLogin(html){
    if(html.length>0){
        $("#loginErrorText").fadeIn().text(html);
		$("#loginError").show();
    }else{
		$("#successLogin").show();
		setTimeout("window.location = \"index.php\"", 5000);
    }
}
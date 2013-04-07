/* 
 * document ready 
 */
$(document).ready(function(){
    //form ids
    //alert("entro");
    var formularios = new Array();
    // alert(formularios.toString());
    formularios[0] = "Login";
    formularios[1] = "Register";
    formularios[2] = "Activate";
    formularios[3] = "Forgot01";
    formularios[4] = "Forgot02";
    for(var i=0;i<formularios.length;i++){
        //alert(i);
        var id=formularios[i];
        // alert(id);
        $("#"+id+"Error").hide();
        $("#"+id+"Success").hide();
        $("#"+id+"Loading").hide();
        //  alert('hidden');
        //login messages
        //activation
        //send function
        
        $("#"+id+"FormSubmit").click(function() {
            var id2 = this.id.substring(0,this.id.length-10);
            $("#"+id2+"Loading").slideDown();
            $("#"+id2+"Error").slideUp();
            $("#"+id2+"Success").slideUp();
            var currentform = document.forms[id2+"FormForm"];
            // alert(currentform);
            //alert(currentform.elements.length);
            var data = {};
            data["accion"]=id2;
            for(var j=0;j<currentform.elements.length-1;j++){
                var currentelement = currentform.elements[j];
                var name = currentelement.name;
                var newname;
                var value;
                if(startsWith("input",name)){
                    newname=name.substring(5,name.length);
                    value = $("input#"+newname).val();      
                }else if (startsWith("select",name)){
                    newname=name.substring(6,name.length);
                    value = $("select#"+newname).val();
                }
                data[newname]=value;
            // alert(newname+"="+value);     
            }
            //alert(data);
            //alert("parseo");
            $.ajax({
                type: "POST",
                url: "exec.php",
                cache: false,
                data: data
            }).done(function(html){
                $("#"+id2+"Loading").slideUp();
                //s alert(html);
                if(html.length>0){
                    error(html,id2);
                }else{
                    $("#"+id2+"Success").show();
                    if(id2=="Login"){
                        location.reload()
                    }
                }
            });
        });
        $("#"+id+"ErrorClose").click(function() {
            var id2 = this.id.substring(0,this.id.length-10);
            $("#"+id2+"Error").slideUp();
        });
        $("#"+id+"SuccessClose").click(function() {
            var id2 = this.id.substring(0,this.id.length-12);
            $("#"+id2+"Success").slideUp();
        });
    }
    
});
function error(description,id){
    $("#"+id+"ErrorText").fadeIn().text(description);
    $("#"+id+"Error").slideDown();
}
function startsWith(needle, haystack){
    return (haystack.substr(0, needle.length) == needle);
}
function buscarDireccion(event,txt){
    var direccion = txt;
    if(event.keyCode==13){
        if (!endsWith(',guatemala',direccion.toLowerCase().replace(" ",""))){
            direccion = direccion+", Guatemala"
            frames['frame'].pointFromGeoCode(txt);    
        }
       
        alert(direccion);
    }
}
function endsWith(needle, haystack){
    return (haystack.substr(haystack.length-needle.length,needle.length)==needle);
}

/*
 *Funciones de Rutas by el Ing. Coca
 */
function calcRuta() {
    var origen = document.getElementById('origen').value; //obtiene la ubicacion de origen desde el elemento con el id "origen"
    var destino = document.getElementById('destino').value; //obtiene la ubicacion de origen desde el elemento con el id "origen"
    var transporte = "DRIVING"; //document.getElementByName('gTransporte').value; //obtiene el medio de transporte que se va a utilizar
    frames["frame"].calcRuta(origen, destino, transporte);
    $("#rutaForm").modal('hide');
}

function switchRuta() {
    if(frames["frame"].getVarRuta() == false) {
        frames["frame"].setVarRuta(true);
        document.getElementById('btnRuta').setAttribute('class','btn btn-success');
        document.getElementById("navIz").children['btnsTransporte'].style.display = '';
    } else {
        frames["frame"].setVarRuta(false);
        frames["frame"].restablecerVariablesDeRuta();
        document.getElementById('btnRuta').setAttribute('class','btn btn-inverse');
        document.getElementById("navIz").children['btnsTransporte'].style.display = 'none';
    }
}

function setTransporteAuto() {
    var trans = document.getElementById('btnAuto').value;
    frames["frame"].setTransporte(trans);
}

function setTransportePublico() {
    var trans = document.getElementById('btnPublico').value;
    frames["frame"].setTransporte(trans);
}

function setTransporteAPie() {
    var trans = document.getElementById('btnAPie').value;
    frames["frame"].setTransporte(trans);
}
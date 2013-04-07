<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <title>Animated Form Switching with jQuery</title>
 
        <link rel="stylesheet" type="text/css" href="css/loginstyle.css" />
		<script src="js/cufon-yui.js" type="text/javascript"></script>
		<script src="js/ChunkFive_400.font.js" type="text/javascript"></script>
		<script type="text/javascript">
			Cufon.replace('h1',{ textShadow: '1px 1px #fff'});
			Cufon.replace('h2',{ textShadow: '1px 1px #fff'});
			Cufon.replace('h3',{ textShadow: '1px 1px #000'});
			Cufon.replace('.back');
		</script>
            <script src="js/jquery-1.8.2.js"></script>
			<script src="js/messi.js"></script>
    </head>
    <?php
	if(!isset($_GET['edad'])){?>
    <body onload="javascript:window.parent.checkedad();">
    <?php 
	}else{
		?>
    <body>
    <?php
	}
	?>
		  <div id="form_wrapper" class="form_wrapper" style="width:700px;">
		    <form class="register active" id="register" action="functions/register.php" method="post">
		      <h3>Registro</h3>
		      <div class="column">
		        <div>
		          <label>DPI:</label>
                  <?php
                  if(!isset($_GET['edad'])){?>
					<input type="text" id="dpi" name="dpi"  onkeyup="javascript:checkdpi();"/>  
                    <input type="hidden" name="edad" value="menor" />
                    <?php
				  }else{
					  if($_GET['edad']=='mayor'){
				  ?>
		          <input type="text" id="dpi" name="dpi"  onkeyup="javascript:checkdpi();"/>
                                      <input type="hidden" name="edad" value="mayor" />
                  <?php
					  }else{
				?>
                <input type="text"  id="dpi" name="dpi" value = "N/A" disabled="disabled"  onkeyup="javascript:checkdpi();"/>
                                    <input type="hidden" name="edad" value="menor" />
                <?php	  
					  }
				  }
                  ?>
                  <span class="error" id="dpierror">Consta de 13 digitos numericos.</span> </div>
		        <div>
		          <label>Primer Nombre:</label>
		          <input type="text" name="nombre1" id="nombre1" onkeyup="javascript:checkdpi();"/>
		          <span class="error" id="nombre1error">Es un campo obligatorio</span> </div>
		        <div>
		          <label>Segundo Nombre:</label>
		          <input type="text" name="nombre2" id="nombre2"/>
		          <span class="error" id="nombre2error">Es un campo obligatorio</span> </div>
	          </div>
              <div class="column">
		        <div>
		          <label>Primer Apellido:</label>
		          <input type="text" name="apellido1" id="apellido1"/>
		          <span class="error" id="apellido1error">Es un campo obligatorio</span></div>
		        <div>
		          <label>Segundo Apellido:</label>
		          <input type="text" name="apellido2" id="apellido2"/>
		          <span class="error" id="apellido2error">Es un campo obligatorio</span></div>
		        <div>
		          <label>Pais:</label>
		          <input type="text" name="pais" id="pais" value="Guatemala" disabled="disabled" />
		          <span class="error">Es un campo obligatorio</span></div>
                </div>
		      <div class="column">
		        <div>
		          <label>Correo Electronico:</label>
		          <input type="text" id="email" name="email" value="@" onkeyup="javascript:checkmail();"/>
		          <span class="error" id="mailerror">El correo electronico es invalido.</span> </div>
		        <div>
		          <label>Contrase&ntilde;a:</label>
		          <input type="password" id='pw1' name="pw" onkeyup="javascript:checkpw();"/>
		          <span class="error">This is an error</span> </div>
		        <div>
		          <label>Confirmar Contrase&ntilde;a:</label>
		          <input type="password" id='pw2' name="correctpw" onkeyup="javascript:checkpw();"/>
		          <span class="error" id="pwerror">Las contrase&ntilde;as no coinciden</span> </div>
 	          </div>
		      <div class="bottom">
		        <input type="button" value="Registrarse" onclick="javascript:checkdata();"/>
		        <a href="login.html" rel="login" class="linkform">Ya tienes una cuenta? Inicia sesion aqui</a>
		        <div class="clear"></div>
	          </div>
	        </form>		   
	      </div>
    </body>
    <script language="javascript">
	var dpi = false;
	var mail = false;
	var pw = false;
	var dem = false;
	var msg = "";
    function checkdata(){
		checkpw();
		checkmail();
		checkdpi();
		if(document.getElementById('nombre1').value==''){
				document.getElementById('nombre1error').style.visibility = 'visible';
				dem = false;
			}else{
				document.getElementById('nombre1error').style.visibility = 'hidden';
				dem = true;
			}
			if(document.getElementById('nombre2').value==''){
				document.getElementById('nombre2error').style.visibility = 'visible';
				dem = false;
			}else{
				document.getElementById('nombre2error').style.visibility = 'hidden';
				if(dem==true){
				dem = true;
				}else{
				dem = false;
				}
			}
			if(document.getElementById('apellido1').value==''){
				document.getElementById('apellido1error').style.visibility = 'visible';
				dem = false;
			}else{
				document.getElementById('apellido1error').style.visibility = 'hidden';
				if(dem==true){
				dem = true;
				}else{
				dem = false;
				}
			}
			if(document.getElementById('apellido2').value==''){
				document.getElementById('apellido2error').style.visibility = 'visible';
				dem = false;
			}else{
				document.getElementById('apellido2error').style.visibility = 'hidden';
				if(dem==true){
				dem = true;
				}else{
				dem = false;
				}
			}
		if(dpi==true && mail==true&&pw==true&&dem==true){
			document.getElementById('dpi').disabled = false;
			document.getElementById('pais').disabled = false;
			document.forms["register"].submit();
			
		}else{
			msg = "Hay datos incorrectos en el formulario"
			var counter = 0;
			if(dpi == false){
				if (counter> 0){
				msg = msg + ", DPI";
				}else{
				msg = msg+": DPI"	
				counter++;
				}
			}
			if(mail == false){
				if (counter> 0){
				msg = msg + ", Correo Electronico";	
				}else{
				msg = msg+": Correo Electronico"	
				counter++;
				}
			}
			if(pw == false){
				if (counter> 0){
				msg = msg + ", Contrase&ntilde;a";	
				}else{
				msg = msg+": Contrase&ntilde;a"	
				counter++;
				}
			}
			window.parent.showerror('Error de Registro:',msg);
			}
		}
	function checkpw(){
		var pas1 = document.getElementById('pw1').value;
		var pas2 = document.getElementById('pw2').value;
		if(pas1==pas2 && pas1!=''){
			document.getElementById('pwerror').style.visibility = 'hidden';
			pw = true;
	    }else{
			document.getElementById('pwerror').style.visibility = 'visible';
			pw = false;
			}
		}
	function checkmail(){
		var eemail = document.getElementById('email').value;
	    var matchmail =/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(eemail);
		
		if(matchmail==true){
			document.getElementById('mailerror').style.visibility = 'hidden';
			mail = true;
		}else{
			document.getElementById('mailerror').style.visibility = 'visible';
			mail = false;
		}
		}
		function checkdpi(){
			if(document.getElementById('dpi').disabled==true){
				dpi = true;
			}else{
				var dpival = document.getElementById('dpi').value;
				var matchdpi = /[0-9]{13}/.test(dpival);
				if(matchdpi==true &&dpival.length==13){
					document.getElementById('dpierror').style.visibility = 'hidden';
					dpi = true;
				}else{
					document.getElementById('dpi').value = document.getElementById('dpi').value.replace(/[^0-9]/,'');
					document.getElementById('dpierror').style.visibility = 'visible';
					dpi = false;
				}
			}
			
		}
    </script>
</html>
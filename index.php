<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Redpoint | Crowdsourcing helpful maps</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link href="style.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/messi.css" />
    <script src="js/jquery-1.8.2.js"></script>
	<script src="js/messi.js"></script>
<?php 
if (!isset($_COOKIE['firsttime']))
{
    setcookie("firsttime", "no", time()+3600);
?>
    <script>
   jQuery.noConflict ();
    (function($) {
      $(document).ready(function() {
          new Messi('Es esta tu primera visita a RedPoint?.', {title: 'Bienvenido a Redpoint', modal:true, titleClass: 'anim info', buttons: [{id: 0, label: 'Si', val: 'Y',btnClass: 'btn-success'}, {id: 1, label: 'No', val: 'N',btnClass: 'btn-danger'}], callback: function(val) {
			  if(val == 'Y'){
				 document.getElementById("loader").contentWindow.location = "about.php";
			 }}});
   
        
        
      });
    })(jQuery);
    </script>
	<?php }
?>
<script language="javascript">
	function checkedad(){
    new Messi('Es usted mayor de edad?.', {title: 'Registro: Edad', modal:true, buttons: [{id: 0, label: 'Si', val: 'Y',btnClass: 'btn-success'}, {id: 1, label: 'No', val: 'N',btnClass: 'btn-danger'}], callback: function(val) { if(val == 'Y'){
				 document.getElementById("loader").contentWindow.location = "registro.php?edad=mayor"; }else{
				 document.getElementById("loader").contentWindow.location = "registro.php?edad=menor" ;
					 }}});
	}
	function showinfo(url){
	jQuery.get(url, function(data){
 new Messi(data,{show: true, unload: true, modal:true});
});
	}
	function showsuccess(title,text){
		new Messi(text, {title: title, titleClass: 'anim success', buttons: [{id: 0, label: 'Cerrar', val: 'X'}]});
	}
	function showerror(title,text){
		new Messi(text, {title: title, titleClass: 'anim error', buttons: [{id: 0, label: 'Cerrar', val: 'X'}]});
	}
    </script>
</head>
<body onload="firsttime()">
    <div id="page"><div id="page2">
            <div id="header">
                <h1><a href="#"><img src="images/redpointlogo.fw.png" width="80" height="78" />redpoint</a></h1>
            </div>
            
            <div id="intro"><div id="intro2">
            <iframe src="mapa.php" name="loader" id="loader" width="920" height="495" frameborder="0"></iframe>        
            </div></div> 
            <div id="main"><div id="main2">&nbsp;<div id="main3"><center>
            <ul class="tt-wrapper">
				<li style="list-style:none;"><a class="tt-gplus" href="mapa.php" target="loader"><span>Inicio</span></a></li>
				<li style="list-style:none;"><a class="tt-twitter" href="registro.php" target="loader"><span>Registro</span></a></li>
				<li style="list-style:none;"><a class="tt-dribbble" href="login.html" target="loader"><span>Login</span></a></li>
				<li style="list-style:none;"><a class="tt-facebook" href="#"><span>Mapa</span></a></li>
				<li style="list-style:none;"><a class="tt-linkedin" href="#"><span>Contacto</span></a></li>
				<li style="list-style:none;"><a class="tt-forrst" href="about.php" target="loader"><span>Quienes somos</span></a></li>
			</ul>
            </center>
            <center><a href="http://softso.tk/"><img src="images/softso.png" /></a></center>
                        <div class="clearing"></div>   
            </div></div></div><!-- main --><!-- main2 --><!-- main3 -->
            <div id="footer">
                <p>Copyright &copy; 2012, designed by <a href="#">Oscar Canek & Javier Cifuentes</a>,  | <a href="#">Privacy Policy</a></p>
            </div>
    </div></div><!-- page --><!-- page2 -->
</body>
</html>
<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Redpoint + bootstrap</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <!-- Le styles -->
            <link href="css/bootstrap.css" rel="stylesheet">
                <style>
                    body {
                        padding-top: 10px; /* 60px to make the container go all the way to the bottom of the topbar */
                    }
                    .navbar-wrapper {
                        margin-bottom: -90px;
                        z-index: 10;
                        position: absolute;
                        top: 0;
                        left: 0;
                        right: 0;
                        z-index: 10;
                        margin-top: 20px;
                    }
                    .navbar .navbar-inner {
                        border: 0;
                        -webkit-box-shadow: 0 2px 10px rgba(0,0,0,.25);
                        -moz-box-shadow: 0 2px 10px rgba(0,0,0,.25);
                        box-shadow: 0 2px 10px rgba(0,0,0,.25);
                    }
                </style>
                <link href="css/bootstrap-responsive.css" rel="stylesheet">
                    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
                    <!--[if lt IE 9]>
                      <script src="js/html5shiv.js"></script>
                    <![endif]-->
                    <link rel="stylesheet" type="text/css" href="css/dhtmlxcalendar.css"></link>
                    <link rel="stylesheet" type="text/css" href="css/skins/dhtmlxcalendar_dhx_skyblue.css"></link>
                    <script src="js/dhtmlxcalendar.js"></script>
                    <script>
                        var myCalendar;
                        function doOnLoad() {
                            myCalendar = new dhtmlXCalendarObject("calendar");
                            myCalendar.setDateFormat("%Y-%m-%d %H:%i:%s");
                            parent.resizeIframe(document.body.scrollHeight);                
                        }
                    </script>
                    </head>

                    <body onload="javascript:doOnLoad();">
                        <div class="navbar-wrapper">
                            <div class="container">
                                <div class="navbar navbar-inverse">
                                    <div class="navbar-inner">
                                        <div class="container">
                                            <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                                                <span class="icon-bar"></span>
                                                <span class="icon-bar"></span>
                                                <span class="icon-bar"></span>
                                            </a>
                                            <a class="brand" href="#"><img src="img/redpointlogo.png" height="20" width="20" />&nbsp;Redpoint&trade;</a>
                                            <div class="nav-collapse collapse navbar-responsive-collapse">
                                                <ul id="navIz" class="nav">
                                                    <li class="active"><a  href="mapa.php" target="frame">Mapa</a></li> 
                                                    <?php if (!isset($_SESSION['nombre'])) { ?><li><a href="#LoginForm" data-toggle="modal">Inicia Sesion</a></li><?php } ?>
                                                    <li><button id="btnRuta" type="button" class="btn btn-inverse" onclick="switchRuta()">Ruta</button></li>
                                                    <li class="divider-vertical"></li>
                                                    <li id="btnsTransporte" style="display:none">
                                                        <div class="btn-group">
                                                            <button id="btnAuto" name="btnTransporte" class="btn" value="DRIVING" onclick="setTransporteAuto()"><img src="img/auto.png" width="19" height="16" alt="auto"/></button>
                                                            <button id="btnPublico" name="btnTransporte" class="btn" value="TRANSIT" onclick="setTransportePublico()"><img src="img/publico.png" width="20" height="16" alt="Transporte publico"/></button>
                                                            <button id="btnAPie" name="btnTransporte" class="btn" value="WALKING" onclick="setTransporteAPie()"><img src="img/apie.png" width="17" height="16" alt="A pie"/></button>
                                                        </div>
                                                    </li>

                                                </ul>
                                                </li>
                                                </ul>
                                                <div class="navbar-search pull-left">
                                                    <input type="text" class="search-query span2 pull-left" placeholder="Buscar Lugar" onkeypress="buscarDireccion(event,this.value)">
                                                </div>
                                                <ul class="nav pull-right">
                                                    <li><a href="javascript:share('fb');"><img src="img/facebook_small.png" /></a></li>
                                                    <li><a href="javascript:share('tw');"><img src="img/twitter_small.png" /></a></li>
                                                    <li><a href="javascript:share('gp');"><img src="img/googleplus_small.png" /></a></li>
                                                    <li class="divider-vertical"></li>
                                                    <li class="dropdown">
                                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Acerca De <b class="caret"></b></a>
                                                        <ul class="dropdown-menu">
                                                            <li><a href="about.php" target="frame">Acerca de Redpoint</a></li>
                                                            <li><a href="http://www.visitguatemala.com">Acerca de Guatemala</a></li>
                                                            <li class="divider"></li>
                                                            <li><a  href="#termsConditions" data-toggle="modal">Terminos y Condiciones</a></li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </div><!-- /.nav-collapse -->
                                        </div>
                                    </div><!-- /navbar-inner -->
                                </div><!-- /navbar -->
                            </div> <!-- /.container -->
                        </div><!-- /.navbar-wrapper -->
                        <!-- Mapa de fondo por iFrame -->
                        <iframe src="mapa.php" height="100%" width="100%" style="position:absolute; top:0px; left:0px;" frameborder="0" name="frame" id="frame"></iframe>
                        <!--login form-->
                        <div id="LoginForm" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="loginLabel" aria-hidden="true">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h3 id="myModalLabel">Inicio de Sesion</h3>
                            </div>
                            <div class="alert fade in alert-error" id="LoginError">
                                <button type="button" class="close" id="LoginErrorClose">&times;</button>
                                <strong>Error!</strong>&nbsp;<span id="LoginErrorText">Error de jquery</span>
                            </div>
                            <div class="alert fade in alert-success" id="LoginSuccess">
                                <button type="button" class="close" id="LoginSuccessClose">&times;</button>
                                <h4>Exito!</h4>
                                Se ha iniciado sesion correctamente, espere mientras lo redirigimos...<br /><center><img src="img/loading.gif" /></center>
                            </div>                            <div class="modal-body">
                                <form class="form-horizontal" action="#" id="LoginFormForm">
                                    <div class="control-group">
                                        <label class="control-label" for="user">Usuario</label>
                                        <div class="controls">
                                            <input type="text" id="username" name="inputusername" placeholder="Usuario">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="pass">Contrase&ntilde;a</label>
                                        <div class="controls">
                                            <input type="password" id="password" name="inputpassword" placeholder="Contrase&ntilde;a">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls">
                                            <button type="button" class="btn" id="LoginFormSubmit">Iniciar Sesion</button>
                                        </div>
                                    </div>
                                </form>
                                <div class="alert fade in alert-info" id="LoginLoading">
                                    <center><strong>Espera!</strong> Estamos revisando esta  info...</center>
                                </div>
                            </div>
                            <div class="modal-footer">
                                &iquest;No tienes una cuenta?&nbsp;<a href="#RegisterForm" class="btn btn-info" data-toggle="modal" data-dismiss="modal" aria-hidden="true">Registrate</a><br><br>&iquest;Olvidaste tu contrase&ntilde;a?&nbsp;<a href="#Forgot01Form" class="btn btn-info" data-toggle="modal" data-dismiss="modal" aria-hidden="true">Recuperar tu cuenta</a>
                                        <br><br>&iquest;Aun no has activado tu cuenta?&nbsp;<a href="#ActivateForm" class="btn btn-info" data-toggle="modal" data-dismiss="modal" aria-hidden="true">Activar tu cuenta</a>
                                                </div>
                                                </div>
                                                <!--register form-->
                                                <div id="RegisterForm" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="registerLabel" aria-hidden="true">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        <h3 id="myModalLabel">Registro</h3>
                                                    </div>

                                                    <div class="alert fade in alert-error" id="RegisterError">
                                                        <button type="button" class="close" id="RegisterErrorClose">&times;</button>
                                                        <strong>Error!</strong>&nbsp;<span id="RegisterErrorText">Error de jquery</span>
                                                    </div>
                                                    <div class="alert fade in alert-success" id="RegisterSuccess">
                                                        <button type="button" class="close" id="RegisterSuccessClose">&times;</button>
                                                        <h4>Exito!</h4>
                                                        Su registro se ha completado, revise su correo para activar su cuenta!<br>
                                                            <a href="#ActivateForm" class="btn btn-info" data-toggle="modal" data-dismiss="modal" aria-hidden="true">Activar Cuenta</a>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form class="form-horizontal" id="RegisterFormForm" action="#">
                                                            <div class="control-group">
                                                                <label class="control-label" for="dpi">DPI</label>
                                                                <div class="controls">
                                                                    <input type="text" id="dpi" name="inputdpi" placeholder="DPI">
                                                                </div>
                                                            </div>
                                                            <div class="control-group">
                                                                <label class="control-label" for="nombre">Nombre</label>
                                                                <div class="controls">
                                                                    <input type="text" id="nombre" name="inputnombre" placeholder="Nombre">
                                                                </div>
                                                            </div>
                                                            <div class="control-group">
                                                                <label class="control-label" for="email">Correo Electronico</label>
                                                                <div class="controls">
                                                                    <input type="text" id="email" name="inputemail" placeholder="Email">
                                                                </div>
                                                            </div>
                                                            <div class="control-group">
                                                                <label class="control-label" for="passwd">Contrase&ntilde;a</label>
                                                                <div class="controls">
                                                                    <input type="password" id="passwordr" name="inputpasswordr" placeholder="Contrase&ntilde;a">
                                                                </div>
                                                            </div>
                                                            <div class="control-group">
                                                                <label class="control-label" for="vpass">Verificar Contrase&ntilde;a</label>
                                                                <div class="controls">
                                                                    <input type="password" id="vpassword" name="inputvpassword" placeholder="Contrase&ntilde;a">
                                                                </div>
                                                            </div>
                                                            <div class="control-group">
                                                                <label class="control-label" for="pais">Pais</label>
                                                                <div class="controls">
                                                                    <select id="pais" name="selectpais">
                                                                        <option value="1">Guatemala</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="control-group">
                                                                <div class="controls">
                                                                    <button type="button" class="btn" id="RegisterFormSubmit">Registro</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                        <div class="alert fade in alert-info" id="RegisterLoading">
                                                            <center><strong>Espera!</strong> Estamos revisando esta  info...</center>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">

                                                        &iquest;Ya tienes una cuenta?&nbsp;<a href="#LoginForm" class="btn btn-info" data-toggle="modal" data-dismiss="modal" aria-hidden="true">Inicia Sesion</a>
                                                    </div>


                                                </div>
                                                <!--Terminos y Condiciones-->
                                                <div id="termsConditions" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="termslabel" aria-hidden="true">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        <h3 id="myModalLabel">Terminos y Condiciones</h3>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>
                                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur dictum erat a nulla consequat semper. Nullam sit amet leo quis velit interdum eleifend. Praesent egestas, mi ut porta viverra, lorem diam fermentum quam, et luctus ante arcu at nulla. Nulla facilisi. Ut augue neque, adipiscing vel tempus id, convallis vel leo. Curabitur elit diam, lobortis id volutpat id, imperdiet id urna. Phasellus iaculis interdum sagittis. Pellentesque eget lobortis metus. Praesent nunc elit, sagittis id mattis vel, congue nec orci. Nulla sagittis augue eget leo blandit vestibulum. Nam mattis dignissim diam, ut luctus metus adipiscing nec. Nam lacinia viverra ligula, quis gravida est fringilla vitae. Maecenas sit amet augue nunc, vel euismod neque. Suspendisse sollicitudin posuere massa vitae elementum. Sed eu dolor velit.
                                                        </p> <p>
                                                            Ut ac dapibus felis. Fusce vitae sodales elit. Nunc vel viverra quam. In eget tempus ipsum. Sed adipiscing posuere lacus, vitae pellentesque odio sollicitudin at. Sed posuere tempus dignissim. Donec cursus molestie lacus ut ullamcorper. Duis rhoncus convallis libero posuere sagittis. Nam mauris magna, porta a varius congue, hendrerit non dolor. Aliquam ipsum ante, porta a rhoncus quis, cursus eu ligula.
                                                        </p> <p>
                                                            In hac habitasse platea dictumst. Donec vitae eros ut felis facilisis malesuada. Morbi neque nibh, viverra eget volutpat hendrerit, ultrices sit amet lorem. Donec justo tellus, feugiat at consectetur eu, posuere non turpis. Aliquam quis orci velit, eget porttitor nulla. Nam commodo dignissim dolor nec malesuada. Vivamus a leo vitae purus ultricies gravida sed et nibh. Cras lorem diam, pulvinar in rhoncus nec, semper sed neque. Ut ac turpis diam. Ut dapibus leo vitae enim tempor ultrices tincidunt ipsum vehicula. Morbi imperdiet lorem eget libero vulputate non tincidunt dui eleifend. Morbi dictum tempus volutpat. Maecenas sollicitudin ultricies nibh vitae porta. Praesent nisl nibh, tempor a imperdiet nec, fringilla sit amet metus. Nam lacinia, orci id venenatis condimentum, mauris neque gravida augue, sit amet egestas lectus felis ut lectus.
                                                        </p><p>
                                                            Nullam consectetur, massa eget scelerisque porttitor, velit est suscipit velit, sed molestie lectus metus a tortor. Nullam sit amet arcu orci. Proin pretium, magna tempor interdum dignissim, risus metus rhoncus lacus, sed consequat quam magna eget orci. Aenean tortor libero, venenatis eu porta ac, facilisis at leo. Nullam sodales sem adipiscing erat porta cursus aliquam elit eleifend. Vestibulum luctus nisl eu massa dignissim vitae sagittis ipsum blandit. Donec viverra, felis consequat convallis iaculis, nibh mauris sodales nibh, sed sodales leo velit nec odio. Sed hendrerit enim quis dolor porttitor feugiat. Donec viverra, lorem nec varius elementum, augue turpis adipiscing erat, eu semper elit nulla in risus. Nam consectetur vehicula urna ac ultrices. Nullam pellentesque, urna sed vestibulum faucibus, nibh ipsum hendrerit nisi, vel tincidunt ligula est sit amet nisl. Nunc a lorem neque. Aliquam ultricies felis nec ligula facilisis et faucibus metus venenatis. Vestibulum pharetra sem at quam faucibus vel mollis orci consectetur. Pellentesque quis imperdiet dui. Nunc eget nisl velit, a fermentum tortor.
                                                        </p> <p>
                                                            Vivamus venenatis eros ut risus rutrum non cursus ante faucibus. Fusce sed sem ante. Curabitur sit amet metus erat, vel malesuada arcu. Suspendisse ipsum massa, ornare quis sodales et, sagittis vel felis. Praesent convallis, lacus in auctor lacinia, erat nibh congue orci, at interdum erat arcu placerat orci. Donec malesuada, libero ac dapibus volutpat, augue nibh fringilla est, vitae adipiscing mi lacus eget tortor. Pellentesque ligula tortor, condimentum id volutpat quis, congue et sem. </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        Los terminos y condiciones estan sujetos a cambios sin previo aviso.
                                                    </div>
                                                </div>
                                                <!-- Activar tu cuenta -->
                                                <div id="ActivateForm" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="activatelabel" aria-hidden="true">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        <h3 id="myModalLabel">Activar tu Cuenta</h3>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="alert fade in alert-warning" id="ActivateError">
                                                            <button type="button" class="close" id="ActivateErrorClose">&times;</button>
                                                            <strong>Error!</strong>&nbsp;<span id="ActivateErrorText">Error de jquery</span>
                                                        </div>
                                                        <div class="alert fade in alert-success" id="ActivateSuccess">
                                                            <button type="button" class="close" id="ActivateSuccessClose">&times;</button>
                                                            <h4>Exito!</h4>
                                                            Se ha activado su cuenta exitosamente, puede iniciar sesion!
                                                        </div>
                                                        <p>Cuando te registraste se envio un codigo a tu correo, por favor introduce aqui tu codigo y presiona activar para poder utilizar tu cuenta de redpoint.</p>
                                                        <form class="form-horizontal" id="ActivateFormForm" action="#">
                                                            <div class="control-group">
                                                                <label class="control-label" for="cda">Codigo de Activacion</label>
                                                                <div class="controls">
                                                                    <input type="text" id="cda" name="inputcda" placeholder="Codigo de Activacion">
                                                                </div>
                                                            </div>
                                                            <div class="control-group">
                                                                <div class="controls">
                                                                    <button type="button" class="btn" id="ActivateFormSubmit">Activar</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                        <div class="alert fade in alert-info" id="ActivateLoading">
                                                            <center><strong>Espera!</strong> Estamos revisando esta  info...</center>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        &iquest;Ya activaste tu cuenta?&nbsp;<a href="#LoginForm" class="btn btn-info" data-toggle="modal" data-dismiss="modal" aria-hidden="true">Inicia Sesion</a>
                                                    </div>
                                                </div>
                                                <!-- recuperar cuenta step 1-->
                                                <div id="Forgot01Form" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="recover1label" aria-hidden="true">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        <h3 id="myModalLabel">Recuperar tu Cuenta</h3>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="alert fade in alert-warning" id="Forgot01Error">
                                                            <button type="button" class="close" id="Forgot01ErrorClose">&times;</button>
                                                            <strong>Error!</strong>&nbsp;<span id="Forgot01ErrorText">Error de jquery</span>
                                                        </div>
                                                        <div class="alert fade in alert-success" id="Forgot01Success">
                                                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                                            <h4>Exito!</h4>
                                                            Se ha enviado un correo a tu cuenta, puedes pasar al siguiente paso.
                                                        </div>
                                                        <p>Introduce tu email, te enviaremos un codigo de verificacion y luego podras cambiar tu contrase&ntilde;a, si ya tienes tu codigo utiliza el siguiente paso.</p>
                                                        <form class="form-horizontal" id="Forgot01FormForm" action="#">
                                                            <div class="control-group">
                                                                <label class="control-label" for="emails">Email</label>
                                                                <div class="controls">
                                                                    <input type="text" id="emails" name="inputemails" placeholder="Email">
                                                                </div>
                                                            </div>
                                                            <div class="control-group">
                                                                <div class="controls">
                                                                    <button type="button" class="btn" id="Forgot01FormSubmit">Enviar Email</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                        <div class="alert fade in alert-info" id="Forgot01Loading">
                                                            <center><strong>Espera!</strong> Estamos revisando esta  info...</center>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        &iquest;Te recordaste de tu contrase&ntilde;a?&nbsp;<a href="#LoginForm" class="btn btn-info" data-toggle="modal" data-dismiss="modal" aria-hidden="true">Inicia Sesion</a> <a href="#Forgot02Form" class="btn btn-info" data-toggle="modal" data-dismiss="modal" aria-hidden="true">Paso 2</a> 
                                                    </div>
                                                </div>
                                                <!-- recuperar cuenta step 2-->
                                                <div id="Forgot02Form" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="recover2label" aria-hidden="true">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        <h3 id="myModalLabel">Paso 2: Cambia tu contrase&ntilde;a</h3>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="alert fade in alert-warning" id="Forgot02Error">
                                                            <button type="button" class="close" id="Forgot02ErrorClose">&times;</button>
                                                            <strong>Error!</strong>&nbsp;<span id="Forgot02ErrorText">Error de jquery</span>
                                                        </div>
                                                        <div class="alert fade in alert-success" id="Forgot02Success">
                                                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                                            <h4>Exito!</h4>
                                                            Se ha activado cambiado la contrase&ntilde;a de tu cuenta, ahora puedes iniciar sesion!
                                                        </div>
                                                        <p>Ingresa tu nueva contrase&ntilde;a y luego el codigo de verificacion del paso anterior, si no tienes el codigo puedes regresar al paso anterior.</p>
                                                        <form class="form-horizontal" id="Forgot02FormForm" action="#">
                                                            <div class="control-group">
                                                                <label class="control-label" for="pw1">Contrase&ntilde;a</label>
                                                                <div class="controls">
                                                                    <input type="password" id="pw1" name="inputpw1" placeholder="Contrase&ntilde;a">
                                                                </div>
                                                            </div>
                                                            <div class="control-group">
                                                                <label class="control-label" for="pw2">Verifica tu Contrase&ntilde;a</label>
                                                                <div class="controls">
                                                                    <input type="password" id="pw2" name="inputpw2" placeholder="Contrase&ntilde;a">
                                                                </div>
                                                            </div>
                                                            <div class="control-group">
                                                                <label class="control-label" for="pwcode">Codigo de Verificacion</label>
                                                                <div class="controls">
                                                                    <input type="text" id="pwcode" name="inputpwcode" placeholder="Codigo de Verificacion">
                                                                </div>
                                                            </div>
                                                            <div class="control-group">
                                                                <div class="controls">
                                                                    <button type="button" class="btn" id="Forgot02FormSubmit">Cambiar Contrase&ntilde;a</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                        <div class="alert fade in alert-info" id="Forgot02Loading">
                                                            <center><strong>Espera!</strong> Estamos revisando esta  info...</center>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        &iquest;Ya terminaste?&nbsp;<a href="#LoginForm" class="btn btn-info" data-toggle="modal" data-dismiss="modal" aria-hidden="true">Inicia Sesion</a><a href="#Forgot01Form" class="btn btn-info" data-toggle="modal" data-dismiss="modal" aria-hidden="true">Paso 1</a> 
                                                    </div>
                                                </div>
                                                <!--- interfaz para agregar puntos -->
                                                <div id="agregarPunto" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="termslabel" aria-hidden="true">
                                                    <div class="modal-header">
                                                        <h3 id="myModalLabel">Agregar Punto</h3>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="alert fade in alert-warning" id="agregaError">
                                                            <button type="button" class="close" id="agregaErrorClose">&times;</button>
                                                            <strong>Error!</strong>&nbsp;<span id="agregaErrorText">Error de jquery</span>
                                                        </div>
                                                        <div class="alert fade in alert-success" id="successAgrega">
                                                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                                            <h4>Exito!</h4>
                                                            Se ha activado cambiado la contrase&ntilde;a de tu cuenta, ahora puedes iniciar sesion!
                                                        </div>
                                                        <center>
                                                            <form action="#" id="insertar" name="insertar">
                                                                <input type="hidden" name="lat" id="lat" value="">
                                                                    <input type="hidden" name="lng"  id="lng" value="">
                                                                        <table>
                                                                            <tr>
                                                                                <td><label>Fecha y Hora del Suceso:</label></td>
                                                                                <td><input class="input-large" id="calendar" type="text" name="datetime" ></td>
                                                                            </tr>
                                                                            <tr><td><label>Tipo de Suceso:</label></td><td>
                                                                                    <select name="idTipoPunto" id="idTipoPunto">

                                                                                    </select></td></tr>

                                                                            <tr><td colspan="2"><h4>Comentario:</h4></td></tr>
                                                                            <tr><td colspan="2"><textarea cols="100" rows="3" name="comentario" style="margin: 0px 0px 10px; width: 368px; height: 50px;" id="comentariopunto"></textarea></td></tr>
                                                                            <tr><td colspan="2"><center><input type="button" class="btn btn-primary btn-block" value="Crear Punto" id="submitD"></center></td></tr>
                                                                        </table>
                                                                        </form>
                                                                        </center>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button class="btn btn-block btn-danger" data-dismiss="modal" aria-hidden="true">He Terminado</button>
                                                                        </div>
                                                                        </div>


                                                                        <!-- acordion para datos de usuario tw + fb-->
                                                                        <div class="accordion" id="accordion2" style="position:absolute; right:10px; top:60px; background-color:#F7F7F9; width:250px">
                                                                            <div class="accordion-group">
                                                                                <div class="accordion-heading">
                                                                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne" style="text-decoration:none"><?php
                                                    if (isset($_SESSION['correo'])) {
                                                        echo (trim($_SESSION['correo']));
                                                    } else {
                                                        ?>Usuario Anonimo<?php } ?></a>
                                                                                </div>
                                                                                <div id="collapseOne" class="accordion-body collapse in">
                                                                                    <div class="accordion-inner">
                                                                                        <?php
                                                                                        if (isset($_SESSION['nombre'])) {
                                                                                            ?><?php echo(trim($_SESSION['nombre'])); ?><h4>Menu:</h4>
                                                                                            <center>
                                                                                                <a href="#" class="btn btn-block btn-primary">Mis Puntos</a><br>
                                                                                                    <a href="#" class="btn btn-block btn-primary">Mis Denuncias</a><br>  
                                                                                                        <a href="#" class="btn btn-block btn-info">Mi Cuenta</a><br>  
                                                                                                            <a href="logout.php" class="btn btn-block btn-danger">Cerrar Sesion</a></center>
                                                                                                        <?php } else {
                                                                                                            ?>
                                                                                                            En la actualidad estas utilizando redpoint como un usuario anonimo, puedes ver y colocar puntos.
                                                                                                        <?php } ?>
                                                                                                        </div>
                                                                                                        </div>
                                                                                                        </div>
                                                                                                        <div class="accordion-group">
                                                                                                            <div class="accordion-heading">
                                                                                                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo" style="text-decoration:none">
                                                                                                                    Redes Sociales:
                                                                                                                </a>
                                                                                                            </div>
                                                                                                            <div id="collapseTwo" class="accordion-body collapse">
                                                                                                                <div class="accordion-inner">
                                                                                                                    <a class="twitter-timeline" href="https://twitter.com/search?q=%23redpoint" data-widget-id="311198387074646018">Tweets sobre "#redpoint"</a>
                                                                                                                    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        </div>
                                                                                                        <!-- Le javascript
                                                                                                    ================================================== -->
                                                                                                        <!-- Placed at the end of the document so the pages load faster -->
                                                                                                        <script src="js/jquery.js"></script>
                                                                                                        <script src="js/bootstrap-transition.js"></script>
                                                                                                        <script src="js/bootstrap-alert.js"></script>
                                                                                                        <script src="js/bootstrap-modal.js"></script>
                                                                                                        <script src="js/bootstrap-dropdown.js"></script>
                                                                                                        <script src="js/bootstrap-scrollspy.js"></script>
                                                                                                        <script src="js/bootstrap-tab.js"></script>
                                                                                                        <script src="js/bootstrap-tooltip.js"></script>
                                                                                                        <script src="js/bootstrap-popover.js"></script>
                                                                                                        <script src="js/bootstrap-button.js"></script>
                                                                                                        <script src="js/bootstrap-collapse.js"></script>
                                                                                                        <script src="js/bootstrap-carousel.js"></script>
                                                                                                        <script src="js/bootstrap-typeahead.js"></script>
                                                                                                        <script src="js/bootstrap-affix.js"></script>
                                                                                                        <script src="js/holder/holder.js"></script>
                                                                                                        <script src="js/google-code-prettify/prettify.js"></script>
                                                                                                        <script src="js/application.js"></script>
                                                                                                        <script src="js/redpoint-prevfunctions.js"></script>
                                                                                                        <script>
                                                                                                            function share(red){
                                                                                                                if(red=="fb"){
                                                                                                                    PopupCenter("https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fredpoint.herobo.com&t=Redpoint%20Crowdsourcing%20Helpful%20Maps","Facebook",300,500);
                                                                                                                }else if (red=="tw"){
                                                                                                                    PopupCenter("https://twitter.com/intent/tweet?hashtags=redpoint&original_referer=https%3A%2F%2Ftwitter.com%2Fabout%2Fresources%2Fbuttons&source=tweetbutton&text=Redpoint%3A%20Crowdsourcing%20Helpful%20maps&url=http%3A%2F%2Fredpoint.herobo.com","Twitter",300,500);
                                                                                                                }else if (red=="gp"){
                                                                                                                    PopupCenter("https://plus.google.com/share?url=http://redpoint.herobo.com","Google Plus",300,500);
                                                                                                                }
                            
                                                                                                            }
                                                                                                            function PopupCenter(pageURL, title,h,w) {
                                                                                                                var left = (screen.width/2)-(w/2);
                                                                                                                var top = (screen.height/2)-(h/2);
                                                                                                                var targetWin = window.open (pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
                                                                                                                if (window.focus) {targetWin.focus();}
                                                                                                            } 
                                                                                                            function showModal(lat,lon){
                                                                                                                $('#agregarPunto').modal({backdrop:true,backdrop: 'static'});
                                                                                                                $('#lat').attr('value',lat); 
                                                                                                                $('#lng').attr('value',lon); 
                                                                                                                $('#agregarPunto').modal('show');
                                                                                                            }
                                                                                                        </script>

                                                                                                        <img src="img/softso.png" style="position:absolute; bottom:20px; right:10px"/>
                                                                                                        </body>
                                                                                                        </html>

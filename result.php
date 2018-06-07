<!--
	Copyright 2009 Jeremie Tisseau
	"Sliding Login Panel with jQuery 1.3.2" is distributed under the GNU General Public License version 3:
	http://www.gnu.org/licenses/gpl-3.0.html
-->
<?php session_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
	<?php include ('functions/funciones.php'); ?>
  	<title>TRABAJOS PROGRAMADOS</title>
  	<meta name="description" content="Inventario lógico" />
  	<meta name="keywords" content="Inventario lógico" />
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />	
	<!-- stylesheets -->
  	<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
  	<link rel="stylesheet" href="css/slide.css" type="text/css" media="screen" />
  	<!-- upload file -->
	<link rel="stylesheet" href="css/jquery.plupload.queue.css" type="text/css" media="screen" />
  	<!--<link rel="stylesheet" href="css/form.css" type="text/css" media="screen" />-->
  	<!-- PNG FIX for IE6 -->
  	<!-- http://24ways.org/2007/supersleight-transparent-png-in-ie6 -->
	<!--[if lte IE 6]>
		<script type="text/javascript" src="js/pngfix/supersleight-min.js"></script>
	<![endif]-->	 
    <!-- jQuery - the core -->
	<script src="js/jquery-1.3.2.min.js" type="text/javascript"></script>
	<!-- Sliding effect -->
	<script src="js/slide.js" type="text/javascript"></script>
		<!-- production -->
	<script type="text/javascript" src="js/plupload.full.min.js"></script>
	<script type="text/javascript" src="js/jquery.plupload.queue.js"></script>
	<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>-->

</head>
<body>

<!-- Panel -->
<div id="toppanel">
	<div id="panel">
		<div class="content clearfix">
			<div class="left">
				<h1>SSR</h1>
				<img src="images/ftth.jpg"/>
			</div>
			<?php if (empty($_SESSION['usuario']) && empty($_SESSION['password'])) { ?>
			<div class="left">
				<form class="clearfix" action="functions/login.php" method="post">
					<h1>Inicio de sesión de usuario</h1>
					<label class="grey" for="log">Nombre de usuario:</label>
					<input class="field" type="text" name="usuario" id="usu" value="" size="23" />
					<label class="grey" for="pwd">Password:</label>
					<input class="field" type="password" name="password" id="pass" size="23" />
	            	<label><input name="rememberme" id="rememberme" type="checkbox" checked="checked" value="forever" /> &nbsp;Recordar password</label>
        			<div class="clear"></div>
					<input type="submit" name="submit" value="Iniciar" class="bt_login" />
				</form>
			</div>
			<?php } else { ?>
			<div class="rigth">
				<!--<div id="cont_tools">-->
					<a href="functions/logoff.php">
						<div id="controles">
							<img src="images/ico/power27.png" />
							<div id="txt_btn">
								<p id="label_btn">Salir</p>
							</div>
						</div>
					</a>
				<!--</div>-->
			</div>
			<?php } ?>
		</div>
	</div> <!-- /login -->	
	<!-- The tab on top -->	
	<div class="tab">
		<ul class="login">
			<li class="left">&nbsp;</li>
			<li><?php echo get_nombre($_SESSION['usuario']); ?></li>
			<li class="sep">|</li>
			<li id="toggle">
				<a id="open" class="open" href="#">Iniciar sesión</a>
				<a id="close" style="display: none;" class="close" href="#">Cerrar panel</a>			
			</li>
			<li class="right">&nbsp;</li>
		</ul> 
	</div> <!-- / top -->
</div> <!--panel -->

    <div id="container">
		<div id="content">
			<div id="tools">
				<div id="logo">
					<img src="images/logo.jpg" width="178" height="100"/>
				</div>
				<!--Decido si muestro o no el menu de usuario -->
				<?php
					if (es_usuario($_SESSION['usuario'],$_SESSION['password'])){
				?>
				<div id="cont_tools">
					<a href="index.php?view=1">
						<div id="controles">
							<img src="images/ico/microsoftexcel.png" />
							<div id="txt_btn">
								<p id="label_btn">Cargar</p>
							</div>
						</div>
					</a>
					<a href="index.php?view=2">
						<div id="controles">
							<img src="images/ico/verified18.png" />
							<div id="txt_btn">
								<p id="label_btn">Solicitudes</p>
							</div>
						</div>
					</a>
					<?php
						if (get_perfil($_SESSION['usuario']) == 1 || get_perfil($_SESSION['usuario']) == 2) {
					?>
					<a href="index.php?view=3">
						<div id="controles">
							<img src="images/ico/search111.png" />
							<div id="txt_btn">
								<p id="label_btn">Revisión</p>
							</div>
						</div>
					</a>
					<a href="index.php?view=4">
						<div id="controles">
							<img src="images/ico/spreadsheet5.png" />
							<div id="txt_btn">
								<p id="label_btn">Informes</p>
							</div>
						</div>
					</a>
					<a href="index.php?view=5">
						<div id="controles">
							<img src="images/ico/settings48.png" />
							<div id="txt_btn">
								<p id="label_btn">Configuración</p>
							</div>
						</div>
					</a>
					<?php } ?>
					<a href="index.php">
						<div id="home_btn">
							<img src="images/ico/house58.png" />
							<div id="txt_btn">
								<p id="label_btn">Inicio</p>
							</div>
						</div>
					</a>
				</div>
				<?php } ?>
				<!--Decido si muestro o no el menu de usuario -->
				<div id="breagkrumb">

				</div>
<!-- llamada de pantalla solicitada -->				
				<div id="cont_view">
					<?php
						//echo '<link rel="stylesheet" type="text/css" href="css/smoothness/jquery-ui-1.8.16.custom.css"/>';
						//echo '<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>';
						//echo '<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>';
						echo '<script type="text/javascript" src="js/validaciones.js"></script>';
						include ('functions/leer_xls.php');
						if(!empty($_FILES["file"]["tmp_name"])) {
							leer_fichero($_FILES["file"]["tmp_name"]);
						}
						else {
							ob_start(); 
							header("refresh: 3; url = index.php?view=1");
							echo '<div id="content_result">';
							echo '<h1><img src="images/ico/warning45.png" /> Debe seleccionar un archivo con extensión ".xslx" para procesarlo</h1>';
							echo '</div>';
							ob_end_flush();
						}
					?>
<!-- llamada de pantalla solicitada -->					
<!-- Este escript lo utiliza el componente para subir archivos al servidor-->
					<script type="text/javascript">
						$(function() {

							// Setup html5 version
							$("#html5_uploader").pluploadQueue({
								// General settings
								runtimes : 'html5',
								url : 'functions/upload.php',
								chunk_size : '1mb',
								unique_names : true,
								
								filters : {
									max_file_size : '1mb',
									mime_types: [
										{title : "Archivo Excel", extensions : "xls,xlsx"},
										/*{title : "Zip files", extensions : "zip"}*/
									]
								},
								// Resize images on clientside if we can
								//resize : {width : 320, height : 240, quality : 90}
							});
						});
					</script>
<!-- Este escript lo utiliza el componente para subir archivos al servidor-->					
				</div>
			</div>
		</div><!-- / content -->		
	</div><!-- / container -->
</body>
</html>
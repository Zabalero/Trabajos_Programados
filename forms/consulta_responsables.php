<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
	<title>Operaciones de responsables</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	
	<!-- stylesheets -->
  	<link rel="stylesheet" href="../css/style.css" type="text/css" media="screen" />
  	<script type="text/javascript" src="../js/validaciones.js"></script>
  	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
</head>
<body>
<?php
	include ('../functions/funciones.php');

	if (isset($_REQUEST['cod_resp'])) {

		$conn=conectar_bd();
		$tsql="SELECT * FROM tbResponsables WHERE COD_RESPONSABLE = ".$_GET['cod_resp']." ";
		$stmt = sqlsrv_query( $conn, $tsql);
		if( $stmt === false ){
			die ("Error al ejecutar consulta datos responsables");
		}
		while($row = sqlsrv_fetch_array($stmt)){
			
			$cod_resp = $row['COD_RESPONSABLE'];
			$nombre_comp = $row['NOMBRE_COMPLETO'];
			$telefono = $row['TELEFONO'];
		}
	}

	if (isset($_REQUEST['mode'])) {
		$mode = $_REQUEST['mode'];
		if ($mode == 1){
			$lectura = 'readOnly';
			$deshabilitado = 'disabled';
		}
		if ($mode == 2){
			$lectura = '';
			$deshabilitado = '';
			$accion = 'actualizar_resp';
		}
	}
	else {
		$accion = 'insertar_resp';
		$lectura = '';
		$deshabilitado = '';
		$mode = 2;
	}
?>

	<div id="content_result">
		<div id="apartado">
		<h2><b>DATOS DE RESPONSABLES</b></h2>
		</div>
		<form name="admin_resp" onsubmit="return validarGuardarResp()" method="post" enctype="multipart/form-data" action="../functions/process_solicitud.php?accion=<?php echo $accion; ?>">
		<input type="hidden" name="usuario" id="usuario" value="<?php echo $_SESSION['privi']; ?>" />
		<input type="hidden" name="perfil" id="perfil" value="<?php echo $_SESSION['perfil']; ?>" />
		<input type="hidden" name="cod_resp" id="cod_resp" value="<?php echo $cod_resp; ?>" />
		<div id="apartado">
			<div id="campo_right">
				<p><b>NOMBRE COMPLETO</b>: <input type="text" <?php echo $lectura; ?> size ="40" id="nombre_comp" name="nombre_comp" value="<?php echo $nombre_comp; ?>"/></p>
			</div>
			<div id="campo_right"> 
				<p><b>TELEFONO</b>: <input type="text" <?php echo $lectura; ?> size ="13" id="telefono" name="telefono" value="<?php echo $telefono; ?>"/></p>
			</div>
		<?php
		if ($mode == 2) {
		?>
		<div id="cont_tools">
			<div id="controles">
				<input class="boton_guardar" type="submit" name="submitButtonName" value="">
				<div id="txt_btn">
					<p id="label_btn">GUARDAR</p>
				</div>
			</div>
			<div id="controles">
				<input class="boton_cancelar" onclick="parent.$.fancybox.close();" name="submitButtonName" value="">
				<div id="txt_btn">
					<p id="label_btn">CANCELAR</p>
				</div>
			</div>
		</div>
		<?php } ?>
		</form>
	</div>
<?php
	sqlsrv_free_stmt( $stmt);
	sqlsrv_close( $conn);
?>
</body>
</html>
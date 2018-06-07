<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
	<title>Operaciones de provincias</title>
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

	if (isset($_REQUEST['cod_prov'])) {

		$conn=conectar_bd();
		$tsql="SELECT * FROM tbProvincias WHERE COD_PROVINCIA = ".$_GET['cod_prov']." ";
		$stmt = sqlsrv_query( $conn, $tsql);
		if( $stmt === false ){
			die ("Error al ejecutar consulta datos provincias");
		}
		while($row = sqlsrv_fetch_array($stmt)){
			
			$cod_prov = $row['COD_PROVINCIA'];
			$provincia = $row['DESCRIPCION'];
			$region = $row['COD_REGION'];
			$iniciales = $row['INICIALES'];
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
			$accion = 'actualizar_prov';
		}
	}
	else {
		$accion = 'insertar_prov';
		$lectura = '';
		$deshabilitado = '';
		$mode = 2;
	}
?>

	<div id="content_result">
		<div id="apartado">
		<h2><b>DATOS DE PROVINCIAS</b></h2>
		</div>
		<form name="admin_prov" onsubmit="return validarGuardarProv()" method="post" enctype="multipart/form-data" action="../functions/process_solicitud.php?accion=<?php echo $accion; ?>">
		<input type="hidden" name="usuario" id="usuario" value="<?php echo $_SESSION['privi']; ?>" />
		<input type="hidden" name="perfil" id="perfil" value="<?php echo $_SESSION['perfil']; ?>" />
		<input type="hidden" name="cod_prov" id="cod_prov" value="<?php echo $cod_prov; ?>" />
		<div id="apartado">
			<div id="campo_right">
			<p><b>NOMBRE PROVINCIA</b>: <input type="text" <?php echo $lectura; ?> size ="40" id="provincia" name="provincia" value="<?php echo $provincia; ?>"/></p>
			</div>
			<div id="campo_right">
			<p><b>INICIALES</b>: <input type="text" <?php echo $lectura; ?> size ="2" id="iniciales" name="iniciales" value="<?php echo $iniciales; ?>"/></p>
			</div>
			<div id="campo_right"> 
			<p><b>REGIONES</b>:
			<?php
				echo '<select name="regiones" id="regiones" '.$deshabilitado.' >';
					echo '<option value="0"></option>';
					$conn=conectar_bd();
					$tsql2="SELECT COD_REGION,UPPER(RTRIM(DESCRIPCION)) AS DESCRIPCION FROM tbRegiones";
					//Obtiene el resultado
					$query2 = sqlsrv_query( $conn, $tsql2); 
					while($row2 = sqlsrv_fetch_array($query2)){
						if ($row2['COD_REGION'] != $region) {
					    	echo '<option value="'.$row2['COD_REGION'].'">';
					    }
					    else {
					    	echo '<option value="'.$row2['COD_REGION'].'" selected>';
					    }
					    echo $row2['DESCRIPCION'];
					    echo '</option>';
					}
					sqlsrv_free_stmt( $query2);
					sqlsrv_close( $conn);
				echo '</select>';
				echo '</p>';                	
			?>
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
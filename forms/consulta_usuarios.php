<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
	<title>Operaciones de usuarios</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	
	<!-- stylesheets -->
  	<link rel="stylesheet" href="../css/style.css" type="text/css" media="screen" />
  	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<link rel="stylesheet" type="text/css" href="../css/jquery.tokenize.css" />
  	<script type="text/javascript" src="../js/validaciones.js"></script>
  	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  	<script type="text/javascript" src="../js/jquery.tokenize.js"></script>
</head>
<body>
<?php
	include ('../functions/funciones.php');

	if (isset($_REQUEST['cod_usu'])) {

		$conn=conectar_bd();
		$tsql="SELECT * FROM tbUsuarios WHERE COD_USUARIO = ".$_GET['cod_usu']." ";
		$stmt = sqlsrv_query( $conn, $tsql);
		if( $stmt === false ){
			die ("Error al ejecutar consulta datos regional");
		}
		while($row = sqlsrv_fetch_array($stmt)){
			
			$cod_usu = $row['COD_USUARIO'];
			$login = $row['LOGIN'];
			$nombre_completo = $row['NOMBRE_COMPLETO'];
			$perfil_usuario = $row['COD_PERFIL'];
			$email = $row['EMAIL'];
			$dni = $row['DNI'];
			$password = $row['PASSWORD'];
			$region = $row['COD_REGION'];
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
			$accion = 'actualizar_usu';
		}
	}
	else {
		$accion = 'insertar_usu';
		$lectura = '';
		$deshabilitado = '';
		$mode = 2;
	}
?>

	<div id="content_result">
		<div id="apartado">
		<h2><b>DATOS DE USUARIOS</b></h2>
		</div>
		<form name="admin_usu" onsubmit="return validarGuardarUsu()" method="post" enctype="multipart/form-data" action="../functions/process_solicitud.php?accion=<?php echo $accion; ?>">
		<input type="hidden" name="usuario" id="usuario" value="<?php echo $_SESSION['privi']; ?>" />
		<input type="hidden" name="perfil" id="perfil" value="<?php echo $_SESSION['perfil']; ?>" />
		<input type="hidden" name="cod_usu" id="cod_usu" value="<?php echo $cod_usu; ?>" />
		<div id="apartado">
			<div id="campo_right">
			<p><b>NOMBRE COMPLETO</b>: <input type="text" <?php echo $lectura; ?> size ="40" id="nombre_completo" name="nombre_completo" value="<?php echo $nombre_completo; ?>"/></p>
			</div>
			<div id="campo_right">
			<p><b>NOMBRE DE USUARIO</b>: <input type="text" <?php echo $lectura; ?> size ="20" id="login" name="login" value="<?php echo $login; ?>"/></p>
			</div>
			<div id="campo_right">
			<?php if ($_SESSION['perfil'] != 4) { ?>
				<p><b>PASSWORD</b>: <input type="password" <?php echo $lectura; ?> size ="10" id="password" name="password" value="<?php echo $password; ?>"/></p>
			<?php } else { ?>
				<p><b>PASSWORD</b>: <input type="text" <?php echo $lectura; ?> size ="10" id="password" name="password" value="<?php echo $password; ?>"/></p>
			<?php } ?>
			</div>
			<div id="campo_right">
			<p><b>DIRECCIÓN DE EMAIL</b>: <input type="text" <?php echo $lectura; ?> size ="50" id="email" name="email" value="<?php echo $email; ?>"/></p>
			</div>
			<div id="campo_right">
			<p><b>DNI</b>: <input type="text" <?php echo $lectura; ?> size ="20" id="dni" name="dni" value="<?php echo $dni; ?>"/></p>
			</div>
			<div id="campo_right"> 
			<p><b>PERFIL</b>:
			<?php
				echo '<select name="perfil_usu" id="perfil_usu" '.$deshabilitado.' >';
					echo '<option value="0"></option>';
					$conn=conectar_bd();
					$tsql2="SELECT COD_PERFIL,UPPER(RTRIM(DESCRIPCION)) AS DESCRIPCION FROM tbPerfiles";
					//Obtiene el resultado
					$query2 = sqlsrv_query( $conn, $tsql2); 
					while($row2 = sqlsrv_fetch_array($query2)){
						if ($row2['COD_PERFIL'] != $perfil_usuario) {
					    	echo '<option value="'.$row2['COD_PERFIL'].'">';
					    }
					    else {
					    	echo '<option value="'.$row2['COD_PERFIL'].'" selected>';
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
			<div id="campo_right"> 
			<p><b>REGION</b>:
			<?php
				echo '<select name="region" id="region" '.$deshabilitado.' >';
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
			<div id="campo_right"> 
				<p><br><br><b>PROVINCIAS ASOCIADAS (SOLO PERFIL MULTIREGIÓN):</b></p>
				<p>
				<?php
					$conexion = conectar_bd();
					$tsql_provincia = "SELECT * FROM tbProvincias ORDER BY DESCRIPCION";
					$query_provincia = sqlsrv_query($conexion,$tsql_provincia) or die ("Error al intentar obter historico ==> TSQL = ".$tsql_provincia);
					echo '<select name="provincias[]" id="provincias" multiple="multiple" class="tokenize-sample">';
					while ($prov=sqlsrv_fetch_array($query_provincia)) {
					    echo '<option value="'.$prov['COD_PROVINCIA'].'" selected>'.strtoupper($prov['DESCRIPCION']).'</option>';
					}
					echo '</select>';
					sqlsrv_free_stmt($query_provincia);
					sqlsrv_close($conexion);
				?>
				</p>
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
	<script type="text/javascript">
		$('#provincias').hide();
		$('#provincias').tokenize().disable();
		$('#perfil_usu').change(function(){
			$('#provincias').hide();
			$('#provincias').tokenize().disable();	
			if ($('#perfil_usu').val() == 5) {
				$('#provincias').tokenize();
				$('#provincias').tokenize().enable();
			}
		});
	</script>
<?php
	sqlsrv_free_stmt( $stmt);
	sqlsrv_close( $conn);
?>
</body>
</html>
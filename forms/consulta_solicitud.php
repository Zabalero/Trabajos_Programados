<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
	<title>Solicitud de Trabajo</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	
	<!-- stylesheets -->
  	<link rel="stylesheet" href="../css/style.css" type="text/css" media="screen" />
  	<link href="../css/dropzone.css" type="text/css" rel="stylesheet" />
  	<script type="text/javascript" src="../js/validaciones.js"></script>
  	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  	<script src="../js/dropzone.js"></script>

  	<script>
	  $(function() {
	  	$.datepicker.setDefaults($.datepicker.regional["es"]);
	    $( "input#fechaini, input#fechafin" ).datepicker({
				firstDay: 1,
				closeText: 'Cerrar',
				prevText: '<Ant',
				nextText: 'Sig>',
				currentText: 'Hoy',
				monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
				monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
				dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
				dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
				dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
				weekHeader: 'Sm',
				dateFormat: 'dd/mm/yy',
				firstDay: 1,
				isRTL: false,
				showMonthAfterYear: false,
				yearSuffix: '',
			});
		});
  	</script>

</head>
<body>
<?php
	include ('../functions/funciones.php');

	if (isset($_REQUEST['jobcode'])) {

		$conn=conectar_bd();
		$tsql="SELECT tbTrabajos_Solicitados.COD_TRABAJO AS SOLICITUD,
		   ISNULL(RTRIM(tbGrupos.COD_GRUPO),'') AS GRUPO,
		   ISNULL(RTRIM(tbResponsables.COD_RESPONSABLE),'') AS RESPONSABLE,
		   ISNULL(RTRIM(tbTipos_Actuacion.COD_TIPO_ACTUACION),'') AS TIPO_ACT,
		   ISNULL(RTRIM(tbProvincias.COD_PROVINCIA),'') AS PROVINCIA,
		   ISNULL(RTRIM(tbEmpresas.COD_EMPRESA),'') AS EMPRESA,
		   RTRIM(CONVERT(CHAR,tbTrabajos_Solicitados.FX_PROPUESTA_INICIO,103)) AS PRO_FECHAINI,
		   RTRIM(CONVERT(CHAR,tbTrabajos_Solicitados.FX_PROPUESTA_INICIO,108)) AS PRO_HORAINI,
		   RTRIM(CONVERT(CHAR,tbTrabajos_Solicitados.FX_PROPUESTA_FIN,103)) AS PRO_FECHAFIN,
		   RTRIM(CONVERT(CHAR,tbTrabajos_Solicitados.FX_PROPUESTA_FIN,108)) AS PRO_HORAFIN,
		   ISNULL(RTRIM(tbTrabajos_Solicitados.IDENTIFICADOR),'') AS IDENT,
		   ISNULL(RTRIM(tbResponsables.TELEFONO),'') AS TLF_RESP,
		   ISNULL(RTRIM(tbCentrales.COD_CENTRAL),'') AS CENTRAL,
		   ISNULL(RTRIM(tbTecnicos.COD_TECNICO),'') AS TECNICO,
		   ISNULL(RTRIM(tbTecnicos.TELEFONO),'') AS TLF_TEC,
		   ISNULL(RTRIM(tbTrabajos_Solicitados.CAMARA_FRONTERA),'') AS CAMARA,
		   ISNULL(RTRIM(tbTrabajos_Solicitados.PROYECTO),'') AS PROYECTO,
		   ISNULL(RTRIM(tbTrabajos_Solicitados.DESCRIPCION),'') AS DESCRIPCION,
		   ISNULL(RTRIM(tbTrabajos_Revisados.COMENTARIOS),'') AS OBSERVACIONES,
		   RTRIM(CONVERT(CHAR,tbTrabajos_Revisados.FX_APROBADA_INICIO,103)) AS APRO_FECHAINI,
		   RTRIM(CONVERT(CHAR,tbTrabajos_Revisados.FX_APROBADA_INICIO,108)) AS APRO_HORAINI,
		   RTRIM(CONVERT(CHAR,tbTrabajos_Revisados.FX_APROBADA_FIN,103)) AS APRO_FECHAFIN,
		   RTRIM(CONVERT(CHAR,tbTrabajos_Revisados.FX_APROBADA_FIN,108)) AS APRO_HORAFIN,
		   ISNULL(RTRIM(tbTrabajos_Revisados.REMEDY),'') AS REMEDY,
		   ISNULL(RTRIM(tbUsuarios.NOMBRE_COMPLETO),'') AS USU_SSR,
		   ISNULL(RTRIM(tbUbicaciones.COD_UBICACION),'') AS UBICACION,
		   ISNULL(RTRIM(tbTrabajos_Solicitados.REQUIERE_PERMISO_AC),'--') AS PERMISO,
		   ISNULL(RTRIM(tbTrabajos_Solicitados.PERMISO_CONCEDIDO),'--') AS PERMISOCON,
		   ISNULL(RTRIM(tbTrabajos_Solicitados.REPLANTEO_PREVIO),'--') AS REPLANTEO,
		   ISNULL(RTRIM(tbTrabajos_Solicitados.CAMARA_OK),'--') AS CONDICIONES
		FROM tbTrabajos_Solicitados 
		LEFT JOIN tbTipos_Actuacion ON tbTipos_Actuacion.COD_TIPO_ACTUACION = tbTrabajos_Solicitados.COD_TIPO_ACTUACION 
		LEFT JOIN tbResponsables ON tbTrabajos_Solicitados.COD_RESPONSABLE = tbResponsables.COD_RESPONSABLE 
		LEFT JOIN tbCentrales ON tbTrabajos_Solicitados.COD_CENTRAL = tbCentrales.COD_CENTRAL 
		LEFT JOIN tbProvincias ON tbCentrales.COD_PROVINCIA = tbProvincias.COD_PROVINCIA 
		LEFT JOIN tbEmpresas ON tbTrabajos_Solicitados.COD_EMPRESA = tbEmpresas.COD_EMPRESA
		LEFT JOIN tbTecnicos ON tbTrabajos_Solicitados.COD_TECNICO = tbTecnicos.COD_TECNICO
		LEFT JOIN tbTrabajos_Revisados ON tbTrabajos_Revisados.COD_TRABAJO = tbTrabajos_Solicitados.COD_TRABAJO 
		LEFT JOIN tbUsuarios ON tbTrabajos_Revisados.COD_USUARIO_SSR = tbUsuarios.COD_USUARIO
		LEFT JOIN tbUbicaciones ON tbTrabajos_Solicitados.COD_UBICACION = tbUbicaciones.COD_UBICACION
		LEFT JOIN tbGrupos ON tbTrabajos_Solicitados.COD_GRUPO = tbGrupos.COD_GRUPO
		WHERE tbTrabajos_Solicitados.COD_TRABAJO = ".$_GET['jobcode']." ";
		$stmt = sqlsrv_query( $conn, $tsql);
		if( $stmt === false ){
			die ("Error al ejecutar consulta datos regional");
		}
		while($row = sqlsrv_fetch_array($stmt)){
			
			$solicitud = $row['SOLICITUD'];
			$grupo = $row['GRUPO'];
			$responsable = $row['RESPONSABLE'];
			$tipo_act = $row['TIPO_ACT'];
			$provincia = $row['PROVINCIA'];
			$empresa = $row['EMPRESA'];
			$pro_fechaini = $row['PRO_FECHAINI'];
			$pro_horaini = $row['PRO_HORAINI'];
			$pro_fechafin = $row['PRO_FECHAFIN'];
			$pro_horafin = $row['PRO_HORAFIN'];
			$ident = $row['IDENT'];
			$tlf_resp = $row['TLF_RESP'];
			$central = $row['CENTRAL'];
			$tecnico = $row['TECNICO'];
			$tlf_tec = $row['TLF_TEC'];
			$camara = $row['CAMARA'];
			$proyecto = $row['PROYECTO'];
			$descripcion = $row['DESCRIPCION'];
			$observaciones = $row['OBSERVACIONES'];
			$apro_fechaini = $row['APRO_FECHAINI'];
			$apro_horaini = $row['APRO_HORAINI'];
			$apro_fechafin = $row['APRO_FECHAFIN'];
			$apro_horafin = $row['APRO_HORAFIN'];
			$remedy = $row['REMEDY'];
			$usu_ssr = $row['USU_SSR'];
			$ubicacion = $row['UBICACION'];
			$permiso = $row['PERMISO'];
			$permisocon = $row['PERMISOCON'];
			$replanteo = $row['REPLANTEO'];
			$condiciones = $row['CONDICIONES'];	
		}
	}

	$tsql_est = "SELECT RTRIM(ESTADO_TP) AS ESTADO_TP FROM tbTrabajos_Solicitados WHERE COD_TRABAJO = ".$solicitud." ";
	$query_est = sqlsrv_query($conn,$tsql_est);
	$result_est = sqlsrv_fetch_array($query_est);
	$ult_est = $result_est['ESTADO_TP'];

	if (isset($_GET['mode'])) {
		$mode = $_GET['mode'];
		$accion = 'actualizar';
	}
	else {
		$mode = 2;
		$accion = 'insertar';
	}

	if ($mode == 1){
		$lectura = 'readOnly';
		$deshabilitado = 'disabled';
	}
	if ($mode == 2){
		if ($ult_est === 'Registrado'){
			$lectura = '';
			$deshabilitado = '';
		}
		elseif ($ult_est == '') {
			$lectura = '';
			$deshabilitado = '';
		}
		else {
			$lectura = 'readOnly';
			$deshabilitado = 'disabled';
		}
	}
	if ($_SESSION['perfil'] == 1 && $mode == 2) {
		$lectura = '';
		$deshabilitado = '';
		$accion = 'actualizar';
	}
?>

	<div id="content_result">
		<div id="apartado">
		<h2><b>DATOS ADMINISTRATIVOS DEL CAMBIO  ( <?php echo $solicitud; ?> )</b></h2>
		</div>
		<form name="solicitud_ssr" onsubmit="return validarSolicitud()" method="post" enctype="multipart/form-data" action="../functions/process_solicitud.php?accion=<?php echo $accion.'&org=2'; ?>">
		<input type="hidden" name="usuario" id="usuario" value="<?php echo $_SESSION['privi']; ?>" />
		<input type="hidden" name="perfil" id="perfil" value="<?php echo $_SESSION['perfil']; ?>" />
		<input type="hidden" name="solicitud" id="solicitud" value="<?php echo $solicitud; ?>" />
		<div id="apartado">
			<?php if ($usu_ssr != '') { ?>
			<div id="campo_right">
			<p><b>USUARIO SSR</b>: <input type="text" <?php echo $lectura; ?> size ="20" id="usu_ssr" name="usu_ssr" value="<?php echo $usu_ssr; ?>"/></p>
			</div>
			<?php } ?>
			<?php if ($remedy != '') { ?>
			<div id="campo_left">
			<p><b>REMEDY</b>: <input type="text" <?php echo $lectura; ?> size ="20" id="remedy" name="remedy" value="<?php echo $remedy; ?>"/></p>
			</div>
			<?php } ?>
			<div id="campo_right">
			<p><b>GRUPO SOLICITANTE</b>: <!--<input type="text" id="grupo_s" <?php //echo $lectura; ?> size ="50" name="grupo_s" value="<?php //echo $grupo; ?>"/></p>-->
			<?php
				echo '<select name="grupo_s" id="grupo_s" '.$deshabilitado.' required>';
					echo '<option value="0">--</option>';
					$conn=conectar_bd();
					$tsql="SELECT COD_GRUPO,UPPER(RTRIM(DESCRIPCION)) AS DESCRIPCION FROM tbGrupos";
					//Obtiene el resultado
					$query = sqlsrv_query( $conn, $tsql); 
					while($row = sqlsrv_fetch_array($query)){
						if ($row['COD_GRUPO'] != $grupo) {
					    	echo '<option value="'.$row['COD_GRUPO'].'">';
					    }
					    else {
					    	echo '<option value="'.$row['COD_GRUPO'].'" selected>';
					    }
					    echo $row['DESCRIPCION'];
					    echo '</option>';
					}
					sqlsrv_free_stmt( $query);
					sqlsrv_close( $conn);
				echo '</select>';
				echo '</p>';                	
			?>
			</div>
			<?php if ($ident != '') { ?>
			<div id="campo_left">
			<p><b>IDENTIFICADOR DEL CAMBIO</b>: <input type="text" id="identificador" readonly size ="20" id="identificador" name="identificador" value="<?php echo $ident; ?>"/></p>
			</div>
			<?php } ?>
			<div id="campo_left">
			<p><b>RESPONSABLE JAZZTEL</b>: <!--<input type="text" id="responsable" <?php //echo $lectura; ?> size ="50" name="responsable" value="<?php //echo $responsable; ?>"/></p>-->
			<?php
				echo '<select name="responsable" id="responsable" >';
					echo '<option value="0"></option>';
					$conn=conectar_bd();
					$tsql="SELECT COD_RESPONSABLE,UPPER(RTRIM(NOMBRE_COMPLETO)) AS NOMBRE_COMPLETO FROM tbResponsables";
					//Obtiene el resultado
					$query = sqlsrv_query( $conn, $tsql); 
					while($row = sqlsrv_fetch_array($query)){
						if ($row['COD_RESPONSABLE'] != $responsable) {
					    	echo '<option value="'.$row['COD_RESPONSABLE'].'">';
					    }
					    else {
					    	echo '<option value="'.$row['COD_RESPONSABLE'].'" selected>';
					    }
					    echo $row['NOMBRE_COMPLETO'];
					    echo '</option>';
					}
					sqlsrv_free_stmt( $query);
					sqlsrv_close( $conn);
				echo '</select>';
				echo '</p>';                	
			?>
			</div>
			<div id="campo_left">
				<p><b>TELÉFONO RESPONSABLE JAZZTEL</b>: <input type="text" id="tlf_resp" <?php echo $lectura; ?> size ="13" name="tlf_resp" value="<?php echo $tlf_resp; ?>"/></p>
			</div>
			<div id="campo_right">
			<p><b>TIPO ACTUACIÓN</b>: <!--<input type="text" id="tipo_act" <?php //echo $lectura; ?> size ="50" name="tipo_act" value="<?php //echo $tipo_act; ?>"/></p>-->
			<?php
				echo '<select name="tipo_act" id="tipo_act" '.$deshabilitado.' >';
					echo '<option value="0"></option>';
					$conn=conectar_bd();
				$tsql="SELECT COD_TIPO_ACTUACION, UPPER(RTRIM(DESCRIPCION)) AS TIPO_ACT FROM tbTipos_Actuacion";
				//Obtiene el resultado
				$query = sqlsrv_query( $conn, $tsql); 
				while($row = sqlsrv_fetch_array($query)){
					if ($row['COD_TIPO_ACTUACION'] != $tipo_act) {
				    	echo '<option value="'.$row['COD_TIPO_ACTUACION'].'">';
				    }
				    else {
				    	echo '<option value="'.$row['COD_TIPO_ACTUACION'].'" selected>';
				    }
				    echo $row['TIPO_ACT'];
				    echo '</option>';
				}
				sqlsrv_free_stmt( $query);
				sqlsrv_close( $conn);
				echo '</select>';
				echo '</p>';                	
			?>
			</div>
			<div id="campo_right">
			<p><b>PROVINCIA</b>: <!--<input type="text" id="provincia" <?php //echo $lectura; ?> size ="30" name="provincia" value="<?php //echo $provincia; ?>"/></p>-->
			<?php
				echo '<select name="provincia" id="provincia" disabled >';
					echo '<option value="0"></option>';
					$conn=conectar_bd();
					$tsql="SELECT COD_PROVINCIA,UPPER(RTRIM(DESCRIPCION)) AS PROVINCIA FROM tbProvincias";
					//Obtiene el resultado
					$query = sqlsrv_query( $conn, $tsql); 
					while($row = sqlsrv_fetch_array($query)){
						if ($row['COD_PROVINCIA'] != $provincia) {
					    	echo '<option value="'.$row['COD_PROVINCIA'].'">';
					    }
					    else {
					    	echo '<option value="'.$row['COD_PROVINCIA'].'" selected>';
					    }
					    echo $row['PROVINCIA'];
					    echo '</option>';
					}
					sqlsrv_free_stmt( $query);
					sqlsrv_close( $conn);
				echo '</select>';
				echo '</p>';                	
			?>
			</div>
			<div id="campo_left">
			<p><b>CENTRAL</b>: <!--<input type="text" id="central" <?php //echo $lectura; ?> size ="15" name="central" value="<?php //echo $central; ?>"/></p>-->
			<?php
				echo '<select name="central" id="central" '.$deshabilitado.' >';
					echo '<option value="0"></option>';
					$conn=conectar_bd();
				$tsql="SELECT COD_CENTRAL,UPPER(RTRIM(DESCRIPCION)) AS CENTRAL FROM tbCentrales";
				//Obtiene el resultado
				$query = sqlsrv_query( $conn, $tsql); 
				while($row = sqlsrv_fetch_array($query)){
					if ($row['COD_CENTRAL'] != $central) {
				    	echo '<option value="'.$row['COD_CENTRAL'].'">';
				    }
				    else {
				    	echo '<option value="'.$row['COD_CENTRAL'].'" selected>';
				    }
				    echo $row['CENTRAL'];
				    echo '</option>';
				}
				sqlsrv_free_stmt( $query);
				sqlsrv_close( $conn);
				echo '</select>';
				echo '</p>';                	
			?>
			</div>
			<div id="campo_left">
			<p><b>CÁMARA FRONTERA</b>: <input type="text" id="cam_front" <?php echo $lectura; ?> size ="28" name="cam_front" value="<?php echo $camara; ?>"/></p>
			</div>
			<div id="campo_right">
			<p><b>EMPRESA QUE REALIZA EL CAMBIO</b>: <!--<input type="text" id="empresa" <?php //echo $lectura; ?> size ="28" name="empresa" value=""/></p>-->
			<?php
				echo '<select name="empresa" id="empresa" '.$deshabilitado.' >';
					echo '<option value="0"></option>';
					$conn=conectar_bd();
					$tsql="SELECT COD_EMPRESA,UPPER(RTRIM(DESCRIPCION)) AS EMPRESA FROM tbEmpresas WHERE DESCRIPCION IS NOT NULL";
					//Obtiene el resultado
					$query = sqlsrv_query( $conn, $tsql); 
					while($row = sqlsrv_fetch_array($query)){
						if ($row['COD_EMPRESA'] != $empresa) {
					    	echo '<option value="'.$row['COD_EMPRESA'].'">';
					    }
					    else {
					    	echo '<option value="'.$row['COD_EMPRESA'].'" selected>';
					    }
					    echo $row['EMPRESA'];
					    echo '</option>';
					}
					sqlsrv_free_stmt( $query);
					sqlsrv_close( $conn);
				echo '</select>';
				echo '</p>';                	
			?>
			</div>
			<div id="campo_left">
			<p><b>TÉCNICO EJECUCÍON</b>: <!--<input type="text" id="tecnico" <?php //echo $lectura; ?> size ="20" name="tectnico" value=""/></p>-->
			<?php
				echo '<select name="tecnico" id="tecnico" '.$deshabilitado.' >';
					echo '<option value="0"></option>';
					$conn=conectar_bd();
					$tsql="SELECT COD_TECNICO,UPPER(RTRIM(NOMBRE)) AS TECNICO FROM tbTecnicos";
					//Obtiene el resultado
					$query = sqlsrv_query( $conn, $tsql); 
					while($row = sqlsrv_fetch_array($query)){
						if ($row['COD_TECNICO'] != $tecnico) {
					    	echo '<option value="'.$row['COD_TECNICO'].'">';
					    }
					    else {
					    	echo '<option value="'.$row['COD_TECNICO'].'" selected>';
					    }
					    echo $row['TECNICO'];
					    echo '</option>';
					}
					sqlsrv_free_stmt( $query);
					sqlsrv_close( $conn);
				echo '</select>';
				echo '</p>';                	
			?>
			</div>
			<div id="campo_left">
			<p><b>TELÉFONO TÉCNICO</b>: <input type="text" id="tlf_tec" <?php echo $lectura; ?> size ="13" name="tlf_tec" value="<?php echo $tlf_tec; ?>"/></p>
			</div>
			<div id="campo_right">
			<p><b>FECHA PROPUESTA INICIO</b>: <input type="text" id="fechaini" <?php echo $lectura; ?> name="fechaini" value="<?php echo $pro_fechaini; ?>"/>
			<input type="time" name="pro_hora_ini" id="pro_hora_ini" <?php echo $lectura; ?> value="<?php echo $pro_horaini; ?>" max="24:00:00" min="00:00:00" step="1"></p>
			</div>
			<div id="campo_right">
			<p><b>FECHA/HORA PROPUESTA FIN</b>: <input type="text" id="fechafin" <?php echo $lectura; ?> name="fechafin" value="<?php echo $pro_fechafin; ?>"/>
			<input type="time" name="pro_hora_fin" id="pro_hora_fin" <?php echo $lectura; ?> value="<?php echo $pro_horafin; ?>" max="24:00:00" min="00:00:00" step="1"></p>
			</div>
		</div>
		<div id="apartado">
		<h2><b>PROYECTO</b></h2>
		</div>
		<div id="campo_left">
		<p><textarea <?php if ($ult_est === 'Registrado' || $ult_est === 'Pendiente Info') { } else {echo $lectura; } ?> name="proyecto" cols=100 rows=10 id="proyecto"><?php echo $proyecto; ?></textarea></p>
		</div>
		<div id="apartado">
		<h2><b>DESCRIPCIÓN DEL TRABAJO Y LISTADO DE ELEMENTOS Y FIBRAS SOBRE LAS QUE ACTUAR</b></h2>
		</div>
		<div id="campo_left">
		<p><textarea <?php if ($ult_est === 'Registrado' || $ult_est === 'Pendiente Info') { } else { echo $lectura; } ?> name="descripcion" cols=100 rows=15 id="descripcion"><?php echo $descripcion; ?></textarea></p>
		</div>
		<div id="apartado">
		<h2><b>CUESTIONARIO</b></h2>
		</div>
		<div id="apartado">
			<div id="campo_left">
			<p><b>UBICACIÓN DE LA CÁMARA FRONTERA</b>: <!--<input type="text" id="encuesta1" <?php //echo $lectura; ?> size ="10" name="encuesta1" value=""/></p>-->
			<?php
				echo '<select name="encuesta1" id="encuesta1" '.$deshabilitado.' >';
					echo '<option value="0">--</option>';
					$conn=conectar_bd();
					$tsql="SELECT COD_UBICACION,UPPER(RTRIM(DESCRIPCION)) AS UBICA FROM tbUbicaciones";
					//Obtiene el resultado
					$query = sqlsrv_query( $conn, $tsql); 
					while($row = sqlsrv_fetch_array($query)){
						if ($row['COD_UBICACION'] != $ubicacion) {
					    	echo '<option value="'.$row['COD_UBICACION'].'">';
					    }
					    else {
					    	echo '<option value="'.$row['COD_UBICACION'].'" selected>';
					    }
					    echo $row['UBICA'];
					    echo '</option>';
					}
					sqlsrv_free_stmt( $query);
					sqlsrv_close( $conn);
				echo '</select>';
				echo '</p>';                	
			?>
			</div>
			<div id="campo_left">
			<p><b>¿SE REQUIERE PERMISO DE ACCESO A LA CÁMARA?</b>: <!--<input type="text" id="encuesta2" <?php //echo $lectura; ?> size ="2" name="encuesta2" value=""/></p>-->
			<?php
				echo '<select name="encuesta2" id="encuesta2" '.$deshabilitado.' >';
				if (strtoupper(rtrim($permiso)) == 1) {
					echo '<option value="1" selected>SI</option>';
					echo '<option value="0">NO</option>';
				}
				if (strtoupper(rtrim($permiso)) == 0){
					echo '<option value="0" selected>NO</option>';
					echo '<option value="1">SI</option>';
				}
				echo '</select>';
			?>
			</div>
			<div id="campo_left">
			<p><b>¿SE DISPONE DE PERMISO CONCEDIDO?</b>: <!--<input type="text" id="encuesta3" <?php //echo $lectura; ?> size ="2" name="encuesta3" value=""/></p>-->
			<?php
				echo '<select name="encuesta3" id="encuesta3" '.$deshabilitado.' >';
				if (strtoupper(rtrim($permisocon)) == 1) {
					echo '<option value="1" selected>SI</option>';
					echo '<option value="0">NO</option>';
				}
				if (strtoupper(rtrim($permisocon)) == 0){
					echo '<option value="0" selected>NO</option>';
					echo '<option value="1">SI</option>';
				}
				echo '</select>';
			?>
			</div>
			<div id="campo_left">
			<p><b>SE HA REALIZADO PLANTEO PREVIO DEL CAMBIO</b>: <!--<input type="text" id="encuesta4" <?php //echo $lectura; ?> size ="2" name="encuesta4" value=""/></p>-->
			<?php
				echo '<select name="encuesta4" id="encuesta4" '.$deshabilitado.' >';
				if (strtoupper(rtrim($replanteo)) == 1) {
					echo '<option value="1" selected>SI</option>';
					echo '<option value="0">NO</option>';
				}
				if (strtoupper(rtrim($replanteo)) == 0){
					echo '<option value="0" selected>NO</option>';
					echo '<option value="1">SI</option>';
				}
				echo '</select>';
			?>
			</div>
			<div id="campo_left">
			<p><b>¿ESTÁ LA CÁMARA EN CONDICIONES PARA TRABAJAR EN ELLA?</b>: <!--<input type="text" id="encuesta5" <?php //echo $lectura; ?> size ="2" name="encuesta5" value=""/></p>-->
			<?php
				echo '<select name="encuesta5" id="encuesta5" '.$deshabilitado.' >';
				if (strtoupper(rtrim($condiciones)) == 1) {
					echo '<option value="1" selected>SI</option>';
					echo '<option value="0">NO</option>';
				}
				if (strtoupper(rtrim($condiciones)) == 0){
					echo '<option value="0" selected>NO</option>';
					echo '<option value="1">SI</option>';
				}
				echo '</select>';
			?>
			</div>
		</div>
		<?php if ($observaciones != ''){ ?>
		<div id="apartado">
		<h2><b>OBSERVACIONES</b></h2>
		</div>
		<div id="campo_left">
		<p><textarea <?php echo $lectura; ?> name="observaciones" cols=100 rows=15 id="observaciones"><?php echo $observaciones; ?></textarea></p>
		</div>
		<?php } ?>
		<?php if (!empty($apro_fechaini)){ ?>
		<div id="apartado">
		<h2><b>CAB</b></h2>
		</div>
		<div id="apartado">
			<div id="campo_left">
			<p><b>FECHA/HORA ACORDADA INICIO</b>: <input type="text" id="fechaini2" value="<?php echo $apro_fechaini; ?>" name="fechaini2" readOnly/><input type="time" name="apro_hora_ini" id="apro_hora_ini" <?php echo $lectura; ?> value="<?php echo $apro_horaini; ?>" readOnly required max="24:00:00" min="00:00:00" step="1"></p>
			</div>
			<div id="campo_left">
			<p><b>FECHA/HORA ACORDADA FIN</b>: <input type="text" id="fechafin2" value="<?php echo $apro_fechafin; ?>" name="fechafin2" readOnly/><input type="time" name="apro_hora_fin" id="apro_hora_fin" <?php echo $lectura; ?> value="<?php echo $apro_horafin; ?>" readOnly required max="24:00:00" min="00:00:00" step="1"></p>
			</div>
		</div>
		<?php } ?>

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

		<?php
			$conexion = conectar_bd();
			$ruta_ficheros = '../docs/tps/'.$ident;
			$tsql_ficheros = "SELECT ID_FICHERO,NOMBRE FROM tbDOC_TPS WHERE COD_TRABAJO =".$solicitud;
			$query_ficheros = sqlsrv_query($conexion,$tsql_ficheros) or die ("Error en la consulta de ficheros");
		?>	
			<div id="apartado">
				<h2><b>FICHEROS ADJUNTOS</b></h2>
				<?php
				while ($files = sqlsrv_fetch_array($query_ficheros)) {
					echo '<div id="campo_left">';
						echo '<a onclick="return validarBorrar();" href="../functions/process_solicitud.php?accion=eliminar_adjunto&id_file='.$files['ID_FICHERO'].'&modo='.$mode.'&ruta='.$ruta_ficheros.'&cod_trabajo_file='.$solicitud.'&name_file='.$files['NOMBRE'].'" target="_self">
							  <p style="vertical-align:center;"><img title="Eliminar" style="padding-right:5px;" src="../images/mini_ico/x.png" width="10" height="10" /></a>
							  <a href="'.$ruta_ficheros.'/'.$files['NOMBRE'].'" target="_self">
							  		'.$files['NOMBRE'].'
								  	<img style="padding-left:10px;" title="Descargar" src="../images/mini_ico/download.png" width="16" height="16" />
								  </p>
							  </a>';
					echo '</div>';
				}
				sqlsrv_free_stmt($query_ficheros);
				?>
			</div>
		<?php
			if ($_SESSION['perfil'] != 6) {
		?>
			<div id="apartado">
				<h2><b>ADJUNTAR FICHERO</b></h2>
				<div id="campo_left">
				<form action="../functions/upload.php" class="dropzone">
					<input type="hidden" name="solicitud_doc" id="solicitud_doc" value="<?php echo $solicitud; ?>" />
					<input type="hidden" name="identificador_doc" id="identificador_doc" value="<?php echo $ident; ?>" />
				</form>
				</div>
			</div>
		<?php
			}
		?>
	</div>
<?php
	sqlsrv_free_stmt( $stmt);
	sqlsrv_close( $conn);
?>
<script type="text/javascript">
	function validarBorrar(){
		if (confirm('¿Esta seguro que desea eliminar el adjunto seleccionado?')){
			return true;
		}
		else {
			return false;
		}
	}
</script>
</body>
</html>
<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
	<title>Trabajo Solicitado SSR</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	
	<!-- stylesheets -->
  	<link rel="stylesheet" href="../css/style.css" type="text/css" media="screen" />
  	<script type="text/javascript" src="../js/validaciones.js"></script>
  	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
  	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

  	<script>
	  $(function() {
	  	$.datepicker.setDefaults($.datepicker.regional["es"]);
	    $( "input#apro_fechaini, input#apro_fechafin, input#f_apertura, input#ejec_ini, input#ejec_fin" ).datepicker({
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
		   ISNULL(RTRIM(tbUsuarios.DNI),'---') AS DNI_UC,
		   ISNULL(RTRIM(tbGrupos.DESCRIPCION),'') AS GRUPO,
		   ISNULL(RTRIM(tbResponsables.NOMBRE_COMPLETO),'') AS RESPONSABLE,
		   ISNULL(RTRIM(tbTipos_Actuacion.COD_TIPO_ACTUACION),'') AS TIPO_ACT,
		   ISNULL(RTRIM(tbProvincias.DESCRIPCION),'') AS PROVINCIA,
		   ISNULL(RTRIM(tbEmpresas.DESCRIPCION),'') AS EMPRESA,
		   RTRIM(CONVERT(CHAR,tbTrabajos_Solicitados.FX_PROPUESTA_INICIO,103)) AS PRO_FECHAINI,
		   CONVERT(CHAR,tbTrabajos_Solicitados.FX_PROPUESTA_INICIO,108) AS PRO_HORAINI,
		   RTRIM(CONVERT(CHAR,tbTrabajos_Solicitados.FX_PROPUESTA_FIN,103)) AS PRO_FECHAFIN,
		   CONVERT(CHAR,tbTrabajos_Solicitados.FX_PROPUESTA_FIN,108) AS PRO_HORAFIN,
		   ISNULL(RTRIM(tbTrabajos_Solicitados.IDENTIFICADOR),'') AS IDENT,
		   ISNULL(RTRIM(tbResponsables.TELEFONO),'') AS TLF_RESP,
		   ISNULL(RTRIM(tbCentrales.DESCRIPCION),'') AS CENTRAL,
		   ISNULL(RTRIM(tbTecnicos.NOMBRE),'') AS TECNICO,
		   ISNULL(RTRIM(tbTecnicos.TELEFONO),'') AS TLF_TEC,
		   ISNULL(RTRIM(tbTrabajos_Solicitados.CAMARA_FRONTERA),'') AS CAMARA,
		   ISNULL(RTRIM(tbTrabajos_Solicitados.PROYECTO),'') AS PROYECTO,
		   ISNULL(RTRIM(tbTrabajos_Solicitados.DESCRIPCION),'') AS DESCRIPCION,
		   ISNULL(RTRIM(tbTrabajos_Revisados.COMENTARIOS),'') AS OBSERVACIONES,
		   --ISNULL(RTRIM(CONVERT(CHAR,tbTrabajos_Revisados.FX_APROBADA_INICIO,112)),'') AS APRO_FECHAINI,
		   --ISNULL(RTRIM(CONVERT(CHAR,tbTrabajos_Revisados.FX_APROBADA_FIN,112)),'') AS APRO_FECHAFIN,
		   ISNULL(RTRIM(tbTrabajos_Revisados.REMEDY),'') AS REMEDY,
		   ISNULL(RTRIM(tbUsuarios.NOMBRE_COMPLETO),'') AS USU_SSR,
		   ISNULL(RTRIM(tbUbicaciones.DESCRIPCION),'') AS UBICACION,
		   ISNULL(RTRIM(tbTrabajos_Solicitados.REQUIERE_PERMISO_AC),'--') AS PERMISO,
		   ISNULL(RTRIM(tbTrabajos_Solicitados.PERMISO_CONCEDIDO),'--') AS PERMISOCON,
		   ISNULL(RTRIM(tbTrabajos_Solicitados.REPLANTEO_PREVIO),'--') AS REPLANTEO,
		   ISNULL(RTRIM(tbTrabajos_Solicitados.CAMARA_OK),'--') AS CONDICIONES
		FROM tbTrabajos_Solicitados 
		LEFT JOIN tbTipos_Actuacion ON tbTipos_Actuacion.COD_TIPO_ACTUACION = tbTrabajos_Solicitados.COD_TIPO_ACTUACION 
		LEFT JOIN tbResponsables ON tbTrabajos_Solicitados.COD_RESPONSABLE = tbResponsables.COD_RESPONSABLE 
		LEFT JOIN tbGrupos ON tbTrabajos_Solicitados.COD_GRUPO = tbGrupos.COD_GRUPO 
		LEFT JOIN tbCentrales ON tbTrabajos_Solicitados.COD_CENTRAL = tbCentrales.COD_CENTRAL 
		LEFT JOIN tbProvincias ON tbCentrales.COD_PROVINCIA = tbProvincias.COD_PROVINCIA 
		LEFT JOIN tbEmpresas ON tbTrabajos_Solicitados.COD_EMPRESA = tbEmpresas.COD_EMPRESA
		LEFT JOIN tbTecnicos ON tbTrabajos_Solicitados.COD_TECNICO = tbTecnicos.COD_TECNICO
		LEFT JOIN tbTrabajos_Revisados ON tbTrabajos_Revisados.COD_TRABAJO = tbTrabajos_Solicitados.COD_TRABAJO 
		LEFT JOIN tbUsuarios ON tbTrabajos_Solicitados.COD_USUARIO_CARGA = tbUsuarios.COD_USUARIO
		LEFT JOIN tbUbicaciones ON tbTrabajos_Solicitados.COD_UBICACION = tbUbicaciones.COD_UBICACION
		WHERE tbTrabajos_Solicitados.COD_TRABAJO = ".$_GET['jobcode']." ";
		$stmt = sqlsrv_query( $conn, $tsql);
		if( $stmt === false ){
			die ("<b>Error al ejecutar consulta</b><br>".$tsql);
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
			$tlf_resp = $row['TLF_RESP'];
			$central = $row['CENTRAL'];
			$tecnico = $row['TECNICO'];
			$tlf_tec = $row['TLF_TEC'];
			$camara = $row['CAMARA'];
			$proyecto = $row['PROYECTO'];
			$descripcion = $row['DESCRIPCION'];
			$usu_intro = $row['USU_SSR'];
			$ubicacion = $row['UBICACION'];
			$permiso = $row['PERMISO'];
			$permisocon = $row['PERMISOCON'];
			$replanteo = $row['REPLANTEO'];
			$condiciones = $row['CONDICIONES'];
			$dni_uc = $row['DNI_UC'];
			$ident = $row['IDENT'];
		}

		$ssr_tsql = "SELECT tbTrabajos_Revisados.COD_TRABAJO as codigo,
						   tbTrabajos_Revisados.COD_ACTIVIDAD as actividad,
						   tbTrabajos_Revisados.DESCRIPCION_ACTIVIDAD as descrip_act,
						   tbTrabajos_Revisados.COD_TIPO_CAMBIO as tipo_cambio,
						   tbTrabajos_Revisados.N_CLIENTES_RIESGO as nc_riesgo,
						   tbTrabajos_Revisados.N_CLIENTES_AFECTADOS as nc_afectados,
						   tbTrabajos_Revisados.N_CLIENTES_CENTREX as nc_centrex,
						   tbTrabajos_Solicitados.ESTADO_TP as estado,
						   tbTrabajos_Revisados.COD_MOTIVO_RECHAZO as m_rechazo,
						   tbTrabajos_Revisados.COD_MOTIVO_CANCELADO as m_cancelado,
						   tbTrabajos_Revisados.RIESGO as riesgo,

				           -- maiteben_20160705
						   ISNULL(tbTrabajos_Revisados.AF_CONECTIVIDAD,'') AS af_conectividad,
						   ISNULL(tbTrabajos_Revisados.AF_FTTN,'') AS af_fttn,
						   ISNULL(tbTrabajos_Revisados.AF_OTROS,'') AS af_otros,
						   -- maiteben_20160705_fin

						   tbTrabajos_Revisados.COMENTARIOS as observaciones,
						   tbTrabajos_Revisados.REMEDY as remedy,
						   tbTrabajos_Revisados.FX_APROBADA_INICIO as apro_ini,
						   tbTrabajos_Revisados.FX_APROBADA_FIN as apro_fin,
						   tbTrabajos_Revisados.FX_APERTURA as f_apertura,
						   tbTrabajos_Revisados.FX_EJECUCION_INICIO as ejec_ini,
						   tbTrabajos_Revisados.FX_EJECUCION_FIN as ejec_fin,
						   tbTrabajos_Revisados.INICIO_RETRASADO as ini_ret,
						   tbTrabajos_Revisados.AFECTACIONES_DERIVADAS as afect_derv,
						   tbTrabajos_Revisados.N_CLIENTES_CAIDOS as nc_caidos,
						   tbTrabajos_Revisados.COMUNICADO as comunicado,
						   tbTrabajos_Revisados.COD_USUARIO_SSR as cod_ssr
					 FROM tbTrabajos_Revisados
					 LEFT JOIN tbTrabajos_Solicitados ON tbTrabajos_Revisados.COD_TRABAJO = tbTrabajos_Solicitados.COD_TRABAJO
					 WHERE tbTrabajos_Revisados.COD_TRABAJO = ".$_GET['jobcode']." ";

		$conn = conectar_bd();
		$stmt_ssr = sqlsrv_query( $conn, $ssr_tsql);
		if( $stmt_ssr === false ){
			die ("<b>Error al ejecutar consulta datos SSR</b><br>".$ssr_tsql);
		}

		while($fila = sqlsrv_fetch_array($stmt_ssr)) {

			$codigo = $fila['codigo'];
			$actividad = $fila['actividad'];
			$descrip_act = $fila['descrip_act'];
			$tipo_cambio = $fila['tipo_cambio'];
			$nc_riesgo = $fila['nc_riesgo'];
			$nc_afectados = $fila['nc_afectados'];
			$nc_centrex = $fila['nc_centrex'];
			$estado = $fila['estado'];
			$m_rechazo = $fila['m_rechazo'];
			$m_cancelado = $fila['m_cancelado'];
			$riesgo = $fila['riesgo'];
			$observaciones = $fila['observaciones'];
			$remedy = $fila['remedy'];
			$apro_fechaini = $fila['apro_fechaini'];
			$apro_fin = $fila['apro_fin'];
			$f_apertura = $fila['f_apertura'];
			$ejec_ini = $fila['ejec_ini'];
			$ejec_fin = $fila['ejec_fin'];
			$ini_ret = $fila['ini_ret'];
			$afect_derv = $fila['afect_derv'];
			$nc_caidos = $fila['nc_caidos'];
			$comunicado = $fila['comunicado'];
			$cod_ssr = $fila['cod_ssr'];

			// maiteben_20160705
			$af_conectividad = $fila['af_conectividad'];
			$af_fttn = $fila['af_fttn'];
			$af_otros = $fila['af_otros'];
			// maiteben_20160705_fin
		}
	}
	if (isset($_GET['mode'])) {
		$mode = $_GET['mode'];
		$accion = 'actualizar_ssr';
	}
	else {
		$mode = 2;
		$accion = 'actualizar_ssr';
	}
	if ($mode == 1){
		$lectura = 'readOnly';
		$deshabilitado = 'disabled';
	}
	if ($mode == 2){
		$lectura = '';
		$deshabilitado = '';
	}
?>
	<div id="content_result">
		<!-- MUESTRO LOS DATOS DE LA SOLICITUD -->
		<div id="apartado_info">
			<p><b>DATOS ADMINISTRATIVOS DEL CAMBIO  ( <?php echo $solicitud; ?> )</b></p>
			<div id="campo_info">
				<p><b>IDENTIFICADOR</b>: <?php echo $ident; ?></p>
				<p><b>USUARIO REGIONAL</b>: <?php echo $usu_intro; ?></p>
				<p><b>DNI USUARIO SOLICITA</b>: <?php echo $dni_uc; ?></p>
				<p><b>GRUPO SOLICITANTE</b>: <?php echo $grupo; ?></p>
				<p><b>RESPONSABLE JAZZTEL</b>: <?php echo $responsable; ?></p>
				<p><b>TELÉFONO RESPONSABLE JAZZTEL</b>: <?php echo $tlf_resp; ?></p>
				<p><b>PROVINCIA</b>: <?php echo $provincia; ?></p>
				<p><b>CENTRAL</b>: <?php echo $central; ?></p>
			</div>
			<div id="campo_info">
				<p><b>CÁMARA FRONTERA</b>: <?php echo $camara; ?></p>
				<p><b>EMPRESA QUE REALIZA EL CAMBIO</b>: <?php echo $empresa ?></p>
				<p><b>TÉCNICO EJECUCÍON</b>: <?php echo $tecnico; ?></p>
				<p><b>TELÉFONO TÉCNICO</b>: <?php echo $tlf_tec; ?></p>
				<p><b>FECHA/HORA PROPUESTA INICIO</b>: <?php echo $pro_fechaini; ?> <b>HORA:</b> <?php print $pro_horaini; ?> </p>
				<p><b>FECHA/HORA PROPUESTA FIN</b>: <?php echo $pro_fechafin; ?> <b>HORA:</b> <?php print $pro_horafin; ?></p>
				<p><b>PROYECTO</b> <?php echo $proyecto; ?></p>
			</div>
			<div id="campo_info">
				<p><b>DESCRIPCIÓN DEL TRABAJO Y LISTADO DE ELEMENTOS Y FIBRAS SOBRE LAS QUE ACTUAR</b></p>
				<p><?php echo $descripcion; ?></p>
				<p><b>CUESTIONARIO</b></p>
				<p><b>UBICACIÓN DE LA CÁMARA FRONTERA</b>: <?php echo $ubicacion; ?></p>
			    <p><b>¿SE REQUIERE PERMISO DE ACCESO A LA CÁMARA?</b>: <?php if ($permiso == 1) { echo 'SI'; } else { echo 'NO'; }; ?></p>
				<p><b>¿SE DISPONE DE PERMISO CONCEDIDO?</b>: <?php if ($permisocon ==1) { echo 'SI'; } else { echo 'NO'; } ?></p>
				<p><b>SE HA REALIZADO PLANTEO PREVIO DEL CAMBIO</b>: <?php if ($replanteo ==1) { echo 'SI'; } else { echo 'NO'; } ?></p>
				<p><b>¿ESTÁ LA CÁMARA EN CONDICIONES PARA TRABAJAR EN ELLA?</b>: <?php if ($condiciones ==1) { echo 'SI'; } else { echo 'NO'; } ?></p>
			</div>
		</div>
		<!-- FORMULARIO A RELLENAR POR EL SSR -->
		<div id="apartado">
			<form name="revision_ssr" onsubmit="return validarEstudio()" method="post" enctype="multipart/form-data" action="../functions/process_solicitud.php?accion=<?php echo $accion; ?>">
				<input type="hidden" name="usuario" id="usuario" value="<?php echo $_SESSION['privi']; ?>" />
				<input type="hidden" name="perfil" id="perfil" value="<?php echo $_SESSION['perfil']; ?>" />
				<input type="hidden" name="solicitud" id="solicitud" value="<?php echo $solicitud; ?>" />
					<div id="campo_right">
						<p><b>TIPO ACTUACIÓN</b>
						<?php
						echo '<select id="tipo_act" name="tipo_act" '.$deshabilitado.'>';
							echo '<option value="0"></option>';
								$conn=conectar_bd();
								$tsql="SELECT COD_TIPO_ACTUACION,UPPER(RTRIM(DESCRIPCION)) AS TIPO_ACT FROM tbTipos_Actuacion";
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
								sqlsrv_free_stmt( $stmt);
								sqlsrv_close( $conn);
							?>
						</select>            
					</div>
					<div id="campo_left">
						<p><b>ACTIVIDAD</b>:
						<?php
							echo '<select name="actividad" id="actividad" '.$deshabilitado.' >';
								echo '<option value="0"></option>';
								$conn=conectar_bd();
								$tsql="SELECT COD_ACTIVIDAD,UPPER(RTRIM(DESCRIPCION)) AS DESCRIPCION FROM tbActividades";
								//Obtiene el resultado
								$query = sqlsrv_query( $conn, $tsql); 
								while($row = sqlsrv_fetch_array($query)){
									if ($row['COD_ACTIVIDAD'] != $actividad) {
								    	echo '<option value="'.$row['COD_ACTIVIDAD'].'">';
								    }
								    else {
								    	echo '<option value="'.$row['COD_ACTIVIDAD'].'" selected>';
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
					<div id="campo_right">
						<p><b>DESCRIPCION ACTIVIDAD</b>: <input type="text" <?php echo $lectura; ?> size ="20" id="descrip_act" name="descrip_act" value="<?php echo $descrip_act; ?>"/></p>
					</div>
					<div id="campo_left">
						<p><b>TIPO CAMBIO</b>:
						<?php
							echo '<select name="tipo_cambio" id="tipo_cambio" '.$deshabilitado.' >';
								echo '<option value="0"></option>';
								$conn=conectar_bd();
								$tsql="SELECT COD_TIPO_CAMBIO,UPPER(RTRIM(DESCRIPCION)) AS DESCRIPCION FROM tbTipos_Cambio";
								//Obtiene el resultado
								$query = sqlsrv_query( $conn, $tsql); 
								while($row = sqlsrv_fetch_array($query)){
									if ($row['COD_TIPO_CAMBIO'] != $tipo_cambio) {
								    	echo '<option value="'.$row['COD_TIPO_CAMBIO'].'">';
								    }
								    else {
								    	echo '<option value="'.$row['COD_TIPO_CAMBIO'].'" selected>';
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
					<div id="campo_right">
						<p><b>Nº CLIENTES RIESGO</b>: <input type="text" <?php echo $lectura; ?> size ="2" id="nc_riesgo" name="nc_riesgo" value="<?php echo $nc_riesgo; ?>"/></p>
					</div>
					<div id="campo_left">
						<p><b>Nº CLIENTES AFECTADOS</b>: <input type="text" <?php echo $lectura; ?> size ="2" id="nc_afectados" name="nc_afectados" value="<?php echo $nc_afectados; ?>"/></p>
					</div>
					<div id="campo_left">
						<p><b>Nº CLIENTES CENTREX</b>: <input type="text" <?php echo $lectura; ?> size ="2" id="nc_centrex" name="nc_centrex" value="<?php echo $nc_centrex; ?>"/></p>
					</div>

					<!-- maiteben_20160705 -->
					<div id="campo_right">
						<p><b>AF CONECTIVIDAD</b>:					

						<?php
							echo '<select name="af_conectividad" id="af_conectividad" '.$deshabilitado.' >';
								echo '<option'; if ($af_conectividad ==  0) { echo ' selected';} echo ' value="0"></option>';
								echo '<option'; if ($af_conectividad ==  1) { echo ' selected';} echo ' value="1">SI</option>';
								echo '<option'; if ($af_conectividad ==  2) { echo ' selected';} echo ' value="2">RIESGO</option>';
								echo '<option'; if ($af_conectividad ==  3) { echo ' selected';} echo ' value="3">NO</option>';								
							echo '</select>';
							echo '</p>';                	
						?>
					</div>
					<div id="campo_left">
						<p><b>AF FTTN</b>:
						<?php
							echo '<select name="af_fttn" id="af_fttn" '.$deshabilitado.' >';
								echo '<option'; if ($af_fttn ==  0) { echo ' selected';} echo ' value="0"></option>';
								echo '<option'; if ($af_fttn ==  1) { echo ' selected';} echo ' value="1">SI</option>';
								echo '<option'; if ($af_fttn ==  2) { echo ' selected';} echo ' value="2">RIESGO</option>';
								echo '<option'; if ($af_fttn ==  3) { echo ' selected';} echo ' value="3">NO</option>';										
							echo '</select>';
							echo '</p>';                	
						?>
					</div>
					<div id="campo_left">
						<p><b>AF OTROS SERVICIOS</b>:
						<?php
							echo '<select name="af_otros" id="af_otros" '.$deshabilitado.' >';
								echo '<option'; if ($af_otros ==  0) { echo ' selected';} echo ' value="0"></option>';
								echo '<option'; if ($af_otros ==  1) { echo ' selected';} echo ' value="1">SI</option>';
								echo '<option'; if ($af_otros ==  2) { echo ' selected';} echo ' value="2">RIESGO</option>';
								echo '<option'; if ($af_otros ==  3) { echo ' selected';} echo ' value="3">NO</option>';															
							echo '</select>';
							echo '</p>';                	
						?>
					</div>
					<!-- maiteben_20160705_fin -->

					<div id="campo_right">
						<p><b>RIESGO</b>: <input type="text" <?php echo $lectura; ?> size ="20" id="riesgo" name="riesgo" value="<?php echo $riesgo; ?>"/></p>
					</div>
					<div id="campo_left">
						<p><b>REMEDY</b>: <input type="text" <?php echo $lectura; ?> size ="20" id="remedy" name="remedy" value="<?php echo $remedy; ?>"/></p>
					</div>
					<div id="campo_right">
						<p><b>OBSERVACIONES</b></p>:
						<p><textarea <?php echo $lectura; ?> name="observaciones" cols=90 rows=15 id="observaciones"><?php echo $observaciones; ?></textarea></p>
					</div>
					<div id="campo_right">
						<p><b>ESTADO</b>:
						<?php
							echo '<select name="estado" id="estado" '.$deshabilitado.' >';
								echo '<option value="0"></option>';
								if ($estado === 'Pendiente Info') {
								    echo '<option value="Pendiente Info" selected>Pendiente Info</option>';
									echo '<option value="Pendiente CAB">Pendiente CAB</option>';
									echo '<option value="Rechazado">Rechazado</option>';
								}
								elseif ($estado === 'Pendiente CAB' ) {
								 	echo '<option value="Pendiente CAB" selected>Pendiente CAB</option>';
								 	echo '<option value="Pendiente Info">Pendiente Info</option>';
								 	echo '<option value="Rechazado">Rechazado</option>';
								}
								elseif ($estado === 'Rechazado' ) {
								 	echo '<option value="Pendiente CAB">Pendiente CAB</option>';
								 	echo '<option value="Pendiente Info">Pendiente Info</option>';
								 	echo '<option value="Rechazado" selected>Rechazado</option>';
								}
								else {
									echo '<option value="Pendiente Info">Pendiente Info</option>';
									echo '<option value="Pendiente CAB">Pendiente CAB</option>';
									echo '<option value="Rechazado">Rechazado</option>';
								} 
								
							echo '</select>';
							echo '</p>';                	
						?>
					</div>
					<div id="campo_left">
						<p><b>ESTADO RECHAZO</b>:
						<?php
							echo '<select name="m_rechazo" id="m_rechazo" '.$deshabilitado.' >';
								echo '<option value="0"></option>';
								$conn=conectar_bd();
								$tsql="SELECT COD_MOTIVO,DESCRIPCION FROM tbMotivos_Estado WHERE ESTADO = 'Rechazado'";
								//Obtiene el resultado
								$query = sqlsrv_query( $conn, $tsql); 
								while($row = sqlsrv_fetch_array($query)){
									if ($row['COD_MOTIVO'] != $m_rechazo) {
								    	echo '<option value="'.$row['COD_MOTIVO'].'">';
								    }
								    else {
								    	echo '<option value="'.$row['COD_MOTIVO'].'" selected>';
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
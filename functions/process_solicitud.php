<?php
	header('Content-Type: text/html; charset=ISO-8859-1');
	include 'funciones.php';
	session_start();
	$usuario_accion = $_POST['usuario'];
	$perfil = $_POST['perfil'];
	$solicitud = $_POST['solicitud']; 
	$grupo_s = vXd($_POST['grupo_s']);
	$responsable = vXd($_POST['responsable']);
	$des_responsable = vXd($_POST['des_responsable']);
	$tlf_resp = vXd($_POST['tlf_resp']);
	$tipo_act = vXd($_POST['tipo_act']);
	$provincia = vXd($_POST['provincia']);
	$central = vXd($_POST['central']);
	$cam_front = vXd($_POST['cam_front']);
	$empresa = vXd($_POST['empresa']);
	if (!empty($_POST['fechaini']))  {
		$fechaini = $_POST['fechaini'].' '.$_POST['pro_hora_ini'];
	}
	if (!empty($_POST['fechafin']))  {
		$fechafin = $_POST['fechafin'].' '.$_POST['pro_hora_fin'];
	}
	$proyecto = vXd($_POST['proyecto']);
	$descripcion = vXd($_POST['descripcion']);
	$encuesta1 = vXd($_POST['encuesta1']);
	$encuesta2 = vXd($_POST['encuesta2']);
	$encuesta3 = vXd($_POST['encuesta3']);
	$encuesta4 = vXd($_POST['encuesta4']);
	$encuesta5 = vXd($_POST['encuesta5']);
	$tecnico = vXd($_POST['tecnico']);
	$tlf_tec = vXd($_POST['tlf_tec']);
	$des_tecnico = vXd($_POST['des_tecnico']);
	$fecha1 = date('Y-m-d');
	$segundos=strtotime($fechaini) - strtotime($fecha1);
	$diferencia_dias=intval($segundos/60/60/24);
	if ($diferencia_dias > 0 && $diferencia_dias <= 3) {
		$prioridad = 1;
	}
	elseif ($diferencia_dias > 3) {
		$prioridad = 2;
	}
	elseif ($diferencia_dias <= 0) {
		$prioridad = 1;
	}
	$estado = 'Registrado';
	$usuario_carga = $_POST['vista'];
	$accion = $_REQUEST['accion'];

	if (empty($usuario_carga)) {
		$usuario_carga = $usuario_accion;
	}

	if ($accion === 'test') {
		//esta acción es de prueba para nuevas implementaciones
		echo 'Llega';
		$conexion = conectar_bd();
		$consulta = "SELECT * FROM tbTrabajos_Solicitados";
		$query_test = sqlsrv_query($conexion,$consulta);
		sqlsrv_free_stmt($query_test);
		sqlsrv_close($conexion);
		echo '<script type="text/javascript">';
			echo "window.opener.document.getElementById('btnfiltrar').click();";
			echo 'window.close();';
		echo '</script>';
	}

	if ($accion === 'insertar') { //PROCEDIMIENTO PARA INSERTAR UNA NUEVA SOLICITUD

		if ($tecnico == '') {
			$new_tecnico = "INSERT INTO tbTecnicos (NOMBRE,TELEFONO) VALUES ('".$des_tecnico."', '".$tlf_tec."');SELECT SCOPE_IDENTITY() AS NEWID;";
			$conn = conectar_bd();
			$query = sqlsrv_query($conn,$new_tecnico) or die ("Fallo al intentar insertar nuevo técnico ".$new_tecnico);
			sqlsrv_next_result($query);
			sqlsrv_fetch($query);
			$tecnico=sqlsrv_get_field($query, 0);
			sqlsrv_free_stmt($query);
			sqlsrv_close($conn);			
		}
		if ($responsable == '') {
			$new_respon = "INSERT INTO tbResponsables (NOMBRE_COMPLETO,TELEFONO) VALUES ('".$des_responsable."', '".$tlf_resp."');SELECT SCOPE_IDENTITY() AS NEWID;";
			$conn = conectar_bd();
			$query = sqlsrv_query($conn,$new_respon) or die ("Fallo al intentar insertar nuevo técnico ".$new_respon);
			sqlsrv_next_result($query);
			sqlsrv_fetch($query);
			$responsable=sqlsrv_get_field($query, 0);
			sqlsrv_free_stmt($query);
			sqlsrv_close($conn);			
		}
		if ($_REQUEST['org'] == 1) {
			$tabla= "INSERT INTO tbTrabajos_Solicitados (IDENTIFICADOR,";
			$campos = ") VALUES ('".getIdent($central)."',";
			$error = "Fallo al intentar insertar la solicitud. <br> Los siguientes campos son obligatorios:";
			$verror = 0;
			if (!empty($responsable)) {
				$tabla .= "COD_RESPONSABLE,";
				$campos .= $responsable.",";
			} else {
				$error = $error . "<br> - Responsable";
				$verror = 1;
			}
			if (!empty($tipo_act)) {
				$tabla .= "COD_TIPO_ACTUACION,";
				$campos .= $tipo_act.",";
			}
			if (!empty($central) || $central <> 0) {
				$tabla .= "COD_CENTRAL,";
				$campos .= $central.",";
			} else {
				$error = $error."<br> - La Central indicada en el registro no existe en el sistema, debe solicitar al personal de SSR el alta en el sistema.";
				$verror = 1;
			}
			if (!empty($cam_front) &&( strlen($cam_front)==8 && (eregi(cr,$cam_front) || eregi(ad,$cam_front) || $cam_front='central'))) {

				$tabla .= "CAMARA_FRONTERA,";
				$campos .= "'".$cam_front."',";
			} else {
				$error = $error."<br> - Error al introducir valor en el campo CR. Este campo solo admite los siguientes valores:<br>CRXXXXXX donde XXXXXX es el numero de la CR frontera.
				<br>ADXXXXXX donde  XXXXXX es el numero de la  CR frontera.
				<br> Central si los trabajos se realizan en central.";
				$verror = 1;
			}
			if (!empty($empresa)) {
				$tabla .= "COD_EMPRESA,";
				$campos .= $empresa.",";
			} else {
				$error = $error."<br> - Empresa";
				$verror = 1;
			}
			if (!empty($tecnico)) {
				$tabla .= "COD_TECNICO,";
				$campos .= $tecnico.",";
			} else {
				$error = $error."<br> - Técnico";
				$verror = 1;
			}
			if ((!empty($fechaini) && !empty($fechafin)) && ($fechaini <= $fechafin)) {
				$tabla .= "FX_PROPUESTA_INICIO,FX_PROPUESTA_FIN,";
				$campos .= "'".date('Y-m-d H:i:s',strtotime(str_replace('/', '-', $fechaini)))."','".date('Y-m-d H:i:s',strtotime(str_replace('/', '-', $fechafin)))."',";
			}else {
				$error = $error."<br> - Fecha inicio y fin propuesta, el formato de fecha debe ser dd/mm/aaaa hh:mm";
				$verror = 1;
			}
			if ($prioridad > 0) {
				$tabla .= "PRIORIDAD,";
				$campos .= $prioridad.",";
			}else {
				$error = $error."<br> - Fecha inicio y fin propuesta (calculo prioridad)";
				$verror = 1;
			}
			if (!empty($proyecto)) {
				$tabla .= "PROYECTO,";
				$campos .= "'".$proyecto."',";
			}
			if (!empty($descripcion)) {
				$tabla .= "DESCRIPCION,";
				$campos .= "SUBSTRING('".$descripcion."',1,4000),";
			}
			if (!empty($encuesta1)) {
				$tabla .= "COD_UBICACION,";
				$campos .= $encuesta1.",";
			}else {
				$error = $error."<br> - Ubicación";
				$verror = 1;
			}
			if (!empty($estado)) {
				$tabla .= "ESTADO_TP,";
				$campos .= "'".$estado."',";
			}
			if (!empty($grupo_s)) {
				$tabla .= "COD_GRUPO,";
				$campos .= $grupo_s.",";
			}else {
				$error = $error."<br> - Grupo solicitante";
				$verror = 1;
			}
			if ($verror == 0) {
			$insert .= $tabla.'FX_REGISTRO,COD_USUARIO_CARGA'. $campos . "getdate(),".$usuario_carga.");SELECT SCOPE_IDENTITY() AS NEWID;";
			$conn=conectar_bd();
			$query = sqlsrv_query( $conn, $insert) or die ("Fallo al intentar insertar la solicitud ".$insert);
			sqlsrv_next_result($query);
			sqlsrv_fetch($query);
			$newid=sqlsrv_get_field($query, 0);
			sqlsrv_free_stmt( $query);
			sqlsrv_close( $conn);
			}
			else {
				die ("Para registrar una solicitud debe completar los siguientes campos del fichero". $error . "<br><br><br><a href='http://ftth-dst.jazztel.com/trabajos_programados/index.php?view=1' targe=_self>INTENTAR DE NUEVO</a>");
			}
			header('Location: http://ftth-dst.jazztel.com/trabajos_programados/index.php?view=2');
		}
		if ($_REQUEST['org'] == 2) {
			$tabla= "INSERT INTO tbTrabajos_Solicitados (IDENTIFICADOR,";
			$campos = ") VALUES ('".getIdent($central)."',";
			$error = "Fallo al intentar insertar la solicitud. <br> Los siguientes campos son obligatorios:";
			if (!empty($responsable)) {
				$tabla .= "COD_RESPONSABLE,";
				$campos .= $responsable.",";
			} else {
				$error .= "<br> - Responsable";
				$verror = 1;
			}
			if (!empty($tipo_act)) {
				$tabla .= "COD_TIPO_ACTUACION,";
				$campos .= $tipo_act.",";
			} else {
				$error .= "<br> - Tipo Actuación";
				$verror = 1;
			}
			if (!empty($central)) {
				$tabla .= "COD_CENTRAL,";
				$campos .= $central.",";
			} else {
				$error .= "<br> - Central";
				$verror = 1;
			}
		if (!empty($cam_front) &&( strlen($cam_front)==8 && (eregi(cr,$cam_front) || eregi(ad,$cam_front) || $cam_front='central'))) {
				
				$tabla .= "CAMARA_FRONTERA,";
				$campos .= $cam_front.",";
			}else {
			$error = $error."<br> - Error al introducir valor en el campo CR. Este campo solo admite los siguientes valores:<br>CRXXXXXX donde XXXXXX es el numero de la CR frontera.
				<br>ADXXXXXX donde  XXXXXX es el numero de la  CR frontera.
				<br> Central si los trabajos se realizan en central.";
				$verror = 1;
			}

			if (!empty($empresa)) {
				$tabla .= "COD_EMPRESA,";
				$campos .= $empresa.",";
			} else {
				$error .= "<br> - Empresa";
				$verror = 1;
			}
			if (!empty($tecnico)) {
				$tabla .= "COD_TECNICO,";
				$campos .= $tecnico.",";
			} else {
				$error .= "<br> - Técnico";
				$verror = 1;
			}
			if ((!empty($fechaini) && !empty($fechafin)) && ($fechaini <= $fechafin)) {
				$tabla .= "FX_PROPUESTA_INICIO,FX_PROPUESTA_FIN,";
				$campos .= "'".date('Y-m-d H:i:s',strtotime(str_replace('/', '-', $fechaini)))."','".date('Y-m-d H:i:s',strtotime(str_replace('/', '-', $fechafin)))."',";
			}else {
				$error .= "<br> - Fecha inicio y fin propuesta";
				$verror = 1;
			}
			if (!empty($prioridad > 0)) {
				$tabla .= "PRIORIDAD,";
				$campos .= $prioridad.",";
			}
			if (!empty($proyecto)) {
				$tabla .= "PROYECTO,";
				$campos .= "'".$proyecto."',";
			}
			if (!empty($descripcion)) {
				$tabla .= "DESCRIPCION,";
				$campos .= "SUBSTRING('".$descripcion."',1,4000),";
			}
			if (!empty($encuesta1)) {
				$tabla .= "COD_UBICACION,";
				$campos .= $encuesta1.",";
			}else {
				$error .= "<br> - Ubicación";
				$verror = 1;
			}
			if (!empty($estado)) {
				$tabla .= "ESTADO_TP,";
				$campos .= "'".$estado."',";
			}
			if (!empty($grupo_s)) {
				$tabla .= "COD_GRUPO,";
				$campos .= $grupo_s.",";
			}else {
				$error .= "<br> - Grupo solicitante";
				$verror = 1;
			}

			if ($verror == 0) {	

			$insert .= $tabla.'FX_REGISTRO,COD_USUARIO_CARGA'.$campos."getdate(),".$usuario_carga.");SELECT SCOPE_IDENTITY() AS NEWID;";
			$conn=conectar_bd();
			$query = sqlsrv_query( $conn, $insert) or die ("Fallo al intentar insertar la solicitud ".$insert);
			sqlsrv_next_result($query);
			sqlsrv_fetch($query);
			$newid=sqlsrv_get_field($query, 0);
			sqlsrv_free_stmt( $query);
			sqlsrv_close( $conn);
			header('Location: http://ftth-dst.jazztel.com/trabajos_programados/forms/fin_proceso.php');
				}

			else {
				echo "Para registrar una solicitud debe completar los siguientes campos del fichero". $error . "<br><br><br><a href='http://ftth-dst.jazztel.com/trabajos_programados/index.php?view=1' targe=_self>INTENTAR DE NUEVO</a>";
			}



		}
	}

	if ($accion === 'actualizar') { //PROCEDIMIENTO PARA ACTUALIZAR UN TRABAJO SOLICITADO
		$conn=conectar_bd();
		$tsql_est = "SELECT RTRIM(ESTADO_TP) AS ESTADO_TP FROM tbTrabajos_Solicitados WHERE COD_TRABAJO = ".$solicitud;
		$query_est = sqlsrv_query($conn,$tsql_est);
		$result_est = sqlsrv_fetch_array($query_est);
		$ult_est = $result_est['ESTADO_TP'];
		if ($ult_est === 'Registrado') {
			$update="UPDATE tbTrabajos_Solicitados 
					 SET COD_RESPONSABLE = ".$responsable.",
					 	 COD_TIPO_ACTUACION = ".$tipo_act.",
					 	 COD_CENTRAL = ".$central.",
					 	 CAMARA_FRONTERA = '".$cam_front."',
					 	 COD_EMPRESA = ".$empresa.", 
					 	 COD_TECNICO = ".$tecnico.",
					 	 FX_PROPUESTA_INICIO = '".date('Y-m-d H:i:s',strtotime(str_replace('/', '-', $fechaini)))."',
					 	 FX_PROPUESTA_FIN = '".date('Y-m-d H:i:s',strtotime(str_replace('/', '-', $fechafin)))."',
					 	 PROYECTO = '".$proyecto."',
					 	 DESCRIPCION = '".$descripcion."',
					 	 COD_UBICACION = ".$encuesta1.",
					 	 REQUIERE_PERMISO_AC = ".$encuesta2.",
					 	 PERMISO_CONCEDIDO = ".$encuesta3.",
					 	 REPLANTEO_PREVIO = ".$encuesta4.",
					 	 CAMARA_OK = ".$encuesta5." 
					 	 WHERE COD_TRABAJO = ".$solicitud;
			$insert="INSERT INTO tbHistorico_Trabajos (COD_TRABAJO,ESTADO_TP,FX_OPERACION,COD_USUARIO,CORREO_ENVIADO) VALUES (".$_REQUEST['solicitud'].",'Registrado',getdate(),".$usuario_carga.",1)";
		}
		if ($ult_est === 'Pendiente Info') {
			$update="UPDATE tbTrabajos_Solicitados SET ESTADO_TP = 'Asignado', PROYECTO = '".$proyecto."',DESCRIPCION = '".$descripcion."' WHERE COD_TRABAJO = ".$solicitud;
			$insert="INSERT INTO tbHistorico_Trabajos (COD_TRABAJO,ESTADO_TP,FX_OPERACION,COD_USUARIO,CORREO_ENVIADO) VALUES (".$_REQUEST['solicitud'].",'Asignado',getdate(),".$usuario_carga.",1)";
			envioCambio($_REQUEST['solicitud']);
		}
		$query = sqlsrv_query( $conn, $update) or die ("Fallo al intentar actualizar la solicitud <br>".$update."");
		$query1 = sqlsrv_query( $conn, $insert) or die ("Fallo al intentar insertar la solicitud en historico <br>".$insert."");
		sqlsrv_free_stmt( $update);
		sqlsrv_free_stmt( $insert);
		sqlsrv_close( $conn);
		header('Location: http://ftth-dst.jazztel.com/trabajos_programados/forms/fin_proceso.php');
	}
	
	if ($accion === 'cancelar') { //PROCEDIMIENTO PARA CANCELAR, RECHAZAR O ANULAR SOLICITUDES
		$consulta = "SELECT ESTADO_TP FROM tbTrabajos_Solicitados WHERE COD_TRABAJO = ".$_REQUEST['solicitud']."";
		$conn=conectar_bd();
		$result = sqlsrv_query($conn,$consulta);
		$est = sqlsrv_fetch_array($result);
		if ($_SESSION['perfil'] == 3 && ($est['ESTADO_TP'] === 'Registrado' || $est['ESTADO_TP'] === 'Asignado')){
			$sql = "UPDATE tbTrabajos_Solicitados SET ESTADO_TP = 'Anulado' WHERE COD_TRABAJO = ".$_REQUEST['solicitud']."";
			$insert="INSERT INTO tbHistorico_Trabajos VALUES (".$_REQUEST['solicitud'].",'Anulado',getdate(),1,".$_SESSION['privi'].")";
			$query = sqlsrv_query( $conn, $sql) or die ("Fallo al intentar insertar la solicitud");
			$query1 = sqlsrv_query( $conn, $insert) or die ("Fallo al intentar insertar la solicitud en historico".$insert);
			envioCambio($_REQUEST['solicitud']);
		}
		if ($_SESSION['perfil'] == 3 &&  ($est['ESTADO_TP'] === 'Pendiente CAB' || $est['ESTADO_TP'] === 'Aceptado')) {
			$sql = "UPDATE tbTrabajos_Solicitados SET ESTADO_TP = 'Cancelado' WHERE COD_TRABAJO = ".$_REQUEST['solicitud']."";
			$insert="INSERT INTO tbHistorico_Trabajos (COD_TRABAJO,ESTADO_TP,FX_OPERACION,COD_USUARIO,CORREO_ENVIADO) VALUES (".$_REQUEST['solicitud'].",'Cancelado',getdate(),".$_SESSION['privi'].",1)";
			$query = sqlsrv_query( $conn, $sql) or die ("Fallo al intentar insertar la solicitud");
			$query1 = sqlsrv_query( $conn, $insert) or die ("Fallo al intentar insertar la solicitud en historico1 ".$insert);
			envioCambio($_REQUEST['solicitud']);
		}

		if ($_SESSION['perfil'] != 3 && $est['ESTADO_TP'] === 'Pendiente CAB') {
			$sql = "UPDATE tbTrabajos_Solicitados SET ESTADO_TP = 'Rechazado' WHERE COD_TRABAJO = ".$_REQUEST['solicitud']."";
			$insert="INSERT INTO tbHistorico_Trabajos (COD_TRABAJO,ESTADO_TP,FX_OPERACION,COD_USUARIO,CORREO_ENVIADO) VALUES (".$_REQUEST['solicitud'].",'Rechazado',getdate(),".$_SESSION['privi'].",1)";
			$query = sqlsrv_query( $conn, $sql) or die ("Fallo al intentar insertar la solicitud");
			$query1 = sqlsrv_query( $conn, $insert) or die ("Fallo al intentar insertar la solicitud en historico");
			envioCambio($_REQUEST['solicitud']);
			$usuar = $_SESSION['perfil'];
		}
		if ($_SESSION['perfil'] != 3 && ($est['ESTADO_TP'] === 'Pendiente Info' || $est['ESTADO_TP'] === 'Asignado')) {
			$sql = "UPDATE tbTrabajos_Solicitados SET ESTADO_TP = 'Rechazado' WHERE COD_TRABAJO = ".$_REQUEST['solicitud']."";
			$insert="INSERT INTO tbHistorico_Trabajos (COD_TRABAJO,ESTADO_TP,FX_OPERACION,COD_USUARIO,CORREO_ENVIADO) VALUES (".$_REQUEST['solicitud'].",'Rechazado',getdate(),".$_SESSION['privi'].",1)";
			$query = sqlsrv_query( $conn, $sql) or die ("Fallo al intentar insertar la solicitud");
			$query1 = sqlsrv_query( $conn, $insert) or die ("Fallo al intentar insertar la solicitud en historico");
			envioCambio($_REQUEST['solicitud']);
		}
		//echo $_est['ESTADO_TP'];
		if ($est['ESTADO_TP'] === 'Aceptado') {
			$sql = "UPDATE tbTrabajos_Solicitados SET ESTADO_TP = 'Cancelado' WHERE COD_TRABAJO = ".$_REQUEST['solicitud']."";
			$insert="INSERT INTO tbHistorico_Trabajos (COD_TRABAJO,ESTADO_TP,FX_OPERACION,COD_USUARIO,CORREO_ENVIADO) VALUES (".$_REQUEST['solicitud'].",'Cancelado',getdate(),".$_SESSION['privi'].",1)";
			$query = sqlsrv_query( $conn, $sql) or die ("Fallo al intentar insertar la solicitud");
			$query1 = sqlsrv_query( $conn, $insert) or die ("Fallo al intentar insertar la solicitud en historico2 ".$insert);
			envioCambio($_REQUEST['solicitud']);
		}
		sqlsrv_free_stmt( $sql);
		sqlsrv_free_stmt( $insert);
		sqlsrv_close( $conn);
	    header('Location: http://ftth-dst.jazztel.com/trabajos_programados/index.php?view='.$_REQUEST['view'].'');
	}

	if ($accion === 'asignar'){ //PROCEDIMIENTO PARA ASIGNAR UNA SOLICITUD AL USUARIO SSR
		$sql = "INSERT INTO tbTrabajos_Revisados (COD_TRABAJO,COD_USUARIO_SSR) VALUES (".$_REQUEST['solicitud'].",".$_SESSION['privi'].")";
		$sql1 = "UPDATE tbTrabajos_Solicitados SET ESTADO_TP = 'Asignado' WHERE COD_TRABAJO = ".$_REQUEST['solicitud']."";
		$insert="INSERT INTO tbHistorico_Trabajos (COD_TRABAJO,ESTADO_TP,FX_OPERACION,COD_USUARIO) VALUES (".$_REQUEST['solicitud'].",'Asignado',getdate(),".$_SESSION['privi'].")";
		$conexion = conectar_bd();
		$query = sqlsrv_query($conexion,$sql) or die ('Fallo al intentar asignar los trabajos solicitados'. $sql);
		$query1 = sqlsrv_query($conexion,$sql1) or die ('Fallo al intentar asignar los trabajos solicitados'. $sql1);
		$query2 = sqlsrv_query($conexion,$insert) or die ('Fallo al intentar asignar los trabajos solicitados'. $insert);
		sqlsrv_free_stmt($sql);
		sqlsrv_free_stmt($sql1);
		sqlsrv_free_stmt($insert);
		sqlsrv_close($conexion);
		/*header('Location: http://ftth-dst.jazztel.com/trabajos_programados/index.php?view=2');*/
		echo '<script type="text/javascript">';
			echo "window.opener.document.getElementById('btnfiltrar').click();";
			echo 'window.close();';
		echo '</script>';
	}

	//PROCESOS SSR

	$codigo = $_POST['codigo'];
	$actividad = $_POST['actividad'];
	$descrip_act = $_POST['descrip_act'];
	$tipo_cambio = $_POST['tipo_cambio'];
	$nc_riesgo = $_POST['nc_riesgo'];
	$nc_afectados = $_POST['nc_afectados'];
	$nc_centrex = $_POST['nc_centrex'];
	$estado = $_POST['estado'];
	$m_rechazo = $_POST['m_rechazo'];
	$m_cancelado = $_POST['m_cancelado'];
	$riesgo = $_POST['riesgo'];
	$observaciones = $_POST['observaciones'];
	$remedy = $_POST['remedy'];
	$apro_fechaini = $_POST['apro_fechaini'].' '.$_POST['apro_hora_ini'];
	$apro_fechafin = $_POST['apro_fechafin'].' '.$_POST['apro_hora_fin'];
	$f_apertura = $_POST['f_apertura'].' '.$_POST['apert_hora_ini'];
	$ejec_ini = $_POST['ejec_ini'].' '.$_POST['ejec_hora_ini'];
	$ejec_fin = $_POST['ejec_fin'].' '.$_POST['ejec_hora_fin'];
	$ini_ret = $_POST['ini_ret'];
	$afect_derv = $_POST['afect_derv'];
	$nc_caidos = $_POST['nc_caidos'];
	$comunicado = $_POST['comunicado'];
	$cod_ssr = $_POST['cod_ssr'];
	$af_conectividad = $_POST['af_conectividad'];
	$af_fttn = $_POST['af_fttn'];
	$af_otros = $_POST['af_otros'];

	if ($accion == 'actualizar_ssr') { //PROCEDIMIENTO PARA ACTUALIZAR UN TRABAJO EN REVISIÓN O ESTUDIO

		$msg_error = 'Fallo al intentar actualizar el estudio de la solicitud. <br> Los siguientes campos son requeridos:';

		$tabla = "UPDATE tbTrabajos_Revisados SET ";
		
		if (!empty($actividad)) {
			$campos .= "COD_ACTIVIDAD = ".$actividad.",";
		} else {
			$msg_error .= '<br> - Actividad';
		}
		if (!empty($descrip_act)) {
			$campos .= "DESCRIPCION_ACTIVIDAD = '".$descrip_act."'";
		} else {
			$msg_error .= '<br> - Descripción actividad';
		}
		if (!empty($tipo_cambio)) {
			$campos .= ",COD_TIPO_CAMBIO = ".$tipo_cambio;
		} else {
			$msg_error .= '<br> - Tipo cambio';
		}
		if (!empty($nc_riesgo) || $nc_afectados == 0) {
			$campos .= ",N_CLIENTES_RIESGO = ".$nc_riesgo;
		} else {
			$msg_error .= '<br> - Numero clientes riesgo';
		}
		if (!empty($nc_afectados) || $nc_afectados == 0) {
			$campos .= ",N_CLIENTES_AFECTADOS = ".$nc_afectados;
		} else {
			$msg_error .= '<br> - Numero clientes afectados';
		}
		if (!empty($nc_centrex) || $nc_afectados == 0) {
			$campos .= ",N_CLIENTES_CENTREX = ".$nc_centrex;
		} else {
			$msg_error .= '<br> - Numero clientes centrex';
		}
		if (!empty($m_rechazo)) {
			$campos .= ",COD_MOTIVO_RECHAZO = ".$m_rechazo;
		} else {
			$msg_error .= '<br> - Motivo rechazo';
		}
		if (!empty($m_cancelado)) {
			$campos .= ",COD_MOTIVO_CANCELADO = ".$m_cancelado;
		} else {
			$msg_error .= '<br> - Motivo rechazo';
		}
		if (!empty($riesgo)) {
			$campos .= ",RIESGO = '".$riesgo."'";
		} else {
			$msg_error .= '<br> - Riesgo';
		}


		if (!empty($af_conectividad)) {
			$campos .= ",AF_CONECTIVIDAD = ".$af_conectividad;
		} else {
			$msg_error .= '<br> - AF CONECTIVIDAD';
		}
		if (!empty($af_fttn)) {
			$campos .= ",AF_FTTN = ".$af_fttn;
		} else {
			$msg_error .= '<br> - AF FTTN';
		}
		if (!empty($af_otros)) {
			$campos .= ",AF_OTROS = ".$af_otros;
		} else {
			$msg_error .= '<br> - AF OTROS';
		}


		if (!empty($observaciones)) {
			$campos .= ",COMENTARIOS = '".$observaciones."'";
		} else {
			$msg_error .= '<br> - Observaciones';
		}
		if (!empty($remedy)) {
			$campos .= ",REMEDY = '".$remedy."'";
		} else {
			$msg_error .= '<br> - Remedy';
		}

		$condic = " WHERE COD_TRABAJO = ".$_REQUEST['solicitud']."";
		$update = $tabla.$campos.$condic;
		$update1 = "UPDATE tbTrabajos_Solicitados SET ESTADO_TP = '".$estado."', COD_TIPO_ACTUACION = ".$tipo_act." WHERE COD_TRABAJO = ".$_REQUEST['solicitud']."";
		$insert="INSERT INTO tbHistorico_Trabajos (COD_TRABAJO,ESTADO_TP,FX_OPERACION,COD_USUARIO,CORREO_ENVIADO) VALUES (".$_REQUEST['solicitud'].",'".$estado."',getdate(),".$_SESSION['privi'].",1)";
		$conn=conectar_bd();
		$query = sqlsrv_query($conn,$update) or die ('Fallo al intentar actualizar el trabajo solicitado'.$msg_error.'<br>'.$update);
		$query2 = sqlsrv_query($conn,$update1) or die ('Fallo al intentar actualizar el trabajo solicitado'.$update1);
		$query3 = sqlsrv_query($conn,$insert);
		sqlsrv_free_stmt($query);
		sqlsrv_free_stmt($query2);
		sqlsrv_free_stmt($insert);
		sqlsrv_close($conn);
		if ($estado = 'Pendiente Info' || $estado = 'Rechazado'){
			envioCambio($_REQUEST['solicitud']);
		}
		header('Location: http://ftth-dst.jazztel.com/trabajos_programados/forms/fin_proceso.php');
	}

	if ($accion == 'actualizar_cab') { //PROCEDIMIENTO PARA ACTUALIZAR DATOS DE SOLICITUDES PENDIENTES DE CAB
		$update = "UPDATE tbTrabajos_Revisados 
				   SET FX_APROBADA_INICIO = '".date('Y-m-d H:i:s',strtotime(str_replace('/', '-', $apro_fechaini)))."', 
				   	   FX_APROBADA_FIN = '".date('Y-m-d H:i:s',strtotime(str_replace('/', '-', $apro_fechafin)))."' 
				   WHERE COD_TRABAJO = ".$_REQUEST['solicitud']." ";
		$update1 = "UPDATE tbTrabajos_Solicitados SET ESTADO_TP ='Aceptado' WHERE COD_TRABAJO = ".$_REQUEST['solicitud']." ";
		$insert="INSERT INTO tbHistorico_Trabajos (COD_TRABAJO,ESTADO_TP,FX_OPERACION) VALUES (".$_REQUEST['solicitud'].",'Aceptado',getdate())";
		$conn = conectar_bd();
		$query = sqlsrv_query($conn,$update) or die ('Fallo al intentar actualizar fecha de CAB <br>'.$update);
		$query1 = sqlsrv_query($conn,$update1) or die ('Fallo al intentar actualizar fecha de CAB <br>'.$update1);
		$query2 = sqlsrv_query($conn,$insert) or die ('Fallo al intentar actualizar resultados de ejecución historico <br>'.$insert);
		sqlsrv_free_stmt($query);
		sqlsrv_free_stmt($query1);
		sqlsrv_free_stmt($query2);
		sqlsrv_close($conn);
		header('Location: http://ftth-dst.jazztel.com/trabajos_programados/forms/fin_proceso.php');
	}

	if ($accion == 'actualizar_ejec') { //PROCEDIMIENTO PARA ACTUALIZAR DATOS DE SOLICITUDES PENDIENTES DE EJECUCIÓN
		$update = "UPDATE tbTrabajos_Revisados set FX_APERTURA = '".date('Y-m-d H:i:s',strtotime(str_replace('/', '-',$f_apertura)))."',COMUNICADO = 1, FX_EJECUCION_INICIO = '".date('Y-m-d H:i:s',strtotime(str_replace('/', '-', $ejec_ini)))."'";
												   if ($apro_fechaini == $comp_fecha_ini) { 
												   		$update .= ",INICIO_RETRASADO = 0";
												   } else {
												   		$update .= ",INICIO_RETRASADO = 1";
												   }
												   if (!empty(trim($ejec_fin))) { 
														$update .= ",FX_EJECUCION_FIN = '".date('Y-m-d H:i:s',strtotime(str_replace('/', '-',$ejec_fin)))."'";
													} else {
														$update .= ",FX_EJECUCION_FIN = NULL";
													}									
												   if (!empty($afect_derv)) {
												   		$update .= ",AFECTACIONES_DERIVADAS = ".$afect_derv.",";
													}
													if (!empty($nc_caidos)){
												   		$update .= "N_CLIENTES_CAIDOS = ".$nc_caidos;
													}
													$update .= " WHERE COD_TRABAJO = ".$_REQUEST['solicitud'];
		$conn = conectar_bd();
		if (!empty(trim($ejec_fin))) {
			$update1 = "UPDATE tbTrabajos_Solicitados SET ESTADO_TP ='Realizado' WHERE COD_TRABAJO = ".$_REQUEST['solicitud']." ";
			$insert="INSERT INTO tbHistorico_Trabajos (COD_TRABAJO,ESTADO_TP,FX_OPERACION) VALUES (".$_REQUEST['solicitud'].",'Realizado',getdate())";
			$query1 = sqlsrv_query($conn,$update1) or die ('Fallo al intentar actualizar resultados de ejecución sol <br>'.$update1);
			$query2 = sqlsrv_query($conn,$insert) or die ('Fallo al intentar actualizar resultados de ejecución historico<br>'.$insert);
			sqlsrv_free_stmt($query1);
			sqlsrv_free_stmt($query2);
		}
		$query = sqlsrv_query($conn,$update) or die ('Fallo al intentar actualizar resultados de ejecución rev <br>'.$update);
		sqlsrv_free_stmt($query);
		sqlsrv_close($conn);
		header('Location: http://ftth-dst.jazztel.com/trabajos_programados/forms/fin_proceso.php');
	}

	//PROCESOS DE CONFIGURACIÓN DE LA APLICACIÓN

	$nombre_completo = $_POST['nombre_completo'];
	$login = $_POST['login'];
	$password = $_POST['password'];
	$perfil_usu = $_POST['perfil_usu'];
	$email = $_POST['email'];
	$dni = $_POST['dni'];
	$cod_usu = $_REQUEST['cod_usu'];
	$region = $_POST['region'];
	$provincias = $_POST['provincias'];

	if ($accion == 'insertar_usu'){
		$conn = conectar_bd();
		if ($perfil_usu == 3) {
			$insert_usu = "INSERT INTO tbUsuarios (LOGIN,PASSWORD,COD_PERFIL,APLICACION,NOMBRE_COMPLETO,EMAIL,DNI,COD_REGION) 
						   VALUES ('".$login."','".$password."',".$perfil_usu.",'SSR','".$nombre_completo."','".$email."','".$dni."',".$region.")";
			$query_usu = sqlsrv_query($conn,$insert_usu) or die ('Fallo al intentar insertar el nuevo usuario <br>'.$insert_usu);
		} elseif ($perfil_usu == 5) {
			$insert_usu = "INSERT INTO tbUsuarios (LOGIN,PASSWORD,COD_PERFIL,APLICACION,NOMBRE_COMPLETO,EMAIL,DNI) 
						   VALUES ('".$login."','".$password."',".$perfil_usu.",'SSR','".$nombre_completo."','".$email."','".$dni."');SELECT SCOPE_IDENTITY() AS NEWID;";
			$query_usu = sqlsrv_query($conn,$insert_usu) or die ('Fallo al intentar insertar el nuevo usuario <br>'.$insert_usu);
			sqlsrv_next_result($query_usu);
			sqlsrv_fetch($query_usu);
			$new_user = sqlsrv_get_field($query_usu, 0);
			for ($i=0;$i<count($provincias);$i++) { 
				$insert_prov_usu = "INSERT INTO tbUsuarios_Provincias (COD_USUARIO,COD_PROVINCIA) VALUES (".$new_user.",".$provincias[$i].")";
				$query_prov_usu = sqlsrv_query($conn,$insert_prov_usu);
			}
			sqlsrv_free_stmt($query_prov_usu);
		}
		else {
			$insert_usu = "INSERT INTO tbUsuarios (LOGIN,PASSWORD,COD_PERFIL,APLICACION,NOMBRE_COMPLETO,EMAIL,DNI,COD_REGION) 
						   VALUES ('".$login."','".$password."',".$perfil_usu.",'SSR','".$nombre_completo."','".$email."',null,null)";
			$query_usu = sqlsrv_query($conn,$insert_usu) or die ('Fallo al intentar insertar el nuevo usuario <br>'.$insert_usu);
		}
		sqlsrv_free_stmt($query_usu);
		sqlsrv_close($conn);
		header('Location: http://ftth-dst.jazztel.com/trabajos_programados/forms/fin_proceso.php');
	}

	if ($accion == 'actualizar_usu'){
		$msg_error = 'Fallo al intentar actualizar el usuario. <br> Los siguientes campos son requeridos:';

		$tabla = "UPDATE tbUsuarios SET ";
		if (!empty($login)) {
			$campos .= "LOGIN = '".$login;
		} else {
			$msg_error .= '<br> - Login';
		}
		if (!empty($login)) {
			$campos .= "',PASSWORD = '".$password;
		} else {
			$msg_error .= '<br> - Password';
		}
		if (!empty($perfil_usu)) {
			$campos .= "',COD_PERFIL = ".$perfil_usu;
		} else {
			$msg_error .= '<br> - Perfil';
		}
		if (!empty($nombre_completo)) {
			$campos .= ",NOMBRE_COMPLETO = '".$nombre_completo;
		} else {
			$msg_error .= '<br> - Nombre completo';
		}
		if (!empty($email)) {
			$campos .= "',EMAIL = '".$email;
		} else {
			$msg_error .= '<br> - e-mail';
		}
		if (!empty($dni)) {
			$campos .= "',DNI = '".$dni;
		} else {
			$msg_error .= '<br> - DNI';
		}
		if (!empty($region)) {
			$campos .= "',COD_REGION = '".$region;
		} else {
			$msg_error .= '<br> - REGION';
		}
		$condic = "' WHERE COD_USUARIO = ".$cod_usu."";
		$update = $tabla.$campos.$condic;
		$conn=conectar_bd();
		$query = sqlsrv_query($conn,$update) or die ('Fallo al intentar actualizar el usuario seleccionado'.$msg_error.'<br>'.$update);
		if ($perfil_usu == 5) {
			$tborrar = "delete from tbUsuarios_Provincias where COD_USUARIO=".$cod_usu;
			$qborrar = sqlsrv_query($conn,$tborrar);
			for ($i=0;$i<count($provincias);$i++) { 
				$insert_prov_usu = "INSERT INTO tbUsuarios_Provincias (COD_USUARIO,COD_PROVINCIA) VALUES (".$cod_usu.",".$provincias[$i].")";
				$query_prov_usu = sqlsrv_query($conn,$insert_prov_usu);
			}
			sqlsrv_free_stmt($query_prov_usu);
		} else {
			$tborrar = "delete from tbUsuarios_Provincias where COD_USUARIO=".$cod_usu;
			$qborrar = sqlsrv_query($conn,$tborrar);
		}
		sqlsrv_free_stmt($query);
		sqlsrv_close($conn);
		header('Location: http://ftth-dst.jazztel.com/trabajos_programados/forms/fin_proceso.php');
	}

	if ($accion == 'eliminar_usu'){
		$borrar = "delete from tbUsuarios where COD_USUARIO = ".$_GET['cod_usu'];
		$borrar_provincias = "delete from tbUsuarios_Provincias where COD_USUARIO =".$_GET['cod_usu'];
		$conn = conectar_bd();
		$qborrar = sqlsrv_query($conn,$borrar);
		$qborrar_provincias = sqlsrv_query($conn,$borrar_provincias);
		sqlsrv_free_stmt($qborrar);
		sqlsrv_free_stmt($qborrar_provincias);
		sqlsrv_close($conn);
		header('Location: http://ftth-dst.jazztel.com/trabajos_programados/index.php?view=51');
	}

	//-----------------------------------------

	$codi_prov = $_POST['cod_prov'];
	$nom_prov = $_POST['provincia'];
	$iniciales = $_POST['iniciales'];
	$region = $_POST['regiones'];

	if ($accion == 'insertar_prov'){
		$insert_prov = "INSERT INTO tbProvincias (DESCRIPCION,COD_REGION,INICIALES) values ('".$nom_prov."',".$region.",'".$iniciales."')";
		$conn = conectar_bd();
		$query_prov = sqlsrv_query($conn,$insert_prov) or die ('Fallo al intentar insertar una nueva provincia <br>'.$insert_prov);
		sqlsrv_free_stmt($query_prov);
		sqlsrv_close($conn);
		header('Location: http://ftth-dst.jazztel.com/trabajos_programados/forms/fin_proceso.php');
	}

	if ($accion == 'actualizar_prov'){
		$msg_error = 'Fallo al intentar actualizar la provincia. <br> Los siguientes campos son requeridos:';

		$tabla = "UPDATE tbProvincias SET ";
		if (!empty($nom_prov)) {
			$campos .= "DESCRIPCION = '".$nom_prov;
		} else {
			$msg_error .= '<br> - Provincia';
		}
		if (!empty($iniciales)) {
			$campos .= "',INICIALES = '".$iniciales;
		} else {
			$msg_error .= '<br> - Iniciales';
		}
		if (!empty($region)) {
			$campos .= "',COD_REGION = ".$region;
		} else {
			$msg_error .= '<br> - Region';
		}
		$condic = " WHERE COD_PROVINCIA = ".$codi_prov."";
		$update = $tabla.$campos.$condic;
		$conn=conectar_bd();
		$query = sqlsrv_query($conn,$update) or die ('Fallo al intentar actualizar la provincia seleccionada'.$msg_error.'<br>'.$update);
		sqlsrv_free_stmt($query);
		sqlsrv_close($conn);
		header('Location: http://ftth-dst.jazztel.com/trabajos_programados/forms/fin_proceso.php');
	}

	if ($accion == 'eliminar_prov'){
		$borrar = "delete from tbProvincias where COD_PROVINCIA = ".$_GET['cod_prov'];
		$conn = conectar_bd();
		$qborrar = sqlsrv_query($conn,$borrar);
		sqlsrv_free_stmt($qborrar);
		sqlsrv_close($conn);
		header('Location: http://ftth-dst.jazztel.com/trabajos_programados/index.php?view=52');
	}

	//-----------------------------------------

	$cod_cent = $_POST['cod_cent'];
	$central = $_POST['central'];
	$provincia = $_POST['provincia'];

	if ($accion == 'insertar_cent'){
		$insert_cent = "INSERT INTO tbCentrales (DESCRIPCION,COD_PROVINCIA) values ('".$central."',".$provincia.")";
		$conn = conectar_bd();
		$query_cent = sqlsrv_query($conn,$insert_cent) or die ('Fallo al intentar insertar una nueva central <br>'.$insert_cent);
		sqlsrv_free_stmt($query_cent);
		sqlsrv_close($conn);
		header('Location: http://ftth-dst.jazztel.com/trabajos_programados/forms/fin_proceso.php');
	}

	if ($accion == 'actualizar_cent'){
		$msg_error = 'Fallo al intentar actualizar central. <br> Los siguientes campos son requeridos:';

		$tabla = "UPDATE tbCentrales SET ";
		if (!empty($login)) {
			$campos .= "COD_PROVINCIA = ".$provincia;
		} else {
			$msg_error .= '<br> - Provincia';
		}
		if (!empty($login)) {
			$campos .= ",DESCRIPCION = '".$central;
		} else {
			$msg_error .= '<br> - Central';
		}
		$condic = "' WHERE COD_CENTRAL = ".$cod_cent."";
		$update = $tabla.$campos.$condic;
		$conn=conectar_bd();
		$query = sqlsrv_query($conn,$update) or die ('Fallo al intentar actualizar la central seleccionada'.$msg_error.'<br>'.$update);
		sqlsrv_free_stmt($query);
		sqlsrv_close($conn);
		header('Location: http://ftth-dst.jazztel.com/trabajos_programados/forms/fin_proceso.php');
	}

	if ($accion == 'eliminar_cent'){
		$borrar = "delete from tbCentrales where COD_CENTRAL = ".$_GET['cod_cent'];
		$conn = conectar_bd();
		$qborrar = sqlsrv_query($conn,$borrar);
		sqlsrv_free_stmt($qborrar);
		sqlsrv_close($conn);
		header('Location: http://ftth-dst.jazztel.com/trabajos_programados/index.php?view=53');
	}

	$cod_resp = $_POST['cod_resp'];
	$nombre_comp = $_POST['nombre_comp'];
	$telefono = $_POST['telefono'];

	if ($accion == 'insertar_resp'){
		$insert_resp = "INSERT INTO tbResponsables (NOMBRE_COMPLETO,TELEFONO) values ('".$nombre_comp."','".$telefono."')";
		$conn = conectar_bd();
		$query_resp = sqlsrv_query($conn,$insert_resp) or die ('Fallo al intentar insertar el nuevo responsable <br>'.$insert_resp);
		sqlsrv_free_stmt($query_resp);
		sqlsrv_close($conn);
		header('Location: http://ftth-dst.jazztel.com/trabajos_programados/forms/fin_proceso.php');
	}

	if ($accion == 'actualizar_resp'){
		$msg_error = 'Fallo al intentar actualizar el responsable. <br> Los siguientes campos son requeridos:';

		$tabla = "UPDATE tbResponsables SET ";
		if (!empty($nombre_comp)) {
			$campos .= "NOMBRE_COMPLETO = '".$nombre_comp;
		} else {
			$msg_error .= '<br> - Nombre completo';
		}
		if (!empty($telefono)) {
			$campos .= "',TELEFONO = '".$telefono;
		} else {
			$msg_error .= '<br> - telefono';
		}
		$condic = "' WHERE COD_RESPONSABLE = ".$cod_resp."";
		$update = $tabla.$campos.$condic;
		$conn=conectar_bd();
		$query = sqlsrv_query($conn,$update) or die ('Fallo al intentar actualizar el responsable seleccionado'.$msg_error.'<br>'.$update);
		sqlsrv_free_stmt($query);
		sqlsrv_close($conn);
		header('Location: http://ftth-dst.jazztel.com/trabajos_programados/forms/fin_proceso.php');
	}

	if ($accion == 'eliminar_resp'){
		$borrar = "delete from tbResponsables where COD_RESPONSABLE = ".$_GET['cod_resp'];
		$conn = conectar_bd();
		$qborrar = sqlsrv_query($conn,$borrar);
		sqlsrv_free_stmt($qborrar);
		sqlsrv_close($conn);
		header('Location: http://ftth-dst.jazztel.com/trabajos_programados/index.php?view=54');
	}

	if ($accion == 'enviar_todo'){
		Envio_Aceptado();
	}

	$id_fichero = $_GET['id_file'];
	$modo = $_GET['modo'];
	$ruta = $_GET['ruta'];
	$cod_trabajo_file = $_GET['cod_trabajo_file'];
	$nombre_file = $_GET['name_file'];

	if ($accion == 'eliminar_adjunto') {
		$conexion = conectar_bd();
		$tsql_delete_file = "DELETE FROM tbDOC_TPS WHERE ID_FICHERO =".$id_fichero;
		$query_delete_file = sqlsrv_query($conexion,$tsql_delete_file);
		if ($query_delete_file == false){
			die ("No se ha podido llevar a cabo la solicitud de borrado");
		} else {
			if (unlink($ruta.'/'.$nombre_file)) {
				sqlsrv_free_stmt($query_delete_file);
				sqlsrv_close($conexion);
				header('Location: http://ftth-dst.jazztel.com/trabajos_programados/forms/consulta_solicitud.php?jobcode='.$cod_trabajo_file.'&mode='.$modo);
			} else {
				die ("No se ha podido borrar el fichero del servidor");
			}
		}
		
	}
?>
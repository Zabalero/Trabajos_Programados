<?php 
include("funciones.php");
session_start();

if($_GET['action'] == 'listar')
{
	// valores recibidos por POST
	$vnm   = $_POST['REMEDY'];
	$vident = $_POST['IDENT'];
	$vsemana = $_POST['week'];
	$vcr = $_POST['cr'];
	$vprovincia = $_POST['provincias'];
	$vcentrales = $_POST['centrales'];
	$vempresas = $_POST['empresas'];
	$vestados = $_POST['estados'];
	$vdel  = ($_POST['del'] != '' ) ? explode("/",$_POST['del']) : '';
	$val   = ($_POST['al']  != '' ) ? explode("/",$_POST['al']) : '';
	$idusuario = $_POST['vista'];
	$perfil = $_POST['perfil'];
	$provincias_usu = $_POST['provincias_usu'];
	
	if ($perfil == 3) {
		$sql = "SELECT tbTrabajos_Solicitados.COD_TRABAJO as codigo,
					   convert(char,tbTrabajos_Solicitados.FX_REGISTRO,103) as fechaenv,
					   tbTrabajos_Solicitados.IDENTIFICADOR as identificador,
					   isnull(rtrim(tbTrabajos_Revisados.REMEDY),'-------') as remedy,
					   tbProvincias.DESCRIPCION as provincia,
					   tbCentrales.DESCRIPCION as central,
					   tbTrabajos_Solicitados.CAMARA_FRONTERA as camara,
					   tbTrabajos_Solicitados.ESTADO_TP as estado,
					   isnull(convert(char,tbTrabajos_Revisados.FX_APROBADA_INICIO,103),'--/--/----') as fechaini,
					   isnull(convert(char,tbTrabajos_Revisados.FX_APROBADA_FIN,103),'--/--/----') as fechafin,
					   isnull(DATEPART(ISO_WEEK,tbTrabajos_Revisados.FX_APROBADA_INICIO),'') as semana,
		   			   UPPER((SELECT NOMBRE_COMPLETO FROM tbUsuarios WHERE tbUsuarios.COD_USUARIO = tbTrabajos_Solicitados.COD_USUARIO_CARGA)) as usu_carga 
				from tbTrabajos_Solicitados 
				left join tbTrabajos_Revisados on tbTrabajos_Solicitados.COD_TRABAJO = tbTrabajos_Revisados.COD_TRABAJO 
				left join tbCentrales on tbTrabajos_Solicitados.COD_CENTRAL = tbCentrales.COD_CENTRAL 
				left join tbProvincias on tbCentrales.COD_PROVINCIA = tbProvincias.COD_PROVINCIA 
				left join tbEmpresas on tbTrabajos_Solicitados.COD_EMPRESA = tbEmpresas.COD_EMPRESA 
				where (FX_REGISTRO BETWEEN DATEADD(MONTH,-2,GETDATE()) AND GETDATE()) 
					   AND tbTrabajos_Solicitados.COD_USUARIO_CARGA =".$idusuario."";
	}
	if ($perfil == 5) {
		$sql = "SELECT tbTrabajos_Solicitados.COD_TRABAJO as codigo,
					   convert(char,tbTrabajos_Solicitados.FX_REGISTRO,103) as fechaenv,
					   tbTrabajos_Solicitados.IDENTIFICADOR as identificador,
					   isnull(rtrim(tbTrabajos_Revisados.REMEDY),'-------') as remedy,
					   tbProvincias.DESCRIPCION as provincia,
					   tbCentrales.DESCRIPCION as central,
					   tbTrabajos_Solicitados.CAMARA_FRONTERA as camara,
					   tbTrabajos_Solicitados.ESTADO_TP as estado,
					   isnull(convert(char,tbTrabajos_Revisados.FX_APROBADA_INICIO,103),'--/--/----') as fechaini,
					   isnull(convert(char,tbTrabajos_Revisados.FX_APROBADA_FIN,103),'--/--/----') as fechafin,
					   isnull(DATEPART(ISO_WEEK,tbTrabajos_Revisados.FX_APROBADA_INICIO),'') as semana,
		   			   UPPER((SELECT NOMBRE_COMPLETO FROM tbUsuarios WHERE tbUsuarios.COD_USUARIO = tbTrabajos_Solicitados.COD_USUARIO_CARGA)) as usu_carga 
				from tbTrabajos_Solicitados 
				left join tbTrabajos_Revisados on tbTrabajos_Solicitados.COD_TRABAJO = tbTrabajos_Revisados.COD_TRABAJO 
				left join tbCentrales on tbTrabajos_Solicitados.COD_CENTRAL = tbCentrales.COD_CENTRAL 
				left join tbProvincias on tbCentrales.COD_PROVINCIA = tbProvincias.COD_PROVINCIA 
				left join tbEmpresas on tbTrabajos_Solicitados.COD_EMPRESA = tbEmpresas.COD_EMPRESA 
				where (FX_REGISTRO BETWEEN DATEADD(MONTH,-2,GETDATE()) AND GETDATE()) 
					   AND tbProvincias.COD_PROVINCIA IN (".$provincias_usu.")";
	}
	if ($perfil == 2) {
		$sql = "SELECT tbTrabajos_Solicitados.COD_TRABAJO as codigo,
					   tbTrabajos_Solicitados.PRIORIDAD as prioridad,
					   tbTrabajos_Solicitados.IDENTIFICADOR as identificador,
					   isnull(rtrim(tbTrabajos_Revisados.REMEDY),'-------') as remedy,
					   tbProvincias.DESCRIPCION as provincia,
					   tbCentrales.DESCRIPCION as central,
					   tbTrabajos_Solicitados.CAMARA_FRONTERA as camara,
					   tbTrabajos_Solicitados.ESTADO_TP as estado,
					   isnull(convert(char,tbTrabajos_Solicitados.FX_PROPUESTA_INICIO,103),'--/--/----') as fechaini_pro,
					   isnull(convert(char,tbTrabajos_Solicitados.FX_PROPUESTA_FIN,103),'--/--/----') as fechafin_pro, 
					   isnull(DATEPART(ISO_WEEK,tbTrabajos_Solicitados.FX_PROPUESTA_INICIO),'') as semanapro,
		   			   UPPER((SELECT NOMBRE_COMPLETO FROM tbUsuarios WHERE tbUsuarios.COD_USUARIO = tbTrabajos_Solicitados.COD_USUARIO_CARGA)) as usu_carga 
				from tbTrabajos_Solicitados 
				left join tbTrabajos_Revisados on tbTrabajos_Solicitados.COD_TRABAJO = tbTrabajos_Revisados.COD_TRABAJO 
				left join tbCentrales on tbTrabajos_Solicitados.COD_CENTRAL = tbCentrales.COD_CENTRAL 
				left join tbProvincias on tbCentrales.COD_PROVINCIA = tbProvincias.COD_PROVINCIA 
				left join tbEmpresas on tbTrabajos_Solicitados.COD_EMPRESA = tbEmpresas.COD_EMPRESA 
				where tbTrabajos_Solicitados.IDENTIFICADOR <> '' 
					  and (FX_REGISTRO BETWEEN DATEADD(MONTH,-2,GETDATE()) AND GETDATE())";
	}
	if ($perfil == 4 || $perfil == 1) {
		$sql = "SELECT tbTrabajos_Solicitados.COD_TRABAJO as codigo,
					   tbTrabajos_Solicitados.PRIORIDAD as prioridad,
					   tbTrabajos_Solicitados.IDENTIFICADOR as identificador,
					   isnull(rtrim(tbTrabajos_Revisados.REMEDY),'-------') as remedy,
					   tbProvincias.DESCRIPCION as provincia,
					   tbCentrales.DESCRIPCION as central,
					   tbTrabajos_Solicitados.CAMARA_FRONTERA as camara,
					   tbTrabajos_Solicitados.ESTADO_TP as estado,
					   isnull(convert(char,tbTrabajos_Solicitados.FX_PROPUESTA_INICIO,103),'--/--/----') as fechaini_pro,
					   isnull(convert(char,tbTrabajos_Solicitados.FX_PROPUESTA_FIN,103),'--/--/----') as fechafin_pro, 
					   isnull(DATEPART(ISO_WEEK,tbTrabajos_Solicitados.FX_PROPUESTA_INICIO),'') as semanapro,
		   			   UPPER((SELECT NOMBRE_COMPLETO FROM tbUsuarios WHERE tbUsuarios.COD_USUARIO = tbTrabajos_Solicitados.COD_USUARIO_CARGA)) as usu_carga 
				from tbTrabajos_Solicitados 
				left join tbTrabajos_Revisados on tbTrabajos_Solicitados.COD_TRABAJO = tbTrabajos_Revisados.COD_TRABAJO 
				left join tbCentrales on tbTrabajos_Solicitados.COD_CENTRAL = tbCentrales.COD_CENTRAL 
				left join tbProvincias on tbCentrales.COD_PROVINCIA = tbProvincias.COD_PROVINCIA 
				left join tbEmpresas on tbTrabajos_Solicitados.COD_EMPRESA = tbEmpresas.COD_EMPRESA 
				where tbTrabajos_Solicitados.IDENTIFICADOR <> '' 
					  and (FX_REGISTRO BETWEEN DATEADD(MONTH,-2,GETDATE()) AND GETDATE())";
	}
	if ($perfil == 6) {
		$sql = "SELECT tbTrabajos_Solicitados.COD_TRABAJO as codigo,
					   convert(char,tbTrabajos_Solicitados.FX_REGISTRO,103) as fechaenv,
					   tbTrabajos_Solicitados.IDENTIFICADOR as identificador,
					   isnull(rtrim(tbTrabajos_Revisados.REMEDY),'-------') as remedy,
					   tbEmpresas.DESCRIPCION as empresa,
					   tbProvincias.DESCRIPCION as provincia,
					   tbCentrales.DESCRIPCION as central,
					   tbTrabajos_Solicitados.CAMARA_FRONTERA as camara,
					   tbTrabajos_Solicitados.ESTADO_TP as estado,
					   isnull(convert(char,tbTrabajos_Revisados.FX_APROBADA_INICIO,103),'--/--/----') as fechaini,
					   isnull(convert(char,tbTrabajos_Revisados.FX_APROBADA_FIN,103),'--/--/----') as fechafin,
					   isnull(DATEPART(ISO_WEEK,tbTrabajos_Revisados.FX_APROBADA_INICIO),'') as semana,
		   			   UPPER((SELECT NOMBRE_COMPLETO FROM tbUsuarios WHERE tbUsuarios.COD_USUARIO = tbTrabajos_Solicitados.COD_USUARIO_CARGA)) as usu_carga 
				from tbTrabajos_Solicitados 
				left join tbTrabajos_Revisados on tbTrabajos_Solicitados.COD_TRABAJO = tbTrabajos_Revisados.COD_TRABAJO 
				left join tbCentrales on tbTrabajos_Solicitados.COD_CENTRAL = tbCentrales.COD_CENTRAL 
				left join tbProvincias on tbCentrales.COD_PROVINCIA = tbProvincias.COD_PROVINCIA 
				left join tbEmpresas on tbTrabajos_Solicitados.COD_EMPRESA = tbEmpresas.COD_EMPRESA 
				where (FX_REGISTRO BETWEEN DATEADD(MONTH,-2,GETDATE()) AND GETDATE())";
	}										
	// Vericamos si hay algun filtro
	$sql .= ($vnm != '')      ? " AND tbTrabajos_Revisados.REMEDY LIKE '".$vnm."%'" : "";
	$sql .= ($vident != '')      ? " AND tbTrabajos_Solicitados.IDENTIFICADOR LIKE '".$vident."%'" : "";
	$sql .= ($vcr != '')      ? " AND tbTrabajos_Solicitados.CAMARA_FRONTERA LIKE '".$vcr."%'" : "";
	$sql .= ($vprovincia > 0)      ? " AND tbProvincias.COD_PROVINCIA = '".$vprovincia."'" : "";
	if ($perfil <> 3) {
		$sql .= ($vsemana > 0)      ? " AND DATEPART(ISO_WEEK,tbTrabajos_Solicitados.FX_PROPUESTA_INICIO) = ".$vsemana."" : "";
	} else {
		$sql .= ($vsemana > 0)      ? " AND DATEPART(ISO_WEEK,tbTrabajos_Revisados.FX_APROBADA_INICIO) = ".$vsemana."" : "";
	}
	$sql .= ($vcentrales > 0)      ? " AND tbCentrales.COD_CENTRAL = '".$vcentrales."'" : "";
	$sql .= ($vempresas > 0)      ? " AND tbEmpresas.COD_EMPRESA = '".$vempresas."'" : "";
	$sql .= ($vestados !='Seleccionar')      ? " AND tbTrabajos_Solicitados.ESTADO_TP = '".$vestados."'" : "";
	$sql .= ($vdel && $val)   ? " AND tbTrabajos_Solicitados.FX_REGISTRO BETWEEN '$vdel[2]$vdel[1]$vdel[0]' AND '$val[2]$val[1]$val[0]' " : "";
	
	// Ordenar por
	$vorder = $_POST['orderby'];
	
	if($vorder != ''){
		$sql .= " ORDER BY ".$vorder;
	}
	else {
		$sql .= " ORDER BY tbTrabajos_Solicitados.FX_REGISTRO DESC";
	}
	
	$conn=conectar_bd();
	$query = sqlsrv_query( $conn, $sql);
	$datos = array();
	$tablaExcel .= '<table>
					<thead><tr>
					<th>Solicita</th>
					<th>Identificador</th>
					<th>Remedy</th>
					<th>Provincia</th>
					<th>Central</th>
					<th>Cámara front.</th>
					<th>Est.</th>
					<th>Fecha inicio apro.</th>
					<th>Fecha fin apro.</th>
					<th>Semana</th>
					<th>Prioridad</th>
					<th>Fecha inicio pro</th>
					<th>Fecha fin pro</th>
					<th>Semana pro</th>
					</tr></thead><tbody>';
	
	while($row = sqlsrv_fetch_array($query)) {
		$datos[] = array(
						'codigo' => $row['codigo'],
						'fechaenv' => $row['fechaenv'],
						'identificador' => $row['identificador'],
						'remedy' => $row['remedy'],
						'provincia' => $row['provincia'],
						'emp' => $row['empresa'],
						'central' => $row['central'],
						'camara' => $row['camara'],
						'estado' => $row['estado'],
						'fechaini' => $row['fechaini'],
						'fechafin' => $row['fechafin'],
						'semana' => $row['semana'],
						'prioridad' => $row['prioridad'],
						'fechaini_pro' => $row['fechaini_pro'],
						'fechafin_pro' => $row['fechafin_pro'],
						'semanapro' => $row['semanapro'],
						'solicita' => $row['usu_carga'],
						'perfil' => $perfil
						);
		$tablaExcel .= '<tr>
						<td>'.$row['usu_carga'].'</td>
						<td>'.$row['identificador'].'</td>
						<td>'.$row['remedy'].'</td>
						<td>'.$row['provincia'].'</td>
						<td>'.$row['central'].'</td>
						<td>'.$row['camara'].'</td>
						<td>'.$row['estado'].'</td>
						<td>'.$row['fechaini'].'</td>
						<td>'.$row['fechafin'].'</td>
						<td>'.$row['semana'].'</td>
						<td>'.$row['prioridad'].'</td>
						<td>'.$row['fechaini_pro'].'</td>
						<td>'.$row['fechafin_pro'].'</td>
						<td>'.$row['semanapro'].'</td>
						</tr>';
	}
	$tablaExcel .= '</tbody></table>';
	// convertimos el array de datos a formato json
	$_SESSION['excel_solicitudes'] = $tablaExcel;
	echo json_encode($datos);
	sqlsrv_free_stmt( $query);
	sqlsrv_close( $conn);
}

if($_GET['action'] == 'listar_ssr')
{
	// valores recibidos por POST
	$vnm   = $_POST['REMEDY'];
	$vident = $_POST['IDENT'];
	$vcr = $_POST['cr'];
	$vprovincia = $_POST['provincias'];
	$vcentrales = $_POST['centrales'];
	$vempresas = $_POST['empresas'];
	$vestados = $_POST['estados'];
	$vdel  = ($_POST['del'] != '' ) ? explode("/",$_POST['del']) : '';
	$val   = ($_POST['al']  != '' ) ? explode("/",$_POST['al']) : '';
	$idusuario = $_POST['vista'];
	$perfil = $_POST['perfil'];
	
	if ($perfil == 2){
		$sql = "SELECT tbTrabajos_Revisados.COD_TRABAJO as codigo,
					   ISNULL(DATEPART(ISO_WEEK,tbTrabajos_Revisados.FX_APROBADA_INICIO),0) as semana,
					   CONVERT(CHAR,tbTrabajos_Solicitados.FX_REGISTRO,103) AS fechareg,
					   ISNULL(CONVERT(CHAR,tbTrabajos_Revisados.FX_APROBADA_INICIO,103),'--/--/----') AS fechaini,
					   ISNULL(CONVERT(CHAR,tbTrabajos_Revisados.FX_APROBADA_FIN,103),'--/--/----') AS fechafin,
					   tbTrabajos_Solicitados.IDENTIFICADOR as identificador,
					   ISNULL(tbTrabajos_Revisados.REMEDY,'-------') as remedy,
					   tbProvincias.DESCRIPCION as provincia,
					   tbCentrales.DESCRIPCION as central,
					   tbTrabajos_Solicitados.CAMARA_FRONTERA as camara,
					   UPPER(tbEmpresas.DESCRIPCION) AS empresa,
					   isnull(tbTrabajos_Revisados.N_CLIENTES_RIESGO,'') as nc_riesgo,
					   isnull(tbTrabajos_Revisados.N_CLIENTES_AFECTADOS,'') as nc_caidos,
					   ISNULL(tbTrabajos_Revisados.AF_CONECTIVIDAD,'') AS af_conectividad,
					   ISNULL(tbTrabajos_Revisados.AF_FTTN,'') AS af_fttn,
					   ISNULL(tbTrabajos_Revisados.AF_OTROS,'') AS af_otros,
					   tbTrabajos_Solicitados.ESTADO_TP as estado
				from tbTrabajos_Revisados
				left join tbTrabajos_Solicitados on tbTrabajos_Revisados.COD_TRABAJO = tbTrabajos_Solicitados.COD_TRABAJO
				left join tbCentrales on tbTrabajos_Solicitados.COD_CENTRAL = tbCentrales.COD_CENTRAL
				left join tbEmpresas on tbTrabajos_Solicitados.COD_EMPRESA = tbEmpresas.COD_EMPRESA
				left join tbProvincias on tbCentrales.COD_PROVINCIA = tbProvincias.COD_PROVINCIA  
				WHERE (FX_REGISTRO BETWEEN DATEADD(MONTH,-2,GETDATE()) AND GETDATE()) 
					   AND tbTrabajos_Solicitados.ESTADO_TP <> 'Registrado' 
					   AND tbTrabajos_Revisados.COD_USUARIO_SSR = ".$idusuario."";
	}
	if ($perfil == 4 || $perfil == 1){
		$sql = "SELECT tbTrabajos_Revisados.COD_TRABAJO as codigo,
					   ISNULL(DATEPART(ISO_WEEK,tbTrabajos_Revisados.FX_APROBADA_INICIO),0) as semana,
					   CONVERT(CHAR,tbTrabajos_Solicitados.FX_REGISTRO,103) AS fechareg,
					   ISNULL(CONVERT(CHAR,tbTrabajos_Revisados.FX_APROBADA_INICIO,103),'--/--/----') AS fechaini,
					   ISNULL(CONVERT(CHAR,tbTrabajos_Revisados.FX_APROBADA_FIN,103),'--/--/----') AS fechafin,
					   tbTrabajos_Solicitados.IDENTIFICADOR as identificador,
					   ISNULL(tbTrabajos_Revisados.REMEDY,'-------') as remedy,
					   tbProvincias.DESCRIPCION as provincia,
					   tbCentrales.DESCRIPCION as central,
					   tbTrabajos_Solicitados.CAMARA_FRONTERA as camara,
					   UPPER(tbEmpresas.DESCRIPCION) AS empresa,
					   isnull(tbTrabajos_Revisados.N_CLIENTES_RIESGO,'') as nc_riesgo,
					   isnull(tbTrabajos_Revisados.N_CLIENTES_AFECTADOS,'') as nc_caidos,
					   ISNULL(tbTrabajos_Revisados.AF_CONECTIVIDAD,'') AS af_conectividad,
					   ISNULL(tbTrabajos_Revisados.AF_FTTN,'') AS af_fttn,
					   ISNULL(tbTrabajos_Revisados.AF_OTROS,'') AS af_otros,
					   tbTrabajos_Solicitados.ESTADO_TP as estado
				from tbTrabajos_Revisados
				left join tbTrabajos_Solicitados on tbTrabajos_Revisados.COD_TRABAJO = tbTrabajos_Solicitados.COD_TRABAJO
				left join tbCentrales on tbTrabajos_Solicitados.COD_CENTRAL = tbCentrales.COD_CENTRAL
				left join tbEmpresas on tbTrabajos_Solicitados.COD_EMPRESA = tbEmpresas.COD_EMPRESA
				left join tbProvincias on tbCentrales.COD_PROVINCIA = tbProvincias.COD_PROVINCIA 
				WHERE tbTrabajos_Revisados.COD_TRABAJO <> ''  
					  AND (FX_REGISTRO BETWEEN DATEADD(MONTH,-2,GETDATE()) AND GETDATE())";
	}
	// Vericamos si hay algun filtro
	$sql .= ($vnm != '') ? " AND tbTrabajos_Revisados.REMEDY LIKE '".$vnm."%'" : "";
	$sql .= ($vident != '') ? " AND tbTrabajos_Solicitados.IDENTIFICADOR LIKE '".$vident."%'" : "";
	$sql .= ($vcr != '') ? " AND tbTrabajos_Solicitados.CAMARA_FRONTERA LIKE '".$vcr."%'" : "";
	$sql .= ($vprovincia > 0) ? " AND tbProvincias.COD_PROVINCIA = '".$vprovincia."'" : "";
	$sql .= ($vcentrales > 0) ? " AND tbCentrales.COD_CENTRAL = '".$vcentrales."'" : "";
	$sql .= ($vempresas > 0) ? " AND tbEmpresas.COD_EMPRESA = '".$vempresas."'" : "";
	$sql .= ($vestados !='Seleccionar')      ? " AND tbTrabajos_Solicitados.ESTADO_TP = '".$vestados."'" : "";
	$sql .= ($vdel && $val) ? " AND tbTrabajos_Solicitados.FX_REGISTRO BETWEEN '$vdel[2]$vdel[1]$vdel[0]' AND '$val[2]$val[1]$val[0]' " : "";
	
	// Ordenar por
	$vorder = $_POST['orderby'];
	
	if($vorder != ''){
		$sql .= " ORDER BY ".$vorder;
	}
	else {
		$sql .= " ORDER BY convert(char,tbTrabajos_Solicitados.FX_REGISTRO,103) DESC";
	}

	$conn=conectar_bd();
	$query = sqlsrv_query($conn,$sql);
	$datosssr = array();
	$tablaExcel .= '<table>
					<thead><tr>
					<th>Prioridad</th>
					<th>Identificador</th>
					<th>Remedy</th>
					<th>Fecha inicio</th>
					<th>Fecha fin</th>
					<th>Semana</th>
					<th>Provincia</th>
					<th>Central</th>
					<th>Cámara</th>

					<th>AF CONECTIVIDAD</th>
					<th>AF FTTN</th>
					<th>AF OTROS</th>

					<th>Estado</th>
					<th>Nº client. riesgo</th>
					<th>Nº client. caidos</th>
					</tr></thead><tbody>';
	
	while($row = sqlsrv_fetch_array($query)) {
		$datosssr[] = array(
							'codigo'=> $row['codigo'],
							'semana'=> $row['semana'],
							'fechareg'=> $row['fechareg'],
							'fechaini'=> $row['fechaini'],
							'fechafin'=> $row['fechafin'],
							'identificador'=> $row['identificador'],
							'remedy'=> $row['remedy'],
							'provincia'=> $row['provincia'],
							'central'=> $row['central'],
							'camara'=> $row['camara'],
							'empresa'=> $row['empresa'],
							'estado'=> $row['estado'],
							'nc_riesgo'=> $row['nc_riesgo'],
							'nc_caidos'=> $row['nc_caidos'],
							'af_conectividad'=> $row['af_conectividad'],
							'af_fttn'=> $row['af_fttn'],
							'af_otros'=> $row['af_otros'],
							'perfil'=> $perfil
							);
		$tablaExcel .= '<tr>
						<td>'.$row['prioridad'].'</td>
						<td>'.$row['identificador'].'</td>
						<td>'.$row['remedy'].'</td>
						<td>'.$row['fechaini'].'</td>
						<td>'.$row['fechafin'].'</td>
						<td>'.$row['semana'].'</td>
						<td>'.$row['provincia'].'</td>
						<td>'.$row['central'].'</td>
						<td>'.$row['camara'].'</td>';

						if ($row['af_conectividad'] == 1) {
							$tablaExcel .= '<td>SI</td>';
						} else {
							if ($fila['af_conectividad'] == 2) {
								$tablaExcel .= '<td>RIESGO</td>';
							} else {
								if ($fila['af_conectividad'] == 2) {
									$tablaExcel .= '<td>NO</td>';
								} else {
									$tablaExcel .= '<td>--</td>';
								}

							}
						}


						if ($row['af_fttn'] == 1) {
							$tablaExcel .= '<td>SI</td>';
						} else {
							if ($fila['af_conectividad'] == 2) {
								$tablaExcel .= '<td>RIESGO</td>';
							} else {
								if ($fila['af_conectividad'] == 2) {
									$tablaExcel .= '<td>NO</td>';
								} else {
									$tablaExcel .= '<td>--</td>';
								}

							}
						}


						if ($row['af_otros'] == 1) {
							$tablaExcel .= '<td>SI</td>';
						} else {
							if ($fila['af_conectividad'] == 2) {
								$tablaExcel .= '<td>RIESGO</td>';
							} else {
								if ($fila['af_conectividad'] == 2) {
									$tablaExcel .= '<td>NO</td>';
								} else {
									$tablaExcel .= '<td>--</td>';
								}

							}
						}						

						$tablaExcel .= '<td>'.$row['estado'].'</td>
										<td>'.$row['nc_riesgo'].'</td>
										<td>'.$row['nc_caidos'].'</td>';


						$tablaExcel .= '</tr>';
	}
	$tablaExcel .= '</tbody></table>';
	$_SESSION['excel_ssr'] = $tablaExcel;
	// convertimos el array de datos a formato json
	echo json_encode($datosssr);
	sqlsrv_free_stmt($query);
	sqlsrv_close($conn);
}

if($_GET['action'] == 'listar_ejec')
{
	// valores recibidos por POST
	$vnm   = $_POST['REMEDY'];
	$vident   = $_POST['identificador'];
	$vcr = $_POST['cr'];
	$vprovincia = $_POST['provincias'];
	$vcentrales = $_POST['centrales'];
	$vempresas = $_POST['empresas'];
	$vestados = $_POST['estados'];
	$vsemana = $_POST['week'];
	$vdel  = ($_POST['del'] != '' ) ? explode("/",$_POST['del']) : '';
	$val   = ($_POST['al']  != '' ) ? explode("/",$_POST['al']) : '';
	$idusuario = $_POST['vista'];
	$perfil = $_POST['perfil'];

	$sql = "SELECT tbTrabajos_Revisados.COD_TRABAJO as codigo,
				   tbTrabajos_Solicitados.PRIORIDAD as prioridad,
				   tbTrabajos_Solicitados.IDENTIFICADOR as identificador,
				   ISNULL(tbTrabajos_Revisados.REMEDY,'----') as remedy,
				   RTRIM(CONVERT(CHAR,tbTrabajos_Revisados.FX_APROBADA_INICIO,103)) + ' ' + convert(char(5), tbTrabajos_Revisados.FX_APROBADA_INICIO, 14) as fechaini_apro,
				   RTRIM(CONVERT(CHAR, tbTrabajos_Revisados.FX_APROBADA_FIN,103)) + ' ' + convert(char(5), tbTrabajos_Revisados.FX_APROBADA_FIN, 14) as fechafin_apro,
				   ISNULL(RTRIM(CONVERT(CHAR,tbTrabajos_Revisados.FX_APERTURA,103)) + ' ' + convert(char(5), tbTrabajos_Revisados.FX_APERTURA, 14),'--/--/---- --:--') as fecha_apert,
				   DATEPART(ISO_WEEK,tbTrabajos_Revisados.FX_APROBADA_INICIO) as semana_apro,
				   tbProvincias.DESCRIPCION as provincia,
				   tbCentrales.DESCRIPCION as central,
				   tbTrabajos_Solicitados.CAMARA_FRONTERA as camara,
				   tbEmpresas.DESCRIPCION as empresa,

				   -- maiteben_20160705
				   isnull(tbTrabajos_Revisados.N_CLIENTES_RIESGO,'') as nc_riesgo,
					isnull(tbTrabajos_Revisados.N_CLIENTES_AFECTADOS,'') as nc_caidos,				   
				   ISNULL(tbTrabajos_Revisados.AF_CONECTIVIDAD,'') AS af_conectividad,
				   ISNULL(tbTrabajos_Revisados.AF_FTTN,'') AS af_fttn,
				   ISNULL(tbTrabajos_Revisados.AF_OTROS,'') AS af_otros,
				   -- maiteben_20160705_fin

				   tbTrabajos_Solicitados.ESTADO_TP as estados,
				   (select TOP 1 case when CORREO_ENVIADO = 1 then 'si' else 'no' end as estado from tbHistorico_Trabajos where ESTADO_TP = 'Aceptado' and COD_TRABAJO = tbTrabajos_Revisados.COD_TRABAJO) as aceptado_env   
			from tbTrabajos_Revisados
			left join tbTrabajos_Solicitados on tbTrabajos_Revisados.COD_TRABAJO = tbTrabajos_Solicitados.COD_TRABAJO
			left join tbCentrales on tbTrabajos_Solicitados.COD_CENTRAL = tbCentrales.COD_CENTRAL
			left join tbProvincias on tbCentrales.COD_PROVINCIA = tbProvincias.COD_PROVINCIA 
			left join tbEmpresas on tbTrabajos_Solicitados.COD_EMPRESA = tbEmpresas.COD_EMPRESA WHERE tbTrabajos_Solicitados.ESTADO_TP in ('Aceptado','Realizado') and tbTrabajos_Revisados.FX_APROBADA_INICIO <> '' and tbTrabajos_Revisados.FX_APROBADA_FIN <> '' and (FX_REGISTRO BETWEEN DATEADD(MONTH,-2,GETDATE()) AND GETDATE())";
				// Vericamos si hay algun filtro
	$sql .= ($vnm != '') ? " AND tbTrabajos_Revisados.REMEDY LIKE '".$vnm."%'" : "";
	$sql .= ($vident != '') ? " AND tbTrabajos_Solicitados.IDENTIFICADOR LIKE '".$vident."%'" : "";
	$sql .= ($vcr != '') ? " AND tbTrabajos_Solicitados.CAMARA_FRONTERA LIKE '".$vcr."%'" : "";
	$sql .= ($vprovincia > 0) ? " AND tbProvincias.COD_PROVINCIA = '".$vprovincia."'" : "";
	$sql .= ($vsemana > 0) ? " AND DATEPART(ISO_WEEK,tbTrabajos_Revisados.FX_APROBADA_INICIO) = ".$vsemana."" : "";
	$sql .= ($vcentrales > 0) ? " AND tbCentrales.COD_CENTRAL = '".$vcentrales."'" : "";
	$sql .= ($vempresas > 0) ? " AND tbEmpresas.COD_EMPRESA = '".$vempresas."'" : "";
	$sql .= ($vestados !='Seleccionar') ? " AND tbTrabajos_Solicitados.ESTADO_TP = '".$vestados."'" : "";
	$sql .= ($vdel && $val) ? " AND tbTrabajos_Revisados.FX_APROBADA_INICIO BETWEEN '$vdel[2]$vdel[1]$vdel[0]' AND '$val[2]$val[1]$val[0]' " : "";
	
	// Ordenar por
	$vorder = $_POST['orderby'];
	
	if($vorder != ''){
		$sql .= " ORDER BY ".$vorder;
	}
	else {
		$sql .= " ORDER BY tbTrabajos_Revisados.FX_APROBADA_INICIO asc";
	}

	$conn=conectar_bd();
	$query = sqlsrv_query($conn,$sql);
	$datos_ejec = array();
	$tablaExcel .= '<table>
					<thead><tr>
					<th>Prioridad</th>
					<th>Identificador</th>
					<th>Remedy</th>
					<th>Fecha inicio apro.</th>
					<th>Fecha fin apro.</th>
					<th>Semana apro.</th>
					<th>Fecha apertura</th>
					<th>provincia</th>
					<th>Central</th>
					<th>Cámara</th>
					<th>Empresa</th>

					<th>Nº client. riesgo</th>
					<th>Nº client. caidos</th>					

					<th>AF CONECTIVIDAD</th>
					<th>AF FTTN</th>
					<th>AF OTROS</th>

					<th>Estados</th>
					<th>Enviado</th>
					</tr></thead><tbody>';
	
	while($row = sqlsrv_fetch_array($query))
	{
		$datos_ejec[] = array(
			'codigo'=> $row['codigo'],
			'prioridad'=> $row['prioridad'],
			'identificador'=> $row['identificador'],
			'remedy'=> $row['remedy'],
			'fechaini_apro'=> $row['fechaini_apro'],
			'fechafin_apro'=> $row['fechafin_apro'],
			'semana_apro'=> $row['semana_apro'],
			'fecha_apert'=> $row['fecha_apert'],
			'provincia'=> $row['provincia'],
			'central'=> $row['central'],
			'camara'=> $row['camara'],
			'empresa'=> $row['empresa'],

			// maiteben_20160705
			'nc_riesgo'=> $row['nc_riesgo'],
			'nc_caidos'=> $row['nc_caidos'],			
			'af_conectividad'=> $row['af_conectividad'],
			'af_fttn'=> $row['af_fttn'],
			'af_otros'=> $row['af_otros'],
			// maiteben_20160705_fin

			'estados'=> $row['estados'],
			'perfil'=> $perfil,
			'aceptado_env' => $row['aceptado_env']
		);
		$tablaExcel .= '<tr>
						<td>'.$row['prioridad'].'</td>
						<td>'.$row['identificador'].'</td>
						<td>'.$row['remedy'].'</td>
						<td>'.$row['fechaini_apro'].'</td>
						<td>'.$row['fechafin_apro'].'</td>
						<td>'.$row['semana_apro'].'</td>
						<td>'.$row['fecha_apert'].'</td>
						<td>'.$row['provincia'].'</td>
						<td>'.$row['central'].'</td>
						<td>'.$row['camara'].'</td>
						<td>'.$row['empresa'].'</td>
						<td>'.$row['nc_riesgo'].'</td>
						<td>'.$row['nc_caidos'].'</td>';						

						if ($row['af_conectividad'] == 1) {
							$tablaExcel .= '<td>SI</td>';
						} else {
							if ($fila['af_conectividad'] == 2) {
								$tablaExcel .= '<td>RIESGO</td>';
							} else {
								if ($fila['af_conectividad'] == 3) {
									$tablaExcel .= '<td>NO</td>';
								} else {
									$tablaExcel .= '<td>--</td>';
								} 

							}
						}


						if ($row['af_fttn'] == 1) {
							$tablaExcel .= '<td>SI</td>';
						} else {
							if ($fila['af_conectividad'] == 2) {
								$tablaExcel .= '<td>RIESGO</td>';
							} else {
								if ($fila['af_conectividad'] == 3) {
									$tablaExcel .= '<td>NO</td>';
								} else {
									$tablaExcel .= '<td>--</td>';
								}

							}
						}


						if ($row['af_otros'] == 1) {
							$tablaExcel .= '<td>SI</td>';
						} else {
							if ($fila['af_conectividad'] == 2) {
								$tablaExcel .= '<td>RIESGO</td>';
							} else {
								if ($fila['af_conectividad'] == 3) {
									$tablaExcel .= '<td>NO</td>';
								} else {
									$tablaExcel .= '<td>--</td>';
								}

							}
						}						

						$tablaExcel .= '<td>'.$row['estados'].'</td>
										<td>'.$row['aceptado_env'].'</td>
										</tr>';
	}
	$tablaExcel .= '</tbody></table>';
	$_SESSION['excel_ejecucion'] = $tablaExcel;
	// convertimos el array de datos a formato json
	echo json_encode($datos_ejec);
	sqlsrv_free_stmt($query);
	sqlsrv_close($conn);
}

if($_GET['action'] == 'listar_cab')
{
	// valores recibidos por POST
	$vnm   = $_POST['IDENT'];
	$vcr = $_POST['cr'];
	$vpais = $_POST['provincias'];
	$vestados = $_POST['estados'];
	$vsemana = $_POST['week'];
	$vrem = $_POST['rem'];
	$vdel  = ($_POST['del'] != '' ) ? explode("/",$_POST['del']) : '';
	$val   = ($_POST['al']  != '' ) ? explode("/",$_POST['al']) : '';
	$idusuario = $_POST['vista'];
	$perfil = $_POST['perfil'];

	$sql = "SELECT tbTrabajos_Revisados.COD_TRABAJO as codigo,
	   tbTrabajos_Solicitados.PRIORIDAD as prioridad,
	   tbTrabajos_Solicitados.IDENTIFICADOR as identificador,
	   ISNULL(tbTrabajos_Revisados.REMEDY,'-------') as remedy,
	   RTRIM(CONVERT(CHAR,tbTrabajos_Solicitados.FX_PROPUESTA_INICIO,103)) as fechaini_pro,
	   RTRIM(CONVERT(CHAR, tbTrabajos_Solicitados.FX_PROPUESTA_FIN,103)) as fechafin_pro,
	   ISNULL(RTRIM(CONVERT(CHAR,tbTrabajos_Revisados.FX_APROBADA_INICIO,103)),'--/--/----') as fechaini_apro,
	   ISNULL(RTRIM(CONVERT(CHAR, tbTrabajos_Revisados.FX_APROBADA_FIN,103)),'--/--/----') as fechafin_apro,
	   isnull(DATEPART(ISO_WEEK,tbTrabajos_Revisados.FX_APROBADA_INICIO),'') as semana,
	   tbProvincias.DESCRIPCION as provincia,
	   tbCentrales.DESCRIPCION as central,
	   tbTrabajos_Solicitados.CAMARA_FRONTERA as camara,
	   isnull(tbTrabajos_Revisados.N_CLIENTES_RIESGO,0) as nc_riesgo,
	   isnull(tbTrabajos_Revisados.N_CLIENTES_AFECTADOS,0) as nc_caidos,
	   tbTrabajos_Solicitados.ESTADO_TP as estado,

	   -- maiteben_20160705
	   ISNULL(tbTrabajos_Revisados.AF_CONECTIVIDAD,'') AS af_conectividad,
	   ISNULL(tbTrabajos_Revisados.AF_FTTN,'') AS af_fttn,
	   ISNULL(tbTrabajos_Revisados.AF_OTROS,'') AS af_otros,
	   -- maiteben_20160705_fin

	   (select TOP 1 case when CORREO_ENVIADO = 1 then 'si' else 'no' end as estado from tbHistorico_Trabajos  where ESTADO_TP = 'Aceptado' and COD_TRABAJO = tbTrabajos_Revisados.COD_TRABAJO) as aceptado_env
	from tbTrabajos_Revisados
	left join tbTrabajos_Solicitados on tbTrabajos_Revisados.COD_TRABAJO = tbTrabajos_Solicitados.COD_TRABAJO
	left join tbCentrales on tbTrabajos_Solicitados.COD_CENTRAL = tbCentrales.COD_CENTRAL
	left join tbProvincias on tbCentrales.COD_PROVINCIA = tbProvincias.COD_PROVINCIA 
	left join tbEmpresas on tbTrabajos_Solicitados.COD_EMPRESA = tbEmpresas.COD_EMPRESA WHERE tbTrabajos_Solicitados.ESTADO_TP IN ('Pendiente CAB','Aceptado')  and (FX_REGISTRO BETWEEN DATEADD(MONTH,-2,GETDATE()) AND GETDATE())";
	// Vericamos si hay algun filtro
	$sql .= ($vnm != '')      ? " AND tbTrabajos_Solicitados.IDENTIFICADOR LIKE '".$vnm."%'" : "";
	$sql .= ($vrem != '')      ? " AND tbTrabajos_Revisados.REMEDY LIKE '".$vrem."%'" : "";
	$sql .= ($vcr != '')      ? " AND tbTrabajos_Solicitados.CAMARA_FRONTERA LIKE '".$vcr."%'" : "";
	$sql .= ($vsemana > 0)      ? " AND DATEPART(ISO_WEEK,tbTrabajos_Revisados.FX_APROBADA_INICIO) = ".$vsemana."" : "";
	$sql .= ($vpais > 0)      ? " AND tbProvincias.COD_PROVINCIA = '".$vpais."'" : "";
	$sql .= ($vestados !='Seleccionar')      ? " AND tbTrabajos_Solicitados.ESTADO_TP = '".$vestados."'" : "";
	$sql .= ($vdel && $val)   ? " AND tbTrabajos_Solicitados.FX_REGISTRO BETWEEN '$vdel[2]$vdel[1]$vdel[0]' AND '$val[2]$val[1]$val[0]' " : "";
	// Ordenar por
	$vorder = $_POST['orderby'];
	
	if($vorder != ''){
		$sql .= " ORDER BY ".$vorder;
	}
	else {
		$sql .= " ORDER BY tbTrabajos_Solicitados.PRIORIDAD, tbTrabajos_Solicitados.FX_REGISTRO";
	}

	$conn=conectar_bd();
	$query = sqlsrv_query($conn,$sql);
	$datos_cab = array();
	$tablaExcel .= '<table>
					<thead><tr>
					<th>Prioridad</th>
					<th>Identificador</th>
					<th>Remedy</th>
					<th>Fecha inicio pro.</th>
					<th>Fecha fin pro.</th>
					<th>Fecha inicio apro.</th>
					<th>Fecha fin apro.</th>
					<th>Semana apro.</th>
					<th>provincia</th>
					<th>Central</th>
					<th>Cámara</th>
					<th>Nº client. riesgo</th>
					<th>Nº client. caidos</th>

					<th>AF CONECTIVIDAD</th>
					<th>AF FTTN</th>
					<th>AF OTROS</th>

					<th>Estado</th>
					</tr></thead><tbody>';
	
	while($row = sqlsrv_fetch_array($query))
	{
		$datos_cab[] = array(
			'codigo'=> $row['codigo'],
			'prioridad'=> $row['prioridad'],
			'identificador'=> $row['identificador'],
			'remedy'=> $row['remedy'],
			'fechaini_pro'=> $row['fechaini_pro'],
			'fechafin_pro'=> $row['fechafin_pro'],
			'fechaini_apro'=> $row['fechaini_apro'],
			'fechafin_apro'=> $row['fechafin_apro'],
			'semana' => $row['semana'],
			'provincia'=> $row['provincia'],
			'central'=> $row['central'],
			'camara'=> $row['camara'],
			'nc_riesgo'=> $row['nc_riesgo'],
			'nc_caidos'=> $row['nc_caidos'],

			// maiteben_20160705
			'af_conectividad'=> $row['af_conectividad'],
			'af_fttn'=> $row['af_fttn'],
			'af_otros'=> $row['af_otros'],
			// maiteben_20160705_fin

			'estado'=> $row['estado'],
			'perfil'=> $perfil,
			'aceptado_env' => $row['aceptado_env']
		);
		$tablaExcel .= '<tr>
						<td>'.$row['prioridad'].'</td>
						<td>'.$row['identificador'].'</td>
						<td>'.$row['remedy'].'</td>
						<td>'.$row['fechaini_pro'].'</td>
						<td>'.$row['fechafin_pro'].'</td>
						<td>'.$row['fechaini_apro'].'</td>
						<td>'.$row['fechafin_apro'].'</td>
						<td>'.$row['semana'].'</td>
						<td>'.$row['provincia'].'</td>
						<td>'.$row['central'].'</td>
						<td>'.$row['camara'].'</td>
						<td>'.$row['nc_riesgo'].'</td>
						<td>'.$row['nc_caidos'].'</td>';


						if ($row['af_conectividad'] == 1) {
							$tablaExcel .= '<td>SI</td>';
						} else {
							if ($fila['af_conectividad'] == 2) {
								$tablaExcel .= '<td>RIESGO</td>';
							} else {
								if ($fila['af_conectividad'] == 2) {
									$tablaExcel .= '<td>NO</td>';
								} else {
									$tablaExcel .= '<td>--</td>';
								}

							}
						}


						if ($row['af_fttn'] == 1) {
							$tablaExcel .= '<td>SI</td>';
						} else {
							if ($fila['af_conectividad'] == 2) {
								$tablaExcel .= '<td>RIESGO</td>';
							} else {
								if ($fila['af_conectividad'] == 2) {
									$tablaExcel .= '<td>NO</td>';
								} else {
									$tablaExcel .= '<td>--</td>';
								}

							}
						}


						if ($row['af_otros'] == 1) {
							$tablaExcel .= '<td>SI</td>';
						} else {
							if ($fila['af_conectividad'] == 2) {
								$tablaExcel .= '<td>RIESGO</td>';
							} else {
								if ($fila['af_conectividad'] == 2) {
									$tablaExcel .= '<td>NO</td>';
								} else {
									$tablaExcel .= '<td>--</td>';
								}

							}
						}						

						$tablaExcel .= '<td>'.$row['estado'].'</td>
										</tr>';
	}
	$tablaExcel .= '</tbody></table>';
	$_SESSION['excel_cab'] = $tablaExcel;
	// convertimos el array de datos a formato json
	echo json_encode($datos_cab);
	sqlsrv_free_stmt($query);
	sqlsrv_close($conn);
}

if($_GET['action'] == 'listar_usu')
{
	// valores recibidos por POST
	$vnm   = $_POST['NOMUSU'];
	$sql = "SELECT tbUsuarios.COD_USUARIO AS COD,UPPER(RTRIM(tbUsuarios.LOGIN)) AS USUARIO,UPPER(RTRIM(tbUsuarios.NOMBRE_COMPLETO)) AS NOMBRE,ISNULL(tbUsuarios.EMAIL,'') AS EMAIL,RTRIM(tbPerfiles.DESCRIPCION) AS PERFIL, ISNULL(RTRIM(tbRegiones.Descripcion),'-------') AS REGION FROM tbUsuarios LEFT JOIN tbPerfiles ON tbUsuarios.COD_PERFIL = tbPerfiles.COD_PERFIL LEFT JOIN tbRegiones ON tbUsuarios.COD_REGION = tbRegiones.COD_REGION";
	// Vericamos si hay algun filtro
	$sql .= ($vnm != '')      ? " WHERE UPPER(tbUsuarios.NOMBRE_COMPLETO) LIKE UPPER('$vnm%')" : "";
	
	// Ordenar por
	$vorder = $_POST['orderby'];
	
	if($vorder != ''){
		$sql .= " ORDER BY ".$vorder;
	}
	else {
		$sql .= " ORDER BY tbUsuarios.NOMBRE_COMPLETO";
	}
	
	$conn=conectar_bd();
	$query = sqlsrv_query( $conn, $sql);
	$tbusuarios = array();
	
	while($row = sqlsrv_fetch_array($query))
	{
		$tbusuarios[] = array(
			'cod'          => $row['COD'],
			'nombre'      => $row['NOMBRE'],
			'usuario'       => $row['USUARIO'],
			'email'  => $row['EMAIL'],
			'perfil'       => $row['PERFIL'],
			'region'  => $row['REGION']
		);
	}
	// convertimos el array de datos a formato json
	echo json_encode($tbusuarios);
	sqlsrv_free_stmt( $stmt);
	sqlsrv_close( $conn);
}

if($_GET['action'] == 'listar_prov')
{
	// valores recibidos por POST
	$vnm   = $_POST['region'];
	$sql = "SELECT tbProvincias.COD_PROVINCIA AS COD,UPPER(RTRIM(tbProvincias.DESCRIPCION)) AS PROVINCIA, UPPER(RTRIM(tbRegiones.Descripcion)) AS REGION FROM tbProvincias LEFT JOIN tbRegiones ON tbProvincias.COD_REGION = tbRegiones.Cod_Region";
	// Vericamos si hay algun filtro
	$sql .= ($vnm != '')      ? " WHERE UPPER(tbRegiones.DESCRIPCION) LIKE UPPER('$vnm%')" : "";
	
	// Ordenar por
	$vorder = $_POST['orderby'];
	
	if($vorder != ''){
		$sql .= " ORDER BY ".$vorder;
	}
	else {
		$sql .= " ORDER BY tbProvincias.DESCRIPCION,tbRegiones.Descripcion";
	}
	
	$conn=conectar_bd();
	$query = sqlsrv_query( $conn, $sql);
	$tbprovincias = array();
	
	while($row = sqlsrv_fetch_array($query))
	{
		$tbprovincias[] = array(
			'cod'          => $row['COD'],
			'provincia'      => $row['PROVINCIA'],
			'region'       => $row['REGION']
		);
	}
	// convertimos el array de datos a formato json
	echo json_encode($tbprovincias);
	sqlsrv_free_stmt( $stmt);
	sqlsrv_close( $conn);
}

if($_GET['action'] == 'listar_centr')
{
	// valores recibidos por POST
	$vnm   = $_POST['central'];
	$sql = "SELECT tbCentrales.COD_CENTRAL AS COD, tbCentrales.DESCRIPCION AS CENTRAL, tbProvincias.DESCRIPCION AS PROVINCIA, tbRegiones.Descripcion AS REGION FROM tbCentrales LEFT JOIN tbProvincias ON tbCentrales.COD_PROVINCIA = tbProvincias.COD_PROVINCIA LEFT JOIN tbRegiones ON tbProvincias.COD_REGION = tbRegiones.Cod_Region";
	// Vericamos si hay algun filtro
	$sql .= ($vnm != '')      ? " WHERE UPPER(tbCentrales.DESCRIPCION) LIKE UPPER('$vnm%')" : "";
	
	// Ordenar por
	$vorder = $_POST['orderby'];
	
	if($vorder != ''){
		$sql .= " ORDER BY ".$vorder;
	}
	else {
		$sql .= " ORDER BY tbProvincias.DESCRIPCION,tbCentrales.DESCRIPCION";
	}
	
	$conn=conectar_bd();
	$query = sqlsrv_query( $conn, $sql);
	$tbcentrales = array();
	
	while($row = sqlsrv_fetch_array($query))
	{
		$tbcentrales[] = array(
			'cod'          => $row['COD'],
			'central'      => $row['CENTRAL'],
			'provincia'       => $row['PROVINCIA'],
			'region'       => $row['REGION']
		);
	}
	// convertimos el array de datos a formato json
	echo json_encode($tbcentrales);
	sqlsrv_free_stmt( $stmt);
	sqlsrv_close( $conn);
}

if($_GET['action'] == 'listar_responsable')
{
	// valores recibidos por POST
	$vnm   = $_POST['nomresp'];
	$sql = "SELECT COD_RESPONSABLE AS COD, UPPER(RTRIM(tbResponsables.NOMBRE_COMPLETO)) AS NOMBRE, ISNULL(UPPER(RTRIM(tbResponsables.TELEFONO)),'---------') AS TELEFONO FROM tbResponsables";
	// Vericamos si hay algun filtro
	$sql .= ($vnm != '')      ? " WHERE UPPER(tbResponsables.NOMBRE_COMPLETO) LIKE UPPER('$vnm%')" : "";
	
	// Ordenar por
	$vorder = $_POST['orderby'];
	
	if($vorder != ''){
		$sql .= " ORDER BY ".$vorder;
	}
	else {
		$sql .= " ORDER BY tbResponsables.NOMBRE_COMPLETO";
	}
	
	$conn=conectar_bd();
	$query = sqlsrv_query( $conn, $sql);
	$tbresponsables = array();
	
	while($row = sqlsrv_fetch_array($query))
	{
		$tbresponsables[] = array(
			'cod'          => $row['COD'],
			'nombre'      => $row['NOMBRE'],
			'telefono'       => $row['TELEFONO']
		);
	}
	// convertimos el array de datos a formato json
	echo json_encode($tbresponsables);
	sqlsrv_free_stmt( $stmt);
	sqlsrv_close( $conn);
}

?>
<?php
// Establece una conexión con la base de datos
function conectar_bd(){
	/* Nombre del servidor. */
	$serverName = "172.29.0.80";
	/* Usuario y clave.  */
	$uid = "DST_ADM";
	$pwd = "reparil2014";
	/* Array asociativo con la información de la conexion */
	$connectionInfo = array( "UID"=>$uid,"PWD"=>$pwd,"Database"=>"TRABAJOS_PROGRAMADOS", "CharacterSet" => "UTF-8");
	/* Nos conectamos mediante la autenticación de SQL Server . */
	$conn = sqlsrv_connect( $serverName, $connectionInfo);
	if( $conn === false ){
		die ("No se puede conectar con el servidor");
	}
	//Devolvemos el enlace a la conexión
	return $conn;
}
function escribirLog($id_usuario) {
	$serverName_log = "172.29.0.80";
	$uid_log = "DST_ADM";
	$pwd_log = "reparil2014";
	$connectionInfo_log = array( "UID"=>$uid_log,"PWD"=>$pwd_log,"Database"=>"Remedy", "CharacterSet" => "UTF-8");
	$conn_log = sqlsrv_connect( $serverName_log, $connectionInfo_log);

	$tsql_log = "SELECT * FROM TB_LOG_APPS WHERE ID_USUARIO = ".$id_usuario." AND CONVERT(CHAR,FECHA,103) = CONVERT(CHAR,GETDATE(),103) AND APP_ORIGEN = 'TRABAJOS PROGRAMADOS'";
	$query_log = sqlsrv_query($conn_log,$tsql_log);
	$result_log = sqlsrv_has_rows($query_log);
	if ($result_log === false) {
		$insert_log = "INSERT INTO TB_LOG_APPS (ID_USUARIO,FECHA,APP_ORIGEN) VALUES (".$id_usuario.",GETDATE(),'TRABAJOS PROGRAMADOS')";
		$query_log_in = sqlsrv_query($conn_log,$insert_log);
		sqlsrv_free_stmt($query_log_in);
	}
	sqlsrv_free_stmt($query_log);
	sqlsrv_close($conn_log);
}
function es_usuario($usuario,$password){
	$conn=conectar_bd();
	$tsql="SELECT * FROM tbUsuarios WHERE LOGIN='".$usuario."'AND PASSWORD='".$password."'";
	$stmt = sqlsrv_query( $conn, $tsql);
	if( $stmt === false ){
		die ("Error al ejecutar consulta");
	}
	$rows = sqlsrv_has_rows( $stmt );
	if ($rows === true){
		$usuario = sqlsrv_fetch_array($stmt);
		escribirLog($usuario['COD_USUARIO']);
		return true;
	}
	else {
		return false;
	}
	sqlsrv_free_stmt( $stmt);
	sqlsrv_close( $conn);
}

function get_nombre($usuario){
//Se conecta a la base de datos
	$conn=conectar_bd();
	//Busca al usuario y su contraseña en la tabla usuarios
	$tsql="SELECT NOMBRE_COMPLETO,COD_PERFIL FROM tbUsuarios WHERE LOGIN='".$usuario."'";
	//Obtiene el resultado
	$stmt = sqlsrv_query( $conn, $tsql);
	if( $stmt === false ){
		die ("Error al ejecutar consulta");
	}
	/* Mostramos el resultado. */
	//(una fila)
	while($row = sqlsrv_fetch_array($stmt)){	
		$nombre= $row["NOMBRE_COMPLETO"];
		/*$perfil= $row["COD_PERFIL"]; */
	}
	/*if (!empty($perfil)) {
		$_SESSION['perfil'] = $perfil;
	}*/
	/* Cerramos la conexión */
	sqlsrv_free_stmt( $stmt);
	sqlsrv_close( $conn);
	return $nombre;
}

function get_perfil($usuario){
//Se conecta a la base de datos
	$conn=conectar_bd();
	//Busca al usuario y su contraseña en la tabla usuarios
	$tsql="SELECT COD_PERFIL FROM tbUsuarios WHERE LOGIN='".$usuario."'";
	//Obtiene el resultado
	$stmt = sqlsrv_query( $conn, $tsql);
	if( $stmt === false ){
		die ("Error al ejecutar consulta");
	}
	/* Mostramos el resultado. */
	//(una fila)
	while($row = sqlsrv_fetch_array($stmt)){	
		$perfil = $row["COD_PERFIL"];
		/*$perfil= $row["COD_PERFIL"]; */
	}
	/*if (!empty($perfil)) {
		$_SESSION['perfil'] = $perfil;
	}*/
	/* Cerramos la conexión */
	sqlsrv_free_stmt( $stmt);
	sqlsrv_close( $conn);
	return $perfil;
}

function get_idusuario($usuario){
//Se conecta a la base de datos
	$conn=conectar_bd();
	//Busca al usuario y su contraseña en la tabla usuarios
	$tsql="SELECT COD_USUARIO FROM tbUsuarios WHERE LOGIN='".$usuario."'";
	//Obtiene el resultado
	$stmt = sqlsrv_query( $conn, $tsql);
	if( $stmt === false ){
		die ("Error al ejecutar consulta");
	}
	/* Mostramos el resultado. */
	//(una fila)
	while($row = sqlsrv_fetch_array($stmt)){	
		$codigo = $row["COD_USUARIO"];
	}
	/* Cerramos la conexión */
	sqlsrv_free_stmt( $stmt);
	sqlsrv_close( $conn);
	return $codigo;
}

function get_provincias($usuario){
	$conn=conectar_bd();
	$tsql="SELECT COD_PROVINCIA FROM tbUSUARIOS_PROVINCIAS WHERE COD_USUARIO =".$usuario;
	$stmt = sqlsrv_query( $conn, $tsql);
	if( $stmt === false ){
		die ("Error al ejecutar consulta");
	}
	while($row = sqlsrv_fetch_array($stmt)){	
		$provincia.= $row["COD_PROVINCIA"].",";
	}
	$provincias = rtrim($provincia,',');
	sqlsrv_free_stmt( $stmt);
	sqlsrv_close( $conn);
	return $provincias;
}

function replace_specials_characters($s) {
	//$s = mb_convert_encoding($s, 'UTF-8','');
	$s = preg_replace("/á|à|â|ã|ª/","a",$s);
	$s = preg_replace("/Á|À|Â|Ã/","A",$s); 
	$s = preg_replace("/é|è|ê/","e",$s);
	$s = preg_replace("/É|È|Ê/","E",$s);
	$s = preg_replace("/í|ì|î/","i",$s);
	$s = preg_replace("/Í|Ì|Î/","I",$s);
	$s = preg_replace("/ó|ò|ô|õ|º/","o",$s);
	$s = preg_replace("/Ó|Ò|Ô|Õ/","O",$s);
	$s = preg_replace("/ú|ù|û/","u",$s);
	$s = preg_replace("/Ú|Ù|Û/","U",$s);
	$s = str_replace(" ","_",$s);
	$s = str_replace("ñ","n",$s);
	$s = str_replace("Ñ","N",$s);
	$s = preg_replace('/[^a-zA-Z0-9_\.-]/', '', $s);
	return $s;
}

function fechaBuena ($fecha) {
    $tam = strlen(rtrim($fecha));
    if ($tam >= 17 && $tam <= 19) {
    	$new_fecha = str_replace('/','-',$fecha);
    	return date('d-m-Y H:i:s',strtotime($new_fecha));
    } elseif ($tam < 17) {
    	$fecha_des = explode('-', $fecha);
    	if (strlen($fecha_des[0]) == 1) {
    		$new_fecha .= str_pad($fecha_des[0],2,'0',STR_PAD_LEFT);
    	}
    	else {
    		$new_fecha .= $fecha_des[0];
    	}
    	if (strlen($fecha_des[1]) == 1) {
    		$new_fecha .= '-'.str_pad($fecha_des[1],2,'0',STR_PAD_LEFT);
    	}
    	else {
    		$new_fecha .= '-'.$fecha_des[1];
    	}
    	$fecha_rest = explode(' ', $fecha_des[2]);
    	if (strlen($fecha_rest[0]) == 2){
    		$new_fecha .= '-'.'20'.$fecha_rest[0].' '.$fecha_rest[1];
    	}
    	else{
    		$new_fecha .= $fecha_rest[0].' '.$fecha_rest[1];
    	}
    return date('d-m-Y H:i:s',strtotime($new_fecha));
    } else {
    	$mensaje = '';
    	return $mensaje;
    }
}


function fechaSolicitud1($valor_campo) {
	$fecha = explode('/',$valor_campo);
	$fecha_comp = $fecha[2].'-'.$fecha[1].'-'.$fecha[0];
	return $fecha_comp;
}

function dameURL(){
	$url=$_SERVER['REQUEST_URI'];
	return $url;
}

function vXd($valor) {
	if (empty($valor)) {
		$valor == null;
	}
	if ($valor == 0) {
		$valor == null;
	}
	return $valor;
}

function getIdent($central){
	$tsql = "SELECT TOP 1 SUBSTRING(RTRIM(IDENTIFICADOR),3,6) AS INICT, 
					RIGHT(RTRIM(IDENTIFICADOR),4) AS IDENTIFICADOR,
					(SELECT tbProvincias.INICIALES 
					FROM tbProvincias 
					LEFT JOIN tbCentrales ON tbProvincias.COD_PROVINCIA = tbCentrales.COD_PROVINCIA 
					WHERE tbCentrales.COD_CENTRAL = ".$central.") AS INI 
			FROM tbTrabajos_Solicitados 
			WHERE IDENTIFICADOR <> '' 
				  AND LEN(IDENTIFICADOR) = 12 
		 	ORDER BY SUBSTRING(RTRIM(IDENTIFICADOR),3,10) DESC";
	if (empty($tsql)){
		 $tsql = "SELECT tbProvincias.INICIALES AS INI 
		 		  FROM tbProvincias 
		 		  LEFT JOIN tbCentrales ON tbProvincias.COD_PROVINCIA = tbCentrales.COD_PROVINCIA 
		 		  WHERE tbCentrales.COD_CENTRAL = ".$central.""; 
	}
	$conn=conectar_bd();
	$query = sqlsrv_query( $conn, $tsql);
	$row = sqlsrv_fetch_array($query);
	$ma = $row['INICT'];
	$ult_numero = $row['IDENTIFICADOR'];
	$ini_provinci = $row['INI'];
	$fecha = date('Y-m-d');
	$exp = explode('-',$fecha);
	$pref = $exp[0].$exp[1];
	if ($pref != $ma) {
		$ult_numero = 0;
	}
	$ult_numero+=1;
	$identificador = $ini_provinci.$exp[0].$exp[1].str_pad($ult_numero,4,'0',STR_PAD_LEFT);	
	return $identificador;
}

function envioCambio($cod_trabajo) {

	$tsql = "SELECT tbUsuarios.NOMBRE_COMPLETO AS NOMBRE, 
			tbUsuarios.EMAIL AS EMAIL, 
			tbTrabajos_Solicitados.ESTADO_TP AS ESTADO,
			tbCentrales.DESCRIPCION AS CENTRAL,
			tbTrabajos_Revisados.REMEDY as REMEDY,
			tbTrabajos_Solicitados.CAMARA_FRONTERA as CAMARA,
			convert(char,tbTrabajos_Solicitados.FX_REGISTRO,103) as ALTA,
			replace(tbTrabajos_Revisados.COMENTARIOS,CHAR(13)+CHAR(10),'<br>') as COMENTARIOS,
			(select NOMBRE_COMPLETO from tbUsuarios where COD_USUARIO = (select top 1 COD_USUARIO from tbHistorico_Trabajos where COD_TRABAJO = ".$cod_trabajo." order by FX_OPERACION desc)) as USUACCION, 
			tbTrabajos_Solicitados.IDENTIFICADOR FROM TBUSUARIOS 
			LEFT JOIN tbTrabajos_Solicitados ON tbUsuarios.COD_USUARIO = tbTrabajos_Solicitados.COD_USUARIO_CARGA
			LEFT JOIN tbCentrales ON tbCentrales.COD_CENTRAL = tbTrabajos_Solicitados.COD_CENTRAL
			LEFT JOIN tbTrabajos_Revisados ON tbTrabajos_Solicitados.COD_TRABAJO = tbTrabajos_Revisados.COD_TRABAJO
			WHERE tbTrabajos_Solicitados.COD_TRABAJO = ".$cod_trabajo."";
	$conn=conectar_bd();
	$query = sqlsrv_query( $conn, $tsql);
	$row = sqlsrv_fetch_array($query);
	$nombre = $row['NOMBRE'];
	$email= $row['EMAIL'];
	$estado= $row['ESTADO'];
	$central = $row['CENTRAL'];
	$identificador= $row['IDENTIFICADOR'];
	$camara= $row['CAMARA'];
	$alta = $row['ALTA'];
	$observaciones = $row['COMENTARIOS'];
	$usu_accion = $row['USUACCION'];
	sqlsrv_free_stmt($query);

	$asunto="CAMBIO DE ESTADO DE TRABAJO ".$identificador." – ".$camara." – ".$central;
	if (strtoupper($estado)=="ANULADO") {
		$cuerpo = '<html><head><title>Anulación de trabajo programado</title></head><body><h1 style="font-size: 11px;color: #ED7D31;font-weight: bold;font-family: "Calibri",sans-serif;">GESTION DE TRABAJOS SSR</h1>';
		$cuerpo .='<p style="color: #595959;font-size: 11px;font-family: "Calibri",sans-serif;">El trabajo solicitado con el <b style="color: #404040;font-size: 11px;font-family: "Calibri",sans-serif;font-weight: bold;">IDENTIFICADOR '.$identificador.'</b> dado de alta el día <b style="color: #404040;font-size: 11px;font-family: "Calibri",sans-serif;font-weight: bold;>'.$alta.'</b> por el usuario <b style="color: #404040;font-size: 11px;font-family: "Calibri",sans-serif;font-weight: bold;>'.$nombre.'</b> ha cambiado al estado <b style="color: #404040;font-size: 11px;font-family: "Calibri",sans-serif;font-weight: bold;>ANULADO.</b></p>';
		$cuerpo .='<p style="color: #595959;font-size: 11px;font-family: "Calibri",sans-serif;">Acción realizada por <b style="color: #404040;font-size: 11px;font-family: "Calibri",sans-serif;font-weight: bold;">'.$usu_accion.'</b></p></body></html>';
		$headers = "MIME-Version: 1.0\r\n"; 
		$headers .= "Content-type: text/html; charset=UTF-8\r\n"; 
		$headers .= "From: Notificación de solicitudes <ssr@jazztel.com>\r\n"; 
		$headers .= "Return-path: ".$email."\r\n"; 
		$headers .= "Cc: daniel.coronel@jazztel.com\r\n"; 
		mail($email,$asunto,$cuerpo,$headers); 
		$tsql = "UPDATE TBHISTORICO_TRABAJOS SET CORREO_ENVIADO = 1 WHERE COD_TRABAJO = ".$cod_trabajo." AND UPPER(ESTADO_TP) IN ('ANULADO', 'RECHAZADO', 'CANCELADO', 'PENDIENTE INFO') AND CORREO_ENVIADO = 0";
		$query = sqlsrv_query( $conn, $tsql);
		sqlsrv_close( $conn);
	}
	elseif (strtoupper($estado)=="RECHAZADO") {
		$cuerpo = '<html><head><title>Rechazo de trabajo programado</title></head><body><h1 style="font-size: 11px;color: #ED7D31;font-weight: bold;font-family: "Calibri",sans-serif;">GESTION DE TRABAJOS SSR</h1>';
		$cuerpo .='<p style="color: #595959;font-size: 11px;font-family: "Calibri",sans-serif;">El trabajo solicitado con el <b style="color: #404040;font-size: 11px;font-family: "Calibri",sans-serif;font-weight: bold;">IDENTIFICADOR '.$identificador.'</b> dado de alta el día <b style="color: #404040;font-size: 11px;font-family: "Calibri",sans-serif;font-weight: bold;>'.$alta.'</b> por el usuario <b style="color: #404040;font-size: 11px;font-family: "Calibri",sans-serif;font-weight: bold;>'.$nombre.'</b> ha cambiado al estado <b style="color: #404040;font-size: 11px;font-family: "Calibri",sans-serif;font-weight: bold;>RECHAZADO.</b></p>';
		$cuerpo .='<p style="color: #595959;font-size: 11px;font-family: "Calibri",sans-serif;">Acción realizada por <b style="color: #404040;font-size: 11px;font-family: "Calibri",sans-serif;font-weight: bold;">'.$usu_accion.'</b></p></body></html>';
		$headers = "MIME-Version: 1.0\r\n"; 
		$headers .= "Content-type: text/html; charset=UTF-8\r\n"; 
		$headers .= "From: Notificación de solicitudes <ssr@jazztel.com>\r\n"; 
		$headers .= "Return-path: ".$email."\r\n"; 
		$headers .= "Cc: daniel.coronel@jazztel.com\r\n"; 
		mail($email,$asunto,$cuerpo,$headers); 
		$tsql = "UPDATE TBHISTORICO_TRABAJOS SET CORREO_ENVIADO = 1 WHERE COD_TRABAJO = ".$cod_trabajo." AND UPPER(ESTADO_TP) IN ('ANULADO', 'RECHAZADO', 'CANCELADO', 'PENDIENTE INFO') AND CORREO_ENVIADO = 0";
		$query = sqlsrv_query( $conn, $tsql);
		sqlsrv_close( $conn);
	}
	elseif (strtoupper($estado)=="CANCELADO") {
		$cuerpo = '<html><head><title>Cancelación de trabajo programado</title></head><body><h1 style="font-size: 11px;color: #ED7D31;font-weight: bold;font-family: "Calibri",sans-serif;">GESTION DE TRABAJOS SSR</h1>';
		$cuerpo .='<p style="color: #595959;font-size: 11px;font-family: "Calibri",sans-serif;">El trabajo solicitado con el <b style="color: #404040;font-size: 11px;font-family: "Calibri",sans-serif;font-weight: bold;">IDENTIFICADOR '.$identificador.'</b> dado de alta el día <b style="color: #404040;font-size: 11px;font-family: "Calibri",sans-serif;font-weight: bold;>'.$alta.'</b> por el usuario <b style="color: #404040;font-size: 11px;font-family: "Calibri",sans-serif;font-weight: bold;>'.$nombre.'</b> ha cambiado al estado <b style="color: #404040;font-size: 11px;font-family: "Calibri",sans-serif;font-weight: bold;>CANCELADO.</b></p>';
		$cuerpo .='<p style="color: #595959;font-size: 11px;font-family: "Calibri",sans-serif;">Acción realizada por <b style="color: #404040;font-size: 11px;font-family: "Calibri",sans-serif;font-weight: bold;">'.$usu_accion.'</b></p></body></html>';
		$headers = "MIME-Version: 1.0\r\n"; 
		$headers .= "Content-type: text/html; charset=UTF-8\r\n"; 
		$headers .= "From: Notificación de solicitudes <ssr@jazztel.com>\r\n"; 
		$headers .= "Return-path: ".$email."\r\n"; 
		$headers .= "Cc: daniel.coronel@jazztel.com\r\n"; 
		mail($email,$asunto,$cuerpo,$headers); 
		$tsql = "UPDATE TBHISTORICO_TRABAJOS SET CORREO_ENVIADO = 1 WHERE COD_TRABAJO = ".$cod_trabajo." AND UPPER(ESTADO_TP) IN ('ANULADO', 'RECHAZADO', 'CANCELADO', 'PENDIENTE INFO') AND CORREO_ENVIADO = 0";
		$query = sqlsrv_query( $conn, $tsql);
		sqlsrv_close( $conn);
	}
	elseif (strtoupper($estado)=="PENDIENTE INFO") {
		$cuerpo = '<html><head><title>Solicitud de información</title></head><body><h1 style="font-size: 11px;color: #ED7D31;font-weight: bold;font-family: "Calibri",sans-serif;">GESTION DE TRABAJOS SSR</h1>';
		$cuerpo .='<p style="color: #595959;font-size: 11px;font-family: "Calibri",sans-serif;">El trabajo solicitado con el <b style="color: #404040;font-size: 11px;font-family: "Calibri",sans-serif;font-weight: bold;">IDENTIFICADOR '.$identificador.'</b> dado de alta el día <b style="color: #404040;font-size: 11px;font-family: "Calibri",sans-serif;font-weight: bold;>'.$alta.'</b> por el usuario <b style="color: #404040;font-size: 11px;font-family: "Calibri",sans-serif;font-weight: bold;>'.$nombre.'</b> ha cambiado al estado <b style="color: #404040;font-size: 11px;font-family: "Calibri",sans-serif;font-weight: bold;>PENDIENTE INFO.</b></p>';
		$cuerpo .='<p style="color: #595959;font-size: 11px;font-family: "Calibri",sans-serif;">Acción realizada por <b style="color: #404040;font-size: 11px;font-family: "Calibri",sans-serif;font-weight: bold;">'.$usu_accion.'</b></p>';
		$cuerpo .='<b style="color: #404040;font-size: 11px;font-family: "Calibri",sans-serif;font-weight: bold;">OBSERVACIONES REALIZADAS:</b><br><p style="color: #595959;font-size: 11px;font-family: "Calibri",sans-serif;">'.$observaciones.'</p></body></html>';
		$headers = "MIME-Version: 1.0\r\n"; 
		$headers .= "Content-type: text/html; charset=UTF-8\r\n"; 
		$headers .= "From: Notificación de solicitudes <ssr@jazztel.com>\r\n"; 
		$headers .= "Return-path: ".$email."\r\n"; 
		$headers .= "Cc: daniel.coronel@jazztel.com\r\n"; 
		mail($email,$asunto,$cuerpo,$headers); 
		$tsql = "UPDATE TBHISTORICO_TRABAJOS SET CORREO_ENVIADO = 1 WHERE COD_TRABAJO = ".$cod_trabajo." AND UPPER(ESTADO_TP) IN ('ANULADO', 'RECHAZADO', 'CANCELADO', 'PENDIENTE INFO') AND CORREO_ENVIADO = 0";
		$query = sqlsrv_query( $conn, $tsql);
		sqlsrv_close( $conn);
	} 
}

function Envio_Aceptado() {
	$asunto = "NOTIFICACIÓN DE SOLICITUDES DE TRABAJOS ACEPTADOS";
	$tsql = "SELECT TBUSUARIOS.COD_USUARIO, 
					TBUSUARIOS.NOMBRE_COMPLETO, 
					TBUSUARIOS.EMAIL 
			FROM (TBUSUARIOS INNER JOIN TBTRABAJOS_SOLICITADOS ON TBUSUARIOS.COD_USUARIO = TBTRABAJOS_SOLICITADOS.COD_USUARIO_CARGA) INNER JOIN TBHISTORICO_TRABAJOS ON tbTrabajos_Solicitados.COD_TRABAJO = TBHISTORICO_TRABAJOS.COD_TRABAJO WHERE TBHISTORICO_TRABAJOS.ESTADO_TP = 'Aceptado' AND TBHISTORICO_TRABAJOS.CORREO_ENVIADO IS NULL GROUP BY TBUSUARIOS.COD_USUARIO, TBUSUARIOS.NOMBRE_COMPLETO, TBUSUARIOS.EMAIL";
	$conn=conectar_bd();
	$query = sqlsrv_query( $conn, $tsql);
	if( $query === false ){
		die ("Error al ejecutar consulta");
	}
	while($row = sqlsrv_fetch_array($query)){
		$codusuario = $row['COD_USUARIO'];
		$nombre = $row['NOMBRE_COMPLETO'];
		$email= $row['EMAIL'];
		$tsql2 = "SELECT tbTrabajos_Solicitados.COD_TRABAJO,
				   tbTrabajos_Solicitados.IDENTIFICADOR,
				   tbTrabajos_Revisados.REMEDY as remedy,
				   tbHistorico_Trabajos.FX_OPERACION,
				   tbProvincias.DESCRIPCION as provincia,
				   tbCentrales.DESCRIPCION as central,
				   tbTrabajos_Solicitados.CAMARA_FRONTERA as cr,
				   tbEmpresas.DESCRIPCION as empresa,
				   convert(char,tbTrabajos_Revisados.FX_APROBADA_INICIO,103) as fechaini,
				   convert(char,tbTrabajos_Revisados.FX_APROBADA_INICIO,108) as horaini,
				   convert(char,tbTrabajos_Revisados.FX_APROBADA_FIN,103) as fechafin,
				   convert(char,tbTrabajos_Revisados.FX_APROBADA_FIN,108) as horafin,
				   datepart(iso_week,tbTrabajos_Revisados.FX_APROBADA_INICIO) as semana 
			FROM tbTrabajos_Solicitados 
			INNER JOIN tbHistorico_Trabajos ON tbTrabajos_Solicitados.COD_TRABAJO = tbHistorico_Trabajos.COD_TRABAJO
			INNER JOIN tbTrabajos_Revisados ON tbTrabajos_Solicitados.COD_TRABAJO = tbTrabajos_Revisados.COD_TRABAJO
			INNER JOIN tbEmpresas ON tbTrabajos_Solicitados.COD_EMPRESA = tbEmpresas.COD_EMPRESA 
			INNER JOIN tbCentrales ON tbTrabajos_Solicitados.COD_CENTRAL = tbCentrales.COD_CENTRAL
			INNER JOIN tbProvincias ON tbCentrales.COD_PROVINCIA = tbProvincias.COD_PROVINCIA   
			WHERE tbHistorico_Trabajos.ESTADO_TP = 'Aceptado' AND tbHistorico_Trabajos.CORREO_ENVIADO IS NULL AND tbTrabajos_Solicitados.COD_USUARIO_CARGA = ".$codusuario." ";
		$query2=sqlsrv_query($conn, $tsql2);
		$cuerpo = '<html><head><title>NOTIFICACIÓN DE SOLICITUDES ACEPTADAS</title></head><body><h1 style="font-size: 14px;color: #ED7D31;font-weight: bold;font-family: "Calibri",sans-serif;">GESTION DE TRABAJOS SSR</h1>';
		$cuerpo .='<p style="color: #595959;font-size: 11px;font-family: "Calibri",sans-serif;">A continuación se listan las solicitudes de trabajos aceptadas</p>';
		while($row2 = sqlsrv_fetch_array($query2)){
			$cuerpo=$cuerpo.'<p style="color: #595959;font-size: 11px;font-family: "Calibri",sans-serif;"><b style="color: #404040;font-size: 11px;font-family: "Calibri",sans-serif;font-weight: bold;">Trabajo Aceptado IDENTIFICADOR:'.$row2["IDENTIFICADOR"].'</b></p>';
			$cuerpo=$cuerpo.'<p style="color: #595959;font-size: 11px;font-family: "Calibri",sans-serif;">Remedy:'.$row2["remedy"].'</p>';
			$cuerpo=$cuerpo.'<p style="color: #595959;font-size: 11px;font-family: "Calibri",sans-serif;">Provincia:'.$row2["provincia"].'</p>';
			$cuerpo=$cuerpo.'<p style="color: #595959;font-size: 11px;font-family: "Calibri",sans-serif;">Central:'.$row2["central"].'</p>';
			$cuerpo=$cuerpo.'<p style="color: #595959;font-size: 11px;font-family: "Calibri",sans-serif;">Cámara registro:'.$row2["cr"].'</p>';
			$cuerpo=$cuerpo.'<p style="color: #595959;font-size: 11px;font-family: "Calibri",sans-serif;">Empresa mantenedora:'.$row2["empresa"].'</p>';
			$cuerpo=$cuerpo.'<p style="color: #595959;font-size: 11px;font-family: "Calibri",sans-serif;">Semana:'.$row2["semana"].'</p>';
			$cuerpo=$cuerpo.'<p style="color: #595959;font-size: 11px;font-family: "Calibri",sans-serif;">Fecha de inicio aprobada:'.$row2["fechaini"].'</p>';
			$cuerpo=$cuerpo.'<p style="color: #595959;font-size: 11px;font-family: "Calibri",sans-serif;">Hora de inicio aprobada:'.$row2["horaini"].'</p>';
			$cuerpo=$cuerpo.'<p style="color: #595959;font-size: 11px;font-family: "Calibri",sans-serif;">Fecha fin aprobada:'.$row2["fechafin"].'</p>';
			$cuerpo=$cuerpo.'<p style="color: #595959;font-size: 11px;font-family: "Calibri",sans-serif;">Hora fin aprobada:'.$row2["horafin"].'</p>';
			$cuerpo=$cuerpo.'<p style="color: #595959;font-size: 11px;font-family: "Calibri",sans-serif;"><a href="http://10.118.247.229/trabajos_programados/functions/genera_pdf.php?jobcode='.$row2['COD_TRABAJO'].'" target="_blank">Descargar PDF del trabajo</a></p><br>';
			$update = "UPDATE tbHistorico_Trabajos SET CORREO_ENVIADO = 1, COD_USUARIO = ".$_SESSION['privi']." WHERE COD_TRABAJO = ".$row2['COD_TRABAJO']." AND ESTADO_TP = 'Aceptado' AND CORREO_ENVIADO IS NULL";
			$query3 = sqlsrv_query($conn,$update) or die ('fallo al intentar actualizar el historico'.$update);
		}
		$cuerpo.= '</body></html>';
		sqlsrv_free_stmt( $query2);
		$headers = "MIME-Version: 1.0\r\n"; 
		$headers .= "Content-type: text/html; charset=UTF-8\r\n"; 
		$headers .= "From: SSR <ssr@jazztel.com>\r\n";
		$headers .= "Cc: daniel.coronel@jazztel.com\r\n"; 
		$headers .= "Return-path: ".$email."\r\n"; 
		mail($email,$asunto,$cuerpo,$headers);
	}
	sqlsrv_free_stmt( $query);
	sqlsrv_free_stmt( $query2);
	sqlsrv_free_stmt( $query3);
	header('Location: http://10.118.247.229/trabajos_programados/index.php?view=7');
}

//Envio_Aceptado();

//echo getIdent(19);

?>
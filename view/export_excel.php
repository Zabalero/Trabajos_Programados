<?php 
session_start();
$nombreFichero = date('YmdHis');
$solicitud = $_GET['origen'];
header("Content-Disposition: attachment; filename=".$solicitud."_".$nombreFichero.".xls");
header("Content-Type: application/vnd.ms-excel");
?>
<html LANG="es">
<head>
<meta http-equiv=content-type content=text/html; charset= UTF-8> 
<title>GENERAR FICHERO EXCEL</title>
</head>
<body>

<?php
	include ('../functions/funciones.php');

	if ($solicitud === 'solicitudes') {
		print $_SESSION['excel_solicitudes'];
		unset($_SESSION['excel_solicitudes']);
	}
	if ($solicitud === 'ssr') {
		print $_SESSION['excel_ssr'];
		unset($_SESSION['excel_ssr']);
	}
	if ($solicitud === 'ejecucion') {
		print $_SESSION['excel_ejecucion'];
		unset($_SESSION['excel_ejecucion']);
	}
	if ($solicitud === 'cab') {
		print $_SESSION['excel_cab'];
		unset($_SESSION['excel_cab']);
	}
?>
</body>
</html>
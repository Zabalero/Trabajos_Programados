<?php
session_start();
include "funciones.php";
$conexion = conectar_bd();
$trabajo = $_POST['identificador_doc'];
$tsql_cod_trabajo = "SELECT COD_TRABAJO FROM tbTrabajos_Solicitados WHERE IDENTIFICADOR = '".$trabajo."'";
$query_cod_trabajo = sqlsrv_query($conexion,$tsql_cod_trabajo) or die ("Fallo al intentar obtener el codigo de trabajo");
while ($row = sqlsrv_fetch_array($query_cod_trabajo)) {
	$cod_trabajo = $row['COD_TRABAJO'];
}

$ds = DIRECTORY_SEPARATOR;
$storeFolder = '../docs/tps/'.$trabajo;

if (!file_exists($storeFolder)) {
	if(!mkdir($storeFolder, 0777, true)) {
	    die('Fallo al crear las carpetas...');
	}
}
if (!empty($_FILES) && (!empty($cod_trabajo) || !is_null($cod_trabajo) || $cod_trabajo != '')) {     
    $tempFile = $_FILES['file']['tmp_name'];
    $targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds;
    $targetFile =  $targetPath. $_FILES['file']['name'];
    move_uploaded_file($tempFile,$targetFile);
    $tsql_insert = "INSERT INTO tbDOC_TPS (NOMBRE,TIPO,EXTENSION,COD_TRABAJO,ID_SUARIO) VALUES ('".$_FILES['file']['name']."',2,'".$_FILES['file']['type']."',".$cod_trabajo.",".$_SESSION['privi'].")";
	$query_insert = sqlsrv_query($conexion,$tsql_insert);
}
sqlsrv_free_stmt($query_insert);
sqlsrv_free_stmt($query_cod_trabajo);
sqlsrv_close($conexion);
?>     
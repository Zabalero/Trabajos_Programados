<?php

function leer_fichero($archivo){

	error_reporting(E_ALL);
	set_time_limit(0);

	//date_default_timezone_set('Europe/London');
	/** Include path **/
	set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
	
	/** PHPExcel_IOFactory */
	include 'PHPExcel/IOFactory.php';

	//	$inputFileType = 'Excel5';
		$inputFileType = 'Excel2007';
	//	$inputFileType = 'Excel2003XML';
	//	$inputFileType = 'OOCalc';
	//	$inputFileType = 'Gnumeric';
	$inputFileName = $archivo;
	$sheetname = 'TP';


	class MyReadFilter implements PHPExcel_Reader_IReadFilter
	{
		private $_startRow = 0;

		private $_endRow = 0;

		private $_columns = array();

		public function __construct($startRow, $endRow, $columns) {
			$this->_startRow	= $startRow;
			$this->_endRow		= $endRow;
			$this->_columns		= $columns;
		}

		public function readCell($column, $row, $worksheetName = '') {
			if ($row >= $this->_startRow && $row <= $this->_endRow) {
				if (in_array($column,$this->_columns)) {
					return true;
				}
			}
			return false;
		}
	}

	$filterSubset = new MyReadFilter(1,36,range('A','H'));


	//echo 'Loading file ',pathinfo($inputFileName,PATHINFO_BASENAME),' using IOFactory with a defined reader type of ',$inputFileType,'<br />';
	$objReader = PHPExcel_IOFactory::createReader($inputFileType);
	//echo 'Loading Sheet "',$sheetname,'" only<br />';
	$objReader->setLoadSheetsOnly($sheetname);
	//echo 'Loading Sheet using configurable filter<br />';
	$objReader->setReadFilter($filterSubset);
	$objPHPExcel = $objReader->load($inputFileName);
	//$objPHPExcel->getSecurity()->setWorkbookPassword('');

	$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

	//var_dump($sheetData);
	//echo '<p><b>'.$sheetData);
	echo '<div id="content_result">';
		echo '<div id="apartado">';
		echo '<h2><b>'.$sheetData[5]['B'].'</b></h2>';
		echo '</div>';
		echo '<form name="solicitud_ssr" onsubmit="return validarSolicitud()" method="post" enctype="multipart/form-data" action="functions/process_solicitud.php?accion=insertar&org=1">';
		echo '<input type="hidden" name="vista" id="vista" value="'.$_SESSION['privi'].'" /> ';
		echo '<input type="hidden" name="perfil" id="perfil" value="'.$_SESSION['perfil'].'" /> ';
			echo '<div id="apartado">';
				echo '<div id="campo_left">';
				//echo '<p><b>'.$sheetData[6]['B'].'</b>: <input type="text" id="grupo_s" size ="50" name="grupo_s" value="'.$sheetData[6]['C'].'"/></p>';
				echo '<p><b>'.$sheetData[6]['B'].'</b>: ';

				echo '<select id="grupo_s" name="grupo_s">';
					echo '<option value="0"></option>';
					$conn=conectar_bd();
					$tsql="SELECT COD_GRUPO,UPPER(RTRIM(DESCRIPCION)) AS DESCRIPCION FROM tbGrupos";
					//Obtiene el resultado
					$query = sqlsrv_query( $conn, $tsql); 
					while($row = sqlsrv_fetch_array($query)){
						if (replace_specials_characters($row['DESCRIPCION']) != replace_specials_characters(rtrim(strtoupper($sheetData[6]['C'])))) {
					    	echo '<option value="'.$row['COD_GRUPO'].'">';
					    }
					    else {
					    	echo '<option value="'.$row['COD_GRUPO'].'" selected>';
					    }
					    echo $row['DESCRIPCION'];
					    echo '</option>';
					}
					sqlsrv_free_stmt( $stmt);
					sqlsrv_close( $conn);
					echo '</select>';                	
				echo '</div>';
				/*echo '<div id="campo_left">';
				echo '<p><b>'.$sheetData[6]['E'].'</b>: <input type="text" id="identificador" size ="20" name="identificador" value="'.$sheetData[6]['F'].'"/></p>';
				echo '</div>';*/
				echo '<div id="campo_left">';
				//echo '<p><b>'.$sheetData[7]['B'].'</b>: <input type="text" id="responsable" size ="50" name="responsable" value="'.$sheetData[7]['C'].'"/></p>';
					$conn=conectar_bd();
					$tsql="SELECT TOP 1 COD_RESPONSABLE,UPPER(RTRIM(NOMBRE_COMPLETO)) AS NOMBRE FROM tbResponsables WHERE UPPER(RTRIM(NOMBRE_COMPLETO)) LIKE UPPER(RTRIM('".$sheetData[7]['C']."%'))";
					$query = sqlsrv_query( $conn, $tsql);
					$tf = sqlsrv_has_rows($query);
					if ($tf === true) {
						$row=sqlsrv_fetch_array($query);
						echo '<input type="hidden" name="responsable" id="responsable" value="'.$row['COD_RESPONSABLE'].'" /> ';
						echo '<p><b>'.$sheetData[7]['B'].'</b>: <input type="text" id="des_responsable" size ="28" name="des_responsable" value="'.$row['NOMBRE'].'"/></p>';
						sqlsrv_free_stmt( $stmt);
						sqlsrv_close( $conn);
					}
					else {
						echo '<input type="hidden" name="responsable" id="responsable" value="" /> ';
						echo '<p><b>'.$sheetData[7]['B'].'</b>: <input type="text" id="des_responsable" size ="28" name="des_responsable" value="'.$sheetData[7]['C'].'"/></p>';
					}                
				echo '</div>';
				echo '<div id="campo_left">';
				echo '<p><b>'.$sheetData[7]['E'].'</b>: <input type="text" id="tlf_resp" size ="13" name="tlf_resp" value="'.$sheetData[7]['F'].'"/></p>';
				echo '</div>';
				echo '<div id="campo_right">';
				echo '<p><b>'.$sheetData[8]['B'].'</b>: ';
				echo '<select id="tipo_act" name="tipo_act">';
					echo '<option value="0"></option>';
					$conn=conectar_bd();
					$tsql="SELECT COD_TIPO_ACTUACION,UPPER(RTRIM(DESCRIPCION)) AS TIPO_ACT FROM tbTipos_Actuacion";
					//Obtiene el resultado
					$query = sqlsrv_query( $conn, $tsql); 
					while($row = sqlsrv_fetch_array($query)){
						if ($row['TIPO_ACT'] != rtrim(strtoupper($sheetData[8]['C']))) {
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
					echo '</select>';            
				echo '</div>';
				echo '<div id="campo_right">';
				//echo '<p><b>'.$sheetData[9]['B'].'</b>: <input type="text" id="provincia" size ="30" name="provincia" value="'.$sheetData[9]['C'].'"/></p>';
				echo '<p><b>'.$sheetData[9]['B'].'</b>: ';
				echo '<select id="provincia" disabled name="provincia">';
					echo '<option value="0"></option>';
					$conn=conectar_bd();
					$tsql="SELECT COD_PROVINCIA,UPPER(RTRIM(DESCRIPCION)) AS PROVINCIA FROM tbProvincias ORDER BY DESCRIPCION";
					//Obtiene el resultado
					$query = sqlsrv_query( $conn, $tsql); 
					while($row = sqlsrv_fetch_array($query)){
						if (replace_specials_characters($row['PROVINCIA']) != replace_specials_characters(rtrim(strtoupper($sheetData[9]['C'])))) {
					    	echo '<option value="'.$row['COD_PROVINCIA'].'">';
					    }
					    else {
					    	echo '<option value="'.$row['COD_PROVINCIA'].'" selected>';
					    }
					    echo $row['PROVINCIA'];
					    echo '</option>';
					}
					sqlsrv_free_stmt( $stmt);
					sqlsrv_close( $conn);
					echo '</select>';            
				echo '</div>';
				echo '<div id="campo_left">';
				//echo '<p><b>'.$sheetData[9]['D'].'</b>: <input type="text" id="central" size ="15" name="central" value="'.$sheetData[9]['E'].'"/></p>';
				echo '<p><b>'.$sheetData[9]['D'].'</b>: ';
				echo '<select id="central" name="central">';
					echo '<option value="0"></option>';
					$conn=conectar_bd();
					$tsql="SELECT COD_CENTRAL,UPPER(RTRIM(DESCRIPCION)) AS CENTRAL FROM tbCentrales ORDER BY DESCRIPCION";
					//Obtiene el resultado
					$query = sqlsrv_query( $conn, $tsql); 
					while($row = sqlsrv_fetch_array($query)){
						if (replace_specials_characters($row['CENTRAL']) != replace_specials_characters(rtrim(strtoupper($sheetData[9]['E'])))) {
					    	echo '<option value="'.$row['COD_CENTRAL'].'">';
					    }
					    else {
					    	echo '<option value="'.$row['COD_CENTRAL'].'" selected>';
					    }
					    echo $row['CENTRAL'];
					    echo '</option>';
					}
					sqlsrv_free_stmt( $stmt);
					sqlsrv_close( $conn);
					echo '</select>';            
				echo '</div>';
				echo '<div id="campo_left">';
				echo '<p><b>'.$sheetData[9]['F'].'</b>: <input type="text" id="cam_front" size ="28" name="cam_front" value="'.$sheetData[9]['G'].'"/></p>';
				echo '</div>';
				echo '<div id="campo_right">';
				//echo '<p><b>'.$sheetData[10]['B'].'</b>: <input type="text" id="empresa" size ="28" name="empresa" value="'.$sheetData[10]['C'].'"/></p>';
				echo '<p><b>'.$sheetData[10]['B'].'</b>: ';
				echo '<select id="empresa" name="empresa">';
					echo '<option value="0"></option>';
					$conn=conectar_bd();
					$tsql="SELECT COD_EMPRESA,UPPER(RTRIM(DESCRIPCION)) AS EMPRESA FROM tbEmpresas ORDER BY DESCRIPCION";
					//Obtiene el resultado
					$query = sqlsrv_query( $conn, $tsql); 
					while($row = sqlsrv_fetch_array($query)){
						if (replace_specials_characters($row['EMPRESA']) != replace_specials_characters(rtrim(strtoupper($sheetData[10]['C'])))) {
					    	echo '<option value="'.$row['COD_EMPRESA'].'">';
					    }
					    else {
					    	echo '<option value="'.$row['COD_EMPRESA'].'" selected>';
					    }
					    echo $row['EMPRESA'];
					    echo '</option>';
					}
					sqlsrv_free_stmt( $stmt);
					sqlsrv_close( $conn);
				echo '</select>';            
				echo '</div>';
				echo '<div id="campo_left">';
				//echo '<p><b>'.$sheetData[10]['D'].'</b>: <input type="text" id="tecnico" size ="20" name="tecnico" value="'.$sheetData[10]['E'].'"/></p>';
				$conn=conectar_bd();
				$tsql="SELECT TOP 1 COD_TECNICO,UPPER(RTRIM(NOMBRE)) AS NOMBRE FROM tbTecnicos WHERE UPPER(RTRIM(NOMBRE)) LIKE UPPER(RTRIM('".$sheetData[10]['E']."%')) ";
				$query = sqlsrv_query( $conn, $tsql);
				$tf = sqlsrv_has_rows($query);
				if ($tf === true) {
					$row=sqlsrv_fetch_array($query);
					echo '<input type="hidden" name="tecnico" id="tecnico" value="'.$row['COD_TECNICO'].'" /> ';
					echo '<p><b>'.$sheetData[10]['D'].'</b>: <input type="text" id="des_tecnico" size ="28" name="des_tecnico" value="'.$row['NOMBRE'].'"/></p>';
					sqlsrv_free_stmt( $stmt);
					sqlsrv_close( $conn);
				}
				else {
					echo '<input type="hidden" name="tecnico" id="tecnico" value="" /> ';
					echo '<p><b>'.$sheetData[10]['D'].'</b>: <input type="text" id="des_tecnico" size ="28" name="des_tecnico" value="'.$sheetData[10]['E'].'"/></p>';
				}    
				echo '</div>';
				echo '<div id="campo_left">';
				echo '<p><b>'.$sheetData[10]['F'].'</b>: <input type="text" id="tlf_tec" size ="13" name="tlf_tec" value="'.$sheetData[10]['G'].'"/></p>';
				echo '</div>';
				echo '<div id="campo_right">';
				echo '<p><b>'.$sheetData[11]['B'].'</b>: <input type="text" id="fechaini" readOnly name="fechaini" value="'.fechaBuena($sheetData[11]['C']).'"/></p>';
				echo '</div>';
				echo '<div id="campo_left">';
				echo '<p><b>'.$sheetData[11]['E'].'</b>: <input type="text" id="fechafin" readOnly name="fechafin" value="'.fechaBuena($sheetData[11]['F']).'"/></p>';
				echo '</div>';
			echo '</div>';
			echo '<div id="apartado">';
			echo '<h2><b>'.$sheetData[13]['B'].'</b></h2>';
			echo '</div>';
			echo '<div id="campo_left">';
			echo '<p><textarea name="proyecto" cols=130 rows=10 id="proyecto">'.$sheetData[15]['B'].'</textarea></p>';
			echo '</div>';
			echo '<div id="apartado">';
			echo '<h2><b>'.$sheetData[17]['B'].'</b></h2>';
			echo '</div>';
			echo '<div id="campo_left">';
			echo '<p><textarea name="descripcion" cols=130 rows=15 id="descripcion">'.$sheetData[19]['B'].'</textarea></p>';
			echo '</div>';
			echo '<div id="apartado">';
			echo '<h2><b>'.$sheetData[21]['B'].'</b></h2>';
			echo '</div>';
			echo '<div id="apartado">';
				echo '<div id="campo_left">';
				//echo '<p><b>'.$sheetData[23]['B'].'</b>: <input type="text" id="encuesta1" size ="10" name="encuesta1" value="'.$sheetData[23]['D'].'"/></p>';
				echo '<p><b>'.$sheetData[23]['B'].'</b>: ';
				echo '<select id="encuesta1" name="encuesta1">';
					echo '<option value="0"></option>';
					$conn=conectar_bd();
					$tsql="SELECT COD_UBICACION,UPPER(RTRIM(DESCRIPCION)) AS UBICA FROM tbUbicaciones";
					//Obtiene el resultado
					$query = sqlsrv_query( $conn, $tsql); 
					while($row = sqlsrv_fetch_array($query)){
						if (replace_specials_characters($row['UBICA']) != replace_specials_characters(rtrim(strtoupper($sheetData[23]['D'])))) {
					    	echo '<option value="'.$row['COD_UBICACION'].'">';
					    }
					    else {
					    	echo '<option value="'.$row['COD_UBICACION'].'" selected>';
					    }
					    echo $row['UBICA'];
					    echo '</option>';
					}
					sqlsrv_free_stmt( $stmt);
					sqlsrv_close( $conn);
					echo '</select>';    
				echo '</div>';
				echo '<div id="campo_left">';
				//echo '<p><b>'.$sheetData[24]['B'].'</b>: <input type="text" id="encuesta2" size ="2" name="encuesta2" value="'.$sheetData[24]['D'].'"/></p>';
				echo '<p><b>'.$sheetData[24]['B'].'</b>: ';
				echo '<select name="encuesta2">';
					if (strtoupper(rtrim($sheetData[24]['D'])) === 'SI') {
						echo '<option value="1" selected>SI</option>';
						echo '<option value="0">NO</option>';
					}
					if (strtoupper(rtrim($sheetData[24]['D'])) === 'NO'){
						echo '<option value="0" selected>NO</option>';
						echo '<option value="1">SI</option>';
					}
					if (!isset($sheetData[24]['D'])) {
						echo '<option value="1">SI</option>';
						echo '<option value="0">NO</option>';
					}
					echo '</select>';
				echo '</div>';
				echo '<div id="campo_left">';
				//echo '<p><b>'.$sheetData[25]['B'].'</b>: <input type="text" id="encuesta3" size ="2" name="encuesta3" value="'.$sheetData[25]['D'].'"/></p>';
				echo '<p><b>'.$sheetData[25]['B'].'</b>: ';
				echo '<select name="encuesta3">';
					if (strtoupper(rtrim($sheetData[25]['D'])) === 'SI') {
						echo '<option value="1" selected>SI</option>';
						echo '<option value="0">NO</option>';
					}
					if (strtoupper(rtrim($sheetData[25]['D'])) === 'NO'){
						echo '<option value="0" selected>NO</option>';
						echo '<option value="1">SI</option>';
					}
					if (!isset($sheetData[25]['D'])) {
						echo '<option value="1">SI</option>';
						echo '<option value="0">NO</option>';
					}
					echo '</select>';
				echo '</div>';
				echo '<div id="campo_left">';
				//echo '<p><b>'.$sheetData[26]['B'].'</b>: <input type="text" id="encuesta4" size ="2" name="encuesta4" value="'.$sheetData[26]['D'].'"/></p>';
				echo '<p><b>'.$sheetData[26]['B'].'</b>: ';
				echo '<select name="encuesta4">';
					if (strtoupper(rtrim($sheetData[26]['D'])) === 'SI') {
						echo '<option value="1" selected>SI</option>';
						echo '<option value="0">NO</option>';
					}
					if (strtoupper(rtrim($sheetData[26]['D'])) === 'NO'){
						echo '<option value="0" selected>NO</option>';
						echo '<option value="1">SI</option>';
					}
					if (!isset($sheetData[26]['D'])) {
						echo '<option value="1">SI</option>';
						echo '<option value="0">NO</option>';
					}
					echo '</select>';
				echo '</div>';
				echo '<div id="campo_left">';
				//echo '<p><b>'.$sheetData[27]['B'].'</b>: <input type="text" id="encuesta5" size ="2" name="encuesta5" value="'.$sheetData[27]['D'].'"/></p>';
				echo '<p><b>'.$sheetData[27]['B'].'</b>: ';
				echo '<select name="encuesta5">';
					if (strtoupper(rtrim($sheetData[27]['D'])) === 'SI') {
						echo '<option value="1" selected>SI</option>';
						echo '<option value="0">NO</option>';
					}
					if (strtoupper(rtrim($sheetData[27]['D'])) === 'NO'){
						echo '<option value="0" selected>NO</option>';
						echo '<option value="1">SI</option>';
					}
					if (!isset($sheetData[27]['D'])) {
						echo '<option value="1">SI</option>';
						echo '<option value="0">NO</option>';
					}
					echo '</select>';
				echo '</div>';
			echo '</div>';
			/*echo '<div id="apartado">';
			echo '<h2><b>'.$sheetData[29]['B'].'</b></h2>';
			echo '</div>';
			echo '<div id="campo_left">';
			echo '<p><textarea name="observaciones" cols=130 rows=15 id="observaciones">'.$sheetData[31]['B'].'</textarea></p>';
			echo '</div>';
			echo '<div id="apartado">';
			echo '<h2><b>'.$sheetData[33]['B'].'</b></h2>';
			echo '</div>';
			echo '<div id="apartado">';
				echo '<div id="campo_left">';
				echo '<p><b>'.$sheetData[35]['B'].'</b>: <input type="date-local" id="fechaini2" name="fechaini2" value="'.fechaSolicitud($sheetData[35]['C']).'"/></p>';
				echo '</div>';
				echo '<div id="campo_left">';
				echo '<p><b>'.$sheetData[35]['E'].'</b>: <input type="date-local" id="fechafin2" name="fechafin2" value="'.fechaSolicitud($sheetData[35]['F']).'"/></p>';
				echo '</div>';
			echo '</div>';*/
			echo '<div id="cont_tools">';
				echo '<div id="controles">';
					echo '<input class="boton_guardar" type="submit" name="submitButtonName" value="">';
					echo '<div id="txt_btn">';
						echo '<p id="label_btn">GUARDAR</p>';
					echo '</div>';
				echo '</div>';
				echo '<div id="controles">';
					echo '<input class="boton_cancelar" onclick="location.href=&quot;index.php?view=1&quot;" name="submitButtonName" value="">';
					echo '<div id="txt_btn">';
						echo '<p id="label_btn">CANCELAR</p>';
					echo '</div>';
				echo '</div>';
			echo '</div>';
		echo '</form>';
		echo '<div id="blanco"></div>'; 
	echo '</div>';
	//}
	/*else {
		echo '<div id="content_result">';
			echo '<h1><img src="images/ico/warning45.png" /> No se encontraron datos en el fichero seleccionado o faltan datos por ingresar para procesar la solicitud</h1><br><br><h2>Por favor revise el fichero de solicitud y complete los datos que faltan</h2>';
		echo '</div>';
	}*/

//despues de tener mi array realizo un inserte en la tabla de solicitudes

//despues de esto tendre que redireccionar a una view que muestre los resultados de la insercion del registro procesado de forma grafica con un boton de grabar o eliminar, si hacen clic en eliminar ejecutare query para borrar el registro respectivo

//Despues de esto redirecciono a la pantalla de consulta de solicitudes
}
?>
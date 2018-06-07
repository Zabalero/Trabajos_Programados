<?php
	//include "../functions/funciones.php";

	$trabajo = '123456';

	function crearDirectorios($trabajo) {
		$home_directory = 'docs/tps/';
		$dir_name = $home_directory.$trabajo;
		if (!file_exists($dir_name)) {
			if(!mkdir($dir_name, 0777, true)) {
			    die('Fallo al crear las carpetas...');
			}
		} else {
			$dir_name = 'ya existe';
		}
		return $dir_name;
	}

	echo crearDirectorios($trabajo);
?>
<?php 
print_r('<div id="content_result">');
	echo '<h1>REGISTRO DE SOLICITUDES</h1>';
	echo '<form enctype="multipart/form-data" method="post" action="result.php">';
		echo '<input type="file" name="file" id="file" />';
		echo '<br>';
		echo '<br>';
		echo '<input type="submit" value="Procesar"/> ';
	echo '</form>';
echo '</div>';
?>
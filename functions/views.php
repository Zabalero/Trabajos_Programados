<?php
include_once ('funciones.php');

function ask_view($open_view){

	if(es_usuario($_SESSION['usuario'],$_SESSION['password'])){
		switch ($open_view) {
					case 1://VISTA PARA CARGAR FICHEROS EXCEL DE SOLICITUDES
						echo '<link rel="stylesheet" type="text/css" href="css/smoothness/jquery-ui-1.8.16.custom.css"/>';
						echo '<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>';
						echo '<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>';
						echo '<script type="text/javascript" src="js/js.js"></script>';
						//fancybox
						//echo '<script type="text/javascript" src="fancybox/lib/jquery-1.10.1.min.js"></script>';
						echo '<script type="text/javascript" src="fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>';
						echo '<script type="text/javascript" src="fancybox/source/jquery.fancybox.js?v=2.1.5"></script>';
						echo '<link rel="stylesheet" type="text/css" href="fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />';
						echo '<link rel="stylesheet" type="text/css" href="fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" />';
						echo '<script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>';
						echo '<link rel="stylesheet" type="text/css" href="fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />';
						echo '<script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>';
						echo '<script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>';
						//-----
						echo '<div id="content_result">';
							echo '<h1>REGISTRO DE SOLICITUDES</h1>';
							echo '<h1>Para registrar una nueva solicitud puede hacerlos mediante la carga de un fichero Excel o puede llenar el formulario de solicitud on-line</h1>';
							echo '<div>';
							echo '<br>';
							echo '<p>Para seleccionar un fichero de "Solicitud de Trabajo" haga clic en el boton "Seleccionar archivo y luego en procesar"</p>';
							echo '<br>';
							echo '<form enctype="multipart/form-data" method="post" action="result.php">';
								echo '<input type="file" name="file" id="file" />';
								echo '<br>';
								echo '<br>';
								echo '<input type="submit" id="btnn" value="Procesar"/> ';
							echo '</form>';
							echo '</div>';
							echo '<div>';
							echo '<br>';
							echo '<p>Para llenar el formulario on-line haga clic en el boton "on-line"</p>';
							echo '<a href="forms/consulta_solicitud.php?accion=insertar" class="fancybox fancybox.iframe">';
									echo '<div id="controles">';
										echo '<img src="images/ico/add20.png" />';
										echo '<div id="txt_btn">';
										echo '<p id="label_btn">on-line</p>';
									echo '</div>';
							echo '</a>';
							echo '</div>';
						echo '</div>';
						/*CODIGO HTML PARA MOSTRAR EN LA PAGINA
						echo '<form method="post" action="dump.php">';
							echo '<h1>CARGA DE SOLICITUDES</h1>';
							echo '<p></p>';
							echo '<div style="float: left; margin-right: 20px">';
								echo '<h3></h3>';
								echo '<div id="html5_uploader" style="width: 800px; height: 630px;">Your browser  support native upload.</div>';
							echo '</div>';
							echo '<br style="clear: both" />';
						echo '</form>';
						CODIGO HTML PARA MOSTRAR EN LA PAGINA */
						break; 
					case 2://VISTA PARA REVISION Y CONSULTA DE SOICITUDES PENDIENTES
						echo '<link rel="stylesheet" type="text/css" href="css/smoothness/jquery-ui-1.8.16.custom.css"/>';
						echo '<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>';
						echo '<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>';
						echo '<script type="text/javascript" src="js/js.js"></script>';
						//fancybox
						//echo '<script type="text/javascript" src="fancybox/lib/jquery-1.10.1.min.js"></script>';
						echo '<script type="text/javascript" src="fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>';
						echo '<script type="text/javascript" src="fancybox/source/jquery.fancybox.js?v=2.1.5"></script>';
						echo '<link rel="stylesheet" type="text/css" href="fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />';
						echo '<link rel="stylesheet" type="text/css" href="fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" />';
						echo '<script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>';
						echo '<link rel="stylesheet" type="text/css" href="fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />';
						echo '<script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>';
						echo '<script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>';
						//--------
						echo '<div id="content_result">';
						echo '<h1>NUEVAS SOLICITUDES</h1>';
						echo '<div class="filtro">';
				        	echo '<form id="frm_filtro" method="post" action="">';
				        		echo '<input type="hidden" name="vista" id="vista" value="'.$_SESSION['privi'].'" /> ';
				        		echo '<input type="hidden" name="perfil" id="perfil" value="'.$_SESSION['perfil'].'" /> ';
				        		echo '<input type="hidden" name="provincias_usu" id="provincias_usu" value="'.$_SESSION['provincias'].'" /> ';
				                echo '<label>Fecha env. desde</label> ';
				                echo '<input type="text" name="del" id="del" size="8" class="datepicker" /> ';
				                echo 'Hasta ';
				                echo '<input type="text" name="al" id="al" size="8" class="datepicker" />';
				                echo '<label>&nbsp;&nbsp;Remedy:</label> <input type="text" name="REMEDY" size="11" />';
				                echo '<label>&nbsp;&nbsp;Identificador:</label> <input type="text" name="IDENT" size="11" />';
				                echo '<label>&nbsp;&nbsp;CR:</label> <input type="text" name="cr" size="11" />';
				                echo '<label>&nbsp;&nbsp;Nº Semana:</label><input type="text" name="week" size="1" /><br><br>';
				                echo '<label>Estado:</label>';
				                echo '<select name="estados">';
				                	echo '<option value="Seleccionar"></option>';
				                    $conn=conectar_bd();
				                    $tsql="SELECT distinct(ESTADO_TP) AS ESTADOS FROM tbTrabajos_Solicitados order by ESTADO_TP";
									//Obtiene el resultado
									$query = sqlsrv_query( $conn, $tsql); 
				                    while($row = sqlsrv_fetch_array($query)){
				                        echo '<option value="'.$row['ESTADOS'].'">';
				                        echo $row['ESTADOS'];
				                        echo '</option>';
				                    }
				                    sqlsrv_free_stmt( $stmt);
									sqlsrv_close( $conn);
				                echo '</select>';   
				                echo '<label>&nbsp;&nbsp;Provincia:</label>';
				                echo '<select name="provincias">';
				                	echo '<option value="0">--</option>';
				                    $conn=conectar_bd();
				                    $tsql="SELECT * FROM tbProvincias";
									//Obtiene el resultado
									$query = sqlsrv_query( $conn, $tsql); 
				                    while($row = sqlsrv_fetch_array($query)){
				                    	echo '<option value="'.$row['COD_PROVINCIA'].'">';
				                        echo $row['DESCRIPCION'];
				                        echo '</option>';
				                    }
				                    sqlsrv_free_stmt( $stmt);
									sqlsrv_close( $conn);
				                echo '</select>';             
				                echo '<label>&nbsp;&nbsp;Central:</label>';
				                echo '<select name="centrales">';
				                    echo '<option value="0">--</option>';
				                    $conn=conectar_bd();
				                    $tsql="SELECT * FROM tbCentrales WHERE DESCRIPCION <> '' ORDER BY DESCRIPCION";
									//Obtiene el resultado
									$query = sqlsrv_query( $conn, $tsql); 
				                    while($row = sqlsrv_fetch_array($query)){
				                        echo '<option value="'.$row['COD_CENTRAL'].'">';
				                        echo $row['DESCRIPCION'];
				                        echo '</option>';
				                    }
				                    sqlsrv_free_stmt( $stmt);
									sqlsrv_close( $conn);
				                echo '</select>';      
				                if ($_SESSION['perfil'] != 3){
				                    echo '<label>&nbsp;&nbsp;Empresa:</label>';
				                    echo '<select name="empresas">';
				                        echo '<option value="0">--</option>';
				                        $conn=conectar_bd();
				                        $tsql="SELECT * FROM tbEmpresas WHERE DESCRIPCION <> '' ORDER BY DESCRIPCION";
										//Obtiene el resultado
										$query = sqlsrv_query( $conn, $tsql); 
				                        while($row = sqlsrv_fetch_array($query)){
				                            echo '<option value="'.$row['COD_EMPRESA'].'">';
				                            echo $row['DESCRIPCION'];
				                            echo '</option>';
				                        }
				                        sqlsrv_free_stmt( $stmt);
										sqlsrv_close( $conn);
				                    echo '</select>';
				                }
				                echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" id="btnfiltrar">Filtrar</button>';
				                echo '&nbsp;&nbsp;<button type="button" id="btncancel">Todos</button>';
				                echo '&nbsp;&nbsp;<button type="submit" onclick = "this.form.action = &#39;view/export_excel.php?origen=solicitudes&#39;" id="btnExcel">Exportar Excel</button>';
				                if ($_SESSION['privi'] == 2) {
				                	echo '<a href="functions/process_solicitud.php?accion=test" target="_blank">Prueba</a>';
				                }
				            echo '</form>';
				        echo '</div>';
				        echo '<table cellpadding="0" cellspacing="0" id="data">';
				        	echo '<thead>';
				            	echo '<tr>';
					            	if ($_SESSION['perfil'] != 3 && $_SESSION['perfil'] != 6 && $_SESSION['perfil'] != 5){ //si el perfil es distinto de regional
					            		echo '<th width="8%"><span title="asignar">Asig.</span></th>';
					            		echo '<th width="8%"><span title="prioridad">Prior.</span></th>';
					            		echo '<th width="15%"><span title="solicita">Solicita</span></th>';
					                    echo '<th width="22%"><span title="fechaini_pro">Fecha inicio prop.</span></th>';
					                    echo '<th width="22%"><span title="fechafin_pro">Fecha fin prop.</span></th>';
					                    echo '<th width="8%"><span title="semanapro">Sem.</span></th>';
					                    echo '<th width="30%"><span title="provincia">Provincia</span></th>';
					                    echo '<th width="30%"><span title="central">Central</span></th>';
					                    echo '<th><span title="camara">Cámara front.</span></th>';			                 
					                    echo '<th width="16"><span title="identificador">Identificador</span></th>';
					                    echo '<th width="8%"><span title="remedy">Remedy</span></th>';
					                    echo '<th width="8%"><span title="estado">Estado</span></th>';
					                    echo '<th width="16"><span title="ver">Ver</span></th>';
					                    if ($_SESSION['perfil'] == 1) {
					                    	echo '<th width="16"><span title="modificar">Mod.</span></th>';
					                	}
					                    echo '<th width="16"><span title=""></span></th>';
					                    /*echo '<th width="16"><span title="eliminar">Canc.</span></th>';*/
					            	}
					            	if ($_SESSION['perfil'] ==3 || $_SESSION['perfil'] == 5 || $_SESSION['perfil'] == 6) { //si el perfil es regional
					            		echo '<th width="15%"><span title="solicita">Solicita</span></th>';
					                    echo '<th width="8%"><span title="fechaenv">Fecha envio</span></th>';
					                    echo '<th width="20%"><span title="identificador">Identificador</span></th>';
					                    echo '<th width="20%"><span title="remedy">Remedy</span></th>';
					                    echo '<th width="30%"><span title="provincia">Provincia</span></th>';
					                    if ($_SESSION['perfil'] ==6) {
					                		echo '<th width="16"><span title="emp">Empresa</span></th>';
					                	}
					                    echo '<th width="30%"><span title="central">Central</span></th>';
					                    echo '<th><span title="camara">Cámara front.</span></th>';			                 
					                    echo '<th width="16"><span title="estado">Est.</span></th>';
					                    echo '<th width="15%"><span title="fechaini">Fecha inicio apro.</span></th>';
					                    echo '<th width="15%"><span title="fechafin">Fecha fin apro.</span></th>';
					                    echo '<th width="8%"><span title="semana">Semana</span></th>';
					                    echo '<th width="16"><span title="ver">Ver</span></th>';
					                    if ($_SESSION['perfil'] ==3 || $_SESSION['perfil'] == 5) {
					                    echo '<th width="16"><span title="modificar">Mod.</span></th>';
					                    echo '<th width="16"><span title="eliminar">Canc.</span></th>';
					                	}
					                	echo '<th width="16"><span title=""></span></th>'; 
				                	}
				                echo '</tr>';
				            echo '</thead>';
				            echo '<tbody>';
				            echo '</tbody>';
				        echo '</table>';
						echo '</div>';
						break;
					case 3://VISTA PARA REVISION Y CONSULTA DE SOLICITUDES ASIGNADAS
						echo '<link rel="stylesheet" type="text/css" href="css/smoothness/jquery-ui-1.8.16.custom.css"/>';
						echo '<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>';
						echo '<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>';
						echo '<script type="text/javascript" src="js/js.js"></script>';
						//fancybox
						//echo '<script type="text/javascript" src="fancybox/lib/jquery-1.10.1.min.js"></script>';
						echo '<script type="text/javascript" src="fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>';
						echo '<script type="text/javascript" src="fancybox/source/jquery.fancybox.js?v=2.1.5"></script>';
						echo '<link rel="stylesheet" type="text/css" href="fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />';
						echo '<link rel="stylesheet" type="text/css" href="fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" />';
						echo '<script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>';
						echo '<link rel="stylesheet" type="text/css" href="fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />';
						echo '<script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>';
						echo '<script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>';
						//--------
						echo '<div id="content_result">';
						echo '<h1>SOLICITUDES ASIGNADAS</h1>';
						echo '<div class="filtro">';
				        	echo '<form id="frm_filtro_ssr" method="post" action="">';
				        	echo '<input type="hidden" name="vista" id="vista" value="'.$_SESSION['privi'].'" /> ';
				        	echo '<input type="hidden" name="perfil" id="perfil" value="'.$_SESSION['perfil'].'" /> ';
				            echo '<label>Fecha registro desde</label> ';
				            echo '<input type="text" name="del" id="del" size="8" class="datepicker" /> ';
				            echo 'Hasta ';
				            echo '<input type="text" name="al" id="al" size="8" class="datepicker" />';
				            echo '<label>&nbsp;&nbsp;Remedy:</label> <input type="text" name="REMEDY" size="11" />';
				            echo '<label>&nbsp;&nbsp;Identificador:</label> <input type="text" name="IDENT" size="11" />';
				            echo '<label>&nbsp;&nbsp;CR:</label> <input type="text" name="cr" size="11" /><br><br>';
				            echo '<label>Estado:</label>';
				            echo '<select name="estados">';
				                echo '<option value="Seleccionar"></option>';
				                $conn=conectar_bd();
				                $tsql="SELECT distinct(ESTADO_TP) AS ESTADOS FROM tbTrabajos_Solicitados order by ESTADO_TP";
								//Obtiene el resultado
								$query = sqlsrv_query( $conn, $tsql); 
				                while($row = sqlsrv_fetch_array($query)){
				                    echo '<option value="'.$row['ESTADOS'].'">';
				                    echo $row['ESTADOS'];
				                    echo '</option>';
				                }
				                sqlsrv_free_stmt( $stmt);
								sqlsrv_close( $conn);
				            echo '</select>';
				            echo '<label>&nbsp;&nbsp;Provincia:</label>';
				            echo '<select name="provincias">';
				            	echo '<option value="0">--</option>';
				                $conn=conectar_bd();
				                $tsql="SELECT * FROM tbProvincias";
								//Obtiene el resultado
								$query = sqlsrv_query( $conn, $tsql); 
				                while($row = sqlsrv_fetch_array($query)){
				                    echo '<option value="'.$row['COD_PROVINCIA'].'">';
				                    echo $row['DESCRIPCION'];
				                    echo '</option>';
				                }
				                sqlsrv_free_stmt( $stmt);
								sqlsrv_close( $conn);
				                echo '</select>';                	
				                echo '<label>&nbsp;&nbsp;Central:</label>';
				                echo '<select name="centrales">';
				                    echo '<option value="0">--</option>';
				                    $conn=conectar_bd();
				                    $tsql="SELECT * FROM tbCentrales WHERE DESCRIPCION <> '' ORDER BY DESCRIPCION";
									//Obtiene el resultado
									$query = sqlsrv_query( $conn, $tsql); 
				                    while($row = sqlsrv_fetch_array($query)){
				                        echo '<option value="'.$row['COD_CENTRAL'].'">';
				                        echo $row['DESCRIPCION'];
				                        echo '</option>';
				                    }
				                    sqlsrv_free_stmt( $stmt);
									sqlsrv_close( $conn);
				                echo '</select>';    
				                echo '<label>&nbsp;&nbsp;Empresa:</label>';
				                echo '<select name="empresas">';
				                    echo '<option value="0">--</option>';
				                    $conn=conectar_bd();
				                    $tsql="SELECT * FROM tbEmpresas WHERE DESCRIPCION <> '' ORDER BY DESCRIPCION";
									//Obtiene el resultado
									$query = sqlsrv_query( $conn, $tsql); 
				                    while($row = sqlsrv_fetch_array($query)){
				                        echo '<option value="'.$row['COD_EMPRESA'].'">';
				                        echo $row['DESCRIPCION'];
				                        echo '</option>';
				                    }
				                    sqlsrv_free_stmt( $stmt);
									sqlsrv_close( $conn);
				                echo '</select>';
				                echo '&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" id="btnfiltrar5">Filtrar</button>';
				                echo '&nbsp;&nbsp;<button type="button" id="btncancel5">Todos</button>';
				                echo '&nbsp;&nbsp;<button type="submit" onclick = "this.form.action = &#39;view/export_excel.php?origen=ssr&#39;" id="btnExcel">Exportar Excel</button>';
				            echo '</form>';
				        echo '</div>';
				        echo '<table cellpadding="0" cellspacing="0" id="data_ssr">';
				        	echo '<thead>';
				            	echo '<tr>';
				            		echo '<th width="8"><span title="semana">Sem.</span></th>';
				            		echo '<th width="20%"><span title="fecha_reg">fecha reg.</span></th>';
				            		echo '<th width="20%"><span title="fecha_ini_apro">fecha inicio apro.</span></th>';
				            		echo '<th width="20%"><span title="fecha_fin_apro">fecha fin apro.</span></th>';
				                    echo '<th width="8%"><span title="identificador">Identificador</span></th>';
				                    echo '<th width="8%"><span title="remedy">Remedy</span></th>';
				                    echo '<th width="30%"><span title="provincia">Provincia</span></th>';
				                    echo '<th width="30%"><span title="central">Central</span></th>';
				                    echo '<th width="30%"><span title="camara">Cámara</span></th>';
				                    echo '<th width="30%"><span title="empresa">Empresa</span></th>';
				                    echo '<th width="30%"><span title="nc_riesgo">Clientes riesgo</span></th>';
				                    echo '<th width="30%"><span title="nc_caidos">Clientes afectados</span></th>';
				                    echo '<th width="30%"><span title="af_conectividad">af conect.</span></th>';
				                    echo '<th width="30%"><span title="af_fttn">af fttn</span></th>';
				                    echo '<th width="30%"><span title="af_otros">af otros</span></th>';
				            		/*echo '<th width="8"><span title="prioridad">Prior.</span></th>';
				                    echo '<th width="8%"><span title="identificador">Identificador</span></th>';
				                    echo '<th width="8%"><span title="remedy">Remedy</span></th>';
				                    echo '<th width="20%"><span title="fechaini">Fecha inicio prop.</span></th>';
				                    echo '<th width="20%"><span title="fechafin">Fecha fin prop.</span></th>';
				                    echo '<th width="8%"><span title="semana">Sem.</span></th>';
				                    echo '<th width="30%"><span title="provincia">Provincia</span></th>';
				                    echo '<th width="30%"><span title="central">Central</span></th>';
				                    echo '<th width="30%"><span title="camara">Cámara</span></th>';
				                    echo '<th width="30%"><span title="nc_riesgo">Clientes riesgo</span></th>';
				                    echo '<th width="30%"><span title="nc_caidos">Clientes caidos</span></th>';*/
				                    echo '<th width="10"><span title="estado">Est.</span></th>';
				                    echo '<th width="10"><span title="ver">Ver</span></th>';
				                    echo '<th width="10"><span title="modificar">Mod.</span></th>';
				                    echo '<th width="10"><span title="cancelar">Canc.</span></th>';
				                echo '</tr>';
				            echo '</thead>';
				            echo '<tbody>';
				            echo '</tbody>';
				        echo '</table>';
						echo '</div>';
						break;
					case 4://VISTA PARA CONSULTA DE TRABAJOS EN EJECUCIÓN
						echo '<link rel="stylesheet" type="text/css" href="css/smoothness/jquery-ui-1.8.16.custom.css"/>';
						echo '<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>';
						echo '<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>';
						echo '<script type="text/javascript" src="js/js.js"></script>';
						//fancybox
						//echo '<script type="text/javascript" src="fancybox/lib/jquery-1.10.1.min.js"></script>';
						echo '<script type="text/javascript" src="fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>';
						echo '<script type="text/javascript" src="fancybox/source/jquery.fancybox.js?v=2.1.5"></script>';
						echo '<link rel="stylesheet" type="text/css" href="fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />';
						echo '<link rel="stylesheet" type="text/css" href="fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" />';
						echo '<script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>';
						echo '<link rel="stylesheet" type="text/css" href="fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />';
						echo '<script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>';
						echo '<script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>';
						//--------
						echo '<div id="content_result">';
						echo '<h1>TRABAJOS EN EJECUCIÓN</h1>';
						echo '<div class="filtro">';
				        	echo '<form id="frm_filtro_ejec" method="post" action="">';
					        	echo '<input type="hidden" name="vista" id="vista" value="'.$_SESSION['privi'].'" /> ';
					        	echo '<input type="hidden" name="perfil" id="perfil" value="'.$_SESSION['perfil'].'" /> ';
					            echo '<label>Fecha aprobada desde</label> ';
					            echo '<input type="text" name="del" id="del" size="8" class="datepicker" /> ';
					            echo 'Hasta ';
					            echo '<input type="text" name="al" id="al" size="8" class="datepicker" />';
					            echo '<label>&nbsp;&nbsp;Remedy:</label> <input type="text" name="REMEDY" size="11" />';
					            echo '<label>&nbsp;&nbsp;Identificador:</label> <input type="text" name="identificador" size="11" />';
					            echo '<label>&nbsp;&nbsp;Nº Semana:</label><input type="text" name="week" size="1" />';
					            echo '<label>&nbsp;&nbsp;CR:</label> <input type="text" name="cr" size="11" /><br><br>';
					            echo '<label>Estado:</label>';
					            echo '<select name="estados">';
					                echo '<option value="Seleccionar"></option>';
					                $conn=conectar_bd();
					                $tsql="SELECT distinct(ESTADO_TP) AS ESTADOS FROM tbTrabajos_Solicitados where ESTADO_TP in ('Aceptado','Realizado') order by ESTADO_TP";
									//Obtiene el resultado
									$query = sqlsrv_query( $conn, $tsql); 
					                while($row = sqlsrv_fetch_array($query)){
					                    echo '<option value="'.$row['ESTADOS'].'">';
					                    echo $row['ESTADOS'];
					                    echo '</option>';
					                }
					                sqlsrv_free_stmt( $stmt);
									sqlsrv_close( $conn);
					            echo '</select>';  
					            echo '<label>&nbsp;&nbsp;Provincia:</label>';
					            echo '<select name="provincias">';
					                echo '<option value="0">--</option>';
					                $conn=conectar_bd();
					                $tsql="SELECT * FROM tbProvincias";
									//Obtiene el resultado
									$query = sqlsrv_query( $conn, $tsql); 
					                while($row = sqlsrv_fetch_array($query)){
					                    echo '<option value="'.$row['COD_PROVINCIA'].'">';
					                    echo $row['DESCRIPCION'];
					                    echo '</option>';
					                }
					                sqlsrv_free_stmt( $stmt);
									sqlsrv_close( $conn);
					            echo '</select>'; 
					            echo '<label>&nbsp;&nbsp;Central:</label>';
					            echo '<select name="centrales">';
					                echo '<option value="0">--</option>';
					                $conn=conectar_bd();
					                $tsql="SELECT * FROM tbCentrales WHERE DESCRIPCION <> '' ORDER BY DESCRIPCION";
									//Obtiene el resultado
									$query = sqlsrv_query( $conn, $tsql); 
					                while($row = sqlsrv_fetch_array($query)){
					                    echo '<option value="'.$row['COD_CENTRAL'].'">';
					                    echo $row['DESCRIPCION'];
					                    echo '</option>';
					                }
					                sqlsrv_free_stmt( $stmt);
									sqlsrv_close( $conn);
					            echo '</select>';
					            echo '<label>&nbsp;&nbsp;Empresa:</label>';
					            echo '<select name="empresas">';
					                echo '<option value="0">--</option>';
					                $conn=conectar_bd();
					                $tsql="SELECT * FROM tbEmpresas WHERE DESCRIPCION <> '' ORDER BY DESCRIPCION";
									//Obtiene el resultado
									$query = sqlsrv_query( $conn, $tsql); 
					                while($row = sqlsrv_fetch_array($query)){
					                    echo '<option value="'.$row['COD_EMPRESA'].'">';
					                    echo $row['DESCRIPCION'];
					                    echo '</option>';
					                }
					                sqlsrv_free_stmt( $stmt);
									sqlsrv_close( $conn);
					            echo '</select>';
					            echo '&nbsp;&nbsp;&nbsp;<button type="button" id="btnfiltrar6">Filtrar</button>';
					            echo '&nbsp;&nbsp;<button type="button" id="btncancel6">Todos</button>';
				                echo '&nbsp;&nbsp;<button type="submit" onclick = "this.form.action = &#39;view/export_excel.php?origen=ejecucion&#39;" id="btnExcel">Exportar Excel</button>';
				            echo '</form>';
				        echo '</div>';
				        echo '<table cellpadding="0" cellspacing="0" id="data_ejec">';
				        	echo '<thead>';
				            	echo '<tr>';
				            		echo '<th width="8%"><span title="prioridad">Prioridad</span></th>';
				                    echo '<th width="8%"><span title="identificador">Identificador</span></th>';
				                    echo '<th width="13%"><span title="remedy">Remedy</span></th>';
				                    echo '<th width="20%"><span title="fechaini_apro">Fecha inicio apro.</span></th>';
				                    echo '<th width="30%"><span title="fechafin_apro">Fecha fin apro.</span></th>';
				                    echo '<th width="8%"><span title="semana_apro">Semana</span></th>';
				                    echo '<th width="30%"><span title="fecha_apert">Fecha apertura</span></th>';
				                    echo '<th width="30%"><span title="provincia">Provincia</span></th>';
				                    echo '<th width="30%"><span title="central">Central</span></th>';
				                    echo '<th width="30%"><span title="camara">Cámara</span></th>';
				                    echo '<th width="16"><span title="empresa">Empresa</span></th>';

				                    // maiteben_20160705
				                    echo '<th width="30%"><span title="nc_riesgo">Clientes riesgo</span></th>';
				                    echo '<th width="30%"><span title="nc_caidos">Clientes afectados</span></th>';				                    
				                    echo '<th width="30%"><span title="af_conectividad">af conect.</span></th>';
				                    echo '<th width="30%"><span title="af_fttn">af fttn</span></th>';
				                    echo '<th width="30%"><span title="af_otros">af otros</span></th>';
				                    // maiteben_20160705_fin

				                    echo '<th width="16"><span title="estado">Estado</span></th>';
				                    echo '<th width="16"><span title="ver">Ver</span></th>';
				                    echo '<th width="16"><span title="modificar">Mod.</span></th>';
				                    echo '<th width="16"><span title="cancelar">Canc.</span></th>';
				                echo '</tr>';
				            echo '</thead>';
				            echo '<tbody>';
				            echo '</tbody>';
				        echo '</table>';
						echo '</div>';
						break;
					case 7://VISTA PARA CONSULTA DE TRABAJOS PENDIENTES DE CAB, ACEPTADOS Y ENVIADOS
						echo '<link rel="stylesheet" type="text/css" href="css/smoothness/jquery-ui-1.8.16.custom.css"/>';
						echo '<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>';
						echo '<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>';
						echo '<script type="text/javascript" src="js/js.js"></script>';
						//fancybox
						//echo '<script type="text/javascript" src="fancybox/lib/jquery-1.10.1.min.js"></script>';
						echo '<script type="text/javascript" src="fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>';
						echo '<script type="text/javascript" src="fancybox/source/jquery.fancybox.js?v=2.1.5"></script>';
						echo '<link rel="stylesheet" type="text/css" href="fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />';
						echo '<link rel="stylesheet" type="text/css" href="fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" />';
						echo '<script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>';
						echo '<link rel="stylesheet" type="text/css" href="fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />';
						echo '<script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>';
						echo '<script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>';
						//--------
						echo '<div id="content_result">';
						echo '<h1>TRABAJOS PENDIENTES DE CAB</h1>';
						echo '<div class="filtro">';
				        	echo '<form id="frm_filtro_cab" method="post" action="">';
					        	echo '<input type="hidden" name="vista" id="vista" value="'.$_SESSION['privi'].'" /> ';
					        	echo '<input type="hidden" name="perfil" id="perfil" value="'.$_SESSION['perfil'].'" /> ';
					            echo '<label>Fecha registro: &nbsp;&nbsp; Desde</label> ';
					            echo '<input type="text" name="del" id="del" size="15" class="datepicker" /> ';
					            echo 'Hasta ';
					            echo '<input type="text" name="al" id="al" size="15" class="datepicker" />';
					            echo '<label>Identificador:</label> <input type="text" name="IDENT" size="11" />';
					            echo '<label>&nbsp;&nbsp;Remedy:</label> <input type="text" name="rem" size="11" />';
					            echo '<label>&nbsp;&nbsp;Nº Semana:</label><input type="text" name="week" size="1" />';
					            echo '<label>&nbsp;&nbsp;CR:</label> <input type="text" name="cr" size="11" /><br><br>';
					            echo '<label>Estado:</label>';
					            echo '<select name="estados">';
				                    echo '<option value="Seleccionar"></option>';
				                    $conn=conectar_bd();
				                    $tsql="SELECT distinct(ESTADO_TP) AS ESTADOS FROM tbTrabajos_Solicitados order by ESTADO_TP";
									//Obtiene el resultado
									$query = sqlsrv_query( $conn, $tsql); 
				                    while($row = sqlsrv_fetch_array($query)){
				                        echo '<option value="'.$row['ESTADOS'].'">';
				                        echo $row['ESTADOS'];
				                        echo '</option>';
				                    }
				                    sqlsrv_free_stmt( $stmt);
									sqlsrv_close( $conn);
				                echo '</select>';
				                echo '<label>&nbsp;&nbsp;Provincia:</label>';
				                echo '<select name="provincias">';
				                    echo '<option value="0">--</option>';
				                    $conn=conectar_bd();
				                    $tsql="SELECT * FROM tbProvincias";
									//Obtiene el resultado
									$query = sqlsrv_query( $conn, $tsql); 
				                    while($row = sqlsrv_fetch_array($query)){
				                        echo '<option value="'.$row['COD_PROVINCIA'].'">';
				                        echo $row['DESCRIPCION'];
				                        echo '</option>';
				                    }
				                    sqlsrv_free_stmt( $stmt);
									sqlsrv_close( $conn);
				                echo '</select>';
				                echo '&nbsp;&nbsp;&nbsp;<button type="button" id="btnfiltrar7">Filtrar</button>';
				                echo '&nbsp;&nbsp;<button type="button" id="btncancel7">Todos</button>';
				                if ($_SESSION['perfil'] == 4 || $_SESSION['perfil'] == 1) {
				                   	echo '&nbsp;&nbsp;<a href="../trabajos_programados/functions/process_solicitud.php?accion=enviar_todo" id="btnenvia"><button type="button" id="env_acep">Enviar aceptadas</button></a>';
				                }
				                echo '&nbsp;&nbsp;<button type="submit" onclick = "this.form.action = &#39;view/export_excel.php?origen=cab&#39;" id="btnExcel">Exportar Excel</button>';
				            echo '</form>';
				        echo '</div>';
				        echo '<table cellpadding="0" cellspacing="0" id="data_cab">';
				        	echo '<thead>';
				            	echo '<tr>';
				            		echo '<th width="8%"><span title="prioridad">Prioridad</span></th>';
				                    echo '<th width="8%"><span title="identificador">Identificador</span></th>';
				                    echo '<th width="13%"><span title="remedy">Remedy</span></th>';
				                    echo '<th width="20%"><span title="fechaini_pro">Fecha inicio prop.</span></th>';
				                    echo '<th width="30%"><span title="fechafin_pro">Fecha fin prop.</span></th>';
				                    echo '<th width="20%"><span title="fechaini_apro">Fecha inicio aprop.</span></th>';
				                    echo '<th width="30%"><span title="fechafin_apro">Fecha fin aprop.</span></th>';
				                    echo '<th width="30%"><span title="semana_apro">Semana</span></th>';
				                    echo '<th width="30%"><span title="provincia">Provincia</span></th>';
				                    echo '<th width="30%"><span title="central">Central</span></th>';
				                    echo '<th width="30%"><span title="camara">Cámara</span></th>';
				                    echo '<th width="16"><span title="nc_riesgo">Clientes riesgo</span></th>';
				                    echo '<th width="16"><span title="nc_caidos">Clientes afectados</span></th>';

				                    // maiteben_20160705
				                    echo '<th width="30%"><span title="af_conectividad">af conect.</span></th>';
				                    echo '<th width="30%"><span title="af_fttn">af fttn</span></th>';
				                    echo '<th width="30%"><span title="af_otros">af otros</span></th>';
				                    // maiteben_20160705_fin

				                    
				                    echo '<th width="16"><span title="estado">Estado</span></th>';
				                    echo '<th width="16"><span title="ver">Ver</span></th>';
				                if ($_SESSION['perfil'] == 4 || $_SESSION['perfil'] == 1) {
				                    echo '<th width="16"><span title="modificar">Mod.</span></th>';
				                    echo '<th width="16"><span title="cancelar">Canc.</span></th>';
				                }
				                echo '</tr>';
				            echo '</thead>';
				            echo '<tbody>';
				            echo '</tbody>';
				        echo '</table>';
						echo '</div>';
						break;
					case 6://VISTA PARA CONSULTA DE INFORMES
						echo '<div id="content_result">';
						echo '<h1>INFORMES</h1>';
						echo '</div>';
						break;
					case 5://VISTA PARA CONFIGURAR LISTAS ESTANDAR
						echo '<div id="content_result">';
							echo '<h1>CONFIGURACIÓN</h1>';
							echo '<div id="content_maxi_btn">';
								//
								echo '<a href="index.php?view=51">';
									echo '<div id="maxi_btn">';
										echo '<img src="images/ico/user91.png" />';
										echo '<div id="txt_maxi_btn">';
											echo '<p id="label_btn">usuarios</p>';
										echo '</div>';
									echo '</div>';
								echo '</a>';
								//
								echo '<a href="index.php?view=52">';
									echo '<div id="maxi_btn">';
										echo '<img src="images/ico/maps.png" />';
										echo '<div id="txt_maxi_btn">';
											echo '<p id="label_btn">provincias</p>';
										echo '</div>';
									echo '</div>';
								echo '</a>';
								//
								echo '<a href="index.php?view=53">';
									echo '<div id="maxi_btn">';
										echo '<img src="images/ico/settings3.png" />';
										echo '<div id="txt_maxi_btn">';
											echo '<p id="label_btn">centrales</p>';
										echo '</div>';
									echo '</div>';
								echo '</a>';
								//
								echo '<a href="index.php?view=54">';
									echo '<div id="maxi_btn">';
										echo '<img src="images/ico/handshake1.png" />';
										echo '<div id="txt_maxi_btn">';
											echo '<p id="label_btn">responsables</p>';
										echo '</div>';
									echo '</div>';
								echo '</a>';
								//
								echo '<a href="index.php?view=55">';
									echo '<div id="maxi_btn">';
										echo '<img src="images/ico/city21.png" />';
										echo '<div id="txt_maxi_btn">';
											echo '<p id="label_btn">empresas</p>';
										echo '</div>';
									echo '</div>';
								echo '</a>';
								//
								echo '<a href="index.php?view=56">';
									echo '<div id="maxi_btn">';
										echo '<img src="images/ico/screwdriver3.png" />';
										echo '<div id="txt_maxi_btn">';
											echo '<p id="label_btn">Técnicos</p>';
										echo '</div>';
									echo '</div>';
								echo '</a>';
								//
							echo '</div>';
						echo '</div>';
					break;
						//VISTA PARA CONFIGURAR USUARIOS Y PERFILES
						case 51:
							echo '<link rel="stylesheet" type="text/css" href="css/smoothness/jquery-ui-1.8.16.custom.css"/>';
							echo '<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>';
							echo '<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>';
							echo '<script type="text/javascript" src="js/js.js"></script>';
							//fancybox
							//echo '<script type="text/javascript" src="fancybox/lib/jquery-1.10.1.min.js"></script>';
							echo '<script type="text/javascript" src="fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>';
							echo '<script type="text/javascript" src="fancybox/source/jquery.fancybox.js?v=2.1.5"></script>';
							echo '<link rel="stylesheet" type="text/css" href="fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />';
							echo '<link rel="stylesheet" type="text/css" href="fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" />';
							echo '<script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>';
							echo '<link rel="stylesheet" type="text/css" href="fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />';
							echo '<script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>';
							echo '<script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>';
							//--------
							echo '<div id="content_result">';
							echo '<h1>ADMINISTRACIÓN DE USUARIOS</h1>';
							echo '<div class="filtro">';
					        	echo '<form id="frm_filtro_usu" method="post" action="">';
					                    echo '<label>Nombre completo:</label> <input type="text" name="NOMUSU" size="30" />';
					                    echo '&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" id="btnfiltrar1">Filtrar</button>';                
					                    /*echo '<li>';
					                    	echo '<a href="javascript:;" id="btncancel1">Todos</a>';
					                    echo '</li>';*/	
					                    echo '&nbsp;&nbsp;<a href="forms/consulta_usuarios.php" class="fancybox fancybox.iframe"><button type="button" id="btnfiltrar1">Nuevo usuario</button></a>';
					            echo '</form>';
					        echo '</div>';
					        echo '<table cellpadding="0" cellspacing="0" id="data_user">';
					        	echo '<thead>';
					            	echo '<tr>';
					                    echo '<th width="30%"><span title="nombre">NombreCompleto</span></th>';
					                    echo '<th width="13%"><span title="usuario">Usuario</span></th>';
					                    echo '<th width="30%"><span title="email">Dirección e-mail</span></th>';
					                    echo '<th width="15%"><span title="perfil">Perfil</span></th>';
					                    echo '<th width="20%"><span title="region">Región</span></th>';
					                    echo '<th width="16"><span title="ver">Ver</span></th>';
					                    echo '<th width="16"><span title="modificar">Mod.</span></th>';
					                    echo '<th width="16"><span title="eliminar">Eli.</span></th>';
					                echo '</tr>';
					            echo '</thead>';
					            echo '<tbody>';
					            echo '</tbody>';
					        echo '</table>';
							echo '</div>';
						break;
						//VISTA PARA CONFIGURAR LISTAS ESTANDAR DE PROVINCIAS
						case 52:
							echo '<link rel="stylesheet" type="text/css" href="css/smoothness/jquery-ui-1.8.16.custom.css"/>';
							echo '<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>';
							echo '<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>';
							echo '<script type="text/javascript" src="js/js.js"></script>';
							//fancybox
							//echo '<script type="text/javascript" src="fancybox/lib/jquery-1.10.1.min.js"></script>';
							echo '<script type="text/javascript" src="fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>';
							echo '<script type="text/javascript" src="fancybox/source/jquery.fancybox.js?v=2.1.5"></script>';
							echo '<link rel="stylesheet" type="text/css" href="fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />';
							echo '<link rel="stylesheet" type="text/css" href="fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" />';
							echo '<script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>';
							echo '<link rel="stylesheet" type="text/css" href="fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />';
							echo '<script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>';
							echo '<script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>';
							//--------
							echo '<div id="content_result">';
							echo '<h1>ADMINISTRACIÓN DE PROVINCIAS</h1>';
							echo '<div class="filtro">';
					        	echo '<form id="frm_filtro_prov" method="post" action="">';
					                    echo '<label>Nombre completo:</label> <input type="text" name="NOMUSU" size="30" />';
					                    echo '&nbsp;&nbsp;<button type="button" id="btnfiltrar1">Filtrar</button>';                
					                    /*echo '<li>';
					                    	echo '<a href="javascript:;" id="btncancel1">Todos</a>';
					                    echo '</li>';*/;
					                    echo '&nbsp;&nbsp;<a href="forms/consulta_provincias.php" class="fancybox fancybox.iframe"><button type="button" id="btnfiltrar1">Nueva provincia</button></a>';
					            echo '</form>';
					        echo '</div>';
					        echo '<table cellpadding="0" cellspacing="0" id="data_prov">';
					        	echo '<thead>';
					            	echo '<tr>';
					                    echo '<th width="50%"><span title="provincia">Provincia</span></th>';
					                    echo '<th width="50%"><span title="region">Región</span></th>';
					                    echo '<th width="16"><span title="ver">Ver</span></th>';
					                    echo '<th width="16"><span title="modificar">Mod.</span></th>';
					                    echo '<th width="16"><span title="eliminar">Eli.</span></th>';
					                echo '</tr>';
					            echo '</thead>';
					            echo '<tbody>';
					            echo '</tbody>';
					        echo '</table>';
							echo '</div>';
						break;
						//VISTA PARA CONFIGURAR LISTAS ESTANDAR DE CENTRALES
						case 53:
							echo '<link rel="stylesheet" type="text/css" href="css/smoothness/jquery-ui-1.8.16.custom.css"/>';
							echo '<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>';
							echo '<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>';
							echo '<script type="text/javascript" src="js/js.js"></script>';
							//fancybox
							//echo '<script type="text/javascript" src="fancybox/lib/jquery-1.10.1.min.js"></script>';
							echo '<script type="text/javascript" src="fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>';
							echo '<script type="text/javascript" src="fancybox/source/jquery.fancybox.js?v=2.1.5"></script>';
							echo '<link rel="stylesheet" type="text/css" href="fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />';
							echo '<link rel="stylesheet" type="text/css" href="fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" />';
							echo '<script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>';
							echo '<link rel="stylesheet" type="text/css" href="fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />';
							echo '<script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>';
							echo '<script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>';
							//--------
							echo '<div id="content_result">';
							echo '<h1>ADMINISTRACIÓN DE CENTRALES</h1>';
							echo '<div class="filtro">';
					        	echo '<form id="frm_filtro_centr" method="post" action="">';
					                    echo '<label>Central:</label> <input type="text" name="central" size="30" />';
					                    	echo '&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" id="btnfiltrar3">Filtrar</button>';
					                    	echo '&nbsp;&nbsp;<a href="forms/consulta_centrales.php" class="fancybox fancybox.iframe"><button type="button" id="btnfiltrar1">Nueva central</button></a>';
					            echo '</form>';
					        echo '</div>';
					        echo '<table cellpadding="0" cellspacing="0" id="data_centr">';
					        	echo '<thead>';
					            	echo '<tr>';
					                    echo '<th width="33%"><span title="central">Central</span></th>';
					                    echo '<th width="33%"><span title="provincia">Provincia</span></th>';
					                    echo '<th width="33%"><span title="region">Región</span></th>';
					                    echo '<th width="16"><span title="ver">Ver</span></th>';
					                    echo '<th width="16"><span title="modificar">Mod.</span></th>';
					                    echo '<th width="16"><span title="eliminar">Eli.</span></th>';
					                echo '</tr>';
					            echo '</thead>';
					            echo '<tbody>';
					            echo '</tbody>';
					        echo '</table>';
							echo '</div>';
						break;
						//VISTA PARA CONFIGURAR LISTAS ESTANDAR DE RESPONSABLES
						case 54:
							echo '<link rel="stylesheet" type="text/css" href="css/smoothness/jquery-ui-1.8.16.custom.css"/>';
							echo '<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>';
							echo '<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>';
							echo '<script type="text/javascript" src="js/js.js"></script>';
							//fancybox
							//echo '<script type="text/javascript" src="fancybox/lib/jquery-1.10.1.min.js"></script>';
							echo '<script type="text/javascript" src="fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>';
							echo '<script type="text/javascript" src="fancybox/source/jquery.fancybox.js?v=2.1.5"></script>';
							echo '<link rel="stylesheet" type="text/css" href="fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />';
							echo '<link rel="stylesheet" type="text/css" href="fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" />';
							echo '<script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>';
							echo '<link rel="stylesheet" type="text/css" href="fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />';
							echo '<script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>';
							echo '<script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>';
							//--------
							echo '<div id="content_result">';
							echo '<h1>ADMINISTRACIÓN DE RESPONSABLES</h1>';
							echo '<div class="filtro">';
					        	echo '<form id="frm_filtro_responsable" method="post" action="">';
					                    echo '<label>Nombre:</label> <input type="text" name="nomresp" size="30" />';
					                    	echo '<button type="button" id="btnfiltrar4">Filtrar</button>';
					                    	echo '&nbsp;&nbsp;<a href="forms/consulta_responsables.php" class="fancybox fancybox.iframe"><button type="button" id="btnfiltrar1">Nuevo responsable</button></a>';
					            echo '</form>';
					        echo '</div>';
					        echo '<table cellpadding="0" cellspacing="0" id="data_responsable">';
					        	echo '<thead>';
					            	echo '<tr>';
					                    echo '<th width="80%"><span title="nombre">Nombre</span></th>';
					                    echo '<th width="16%"><span title="telefono">Telefono</span></th>';
					                    echo '<th width="16"><span title="ver">Ver</span></th>';
					                    echo '<th width="16"><span title="modificar">Mod.</span></th>';
					                    echo '<th width="16"><span title="eliminar">Eli.</span></th>';
					                echo '</tr>';
					            echo '</thead>';
					            echo '<tbody>';
					            echo '</tbody>';
					        echo '</table>';
							echo '</div>';
						break;
						//VISTA PARA CONFIGURAR LISTAS ESTANDAR DE EMPRESAS
						case 55:
							echo '<link rel="stylesheet" type="text/css" href="css/smoothness/jquery-ui-1.8.16.custom.css"/>';
							echo '<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>';
							echo '<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>';
							echo '<script type="text/javascript" src="js/js.js"></script>';
							//fancybox
							//echo '<script type="text/javascript" src="fancybox/lib/jquery-1.10.1.min.js"></script>';
							echo '<script type="text/javascript" src="fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>';
							echo '<script type="text/javascript" src="fancybox/source/jquery.fancybox.js?v=2.1.5"></script>';
							echo '<link rel="stylesheet" type="text/css" href="fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />';
							echo '<link rel="stylesheet" type="text/css" href="fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" />';
							echo '<script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>';
							echo '<link rel="stylesheet" type="text/css" href="fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />';
							echo '<script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>';
							echo '<script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>';
							//--------
							echo '<div id="content_result">';
							echo '<h1>ADMINISTRACIÓN DE EMPRESAS</h1>';
							echo '<div class="filtro">';
					        	echo '<form id="frm_filtro_responsable" method="post" action="">';
					                    echo '<label>Nombre:</label> <input type="text" name="nomresp" size="30" />';
					                    	echo '<button type="button" id="btnfiltrar4">Filtrar</button>';
					                    	echo '&nbsp;&nbsp;<a href="forms/consulta_responsables.php" class="fancybox fancybox.iframe"><button type="button" id="btnfiltrar1">Nuevo responsable</button></a>';
					            echo '</form>';
					        echo '</div>';
					        /*echo '<table cellpadding="0" cellspacing="0" id="data_responsable">';
					        	echo '<thead>';
					            	echo '<tr>';
					                    echo '<th width="80%"><span title="nombre">Nombre</span></th>';
					                    echo '<th width="16%"><span title="telefono">Telefono</span></th>';
					                    echo '<th width="16"><span title="ver">Ver</span></th>';
					                    echo '<th width="16"><span title="modificar">Mod.</span></th>';
					                    echo '<th width="16"><span title="eliminar">Eli.</span></th>';
					                echo '</tr>';
					            echo '</thead>';
					            echo '<tbody>';
					            echo '</tbody>';
					        echo '</table>';*/
							echo '</div>';
						break;
						//VISTA PARA CONFIGURAR LISTAS ESTANDAR DE TÉCNICOS
						case 56:
							echo '<link rel="stylesheet" type="text/css" href="css/smoothness/jquery-ui-1.8.16.custom.css"/>';
							echo '<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>';
							echo '<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>';
							echo '<script type="text/javascript" src="js/js.js"></script>';
							//fancybox
							//echo '<script type="text/javascript" src="fancybox/lib/jquery-1.10.1.min.js"></script>';
							echo '<script type="text/javascript" src="fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>';
							echo '<script type="text/javascript" src="fancybox/source/jquery.fancybox.js?v=2.1.5"></script>';
							echo '<link rel="stylesheet" type="text/css" href="fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />';
							echo '<link rel="stylesheet" type="text/css" href="fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" />';
							echo '<script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>';
							echo '<link rel="stylesheet" type="text/css" href="fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />';
							echo '<script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>';
							echo '<script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>';
							//--------
							echo '<div id="content_result">';
							echo '<h1>ADMINISTRACIÓN DE TÉCNICOS</h1>';
							echo '<div class="filtro">';
					        	echo '<form id="frm_filtro_responsable" method="post" action="">';
					                    echo '<label>Nombre:</label> <input type="text" name="nomresp" size="30" />';
					                    	echo '<button type="button" id="btnfiltrar4">Filtrar</button>';
					                    	echo '&nbsp;&nbsp;<a href="forms/consulta_responsables.php" class="fancybox fancybox.iframe"><button type="button" id="btnfiltrar1">Nuevo responsable</button></a>';
					            echo '</form>';
					        echo '</div>';
					        /*echo '<table cellpadding="0" cellspacing="0" id="data_responsable">';
					        	echo '<thead>';
					            	echo '<tr>';
					                    echo '<th width="80%"><span title="nombre">Nombre</span></th>';
					                    echo '<th width="16%"><span title="telefono">Telefono</span></th>';
					                    echo '<th width="16"><span title="ver">Ver</span></th>';
					                    echo '<th width="16"><span title="modificar">Mod.</span></th>';
					                    echo '<th width="16"><span title="eliminar">Eli.</span></th>';
					                echo '</tr>';
					            echo '</thead>';
					            echo '<tbody>';
					            echo '</tbody>';
					        echo '</table>';*/
							echo '</div>';
						break;
		}
	}
	else {
		echo '<script>alert("Debe iniciar sesión de usuario para poder ver esta sección")</script>';
	}
}
?>
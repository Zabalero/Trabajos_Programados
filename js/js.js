// JavaScript Document
var ordenar = '';
$(document).ready(function(){
	
	// Llamando a la funcion de busqueda al
	// cargar la pagina
	filtrar()

	filtrar_ssr()

	filtrar_tbuser()

	filtrar_tbprovincias()

	filtrar_tbcentrales()

	filtrar_tbresponsables()

	filtrar_ejec()

	filtrar_cab()

	
	var dates = $( "#del, #al" ).datepicker({
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
			onSelect: function( selectedDate ) {
				var option = this.id == "del" ? "minDate" : "maxDate",
					instance = $( this ).data( "datepicker" ),
					date = $.datepicker.parseDate(
						instance.settings.dateFormat ||
						$.datepicker._defaults.dateFormat,
						selectedDate, instance.settings );
				dates.not( this ).datepicker( "option", option, date );
			}
	});
	
	// filtrar al darle click al boton
	$("#btnfiltrar").click(function(){ filtrar() });

	// filtrar al darle click al boton
	$("#btnfiltrar1").click(function(){ filtrar_tbuser() });

	$("#btnfiltrar2").click(function(){ filtrar_tbprovincias() });

	$("#btnfiltrar3").click(function(){ filtrar_tbcentrales() });

	$("#btnfiltrar4").click(function(){ filtrar_tbresponsables() });

	$("#btnfiltrar5").click(function(){ filtrar_ssr() });

	$("#btnfiltrar6").click(function(){ filtrar_ejec() });
	
	$("#btnfiltrar7").click(function(){ filtrar_cab() });

	// boton cancelar
	$("#btncancel").click(function(){ 
		$(".filtro input").val('')
		$(".filtro select").find("option[value='0']").attr("selected",true)
		close();
	});

	$("#btncancel5").click(function(){ 
		$(".filtro input").val('')
		$(".filtro select").find("option[value='0']").attr("selected",true)
		close();
	});

	$("#btncancel6").click(function(){ 
		$(".filtro input").val('')
		$(".filtro select").find("option[value='0']").attr("selected",true)
		close();
	});

	$("#btncancel7").click(function(){ 
		$(".filtro input").val('')
		$(".filtro select").find("option[value='0']").attr("selected",true)
		close();
	});

	// boton cancelar
	$("#btncancel1").click(function(){ 
		$(".filtro input").val('')
		close();
	});

	$("#btncancel2").click(function(){ 
		$(".filtro input").val('')
		close();
	});

	$("#btncancel3").click(function(){ 
		$(".filtro input").val('')
		close();
	});

	$("#btncancel4").click(function(){ 
		$(".filtro input").val('')
		close();
	});
	
	// ordenar por
	$("#data th span").click(function(){
		var orden = '';
		if($(this).hasClass("desc"))
		{
			$("#data th span").removeClass("desc").removeClass("asc")
			$(this).addClass("asc");
			ordenar = "&orderby="+$(this).attr("title")+" asc"		
		}else
		{
			$("#data th span").removeClass("desc").removeClass("asc")
			$(this).addClass("desc");
			ordenar = "&orderby="+$(this).attr("title")+" desc"
		}
		filtrar()
	});

	$("#data_ssr th span").click(function(){
		var orden = '';
		if($(this).hasClass("desc"))
		{
			$("#data_ssr th span").removeClass("desc").removeClass("asc")
			$(this).addClass("asc");
			ordenar = "&orderby="+$(this).attr("title")+" asc"		
		}else
		{
			$("#data_ssr th span").removeClass("desc").removeClass("asc")
			$(this).addClass("desc");
			ordenar = "&orderby="+$(this).attr("title")+" desc"
		}
		filtrar_ssr()
	});

	$("#data_ejec th span").click(function(){
		var orden = '';
		if($(this).hasClass("desc"))
		{
			$("#data_ejec th span").removeClass("desc").removeClass("asc")
			$(this).addClass("asc");
			ordenar = "&orderby="+$(this).attr("title")+" asc"		
		}else
		{
			$("#data_ejec th span").removeClass("desc").removeClass("asc")
			$(this).addClass("desc");
			ordenar = "&orderby="+$(this).attr("title")+" desc"
		}
		filtrar_ejec()
	});

	$("#data_cab th span").click(function(){
		var orden = '';
		if($(this).hasClass("desc"))
		{
			$("#data_ejec th span").removeClass("desc").removeClass("asc")
			$(this).addClass("asc");
			ordenar = "&orderby="+$(this).attr("title")+" asc"		
		}else
		{
			$("#data_ejec th span").removeClass("desc").removeClass("asc")
			$(this).addClass("desc");
			ordenar = "&orderby="+$(this).attr("title")+" desc"
		}
		filtrar_ejec()
	});

	// ordenar por
	$("#data_user th span").click(function(){
		var orden = '';
		if($(this).hasClass("desc"))
		{
			$("#data_user th span").removeClass("desc").removeClass("asc")
			$(this).addClass("asc");
			ordenar = "&orderby="+$(this).attr("title")+" asc"		
		}else
		{
			$("#data_user th span").removeClass("desc").removeClass("asc")
			$(this).addClass("desc");
			ordenar = "&orderby="+$(this).attr("title")+" desc"
		}
		filtrar_tbuser()
	});

	// ordenar por
	$("#data_prov th span").click(function(){
		var orden = '';
		if($(this).hasClass("desc"))
		{
			$("#data_prov th span").removeClass("desc").removeClass("asc")
			$(this).addClass("asc");
			ordenar = "&orderby="+$(this).attr("title")+" asc"		
		}else
		{
			$("#data_prov th span").removeClass("desc").removeClass("asc")
			$(this).addClass("desc");
			ordenar = "&orderby="+$(this).attr("title")+" desc"
		}
		filtrar_tbprovincias()
	});

	// ordenar por
	$("#data_centr th span").click(function(){
		var orden = '';
		if($(this).hasClass("desc"))
		{
			$("#data_centr th span").removeClass("desc").removeClass("asc")
			$(this).addClass("asc");
			ordenar = "&orderby="+$(this).attr("title")+" asc"		
		}else
		{
			$("#data_centr th span").removeClass("desc").removeClass("asc")
			$(this).addClass("desc");
			ordenar = "&orderby="+$(this).attr("title")+" desc"
		}
		filtrar_tbcentrales()
	});

	// ordenar por
	$("#data_responsable th span").click(function(){
		var orden = '';
		if($(this).hasClass("desc"))
		{
			$("#data_responsable th span").removeClass("desc").removeClass("asc")
			$(this).addClass("asc");
			ordenar = "&orderby="+$(this).attr("title")+" asc"		
		}else
		{
			$("#data_responsable th span").removeClass("desc").removeClass("asc")
			$(this).addClass("desc");
			ordenar = "&orderby="+$(this).attr("title")+" desc"
		}
		filtrar_tbresponsables()
	});

});

function filtrar()
{	
	$.ajax({
		data: $("#frm_filtro").serialize()+ordenar,
		type: "POST",
		dataType: "json",
		url: "./functions/ajax.php?action=listar",
			success: function(data){
				var html = '';
				if(data.length > 0){
					$.each(data, function(i,item){
						html += '<tr>'
							if (item.perfil != 3 && item.perfil != 6 && item.perfil != 5){
								if (item.estado === 'Registrado') {
									html += '<td><a href="functions/process_solicitud.php?accion=asignar&solicitud='+item.codigo+'" target="_blank" id="'+item.codigo+'" class="btn_elim"><img src="images/ico/plus24.png" width="20" heigth="20"/></a></td>'
								} else {
									html += '<td></td>'
								}								
								if (item.prioridad == 1){
									html += '<td><img src="images/ico/number41.png" width="20" heigth="20"/></td>'
								}
								if (item.prioridad == 2){
									html += '<td><img src="images/ico/number40.png" width="20" heigth="20"/></td>'
								}
								html += '<td>'+item.solicita+'</td>'
								html += '<td>'+item.fechaini_pro+'</td>'
								html += '<td>'+item.fechafin_pro+'</td>'
								html += '<td>'+item.semanapro+'</td>'
								html += '<td>'+item.provincia+'</td>'
								html += '<td>'+item.central+'</td>'
								html += '<td>'+item.camara+'</td>'
								html += '<td>'+item.identificador+'</td>'
								html += '<td>'+item.remedy+'</td>'
								html += '</td>'
								switch (item.estado) {
									case 'Registrado':
										html += '<td><img src="images/ico/send4.png" width="20"  heigth="20" title="'+item.estado+'"/></td>'
										break;
									case 'Pendiente Info':
										html += '<td><img src="images/ico/speech140.png" width="20" heigth="20" title="'+item.estado+'"/></td>'
										break;
									case 'Asignado':
										html += '<td><img src="images/ico/settings49.png" width="20" heigth="20" title="'+item.estado+'"/></td>'
										break;
									case 'Pendiente CAB':
										html += '<td><img src="images/ico/speedometer10.png" width="20" heigth="20" title="'+item.estado+'"/></td>'
										break;
									case 'Aceptado':	
										html += '<td><img src="images/ico/thumb36.png" width="20" heigth="20" title="'+item.estado+'"/></td>'
										break;
									case 'Realizado':
										html += '<td><img src="images/ico/white65.png" width="20" heigth="20" title="'+item.estado+'"/></td>'
										break;
									case 'Cancelado':
										html += '<td><img src="images/ico/blocking.png" width="20" heigth="20" title="'+item.estado+'"/></td>'
										break;
									case 'Anulado':
										html += '<td><img src="images/ico/prohibited4.png" width="20" heigth="20" title="'+item.estado+'"/></td>'
										break;
									case 'Rechazado':
										html += '<td><img src="images/ico/thumbs25.png" width="20" heigth="20" title="'+item.estado+'"/></td>'
										break;
								}
								html += '<td><a href="forms/consulta_solicitud.php?jobcode='+item.codigo+'&mode=1" id="'+item.codigo+'" class="fancybox fancybox.iframe"><img src="images/ico/visibility1.png" width="20" heigth="20"/></a></td>'
								if (item.perfil == 1) {
									html += '<td><a href="forms/consulta_solicitud.php?jobcode='+item.codigo+'&mode=2" id="'+item.codigo+'" class="fancybox fancybox.iframe"><img src="images/ico/pencil43.png" width="20" heigth="20"/></a></td>'
								}
								if (item.estado === 'Aceptado' || item.estado === 'Realizado') {
									html += '<td><a href="functions/genera_pdf.php?jobcode='+item.codigo+'" target="_blank"><img src="images/ico/pdf17.png" width="20" heigth="20" title="Descargar solicitud"/></a></td>'
								} else {
									html +='<td></td>'
								}
							}
							if (item.perfil == 3 || item.perfil == 5) {
								html += '<td>'+item.solicita+'</td>'
								html += '<td>'+item.fechaenv+'</td>'
								html += '<td>'+item.identificador+'</td>'
								html += '<td>'+item.remedy+'</td>'
								html += '<td>'+item.provincia+'</td>'
								html += '<td>'+item.central+'</td>'
								html += '<td>'+item.camara+'</td>'
								switch (item.estado) {
									case 'Registrado':
										html += '<td><img src="images/ico/send4.png" width="20"  heigth="20" title="'+item.estado+'"/></td>'
										break;
									case 'Pendiente Info':
										html += '<td><img src="images/ico/speech140.png" width="20" heigth="20" title="'+item.estado+'"/></td>'
										break;
									case 'Asignado':
										html += '<td><img src="images/ico/settings49.png" width="20" heigth="20" title="'+item.estado+'"/></td>'
										break;
									case 'Pendiente CAB':
										html += '<td><img src="images/ico/speedometer10.png" width="20" heigth="20" title="'+item.estado+'"/></td>'
										break;
									case 'Aceptado':
										html += '<td><img src="images/ico/thumb36.png" width="20" heigth="20" title="'+item.estado+'"/></td>'
										break;
									case 'Realizado':
										html += '<td><img src="images/ico/white65.png" width="20" heigth="20" title="'+item.estado+'"/></td>'
										break;
									case 'Cancelado':
										html += '<td><img src="images/ico/blocking.png" width="20" heigth="20" title="'+item.estado+'"/></td>'
										break;
									case 'Anulado':
										html += '<td><img src="images/ico/prohibited4.png" width="20" heigth="20" title="'+item.estado+'"/></td>'
										break;
									case 'Rechazado':
										html += '<td><img src="images/ico/thumbs25.png" width="20" heigth="20" title="'+item.estado+'"/></td>'
										break;
								}
								html += '<td>'+item.fechaini+'</td>'
								html += '<td>'+item.fechafin+'</td>'
								html += '<td>'+item.semana+'</td>'
								html += '<td><a href="forms/consulta_solicitud.php?jobcode='+item.codigo+'&mode=1" id="'+item.codigo+'" class="fancybox fancybox.iframe"><img src="images/ico/visibility1.png" width="20" heigth="20"/></a></td>'
								html += '<td>'
								if (item.estado === 'Registrado' || item.estado === 'Pendiente Info') {
								html += '<a href="forms/consulta_solicitud.php?jobcode='+item.codigo+'&mode=2" id="'+item.codigo+'" class="fancybox fancybox.iframe"><img src="images/ico/pencil43.png" width="20" heigth="20"/></a>'
								}
								html += '</td>'
								html += '<td>'
								if (item.estado === 'Registrado' || item.estado === 'Asignado' || item.estado === 'Pendiente CAB' || item.estado === 'Aceptado') {
								html += '<a href="functions/process_solicitud.php?accion=cancelar&solicitud='+item.codigo+'&view=2" id="'+item.codigo+'" onclick="validarCancelar()" class="btn_elim"><img src="images/ico/rubbish.png" width="20" heigth="20"/></a>'
								}
								html += '</td>'
								if (item.estado === 'Aceptado' || item.estado === 'Realizado') {
									html += '<td><a href="functions/genera_pdf.php?jobcode='+item.codigo+'" target="_blank"><img src="images/ico/pdf17.png" width="20" heigth="20" title="Descargar solicitud"/></a></td>'
								} else {
									html +='<td></td>'
								}
							}
							if (item.perfil == 6) {
								html += '<td>'+item.solicita+'</td>'
								html += '<td>'+item.fechaenv+'</td>'
								html += '<td>'+item.identificador+'</td>'
								html += '<td>'+item.remedy+'</td>'
								html += '<td>'+item.provincia+'</td>'
								html += '<td>'+item.emp+'</td>'
								html += '<td>'+item.central+'</td>'
								html += '<td>'+item.camara+'</td>'
								switch (item.estado) {
									case 'Registrado':
										html += '<td><img src="images/ico/send4.png" width="20"  heigth="20" title="'+item.estado+'"/></td>'
										break;
									case 'Pendiente Info':
										html += '<td><img src="images/ico/speech140.png" width="20" heigth="20" title="'+item.estado+'"/></td>'
										break;
									case 'Asignado':
										html += '<td><img src="images/ico/settings49.png" width="20" heigth="20" title="'+item.estado+'"/></td>'
										break;
									case 'Pendiente CAB':
										html += '<td><img src="images/ico/speedometer10.png" width="20" heigth="20" title="'+item.estado+'"/></td>'
										break;
									case 'Aceptado':
										html += '<td><img src="images/ico/thumb36.png" width="20" heigth="20" title="'+item.estado+'"/></td>'
										break;
									case 'Realizado':
										html += '<td><img src="images/ico/white65.png" width="20" heigth="20" title="'+item.estado+'"/></td>'
										break;
									case 'Cancelado':
										html += '<td><img src="images/ico/blocking.png" width="20" heigth="20" title="'+item.estado+'"/></td>'
										break;
									case 'Anulado':
										html += '<td><img src="images/ico/prohibited4.png" width="20" heigth="20" title="'+item.estado+'"/></td>'
										break;
									case 'Rechazado':
										html += '<td><img src="images/ico/thumbs25.png" width="20" heigth="20" title="'+item.estado+'"/></td>'
										break;
								}
								html += '<td>'+item.fechaini+'</td>'
								html += '<td>'+item.fechafin+'</td>'
								html += '<td>'+item.semana+'</td>'
								html += '<td><a href="forms/consulta_solicitud.php?jobcode='+item.codigo+'&mode=1" id="'+item.codigo+'" class="fancybox fancybox.iframe"><img src="images/ico/visibility1.png" width="20" heigth="20"/></a></td>'
								if (item.estado === 'Aceptado' || item.estado === 'Realizado') {
									html += '<td><a href="functions/genera_pdf.php?jobcode='+item.codigo+'" target="_blank"><img src="images/ico/pdf17.png" width="20" heigth="20" title="Descargar solicitud"/></a></td>'
								} else {
									html +='<td></td>'
								}
								/*html += '<td>'
								html += '</td>'
								html += '<td>'
								html += '</td>'*/
							}
						html += '</tr>';									
					});					
				}
				if(html == '') html = '<tr><td colspan="14" align="center">No se encontraron registros..</td></tr>'
				$("#data tbody").html(html);
			}
	  });
}

function filtrar_ssr()
{	
	$.ajax({
		data: $("#frm_filtro_ssr").serialize()+ordenar,
		type: "POST",
		dataType: "json",
		url: "./functions/ajax.php?action=listar_ssr",
			success: function(data){
				var html = '';
				if(data.length > 0){
					$.each(data, function(i,item){
						html += '<tr>'
							html += '<td>'+item.semana+'</td>'
							html += '<td>'+item.fechareg+'</td>'
							html += '<td>'+item.fechaini+'</td>'
							html += '<td>'+item.fechafin+'</td>'
							html += '<td>'+item.identificador+'</td>'
							html += '<td>'+item.remedy+'</td>'
							html += '<td>'+item.provincia+'</td>'
							html += '<td>'+item.central+'</td>'
							html += '<td>'+item.camara+'</td>'
							html += '<td>'+item.empresa+'</td>'
							html += '<td>'+item.nc_riesgo+'</td>'
							html += '<td>'+item.nc_caidos+'</td>'
							if (item.af_conectividad == 1) {
								html += '<td>SI</td>'
							} else if (item.af_conectividad == 2) {
								html += '<td>RI</td>'
							} else if (item.af_conectividad == 3) {
								html += '<td>NO</td>'
							} else {
								html += '<td>--</td>'
							}
							if (item.af_fttn == 1) {
								html += '<td>SI</td>'
							} else if (item.af_fttn == 2) {
								html += '<td>RI</td>'
							} else if (item.af_fttn == 3) {
								html += '<td>NO</td>'
							} else {
								html += '<td>--</td>'
							}
							if (item.af_otros == 1) {
								html += '<td>SI</td>'
							} else if (item.af_otros == 2) {
								html += '<td>RI</td>'
							} else if (item.af_otros == 3) {
								html += '<td>NO</td>'
							} else {
								html += '<td>--</td>'
							}
							switch (item.estado) {
								case 'Registrado':
									html += '<td><img src="images/ico/send4.png" width="20"  heigth="20" title="'+item.estado+'"/></td>'
									break;
								case 'Pendiente Info':
									html += '<td><img src="images/ico/speech140.png" width="20" heigth="20" title="'+item.estado+'"/></td>'
									break;
								case 'Asignado':
									html += '<td><img src="images/ico/settings49.png" width="20" heigth="20" title="'+item.estado+'"/></td>'
									break;
								case 'Pendiente CAB':
									html += '<td><img src="images/ico/speedometer10.png" width="20" heigth="20" title="'+item.estado+'"/></td>'
									break;
								case 'Aceptado':
									html += '<td><img src="images/ico/thumb36.png" width="20" heigth="20" title="'+item.estado+'"/></td>'
									break;
								case 'Realizado':
									html += '<td><img src="images/ico/white65.png" width="20" heigth="20" title="'+item.estado+'"/></td>'
									break;
								case 'Cancelado':
									html += '<td><img src="images/ico/blocking.png" width="20" heigth="20" title="'+item.estado+'"/></td>'
									break;
								case 'Anulado':
									html += '<td><img src="images/ico/prohibited4.png" width="20" heigth="20" title="'+item.estado+'"/></td>'
									break;
								case 'Rechazado':
									html += '<td><img src="images/ico/thumbs25.png" width="20" heigth="20" title="'+item.estado+'"/></td>'
									break;
							}
							html += '<td><a href="forms/consulta_solicitud_ssr.php?jobcode='+item.codigo+'&mode=1" id="'+item.codigo+'" class="fancybox fancybox.iframe"><img src="images/ico/visibility1.png" width="20" heigth="20"/></a></td>'
							html += '<td>'
							if (item.perfil == 2 /*&& (item.estado === 'Asignado' || item.estado === 'Pendiente CAB' || item.estado === 'Pendiente Info' || item.estado === 'Aceptado')*/){
								html += '<a href="forms/consulta_solicitud_ssr.php?jobcode='+item.codigo+'&mode=2" id="'+item.codigo+'" class="fancybox fancybox.iframe"><img src="images/ico/pencil43.png" width="20" heigth="20"/></a>'							
							}
							if (item.perfil == 4 || item.perfil == 1){
								html += '<a href="forms/consulta_solicitud_ssr.php?jobcode='+item.codigo+'&mode=2" id="'+item.codigo+'" class="fancybox fancybox.iframe"><img src="images/ico/pencil43.png" width="20" heigth="20"/></a>'							
							}
							html += '</td>'
							html += '<td>'
							if ( item.perfil == 2 && (item.estado === 'Asignado' || item.estado === 'Pendiente Info' || item.estado === 'Pendiente CAB')) {
								html += '<a href="functions/process_solicitud.php?accion=cancelar&solicitud='+item.codigo+'" id="'+item.codigo+'" onclick="validarCancelar()" class="btn_elim"><img src="images/ico/rubbish.png" width="20" heigth="20"/></a>'
							}
							if ( item.perfil == 4 || item.perfil == 1) {
								html += '<a href="functions/process_solicitud.php?accion=cancelar&solicitud='+item.codigo+'&view=3" id="'+item.codigo+'" onclick="validarCancelar()" class="btn_elim"><img src="images/ico/rubbish.png" width="20" heigth="20"/></a>'
							}
							html += '</td>'							
						html += '</tr>';									
					});					
				}
				if(html == '') html = '<tr><td colspan="10" align="center">No se encontraron registros..</td></tr>'
				$("#data_ssr tbody").html(html);
			}
	  });
}

function filtrar_ejec()
{	
	$.ajax({
		data: $("#frm_filtro_ejec").serialize()+ordenar,
		type: "POST",
		dataType: "json",
		url: "./functions/ajax.php?action=listar_ejec",
			success: function(data){
				var html = '';
				if(data.length > 0){
					$.each(data, function(i,item){
						html += '<tr>'
							if (item.prioridad == 1){
								html += '<td><img src="images/ico/number41.png" width="20" heigth="20"/></td>'
							}
							if (item.prioridad == 2){
								html += '<td><img src="images/ico/number40.png" width="20" heigth="20"/></td>'
							}
							html += '<td>'+item.identificador+'</td>'
							html += '<td>'+item.remedy+'</td>'
							html += '<td>'+item.fechaini_apro+'</td>'
							html += '<td>'+item.fechafin_apro+'</td>'
							html += '<td>'+item.semana_apro+'</td>'
							html += '<td>'+item.fecha_apert+'</td>'
							html += '<td>'+item.provincia+'</td>'
							html += '<td>'+item.central+'</td>'
							html += '<td>'+item.camara+'</td>'
							html += '<td>'+item.empresa+'</td>'

							// maiteben_20160705

							html += '<td>'+item.nc_riesgo+'</td>'
							html += '<td>'+item.nc_caidos+'</td>'
														
							if (item.af_conectividad == 1) {
								html += '<td>SI</td>'
							} else if (item.af_conectividad == 2) {
								html += '<td>RI</td>'
							} else if (item.af_conectividad == 3) {
								html += '<td>NO</td>'
							} else {
								html += '<td>--</td>'
							}
							if (item.af_fttn == 1) {
								html += '<td>SI</td>'
							} else if (item.af_fttn == 2) {
								html += '<td>RI</td>'
							} else if (item.af_fttn == 3) {
								html += '<td>NO</td>'
							} else {
								html += '<td>--</td>'
							}
							if (item.af_otros == 1) {
								html += '<td>SI</td>'
							} else if (item.af_otros == 2) {
								html += '<td>RI</td>'
							} else if (item.af_otros == 3) {
								html += '<td>NO</td>'
							} else {
								html += '<td>--</td>'
							}
							// maiteben_20160705_fin

							switch (item.estados) {
								case 'Registrado':
									html += '<td><img src="images/ico/send4.png" width="20"  heigth="20" title="'+item.estados+'"/></td>'
									break;
								case 'Pendiente Info':
									html += '<td><img src="images/ico/speech140.png" width="20" heigth="20" title="'+item.estados+'"/></td>'
									break;
								case 'Asignado':
									html += '<td><img src="images/ico/settings49.png" width="20" heigth="20" title="'+item.estados+'"/></td>'
									break;
								case 'Pendiente CAB':
									html += '<td><img src="images/ico/speedometer10.png" width="20" heigth="20" title="'+item.estados+'"/></td>'
									break;
								case 'Aceptado':
									if (item.aceptado_env == 'no') {
										html += '<td><img src="images/ico/thumb36.png" width="20" heigth="20" title="'+item.estados+'"/></td>'
									}
									if (item.aceptado_env == 'si') {
										html += '<td><img src="images/ico/email109.png" width="20" heigth="20" title="Enviado"/></td>'
									}
									break;
								case 'Realizado':
									html += '<td><img src="images/ico/white65.png" width="20" heigth="20" title="'+item.estados+'"/></td>'
									break;
								case 'Cancelado':
									html += '<td><img src="images/ico/blocking.png" width="20" heigth="20" title="'+item.estados+'"/></td>'
									break;
								case 'Anulado':
									html += '<td><img src="images/ico/prohibited4.png" width="20" heigth="20" title="'+item.estados+'"/></td>'
									break;
								case 'Rechazado':
									html += '<td><img src="images/ico/thumbs25.png" width="20" heigth="20" title="'+item.estados+'"/></td>'
									break;
							}
							html += '<td><a href="forms/consulta_solicitud_ejec.php?jobcode='+item.codigo+'&mode=1" id="'+item.codigo+'" class="fancybox fancybox.iframe"><img src="images/ico/visibility1.png" width="20" heigth="20"/></a></td>'
							if (item.perfil != 6) {
								html += '<td><a href="forms/consulta_solicitud_ejec.php?jobcode='+item.codigo+'&mode=2" id="'+item.codigo+'" class="fancybox fancybox.iframe"><img src="images/ico/pencil43.png" width="20" heigth="20"/></a></td>'
							} else {
								html += '<td><img src="images/ico/pencil43.png" width="20" heigth="20"/></a></td>'
							}
							if (item.perfil != 6) {
								html += '<td><a href="functions/process_solicitud.php?accion=cancelar&solicitud='+item.codigo+'&view=4" id="'+item.codigo+'" onclick="validarCancelar()" class="btn_elim"><img src="images/ico/rubbish.png" width="20" heigth="20"/></a></td>'	
							} else {
								html += '<td><img src="images/ico/rubbish.png" width="20" heigth="20"/></a></td>'	
							}
						html += '</tr>';									
					});					
				}
				if(html == '') html = '<tr><td colspan="14" align="center">No se encontraron registros..</td></tr>'
				$("#data_ejec tbody").html(html);
			}
	  });
}

function filtrar_cab()
{	
	$.ajax({
		data: $("#frm_filtro_cab").serialize()+ordenar,
		type: "POST",
		dataType: "json",
		url: "./functions/ajax.php?action=listar_cab",
			success: function(data){
				var html = '';
				if(data.length > 0){
					$.each(data, function(i,item){
						html += '<tr>'
							if (item.prioridad == 1){
								html += '<td><img src="images/ico/number41.png" width="20" heigth="20"/></td>'
							}
							if (item.prioridad == 2){
								html += '<td><img src="images/ico/number40.png" width="20" heigth="20"/></td>'
							}
							html += '<td>'+item.identificador+'</td>'
							html += '<td>'+item.remedy+'</td>'
							html += '<td>'+item.fechaini_pro+'</td>'
							html += '<td>'+item.fechafin_pro+'</td>'
							html += '<td>'+item.fechaini_apro+'</td>'
							html += '<td>'+item.fechafin_apro+'</td>'
							html += '<td>'+item.semana+'</td>'
							html += '<td>'+item.provincia+'</td>'
							html += '<td>'+item.central+'</td>'
							html += '<td>'+item.camara+'</td>'
							html += '<td>'+item.nc_riesgo+'</td>'
							html += '<td>'+item.nc_caidos+'</td>'

							// maiteben_20160705
							if (item.af_conectividad == 1) {
								html += '<td>SI</td>'
							} else if (item.af_conectividad == 2) {
								html += '<td>RI</td>'
							} else if (item.af_conectividad == 3) {
								html += '<td>NO</td>'
							} else {
								html += '<td>--</td>'
							}
							if (item.af_fttn == 1) {
								html += '<td>SI</td>'
							} else if (item.af_fttn == 2) {
								html += '<td>RI</td>'
							} else if (item.af_fttn == 3) {
								html += '<td>NO</td>'
							} else {
								html += '<td>--</td>'
							}
							if (item.af_otros == 1) {
								html += '<td>SI</td>'
							} else if (item.af_otros == 2) {
								html += '<td>RI</td>'
							} else if (item.af_otros == 3) {
								html += '<td>NO</td>'
							} else {
								html += '<td>--</td>'
							}
							// maiteben_20160705_fin


							switch (item.estado) {
								case 'Registrado':
									html += '<td><img src="images/ico/send4.png" width="20"  heigth="20" title="'+item.estado+'"/></td>'
									break;
								case 'Pendiente Info':
									html += '<td><img src="images/ico/speech140.png" width="20" heigth="20" title="'+item.estado+'"/></td>'
									break;
								case 'Asignado':
									html += '<td><img src="images/ico/settings49.png" width="20" heigth="20" title="'+item.estado+'"/></td>'
									break;
								case 'Pendiente CAB':
									html += '<td><img src="images/ico/speedometer10.png" width="20" heigth="20" title="'+item.estado+'"/></td>'
									break;
								case 'Aceptado':
									if (item.aceptado_env == 'no') {
										html += '<td><img src="images/ico/thumb36.png" width="20" heigth="20" title="'+item.estado+'"/></td>'
									}
									if (item.aceptado_env == 'si') {
										html += '<td><img src="images/ico/email109.png" width="20" heigth="20" title="Enviado"/></td>'
									}
									break;
								case 'Realizado':
									html += '<td><img src="images/ico/white65.png" width="20" heigth="20" title="'+item.estado+'"/></td>'
									break;
								case 'Cancelado':
									html += '<td><img src="images/ico/blocking.png" width="20" heigth="20" title="'+item.estado+'"/></td>'
									break;
								case 'Anulado':
									html += '<td><img src="images/ico/prohibited4.png" width="20" heigth="20" title="'+item.estado+'"/></td>'
									break;
								case 'Rechazado':
									html += '<td><img src="images/ico/thumbs25.png" width="20" heigth="20" title="'+item.estado+'"/></td>'
									break;
							}

							html += '<td><a href="forms/consulta_solicitud_cab.php?jobcode='+item.codigo+'&mode=1" id="'+item.codigo+'" class="fancybox fancybox.iframe"><img src="images/ico/visibility1.png" width="20" heigth="20"/></a></td>'
							html += '<td>'
							/*if (item.perfil == 2 && (item.estado === 'Asignado' || item.estado === 'Pendiente CAB' || item.estado === 'Pendiente Info')){
								html += '<a href="forms/consulta_solicitud_cab.php?jobcode='+item.codigo+'&mode=2" id="'+item.codigo+'" class="fancybox fancybox.iframe"><img src="images/ico/pencil43.png" width="20" heigth="20"/></a>'							
							}*/
							if (item.perfil == 4 || item.perfil == 1){
								html += '<a href="forms/consulta_solicitud_cab.php?jobcode='+item.codigo+'&mode=2" id="'+item.codigo+'" class="fancybox fancybox.iframe"><img src="images/ico/pencil43.png" width="20" heigth="20"/></a>'							
							}
							html += '</td>'
							html += '<td>'
							/*if ( item.perfil == 2 && (item.estado === 'Asignado' || item.estado === 'Pendiente Info' || item.estado === 'Pendiente CAB')) {
								html += '<a href="functions/process_solicitud.php?accion=cancelar&solicitud='+item.codigo+'" id="'+item.codigo+'" onclick="validarCancelar()" class="btn_elim"><img src="images/ico/rubbish.png" width="20" heigth="20"/></a>'
							}*/
							if ( item.perfil == 4 || item.perfil == 1) {
								html += '<a href="functions/process_solicitud.php?accion=cancelar&solicitud='+item.codigo+'&view=7" id="'+item.codigo+'" onclick="validarCancelar()" class="btn_elim"><img src="images/ico/rubbish.png" width="20" heigth="20"/></a>'
							}
							html += '</td>'							
						html += '</tr>';									
					});					
				}
				if(html == '') html = '<tr><td colspan="16" align="center">No se encontraron registros..</td></tr>'
				$("#data_cab tbody").html(html);
			}
	  });
}

function filtrar_tbuser()
{	
	$.ajax({
		data: $("#frm_filtro_usu").serialize()+ordenar,
		type: "POST",
		dataType: "json",
		url: "./functions/ajax.php?action=listar_usu",
			success: function(data){
				var html = '';
				if(data.length > 0){
					$.each(data, function(i,item){
						html += '<tr>'
							html += '<td>'+item.nombre+'</td>'
							html += '<td>'+item.usuario+'</td>'
							html += '<td>'+item.email+'</td>'
							html += '<td>'+item.perfil+'</td>'
							html += '<td>'+item.region+'</td>'
							html += '<td><a href="forms/consulta_usuarios.php?cod_usu='+item.cod+'&mode=1" id="'+item.cod+'" class="fancybox fancybox.iframe"><img src="images/ico/visibility1.png" width="20" heigth="20"/></a></td>'
							html += '<td><a href="forms/consulta_usuarios.php?cod_usu='+item.cod+'&mode=2" id="'+item.cod+'" class="fancybox fancybox.iframe"><img src="images/ico/pencil43.png" width="20" heigth="20"/></a></td>'
							html += '<td><a href="functions/process_solicitud.php?accion=eliminar_usu&cod_usu='+item.cod+'&view=51" id="'+item.cod+'" onclick="validarCancelar()" class="btn_elim"><img src="images/ico/rubbish.png" width="20" heigth="20"/></a></td>'
						html += '</tr>';									
					});					
				}
				if(html == '') html = '<tr><td colspan="9" align="center">No se encontraron registros..</td></tr>'
				$("#data_user tbody").html(html);
			}
	  });
}

function filtrar_tbprovincias()
{	
	$.ajax({
		data: $("#frm_filtro_prov").serialize()+ordenar,
		type: "POST",
		dataType: "json",
		url: "./functions/ajax.php?action=listar_prov",
			success: function(data){
				var html = '';
				if(data.length > 0){
					$.each(data, function(i,item){
						html += '<tr>'
							html += '<td>'+item.provincia+'</td>'
							html += '<td>'+item.region+'</td>'
							html += '<td><a href="forms/consulta_provincias.php?cod_prov='+item.cod+'&mode=1" id="'+item.cod+'" class="fancybox fancybox.iframe"><img src="images/ico/visibility1.png" width="20" heigth="20"/></a></td>'
							html += '<td><a href="forms/consulta_provincias.php?cod_prov='+item.cod+'&mode=2" id="'+item.cod+'" class="fancybox fancybox.iframe"><img src="images/ico/pencil43.png" width="20" heigth="20"/></a></td>'
							html += '<td><a href="functions/process_solicitud.php?accion=eliminar_prov&cod_prov='+item.cod+'&view=52" onclick="validarCancelar()" id="'+item.cod+'" class="btn_elim"><img src="images/ico/rubbish.png" width="20" heigth="20"/></a></td>'
						html += '</tr>';									
					});					
				}
				if(html == '') html = '<tr><td colspan="9" align="center">No se encontraron registros..</td></tr>'
				$("#data_prov tbody").html(html);
			}
	  });
}

function filtrar_tbcentrales()
{	
	$.ajax({
		data: $("#frm_filtro_centr").serialize()+ordenar,
		type: "POST",
		dataType: "json",
		url: "./functions/ajax.php?action=listar_centr",
			success: function(data){
				var html = '';
				if(data.length > 0){
					$.each(data, function(i,item){
						html += '<tr>'
							html += '<td>'+item.central+'</td>'
							html += '<td>'+item.provincia+'</td>'
							html += '<td>'+item.region+'</td>'
							html += '<td><a href="forms/consulta_centrales.php?cod_cent='+item.cod+'&mode=1" id="'+item.cod+'" class="fancybox fancybox.iframe"><img src="images/ico/visibility1.png" width="20" heigth="20"/></a></td>'
							html += '<td><a href="forms/consulta_centrales.php?cod_cent='+item.cod+'&mode=2" id="'+item.cod+'" class="fancybox fancybox.iframe"><img src="images/ico/pencil43.png" width="20" heigth="20"/></a></td>'
							html += '<td><a href="functions/process_solicitud.php?accion=eliminar_cent&cod_cent='+item.cod+'&view=53" id="'+item.cod+'" class="btn_elim"><img src="images/ico/rubbish.png" width="20" heigth="20"/></a></td>'
						html += '</tr>';									
					});					
				}
				if(html == '') html = '<tr><td colspan="9" align="center">No se encontraron registros..</td></tr>'
				$("#data_centr tbody").html(html);
			}
	  });
}

function filtrar_tbresponsables()
{	
	$.ajax({
		data: $("#frm_filtro_responsable").serialize()+ordenar,
		type: "POST",
		dataType: "json",
		url: "./functions/ajax.php?action=listar_responsable",
			success: function(data){
				var html = '';
				if(data.length > 0){
					$.each(data, function(i,item){
						html += '<tr>'
							html += '<td>'+item.nombre+'</td>'
							html += '<td>'+item.telefono+'</td>'
							html += '<td><a href="forms/consulta_responsables.php?cod_resp='+item.cod+'&mode=1" id="'+item.cod+'" class="fancybox fancybox.iframe"><img src="images/ico/visibility1.png" width="20" heigth="20"/></a></td>'
							html += '<td><a href="forms/consulta_responsables.php?cod_resp='+item.cod+'&mode=2" id="'+item.cod+'" class="fancybox fancybox.iframe"><img src="images/ico/pencil43.png" width="20" heigth="20"/></a></td>'
							html += '<td><a href="functions/process_solicitud.php?accion=eliminar_resp&cod_resp='+item.cod+'&view=54" id="'+item.cod+'" class="btn_elim"><img src="images/ico/rubbish.png" width="20" heigth="20"/></a></td>'
						html += '</tr>';									
					});					
				}
				if(html == '') html = '<tr><td colspan="5" align="center">No se encontraron registros..</td></tr>'
				$("#data_responsable tbody").html(html);
			}
	  });
}
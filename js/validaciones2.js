function validarFechaMenorActual(date){
      var x=new Date();
      var fecha = date.split("/");
      x.setFullYear(fecha[2],fecha[1]-1,fecha[0]);
      var today = new Date();
 
      if (x >= today)
        return false;
      else
        return true;
}

function validarCancelar() {
	if (confirm('¿Esta seguro que desea realizar esta acción?')){
		return true;
	}
	else {
		return false;
	}
}

function validarSolicitud() {

	var grupo_s = document.forms["solicitud_ssr"]["grupo_s"].value;
	var responsable = document.forms["solicitud_ssr"]["responsable"].value;
	var tlf_resp = document.forms["solicitud_ssr"]["tlf_resp"].value;
	var central = document.forms["solicitud_ssr"]["central"].value;
	var cam_front = document.forms["solicitud_ssr"]["cam_front"].value;
	var empresa = document.forms["solicitud_ssr"]["empresa"].value;
	var tecnico = document.forms["solicitud_ssr"]["tecnico"].value;
	var tlf_tec = document.forms["solicitud_ssr"]["tlf_tec"].value;
	var fechaini = document.forms["solicitud_ssr"]["fechaini"].value;
	var fechafin = document.forms["solicitud_ssr"]["fechafin"].value;
	var pro_hora_ini = document.forms["solicitud_ssr"]["pro_hora_ini"].value;
	var pro_hora_fin = document.forms["solicitud_ssr"]["pro_hora_fin"].value;
	var proyecto = document.forms["solicitud_ssr"]["proyecto"].value;
	var descripcion = document.forms["solicitud_ssr"]["descripcion"].value;
	var encuesta1 = document.forms["solicitud_ssr"]["encuesta1"].value;

	if (grupo_s == null || grupo_s == 0) {
        alert("Debe seleccionar un GRUPO SOLICITANTE");
        return false;
    }

    if (responsable == null || responsable == 0) {
        alert("Debe seleccionar un RESPONSABLE JAZZTEL");
        return false;
    }

    if (tlf_resp == null || tlf_resp == '' /*|| tlf_resp.length != 9*/) {
        alert("Debe llenar el campo TELEFONO RESPONSABLE JAZZTEL o introducir un valor válido");
        return false;
    }

    if (central == null || central == 0) {
        alert("Debe seleccionar una CENTRAL");
        return false;
    }

    if (tlf_resp == null || tlf_resp == '') {
        alert("Debe llenar el campo CÁMARA FRONTERA");
        return false;
    }

    if (empresa == null || empresa == 0) {
        alert("Debe seleccionar una EMPRESA QUE REALIZA EL CAMBIO");
        return false;
    }

    if (tecnico == null || tecnico == 0) {
        alert("Debe seleccionar una TÉCNICO EJECUCÍON");
        return false;
    }

    if (tlf_tec == null || tlf_tec == '' /*|| tlf_resp.length != 9*/) {
        alert("Debe llenar el campo TELÉFONO TÉCNICO o introducir un valor válido");
        return false;
    }
    //revisar esta validación
    if (validarFechaMenorActual(fechaini)) {
    	alert("FECHA PROPUESTA INICIO seleccionada es menor a la fecha actual, por favor seleccione una fecha valida");
		return false;
    }

    if((Date.parse(fechaini)) > (Date.parse(fechafin))){
    	alert("FECHA PROPUESTA INICIO no puede ser mayor a la FECHA APROBADA FIN");
		return false;
    }

    if((Date.parse(fechafin)) < (Date.parse(fechaini))){
    	alert("FECHA PROPUESTA FIN no puede ser menor a la FECHA APROBADA INICIO");
		return false;
    }

    if (pro_hora_ini == '') {
        alert("Debe llenar el campo HORA INICIO");
        return false;
    }

    if (pro_hora_fin == '') {
        alert("Debe llenar el campo HORA FIN");
        return false;
    }

    if (proyecto == null || proyecto == '') {
        alert("Debe llenar el campo PROYECTO");
        return false;
    }

    if (descripcion == null || descripcion == '') {
        alert("Debe llenar el campo DESCRIPCIÓN");
        return false;
    }

    if (encuesta1 == null || encuesta1 == 0) {
        alert("Debe seleccionar una UBICACIÓN DE LA CÁMARA FRONTERA y llenar los campos de la encuesta");
        return false;
    }
}

function validarEstudio() {

	var actividad = document.forms["revision_ssr"]["actividad"].value;
	var descrip_act = document.forms["revision_ssr"]["descrip_act"].value;
	var tipo_cambio = document.forms["revision_ssr"]["tipo_cambio"].value;
	var nc_riesgo = document.forms["revision_ssr"]["nc_riesgo"].value;
	var nc_afectados = document.forms["revision_ssr"]["nc_afectados"].value;
	var nc_centrex = document.forms["revision_ssr"]["nc_centrex"].value;
	var riesgo = document.forms["revision_ssr"]["riesgo"].value;
	var remedy = document.forms["revision_ssr"]["remedy"].value;
	var estado = document.forms["revision_ssr"]["estado"].value;	
	var m_rechazo = document.forms["revision_ssr"]["m_rechazo"].value;
	var observaciones = document.forms["revision_ssr"]["observaciones"].value;
    var tipo_act = document.forms["revision_ssr"]['tipo_act'].value;

	if (estado == 'Pendiente Info') {
		if (observaciones == null || observaciones == '') {
    		alert("Si el estado del estudio es Pendiente Info entonces debe llenar el campo OBSERVACIONES");
    		return false;
    	}
    	/*if (actividad == null || actividad == 0) {
        	alert("Debe seleccionar una ACTIVIDAD");
        	return false;
    	}*/

        if (tipo_act == null || tipo_act == 0) {
            alert("Debe seleccionar un TIPO DE ACTUACIÓN");
            return false;
        }

	    if (descrip_act == null || descrip_act == '') {
	        alert("Debe introducir una DESCRIPCION ACTIVIDAD");
	        return false;
	    }

	    if (tipo_cambio == null || tipo_cambio == 0) {
	        alert("Debe seleccionar un TIPO DE CAMBIO");
	        return false;
	    }
	}

	if (estado == 'Rechazado') {
		if (m_rechazo == null || m_rechazo == 0) {
    		alert("Si el estado del estudio es 	RECHAZADO entonces debe seleccionar un ESTADO RECHAZO");
    		return false;
    	}
    	/*if (actividad == null || actividad == 0) {
        	alert("Debe seleccionar una ACTIVIDAD");
        	return false;
    	}*/

	    if (descrip_act == null || descrip_act == '') {
	        alert("Debe introducir una DESCRIPCION ACTIVIDAD");
	        return false;
	    }

	    if (tipo_cambio == null || tipo_cambio == 0) {
	        alert("Debe seleccionar un TIPO DE CAMBIO");
	        return false;
	    }

         if (tipo_act == null || tipo_act == 0) {
            alert("Debe seleccionar un TIPO DE ACTUACIÓN");
            return false;
        }
	}

	if (estado == 'Pendiente CAB'){

         if (tipo_act == null || tipo_act == 0) {
            alert("Debe seleccionar un TIPO DE ACTUACIÓN");
            return false;
        }

		/*if (actividad == null || actividad == 0) {
	        alert("Debe seleccionar una ACTIVIDAD");
	        return false;
	    }*/

	    if (descrip_act == null || descrip_act == '') {
	        alert("Debe introducir una DESCRIPCION ACTIVIDAD");
	        return false;
	    }

	    if (tipo_cambio == null || tipo_cambio == 0) {
	        alert("Debe seleccionar un TIPO DE CAMBIO");
	        return false;
	    }

	    if (nc_riesgo == null || nc_riesgo == '') {
	        alert("Debe introducir Nº CLIENTES RIESGO o colocal cero de no haber");
	        return false;
	    }

	    if (nc_afectados == null || nc_afectados == '') {
	        alert("Debe introducir Nº CLIENTES AFECTADOS o colocal un CERO de no haber");
	        return false;
	    }

	    if (nc_centrex == null || nc_centrex == '') {
	        alert("Debe introducir Nº CLIENTES CENTREX o colocal un CERO de no haber");
	        return false;
	    }

	    if (riesgo == null || riesgo == '') {
	        alert("Debe introducir un riesgo en el campo RIESGO");
	        return false;
	    }

		if (remedy == null || remedy == '') {
	        alert("Debe introducir un numero de REMEDY");
	        return false;
	    }

	    if (remedy.length < 7 || remedy.length > 15) {
	    	alert("Numero de REMEDY no valido");
	    	return false;
	    }

	}
	
    if (estado == null || estado == 0) {
    	alert("Debe seleccionar un ESTADO");
    	return false;
    }      			
}

function validacionCab() {
	var apro_fechaini = document.forms["revision_cab"]["apro_fechaini"].value;
	var arpo_fechafin = document.forms["revision_cab"]["apro_fechafin"].value;
	var apro_hora_ini = document.forms["revision_cab"]["apro_hora_ini"].value;
	var apro_hora_fin = document.forms["revision_cab"]["apro_hora_fin"].value;

	if (validarFechaMenorActual(apro_fechaini)) {
    	alert("FECHA PROPUESTA INICIO seleccionada es menor a la fecha actual, por favor seleccione una fecha valida");
		return false;
    }

    if (validarFechaMenorActual(apro_fechafin)) {
    	alert("FECHA PROPUESTA FIN seleccionada es menor a la fecha actual, por favor seleccione una fecha valida");
		return false;
    }

    if((Date.parse(apro_fechaini)) > (Date.parse(apro_fechafin))){
    	alert("FECHA APROBADA INICIO no puede ser mayor a la FECHA APROBADA FIN");
		return false;
    }

    if((Date.parse(apro_fechafin)) < (Date.parse(apro_fechaini))){
    	alert("FECHA APROBADA FIN no puede ser menor a la FECHA APROBADA INICIO");
		return false;
    }

    if (apro_hora_ini == '') {
        alert("Debe llenar el campo HORA INICIO");
        return false;
    }

    if (apro_hora_fin == '') {
        alert("Debe llenar el campo HORA INICIO");
        return false;
    }	
}

function validacionEjec() {
	var f_apertura = document.forms["revision_ejec"]["f_apertura"].value;
	var ejec_ini = document.forms["revision_ejec"]["ejec_ini"].value;
	var ejec_fin = document.forms["revision_ejec"]["ejec_fin"].value;
	var apert_hora_ini = document.forms["revision_ejec"]["apert_hora_ini"].value;
	var ejec_hora_ini = document.forms["revision_ejec"]["ejec_hora_ini"].value;
	var ejec_hora_fin = document.forms["revision_ejec"]["ejec_hora_fin"].value;
	var ini_ret = document.forms["revision_ejec"]["ini_ret"].value;
	var afect_derv = document.forms["revision_ejec"]["afect_derv"].value;
	var comunicado = document.forms["revision_ejec"]["comunicado"].value;

	if (f_apertura == null || f_apertura == '') {
        alert("Debe llenar el campo FECHA/HORA APERTURA");
        return false;
    }

    if (ejec_ini == null || ejec_ini == '') {
        alert("Debe llenar el campo FECHA/HORA EJECUCION INICIO");
        return false;
    }

    if (ejec_fin == null || ejec_fin == '') {
        alert("Debe llenar el campo FECHA/HORA EJECUCION FIN");
        return false;
    }

	if (apert_hora_ini == '') {
        alert("Debe llenar el campo FECHA/HORA APERTURA");
        return false;
    }

    if (ejec_hora_ini == '') {
        alert("Debe llenar el campo FECHA/HORA EJECUCION INICIO");
        return false;
    }

    if (ejec_hora_fin == '') {
        alert("Debe llenar el campo FECHA/HORA EJECUCION FIN");
        return false;
    }

	if (ini_ret == null || ini_ret == '') {
        alert("Debe llenar el campo ¿INICIO RETRASADO?");
        return false;
    }

    if (afect_derv == null || afect_derv == '') {
        alert("Debe llenar el campo ¿AFECTACIONES DERIVADAS?");
        return false;
    }  

    if (comunicado == null || comunicado == '') {
        alert("Debe llenar el campo ¿COMUNICADO?");
        return false;
    }            
}

function validarGuardarUsu() {
    var nombre_completo = document.forms["admin_usu"]["nombre_completo"].value;
    var login = document.forms["admin_usu"]["login"].value;
    var password = document.forms["admin_usu"]["password"].value;
    var email = document.forms["admin_usu"]["email"].value;
    var dni = document.forms["admin_usu"]["dni"].value;
    var perfil_usu = document.forms["admin_usu"]["perfil_usu"].value;
    var region = document.forms["admin_usu"]["region"].value;

    if (nombre_completo == '' || nombre_completo == null){
        alert("Debe llenar el campo NOMBRE COMPLETO del usuario");
        return false;
    }
    if (login == '' || login == null){
        alert("Debe llenar el campo NOMBRE DE USUARIO");
        return false;
    }
    if (password == '' || password == null) {
        alert("Debe llenar el campo PASSWORD del usuario");
        return false;
    }
    if (email == '' || email == null) {
        alert("Debe llenar el campo DIRECCIÓN DE EMAIL");
        return false;
    }

    if (perfil_usu == 3) {
        if (dni === '') {
            alert("Debe indicar el DNI del usuario");
            return false;
        }
        if (region === '') {
            alert("Debe indicar la REGION del usuario");
            return false;
        }
    }
}

function validarGuardarCent() {
    var central = document.forms["admin_cent"]["central"].value;
    var provincia = document.forms["admin_cent"]["provincia"].value;

    if (central == '' || central == null){
        alert("Debe indicar el nombre de la central");
        return false;
    }

    if (provincia == '' || provincia == null){
        alert("Debe indicar una provincia");
        return false;
    }
}

function validarGuardarProv() {
    var iniciales = document.forms["admin_prov"]["iniciales"].value;
    var provincia = document.forms["admin_prov"]["provincia"].value;
    var regiones = document.forms["admin_prov"]["regiones"].value;

    if (provincia == '' || provincia == null){
        alert("Debe indicar un nombre de provincia");
        return false;
    }
    if (iniciales == '' || iniciales == null){
        alert("Debe indicar 2 iniciales de la provincia");
        return false;
    }
    if (regiones == '' || regiones == null){
        alert("Debe indicar una region");
        return false;
    }
}
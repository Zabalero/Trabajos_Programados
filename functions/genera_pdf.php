<?php
//============================================================+
// File name   : example_006.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 006 for TCPDF class
//               WriteHTML and RTL support
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: WriteHTML and RTL support
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');
include 'funciones.php';

$id_trabajo = $_GET['jobcode'];

// Realizamos consulta de datos
$tsql_datos = "SELECT tbTrabajos_Solicitados.COD_TRABAJO AS SOLICITUD,
                 ISNULL(RTRIM(tbUsuarios.DNI),'------') AS DNI_UC,
                 ISNULL(RTRIM(tbGrupos.DESCRIPCION),'------') AS GRUPO,
                 ISNULL(RTRIM(tbResponsables.NOMBRE_COMPLETO),'------') AS RESPONSABLE,
                 ISNULL(RTRIM(tbTipos_Actuacion.DESCRIPCION),'------') AS TIPO_ACT,
                 ISNULL(RTRIM(tbProvincias.DESCRIPCION),'-------') AS PROVINCIA,
                 ISNULL(RTRIM(tbEmpresas.DESCRIPCION),'-------') AS EMPRESA,
                 RTRIM(CONVERT(CHAR,tbTrabajos_Solicitados.FX_PROPUESTA_INICIO,103)) AS PRO_FECHAINI,
                 RTRIM(CONVERT(CHAR,tbTrabajos_Solicitados.FX_PROPUESTA_FIN,103)) AS PRO_FECHAFIN,
                 CONVERT(CHAR,tbTrabajos_Solicitados.FX_PROPUESTA_INICIO,108) AS PRO_HORAINI,
                 CONVERT(CHAR,tbTrabajos_Solicitados.FX_PROPUESTA_FIN,108) AS PRO_HORAFIN,
                 RTRIM(CONVERT(CHAR,tbTrabajos_Revisados.FX_APROBADA_INICIO,103)) AS APRO_FECHAINI,
                 RTRIM(CONVERT(CHAR,tbTrabajos_Revisados.FX_APROBADA_FIN,103)) AS APRO_FECHAFIN,
                 CONVERT(CHAR,tbTrabajos_Revisados.FX_APROBADA_INICIO,108) AS APRO_HORAINI,
                 CONVERT(CHAR,tbTrabajos_Revisados.FX_APROBADA_FIN,108) AS APRO_HORAFIN,
                 ISNULL(RTRIM(tbTrabajos_Solicitados.IDENTIFICADOR),'') AS IDENT,
                 ISNULL(RTRIM(tbResponsables.TELEFONO),'------') AS TLF_RESP,
                 ISNULL(RTRIM(tbCentrales.DESCRIPCION),'-------') AS CENTRAL,
                 ISNULL(RTRIM(tbTecnicos.NOMBRE),'-------') AS TECNICO,
                 ISNULL(RTRIM(tbTecnicos.TELEFONO),'------') AS TLF_TEC,
                 ISNULL(RTRIM(tbTrabajos_Solicitados.CAMARA_FRONTERA),'-------') AS CAMARA,
                 ISNULL(REPLACE(RTRIM(tbTrabajos_Solicitados.PROYECTO),CHAR(13),'<BR>'),'') AS PROYECTO,
                 ISNULL(REPLACE(RTRIM(tbTrabajos_Solicitados.DESCRIPCION),CHAR(13),'<BR>'),'') AS DESCRIPCION,
                 ISNULL(REPLACE(RTRIM(tbTrabajos_Revisados.COMENTARIOS),CHAR(13),'<BR>'),'') AS OBSERVACIONES,
                 ISNULL(RTRIM(tbTrabajos_Revisados.REMEDY),'-------') AS REMEDY,
                 ISNULL(RTRIM(tbUsuarios.NOMBRE_COMPLETO),'---') AS USU_SSR,
                 ISNULL(RTRIM(tbUbicaciones.DESCRIPCION),'---') AS UBICACION,
                 ISNULL(RTRIM(tbTrabajos_Solicitados.REQUIERE_PERMISO_AC),'---') AS PERMISO,
                 ISNULL(RTRIM(tbTrabajos_Solicitados.PERMISO_CONCEDIDO),'---') AS PERMISOCON,
                 ISNULL(RTRIM(tbTrabajos_Solicitados.REPLANTEO_PREVIO),'---') AS REPLANTEO,
                 ISNULL(RTRIM(tbTrabajos_Solicitados.CAMARA_OK),'---') AS CONDICIONES,

                 CASE WHEN tbTrabajos_Revisados.AF_CONECTIVIDAD = 1
                      THEN 'SI'
                      WHEN tbTrabajos_Revisados.AF_CONECTIVIDAD = 2
                      THEN 'RIESGO'
                      WHEN tbTrabajos_Revisados.AF_CONECTIVIDAD = 3
                      THEN 'NO'
                      ELSE '---'
                 END AS AF_CONECTIVIDAD,
                 CASE WHEN tbTrabajos_Revisados.AF_FTTN = 1
                      THEN 'SI'
                      WHEN tbTrabajos_Revisados.AF_FTTN = 2
                      THEN 'RIESGO'
                      WHEN tbTrabajos_Revisados.AF_FTTN = 3
                      THEN 'NO'
                      ELSE '---'
                 END AS AF_FTTN,
                 CASE WHEN tbTrabajos_Revisados.AF_OTROS = 1
                      THEN 'SI'
                      WHEN tbTrabajos_Revisados.AF_OTROS = 2
                      THEN 'RIESGO'
                      WHEN tbTrabajos_Revisados.AF_OTROS = 3
                      THEN 'NO'
                      ELSE '---'
                 END AS AF_OTROS

              FROM tbTrabajos_Solicitados 
              LEFT JOIN tbTipos_Actuacion ON tbTipos_Actuacion.COD_TIPO_ACTUACION = tbTrabajos_Solicitados.COD_TIPO_ACTUACION 
              LEFT JOIN tbResponsables ON tbTrabajos_Solicitados.COD_RESPONSABLE = tbResponsables.COD_RESPONSABLE 
              LEFT JOIN tbGrupos ON tbTrabajos_Solicitados.COD_GRUPO = tbGrupos.COD_GRUPO 
              LEFT JOIN tbCentrales ON tbTrabajos_Solicitados.COD_CENTRAL = tbCentrales.COD_CENTRAL 
              LEFT JOIN tbProvincias ON tbCentrales.COD_PROVINCIA = tbProvincias.COD_PROVINCIA 
              LEFT JOIN tbEmpresas ON tbTrabajos_Solicitados.COD_EMPRESA = tbEmpresas.COD_EMPRESA
              LEFT JOIN tbTecnicos ON tbTrabajos_Solicitados.COD_TECNICO = tbTecnicos.COD_TECNICO
              LEFT JOIN tbTrabajos_Revisados ON tbTrabajos_Revisados.COD_TRABAJO = tbTrabajos_Solicitados.COD_TRABAJO 
              LEFT JOIN tbUsuarios ON tbTrabajos_Solicitados.COD_USUARIO_CARGA = tbUsuarios.COD_USUARIO
              LEFT JOIN tbUbicaciones ON tbTrabajos_Solicitados.COD_UBICACION = tbUbicaciones.COD_UBICACION
              WHERE tbTrabajos_Solicitados.COD_TRABAJO =".$id_trabajo;

$conexion = conectar_bd();
$query_datos = sqlsrv_query($conexion,$tsql_datos);
$datos = sqlsrv_fetch_array($query_datos);

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('SSR');
$pdf->SetTitle('SOLICITUD DE TRABAJOS PROGRAMADOS');
$pdf->SetSubject('Solicitud de trabajo');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' '.$datos['IDENT'], PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/spa.php')) {
	require_once(dirname(__FILE__).'/lang/spa.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('dejavusans', '', 10);

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// Print a table

// add a page
$pdf->AddPage();
// create some HTML content
$html = '
<table id="tg-UE30u" class="tg" style="undefined;table-layout: fixed; width:650px;font-size:9px;border-collapse:collapse;border-spacing:0;margin:0px auto;background-color:#f5f5f5;">
<colgroup>
<col style="width: 214px">
<col style="width: 205px">
<col style="width: 235px">
<col style="width: 273px">
<col style="width: 260px">
<col style="width: 230px">
</colgroup> 
  <tr>
    <td class="tg-cs83" colspan="6" style="font-weight:bold;text-decoration:underline;font-size:10px;text-align:center;">
    	COMUNICACIÓN DE TRABAJOS PROGRAMADOS<br>
    </td>
  </tr>
  <tr>
    <td class="tg-wz42" colspan="6" style="text-align:center;font-weight: bold;background-color:#c0c0c0;">DATOS ADMINISTRATIVOS DEL CAMBIO</td>
  </tr>
  <tr colspan="6">
  	<br>
  </tr>
  <tr>
    <td class="tg-qkwu">GRUPO SOLICITANTE:</td>
    <td class="tg-hy62">'.strtoupper($datos['GRUPO']).'</td>
    <td class="tg-031e"></td>
    <td class="tg-qkwu"><b>IDENTIFICADOR DEL CAMBIO:</b></td>
    <td class="tg-hy62" style="text-align:left;"><BR><b>'.strtoupper($datos['IDENT']).'</b></td>
  </tr>
  <tr colspan="6">
    <br>
  </tr>
  <tr>
    <td class="tg-qkwu">RESPONSABLE JAZZTEL:</td>
    <td class="tg-hy62">'.strtoupper($datos['RESPONSABLE']).'</td>
    <td class="tg-031e"></td>
    <td class="tg-qkwu">TELÉFONO RESPONSABLE JAZZTEL:</td>
    <td class="tg-hy62">'.strtoupper($datos['TLF_RESP']).'</td>
    <td class="tg-031e"></td>
  </tr>
  <tr colspan="6">
    <br>
  </tr>
  <tr>
    <td class="tg-qkwu">TIPO ACTUACIÓN:</td>
    <td class="tg-hy62">'.strtoupper($datos['TIPO_ACT']).'</td>
    <td class="tg-031e"></td>
    <td class="tg-qkwu">PROVINCIA:</td>
    <td class="tg-hy62">'.strtoupper($datos['PROVINCIA']).'</td>
  </tr>
  <tr colspan="6">
    <br>
  </tr>
  <tr>
    <td class="tg-qkwu">CENTRAL:</td>
    <td class="tg-hy62">'.strtoupper($datos['CENTRAL']).'</td>
    <td class="tg-031e"></td>
    <td class="tg-qkwu">CÁMARA FRONTERA:</td>
    <td class="tg-hy62">'.$datos['CAMARA'].'</td>
  </tr>
  <tr colspan="6">
    <br>
  </tr>
  <tr>
    <td class="tg-qkwu">TÉCNICO EJECUCIÓN:</td>
    <td class="tg-hy62">'.strtoupper($datos['TECNICO']).'</td>
    <td class="tg-031e"></td>
    <td class="tg-qkwu">TELÉFONO TÉCNICO:</td>
    <td class="tg-hy62">'.strtoupper($datos['TLF_TEC']).'</td>
  </tr>
  <tr colspan="6">
    <br>
  </tr>
  <tr>
    <td class="tg-qkwu">EMPRESA QUE REALIZA CAMBIO:</td>
    <td class="tg-hy62">'.strtoupper($datos['EMPRESA']).'</td>
    <td class="tg-031e"></td>
    <td class="tg-qkwu"><b>REMEDY:</b></td>
    <td class="tg-hy62"><b>'.strtoupper($datos['REMEDY']).'</b></td>
  </tr>
   <tr colspan="6">
    <br>
  </tr>
  <tr>
    <td class="tg-qkwu">FECHA/HORA PROPUESTA INICIO:</td>
    <td class="tg-hy62">'.strtoupper($datos['PRO_FECHAINI']).' '.$datos['PRO_HORAINI'].'</td>
    <td class="tg-031e"></td>
    <td class="tg-qkwu">FECHA/HORA PROPUESTA FIN:</td>
    <td class="tg-hy62">'.strtoupper($datos['PRO_FECHAFIN']).' '.$datos['PRO_HORAFIN'].'</td>
    <td class="tg-031e"></td>
  </tr>
  <tr colspan="6">
  	<br>
  </tr>
  <tr>
    <td class="tg-wz42" colspan="6" style="text-align:center;font-weight: bold;background-color:#c0c0c0;">PROYECTO</td>
  </tr>
  <tr colspan="6">
  	<br>
  </tr>
  <tr>
    <td class="tg-hy62" style="background-color:#f5f5f5;" colspan="6">
    	'.strtoupper($datos['PROYECTO']).'
    </td>
  </tr>
  <tr>
  	<br>
  </tr>
  <tr>
    <td class="tg-wz42" colspan="6" style="text-align:center;font-weight: bold;background-color:#c0c0c0;">DESCRIPCIÓN DEL TRABAJO Y LISTADO DE ELEMENTOS Y FIBRAS SOBRE LAS QUE ACTUAR</td>
  </tr>
  <tr>
  	<br>
  </tr>
  <tr>
    <td class="tg-hy62" style="background-color:#f5f5f5;" colspan="6">
    	'.strtoupper($datos['DESCRIPCION']).'
    </td>
  </tr>
  <tr>
  	<br>
  </tr>
  <tr>
    <td class="tg-by3v" colspan="6" style="text-align:center;font-weight: bold;background-color:#c0c0c0;">CUESTIONARIO</td>
  </tr>
  <tr>
  	<br>
  </tr>
  <tr>
    <td class="tg-dg1h" colspan="2">Ubicación de la cámara frontera</td>
    <td class="tg-hy62" colspan="3">'.strtoupper($datos['UBICACION']).'</td>
    <td class="tg-031e" rowspan="5"></td>
  </tr>
  <tr>
    <td class="tg-qkwu" colspan="2">¿Se requiere permiso de acceso a cámara?</td>
    <td class="tg-hy62" colspan="3">'.strtoupper($datos['PERMISO']).'</td>
  </tr>
  <tr>
    <td class="tg-dg1h" colspan="2">¿Se dispone del permiso concedido?</td>
    <td class="tg-hy62" colspan="3">'.strtoupper($datos['PERMISOCON']).'</td>
  </tr>
  <tr>
    <td class="tg-dg1h" colspan="2">¿Se ha realizado replanteo previo del cambio?</td>
    <td class="tg-hy62" colspan="3">'.strtoupper($datos['REPLANTEO_PREVIO']).'</td>
  </tr>
  <tr>
    <td class="tg-dg1h" colspan="2">¿Está la cámara en condiciones para trabajar en ella?</td>
    <td class="tg-hy62" colspan="3">'.strtoupper($datos['CAMARA_OK']).'</td>
  </tr>
  <tr>
  	<br>
  </tr>
  <tr>
    <td class="tg-6f4q" colspan="6" style="text-align:center;font-weight: bold;background-color:#c0c0c0;">OBSERVACIONES (SSR)</td>
  </tr>
  <tr>
  	<br>
  </tr>
  <tr>
    <td class="tg-hy62" style="background-color:#f5f5f5;" colspan="6">
    	'.strtoupper($datos['OBSERVACIONES']).'
    </td>
  </tr>
   <tr>
  	<br>
  </tr>
  <tr>
    <td class="tg-6f4q" colspan="6" style="text-align:center;font-weight: bold;background-color:#c0c0c0;">CAB</td>
  </tr>
   <tr>
  	<br>
  </tr>
  <tr>
    <td class="tg-dg1h">FECHA/HORA ACORDADA INICIO:</td>
    <td class="tg-hy62">'.strtoupper($datos['APRO_FECHAINI']).' '.strtoupper($datos['APRO_HORAINI']).'</td>
    <td class="tg-031e"></td>
    <td class="tg-031e"></td>
    <td class="tg-dg1h">FECHA/HORA ACORDADA FIN:</td>
    <td class="tg-hy62">'.strtoupper($datos['APRO_FECHAFIN']).' '.strtoupper($datos['APRO_HORAFIN']).'</td>
  </tr>


  <tr>
    <td class="tg-6f4q" colspan="6" style="text-align:center;font-weight: bold;background-color:#c0c0c0;">AFECTACIÓN</td>
  </tr>
   <tr>
    <br>
  </tr>
  <tr>
    <td class="tg-dg1h">AF CONECTIVIDAD</td>
    <td class="tg-hy62">'.strtoupper($datos['AF_CONECTIVIDAD']).'</td>

    <td class="tg-dg1h">AF FTTN</td>
    <td class="tg-hy62">'.strtoupper($datos['AF_FTTN']).'</td>

    <td class="tg-dg1h">AF OTROS:</td>
    <td class="tg-hy62">'.strtoupper($datos['AF_OTROS']).'</td>
  </tr>
  


</table>';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');


// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('solicitud006.pdf', 'I');
sqlsrv_free_stmt($query_datos);
sqlsrv_close($conexion);
//============================================================+
// END OF FILE
//============================================================+
?>
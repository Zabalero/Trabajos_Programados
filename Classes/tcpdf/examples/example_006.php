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

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('SSR');
$pdf->SetTitle('SOLICITUD DE TRABAJOS PROGRAMADOS');
$pdf->SetSubject('Solicitud de trabajo');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);

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
//$subtable = '<table border="1" cellspacing="6" cellpadding="4"><tr><td>a</td><td>b</td></tr><tr><td>c</td><td>d</td></tr></table>';

$html = '
<table id="tg-UE30u" class="tg" style="undefined;table-layout: fixed; width:650px;font-size:9px;border-collapse:collapse;border-spacing:0;margin:0px auto;">
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
  <tr>
  	<br>
  </tr>
  <tr>
    <td class="tg-qkwu">GRUPO SOLICITANTE:</td>
    <td class="tg-hy62"></td>
    <td class="tg-031e"></td>
    <td class="tg-qkwu">IDENTIFICADOR DEL CAMBIO:</td>
    <td class="tg-hy62"></td>
    <td class="tg-031e"></td>
  </tr>
  <tr>
    <td class="tg-qkwu">RESPONSABLE JAZZTEL:</td>
    <td class="tg-hy62" colspan="2"></td>
    <td class="tg-qkwu">TELÉFONO RESPONSABLE JAZZTEL:</td>
    <td class="tg-hy62"></td>
    <td class="tg-031e"></td>
  </tr>
  <tr>
    <td class="tg-qkwu">TIPO ACTUACIÓN:</td>
    <td class="tg-hy62"></td>
    <td class="tg-031e" colspan="4"></td>
  </tr>
  <tr>
    <td class="tg-qkwu">PROVINCIA</td>
    <td class="tg-hy62"></td>
    <td class="tg-qkwu">CENTRAL:</td>
    <td class="tg-hy62"></td>
    <td class="tg-qkwu">CÁMARA FRONTERA:</td>
    <td class="tg-hy62"></td>
  </tr>
  <tr>
    <td class="tg-qkwu">EMPRESA QUE REALIZA CAMBIO</td>
    <td class="tg-hy62"></td>
    <td class="tg-qkwu">TÉCNICO EJECUCIÓN</td>
    <td class="tg-hy62"></td>
    <td class="tg-qkwu">TELÉFONO TÉCNICO:</td>
    <td class="tg-hy62"></td>
  </tr>
  <tr>
    <td class="tg-qkwu">FECHA/HORA PROPUESTA INICIO</td>
    <td class="tg-hy62"></td>
    <td class="tg-031e"></td>
    <td class="tg-qkwu">FECHA/HORA PROPUESTA FIN</td>
    <td class="tg-hy62"></td>
    <td class="tg-031e"></td>
  </tr>
  <tr>
  	<br>
  </tr>
  <tr>
    <td class="tg-wz42" colspan="6" style="text-align:center;font-weight: bold;background-color:#c0c0c0;">PROYECTO</td>
  </tr>
  <tr>
  	<br>
  </tr>
  <tr>
    <td class="tg-hy62" colspan="6">
    	<br><br><br><br><br><br>
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
    <td class="tg-hy62" colspan="6">
    	<br><br><br><br><br><br><br><br><br><br><br>
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
    <td class="tg-hy62" colspan="3"></td>
    <td class="tg-031e" rowspan="5"></td>
  </tr>
  <tr>
    <td class="tg-qkwu" colspan="2">¿Se requiere permiso de acceso a cámara?</td>
    <td class="tg-hy62" colspan="3"></td>
  </tr>
  <tr>
    <td class="tg-dg1h" colspan="2">¿Se dispone del permiso concedido?</td>
    <td class="tg-hy62" colspan="3"></td>
  </tr>
  <tr>
    <td class="tg-dg1h" colspan="2">¿Se ha realizado replanteo previo del cambio?</td>
    <td class="tg-hy62" colspan="3"></td>
  </tr>
  <tr>
    <td class="tg-dg1h" colspan="2">¿Está la cámara en condiciones para trabajar en ella?</td>
    <td class="tg-hy62" colspan="3"></td>
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
    <td class="tg-hy62" colspan="6">
    	<br><br><br><br><br><br><br><br><br><br>
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
    <td class="tg-hy62"></td>
    <td class="tg-031e"></td>
    <td class="tg-031e"></td>
    <td class="tg-dg1h">FECHA/HORA ACORDADA FIN:</td>
    <td class="tg-hy62"></td>
  </tr>
</table>';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');


// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_006.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>
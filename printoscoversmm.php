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
// Desactivar toda notificación de error
error_reporting(0);
require_once('tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);



// set document information
 
$pdf->SetAuthor(' ');
$pdf->SetTitle(' ');
$pdf->SetSubject(' ');
$pdf->SetKeywords(' ');
 

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);

// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
//$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
//$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('dejavusans', '', 10);


  

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
// add a page
$pdf->AddPage();

$pdf->SetFont("freesans", "BI",44);

# Contenido HTML del documento que queremos generar en PDF.





$cc = $_REQUEST['cc'];

for ($i = 1; $i <= $cc ; $i++) {
  
    // output some RTL HTML content
    $html="";
 

if ($_REQUEST['vnomc']=="")
{
    $html ="<br><br>";
    $html =$html . '<div style="text-align:center">'.$_REQUEST['vwo'].'<br><br><br>'.$_REQUEST['vciu'].'<br><br><br><br> '.$i.' / '.$cc.' </div>';
    $barcodeText= $_REQUEST['vwo'];
    $barcodeTextciu= $_REQUEST['vciu'];

    
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->write1DBarcode( $barcodeText, 'C128', '80', '75', '', 18, 0.4, $style, 'N');

$pdf->write1DBarcode( $barcodeTextciu, 'C128', '65', '140', '', 18, 0.4, $style, 'N');

}
else
{
    $html ="<br><br>";
    $html =$html . '<div style="text-align:center">'.$_REQUEST['vwo'].'<br><br><br>'.$_REQUEST['vnomc'].'<br><br>'.$_REQUEST['vciu'].'<br><br><br> '.$i.' / '.$cc.' </div>';
    $barcodeText= $_REQUEST['vwo'];
    $barcodeTextciu= $_REQUEST['vciu'];

    
$pdf->writeHTML($html, true, false, true, false, '');

$pdf->write1DBarcode( $barcodeText, 'C128', '80', '75', '', 18, 0.4, $style, 'N');

$pdf->write1DBarcode( $barcodeTextciu, 'C128', '75', '175', '', 18, 0.4, $style, 'N');


}
//$html =$html. '<p>aaa<img class="barcode" src="barcodephp/barcode.php?text='.$barcodeText.'&codetype=code128&orientation=horizontal&size=50&print=true"/></p>';

if ($i < $cc)
{
    $pdf->AddPage();
}



}
 
// ---------------------------------------------------------
ob_clean();
//Close and output PDF document
$pdf->Output( $_SERVER['DOCUMENT_ROOT'] . '/temppdf/example_006.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
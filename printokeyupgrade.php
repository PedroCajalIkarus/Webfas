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
$idnroor=$_REQUEST['vido'];
$idsnpara=$_REQUEST['sn'];
include("db_conect.php"); 
$sql1=" select orders_sn.idproduct,  wo_serialnumber, so_soft_external, namecustomers, modelciu as typeupgrade	, description 
from orders_sn 
inner join customers
on customers.idcustomers =  orders_sn.idcustomers
inner join fnt_select_allproducts_maxrev() as ppp
on ppp.idproduct = orders_sn.idproduct
where idorders = ".$idnroor." and wo_serialnumber <> '' and wo_serialnumber ='".$idsnpara."' ";
  
$dataheadr = $connect->query($sql1)->fetchAll();
foreach ($dataheadr as $rowhead) 
	{
        $v_name_customers =  $rowhead['namecustomers'];
        $v_wo_serialnumber =  $rowhead['wo_serialnumber'];
        $snparam=  $rowhead['wo_serialnumber'];
        $v_so_soft_external =  $rowhead['so_soft_external'];
        $v_typeupgrade  =  $rowhead['typeupgrade'];
        $v_description =  $rowhead['description'];
        $v_idproduct= $rowhead['idproduct'];
    }

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
// add a page
$pdf->AddPage();

$pdf->SetFont("Helvetica", "B",16);

# Contenido HTML del documento que queremos generar en PDF.
$html="<b>UPGRADE LICENSE</b>";
$pdf->writeHTML($html, true, false, true, false, '');
$x_pos = $pdf->GetX();
$y_pos = $pdf->GetY();
// Place image relative to end of HTML
$pdf->SetXY($x_pos-1, $y_pos - 1);
$pdf->Image('https://webfas.honeywell.com/lineatitulopdf.png',9,17,195 );

  

$sqlso ="select wo_serialnumber, so_soft_external,  modelciu  
from orders_sn inner join fnt_select_allproducts_maxrev() as ppp on ppp.idproduct = orders_sn.idproduct where   wo_serialnumber = '". $v_wo_serialnumber."' and orders_sn.typeregister = 'SO'";
$datacabbb = $connect->query($sqlso)->fetchAll();
$v_so_original = "";
 
  foreach ($datacabbb as $rowdso) 
  {
    $v_so_original =  $rowdso['modelciu'];
  }

////fnt_select_upgrade_finalsku_ia_detect_lic
  $Sql_ifupgrade2 = $connect->prepare(" select * from fnt_select_upgrade_finalsku_ia_detect_lic('".$v_so_original."','". $v_typeupgrade."') ");                                 
  $Sql_ifupgrade2->execute();
  $result_ifup2 = $Sql_ifupgrade2->fetchAll();	
  foreach ($result_ifup2 as $row_up2)
  {
   $skucalculado = $row_up2['v_fsku'];
  }

  $skucalculado-"HONBDA-D-7S33A";

  $pdf->SetFont("Helvetica", "B",8);
$pdf->SetTextColor(0, 0, 0);
$pdf->Ln();
$pdf->Cell(30,9,'Part Number:',0,'','L'); 
$pdf->SetTextColor(0, 83, 161);
$pdf->Cell(0,9,$v_so_original,0,'','L'); 
////////////////////////////////////////////////////////////

$y_pos = $pdf->GetY();
$y_pos= 18;
$pdf->SetY($y_pos);
$pdf->SetTextColor(0, 0, 0);
$pdf->Ln();
$pdf->Cell(30,9,'Serial Number:',0,'','L'); 
$pdf->SetTextColor(0, 83, 161);
$pdf->Cell(0,9,$v_wo_serialnumber,0,'','L'); 

/////////////////////////////////////////////////////
 
$y_pos= $y_pos+3;
$pdf->SetY($y_pos);
 
$pdf->SetTextColor(0, 0, 0);
$pdf->Ln();
$pdf->Cell(0,9,'_________________________________________________________________________________________________________________________',0,'','C'); 

$y_pos= $y_pos+14;
$pdf->SetY($y_pos);

$pdf->SetFont("Helvetica", "B",8);
$pdf->SetTextColor(0, 83, 161);
$pdf->SetX(9);
 
$pdf->SetY($y_pos);
$pdf->Cell(10,10,'•	'.  $v_typeupgrade,0,'','L'); 
$pdf->SetFont("Helvetica", " ",8);
$pdf->SetTextColor(0, 0, 0);

$y_pos= $y_pos+9;
$pdf->SetY($y_pos);

$pdf->SetX(11);
$pdf->SetFont("Helvetica", " ",8);
$html="Type of upgrade:";
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->SetTextColor(0, 83, 161);

$pdf->SetY($y_pos);
$pdf->SetX(34);
$html="  ".$v_description;
$pdf->writeHTML($html, true, false, true, false, '');


$pdf->SetTextColor(0, 0, 0);
$y_pos= $y_pos+8;
$pdf->SetY($y_pos);
$pdf->SetX(11);
$pdf->SetFont("Helvetica", " ",8);
$html="New Part Number:";
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->SetTextColor(0, 83, 161);

$pdf->SetY($y_pos);
$pdf->SetX(35);
$html=" ".$skucalculado;
$pdf->writeHTML($html, true, false, true, false, '');




$sqlm= "select *, v_boolean::integer as isboolean from products_attributes inner join products_attributes_type on products_attributes_type.idattribute =  products_attributes.idattribute   where products_attributes.idattribute in (94,95,96,97) and  products_attributes.idproduct =". $v_idproduct;

 // echo "<br>".$sqlm;
                       $datacabedet = $connect->query($sqlm)->fetchAll();
                        $idtemp=0;
                        $vejecucion = 1;

                        $array_licencias_habilitadas=array('');

                       
                          foreach ($datacabedet as $rowdet) 
                          {
                            if ( $rowdet['isboolean']==1)
                            {
                                $tipodesbloque= $rowdet['attributename'];
                                array_push($array_licencias_habilitadas, $tipodesbloque);
                             
              $htmlfinal="<table> ";
             
                            }
                            //print_r($array_licencias_habilitadas);
                          }


                          $sqlm2= "select * from fas_unitkeys where  sn = '". $snparam."'" ;

                     
 

                       $datacabedet2 = $connect->query($sqlm2)->fetchAll();
        
                       
                          foreach ($datacabedet2 as $rowdet3) 
                          {
                        //    echo $rowdet3['band0key'];
                            ?>

<?php
                              /////;  
                              $v="";
                              $v = array_search("UnlockerBand700",$array_licencias_habilitadas,true);
                             //  if ( $tipodesbloque=="UnlockerBand700")
                             if ( $v!="")
                                { 
								  $htmlfinal=$htmlfinal."  <tr>";
								  $htmlfinal=$htmlfinal."<th> <span style=".'"color:#000000"'."><b>Upgrade key to unlock band 700MHz [Ø=Zero]:</b></span><br> ". str_replace('0', 'Ø', $rowdet3['band0key']) ."<br></th>";
								  $htmlfinal=$htmlfinal."    </tr>";
                                 }
                                $v="";
                                $v = array_search("UnlockerBand800",$array_licencias_habilitadas,true);
                             //   echo "<br>aa".$v."bv";
                                if ( $v!="")
                               //// if ( $tipodesbloque=="UnlockerBand800")
                                {

                                  //  $htmlfinal=$htmlfinal."  <tr>";
                                 //   $htmlfinal=$htmlfinal."<th> Key to Upgrade :<br> ". str_replace('0', 'Ø', $rowdet3['band1key'])."</th>";
                                 //   $htmlfinal=$htmlfinal."    </tr>";

                                  }

                                $v="";
                                $v = array_search("Unlocker2W",$array_licencias_habilitadas,true);  
                           //     echo "aaa".$v."bbbb";                            
                                if ( $v!="")
           ///                      if ( $tipodesbloque=="Unlocker2W")
                                { 
								  $htmlfinal=$htmlfinal."  <tr>";
								  $htmlfinal=$htmlfinal."<th> <span style=".'"color:#000000"'."><b>Upgrade key to unlock 33dBm DL MaxPwr [Ø=Zero]:</b></span><br> ". str_replace('0', 'Ø', $rowdet3['maxpwrkey']) ."<br></th>";
                                  $htmlfinal=$htmlfinal."    </tr>";
                                 }
                                
                                $v="";
                                $v = array_search("UnlockerClassA",$array_licencias_habilitadas,true);
                            //    echo "aaaccccc".$v."ddddbbbb";  
                                if ( $v!="")
                                //if ( $tipodesbloque=="UnlockerClassA")
                                {
                                $htmlfinal=$htmlfinal."  <tr>";
                                $htmlfinal=$htmlfinal."  <th><span style=".'"color:#000000"'."><b> Upgrade key to unlock Class A Filtering [Ø=Zero]:</b></span> <br> ".  str_replace('0', 'Ø', $rowdet3['classkey'])."</th>";
                                $htmlfinal=$htmlfinal."    </tr>";
                                 } 
                            
                          }
                          
                          $htmlfinal=$htmlfinal."    </table><br><hr>&nbsp;";
                          $html23="<br>
                           <table align='left' border=0 style='bordercolor:#000000;color:#000000' >
                           <tr>  <td  align='left'><b>1. Disclaimer of responsibility </b>  </td> </tr>
                           <tr>  <td  align='left'><br><br>Customer is solely responsible for replacing the current identification labels on the unit with the new labels included in this envelope which reflects the configuration upgrade conducted according to Customer’s request. Fiplex accepts no liability whatsover in this regard. <br></td> </tr>
                           <tr>  <td  align='left'><b>2. Scan QR Code for Instructions on How to Apply License:</b><br> <img src=".'"https://webfas.honeywell.com/fire-vidyard-qr-code.jpg"'." width=".'"80px"'."  ></td> </tr>
                           <tr>  <td  align='left'><b>3. Instructions to update labels on unit</b> </td> </tr>
                           <tr>  <td  align='left'><br><br>Customer should replace the following labels:<br> 
                           (A) Unit Label<br> 
                           (B) FCC Label Part 90  </td> </tr>

                           
                        
                          ";
            

$pdf->SetTextColor(0, 83, 161);
$y_pos= $y_pos+7;
$pdf->SetY($y_pos);
 
$pdf->SetFillColor(255, 255, 255);
$pdf->SetX(10);
$pdf->SetFont("Helvetica", " ",8);

//$pdf->writeHTML($html, true, false, true, false, '');
$pdf->writeHTML($htmlfinal, true, false, true, false, '');

$pdf->SetTextColor(0, 0, 0);

$pdf->writeHTML($html23, true, false, true, false, '');
$pdf->WriteHTML(' <tr>  <td  align="center"><img src="https://webfas.honeywell.com/instrucion_update_label.png" width="500px"  ></td> </tr>   ');
 
$htmlqr='   </table>';
 
 

/*

$pdf->SetTextColor(0, 0, 0);
$pdf->SetY(150);
$pdf->SetX(9);
$pdf->SetFont("Helvetica", " ",10);
$html="Ref Zero: Ø";
$pdf->writeHTML($html, true, false, true, false, '');
*/



$x_pos = $pdf->GetX();
$y_pos =$pdf->GetPageHeight() -38;
// Place image relative to end of HTML
$pdf->SetXY($x_pos-1, $y_pos - 1);
$pdf->Image('https://webfas.honeywell.com/lineapiepdf.PNG',9,$y_pos,195 );
 
// ---------------------------------------------------------
ob_clean();
//Close and output PDF document
$pdf->Output(  '/Upgrade_'.$v_wo_serialnumber.".pdf", 'I');

//============================================================+
// END OF FILE
//============================================================+
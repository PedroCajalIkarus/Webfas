<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<link rel="STYLESHEET" href="css/print_static.css" type="text/css" />
</head>

<body>


<div id="body">

<div id="section_header">
</div>

<div id="content">
  
<div class="page" style="font-size: 10pt">

<table style="width: 100%; font-size: 12pt;" >
<tr>
<td>
<!--  <img  width="200" height="74" src="img/Fiplex-communications-Sin-bajada.png"/> --> 
</td>
<td style="text-align: right"><strong><?php echo date("m/d/y h:m:s")?></strong></td>
</tr>
</table>

<?php
// Desactivar toda notificación de error
//error_reporting(0);
// Notificar todos los errores de PHP (ver el registro de cambios)
error_reporting(E_ALL);
 include("db_conectbypdf.php"); 
//192.168.60.26/webfas/calibrationtopdf.php?idsndib=20066097FU&iduldl=0&idmb=0
 	session_start();
	    $vparam_wo = $_REQUEST['idwop']; ///
		$vvidpo= $_REQUEST['idwop']; ///
	  //$sql = $connect->prepare("SELECT idproduct,  idpresales, idcustomers, idfamilyprod, idtypeband, idtypeproduct, products.idproduct,presales.idconfiguration, products.modelciu as ciu, idrev, so_soft_external, idruninfo, ponumber, pwrsupplytype,rcgfbwa, moden_dig, date_approved, coalesce(presales.descripcion,'-') as descripcion, ul_gain, ul_max_pwr, dl_gain, dl_max_pwr, req_ppassy, req_calibration, req_spec, req_other, nameapproved, quantity, coalesce(notes,' ') as notes, reqresources	FROM presales  inner join products on products.idproduct = presales.idproduct WHERE presales.typeregister='WO' and  idpresales = :vvidlog  and idrev in (select max(idrev) from presales  WHERE presales.typeregister='WO' and  idpresales =:vvidlog ) ");
	  $sql = $connect->prepare("SELECT orders.idproduct,  orders.idorders as idpresales , orders_sn.so_soft_external,  orders.idcustomers, orders.idfamilyprod, orders.idtypeband, orders.idtypeproduct, products.idproduct,
orders.idconfiguration, products.modelciu as ciu, orders.idrev,  orders.idruninfo, ponumber, pwrsupplytype,rcgfbwa, 
moden_dig, orders.date_approved, coalesce(orders_sn.descripcion,'-') as descripcion, ul_gain, ul_max_pwr, dl_gain, 
dl_max_pwr, req_ppassy, req_calibration, req_spec, req_other, orders.nameapproved, quantity, coalesce(orders_sn.notes,' ') as notes, reqresources

FROM orders 
inner join orders_sn
on orders_sn.idorders = orders.idorders and
orders_sn.idrev = orders.idrev  and
orders_sn.idnroserie = 0
inner join products on products.idproduct = orders.idproduct 
WHERE orders.typeregister='WO'
and  orders.idorders =:vvidlog
and orders.idrev in (select max(idrev) from orders  WHERE orders.typeregister='WO' and  idorders =:vvidlog ) ");
	  $sql->bindParam(':vvidlog', $vparam_wo);
    $sql->execute();
    $resultado = $sql->fetchAll();
	

	 foreach ($resultado as $row) 
	 {
		 $vuserruninfo = $row[2];
		$vstation = $row[3];
		$vdevice = $row[4];
	    $vmostrar = "".trim(substr($row[0],0,10))."\r\n". str_replace("###","",$row[1]);
		
		if ($row['descripcion']=="" or $row['descripcion'] == null)
		{
			$vdescrpicion = "-";
		}
		else
		{
		$vdescrpicion = $row['descripcion']	;
		}
		if ($row['notes']=="" or $row['notes'] == null)
		{
			$vnotes = "-";
		}
		else
		{
			$vnotes = $row['notes']	;
		}
		
		 
					$vv_descripcion= $vdescrpicion;
                    $vv_notes= $vnotes;
					$vv_idpresales=$row['idpresales'];
					$vv_idproduct=$row['idproduct'];
					$vv_ciu=$row['ciu'];
					$vv_idrev=$row['idrev'];
					$vv_so_soft_external=$row['so_soft_external'];
				    $vv_ponumber=$row['ponumber'];
					$vv_pwrsupplytype=$row['pwrsupplytype'];
					$vv_rcgfbwa=$row['rcgfbwa'];
					$vv_moden_dig=$row['moden_dig'];
					$vv_date_approved=$row['date_approved'];
					$vv_ul_gain="NA";
					if ($row['ul_gain'] != 9999)
					{
						$vv_ul_gain=$row['ul_gain'];
					}
					$vv_ul_max_pwr="NA";
					if ($row['ul_max_pwr'] != 9999)
					{
						$vv_ul_max_pwr=$row['ul_max_pwr'];
					}
					$vv_dl_gain="NA";
					if ($row['dl_gain'] != 9999)
					{
						$vv_dl_gain=$row['dl_gain'];
					}
					$vv_dl_max_pwr="NA";
					if ($row['dl_max_pwr'] != 9999)
					{
						$vv_dl_max_pwr=$row['dl_max_pwr'];
					}
				
					
					
				
					
				
					$vv_nameapproved=$row['nameapproved'];
				    $vv_quantity=$row['quantity'];
					$vv_reqresources=$row['reqresources'];
                    
					//echo "-".$row['req_calibration']."-";
						if ($row['req_ppassy']) 
						{
							$vv_req_ppassy="Yes";
						}
						else
						{
								$vv_req_ppassy="No";
						}
						if ($row['req_calibration']) 
						{
								$vv_req_calibration="Yes";
						}
						else
						{
								$vv_req_calibration="No";
						}
						if ($row['req_spec']) 
						{
								$vv_req_spec="Yes";
						}
						else
						{
								$vv_req_spec="No";
						}
							if ($row['req_other']) 
						{
									$vv_req_other="Yes";
						}
						else
						{
									$vv_req_other="No";
						}
			
		
	 }
	 
	

?>

<table style="width: 100%;" class="header">
<tr>
<td><h2 style="text-align: left; color:#0053a1;">INFO WORK ORDER</h2></td>
<td><h1 style="text-align: right"><?php echo $vv_so_soft_external; ?></h1></td>
</tr>
</table>



<table style="width: 100%;  border-top: 1px solid black; border-bottom: 1px solid black; font-size: 12pt;">
<tbody>
<tr>
	<td colspan="2" style="  border-bottom: 1px solid black;"> <b>CIU: </b></td><td style="  border-bottom: 1px solid black;"><?php echo $vv_ciu; ?></td><td  style="  border-bottom: 1px solid black;"> <b>Quantity: </b></td><td style="  border-bottom: 1px solid black;"><?php echo $vv_quantity; ?></td>
</tr>
<tr >
	<th align="left" style="  border-bottom: 1px solid black;">Description PO:<br></th><td colspan="4" style=" border-bottom: 1px solid black;"><?php echo $vv_descripcion; ?> </td></tr>
<tr>
	<th align="left" style="  border-bottom: 1px solid black;">Notes PO:<br></th><td colspan="4" style="  border-bottom: 1px solid black;"><?php echo $vv_notes; ?> </td>
</tr>
<tr>
	<td colspan="2" style="  border-bottom: 1px solid black;"><b>Power Supply Type:</b></td><td style="  border-bottom: 1px solid black;"><?php echo $vv_pwrsupplytype; ?></td><td style="  border-bottom: 1px solid black;"> </td><td style="  border-bottom: 1px solid black;"> </td>
</tr>
<tr><td colspan="2" style="  border-bottom: 1px solid black;"><b>RC-G for BWA:</b></td><td style="  border-bottom: 1px solid black;"> <span class="btn btn-outline-danger btn-xs"><?php echo $vv_rcgfbwa; ?></span></td><td style="  border-bottom: 1px solid black;"><b>Moden for Digital:</b></td><td style="  border-bottom: 1px solid black;"> <span class="btn btn-outline-danger btn-xs"><?php echo $vv_moden_dig; ?></span> </td>
</tr>
<tr><td colspan="2" style="  border-bottom: 1px solid black;"><b>DL gain: </b></td><td style="  border-bottom: 1px solid black;"><?php echo $vv_dl_gain; ?> (dB)</td><td style="  border-bottom: 1px solid black;"><b>UL  gain:</b></td style="  border-bottom: 1px solid black;"> <td style="  border-bottom: 1px solid black;"><?php echo $vv_ul_gain; ?> (dB)</td>
</tr>
<tr><td colspan="2" style="  border-bottom: 1px solid black;"><b>DL Max Pwr Out: </b></td><td style="  border-bottom: 1px solid black;"><?php echo $vv_dl_max_pwr; ?> (dBm)</td><td style="  border-bottom: 1px solid black;"><b>UL 	Max Pwr Out:</b></td style="  border-bottom: 1px solid black;"> <td style="  border-bottom: 1px solid black;"><?php echo $vv_ul_max_pwr; ?>  (dBm)</td>
</tr>
<tr><td colspan="2" ><br></td><td></td><td></td><td></td>
</tr>

<?php
	////mostramos los SN	
	//Si esta procesado solo muestros idnroserie >0 sino = 0
	
	 $return_arr_sn = array();
	 //echo "SELECT idnroserie, wo_serialnumber,so_soft_external, so_associed,count(distinct fas_tree_measure.iduniquebranch) as cantregisencalib   FROM orders_sn left join fas_tree_measure on fas_tree_measure.unitsn = orders_sn.wo_serialnumber WHERE idorders = :vvidlog and idnroserie > 0  and idrev in (select max(idrev) from orders_sn  WHERE typeregister='WO' and  idorders =:vvidlog )  group by idnroserie, wo_serialnumber,so_soft_external, so_associed  order by wo_serialnumber "; 
	  $sql = $connect->prepare("SELECT idnroserie, wo_serialnumber,so_soft_external, so_associed,count(distinct fas_tree_measure.iduniquebranch) as cantregisencalib   FROM orders_sn left join fas_tree_measure on fas_tree_measure.unitsn = orders_sn.wo_serialnumber WHERE idorders = :vvidlog and idnroserie > 0  and idrev in (select max(idrev) from orders_sn  WHERE typeregister='WO' and  idorders =:vvidlog )  group by idnroserie, wo_serialnumber,so_soft_external, so_associed  order by wo_serialnumber ");
	  $sql->bindParam(':vvidlog', $vvidpo);
    $sql->execute();
    $resultado3 = $sql->fetchAll();
	foreach ($resultado3 as $row2) 
	 {
		  $return_arr_sn[] = array("idpssn" => $row2['idnroserie'],
                    "wosn" => $row2['wo_serialnumber'],
					"soassocied" => $row2['so_associed'],
					"cantregisencalib" => $row2['cantregisencalib'],
                    );
					?>
					<tr>
						<td colspan="2" style="  border-bottom: 1px solid black;">SN: <b><?php echo $row2['wo_serialnumber']; ?></b> </td>
						
						<td style="  border-bottom: 1px solid black;" colspan="3"><b>Used:
										<?php
										if ($row2['so_associed'] =="")
										{
											echo "No";
										}
										else
										{
											echo $row2['so_associed'];
										}
										?>
										</b> </td>
						
					</tr>
					<?php
	 }
?>



<tr><td colspan="2"><br></td><td></td><td></td><td></td></tr>
</table>
<table style="width: 100%;  border-top: 1px solid black; border-bottom: 1px solid black; font-size: 10pt;">
<tr><th colspan="3" style="  border-bottom: 1px solid black;" align="left"><b>UNIT (DL - UL) List</b></th>
<td></td><td></td><td></td></tr>
<tr><th colspan="8"><br> </th></tr>
<?php

 //Si esta procesado solo muestros idnroserie >0 sino = 0
	   $sql = $connect->prepare("SELECT orders_sn_specs.idorders, orders_sn_specs.idrev, idch,  typedata, ul_ch_fr, dl_ch_fr, dpxlowstart, dpxlowstop, dpxhihgstart, dpxhihgstop, unitdlstart, unitdlstop, unitulstart, unitulstop, orders_sn_specs.notes FROM orders_sn_specs inner join orders_sn
ON orders_sn.idorders  = orders_sn_specs.idorders AND
orders_sn.idrev      =  orders_sn_specs.idrev AND
orders_sn.idnroserie = orders_sn_specs.idnroserie  WHERE typedata = 'UNIT' and  orders_sn.processfasserver = true  and orders_sn_specs.idnroserie >0 and  orders_sn_specs.idorders = :vvidlog   and orders_sn_specs.idrev in (select max(idrev) from orders  WHERE  idorders =:vvidlog )  
union SELECT orders_sn_specs.idorders, orders_sn_specs.idrev, idch,  typedata, ul_ch_fr, dl_ch_fr, dpxlowstart, dpxlowstop, dpxhihgstart, dpxhihgstop, unitdlstart, unitdlstop, unitulstart, unitulstop, orders_sn_specs.notes FROM orders_sn_specs inner join orders_sn
ON orders_sn.idorders  = orders_sn_specs.idorders AND
orders_sn.idrev      =  orders_sn_specs.idrev AND
orders_sn.idnroserie = orders_sn_specs.idnroserie  WHERE typedata = 'UNIT' and   orders_sn_specs.idnroserie = 0 and  orders_sn_specs.idorders = :vvidlog  and orders_sn_specs.idrev in (select max(idrev) from orders  WHERE  idorders =:vvidlog  )   order by typedata,idch ");
	  $sql->bindParam(':vvidlog', $vvidpo);
    $sql->execute();
    $resultado2 = $sql->fetchAll();
	 
	$return_arr_dpx = array();
	$return_arr_unit = array();
	 $return_arr_ch = array();

	 foreach ($resultado2 as $row2) 
	 {
		
		  if ( $row2['typedata']=="UNIT")
		 {
			  
				$vv_notes = $row2['notes'];
					
			?>
			<tr>
			
				<td colspan="2" style="width: 25%;  border-bottom: 1px solid black;">DL: Start: <b><?php echo $row2['unitdlstart'];?></b> MHz</td>
				<td colspan="2" style="width: 25%;  border-bottom: 1px solid black;">DL: Stop: <b><?php echo $row2['unitdlstop'];?></b> MHz</td>
				<td colspan="2" style="width: 25%;  border-bottom: 1px solid black;">UL: Start: <b><?php echo $row2['unitulstart'];?></b> MHz</td>
				<td colspan="2" style="width: 25%;  border-bottom: 1px solid black;">UL: Stop: <b><?php echo $row2['unitulstop'];?></b> MHz</td>
			</tr>

			<?php			
		 } 
		
				
	 }
	 if ($vv_notes <>"")
	 {
		 ?>
		 <tr><th style="  border-bottom: 1px solid black;" align="left">Note Unit:<br></th><td colspan="6" style="  border-bottom: 1px solid black;"><?php echo $vv_notes;?></td></tr>
		 <?php
	 }



?>
<tr><th colspan="8"><br> </th></tr>
<tr><th colspan="4" style="  border-bottom: 1px solid black;" align="left"><b>DPX (Low - High) List</b></th>
<td></td><td></td><td></td></tr>
<tr><th colspan="8"><br> </th></tr>
<?php

 //Si esta procesado solo muestros idnroserie >0 sino = 0
	   $sql = $connect->prepare("SELECT orders_sn_specs.idorders, orders_sn_specs.idrev, idch,  typedata, ul_ch_fr, dl_ch_fr, dpxlowstart, dpxlowstop, dpxhihgstart, dpxhihgstop, unitdlstart, unitdlstop, unitulstart, unitulstop, orders_sn_specs.notes FROM orders_sn_specs inner join orders_sn
ON orders_sn.idorders  = orders_sn_specs.idorders AND
orders_sn.idrev      =  orders_sn_specs.idrev AND
orders_sn.idnroserie = orders_sn_specs.idnroserie  WHERE typedata = 'DPX' and  orders_sn.processfasserver = true  and orders_sn_specs.idnroserie >0 and  orders_sn_specs.idorders = :vvidlog   and orders_sn_specs.idrev in (select max(idrev) from orders  WHERE  idorders =:vvidlog )  
union SELECT orders_sn_specs.idorders, orders_sn_specs.idrev, idch,  typedata, ul_ch_fr, dl_ch_fr, dpxlowstart, dpxlowstop, dpxhihgstart, dpxhihgstop, unitdlstart, unitdlstop, unitulstart, unitulstop, orders_sn_specs.notes FROM orders_sn_specs inner join orders_sn
ON orders_sn.idorders  = orders_sn_specs.idorders AND
orders_sn.idrev      =  orders_sn_specs.idrev AND
orders_sn.idnroserie = orders_sn_specs.idnroserie  WHERE typedata = 'DPX' and  orders_sn_specs.idnroserie = 0 and  orders_sn_specs.idorders = :vvidlog  and orders_sn_specs.idrev in (select max(idrev) from orders  WHERE  idorders =:vvidlog  )   order by typedata,idch ");
	  $sql->bindParam(':vvidlog', $vvidpo);
    $sql->execute();
    $resultado2 = $sql->fetchAll();
	 
	$return_arr_dpx = array();
	$return_arr_unit = array();
	 $return_arr_ch = array();

	 foreach ($resultado2 as $row2) 
	 {
		
		  if ( $row2['typedata']=="DPX")
		 {
			  			
			?>
			<tr>
				
				<td colspan="2" style="width: 25%;  border-bottom: 1px solid black;">Low Start: <b><?php echo $row2['dpxlowstart'];?></b> MHz</td>
				<td  colspan="2" style="width: 25%;  border-bottom: 1px solid black;">Low Stop: <b><?php echo $row2['dpxlowstop'];?></b> MHz</td>
				<td colspan="2" style="width: 25%;  border-bottom: 1px solid black;">High Start: <b><?php echo $row2['dpxhihgstart'];?></b> MHz</td>
				<td colspan="2" style="width: 25%; border-bottom: 1px solid black;">High Stop: <b><?php echo $row2['dpxhihgstop'];?></b> MHz</td>
			</tr>

			<?php			
		 } 
		
				
	 }
	 





 //Si esta procesado solo muestros idnroserie >0 sino = 0
	   $sql = $connect->prepare("SELECT orders_sn_specs.idorders, orders_sn_specs.idrev, idch,  typedata, ul_ch_fr, dl_ch_fr, dpxlowstart, dpxlowstop, dpxhihgstart, dpxhihgstop, unitdlstart, unitdlstop, unitulstart, unitulstop, orders_sn_specs.notes FROM orders_sn_specs inner join orders_sn
ON orders_sn.idorders  = orders_sn_specs.idorders AND
orders_sn.idrev      =  orders_sn_specs.idrev AND
orders_sn.idnroserie = orders_sn_specs.idnroserie  WHERE typedata = 'CHANNEL' and orders_sn.processfasserver = true  and orders_sn_specs.idnroserie >0 and  orders_sn_specs.idorders = :vvidlog   and orders_sn_specs.idrev in (select max(idrev) from orders  WHERE  idorders =:vvidlog )  
union SELECT orders_sn_specs.idorders, orders_sn_specs.idrev, idch,  typedata, ul_ch_fr, dl_ch_fr, dpxlowstart, dpxlowstop, dpxhihgstart, dpxhihgstop, unitdlstart, unitdlstop, unitulstart, unitulstop, orders_sn_specs.notes FROM orders_sn_specs inner join orders_sn
ON orders_sn.idorders  = orders_sn_specs.idorders AND
orders_sn.idrev      =  orders_sn_specs.idrev AND
orders_sn.idnroserie = orders_sn_specs.idnroserie  WHERE typedata = 'CHANNEL' and   orders_sn_specs.idnroserie = 0 and  orders_sn_specs.idorders = :vvidlog  and orders_sn_specs.idrev in (select max(idrev) from orders  WHERE  idorders =:vvidlog  )   order by typedata,idch ");
	  $sql->bindParam(':vvidlog', $vvidpo);
    $sql->execute();
    $resultado2 = $sql->fetchAll();
	
	
	
	
	if (count($resultado2)>0)
	{
		?>
<tr><th colspan="8"><br> </th></tr>
<tr><th colspan="4" style="  border-bottom: 1px solid black;" align="left"><b>Channels List</b></th>
<td></td><td></td><td></td></tr>
<tr><th colspan="8"><br> </th></tr>
<?php
	}
	else
	{
		?>
		<tr><th colspan="5"><br> </th></tr>
		<?php
	}
	 
	$return_arr_dpx = array();
	$return_arr_unit = array();
	 $return_arr_ch = array();

	 foreach ($resultado2 as $row2) 
	 {
			 
		  if ( $row2['typedata']=="CHANNEL")
				{
			  	
				
					$vv_chnotes = $row2['notes'];
			?>
			<tr>
				<td colspan="2" style=" width: 20%; border-bottom: 1px solid black;">#<?php echo $row2['idch'];?></td>
				<td colspan="3" style="width: 40%;  border-bottom: 1px solid black;">UL: <b><?php echo $row2['ul_ch_fr'];?></b> MHz</td>
				<td colspan="3" style="width: 40%;  border-bottom: 1px solid black;">DL: <b><?php echo $row2['dl_ch_fr'];?></b> MHz</td>
			
			</tr>

			<?php			
		 } 
		
				
	 }
	  if ($vv_chnotes <>"")
	 {
		 ?>
		 <tr><th style="  border-bottom: 1px solid black;" align="left">Note Channels:<br></th><td colspan="6" style="  border-bottom: 1px solid black;"><?php echo $vv_chnotes;?></td></tr>
		 <?php
	 }




?>



<tr><td colspan="3" style="  border-bottom: 1px solid black;"><b>Training required for PP-ASSY: </b></td>
    <td style="  border-bottom: 1px solid black;"> <span class="btn btn-outline-danger btn-xs"><?php echo $vv_req_ppassy; ?></span></td>
	<td colspan="3" style="  border-bottom: 1px solid black;"><b>Training required for Calibration:</b></td> 
	<td style="  border-bottom: 1px solid black;"> <span class="btn btn-outline-danger btn-xs"><?php echo $vv_req_calibration; ?></span> </td>
</tr>
<tr>
<td colspan="3" style="  border-bottom: 1px solid black;"><b>Special Material required: </b></td>
<td style="  border-bottom: 1px solid black;"> <span class="btn btn-outline-danger btn-xs"><?php echo $vv_req_spec; ?></span></td>
<td  colspan="3" style="  border-bottom: 1px solid black;"><b>Other:</b></td>
 <td style="  border-bottom: 1px solid black;"> <span class="btn btn-outline-danger btn-xs"><?php echo $vv_req_other; ?></span> </td>
</tr>
<tr><th colspan="4" align="left" >Description of Resources Required:<br></th>
<td colspan="3"><?php echo $vv_reqresource; ?></td></tr></tbody></table>

</div>

<script type="text/php">

if ( isset($pdf) ) {

  $font = Font_Metrics::get_font("verdana");
  // If verdana isn't available, we'll use sans-serif.
  if (!isset($font)) { Font_Metrics::get_font("sans-serif"); }
  $size = 6;
  $color = array(0,0,0);
  $text_height = Font_Metrics::get_font_height($font, $size);

  $foot = $pdf->open_object();
  
  $w = $pdf->get_width();
  $h = $pdf->get_height();

  // Draw a line along the bottom
  $y = $h - 2 * $text_height - 24;
  $pdf->line(16, $y, $w - 16, $y, $color, 1);

  $y += $text_height;

  $text = "Job: 132-003";
  $pdf->text(16, $y, $text, $font, $size, $color);

  $pdf->close_object();
  $pdf->add_object($foot, "all");

  global $initials;
  $initials = $pdf->open_object();
  
  // Add an initals box
  $text = "Initials:";
  $width = Font_Metrics::get_text_width($text, $font, $size);
  $pdf->text($w - 16 - $width - 38, $y, $text, $font, $size, $color);
  $pdf->rectangle($w - 16 - 36, $y - 2, 36, $text_height + 4, array(0.5,0.5,0.5), 0.5);
    

  $pdf->close_object();
  $pdf->add_object($initials);
 
  // Mark the document as a duplicate
  $pdf->text(110, $h - 240, "DUPLICATE", Font_Metrics::get_font("verdana", "bold"),
             110, array(0.85, 0.85, 0.85), 0, 0, -52);

  $text = "Page {PAGE_NUM} of {PAGE_COUNT}";  

  // Center the text
  $width = Font_Metrics::get_text_width("Page 1 of 2", $font, $size);
  $pdf->page_text($w / 2 - $width / 2, $y, $text, $font, $size, $color);
  
}
</script>


</body>
</html>
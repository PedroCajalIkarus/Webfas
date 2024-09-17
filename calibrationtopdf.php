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
<!-- <img  width="200" height="74" src="img/Fiplex-communications-Sin-bajada.png"/> --> 
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
	    $vparam_vnrounitsn = $_REQUEST['idsndib']; ///
		
	  $sql = $connect->prepare("select distinct products.modelciu, orders_sn.* 
from orders_sn 
inner join orders_sn_specs
on orders_sn.idorders = orders_sn_specs.idorders and
orders_sn.idrev = orders_sn_specs.idrev and 
orders_sn.idnroserie = orders_sn_specs.idnroserie
inner join products
on products.idproduct = orders_sn.idproduct
where wo_serialnumber =  '".$vparam_vnrounitsn."'");
	 /// $sql->bindParam(':vvidsndib', $vparam_vnrounitsn);
    $sql->execute();
    $resultado3 = $sql->fetchAll();
	foreach ($resultado3 as $row2) 
	 {
		 $v_powersupply = $row2['pwrsupplytype'];
		 $v_ul_gain = $row2['ul_gain'];
		 $v_ul_gain_pwr = $row2['ul_max_pwr'];
		 $v_dl_gain = $row2['dl_gain'];
		 $v_dl_gain_pwr = $row2['dl_max_pwr'];
		 $_name_ciu = $row2['modelciu'];
	 }

?>

<table style="width: 100%;" class="header">
<tr>
<td><h2 style="text-align: left; color:#0053a1;">TEST RESULTS</h2></td>
<td><h1 style="text-align: right"></h1></td>
</tr>
</table>

<table style="width: 100%;  border-top: 1px solid black; border-bottom: 1px solid black; font-size: 12pt;">
<tr>
<td style='text-align: left'>CIU: <strong><?php echo $_name_ciu;?></strong></td>
<td style='text-align: right'>SN: <strong><?php echo $vparam_vnrounitsn;?></strong></td>

</tr>
</table>

<?php
$queryinfo = "select fas_finalcheckref_result.* , runinfodb.userruninfo from fas_finalcheckref_result inner join runinfodb 	on runinfodb.idruninfodb = fas_finalcheckref_result.idruninfo  where fas_finalcheckref_result.idruninfo in(SELECT  MAX(idrununfo) as idruninfo from fas_tree_measure where fas_tree_measure.iduniquebranch like '002%' and unitsn = '".$vparam_vnrounitsn."' )";

//query mejorado
$queryinfo = "
select 2 as ordrnnn, fas_finalcheckref_result.* , runinfodb.userruninfo from fas_finalcheckref_result inner join runinfodb 	on runinfodb.idruninfodb = fas_finalcheckref_result.idruninfo  where fas_finalcheckref_result.idruninfo in(SELECT  MAX(idrununfo) as idruninfo from fas_tree_measure where fas_tree_measure.iduniquebranch like '002%' and unitsn = '".$vparam_vnrounitsn."' )
union
select 1, fas_finalcheckref_result.* , runinfodb.userruninfo from fas_finalcheckref_result inner join runinfodb 	on runinfodb.idruninfodb = fas_finalcheckref_result.idruninfo  where modelciu not in(select distinct  modelciu from products where  idproduct in (select distinct idproduct from products_attributes where v_boolean= true and idattribute = 0)) and  fas_finalcheckref_result.idruninfo in( select idrununfo from fas_tree_measure where fas_tree_measure.iduniquebranch like '002%' and unitsn = '".$vparam_vnrounitsn."'
and datetime in(
	SELECT  MAX(datetime) as idruninfo from fas_tree_measure
where fas_tree_measure.iduniquebranch like '002%' and unitsn = '".$vparam_vnrounitsn."') ) order by ordrnnn desc
";

 $datainfoVersiones = $connect->query($queryinfo)->fetchAll();
								$idtemp=0;
								$vejecucion = 1;
								  foreach ($datainfoVersiones as $rowversiones) 
								  {
									 $vv_info_gaintolerance =  $rowversiones['gaintolerance'];
									  $vv_info_maxpwrtolerance =  $rowversiones['maxpwrtolerance'];
									   $vv_info_imdlimit =  $rowversiones['imdlimit'];
									    $vv_info_nfreference =  $rowversiones['nfreference'];
										   $vv_info_spuriousreference =  $rowversiones['spuriousreference'];
									  
?>
<br>
<table style="width: 100%;  border-top: 1px solid black; border-bottom: 1px solid black; font-size: 12pt;">
<tr>
<td style='width: 20%;text-align: left'>Calibrator: <strong><?php echo $rowversiones['userruninfo'];?></strong></td>

<td style='width: 20%;text-align: left'>FAS Version: <strong><?php echo $rowversiones['fasversion'];?></strong></td>
<td style='width: 20%;text-align: left'>FW FPGA: <strong><?php echo $rowversiones['fpgafirm'];?></strong></td>
</tr>
<tr>
<td style='width: 20%;text-align: left'>FW uC: <strong><?php echo $rowversiones['ucfirm'];?></strong></td>
<td style='width: 20%;text-align: left'>FW Ethernet: <strong><?php echo $rowversiones['ethernetfirm'];?></strong></td>

</tr>
</table>

								  <?php } ?>



<h2 style="text-decoration: underline;">Parameters:</h2>
<table  style="width: 100%;font-size: 10pt;text-align: left;border-top: 1px solid black; border-bottom: 1px solid black;" >

<tbody>

<tr>
<th style="text-align: left">DL gain:</th>
<td style="text-align: left"><?php echo $v_dl_gain; ?> (dB)</td>
<th style="text-align: left">UL gain:</th>
<td style="text-align: left"><?php echo $v_ul_gain; ?> (dB)</td>
</tr>

<tr>
<th style="text-align: left">DL Max Pwr Out:</th>
<td style="text-align: left"><?php echo $v_dl_gain_pwr; ?> (dBm) </td>
<th style="text-align: left">UL Max Pwr Out:</th>
<td style="text-align: left"><?php echo $v_ul_gain_pwr; ?> (dBm) </td>
</tr>
<tr>
<th style="text-align: left" >Power Supply Type</th>
<td style="text-align: left"><?php echo $v_powersupply; ?></td>
<th style="text-align: left"></th>
<td style="text-align: left"></td>

</tr>

</tbody>
</table>
<h3 style="text-decoration: underline;">UNIT (DL - UL) List:</h3>
<table  style="width: 100%;font-size: 10pt;text-align: left;border-top: 1px solid black; border-bottom: 1px solid black;" >
<tbody>

<?php

	  $sql = $connect->prepare("select distinct idband.description as nameband,orders_sn_specs.*	 
from orders_sn 
inner join orders_sn_specs
on orders_sn.idorders = orders_sn_specs.idorders and
orders_sn.idrev = orders_sn_specs.idrev and 
orders_sn.idnroserie = orders_sn_specs.idnroserie
inner join idband
on idband.idband = orders_sn_specs.idband	
	where typedata = 'UNIT'  and  wo_serialnumber =  '".$vparam_vnrounitsn."'");
	 /// $sql->bindParam(':vvidsndib', $vparam_vnrounitsn);
    $sql->execute();
    $resultado3 = $sql->fetchAll();
	foreach ($resultado3 as $row2) 
	 {
	
		 
		 ?>
		 <tr>
		 <th style="text-align: left" >Band: <?php echo $row2['nameband']; ?></th>
		 <td style="text-align: left"> UL Start: <?php echo $row2['unitulstart']; ?> MHz</td>
		<td style="text-align: left"> UL Stop: <?php echo $row2['unitulstop']; ?> MHz</td>
		<td style="text-align: left"> DL Start: <?php echo $row2['unitdlstart']; ?> MHz</td>
		<td style="text-align: left"> DL Stop: <?php echo $row2['unitdlstop']; ?> MHz</td>
		
		</tr>
		 <?php
	 }

?>



</tbody>
</table>
<h3 style="text-decoration: underline;">DPX (Low - High) List:</h3>
<table  style="width: 100%;font-size: 10pt;text-align: left;border-top: 1px solid black; border-bottom: 1px solid black;" >
<tbody>
<?php
	  $sql = $connect->prepare("select distinct idband.description as nameband,orders_sn_specs.*	 
from orders_sn 
inner join orders_sn_specs
on orders_sn.idorders = orders_sn_specs.idorders and
orders_sn.idrev = orders_sn_specs.idrev and 
orders_sn.idnroserie = orders_sn_specs.idnroserie
inner join idband
on idband.idband = orders_sn_specs.idband	
	where typedata = 'DPX'  and  wo_serialnumber =  '".$vparam_vnrounitsn."'");
	 /// $sql->bindParam(':vvidsndib', $vparam_vnrounitsn);
    $sql->execute();
    $resultado3 = $sql->fetchAll();
	foreach ($resultado3 as $row2) 
	 {
	
		 
		 ?>
		 <tr>
		 <th style="text-align: left" >Band: <?php echo $row2['nameband']; ?></th>
		 	<td style="text-align: left"> UL Start: <?php echo $row2['dpxhihgstart']; ?> MHz</td>
		<td style="text-align: left"> UL Stop: <?php echo $row2['dpxhihgstop']; ?> MHz</td>
		<td style="text-align: left"> DL Start: <?php echo $row2['dpxlowstart']; ?> MHz</td>
		<td style="text-align: left"> DL Stop: <?php echo $row2['dpxlowstop']; ?> MHz</td>
	
		</tr>
		 <?php
	 }

?>
</tbody>
</table>
<br><br>
<table style="width: 100%; font-size: 10pt; border-top: 1px solid black; border-bottom: 1px solid black; ">
<tr>
<td style='width: 33%;text-align: left'>Gain Tolerance: <strong><?php echo $vv_info_gaintolerance;?></strong></td>
<td style='width: 33%;text-align: left'>Max Pwr Tolarance: <strong><?php echo $vv_info_maxpwrtolerance;?></strong></td>
<td style='width: 33%;text-align: left'>Noise Figure reference: <strong><?php echo $vv_info_nfreference;?></strong></td>
</tr>
<tr>
<td style='width: 33%;text-align: left'>IMD Reference: <strong><?php echo $vv_info_imdlimit;?></strong></td>
<td style='width: 33%;text-align: left'>Spurious reference: <strong><?php echo $vv_info_spuriousreference;?></strong></td>

</tr>
</table>
<br><br>
<table  style="width: 100%;font-size: 10pt;text-align: left;border-top: 2px solid black;border-right: 2px solid black;border-left: 2px solid black; border-bottom: 2px solid black;" >
<tbody>
<tr >
<th style="font-size: 10pt;text-align: left;border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black; border-bottom: 1px solid black;">Reference</th>
<th style="font-size: 10pt;text-align: center;border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black; border-bottom: 1px solid black;">Status Gain</th>
<th style="font-size: 10pt;text-align: center;border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black; border-bottom: 1px solid black;">Status MaxPower</th>
<th style="font-size: 10pt;text-align: center;border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black; border-bottom: 1px solid black;">Status NF</th>
<th style="font-size: 10pt;text-align: center;border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black; border-bottom: 1px solid black;">Status IMD</th>
<th style="font-size: 10pt;text-align: center;border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black; border-bottom: 1px solid black;">Status Spurious</th>

</tr>

<?php


  $vparam_vnrounitsn = $_REQUEST['idsndib']; ///

 $Vjd=0;
 $vtemp_idruninfo=0;
 $sql="SELECT DISTINCT uldl, band , MAX(idrununfo) as idruninfo  from fas_tree_measure where fas_tree_measure.iduniquebranch like '002%' and unitsn = '".$vparam_vnrounitsn."' GROUP BY uldl,band order by uldl,band ";
								
//	echo $sql."<br>";							
							   $datacabez = $connect->query($sql)->fetchAll();
								$idtemp=0;
								$vejecucion = 1;
								  foreach ($datacabez as $rowheaders) 
								  {
									  
									 
									  $vparam_vnrounitsn = $_REQUEST['idsndib']; ///// "20000000fu";	
									$vparam_band = $rowheaders['band'];
									$vaparam_uldl = $rowheaders['uldl'];
									
										if ( $vtemp_idruninfo <= $rowheaders['idruninfo'])
										{
											 $vtemp_idruninfo=$rowheaders['idruninfo'];
											 $vparam_idruninfo = $rowheaders['idruninfo'];
										}
										else
										{
											$vparam_idruninfo = 0;
										}
									
								  
									  
								
		  $query_lista="SELECT fas_tree_measure.totalpass::int as totalpassconvert,  fas_tree_measure.iduniqueop,  fas_step.description as namebranch,  fas_tree_measure.iduniquebranch, fas_tree_measure.unitsn, fas_tree_measure.dibsn, fas_tree_measure.uldl, fas_tree_measure.band
,fas_tree_measure.idrununfo
from fas_tree_measure
inner join fas_tree
on fas_tree.iduniquebranch = fas_tree_measure.iduniquebranch
inner join fas_step
on fas_step.idfasstep = fas_tree.idfastrepson
where fas_tree_measure.iduniquebranch  in('002007013','00200701B','00200701A','00200701C','00200701B02F0','002007030') and fas_tree_measure.iduniquebranch like '002%' and uldl = ".$vaparam_uldl ." and band = ".$vparam_band." and  unitsn = '".$vparam_vnrounitsn."' and  idrununfo =".$vparam_idruninfo. " order by iduniqueop";

	//	echo "<br>".$query_lista."<br>";
				  $dataresumen = $connect->query($query_lista)->fetchAll();
				  
				
				  ?>
        
                    <tr>
					<td style="font-size: 10pt;text-align: left;border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black; border-bottom: 1px solid black;"><?php 
						if ($vaparam_uldl ==0)
						{
					 	    $label_ULDL_amostrar ="Uplink";
						}
						else
						{
							$label_ULDL_amostrar ="Downlink";
						}
						if ($vparam_band ==0)
						{
					 	    $label_band_amostrar ="700 FirstNet";
						}
						else
						{
							$label_band_amostrar ="800";
						}
					
					echo "".$label_band_amostrar ." - ".$label_ULDL_amostrar; ?></td>
				     <?php
					   $vi=0;
					   $imgesperar = 0;
					    foreach ($dataresumen as $rowresult) 
						{
							 $vi= $vi + 1;
							if ($rowresult['totalpassconvert'] =="0")
							{
									echo "<td style='font-size: 10pt;text-align: center;border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black; border-bottom: 1px solid black;color:red'><b>Not Passed</b> </td>";
							}
							else
							{	
								if ($rowresult['totalpassconvert'] =="1")
								{
										echo "<td style='font-size: 10pt;text-align: center;border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black; border-bottom: 1px solid black;color:green'><b>Passed</b></td>";
								}
								else
								{
									
									if ($imgesperar ==0)
									{
										$imgesperar = 1;
										echo "<td style='font-size: 10pt;text-align: center;border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black; border-bottom: 1px solid black;'> - </td>";
									}
									else
									{
										echo "<td style='font-size: 10pt;text-align: center;border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black; border-bottom: 1px solid black;'> - </td>";
									}
										
								}
							}
							
							
						}
						if ( $vi==0)
						{
							if ($imgesperar ==0)
									{
										$imgesperar = 1;
										echo "<td style='font-size: 10pt;text-align: center;border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black; border-bottom: 1px solid black;'> - </td>";
									}
									else
									{
										echo "<td style='font-size: 10pt;text-align: center;border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black; border-bottom: 1px solid black;'> - </td>";
									}
							?>
							
							<td style="font-size: 10pt;text-align: center;border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black; border-bottom: 1px solid black;"> - </td>
							<td style="font-size: 10pt;text-align: center;border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black; border-bottom: 1px solid black;"> - </td>
							<td style="font-size: 10pt;text-align: center;border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black; border-bottom: 1px solid black;"> - </td>
							<td style="font-size: 10pt;text-align: center;border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black; border-bottom: 1px solid black;"> - </td>
						
							<?php
						}
					  ?>
                    </tr>
								  <?php  }?>
			



</tbody>
</table>

<br>
<br><br><br><br><br><br>

<br><br><br>
<br><br>


<?php

  foreach ($datacabez as $rowheaders) 
	{
			$vparam_vnrounitsn = $_REQUEST['idsndib']; ///// "20000000fu";	
			$vparam_band = $rowheaders['band'];
			$vaparam_uldl = $rowheaders['uldl'];
			 $vparam_idruninfo = $rowheaders['idruninfo'];
		
			
				if ($vaparam_uldl ==0)
						{
					 	    $label_ULDL_amostrar ="Uplink";
						}
						else
						{
							$label_ULDL_amostrar ="Downlink";
						}
						if ($vparam_band ==0)
						{
					 	    $label_band_amostrar ="700 FirstNet";
						}
						else
						{
							$label_band_amostrar ="800";
						}
					
					
						  $query_listacuadros="SELECT fas_tree_measure.totalpass,  fas_tree_measure.iduniqueop,  fas_step.description as namebranch,  fas_tree_measure.iduniquebranch, fas_tree_measure.unitsn, fas_tree_measure.dibsn, fas_tree_measure.uldl, fas_tree_measure.band
,fas_tree_measure.idrununfo
from fas_tree_measure
inner join fas_tree
on fas_tree.iduniquebranch = fas_tree_measure.iduniquebranch
inner join fas_step
on fas_step.idfasstep = fas_tree.idfastrepson
where  fas_tree_measure.iduniquebranch like '002%' and uldl = ".$vaparam_uldl." and  band = ".$vparam_band." and  unitsn = '".$vparam_vnrounitsn."' and  idrununfo =".$vparam_idruninfo. " order by iduniqueop";
//	echo "inicio:".$query_lista."<br>fin<br>";
				$datacuadros = $connect->query($query_listacuadros)->fetchAll();
				
				
				 unset($arrayfreq);
				  unset($array_finalchk_gain);
				   unset($array_finalchk_pwr);
				    unset($array_finalchk_noisefigshow);
					 unset($Finalchk_imd_1);
					 unset($Finalchk_imd_2);
					 unset($Finalchk_imd_3);
					 unset($Finalchk_imd_4);
					 unset($Finalchk_imdfreq);
				 
				 
				 foreach ($datacuadros as $row) 
				  {
					   if("002007013" ==$row['iduniquebranch'])
					  {
						   
						
								   
						    $query_lista5=" select * from fas_singlemeasures where iduniqueop = ".$row['iduniqueop']." order by id_singlemeasure";
						//	echo  "<br>///FinalCheck_Measures_Gain".$query_lista5;
							
							$datalsgp = $connect->query($query_lista5)->fetchAll();
							 foreach ($datalsgp as $rowlsgp1) 
								  {
									    $arrayfreq[] =round($rowlsgp1['freq'],1); 
									    $freqlabel =  $freqlabel."".round($rowlsgp1['freq'],1).",";
									    $array_finalchk_gain[] =  $rowlsgp1['gainnoagc'];
										$array_finalchk_gaingrafico=  $array_finalchk_gaingrafico."".$rowlsgp1['gainnoagc'].",";										
										$finalchk_gain_freqshow=round($rowlsgp1['freq'],1);  
								
									
								  }
							  
					  }
					     ///FinalCheck_Measures_MaxPower
						$mi = 0;
					  if("00200701A" ==$row['iduniquebranch'])
					  {
						
						
								  
								   $query_lista6=" select * from fas_mkrmeasures where iduniqueop = ".$row['iduniqueop']." order by id_mkrmeasures";
								  // echo $query_lista6;
								$datalsgp = $connect->query($query_lista6)->fetchAll();
									$mi = 0;
								foreach ($datalsgp as $rowlsgp6) 
								  {
									
									   $arrayfreqpwr[] =round($rowlsgp6['freq'],1); 
									    $freqlabelpwr =  $freqlabelpwr."".round($rowlsgp6['freq'],1).",";
									    $array_finalchk_pwr[] =  $rowlsgp6['pwr'];
										$array_finalchk_pwrgrafico=  $array_finalchk_pwrgrafico."".$rowlsgp6['pwr'].",";										
										$finalchk_gain_freqshowpwr=round($rowlsgp6['freq'],1);  
										
										
										if($mi==10)
										{
											break;
										}
										$mi=$mi+1;
								  }
							  
					  }
					  
					    if("002007031" ==$row['iduniquebranch'])
					  {
						
						//select distinct freq ,pwrin,  gainnoagc from fas_singlemeasures where iduniqueop = 503
					   //select distinct freq ,  gainnoagc from fas_singlemeasures where iduniqueop = 503
							$query_lista5="select distinct id_singlemeasure,	 freq , pwrin, gainnoagc from fas_singlemeasures where iduniqueop = ".$row['iduniqueop']." order by id_singlemeasure ";				
						    $datalsgp = $connect->query($query_lista5)->fetchAll();
							 foreach ($datalsgp as $rowlsgp1) 
								  {					
										$lblfreqmostrargrafico = round($rowlsgp1['freq'],1);
										$array_finalchk_abajo1_freq=  $array_finalchk_abajo1_freq."".round($rowlsgp1['freq'],1).",";										
										$array_finalchk_abajo1_pwrin=  $array_finalchk_abajo1_pwrin."".$rowlsgp1['pwrin'].",";										
										$array_finalchk_abajo1_gainnoagc=  $array_finalchk_abajo1_gainnoagc."".$rowlsgp1['gainnoagc'].",";										
								  }	
							$query_lista5="select id_mkrmeasures,pwr from fas_mkrmeasures where iduniqueop = ".$row['iduniqueop']." order by id_mkrmeasures ";				
						    $datalsgp = $connect->query($query_lista5)->fetchAll();
							 foreach ($datalsgp as $rowlsgp1) 
								  {										
										
										$array_finalchk_abajo2_pwr=  $array_finalchk_abajo2_pwr."".$rowlsgp1['pwr'].",";										
										
								  }	 

						$query_lista6="select *from fas_ucmeasures where iduniqueop = ".$row['iduniqueop']." order by id_ucmeasures  ";		
					//	echo "<br>".$query_lista6;
						    $datalsgp = $connect->query($query_lista6)->fetchAll();
							 foreach ($datalsgp as $rowlsgp16) 
								  {										
										
										$array_finalchk_abajo3_uclevel=  $array_finalchk_abajo3_uclevel."".$rowlsgp16['uclevel'].",";										
										$array_finalchk_abajo4_ucchanc=  $array_finalchk_abajo4_ucchanc."".$rowlsgp16['ucchagc'].",";										
										$array_finalchk_abajo5_ucbbagc=  $array_finalchk_abajo5_ucbbagc."".$rowlsgp16['ucbbagc'].",";										
										
								  }	 										  
								  
								
							  
					  }
					  //FinalCheck_Measures_IMD				  
					   if("00200701B" ==$row['iduniquebranch'])
					  {
						  
						  
								  
								  
						  	$query_lista5=" select fas_sameasures.fcent, fas_mkrmeasures.*
							from fas_sameasures
							inner join fas_mkrmeasures
							on fas_mkrmeasures.iduniqueop   = fas_sameasures.iduniqueop and
							   fas_mkrmeasures.id_mkrmeasures = fas_sameasures.id_mkrmeasures
							where fas_sameasures.iduniqueop   = ".$row['iduniqueop']." order by id_mkrmeasures ";
						//	echo $query_lista5;
							
							$datalsgp = $connect->query($query_lista5)->fetchAll();
							$idindiceimd=1;
							 foreach ($datalsgp as $rowlsgp1) 
								  {
									  if ($idindiceimd==4)
									  {
											$Finalchk_imd_4[]=$rowlsgp1['pwr'];	
											$idindiceimd=0;
									  }
									   if ($idindiceimd==3)
									  {
											$Finalchk_imd_3[]=$rowlsgp1['pwr'];	
									  }
									   if ($idindiceimd==2)
									  {
										
										$Finalchk_imd_2[]=$rowlsgp1['pwr'];	
									
									  }
									   if ($idindiceimd==1)
									  {
										 $Finalchk_imdfreq[]=$rowlsgp1['fcent'];
										$Finalchk_imd_1[]=$rowlsgp1['pwr'];	
										
									  }
											$idindiceimd = $idindiceimd + 1;								
								  }	
					  }
					  ///array_finalchk_noisefig
					  if("00200701C" ==$row['iduniquebranch'])
					  {
						   
								   
						    $query_lista5=" select * from fas_noisefigure where iduniqueop = ".$row['iduniqueop']." order by idfas_noisefigure ";
						//	echo  "<br>". $query_lista5;
							$datalsgp = $connect->query($query_lista5)->fetchAll();
							 foreach ($datalsgp as $rowlsgp1) 
								  {
									 
									    
										$array_finalchk_noisefig=  $array_finalchk_noisefig."".$rowlsgp1['nf'].",";										
										  $array_finalchk_noisefigshow[] =  $rowlsgp1['nf'];
								
									
								  }
							  
					  }
				  }

									
		?>
		<h3 style="text-decoration: underline;"><?php echo "".$label_band_amostrar ." - ".$label_ULDL_amostrar; ?></h3>
		 <table style="width: 100%;font-size: 10pt;text-align: left;border-top: 2px solid black;border-right: 2px solid black;border-left: 2px solid black; border-bottom: 2px solid black;">
                
                     <thead class="thead-dark">
                    <tr>
                      <th style="font-size: 10pt;text-align: left;border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black; border-bottom: 1px solid black;">Freq - [MHz]</th>
					  <?php
					  $mi=0;
					   foreach($arrayfreq as $fec) 
							{
								echo "<th style='font-size: 10pt;text-align: center;border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black; border-bottom: 1px solid black;'>" . round($fec,3) ."</th>";
								$mi=$mi+1;
								if($mi==11)
								{
									//break;
								}
							}
					?>                     
                    </tr>
                  </thead>
                  <tbody>
				  	<tr>
                      <td style="font-size: 10pt;text-align: left;border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black; border-bottom: 1px solid black;">Gain <span style="text-align: right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [dB]</span></td>
                      <?php
					   $mi=0;
					   foreach($array_finalchk_gain as $leveldat) 
							{
								echo "<td style='font-size: 10pt;text-align: center;border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black; border-bottom: 1px solid black;'> " . round($leveldat,1) . "</td>";
								$mi=$mi+1;
								if($mi==11)
								{
									//break;
								}
							}
					?>   		  					  
                    </tr> 	
					 	<tr>
                      <td style="font-size: 10pt;text-align: left;border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black; border-bottom: 1px solid black;">Max Pwr <span style="text-align: right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [dBm]</span></td>
                      <?php
					   $mi=0;
					   foreach($array_finalchk_pwr as $leveldat) 
							{
								//echo "<td>" . $leveldat . "</td>";
								echo "<td style='font-size: 10pt;text-align: center;border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black; border-bottom: 1px solid black;'> " . $leveldat . "</td>";
								$mi=$mi+1;
								if($mi==11)
								{
									//break;
								}
							}
					?>   		  					  
                    </tr> 
						<tr>
                      <td style="font-size: 10pt;text-align: left;border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black; border-bottom: 1px solid black;">Noise Figure <span style="text-align: right;">&nbsp;&nbsp; [dB]</span></td>
                      <?php
					   $mi=0;
					   foreach( $array_finalchk_noisefigshow as $leveldat) 
							{
							//	echo "<td>" . $leveldat . "</td>";
									echo "<td style='font-size: 10pt;text-align: center;border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black; border-bottom: 1px solid black;'> " . $leveldat . "</td>";
								$mi=$mi+1;
								if($mi==11)
								{
									//break;
								}
							}
					?>   		  					  
                    </tr> 
						
                     
                  </tbody>
				    </table>
					<br>
					<table style="width: 100%;font-size: 10pt;text-align: left;border-top: 2px solid black;border-right: 2px solid black;border-left: 2px solid black; border-bottom: 2px solid black;">
                
                     <thead class="thead-dark">
                    <tr>
                      <th style="width: 30%;font-size: 10pt;text-align: left;border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black; border-bottom: 1px solid black;">Frequency Center [MHz] </th>
					  <?php
					  $mi=0;
					   foreach($Finalchk_imdfreq as $fec) 
							{
								echo "<th style='font-size: 10pt;text-align: center;border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black; border-bottom: 1px solid black;'>" . round($fec,3) . "</th>";
								$mi=$mi+1;
								if($mi==11)
								{
									//break;
								}
							}
					?>     
								
                    </tr>
                  </thead>
                  <tbody>
				  	<tr>
                      <td style="width: 20%;font-size: 10pt;text-align: left;border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black; border-bottom: 1px solid black;">IMD 1 <span style="text-align: right;">&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [dBm]</span></td>
                      <?php
					   $mi=0;
					   foreach($Finalchk_imd_1 as $leveldat) 
							{
								echo "<td style='font-size: 10pt;text-align: center;border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black; border-bottom: 1px solid black;'>" . $leveldat . "</td>";
								$mi=$mi+1;
								if($mi==11)
								{
									//break;
								}
							}
					?>   	
												
                    </tr> 	
					 	<tr>
                      <td style="width: 20%;font-size: 10pt;text-align: left;border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black; border-bottom: 1px solid black;">Fundamental Tone 1 <span style="text-align: right;">&nbsp;&nbsp; [dBm]</span></td>
                      <?php
					   $mi=0;
					   foreach($Finalchk_imd_2 as $leveldat) 
							{
								echo "<td style='font-size: 10pt;text-align: center;border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black; border-bottom: 1px solid black;'>" . $leveldat . "</td>";
								$mi=$mi+1;
								if($mi==11)
								{
									//break;
								}
							}
					?>   		  					  
                    </tr> 
						<tr>
                      <td style="width: 20%;font-size: 10pt;text-align: left;border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black; border-bottom: 1px solid black;">Fundamental Tone 2 <span style="text-align: right;">&nbsp;&nbsp; [dBm]</span></td>
                      <?php
					   $mi=0;
					   foreach( $Finalchk_imd_3 as $leveldat) 
							{
								echo "<td style='font-size: 10pt;text-align: center;border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black; border-bottom: 1px solid black;'>" . $leveldat . "</td>";
								$mi=$mi+1;
								if($mi==11)
								{
									//break;
								}
							}
					?>   		  					  
                    </tr> 
						<tr>
                      <td style="width: 20%;font-size: 10pt;text-align: left;border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black; border-bottom: 1px solid black;">IMD 2 <span style="text-align: right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; [dBm]</span></td>
                      <?php
					   $mi=0;
					   foreach( $Finalchk_imd_4 as $leveldat) 
							{
								echo "<td style='font-size: 10pt;text-align: center;border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black; border-bottom: 1px solid black;'>" . $leveldat . "</td>";
								$mi=$mi+1;
								if($mi==11)
								{
									//break;
								}
							}
					?>   		  					  
                    </tr> 
					
                     <tr>
                    
					
                  </tbody>
				    </table>
		<br><br>
		<br><br>
		<br><br>
		<br><br>
		<br><br>
		<br><br>
		<br><br>
		<br><br>
		<br><br>
		<br><br>
		<br><br>
		<br><br>
		<br><br>
		<br><br>
		<br><br>
		<br><br>
		<br><br>
		<br><br>
		<br><br>
		<br><br>
		<br><br>
		
	
		
		
		<?php
		
	}
									  
?>


					
					<hr>
				

</div>

</div>
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
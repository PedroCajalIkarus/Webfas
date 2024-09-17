<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<link rel="shortcut icon" href="fiplexcirculo-01.ico" />
<head>

	<style>
	.page { width: 100%; height: 100%; }
.page_break { page-break-before: always; }
</style>



</head>

<body>
<?php error_reporting(0); ?>



<div id="body">


<div id="contenthead" name="contenthead"> 
  
<div class="" id="contenthead2" name="contenthead2" style="font-size: 10pt">

<table style="width: 100%; font-size: 12pt;" >
<tr>

<td>
<?php if ($_REQUEST['tracking']=="nomoestramasxahora")
				{
					?>
<img  width="200" height="74" src="img/Fiplex-communications-Sin-bajada.png"/>
<?php } ?></td>
<td style="text-align: right"><strong><?php echo date("m/d/y h:m:s")

 

?></strong></td>
</tr>
</table>

<?php
// Desactivar toda notificación de error
error_reporting(0);
// Notificar todos los errores de PHP (ver el registro de cambios)
 
 include("db_conectbypdf.php"); 
//192.168.60.26/webfas/calibrationtopdf.php?idsndib=20066097FU&iduldl=0&idmb=0
// 192.168.60.26/webfas/calibrationtopdfconimg.php?idsndib=20066097FU&iduldl=0&idmb=0 
 	session_start();
	    $vparam_vnrounitsn = $_REQUEST['idsndib']; ///

	/////**************************************************** 
		/////**************************************************** 
			/////**************************************************** 
			///Detectamos CIU
			/////**************************************************** 
			/////**************************************************** 
			$ciuisbda="N";
			$ciuisenterprice="N";
			$ciuiscentrix="N";
			$ciuisremote="N";
			$ciuisdas="N";
			$ismaster="N";
			$israckmount="N";
			$sqldetect="select fnt_select_detect_bysn_isbda_isdas('".$vparam_vnrounitsn."','SO') ";
	//	 echo "test:".$sqldetect;
			$datadetect = $connect->query($sqldetect)->fetchAll();
			foreach ($datadetect as $rowdetect) 
								  {	
								//	  echo "****.....".$rowdetect[0];
									  $resulm = json_decode($rowdetect[0]);
									///  echo "****".$resulm->{'isdba'};
									if( $resulm->{'isdba'} >0 )
									{
									$ciuisbda="Y";
									}
									if( $resulm->{'isdas'} >0 )
									{
									$ciuisdas="Y";
									}
									if( $resulm->{'isenterprise'} >0 )
									{
									$ciuisenterprice="Y";
									}
									if( $resulm->{'ispcs'} >0 )
									{
									$ciuiscentrix="Y";
									}
									if( $resulm->{'isremote'} >0 )
									{
									$ciuisremote="Y";
									}

									if( $resulm->{'ismaster'} >0 )
									{
									$ismaster="Y";
									}
									if( $resulm->{'israckmount'} >0 )
									{
									$israckmount="Y";
									}


								  } 
							 

			/////**************************************************** 								
			//fin detectamos CIU
			/////**************************************************** 
			/////**************************************************** 
				
			$sqlnombremand ="SELECT  0+ row_number() OVER () as rnum, idband.description ,CASE idband.idband
			WHEN 0  THEN 0
			WHEN 3  THEN 0
			WHEN 4  THEN 1
			WHEN 8  THEN 1
			WHEN 7  THEN 1
			WHEN 1  THEN 1
			WHEN 6  THEN 1
			ELSE NULL
			END AS idbandperson, modelciu
		 
FROM orders_sn 
inner join fnt_select_allproducts_maxrev() as ppp on ppp.idproduct= orders_sn.idproduct
INNER JOIN orders_sn_specs
ON orders_sn_specs.idorders = orders_sn.idorders and
orders_sn_specs.idnroserie = orders_sn.idnroserie
inner join idband
on idband.idband = orders_sn_specs.idband
 WHERE wo_serialnumber='".$vparam_vnrounitsn."' AND typeregister = 'SO' and orders_sn_specs.typedata ='UNIT'";

// echo "<br>sqlnombremand".$sqlnombremand;

$datacabeznomband = $connect->query($sqlnombremand)->fetchAll();
$nombreband_0 ="";
$nombreband_1 ="";
$nombreband_2 ="";
$nombreband_3 ="";
$quantityband = 0;
foreach ($datacabeznomband as $rowheadersnomband) 
{
	$_name_ciu = $rowheadersnomband['modelciu'];

	$quantityband = count($datacabeznomband );
	if (count($datacabeznomband )==1)
	{
		$nombreband_0=$rowheadersnomband['description'];
		$nombreband_1=$rowheadersnomband['description'];
	}
	else
	{
		if ($rowheadersnomband['rnum']==1)
		{
		$nombreband_0=$rowheadersnomband['description'];
		}
		if ($rowheadersnomband['rnum']==2)
		{
		$nombreband_1=$rowheadersnomband['description'];
			//echo "aca1aaaaaaaaaaaaa".$nombreband_1;
		}
		if ($rowheadersnomband['rnum']==3)
		{
		$nombreband_2=$rowheadersnomband['description'];
		///	echo "aaaaaaaaaaaaa".$nombreband_1;
		}
		if ($rowheadersnomband['rnum']==4)
		{
		$nombreband_3=$rowheadersnomband['description'];
		///	echo "aaaaaaaaaaaaa".$nombreband_1;
		}

	}

}

	if ($vparam_band==9)
	{
		$vparam_band='';
		$vparam_uldld='';

	}



?>
<?php if ($_REQUEST['tracking']=="")
				{
					?>
<table style="width: 100%;" class="header">
<tr>
<td><h2 style="text-align: left; color:#0053a1;">TEST RESULTS</h2></td>
<td><h1 style="text-align: right"></h1></td>
</tr>
</table>
<?php } ?>

<table style="width: 100%;  border-top: 1px solid black; border-bottom: 1px solid black; font-size: 12pt;">
<tr>
<td style='text-align: left'>CIU: <strong><?php echo $_name_ciu;?></strong></td>
<td style='text-align: right'>SN: <strong><?php echo $vparam_vnrounitsn;?></strong></td>

</tr>
</table>

<?php

$idrun= $_REQUEST['idrunaferbur'];

///desde sale orders solo muestro los NO genericos de CIU
$queryinfo = "select * from fas_outcome_integral where reference = ".$idrun." AND idtype IN (16,7,8,9,10)";
////aca tenemos un problema..meti una union.. primero traemos los datos genericos y despues los especificos
 
 $datainfoVersiones = $connect->query($queryinfo)->fetchAll();
								$idtemp=0;
								$vejecucion = 1;
								$usucalibration="";
								$fas_version="";
								$fas_fpga_ver ="";
								$fas_uc_ver="";
								$fas_eth_ver="";
								  foreach ($datainfoVersiones as $rowversiones) 
								  {
									  if ($rowversiones['idtype']==16)
									  {
										$usucalibration = $rowversiones['v_string'];
									  }
									  if ($rowversiones['idtype']==7)
									  {
										$fas_version = $rowversiones['v_string'];
									  }
									  if ($rowversiones['idtype']==8)
									  {
										$fas_fpga_ver = $rowversiones['v_string'];
									  }
									  if ($rowversiones['idtype']==9)
									  {
										$fas_uc_ver = $rowversiones['v_string'];
									  }
									  if ($rowversiones['idtype']==10)
									  {
										$fas_eth_ver = $rowversiones['v_string'];
									  }
								  }
								 
								 							  
?>
<br>
<table style="width: 100%;  border-top: 1px solid black; border-bottom: 1px solid black; font-size: 12pt;">
<tr>
<td style='width: 30%;text-align: left'>Calibrator: <strong><?php echo $usucalibration;?></strong></td>
<td style='width: 30%;text-align: left'> </td>
<td style='width: 30%;text-align: right'>FAS Version: <strong><?php echo $fas_version;?></strong></td>

</tr>
<tr><td colspan=3><hr></td></tr>
<tr>
<td style='width: 30%;text-align: left'>FW FPGA: <strong><?php echo $fas_fpga_ver ;?></strong></td>
<td style='width: 30%;text-align: left'>FW uC: <strong><?php echo $fas_uc_ver;?></strong></td>
<?php if ( $vv_idbusiness_ciu==1)
{
	?>
	<td style='width: 30%;text-align: left'>FW Ethernet: <strong><?php echo $fas_eth_ver;?></strong></td>
	<?php
}
?>



</tr>
</table>
 



<h2 style="text-decoration: underline;">Parameters:</h2>
 
</table>
<h3 style="text-decoration: underline;">UNIT (DL - UL) List:</h3>
<table  style="width: 100%;font-size: 10pt;text-align: left;border-top: 1px solid black; border-bottom: 1px solid black;" >
<tbody>

<?php

 


$sql = $connect->prepare("select distinct  idband.description as nameband,ul_ch_fr, dl_ch_fr, dpxlowstart, dpxlowstop, dpxhihgstart, dpxhihgstop, unitdlstart, unitdlstop, unitulstart, unitulstop ,
ulgain,dlgain ,ulmaxpwr, dlmaxpwr 
from orders_sn 
inner join orders_sn_specs
on orders_sn.idorders = orders_sn_specs.idorders and
orders_sn.idrev = orders_sn_specs.idrev and 
orders_sn.idnroserie = orders_sn_specs.idnroserie
inner join idband
on idband.idband = orders_sn_specs.idband	
	where typedata = 'UNIT' and  (so_soft_external like '%SO') and  wo_serialnumber =  '".$vparam_vnrounitsn."'");
	
	 /// $sql->bindParam(':vvidsndib', $vparam_vnrounitsn);
    $sql->execute();
    $resultado3 = $sql->fetchAll();
	$rnum =1;
	foreach ($resultado3 as $row2) 
	 {
		if ($rnum==1)
		{
			$rnum = $rnum + 1;
		//	$nombreband_0=$row2['nameband'];
		}
		if ($rnum==2)
		{
		//	$nombreband_1=$row2['nameband'];
		}
		 
		 ?>
		 <tr>
		 <th style="text-align: left" >Band: <?php echo $row2['nameband']; ?></th>
		 <td style="text-align: left"> UL Start: <?php echo $row2['unitulstart']; ?> MHz</td>
		<td style="text-align: left"> UL Stop: <?php echo $row2['unitulstop']; ?> MHz</td>

		<td style="text-align: left"> UL Gain: <?php  echo floor($row2['ulgain']); ?> 	(dB)</td>
		<td style="text-align: left"> UL Max Pwr Out: <?php echo floor($row2['ulmaxpwr']); ?> 	(dBm)</td>

		<td style="text-align: left"> DL Start: <?php echo $row2['unitdlstart']; ?> MHz</td>
		<td style="text-align: left"> DL Stop: <?php echo $row2['unitdlstop']; ?> MHz</td>

		<td style="text-align: left"> DL Gain: <?php  echo floor($row2['dlgain']); ?> 	(dB)</td>
		<td style="text-align: left"> DL Max Pwr Out: <?php echo floor($row2['dlmaxpwr']); ?> 	(dBm)</td>
		
		</tr>
		 <?php
	 }

?>



</tbody>
</table>

<?php 

if ($ciuiscentrix=="N" && $israckmount=="N" && $ismaster =="N"  )
{


if ( $showdpxreport == true) 
{?>
<h3 style="text-decoration: underline;">DPX (Low - High) List:</h3>
<table  style="width: 100%;font-size: 10pt;text-align: left;border-top: 1px solid black; border-bottom: 1px solid black;" >
<tbody>
<?php
	  $sql = $connect->prepare(	"select distinct  idband.description as nameband,ul_ch_fr, dl_ch_fr, dpxlowstart, dpxlowstop, dpxhihgstart, dpxhihgstop, unitdlstart, unitdlstop, unitulstart, unitulstop	 
	from orders_sn 
	inner join orders_sn_specs
	on orders_sn.idorders = orders_sn_specs.idorders and
	orders_sn.idrev = orders_sn_specs.idrev and 
	orders_sn.idnroserie = orders_sn_specs.idnroserie
	inner join products
	on products.idproduct = orders_sn.idproduct
	inner join idband
	on idband.idband = orders_sn_specs.idband	
	where typedata = 'DPX' and (so_soft_external like '%SO' or so_soft_external like '%RM')  and  wo_serialnumber =  '".$vparam_vnrounitsn."'");

	 /// $sql->bindParam(':vvidsndib', $vparam_vnrounitsn);
    $sql->execute();
	$tempnombreand = "";
    $resultado3 = $sql->fetchAll();
	$tempnombreand = "";
	foreach ($resultado3 as $row2) 
	 {
	
		if ( $row2['nameband'] !=	$tempnombreand )
		{
			if (	$tempnombreand !="")
			{
			//	break;
			}
			   $tempnombreand = $row2['nameband'];
			  
		}
		 ?>
		 <tr>
		 <th style="text-align: left" >Band: <?php echo $row2['nameband']; ?></th>
		 	<td style="text-align: left"> UL Start: <?php echo floor($row2['dpxhihgstart']); ?> MHz</td>
		<td style="text-align: left"> UL Stop: <?php echo floor($row2['dpxhihgstop']); ?> MHz</td>
		<td style="text-align: left"> DL Start: <?php echo floor($row2['dpxlowstart']); ?> MHz</td>
		<td style="text-align: left"> DL Stop: <?php echo floor($row2['dpxlowstop']); ?> MHz</td>
	
		</tr>
		 <?php
	 }

?>
</tbody>
</table>
<?php  }
} ?>
<br><br>
<?php


?>
<br>

<table  style="width: 100%;font-size: 10pt;text-align: left;border-top: 2px solid black;border-right: 2px solid black;border-left: 2px solid black; border-bottom: 2px solid black;" >
<tbody>
 

 

<?php
$v_dnd="SO";

$vparam_vnrounitsn = $_REQUEST['idsndib']; ///
$vparam_band = $_REQUEST['idmb'];
$vaparam_uldl = $_REQUEST['iduldl'];

/* IF Para mostrar DATO
S [09:18] Agustin Corigliano
    sea una copia del afterburnin check, solo que cambiado el CIU, hay que poner el ciu personalizado, no el generico
	*/
	

$sql="select description , todomm.*
from (
		select  fas_routines_steps.parameters->>'uldl' as eluldl,   fas_routines_steps.parameters->>'idband' as elidband,
	 ARRAY_AGG (fas_step.titlestep order by fas_step.titlestep ) as lostitulos ,
	 ARRAY_AGG (fas_outcome_integral.v_boolean order by fas_step.titlestep ) as totalespass
 
	 from fnt_select_allfas_routines_process_sn_maxrev_byscript('".$vparam_vnrounitsn."',35) as maxrev_sn
	 inner join 	fas_routines_steps
	 on fas_routines_steps.idstep  = maxrev_sn.idstep
	 inner join fas_step
	 on fas_step.instance =  fas_routines_steps.instance	 
	 inner join 
	 (
			 select sn,idruninfodb, elidband, eluldl, titlestep, count(idstep), min(idorder) as  minidorder
			 from (	
				 select  sn,idruninfodb,  parameters->>'uldl' as eluldl,    parameters->>'idband' as elidband, fas_step.titlestep, maxrev_sn.idstep, maxrev_sn.idorder
				 from fnt_select_allfas_routines_process_sn_maxrev_byscript('".$vparam_vnrounitsn."',35) as maxrev_sn
				 inner join 	fas_routines_steps
				 on fas_routines_steps.idstep  = maxrev_sn.idstep
				 inner join fas_step
				 on fas_step.instance =  fas_routines_steps.instance	 
				 where sn = '".$vparam_vnrounitsn."' and 
					   idruninfodb =  ".$idrun." and 
					   parameters->>'ismeasure' = 'true' and titlestep <>'Noise Floor Measurement'
				 ) as oerr
			   group by sn,idruninfodb, elidband, eluldl, titlestep
  
	  ) as  losdatos
	 on  losdatos.sn  		 =		maxrev_sn.sn and
		 losdatos.idruninfodb =	 	maxrev_sn.idruninfodb and 
		 losdatos.eluldl		 =		 fas_routines_steps.parameters->>'uldl' 	  and
		 losdatos.elidband	 =		 fas_routines_steps.parameters->>'idband' 	   and
		 losdatos.titlestep	 =		fas_step.titlestep    and
		 losdatos.minidorder	 = 		maxrev_sn.idorder	
		 
	 inner join fas_outcome_integral
	 on  fas_outcome_integral.reference = maxrev_sn.iduniqueop and
		 fas_outcome_integral.idfasoutcomecat = 1 and
		 fas_outcome_integral.idtype =0 and 
		 fas_outcome_integral.v_boolean is not null

	 
 
	 where maxrev_sn.sn = '".$vparam_vnrounitsn."' and 
		   maxrev_sn.idruninfodb = ".$idrun." and 
		   parameters->>'ismeasure' = 'true' 
		   
	 group by  fas_routines_steps.parameters->>'uldl' ,   fas_routines_steps.parameters->>'idband'
		   
		) as todomm
	 inner join idband
	 on idband.idband = todomm.elidband::integer
 
		   
		   
	  
 

	 ";

	 
//echo "Hola a ver q tenemos".$v_dnd." -sql;".$sql;
$simbolosaborrar = array("{", "}");
		  $dataresumen = $connect->query($sql)->fetchAll();
 
	 
					 
					$vi=0;
					$imgesperar = 0;
						foreach ($dataresumen as $rowresult) 
						{
								if ($vi==0)
								{
								//	cabezadetabla
									$datoscabe = str_replace($simbolosaborrar, "", $rowresult['lostitulos']);
									echo "<tr>";
									?>
									<th style='font-size: 10pt;text-align: left;border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black; border-bottom: 1px solid black'>
									<?php
									echo "Reference</th>";
									$cabezadetabla =  explode(',',$datoscabe) ;
										for ($y=0; $y<count($cabezadetabla);  $y++) 
										{
											?>
											<th style='font-size: 10pt;text-align: left;border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black; border-bottom: 1px solid black'>
											<?php
											
											echo "<b>".str_replace('"',"",$cabezadetabla[$y])."</b></th>";
										}
										$vi =1;

										echo "</tr>";

								}	
								 
								
								$datoscabe2 = str_replace($simbolosaborrar, "", $rowresult['totalespass']);

								$datosref = str_replace($simbolosaborrar, "", $rowresult['lasrefe']);
								$datostol = str_replace($simbolosaborrar, "", $rowresult['lastolerancias']);
								$datosimdymas = str_replace($simbolosaborrar, "", $rowresult['lasrefimd']);
								 
								
									$cabezadetabla2 =  explode(',',$datoscabe2) ;

									$cabezdatosref =  explode(',',$datosref) ;
									$cabezdatostol =  explode(',',$datostol) ;
									$cabezdatosimdymas =  explode(',',$datosimdymas) ;

								//	echo 
							///		echo "a ver".print_r($cabezdatosref)."<br>";
									echo "<tr>";
								 ?>
								 <td style='font-size: 10pt;text-align: left;border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black; border-bottom: 1px solid black'>
								 <?php
									$label_ULDL_amostrar="";

									if ($rowresult['eluldl'] ==0)
									{
										$label_ULDL_amostrar =" - Uplink";
									}
									else
									{
										$label_ULDL_amostrar =" - Downlink";
									}

									echo "".$rowresult['description']." ".$label_ULDL_amostrar."</td>";

									
										for ($ym=0; $ym<count($cabezadetabla2);  $ym++) 
										{

											 
											?>
											<td style='font-size: 10pt;text-align: left;border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black; border-bottom: 1px solid black'>
											<?php
									 
											
											if ($cabezadetabla2[$ym]=="t")
											{
												?>
												<span style="color:green"><b>[Passed]</b></span>
												<?php
											}
											else
											{
												?>
												<span  style="color:red"><b>[Not Passed]</b></span>
												<?php
											}
											echo "</td>";
										}
										echo "</tr>";
							
							
						}
				 
					?>
					</tr>
						  <?php  
		?>
	



</tbody>
</table>

 
		
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/chart.js/Chart.min.js"></script>


<script type="text/javascript">

		var salesChart_finalchknoisefig = $('#salesChartlevel<?php echo $vvv_sumanombregraf; ?>').get(0).getContext('2d');
		var salesChart_finalchkmaxpowers = $('#salesChartpowers<?php echo $vvv_sumanombregraf; ?>').get(0).getContext('2d'); 
		var salesChart_finalchkgain = $('#salesCharttxripple<?php echo $vvv_sumanombregraf; ?>').get(0).getContext('2d');	  
		var salesChart_finalgraf1 = $('#graficoabajo1<?php echo $vvv_sumanombregraf; ?>').get(0).getContext('2d'); 
		var salesChart_finalgraf2 = $('#graficoabajo2<?php echo $vvv_sumanombregraf; ?>').get(0).getContext('2d'); 
		var salesChart_finalgraf3 = $('#graficoabajo3<?php echo $vvv_sumanombregraf; ?>').get(0).getContext('2d'); 
		var salesChart_finalgraf4 = $('#graficoabajo4<?php echo $vvv_sumanombregraf; ?>').get(0).getContext('2d'); 
		var salesChart_finalgraf5 = $('#graficoabajo5<?php echo $vvv_sumanombregraf; ?>').get(0).getContext('2d'); 

		var salesChart_finalgraf6 = $('#graficoabajolr<?php echo $vvv_sumanombregraf; ?>').get(0).getContext('2d'); 
 
	


  var salesChartDatatotalesnoisefig = {
    labels  : [<?php echo  $freqlabel; ?>],
    datasets: [
	 
	   {
        label               : 'Equalized',		
	     backgroundColor     : 'rgba(60,141,188,0.3)',
        borderColor         : 'rgba(60,141,188,1)',
        pointRadius          : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
     	 data          :[<?php echo  $array_finalchk_noisefig;?>]
      },
    ]
  };
  
    var salesChartDatatotalesGain = {
    labels  : [<?php echo  $freqlabel; ?>],
    datasets: [
	 
	   {
        label               : 'Equalized',		
	     backgroundColor     : 'rgba(60,141,188,0.3)',
        borderColor         : 'rgba(60,141,188,1)',
        pointRadius          : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
     	 data          :[<?php echo  $array_finalchk_gaingrafico;?>]
      },
    ]
  };
  
   var salesChartDatalpowees = {
    labels  : [<?php echo  $freqlabelpwr;?>],
    datasets: [
	
	   {
       label               : 'Equalized',		
	     backgroundColor     : 'rgba(60,141,188,0.3)',
        borderColor         : 'rgba(60,141,188,1)',
        pointRadius          : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',	
     	 data          :[<?php echo  $array_finalchk_pwrgrafico;?>]
      },
    ]
  }
;

////definicion grafico abajo1 
   var datosgraficoabajo1 = {
    labels  : [<?php echo  $array_finalchk_abajo1_pwrin;?>],
    datasets: [	
	   {
       label               : 'Equalized',		
	     backgroundColor     : 'rgba(60,141,188,0.3)',
        borderColor         : 'rgba(60,141,188,1)',
        pointRadius          : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',	
     	 data          :[<?php echo  $array_finalchk_abajo1_gainnoagc;?>]
      },
    ]
  }
;

////definicion grafico abajo2 
   var datosgraficoabajo2 = {
    labels  : [<?php echo  $array_finalchk_abajo1_pwrin;?>],
    datasets: [	
	   {
       label               : 'Equalized',		
	     backgroundColor     : 'rgba(60,141,188,0.3)',
        borderColor         : 'rgba(60,141,188,1)',
        pointRadius          : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',	
     	 data          :[<?php echo  $array_finalchk_abajo2_pwr;?>]
      },
    ]
  }
;

////definicion grafico abajo3
   var datosgraficoabajo3 = {
    labels  : [<?php echo  $array_finalchk_abajo1_pwrin;?>],
    datasets: [	
	   {
       label               : 'Equalized',		
	     backgroundColor     : 'rgba(60,141,188,0.3)',
        borderColor         : 'rgba(60,141,188,1)',
        pointRadius          : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',	
     	 data          :[<?php echo  $array_finalchk_abajo3_uclevel;?>]
      },
    ]
  }
;
////definicion grafico abajo4
   var datosgraficoabajo4 = {
    labels  : [<?php echo  $array_finalchk_abajo1_pwrin;?>],
    datasets: [	
	   {
       label               : 'Equalized',		
	     backgroundColor     : 'rgba(60,141,188,0.3)',
        borderColor         : 'rgba(60,141,188,1)',
        pointRadius          : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',	
     	 data          :[<?php echo  $array_finalchk_abajo4_ucchanc;?>]
      },
    ]
  }
;
////definicion grafico abajo5
   var datosgraficoabajo5 = {
    labels  : [<?php echo  $array_finalchk_abajo1_pwrin;?>],
    datasets: [	
	   {
       label               : 'Equalized',		
	     backgroundColor     : 'rgba(60,141,188,0.3)',
        borderColor         : 'rgba(60,141,188,1)',
        pointRadius          : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',	
     	 data          :[<?php echo  $array_finalchk_abajo5_ucbbagc;?>]
      },
    ]
  }
;

////definicion grafico abajo6

var salesChartOptionslevelread= {
    maintainAspectRatio : false,
    responsive : true,	
    legend: {
      display: false
    },
	
    scales: {
      xAxes: [{
        gridLines : {
          display : true,		 
        }
		
	
      }],
      yAxes: [{
        gridLines : {
          display : true,
		 
        },
		 ticks: {
                   
				    suggestedMin: -71,
                    suggestedMax: -60
               }
	
		
      }]
    }
  };
var datosgraficoabajo6 = {
    labels  : [<?php echo  $array_finalchk_levelread_freq;?>],
    datasets: [	
	   {
       label               : 'Equalized',		
	     backgroundColor     : 'rgba(60,141,188,0.3)',
        borderColor         : 'rgba(60,141,188,1)',
        pointRadius          : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',	
     	 data          :[<?php echo  $array_finalchk_levelread_uclevel;?>]
      },
    ]
  }
;


  
    var salesChartOptions = {
    maintainAspectRatio : false,
    responsive : false,	
    legend: {
      display: false
    },
	
    scales: {
      xAxes: [{
        gridLines : {
          display : true,		 
        }
		
	
      }],
      yAxes: [{
        gridLines : {
          display : true,
		 
        },
		 ticks: {
                   
				    suggestedMin: 80,
                    suggestedMax: 90
               }
	
		
      }]
    }
  }
  
  
  var salesChartOptionsnoise= {
    maintainAspectRatio : false,
    responsive : false,	
    legend: {
      display: false
    },
	
    scales: {
      xAxes: [{
        gridLines : {
          display : true,		 
        }
		
	
      }],
      yAxes: [{
        gridLines : {
          display : true,
		 
        },
		 ticks: {
                   
				    suggestedMin: 8,
                    suggestedMax: 15
               }
	
		
      }]
    }
  }
  
   var optionesbasicasgrafico= {
    maintainAspectRatio : false,
    responsive : false,	
    legend: {
      display: false
    },
	
    scales: {
      xAxes: [{
        gridLines : {
          display : true,		 
        }
		
	
      }],
      yAxes: [{
        gridLines : {
          display : true,
		 
        }				
      }]
    }
  }
  
  
     var salesChartOptionsmaxpwr = {
    maintainAspectRatio : false,
    responsive : false,	
    legend: {
      display: false
    },
	
    scales: {
      xAxes: [{
        gridLines : {
          display : true,		 
        }
		
	
      }],
      yAxes: [{
        gridLines : {
          display : true,
		 
        },
		 ticks: {
                   
				    suggestedMin: 20,
                    suggestedMax: 30
               },
			    plugins: {
            zoom: {
                // Container for pan options
                pan: {
                    // Boolean to enable panning
                    enabled: true,

                    // Panning directions. Remove the appropriate direction to disable 
                    // Eg. 'y' would only allow panning in the y direction
                    mode: 'xy'
                },

                // Container for zoom options
                zoom: {
                    // Boolean to enable zooming
                    enabled: true,

                    // Zooming directions. Remove the appropriate direction to disable 
                    // Eg. 'y' would only allow zooming in the y direction
                    mode: 'xy',
                }
            }
        }
	
		
      }]
    }
  }
	
	  var salesChart2 = new Chart(salesChart_finalchknoisefig, { 
      type: 'line', 	
      data: salesChartDatatotalesnoisefig, 	 
      options: salesChartOptionsnoise
    });
	
	
	  var salesChart3 = new Chart(salesChart_finalchkmaxpowers, { 
      type: 'line', 	
      data: salesChartDatalpowees, 	 
      options: salesChartOptionsmaxpwr
    });
	
	  var salesChart4 = new Chart(salesChart_finalchkgain, { 
      type: 'line', 	
      data: salesChartDatatotalesGain, 	 
      options: salesChartOptions
    });
	
	/// definicion grafico 5
	  var salesChart5 = new Chart(salesChart_finalgraf1, { 
      type: 'line', 	
      data: datosgraficoabajo1, 	
 options: optionesbasicasgrafico	  
      
    });
	/// definicion grafico 6
	  var salesChart6 = new Chart(salesChart_finalgraf2, { 
      type: 'line', 	
      data: datosgraficoabajo2, 	 
      options: optionesbasicasgrafico
    });
	/// definicion grafico 7
	  var salesChart7 = new Chart(salesChart_finalgraf3, { 
      type: 'line', 	
      data: datosgraficoabajo3, 	 
      options: optionesbasicasgrafico
    });
	/// definicion grafico 8
	  var salesChart8 = new Chart(salesChart_finalgraf4, { 
      type: 'line', 	
      data: datosgraficoabajo4, 	 
      options: optionesbasicasgrafico
    });
	/// definicion grafico 9
	  var salesChart9 = new Chart(salesChart_finalgraf5, { 
      type: 'line', 	
      data: datosgraficoabajo5, 	 
      options: optionesbasicasgrafico
    });

	/// definicion grafico 10
	var salesChart10 = new Chart(salesChart_finalgraf6, { 
      type: 'line', 	
      data: datosgraficoabajo6, 	 
      options: salesChartOptionslevelread
    });
	


 

</script>
		<div>
 


<script type="text/javascript">



	$( document ).ready(function() {
		
		var imggrafico1 = document.getElementById('salesCharttxripplemm00').toDataURL('image/png');
	/*var imggrafico2 = document.getElementById('salesChartpowers').toDataURL('image/png');
	var imggrafico3 = document.getElementById('salesChartlevel').toDataURL('image/png');
	var imggrafico4 = document.getElementById('graficoabajo1').toDataURL('image/png');
	var imggrafico5 = document.getElementById('graficoabajo2').toDataURL('image/png');
	var imggrafico6 = document.getElementById('graficoabajo3').toDataURL('image/png');
	var imggrafico7 = document.getElementById('graficoabajo4').toDataURL('image/png');
	var imggrafico8 = document.getElementById('graficoabajo5').toDataURL('image/png');*/
	
	console.log('bbb');
	console.log(imggrafico1);
				
 var canvas = document.getElementById("salesCharttxripplemm00");
   var imgdelcanvas = canvas.toDataURL("image/png");
 	  $('#testDiv').empty().append('<img src='+imgdelcanvas+' height="346px" width="232px">')


}); 
  	
</script>	
					
					
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
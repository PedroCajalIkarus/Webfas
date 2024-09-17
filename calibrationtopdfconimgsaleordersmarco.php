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
//error_reporting(0);
// Notificar todos los errores de PHP (ver el registro de cambios)
error_reporting(E_ALL);
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
			END AS idbandperson
		 
FROM orders_sn 
INNER JOIN orders_sn_specs
ON orders_sn_specs.idorders = orders_sn.idorders and
orders_sn_specs.idnroserie = orders_sn.idnroserie
inner join idband
on idband.idband = orders_sn_specs.idband
 WHERE wo_serialnumber='".$vparam_vnrounitsn."' AND typeregister = 'SO' and orders_sn_specs.typedata ='UNIT'";

 //echo "<br>sqlnombremand".$sqlnombremand;

$datacabeznomband = $connect->query($sqlnombremand)->fetchAll();
$nombreband_0 ="";
$nombreband_1 ="";
$nombreband_2 ="";
$nombreband_3 ="";
$quantityband = 0;
foreach ($datacabeznomband as $rowheadersnomband) 
{
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

	echo "aaaaaaaaaaaaaaaaaaa";
		
	  $sql = $connect->prepare("select distinct powersupply, products.idbusiness,  products.modelciu, orders_sn.* , showdpxreport, fas_tree_product.idfastree , COALESCE(orders_sn_specs.ulgain,0) as ulgainnew , COALESCE(orders_sn_specs.dlgain,0) as dlgainnew,
	  COALESCE(orders_sn_specs.ulmaxpwr,0) as ulmaxpwrnew , COALESCE(orders_sn_specs.dlmaxpwr,0) as dlmaxpwrnew
from orders_sn 
left join orders_sn_specs
on orders_sn.idorders = orders_sn_specs.idorders and
orders_sn.idrev = orders_sn_specs.idrev and 
orders_sn.idnroserie = orders_sn_specs.idnroserie
inner join fnt_select_allproducts_maxrev() as products
on products.idproduct = orders_sn.idproduct
inner join fas_tree_product 
on fas_tree_product.idproduct = orders_sn.idproduct
where (so_soft_external like '%SO' or so_soft_external like '%RM') and wo_serialnumber =  '".$vparam_vnrounitsn."'");
	 /// $sql->bindParam(':vvidsndib', $vparam_vnrounitsn);
    $sql->execute();
    $resultado3 = $sql->fetchAll();
	foreach ($resultado3 as $row2) 
	 {
		 $v_powersupply = $row2['powersupply'];
		
		 	if ($row2['ulgainnew']>0)
			 {
				$v_ul_gain = $row2['ulgainnew'];
			 }
			 else
			 {
				$v_ul_gain = $row2['ul_gain']; 
			 }

			 if ($row2['ulmaxpwrnew'] <>"")
			 {
				$v_ul_gain_pwr = $row2['ulmaxpwrnew'];
			 }
			 else
			 {
				$v_ul_gain_pwr = $row2['ul_max_pwr'];
			 }
			 if ($row2['dlgainnew']>0)
			 {
				$v_dl_gain = $row2['dlgainnew'];
			 }
			 else
			 {
				$v_dl_gain = $row2['dl_gain'];
			 }
			 if ($row2['dlmaxpwrnew']>0)
			 {
			    $v_dl_gain_pwr = $row2['dlmaxpwrnew'];
			 }
			 else
			 {
				$v_dl_gain_pwr = $row2['dl_max_pwr'];
			 }


			 
		
	
		
			 $vv_idbusiness_ciu = $row2['idbusiness'];

		 $_name_ciu = $row2['modelciu'];
		 $showdpxreport = $row2['showdpxreport'];
		  $idfastree_byproduct = $row2['idfastree'];
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
$queryinfo = "select fas_finalcheckref_result.* , runinfodb.userruninfo from fas_finalcheckref_result inner join runinfodb 	on runinfodb.idruninfodb = fas_finalcheckref_result.idruninfo  where fas_finalcheckref_result.idruninfo in(SELECT  MAX(idrununfo) as idruninfo from fas_tree_measure where fas_tree_measure.iduniquebranch like '002%' and unitsn = '".$vparam_vnrounitsn."' )";

//query mejorado
//query mejorado
$queryinfo = "
select 2 as ordrnnn, fas_finalcheckref_result.* , runinfodb.userruninfo from fas_finalcheckref_result inner join runinfodb 	on runinfodb.idruninfodb = fas_finalcheckref_result.idruninfo  where fas_finalcheckref_result.idruninfo in(SELECT  MAX(idrununfo) as idruninfo from fas_tree_measure where fas_tree_measure.iduniquebranch like '002%' and unitsn = '".$vparam_vnrounitsn."' )
union
select 1, fas_finalcheckref_result.* , runinfodb.userruninfo from fas_finalcheckref_result inner join runinfodb 	on runinfodb.idruninfodb = fas_finalcheckref_result.idruninfo  where modelciu not in(select distinct  modelciu from products where  idproduct in (select distinct idproduct from products_attributes where v_boolean= true and idattribute = 0)) and  fas_finalcheckref_result.idruninfo in( select idrununfo from fas_tree_measure where fas_tree_measure.iduniquebranch like '002%' and unitsn = '".$vparam_vnrounitsn."'
and datetime in(
	SELECT  MAX(datetime) as idruninfo from fas_tree_measure
where fas_tree_measure.iduniquebranch like '002%' and unitsn = '".$vparam_vnrounitsn."') ) order by ordrnnn desc
";

///desde sale orders solo muestro los NO genericos de CIU
$queryinfo = "
select 2 as ordrnnn, fas_finalcheckref_result.* , runinfodb.userruninfo from fas_finalcheck_references_result as fas_finalcheckref_result inner join runinfodb 	on runinfodb.idruninfodb = fas_finalcheckref_result.idruninfo  where fas_finalcheckref_result.idruninfo in(SELECT  MAX(idrununfo) as idruninfo from fas_tree_measure where fas_tree_measure.iduniquebranch like '002%' and unitsn = '".$vparam_vnrounitsn."' )
union
select 3, fas_finalcheckref_result.* , runinfodb.userruninfo from fas_finalcheck_references_result as fas_finalcheckref_result inner join runinfodb 	on runinfodb.idruninfodb = fas_finalcheckref_result.idruninfo  where modelciu not in(select distinct  modelciu from products where  idproduct in (select distinct idproduct from products_attributes where v_boolean= true and idattribute = 0)) and  fas_finalcheckref_result.idruninfo in( select idrununfo from fas_tree_measure where fas_tree_measure.iduniquebranch like '002%' and unitsn = '".$vparam_vnrounitsn."'
and datetime in(
	SELECT  MAX(datetime) as idruninfo from fas_tree_measure
where fas_tree_measure.iduniquebranch like '002%' and unitsn = '".$vparam_vnrounitsn."') )
union 
select 4, fas_finalcheck_references_result.* , runinfodb.userruninfo
from fas_finalcheck_references_result  inner join runinfodb 	on runinfodb.idruninfodb = fas_finalcheck_references_result.idruninfo  where modelciu not in(select distinct  modelciu from products where  idproduct in (select distinct idproduct from products_attributes where v_boolean= true and idattribute = 0)) and  fas_finalcheck_references_result.idruninfo in( select idrununfo from fas_tree_measure where fas_tree_measure.iduniquebranch like '002%' and unitsn = '".$vparam_vnrounitsn."'
and datetime in(
	SELECT  MAX(datetime) as idruninfo from fas_tree_measure
where  unitsn = '".$vparam_vnrounitsn."') )

union
select distinct 5, fas_finalcheckref_result.* , runinfodb.userruninfo from fas_finalcheck_references_result as fas_finalcheckref_result 
									  inner join runinfodb on runinfodb.idruninfodb = fas_finalcheckref_result.idruninfo 
									  where 
									  modelciu not in(select distinct modelciu from products where idproduct in (select distinct idproduct from products_attributes where v_boolean= true and idattribute = 0)) and 
									  fas_finalcheckref_result.idruninfo in( 
										  
																	  select idruninfodb from runinfodb where dateserver in ( 
SELECT   max(runinfodb.dateserver) from fas_tree_measure
inner join fas_finalcheck_references_result as fas_finalcheckref_result on  
								 fas_finalcheckref_result.unitsn  =  fas_tree_measure.unitsn 	
inner join runinfodb on runinfodb.idruninfodb = fas_finalcheckref_result.idruninfo 	  
where   fas_finalcheckref_result.unitsn = '".$vparam_vnrounitsn."' and
		 modelciu  in(select distinct modelciu from products where idproduct not  in (select distinct idproduct from products_attributes where v_boolean= true and idattribute = 0))  
)
		  
									  )
order by ordrnnn desc
";
////aca tenemos un problema..meti una union.. primero traemos los datos genericos y despues los especificos
//echo "<br>".$queryinfo;/
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
<td style='width: 30%;text-align: left'>Calibrator: <strong><?php echo $rowversiones['userruninfo'];?></strong></td>
<td style='width: 30%;text-align: left'> </td>
<td style='width: 30%;text-align: right'>FAS Version: <strong><?php echo $rowversiones['fasversion'];?></strong></td>

</tr>
<tr><td colspan=3><hr></td></tr>
<tr>
<td style='width: 30%;text-align: left'>FW FPGA: <strong><?php echo $rowversiones['fpgafirm'];?></strong></td>
<td style='width: 30%;text-align: left'>FW uC: <strong><?php echo $rowversiones['ucfirm'];?></strong></td>
<?php if ( $vv_idbusiness_ciu==1)
{
	?>
	<td style='width: 30%;text-align: left'>FW Ethernet: <strong><?php echo $rowversiones['ethernetfirm'];?></strong></td>
	<?php
}
?>



</tr>
</table>

								  <?php
									break;
								  } ?>



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
<th style="text-align: left"> <?php if ( $ismaster=="N") { ?>DL Max Pwr Out: <?php } ?></th>
<td style="text-align: left"><?php if ( $ismaster=="N") { ?> <?php echo $v_dl_gain_pwr; ?> (dBm) <?php } ?> </td>
<th style="text-align: left"><?php if ( $ciuisremote=="N") { ?> UL Max Pwr Out: <?php } ?></th>
<td style="text-align: left"><?php if ( $ciuisremote=="N") { ?>  <?php echo $v_ul_gain_pwr; ?> (dBm) <?php } ?> </td>
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

/*
	  $sql = $connect->prepare("select distinct  idband.description as nameband,ul_ch_fr, dl_ch_fr, dpxlowstart, dpxlowstop, dpxhihgstart, dpxhihgstop, unitdlstart, unitdlstop, unitulstart, unitulstop  
from orders_sn 
inner join orders_sn_specs
on orders_sn.idorders = orders_sn_specs.idorders and
orders_sn.idrev = orders_sn_specs.idrev and 
orders_sn.idnroserie = orders_sn_specs.idnroserie
inner join products
on products.idproduct = orders_sn.idproduct
inner join objectband
on objectband.idproduct = orders_sn.idproduct and objectband.idband = orders_sn_specs.idband 
and objectband.idrev in (select max(idrev) from objectband where idproduct in (select idproduct from orders_sn where  so_soft_external like '%SO' and wo_serialnumber = '".$vparam_vnrounitsn."' ))
inner join idband
on idband.idband = objectband.idband	
	where typedata = 'UNIT' and so_soft_external like '%SO'  and  wo_serialnumber =  '".$vparam_vnrounitsn."'");
	*/
//// sacamos el cruce por idband
$sql = $connect->prepare("select distinct  idband.description as nameband,ul_ch_fr, dl_ch_fr, dpxlowstart, dpxlowstop, dpxhihgstart, dpxhihgstop, unitdlstart, unitdlstop, unitulstart, unitulstop  
from orders_sn 
inner join orders_sn_specs
on orders_sn.idorders = orders_sn_specs.idorders and
orders_sn.idrev = orders_sn_specs.idrev and 
orders_sn.idnroserie = orders_sn_specs.idnroserie
inner join idband
on idband.idband = orders_sn_specs.idband	
	where typedata = 'UNIT' and so_soft_external like '%SO'  and  wo_serialnumber =  '".$vparam_vnrounitsn."'");

	echo "<br><br>select distinct  idband.description as nameband,ul_ch_fr, dl_ch_fr, dpxlowstart, dpxlowstop, dpxhihgstart, dpxhihgstop, unitdlstart, unitdlstop, unitulstart, unitulstop  
	from orders_sn 
	inner join orders_sn_specs
	on orders_sn.idorders = orders_sn_specs.idorders and
	orders_sn.idrev = orders_sn_specs.idrev and 
	orders_sn.idnroserie = orders_sn_specs.idnroserie
	inner join idband
	on idband.idband = orders_sn_specs.idband	
		where typedata = 'UNIT' and so_soft_external like '%SO'  and  wo_serialnumber =  '".$vparam_vnrounitsn."'";
	
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
		<td style="text-align: left"> DL Start: <?php echo $row2['unitdlstart']; ?> MHz</td>
		<td style="text-align: left"> DL Stop: <?php echo $row2['unitdlstop']; ?> MHz</td>
		
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
	where typedata = 'DPX' and so_soft_external   like '%SO'  and  wo_serialnumber =  '".$vparam_vnrounitsn."'");

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
<?php  }
} ?>
<br><br>
<table style="width: 100%; font-size: 10pt; border-top: 1px solid black; border-bottom: 1px solid black; ">
<tr>
<td style='width: 33%;text-align: left'>Gain Tolerance: ± <strong><?php echo $vv_info_gaintolerance;?> (dB)</strong></td>
<td style='width: 33%;text-align: left'>Max Pwr Tolerance: ± <strong><?php echo $vv_info_maxpwrtolerance;?> (dBm)</strong></td>
<td style='width: 33%;text-align: left'>Noise Figure reference: <=<strong><?php echo $vv_info_nfreference;?> (dB)</strong></td>
</tr>
<tr>
<td style='width: 33%;text-align: left'>IMD Reference: <=<strong><?php echo $vv_info_imdlimit;?> (dBm)</strong></td>
<td style='width: 33%;text-align: left'>Spurious reference: <= <strong><?php echo $vv_info_spuriousreference;?> (dBm)</strong></td>

</tr>
</table>
<br><br>
<table  style="width: 100%;font-size: 10pt;text-align: left;border-top: 2px solid black;border-right: 2px solid black;border-left: 2px solid black; border-bottom: 2px solid black;" >
<tbody>
<tr >
<th style="font-size: 10pt;text-align: left;border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black; border-bottom: 1px solid black;">Reference</th>
 

<?php
$v_dnd="SO";

$vparam_vnrounitsn = $_REQUEST['idsndib']; ///
$vparam_band = $_REQUEST['idmb'];
$vaparam_uldl = $_REQUEST['iduldl'];

/* IF Para mostrar DATO
S [09:18] Agustin Corigliano
    sea una copia del afterburnin check, solo que cambiado el CIU, hay que poner el ciu personalizado, no el generico
	*/
	


	 
$Vjd=0;
$vtemp_idruninfo=0;
	if(  $ciuisdas =="Y" && 	$ciuiscentrix=="Y")
	{
		if ($v_dnd =="WO")
		{

			$sql="
			select distinct 0 as uldl, fas_tree_measure.band , idrununfo as idruninfo
			from fas_tree_measure
			inner join fas_tree
			on fas_tree.iduniquebranch = fas_tree_measure.iduniquebranch  and fas_tree.idfastree =  1
			inner join (
			SELECT DISTINCT uldl, band , MAX(datetime) as masfechaidruninfo  
			from fas_tree_measure 
			inner join fas_tree
			on fas_tree.iduniquebranch = fas_tree_measure.iduniquebranch  and fas_tree.idfastree =  1
			inner join  fas_calibration_result
			on 
			fas_calibration_result.unitsn 	= fas_tree_measure.unitsn and
			fas_calibration_result.dibsn	= fas_tree_measure.dibsn and 
			fas_calibration_result.idruninfo =  fas_tree_measure.idrununfo
				where fas_tree_measure.iduniquebranch like '002%' and fas_calibration_result.modelciu  in(select distinct  modelciu from products where  idproduct in (select distinct idproduct from products_attributes where v_boolean= true and idattribute = 0)) 
				and fas_tree_measure.unitsn = '".$vparam_vnrounitsn."' GROUP BY fas_tree_measure.uldl,fas_tree_measure.band   )
			as losmasejecutados
			on fas_tree_measure.uldl = losmasejecutados.uldl and
			fas_tree_measure.band =  losmasejecutados.band and 
			fas_tree_measure.datetime = losmasejecutados.masfechaidruninfo
			where fas_tree_measure.unitsn = '".$vparam_vnrounitsn."' 
			and fas_tree_measure.band in   ( SELECT CASE idband.idband
								WHEN 0  THEN 0
								WHEN 3  THEN 0
								WHEN 4  THEN 1
								WHEN 8  THEN 1
								WHEN 7  THEN 1
								WHEN 1  THEN 1
								WHEN 6  THEN 1
								ELSE NULL
								END AS idbandperson
							
					FROM orders_sn 
					INNER JOIN orders_sn_specs
					ON orders_sn_specs.idorders = orders_sn.idorders and
					orders_sn_specs.idnroserie = orders_sn.idnroserie
					inner join idband
					on idband.idband = orders_sn_specs.idband
					WHERE wo_serialnumber='".$vparam_vnrounitsn."'  AND typeregister = 'WO' and orders_sn_specs.typedata ='UNIT')
					 order by fas_tree_measure.band";		

		}
		else
		{
			$sql="
		select distinct 0 as uldl, fas_tree_measure.band , idrununfo as idruninfo
		from fas_tree_measure
		inner join fas_tree
		on fas_tree.iduniquebranch = fas_tree_measure.iduniquebranch  and fas_tree.idfastree =  1
		inner join (
		SELECT DISTINCT uldl, band , MAX(datetime) as masfechaidruninfo  
		from fas_tree_measure 
		inner join fas_tree
		on fas_tree.iduniquebranch = fas_tree_measure.iduniquebranch  and fas_tree.idfastree =  1
		inner join  fas_calibration_result
		on 
		fas_calibration_result.unitsn 	= fas_tree_measure.unitsn and
	 
		fas_calibration_result.idruninfo =  fas_tree_measure.idrununfo
			where fas_tree_measure.iduniquebranch like '002%' 
			and fas_calibration_result.modelciu  in(select distinct  modelciu from products where  idproduct not in (select distinct idproduct from products_attributes where v_boolean= true and idattribute = 0)) 
			and fas_tree_measure.unitsn = '".$vparam_vnrounitsn."' GROUP BY fas_tree_measure.uldl,fas_tree_measure.band   )
		as losmasejecutados
		on fas_tree_measure.uldl = losmasejecutados.uldl and
		fas_tree_measure.band =  losmasejecutados.band and 
		fas_tree_measure.datetime = losmasejecutados.masfechaidruninfo
		where fas_tree_measure.unitsn = '".$vparam_vnrounitsn."' and fas_tree_measure.band in   ( SELECT CASE idband.idband
		WHEN 0  THEN 0
		WHEN 3  THEN 0
		WHEN 4  THEN 1
		WHEN 8  THEN 1
		WHEN 7  THEN 1
		WHEN 1  THEN 1
		WHEN 6  THEN 1
		ELSE NULL
		END AS idbandperson
	
FROM orders_sn 
INNER JOIN orders_sn_specs
ON orders_sn_specs.idorders = orders_sn.idorders and
orders_sn_specs.idnroserie = orders_sn.idnroserie
inner join idband
on idband.idband = orders_sn_specs.idband
WHERE wo_serialnumber='".$vparam_vnrounitsn."'  AND typeregister = 'SO' and orders_sn_specs.typedata ='UNIT' union select 3 union select 2  )
 order by fas_tree_measure.band 	";	
 
		}
	}
	else
	{
		if ($v_dnd =="WO")
			{

				$sql="
				select fas_tree_measure.uldl, fas_tree_measure.band , idrununfo as idruninfo
				from fas_tree_measure
				inner join fas_tree
				on fas_tree.iduniquebranch = fas_tree_measure.iduniquebranch  and fas_tree.idfastree =  1
				inner join (
				SELECT DISTINCT uldl, band , MAX(datetime) as masfechaidruninfo  
				from fas_tree_measure 
				inner join fas_tree
				on fas_tree.iduniquebranch = fas_tree_measure.iduniquebranch  and fas_tree.idfastree =  1
				inner join  fas_calibration_result
				on 
				fas_calibration_result.unitsn 	= fas_tree_measure.unitsn and
				fas_calibration_result.dibsn	= fas_tree_measure.dibsn and 
				fas_calibration_result.idruninfo =  fas_tree_measure.idrununfo
					where fas_tree_measure.iduniquebranch like '002%' and fas_calibration_result.modelciu  in(select distinct  modelciu from products where  idproduct in (select distinct idproduct from products_attributes where v_boolean= true and idattribute = 0)) 
					and fas_tree_measure.unitsn = '".$vparam_vnrounitsn."' GROUP BY fas_tree_measure.uldl,fas_tree_measure.band   )
				as losmasejecutados
				on fas_tree_measure.uldl = losmasejecutados.uldl and
				fas_tree_measure.band =  losmasejecutados.band and 
				fas_tree_measure.datetime = losmasejecutados.masfechaidruninfo
				where fas_tree_measure.unitsn = '".$vparam_vnrounitsn."' 
				and fas_tree_measure.band in   ( SELECT CASE idband.idband
								WHEN 0  THEN 0
								WHEN 3  THEN 0
								WHEN 4  THEN 1
								WHEN 8  THEN 1
								WHEN 7  THEN 1
								WHEN 1  THEN 1
								WHEN 6  THEN 1
								ELSE NULL
								END AS idbandperson
							
					FROM orders_sn 
					INNER JOIN orders_sn_specs
					ON orders_sn_specs.idorders = orders_sn.idorders and
					orders_sn_specs.idnroserie = orders_sn.idnroserie
					inner join idband
					on idband.idband = orders_sn_specs.idband
					WHERE wo_serialnumber='".$vparam_vnrounitsn."'  AND typeregister = 'WO' and orders_sn_specs.typedata ='UNIT' )
					 order by fas_tree_measure.band, fas_tree_measure.uldl	";		

			}
			else
			{
				$sql="
			select fas_tree_measure.uldl, fas_tree_measure.band , idrununfo as idruninfo
			from fas_tree_measure
			inner join fas_tree
			on fas_tree.iduniquebranch = fas_tree_measure.iduniquebranch  and fas_tree.idfastree =  1
			inner join (
			SELECT DISTINCT uldl, band , MAX(datetime) as masfechaidruninfo  
			from fas_tree_measure 
			inner join fas_tree
			on fas_tree.iduniquebranch = fas_tree_measure.iduniquebranch  and fas_tree.idfastree =  1
			inner join  fas_calibration_result
			on 
			fas_calibration_result.unitsn 	= fas_tree_measure.unitsn and
			 
			fas_calibration_result.idruninfo =  fas_tree_measure.idrununfo
				where fas_tree_measure.iduniquebranch like '002%' 
		
				and fas_tree_measure.unitsn = '".$vparam_vnrounitsn."' GROUP BY fas_tree_measure.uldl,fas_tree_measure.band   )
			as losmasejecutados
			on fas_tree_measure.uldl = losmasejecutados.uldl and
			fas_tree_measure.band =  losmasejecutados.band and 
			fas_tree_measure.datetime = losmasejecutados.masfechaidruninfo
			where fas_tree_measure.unitsn = '".$vparam_vnrounitsn."' 
			and fas_tree_measure.band in   ( SELECT CASE idband.idband
								WHEN 0  THEN 0
								WHEN 3  THEN 0
								WHEN 4  THEN 1
								WHEN 8  THEN 1
								WHEN 7  THEN 1
								WHEN 1  THEN 1
								WHEN 6  THEN 1
								ELSE NULL
								END AS idbandperson
							
					FROM orders_sn 
					INNER JOIN orders_sn_specs
					ON orders_sn_specs.idorders = orders_sn.idorders and
					orders_sn_specs.idnroserie = orders_sn.idnroserie
					inner join idband
					on idband.idband = orders_sn_specs.idband
					WHERE wo_serialnumber='".$vparam_vnrounitsn."'  AND typeregister = 'SO' and orders_sn_specs.typedata ='UNIT' union select 3 union select 2 )
			order by fas_tree_measure.band, fas_tree_measure.uldl 	";	
		 	
			}
	}
	echo "Hola a ver q tenemos".$v_dnd." -sql;".$sql;
////aca tenemos un problema..						
					   $datacabez = $connect->query($sql)->fetchAll();

					   $controlcortedebandas=0;
				$mostrarlostitulodetabla='N';
						$idtemp=0;
						$vejecucion = 1;
						  foreach ($datacabez as $rowheaders) 
						  {
							  
							 
							  $vparam_vnrounitsn = $_REQUEST['idsndib']; ///// "20000000fu";	
						
							

							  if ($vparam_band_temp9=="")
							{

								$vparam_band_temp9 =$rowheaders['band'];
								$vaparam_uldl_temp9 =  $rowheaders['uldl'];
							}


								if ( $vtemp_idruninfo <= $rowheaders['idruninfo'])
								{
									 $vtemp_idruninfo=$rowheaders['idruninfo'];
									 $vparam_idruninfo = $rowheaders['idruninfo'];
								}
								else
								{
									$vparam_idruninfo = 0;
								}
							
								$v_uldl = $rowheaders['uldl'];
								$v_ban  = $rowheaders['band'];
							  
						//// $typeproduct_ciu == "PSC REMOTE"
								//// $typeproduct_ciu == "PSC REMOTE"
								if(  $ciuisdas =="Y" &&  $ciuiscentrix=="Y" && $v_dnd =="SO")
								{
								//	echo "**********************SI";
									$query_lista="SELECT fas_tree_measure.totalpass::int as totalpassconvert,  fas_tree_measure.iduniqueop,  fas_step.description as namebranch,  fas_tree_measure.iduniquebranch, fas_tree_measure.unitsn, fas_tree_measure.dibsn, fas_tree_measure.uldl, fas_tree_measure.band
									,fas_tree_measure.idrununfo
									from fas_tree_measure

									inner join 
									( select iduniquebranch, unitsn, dibsn, uldl, band, idrununfo, max(idrev) as maxidrev from fas_tree_measure
									where fas_tree_measure.iduniquebranch in('002007013','00200701B','00200701A','00200701C','00200701B02F0','002007030') and 
									fas_tree_measure.iduniquebranch like '002%'   and band = ".$rowheaders['band']." and unitsn = '".$vparam_vnrounitsn."' and  idrununfo =".$vparam_idruninfo. "
									group by iduniquebranch, unitsn, dibsn, uldl, band, idrununfo
									) as maxretry on 
									maxretry.iduniquebranch	=	fas_tree_measure.iduniquebranch and
									maxretry.unitsn			=	fas_tree_measure.unitsn and
									maxretry.uldl			=	fas_tree_measure.uldl and 
								 
									maxretry.band 			=	fas_tree_measure.band and 
									maxretry.idrununfo 		= 	fas_tree_measure.idrununfo and 
									maxretry.maxidrev		=   fas_tree_measure.idrev

									inner join fas_tree
									on fas_tree.iduniquebranch = fas_tree_measure.iduniquebranch  and fas_tree.idfastree =  1
									inner join fas_step
									on fas_step.idfasstep = fas_tree.idfastrepson
									where   fas_tree_measure.iduniquebranch  in('002007013','00200701B','00200701A','00200701C','00200701B02F0','002007030') and fas_tree_measure.iduniquebranch like '002%' and fas_tree_measure.band = ".$rowheaders['band']." and  fas_tree_measure.unitsn = '".$vparam_vnrounitsn."' and  fas_tree_measure.idrununfo =".$vparam_idruninfo. " order by iduniqueop";
															
								}
								else
								{
									$query_lista="SELECT fas_tree_measure.totalpass::int as totalpassconvert,  fas_tree_measure.iduniqueop,  fas_step.description as namebranch,  fas_tree_measure.iduniquebranch, fas_tree_measure.unitsn, fas_tree_measure.dibsn, fas_tree_measure.uldl, fas_tree_measure.band
									,fas_tree_measure.idrununfo
									from fas_tree_measure

									inner join 
									( select iduniquebranch, unitsn, dibsn, uldl, band, idrununfo, max(idrev) as maxidrev from fas_tree_measure
									where fas_tree_measure.iduniquebranch in('002007013','00200701B','00200701A','00200701C','00200701B02F0','002007030') and 
									fas_tree_measure.iduniquebranch like '002%' and uldl = ".$rowheaders['uldl']." and band = ".$rowheaders['band']." and unitsn = '".$vparam_vnrounitsn."' and  idrununfo =".$vparam_idruninfo. "
									group by iduniquebranch, unitsn, dibsn, uldl, band, idrununfo
									) as maxretry on 
									maxretry.iduniquebranch	=	fas_tree_measure.iduniquebranch and
								 
									maxretry.uldl			=	fas_tree_measure.uldl and 
								 
									maxretry.band 			=	fas_tree_measure.band and 
									maxretry.idrununfo 		= 	fas_tree_measure.idrununfo and 
									maxretry.maxidrev		=   fas_tree_measure.idrev

									inner join fas_tree
									on fas_tree.iduniquebranch = fas_tree_measure.iduniquebranch  and fas_tree.idfastree =  1
									inner join fas_step
									on fas_step.idfasstep = fas_tree.idfastrepson
									where   fas_tree_measure.iduniquebranch  in('002007013','00200701B','00200701A','00200701C','00200701B02F0','002007030') and fas_tree_measure.iduniquebranch like '002%' and fas_tree_measure.uldl = ".$rowheaders['uldl'] ." and fas_tree_measure.band = ".$rowheaders['band']." and  fas_tree_measure.unitsn = '".$vparam_vnrounitsn."' and  fas_tree_measure.idrununfo =".$vparam_idruninfo. " order by iduniqueop";
								}
 
echo "<br><br>2do::".$query_lista;
		
		  $dataresumen = $connect->query($query_lista)->fetchAll();
		  $tienedatosparalatabla = count($dataresumen);
		 if ($tienedatosparalatabla>0)
		 {
			if ($mostrarlostitulodetabla=='N')
			{
				foreach ($dataresumen as $rowresult2) 
				{
					$mostrarlostitulodetabla='S';
					$nombrecabezaamostrar = explode("_", $rowresult2['namebranch'] );
				///	echo "a verrr cuantos son:".count($nombrecabezaamostrar);
					$posiamostrar = count($nombrecabezaamostrar )-1;
					echo '<th style="font-size: 10pt;text-align: center;border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black; border-bottom: 1px solid black;">Status '.$nombrecabezaamostrar[$posiamostrar].'</th>';
				}
				echo "</tr>";
			} 
			
			/////////////////////control rapido para no duplicar bandas
			//if ($controlcortedebandas <= $quantityband)
		//	{
			//	$controlcortedebandas=$controlcortedebandas+1;
			//echo "a ver el cotrol".$controlcortedebandas."--".$quantityband;
		  ?>

					<tr>
					<td style='font-size: 10pt;text-align: left;border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black; border-bottom: 1px solid black'><?php 
						if ($v_uldl ==0)
						{
							$label_ULDL_amostrar ="Uplink";
						}
						else
						{
							$label_ULDL_amostrar ="Downlink";
						}
					//echo "cant band:".$quantityband."aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa".$v_ban;
						if ($v_ban  ==0)
						{
							$label_band_amostrar = $nombreband_0; //"700 FirstNet";
						}
						if ($v_ban  ==1)
						{
							$label_band_amostrar = $nombreband_1; //"800";
						}
						if ($v_ban  ==2)
						{
							$label_band_amostrar = $nombreband_2; //"800";
						}
						if ($v_ban  ==3)
						{
							$label_band_amostrar = $nombreband_3; //"800";
						}
						if(  $ciuisdas =="Y" && 	$ciuiscentrix=="Y")
						{
							echo "".$label_band_amostrar; ?> <a href="finalchkallband.php?dnd=<?php echo $v_dnd;  ?>&idsndib=<?php echo $vparam_vnrounitsn; ?>&idmb=<?php echo $v_ban ; ?>&iduldl=<?php echo $v_uldl; ?>&idruninfo=<?php echo $vparam_idruninfo; ?>&idrunaferbur=<?php echo $_REQUEST['idrunaferbur']; ?>#"> <i class="fas fa-eye"></i> </a></td>
							<?php
						}
						else
						{
							echo "".$label_band_amostrar ." - ".$label_ULDL_amostrar; ?> <a href="finalchkallband.php?dnd=<?php echo $v_dnd;  ?>&idsndib=<?php echo $vparam_vnrounitsn; ?>&idmb=<?php echo $v_ban ; ?>&iduldl=<?php echo $v_uldl; ?>&idruninfo=<?php echo $vparam_idruninfo; ?>&idrunaferbur=<?php echo $_REQUEST['idrunaferbur']; ?>#"> <i class="fas fa-eye"></i> </a></td>
						<?php
						}
					
					 
					$vi=0;
					$imgesperar = 0;
						foreach ($dataresumen as $rowresult) 
						{
							$vi= $vi + 1;
							if ($rowresult['totalpassconvert'] =="0")
							{
									echo "<td style='font-size: 10pt;text-align: center;border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black; border-bottom: 1px solid black;color:red'><span class='badge bg-danger'>Not Passed </span><b> </b> </td>";
							}
							else
							{	
								if ($rowresult['totalpassconvert'] =="1")
								{
										echo "<td style='font-size: 10pt;text-align: center;border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black; border-bottom: 1px solid black;color:green'><b> <span class='badge bg-success'>Passed</span> </b></td>";
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
							
							<td class="table-dark text-left"> - </td>
							<td class="table-dark text-left"> - </td>
							<td class="table-dark text-left"> - </td>
							<td class="table-dark text-left"> - </td>
						
							<?php
						}

				//	}
					// fin duplicado de bandas control rapido
					?>
					</tr>
						  <?php  }
		}?>
	



</tbody>
</table>

				 <!-- fin cuadro resumen --->
 

</div>

<?php


//////////////////////////// OJOOO
//echo "aaaaaaaaaaaaaaaaa:".substr($_name_ciu,0,4);
if (substr($_name_ciu,0,4)=="DH14" || ($ciuiscentrix=="Y"  && $ciuisremote=="Y") )
{
///	exit();
//echo "DEBERIA CORTAR ACA";/
}
///////////////////////////////////////


  foreach ($datacabez as $rowheaders) 
	{
			$vparam_vnrounitsn = $_REQUEST['idsndib']; ///// "20000000fu";	
			$vparam_band = $rowheaders['band'];
			$vaparam_uldl = $rowheaders['uldl'];
			 $vparam_idruninfo = $rowheaders['idruninfo'];
		
			$vvv_sumanombregraf="mm".$vaparam_uldl.$vparam_band;
			
			if ($vaparam_uldl ==0)
			{
				 $label_ULDL_amostrar ="Uplink";
			}
			else
			{
				$label_ULDL_amostrar ="Downlink";
			}
		
		
			if ($vparam_band  ==0)
			{
				 $label_band_amostrar = $nombreband_0; //"700 FirstNet";
			}
			if ($vparam_band  ==1)
			{
				$label_band_amostrar = $nombreband_1; //"800";
			}
			if ($vparam_band  ==2)
			{
				$label_band_amostrar = $nombreband_2; //"800";
			}
			if ($vparam_band  ==3)
			{
				$label_band_amostrar = $nombreband_3; //"800";
			}

		
			if(  $ciuisdas =="Y"   && 	$ciuiscentrix=="Y")
			{
				//echo "SI";
				$query_listacuadros="SELECT distinct fas_tree_measure.totalpass,  fas_tree_measure.iduniqueop,  fas_step.description as namebranch,  fas_tree_measure.iduniquebranch, fas_tree_measure.unitsn, fas_tree_measure.dibsn, fas_tree_measure.uldl, fas_tree_measure.band
				,fas_tree_measure.idrununfo
				from fas_tree_measure
				inner join fas_tree
				on fas_tree.iduniquebranch = fas_tree_measure.iduniquebranch  and fas_tree.idfastree =  1
				inner join fas_step
				on fas_step.idfasstep = fas_tree.idfastrepson


				inner join (
					select unitsn, idrununfo,  iduniquebranch, max(idrev) as maxidrev
				from fas_tree_measure where
				fas_tree_measure.iduniquebranch like '002%'   and band = ".$vparam_band." and unitsn = '".$vparam_vnrounitsn."' AND idrununfo = ".$vparam_idruninfo. " 
				group by unitsn, idrununfo,iduniquebranch
				) as maxretry
				on maxretry.unitsn			=	fas_tree_measure.unitsn and
				maxretry.idrununfo			=	fas_tree_measure.idrununfo and 
				maxretry.iduniquebranch		=	fas_tree_measure.iduniquebranch and
				maxretry.maxidrev 			=	fas_tree_measure.idrev


				where  fas_tree_measure.iduniquebranch like '002%'   and  fas_tree_measure.band = ".$vparam_band." and  fas_tree_measure.unitsn = '".$vparam_vnrounitsn."' and  fas_tree_measure.idrununfo =".$vparam_idruninfo. " order by iduniqueop";
//echo $query_listacuadros;
			}
			else
			{
				$query_listacuadros="SELECT distinct fas_tree_measure.totalpass,  fas_tree_measure.iduniqueop,  fas_step.description as namebranch,  fas_tree_measure.iduniquebranch, fas_tree_measure.unitsn, fas_tree_measure.dibsn, fas_tree_measure.uldl, fas_tree_measure.band
				,fas_tree_measure.idrununfo
				from fas_tree_measure
				inner join fas_tree
				on fas_tree.iduniquebranch = fas_tree_measure.iduniquebranch  and fas_tree.idfastree =  1
				inner join fas_step
				on fas_step.idfasstep = fas_tree.idfastrepson


				inner join (
					select unitsn, idrununfo,  iduniquebranch, max(idrev) as maxidrev
				from fas_tree_measure where
				fas_tree_measure.iduniquebranch like '002%' and uldl = ".$vaparam_uldl ." and band = ".$vparam_band." and unitsn = '".$vparam_vnrounitsn."' AND idrununfo = ".$vparam_idruninfo. " 
				group by unitsn, idrununfo,iduniquebranch
				) as maxretry
				on maxretry.unitsn			=	fas_tree_measure.unitsn and
				maxretry.idrununfo			=	fas_tree_measure.idrununfo and 
				maxretry.iduniquebranch		=	fas_tree_measure.iduniquebranch and
				maxretry.maxidrev 			=	fas_tree_measure.idrev


				where  fas_tree_measure.iduniquebranch like '002%' and fas_tree_measure.uldl = ".$vaparam_uldl." and  fas_tree_measure.band = ".$vparam_band." and  fas_tree_measure.unitsn = '".$vparam_vnrounitsn."' and  fas_tree_measure.idrununfo =".$vparam_idruninfo. " order by iduniqueop";

			}

	///echo "<br>Cuadros:".$query_listacuadros;			
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
					 unset($arrayfreqpwr);
				 $freqlabel ="";
				 $array_finalchk_gaingrafico="";
				 $finalchk_gain_freqshow="";
				  $freqlabelpwr="";
				  unset(  $array_finalchk_pwr);

					$array_finalchk_pwrgrafico="";
					$finalchk_gain_freqshowpwr="";
					$lblfreqmostrargrafico ="";

					$array_finalchk_abajo1_freq="";
					$array_finalchk_abajo1_pwrin="";
					$array_finalchk_abajo1_gainnoagc="";
					$array_finalchk_abajo2_pwr="";

					$array_finalchk_abajo3_uclevel="";
					$array_finalchk_abajo4_ucchanc="";
					$array_finalchk_abajo5_ucbbagc= "";

					$array_finalchk_levelread_freq="";
						$array_finalchk_levelread_uclevel="";
						unset(	$Finalchk_levelread_freq);
						unset(	$Finalchk_levelread_uclevel);

					unset(  $Finalchk_imd_4);
					unset(  $Finalchk_imd_3 );
					unset(  $Finalchk_imd_2 );
					unset(  $Finalchk_imd_1);
					unset(  $Finalchk_imdfreq );

					unset(  $array_finalchk_noisefigshow);
					$array_finalchk_noisefig="";

					$idrunaferbur = $_REQUEST['idrunaferbur'];

					$tienemediciodelinealidad ="N";
					$tienedatosgraflevelread ="N";
				 foreach ($datacuadros as $row) 
				  {
					   if("002007013" ==$row['iduniquebranch'])
					  {
						   
						
								   
						    $query_lista5=" select * from fas_singlemeasures where iduniqueop = ".$row['iduniqueop']." order by id_singlemeasure";
						//	echo  "<br>///FinalCheck_Measures_Gain".$query_lista5;
							///	echo "<br>Agus.. Pwrin:::".$query_lista5;
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
						$tienemediciodelinealidad ="S";
						//select distinct freq ,pwrin,  gainnoagc from fas_singlemeasures where iduniqueop = 503
					   //select distinct freq ,  gainnoagc from fas_singlemeasures where iduniqueop = 503
							$query_lista5="select distinct id_singlemeasure,	 freq , pwrin, gainnoagc from fas_singlemeasures where iduniqueop = ".$row['iduniqueop']." order by id_singlemeasure ";	
						echo "<br>Grafico 1 gain:".$query_lista5;	
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
					   ///FinalCheck_Measures_LevelRead
						if("002007062" ==$row['iduniquebranch'])
						{
							//			echo "aaaaaaaaaaaaaaa<br>";
							//	select * from fas_ucmeasures   where iduniqueop = 182374  --- uclevel
							$query_listalevelread=" select distinct * from fas_ucmeasures where iduniqueop = ".$row['iduniqueop']." order by id_ucmeasures ";
						//	 echo  'query_listalevelread'.$query_listalevelread;
							$indtooltip = 0;
							$vtmparrayind=0;
							$datalevelread1 = $connect->query($query_listalevelread)->fetchAll();
							foreach ($datalevelread1 as $rowleveltr1) 
							  {
								  $tienedatosgraflevelread ="S";
								$Finalchk_levelread_uclevel[]= round($rowleveltr1['uclevel'],1); 
								$array_finalchk_levelread_uclevel =  $array_finalchk_levelread_uclevel."".round($rowleveltr1['uclevel'],1).",";	
								$showLevelread_pwrin = $rowleveltr1['pwrin'];
								$have_levelread ='Y';
								$array_finalchk_levelread_tooltip_pwrin[$indtooltip][$vtmparrayind] =  $rowleveltr1['pwrin'];
								$array_finalchk_levelread_tooltip_uclevel[$indtooltip][$vtmparrayind] = round( $rowleveltr1['uclevel'],2);
								$array_finalchk_levelread_tooltip_ucchagc[$indtooltip][$vtmparrayind] =  $rowleveltr1['ucchagc'];
								$array_finalchk_levelread_tooltip_ucbbagc[$indtooltip][$vtmparrayind] =  $rowleveltr1['ucbbagc'];
								$array_finalchk_levelread_tooltip_ucoutputpwr[$indtooltip][$vtmparrayind] =  round($rowleveltr1['ucoutputpwr'],2);
								$array_finalchk_levelreadn_tooltip_uctemperature[$indtooltip][$vtmparrayind] = round( $rowleveltr1['uctemperature'],2);
								$array_finalchk_levelread_tooltip_pacurrent[$indtooltip][$vtmparrayind] =  $rowleveltr1['pacurrent'];
								$indtooltip = $indtooltip+ 1;
								$vtmparrayind = $vtmparrayind+1;
							  }	 
								//	select * from fas_sameasures   where iduniqueop = 182374   -- para titulo fcent
								$query_listalevelread2=" select distinct * from fas_sameasures where iduniqueop = ".$row['iduniqueop']." order by id_sameasures ";
								//	echo "<br>".$query_listalevelread2;

								$datalevelread1a = $connect->query($query_listalevelread2)->fetchAll();
								foreach ($datalevelread1a as $rowleveltr1a) 
								{
								$Finalchk_levelread_freq[]=$rowleveltr1a['fcent']; 
								$array_finalchk_levelread_freq=  $array_finalchk_levelread_freq."".$rowleveltr1a['fcent'].",";	

								}	 
						}

						

					   if("00200701B" ==$row['iduniquebranch'])
					  {
						  
						  
								  
								  
						  	$query_lista5=" select distinct fas_sameasures.fcent, fas_mkrmeasures.*
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
					  if("00200701C" ==$row['iduniquebranch'] || $idrunaferbur <>"")
					  {

						if ($idrunaferbur=="")
						{
						  $eluniquemodiparaNF = $row['iduniqueop'];
						}
						else
						{
							////999999
							  $queryspecial="SELECT   fas_tree_measure.iduniqueop
							  from fas_tree_measure
							  inner join fas_tree
							  on fas_tree.iduniquebranch = fas_tree_measure.iduniquebranch  and fas_tree.idfastree =  1
							  inner join fas_step
							  on fas_step.idfasstep = fas_tree.idfastrepson
							  inner join 
							  (
								  select unitsn , iduniquebranch, max(idrev) as maxeje
							  from fas_tree_measure
							  where fas_tree_measure.iduniquebranch like '002%'  and  unitsn = '".$vparam_vnrounitsn."' and  idrununfo =".$idrunaferbur. " and  band = ".$vparam_band." 
							  group by unitsn , iduniquebranch
							  ) as maxidrev
							  on maxidrev.unitsn = fas_tree_measure.unitsn and 
							  maxidrev.iduniquebranch =  fas_tree_measure.iduniquebranch and 
							  maxidrev.maxeje =  fas_tree_measure.idrev
							  where  fas_tree_measure.iduniquebranch like '002%'   and  fas_tree_measure.unitsn = '".$vparam_vnrounitsn."' and  idrununfo =".$idrunaferbur. " and  band = ".$vparam_band." and fas_tree_measure.iduniquebranch = '00200701C' limit 1";
							  $dataspecial = $connect->query($queryspecial)->fetchAll();
						//	  echo "<br>a ver la quey special =".$queryspecial;
							  foreach ($dataspecial as $rowspecc) 
							  {
								  $eluniquemodiparaNF = $rowspecc['iduniqueop'];
							///	  echo "<br>ID nuevoo".$eluniquemodiparaNF;
							  }

					 
							  
						}
						$idrunaferbur = "";
						   
								   
						    $query_lista5=" select * from fas_noisefigure where iduniqueop = ".$eluniquemodiparaNF." order by idfas_noisefigure ";
						   
								   
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

		
		////////////////////////////////////////////
		///// Ultimo controll  $array_finalchk_pwr[]
		///echo "a ver cuantos tengoo".count( $array_finalchk_pwr)."<br>";		  
		if (count( $array_finalchk_pwr) < 9)
		{
			//////FRENAMOS TODO si tenemos solo 1 muestra de POWER
			//echo "FRENAMOS TODO si tenemos solo 1 muestra de POWER";
			///exit();
		}

		?>
		<div  class="page_break" id="content<?php echo "".$label_band_amostrar ." - ".$label_ULDL_amostrar; ?>" name="content<?php echo "".$label_band_amostrar ." - ".$label_ULDL_amostrar; ?>"> 
		<h3 style="text-decoration: underline;"><?php
		/// echo "".$label_band_amostrar ." - ".$label_ULDL_amostrar; 

		 if(  $ciuisdas =="Y" && 	$ciuiscentrix=="Y")
		 {
			 echo " ".$label_band_amostrar;
		 }
		 else
		 {
			 echo " ".$label_band_amostrar ." - ".$label_ULDL_amostrar;
		 }	

		 ?></h3>
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
								if($mi==5)
								{
									break;
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
								if($mi==5)
								{
									break;
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
								if($mi==5)
								{
									break;
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
								if($mi==5)
								{
									break;
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
								if($mi==5)
								{
								
									
									break;
								}
							}
					?>   		  					  
                    </tr> 
					
                     <tr>
                    
					
                  </tbody>
				    </table>
		<br>
		<hr>
		<!-- levelread tabla especial  -->
<?php
// if( $typeproduct_ciu == "PSC REMOTE")
if(  ($ciuisdas =="Y"  && 	$ciuiscentrix=="Y") )
{ ?>
<br>


<table style="width: 100%;font-size: 10pt;text-align: left;border-top: 2px solid black;border-right: 2px solid black;border-left: 2px solid black; border-bottom: 2px solid black;">
         
<thead class="thead-dark">
<tr>
<th style="font-size: 10pt;text-align: left;border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black; border-bottom: 1px solid black;">Freq - [MHz]</th>
<?php
$mi=0;
foreach($Finalchk_levelread_freq as $fec) 
   {
	   echo "<th style='font-size: 10pt;text-align: left;border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black; border-bottom: 1px solid black;''>" . round($fec,3) ."</th>";
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

<td class="table-dark text-left"> Level Read  @<?php echo $showLevelread_pwrin;
///variable fija de pwrin de fas_ucmeasures para el iuniqueipp
?> dBm</td>
  <?php
 //  $minombrenf = $mi;
   $mi=0;

   foreach( $Finalchk_levelread_uclevel as $leveldat) 
		{
		//	echo "<td>" . $leveldat . "</td>";
				echo "<td style='font-size: 10pt;text-align: left;border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black; border-bottom: 1px solid black;'> " . $leveldat . "
			
				</td>";
			$minombrenf=$minombrenf+1;
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
<?php } ?>
<!-- fin levelread tabla especial -->
		<br>
		<?php
				/// if( $typeproduct_ciu == "PSC REMOTE")
				$mostrargraficosDAS="";
				$mostrargraficosDASENTER="";
				if(  ($ciuisdas =="Y"  &&   $ciuiscentrix=="Y")  )
				{
					$mostrargraficosDAS="display: none";
					
				}
			
					if (  	$ciuisenterprice =="Y")
					{
						$mostrargraficosDASENTER="display: none";
					}
				
				if($tienemediciodelinealidad =="N")
				{
					$mostrargraficosDAS="display: none";
				}	
				
			?>

		<table style="width: 680px;font-size: 10pt;text-align: center;border-top: 0px solid black;border-right: 0px solid black;border-left: 0px solid black; border-bottom: 0px solid black;">
        <tr>
			<td style="width:340px;height:190px;">Gain       
			<canvas id="salesCharttxripple<?php echo $vvv_sumanombregraf; ?>" width="338px" height="245px"  style="height: 245px;width:338px"></canvas>
		</td>
			<td style="width:340px;height:190px;">Max Power
		<canvas id="salesChartpowers<?php echo $vvv_sumanombregraf; ?>" width="338px" height="245px"  style="height: 245px;width:338px"></canvas>
		</td>
		</tr>
		</table>
		<?php if (	$mostrargraficosDAS=="") 
		{
			?>
			<div style="<?php echo $mostrargraficosDASENTER ?>">
				<table style="width: 680px;font-size: 10pt;text-align: center;border-top: 0px solid black;border-right: 0px solid black;border-left: 0px solid black; border-bottom: 0px solid black;">

				<tr>
				<td style="width:340px;height:19px;" >Noise Figure   
				<canvas id="salesChartlevel<?php echo $vvv_sumanombregraf; ?>" width="338px" height="245px"  style="height: 245px;width:338px"></canvas>
				</td>

				<td style="width:340px;height:190px;">Gain vs PwrIn 
				<canvas id="graficoabajo1<?php echo $vvv_sumanombregraf; ?>" width="338px" height="245px"  style="height: 245px;width:338px"></canvas>
			
				</td>
				</tr>

				</table>
					<div class='d-none'>
					<canvas id="graficoabajolr<?php echo $vvv_sumanombregraf; ?>" width="0px" height="0px"  style="height: 0px;width:0px"></canvas>
					</div>
				</div>
			<?php
		}
		else
		{
			?>
			<div style="<?php echo $mostrargraficosDASENTER ?>">
				<table style="width: 680px;font-size: 10pt;text-align: center;border-top: 0px solid black;border-right: 0px solid black;border-left: 0px solid black; border-bottom: 0px solid black;">

				<tr>
				<td style="width:340px;height:19px;" >Noise Figure   
				<canvas id="salesChartlevel<?php echo $vvv_sumanombregraf; ?>" width="338px" height="245px"  style="height: 245px;width:338px"></canvas>
				</td>

				<td style="width:340px;height:190px;"> 
				<canvas id="graficoabajo1<?php echo $vvv_sumanombregraf; ?>" width="0px" height="0px"  style="height: 0px;width:0px"></canvas>
				<?php if ($tienedatosgraflevelread =="N")
				{
					?>
			 			<p style='display: none'>
						<canvas id="graficoabajolr<?php echo $vvv_sumanombregraf; ?>" width="0px" height="0px"  style="height: 0px;width:0px"></canvas>
						</p>
					<?php
				}  
				else
				{
					?>
					Level Read  @<?php echo $showLevelread_pwrin; ?>
				<canvas id="graficoabajolr<?php echo $vvv_sumanombregraf; ?>" width="338px" height="245px"  style="height: 245px;width:338px"></canvas>
					<?php
				}
				?>
				
					</td>
				</tr>

				</table>
				</div>
			<?php
		} ?>
	
			
				<div style="<?php echo $mostrargraficosDAS; ?>">
	
		<br>	<br>	<br>	<br>	<br>	<br>	<br>	<br>	<br>
		<table style="width: 680px;font-size: 10pt;text-align: center;border-top: 0px solid black;border-right: 0px solid black;border-left: 0px solid black; border-bottom: 0px solid black;">
		
		<tr>
			<td style="width:340px;height:190px;">PwrOut vs PwrIn   
		<canvas id="graficoabajo2<?php echo $vvv_sumanombregraf; ?>" width="338px" height="245px"  style="height: 245px;width:338px"></canvas>
		</td>
		
			<td style="width:340px;height:190px;">PwrIn Dynamic Range   
		<canvas id="graficoabajo3<?php echo $vvv_sumanombregraf; ?>" width="338px" height="245px"  style="height: 245px;width:338px"></canvas>
		</td>
		</tr>
				</table>
		<table style="width: 680px;font-size: 10pt;text-align: center;border-top: 0px solid black;border-right: 0px solid black;border-left: 0px solid black; border-bottom: 0px solid black;">
		
		<tr>
			<td style="width:340px;height:190px;">Ch AGC vs PwrIn  
		<canvas id="graficoabajo4<?php echo $vvv_sumanombregraf; ?>" width="338px" height="245px"  style="height: 245px;width:338px"></canvas>
		</td>
		
			<td style="width:340px;height:190px;">BB AGC vs PwrIn   
		<canvas id="graficoabajo5<?php echo $vvv_sumanombregraf; ?>" width="338px" height="245px"  style="height: 245px;width:338px"></canvas>
		
		</td>
		</tr>
		</table>	
		</div>

		
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
		<?php
		
	
	}
									  
?>


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
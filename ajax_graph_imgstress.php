<?php
error_reporting(0);
    include("db_conect.php"); 
		header('Content-Type: application/json');

		$idruninfo =$_REQUEST['idruninfo'];	
		$idrun =$_REQUEST['idruninfo'];	
		
		////////////////////////    //////////////////////////////////
$sqlmmhead="
select distinct  bandnuevo, uldl  , iduniquebranch,   script,    timename, iduniqueop ,  pwr2  as arraypwr,duration,idmm, 
ARRAY_AGG (    round( CAST(freq as numeric),2)    ) as arraylbl 
from 
(

select distinct  bandnuevo, uldl  , iduniquebranch,   script,    timename, iduniqueop , freq  ,duration
,ARRAY_AGG (    round( CAST(pwr as numeric),2)  order by id_mkrmeasures asc ) as pwr2  ,row_number() OVER(order by bandnuevo) as idmm
from
(


	---select 2	 
		select   distinct id_mkrmeasures,  bandnuevo, listroutime.uldl  , listroutime.iduniquebranch,  branchname as script,    fas_times_type.timename, fas_tree_measure.iduniqueop
		,freq, fas_mkrmeasures.pwr  , max(fas_times.duration) as duration
		from fnt_select_allfas_tree_measure_maxrev2() as fas_tree_measure 
		inner join
		(
			---- select1
			select fas_routines_product.*,fas_step.description as branchname, CASE fas_routines_product.idband
		WHEN 0  THEN 0
		WHEN 3  THEN 0
		WHEN 4  THEN 1
		WHEN 8  THEN 1
		WHEN 7  THEN 1
		WHEN 1  THEN 1
		WHEN 6  THEN 1
		ELSE NULL
		END AS bandnuevo2 , idband.idbandforfas as bandnuevo
		from fas_routines_product 
		inner join idband
		on idband.idband = fas_routines_product.idband
			inner join fas_tree_product 
			on fas_tree_product.idproduct = fas_routines_product.idproduct
			inner join fas_tree
			on fas_tree.iduniquebranch = fas_routines_product.iduniquebranch
			and fas_tree.idfastree = fas_tree_product.idfastree
			inner join fas_step
			on fas_tree.idfastrepson = fas_step.idfasstep
			where fas_routines_product.idproduct  in (
				
				
				
				select lasdos.idproduct from 
				(
				SELECT idproduct ,1 as ordernmm from orders_sn where typeregister = 'SO' and  wo_serialnumber in (select unitsn from fas_tree_measure where idrununfo =  ".$idruninfo." )
				union 
				SELECT idproduct,2  from orders_sn where typeregister = 'WO' and  wo_serialnumber in (select unitsn from fas_tree_measure where idrununfo =  ".$idruninfo." )
				) as lasdos 
				inner join products_attributes
				on 				products_attributes.idproduct  = lasdos.idproduct and
				products_attributes.idattribute = 0 and v_boolean = true
				order by ordernmm asc limit 1
				
				)

			and fas_routines_product.active = 'Y'
			order by idorden
			
			--select 1
		) as listroutime
		on listroutime.iduniquebranch =  fas_tree_measure.iduniquebranch and
		listroutime.bandnuevo =  fas_tree_measure.band and
		listroutime.uldl =  fas_tree_measure.uldl 

		inner join runinfodb
		on runinfodb.idruninfodb = fas_tree_measure.idrununfo
		inner join fas_times
		on fas_times.iduniqueop   = fas_tree_measure.iduniqueop 
		and fas_times.idsinglemeasure is null 
		and fas_times.idsameasures is null
		and fas_times.iducmeasure is null

	 
		left join fas_mkrmeasures 
		on fas_mkrmeasures.iduniqueop = fas_tree_measure.iduniqueop

		inner join fas_times_type
		on fas_times_type.idtimetype = fas_times.idtimetype
		where idrununfo =  ".$idruninfo."     and listroutime.iduniquebranch = '00200701B'
		group by id_mkrmeasures,  bandnuevo, listroutime.uldl  , listroutime.iduniquebranch,  branchname  ,    fas_times_type.timename, fas_tree_measure.iduniqueop
		,freq, fas_mkrmeasures.pwr 
		order by id_mkrmeasures asc

	 
 
) as final
--where pwr_txconmedia >0
group  by bandnuevo, uldl  , iduniquebranch,   script,    timename, iduniqueop, freq ,duration
) as ult
group  by bandnuevo, uldl  , iduniquebranch,   script,    timename, iduniqueop, pwr2, duration , idmm
order by bandnuevo, uldl  , iduniquebranch, arraylbl


 	   
	
";
////////////////////// FinalCheck_Measures_IMD

 $i_0_0 = 0;
 $i_0_1 = 0;
 $i_1_0 = 0;
 $i_1_1 = 0;

 //echo $sqlmmhead;
 
$tem="orange";
$dataheadr = $connect->query($sqlmmhead)->fetchAll();
foreach ($dataheadr as $rowhead) 
	{
		
			if ($rowhead['bandnuevo'] == 0 && $rowhead['uldl']==0)
			{
				if ( $i_0_0 ==0)
				{
					$iduniqueop_band_0_uldl_0_imdstress_0 = substr($rowhead['arraypwr'],1,-1);
				}
				if ( $i_0_0 ==1)
				{
					$iduniqueop_band_0_uldl_0_imdstress_1 = substr($rowhead['arraypwr'],1,-1);
				}
				if ( $i_0_0 ==2)
				{
					$iduniqueop_band_0_uldl_0_imdstress_2 = substr($rowhead['arraypwr'],1,-1);
				}
				if ( $i_0_0 ==3)
				{
					$iduniqueop_band_0_uldl_0_imdstress_3 = substr($rowhead['arraypwr'],1,-1);
				}
				$i_0_0 =  $i_0_0+1;
				$label_imdstress_calib_0_0 = 	$label_imdstress_calib_0_0.substr($rowhead['arraylbl'],1,-1).",";  
				$dura_0_0 = $rowhead['duration'];
				
			}
			if ($rowhead['bandnuevo'] == 0 && $rowhead['uldl']==1)
			{
				if ( $i_0_1 ==0)
				{
					$iduniqueop_band_0_uldl_1_imdstress_0 = substr($rowhead['arraypwr'],1,-1);
				}
				if ( $i_0_1 ==1)
				{
					$iduniqueop_band_0_uldl_1_imdstress_1 = substr($rowhead['arraypwr'],1,-1);
				}
				if ( $i_0_1 ==2)
				{
					$iduniqueop_band_0_uldl_1_imdstress_2 = substr($rowhead['arraypwr'],1,-1);
				}
				if ( $i_0_1 ==3)
				{
					$iduniqueop_band_0_uldl_1_imdstress_3 = substr($rowhead['arraypwr'],1,-1);
				}
				$i_0_1 =  $i_0_1+1;
				$label_imdstress_calib_0_1 = 	$label_imdstress_calib_0_1.substr($rowhead['arraylbl'],1,-1).",";  
				$dura_0_1 = $rowhead['duration'];
			}
			if ($rowhead['bandnuevo'] == 1 && $rowhead['uldl']==0)
			{
				if ( $i_1_0 ==0)
				{
					$iduniqueop_band_1_uldl_0_imdstress_0 = substr($rowhead['arraypwr'],1,-1);
				}
				if ( $i_1_0 ==1)
				{
					$iduniqueop_band_1_uldl_0_imdstress_1 = substr($rowhead['arraypwr'],1,-1);
				}
				if ( $i_1_0 ==2)
				{
					$iduniqueop_band_1_uldl_0_imdstress_2 = substr($rowhead['arraypwr'],1,-1);
				}
				if ( $i_1_0 ==3)
				{
					$iduniqueop_band_1_uldl_0_imdstress_3 = substr($rowhead['arraypwr'],1,-1);
				}
				$i_1_0 =  $i_1_0+1;
				$label_imdstress_calib_1_0 = 	$label_imdstress_calib_1_0.substr($rowhead['arraylbl'],1,-1).",";   
				$dura_1_0 = $rowhead['duration'];
			}
			if ($rowhead['bandnuevo'] == 1 && $rowhead['uldl']==1)
			{
				if ( $i_1_1 ==0)
				{
					$iduniqueop_band_1_uldl_1_imdstress_0 = substr($rowhead['arraypwr'],1,-1);
				}
				if ( $i_1_1 ==1)
				{
					$iduniqueop_band_1_uldl_1_imdstress_1 = substr($rowhead['arraypwr'],1,-1);
				}
				if ( $i_1_1 ==2)
				{
					$iduniqueop_band_1_uldl_1_imdstress_2 = substr($rowhead['arraypwr'],1,-1);
				}
				if ( $i_1_1 ==3)
				{
					$iduniqueop_band_1_uldl_1_imdstress_3 = substr($rowhead['arraypwr'],1,-1);
				}
				$i_1_1 =  $i_1_1+1;
				$label_imdstress_calib_1_1 = 	$label_imdstress_calib_1_1.substr($rowhead['arraylbl'],1,-1).",";   
				$dura_1_1 = $rowhead['duration'];
			}
		 
	}
//////////////////////// FIN    //////////////////////////////////
echo(json_encode(["dura_0_0"=>$dura_0_0,"dura_0_1"=>$dura_0_1,"dura_1_0"=>$dura_1_0,"dura_1_1"=>$dura_1_1,"label_imdstress_calib_0_0"=>$label_imdstress_calib_0_0,"label_imdstress_calib_0_1"=>$label_imdstress_calib_0_1,"label_imdstress_calib_1_0"=>$label_imdstress_calib_1_0,"label_imdstress_calib_1_1"=>$label_imdstress_calib_1_1,"iduniqueop_band_0_uldl_0_imdstress_0"=>$iduniqueop_band_0_uldl_0_imdstress_0,"iduniqueop_band_0_uldl_0_imdstress_1"=>$iduniqueop_band_0_uldl_0_imdstress_1,"iduniqueop_band_0_uldl_0_imdstress_2"=>$iduniqueop_band_0_uldl_0_imdstress_2,"iduniqueop_band_0_uldl_0_imdstress_3"=>$iduniqueop_band_0_uldl_0_imdstress_3,"iduniqueop_band_0_uldl_1_imdstress_0"=>$iduniqueop_band_0_uldl_1_imdstress_0,"iduniqueop_band_0_uldl_1_imdstress_1"=>$iduniqueop_band_0_uldl_1_imdstress_1,"iduniqueop_band_0_uldl_1_imdstress_2"=>$iduniqueop_band_0_uldl_1_imdstress_2,"iduniqueop_band_0_uldl_1_imdstress_3"=>$iduniqueop_band_0_uldl_1_imdstress_3,"iduniqueop_band_1_uldl_0_imdstress_0"=>$iduniqueop_band_1_uldl_0_imdstress_0,"iduniqueop_band_1_uldl_0_imdstress_1"=>$iduniqueop_band_1_uldl_0_imdstress_1,"iduniqueop_band_1_uldl_0_imdstress_2"=>$iduniqueop_band_1_uldl_0_imdstress_2,"iduniqueop_band_1_uldl_0_imdstress_3"=>$iduniqueop_band_1_uldl_0_imdstress_3,"iduniqueop_band_1_uldl_1_imdstress_0"=>$iduniqueop_band_1_uldl_1_imdstress_0,"iduniqueop_band_1_uldl_1_imdstress_1"=>$iduniqueop_band_1_uldl_1_imdstress_1,"iduniqueop_band_1_uldl_1_imdstress_2"=>$iduniqueop_band_1_uldl_1_imdstress_2,"iduniqueop_band_1_uldl_1_imdstress_3"=>$iduniqueop_band_1_uldl_1_imdstress_3,"iduniqueop_band_0_uldl_1_imdstress"=>$iduniqueop_band_0_uldl_1_imdstress,"iduniqueop_band_1_uldl_0_imdstress"=>$iduniqueop_band_1_uldl_0_imdstress,"iduniqueop_band_1_uldl_1_imdstress"=>$iduniqueop_band_1_uldl_1_imdstress ]));
 
?>
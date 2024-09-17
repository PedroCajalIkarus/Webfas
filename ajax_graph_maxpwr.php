<?php
error_reporting(0);
    include("db_conect.php"); 
		header('Content-Type: application/json');

		$idruninfo =$_REQUEST['idruninfo'];	
		$idrun =$_REQUEST['idruninfo'];	

		/*
		////////////////////////  FinalCheck_Measures_MaxPower //////////////////////////////////
 */
/*
$sqlmmhead ="
select distinct  bandnuevo, uldl  , iduniquebranch,   script,    timename, iduniqueop, pwrin
,ARRAY_AGG (    round( CAST(pwr as numeric),2) order by freq asc ) as arraypwr , ARRAY_AGG (   round( CAST(freq as numeric),2) order by freq asc) as arraylbl 
from
(
    --select 1
  select distinct id_mkrmeasures,  bandnuevo, listroutime.uldl  , listroutime.iduniquebranch,  branchname as script,    fas_times_type.timename, fas_tree_measure.iduniqueop
  ,fas_mkrmeasures.pwr, freq ,fas_ucmeasures.pwrin 
  from fnt_select_allfas_tree_measure_maxrev2() as fas_tree_measure 
  inner join
  (
    ---select listarutines
    select fas_routines_product.*,fas_step.description as branchname, CASE fas_routines_product.idband
  WHEN 0  THEN 0
  WHEN 3  THEN 0
  WHEN 4  THEN 1
  WHEN 8  THEN 1
  WHEN 7  THEN 1
  WHEN 1  THEN 1
  WHEN 6  THEN 1
  ELSE NULL
  END AS bandnuevo from  fas_routines_product 
    inner join fas_tree_product 
    on fas_tree_product.idproduct = fas_routines_product.idproduct
    inner join fas_tree
    on fas_tree.iduniquebranch = fas_routines_product.iduniquebranch
    and fas_tree.idfastree = fas_tree_product.idfastree
    inner join fas_step
    on fas_tree.idfastrepson = fas_step.idfasstep
    where fas_routines_product.idproduct in (
      
      
      select lasdos.idproduct from 
      (
      SELECT idproduct ,1 as ordernmm from orders_sn where typeregister = 'SO' and  wo_serialnumber in (select unitsn from fas_tree_measure where idrununfo =  ".$idrun." )
      union 
      SELECT idproduct,2  from orders_sn where typeregister = 'WO' and  wo_serialnumber in (select unitsn from fas_tree_measure where idrununfo =  ".$idrun." )
      ) as lasdos 
      inner join products_attributes
      on 				products_attributes.idproduct  = lasdos.idproduct and
      				products_attributes.idattribute = 0 and v_boolean = true
      order by ordernmm asc limit 1
      
      )
     
    and fas_routines_product.active = 'Y'
    order by idorden
    ---select listarutines
  ) as listroutime
  on listroutime.iduniquebranch =  fas_tree_measure.iduniquebranch and
  listroutime.bandnuevo =  fas_tree_measure.band and
  listroutime.uldl =  fas_tree_measure.uldl and
  listroutime.idorden         = fas_tree_measure.idorder  and 
      fas_tree_measure.idrununfo = ".$idrun."
  
  inner join runinfodb
  on runinfodb.idruninfodb = fas_tree_measure.idrununfo
  inner join fas_times
  on fas_times.iduniqueop   = fas_tree_measure.iduniqueop 
  and fas_times.idsinglemeasure is null 
  and fas_times.idsameasures is null
  and fas_times.iducmeasure is null
  
  left join fas_mkrmeasures 
  on fas_mkrmeasures.iduniqueop = fas_tree_measure.iduniqueop
    
  left join fas_ucmeasures
    on fas_ucmeasures.iduniqueop = fas_tree_measure.iduniqueop
  
  inner join fas_times_type
  on fas_times_type.idtimetype = fas_times.idtimetype
  where idrununfo = ".$idrun."    and listroutime.iduniquebranch = '00200701A'
  order by bandnuevo, uldl,id_mkrmeasures
    --select 1
 ) as final
--	where pwr_txconmedia >0
group  by bandnuevo, uldl  , iduniquebranch,   script,    timename, iduniqueop,pwrin
order by  bandnuevo, uldl  ";
////////////////////// FinalCheck_Measures_MaxPower
*/
 

$sqlmmhead ="
select distinct  bandnuevo, uldl  , iduniquebranch,   script,    timename, iduniqueop, pwrin
,ARRAY_AGG (    round( CAST(pwr as numeric),2) order by freq asc ) as arraypwr , ARRAY_AGG (   round( CAST(freq as numeric),2) order by freq asc) as arraylbl 
from
(
    --select 1
  select distinct id_mkrmeasures,  bandnuevo, listroutime.uldl  , listroutime.iduniquebranch,  branchname as script,    fas_times_type.timename, fas_tree_measure.iduniqueop
  ,fas_mkrmeasures.pwr, freq ,fas_ucmeasures.pwrin 
  from fnt_select_allfas_tree_measure_maxrev2() as fas_tree_measure 
  inner join
  (
    ---select listarutines
    select fas_routines_product.*,' ' as branchname, CASE fas_routines_product.idband
  WHEN 0  THEN 0
  WHEN 3  THEN 0
  WHEN 4  THEN 1
  WHEN 8  THEN 1
  WHEN 7  THEN 1
  WHEN 1  THEN 1
  WHEN 6  THEN 1
  ELSE NULL
  END AS bandnuevo2 , idband.idbandforfas as bandnuevo
  from fas_routines_product_sn as  fas_routines_product 
  inner join idband
  on idband.idband = fas_routines_product.idband
     
    where fas_routines_product.idproduct in (
      
      
      select lasdos.idproduct from 
      (
      SELECT idproduct ,1 as ordernmm from orders_sn where typeregister = 'SO' and  wo_serialnumber in (select unitsn from fas_tree_measure where idrununfo =  ".$idrun." )
      union 
      SELECT idproduct,2  from orders_sn where typeregister = 'WO' and  wo_serialnumber in (select unitsn from fas_tree_measure where idrununfo =  ".$idrun." )
      ) as lasdos 
      inner join products_attributes
      on 				products_attributes.idproduct  = lasdos.idproduct and
      				products_attributes.idattribute = 0 and v_boolean = true
      order by ordernmm asc limit 1
      
      )
     
  
    order by idorden
    ---select listarutines
  ) as listroutime
  on listroutime.iduniquebranch =  fas_tree_measure.iduniquebranch and
  listroutime.bandnuevo =  fas_tree_measure.band and
  listroutime.uldl =  fas_tree_measure.uldl and
  listroutime.idorden         = fas_tree_measure.idorder  and 
      fas_tree_measure.idrununfo = ".$idrun."
  
  inner join runinfodb
  on runinfodb.idruninfodb = fas_tree_measure.idrununfo
  inner join fas_times
  on fas_times.iduniqueop   = fas_tree_measure.iduniqueop 
  and fas_times.idsinglemeasure is null 
  and fas_times.idsameasures is null
  and fas_times.iducmeasure is null
  
  left join fas_mkrmeasures 
  on fas_mkrmeasures.iduniqueop = fas_tree_measure.iduniqueop
    
  left join fas_ucmeasures
    on fas_ucmeasures.iduniqueop = fas_tree_measure.iduniqueop
  
  inner join fas_times_type
  on fas_times_type.idtimetype = fas_times.idtimetype
  where idrununfo = ".$idrun."    and listroutime.iduniquebranch = '00200701A'
  order by bandnuevo, uldl,id_mkrmeasures
    --select 1
 ) as final
--	where pwr_txconmedia >0
group  by bandnuevo, uldl  , iduniquebranch,   script,    timename, iduniqueop,pwrin
order by  bandnuevo, uldl  ";

//echo $sqlmmhead;
$tem="orange";

$dataheadr = $connect->query($sqlmmhead)->fetchAll();
foreach ($dataheadr as $rowhead) 
	{
		
			if ($rowhead['bandnuevo'] == 0 && $rowhead['uldl']==0)
			{
				$iduniqueop_band_0_uldl_0_maxpwr = substr($rowhead['arraypwr'],1,-1);
				$label_maxpwr_calib_0_0 =  substr($rowhead['arraylbl'],1,-1);
				$freq_ref_0_0=   $rowhead['pwrin'];
			}
			if ($rowhead['bandnuevo'] == 0 && $rowhead['uldl']==1)
			{
				$iduniqueop_band_0_uldl_1_maxpwr = substr($rowhead['arraypwr'],1,-1);
				$label_maxpwr_calib_0_1 =  substr($rowhead['arraylbl'],1,-1);  
				$freq_ref_0_1=   $rowhead['pwrin'];
			}
			if ($rowhead['bandnuevo'] == 1 && $rowhead['uldl']==0)
			{
				$iduniqueop_band_1_uldl_0_maxpwr = substr($rowhead['arraypwr'],1,-1);
				$label_maxpwr_calib_1_0 =  substr($rowhead['arraylbl'],1,-1);  
				$freq_ref_1_0=   $rowhead['pwrin'];
			}
			if ($rowhead['bandnuevo'] == 1 && $rowhead['uldl']==1)
			{
				$iduniqueop_band_1_uldl_1_maxpwr = substr($rowhead['arraypwr'],1	,-1);
				$label_maxpwr_calib_1_1 =  substr($rowhead['arraylbl'],1,-1); 
				$freq_ref_1_1=   $rowhead['pwrin']; 
			}
		 
	}
//////////////////////// FIN  Calibration_EQ_Calibration_Tx //////////////////////////////////
echo(json_encode(["freq_ref_0_0"=>$freq_ref_0_0,"freq_ref_0_1"=>$freq_ref_0_1,"freq_ref_1_0"=>$freq_ref_1_0,"freq_ref_1_1"=>$freq_ref_1_1,"label_maxpwr_calib_0_0"=>$label_maxpwr_calib_0_0,"label_maxpwr_calib_0_1"=>$label_maxpwr_calib_0_1,"label_maxpwr_calib_1_0"=>$label_maxpwr_calib_1_0,"label_maxpwr_calib_1_1"=>$label_maxpwr_calib_1_1,"iduniqueop_band_0_uldl_0_maxpwr"=>$iduniqueop_band_0_uldl_0_maxpwr,"iduniqueop_band_0_uldl_1_maxpwr"=>$iduniqueop_band_0_uldl_1_maxpwr,"iduniqueop_band_1_uldl_0_maxpwr"=>$iduniqueop_band_1_uldl_0_maxpwr,"iduniqueop_band_1_uldl_1_maxpwr"=>$iduniqueop_band_1_uldl_1_maxpwr ]));
 
?>
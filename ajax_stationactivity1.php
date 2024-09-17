<?php
 include("db_conect.php"); 
	
	header('Content-Type: application/json');
$array = array();	

$fb= $_POST['fb'];
$wk= $_POST['wk'];
$us = $_POST['us'];
$idscrptp = $_POST['idscrptp'];
$lainstancia= $_POST['lains'];
$where1="";
$where1a="";
if ($wk=="na")
{
	$where1="";
}
else
{
	$where1=" and  extract(week from dateserver::date) =".$wk;
	$where1a=" and  extract(week from datetime::date) =".$wk;
}

if ($us=="na")
{
	$where2="";
}
else
{
	$where2=" and  userruninfo ='".$us."' ";
}
if ($wk =="na")
	{
		$query_lista = "	select distinct    	 uldl,band ,   min( round( CAST(v_double as numeric),2)) elmin, max( round( CAST(v_double as numeric),2)) as elmax
				
		, array_agg(  round( CAST(v_double as numeric),2)  ) as outcome24
				from 
				(
					
					select distinct  userruninfo, runinfodb.station, to_char(dateserver, 'YYYY-MM-DD') as diarun ,	 fas_tree_measure2.uldl,fas_tree_measure2.band, v_double   
	
					from fas_routines_product_sn
					inner join runinfodb
					on fas_routines_product_sn.idruninfo = runinfodb.idruninfo 
					inner join fas_calibration_result
					on fas_calibration_result.idruninfo = fas_routines_product_sn.idruninfo and
					fas_calibration_result.unitsn = fas_routines_product_sn.sn  
					inner join (
					select   * from fnt_select_allfas_tree_measure_maxrev2() where iduniquebranch = '".$lainstancia."'
					and datetime  > NOW() - INTERVAL '16 DAY' ".$where1a."
					) as   fas_tree_measure2
					on 
					fas_tree_measure2.unitsn = fas_calibration_result.unitsn and
					fas_tree_measure2.idrununfo =  fas_calibration_result.idruninfo and
					fas_tree_measure2.iduniquebranch = '".$lainstancia."'
					inner join fas_outcome
					on fas_outcome.iduniqueop 	= fas_tree_measure2.iduniqueop
					AND idscriptoutcometype = ".$idscrptp."
					where dateserver  > NOW() - INTERVAL '15 DAY' ".$where1.$where2."
					 
					 order by diarun,userruninfo
				) as tt
				 group by   uldl,band
				 order by  uldl,band   desc 
					";
	}
	else
	{
		if ($fb =="na")
		{
			$query_lista = "	select distinct    	 uldl,band ,   min( round( CAST(v_double as numeric),2)) elmin, max( round( CAST(v_double as numeric),2)) as elmax
				
			, array_agg(  round( CAST(v_double as numeric),2)  ) as outcome24
					from 
					(
						
						select distinct  userruninfo, runinfodb.station, to_char(dateserver, 'YYYY-MM-DD') as diarun ,	 fas_tree_measure2.uldl,fas_tree_measure2.band, v_double   
		
						from fas_routines_product_sn
						inner join runinfodb
						on fas_routines_product_sn.idruninfo = runinfodb.idruninfo 
						inner join fas_calibration_result
						on fas_calibration_result.idruninfo = fas_routines_product_sn.idruninfo and
						fas_calibration_result.unitsn = fas_routines_product_sn.sn  
						inner join (
						select   * from fnt_select_allfas_tree_measure_maxrev2xweek(".$wk.") where iduniquebranch = '".$lainstancia."'
						and datetime  > NOW() - INTERVAL '16 DAY' ".$where1a."
						) as   fas_tree_measure2
						on 
						fas_tree_measure2.unitsn = fas_calibration_result.unitsn and
						fas_tree_measure2.idrununfo =  fas_calibration_result.idruninfo and
						fas_tree_measure2.iduniquebranch = '".$lainstancia."'
						inner join fas_outcome
						on fas_outcome.iduniqueop 	= fas_tree_measure2.iduniqueop
						AND idscriptoutcometype = ".$idscrptp."
						where dateserver  > NOW() - INTERVAL '15 DAY' ".$where1.$where2."
						 
						 order by diarun,userruninfo
					) as tt
					 group by   uldl,band
					 order by  uldl,band   desc 
						";
		
		}
		else
		{
			$query_lista = "	select distinct  diarun,  	 uldl,band,  min( round( CAST(v_double as numeric),2)) elmin, max( round( CAST(v_double as numeric),2)) as elmax
				
			, array_agg(  round( CAST(v_double as numeric),2)  ) as outcome24
					from 
					(
						
						select distinct  userruninfo, runinfodb.station, to_char(dateserver, 'YYYY-MM-DD') as diarun ,	 fas_tree_measure2.uldl,fas_tree_measure2.band, v_double   
		
						from fas_routines_product_sn
						inner join runinfodb
						on fas_routines_product_sn.idruninfo = runinfodb.idruninfo 
						inner join fas_calibration_result
						on fas_calibration_result.idruninfo = fas_routines_product_sn.idruninfo and
						fas_calibration_result.unitsn = fas_routines_product_sn.sn  
						inner join (
						select   * from fnt_select_allfas_tree_measure_maxrev2xweek(".$wk.") where iduniquebranch = '".$lainstancia."'
						and datetime  > NOW() - INTERVAL '16 DAY'   ".$where1a."
						) as   fas_tree_measure2
						on 
						fas_tree_measure2.unitsn = fas_calibration_result.unitsn and
						fas_tree_measure2.idrununfo =  fas_calibration_result.idruninfo and
						fas_tree_measure2.iduniquebranch = '".$lainstancia."'
						inner join fas_outcome
						on fas_outcome.iduniqueop 	= fas_tree_measure2.iduniqueop
						AND idscriptoutcometype = ".$idscrptp."
						where dateserver  > NOW() - INTERVAL '15 DAY'  ".$where1."
						
						 
						 order by diarun,userruninfo
					) as tt
			
					 group by diarun,   uldl,band
					 order by  uldl,band   desc 
						";
		
		}
	}

//	---	where diarun  ='".$fb."'

 
//echo $query_lista;
						
						
	$data = $connect->query($query_lista)->fetchAll();	
	$cantidad = 0;
	foreach ($data as $row) {			

		if ($row['diarun']== $fb || $fb=="na")
		{

					//$array['id'] =  $row['iduniquebranch'];
			//$array['name'] = $row['nameidfasstepson'];
			//	$array['icon'] = 'fa fa-inbox';
			//	$array['parent_id'] = $row['idfasstepfather'];
			if($row['band']== 0 && $row['uldl']== 0 )
			{
				$band_0_0 =  substr($row['outcome24'],1,-1); 
				$band_0_0min= $row['elmin'];
				$band_0_0max= $row['elmax'];
			}
			if($row['band']== 0 && $row['uldl']== 1 )
			{
				$band_0_1 =  substr($row['outcome24'],1,-1); 
				$band_0_1min= $row['elmin'];
				$band_0_1max= $row['elmax'];
			}
			if($row['band']== 1 && $row['uldl']== 0 )
			{
				$band_1_0 =  substr($row['outcome24'],1,-1); 
				$band_1_0min= $row['elmin'];
				$band_1_0max= $row['elmax'];
			}
			if($row['band']== 1 && $row['uldl']== 1 )
			{
				$band_1_1 =  substr($row['outcome24'],1,-1); 
				$band_1_1min= $row['elmin'];
				$band_1_1max= $row['elmax'];
			}

		}
	 
		
				
				
						

	 }

	 $array[] = array
						(
						  'band_0_0' => $band_0_0,
						  'band_0_1' => $band_0_1,
						  'band_1_0' =>$band_1_0,
						  'band_1_1' => $band_1_1,
						  'band_0_0min' => $band_0_0min,
						  'band_0_0max' => $band_0_0max,
						  'band_0_1min' => $band_0_1min,
						  'band_0_1max' => $band_0_1max,
						  'band_1_0min' => $band_1_0min,
						  'band_1_0max' => $band_1_0max,
						  'band_1_1min' => $band_1_1min,
						  'band_1_1max' => $band_1_1max
						 
						);
	$resul =  $array;
	

	 
echo(json_encode($resul));

?>
<?php
 include("db_conect.php"); 
	
	header('Content-Type: application/json');
$array = array();	

$iddigb = $_REQUEST['iddigb'];
$instan = $_REQUEST['instan'];

	$query_lista = "   select band,uldl, 
 
	array_to_json(array_agg(  freq)) as arrayfreq, 
	
	array_to_json(array_agg(  gainnoagc)) as arraygainnoagc 
from fas_tree_measure
	inner join fas_calibration_result
	on fas_calibration_result.unitsn = fas_tree_measure.unitsn and   fas_calibration_result.totalpass =true    and
	fas_tree_measure.totalpass=true  
and  (fas_tree_measure.unitsn like '20%' or fas_tree_measure.unitsn like '21%' or fas_tree_measure.unitsn like '%SP' )
						and fas_tree_measure.unitsn not like '000%'
	inner join  
	(
					select fas_tree_measure.unitsn, idrununfo 
					from fas_tree_measure
					inner join  
					(
					select modelciu, fas_tree_measure.unitsn, max(datetime) as maxdatetime
					from fas_tree_measure
					inner join fas_calibration_result
					on fas_calibration_result.unitsn = fas_tree_measure.unitsn 
					where fas_calibration_result.totalpass =true and  
					fas_tree_measure.totalpass=true and
					modelciu = '".$iddigb."' and iduniquebranch= '".$instan."'
					and  (fas_tree_measure.unitsn like '20%' or fas_tree_measure.unitsn like '21%' or fas_tree_measure.unitsn like '%SP' )
						and fas_tree_measure.unitsn not like '000%'  and datetime > '2021/03/24'
					group by modelciu , fas_tree_measure.unitsn
					) as lasmaxfechaxsn
					on  lasmaxfechaxsn.unitsn      = fas_tree_measure.unitsn and 
					lasmaxfechaxsn.maxdatetime = fas_tree_measure.datetime 
		
	) as lasmaxfechaxsn
	on  lasmaxfechaxsn.unitsn      = fas_tree_measure.unitsn and 
		lasmaxfechaxsn.idrununfo = fas_tree_measure.idrununfo 
	inner join fas_singlemeasures
	on fas_singlemeasures.iduniqueop = fas_tree_measure.iduniqueop
	where     fas_calibration_result.totalpass =true    and iduniquebranch= '".$instan."' and
	fas_tree_measure.totalpass=true 
		group by band , uldl	
	order by band , uldl
	
	";


						
						
	$data = $connect->query($query_lista)->fetchAll();	
	foreach ($data as $row) {			
				//$array['id'] =  $row['iduniquebranch'];
			//$array['name'] = $row['nameidfasstepson'];
			//	$array['icon'] = 'fa fa-inbox';
			//	$array['parent_id'] = $row['idfasstepfather'];
			 
			if ($row['band'] ==0 && $row['uldl']==0)
			{
				$losdatos_0_0_datosx  =  $row['arrayfreq'];
				$losdatos_0_0_datosy  =  $row['arraygainnoagc'];
			}	
			if ($row['band'] ==0 && $row['uldl']==1)
			{
				$losdatos_0_1_datosx  =  $row['arrayfreq'];
				$losdatos_0_1_datosy  =  $row['arraygainnoagc'];
			}	
			if ($row['band'] ==1 && $row['uldl']==0)
			{
				$losdatos_1_0_datosx  =  $row['arrayfreq'];
				$losdatos_1_0_datosy  =  $row['arraygainnoagc'];
			}	
			if ($row['band'] ==1 && $row['uldl']==1)
			{
				$losdatos_1_1_datosx  =  $row['arrayfreq'];
				$losdatos_1_1_datosy  =  $row['arraygainnoagc'];
			}	
			

	 }

	 $array[] = array
	 (
	   'losdatos_0_0_datosx' => $losdatos_0_0_datosx,						
	   'losdatos_0_0_datosy' => $losdatos_0_0_datosy,
		 'losdatos_0_1_datosx' => $losdatos_0_1_datosx,
		 'losdatos_0_1_datosy' => $losdatos_0_1_datosy ,
		 'losdatos_1_0_datosx' => $losdatos_1_0_datosx,						
		 'losdatos_1_0_datosy' => $losdatos_1_0_datosy,
		   'losdatos_1_1_datosx' => $losdatos_1_1_datosx,
		   'losdatos_1_1_datosy' => $losdatos_1_1_datosy ,
		 'icon'=> 'fa fa-inbox'
	 );
	 

	$resul =  $array;
	

	 
echo(json_encode($resul));

?>
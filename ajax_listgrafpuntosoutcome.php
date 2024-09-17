<?php
 include("db_conect.php"); 
	
	header('Content-Type: application/json');
$array = array();	

$iddigb = $_REQUEST['iddigb'];
$instan = $_REQUEST['instan'];
$idtype = $_REQUEST['idtype'];

	$query_lista = "  select band,uldl,
	array_to_json(array_agg(  v_double)) as arrayv_double
	
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
					modelciu = '".$iddigb."' and 						 
						iduniquebranch= '".$instan."'
			 
					group by modelciu , fas_tree_measure.unitsn
					) as lasmaxfechaxsn
					on  lasmaxfechaxsn.unitsn      = fas_tree_measure.unitsn and 
					lasmaxfechaxsn.maxdatetime = fas_tree_measure.datetime 
		
	) as lasmaxfechaxsn
	on  lasmaxfechaxsn.unitsn      = fas_tree_measure.unitsn and 
		lasmaxfechaxsn.idrununfo = fas_tree_measure.idrununfo 
	inner join fas_outcome
	on fas_outcome.iduniqueop = fas_tree_measure.iduniqueop  and 
	idscriptoutcometype = ".$idtype."
	where     fas_calibration_result.totalpass =true    and iduniquebranch= '".$instan."' and
	fas_tree_measure.totalpass=true 
 group by band,uldl
	
	";


				echo $query_lista;		
						
	$data = $connect->query($query_lista)->fetchAll();	
	foreach ($data as $row) {			
				//$array['id'] =  $row['iduniquebranch'];
			//$array['name'] = $row['nameidfasstepson'];
			//	$array['icon'] = 'fa fa-inbox';
			//	$array['parent_id'] = $row['idfasstepfather'];
			 
			if ($row['band'] ==0 && $row['uldl']==0)
			{
				$losdatos_0_0_datosx  =  $row['arrayv_double'];
				$losdatos_0_0_datosy  =  $row['arrayv_double'];
			}	
			if ($row['band'] ==0 && $row['uldl']==1)
			{
				$losdatos_0_1_datosx  =  $row['arrayv_double'];
				$losdatos_0_1_datosy  =  $row['arrayv_double'];
			}	
			if ($row['band'] ==1 && $row['uldl']==0)
			{
				$losdatos_1_0_datosx  =  $row['arrayv_double'];
				$losdatos_1_0_datosy  =  $row['arrayv_double'];
			}	
			if ($row['band'] ==1 && $row['uldl']==1)
			{
				$losdatos_1_1_datosx  =  $row['arrayv_double'];
				$losdatos_1_1_datosy  =  $row['arrayv_double'];
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
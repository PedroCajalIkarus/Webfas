<?php
 include("db_conect.php"); 
	
	header('Content-Type: application/json');
$array = array();	

	$query_lista = "select array_to_json(array_agg(arrleveloffset)) as rearrleveloffset, 
	array_to_json(array_agg(arrsqoffset)) as rearrsqoffset, 
	array_to_json(array_agg(arrgainoffset)) as rearrgainoffset, 
	array_to_json(array_agg(unitsn)) as resusn ,
	array_to_json(array_agg(arrpoweroffset)) as rearrpoweroffset

	from (
	select unitsn ,  concat(CAST(leveloffset as  character varying), '#' ,  CAST(positionmm  as character varying) )  as arrleveloffset ,
	concat(CAST(sqoffset as  character varying), '#' ,  CAST(positionmm  as character varying) )  as arrsqoffset ,
	concat(CAST(gainoffset as  character varying), '#' ,  CAST(positionmm  as character varying) )  as arrgainoffset ,
	concat(CAST(poweroffset as  character varying), '#' ,  CAST(positionmm  as character varying) )  as arrpoweroffset 


	from
	(
							select row_number() OVER(ORDER BY fas_tree_measure.unitsn DESC) AS positionmm, fas_tree_measure.unitsn ,  fas_tree_measure.iduniqueop
						 from fas_tree_measure
						inner join (
						select distinct unitsn,  max(datetime) as maxfechaxsn  from fas_tree_measure where iduniquebranch = '001004015'
						and  unitsn  <> '' and unitsn not like '%DV'
						group by unitsn
						) as losmaxsn
						on  losmaxsn.unitsn  = fas_tree_measure.unitsn and
					
						losmaxsn.maxfechaxsn = fas_tree_measure.datetime
						inner join fas_calibration_result
						on fas_calibration_result.unitsn = fas_tree_measure.unitsn 
						and fas_calibration_result.idruninfo = fas_tree_measure.idrununfo	
		) as todos
		inner join fas_lsgp
		on fas_lsgp.iduniqueop = todos.iduniqueop
		
				) as sss
				
				";


						
						
	$data = $connect->query($query_lista)->fetchAll();	
	foreach ($data as $row) {			
				//$array['id'] =  $row['iduniquebranch'];
			//$array['name'] = $row['nameidfasstepson'];
			//	$array['icon'] = 'fa fa-inbox';
			//	$array['parent_id'] = $row['idfasstepfather'];
				
				$array[] = array
						(
						  'rearrleveloffset' => $row['rearrleveloffset'],
						  'rearrsqoffset' => $row['rearrsqoffset'],
						  'rearrgainoffset' => $row['rearrgainoffset'],
						  'rearrpoweroffset' => $row['rearrpoweroffset'],
						  'resusn' => $row['resusn'], 
							'icon'=> 'fa fa-inbox'
						);
						

	 }
	$resul =  $array;
	

	 
echo(json_encode($resul));

?>
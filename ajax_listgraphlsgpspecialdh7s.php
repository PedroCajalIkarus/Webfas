<?php
 include("db_conect.php"); 
	
	header('Content-Type: application/json');
$array = array();	

	$query_lista = " 
	select outcomedescription,band, uldl, array_to_json(array_agg( distinct array_v_double)) as array_v_double 
		from (
		select distinct fas_outcome_type.outcomedescription,band, uldl, modelciu,   
		 concat(  CAST(v_double as  character varying), '#' ,  CAST(positionmm  as character varying) )  as array_v_double
	 
		from
		(
			 
								select distinct  row_number() OVER(ORDER BY fas_tree_measure.unitsn DESC) AS positionmm, fas_tree_measure.unitsn ,  fas_tree_measure.iduniqueop, fas_tree_measure.band,
								fas_tree_measure.uldl,
								fas_calibration_result.modelciu
							 from fas_tree_measure
							inner join (
										select fas_tree_measure.unitsn	,idrununfo
										from fas_tree_measure
										inner join
										(
											select distinct unitsn,  max(datetime) as maxfechaxsn  from fas_tree_measure where iduniquebranch = '002007013'
												and  unitsn  <> '' and unitsn not like '%DV'  and totalpass= true
												group by unitsn
										) as losmaxsnfecha
										on  losmaxsnfecha.unitsn      =  fas_tree_measure.unitsn and
										losmaxsnfecha.maxfechaxsn =  fas_tree_measure.datetime  
										
								
								
							) as losmaxsn
							on  losmaxsn.unitsn  = fas_tree_measure.unitsn and
								fas_tree_measure.totalpass= true and 
							losmaxsn.idrununfo = fas_tree_measure.idrununfo
							left join fas_calibration_result
							on fas_calibration_result.unitsn = fas_tree_measure.unitsn 
							and fas_calibration_result.idruninfo = fas_tree_measure.idrununfo	and
							fas_calibration_result.totalpass= true
							left join products 
							on  products.modelciu = fas_calibration_result.modelciu and 
								 products.idproduct in (select idproduct from products_attributes where idattribute = 0 )
						 where 	fas_calibration_result.modelciu in ('DH7S-A','DH7S-D')
							and fas_tree_measure.unitsn = '22044017FU'
			order by positionmm
			
			
			) as todos
			inner join fas_outcome
			on fas_outcome.iduniqueop = todos.iduniqueop
			 inner join fas_outcome_type
			on fas_outcome_type.idscriptoutcometype = fas_outcome.idscriptoutcometype
			where fas_outcome.idscriptoutcometype in (24,25,26,27,28,29,30,31)
		) as ffftodos
			group by  	outcomedescription,band, uldl
			order by  outcomedescription,band, uldl
				
				";

$query_lista=" 	select outcomedescription,band, uldl, array_to_json(array_agg( distinct array_v_double)) as array_v_double 
from (

select distinct  outcomedescription,band, uldl, modelciu,   
 concat(  CAST(array_v_double as  character varying), '#' ,  CAST(  row_number() OVER(ORDER BY outcomedescription DESC)   as character varying) )  as array_v_double

from
(
  
select distinct  fas_outcome_type.outcomedescription,band, uldl, modelciu,   
  CAST(v_double as  character varying)   as array_v_double

from
(
	select distinct  fas_tree_measure.unitsn ,  fas_tree_measure.iduniqueop, fas_tree_measure.band,
						fas_tree_measure.uldl,
						fas_calibration_result.modelciu
					 from fas_tree_measure
					inner join (
								select fas_tree_measure.unitsn	,idrununfo
								from fas_tree_measure
								inner join
								(
									select distinct unitsn,  max(datetime) as maxfechaxsn  from fas_tree_measure where iduniquebranch = '002007013'
										and  unitsn  <> '' and unitsn not like '%DV'  and totalpass= true
										group by unitsn
								) as losmaxsnfecha
								on  losmaxsnfecha.unitsn      =  fas_tree_measure.unitsn and
								losmaxsnfecha.maxfechaxsn =  fas_tree_measure.datetime  
								
						
						
					) as losmaxsn
					on  losmaxsn.unitsn  = fas_tree_measure.unitsn and
						fas_tree_measure.totalpass= true and 
					losmaxsn.idrununfo = fas_tree_measure.idrununfo
					left join fas_calibration_result
					on fas_calibration_result.unitsn = fas_tree_measure.unitsn 
					and fas_calibration_result.idruninfo = fas_tree_measure.idrununfo	and
					fas_calibration_result.totalpass= true
					left join products 
					on  products.modelciu = fas_calibration_result.modelciu and 
						 products.idproduct in (select idproduct from products_attributes where idattribute = 0 )
				 where 	fas_calibration_result.modelciu in ('DH7S-A','DH7S-D')
			 
	
		) as todos
	inner join fas_outcome
	on fas_outcome.iduniqueop = todos.iduniqueop
	 inner join fas_outcome_type
	on fas_outcome_type.idscriptoutcometype = fas_outcome.idscriptoutcometype
	where fas_outcome.idscriptoutcometype in (24,25,26,27,28,29,30,31)
	) as final
		) as final2
			group by  	outcomedescription,band, uldl
	order by  outcomedescription,band, uldl";
						
						
	$data = $connect->query($query_lista)->fetchAll();	
	foreach ($data as $row) {			
				//$array['id'] =  $row['iduniquebranch'];
			//$array['name'] = $row['nameidfasstepson'];
			//	$array['icon'] = 'fa fa-inbox';
			//	$array['parent_id'] = $row['idfasstepfather'];
			/////24,25,26,27,28,29,30,31
				
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
	

	 
echo(json_encode($data));

?>
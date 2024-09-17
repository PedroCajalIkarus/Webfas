<?php
 include("db_conect.php"); 
	
	header('Content-Type: application/json');
$array = array();	

	$query_lista = "select  array_to_json(array_agg(sn)) as resusn,
	array_to_json(array_agg(armovoltage)) as resuvolt, 
	array_to_json(array_agg(armocurrent)) as resucurrent, 
	array_to_json(array_agg(armotemp)) as resutemp, 
	array_to_json(array_agg(armotx)) as resutx, 
	array_to_json(array_agg(armorx)) as resurx, 
	array_to_json(array_agg(armotempdib)) as resutempdib
   from 
   (
   select sn, 
   concat(CAST(avgvoltaje as  character varying), '#' ,  CAST(positionmm  as character varying) )  as armovoltage, 
   concat(CAST(avgcurrent as  character varying), '#' ,  CAST(positionmm  as character varying) )  as armocurrent, 
   concat(CAST(avgtemp as  character varying), '#' ,  CAST(positionmm  as character varying) )  as armotemp,
   concat(CAST(avgtx as  character varying), '#' ,  CAST(positionmm  as character varying) )  as armotx,
   concat(CAST(avgrx as  character varying), '#' ,  CAST(positionmm  as character varying) )  as armorx,
   concat(CAST(avgtempdib as  character varying), '#' ,  CAST(positionmm  as character varying) )  as armotempdib
   ------,array_agg(avgtx), array_agg(avgrx), array_agg(avgtempdib)
   from(	
   select row_number() OVER(ORDER BY sn DESC) AS positionmm , sn, AVG(voltage) as avgvoltaje ,AVG(current) as avgcurrent ,AVG(temperature) as avgtemp,
	   AVG(txpower) as avgtx ,AVG(rxpower) as avgrx, 
	   AVG( (temperature -temperaturedib)) as avgtempdib from fas_fiberopticcheck WHERE sn not like 'P%' 
	   and rxpower >-11
   group by sn 
   order by sn) as fff
	   ) as ccz";


						
						
	$data = $connect->query($query_lista)->fetchAll();	
	foreach ($data as $row) {			
				//$array['id'] =  $row['iduniquebranch'];
			//$array['name'] = $row['nameidfasstepson'];
			//	$array['icon'] = 'fa fa-inbox';
			//	$array['parent_id'] = $row['idfasstepfather'];
				
				$array[] = array
						(
						  'resusn' => $row['resusn'],						
						  'resuvolt' => $row['resuvolt'],
							'resucurrent' => $row['resucurrent'],
							'resutemp' => $row['resutemp'],
							'resutx' => $row['resutx'],
							'resurx' => $row['resurx'],
							'resutempdib' => $row['resutempdib'],
							'icon'=> 'fa fa-inbox'
						);
						

	 }
	$resul =  $array;
	

	 
echo(json_encode($resul));

?>
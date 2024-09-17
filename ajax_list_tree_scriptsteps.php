<?php
 include("db_conect.php"); 
	
	header('Content-Type: application/json');
$array = array();	

$idbu = "9999";
$nmbu = $_REQUEST['nmbu'];
	$query_lista = "
	select distinct 9999 as idcategory, concat(idscript::text) as idtype,  scriptname  as description
	from fas_routines_process
	inner join fas_script_type
	on fas_script_type.idscripttype = fas_routines_process.idscript
	union
	select distinct idscript,  concat('0',idstep::text) ,  description 
	
	 
	from fas_routines_process
	inner join fas_script_type
	on fas_script_type.idscripttype = fas_routines_process.idscript
	inner join fas_step
	on fas_step.idfasstep = fas_routines_process.idstep
	";


$nombrecabezaarbol = ' Script Step';
$nombrearbol  ="a".$idbu;
$array[] = array
						(
						  'id' => $nombrearbol,						
						  'parent' => "#",
						    'text' => $nombrecabezaarbol
						);
						
						
	$data = $connect->query($query_lista)->fetchAll();	
	foreach ($data as $row) {			
				//$array['id'] =  $row['iduniquebranch'];
			//$array['name'] = $row['nameidfasstepson'];
			//	$array['icon'] = 'fa fa-inbox';
			//	$array['parent_id'] = $row['idfasstepfather'];
				
		
						

						$nuevonombre = explode("#", $row['description']);
						///		echo "cant".count($nuevonombre)."---".$row['description'];
								$txtnombre="";
								 
									$txtnombre=$row['description'];
							 
									
									$array[] = array
											(
											  'id' => "a".$row['idtype'],						
											  'parent' => "a".$row['idcategory'],
												'text' => $txtnombre,
												'icon'=> 'fa fa-inbox'
											);
											

	 }
	$resul =  $array;
	
	 /////////////////////////////////////////////////////

	 
echo(json_encode($resul));

?>
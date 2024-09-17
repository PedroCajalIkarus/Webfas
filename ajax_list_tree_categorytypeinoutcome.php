<?php
 include("db_conect.php"); 
	
	header('Content-Type: application/json');
$array = array();	

$idbu = "9999";
$nmbu = $_REQUEST['nmbu'];
	$query_lista = "select distinct 1 as orderbymm, 9999 as idcategory,concat(fas_outcome_category.idcategory::text) as idtype,  nameoutcomecat  as description
	from fas_outcome_category	
	inner join fas_outcome_category_type
	on fas_outcome_category_type.idfasoutcomecat = fas_outcome_category.idcategory
 
	union 
	 
	select distinct 2, idcategory, concat('0',idtype::text),  fasoutcometypename as description
	from fas_outcome_category	
	inner join fas_outcome_category_type
	on fas_outcome_category_type.idfasoutcomecat = fas_outcome_category.idcategory
 
	order by  orderbymm,  description";


$nombrecabezaarbol = ' Category Type';
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
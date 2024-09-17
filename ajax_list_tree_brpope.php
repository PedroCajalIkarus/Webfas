<?php
 include("db_conect.php"); 
	
	header('Content-Type: application/json');
$array = array();	
$idbu = $_REQUEST['idbu'];
$nmbu = $_REQUEST['nmbu'];

	$query_lista = "select * from sap_operations order by descripoperation ";

 
$nombrecabezaarbol = $nmbu.' BRP Operations';
$nombrearbol  ="a000".$idbu;

$array[] = array
						(
						    'id' => $nombrearbol,						
						  'parent' => "#",
						    'text' => $nombrecabezaarbol
						);
						
						
	$data = $connect->query($query_lista)->fetchAll();	
	foreach ($data as $row) {			
		 
				$txtnombre=$row['nameoperation'];
		 
				
				$array[] = array
						(
						  'id' => "a".$row['idoperation'],						
						  'parent' => "a000",
						    'text' => $txtnombre,
							'icon'=> 'fa fa-inbox'
						);
						

	 }
	$resul =  $array;
	
	 ///////////////////////////////////////////////////// 
	 
echo(json_encode($resul));

?>
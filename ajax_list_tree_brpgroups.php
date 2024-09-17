<?php
 include("db_conect.php"); 
	
	header('Content-Type: application/json');
$array = array();	
$idbu = $_REQUEST['idbu'];
$nmbu = $_REQUEST['nmbu'];

	$query_lista = "select distinct idbrpgroup from sap_brp_operations order by idbrpgroup ";

 
$nombrecabezaarbol = $nmbu.' BRP Groups';
$nombrearbol  ="a000".$idbu;

$array[] = array
						(
						    'id' => $nombrearbol,						
						  'parent' => "#",
						    'text' => $nombrecabezaarbol
						);
						
						
	$data = $connect->query($query_lista)->fetchAll();	
	foreach ($data as $row) {			
		 
				$txtnombre=$row['idbrpgroup'];
		 
				
				$array[] = array
						(
						  'id' => "a".$row['idbrpgroup'],						
						  'parent' => "a000",
						    'text' => $txtnombre,
							'icon'=> 'fa fa-inbox'
						);
						

	 }
	$resul =  $array;
	
	 ///////////////////////////////////////////////////// 
	 
echo(json_encode($resul));

?>
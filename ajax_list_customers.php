<?php
 include("db_conect.php"); 
	include("funcionesstores.php"); 
	//header('Content-Type: application/json');
	
	$palabra_a_buscar = $_REQUEST['query'];
	$query_lista = list_all_customers($palabra_a_buscar);
    $return_arr = array();
 	
	
	
	$data = $connect->query($query_lista)->fetchAll();	
	foreach ($data as $row) {			
	//	array_push($return_arr,  $row[0]);		
		$return_arr[] = array("id" => $row[0], "name" => $row[1]);		
	 }
	 /////////////////////////////////////////////////////
	 



 echo(json_encode($return_arr));

 /*
echo json_encode(array(
    array(
        "name"          => "Ducks",
        "img"           => "ducks",
        "city"          => "Anaheim",
        "id"            => "ANA",
        "conference"    => "Western",
        "division"      => "Pacific"
    ),
    array(
        "name"          => "Thrashers",
        "img"           => "thrashers",
        "city"          => "Atlanta",
        "id"            => "ATL",
        "conference"    => "Eastern",
        "division"      => "Southeast"
    )
 ));
 */
?>
<?php
 include("db_conect.php"); 
	 
	header('Content-Type: application/json');
	$query_lista ="select * from idband";
    $return_arr = array();
 
 	$return_arr_ul = array();
	$return_arr_made = array();
	$return_arr_flia = array();
	$return_arr_fcc = array();
	$return_arr_ic = array();
	$return_arr_etsi = array();
	
 	$letrasbuscadas = array("/", ".", ",", "-", );
	
 
	$data = $connect->query($query_lista)->fetchAll();	
	foreach ($data as $row) {			
		array_push($return_arr,  $row);					
	 }
	
	 /////////////////////////////////////////////////////
	 
	
	
	//print_r($return_arr);				
    //echo json_encode($return_arr);
 
 


 echo(json_encode(["thebands"=>$return_arr]));

?>
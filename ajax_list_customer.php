<?php
 include("db_conect.php"); 
	include("funcionesstores.php"); 
	header('Content-Type: application/json');
	$query_lista = list_all_values_from_table('products_labeling','ciu');
    $return_arr = array();
 
 	$return_arr_ul = array();
	$return_arr_made = array();
	$return_arr_flia = array();
	$return_arr_fcc = array();
	$return_arr_ic = array();
	$return_arr_etsi = array();
	
 	$letrasbuscadas = array("/", ".", ",", "-", );
	
	$query_lista = "select distinct namecustomers from customers order by namecustomers asc";;
	$data = $connect->query($query_lista)->fetchAll();	
	foreach ($data as $row) {			
		array_push($return_arr,  $row[0]);					
	 }
	
	 /////////////////////////////////////////////////////
	 
	
	
	//print_r($return_arr);				
    //echo json_encode($return_arr);
 
 


 echo(json_encode(["namecustomers"=>$return_arr]));

?>
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
	
	$query_lista = list_all_values_from_table('products_labeling','ciu');
	$data = $connect->query($query_lista)->fetchAll();	
	foreach ($data as $row) {			
		array_push($return_arr,  $row[0]);					
	 }
	 /////////////////////////////////////////////////////
	 $query_lista = list_all_values_from_table('products_labeling','ulpwrrat');
	$data = $connect->query($query_lista)->fetchAll();	
	foreach ($data as $row) {			
		array_push($return_arr_ul,  $row[0]);					
	 }
	 /////////////////////////////////////////////////////
	 $query_lista = list_all_values_from_table('products_labeling','madein');
	$data = $connect->query($query_lista)->fetchAll();	
	foreach ($data as $row) {			
		array_push($return_arr_made,  $row[0]);					
	 }
	 /////////////////////////////////////////////////////
	 $query_lista = list_all_values_from_table('products_labeling','flia');
	$data = $connect->query($query_lista)->fetchAll();	
	foreach ($data as $row) {			
		array_push($return_arr_flia,  $row[0]);					
	 }
	 /////////////////////////////////////////////////////
	 $query_lista = list_all_values_from_table('products_labeling','fcc');
	$data = $connect->query($query_lista)->fetchAll();	
	foreach ($data as $row) {			
		array_push($return_arr_fcc,  $row[0]);					
	 }
	 /////////////////////////////////////////////////////
	 $query_lista = list_all_values_from_table('products_labeling','ic');
	$data = $connect->query($query_lista)->fetchAll();	
	foreach ($data as $row) {			
		array_push($return_arr_ic,  $row[0]);					
	 }
	  $query_lista = list_all_values_from_table('products_labeling','etsi');
	$data = $connect->query($query_lista)->fetchAll();	
	foreach ($data as $row) {			
		array_push($return_arr_etsi,  $row[0]);					
	 }
	 /////////////////////////////////////////////////////
	 
	
	
	//print_r($return_arr);				
    //echo json_encode($return_arr);
 
 


 echo(json_encode(["ciu"=>$return_arr,"ulpwrrat"=>$return_arr_ul, "madein"=>$return_arr_made , "flia"=>$return_arr_flia, "etsi"=>$return_arr_etsi,   "ic"=>$return_arr_ic,"fcc"=>$return_arr_fcc]));

?>
<?php
 include("db_conect.php"); 
  	session_start();
	include("funcionesstores.php"); 
	header('Content-Type: application/json');
	
	
	$vidlabel = $_REQUEST['idlabel'];
	$vlblname = trim($_REQUEST['lblname']);
	$vdataso = trim($_REQUEST['dataso']);
	
	$query_lista = insert_labeling($vidlabel ,$vlblname ,$vdataso );
    $return_arr = array();
  	
	//echo $query_lista;
	//echo "<br>hacemos el Update.".$_SESSION["b"];				
	
	 $connect->query($query_lista);
	$return_arr[] = array("resultado" => "OK");
					
		
	
	
					
 echo json_encode($return_arr);
 
 



?>
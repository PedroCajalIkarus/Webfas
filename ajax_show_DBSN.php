<?php
 include("db_conect.php"); 
	include("funcionesstores.php"); 
	header('Content-Type: application/json');
	$query_lista = list_show_SN_by_CIU($_REQUEST['idtipoclac'],$_REQUEST['dbciu']);
    $return_arr = array();
  //	echo $query_lista;				
	$data = $connect->query($query_lista)->fetchAll();						
	$letrasbuscadas = array("/", ".", ",", "-", );

	foreach ($data as $row) {
		$rowciu_sincaractraros = str_replace($letrasbuscadas, "", $row[0]);
		$return_arr[] = array("sn" => $row[1], "snactive" => $row['active']);
					
		//echo $row[0].",".$row[1];
	 }
	
	
					
 echo json_encode($return_arr);
 
 



?>
<?php
 include("db_conectbypdf.php"); 
 	header('Content-Type: application/json');
	
	$idabuscar = $_REQUEST['id'];
	
	//$query_lista = list_all_cuis($palabra_a_buscar);
    $return_arr = array();
 	$query_lista="select * from fnt_select_allfas_firmwarelist_maxrev() where active = 'Y' and  idfas_firmwarelist = ".$idabuscar;
		
	$data = $connect->query($query_lista)->fetchAll();	
	foreach ($data as $row) {			
	//	array_push($return_arr,  $row[0]);		
		$return_arr[] = array("idfas_firmwarelist" => $row['idfas_firmwarelist'], "namefirmware" => $row['namefirmware'], "fpga_file" => $row['fpga_file'], "micro_file" => $row['micro_file'],"eth_file" => $row['eth_file'],"fpga_fas" => $row['fpga_fas'],"micro_fas" => $row['micro_fas'],"eth_fas" => $row['eth_fas'],"calrstring"=>$row['calrstring']);		
	 }
	 /////////////////////////////////////////////////////
	 


/// echo(json_encode(["gi"=>$return_arr,"gifw"=>$return_arr_fw, "gisn"=>$return_arr_sn , "gilog"=>$return_arr_runinfo, "giciu"=>$return_arr_cius]));
 echo(json_encode(["listfrw"=>$return_arr]));


?>
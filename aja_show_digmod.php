<?php
 include("db_conect.php"); 
	include("funcionesstores.php"); 
	header('Content-Type: application/json');
	$query_lista = list_digmodule($_REQUEST['idsunit'] ,$_REQUEST['iddib_sn_modulo']);
    $return_arr = array();
 //	echo $query_lista;				
	$data = $connect->query($query_lista)->fetchAll();						
	$letrasbuscadas = array("/", ".", ",", "-", );


	$return_arr = array();
	$return_arr_fw = array();
	 $return_arr_sn = array();
	 $return_arr_cius= array();
	 $return_arr_runinfo= array();


	foreach ($data as $row) {
		$rowciu_sincaractraros = str_replace($letrasbuscadas, "", $row[0]);
		$return_arr[] = array(
                    "idit" => "Iteracion: ".$row['idit'],
					"Date" => $row['dateinfo'],
					"timescript" => $row['timescript'] , 
					"userinfo" => $row['userruninfo'],
					"station" => $row['station'],
					"fasversion" => $row['fasver'],
					"totalpass" => $row['totalpass']
				
                    );
				
		$split_fw= explode(" ", $row['fws']);		
		
			$v0_split_fw ="";
		$v1_split_fw ="";
		$v2_split_fw ="";
		
		
		if($split_fw[0]!="null") { $v0_split_fw = $split_fw[0]; }
		if($split_fw[1]!="null") { $v1_split_fw = $split_fw[1]; }
		if($split_fw[2]!="null") { $v2_split_fw = $split_fw[2]; }
	
		
		$return_arr_fw[] = array(
                    "idit" => "Iteracion: ".$row['idit']  ,					
					"fwfpga" => $v0_split_fw ,			
					"fwuc" =>   $v1_split_fw,		
					"fwrabb" => $v2_split_fw		
                    );	
		$split_sn= explode(" ", $row['fws']);		
		$return_arr_sn[] = array(
                    "idit" => "Iteracion: ".$row['idit']  ,					
					"sndb" => $row['sn_module'] , 					
					"snunit" => $row['sn_unit'] 					
                    );			
		$return_arr_cius[] = array(
                    "idit" => "Iteracion: ".$row['idit']  ,					
					"ciudb" => $row['ciu_module'] , 					
					"ciuunit" => $row['ciu_unit'] 					
                    );		

	$return_arr_runinfo[] = array(
                    "idlog" => $row['idruninfo'] 				
                    );		




	 }
	
	
					
 
 echo(json_encode(["gi"=>$return_arr,"gifw"=>$return_arr_fw, "gisn"=>$return_arr_sn , "gilog"=>$return_arr_runinfo, "giciu"=>$return_arr_cius]));




?>
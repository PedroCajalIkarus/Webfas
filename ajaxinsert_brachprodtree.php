<?php
 include("db_conect.php"); 
  	session_start();
	header('Content-Type: application/json');
	

	$v_idempresa = trim($_REQUEST['idbusiness']);
	$v_nodoprodadd = trim($_REQUEST['nodoprodadd']);
	$v_nodobranchadd = trim($_REQUEST['nodobranchadd']);
	
	$nodobranchmove = str_replace("a","",trim($_REQUEST['nodobranchmove']));	  
	
   $v_nodobranchfrom = str_replace("a","",trim($_REQUEST['nodobranchfrom']));	
	$viduser = 	$_SESSION["a"] ;
	
	$array_v_nodoprodadd = explode("#", $v_nodoprodadd);
//echo $array_v_nodoprodadd[0]; // porción1/
//	echo $v_nodobranchadd;
	if ($v_nodobranchadd <>"undefined")
	{
			$query_lista = "call sp_insert_business_branch_tree('".$array_v_nodoprodadd[0]."','".$v_nodobranchfrom."','".$array_v_nodoprodadd[1]."','".$v_idempresa."')";
	}
	else
	{
			$query_lista = "call sp_insert_business_branch_tree('m','".$v_nodobranchfrom."','".$nodobranchmove."','".$v_idempresa."')";
	}	
	

	
echo $query_lista;
	
		 try {
				 
					 $connect->query($query_lista);
					  	$resuljson="ok";
					$return_arr[] = array("resultado" => "ok");
					
					
					/// Fin Aviso Soporte
					
				} 
				catch (PDOException $e) 
				{
				
				$return_arr[] = array("resultado" => "errok");
				$resuljson="error";
				}		
		
	
	
					
 echo json_encode($resuljson);
 
 



?>
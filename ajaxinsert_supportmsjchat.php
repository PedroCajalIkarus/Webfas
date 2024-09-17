<?php
 include("db_conect.php"); 
  	session_start();
	header('Content-Type: application/json');
	
	

	$v_idfas_techsupport = trim($_REQUEST['vidtksuport']);
	$mshchat = trim($_REQUEST['mshchat']);
	
	$viduser = 	$_SESSION["a"] ;
	
	

	
				
			 try {
				 
				 	 	$sqlmaxrev = $connect->prepare("INSERT INTO public.fas_techsupport_messages(idfas_techsupport, datecreate, iduserfrom, iduserto, messagessend, dateread)	VALUES (".$v_idfas_techsupport.", now(), ".$viduser .", null, :mshchat, null); ");
						$sqlmaxrev->bindParam(':mshchat', $mshchat);		
						$sqlmaxrev->execute();
					
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
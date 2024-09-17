<?php
// Desactivar toda notificación de error
error_reporting(0);
 include("db_conect.php"); 
  	session_start();
	include("funcionesstores.php"); 
	header('Content-Type: application/json');
	
	
	$vidlabel = $_REQUEST['idlabel'];
	$vlblname = trim($_REQUEST['lblname']);
	$vdataso = trim($_REQUEST['dataso']);
	
	//$query_lista = update_labeling($vidlabel ,$vlblname ,$vdataso );
	if ($vdataso == "")
	{
		$query_lista="update products_labeling set $vlblname = null where idlabel = ".$vidlabel;		
	}
	else
	{
		$query_lista="update products_labeling set $vlblname = '$vdataso' where idlabel = ".$vidlabel;	
	}
	
    $return_arr = array();
  	
	//echo $query_lista;
	//echo "<br>hacemos el Update.".$_SESSION["b"];				
	
	 $connect->query($query_lista);
	 
	 	$vuserfas = $_SESSION["b"];
						$vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
						$vaccionweb="UPDATE";
						$vdescripaudit=" update products_labeling ";	
						$vtextaudit=$query_lista;
					
						$sentenciaudit = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
								$sentenciaudit->bindParam(':userfas', $vuserfas);								
								$sentenciaudit->bindParam(':menuweb', $vmenufas);
								$sentenciaudit->bindParam(':actionweb', $vaccionweb);
								$sentenciaudit->bindParam(':descripaudit', $vdescripaudit);
								$sentenciaudit->bindParam(':textaudit', $vtextaudit);
								$sentenciaudit->execute();
								
								
	$return_arr[] = array("resultado" => "OK");
					
		
	
	
					
 echo json_encode($return_arr);
 
 



?>
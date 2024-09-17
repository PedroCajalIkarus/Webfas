<?php
// Desactivar toda notificación de error
error_reporting(0);
 include("db_conect.php"); 
  	session_start();
	include("funcionesstores.php"); 
	header('Content-Type: application/json');
	
	
	$vidlabel = $_REQUEST['idcustomers'];
	$vlblname = trim($_REQUEST['lblname']);
	$vdataso = trim($_REQUEST['dataso']);
	
	if ($vlblname =="cliactive")
	{
		$vlblname="active";
	}
	
	if ($vlblname =="vvpersoncontact")
	{
		$vlblname="personcontact";
	}
	if ($vlblname =="vvtelephone")
	{
		$vlblname="telephone";
	}
	if ($vlblname =="vvemailcustom")
	{
		$vlblname="emailcustom";
	}
	if ($vlblname =="vvaddress")
	{
		$vlblname="address";
	}
	
	 $query_lista = "UPDATE public.customers SET ".$vlblname." = '".strtoupper($vdataso)."' WHERE idcustomers =".$vidlabel;
	 
	 
//	echo  $query_lista;
	//$query_lista = update_labeling($vidlabel ,$vlblname ,$vdataso );
    $return_arr = array();
  	
	
	 $connect->query($query_lista);
	 
	 	$vuserfas = $_SESSION["b"];
						$vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
						$vaccionweb="UPDATE";
						$vdescripaudit=" update Customers ";	
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
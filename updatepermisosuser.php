<?php
// Desactivar toda notificación de error
error_reporting(0);
 include("db_conect.php"); 
  	session_start();

	header('Content-Type: application/json');
	

	$vviduser = $_REQUEST['iduser'];
	$vvidmenu = trim($_REQUEST['idmenu']);
	$vvidbusiness = trim($_REQUEST['idb']);
	$vvaccion = trim($_REQUEST['accion']);
	$existemenuusuario = "N";

		if($vvaccion=="true")
		{
			$query_lista = "insert into business_user_menu(	idbusiness, iduserfas, idmenu) VALUES (".$vvidbusiness.", ".$vviduser.", ".$vvidmenu.");" ;
	$vaccionweb="INSERT";
		}
		if($vvaccion=="false")
		{
			$query_lista = "delete from business_user_menu where idbusiness=".$vvidbusiness." and iduserfas=".$vviduser." and idmenu = ".$vvidmenu ;
	$vaccionweb="DELETE";
		}
	
    $return_arr = array();
		
	//echo $query_lista;
		 $sql = $connect->prepare($query_lista);
		$sql->execute();
		

	
	 	$vuserfas = $_SESSION["b"];
						$vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
						
						$vdescripaudit=" update business_user_menu ";	
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
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
			$query_lista = "insert into fas_techsupport_category_byuserfas(	idtechsupport_category, iduserfas, idbusiness) VALUES (".$vvidmenu.", ".$vviduser.", ".$vvidbusiness.");" ;
	$vaccionweb="INSERT";
		}
		if($vvaccion=="false")
		{
			$query_lista = "delete from fas_techsupport_category_byuserfas where idbusiness=".$vvidbusiness." and iduserfas=".$vviduser." and idtechsupport_category = ".$vvidmenu ;
	$vaccionweb="DELETE";
		}
	
    $return_arr = array();
		
	//echo $query_lista;
		 $sql = $connect->prepare($query_lista);
		$sql->execute();
		

	
	 	$vuserfas = $_SESSION["b"];
						$vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
						
						$vdescripaudit=" update fas_techsupport_category_byuserfas ";	
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
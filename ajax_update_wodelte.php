<?php
// Desactivar toda notificación de error
error_reporting(0);
 include("db_conect.php"); 
  	session_start();
	
	header('Content-Type: application/json');
	
	
	$idwoainactiva = trim($_REQUEST['idwo']);
	$return_result_insert="";

			$idcomp_dibidrev = $idcomp_dibidrev + 1;
			 try {
			//	 $sql="delete from ";
				//	$connect->query($sql);
					 $vuserfas = $_SESSION["b"];
						
						$vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
						$vaccionweb="update wo ";
						  
					$sql2="update orders set active ='N' where idorders = ".$idwoainactiva;
					$vdescripaudit="Inactive WO -".$sql2;	
					$vtextaudit = $sql2;
					$connect->query($sql2);
					
							$sentenciaudit = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
								$sentenciaudit->bindParam(':userfas', $vuserfas);								
								$sentenciaudit->bindParam(':menuweb', $vmenufas);
								$sentenciaudit->bindParam(':actionweb', $vaccionweb);
								$sentenciaudit->bindParam(':descripaudit', $vdescripaudit);
								$sentenciaudit->bindParam(':textaudit', $vtextaudit);
								$sentenciaudit->execute();
								
					$return_result_insert="ok";
				} 
				catch (PDOException $e) 
				{
					
					$return_result_insert="error";
					$msjerr= "Syntax Error MM: ".$e->getMessage();
						
					
				}
		
		
	//echo $sql."<br>";
	
 echo(json_encode(["resultiu"=>$return_result_insert,"erromsj"=>$msjerr]));
 



?>
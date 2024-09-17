<?php
error_reporting(0);
  include("db_conect.php");
  	header('Content-Type: application/json');
   $vvidpo = $_REQUEST['idpo'];
   
    $vvidpo = $_REQUEST['idpo'];
	 $vso_soft_external = $_REQUEST['so'];	  
		 $nameapproved = $_SESSION["b"];
		 
		 $vuserfas = $_SESSION["b"];
						
						$vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
						$vaccionweb="update po so";
  
  $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connect->beginTransaction();
		 try {
				  $sql = $connect->prepare("update orders_sn set  typeregister= 'PO' ,nameapproved =:nameapproved , so_soft_external = :so_soft_external  WHERE idorders = :vvidlog  ");
				  $sql->bindParam(':vvidlog', $vvidpo);
				  $sql->bindParam(':so_soft_external', $vso_soft_external);
				  $sql->bindParam(':nameapproved', $nameapproved);
				  
			  	  $sql->execute();
				  $resultado = $sql->fetchAll();
				  
			
				$vuserfas = $_SESSION["b"];
				  $vdescripaudit="orders_sn Update PO y so_soft_external - proceso Lu - user:".$vuserfas;		
								$vtextaudit="update orders_sn set  typeregister= 'PO' ,nameapproved =:nameapproved , so_soft_external = :so_soft_external  WHERE idorders = :vvidlog ";
								$vtextaudit=$vtextaudit."!!so_soft_external:".$vso_soft_external;
								$vtextaudit=$vtextaudit."!!nameapproved:".$nameapproved;
								
							
								
								$sentenciaudit = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
								$sentenciaudit->bindParam(':userfas', $vuserfas);								
								$sentenciaudit->bindParam(':menuweb', $vmenufas);
								$sentenciaudit->bindParam(':actionweb', $vaccionweb);
								$sentenciaudit->bindParam(':descripaudit', $vdescripaudit);
								$sentenciaudit->bindParam(':textaudit', $vtextaudit);
								$sentenciaudit->execute();
				  
				  // Insertamos Estado 
				  
					$return_result_insert="ok"; 
					$msjerr= "";
					$query_lista ="INSERT INTO orders_states(idorders, idstate, datestate)	VALUES (".$vvidpo.", 3, now());";
					 $connect->query($query_lista);
					  $connect->commit();
				} 
				catch (PDOException $e) 
				{
					
					$connect->rollBack();
					$return_result_insert="error".$e->getMessage();
					$msjerr= "Syntax Error MM: ".$e->getMessage();
					echo $msjerr;
					exit();
						
					
				}
		
		
	//echo $sql."<br>";

 echo(json_encode(["result"=>$return_result_insert,"erromsj"=>$msjerr]));
 

?>
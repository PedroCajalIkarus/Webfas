<?php
error_reporting(0);
  include("db_conect.php");
  	header('Content-Type: application/json');
   $vvidpo = $_REQUEST['idwo'];
   
    $vvidpo = $_REQUEST['idwo'];
	
		 $nameapproved = $_SESSION["b"];
		 $vuserfas = $_SESSION["b"];
						
						$vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
						$vaccionweb="update SO ";
  
  $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connect->beginTransaction();
		 try {
			  
				  $sql = $connect->prepare("update orders set active ='N'  WHERE idorders = :vvidlog ");
				   $sql->bindParam(':vvidlog', $vvidpo);
				  
			  	  $sql->execute();
				  
				   $sql = $connect->prepare("update orders_sn set wo_serialnumber = '', availablesn = null  WHERE idorders = :vvidlog ");
				   $sql->bindParam(':vvidlog', $vvidpo);
				  
			  	  $sql->execute();
				  
				  $resultado = $sql->fetchAll();
				  
				  // Insertamos Estado 
				  
				  						$vuserfas = $_SESSION["b"];
							$vdescripaudit="Inactive SO -id:".$vvidpo."  - user:".$vuserfas;		
								$vtextaudit="update orders_sn set wo_serialnumber = '', availablesn = null  WHERE idorders = :vvidlog ";
						
								$vtextaudit=$vtextaudit."!!vvidlog:".$vvidpo;
								
							
								
									$sentenciaudit = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
								$sentenciaudit->bindParam(':userfas', $vuserfas);								
								$sentenciaudit->bindParam(':menuweb', $vmenufas);
								$sentenciaudit->bindParam(':actionweb', $vaccionweb);
								$sentenciaudit->bindParam(':descripaudit', $vdescripaudit);
								$sentenciaudit->bindParam(':textaudit', $vtextaudit);
								$sentenciaudit->execute();
								
				  
					$return_result_insert="ok"; 
					$msjerr= "";
			
					  $connect->commit();
					  
					  /*
					  mandamos aviso.
					  */
					  /// Enviamos Aviso soprote
					include("configsendmail.php"); 
					//Set who the message is to be sent to
						$mail->addAddress('agustin.corigliano@fiplex.com', 'DEVELOPMENT');
								$mail->addBCC('marco.moretti@fiplex.com', 'marco ');
								//$mail->addBCC('agustin.corigliano@fiplex.com', 'Agus');
								$mail->addBCC('leandro.julian@fiplex.com', 'Lea');
		
							  $mail->Subject = "WEBFAS::SO DELETE";
							  $mail->Body = " attention, a saleorders was inactive - IdOrders=  ".$vvidpo;
							//Definimos AltBody por si el destinatario del correo no admite email con formato html 
							  $mail->AltBody = "SO DELETE - IdOrders= ".$vvidpo;
							
							
								$mail->Send();
							
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
<?php
error_reporting(0);
  include("db_conect.php");
  	header('Content-Type: application/json');



	$sanitized_n = filter_var($_REQUEST['snparam'], FILTER_SANITIZE_STRING);
	if (filter_var($sanitized_n, FILTER_SANITIZE_STRING)) {
		$v_sn = $_REQUEST['snparam'];
	}


		 $nameapproved = $_SESSION["b"];
		 $vuserfas = $_SESSION["b"];
						
						$vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
						$vaccionweb="update WO";
  
  $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connect->beginTransaction();
		 try {
			  
				  $sql = $connect->prepare("update orders_sn set availablesn =true  WHERE wo_serialnumber = :vwo_serialnumber and so_soft_external like '%WO%' ");
				   $sql->bindParam(':vwo_serialnumber', $v_sn);
				  
			  	  $sql->execute();
				  
				
				  
				  // Insertamos Estado 
				  
				  						$vuserfas = $_SESSION["b"];
							$vdescripaudit="Enable WO SN:".$v_sn."  - user:".$vuserfas;		
								$vtextaudit="update orders_sn set availablesn =true  WHERE wo_serialnumber = :vwo_serialnumber and so_soft_external like '%WO%' ";
						
								$vtextaudit=$vtextaudit."!!vwo_serialnumber:".$v_sn;
								
							
								
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
					/*	include("configsendmail.php"); 
					//Set who the message is to be sent to
						$mail->addAddress('marco.moretti@fiplex.com', 'DEVELOPMENT');
								$mail->addBCC('marco.moretti@fiplex.com', 'marco ');
							
							  $mail->Subject = "WEBFAS::ENABLED SN";
							  $mail->Body = " attention, ENABLED SN:  ".$v_sn;
							//Definimos AltBody por si el destinatario del correo no admite email con formato html 
							  $mail->AltBody = " ENABLED SN: ".$v_sn;
							
							
								$mail->Send();
								*/
							
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
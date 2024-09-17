<?php
 include("db_conect.php"); 
  	session_start();

	header('Content-Type: application/json');
	
	
	$vvidruninfodb = $_REQUEST['idruninfodb'];
	$vvv_issue = trim($_REQUEST['v_issue']);
	$vv_userreported = trim($_REQUEST['vuser']);
	
	$vidempresa = 	$_SESSION["i"] ;
	$tipoticket =  $_REQUEST['tp']; 
	$datokey =  trim($_REQUEST['keyd']); 

	if ($_REQUEST['tp1']=="")
	{

	}
	else
	{
		$vvv_issue =  trim($vvv_issue." - ".$_REQUEST['tp1']); 
	}
	
	$query_lista = "CALL sp_insert_techsupport(".$vvidruninfodb.",' ".$vvv_issue."','".$vv_userreported."',' ".$datokey."',".$vidempresa.",".$tipoticket.")";
	
	/*
	sp_insert_techsupport(
    v_idruninfo bigint,
    v_issue character varying,
    v_userreported character varying,
    v_keywordref character varying,
    v_idbusiness integer,
    v_idcategory integer)*/
	
 
//	echo $query_lista;
	//echo "<br>hacemos el Update.".$_SESSION["b"];				
	
		
			 try {
				 
					 $connect->query($query_lista);
					  
					$return_arr[] = array("resultado" => "ok");
					
					
					 include("configsendmail.php"); 
					 ///  SMTP-secure.honeywell.com
					//Set who the message is to be sent to
					$mail->addAddress('marco.moretti@fiplex.com', 'marco ');
					$mail->addCC('agustin.corigliano@fiplex.com', 'Agus');
					$mail->addCC('leandro.julian@fiplex.com', 'Agus');

					  //Asignamos asunto y cuerpo del mensaje
					  //El cuerpo del mensaje lo ponemos en formato html, haciendo 
					  //que se vea en negrita
					
							$sql = $connect->prepare("select * from  fas_techsupport where idruninfo = ".$vvidruninfodb." order by datereported asc limit 1");
								$sql->execute();
							$resultadostock = $sql->fetchAll();
								 foreach ($resultadostock as $rowstock) 
								{			
									  $vvidtksupport =  $rowstock['idfas_techsupport'];
										
								}
 
					if ($vvidruninfodb>0)
					{
								  $sql = $connect->prepare("select * from  runinfodb where idruninfodb = ".$vvidruninfodb);
								  
							//	$sql->bindParam(':vvidpresales', $vvidpo);
								$sql->execute();
								$resultadostock = $sql->fetchAll();
								 foreach ($resultadostock as $rowstock) 
								{			
									  $vvloginfo =  $rowstock['loginfo'];
										
								}
								$porciones = explode("\n", $vvloginfo);
								foreach ($porciones as &$valor) 
								{
									$pos =substr_count($valor, '###');
										
										//$pos2 = strstr($valor, '$$$',true);
										$pos2 =substr_count($valor, '$$$');	
										
										//	if ($pos =="" &&  $pos2 =="" )	
											//if ($pos ==0 &&  $pos2 ==0 )							
											//	{					
												$posbr = 	strstr($valor, '<br>',true);
												if ($posbr =="")
												{							
													$vmostrar = $vmostrar." ".$valor."<br>";
												}
												else
												{						
													$vmostrar = $vmostrar." ".$valor;							
												}						
									
											//} 
								}
					}
		
					  $mail->Subject = "Tech Support::New Ticket #".$vvidtksupport." - IdRunInfo:".$vvidruninfodb." - UserReported:".$vv_userreported;
					  $mail->Body = "<b>New Support Ticket:</b> ".$vvidtksupport."<br><b>UserReported:</b> ".$vv_userreported."<br><b>IdRunInfo:</b> ".$vvidruninfodb."<br><b> Issue:</b> ".$vvv_issue."<br><b>Log:</b><br>".$vmostrar;
                    //Definimos AltBody por si el destinatario del correo no admite email con formato html 
					  $mail->AltBody = "New Support Ticket:".$vvidtksupport." -- From: ".$vv_userreported." -> IdRunInfo:".$vvidruninfodb." - UserReported:".$vv_userreported." -- Issue: ".$vvv_issue."- log".$vmostrar;

						$mail->Send();
					
       
					
					/// Fin Aviso Soporte
					
				} 
				catch (PDOException $e) 
				{
				
				$return_arr[] = array("resultado" => "errok");
				}		
		
	
	
					
 echo json_encode("ok");
 
 



?>
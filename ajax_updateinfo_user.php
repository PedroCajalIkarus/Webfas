<?php
// Desactivar toda notificación de error
error_reporting(0);

	include("db_conect.php"); 
	header('Content-Type: application/json');
		  
	$idcliselect= $_REQUEST['idcliselect'];
	$idcliempreselect= $_REQUEST['idcliempreselect'];	
	$txtupwdmodif= $_REQUEST['v_txtupwd'];
	$txtnameusermodif= $_REQUEST['txtnameusermodif'];
	$txtcategorymodif= $_REQUEST['txtcategorymodif'];
	$txtemailmodif= $_REQUEST['txtemailmodif'];
	$vtxtusernamehideen = $_REQUEST['vtxtusernamehideen']; 
	$qaccionhacer= $_REQUEST['qaccem'];
/*
UPDATE userfas 	SET  userpass=?, active=?, usermail=?, usermobile=?, development=?, nameuserfas=?, userphoto=? 	WHERE iduserfas = 
	*/
if ($qaccionhacer == 1)
{
	$sql = "UPDATE userfas 	SET usermail='".$txtemailmodif."', development='".$txtcategorymodif."', nameuserfas='".$txtnameusermodif."'	WHERE iduserfas = ".$idcliselect;
}
if ($qaccionhacer == 2)
{
	$sql = "UPDATE userfas 	SET userpass =MD5('".$txtupwdmodif."')	WHERE iduserfas = ".$idcliselect;
}
if ($qaccionhacer == 3)
{
	$sql = "UPDATE userfas 	SET userpass =MD5('".$txtupwdmodif."')	WHERE iduserfas = ".$idcliselect;
}
//echo $sql;

			try {
					$connect->query($sql);
								
						$vuserfas = $_SESSION["b"];
						$vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
						$vaccionweb="UPDATE";
						$vdescripaudit="update userfas ";	
						$vtextaudit=$sql." - idbusiness:".$v_txtbusiness;
					
						$sentenciaudit = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
								$sentenciaudit->bindParam(':userfas', $vuserfas);								
								$sentenciaudit->bindParam(':menuweb', $vmenufas);
								$sentenciaudit->bindParam(':actionweb', $vaccionweb);
								$sentenciaudit->bindParam(':descripaudit', $vdescripaudit);
								$sentenciaudit->bindParam(':textaudit', $vtextaudit);
								$sentenciaudit->execute();
								
						//Relacion con la empresa
								
						$return_result_insert="ok";
														
								
				} 
				catch (PDOException $e) 
				{
					
					$return_result_insert="error";
					$msjerr= "Syntax Error MM: ".$e->getMessage();
						
					
				}
	
if ($qaccionhacer == 3)
{
	if ($return_result_insert=="ok")
	{
		
		//mandamos email al usuario
		/// Enviamos email por el modo de petition.. porque el envio comun esta bloqueado.

		/*
							 include("configsendmail.php"); 
					//Set who the message is to be sent to
							$mail->addAddress($txtemailmodif,  $vnombre_dondeavisar);
								$mail->addBCC('marco.moretti@fiplex.com', 'marco ');
								//$mail->addBCC('agustin.corigliano@fiplex.com', 'Agus');
								//$mail->addBCC('leandro.julian@fiplex.com', 'Agus');
		
							  $mail->Subject = "WEBFAS::Password Changed";
							  $mail->Body = " The password for your WEBFAS account on http://webfas.honeywell.com has successfully been changed.<br><br>your user: ".$vtxtusernamehideen ."<br>your new password is: ".$txtupwdmodif."<br><br>If you did not initiate this change, please contact your administrator immediately. ";
							//Definimos AltBody por si el destinatario del correo no admite email con formato html 
							  $mail->AltBody = " The password for your WEBFAS account on http://webfas.honeywell.com has successfully been changed. If you did not initiate this change, please contact your administrator immediately. ";
							
							if ($txtemailmodif <> "")
							{
								$mail->Send();
							}
							*/
							
							$sqlmail = "select * from fnt_sendmail_changepass('".$txtemailmodif."',".$idcliselect.",'".$txtupwdmodif."')";
						 
							$connect->query($sqlmail);



	}
}	
		
 echo(json_encode(["resultiu"=>$return_result_insert,"erromsj"=>$msjerr]));

?>

<?php
error_reporting(0);
 include("db_conect.php"); 
  	session_start();
	header('Content-Type: application/json');
	
	error_reporting(0);
	$vvidruninfodb = $_REQUEST['idruninfodb'];
	if ($vvidruninfodb=="")
	{
		$vvidruninfodb=1;
	}
	$vvv_issue = trim($_REQUEST['v_issue']);
	$vv_userreported = trim($_REQUEST['vuser']);
	
	$vowels = array("'");
	$vvv_issue=str_ireplace("'","*",$vvv_issue);
	
	$vvv_issue = nl2br($vvv_issue);
	
	$vidempresa = 	$_SESSION["i"] ;
	$tipoticket =  $_REQUEST['tp']; 
	$v_idtkreason =  $_REQUEST['txtcmbreason']; 
	//$tipoticket es el tipo de categoria enviada.   idtechsupport_category#iduserfastorepor
	$porciones_typecategory = explode("#", $tipoticket);
	
	$datokey =  trim($_REQUEST['keyd']); 
	//la fecha
	$txtdechadl = trim($_REQUEST['txtdechadl']); 
	if ($txtdechadl=="")
	{
	//	$txtdechadl="now()";
		
		$fecha_actual = date("m/d/Y");
		$txtdechadl = date("m/d/Y",strtotime($fecha_actual."+ 7 days")); 
		 

	}	
	
	$tkkey = trim($_REQUEST['$tkkey']); 
	
	$query_lista = "CALL sp_insert_techsupport_userto(".$vvidruninfodb.",' ".$vvv_issue."','".$vv_userreported."',".$porciones_typecategory[1].",' ".$datokey."',".$vidempresa.",".$porciones_typecategory[0].",".$v_idtkreason.",'".$txtdechadl."')";
  
	/*
sp_insert_techsupport_userto(
	v_idruninfo bigint,
	v_issue character varying,
	v_userreported character varying,
	v_userrto character varying,
	v_keywordref character varying,
	v_idbusiness integer,
	v_idcategory integer)
	*/
 
	//echo $query_lista;
	//echo "<br>hacemos el Update.".$_SESSION["b"];				
			
				///Agregamos la parte de Attach
				 
			if(!empty($_FILES['files'])){
				$n=0;
				$s=0;
				$prepareNames   =   array();
				foreach($_FILES['files']['name'] as $val)
				{
					$infoExt        =   getimagesize($_FILES['files']['tmp_name'][$n]);
					$s++;
					$filesName      =   str_replace(" ","",trim($_FILES['files']['name'][$n]));
					$files          =   explode(".",$filesName);
					$File_Ext       =   substr($_FILES['files']['name'][$n], strrpos($_FILES['files']['name'][$n],'.'));
					 
					if($infoExt['mime'] == 'image/gif' || $infoExt['mime'] == 'image/jpeg' || $infoExt['mime'] == 'image/png')
					{
						$srcPath    =   '/var/www/html/uploadstk/';
						 
						$srcPath = 'C:\laragon\www\uploadstk\\';

						$fileName   =   $s.rand(0,999).time().$File_Ext;
						$path   =   trim($srcPath.$fileName);
						if(move_uploaded_file($_FILES['files']['tmp_name'][$n], $path))
						{
							$prepareNames[] .=  $fileName; //need to be fixed.
							$Sflag      =   1; // success
						}else{
							$Sflag  = 2; // file not move to the destination
						}
					}
					else
					{
						$Sflag  = 3; //extention not valid
					}
					$n++;
				}
			   
			  if($Sflag==1){
				   // echo '{Images uploaded successfully!}';
				}else if($Sflag==2){
					echo '{File not move to the destination.}';
				}else if($Sflag==3){
					echo '{File extention not good. Try with .PNG, .JPEG, .GIF, .JPG}';
				}
			 
				if(!empty($prepareNames)){
					
					
					//// Buscamos el
		
					
					$count  =   0;
					
				//	echo "HOLA".$_REQUEST['tkkey'];
					$vvtkkeymarco= $_REQUEST['tkkey'];
					foreach($prepareNames as $name){
						$data   =   array(
										'img_name'=>$name,
										'img_order'=>$count++,
									);
						//Insertamos relacion TK archivos adjuntamos.
						//echo "INSERT INTO public.fas_techsupport_fileattach(	idfas_techsupport, idnrofile, namefile) VALUES (".$elmaxidtkcreado .", ".$count.", '".$name."');";
								$sqlmaxrev = $connect->prepare("INSERT INTO public.fas_techsupport_fileattach(	idfas_techsupport, idnrofile, namefile) VALUES (0, ".$count.",'".$vvtkkeymarco."_".$name."');");
								///	$sqlmaxrev->bindParam(':mshchat', $mshchat);		
									$sqlmaxrev->execute();
						//fas_techsupport_fileattach
						
						
					}
				}
			}
				/// fin parte de attach
		
	 try {
				 
				 	if(!empty($_REQUEST['keyd']))
					{
					 $connect->query($query_lista);
					 
					 
					 	$vuserfas = $_SESSION["b"];
						$vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
						$vaccionweb="INSERT";
						$vdescripaudit=" INSERT TK STATUS ";	
						$vtextaudit=$query_lista;
					
						$sentenciaudit = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
								$sentenciaudit->bindParam(':userfas', $vuserfas);								
								$sentenciaudit->bindParam(':menuweb', $vmenufas);
								$sentenciaudit->bindParam(':actionweb', $vaccionweb);
								$sentenciaudit->bindParam(':descripaudit', $vdescripaudit);
								$sentenciaudit->bindParam(':textaudit', $vtextaudit);
								$sentenciaudit->execute();	
					 
					 
					 ///Asociamos File Attach al TK 
					
					 	$elmaxidtkcreado = 0;		
						$vv_userreported = trim($_SESSION["b"]);
						$sql2="	select fas_techsupport.idfas_techsupport as idmaxtk from  fas_techsupport where userreported = '".$vv_userreported."' order by datereported desc limit 1  ";
						$result_max_tkxusuario = $connect->query($sql2)->fetchAll();
							foreach ($result_max_tkxusuario as $rowdatos)
							{
								$elmaxidtkcreado = $rowdatos['idmaxtk'];
							}
						$sqlmaxrev = $connect->prepare("update fas_techsupport_fileattach set idfas_techsupport = ".$elmaxidtkcreado."  where idfas_techsupport = 0 and namefile like '". $tkkey."%'  ");
								///	$sqlmaxrev->bindParam(':mshchat', $mshchat);		
						$sqlmaxrev->execute();
					 
					 
					 
					  	$resuljson="ok";
					$return_arr[] = array("resultado" => "ok");
					
					
					 include("configsendmail.php"); 
					//Set who the message is to be sent to
					

					  //Asignamos asunto y cuerpo del mensaje
					  //El cuerpo del mensaje lo ponemos en formato html, haciendo 
					  //que se vea en negrita
					
							//$sql = $connect->prepare("select * from  fas_techsupport inner join fas_techsupport_category on fas_techsupport_category.idtechsupport_category = fas_techsupport.idcategory where idruninfo = ".$vvidruninfodb." order by datereported desc limit 1");
							$sql = $connect->prepare("select * from  fas_techsupport inner join fas_techsupport_category on fas_techsupport_category.idtechsupport_category = fas_techsupport.idcategory where userreported = '".$vv_userreported."' order by datereported desc limit 1");
								$sql->execute();
							$resultadostock = $sql->fetchAll();
								 foreach ($resultadostock as $rowstock) 
								{			
									  $vvidtksupport =  $rowstock['idfas_techsupport'];
									  $emailreported = $rowstock['emailreported'];
										
								}
							///		echo "aaaa".$emailreported;
								if (   $emailreported  == "agustin.corigliano@honeywell.com")
								{
									
									$mail->addAddress('agustin.corigliano@honeywell.com', 'Agus');
									$mail->addCC('leandro.julian@honeywell.com', 'Agus');
									$mail->addBCC('marco.moretti@honeywell.com', 'marco ');
								///	$mail->addBCC('cassia.sanada@honeywell.com', 'cassia ');
								///	$mail->addAddress('estefany.arocha@honeywell.com', 'estefany ');
								}
								else
								{
							//	echo "SI";
									$emailareportarray = explode(";", $emailreported);
									
									if  (count($emailareportarray)>0)
									{
										for($imv = 0; $imv < count($emailareportarray); $imv++){
										//	echo $emailareportarray[$imv].", ";
										
											$mail->addAddress(  $emailareportarray[$imv]);		
										}
								 
									}
									else
									{
										$mail->addAddress( $emailreported);		
									}

								//	$mail->addAddress( $emailreported);									
									$mail->addBCC('marco.moretti@honeywell.com', 'marco ');
								///	$mail->addBCC('cassia.sanada@honeywell.com', 'cassia ');
								////	$mail->addAddress('estefany.arocha@honeywell.com', 'estefany ');
								}
								
								
								$vmostrar="";
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
					  $mail->Body = "<b>New Support Ticket:</b> ".$vvidtksupport."<br><b>UserReported:</b> ".$vv_userreported."<br><b>IdRunInfo:</b> ".$vvidruninfodb."<br><b> Issue:</b> ".$vvv_issue."<br><b> Reference keywords:</b>".$datokey."<br><b>Log:</b><br>".$vmostrar;
                    //Definimos AltBody por si el destinatario del correo no admite email con formato html 
					  $mail->AltBody = "New Support Ticket:".$vvidtksupport." -- From: ".$vv_userreported." -> IdRunInfo:".$vvidruninfodb." - UserReported:".$vv_userreported." -- Issue: ".$vvv_issue."- log".$vmostrar;

						$mail->Send();
					
					}
					
					/// Fin Aviso Soporte
					
				} 
				catch (PDOException $e) 
				{
				
				$return_arr[] = array("resultado" => "errok");
				$resuljson="error";
				}		
		
	
	
					
 echo json_encode($resuljson);
 
 



?>
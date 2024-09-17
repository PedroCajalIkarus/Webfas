<?php
error_reporting(0);
  include("db_conect.php");
  	header('Content-Type: application/json');
   $vvidpo = $_REQUEST['idpo'];
   
    $vvidpo = $_REQUEST['idpo'];
	 $vso_soft_external = $_REQUEST['so'];	  
		 $nameapproved = $_SESSION["b"];
		 $cantasing  =  $_REQUEST["cantasing"];
		 $poskufinal =  $_REQUEST["poskufinal"];
	$todoslossn = explode("#", $_REQUEST['lossn']  );
  
		$vuserfas = $_SESSION["b"];
						
						$vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
						$vaccionweb="update po so sn";
	
	
		  $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connect->beginTransaction();
	
		 try {
			 
			 	$sqlmaxrev = $connect->prepare("select  coalesce(max(idrev),0) as cc from orders where idorders = :v_idorders ");
				$sqlmaxrev->bindParam(":v_idorders", $vvidpo);		
				$sqlmaxrev->execute();
				$result = $sqlmaxrev->fetchAll();				
			
					foreach ($result as $row) 
					{
					///	echo "MAX ID REV ".$row['maxidrev']."---------------".$vvidpo;
					$vgeneradoidrev=$row['cc']	;
					}
				
				
			 
				$id_sn_autogenerado=1 +  $cantasing  ;
			//	$id_sn_autogenerado =2;
				  foreach ($todoslossn as $elsn) {
				//	  echo "elsn".$elsn;
					  if ($elsn != "")
					  {
					//	echo "---------------".$elsn."<br>";  
						$elsnsplitter = explode("|", $elsn  );
					//	echo "entro****".$elsnsplitter[0];
						////20036147FU|00000001WO
						
							$sqlmaxrev = $connect->prepare("select coalesce(idorders,0) as idorders  , coalesce(wo_serialnumber,'')  as wo_serialnumber from orders_sn where idorders = :v_idorders and idnroserie = :vidsn ");
							$sqlmaxrev->bindParam(":v_idorders", $vvidpo);		
							$sqlmaxrev->bindParam(":vidsn", $id_sn_autogenerado);		
							$sqlmaxrev->execute();
							$result = $sqlmaxrev->fetchAll();
							$vexiste_ordern_sn =0;							
								//foreach ($result as $row) 
								//	{
									///	echo "MAX ID REV ".$row['maxidrev']."---------------".$vvidpo;
									//	$vexiste_ordern_sn=$row['idorders']	;
									//	$vexiste_ordern_sn_nro=$row['wo_serialnumber']	;
									//}
									if ( $vexiste_ordern_sn > 0)
									{
										if ( $vexiste_ordern_sn_nro <> $elsnsplitter[0] )
										{
											///// updateamosss
												$sql = $connect->prepare("update orders_sn set wo_serialnumber = :v_sn, ponumber=:ponumber, processfasserver=false, so_associed =:v_woassocied where idorders = :v_idorders	and idnroserie = :vidsn and idrev in (select max(idrev) FROM orders_sn where idorders = :v_idorders2 );");
												$sql->bindParam(':v_sn', $elsnsplitter[0]);
												$sql->bindParam(':ponumber', $poskufinal);
												$sql->bindParam(':v_woassocied', $elsnsplitter[1]);
												$sql->bindParam(':v_idorders', $vvidpo);
											
												$sql->bindParam(':vidsn', $id_sn_autogenerado);
													$sql->bindParam(':v_idorders2', $vvidpo);
											
												  $sql->execute();
												$vtextaudit="update orders_sn set wo_serialnumber = :v_sn, processfasserver=false, so_associed =:v_woassocied where idorders = :v_idorders	and idnroserie = :vidsn and idrev in (select max(idrev) FROM orders_sn where idorders = :v_idorders2 );";
												$vtextaudit=$vtextaudit."!!v_sn:".$elsnsplitter[0];
												$vtextaudit=$vtextaudit."!!v_idorders:".$vvidpo;
												$vtextaudit=$vtextaudit."!!ponumber:".$poskufinal;
												$vtextaudit=$vtextaudit."!!vidsn:".$id_sn_autogenerado;
												$vtextaudit=$vtextaudit."!!v_woassocied:".$elsnsplitter[1];
												
										}
									}
									else
									{
										///-------si no existe esa order y idnroserie..busco el template.. con el max idrev y lo inserto
										
										$sql = $connect->prepare("insert into orders_sn SELECT idorders, idcustomers, idfamilyprod, idtypeband, idtypeproduct, idproduct, idconfiguration, idrev, :vidsn, so_soft_external, :v_sn, idruninfo, :ponumber, pwrsupplytype, rcgfbwa, moden_dig, date_approved, descripcion, ul_gain, ul_max_pwr, dl_gain, dl_max_pwr, req_ppassy, req_calibration, req_spec, req_other, nameapproved, notes, reqresources, typeregister, processday, processfasserver, so_original, :v_nrowo FROM orders_sn  where idorders   = :v_idorders	and idrev in (select max(idrev) FROM orders_sn where idorders   =:v_idorders2	 ) order by idnroserie desc limit 1;");
												$sql->bindParam(':vidsn', $id_sn_autogenerado);												
												$sql->bindParam(':v_sn', $elsnsplitter[0]);
												$sql->bindParam(':ponumber', $poskufinal);
												$sql->bindParam(':v_nrowo', $elsnsplitter[1]);
												$sql->bindParam(':v_idorders', $vvidpo);
												$sql->bindParam(':v_idorders2', $vvidpo);
												
												 $sql->execute();
												 
											
											$vtextaudit="insert into orders_sn SELECT idorders, idcustomers, idfamilyprod, idtypeband, idtypeproduct, idproduct, idconfiguration, idrev, :vidsn, so_soft_external, :v_sn, idruninfo, ponumber, pwrsupplytype, rcgfbwa, moden_dig, date_approved, descripcion, ul_gain, ul_max_pwr, dl_gain, dl_max_pwr, req_ppassy, req_calibration, req_spec, req_other, nameapproved, notes, reqresources, typeregister, processday, processfasserver, so_original, :v_nrowo FROM orders_sn  where idorders   = :v_idorders	and idrev in (select max(idrev) FROM orders_sn where idorders   =:v_idorders	 ) order by idnroserie desc limit 1;";	  
											
											$vtextaudit=$vtextaudit."!!v_sn:".$elsnsplitter[0];
												$vtextaudit=$vtextaudit."!!v_idorders:".$vvidpo;
												$vtextaudit=$vtextaudit."!!vidsn:".$id_sn_autogenerado;
												$vtextaudit=$vtextaudit."!!v_nrowo:".$elsnsplitter[1];
											
											
										  $sql = $connect->prepare("insert into orders_sn_specs SELECT idorders, idrev, idch, :vidsn, typedata, ul_ch_fr, dl_ch_fr, dpxlowstart, dpxlowstop, dpxhihgstart, dpxhihgstop, unitdlstart, unitdlstop, unitulstart, unitulstop, notes, idband, ulgain, dlgain, ulmaxpwr, dlmaxpwr FROM orders_sn_specs where idorders   = :v_idorders and idnroserie = 0 and idrev in (select max(idrev) FROM orders_sn_specs where idorders   = :v_idorders2 );");
												$sql->bindParam(':vidsn', $id_sn_autogenerado);
												$sql->bindParam(':v_idorders', $vvidpo);
													$sql->bindParam(':v_idorders2', $vvidpo);
												
												
												  $sql->execute();
									}
								
									$vuserfas = $_SESSION["b"];
									$sentenciaudit = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
								$sentenciaudit->bindParam(':userfas', $vuserfas);								
								$sentenciaudit->bindParam(':menuweb', $vmenufas);
								$sentenciaudit->bindParam(':actionweb', $vaccionweb);
						
							
							
								$vdescripaudit="orders_sn Update SN proceso Christ - user:".$vuserfas;		
								$sentenciaudit->bindParam(':descripaudit', $vdescripaudit);
								$sentenciaudit->bindParam(':textaudit', $vtextaudit);
								$sentenciaudit->execute();	
					
								 
								$sqlattt = $connect->prepare("delete from orders_sn_attributes 	where idorders   = :v_idorders  and  sn = :v_sn");
																		 
								$sqlattt->bindParam(':v_idorders', $vvidpo);
								$sqlattt->bindParam(':v_sn', $elsnsplitter[0]);
								$sqlattt->execute();

								 	
								$sqlattt2 = $connect->prepare("insert into orders_sn_attributes
								SELECT idorders, idattribute_orders, datemodif,:v_sn, v_boolean, v_integer, v_double, v_string, v_date
								FROM public.orders_attributes
								where idorders   = :v_idorders");
								$sqlattt2->bindParam(':v_idorders', $vvidpo);
								$sqlattt2->bindParam(':v_sn', $elsnsplitter[0]);
								$sqlattt2->execute();
					
					
							
						
						
							  $id_sn_autogenerado= $id_sn_autogenerado+1;
						//	echo "PASOOOOOOOOOOOOOOOOOOOO POR CALL";
							
							$sql = $connect->prepare("update orders_sn set so_associed = (select distinct so_soft_external from orders_sn where idorders =:vvidlog and  wo_serialnumber =:v_sn ) where so_soft_external = :v_woassocied and wo_serialnumber = :v_sn ;");
							$sql->bindParam(':vvidlog', $vvidpo);
							$sql->bindParam(':v_sn', $elsnsplitter[0]);
							$sql->bindParam(':v_woassocied', $elsnsplitter[1]);
							  $sql->execute();


							  $sql = $connect->prepare("update orders_sn set idorders_nxt_trk = (select distinct idorders from orders_sn where idorders =:vvidlog and  wo_serialnumber = :v_sn ) where so_soft_external = :v_woassocied and wo_serialnumber = :v_sn");
							  $sql->bindParam(':vvidlog', $pp_idso);
							  $sql->bindParam(':v_sn', $pp_sn);
							  $sql->bindParam(':v_woassocied', $pp_wo);
								$sql->execute();
					 
								
								$sql = $connect->prepare("update orders_sn set idnroserie_nxt_trk = (select distinct idnroserie from orders_sn where idorders =:vvidlog and  wo_serialnumber = :v_sn ) where so_soft_external = :v_woassocied and wo_serialnumber = :v_sn");
								$sql->bindParam(':vvidlog', $pp_idso);
								$sql->bindParam(':v_sn', $pp_sn);
								$sql->bindParam(':v_woassocied', $pp_wo);
								  $sql->execute();

							  $sql = $connect->prepare("update orders_sn set so_associed = :v_woassocied where typeregister = 'SO' and  wo_serialnumber = :v_sn ;");
							  $sql->bindParam(':v_woassocied', $elsnsplitter[1]);
							  $sql->bindParam(':v_sn', $elsnsplitter[0]);
							
								$sql->execute();
					  }
						
					}
								
				
			/////**************************************************** 

				  // Insertamos Estado 
				   $sql2 = $connect->prepare("update orders_sn set processfasserver = false,  typeregister= 'SO'  WHERE idorders = :vvidlog  ");
				  $sql2->bindParam(':vvidlog', $vvidpo);			  
				  
			  	  $sql2->execute();
				//  $resultado = $sql2->fetchAll();

				$query_lista ="INSERT INTO orders_states(idorders, idstate, datestate)	VALUES (".$vvidpo.", 17, (NOW() - interval '10 minutes') );";
				$connect->query($query_lista);
					
				  
				  $sql2 = $connect->prepare("update orders set processfasserver = false,  typeregister= 'SO', active = 'Y'   WHERE idorders = :vvidlog  ");
				  $sql2->bindParam(':vvidlog', $vvidpo);
				   $sql2->execute();
				//  $resultado = $sql->fetchAll();

				/////**************************************************** 
					// Preguntamos aca si es BDA FLEX  700/800 - para setear el autopass por fasclientes = true				
			/*		$sql2fix = $connect->prepare("	update orders_sn set processfasserver = false,  processday =now() where idorders = :vvidlog and  wo_serialnumber = '".$elsnsplitter[0]."' and typeregister= 'SO'
					and idproduct in ( 
						select distinct products.idproduct from fnt_select_allproducts_maxrev() as products
						inner join fnt_select_objectband_maxrev() as objectband
					  on products.idproduct		=	objectband.idproduct 
					where   iduniquebranchsonprod like '%00010037003900430045%' and idband  in(3,4)
					)   ");
				//	$sql2fix->bindParam(':wo_serialnumber',  $elsnsplitter[0]);
					$sql2fix->bindParam(':vvidlog', $vvidpo);
					 $sql2fix->execute();
					 // Preguntamos aca si es BDA FLEX  700/800 - para setear el autopass por fasclientes = true				
					$sql2fix = $connect->prepare("	update orders set processfasserver = false ,active = 'A', processday =now(), fassrverror='automatic' where idorders = :vvidlog   and typeregister= 'SO'
					and idproduct in ( 
						select distinct products.idproduct from fnt_select_allproducts_maxrev() as products
						inner join fnt_select_objectband_maxrev() as objectband
					  on products.idproduct		=	objectband.idproduct 
					where   iduniquebranchsonprod like '%00010037003900430045%' and idband  in(3,4)
					)   ");
					$sql2fix->bindParam(':vvidlog', $vvidpo);
					 $sql2fix->execute();
					 ///// comentado el 06-13-2022 - 11:03
				*/
					/// 'SNs Assign FAS_Server'
					$query_lista ="INSERT INTO orders_states(idorders, idstate, datestate)	VALUES (".$vvidpo.", 7, now());";
				   $connect->query($query_lista);
					 	$return_result_insert="ok"; 
										$msjerr= "";
			
					 $connect->commit();
					 
					 	
						/// INSERT para SERVIDOR DE peticions :: petitions_server
							$v_id_station = 	$_SESSION["k"]  	 ; //id station for user business
							$iduuff = 	$_SESSION["a"];
							$iduu = 22; /// usuario del servidor
							$v_id_station = 13; // station del servidor;

						 $parajson= '{"idorders":'.$vvidpo.'}';
							$sqlpetiti ="INSERT INTO public.fas_petitions_server(
	idpetition, petitiontype, iduserfrom, iduserto, idstationto, instance, date, status, exitstatus, parameters1, parameters2, parameters3, idexterna)
	VALUES ((select COALESCE(max(idpetition),0) + 1 from fas_petitions_server), 2, ".$iduuff.", ".$iduu.", ".$v_id_station.",'04F', now(), 0, null, '".$parajson."', null, null, null);";
	
	
					    	$connect->query($sqlpetiti);
	
						/// fin petitions_server

						  /// Enviamos Aviso soprote
				/*	include("configsendmail.php"); 
					//Set who the message is to be sent to
						$mail->addAddress('marco.moretti@fiplex.com', 'DEVELOPMENT');
								
							
							  $mail->Subject = "WEBFAS::Asingar SN";
							  $mail->Body = " attention, Asingar SN:  ".$parajson."-".$_REQUEST['lossn'] ;
							//Definimos AltBody por si el destinatario del correo no admite email con formato html 
							  $mail->AltBody = " Asingar SN: ".$parajson."-".$_REQUEST['lossn'] ;
							
							
								$mail->Send();*/
						
						
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
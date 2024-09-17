<?php
 include("db_conect.php"); 
  	session_start();
	include("funcionesstores.php"); 
	header('Content-Type: application/json');
	
	error_reporting(E_ALL);
		
	$vv_idmoduleprodflia =str_replace ('a','', trim($_REQUEST['idmoduleprodflia']));	
	$vv_txtbusiness = trim($_REQUEST['txtbusiness']);	
	    $return_arr = array();
	
	$porciones_param = explode("_", $vv_idmoduleprodflia);
	
	$vv_txtnewprod = trim($_REQUEST['v_namemod']);
	$vv_txtnewproddescr = trim($_REQUEST['v_namemoddescrip']);
	
	$vvtxtrohsimg = trim($_REQUEST['txtrohsimg']);
	$vvtxtmadeinimg = trim($_REQUEST['txtmadeinimg']);
						
	
		$vv_txtnewproddescr = trim($_REQUEST['v_namemoddescrip']);
			$vv_txtnewproddescr = trim($_REQUEST['v_namemoddescrip']);
	///module passive coupler
	$vcouple_coupling = trim($_REQUEST['vcouple_coupling']);
	$vcouple_insertloss = trim($_REQUEST['vcouple_insertloss']);
	$vcouple_isolation = trim($_REQUEST['vcouple_isolation']);
	$vcouple_freqstart = trim($_REQUEST['vcouple_freqstart']);
	$vcouple_freqstop = trim($_REQUEST['vcouple_freqstop']);
	
	///module passive duplexer
	$vduplexer_txrxsep = trim($_REQUEST['vduplexer_txrxsep']);
	$vduplexer_insertlosstx = trim($_REQUEST['vduplexer_insertlosstx']);
	$vduplexer_insertlossrx = trim($_REQUEST['vduplexer_insertlossrx']);
	$vduplexer_txnoise = trim($_REQUEST['vduplexer_txnoise']);
	$vduplexer_isolationrxtx = trim($_REQUEST['vduplexer_isolationrxtx']);
	$vduplexer_freqstart = trim($_REQUEST['vduplexer_freqstart']);
	$vduplexer_freqstop = trim($_REQUEST['vduplexer_freqstop']);
	///module passive Preselector
	$vpreselector_bandwitdh = trim($_REQUEST['vpreselector_bandwitdh']);
	$vpreselector_insertloss = trim($_REQUEST['vpreselector_insertloss']);
	$vpreselector_freqstart = trim($_REQUEST['vpreselector_freqstart']);
	$vpreselector_freqstop = trim($_REQUEST['vpreselector_freqstop']);
	///module passive splitter
	$vsplitter_splitloss = trim($_REQUEST['vsplitter_splitloss']);
	$vsplitter_insertloss = trim($_REQUEST['vsplitter_insertloss']);
	$vsplitter_nroways = trim($_REQUEST['vsplitter_nroways']);
	$vsplitter_freqstart = trim($_REQUEST['vsplitter_freqstart']);
	$vsplitter_freqstop = trim($_REQUEST['vsplitter_freqstop']);

	$vuserfas = $_SESSION["b"];
$vvidconfi = 0;


	$query_lista ="select max(idproduct) as maxidproduct  from products";
	
	//echo $query_lista;
	$vvmaxidproduct=0;
		$data = $connect->query($query_lista)->fetchAll();	
			foreach ($data as $row) {			
				$vvmaxidproduct=$row['maxidproduct'];
			}
	$vvmaxidproduct=$vvmaxidproduct + 1 ;
	
		
	

		$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connect->beginTransaction();
		 try {
		
			  		
						$sql = $connect->prepare("INSERT INTO public.products(
						idfamilyprod, idtypeproduct, idproduct, idconfiguration, powersupply, modelciu, description, namecustom, classproduct,
						active, usermodif, datelastmodif, woparam, showdpxreport, idfamilygroup, idbusiness, iduniquebranchsonprod, idbandgroup)
						VALUES (:idfamilyprod, :idtypeproduct, :idproduct, :idconfiguration, '-', :modelciu, :description, null, null,
						'Y', :usermodif, now(), false, false, :idfamilygroup, :idbusiness, :iduniquebranchsonprod, 0); ");
						$sql->bindParam(':idfamilyprod', $vvidconfi);
						$sql->bindParam(':idtypeproduct',$vvidconfi);
						$sql->bindParam(':idproduct', $vvmaxidproduct);
						$sql->bindParam(':idconfiguration', $vvidconfi);
						$sql->bindParam(':modelciu', $vv_txtnewprod);
						$sql->bindParam(':description', $vv_txtnewproddescr);
							$sql->bindParam(':usermodif', $vuserfas);
						$sql->bindParam(':idfamilygroup', $vvidconfi);
						$sql->bindParam(':idbusiness', $vv_txtbusiness);
						$sql->bindParam(':iduniquebranchsonprod', $vv_idmoduleprodflia);

						$sql->execute();
				
						$sqllabel = $connect->prepare("	INSERT INTO public.products_label( idbusiness, idfamilygroup, idfamilyprod, idtypeproduct, idproduct, idconfiguration, ulpwrrat, madein, flia, fcc, ic, idlabel, active, description, fccimg, ulimg, rohsimg, madeinimg, etsi, idrev, etlnumber, intertekimg) 	VALUES (:idbusiness, :idfamilygroup, :idfamilyprod, :idtypeproduct, :idproduct, :idconfiguration, null, :madein, :flia, null, null, (select  coalesce (max(idlabel),0) + 1 from products_label) , 'Y', null, null, null, '".$vvtxtrohsimg."', '".$vvtxtmadeinimg."', null, 0, null, null);");
						
						
						$sqllabel->bindParam(':idbusiness', $vv_txtbusiness);
						$sqllabel->bindParam(':idfamilygroup',  $vvidconfi);
						$sqllabel->bindParam(':idfamilyprod',  $vvidconfi);
						$sqllabel->bindParam(':idtypeproduct',  $vvidconfi);
						$sqllabel->bindParam(':idproduct', $vvmaxidproduct);
						$sqllabel->bindParam(':idconfiguration', $vvidconfi);

						$vvtxtrohsimg = trim($_REQUEST['txtrohsimg']);
						$vvtxtmadeinimg = trim($_REQUEST['txtmadeinimg']);
						$vvtxtmadein = trim($_REQUEST['txtmadein']);
						$txtflia = trim($_REQUEST['flia']);
						
							$sqllabel->bindParam(':madein', $vvtxtmadein);
							
						$sqllabel->bindParam(':flia', $txtflia);
				
					

						$sqllabel->execute();
	
							
							// Insertamos auditoria 				  
				  				$vuserfas = $_SESSION["b"];
								$vdescripaudit="Create Module Passive :".$vv_idmoduleprodflia."  - user:".$vuserfas;		
								$vtextaudit="INSERT INTO public.products(
	idfamilyprod, idtypeproduct, idproduct, idconfiguration, powersupply, modelciu, description, namecustom, classproduct,
	active, usermodif, datelastmodif, woparam, showdpxreport, idfamilygroup, idbusiness)
	VALUES (:idfamilyprod, :idtypeproduct, :idproduct, :idconfiguration, '-', :modelciu, :description, null, null,
	'Y', usermodif, now(), false, false, :idfamilygroup, :idbusiness); ";						
								$vtextaudit=$vtextaudit."!!idfamilyprod:".$vv_idmoduleprodflia;
								$vtextaudit=$vtextaudit."!!idproduct:".$vvmaxidproduct;							
								$vtextaudit=$vtextaudit."!!modelciu:".$vv_txtnewprod;
								$vtextaudit=$vtextaudit."!!description:".$vv_txtnewproddescr;
								$vtextaudit=$vtextaudit."!!idbusiness:".$vv_txtbusiness;
								
								$sentenciaudit = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
								$sentenciaudit->bindParam(':userfas', $vuserfas);								
								$sentenciaudit->bindParam(':menuweb', $vmenufas);
								$sentenciaudit->bindParam(':actionweb', $vaccionweb);
								$sentenciaudit->bindParam(':descripaudit', $vdescripaudit);
								$sentenciaudit->bindParam(':textaudit', $vtextaudit);
								$sentenciaudit->execute();
							////// inicio insert components_passives_coupler
								if($vv_idmoduleprodflia=="0000000020006") 
									{
								
										///////////////////////////////////////////////////////////////////////////////
										$vvmaxidcomponect = 0;
										$query_lista ="select max(idcomppassivecoup)+1 as maxidcomppassivecoup  from components_passives_coupler";
										$data = $connect->query($query_lista)->fetchAll();	
											foreach ($data as $row) {			
												$vvmaxidcomponect=$row['maxidcomppassivecoup'];
											}
											$vvmaxidcomponect=$vvmaxidcomponect + 1 ;
										///////////////////////////////////////////////////////////////////////////////	
		
										$sql = $connect->prepare("INSERT INTO public.components_passives_coupler(
										idbusiness, idfamilygroup, idfamilyprod, idtypeproduct, idproduct, idconfiguration, idcomppassivecoup, idcomprevcoup, coupfstart, coupfstop, coupling, couplinginsertloss, couplingisolation, active)
										VALUES (:idbusiness, :idfamilygroup, :idfamilyprod, :idtypeproduct, :idproduct, :idconfiguration, :idcomppassivecoup, 0, :coupfstart, :coupfstop, :coupling, :couplinginsertloss, :couplingisolation,'Y');");
															
															$sql->bindParam(':idfamilyprod',  $vvidconfi);
															$sql->bindParam(':idtypeproduct',  $vvidconfi);
															$sql->bindParam(':idproduct', $vvmaxidproduct);
															$sql->bindParam(':idconfiguration', $vvidconfi);
															
															$sql->bindParam(':idcomppassivecoup', $vvmaxidcomponect);
															$sql->bindParam(':coupfstart', $vcouple_freqstart);
															$sql->bindParam(':coupfstop', $vcouple_freqstop);
															$sql->bindParam(':coupling', $vcouple_coupling);
															$sql->bindParam(':couplinginsertloss', $vcouple_insertloss);
															$sql->bindParam(':couplingisolation', $vcouple_isolation);
													
															$sql->bindParam(':idfamilygroup',  $vvidconfi);
															$sql->bindParam(':idbusiness', $vv_txtbusiness);

															$sql->execute();										  
														// Insertamos auditoria 				  
															$vuserfas = $_SESSION["b"];
															$vdescripaudit="Create Module components_passives_coupler :".$vv_idmoduleprodflia."  - user:".$vuserfas;		
															$vtextaudit="INSERT INTO public.components_passives_coupler(
								idbusiness, idfamilygroup, idfamilyprod, idtypeproduct, idproduct, idconfiguration, idcomppassivecoup, idcomprevcoup, coupfstart, coupfstop, coupling, couplinginsertloss, couplingisolation)
								VALUES (:idbusiness, :idfamilygroup, :idfamilyprod, :idtypeproduct, :idproduct, :idconfiguration, :idcomppassivecoup, 0, :coupfstart, :coupfstop, :coupling, :couplinginsertloss, :couplingisolation);";						
															$vtextaudit=$vtextaudit."!!idfamilyprod:".$vv_idmoduleprodflia;
															$vtextaudit=$vtextaudit."!!idproduct:".$vvmaxidproduct;		
															$vtextaudit=$vtextaudit."!!idcomppassivecoup:".$vvmaxidcomponect;
															$vtextaudit=$vtextaudit."!!coupfstart:".$vcouple_freqstart;
															$vtextaudit=$vtextaudit."!!coupfstop:".$vcouple_freqstop;
															$vtextaudit=$vtextaudit."!!coupling:".$vcouple_coupling;
															$vtextaudit=$vtextaudit."!!couplinginsertloss:".$vcouple_insertloss;
															$vtextaudit=$vtextaudit."!!couplingisolation:".$vcouple_isolation;
															
															$sentenciaudit = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
															$sentenciaudit->bindParam(':userfas', $vuserfas);								
															$sentenciaudit->bindParam(':menuweb', $vmenufas);
															$sentenciaudit->bindParam(':actionweb', $vaccionweb);
															$sentenciaudit->bindParam(':descripaudit', $vdescripaudit);
															$sentenciaudit->bindParam(':textaudit', $vtextaudit);
															$sentenciaudit->execute();
									}
								///// fin insert components_passives_coupler
								///// inicio insert components_passives_Duplexer
								if($porciones_param[3] =="Duplexer") 
									{
										
										///////////////////////////////////////////////////////////////////////////////
										$vvmaxidcomponect = 0;
										$query_lista ="select max(idcomppassivecoup)+1 as maxidcomppassivecoup  from components_passives_duplexer";
										$data = $connect->query($query_lista)->fetchAll();	
											foreach ($data as $row) {			
												$vvmaxidcomponect=$row['maxidcomppassivecoup'];
											}
											$vvmaxidcomponect=$vvmaxidcomponect + 1 ;
										///////////////////////////////////////////////////////////////////////////////	


										$sql = $connect->prepare("INSERT INTO public.components_passives_duplexer(
	idbusiness, idfamilygroup, idfamilyprod, idtypeproduct, idproduct, idconfiguration, idcomppassivecoup, idcomprevcoup, duplexerfstart, duplexerfstop, duplexertxrxsep, duplexerinserlosstx, duplexerinserlossrx, duplexertxnoise, duplexerrxtxisolation)
	VALUES (:idbusiness, :idfamilygroup, :idfamilyprod, :idtypeproduct, :idproduct, :idconfiguration, :idcomppassivecoup, 0, :duplexerfstart, :duplexerfstop, :duplexertxrxsep, :duplexerinserlosstx, :duplexerinserlossrx, :duplexertxnoise, :duplexerrxtxisolation);");
															
															$sql->bindParam(':idfamilyprod',  $vvidconfi);
															$sql->bindParam(':idtypeproduct',  $vvidconfi);
															$sql->bindParam(':idproduct', $vvmaxidproduct);
															$sql->bindParam(':idconfiguration', $vvidconfi);															
															$sql->bindParam(':idcomppassivecoup', $vvmaxidcomponect);															
															$sql->bindParam(':duplexerfstart', $vduplexer_freqstart);
															$sql->bindParam(':duplexerfstop', $vduplexer_freqstop);
															$sql->bindParam(':duplexertxrxsep', $vduplexer_txrxsep);																														
															$sql->bindParam(':duplexerinserlosstx', $vduplexer_insertlosstx);
															$sql->bindParam(':duplexerinserlossrx', $vduplexer_insertlossrx);
															$sql->bindParam(':duplexertxnoise', $vduplexer_txnoise);
															$sql->bindParam(':duplexerrxtxisolation', $vduplexer_isolationrxtx);
															$sql->bindParam(':idfamilygroup',  $vvidconfi);
															$sql->bindParam(':idbusiness', $vv_txtbusiness);

															$sql->execute();
															
															
									}
								///// fin insert components_passives_Duplexer
								///// inicio insert components_passives_Preselector
								if($porciones_param[3] =="Preselector") 
									{
										
											///////////////////////////////////////////////////////////////////////////////
										$vvmaxidcomponect = 0;
										$query_lista ="select max(idcomppassivecoup)+1 as maxidcomppassivecoup  from components_passives_preselector";
										$data = $connect->query($query_lista)->fetchAll();	
											foreach ($data as $row) {			
												$vvmaxidcomponect=$row['maxidcomppassivecoup'];
											}
											$vvmaxidcomponect=$vvmaxidcomponect + 1 ;
										///////////////////////////////////////////////////////////////////////////////	
										
										
										$sql = $connect->prepare("INSERT INTO public.components_passives_preselector(
	idbusiness, idfamilygroup, idfamilyprod, idtypeproduct, idproduct, idconfiguration, idcomppassivecoup, idcomprevcoup, preselectorfstart, preselectorfstop, preselectorbandwidth, preselectorinserloss)
	VALUES (:idbusiness, :idfamilygroup, :idfamilyprod, :idtypeproduct, :idproduct, :idconfiguration, :idcomppassivecoup, 0, :preselectorfstart, :preselectorfstop, :preselectorbandwidth, :preselectorinserloss);");
	
															$sql->bindParam(':idfamilyprod',  $vvidconfi);
															$sql->bindParam(':idtypeproduct',  $vvidconfi);
															$sql->bindParam(':idproduct', $vvmaxidproduct);
															$sql->bindParam(':idconfiguration', $vvidconfi);															
															$sql->bindParam(':idcomppassivecoup', $vvmaxidcomponect);															
															
															$sql->bindParam(':preselectorfstart', $vpreselector_freqstart);
															$sql->bindParam(':preselectorfstop', $vpreselector_freqstop);																														
															$sql->bindParam(':preselectorbandwidth', $vpreselector_bandwitdh);
															$sql->bindParam(':preselectorinserloss', $vpreselector_insertloss);			
															$sql->bindParam(':idfamilygroup', $vvidconfi);
															$sql->bindParam(':idbusiness', $vv_txtbusiness);

															$sql->execute();
															
									}
								///// fin insert components_passives_Preselector
								///// inicio insert components_passives_Splitter
								if($porciones_param[3] =="Splitter") 
									{
										
										///////////////////////////////////////////////////////////////////////////////
										$vvmaxidcomponect = 0;
										$query_lista ="select max(idcomppassivecoup)+1 as maxidcomppassivecoup  from components_passives_splitter";
										$data = $connect->query($query_lista)->fetchAll();	
											foreach ($data as $row) {			
												$vvmaxidcomponect=$row['maxidcomppassivecoup'];
											}
											$vvmaxidcomponect=$vvmaxidcomponect + 1 ;
										///////////////////////////////////////////////////////////////////////////////	
										
										
										$sql = $connect->prepare("INSERT INTO public.components_passives_splitter(
											idbusiness, idfamilygroup, idfamilyprod, idtypeproduct, idproduct, idconfiguration, idcomppassivecoup, idcomprevcoup, splitterfstart, splitterfstop, nroway, splitloss, insertloss)
											VALUES (:idbusiness, :idfamilygroup, :idfamilyprod, :idtypeproduct, :idproduct, :idconfiguration, :idcomppassivecoup, 0, :splitterfstart, :splitterfstop, :nroway, :splitloss, :insertloss);
											");
	
	
	
															$sql->bindParam(':idfamilyprod', $vvidconfi);
															$sql->bindParam(':idtypeproduct',  $vvidconfi);
															$sql->bindParam(':idproduct', $vvmaxidproduct);
															$sql->bindParam(':idconfiguration', $vvidconfi);															
															$sql->bindParam(':idcomppassivecoup', $vvmaxidcomponect);															
															
															
															$sql->bindParam(':splitterfstart', $vsplitter_freqstart);
															$sql->bindParam(':splitterfstop', $vsplitter_freqstop);			
															
															$sql->bindParam(':nroway', $vsplitter_nroways);
															$sql->bindParam(':splitloss', $vsplitter_splitloss);		
															$sql->bindParam(':insertloss', $vsplitter_insertloss);		
															
															$sql->bindParam(':idfamilygroup',  $vvidconfi);
															$sql->bindParam(':idbusiness', $vv_txtbusiness);

														$sql->execute();
															
									}
								///// fin insert components_passives_Splitter
								
								///// inicio insert DIGBOARDFLEZ
								if( $vv_idmoduleprodflia =="DIGBOARDFLEZ") 
								{
									
									///////////////////////////////////////////////////////////////////////////////
									$vvmaxidcomponect = 0;
									$query_lista ="select max(idcomppassivecoup)+1 as maxidcomppassivecoup  from components_passives_splitter";
									$data = $connect->query($query_lista)->fetchAll();	
										foreach ($data as $row) {			
											$vvmaxidcomponect=$row['maxidcomppassivecoup'];
										}
										$vvmaxidcomponect=$vvmaxidcomponect + 1 ;
									///////////////////////////////////////////////////////////////////////////////	
									
									
									$sql = $connect->prepare("INSERT INTO public.components_passives_splitter(
										idbusiness, idfamilygroup, idfamilyprod, idtypeproduct, idproduct, idconfiguration, idcomppassivecoup, idcomprevcoup, splitterfstart, splitterfstop, nroway, splitloss, insertloss)
										VALUES (:idbusiness, :idfamilygroup, :idfamilyprod, :idtypeproduct, :idproduct, :idconfiguration, :idcomppassivecoup, 0, :splitterfstart, :splitterfstop, :nroway, :splitloss, :insertloss);
										");



														$sql->bindParam(':idfamilyprod', $vvidconfi);
														$sql->bindParam(':idtypeproduct',  $vvidconfi);
														$sql->bindParam(':idproduct', $vvmaxidproduct);
														$sql->bindParam(':idconfiguration', $vvidconfi);															
														$sql->bindParam(':idcomppassivecoup', $vvmaxidcomponect);															
														
														
														$sql->bindParam(':splitterfstart', $vsplitter_freqstart);
														$sql->bindParam(':splitterfstop', $vsplitter_freqstop);			
														
														$sql->bindParam(':nroway', $vsplitter_nroways);
														$sql->bindParam(':splitloss', $vsplitter_splitloss);		
														$sql->bindParam(':insertloss', $vsplitter_insertloss);		
														
														$sql->bindParam(':idfamilygroup',  $vvidconfi);
														$sql->bindParam(':idbusiness', $vv_txtbusiness);

													$sql->execute();
														
								}
							///// fin insert DIGBOARDFLEZ
							////	DIGBOARDFLEZ
								
								
				  	$return_arr[] = array("resultado" => "OK");
					$return_result_insert="ok"; 
					$msjerr= "";
			
					  $connect->commit();
					
							
				} 
				catch (PDOException $e) 
				{
					
					$connect->rollBack();
				  	$return_arr[] = array("resultado" => "Error");
					$return_result_insert=$e; 
					echo $e;
					exit();
						
					
				}
		

	
	// $connect->query($query_lista);

					
		
	
	
					
 echo json_encode($return_arr);
 
 



?>
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
	
	$vv_txtnewprod = strtoupper(trim($_REQUEST['v_namemod']));
	$vv_txtnewproddescr = trim($_REQUEST['v_namemoddescrip']);
	
	$vvtxtrohsimg = trim($_REQUEST['txtrohsimg']);
	$vvtxtmadeinimg = trim($_REQUEST['txtmadeinimg']);
						
	


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


	/// Busco el max id arboñ
	$query_listaarbol ="select max(idfastree) +1 as maxtree from fas_tree";
	
	//echo $query_lista;
	$vvmaxidtree=0;
		$data = $connect->query($query_listaarbol)->fetchAll();	
			foreach ($data as $rowtree) {			
				$vvmaxidtree=$rowtree['maxtree'];
			}
	$vvmaxidtree=$vvmaxidtree + 1 ;

	
		
	

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
				
					
	
							
							// Insertamos auditoria 				  
				  				$vuserfas = $_SESSION["b"];
								$vdescripaudit="Create Module DiB :".$vv_idmoduleprodflia."  - user:".$vuserfas;		
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

										//////// INSERT TABLE FAS_CONFIDENCIAL_FW
								
								$txttypeclassfw = trim($_REQUEST['txttypeclassfw']);
								if ($txttypeclassfw == 'firmwarestand')
								{
									$txttypeclassfw=false;
								}
								else
								{
									$txttypeclassfw=true;
								}
								$txtfpga = trim($_REQUEST['txtfpga']);
								$txtfpgacus = trim($_REQUEST['txtfpgacus']);
								$txtuc = trim($_REQUEST['txtuc']);
								$txtether = trim($_REQUEST['txtether']);
								$txtuccus = trim($_REQUEST['txtuccus']);
								$txtethercus = trim($_REQUEST['txtethercus']);
								$vuserfas = $_SESSION["b"];
								$viduserfas = $_SESSION["a"];
							
								
								$sql = $connect->prepare("INSERT INTO public.fas_confidential_fw(	idtypeband, idciu, fpgafilename, microfilename, ethfilename, active, customfw, fpga_fas, micro_fas, eth_fas, datelastmodif, usermodif, calrstring)  VALUES (5, :idproduct, '".$txtfpgacus."', '".$txtuccus."','".$txtethercus."', 'Y', '".$txttypeclassfw."', '".$txtfpga."', '".$txtuc."', '".$txtether."', now(), :usermodif, null)");
								
												
															$sql->bindParam(':idproduct', $vvmaxidproduct);
															$sql->bindParam(':usermodif', $vuserfas);
															$sql->execute();	
															
								
	
							////// fin TABLE FAS_CONFIDENCIAL_FW
								//////// INSERT TABLE objectband
								$divlist_tabla_gain_rftexto = trim($_REQUEST['divlist_tabla_gain_rftexto']);
								$array_band_rf = explode("#", $divlist_tabla_gain_rftexto);
								
								$Vidobjrev = 0; 
									foreach($array_band_rf as $ladandadedatos)
									{
								//	echo "El " . $ladandadedatos ;
										//2do explode
										////700 FirstNet|A|UL In|UL Out|85|33|DL In|UL Out|85|24|3|3|4|5|6|
										$array_datos_acargar_band_rf = explode("|", $ladandadedatos);
										if ($array_datos_acargar_band_rf[10] <>"")
										{
										//echo "******el0es:".$array_datos_acargar_band_rf[0]."----".$array_datos_acargar_band_rf[1]."******<br>";
											$sql = $connect->prepare("INSERT INTO public.objectband(ciu, idband, idportinul, idportoutul, idportindl, idportoutdl, dlgain, ulgain, dlmaxpwr, ulmaxpwr, class, ismodule, idproduct, idrev) VALUES (:modelciu, ".$array_datos_acargar_band_rf[10].", :idportinul, :idportoutul, :idportindl, :idportoutdl, :dlgain, :ulgain, :dlmaxpwr, :ulmaxpwr, '', false, :idproduct, :idrev);");
								
												$sql->bindParam(':modelciu', $vv_txtnewprod);
												////$sql->bindParam(':idband', $array_datos_acargar_band_rf[10]);
												$sql->bindParam(':idportinul', $array_datos_acargar_band_rf[11]);
												$sql->bindParam(':idportoutul', $array_datos_acargar_band_rf[12]);
												$sql->bindParam(':idportindl', $array_datos_acargar_band_rf[13]);
												$sql->bindParam(':idportoutdl', $array_datos_acargar_band_rf[14]);
												$sql->bindParam(':dlgain', $array_datos_acargar_band_rf[8]);
												$sql->bindParam(':ulgain', $array_datos_acargar_band_rf[4]);
												$sql->bindParam(':dlmaxpwr', $array_datos_acargar_band_rf[9]);
												$sql->bindParam(':ulmaxpwr', $array_datos_acargar_band_rf[5]);

												$sql->bindParam(':idproduct', $vvmaxidproduct);
												$sql->bindParam(':idrev',$Vidobjrev);
											
												$sql->execute();	
									 
												/*echo ':idband'.$array_datos_acargar_band_rf[10]."<br>";
												echo ':idportinul', $array_datos_acargar_band_rf[11]."<br>";
												echo ':idportoutul', $array_datos_acargar_band_rf[12]."<br>";
												echo ':idportindl', $array_datos_acargar_band_rf[13]."<br>";
												echo ':idportoutdl', $array_datos_acargar_band_rf[14]."<br>";
												*/
											}	
									
									}
	
							
									
							//////// FIN INSERT TABLE objectband
							//////// INSERT TABLE fastree
							$divlist_tabla_gain_rftexto = trim($_REQUEST['idmediacionaaasociar']);
							$array_medicionesareplicar = explode("*", $divlist_tabla_gain_rftexto);
							
							$cantmediciones = count($array_medicionesareplicar);
							if ($cantmediciones > 0)
							{
							
								// Insertamos Fas tree products
								$sql = $connect->prepare("INSERT INTO public.fas_tree_product(idfastree, idproduct, snproduct, active)VALUES (:idfastree,:idproduct,'',true);");
								$sql->bindParam(':idfastree', $vvmaxidtree);
								$sql->bindParam(':idproduct', $vvmaxidproduct);							
								$sql->execute();	

								
								// Insertamos fas tre products referentece


								foreach($array_medicionesareplicar as $ladandadedatosmed)
								{	
									$array_datos_mediciones = explode("#", $ladandadedatosmed);
								//	echo ':idtree'.$array_datos_mediciones[1]."<br>";
									//echo ':idtreefather'.$array_datos_mediciones[2]."<br>";
								//	echo ':idfastrepson'.$array_datos_mediciones[3]."<br>";
									$med = $array_datos_mediciones[2];
									$med2 = $array_datos_mediciones[3];
									
									$vvarmadoiduniqyebranch = $array_datos_mediciones[4];
									if ($array_datos_mediciones[2] <> "")
									{

									
									$sql = $connect->prepare("INSERT INTO public.fas_tree(idfastree, idfasstepfather, idfastrepson, iduniquebranch)	VALUES (:idfastree, :idfasstepfather, :idfastrepson, :iduniquebranch);");
									$sql->bindParam(':idfastree', $vvmaxidtree);
									$sql->bindParam(':idfasstepfather', $med );							
									$sql->bindParam(':idfastrepson', $med2);	
													
									$sql->bindParam(':iduniquebranch', $vvarmadoiduniqyebranch);							
									$sql->execute();
									
echo "sigo";
									$sql = $connect->prepare("INSERT INTO public.fas_tree_product_reference(idfastree, idproduct, iduniquebranch, nmeasures, reference1, reference2, reference3, reference4, reference5, reference6, reference7, reference8, idrev, idusermodif, datelastmodif) 	VALUES (:idfastree, :idproduct, :iduniquebranch, :nmeasures, :reference1, null, null, null, null, null, null, null, 0, :usermodif, now());");
									$sql->bindParam(':idfastree', $vvmaxidtree);
									$sql->bindParam(':idproduct', $vvmaxidproduct );																				
									$sql->bindParam(':iduniquebranch', $vvarmadoiduniqyebranch);	
								
									$vnmeasures = 11;
									$vvreference1 = 2;
									$sql->bindParam(':nmeasures', $vnmeasures);	
									$sql->bindParam(':reference1', $vvreference1);	
									$sql->bindParam(':usermodif', $viduserfas);
									$sql->execute();
								//	echo "pasooo";
								}

								}


							}
													
								
								
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
<?php
 include("db_conect.php"); 
  	session_start();
	include("funcionesstores.php"); 
	header('Content-Type: application/json');
	
	error_reporting(E_ALL);
		
	$vv_idmoduleprodflia = trim($_REQUEST['idmoduleprodflia']);	
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
						active, usermodif, datelastmodif, woparam, showdpxreport, idfamilygroup, idbusiness)
						VALUES (:idfamilyprod, :idtypeproduct, :idproduct, :idconfiguration, '-', :modelciu, :description, null, null,
						'Y', :usermodif, now(), false, false, :idfamilygroup, :idbusiness); ");
						$sql->bindParam(':idfamilyprod', $porciones_param[1]);
						$sql->bindParam(':idtypeproduct', $porciones_param[2]);
						$sql->bindParam(':idproduct', $vvmaxidproduct);
						$sql->bindParam(':idconfiguration', $vvidconfi);
						$sql->bindParam(':modelciu', $vv_txtnewprod);
						$sql->bindParam(':description', $vv_txtnewproddescr);
						$sql->bindParam(':usermodif', $vuserfas);
						$sql->bindParam(':idfamilygroup', $porciones_param[0]);
						$sql->bindParam(':idbusiness', $vv_txtbusiness);

						$sql->execute();
						
						
						$vvtxtrohsimg = trim($_REQUEST['txtrohsimg']);
						$vvtxtmadeinimg = trim($_REQUEST['txtmadeinimg']);
						$vvtxtmadein = trim($_REQUEST['txtmadein']);
						$txtflia = trim($_REQUEST['flia']);


						//, , , , , , etsi,  etlnumber, intertekimg
						$txtupwr = trim($_REQUEST['txtupwr']);
						$txtfcc = trim($_REQUEST['txtfcc']);
						$txtic = trim($_REQUEST['txtic']);
						$txtfccimg = trim($_REQUEST['txtfccimg']);
						$ulimg = trim($_REQUEST['txtulimg']);

						$txtetlnumber = trim($_REQUEST['txtetlnumber']);
						$txtintertek = trim($_REQUEST['txtintertek']);

						$txtetsi = trim($_REQUEST['txtetsi']);
								
				
						$sqllabel = $connect->prepare("	INSERT INTO public.products_label( idbusiness, idfamilygroup, idfamilyprod, idtypeproduct, idproduct, idconfiguration, ulpwrrat, madein, flia, fcc, ic, idlabel, active, description, fccimg, ulimg, rohsimg, madeinimg, etsi, idrev, etlnumber, intertekimg) 	
						                                                      VALUES (:idbusiness, :idfamilygroup, :idfamilyprod, :idtypeproduct, :idproduct, :idconfiguration, :ulpwrrat, :madein, :flia, :fcc, :ic, (select  coalesce (max(idlabel),0) + 1 from products_label) , 'Y', null, '".$txtfccimg."', ".$ulimg.", ".$vvtxtrohsimg.", ".$vvtxtmadeinimg.", '".$txtetsi."', 0, '".$txtetlnumber."', '".$txtintertek."');");
						
					
						$sqllabel->bindParam(':idbusiness', $vv_txtbusiness);
						$sqllabel->bindParam(':idfamilygroup', $porciones_param[0]);
						$sqllabel->bindParam(':idfamilyprod', $porciones_param[1]);
						$sqllabel->bindParam(':idtypeproduct', $porciones_param[2]);
						$sqllabel->bindParam(':idproduct', $vvmaxidproduct);
						$sqllabel->bindParam(':idconfiguration', $vvidconfi);						
						
						$sqllabel->bindParam(':madein', $vvtxtmadein);							
						$sqllabel->bindParam(':flia', $txtflia);						
						$sqllabel->bindParam(':ulpwrrat', $txtupwr);
						$sqllabel->bindParam(':fcc', $txtfcc);
						$sqllabel->bindParam(':ic', $txtic);						
						
				
					

						$sqllabel->execute();
						
					///	****** FALTA fas_tree_products
	
							
							// Insertamos auditoria 				  
				  				$vuserfas = $_SESSION["b"];
								$vdescripaudit="Create Module bda :".$vv_idmoduleprodflia."  - user:".$vuserfas;		
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
							
								
								$sql = $connect->prepare("INSERT INTO public.fas_confidential_fw(idfamilyprod, idtypeband, idtypeproduct, idciu, fpgafilename, microfilename, ethfilename, active, customfw, fpga_custom, micro_custom, eth_custom, fpga_fas, micro_fas, eth_fas, datelastmodif, usermodif, calrstring, idfamilygroup)	VALUES (:idfamilyprod, 0, :idtypeproduct, :idproduct, '".$txtfpga."', '".$txtuc."','".$txtether."', 'Y', '".$txttypeclassfw."', '".$txtfpgacus."', '".$txtuccus."', '".$txtethercus."', '', '', '', now(), :usermodif, null, :idfamilygroup);");
															
															$sql->bindParam(':idfamilygroup', $porciones_param[0]);
															$sql->bindParam(':idfamilyprod', $porciones_param[1]);
															$sql->bindParam(':idtypeproduct', $porciones_param[2]);
															$sql->bindParam(':idproduct', $vvmaxidproduct);
															$sql->bindParam(':usermodif', $vuserfas);
															$sql->execute();	
															
								
	
							////// fin TABLE FAS_CONFIDENCIAL_FW
							//////// INSERT TABLE FAS_CONFIDENCIAL_FW
											
							$txtgaintolerancebda = trim($_REQUEST['txtgaintolerancebda']);
							$txtmaxprwtolbda = trim($_REQUEST['txtmaxprwtolbda']);
							$txtimdlibda = trim($_REQUEST['txtimdlibda']);
							$txtnoisefbda = trim($_REQUEST['txtnoisefbda']);
							$txtspuriosbda = trim($_REQUEST['txtspuriosbda']);
	
											$sql = $connect->prepare("INSERT INTO public.fas_finalcheckref( ciu, gaintolerance, maxpwrtolerance, imdlimit, nfreference, spuriousreference, nmeasuresgain, nmeasuresmaxpwr, nmeasuresimd, nmeasuresnoisefloor, nemeasureslineality) VALUES (:modelciu, :gaintolerance, :maxpwrtolerance, :imdlimit, :nfreference, :spuriousreference, null,null, null, null, null);");
															
															$sql->bindParam(':modelciu', $vv_txtnewprod);
															$sql->bindParam(':gaintolerance', $txtgaintolerancebda);
															$sql->bindParam(':maxpwrtolerance', $txtmaxprwtolbda);
															$sql->bindParam(':imdlimit', $txtimdlibda);
															$sql->bindParam(':nfreference', $txtnoisefbda);															
															$sql->bindParam(':spuriousreference', $txtspuriosbda);
														
															$sql->execute();	

							//////// fin TABLE FAS_CONFIDENCIAL_FW
							//////// INSERT TABLE objectband
								$divlist_tabla_gain_rftexto = trim($_REQUEST['divlist_tabla_gain_rftexto']);
								$array_band_rf = explode("#", $divlist_tabla_gain_rftexto);
								
								
									foreach($array_band_rf as $ladandadedatos)
									{
								//	echo "El " . $ladandadedatos ;
										//2do explode
										////700 FirstNet|A|UL In|UL Out|85|33|DL In|UL Out|85|24|3|3|4|5|6|
										$array_datos_acargar_band_rf = explode("|", $ladandadedatos);
										if ($array_datos_acargar_band_rf[10] <>"")
										{
										//echo "******el0es:".$array_datos_acargar_band_rf[0]."----".$array_datos_acargar_band_rf[1]."******<br>";
											$sql = $connect->prepare("INSERT INTO public.objectband(ciu, idband, idportinul, idportoutul, idportindl, idportoutdl, dlgain, ulgain, dlmaxpwr, ulmaxpwr, class, ismodule) VALUES (:modelciu, ".$array_datos_acargar_band_rf[10].", :idportinul, :idportoutul, :idportindl, :idportoutdl, :dlgain, :ulgain, :dlmaxpwr, :ulmaxpwr, :class, false);");
								
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
												$sql->bindParam(':class', $array_datos_acargar_band_rf[1]);
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
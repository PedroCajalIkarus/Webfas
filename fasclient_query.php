<?php
	include("db_conect.php"); 
	header('Content-Type: application/json');	
	$idbb = $_POST['idb'];
	$idss = $_POST['ids'];
	$iduu = $_POST['idu'];	
	$idcust = $_POST['idaccionweb'];
	
	/* STATUS
	0 - para procesar..
	1 - Procesando
	2 - Exitoso
	3 - Error
	*/
	$return_result_insert="";
	$respuesta="";

	/// controlo estado del servidor
	if ($idcust == 0)
	{
		$sql ="INSERT INTO public.fas_petitions_server(
			idpetition, petitiontype, iduserfrom, iduserto, idstationto, instance, date, status, exitstatus, parameters1, parameters2, parameters3, idexterna)
			VALUES ((select COALESCE(max(idpetition),0) + 1 from fas_petitions_server), 0, ".$idbb.", ".$idss.", ".$iduu.",'04D0B3', now(), 0, null, null, null, null, null);";
			//	echo $sql;
					try {
						$connect->query($sql);
						
							
							
							 $sql2 = $connect->prepare("select max(idpetition) as madidpp from fas_petitions_server where petitiontype = 0 and iduserfrom = ".$iduu." and date >CURRENT_DATE ");
							$sql2->execute();
							$resultado_station = $sql2->fetchAll();				
							
								foreach ($resultado_station as $rowstation) 
								{
									$respuesta =$rowstation['madidpp'];
								}
								
							
								$return_result_insert="ok#".$respuesta;
								
								$vuserfas = $_SESSION["b"];
								$vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
								$vaccionweb="INSERT";
								$vdescripaudit=" Test Responde FASClient ".$iduu;	
								$vtextaudit=$sql;
							
								$sentenciaudit = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
										$sentenciaudit->bindParam(':userfas', $vuserfas);								
										$sentenciaudit->bindParam(':menuweb', $vmenufas);
										$sentenciaudit->bindParam(':actionweb', $vaccionweb);
										$sentenciaudit->bindParam(':descripaudit', $vdescripaudit);
										$sentenciaudit->bindParam(':textaudit', $vtextaudit);
										//$sentenciaudit->execute();
										
						} 
						catch (PDOException $e) 
						{
							
							$return_result_insert="error";
							$msjerr= "Syntax Error MM: ".$e->getMessage();
								
							
						}
						
				$respuesta=$return_result_insert;
			}
	/// inserto para SCAN DEVICE
	if ($idcust == 1)
	{
		
		
			$sql2pre = "update fas_petitions_server set status = 3, exitstatus ='Fas Client not response' where iduserfrom = ".$iduu." and status= 0";
			$connect->query($sql2pre);
			
		//$sql = "INSERT INTO fas_confidential_fw( idciu, fpga, micro, eth, active) 	VALUES (".$v_txtciu.", '".$v_txtfpga."','".$v_txtmicro."','".$v_txtehter."', 'true');";
			$sql ="INSERT INTO public.fas_petitions_server(
	idpetition, petitiontype, iduserfrom, iduserto, idstationto, instance, date, status, exitstatus, parameters1, parameters2, parameters3, idexterna)
	VALUES ((select COALESCE(max(idpetition),0) + 1 from fas_petitions_server), 1, ".$iduu.", ".$iduu.", ".$idss.",'03F', now(), 0, null, null, null, null, null);";
	//	echo $sql;
			try {
				$connect->query($sql);
				
					
					
					 $sql2 = $connect->prepare("select max(idpetition) as madidpp from fas_petitions_server where petitiontype = 1 and iduserfrom = ".$iduu." and date >CURRENT_DATE ");
					$sql2->execute();
					$resultado_station = $sql2->fetchAll();				
					
						foreach ($resultado_station as $rowstation) 
						{
							$respuesta =$rowstation['madidpp'];
						}
						
					
						$return_result_insert="ok#".$respuesta;
						
						$vuserfas = $_SESSION["b"];
						$vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
						$vaccionweb="INSERT";
						$vdescripaudit=" INSERT SCAN DEVICE usu:".$iduu;	
						$vtextaudit=$sql;
					
						$sentenciaudit = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
								$sentenciaudit->bindParam(':userfas', $vuserfas);								
								$sentenciaudit->bindParam(':menuweb', $vmenufas);
								$sentenciaudit->bindParam(':actionweb', $vaccionweb);
								$sentenciaudit->bindParam(':descripaudit', $vdescripaudit);
								$sentenciaudit->bindParam(':textaudit', $vtextaudit);
								//$sentenciaudit->execute();
								
				} 
				catch (PDOException $e) 
				{
					
					$return_result_insert="error";
					$msjerr= "Syntax Error MM: ".$e->getMessage();
						
					
				}
				
		$respuesta=$return_result_insert;
	}
		/// inserto para consultar si devolvio el scan device
	if ($idcust == 2)
	{
		$v_idppaaa = $_POST['idpp'];
		if( $v_idppaaa !="")
		{

			 if(is_numeric($v_idppaaa))
			 {
				 $sql = $connect->prepare("select *  from fas_petitions_server where  status in(0,2,3) and idpetition =".$v_idppaaa." and date >CURRENT_DATE and iduserfrom =  ".$iduu." and idstationto = ".$idss." order by date desc");
			 }
			 else
			 {
				// $sql = $connect->prepare("select *  from fas_petitions_server where  status = 2 and date >CURRENT_DATE and iduserfrom =  ".$iduu." and idstationto = ".$idss." order by date desc");	
			 }
			
		}
		else
		{
		//$sql = $connect->prepare("select *  from fas_petitions_server where  status = 2 and date >CURRENT_DATE and iduserfrom =  ".$iduu." and idstationto = ".$idss." order by date desc");	
		}
				   
		   
		$sql->execute();
		$resultado_station = $sql->fetchAll();							
		$usuario_con_idstation = "N";
		
		$respuesta = 0;
		foreach ($resultado_station as $rowstation) 
		{
			$respuesta =$rowstation['parameters2'];
			

		}
	
	
	
	//	$respuesta  = rand(5, 10);
		
	}
		/// inserto para ejecutar 
	if ($idcust == 3)
	{
			$parajson = $_POST['pjson'];
			
		$sql ="INSERT INTO public.fas_petitions_server(
	idpetition, petitiontype, iduserfrom, iduserto, idstationto, instance, date, status, exitstatus, parameters1, parameters2, parameters3, idexterna)
	VALUES ((select COALESCE(max(idpetition),0) + 1 from fas_petitions_server), 2, ".$iduu.", ".$iduu.", ".$idss.",'03F', now(), 0, null, '".$parajson."', null, null, null) ;";
	//	echo $sql;
			try {
				
				$connect->query($sql);
						
				 $sql2 = $connect->prepare("select max(idpetition) as madidpp,  idruninfo from fas_petitions_server where petitiontype = 2 and iduserfrom = ".$iduu." and date >CURRENT_DATE group by idruninfo order by madidpp asc");
					$sql2->execute();
					$resultado_station = $sql2->fetchAll();				
					
						foreach ($resultado_station as $rowstation) 
						{
							$respuesta =$rowstation['madidpp'];
							$respuestaidruninfo =$rowstation['idruninfo'];
						}

						////// -INSERTO ACA FAS PETITIONS DETAILS STP
						$query_lista ="SELECT * FROM public.fas_petitions_server where date > '2020-10-25' and instance = '03F' and parameters1 is not null and idpetition = ".$respuesta."	order by date";
					//echo $query_lista;
					$vvmaxidproduct=0;
						$data = $connect->query($query_lista)->fetchAll();	
							foreach ($data as $row) {			
							//   echo " <hr><br>HOLA".$row['parameters1'];
							   $objdd = json_decode($row['parameters1']);
							 //  echo "<br>Obj snsdib:".   $objdd->snsdib;
							   $obtsndib = json_decode( $objdd->snsdib ); 
							 //  echo "<br>Obj snsdib 1 :".   $objdd->snsdib[0];
							//    echo "---------------";
					
							   for ($x=0;$x<count($objdd->snsdib); $x++)
							   {
									//   echo "Idpetitios".$row['idpetition']."->".$objdd->snsdib[$x]."<br>";
									   // Buscamos los SN
								   
							
							   
							   $idagrupado = 0;
							   $idtempo = 0;
							 
							 // for ($xs=0;$xs<count($objdd->sns); $xs++)
							 //  {
									 //  echo "<br>SN:".$objdd->sns[$xs]."<br>";
									   // Buscamos los SN
									   $xs=$x;
									   for ($xsm=0;$xsm<count($objdd->sns[$xs]); $xsm++)
									   {
										 
									//	 echo "<br>SN:".$objdd->sns[$xs][$xsm]."<br>";
										 $elquery= "INSERT INTO public.fas_petitions_server_detailssfp( idfasserverdetails, datetimedet, snsdib, sndet, measuretime, scripttime, idgroupby, idpetition,reference)
											VALUES ((select coalesce(max(idfasserverdetails),0)+1 from fas_petitions_server_detailssfp), '".$row['date']."', '".$objdd->snsdib[$x]."', '".$objdd->sns[$xs][$xsm]."',".$objdd->measuretime." ,".$objdd->scripttime." , ".$idagrupado.", ".$row['idpetition'].",'sfp');";
					
									//	echo $elquery;
										$connect->query($elquery);
										if (  $idtempo == 1 )
										{
										$idtempo =   0;
										$idagrupado =  $idagrupado +1;
										}
										else
										{
										  //  $idagrupado = 0;
											$idtempo = 1 ;
										}
									   }
									   
							  // }
							}
						
							}
						/////// FIN
		
					$return_result_insert="ok#".$respuesta."#".$respuestaidruninfo;
					
						$vuserfas = $_SESSION["b"];
						$vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
						$vaccionweb="INSERT";
						$vdescripaudit=" INSERT SCAN DEVICE usu:".$iduu;	
						$vtextaudit=$sql;
					
						$sentenciaudit = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
								$sentenciaudit->bindParam(':userfas', $vuserfas);								
								$sentenciaudit->bindParam(':menuweb', $vmenufas);
								$sentenciaudit->bindParam(':actionweb', $vaccionweb);
								$sentenciaudit->bindParam(':descripaudit', $vdescripaudit);
								$sentenciaudit->bindParam(':textaudit', $vtextaudit);
								//$sentenciaudit->execute();
								
				} 
				catch (PDOException $e) 
				{
					
					$return_result_insert="error";
					$msjerr= "Syntax Error MM: ".$e->getMessage();
						
					
				}
				
		$respuesta=$return_result_insert;
	}
			/// inserto para Stop 
	if ($idcust == 4)
	{
			$v_idppaaa = $_POST['idpp'];
			
			$sql ="INSERT INTO public.fas_petitions_server(
	idpetition, petitiontype, iduserfrom, iduserto, idstationto, instance, date, status, exitstatus, parameters1, parameters2, parameters3, idexterna)
	VALUES ((select COALESCE(max(idpetition),0) + 1 from fas_petitions_server), 3, ".$iduu.", ".$iduu.", ".$idss.",'03F', now(), 0, null, null, null, null, ".$v_idppaaa.");";
	//	echo $sql;
			try {
				$connect->query($sql);
					$return_result_insert="ok";
					
						$vuserfas = $_SESSION["b"];
						$vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
						$vaccionweb="INSERT";
						$vdescripaudit=" INSERT SCAN DEVICE usu:".$iduu;	
						$vtextaudit=$sql;
					
						$sentenciaudit = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
								$sentenciaudit->bindParam(':userfas', $vuserfas);								
								$sentenciaudit->bindParam(':menuweb', $vmenufas);
								$sentenciaudit->bindParam(':actionweb', $vaccionweb);
								$sentenciaudit->bindParam(':descripaudit', $vdescripaudit);
								$sentenciaudit->bindParam(':textaudit', $vtextaudit);
								//$sentenciaudit->execute();
								
				} 
				catch (PDOException $e) 
				{
					
					$return_result_insert="error";
					$msjerr= "Syntax Error MM: ".$e->getMessage();
						
					
				}
				
		$respuesta=$return_result_insert;
	}
	
	if ($idcust == 5)
	{
	$v_idppaaa = $_POST['idpp'];
			
		try {
				 $sql2 = $connect->prepare("select idpetition as madidpp, exitstatus,  idruninfo from fas_petitions_server where petitiontype = 2 and iduserfrom = ".$iduu." and idpetition= ".$v_idppaaa);
					$sql2->execute();
					$resultado_station = $sql2->fetchAll();				
					
						foreach ($resultado_station as $rowstation) 
						{
							$respuesta =$rowstation['madidpp'];
							$respuestaidruninfo =$rowstation['idruninfo'];
							$respuestaerro =$rowstation['exitstatus'];
						}
		
					$return_result_insert="ok#".$respuesta."#".$respuestaidruninfo."#".$respuestaerro;
					
								
				} 
				catch (PDOException $e) 
				{
					
					$return_result_insert="error";
					$msjerr= "Syntax Error MM: ".$e->getMessage();
						
					
				}
				
		$respuesta=$return_result_insert;
	}
	
	if ($idcust == 6)
	{
	$v_idppaaa = $_POST['idpp'];
			
		try {
				 $sql2 = $connect->prepare("update fas_petitions_server set status = 3, exitstatus ='Fas Client not response'  where iduserfrom = ".$iduu." and idpetition= ".$v_idppaaa);
					$sql2->execute();
					$resultado_station = $sql2->fetchAll();				
					
							
					$return_result_insert="ok#".$respuesta."#".$respuestaidruninfo."#".$respuestaerro;
					
								
				} 
				catch (PDOException $e) 
				{
					
					$return_result_insert="error";
				
					$msjerr= "Syntax Error MM: ".$e->getMessage();
						
					
				}
				
		$respuesta=$return_result_insert;
	}


//// INSERTO LABEL PARA IMPRIMIR
	if ($idcust == 7)
	{
		$viduuto = $_POST['iduserto'];
		$vidbranch = $_POST['idbranch'];
		$_vparamjson1 = $_POST['parajson1'];
		$idquantitybybranh =  $_POST['idquantitybybranh'];
		$iduu = $_POST['idu'];	

		$idsnbybranh =  $_POST['idsnbybranh'];
		$idciubybranh =  $_POST['idciubybranh'];

		//Auto timer marco // Pedido por Lea para que no se vuelva loco el FAS
		$sqltemplatejson2 = $connect->prepare("SELECT COUNT(*) FROM fas_tree_measure");
		$sqltemplatejson2->execute();
		//Auto timer marco
			//Auto timer marco
			$sqltemplatejson2 = $connect->prepare("SELECT COUNT(*) FROM fas_tree_measure");
			$sqltemplatejson2->execute();
			//Auto timer marco

///////////////////////BUSCAMOS UN TEMPLATEE ////////////////////////////////////////
	$sqltemplatejson = $connect->prepare("select * from fas_printlbl_template where instance  = '".$vidbranch."' ");
	$sqltemplatejson->execute();
	$resultado_json = $sqltemplatejson->fetchAll();				

	foreach ($resultado_json as $rowjson) 
	{
		$template_a_remmplajar =$rowjson['templatejson'];
	
	}
//	echo  "<br>".$template_a_remmplajar;

	$template_a_remmplajar = str_replace("#quantity",	$idquantitybybranh,$template_a_remmplajar);
	$template_a_remmplajar = str_replace("#ciu",	$idciubybranh,$template_a_remmplajar);
	$template_a_remmplajar = str_replace("#sn",	$idsnbybranh,$template_a_remmplajar);
//	echo  "<br>modificado:".$template_a_remmplajar;
////////////////////// FIN BUSCAMOS UN TEMPLATE /////////////////////////////////////
$_vparamjson1 = $template_a_remmplajar;
		
$sql ="INSERT INTO public.fas_petitions_server(
	idpetition, petitiontype, iduserfrom, iduserto, idstationto, instance, date, status, exitstatus, parameters1, parameters2, parameters3, idexterna)
	VALUES ((select COALESCE(max(idpetition),0) + 1 from fas_petitions_server), 2, ".$viduuto.", ".$iduu.", ".$idss.",'".trim($vidbranch)."', now(), 0, null, '".$_vparamjson1."', null, null, null);";

	//	echo $sql;
			try {
				$connect->query($sql);
				
				
				 $sql2 = $connect->prepare("select max(idpetition) as madidpp,  idruninfo from fas_petitions_server where petitiontype = 4 and iduserfrom = ".$iduu." and date >CURRENT_DATE group by idruninfo order by madidpp asc");
					$sql2->execute();
					$resultado_station = $sql2->fetchAll();				
					
						foreach ($resultado_station as $rowstation) 
						{
							$respuesta =$rowstation['madidpp'];
							$respuestaidruninfo =$rowstation['idruninfo'];
						}
		
					$return_result_insert="ok#".$respuesta."#".$respuestaidruninfo;
					
					
						$vuserfas = $_SESSION["b"];
						$vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
						$vaccionweb="INSERT";
						$vtextaudit=$sql;
						$vdescripaudit=" INSERT LABEL_Print  usu:".$iduu;	
					
						$sentenciaudit = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
								$sentenciaudit->bindParam(':userfas', $vuserfas);								
								$sentenciaudit->bindParam(':menuweb', $vmenufas);
								$sentenciaudit->bindParam(':actionweb', $vaccionweb);
								$sentenciaudit->bindParam(':descripaudit', $vdescripaudit);
								$sentenciaudit->bindParam(':textaudit', $vtextaudit);
								//$sentenciaudit->execute();
								
				} 
				catch (PDOException $e) 
				{
					
					$return_result_insert="error";
					$msjerr= "Syntax Error MM: ".$e->getMessage();
						
					
				}
				
		$respuesta=$return_result_insert;
	}
	//// Esperar confirmacion de  LABEL  IMPRwao
	if ($idcust == 8)
	{
			$v_idppaaa = $_POST['idpp'];
			
		try {
				 $sql2 = $connect->prepare("select idpetition as madidpp, exitstatus,  idruninfo from fas_petitions_server where petitiontype = 4 and iduserfrom = ".$iduu." and idpetition= ".$v_idppaaa);
					$sql2->execute();
					$resultado_station = $sql2->fetchAll();				
					
						foreach ($resultado_station as $rowstation) 
						{
							$respuesta =$rowstation['madidpp'];
							$respuestaidruninfo =$rowstation['idruninfo'];
							$respuestaerro =$rowstation['exitstatus'];
						}
		
					$return_result_insert="ok#".$respuesta."#".$respuestaidruninfo."#".$respuestaerro;
					
								
				} 
				catch (PDOException $e) 
				{
					
					$return_result_insert="error";
					$msjerr= "Syntax Error MM: ".$e->getMessage();
						
					
				}
				
		$respuesta=$return_result_insert;
	}
	
		/// inserto para ejecutar  CALSTRING
	if ($idcust == 9)
	{
			$parajson = $_POST['pjson'];
			
		$sql ="INSERT INTO public.fas_petitions_server(
	idpetition, petitiontype, iduserfrom, iduserto, idstationto, instance, date, status, exitstatus, parameters1, parameters2, parameters3, idexterna)
	VALUES ((select COALESCE(max(idpetition),0) + 1 from fas_petitions_server), 2, ".$iduu.", ".$iduu.", ".$idss.",'04D04E', now(), 0, null, '".$parajson."', null, null, null) ;";
	//	echo $sql;
			try {
				
				$connect->query($sql);
						
				 $sql2 = $connect->prepare("select max(idpetition) as madidpp,  idruninfo from fas_petitions_server where petitiontype = 2 and iduserfrom = ".$iduu." and date >CURRENT_DATE group by idruninfo order by madidpp asc");
					$sql2->execute();
					$resultado_station = $sql2->fetchAll();				
					
						foreach ($resultado_station as $rowstation) 
						{
							$respuesta =$rowstation['madidpp'];
							$respuestaidruninfo =$rowstation['idruninfo'];
						}
		
					$return_result_insert="ok#".$respuesta."#".$respuestaidruninfo;
					
						$vuserfas = $_SESSION["b"];
						$vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
						$vaccionweb="INSERT";
						$vdescripaudit=" INSERT SCAN DEVICE usu:".$iduu;	
						$vtextaudit=$sql;
					
						$sentenciaudit = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
								$sentenciaudit->bindParam(':userfas', $vuserfas);								
								$sentenciaudit->bindParam(':menuweb', $vmenufas);
								$sentenciaudit->bindParam(':actionweb', $vaccionweb);
								$sentenciaudit->bindParam(':descripaudit', $vdescripaudit);
								$sentenciaudit->bindParam(':textaudit', $vtextaudit);
								//$sentenciaudit->execute();
								
				} 
				catch (PDOException $e) 
				{
					
					$return_result_insert="error";
					$msjerr= "Syntax Error MM: ".$e->getMessage();
						
					
				}
				
		$respuesta=$return_result_insert;
	}	
	///10 Esperar la confirmacion que esta online fas3 

	if ($idcust == 10)
	{
	$v_idppaaa = $_POST['idpp'];
			
		try {
				 $sql2 = $connect->prepare("select idpetition as madidpp, status,  exitstatus,  idruninfo from fas_petitions_server where petitiontype = 0 and iduserfrom = ".$iduu." and idpetition= ".$v_idppaaa);
					$sql2->execute();
					$resultado_station = $sql2->fetchAll();				
					$vvstatus="";
						foreach ($resultado_station as $rowstation) 
						{
							$respuesta =$rowstation['madidpp'];
							if ($rowstation['status']==2)
							{
								$vvstatus =$rowstation['status'];
							}
							
							$respuestaerro =$rowstation['exitstatus'];
						}
		
					$return_result_insert="ok#".$vvstatus."#".$respuestaerro;
					
								
				} 
				catch (PDOException $e) 
				{
					
					$return_result_insert="error";
					$msjerr= "Syntax Error MM: ".$e->getMessage();
						
					
				}
				
		$respuesta=$return_result_insert;
	}


	 echo(json_encode($respuesta));

?>
<?php
error_reporting(0);
  include("db_conect.php");
  header('Content-Type: application/json');
 
	
////				data: "idsoorig="+idsoorig+'&idsodestno='+idsodestno+'&sn='+sn+'&idprodorig='+idprodorig,		

			$idsoorig = $_REQUEST['idsoorig'];
			$idsodestno = $_REQUEST['idsodestno'];
			$sn = $_REQUEST['sn'];
			$idprodorig = $_REQUEST['idprodorig'];
			$soorig = $_REQUEST['soorig'];
		 

			$vuserfas = $_SESSION["b"];
						
			$vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
			$vaccionweb="upgrade sn";
	
			$vdescripaudit="SELECT idorders, idcustomers, idfamilyprod, idtypeband, idtypeproduct, idproduct, idconfiguration, idrev, max(idnroserie) + 1, so_soft_external,'".$sn."',  idruninfo, ponumber, pwrsupplytype, rcgfbwa, moden_dig, date_approved, descripcion, ul_gain, ul_max_pwr, dl_gain, dl_max_pwr, req_ppassy, req_calibration, req_spec, req_other, nameapproved, notes, reqresources, typeregister, processday, processfasserver, so_original,".$soorig.", availablesn
			FROM public.orders_sn where orders_sn.idorders = ".$idsodestno." group by  idorders, idcustomers, idfamilyprod, idtypeband, idtypeproduct, idproduct, idconfiguration, idrev,so_soft_external,idruninfo, ponumber, pwrsupplytype, rcgfbwa, moden_dig, date_approved, descripcion, ul_gain, ul_max_pwr, dl_gain, dl_max_pwr, req_ppassy, req_calibration, req_spec, req_other, nameapproved, notes, reqresources, typeregister, processday, processfasserver, so_original,availablesn";		
			$vtextaudit="Upgrade SN ".$sn." - idsoorig:".$idsoorig." - idsodestno".$idsodestno." - idprodorig".$idprodorig." - soorig ".$soorig;

		 

	
		  $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connect->beginTransaction();
	
		 try {

			
			$sentenciach = $connect->prepare("insert into orders_sn SELECT idorders, idcustomers, idfamilyprod, idtypeband, idtypeproduct, idproduct, idconfiguration, idrev, max(idnroserie) + 1, so_soft_external,:sn, idruninfo, ponumber, pwrsupplytype, rcgfbwa, moden_dig, date_approved, descripcion, ul_gain, ul_max_pwr, dl_gain, dl_max_pwr, req_ppassy, req_calibration, req_spec, req_other, nameapproved, notes, reqresources, typeregister, processday, processfasserver, so_original, :so_associed, availablesn
			FROM public.orders_sn where orders_sn.idorders = :idorders group by  idorders, idcustomers, idfamilyprod, idtypeband, idtypeproduct, idproduct, idconfiguration, idrev,so_soft_external,idruninfo, ponumber, pwrsupplytype, rcgfbwa, moden_dig, date_approved, descripcion, ul_gain, ul_max_pwr, dl_gain, dl_max_pwr, req_ppassy, req_calibration, req_spec, req_other, nameapproved, notes, reqresources, typeregister, processday, processfasserver, so_original,availablesn");
								
			$sentenciach->bindParam(':idorders', $idsodestno);								
			$sentenciach->bindParam(':sn', $sn);
			$sentenciach->bindParam(':so_associed', $soorig);		
			$sentenciach->execute();
									
			
			$sentenciaorsn = $connect->prepare("update orders_sn set typeregister= 'UP'  where idorders = :idorders ");								
			$sentenciaorsn->bindParam(':idorders', $idsodestno);											 
			$sentenciaorsn->execute();

			$sentenciaor = $connect->prepare("update orders set typeregister= 'UP'  where idorders = :idorders ");								
			$sentenciaor->bindParam(':idorders', $idsodestno);											 
			$sentenciaor->execute();

			$sentenciaudit = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
			$sentenciaudit->bindParam(':userfas', $vuserfas);								
			$sentenciaudit->bindParam(':menuweb', $vmenufas);
			$sentenciaudit->bindParam(':actionweb', $vaccionweb);
			$sentenciaudit->bindParam(':descripaudit', $vdescripaudit);
			$sentenciaudit->bindParam(':textaudit', $vtextaudit);
			$sentenciaudit->execute();


			

		
			$connect->commit();			
			$return_result_insert="ok"; 
			$msjerr= "";
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
<?php
    error_reporting(0);
    

		  
	include("db_conect_login.php"); 	
	header('Content-Type: application/json');
	

    $return_arr = array();
	
	//http://srv-pgsql.fiplex.com/webfas/lockeraccion.php?v1=001&v2=192.167.0.22&v3=TRUE&v4=AGUSRF234534535353a&v5=MAM345353453453FN&v6=C3534534534534rC&v7=16.26crcmarco&v8=1
	
		$sql = $connect->prepare("select count(idpresales) as cc from  presales ");
  
		$vconcero=0;
		$v0 = $_REQUEST['v0']; ///$vidcustomer
		$v1 = $_REQUEST['v1']; ///idruninfo
		$v2 = strtolower($_REQUEST['v2']); // ipomac
		$v3 = strtolower($_REQUEST['v3']); //lookstatus  (Boolean)
		$v4 = strtolower($_REQUEST['v4']); // fpga
		$v5 = strtolower($_REQUEST['v5']); // snunit
		$v6 = $_REQUEST['v6']; //crc   (Boolean)
		$v7 = $_REQUEST['v7']; //crc marco
		$v8 = $_REQUEST['v8']; //typescritp  0 DIG MOD - 1 : CaliB - 2 FINAL CHECK
		$v9 = strtoupper($_REQUEST['v9']); //Permanent Lock
		$v10 = strtoupper($_REQUEST['v10']); //Permanent Lock
		
			$sql->execute();
					$resultado = $sql->fetchAll();
					 foreach ($resultado as $row) {
						$vmaxid= $row['cc']+1;
						
					 }
		
		
			/*		
			$checksumm = crc32( substr($v4,-2,2))."".crc32(date('yy'))."".crc32($v4)."".crc32($v5)."".crc32(date('m/d'))."".crc32(substr($v5,-2,2));
			$chkcrcm="false";
			if ($v7 == $checksumm)
			{
				$chkcrcm="true";
			}
			*/
		$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connect->beginTransaction();
			 try {
					//$connect->query($sql);
					$lafecha="now()";
					$sentencia = $connect->prepare("INSERT INTO presales(idpresales, idcustomers, idfamilyprod, idtypeband, idtypeproduct, idproduct, idconfiguration, ciu, idrev, so_soft_external,  ponumber, pwrsupplytype, rcgfbwa, moden_dig, ul_start, ul_stop, dl_start, dl_stop, date_approved, descripcion, ul_gain, ul_max_pwr, dl_gain, dl_max_pwr, dpx_low_pass_start, dpx_low_pass_stop, dpx_high_pass_start, dpx_high_pass_stop, req_ppassy, req_calibration, req_spec, req_other, nameapproved) VALUES (:idpresales, :idcustomers, :idfamilyprod, :idtypeband, :idtypeproduct, :idproduct, :idconfiguration, :ciu, :idrev, :so_soft_external, :idruninfo, :ponumber, :pwrsupplytype, :rcgfbwa, :moden_dig, :ul_start, :ul_stop, :dl_start, :dl_stop, :date_approved, :descripcion, :ul_gain, :ul_max_pwr, :dl_gain, :dl_max_pwr, :dpx_low_pass_start, :dpx_low_pass_stop, :dpx_high_pass_start, :dpx_high_pass_stop, :req_ppassy, :req_calibration, :req_spec, :req_other, :nameapproved);");
					
					
					//(:idpresales, :idcustomers, :idfamilyprod, :idtypeband, :idtypeproduct, :idproduct, :idconfiguration, :ciu, :idrev, :so_soft_external,  :ponumber,
					//	:pwrsupplytype, :rcgfbwa, :moden_dig, :ul_start, :ul_stop, :dl_start, :dl_stop, :date_approved, :descripcion, :ul_gain, :ul_max_pwr, :dl_gain, :dl_max_pwr, :dpx_low_pass_start,
					//:dpx_low_pass_stop, :dpx_high_pass_start, :dpx_high_pass_stop, :req_ppassy, :req_calibration, :req_spec, :req_other, :nameapproved);
					$sentencia->bindParam(':idpresales', $vmaxid);
					$sentencia->bindParam(':idcustomers', $v0);
					$sentencia->bindParam(':idfamilyprod', $vconcero);
					$sentencia->bindParam(':idtypeband', $vconcero);
					$sentencia->bindParam(':idtypeproduct', $vconcero);
					$sentencia->bindParam(':idproduct', $v1);
					$sentencia->bindParam(':idconfiguration', $vconcero);
					$sentencia->bindParam(':ciu', $lafecha);
					$sentencia->bindParam(':idrev', $vconcero);
					$sentencia->bindParam(':so_soft_external', $vconcero);
					$sentencia->bindParam(':ponumber', $v8);
					
					$sentencia->bindParam(':pwrsupplytype', $v9);
					$sentencia->bindParam(':rcgfbwa', $v10);
					$sentencia->bindParam(':moden_dig', $v10);
					$sentencia->bindParam(':ul_start', $v10);
					$sentencia->bindParam(':ul_stop', $v10);
					$sentencia->bindParam(':dl_start', $v10);
					$sentencia->bindParam(':dl_stop', $v10);
					$sentencia->bindParam(':date_approved', $v10);
					
					$sentencia->bindParam(':descripcion', $v10);
					$sentencia->bindParam(':ul_gain', $v10);
					$sentencia->bindParam(':ul_max_pwr', $v10);
					$sentencia->bindParam(':dl_gain', $v10);
					$sentencia->bindParam(':dl_max_pwr', $v10);
					$sentencia->bindParam(':dpx_low_pass_start', $v10);
					
					$sentencia->bindParam(':dpx_low_pass_stop', $v10);
					$sentencia->bindParam(':dpx_high_pass_start', $v10);
					$sentencia->bindParam(':dpx_high_pass_stop', $v10);
					$sentencia->bindParam(':req_ppassy', $v10);
					$sentencia->bindParam(':req_calibration', $v10);
					$sentencia->bindParam(':req_spec', $v10);
					$sentencia->bindParam(':req_other', $v10);
					$sentencia->bindParam(':nameapproved', $v10);
					
					
					$sentencia->execute();
					$return_result_insert="ok";
				    $connect->commit();
				} 
				catch (PDOException $e) 
				{
					$connect->rollBack();
					$return_result_insert="error";
					$msjerr= "Syntax Error MM: ".$e->getMessage();
				}
	}	
		
echo(json_encode(["result"=>$return_result_insert]));


?>


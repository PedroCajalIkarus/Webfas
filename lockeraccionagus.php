<?php
    error_reporting(0);
    echo "a";

	include("db_conect_login.php"); 	
	header('Content-Type: application/json');
	
	
	$query_lista ="INSERT INTO lockerlog(idlockerlog, unitsn, fpga, crc, lookstatus, ip_mac, idruninfo, datelocket)	VALUES (?, ?, ?, ?, ?, ?, ?, ?);";

    $return_arr = array();
	
	//http://srv-pgsql.fiplex.com/webfas/lockeraccion.php?v1=001&v2=192.167.0.22&v3=TRUE&v4=AGUSRF234534535353a&v5=MAM345353453453FN&v6=C3534534534534rC&v7=16.26crcmarco&v8=1
	
	$sql = $connect->prepare("select count(idlockerlog) as cc from  lockerlog ");
  
	
	$v0 = $_REQUEST['v0']; ///testconexion
	if ($v0 == "0")
	{
			 try {
				    $sql->execute();
					$resultado = $sql->fetchAll();
					 foreach ($resultado as $row) {
						$vmaxid= $row['cc']+1;
						$return_result_insert="connection";
					 }
				 
				 } 
				catch (PDOException $e) 
				{
					
					$return_result_insert="error";
					$msjerr= "Syntax Error MM: ".$e->getMessage();
						
					
				}
	}
/*	else
	{	
		
		$v1 = $_REQUEST['v1']; ///idruninfo
		$v2 = strtolower($_REQUEST['v2']); // ipomac
		$v3 = strtolower($_REQUEST['v3']); //lookstatus  (Boolean)
		$v4 = strtolower($_REQUEST['v4']); // fpga
		$v5 = strtolower($_REQUEST['v5']); // snunit
		$v6 = $_REQUEST['v6']; //crc   (Boolean)
		$v7 = $_REQUEST['v7']; //crc marco
		$v8 = $_REQUEST['v8']; //typescritp  0 DIG MOD - 1 : CaliB - 2 FINAL CHECK
		$v9 = strtolower($_REQUEST['v9']); //Permanent Lock
		$v10 = strtolower$_REQUEST['v10']); //Permanent Lock
		
			$sql->execute();
					$resultado = $sql->fetchAll();
					 foreach ($resultado as $row) {
						$vmaxid= $row['cc']+1;
						
					 }
		
			$checksumm = crc32( substr($v4,-2,2))."".crc32(date('yy'))."".crc32($v4)."".crc32($v5)."".crc32(date('m/d'))."".crc32(substr($v5,-2,2));
			$chkcrcm="false";
			if ($v7 == $checksumm)
			{
				$chkcrcm="true";
			}
	//	$sql = "INSERT INTO products_labeling(ciu, ulpwrrat, madein, flia, fcc, ic, etsi, idlabel, active) VALUES  ('".$sheetA."','".$sheetB."','".$sheetC."','".$sheetD."','".$sheetE."','".$sheetF."','".$sheetG."',(select COALESCE(max(idlabel),0) + 1 from products_labeling),'true');";
	//	$sql ="INSERT INTO lockerlog(idlockerlog, unitsn, fpga, crc, lookstatus, ip_mac, idruninfo, datelocket, crcm, crcmv,typescript)
	//	                     VALUES (".$vmaxid.",'".$v5."', '".$v4."','".strtoupper ($v6)."', '".strtoupper($v3)."', '".$v2."', ".$v1.",now(), '".$v7."',".$chkcrcm.",".$v8.");";
//echo $sql;

		$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connect->beginTransaction();
			 try {
					
					///$connect->query($sql);
					$lafecha="now()";
					$sentencia = $connect->prepare("INSERT INTO lockerlog( idlockerlog, unitsn, fpga, crc, lookstatus, ip_mac, idruninfo, datelocket, crcm, crcmv, typescript, permanentlock, statusCheck)  VALUES (:idlockerlog, :unitsn, :fpga, :crc, :lookstatus, :ip_mac, :idruninfo, :datelocket, :crcm, :crcmv,:typescript,:permanentlock, :statusCheck)");
					$sentencia->bindParam(':idlockerlog', $vmaxid);
					$sentencia->bindParam(':unitsn', $v5);
					$sentencia->bindParam(':fpga', $v4);
					$sentencia->bindParam(':crc', $v6);
					$sentencia->bindParam(':lookstatus', $v3);
					$sentencia->bindParam(':ip_mac', $v2);
					$sentencia->bindParam(':idruninfo', $v1);
					$sentencia->bindParam(':datelocket', $lafecha);
					$sentencia->bindParam(':crcm', $v7);
					$sentencia->bindParam(':crcmv', $chkcrcm);
					$sentencia->bindParam(':typescript', $v8);
					
					$sentencia->bindParam(':permanentlock', $v9);
					$sentencia->bindParam(':statusCheck', $v10);
					
					
				

// insertar una fila

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
		
		/// CRC2 MARCO
		 /// Concatenar  CRC32(right(2 del FPGA)) CRC32(date(yyyy))+CRC32(fpga (solonumeros))+ CRC32(snunit (solonumeros))+ CRC32("mm/dd")+ CRC32(right(2 del sn unit)); 


//printf("%u\n", $checksum);
///echo  " --> crc32:".$checksum."----".date('m/d');
*/	
echo(json_encode(["result"=>$return_result_insert]));
 
 
 
 
 



?>


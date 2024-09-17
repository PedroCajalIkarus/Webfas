<?php
    error_reporting(-1);
    
	include("db_conect_login.php"); 	
	header('Content-Type: application/json');
		
	
	$query_lista ="INSERT INTO lockerlog(idlockerlog, unitsn, fpga, crc, lookstatus, ip_mac, idruninfo, datelocket)	VALUES (?, ?, ?, ?, ?, ?, ?, ?);";

    $return_arr = array();
	
	//http://192.168.70.241/lockeraccion.php?v1=idruninfo&v2=ipomac&v3=lookstatus&v4=fpga&v5=snunit&v6=CrC&v7=crcmarco
	//http://webfas.fiplex.com/lockeraccion.php?v1=idruninfo&v2=ipomac&v3=lookstatus&v4=fpga&v5=snunit&v6=CrC&v7=crcmarco
	$sql = $connect->prepare("select count(idlockerlog) as cc from  lockerlog ");
    $sql->execute();
    $resultado = $sql->fetchAll();
	 foreach ($resultado as $row) {
		$vmaxid= $row['cc']+1;
		
	 }
	
	
		
		$v1 = $_REQUEST['v1']; ///idruninfo
		$v2 = strtolower($_REQUEST['v2']); // ipomac
		$v3 = strtolower($_REQUEST['v3']); //lookstatus
		$v4 = strtolower($_REQUEST['v4']); // fpga
		$v5 = strtolower($_REQUEST['v5']); // snunit
		$v6 = $_REQUEST['v6']; //crc 
		$v7 = $_REQUEST['v7']; //crc marco
		
			$checksumm = crc32( substr($v4,-2,2))."".crc32(date('yy'))."".crc32($v4)."".crc32($v5)."".crc32(date('m/d'))."".crc32(substr($v5,-2,2));
			
		//	echo $checksumm;
			$chkcrcm="false";
			if ($v7 == $checksumm)
			{
				$chkcrcm="true";
			}
	//	$sql = "INSERT INTO products_labeling(ciu, ulpwrrat, madein, flia, fcc, ic, etsi, idlabel, active) VALUES  ('".$sheetA."','".$sheetB."','".$sheetC."','".$sheetD."','".$sheetE."','".$sheetF."','".$sheetG."',(select COALESCE(max(idlabel),0) + 1 from products_labeling),'true');";
	//	$sql ="INSERT INTO lockerlog(idlockerlog, unitsn, fpga, crc, lookstatus, ip_mac, idruninfo, datelocket, crcm, crcmv)  VALUES (".$vmaxid.",'".$v5."', '".$v4."','".$v6."', '".$v3."', '".$v2."', ".$v1.",now(), '".$v7."',".$chkcrcm.");";
							 
							 
//echo $sql;

  $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $connect->beginTransaction();
			 try {
				//	$connect->query($sql);
					$return_result_insert="ok";
					$lafecha="now()";
						//$sentencia = $connect->prepare("INSERT INTO testmarco (namem, valuem) VALUES (:name, :value)");
						$sentencia = $connect->prepare("INSERT INTO lockerlog (idlockerlog, unitsn, fpga, crc, lookstatus, ip_mac, idruninfo, datelocket, crcm, crcmv)  VALUES (:idlockerlog, :unitsn, :fpga, :crc, :lookstatus, :ip_mac, :idruninfo, :datelocket, :crcm, :crcmv)");
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

		// insertar una fila
	
		$sentencia->execute();

					
					
					 $connect->commit();
				} 
				catch (PDOException $e) 
				{
					  $connect->rollBack();
					$return_result_insert="error";
					$msjerr= "Syntax Error MM: ".$e->getMessage();
						
					
				}
		
		
		
		/// CRC2 MARCO
		 /// Concatenar  CRC32(right(2 del FPGA)) CRC32(date(yyyy))+CRC32(fpga (solonumeros))+ CRC32(snunit (solonumeros))+ CRC32("mm/dd")+ CRC32(right(2 del sn unit)); 


//printf("%u\n", $checksum);
//echo  " --> crc32:".$checksum."----".date('m/d');
//echo $msjerr;
	
echo(json_encode(["result"=>$return_result_insert]));
 
 
 
 
 



?>

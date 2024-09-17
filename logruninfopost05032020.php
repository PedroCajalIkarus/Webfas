<?php
//    error_reporting(0);
	include("db_conect_login.php"); 	
	header('Content-Type: application/json');
	

    $return_arr = array();
	$v0 = $_REQUEST['v0']; ///testconexion
	
	if ($v0 == "0")
	{
			 try {
				 	$sql = $connect->prepare("select idlockerlog as cc from  lockerlog limit 2 ");
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
			//	echo "connection";
	}
	if ($v0 == "1")
	{	
		$v1 = $_REQUEST['v1']; ///idbusiness
		$sql = $connect->prepare("select CAST (concat(right(concat(0,buf.idbusiness),2) ,right(concat(0,bs.idstation),2), right(concat(0,buf.iduserfas),2),right( concat(0,0,0,0,0,0,(maxidruninfo+1)),6)) as bigint) as ccidbingit from userfas inner join business_userfas as buf on userfas.iduserfas = buf.iduserfas	inner join business on business.idbusiness = buf.idbusiness inner join business_station as bs on buf.idbusiness = bs.idbusiness and bs.typestation = 'server' where bs.idbusiness = ".$v1." and buf.iduserfas =21 ");
		 try {
				    $sql->execute();
					$resultado = $sql->fetchAll();
					 foreach ($resultado as $row) {
						$vmaxid= $row['ccidbingit']+1;
						$return_result_insert=$vmaxid;
					 }
				 
				 } 
				catch (PDOException $e) 
				{
					
					$return_result_insert="error";
					$msjerr= "Syntax Error MM: ".$e->getMessage();
						
					
				}
	}	

	if ($v0 == "2")
	{	
		
		$v1 = $_REQUEST['v1']; ///idruninfo
		$v2 = strtolower($_REQUEST['v2']); // dateinfo
		$v3 = strtolower($_REQUEST['v3']); //userruninfo
		$v4 = strtolower($_REQUEST['v4']); // station
		$v5 = strtolower($_REQUEST['v5']); // device
		$v6 = strtolower($_REQUEST['v6']); //script
		$v7 = $_REQUEST['v7']; //fasver
		$v8 = $_REQUEST['v8']; //loginfo
		$v9 = $_REQUEST['v9']; ///idruninfoDB
	
			$sql_busca = $connect->prepare("select idruninfo from runinfodb where idruninfodb = ".$v9 );
			$sql_busca->execute();
			$exite_idnube = "N";
					$resultado_busca = $sql_busca->fetchAll();
					 foreach ($resultado_busca as $rowbusca) {
							$exite_idnube = "Y";
					 }
		
	
		
		$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connect->beginTransaction();
			 try {
					
					
					
					if ($exite_idnube == "N")
					{
						//$connect->query($sql);
						$lafecha="now()";
						$sentencia = $connect->prepare("INSERT INTO runinfodb (idruninfo,dateinfo,userruninfo,station,device,script,fasver,loginfo,dateinfom,dateserver, idruninfodb) 	values (:idruninfo,:dateinfo,:userruninfo,:station,:device,:script,:fasver,:loginfo,now(),now(), :idruninfodb)  ");
						$sentencia->bindParam(':idruninfo', $v1);
						$sentencia->bindParam(':dateinfo', $v2);
						$sentencia->bindParam(':userruninfo', $v3);
						$sentencia->bindParam(':station', $v4);
						$sentencia->bindParam(':device', $v5);
						$sentencia->bindParam(':script', $v6);
						$sentencia->bindParam(':fasver', $v7);
						$sentencia->bindParam(':loginfo', $v8);
						$sentencia->bindParam(':idruninfodb', $v9);
						// insertar una fila
						$sentencia->execute();
					}	
					else
					{
							$sentencia = $connect->prepare("update runinfodb set dateinfo = now(), loginfo = concat(loginfo,' - ', ".$v8.")  where idruninfodb = ".$v9);
							
						// insertar una fila
							$sentencia->execute();
					}						
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


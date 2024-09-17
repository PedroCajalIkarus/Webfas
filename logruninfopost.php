<?php
 //   error_reporting(0);
//	error_reporting(-1);
	include("db_conect_login_query.php"); 	
//	header('Content-Type: application/json');
	

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
	//	echo "select CAST (concat(right(concat(0,buf.idbusiness),2) ,right(concat(0,bs.idstation),2), right(concat(0,buf.iduserfas),2),right( concat(0,0,0,0,0,0,(maxidruninfo+1)),6)) as bigint) as ccidbingit from userfas inner join business_userfas as buf on userfas.iduserfas = buf.iduserfas	inner join business on business.idbusiness = buf.idbusiness inner join business_station as bs on buf.idbusiness = bs.idbusiness and bs.typestation = 'server' where bs.idbusiness = ".$v1." and buf.iduserfas =21 ";
		$sql = $connect->prepare("select CAST (concat(right(concat(0,buf.idbusiness),2) ,right(concat(0,bs.idstation),2), right(concat(0,buf.iduserfas),2),right( concat(0,0,0,0,0,0,(maxidruninfo+1)),6)) as bigint) as ccidbingit from userfas inner join business_userfas as buf on userfas.iduserfas = buf.iduserfas	inner join business on business.idbusiness = buf.idbusiness inner join business_station as bs on buf.idbusiness = bs.idbusiness and bs.typestation = 'server' where bs.idbusiness = ".$v1." and buf.iduserfas =21 ");
		 try {
				    $sql->execute();
					$resultado = $sql->fetchAll();
					 foreach ($resultado as $row) {
						$vmaxid= $row['ccidbingit']+1;
						$return_result_insert=$vmaxid;
					 }
						
							$sentencia = $connect->prepare("update business_station set maxidruninfo = maxidruninfo + 1 where idbusiness = ".$v1." and typestation = 'server'");
							$sentencia->execute();
				 } 
				catch (PDOException $e) 
				{
					
					$return_result_insert="error";
					$msjerr= "Syntax Error MM: ".$e->getMessage();
						
					
				}
	}	

	if ($v0 == "2")
	{	
		
		//$v1 = $_REQUEST['v1']; ///idruninfo
		$v2 = strtolower($_REQUEST['v2']); // dateinfo
		$v3 = strtolower($_REQUEST['v3']); //userruninfo
		$v4 = strtolower($_REQUEST['v4']); // station
		$v5 = strtolower($_REQUEST['v5']); // device
		$v6 = strtolower($_REQUEST['v6']); //script
		$v7 = $_REQUEST['v7']; //fasver
		$v8 = $_REQUEST['v8']; //loginfo
		$v9 = $_REQUEST['v9']; ///idruninfoDB
	//	echo "hola".$v9;
			$v1=1;
	
			$sql_busca = $connect->prepare("select idruninfodb from runinfodb where idruninfodb = ".$v9 );
			$sql_busca->execute();
			$exite_idnube = "N";
					$resultado_busca = $sql_busca->fetchAll();
					 foreach ($resultado_busca as $rowbusca) {
							$exite_idnube = "Y";
					 }
		
	
//	echo "abc".$exite_idnube;
		
		$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connect->beginTransaction();
			 try {
					
					
					
					if ($exite_idnube == "N")
					{
						//$connect->query($sql);
						$lafecha="now()";
						$sentencia = $connect->prepare("INSERT INTO runinfodb (idruninfo,dateinfo,userruninfo,station,device,script,fasver,loginfo,dateinfom,dateserver, idruninfodb) 	values (:idruninfo,:dateinfo,:userruninfo,:station,:device,:script,:fasver,:loginfo,now(),now(), :idruninfodb)  ");
						$sentencia->bindParam(':idruninfo', $v9);
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
						
							$sentencia = $connect->prepare("update runinfodb set dateinfo = now(), loginfo = concat(loginfo,' - <br>', '".$v8."')  where idruninfodb = ".$v9);
						////	echo "update runinfodb set dateinfo = now(), loginfo = concat(loginfo,' - <br>', '".$v8."')  where idruninfodb = ".$v9;
							$sentencia->execute();
							
						
					}						
					$return_result_insert="ok";
					 $connect->commit();
					 
				/*	 if ($exite_idnube == "N")
					{
												
						/// replicamos lo mismo en la base replica.
					//	$ipserver="127.0.0.1";
							$vuserdb="wfeibpulseexr";
							$vpassdb="d-VcL{3D[Wef7pH=";
							$vdbnamerepli="dbfiplexrepli";			
							
						
							$connectrepli = new PDO('pgsql:host='.$ipserver.';port=5432;dbname='.$vdbnamerepli.';user='.$vuserdb.';password='.$vpassdb.'');
							$lafecha="now()";
							$sentenciarepli = $connectrepli->prepare("INSERT INTO runinfodb (idruninfo,dateinfo,userruninfo,station,device,script,fasver,loginfo,dateinfom,dateserver, idruninfodb) 	values (:idruninfo,:dateinfo,:userruninfo,:station,:device,:script,:fasver,:loginfo,now(),now(), :idruninfodb)  ");
							$sentenciarepli->bindParam(':idruninfo', $v9);
							$sentenciarepli->bindParam(':dateinfo', $v2);
							$sentenciarepli->bindParam(':userruninfo', $v3);
							$sentenciarepli->bindParam(':station', $v4);
							$sentenciarepli->bindParam(':device', $v5);
							$sentenciarepli->bindParam(':script', $v6);
							$sentenciarepli->bindParam(':fasver', $v7);
							$sentenciarepli->bindParam(':loginfo', $v8);
							$sentenciarepli->bindParam(':idruninfodb', $v9);
							// insertar una fila
							$sentenciarepli->execute();
							
							
							$sentenciareplim = $connect->prepare("INSERT INTO runinfodb (idruninfo,dateinfo,userruninfo,station,device,script,fasver,loginfo,dateinfom,dateserver, idruninfodb) 	values (:idruninfo,:dateinfo,:userruninfo,:station,:device,:script,:fasver,:loginfo,now(),now(), :idruninfodb)  ");
							$sentenciareplim->bindParam(':idruninfo', $v9);
							$sentenciareplim->bindParam(':dateinfo', $v2);
							$sentenciareplim->bindParam(':userruninfo', $v3);
							$sentenciareplim->bindParam(':station', $v4);
							$sentenciareplim->bindParam(':device', $v5);
							$sentenciareplim->bindParam(':script', $v6);
							$sentenciareplim->bindParam(':fasver', $v7);
							$sentenciareplim->bindParam(':loginfo', $v8);
							$sentenciareplim->bindParam(':idruninfodb', $v9);
							// insertar una fila
							$sentenciareplim->execute();
							
							
							
						
						
						
					}	
					else
					{
						
							
					//	$ipserver="127.0.0.1";
							$vuserdb="wfeibpulseexr";
							$vpassdb="d-VcL{3D[Wef7pH=";
							$vdbnamerepli="dbfiplexrepli";			
							
						
							$connectrepli = new PDO('pgsql:host='.$ipserver.';port=5432;dbname='.$vdbnamerepli.';user='.$vuserdb.';password='.$vpassdb.'');
							$sentenciarepli = $connectrepli->prepare("update runinfodb set dateinfo = now(), loginfo = concat(loginfo,' - <br>', '".$v8."')  where idruninfodb = ".$v9);
						// insertar una fila
							$sentenciarepli->execute();
							
							
							$sentenciarepliq = $connect->prepare("update runinfodb set dateinfo = now(), loginfo = concat(loginfo,' - <br>', '".$v8."')  where idruninfodb = ".$v9);
						// insertar una fila
							$sentenciarepliq->execute();
					}	
						*/
					 
					 
					 
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


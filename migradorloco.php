<?php

				$ipserver="107.191.42.48";
							$vuserdb="wfeibpulseexr";
							$vpassdb="d-VcL{3D[Wef7pH=";
							$vdbnamerepli="dbfiplexrepli";			
							$vdbname="dbfiplex";			
							
						
							$connectrepli = new PDO('pgsql:host='.$ipserver.';port=5432;dbname='.$vdbnamerepli.';user='.$vuserdb.';password='.$vpassdb.'');
						$connect = new PDO('pgsql:host='.$ipserver.';port=5432;dbname='.$vdbname.';user='.$vuserdb.';password='.$vpassdb.'');
						
							
						
						//	$sql_busca = $connectrepli->prepare("select * from runinfodb where idruninfodb >= 10902007096  order by  idruninfodb  limit 1000 " );
							$sql_busca = $connectrepli->prepare("select * from runinfodb where idruninfodb >= 10906001678 and idruninfodb< 20000000000 order by  idruninfodb desc  limit 100 " );
			$sql_busca->execute();
		
					$resultado_busca = $sql_busca->fetchAll();
					 foreach ($resultado_busca as $rowbusca) {
							
							echo "<br>select * from runinfodb where idruninfodb = ".$rowbusca['idruninfodb'];
							
							    	$sql_busca_siexiste = $connect->prepare("select * from runinfodb where idruninfodb = ".$rowbusca['idruninfodb'] );
									$sql_busca_siexiste->execute();
									$exite_idnube = "N";
									$resultado_buscasiexiste = $sql_busca_siexiste->fetchAll();
									 foreach ($resultado_buscasiexiste as $rowbusca2) 
									 {
											$exite_idnube = "S";	
									 }
									 if ($exite_idnube == "N")
									 {
											echo "-Comparando NO Existe ID run info ".$rowbusca['idruninfodb'].".Existe?".$exite_idnube."<br>";	 	
											
											
												$lafecha="now()";
												$sentencia = $connect->prepare("INSERT INTO runinfodb (idruninfo,dateinfo,userruninfo,station,device,script,fasver,loginfo,dateinfom,dateserver, idruninfodb) 	values (:idruninfo,:dateinfo,:userruninfo,:station,:device,:script,:fasver,:loginfo,:dateinfom,:dateserver, :idruninfodb)  ");
												$sentencia->bindParam(':idruninfo', $rowbusca['idruninfodb']);
												$sentencia->bindParam(':dateinfo', $rowbusca['dateinfo']);
												$sentencia->bindParam(':userruninfo', $rowbusca['userruninfo']);
												$sentencia->bindParam(':station', $rowbusca['station']);
												$sentencia->bindParam(':device', $rowbusca['device']);
												$sentencia->bindParam(':script', $rowbusca['script']);
												$sentencia->bindParam(':fasver', $rowbusca['fasver']);
												$sentencia->bindParam(':loginfo', $rowbusca['loginfo']);
												$sentencia->bindParam(':dateinfom', $rowbusca['dateinfom']);
												$sentencia->bindParam(':dateserver', $rowbusca['dateserver']);
												$sentencia->bindParam(':idruninfodb', $rowbusca['idruninfodb']);
												// insertar una fila
												$sentencia->execute();
						
									
									 }
									 else
									 {
									echo "-EXISTE Comparando ID run info ".$rowbusca['idruninfodb'].".Existe?".$exite_idnube."<br>";	 		 	 
									 }	 
									 
								
					 }
		
		
						
?>

<!--
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
							-->
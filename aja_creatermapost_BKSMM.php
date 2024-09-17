<?php
    error_reporting(0);
	include("db_conect_login.php"); 	
	header('Content-Type: application/json');
	
 	session_start();
    $return_arr = array();
	$vnroserie = $_REQUEST['v0']; 
	$v1 = $_REQUEST['v1']; 
	$v2 = $_REQUEST['v2'];
	$v_rma_nroexterno_RMASO = $_REQUEST['v3'];
	$vidorderreplicar = $_REQUEST['v2'];
	
					
	
		
		$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connect->beginTransaction();
			 try {
				 // buscamos la max rev.
						$sql = $connect->prepare("select max(idorders)+1 as maxidorders from orders ");				
						$sql->execute();
						$resultado = $sql->fetchAll();
						$maxidorders=0;
						foreach ($resultado as $row) 
						{
								$maxidorders=$row['maxidorders']	;
						}
					
						 $query_lista ="insert into  orders SELECT ".$maxidorders.", idcustomers, idfamilyprod, idtypeband, idtypeproduct, idproduct, idconfiguration, 0, 0, date_approved, 1, typeregister, processday, false, nameapproved ,'Y', ''	FROM orders 	where idorders = ".$vidorderreplicar."  and idrev in (select max(idrev) from orders  where idorders = ".$vidorderreplicar."   )";
						 $connect->query($query_lista);					 
						 // buscamos la max rev.					 
						$vgeneradoidrev=0;						 
						 $query_lista ="insert into orders_sn SELECT ".$maxidorders.", idcustomers, idfamilyprod, idtypeband, idtypeproduct, idproduct, idconfiguration, ".$vgeneradoidrev.", idnroserie, '".$v_rma_nroexterno_RMASO."', wo_serialnumber, idruninfo, ponumber, pwrsupplytype, rcgfbwa, moden_dig, date_approved, descripcion, ul_gain, ul_max_pwr, dl_gain, dl_max_pwr, req_ppassy, req_calibration, req_spec, req_other, nameapproved, notes, reqresources, typeregister, processday, false, so_soft_external, so_associed
						FROM orders_sn 	where idorders = ".$vidorderreplicar."  and wo_serialnumber = '".$vnroserie."' and idrev in (select max(idrev) from orders_sn  where idorders = ".$vidorderreplicar."   )";
						$connect->query($query_lista);					
						$query_lista ="insert into orders_sn_specs	SELECT ".$maxidorders.", ".$vgeneradoidrev.", idch, idnroserie, typedata, ul_ch_fr, dl_ch_fr, dpxlowstart, dpxlowstop, dpxhihgstart, dpxhihgstop, unitdlstart, unitdlstop, unitulstart, unitulstop, notes 	FROM orders_sn_specs 	where idorders = ".$vidorderreplicar."  and idrev in (select max(idrev) from orders  where idorders = ".$vidorderreplicar." ) and idnroserie in ( select idnroserie from orders_sn  where idorders = ".$vidorderreplicar." and wo_serialnumber = '".$vnroserie."' )";
						$connect->query($query_lista);						
						/////////////////////////////////////////////////////////////////////////////////////
						//////AUDITAMOS///////////////////////////////////////////////////////////////////////////////
						$vuserfas = $_SESSION["b"];
						$vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
						$vaccionweb="INSERT RMA";
						$vdescripaudit="REPLICA SO para RMA NEW REV idordersareplciar:".$vidorderreplicar;	
						$vtextaudit="insert into  orders SELECT ".$maxidorders.", idcustomers, idfamilyprod, idtypeband, idtypeproduct, idproduct, idconfiguration, 0, 0, date_approved, 1, typeregister, processday, false, nameapproved ,'Y', ''	FROM orders 	where idorders = ".$vidorderreplicar."  and idrev in (select max(idrev) from orders  where idorders = ".$vidorderreplicar."   )";
									
								$sentenciaudit = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
								$sentenciaudit->bindParam(':userfas', $vuserfas);								
								$sentenciaudit->bindParam(':menuweb', $vmenufas);
								$sentenciaudit->bindParam(':actionweb', $vaccionweb);
								$sentenciaudit->bindParam(':descripaudit', $vdescripaudit);
								$sentenciaudit->bindParam(':textaudit', $vtextaudit);
								$sentenciaudit->execute();
								$return_result_insert="ok";
								
								
									/// 'SNs Assign FAS_Server'
					$query_lista ="INSERT INTO orders_states(idorders, idstate, datestate)	VALUES (".$maxidorders.", 7, now());";
				   $connect->query($query_lista);
				   $query_lista ="INSERT INTO orders_states(idorders, idstate, datestate)	VALUES (".$maxidorders.", 4, now());";
				   $connect->query($query_lista);
					 	$return_result_insert="ok"; 
										$msjerr= "";
										
					 $connect->commit();
				} 
				catch (PDOException $e) 
				{
					  $connect->rollBack();
					$return_result_insert="error";
					$msjerr= "Syntax Error MM: ".$e->getMessage();					
				}
			
echo(json_encode(["result"=>$return_result_insert]));

?>


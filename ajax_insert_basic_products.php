<?php
 include("db_conect.php"); 
  	session_start();

//	header('Content-Type: application/json');
// Motrar todos los errores de PHP
error_reporting(-1);
	
	
	$txtbusiness = $_REQUEST['txtbusiness'];
	$txtnewprod = trim($_REQUEST['txtnewprod']);
	$txtnewproddescr = trim($_REQUEST['txtnewproddescr']);
	//txtfiplexsku
	$txtfiplexsku = trim($_REQUEST['txtfiplexsku']);
	//txtrefmother
	$txtrefmother = trim($_REQUEST['txtrefmother']);

	///echo "HOla".$txtnewprod;

	$iduniquebranchsonprod = trim($_REQUEST['iduniquebranchsonprod']);
	$typeproduct  = trim($_REQUEST['typeproduct']);
	$vuserfas = $_SESSION["b"];
	$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$return_arr = array();
		$connect->beginTransaction();
		 try {

					$sql = $connect->prepare("INSERT INTO public.products(idtypeproduct, idproduct, idconfiguration, powersupply, modelciu, description, classproduct, active, usermodif, datelastmodif, woparam, showdpxreport, idbusiness, iduniquebranchsonprod, idbandgroup, idtypeproductaux, idrevproduct, fiplexsku, typeproduct) VALUES (0, (select max(idproduct)+1 from products ), 0, '', :modelciu,:description, :classproduct, 'Y', :usermodif, now(), true, true,:idbusiness,:iduniquebranchsonprod, null, null, 0,:fiplexsku,:typeproduct);");
					//$sql = $connect->prepare("INSERT INTO public.products(idtypeproduct, idproduct, idconfiguration, powersupply, modelciu, description, classproduct, active, usermodif, datelastmodif, woparam, showdpxreport, idbusiness, iduniquebranchsonprod, idbandgroup, idtypeproductaux, idrevproduct, fiplexsku, typeproduct) VALUES (0, (select max(idproduct)+1 from products ), 0, '', ':modelciu',':description', :classproduct, 'Y', :usermodif, now(), true, true,:idbusiness,':iduniquebranchsonprod', null, null, 0,':fiplexsku',':typeproduct');");
					
				
					$sql->bindParam(':modelciu', $txtnewprod);
					$sql->bindParam(':description', $txtnewproddescr);

					$sql->bindParam(':classproduct', $txtrefmother);
					$sql->bindParam(':usermodif', $vuserfas);
				
					//:iduniquebranchsonprod
					$sql->bindParam(':idbusiness', $txtbusiness);
					$sql->bindParam(':iduniquebranchsonprod', $iduniquebranchsonprod);
					$sql->bindParam(':fiplexsku', $txtfiplexsku);

					$sql->bindParam(':typeproduct', $typeproduct);
					
				

					$sql->execute();
				
					$return_arr[] = array("resultado" => "OK");
					$connect->commit();

								//////AUDITAMOS///////////////////////////////////////////////////////////////////////////////
				$vuserfas = $_SESSION["b"];
				$vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
				$vaccionweb="AddCIU";
					$vdescripaudit="visitAddCIUweb#".$_SERVER['SERVER_ADDR'];
				$vtextaudit="AddCIU -modelciu:".$txtnewprod."-classproduct:". $txtrefmother."-txtbusiness:".$txtbusiness."-txtfiplexsku".$txtfiplexsku."-typeproduct".$typeproduct."-iduniquebranchsonprod". $iduniquebranchsonprod."-descrip:".$txtnewproddescr;
				
				$sentenciach = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
								$sentenciach->bindParam(':userfas', $vuserfas);								
								$sentenciach->bindParam(':menuweb', $vmenufas);
								$sentenciach->bindParam(':actionweb', $vaccionweb);
								$sentenciach->bindParam(':descripaudit', $vdescripaudit);
								$sentenciach->bindParam(':textaudit', $vtextaudit);
								$sentenciach->execute();
								
							
				/////////////////////////////////////////////////////////////////////////////////////
					
			} 
			catch (PDOException $e) 
			{
				//echo $e;
				$connect->rollBack();
				$return_arr[] = array("resultado" => "Error");
			}
	
					
 echo json_encode($return_arr);
 
 



?>
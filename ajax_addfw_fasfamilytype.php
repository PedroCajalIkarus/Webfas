<?php
// Desactivar toda notificación de error
error_reporting(0);

	include("db_conect.php"); 
	header('Content-Type: application/json');
	
	
 	$return_result_insert="ok";
	//	$return_arr[] = array("resultiu" => "ok");
	//data: "txtfliaprodtype="+txtfliaprodtype+'&txtfpgafw='+txtfpgafw+'&txtfpgafasfw='+txtfpgafasfw+'&txtucfw='+txtucfw+
	//'&txtucfasfw='+txtucfasfw+'&txtucfasfw='+txtether+'&txtetherfasfw='+txtetherfasfw+'&txtetherfw='+txtetherfw+'&calstringfw='+calstringfw,			
	$txtfliaprodtype= $_REQUEST['txtfliaprodtype'];
	// separar flia.
	$porciones = explode("#", $txtfliaprodtype);
	$iduniquebranchprod= str_replace("a","",$porciones[0]);
	$idbranchprod = $porciones[1];

	$idfirmware  = $_REQUEST['idfirmware'];
	$txtfpga = $_REQUEST['txtfpgafw'];
	$txtfpgafas= $_REQUEST['txtfpgafasfw'];
	$txtuc= $_REQUEST['txtucfw'];
	$txtucfas= $_REQUEST['txtucfasfw'];
	$txtether= $_REQUEST['txtetherfw'];
	$txtetherfas= $_REQUEST['txtetherfasfw'];

	
		$txtfpgacusdescrip = $_REQUEST['txtfpgacusdescrip'];
		
	$txtuccusdescrip = $_REQUEST['txtuccusdescrip'];
	$txtethercusdescrip = $_REQUEST['txtethercusdescrip'];
	
		$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connect->beginTransaction();
		//echo $sql;
			try {
				$connect->query($sql);
					$return_result_insert="ok";
					
					//Insertamos los datos del FW
					
				//	$sql="INSERT INTO public.products_branch_fw(idproductsbranch, idrev, datetimemodif, fpga_file, micro_file, eth_file, fpga_fas, micro_fas, eth_fas, calrstring,fpga_description, uc_description, eht_description, idbandgroup, idunquebranchfather) 	VALUES ( ".$idbranchprod.",(select COALESCE(count(idrev)+1,0)  from products_branch_fw  where idproductsbranch = ".$idbranchprod."),now(), '".$txtfpga."','".$txtuc."','".$txtether."','".$txtfpgafas."','".$txtucfas."','".$txtetherfas."','".$calstring."','".$txtfpgacusdescrip."','".$txtuccusdescrip."','".$txtethercusdescrip."');";
					$sql="INSERT INTO public.fas_firmwarelist(idfas_firmwarelist, idrev, namefirmware, datetimemodif, fpga_file, micro_file, eth_file, fpga_fas, micro_fas, eth_fas, calrstring, fpga_description, uc_description, eht_description, idbusiness, active) VALUES (".$idfirmware.",(select COALESCE(count(idrev)+1,0)  from fas_firmwarelist  where idfas_firmwarelist = ".$idfirmware."), (select distinct namefirmware from fas_firmwarelist  where idfas_firmwarelist = ".$idfirmware."),now(),'".$txtfpga."','".$txtuc."','".$txtether."','".$txtfpgafas."','".$txtucfas."','".$txtetherfas."','".$calstring."','".$txtfpgacusdescrip."','".$txtuccusdescrip."','".$txtethercusdescrip."',(select distinct idbusiness from fas_firmwarelist  where idfas_firmwarelist = ".$idfirmware."),'Y')";
					///echo $sql."<br>";/
						$connect->query($sql);
						$vuserfas = $_SESSION["b"];
						$vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
						$vaccionweb="INSERT";
						$vdescripaudit=" INSERT products_branch_fw ";	
						$vtextaudit=$sql;
					
						$sentenciaudit = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
								$sentenciaudit->bindParam(':userfas', $vuserfas);								
								$sentenciaudit->bindParam(':menuweb', $vmenufas);
								$sentenciaudit->bindParam(':actionweb', $vaccionweb);
								$sentenciaudit->bindParam(':descripaudit', $vdescripaudit);
								$sentenciaudit->bindParam(':textaudit', $vtextaudit);
								$sentenciaudit->execute();
								
								
								$vuserfas = $_SESSION["b"];
					
								///UPDATE EN CADENA PARa TODOSLOS PRDUCTOS DE ESA FLIA!!!!!
						//$txtfpga."','".$txtuc."','".$txtether."','".$txtfpgafas."','".$txtucfas."','".$txtetherfas
						////oldversion
					//	$sql_encadena="UPDATE public.fas_confidential_fw SET  calrstring = '".$calstring."' fpgafilename='".$txtfpga."', microfilename='".$txtuc."', ethfilename='".$txtether."',  fpga_fas='".$txtfpgafas."', micro_fas='".$txtucfas."', eth_fas='".$txtetherfas."', datelastmodif=now() 	WHERE customfw = false and idciu in ( select idproduct from products where iduniquebranchsonprod='".$vvidunquebranchfather."'  )";
					//	echo "---------------".$sql_encadena;

					/// select fiplex union select ciu no fiplex 
						$sql_encadena="insert into fas_confidential_fw
						 SELECT distinct fas_confidential_fw.idtypeband, fas_confidential_fw.idciu, '".$txtfpga."', '".$txtuc."', '".$txtether."', active, customfw, '".$txtfpgafas."', '".$txtucfas."', '".$txtetherfas."', now(), '".$vuserfas ."', calrstring, idrevmaxfw
						FROM public.fas_confidential_fw
						inner join (
							select  idtypeband ,  idciu, max(idrevfw) + 1 as idrevmaxfw,  max(idrevfw) as idrevmaxsolo
						from fas_confidential_fw    
						where idciu in( select idproduct from products where iduniquebranchsonprod in (select iduniquebranchprodson from business_branch_tree_fw where idfas_firmwarelist =".$idfirmware.") and idbusiness = 1  )
						group by  idtypeband, idciu
							) as maxidrevfrw
							on maxidrevfrw.idciu = fas_confidential_fw.idciu and
							maxidrevfrw.idtypeband = fas_confidential_fw.idtypeband and
							maxidrevfrw.idrevmaxsolo = fas_confidential_fw.idrevfw
						where fas_confidential_fw.idciu in( select idproduct from products where iduniquebranchsonprod  in (select iduniquebranchprodson from business_branch_tree_fw where idfas_firmwarelist =".$idfirmware.") and idbusiness = 1 )
						union
						SELECT distinct fas_confidential_fw.idtypeband, fas_confidential_fw.idciu, '".$txtfpga."', '".$txtuc."', 'NA', active, customfw, '".$txtfpgafas."', '".$txtucfas."', '0.0.0', now(), '".$vuserfas ."', calrstring, idrevmaxfw
						FROM public.fas_confidential_fw
						inner join (
							select  idtypeband ,  idciu, max(idrevfw) + 1 as idrevmaxfw,  max(idrevfw) as idrevmaxsolo
						from fas_confidential_fw    
						where idciu in( select idproduct from products where iduniquebranchsonprod in (select iduniquebranchprodson from business_branch_tree_fw where idfas_firmwarelist =".$idfirmware.") and idbusiness > 1  )
						group by  idtypeband, idciu
							) as maxidrevfrw
							on maxidrevfrw.idciu = fas_confidential_fw.idciu and
							maxidrevfrw.idtypeband = fas_confidential_fw.idtypeband and
							maxidrevfrw.idrevmaxsolo = fas_confidential_fw.idrevfw
						where fas_confidential_fw.idciu in( select idproduct from products where iduniquebranchsonprod in (select iduniquebranchprodson from business_branch_tree_fw where idfas_firmwarelist =".$idfirmware.") and idbusiness > 1)	";

							$connect->query($sql_encadena);
														
									
					
						$vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
						$vaccionweb="INSERT";
						$vdescripaudit=" UPDATE fas_confidential_fw TRIGEER SON PRODUCTS";	
						$vtextaudit=$sql_encadena;
					
						$sentenciaudit = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
								$sentenciaudit->bindParam(':userfas', $vuserfas);								
								$sentenciaudit->bindParam(':menuweb', $vmenufas);
								$sentenciaudit->bindParam(':actionweb', $vaccionweb);
								$sentenciaudit->bindParam(':descripaudit', $vdescripaudit);
								$sentenciaudit->bindParam(':textaudit', $vtextaudit);
								$sentenciaudit->execute();
								
						
				
				$connect->commit();
					
							
				} 
				catch (PDOException $e) 
				{
					
					$connect->rollBack();

				
					
					$return_result_insert="error";
					$msjerr= "Syntax Error MM: ".$e->getMessage();
						
					
				}
	

 echo(json_encode(["resultiu"=>$return_result_insert,"erromsj"=>$msjerr]));

?>

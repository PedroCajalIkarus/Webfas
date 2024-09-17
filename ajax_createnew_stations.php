<?php
// Desactivar toda notificación de error
error_reporting(0);

	include("db_conect.php"); 
	header('Content-Type: application/json');
		  

	$txtstationame= $_REQUEST['txtstationame'];
	$txtmacadd= $_REQUEST['txtmacadd'];	
	$txxipsation= $_REQUEST['txxipsation'];
	$txtipgen1= $_REQUEST['txtipgen1'];
	$txtipgen2= $_REQUEST['txtipgen2'];
	$txtprintzebra = $_REQUEST['txtprintzebra'];
	$txtidmodif= $_REQUEST['txtidmodif'];

 
	
	$query_lista ="select max(idstation) as masiduser from business_station ";
	
	//echo $query_lista;
	$elmaxiduser=0;
		$data = $connect->query($query_lista)->fetchAll();	
			foreach ($data as $row) {			
				$elmaxiduser=$row['masiduser'];
			}
	$elmaxiduser=$elmaxiduser + 1 ;
	
	/// controlamos si existe un registro con los mismos datos.
	$yaexiste= "N";
	$query_lista ="select namestation from business_station where namestation  ='".$v_txtusername."'";
	

		$data = $connect->query($query_lista)->fetchAll();	
			foreach ($data as $row) {			
				$yaexiste= "S";
			}
	
		
			if ($txtidmodif !="nuevo")
			{
				$sql = "
				 update public.business_station set  ipgen1 ='".$txtipgen1."', ipgen2 ='".$txtipgen2."', ipstation ='".$txxipsation."', namestation ='".$txtstationame."',  printerzebra ='".$txtprintzebra."', bs_mac_address ='".$txtmacadd."'					
				 	 where idstation = ".$txtidmodif;
			//	echo $sql;
				try {
						$connect->query($sql);
									
							$vuserfas = $_SESSION["b"];
							$vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
							$vaccionweb="INSERT";
							$vdescripaudit=" INSERT products_labeling ";	
							$vtextaudit=$sql." - idbusiness:".$v_txtbusiness;
						
							$sentenciaudit = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
									$sentenciaudit->bindParam(':userfas', $vuserfas);								
									$sentenciaudit->bindParam(':menuweb', $vmenufas);
									$sentenciaudit->bindParam(':actionweb', $vaccionweb);
									$sentenciaudit->bindParam(':descripaudit', $vdescripaudit);
									$sentenciaudit->bindParam(':textaudit', $vtextaudit);
									$sentenciaudit->execute();
									
							//Relacion con la empresa
									
							$return_result_insert="ok";					
						
				
									
					} 
					catch (PDOException $e) 
					{
						
						$return_result_insert="error";
						$msjerr= "Syntax Error MM: ".$e->getMessage();
							
						
					}
			}
			else
			{

				if ($yaexiste == "N")
				{
					$sql = "
					INSERT INTO public.business_station(
						idbusiness, idstation, ipgen1, ipgen2, ipstation, namestation, active, maxidruninfo, typestation, idtokenlogin, datelastaupdate, printerzebra, bs_mac_address)
						VALUES (1,".$elmaxiduser." , '".$txtipgen1."','".$txtipgen2."', '".$txxipsation."','".$txtstationame."', 'true',1, 'client', null, null, '".$txtprintzebra."','".$txtmacadd."');";
					///echo $sql;
					try {
							$connect->query($sql);
										
								$vuserfas = $_SESSION["b"];
								$vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
								$vaccionweb="INSERT";
								$vdescripaudit=" INSERT products_labeling ";	
								$vtextaudit=$sql." - idbusiness:".$v_txtbusiness;
							
								$sentenciaudit = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
										$sentenciaudit->bindParam(':userfas', $vuserfas);								
										$sentenciaudit->bindParam(':menuweb', $vmenufas);
										$sentenciaudit->bindParam(':actionweb', $vaccionweb);
										$sentenciaudit->bindParam(':descripaudit', $vdescripaudit);
										$sentenciaudit->bindParam(':textaudit', $vtextaudit);
										$sentenciaudit->execute();
										
								//Relacion con la empresa
										
								$return_result_insert="ok";					
							
					
										
						} 
						catch (PDOException $e) 
						{
							
							$return_result_insert="error";
							$msjerr= "Syntax Error MM: ".$e->getMessage();
								
							
						}
				}
				else
				{
							$return_result_insert="error";
							$msjerr= "Syntax Error: Duplicate Row Data : ";
				}	

			}
	

		
 echo(json_encode(["resultiu"=>$return_result_insert,"erromsj"=>$msjerr]));

?>

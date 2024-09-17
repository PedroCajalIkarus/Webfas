<?php
// Desactivar toda notificación de error
error_reporting(0);

	include("db_conect.php"); 
	include("funcionesstores.php"); 
	header('Content-Type: application/json');
	$query_lista = list_all_values_from_table('products_labeling','ciu');
 
	
 	$return_result_insert="ok";
	//	$return_arr[] = array("resultiu" => "ok");
	

	$sheetA= $_REQUEST['v_txtciu'];
	$sheetB= $_REQUEST['v_txtupwr'];
	if ($sheetB ==""){ $sheetB = null;}
	$sheetC= $_REQUEST['v_txtmadein'];
	$sheetD= $_REQUEST['v_txtflia'];
	$sheetE= $_REQUEST['v_txtfcc'];
	if ($sheetE ==""){ $sheetE = null;}
	$sheetF= $_REQUEST['v_txtic'];
	if ($sheetF ==""){ $sheetF = null;}
	
	$sheetG= $_REQUEST['v_txtetsi'];
	if ($sheetG ==""){ $sheetG = null;}
	
	$sheetH= $_REQUEST['v_txtfccimg'];
	if ($sheetH ==""){ $sheetH = null;}
	
	$sheetI= $_REQUEST['v_txtulimg'];
	if ($sheetI ==""){ $sheetI = null;}
	
	$sheetJ= $_REQUEST['v_txtrohsimg'];
	if ($sheetJ ==""){ $sheetJ = null;}
	
	$sheetK= $_REQUEST['v_txtmadeinimg'];
	if ($sheetK ==""){ $sheetK = null;}
	
	$sheetL= $_REQUEST['v_txtdescript'];
	
	$sheetKmm= $_REQUEST['v_txtetlnumber'];
	if ($sheetKmm ==""){ $sheetKmm = null;}
	
	$sheetKnn= $_REQUEST['v_txtintertek'];
	if ($sheetKnn ==""){ $sheetKnn = null;}
	
	/// controlamos si existe un registro con los mismos datos.
	$yaexiste= "N";
	$query_lista ="select ciu from products_labeling where  ciu ='".$sheetA."' and ulpwrrat ='".$sheetB."' and madein ='".$sheetC."' and flia ='".$sheetD."' and fcc ='".$sheetE."' and ic ='".$sheetF."' ";
	
	//echo $query_lista;
		$data = $connect->query($query_lista)->fetchAll();	
			foreach ($data as $row) {			
				$yaexiste= "S";
			}
	
		if ($yaexiste == "N")
		{
			$sql = "INSERT INTO products_labeling(ciu, ulpwrrat, madein, flia, fcc, ic, idlabel, active, description, fccimg, ulimg, rohsimg, madeinimg, etsi,idrev, etlnumber, intertekimg )	
			VALUES  ('".$sheetA."','".$sheetB."','".$sheetC."','".$sheetD."','".$sheetE."','".$sheetF."',(select COALESCE(max(idlabel),0) + 1 from products_labeling),'true','".$sheetL."',".$sheetH.",".$sheetI.",".$sheetJ.",".$sheetK.",".$sheetG.",0,'".$sheetKmm."',".$sheetKnn.");";

			try {
				$connect->query($sql);
					$return_result_insert="ok";
					
				
					 $sqlsolucionador ="update products_labeling set ulpwrrat = null where ulpwrrat = '' ";
					 $connect->query($sqlsolucionador);
			  		 $sqlsolucionador ="update products_labeling set fcc = null where fcc = '' ";
					 $connect->query($sqlsolucionador);
					 $sqlsolucionador ="update products_labeling set ic = null where ic = '' ";
					 $connect->query($sqlsolucionador);
				 	 $sqlsolucionador ="update products_labeling set etlnumber = null where etlnumber = '' ";
					 $connect->query($sqlsolucionador);
				 	 $sqlsolucionador ="update products_labeling set ulpwrrat = null where ulpwrrat = '' ";
					 $connect->query($sqlsolucionador);
					
						
						$vuserfas = $_SESSION["b"];
						$vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
						$vaccionweb="INSERT";
						$vdescripaudit=" INSERT products_labeling ";	
						$vtextaudit=$sql;
					
						$sentenciaudit = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
								$sentenciaudit->bindParam(':userfas', $vuserfas);								
								$sentenciaudit->bindParam(':menuweb', $vmenufas);
								$sentenciaudit->bindParam(':actionweb', $vaccionweb);
								$sentenciaudit->bindParam(':descripaudit', $vdescripaudit);
								$sentenciaudit->bindParam(':textaudit', $vtextaudit);
								$sentenciaudit->execute();
								
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
		
		
		//echo $sql."<br>";
		
		
		 
		
		

 echo(json_encode(["resultiu"=>$return_result_insert,"erromsj"=>$msjerr]));

?>

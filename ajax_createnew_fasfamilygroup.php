<?php
// Desactivar toda notificación de error
error_reporting(0);

	include("db_conect.php"); 
	header('Content-Type: application/json');
	
	
 	$return_result_insert="ok";
	//	$return_arr[] = array("resultiu" => "ok");
	

///	data: "v_txtciu="+v_txtciu+'&v_txtfpga='+v_txtfpga+'&v_txtmicro='+v_txtmicro+'&v_txtehter='+v_txtehter,	

	$v_txtnewflia= $_REQUEST['txtnewflia'];


	/// controlamos si existe un registro con los mismos datos.
	$yaexiste= "N";
	$query_lista ="select idfamilygroup from familygroup where  namefamilygroup ='".$v_txtnewflia."' ";
	
	//	echo "aaaa".$query_lista;
	
		$data = $connect->query($query_lista)->fetchAll();	
			foreach ($data as $row) {			
				$yaexiste= "S";
			}
	
		if ($yaexiste == "N")
		{
			//$sql = "INSERT INTO fas_confidential_fw( idciu, fpga, micro, eth, active) 	VALUES (".$v_txtciu.", '".$v_txtfpga."','".$v_txtmicro."','".$v_txtehter."', 'true');";
			$sql ="INSERT INTO familygroup(	idfamilygroup, namefamilygroup, active) 	VALUES ((select COALESCE(max(idfamilygroup),0) + 1 from familygroup), '".$v_txtnewflia."' ,'Y');";
		
			try {
				$connect->query($sql);
					$return_result_insert="ok";
					
						$vuserfas = $_SESSION["b"];
						$vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
						$vaccionweb="INSERT";
						$vdescripaudit=" INSERT familygroup ";	
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

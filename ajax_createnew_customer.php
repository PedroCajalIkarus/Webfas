<?php
// Desactivar toda notificación de error
error_reporting(0);

	include("db_conect.php"); 
	include("funcionesstores.php"); 
	header('Content-Type: application/json');
	$query_lista = list_all_values_from_table('products_labeling','ciu');
 
	
 	$return_result_insert="ok";
	//	$return_arr[] = array("resultiu" => "ok");
	
//data: "v_txtnamecli="+v_txtciu+'&v_txtdomi='+v_txtdomi+'&v_txtemailto='+v_txtemailto+'&v_txttel='+v_txttel+'&v_txtpersnalcontacto='+v_txtpersnalcontacto,
	$v_txtnamecli= $_REQUEST['v_txtnamecli'];
	
	$v_txtdomi= $_REQUEST['v_txtdomi'];
	$v_txtemailto= $_REQUEST['v_txtemailto'];
	$v_txttel= $_REQUEST['v_txttel'];
	$v_txtpersnalcontacto= $_REQUEST['v_txtpersnalcontacto'];
	
		
	/// controlamos si existe un registro con los mismos datos.
	$yaexiste= "N";
	$query_lista ="select namecustomers from  customers where  namecustomers ='".$v_txtnamecli."'" ;
	
	//echo $query_lista;
		$data = $connect->query($query_lista)->fetchAll();	
			foreach ($data as $row) {			
				$yaexiste= "S";
			}
	
		if ($yaexiste == "N")
		{
			$v_txtnamecli = str_replace(",", "", $v_txtnamecli);
			$sql = "INSERT INTO customers(idcustomers, namecustomers, active,address, telephone, emailcustom, personcontact)
			VALUES ( (select COALESCE(max(idcustomers),0) + 1 from customers), '".strtoupper($v_txtnamecli)."','Y','".$v_txtdomi."','".$v_txttel."','".$v_txtemailto."','".$v_txtpersnalcontacto."');";

			try {
				$connect->query($sql);
					$return_result_insert="ok";
					
						$vuserfas = $_SESSION["b"];
						$vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
						$vaccionweb="INSERT";
						$vdescripaudit=" INSERT customers ";	
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

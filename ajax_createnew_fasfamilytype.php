<?php
// Desactivar toda notificación de error
error_reporting(0);

	include("db_conect.php"); 
	header('Content-Type: application/json');
	
	
 	$return_result_insert="ok";
	//	$return_arr[] = array("resultiu" => "ok");
	//data: "txtfliaprodtype="+txtfliaprodtype+'&txttypeflia='+txttypeflia+'&txtfpga='+txtfpga+'&txtfpgafas='+txtfpgafas+'&txtuc='+txtuc+'&txtucfas='+txtucfas+'&txtether='+txtether+'&txtetherfas='+txtetherfas,	
				
	$txtfliaprodtype= $_REQUEST['txtfliaprodtype'];
	// separar flia.
	$porciones = explode("#", $txtfliaprodtype);
	$idgroup=$porciones[0];
	$idflia = $porciones[1];
	$txttypeflia= $_REQUEST['txttypeflia'];
	
	$txtfpga= $_REQUEST['txtfpga'];
	$txtfpgafas= $_REQUEST['txtfpgafas'];
	$txtuc= $_REQUEST['txtuc'];
	$txtucfas= $_REQUEST['txtucfas'];
	$txtether= $_REQUEST['txtether'];
	$txtetherfas= $_REQUEST['txtetherfas'];
	$calstring = $_REQUEST['calstring'];
	$havefw = $_REQUEST['havefw'];
	
	$txtfpgacusdescrip = $_REQUEST['txtfpgacusdescrip'];
	$txtuccusdescrip = $_REQUEST['txtuccusdescrip'];
	$txtethercusdescrip = $_REQUEST['txtethercusdescrip'];
	/// controlamos si existe un registro con los mismos datos.
	$yaexiste= "N";
	$query_lista ="select idtypeproducts from typeproducts where  description ='".$txttypeflia."'";
	
	//	echo "aaaa".$query_lista;
	
		$data = $connect->query($query_lista)->fetchAll();	
			foreach ($data as $row) {			
				$yaexiste= "S";
			}
	
		if ($yaexiste == "N")
		{
			
		    $sql="INSERT INTO public.typeproducts(idfamilygroup, idfamilyprod, idtypeproducts, description, active , havefw) VALUES (".$idgroup.", ".$idflia.", (select max(idtypeproducts) + 1 from typeproducts), '".$txttypeflia."', 'Y','".$havefw ."' );";
			//echo $sql;
			try {
				$connect->query($sql);
					$return_result_insert="ok";
					
					//Insertamos los datos del FW
					if ($havefw =="Y")
					{
						$sql="INSERT INTO public.typeproducts_fw(idfamilygroup, idfamilyprod, idtypeproducts, idrev, datetimemodif, fpga_file, micro_file, eth_file, fpga_fas, micro_fas, eth_fas, calrstring,fpga_description, uc_description, eht_description) 					VALUES (".$idgroup.", ".$idflia.", (select max(idtypeproducts)  from typeproducts),(select count(idrev)  from typeproducts_fw  where idtypeproducts in( select max(idtypeproducts)  from typeproducts)),now(), '".$txtfpga."','".$txtuc."','".$txtether."','".$txtfpgafas."','".$txtucfas."','".$txtetherfas."','".$calstring."','".$txtfpgacusdescrip."','".$txtuccusdescrip."','".$txtethercusdescrip."');";
				//	echo $sql;
						$connect->query($sql);
					}	
						$vuserfas = $_SESSION["b"];
						$vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
						$vaccionweb="INSERT";
						$vdescripaudit=" INSERT typeproducts ";	
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

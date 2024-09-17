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
	$havefw = $_REQUEST['cmbtxthavefw'];
	
	$txtfpgacusdescrip = $_REQUEST['txtfpgacusdescrip'];
	$txtuccusdescrip = $_REQUEST['txtuccusdescrip'];
	$txtethercusdescrip = $_REQUEST['txtethercusdescrip'];
	/// controlamos si existe un registro con los mismos datos.
	$yaexiste= "N";
	$query_lista ="select idproductsbranch from products_branch where  description ='".$txttypeflia."'";
	
//	echo "aaaa".$query_lista;
	
		$data = $connect->query($query_lista)->fetchAll();	
			foreach ($data as $row) {			
				$yaexiste= "S";
			}
	
		if ($yaexiste == "N")
		{
			
					//	echo "HOLA".str_pad("1", 4, "0", STR_PAD_LEFT);
		///	echo "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa".bin2hex("001")."-";

			
		    $sql="INSERT INTO public.products_branch(	idproductsbranch, description, codeproductbranch, typebranch, active, havefw) VALUES ( (select max(idproductsbranch) + 1 from products_branch), '".$txttypeflia."',(select   lpad((max(idproductsbranch)+1)::text, 4, '0')  from products_branch), 'products', 'Y','".$havefw ."' );";
			//$sql="INSERT INTO public.products_branch(	idproductsbranch, description, codeproductbranch, typebranch, active, havefw)	VALUES (idproductsbranch, description, codeproductbranch, typebranch, active, havefw);";
			//echo $sql;
			try {
				$connect->query($sql);
					$return_result_insert="ok";
					
					//Insertamos los datos del FW
					if ($havefw =="Y")
					{
						$sql="INSERT INTO public.products_branch_fw(idproductsbranch, idrev, datetimemodif, fpga_file, micro_file, eth_file, fpga_fas, micro_fas, eth_fas, calrstring,fpga_description, uc_description, eht_description,idbandgroup,idunquebranchfather,idbandgrouptttemp) 					VALUES ( (select max(idproductsbranch)  from products_branch),(select count(idrev)  from products_branch_fw  where idproductsbranch in( select max(idproductsbranch)  from products_branch)),now(), '".$txtfpga."','".$txtuc."','".$txtether."','".$txtfpgafas."','".$txtucfas."','".$txtetherfas."','".$calstring."','".$txtfpgacusdescrip."','".$txtuccusdescrip."','".$txtethercusdescrip."');";
						
					//echo $sql;
						$connect->query($sql);
					}	
						$vuserfas = $_SESSION["b"];
						$vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
						$vaccionweb="INSERT";
						$vdescripaudit=" INSERT products_branc ";	
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

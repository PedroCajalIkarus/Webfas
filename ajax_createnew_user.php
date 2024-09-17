<?php
// Desactivar toda notificación de error
error_reporting(0);

	include("db_conect.php"); 
	header('Content-Type: application/json');
		  
	$v_txtusername= $_REQUEST['v_txtusername'];
	$v_txtupwd= $_REQUEST['v_txtupwd'];	
	$v_txtnameuser= $_REQUEST['v_txtnameuser'];
	$v_txtcategory= $_REQUEST['v_txtcategory'];
	$v_txtbusiness= $_REQUEST['v_txtbusiness'];
	$v_txthidm = $_REQUEST['v_txthidm'];
	$v_txtemail= $_REQUEST['v_txtemail'];

	$v_txtbarea= $_REQUEST['v_txtbarea'];
	
	$query_lista ="select max(iduserfas) as masiduser from userfas ";
	
	//echo $query_lista;
	$elmaxiduser=0;
		$data = $connect->query($query_lista)->fetchAll();	
			foreach ($data as $row) {			
				$elmaxiduser=$row['masiduser'];
			}
	$elmaxiduser=$elmaxiduser + 1 ;
	
	/// controlamos si existe un registro con los mismos datos.
	$yaexiste= "N";
	$query_lista ="select username from userfas where username  ='".$v_txtusername."'";
	

		$data = $connect->query($query_lista)->fetchAll();	
			foreach ($data as $row) {			
				$yaexiste= "S";
			}
	
	
		if ($yaexiste == "N")
		{
			$sql = "INSERT INTO public.userfas(	iduserfas, username, userpass, active, usermail, usermobile, development, nameuserfas, userphoto, fascategory, hid)
			VALUES (".$elmaxiduser.", '".strtolower($v_txtusername)."', MD5('".$v_txtupwd."'), 'true', '".$v_txtemail."', '', '".$v_txtcategory."', '".$v_txtnameuser."', 'false','', '".$v_txthidm."')";
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
						
						$sql = "INSERT INTO business_userfas(idbusiness, iduserfas, active)	VALUES (".$v_txtbusiness.",".$elmaxiduser.", 'true');";
						//echo $sql;
						$connect->query($sql);

						$sql = "INSERT INTO business_area_users(idbusiness,idarea, iduserfas,fstartdate)	VALUES (".$v_txtbusiness.",".$v_txtbarea.",".$elmaxiduser.", now());";
						//echo $sql;
						$connect->query($sql);
			
								
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
		
 echo(json_encode(["resultiu"=>$return_result_insert,"erromsj"=>$msjerr]));

?>

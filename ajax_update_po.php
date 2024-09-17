<?php
error_reporting(0);
  include("db_conect.php");
  	header('Content-Type: application/json');
   $vvidpo = $_REQUEST['idpo'];
   
    $vvidpo = $_REQUEST['idpo'];
	 $veqcalib = $_REQUEST['eqcalib'];
	  $vmatespecial = $_REQUEST['matespecial'];
	   $votherchange = $_REQUEST['otherchange'];
	    $vtxtdescrip = $_REQUEST['txtdescrip'];
		    $vppassy = $_REQUEST['ppassy'];
		 $nameapproved = $_SESSION["b"];
		 $vuserfas = $_SESSION["b"];
						
						$vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
						$vaccionweb="update po ";
  
  $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connect->beginTransaction();
		 try {
			  
				  $sql = $connect->prepare("update orders_sn set nameapproved =:nameapproved , req_ppassy = :req_ppassy, req_calibration =:req_calibration, req_spec = :req_spec, req_other = :req_other, reqresources = :reqresources  WHERE idorders = :vvidlog and idrev in (select max(idrev) from orders_sn WHERE idorders = :vvidlog ) ");
				  
				  $sql->bindParam(':nameapproved', $nameapproved);
				  $sql->bindParam(':req_ppassy', $vppassy);
				  $sql->bindParam(':req_calibration', $veqcalib);
				  $sql->bindParam(':req_spec', $vmatespecial);
				  $sql->bindParam(':req_other', $votherchange);
				  $sql->bindParam(':reqresources', $vtxtdescrip);
				  $sql->bindParam(':vvidlog', $vvidpo);
				  
			  	  $sql->execute();
				  $resultado = $sql->fetchAll();
				  
				  // Insertamos Estado 
				  
				  						$vuserfas = $_SESSION["b"];
							$vdescripaudit="orders_sn Update PO - process Albert - user:".$vuserfas;		
								$vtextaudit="update orders_sn set nameapproved =:nameapproved , req_ppassy = :req_ppassy, req_calibration =:req_calibration, req_spec = :req_spec, req_other = :req_other, reqresources = :reqresources  WHERE idorders = :vvidlog and idrev in (select max(idrev) from orders_sn WHERE idorders = :vvidlog )";
								$vtextaudit=$vtextaudit."!!nameapproved:".$nameapproved;
								$vtextaudit=$vtextaudit."!!req_ppassy:".$vppassy;
								$vtextaudit=$vtextaudit."!!req_calibration:".$veqcalib;
								$vtextaudit=$vtextaudit."!!req_spec:".$vmatespecial;
								$vtextaudit=$vtextaudit."!!req_other:".$votherchange;
								$vtextaudit=$vtextaudit."!!reqresources:".$vtxtdescrip;
								$vtextaudit=$vtextaudit."!!vvidlog:".$vvidpo;
								
							
								
									$sentenciaudit = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
								$sentenciaudit->bindParam(':userfas', $vuserfas);								
								$sentenciaudit->bindParam(':menuweb', $vmenufas);
								$sentenciaudit->bindParam(':actionweb', $vaccionweb);
								$sentenciaudit->bindParam(':descripaudit', $vdescripaudit);
								$sentenciaudit->bindParam(':textaudit', $vtextaudit);
								$sentenciaudit->execute();
								
				  
					$return_result_insert="ok"; 
					$msjerr= "";
					$query_lista ="INSERT INTO orders_states(idorders, idstate, datestate)	VALUES (".$vvidpo.", 2, now());";
					 $connect->query($query_lista);
					  $connect->commit();
				} 
				catch (PDOException $e) 
				{
					
					$connect->rollBack();
					$return_result_insert="error".$e->getMessage();
					$msjerr= "Syntax Error MM: ".$e->getMessage();
					echo $msjerr;
					exit();
						
					
				}
		
		
	//echo $sql."<br>";

 echo(json_encode(["result"=>$return_result_insert,"erromsj"=>$msjerr]));
 

?>
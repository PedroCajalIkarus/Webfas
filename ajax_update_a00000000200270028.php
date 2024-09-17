<?php
// Desactivar toda notificación de error
error_reporting(0);
 include("db_conect.php"); 
  	session_start();
	include("funcionesstores.php"); 
	header('Content-Type: application/json');
	
	
	$vidlabel = $_REQUEST['idlabel'];
	$vlblname = trim($_REQUEST['lblname']);
	$vdataso = trim($_REQUEST['dataso']);
	
	$query_lista = "insert into components_pa SELECT idcomppa, idcomprev +1  as idcomprev, namepa, descriptionpa, gain, active, usermodif, datelastmodif, fstart, fstop, band, gaintolerance, currenttolerance, powersupply, imd3a, imd3b, imd3limita, imd3limitb, currentpa, vgate, tonetolerance, isetsi, dbctolerance, isdual, uselnasetup, idbandgroup
	FROM public.components_pa 	where ".$vidlabel."= idcomppa and idcomprev in (select max(idcomprev) from components_pa where ".$vidlabel."= idcomppa  )";
//echo $query_lista;
	 $connect->query($query_lista);
	if ($vdataso == "")
	{
		$query_lista="update components_pa set $vlblname = null where idcomppa = ".$vidlabel." and idcomprev in (select max(idcomprev) from components_pa where ".$vidlabel."= idcomppa  )";		
	}
	else
	{
		$query_lista="update components_pa set $vlblname = '$vdataso' where idcomppa = ".$vidlabel." and idcomprev in (select max(idcomprev) from components_pa where ".$vidlabel."= idcomppa  )";	
	}
	
    $return_arr = array();
  	
	//echo "<br>".$query_lista;
	//echo "<br>hacemos el Update.".$_SESSION["b"];				
	
	 $connect->query($query_lista);
	 
	 	$vuserfas = $_SESSION["b"];
						$vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
						$vaccionweb="UPDATE";
						$vdescripaudit=" update components_pa ";	
						$vtextaudit=$query_lista;
					
						$sentenciaudit = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
								$sentenciaudit->bindParam(':userfas', $vuserfas);								
								$sentenciaudit->bindParam(':menuweb', $vmenufas);
								$sentenciaudit->bindParam(':actionweb', $vaccionweb);
								$sentenciaudit->bindParam(':descripaudit', $vdescripaudit);
								$sentenciaudit->bindParam(':textaudit', $vtextaudit);
								$sentenciaudit->execute();
								
								
	$return_arr[] = array("resultado" => "OK");
					
		
	
	
					
 echo json_encode($return_arr);
 
 



?>
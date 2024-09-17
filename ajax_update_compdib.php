<?php
// Desactivar toda notificación de error
error_reporting(0);
 include("db_conect.php"); 
  	session_start();
	include("funcionesstores.php"); 
	header('Content-Type: application/json');
	
	
	$idcompdibrev = explode("#",$_REQUEST['idcompdib']); 
	
	$idcompdib = $idcompdibrev[0]; 
	$idcomp_dibidrev = $idcompdibrev[1]; 
	
	$vcampotabla = trim($_REQUEST['lblname']);
	$vdataso = trim($_REQUEST['dataso']);
	
	$query_lista = 0; //update_labeling($vidlabel ,$vlblname ,$vdataso );
    $return_arr = array();
  	
	//echo $query_lista;
	//echo "<br>hacemos el Update.".$_SESSION["b"];				
	
$return_result_insert="ok";
	//	$return_arr[] = array("resultiu" => "ok");
	

	$sheetA= $_REQUEST['v_txtciu'];
	$sheetB= $_REQUEST['v_txtupwr'];
	$sheetC= $_REQUEST['v_txtmadeinusa'];
	$sheetD= $_REQUEST['v_txtflia'];
	$sheetE= $_REQUEST['v_txtfcc'];
	$sheetF= $_REQUEST['v_txtic'];
	$sheetG= $_REQUEST['v_txtetsi'];
	
	
	/// controlamos si existe un registro con los mismos datos.
	$yaexiste= "N";
	$sql ="insert into components_dib SELECT idcompdib, ( select max(idcompdibrev) + 1 from components_dib where idcompdib = ".$idcompdib." ), namedib, descriptiondib, gainul, gaindl, gaintolerance, maxpwrul, maxpwrdl, maxriple, acceptcalib, active, usermodif, datelastmodif
	FROM components_dib where idcompdib = ".$idcompdib." and idcompdibrev = ".$idcomp_dibidrev;
	
		
			$idcomp_dibidrev = $idcomp_dibidrev + 1;
			 try {
					$connect->query($sql);
					
					$sql2="update components_dib set $vcampotabla = '$vdataso' where idcompdib = ".$idcompdib." and idcompdibrev = ".$idcomp_dibidrev;
					
					$connect->query($sql2);
					$return_result_insert="ok";
				} 
				catch (PDOException $e) 
				{
					
					$return_result_insert="error";
					$msjerr= "Syntax Error MM: ".$e->getMessage();
						
					
				}
		
		
	//echo $sql."<br>";
	
 echo(json_encode(["resultiu"=>$return_result_insert,"erromsj"=>$msjerr]));
 



?>
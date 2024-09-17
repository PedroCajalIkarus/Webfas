<?php

// Desactivar toda notificación de error
error_reporting(0);

	include("db_conect.php"); 
	
	header('Content-Type: application/json');
	$query_lista = "";
   $vidprod = $_REQUEST['idprod'];

	/// controlamos si existe un registro con los mismos datos.
	
	  $return_product = array();
	  $return_coupler = array();
	  $return_duplexer = array();
	  $return_preselector = array();
	  $return_splitter = array();
	  
	  	$query_lista ="SELECT idfamilyprod, idtypeproduct, idproduct, idconfiguration, powersupply,
		modelciu, description, namecustom, classproduct, active, usermodif, datelastmodif, woparam, showdpxreport, idfamilygroup, idbusiness
	FROM public.products where idproduct = ".$vidprod ;
	//echo $query_lista;
		$data = $connect->query($query_lista)->fetchAll();	
			foreach ($data as $row) 
			{			
				
					$return_product[] = array(
					 "modelciu"=> $row['modelciu'],					 
					 "description" => $row['description'],		
					 "idbusiness"=> $row['idbusiness']	
					
                    );
					
			}

	$query_lista ="select  idbusiness, idfamilygroup, idfamilyprod, idtypeproduct, idproduct, idconfiguration, idcomppassivecoup, idcomprevcoup,
	coupfstart, coupfstop, coupling, couplinginsertloss, couplingisolation
	FROM public.components_passives_coupler where idproduct = ".$vidprod ;
	//echo $query_lista;
		$data = $connect->query($query_lista)->fetchAll();	
			foreach ($data as $row) 
			{			
				
					$return_coupler[] = array(
					 "coupfstart"=> $row['coupfstart'],					 
					 "coupfstop" => $row['coupfstop'],		
					 "coupling"=> $row['coupling'],		
					 "couplinginsertloss"=>  $row['couplinginsertloss'],		
					 "couplingisolation"=> $row['couplingisolation']
                    );
					
			}
			
			
			$query_lista ="SELECT idbusiness, idfamilygroup, idfamilyprod, idtypeproduct, idproduct, idconfiguration, idcomppassivecoup, idcomprevcoup, 
			duplexerfstart, duplexerfstop, duplexertxrxsep, duplexerinserlosstx, duplexerinserlossrx, duplexertxnoise, duplexerrxtxisolation
	FROM public.components_passives_duplexer where idproduct = ".  $vidprod ;
	
		$data = $connect->query($query_lista)->fetchAll();	
			foreach ($data as $row) {			
				
					$return_duplexer[] = array(
					 "duplexerfstart"=> $row['duplexerfstart'],					 
					 "duplexerfstop" => $row['duplexerfstop'],		
					 "duplexertxrxsep"=> $row['duplexertxrxsep'],		
					 "duplexerinserlosstx"=>  $row['duplexerinserlosstx'],		
					 "duplexerinserlossrx"=> $row['duplexerinserlossrx'],					 
					 "duplexertxnoise"=> $row['duplexertxnoise'],
					 "duplexerrxtxisolation"=> $row['duplexerrxtxisolation']
                    );
					
			}
			
				$query_lista ="SELECT idbusiness, idfamilygroup, idfamilyprod, idtypeproduct, idproduct, idconfiguration, idcomppassivecoup, idcomprevcoup,
				preselectorfstart, preselectorfstop, preselectorbandwidth, preselectorinserloss
	FROM public.components_passives_preselector where idproduct = ".  $vidprod ;
	
		$data = $connect->query($query_lista)->fetchAll();	
			foreach ($data as $row) {			
				
					$return_preselector[] = array(
					 "preselectorfstart"=> $row['preselectorfstart'],					 
					 "preselectorfstop" => $row['preselectorfstop'],		
					 "preselectorbandwidth"=> $row['preselectorbandwidth'],		
					 "preselectorinserloss"=>  $row['preselectorinserloss']
                    );
					
			}

	$query_lista ="SELECT idbusiness, idfamilygroup, idfamilyprod, idtypeproduct, idproduct, idconfiguration, idcomppassivecoup, idcomprevcoup, 
	splitterfstart, splitterfstop, nroway, splitloss, insertloss
	FROM public.components_passives_splitter where idproduct = ".  $vidprod ;
	
		$data = $connect->query($query_lista)->fetchAll();	
			foreach ($data as $row) {			
				
					$return_splitter[] = array(
					 "splitterfstart"=> $row['splitterfstart'],					 
					 "splitterfstop" => $row['splitterfstop'],		
					 "nroway"=> $row['nroway'],		
					 "splitloss"=>  $row['splitloss'],		
					 "insertloss"=> $row['insertloss']
                    );
					
			}
					
		

 echo(json_encode(["dreturn_product"=>$return_product,"dreturn_coupler"=>$return_coupler,"dreturn_duplexer"=>$return_duplexer, "dreturn_preselector"=>$return_preselector,"dreturn_splitter"=>$return_splitter]));
 	

?>

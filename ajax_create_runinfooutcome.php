<?php
error_reporting(0);
  include("db_conect.php");
  	header('Content-Type: application/json');

	  ///		data: "vvv_refence="+vvv_refence+'&vcatt='+vcatt+'&cccatttype='+cccatttype,	
  
	$vvv_refence = $_REQUEST['vvv_refence'];   
    $vcatt = $_REQUEST['vcatt'];
	 $cccatttype = $_REQUEST['cccatttype'];	  
	 

	 $v_tipoinsert = $_REQUEST['iinserttype'];	 
	 $v_integer = $_REQUEST['nidattrib'];	 

	 $v_typeworkc = $_REQUEST['typeworkc'];	 	
	
		
		 try {
			 
		 

			$v_stringdata=  $_REQUEST['vsn'];	  
			$_idruninfo_reference=   $vvv_refence;
			$v_categoryoutcome=   $vcatt;
			$v_catidtype=  $cccatttype;

			if ( $v_tipoinsert = "")
			{
				$sentenciach = $connect->prepare("select fnt_insert_return_fas_outcome_integral(:idfasoutcomecat, :idtype, :reference, null, null, null, :v_string, null);");                  
				
				$sentenciach->bindParam(':idfasoutcomecat', $v_categoryoutcome);			
				$sentenciach->bindParam(':idtype', $v_catidtype);			
				$sentenciach->bindParam(':reference', $_idruninfo_reference);								
				$sentenciach->bindParam(':v_string', $v_stringdata); 
				$sentenciach->execute();
			}
			else
			{
				$sentenciach = $connect->prepare("select fnt_insert_return_fas_outcome_integral(:idfasoutcomecat, :idtype, :reference, null, :v_integer, null, :v_string, null);");                  
				
						$sentenciach->bindParam(':idfasoutcomecat', $v_categoryoutcome);			
						$sentenciach->bindParam(':idtype', $v_catidtype);			
						$sentenciach->bindParam(':reference', $_idruninfo_reference);								
						$sentenciach->bindParam(':v_string', $v_stringdata); 
						$sentenciach->bindParam(':v_integer', $v_integer); 
						
						$sentenciach->execute();
			}

			//// Asociate to Idruinfo. idscript 48 Assy	
			if ($v_categoryoutcome == 12 &&  $v_catidtype  ==16 && 'ASSY' ==  $v_typeworkc)
			{
				$vintegetemp = 48;
				$temoca= 0;
				$temptype=12;
				$vtextoregf ="ASSY Webfas";
				
				$sentenciach = $connect->prepare("select fnt_insert_return_fas_outcome_integral(:idfasoutcomecat, :idtype, :reference, null, :v_integer, null, :v_string, null);");                  
						$sentenciach->bindParam(':idfasoutcomecat', $temoca);			
						$sentenciach->bindParam(':idtype',$temptype);			
						$sentenciach->bindParam(':reference', $_idruninfo_reference);								
						$sentenciach->bindParam(':v_string', $vtextoregf); 
						$sentenciach->bindParam(':v_integer',$vintegetemp); 						
						$sentenciach->execute();
			}
			if ($v_categoryoutcome == 12 &&  $v_catidtype  ==16 && '2ND-ASSY'==  $v_typeworkc)
			{
				$vtextoregf ="2ND-ASSY Webfas";
				$vintegetemp = 50;
				$temoca= 0;
				$temptype=12;
				
				$sentenciach = $connect->prepare("select fnt_insert_return_fas_outcome_integral(:idfasoutcomecat, :idtype, :reference, null, :v_integer, null, :v_string, null);");                  
						$sentenciach->bindParam(':idfasoutcomecat', $temoca);			
						$sentenciach->bindParam(':idtype', $temptype);			
						$sentenciach->bindParam(':reference', $_idruninfo_reference);								
						$sentenciach->bindParam(':v_string', $vtextoregf); 
						$sentenciach->bindParam(':v_integer', $vintegetemp); 						
						$sentenciach->execute();
			}

			if ($v_categoryoutcome == 12 &&  $v_catidtype  ==16 && 'ENG-CAL'==  $v_typeworkc)
			{
				$vtextoregf ="Caibration Cost Calculation";
				$vintegetemp = 51;
				$temoca= 0;
				$temptype=12;
				
				$sentenciach = $connect->prepare("select fnt_insert_return_fas_outcome_integral(:idfasoutcomecat, :idtype, :reference, null, :v_integer, null, :v_string, null);");                  
						$sentenciach->bindParam(':idfasoutcomecat', $temoca);			
						$sentenciach->bindParam(':idtype', $temptype);			
						$sentenciach->bindParam(':reference', $_idruninfo_reference);								
						$sentenciach->bindParam(':v_string', $vtextoregf); 
						$sentenciach->bindParam(':v_integer', $vintegetemp); 						
						$sentenciach->execute();
			}
				
			if ($v_categoryoutcome == 12 &&  $v_catidtype  ==16 && 'A.BURN'==  $v_typeworkc)
			{
				$vtextoregf ="After Burning Check";
				$vintegetemp = 52;
				$temoca= 0;
				$temptype=12;
				
				$sentenciach = $connect->prepare("select fnt_insert_return_fas_outcome_integral(:idfasoutcomecat, :idtype, :reference, null, :v_integer, null, :v_string, null);");                  
						$sentenciach->bindParam(':idfasoutcomecat', $temoca);			
						$sentenciach->bindParam(':idtype', $temptype);			
						$sentenciach->bindParam(':reference', $_idruninfo_reference);								
						$sentenciach->bindParam(':v_string', $vtextoregf); 
						$sentenciach->bindParam(':v_integer', $vintegetemp); 						
						$sentenciach->execute();
			}

				   
				 	$return_result_insert="ok"; 
					 
						
						
				} 
				catch (PDOException $e) 
				{
					
									
				
				
					$return_result_insert="error".$e->getMessage();
					$msjerr= "Syntax Error MM: ".$e->getMessage();
					echo $msjerr;
					exit();
					
						
					
				}
		
		
	//echo $sql."<br>";

 echo(json_encode(["result"=>$return_result_insert,"erromsj"=>$msjerr]));
 

?>
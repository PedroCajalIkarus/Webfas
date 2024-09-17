<?php
  include("db_conect.php");
  	header('Content-Type: application/json');

    $elsnactrl = $_REQUEST['sn'];
	$snequ =$_REQUEST['snequ'];
  $msjerr="";
		 try {
				/*
                Accept [0] 					ACF, DiB Legacy, PAMP, PAHP
                AcceptDiBFlex [24] 			DiB Flex
                AcceptPassive [29] 			FCR023
                AcceptDiBEnterprise [34] 	DiB Enterprise
                AcceptBatteryCharger [36]   Battery Chargers
                DigitalModule [1]			DiB Legacy
                AcceptDiBAnalogBDA [40]		DiB Analog
                */
                
					$query_lista="
                    select  v_boolean::integer as idboollint, v_integer,idtype  from fas_outcome_integral where reference in
( 
	select reference from fas_outcome_integral where  id_outcome in
	(
		
		select  max(id_outcome)
		from fas_outcome_integral 
		where reference in 
		(
			select reference
			from  fas_outcome_integral
			where v_string  = '".  $elsnactrl."'
		) AND idfasoutcomecat  = 0 AND idtype= 12 and v_integer in(0,1,24,29,34,36,40)
	)
) AND idfasoutcomecat  = 0 AND idtype in (13,38,30) 
                    ";

                    $statusrun="Nopass";
					$v_rev_acep="";
					$v_batch_acep="";
							///		echo $query_lista;
									$data = $connect->query($query_lista)->fetchAll();	
									foreach ($data as $row) {	
                                        
										if ($row['idtype']==13) 
										{                                
										   if ($row['idboollint']==1)
                                        	{
                                            $statusrun="ok";
                                        	}
										}
										if ($row['idtype']==30) 
										{    
												$v_rev_acep = $row['v_integer'];                                         	
										}
                                        if ($row['idtype']==38) 
										{    
												$v_batch_acep = $row['v_integer'];                                         	
										}
                                       
									}

									if  ($statusrun=="ok")	
									{
										$query_listaisused="select wo_serialnumber from fnt_select_allcomoponetns_sn_maxrev() where components_sn = '".$elsnactrl."' and wo_serialnumber <> '".$snequ."' ";
										$dataused = $connect->query($query_listaisused)->fetchAll();	
										foreach ($dataused as $rowused) 
										{
											$statusrun="sn_used";
											
										}	

									}
								 
							 
				
				} 
				catch (PDOException $e) 
				{
					
					$return_result_insert="error";
                    $statusrun="Nopass";
					$msjerr= "Syntax Error MM: ".$e->getMessage();
						
					
				}
		
		
	//echo $sql."<br>";

 echo(json_encode([  "status"=>$statusrun,"v_rev_acep"=>$v_rev_acep,"v_batch_acep"=>$v_batch_acep]));
 

?>
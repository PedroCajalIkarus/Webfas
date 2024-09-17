<?php
  include("db_conect.php");
  	header('Content-Type: application/json');

    $elsnactrl = $_REQUEST['elsnactrl'];
  
  $msjerr="";
		 try {
				
					$query_lista="
                    select * from orders_sn_components_xml  where components_sn = '".  $elsnactrl."'
                    
                    ";

                    $script= "N";
                    $totalpass="N";
                    $mainpcbstring="";

								//	echo $query_lista;
									$data = $connect->query($query_lista)->fetchAll();	
									foreach ($data as $row) {	
                                        
                               
                                            $v_wo_serialnumber = $row['wo_serialnumber'];
                                       
									}

							 
				
				} 
				catch (PDOException $e) 
				{
					
					$return_result_insert="error";
					$msjerr= "Syntax Error MM: ".$e->getMessage();
						
					
				}
		
		
	//echo $sql."<br>";

 echo(json_encode([  "v_wo_serialnumber"=>$v_wo_serialnumber]));
 

?>
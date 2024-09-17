<?php
  include("db_conect.php");
  	header('Content-Type: application/json');

    $idmainpcb = $_REQUEST['idmainpcb'];
  
  $msjerr="";
		 try {
				
					$query_lista="
                    select * from fas_outcome_integral where reference in(
                        select reference from fas_outcome_integral where idtype = 4 and idfasoutcomecat = 0 and v_string = '".  $idmainpcb."'
                    and datetimeref in (	  select max(datetimeref) from fas_outcome_integral where idtype = 4 and idfasoutcomecat = 0 and v_string = '".  $idmainpcb."')
                  ) and idtype in(3,12,13)
                  
                    ";

                    $script= "N";
                    $totalpass="N";
                    $mainpcbstring="";

								//	echo $query_lista;
									$data = $connect->query($query_lista)->fetchAll();	
									foreach ($data as $row) {	
                                        
                                  //      echo "a".$row['idtype'];
                                        if( $row['idtype']==12 && $row['v_integer']==24 )
                                        {
                                            $script= "Y";
                                        }
                                        if( $row['idtype']==13 && $row['v_boolean']==true )
                                        {
                                            $totalpass= "Y";
                                        }
                                        if( $row['idtype']==3   )
                                        {
                                            $mainpcbstring = $row['v_string'];
                                        }
									}

							 
				
				} 
				catch (PDOException $e) 
				{
					
					$return_result_insert="error";
					$msjerr= "Syntax Error MM: ".$e->getMessage();
						
					
				}
		
		
	//echo $sql."<br>";

 echo(json_encode(["script"=>$script, "totalpass"=>$totalpass, "mainpcbstring"=>$mainpcbstring]));
 

?>
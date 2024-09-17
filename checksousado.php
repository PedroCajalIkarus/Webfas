<?php
  include("db_conect.php");
  	header('Content-Type: application/json');

    $vso_abuscar = $_REQUEST['so'];
  
  $msjerr="";
		 try {
				 $return_result_insert="free"; 
				 $query_lista="select wo_serialnumber from orders_sn where  so_soft_external = '". trim($vso_abuscar)."' and typeregister = 'SO' and processfasserver = true  order by wo_serialnumber desc ";
				//echo $query_lista;
				$data = $connect->query($query_lista)->fetchAll();	
				foreach ($data as $row) {			
				//	array_push($return_arr,  $row[0]);		
					if ($row[0] <> "")
					{
						$return_result_insert="used"; 
					}
					else
					{
						$return_result_insert="free"; 
					}
						
				 }


				} 
				catch (PDOException $e) 
				{
					
					$return_result_insert="error";
					$msjerr= "Syntax Error MM: ".$e->getMessage();
						
					
				}
		
		
	//echo $sql."<br>";

 echo(json_encode(["result"=>$return_result_insert,"erromsj"=>$msjerr]));
 

?>
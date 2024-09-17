<?php
  include("db_conect.php");
  	header('Content-Type: application/json');

    $vwo_abuscar = $_REQUEST['wo'];
  
  $msjerr="";
		 try {
				 $return_result_insert="free"; 
				 $query_lista="select * from orders_sn where  so_soft_external = '". trim($vwo_abuscar)."'  ";
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
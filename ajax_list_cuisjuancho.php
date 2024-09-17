<?php
 include("db_conectbypdf.php"); 
	include("funcionesstores.php"); 
	header('Content-Type: application/json');
	
	$palabra_a_buscar = $_REQUEST['q'];
	
	//$query_lista = list_all_cuis($palabra_a_buscar);
    $return_arr = array();
 	

		$query_lista= "select * from products where idproduct in(400,401,611,612,613,614) and upper(modelciu) like '%".strtoupper($palabra_a_buscar)."%' and  active = 'Y' order by modelciu";	
		$query_lista="select * from products inner join (
			select idproduct, max(idrevproduct) as maxidrev from products where  upper(modelciu) like '%".strtoupper($palabra_a_buscar)."%' and  active = 'Y' group by idproduct
				) as maxprod
				on maxprod.idproduct	=  products.idproduct and 
				maxprod.maxidrev		=  products.idrevproduct  order by modelciu";
	
	
	
	
	$data = $connect->query($query_lista)->fetchAll();	
	foreach ($data as $row) {			
	//	array_push($return_arr,  $row[0]);		
		$return_arr[] = array("id" => $row['idproduct'], "modelciu" => $row['modelciu'], "fiplexsku" => $row['fiplexsku'], "typeproduct" => $row['typeproduct'], "description" => $row['description'],"link"=>"User Manual: <a href='#'> XXXX </a>");		
	 }
	 /////////////////////////////////////////////////////
	 


/// echo(json_encode(["gi"=>$return_arr,"gifw"=>$return_arr_fw, "gisn"=>$return_arr_sn , "gilog"=>$return_arr_runinfo, "giciu"=>$return_arr_cius]));
 echo(json_encode(["items"=>$return_arr]));


?>
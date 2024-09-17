<?php
 include("db_conect.php"); 
	include("funcionesstores.php"); 
	//header('Content-Type: application/json');
	
	$palabra_a_buscar = $_REQUEST['q'];
	$vfrom = $_REQUEST['from'];
	//$query_lista = list_all_cuis($palabra_a_buscar);
    $return_arr = array();
 	

	$query_lista="select * from products inner join (
			select idproduct, max(idrevproduct) as maxidrev from products where   upper(modelciu) like '%".strtoupper($palabra_a_buscar)."%' and  active = 'Y' group by idproduct
				) as maxprod
				on maxprod.idproduct	=  products.idproduct and 
				maxprod.maxidrev		=  products.idrevproduct  order by modelciu";
	

	
	
	$data = $connect->query($query_lista)->fetchAll();	
	foreach ($data as $row) {			
	//	array_push($return_arr,  $row[0]);		
		$return_arr[] = array("id" => $row['idproduct'], "text" => $row['modelciu'], "description" => $row['description'],"link"=>"User Manual: <a href='#'> XXXX </a>");		
	 }
	 /////////////////////////////////////////////////////
	 


/// echo(json_encode(["gi"=>$return_arr,"gifw"=>$return_arr_fw, "gisn"=>$return_arr_sn , "gilog"=>$return_arr_runinfo, "giciu"=>$return_arr_cius]));
 echo(json_encode(["items"=>$return_arr]));

 /*
echo json_encode(array(
    array(
        "name"          => "Ducks",
        "img"           => "ducks",
        "city"          => "Anaheim",
        "id"            => "ANA",
        "conference"    => "Western",
        "division"      => "Pacific"
    ),
    array(
        "name"          => "Thrashers",
        "img"           => "thrashers",
        "city"          => "Atlanta",
        "id"            => "ATL",
        "conference"    => "Eastern",
        "division"      => "Southeast"
    )
 ));
 */
?>
<?php
 include("db_conect.php"); 
	include("funcionesstores.php"); 
	//header('Content-Type: application/json');
	
	$palabra_a_buscar = $_REQUEST['q'];
	$vfrom = $_REQUEST['from'];
	//$query_lista = list_all_cuis($palabra_a_buscar);
    $return_arr = array();
 	
	if ($vfrom =="WO")
	{
	////	$query_lista= "select * from products where idproduct in(400,401,611,612,613,614) and upper(modelciu) like '%".strtoupper($palabra_a_buscar)."%' and  active = 'Y' order by modelciu";	
		$query_lista="select * 
		from fnt_select_allproducts_maxrev() as products
		 inner join (
				select idproduct, max(idrevproduct) as maxidrev 
				from products where  idproduct in
						 (select distinct idproduct 
						 	from products_attributes where v_boolean= true and idattribute = 0) and 
							 upper(modelciu) like '%".strtoupper($palabra_a_buscar)."%' and  active = 'Y' group by idproduct
				union 

				select distinct idproduct, idrevproduct as maxidrev 
				from fnt_select_allproducts_maxrev()
				where iduniquebranchsonprod like '00010091%'  and 
				upper(modelciu) like '%".strtoupper($palabra_a_buscar)."%' and  active = 'Y'

				) as maxprod
				on maxprod.idproduct	=  products.idproduct and 
				maxprod.maxidrev		=  products.idrevproduct  order by modelciu";
	}
	else
	{
	////	$query_lista= "select * from products where  idproduct not  in(400,401,611,612,613,614)   and upper(modelciu) like '%".strtoupper($palabra_a_buscar)."%' and  active = 'Y' order by modelciu";	
		$query_lista="select products.* from fnt_select_allproducts_maxrev() as products
				
		inner join (
			select idproduct, max(idrevproduct) as maxidrev from products where   idproduct not in (select distinct idproduct from products_attributes where v_boolean= true and idattribute = 0) and upper(modelciu) like '%".strtoupper($palabra_a_buscar)."%' and  active = 'Y' group by idproduct
				) as maxprod
				on maxprod.idproduct	=  products.idproduct and 
				maxprod.maxidrev		=  products.idrevproduct  order by modelciu";
	}	
	
	
	
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
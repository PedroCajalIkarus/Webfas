<?php
 include("db_conect.php"); 
	include("funcionesstores.php"); 
	//header('Content-Type: application/json');
	
	$palabra_a_buscar = trim($_REQUEST['q']);
	$vfrom = $_REQUEST['from'];
	//$query_lista = list_all_cuis($palabra_a_buscar);
    $return_arr = array();
 	

		$query_lista= "
		select 'SO' as tipobusq, orders_sn.idorders,  so_soft_external as nombreencontrado, 'Associated with a SO' as description,  products.modelciu   from orders_sn
        INNER JOIN fnt_select_allproducts_maxrev() as  products
ON products.idproduct = orders_sn.idproduct 
inner join orders on orders.idorders = orders_sn.idorders and orders.active = 'Y'
where so_soft_external like '%".strtoupper($palabra_a_buscar)."%' and  so_soft_external like '%SO'
union
select 'WO', orders_sn.idorders, so_soft_external, 'Associated with a WO' , products.modelciu  from orders_sn
INNER JOIN fnt_select_allproducts_maxrev() as  products
ON products.idproduct = orders_sn.idproduct 
inner join orders on orders.idorders = orders_sn.idorders  and orders.active = 'Y'
where so_soft_external like '%".strtoupper($palabra_a_buscar)."%' and  so_soft_external like '%WO'
union
select 'RM', orders_sn.idorders, so_soft_external, 'Associated with a RM'  , products.modelciu  from orders_sn
INNER JOIN fnt_select_allproducts_maxrev() as  products
ON products.idproduct = orders_sn.idproduct 
inner join orders on orders.idorders = orders_sn.idorders  and orders.active = 'Y'
where so_soft_external like '%".strtoupper($palabra_a_buscar)."%' and  so_soft_external like '%RM'
union 
select orders.typeregister , orders_sn.idorders ,  wo_serialnumber,'Associated with a serial number '  , products.modelciu   from orders_sn
INNER JOIN fnt_select_allproducts_maxrev() as  products
ON products.idproduct = orders_sn.idproduct 
inner join orders on orders.idorders = orders_sn.idorders and orders.active = 'Y'
where wo_serialnumber like '%".strtoupper($palabra_a_buscar)."%' and products.modelciu not like '%LIC%'
union
select 'UP' , orders_sn.idorders ,  wo_serialnumber,'Associated with a serial number '  , products.modelciu   from orders_sn
INNER JOIN fnt_select_allproducts_maxrev() as  products
ON products.idproduct = orders_sn.idproduct 
inner join orders on orders.idorders = orders_sn.idorders and orders.active = 'Y'
where wo_serialnumber like '%".strtoupper($palabra_a_buscar)."%' and products.modelciu like '%LIC%'

";

	
	
	$data = $connect->query($query_lista)->fetchAll();	
	foreach ($data as $row) {			
	//	array_push($return_arr,  $row[0]);		
		$return_arr[] = array("id" => $row['idorders']."#". $row['tipobusq']."#". $row['nombreencontrado'], "text" => $row['nombreencontrado'], "description" => $row['description']." -> ".$row['modelciu'],"link"=>"","img"=> $row['tipobusq']);		
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
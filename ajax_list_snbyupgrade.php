<?php
 include("db_conect.php"); 
	include("funcionesstores.php"); 
	//header('Content-Type: application/json');
	
	$palabra_a_buscar = trim($_REQUEST['q']);
	$vfrom = $_REQUEST['from'];
	$vidsociu = $_REQUEST['idsociu'];
	//$query_lista = list_all_cuis($palabra_a_buscar);
    $return_arr = array();
 	

	$query_lista="select orders_sn.idproduct, orders_sn.idorders,  orders_sn.idproduct,so_soft_external , wo_serialnumber, modelciu 
	, fnt_select_upgrade_finalsku_ia_detect_lic(modelciu,'".$vidsociu."') as v_fsku 
	from orders_sn
	inner join fnt_select_allproducts_maxrev() as ppp
	on ppp.idproduct = orders_sn.idproduct
	where  so_soft_external LIKE '%SO' AND wo_serialnumber like '%".strtoupper($palabra_a_buscar)."%'
	and typeregister = 'SO' and iduniquebranchsonprod  like '%00010037%' 
	and orders_sn.idproduct in (select idproduct from products_attributes where idattribute = 105 ) 
	and wo_serialnumber not in (select distinct wo_serialnumber from orders_sn where typeregister = 'UP' and wo_serialnumber <>''   ) 
	";

	//echo $query_lista;
	//exit();

	$data = $connect->query($query_lista)->fetchAll();	
	foreach ($data as $row) {			
	//	array_push($return_arr,  $row[0]);		
	//echo " select * from fnt_select_upgrade_finalsku_ia_detect_lic('".$row['modelciu']."','".$vidsociu."') ";
			 
			$skucalculado = $row['v_fsku'];
		 	

		$return_arr[] = array("id" => $row['idorders']."|".$row['idproduct']."|".$row['so_soft_external']."|".$row['wo_serialnumber']."|".$row['modelciu']."|".$skucalculado, "text" => $row['so_soft_external']." || ".$row['wo_serialnumber']." || ".$row['modelciu']  , "description" => "PN Upgrade :","link"=>	$skucalculado);		
	 }

	/*
		$query_lista="select orders_sn.idproduct, orders_sn.idorders,  orders_sn.idproduct,so_soft_external , wo_serialnumber, modelciu   
		from orders_sn
		inner join fnt_select_allproducts_maxrev() as ppp
		on ppp.idproduct = orders_sn.idproduct
		where  so_soft_external LIKE '%SO' AND wo_serialnumber like '%".$palabra_a_buscar."%'
		and typeregister = 'SO' and iduniquebranchsonprod  like '%00010037%' 
		and orders_sn.idproduct in (select idproduct from products_attributes where idattribute = 105 ) 
		and wo_serialnumber not in (select distinct wo_serialnumber from orders_sn where typeregister = 'UP' and wo_serialnumber <>''   ) 
		";

 
	
	$data = $connect->query($query_lista)->fetchAll();	
	foreach ($data as $row) {			
	//	array_push($return_arr,  $row[0]);		
	//echo " select * from fnt_select_upgrade_finalsku_ia_detect_lic('".$row['modelciu']."','".$vidsociu."') ";
			$Sql_ifupgrade2 = $connect->prepare(" select * from fnt_select_upgrade_finalsku_ia_detect_lic('".$row['modelciu']."','".$vidsociu."') ");                                 
			$Sql_ifupgrade2->execute();
			$result_ifup2 = $Sql_ifupgrade2->fetchAll();	
			foreach ($result_ifup2 as $row_up2)
			{
			$skucalculado = $row_up2['v_fsku'];
			}	

		$return_arr[] = array("id" => $row['idorders']."|".$row['idproduct']."|".$row['so_soft_external']."|".$row['wo_serialnumber']."|".$row['modelciu']."|".$skucalculado, "text" => $row['so_soft_external']." || ".$row['wo_serialnumber']." || ".$row['modelciu']  , "description" => "PN Upgrade :","link"=>	$skucalculado);		
	 }
	 /////////////////////////////////////////////////////
	 
*/

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
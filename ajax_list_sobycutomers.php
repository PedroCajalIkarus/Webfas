<?php
 include("db_conect.php"); 
	include("funcionesstores.php"); 
	header('Content-Type: application/json');
	
	$idcust = $_REQUEST['idcust'];
		$nroso = trim($_REQUEST['nroso']);
		if ($nroso == "")
		{
				$query_lista = "select distinct orders_sn.ponumber, so_soft_external from orders_sn inner join orders on orders.idorders = orders_sn.idorders where orders.active = 'Y' and orders_sn.idcustomers = ".$idcust."  and orders_sn.typeregister <> 'WO' order by orders_sn.ponumber ";	
		}
		else
		{
			$query_lista = "select  distinct orders_sn.ponumber, so_soft_external   from orders_sn inner join orders on orders.idorders = orders_sn.idorders where orders.active = 'Y' and orders_sn.so_soft_external = '".$nroso."'  and orders_sn.typeregister <> 'WO'  order by orders_sn.ponumber";		
			
		}
	//	echo $query_lista;
		$seedtemp="";
		$queryatt="select coalesce( seedtemp,'') as  seedtemp from orders_sn inner join orders on orders.idorders = orders_sn.idorders
		left join orders_fileattach on orders_fileattach.idorders = orders.idorders  where orders.active = 'Y' and orders_sn.so_soft_external = '".$nroso."'";
	
		$dataatt = $connect->query($queryatt)->fetchAll();	
		foreach ($dataatt as $rowatt) {			
		//	array_push($return_arr,  $row[0]);		
			$seedtemp= $rowatt['seedtemp'];		
		 }
	 
 
    $return_arr = array();
 	
	
	
	
	$data = $connect->query($query_lista)->fetchAll();	
	foreach ($data as $row) {			
	//	array_push($return_arr,  $row[0]);	
	/// echo "ssssssssssssssssssss";
		$return_arr[] = array("id" => $row['ponumber'], "text" => $row['so_soft_external'],"seedtemp"=>$seedtemp);		
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
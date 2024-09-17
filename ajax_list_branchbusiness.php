<?php
 include("db_conect.php"); 
	include("funcionesstores.php"); 
	header('Content-Type: application/json');
   $return_arr = array();
 
 	$return_arr_ul = array();
	$return_arr_made = array();
	$return_arr_flia = array();
	$return_arr_fcc = array();
	$return_arr_ic = array();
	$return_arr_etsi = array();

	$seaccparamm = $_REQUEST['searc'];
	
 	$letrasbuscadas = array("/", ".", ",", "-", );
	
	$query_lista = "	select distinct  * from
	(
	select  public.full_tree_namever2_fullbusiness(iduniquebranchprodson, '') as stringtree, iduniquebranchprodson
	from (
		select  distinct iduniquebranchprodson
													 from business_branch_tree
													 inner join products_branch
													 on products_branch.idproductsbranch = business_branch_tree.idprodbranchson 
													 inner join products_branch as products_branchpp
													 on products_branchpp.idproductsbranch = business_branch_tree.idprodbranchfather  
											 where products_branch.active='Y' and idbusiness =1 
		 
											 
	) as viewtree
	) as alltree
 where iduniquebranchprodson like '%".$seaccparamm."%'
	order by stringtree"; 
	///searc

//	echo $query_lista;
	$data = $connect->query($query_lista)->fetchAll();	
	foreach ($data as $row) {			
	 
		$return_arr[] = array(
		 
			"stringtree"=> $row['stringtree']	,
			"iduniquebranchprodson"=> $row['iduniquebranchprodson']
		   );

	 }
	
	 /////////////////////////////////////////////////////
	 
	
	
	//print_r($return_arr);				
    //echo json_encode($return_arr);
 
 


 echo(json_encode(["losbranch"=>$return_arr]));

?>
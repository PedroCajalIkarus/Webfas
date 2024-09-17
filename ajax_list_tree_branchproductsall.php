<?php
 include("db_conect.php"); 
	
	header('Content-Type: application/json');
$array = array();	

	$query_lista = "select 0 idprodtree, idprodbranchfather, idprodbranchson, iduniquebranchprod, description, iduniquebranchprodson
from business_branch_tree
inner join products_branch
on products_branch.idproductsbranch = business_branch_tree.idprodbranchson 
union 
select 
0 , business_branch_tree.idprodbranchson, products.idproduct,
business_branch_tree.iduniquebranchprodson, products.modelciu, concat( business_branch_tree.iduniquebranchprodson , right(concat('0000',cast(products.idproduct as character varying) ),4) )
from products
 inner join business_branch_tree
on business_branch_tree.iduniquebranchprodson   = products.iduniquebranchsonprod


order by iduniquebranchprod ,  description ";


$array[] = array
						(
						  'id' => "a000000",						
						  'parent' => "#",
						    'text' => "FIPLEX Products"
						);
						
						
	$data = $connect->query($query_lista)->fetchAll();	
	foreach ($data as $row) {			
				//$array['id'] =  $row['iduniquebranch'];
			//$array['name'] = $row['nameidfasstepson'];
			//	$array['icon'] = 'fa fa-inbox';
			//	$array['parent_id'] = $row['idfasstepfather'];
			
						$nuevonombre = explode("#", $row['description']);
						///		echo "cant".count($nuevonombre)."---".$row['description'];
								$txtnombre="";
								if (count($nuevonombre) ==1)
								{
									$txtnombre=$row['description'];
								}
								else
								{
									$txtnombre=$nuevonombre[1];
								}
									
									$array[] = array
											(
											  'id' => "a".$row['iduniquebranchprodson'],						
											  'parent' => "a".$row['iduniquebranchprod'],
												'text' => $txtnombre,
												'icon'=> 'fa fa-inbox'
											);
											

	 }
	$resul =  $array;
	
	 /////////////////////////////////////////////////////
/*
	 
	 function search_branch( $iduniquebranchparam )
	 {
		 $arraytemp = array();	
		  include("db_conect.php"); 
		  $query_lista = "SELECT public.fnt_select_fas_tree('".$iduniquebranchparam."')";
		//  echo $query_lista ;
		  $data = $connect->query($query_lista)->fetchAll();	
			foreach ($data as $row2) 
			{			
					$obj = json_decode($row2[0]);
					
						
					$arraytemp=	  search_branch( $obj->{'iduniquebranch'} );
					$array[] = array
						(
						  'id' => $obj->{'iduniquebranch'},
						  'text' => $obj->{'nameidfasstepson'} ,
						  'parent' =>  $obj->{'idfasstepfather'} ,
						  'icon' => 'fa fa-inbox',
						  'children'=>$arraytemp
						);
						
				}
		return $array;
	 }
	 
	$resul =   search_branch('001');
*/
	 
echo(json_encode($resul));

?>
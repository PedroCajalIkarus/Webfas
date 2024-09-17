<?php
 include("db_conect.php"); 
	
	header('Content-Type: application/json');
$array = array();	

$idbu = $_REQUEST['idbu'];
$nmbu = $_REQUEST['nmbu'];
	$query_lista = "select 0 idprodtree, idprodbranchfather, idprodbranchson, iduniquebranchprod, description, iduniquebranchprodson
from business_branch_tree
inner join products_branch
on products_branch.idproductsbranch = business_branch_tree.idprodbranchson 
where products_branch.active='Y' and idbusiness =".$idbu." order by iduniquebranchprod ,  description ";


$nombrecabezaarbol = $nmbu.' Products';
if ($idbu<10)
{
	$nombrearbol  ="a000".$idbu;
}
else
{
	$nombrearbol  ="a00".$idbu;
}

$array[] = array
						(
						  'id' => $nombrearbol,						
						  'parent' => "#",
						    'text' => $nombrecabezaarbol
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
									$txtnombre=$row['description']." - [".$row['iduniquebranchprodson']."]";
								}
								else
								{
									$txtnombre=$nuevonombre[1]." - [".$row['iduniquebranchprodson']."]";
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
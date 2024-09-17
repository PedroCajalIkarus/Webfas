<?php
 include("db_conect.php"); 
	
	header('Content-Type: application/json');
$array = array();	

	$query_lista = "select distinct  boms.idboms as iduniquebranchprodson , '000000' as iduniquebranchprod, 0, partnumber as description,'a'
from boms
inner join boms_parts
on boms_parts.idbomsparts  = boms.idboms and
boms_parts.partclass = 'null' and  vendor_id = 48 order by iduniquebranchprod ,  description ";


$array[] = array
						(
						  'id' => "a000000",						
						  'parent' => "#",
						    'text' => "FIPLEX BOMS"
						);
						
						
	$data = $connect->query($query_lista)->fetchAll();	
	foreach ($data as $row) {			
				//$array['id'] =  $row['iduniquebranch'];
			//$array['name'] = $row['nameidfasstepson'];
			//	$array['icon'] = 'fa fa-inbox';
			//	$array['parent_id'] = $row['idfasstepfather'];
				
				$array[] = array
						(
						  'id' => "a".$row['iduniquebranchprodson'],						
						  'parent' => "a".$row['iduniquebranchprod'],
						    'text' => $row['description'],
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
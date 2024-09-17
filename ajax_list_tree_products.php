<?php
 include("db_conect.php"); 
	
	header('Content-Type: application/json');
$array = array();	
/*		

	$query_lista = "		select fas_tree.*  , fas_steppp.description as namefasstepfather 
, fas_stephh.description as nameidfasstepson
from 	fas_tree
inner join fas_step as fas_steppp
on fas_tree.idfasstepfather  = fas_steppp.idfasstep
inner join fas_step as fas_stephh
on fas_tree.idfastrepson  = fas_stephh.idfasstep
order by  fas_tree.iduniquebranch
";




	$data = $connect->query($query_lista)->fetchAll();	
	foreach ($data as $row) {			
				//$array['id'] =  $row['iduniquebranch'];
			//$array['name'] = $row['nameidfasstepson'];
			//	$array['icon'] = 'fa fa-inbox';
			//	$array['parent_id'] = $row['idfasstepfather'];
				
				$array[] = array
						(
						  'id' => $row['iduniquebranch'],
						  'text' => $row['nameidfasstepson'],
						  'parent_id' => $row['idfasstepfather'],
						  'icon' => 'fa fa-inbox'
						);

	 }
	*/
	
	 /////////////////////////////////////////////////////
//	 $query_lista = "SELECT public.fnt_select_fas_tree('001')";
	
	 
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
						  'parent_id' =>  $obj->{'idfasstepfather'} ,
						  'icon' => 'fa fa-inbox',
						  'children'=>$arraytemp
						);
						
				}
		return $array;
	 }
	 
	$resul =   search_branch('001');

	 
echo(json_encode($resul));

?>
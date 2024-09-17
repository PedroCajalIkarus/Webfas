<?php
error_reporting(0);
 include("db_conect.php"); 
	include("funcionesstores.php"); 
	header('Content-Type: application/json');
	///$query_lista = list_show_CIU_SN($_REQUEST['idsaleorders'],$_REQUEST['vciu']);
$v_idsaleordersBD= $_REQUEST['idsaleorders'];
	$v_idciu = $_REQUEST['vciu'];
	$query_lista= " select distinct coalesce(  orders_sn.wo_serialnumber,' --') sn, 1  from orders inner join products on products.idproduct = orders.idproduct  inner join orders_sn on orders_sn.idorders = orders.idorders  where  orders.typeregister = 'SO' and orders.active = 'Y' and orders.idorders =".$v_idsaleordersBD." and products.modelciu ='$v_idciu' and orders_sn.idnroserie >0";

    $return_arr = array();
  	//echo $query_lista;				
	$data = $connect->query($query_lista)->fetchAll();						
	
	$letrasbuscadas = array("/", ".", ",", "-", );

	foreach ($data as $row) {
			
					//$return_arr[] = array("sn" => $row[0],"ifdualband" => $row[1]
                    
					// por cada SO CIU Y SN y band		
						$tienemod=0;
						///buscamos aca. si tiene final chk.
						$tienefinalchk=0;
						$query_iffinalchk="";
				  $query_iffinalchk="SELECT distinct fas_tree_measure.totalpass::int as totalpassconvert,  fas_tree_measure.iduniqueop,  fas_step.description as namebranch,  fas_tree_measure.iduniquebranch, fas_tree_measure.unitsn, fas_tree_measure.dibsn, fas_tree_measure.uldl, fas_tree_measure.band
,fas_tree_measure.idrununfo
from fas_tree_measure
inner join fas_tree
on fas_tree.iduniquebranch = fas_tree_measure.iduniquebranch
inner join fas_step
on fas_step.idfasstep = fas_tree.idfastrepson
where fas_tree_measure.iduniquebranch  in('002007013','00200701B','00200701A','00200701C','00200701B02F0','002007030') and fas_tree_measure.iduniquebranch like '002%' and   unitsn = '".$row['sn']."'  order by iduniqueop";

$query_iffinalchk="SELECT distinct fas_tree_measure.totalpass::int as totalpassconvert
from fas_tree_measure
inner join fas_tree
on fas_tree.iduniquebranch = fas_tree_measure.iduniquebranch
inner join fas_step
on fas_step.idfasstep = fas_tree.idfastrepson
where fas_tree_measure.iduniquebranch  in('002007013','00200701B','00200701A','00200701C','00200701B02F0','002007030') and fas_tree_measure.iduniquebranch like '002%' and   unitsn = '".$row['sn']."' ";					
					 
						$data2 = $connect->query($query_iffinalchk)->fetchAll();		
					//	foreach ($data2 as $row2) {

							//$return_arr[] = array("sn" => $row[0],"ifdualband" => $row[1],"idband" => "","sn_modulo" => "","countdigm" =>"","totalpassdig" => "");
							$return_arr[] = array("sn" => $row[0],"ifdualband" => $row[1],"idband" => "",	"tienefinalchk" => $tienefinalchk,"countdigm" => "","totalpassdig" => "","sn_modulocalif" => "","countdigmcalif" => "","totalpassdigcalif" => "","sn_modulocaliffnchk" => "","countdigmcaliffnchk" => "","totalpassdigcaliffnchk" => "");									
										
					//	}
             
					
		//echo $row[0].",".$row[1];
	 }
	
	
					
 echo json_encode($return_arr);
 
 



?>
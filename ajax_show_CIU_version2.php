<?php
 include("db_conect.php"); 
	include("funcionesstores.php"); 
	header('Content-Type: application/json');
	
	
	$query_lista=" select *
from (  select orders.idorders as idsaleorders, products.modelciu as ciu ,0 as ifdualband2,  array_agg(coalesce(orders_sn.wo_serialnumber,'')) as groupxsn , count(distinct coalesce( orders_sn.wo_serialnumber,'0')) as cc_sn   from orders  inner join products on products.idproduct = orders.idproduct  inner join ( select orders.idorders, max(orders.idrev) as maxiderev from orders  inner join orders_sn on orders_sn.idorders = orders.idorders  where  orders.typeregister = 'SO' and orders.active = 'Y' and  orders.idorders = ".$_REQUEST['idsaleorders']." group by orders.idorders ) as maxidrevxpo on maxidrevxpo.idorders  = orders.idorders and maxidrevxpo.maxiderev =  orders.idrev inner join orders_sn  on orders_sn.idorders = orders.idorders and orders_sn.idnroserie >0  and orders_sn.idrev =  orders.idrev where  orders.typeregister = 'SO' and  orders.idorders = ".$_REQUEST['idsaleorders']." group by orders.idorders, products.modelciu, ifdualband2 ) as  list_so_cui

left join
( select so_sp.idsaleorders, so_sp.ciu, count(distinct digm.sn_unit)  as cantdib from  saleorders_specs so_sp 
  left join digmodule digm on digm.sn_unit = so_sp.sn_unit and digm.ciu_unit = so_sp.ciu  
	and digm.band = so_sp.idband  
    group by so_sp.idsaleorders, so_sp.ciu
) as so_conmodulos  on list_so_cui.idsaleorders = so_conmodulos.idsaleorders and
list_so_cui.ciu = so_conmodulos.ciu

left join
( select so_sp.idsaleorders, so_sp.ciu, count(distinct 	calibfchk.sn_unit)  as cantcalib from  saleorders_specs so_sp 
  left join calibrationfinalcheck calibfchk on calibfchk.sn_unit = so_sp.sn_unit and calibfchk.ciu_unit = so_sp.ciu and calibfchk.step = 0
    group by so_sp.idsaleorders, so_sp.ciu
) as so_concalibrat  on list_so_cui.idsaleorders = so_concalibrat.idsaleorders and
list_so_cui.ciu = so_concalibrat.ciu
left join
( select so_sp.idsaleorders, so_sp.ciu,  count(distinct calibfchk.sn_unit)  as cantfinalchk from  saleorders_specs so_sp 
  left join calibrationfinalcheck calibfchk on calibfchk.sn_unit = so_sp.sn_unit and calibfchk.ciu_unit = so_sp.ciu and calibfchk.step = 1
    group by  so_sp.idsaleorders,so_sp.ciu
) as so_concalibratfinalchk  
on list_so_cui.idsaleorders = so_concalibratfinalchk.idsaleorders and
list_so_cui.ciu = so_concalibratfinalchk.ciu";
	
	
    $return_arr = array();
//  	echo $query_lista;				
	//exit();
	$data = $connect->query($query_lista)->fetchAll();						
	$letrasbuscadas = array("/", ".", ",", "-", );

	foreach ($data as $row) {
		$rowciu_sincaractraros = str_replace($letrasbuscadas, "", $row[1]);
		$return_arr[] = array("ciu" => $row[1],
                    "cant_sn" => $row['cc_sn'],
					"ciu_sincara" => $rowciu_sincaractraros , 
					"ifdualband" => $row['ifdualband2'] , 
					"arraysn" => $row['groupxsn'] , 
						"cantdib" => $row['cantdib'] , 
						"cantcalib" => $row['cantcalib'] , 
						"cantfinalchk" => $row['cantfinalchk'] 
                    );
					
		//echo $row[0].",".$row[1];
	 }
	
	
					
 echo json_encode($return_arr);
 
 



?>
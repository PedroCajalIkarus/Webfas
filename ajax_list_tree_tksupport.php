<?php
 include("db_conect.php"); 
	
	header('Content-Type: application/json');
$array = array();	
 	session_start();

	if 	($_SESSION["g"] == "develop" || $_SESSION["g"] == "director"  || $_SESSION["g"] == "production"  ) 
					{
						
	$query_lista = " 
	select fas_techsupport.idcategory, fas_techsupport.idfas_techsupport, issue, idgrouper, keywordref,'tk' as typeunion, 0 as canttk
	from (
		select fas_techsupport.idfas_techsupport, max(datessupportstate) as maxdia
		from fas_techsupport
		inner join fas_techsupport_state
		on fas_techsupport.idfas_techsupport = fas_techsupport_state.idfas_techsupport
							
		group by fas_techsupport.idfas_techsupport
	) as maxestadoxtk
		inner join fas_techsupport
		on maxestadoxtk.idfas_techsupport = fas_techsupport.idfas_techsupport
		inner join fas_techsupport_state
		on maxestadoxtk.idfas_techsupport = fas_techsupport_state.idfas_techsupport and
		maxestadoxtk.maxdia = fas_techsupport_state.datessupportstate 
		inner join fas_techsupport_typestate
		on fas_techsupport_typestate.idtypestate = fas_techsupport_state.idstatesupport	
		left join userfas
		on userfas.iduserfas = fas_techsupport_state.idusersupport
		left join userfas as userfas_to
		on userfas_to.iduserfas = fas_techsupport.iduserto
		inner join fas_techsupport_category
		on fas_techsupport_category.idtechsupport_category = fas_techsupport.idcategory
		inner join business_area
		on business_area.idbusiness  = fas_techsupport.idbusiness and 
		business_area.idarea =  fas_techsupport.idarea
		left join fas_techsupport_messages
		on fas_techsupport_messages.idfas_techsupport = fas_techsupport.idfas_techsupport 
			where 	 fas_techsupport_typestate.idtypestate not in(3,7) and fas_techsupport.idgrouper is null
	union 
	select 0, idtechsupport_category, namecategory, 0, namecategory,'cat', canttk
from fas_techsupport_category 
inner join  (

	select distinct fas_techsupport.idcategory, count(distinct fas_techsupport.idfas_techsupport ) as canttk
	from (
		select fas_techsupport.idfas_techsupport, max(datessupportstate) as maxdia
		from fas_techsupport
		inner join fas_techsupport_state
		on fas_techsupport.idfas_techsupport = fas_techsupport_state.idfas_techsupport
							
		group by fas_techsupport.idfas_techsupport
	) as maxestadoxtk
		inner join fas_techsupport
		on maxestadoxtk.idfas_techsupport = fas_techsupport.idfas_techsupport
		inner join fas_techsupport_state
		on maxestadoxtk.idfas_techsupport = fas_techsupport_state.idfas_techsupport and
		maxestadoxtk.maxdia = fas_techsupport_state.datessupportstate 
		inner join fas_techsupport_typestate
		on fas_techsupport_typestate.idtypestate = fas_techsupport_state.idstatesupport	
		left join userfas
		on userfas.iduserfas = fas_techsupport_state.idusersupport
		left join userfas as userfas_to
		on userfas_to.iduserfas = fas_techsupport.iduserto
		inner join fas_techsupport_category
		on fas_techsupport_category.idtechsupport_category = fas_techsupport.idcategory
		inner join business_area
		on business_area.idbusiness  = fas_techsupport.idbusiness and 
		business_area.idarea =  fas_techsupport.idarea
		left join fas_techsupport_messages
		on fas_techsupport_messages.idfas_techsupport = fas_techsupport.idfas_techsupport 
			where 	 fas_techsupport_typestate.idtypestate not in(3,7) and fas_techsupport.idgrouper is null
	group by fas_techsupport.idcategory
	) as lascantidades
	on lascantidades.idcategory = fas_techsupport_category.idtechsupport_category 
	
							";
					}
					else
					{
						
							$query_lista = " 
	select fas_techsupport.idcategory, fas_techsupport.idfas_techsupport, issue, idgrouper, keywordref ,'tk' as typeunion, 0 as canttk
	from (
		select fas_techsupport.idfas_techsupport, max(datessupportstate) as maxdia
		from fas_techsupport
		inner join fas_techsupport_state
		on fas_techsupport.idfas_techsupport = fas_techsupport_state.idfas_techsupport
		where fas_techsupport.userreported = '".$_SESSION["b"]."' or fas_techsupport.iduserto	= ".$_SESSION["a"]."  						
		group by fas_techsupport.idfas_techsupport
	) as maxestadoxtk
		inner join fas_techsupport
		on maxestadoxtk.idfas_techsupport = fas_techsupport.idfas_techsupport
		inner join fas_techsupport_state
		on maxestadoxtk.idfas_techsupport = fas_techsupport_state.idfas_techsupport and
		maxestadoxtk.maxdia = fas_techsupport_state.datessupportstate 
		inner join fas_techsupport_typestate
		on fas_techsupport_typestate.idtypestate = fas_techsupport_state.idstatesupport	
		left join userfas
		on userfas.iduserfas = fas_techsupport_state.idusersupport
		left join userfas as userfas_to
		on userfas_to.iduserfas = fas_techsupport.iduserto
		inner join fas_techsupport_category
		on fas_techsupport_category.idtechsupport_category = fas_techsupport.idcategory
		inner join business_area
		on business_area.idbusiness  = fas_techsupport.idbusiness and 
		business_area.idarea =  fas_techsupport.idarea
		left join fas_techsupport_messages
		on fas_techsupport_messages.idfas_techsupport = fas_techsupport.idfas_techsupport 
			where 	 fas_techsupport_typestate.idtypestate  not in(3,7) and fas_techsupport.idgrouper is null
			and fas_techsupport.userreported = '".$_SESSION["b"]."' or fas_techsupport.iduserto	= ".$_SESSION["a"]."  	
	union 
	select 0, idtechsupport_category, namecategory, 0, namecategory,'cat', canttk
from fas_techsupport_category 
inner join  (

	select distinct fas_techsupport.idcategory, count(distinct fas_techsupport.idfas_techsupport ) as canttk
	from (
		select fas_techsupport.idfas_techsupport, max(datessupportstate) as maxdia
		from fas_techsupport
		inner join fas_techsupport_state
		on fas_techsupport.idfas_techsupport = fas_techsupport_state.idfas_techsupport
			where fas_techsupport.userreported = '".$_SESSION["b"]."' or fas_techsupport.iduserto	= ".$_SESSION["a"]."  						
		group by fas_techsupport.idfas_techsupport
	) as maxestadoxtk
		inner join fas_techsupport
		on maxestadoxtk.idfas_techsupport = fas_techsupport.idfas_techsupport
		inner join fas_techsupport_state
		on maxestadoxtk.idfas_techsupport = fas_techsupport_state.idfas_techsupport and
		maxestadoxtk.maxdia = fas_techsupport_state.datessupportstate 
		inner join fas_techsupport_typestate
		on fas_techsupport_typestate.idtypestate = fas_techsupport_state.idstatesupport	
		left join userfas
		on userfas.iduserfas = fas_techsupport_state.idusersupport
		left join userfas as userfas_to
		on userfas_to.iduserfas = fas_techsupport.iduserto
		inner join fas_techsupport_category
		on fas_techsupport_category.idtechsupport_category = fas_techsupport.idcategory
		inner join business_area
		on business_area.idbusiness  = fas_techsupport.idbusiness and 
		business_area.idarea =  fas_techsupport.idarea
		left join fas_techsupport_messages
		on fas_techsupport_messages.idfas_techsupport = fas_techsupport.idfas_techsupport 
			where 	 fas_techsupport_typestate.idtypestate not in(3,7) and fas_techsupport.idgrouper is null
			and fas_techsupport.userreported = '".$_SESSION["b"]."' or fas_techsupport.iduserto	= ".$_SESSION["a"]."  	
	group by fas_techsupport.idcategory
	) as lascantidades
	on lascantidades.idcategory = fas_techsupport_category.idtechsupport_category 
  	)
							";
					}


$array[] = array
						(
						  'id' => "a0",						
						  'parent' => "#",
						    'text' => "Ticket Tree Manager by Category "
						);
						
						
	$data = $connect->query($query_lista)->fetchAll();	
	foreach ($data as $row) {			
				//$array['id'] =  $row['iduniquebranch'];
			//$array['name'] = $row['nameidfasstepson'];
			//	$array['icon'] = 'fa fa-inbox';
			//	$array['parent_id'] = $row['idfasstepfather'];
				if ( $row['typeunion'] =="tk")
				{
						$array[] = array
						(
						  'id' => "a".$row['idfas_techsupport'],						
						  'parent' => "a".$row['idcategory'],
						    'text' => substr($row['issue'],0,40)."<br>".$row['keywordref'],
							 'title' => $row['keywordref']." ".$row['issue'],   								
							'icon'=> 'fa fa-inbox'
						);
				}
				else
				{
						$array[] = array
						(
						  'id' => "a".$row['idfas_techsupport'],						
						  'parent' => "a".$row['idcategory'],
						    'text' => "Category:".substr($row['keywordref'],0,32)." [".$row['canttk']."]".,
							 'title' => $row['keywordref']." ".$row['issue'],   							
							'icon'=> 'fa fa-inbox'
						);
				}
			
						

	 }
	$resul =  $array;
	
	 
echo(json_encode($resul));

?>
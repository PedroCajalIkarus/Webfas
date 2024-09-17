<?php
  include("db_conect.php");
  	header('Content-Type: application/json');

    $vvvidproduct = $_REQUEST['idproduct'];
  
  $msjerr="";
		 try {
				 $return_result_insert="free"; 
 
$encontrealgo="N";
/*
$query_lista="
select distinct woparam,powersupply,coalesce(dlgain,'9999') as dlgain,coalesce(ulgain,'9999') as ulgain,coalesce(dlmaxpwr,'9999')as dlmaxpwr, coalesce(ulmaxpwr,'9999') as ulmaxpwr, objectband.idband, coalesce(objectband.idband,9999) as idbandifnull, fstartul, fstopul, fstartdl, fstopdl , idband.description , coalesce(fas_instruments_parameters.idproduct ,0) as haveconfiguration,
CASE  
when idband.description like '700%' then 0
when idband.description like '800%' then 1
when idband.description like 'VHF%' then 2
when idband.description like 'UHF%' then 3
when idband.description like 'UHF%' then 8
else 99
end bandorder, coalesce(products_attributes.v_double,1) as cantsubband,  coalesce(products_attributes.v_boolean,false) as isfullband
from products 

left join objectband
on objectband.ciu = products.modelciu and
   objectband.idrev in (	select  max(idrev)  from objectband where idproduct  = ". trim($vvvidproduct).")
left join idband
on idband.idband = objectband.idband
left join fas_instruments_parameters
on fas_instruments_parameters.idproduct = products.idproduct 

left join products_attributes
on products_attributes.idproduct = products.idproduct and
   products_attributes.v_integer = objectband.idband and
   products_attributes.idattribute = 72

where  products.idproduct = ". trim($vvvidproduct)." and products.idrevproduct in (	select  max(idrevproduct)  from products where idproduct  = ". trim($vvvidproduct).")  ";
*/

/*
$query_lista="
select distinct woparam,powersupply,coalesce(dlgain,'9999') as dlgain,coalesce(ulgain,'9999') as ulgain,coalesce(dlmaxpwr,'9999')as dlmaxpwr, coalesce(ulmaxpwr,'9999') as ulmaxpwr, objectband.idband, coalesce(objectband.idband,9999) as idbandifnull, fstartul, fstopul, fstartdl, fstopdl , idband.description , coalesce(fas_instruments_parameters.idproduct ,0) as haveconfiguration,
CASE  
when idband.description like '700%' then 0
when idband.description like '800%' then 1
when idband.description like 'VHF%' then 2
when idband.description like 'UHF%' then 3
when idband.description like 'UHF%' then 8
else 99
end bandorder, coalesce(products_attributes.v_double,1) as cantsubband,  coalesce(products_attributes.v_boolean,false) as isfullband
from products 

left join fas_instruments_parameters
on fas_instruments_parameters.idproduct = products.idproduct 

left join products_attributes
on products_attributes.idproduct = products.idproduct and 
   products_attributes.idattribute = 72
   
   
left join idband
on idband.idband = products_attributes.v_integer 

left join fnt_select_objectband_maxrev() as  objectband
on objectband.ciu = products.modelciu and
   objectband.idband =  idband.issubband::integer

where  products.idproduct = ". trim($vvvidproduct)." and products.idrevproduct in (	select  max(idrevproduct)  from products where idproduct  = ". trim($vvvidproduct).") order by bandorder";
*/
$query_lista="
select distinct woparam,powersupply,coalesce(dlgain,'9999') as dlgain,coalesce(ulgain,'9999') as ulgain,coalesce(dlmaxpwr,'9999')as dlmaxpwr, coalesce(ulmaxpwr,'9999') as ulmaxpwr, objectband.idband, coalesce(objectband.idband,9999) as idbandifnull, fstartul, fstopul, fstartdl, fstopdl , idband.description , coalesce(fas_instruments_parameters.idproduct ,0) as haveconfiguration,
CASE  
when idband.description like '700%' then 0
when idband.description like '800%' then 1
when idband.description like 'VHF%' then 2
when idband.description like 'UHF%' then 3
when idband.description like 'UHF%' then 8
else 99
end bandorder, coalesce(products_attributes.v_double,1) as cantsubband,  coalesce(products_attributes.v_boolean,false) as isfullband
from products 

inner join objectband
on objectband.ciu = products.modelciu and
   objectband.idrev in (	select  max(idrev)  from objectband where idproduct  = ". trim($vvvidproduct).")
inner join idband
on idband.idband = objectband.idband and idband.issubband is false
left join fas_instruments_parameters
on fas_instruments_parameters.idproduct = products.idproduct 

left join products_attributes
on products_attributes.idproduct = products.idproduct and
   products_attributes.v_integer = objectband.idband and
   products_attributes.idattribute = 72

where  products.idproduct = ". trim($vvvidproduct)." and products.idrevproduct in (	select  max(idrevproduct)  from products where idproduct  =". trim($vvvidproduct).")  

union 



select distinct woparam,powersupply,coalesce(dlgain,'9999') as dlgain,coalesce(ulgain,'9999') as ulgain,coalesce(dlmaxpwr,'9999')as dlmaxpwr, coalesce(ulmaxpwr,'9999') as ulmaxpwr, objectband.idband, coalesce(objectband.idband,9999) as idbandifnull, fstartul, fstopul, fstartdl, fstopdl , idband.description , coalesce(fas_instruments_parameters.idproduct ,0) as haveconfiguration,
CASE  
when idband.description like '700%' then 0
when idband.description like '800%' then 1
when idband.description like 'VHF%' then 2
when idband.description like 'UHF%' then 3
when idband.description like 'UHF%' then 8
else 99
end bandorder, coalesce(products_attributes.v_double,1) as cantsubband,  coalesce(products_attributes.v_boolean,false) as isfullband
from products 

left join fas_instruments_parameters
on fas_instruments_parameters.idproduct = products.idproduct 

inner join products_attributes
on products_attributes.idproduct = products.idproduct and 
   products_attributes.idattribute = 72
   
   
inner join idband
on idband.idband = products_attributes.v_integer and idband.issubband is true

left join fnt_select_objectband_maxrev() as  objectband
on objectband.ciu = products.modelciu and
   objectband.idband =  idband.issubband::integer

where  products.idproduct = ". trim($vvvidproduct)." and products.idrevproduct in (	select  max(idrevproduct)  from products where idproduct  = ". trim($vvvidproduct).") order by bandorder";


		//	echo $query_lista;
		$haveconfiguration=10 ; 

				$data = $connect->query($query_lista)->fetchAll();	
				foreach ($data as $row) {			
				//	array_push($return_arr,  $row[0]);		
					
						$retur_woparam=$row['woparam'] ; 
						$retur_powersupply=$row['powersupply'] ; 
						$vdlgain=round($row['dlgain']) ; 
						$vulgain=round($row['ulgain']) ; 
						$vdlmaxpwr=round($row['dlmaxpwr']) ; 
						$vulmaxpwr=round($row['ulmaxpwr']) ; 
						
						$haveconfiguration=round($row['haveconfiguration']) ; 
						$haveconfiguration=10 ; 
						
					//	$retur_woparam=$row['woparam'] ; 
					
			//		echo $row['idband'];
			/// if para no mostrar NAN en order_sn_spec.. creadas desde WO
					if (9999 != $row['idbandifnull'])
					{
						$return_arr_dpxunit[] = array("idch" => $row['idband'],
						"fstartul" => $row['fstartul'],
						"fstopul" => $row['fstopul'],
						"fstartdl" => $row['fstartdl'],
						"fstopdl" => $row['fstopdl'],
						"nomband" => $row['description'],
						"cantsubband" => $row['cantsubband'],
						"isfullband" => $row['isfullband']
						);
						$encontrealgo="S";
					}
					
					
						
				 }

				if ($haveconfiguration <=0)
				{
					///Controlamos si no es BTTY.. el CIU
					$query_lista="select distinct woparam,powersupply
					from products 
					where  iduniquebranchsonprod like '%000100370041%' and  products.idproduct = ". trim($vvvidproduct)." and products.idrevproduct in (	select  max(idrevproduct)  from products where idproduct  = ". trim($vvvidproduct).") ";
								//	echo $query_lista;
									$data = $connect->query($query_lista)->fetchAll();	
									foreach ($data as $row) {	
										$retur_woparam=$row['woparam'] ; 
										$retur_powersupply=$row['powersupply'] ;
										$haveconfiguration=1; 
									}

									$vdlgain=0 ; 
									$vulgain=0 ; 
									$vdlmaxpwr=0 ; 
									$vulmaxpwr=0 ; 
				}
				if ($haveconfiguration <=0)
				{
					///Controlamos si flia enterprsie master
					$query_lista="select distinct woparam,powersupply
					from products 
					where  iduniquebranchsonprod like '%000100370040004900520054%' and  products.idproduct = ". trim($vvvidproduct)." and products.idrevproduct in (	select  max(idrevproduct)  from products where idproduct  = ". trim($vvvidproduct).") ";
								//	echo $query_lista;
									$data = $connect->query($query_lista)->fetchAll();	
									foreach ($data as $row) {	
										$retur_woparam=$row['woparam'] ; 
										$retur_powersupply=$row['powersupply'] ;
										$haveconfiguration=1; 
									}

								 
									$vdlgain=0 ; 
									$vulgain=0 ; 
									$vdlmaxpwr=0 ; 
									$vulmaxpwr=0 ; 

				}
				if ($haveconfiguration <=0)
				{
					///Controlamos si flia LEGACY
					$query_lista="select distinct woparam,powersupply
					from products 
					LEFT join objectband
					on objectband.ciu = products.modelciu and
   					objectband.idrev in (	select  max(idrev)  from objectband where idproduct  = ". trim($vvvidproduct).")
					where  iduniquebranchsonprod like '000100010038%' and  products.idproduct = ". trim($vvvidproduct)." and products.idrevproduct in (	select  max(idrevproduct)  from products where idproduct  = ". trim($vvvidproduct).") ";
								//	echo $query_lista;
							//	00010001003800820084
									$data = $connect->query($query_lista)->fetchAll();	
									foreach ($data as $row) {	
										$retur_woparam=true; 
										$retur_powersupply=$row['powersupply'] ;
										$haveconfiguration=1; 
									}

								 
									$vdlgain=0 ; 
									$vulgain=0 ; 
									$vdlmaxpwr=0 ; 
									$vulmaxpwr=0 ; 

				}
				if ($haveconfiguration <=0)
				{
					///Controlamos si PASSIVEs
					$query_lista="select distinct woparam,powersupply
					from products 
					where  iduniquebranchsonprod like '00010091%' and  products.idproduct = ". trim($vvvidproduct)." and products.idrevproduct in (	select  max(idrevproduct)  from products where idproduct  = ". trim($vvvidproduct).") ";
								//	echo $query_lista;
									$data = $connect->query($query_lista)->fetchAll();	
									foreach ($data as $row) {	
										$retur_woparam=true; 
										$retur_powersupply=$row['powersupply'] ;
										$haveconfiguration=1; 
									}

								 
									$vdlgain=0 ; 
									$vulgain=0 ; 
									$vdlmaxpwr=0 ; 
									$vulmaxpwr=0 ; 

				}
				//////00010096 ACCESSORIES
				if ($haveconfiguration <=0)
				{
					///Controlamos si PASSIVEs
					$query_lista="select distinct woparam,powersupply
					from products 
					where  (iduniquebranchsonprod like '00010096%' or iduniquebranchsonprod like '000100020097%'   ) and  products.idproduct = ". trim($vvvidproduct)." and products.idrevproduct in (	select  max(idrevproduct)  from products where idproduct  = ". trim($vvvidproduct).") ";
								//	echo $query_lista;
									$data = $connect->query($query_lista)->fetchAll();	
									foreach ($data as $row) {	
										$retur_woparam=false; 
										$retur_powersupply=$row['powersupply'] ;
										$haveconfiguration=1; 
									}

								 
									$vdlgain=0 ; 
									$vulgain=0 ; 
									$vdlmaxpwr=0 ; 
									$vulmaxpwr=0 ; 

				}

				if ($haveconfiguration <=0)
				{
					///Controlamos si flia DPX or ACF
					$query_lista="select distinct woparam,powersupply
					from products 
					where (   iduniquebranchsonprod like '%00020007') and  products.idproduct = ". trim($vvvidproduct)." and products.idrevproduct in (	select  max(idrevproduct)  from products where idproduct  = ". trim($vvvidproduct).") ";
								//	echo $query_lista;
									$data = $connect->query($query_lista)->fetchAll();	
									foreach ($data as $row) {	
										$retur_woparam=true; 
										$retur_powersupply=$row['powersupply'] ;
										$haveconfiguration=1; 
									}

								 
									$vdlgain=0 ; 
									$vulgain=0 ; 
									$vdlmaxpwr=0 ; 
									$vulmaxpwr=0 ; 

				}

				if ($haveconfiguration <=0)
				{
					///Controlamos si flia DPX or ACF
					$query_lista="select distinct woparam,powersupply
					from products 
					where ( iduniquebranchsonprod like '%000100020095%'  ) and  products.idproduct = ". trim($vvvidproduct)." and products.idrevproduct in (	select  max(idrevproduct)  from products where idproduct  = ". trim($vvvidproduct).") ";
								//	echo $query_lista;
									$data = $connect->query($query_lista)->fetchAll();	
									foreach ($data as $row) {	
										$retur_woparam=false; 
										$retur_powersupply=$row['powersupply'] ;
										$haveconfiguration=1; 
									}

								 
									$vdlgain=0 ; 
									$vulgain=0 ; 
									$vdlmaxpwr=0 ; 
									$vulmaxpwr=0 ; 

				}
				/////000100010094  ANALOG BDA
				if ($haveconfiguration <=0)
				{
					///Controlamos si Inline Booster
					$query_lista="select distinct woparam,powersupply
					from products 
					where ( iduniquebranchsonprod like '%000100010094%'  ) and  products.idproduct = ". trim($vvvidproduct)." and products.idrevproduct in (	select  max(idrevproduct)  from products where idproduct  = ". trim($vvvidproduct).") ";
								//	echo $query_lista;
									$data = $connect->query($query_lista)->fetchAll();	
									foreach ($data as $row) {	
										$retur_woparam=false; 
										$retur_powersupply=$row['powersupply'] ;
										$haveconfiguration=1; 
									}

								 
									$vdlgain=0 ; 
									$vulgain=0 ; 
									$vdlmaxpwr=0 ; 
									$vulmaxpwr=0 ; 

				}


				} 
				catch (PDOException $e) 
				{
					
					$return_result_insert="error";
					$msjerr= "Syntax Error MM: ".$e->getMessage();
						
					
				}
		
		
	//echo $sql."<br>";

 echo(json_encode(["woparam"=>$retur_woparam, "arr_dpxunit"=>$return_arr_dpxunit, "powersupply"=>$retur_powersupply,"dlgain"=>$vdlgain,"ulgain"=>$vulgain,"dlmaxpwr"=>$vdlmaxpwr,"ulmaxpwr"=>$vulmaxpwr,"haveconfiguration"=>$haveconfiguration]));
 

?>
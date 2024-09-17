<?php
  include("db_conect.php");
 	header('Content-Type: application/json');
  $vvidpo = $_REQUEST['idpo'];
  
  $sqlstate = $connect->prepare("SELECT * from orders_states WHERE   idorders =:vvidlog   and idstate = 2   ");
  $sqlstate->bindParam(':vvidlog', $vvidpo);
  $sqlstate->execute();
  $resultadosatete = $sqlstate->fetchAll();
   $return_arr = array();

   $estacompleto="N";
   
   foreach ($resultadosatete as $rowstate) 
   {
	$estacompleto="Y";
   }



   $query_lista ="select * from idband where idband in
   	(
		select idband from fnt_select_objectband_maxrev() where idproduct in (select distinct idproduct from orders_sn where idorders =".$vvidpo."  )
		union
		select distinct idband from orders_sn_specs where idorders =".$vvidpo." 
    )";
    $return_arr = array();
 
	
 	$letrasbuscadas = array("/", ".", ",", "-", );
	
	 $return_arr_bandas = array();
	$datamm = $connect->query($query_lista)->fetchAll();	
	foreach ($datamm as $rowm1) {			
		array_push($return_arr_bandas,  $rowm1);					
	 }
	


	  	  
//	  $sql = $connect->prepare("SELECT presales.idproduct,  presales.idpresales, presales.idcustomers, presales.idfamilyprod, presales.idtypeband, presales.idtypeproduct, products.idproduct,presales.idconfiguration, products.modelciu as ciu, idrev, so_soft_external, idruninfo, ponumber, pwrsupplytype,rcgfbwa, moden_dig, date_approved, coalesce(presales.descripcion,'-') as descripcion, ul_gain, ul_max_pwr, dl_gain, dl_max_pwr, req_ppassy, req_calibration, req_spec, req_other, nameapproved, quantity, coalesce(notes,' ') as notes, reqresources	FROM presales  inner join products on products.idproduct = presales.idproduct WHERE presales.typeregister='PO' and  idpresales = :vvidlog and idrev in (select max(idrev) from presales  WHERE presales.typeregister='PO' and  idpresales =:vvidlog ) ");
	  	  $sql = $connect->prepare("SELECT orders.idproduct,  orders.idorders as idpresales , orders_sn.so_soft_external,  orders.idcustomers, orders.idfamilyprod, 
			orders.idtypeband, orders.idtypeproduct, products.idproduct,
orders.idconfiguration, products.modelciu as ciu, orders.idrev,  orders.idruninfo, ponumber, pwrsupplytype,rcgfbwa, 
moden_dig, orders.date_approved, coalesce(orders_sn.descripcion,'-') as descripcion, ul_gain, ul_max_pwr, dl_gain, 
dl_max_pwr, req_ppassy, req_calibration, req_spec, req_other, orders.nameapproved, quantity, coalesce(orders_sn.notes,' ') as notes, reqresources, products.description as  descrpicionciu
, orders_attributes.v_boolean::integer as isupgrade, products_upgrades.upgrcode
FROM orders 
inner join orders_sn
on orders_sn.idorders = orders.idorders and
orders_sn.idrev = orders.idrev  and
orders_sn.idnroserie = 0
inner join fnt_select_allproducts_maxrev()  as  products on products.idproduct = orders.idproduct 

left join  orders_attributes
 on orders_attributes.idorders  =  orders_sn.idorders and
 orders_attributes.idattribute_orders = 2
 left join products_upgrades
 on products_upgrades.idprodup = orders_attributes.v_integer

WHERE orders.typeregister in('PO','SO','RM','UP')
and  orders.idorders =:vvidlog
and orders.idrev in (select max(idrev) from orders  WHERE orders.typeregister in('PO','SO','RM','UP') and  idorders =:vvidlog ) ");

	  $sql->bindParam(':vvidlog', $vvidpo);
    $sql->execute();
    $resultado = $sql->fetchAll();
	 $return_arr = array();

	 foreach ($resultado as $row) 
	 {
		 $vuserruninfo = $row[2];
		$vstation = $row[3];
		$vdevice = $row[4];
	    $vmostrar = "".trim(substr($row[0],0,10))."\r\n". str_replace("###","",$row[1]);
		$vdescrpicionciu = $row['descrpicionciu'];
		if ($row['descripcion']=="" or $row['descripcion'] == null)
		{
			$vdescrpicion = "-";
		}
		else
		{
		$vdescrpicion = $row['descripcion']	;
		}
		if ($row['notes']=="" or $row['notes'] == null)
		{
			$vnotes = "-";
		}
		else
		{
		$vnotes = $row['notes']	;
		}
		
		if (  $row['isupgrade'] == 1  )
		{
			$elciu= $row['upgrcode'];  
		}
		else
		{
			$elciu=$row['ciu']; 
		}

	
		 
		 $return_arr[] = array("descripcion" => $vdescrpicion,
					 "descripcionciu" => $vdescrpicionciu,
                    "notes" => $vnotes,
					"idpresales"=>$row['idpresales'],
					"idproduct"=>$row['idproduct'],
					"ciu"=>$elciu,
					"idrev"=>$row['idrev'],
					"so_soft_external"=>$row['so_soft_external'],
				    "ponumber"=>$row['ponumber'],
					"pwrsupplytype"=>$row['pwrsupplytype'],
					"rcgfbwa"=>$row['rcgfbwa'],
					"moden_dig"=>$row['moden_dig'],
					"date_approved"=>$row['date_approved'],
					"ul_gain"=>$row['ul_gain'],
					"ul_max_pwr"=>$row['ul_max_pwr'],
					"dl_gain"=>$row['dl_gain'],
					"dl_max_pwr"=>$row['dl_max_pwr'],
					"req_ppassy"=>$row['req_ppassy'],
					"req_calibration"=>$row['req_calibration'],
					"req_spec"=>$row['req_spec'],
					"req_other"=>$row['req_other'],
					"nameapproved"=>$row['nameapproved'],
					"quantity"=>$row['quantity'],
					"reqresources"=>$row['reqresources'],
					"estacompletalaso"=>$estacompleto
                    );
				
		
	 }
	 


	 	 
	 //Si esta procesado solo muestros idnroserie >0 sino = 0
	   $sql = $connect->prepare("SELECT distinct orders_sn_specs.*, orders_sn.*, idband.description ,orders_sn_specs.notes as notesch,
	          CASE 
             when idband.description like '700%' then 0
             when idband.description like '800%' then 1
             when idband.description like 'VHF%' then 2
             when idband.description like 'UHF%' then 3
             else 99
           end bandorder
		     FROM orders_sn_specs 
	   inner join orders_sn
ON orders_sn.idorders  = orders_sn_specs.idorders AND
orders_sn.idrev      =  orders_sn_specs.idrev AND
orders_sn.idnroserie = orders_sn_specs.idnroserie  
left join idband
on idband.idband = orders_sn_specs.idband

WHERE  orders_sn.processfasserver = true  and orders_sn_specs.idnroserie =1 and  orders_sn_specs.idorders = :vvidlog  
and orders_sn_specs.idrev in (select max(idrev) from orders  WHERE  idorders =:vvidlog ) 

 union SELECT  orders_sn_specs.*, orders_sn.*, idband.description ,orders_sn_specs.notes as notesch
 ,
	          CASE 
             when idband.description like '700%' then 0
             when idband.description like '800%' then 1
             when idband.description like 'VHF%' then 2
             when idband.description like 'UHF%' then 3
             else 99
           end bandorder
 FROM orders_sn_specs 
 inner join orders_sn
								ON orders_sn.idorders  = orders_sn_specs.idorders AND
								orders_sn.idrev      =  orders_sn_specs.idrev AND
								orders_sn.idnroserie = orders_sn_specs.idnroserie  
								left join idband
on idband.idband = orders_sn_specs.idband
								WHERE    orders_sn_specs.idnroserie = 0 and    orders_sn_specs.idnroserie  in(select max(idnroserie) from orders_sn  WHERE  idorders =:vvidlog) and 
								orders_sn_specs.idorders = :vvidlog  and orders_sn_specs.idrev in (select max(idrev) from orders  WHERE  idorders =:vvidlog )   order by typedata, bandorder,idch ");
	  $sql->bindParam(':vvidlog', $vvidpo);
    $sql->execute();
    $resultado2 = $sql->fetchAll();
	 
	$return_arr_dpx = array();
	$return_arr_unit = array();
	 $return_arr_ch = array();
	 	 $return_arr_stock = array();
		  $return_arr_stock_det = array();

	 $tieneunit =0;
	 foreach ($resultado2 as $row2) 
	 {
		 if ( $row2['typedata']=="CHANNEL")
		 {
			  $return_arr_ch[] = array("idch" => $row2['idch'],
                    "ul_ch_fr" => $row2['ul_ch_fr'],
					"dl_ch_fr" => $row2['dl_ch_fr'],
						"notes" => $row2['notesch'],
						"idband" => $row2['idband'],
						"nameband" => $row2['description'],
                    );
					
		 }
		  if ( $row2['typedata']=="UNIT")
		 {
			$tieneunit =1;
			   $return_arr_unit[] = array("idch" => $row2['idch'],
                    "unitdlstart" => $row2['unitdlstart'],
					"unitdlstop" => $row2['unitdlstop'],
					"unitulstart" => $row2['unitulstart'],
					"unitulstop" => $row2['unitulstop'],
					"ul_gain"=>$row2['ulgain'],
					"ul_max_pwr"=>$row2['ulmaxpwr'],
					"dl_gain"=>$row2['dlgain'],
					"dl_max_pwr"=>$row2['dlmaxpwr'],
					"notes" => $row2['notes'],
					"nomband"=> $row2['description']
                    );
		 } 
		 if ( $row2['typedata']=="DPX")
		 {
			   $return_arr_dpx[] = array("idch" => $row2['idch'],
                    "dpxlowstart" => $row2['dpxlowstart'],
					"dpxlowstop" => $row2['dpxlowstop'],
					"dpxhihgstart" => $row2['dpxhihgstart'],					
					"dpxhihgstop" => $row2['dpxhihgstop'],
					"nomband"=> $row2['description']
                    );
		 }	
				
	 }
	 if (	$tieneunit ==0)
	 {
		 
	 }



if 	($_SESSION["g"] == "develop"  ) 
	  {
		// vamos a buscar el Stock
		  //$sql = $connect->prepare("select presales.idproduct, products.modelciu, coalesce(count( distinct presales_sn.wo_sn),0)   as ccstock from presales_sn inner join presales on presales.idpresales = presales_sn.idpresales inner join products on products.idproduct = presales.idproduct where presales.typeregister='WO' and length(wo_sn)>0 and presales_sn.idpresales = :vvidpresales group by  presales.idproduct, products.modelciu");
					  $sql = $connect->prepare("select  
			 orders_sn.idproduct, products.modelciu, coalesce(count( distinct orders_sn.wo_serialnumber),0)   as ccstock 
			from orders_sn
			inner join orders
			on orders.idorders = orders_sn.idorders
			inner join fnt_select_allproducts_maxrev()  as  products
		  on products.idproduct = orders_sn.idproduct 
			and products.classproduct in  (select classproduct from orders inner join fnt_select_allproducts_maxrev()  as products on products.idproduct = orders.idproduct where idorders = ".$vvidpo." )
			where orders.active ='Y' and orders.processfasserver = true and
			orders_sn.processfasserver = true and orders.typeregister='WO' and length(trim(wo_serialnumber)) >0 
			
			and orders_sn.so_associed = '' and (orders_sn.availablesn = true or  orders_sn.idproduct in (  select idproduct from products_attributes where idattribute  =160  ))
			group by  orders_sn.idproduct, products.modelciu");
					  
				//	$sql->bindParam(':vvidpresales', $vvidpo);
					$sql->execute();
					$resultadostock = $sql->fetchAll();
					 foreach ($resultadostock as $rowstock) 
					{
						$return_arr_stock[] = array("idproduct" => $rowstock['idproduct'],
								"modelciu" => $rowstock['modelciu'],
								"stockciu" => $rowstock['ccstock']
								);
					}
					
					
					
							  $sql = $connect->prepare("select  distinct
			 orders_sn.idproduct, products.modelciu,   orders_sn.wo_serialnumber, so_soft_external
			from orders_sn
			inner join orders
			on orders.idorders = orders_sn.idorders
			inner join fnt_select_allproducts_maxrev()  as  products
			  on products.idproduct = orders_sn.idproduct
			and products.classproduct in  (select classproduct from orders inner join fnt_select_allproducts_maxrev()  as products on products.idproduct = orders.idproduct where idorders = ".$vvidpo." )	
			where orders.active ='Y' and orders.processfasserver = true and
			orders_sn.processfasserver = true and orders.typeregister='WO' and length(trim(wo_serialnumber)) >0 			
			and trim(orders_sn.so_associed) = '' and  orders_sn.wo_serialnumber <> '' and orders_sn.availablesn = true order by  orders_sn.wo_serialnumber
			");
					  //SUMAS FILTRO ESTANDAR
				//	$sql->bindParam(':vvidpresales', $vvidpo);
					$sql->execute();
					$resultadostock = $sql->fetchAll();
					 foreach ($resultadostock as $rowstock) 
					{
						$return_arr_stock_det[] = array("idproduct" => $rowstock['idproduct'],
								"modelciu" => $rowstock['modelciu'],
								"wo_serialnumber" => $rowstock['wo_serialnumber'], 
								"so_soft_external"=> $rowstock['so_soft_external']				
								);
					}
		
	  }
	  else
	{
	/// NO mostramos SN con DV al final	

	//// Adaptacion para calibradores bbu
	if 	($_SESSION["g"] == "calibratorbbu" ) 
	{ 
		$sql = $connect->prepare("select  
		orders_sn.idproduct, products.modelciu, coalesce(count( distinct orders_sn.wo_serialnumber),0)   as ccstock 
	   from orders_sn
	   inner join orders
	   on orders.idorders = orders_sn.idorders
	   inner join products on products.idproduct = orders_sn.idproduct 
	   and products.classproduct in  (select classproduct from orders inner join products on products.idproduct = orders.idproduct where idorders = ".$vvidpo." )
	   where orders.active ='Y' and orders.processfasserver = true and
	   orders_sn.processfasserver = true and orders.typeregister='WO' and length(trim(wo_serialnumber)) >0 
	   and  trim(orders_sn.so_associed)  = '' and orders_sn.availablesn = true
		   and orders_sn.wo_serialnumber not like '%DV%' and products.iduniquebranchsonprod LIKE '%000100370041%'
	   group by  orders_sn.idproduct, products.modelciu");
	}
	else
	{
		$sql = $connect->prepare("select  
		orders_sn.idproduct, products.modelciu, coalesce(count( distinct orders_sn.wo_serialnumber),0)   as ccstock 
	   from orders_sn
	   inner join orders
	   on orders.idorders = orders_sn.idorders
	   inner join products on products.idproduct = orders_sn.idproduct 
	   and products.classproduct in  (select classproduct from orders inner join products on products.idproduct = orders.idproduct where idorders = ".$vvidpo." )
	   where orders.active ='Y' and orders.processfasserver = true and
	   orders_sn.processfasserver = true and orders.typeregister='WO' and length(trim(wo_serialnumber)) >0 
	   and  trim(orders_sn.so_associed) = '' and orders_sn.availablesn = true
		   and orders_sn.wo_serialnumber not like '%DV%'
	   group by  orders_sn.idproduct, products.modelciu");
	}
					
					  
				//	$sql->bindParam(':vvidpresales', $vvidpo);
					$sql->execute();
					$resultadostock = $sql->fetchAll();
					 foreach ($resultadostock as $rowstock) 
					{
						$return_arr_stock[] = array("idproduct" => $rowstock['idproduct'],
								"modelciu" => $rowstock['modelciu'],
								"stockciu" => $rowstock['ccstock']
								);
					}
					
					
					//// Adaptacion para calibradores bbu
						if 	($_SESSION["g"] == "calibratorbbu" ) 
						{
							$sql = $connect->prepare("select  distinct
							orders_sn.idproduct, products.modelciu,   orders_sn.wo_serialnumber, so_soft_external
							from orders_sn
							inner join orders
							on orders.idorders = orders_sn.idorders
							inner join products on products.idproduct = orders_sn.idproduct 
							and products.classproduct in  (select classproduct from orders inner join products on products.idproduct = orders.idproduct where idorders = ".$vvidpo." )
							where orders.active ='Y' and orders.processfasserver = true and
							orders_sn.processfasserver = true and orders.typeregister='WO' and length(trim(wo_serialnumber)) >0 
							and  trim(orders_sn.so_associed)  = '' and  orders_sn.wo_serialnumber <> '' and orders_sn.availablesn = true
							and products.iduniquebranchsonprod LIKE '%000100370041%'
							and orders_sn.wo_serialnumber not like '%DV%' order by  orders_sn.wo_serialnumber 
							");
						}	
						else
						{
							$sql = $connect->prepare("select  distinct
							orders_sn.idproduct, products.modelciu,   orders_sn.wo_serialnumber, so_soft_external
							from orders_sn
							inner join orders
							on orders.idorders = orders_sn.idorders
							inner join products on products.idproduct = orders_sn.idproduct 
							and products.classproduct in  (select classproduct from orders inner join products on products.idproduct = orders.idproduct where idorders = ".$vvidpo." )
							where orders.active ='Y' and orders.processfasserver = true and
							orders_sn.processfasserver = true and orders.typeregister='WO' and length(trim(wo_serialnumber)) >0 
							and  trim(orders_sn.so_associed)  = '' and  orders_sn.wo_serialnumber <> '' and orders_sn.availablesn = true
							and orders_sn.wo_serialnumber not like '%DV%' order by  orders_sn.wo_serialnumber
							");
						}	
					  
				//	$sql->bindParam(':vvidpresales', $vvidpo);
					$sql->execute();
					$resultadostock = $sql->fetchAll();
					 foreach ($resultadostock as $rowstock) 
					{
						$return_arr_stock_det[] = array("idproduct" => $rowstock['idproduct'],
								"modelciu" => $rowstock['modelciu'],
								"wo_serialnumber" => $rowstock['wo_serialnumber'], 
								"so_soft_external"=> $rowstock['so_soft_external']				
								);
					}
	}

	///search attach los 
	$sql = $connect->prepare("		select distinct idordersfileat, seedtemp ,  replace(replace(orders_fileattach.namefileattach,seedtemp,''),'_','')  as  namefileattach ,
	 namefileattach as namefileattach2  from orders_fileattach
	inner join orders_sn on orders_sn.idorders  =  orders_fileattach.idorders 	where so_soft_external  in (select so_soft_external from  orders_sn where idorders = ".$vvidpo.") " );
	$sql->execute();
	$encontresemilla = 'N';
					$resultlistatt = $sql->fetchAll();
					 foreach ($resultlistatt as $rowatt) 
					 {
						$encontresemilla = 'Y';
						$return_arr_listattac[] = array("idordersfileat" => $rowatt['idordersfileat'],								
						"namefileattach" => $rowatt['namefileattach'] ,
						"namefileattach2" => $rowatt['namefileattach2'],
						"seedtemp" => $rowatt['seedtemp'] 		 											
						);
					 }
						if ($encontresemilla == 'N')
						{
							$psswdtkkey = substr( md5(microtime()), 1, 8);
							$ssmm="";
							$mmdd=0;
							$return_arr_listattac[] = array("idordersfileat" => $mmdd,								
									"namefileattach" =>$ssmm ,
									"namefileattach2" =>$ssmm,
									"seedtemp" => $psswdtkkey 	 											
									);

						}
	
	/////IS DIG UNIT
	$sqlidigunit="select distinct idproduct from products_attributes where  idattribute  = 86 and idproduct in(select idproduct from orders_sn where idorders = ".$vvidpo.") ";
	$sql = $connect->prepare($sqlidigunit );
   $sql->execute();
   $result_isdigunit = $sql->fetchAll();
   $isdigunit= 'N';
   foreach ($result_isdigunit as $rowdigunit) 
   {
	  $isdigunit = 'Y';
	
   }
						
	///search have module rabbit 
	$sql = $connect->prepare("		select idorders from orders_attributes where idattribute_orders = 1 and v_boolean= TRUE and  idorders = ".$vvidpo." " );
   $sql->execute();
   $havemodulorabbit = '';
				   $resultlisthavmod = $sql->fetchAll();
					foreach ($resultlisthavmod as $rowastt) 
					{
					   $havemodulorabbit = 'Y';
					 
					}

					$sql = $connect->prepare("		select idorders from orders_attributes where idattribute_orders = 1 and v_boolean= FALSE and  idorders = ".$vvidpo." " );
					$sql->execute();
		 
									$resultlisthavmod = $sql->fetchAll();
									 foreach ($resultlisthavmod as $rowastt) 
									 {
										$havemodulorabbit = 'N';
									  
									 }
					    
 
 // buscamos los SN asignados al WO
 		  $sql = $connect->prepare("select * from orders_sn where idorders = ".$vvidpo." and idnroserie>0 and idrev in ( select max(idrev) from orders where idorders = ".$vvidpo.") order by wo_serialnumber  ");
					  
				//	$sql->bindParam(':vvidpresales', $vvidpo);
					$sql->execute();
					$resultadostock2 = $sql->fetchAll();
					 foreach ($resultadostock2 as $rowstock2) 
					{
						$return_arr_snasignados[] = array("idorders" => $rowstock2['idorders'],								
								"wo_serialnumber" => $rowstock2['wo_serialnumber'] 											
								);
					}
/*
 // buscamos los Prod Orders...de la SO
 $sql = $connect->prepare("select * from orders_sn where idorders = ".$vvidpo." and idnroserie>0 and idrev in ( select max(idrev) from orders where idorders = ".$vvidpo.") order by wo_serialnumber  ");
					  
 //	$sql->bindParam(':vvidpresales', $vvidpo);
	 $sql->execute();
	 $resultadostock2 = $sql->fetchAll();
	  foreach ($resultadostock2 as $rowstock2) 
	 {
		 $return_arr_snasignados[] = array("idorders" => $rowstock2['idorders'],								
				 "wo_serialnumber" => $rowstock2['wo_serialnumber'] 											
				 );
	 }
*/


//echo json_encode($return_arr );

			$sqlblock = "SELECT json_agg ( JSON_BUILD_OBJECT('idattribute_orders',idattribute,'attributedescription', attributedescription,
			'attributename', attributename, 'attdatatype', attdatatype, 
			'v_boolean',v_boolean, 'v_integer',v_integer, 'v_double',v_double, 'datemodif', to_char(datemodif, 'DD/MM/YYYY HH24:MI:SS') ,
			'v_string',v_string)::jsonb) AS v_parametersjson 
			from 
			orders_attributes 
			INNER JOIN orders_attributes_type
			ON orders_attributes.idattribute_orders = orders_attributes_type.idattribute
			where idorders =".$vvidpo." and  orders_attributes.idattribute_orders =30  ";

 $dataJSOMSML = $connect->query($sqlblock)->fetchAll();	
 $resultadojson="";
 foreach ($dataJSOMSML as $rowDATA2) 
 {
 // echo  $rowDATA2['v_parametersjson'];
 $decoded_json = json_decode($rowDATA2['v_parametersjson'], true);
 
	 foreach($decoded_json as $country) {
	 //  echo var_dump($country);
	//	 $resultadojson= $resultadojson.'<b>'.str_replace("XML#","",$country['attributename']).'</b> -><b>'.$country['v_string'].'</b> || -> Datetime:' .substr($country['datemodif'],0,19).'<br>';
	 	if ($country['v_string'] =='No')
		{
			$resultadojson= $resultadojson.'<b>  <div class="  btn btn-outline-success btn-sm" role="alert"><i class="far fa-file-alt mr-1"></i> SO with credit approval || Datetime:' .substr($country['datemodif'],0,19).' </div>    </b>  ';
		}
		else
		{
			$resultadojson= $resultadojson.'<b> <div class=" btn btn-outline-danger btn-sm" role="alert"> <i class="far fa-file-alt mr-1"></i> SO with credit block &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; || Datetime:' .substr($country['datemodif'],0,19).' </div>    </b>  ';
			

			
		}
	 }
 
 }



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
   objectband.idrev in (	select  max(idrev)  from objectband where idproduct  in (select distinct idproduct from orders_sn where idorders =".$vvidpo."))
inner join idband
on idband.idband = objectband.idband and idband.issubband is false
left join fas_instruments_parameters
on fas_instruments_parameters.idproduct = products.idproduct 

left join products_attributes
on products_attributes.idproduct = products.idproduct and
   products_attributes.v_integer = objectband.idband and
   products_attributes.idattribute = 72

where  products.idproduct in ( select distinct idproduct from orders_sn where idorders =".$vvidpo." ) and products.idrevproduct in (	select  max(idrevproduct)  from products where idproduct  in ( select distinct idproduct from orders_sn where idorders =".$vvidpo."))  

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

where  products.idproduct in (select distinct idproduct from orders_sn where idorders =".$vvidpo." ) and products.idrevproduct in (	select  max(idrevproduct)  from products where idproduct  in (select distinct idproduct from orders_sn where idorders =".$vvidpo.")) order by bandorder";


		//	echo $query_lista;
				$data = $connect->query($query_lista)->fetchAll();	
				foreach ($data as $row) {		
					



			 
					if (9999 != $row['idbandifnull'])
					{
						$return_arr_dpxunit[] = array("idch" => $row['idband'],
						"fstartul" => $row['fstartul'],
						"fstopul" => $row['fstopul'],
						"fstartdl" => $row['fstartdl'],
						"fstopdl" => $row['fstopdl'],
						"nomband" => $row['description'],
						"cantsubband" => $row['cantsubband'],
						"isfullband" => $row['isfullband'],
						"retur_woparam"=>$row['woparam'] ,
						"retur_powersupply"=>$row['powersupply'] ,
						"v_gain_dl"=>round($row['dlgain']) ,
						"v_gain_ul"=>round($row['ulgain']) , 
						"v_maxpwr_dl"=>round($row['dlmaxpwr']) ,
						"v_maxpwr_ul"=>round($row['ulmaxpwr']),						
						"haveconfiguration"=>round($row['haveconfiguration']) 
						);
						$encontrealgo="S";
					} 
						
				 }


 
echo(json_encode(["resultadojson"=>$resultadojson,"arr_dpxunit"=>$return_arr_dpxunit,"thebands"=>$return_arr_bandas,"isdigunit"=>$isdigunit, "havemodulorabbit"=> $havemodulorabbit,"ps"=>$return_arr,"psch"=>$return_arr_ch,"snasignados"=>$return_arr_snasignados,"psunit"=>$return_arr_unit,"psdpx"=>$return_arr_dpx,"ciustock"=>$return_arr_stock,"ciustockdet"=>$return_arr_stock_det, "listattach"=>$return_arr_listattac]));
?>
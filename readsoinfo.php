<?php
  include("db_conect.php");
  	header('Content-Type: application/json');
  $vvidpo = $_REQUEST['idpo'];
  $vwoserialnumber = $_REQUEST['sn'];
  
	if ( $vwoserialnumber  !="0")
	{
	  	  
//	  $sql = $connect->prepare("SELECT presales.idproduct,  presales.idpresales, presales.idcustomers, presales.idfamilyprod, presales.idtypeband, presales.idtypeproduct, products.idproduct,presales.idconfiguration, products.modelciu as ciu, idrev, so_soft_external, idruninfo, ponumber, pwrsupplytype,rcgfbwa, moden_dig, date_approved, coalesce(presales.descripcion,'-') as descripcion, ul_gain, ul_max_pwr, dl_gain, dl_max_pwr, req_ppassy, req_calibration, req_spec, req_other, nameapproved, quantity, coalesce(notes,' ') as notes, reqresources	FROM presales  inner join products on products.idproduct = presales.idproduct WHERE presales.typeregister='PO' and  idpresales = :vvidlog and idrev in (select max(idrev) from presales  WHERE presales.typeregister='PO' and  idpresales =:vvidlog ) ");
	  	  $sql = $connect->prepare("SELECT orders.idproduct,  orders.idorders as idpresales , orders_sn.so_soft_external,  orders.idcustomers, orders.idfamilyprod, orders.idtypeband, orders.idtypeproduct, products.idproduct,
			orders.idconfiguration, products.modelciu as ciu, orders.idrev,  orders.idruninfo, ponumber, pwrsupplytype,rcgfbwa, 
			moden_dig, orders.date_approved, coalesce(orders_sn.descripcion,'-') as descripcion, ul_gain, ul_max_pwr, dl_gain, 
			dl_max_pwr, req_ppassy, req_calibration, req_spec, req_other, orders.nameapproved, quantity, coalesce(orders_sn.notes,' ') as notes, reqresources

			FROM orders 
			inner join orders_sn
			on orders_sn.idorders = orders.idorders and
			orders_sn.idrev = orders.idrev  
			inner join products on products.idproduct = orders.idproduct 
			WHERE orders.typeregister = 'SO'
			and  orders.idorders =:vvidlog
			and orders.idrev in (select max(idrev) from orders  WHERE orders.typeregister = 'SO' and  idorders =:vvidlog ) and orders_sn.wo_serialnumber = :wo_serialnumber ");
			
			 $sql_sn = $connect->prepare("SELECT  orders_sn.wo_serialnumber, orders_sn.idnroserie
			FROM orders 
			inner join orders_sn
			on orders_sn.idorders = orders.idorders and
			orders_sn.idrev = orders.idrev  
			inner join products on products.idproduct = orders.idproduct 
			WHERE orders.typeregister = 'SO'
			and  orders.idorders =:vvidlog
			and orders.idrev in (select max(idrev) from orders  WHERE orders.typeregister = 'SO' and  idorders =:vvidlog ) and orders_sn.wo_serialnumber = :wo_serialnumber ");
			
			$sql->bindParam(':vvidlog', $vvidpo);
			$sql->bindParam(':wo_serialnumber', $vwoserialnumber);
			
			$sql_sn->bindParam(':vvidlog', $vvidpo);
			$sql_sn->bindParam(':wo_serialnumber', $vwoserialnumber);


	}
	else
	{
		  	  $sql = $connect->prepare("SELECT distinct orders.idproduct,  orders.idorders as idpresales , orders_sn.so_soft_external,  orders.idcustomers, orders.idfamilyprod, orders.idtypeband, orders.idtypeproduct, products.idproduct,
			orders.idconfiguration, products.modelciu as ciu, orders.idrev,  orders.idruninfo, ponumber, pwrsupplytype,rcgfbwa, 
			moden_dig, orders.date_approved, coalesce(orders_sn.descripcion,'-') as descripcion, ul_gain, ul_max_pwr, dl_gain, 
			dl_max_pwr, req_ppassy, req_calibration, req_spec, req_other, orders.nameapproved, quantity, coalesce(orders_sn.notes,' ') as notes, reqresources

			FROM orders 
			inner join orders_sn
			on orders_sn.idorders = orders.idorders and
			orders_sn.idrev = orders.idrev  
			inner join products on products.idproduct = orders.idproduct 
			WHERE orders.typeregister = 'SO'
			and  orders.idorders =:vvidlog
			and orders.idrev in (select max(idrev) from orders  WHERE orders.typeregister = 'SO' and  idorders =:vvidlog ) ");
			
			$sql_sn = $connect->prepare("SELECT orders_sn.wo_serialnumber, orders_sn.idnroserie
			FROM orders 
			inner join orders_sn
			on orders_sn.idorders = orders.idorders and
			orders_sn.idrev = orders.idrev  
			inner join products on products.idproduct = orders.idproduct 
			WHERE orders.typeregister = 'SO'
			and  orders.idorders =:vvidlog
			and orders.idrev in (select max(idrev) from orders  WHERE orders.typeregister = 'SO' and  idorders =:vvidlog ) and orders_sn.wo_serialnumber <> ''");
			
			
			$sql->bindParam(':vvidlog', $vvidpo);
			
			$sql_sn->bindParam(':vvidlog', $vvidpo);
	}


	// cargo los SN... necesarios para la parte de edicion.
	 $sql_sn->execute();
    $resultado_sn = $sql_sn->fetchAll();
	 $return_arr_lossn = array();

	 foreach ($resultado_sn as $row_sn) 
	 {
		  $return_arr_lossn[] = array("elsn" => $row_sn['wo_serialnumber'],
                    "elidsn" => $row_sn['idnroserie']
					    );
	 }
	// fin cargo los SN.
	
	
    $sql->execute();
    $resultado = $sql->fetchAll();
	 $return_arr = array();

	 foreach ($resultado as $row) 
	 {
		 $vuserruninfo = $row[2];
		$vstation = $row[3];
		$vdevice = $row[4];
	    $vmostrar = "".trim(substr($row[0],0,10))."\r\n". str_replace("###","",$row[1]);
		
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
		
		 
		 $return_arr[] = array("descripcion" => $vdescrpicion,
                    "notes" => $vnotes,
					"idpresales"=>$row['idpresales'],
					"idproduct"=>$row['idproduct'],
					"ciu"=>$row['ciu'],
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
					"reqresources"=>$row['reqresources']
                    );
				
		
	 }
	 
	 if ( $vwoserialnumber  !="0")
	{
	 //Si esta procesado solo muestros idnroserie >0 sino = 0
	   $sql = $connect->prepare("SELECT * FROM orders_sn_specs inner join orders_sn
ON orders_sn.idorders  = orders_sn_specs.idorders AND
orders_sn.idrev      =  orders_sn_specs.idrev AND
orders_sn.idnroserie = orders_sn_specs.idnroserie  WHERE  orders_sn.processfasserver = true  and orders_sn_specs.idnroserie >0 and  orders_sn_specs.idorders = :vvidlog  and orders_sn_specs.idrev in (select max(idrev) from orders  WHERE  idorders =:vvidlog )   and orders_sn.wo_serialnumber = :wo_serialnumber union SELECT * FROM orders_sn_specs inner join orders_sn
ON orders_sn.idorders  = orders_sn_specs.idorders AND
orders_sn.idrev      =  orders_sn_specs.idrev AND
orders_sn.idnroserie = orders_sn_specs.idnroserie  WHERE  orders_sn.processfasserver = false  and orders_sn_specs.idnroserie = 0 and  orders_sn_specs.idorders = :vvidlog  and orders_sn_specs.idrev in (select max(idrev) from orders  WHERE  idorders =:vvidlog )   and orders_sn.wo_serialnumber = :wo_serialnumber  order by typedata ");
		$sql->bindParam(':vvidlog', $vvidpo);
	    $sql->bindParam(':wo_serialnumber', $vwoserialnumber);

	}
	else
	{
		   $sql = $connect->prepare("SELECT distinct  * FROM orders_sn_specs inner join orders_sn
ON orders_sn.idorders  = orders_sn_specs.idorders AND
orders_sn.idrev      =  orders_sn_specs.idrev AND
orders_sn.idnroserie = orders_sn_specs.idnroserie  WHERE  orders_sn.processfasserver = true  and orders_sn_specs.idnroserie >0 and  orders_sn_specs.idorders = :vvidlog  and orders_sn_specs.idrev in (select max(idrev) from orders  WHERE  idorders =:vvidlog ) and orders_sn_specs.idnroserie = 1  ");

		$sql->bindParam(':vvidlog', $vvidpo);
	
	}
		
	

    $sql->execute();
    $resultado2 = $sql->fetchAll();
	 
	$return_arr_dpx = array();
	$return_arr_unit = array();
	 $return_arr_ch = array();
	 	 $return_arr_stock = array();
		  $return_arr_stock_det = array();

	 foreach ($resultado2 as $row2) 
	 {
		 if ( $row2['typedata']=="CHANNEL")
		 {
			  $return_arr_ch[] = array("idch" => $row2['idch'],
                    "ul_ch_fr" => $row2['ul_ch_fr'],
					"dl_ch_fr" => $row2['dl_ch_fr'],
						"notes" => $row2['notes'],
                    );
		 }
		  if ( $row2['typedata']=="UNIT")
		 {
			   $return_arr_unit[] = array("idch" => $row2['idch'],
                    "unitdlstart" => $row2['unitdlstart'],
					"unitdlstop" => $row2['unitdlstop'],
					"unitulstart" => $row2['unitulstart'],
					"unitulstop" => $row2['unitulstop'],
					"notes" => $row2['notes']
                    );
		 } 
		 if ( $row2['typedata']=="DPX")
		 {
			   $return_arr_dpx[] = array("idch" => $row2['idch'],
                    "dpxlowstart" => $row2['dpxlowstart'],
					"dpxlowstop" => $row2['dpxlowstop'],
					"dpxhihgstart" => $row2['dpxhihgstart'],
					"dpxhihgstop" => $row2['dpxhihgstop']
                    );
		 }	
				
	 }

		// vamos a buscar el Stock
		  //$sql = $connect->prepare("select presales.idproduct, products.modelciu, coalesce(count( distinct presales_sn.wo_sn),0)   as ccstock from presales_sn inner join presales on presales.idpresales = presales_sn.idpresales inner join products on products.idproduct = presales.idproduct where presales.typeregister='WO' and length(wo_sn)>0 and presales_sn.idpresales = :vvidpresales group by  presales.idproduct, products.modelciu");
		  $sql = $connect->prepare("select  
 orders_sn.idproduct, products.modelciu, coalesce(count( distinct orders_sn.wo_serialnumber),0)   as ccstock 
from orders_sn
inner join orders
on orders.idorders = orders_sn.idorders
inner join products on products.idproduct = orders_sn.idproduct 
where orders.active ='Y' and orders.processfasserver = true and
orders_sn.processfasserver = true and orders.typeregister='WO' and length(trim(wo_serialnumber)) >0 
and orders_sn.so_associed = ''
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
inner join products on products.idproduct = orders_sn.idproduct 
where orders.active ='Y' and orders.processfasserver = true and
orders_sn.processfasserver = true and orders.typeregister='WO' and length(trim(wo_serialnumber)) >0 
and orders_sn.so_associed = '' and  orders_sn.wo_serialnumber <> ''
");
		  
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
		
		

 
//echo json_encode($return_arr );
 
echo(json_encode(["ps"=>$return_arr,"psch"=>$return_arr_ch,"psunit"=>$return_arr_unit,"psdpx"=>$return_arr_dpx,"ciustock"=>$return_arr_stock,"ciustockdet"=>$return_arr_stock_det,"lossn"=>$return_arr_lossn]));
?>
<?php
  include("db_conect.php");
  	header('Content-Type: application/json');
  $vvidpo = $_REQUEST['idpo'];
  
  	function marco_encrypt($string, $key) {
   $result = '';
   for($i=0; $i<strlen($string); $i++) {
      $char = substr($string, $i, 1);
      $keychar = substr($key, ($i % strlen($key))-1, 1);
      $char = chr(ord($char)+ord($keychar));
      $result.=$char;
   }
   return base64_encode($result);
}

	  	  
	  //$sql = $connect->prepare("SELECT idproduct,  idpresales, idcustomers, idfamilyprod, idtypeband, idtypeproduct, products.idproduct,presales.idconfiguration, products.modelciu as ciu, idrev, so_soft_external, idruninfo, ponumber, pwrsupplytype,rcgfbwa, moden_dig, date_approved, coalesce(presales.descripcion,'-') as descripcion, ul_gain, ul_max_pwr, dl_gain, dl_max_pwr, req_ppassy, req_calibration, req_spec, req_other, nameapproved, quantity, coalesce(notes,' ') as notes, reqresources	FROM presales  inner join products on products.idproduct = presales.idproduct WHERE presales.typeregister='WO' and  idpresales = :vvidlog  and idrev in (select max(idrev) from presales  WHERE presales.typeregister='WO' and  idpresales =:vvidlog ) ");
	  $sql = $connect->prepare("SELECT orders.idproduct,  orders.idorders as idpresales , orders_sn.so_soft_external,  orders.idcustomers, orders.idfamilyprod, orders.idtypeband, orders.idtypeproduct, products.idproduct,
orders.idconfiguration, products.modelciu as ciu, orders.idrev,  orders.idruninfo, ponumber, pwrsupplytype,rcgfbwa, 
moden_dig, orders.date_approved, coalesce(orders_sn.descripcion,'-') as descripcion, ul_gain, ul_max_pwr, dl_gain, 
dl_max_pwr, req_ppassy, req_calibration, req_spec, req_other, orders.nameapproved, quantity, coalesce(orders_sn.notes,' ') as notes, reqresources

FROM orders 
inner join orders_sn
on orders_sn.idorders = orders.idorders and
orders_sn.idrev = orders.idrev  and
orders_sn.idnroserie = 0
inner join products on products.idproduct = orders.idproduct 
WHERE orders.typeregister='WO'
and  orders.idorders =:vvidlog
and orders.idrev in (select max(idrev) from orders  WHERE orders.typeregister='WO' and  idorders =:vvidlog ) ");
	  $sql->bindParam(':vvidlog', $vvidpo);
    $sql->execute();
    $resultado = $sql->fetchAll();
	

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
		
		$so_soft_external=$row['so_soft_external'];
		 
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
	 
	 //Si esta procesado solo muestros idnroserie >0 sino = 0
	   $sql = $connect->prepare("SELECT orders_sn_specs.idorders, orders_sn_specs.idrev, idch,  typedata, ul_ch_fr, dl_ch_fr, dpxlowstart, dpxlowstop, dpxhihgstart, dpxhihgstop, unitdlstart, unitdlstop, unitulstart, unitulstop, orders_sn_specs.notes, orders_sn_specs.idband, ulgain, dlgain, ulmaxpwr, dlmaxpwr, idband.description as nombband FROM orders_sn_specs inner join orders_sn
ON orders_sn.idorders  = orders_sn_specs.idorders AND
orders_sn.idrev      =  orders_sn_specs.idrev AND
orders_sn.idnroserie = orders_sn_specs.idnroserie
inner join idband
on idband.idband  = orders_sn_specs.idband
 WHERE  orders_sn.processfasserver = true  and orders_sn_specs.idnroserie >0 and  orders_sn_specs.idorders = :vvidlog   and orders_sn_specs.idrev in (select max(idrev) from orders  WHERE  idorders =:vvidlog )  
union SELECT orders_sn_specs.idorders, orders_sn_specs.idrev, idch,  typedata, ul_ch_fr, dl_ch_fr, dpxlowstart, dpxlowstop, dpxhihgstart, dpxhihgstop, unitdlstart, unitdlstop, unitulstart, unitulstop, orders_sn_specs.notes, orders_sn_specs.idband, ulgain, dlgain, ulmaxpwr, dlmaxpwr, idband.description as nombband FROM orders_sn_specs inner join orders_sn
ON orders_sn.idorders  = orders_sn_specs.idorders AND
orders_sn.idrev      =  orders_sn_specs.idrev AND
orders_sn.idnroserie = orders_sn_specs.idnroserie
inner join idband
on idband.idband  = orders_sn_specs.idband
  WHERE  orders_sn_specs.idnroserie = 0 and  orders_sn_specs.idorders = :vvidlog  and orders_sn_specs.idrev in (select max(idrev) from orders  WHERE  idorders =:vvidlog  )   order by typedata,idch ");
	  $sql->bindParam(':vvidlog', $vvidpo);
    $sql->execute();
    $resultado2 = $sql->fetchAll();
	 
	$return_arr_dpx = array();
	$return_arr_unit = array();
	 $return_arr_ch = array();

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
					"notes" => $row2['notes'],
					"nomband"=> $row2['nombband'],
					"ulgain"=> $row2['ulgain'],
					"dlgain"=> $row2['dlgain'],
					"ulmaxpwr"=> $row2['ulmaxpwr'],
					"dlmaxpwr"=> $row2['dlmaxpwr']

                    );
		 } 
		 if ( $row2['typedata']=="DPX")
		 {
			   $return_arr_dpx[] = array("idch" => $row2['idch'],
                    "dpxlowstart" => $row2['dpxlowstart'],
					"dpxlowstop" => $row2['dpxlowstop'],
					"dpxhihgstart" => $row2['dpxhihgstart'],
					"dpxhihgstop" => $row2['dpxhihgstop'],
					"nomband"=> $row2['notes']
                    );
		 }	
				
	 }
	
	////mostramos los SN	
	//Si esta procesado solo muestros idnroserie >0 sino = 0
	
	 $return_arr_sn = array();
	 //echo "SELECT idnroserie, wo_serialnumber,so_soft_external, so_associed,count(distinct fas_tree_measure.iduniquebranch) as cantregisencalib   FROM orders_sn left join fas_tree_measure on fas_tree_measure.unitsn = orders_sn.wo_serialnumber WHERE idorders = :vvidlog and idnroserie > 0  and idrev in (select max(idrev) from orders_sn  WHERE typeregister='WO' and  idorders =:vvidlog )  group by idnroserie, wo_serialnumber,so_soft_external, so_associed  order by wo_serialnumber "; 
	  $sql = $connect->prepare("SELECT idnroserie, wo_serialnumber,so_soft_external, so_associed,count(distinct fas_tree_measure.iduniquebranch) as cantregisencalib   FROM orders_sn left join fas_tree_measure on fas_tree_measure.unitsn = orders_sn.wo_serialnumber WHERE idorders = :vvidlog and idnroserie > 0  and orders_sn.idrev in (select max(idrev) from orders_sn  WHERE typeregister='WO' and  idorders =:vvidlog )  group by idnroserie, wo_serialnumber,so_soft_external, so_associed  order by wo_serialnumber ");
	  $sql->bindParam(':vvidlog', $vvidpo);
    $sql->execute();
    $resultado3 = $sql->fetchAll();
	foreach ($resultado3 as $row2) 
	 {
		 
			//$encrip1 = marco_encrypt($row2['wo_serialnumber']);
			//$encrip2 = marco_encrypt($so_soft_external);
			$encrip1 = "";
					
					 $return_arr_sn[] = array("idpssn" => $row2['idnroserie'],
                    "wosn" => $row2['wo_serialnumber'],
					"wosnencript" => $encrip1,
					"so_external_encript" =>$encrip1,
					"soassocied" => $row2['so_associed'],
					"cantregisencalib" => $row2['cantregisencalib'],
                    );
					
	 }
 
//echo json_encode($return_arr );
 
echo(json_encode(["ps"=>$return_arr,"psch"=>$return_arr_ch,"psunit"=>$return_arr_unit,"psdpx"=>$return_arr_dpx,"pssn"=>$return_arr_sn]));
?>
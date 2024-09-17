<?php
include "db_conect.php";
error_reporting(0);
/* Getting post data */
$nropage = $_REQUEST['page'];


 include ('licencefiplex_mm.php');
 
   //   $Encryption = new Encryption();



$sql = $connect->prepare("select count(*) as cc from  components_pa ");
    $sql->execute();
    $resultado = $sql->fetchAll();
	 foreach ($resultado as $row) {
		$allcount= $row['cc']+1;
	 }
	

		$rowid= 20;
		$nropage = $nropage -1;
		if($nropage ==0)
		{
			$rowid= 20;
			$rowperpage = $rowid * $nropage;			
		}
		if ($nropage==1)
		{
			$rowid=$allcount;
			$rowperpage=20;
		}
		if ($nropage==2)
		{
			$rowid=0;
			$rowperpage=0;
		}
				
		
	
        

$idcantrow=0;
$employee_arr = array();



	 $sql = $connect->prepare("select distinct components_pa.idcomppa, idcomprev,   gain, components_pa.active, components_pa.usermodif, components_pa.datelastmodif, fstart, fstop, band, 
gaintolerance, currenttolerance, components_pa.powersupply, imd3a, imd3b, imd3limita, imd3limitb, currentpa, vgate, tonetolerance, 
isetsi, dbctolerance, isdual, uselnasetup, components_pa.idbandgroup , products.modelciu, products.description, products.idproduct , bandgroups.namegroup 
from components_pa
inner join (
	select idcomppa, max(idcomprev) as idcomprevmax from components_pa group by idcomppa
) as maxcomppa
on maxcomppa.idcomppa = components_pa.idcomppa and 
maxcomppa.idcomprevmax = components_pa.idcomprev
inner join products on
products.idproduct = components_pa.idcomppa
inner join bandgroups
on bandgroups.idbandgroup  = components_pa.idbandgroup
where products.modelciu like 'PAMP%' order by modelciu ");
    $sql->execute();
    $resultado = $sql->fetchAll();
	//$employee_arr[] = array("last_page" => $allcount);

	 foreach ($resultado as $row) {
			 $viproduc =  $row['idproduct']; 
		// $idcantrow = $idcantrow +1;  
		$vmodelciu = $row['modelciu'];
		$vdescripcion = $row['description'];
		
		
		$vidcomprev = $row['idcomprev'];
		$vgain = $row['gain'];  
		$vactive = $row['active'];  
		
		$vfstart = $row['fstart'];  
		$vfstop = $row['fstop'];


		$vgaintolerance = $row['gaintolerance'];
		$vcurrenttolerance = $row['currenttolerance'];
		$vpowersupply = $row['powersupply'];
		$vimd3a = $row['imd3a'];
		$vimd3b = $row['imd3b'];
		$vimd3limita = $row['imd3limita'];
		$vimd3limitb = $row['imd3limitb'];
		$vcurrentpa = $row['currentpa'];
		$vvgate = $row['vgate'];
		$vtonetolerance = $row['tonetolerance'];


		
		$visetsi = $row['isetsi'];  
		
		$vdbctolerance = $row['dbctolerance'];
		$visdual = $row['isdual'];
		$vuselnasetup = $row['uselnasetup'];
		$vidbandgroup = $row['idbandgroup'];
		$vnamegroup = $row['namegroup'];

			
		
		$employee_arr[] = array("idproduct" => $viproduc,"modelciu" => $vmodelciu,"description" => $vdescripcion, "idcomprev" => $vidcomprev ,
		"gain" => $vgain, "active" => $vactive, "fstart" => $vfstart, "fstop" => $vfstop, "isetsi" => $visetsi, 		
		"gaintolerance" => $vgaintolerance, "currenttolerance" => $vcurrenttolerance, "powersupply" => $vpowersupply, "imd3a" => $vimd3a, "imd3b" => $vimd3b, 
		"imd3limita" => $vimd3limita, "imd3limitb" => $vimd3limitb, "currentpa" => $vcurrentpa, "vgate" => $vvgate, "tonetolerance" => $vtonetolerance, 		
		"dbctolerance" => $vdbctolerance, "isdual" => $visdual, "uselnasetup" => $vuselnasetup, "idbandgroup" => $vidbandgroup,
		"namegroup" => $vnamegroup);
	}


/* encoding array to JSON format */
$allcount=1;  // solo para q haga 1 llamado de trae datos
echo(json_encode(["last_page"=>$allcount, "data"=>$employee_arr,"a"=>$rowperpage]));


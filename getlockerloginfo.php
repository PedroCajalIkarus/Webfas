<?php
include "db_conect.php";
error_reporting(0);
/* Getting post data */
$nropage = $_REQUEST['page'];


 include ('licencefiplex_mm.php');
 
   //   $Encryption = new Encryption();

/* Count total number of rows */
/*
when SUBSTRING(dateinfo,12,2)= '02' then 'A'
end as hrrango 
FROM runinfo ORDER BY fechamm desc,hr DESC, hrcorta desc  LIMIT ".$rowid.",".$rowperpage);
*/

$elwhere="";
	$param_search=$_POST['p'];
	$text_search=$_REQUEST['t'];
	
	$idempresaafil=$_REQUEST['idb'];
	

$sql = $connect->prepare("select count(*) as cc from  lockerlog ");
    $sql->execute();
    $resultado = $sql->fetchAll();
	 foreach ($resultado as $row) {
		$allcount= $row['cc'];
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
				
		
	
        $vidruninfomayor= 1;
		$vidruninfomenor = 1;
		if ($idempresaafil == ""  )
		{
			$vidruninfomenor = 1;
			$vidruninfomayor = 20000000000;
			$sql = $connect->prepare("SELECT distinct *  FROM lockerlog where idruninfo >= ".$vidruninfomenor." and idruninfo < ".$vidruninfomayor."  ORDER BY datelocket desc  LIMIT ".$rowid." OFFSET ".$rowperpage);
		}
		else
		{
				$vidruninfomenor = $idempresaafil * 10000000000;
				$vempresatemo = $idempresaafil+1;
				$vidruninfomayor = $vempresatemo * 10000000000;
				if ($idempresaafil == "3"  )
				{
					//solo Spinnaker. levantar datos viejos.
					$sql = $connect->prepare("SELECT distinct *  FROM lockerlog where idruninfo < 10000000000 and ip_mac like '%192.168.20%'  union   SELECT distinct *  FROM lockerlog where idruninfo >= ".$vidruninfomenor." and idruninfo < ".$vidruninfomayor."  ORDER BY datelocket desc  LIMIT ".$rowid." OFFSET ".$rowperpage);
				}
				else
				{
				$sql = $connect->prepare(" SELECT distinct *  FROM lockerlog where idruninfo >= ".$vidruninfomenor." and idruninfo < ".$vidruninfomayor."  ORDER BY datelocket desc  LIMIT ".$rowid." OFFSET ".$rowperpage);	
				}
				
		}	

	
	 
    $sql->execute();
    $resultado = $sql->fetchAll();




$employee_arr = array();
//$employee_arr[] = array("last_page" => $allcount);

$idcantrow=1;
 foreach ($resultado as $row) {
	 $idlockerlog =  $row['idlockerlog'];
   ////  idlockerlog, unitsn, fpga, crc, lookstatus, ip_mac, idruninfo, datelocket, crcm, crcmv
	   
    $unitsn = $row['unitsn'];
    $fpga = $row['fpga'];
	$crc = strtoupper ($row['crc']);  
	$lookstatus = strtoupper ($row['lookstatus']);  
	$ip_mac = $row['ip_mac'];  
	$idruninfo = $row['idruninfo'];  
	$datelocket = substr($row['datelocket'],0,19);  
	$crcchk = $row['crcmv'];  
	
	$idtypescript = $row['typescript'];
	
	$vpermanentlock = strtoupper($row['permanentlock']);
	$vstatusCheck = strtoupper($row['statuscheck']);
	
	if($row['typescript'] ==0)
	{
			$typescript="Dig Mod.";
	}
	if($row['typescript'] ==1)
	{
			$typescript="Calib.";
	}
	if($row['typescript'] ==2)
	{
			$typescript="Final Chk.";
	}


    $employee_arr[] = array("unitsn" => $unitsn,"fpga" => $fpga,"crc" => $crc, "lookstatus" => $lookstatus , "ip_mac" => $ip_mac, "idruninfo" => $idruninfo, "datelocket" => $datelocket,"idtypescript"=>$idtypescript,"crcchk"=> $crcchk,"typescript"=>$typescript,"permanentlock"=>$vpermanentlock ,"statuscheck"=>$vstatusCheck);

	
}

/* encoding array to JSON format */
echo(json_encode(["last_page"=>$rowid, "data"=>$employee_arr,"a"=>$rowperpage]));


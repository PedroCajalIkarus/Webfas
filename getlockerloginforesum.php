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
				
		
	
        

	$sql = $connect->prepare("SELECT distinct *  FROM lockerlog where typescript = 2  and permanentlock = 'TRUE' ORDER BY datelocket desc  LIMIT ".$rowid." OFFSET ".$rowperpage);
	 //$sql = $connect->prepare("SELECT distinct *  FROM lockerlog where typescript = 2  and permanentlock = 'TRUE'  ORDER BY datelocket desc  ");
	
/*	$sql = $connect->prepare("select  distinct lockerlog.* 
	from lockerlog
	inner join (
	SELECT unitsn, max(datelocket) as maxfechasn FROM lockerlog where typescript = 2  and permanentlock = 'TRUE' group by unitsn  
		) as losmaxid
	on lockerlog.unitsn =  losmaxid.unitsn and
	lockerlog.datelocket = losmaxid.maxfechasn
	
	ORDER BY datelocket desc LIMIT ".$rowid." OFFSET ".$rowperpage); */
	 
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


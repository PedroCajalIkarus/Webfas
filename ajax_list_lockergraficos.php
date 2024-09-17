<?php
 include("db_conect.php"); 
	include("funcionesstores.php"); 
	header('Content-Type: application/json');
	

	$query_lista = "select losdias.*, losfinalchk.cc as ccfinalchk, COALESCE(loscalibration.cc,0) as cccalib
from (
select distinct date_part('month',datelocket) as elmes , date_part('year',datelocket) as elanio, date_part('day',datelocket) as eldia
from lockerlog 
inner join (
select unitsn, max(datelocket) as maxdatelocket from lockerlog
group by unitsn) as maxestadoxunitsn
on lockerlog.unitsn =  maxestadoxunitsn.unitsn and 
   lockerlog.datelocket =  maxestadoxunitsn.maxdatelocket
 	order by  elanio, elmes desc ,eldia  desc
limit 7   
	) as losdias
	left join (
	select  date_part('month',datelocket) as elmes , date_part('year',datelocket) as elanio, date_part('day',datelocket) as eldia ,count(lockerlog.unitsn) as cc
from lockerlog 
inner join (
select unitsn, max(datelocket) as maxdatelocket from lockerlog
group by unitsn) as maxestadoxunitsn
on lockerlog.unitsn =  maxestadoxunitsn.unitsn and 
   lockerlog.datelocket =  maxestadoxunitsn.maxdatelocket
		where typescript= 2
		group by  elanio, elmes, eldia ,typescript
	) as losfinalchk
	on losfinalchk.elanio = losdias.elanio and
	   losfinalchk.elmes = losdias.elmes and 
	   losfinalchk.eldia = losdias.eldia
	   left join (
	select  date_part('month',datelocket) as elmes , date_part('year',datelocket) as elanio, date_part('day',datelocket) as eldia ,count(lockerlog.unitsn) as cc
from lockerlog 
inner join (
select unitsn, max(datelocket) as maxdatelocket from lockerlog
group by unitsn) as maxestadoxunitsn
on lockerlog.unitsn =  maxestadoxunitsn.unitsn and 
   lockerlog.datelocket =  maxestadoxunitsn.maxdatelocket
		where typescript= 1
		group by  elanio, elmes, eldia ,typescript
	) as loscalibration
	on loscalibration.elanio = losdias.elanio and
	   loscalibration.elmes = losdias.elmes and 
	   loscalibration.eldia = losdias.eldia	";
    $return_arr = array();
 	
	
	
	$data = $connect->query($query_lista)->fetchAll();	
	foreach ($data as $row) {			
	//	array_push($return_arr,  $row[0]);		
	$namescriptemp="";
		$cccalib=0;
		$return_arr[] = array("aniomes" => $row[0]."-".$row[1], "quantitycalib" => $cccalib,"quantityfchk"=>$row['cc'] );		
	 }
	 /////////////////////////////////////////////////////
	 



 echo(json_encode($return_arr));

 /*
echo json_encode(array(
    array(
        "name"          => "Ducks",
        "img"           => "ducks",
        "city"          => "Anaheim",
        "id"            => "ANA",
        "conference"    => "Western",
        "division"      => "Pacific"
    ),
    array(
        "name"          => "Thrashers",
        "img"           => "thrashers",
        "city"          => "Atlanta",
        "id"            => "ATL",
        "conference"    => "Eastern",
        "division"      => "Southeast"
    )
 ));
 */
?>
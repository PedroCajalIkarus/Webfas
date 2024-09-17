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
	if ( $param_search=="")
	{
		$elwhere="";
		$val_show_inputtextp1="";
	}
	
	if ( $param_search=="fiplexlog2")
	{
		$val_show_inputtextp2t1=$_REQUEST['t1'];
		$val_show_inputtextp2t2=$_REQUEST['t2'];
		$val_show_inputtextp2t3=$_REQUEST['t3'];
		$val_show_inputtextp2t4=$_REQUEST['t4'];
		$elwhere1="";
		$elwhere2="";
		$elwhere3="";
		$elwhere4="";
		$anteswhere="";
			$elwhere=" where ";
		if ($val_show_inputtextp2t1 <> "")
		{
			$the_date = explode(" ",$val_show_inputtextp2t1);
			
			//echo $the_date[2];
			$nuevafecha =strtotime($the_date[2]."+ 1 days"); 
			 $nuevafecha = date ( 'm/d/Y' , $nuevafecha );
			// echo "-".$nuevafecha;
			 
			$the_date_d = explode("/",$the_date[0]);
			$the_date_h = explode("/",$nuevafecha);
			//$dianuevo = $the_date_h[1]+1;
			$dianuevo = $the_date_h[1];
			$newthe_date_d = $the_date_d[2]."/".$the_date_d[0]."/".$the_date_d[1];
			$newthe_date_h =$the_date_h[2]."/".$the_date_h[0]."/".$dianuevo;
			
			$elwhere1=" dateinfom between '".$newthe_date_d."' and '".$newthe_date_h."' ";
			
			$elwhere=$elwhere.$elwhere1;
		}
		if ($val_show_inputtextp2t2 <> "")
		{
			if ($elwhere1 <> "")
			{
				$anteswhere=" and ";
			}
			$elwhere2=$anteswhere." userruninfo like '%".$val_show_inputtextp2t2."%' " ;
			$elwhere=$elwhere.$elwhere2;
		}
		if ($val_show_inputtextp2t3 <> "")
		{
			if ($elwhere1 <> "" || $elwhere2 <> "")
			{
				$anteswhere=" and ";
			}
			$elwhere3=$anteswhere." station like '%".$val_show_inputtextp2t3."%' " ;
			$elwhere=$elwhere.$elwhere3;
		}
		if ($val_show_inputtextp2t4 <> "")
		{
			if ($elwhere1 <> "" || $elwhere2 <> "" || $elwhere3 <> "" )
			{
				$anteswhere=" and ";
			}
			$elwhere4=$anteswhere." script like '%".$val_show_inputtextp2t4."%' " ;
			$elwhere=$elwhere.$elwhere4;
		}
		
	
		
	}
	

$sql = $connect->prepare("select count(*) as cc from  runinfo ");
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
				
		
	
        
/*
	
	 $sql = $connect->prepare("SELECT distinct  idruninfo, to_char(dateserver,'YYYYY/MM/DD HH24:MI:SS') as fechamm,  to_char(dateserver,'YYYY/MM/DD') as fechacorta,to_char(dateserver,'hh')AS hr,to_char(dateserver,'HH24:MI:SS') as hrcorta,
	trim(userruninfo) as userruninfo, case when  trim(station)='Null' then 'Uknown' else trim(station) end as station, case when trim(device)='Null' then 'Uknown' else trim(device) end  as device, trim(Script) as Script,
	case when to_char(dateserver,'hh')= '01' then 'A'
	when to_char(dateserver,'hh')= '02' then 'A'
	when to_char(dateserver,'hh')= '03' then 'A'
	when to_char(dateserver,'hh')= '04' then 'A'
	when to_char(dateserver,'hh')= '05' then 'A'
	when to_char(dateserver,'hh')= '06' then 'A'
	when to_char(dateserver,'hh')= '07' then 'A'
	when to_char(dateserver,'hh')= '08' then 'A'
	when to_char(dateserver,'hh')= '09' then 'A'
	when to_char(dateserver,'hh')= '10' then 'A'
	when to_char(dateserver,'hh')= '11' then 'B'
	when to_char(dateserver,'hh')= '12' then 'B'
	when to_char(dateserver,'hh')= '13' then 'B'
	when to_char(dateserver,'hh')= '14' then 'C'
	when to_char(dateserver,'hh')= '15' then 'C'
	when to_char(dateserver,'hh')= '16' then 'D'
	when to_char(dateserver,'hh')= '17' then 'D'
	when to_char(dateserver,'hh')= '18' then 'D'
	when to_char(dateserver,'hh')= '19' then 'D'
	when to_char(dateserver,'hh')= '20' then 'D'
	when to_char(dateserver,'hh')= '21' then 'D'
	when to_char(dateserver,'hh')= '22' then 'D'
	when to_char(dateserver,'hh')= '23' then 'D'
	when to_char(dateserver,'hh')= '00' then 'D'
	end as hrrango 
	FROM runinfo ".$elwhere." ORDER BY  idruninfo desc, fechamm desc,  hr DESC, hrcorta desc  LIMIT ".$rowid." OFFSET ".$rowperpage);
*/
	
$sql = $connect->prepare("SELECT distinct  idruninfo, to_char(dateserver,'YYYYY/MM/DD HH24:MI:SS') as fechamm,  to_char(dateserver,'YYYY/MM/DD') as fechacorta,to_char(dateserver,'hh')AS hr,to_char(dateserver,'HH24:MI:SS') as hrcorta,
trim(userruninfo) as userruninfo, case when  trim(station)='Null' then 'Uknown' else trim(station) end as station, case when trim(device)='Null' then 'Uknown' else trim(device) end  as device, trim(Script) as Script,
case when to_char(dateserver,'hh')= '01' then 'A'
when to_char(dateserver,'hh')= '02' then 'A'
when to_char(dateserver,'hh')= '03' then 'A'
when to_char(dateserver,'hh')= '04' then 'A'
when to_char(dateserver,'hh')= '05' then 'A'
when to_char(dateserver,'hh')= '06' then 'A'
when to_char(dateserver,'hh')= '07' then 'A'
when to_char(dateserver,'hh')= '08' then 'A'
when to_char(dateserver,'hh')= '09' then 'A'
when to_char(dateserver,'hh')= '10' then 'A'
when to_char(dateserver,'hh')= '11' then 'B'
when to_char(dateserver,'hh')= '12' then 'B'
when to_char(dateserver,'hh')= '13' then 'B'
when to_char(dateserver,'hh')= '14' then 'C'
when to_char(dateserver,'hh')= '15' then 'C'
when to_char(dateserver,'hh')= '16' then 'D'
when to_char(dateserver,'hh')= '17' then 'D'
when to_char(dateserver,'hh')= '18' then 'D'
when to_char(dateserver,'hh')= '19' then 'D'
when to_char(dateserver,'hh')= '20' then 'D'
when to_char(dateserver,'hh')= '21' then 'D'
when to_char(dateserver,'hh')= '22' then 'D'
when to_char(dateserver,'hh')= '23' then 'D'
when to_char(dateserver,'hh')= '00' then 'D'
end as hrrango 
from (
		select dateserver,Script,device,station,userruninfo,idruninfo
	FROM runinfodb ".$elwhere."
) as sss
 ORDER BY   fechamm desc,  hr DESC, hrcorta desc  LIMIT ".$rowid." OFFSET ".$rowperpage);


    $sql->execute();
    $resultado = $sql->fetchAll();




$employee_arr = array();
//$employee_arr[] = array("last_page" => $allcount);

$idcantrow=1;
 foreach ($resultado as $row) {
	 $idruninfo =  $row['idruninfo'];
   // $idruninfo = $Encryption->encrypt($row['idruninfo'], $semillafp); // $row['idruninfo'];
	   
    $fechacorta = $row['fechacorta'];
    $station = $row['station'];
	$script = $row['script'];  
	$device = $row['device'];  
	$userruninfo = $row['userruninfo'];  
	$hr = $row['hrcorta'];  

    $employee_arr[] = array("idruninfo" => $idruninfo,"fechacorta" => $fechacorta." ".$hr,"station" => $station, "script" => $script , "device" => $device, "userruninfo" => $userruninfo);

	
}

/* encoding array to JSON format */
echo(json_encode(["last_page"=>$rowid, "data"=>$employee_arr,"a"=>$rowperpage]));


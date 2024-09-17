<?php
error_reporting(0);
    include("db_conect.php"); 
		header('Content-Type: application/json');

	$sqlmm="select *, dateinfom + totaltime as totaltimesum, dateinfom + totalparcial as totaltimeparcial, datetimeend
	from (
	  select device, station ,userruninfo, runinfodb.script , dateinfom,  dateserver ,runinfodb.idruninfo ,  max (fas_times.duration) as totaltime, 
	sum(fas_times_typett.duration) as totalparcial, max(datetimeend) as datetimeend
	from runinfodb
	left join fas_times
	on fas_times.idruninfo = runinfodb.idruninfo and
	fas_times.idtimetype = 0
	left join fas_times as fas_times_typett
	on fas_times_typett.idruninfo = runinfodb.idruninfo and
	fas_times_typett.idtimetype > 0
	left join fas_stats_bugs as fas_stats_bugs
	on fas_stats_bugs.idruninfo = runinfodb.idruninfo
	where dateserver  > NOW() - INTERVAL '1 DAY'
	and userruninfo not in ('fasserver')
	
	and runinfodb.script  not like '%Print%'
		  and runinfodb.script  not like '%Test%' and device not like '%webfas%'
	group by device, station,  userruninfo, runinfodb.script , dateinfom,  dateserver, runinfodb.idruninfo
	order by station ,userruninfo
	) as  ttt  order by userruninfo , dateserver
	
	";
	$datalineality = $connect->query($sqlmm)->fetchAll();

	$arr_scriptcolor = [
		'5c6bc0' => 'Unit Calibration',
		'202020' =>'Accept DigitalBoard',
		'db4437' =>'Total Pass',
		'e06055' =>'Printer Services StandAlone',
		'e4776e' =>'Print Label',
		'f5bf26' =>'Accept DiB Flex',
		'51b886' =>'Accept Module',
		'ab47bc' =>'Product Excel Importer',
		'c27ace' =>'SOFUSA Generator',
		'ab47bc' =>'Digital Module',
		'ff7043' =>'Test Script',
		'9e9d24' =>'Unit Final Check',
		'f06292' =>'Unlock DiB',
		'acab44' =>'Instruments GUI'
		];

	$usu="";
	$cantusarios=0;
	$cantitem=0;
	foreach ($datalineality as $row) 
	{
		if ( trim($usu) <> trim($row['userruninfo']))
		{
			$usu = trim($row['userruninfo']);
			$ususation = trim($row['station']);
			$cantusarios=$cantusarios + 1;

			$return_items[] = array(
				"id"=> $cantusarios,		 
				"content" => "'".$ususation."'"		
			   );	
		}

		$tem= array_search( trim($row['script']), $arr_scriptcolor );
		if ($tem=="")
		{
		  $tem="orange";
		}
		$tem="mm".$tem;
		/*if ( $row['idrev']>0)
		{
			$tem="red";
		}*/

		$label_a_mostrar =trim($row['device'])." - ".trim($row['script'])."-".trim($row['idruninfo'])  ;
	///	$label_a_mostrar="Band:".trim($row['band'])."-UL/DL:".trim($row['uldl'])."-".trim($row['namebranch'])."[".trim($row['idrev'])."]" ;

		$cantitem= $cantitem+ 1;
		$fechafin="";
		$duracioinfo="";
		if ($row['datetimeend'] ==NULL  )
		{
		  if ($row['totaltimesum'] ==NULL )
		  {
			if ($row['totaltimeparcial'] ==NULL )
			{
			  $fechafin=$row['dateinfom'];
			  $duracioinfo="0";  
			}
			else
			{
			  $fechafin=$row['totaltimeparcial'];
			  $duracioinfo=$row['totalparcial'];  
			}
		  }
		  else
		  {
			$fechafin=$row['totaltimesum'];
			$duracioinfo=$row['totaltime'];  
		  }
		}
		else
		{
		  $fechafin=$row['dateinfom'];
		  $duracioinfo="0";  
		}
		   
		$label_a_mostrar_title =  trim($row['device'])."<br>Script:". trim($row['script'])."<br>IdRuninfo: ".trim($row['idruninfo']) ."<br>FI:".$row['dateinfom']."<br>FE:".$fechafin;
		 

		   $return_grupos[] = array(
			"id" => $cantitem,
			"content" =>$label_a_mostrar ,
			"start" => $row['dateinfom'],
			"end" =>$fechafin,
			"className" =>	$tem,
			"editable" => "false",
			"selectable" =>"false",
			"group" =>$cantusarios,
			"title"=>	$label_a_mostrar_title				 
	   );
	   
		   
		  
	}
	 
				
			 
echo(json_encode(["grupos"=>$return_items,  "items"=>$return_grupos]));
?>

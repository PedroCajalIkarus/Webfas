<?php
error_reporting(0);
    include("db_conect.php"); 
		header('Content-Type: application/json');

	
$sqlmmhead="
select distinct  
bandnuevo, listroutime.uldl
from fas_tree_measure 
inner join
(
	select fas_routines_product.*,fas_step.description as branchname, CASE fas_routines_product.idband
WHEN 0  THEN 0
WHEN 3  THEN 0
WHEN 4  THEN 1
WHEN 8  THEN 1
WHEN 7  THEN 1
WHEN 1  THEN 1
WHEN 6  THEN 1
ELSE NULL
END AS bandnuevo from  fas_routines_product 
	inner join fas_tree_product 
	on fas_tree_product.idproduct = fas_routines_product.idproduct
	inner join fas_tree
	on fas_tree.iduniquebranch = fas_routines_product.iduniquebranch
	and fas_tree.idfastree = fas_tree_product.idfastree
	inner join fas_step
	on fas_tree.idfastrepson = fas_step.idfasstep
	where fas_routines_product.idproduct = (SELECT idproduct from fnt_select_allproducts_maxrev() where modelciu like 'DH7S-A') 
	 
	and fas_routines_product.active = 'Y'
	order by idorden
) as listroutime
on listroutime.iduniquebranch =  fas_tree_measure.iduniquebranch
inner join runinfodb
on runinfodb.idruninfodb = fas_tree_measure.idrununfo
inner join fas_times
on fas_times.iduniqueop   = fas_tree_measure.iduniqueop 
and fas_times.idsinglemeasure is null 
and fas_times.idsameasures is null
and fas_times.iducmeasure is null

inner join fas_times_type
on fas_times_type.idtimetype = fas_times.idtimetype
where idrununfo = 10901032323
group by branchname ,  fas_times_type.timename,	userruninfo, station, device, runinfodb.idruninfo  ,bandnuevo, listroutime.uldl


";
$tem="orange";
$dataheadr = $connect->query($sqlmmhead)->fetchAll();
foreach ($dataheadr as $rowhead) 
	{
		$nomULDL="";
		if ($rowhead['uldl']==0)
		{
			$nomULDL=" - UpLink";
		}
		else
		{
			$nomULDL=" - DownLink";
		}
	 	$iduniconombre = "Band:".$rowhead['bandnuevo'].$nomULDL; 
 
				 $idunico = "T".$rowhead['bandnuevo'].$rowhead['uldl'];
				 $return_cabezera[] = array(
					 "id" => $idunico,
					 "content" =>$iduniconombre ,
					 "value" =>$idunico ,
					 "className" =>	$tem		 
					   );
			
	   
	}


	$sqlmm="
	select distinct branchname as script,    fas_times_type.timename, fas_tree_measure.datetime as datetimelog , (max(fas_tree_measure.datetime+fas_times.duration)::time) as datetimelogresta ,
userruninfo, station, device, runinfodb.idruninfo ,
bandnuevo, listroutime.uldl, fas_tree_measure.iduniquebranch


from fas_tree_measure 
inner join
(
	select fas_routines_product.*,fas_step.description as branchname, CASE fas_routines_product.idband
WHEN 0  THEN 0
WHEN 3  THEN 0
WHEN 4  THEN 1
WHEN 8  THEN 1
WHEN 7  THEN 1
WHEN 1  THEN 1
WHEN 6  THEN 1
ELSE NULL
END AS bandnuevo from  fas_routines_product 
	inner join fas_tree_product 
	on fas_tree_product.idproduct = fas_routines_product.idproduct
	inner join fas_tree
	on fas_tree.iduniquebranch = fas_routines_product.iduniquebranch
	and fas_tree.idfastree = fas_tree_product.idfastree
	inner join fas_step
	on fas_tree.idfastrepson = fas_step.idfasstep
	where fas_routines_product.idproduct = (SELECT idproduct from fnt_select_allproducts_maxrev() where modelciu like 'DH7S-A') 
	 
	and fas_routines_product.active = 'Y'
	order by idorden
) as listroutime
on listroutime.iduniquebranch =  fas_tree_measure.iduniquebranch and
listroutime.bandnuevo =  fas_tree_measure.band and
listroutime.uldl =  fas_tree_measure.uldl 

inner join runinfodb
on runinfodb.idruninfodb = fas_tree_measure.idrununfo
inner join fas_times
on fas_times.iduniqueop   = fas_tree_measure.iduniqueop 
and fas_times.idsinglemeasure is null 
and fas_times.idsameasures is null
and fas_times.iducmeasure is null

inner join fas_times_type
on fas_times_type.idtimetype = fas_times.idtimetype
where idrununfo = 10901032323  
group by branchname ,  fas_times_type.timename,	userruninfo, station, device, runinfodb.idruninfo  ,bandnuevo, listroutime.uldl, fas_tree_measure.iduniquebranch,fas_tree_measure.datetime
order by script, bandnuevo, uldl 
	
	";
	$datalineality = $connect->query($sqlmm)->fetchAll();

	$arr_scriptcolor = [
		'5c6bc0' => 'Calibration_EQ_Calibration_Rx',
		'202020' =>'Calibration_EQ_Calibration_Tx',
		'db4437' =>'Calibration_EQ_Check_Rx',
		'e06055' =>'Calibration_EQ_Check_Tx',
		'e4776e' =>'Calibration_LSGP_Calibration_Current',
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
	///	$tem = "mm".$row['colorgenerado'];
		/*if ( $row['idrev']>0)
		{
			$tem="red";
		}*/

	//	$label_a_mostrar =trim($row['device'])." - ".trim($row['script'])."-".trim($row['idruninfo'])  ;
		$label_a_mostrar = "" .trim($row['script']).'';
	///	$label_a_mostrar="Band:".trim($row['band'])."-UL/DL:".trim($row['uldl'])."-".trim($row['namebranch'])."[".trim($row['idrev'])."]" ;

		$cantitem= $cantitem+ 1;
		$fechafin="";
		$duracioinfo="";
		
			$fechafin=$row['datetimelogresta'];
			$duracioinfo=$row['duration'];  
	
		   
		$label_a_mostrar_title = "Duration:01:02:03<br>".trim($row['device'])."<br>Script:". trim($row['script'])."<br>IdRuninfo: ".trim($row['idruninfo']) ."<br>FI:".$row['dateinfom']."<br>FE:".$fechafin;
	//	$label_a_mostrar_title =  "Script:". trim($row['script']);
			$nombrgrupoarmado = "T".$row['bandnuevo'].$row['uldl'];

		   $return_grupos[] = array(
			"id" => $cantitem,
			"content" =>$label_a_mostrar ,
			"start" => $row['datetimelog'],
			"end" =>$fechafin,
				"className" =>	$tem,
			"editable" => "false",
			"selectable" =>"false",			 
			"title"=>	$label_a_mostrar_title	 
	   );
	   
	

		   
		  
	}
	 
				
			 
echo(json_encode(["grupos"=>$return_cabezera1,  "items"=>$return_grupos]));
?>

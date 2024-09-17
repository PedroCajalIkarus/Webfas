<?php
error_reporting(0);
    include("db_conect.php"); 
		header('Content-Type: application/json');

		$idrun = $_REQUEST['idruninfo'];
	
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
	where fas_routines_product.idproduct in (
	 	select distinct idproduct from products where classproduct in (
        select distinct classproduct from products where idproduct in (
        select idproduct from 
          (
          SELECT idproduct ,1 as ordernmm from orders_sn where typeregister = 'SO' and  wo_serialnumber in (select unitsn from fas_tree_measure where idrununfo = ".$idrun.")
          union 
          SELECT idproduct,2  from orders_sn where typeregister = 'WO' and  wo_serialnumber in (select unitsn from fas_tree_measure where idrununfo = ".$idrun.")
          ) as lasdos order by ordernmm asc limit 1))
          and idproduct in (
          select distinct idproduct from products_attributes where v_boolean= true and idattribute = 0
          )
		  )
	 
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
where idrununfo = ".$idrun ."
group by branchname ,  fas_times_type.timename,	userruninfo, station, device, runinfodb.idruninfo  ,bandnuevo, listroutime.uldl


";

	echo $sqlmmhead."<br>";
 
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

 
	$sqlmmresu="
	select distinct products.modelciu as modelcuipp, fas_routines_product_sn.sn,fas_calibration_result.*
		, coalesce(laduraciontotal.duration,'00:00:00') as laduracion,  to_char(laduraciontotal.datetimelog, 'YYYY-MM-DD') as datetimelogtotal  
		,coalesce(laduracionparcial.durationpartial,'00:00:00') as durationpartial,  laduracionparcial.datetimelog  as datetimelogparcial
		from fas_routines_product_sn
		inner join products
		on products.idproduct = fas_routines_product_sn.idproduct
		
		left join fas_calibration_result 
		 on 
		 
			fas_routines_product_sn.idruninfo		=	fas_calibration_result.idruninfo and
			fas_routines_product_sn.sn		=	fas_calibration_result.unitsn 
		
		left join (select * from fas_times where idruninfo = ".$idrun ." AND idtimetype = 0)
		as laduraciontotal on laduraciontotal.idruninfo = fas_routines_product_sn.idruninfo
		
		 
		
		left join 
		(select idruninfo,  to_char(datetimelog, 'YYYY-MM-DD') as datetimelog  , sum(duration) as durationpartial from fas_times where idruninfo =  ".$idrun ."  AND idtimetype = 1 
		 and idsinglemeasure is null and idsameasures is null and iducmeasure is null
		 group by idruninfo,  to_char(datetimelog, 'YYYY-MM-DD')  )
		as laduracionparcial
		on laduracionparcial.idruninfo = fas_routines_product_sn.idruninfo
		
		where fas_routines_product_sn.idruninfo = ".$idrun ." ";

//echo $sqlmmresu."<br>";

	$dataresumen = $connect->query($sqlmmresu)->fetchAll();
$entrotitu=0;
	foreach ($dataresumen as $rowmm) 
	{
		$entrotitu=1;
		$retureturn_titulo[] = array(
			"sn" => trim($rowmm['sn']),
			"modelciu" => trim($rowmm['modelcuipp']) ,
			"totalpass" => trim($rowmm['totalpass']) ,
			"durationpartial" => trim($rowmm['durationpartial']) ,
			"datetimelogparcial"=>trim($rowmm['datetimelogparcial']) ,
			"datetimelogtotal"=>trim($rowmm['datetimelogtotal']) ,
			"duration" =>trim($rowmm['laduracion']) 
		 
	   );
	}
	if($entrotitu==0)
	{
		$retureturn_titulo[] = array(
			"sn" => "",
			"modelciu" => "",
			"totalpass" =>"",
			"durationpartial" => "",
			"duration" => ""
		 
	   );
	}


	$sqlmm="
	select distinct fas_tree_measure.iduniqueop , branchname as script,    fas_times_type.timename, fas_tree_measure.datetime as datetimelog , (fas_tree_measure.datetime+ max(fas_times.duration)::time) as datetimelogresta ,
userruninfo, station, device, runinfodb.idruninfo ,
bandnuevo, listroutime.uldl, fas_tree_measure.iduniquebranch , max(fas_times.duration) as durationmm


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
	where fas_routines_product.idproduct 
	in (

		select distinct idproduct from products where classproduct in (
			select distinct classproduct from products where idproduct in (
			select idproduct from 
			  (
			  SELECT idproduct ,1 as ordernmm from orders_sn where typeregister = 'SO' and  wo_serialnumber in (select unitsn from fas_tree_measure where idrununfo = ".$idrun.")
			  union 
			  SELECT idproduct,2  from orders_sn where typeregister = 'WO' and  wo_serialnumber in (select unitsn from fas_tree_measure where idrununfo = ".$idrun.")
			  ) as lasdos order by ordernmm asc limit 1))
			  and idproduct in (
			  select distinct idproduct from products_attributes where v_boolean= true and idattribute = 0
			  )
			  
	 )
	 
	and fas_routines_product.active = 'Y'
	order by idorden
) as listroutime
on listroutime.iduniquebranch =  fas_tree_measure.iduniquebranch and
listroutime.bandnuevo =  fas_tree_measure.band and
listroutime.uldl =  fas_tree_measure.uldl  and
listroutime.idorden         = fas_tree_measure.idorder and 
fas_tree_measure.idrununfo = ".$idrun."

inner join runinfodb
on runinfodb.idruninfodb = fas_tree_measure.idrununfo
inner join fas_times
on fas_times.iduniqueop   = fas_tree_measure.iduniqueop 
and fas_times.idsinglemeasure is null 
and fas_times.idsameasures is null
and fas_times.iducmeasure is null

inner join fas_times_type
on fas_times_type.idtimetype = fas_times.idtimetype
where idrununfo = ".$idrun."  
group by fas_tree_measure.iduniqueop , branchname ,  fas_times_type.timename,	userruninfo, station, device, runinfodb.idruninfo  ,bandnuevo, listroutime.uldl, fas_tree_measure.iduniquebranch,fas_tree_measure.datetime
order by script, bandnuevo, uldl  
	
	";

	//echo $sqlmm."<br>99<br>";
 
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
	
		   
		$label_a_mostrar_title = "Duration:".trim($row['durationmm'])." <br>iduniqueop:".trim($row['iduniqueop'])."<br>".trim($row['device'])."<br>Script:". trim($row['script'])."<br>IdRuninfo: ".trim($row['idruninfo']) ."<br>FI:".$row['datetimelog']."<br>FE:".$fechafin;
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
			"title"=>	$label_a_mostrar_title	,
			"group"=> $nombrgrupoarmado			 
	   );
	   
	

		   
		  
	}
	 
	////////// 700 /////////////////////////////////
	//////////////////// Loaded // Unloaded // Threshold /////////////////////////////
	////Calibration_Threshold_ReturnLoss_Loaded
	$sql_ReturnLoss_Loaded ="	select distinct idscriptoutcometype, v_double from fas_outcome 
	where iduniqueop in (select iduniqueop from fas_tree_measure 
						 where iduniquebranch = '00108F090091' and band=0 
						and uldl=1 and idrununfo =  ".$idrun." )";

			//			echo "<br><hr>aaaaa: ".$sql_ReturnLoss_Loaded;

	$dataReturnLoss_Loaded = $connect->query($sql_ReturnLoss_Loaded)->fetchAll();
//	echo "123aaaa132";
	foreach ($dataReturnLoss_Loaded as $row_Loaded) 
	{
		$val_Loaded_700 = $row_Loaded['v_double'];
	}
//	echo "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";

	////// Calibration_Threshold_ReturnLoss_Unloaded
	$sql_Threshold_ReturnLoss_Unloaded=" select distinct idscriptoutcometype, v_double from fas_outcome 
		where iduniqueop in (select iduniqueop from fas_tree_measure 
					where iduniquebranch =  '00108F090092'  and band=0 
					and uldl=1 and idrununfo = ".$idrun.")";

					
//	echo "<br><hr>bbb: ".$sql_Threshold_ReturnLoss_Unloaded;	
	$dataReturnLoss_Unloaded = $connect->query($sql_Threshold_ReturnLoss_Unloaded)->fetchAll();



	///// Sobre la misma medicionn(iduniqueio) esta los dos valores asociados..
	foreach ($dataReturnLoss_Unloaded as $row_UnLoaded) 
	{
		if (  $row_UnLoaded['idscriptoutcometype'] == 48)
		{
			$val_UnLoaded_700 = $row_UnLoaded['v_double'];
		}
		if (  $row_UnLoaded['idscriptoutcometype'] == 57)
		{
			$val_Threshold_ReturnLoss_700 = $row_UnLoaded['v_double'];
		}
		
	}
	//////////////////// Loaded // Unloaded // Threshold /////////////////////////////
	////////////// 800 /////////////////////////////
		//////////////////// Loaded // Unloaded // Threshold /////////////////////////////
	////Calibration_Threshold_ReturnLoss_Loaded
	$sql_ReturnLoss_Loaded ="	select distinct idscriptoutcometype, v_double from fas_outcome 
	where iduniqueop in (select iduniqueop from fas_tree_measure 
						 where iduniquebranch = '00108F090091' and band=1 
						and uldl=1 and idrununfo =  ".$idrun." )";
	$dataReturnLoss_Loaded = $connect->query($sql_ReturnLoss_Loaded)->fetchAll();
	foreach ($dataReturnLoss_Loaded as $row_Loaded) 
	{
		$val_Loaded_800 = $row_Loaded['v_double'];
	}

	////// Calibration_Threshold_ReturnLoss_Unloaded
	$sql_Threshold_ReturnLoss_Unloaded=" select idscriptoutcometype, v_double from fas_outcome 
		where iduniqueop = (select iduniqueop from fas_tree_measure 
					where iduniquebranch =  '00108F090092'  and band=1 
					and uldl=1 and idrununfo = ".$idrun.")";
	$dataReturnLoss_Unloaded = $connect->query($sql_Threshold_ReturnLoss_Unloaded)->fetchAll();

	///// Sobre la misma medicionn(iduniqueio) esta los dos valores asociados..
	foreach ($dataReturnLoss_Unloaded as $row_UnLoaded) 
	{
		if (  $row_UnLoaded['idscriptoutcometype'] == 48)
		{
			$val_UnLoaded_800 = $row_UnLoaded['v_double'];
		}
		if (  $row_UnLoaded['idscriptoutcometype'] == 57)
		{
			$val_Threshold_ReturnLoss_800 = $row_UnLoaded['v_double'];
		}
		
	}
	//////////////////// Loaded // Unloaded // Threshold /////////////////////////////
	////////////// fin 800 /////////////////////////////
	$return_ReturnLoss[] = array(
		"v700_Loaded" => $val_Loaded_700,
		"v700_UnLoaded" => 	$val_UnLoaded_700 ,
		"v700_Threshold" => $val_Threshold_ReturnLoss_700,
		"v800_Loaded" => $val_Loaded_800,
		"v800_UnLoaded" =>$val_UnLoaded_800 ,
		"v800_Threshold" => $val_Threshold_ReturnLoss_800
		 		 
   );

				
			 
echo(json_encode(["grupos"=>$return_cabezera,  "items"=>$return_grupos, "titulo"=>$retureturn_titulo, "returnloss"=>$return_ReturnLoss]));
?>

<?php
 include("db_conect.php"); 
	
	header('Content-Type: application/json');
$array = array();	

	$query_lista = "select idfasoutcomecat, idtype, array_to_json(array_agg(arraymeasures)) as arraymeasures2
	from
	(
			select unitsn ,idfasoutcomecat, idtype,   concat(CAST(v_double as  character varying), '#' ,  CAST(positionmm  as character varying) )  as arraymeasures 
		from
		(
	
			select row_number() OVER(ORDER BY lossn.v_string DESC) AS positionmm, lossn.reference as idrununfo, 
			lossn.v_string as unitsn  , fas_outcome_integral.idfasoutcomecat, fas_outcome_integral.idtype, 
			fas_outcome_integral.v_double, fas_outcome_integral.v_integer
	
			from fnt_select_allsn_maxruninfo_byscript(22) as lossn
			inner join fas_routines_process_sn
			on  fas_routines_process_sn.sn 			=	lossn.v_string and
			fas_routines_process_sn.idruninfodb	=	lossn.reference	
			inner join fas_tree_measure
			on  fas_tree_measure.unitsn 			=	lossn.v_string and
			fas_tree_measure.idrununfo	=	lossn.reference	and
			fas_tree_measure.iduniqueop	=	fas_routines_process_sn.iduniqueop and 
			fas_tree_measure.iduniquebranch	='09B09F0AD'
			inner join fas_outcome_integral
			on fas_outcome_integral.reference	=	fas_routines_process_sn.iduniqueop and 
			fas_outcome_integral.idfasoutcomecat in (3,5,2) AND fas_outcome_integral.idtype =0
			-----order by lossn.datetimeref desc
		) as kk
		 
	) as mam
	group by idfasoutcomecat, idtype
	
				";


						
						
	$data = $connect->query($query_lista)->fetchAll();	
	foreach ($data as $row) {			
		if ($row['idfasoutcomecat']==5 &&  $row['idtype']==0)
		{
			$volreadmeasure =  $row['arraymeasures2'];
		}	
		if ($row['idfasoutcomecat']==3 &&  $row['idtype']==0)
		{
			$volread_eload =  $row['arraymeasures2'];
		}				

	 }

	 $array[] = array
	 (
	   'volreadmeasure' => $volreadmeasure,
	   'volread_eload' => $volread_eload ,
		 'icon'=> 'fa fa-inbox'
	 );

	$resul =  $array;
	

	 
echo(json_encode($resul));

?>
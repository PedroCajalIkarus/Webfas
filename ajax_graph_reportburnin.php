<?php
error_reporting(0);
    include("db_conect.php"); 
	include("db_conect_srv20.php"); 
	 
		header('Content-Type: application/json');

		$idruninfo =$_REQUEST['idruninfo'];	
		$idrun =$_REQUEST['idruninfo'];	
		
		////////////////////////    //////////////////////////////////
$sqlmmhead="
select  fas_outcome_integral.idtype , uldl, idband as bandnuevo, description , ARRAY_AGG (    round( fas_outcome_integral.v_double)    ) as arrayvalue 	
, ARRAY_AGG ( to_char(fas_outcome_integral.datetimeref, 'HH24:MI:SS') order by fas_outcome_integral.datetimeref asc ) AS arraylabel 
from fas_outcome_integral
inner join 
(
		------- referencias de Id SingleMeasure
		select  fas_outcome_integral.*, losdatosSingleMeasure.uldl, idband, description
		from fas_outcome_integral
		inner join 
		(
			------- referencias de Id SingleMeasure
			select  fas_outcome_integral.*,losdatosiduniqueop.uldl, idband, description
			from fas_outcome_integral
			inner join 
			(

				----- Rerefencias de IdUniqueop
				select  fas_outcome_integral.id_outcome, uldl, idband, description
				from fas_outcome_integral
				inner join 
				(
				----- Rerefencias de uldl
					select  fas_outcome_integral.id_outcome, v_integer as uldl ,losdatosidband.idband, losdatosidband.description
					from fas_outcome_integral
					inner join 
					(
					----- Rerefencias de idband
					select id_outcome, v_integer as idband ,idband.description
					from fas_outcome_integral
					inner join idband 
					on idband.idband = fas_outcome_integral.v_integer
					where reference in
						(
							----- Rerefencias de Idruninfo
							select id_outcome from  fas_outcome_integral  where reference  = ".$idruninfo." and idfasoutcomecat= 0 and idtype = 23
						)
					) as losdatosidband
					on losdatosidband.id_outcome = fas_outcome_integral.reference
					) as losdatosuldl
					on losdatosuldl.id_outcome = fas_outcome_integral.reference

			) as losdatosiduniqueop
			on losdatosiduniqueop.id_outcome = fas_outcome_integral.reference
		) as losdatosSingleMeasure
			on losdatosSingleMeasure.id_outcome = fas_outcome_integral.reference
	) as losdatosucMeasure
	on losdatosucMeasure.id_outcome = fas_outcome_integral.reference
	where   fas_outcome_integral.idfasoutcomecat=5 and fas_outcome_integral.idtype in (8,11,18)
	group by  fas_outcome_integral.idtype , uldl, idband, description 

 	   
	
";

$sqlmmhead="	select  fas_outcome_integral.idfasoutcomecat ,  fas_outcome_integral.idtype , uldl, idband as bandnuevo, description , ARRAY_AGG (     fas_outcome_integral.v_double    ) as arrayvalue 	
, ARRAY_AGG ( to_char(fas_outcome_integral.datetimeref, 'HH24:MI:SS') order by fas_outcome_integral.datetimeref asc ) AS arraylabel 
from fas_outcome_integral
					 
					inner join 
					(

						----- Rerefencias de IdUniqueop
						select  fas_outcome_integral.id_outcome, uldl, idband, description
						from fas_outcome_integral
						inner join 
						(
						----- Rerefencias de uldl
							select  fas_outcome_integral.id_outcome, v_integer as uldl ,losdatosidband.idband, losdatosidband.description
							from fas_outcome_integral
							inner join 
							(
							----- Rerefencias de idband
							select id_outcome, v_integer as idband ,idband.description
							from fas_outcome_integral
							inner join idband 
							on idband.idband = fas_outcome_integral.v_integer
							where reference in
								(
									----- Rerefencias de Idruninfo
									select id_outcome from  fas_outcome_integral  where reference  =".$idruninfo." and idfasoutcomecat= 0 and idtype = 23
								)
							) as losdatosidband
							on losdatosidband.id_outcome = fas_outcome_integral.reference
							) as losdatosuldl
							on losdatosuldl.id_outcome = fas_outcome_integral.reference
							union 
							----- Rerefencias de IdUniqueop
							select  vv_id_outcome as id_outcome, vv_uldl as uldl , vv_idband as idband, vv_nomband as description
							
							 from select_outcome_integral_singlem_band_uldl_iduniqueop(".$idruninfo.")

					) as losdatosiduniqueop
					on losdatosiduniqueop.id_outcome = fas_outcome_integral.reference
					
					where   fas_outcome_integral.idfasoutcomecat=5 and fas_outcome_integral.idtype in (8,11,18)
					
					group by   fas_outcome_integral.idfasoutcomecat, fas_outcome_integral.idtype , uldl, idband, description ";
////////////////////// FinalCheck_Measures_IMD

 $i_0_0 = 0;
 $i_0_1 = 0;
 $i_1_0 = 0;
 $i_1_1 = 0;

 //echo $sqlmmhead;
 
$tem="orange";
$dataheadr = $connect20->query($sqlmmhead)->fetchAll();
foreach ($dataheadr as $rowhead) 
	{
		if ($rowhead['idtype'] ==8)
		{
						if ($rowhead['bandnuevo'] == 0 && $rowhead['uldl']==0)
			{
			    $lblname_0_0 = $rowhead['description']; 
				$values_pacurrent_0_0 = 	$values_pacurrent_0_0.substr($rowhead['arrayvalue'],1,-1).","; 		
			//	$label_pacurrent_0_0 = 	$label_pacurrent_0_0.substr($rowhead['arraylabel'],1,-1).","; 			
				$label_pacurrent_0_0 = 	$label_pacurrent_0_0.substr($rowhead['arraylabel'],1,-1); 			
			}
			if ($rowhead['bandnuevo'] == 0 && $rowhead['uldl']==1)
			{
				$lblname_0_1 = $rowhead['description']; 
				$values_pacurrent_0_1 = 	$values_pacurrent_0_1.substr($rowhead['arrayvalue'],1,-1).","; 	
				$label_pacurrent_0_1 = 	$label_pacurrent_0_1.substr($rowhead['arraylabel'],1,-1).","; 						
			}
			if ($rowhead['bandnuevo'] == 1 && $rowhead['uldl']==0)
			{
				$lblname_1_0 = $rowhead['description']; 
				$values_pacurrent_1_0 = 	$values_pacurrent_1_0.substr($rowhead['arrayvalue'],1,-1).","; 	
				$label_pacurrent_1_0 = 	$label_pacurrent_1_0.substr($rowhead['arraylabel'],1,-1).","; 							
			}
			if ($rowhead['bandnuevo'] == 1 && $rowhead['uldl']==1)
			{
				$lblname_1_1 = $rowhead['description']; 
				$values_pacurrent_1_1 = 	$values_pacurrent_1_1.substr($rowhead['arrayvalue'],1,-1).","; 
				$label_pacurrent_1_1 = 	$label_pacurrent_1_1.substr($rowhead['arraylabel'],1,-1).","; 								
			}
		}
		if ($rowhead['idtype'] ==11)
		{
			if ($rowhead['bandnuevo'] == 0 && $rowhead['uldl']==0)
			{
			    
				$values_temp_0_0 = 	$values_temp_0_0.substr($rowhead['arrayvalue'],1,-1).","; 	

				//$label_temp_0_0 = 	$label_temp_0_0.substr($rowhead['arraylabel'],1,-1).","; 	
				$label_temp_0_0 = 	$label_temp_0_0.substr($rowhead['arraylabel'],1,-1); 	
			}
			if ($rowhead['bandnuevo'] == 0 && $rowhead['uldl']==1)
			{
				
				$values_temp_0_1 = 	$values_temp_0_1.substr($rowhead['arrayvalue'],1,-1).","; 				
			}
			if ($rowhead['bandnuevo'] == 1 && $rowhead['uldl']==0)
			{
				
				$values_temp_1_0 = 	$values_temp_1_0.substr($rowhead['arrayvalue'],1,-1).","; 					
			}
			if ($rowhead['bandnuevo'] == 1 && $rowhead['uldl']==1)
			{
				
				$values_temp_1_1 = 	$values_temp_1_1.substr($rowhead['arrayvalue'],1,-1).","; 					
			}
		}
		if ($rowhead['idtype'] ==18)
		{
			if ($rowhead['bandnuevo'] == 0 && $rowhead['uldl']==0)
			{
			   
					$values_level_0_0 = 	$values_level_0_0.substr($rowhead['arrayvalue'],1,-1).","; 	
					//$label_level_0_0 = 	$label_level_0_0.substr($rowhead['arraylabel'],1,-1).","; 				
					$label_level_0_0 = 	$label_level_0_0.substr($rowhead['arraylabel'],1,-1); 				
				
				
			}
			if ($rowhead['bandnuevo'] == 0 && $rowhead['uldl']==1)
			{
				
				$values_level_0_1 = 	$values_level_0_1.substr($rowhead['arrayvalue'],1,-1).","; 				
			}
			if ($rowhead['bandnuevo'] == 1 && $rowhead['uldl']==0)
			{
				
				$values_level_1_0 = 	$values_level_1_0.substr($rowhead['arrayvalue'],1,-1).","; 					
			}
			if ($rowhead['bandnuevo'] == 1 && $rowhead['uldl']==1)
			{
				
				$values_level_1_1 = 	$values_level_1_1.substr($rowhead['arrayvalue'],1,-1).","; 					
			}
		}
		
		 
		 

	}

	 
//////////////////////// FIN    //////////////////////////////////
echo(json_encode(["label_pacurrent_0_0"=>$label_pacurrent_0_0,"label_level_0_0"=>$label_level_0_0,"label_temp_0_0"=>$label_temp_0_0, "lblname_0_0"=>$lblname_0_0,"lblname_0_1"=>$lblname_0_1,"lblname_1_0"=>$lblname_1_0,"lblname_1_1"=>$lblname_1_1,"values_pacurrent_0_0"=>$values_pacurrent_0_0,"values_pacurrent_0_1"=>$values_pacurrent_0_1,"values_pacurrent_1_0"=>$values_pacurrent_1_0,"values_pacurrent_1_1"=>$values_pacurrent_1_1,"values_temp_0_0"=>$values_temp_0_0,"values_temp_0_1"=>$values_temp_0_1,"values_temp_1_0"=>$values_temp_1_0,"values_temp_1_1"=>$values_temp_1_1,"values_level_0_0"=>$values_level_0_0,"values_level_0_1"=>$values_level_0_1,"values_level_1_0"=>$values_level_1_0,"values_level_1_1"=>$values_level_1_1 ]));
 
?>

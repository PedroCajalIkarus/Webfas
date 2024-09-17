<?php
error_reporting(0);
    include("db_conect.php"); 
	include("db_conect_srv20.php"); 
	 
		header('Content-Type: application/json');

		 
		$unitsn =$_REQUEST['unitsn'];	
		$idrun =$_REQUEST['idrun'];	
		
		////////////////////////    //////////////////////////////////

if ($idrun =="null")
{

	$sqlmmhead=" 
								select fas_step.description as namestep,  fas_outcome_integral.idfasoutcomecat ,  fas_outcome_integral.idtype  , fasoutcometypename , ARRAY_AGG (    fas_outcome_integral.v_double order by fas_outcome_integral.id_outcome  asc  ) as arrayvalue 	
								, ARRAY_AGG ( to_char(fas_outcome_integral.datetimeref, 'HH24:MI:SS') order by fas_outcome_integral.id_outcome asc ) AS arraylabel 
								
									   from   fnt_select_allfas_routines_process_sn_maxrev_byscript('".$unitsn."',22) as fas_routines_process_sn_t

									   inner join fas_routines_steps
										on fas_routines_steps.idstep = fas_routines_process_sn_t.idstep
										inner join fas_step
										on fas_step.instance = fas_routines_steps.instance 

										inner join fas_script_type
									  on fas_script_type.idscripttype  = fas_routines_process_sn_t.idscript
								 
									  inner join fas_outcome_integral
									  on fas_outcome_integral.reference = fas_routines_process_sn_t.iduniqueop  and
										  fas_routines_process_sn_t.iduniqueop			= 	fas_outcome_integral.reference
									  inner join fas_outcome_category_type
									  on  fas_outcome_category_type.idfasoutcomecat	=	fas_outcome_integral.idfasoutcomecat and
										  fas_outcome_category_type.idtype			=	fas_outcome_integral.idtype
									  
									  inner join fnt_select_maxidrun_fas_outcome_integral_byidscrip('".$unitsn."',22) as maxidrun
									  on maxidrun.reference =  fas_routines_process_sn_t.idruninfodb
									  where  fas_outcome_integral.idfasoutcomecat in(3,5)
								 
									 
									  group by fas_step.description ,fas_outcome_integral.idfasoutcomecat ,  fas_outcome_integral.idtype  , fasoutcometypename
									  		";


}
else
{ 
$sqlmmhead=" 
								select  fas_step.description as namestep, fas_outcome_integral.idfasoutcomecat ,  fas_outcome_integral.idtype  , fasoutcometypename , ARRAY_AGG (    fas_outcome_integral.v_double order by fas_outcome_integral.id_outcome  asc  ) as arrayvalue 	
								, ARRAY_AGG ( to_char(fas_outcome_integral.datetimeref, 'HH24:MI:SS') order by fas_outcome_integral.id_outcome asc ) AS arraylabel 
								
									   from   fnt_select_allfas_routines_process_sn_maxrev_byscript_byidrun('".$unitsn."',22,".$idrun.") as fas_routines_process_sn_t
										 inner join fas_routines_steps
										on fas_routines_steps.idstep = fas_routines_process_sn_t.idstep
										inner join fas_step
										on fas_step.instance = fas_routines_steps.instance 

										inner join fas_script_type
									  on fas_script_type.idscripttype  = fas_routines_process_sn_t.idscript
								 
									  inner join fas_outcome_integral
									  on fas_outcome_integral.reference = fas_routines_process_sn_t.iduniqueop  and
										  fas_routines_process_sn_t.iduniqueop			= 	fas_outcome_integral.reference
									  inner join fas_outcome_category_type
									  on  fas_outcome_category_type.idfasoutcomecat	=	fas_outcome_integral.idfasoutcomecat and
										  fas_outcome_category_type.idtype			=	fas_outcome_integral.idtype
									  
									  inner join fnt_select_maxidrun_fas_outcome_integral_byidscrip_byidrun ('".$unitsn."',22,".$idrun.") as maxidrun
									  on maxidrun.reference =  fas_routines_process_sn_t.idruninfodb
									  where  fas_outcome_integral.idfasoutcomecat in(3,5)
							
									 
									  group by fas_step.description, fas_outcome_integral.idfasoutcomecat ,  fas_outcome_integral.idtype  , fasoutcometypename
									  		";

}

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
			
			if ($rowhead['idfasoutcomecat'] == 3 && $rowhead['idtype']==0 &&  $rowhead['namestep']=="AcceptBBU_Check_PowerStress")
			{
				///Voltage Read ELOAD:
			    $lblname_voltread = $rowhead['fasoutcometypename']; 
				$values_pacurrent_voltread = 	$values_pacurrent_voltread.substr($rowhead['arrayvalue'],1,-1).","; 					
				$label_pacurrent_voltread = 	$label_pacurrent_voltread.substr($rowhead['arraylabel'],1,-1); 	
				
			 
			}
			if ($rowhead['idfasoutcomecat'] == 5 && $rowhead['idtype']==0)
			{
			    ////Voltage Read FIP485:
				$values_pacurrent_voltreadFIP485 = 	$values_pacurrent_voltreadFIP485.substr($rowhead['arrayvalue'],1,-1).",";
			 
			}
			if ($rowhead['idfasoutcomecat'] == 3 && $rowhead['idtype']==1 &&  $rowhead['namestep']=="AcceptBBU_Check_PowerStress")
			{
			    //Current Read ELOAD
				$values_pacurrent_read = 	$values_pacurrent_read.substr($rowhead['arrayvalue'],1,-1).","; 					
				$label_pacurrent_read = 	$label_pacurrent_read.substr($rowhead['arraylabel'],1,-1); 
			}
			if ($rowhead['idfasoutcomecat'] == 5 && $rowhead['idtype']==31 )
			{
			    //Main Current Sensor Read:
				$values_pacurrent_readcurrentsendor = 	$values_pacurrent_readcurrentsendor.substr($rowhead['arrayvalue'],1,-1).","; 					
				
			}
			if ($rowhead['idfasoutcomecat'] == 3 && $rowhead['idtype']==7)
			{
			    
				$values_pacurrent_pwr = 	$values_pacurrent_pwr.substr($rowhead['arrayvalue'],1,-1).","; 					
				$label_pacurrent_pwr = 	$label_pacurrent_pwr.substr($rowhead['arraylabel'],1,-1); 
			}
			
	

	}
	

	 
//////////////////////// FIN    //////////////////////////////////
//echo(json_encode(["label_pacurrent_0_0"=>$label_pacurrent_0_0,"label_level_0_0"=>$label_level_0_0,"label_temp_0_0"=>$label_temp_0_0, "lblname_0_0"=>$lblname_0_0,"lblname_0_1"=>$lblname_0_1,"lblname_1_0"=>$lblname_1_0,"lblname_1_1"=>$lblname_1_1,"values_pacurrent_0_0"=>$values_pacurrent_0_0,"values_pacurrent_0_1"=>$values_pacurrent_0_1,"values_pacurrent_1_0"=>$values_pacurrent_1_0,"values_pacurrent_1_1"=>$values_pacurrent_1_1,"values_temp_0_0"=>$values_temp_0_0,"values_temp_0_1"=>$values_temp_0_1,"values_temp_1_0"=>$values_temp_1_0,"values_temp_1_1"=>$values_temp_1_1,"values_level_0_0"=>$values_level_0_0,"values_level_0_1"=>$values_level_0_1,"values_level_1_0"=>$values_level_1_0,"values_level_1_1"=>$values_level_1_1 ]));
echo(json_encode(["values_pacurrent_voltreadFIP485"=>$values_pacurrent_voltreadFIP485,"values_pacurrent_readcurrentsendor"=>$values_pacurrent_readcurrentsendor,"label_pacurrent_pwr"=>$label_pacurrent_pwr,"values_pacurrent_pwr"=>$values_pacurrent_pwr,"values_pacurrent_voltread"=>$values_pacurrent_voltread,"label_pacurrent_voltread"=>$label_pacurrent_voltread,"lblname_voltread"=>$lblname_voltread,"label_pacurrent_read"=>$label_pacurrent_read,"values_pacurrent_read"=>$values_pacurrent_read ]));
 
?>

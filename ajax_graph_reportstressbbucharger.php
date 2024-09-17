<?php
error_reporting(0);
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

    include("db_conect.php"); 
  
		header('Content-Type: application/json');

		 
		$unitsn =$_REQUEST['unitsn'];	
		$idrun =$_REQUEST['idrun'];	
		
		////////////////////////    //////////////////////////////////


$sqlmmhead=" 
select  fas_outcome_integral.idfasoutcomecat ,  fas_outcome_integral.idtype  , fasoutcometypename , ARRAY_AGG (    fas_outcome_integral.v_double order by fas_outcome_integral.id_outcome  asc  ) as arrayvalue 	
, ARRAY_AGG ( to_char(fas_outcome_integral.datetimeref, 'HH24:MI:SS') order by fas_outcome_integral.id_outcome asc ) AS arraylabel 

	from fas_routines_process_sn as fas_routines_process_sn_t
	 
		inner join fas_script_type
	  on fas_script_type.idscripttype  = fas_routines_process_sn_t.idscript

	  inner join fas_outcome_integral
	  on fas_outcome_integral.reference = fas_routines_process_sn_t.iduniqueop  and
		  fas_routines_process_sn_t.iduniqueop			= 	fas_outcome_integral.reference
	  inner join fas_outcome_category_type
	  on  fas_outcome_category_type.idfasoutcomecat	=	fas_outcome_integral.idfasoutcomecat and
		  fas_outcome_category_type.idtype			=	fas_outcome_integral.idtype
	  
 
	  where  fas_outcome_integral.idfasoutcomecat in(2,3,5)
	 
	 and fas_routines_process_sn_t.sn = '".$unitsn."'
	 and 									 	 fas_routines_process_sn_t.idruninfodb = ".$idrun."
	  group by fas_outcome_integral.idfasoutcomecat ,  fas_outcome_integral.idtype  , fasoutcometypename
									  		";
////////////////////// FinalCheck_Measures_IMD
 

 $i_0_0 = 0;
 $i_0_1 = 0;
 $i_1_0 = 0;
 $i_1_1 = 0;

 
 
$tem="orange";
$dataheadr = $connect->query($sqlmmhead)->fetchAll();
foreach ($dataheadr as $rowhead) 
	{
			
			if ($rowhead['idfasoutcomecat'] == 2 && $rowhead['idtype']==0)
			{	
				$volt_reference  = substr($rowhead['arrayvalue'],1,-1);
			}
			if ($rowhead['idfasoutcomecat'] == 2 && $rowhead['idtype']==6)
			{	
				$volt_lower_limit = substr($rowhead['arrayvalue'],1,-1);
			}
			if ($rowhead['idfasoutcomecat'] == 2 && $rowhead['idtype']==7)
			{	
				$volt_upeer_limit  = substr($rowhead['arrayvalue'],1,-1);
			}
			if ($rowhead['idfasoutcomecat'] == 3 && $rowhead['idtype']==0)
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
			if ($rowhead['idfasoutcomecat'] == 3 && $rowhead['idtype']==1)
			{
			    //Current Read ELOAD
				$values_pacurrent_read = 	$values_pacurrent_read.substr($rowhead['arrayvalue'],1,-1).","; 					
				$label_pacurrent_read = 	$label_pacurrent_read.substr($rowhead['arraylabel'],1,-1); 
			}
			if ($rowhead['idfasoutcomecat'] == 5 && $rowhead['idtype']==31)
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
	

	$volt_upeer_limit_a = $volt_reference  + $volt_upeer_limit;
	$volt_lower_limit_b = $volt_reference  - $volt_lower_limit;
//////////////////////// FIN    //////////////////////////////////
//echo(json_encode(["label_pacurrent_0_0"=>$label_pacurrent_0_0,"label_level_0_0"=>$label_level_0_0,"label_temp_0_0"=>$label_temp_0_0, "lblname_0_0"=>$lblname_0_0,"lblname_0_1"=>$lblname_0_1,"lblname_1_0"=>$lblname_1_0,"lblname_1_1"=>$lblname_1_1,"values_pacurrent_0_0"=>$values_pacurrent_0_0,"values_pacurrent_0_1"=>$values_pacurrent_0_1,"values_pacurrent_1_0"=>$values_pacurrent_1_0,"values_pacurrent_1_1"=>$values_pacurrent_1_1,"values_temp_0_0"=>$values_temp_0_0,"values_temp_0_1"=>$values_temp_0_1,"values_temp_1_0"=>$values_temp_1_0,"values_temp_1_1"=>$values_temp_1_1,"values_level_0_0"=>$values_level_0_0,"values_level_0_1"=>$values_level_0_1,"values_level_1_0"=>$values_level_1_0,"values_level_1_1"=>$values_level_1_1 ]));
echo(json_encode(["volt_upeer_limit"=>$volt_upeer_limit_a,"volt_lower_limit"=>$volt_lower_limit_b, "values_pacurrent_voltreadFIP485"=>$values_pacurrent_voltreadFIP485,"values_pacurrent_readcurrentsendor"=>$values_pacurrent_readcurrentsendor,"label_pacurrent_pwr"=>$label_pacurrent_pwr,"values_pacurrent_pwr"=>$values_pacurrent_pwr,"values_pacurrent_voltread"=>$values_pacurrent_voltread,"label_pacurrent_voltread"=>$label_pacurrent_voltread,"lblname_voltread"=>$lblname_voltread,"label_pacurrent_read"=>$label_pacurrent_read,"values_pacurrent_read"=>$values_pacurrent_read ]));
 
?>

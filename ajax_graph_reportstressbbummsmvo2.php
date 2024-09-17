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
			select nameoutcomesub , fasoutcometypename ,
			fas_outcome_integral.idfasoutcomecat ,  
			fas_outcome_integral.idtype  , 0 as idxmeasure ,
			fasoutcometypename , 
			ARRAY_AGG (    fas_outcome_integral.v_double order by fas_outcome_integral.id_outcome  asc  ) as arrayvalue , 
			ARRAY_AGG ( to_char(fas_outcome_integral.datetimeref, 'HH24:MI:SS') order by fas_outcome_integral.id_outcome asc ) AS arraylabel 


			 
			   from fas_outcome_integral
				inner join 
				(
						select  id_outcome, fasoutcometypename as nameoutcomesub
						from fas_outcome_integral
						inner join fas_outcome_category_type
						on fas_outcome_category_type.idfasoutcomecat	=	fas_outcome_integral.idfasoutcomecat and 
						fas_outcome_category_type.idtype				=	fas_outcome_integral.idtype
						where reference in 
						(

						 select id_outcome from fas_outcome_integral
						 where reference in 
						 (
							 select id_outcome from fas_outcome_integral
							 where reference in 
								 (
								 select id_outcome  
								 from fas_outcome_integral 
								 where reference in
										 ( select reference  
										   from fnt_select_maxidrun_fas_outcome_integral_byidscrip('".$unitsn."',62) as maxidrun
										 )
								 and idfasoutcomecat = 0 and idtype = 23
								 ) and v_bigint in 
												(
													select  iduniqueop
													from fnt_select_allfas_routines_process_sn_maxrev('".$unitsn."') as routmaxrun
													inner join fas_routines_steps
													on fas_routines_steps.idstep = routmaxrun.idstep
													inner join fas_step
													on fas_step.instance = fas_routines_steps.instance and
													fas_step.instance = '10811A'
													where  idruninfodb in (
																			select reference 
																			from fnt_select_maxidrun_fas_outcome_integral_byidscrip('".$unitsn."' ,62)
																		) 
												)
						 )	and idfasoutcomecat = 0 and idtype = 27
							)
							 
					) as losidoutcomesub2847 
					on losidoutcomesub2847.id_outcome = fas_outcome_integral.reference
				
	 
		inner join fas_outcome_category_type
		on fas_outcome_category_type.idfasoutcomecat	=	fas_outcome_integral.idfasoutcomecat and 
		fas_outcome_category_type.idtype				=	fas_outcome_integral.idtype
		where  fas_outcome_integral.idfasoutcomecat in(11,5,3) and
		fas_outcome_integral.idtype in (202,201,200,207,0,203,204,101,102,140,141,0,7)
		group by fas_outcome_integral.idfasoutcomecat ,  fas_outcome_integral.idtype  , fasoutcometypename, nameoutcomesub
		union 
			select nameoutcomesub , fasoutcometypename ,
			fas_outcome_integral.idfasoutcomecat ,  
			fas_outcome_integral.idtype  , idxmeasure , 
			fasoutcometypename , 
			ARRAY_AGG (    fas_outcome_integral.v_double order by fas_outcome_integral.id_outcome  asc  ) as arrayvalue , 
			ARRAY_AGG ( to_char(fas_outcome_integral.datetimeref, 'HH24:MI:SS') order by fas_outcome_integral.id_outcome asc ) AS arraylabel 


			 
			   from fas_outcome_integral
				inner join 
				(
						select  id_outcome, fasoutcometypename as nameoutcomesub, v_integer as idxmeasure
		 
						from fas_outcome_integral
						inner join fas_outcome_category_type
						on fas_outcome_category_type.idfasoutcomecat	=	fas_outcome_integral.idfasoutcomecat and 
						fas_outcome_category_type.idtype				=	fas_outcome_integral.idtype
						where reference in 
						(

						 select id_outcome from fas_outcome_integral
						 where reference in 
						 (
							 select id_outcome from fas_outcome_integral
							 where reference in 
								 (
								 select id_outcome  
								 from fas_outcome_integral 
								 where reference in
										 ( select reference  
										   from fnt_select_maxidrun_fas_outcome_integral_byidscrip('".$unitsn."',62) as maxidrun
										 )
								 and idfasoutcomecat = 0 and idtype = 23
								 ) and v_bigint in 
												(
													select  iduniqueop
													from fnt_select_allfas_routines_process_sn_maxrev('".$unitsn."') as routmaxrun
													inner join fas_routines_steps
													on fas_routines_steps.idstep = routmaxrun.idstep
													inner join fas_step
													on fas_step.instance = fas_routines_steps.instance and
													fas_step.instance = '10811A'
													where  idruninfodb in (
																			select reference 
																			from fnt_select_maxidrun_fas_outcome_integral_byidscrip('".$unitsn."' ,62)
																		) 
												)
						 )	and idfasoutcomecat = 0 and idtype = 27
							)
							 
					) as losidoutcomesub2847 
					on losidoutcomesub2847.id_outcome = fas_outcome_integral.reference
				
	 
		inner join fas_outcome_category_type
		on fas_outcome_category_type.idfasoutcomecat	=	fas_outcome_integral.idfasoutcomecat and 
		fas_outcome_category_type.idtype				=	fas_outcome_integral.idtype
		where  fas_outcome_integral.idfasoutcomecat in(3) and
		fas_outcome_integral.idtype in (1,0)
		group by fas_outcome_integral.idfasoutcomecat ,  fas_outcome_integral.idtype  , fasoutcometypename, 
		nameoutcomesub, idxmeasure
		";
		
		
		}
		else
		{ 
		$sqlmmhead="  		  		";
		
		}
		
////echo $sqlmmhead;
////////////////////// FinalCheck_Measures_IMD

 $i_0_0 = 0;
 $i_0_1 = 0;
 $i_1_0 = 0;
 $i_1_1 = 0;

 
 
$tem="orange";
$dataheadr = $connect20->query($sqlmmhead)->fetchAll();
foreach ($dataheadr as $rowhead) 
	{
	//	values_System_vload1
	
			//if ($rowhead['idfasoutcomecat'] == 5 && $rowhead['idtype']==0)  y 138 Battery Charger - Current

			if ($rowhead['idfasoutcomecat'] == 3 && $rowhead['idtype']==7)
			{
			    
				$values_pacurrent_pwr = 	$values_pacurrent_pwr.substr($rowhead['arrayvalue'],1,-1).","; 					
				$label_pacurrent_pwr = 	$label_pacurrent_pwr.substr($rowhead['arraylabel'],1,-1); 
			}

			if ($rowhead['idfasoutcomecat'] == 3 && $rowhead['idtype']==0 && $rowhead['idxmeasure']==0)
			{
			    ////values_System_Voltage:
				$values_System_vload1 = 	$values_System_vload1.substr($rowhead['arrayvalue'],1,-1).",";
				
			}

			if ($rowhead['idfasoutcomecat'] == 3 && $rowhead['idtype']==0 && $rowhead['idxmeasure']==1)
			{
			    ////values_System_Voltage:
				
				$values_System_vload2 = 	$values_System_vload2.substr($rowhead['arrayvalue'],1,-1).",";			 
			}

			if ($rowhead['idfasoutcomecat'] == 3 && $rowhead['idtype']==1  && $rowhead['idxmeasure']==0)
			{			   
				$values_CurrentComsum_ieload = 	$values_CurrentComsum_ieload.substr($rowhead['arrayvalue'],1,-1).",";			 
			}
			if ($rowhead['idfasoutcomecat'] == 3 && $rowhead['idtype']==1  && $rowhead['idxmeasure']==1)
			{			   
				$values_CurrentComsum_ieload2 = 	$values_CurrentComsum_ieload2.substr($rowhead['arrayvalue'],1,-1).",";			 
			}


			if ($rowhead['idfasoutcomecat'] == 11 && $rowhead['idtype']==202)
			{
			    ////values_System_Voltage:
				$values_System_Voltage_vsys = 	$values_System_Voltage_vsys.substr($rowhead['arrayvalue'],1,-1).",";
				$label_system_volt = 	$label_system_volt.substr($rowhead['arraylabel'],1,-1); 	
			 
			}
			if ($rowhead['idfasoutcomecat'] == 11 && $rowhead['idtype']==201)
			{
			    ////values_System_Voltage:
				$values_System_Voltage_vin = 	$values_System_Voltage_vin.substr($rowhead['arrayvalue'],1,-1).",";
			 
			}


			if ($rowhead['idfasoutcomecat'] == 11 && $rowhead['idtype']==207)
			{
			  
				$values_Battery_Voltage_vbank = 	$values_Battery_Voltage_vbank.substr($rowhead['arrayvalue'],1,-1).",";
			 
			}
			if ($rowhead['idfasoutcomecat'] == 11 && $rowhead['idtype']==200)
			{
			    
				$values_Battery_Voltage_vbat = 	$values_Battery_Voltage_vbat.substr($rowhead['arrayvalue'],1,-1).",";
			 
			}
			if ($rowhead['idfasoutcomecat'] == 3 && $rowhead['idtype']==0)
			{
			     
				$values_Battery_Voltage_veload = 	$values_Battery_Voltage_veload.substr($rowhead['arrayvalue'],1,-1).",";
			 
			}
		
			if ($rowhead['idfasoutcomecat'] == 11 && $rowhead['idtype']==203)
			{			   
				$values_CurrentComsum_ibat = 	$values_CurrentComsum_ibat.substr($rowhead['arrayvalue'],1,-1).",";			 
			}
			if ($rowhead['idfasoutcomecat'] == 11 && $rowhead['idtype']==204)
			{			   
				$values_CurrentComsum_iin = 	$values_CurrentComsum_iin.substr($rowhead['arrayvalue'],1,-1).",";			 
			}
		
			 
			if ($rowhead['idfasoutcomecat'] == 11 && $rowhead['idtype']==140)
			{			   
				$values_individual_batt_volt_vbat1 = 	$values_individual_batt_volt_vbat1.substr($rowhead['arrayvalue'],1,-1).",";			 
			}
			if ($rowhead['idfasoutcomecat'] == 11 && $rowhead['idtype']==141)
			{			   
				$values_individual_batt_volt_vbat2 = 	$values_individual_batt_volt_vbat2.substr($rowhead['arrayvalue'],1,-1).",";			 
			}
 
			
	

	}
	

	 
//////////////////////// FIN    //////////////////////////////////
//echo(json_encode(["label_pacurrent_0_0"=>$label_pacurrent_0_0,"label_level_0_0"=>$label_level_0_0,"label_temp_0_0"=>$label_temp_0_0, "lblname_0_0"=>$lblname_0_0,"lblname_0_1"=>$lblname_0_1,"lblname_1_0"=>$lblname_1_0,"lblname_1_1"=>$lblname_1_1,"values_pacurrent_0_0"=>$values_pacurrent_0_0,"values_pacurrent_0_1"=>$values_pacurrent_0_1,"values_pacurrent_1_0"=>$values_pacurrent_1_0,"values_pacurrent_1_1"=>$values_pacurrent_1_1,"values_temp_0_0"=>$values_temp_0_0,"values_temp_0_1"=>$values_temp_0_1,"values_temp_1_0"=>$values_temp_1_0,"values_temp_1_1"=>$values_temp_1_1,"values_level_0_0"=>$values_level_0_0,"values_level_0_1"=>$values_level_0_1,"values_level_1_0"=>$values_level_1_0,"values_level_1_1"=>$values_level_1_1 ]));
echo(json_encode(["label_pacurrent_pwr"=>$label_pacurrent_pwr,"values_pacurrent_pwr"=>$values_pacurrent_pwr,"values_System_vload2"=>$values_System_vload2,"values_System_vload1"=>$values_System_vload1,"label_system_volt"=>$label_system_volt,"values_System_Voltage_vsys"=>$values_System_Voltage_vsys,"values_System_Voltage_vin"=>$values_System_Voltage_vin,"values_Battery_Voltage_vbank"=>$values_Battery_Voltage_vbank,"values_Battery_Voltage_vbat"=>$values_Battery_Voltage_vbat,"values_Battery_Voltage_veload"=>$values_Battery_Voltage_veload,"values_CurrentComsum_ibat"=>$values_CurrentComsum_ibat,"values_CurrentComsum_iin"=>$values_CurrentComsum_iin,"values_CurrentComsum_ieload"=>$values_CurrentComsum_ieload,"values_CurrentComsum_ieload2"=>$values_CurrentComsum_ieload2,"values_individual_batt_volt_vbat1"=>$values_individual_batt_volt_vbat1,"values_individual_batt_volt_vbat2"=>$values_individual_batt_volt_vbat2 ]));
 
?>

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
			fas_outcome_integral.idtype  , 
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
						   from fnt_select_maxidrun_fas_outcome_integral_byidscrip('".$unitsn."',53) as maxidrun
						 )
				 and idfasoutcomecat = 0 and idtype = 23
				 ) and v_bigint in 
				 				(	
									select min ( iduniqueop )
									from fnt_select_allfas_routines_process_sn_maxrev('".$unitsn."') as routmaxrun
									inner join fas_routines_steps
									on fas_routines_steps.idstep = routmaxrun.idstep
									inner join fas_step
									on fas_step.instance = fas_routines_steps.instance and
									fas_step.instance = '107'
									where  idruninfodb in (
															select reference 
															from fnt_select_maxidrun_fas_outcome_integral_byidscrip('".$unitsn."' ,53)
														) 
								)
		 )	and idfasoutcomecat = 0 and idtype = 27
		
		) 
		) as losidoutcomesub 
		on losidoutcomesub.id_outcome = fas_outcome_integral.reference
		inner join fas_outcome_category_type
		on fas_outcome_category_type.idfasoutcomecat	=	fas_outcome_integral.idfasoutcomecat and 
		fas_outcome_category_type.idtype				=	fas_outcome_integral.idtype
		
		group by fas_outcome_integral.idfasoutcomecat ,  fas_outcome_integral.idtype  , fasoutcometypename, nameoutcomesub
		";
		
		
		}
		else
		{ 
		$sqlmmhead="  		  		";
		$sqlmmhead=" 
			select nameoutcomesub , fasoutcometypename ,
			fas_outcome_integral.idfasoutcomecat ,  
			fas_outcome_integral.idtype  , 
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
						   from fnt_select_maxidrun_fas_outcome_integral_byidscrip('".$unitsn."',53) as maxidrun
						 )
				 and idfasoutcomecat = 0 and idtype = 23
				 ) and v_bigint in 
				 				(	
									select min ( iduniqueop )
									from fnt_select_allfas_routines_process_sn_maxrev('".$unitsn."') as routmaxrun
									inner join fas_routines_steps
									on fas_routines_steps.idstep = routmaxrun.idstep
									inner join fas_step
									on fas_step.instance = fas_routines_steps.instance and
									fas_step.instance = '107'
									where  idruninfodb in (
															select reference 
															from fnt_select_maxidrun_fas_outcome_integral_byidscrip('".$unitsn."' ,53)
														) 
								)
		 )	and idfasoutcomecat = 0 and idtype = 27
		
		) 
		) as losidoutcomesub 
		on losidoutcomesub.id_outcome = fas_outcome_integral.reference
		inner join fas_outcome_category_type
		on fas_outcome_category_type.idfasoutcomecat	=	fas_outcome_integral.idfasoutcomecat and 
		fas_outcome_category_type.idtype				=	fas_outcome_integral.idtype
		
		group by fas_outcome_integral.idfasoutcomecat ,  fas_outcome_integral.idtype  , fasoutcometypename, nameoutcomesub
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
			
			if ($rowhead['idfasoutcomecat'] == 3 && $rowhead['idtype']==0)
			{
				///Voltage Read ELOAD:
			    $lblname_voltread = $rowhead['fasoutcometypename']; 
				$values_pacurrent_voltread = 	$values_pacurrent_voltread.substr($rowhead['arrayvalue'],1,-1).","; 					
				$label_pacurrent_voltread = 	$label_pacurrent_voltread.substr($rowhead['arraylabel'],1,-1); 	
				
			 
			}
			//if ($rowhead['idfasoutcomecat'] == 5 && $rowhead['idtype']==0)  y 138 Battery Charger - Current
			if ($rowhead['idfasoutcomecat'] == 11 && $rowhead['idtype']==137)
			{
			    ////values_System_Voltage:
				$values_System_Voltage = 	$values_System_Voltage.substr($rowhead['arrayvalue'],1,-1).",";
			 
			}

			if ($rowhead['idfasoutcomecat'] == 11 && $rowhead['idtype']==140)
			{
			  
				$values_Battery_Voltage_1 = 	$values_Battery_Voltage_1.substr($rowhead['arrayvalue'],1,-1).",";
			 
			}
			if ($rowhead['idfasoutcomecat'] == 11 && $rowhead['idtype']==141)
			{
			    
				$values_Battery_Voltage_2 = 	$values_Battery_Voltage_2.substr($rowhead['arrayvalue'],1,-1).",";
			 
			}
			if ($rowhead['idfasoutcomecat'] == 11 && $rowhead['idtype']==142)
			{
			     
				$values_Battery_Voltage_3 = 	$values_Battery_Voltage_3.substr($rowhead['arrayvalue'],1,-1).",";
			 
			}
			if ($rowhead['idfasoutcomecat'] == 11 && $rowhead['idtype']==143)
			{
			   
				$values_Battery_Voltage_4 = 	$values_Battery_Voltage_4.substr($rowhead['arrayvalue'],1,-1).",";
			 
			}

			 

			if ($rowhead['idfasoutcomecat'] == 3 && $rowhead['idtype']==1)
			{
			    //Current Read ELOAD
				$values_pacurrent_read = 	$values_pacurrent_read.substr($rowhead['arrayvalue'],1,-1).","; 					
				$label_pacurrent_read = 	$label_pacurrent_read.substr($rowhead['arraylabel'],1,-1); 
			}
			///if ($rowhead['idfasoutcomecat'] == 5 && $rowhead['idtype']==31)
			if ($rowhead['idfasoutcomecat'] == 11 && $rowhead['idtype']==139)
			{
			    
				$values_Battery_Current_Sensor_Current = 	$values_Battery_Current_Sensor_Current.substr($rowhead['arrayvalue'],1,-1).","; 					
				
			}
			if ($rowhead['idfasoutcomecat'] == 11 && $rowhead['idtype']==138)
			{
			     
				$values_Battery_Charger_Current = 	$values_Battery_Charger_Current.substr($rowhead['arrayvalue'],1,-1).","; 					
				
			}
			if ($rowhead['idfasoutcomecat'] == 3 && $rowhead['idtype']==7)
			{
			    
				$values_pacurrent_pwr = 	$values_pacurrent_pwr.substr($rowhead['arrayvalue'],1,-1).","; 					
				$label_pacurrent_pwr = 	$label_pacurrent_pwr.substr($rowhead['arraylabel'],1,-1); 
			}
			
	

	}
	

	 
//////////////////////// FIN    //////////////////////////////////
//echo(json_encode(["label_pacurrent_0_0"=>$label_pacurrent_0_0,"label_level_0_0"=>$label_level_0_0,"label_temp_0_0"=>$label_temp_0_0, "lblname_0_0"=>$lblname_0_0,"lblname_0_1"=>$lblname_0_1,"lblname_1_0"=>$lblname_1_0,"lblname_1_1"=>$lblname_1_1,"values_pacurrent_0_0"=>$values_pacurrent_0_0,"values_pacurrent_0_1"=>$values_pacurrent_0_1,"values_pacurrent_1_0"=>$values_pacurrent_1_0,"values_pacurrent_1_1"=>$values_pacurrent_1_1,"values_temp_0_0"=>$values_temp_0_0,"values_temp_0_1"=>$values_temp_0_1,"values_temp_1_0"=>$values_temp_1_0,"values_temp_1_1"=>$values_temp_1_1,"values_level_0_0"=>$values_level_0_0,"values_level_0_1"=>$values_level_0_1,"values_level_1_0"=>$values_level_1_0,"values_level_1_1"=>$values_level_1_1 ]));
echo(json_encode(["values_Battery_Charger_Current"=>$values_Battery_Charger_Current,"values_Battery_Current_Sensor_Current"=>$values_Battery_Current_Sensor_Current,"values_System_Voltage"=>$values_System_Voltage,"values_Battery_Voltage_1"=>$values_Battery_Voltage_1,"values_Battery_Voltage_2"=>$values_Battery_Voltage_2,"values_Battery_Voltage_3"=>$values_Battery_Voltage_3,"values_Battery_Voltage_4"=>$values_Battery_Voltage_4,"values_pacurrent_readcurrentsendor"=>$values_pacurrent_readcurrentsendor,"label_pacurrent_pwr"=>$label_pacurrent_pwr,"values_pacurrent_pwr"=>$values_pacurrent_pwr,"values_pacurrent_voltread"=>$values_pacurrent_voltread,"label_pacurrent_voltread"=>$label_pacurrent_voltread,"lblname_voltread"=>$lblname_voltread,"label_pacurrent_read"=>$label_pacurrent_read,"values_pacurrent_read"=>$values_pacurrent_read ]));
 
?>
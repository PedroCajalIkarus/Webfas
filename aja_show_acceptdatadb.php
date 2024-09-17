<?php
// Desactivar toda notificación de error
error_reporting(0);
// Notificar todos los errores de PHP (ver el registro de cambios)
//error_reporting(E_ALL);

 include("db_conect.php"); 
	include("funcionesstores.php"); 
	header('Content-Type: application/json');
	$query_lista = list_accept_db_data($_REQUEST['tipodb'] ,$_REQUEST['ciu'] ,$_REQUEST['sn']);
    $return_arr = array();
 // 	echo $query_lista;				
	$data = $connect->query($query_lista)->fetchAll();						
	$letrasbuscadas = array("/", ".", ",", "-", );

$Iteracion = 1;

	foreach ($data as $row) {
		$rowciu_sincaractraros = str_replace($letrasbuscadas, "", $row[0]);
		
		////$_REQUEST['tipodb'] == 3  === ACF
		if ($_REQUEST['tipodb'] == 3)
		{
			if(  $row['totalpass'] =="false" ) {
				$v_totalpass_pa = $row['totalpass'];}
			else
			{
			if(  $row['totalpass'] =="true" ){
				$v_totalpass_pa= $row['totalpass']; 
				} 
			else { 
				$v_totalpass_pa ="";
				}
			}				
				//if( $row['totalpass']!="true" )  { $v_totalpass_pa ="";} else { $v_totalpass_pa = $row['totalpass'];}
				if( $row['fasver2']=="null") { $v_fasversion_pa ="";} else { $v_fasversion_pa = $row['fasversion'];}
				if(is_null(  $row['totaltime'] ) || $row['totaltime']=="null") { $v_timescript_pa ="UnKonown";} else { $v_timescript_pa = $row['totaltime'];}
				
				$v_referencefreq= explode(" ", $row['referencefreq']); 
				$v_referencegain = $row['referencegain'];
				
				$v_setciuparameterspass  = $row['setciuparameterspass'];
				$v_tunefiltercalibrationpass = $row['tunefiltercalibrationpass'];
				$v_addetectorpass = $row['addetectorpass'];
				$v_inbandgainpass  = $row['inbandgainpass'];
				$v_outofchannelgainpass = $row['outofchannelgainpass'];
				$v_channelripplepass  = $row['channelripplepass'];
				$v_maxpoweroverloadpass  = $row['maxpoweroverloadpass'];
				$v_alarmtotalpass  = $row['alarmtotalpass']; 
				
				$v_gainripple  = explode(" ",$row['gainripple']); 
				$v_tunefiltercalibration  = explode(" ", $row['tunefiltercalibration']); 
				$v_outofchannelgain  = explode(" ",$row['outofchannelgain']); 
				$v_channelripple   = explode(" ",$row['channelripple']); 
				$v_maxoutpower   = explode(" ",$row['maxoutpower']); 
				$v_addetectorin   = explode(" ",$row['addetectorin']);  
				$v_addetectorout  = explode(" ",$row['addetectorout']); 
				
				
			
				$v_alarmpass =  explode(" ",$row['alarmpass']);  
					
				
				$v_alarmledspass =  explode(" ",$row['alarmledspass']);  
   
				$lblarrayrefer=  ( $v_referencefreq[0]=="null" ? " " : $v_referencefreq[0]."")." - ". ( $v_referencefreq[2]=="null" ? " " : $v_referencefreq[2]." MHz");
				$lblGainRipple=  $v_gainripple[1]." dB (< ".$v_gainripple[0]." dB)";
				$valorcal = ( $v_maxoutpower[1] -  $v_maxoutpower[0]/2);
					$return_arr[] = array(
                    "idit" => "Iteracion: ".$Iteracion,					
					"Date" => $row['dateacf'],
					"timescript" => $v_timescript_pa , 
					"userinfo" => $row['userruninfo'],
					"station" => $row['station'],
					"fasversion" => $v_fasversion_pa, 
					"espaciototalpass" => " ",
					"fw" =>   ( $row['fw']=="null" ? " " : $row['fw']),  
					"freqst" => $lblarrayrefer,
					"referencegain" =>   ( $v_referencegain=="null" ? " " : $v_referencegain. " dB "),  
					"freqwespacioaa" => " ",					
					"setciuparameterspass" =>  ( $v_setciuparameterspass=="null" ? " " : $v_setciuparameterspass),  
					"tunefiltercalibrationpass" =>  ( $row['tunefiltercalibrationpass']=="null" ? " " : $row['tunefiltercalibrationpass']),  
				    "addetectorpass" =>  ( $row['addetectorpass']=="null" ? " " : $row['addetectorpass']),  
					"inbandgainpass"  =>  ( $row['inbandgainpass']=="null" ? " " : $row['inbandgainpass']),  
					"outofchannelgainpass" => ( $row['outofchannelgainpass']=="null" ? " " : $row['outofchannelgainpass']),  
					"channelripplepass"  => ( $row['channelripplepass']=="null" ? " " : $row['channelripplepass']),  
					"maxpoweroverloadpass"  =>  ( $row['maxpoweroverloadpass']=="null" ? " " : $row['maxpoweroverloadpass']),  
					"alarmtotalpass" =>  ( $row['alarmtotalpass']=="null" ? " " : $row['alarmtotalpass']),
						"totalpass" => ( $v_totalpass_pa=="null" ? " " : $v_totalpass_pa),  
					"espacioTuneFiltrerCalibration" => " ",					
					"GainRipple" => $lblGainRipple ,
					"espacioaagr1" => " ",					
					"OutOfChannelGainl" =>   $v_outofchannelgain[2]." Mhz - ".$v_outofchannelgain[3]." Mhz",
					"OutOfChannelGain" =>    $v_outofchannelgain[1]." dB (< ".$v_outofchannelgain[0]." dB)" ,				
					"ChannelRipple" =>    $v_channelripple[2]." Mhz - ".$v_channelripple[3]." Mhz", 
					"ChannelRipple2" =>   $v_channelripple[1]." dB (< ".$v_channelripple[0]." dB)" ,					
					"espacioMaxOutPower" => " ",
					"MaxOutPowermin" =>   ( $v_maxoutpower[3]=="null" ? " " : $v_maxoutpower[3]." Mhz"), 					
					"MaxOutPowermax" =>  ( $v_maxoutpower[2]=="null" ? " " : $v_maxoutpower[2]." dBm (- ".$valorcal."+/-".$valorcal." dBm)") ,
					"espacioMaxOutPower2" => " ",
					"alarmpaa1" =>  $v_alarmpass[0],
					"alarmpaa12" =>  $v_alarmpass[1],
					"alarmpaa13" =>  $v_alarmpass[2],
					"alarmpaa14" =>  $v_alarmpass[3],
					"alarmpaa15" =>  $v_alarmpass[4],
					"alarmpass1" => " ",	
					"alarmpass2" => " ",	
					"ledalarmpaa1" =>  $v_alarmledspass[0],
					"ledalarmpaa12" =>  $v_alarmledspass[1],
					"ledalarmpaa13" =>  $v_alarmledspass[2],
					"ledalarmpaa14" =>  $v_alarmledspass[3],
					"ledalarmpaa15" =>  $v_alarmledspass[4],
					"alarmpass2led" => " "
					
					);
					
					$temmfreq  = explode(" ", $row['freqmeasures']); ;
					$temmpgain  = explode(" ", $row['gainmeasures']); ;
					foreach($temmfreq as $i =>$keyaa) 		
					{
							if ($temmfreq[$i] <> "")
								{
							$return_arrgifreqgain[] = array(								
							    "freq" => $temmfreq[$i]." MHz ",
								"gain" =>$temmpgain[$i]." dB"													
							);
							}
					}
					
		}
		////$_REQUEST['tipodb'] == 2  === PA
		if ($_REQUEST['tipodb'] == 2)
		{
			if(  $row['totalpass'] =="false" ) {
			$v_totalpass_pa = $row['totalpass'];}
			else
			{
			if(  $row['totalpass'] =="true" ){
				$v_totalpass_pa= $row['totalpass']; 
				} 
			else { 
				$v_totalpass_pa ="";
				}
			}				
				//if( $row['totalpass']!="true" )  { $v_totalpass_pa ="";} else { $v_totalpass_pa = $row['totalpass'];}
				if( $row['fasver2']=="null") { $v_fasversion_pa ="";} else { $v_fasversion_pa = $row['fasver2'];}
				if(is_null(  $row['totaltime'] ) || $row['totaltime']=="null") { $v_timescript_pa ="UnKonown";} else { $v_timescript_pa = $row['totaltime'];}
								
				$v_gainpass0 =  explode(" ", $row['gainpass']);
				$v_imdpass = explode(" ", $row['imdpass']); 
				$v_currentpass = explode(" ", $row['currentpass']); 
				$v_linealitypass = $row['linealitypass'];				
				$v_retuned  = $row['retuned']; 
				
				if ($v_linealitypass=="null")
				{
					$v_linealitypass="-";
				}
				else
				{
					$v_linealitypass = $row['linealitypass'];	
				}
				
				if ($v_retuned=="null")
				{
					$v_retuned="-";
				}
				else
				{
					$v_retuned  = $row['retuned']; 
				}
				
				if ($v_imdpass[0]=="null")
				{
					$v_imdpass_0="-";
				}
				else
				{
					$v_imdpass_0=$v_imdpass[0];
				}
				
				if ($v_gainpass0[0]=="null")
				{
					$v_gainpass0_0="-";
				}
				else
				{
					$v_gainpass0_0=$v_gainpass0[0];
				}
				
				if ($v_currentpass[0]=="null")
				{
					$v_currentpass_0="-";
				}
				else
				{
					$v_currentpass_0=$v_currentpass[0];
				}
				
				
				if ($v_forcepass_pa=="null")
				{
					$v_forcepass_pa = "-";
				}
				else
				{
					$v_forcepass_pa = $row['forcedpass'];
				}
				
				$vreferences  = explode(" ", $row['references0']);  
				
				$vvfreq1  = explode(" ", $row['freq0']);  
				$vimd000  = explode(" ", $row['imd000']);  
				$vimd001  = explode(" ", $row['imd001']);  
				$vimd002  = explode(" ", $row['imd002']); 

				$v_power0  = explode(" ", $row['power0']); 	

				
				$pwr2vimd000  = explode(" ", $row['imd010']);  
				$pwr2vimd001  = explode(" ", $row['imd011']);  
				$pwr2vimd002  = explode(" ", $row['imd012']);				
				
				$v_refgain = explode(" ",$row['gain0']);
				$v_nfpa = explode(" ",$row['nfpa']);
				$v_current0 = explode(" ",$row['current0']);
				
				
				$return_arr[] = array(
                    "idit" => "Iteracion: ".$Iteracion,					
					"Date" => $row['date'],
					"timescript" => $v_timescript_pa , 
					"userinfo" => $row['userruninfo'],
					"station" => $row['station'],
					"fasversion" => $v_fasversion_pa, 
					"totalpass" =>  $v_totalpass_pa,
					"espacioaa" => " ",					
					"gainpass" => ($v_gainpass0_0=="null" ? " " : $v_gainpass0_0),
					"imdpass" => ($v_imdpass_0=="null" ? " " : $v_imdpass_0),
					"currentpass" => ($v_currentpass_0=="null" ? " " : $v_currentpass_0),										
					"retuned" => ($v_retuned=="null" ? " " : $v_retuned),
					"linealitypass" => ($v_linealitypass=="null" ? " " : $v_linealitypass),
					"forcedpass" => ($v_forcepass_pa=="null" ? " " : $v_forcepass_pa), 
					"espacio12" => " ",
					"espacio123" => " ",					
					"refGain" => ($vreferences[0]=="null" ? " " : $vreferences[0]),
					"refmaxpwr1" => ($vreferences[1]=="null" ? " " : $vreferences[1]),
					"refimd1" => ($vreferences[2]=="null" ? " " : $vreferences[2]),
					"refmaxpwr2" => "maxpwr2",
					"refimd2" => "imd2",					
					"refvolt" => "voltaj",		
					"refCurrent" => "Current",	
					"refespacio123" => " ",		
					"pwr0" => " ",							
					"pwrstan" => ($v_power0[0]=="null" ? " " : $v_power0[0]),
					"pwr1x" => ($v_power0[1]=="null" ? " " : $v_power0[1]),
					"pwr2x37" => ($v_power0[2]=="null" ? " " : $v_power0[2]),
					"pwr2x39" => ($v_power0[3]=="null" ? " " : $v_power0[3]),
					"refimd3espa" => " ",						
					"refimd3" => "2x37.0",
					"refimd3fstart" => ($vvfreq1[0]=="null" ? " " : $vvfreq1[0]),
					"p2imd1" => ($vimd000[0]=="null" ? " " : $vimd000[0]),
					"p2cent1" => ($vimd000[1]=="null" ? " " : $vimd000[1]),
					"p2cent2" => ($vimd000[2]=="null" ? " " : $vimd000[2]),
					"p2cent3" => ($vimd000[3]=="null" ? " " : $vimd000[3]),				
					"p3refimd3fstart" => ($vvfreq1[1]=="null" ? " " : $vvfreq1[1]),
					"p3imd1" => ($vimd001[0]=="null" ? " " : $vimd001[0]),
					"p3cent1" => ($vimd001[1]=="null" ? " " : $vimd001[1]),
					"p3cent2" => ($vimd001[2]=="null" ? " " : $vimd001[2]),
					"p3cent3" => ($vimd001[3]=="null" ? " " : $vimd001[3]),					
					"p4refimd3fstart" => ($vvfreq1[2]=="null" ? " " : $vvfreq1[2]),
					"p4imd1" =>  ($vimd002[0]=="null" ? " " : $vimd002[0]),
					"p4cent1" => ($vimd002[1]=="null" ? " " : $vimd002[1]),
					"p4cent2" => ($vimd002[2]=="null" ? " " : $vimd002[2]),
					"p4cent3" => ($vimd002[3]=="null" ? " " : $vimd002[3]),
					"pwr2refimd3" => "2x39.0",
					
					"pwr2refimd3fstart" => ($vvfreq1[0]=="null" ? " " : $vvfreq1[0]),
					"pwr2p2imd1" =>  ($pwr2vimd000[0]=="null" ? " " : $pwr2vimd000[0]),
					"pwr2p2cent1" => ($pwr2vimd000[1]=="null" ? " " : $pwr2vimd000[0]),
					"pwr2p2cent2" => ($pwr2vimd000[2]=="null" ? " " : $pwr2vimd000[0]),
					"pwr2p2cent3" => ($pwr2vimd000[3]=="null" ? " " : $pwr2vimd000[0]),				
					"pwr2p3refimd3fstart" => ($vvfreq1[1]=="null" ? " " : $vvfreq1[1]),
					"pwr2p3imd1" =>  ($pwr2vimd001[0]=="null" ? " " : $pwr2vimd001[0]),
					"pwr2p3cent1" => ($pwr2vimd001[1]=="null" ? " " : $pwr2vimd001[0]),
					"pwr2p3cent2" => ($pwr2vimd001[2]=="null" ? " " : $pwr2vimd001[0]),
					"pwr2p3cent3" => ($pwr2vimd001[3]=="null" ? " " : $pwr2vimd001[0]),
					"pwr2p4refimd3fstart" =>($vvfreq1[2]=="null" ? " " : $vvfreq1[2]),
					"pwr2p4imd1" =>  ($pwr2vimd002[0]=="null" ? " " : $pwr2vimd002[0]),
					"pwr2p4cent1" => ($pwr2vimd002[1]=="null" ? " " : $pwr2vimd002[1]),
					"pwr2p4cent2" => ($pwr2vimd002[2]=="null" ? " " : $pwr2vimd002[2]),
					"pwr2p4cent3" => ( $pwr2vimd002[3]=="null" ? " " : $pwr2vimd002[3]),
					"pwr2p4cent3esp" => "",
					"refgain0s" => "",
					"refgainfs" => ($v_refgain[0]=="null" ? " " : $v_refgain[0]),
					"refgainfc" => ($v_refgain[1]=="null" ? " " : $v_refgain[1]),
					"refgainfst" => ($v_refgain[2]=="null" ? " " : $v_refgain[2]),
					"refgain1s" => "",
					"refgain2s" => "",					
					"refvvfreq1fs" => ($vvfreq1[0]=="null" ? " " : $vvfreq1[0]),
					"refvvfreq1fc" => ($vvfreq1[1]=="null" ? " " : $vvfreq1[1]),
					"revvfreq1fst" => ($vvfreq1[2]=="null" ? " " : $vvfreq1[2]),
					"refvvfreq11s" => "",
					"refvvfreq12s" => "curre",
					"revnfcurre" =>  ($v_current0[0]=="null" ? " " : $v_current0[0]),
					"revnfcurre1" => ($v_current0[1]=="null" ? " " : $v_current0[1]),
					"revnfcurre2" => ($v_current0[2]=="null" ? " " : $v_current0[2]),
					"revnfcurre3" => ($v_current0[3]=="null" ? " " : $v_current0[3]),
					"refvvfreq11s2" => "",
					"revnfpa" =>  ($v_nfpa[0]=="null" ? " " : $v_nfpa[0]),
					"revnfpa1" => ($v_nfpa[1]=="null" ? " " : $v_nfpa[1]),
					"revnfpa2" => ($v_nfpa[2]=="null" ? " " : $v_nfpa[2]),
					"revnfpa3" => ($v_nfpa[3]=="null" ? " " : $v_nfpa[3]),
					"revnfpa4" => ($v_nfpa[4]=="null" ? " " : $v_nfpa[4])
								
                    );
		}	
		////$_REQUEST['tipodb'] == 1  === DIB
		if ($_REQUEST['tipodb'] == 1)
		{
			
			if( $row['totalpass']!="true" )  { $v_totalpass ="";} else { $v_totalpass = $row['totalpass'];}
			$v_totalpass =($row['totalpass']=="null" ? " " : $v_totalpass);
			
			if( $row['fasver2']=="null") { $v_fasversion ="";} else { $v_fasversion = $row['fasver2'];}
			if(is_null(  $row['totaltime'] ) || $row['totaltime']=="null") { $v_timescript ="";} else { $v_timescript = $row['totaltime'];}
			if(  $row['forcedpass'] !="true" ) {  $v_forcepass ="";} else { $v_forcepass = $row['forcedpass'];}
		
			if(is_null(  $row['rabbitip']  )) { $v_rabbitip ="";} else { $v_rabbitip = $row['rabbitip'];}		
			if(  $row['gainpass0'] !="true" )  { $v_gainpass0 ="";} else { $v_gainpass0 = $row['gainpass0'];}
			if(  $row['gainpass1']  !="true" ) { $v_gainpass1 ="";} else { $v_gainpass1 = $row['gainpass1'];}
			if(  $row['maxpwrpass0']!="true" ) { $v_maxpwrpass0 ="";} else { $v_maxpwrpass0 = $row['maxpwrpass0'];}
			
			if(  $row['temppass'] !="true" ) {  $v_temppass ="";} else { $v_temppass = $row['temppass'];}
			if(  $row['hwfailpass']!="true" ) { $v_hwfailpass ="";} else { $v_hwfailpass = $row['hwfailpass'];}
			if(  $row['forcepass'] !="true" ) {  $v_forcepass ="";} else { $v_forcepass = $row['forcepass'];}
			if(  $row['rabbitpass'] !="true" ) { $v_rabbitpass ="";} else { $v_rabbitpass = $row['rabbitpass'];}
			if( is_null( $row['gain0'] ) || $row['gain0']=="null") { $v_gain0 ="";} else { $v_gain0 = $row['gain0'];}
			if( is_null(  $row['gain1'] ) || $row['gain1']=="null") { $v_gain1 ="";} else { $v_gain1 = $row['gain1'];}
			if( is_null( $row['maxpwr0'] ) || $row['maxpwr0']=="null") { $v_maxpwr0 ="";} else { $v_maxpwr0 = $row['maxpwr0'];}
			if( is_null( $row['maxpwr1'] ) || $row['maxpwr1']=="null") { $v_maxpwr1="";} else { $v_maxpwr1 = $row['maxpwr1'];}
			if( is_null( $row['rabbitip'] )|| $row['rabbitip']=="null") { $v_rabbitip ="";} else { $v_rabbitip = $row['rabbitip'];}
			
			if( is_null( $row['ripleul'] ) || $row['ripleul']=="null") { $v_ripleul ="";} else { $v_ripleul = $row['ripleul'];}
			if( is_null( $row['ripledl'] ) || $row['ripledl']=="null") { $v_ripledl="";} else { $v_ripledl = $row['ripledl'];}
		
		
					$return_arr[] = array(
                    "idit" => "Iteracion: ".$Iteracion,
					"Date" => $row['dateacceptdib'],
					"timescript" => $v_timescript , 
					"userinfo" => $row['userruninfo'],
					"station" => $row['station'],
					"fasversion" => $v_fasversion, 
					"totalpass" => $row['totalpass'] ,
					"espacio" => " ",
					"espacio1" => " ",
					"gainpassul" => $row['gainpass0'] ,
					"gainpassdl" => $row['gainpass1'] ,					
					"MaxPwrPass" => $row['maxpwrpass0'] ,					
					"TemperaturePass" =>  $row['temppass'] ,
					"HWFailPass" =>  $row['hwfailpass'] ,
					"ForcedPass " =>  $row['forcepass'] ,
					"RabbitPass" =>  $row['rabbitpass'] ,
						"espacio3" => " ",
						"espacio31" => " ",
					"Gainul" => $v_gain0,
					"Gaindl" => $v_gain1,	
						"espacio13" => " ",
						"espacio131" => " ",					
					"MaxPwrul" => $v_maxpwr0,
					"MaxPwrdl" => $v_maxpwr1,	
						"espacio23" => " ",
						"espacio231" => " ",					
					"Rippleul" =>$v_ripleul,
					"Rippledl" => $v_ripledl,
					"espacio51" => " ",
					"RabbitIP" => $v_rabbitip,
				
                    );
		}
		///fin  if ($_REQUEST['tipodb'] == 1)
		
					
				
		$return_arr_runinfo[] = array(
					"idit" => $Iteracion ,
                    "idlog" => $row['idruninfo'] 				
                    );		

		$Iteracion= $Iteracion + 1 ;


	 }
	
	
					
 
 echo(json_encode(["gi"=>$return_arr,"gifreqgain"=>$return_arrgifreqgain, "gilog"=>$return_arr_runinfo]));




?>
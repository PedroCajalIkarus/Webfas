<?php
// Desactivar toda notificación de error
//error_reporting(0);

 include("db_conect.php"); 
	include("funcionesstores.php"); 
	header('Content-Type: application/json');
	$query_lista = list_digmodulecalif($_REQUEST['idsunit'] ,$_REQUEST['iddib_sn_modulo']);
    $return_arr = array();
 // 	echo $query_lista;				
	$data = $connect->query($query_lista)->fetchAll();						
	$letrasbuscadas = array("/", ".", ",", "-", );
	$vidfreqcant =0;
	foreach ($data as $row) {
		$rowciu_sincaractraros = str_replace($letrasbuscadas, "", $row[0]);
		
		$time_totalt = explode("#", $row['timescriptsteps']);	
		$timetotalt1 = explode("|",$time_totalt[0]);	
		$timetotalt2 = explode(" ",$timetotalt1[0]);
		$timetotalt3 = $timetotalt2[5];
		
		$return_arr[] = array(
                    "idit" => "Iteracion: ".$row['id_it'],
					"Date" => $row['dateinfo'],
					"timescript" => $timetotalt3  , 
					"userinfo" => $row['userruninfo'],
					"station" => $row['station'],
					"fasversion" => $row['fasver'],
					"totalpass" => $row['totalpass']
				
                    );
				
		$split_fw= explode(" ", $row['fws']);	
		
		
		

		$v0_split_fw ="";
		$v1_split_fw ="";
		$v2_split_fw ="";
		$v3_split_fw ="";
		
		if($split_fw[0]!="null") { $v0_split_fw = $split_fw[0]; }
		if($split_fw[1]!="null") { $v1_split_fw = $split_fw[1]; }
		if($split_fw[2]!="null") { $v2_split_fw = $split_fw[2]; }
		if($split_fw[3]!="null") { $v3_split_fw = $split_fw[3]; }
		
		$return_arr_fw[] = array(
                    "idit" => "Iteracion: ".$row['id_it']  ,					
					"fwfpga" => $v0_split_fw ,
					"fwuc" =>  $v1_split_fw ,
					"fwrabb" => $v2_split_fw,
					"fwpahp" => $v3_split_fw
                    );	
			
			
		$v0_split_sn ="- ";
		$v1_split_sn ="- ";
		$v2_split_sn ="- ";
		$v3_split_sn ="- ";
		
		if( $row['sn_dib']!="null") { $v0_split_sn = $row['sn_dib']; }
		if( $row['sn_unit'] !="null") { $v1_split_sn = $row['sn_unit'] ; }
		if( $row['sn_palp'] !="null") { $v2_split_sn = $row['sn_palp'] ; }
		if( $row['sn_pahp']  !="null") { $v3_split_sn = $row['sn_pahp'] ; }
		
		
		$return_arr_sn[] = array(
                    "idit" => "Iteracion: ".$row['id_it']  ,					
					"sndb" => $v0_split_sn, 					
					"snunit" => $v1_split_sn,
					"snpalp" => $v2_split_sn ,
					"snpahp" => $v3_split_sn					
                    );		


		$v0_split_ciu ="- ";
		$v1_split_ciu ="- ";
		$v2_split_ciu ="- ";
		$v3_split_ciu ="- ";
		
		if( $row['ciu_dib']!="null") { $v0_split_ciu = $row['ciu_dib']; }
		if( $row['ciu_unit'] !="null") {  $v1_split_ciu = $row['ciu_unit'] ; }
		if( $row['ciu_palp'] !="null") {  $v2_split_ciu = $row['ciu_palp'] ; }
		if( $row['ciu_pahp']  !="null") { $v3_split_ciu = $row['ciu_pahp'] ; }			
					
					
		$return_arr_cius[] = array(
                    "idit" => "Iteracion: ".$row['id_it']  ,					
					"ciudb" => $v0_split_ciu  , 					
					"ciuunit" => $v1_split_ciu,
					"ciu_palp" => $v2_split_ciu,
					"ciu_pahp" => $v3_split_ciu					
                    );

		$frequl_start ="- ";
		$frequl_stop ="- ";
		$freqdl_start ="- ";
		$freqdl_stop ="- ";
	
		$split_freq= explode("#", $row['freq']);	
		$split_freqa= explode("|",  $split_freq[0]);	
		$split_freqb= explode("|",  $split_freq[1]);	
		
		$split_freqaa= explode(" ",  $split_freqa[0]);	
		$split_freqbb= explode(" ",  $split_freqb[1]);	
		
		if( $split_freqaa[0]!="null") { $frequl_start = $split_freqaa[0]; }
		if( $split_freqaa[1]!="null") { $frequl_stop = $split_freqaa[1]; }
		if( $split_freqbb[0]!="null") { $freqdl_start = $split_freqbb[0]; }
		if( $split_freqbb[1]!="null") { $freqdl_stop = $split_freqbb[1]; }
	
					
					
		$return_arr_freq[] = array(
                    "idit" => "Iteracion: ".$row['id_it']  ,					
					"frequl_start" => $frequl_start  , 					
					"frequl_stop" => $frequl_stop  , 					
					"freqdl_start" => $freqdl_start,
					"freqdl_stop" => $freqdl_stop
                    );	

	$return_arr_runinfo[] = array(
                    "idlog" => $row['idruninfo'] 				
                    );	

	$losdos = explode("#", $row['eqbda']);
	$losfreqUL = explode("|", $losdos[0]);
	$losfreqDL = explode("|", $losdos[1]);
	
	$losfreqUL1="";
	$losfreqUL2="";
	$losfreqUL3="";
	$losfreqUL4="";
	$losfreqUL5="";
	$losfreqUL6="";
	$losfreqUL7="";
	$losfreqUL8="";
	$losfreqUL9="";
	$losfreqUL10="";
	
	$losfreqDL1="";
	$losfreqDL2="";
	$losfreqDL3="";
	$losfreqDL4="";
	$losfreqDL5="";
	$losfreqDL6="";
	$losfreqDL7="";
	$losfreqDL8="";
	$losfreqDL9="";
	$losfreqDL10="";
	
	
	
	if( $losfreqUL[0]!="null") { $losfreqUL1 = $losfreqUL[0]; }
	if( $losfreqUL[1]!="null") { $losfreqUL2 = $losfreqUL[1]; }
	if( $losfreqUL[2]!="null") { $losfreqUL3 = $losfreqUL[2]; }
	if( $losfreqUL[3]!="null") { $losfreqUL4 = $losfreqUL[3]; }
	if( $losfreqUL[4]!="null") { $losfreqUL5 = $losfreqUL[4]; }
	if( $losfreqUL[5]!="null") { $losfreqUL6 = $losfreqUL[5]; }
	if( isset($losfreqUL[6])!=false) { $losfreqUL7 = $losfreqUL[6]; }
//	if( $losfreqUL[7]!="null") { $losfreqUL8 = $losfreqUL[7]; }
//	if( $losfreqUL[8]!="null") { $losfreqUL9 = $losfreqUL[8]; }
//	if( $losfreqUL[9]!="null") { $losfreqUL10 = $losfreqUL[9]; }
	
	if( $losfreqDL[0]!="null") { $losfreqDL1 = $losfreqDL[0]; }
	if( $losfreqDL[1]!="null") { $losfreqDL2 = $losfreqDL[1]; }
	if( $losfreqDL[2]!="null") { $losfreqDL3 = $losfreqDL[2]; }
	if( $losfreqDL[3]!="null") { $losfreqDL4 = $losfreqDL[3]; }
	if( $losfreqDL[4]!="null") { $losfreqDL5 = $losfreqDL[4]; }
	if( $losfreqDL[5]!="null") { $losfreqDL6 = $losfreqDL[5]; }
//	if( $losfreqDL[6]!="null") { $losfreqDL7 = $losfreqDL[6]; }
//	if( $losfreqDL[7]!="null") { $losfreqDL8 = $losfreqDL[7]; }
//	if( $losfreqDL[8]!="null") { $losfreqDL9 = $losfreqDL[8]; }
//	if( $losfreqDL[9]!="null") { $losfreqDL10 = $losfreqDL[9]; }
	
	
	$gicalifreqtabfreq = array(					
					"idit" => "Iteracion: ".$row['id_it']  ,					
					"freqUL" => $losfreqUL1,
					"freqDL" => $losfreqDL1,
					"levelul" => $losfreqUL2,
					"leveldl" => $losfreqDL2,
					
					);
					
					$vidfreqcant = $vidfreqcant + 1;

	 }


					
 
 echo(json_encode(["gicalif"=>$return_arr,"gicaliffw"=>$return_arr_fw, "gicalisn"=>$return_arr_sn, "gilogcalif"=>$return_arr_runinfo, "gicalifrequldl"=>$gicalifreqtabfreq, "gicalifreq"=>$return_arr_freq,"gicaliciu"=>$return_arr_cius]));




?>
<?php
error_reporting(0);
    include("db_conect.php"); 
	include("funcionesstores.php"); 
	header('Content-Type: application/json');
	if ($_REQUEST['cuantomuestro']==1)
	{
		$query_lista = list_show_ciu_sn_info_maxrev($_REQUEST['idciu'],$_REQUEST['ciusn']);
	}
	else
	{
			$query_lista = list_show_ciu_sn_info($_REQUEST['idciu'],$_REQUEST['ciusn']);
	}

    $return_arr = array();
	$return_arr_out_table = array();
	$return_arr_out = array();
//  		echo $query_lista;		
	$data = $connect->query($query_lista)->fetchAll();						
	$v_description ="";
	
	foreach ($data as $row) {
		if( $row[7]=="null" )
			{ $v_description =" ";} 
		else
			{$v_description =$row[7];}
		if( $row[4]=="null" )
			{ $v_po =" ";} 
		else
			{$v_po =$row[4];}
		$separafechashora = explode(" ", $row[2]);
		 $v_Approvedby = ( $row['nameapproved']=="" ? " " : $row['nameapproved']);  
		 $v_Approvedby = ( $v_Approvedby=="null" ? " " : $v_Approvedby);  
		//$nombandrev = "Band: "$row[0]." - Rev: ".$row[1]
	if ( intval($row[17])>1 )
		{
		$return_arr[] = array(
					 "BandRev"=> "<b>Band: ".$row[0]."<br>Rev: ".$row[1]."</b>",					 
					 "DateApproved" => $separafechashora[0]."<br>".$separafechashora[1],
					 "PowerSupply"=> $row[3],
					 "PO"=> $v_po,
					 "RC-GforBWA"=> $row[5],
					 "ModenDigital"=> $row[6],
					 "Description"=> $v_description	,
					 "Approvedby"=> $v_Approvedby
                    );
		}	
		else		
		{
				$return_arr[] = array(
					 "BandRev"=> "<b>Rev: ".$row[1]."</b>",					 
					 "DateApproved" => $separafechashora[0]."<br>".$separafechashora[1],
					 "PowerSupply"=> $row[3],
					 "PO"=> $v_po,
					 "RC-GforBWA"=> $row[5],
					 "ModenDigital"=> $row[6],
					 "Description"=> $v_description,
					 "Approvedby"=> $v_Approvedby					 
                    );
		}
					
		$return_arr_ul[] = array(
					 "BandRev"=> "Band: ".$row[0]."<br>Rev: ".$row[1],	
					 "Gain" => $row[8],
					 "Max Pwr"=> $row[9],
					 "Freq Start"=> $row[10],
					 "Freq Stop"=> $row[11],
					 "Approvedby"=> $v_Approvedby
                    );	

		$return_arr_dl[] = array(
					"BandRev"=> "Band: ".$row[0]."<br>Rev: ".$row[1],	
					 "Gain" => $row[12],
					 "Max Pwr"=> $row[13],
					 "Freq Start"=> $row[14],
					 "Freq Stop"=> $row[15]	,
					 "Approvedby"=> $v_Approvedby					 
                    );	
		$return_arr_log[] = array(
					 "Band"=> $row[0],
					  "Rev"=> $row[1],
					 "idruninfo" => $row[16]			
                    );								
					
		
		///Pregunt si IFdual band
		
		if ( intval($row[17])>1 )
		{
			$return_arr_uldl[] = array(		 
					 "BandRev"=> "<b>DL<hr>Band: ".$row[0]."<br>Rev: ".$row[1]."</b>",	
					 "Gain" => $row[12],
					 "MaxPwr"=> $row[13],
					 "FreqStart"=> $row[14],
					 "FreqStop"=> $row[15]						 
                    );	
		$return_arr_uldl[] = array(
					 "BandRev"=> "<b>UL<hr>Band: ".$row[0]."<br>Rev: ".$row[1]."</b>",	
					 "Gain" => $row[8],
					 "Max Pwr"=> $row[9],
					 "Freq Start"=> $row[10],
					 "Freq Stop"=> $row[11]	
					 );	
		}
		else
		{
		$return_arr_uldl[] = array(		 
					 "BandRev"=> "<b>DL<hr>Rev: ".$row[1]."</b>",		
					 "Gain" => $row[12],
					 "MaxPwr"=> $row[13],
					 "FreqStart"=> $row[14],
					 "FreqStop"=> $row[15]						 
                    );	
		$return_arr_uldl[] = array(
					 "BandRev"=> "<b>UL<hr>Rev: ".$row[1]."</b>",	
					 "Gain" => $row[8],
					 "Max Pwr"=> $row[9],
					 "Freq Start"=> $row[10],
					 "Freq Stop"=> $row[11]	
					 );		
		}					 
		//echo $row[0].",".$row[1];
	
	 }
	

	//// list_show_ciu_sn_info_subband
	 if ($_REQUEST['cuantomuestro']==1)	
	 {
		$query_lista =  list_show_ciu_sn_info_subband_maxrev($_REQUEST['idciu'],$_REQUEST['ciusn']);
	 }
	else
	{
		///aca falta crear esta funcion 
		$query_lista = list_show_ciu_sn_info_subband($_REQUEST['idciu'],$_REQUEST['ciusn']);	
	}
	//echo $query_lista;
	$data_subband = $connect->query($query_lista)->fetchAll();						

	
	foreach ($data_subband as $rowsubband) 
	{
		if ( intval($rowsubband[0])>1 )
		{
			$return_arr_uldl_subband[] = array(		 
					 "BandRev"=> "<b>DL<hr>Band: ".$rowsubband[1]."<br>Rev: ".$rowsubband[2]."<br>Subband:".$rowsubband[3]."</b>",			
					 "Start" => $rowsubband[7],
					 "Center"=> $rowsubband[8],
					 "Stop"=> $rowsubband[9]
					 
                    );	
		$return_arr_uldl_subband[] = array(
					 "BandRev"=> "<b>UL<hr>Band: ".$rowsubband[1]."<br>Rev: ".$rowsubband[2]."<br>Sband:".$rowsubband[3]."</b>",			
					 "Start" => $rowsubband[4],
					 "Center"=> $rowsubband[5],
					 "Stop"=> $rowsubband[6]
					 );	
		}
		else
		{
		$return_arr_uldl_subband[] = array(		 
					 "BandRev"=> "<b>DL<hr>Rev: ".$rowsubband[2]."<br>Sband:".$rowsubband[3]."</b>",		
					 "Start" => $rowsubband[7],
					 "Center"=> $rowsubband[8],
					 "Stop"=> $rowsubband[9]					 
                    );	
		$return_arr_uldl_subband[] = array(
					 "BandRev"=> "<b>UL<hr>Rev: ".$rowsubband[2]."<br>Sband:".$rowsubband[3]."</b>",			
					 "Start" => $rowsubband[4],
					 "Center"=> $rowsubband[5],
					 "Stop"=> $rowsubband[6]
					 );		
		}				
	}
	
	//fin list_show_ciu_sn_info_subband
	 //recorremos data de so_sp_ch
	 if ($_REQUEST['cuantomuestro']==1)	
	 {
		$query_lista = list_show_ciu_sn_info_ch_maxrev($_REQUEST['idciu'],$_REQUEST['ciusn']);
	 }
	else
	{
		$query_lista = list_show_ciu_sn_info_ch($_REQUEST['idciu'],$_REQUEST['ciusn']);	
	}
	
	//echo $query_lista;
	$data_ch = $connect->query($query_lista)->fetchAll();	
	//$data_ch = $connect->query($query_lista)->fetchAll();	
	//$data_ch = $connect->query($query_lista)->fetchAll();	
	 
     $id_ch_temp="";
	 $return_arr_idch= array();
	$columnul="";
	$columdl="";
	$vfch1="";
	$vfch2="";
	$vfch3="";
	$vfch4="";
	$vfch5="";
	$vfch6="";
	$vfch7="";
	$vfch8="";
	$vfch9="";
	$vfch10="";
	$vfch11="";
	$vfch12="";
	$vfch13="";
	$vfch14="";
	$vfch15="";
	$vfch16="";
	$vfch17="";
	$vfch18="";
	$vfch19="";
	$vfch20="";
	$vfch21="";
	$vfch22="";
	$vfch23="";
	$vfch24="";
	$vfch25="";
	$vfch26="";
	$vfch27="";
	$vfch28="";
	$vfch29="";
	$vfch30="";
	$vfch31="";
	
	$vfch1dl="";
	$vfch2dl="";
	$vfch3dl="";
	$vfch4dl="";
	$vfch5dl="";
	$vfch6dl="";
	$vfch7dl="";
	$vfch8dl="";
	$vfch9dl="";
	$vfch10dl="";
	$vfch11dl="";
	$vfch12dl="";
	$vfch13dl="";
	$vfch14dl="";
	$vfch15dl="";
	$vfch16dl="";
	$vfch17dl="";
	$vfch18dl="";
	$vfch19dl="";
	$vfch20dl="";
	$vfch21dl="";
	$vfch22dl="";
	$vfch23dl="";
	$vfch24dl="";
	$vfch25dl="";
	$vfch26dl="";
	$vfch27dl="";
	$vfch28dl="";
	$vfch29dl="";
	$vfch30dl="";
	$vfch31dl="";
	$banrev="";
	
	 	foreach ($data_ch as $row_ch) 
		{	
			$banrevtemp=$row_ch[1]."#".$row_ch[2];
				if ( intval($row_ch[0])>1 )
				{
					$columnul="<b>UL<hr>Band: ".$row_ch[1]."<br>Rev: ".$row_ch[2]."</b>";
					$columdl="<b>DL<hr>Band: ".$row_ch[1]."<br>Rev: ".$row_ch[2]."</b>";
				}
				else
				{
					$columnul="<b>UL<hr>Rev: ".$row_ch[2]."</b>";
					$columdl="<b>DL<hr>Rev: ".$row_ch[2]."</b>";
				}
				if ($row_ch[3] == 1)
				{ $vfch1=$row_ch[4]; $vfch1dl=$row_ch[5];}
				if ($row_ch[3] == 2)
				{ $vfch2=$row_ch[4]; $vfch2dl=$row_ch[5];}
				if ($row_ch[3] == 3)
				{ $vfch3=$row_ch[4]; $vfch3dl=$row_ch[5];}
				if ($row_ch[3] == 4)
				{ $vfch4=$row_ch[4];$vfch4dl=$row_ch[5];}
				if ($row_ch[3] == 5)
				{ $vfch5=$row_ch[4];$vfch5dl=$row_ch[5];}
				if ($row_ch[3] == 6)
				{ $vfch6=$row_ch[4];$vfch6dl=$row_ch[5];}
				if ($row_ch[3] == 7)
				{ $vfch7=$row_ch[4];  $vfch7dl=$row_ch[5];}
				if ($row_ch[3] == 8)
				{ $vfch8=$row_ch[4]; $vfch8dl=$row_ch[5];}
				if ($row_ch[3] == 9)
				{ $vfch9=$row_ch[4]; $vfch9dl=$row_ch[5];}
				if ($row_ch[3] == 10)
				{ $vfch10=$row_ch[4]; $vfch10dl=$row_ch[5];}
				if ($row_ch[3] == 11)
				{ $vfch11=$row_ch[4]; $vfch11dl=$row_ch[5];}
			
				if ($row_ch[3] == 12)
				{ $vfch12=$row_ch[4]; $vfch12dl=$row_ch[5];}
			if ($row_ch[3] == 13)
				{ $vfch13=$row_ch[4]; $vfch13dl=$row_ch[5];}
			if ($row_ch[3] == 14)
				{ $vfch14=$row_ch[4]; $vfch14dl=$row_ch[5];}
			if ($row_ch[3] == 15)
				{ $vfch15=$row_ch[4]; $vfch15dl=$row_ch[5];}
			if ($row_ch[3] == 16)
				{ $vfch16=$row_ch[4]; $vfch16dl=$row_ch[5];}
			if ($row_ch[3] == 17)
				{ $vfch17=$row_ch[4]; $vfch17dl=$row_ch[5];}
			if ($row_ch[3] == 18)
				{ $vfch18=$row_ch[4]; $vfch18dl=$row_ch[5];}
			if ($row_ch[3] == 19)
				{ $vfch19=$row_ch[4]; $vfch19dl=$row_ch[5];}
			if ($row_ch[3] == 20)
				{ $vfch20=$row_ch[4]; $vfch20dl=$row_ch[5];}
			if ($row_ch[3] == 21)
				{ $vfch21=$row_ch[4]; $vfch21dl=$row_ch[5];}
			if ($row_ch[3] == 22)
				{ $vfch22=$row_ch[4]; $vfch22dl=$row_ch[5];}
			if ($row_ch[3] == 23)
				{ $vfch23=$row_ch[4]; $vfch23dl=$row_ch[5];}
			if ($row_ch[3] == 24)
				{ $vfch24=$row_ch[4]; $vfch24dl=$row_ch[5];}
			if ($row_ch[3] == 25)
				{ $vfch25=$row_ch[4]; $vfch25dl=$row_ch[5];}
			if ($row_ch[3] == 26)
				{ $vfch26=$row_ch[4]; $vfch26dl=$row_ch[5];}
			if ($row_ch[3] == 27)
				{ $vfch27=$row_ch[4]; $vfch27dl=$row_ch[5];}
			if ($row_ch[3] == 28)
				{ $vfch28=$row_ch[4]; $vfch28dl=$row_ch[5];}
			if ($row_ch[3] == 29)
				{ $vfch29=$row_ch[4]; $vfch29dl=$row_ch[5];}
			if ($row_ch[3] == 30)
				{ $vfch30=$row_ch[4]; $vfch30dl=$row_ch[5];}
			
			
		
				if ($banrev == $banrevtemp)
				{
					$banrev = $banrevtemp;
				}
				else
				{
						
						if ($banrev!="")
						{
							$return_arr_idch_uldl[] = array(		 
							 "BandRev"=>$columdl,									
							 "Fch [0]"	=> $vfch1dl,	 
							 "Fch [1]"	=> $vfch2dl,	 
							 "Fch [2]"	=> $vfch3dl,	 
							 "Fch [3]"	=> $vfch4dl,	 
							 "Fch [4]"	=> $vfch5dl,	 
							 "Fch [5]"	=> $vfch6dl,	 
							 "Fch [6]"	=>  $vfch7dl,							
							 "Fch [7]"	=>  $vfch8dl,			
							 "Fch [8]"	=>  $vfch9dl,			
							 "Fch [9]"	=> $vfch10dl,
							 "Fch [10]"	=> $vfch11dl,
							"Fch [11]"	=> $vfch12dl,
							"Fch [12]"	=> $vfch13dl,
							"Fch [13]"	=> $vfch14dl,
							"Fch [14]"	=> $vfch15dl,
							"Fch [15]"	=> $vfch16dl,
							"Fch [16]"	=> $vfch17dl,
							"Fch [17]"	=> $vfch18dl,
							"Fch [18]"	=> $vfch19dl,
							"Fch [19]"	=> $vfch20dl,
							"Fch [20]"	=> $vfch21dl,
							"Fch [21]"	=> $vfch22dl,
							"Fch [22]"	=> $vfch23dl,
							"Fch [23]"	=> $vfch24dl,
							"Fch [24]"	=> $vfch25dl,
							"Fch [25]"	=> $vfch26dl,
							"Fch [26]"	=> $vfch27dl,
							"Fch [27]"	=> $vfch28dl,
							"Fch [28]"	=> $vfch29dl,
							"Fch [29]"	=> $vfch30dl,
							"Fch [30]"	=> $vfch31dl
							);	
							$return_arr_idch_uldl[] = array(		 
							 "BandRev"=>$columnul,									
							 "Fch [0]"	=> $vfch1,	 
							 "Fch [1]"	=> $vfch2,	 
							 "Fch [2]"	=> $vfch3,	 
							 "Fch [3]"	=> $vfch4,	 
							 "Fch [4]"	=> $vfch5,	 
							 "Fch [5]"	=> $vfch6,	 
							 "Fch [6]"	=>  $vfch7,							
							 "Fch [7]"	=>  $vfch8,			
							 "Fch [8]"	=>  $vfch9,			
							 "Fch [9]"	=> $vfch10,
							 "Fch [10]"	=> $vfch11,		
							"Fch [11]"	=> $vfch12,
							"Fch [12]"	=> $vfch13,
							"Fch [13]"	=> $vfch14,
							"Fch [14]"	=> $vfch15,
							"Fch [15]"	=> $vfch16,
							"Fch [16]"	=> $vfch17,
							"Fch [17]"	=> $vfch18,
							"Fch [18]"	=> $vfch19,
							"Fch [19]"	=> $vfch20,
							"Fch [20]"	=> $vfch21,
							"Fch [21]"	=> $vfch22,
							"Fch [22]"	=> $vfch23,
							"Fch [23]"	=> $vfch24,
							"Fch [24]"	=> $vfch25,
							"Fch [25]"	=> $vfch26,
							"Fch [26]"	=> $vfch27,
							"Fch [27]"	=> $vfch28,
							"Fch [28]"	=> $vfch29,
							"Fch [29]"	=> $vfch30,
							"Fch [30]"	=> $vfch31 	 	 								 
							);	
						}	
						$banrev = $banrevtemp;
				}
			
					
		}
		
						$return_arr_idch_uldl[] = array(		 
							 "BandRev"=>$columdl,									
							 "Fch [0]"	=> $vfch1dl,	 
							 "Fch [1]"	=> $vfch2dl,	 
							 "Fch [2]"	=> $vfch3dl,	 
							 "Fch [3]"	=> $vfch4dl,	 
							 "Fch [4]"	=> $vfch5dl,	 
							 "Fch [5]"	=> $vfch6dl,	 
							 "Fch [6]"	=>  $vfch7dl,							
							 "Fch [7]"	=>  $vfch8dl,			
							 "Fch [8]"	=>  $vfch9dl,			
							 "Fch [9]"	=> $vfch10dl,
							 "Fch [10]"	=> $vfch11dl,
							"Fch [11]"	=> $vfch12dl,
							"Fch [12]"	=> $vfch13dl,
							"Fch [13]"	=> $vfch14dl,
							"Fch [14]"	=> $vfch15dl,
							"Fch [15]"	=> $vfch16dl,
							"Fch [16]"	=> $vfch17dl,
							"Fch [17]"	=> $vfch18dl,
							"Fch [18]"	=> $vfch19dl,
							"Fch [19]"	=> $vfch20dl,
							"Fch [20]"	=> $vfch21dl,
							"Fch [21]"	=> $vfch22dl,
							"Fch [22]"	=> $vfch23dl,
							"Fch [23]"	=> $vfch24dl,
							"Fch [24]"	=> $vfch25dl,
							"Fch [25]"	=> $vfch26dl,
							"Fch [26]"	=> $vfch27dl,
							"Fch [27]"	=> $vfch28dl,
							"Fch [28]"	=> $vfch29dl,
							"Fch [29]"	=> $vfch30dl,
							"Fch [30]"	=> $vfch31dl
							);	
							$return_arr_idch_uldl[] = array(		 
							 "BandRev"=>$columnul,									
							 "Fch [0]"	=> $vfch1,	 
							 "Fch [1]"	=> $vfch2,	 
							 "Fch [2]"	=> $vfch3,	 
							 "Fch [3]"	=> $vfch4,	 
							 "Fch [4]"	=> $vfch5,	 
							 "Fch [5]"	=> $vfch6,	 
							 "Fch [6]"	=>  $vfch7,							
							 "Fch [7]"	=>  $vfch8,			
							 "Fch [8]"	=>  $vfch9,			
							 "Fch [9]"	=> $vfch10,
							 "Fch [10]"	=> $vfch11,		
							"Fch [11]"	=> $vfch12,
							"Fch [12]"	=> $vfch13,
							"Fch [13]"	=> $vfch14,
							"Fch [14]"	=> $vfch15,
							"Fch [15]"	=> $vfch16,
							"Fch [16]"	=> $vfch17,
							"Fch [17]"	=> $vfch18,
							"Fch [18]"	=> $vfch19,
							"Fch [19]"	=> $vfch20,
							"Fch [20]"	=> $vfch21,
							"Fch [21]"	=> $vfch22,
							"Fch [22]"	=> $vfch23,
							"Fch [23]"	=> $vfch24,
							"Fch [24]"	=> $vfch25,
							"Fch [25]"	=> $vfch26,
							"Fch [26]"	=> $vfch27,
							"Fch [27]"	=> $vfch28,
							"Fch [28]"	=> $vfch29,
							"Fch [29]"	=> $vfch30,
							"Fch [30]"	=> $vfch31 	 	 								 
							);	
		
//echo json_encode($return_arr_out);
//echo(json_encode(["gi"=>$return_arr,"ul"=>$return_arr_ul,"ud"=>$return_arr_dl, "lg"=>$return_arr_log, "ch"=>$return_arr_idch,"uldl"=>$return_arr_uldl]));
echo(json_encode(["gi"=>$return_arr,"lg"=>$return_arr_log, "ch"=>$return_arr_idch_uldl,"uldlsubband"=>$return_arr_uldl_subband,"uldl"=>$return_arr_uldl]));
 		
 //echo json_encode($someArray);
 
 
 



?>

<?php
error_reporting(0);
    include("db_conect.php"); 
	include("funcionesstores.php"); 
	header('Content-Type: application/json');

	if ($_REQUEST['cuantomuestro']==1)
	{
		 $query_lista= "select distinct  
								0 as idband, pre.idrev, COALESCE (orders_sn.date_approved,'') as date_approved , 
								case when coalesce(pwrsupplytype,'')='' then '-' when pwrsupplytype='null' then '-' else pwrsupplytype end as  pwrsupplytype,
								case when coalesce(ponumber,'')='' then '-' when ponumber='null' then '-' else ponumber end as  ponumber,
								 rcgfbwa,
								 moden_dig,
								case when coalesce(orders_sn.descripcion,'')='' then '-' when orders_sn.descripcion='null' then '-' else orders_sn.descripcion end as  descripcion,
								  ul_ch_fr,
								  dl_ch_fr,
								  dpxlowstart,
								  dpxlowstop ,
								  dpxhihgstart,
								  dpxhihgstop,
								  unitdlstart,
								  unitdlstop,
								   unitulstart,
								  unitulstop,
								  orders_sn_specs.notes as orders_sn_specsnotes,
								 pre.idruninfo, 0 as ifdualband,
								case when pre.idruninfo = 0 then '-' when pre.idruninfo >0 then trim(runinfodb.userruninfo) end as userruninfo , pre.nameapproved ,typedata,
								 ul_gain, ul_max_pwr, dl_gain, dl_max_pwr, 
								 req_ppassy, req_calibration, req_spec, req_other, idch

								from orders as pre
								inner join products
								on products.idproduct = pre.idproduct  												
								inner join customers
								on customers.idcustomers = pre.idcustomers
								 inner join 
																					(
																						select idorders, max(idrev) as maxiderev from orders where idorders = ".$_REQUEST['idord']." 
																						group by idorders
																					) as maxidrevxpo
																					on maxidrevxpo.idorders  = pre.idorders and 
																					   maxidrevxpo.maxiderev =  pre.idrev	 													  
								inner join orders_sn
								on orders_sn.idorders = pre.idorders and
								  orders_sn.idrev = pre.idrev
								  left join orders_sn_specs
								on orders_sn_specs.idorders = pre.idorders and
								  orders_sn_specs.idrev = pre.idrev and
								   orders_sn_specs.idnroserie = orders_sn.idnroserie 
								  left join runinfodb
								on runinfodb.idruninfo = pre.idruninfo 
								where pre.typeregister = 'SO' and pre.active ='Y' and orders_sn.wo_serialnumber  = '".$_REQUEST['ciusn']."'
								and pre.idorders= ".$_REQUEST['idord']."  and orders_sn.idnroserie >0 ";
		
	}
	else
	{
		
		 $query_lista= "select distinct  
								0 as idband, pre.idrev, COALESCE (orders_sn.date_approved,'') as date_approved , 
								case when coalesce(pwrsupplytype,'')='' then '-' when pwrsupplytype='null' then '-' else pwrsupplytype end as  pwrsupplytype,
								case when coalesce(ponumber,'')='' then '-' when ponumber='null' then '-' else ponumber end as  ponumber,
								 rcgfbwa,
								 moden_dig,
								case when coalesce(orders_sn.descripcion,'')='' then '-' when orders_sn.descripcion='null' then '-' else orders_sn.descripcion end as  descripcion,
								  ul_ch_fr,
								  dl_ch_fr,
								  dpxlowstart,
								  dpxlowstop ,
								  dpxhihgstart,
								  dpxhihgstop,
								  unitdlstart,
								  unitdlstop,
								   unitulstart,
								  unitulstop,
								  orders_sn_specs.notes as orders_sn_specsnotes,
								 pre.idruninfo, 0 as ifdualband,
								case when pre.idruninfo = 0 then '-' when pre.idruninfo >0 then trim(runinfodb.userruninfo) end as userruninfo , pre.nameapproved ,typedata,
								 ul_gain, ul_max_pwr, dl_gain, dl_max_pwr, 
								 req_ppassy, req_calibration, req_spec, req_other, idch

								from orders as pre
								inner join products
								on products.idproduct = pre.idproduct  												
								inner join customers
								on customers.idcustomers = pre.idcustomers
																				  
								inner join orders_sn
								on orders_sn.idorders = pre.idorders and
								  orders_sn.idrev = pre.idrev
								  left join orders_sn_specs
									on orders_sn_specs.idorders = orders_sn.idorders and
								  orders_sn_specs.idrev = orders_sn.idrev and
								  orders_sn_specs.idnroserie = orders_sn.idnroserie 
								  left join runinfodb
								on runinfodb.idruninfo = pre.idruninfo 
								where pre.typeregister = 'SO' and pre.active ='Y' and orders_sn.wo_serialnumber  = '".$_REQUEST['ciusn']."'
								and pre.idorders= ".$_REQUEST['idord']."  and orders_sn.idnroserie >0 ";
	}
			 

	

    $return_arr = array();
	$return_arr_out_table = array();
	$return_arr_out = array();
  	//	echo $query_lista;		
	$data = $connect->query($query_lista)->fetchAll();						
	$v_description ="";
	$vcantmostrar=0;
	$vcantmostrartablach=0;
		$vcantmostrar1ertablach=0;
	$vtemprevmostre = -1;
	
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
	
	$vfdpxh1="";
	$vfdpxh2="";
	$vfdpxh3="";
	$vfdpxh4="";
	$vfdpxh5="";
	$vfdpxh6="";
	$vfdpxh7="";
	$vfdpxh8="";
	$vfdpxh9="";
	$vfdpxh10="";
	$vfdpxh11="";
	$vfdpxh12="";
	$vfdpxh13="";
	$vfdpxh14="";
	$vfdpxh15="";
	$vfdpxh16="";
	$vfdpxh17="";
	$vfdpxh18="";
	$vfdpxh19="";
	$vfdpxh20="";
	
	$vfddpxl1="";
	$vfddpxl2="";
	$vfddpxl3="";
	$vfddpxl4="";
	$vfddpxl5="";
	$vfddpxl6="";
	$vfddpxl7="";
	$vfddpxl8="";
	$vfddpxl9="";
	$vfddpxl10="";
	$vfddpxl11="";
	$vfddpxl12="";
	$vfddpxl13="";
	$vfddpxl14="";
	$vfddpxl15="";
	$vfddpxl16="";
	$vfddpxl17="";
	$vfddpxl18="";
	$vfddpxl19="";
	$vfddpxl20="";
	
	$vfunit1="";
	$vfunit2="";
	$vfunit3="";
	$vfunit4="";
	$vfunit5="";
	$vfunit6="";
	$vfunit7="";
	$vfunit8="";
	$vfunit9="";
	$vfunit10="";
	$vfunit11="";
	$vfunit12="";
	$vfunit13="";
	$vfunit14="";
	$vfunit15="";
	$vfunit16="";
	$vfunit17="";
	$vfunit18="";
	$vfunit19="";
	$vfunit20="";
	
	$vfunitdl1="";
	$vfunitdl2="";
	$vfunitdl3="";
	$vfunitdl4="";
	$vfunitdl5="";
	$vfunitdl6="";
	$vfunitdl7="";
	$vfunitdl8="";
	$vfunitdl9="";
	$vfunitdl10="";
	$vfunitdl11="";
	$vfunitdl12="";
	$vfunitdl13="";
	$vfunitdl14="";
	$vfunitdl15="";
	$vfunitdl16="";
	$vfunitdl17="";
	$vfunitdl18="";
	$vfunitdl19="";
	$vfunitdl20="";
	
	$vfunit1stop="";
	$vfunit2stop="";
	$vfunit3stop="";
	$vfunit4stop="";
	$vfunit5stop="";
	$vfunit6stop="";
	$vfunit7stop="";
	$vfunit8stop="";
	$vfunit9stop="";
	$vfunit10stop="";
	$vfunit11stop="";
	$vfunit12stop="";
	$vfunit13stop="";
	$vfunit14stop="";
	$vfunit15stop="";
	$vfunit16stop="";
	$vfunit17stop="";
	$vfunit18stop="";
	$vfunit19stop="";
	$vfunit20stop="";
	
	$vfunitdl1stop="";
	$vfunitdl2stop="";
	$vfunitdl3stop="";
	$vfunitdl4stop="";
	$vfunitdl5stop="";
	$vfunitdl6stop="";
	$vfunitdl7stop="";
	$vfunitdl8stop="";
	$vfunitdl9stop="";
	$vfunitdl10stop="";
	$vfunitdl11stop="";
	$vfunitdl12stop="";
	$vfunitdl13stop="";
	$vfunitdl14stop="";
	$vfunitdl15stop="";
	$vfunitdl16stop="";
	$vfunitdl17stop="";
	$vfunitdl18stop="";
	$vfunitdl19stop="";
	$vfunitdl20stop="";
	
					$maxunitgaindl ="-";
					$maxunitgainul ="-";
					$unitgainul ="-";	
					$unitgaindl ="-";
					
					$unitcolumdl="-";
					$unitcolumul="-";
					
	$temprevision=-1;

	
	foreach ($data as $row) 
		{
			if( $row['descripcion']=="null" )
				{ $v_description =" ";} 
			else
				{$v_description =$row['descripcion'];}
			if( $row['ponumber']=="null" )
				{ $v_po =" ";} 
			else
				{$v_po =$row['ponumber'];}
			$separafechashora = explode(" ", $row['date_approved']);
			 $v_Approvedby = ( $row['nameapproved']=="" ? " " : $row['nameapproved']);  
			 $v_Approvedby = ( $v_Approvedby=="null" ? " " : $v_Approvedby);  
		//$nombandrev = "Band: "$row[0]." - Rev: ".$row[1]

			if ( $_REQUEST['cuantomuestro'] ==1)
			{
				$temprevision = 99;
				if ($vcantmostrar ==0  and  $_REQUEST['cuantomuestro'] ==1)
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
					
					$return_arr_log[] = array(
					 "Band"=> $row[0],
					  "Rev"=> $row[1],
					 "idruninfo" => $row['idruninfo']			
                    );	
				}
				
				$vcantmostrar=1;	
					/// SOLO CARGAMOS DATOS ADICIONALES PARA LA ULT Rev
					if ( $row['typedata'] =="CHANNEL") 	
					{
								$columnul="<b>UL<hr>Rev: ".$row[1]."</b>";
								$columdl="<b>DL<hr>Rev: ".$row[1]."</b>";
				
														
									if ($row['idch'] == 1)
									{ $vfch1=$row['ul_ch_fr']; $vfch1dl=$row['dl_ch_fr'];}
									if ($row['idch']== 2)
									{ $vfch2=$row['ul_ch_fr']; $vfch2dl=$row['dl_ch_fr'];}
									if ($row['idch']== 3)
									{ $vfch3=$row['ul_ch_fr']; $vfch3dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 4)
									{ $vfch4=$row['ul_ch_fr'];$vfch4dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 5)
									{ $vfch5=$row['ul_ch_fr'];$vfch5dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 6)
									{ $vfch6=$row['ul_ch_fr'];$vfch6dl=$row['dl_ch_fr'];}
									if ($row['idch']== 7)
									{ $vfch7=$row['ul_ch_fr'];  $vfch7dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 8)
									{ $vfch8=$row['ul_ch_fr']; $vfch8dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 9)
									{ $vfch9=$row['ul_ch_fr']; $vfch9dl=$row['dl_ch_fr'];}
									if ($row['idch']== 10)
									{ $vfch10=$row['ul_ch_fr']; $vfch10dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 11)
									{ $vfch11=$row['ul_ch_fr']; $vfch11dl=$row['dl_ch_fr'];}

									if ($row['idch'] == 12)
									{ $vfch12=$row['ul_ch_fr']; $vfch12dl=$row['dl_ch_fr'];}
									if ($row['idch']== 13)
									{ $vfch13=$row['ul_ch_fr']; $vfch13dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 14)
									{ $vfch14=$row['ul_ch_fr']; $vfch14dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 15)
									{ $vfch15=$row['ul_ch_fr']; $vfch15dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 16)
									{ $vfch16=$row['ul_ch_fr']; $vfch16dl=$row['dl_ch_fr'];}
									if ($row['idch']== 17)
									{ $vfch17=$row['ul_ch_fr']; $vfch17dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 18)
									{ $vfch18=$row['ul_ch_fr']; $vfch18dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 19)
									{ $vfch19=$row['ul_ch_fr']; $vfch19dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 20)
									{ $vfch20=$row['ul_ch_fr']; $vfch20dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 21)
									{ $vfch21=$row['ul_ch_fr']; $vfch21dl=$row['dl_ch_fr'];}
									if ($row['idch']== 22)
									{ $vfch22=$row['ul_ch_fr']; $vfch22dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 23)
									{ $vfch23=$row['ul_ch_fr']; $vfch23dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 24)
									{ $vfch24=$row['ul_ch_fr']; $vfch24dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 25)
									{ $vfch25=$row['ul_ch_fr']; $vfch25dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 26)
									{ $vfch26=$row['ul_ch_fr']; $vfch26dl=$row['dl_ch_fr'];}
									if ($row['idch']== 27)
									{ $vfch27=$row['ul_ch_fr']; $vfch27dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 28)
									{ $vfch28=$row['ul_ch_fr']; $vfch28dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 29)
									{ $vfch29=$row['ul_ch_fr']; $vfch29dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 30)
									{ $vfch30=$row['ul_ch_fr']; $vfch30dl=$row['dl_ch_fr'];}
								
							
									
						
					}
					
					if ( $row['typedata'] =="DPX") 	
					{
							$unitcolumdl="<b>DL<hr>Rev: ".$row[1]."</b>";
							$unitcolumul="<b>UL<hr>Rev: ".$row[1]."</b>";
								if ($row['idch'] == 1)
									{ 
									  $vfdpxh1=$row['dpxhihgstart']." / ".$row['dpxhihgstop'];
									  $vfddpxl1=$row['dpxlowstart']." / ".$row['dpxlowstop'];
									}
								if ($row['idch'] == 2)
									{ 
									  $vfdpxh2=$row['dpxhihgstart']." / ".$row['dpxhihgstop'];
									  $vfddpxl2=$row['dpxlowstart']." / ".$row['dpxlowstop'];
									}
								if ($row['idch'] == 3)
									{ 
									  $vfdpxh3=$row['dpxhihgstart']." / ".$row['dpxhihgstop'];
									  $vfddpxl3=$row['dpxlowstart']." / ".$row['dpxlowstop'];
									}		
							
					}

					if ( $row['typedata'] =="UNIT") 	
					{
							$unitcolumdl="<b>DL<hr>Rev: ".$row[1]."</b>";
							$unitcolumul="<b>UL<hr>Rev: ".$row[1]."</b>";
							
							if ($row['dl_gain'] !="null")
							{
								$unitgaindl =$row['dl_gain'];	
							}
							else
							{
								$unitgaindl ="";
							}
							if ($row['ul_gain'] !="null")
							{
								$unitgainul =$row['ul_gain'];	
							}
							else
							{
								$unitgainul ="";	
							}
							
							
							if ($row['dl_max_pwr'] !="null")
							{
								$maxunitgaindl =$row['dl_max_pwr'];	
							}
							else
							{
								$maxunitgaindl ="";	
							}
							
							
							if ($row['ul_max_pwr'] !="null")
							{
								$maxunitgainul =$row['ul_max_pwr'];	
							}
							else
							{
								$maxunitgainul ="";	
							}
							
					
							
										 
									if ($row['idch'] == 1)
									{ 
									
									  $vfunit1=$row['unitulstart']." / ".$row['unitulstop'];
									  $vfunitdl1=$row['unitdlstart']." / ".$row['unitdlstop'];
									}
									if ($row['idch'] == 2)
									{ 
										$vfunit2=$row['unitulstart']." / ".$row['unitulstop'];
									  $vfunitdl2=$row['unitdlstart']." / ".$row['unitdlstop'];
									}
									if ($row['idch'] == 3)
									{ 
									   $vfunit3=$row['unitulstart']." / ".$row['unitulstop'];
									  $vfunitdl3=$row['unitdlstart']." / ".$row['unitdlstop'];
									}
										if ($row['idch'] == 4)
									{ 
									   $vfunit4=$row['unitulstart']." / ".$row['unitulstop'];
									  $vfunitdl4=$row['unitdlstart']." / ".$row['unitdlstop'];
									}
									if ($row['idch'] == 5)
									{ 
									   $vfunit5=$row['unitulstart']." / ".$row['unitulstop'];
									  $vfunitdl5=$row['unitdlstart']." / ".$row['unitdlstop'];
									}
									if ($row['idch'] == 6)
									{ 
									   $vfunit6=$row['unitulstart']." / ".$row['unitulstop'];
									  $vfunitdl6=$row['unitdlstart']." / ".$row['unitdlstop'];
									}
									if ($row['idch'] == 7)
									{ 
									   $vfunit7=$row['unitulstart']." / ".$row['unitulstop'];
									  $vfunitdl7=$row['unitdlstart']." / ".$row['unitdlstop'];
									}
									if ($row['idch'] == 8)
									{ 
									   $vfunit8=$row['unitulstart']." / ".$row['unitulstop'];
									  $vfunitdl8=$row['unitdlstart']." / ".$row['unitdlstop'];
									}
									if ($row['idch'] == 9)
									{ 
									   $vfunit9=$row['unitulstart']." / ".$row['unitulstop'];
									  $vfunitdl9=$row['unitdlstart']." / ".$row['unitdlstop'];
									}
									if ($row['idch'] == 10)
									{ 
									   $vfunit10=$row['unitulstart']." / ".$row['unitulstop'];
									  $vfunitdl10=$row['unitdlstart']." / ".$row['unitdlstop'];
									}
									
					}	
					/// FIN SOLO CARGAMOS DATOS ADICIONALES PARA LA ULT REV
				
			}			
			
			if ( $_REQUEST['cuantomuestro'] ==2 )
			{
				if ( intval($vtemprevmostre) < intval($row[1]) )
				{
					$vtemprevmostre = $row[1];
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
					
						$return_arr_log[] = array(
					 "Band"=> $row[0],
					  "Rev"=> $row[1],
					 "idruninfo" => $row['idruninfo']			
                    );	
					$vcantmostrar=1;
				}
			
			
				if ($temprevision != $row[1])	
				{
					$temprevision = $row[1];
				
					
					if ( $row['typedata'] =="CHANNEL") 	
					{
								$columnul="<b>UL<hr>Rev: ".$row[1]."</b>";
								$columdl="<b>DL<hr>Rev: ".$row[1]."</b>";
				
														
									if ($row['idch'] == 1)
									{ $vfch1=$row['ul_ch_fr']; $vfch1dl=$row['dl_ch_fr'];}
									if ($row['idch']== 2)
									{ $vfch2=$row['ul_ch_fr']; $vfch2dl=$row['dl_ch_fr'];}
									if ($row['idch']== 3)
									{ $vfch3=$row['ul_ch_fr']; $vfch3dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 4)
									{ $vfch4=$row['ul_ch_fr'];$vfch4dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 5)
									{ $vfch5=$row['ul_ch_fr'];$vfch5dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 6)
									{ $vfch6=$row['ul_ch_fr'];$vfch6dl=$row['dl_ch_fr'];}
									if ($row['idch']== 7)
									{ $vfch7=$row['ul_ch_fr'];  $vfch7dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 8)
									{ $vfch8=$row['ul_ch_fr']; $vfch8dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 9)
									{ $vfch9=$row['ul_ch_fr']; $vfch9dl=$row['dl_ch_fr'];}
									if ($row['idch']== 10)
									{ $vfch10=$row['ul_ch_fr']; $vfch10dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 11)
									{ $vfch11=$row['ul_ch_fr']; $vfch11dl=$row['dl_ch_fr'];}

									if ($row['idch'] == 12)
									{ $vfch12=$row['ul_ch_fr']; $vfch12dl=$row['dl_ch_fr'];}
									if ($row['idch']== 13)
									{ $vfch13=$row['ul_ch_fr']; $vfch13dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 14)
									{ $vfch14=$row['ul_ch_fr']; $vfch14dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 15)
									{ $vfch15=$row['ul_ch_fr']; $vfch15dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 16)
									{ $vfch16=$row['ul_ch_fr']; $vfch16dl=$row['dl_ch_fr'];}
									if ($row['idch']== 17)
									{ $vfch17=$row['ul_ch_fr']; $vfch17dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 18)
									{ $vfch18=$row['ul_ch_fr']; $vfch18dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 19)
									{ $vfch19=$row['ul_ch_fr']; $vfch19dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 20)
									{ $vfch20=$row['ul_ch_fr']; $vfch20dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 21)
									{ $vfch21=$row['ul_ch_fr']; $vfch21dl=$row['dl_ch_fr'];}
									if ($row['idch']== 22)
									{ $vfch22=$row['ul_ch_fr']; $vfch22dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 23)
									{ $vfch23=$row['ul_ch_fr']; $vfch23dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 24)
									{ $vfch24=$row['ul_ch_fr']; $vfch24dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 25)
									{ $vfch25=$row['ul_ch_fr']; $vfch25dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 26)
									{ $vfch26=$row['ul_ch_fr']; $vfch26dl=$row['dl_ch_fr'];}
									if ($row['idch']== 27)
									{ $vfch27=$row['ul_ch_fr']; $vfch27dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 28)
									{ $vfch28=$row['ul_ch_fr']; $vfch28dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 29)
									{ $vfch29=$row['ul_ch_fr']; $vfch29dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 30)
									{ $vfch30=$row['ul_ch_fr']; $vfch30dl=$row['dl_ch_fr'];}
								
							
									
						
					}
					
					if ( $row['typedata'] =="DPX") 	
					{
							$unitcolumdl="<b>DL<hr>Rev: ".$row[1]."</b>";
							$unitcolumul="<b>UL<hr>Rev: ".$row[1]."</b>";
								if ($row['idch'] == 1)
									{ 
									  $vfdpxh1=$row['dpxhihgstart']." / ".$row['dpxhihgstop'];
									  $vfddpxl1=$row['dpxlowstart']." / ".$row['dpxlowstop'];
									}
								if ($row['idch'] == 2)
									{ 
									  $vfdpxh2=$row['dpxhihgstart']." / ".$row['dpxhihgstop'];
									  $vfddpxl2=$row['dpxlowstart']." / ".$row['dpxlowstop'];
									}
								if ($row['idch'] == 3)
									{ 
									  $vfdpxh3=$row['dpxhihgstart']." / ".$row['dpxhihgstop'];
									  $vfddpxl3=$row['dpxlowstart']." / ".$row['dpxlowstop'];
									}		
							
					}

					if ( $row['typedata'] =="UNIT") 	
					{
							$unitcolumdl="<b>DL<hr>Rev: ".$row[1]."</b>";
							$unitcolumul="<b>UL<hr>Rev: ".$row[1]."</b>";
							
							if ($row['dl_gain'] !="null")
							{
								$unitgaindl =$row['dl_gain'];	
							}
							else
							{
								$unitgaindl ="";
							}
							if ($row['ul_gain'] !="null")
							{
								$unitgainul =$row['ul_gain'];	
							}
							else
							{
								$unitgainul ="";	
							}
							
						
							
										 
									if ($row['idch'] == 1)
									{ 
									
									  $vfunit1=$row['unitulstart']." / ".$row['unitulstop'];
									  $vfunitdl1=$row['unitdlstart']." / ".$row['unitdlstop'];
									}
									if ($row['idch'] == 2)
									{ 
										$vfunit2=$row['unitulstart']." / ".$row['unitulstop'];
									  $vfunitdl2=$row['unitdlstart']." / ".$row['unitdlstop'];
									}
									if ($row['idch'] == 3)
									{ 
									   $vfunit3=$row['unitulstart']." / ".$row['unitulstop'];
									  $vfunitdl3=$row['unitdlstart']." / ".$row['unitdlstop'];
									}
										if ($row['idch'] == 4)
									{ 
									   $vfunit4=$row['unitulstart']." / ".$row['unitulstop'];
									  $vfunitdl4=$row['unitdlstart']." / ".$row['unitdlstop'];
									}
									if ($row['idch'] == 5)
									{ 
									   $vfunit5=$row['unitulstart']." / ".$row['unitulstop'];
									  $vfunitdl5=$row['unitdlstart']." / ".$row['unitdlstop'];
									}
									if ($row['idch'] == 6)
									{ 
									   $vfunit6=$row['unitulstart']." / ".$row['unitulstop'];
									  $vfunitdl6=$row['unitdlstart']." / ".$row['unitdlstop'];
									}
									if ($row['idch'] == 7)
									{ 
									   $vfunit7=$row['unitulstart']." / ".$row['unitulstop'];
									  $vfunitdl7=$row['unitdlstart']." / ".$row['unitdlstop'];
									}
									if ($row['idch'] == 8)
									{ 
									   $vfunit8=$row['unitulstart']." / ".$row['unitulstop'];
									  $vfunitdl8=$row['unitdlstart']." / ".$row['unitdlstop'];
									}
									if ($row['idch'] == 9)
									{ 
									   $vfunit9=$row['unitulstart']." / ".$row['unitulstop'];
									  $vfunitdl9=$row['unitdlstart']." / ".$row['unitdlstop'];
									}
									if ($row['idch'] == 10)
									{ 
									   $vfunit10=$row['unitulstart']." / ".$row['unitulstop'];
									  $vfunitdl10=$row['unitdlstart']." / ".$row['unitdlstop'];
									}
									
					}					
			
			
			
				}
			else
				{
						//agregar x cada cambio de rEV
							$return_arr_uldl_subband[] = array(
									 "BandRev"=> $unitcolumdl,								
									 "Freq [0]"	=> $vfdpxh1,	 
									 "Freq [1]"	=> $vfdpxh2,	 
									 "Freq [2]"	=> $vfdpxh3,	 
									 "Freq [3]"	=> $vfdpxh4,	 
									 "Freq [4]"	=> $vfdpxh5,	 
									 "Freq [5]"	=> $vfdpxh6,	 
									 "Freq [6]"	=>  $vfdpxh7,							
									 "Freq [7]"	=>  $vfdpxh8,			
									 "Freq [8]"	=>  $vfdpxh9,			
									 "Freq [9]"	=> $vfdpxh10,
									 "Freq [10]"	=> $vfdpxh11,
									"Freq [11]"	=> $vfdpxh12,
									"Freq [12]"	=> $vfdpxh13,
									"Freq [13]"	=> $vfdpxh14,
									"Freq [14]"	=> $vfdpxh15,
									"Freq [15]"	=> $vfdpxh16,
									"Freq [16]"	=> $vfdpxh17,
									"Freq [17]"	=> $vfdpxh18,
									"Freq [18]"	=> $vfdpxhd9,
									"Freq [19]"	=> $vfdpxhd10
									 );	
									 
									 $return_arr_uldl_subband[] = array(
									 "BandRev"=> $unitcolumul,								
									 "Freq [0]"	=> $vfddpxl1,	 
									 "Freq [1]"	=> $vfddpxl2,	 
									 "Freq [2]"	=> $vfddpxl3,	 
									 "Freq [3]"	=> $vfddpxl4,	 
									 "Freq [4]"	=> $vfddpxl5,	 
									 "Freq [5]"	=> $vfddpxl6,	 
									 "Freq [6]"	=>  $vfddpxl7,							
									 "Freq [7]"	=>  $vfddpxl8,			
									 "Freq [8]"	=>  $vfddpxl9,			
									 "Freq [9]"	=> $vfddpxl10,
									 "Freq [10]"	=> $vfddpxl11,
									"Freq [11]"	=> $vfddpxl12,	
									"Freq [12]"	=> $vfddpxl13,
									"Freq [13]"	=> $vfddpxl14,
									"Freq [14]"	=> $vfddpxl15,
									"Freq [15]"	=> $vfddpxl16,
									"Freq [16]"	=> $vfddpxl17,
									"Freq [17]"	=> $vfddpxl18,
									"Freq [18]"	=> $vfddpxld9,
									"Freq [19]"	=> $vfddpxld10
									 );	
					
							$return_arr_uldl[] = array(
									 "BandRev"=> $unitcolumdl,	
									 "Gain" => $unitgaindl,
									 "Max Pwr"=> $maxunitgaindl,
									  "Freq [0]"	=> $vfunitdl1,	 
									 "Freq [1]"	=> $vfunitdl2,	 
									 "Freq [2]"	=> $vfunitdl3,	 
									 "Freq [3]"	=> $vfunitdl4,	 
									 "Freq [4]"	=> $vfunitdl5,	 
									 "Freq [5]"	=> $vfunitdl6,	 
									 "Freq [6]"	=>  $vfunitdl7,							
									 "Freq [7]"	=>  $vfunitdl8,			
									 "Freq [8]"	=>  $vfunitdl9,			
									 "Freq [9]"	=> $vfunitdl10,
									 "Freq [10]"	=> $vfunitdl11,
									"Freq [11]"	=> $vfunitdl12,
									"Freq [12]"	=> $vfunitdl13,
									"Freq [13]"	=> $vfunitdl14,
									"Freq [14]"	=> $vfunitdl15,
									"Freq [15]"	=> $vfunitdl16,
									"Freq [16]"	=> $vfunitdl17,
									"Freq [17]"	=> $vfunitdl18,
									"Freq [18]"	=> $vfunitdl19,
									"Freq [19]"	=> $vfunitdl20
									 );	
									 
									 $return_arr_uldl[] = array(
										"BandRev"=> $unitcolumul,
										"Gain" => $unitgainul,
										"Max Pwr"=> $maxunitgainul,
										"Freq [0]"	=> $vfunit1,	 
										"Freq [1]"	=> $vfunit2,	 
										"Freq [2]"	=> $vfunit3,	 
										"Freq [3]"	=> $vfunit4,	 
										"Freq [4]"	=> $vfunit5,	 
										"Freq [5]"	=> $vfunit6,	 
										"Freq [6]"	=>  $vfunit7,							
										"Freq [7]"	=>  $vfunit8,			
										"Freq [8]"	=>  $vfunit9,			
										"Freq [9]"	=> $vfunit10,
										"Freq [10]"	=> $vfunit11,
									   "Freq [11]"	=> $vfunit12,
									   "Freq [12]"	=> $vfunit13,
									   "Freq [13]"	=> $vfunit14,
									   "Freq [14]"	=> $vfunit15,
									   "Freq [15]"	=> $vfunit16,
									   "Freq [16]"	=> $vfunit17,
									   "Freq [17]"	=> $vfunit18,
									   "Freq [18]"	=> $vfunitd9,
									   "Freq [19]"	=> $vfunitd0
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
						/////fin por cada rev..		
							$unitcolumdl="<b>DL<hr>Rev: MM</b>";
							$unitcolumul="<b>UL<hr>Rev: MM</b>";	
							$unitcolumdl="<b>DL<hr>Rev: ".$row[1]."</b>";
							$unitcolumul="<b>UL<hr>Rev: ".$row[1]."</b>";	

	//////////test
					if ( $row['typedata'] =="CHANNEL") 	
					{
								$columnul="<b>UL<hr>Rev: ".$row[1]."</b>";
								$columdl="<b>DL<hr>Rev: ".$row[1]."</b>";
				
														
									if ($row['idch'] == 1)
									{ $vfch1=$row['ul_ch_fr']; $vfch1dl=$row['dl_ch_fr'];}
									if ($row['idch']== 2)
									{ $vfch2=$row['ul_ch_fr']; $vfch2dl=$row['dl_ch_fr'];}
									if ($row['idch']== 3)
									{ $vfch3=$row['ul_ch_fr']; $vfch3dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 4)
									{ $vfch4=$row['ul_ch_fr'];$vfch4dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 5)
									{ $vfch5=$row['ul_ch_fr'];$vfch5dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 6)
									{ $vfch6=$row['ul_ch_fr'];$vfch6dl=$row['dl_ch_fr'];}
									if ($row['idch']== 7)
									{ $vfch7=$row['ul_ch_fr'];  $vfch7dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 8)
									{ $vfch8=$row['ul_ch_fr']; $vfch8dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 9)
									{ $vfch9=$row['ul_ch_fr']; $vfch9dl=$row['dl_ch_fr'];}
									if ($row['idch']== 10)
									{ $vfch10=$row['ul_ch_fr']; $vfch10dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 11)
									{ $vfch11=$row['ul_ch_fr']; $vfch11dl=$row['dl_ch_fr'];}

									if ($row['idch'] == 12)
									{ $vfch12=$row['ul_ch_fr']; $vfch12dl=$row['dl_ch_fr'];}
									if ($row['idch']== 13)
									{ $vfch13=$row['ul_ch_fr']; $vfch13dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 14)
									{ $vfch14=$row['ul_ch_fr']; $vfch14dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 15)
									{ $vfch15=$row['ul_ch_fr']; $vfch15dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 16)
									{ $vfch16=$row['ul_ch_fr']; $vfch16dl=$row['dl_ch_fr'];}
									if ($row['idch']== 17)
									{ $vfch17=$row['ul_ch_fr']; $vfch17dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 18)
									{ $vfch18=$row['ul_ch_fr']; $vfch18dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 19)
									{ $vfch19=$row['ul_ch_fr']; $vfch19dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 20)
									{ $vfch20=$row['ul_ch_fr']; $vfch20dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 21)
									{ $vfch21=$row['ul_ch_fr']; $vfch21dl=$row['dl_ch_fr'];}
									if ($row['idch']== 22)
									{ $vfch22=$row['ul_ch_fr']; $vfch22dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 23)
									{ $vfch23=$row['ul_ch_fr']; $vfch23dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 24)
									{ $vfch24=$row['ul_ch_fr']; $vfch24dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 25)
									{ $vfch25=$row['ul_ch_fr']; $vfch25dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 26)
									{ $vfch26=$row['ul_ch_fr']; $vfch26dl=$row['dl_ch_fr'];}
									if ($row['idch']== 27)
									{ $vfch27=$row['ul_ch_fr']; $vfch27dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 28)
									{ $vfch28=$row['ul_ch_fr']; $vfch28dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 29)
									{ $vfch29=$row['ul_ch_fr']; $vfch29dl=$row['dl_ch_fr'];}
									if ($row['idch'] == 30)
									{ $vfch30=$row['ul_ch_fr']; $vfch30dl=$row['dl_ch_fr'];}
								
							
									
						
					}
					
					if ( $row['typedata'] =="DPX") 	
					{
							$unitcolumdl="<b>DL<hr>Rev: ".$row[1]."</b>";
							$unitcolumul="<b>UL<hr>Rev: ".$row[1]."</b>";
								if ($row['idch'] == 1)
									{ 
									  $vfdpxh1=$row['dpxhihgstart']." / ".$row['dpxhihgstop'];
									  $vfddpxl1=$row['dpxlowstart']." / ".$row['dpxlowstop'];
									}
								if ($row['idch'] == 2)
									{ 
									  $vfdpxh2=$row['dpxhihgstart']." / ".$row['dpxhihgstop'];
									  $vfddpxl2=$row['dpxlowstart']." / ".$row['dpxlowstop'];
									}
								if ($row['idch'] == 3)
									{ 
									  $vfdpxh3=$row['dpxhihgstart']." / ".$row['dpxhihgstop'];
									  $vfddpxl3=$row['dpxlowstart']." / ".$row['dpxlowstop'];
									}		
							
					}

					if ( $row['typedata'] =="UNIT") 	
					{
							$unitcolumdl="<b>DL<hr>Rev: ".$row[1]."</b>";
							$unitcolumul="<b>UL<hr>Rev: ".$row[1]."</b>";
							
							if ($row['dl_gain'] !="null")
							{
								$unitgaindl =$row['dl_gain'];	
							}
							else
							{
								$unitgaindl ="";
							}
							if ($row['ul_gain'] !="null")
							{
								$unitgainul =$row['ul_gain'];	
							}
							else
							{
								$unitgainul ="";	
							}
							
						
							
										 
									if ($row['idch'] == 1)
									{ 
									
									  $vfunit1=$row['unitulstart']." / ".$row['unitulstop'];
									  $vfunitdl1=$row['unitdlstart']." / ".$row['unitdlstop'];
									}
									if ($row['idch'] == 2)
									{ 
										$vfunit2=$row['unitulstart']." / ".$row['unitulstop'];
									  $vfunitdl2=$row['unitdlstart']." / ".$row['unitdlstop'];
									}
									if ($row['idch'] == 3)
									{ 
									   $vfunit3=$row['unitulstart']." / ".$row['unitulstop'];
									  $vfunitdl3=$row['unitdlstart']." / ".$row['unitdlstop'];
									}
										if ($row['idch'] == 4)
									{ 
									   $vfunit4=$row['unitulstart']." / ".$row['unitulstop'];
									  $vfunitdl4=$row['unitdlstart']." / ".$row['unitdlstop'];
									}
									if ($row['idch'] == 5)
									{ 
									   $vfunit5=$row['unitulstart']." / ".$row['unitulstop'];
									  $vfunitdl5=$row['unitdlstart']." / ".$row['unitdlstop'];
									}
									if ($row['idch'] == 6)
									{ 
									   $vfunit6=$row['unitulstart']." / ".$row['unitulstop'];
									  $vfunitdl6=$row['unitdlstart']." / ".$row['unitdlstop'];
									}
									if ($row['idch'] == 7)
									{ 
									   $vfunit7=$row['unitulstart']." / ".$row['unitulstop'];
									  $vfunitdl7=$row['unitdlstart']." / ".$row['unitdlstop'];
									}
									if ($row['idch'] == 8)
									{ 
									   $vfunit8=$row['unitulstart']." / ".$row['unitulstop'];
									  $vfunitdl8=$row['unitdlstart']." / ".$row['unitdlstop'];
									}
									if ($row['idch'] == 9)
									{ 
									   $vfunit9=$row['unitulstart']." / ".$row['unitulstop'];
									  $vfunitdl9=$row['unitdlstart']." / ".$row['unitdlstop'];
									}
									if ($row['idch'] == 10)
									{ 
									   $vfunit10=$row['unitulstart']." / ".$row['unitulstop'];
									  $vfunitdl10=$row['unitdlstart']." / ".$row['unitdlstop'];
									}
									
					}	
	//// fin test 						
				}
				
			}  // Cierra IF de muestro 2 	
		}
	
	//fin list_show_ciu_sn_info_subband
	 //recorremos data de so_sp_ch
	
			if ($temprevision>1)
			{
				$return_arr_uldl_subband[] = array(
								 "BandRev"=> $unitcolumdl,								
								 "Freq [0]"	=> $vfdpxh1,	 
								 "Freq [1]"	=> $vfdpxh2,	 
								 "Freq [2]"	=> $vfdpxh3,	 
								 "Freq [3]"	=> $vfdpxh4,	 
								 "Freq [4]"	=> $vfdpxh5,	 
								 "Freq [5]"	=> $vfdpxh6,	 
								 "Freq [6]"	=>  $vfdpxh7,							
								 "Freq [7]"	=>  $vfdpxh8,			
								 "Freq [8]"	=>  $vfdpxh9,			
								 "Freq [9]"	=> $vfdpxh10,
								 "Freq [10]"	=> $vfdpxh11,
								"Freq [11]"	=> $vfdpxh12,
								"Freq [12]"	=> $vfdpxh13,
								"Freq [13]"	=> $vfdpxh14,
								"Freq [14]"	=> $vfdpxh15,
								"Freq [15]"	=> $vfdpxh16,
								"Freq [16]"	=> $vfdpxh17,
								"Freq [17]"	=> $vfdpxh18,
								"Freq [18]"	=> $vfdpxhd9,
								"Freq [19]"	=> $vfdpxhd10
								 );	
								 
								 $return_arr_uldl_subband[] = array(
								 "BandRev"=> $unitcolumul,								
								 "Freq [0]"	=> $vfddpxl1,	 
								 "Freq [1]"	=> $vfddpxl2,	 
								 "Freq [2]"	=> $vfddpxl3,	 
								 "Freq [3]"	=> $vfddpxl4,	 
								 "Freq [4]"	=> $vfddpxl5,	 
								 "Freq [5]"	=> $vfddpxl6,	 
								 "Freq [6]"	=>  $vfddpxl7,							
								 "Freq [7]"	=>  $vfddpxl8,			
								 "Freq [8]"	=>  $vfddpxl9,			
								 "Freq [9]"	=> $vfddpxl10,
								 "Freq [10]"	=> $vfddpxl11,
								"Freq [11]"	=> $vfddpxl12,	
								"Freq [12]"	=> $vfddpxl13,
								"Freq [13]"	=> $vfddpxl14,
								"Freq [14]"	=> $vfddpxl15,
								"Freq [15]"	=> $vfddpxl16,
								"Freq [16]"	=> $vfddpxl17,
								"Freq [17]"	=> $vfddpxl18,
								"Freq [18]"	=> $vfddpxld9,
								"Freq [19]"	=> $vfddpxld10
								 );	
						
							$return_arr_uldl[] = array(
								 "BandRev"=> $unitcolumdl,	
								 "Gain" => $unitgaindl,
								 "Max Pwr"=> $maxunitgaindl,
								  "Freq [0]"	=> $vfunitdl1,	 
								 "Freq [1]"	=> $vfunitdl2,	 
								 "Freq [2]"	=> $vfunitdl3,	 
								 "Freq [3]"	=> $vfunitdl4,	 
								 "Freq [4]"	=> $vfunitdl5,	 
								 "Freq [5]"	=> $vfunitdl6,	 
								 "Freq [6]"	=>  $vfunitdl7,							
								 "Freq [7]"	=>  $vfunitdl8,			
								 "Freq [8]"	=>  $vfunitdl9,			
								 "Freq [9]"	=> $vfunitdl10,
								 "Freq [10]"	=> $vfunitdl11,
								"Freq [11]"	=> $vfunitdl12,
								"Freq [12]"	=> $vfunitdl13,
								"Freq [13]"	=> $vfunitdl14,
								"Freq [14]"	=> $vfunitdl15,
								"Freq [15]"	=> $vfunitdl16,
								"Freq [16]"	=> $vfunitdl17,
								"Freq [17]"	=> $vfunitdl18,
								"Freq [18]"	=> $vfunitdl19,
								"Freq [19]"	=> $vfunitdl20
								 );	
								 $return_arr_uldl[] = array(
									"BandRev"=> $unitcolumul,
									"Gain" => $unitgainul,
									"Max Pwr"=> $maxunitgainul,
									"Freq [0]"	=> $vfunit1,	 
									"Freq [1]"	=> $vfunit2,	 
									"Freq [2]"	=> $vfunit3,	 
									"Freq [3]"	=> $vfunit4,	 
									"Freq [4]"	=> $vfunit5,	 
									"Freq [5]"	=> $vfunit6,	 
									"Freq [6]"	=>  $vfunit7,							
									"Freq [7]"	=>  $vfunit8,			
									"Freq [8]"	=>  $vfunit9,			
									"Freq [9]"	=> $vfunit10,
									"Freq [10]"	=> $vfunit11,
								   "Freq [11]"	=> $vfunit12,
								   "Freq [12]"	=> $vfunit13,
								   "Freq [13]"	=> $vfunit14,
								   "Freq [14]"	=> $vfunit15,
								   "Freq [15]"	=> $vfunit16,
								   "Freq [16]"	=> $vfunit17,
								   "Freq [17]"	=> $vfunit18,
								   "Freq [18]"	=> $vfunitd9,
								   "Freq [19]"	=> $vfunitd0
									);		
								 
		
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
	 			
		
//echo json_encode($return_arr_out);

//echo(json_encode(["gi"=>$return_arr,"lg"=>$return_arr_log, "ch"=>$return_arr_idch_uldl,"uldlsubband"=>$return_arr_uldl_subband,"uldl"=>$return_arr_uldl]));
echo(json_encode(["gi"=>$return_arr, "ch"=>$return_arr_idch_uldl,"lg"=>$return_arr_log,"uldlsubband"=>$return_arr_uldl_subband,"uldl"=>$return_arr_uldl]));
 		
 //echo json_encode($someArray);
 
 
 



?>

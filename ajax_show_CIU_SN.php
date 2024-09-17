<?php
 include("db_conect.php"); 
	include("funcionesstores.php"); 
	header('Content-Type: application/json');
	$query_lista = list_show_CIU_SN($_REQUEST['idsaleorders'],$_REQUEST['vciu']);
    $return_arr = array();
  					
	$data = $connect->query($query_lista)->fetchAll();						
//	echo $query_lista;
	$letrasbuscadas = array("/", ".", ",", "-", );

	foreach ($data as $row) {
			
					//$return_arr[] = array("sn" => $row[0],"ifdualband" => $row[1]
                    
					// por cada SO CIU Y SN y band		
						$tienemod=0;
						$query_lista = list_show_SO_CIU_SN( $_REQUEST['idsaleorders'],$_REQUEST['vciu'],$row[0]);
					//	echo "x dig".$query_lista."**********************";
					///	echo "x dig".$_REQUEST['idsaleorders']."**".$_REQUEST['vciu']."**".$row[0]."<br>";
						$data2 = $connect->query($query_lista)->fetchAll();						
						foreach ($data2 as $rowciu_sn) 
						{
							$tienemod=1;
							//$return_arr[] = array("sn" => $row[0],"ifdualband" => $row[1],"idband" => $rowciu_sn['idband'],"sn_modulo" => $rowciu_sn['sn_module'],"countdigm" => $rowciu_sn['countdigm'],"totalpassdig" => $rowciu_sn['totalpassdig']);
							//// Buscamos calibration							
							$query_lista2 = list_show_SO_CIU_SN_calib( $_REQUEST['idsaleorders'],$_REQUEST['vciu'],$row[0],$rowciu_sn['idband']);
							$tienemodcalib=0;
							//echo "xcalib ".$query_lista2."-----------";
						//	echo "xcalib ".$_REQUEST['idsaleorders']."**".$_REQUEST['vciu']."**".$row[0]."***".$rowciu_sn['idband']."<br>";;
							$data_calif = $connect->query($query_lista2)->fetchAll();						
							foreach ($data_calif as $rowciu_sn_dalib) 
							{
								$tienemodcalib=1;
								//$return_arr[] = array("sn" => $row[0],"ifdualband" => $row[1],"idband" => $rowciu_sn['idband'],	"sn_modulo" => $rowciu_sn['sn_module'],"countdigm" => $rowciu_sn['countdigm'],"totalpassdig" => $rowciu_sn['totalpassdig'],"sn_modulocalif" => $rowciu_sn_dalib['sn_modulecf'],"countdigmcalif" => $rowciu_sn_dalib['countdigmcalif'],"totalpassdigcalif" => $rowciu_sn_dalib['totalpasscalif']);
								
								///list_show_SO_CIU_SN_calibfinalchk
								$query_lista_fnchk = list_show_SO_CIU_SN_calibfinalchk( $_REQUEST['idsaleorders'],$_REQUEST['vciu'],$row[0],$rowciu_sn['idband']);
								$tienemodcalibfnchk=0;
								//echo "xfnchk ".$query_lista_fnchk;
								$data_califfnchk = $connect->query($query_lista_fnchk)->fetchAll();						
								foreach ($data_califfnchk as $rowciu_sn_calif_fnchk) 
								{
										
										$tienemodcalibfnchk=1;
										$query_lista_fnchk2da="SELECT iduniqueop from fas_tree_measure where  unitsn = '".$rowciu_sn['sn_module']."' and iduniquebranch like '001%' limit 2";
										
											$data_2dageneracion = $connect->query($query_lista_fnchk2da)->fetchAll();		
										foreach ($data_2dageneracion as $row2dageneracion) 
										{
											$tienecalib2dagenera="Y";
										}
										
										
										$return_arr[] = array("sn" => $row[0],"ifdualband" => $row[1],"idband" => $rowciu_sn['idband'],	"sn_modulo" => $rowciu_sn['sn_module'],"countdigm" => $rowciu_sn['countdigm'],"totalpassdig" => $rowciu_sn['totalpassdig'],"sn_modulocalif" => $rowciu_sn_dalib['sn_modulecf'],"countdigmcalif" => $rowciu_sn_dalib['countdigmcalif'],"totalpassdigcalif" => $rowciu_sn_dalib['totalpasscalif'],"sn_modulocaliffnchk" => $rowciu_sn_calif_fnchk['sn_modulecf'],"countdigmcaliffnchk" => $rowciu_sn_calif_fnchk['countdigmcalif'],"totalpassdigcaliffnchk" => $rowciu_sn_calif_fnchk['totalpasscalif'],"calib2dagener"=>$tienecalib2dagenera);
										
								}
								if ($tienemodcalibfnchk==0)
								{
										$tienecalib2dagenera="N";
									$return_arr[] = array("sn" => $row[0],"ifdualband" => $row[1],"idband" => $rowciu_sn['idband'],	"sn_modulo" => $rowciu_sn['sn_module'],"countdigm" => $rowciu_sn['countdigm'],"totalpassdig" => $rowciu_sn['totalpassdig'],"sn_modulocalif" => $rowciu_sn_dalib['sn_modulecf'],"countdigmcalif" => $rowciu_sn_dalib['countdigmcalif'],"totalpassdigcalif" => $rowciu_sn_dalib['totalpasscalif'],"sn_modulocaliffnchk" => "","countdigmcaliffnchk" => "","totalpassdigcaliffnchk" => "","calib2dagener"=>$tienecalib2dagenera);									
								}
								
							}
							if ($tienemodcalib==0)
							{
								//$return_arr[] = array("sn" => $row[0],"ifdualband" => $row[1],"idband" => $rowciu_sn['idband'],"sn_modulo" => $rowciu_sn['sn_module'],"countdigm" => $rowciu_sn['countdigm'],"totalpassdig" => $rowciu_sn['totalpassdig']);
								  $return_arr[] = array("sn" => $row[0],"ifdualband" => $row[1],"idband" => $rowciu_sn['idband'],	"sn_modulo" => $rowciu_sn['sn_module'],"countdigm" => $rowciu_sn['countdigm'],"totalpassdig" => $rowciu_sn['totalpassdig'],"sn_modulocalif" => "","countdigmcalif" => "","totalpassdigcalif" => "","sn_modulocaliffnchk" => "","countdigmcaliffnchk" => "","totalpassdigcaliffnchk" => "");									
							}
						
							
						
						}
						if ($tienemod==0)
						{
							//$return_arr[] = array("sn" => $row[0],"ifdualband" => $row[1],"idband" => "","sn_modulo" => "","countdigm" =>"","totalpassdig" => "");
							$return_arr[] = array("sn" => $row[0],"ifdualband" => $row[1],"idband" => "",	"sn_modulo" => "","countdigm" => "","totalpassdig" => "","sn_modulocalif" => "","countdigmcalif" => "","totalpassdigcalif" => "","sn_modulocaliffnchk" => "","countdigmcaliffnchk" => "","totalpassdigcaliffnchk" => "");									
						}
						
							
							
						
							
						
					
					
             
					
		//echo $row[0].",".$row[1];
	 }
	
	
					
 echo json_encode($return_arr);
 
 



?>
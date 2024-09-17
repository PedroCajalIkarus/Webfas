<?php
include("db_conect.php"); 
	include("funcionesstores.php"); 
	
 
		  function color_rand() {
 return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
 }
		 
$vanio=$_REQUEST['anio'];		 
$vmes=$_REQUEST['mes'];		 
$vidmemp=$_REQUEST['idempresa'];		 
					$query_lista_repor =" select * from fnt_select_runinfo_by_business_count_byscriptwithparam(".$vidmemp.",".$vmes.",".$vanio."); ";
	//$return_arr[]="";				
				//	echo $query_lista_repor ;
				//		$query_lista_repor =" select * from runinfodb limit 1; ";
					$resultadorepor = $connect->query($query_lista_repor);	
					$loslabels="";
					
					
					echo "";	
				//$loslabels="{";
					foreach ($resultadorepor as $rowreport) 
					{
					//	echo "<br>b:".$rowreport[0];
					 
						$arraydatos  = json_decode($rowreport[0], true);		
						$elcolorrandow = color_rand();

						$nomb= $arraydatos['nobmrescript']; 
						$diames =  implode(",",$arraydatos['diames']); 
						$valorxdia =  implode(",",$arraydatos['ccc']);
						$loslabels=$loslabels." <span class='mr-2'><i class='fas fa-square' style='color:$elcolorrandow;'></i>[".$nomb."]</span> ";
					//	$loslabels= " <span class='mr-2'><i class='fas fa-square text-primary'></i>[".$nomb."]</span> ";
						$losdatosamostrar =$losdatosamostrar.  "{label:'".$nomb."',fill: false,borderWidth : 2,lineTension  : 0,	spanGaps : true,borderColor  : '".$elcolorrandow."',	pointRadius : 3,pointHoverRadius : 7,pointColor: '#efefef',pointBackgroundColor: '#efefef',data : [".$valorxdia."] },";
						
					//	echo 	$losdatosamostrar ;
					
						$return_arr[] = array( $valorxdia);			
						$return_arrlabl[] = array($nomb );
					
					
					}	
			//	$loslabels=	$loslabels."}";
					//	echo "],	labels  : [".$diames."] ";
									
										$return_loslabels[] = array($loslabels );			
			
						
			//	 echo json_encode($return_arr);	
				echo(json_encode(["a"=>$losdatosamostrar,"b"=>$arraydatos['diames'],"c"=>$loslabels]));	
				//	 echo json_encode($return_arr);
					?>
					
	
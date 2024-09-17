<!DOCTYPE html>
<?php 

// Desactivar toda notificación de error
error_reporting(0);
// Notificar todos los errores de PHP (ver el registro de cambios)
//error_reporting(E_ALL);
 include("db_conectbypdf.php"); 
 
 	session_start();
	
 /*
  if(isset($_SESSION["timeout"])){
        // Calcular el tiempo de vida de la sesión (TTL = Time To Live)
	//	echo "***********hola".time() - $_SESSION["timeout"];
        $sessionTTL = time() - $_SESSION["timeout"];
        if($sessionTTL > $inactividad){
			session_unset();
            session_destroy();
            header("Location: http://".$ipservidorapache."/index.php");
        }
    }
	else
	{
			session_unset();
            session_destroy();
            header("Location: http://".$ipservidorapache."/index.php");
        
	}
	
	$status = $connect->getAttribute(PDO::ATTR_CONNECTION_STATUS);
	
	if ($status !="Connection OK; waiting to send.")
	{
	
		header("Location: http://".$ipservidorapache."/".$folderservidor."/errorconect.php");
		exit;
		
	}
	*/
?>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIPLEX</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- daterangepicker -->
   <link rel="stylesheet" href="plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
   <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="plugins/ion-rangeslider/css/ion.rangeSlider.css">
  
  <!-- AdminLTE css -->
  <link rel="stylesheet" href="dist/css/adminlte.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  
  <link href="css/tabulator_bootstrap4.css" rel="stylesheet">
  <link rel="shortcut icon" href="fiplexcirculo-01.ico" />
  
  <link rel="stylesheet" href="toastr.css">
  
 <link href="css/tabulator_bulma.css" rel="stylesheet">
 
  
    <link rel="stylesheet" href="cssfiplex.css">
	    <link rel="stylesheet" href="css/viewer.min.css">
		 <style>
		 
		 .containermarco {
    width: 98%;
     padding-right: 7.5px; 
     padding-left: 7.5px; 
     margin-right: auto; 
     margin-left: auto; 
	}

    .pictures {
      list-style: none;
      margin: 0;
      max-width: 30rem;
      padding: 0;
    }

    .pictures > li {
    /*  border: 1px solid transparent;
      float: left;
      height: calc(100% / 2);
      margin: 0 31px 0px 15px;
      overflow: hidden;
      width: calc(100% / 2);*/
    }

    .pictures > li > img {
      cursor: zoom-in;
      width: 100%;
    }
	.rowmm {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
     margin-right: -1.5px; 
     margin-left: -1.5px; 
}


.card {
    box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
    margin-bottom: 5px;
}

.card-title {
    float: left;
    font-size: 14px;
}

.irs-grid_marco_verde {
    background: #28a745;
}
.irs-grid_marco_amarillo {
    background: #ffc107;
}
.irs-grid_marco_rojo {
    background: #dc3545;
}


.divmarco {
	  margin-top: 17.5px; 
}


.tooltipmarco {
    background-color: #0053a1;
    color:  #ffffff;
    padding: 5px 10px;
    border-radius: 4px;
    font-size: 14px;
	 opacity: 0.9;
  }

  </style>
  
</head>
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->

<script src="toastr.min.js"></script>

<script src="licencefiplex_mm.js"></script>
<script src="licencefiplex1.js"></script>
<script src="js/jquery.inactivityTimeout.js"></script>

<script src="js/popperparacalibratio.min.js"></script>

<script src="plugins/chart.js/Chart.min.js"></script>

<script src="js/viewer.js"></script>
<form name="frma" id="frma">



<input type="hidden" name="uso" id="uso" value="0">
<body class="hold-transition sidebar-mini sidebar-collapse">

  <div class="">
  


<!-- Site wrapper -->
  <!-- Navbar -->
 
<?php
	$vparam_vnrounitsn = $_REQUEST['idsndib']; ///// "20000000fu";	

 $Vjd=0;
 $vtemp_idruninfo=0;
							
	//echo $sql."<br>";	
 $sql="
select fas_tree_measure.uldl, fas_tree_measure.band , idrununfo as idruninfo 
from fas_tree_measure 
inner join ( 
	SELECT DISTINCT uldl, band , MAX(datetime) as masfechaidruninfo 
	from fas_tree_measure 
	where  fas_tree_measure.iduniquebranch like '00E%' and 
	fas_tree_measure.unitsn = '".$vparam_vnrounitsn."' GROUP BY uldl,band order by uldl,band
		) as losmasejecutados 
		
		on fas_tree_measure.uldl = losmasejecutados.uldl and fas_tree_measure.band = losmasejecutados.band and 
		fas_tree_measure.datetime = losmasejecutados.masfechaidruninfo where fas_tree_measure.unitsn = '".$vparam_vnrounitsn."'";


//echo "<br>1er select<br>".$sql." -- ok<br>";	

							   $datacabez = $connect->query($sql)->fetchAll();
								$idtemp=0;
								$vejecucion = 1;
								  foreach ($datacabez as $rowheaders) 
								  {
									  
									 unset($arrayfreq);
					unset($array_finalchk_gain);
					unset($array_finalchk_pwr);
				    unset($array_finalchk_noisefigshow);
					 unset($Finalchk_imd_1);
					 unset($Finalchk_imd_2);
					 unset($Finalchk_imd_3);
					 unset($Finalchk_imd_4);
					 unset($Finalchk_imdfreq);
					 unset($arrayfreqpwr);
				 $freqlabel ="";
				 $array_finalchk_gaingrafico="";
				 $finalchk_gain_freqshow="";
				  $freqlabelpwr="";
				  unset(  $array_finalchk_pwr);

					$array_finalchk_pwrgrafico="";
					$finalchk_gain_freqshowpwr="";
					$lblfreqmostrargrafico ="";

					$array_finalchk_abajo1_freq="";
					$array_finalchk_abajo1_pwrin="";
					$array_finalchk_abajo1_gainnoagc="";
					$array_finalchk_abajo2_pwr="";

					$array_finalchk_abajo3_uclevel="";
					$array_finalchk_abajo4_ucchanc="";
					$array_finalchk_abajo5_ucbbagc= "";

					unset(  $Finalchk_imd_4);
					unset(  $Finalchk_imd_3 );
					unset(  $Finalchk_imd_2 );
					unset(  $Finalchk_imd_1);
					unset(  $Finalchk_imdfreq );

					unset(  $array_finalchk_noisefigshow);
					$array_finalchk_noisefig="";
					
					
									  $vparam_vnrounitsn = $_REQUEST['idsndib']; ///// "20000000fu";	
									$vparam_band = $rowheaders['band'];
									$vaparam_uldl = $rowheaders['uldl'];
									
									 $vtemp_idruninfo=$rowheaders['idruninfo'];
								    $vparam_idruninfo = $rowheaders['idruninfo'];
									
								  /// aca cargamos titulo
								  	if ($vaparam_uldl ==0)
										{
											$label_ULDL_amostrar ="Uplink";
										}
										else
										{
											$label_ULDL_amostrar ="Downlink";
										}
										if ($vparam_band ==0)
										{
											$label_band_amostrar ="700 FirstNet";
										}
										else
										{
											$label_band_amostrar ="800";
										}
										$vvv_sumanombregraf="mm".$vaparam_uldl.$vparam_band;
									echo "<hr><h6 class=' colorazulfiplex'>".$label_band_amostrar ." - ".$label_ULDL_amostrar."</h6><br>"; 
									// cada cada band buscamos las tablas..
									
									  $query_lista="SELECT fas_tree_measure.totalpass,  fas_tree_measure.iduniqueop,  fas_step.description as namebranch,  fas_tree_measure.iduniquebranch, fas_tree_measure.unitsn, fas_tree_measure.dibsn, fas_tree_measure.uldl, fas_tree_measure.band
										,fas_tree_measure.idrununfo
										from fas_tree_measure
										inner join fas_tree
										on fas_tree.iduniquebranch = fas_tree_measure.iduniquebranch
										inner join fas_step
										on fas_step.idfasstep = fas_tree.idfastrepson
										where  fas_tree_measure.iduniquebranch like '00E%' and uldl = ".$vaparam_uldl." and  band = ".$vparam_band." and  unitsn = '".$vparam_vnrounitsn."' and  idrununfo =".$vparam_idruninfo. " order by iduniqueop";
									//		echo "inicio:".$query_lista."<br>fin<br>";
									  $data = $connect->query($query_lista)->fetchAll();
										  foreach ($data as $row) 
										  {
											  
											  //AcceptDiB
											  if("00E" ==$row['iduniquebranch'])
											  {
												   $vpass = $row['totalpass'];
												   $v_iduniqueop = $row['iduniqueop'];
											  }
											  
												  ///AcceptDiB_Measure_Gain
											//	  echo "<br>-- **Antes del IF GAIN".$row['iduniquebranch'];
											  ///if(  $row['iduniquebranch']=="00E041044")
											  if (strcmp( $row['iduniquebranch'], "00E041044") === 0)
											  {
												  
											
												   
													 $query_lista5=" select distinct filename from fas_sameasures where iduniqueop = ".$row['iduniqueop']." order by filename";
												
													$datalsgp = $connect->query($query_lista5)->fetchAll();
													 foreach ($datalsgp as $rowlsgp1) 
														  {
															$Finalchk_gain_plot[]=$rowlsgp1['filename']; 
															
														  }	   
														   
														   
													$query_lista5=" select * from fas_singlemeasures where iduniqueop = ".$row['iduniqueop']." order by id_singlemeasure";
													//echo  "<br>///FinalCheck_Measures_Gain".$query_lista5;
												
													//echo  "<br>query gain:".$row['iduniquebranch']."-->".$query_lista5;
													$eliduniqoptooltop = $row['iduniqueop'];
													$datalsgp = $connect->query($query_lista5)->fetchAll();
													$indtooltip = 0;
													 foreach ($datalsgp as $rowlsgp1) 
														  {
																$arrayfreq[] =round($rowlsgp1['freq'],1); 
																$freqlabel =  $freqlabel."".round($rowlsgp1['freq'],1).",";
																$array_finalchk_gain[] =  $rowlsgp1['gainnoagc'];
																
																//vamos a ver los datos para el tool tip text fas_ucmeasure 
																$query_lista5a=" select * from fas_ucmeasures where iduniqueop = ".$eliduniqoptooltop." order by id_ucmeasures desc";
															//	echo $query_lista5a."<br>";
																$data_ptooltip = $connect->query($query_lista5a)->fetchAll();
																$vtmparrayind=0;
																 foreach ($data_ptooltip as $rowdatoltip) 
																	  {
																		  //aca armar un array de dos dimensiones
																		//  echo "<br>result".$rowdatoltip['pacurrent']."<br>";
																		 $array_finalchk_gain_tooltip_pwrin[$indtooltip][$vtmparrayind] =  $rowdatoltip['pwrin'];
																		 $array_finalchk_gain_tooltip_uclevel[$indtooltip][$vtmparrayind] = round( $rowdatoltip['uclevel'],2);
																		 $array_finalchk_gain_tooltip_ucchagc[$indtooltip][$vtmparrayind] =  $rowdatoltip['ucchagc'];
																		 $array_finalchk_gain_tooltip_ucbbagc[$indtooltip][$vtmparrayind] =  $rowdatoltip['ucbbagc'];
																		 $array_finalchk_gain_tooltip_ucoutputpwr[$indtooltip][$vtmparrayind] =  round($rowdatoltip['ucoutputpwr'],2);
																		 $array_finalchk_gain_tooltip_uctemperature[$indtooltip][$vtmparrayind] = round( $rowdatoltip['uctemperature'],2);
																		 $array_finalchk_gain_tooltip_pacurrent[$indtooltip][$vtmparrayind] =  $rowdatoltip['pacurrent'];
																		 $vtmparrayind = $vtmparrayind+ 1;
																	  }
																//fin carga de variable fas_ucmeasure 
															//	echo "*muestra 0 -0:::[". $array_finalchk_gain_tooltip_pwrin[0][0]."]";
															//	echo "*muestra 1 -1:::[". $array_finalchk_gain_tooltip_pwrin[0][1]."]";
																//echo "*/0-0/*".$array_finalchk_gain_tooltip_pwrin[0][0];
																//echo "uclevel*/0-0/*".$array_finalchk_gain_tooltip_uclevel[0][0];
																$indtooltip = $indtooltip + 1;
																
																$array_finalchk_gaingrafico=  $array_finalchk_gaingrafico."".$rowlsgp1['gainnoagc'].",";										
																$finalchk_gain_freqshow=round($rowlsgp1['freq'],1);  
														
															
														  }
													  
											  }
											  
											 
											  
												///AcceptDiB_Measure_MaxPower
												$mi = 0;
												//  echo "<br>-- **Antes del IF MAX PWR::".$row['iduniquebranch'];
												   if (strcmp( $row['iduniquebranch'], "00E041045") === 0)											  
											  {
												
													$query_lista5=" select distinct filename from fas_sameasures where iduniqueop = ".$row['iduniqueop']." order by filename";
													$datalsgp = $connect->query($query_lista5)->fetchAll();
													//echo  "<br>query Maxpwr:".$row['iduniquebranch']."-->".$query_lista5;
												
													 foreach ($datalsgp as $rowlsgp1) 
														  {
																$Finalchk_maxpwr_plot[]=$rowlsgp1['filename']; 
														  }	 
														  
														   $query_lista6=" select * from fas_mkrmeasures where iduniqueop = ".$row['iduniqueop']." order by id_mkrmeasures";
														  // echo $query_lista6;
														$datalsgp = $connect->query($query_lista6)->fetchAll();
															$mi = 0;
															$eliduniqoptooltop = $row['iduniqueop'];
													$indtooltip = 0;
														foreach ($datalsgp as $rowlsgp6) 
														  {
															
															   $arrayfreqpwr[] =round($rowlsgp6['freq'],1); 
																$freqlabelpwr =  $freqlabelpwr."".round($rowlsgp6['freq'],1).",";
																$array_finalchk_pwr[] =  $rowlsgp6['pwr'];
																$array_finalchk_pwrgrafico=  $array_finalchk_pwrgrafico."".$rowlsgp6['pwr'].",";										
																$finalchk_gain_freqshowpwr=round($rowlsgp6['freq'],1);  
																
																//aca buscamos los datos para el tooltip
																//vamos a ver los datos para el tool tip text fas_ucmeasure 
																$query_lista5b=" select * from fas_ucmeasures where iduniqueop = ".$eliduniqoptooltop." order by id_ucmeasures desc";
														//		echo "AMX PWR::".$query_lista5b."<br>";
																$data_ptooltipmp = $connect->query($query_lista5b)->fetchAll();
																$vtmparrayind=0;
																 foreach ($data_ptooltipmp as $rowdatoltipmp) 
																	  {
																		  //aca armar un array de dos dimensiones
																		//  echo "<br>result".$rowdatoltip['pacurrent']."<br>";
																		 $array_finalchk_maxpwr_tooltip_pwrin[$indtooltip][$vtmparrayind] =  $rowdatoltipmp['pwrin'];
																		 $array_finalchk_maxpwr_tooltip_uclevel[$indtooltip][$vtmparrayind] = round( $rowdatoltipmp['uclevel'],2);
																		 $array_finalchk_maxpwr_tooltip_ucchagc[$indtooltip][$vtmparrayind] =  $rowdatoltipmp['ucchagc'];
																		 $array_finalchk_maxpwr_tooltip_ucbbagc[$indtooltip][$vtmparrayind] =  $rowdatoltipmp['ucbbagc'];
																		 $array_finalchk_maxpwr_tooltip_ucoutputpwr[$indtooltip][$vtmparrayind] =  round($rowdatoltipmp['ucoutputpwr'],2);
																		 $array_finalchk_maxpwr_tooltip_uctemperature[$indtooltip][$vtmparrayind] = round( $rowdatoltipmp['uctemperature'],2);
																		 $array_finalchk_maxpwr_tooltip_pacurrent[$indtooltip][$vtmparrayind] =  $rowdatoltipmp['pacurrent'];
																		 $vtmparrayind = $vtmparrayind+ 1;
																	  }
																$indtooltip  = $indtooltip +  1;
														
																
																if($mi==10)
																{
																	break;
																}
																$mi=$mi+1;
														  }
													  
											  }
											  
											
											
										
										  }
									//
									?>
									  <table class="table table-sm table-hover table-striped table-bordered text-center textotabla10">
                
                     <thead class="thead-dark">
                    <tr>
                      <th class="table-dark text-left">Freq - [MHz]</th>
					  <?php
					  $mi=0;
					   foreach($arrayfreq as $fec) 
							{
								echo "<th>" . round($fec,3) ."</th>";
								$mi=$mi+1;
								if($mi==11)
								{
									//break;
								}
							}
					?>                     
                    </tr>
                  </thead>
                  <tbody>
				  	<tr>
                      <td class="table-dark text-left">Gain</td>
                      <?php
					   $mi=0;			   
					   
					   foreach($array_finalchk_gain as $leveldat) 
							{
								echo "<td> <a href='#' class='tooltipmarcolink".$mi."' name='link0' id='link0' onmouseout='ocultar_tooltip(".$mi.")' onmouseover='mostrar_tooltip(".$mi.")' onclick=abrirgaleria('imgma$mi')>" .round($leveldat,2) . "</a>
								<div id='tooltipfreq".$mi."' name='tooltipfreq".$mi."' class='d-none tooltipmarco text-left' role='tooltip'>
								
<table class=' table-sm text-left texto10' border='0' style='table, tr, td, th {
     border: 0;
}'>
	<tr>
		<td class='text-left'><b>Pwr In</b></td>
		<td class='text-left'>".$array_finalchk_gain_tooltip_pwrin[$mi][$mi]." [dBm]</td>
		<td>&nbsp;&nbsp;</td>
		<td class='text-left'><b>FPGA Pwr Read</b></td>
		<td class='text-left'>".$array_finalchk_gain_tooltip_uclevel[$mi][$mi]." [dBm]</td>
		<td>&nbsp;&nbsp;</td>
		<td class='text-left'><b>Ch AGC</b></td>
		<td class='text-left'>".$array_finalchk_gain_tooltip_ucchagc[$mi][$mi]." [dB]</td>
	</tr>
		<tr>
		<td class='text-left'><b>BB AGC</b></td>
		<td class='text-left'>".$array_finalchk_gain_tooltip_ucbbagc[$mi][$mi]." [dB]</td>
	<td>&nbsp;&nbsp;</td>
		<td class='text-left'><b>uC OutputPwr</b></td>
		<td class='text-left'>".$array_finalchk_gain_tooltip_ucoutputpwr[$mi][$mi]." [dBm]</td>
	<td>&nbsp;&nbsp;</td>
		<td class='text-left'><b>Temperature</b></td>
		<td class='text-left'>".$array_finalchk_gain_tooltip_uctemperature[$mi][$mi]." [C]</td>
	</tr>
		<tr>
		<td class='text-left'><b>PACurrent</b></td>
		<td class='text-left'>".$array_finalchk_gain_tooltip_pacurrent[$mi][$mi]." [mA]</td>
	</tr>
</table>
								
									
								
								</div>
								</td>";
								$mi=$mi+1;
								if($mi==11)
								{
									//break;
								}
							}
					?>   		  					  
                    </tr> 	
					 	<tr>
                      <td class="table-dark text-left">Max Pwr</td>
                      <?php
					     $minombrenf = $mi;
					   $mi=0;
					   foreach($array_finalchk_pwr as $leveldat) 
							{
								//echo "<td>" . $leveldat . "</td>";
								
								
								echo "<td> <a href='#' class='tooltipmarcolink".$minombrenf."' onclick=abrirgaleria('imgmb$mi') onmouseout='ocultar_tooltip(".$minombrenf.")' onmouseover='mostrar_tooltip(".$minombrenf.")' >" . $leveldat . "</a>
									<div id='tooltipfreq".$minombrenf."' name='tooltipfreq".$minombrenf."' class='d-none tooltipmarco text-left' role='tooltip'>
								
<table class=' table-sm text-left texto10' border='0' style='table, tr, td, th {
     border: 0;
}'>
	<tr>
		<td class='text-left'><b>Pwr In</b></td>
		<td class='text-left'>".$array_finalchk_maxpwr_tooltip_pwrin[$mi][$mi]." [dBm]</td>
		<td>&nbsp;&nbsp;</td>
		<td class='text-left'><b>FPGA Pwr Read</b></td>
		<td class='text-left'>".$array_finalchk_maxpwr_tooltip_uclevel[$mi][$mi]." [dBm]</td>
		<td>&nbsp;&nbsp;</td>
		<td class='text-left'><b>Ch AGC</b></td>
		<td class='text-left'>".$array_finalchk_maxpwr_tooltip_ucchagc[$mi][$mi]." [dB]</td>
	</tr>
		<tr>
		<td class='text-left'><b>BB AGC</b></td>
		<td class='text-left'>".$array_finalchk_maxpwr_tooltip_ucbbagc[$mi][$mi]." [dB]</td>
	<td>&nbsp;&nbsp;</td>
		<td class='text-left'><b>uC OutputPwr</b></td>
		<td class='text-left'>".$array_finalchk_maxpwr_tooltip_ucoutputpwr[$mi][$mi]." [dBm]</td>
	<td>&nbsp;&nbsp;</td>
		<td class='text-left'><b>Temperature</b></td>
		<td class='text-left'>".$array_finalchk_maxpwr_tooltip_uctemperature[$mi][$mi]." [C]</td>
	</tr>
		<tr>
		<td class='text-left'><b>PACurrent</b></td>
		<td class='text-left'>".$array_finalchk_maxpwr_tooltip_pacurrent[$mi][$mi]." [mA]</td>
	</tr>
</table>
								
									
								
								</div>
								</td>";
								$mi=$mi+1;
									$minombrenf=$minombrenf+1;
								if($mi==11)
								{
									//break;
								}
							}
					?>   		  					  
                    </tr> 
					</table>
						<table style="width: 680px;font-size: 10pt;text-align: center;border-top: 0px solid black;border-right: 0px solid black;border-left: 0px solid black; border-bottom: 0px solid black;">
        <tr>
			<td style="width:340px;height:190px;">Gain       
			<canvas id="salesCharttxripple<?php echo $vvv_sumanombregraf; ?>" width="100px" height="100px" style="height: 100;width:100"></canvas>
		</td>
			<td style="width:340px;height:190px;">Max Power
		<canvas id="salesChartpowers<?php echo $vvv_sumanombregraf; ?>" width="100px" height="100px" style="height: 100;width:100"></canvas>
		</td>
		</tr>
		</table>
			 <div id="idocultargalleria" class="d-none">
					   <div id="galley1">
								  <ul class="pictures">
							<?php
								  $vt=0;
									  foreach ($Finalchk_maxpwr_plot as $rowd) 
											  {
												  if ($vt ==0)
													{
												  ?>
												<li>
													<img id="imgmb<?php echo $vt; ?>" name="imgmb<?php echo $vt; ?>"  data-original="../plotsimg/<?php echo trim($rowd);?>.png" src="../plotsimg/<?php echo trim($rowd);?>.png" width="10%"> 
													
												</li>
												  <?php
													}
													else
													{
														  ?>
														<li>
															<img  id="imgmb<?php echo $vt; ?>" name="imgmb<?php echo $vt; ?>" data-original="../plotsimg/<?php echo trim($rowd);?>.png" src="../plotsimg/<?php echo trim($rowd);?>.png" width="10%" class="d-none" > 
															
														</li>
												  <?php
													}
												  $vt= $vt + 1;
												  if ($vt==11)
												  {
													//  break;
												  }
											
											  }
											?>

								  </ul>
								</div>
				</div>
				  <div id="idocultargalleria" class="d-none">
					   <div id="galley">
								  <ul class="pictures">
							<?php
								  $vt=0;
									  foreach ($Finalchk_gain_plot as $rowd) 
											  {
												  if ($vt ==0)
													{
												  ?>
												<li>
													<img id="imgma<?php echo $vt; ?>" name="imgma<?php echo $vt; ?>"  data-original="../plotsimg/<?php echo trim($rowd);?>.png" src="../plotsimg/<?php echo trim($rowd);?>.png" width="10%"> 
													
												</li>
												  <?php
													}
													else
													{
														  ?>
														<li>
															<img id="imgma<?php echo $vt; ?>" name="imgma<?php echo $vt; ?>" data-original="../plotsimg/<?php echo trim($rowd);?>.png" src="../plotsimg/<?php echo trim($rowd);?>.png" width="10%" class="d-none" > 
															
														</li>
												  <?php
													}
												  $vt= $vt + 1;
												  if ($vt==11)
												  {
													//  break;
												  }
											
											  }
											?>

								  </ul>
								</div>
				</div>

<script type="text/javascript">

		
		var salesChart_finalchkmaxpowers = $('#salesChartpowers<?php echo $vvv_sumanombregraf; ?>').get(0).getContext('2d'); 
		var salesChart_finalchkgain = $('#salesCharttxripple<?php echo $vvv_sumanombregraf; ?>').get(0).getContext('2d');	  
	
		/*var salesChart_finalgraf1 = $('#graficoabajo1<?php echo $vvv_sumanombregraf; ?>').get(0).getContext('2d'); 
		var salesChart_finalgraf2 = $('#graficoabajo2<?php echo $vvv_sumanombregraf; ?>').get(0).getContext('2d'); 
		var salesChart_finalgraf3 = $('#graficoabajo3<?php echo $vvv_sumanombregraf; ?>').get(0).getContext('2d'); 
		var salesChart_finalgraf4 = $('#graficoabajo4<?php echo $vvv_sumanombregraf; ?>').get(0).getContext('2d'); 
		var salesChart_finalgraf5 = $('#graficoabajo5<?php echo $vvv_sumanombregraf; ?>').get(0).getContext('2d'); 
	*/

  window.addEventListener('DOMContentLoaded', function () {
      var galley = document.getElementById('galley');
      var viewer = new Viewer(galley, {
        url: 'data-original',
        title: function (image) {
          return image.alt + ' (' + (this.index + 1) + '/' + this.length + ')';
        },
      });
    });
	
 	 window.addEventListener('DOMContentLoaded', function () {
      var galley = document.getElementById('galley1');
      var viewer = new Viewer(galley, {
        url: 'data-original',
        title: function (image) {
          return image.alt + ' (' + (this.index + 1) + '/' + this.length + ')';
        },
      });
    });
	
		window.addEventListener('DOMContentLoaded', function () {
      var galley = document.getElementById('galley2');
      var viewer = new Viewer(galley, {
        url: 'data-original',
        title: function (image) {
          return image.alt + ' (' + (this.index + 1) + '/' + this.length + ')';
        },
      });
    });
	
		window.addEventListener('DOMContentLoaded', function () {
      var galley = document.getElementById('galley4');
      var viewer = new Viewer(galley, {
        url: 'data-original',
        title: function (image) {
          return image.alt + ' (' + (this.index + 1) + '/' + this.length + ')';
        },
      });
    });
  
    var salesChartDatatotalesGain = {
    labels  : [<?php echo  $freqlabel; ?>],
    datasets: [
	 
	   {
        label               : 'Equalized',		
	     backgroundColor     : 'rgba(60,141,188,0.3)',
        borderColor         : 'rgba(60,141,188,1)',
        pointRadius          : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
     	 data          :[<?php echo  $array_finalchk_gaingrafico;?>]
      },
    ]
  };
  
   var salesChartDatalpowees = {
    labels  : [<?php echo  $freqlabelpwr;?>],
    datasets: [
	
	   {
       label               : 'Equalized',		
	     backgroundColor     : 'rgba(60,141,188,0.3)',
        borderColor         : 'rgba(60,141,188,1)',
        pointRadius          : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',	
     	 data          :[<?php echo  $array_finalchk_pwrgrafico;?>]
      },
    ]
  }
;

  
    var salesChartOptions = {
    maintainAspectRatio : false,
    responsive : true,	
    legend: {
      display: false
    },
	
    scales: {
      xAxes: [{
        gridLines : {
          display : true,		 
        }
		
	
      }],
      yAxes: [{
        gridLines : {
          display : true,
		 
        },
		 ticks: {
                   
				    suggestedMin: 0,
                    suggestedMax: 30
               }
	
		
      }]
    }
  }
  
  

  
   var optionesbasicasgrafico= {
    maintainAspectRatio : false,
    responsive : true,	
    legend: {
      display: false
    },
	
    scales: {
      xAxes: [{
        gridLines : {
          display : true,		 
        }
		
	
      }],
      yAxes: [{
        gridLines : {
          display : true,
		 
        }				
      }]
    }
  }
  
  
     var salesChartOptionsmaxpwr = {
    maintainAspectRatio : false,
    responsive : true,	
    legend: {
      display: false
    },
	
    scales: {
      xAxes: [{
        gridLines : {
          display : true,		 
        }
		
	
      }],
      yAxes: [{
        gridLines : {
          display : true,
		 
        },
		 ticks: {
                   
				    suggestedMin: -50,
                    suggestedMax: -10
               },
			    plugins: {
            zoom: {
                // Container for pan options
                pan: {
                    // Boolean to enable panning
                    enabled: true,

                    // Panning directions. Remove the appropriate direction to disable 
                    // Eg. 'y' would only allow panning in the y direction
                    mode: 'xy'
                },

                // Container for zoom options
                zoom: {
                    // Boolean to enable zooming
                    enabled: true,

                    // Zooming directions. Remove the appropriate direction to disable 
                    // Eg. 'y' would only allow zooming in the y direction
                    mode: 'xy',
                }
            }
        }
	
		
      }]
    }
  }
	
	
	
	  var salesChart3 = new Chart(salesChart_finalchkmaxpowers, { 
      type: 'line', 	
      data: salesChartDatalpowees, 	 
      options: salesChartOptionsmaxpwr
    });
	
	  var salesChart4 = new Chart(salesChart_finalchkgain, { 
      type: 'line', 	
      data: salesChartDatatotalesGain, 	 
      options: salesChartOptions
    });
	
	

</script>
									<?php
									
								  }
								  
								  
								  // fin titulo	

?>


</body>



<script type="text/javascript">


	$( document ).ready(function() {
		
		/*//Inicio mostrar hora live
		 var interval = setInterval(function() {
			 
        var momentNow = moment();
		var newYork    = momentNow.tz('America/New_York').format('ha z');
        $('#date-part').html(momentNow.format('YYYY/MM/DD') 	  );
        $('#time-part').html(momentNow.format('hh:mm:ss'));
		}, 100);
		//FIN mostrar hora live*/
			console.log( "ready!" );
			$('#msjwaitline ').hide();
			$('#divscrolllog').show(); 
			$('#p-b0').hide();
			$('#p-b0').CardWidget('toggle');		
			$("#detallelog").hide();
			$("#detallelog").text("");
			$("#msjwait").hide();			

				toastr.options = {
				  "closeButton": false,
				  "debug": false,
				  "newestOnTop": false,
				  "progressBar": true,
				  "positionClass": "toast-bottom-right",
				  "preventDuplicates": false,
				  "onclick": null,
				  "showDuration": "300",
				  "hideDuration": "1000",
				  "timeOut": "5000",
				  "extendedTimeOut": "1000",
				  "showEasing": "swing",
				  "hideEasing": "linear",
				  "showMethod": "fadeIn",
				  "hideMethod": "fadeOut"
				};				
			
		
  
	});
	
	
	  window.addEventListener('DOMContentLoaded', function () {
      var galley = document.getElementById('galley');
      var viewer = new Viewer(galley, {
        url: 'data-original',
        title: function (image) {
          return image.alt + ' (' + (this.index + 1) + '/' + this.length + ')';
        },
      });
    });
	
 	 window.addEventListener('DOMContentLoaded', function () {
      var galley = document.getElementById('galley1');
      var viewer = new Viewer(galley, {
        url: 'data-original',
        title: function (image) {
          return image.alt + ' (' + (this.index + 1) + '/' + this.length + ')';
        },
      });
    });
	
		window.addEventListener('DOMContentLoaded', function () {
      var galley = document.getElementById('galley2');
      var viewer = new Viewer(galley, {
        url: 'data-original',
        title: function (image) {
          return image.alt + ' (' + (this.index + 1) + '/' + this.length + ')';
        },
      });
    });
	
		window.addEventListener('DOMContentLoaded', function () {
      var galley = document.getElementById('galley4');
      var viewer = new Viewer(galley, {
        url: 'data-original',
        title: function (image) {
          return image.alt + ' (' + (this.index + 1) + '/' + this.length + ')';
        },
      });
    });
	
	function abrirgaleria(qimgsendclick)
{
	document.getElementById(qimgsendclick).click();
}

function ocultar_tooltip(iddivamostrar)
{
	  $('#tooltipfreq'+iddivamostrar).addClass('d-none');
}

function mostrar_tooltip(iddivamostrar)
{

			  const reference = document.querySelector('.tooltipmarcolink'+iddivamostrar);
			const popper = document.querySelector('#tooltipfreq'+iddivamostrar);

	//  var button = document.querySelector('#link'+iddivamostrar);
  //var tooltip = document.querySelector('#tooltipfreq'+iddivamostrar);
  


 Popper.createPopper(reference , popper , {
    placement: 'right',
  });
  
  $('#tooltipfreq'+iddivamostrar).removeClass('d-none');
 
}
	
	
 $('#cmbiditeracion').on('change', function() {
							//  alert( this.value );
						   window.location = this.value;
							})

</script>
</html>
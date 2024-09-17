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
		
<form name="frma" id="frma">

  <div class="">
  			 <table class='table table-sm table-bordered textotabla10'>
								  <thead><tr class="thead-dark"><th>Ref: </th><th>Status: Gain</th><th>Status: MaxPower</th></tr></thead>
								
	
<?php
	$vparam_vnrounitsn = $_REQUEST['idsndib']; ///// "20000000fu";	
	
	
	//////CUADRO RESUMEN ///////////////////////////////////////////////////
	 $sql="	select  fnt_select_fascalibration_componets_approved('".$vparam_vnrounitsn."')";	


//echo "<br>Cuadro Resumen<br>".$sql;/


							   $datacabez = $connect->query($sql)->fetchAll();
								$idtemp=0;
								$vejecucion = 1;
								  foreach ($datacabez as $rowheaders) 
								  {
									  
									  $obj_result_json = json_decode($rowheaders[0]);
									//  echo  "HOLA:". $obj_result_json->{'totalpass'};
									  $vparam_idruninfo = $obj_result_json->{'idruninfo'};
									  
									  $query_lista="SELECT uldl, band ,fas_tree_measure,totalpass::int as totalpassconvert,  fas_tree_measure.iduniqueop,  fas_step.description as namebranch,  fas_tree_measure.iduniquebranch, fas_tree_measure.unitsn, fas_tree_measure.dibsn, fas_tree_measure.uldl, fas_tree_measure.band
										,fas_tree_measure.idrununfo
										from fas_tree_measure
										inner join fas_tree
										on fas_tree.iduniquebranch = fas_tree_measure.iduniquebranch
										inner join fas_step
										on fas_step.idfasstep = fas_tree.idfastrepson
										where fas_tree_measure.iduniquebranch = '00E' and dibsn = '".$vparam_vnrounitsn."' and  idrununfo =".$vparam_idruninfo. " order by fas_tree_measure.band, fas_tree_measure.uldl, iduniqueop";

											//	echo "<br>aaa verrr".$query_lista."<br>";
											 $datacabez2 = $connect->query($query_lista)->fetchAll();
												$tempband = 0;
											 foreach ($datacabez2 as $rowheaders) 
											  {
												  if ($rowheaders['uldl'] ==0)
													{
														$label_ULDL_amostrar ="Uplink";
													}
													else
													{
														$label_ULDL_amostrar ="Downlink";
													}
													if ($rowheaders['band'] ==0)
													{
														$label_band_amostrar ="700 FirstNet";
													}
													else
													{
														$label_band_amostrar ="800";
													}
													?>
													<tr>
														<td> <?php	echo "".$label_band_amostrar ." - ".$label_ULDL_amostrar; ?> </td>
														<?php
														///AcceptDiB_Measure_Gain
														  $query_lista_Adentro ="SELECT totalpass::int as totalpassconvert
										,fas_tree_measure.idrununfo
										from fas_tree_measure
										inner join fas_tree
										on fas_tree.iduniquebranch = fas_tree_measure.iduniquebranch
										inner join fas_step
										on fas_step.idfasstep = fas_tree.idfastrepson
										where fas_tree_measure.iduniquebranch = '00E041044' and fas_tree_measure.uldl = ".$rowheaders['uldl']." and fas_tree_measure.band = ".$rowheaders['band']." and dibsn = '".$vparam_vnrounitsn."' and  idrununfo =".$vparam_idruninfo. " ";
												
														$datacabez_adentro = $connect->query($query_lista_Adentro)->fetchAll();
															 foreach ($datacabez_adentro as $rowheaders_adentro) 
																{
																	$vprime = $rowheaders_adentro['totalpassconvert'];
																}
																if ($vprime==1)
																{
																	echo "<td align='center'><span class='badge badge-pill badge-success'>Passed </span></td>";
																}
															    else
																{
																	echo "<td align='center'><span class='badge badge-pill badge-danger'>Not Passed </span></td>";
																	
																}
																
																
														?>
														
														
															<?php
															///AcceptDiB_Measure_MaxPower
														  $query_lista_Adentro ="SELECT totalpass::int as totalpassconvert
										,fas_tree_measure.idrununfo
										from fas_tree_measure
										inner join fas_tree
										on fas_tree.iduniquebranch = fas_tree_measure.iduniquebranch
										inner join fas_step
										on fas_step.idfasstep = fas_tree.idfastrepson
										where fas_tree_measure.iduniquebranch = '00E041045' and fas_tree_measure.uldl = ".$rowheaders['uldl']." and fas_tree_measure.band = ".$rowheaders['band']." and dibsn = '".$vparam_vnrounitsn."' and  idrununfo =".$vparam_idruninfo. " ";
															$datacabez_adentro = $connect->query($query_lista_Adentro)->fetchAll();
															 foreach ($datacabez_adentro as $rowheaders_adentro) 
																{
																	$vprime2 = $rowheaders_adentro['totalpassconvert'];
																}
																if ($vprime2==1)
																{
																	echo "<td align='center'><span class='badge badge-pill badge-success'>Passed </span></td>";
																}
															    else
																{
																	echo "<td align='center'><span class='badge badge-pill badge-danger'>Not Passed </span></td>";
																	
																}
														?>
														
													</tr>
													<?php
												 
											  }
	
				
								  }
								  
								  
								 echo "</table><hr>";

	/////////////////////////////////////////////////////////////////////////

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
		fas_tree_measure.datetime = losmasejecutados.masfechaidruninfo where fas_tree_measure.unitsn = '".$vparam_vnrounitsn."' order by fas_tree_measure.band ,fas_tree_measure.uldl ";


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
				  <div id="idocultargalleria" class="sd-none">
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





<script type="text/javascript">

	
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
	
	


</script>

<?php
//error_reporting(0);
// Notificar todos los errores de PHP (ver el registro de cambios)
error_reporting(E_ALL);
 include("db_conect.php"); 
 
 	session_start();


////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////

function section_create_graph_VNA_by_idrun_sn($vp_runinfo,$v_sn,$idscript, $idinstance)
{

	include("db_conect.php"); 

	require 'aws/aws-autoloader.php';
	require 'aws/fplmm.php';


		$sql= " 
		select *
		from fas_routines_process_sn
		inner join fas_routines_steps
		on fas_routines_steps.idstep = fas_routines_process_sn.idstep
		inner join fas_step
		on fas_step.instance = fas_routines_steps.instance
		where idruninfodb =".$vp_runinfo." and iduniqueop > 0 and fas_step.instance  ='".$idinstance."' order by idorder";
 
		$datacabez = $connect->query($sql)->fetchAll();
		$sitienedatos=0;

 	echo "<br>".$sql;

		
		?>
		
<table class="table   table-bordered table-sm">
  <thead class="table-secondary">
    <tr>
      <th scope="col">Filter</th>
      <th scope="col"></th>
       <th colspan="9" style='  text-align: center;'>Marker </th>     
    </tr>

	
  </thead>
  <tbody>
		<?php
		$nro_of_filter = 0;
	 	foreach ($datacabez as $row_op) 
			{
			
				///por aca iduniqueop 
				$sqlop ="select * from fas_outcome_integral where reference in 
				(
					select id_outcome from fas_outcome_integral where reference in 
				(
					select id_outcome from fas_outcome_integral where reference in 
				(
					select id_outcome from fas_outcome_integral where v_bigint in 
					(
					select v_bigint from fas_outcome_integral
						where reference in( 
								select id_outcome from fas_outcome_integral   where v_bigint = ".$row_op['idruninfodb']."  ) 
				
						and v_bigint =  ".$row_op['iduniqueop']." 
						)
					)
					and  idfasoutcomecat = 0 and idtype= 27
				)
				
				) and idtype in (0,1,6,7,16)  
				";
				echo "<br>x cada iduniqueop:<br>".$sqlop;
			 
				$muestrocab_freq = 0;	
				$simbolosareemplazar = array("{", "}");		
				$datafreq = $connect->query($sqlop)->fetchAll();
				$sitienedatos=0;
				$v_idoutcomefreq="";
				 foreach ($datafreq as $row_op_freq) 
					{
						$sitienedatos=1;
						if ( $row_op_freq['idtype']==0 )
						{
							$freq_start=$row_op_freq['v_double'];
						}
						if ( $row_op_freq['idtype']==1 )
						{
							$freq_stop=$row_op_freq['v_double'];
						}
						if ( $row_op_freq['idtype']==6 )
						{
							$port_a_name=$row_op_freq['v_string'];
						}
						if ( $row_op_freq['idtype']==7 )
						{
							$port_b_name=$row_op_freq['v_string'];
						}
						if ( $row_op_freq['idtype']==16 )
						{
							if ($v_idoutcomefreq=="")
							{
								$v_idoutcomefreq=$row_op_freq['id_outcome'];
							} 
							else
							{
								$v_idoutcomefreq=$v_idoutcomefreq.",".$row_op_freq['id_outcome'];
							}
							
						}
					}

					if ($sitienedatos==1)
					{
						$nro_of_filter = $nro_of_filter +1;
		//				echo "<br><hr"; 

						$sqlop_row = "select fas_outcome_integral.reference,fas_outcome_integral.v_string,fas_outcome_integral.idtype as idtypetree,
    ARRAY_AGG(fas_outcome_integral.v_integer order by fas_outcome_integral.v_integer asc) as arrayinteger, foi.idtype, 
    ARRAY_AGG(foi.v_double order by fas_outcome_integral.v_integer asc) as arraydouble,ARRAY_AGG(foi.v_boolean::integer order by fas_outcome_integral.v_integer asc) as arrayboolena 
    from fas_outcome_integral 
    left join fas_outcome_integral as foi on fas_outcome_integral.id_outcome = foi.reference where fas_outcome_integral.reference in ( ".$v_idoutcomefreq." )
    group by fas_outcome_integral.reference , idtypetree,foi.idtype,fas_outcome_integral.v_string ,fas_outcome_integral.idtype ";

	//echo "<br>final<br>".$sqlop_row."<br>fin";
										$datafreqrow = $connect->query($sqlop_row)->fetchAll();
										$sitienedatos=0;
										foreach ($datafreqrow as $rowdata) 
										{
											if ( $rowdata['idtypetree'] == 17)
											{
												$row_name = $rowdata['v_string'];
											}
											if ( $rowdata['idtype'] == 19)
											{
												 
													$lasfreq = str_replace($simbolosareemplazar, "",  $rowdata['arraydouble']);												 
													$lasfreq = explode(",", $lasfreq);
											 
												
												//print_r($lasfreq);
											    //echo "<br>";
											 
											}
											if ( $rowdata['idtype'] == 20)
											{
												if ($row_name=="S11")
												{
													$arraygainmaker_s11 = str_replace($simbolosareemplazar, "",  $rowdata['arraydouble']);												 
													$arraygainmaker_s11 = explode(",", $arraygainmaker_s11);
												} 
												if ($row_name=="S21")
												{
													$arraygainmaker_s21 = str_replace($simbolosareemplazar, "",  $rowdata['arraydouble']);												 
													$arraygainmaker_s21 = explode(",", $arraygainmaker_s21);
												} 
												
												//print_r($arraygainmaker);
												//echo "<br>";
											}
											if ( $rowdata['idtype'] == 21)
											{
												if ($row_name=="S11")
												{
													$array_refmaker_s11 = str_replace($simbolosareemplazar, "",  $rowdata['arraydouble']);												 
													$array_refmaker_s11 = explode(",", $array_refmaker_s11);
												}
												if ($row_name=="S21")
												{
													$array_refmaker_s21 = str_replace($simbolosareemplazar, "",  $rowdata['arraydouble']);												 
													$array_refmaker_s21 = explode(",", $array_refmaker_s21);
												}

												
												//	print_r($array_refmaker);
												//	echo "<br>";
											}
											if ( $rowdata['idtype'] == 24)
											{
												if ($row_name=="S11")
												{
													$array_boolean_s11 = str_replace($simbolosareemplazar, "",  $rowdata['arrayboolena']);												 
													$array_boolean_s11 = explode(",", $array_boolean_s11);
												}
												if ($row_name=="S21")
												{
													$array_boolean_s21 = str_replace($simbolosareemplazar, "",  $rowdata['arrayboolena']);												 
													$array_boolean_s21 = explode(",", $array_boolean_s21);
												}
											 	
											//	print_r($array_boolean);
											//	echo "<br>";

											}
											if ( $rowdata['idtype'] == 22)
											{
												if ($row_name=="S11")
												{
													$array_overpass_s11 = str_replace($simbolosareemplazar, "",  $rowdata['arrayboolena']);												 
													$array_overpass_s11 = explode(",", $array_overpass_s11);
												}
												if ($row_name=="S21")
												{
													$array_overpass_s21 = str_replace($simbolosareemplazar, "",  $rowdata['arrayboolena']);												 
													$array_overpass_s21 = explode(",", $array_overpass_s21);
												}
											 	
											//	print_r($array_overpass_s11);
											//	echo "<br>";
											}
											
										
										}


						if ($muestrocab_freq == 0)
						{			
							$muestrocab_freq = 1;	
					?>

					
						<tr>
							<th scope="col" class="table-secondary"> </th>
							<th scope="col" class="table-secondary">Frequency </th>
							<?php
									for ($i = 0; $i < count($lasfreq); ++$i){
										echo "<th class='table-secondary' style='  text-align: center;'>".$lasfreq[$i]."</th>";
									}
							?>
							

							</tr>
					<?php } ?>
						<tr>
						<th rowspan="7" style='text-align: middle;'>Filter <?php echo $nro_of_filter; ?>  <br>[<?php echo $freq_start." - ".$freq_stop; ?>] <br><?php echo $port_a_name."  <i class='fa fa-arrow-right'></i> ".$port_b_name; ?>
					<br><br>  	
					<p align="center">
						<?php  //echo "aca buusco idoutcome";
						
						$sqlplost="	select * from fas_outcome_integral where reference in ( ".$v_idoutcomefreq." ) 	and idfasoutcomecat = 18 and idtype = 23";
				 
					//	echo $sqlplost;
						
						?>
						    <style>
		 
		 .pictures {
		   list-style: none;
		   margin: 0;
		 
		 }
	 
	 </style>
					<div id="galley<?php echo $nro_of_filter; ?>" style="  max-width: 100vw; width:150px;">
						<ul class="pictures">
							<?php

							

$vt =0;
									$resultadoplot = $connect->query($sqlplost);	
                                   
								   foreach ($resultadoplot as $rowplot) 
									{
								  //  echo trim($rowplot['filename'])."<br>";
									$pngtemp2 = "plots/".trim($rowplot['v_string']).".png";
									$pngtemp2 = trim($rowplot['v_string']);
								//	  echo $pngtemp;
								   
									$cmd2 = $clientS3AWS->getCommand('GetObject', [
									  'Bucket' => 'fpxwebfas',
									  'Key'    => $pngtemp2
									]);

									//The period of availability
									$request2 = $clientS3AWS->createPresignedRequest($cmd2, '+20 minutes');

									//echo var_dump($request);
									//Get the pre-signed URL
									$signedUrl2 = (string) $request2->getUri();
						   //       echo "<br>a ver aqui:".$signedUrl;

									  if ($vt ==0)
									  {
									  ?>
									<li>
									  <img  id="imgmc<?php echo $idmedicionind; ?>" name="imgmc<?php echo $idmedicionind; ?>" data-original="<?php echo $signedUrl2;?>" src="<?php echo $signedUrl2;?>" width="100%" class="md-none"> 
									  
									</li>
									  <?php
									  }
									  else
									  {
										  ?>
										<li>
										  <img  data-original="<?php echo $signedUrl2;?>" src="<?php echo $signedUrl2;?>" width="20%" class="d-none" > 
										  
										</li>
									  <?php
									  }
									  $vt= $vt + 1;
										

									}
									?>
									 
						</ul>				
					</div>		

					<script type="text/javascript">
                                        window.addEventListener('DOMContentLoaded', function () {
                                          var idmedicion= <?php echo $nro_of_filter;  ?>;
                                        var galley = document.getElementById('galley'+idmedicion);
                                        var viewer = new Viewer(galley, {
                                          url: 'data-original',
                                          title: function (image) {
                                            return image.alt + ' (' + (this.index + 1) + '/' + this.length + ')';
                                          },
                                        });
                                      });
                                      </script>

								</p>
					</th>  
						</tr>

						<tr>
						<td 
						<?php 
							 
							   echo "class='table-primary'";  

						?>
						> <b><?php echo "S11 [ROE]";
					 		 $nombre_class_usar = "table-primary"; 
						?></b></td>
							 	<?php
									for ($i = 0; $i < count($array_refmaker_s11); ++$i){

										if ("1" == $array_overpass_s11[$i])
										{
											$elsimgamostr=">";
										}
										else
										{
											
											$elsimgamostr=" < ";
										}	

										echo "<th class='". $nombre_class_usar."'  style=' text-align: center;'>". $elsimgamostr.$array_refmaker_s11[$i]."</th>";
									}
							?>
						</tr>
						<td class='<?php echo $nombre_class_usar; ?>'> <b>Readed</b></td>
							 	<?php
									for ($i = 0; $i < count($arraygainmaker_s11); ++$i){
										echo "<th class='". $nombre_class_usar."' style='  text-align: center;'>".$arraygainmaker_s11[$i]."</th>";
									}
							?>
						</tr>
						<tr>
						
						<td class='<?php echo $nombre_class_usar; ?>'><b>Pass</b></td>

						
						<?php
									for ($i = 0; $i < count($array_boolean_s11); ++$i){
										echo "<th class='". $nombre_class_usar."' style='  text-align: center;'>"; 
										if ($array_boolean_s11[$i]==0)
										{
											?><span class="badge badge-danger">Not Passed</span><?php
										}
										else
										{
											?><span class="badge badge-success">Passed</span><?php
										}
										echo "</th>";
									}
							?>
						
						</tr>
						

						<?php ////////////////////////////////////////////// ?>
						<tr>
							 
						<td 
						<?php 
							 
							   echo "class='table-warning'";  

						?>
						> <b><?php echo "S21 [Rejection]";
					 		 $nombre_class_usar = "table-warning"; 
						?></b></td>
							 	<?php
									for ($i = 0; $i < count($array_refmaker_s21); ++$i){

										if ("1" == $array_overpass_s21[$i])
										{
											$elsimgamostr=">";
										}
										else
										{
											
											$elsimgamostr=" < ";
										}	

										echo "<th class='". $nombre_class_usar."'  style=' text-align: center;'>".$elsimgamostr.$array_refmaker_s21[$i]."</th>";
									}
							?>
						</tr>
						
						<td class='<?php echo $nombre_class_usar; ?>'> <b>Readed</b></td>
							 	<?php
									for ($i = 0; $i < count($arraygainmaker_s21); ++$i){
										echo "<th class='". $nombre_class_usar."' style='  text-align: center;'>".$arraygainmaker_s21[$i]."</th>";
									}
							?>
						</tr>
						<tr>
						
						<td class='<?php echo $nombre_class_usar; ?>'><b>Pass</b></td>

						
						<?php
									for ($i = 0; $i < count($array_boolean_s21); ++$i){
										echo "<th class='". $nombre_class_usar."' style='  text-align: center;'>"; 
										if ($array_boolean_s21[$i]==0)
										{
											?><span class="badge badge-danger">Not Passed</span><?php
										}
										else
										{
											?><span class="badge badge-success">Passed</span><?php
										}
										echo "</th>";
									}
							?>
						
						</tr>
						<tr>
					
					 
  
					<?php
					}

			}


?>



  
 

  </tbody>
</table>
<?php
}

////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////

////HTML PARA Agregar graficos
	function create_graph_Equalization($v_sn_agraf, $vv_idrununfo)
	{
		include("db_conect.php"); 
		$sql= "select distinct  idband.*
			from orders_sn_specs
			inner join idband
			on idband.idband = orders_sn_specs.idband and idband.active = 'Y'
		where  idorders IN (  select  idorders from orders_sn where  wo_serialnumber = '".$v_sn_agraf."' order by typeregister limit 1 ) AND typedata = 'UNIT'  ";



		$datacabez = $connect->query($sql)->fetchAll();
	 	foreach ($datacabez as $rowbandas) 
			{
				$restultado_bytes = random_bytes(8);
				$namedivxband = bin2hex($restultado_bytes);
				// 00100300B- EQ Check ******* 00100300A - EQ Calibration
			
				/////----ojo para las 14 mediciones q tengo en el ejemplo. tomar la maxfecha x cada freq
					///section_create_graph_EQ_TOTAL_RX_TX('AUTO GENERATE '.$namedivxband."<br>".$rowbandas['description'], 'm'.$rowbandas['idband'].$namedivxband,$vv_idrununfo,  $rowbandas['idbandforfas']) ;
				section_create_graph_EQ_TOTAL_RX_TX($rowbandas['description'], 'm'.$rowbandas['idband'].$namedivxband,$vv_idrununfo,  $rowbandas['idbandforfas']) ;
			
				?>
				<section class="col-lg-12 connectedSortable ui-sortable" id="am" name="am">
				<div class="row">	
				<?php
				section_create_graph_GAIN($rowbandas['description'], 'm'.$rowbandas['idband'].$namedivxband,$vv_idrununfo,  $rowbandas['idbandforfas']) ;
				section_create_graph_MaxPwr($rowbandas['description'], 'm'.$rowbandas['idband'].$namedivxband,$vv_idrununfo,  $rowbandas['idbandforfas']) ;
				section_create_graph_LevelRead($rowbandas['description'], 'm'.$rowbandas['idband'].$namedivxband,$vv_idrununfo,  $rowbandas['idbandforfas']) ;
				section_create_graph_Noiefigure($rowbandas['description'], 'm'.$rowbandas['idband'].$namedivxband,$vv_idrununfo,  $rowbandas['idbandforfas']) ;
				section_create_table_IMD($rowbandas['description'], 'm'.$rowbandas['idband'].$namedivxband,$vv_idrununfo,  $rowbandas['idbandforfas'],$v_sn_agraf) ;
				?>
			 
				</div>
				</section>
				<?php
			}
	
		 
		// section_create_graph_('800b', 'm800a');
	}


	function section_create_table_IMD($name_graf, $idgrapf, $vp_runinfo, $idbandoffas,$snmm)
	{
		include("db_conect.php"); 
		/// 7-0 FREQ
		/// 7 -0 Valores
		//select * from fnt_select_allmeasures_outcome_integral_mktmeasure(10902127375, 10702002638) where t_idfasoutcomecat = 7 and t_idtype = 1

		$sql_fastreem = "select * from fas_tree_measure where idrununfo =".$vp_runinfo."  AND iduniquebranch in('00200701B') and band =  ".$idbandoffas;
		$simbolosaborrar = array("{", "}");
	
	$datalosiduniqye = $connect->query($sql_fastreem)->fetchAll();
	foreach ($datalosiduniqye as $rowiduniqieop) 
	   {
		   $sql_maxpwr2=  " select   t_idfasoutcomecat, t_idtype,
		   ARRAY_AGG(t_v_double order by t_id_outcome) as arraydoublem
		   from fnt_select_allmeasures_outcome_integral_mktmeasure(".$vp_runinfo.", ". $rowiduniqieop['iduniqueop'].")  
		   group by t_idfasoutcomecat, t_idtype
		   ";
		//	echo "<br>eeeee".$sql_maxpwr2;
			$datamaxpwrxiduniqueop = $connect->query($sql_maxpwr2)->fetchAll();
			foreach ($datamaxpwrxiduniqueop as $rowmaxpwriuniqeip) 
			   {
					   if ( $rowiduniqieop['uldl']==0 &&   $rowmaxpwriuniqeip['t_idfasoutcomecat'] == 7  &&  $rowmaxpwriuniqeip['t_idtype'] ==0)
					   {
						   $_data_imd_0_freq =  $rowmaxpwriuniqeip['arraydoublem'];
					   }
					   $_data_imd_0_freq = str_replace($simbolosaborrar, "", $_data_imd_0_freq);
					   if ( $rowiduniqieop['uldl'] ==0 &&   $rowmaxpwriuniqeip['t_idfasoutcomecat'] == 7  &&  $rowmaxpwriuniqeip['t_idtype'] ==1)
					   {
						   $_data_imd_0_data=  $rowmaxpwriuniqeip['arraydoublem'];
					   }
					   $_data_imd_0_data = str_replace($simbolosaborrar, "", $_data_imd_0_data);

					   if ( $rowiduniqieop['uldl'] ==1 &&   $rowmaxpwriuniqeip['t_idfasoutcomecat'] == 7  &&  $rowmaxpwriuniqeip['t_idtype'] ==0)
					   {
						   $_data_imd_1_freq =  $rowmaxpwriuniqeip['arraydoublem'];
					   }
					   $_data_imd_1_freq = str_replace($simbolosaborrar, "", $_data_imd_1_freq);
				   //	echo "A VER".$rowiduniqieop['uldl'];
					
					   if ($rowiduniqieop['uldl']==1 &&   $rowmaxpwriuniqeip['t_idfasoutcomecat'] == 7  &&  $rowmaxpwriuniqeip['t_idtype'] ==1)
					   {
						   $_data_imd_1_data =  $rowmaxpwriuniqeip['arraydoublem'];
					   }
					   $_data_imd_1_data = str_replace($simbolosaborrar, "", $_data_imd_1_data);
			   }

			   $_data_imd_0_freq_array = explode(",", $_data_imd_0_freq);
			   $_data_imd_1_freq_array = explode(",", $_data_imd_1_freq);
			   $_data_imd_0_data_array = explode(",", $_data_imd_0_data);
			   $_data_imd_1_data_array = explode(",", $_data_imd_1_data);

	   }	?>
	                    <div class="row"> 
						
						    <div class="col-6  " id="divgrafico700imd001" name="divgrafico700imd001">
							<hr style=" border: 1px solid #007bff;">
							<p class="  colorazulfiplex" style="font-size: 14px"><b>IMD  <?php echo $name_graf; ?> UPLINK</b>
						 
							
						</p>
									<table class="table table-bordered table-sm text-center" style="font-size: 11px" >
									<thead class="thead-dark">
										<tr>
										
										<th scope="col">IMD1 [@<?php echo  $_data_imd_0_freq_array[0]; ?>]</th>
										<th scope="col">Fund. Tone [@<?php echo  $_data_imd_0_freq_array[1]; ?>]</th>
										<th scope="col">Fund. Tone [@<?php echo  $_data_imd_0_freq_array[2]; ?>]</th>
										<th scope="col">IMD2 [@<?php echo  $_data_imd_0_freq_array[3]; ?>]</th>
										</tr>
									</thead>
									<tbody>
										<tr>
										<th scope="row"><?php echo  $_data_imd_0_data_array[0]; ?></th>
										<td><?php echo  $_data_imd_0_data_array[1]; ?></td>
										<td><?php echo  $_data_imd_0_data_array[2]; ?></td>
										<td><?php echo  $_data_imd_0_data_array[3]; ?></td>
										</tr>

									</tbody>
									</table>
							</div>	
							<div class="col-6  " id="divgrafico700imd0012" name="divgrafico700imd0012">
							<hr style=" border: 1px solid #007bff;">
							<p class="  colorazulfiplex" style="font-size: 14px"><b>IMD <?php echo $name_graf; ?> DOWNLINK</b>
							&nbsp;&nbsp;<a href="#" onclick="abrirgaleria(<?php echo "'".$snmm."','00200701B',".$vp_runinfo.",".$idbandoffas; ?>)"><i class="	fa fa-camera"></i> Plots </a>
						</p>
									<table class="table table-bordered table-sm text-center" style="font-size: 11px"  >
									<thead class="thead-dark">
										<tr>
										
										<th scope="col">IMD1 [@<?php echo  $_data_imd_1_freq_array[0]; ?>]</th>
										<th scope="col">Fund. Tone [@<?php echo  $_data_imd_1_freq_array[1]; ?>]</th>
										<th scope="col">Fund. Tone [@<?php echo  $_data_imd_1_freq_array[2]; ?>]</th>
										<th scope="col">IMD2 [@<?php echo  $_data_imd_1_freq_array[3]; ?>]</th>
										</tr>
									</thead>
									<tbody>
										<tr>
										<th scope="row"><?php echo  $_data_imd_1_data_array[0]; ?> </th>
										<td><?php echo  $_data_imd_1_data_array[1]; ?> </td>
										<td> <?php echo  $_data_imd_1_data_array[2]; ?> </td>
										<td> <?php echo  $_data_imd_1_data_array[3]; ?></td>
										</tr>

									</tbody>
									</table>
							</div>		
						</div>			
	   <?php
		 
	}

	function section_create_graph_Noiefigure($name_graf, $idgrapf, $vp_runinfo, $idbandoffas)
	
	{
		include("db_conect.php"); 
		/// 7-0 FREQ
		/// 7 -0 Valores
		//select * from fnt_select_allmeasures_outcome_integral_mktmeasure(10902127375, 10702002638) where t_idfasoutcomecat = 7 and t_idtype = 1

		/////00200701C  --- Tenia: 002007084

		$sql_fastreem = "select * from fas_tree_measure where idrununfo =".$vp_runinfo."  AND iduniquebranch in('00200701C') and band =  ".$idbandoffas;
	
	
	//		echo "Level READ<br>".$sql_fastreem;


	$simbolosaborrar = array("{", "}");
	
	$datalosiduniqye = $connect->query($sql_fastreem)->fetchAll();
	foreach ($datalosiduniqye as $rowiduniqieop) 
	   {
		 /*  $sql_maxpwr2=  " select   t_idfasoutcomecat, t_idtype,
		   ARRAY_AGG(t_v_double order by t_id_outcome) as arraydoublem
		   from fnt_select_allmeasures_outcome_integral_mktmeasure(".$vp_runinfo.", ". $rowiduniqieop['iduniqueop'].")  
		   group by t_idfasoutcomecat, t_idtype
		   ";*/

		   $sql_maxpwr2=" select idfasoutcomecat as t_idfasoutcomecat , idtype as t_idtype, ARRAY_AGG(v_double order by id_outcome) as arraydoublem
		   from fas_outcome_integral where reference in ( SELECT t_id_outcome from fnt_select_allmeasures_outcome_integral_single(".$vp_runinfo.", ". $rowiduniqieop['iduniqueop'].") )
		   group by idfasoutcomecat, idtype
		   ";
		//	echo "<br>Noise Floor: ".$sql_maxpwr2;
			$datamaxpwrxiduniqueop = $connect->query($sql_maxpwr2)->fetchAll();
			foreach ($datamaxpwrxiduniqueop as $rowmaxpwriuniqeip) 
			   {
					   if ( $rowiduniqieop['uldl']==0 &&   $rowmaxpwriuniqeip['t_idfasoutcomecat'] == 6  &&  $rowmaxpwriuniqeip['t_idtype'] ==0)
					   {
						   $_data_nf_0_freq =  $rowmaxpwriuniqeip['arraydoublem'];
					   }
					   $_data_nf_0_freq = str_replace($simbolosaborrar, "", $_data_nf_0_freq);
					   if ( $rowiduniqieop['uldl'] ==0 &&   $rowmaxpwriuniqeip['t_idfasoutcomecat'] == 6  &&  $rowmaxpwriuniqeip['t_idtype'] ==12)
					   {
						   $_data_nf_0_value =  $rowmaxpwriuniqeip['arraydoublem'];
					   }
					   $_data_nf_0_value = str_replace($simbolosaborrar, "", $_data_nf_0_value);
					   if ( $rowiduniqieop['uldl'] ==1 &&   $rowmaxpwriuniqeip['t_idfasoutcomecat'] == 6  &&  $rowmaxpwriuniqeip['t_idtype'] ==0)
					   {
						   $_data_nf_1_freq =  $rowmaxpwriuniqeip['arraydoublem'];
					   }
					   $_data_nf_1_freq = str_replace($simbolosaborrar, "", $_data_nf_1_freq);
				   //	echo "A VER".$rowiduniqieop['uldl'];
					
					   if ($rowiduniqieop['uldl']==1 &&   $rowmaxpwriuniqeip['t_idfasoutcomecat'] ==6  &&  $rowmaxpwriuniqeip['t_idtype'] ==12)
					   {
						   $_data_nf_1_value =  $rowmaxpwriuniqeip['arraydoublem'];
					   }
					   $_data_nf_1_value = str_replace($simbolosaborrar, "", $_data_nf_1_value);
			   }

	   }	
		?>

	

	   <div class="col-6">
		  <hr style=" border: 1px solid #007bff;">
				  <div class="row"> 
						  <div class="col-6  " id="divgrafico700nf001" name="divgrafico700nf001">
						  
							  <div class="chart">
							  <p class="  colorazulfiplex" style="font-size: 14px"><b>Noise Figure <?php echo $name_graf;?> UpLink</b></p>
							  
								  <canvas id="grafinfnup_<?php echo $idgrapf; ?>" width="446" style="width: 446;"></canvas>
									  <?php $grafico_0_up_nf ="grafinfnup_".$idgrapf;?>
  
							  </div>
						  </div>
						  <div class="col-6  " id="divgrafico700nf002" name="divgrafico700nf002">
						  
						  <div class="chart">
						  <p class="  colorazulfiplex" style="font-size: 14px"><b>Noise Figure <?php echo $name_graf;?> DownLink</b></p>
						  
							  <canvas id="grafinfndown_<?php echo $idgrapf; ?>" width="446" style="width: 446;"></canvas>
								  <?php $grafico_0_down_nf ="grafinfndown_".$idgrapf;?>
  
						  </div>
					  </div>
					   
				  </div>
			   
   
		  </div>
		   
		  <script src="plugins/chart.js/Chart.min.js"	></script>
			<script type="text/javascript">
	
var grafico_0_up_nf = document.getElementById('<?php echo $grafico_0_up_nf;?>').getContext('2d');
var grafico_0_down_nf = document.getElementById('<?php echo $grafico_0_down_nf;?>').getContext('2d');

var iduni_0_nf_up = "<?php echo $_data_nf_0_value;?>";					 
var iduni_1_nf_down = "<?php echo $_data_nf_1_value;?>";					 

var iduni_0_nf_down_lbl = "<?php echo $_data_nf_0_freq;?>";					 
var iduni_1_nf_down_lbl = "<?php echo $_data_nf_1_freq;?>";	



iduni_0_nf_up_data= iduni_0_nf_up.split(",");  
iduni_1_nf_down_data= iduni_1_nf_down.split(",");  
iduni_0_nf_down_lbl_data= iduni_0_nf_down_lbl.split(",");  
iduni_1_nf_down_lbl_data= iduni_1_nf_down_lbl.split(",");  
/*
console.log('marco NF');
console.log(iduni_0_nf_up_data);
console.log(iduni_1_nf_down_data);
console.log(iduni_0_nf_down_lbl_data);
console.log(iduni_1_nf_down_lbl_data);
*/
 

 	    var configOptions_nf_00 = {
                                  maintainAspectRatio : false,
                                  responsive : false,	
                                  legend: {
                                  display: false
                                  },                                  
                                            title: {
                                              display: true,
                                              text: '   '
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

                                            suggestedMin: (Math.min.apply(Math, iduni_0_nf_up_data) - Math.abs(  Math.min.apply(Math, iduni_0_nf_up_data)*0.1)),
                                            suggestedMax: (Math.max.apply(Math, iduni_0_nf_up_data) + Math.abs(  Math.max.apply(Math, iduni_0_nf_up_data)*0.1))
                                            }
                                          }]
                                  }
                                  }
								  
								     var datos_grafico_0_nf = {
                                        labels  : iduni_0_nf_down_lbl_data,
                                        datasets: [

                                                        {
                                                        label               : ' ',		
                                                        backgroundColor     : 'rgba(60,141,188,0.3)',
                                                        borderColor         : 'rgba(60,141,188,1)',
                                                        pointRadius          : false,
                                                        pointColor          : '#3b8bba',
                                                        pointStrokeColor    : 'rgba(60,141,188,1)',
                                                        pointHighlightFill  : '#fff',
                                                        pointHighlightStroke: 'rgba(60,141,188,1)',	
                                                        data          :iduni_0_nf_up_data
                                                        },
                                                    ]
                                        };
										
							     var rpt_grafico700nfd00 = new Chart(grafico_0_up_nf, { 
                              type: 'line', 	
                              data: datos_grafico_0_nf,	 
                              options: configOptions_nf_00
                            });
						
							///// 2do graf max pwr
								 var configOptions_nf_11 = {
                                  maintainAspectRatio : false,
                                  responsive : false,	
                                  legend: {
                                  display: false
                                  },                                  
                                            title: {
                                              display: true,
                                              text: '  '
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

                                            suggestedMin: (Math.min.apply(Math, iduni_1_nf_down_data) - Math.abs(  Math.min.apply(Math, iduni_1_nf_down_data)*0.1)),
                                            suggestedMax: (Math.max.apply(Math, iduni_1_nf_down_data) + Math.abs(  Math.max.apply(Math, iduni_1_nf_down_data)*0.1))
                                            }
                                          }]
                                  }
                                  }
								  
								     var datos_grafico_1_nf= {
                                        labels  : iduni_1_nf_down_lbl_data ,
                                        datasets: [

                                                        {
                                                        label               : '',		
                                                        backgroundColor     : 'rgba(60,141,188,0.3)',
                                                        borderColor         : 'rgba(60,141,188,1)',
                                                        pointRadius          : false,
                                                        pointColor          : '#3b8bba',
                                                        pointStrokeColor    : 'rgba(60,141,188,1)',
                                                        pointHighlightFill  : '#fff',
                                                        pointHighlightStroke: 'rgba(60,141,188,1)',	
                                                        data          :iduni_1_nf_down_data
                                                        },
                                                    ]
                                        };
										
							     var rpt_grafico700bf01 = new Chart(grafico_0_down_nf, { 
                              type: 'line', 	
                              data: datos_grafico_1_nf, 
                              options: configOptions_nf_11
                            });			

						</script>
		  
		   
		<?php
	}

	function section_create_graph_Alarmchk_by_idrun_sn_fromafterburn($vp_runinfo,$v_sn,$idscript,$idinstancemimd)
	{

		$v_General_Failure_alarm_on =0 ;
		$v_General_Failure_alarm_off =0;

		$v_donnor_ant_disc_alarm_on =0;  
		$v_donnor_ant_disc_alarm_off =0;

		$v_donnor_ant_malfunc_alarm_on =0;
		$v_donnor_ant_malfunc_alarm_off =0;

		$v_vswr_alarm_on =0;  
		$v_vswr_alarm_off =0;

		include("db_conect.php"); 

	///// 085087 - 	VSWR  //// 0850C7 - PA Alarm // 0850CB LNA check // 0850E5  Antanna Malfunction // 0850DB Antanna Disconnection // 0850DA Oscilation and Isolation Alarm Chec
		$sql_fastreem = "
		select distinct idband.description as nombrebandmm,  fas_step.description as nameinstance,    * ,alarm.v_boolean::integer as statusalarm 
	from 
	(
		select distinct losiduniqueop.* , outcomeband.v_integer as idbanda, outcomeuldl.v_integer as uldl
		  
		from 
		(
			select distinct  losdd.* , fas_routines_steps.instance  as instancemm
		from fnt_select_allfas_routines_process_sn_maxrev_byscript_byidrun('".$v_sn."',".$idscript." ,".$vp_runinfo." ) as  losdd
		inner join fas_routines_steps
		on fas_routines_steps.idstep = losdd.idstep 
		inner join fas_step
		on fas_step.instance = fas_routines_steps.instance  
		where  fas_routines_steps.instance in ('085087','0850C7','0850CB','0850E5','0850DB','0850DA'  )
	) as losiduniqueop
	inner join fas_outcome_integral 
	on fas_outcome_integral.v_bigint = losiduniqueop.iduniqueop
	
	
	  left join fas_outcome_integral as outcomeband
	on outcomeband.reference = fas_outcome_integral.id_outcome and
	   outcomeband.idfasoutcomecat = 1 and
	   outcomeband.idtype          = 1
	   left join fas_outcome_integral as outcomeuldl
	on outcomeuldl.reference = fas_outcome_integral.id_outcome and
	   outcomeuldl.idfasoutcomecat = 1 and
	   outcomeuldl.idtype          = 2
	
	
	) as tt
	inner join fas_outcome_integral as alarm
	on alarm.reference = tt.iduniqueop
	inner join idband
	on idband.idband = tt.idbanda and idband.active = 'Y'
	inner join fas_step  on fas_step.instance = tt.instancemm
	";

	//echo "<br>Arlam:".$sql_fastreem."bbbbb<br>";	

 

 

		$simbolosaborrar = array("{", "}");

		?>
					 <div class="col " id="divgrafico700maxpwr00" name="divgrafico700maxpwr001">
						  
						  <div class="chart">
						  <p class="  colorazulfiplex" style="font-size: 14px"><b>Alarm Band:   
						  <table class="table table-sm table-hover table-striped table-bordered text-center textotabla10">
								
						  	<thead class="thead-dark">
								<tr>
								<th style="text-align: left">Reference:</th>
								<th style="text-align: left">Band:</th>
							
								<th style="text-align: center">Status</th> 
								<th style="text-align: center">Forced On</th> 
								<th style="text-align: center">Forced Off</th> 
								</tr>
							</thead>	
		<?php
	
		$datalosiduniqye = $connect->query($sql_fastreem)->fetchAll();
	 	foreach ($datalosiduniqye as $rowiduniqieop) 
			{

				$idbandoffas =  $rowiduniqieop['idbanda'];	
				$iduldl = $rowiduniqieop['uldl'];
				$instancemm =  $rowiduniqieop['instancemm'];	
			$idgrapf = $rowiduniqieop['iduniqueop'];

		//	echo "<br>aaaaaaaaaaa".$idgrapf;
				if ($rowiduniqieop['uldl']==0)
				{
					$nameuldl ="UpLink";
				}
				else
				{
					$nameuldl ="Down";
				}


			$sql_maxpwr2=  " 
			select fasoutcometypename,  strpos(fasoutcometypename, 'On') as haveon,
			strpos(fasoutcometypename, 'Off') as haveoff, fas_outcome_integral.idfasoutcomecat ,fas_outcome_integral.idtype, v_boolean::integer as v_boolean
from fas_outcome_integral 
inner join fas_outcome_category_type
on  fas_outcome_category_type.idfasoutcomecat   = fas_outcome_integral.idfasoutcomecat and
    fas_outcome_category_type.idtype            = fas_outcome_integral.idtype

			where reference in (
							 
										   select  id_outcome 
										   from fas_outcome_integral 
										   where v_bigint = ".$idgrapf."    

							   )
			   and   fas_outcome_integral.idfasoutcomecat =11
		 
			";

		//	echo "<br>-->".$rowiduniqieop['instancemm']."<br>333".$sql_maxpwr2."4444<br>";	
			$force_Alarm_On="";
			$force_Alarm_On_Q=0;
			$force_Alarm_Off="";
			$force_Alarm_Off_Q=0;
				 $datamaxpwrxiduniqueop = $connect->query($sql_maxpwr2)->fetchAll();
			 foreach ($datamaxpwrxiduniqueop as $rowmaxpwriuniqeip) 
				{	
				 			 
						if (   $rowmaxpwriuniqeip['haveon'] > 0 &&  $rowmaxpwriuniqeip['v_boolean'] ==1)
						{
							$force_Alarm_On =  $rowmaxpwriuniqeip['v_boolean'];
							$force_Alarm_On_Q=$force_Alarm_On_Q+1;
						}	
						if (   $rowmaxpwriuniqeip['haveoff']> 0 &&  $rowmaxpwriuniqeip['v_boolean'] ==0)
						{
							$force_Alarm_Off =  $rowmaxpwriuniqeip['v_boolean'];
							$force_Alarm_Off_Q=  $force_Alarm_Off_Q + 1;
						}
					 		 
				 
				}

		//	echo "<br>force_Alarm_On:".$force_Alarm_On."-force_Alarm_Off:".$force_Alarm_Off."->q".$force_Alarm_On_Q."--q:".$force_Alarm_Off_Q;
		?>			 
			<tr>
			<th style="text-align: left"> <?php echo $rowiduniqieop['nameinstance'];?> </th>
			<th style="text-align: left">
			<?php //echo $rowiduniqieop['nombrebandmm'];
					if ($idscript==38 && $nameuldl  =="UpLink" && $rowiduniqieop['nombrebandmm'] =="700 FirstNet" ) 
					{ 
						echo "700 & 800 - ". $nameuldl ;
					}
					else
					{
						echo $rowiduniqieop['nombrebandmm']." - ". $nameuldl ;
					} 
			?>			
			</th>
		
			<td style="text-align: center"> <?php  

			if ( $force_Alarm_On ==1 &&  $force_Alarm_Off ==0 && $force_Alarm_Off_Q == $force_Alarm_On_Q )
			{
				?><span class="badge bg-green">Pass</span><?php
			}
			else
			{
				?><span class="badge bg-red">Not Pass</span><?php
			}
			?>
			</td>
			<td style="text-align: center"> 
			<?php  

			if ( $force_Alarm_On ==1 && $force_Alarm_On_Q >=1)
			{
				?><span class="badge bg-green">Pass</span><?php
			}
			else
			{
				?><span class="badge bg-red">Not Pass</span><?php
			}
			?>

			</td>
			<td style="text-align: center">
			<?php if ( $force_Alarm_Off ==0 && $force_Alarm_Off_Q >=1)
			{
				?><span class="badge bg-green">Pass</span><?php
			}
			else
			{
				?><span class="badge bg-red">Not Pass</span><?php
			}
			?>
			</td>
			</tr>
<?php
			}
?>
		</table>	
</div>
</div>
		<?php
			
	}

	function section_create_graph_spurious_by_idrun_sn_fromafterburn($vp_runinfo,$v_sn,$idscript,$idinstancemimd)
	{
		include("db_conect.php"); 

	
		$sql_fastreem = "
		select *
	from 
	(
		select losiduniqueop.* , outcomeband.v_integer as idbanda, outcomeuldl.v_integer as uldl
		  
		from 
		(
			select  losdd.* , fas_routines_steps.instance  as instancemm
		from fnt_select_allfas_routines_process_sn_maxrev_byscript_byidrun('".$v_sn."',".$idscript." ,".$vp_runinfo." ) as  losdd
		inner join fas_routines_steps
		on fas_routines_steps.idstep = losdd.idstep 
		inner join fas_step
		on fas_step.instance = fas_routines_steps.instance  
		where  fas_routines_steps.instance = '".$idinstancemimd."'  
	) as losiduniqueop
	inner join fas_outcome_integral 
	on fas_outcome_integral.v_bigint = losiduniqueop.iduniqueop
	
	
	  left join fas_outcome_integral as outcomeband
	on outcomeband.reference = fas_outcome_integral.id_outcome and
	   outcomeband.idfasoutcomecat = 1 and
	   outcomeband.idtype          = 1
	   left join fas_outcome_integral as outcomeuldl
	on outcomeuldl.reference = fas_outcome_integral.id_outcome and
	   outcomeuldl.idfasoutcomecat = 1 and
	   outcomeuldl.idtype          = 2
	
	
	) as tt
	inner join idband
	on idband.idband = tt.idbanda and idband.active = 'Y'
	";


		$sql_fastreem = "
		select *
	from 
	(
		select losiduniqueop.* , outcomeband.v_integer as idbanda, outcomeuldl.v_integer as uldl
		  
		from 
		(
			select  losdd.* , fas_routines_steps.instance  as instancemm
		from fnt_select_allfas_routines_process_sn_maxrev_byscript_byidrun('".$v_sn."',".$idscript." ,".$vp_runinfo." ) as  losdd
		inner join fas_routines_steps
		on fas_routines_steps.idstep = losdd.idstep 
		inner join fas_step
		on fas_step.instance = fas_routines_steps.instance  
		where  fas_routines_steps.instance = '".$idinstancemimd."'  
	) as losiduniqueop
	inner join fas_outcome_integral 
	on fas_outcome_integral.v_bigint = losiduniqueop.iduniqueop
	
	
	  left join fas_outcome_integral as outcomeband
	on outcomeband.reference = fas_outcome_integral.id_outcome and
	   outcomeband.idfasoutcomecat = 1 and
	   outcomeband.idtype          = 1
	   left join fas_outcome_integral as outcomeuldl
	on outcomeuldl.reference = fas_outcome_integral.id_outcome and
	   outcomeuldl.idfasoutcomecat = 1 and
	   outcomeuldl.idtype          = 2
	
	
	) as tt
	inner join idband
	on idband.idband = tt.idbanda and idband.active = 'Y'
	";
	
	///echo "<br>aaaa".$sql_fastreem."bbbbb<br>";	

		$simbolosaborrar = array("{", "}");
	
		$datalosiduniqye = $connect->query($sql_fastreem)->fetchAll();
	 	foreach ($datalosiduniqye as $rowiduniqieop) 
			{

				$idbandoffas =  $rowiduniqieop['idbanda'];	
				$iduldl = $rowiduniqieop['uldl'];
		$instancemm =  $rowiduniqieop['instancemm'];	
			$idgrapf = $rowiduniqieop['iduniqueop'];
		
			if ($rowiduniqieop['uldl']==0)
			{
				$nameuldl ="UpLink";
			}
			else
			{
				$nameuldl ="Down";
			}


				$sql_maxpwr2=  " select idfasoutcomecat, idtype, ARRAY_AGG(v_double order by id_outcome) as arraydoublem
				from fas_outcome_integral
				where reference in (
								select distinct   max(id_outcome)  as id_outcome_del027
								   from fas_outcome_integral 
								   where reference in(
											   select  id_outcome 
											   from fas_outcome_integral 
											   where v_bigint = ".$idgrapf."    
											   )
								   and   idfasoutcomecat = 0 and idtype = 27  group by v_integer
								   )
				   and   idfasoutcomecat = 6 and idtype in(0,12)
			   group by idfasoutcomecat, idtype 
				";

		//		echo "<br>333".$sql_maxpwr2."4444<br>";	

				 $datamaxpwrxiduniqueop = $connect->query($sql_maxpwr2)->fetchAll();
				 foreach ($datamaxpwrxiduniqueop as $rowmaxpwriuniqeip) 
					{						 
							if (   $rowmaxpwriuniqeip['idfasoutcomecat'] == 6  &&  $rowmaxpwriuniqeip['idtype'] ==0)
							{
								$_data_spurious_0_freq =  $rowmaxpwriuniqeip['arraydoublem'];
							}
							
							 
							$_data_spurious_0_freq = str_replace($simbolosaborrar, "", $_data_spurious_0_freq);
							
					}
				 
/*
					if (   $rowmaxpwriuniqeip['idfasoutcomecat'] == 6  &&  $rowmaxpwriuniqeip['idtype'] ==12)
					{
						$_data_noisefig_0_reach =  $rowmaxpwriuniqeip['arraydoublem'];
					}
					 
					$_data_spurious_0_freq = str_replace($simbolosaborrar, "", $_data_spurious_0_freq);
					$_data_noisefig_0_reach = str_replace($simbolosaborrar, "", $_data_noisefig_0_reach);
					*/
				 
						

		?>			     <div class="col " id="divgrafico700maxpwr00" name="divgrafico700maxpwr001">
						  
							  <div class="chart">
							  <p class="  colorazulfiplex" style="font-size: 14px"><b>Spurious  
							  <?php
							 if ($idscript==40 && $nameuldl  =="UpLink" && $rowiduniqieop['description'] =="700 FirstNet" ) 
							 { 
								 echo "700 & 800 - ". $nameuldl ;
							 }
							 else
							 {
								 echo $rowiduniqieop['description']." - ". $nameuldl ;
							 } 
							 
							// echo $name_graf;
							?>  </b>&nbsp; </p>
							  
								  <canvas id="grafilevelreadnup_<?php echo $idgrapf; ?>" width="446" style="width: 446;"></canvas>
									  <?php $grafico_0_up_noisefig ="grafilevelreadnup_".$idgrapf;?>  
							  </div>
						  </div>
						  
						  
				  
   	   
		  <script src="plugins/chart.js/Chart.min.js"	></script>
			<script type="text/javascript">
	
var grafico_0_up_levelread = document.getElementById('<?php echo $grafico_0_up_noisefig;?>').getContext('2d');

var iduni_0_levelread_up = "<?php echo $_data_noisefig_0_reach;?>";	
var iduni_0_levelread_down_lbl = "<?php echo $_data_noisefig_0_freq;?>";					 

iduni_0_levelread_up_data= iduni_0_levelread_up.split(",");  
iduni_0_levelread_down_lbl_data= iduni_0_levelread_down_lbl.split(",");  
 	    var configOptions_levelread_00 = {
                                  maintainAspectRatio : false,
                                  responsive : false,	
                                  legend: {
                                  display: false
                                  },                                  
                                            title: {
                                              display: true,
                                              text: '   '
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

                                            suggestedMin: (Math.min.apply(Math, iduni_0_levelread_up_data) - Math.abs(  Math.min.apply(Math, iduni_0_levelread_up_data)*0.1)),
                                            suggestedMax: (Math.max.apply(Math, iduni_0_levelread_up_data) + Math.abs(  Math.max.apply(Math, iduni_0_levelread_up_data)*0.1))
                                            }
                                          }]
                                  }
                                  }
								  
								     var datos_grafico_0_levelread = {
                                        labels  : iduni_0_levelread_down_lbl_data,
                                        datasets: [

                                                        {
                                                        label               : ' ',		
                                                        backgroundColor     : 'rgba(60,141,188,0.3)',
                                                        borderColor         : 'rgba(60,141,188,1)',
                                                        pointRadius          : false,
                                                        pointColor          : '#3b8bba',
                                                        pointStrokeColor    : 'rgba(60,141,188,1)',
                                                        pointHighlightFill  : '#fff',
                                                        pointHighlightStroke: 'rgba(60,141,188,1)',	
                                                        data          :iduni_0_levelread_up_data
                                                        },
                                                    ]
                                        };
										
							     var rpt_grafico700levelread00 = new Chart(grafico_0_up_levelread, { 
                              type: 'line', 	
                              data: datos_grafico_0_levelread,	 
                              options: configOptions_levelread_00
                            });
						
						
						</script>
		  
		   
		<?php
			}
	}

	function section_create_graph_Noisefigure_by_idrun_sn_fromafterburn($vp_runinfo,$v_sn,$idscript,$idinstancemimd)
	{
		include("db_conect.php"); 

	
		$sql_fastreem = "
		select * ,  idband.description as nombrebandmm
	from 
	(
		select losiduniqueop.* , outcomeband.v_integer as idbanda, outcomeuldl.v_integer as uldl
		  
		from 
		(
			select  losdd.* , fas_routines_steps.instance  as instancemm
		from fnt_select_allfas_routines_process_sn_maxrev_byscript_byidrun('".$v_sn."',".$idscript." ,".$vp_runinfo." ) as  losdd
		inner join fas_routines_steps
		on fas_routines_steps.idstep = losdd.idstep 
		inner join fas_step
		on fas_step.instance = fas_routines_steps.instance  
		where  fas_routines_steps.instance = '".$idinstancemimd."'  
	) as losiduniqueop
	inner join fas_outcome_integral 
	on fas_outcome_integral.v_bigint = losiduniqueop.iduniqueop
	
	
	  left join fas_outcome_integral as outcomeband
	on outcomeband.reference = fas_outcome_integral.id_outcome and
	   outcomeband.idfasoutcomecat = 1 and
	   outcomeband.idtype          = 1
	   left join fas_outcome_integral as outcomeuldl
	on outcomeuldl.reference = fas_outcome_integral.id_outcome and
	   outcomeuldl.idfasoutcomecat = 1 and
	   outcomeuldl.idtype          = 2
	
	
	) as tt
	inner join idband
	on idband.idband = tt.idbanda and idband.active = 'Y'
	";
	
////	echo "<br>aaaa".$sql_fastreem."bbbbb<br>";	

		$simbolosaborrar = array("{", "}");
	
		$datalosiduniqye = $connect->query($sql_fastreem)->fetchAll();
	 	foreach ($datalosiduniqye as $rowiduniqieop) 
			{

				$idbandoffas =  $rowiduniqieop['idbanda'];	
				$iduldl = $rowiduniqieop['uldl'];
		$instancemm =  $rowiduniqieop['instancemm'];	
			$idgrapf = $rowiduniqieop['iduniqueop'];
		
			if ($rowiduniqieop['uldl']==0)
			{
				$nameuldl ="UpLink";
			}
			else
			{
				$nameuldl ="Down";
			}


				$sql_maxpwr2=  " select idfasoutcomecat, idtype, ARRAY_AGG(v_double order by id_outcome) as arraydoublem
				from fas_outcome_integral
				where reference in (
								select distinct   max(id_outcome)  as id_outcome_del027
								   from fas_outcome_integral 
								   where reference in(
											   select  id_outcome 
											   from fas_outcome_integral 
											   where v_bigint = ".$idgrapf."    
											   )
								   and   idfasoutcomecat = 0 and idtype = 27  group by v_integer
								   )
				   and   idfasoutcomecat = 6 and idtype in(0,12)
			   group by idfasoutcomecat, idtype 
				";

			//	echo "<br>333".$sql_maxpwr2."4444<br>";	

				 $datamaxpwrxiduniqueop = $connect->query($sql_maxpwr2)->fetchAll();
				 foreach ($datamaxpwrxiduniqueop as $rowmaxpwriuniqeip) 
					{						 
							if (   $rowmaxpwriuniqeip['idfasoutcomecat'] == 6  &&  $rowmaxpwriuniqeip['idtype'] ==0)
							{
								$_data_noisefig_0_freq =  $rowmaxpwriuniqeip['arraydoublem'];
							}
							if (   $rowmaxpwriuniqeip['idfasoutcomecat'] == 6  &&  $rowmaxpwriuniqeip['idtype'] ==12)
							{
								$_data_noisefig_0_reach =  $rowmaxpwriuniqeip['arraydoublem'];
							}
							 
							$_data_noisefig_0_freq = str_replace($simbolosaborrar, "", $_data_noisefig_0_freq);
							$_data_noisefig_0_reach = str_replace($simbolosaborrar, "", $_data_noisefig_0_reach);
					}
				 
				 
						

		?>			     <div class="col " id="divgrafico700maxpwr00" name="divgrafico700maxpwr001">
						  
							  <div class="chart">
							  <p class="  colorazulfiplex" style="font-size: 14px"><b>Noise Figure 
							  <?php
							 if ($idscript==38 && $nameuldl  =="UpLink" && $rowiduniqieop['nombrebandmm'] =="700 FirstNet" ) 
							 { 
								 echo "700 & 800 - ". $nameuldl ;
							 }
							 else
							 {
								 echo $rowiduniqieop['nombrebandmm']." - ". $nameuldl ;
							 } 
							 
							// echo $name_graf;
							?>  </b>&nbsp; </p>
							  
								  <canvas id="grafilevelreadnup_<?php echo $idgrapf; ?>" width="446" style="width: 446;"></canvas>
									  <?php $grafico_0_up_noisefig ="grafilevelreadnup_".$idgrapf;?>  
							  </div>
						  </div>
						  
						  
				  
   	   
		  <script src="plugins/chart.js/Chart.min.js"	></script>
			<script type="text/javascript">
	
var grafico_0_up_levelread = document.getElementById('<?php echo $grafico_0_up_noisefig;?>').getContext('2d');

var iduni_0_levelread_up = "<?php echo $_data_noisefig_0_reach;?>";	
var iduni_0_levelread_down_lbl = "<?php echo $_data_noisefig_0_freq;?>";					 

iduni_0_levelread_up_data= iduni_0_levelread_up.split(",");  
iduni_0_levelread_down_lbl_data= iduni_0_levelread_down_lbl.split(",");  
 	    var configOptions_levelread_00 = {
                                  maintainAspectRatio : false,
                                  responsive : false,	
                                  legend: {
                                  display: false
                                  },                                  
                                            title: {
                                              display: true,
                                              text: '   '
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

                                            suggestedMin: (Math.min.apply(Math, iduni_0_levelread_up_data) - Math.abs(  Math.min.apply(Math, iduni_0_levelread_up_data)*0.1)),
                                            suggestedMax: (Math.max.apply(Math, iduni_0_levelread_up_data) + Math.abs(  Math.max.apply(Math, iduni_0_levelread_up_data)*0.1))
                                            }
                                          }]
                                  }
                                  }
								  
								     var datos_grafico_0_levelread = {
                                        labels  : iduni_0_levelread_down_lbl_data,
                                        datasets: [

                                                        {
                                                        label               : ' ',		
                                                        backgroundColor     : 'rgba(60,141,188,0.3)',
                                                        borderColor         : 'rgba(60,141,188,1)',
                                                        pointRadius          : false,
                                                        pointColor          : '#3b8bba',
                                                        pointStrokeColor    : 'rgba(60,141,188,1)',
                                                        pointHighlightFill  : '#fff',
                                                        pointHighlightStroke: 'rgba(60,141,188,1)',	
                                                        data          :iduni_0_levelread_up_data
                                                        },
                                                    ]
                                        };
										
							     var rpt_grafico700levelread00 = new Chart(grafico_0_up_levelread, { 
                              type: 'line', 	
                              data: datos_grafico_0_levelread,	 
                              options: configOptions_levelread_00
                            });
						
						
						</script>
		  
		   
		<?php
			}
	}

	function section_create_graph_LevelRead_by_idrun_sn_fromafterburn($vp_runinfo,$v_sn,$idscript,$idinstancemimd)
	{
		include("db_conect.php"); 

	
		$sql_fastreem = "
		select *,  idband.description as nombrebandmm
	from 
	(
		select losiduniqueop.* , outcomeband.v_integer as idbanda, outcomeuldl.v_integer as uldl
		  
		from 
		(
			select  losdd.* , fas_routines_steps.instance  as instancemm
		from fnt_select_allfas_routines_process_sn_maxrev_byscript_byidrun('".$v_sn."',".$idscript." ,".$vp_runinfo." ) as  losdd
		inner join fas_routines_steps
		on fas_routines_steps.idstep = losdd.idstep 
		inner join fas_step
		on fas_step.instance = fas_routines_steps.instance  
		where  fas_routines_steps.instance = '".$idinstancemimd."'  
	) as losiduniqueop
	inner join fas_outcome_integral 
	on fas_outcome_integral.v_bigint = losiduniqueop.iduniqueop
	
	
	  left join fas_outcome_integral as outcomeband
	on outcomeband.reference = fas_outcome_integral.id_outcome and
	   outcomeband.idfasoutcomecat = 1 and
	   outcomeband.idtype          = 1
	   left join fas_outcome_integral as outcomeuldl
	on outcomeuldl.reference = fas_outcome_integral.id_outcome and
	   outcomeuldl.idfasoutcomecat = 1 and
	   outcomeuldl.idtype          = 2
	
	
	) as tt
	inner join idband
	on idband.idband = tt.idbanda and idband.active = 'Y'
	";
	//echo "<br>aaaa".$sql_fastreem."bbbbb<br>";	



	/*
  - 10:13:11.816	1/3 @769.00 MHz single measure.. REFERENCE 4218318	 -> Level Read = -50.6 dBm    (4218362 11 --11)  Pass = true
  - 10:13:49.649	2/3 @772.00 MHz -> 4218690  Level Read = -50.6 dBm  4218738    Pass = true
  - 10:14:27.557	3/3 @775.00 MHz -> (4219062 ,4219106 Level Read = -50.73 dBm     Pass = true
	*/
		$simbolosaborrar = array("{", "}");
	
		$datalosiduniqye = $connect->query($sql_fastreem)->fetchAll();
	 	foreach ($datalosiduniqye as $rowiduniqieop) 
			{

				$idbandoffas =  $rowiduniqieop['idbanda'];	
				$iduldl = $rowiduniqieop['uldl'];
		$instancemm =  $rowiduniqieop['instancemm'];	
			$idgrapf = $rowiduniqieop['iduniqueop'];
		
			if ($rowiduniqieop['uldl']==0)
			{
				$nameuldl ="UpLink";
			}
			else
			{
				$nameuldl ="Down";
			}


				$sql_maxpwr2=  " select idfasoutcomecat, idtype, ARRAY_AGG(v_double order by id_outcome) as arraydoublem
				from fas_outcome_integral
				where reference in (
								select distinct   max(id_outcome)  as id_outcome_del027
								   from fas_outcome_integral 
								   where reference in(
											   select  id_outcome 
											   from fas_outcome_integral 
											   where v_bigint = ".$idgrapf."    
											   )
								   and   idfasoutcomecat = 0 and idtype = 27  group by v_integer
								   )
				   and   idfasoutcomecat = 6 and idtype in(0,1)
			   group by idfasoutcomecat, idtype 
				";

			//	echo "<br>333".$sql_maxpwr2."4444<br>";	

				 $datamaxpwrxiduniqueop = $connect->query($sql_maxpwr2)->fetchAll();
				 foreach ($datamaxpwrxiduniqueop as $rowmaxpwriuniqeip) 
					{						 
							if (   $rowmaxpwriuniqeip['idfasoutcomecat'] == 6  &&  $rowmaxpwriuniqeip['idtype'] ==0)
							{
								$_data_levelread_0_freq =  $rowmaxpwriuniqeip['arraydoublem'];
							}
							if (   $rowmaxpwriuniqeip['idfasoutcomecat'] == 6  &&  $rowmaxpwriuniqeip['idtype'] ==1)
							{
								$_data_levelread_0_reach =  $rowmaxpwriuniqeip['arraydoublem'];
							}
							
							 
							$_data_levelread_0_freq_data = str_replace($simbolosaborrar, "", $_data_levelread_0_freq);
							$_data_levelread_0_reach = str_replace($simbolosaborrar, "", $_data_levelread_0_reach);
						 
						 

					}
					///////////////////////////////
					$sql_maxpwr2=  "
					select idfasoutcomecat , idtype , ARRAY_AGG(v_double order by id_outcome) as arraydoublem
					from fas_outcome_integral
					where reference in (     
							select distinct id_outcome as id_outcome_del028
							from fas_outcome_integral
							where reference in (
											   select distinct   max(id_outcome)  as id_outcome_del027
											   from fas_outcome_integral 
											   where reference in(
														   select  id_outcome 
														   from fas_outcome_integral 
														   where v_bigint = ".$idgrapf."    
														   )
											   and   idfasoutcomecat = 0 and idtype = 27  group by v_integer
											   )
							   and   idfasoutcomecat = 0 and idtype = 28
						)   and   idfasoutcomecat = 11  
						group by idfasoutcomecat , idtype			 
				";
				// echo "<br>22Level Read:".$sql_maxpwr2;
				 $datamaxpwrxiduniqueop = $connect->query($sql_maxpwr2)->fetchAll();
				 foreach ($datamaxpwrxiduniqueop as $rowmaxpwriuniqeip) 
					{

					///			echo "idband".$idbandoffas."-uldl:".$iduldl."<br>";
						if ($idbandoffas==3 && $iduldl==1 && $rowmaxpwriuniqeip['idfasoutcomecat']==11  && $rowmaxpwriuniqeip['idtype']==11)
						{
							$_data_levelread_0 =  $rowmaxpwriuniqeip['arraydoublem'];
						}

						if ($idbandoffas==3 && $iduldl==0 && $rowmaxpwriuniqeip['idfasoutcomecat']==11  && $rowmaxpwriuniqeip['idtype']==103)
						{
							$_data_levelread_0 =  $rowmaxpwriuniqeip['arraydoublem'];
						}
						if ($idbandoffas==4 && $iduldl==1 && $rowmaxpwriuniqeip['idfasoutcomecat']==11  && $rowmaxpwriuniqeip['idtype']==12)
						{
							$_data_levelread_0 =  $rowmaxpwriuniqeip['arraydoublem'];
						}
						if ($idbandoffas==4 && $iduldl==0 && $rowmaxpwriuniqeip['idfasoutcomecat']==11  && $rowmaxpwriuniqeip['idtype']==12)
						{
							$_data_levelread_0 =  $rowmaxpwriuniqeip['arraydoublem'];
						}
					
					
 
							
					 
					}
					///////////////////////////////
					$_data_levelread_0_value = str_replace($simbolosaborrar, "", $_data_levelread_0);	
					$data_0_reach = explode(",", $_data_levelread_0_reach);
						

		?>			     <div class="col " id="divgrafico700maxpwr00" name="divgrafico700maxpwr001">
						  
							  <div class="chart">
							  <p class="  colorazulfiplex" style="font-size: 14px"><b>Level Read 
							  <?php
							 if ($idscript==38 && $nameuldl  =="UpLink" && $rowiduniqieop['nombrebandmm'] =="700 FirstNet" ) 
							 { 
								 echo "700 & 800 - ". $nameuldl ;
							 }
							 else
							 {
								 echo $rowiduniqieop['nombrebandmm']." - ". $nameuldl ;
							 } 
							 
							// echo $name_graf;
							?>  </b>&nbsp; @<?php echo $data_0_reach[0];?>dBm</p>
							  
								  <canvas id="grafilevelreadnup_<?php echo $idgrapf; ?>" width="446" style="width: 446;"></canvas>
									  <?php $grafico_0_up_levelread ="grafilevelreadnup_".$idgrapf;?>  
							  </div>
						  </div>
						  
						  
				  
   	   
		  <script src="plugins/chart.js/Chart.min.js"	></script>
			<script type="text/javascript">
	
var grafico_0_up_levelread = document.getElementById('<?php echo $grafico_0_up_levelread;?>').getContext('2d');

var iduni_0_levelread_up = "<?php echo $_data_levelread_0_value;?>";	
var iduni_0_levelread_down_lbl = "<?php echo $_data_levelread_0_freq_data;?>";					 

iduni_0_levelread_up_data= iduni_0_levelread_up.split(",");  
iduni_0_levelread_down_lbl_data= iduni_0_levelread_down_lbl.split(",");  
 	    var configOptions_levelread_00 = {
                                  maintainAspectRatio : false,
                                  responsive : false,	
                                  legend: {
                                  display: false
                                  },                                  
                                            title: {
                                              display: true,
                                              text: '   '
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

                                            suggestedMin: (Math.min.apply(Math, iduni_0_levelread_up_data) - Math.abs(  Math.min.apply(Math, iduni_0_levelread_up_data)*0.1)),
                                            suggestedMax: (Math.max.apply(Math, iduni_0_levelread_up_data) + Math.abs(  Math.max.apply(Math, iduni_0_levelread_up_data)*0.1))
                                            }
                                          }]
                                  }
                                  }
								  
								     var datos_grafico_0_levelread = {
                                        labels  : iduni_0_levelread_down_lbl_data,
                                        datasets: [

                                                        {
                                                        label               : ' ',		
                                                        backgroundColor     : 'rgba(60,141,188,0.3)',
                                                        borderColor         : 'rgba(60,141,188,1)',
                                                        pointRadius          : false,
                                                        pointColor          : '#3b8bba',
                                                        pointStrokeColor    : 'rgba(60,141,188,1)',
                                                        pointHighlightFill  : '#fff',
                                                        pointHighlightStroke: 'rgba(60,141,188,1)',	
                                                        data          :iduni_0_levelread_up_data
                                                        },
                                                    ]
                                        };
										
							     var rpt_grafico700levelread00 = new Chart(grafico_0_up_levelread, { 
                              type: 'line', 	
                              data: datos_grafico_0_levelread,	 
                              options: configOptions_levelread_00
                            });
						
						
						</script>
		  
		   
		<?php
			}
	}

	function section_create_graph_LevelRead_by_idrun_sn($vp_runinfo,$v_sn,$idscript,$idinstancemimd)
	{
		include("db_conect.php"); 

	
		$sql_fastreem = "
		select *
	from 
	(
		select losiduniqueop.* , outcomeband.v_integer as idbanda, outcomeuldl.v_integer as uldl
		  
		from 
		(
			select  losdd.* , fas_routines_steps.instance  as instancemm
		from fnt_select_allfas_routines_process_sn_maxrev_byscript_byidrun('".$v_sn."',".$idscript." ,".$vp_runinfo." ) as  losdd
		inner join fas_routines_steps
		on fas_routines_steps.idstep = losdd.idstep 
		inner join fas_step
		on fas_step.instance = fas_routines_steps.instance  
		where  fas_routines_steps.instance = '".$idinstancemimd."'  
	) as losiduniqueop
	inner join fas_outcome_integral 
	on fas_outcome_integral.v_bigint = losiduniqueop.iduniqueop
	
	
	  left join fas_outcome_integral as outcomeband
	on outcomeband.reference = fas_outcome_integral.id_outcome and
	   outcomeband.idfasoutcomecat = 1 and
	   outcomeband.idtype          = 1
	   left join fas_outcome_integral as outcomeuldl
	on outcomeuldl.reference = fas_outcome_integral.id_outcome and
	   outcomeuldl.idfasoutcomecat = 1 and
	   outcomeuldl.idtype          = 2
	
	
	) as tt
	inner join idband
	on idband.idband = tt.idbanda and idband.active = 'Y'
	";
	//echo "<br>aaaa".$sql_fastreem."bbbbb<br>";	



	/*
  - 10:13:11.816	1/3 @769.00 MHz single measure.. REFERENCE 4218318	 -> Level Read = -50.6 dBm    (4218362 11 --11)  Pass = true
  - 10:13:49.649	2/3 @772.00 MHz -> 4218690  Level Read = -50.6 dBm  4218738    Pass = true
  - 10:14:27.557	3/3 @775.00 MHz -> (4219062 ,4219106 Level Read = -50.73 dBm     Pass = true
	*/
		$simbolosaborrar = array("{", "}");
	
		$datalosiduniqye = $connect->query($sql_fastreem)->fetchAll();
	 	foreach ($datalosiduniqye as $rowiduniqieop) 
			{

				$idbandoffas =  $rowiduniqieop['idbanda'];	
		$instancemm =  $rowiduniqieop['instancemm'];	
			$idgrapf = $rowiduniqieop['iduniqueop'];
			if ($rowiduniqieop['uldl']==0)
			{
				$nameuldl ="UpLink";
			}
			else
			{
				$nameuldl ="Down";
			}


				$sql_maxpwr2=  " select   t_idfasoutcomecat, t_idtype,
				ARRAY_AGG(t_v_double order by t_id_outcome) as arraydoublem
				from fnt_select_allmeasures_outcome_integral_ucmeasure_ns(".$vp_runinfo.", ". $rowiduniqieop['iduniqueop'].")  where t_idfasoutcomecat in(5,11) and t_idtype in(14,18)
				group by t_idfasoutcomecat, t_idtype
				";

		//		echo "<br>333".$sql_maxpwr2."4444<br>";	

				 $datamaxpwrxiduniqueop = $connect->query($sql_maxpwr2)->fetchAll();
				 foreach ($datamaxpwrxiduniqueop as $rowmaxpwriuniqeip) 
					{						 
							if ( $rowiduniqieop['uldl'] ==0 &&   $rowmaxpwriuniqeip['t_idfasoutcomecat'] == 5  &&  $rowmaxpwriuniqeip['t_idtype'] ==18)
							{
								$_data_levelread_0 =  $rowmaxpwriuniqeip['arraydoublem'];
							}
							if ( $rowiduniqieop['uldl'] ==0 &&   $rowmaxpwriuniqeip['t_idfasoutcomecat'] == 5  &&  $rowmaxpwriuniqeip['t_idtype'] ==14)
							{
								$_data_levelread_0_reach =  $rowmaxpwriuniqeip['arraydoublem'];
							}
							$_data_levelread_0_value = str_replace($simbolosaborrar, "", $_data_levelread_0);				

					}
					///////////////////////////////
					$sql_maxpwr2=  "
					select ARRAY_AGG(v_double order by id_outcome) as arraydoublem
					from ( 
						select * from fas_outcome_integral 
						where reference in ( select t_id_outcome from fnt_select_allmeasures_outcome_integral_single_ns(". $rowiduniqieop['iduniqueop'].")) and idfasoutcomecat = 6 and idtype =0)
						 as dddd				 
				";
				// echo "<br>22Level Read:".$sql_maxpwr2;
				 $datamaxpwrxiduniqueop = $connect->query($sql_maxpwr2)->fetchAll();
				 foreach ($datamaxpwrxiduniqueop as $rowmaxpwriuniqeip) 
					{
							if ( $rowiduniqieop['uldl']==0 )
							{
								$_data_levelread_0_freq =  $rowmaxpwriuniqeip['arraydoublem'];
							}
							$_data_levelread_0_freq_data = str_replace($simbolosaborrar, "", $_data_levelread_0_freq);
						 
							if ( $rowiduniqieop['uldl'] ==1)
							{
								$_data_levelread_1_freq =  $rowmaxpwriuniqeip['arraydoublem'];
							}
							$_data_levelread_1_freq_data = str_replace($simbolosaborrar, "", $_data_levelread_1_freq);
					 
					}
					///////////////////////////////
					$data_0_reach = explode(",", $_data_levelread_0_reach);
						

		?>			     <div class="col " id="divgrafico700maxpwr00" name="divgrafico700maxpwr001">
						  
							  <div class="chart">
							  <p class="  colorazulfiplex" style="font-size: 14px"><b>Level Read 
							  <?php
							 if ($idscript==40 && $nameuldl  =="UpLink" && $rowiduniqieop['description'] =="700 FirstNet" ) 
							 { 
								 echo "700 & 800 - ". $nameuldl ;
							 }
							 else
							 {
								 echo $rowiduniqieop['description']." - ". $nameuldl ;
							 } 
							 
							// echo $name_graf;
							?>  </b>&nbsp; @<?php echo $data_0_reach[1];?>dBm</p>
							  
								  <canvas id="grafilevelreadnup_<?php echo $idgrapf; ?>" width="446" style="width: 446;"></canvas>
									  <?php $grafico_0_up_levelread ="grafilevelreadnup_".$idgrapf;?>  
							  </div>
						  </div>
						  
						  
				  
   	   
		  <script src="plugins/chart.js/Chart.min.js"	></script>
			<script type="text/javascript">
	
var grafico_0_up_levelread = document.getElementById('<?php echo $grafico_0_up_levelread;?>').getContext('2d');

var iduni_0_levelread_up = "<?php echo $_data_levelread_0_value;?>";	
var iduni_0_levelread_down_lbl = "<?php echo $_data_levelread_0_freq_data;?>";					 

iduni_0_levelread_up_data= iduni_0_levelread_up.split(",");  
iduni_0_levelread_down_lbl_data= iduni_0_levelread_down_lbl.split(",");  
 	    var configOptions_levelread_00 = {
                                  maintainAspectRatio : false,
                                  responsive : false,	
                                  legend: {
                                  display: false
                                  },                                  
                                            title: {
                                              display: true,
                                              text: '   '
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

                                            suggestedMin: (Math.min.apply(Math, iduni_0_levelread_up_data) - Math.abs(  Math.min.apply(Math, iduni_0_levelread_up_data)*0.1)),
                                            suggestedMax: (Math.max.apply(Math, iduni_0_levelread_up_data) + Math.abs(  Math.max.apply(Math, iduni_0_levelread_up_data)*0.1))
                                            }
                                          }]
                                  }
                                  }
								  
								     var datos_grafico_0_levelread = {
                                        labels  : iduni_0_levelread_down_lbl_data,
                                        datasets: [

                                                        {
                                                        label               : ' ',		
                                                        backgroundColor     : 'rgba(60,141,188,0.3)',
                                                        borderColor         : 'rgba(60,141,188,1)',
                                                        pointRadius          : false,
                                                        pointColor          : '#3b8bba',
                                                        pointStrokeColor    : 'rgba(60,141,188,1)',
                                                        pointHighlightFill  : '#fff',
                                                        pointHighlightStroke: 'rgba(60,141,188,1)',	
                                                        data          :iduni_0_levelread_up_data
                                                        },
                                                    ]
                                        };
										
							     var rpt_grafico700levelread00 = new Chart(grafico_0_up_levelread, { 
                              type: 'line', 	
                              data: datos_grafico_0_levelread,	 
                              options: configOptions_levelread_00
                            });
						
						
						</script>
		  
		   
		<?php
			}
	}

	function section_create_graph_LevelRead($name_graf, $idgrapf, $vp_runinfo, $idbandoffas)
 
	{
		include("db_conect.php"); 
		/// 7-0 FREQ
		/// 7 -0 Valores
		//select * from fnt_select_allmeasures_outcome_integral_mktmeasure(10902127375, 10702002638) where t_idfasoutcomecat = 7 and t_idtype = 1

		$sql_fastreem = "select * from fas_tree_measure where idrununfo =".$vp_runinfo."  AND iduniquebranch in('002007062') and band =  ".$idbandoffas;
	
	
		//	echo "Level READ<br>".$sql_fastreem;


		$simbolosaborrar = array("{", "}");
	
		$datalosiduniqye = $connect->query($sql_fastreem)->fetchAll();
	 	foreach ($datalosiduniqye as $rowiduniqieop) 
			{
				$sql_maxpwr2=  " select   t_idfasoutcomecat, t_idtype,
				ARRAY_AGG(t_v_double order by t_id_outcome) as arraydoublem
				from fnt_select_allmeasures_outcome_integral_ucmeasure(".$vp_runinfo.", ". $rowiduniqieop['iduniqueop'].")  where t_idfasoutcomecat = 5 and t_idtype in(14,18)
				group by t_idfasoutcomecat, t_idtype
				";
		//		 echo "<br>eeeee".$sql_maxpwr2;
				 $datamaxpwrxiduniqueop = $connect->query($sql_maxpwr2)->fetchAll();
				 foreach ($datamaxpwrxiduniqueop as $rowmaxpwriuniqeip) 
					{
						 
							if ( $rowiduniqieop['uldl'] ==0 &&   $rowmaxpwriuniqeip['t_idfasoutcomecat'] == 5  &&  $rowmaxpwriuniqeip['t_idtype'] ==18)
							{
								$_data_levelread_0 =  $rowmaxpwriuniqeip['arraydoublem'];
							}
							if ( $rowiduniqieop['uldl'] ==0 &&   $rowmaxpwriuniqeip['t_idfasoutcomecat'] == 5  &&  $rowmaxpwriuniqeip['t_idtype'] ==14)
							{
								$_data_levelread_0_reach =  $rowmaxpwriuniqeip['arraydoublem'];
							}

							$_data_levelread_0_value = str_replace($simbolosaborrar, "", $_data_levelread_0);
						 
					 
							if ($rowiduniqieop['uldl']==1 &&   $rowmaxpwriuniqeip['t_idfasoutcomecat'] == 5  &&  $rowmaxpwriuniqeip['t_idtype'] ==18)
							{
								$_data_levelread_1 =  $rowmaxpwriuniqeip['arraydoublem'];
							}
							if ( $rowiduniqieop['uldl'] ==0 &&   $rowmaxpwriuniqeip['t_idfasoutcomecat'] == 5  &&  $rowmaxpwriuniqeip['t_idtype'] ==14)
							{
								$_data_levelread_1_reach =  $rowmaxpwriuniqeip['arraydoublem'];
							}


							$_data_levelread_1_value = str_replace($simbolosaborrar, "", $_data_levelread_1);
					}
					///////////////////////////////
					$sql_maxpwr2=  "
					select ARRAY_AGG(v_double order by id_outcome) as arraydoublem
					from ( 
						select * from fas_outcome_integral 
						where reference in ( select t_id_outcome from fnt_select_allmeasures_outcome_integral_single(".$vp_runinfo.", ". $rowiduniqieop['iduniqueop'].")) and idfasoutcomecat = 6 and idtype =0)
						 as dddd


				 
				";
			//	 echo "<br>eeeee".$sql_maxpwr2;
				 $datamaxpwrxiduniqueop = $connect->query($sql_maxpwr2)->fetchAll();
				 foreach ($datamaxpwrxiduniqueop as $rowmaxpwriuniqeip) 
					{
							if ( $rowiduniqieop['uldl']==0 )
							{
								$_data_levelread_0_freq =  $rowmaxpwriuniqeip['arraydoublem'];
							}
							$_data_levelread_0_freq_data = str_replace($simbolosaborrar, "", $_data_levelread_0_freq);
						 
							if ( $rowiduniqieop['uldl'] ==1)
							{
								$_data_levelread_1_freq =  $rowmaxpwriuniqeip['arraydoublem'];
							}
							$_data_levelread_1_freq_data = str_replace($simbolosaborrar, "", $_data_levelread_1_freq);
					 
					}
					///////////////////////////////
					$data_0_reach = explode(",", $_data_levelread_0_reach);
					$data_1_reach = explode(",", $_data_levelread_1_reach);
				//	echo "HOLA:::".$data_0_reach[1];
			}	

			
			

		?>

	

	   <div class="col-6">
		  <hr style=" border: 1px solid #007bff;">
				  <div class="row"> 
						  <div class="col-6  " id="divgrafico700maxpwr00" name="divgrafico700maxpwr001">
						  
							  <div class="chart">
							  <p class="  colorazulfiplex" style="font-size: 14px"><b>Level Read <?php echo $name_graf;?> UpLink</b>&nbsp; @<?php echo $data_0_reach[1];?>dBm</p>
							  
								  <canvas id="grafilevelreadnup_<?php echo $idgrapf; ?>" width="446" style="width: 446;"></canvas>
									  <?php $grafico_0_up_levelread ="grafilevelreadnup_".$idgrapf;?>
  
							  </div>
						  </div>
						  <div class="col-6  " id="divgrafico700maxpwr00" name="divgrafico700maxpwr001">
						  
						  <div class="chart">
						  <p class="  colorazulfiplex" style="font-size: 14px"><b>Level Read <?php echo $name_graf;?> DownLink</b>&nbsp; @<?php echo $data_1_reach[1];?>dBm</p>
						  
							  <canvas id="grafilevelreadndown_<?php echo $idgrapf; ?>" width="446" style="width: 446;"></canvas>
								  <?php $grafico_0_down_levelread ="grafilevelreadndown_".$idgrapf;?>
  
						  </div>
					  </div>
					   
				  </div>
			   
   
		  </div>
		   
		  <script src="plugins/chart.js/Chart.min.js"	></script>
			<script type="text/javascript">
	
var grafico_0_up_levelread = document.getElementById('<?php echo $grafico_0_up_levelread;?>').getContext('2d');
var grafico_0_down_levelreadv = document.getElementById('<?php echo $grafico_0_down_levelread;?>').getContext('2d');

var iduni_0_levelread_up = "<?php echo $_data_levelread_0_value;?>";					 
var iduni_1_levelread_down = "<?php echo $_data_levelread_1_value;?>";					 

var iduni_0_levelread_down_lbl = "<?php echo $_data_levelread_0_freq_data;?>";					 
var iduni_1_levelread_down_lbl = "<?php echo $_data_levelread_1_freq_data;?>";	






iduni_0_levelread_up_data= iduni_0_levelread_up.split(",");  
iduni_1_levelread_down_data= iduni_1_levelread_down.split(",");  
iduni_0_levelread_down_lbl_data= iduni_0_levelread_down_lbl.split(",");  
iduni_1_levelread_down_lbl_data= iduni_1_levelread_down_lbl.split(",");  
/*
console.log('marco level');
console.log(iduni_0_levelread_up_data);
console.log(iduni_1_levelread_down_data);
console.log(iduni_0_levelread_down_lbl_data);
console.log(iduni_1_levelread_down_lbl_data);
 */

 	    var configOptions_levelread_00 = {
                                  maintainAspectRatio : false,
                                  responsive : false,	
                                  legend: {
                                  display: false
                                  },                                  
                                            title: {
                                              display: true,
                                              text: '   '
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

                                            suggestedMin: (Math.min.apply(Math, iduni_0_levelread_up_data) - Math.abs(  Math.min.apply(Math, iduni_0_levelread_up_data)*0.1)),
                                            suggestedMax: (Math.max.apply(Math, iduni_0_levelread_up_data) + Math.abs(  Math.max.apply(Math, iduni_0_levelread_up_data)*0.1))
                                            }
                                          }]
                                  }
                                  }
								  
								     var datos_grafico_0_levelread = {
                                        labels  : iduni_0_levelread_down_lbl_data,
                                        datasets: [

                                                        {
                                                        label               : ' ',		
                                                        backgroundColor     : 'rgba(60,141,188,0.3)',
                                                        borderColor         : 'rgba(60,141,188,1)',
                                                        pointRadius          : false,
                                                        pointColor          : '#3b8bba',
                                                        pointStrokeColor    : 'rgba(60,141,188,1)',
                                                        pointHighlightFill  : '#fff',
                                                        pointHighlightStroke: 'rgba(60,141,188,1)',	
                                                        data          :iduni_0_levelread_up_data
                                                        },
                                                    ]
                                        };
										
							     var rpt_grafico700levelread00 = new Chart(grafico_0_up_levelread, { 
                              type: 'line', 	
                              data: datos_grafico_0_levelread,	 
                              options: configOptions_levelread_00
                            });
						
							///// 2do graf max pwr
				 var configOptions_levelerad_11 = {
                                  maintainAspectRatio : false,
                                  responsive : false,	
                                  legend: {
                                  display: false
                                  },                                  
                                            title: {
                                              display: true,
                                              text: '  '
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

                                            suggestedMin: (Math.min.apply(Math, iduni_1_levelread_down_data) - Math.abs(  Math.min.apply(Math, iduni_1_levelread_down_data)*0.1)),
                                            suggestedMax: (Math.max.apply(Math, iduni_1_levelread_down_data) + Math.abs(  Math.max.apply(Math, iduni_1_levelread_down_data)*0.1))
                                            }
                                          }]
                                  }
                                  }
								  
								     var datos_grafico_1_levelread = {
                                        labels  : iduni_1_levelread_down_lbl_data ,
                                        datasets: [

                                                        {
                                                        label               : '',		
                                                        backgroundColor     : 'rgba(60,141,188,0.3)',
                                                        borderColor         : 'rgba(60,141,188,1)',
                                                        pointRadius          : false,
                                                        pointColor          : '#3b8bba',
                                                        pointStrokeColor    : 'rgba(60,141,188,1)',
                                                        pointHighlightFill  : '#fff',
                                                        pointHighlightStroke: 'rgba(60,141,188,1)',	
                                                        data          :iduni_1_levelread_down_data
                                                        },
                                                    ]
                                        };
										
							     var rpt_grafico700levelreadr00 = new Chart(grafico_0_down_levelreadv, { 
                              type: 'line', 	
                              data: datos_grafico_1_levelread ,
                              options: configOptions_levelerad_11
                            });			

						</script>
		  
		   
		<?php
	}

	function section_create_graph_LevelRead_burningtest($name_graf, $idgrapf, $vp_runinfo, $idbandoffas,$vparamv_sn)
 
	{
		include("db_conect.php"); 
		/// 7-0 FREQ
		/// 7 -0 Valores
		//select * from fnt_select_allmeasures_outcome_integral_mktmeasure(10902127375, 10702002638) where t_idfasoutcomecat = 7 and t_idtype = 1

		$sql_fastreem = "select iduniqueop 
		from fas_routines_process_sn 
		inner join fas_routines_steps
		on fas_routines_steps.idstep = fas_routines_process_sn.idstep
		where  idruninfodb = ".$vp_runinfo."  and sn = '".$vparamv_sn."'  and instance = '0520BF0C00C1'"	;
	
	
		//	echo "Level READ<br>".$sql_fastreem;


		$simbolosaborrar = array("{", "}");
	
		$datalosiduniqye = $connect->query($sql_fastreem)->fetchAll();
	 	foreach ($datalosiduniqye as $rowiduniqieop) 
			{
				$sql_maxpwr2=  " select  t_idband, t_uldl,  t_idfasoutcomecat, t_idtype,
				ARRAY_AGG(t_v_double order by t_id_outcome) as arraydoublem , ARRAY_AGG ( to_char(fas_outcome_integral.datetimeref, 'HH24:MI:SS') order by fas_outcome_integral.datetimeref asc ) AS arraylabel 
				from fnt_select_allmeasures_outcome_integral_ucmeasure(".$vp_runinfo.", ". $rowiduniqieop['iduniqueop'].") as ccc
				inner join fas_outcome_integral
				on fas_outcome_integral.id_outcome = ccc.t_id_outcome
				where t_idfasoutcomecat = 5 and t_idtype in(14,18,8,11) 
				group by t_idfasoutcomecat, t_idtype,  t_idband, t_uldl
				";


				$sql_maxpwr2="
				select  t_idband, t_uldl,  fas_outcome_integral.idfasoutcomecat as t_idfasoutcomecat, fas_outcome_integral.idtype as t_idtype,
							   ARRAY_AGG(fas_outcome_integral.v_double order by fas_outcome_integral.id_outcome) as arraydoublem , 
							   ARRAY_AGG ( to_char(fas_outcome_integral.datetimeref, 'HH24:MI:SS') order by fas_outcome_integral.datetimeref asc ) AS arraylabel 
							   from  (
								   
								  select 'UcMeasure' ::character varying as typemm, fas_outcome_integral.idfasoutcomecat::integer,
					   fas_outcome_integral.idtype::integer, fas_outcome_integral.id_outcome,  
						   fas_outcome_integral.v_boolean, fas_outcome_integral.v_integer, fas_outcome_integral.v_double,
						   fas_outcome_integral.v_string,  0, 0,0, t_uldl , t_idband, 'nomband',fas_outcome_integral.reference
						   from fas_outcome_integral	
						   inner join ( 
					
								   select losucmm.*,fas_outcome_integral.*
								   from 
								   (
									   select t_idband, t_uldl, v_integer, max(reference) as maxrefff from fas_outcome_integral
								   inner join (
												   select * from fnt_select_allmeasures_outcome_integral_single(".$vp_runinfo.", ". $rowiduniqieop['iduniqueop'].")
												   where t_idfasoutcomecat= 0 
									 ) as lossingle
									 on lossingle.t_id_outcome = fas_outcome_integral.reference
									where idfasoutcomecat = 6 and idtype = 13
								   -- and v_integer = 41
									group by t_idband, t_uldl, v_integer
								   ) as losucmm
								   inner join fas_outcome_integral
								   on fas_outcome_integral.reference = losucmm.maxrefff
									where fas_outcome_integral.idfasoutcomecat = 0 and idtype = 28
							   
							   
						   ) as lossameasure
						   on lossameasure.id_outcome = fas_outcome_integral.reference 
								   
									 ) as ccc
							   inner join fas_outcome_integral
							   on fas_outcome_integral.id_outcome = ccc.id_outcome
							   where fas_outcome_integral.idfasoutcomecat = 5 and fas_outcome_integral.idtype in(14,18,8,11) 
							   group by fas_outcome_integral.idfasoutcomecat, fas_outcome_integral.idtype,  t_idband, t_uldl
							   
							   ";

		//		 echo "<br>Sql datos:".$sql_maxpwr2;
				 $datamaxpwrxiduniqueop = $connect->query($sql_maxpwr2)->fetchAll();
				 foreach ($datamaxpwrxiduniqueop as $rowmaxpwriuniqeip) 
					{
						 
						if ( $rowmaxpwriuniqeip['t_idband'] ==0  &&  $rowmaxpwriuniqeip['t_uldl'] ==0 &&   $rowmaxpwriuniqeip['t_idfasoutcomecat'] == 5  &&  $rowmaxpwriuniqeip['t_idtype'] ==11)
							{
								$_data_temerat_0_0 =  $rowmaxpwriuniqeip['arraydoublem'];
								
							}

							if ( $rowmaxpwriuniqeip['t_idband'] ==0  &&  $rowmaxpwriuniqeip['t_uldl'] ==0 &&   $rowmaxpwriuniqeip['t_idfasoutcomecat'] == 5  &&  $rowmaxpwriuniqeip['t_idtype'] ==18)
							{
								$_data_levelread_0_0 =  $rowmaxpwriuniqeip['arraydoublem'];
								$_data_levelread_0_0_label = $rowmaxpwriuniqeip['arraylabel'];
							}

							if ( $rowmaxpwriuniqeip['t_idband'] ==0  &&  $rowmaxpwriuniqeip['t_uldl'] ==0 &&   $rowmaxpwriuniqeip['t_idfasoutcomecat'] == 5  &&  $rowmaxpwriuniqeip['t_idtype'] ==8)
							{
								$_data_pacurrent_0_0 =  $rowmaxpwriuniqeip['arraydoublem'];
								$_data_pacurrent_0_0_label = $rowmaxpwriuniqeip['arraylabel'];
							}
							if ( $rowmaxpwriuniqeip['t_idband'] ==0  &&  $rowmaxpwriuniqeip['t_uldl'] ==1 &&   $rowmaxpwriuniqeip['t_idfasoutcomecat'] == 5  &&  $rowmaxpwriuniqeip['t_idtype'] ==8)
							{
								$_data_pacurrent_0_1 =  $rowmaxpwriuniqeip['arraydoublem'];								
							}
							if ( $rowmaxpwriuniqeip['t_idband'] ==1  &&  $rowmaxpwriuniqeip['t_uldl'] ==0 &&   $rowmaxpwriuniqeip['t_idfasoutcomecat'] == 5  &&  $rowmaxpwriuniqeip['t_idtype'] ==8)
							{
								$_data_pacurrent_1_0 =  $rowmaxpwriuniqeip['arraydoublem'];								
							}
							if ( $rowmaxpwriuniqeip['t_idband'] ==1  &&  $rowmaxpwriuniqeip['t_uldl'] ==1 &&   $rowmaxpwriuniqeip['t_idfasoutcomecat'] == 5  &&  $rowmaxpwriuniqeip['t_idtype'] ==8)
							{
								$_data_pacurrent_1_1 =  $rowmaxpwriuniqeip['arraydoublem'];								
							}


						//	ECHO "<BR>".$rowmaxpwriuniqeip['t_idband']."-->".$rowmaxpwriuniqeip['t_uldl']."->". $rowmaxpwriuniqeip['t_idfasoutcomecat']."->". $rowmaxpwriuniqeip['t_idtype'];

							if ( $rowmaxpwriuniqeip['t_idband'] ==0  &&  $rowmaxpwriuniqeip['t_uldl'] ==1 &&   $rowmaxpwriuniqeip['t_idfasoutcomecat'] == 5  &&  $rowmaxpwriuniqeip['t_idtype'] ==18)
							{
								$_data_levelread_0_1 =  $rowmaxpwriuniqeip['arraydoublem'];
						//		ECHO "---------------------si";
							}
							if ( $rowmaxpwriuniqeip['t_idband'] ==0  && $rowmaxpwriuniqeip['t_uldl'] ==0 &&   $rowmaxpwriuniqeip['t_idfasoutcomecat'] == 5  &&  $rowmaxpwriuniqeip['t_idtype'] ==14)
							{
								$_data_levelread_0_reach =  $rowmaxpwriuniqeip['arraydoublem'];
							}

						
						 
					 
							if ( $rowmaxpwriuniqeip['t_idband'] ==1  && $rowmaxpwriuniqeip['t_uldl']==0 &&   $rowmaxpwriuniqeip['t_idfasoutcomecat'] == 5  &&  $rowmaxpwriuniqeip['t_idtype'] ==18)
							{
								$_data_levelread_1_0 =  $rowmaxpwriuniqeip['arraydoublem'];
							}
							if ( $rowmaxpwriuniqeip['t_idband'] ==1  && $rowmaxpwriuniqeip['t_uldl']==1 &&   $rowmaxpwriuniqeip['t_idfasoutcomecat'] == 5  &&  $rowmaxpwriuniqeip['t_idtype'] ==18)
							{
								$_data_levelread_1_1 =  $rowmaxpwriuniqeip['arraydoublem'];
							}

							if ( $rowmaxpwriuniqeip['t_idband'] ==1  && $rowmaxpwriuniqeip['t_uldl'] ==1 &&   $rowmaxpwriuniqeip['t_idfasoutcomecat'] == 5  &&  $rowmaxpwriuniqeip['t_idtype'] ==14)
							{
								$_data_levelread_1_reach =  $rowmaxpwriuniqeip['arraydoublem'];
							}

						
					}


					$_data_pacurrent_0_0 = str_replace($simbolosaborrar, "", $_data_pacurrent_0_0);
					$_data_pacurrent_0_1 = str_replace($simbolosaborrar, "", $_data_pacurrent_1_0);
					$_data_pacurrent_1_0 = str_replace($simbolosaborrar, "", $_data_pacurrent_0_1);
					$_data_pacurrent_1_1 = str_replace($simbolosaborrar, "", $_data_pacurrent_1_1);

					 
					$_data_temerat_0_0 = str_replace($simbolosaborrar, "", $_data_temerat_0_0);

					//label_values_pacurrent_voltread = data.label_pacurrent_voltread.split(",");
					$_data_levelread_0_0 = str_replace($simbolosaborrar, "", $_data_levelread_0_0);
					$_data_levelread_0_1 = str_replace($simbolosaborrar, "", $_data_levelread_0_1);
					$_data_levelread_1_0 = str_replace($simbolosaborrar, "", $_data_levelread_1_0);
					$_data_levelread_1_1 = str_replace($simbolosaborrar, "", $_data_levelread_1_1);

					$_data_levelread_0_0_value = str_replace($simbolosaborrar, "", $_data_levelread_0_0);
					$_data_levelread_0_1_value = str_replace($simbolosaborrar, "", $_data_levelread_0_1);

					$_data_levelread_0_0_label = str_replace($simbolosaborrar, "", $_data_levelread_0_0_label);
					$data_0__0_label  = explode(",", $_data_levelread_0_0_label);
				//	echo "***********data_0__0_label".var_dump($data_0__0_label);

					$_data_levelread_1_0_value = str_replace($simbolosaborrar, "", $_data_levelread_1_0);
					$_data_levelread_1_1_value = str_replace($simbolosaborrar, "", $_data_levelread_1_1);
					///////////////////////////////
					$sql_maxpwr2=  "
					select ARRAY_AGG(v_double order by id_outcome) as arraydoublem
					from ( 
						select * from fas_outcome_integral 
						where reference in ( select t_id_outcome from fnt_select_allmeasures_outcome_integral_single(".$vp_runinfo.", ". $rowiduniqieop['iduniqueop'].")) and idfasoutcomecat = 6 and idtype =0)
						 as dddd
				 
				";
			//	 echo "<br>eeeee".$sql_maxpwr2;
				 $datamaxpwrxiduniqueop = $connect->query($sql_maxpwr2)->fetchAll();
				 foreach ($datamaxpwrxiduniqueop as $rowmaxpwriuniqeip) 
					{
							if ( $rowmaxpwriuniqeip['t_uldl']==0 )
							{
								$_data_levelread_0_freq =  $rowmaxpwriuniqeip['arraydoublem'];
							}
							$_data_levelread_0_freq_data = str_replace($simbolosaborrar, "", $_data_levelread_0_freq);
						 
							if ( $rowmaxpwriuniqeip['t_uldl'] ==1)
							{
								$_data_levelread_1_freq =  $rowmaxpwriuniqeip['arraydoublem'];
							}
							$_data_levelread_1_freq_data = str_replace($simbolosaborrar, "", $_data_levelread_1_freq);
					 
					}
					///////////////////////////////
					$data_0_reach = explode(",", $_data_levelread_0_reach);
					$data_1_reach = explode(",", $_data_levelread_1_reach);
				//	echo "HOLA:::".$data_0_reach[1];
			}	

			
			

		?>

	

	 
<div class="col-12">
		  <hr style=" border: 1px solid #007bff;">
				  <div class="row"> 
				  <div class="col-12  " id="divgrafico700maxpwr00temp" name="divgrafico700maxpwr001temp">
						  
						  <div class="chart">
						  <p class="  colorazulfiplex" style="font-size: 14px"><b>Temperature</b>&nbsp;  </p>
						  
							  <canvas id="grafilevelreadndowntemp_<?php echo $idgrapf; ?>" height="400px" width="1500px" style="width: 1500px;"></canvas>
								  <?php $grafico_0_down_levelreadtemp ="grafilevelreadndowntemp_".$idgrapf;?>
  
						  </div>
					  </div>
					 	  <div class="col-12 " id="divgrafico700maxpwr00" name="divgrafico700maxpwr001">
						  <hr style=" border: 1px solid #007bff;">
							  <div class="chart">
							  <p class="  colorazulfiplex" style="font-size: 14px"><b>Level Read  </b>&nbsp; @<?php echo $data_0_reach[1];?>dBm</p>
							  
								  <canvas id="grafilevelreadnup_<?php echo $idgrapf; ?>"  height="400px" width="1500px" style="width: 1500px;" ></canvas>
									  <?php $grafico_0_up_levelread ="grafilevelreadnup_".$idgrapf;?>
  
							  </div>
						  </div>
						
						  <div class="col-12  " id="divgrafico700maxpwr00" name="divgrafico700maxpwr001">
						  <hr style=" border: 1px solid #007bff;">
						  <div class="chart">
						  <p class="  colorazulfiplex" style="font-size: 14px"><b>PA Current</b>&nbsp;  </p>
						  
							  <canvas id="grafilevelreadndown_<?php echo $idgrapf; ?>"  height="400px" width="1500px" style="width: 1500px;"></canvas>
								  <?php $grafico_0_down_levelread ="grafilevelreadndown_".$idgrapf;?>
  
						  </div>

					  </div>

				
					   
				  </div>
			   
   
		  </div>
		   
		  <script src="plugins/chart.js/Chart.min.js"	></script>
		  <script src="plugins/moment/moment.min.js"></script>
			<script type="text/javascript">
	
	function secondsToString(seconds) {
  var hour = Math.floor(seconds / 3600);
  hour = (hour < 10)? '0' + hour : hour;
  var minute = Math.floor((seconds / 60) % 60);
  minute = (minute < 10)? '0' + minute : minute;
  var second = seconds % 60;
  second = (second < 10)? '0' + second : second;
  return hour + ':' + minute + ':' + second;
}



var grafico_0_up_levelread = document.getElementById('<?php echo $grafico_0_up_levelread;?>').getContext('2d');
var grafico_0_down_levelreadv = document.getElementById('<?php echo $grafico_0_down_levelread;?>').getContext('2d');
var grafico_0_down_levelreadvtemperat = document.getElementById('<?php echo $grafico_0_down_levelreadtemp;?>').getContext('2d');

var iduni_0_levelread_up = "<?php echo $_data_levelread_0_0_value;?>";					 
var iduni_0_levelread_down = "<?php echo $_data_levelread_0_1_value;?>";					 

var momentNow = moment();
var data_00_label  = "<?php echo $_data_levelread_0_0_label;?>";  	
data_00_label = data_00_label.split(","); 
console.log('los tiempos');
console.log(data_00_label);
var sumarmunitos = new Date('2020-01-01 00:00:00');
var nuevolabeltemp_0_0_temp = [];
	for (let i = 0; i < data_00_label.length; i++) 
			{
		
			var date1 = moment("2022-01-01 " + data_00_label[0]);
			var date2 = moment("2022-01-01 " +data_00_label[i]);
		
	
			var diff = date2.diff(date1,'s');

			nuevolabeltemp_0_0_temp.push(secondsToString(diff));

			
			}	 


var iduni_1_levelread_up = "<?php echo $_data_levelread_1_0_value;?>";					 
var iduni_1_levelread_down = "<?php echo $_data_levelread_1_1_value;?>";					 

var iduni_0_levelread_down_lbl = "<?php echo $_data_levelread_0_freq_data;?>";					 
var iduni_1_levelread_down_lbl = "<?php echo $_data_levelread_1_freq_data;?>";	



iduni_0_levelread_up_data= iduni_0_levelread_up.split(",");  
iduni_0_levelread_down_data= iduni_0_levelread_down.split(",");  


iduni_1_levelread_up_data= iduni_1_levelread_up.split(",");  
iduni_1_levelread_down_data= iduni_1_levelread_down.split(",");  

var v_data_temerat_0_0 = "<?php echo $_data_temerat_0_0;?>";	

var iduni_0_0_pacurrent = "<?php echo $_data_pacurrent_0_0;?>";	
var iduni_0_1_pacurrent = "<?php echo $_data_pacurrent_0_1;?>";	
var iduni_1_0_pacurrent = "<?php echo $_data_pacurrent_1_0;?>";	
var iduni_1_1_pacurrent = "<?php echo $_data_pacurrent_1_1;?>";	

v_data_temerat_0_0= v_data_temerat_0_0.split(",");  

iduni_0_0_pacurrent= iduni_0_0_pacurrent.split(",");  
iduni_0_1_pacurrent= iduni_0_1_pacurrent.split(",");  
iduni_1_0_pacurrent= iduni_1_0_pacurrent.split(",");  
iduni_1_1_pacurrent= iduni_1_1_pacurrent.split(",");  

console.log('PA CURRENT');
console.log(iduni_0_0_pacurrent);
console.log(iduni_0_1_pacurrent);
console.log(iduni_1_0_pacurrent);
console.log(iduni_1_1_pacurrent);


console.log(nuevolabeltemp_0_0_temp);



iduni_0_levelread_down_lbl_data= iduni_0_levelread_down_lbl.split(",");  
iduni_1_levelread_down_lbl_data= iduni_1_levelread_down_lbl.split(",");  

console.log('marco level');
console.log(iduni_0_levelread_up_data);
console.log(iduni_1_levelread_up_data);

console.log(iduni_0_levelread_down_data);
console.log(iduni_1_levelread_down_data);

console.log('marco lbl');
console.log(iduni_0_levelread_down_lbl_data);

 	    var configOptions_levelread_00spec = {
                                  maintainAspectRatio : false,
                                  responsive : false,	
                                  legend: {
                                  display: true
                                  },                                  
                                            title: {
                                              display: true,
                                              text: '   '
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
										 
                                          }]
                                  }
                                  }

								  var configOptions_levelread_11spec = {
                                  maintainAspectRatio : true,
                                  responsive : false,	
                                  legend: {
                                  display: true
                                  },                                  
                                            title: {
                                              display: true,
                                              text: '   '
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
										 
                                          }]
                                  }
                                  }
								  
								     var datos_grafico_0_levelread = {
                                        labels  : nuevolabeltemp_0_0_temp,
                                        datasets: [

                                                        {
                                                        label               : 'Band 0 Up ',		                                                       
														borderColor         : 'rgba(255, 99, 132, 1)',
														backgroundColor     : 'rgba(60,141,188,0)',
														pointRadius         : false,
														pointColor          : 'rgba(255, 99, 132, 1)',
														pointHighlightFill  : '#fff',

                                                        data          :iduni_0_levelread_up_data
                                                        } ,
														
														{
                                                        label               : 'Band 1 Up ',															 
														borderColor         : 'rgba(40,121,168,1)',
														backgroundColor     : 'rgba(60,141,188,0)',
														pointRadius         : false,
														pointColor          : 'rgba(255, 99, 132, 1)',
														pointHighlightFill  : '#fff',
															 
                                                        data          :iduni_1_levelread_up_data	
                                                        } ,
														{
                                                        label               : 'Band 0 Down ',		
														borderColor         : 'rgba(80,161,208,1)',
                                                     
														backgroundColor     : 'rgba(60,141,188,0)',
														pointRadius         : false,
														pointColor          : 'rgba(255, 99, 132, 1)',
														pointHighlightFill  : '#fff',
                                                   
                                                        data          :iduni_0_levelread_down_data
                                                        },
														{
                                                        label               : 'Band 1 Dwown',															 
														 
																borderColor         : 'rgba(200, 19, 100, 1)',
																backgroundColor     : 'rgba(60,141,188,0)',
														pointRadius         : false,
														pointColor          : 'rgba(255, 99, 132, 1)',
														pointHighlightFill  : '#fff',
													 
                                                        data          :iduni_1_levelread_down_data
                                                        },
                                                    ]
                                        };
										
							     var rpt_grafico700levelread00 = new Chart(grafico_0_up_levelread, { 
                              type: 'line', 	
                              data: datos_grafico_0_levelread,	 
                              options: configOptions_levelread_00spec  
                            });



							var datos_grafico_1_levelread = {
                                        labels  : nuevolabeltemp_0_0_temp,
                                        datasets: [

											{
                                                        label               : 'Band 0 Up ',		                                                       
														borderColor         : 'rgba(255, 99, 132, 1)',
														backgroundColor     : 'rgba(60,141,188,0)',
														pointRadius         : false,
														pointColor          : 'rgba(255, 99, 132, 1)',
														pointHighlightFill  : '#fff',

                                                        data          :iduni_0_0_pacurrent
                                                        } ,
														
														{
                                                        label               : 'Band 1 Up ',															 
														borderColor         : 'rgba(40,121,168,1)',
														backgroundColor     : 'rgba(60,141,188,0)',
														pointRadius         : false,
														pointColor          : 'rgba(255, 99, 132, 1)',
														pointHighlightFill  : '#fff',
															 
                                                        data          :iduni_1_0_pacurrent	
                                                        } ,
														{
                                                        label               : 'Band 0 Down ',		
														borderColor         : 'rgba(80,161,208,1)',
                                                     
														backgroundColor     : 'rgba(60,141,188,0)',
														pointRadius         : false,
														pointColor          : 'rgba(255, 99, 132, 1)',
														pointHighlightFill  : '#fff',
                                                   
                                                        data          :iduni_0_1_pacurrent
                                                        },
														{
                                                        label               : 'Band 1 Dwown',															 
														 
																borderColor         : 'rgba(200, 19, 100, 1)',
																backgroundColor     : 'rgba(60,141,188,0)',
														pointRadius         : false,
														pointColor          : 'rgba(255, 99, 132, 1)',
														pointHighlightFill  : '#fff',
													 
                                                        data          :iduni_1_1_pacurrent
                                                        },
													 
                                                    ]
                                        };
 

										///datos_grafico_1_temp
										var datos_grafico_1_temp = {
                                        labels  : nuevolabeltemp_0_0_temp,
                                        datasets: [

											{
                                                        label               : 'Temperature',		                                                       
														borderColor         : 'rgba(255, 99, 132, 1)',
														backgroundColor     : 'rgba(60,141,188,0)',
														pointRadius         : false,
														pointColor          : 'rgba(255, 99, 132, 1)',
														pointHighlightFill  : '#fff',

                                                        data          :v_data_temerat_0_0
                                                        }  
													 
                                                    ]
                                        };
 
										
							     var rpt_grafico700levelreadr00 = new Chart(grafico_0_down_levelreadv, { 
                              type: 'line', 	
                              data: datos_grafico_1_levelread ,
                              options: configOptions_levelread_11spec 
                            });			
						
						 

							var rpt_grafico700levelreadr00temp = new Chart(grafico_0_down_levelreadvtemperat, { 
                              type: 'line', 	
                              data: datos_grafico_1_temp ,
                             options: configOptions_levelread_11spec 
                            });			
						

							

						</script>
		  
		   
		<?php
	}

	function section_create_graph_MaxPwr($name_graf, $idgrapf, $vp_runinfo, $idbandoffas)
	{
		include("db_conect.php"); 
		/// 7-0 FREQ
		/// 7 -0 Valores
		//select * from fnt_select_allmeasures_outcome_integral_mktmeasure(10902127375, 10702002638) where t_idfasoutcomecat = 7 and t_idtype = 1

		$sql_fastreem = "select * from fas_tree_measure where idrununfo =".$vp_runinfo."  AND iduniquebranch in('00200701A') and band =  ".$idbandoffas;
	
	
		//	echo "MAX PWR<br>".$sql_fastreem;


	$simbolosaborrar = array("{", "}");
	$_data_maxpwr_0_value ="";
	$_data_maxpwr_1_value ="";
		$datalosiduniqye = $connect->query($sql_fastreem)->fetchAll();
	 	foreach ($datalosiduniqye as $rowiduniqieop) 
			{
				$sql_maxpwr2=  " select   t_idfasoutcomecat, t_idtype,
				ARRAY_AGG(t_v_double order by t_id_outcome) as arraydoublem
				from fnt_select_allmeasures_outcome_integral_mktmeasure(".$vp_runinfo.", ". $rowiduniqieop['iduniqueop'].")  where t_idfasoutcomecat = 7 and t_idtype in(0,1)
				group by t_idfasoutcomecat, t_idtype
				";
			//	 echo "<br>eeeee".$sql_maxpwr2;
				 $datamaxpwrxiduniqueop = $connect->query($sql_maxpwr2)->fetchAll();
				 foreach ($datamaxpwrxiduniqueop as $rowmaxpwriuniqeip) 
					{
							if ( $rowiduniqieop['uldl']==0 &&   $rowmaxpwriuniqeip['t_idfasoutcomecat'] == 7  &&  $rowmaxpwriuniqeip['t_idtype'] ==0)
							{
								$_data_maxpwr_0_freq =  $rowmaxpwriuniqeip['arraydoublem'];
							}
							$_data_maxpwr_0_freq = str_replace($simbolosaborrar, "", $_data_maxpwr_0_freq);
							if ( $rowiduniqieop['uldl'] ==0 &&   $rowmaxpwriuniqeip['t_idfasoutcomecat'] == 7  &&  $rowmaxpwriuniqeip['t_idtype'] ==1 && $_data_maxpwr_0_value =="")
							{
								$_data_maxpwr_0_value =  $rowmaxpwriuniqeip['arraydoublem'];
							}
							$_data_maxpwr_0_value = str_replace($simbolosaborrar, "", $_data_maxpwr_0_value);
							if ( $rowiduniqieop['uldl'] ==1 &&   $rowmaxpwriuniqeip['t_idfasoutcomecat'] == 7  &&  $rowmaxpwriuniqeip['t_idtype'] ==0 )
							{
								$_data_maxpwr_1_freq =  $rowmaxpwriuniqeip['arraydoublem'];
							}
							$_data_maxpwr_1_freq = str_replace($simbolosaborrar, "", $_data_maxpwr_1_freq);
						//	echo "A VER".$rowiduniqieop['uldl'];
						 
							if ($rowiduniqieop['uldl']==1 &&   $rowmaxpwriuniqeip['t_idfasoutcomecat'] == 7  &&  $rowmaxpwriuniqeip['t_idtype'] ==1 && $_data_maxpwr_1_value =="")
							{
								$_data_maxpwr_1_value =  $rowmaxpwriuniqeip['arraydoublem'];
							}
							$_data_maxpwr_1_value = str_replace($simbolosaborrar, "", $_data_maxpwr_1_value);
					}

			}	

		?>

	

	   <div class="col-6">
		  <hr style=" border: 1px solid #007bff;">
				  <div class="row"> 
						  <div class="col-6  " id="divgrafico700maxpwr00" name="divgrafico700maxpwr00">
						  
							  <div class="chart">
							  <p class="  colorazulfiplex" style="font-size: 14px"><b>Max Power <?php echo $name_graf;?> UpLink</b></p>
							  
								  <canvas id="grafimaxpwrnup_<?php echo $idgrapf; ?>" width="446" style="width: 446;"></canvas>
									  <?php $grafico_0_down_maxprw ="grafimaxpwrnup_".$idgrapf;?>
  
							  </div>
						  </div>
						  <div class="col-6  " id="divgrafico700maxpwr00" name="divgrafico700maxpwr00">
						  
						  <div class="chart">
						  <p class="  colorazulfiplex" style="font-size: 14px"><b>Max Power <?php echo $name_graf;?> DownLink</b></p>
						  
							  <canvas id="grafimaxpwrn_down<?php echo $idgrapf; ?>" width="446" style="width: 446;"></canvas>
								  <?php $grafico_1_down_maxprw ="grafimaxpwrn_down".$idgrapf;?>
  
						  </div>
					  </div>
					   
				  </div>
			   
   
		  </div>
		   
		  <script src="plugins/chart.js/Chart.min.js"	></script>
			<script type="text/javascript">
	
var grafico_0_maxpwr = document.getElementById('<?php echo $grafico_0_down_maxprw;?>').getContext('2d');
var grafico_1_maxpwr = document.getElementById('<?php echo $grafico_1_down_maxprw;?>').getContext('2d');

var iduni_0_maxpwr_up = "<?php echo $_data_maxpwr_0_value;?>";					 
var iduni_1_maxpwr_up = "<?php echo $_data_maxpwr_1_value;?>";					 

var iduni_0_maxpwr_up_lbl = "<?php echo $_data_maxpwr_0_freq;?>";					 
var iduni_1_maxpwr_up_lbl = "<?php echo $_data_maxpwr_1_freq;?>";	



iduni_0_maxpwr_up_data= iduni_0_maxpwr_up.split(",");  
iduni_1_maxpwr_up_data= iduni_1_maxpwr_up.split(",");  
iduni_0_maxpwr_up_lbl_data= iduni_0_maxpwr_up_lbl.split(",");  
iduni_1_maxpwr_up_lbl_data= iduni_1_maxpwr_up_lbl.split(",");  
/*
console.log('abccceeeec');
console.log(iduni_0_maxpwr_up);
console.log(iduni_0_maxpwr_up_lbl);
console.log(iduni_1_maxpwr_up);
console.log(iduni_1_maxpwr_up_lbl);
*/
 

 	    var configOptions_maxpwr_00 = {
                                  maintainAspectRatio : false,
                                  responsive : false,	
                                  legend: {
                                  display: false
                                  },                                  
                                            title: {
                                              display: true,
                                              text: ' '
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

                                            suggestedMin: (Math.min.apply(Math, iduni_0_maxpwr_up_data) - Math.abs(  Math.min.apply(Math, iduni_0_maxpwr_up_data)*0.1)),
                                            suggestedMax: (Math.max.apply(Math, iduni_0_maxpwr_up_data) + Math.abs(  Math.max.apply(Math, iduni_0_maxpwr_up_data)*0.1))
                                            }
                                          }]
                                  }
                                  }
								  
								     var datos_grafico_0_maxpwr = {
                                        labels  : iduni_0_maxpwr_up_lbl_data,
                                        datasets: [

                                                        {
                                                        label               : ' ',		
                                                        backgroundColor     : 'rgba(60,141,188,0.3)',
                                                        borderColor         : 'rgba(60,141,188,1)',
                                                        pointRadius          : false,
                                                        pointColor          : '#3b8bba',
                                                        pointStrokeColor    : 'rgba(60,141,188,1)',
                                                        pointHighlightFill  : '#fff',
                                                        pointHighlightStroke: 'rgba(60,141,188,1)',	
                                                        data          :iduni_0_maxpwr_up_data
                                                        },
                                                    ]
                                        };
										
							     var rpt_grafico700maxpwr00 = new Chart(grafico_0_maxpwr, { 
                              type: 'line', 	
                              data: datos_grafico_0_maxpwr,	 
                              options: configOptions_maxpwr_00
                            });
						
							///// 2do graf max pwr
				 var configOptions_maxpwr_11 = {
                                  maintainAspectRatio : false,
                                  responsive : false,	
                                  legend: {
                                  display: false
                                  },                                  
                                            title: {
                                              display: true,
                                              text: '  '
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

                                            suggestedMin: (Math.min.apply(Math, iduni_1_maxpwr_up_data) - Math.abs(  Math.min.apply(Math, iduni_1_maxpwr_up_data)*0.1)),
                                            suggestedMax: (Math.max.apply(Math, iduni_1_maxpwr_up_data) + Math.abs(  Math.max.apply(Math, iduni_1_maxpwr_up_data)*0.1))
                                            }
                                          }]
                                  }
                                  }
								  
								     var datos_grafico_1_maxpwr = {
                                        labels  : iduni_1_maxpwr_up_lbl_data ,
                                        datasets: [

                                                        {
                                                        label               : '',		
                                                        backgroundColor     : 'rgba(60,141,188,0.3)',
                                                        borderColor         : 'rgba(60,141,188,1)',
                                                        pointRadius          : false,
                                                        pointColor          : '#3b8bba',
                                                        pointStrokeColor    : 'rgba(60,141,188,1)',
                                                        pointHighlightFill  : '#fff',
                                                        pointHighlightStroke: 'rgba(60,141,188,1)',	
                                                        data          :iduni_1_maxpwr_up_data
                                                        },
                                                    ]
                                        };
										
							     var rpt_grafico700maxpwr00 = new Chart(grafico_1_maxpwr, { 
                              type: 'line', 	
                              data: datos_grafico_1_maxpwr ,
                              options: configOptions_maxpwr_11
                            });			

						</script>
		  
		   
		<?php
	}


	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////////////////////////////////////////////////
function section_create_graph_MaxPwr_by_idrun_sn($vp_runinfo,$v_sn,$idscript, $idinstancemap)
{
	///  description = 'AcceptDiB_Measure_MaxPower'
	include("db_conect.php"); 
	$sqlgenerardivmaxpwr = "
	select *
from 
(
    select losiduniqueop.* , outcomeband.v_integer as idbanda, outcomeuldl.v_integer as uldl
      
    from 
    (
        select  losdd.*
	from fnt_select_allfas_routines_process_sn_maxrev_byscript_byidrun('".$v_sn."',".$idscript." ,".$vp_runinfo." ) as  losdd
	inner join fas_routines_steps
	on fas_routines_steps.idstep = losdd.idstep 
	inner join fas_step
	on fas_step.instance = fas_routines_steps.instance  
	where fas_routines_steps.instance = '".$idinstancemap."'  
) as losiduniqueop
inner join fas_outcome_integral 
on fas_outcome_integral.v_bigint = losiduniqueop.iduniqueop


  left join fas_outcome_integral as outcomeband
on outcomeband.reference = fas_outcome_integral.id_outcome and
   outcomeband.idfasoutcomecat = 1 and
   outcomeband.idtype          = 1
   left join fas_outcome_integral as outcomeuldl
on outcomeuldl.reference = fas_outcome_integral.id_outcome and
   outcomeuldl.idfasoutcomecat = 1 and
   outcomeuldl.idtype          = 2


) as tt
inner join idband
on idband.idband = tt.idbanda
";
//echo $sqlgenerardivmaxpwr;
//echo "<br>";
	$simbolosaborrar = array("{", "}");
	$datagainmm = $connect->query($sqlgenerardivmaxpwr)->fetchAll();
	 foreach ($datagainmm as $rowgainm) 
		{
			$nameuldl ="";
			$idgrapf = $rowgainm['iduniqueop'];
			if ($rowgainm['uldl']==0)
			{
				$nameuldl ="UpLink";
			}
			else
			{
				$nameuldl ="Down";
			}

			/////////////////////////////////////////////////////////////////////////////////////////////////////
			//////Buscamos las mediciones del iduniqueop
			/////////////////////////////////////////////////////////////////////////////////////////////////////
			$simbolosaborrar = array("{", "}");
			$sql_maxpwr2=  "	select t_idfasoutcomecat, t_idtype, ARRAY_AGG(t_v_double order by t_id_outcome) as arraydoublem from 
				fnt_select_allmeasures_outcome_integral_mktmeasure_ns(".$idgrapf.") where t_idfasoutcomecat = 7 and t_idtype in(0,1) group by t_idfasoutcomecat, t_idtype";
			// echo "<br>MAXPWR".$sql_maxpwr2;
			 $datamaxpwrxiduniqueop = $connect->query($sql_maxpwr2)->fetchAll();
			 foreach ($datamaxpwrxiduniqueop as $rowmaxpwriuniqeip) 
				{
					if (    $rowmaxpwriuniqeip['t_idfasoutcomecat'] == 7  &&  $rowmaxpwriuniqeip['t_idtype'] ==0)
					{
						$_data_maxpwr_0_freq =  $rowmaxpwriuniqeip['arraydoublem'];
					}
					$_data_maxpwr_0_freq = str_replace($simbolosaborrar, "", $_data_maxpwr_0_freq);
					if (   $rowmaxpwriuniqeip['t_idfasoutcomecat'] == 7  &&  $rowmaxpwriuniqeip['t_idtype'] ==1 && $_data_maxpwr_0_value =="")
					{
						$_data_maxpwr_0_value =  $rowmaxpwriuniqeip['arraydoublem'];
					}
					$_data_maxpwr_0_value = str_replace($simbolosaborrar, "", $_data_maxpwr_0_value);				
					 
				}
				/////////////////////////////////////////////////////////////////////////////////////////////////////
				/////////////////////////////////////////////////////////////////////////////////////////////////////
				/////////////////////////////////////////////////////////////////////////////////////////////////////
			//	echo "<br>".$_data_maxpwr_0_value;
		?>
			  <div class="col" id="divgrafico700maxpwrn00" name="divgrafico700maxpwrn00">					  
					  <div class="chart">
					  <p class="  colorazulfiplex" style="font-size: 14px"><b>MaxPwr <?php 

							if ($idscript==38)
							{
							$idscript=40;
							}

					 	if ($idscript==40 && $nameuldl  =="UpLink" && $rowgainm['description'] =="700 FirstNet" ) 
						 { 
							 echo "700 & 800 - ". $nameuldl ;
						 }
						 else
						 {
							 echo $rowgainm['description']." - ". $nameuldl ;
						 }

					//  echo $rowgainm['description']." - ". $nameuldl ;?> </b></p>					  
						  <canvas id="grafimaxprwnup_<?php echo $idgrapf; ?>" width="446" style="width: 446;"></canvas>
							  <?php $grafico_0_down_maxprw ="grafimaxprwnup_".$idgrapf;?>
					  </div>
				  </div>				
		 <script src="plugins/chart.js/Chart.min.js"	></script>
		<script type="text/javascript">	
var grafico_0_maxpwr = document.getElementById('<?php echo $grafico_0_down_maxprw;?>').getContext('2d');

var iduni_0_maxpwr_up = "<?php echo $_data_maxpwr_0_value;?>";	
var iduni_0_maxpwr_up_lbl = "<?php echo $_data_maxpwr_0_freq;?>";					 
iduni_0_maxpwr_up_data= iduni_0_maxpwr_up.split(",");  
iduni_0_maxpwr_up_lbl_data= iduni_0_maxpwr_up_lbl.split(",");  
console.log('iduni_0_maxpwr_up_data');
console.log(iduni_0_maxpwr_up_data);
console.log('iduni_0_maxpwr_up_lbl_data');
console.log(iduni_0_maxpwr_up_lbl_data);
 	    var configOptions_maxpwr_00 = {
                                  maintainAspectRatio : false,
                                  responsive : false,	
                                  legend: {
                                  display: false
                                  },                                  
                                            title: {
                                              display: true,
                                              text: ' '
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

                                            suggestedMin: (Math.min.apply(Math, iduni_0_maxpwr_up_data) - Math.abs(  Math.min.apply(Math, iduni_0_maxpwr_up_data)*0.1)),
                                            suggestedMax: (Math.max.apply(Math, iduni_0_maxpwr_up_data) + Math.abs(  Math.max.apply(Math, iduni_0_maxpwr_up_data)*0.1))
                                            }
                                          }]
                                  }
                                  }
								  
								     var datos_grafico_0_maxpwr = {
                                        labels  : iduni_0_maxpwr_up_lbl_data,
                                        datasets: [

                                                        {
                                                        label               : ' ',		
                                                        backgroundColor     : 'rgba(60,141,188,0.3)',
                                                        borderColor         : 'rgba(60,141,188,1)',
                                                        pointRadius          : false,
                                                        pointColor          : '#3b8bba',
                                                        pointStrokeColor    : 'rgba(60,141,188,1)',
                                                        pointHighlightFill  : '#fff',
                                                        pointHighlightStroke: 'rgba(60,141,188,1)',	
                                                        data          :iduni_0_maxpwr_up_data
                                                        },
                                                    ]
                                        };
										
							     var rpt_grafico700maxpwr00 = new Chart(grafico_0_maxpwr, { 
                              type: 'line', 	
                              data: datos_grafico_0_maxpwr,	 
                              options: configOptions_maxpwr_00
                            });
						
						 

						</script>




			<?php
		}	

}

////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////

function section_create_graph_IMD_by_idrun_sn($vp_runinfo,$v_sn,$idscript,$idinstancemimd)
{

	include("db_conect.php"); 
		/// 7-0 FREQ
		/// 7 -0 Valores
		//select * from fnt_select_allmeasures_outcome_integral_mktmeasure(10902127375, 10702002638) where t_idfasoutcomecat = 7 and t_idtype = 1
/////description = 'AcceptDiB_Measures_IMD'
		$sql_fastreem = "
		select *
	from 
	(
		select losiduniqueop.* , outcomeband.v_integer as idbanda, outcomeuldl.v_integer as uldl
		  
		from 
		(
			select  losdd.* , fas_routines_steps.instance  as instancemm
		from fnt_select_allfas_routines_process_sn_maxrev_byscript_byidrun('".$v_sn."',".$idscript." ,".$vp_runinfo." ) as  losdd
		inner join fas_routines_steps
		on fas_routines_steps.idstep = losdd.idstep 
		inner join fas_step
		on fas_step.instance = fas_routines_steps.instance  
		where  fas_routines_steps.instance = '".$idinstancemimd."'  
	) as losiduniqueop
	inner join fas_outcome_integral 
	on fas_outcome_integral.v_bigint = losiduniqueop.iduniqueop
	
	
	  left join fas_outcome_integral as outcomeband
	on outcomeband.reference = fas_outcome_integral.id_outcome and
	   outcomeband.idfasoutcomecat = 1 and
	   outcomeband.idtype          = 1
	   left join fas_outcome_integral as outcomeuldl
	on outcomeuldl.reference = fas_outcome_integral.id_outcome and
	   outcomeuldl.idfasoutcomecat = 1 and
	   outcomeuldl.idtype          = 2
	
	
	) as tt
	inner join idband
	on idband.idband = tt.idbanda and idband.active = 'Y'
	";
		$simbolosaborrar = array("{", "}");
//	echo $sql_fastreem;
	$datalosiduniqye = $connect->query($sql_fastreem)->fetchAll();
	foreach ($datalosiduniqye as $rowiduniqieop) 
	   {

		$nameuldl ="";
		$idbandoffas =  $rowiduniqieop['idbanda'];	
		$instancemm =  $rowiduniqieop['instancemm'];	
			$idgrapf = $rowiduniqieop['iduniqueop'];
			if ($rowiduniqieop['uldl']==0)
			{
				$nameuldl ="UpLink";
			}
			else
			{
				$nameuldl ="Down";
			}

		   $sql_maxpwr2=  " select   t_idfasoutcomecat, t_idtype,
		   ARRAY_AGG(t_v_double order by t_id_outcome) as arraydoublem
		   from fnt_select_allmeasures_outcome_integral_mktmeasure_ns(".$idgrapf.")  
		   group by t_idfasoutcomecat, t_idtype
		   ";
		//	echo "<br>eeeee".$sql_maxpwr2;
			$datamaxpwrxiduniqueop = $connect->query($sql_maxpwr2)->fetchAll();
			foreach ($datamaxpwrxiduniqueop as $rowmaxpwriuniqeip) 
			   {
					   if (  $rowmaxpwriuniqeip['t_idfasoutcomecat'] == 7  &&  $rowmaxpwriuniqeip['t_idtype'] ==0)
					   {
						   $_data_imd_0_freq =  $rowmaxpwriuniqeip['arraydoublem'];
					   }
					   $_data_imd_0_freq = str_replace($simbolosaborrar, "", $_data_imd_0_freq);
					   if (  $rowmaxpwriuniqeip['t_idfasoutcomecat'] == 7  &&  $rowmaxpwriuniqeip['t_idtype'] ==1)
					   {
						   $_data_imd_0_data=  $rowmaxpwriuniqeip['arraydoublem'];
					   }
					 
			   }

			   $_data_imd_0_freq = str_replace($simbolosaborrar, "", $_data_imd_0_freq);	
			   $_data_imd_0_data = str_replace($simbolosaborrar, "", $_data_imd_0_data);	

			   $_data_imd_0_freq_array = explode(",", $_data_imd_0_freq);
			 
			   $_data_imd_0_data_array = explode(",", $_data_imd_0_data);
		

	   	?>
	                   
						
						    <div class="col" id="divgrafico700imd001" name="divgrafico700imd001">
							<hr style=" border: 1px solid #007bff;">
							<p class="  colorazulfiplex" style="font-size: 14px"><b>IMD  <?php 

if ($idscript==38)
{
  $idscript=40;
}

							if ($idscript==40 && $nameuldl  =="UpLink" && $rowiduniqieop['description'] =="700 FirstNet" ) 
							{ 
								echo "700 & 800 - ". $nameuldl ;
							}
							else
							{
								echo $rowiduniqieop['description']." - ". $nameuldl ;
							}

						//	echo $rowiduniqieop['description']." - ". $nameuldl ;?></b>
						 
							&nbsp;&nbsp;<a href="#" onclick="abrirgaleria(<?php echo "'".$v_sn."','".$instancemm."',".$vp_runinfo.",".$idbandoffas; ?>)"><i class="	fa fa-camera"></i> Plots </a>
						</p>
									<table class="table table-bordered table-sm text-center" style="font-size: 11px" >
									<thead class="thead-dark">
										<tr>
										
										<th scope="col">IMD1 [@<?php echo  $_data_imd_0_freq_array[0]; ?>]</th>
										<th scope="col">Fund. Tone [@<?php echo  $_data_imd_0_freq_array[1]; ?>]</th>
										<th scope="col">Fund. Tone [@<?php echo  $_data_imd_0_freq_array[2]; ?>]</th>
										<th scope="col">IMD2 [@<?php echo  $_data_imd_0_freq_array[3]; ?>]</th>
										</tr>
									</thead>
									<tbody>
										<tr>
										<th scope="row"><?php echo  $_data_imd_0_data_array[0]; ?></th>
										<td><?php echo  $_data_imd_0_data_array[1]; ?></td>
										<td><?php echo  $_data_imd_0_data_array[2]; ?></td>
										<td><?php echo  $_data_imd_0_data_array[3]; ?></td>
										</tr>

									</tbody>
									</table>
							</div>	
						 
						 	
	   <?php
	}

}
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////

function section_create_graph_GAIN_by_idrun_sn($vp_runinfo,$v_sn,$idscript, $idinstance)
{
	///'AcceptDiB_Measure_Gain'
	include("db_conect.php"); 
	$sqlgenerardivgain = "
	select *
from 
(
    select losiduniqueop.* , outcomeband.v_integer as idbanda, outcomeuldl.v_integer as uldl
      
    from 
    (
        select  losdd.*
	from fnt_select_allfas_routines_process_sn_maxrev_byscript_byidrun('".$v_sn."',".$idscript." ,".$vp_runinfo." ) as  losdd
	inner join fas_routines_steps
	on fas_routines_steps.idstep = losdd.idstep 
	inner join fas_step
	on fas_step.instance = fas_routines_steps.instance  
	where fas_routines_steps.instance = '".$idinstance."' 
) as losiduniqueop
inner join fas_outcome_integral 
on fas_outcome_integral.v_bigint = losiduniqueop.iduniqueop


  left join fas_outcome_integral as outcomeband
on outcomeband.reference = fas_outcome_integral.id_outcome and
   outcomeband.idfasoutcomecat = 1 and
   outcomeband.idtype          = 1
   left join fas_outcome_integral as outcomeuldl
on outcomeuldl.reference = fas_outcome_integral.id_outcome and
   outcomeuldl.idfasoutcomecat = 1 and
   outcomeuldl.idtype          = 2


) as tt
inner join idband
on idband.idband = tt.idbanda and idband.active = 'Y'
";
//echo 	$sqlgenerardivgain;

	$simbolosaborrar = array("{", "}");
	$datagainmm = $connect->query($sqlgenerardivgain)->fetchAll();
	 foreach ($datagainmm as $rowgainm) 
		{
			$nameuldl ="";
			$idgrapf = $rowgainm['iduniqueop'];
			if ($rowgainm['uldl']==0)
			{
				$nameuldl ="UpLink";
			}
			else
			{
				$nameuldl ="Down";
			}

			/////////////////////////////////////////////////////////////////////////////////////////////////////
			//////Buscamos las mediciones del iduniqueop
			/////////////////////////////////////////////////////////////////////////////////////////////////////
			$simbolosaborrar = array("{", "}");
			$sql_maxpwr2=  "	select idfasoutcomecat, idtype, ARRAY_AGG(v_double order by id_outcome) as arraydoublem 
				from fas_outcome_integral 
				where reference in (
					select t_reference from fnt_select_allmeasures_outcome_integral_single_ns(".$idgrapf.") where t_idfasoutcomecat = 6 and 
					t_idtype in(0,2)) group by idfasoutcomecat, idtype
			";
		//	 echo "<br>GAIN".$sql_maxpwr2;
			 $datamaxpwrxiduniqueop = $connect->query($sql_maxpwr2)->fetchAll();
			 foreach ($datamaxpwrxiduniqueop as $rowmaxpwriuniqeip) 
				{
						if (  $rowmaxpwriuniqeip['idfasoutcomecat'] == 6  &&  $rowmaxpwriuniqeip['idtype'] ==0)
						{
							$_data_gain_0_freq =  $rowmaxpwriuniqeip['arraydoublem'];
						}
						$_data_gain_0_freq = str_replace($simbolosaborrar, "", $_data_gain_0_freq);
						if ($rowmaxpwriuniqeip['idfasoutcomecat'] == 6  &&  $rowmaxpwriuniqeip['idtype'] ==2)
						{
							$_data_gain_0_value =  $rowmaxpwriuniqeip['arraydoublem'];
						}
						$_data_gain_0_value = str_replace($simbolosaborrar, "", $_data_gain_0_value);

					 
				}
				/////////////////////////////////////////////////////////////////////////////////////////////////////
				/////////////////////////////////////////////////////////////////////////////////////////////////////
				/////////////////////////////////////////////////////////////////////////////////////////////////////


			?>
			  <div class="col" id="divgrafico700gain00" name="divgrafico700gain00">
					  
					  <div class="chart">
					  <p class="  colorazulfiplex" style="font-size: 14px"><b>Gain <?php
					  if ($idscript==38)
					  {
						$idscript=40;
					  }
																							if ($idscript==40 && $nameuldl  =="UpLink" && $rowgainm['description'] =="700 FirstNet" ) 
																							{ 
																								echo "700 & 800 - ". $nameuldl ;
																							}
																							else
																							{
																								echo $rowgainm['description']." - ". $nameuldl ;
																							}
					  																?> </b></p>
					  
						  <canvas id="grafigainnup_<?php echo $idgrapf; ?>" width="446" style="width: 446;"></canvas>
							  <?php $grafico_0_up_gain ="grafigainnup_".$idgrapf;?>

					  </div>
				  </div>

				  <script src="plugins/chart.js/Chart.min.js"	></script>
		<script type="text/javascript">

var grafico_0_gain = document.getElementById('<?php echo $grafico_0_up_gain;?>').getContext('2d');


var iduni_0_gain_up = "<?php echo $_data_gain_0_value;?>";					 
var iduni_0_gain_up_lbl = "<?php echo $_data_gain_0_freq;?>";					 
iduni_0_gain_up_data= iduni_0_gain_up.split(",");  
iduni_0_gain_up_lbl_data= iduni_0_gain_up_lbl.split(",");  

/*
console.log('abccceeeec');
console.log(iduni_0_gain_up_data);
console.log(iduni_1_gain_up_data);
console.log(iduni_0_gain_up_lbl_data);
console.log(iduni_1_gain_up_lbl_data);
*/

	 var configOptions_gain_00 = {
							  maintainAspectRatio : false,
							  responsive : false,	
							  legend: {
							  display: false
							  },                                  
										title: {
										  display: true,
										  text: ' '
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

										suggestedMin: (Math.min.apply(Math, iduni_0_gain_up_data) - Math.abs(  Math.min.apply(Math, iduni_0_gain_up_data)*0.1)),
										suggestedMax: (Math.max.apply(Math, iduni_0_gain_up_data) + Math.abs(  Math.max.apply(Math, iduni_0_gain_up_data)*0.1))
										}
									  }]
							  }
							  }
							  
								 var datos_grafico_0_gain = {
									labels  : iduni_0_gain_up_lbl_data,
									datasets: [

													{
													label               : ' ',		
													backgroundColor     : 'rgba(60,141,188,0.3)',
													borderColor         : 'rgba(60,141,188,1)',
													pointRadius          : false,
													pointColor          : '#3b8bba',
													pointStrokeColor    : 'rgba(60,141,188,1)',
													pointHighlightFill  : '#fff',
													pointHighlightStroke: 'rgba(60,141,188,1)',	
													data          :iduni_0_gain_up_data
													},
												]
									};
									
							 var rpt_grafico700gain00a = new Chart(grafico_0_gain, { 
						  type: 'line', 	
						  data: datos_grafico_0_gain,	 
						  options: configOptions_gain_00
						});													  
							
					</script>



			<?php
		}	
}	

	function section_create_graph_GAIN($name_graf, $idgrapf, $vp_runinfo, $idbandoffas)
  {
	include("db_conect.php"); 
	/// Bsucamos los datos de GAIN
 
	$sql_fastreem = "select * from fas_tree_measure where idrununfo =".$vp_runinfo."  AND iduniquebranch in('002007013') and band =  ".$idbandoffas;
	
	
	//	echo "GAIN<br>".$sql_fastreem;


$simbolosaborrar = array("{", "}");

	$datalosiduniqye = $connect->query($sql_fastreem)->fetchAll();
	 foreach ($datalosiduniqye as $rowiduniqieop) 
		{
			$sql_maxpwr2=  " 
			select idfasoutcomecat, idtype, ARRAY_AGG(v_double order by id_outcome) as arraydoublem 
			from fas_outcome_integral 
			where reference in (
				select t_id_outcome from fnt_select_allmeasures_outcome_integral_single(".$vp_runinfo.", ". $rowiduniqieop['iduniqueop'].") where idfasoutcomecat = 6 and 
				idtype in(0,2)) group by idfasoutcomecat, idtype


							 
			";
	//		 echo "<br>GAIN".$sql_maxpwr2;
			 $datamaxpwrxiduniqueop = $connect->query($sql_maxpwr2)->fetchAll();
			 foreach ($datamaxpwrxiduniqueop as $rowmaxpwriuniqeip) 
				{
						if ( $rowiduniqieop['uldl']==0 &&   $rowmaxpwriuniqeip['idfasoutcomecat'] == 6  &&  $rowmaxpwriuniqeip['idtype'] ==0)
						{
							$_data_gain_0_freq =  $rowmaxpwriuniqeip['arraydoublem'];
						}
						$_data_gain_0_freq = str_replace($simbolosaborrar, "", $_data_gain_0_freq);
						if ( $rowiduniqieop['uldl'] ==0 &&   $rowmaxpwriuniqeip['idfasoutcomecat'] == 6  &&  $rowmaxpwriuniqeip['idtype'] ==2)
						{
							$_data_gain_0_value =  $rowmaxpwriuniqeip['arraydoublem'];
						}
						$_data_gain_0_value = str_replace($simbolosaborrar, "", $_data_gain_0_value);

						if ( $rowiduniqieop['uldl'] ==1 &&   $rowmaxpwriuniqeip['idfasoutcomecat'] == 6  &&  $rowmaxpwriuniqeip['idtype'] ==0)
						{
							$_data_gain_1_freq =  $rowmaxpwriuniqeip['arraydoublem'];
						}
						$_data_gain_1_freq = str_replace($simbolosaborrar, "", $_data_gain_1_freq);
					//	echo "A VER".$rowiduniqieop['uldl'];
					 
						if ($rowiduniqieop['uldl']==1 &&   $rowmaxpwriuniqeip['idfasoutcomecat'] == 6  &&  $rowmaxpwriuniqeip['idtype'] ==2)
						{
							$_data_gain_1_value =  $rowmaxpwriuniqeip['arraydoublem'];
						}
						$_data_gain_1_value = str_replace($simbolosaborrar, "", $_data_gain_1_value);
				}

		}	

	?>



   <div class="col-6">
	  <hr style=" border: 1px solid #007bff;">
			  <div class="row"> 
					  <div class="col-6  " id="divgrafico700gain00" name="divgrafico700gain00">
					  
						  <div class="chart">
						  <p class="  colorazulfiplex" style="font-size: 14px"><b>Gain <?php echo $name_graf;?> UpLink</b></p>
						  
							  <canvas id="grafigainnup_<?php echo $idgrapf; ?>" width="446" style="width: 446;"></canvas>
								  <?php $grafico_0_up_gain ="grafigainnup_".$idgrapf;?>

						  </div>
					  </div>
					  <div class="col-6  " id="divgrafico700gain001" name="divgrafico700gain001">
					  
					  <div class="chart">
					  <p class="  colorazulfiplex" style="font-size: 14px"><b>Gain <?php echo $name_graf;?> DownLink</b></p>
					  
						  <canvas id="grafigainndown_<?php echo $idgrapf; ?>" width="446" style="width: 446;"></canvas>
							  <?php $grafico_0_up_down ="grafigainndown_".$idgrapf;?>

					  </div>
				  </div>
				   
			  </div>
		   

	  </div>
	   
	  <script src="plugins/chart.js/Chart.min.js"	></script>
		<script type="text/javascript">

var grafico_0_gain = document.getElementById('<?php echo $grafico_0_up_gain;?>').getContext('2d');
var grafico_1_gain = document.getElementById('<?php echo $grafico_0_up_down;?>').getContext('2d');

var iduni_0_gain_up = "<?php echo $_data_gain_0_value;?>";					 
var iduni_1_gain_up = "<?php echo $_data_gain_1_value;?>";					 

var iduni_0_gain_up_lbl = "<?php echo $_data_gain_0_freq;?>";					 
var iduni_1_gain_up_lbl = "<?php echo $_data_gain_1_freq;?>";	



iduni_0_gain_up_data= iduni_0_gain_up.split(",");  
iduni_1_gain_up_data= iduni_1_gain_up.split(",");  
iduni_0_gain_up_lbl_data= iduni_0_gain_up_lbl.split(",");  
iduni_1_gain_up_lbl_data= iduni_1_gain_up_lbl.split(",");  
/*
console.log('abccceeeec');
console.log(iduni_0_gain_up_data);
console.log(iduni_1_gain_up_data);
console.log(iduni_0_gain_up_lbl_data);
console.log(iduni_1_gain_up_lbl_data);
*/

	 var configOptions_gain_00 = {
							  maintainAspectRatio : false,
							  responsive : false,	
							  legend: {
							  display: false
							  },                                  
										title: {
										  display: true,
										  text: ' '
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

										suggestedMin: (Math.min.apply(Math, iduni_0_gain_up_data) - Math.abs(  Math.min.apply(Math, iduni_0_gain_up_data)*0.1)),
										suggestedMax: (Math.max.apply(Math, iduni_0_gain_up_data) + Math.abs(  Math.max.apply(Math, iduni_0_gain_up_data)*0.1))
										}
									  }]
							  }
							  }
							  
								 var datos_grafico_0_gain = {
									labels  : iduni_0_gain_up_lbl_data,
									datasets: [

													{
													label               : ' ',		
													backgroundColor     : 'rgba(60,141,188,0.3)',
													borderColor         : 'rgba(60,141,188,1)',
													pointRadius          : false,
													pointColor          : '#3b8bba',
													pointStrokeColor    : 'rgba(60,141,188,1)',
													pointHighlightFill  : '#fff',
													pointHighlightStroke: 'rgba(60,141,188,1)',	
													data          :iduni_0_gain_up_data
													},
												]
									};
									
							 var rpt_grafico700gain00a = new Chart(grafico_0_gain, { 
						  type: 'line', 	
						  data: datos_grafico_0_gain,	 
						  options: configOptions_gain_00
						});
					
						///// 2do graf max pwr
			 var configOptions_gain_11= {
							  maintainAspectRatio : false,
							  responsive : false,	
							  legend: {
							  display: false
							  },                                  
										title: {
										  display: true,
										  text: '   '
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

										suggestedMin: (Math.min.apply(Math, iduni_1_gain_up_data) - Math.abs(  Math.min.apply(Math, iduni_1_gain_up_data)*0.1)),
										suggestedMax: (Math.max.apply(Math, iduni_1_gain_up_data) + Math.abs(  Math.max.apply(Math, iduni_1_gain_up_data)*0.1))
										}
									  }]
							  }
							  }
							  
								 var datos_grafico_1_gain = {
									labels  : iduni_1_gain_up_lbl_data ,
									datasets: [

													{
													label               : '',		
													backgroundColor     : 'rgba(60,141,188,0.3)',
													borderColor         : 'rgba(60,141,188,1)',
													pointRadius          : false,
													pointColor          : '#3b8bba',
													pointStrokeColor    : 'rgba(60,141,188,1)',
													pointHighlightFill  : '#fff',
													pointHighlightStroke: 'rgba(60,141,188,1)',	
													data          :iduni_1_gain_up_data
													},
												]
									};
									
							 var rpt_grafico700gin01 = new Chart(grafico_1_gain, { 
						  type: 'line', 	
						  data: datos_grafico_1_gain ,
						  options: configOptions_gain_11
						});			

					</script>
	  <?php
  }


 

	function section_create_graph_EQ_TOTAL_RX_TX($name_graf, $idgrapf, $vp_runinfo, $idbandoffas)
	{
		include("db_conect.php"); 
		
		$sql_fastreem = "select * from fas_tree_measure where idrununfo =".$vp_runinfo."  AND iduniquebranch in('00100300A','00100300B') and band =  ".$idbandoffas;
//		echo $sql_fastreem;


	$simbolosaborrar = array("{", "}");
	?>
		<section class="col-lg-12 connectedSortable ui-sortable">
			<br>  <h5>Equalization</h5>
	<?php
	
		$datalosiduniqye = $connect->query($sql_fastreem)->fetchAll();
	 	foreach ($datalosiduniqye as $rowiduniqieop) 
			{
				// 00100300B- EQ Check ******* 00100300A - EQ Calibration
					if ($rowiduniqieop['iduniquebranch']=="00100300B" && $rowiduniqieop['band']== $idbandoffas && $rowiduniqieop['uldl']== 0)
					{
						$iduni_eq_check_up= $rowiduniqieop['iduniqueop'];
							$sqlbuscodatos =" select   
							ARRAY_AGG(t_v_double order by t_id_outcome) as arraydoublem
							from fnt_select_allmeasures_outcome_integral_ucmeasure(".$vp_runinfo.", ". $rowiduniqieop['iduniqueop'].")  where t_idfasoutcomecat = 5 and t_idtype= 18";
					//	 echo "a ver marco".$sqlbuscodatos;
							$datos_rx_up = $connect->query($sqlbuscodatos)->fetchAll();
							foreach ($datos_rx_up as $row_dd_rx) 
								{
									$iduni_eq_check_up_RX = $row_dd_rx['arraydoublem'];
								}
								$iduni_eq_check_up_RX = str_replace($simbolosaborrar, "", $iduni_eq_check_up_RX);

							$sqlbuscodatostx ="  select ARRAY_AGG(t_v_double order by t_id_outcome) as arraydoublem 
							from fnt_select_allmeasures_outcome_integral_mktmeasure(".$vp_runinfo.", ". $rowiduniqieop['iduniqueop'].")  where t_idfasoutcomecat = 7 and t_idtype= 1";
							$datos_tx_up = $connect->query($sqlbuscodatostx)->fetchAll();
							foreach ($datos_tx_up as $row_dd_tx) 
								{
									$iduni_eq_check_up_TX = $row_dd_tx['arraydoublem'];
								}
								$iduni_eq_check_up_TX = str_replace($simbolosaborrar, "", $iduni_eq_check_up_TX);
								$sqlbuscodatostx ="  select ARRAY_AGG(t_v_double order by t_id_outcome) as arraydoublem 
							from fnt_select_allmeasures_outcome_integral_mktmeasure(".$vp_runinfo.", ". $rowiduniqieop['iduniqueop'].")  where t_idfasoutcomecat = 7 and t_idtype= 0";
						
							$datos_tx_up = $connect->query($sqlbuscodatostx)->fetchAll();
							foreach ($datos_tx_up as $row_dd_tx) 
								{
									$iduni_eq_check_up_TX_label = $row_dd_tx['arraydoublem'];
								}
								
								$iduni_eq_check_up_TX_label = str_replace($simbolosaborrar, " ", $iduni_eq_check_up_TX_label);
						///		echo "aaaaaaaaaa".$iduni_eq_check_up_TX_label;
							 
						
					}
					if ($rowiduniqieop['iduniquebranch']=="00100300B" && $rowiduniqieop['band']== $idbandoffas && $rowiduniqieop['uldl']== 1)
					{
						$iduni_eq_check_down= $rowiduniqieop['iduniqueop'];
						$sqlbuscodatos =" select   
						ARRAY_AGG(t_v_double order by t_id_outcome) as arraydoublem
						from fnt_select_allmeasures_outcome_integral_ucmeasure(".$vp_runinfo.", ". $rowiduniqieop['iduniqueop'].")  where t_idfasoutcomecat = 5 and t_idtype= 18";
						$datos_rx_down = $connect->query($sqlbuscodatos)->fetchAll();
						foreach ($datos_rx_down as $row_dd_rx) 
							{
								$iduni_eq_check_down_RX = $row_dd_rx['arraydoublem'];
							}
							$iduni_eq_check_down_RX = str_replace($simbolosaborrar, " ", $iduni_eq_check_down_RX);

							
							$sqlbuscodatostx ="  select ARRAY_AGG(t_v_double order by t_id_outcome) as arraydoublem 
							from fnt_select_allmeasures_outcome_integral_mktmeasure(".$vp_runinfo.", ". $rowiduniqieop['iduniqueop'].")  where t_idfasoutcomecat = 7 and t_idtype= 1";
							$datos_tx_do = $connect->query($sqlbuscodatostx)->fetchAll();
							foreach ($datos_tx_do as $row_dd_tx_do) 
								{
									$iduni_eq_check_down_TX = $row_dd_tx_do['arraydoublem'];
								}
								$iduni_eq_check_down_TX = str_replace($simbolosaborrar, " ", $iduni_eq_check_down_TX);

					}
					if ($rowiduniqieop['iduniquebranch']=="00100300A" && $rowiduniqieop['band']== $idbandoffas && $rowiduniqieop['uldl']== 0)
					{
						$iduni_eq_calib_up= $rowiduniqieop['iduniqueop'];
						$sqlbuscodatos_Calib =" select   
						ARRAY_AGG(t_v_double order by t_id_outcome) as arraydoublem
						from fnt_select_allmeasures_outcome_integral_ucmeasure(".$vp_runinfo.", ". $rowiduniqieop['iduniqueop'].")  where t_idfasoutcomecat = 5 and t_idtype= 18";
				//		echo "<br>1::".$sqlbuscodatos_Calib;
						$datos_rx_upccalib = $connect->query($sqlbuscodatos_Calib)->fetchAll();
						foreach ($datos_rx_upccalib as $row_dd_rxcalib) 
							{
								$iduni_eq_calib_up_RX = $row_dd_rxcalib['arraydoublem'];
							}
							$iduni_eq_calib_up_RX = str_replace($simbolosaborrar, " ", $iduni_eq_calib_up_RX);

						$sqlbuscodatostx_Calib ="  select ARRAY_AGG(t_v_double order by t_id_outcome) as arraydoublem 
						from fnt_select_allmeasures_outcome_integral_mktmeasure(".$vp_runinfo.", ". $rowiduniqieop['iduniqueop'].")  where t_idfasoutcomecat = 7 and t_idtype= 1";
						$datos_tx_up_calib = $connect->query($sqlbuscodatostx_Calib)->fetchAll();
						foreach ($datos_tx_up_calib as $row_dd_tx_calib) 
							{
								$iduni_eq_calib_up_TX = $row_dd_tx_calib['arraydoublem'];
							}
							$iduni_eq_calib_up_TX = str_replace($simbolosaborrar, " ", $iduni_eq_calib_up_TX);
							$sqlbuscodatostx_Calib ="  select ARRAY_AGG(t_v_double order by t_id_outcome) as arraydoublem 
							from fnt_select_allmeasures_outcome_integral_mktmeasure(".$vp_runinfo.", ". $rowiduniqieop['iduniqueop'].")  where t_idfasoutcomecat = 7 and t_idtype= 0";
							$datos_tx_up_calib = $connect->query($sqlbuscodatostx_Calib)->fetchAll();
							foreach ($datos_tx_up_calib as $row_dd_tx_calib) 
								{
									$iduni_eq_calib_up_TX_label = $row_dd_tx_calib['arraydoublem'];
								}
								$iduni_eq_calib_up_TX_label = str_replace($simbolosaborrar, " ", $iduni_eq_calib_up_TX_label);

					}
					if ($rowiduniqieop['iduniquebranch']=="00100300A" && $rowiduniqieop['band']== $idbandoffas && $rowiduniqieop['uldl']== 1)
					{
						$iduni_eq_calib_down= $rowiduniqieop['iduniqueop'];
						$sqlbuscodato_Calibs =" select   
						ARRAY_AGG(t_v_double order by t_id_outcome) as arraydoublem
						from fnt_select_allmeasures_outcome_integral_ucmeasure(".$vp_runinfo.", ". $rowiduniqieop['iduniqueop'].")  where t_idfasoutcomecat = 5 and t_idtype= 18";
						$datos_rx_downCalibdo = $connect->query($sqlbuscodato_Calibs)->fetchAll();
						foreach ($datos_rx_downCalibdo as $row_dd_rx_calibdo) 
							{
								$iduni_eq_calib_down_RX = $row_dd_rx_calibdo['arraydoublem'];
							}
							$iduni_eq_calib_down_RX = str_replace($simbolosaborrar, " ", $iduni_eq_calib_down_RX);

							
							$sqlbuscodatostx_Calibdo ="  select ARRAY_AGG(t_v_double order by t_id_outcome) as arraydoublem 
							from fnt_select_allmeasures_outcome_integral_mktmeasure(".$vp_runinfo.", ". $rowiduniqieop['iduniqueop'].")  where t_idfasoutcomecat = 7 and t_idtype= 1";
							$datos_tx_do_calib = $connect->query($sqlbuscodatostx_Calibdo)->fetchAll();
							foreach ($datos_tx_do_calib as $datos_tx_do_calib) 
								{
									$iduni_eq_calib_down_TX = $datos_tx_do_calib['arraydoublem'];
								}
								$iduni_eq_calib_down_TX = str_replace($simbolosaborrar, " ", $iduni_eq_calib_down_TX);
								$sqlbuscodatostx ="  select ARRAY_AGG(t_v_double order by t_id_outcome) as arraydoublem 
								from fnt_select_allmeasures_outcome_integral_mktmeasure(".$vp_runinfo.", ". $rowiduniqieop['iduniqueop'].")  where t_idfasoutcomecat = 7 and t_idtype= 0";
							
								$datos_tx_up = $connect->query($sqlbuscodatostx)->fetchAll();
								foreach ($datos_tx_up as $row_dd_tx) 
									{
										$iduni_eq_check_down_TX_label = $row_dd_tx['arraydoublem'];
									}
					}
					$iduni_eq_check_down_TX_label = str_replace($simbolosaborrar, " ", $iduni_eq_check_down_TX);
				//	echo "aaaaaaaaaa".$iduni_eq_check_down_TX_label;
			}	
/*
			///Buscamos los datos para cada iduniqueop 
			echo "<br>iduni_eq_check_up_RX:".$iduni_eq_check_up_RX;
			echo "<br>iduni_eq_check_up_TX:".$iduni_eq_check_up_TX;
			
			echo "<br>iduni_eq_check_down_RX:".$iduni_eq_check_down_RX;
			echo "<br>iduni_eq_check_down_TX:".$iduni_eq_check_down_TX;

			echo "<br>iduni_eq_calib_up_RX:".$iduni_eq_calib_up_RX;			
			echo "<br>iduni_eq_calib_up_TX:".$iduni_eq_calib_up_TX;

			echo "<br>iduni_eq_calib_down_RX:".$iduni_eq_calib_down_RX;
			echo "<br>iduni_eq_calib_down_TX:".$iduni_eq_calib_down_TX;

            echo "<br>----------------------------";
		*/


	   ?>
		
			<div class="row " id="divgrafi<?php echo $idgrapf;?>" name="divgrafi<?php echo $idgrapf;?>">
			<div class="col-6">
			<hr style=" border: 1px solid #007bff;">
			<p class="  colorazulfiplex" style="font-size: 14px"><b><?php echo $name_graf; ?> UpLink</b></p> 
			     <div class="row">
						<div class="col-12 " id="divgraficoup<?php echo $idgrapf; ?>" name="divgraficoup<?php echo $idgrapf; ?>">
						<b> TOTAL RIPPLE</b> 
							<div class="chart">
							<canvas id="graficouptotalripple_<?php echo $idgrapf; ?>" height="280" style="height: 280;"></canvas>
							<?php $grafico_0_up_total ="graficouptotalripple_".$idgrapf;?>
							</div>
						</div>
						<div class="col-6 " id="divgraficouprxripple<?php echo $idgrapf; ?>" name="divgraficouprxripple<?php echo $idgrapf; ?>">
						<b>RX RIPPLE</b>
							<div class="chart">
								<canvas id="graficouprxripple_<?php echo $idgrapf; ?>" height="280" style="height: 280;"></canvas>
								<?php $grafico_0_up_rx ="graficouprxripple_".$idgrapf;?>
							</div>
						</div>
						<div class="col-6 " id="divgraficouptxripple<?php echo $idgrapf; ?>" name="divgraficouptxripple<?php echo $idgrapf; ?>">
						<b> TX RIPPLE</b>
							<div class="chart">
								<canvas id="graficouptxripple_<?php echo $idgrapf; ?>" height="280" style="height: 280;"></canvas>
								<?php $grafico_0_up_tx ="graficouptxripple_".$idgrapf;?>
							</div>
						</div>
					</div>
				</div>
				<div class="col-6  " id="idreturnloss" name="idreturnloss"  >
				<hr style=" border: 1px solid #007bff;">
				<p class="  colorazulfiplex" style="font-size: 14px"><b><?php echo $name_graf; ?> DownLink</b></p> 
				
			 
			 
			
				<div class="row">
						<div class="col-12 " id="divgraficodown<?php echo $idgrapf; ?>" name="divgraficodown<?php echo $idgrapf; ?>">
						<b> TOTAL RIPPLE</b> 
							<div class="chart">
							<canvas id="graficodowntotalripple_<?php echo $idgrapf; ?>" height="280" style="height: 280;"></canvas>
							<?php $grafico_1_down_total ="graficodowntotalripple_".$idgrapf;?>
							</div>
						</div>
						<div class="col-6 " id="divgraficodownrxripple<?php echo $idgrapf; ?>" name="divgraficodownrxripple<?php echo $idgrapf; ?>">
						<b>RX RIPPLE</b>
							<div class="chart">
								<canvas id="graficodownrxripple_<?php echo $idgrapf; ?>" height="280" style="height: 280;"></canvas>
								<?php $grafico_1_down_rx ="graficodownrxripple_".$idgrapf;?>
							</div>
						</div>
						<div class="col-6 " id="divgraficodowntxripple<?php echo $idgrapf; ?>" name="divgraficodowntxripple<?php echo $idgrapf; ?>">
						<b> TX RIPPLE</b>
							<div class="chart">
								<canvas id="graficodowntxripple_<?php echo $idgrapf; ?>" height="280" style="height: 280;"></canvas>
								<?php $grafico_1_down_tx ="graficodowntxripple_".$idgrapf;?>
							</div>
						</div>
					</div>

				
				</div>

			</div>
			</section> 
			<script src="plugins/chart.js/Chart.min.js"></script>
			<script type="text/javascript">
				 	    
                    
							// const cdt3xm = document.getElementById('<?php echo $grafico_0_up_total;?>').getContext('2d');
						  var grafico_0_up_total_ma = document.getElementById('<?php echo $grafico_0_up_total;?>').getContext('2d');
						  var grafico_0_up_tx = document.getElementById('<?php echo $grafico_0_up_tx;?>').getContext('2d');
						  var grafico_0_up_rx = document.getElementById('<?php echo $grafico_0_up_rx;?>').getContext('2d');

						  var grafico_0_down_total_ma = document.getElementById('<?php echo $grafico_1_down_total;?>').getContext('2d');
						  var grafico_0_down_tx = document.getElementById('<?php echo $grafico_1_down_tx;?>').getContext('2d');
						  var grafico_0_down_rx = document.getElementById('<?php echo $grafico_1_down_rx;?>').getContext('2d');

						var iduni_eq_check_up_TX = "<?php echo $iduni_eq_check_up_TX;?>";					 
						iduni_eq_check_up_TX_data= iduni_eq_check_up_TX.split(",");  	
				/*		console.log(iduni_eq_check_up_TX_data);
						console.log('el minimo del array es' );				 
						console.log( Math.min.apply(null, iduni_eq_check_up_TX_data) );				 
						console.log( Math.max.apply(null, iduni_eq_check_up_TX_data) );	
*/
						var iduni_eq_check_up_TX_data_conmedia = [];
							for (var aix = 0; aix < iduni_eq_check_up_TX_data.length; aix++) {

							//	console.log('original: '+  iduni_eq_check_up_TX_data[aix]);	
							 
						//	console.log('calculo mm: '+ parseFloat(iduni_eq_check_up_TX_data[aix] - ( (Math.min.apply(null, iduni_eq_check_up_TX_data) +Math.max.apply(null, iduni_eq_check_up_TX_data) ) /2))  );

								iduni_eq_check_up_TX_data_conmedia.push( iduni_eq_check_up_TX_data[aix]- ( (Math.min.apply(null, iduni_eq_check_up_TX_data) +Math.max.apply(null, iduni_eq_check_up_TX_data) ) /2)  );
							}
					//		console.log(iduni_eq_check_up_TX_data_conmedia);

					 
				 
						var iduni_eq_calib_up_TX = "<?php echo $iduni_eq_calib_up_TX;?>";
						iduni_eq_calib_up_TX_data= iduni_eq_calib_up_TX.split(",");  

						var iduni_eq_calib_up_TX_data_conmedia = [];
							for (var aix = 0; aix < iduni_eq_calib_up_TX_data.length; aix++) {
								iduni_eq_calib_up_TX_data_conmedia.push( iduni_eq_calib_up_TX_data[aix]- ( (Math.min.apply(null, iduni_eq_calib_up_TX_data) +Math.max.apply(null, iduni_eq_calib_up_TX_data) ) /2)  );
							}
					//		console.log(iduni_eq_calib_up_TX_data_conmedia);


						var iduni_eq_check_up_RX = "<?php echo $iduni_eq_check_up_RX;?>";					 
						iduni_eq_check_up_RX_data= iduni_eq_check_up_RX.split(",");  	
						
						var iduni_eq_check_up_RX_data_conmedia = [];
							for (var aix = 0; aix < iduni_eq_check_up_RX_data.length; aix++) {
								iduni_eq_check_up_RX_data_conmedia.push( iduni_eq_check_up_RX_data[aix]- ( (Math.min.apply(null, iduni_eq_check_up_RX_data) +Math.max.apply(null, iduni_eq_check_up_RX_data) ) /2)  );
							}
					//		console.log(iduni_eq_check_up_RX_data_conmedia);
				 
						var iduni_eq_calib_up_RX = "<?php echo $iduni_eq_calib_up_RX;?>";
						iduni_eq_calib_up_RX_data= iduni_eq_calib_up_RX.split(",");  

						var iduni_eq_calib_up_RX_data_conmedia = [];
							for (var aix = 0; aix < iduni_eq_calib_up_RX_data.length; aix++) {
								iduni_eq_calib_up_RX_data_conmedia.push( iduni_eq_calib_up_RX_data[aix]- ( (Math.min.apply(null, iduni_eq_calib_up_RX_data) +Math.max.apply(null, iduni_eq_calib_up_RX_data) ) /2)  );
							}
					//		console.log(iduni_eq_calib_up_RX_data_conmedia);


						//////////////////////////////////
						var iduni_eq_check_down_TX = "<?php echo $iduni_eq_check_down_TX;?>";					 
						iduni_eq_check_down_TX_data= iduni_eq_check_down_TX.split(",");  

						var iduni_eq_check_down_TX_data_conmedia = [];
							for (var aix = 0; aix < iduni_eq_check_down_TX_data.length; aix++) {
								iduni_eq_check_down_TX_data_conmedia.push( iduni_eq_check_down_TX_data[aix]- ( (Math.min.apply(null, iduni_eq_check_down_TX_data) +Math.max.apply(null, iduni_eq_check_down_TX_data) ) /2)  );
							}
					//		console.log(iduni_eq_check_down_TX_data_conmedia);					 
				 
						var iduni_eq_calib_down_TX = "<?php echo $iduni_eq_calib_down_TX;?>";
						iduni_eq_calib_down_TX_data= iduni_eq_calib_down_TX.split(",");  

						var iduni_eq_calib_down_TX_data_conmedia = [];
							for (var aix = 0; aix < iduni_eq_calib_down_TX_data.length; aix++) {
								iduni_eq_calib_down_TX_data_conmedia.push( iduni_eq_calib_down_TX_data[aix]- ( (Math.min.apply(null, iduni_eq_calib_down_TX_data) +Math.max.apply(null, iduni_eq_calib_down_TX_data) ) /2)  );
							}
					//		console.log(iduni_eq_calib_down_TX_data_conmedia);		

						var iduni_eq_check_down_RX = "<?php echo $iduni_eq_check_down_RX;?>";					 
						iduni_eq_check_down_RX_data= iduni_eq_check_down_RX.split(",");  
						
						var iduni_eq_check_down_RX_data_conmedia = [];
							for (var aix = 0; aix < iduni_eq_check_down_RX_data.length; aix++) {
								iduni_eq_check_down_RX_data_conmedia.push( iduni_eq_check_down_RX_data[aix]- ( (Math.min.apply(null, iduni_eq_check_down_RX_data) +Math.max.apply(null, iduni_eq_check_down_RX_data) ) /2)  );
							}
							//		console.log(iduni_eq_check_down_RX_data_conmedia);	
				 
						var iduni_eq_calib_down_RX = "<?php echo $iduni_eq_calib_down_RX;?>";
						iduni_eq_calib_down_RX_data= iduni_eq_calib_down_RX.split(",");
						
						var iduni_eq_calib_down_RX_data_conmedia = [];
							for (var aix = 0; aix < iduni_eq_calib_down_RX_data.length; aix++) {
								iduni_eq_calib_down_RX_data_conmedia.push( iduni_eq_calib_down_RX_data[aix]- ( (Math.min.apply(null, iduni_eq_calib_down_RX_data) +Math.max.apply(null, iduni_eq_calib_down_RX_data) ) /2)  );
							}
							//		console.log(iduni_eq_calib_down_RX_data_conmedia);


						//////////////////DOWN/////////////////////////////
					
						var iduni_eq_check_up_TX_label ="<?php echo   $iduni_eq_check_up_TX_label;?>";
						iduni_eq_check_up_TX_label= iduni_eq_check_up_TX_label.split(",");  

						var iduni_eq_check_down_TX_label ="<?php echo   $iduni_eq_check_down_TX_label;?>";
						iduni_eq_check_down_TX_label= iduni_eq_check_down_TX_label.split(",");  

						var grafico_0_uptx = {
                            labels  :  iduni_eq_check_up_TX_label,
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
                              data                :  iduni_eq_check_up_TX_data_conmedia                              
                              },
                            {
                                label               : 'Not Equalized',		
                              backgroundColor     : 'rgba(255, 99, 132, 0.5)',
                                borderColor         : 'rgba(255, 99, 132, 1)',
                                pointRadius         : false,
                                pointColor          : 'rgba(255, 99, 132, 1)',
                                pointStrokeColor    : '#c1c7d1',
                                pointHighlightFill  : '#fff',
                                pointHighlightStroke: 'rgba(255, 99, 132, 1)',		
                              data          :  iduni_eq_calib_up_TX_data_conmedia 
                              },
                            ]
                          };

						  var grafico_1_uptx = {
                            labels  :  iduni_eq_check_down_TX_label,
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
                              data                :  iduni_eq_check_down_TX_data_conmedia
                              },
                            {
                                label               : 'Not Equalized',		
                              backgroundColor     : 'rgba(255, 99, 132, 0.5)',
                                borderColor         : 'rgba(255, 99, 132, 1)',
                                pointRadius         : false,
                                pointColor          : 'rgba(255, 99, 132, 1)',
                                pointStrokeColor    : '#c1c7d1',
                                pointHighlightFill  : '#fff',
                                pointHighlightStroke: 'rgba(255, 99, 132, 1)',		
                              data          :  iduni_eq_calib_down_TX_data_conmedia
                              },
                            ]
                          };

						
						
                          var grafico_0_uprx = {
                            labels  :  iduni_eq_check_up_TX_label,
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
                              data                :  iduni_eq_check_up_RX_data_conmedia
                                
                              },
                            {
                                label               : 'Not Equalized',		
                              backgroundColor     : 'rgba(255, 99, 132, 0.5)',
                                borderColor         : 'rgba(255, 99, 132, 1)',
                                pointRadius         : false,
                                pointColor          : 'rgba(255, 99, 132, 1)',
                                pointStrokeColor    : '#c1c7d1',
                                pointHighlightFill  : '#fff',
                                pointHighlightStroke: 'rgba(255, 99, 132, 1)',		
                              data          : iduni_eq_calib_up_RX_data_conmedia
                              },
                            ]
                          };

						  var grafico_1_uprx = {
                            labels  :  iduni_eq_check_down_TX_label,
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
                              data                :  iduni_eq_check_down_RX_data_conmedia
                                
                              },
                            {
                                label               : 'Not Equalized',		
                              backgroundColor     : 'rgba(255, 99, 132, 0.5)',
                                borderColor         : 'rgba(255, 99, 132, 1)',
                                pointRadius         : false,
                                pointColor          : 'rgba(255, 99, 132, 1)',
                                pointStrokeColor    : '#c1c7d1',
                                pointHighlightFill  : '#fff',
                                pointHighlightStroke: 'rgba(255, 99, 132, 1)',		
                              data          : iduni_eq_calib_down_RX_data_conmedia
                              },
                            ]
                          };

						  function sumArray(a, b) {
      var c = [];
      for (var i = 0; i < Math.max(a.length, b.length); i++) {
        c.push( parseFloat(a[i] || 0) + parseFloat(b[i] || 0));
      }
      return c;
  }

 
                          
						  iduniqueop_band_0_uldl_0_tx_check_total = sumArray(iduni_eq_check_up_TX_data_conmedia,iduni_eq_check_up_RX_data_conmedia);
                          iduniqueop_band_0_uldl_0_rx_check_total  = sumArray(iduni_eq_calib_up_TX_data_conmedia ,iduni_eq_calib_up_RX_data_conmedia);

						  iduniqueop_band_0_uldl_1_tx_check_total = sumArray(iduni_eq_check_down_TX_data_conmedia ,iduni_eq_check_down_RX_data_conmedia);
                          iduniqueop_band_0_uldl_1_rx_check_total  = sumArray(iduni_eq_calib_down_TX_data_conmedia ,iduni_eq_calib_down_RX_data_conmedia);

                        //  console.log('sumArray');
                        //  console.log(iduniqueop_band_0_uldl_0_tx_check_total);

                          var grafico700uprx_datos_0_0_total = {
                            labels  :  iduni_eq_check_up_TX_label,
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
                              data                :  iduniqueop_band_0_uldl_0_tx_check_total
                                
                              },
                            {
                                label               : 'Not Equalized',		
                              backgroundColor     : 'rgba(255, 99, 132, 0.5)',
                                borderColor         : 'rgba(255, 99, 132, 1)',
                                pointRadius         : false,
                                pointColor          : 'rgba(255, 99, 132, 1)',
                                pointStrokeColor    : '#c1c7d1',
                                pointHighlightFill  : '#fff',
                                pointHighlightStroke: 'rgba(255, 99, 132, 1)',		
                              data          : iduniqueop_band_0_uldl_0_rx_check_total 
                              },
                            ]
                          };

						  var grafico700uprx_datos_01_total = {
                            labels  :  iduni_eq_check_down_TX_label,
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
                              data                :  iduniqueop_band_0_uldl_1_tx_check_total
                                
                              },
                            {
                                label               : 'Not Equalized',		
                              backgroundColor     : 'rgba(255, 99, 132, 0.5)',
                                borderColor         : 'rgba(255, 99, 132, 1)',
                                pointRadius         : false,
                                pointColor          : 'rgba(255, 99, 132, 1)',
                                pointStrokeColor    : '#c1c7d1',
                                pointHighlightFill  : '#fff',
                                pointHighlightStroke: 'rgba(255, 99, 132, 1)',		
                              data          : iduniqueop_band_0_uldl_1_rx_check_total 
                              },
                            ]
                          };

							
  var salesChartOptions = {
    maintainAspectRatio : false,
    responsive : true,	
    legend: {
      display: true
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
						 
						  var grafico_0_up_total_a = new Chart(grafico_0_up_total_ma, { 
                          type: 'line', 	
                          data: grafico700uprx_datos_0_0_total, 	 
                          options: salesChartOptions
                        });

                        var grafico_0_up_tx_a = new Chart(grafico_0_up_tx, { 
                          type: 'line', 	
                          data: grafico_0_uptx, 	 
                          options: salesChartOptions
                        });

                        var grafico_0_up_rx_a = new Chart(grafico_0_up_rx, { 
                            type: 'line', 	
                            data: grafico_0_uprx, 	 
                            options: salesChartOptions
                          });
						

						  var grafico_0_up_total_b = new Chart(grafico_0_down_total_ma, { 
                          type: 'line', 	
                          data: grafico700uprx_datos_01_total, 	 
                          options: salesChartOptions
                        });

                        var grafico_0_up_tx_b = new Chart(grafico_0_down_tx, { 
                          type: 'line', 	
                          data: grafico_1_uptx, 	 
                          options: salesChartOptions
                        });


						var grafico_0_up_tx_b2 = new Chart(grafico_0_down_rx, { 
                          type: 'line', 	
                          data: grafico_1_uprx, 	 
                          options: salesChartOptions
                        });

               


						

			</script>	
	   <?php
	 
	}

	 

						/*  var grafico_0_up_total_b4 = document.getElementById('<?php echo $grafico_0_up_total;?>').getContext('2d');
                          
						  var grafico_0_up_total_a = new Chart(grafico_0_up_total, { 
                          type: 'line', 	
                          data: grafico_0_uptx 
                        });
*/
					/*
					///andandnooooo
						const cdt3xm = document.getElementById('<?php echo $grafico_0_up_total;?>').getContext('2d');
                          
						const myChardsddt = new Chart(cdt3xm , {
									type: 'bar',
									data: {
										labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
										datasets: [{
											label: '# of Votes',
											data: [12, 19, 3, 5, 2, 3],
											backgroundColor: [
												'rgba(255, 99, 132, 0.2)',
												'rgba(54, 162, 235, 0.2)',
												'rgba(255, 206, 86, 0.2)',
												'rgba(75, 192, 192, 0.2)',
												'rgba(153, 102, 255, 0.2)',
												'rgba(255, 159, 64, 0.2)'
											],
											borderColor: [
												'rgba(255, 99, 132, 1)',
												'rgba(54, 162, 235, 1)',
												'rgba(255, 206, 86, 1)',
												'rgba(75, 192, 192, 1)',
												'rgba(153, 102, 255, 1)',
												'rgba(255, 159, 64, 1)'
											],
											borderWidth: 1
										}]
									},
									options: {
										scales: {
											y: {
												beginAtZero: true
											}
										}
									}
								});
						///fin andando		
							*/

		
?>
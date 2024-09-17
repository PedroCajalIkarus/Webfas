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

p {
    margin-top: 6px;
}
  </style>
  
</head>
<form name="frma" id="frma">



<input type="hidden" name="uso" id="uso" value="0">
<body class="hold-transition sidebar-mini sidebar-collapse">

  <div class="">
  


<!-- Site wrapper -->
<div class="	">
  <!-- Navbar -->
 


  <!-- Content Wrapper. Contains page content -->
  <div class="">
    <!-- Content Header (Page header) -->



    <!-- Main content 
	
	levelsplot -> TotalRipplePlot -- nuevo titulo del gráfico: Total Ripple
Powersplot -> TxRipplePlot -- nuevo titulo del gráfico: Rx Ripple
RxRipplePlot es el nuevo campo -- nuevo titulo del gráfico: Tx Ripple
-->
<?php
	$vparam_vnrounitsn = $_REQUEST['idsndib']; ///// "20000000fu";	
	$vparam_band = $_REQUEST['idmb'];
	 $vparam_idruninfo = $_REQUEST['idmr'];
	$vparam_uldld = $_REQUEST['iduldl'];
?>
    <section class="content">
	
	 <div class="container-fluid"><br>
	<div class="card card-primary card-tabs">

	
	
			<span class="text-right"><a href="finalchk.php?idsndib=<?php echo $_REQUEST['idsndib']."&iduldl=".$vparam_uldld."&idmb=".$vparam_band;?>" target="_blank">Open in New Tab</a> &nbsp;&nbsp;&nbsp;</span>
             <div class="col-10">
		    <div class="form-group row">
			
    <span class="col-sm-2 col-form-label textotabla10">Select the Iteration:</span>   

			<?php
	        $sql="SELECT DISTINCT  fas_tree_measure.band ,  fas_tree_measure.idrununfo as idruninfo, max(datetime) as fechahora  from fas_tree_measure 
			  inner join fas_calibration_result on fas_calibration_result.unitsn = fas_tree_measure.unitsn and  fas_calibration_result.idruninfo = fas_tree_measure.idrununfo
		
		 where  fas_tree_measure.unitsn = '".$vparam_vnrounitsn."' and  fas_tree_measure.uldl = ".$vparam_uldld."  and fas_tree_measure.iduniquebranch like '002%' group by  fas_tree_measure.band , fas_tree_measure.idrununfo order by fechahora desc ";
		// echo "22hola".$sql;
			?>
				 <select class="form-control col-sm-3 form-control-sm" name="cmbiditeracion" id="cmbiditeracion" >
	
			<?php
			$datacabez = $connect->query($sql)->fetchAll();	
				$vidnro = 1;
								  foreach ($datacabez as $rowheaders) 
								  {
									$loencontre="";
										if ($_REQUEST['idruninfo']  == $rowheaders['idruninfo'])
										{
												$loencontre=" selected ";
											
										}
										if ($_REQUEST['idruninfo'] =="")
										{
											$loencontre=" selected ";
										}
											   $vparam_idruninfo = $rowheaders['idruninfo'];
											      $fechahcortada = substr($rowheaders['fechahora'],0,19);
										//	echo "<a href='equalizeriir.php?idsndib=".$_REQUEST['idsndib']."&iduldl=".$vparam_uldld."&idmb=".$vparam_band."&idruninfo=".$vparam_idruninfo."'> It.".$vidnro ."</a> - ";
											echo " <option ".$loencontre." value='finalchk.php?idsndib=".$_REQUEST['idsndib']."&iduldl=".$vparam_uldld."&idmb=".$rowheaders['band']."&idruninfo=".$vparam_idruninfo."'>".$vidnro." [".$fechahcortada."]</option>";
										$vidnro = $vidnro + 1;
										$vparam_band =  $rowheaders['band'];
									  }
									  ?>
					  </select>				  
			&nbsp&nbsp<p><a href="#" onclick="ver_log_seleccionado()" target="_blank" style="color:#0053a1;">View Log <i class="fas fa-eye"></i></a></p>
			&nbsp&nbsp<a href="#" onclick="open_calibstring('<?php echo $_REQUEST['idsndib'];?>')" class='btn btn-xs' value="<?php echo $_REQUEST['idsndib'];?>" title='Calibration String'> <img src='img/calstring.png' width='25px' title='Calibration String'> </a>
			
			
			
			  </div>
			 </div>
              <div class="card-body d-none">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade active show" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                   

							
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                     
                  </div>
               
                </div>
              </div>
              <!-- /.card -->
            </div>
			
     
        
        <!-- "Calibration_EQ_Check_Levels"   Equalized WITHOUT AGC
"Calibration_EQ_Calibration_Levels" Not Equalized WITHOUT AGC
"Calibration_EQ_Calibration_Powers"   Not Equalized AGC
"Calibration_EQ_Check_Powers"   Equalized AGC
		-->
		  <?php
		  	$v_Levels_Offset = 0;
								$v_Squelch_Offset = 0;
								$v_Gain_Offset = 0;
								$v_Max_Pwr_Offset = 0;
								
								$v_currentminvalor = 0;
								$v_currentmaxvalor = 0;
								$v_currentminmeasurerango = 0;
								$v_currentmaxmeasurerango = 0;
						
			
		
		if ( $_REQUEST['idruninfo']!="")
			{
				  $vparam_idruninfo = $_REQUEST['idruninfo'];
			}
			if (  $vparam_idruninfo  =="")
			{
				 $cantdetipodemediciones =0;
			}
			else
			{
				
			
			
		  $query_lista="SELECT fas_tree_measure.totalpass,  fas_tree_measure.iduniqueop,  fas_step.description as namebranch,  fas_tree_measure.iduniquebranch, fas_tree_measure.unitsn, fas_tree_measure.dibsn, fas_tree_measure.uldl, fas_tree_measure.band
,fas_tree_measure.idrununfo
from fas_tree_measure
inner join fas_tree
on fas_tree.iduniquebranch = fas_tree_measure.iduniquebranch  and fas_tree.idfastree =  1
inner join fas_step
on fas_step.idfasstep = fas_tree.idfastrepson
inner join 
(
	select unitsn , iduniquebranch, max(idrev) as maxeje
from fas_tree_measure
where fas_tree_measure.iduniquebranch like '002%'  and  unitsn = '".$vparam_vnrounitsn."' and  idrununfo =".$vparam_idruninfo. "
group by unitsn , iduniquebranch
) as maxidrev
on maxidrev.unitsn = fas_tree_measure.unitsn and 
maxidrev.iduniquebranch =  fas_tree_measure.iduniquebranch and 
maxidrev.maxeje =  fas_tree_measure.idrev
where  fas_tree_measure.iduniquebranch like '002%'   and  fas_tree_measure.unitsn = '".$vparam_vnrounitsn."' and  idrununfo =".$vparam_idruninfo. " order by iduniqueop";
//	echo "<br>inicio:".$query_lista."<br>fin<br>";



		//	echo $query_lista;
				  $data = $connect->query($query_lista)->fetchAll();
				  $datapowers = $data;
				  $dataresumen = $data;
			$cantdetipodemediciones = count($datapowers);
			}
				 if ( $cantdetipodemediciones  < 2 )
				 {
					 echo "<div class='alert alert-danger' role='alert'> Incomplete calibration data: Error N.".$cantdetipodemediciones."</div>";
					 ?>
					 <script src="plugins/jquery/jquery.min.js"></script>
					 <script>
					 $('#cmbiditeracion').on('change', function() {
							//  alert( this.value );
						   window.location = this.value;
							})
					 </script>
					 <?php
					// exit();
				 }
				
				 
				  foreach ($data as $row) 
				  {
					  
					  //Calibration_EQ_Check
					  if("002" ==$row['iduniquebranch'])
					  {
						   $vpass = $row['totalpass'];
						   $v_iduniqueop = $row['iduniqueop'];
					  }

					///FinalCheck_Measures_LevelRead
						if("002007062" ==$row['iduniquebranch'])
						{
							//			echo "aaaaaaaaaaaaaaa<br>";
							//	select * from fas_ucmeasures   where iduniqueop = 182374  --- uclevel
							$query_listalevelread=" select distinct * from fas_ucmeasures where iduniqueop = ".$row['iduniqueop']." order by id_ucmeasures ";
							//		 echo $query_listalevelread;
							$indtooltip = 0;
							$vtmparrayind=0;
							$datalevelread1 = $connect->query($query_listalevelread)->fetchAll();
							foreach ($datalevelread1 as $rowleveltr1) 
							  {
								$Finalchk_levelread_uclevel[]= round($rowleveltr1['uclevel'],1); 
								$array_finalchk_levelread_uclevel =  $array_finalchk_levelread_uclevel."".round($rowleveltr1['uclevel'],1).",";	
								$showLevelread_pwrin = $rowleveltr1['pwrin'];

								$array_finalchk_levelread_tooltip_pwrin[$indtooltip][$vtmparrayind] =  $rowleveltr1['pwrin'];
								$array_finalchk_levelread_tooltip_uclevel[$indtooltip][$vtmparrayind] = round( $rowleveltr1['uclevel'],2);
								$array_finalchk_levelread_tooltip_ucchagc[$indtooltip][$vtmparrayind] =  $rowleveltr1['ucchagc'];
								$array_finalchk_levelread_tooltip_ucbbagc[$indtooltip][$vtmparrayind] =  $rowleveltr1['ucbbagc'];
								$array_finalchk_levelread_tooltip_ucoutputpwr[$indtooltip][$vtmparrayind] =  round($rowleveltr1['ucoutputpwr'],2);
								$array_finalchk_levelreadn_tooltip_uctemperature[$indtooltip][$vtmparrayind] = round( $rowleveltr1['uctemperature'],2);
								$array_finalchk_levelread_tooltip_pacurrent[$indtooltip][$vtmparrayind] =  $rowleveltr1['pacurrent'];
								$indtooltip = $indtooltip+ 1;
								$vtmparrayind = $vtmparrayind+1;
							  }	 
								//	select * from fas_sameasures   where iduniqueop = 182374   -- para titulo fcent
								$query_listalevelread2=" select distinct * from fas_sameasures where iduniqueop = ".$row['iduniqueop']." order by id_sameasures ";
								//	echo "<br>".$query_listalevelread2;

								$datalevelread1a = $connect->query($query_listalevelread2)->fetchAll();
								foreach ($datalevelread1a as $rowleveltr1a) 
								{
								$Finalchk_levelread_freq[]=$rowleveltr1a['fcent']; 
								$array_finalchk_levelread_freq=  $array_finalchk_levelread_freq."".$rowleveltr1a['fcent'].",";	

								}	 
						}
					  
					  	  ///FinalCheck_Measures_Gain
					  if("002007013" ==$row['iduniquebranch'])
					  {
						  
					
						   
							 $query_lista5=" select distinct filename from fas_sameasures where iduniqueop = ".$row['iduniqueop']." order by filename";
						//	echo  $query_lista5;
							$datalsgp = $connect->query($query_lista5)->fetchAll();
							 foreach ($datalsgp as $rowlsgp1) 
								  {
									$Finalchk_gain_plot[]=$rowlsgp1['filename']; 
									
								  }	   
								   
								   
						    $query_lista5=" select * from fas_singlemeasures where iduniqueop = ".$row['iduniqueop']." order by id_singlemeasure";
						//	echo  "<br>///FinalCheck_Measures_Gain".$query_lista5;
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
					  
					  ///00200701C02D  FinalCheck_Measures_NF_NoiseFloor
					  ///// OJO OJO OJOJ
					  //********************************************************* */
					  //********************************************************* */
					  //********************************************************* */
					  /// MODIFICAR ACA SACAR LOS VALORES DEL GENERICO.. DESDE SN. 

					  //********************************************************* */
					  //********************************************************* */
					  //********************************************************* */
					   if("00200701C02D" ==$row['iduniquebranch'])
					  {
						   $query_lista5=" select distinct filename from fas_sameasures where iduniqueop = ".$row['iduniqueop']." order by filename";
							$datalsgp = $connect->query($query_lista5)->fetchAll();
								$eliduniqoptooltop = $row['iduniqueop'];
						$indtooltip = 0;
							 foreach ($datalsgp as $rowlsgp1) 
								  {
									$Finalchk_NF_NoiseFloor_plot[]=$rowlsgp1['filename']; 
									
									
									//vamos a ver los datos para el tool tip text fas_ucmeasure 
										$query_lista5a=" select * from fas_ucmeasures where iduniqueop = ".$eliduniqoptooltop." order by id_ucmeasures desc";
									//	echo "<br>NF::".$query_lista5a."<br>";
										$data_ptooltip = $connect->query($query_lista5a)->fetchAll();
										$vtmparrayind=0;
										 foreach ($data_ptooltip as $rowdatoltip) 
											  {
												  //aca armar un array de dos dimensiones
												//  echo "<br>result".$rowdatoltip['pacurrent']."<br>";
												 $array_finalchk_noisefig_tooltip_pwrin[$indtooltip][$vtmparrayind] =  $rowdatoltip['pwrin'];
												 $array_finalchk_noisefig_tooltip_uclevel[$indtooltip][$vtmparrayind] = round( $rowdatoltip['uclevel'],2);
												 $array_finalchk_noisefig_tooltip_ucchagc[$indtooltip][$vtmparrayind] =  $rowdatoltip['ucchagc'];
												 $array_finalchk_noisefig_tooltip_ucbbagc[$indtooltip][$vtmparrayind] =  $rowdatoltip['ucbbagc'];
												 $array_finalchk_noisefig_tooltip_ucoutputpwr[$indtooltip][$vtmparrayind] =  round($rowdatoltip['ucoutputpwr'],2);
												 $array_finalchk_noisefig_tooltip_uctemperature[$indtooltip][$vtmparrayind] = round( $rowdatoltip['uctemperature'],2);
												 $array_finalchk_noisefig_tooltip_pacurrent[$indtooltip][$vtmparrayind] =  $rowdatoltip['pacurrent'];
												 $vtmparrayind = $vtmparrayind+ 1;
											  }
								$indtooltip  = $indtooltip +  1;
								
									
								  }	   
					  }
					  
					  ///array_finalchk_noisefig
					  if("00200701C" ==$row['iduniquebranch'])
					  {
						   
								   
						    $query_lista5=" select * from fas_noisefigure where iduniqueop = ".$row['iduniqueop']." order by idfas_noisefigure ";
						//	echo  "<br>". $query_lista5;
					
							$datalsgp = $connect->query($query_lista5)->fetchAll();
							 foreach ($datalsgp as $rowlsgp1) 
								  {
									 
									    
										$array_finalchk_noisefig=  $array_finalchk_noisefig."".$rowlsgp1['nf'].",";										
										  $array_finalchk_noisefigshow[] =  $rowlsgp1['nf'];
										  
										  
									
								  }
							  
					  }
					  
					  //FinalCheck_Measures_IMD				  
					   if("00200701B" ==$row['iduniquebranch'])
					  {
						  
						  	 $query_lista5=" select distinct filename from fas_sameasures where iduniqueop = ".$row['iduniqueop']." order by filename";
						//	 echo  $query_lista5;
							$datalsgp = $connect->query($query_lista5)->fetchAll();
							 foreach ($datalsgp as $rowlsgp1) 
								  {
									$Finalchk_imd_plot[]=$rowlsgp1['filename']; 
									
								  }	   
								  
								  
						  	$query_lista5=" select fas_sameasures.fcent, fas_mkrmeasures.*
							from fas_sameasures
							inner join fas_mkrmeasures
							on fas_mkrmeasures.iduniqueop   = fas_sameasures.iduniqueop and
							   fas_mkrmeasures.id_mkrmeasures = fas_sameasures.id_mkrmeasures
							where fas_sameasures.iduniqueop   = ".$row['iduniqueop']." order by id_mkrmeasures ";
						//	echo $query_lista5;
							
							$datalsgp = $connect->query($query_lista5)->fetchAll();
							$idindiceimd=1;
							 foreach ($datalsgp as $rowlsgp1) 
								  {
									  if ($idindiceimd==4)
									  {
											$Finalchk_imd_4[]=$rowlsgp1['pwr'];	
											$idindiceimd=0;
									  }
									   if ($idindiceimd==3)
									  {
											$Finalchk_imd_3[]=$rowlsgp1['pwr'];	
									  }
									   if ($idindiceimd==2)
									  {
										
										$Finalchk_imd_2[]=$rowlsgp1['pwr'];	
									
									  }
									   if ($idindiceimd==1)
									  {
										 $Finalchk_imdfreq[]=$rowlsgp1['fcent'];
										$Finalchk_imd_1[]=$rowlsgp1['pwr'];	
										
									  }
											$idindiceimd = $idindiceimd + 1;								
								  }	
					  }
					  
					    ///FinalCheck_Measures_MaxPower
						$mi = 0;
					  if("00200701A" ==$row['iduniquebranch'])
					  {
						
							$query_lista5=" select distinct filename from fas_sameasures where iduniqueop = ".$row['iduniqueop']." order by filename";
							$datalsgp = $connect->query($query_lista5)->fetchAll();
							
						
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
					  
					  ///002007031  FinalCheck_Measures_Lineality
					   if("002007031" ==$row['iduniquebranch'])
					  {
						
						//select distinct freq ,pwrin,  gainnoagc from fas_singlemeasures where iduniqueop = 503
					   //select distinct freq ,  gainnoagc from fas_singlemeasures where iduniqueop = 503
							$query_lista5="select distinct id_singlemeasure,	 freq , pwrin, gainnoagc from fas_singlemeasures where iduniqueop = ".$row['iduniqueop']." order by id_singlemeasure ";				
						    $datalsgp = $connect->query($query_lista5)->fetchAll();
							 foreach ($datalsgp as $rowlsgp1) 
								  {					
										$lblfreqmostrargrafico = round($rowlsgp1['freq'],1);
										$array_finalchk_abajo1_freq=  $array_finalchk_abajo1_freq."".round($rowlsgp1['freq'],1).",";										
										$array_finalchk_abajo1_pwrin=  $array_finalchk_abajo1_pwrin."".$rowlsgp1['pwrin'].",";										
										$array_finalchk_abajo1_gainnoagc=  $array_finalchk_abajo1_gainnoagc."".$rowlsgp1['gainnoagc'].",";										
								  }	
							$query_lista5="select id_mkrmeasures,pwr from fas_mkrmeasures where iduniqueop = ".$row['iduniqueop']." order by id_mkrmeasures ";				
						    $datalsgp = $connect->query($query_lista5)->fetchAll();
							 foreach ($datalsgp as $rowlsgp1) 
								  {										
										
										$array_finalchk_abajo2_pwr=  $array_finalchk_abajo2_pwr."".$rowlsgp1['pwr'].",";										
										
								  }	 

						$query_lista6="select *from fas_ucmeasures where iduniqueop = ".$row['iduniqueop']." order by id_ucmeasures  ";		
					//	echo "<br>".$query_lista6;
						    $datalsgp = $connect->query($query_lista6)->fetchAll();
							 foreach ($datalsgp as $rowlsgp16) 
								  {										
										
										$array_finalchk_abajo3_uclevel=  $array_finalchk_abajo3_uclevel."".$rowlsgp16['uclevel'].",";										
										$array_finalchk_abajo4_ucchanc=  $array_finalchk_abajo4_ucchanc."".$rowlsgp16['ucchagc'].",";										
										$array_finalchk_abajo5_ucbbagc=  $array_finalchk_abajo5_ucbbagc."".$rowlsgp16['ucbbagc'].",";										
										
								  }	 										  
								  
								
							  
					  }
					
				
				  }
				  
				//  echo "idunique op".$row['iduniqueop']."---".$v_iduniqueop;
							  
				
				  ?>
      		
		        <div class="row">
				
        
	
		 <section class="col-lg-12 connectedSortable ui-sortable">
		  <div class="rowmm fondoblanco">
				 
				 <div class="col-lg-12">
					
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
						<tr>
                      <td class="table-dark text-left">Noise Figure</td>
                      <?php
					 //  $minombrenf = $mi;
					   $mi=0;
					
					   foreach( $array_finalchk_noisefigshow as $leveldat) 
							{
							//	echo "<td>" . $leveldat . "</td>";
									echo "<td> <a href='#' class='tooltipmarcolink".$minombrenf."' onclick=abrirgaleria('imgmc$mi') onmouseout='ocultar_tooltip(".$minombrenf.")' onmouseover='mostrar_tooltip(".$minombrenf.")' >" . $leveldat . "</a>
									<div id='tooltipfreq".$minombrenf."' name='tooltipfreq".$minombrenf."' class='d-none tooltipmarco text-left' role='tooltip'>
								
<table class=' table-sm text-left texto10' border='0' style='table, tr, td, th {
     border: 0;
}'>
	<tr>
		<td class='text-left'><b>Pwr In</b></td>
		<td class='text-left'>".$array_finalchk_noisefig_tooltip_pwrin[$mi][$mi]." [dBm]</td>
		<td>&nbsp;&nbsp;</td>
		<td class='text-left'><b>FPGA Pwr Read</b></td>
		<td class='text-left'>".$array_finalchk_noisefig_tooltip_uclevel[$mi][$mi]." [dBm]</td>
		<td>&nbsp;&nbsp;</td>
		<td class='text-left'><b>Ch AGC</b></td>
		<td class='text-left'>".$array_finalchk_noisefig_tooltip_ucchagc[$mi][$mi]." [dB]</td>
	</tr>
		<tr>
		<td class='text-left'><b>BB AGC</b></td>
		<td class='text-left'>".$array_finalchk_noisefig_tooltip_ucbbagc[$mi][$mi]." [dB]</td>
	<td>&nbsp;&nbsp;</td>
		<td class='text-left'><b>uC OutputPwr</b></td>
		<td class='text-left'>".$array_finalchk_noisefig_tooltip_ucoutputpwr[$mi][$mi]." [dBm]</td>
	<td>&nbsp;&nbsp;</td>
		<td class='text-left'><b>Temperature</b></td>
		<td class='text-left'>".$array_finalchk_noisefig_tooltip_uctemperature[$mi][$mi]." [C]</td>
	</tr>
		<tr>
		<td class='text-left'><b>PACurrent</b></td>
		<td class='text-left'>".$array_finalchk_noisefig_tooltip_pacurrent[$mi][$mi]." [mA]</td>
	</tr>
</table>
								
									
								
								</div>
									</td>";
								$minombrenf=$minombrenf+1;
									$mi=$mi+1;
								if($mi==11)
								{
									//break;
								}
							}
					?>   		  					  
                    </tr> 
						
                     
                  </tbody>
				    </table>
					<br>


					<table class="table table-sm table-hover table-striped table-bordered text-center textotabla10">
                
				<thead class="thead-dark">
			   <tr>
				 <th class="table-dark text-left">Freq - [MHz]</th>
				 <?php
				 $mi=0;
				  foreach($Finalchk_levelread_freq as $fec) 
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

					<td class="table-dark text-left"> Level Read  @<?php echo $showLevelread_pwrin;
					///variable fija de pwrin de fas_ucmeasures para el iuniqueipp
					?> dBm</td>
                      <?php
					 //  $minombrenf = $mi;
					   $mi=0;
					
					   foreach( $Finalchk_levelread_uclevel as $leveldat) 
							{
							//	echo "<td>" . $leveldat . "</td>";
									echo "<td> <a href='#' class='tooltipmarcolink".$minombrenf."' onclick=abrirgaleria('imgmc$mi') onmouseout='ocultar_tooltip(".$minombrenf.")' onmouseover='mostrar_tooltip(".$minombrenf.")' >" . $leveldat . "</a>
									<div id='tooltipfreq".$minombrenf."' name='tooltipfreq".$minombrenf."' class='d-none tooltipmarco text-left' role='tooltip'>
								
<table class=' table-sm text-left texto10' border='0' style='table, tr, td, th {
     border: 0;
}'>
	<tr>
		<td class='text-left'><b>Pwr In</b></td>  
		<td class='text-left'>".$array_finalchk_levelread_tooltip_pwrin[$mi][$mi]." [dBm]</td>
		<td>&nbsp;&nbsp;</td>
		<td class='text-left'><b>FPGA Pwr Read</b></td>
		<td class='text-left'>".$array_finalchk_levelread_tooltip_uclevel[$mi][$mi]." [dBm]</td>
		<td>&nbsp;&nbsp;</td>
		<td class='text-left'><b>Ch AGC</b></td>
		<td class='text-left'>".$array_finalchk_levelread_tooltip_ucchagc[$mi][$mi]." [dB]</td>
	</tr>
		<tr>
		<td class='text-left'><b>BB AGC</b></td>
		<td class='text-left'>".$array_finalchk_levelread_tooltip_ucbbagc[$mi][$mi]." [dB]</td>
	<td>&nbsp;&nbsp;</td>
		<td class='text-left'><b>uC OutputPwr</b></td>
		<td class='text-left'>".$array_finalchk_levelread_tooltip_ucoutputpwr[$mi][$mi]." [dBm]</td>
	<td>&nbsp;&nbsp;</td>
		<td class='text-left'><b>Temperature</b></td>
		<td class='text-left'>".$array_finalchk_levelread_tooltip_uctemperature[$mi][$mi]." [C]</td>
	</tr>
		<tr>
		<td class='text-left'><b>PACurrent</b></td>
		<td class='text-left'>".$array_finalchk_levelread_tooltip_pacurrent[$mi][$mi]." [mA]</td>
	</tr>
</table>
								
									
								
								</div>
									</td>";
								$minombrenf=$minombrenf+1;
									$mi=$mi+1;
								if($mi==11)
								{
									//break;
								}
							}
					?>   		  					  
                    </tr> 
						
                     
                  </tbody>
				    </table>
			 </div>
			 <div class="col-lg-3">
			 
			
			 			
				 </div>
				 
			
		 </section>
		 
		 
		 	 <section class="col-lg-12 connectedSortable ui-sortable">
		  <div class="rowmm fondoblanco">
				 
				 <div class="col-lg-12">
					
		  <table class="table table-sm table-hover table-striped table-bordered text-center textotabla10">
                
                     <thead class="thead-dark">
                    <tr>
                      <th class="table-dark text-left">Frequency Center [MHz] </th>
					  <?php
					  $mi=0;
					   foreach($Finalchk_imdfreq as $fec) 
							{
								echo "<th>" . round($fec,3) . "</th>";
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
                      <td class="table-dark text-left">IMD 1</td>
                      <?php
					   $mi=0;
					   foreach($Finalchk_imd_1 as $leveldat) 
							{
								echo "<td>" . $leveldat . "</td>";
								$mi=$mi+1;
								if($mi==11)
								{
									//break;
								}
							}
					?>   	
												
                    </tr> 	
					 	<tr>
                      <td class="table-dark text-left">Fundamental Tone 1</td>
                      <?php
					   $mi=0;
					   foreach($Finalchk_imd_2 as $leveldat) 
							{
								echo "<td>" . $leveldat . "</td>";
								$mi=$mi+1;
								if($mi==11)
								{
									//break;
								}
							}
					?>   		  					  
                    </tr> 
						<tr>
                      <td class="table-dark text-left">Fundamental Tone 2</td>
                      <?php
					   $mi=0;
					   foreach( $Finalchk_imd_3 as $leveldat) 
							{
								echo "<td>" . $leveldat . "</td>";
								$mi=$mi+1;
								if($mi==11)
								{
									//break;
								}
							}
					?>   		  					  
                    </tr> 
						<tr>
                      <td class="table-dark text-left">IMD 2</td>
                      <?php
					   $mi=0;
					   foreach( $Finalchk_imd_4 as $leveldat) 
							{
								echo "<td>" . $leveldat . "</td>";
								$mi=$mi+1;
								if($mi==11)
								{
									//break;
								}
							}
					?>   		  					  
                    </tr> 
					
                     <tr>
                      <td class="table-dark text-left">Plots</td>
					  
					  <?php
					  $mi=0;
					  foreach( $Finalchk_imd_4 as $leveldat) 
							{
								
								?>
								<td><span class="hrefmanito colorazulfiplex" onclick="abrirgaleria('imgmg4<?php echo $mi;?>')">View </span>
								</td>
								<?php
								$mi=$mi+1;
								if($mi==11)
								{
									//break;
								}
							}
					  ?>
                      		
                    </tr> 
					
                  </tbody>
				    </table>
					
					
					 <div id="idocultargalleria" class="d-none">
					   <div id="galley4">
								  <ul class="pictures">
							<?php
								  $vt=0;
									  foreach ($Finalchk_imd_plot as $rowd) 
											  {
												  if ($vt ==0)
													{
												  ?>
												<li>
													<img id="imgmg4<?php echo $vt; ?>" name="imgmg4<?php echo $vt; ?>"  data-original="../plotsimg/<?php echo trim($rowd);?>.png" src="../plotsimg/<?php echo trim($rowd);?>.png" width="10%"> 
													
												</li>
												  <?php
													}
													else
													{
														  ?>
														<li>
															<img id="imgmg4<?php echo $vt; ?>" name="imgmg4<?php echo $vt; ?>"  data-original="../plotsimg/<?php echo trim($rowd);?>.png" src="../plotsimg/<?php echo trim($rowd);?>.png" width="10%" class="d-none" > 
															
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
			 </div>
			 <div class="col-lg-3">
			 
			
			 			
				 </div>
				 
			 </div>
		 </section>
		
		 	<br>
			  <section class="col-lg-3 connectedSortable ui-sortable">

            <div class="" name="divscrolllog" id="divscrolllog" style="display.">
			<p name="msjwaitline" id="msjwaitline" align="center"><img src="img/waitazul.gif" width="100px" ></p>	
				<div class="card">
					
				     <!-- Sales Chart Canvas -->
                  	<div class="card-header">
						<h5 class="card-title colorazulfiplex"><b>Gain</b></h5>
						<div class="card-tools">
							
						
							
						</div>
					</div>
				   <div class="chart">
                      <!-- Sales Chart Canvas -->
                     
					    <canvas id="salesCharttxripple" height="280" style="height: 280;"></canvas>
					   </div>
					   <br>
					   <p class="text-center">
					   
							<span class="hrefmanito colorazulfiplex" onclick="abrirgaleria('imgma0')">Plots Gain </span>
					   </p>
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
                 
                  
			
			 </div> 
			 

        </section>
	
		 <section class="col-lg-3 connectedSortable ui-sortable">
		

				<div class="card">
					<div class="card-header">
						<h5 class="card-title colorazulfiplex"><b>Max Power</b></h5>
						
					
					</div>
			<div class="chart">
                      <!-- Sales Chart Canvas -->
					   <canvas id="salesChartpowers" height="280" style="height: 280;"></canvas>
                    
					   </div>
					   <br>
					   <p class="text-center">
					   
							<span class="hrefmanito colorazulfiplex" onclick="abrirgaleria('imgmb0')">Plots Max Power </span>
					   </p>
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
				
				</div>
		 </section>
			<section class="col-lg-3 connectedSortable ui-sortable">
		

				<div class="card">
					<div class="card-header">
					
					
						<h5 class="card-title colorazulfiplex"><b>Noise Figure</b></h5>
						
						
					</div>
			<div class="chart">
                      <!-- Sales Chart Canvas -->
					   
                       <canvas id="salesChartlevel" height="280" style="height: 280;"></canvas>
					   </div>
					
					 <br>
					   <p class="text-center">
							<span class="hrefmanito colorazulfiplex" onclick="abrirgaleria('imgma0')">Plots Gain </span>
							 -- 
							<span class="hrefmanito colorazulfiplex" onclick="abrirgaleria('imgmc0')">Plots Noise Floor  </span>
					   </p>
					 <div id="idocultargalleria" class="d-none">
					   <div id="galley2">
								  <ul class="pictures">
							<?php
								  $vt=0;
									  foreach ($Finalchk_NF_NoiseFloor_plot as $rowd) 
											  {
												  if ($vt ==0)
													{
												  ?>
												<li>
													<img id="imgmc<?php echo $vt; ?>" name="imgmc<?php echo $vt; ?>"  data-original="../plotsimg/<?php echo trim($rowd);?>.png" src="../plotsimg/<?php echo trim($rowd);?>.png" width="10%"> 
													
												</li>
												  <?php
													}
													else
													{
														  ?>
														<li>
															<img  id="imgmc<?php echo $vt; ?>" name="imgmc<?php echo $vt; ?>"   data-original="../plotsimg/<?php echo trim($rowd);?>.png" src="../plotsimg/<?php echo trim($rowd);?>.png" width="10%" class="d-none" > 
															
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
			
				</div>
		 </section>
			  <section class="col-lg-3 connectedSortable ui-sortable">
			  
			    <div class="card">
					<div class="card-header">
						<h5 class="card-title colorazulfiplex"><b>Gain vs PwrIn @<?php echo $lblfreqmostrargrafico;?>MHz </b></h5>					
					</div>
						<div class="chart">
						<canvas id="graficoabajo1" height="280" style="height: 280;"></canvas>
					   </div>
					  <p class="text-center">
							<span class="hrefmanito colorazulfiplex" >&nbsp; </span>
						
					   </p>
					   <br>
				</div>
				 </section>
				 <section class="col-lg-3 connectedSortable ui-sortable">
				<div class="card">
					<div class="card-header">
						<h5 class="card-title colorazulfiplex"><b>PwrOut vs PwrIn @<?php echo $lblfreqmostrargrafico;?>MHz </b></h5>					
					</div>
					   <div class="chart">
					   <canvas id="graficoabajo2" height="280" style="height: 280;"></canvas>
					   </div>
					   
				</div>	
						 </section>
				 <section class="col-lg-3 connectedSortable ui-sortable">
<div class="card">
					<div class="card-header">
						<h5 class="card-title colorazulfiplex"><b>PwrIn Dynamic Range</b></h5>					
					</div>				
					   <div class="chart">                    
					    <canvas id="graficoabajo3" height="280" style="height: 280;"></canvas>
					   </div>
				</div>	   
			  
			  </section>
			  
		<br>
			  <section class="col-lg-3 connectedSortable ui-sortable">
			  
			    <div class="card">
					<div class="card-header">
						<h5 class="card-title colorazulfiplex"><b>Ch AGC vs PwrIn @<?php echo $lblfreqmostrargrafico;?>MHz  </b></h5>					
					</div>
						<div class="chart">
						<canvas id="graficoabajo4" height="280" style="height: 280;"></canvas>
					   </div>
				</div>
				 </section>
				   <section class="col-lg-3 connectedSortable ui-sortable">
			  
			    <div class="card">
					<div class="card-header">
						<h5 class="card-title colorazulfiplex"><b>BB AGC vs PwrIn @<?php echo $lblfreqmostrargrafico;?>MHz </b></h5>					
					</div>
						<div class="chart">
						<canvas id="graficoabajo5" height="280" style="height: 280;"></canvas>
					   </div>
				</div>
				 </section>
				 <section class="col-lg-3 connectedSortable ui-sortable">
			  
			  <div class="card">
				  <div class="card-header">
					  <h5 class="card-title colorazulfiplex"><b>Level Read  @<?php echo $showLevelread_pwrin;
					///variable fija de pwrin de fas_ucmeasures para el iuniqueipp
					?> dBm </b></h5>					
				  </div>
					  <div class="chart">
					  <canvas id="graficoabajo6" height="280" style="height: 280;"></canvas>
					 </div>
			  </div>
			   </section>
					
          <!-- /.col -->
        		<br><br>
		
      </div>
      <!-- /.timeline -->
  </div>
    </section>
    <!-- /.content -->
	
<!-- The end Modal para el zoom de las imagenes plot -->
	
  </div>
  <!-- /.content-wrapper -->
  
  </form>


  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
</div>

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- DataTables -->


<!-- AdminLTE for daterangepickers -->
<script src="plugins/select2/js/select2.full.min.js"></script>

<script src="plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>

<script src="crypto-js.js"></script><!-- https://github.com/brix/crypto-js/releases crypto-js.js can be download from here -->

<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="toastr.min.js"></script>

<script src="licencefiplex_mm.js"></script>
<script src="licencefiplex1.js"></script>
<script src="js/jquery.inactivityTimeout.js"></script>

<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
 <script src="js/eModal.min.js" type="text/javascript" />
<!-- Ion Slider -->
<script src="plugins/ion-rangeslider/js/ion.rangeSlider.min.js"></script>

<script type="text/javascript" src="js/tabulator.min.js"></script>
<script src="js/viewer.js"></script>
<script src="js/popperparacalibratio.min.js"></script>

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
	


	
	  var salesChart_finalchknoisefig = $('#salesChartlevel').get(0).getContext('2d');
	  var salesChart_finalchkmaxpowers = $('#salesChartpowers').get(0).getContext('2d'); 
	  var salesChart_finalchkgain = $('#salesCharttxripple').get(0).getContext('2d'); 
	  
		var salesChart_finalgraf1 = $('#graficoabajo1').get(0).getContext('2d'); 
		var salesChart_finalgraf2 = $('#graficoabajo2').get(0).getContext('2d'); 
		var salesChart_finalgraf3 = $('#graficoabajo3').get(0).getContext('2d'); 
		var salesChart_finalgraf4 = $('#graficoabajo4').get(0).getContext('2d'); 
		var salesChart_finalgraf5 = $('#graficoabajo5').get(0).getContext('2d'); 
		var salesChart_finalgraf6 = $('#graficoabajo6').get(0).getContext('2d'); 
	
	  

  var salesChartDatatotalesnoisefig = {
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
     	 data          :[<?php echo  $array_finalchk_noisefig;?>]
      },
    ]
  };
  
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

////definicion grafico abajo1 
   var datosgraficoabajo1 = {
    labels  : [<?php echo  $array_finalchk_abajo1_pwrin;?>],
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
     	 data          :[<?php echo  $array_finalchk_abajo1_gainnoagc;?>]
      },
    ]
  }
;

////definicion grafico abajo2 
   var datosgraficoabajo2 = {
    labels  : [<?php echo  $array_finalchk_abajo1_pwrin;?>],
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
     	 data          :[<?php echo  $array_finalchk_abajo2_pwr;?>]
      },
    ]
  }
;

////definicion grafico abajo3
   var datosgraficoabajo3 = {
    labels  : [<?php echo  $array_finalchk_abajo1_pwrin;?>],
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
     	 data          :[<?php echo  $array_finalchk_abajo3_uclevel;?>]
      },
    ]
  }
;
////definicion grafico abajo4
   var datosgraficoabajo4 = {
    labels  : [<?php echo  $array_finalchk_abajo1_pwrin;?>],
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
     	 data          :[<?php echo  $array_finalchk_abajo4_ucchanc;?>]
      },
    ]
  }
;
////definicion grafico abajo5
   var datosgraficoabajo5 = {
    labels  : [<?php echo  $array_finalchk_abajo1_pwrin;?>],
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
     	 data          :[<?php echo  $array_finalchk_abajo5_ucbbagc;?>]
      },
    ]
  }
;

////definicion grafico abajo6
   var datosgraficoabajo6 = {
    labels  : [<?php echo  $array_finalchk_levelread_freq;?>],
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
     	 data          :[<?php echo  $array_finalchk_levelread_uclevel;?>]
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
                   
				    suggestedMin: 80,
                    suggestedMax: 90
               }
	
		
      }]
    }
  }
  
  
  var salesChartOptionsnoise= {
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
                   
				    suggestedMin: 8,
                    suggestedMax: 15
               }
	
		
      }]
    }
  }
  var salesChartOptionslevelread= {
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
                   
				    suggestedMin: -71,
                    suggestedMax: -60
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
                   
				    suggestedMin: 20,
                    suggestedMax: 30
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
	
	  var salesChart2 = new Chart(salesChart_finalchknoisefig, { 
      type: 'line', 	
      data: salesChartDatatotalesnoisefig, 	 
      options: salesChartOptionsnoise
    });
	
	
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
	
	/// definicion grafico 5
	  var salesChart5 = new Chart(salesChart_finalgraf1, { 
      type: 'line', 	
      data: datosgraficoabajo1, 	
 options: optionesbasicasgrafico	  
      
    });
	/// definicion grafico 6
	  var salesChart6 = new Chart(salesChart_finalgraf2, { 
      type: 'line', 	
      data: datosgraficoabajo2, 	 
      options: optionesbasicasgrafico
    });
	/// definicion grafico 7
	  var salesChart7 = new Chart(salesChart_finalgraf3, { 
      type: 'line', 	
      data: datosgraficoabajo3, 	 
      options: optionesbasicasgrafico
    });
	/// definicion grafico 8
	  var salesChart8 = new Chart(salesChart_finalgraf4, { 
      type: 'line', 	
      data: datosgraficoabajo4, 	 
      options: optionesbasicasgrafico
    });
	/// definicion grafico 9
	  var salesChart9 = new Chart(salesChart_finalgraf5, { 
      type: 'line', 	
      data: datosgraficoabajo5, 	 
      options: optionesbasicasgrafico
    });
	/// definicion grafico 10
	  var salesChart10 = new Chart(salesChart_finalgraf6, { 
      type: 'line', 	
      data: datosgraficoabajo6, 	 
      options: salesChartOptionslevelread
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

	function open_calibstring(sn_a_calrstring)
		{
					var ipservidorapache= '<?php echo $ipservidorapache; ?>';
					var datosacortar = $("#cmbiditeracion").val();
					var separa = datosacortar.split("=");
	//indow.open('http://'+ipservidorapache+'/sendcalibrationstring.php?vsn='+sn_a_calrstring, '_blank');
	
		eModal.iframe('https://'+ipservidorapache+'/sendcalibrationstring.php?vsn='+sn_a_calrstring+'&idrun='+separa[4],'Calibration String');
			return false;
		}

function ver_log_seleccionado()
{
	var datosacortar = $("#cmbiditeracion").val();
	var separa = datosacortar.split("=");
		var ipservidorapache= '<?php echo $ipservidorapache; ?>';
	window.open('http://'+ipservidorapache+'/logdb.php?idab='+separa[4], '_blank');
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

<!DOCTYPE html>
<?php 

// Desactivar toda notificación de error
error_reporting(0);
// Notificar todos los errores de PHP (ver el registro de cambios)
//error_reporting(E_ALL);
 include("db_conectbypdf.php"); 


 require 'aws/aws-autoloader.php';
 require 'aws/fplmm.php';

 
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

    .pictures>li {
        /*  border: 1px solid transparent;
      float: left;
      height: calc(100% / 2);
      margin: 0 31px 0px 15px;
      overflow: hidden;
      width: calc(100% / 2);*/
    }

    .pictures>li>img {
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
        box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
        margin-bottom: 5px;
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
    </style>

</head>
<form name="frma" id="frma">



    <input type="hidden" name="uso" id="uso" value="0">

    <body class="hold-transition sidebar-mini sidebar-collapse">

        <div class="containermarco">



            <!-- Site wrapper -->
            <div class="wrapper">
                <!-- Navbar -->



                <!-- Content Wrapper. Contains page content -->
                <div class="">
                    <!-- Content Header (Page header) -->



                    <!-- Main content 
	
	levelsplot -> TotalRipplePlot -- nuevo titulo del gráfico: Total Ripple
Powersplot -> TxRipplePlot -- nuevo titulo del gráfico: Rx Ripple
RxRipplePlot es el nuevo campo -- nuevo titulo del gráfico: Tx Ripple
-->

                    <section class="content">

                        <div class="container-fluid">
                            <div class="card card-primary card-tabs ">

                                <span class="text-right">

                                    <?php
		  
			$vparam_vnrounitsn = $_REQUEST['idsndib']; ///// "20000000fu";	
			$vparam_band = $_REQUEST['idmb'];
			
			$vparam_uldld = $_REQUEST['iduldl'];
			/////**************************************************** 
			/////**************************************************** 
			///Detectamos CIU
			/////**************************************************** 
			/////**************************************************** 
			$ciuisbda="N";
			$ciuisdas="N";
			$sqldetect="select fnt_select_detect_bysn_isbda_isdas('".$vparam_vnrounitsn."','WO') ";
			$datadetect = $connect->query($sqldetect)->fetchAll();
			foreach ($datadetect as $rowdetect) 
								  {	
									//  echo ".....".$rowdetect[0];
									  $resulm = json_decode($rowdetect[0]);
									// echo "****".$resulm->{'isdas'};
									  if( $resulm->{'isdba'} >0 )
									  {
										$ciuisbda="Y";
									  }
									  if( $resulm->{'isdas'} >0 )
									  {
										$ciuisdas="Y";
									  }
								  } 
							 

			/////**************************************************** 								
			//fin detectamos CIU
			/////**************************************************** 
			/////**************************************************** 
			
			echo "	<a href='equalizeriir.php?idsndib=".$_REQUEST['idsndib']."&iduldl=".$vparam_uldld."&idmb=".$vparam_band."' target='_blank'>Open in New Tab</a> &nbsp;&nbsp;&nbsp;</span>";
         ?>
                                    <div class="col-10">
                                        <div class="form-group row">

                                            <?php if ($_REQUEST['tracking']=="")
				{
					?>

                                            <span class="col-sm-2 col-form-label textotabla10">Select the
                                                Iteration:</span>

                                            <select class="form-control col-sm-4 form-control-sm" name="cmbiditeracion"
                                                id="cmbiditeracion">
                                                <?php
		     
		     $sql="SELECT DISTINCT  idrununfo as idruninfo, max(datetime) as fechahora  from fas_tree_measure where unitsn = '".$vparam_vnrounitsn."' and  uldl = ".$vparam_uldld." and band = ". $vparam_band." and iduniquebranch like '001%' group by idrununfo order by fechahora desc ";
		//	echo $sql;
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
											echo " <option ".$loencontre." value='equalizeriir.php?idsndib=".$_REQUEST['idsndib']."&iduldl=".$vparam_uldld."&idmb=".$vparam_band."&idruninfo=".$vparam_idruninfo."'>".$vidnro." [".$fechahcortada."]</option>";
										$vidnro = $vidnro + 1;
									  }
									  ?>
                                            </select>
                                            <?php } 
					  ?>

                                        </div>
                                    </div>
                                    <div class="card-header p-0 pt-1 d-none">
                                        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                            <li class="nav-item ">
                                                <a class="nav-link active" id="custom-tabs-one-home-tab"
                                                    data-toggle="pill" href="#custom-tabs-one-home" role="tab"
                                                    aria-controls="custom-tabs-one-home" aria-selected="false">UL</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill"
                                                    href="#custom-tabs-one-profile" role="tab"
                                                    aria-controls="custom-tabs-one-profile" aria-selected="false">DL</a>
                                            </li>

                                        </ul>
                                    </div>
                                    <div class="card-body d-none">
                                        <div class="tab-content" id="custom-tabs-one-tabContent">
                                            <div class="tab-pane fade active show" id="custom-tabs-one-home"
                                                role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">


                                            </div>
                                            <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel"
                                                aria-labelledby="custom-tabs-one-profile-tab">

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
		  
			$vparam_vnrounitsn = $_REQUEST['idsndib']; ///// "20000000fu";	
			$vparam_band = $_REQUEST['idmb'];
			
		
			
			$vparam_uldld = $_REQUEST['iduldl'];
	
	     // $sql="SELECT DISTINCT  idrununfo as idruninfo, max(datetime) as fechahora  from fas_tree_measure where unitsn = '".$vparam_vnrounitsn."' and  uldl = ".$vparam_uldld." and band = ". $vparam_band." and iduniquebranch like '001%' group by idrununfo order by idrununfo asc ";
		  
		     $sql="SELECT DISTINCT  MAX(fas_tree_measure.idrununfo) as idruninfo  from fas_tree_measure
			   inner join fas_calibration_result on fas_calibration_result.unitsn = fas_tree_measure.unitsn and  fas_calibration_result.idruninfo = fas_tree_measure.idrununfo
			   and 	fas_calibration_result.modelciu in(select distinct  modelciu from products where  idproduct in (select distinct idproduct from products_attributes where v_boolean= true and idattribute = 0)) 
			  where fas_tree_measure.unitsn = '".$vparam_vnrounitsn."' and  fas_tree_measure.uldl = ".$vparam_uldld." and fas_tree_measure.band = ". $vparam_band." and fas_tree_measure.iduniquebranch like '001%' ";
								   $datacabez = $connect->query($sql)->fetchAll();							
								  foreach ($datacabez as $rowheaders) 
								  {
									
											   $vparam_idruninfo = $rowheaders['idruninfo'];
											 
										
									  }
									  
	
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
		  	$v_Levels_Offset = 0;
								$v_Squelch_Offset = 0;
								$v_Gain_Offset = 0;
								$v_Max_Pwr_Offset = 0;
								
								$v_currentminvalor = 0;
								$v_currentmaxvalor = 0;
								$v_Gain_Offset_min= 0;
								$v_Gain_Offset_max=0;

								$v_Max_Pwr_Offset_min=0;
								$v_Max_Pwr_Offset_max= 0;

								// OJO ACA
							//	$v_currentminmeasurerango = 0;
							//	$v_currentmaxmeasurerango = 0;
								
		  $query_lista="SELECT fas_tree_measure.totalpass,  fas_tree_measure.iduniqueop,  fas_step.description as namebranch,  fas_tree_measure.iduniquebranch, fas_tree_measure.unitsn, fas_tree_measure.dibsn, fas_tree_measure.uldl, fas_tree_measure.band
,fas_tree_measure.idrununfo
from fas_tree_measure
inner join fas_tree
on fas_tree.iduniquebranch = fas_tree_measure.iduniquebranch  and fas_tree.idfastree =  1
inner join fas_step
on fas_step.idfasstep = fas_tree.idfastrepson
where uldl = ".$vparam_uldld." and band = ".$vparam_band." and  unitsn = '".$vparam_vnrounitsn."' and  idrununfo =".$vparam_idruninfo. " order by iduniqueop";


				 
		
		//	echo "query 1:::". $query_lista;
				  $data = $connect->query($query_lista)->fetchAll();
				  $datapowers = $data;
				
				 $cantdetipodemediciones = count($datapowers);
			}	 
				 if ( $cantdetipodemediciones  < 8 )
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
					 exit();
				 }

				 $v_Levels_Offset_min= 0;
				 $v_Levels_Offset_max=0;
				 $v_Squelch_Offset_min= 0;
				$v_Squelch_Offset_max=0;
				 
				  foreach ($data as $row) 
				  {
					  
					  //Calibration_EQ_Check
					  if("00100300B" ==$row['iduniquebranch'])
					  {
						   $vpass = $row['totalpass'];
						   $v_iduniqueop = $row['iduniqueop'];
					  }
					  
					  	  ///Calibration_LSGP_Calibration_Levels GAIN NO CALIBRADA
					  if("00100401401F" ==$row['iduniquebranch'])
					  {
						    $query_lista5=" select filename from fas_sameasures where iduniqueop = ".$row['iduniqueop']." ";
							$datalsgp = $connect->query($query_lista5)->fetchAll();
							 foreach ($datalsgp as $rowlsgp1) 
								  {
									$Calibration_LSGP_Calibration_gain_plot=$rowlsgp1['filename'];  
								  }
								   
						    $query_lista5=" select * from fas_singlemeasures where iduniqueop = ".$row['iduniqueop']." ";
							$datalsgp = $connect->query($query_lista5)->fetchAll();
							 foreach ($datalsgp as $rowlsgp1) 
								  {
									$Calibration_LSGP_Calibration_gain_freqshow=round($rowlsgp1['freq'],3);  
									$Calibration_LSGP_Calibration_gain_gainnoagc=round($rowlsgp1['gainnoagc'],2);  
									
								  }
							  
					  }
					   ///Calibration_LSGP_Calibration_Powers Max pwr  NO CALIBRADA
					  if("001004014022" ==$row['iduniquebranch'])
					  {
						    $query_lista5=" select filename from fas_sameasures where iduniqueop = ".$row['iduniqueop']." ";
							$datalsgp = $connect->query($query_lista5)->fetchAll();
							 foreach ($datalsgp as $rowlsgp1) 
								  {
									$Calibration_LSGP_Calibration_maxpwr_plot=$rowlsgp1['filename'];  
								  }
								  
								    $query_lista5=" select * from fas_mkrmeasures where iduniqueop = ".$row['iduniqueop']." ";
							$datalsgp = $connect->query($query_lista5)->fetchAll();
							 foreach ($datalsgp as $rowlsgp1) 
								  {
									$Calibration_LSGP_Calibration_maxpwr_freq=round($rowlsgp1['freq'],3);  
									$Calibration_LSGP_Calibration_maxpwr_pwrnoagc=$rowlsgp1['pwr'];  



								  }
							  
					  }
					  
					  ///Calibration_LSGP_Check_Levels gain  CALIBRADA
					  if("001004015024" ==$row['iduniquebranch'])
					  {
						    $query_lista5=" select filename from fas_sameasures where iduniqueop = ".$row['iduniqueop']." ";
							$datalsgp = $connect->query($query_lista5)->fetchAll();
							 foreach ($datalsgp as $rowlsgp1) 
								  {
									$Calibration_LSGP_Calibration_gain_plot_calib=$rowlsgp1['filename'];  
								  }
								  
								   $query_lista5=" select * from fas_singlemeasures where iduniqueop = ".$row['iduniqueop']." ";
							$datalsgp = $connect->query($query_lista5)->fetchAll();
							 foreach ($datalsgp as $rowlsgp1) 
								  {
									$Calibration_LSGP_Calibration_gain_gainagc=$rowlsgp1['gainwithagc'];  
									
								  }
							  
					  }
					   ///Calibration_LSGP_Check_Powers max pwr  CALIBRADA
					  if("001004015027" ==$row['iduniquebranch'])
					  {
						    $query_lista5=" select filename from fas_sameasures where iduniqueop = ".$row['iduniqueop']." ";
							$datalsgp = $connect->query($query_lista5)->fetchAll();
							 foreach ($datalsgp as $rowlsgp1) 
								  {
									$Calibration_LSGP_Calibration_maxpwr_plot_calib  =  $rowlsgp1['filename'];  
								  }
								  
								   $query_lista5=" select * from fas_mkrmeasures where iduniqueop = ".$row['iduniqueop']." ";
									$datalsgp = $connect->query($query_lista5)->fetchAll();
							 foreach ($datalsgp as $rowlsgp1) 
								  {
									
									$Calibration_LSGP_Calibration_maxpwr_pwragc=$rowlsgp1['pwr'];  
								  }
							  
					  }
						  
					  ///Calibration_LSGP_Calibration GAIN NO CALIBRADA
					  
					  if("001004015" ==$row['iduniquebranch'])
					  {
						  
						  
						    $query_lista4=" select * from fas_lsgp where iduniqueop = ".$row['iduniqueop']." ";
					//	  echo   $query_lista4;
							  $datalsgp = $connect->query($query_lista4)->fetchAll();		 
				 
								$v_Levels_Offset = 0;
								$v_Squelch_Offset = 0;
								$v_Gain_Offset = 0;
								$v_Max_Pwr_Offset = 0;
								
								$v_currentminvalor = 0;
								$v_currentmaxvalor = 0;
							// OJO ACA
							//	$v_currentminmeasurerango = 0;
							//	$v_currentmaxmeasurerango = 0;
								
								
								  foreach ($datalsgp as $rowlsgp) 
								  {
									  //v_Levels_Offset
										$v_Levels_Offset = round($rowlsgp['leveloffset'],2);
										if (  $v_Levels_Offset > 0)
										{
											$v_Levels_Offset_min=0;
											$v_Levels_Offset_max= $v_Levels_Offset;
										}
										else
										{
											$v_Levels_Offset_min= $v_Levels_Offset;
											$v_Levels_Offset_max=0;
										}
										// v_Squelch_Offset						
										$v_Squelch_Offset = round($rowlsgp['sqoffset'],2);
										if (  $v_Squelch_Offset > 0)
										{
											$v_Squelch_Offset_min=0;
											$v_Squelch_Offset_max= $v_Squelch_Offset;
										}
										else
										{
											$v_Squelch_Offset_min= $v_Squelch_Offset;
											$v_Squelch_Offset_max=0;
										}
										// v_Squelch_Offset							
										$v_Gain_Offset = round($rowlsgp['gainoffset'],2);
										if (  $v_Gain_Offset > 0)
										{
											$v_Gain_Offset_min=0;
											$v_Gain_Offset_max= $v_Gain_Offset;
										}
										else
										{
											$v_Gain_Offset_min= $v_Gain_Offset;
											$v_Gain_Offset_max=0;
										}
										
										//v_Max_Pwr_Offset						
										$v_Max_Pwr_Offset = round($rowlsgp['poweroffset'],2);
											if (  $v_Max_Pwr_Offset > 0)
										{
											$v_Max_Pwr_Offset_min=0;
											$v_Max_Pwr_Offset_max= $v_Max_Pwr_Offset;
										}
										else
										{
											$v_Max_Pwr_Offset_min= $v_Max_Pwr_Offset;
											$v_Max_Pwr_Offset_max=0;
										}
										
										
										$v_Levels_Offset_class="";
										$v_Squelch_Offset_class="";
										$v_Gain_Offset_class=""; 
										$v_Max_Pwr_Offset_class="";
								
										$v_currentminvalor = round($rowlsgp['pacurrentminlimit'],2);
										$v_currentmaxvalor = round($rowlsgp['pacurrentmaxlimit'],2);
										
								//	echo "aaaaaaaaaaaaa limit:".$v_currentminvalor."-- consumo:".$v_currentmaxvalor;
										
								  }
					  }
					  
					  /*
					  fa_samasmasure
singlemeasures
fas_mkrmeasures -- tmb poner la frequencua
					  */
					  ///Calibration_EQ_Calibration_Levels
					  if("00100300A008" ==$row['iduniquebranch'] && $freqlabel =="" ) 
					  {
						  // Buscamos freq y valores

						  $query_lista2=" select * from fas_mkrmeasures where iduniqueop = ".$row['iduniqueop']."  order by freq asc";
				//		  echo  "array para freq:".$query_lista2;
				//		  exit();
						 
							$data2 = $connect->query($query_lista2)->fetchAll();
							 foreach ($data2 as $row2) 
								{
										  $arrayfreq[] = $row2['freq'];
										
										  $freqlabel =  $freqlabel."".$row2['freq'].",";
								}

						  $query_lista2=" select * from fas_sameasures where iduniqueop = ".$row['iduniqueop']." order by id_sameasures";
						///  echo  "array para freq:".$query_lista2;
							$data2 = $connect->query($query_lista2)->fetchAll();
							 foreach ($data2 as $row2) 
								{
										////no va mas acaa  $arrayfreq[] = $row2['fcent'];
										  $noteqwithoutagc[] = $row2['filename'];
										////no va mas aca  $freqlabel =  $freqlabel."".$row2['fcent'].",";
								}
							$query_lista2=" select * from fas_equalizeriir_relative_measure where iduniqueop = ".$row['iduniqueop']." order by idfaseqreme";
							$data2 = $connect->query($query_lista2)->fetchAll();
							 foreach ($data2 as $row2) 
								{
										   
										    $arraytotalrippleplot0[] =  $row2['relatvalue'];
											$graftotal0=  $graftotal0."".$row2['relatvalue'].",";
											
										
								}
					
						
					  }
					  
					   ///Calibration_EQ_Calibration_Powers
					  if("00100300A00C" ==$row['iduniquebranch'])
					  {
						  // Buscamos freq y valores
						   $query_lista2=" select * from fas_sameasures where iduniqueop = ".$row['iduniqueop']." order by id_sameasures";
						 
							$data2 = $connect->query($query_lista2)->fetchAll();
							 foreach ($data2 as $row2) 
								{									 
										  $noteqagc[] = $row2['filename'];										 
								}
										
							$query_lista2=" select * from fas_equalizeriir_relative_measure where iduniqueop = ".$row['iduniqueop']." order by idfaseqreme";
							$data2 = $connect->query($query_lista2)->fetchAll();
							 foreach ($data2 as $row2) 
								{
										   $arraypowers0[] = $row2['relatvalue'];
										   $grafpower0=  $grafpower0."".$row2['relatvalue'].",";
								}
							//	echo "a:".$grafpower0;			
					  }
					   ///Calibration_EQ_Check_Levels
					  if("00100300B01D" ==$row['iduniquebranch'])
					  {
						  // Buscamos freq y valores 
						   $query_lista2=" select * from fas_sameasures where iduniqueop = ".$row['iduniqueop']." order by id_sameasures";
						 $data2 = $connect->query($query_lista2)->fetchAll();
							 foreach ($data2 as $row2) 
								{										 
										  $eqwithoutagc[] = $row2['filename'];	
																			  
								}
							 
						
							$query_lista2=" select * from fas_equalizeriir_relative_measure where iduniqueop = ".$row['iduniqueop']." order by idfaseqreme";
						 
							
							$data2 = $connect->query($query_lista2)->fetchAll();
							 foreach ($data2 as $row2) 
								{
										    $arraytotalrippleplot1[] =  $row2['relatvalue'];
											$graftotal1=  $graftotal1."".$row2['relatvalue'].",";
								}
								
								$query_lista2=" select * from  fas_ucmeasures where iduniqueop = ".$row['iduniqueop']." and  id_ucmeasures in( select max(id_ucmeasures) from  fas_ucmeasures where iduniqueop = ".$row['iduniqueop'].") ";
							///	echo "<br>mostramo query consumo:".$query_lista2;
								$data2 = $connect->query($query_lista2)->fetchAll();
								foreach ($data2 as $row2) 
								{
										   $v_currentminmeasurerango = round($row2['pacurrent'],2);	
								}
				//	echo "2da aaaaaaaaaaaaaaaaaa.". $v_currentminmeasurerango."fin<br>";
						
					  }
					//  echo "abc";
					   ///Calibration_EQ_Check_Powers
					  if("00100300B02E" ==$row['iduniquebranch'])
					  {
						  // Buscamos freq y valores
					
						 $query_lista2=" select * from fas_sameasures where iduniqueop = ".$row['iduniqueop']." order by id_sameasures";
						 $data2 = $connect->query($query_lista2)->fetchAll();
							 foreach ($data2 as $row2) 
								{										 
										  $eqagc[] = $row2['filename'];									 
								}
								
							$query_lista2=" select * from fas_equalizeriir_relative_measure where iduniqueop = ".$row['iduniqueop']." order by idfaseqreme";
							
							$data2 = $connect->query($query_lista2)->fetchAll();
							 foreach ($data2 as $row2) 
								{
										   $arraypowers1[] = $row2['relatvalue'];
										  $grafpower1=  $grafpower1."".$row2['relatvalue'].",";
								}
								
								$query_lista2=" select * from  fas_ucmeasures where iduniqueop = ".$row['iduniqueop']." and  id_ucmeasures in( select max(id_ucmeasures) from  fas_ucmeasures where iduniqueop = ".$row['iduniqueop'].") ";
								$data2 = $connect->query($query_lista2)->fetchAll();
								foreach ($data2 as $row2) 
								{
										   $v_currentmaxmeasurerango = round($row2['pacurrent'],2);
								}
					
						
					  }
					  					  	 
					/* 
					Not Equalized
id 53 Total. Ripple  --  id 54  TX  Riple ----Rx = 53-54 (asi lo calculo)
			  	$arraylevel1 [] = $row2['relatvalue'];
										   $graflevels1 =  $graflevels1."".$row2['relatvalue'].",";
					$arraylevel1[] = $row['levelsplot0'];
					 // $arraypowers0[] = $row['powersplot1'];
					   $arraypowers1[] = $row['powersplot0'];					   
					     $arraytotalrippleplot0[] = $row['totalrippleplot1'];
					     $arraytotalrippleplot1[] = $row['totalrippleplot0'];
					   					  $freqlabel =  $freqlabel."".$row['freq'].",";					
					  $graflevels1 =  $graflevels1."".$row['levelsplot1'].",";					  
					  $grafpower0 =  $grafpower0."".$row['powersplot0'].",";
					  $grafpower1 =  $grafpower1."".$row['powersplot1'].",";					  
					  $graftotal0 =  $graftotal0."".$row['totalrippleplot0'].",";
					  $graftotal1 =  $graftotal1."".$row['totalrippleplot1'].",";					 
					    $vpass = $row['pass'];
					  */					  
				
				  }
				  
				//  echo "idunique op".$row['iduniqueop']."---".$v_iduniqueop;
							  
				  for($i=0; $i<11; $i++)
							  {
							  //saco el valor de cada elemento
									$vv_rr =  $arraytotalrippleplot0[$i] - $arraypowers0[$i];
									$arraylevel0[] = $vv_rr;
								    $graflevels10 =  $graflevels10."".$vv_rr.",";
									
									$vv_rr2 =  ($arraytotalrippleplot1[$i]) - ($arraypowers1[$i]);
								///	echo "<br>result:".floatval($vv_rr2);
									 $arraylevel1[] = floatval($vv_rr2);
								     $graflevels1 =  $graflevels1."".floatval($vv_rr2).",";
										
							  }
			
				  ?>

                            <div class="row">

                                <section class="col-lg-4 connectedSortable ui-sortable">

                                    <div class="" name="divscrolllog" id="divscrolllog" style="display.">
                                        <p name="msjwaitline" id="msjwaitline" align="center"><img
                                                src="img/waitazul.gif" width="100px"></p>
                                        <div class="card">

                                            <!-- Sales Chart Canvas -->
                                            <div class="card-header">
                                                <h5 class="card-title colorazulfiplex"><b>TOTAL RIPPLE</b></h5>
                                                <div class="card-tools">
                                                    <?php
								if (   $vpass =="true")
								{
									?>
                                                    <span class="badge badge-pill badge-success">Passed</span>
                                                    <?php
								}
								else
								{
									?>
                                                    <span class="badge badge-pill badge-danger">Not Passed</span>
                                                    <?php
								}
							?>


                                                </div>
                                            </div>
                                            <div class="chart">
                                                <!-- Sales Chart Canvas -->

                                                <canvas id="salesCharttxripple" height="280"
                                                    style="height: 280;"></canvas>
                                            </div>






                                        </div>


                                </section>
                                <section class="col-lg-4 connectedSortable ui-sortable">


                                    <div class="card">
                                        <div class="card-header">


                                            <h5 class="card-title colorazulfiplex"><b>RX RIPPLE</b></h5>


                                        </div>
                                        <div class="chart">
                                            <!-- Sales Chart Canvas -->

                                            <canvas id="salesChartlevel" height="280" style="height: 280;"></canvas>
                                        </div>


                                    </div>
                                </section>
                                <section class="col-lg-4 connectedSortable ui-sortable">


                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title colorazulfiplex"><b>TX RIPPLE</b></h5>


                                        </div>
                                        <div class="chart">
                                            <!-- Sales Chart Canvas -->
                                            <canvas id="salesChartpowers" height="280" style="height: 280;"></canvas>

                                        </div>


                                    </div>
                                </section>


                                <section class="col-lg-12 connectedSortable ui-sortable">
                                    <div class="rowmm fondoblanco">

                                        <div class="col-lg-9">

                                            <table
                                                class="table table-sm table-hover table-striped table-bordered text-center textotabla10">

                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th class="table-dark text-left">Freq - [MHz]</th>
                                                        <?php
						$mi=0;
					   foreach($arrayfreq as $fec) 
							{
								echo "<th>" . $fec . "</th>";
								$mi=$mi+1;
								if($mi==11)
								{
									break;
								}
							}
					?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="table-dark text-left">Total Ripple not eq</td>
                                                        <?php
					   $mi=0;
					   foreach($arraytotalrippleplot0 as $leveldat) 
							{
								echo "<td>" . $leveldat . "</td>";
								$mi=$mi+1;
								if($mi==11)
								{
									break;
								}
							}
					?>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-dark text-left">Total Ripple eq</td>
                                                        <?php
					   $mi=0;
					   foreach($arraytotalrippleplot1 as $leveldat) 
							{
								echo "<td>" . $leveldat . "</td>";
								$mi=$mi+1;
								if($mi==11)
								{
									break;
								}
							}
					?>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-dark text-left">Rx Ripple not eq</td>
                                                        <?php
					   $mi=0;
					   foreach($arraylevel0 as $leveldat) 
							{
								echo "<td>" . $leveldat . "</td>";
								$mi=$mi+1;
								if($mi==11)
								{
									break;
								}
							}
					?>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-dark text-left">Rx Ripple eq</td>
                                                        <?php
					    $mi=0;
												
					   foreach($arraylevel1 as $leveldat) 
							{
							///	echo "adentro".$leveldat;
								echo "<td>" . $leveldat . "</td>";
								$mi=$mi+1;
								if($mi==11)
								{
									break;
								}
							}
							
					?>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-dark text-left">Tx Ripple not eq</td>
                                                        <?php
					    $mi=0;
					   foreach($arraypowers0 as $leveldat) 
							{
								echo "<td>" . $leveldat . "</td>";
								
								$mi=$mi+1;
								if($mi==11)
								{
									break;
								}
							}
					?>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-dark text-left">Tx Ripple eq</td>
                                                        <?php
					    $mi=0;
					   foreach($arraypowers1 as $leveldat) 
							{
								echo "<td>" . $leveldat . "</td>";
								$mi=$mi+1;
								if($mi==11)
								{
									break;
								}
							}
							
						//	levelsplot -> TotalRipplePlot -- nuevo titulo del gráfico: Total Ripple
						//  Powersplot -> TxRipplePlot -- nuevo titulo del gráfico: Rx Ripple
						//  RxRipplePlot es el nuevo campo -- nuevo titulo del gráfico: Tx Ripple

					?>
                                                    </tr>
                                                    <br>

                                                </tbody>
                                            </table>

                                        </div>
                                        <div class="col-lg-3">

                                            <br>
                                            <div id="accordion">
                                                <!-- we are adding the .class so bootstrap.js collapse plugin detects it -->
                                                <div class="">
                                                    <div class="">
                                                        <b>Plots:</b><br><br>
                                                        <h4 class="textotabla10 ">
                                                            &nbsp;<span class="colornaranajafiplex"></span> <a
                                                                data-toggle="collapse" data-parent="#accordion"
                                                                href="#collapseOne" class="collapsed"
                                                                aria-expanded="false">
                                                                <span class="hrefmanito"
                                                                    onclick="abrirgaleria('imgma0')"> Not Equalized
                                                                    WITHOUT AGC </span>
                                                            </a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapseOne22" class="panel-collapse in collapse" style="">
                                                        <div class="card-body">
                                                            <div id="galley">
                                                                <ul class="pictures">
                                                                    <?php
								  $vt=0;
								///  echo "Agusver:".var_dump($noteqwithoutagc);
									  foreach ($noteqwithoutagc as $rowd) 
											  {

												//Get a command to GetObject
												$pngtemp = "".trim($rowd)."";
												echo "MARCOVER.".$pngtemp."<br>";
												$cmd0 = $clientS3AWS->getCommand('GetObject', [
													'Bucket' => 'fpxwebfas',
													'Key'    => $pngtemp
												]);

												//The period of availability
												$request = $clientS3AWS->createPresignedRequest($cmd0, '+20 minutes');

												//echo var_dump($request);
												//Get the pre-signed URL
												$signedUrl = (string) $request->getUri();
												///echo "<br>a ver aqui:".$signedUrl;


												  if ($vt ==0)
													{

														
												  ?>
                                                                    <li>
                                                                        <img id="imgma<?php echo $vt; ?>"
                                                                            name="imgma<?php echo $vt; ?>"
                                                                            data-original="<?php echo $signedUrl;?>"
                                                                            src="<?php echo $signedUrl;?>" width="10%">

                                                                    </li>
                                                                    <?php
													}
													else
													{
														  ?>
                                                                    <li>
                                                                        <img data-original="<?php echo $signedUrl;?>"
                                                                            src="<?php echo $signedUrl;?>" width="10%"
                                                                            class="d-none">

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
                                                </div>

                                                <div class="divmarco">
                                                    <div class="">
                                                        <h4 class="textotabla10 ">
                                                            &nbsp;<span class="colornaranajafiplex"><a
                                                                    data-toggle="collapse" data-parent="#accordion"
                                                                    href="#collapseTwo" class="collapsed"
                                                                    aria-expanded="false">
                                                                    <span class="hrefmanito"
                                                                        onclick="abrirgaleria('imgmb0')"> Equalized
                                                                        WITHOUT AGC</span>
                                                                </a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapseTwo23" class="panel-collapse collapse">
                                                        <div class="card-body">
                                                            <div id="galley1">
                                                                <ul class="pictures">
                                                                    <?php
								  $vt=0;
									  foreach ($eqwithoutagc as $rowd) 
											  {

												$pngtemp1 = "".trim($rowd)."";
											//	echo $pngtemp;
												$cmd1 = $clientS3AWS->getCommand('GetObject', [
													'Bucket' => 'fpxwebfas',
													'Key'    => $pngtemp1
												]);

												//The period of availability
												$request1 = $clientS3AWS->createPresignedRequest($cmd1, '+20 minutes');

												//echo var_dump($request);
												//Get the pre-signed URL
												$signedUrl1 = (string) $request1->getUri();
												///echo "<br>a ver aqui:".$signedUrl;


												  if ($vt ==0)
													{
												  ?>
                                                                    <li>
                                                                        <img id="imgmb<?php echo $vt; ?>"
                                                                            name="imgmb<?php echo $vt; ?>"
                                                                            data-original="<?php echo $signedUrl1;?>"
                                                                            src="<?php echo $signedUrl1;?>" width="10%">

                                                                    </li>
                                                                    <?php
													}
													else
													{
														  ?>
                                                                    <li>
                                                                        <img data-original="<?php echo $signedUrl1;?>"
                                                                            src="<?php echo $signedUrl1;?>" width="10%"
                                                                            class="d-none">

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
                                                </div>

                                                <div class="divmarco">
                                                    <div class="">
                                                        <h4 class="textotabla10 ">
                                                            &nbsp;<span class="colornaranajafiplex"></a> <a
                                                                    data-toggle="collapse" data-parent="#accordion"
                                                                    href="#collapseTwo2" class="collapsed"
                                                                    aria-expanded="false">
                                                                    <span class="hrefmanito"
                                                                        onclick="abrirgaleria('imgmc0')"> Not Equalized
                                                                        AGC </span>
                                                                </a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapseTwo24" class="panel-collapse collapse">
                                                        <div class="card-body">
                                                            <div id="galley2">
                                                                <ul class="pictures">
                                                                    <?php
								  $vt=0;
									  foreach ($noteqagc as $rowd) 
											  {

												$pngtemp2 = "".trim($rowd)."";
											//	echo "acamarco:".$pngtemp;
												$cmd2 = $clientS3AWS->getCommand('GetObject', [
													'Bucket' => 'fpxwebfas',
													'Key'    => $pngtemp2
												]);

												//The period of availability
												$request2 = $clientS3AWS->createPresignedRequest($cmd2, '+20 minutes');

												//echo var_dump($request);
												//Get the pre-signed URL
												$signedUrl2 = (string) $request2->getUri();
												///echo "<br>a ver aqui:".$signedUrl;

												  if ($vt ==0)
													{
												  ?>
                                                                    <li>
                                                                        <img id="imgmc<?php echo $vt; ?>"
                                                                            name="imgmc<?php echo $vt; ?>"
                                                                            data-original="<?php echo $signedUrl2;?>"
                                                                            src="<?php echo $signedUrl2;?>" width="10%">

                                                                    </li>
                                                                    <?php
													}
													else
													{
														  ?>
                                                                    <li>
                                                                        <img data-original="<?php echo $signedUrl2;?>"
                                                                            src="<?php echo $signedUrl2;?>" width="10%"
                                                                            class="d-none">

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
                                                </div>

                                                <div class="divmarco">
                                                    <div class="">
                                                        <h4 class="textotabla10 ">

                                                            &nbsp;<span class="colornaranajafiplex"></a> <a
                                                                    data-toggle="collapse" data-parent="#accordion"
                                                                    href="#collapseThree2" class="collapsed"
                                                                    aria-expanded="false">
                                                                    <span class="hrefmanito"
                                                                        onclick="abrirgaleria('imgmd0')"> Equalized AGC
                                                                    </span>
                                                                </a>
                                                        </h4>
                                                    </div>
                                                    <div id="collapseThree25" class="panel-collapse collapse">
                                                        <div class="card-body">
                                                            <div id="galley3">
                                                                <ul class="pictures">
                                                                    <?php
								  $vt=0;
									  foreach ($eqagc as $rowd) 
											  {
												$pngtemp3 = "".trim($rowd)."";
											//	echo $pngtemp;
												$cmd3 = $clientS3AWS->getCommand('GetObject', [
													'Bucket' => 'fpxwebfas',
													'Key'    => $pngtemp2
												]);

												//The period of availability
												$request3 = $clientS3AWS->createPresignedRequest($cmd3, '+20 minutes');

												//echo var_dump($request);
												//Get the pre-signed URL
												$signedUrl3 = (string) $request3->getUri();

												  if ($vt ==0)
													{
												  ?>
                                                                    <li>
                                                                        <img id="imgmd<?php echo $vt; ?>"
                                                                            name="imgmd<?php echo $vt; ?>"
                                                                            data-original="<?php echo $signedUrl3;?>"
                                                                            src="<?php echo $signedUrl3;?>" width="10%">

                                                                    </li>
                                                                    <?php
													}
													else
													{
														  ?>
                                                                    <li>
                                                                        <img data-original="<?php echo $signedUrl3;?>"
                                                                            src="<?php echo $signedUrl3;?>" width="10%"
                                                                            class="d-none">

                                                                    </li>
                                                                    <?php
													}
												  $vt= $vt + 1;
												   if ($vt==11)
												  {
												//	  break;
												  }
												  
											
											  }
											?>

                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>


                                </section>



                                <section class="col-lg-12 connectedSortable ui-sortable">
                                    <div class="rowmm fondoblanco">
                                        <?php
			  $classciuisdba="d-none";
				 		if ($ciuisbda =="Y")
						 {
							$classciuisdba="";
							}  
						 
				   ?>
                                        <div class="col-md-3 <?php echo $classciuisdba;?>" id="divbarritas"
                                            name="divbarritas">


                                            <br>
                                            <h5 class=" colorazulfiplex text-center"> <strong> Factory
                                                    Parameters</strong></h5>


                                            <div class="progress-group">
                                                <b> Levels Offset</b>

                                                <input id="range_levelsoffset" type="text" name="range_levelsoffset"
                                                    value="" class="d-none" tabindex="-1" readonly="">



                                            </div>
                                            <!-- /.progress-group -->

                                            <div class="progress-group">
                                                <b> Squelch Offset</b>
                                                <input id="range_SquelchOffset" type="text" name="range_SquelchOffset"
                                                    value="" class="d-none" tabindex="-1" readonly=""
                                                    disabled="disabled">

                                            </div>

                                            <!-- /.progress-group -->
                                            <div class="progress-group">
                                                <span class="progress-text"><b>Gain Offset</b></span>
                                                <input id="range_GainOffset" type="text" name="range_GainOffset"
                                                    value="" class="d-none" tabindex="-1" readonly=""
                                                    disabled="disabled">

                                            </div>

                                            <!-- /.progress-group -->
                                            <div class="progress-group">
                                                <b> Max Pwr Offset</b>
                                                <input id="range_MaxPwroffset" type="text" name="range_MaxPwroffset"
                                                    value="" class="d-none" tabindex="-1" readonly=""
                                                    disabled="disabled">


                                            </div>


                                            <!-- /.progress-group -->
                                            <div class="progress-group">
                                                <b> Current consumption</b>
                                                <input id="range_currentlimit" type="text" name="range_currentlimit"
                                                    value="" class="d-none" tabindex="-1" readonly="">
                                            </div>

                                        </div>

                                        <!-- /.progress-group -->

                                        <div class="col-md-9">
                                            <br>
                                            <table
                                                class="table table-sm table-hover table-striped table-bordered text-center textotabla10">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th class="table-dark text-left">Parameters</th>
                                                        <th class="table-dark text-center">Freq - [MHz]</th>
                                                        <th class="table-dark text-center">Not Calibrated</th>
                                                        <th class="table-dark text-center">Calibrated</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class=" text-left"><b>Gain</b></td>
                                                        <td><?php echo round($Calibration_LSGP_Calibration_gain_freqshow,2); ?>
                                                        </td>
                                                        <td><?php echo round($Calibration_LSGP_Calibration_gain_gainnoagc,2); ?>
                                                        </td>
                                                        <td><?php echo round($Calibration_LSGP_Calibration_gain_gainagc,2); ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class=" text-left"><b>Max Pwr</b></td>
                                                        <td><?php echo round($Calibration_LSGP_Calibration_maxpwr_freq,2); ?>
                                                        </td>
                                                        <td><?php echo round($Calibration_LSGP_Calibration_maxpwr_pwrnoagc,2); ?>
                                                        </td>
                                                        <td><?php echo round($Calibration_LSGP_Calibration_maxpwr_pwragc,2); ?>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div id="galley4">
                                                <ul class="pictures">
                                                    <table
                                                        class="table table-sm table-hover table-striped table-bordered text-center textotabla10">
                                                        <tr>
                                                            <td>
                                                                <?php
								//Get a command to GetObject

										$pngtemp = "".trim($Calibration_LSGP_Calibration_gain_plot)."";
									//	echo "HOLA".$pngtemp;
									
										// Establish connection with DreamObjects with an S3 client.
										$cmd = $clientS3AWS->getCommand('GetObject', [

										'Bucket' => 'fpxwebfas',
										'Key'    => $pngtemp
										]);
									
										$request = $clientS3AWS->createPresignedRequest($cmd, '+20 minutes');									
										$signedUrl = (string) $request->getUri();
									///	echo "avermarco2:".$signedUrl;
								
								?>
                                                                <li> <img img src="<?php echo $signedUrl; ?>"
                                                                        width="390px" alt="Gain Not Calibrated">
                                                                    <span class="texto8 colorazulfiplex"> Gain Not
                                                                        Calibrated aa</span>
                                                                </li>
                                                            </td>

                                                            <td>
                                                                <?php
								//Get a command to GetObject

										$pngtemp2 = "".trim($Calibration_LSGP_Calibration_gain_plot_calib)."";
									//	echo "HOLA".$pngtemp2;
										// Establish connection with DreamObjects with an S3 client.
										$cmd = $clientS3AWS->getCommand('GetObject', [

										'Bucket' => 'fpxwebfas',
										'Key'    => $pngtemp2
										]);
									
										$request2 = $clientS3AWS->createPresignedRequest($cmd, '+20 minutes');									
										$signedUrl2 = (string) $request2->getUri();
									///	echo "avermarco2:".$signedUrl;
								
								?>
                                                                <li> <img img src="<?php echo $signedUrl2; ?>"
                                                                        width="390px" alt="Gain Calibrated ">
                                                                    <span class="texto6 colorazulfiplex"> Gain
                                                                        Calibrated </span>
                                                                </li>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <?php
								//Get a command to GetObject

										$pngtemp3 = "".trim($Calibration_LSGP_Calibration_maxpwr_plot)."";
									//	echo "HOLA".$pngtemp3;
										// Establish connection with DreamObjects with an S3 client.
										$cmd = $clientS3AWS->getCommand('GetObject', [

										'Bucket' => 'fpxwebfas',
										'Key'    => $pngtemp3
										]);
									
										$request3 = $clientS3AWS->createPresignedRequest($cmd, '+20 minutes');									
										$signedUrl3 = (string) $request3->getUri();
									///	echo "avermarco2:".$signedUrl;
								
								?>
                                                                <li> <img img src="<?php echo $signedUrl3; ?>"
                                                                        width="390px" alt="Max Pwr Not Calibrated">
                                                                    <span class="texto6 colorazulfiplex"> Max Pwr Not
                                                                        Calibrated </span>
                                                                </li>
                                                            </td>

                                                            <td>
                                                                <?php
								//Get a command to GetObject

										$pngtemp4 = "".trim($Calibration_LSGP_Calibration_maxpwr_plot_calib)."";
									//	echo "HOLA".$pngtemp4;
										// Establish connection with DreamObjects with an S3 client.
										$cmd = $clientS3AWS->getCommand('GetObject', [

										'Bucket' => 'fpxwebfas',
										'Key'    => $pngtemp4
										]);
									
										$request4 = $clientS3AWS->createPresignedRequest($cmd, '+20 minutes');									
										$signedUrl4 = (string) $request4->getUri();
									///	echo "avermarco2:".$signedUrl;
								
								?>
                                                                <li> <img img src="<?php echo $signedUrl4; ?>"
                                                                        width="390px" alt="Max Pwr Calibrated ">
                                                                    <span class="texto6 colorazulfiplex"> Max Pwr
                                                                        Calibrated </span>
                                                                </li>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </ul>
                                            </div>



                                        </div>

                                    </div>
                                </section>

                            </div>
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
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>

<script src="crypto-js.js"></script>
<!-- https://github.com/brix/crypto-js/releases crypto-js.js can be download from here -->

<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="toastr.min.js"></script>

<script src="licencefiplex_mm.js"></script>
<script src="licencefiplex1.js"></script>
<script src="js/jquery.inactivityTimeout.js"></script>
<script src="js/moment-timezone-with-data.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- Ion Slider -->
<script src="plugins/ion-rangeslider/js/ion.rangeSlider.min.js"></script>

<script type="text/javascript" src="js/tabulator.min.js"></script>
<script src="js/viewer.js"></script>


</body>

<script>
function makerzoommarquieto(imgruta) {
    // Get the modal
    var modal_zoom = document.getElementById("myModalzoom");

    // Get the image and insert it inside the modal - use its "alt" text as a caption
    var img = document.getElementById("myImg");
    var modalImg = document.getElementById("img01");
    var captionText = document.getElementById("caption");

    modal.style.display = "block";
    modalImg.src = imgruta;

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on <span> (x), close the modal

}

// Get the modal
var modal = document.getElementById("myModalzoom");

// Get the image and insert it inside the modal - use its "alt" text as a caption
var img = document.getElementById("myImg");
img.style.display = "none";
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
img.onclick = function() {
    modal.style.display = "block";
    modalImg.src = this.src;
    captionText.innerHTML = this.alt;
}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

$(document).on('keydown', function(e) {
    if (e.keyCode === 27) { // ESC
        modal.style.display = "none";
    }
});
</script>

<script type="text/javascript">
$(document).ready(function() {

    /*//Inicio mostrar hora live
		 var interval = setInterval(function() {
			 
        var momentNow = moment();
		var newYork    = momentNow.tz('America/New_York').format('ha z');
        $('#date-part').html(momentNow.format('YYYY/MM/DD') 	  );
        $('#time-part').html(momentNow.format('hh:mm:ss'));
		}, 100);
		//FIN mostrar hora live*/
    console.log("ready!");
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


// controlar inactividad en la web	
$(document).inactivityTimeout({
    inactivityWait: 10000,
    dialogWait: 10,
    logoutUrl: 'logout.php'
})
// fin controlar inactividad en la web		

/* ION SLIDER */




var limitminconsumo = <?php echo $v_currentminvalor; ?>;
var limitmaxconsumo = <?php echo $v_currentmaxvalor; ?>;
var consumomin = <?php if ($v_currentminmeasurerango =="") { echo "0";} else { echo $v_currentminmeasurerango; }  ?>;
var consumomax = <?php if ($v_currentmaxmeasurerango =="") { echo "0";} else { echo $v_currentmaxmeasurerango; } ?>;



var clas_levelsoffset = <?php echo "'".$v_Levels_Offset_class."'"; ?>;
var vmmincur_levelsoffset = <?php echo $v_Levels_Offset_min; ?>;
var vmaxcur_levelsoffset = <?php echo $v_Levels_Offset_max; ?>;



/* Current range_currentlimit */
$('#range_currentlimit').ionRangeSlider({
    type: "double",
    min: limitminconsumo,
    max: limitmaxconsumo,
    from: consumomin,
    to: consumomax,
    grid: true,
    grid_snap: false,
    from_fixed: true, // fix position of FROM handle
    to_fixed: true // fix position of TO handle
});

/* range_levelsoffset */
//alert(vmaxcur_levelsoffset);
$('#range_levelsoffset').ionRangeSlider({
    type: "double",
    min: -15,
    max: 15,
    from: vmmincur_levelsoffset,
    to: vmaxcur_levelsoffset,
    grid: true,
    grid_snap: true,
    from_fixed: true, // fix position of FROM handle
    to_fixed: true // fix position of TO handle
});



/* range_SquelchOffset */

var vmaxcur_range_SquelchOffsetmin = <?php echo $v_Squelch_Offset_min; ?>;
var vmaxcur_range_SquelchOffsetmax = <?php echo $v_Squelch_Offset_max; ?>;

$('#range_SquelchOffset').ionRangeSlider({
    type: "double",
    min: -15,
    max: 15,
    from: vmaxcur_range_SquelchOffsetmin,
    to: vmaxcur_range_SquelchOffsetmax,
    grid: true,
    grid_snap: true,
    from_fixed: true, // fix position of FROM handle
    to_fixed: true // fix position of TO handle
})



//range_GainOffset
var vmmincur_GainOffset = <?php echo $v_Gain_Offset_min; ?>;
var vmaxcur_GainOffset = <?php echo $v_Gain_Offset_max; ?>;

$('#range_GainOffset').ionRangeSlider({
    type: "double",
    min: -9,
    max: 9,
    from: vmmincur_GainOffset,
    to: vmaxcur_GainOffset,
    grid: true,
    grid_snap: true,
    from_fixed: true, // fix position of FROM handle
    to_fixed: true // fix position of TO handle
});

///range_MaxPwroffset
var vmmincur_MaxPwroffset = <?php echo $v_Max_Pwr_Offset_min; ?>;
var vmaxcur_MaxPwroffset = <?php echo $v_Max_Pwr_Offset_max; ?>;

$('#range_MaxPwroffset').ionRangeSlider({
    type: "double",
    min: -9,
    max: 9,
    from: vmmincur_MaxPwroffset,
    to: vmaxcur_MaxPwroffset,
    grid: true,
    grid_snap: true,
    from_fixed: true, // fix position of FROM handle
    to_fixed: true // fix position of TO handle
});


document.getElementById("divbarritas").disabled = true;

//	$('.irs-from').html("");
//	$('.irs-from').html("");

var cur_columns = document.getElementsByClassName('irs-from');
for (var i = 0; i < cur_columns.length; i++) {
    //	console.log(  cur_columns[i].attr("irs-from") );
    if (cur_columns[i].innerText == 0) {
        cur_columns[i].innerText = '';
        cur_columns[i].removeAttribute("class");
    }
}
var cur_columns2 = document.getElementsByClassName('irs-to');
for (var i = 0; i < cur_columns2.length; i++) {
    //	console.log(  cur_columns[i].attr("irs-from") );
    if (cur_columns2[i].innerText == 0) {
        cur_columns2[i].innerText = '';
        cur_columns2[i].removeAttribute("class");
    }
}


//	  $('#range_SquelchOffset').addClass(clas_levelsoffset);
/* requesting data */

//  var salesChartCanvas = $('#salesChart').get(0).getContext('2d');
var salesChartlevel = $('#salesChartlevel').get(0).getContext('2d');
var salesChartpowers = $('#salesChartpowers').get(0).getContext('2d');
var salesCharttxripple = $('#salesCharttxripple').get(0).getContext('2d');


var salesChartDatatotales = {
    labels: [<?php echo  $freqlabel;?>],
    datasets: [{
            label: 'Equalized',
            backgroundColor: 'rgba(60,141,188,0.3)',
            borderColor: 'rgba(60,141,188,1)',
            pointRadius: false,
            pointColor: '#3b8bba',
            pointStrokeColor: 'rgba(60,141,188,1)',
            pointHighlightFill: '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            data: [<?php echo  $graftotal1;?>]

        },
        {
            label: 'Not Equalized',
            backgroundColor: 'rgba(255, 99, 132, 0.5)',
            borderColor: 'rgba(255, 99, 132, 1)',
            pointRadius: false,
            pointColor: 'rgba(255, 99, 132, 1)',
            pointStrokeColor: '#c1c7d1',
            pointHighlightFill: '#fff',
            pointHighlightStroke: 'rgba(255, 99, 132, 1)',
            data: [<?php echo  $graftotal0;?>]
        },
    ]
};

var salesChartDatalevels = {
    labels: [<?php echo  $freqlabel;?>],
    datasets: [{
            label: 'Equalized',
            backgroundColor: 'rgba(60,141,188,0.3)',
            borderColor: 'rgba(60,141,188,1)',
            pointRadius: false,
            pointColor: '#3b8bba',
            pointStrokeColor: 'rgba(60,141,188,1)',
            pointHighlightFill: '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            data: [<?php echo  $graflevels1;?>]

        },
        {
            label: 'Not Equalized',
            backgroundColor: 'rgba(255, 99, 132, 0.5)',
            borderColor: 'rgba(255, 99, 132, 1)',
            pointRadius: false,
            pointColor: 'rgba(255, 99, 132, 1)',
            pointStrokeColor: '#c1c7d1',
            pointHighlightFill: '#fff',
            pointHighlightStroke: 'rgba(255, 99, 132, 1)',
            data: [<?php echo  $graflevels10;?>]
        },
    ]
};

var salesChartDatalpowees = {
    labels: [<?php echo  $freqlabel;?>],
    datasets: [{
            label: 'Equalized',
            backgroundColor: 'rgba(60,141,188,0.3)',
            borderColor: 'rgba(60,141,188,1)',
            pointRadius: false,
            pointColor: '#3b8bba',
            pointStrokeColor: 'rgba(60,141,188,1)',
            pointHighlightFill: '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            data: [<?php echo  $grafpower1;?>]

        },
        {
            label: 'Not Equalized',
            backgroundColor: 'rgba(255, 99, 132, 0.5)',
            borderColor: 'rgba(255, 99, 132, 1)',
            pointRadius: false,
            pointColor: 'rgba(255, 99, 132, 1)',
            pointStrokeColor: '#c1c7d1',
            pointHighlightFill: '#fff',
            pointHighlightStroke: 'rgba(255, 99, 132, 1)',
            data: [<?php echo  $grafpower0;?>]
        },
    ]
};


var salesChartOptions = {
    maintainAspectRatio: false,
    responsive: true,
    legend: {
        display: true
    },

    scales: {
        xAxes: [{
            gridLines: {
                display: true,
            }


        }],
        yAxes: [{
            gridLines: {
                display: true,

            }


        }]
    }
}

// This will get the first returned node in the jQuery collection.
/* var salesChart = new Chart(salesChartCanvas, { 
     type: 'line', 	
     data: salesChartData, 	 
     options: salesChartOptions
   });*/

var salesChart2 = new Chart(salesChartlevel, {
    type: 'line',
    data: salesChartDatalevels,
    options: salesChartOptions
});


var salesChart3 = new Chart(salesChartpowers, {
    type: 'line',
    data: salesChartDatalpowees,
    options: salesChartOptions
});

var salesChart4 = new Chart(salesCharttxripple, {
    type: 'line',
    data: salesChartDatatotales,
    options: salesChartOptions
});

window.addEventListener('DOMContentLoaded', function() {
    var galley = document.getElementById('galley');
    var viewer = new Viewer(galley, {
        url: 'data-original',
        title: function(image) {
            return image.alt + ' (' + (this.index + 1) + '/' + this.length + ')';
        },
    });
});

window.addEventListener('DOMContentLoaded', function() {
    var galley = document.getElementById('galley1');
    var viewer = new Viewer(galley, {
        url: 'data-original',
        title: function(image) {
            return image.alt + ' (' + (this.index + 1) + '/' + this.length + ')';
        },
    });
});
window.addEventListener('DOMContentLoaded', function() {
    var galley = document.getElementById('galley2');
    var viewer = new Viewer(galley, {
        url: 'data-original',
        title: function(image) {
            return image.alt + ' (' + (this.index + 1) + '/' + this.length + ')';
        },
    });
});
window.addEventListener('DOMContentLoaded', function() {
    var galley = document.getElementById('galley3');
    var viewer = new Viewer(galley, {
        url: 'data-original',
        title: function(image) {
            return image.alt + ' (' + (this.index + 1) + '/' + this.length + ')';
        },
    });
});

window.addEventListener('DOMContentLoaded', function() {
    var galley = document.getElementById('galley4');
    var viewer = new Viewer(galley, {
        url: 'data-original',
        title: function(image) {
            return image.alt + ' (' + (this.index + 1) + '/' + this.length + ')';
        },
    });
});

function abrirgaleria(qimgsendclick) {
    document.getElementById(qimgsendclick).click();
}



$('#cmbiditeracion').on('change', function() {
    //  alert( this.value );
    window.location = this.value;
})
</script>

</html>
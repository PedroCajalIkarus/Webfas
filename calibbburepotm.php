<!DOCTYPE html>
<?php 

// Desactivar toda notificación de error
//error_reporting(0);
// Notificar todos los errores de PHP (ver el registro de cambios)
//error_reporting(E_ALL);
 include("db_conectbypdf.php"); 
 
 	session_start();
	
	 
 require 'aws/aws-autoloader.php';
 require 'aws/fplmm.php';


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
	$vparam_vnrounitsn = $_REQUEST['unitsn']; ///// "20000000fu";	

?>
    <section class="content">
	
	 <div class="container-fluid"><br>
 	        <div class="row">
	
		 <section class="col-lg-12 connectedSortable ui-sortable">
		  <div class="rowmm fondoblanco">
				 
				 <div class="col-lg-12">

				  <!-- inicio cuadro resumen  --->
				  <?php
		
 

 
	$sql = $connect->prepare("select fas_outcome_integral.* , fasoutcometypename from fas_outcome_integral
	inner join fas_outcome_category_type
	on  fas_outcome_category_type.idfasoutcomecat	=	fas_outcome_integral.idfasoutcomecat and
		fas_outcome_category_type.idtype			=	fas_outcome_integral.idtype
	where fas_outcome_integral.reference in ( 
					select reference from fas_outcome_integral
					where datetimeref in (
										select max(datetimeref) from fas_outcome_integral
										where idfasoutcomecat = 0 AND idtype = 4 and v_string =  '".$vparam_vnrounitsn."' 
										 )
					and idfasoutcomecat = 0 AND idtype = 4 and v_string = '".$vparam_vnrounitsn."') ");

/// $sql->bindParam(':vvidsndib', $vparam_vnrounitsn);
$sql->execute();
$resultado3 = $sql->fetchAll();


$v_so="";
$_ciu="";
$_userfas="";
$_Fw_uC="";
$_Fw_fpga="";
$$_Fw_eth="";
$fas_version="";
$descriptionmm="";
foreach ($resultado3 as $row2) 
{
	////// SO : 2
	 if( $row2['idtype'] ==2)
	 {
		$v_so=$row2['v_string'];
	 }
	 ////// CIU:3
	 if( $row2['idtype'] ==3)
	 {
		$_ciu=$row2['v_string'];
	 }
	 ////// userFAS:16
	 if( $row2['idtype'] ==16)
	 {
		$_userfas=$row2['v_string'];
	 }
	 ////// FW uC:9
	 if( $row2['idtype'] ==9)
	 {
		$_Fw_uC=$row2['v_string'];
	 }
	  ////// FW EthuC:10
	  if( $row2['idtype'] ==10)
	  {
		 $_Fw_eth=$row2['v_string'];
	  }
	   ////// FW FPGA:8
	 if( $row2['idtype'] ==8)
	 {
		$_Fw_fpga=$row2['v_string'];
	 }
	 //////FasVersion: 7 
	 if( $row2['idtype'] ==7)
	 {
		$fas_version=$row2['v_string'];
	 }
	 // buscamos descripcion

	 $sqldsc = $connect->prepare("select * from fnt_select_allproducts_maxrev() where   modelciu = '".$_ciu."' ");
 
	 $descriptionmm="";
 	 $sqldsc->execute();
     $resultdescc = $sqldsc->fetchAll();
	 foreach ($resultdescc as $rowdesc) 
		{
			$descriptionmm=$rowdesc['description'];
		}
	 
 
}

?>


<table class="table table-sm table-hover table-striped table-bordered text-center textotabla10">
<tr>
<td class="table-dark text-center"> </td>
<td class="table-dark text-center"> </td>

</tr>
<tr>
<td style='text-align: left'>CIU: <strong><?php echo $_ciu;?></strong></td>
<td style='text-align: right'>SN: <strong><?php echo $vparam_vnrounitsn;?></strong></td>

</tr>
<tr>
<td colspan="2" style='text-align: left'>DESCRIPTION: <b>
<?php echo $descriptionmm ; ?></b>
</td>
</tr>

</table>

 

<table class="table table-sm table-hover table-striped table-bordered text-center textotabla10">
<tr>
<td style='width: 30%;text-align: left'>Calibrator: <strong><?php echo $_userfas;?></strong></td>
<td style='width: 30%;text-align: left'> </td>
<td style='width: 30%;text-align: right'>FAS Version: <strong><?php echo 	$fas_version;?></strong></td>

</tr>
 
	<tr>
<td colspan=3 style='text-align: left'>FW uC: <strong> <?php echo 	$_Fw_uC;?> </strong></td>
</tr>
 

</table>

						  <?php
						 
					//////////////////////////////////////////	 


						 ?>



<h5 style="text-decoration: underline;font-size:18px ">Parameters:</h5>
<table class="table table-sm table-hover table-striped table-bordered text-center textotabla10">
<tbody>

<tr>
<th style="text-align: left">Measures:</th>
<th style="text-align: center">Status</th>
 
<th style="text-align: left">Reference:</th>
 <th style="text-align: left">uC value readed</th>
</tr>
<tr>
<td style="text-align: left" >Power Source Voltage</td>

<?php
 //echo "aaaaaaaaaaaaaaaa";
 $elsql="select fas_outcome_category_type.fasoutcometypename, fas_tree_measure.iduniquebranch, fas_tree_measure.totalpass::int as totalpass,  fas_outcome_integral.*,fas_outcome_integral.reference, 
	  scriptname,description
	   from   fnt_select_allfas_routines_process_sn_maxrev('".$vparam_vnrounitsn."') as fas_routines_process_sn_t
		inner join fas_tree_measure
	  on fas_tree_measure.unitsn = fas_routines_process_sn_t.sn and
		 fas_tree_measure.idrununfo = fas_routines_process_sn_t.idruninfodb and
		 fas_tree_measure.iduniqueop = fas_routines_process_sn_t.iduniqueop
		inner join fas_script_type
	  on fas_script_type.idscripttype  = fas_routines_process_sn_t.idscript
	  inner join fas_step
	  on fas_step.idfasstep = fas_routines_process_sn_t.idstep
	  inner join fas_outcome_integral
	  on fas_outcome_integral.reference = fas_routines_process_sn_t.iduniqueop  and
		  fas_routines_process_sn_t.iduniqueop			= 	fas_outcome_integral.reference
	  inner join fas_outcome_category_type
	  on  fas_outcome_category_type.idfasoutcomecat	=	fas_outcome_integral.idfasoutcomecat and
		  fas_outcome_category_type.idtype			=	fas_outcome_integral.idtype
	  
	  inner join fnt_select_maxidrun_fas_outcome_integral('".$vparam_vnrounitsn."') as maxidrun
	  on maxidrun.reference =  fas_routines_process_sn_t.idruninfodb
	  where  fas_outcome_integral.idfasoutcomecat in(1,2,3,5) and fas_tree_measure.iduniquebranch in( '09B09F0AD', '09B09F0AE','09B09F0A0')
	 ";

		$sqlbbtt = $connect->prepare($elsql);

		//echo "bbbbbbbbbbbbbbbbbbbbbbbbbbbbbb".$elsql;

		  
		$vpower_source_voltage="";
		$vrefcurrent="";
		$vpower_source_voltage="";
		$vloadvoltage="";
		$vrefFIP485vol="";
		$vpower_source_voltage_totalapass="";

		$v_residualcurre_totalpass="";
		$v_residualcurre_ref="";
		$v_residualcurre_tole="";
		$v_residualcurre_fip485="";

		$vloadvolt_totalpass="";
		$vloadvolt_pwr="";
		$vloadvolt_ref="";
		$vloadvolt_reftole="";
		$vloadvolt__eloadvol="";
		$vloadvolt_fip485vol="";

		$sqlbbtt->execute();
		$resultbbu = $sqlbbtt->fetchAll();
		foreach ($resultbbu as $rowbbuacpt) 	 
		 {
		 
			/// $descriptionmm=$rowbbuacpt['description'];
			 /////////Reference Voltage -  Power Source Voltage - 09B09F0AD ////
			 
			
			 if ($rowbbuacpt['iduniquebranch'] =="09B09F0AD" && $rowbbuacpt['idfasoutcomecat'] == 1 && $rowbbuacpt['idtype'] == 0 )
			 {
			 
				$vpower_source_voltage_totalapass=$rowbbuacpt['totalpass'];
				 
				 
			 }
			
			 if ($rowbbuacpt['iduniquebranch'] =="09B09F0AD" && $rowbbuacpt['idfasoutcomecat'] == 2 && $rowbbuacpt['idtype'] == 0 )
			 {
				$vpower_source_voltage_ref=$rowbbuacpt['v_double'];
			 
				 
			 }
			 if ($rowbbuacpt['iduniquebranch'] =="09B09F0AD" && $rowbbuacpt['idfasoutcomecat'] == 2 && $rowbbuacpt['idtype'] == 1 )
			 {
				$vpower_source_voltage_ref2=$rowbbuacpt['v_double'];
			 }
			  ///////// FIP485 voltage - 09B09F0AD ////
			  if ($rowbbuacpt['iduniquebranch'] =="09B09F0AD" && $rowbbuacpt['idfasoutcomecat'] == 5 && $rowbbuacpt['idtype'] ==0 )
			  {
				$vrefFIP485vol=$rowbbuacpt['v_double'];
			 
			  }
			   ///////// ELOAD VOLTAGE - 09B09F0AD "Voltage Read"	"09B09F0AD" ////
			 if ($rowbbuacpt['iduniquebranch'] =="09B09F0AD" && $rowbbuacpt['idfasoutcomecat'] == 3 && $rowbbuacpt['idtype'] == 0 )
			 {
				$vloadvoltage=$rowbbuacpt['v_double'];
			 }

			 /////////////////////Residual Current :::Reference Current ::: 09B09F0AE ////////////////////////////////////
			 
			 if ($rowbbuacpt['iduniquebranch'] =="09B09F0AE" && $rowbbuacpt['idfasoutcomecat'] == 1 && $rowbbuacpt['idtype'] == 0 )
			 {
			 
				$v_residualcurre_totalpass=$rowbbuacpt['totalpass'];
			//	echo "".$v_residualcurre_totalpass;
			 }

			 if ($rowbbuacpt['iduniquebranch'] =="09B09F0AE" && $rowbbuacpt['idfasoutcomecat'] == 2 && $rowbbuacpt['idtype'] == 5 )
			 {
				$v_residualcurre_ref=$rowbbuacpt['v_double'];
			 
			//	echo "".$v_residualcurre_totalpass;
			 }
			 if ($rowbbuacpt['iduniquebranch'] =="09B09F0AE" && $rowbbuacpt['idfasoutcomecat'] == 2 && $rowbbuacpt['idtype'] == 1 )
			 {
				$v_residualcurre_tole=$rowbbuacpt['v_double'];
			 
			 }
			 if ($rowbbuacpt['iduniquebranch'] =="09B09F0AE" && $rowbbuacpt['idfasoutcomecat'] == 5 && $rowbbuacpt['idtype'] == 2 )
			 {
				$v_residualcurre_fip485=$rowbbuacpt['v_double'];
			 
			 }
			 ///////////////////////////////////////////////////////////

			///////////////////// Loaded Voltage :: "Reference Power"	"09B09F0A0"//////////////////////////////////////
			   ///////////////////////////////////////////////////////////
			   if ($rowbbuacpt['iduniquebranch'] =="09B09F0A0" && $rowbbuacpt['idfasoutcomecat'] == 1 && $rowbbuacpt['idtype'] == 0 )
			   {
			 
				$vloadvolt_totalpass=$rowbbuacpt['totalpass'];
				
			   
			   }
			   if ($rowbbuacpt['iduniquebranch'] =="09B09F0A0" && $rowbbuacpt['idfasoutcomecat'] == 2 && $rowbbuacpt['idtype'] == 10 )
			   {
				$vloadvolt_pwr=$rowbbuacpt['v_double'];
			 
				
			   
			   }
			   if ($rowbbuacpt['iduniquebranch'] =="09B09F0A0" && $rowbbuacpt['idfasoutcomecat'] == 2 && $rowbbuacpt['idtype'] == 0 )
			   {
				$vloadvolt_ref=$rowbbuacpt['v_double'];
			//	echo "sssssssssssssssssssss".$vloadvolt_ref;
			    
			   }
			   if ($rowbbuacpt['iduniquebranch'] =="09B09F0A0" && $rowbbuacpt['idfasoutcomecat'] == 2 && $rowbbuacpt['idtype'] == 1 )
			   {
				$vloadvolt_reftole =$rowbbuacpt['v_double'];
				 
			 
			   }
				if ($rowbbuacpt['iduniquebranch'] =="09B09F0A0" && $rowbbuacpt['idfasoutcomecat'] == 3 && $rowbbuacpt['idtype'] == 0 )
				{
					$vloadvolt_fip485vol=$rowbbuacpt['v_double'];
					
				}
			    ///////////////////////////////////////////////////////////
 
			
		 }
	  

?>
<td style="text-align: center"><?php if ( $vpower_source_voltage_totalapass ==1)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-green">Pass</span><?php
}
?></td>
 
<td style="text-align: left"><?php echo $vpower_source_voltage_ref; ?>27.25 V +/-  0.15 <?php echo $vpower_source_voltage_ref2; ?> V</td>
 
<td style="text-align: left"><?php echo $vrefFIP485vol;?>27.36 V</td>

</tr>


<tr>
<td style="text-align: left" >Residual Current</td>
<td style="text-align: center"><?php if ( $v_residualcurre_totalpass ==1)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-green">Pass</span><?php
}
?></td>
 
<td style="text-align: left"> <?php echo $v_residualcurre_ref; ?>0.0 A  +/- 0.15 <?php echo $v_residualcurre_tole; ?>  </td>
 
<td style="text-align: left">7.1<?php echo $v_residualcurre_fip485;?> mA</td>
</tr>

 

<tr>
<td style="text-align: left" >Loaded Voltage</td>
<td style="text-align: center"><?php if ( $vloadvolt_totalpass ==1)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-green">Pass</span><?php
}
?></td>
 
<td style="text-align: left"><?php echo $vloadvolt_ref; ?>28.8 V +/-  <?php echo $vloadvolt_reftole; ?>0.2 V</td>
 
<td style="text-align: left"><?php echo $vloadvolt_fip485vol;?>28.84 V</td>
</tr>
<tr>
	<td colspan=4><br></td>
</tr>
 
 
<tr>
<th colspan=4 style="text-align: left"><br>
<h5 style="text-decoration: underline;font-size:18px ">Alarms: </h5>
</th>
</tr>
<tr>
<th style="text-align: left">Reference:</th>
<th style="text-align: center">Status</th>
<th style="text-align: center">Forced On</th>
<th style="text-align: center">Forced Off</th>
</tr>

<?php
/*
select idruninfodb, fas_outcome_category_type.fasoutcometypename, fas_tree_measure.iduniquebranch, fas_tree_measure.totalpass::int as totalpass, fas_outcome_integral.*,fas_outcome_integral.reference, scriptname,description from fnt_select_allfas_routines_process_sn_maxrev('21114153FU') as fas_routines_process_sn_t inner join fas_tree_measure on fas_tree_measure.unitsn = fas_routines_process_sn_t.sn and fas_tree_measure.idrununfo = fas_routines_process_sn_t.idruninfodb and fas_tree_measure.iduniqueop = fas_routines_process_sn_t.iduniqueop inner join fas_script_type on fas_script_type.idscripttype = fas_routines_process_sn_t.idscript inner join fas_step on fas_step.idfasstep = fas_routines_process_sn_t.idstep inner join fas_outcome_integral on fas_outcome_integral.reference = fas_routines_process_sn_t.iduniqueop and fas_routines_process_sn_t.iduniqueop = fas_outcome_integral.reference inner join fas_outcome_category_type on fas_outcome_category_type.idfasoutcomecat = fas_outcome_integral.idfasoutcomecat and fas_outcome_category_type.idtype = fas_outcome_integral.idtype inner join fnt_select_maxidrun_fas_outcome_integral('21114153FU') as maxidrun on maxidrun.reference = fas_routines_process_sn_t.idruninfodb
where 
   fas_tree_measure.iduniqueop in( '10702001276','10702001277' ) and fas_outcome_integral.idfasoutcomecat = 5
   */
 	
	/*
	09B09F0A10A2  General Failure Alarm On
	09B09F0A10AF  General Failure Alarm Off - 10702001277 - recordaer q es el valor q tiene la alarma
	*/
	$elsql2="select fas_outcome_integral.idfasoutcomecat , fas_outcome_integral.idtype, idruninfodb, fas_outcome_category_type.fasoutcometypename, fas_outcome_integral.v_boolean::integer as v_booleanint, fas_tree_measure.iduniquebranch, fas_tree_measure.totalpass::int as totalpass, 
	 fas_outcome_integral.reference, scriptname,description 
	from fnt_select_allfas_routines_process_sn_maxrev('".$vparam_vnrounitsn."') as fas_routines_process_sn_t 
	inner join fas_tree_measure on fas_tree_measure.unitsn = fas_routines_process_sn_t.sn and fas_tree_measure.idrununfo = fas_routines_process_sn_t.idruninfodb and 
	fas_tree_measure.iduniqueop = fas_routines_process_sn_t.iduniqueop 
	inner join fas_script_type on fas_script_type.idscripttype = fas_routines_process_sn_t.idscript 
	inner join fas_step on fas_step.idfasstep = fas_routines_process_sn_t.idstep 
	inner join fas_outcome_integral on fas_outcome_integral.reference = fas_routines_process_sn_t.iduniqueop and 
	fas_routines_process_sn_t.iduniqueop = fas_outcome_integral.reference 
	inner join fas_outcome_category_type on fas_outcome_category_type.idfasoutcomecat = fas_outcome_integral.idfasoutcomecat and 
	fas_outcome_category_type.idtype = fas_outcome_integral.idtype inner join fnt_select_maxidrun_fas_outcome_integral('".$vparam_vnrounitsn."') as maxidrun on maxidrun.reference = fas_routines_process_sn_t.idruninfodb
	where 
	fas_tree_measure.iduniquebranch in( '09B09F0A10A2','09B09F0A10AF','09B09F0A10A5','09B09F0A10B0','09B09F0A10A6','09B09F0A10B1','09B09F0A10A7','09B09F0A10B2','09B09F0A10A6','09B09F0A10B1','09B09F0A10B0','09B09F0A10A5') and fas_outcome_integral.idfasoutcomecat in(2,5,8)";
	//   echo $elsql2;
	$sqlbbttalamr = $connect->prepare($elsql2);

		//echo "bbbbbbbbbbbbbbbbbbbbbbbbbbbbbb".$elsql;
		$v_General_Failure_alarm_state = "";
		$v_General_Failure_alarm_off = "";
		$v_General_Failure_alarm_on = "";

		$v_donnor_ant_disc_alarm_on="";
		$v_donnor_ant_disc_alarm_off="";

		$v_donnor_ant_malfunc_alarm_on="";
		$v_donnor_ant_malfunc_alarm_off="";

		$v_vswr_alarm_on="";
		$v_vswr_alarm_off="";

		$v_system_comp_fail_alarm_off="";
		$v_system_comp_fail_alarm_on="";

		$v_rf_emitter_fail_led_Off="";
		$v_rf_emitter_fail_led_ON="";

		$v_system_comp_fail_led_Off="";
		$v_system_comp_fail_led_On="";

		$v_batt_capacityunder_led_On =""; 
		$v_batt_capacityunder_led_Off="";


		$sqlbbttalamr->execute();
		$result_alarm = $sqlbbttalamr->fetchAll();
		foreach ($result_alarm as $row_alarm) 	 
		 {
			/////// 09B09F0A10A2  General Failure Alarm On
			if ($row_alarm['iduniquebranch'] =="09B09F0A10A2" && $row_alarm['idfasoutcomecat'] == 5 && $row_alarm['idtype'] == 3 )
			{
				$v_General_Failure_alarm_on=$row_alarm['v_booleanint'];
			 
			}
			/////// 09B09F0A10AF  General Failure Alarm On
			if ($rowbrow_alarmbuacpt['iduniquebranch'] =="09B09F0A10AF" && $row_alarm['idfasoutcomecat'] == 5 && $row_alarm['idtype'] == 3 )
			{
				$v_General_Failure_alarm_off=$row_alarm['v_booleanint'];
				
			}

				/////// 09B09F0A10A2  Donor Antenna Disconnection Alarm ON
				if ($row_alarm['iduniquebranch'] =="09B09F0A10A2" && $row_alarm['idfasoutcomecat'] == 5 && $row_alarm['idtype'] == 4 )
				{
					$v_donnor_ant_disc_alarm_on=$row_alarm['v_booleanint'];
				 
				}
				/////// 09B09F0A10AF  Donor Antenna Disconnection Alarm
				if ($rowbrow_alarmbuacpt['iduniquebranch'] =="09B09F0A10AF" && $row_alarm['idfasoutcomecat'] == 5 && $row_alarm['idtype'] == 4 )
				{
					$v_donnor_ant_disc_alarm_off=$row_alarm['v_booleanint'];
					
				}

				

					/////// 09B09F0A10A2  Donor Antenna Malfunction Alarm ON
					if ($row_alarm['iduniquebranch'] =="09B09F0A10A2" && $row_alarm['idfasoutcomecat'] == 5 && $row_alarm['idtype'] == 5 )
					{
						$v_donnor_ant_malfunc_alarm_on=$row_alarm['v_booleanint'];
					 
					}
					/////// 09B09F0A10AF  Donor Antenna Malfunction Alarm off
					if ($rowbrow_alarmbuacpt['iduniquebranch'] =="09B09F0A10AF" && $row_alarm['idfasoutcomecat'] == 5 && $row_alarm['idtype'] == 5 )
					{
						$v_donnor_ant_malfunc_alarm_off=$row_alarm['v_booleanint'];
						
					}

					

						/////// 09B09F0A10A2 VSWR Alarm ON
						if ($row_alarm['iduniquebranch'] =="09B09F0A10A2" && $row_alarm['idfasoutcomecat'] == 5 && $row_alarm['idtype'] == 6 )
						{
							$v_vswr_alarm_on=$row_alarm['v_booleanint'];
						 
						}
						/////// 09B09F0A10AF VSWR Alarm off
						if ($rowbrow_alarmbuacpt['iduniquebranch'] =="09B09F0A10AF" && $row_alarm['idfasoutcomecat'] == 5 && $row_alarm['idtype'] == 6 )
						{
							$v_vswr_alarm_off=$row_alarm['v_booleanint'];
							
						}
 

							/////// 09B09F0A10A5 ::::  System Components Fail Alarm ON Check  2,8 System Components Fail Alarm	ON
							if ($row_alarm['iduniquebranch'] =="09B09F0A10A5" && $row_alarm['idfasoutcomecat'] == 2 && $row_alarm['idtype'] == 8 )
							{
								$v_system_comp_fail_alarm_on=$row_alarm['v_booleanint'];
							 
							}
							/////// 09B09F0A10B0 ::  System Components Fail Alarm OFF Check Reference Alarm  2,8 Battery Capacity Alarm 
							if ($rowbrow_alarmbuacpt['iduniquebranch'] =="09B09F0A10B0" && $row_alarm['idfasoutcomecat'] == 2 && $row_alarm['idtype'] == 8 )
							{
								$v_system_comp_fail_alarm_off=$row_alarm['v_booleanint'];
								
							}

							/////// 09B09F0A10A5 ::::  Battery Capacity Alarm ON Check  2,8 System Components Fail Alarm	ON
							if ($row_alarm['iduniquebranch'] =="09B09F0A10A6" && $row_alarm['idfasoutcomecat'] == 2 && $row_alarm['idtype'] == 8 )
							{
								$v_batt_capacit_alarm_on=$row_alarm['v_booleanint'];
							 
							}
							/////// 09B09F0A10B0 ::  Battery Capacity Alarm OFF Check  Reference Alarm  2,8 Battery Capacity Alarm 
							if ($row_alarm['iduniquebranch'] =="09B09F0A10B1" && $row_alarm['idfasoutcomecat'] == 2 && $row_alarm['idtype'] == 8 )
							{
								$v_batt_capacit_alarm_off=$row_alarm['v_booleanint'];
								
							}
							
							//////////////09B09F0A10A7 Starting Fire Panel Alarms ON Check -  RF Emitter Fail Led 8 ,13
							if ($row_alarm['iduniquebranch'] =="09B09F0A10A7" && $row_alarm['idfasoutcomecat'] == 8 && $row_alarm['idtype'] == 13 )
							{
								$v_rf_emitter_fail_led_ON=$row_alarm['v_booleanint'];
							 
								
							}
							//////////////09B09F0A10B2 Starting Fire Panel Alarms OFF Check -  RF Emitter Fail Led 8 ,13
							if ($row_alarm['iduniquebranch'] =="09B09F0A10B2" && $row_alarm['idfasoutcomecat'] == 8 && $row_alarm['idtype'] == 13 )
							{
								$v_rf_emitter_fail_led_Off=$row_alarm['v_booleanint'];
								
							}

								//////////////09B09F0A10A7 Starting Fire Panel Alarms ON Check -  Donor Antenna Disconnection Led 8 ,14
								if ($row_alarm['iduniquebranch'] =="09B09F0A10A7" && $row_alarm['idfasoutcomecat'] == 8 && $row_alarm['idtype'] == 14 )
								{
									$v_donnor_ant_disconect_led_ON=$row_alarm['v_booleanint'];
									
								}
								//////////////09B09F0A10B2 Starting Fire Panel Alarms OFF Check - Donor Antenna Disconnection Led Led 8 ,14
								if ($row_alarm['iduniquebranch'] =="09B09F0A10B2" && $row_alarm['idfasoutcomecat'] == 8 && $row_alarm['idtype'] == 14 )
								{
									$v_donnor_ant_disconect_led_Off=$row_alarm['v_booleanint'];
									
								}
								
								//////////////09B09F0A10A7 Starting Fire Panel Alarms ON Check - Donor Antenna Malfunction Led Led 8 ,15
								if ($row_alarm['iduniquebranch'] =="09B09F0A10A7" && $row_alarm['idfasoutcomecat'] == 8 && $row_alarm['idtype'] == 15 )
								{
									$v_donnor_ant_malfunction_led_ON=$row_alarm['v_booleanint'];
									
								} 
								//////////////09B09F0A10B2 Starting Fire Panel Alarms OFF Check - Donor Antenna Malfunction Led Led Led 8 ,15
								if ($row_alarm['iduniquebranch'] =="09B09F0A10B2" && $row_alarm['idfasoutcomecat'] == 8 && $row_alarm['idtype'] == 15 )
								{
									$v_donnor_ant_malfunction_led_Off=$row_alarm['v_booleanint'];
									
								}

								////////// 09B09F0A10A5 System Component Fail ON led state 8 -16
								if ($row_alarm['iduniquebranch'] =="09B09F0A10A5" && $row_alarm['idfasoutcomecat'] == 8 && $row_alarm['idtype'] == 16 )
								{
									$v_system_comp_fail_led_On=$row_alarm['v_booleanint'];
									
								}
									////////// 09B09F0A10B0 System Component Fail OFF led state 8 -16
									if ($row_alarm['iduniquebranch'] =="09B09F0A10B0" && $row_alarm['idfasoutcomecat'] == 8 && $row_alarm['idtype'] == 16 )
									{
										$v_system_comp_fail_led_Off=$row_alarm['v_booleanint'];
										
									}
							
								 
							 
									////////// 09B09F0A10A6 Battery Capacity Under  ON led state 8 -16
									if ($row_alarm['iduniquebranch'] =="09B09F0A10A6" && $row_alarm['idfasoutcomecat'] == 8 && $row_alarm['idtype'] == 17 )
									{
										$v_batt_capacityunder_led_On=$row_alarm['v_booleanint'];
										
									}
										////////// 09B09F0A10B1 Battery Capacity Under  OFF led state 8 -16
										if ($row_alarm['iduniquebranch'] =="09B09F0A10B1" && $row_alarm['idfasoutcomecat'] == 8 && $row_alarm['idtype'] == 17 )
										{
											$v_batt_capacityunder_led_Off=$row_alarm['v_booleanint'];
											
										}


		 }

?>
 
<tr>
<td style="text-align: left">General Failure alarm state</td>
<td style="text-align: center"> <?php  

if ( $v_General_Failure_alarm_on ==1 &&  $v_General_Failure_alarm_off ==0)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-green">Pass</span><?php
}
?>
</td>
<td style="text-align: center"> 
<?php  

if ( $v_General_Failure_alarm_on ==1)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-green">Pass</span><?php
}
?>

</td>
<td style="text-align: center">
<?php if ( $v_General_Failure_alarm_off ==0)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-green">Pass</span><?php
}
?>
</td>
</tr>
<tr>
<td style="text-align: left">Donor Antenna Disconnection alarm state</td>
<td style="text-align: center"> 
<?php  

if ( $v_donnor_ant_disc_alarm_on ==1 &&  $v_donnor_ant_malfunc_alarm_off ==0)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-green">Pass</span><?php
}
?>
</td>
<td style="text-align: center"> <?php  

if ( $v_donnor_ant_disc_alarm_on ==1)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-green">Pass</span><?php
}
?>
</td>
<td style="text-align: center"> 
<?php  

if ( $v_donnor_ant_disc_alarm_off ==0)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-green">Pass</span><?php
}
?>
</td>
</tr>
<tr>
<td style="text-align: left">Donor Antenna Malfunction alarm state</td>
<td style="text-align: center">

<?php  

if ( $v_donnor_ant_malfunc_alarm_on ==1 &&  $v_donnor_ant_malfunc_alarm_off ==0)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-green">Pass</span><?php
}
?>
</td>
<td style="text-align: center">

<?php  

if ( $v_donnor_ant_malfunc_alarm_on ==1)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-green">Pass</span><?php
}
?>
</td>
<td style="text-align: center"> 

<?php  

if ( $v_donnor_ant_malfunc_alarm_off ==0)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-green">Pass</span><?php
}
?>
</td>
</tr>
<tr>
<td style="text-align: left">VSWR alarm state</td>
<td style="text-align: center">
<?php  

if ( $v_vswr_alarm_on ==1 &&  $v_vswr_alarm_off ==0)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-green">Pass</span><?php
}
?>
</td>
<td style="text-align: center"> 
<?php  

if ( $v_vswr_alarm_on ==1)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-green">Pass</span><?php
}
?>
</td>
<td style="text-align: center"> 
<?php  

if ( $v_vswr_alarm_off ==0)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-green">Pass</span><?php
}
?>
</td>
</tr>

<tr>
<td style="text-align: left">System Components Fail Alarm </td>
<td style="text-align: center">
<?php  

if ( $v_system_comp_fail_alarm_on ==1 &&  $v_system_comp_fail_alarm_off ==0)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-green">Pass</span><?php
}
?>
</td>
<td style="text-align: center"> 
<?php  

if ( $v_system_comp_fail_alarm_on ==1)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-green">Pass</span><?php
}
?>
</td>
<td style="text-align: center"> 
<?php  

if ( $v_system_comp_fail_alarm_off ==0)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-green">Pass</span><?php
}
?>
</td>
</tr>

<tr>
<td style="text-align: left">Battery Capacity Alarm</td>
<td style="text-align: center">
<?php  

if ( $v_batt_capacit_alarm_on ==1 &&  $v_batt_capacit_alarm_off ==0)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-green">Pass</span><?php
}
?>
</td>
<td style="text-align: center"> 
<?php  

if ( $v_batt_capacit_alarm_on ==1)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-green">Pass</span><?php
}
?>
</td>
<td style="text-align: center"> 
<?php  

if ( $v_batt_capacit_alarm_off ==0)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-green">Pass</span><?php
}
?>
</td>
</tr>
 
<tr>
	<td colspan=4><br></td>
</tr>
<tr>
	<td colspan=4><br></td>
</tr>
 
 
<tr>
<th colspan=4 style="text-align: left">
<h5 style="text-decoration: underline;font-size:18px "><br>Leds: </h5>
</th>
</tr>
<tr>
<th style="text-align: left">Reference:</th>
<th style="text-align: center">Status</th>
<th style="text-align: center">Forced On</th>
<th style="text-align: center">Forced Off</th>
</tr>
         
<tr>
<td style="text-align: left">RF Emitter Fail </td>
<td style="text-align: center">
<?php  

if ( $v_rf_emitter_fail_led_ON ==1 &&  $v_rf_emitter_fail_led_Off ==0)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-green">Pass</span><?php
}
?>
</td>
<td style="text-align: center"> 
<?php  

if ( $v_rf_emitter_fail_led_ON ==1)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-green">Pass</span><?php
}
?>
</td>
<td style="text-align: center"> 
<?php  

if ( $v_rf_emitter_fail_led_Off ==0)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-green">Pass</span><?php
}
 
?>
</td>
</tr>
<tr>
<td style="text-align: left">Donor Antenna Disconnection </td>
<td style="text-align: center">
<?php  

if ( $v_donnor_ant_disconect_led_ON ==1 &&  $v_donnor_ant_disconect_led_Off ==0)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-green">Pass</span><?php
}
?>
</td>
<td style="text-align: center"> 
<?php  

if ( $v_donnor_ant_disconect_led_ON ==1)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-green">Pass</span><?php
}
?>
</td>
<td style="text-align: center"> 
<?php  

if ( $v_donnor_ant_disconect_led_Off ==0)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-green">Pass</span><?php
}
/*
v_donnor_ant_disconect_led_ON
								v_donnor_ant_malfunction_led_Off
								*/
?>
</td>
</tr>

<tr>
<td style="text-align: left">Donor Antenna Malfunction </td>
<td style="text-align: center">
<?php  

if ( $v_donnor_ant_malfunction_led_ON ==1 &&  $v_donnor_ant_malfunction_led_Off ==0)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-green">Pass</span><?php
}
?>
</td>
<td style="text-align: center"> 
<?php  

if ( $v_donnor_ant_malfunction_led_ON ==1)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-green">Pass</span><?php
}
?>
</td>
<td style="text-align: center"> 
<?php  

if ( $v_donnor_ant_malfunction_led_Off ==0)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-green">Pass</span><?php
}
/*
	$v_system_comp_fail_led_Off="";
								$v_system_comp_fail_led_On="";
								
								*/
?>
</td>
</tr>

<tr>
<td style="text-align: left">System Component Fail </td>
<td style="text-align: center">
<?php  

if ( $v_system_comp_fail_led_On ==1 &&  $v_system_comp_fail_led_Off ==0)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-green">Pass</span><?php
}
?>
</td>
<td style="text-align: center"> 
<?php  

if ( $v_system_comp_fail_led_On ==1)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-green">Pass</span><?php
}
?>
</td>
<td style="text-align: center"> 
<?php  

if ( $v_system_comp_fail_led_Off ==0)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-green">Pass</span><?php
}
/*
 
								
								*/
?>
</td>
</tr>

<tr>
<td style="text-align: left">Battery Capacity Under 30%</td>
<td style="text-align: center">
<?php  

if ( $v_batt_capacityunder_led_On ==1 &&  $v_batt_capacityunder_led_Off ==0)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-green">Pass</span><?php
}
?>
</td>
<td style="text-align: center"> 
<?php  

if ( $v_batt_capacityunder_led_On ==1)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-green">Pass</span><?php
}
?>
</td>
<td style="text-align: center"> 
<?php  

if ( $v_batt_capacityunder_led_Off ==0)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-green">Pass</span><?php
}
/*
 
								
								*/
?>
</td>
</tr>
</table>
			
			 </div> 
			 <br><br><br><br><br>

        </section>

		
		 
		
					
          <!-- /.col -->
        		<br><br>
		
      </div>
      <!-- /.timeline -->
  </div>
    </section>
    <!-- /.content -->
	<br><br>
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
	



</script>

</html>

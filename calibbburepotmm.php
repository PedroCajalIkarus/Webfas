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
	$idruninfomreq = $_REQUEST['idrun']; ///// "20000000fu";	

?>
    <section class="content">
	
	 <div class="container-fluid"><br>
 	        <div class="row">
	
		 <section class="col-lg-12 connectedSortable ui-sortable">
		  <div class="rowmm fondoblanco">
				 
				 <div class="col-lg-12">

				  <!-- inicio cuadro resumen  --->
				  <?php
		
  

 
	/*$sql = $connect->prepare("select fas_outcome_integral.* , fasoutcometypename from fas_outcome_integral
	inner join fas_outcome_category_type
	on  fas_outcome_category_type.idfasoutcomecat	=	fas_outcome_integral.idfasoutcomecat and
		fas_outcome_category_type.idtype			=	fas_outcome_integral.idtype
	where fas_outcome_integral.reference in ( 
					select reference from fas_outcome_integral
					where datetimeref in (
										select max(datetimeref) from fas_outcome_integral
										where idfasoutcomecat = 0 AND idtype = 4 and v_string =  '".$vparam_vnrounitsn."' 
										 )
					and idfasoutcomecat = 0 AND idtype = 4 and v_string = '".$vparam_vnrounitsn."') ");*/

					$sql = $connect->prepare("select fas_outcome_integral.* , fasoutcometypename from fas_outcome_integral
					inner join fas_outcome_category_type
					on  fas_outcome_category_type.idfasoutcomecat	=	fas_outcome_integral.idfasoutcomecat and
						fas_outcome_category_type.idtype			=	fas_outcome_integral.idtype
					where fas_outcome_integral.reference in ( 
						select reference from fnt_select_maxidrun_fas_outcome_integral_byidscrip('".$vparam_vnrounitsn."',22) 
 							)
								 ");

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
	$idruninfom = $row2['reference'];
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
			$idbusineesdelproducto=$rowdesc['idbusiness'];

			
			
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
<td  style='text-align: left'>FW uC: <strong> <?php echo 	$_Fw_uC;?> </strong></td>
<td style='width: 30%;text-align: left'> </td>
<td style='width: 30%;text-align: right'>RunInfo# <strong><?php if ($idruninfomreq=="") { 
	echo $idruninfom;
} else {
	echo $idruninfomreq;

} ?></strong></td>

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
// echo "aaaaaaaaaaaaaaaa";
$idruninfomreq = $_REQUEST['idrun']; ///// "20000000fu";	
//echo $idruninfomreq."<br>";

if ($idruninfomreq=="")
{
	$elsql="
	select  fas_outcome_category_type.fasoutcometypename, fas_routines_steps.instance as iduniquebranch, fas_integral_totalpass.v_boolean::int as totalpass, 
fas_outcome_integral.*,fas_outcome_integral.reference, scriptname 

from fnt_select_allfas_routines_process_sn_maxrev_byscript('".$vparam_vnrounitsn."',22) as fas_routines_process_sn_t
 
inner join fas_script_type on fas_script_type.idscripttype = fas_routines_process_sn_t.idscript 
inner join fas_routines_steps on fas_routines_steps.idstep = fas_routines_process_sn_t.idstep 
inner join fas_outcome_integral on fas_outcome_integral.reference = fas_routines_process_sn_t.iduniqueop and 
fas_routines_process_sn_t.iduniqueop = fas_outcome_integral.reference 

inner join fas_outcome_integral as fas_integral_totalpass 
on fas_outcome_integral.reference = fas_integral_totalpass.reference and
    fas_integral_totalpass.idfasoutcomecat=1 and
    fas_integral_totalpass.idtype =0 and
	fas_integral_totalpass.v_boolean is not null

inner join fas_outcome_category_type on fas_outcome_category_type.idfasoutcomecat = fas_outcome_integral.idfasoutcomecat and 
fas_outcome_category_type.idtype = fas_outcome_integral.idtype
inner join fnt_select_maxidrun_fas_outcome_integral_byidscrip('".$vparam_vnrounitsn."',22) as maxidrun on maxidrun.reference = fas_routines_process_sn_t.idruninfodb

where fas_outcome_integral.idfasoutcomecat in(1,2,3,5) 
and fas_routines_steps.instance in( '09B09F0AD', '09B09F0AE','09B09F0A0','09B09F0BA','0DC')
   ";
}
else
{
	$elsql="
	select  fas_outcome_category_type.fasoutcometypename, fas_routines_steps.instance as iduniquebranch, fas_integral_totalpass.v_boolean::int as totalpass, 
fas_outcome_integral.*,fas_outcome_integral.reference, scriptname 

from   fnt_select_allfas_routines_process_sn_maxrev_byscript_byidrun('".$vparam_vnrounitsn."',22,".$idruninfomreq.") as fas_routines_process_sn_t
 
inner join fas_script_type on fas_script_type.idscripttype = fas_routines_process_sn_t.idscript 
inner join fas_routines_steps on fas_routines_steps.idstep = fas_routines_process_sn_t.idstep 
inner join fas_outcome_integral on fas_outcome_integral.reference = fas_routines_process_sn_t.iduniqueop and 
fas_routines_process_sn_t.iduniqueop = fas_outcome_integral.reference 

inner join fas_outcome_integral as fas_integral_totalpass 
on fas_outcome_integral.reference = fas_integral_totalpass.reference and
    fas_integral_totalpass.idfasoutcomecat=1 and
    fas_integral_totalpass.idtype =0 and
	fas_integral_totalpass.v_boolean is not null

inner join fas_outcome_category_type on fas_outcome_category_type.idfasoutcomecat = fas_outcome_integral.idfasoutcomecat and 
fas_outcome_category_type.idtype = fas_outcome_integral.idtype
inner join fnt_select_maxidrun_fas_outcome_integral_byidscrip_byidrun('".$vparam_vnrounitsn."',22,".$idruninfomreq.") as maxidrun on maxidrun.reference = fas_routines_process_sn_t.idruninfodb

where fas_outcome_integral.idfasoutcomecat in(1,2,3,5) 
and fas_routines_steps.instance in( '09B09F0AD', '09B09F0AE','09B09F0A0','09B09F0BA','0DC')
   ";
}



	 
	// echo "bbbbbbbbbbbbbbbbbbbbbbbbbbbbbb".$elsql."<br><br>";

		$sqlbbtt = $connect->prepare($elsql);

	



		  
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

//		echo "<br>Cant:".count($resultbbu );
		if ( count($resultbbu ) == 0)
		{
			echo "Missing information";
			exit();
		}
		foreach ($resultbbu as $rowbbuacpt) 	 
		 {
		 
			/// $descriptionmm=$rowbbuacpt['description'];
			 /////////Reference Voltage -  Power Source Voltage - 09B09F0AD ////
			 
			 /////////////////// INIT ALARM
			 if ($rowbbuacpt['iduniquebranch'] =="0DC" && $rowbbuacpt['idfasoutcomecat'] == 2 && $rowbbuacpt['idtype'] == 31 )
			 {
				$temp_board_reference2_31=$rowbbuacpt['v_integer'];
				$v_have_temp_sensor = "Y";
			 }
			 if ($rowbbuacpt['iduniquebranch'] =="0DC" && $rowbbuacpt['idfasoutcomecat'] == 2 && $rowbbuacpt['idtype'] == 15 )
			 {
				$temp_board_reference2_15=$rowbbuacpt['v_integer'];
			 }
			 if ($rowbbuacpt['iduniquebranch'] =="0DC" && $rowbbuacpt['idfasoutcomecat'] == 5 && $rowbbuacpt['idtype'] == 11 )
			 {
				$temp_board_uc5_11=$rowbbuacpt['v_integer'];
			 }
			 if ($rowbbuacpt['iduniquebranch'] =="0DC" && $rowbbuacpt['idfasoutcomecat'] == 2 && $rowbbuacpt['idtype'] == 1 )
			 {
				$extern_temp_2_1=$rowbbuacpt['v_integer'];
			 }
			 if ($rowbbuacpt['iduniquebranch'] =="0DC" && $rowbbuacpt['idfasoutcomecat'] == 5 && $rowbbuacpt['idtype'] == 36 )
			 {
				$extern_temp_5_36=$rowbbuacpt['v_integer'];
			 }
			 if ($rowbbuacpt['iduniquebranch'] =="0DC" && $rowbbuacpt['idfasoutcomecat'] == 5 && $rowbbuacpt['idtype'] == 34 )
			 {
				$System_high_temp_alarm_5_34=$rowbbuacpt['v_integer'];
			 }
			 if ($rowbbuacpt['iduniquebranch'] =="0DC" && $rowbbuacpt['idfasoutcomecat'] == 5 && $rowbbuacpt['idtype'] == 35 )
			 {
				$System_high_temp_alarm_5_35=$rowbbuacpt['v_integer'];
			 }
			 if ($rowbbuacpt['iduniquebranch'] =="0DC" && $rowbbuacpt['idfasoutcomecat'] == 1 && $rowbbuacpt['idtype'] ==  0 )
			 {
				$board_external_temp_totalpass=$rowbbuacpt['totalpass'];
			 }

			 if ($rowbbuacpt['iduniquebranch'] =="0DC" && $rowbbuacpt['idfasoutcomecat'] == 5 && $rowbbuacpt['idtype'] ==  34)
			 {
				$v_syshigh_tempalarm_on=$rowbbuacpt['totalpass'];
			 }

			 if ($rowbbuacpt['iduniquebranch'] =="0DC" && $rowbbuacpt['idfasoutcomecat'] == 5 && $rowbbuacpt['idtype'] ==  35 )
			 {
				$v_syshigh_tempalarm_off=$rowbbuacpt['totalpass'];
			 }


		 

			 /////////////////// END  ALARM

			
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
			  /////////////////////BATTERY Residual Current :::Reference Current ::: 09B09F0BA ////////////////////////////////////
			 
			  if ($rowbbuacpt['iduniquebranch'] =="09B09F0BA" && $rowbbuacpt['idfasoutcomecat'] == 1 && $rowbbuacpt['idtype'] == 0 )
			  {
			  
				 $v_battresidualcurre_totalpass=$rowbbuacpt['totalpass'];
			 //	echo "".$v_residualcurre_totalpass;
			  }
 
			  if ($rowbbuacpt['iduniquebranch'] =="09B09F0BA" && $rowbbuacpt['idfasoutcomecat'] == 2 && $rowbbuacpt['idtype'] == 5 )
			  {
				  
				 $v_battresidualcurre_ref=$rowbbuacpt['v_double'];
			  
			 //	echo "".$v_residualcurre_totalpass;
			  }
			  if ($rowbbuacpt['iduniquebranch'] =="09B09F0BA" && $rowbbuacpt['idfasoutcomecat'] == 2 && $rowbbuacpt['idtype'] == 1 )
			  {
				 $v_battresidualcurre_tole=$rowbbuacpt['v_double'];
			  
			  }
			  if ($rowbbuacpt['iduniquebranch'] =="09B09F0BA" && $rowbbuacpt['idfasoutcomecat'] == 5 && $rowbbuacpt['idtype'] == 2 )
			  {
				 $v_battresidualcurre_fip485=$rowbbuacpt['v_double'];
			  
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
				if ($rowbbuacpt['iduniquebranch'] =="09B09F0AD" && $rowbbuacpt['idfasoutcomecat'] == 3 && $rowbbuacpt['idtype'] == 0 )
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
	?><span class="badge bg-red">Not Pass</span><?php
}
?></td>
 
<td style="text-align: left"><?php echo $vpower_source_voltage_ref; ?> V +/-  <?php echo $vpower_source_voltage_ref2; ?> V</td>
 
<td style="text-align: left"><?php echo $vrefFIP485vol;?> V</td>

</tr>


<tr>
<td style="text-align: left" >Main Residual Current</td>
<td style="text-align: center"><?php if ( $v_residualcurre_totalpass ==1)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-red">Not Pass</span><?php
}
?></td>
 
<td style="text-align: left"><?php echo ($v_residualcurre_ref * 1000); ?> mA  +/-  <?php echo ($v_residualcurre_tole * 1000); ?> mA</td>
 
<td style="text-align: left"><?php echo $v_residualcurre_fip485;?> mA</td>
</tr>

 
<?php if ($v_battresidualcurre_fip485 != "")
{
	?>
<tr>
<td style="text-align: left" >2nd Sensor Residual Current</td>
<td style="text-align: center"><?php if ( $v_battresidualcurre_totalpass ==1)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-red">Not Pass</span><?php
}
?></td>
 
<td style="text-align: left"><?php echo ($v_battresidualcurre_ref * 1000); ?> mA  +/-  <?php echo ($v_battresidualcurre_tole * 1000); ?> mA</td>
 
<td style="text-align: left"><?php echo $v_battresidualcurre_fip485;?> mA</td>
</tr>
<?php } ?>


<!-- /////////////Board Temperature/////////////// -->

<?php

if ($v_have_temp_sensor == "Y")
{
	?>
<tr>
<td style="text-align: left" >Board Temperature</td>
<td style="text-align: center"><?php if ( $board_external_temp_totalpass ==1)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-red">Not Pass</span><?php
}
?></td>
 
<td style="text-align: left"><?php echo $temp_board_reference2_31; ?> ° C < Temperature Board < <?php echo $temp_board_reference2_15; ?>° C </td>
 
<td style="text-align: left"><?php echo $temp_board_uc5_11;?>° C </td>
</tr>
<tr>
<td style="text-align: left" >External Temperature</td>
<td style="text-align: center"><?php if ( $board_external_temp_totalpass ==1)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-red">Not Pass</span><?php
}
?></td>
 
<td style="text-align: left">+/-<?php echo $extern_temp_2_1; ?> respect Temperature Board <br><?php echo $temp_board_reference2_31; ?> ° C < Temperature Board < <?php echo $temp_board_reference2_15; ?>° C </td>
 
<td style="text-align: left"><?php echo $$extern_temp_5_36;?>° C </td>
</tr>
<?php } ?>
<!-- /////////////end Board Temperature //////////////  -->

<tr>
	<td colspan=4><br></td>
</tr>
 
 
<tr>
<th colspan=4 style="text-align: left"><br>
<h5 style="text-decoration: underline;font-size:18px ">Alarms BDA: </h5>
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
		/*
		 '09B09F0A10B7' - Annunciator Communication Alarm
		'09B09F0A10A3' - AC Fail Alarm -  Loss Normal AC Power - Alarm (5,7)
		'09B09F0A10A7' - 
		*/


		$elsql2="
		select fas_outcome_integral.idfasoutcomecat , fas_outcome_integral.idtype, idruninfodb, fas_outcome_category_type.fasoutcometypename, 
	fas_outcome_integral.v_boolean::integer as v_booleanint,fas_routines_steps.instance as iduniquebranch, fas_integral_totalpass.v_boolean::int as totalpass, 
	 fas_outcome_integral.reference, scriptname 
	
	from fnt_select_allfas_routines_process_sn_maxrev_byscript('".$vparam_vnrounitsn."',22) as fas_routines_process_sn_t
	 
	inner join fas_script_type on fas_script_type.idscripttype = fas_routines_process_sn_t.idscript 
	inner join fas_routines_steps on fas_routines_steps.idstep = fas_routines_process_sn_t.idstep 
	inner join fas_outcome_integral on fas_outcome_integral.reference = fas_routines_process_sn_t.iduniqueop and 
	fas_routines_process_sn_t.iduniqueop = fas_outcome_integral.reference 
	
	inner join fas_outcome_integral as fas_integral_totalpass 
	on fas_outcome_integral.reference = fas_integral_totalpass.reference and
		fas_integral_totalpass.idfasoutcomecat=1 and
		fas_integral_totalpass.idtype =0 and
		fas_integral_totalpass.v_boolean is not null
	
	inner join fas_outcome_category_type on fas_outcome_category_type.idfasoutcomecat = fas_outcome_integral.idfasoutcomecat and 
	fas_outcome_category_type.idtype = fas_outcome_integral.idtype
	inner join fnt_select_maxidrun_fas_outcome_integral_byidscrip('".$vparam_vnrounitsn."',22) as maxidrun on maxidrun.reference = fas_routines_process_sn_t.idruninfodb
	
	where 
	fas_routines_steps.instance in('09B09F0A10B2','09B09F0A10A7', '09B09F0A10B7', '09B09F0A10A3', '09B09F0A10A2','09B09F0A10AF','09B09F0A10A5','09B09F0A10B0','09B09F0A10A6','09B09F0A10B1','09B09F0A10A6','09B09F0A10B1','09B09F0A10B0','09B09F0A10A5') and fas_outcome_integral.idfasoutcomecat in(2,5,8)
	   ";


	/*$elsql2="select fas_outcome_integral.idfasoutcomecat , fas_outcome_integral.idtype, idruninfodb, fas_outcome_category_type.fasoutcometypename, 
	fas_outcome_integral.v_boolean::integer as v_booleanint, fas_tree_measure.iduniquebranch, fas_tree_measure.totalpass::int as totalpass, 
	 fas_outcome_integral.reference, scriptname,description 
	 
	from fnt_select_allfas_routines_process_sn_maxrev_byscript('".$vparam_vnrounitsn."',22) as fas_routines_process_sn_t 
	inner join fas_tree_measure on fas_tree_measure.unitsn = fas_routines_process_sn_t.sn and fas_tree_measure.idrununfo = fas_routines_process_sn_t.idruninfodb and 
	fas_tree_measure.iduniqueop = fas_routines_process_sn_t.iduniqueop 
	inner join fas_script_type on fas_script_type.idscripttype = fas_routines_process_sn_t.idscript 
	inner join fas_step on fas_step.idfasstep = fas_routines_process_sn_t.idstep 
	inner join fas_outcome_integral on fas_outcome_integral.reference = fas_routines_process_sn_t.iduniqueop and 
	fas_routines_process_sn_t.iduniqueop = fas_outcome_integral.reference 
	inner join fas_outcome_category_type on fas_outcome_category_type.idfasoutcomecat = fas_outcome_integral.idfasoutcomecat and 
	fas_outcome_category_type.idtype = fas_outcome_integral.idtype inner join fnt_select_maxidrun_fas_outcome_integral_byidscrip('".$vparam_vnrounitsn."',22) as maxidrun on maxidrun.reference = fas_routines_process_sn_t.idruninfodb
	where 
fas_tree_measure.iduniquebranch in('09B09F0A10B2','09B09F0A10A7', '09B09F0A10B7', '09B09F0A10A3', '09B09F0A10A2','09B09F0A10AF','09B09F0A10A5','09B09F0A10B0','09B09F0A10A6','09B09F0A10B1','09B09F0A10A6','09B09F0A10B1','09B09F0A10B0','09B09F0A10A5') and fas_outcome_integral.idfasoutcomecat in(2,5,8)";
  */
	///echo "aca marco:".$elsql2;
	$sqlbbttalamr = $connect->prepare($elsql2);


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

		$v_batt_capacityunder_led_On =""; 
		$v_batt_capacityunder_led_Off="";

		$v_AC_fail_alarm_on ="";
		$v_AC_fail_alarm_off ="";


		$v_annun_com_alarm_on ="";
		$v_annun_com_alarm_off ="";

		$v_batt_capacit_alarm_on = "";
		$v_batt_capacit_alarm_off = "";

		/* fire panel alarm*/

		$v_FirePAlarm_General_Failure_alarm_off = "";
		$v_FirePAlarm_General_Failure_alarm_on = "";

		$v_FirePAlarm_donnor_ant_disc_alarm_on="";
		$v_FirePAlarm_donnor_ant_disc_alarm_off="";

		$v_FirePAlarm_donnor_ant_malfunc_alarm_on="";
		$v_FirePAlarm_donnor_ant_malfunc_alarm_off="";

		$v_FirePAlarm_vswr_alarm_on="";
		$v_FirePAlarm_vswr_alarm_off="";

		$v_FirePAlarm_system_comp_fail_alarm_off="";
		$v_FirePAlarm_system_comp_fail_alarm_on="";

		$v_FirePAlarm_batt_capacityunder_led_On =""; 
		$v_FirePAlarm_batt_capacityunder_led_Off="";


		$v_FirePAlarm_batt_capacit_alarm_on = "";
		$v_FirePAlarm_batt_capacit_alarm_off = "";

		$v_FirePAlarm_AC_fail_alarm_on ="";
		$v_FirePAlarm_AC_fail_alarm_off ="";


		$v_FirePAlarm_annun_com_alarm_on ="";
		$v_FirePAlarm_annun_com_alarm_off ="";

		/* fire panel alarm*/


		$v_rf_emitter_fail_led_Off="";
		$v_rf_emitter_fail_led_ON="";

		$v_system_comp_fail_led_Off="";
		$v_system_comp_fail_led_On="";



		$v_donnor_ant_disconect_led_ON="";
$v_donnor_ant_disconect_led_Off="";
$v_donnor_ant_malfunction_led_ON="";
$v_donnor_ant_malfunction_led_Off="";

$v_system_comp_fail_led_On = "";
$v_system_comp_fail_led_Off="";

$v_batt_capacityunder_led_On = "";
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

				

				/////-----	'09B09F0A10A3' - AC Fail Alarm -  Loss Normal AC Power - Alarm (5,7)
				if ($row_alarm['iduniquebranch'] =="09B09F0A10A3" && $row_alarm['idfasoutcomecat'] == 5 && $row_alarm['idtype'] == 7 )
				{
				$v_AC_fail_alarm_on=$row_alarm['v_booleanint'];

				}
				////////// 09B09F0A10A4 - AC Fail Alarm -  Loss Normal AC Power - Alarm (5,7)
				if ($row_alarm['iduniquebranch'] =="09B09F0A10A4" && $row_alarm['idfasoutcomecat'] == 5 && $row_alarm['idtype'] == 7 )
				{
				$v_AC_fail_alarm_off=$row_alarm['v_booleanint'];

				}



				/////-----	  Annunciator Communication Alarm
				if ($row_alarm['iduniquebranch'] =="09B09F0A10B7xxxxxxx" && $row_alarm['idfasoutcomecat'] == 5 && $row_alarm['idtype'] ==9 )
				{
				$v_annun_com_alarm_on=$row_alarm['v_booleanint'];

				}
				////////// '09B09F0A10B7' - Annunciator Communication Alarm
				if ($row_alarm['iduniquebranch'] =="09B09F0A10B7" && $row_alarm['idfasoutcomecat'] == 5 && $row_alarm['idtype'] == 9 )
				{
				$v_annun_com_alarm_off=$row_alarm['v_booleanint'];

				}

				////////////////// Variables fire panel alarm//////////FIREPANELALARM///////////////////////////////////
					/////// 09B09F0A10A7  General Failure Alarm On
					if ($row_alarm['iduniquebranch'] =="09B09F0A10A7" && $row_alarm['idfasoutcomecat'] == 5 && $row_alarm['idtype'] == 3 )
					{
						$v_FirePAlarm_General_Failure_alarm_on =$row_alarm['v_booleanint'];
					
					}
					/////// 09B09F0A10B2  General Failure Alarm On
					if ($rowbrow_alarmbuacpt['iduniquebranch'] =="09B09F0A10B2" && $row_alarm['idfasoutcomecat'] == 5 && $row_alarm['idtype'] == 3 )
					{
						$v_FirePAlarm_General_Failure_alarm_off =$row_alarm['v_booleanint'];
						
					}
	
					/////// 09B09F0A10A7  Donor Antenna Disconnection Alarm ON
					if ($row_alarm['iduniquebranch'] =="09B09F0A10A7" && $row_alarm['idfasoutcomecat'] == 5 && $row_alarm['idtype'] == 4 )
					{
						$v_FirePAlarm_donnor_ant_disc_alarm_on=$row_alarm['v_booleanint'];
					 
					}
					/////// 09B09F0A10B2  Donor Antenna Disconnection Alarm
					if ($rowbrow_alarmbuacpt['iduniquebranch'] =="09B09F0A10B2" && $row_alarm['idfasoutcomecat'] == 5 && $row_alarm['idtype'] == 4 )
					{
						$v_FirePAlarm_donnor_ant_disc_alarm_off =$row_alarm['v_booleanint'];
						
					}
	
				
	
					/////// 09B09F0A10A7  Donor Antenna Malfunction Alarm ON
					if ($row_alarm['iduniquebranch'] =="09B09F0A10A7" && $row_alarm['idfasoutcomecat'] == 5 && $row_alarm['idtype'] == 5 )
					{
						$v_FirePAlarm_donnor_ant_malfunc_alarm_on =$row_alarm['v_booleanint'];
						
					}
					/////// 09B09F0A10B2  Donor Antenna Malfunction Alarm off
					if ($rowbrow_alarmbuacpt['iduniquebranch'] =="09B09F0A10B2" && $row_alarm['idfasoutcomecat'] == 5 && $row_alarm['idtype'] == 5 )
					{
						$v_FirePAlarm_donnor_ant_malfunc_alarm_off  =$row_alarm['v_booleanint'];
						
					}
	
				 
	
					/////// 09B09F0A10A7 VSWR Alarm ON
					if ($row_alarm['iduniquebranch'] =="09B09F0A10A7" && $row_alarm['idfasoutcomecat'] == 5 && $row_alarm['idtype'] == 6 )
					{
						$v_FirePAlarm_vswr_alarm_on =$row_alarm['v_booleanint'];
						
					}
					/////// 09B09F0A10B2 VSWR Alarm off
					if ($rowbrow_alarmbuacpt['iduniquebranch'] =="09B09F0A10B2" && $row_alarm['idfasoutcomecat'] == 5 && $row_alarm['idtype'] == 6 )
					{
						$v_FirePAlarm_vswr_alarm_off =$row_alarm['v_booleanint'];
						
					}
					
					/*
					aca
					*/
	
					/////// 09B09F0A10A7 ::::  System Components Fail Alarm ON Check  2,8 System Components Fail Alarm	ON
					if ($row_alarm['iduniquebranch'] =="09B09F0A10A7" && $row_alarm['idfasoutcomecat'] == 2 && $row_alarm['idtype'] == 8 )
					{
						$v_FirePAlarm_system_comp_fail_alarm_on =$row_alarm['v_booleanint'];
						
					}
					/////// 09B09F0A10B0 ::  System Components Fail Alarm OFF Check Reference Alarm  2,8 Battery Capacity Alarm 
					if ($rowbrow_alarmbuacpt['iduniquebranch'] =="09B09F0A10B0" && $row_alarm['idfasoutcomecat'] == 2 && $row_alarm['idtype'] == 8 )
					{
						$v_FirePAlarm_system_comp_fail_alarm_off =$row_alarm['v_booleanint'];
						
					}
	
					/////// 09B09F0A10A7 ::::  Battery Capacity Alarm ON Check  2,8 System Components Fail Alarm	ON
					if ($row_alarm['iduniquebranch'] =="09B09F0A10A7" && $row_alarm['idfasoutcomecat'] == 2 && $row_alarm['idtype'] == 8 )
					{
						$v_FirePAlarm_batt_capacit_alarm_on=$row_alarm['v_booleanint'];
						
					}
					/////// 09B09F0A10B0 ::  Battery Capacity Alarm OFF Check  Reference Alarm  2,8 Battery Capacity Alarm 
					if ($row_alarm['iduniquebranch'] =="09B09F0A10B1" && $row_alarm['idfasoutcomecat'] == 2 && $row_alarm['idtype'] == 8 )
					{
						$v_FirePAlarm_batt_capacit_alarm_off =$row_alarm['v_booleanint'];
						
					}
					/////-----	'09B09F0A10A7' - AC Fail Alarm -  Loss Normal AC Power - Alarm (5,7)
					if ($row_alarm['iduniquebranch'] =="09B09F0A10A7" && $row_alarm['idfasoutcomecat'] == 5 && $row_alarm['idtype'] == 7 )
					{
					$v_FirePAlarm_AC_fail_alarm_on =$row_alarm['v_booleanint'];
	
					}
					////////// 09B09F0A10B0 - AC Fail Alarm -  Loss Normal AC Power - Alarm (5,7)
					if ($row_alarm['iduniquebranch'] =="09B09F0A10B0" && $row_alarm['idfasoutcomecat'] == 5 && $row_alarm['idtype'] == 7 )
					{
					$v_FirePAlarm_AC_fail_alarm_off =$row_alarm['v_booleanint'];
	
					}
	
	
	
					/////-----	  Annunciator Communication Alarm
					if ($row_alarm['iduniquebranch'] =="09B09F0A10B7xxxxxxx" && $row_alarm['idfasoutcomecat'] == 5 && $row_alarm['idtype'] ==9 )
					{
					$v_FirePAlarm_annun_com_alarm_on=$row_alarm['v_booleanint'];
	
					}
					////////// '09B09F0A10B0' - Annunciator Communication Alarm
					if ($row_alarm['iduniquebranch'] =="09B09F0A10B0" && $row_alarm['idfasoutcomecat'] == 5 && $row_alarm['idtype'] == 9 )
					{
					$v_FirePAlarm_annun_com_alarm_off =$row_alarm['v_booleanint'];
	
					}
				///////////////////ffin variales fire panel alarm ////////////////////////////////////////////
							
							//////////////09B09F0A10A2 Starting Fire Panel Alarms ON Check -  RF Emitter Fail Led 8 ,13
							if ($row_alarm['iduniquebranch'] =="09B09F0A10A2" && $row_alarm['idfasoutcomecat'] == 8 && $row_alarm['idtype'] == 13 )
							{
								$v_rf_emitter_fail_led_ON=$row_alarm['v_booleanint'];
							 
								
							}
							//////////////09B09F0A10AF Starting Fire Panel Alarms OFF Check -  RF Emitter Fail Led 8 ,13
							if ($row_alarm['iduniquebranch'] =="09B09F0A10AF" && $row_alarm['idfasoutcomecat'] == 8 && $row_alarm['idtype'] == 13 )
							{
								$v_rf_emitter_fail_led_Off=$row_alarm['v_booleanint'];
								
							}

								//////////////09B09F0A10A2 Starting Fire Panel Alarms ON Check -  Donor Antenna Disconnection Led 8 ,14
								if ($row_alarm['iduniquebranch'] =="09B09F0A10A2" && $row_alarm['idfasoutcomecat'] == 8 && $row_alarm['idtype'] == 14 )
								{
									$v_donnor_ant_disconect_led_ON=$row_alarm['v_booleanint'];
									
								}
								//////////////09B09F0A10AF Starting Fire Panel Alarms OFF Check - Donor Antenna Disconnection Led Led 8 ,14
								if ($row_alarm['iduniquebranch'] =="09B09F0A10AF" && $row_alarm['idfasoutcomecat'] == 8 && $row_alarm['idtype'] == 14 )
								{
									$v_donnor_ant_disconect_led_Off=$row_alarm['v_booleanint'];
									
								}
								
								//////////////09B09F0A10A2 Starting Fire Panel Alarms ON Check - Donor Antenna Malfunction Led Led 8 ,15
						//		echo "<br>a ver:".$row_alarm['iduniquebranch'];
								if ($row_alarm['iduniquebranch'] =="09B09F0A10A2" && $row_alarm['idfasoutcomecat'] == 8 && $row_alarm['idtype'] == 15 )
								{
									$v_donnor_ant_malfunction_led_ON=$row_alarm['v_booleanint'];
								
									
								} 
								//////////////09B09F0A10AF Starting Fire Panel Alarms OFF Check - Donor Antenna Malfunction Led Led Led 8 ,15
								if ($row_alarm['iduniquebranch'] =="09B09F0A10AF" && $row_alarm['idfasoutcomecat'] == 8 && $row_alarm['idtype'] == 15 )
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
	?><span class="badge bg-red">Not Pass</span><?php
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
	?><span class="badge bg-red">Not Pass</span><?php
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
	?><span class="badge bg-red">Not Pass</span><?php
}
?>
</td>
</tr>
<tr>
<td style="text-align: left">Donor Antenna Disconnection alarm state</td>
<td style="text-align: center"> 
<?php  

if ( $v_donnor_ant_disc_alarm_on ==1 &&  $v_donnor_ant_disc_alarm_off ==0)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-red">Not Pass</span><?php
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
	?><span class="badge bg-red">Not Pass</span><?php
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
	?><span class="badge bg-red">Not Pass</span><?php
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
	?><span class="badge bg-red">Not Pass</span><?php
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
	?><span class="badge bg-red">Not Pass</span><?php
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
	?><span class="badge bg-red">Not Pass</span><?php
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
	?><span class="badge bg-red">Not Pass</span><?php
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
	?><span class="badge bg-red">Not Pass</span><?php
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
	?><span class="badge bg-red">Not Pass</span><?php
}
?>
</td>
</tr>

<tr>
	<td colspan=4><br> <h5 style="text-decoration: underline;font-size:18px; text-align: left; ">Alarms BBU: </h5> </td>
</tr>
 
 
 
<tr>
<th style="text-align: left">Reference:</th>
<th style="text-align: center">Status</th>
<th style="text-align: center">Forced On</th>
<th style="text-align: center">Forced Off</th>
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
	?><span class="badge bg-red">Not Pass</span><?php
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
	?><span class="badge bg-red">Not Pass</span><?php
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
	?><span class="badge bg-red">Not Pass</span><?php
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
	?><span class="badge bg-red">Not Pass</span><?php
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
	?><span class="badge bg-red">Not Pass</span><?php
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
	?><span class="badge bg-red">Not Pass</span><?php
}
?>
</td>
</tr>


<tr>
<td style="text-align: left"> AC Fail Alarm</td>
<td style="text-align: center">
<?php  



if ( $v_AC_fail_alarm_on ==1 &&  $v_AC_fail_alarm_off ==0)
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

if ( $v_AC_fail_alarm_on ==1)
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

if ( $v_AC_fail_alarm_off ==0)
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



<!-- ///////////// Alarm Board Temperature/////////////// -->

<?php



if ($v_have_temp_sensor == "Y")
{
	?>
<tr>
<td style="text-align: left" >System High Temperature Alarm</td>

<td style="text-align: center">
<?php  



if ( $v_syshigh_tempalarm_on ==1 &&  $v_syshigh_tempalarm_off ==0)
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

if ( $v_syshigh_tempalarm_on ==1)
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

if ( $v_syshigh_tempalarm_off ==0)
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
<?php } ?>
<!-- ///////////// Alarm Board Temperature/////////////// -->



<?php  
/*
<tr>
<td style="text-align: left">Annunciator Communication Alarm</td>
<td style="text-align: center">


$v_annun_com_alarm_on
$v_annun_com_alarm_off 

if ( $v_annun_com_alarm_on ==1 &&  $v_annun_com_alarm_off ==0)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-red">Not Pass</span><?php
}
</td>
<td style="text-align: center">
*/
?> 
<?php  

/*
if ( $v_annun_com_alarm_on ==1)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-red">Not Pass</span><?php
}
</td>
<td style="text-align: center"> 
*/
?>
<?php  
/*
if ( $v_annun_com_alarm_off ==0)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-red">Not Pass</span><?php
}
*/
?>
</td>
</tr>

 
<tr>
	<td colspan=4><br></td>
</tr>
 
<?php 
/// SI empresa es fiples no moestramos
/*[03-16-2022--- 09:20] Floridia, Francesco

Gamewell, Silent Knight, farenheyt
*/

	if ($idbusineesdelproducto == 5  || $idbusineesdelproducto == 8 )
	{
?> 
<!-- AGREGAR FIRE PANEL ALARM -->
<tr>
	<td colspan=4><br></td>
</tr>
 
 
<tr>
<th colspan=4 style="text-align: left"><br>
<h5 style="text-decoration: underline;font-size:18px ">Fire Panel Alarm: </h5>
</th>
</tr>
<tr>
<th style="text-align: left">Reference:</th>
<th style="text-align: center">Status</th>
<th style="text-align: center">Forced On</th>
<th style="text-align: center">Forced Off</th>
</tr>

<tr>
<td style="text-align: left">General Failure alarm state</td>
<td style="text-align: center"> <?php  

if ( $v_General_Failure_alarm_on ==1 &&  $v_General_Failure_alarm_off ==0)
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

if ( $v_General_Failure_alarm_on ==1)
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
<?php if ( $v_General_Failure_alarm_off ==0)
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
<tr>
<td style="text-align: left">Donor Antenna Disconnection alarm state</td>
<td style="text-align: center"> 
<?php  

if ( $v_FirePAlarm_donnor_ant_disc_alarm_on ==1 &&  $v_FirePAlarm_donnor_ant_disc_alarm_off ==0)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-red">Not Pass</span><?php
}
?>
</td>
<td style="text-align: center"> <?php  

if ( $v_FirePAlarm_donnor_ant_disc_alarm_on ==1)
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

if ( $v_FirePAlarm_donnor_ant_disc_alarm_off ==0)
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
<tr>
<td style="text-align: left">Donor Antenna Malfunction alarm state</td>
<td style="text-align: center">

<?php  

if ( $v_FirePAlarm_donnor_ant_malfunc_alarm_on ==1 &&  $v_FirePAlarm_donnor_ant_malfunc_alarm_off ==0)
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

if ( $v_FirePAlarm_donnor_ant_malfunc_alarm_on ==1)
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

if ( $v_FirePAlarm_donnor_ant_malfunc_alarm_off ==0)
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
<tr>
<td style="text-align: left">VSWR alarm state</td>
<td style="text-align: center">
<?php  

if ( $v_FirePAlarm_vswr_alarm_on ==1 &&  $v_FirePAlarm_vswr_alarm_off ==0)
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

if ( $v_FirePAlarm_vswr_alarm_on ==1)
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

if ( $v_FirePAlarm_vswr_alarm_off ==0)
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




<tr>
<td style="text-align: left">System Components Fail Alarm </td>
<td style="text-align: center">
<?php  

if ( $v_FirePAlarm_system_comp_fail_alarm_on ==1 &&  $v_FirePAlarm_system_comp_fail_alarm_off ==0)
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

if ( $v_FirePAlarm_system_comp_fail_alarm_on ==1)
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

if ( $v_FirePAlarm_system_comp_fail_alarm_off ==0)
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

<tr>
<td style="text-align: left">Battery Capacity Alarm</td>
<td style="text-align: center">
<?php  

if ( $v_FirePAlarm_batt_capacit_alarm_on ==1 &&  $v_FirePAlarm_batt_capacit_alarm_off ==0)
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

if ( $v_FirePAlarm_batt_capacit_alarm_on ==1)
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

if ( $v_FirePAlarm_batt_capacit_alarm_off ==0)
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

--

<tr>
<td style="text-align: left"> AC Fail Alarm</td>
<td style="text-align: center">
<?php  



if ( $v_FirePAlarm_AC_fail_alarm_on ==1 &&  $v_FirePAlarm_AC_fail_alarm_off ==0)
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

if ( $v_FirePAlarm_AC_fail_alarm_on ==1)
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

if ( $v_FirePAlarm_AC_fail_alarm_off ==0)
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
 
--
 
<tr>
	<td colspan=4><br></td>
</tr>
<tr>
	<td colspan=4><br></td>
</tr>
 
<!-- FIN AGREGAR FIRE PANEL ALARM  -->
<?php 
	}
?>
 
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
<td style="text-align: left">RF Emitter Fail   </td>
<td style="text-align: center">
<?php  

if ( $v_rf_emitter_fail_led_ON ==1 &&  $v_rf_emitter_fail_led_Off ==0)
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

if ( $v_rf_emitter_fail_led_ON ==1)
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

if ( $v_rf_emitter_fail_led_Off ==0)
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
	?><span class="badge bg-red">Not Pass</span><?php
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
	?><span class="badge bg-red">Not Pass</span><?php
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
	?><span class="badge bg-red">Not Pass</span><?php
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
	?><span class="badge bg-red">Not Pass</span><?php
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
	?><span class="badge bg-red">Not Pass</span><?php
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
	?><span class="badge bg-red">Not Pass</span><?php
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
	?><span class="badge bg-red">Not Pass</span><?php
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
	?><span class="badge bg-red">Not Pass</span><?php
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
	?><span class="badge bg-red">Not Pass</span><?php
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
	?><span class="badge bg-red">Not Pass</span><?php
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
	?><span class="badge bg-red">Not Pass</span><?php
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
	?><span class="badge bg-red">Not Pass</span><?php
}
/*
 
								
								*/
?>
</td>
</tr>
<tr><td><br></td> </tr>
<tr>
<th colspan=4 style="text-align: left">
<h5 style="text-decoration: underline;font-size:18px "><br>Power Stress: </h5>
</th>
</tr>
</table>
			
			 </div> 
			 <br><br><br><br><br>

	 
  <div class="container-fluid " id="divgrafico700mp" name="divgrafico700mp" >
     
       <div class="col-12">
       <hr style=" border: 1px solid #007bff;">
       <div class="col-12   " id="divgraf_current_pwr" name="divgraf_current_pwr">
             
             <div class="chart">
               <canvas id="graf_current_pwr" height="280" style="height: 280;"></canvas>
             </div>
         </div>

         <div class="row">
         <div class="col-12    " id="divgraf_volt_read" name="divgraf_volt_read">
          
          <div class="chart">
            <canvas id="graf_volt_read" height="280" style="height: 280;"></canvas>
          </div>
      </div>
         
          <div class="col-12   " id="divgraf_current_read" name="divgraf_current_read">
          
                <div class="chart">
                  <canvas id="graf_current_read" height="280" style="height: 280;" ></canvas>
                </div>
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
<script src="plugins/moment/moment.min.js"></script>
<script src="js/moment-timezone-with-data.js"></script>
</body>



<script type="text/javascript">


	$( document ).ready(function() {
		
		var interval = setInterval(function() {
			 
			 var momentNow = moment();
			 var newYork    = momentNow.tz('America/New_York').format('ha z');
			 $('#date-part').html(momentNow.format('YYYY/MM/DD') 	  );
			 $('#time-part').html(momentNow.format('hh:mm:ss'));
			 }, 100);


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
			
				armar_graficos_imdstress();
  
	});
	
	var cant_veces_controlo = 0;
	var cant_veces_controlo_limit = 15;
//var container = document.getElementById('visualization');
//var timeline = new vis.Timeline(container);
var refreshIntervalIdbuscaruninfo =0;

var   datamm={};
var iduniqueop_band_0_uldl_0_tx ="";
var			iduniqueop_band_0_uldl_1_tx ="";
	var		iduniqueop_band_1_uldl_0_tx ="";
	var		iduniqueop_band_1_uldl_1_tx ="";
  var   label_tx={};
  var   label_tx_0_1={};
  var   label_tx2="";
  var label_tx_1="";
  var datax ='';
  var label_700_compartir= '';

var graf_total_0_0="N";
var graf_rx_0_0="N";
var graf_tx_0_0="N";
var graf_total_0_1="N";
var graf_rx_0_1="N";
var graf_tx_0_1="N";
var graf_total_1_0="N";
var graf_rx_1_0="N";
var graf_tx_1_0="N";
var graf_total_1_1="N";
var graf_rx_1_1="N";
var graf_tx_1_1="N";

// recuperamos el querystring
const querystring = window.location.search
console.log(querystring) // '?q=pisos+en+barcelona&ciudad=Barcelona'

// usando el querystring, creamos un objeto del tipo URLSearchParams
const params = new URLSearchParams(querystring)

function window_mouseout( obj, evt, fn ) {

if ( obj.addEventListener ) {

    obj.addEventListener( evt, fn, false );
}
else if ( obj.attachEvent ) {

    obj.attachEvent( 'on' + evt, fn );
}
}


function secondsToString(seconds) {
  var hour = Math.floor(seconds / 3600);
  hour = (hour < 10)? '0' + hour : hour;
  var minute = Math.floor((seconds / 60) % 60);
  minute = (minute < 10)? '0' + minute : minute;
  var second = seconds % 60;
  second = (second < 10)? '0' + second : second;
  return hour + ':' + minute + ':' + second;
}



	function armar_graficos_imdstress()
{

        ///////////////////////
        $.ajax
        ({ 
          url: 'ajax_graph_reportstressbbu.php?unitsn='+params.get('unitsn')+'&idrun='+params.get('idrun'),
          data: "idns="+params.get('idr'),	
          type: 'post',
          async:true,
          cache:false,
          success: function(data)
          {
        ///    console.log('IMD STRESS');
              
          $('#msjwaitline ').hide();
              ///console.log(JSON.parse( data.label_tx ));
              //var keyssmm = Object.keys(datax);
              ///console.log(keyssmm);
               var graf_current_read = $('#graf_current_read').get(0).getContext('2d'); 
               var graf_volt_read   = $('#graf_volt_read').get(0).getContext('2d'); 
                var graf_current_pwr  = $('#graf_current_pwr').get(0).getContext('2d'); 
  

            

                          datos_values_pacurrent_voltread = data.values_pacurrent_voltread.split(",");  
                          datos_values_pacurrent_voltreadFIP485 = data.values_pacurrent_voltreadFIP485.split(",");  
                          label_values_pacurrent_voltread = data.label_pacurrent_voltread.split(",");
                          
                          
                          datos_values_pacurrent_read = data.values_pacurrent_read.split(",");  
                          datos_values_pacurrent_readsensor = data.values_pacurrent_readcurrentsendor.split(",");  

                          label_values_pacurrent_read = data.label_pacurrent_read.split(",");  

                          datos_values_pacurrent_pwr = data.values_pacurrent_pwr.split(",");  
                          label_values_pacurrent_pwr = data.label_pacurrent_pwr.split(",");  

                            for ( var i = 0, j = datos_values_pacurrent_voltread.length ; i < j; i++ ) {
                              if ( datos_values_pacurrent_voltread[ i ] == '' ) {
                                datos_values_pacurrent_voltread.splice( i, 1 );
                              i--;
                              }
                            }

                            for ( var i = 0, j = datos_values_pacurrent_voltreadFIP485.length ; i < j; i++ ) {
                              if ( datos_values_pacurrent_voltreadFIP485[ i ] == '' ) {
                                datos_values_pacurrent_voltreadFIP485.splice( i, 1 );
                              i--;
                              }
                            }

                            for ( var i = 0, j = datos_values_pacurrent_read.length ; i < j; i++ ) {
                              if ( datos_values_pacurrent_read[ i ] == '' ) {
                                datos_values_pacurrent_read.splice( i, 1 );
                              i--;
                              }
                            }

                            for ( var i = 0, j = datos_values_pacurrent_readsensor.length ; i < j; i++ ) {
                              if ( datos_values_pacurrent_readsensor[ i ] == '' ) {
                                datos_values_pacurrent_readsensor.splice( i, 1 );
                              i--;
                              }
                            }

                            for ( var i = 0, j = datos_values_pacurrent_pwr.length ; i < j; i++ ) {
                              if ( datos_values_pacurrent_pwr[ i ] == '' ) {
                                datos_values_pacurrent_pwr.splice( i, 1 );
                              i--;
                              }
                            }
                             
                           console.log(datos_values_pacurrent_pwr); 
                           var    sumarmunitos = new Date('2020-01-01 00:00:00');
                          var nuevolabeltemp_0_0_temp = [];
                                           for (let i = 0; i < label_values_pacurrent_voltread.length; i++) 
                                                  {
                                              
                                                  var date1 = moment("2022-01-01 " + label_values_pacurrent_voltread[0]);
                                                  var date2 = moment("2022-01-01 " +label_values_pacurrent_voltread[i]);
                                                
                                          
                                                  var diff = date2.diff(date1,'s');
 
                                                    nuevolabeltemp_0_0_temp.push(secondsToString(diff));
                                        
                                                  
                                                  }

                         var nuevolabepacurrent_read = [];
                                           for (let i = 0; i < label_values_pacurrent_read.length; i++) 
                                                  {
                                              
                                                  var date1 = moment("2022-01-01 " + label_values_pacurrent_read[0]);
                                                  var date2 = moment("2022-01-01 " +label_values_pacurrent_read[i]);
                                                
                                          
                                                  var diff = date2.diff(date1,'s');
 
                                                  nuevolabepacurrent_read.push(secondsToString(diff));
                                        
                                                  
                                                  }

                        var nuevolabepacurrent_pwr = [];
                                           for (let i = 0; i < label_values_pacurrent_pwr.length; i++) 
                                                  {
                                              
                                                  var date1 = moment("2022-01-01 " + label_values_pacurrent_pwr[0]);
                                                  var date2 = moment("2022-01-01 " +label_values_pacurrent_pwr[i]);
                                                
                                          
                                                  var diff = date2.diff(date1,'s');
 
                                                  nuevolabepacurrent_pwr.push(secondsToString(diff));
                                        
                                                  
                                                  }
                            
                       //     console.log(nuevolabeltemp_0_0_temp); 

                                   var datos_grafico_allband_temp = {
                                        labels  : nuevolabeltemp_0_0_temp,
                                                datasets: [
                                                {
                                                  label               :  'Voltage Read ELOAD  ',
                                                    backgroundColor     : 'rgba(60,141,188,0.1)',
                                                    borderColor         : 'rgba(60,141,188,1)',
                                                    pointRadius          : false,
                                                    pointColor          : '#3b8bba',
                                                    pointStrokeColor    : 'rgba(60,141,188,1)',
                                                    pointHighlightFill  : '#fff',
                                                    pointHighlightStroke: 'rgba(60,141,188,1)',
                                                  data                :  datos_values_pacurrent_voltread                                
                                                  },
                                                  {
                                                  label               :  'Voltage Read FIP485  ',
                                                  backgroundColor     : 'rgba(255, 99, 132, 0.5)',
                                                  borderColor         : 'rgba(255, 99, 132, 1)',
                                                  pointRadius         : false,
                                                  pointColor          : 'rgba(255, 99, 132, 1)',
                                                  pointStrokeColor    : '#c1c7d1',
                                                  pointHighlightFill  : '#fff',
                                                  pointHighlightStroke: 'rgba(255, 99, 132, 1)',		
                                                  data                :  datos_values_pacurrent_voltreadFIP485                                
                                                  }
                                                  
                                                
                                          ]
                                        };

                                        var datos_grafico_pacurrent_read = {
                                        labels  : nuevolabeltemp_0_0_temp,
                                                datasets: [
                                                {
                                                  label               :  'Current Read ELOAD',
                                                    backgroundColor     : 'rgba(60,141,188,0.1)',
                                                    borderColor         : 'rgba(60,141,188,1)',
                                                    pointRadius          : false,
                                                    pointColor          : '#3b8bba',
                                                    pointStrokeColor    : 'rgba(60,141,188,1)',
                                                    pointHighlightFill  : '#fff',
                                                    pointHighlightStroke: 'rgba(60,141,188,1)',
                                                  data                :  datos_values_pacurrent_read                                
                                                  },
                                                  {
                                                  label               :  'Main Current Sensor Read  ',
                                                  backgroundColor     : 'rgba(255, 99, 132, 0.5)',
                                                  borderColor         : 'rgba(255, 99, 132, 1)',
                                                  pointRadius         : false,
                                                  pointColor          : 'rgba(255, 99, 132, 1)',
                                                  pointStrokeColor    : '#c1c7d1',
                                                  pointHighlightFill  : '#fff',
                                                  pointHighlightStroke: 'rgba(255, 99, 132, 1)',		
                                                  data                :  datos_values_pacurrent_readsensor                                
                                                  }
                                                  
                                                
                                          ]
                                        };

                                        
                                        var datos_grafico_pacurrent_pwr = {
                                        labels  : nuevolabeltemp_0_0_temp,
                                                datasets: [
                                                {
                                                  label               :  'Load Power [W]',
                                                    backgroundColor     : 'rgba(60,141,188,0.1)',
                                                    borderColor         : 'rgba(60,141,188,1)',
                                                    pointRadius          : false,
                                                    pointColor          : '#3b8bba',
                                                    pointStrokeColor    : 'rgba(60,141,188,1)',
                                                    pointHighlightFill  : '#fff',
                                                    pointHighlightStroke: 'rgba(60,141,188,1)',
                                                  data                :  datos_values_pacurrent_pwr                                
                                                  },
                                                
                                          ]
                                        };

                                        var optiontemp_2 = {                             
                                          maintainAspectRatio : false,
                                          responsive : true,	
                                          legend: {
                                            display: true
                                          },
                                          title: {
                                              display: false,
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
                                          
                                              } ,ticks: {
                                
                                                suggestedMin: -1,
                                                 suggestedMax: 3
                                              }
                                        
                                          
                                            }]
                                          }
                                        }

                                        var optiontemp_3 = {                             
                                          maintainAspectRatio : false,
                                          responsive : true,	
                                          legend: {
                                            display: true
                                          },
                                          title: {
                                              display: false,
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
                                          
                                              } ,ticks: {
                                
                                                suggestedMin: 0,
                                                 suggestedMax: 100
                                              }
                                        
                                          
                                            }]
                                          }
                                        }

                                        var optiontemp = {                             
                                          maintainAspectRatio : false,
                                          responsive : true,	
                                          legend: {
                                            display: true
                                          },
                                          title: {
                                              display: false,
                                              text: '-- '
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
                                          
                                              } ,ticks: {
                                
                                                suggestedMin: 28,
                                                 suggestedMax: 30
                                              }
                                        
                                          
                                            }]
                                          }
                                        }

                      var rpt_grafico700imdstress01 = new Chart(graf_volt_read, { 
                              type: 'line', 	
                              data: datos_grafico_allband_temp, 	 
                              options: optiontemp 
                            });

                       var rpt_grafico700imdstress02 = new Chart(graf_current_read, { 
                              type: 'line', 	
                              data: datos_grafico_pacurrent_read, 	 
                              options: optiontemp_2
                            });
                          
                            var rpt_grafico700imdstress03 = new Chart(graf_current_pwr, { 
                              type: 'line', 	
                              data: datos_grafico_pacurrent_pwr, 	 
                              options: optiontemp_3
                            });
                       


            }
        });


}

   
  

</script>

</html>

<!DOCTYPE html>
<?php 

// Desactivar toda notificación de error
///error_reporting(0);
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

@media print {
   .divallgraphstress {
      visibility: hidden;
   }
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
	 
 
					$sql = $connect->prepare("select fas_outcome_integral.* , fasoutcometypename from fas_outcome_integral
					inner join fas_outcome_category_type
					on  fas_outcome_category_type.idfasoutcomecat	=	fas_outcome_integral.idfasoutcomecat and
						fas_outcome_category_type.idtype			=	fas_outcome_integral.idtype
					where fas_outcome_integral.reference in ( 
						select reference from fnt_select_maxidrun_fas_outcome_integral_byidscrip('".$vparam_vnrounitsn."',53) 
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
	$v_datetimeidrun=$row2['datetimeref'];
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
	 if( $row2['idtype'] ==36)
	 {
		$fas_hw_version=$row2['v_string'];
	 }

	 if( $row2['idtype'] ==41)
	 {
		
		$battery_charger=$row2['v_string'];
		
	 }
	 if( $row2['idtype'] ==46)
	 {
		
		$battery_current_sensor=$row2['v_string'];
			$sqldscbatt = $connect->prepare("select * from fnt_select_allproducts_maxrev() where   modelciu = '".$battery_current_sensor."' ");
			$sqldscbatt->execute();
			$resultdescbatt = $sqldscbatt->fetchAll();
			foreach ($resultdescbatt as $rowdesbattc) 
			{
				$battery_current_sensor = $rowdesbattc['description'];
			}
		
	 }
	 // buscamos descripcion

	 $sqldsc = $connect->prepare("select * from fnt_select_allproducts_maxrev() where   modelciu = '".$_ciu."' ");
     $vvidprod=0;
	 $descriptionmm="";
 	 $sqldsc->execute();
     $resultdescc = $sqldsc->fetchAll();
	 foreach ($resultdescc as $rowdesc) 
		{
			$descriptionmm=$rowdesc['description'];
			$idbusineesdelproducto=$rowdesc['idbusiness'];
			$vvidprod=$rowdesc['idproduct'];
			
			
		}
	 
		$v_so_soft_external="";
		$sqldscpp = $connect->prepare("select * from orders_sn where idproduct = ".$vvidprod." and    wo_serialnumber = '".$vparam_vnrounitsn."' and typeregister = 'SO' ");
 
	 
			$sqldscpp->execute();
			$resultdescmc = $sqldscpp->fetchAll();
			foreach ($resultdescmc as $rowdescmm) 
				{
					$v_so_soft_external=$rowdescmm['so_soft_external'];
					
				}
 
}

?>
<br>

<table class="table table-sm table-hover table-striped table-bordered text-center textotabla10">
<tr>
<td colspan="3" class="table-dark ">  </td>
 
</tr>
<tr>
<td colspan="3" class="  text-center"><br><h4><b>REPORT HP BBU<b></h4> </td>
 

</tr>
<tr>
<td style='text-align: left'>SO: <strong><?php echo $v_so_soft_external;?></strong></td>
<td style='text-align: right'></td>

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
<td style='width: 30%;text-align: left'>Datime:   <strong><?php echo substr($v_datetimeidrun,0,21);?></strong> </td>
<td style='width: 30%;text-align: right'>FAS Version: <strong><?php echo 	$fas_version;?></strong></td>

</tr>
 
	<tr>
<td  style='text-align: left'>FW uC: <strong> <?php echo 	$_Fw_uC;?> </strong></td>
<td style='width: 30%;text-align: left'>HW: <strong> <?php echo 	$fas_hw_version;?> </strong> </td>
<td style='width: 30%;text-align: right'>RunInfo# <strong><?php if ($idruninfomreq=="") { 
	echo $idruninfom;
} else {
	echo $idruninfomreq;

} ?></strong></td>

</tr>

<tr>
	
<td  style='text-align: left'>Battery Charger: <strong> <?php echo 	$battery_charger; ?> </strong></td>
<td style='width: 30%;text-align: left'>Battery Current Sensor: <strong> <?php echo $battery_current_sensor; ?> </strong> </td>
<td style='width: 30%;text-align: right'></td>

</tr>
 

</table>

						  <?php
						 
					//////////////////////////////////////////	 


						 ?>



<h5 style="text-decoration: underline;font-size:18px;text-align=center "><b>Parameters:</b></h5>
<table class="table table-sm table-hover table-striped table-bordered text-center textotabla10">
<tbody>
<tr>
	<td colspan=4><br></td>
</tr>
<tr >
	<td colspan=4><p class='colorazulfiplex' style='font-size:16px'><br><b>SYSTEM VOLTAGE<b></p></td>
</tr>	
<tr class="thead-dark">
<th style="text-align: left">Measures:</th>
<th style="text-align: center">Status</th>
 
<th style="text-align: left">Reference:</th>
 <th style="text-align: left">Value Readed</th>
</tr>


<?php
 
 //section_create_table_system_voltage_BBUHP_by_idrun_sn($idruninfom,);

	$elsqlvalue="
			select *, '' as instancem from fas_outcome_integral where reference in 
				(
				select id_outcome from fas_outcome_integral where reference in 
								(
										select id_outcome from fas_outcome_integral where reference in 
										(
											select id_outcome from fas_outcome_integral where v_bigint in (
													select iduniqueop
													from 
													(
														select * from fnt_select_allfas_routines_process_sn_maxrev('".$vparam_vnrounitsn."') as dd 
													) as fas_routines_process_sn
													inner join fas_routines_steps
													on fas_routines_steps.idstep = fas_routines_process_sn.idstep
													inner join fas_step
													on fas_step.instance = fas_routines_steps.instance
													where idruninfodb = ". $idruninfom." and iduniqueop > 0
												and 
												fas_step.instance  in('10810B','0DC')											 
											)
										)
								)	
				)
				and  idfasoutcomecat= 11 and idtype in (137,136,27,168)
				union 
				select * , '' as instancem from fas_outcome_integral where reference in 
				(				
					select id_outcome from fas_outcome_integral 
					where v_bigint in (
									select iduniqueop
									  from 
									(
										select * from fnt_select_allfas_routines_process_sn_maxrev('".$vparam_vnrounitsn."') as dd 
									) as fas_routines_process_sn
									inner join fas_routines_steps
									on fas_routines_steps.idstep = fas_routines_process_sn.idstep
									inner join fas_step
									on fas_step.instance = fas_routines_steps.instance
									where idruninfodb =  ". $idruninfom." and iduniqueop > 0
								and 
								fas_step.instance  in('10810B','0DC')
										) 
				) and  idfasoutcomecat= 2 and idtype in (1,6,7,31,15)
				union
				select  fas_outcome_integral.*,lostotalpass.instance
					from 
					(
						select iduniqueop,fas_step.instance
						  from 
						(
							select * from fnt_select_allfas_routines_process_sn_maxrev('".$vparam_vnrounitsn."') as dd 
						) as fas_routines_process_sn
						inner join fas_routines_steps
						on fas_routines_steps.idstep = fas_routines_process_sn.idstep
						inner join fas_step
						on fas_step.instance = fas_routines_steps.instance
						where idruninfodb =  ". $idruninfom." and iduniqueop > 0 and 
						fas_step.instance  in('10810B','0DC')
					) as lostotalpass
					inner join fas_outcome_integral
					on fas_outcome_integral.reference = lostotalpass.iduniqueop


			";
 
	//		$elsqlvalue="select * from fas_outcome_integral limit 10  ";
	 	//	$sqlSystemVoltage = $connect->prepare($elsqlvalue);
		//	echo "bbbbbbbbbbbbbbbbbbbbbbbbbbbbbb".$elsqlvalue."<br><br>";

			
		$v_System_Voltage_status="";
		$v_System_Voltage_ref_2_6="";
		$v_System_Voltage_ref_2_7="";
		$v_System_Voltage_value="";

		$V_Battery_Charger_Voltage_status="";
		$V_Battery_Charger_Voltage_ref_2_6="";
		$V_Battery_Charger_Voltage_ref_2_7="";
		$V_Battery_Charger_Voltage_value="";

		$v_Board_Temperature_status="";
		$v_Board_Temperature_ref_2_31="";
		$v_Board_Temperature_ref_2_1="";
		$v_Board_Temperature_ref_2_15="";
		$v_Board_Temperature_value="";

		$v_ExternalTemperature_status="";
		$v_ExternalTemperature_ref="";
		$v_ExternalTemperature_value="";



			$sqldscpp = $connect->prepare($elsqlvalue);	 
			$sqldscpp->execute();
			$resultdescmc = $sqldscpp->fetchAll();
			foreach ($resultdescmc as $rowbbuacpt) 
				{
					 
					if ( $rowbbuacpt['idfasoutcomecat']==11 && $rowbbuacpt['idtype']==137 ) { $v_System_Voltage_value= $rowbbuacpt['v_double'] ;}
					if ( $rowbbuacpt['idfasoutcomecat']==11 && $rowbbuacpt['idtype']==136 ) { $V_Battery_Charger_Voltage_value= $rowbbuacpt['v_double']; }	
					if ( $rowbbuacpt['idfasoutcomecat']==2 && $rowbbuacpt['idtype']==6 )    {  $v_System_Voltage_ref_2_6 = $rowbbuacpt['v_double']; $V_Battery_Charger_Voltage_ref_2_6 = $rowbbuacpt['v_double'];  }	
					if ( $rowbbuacpt['idfasoutcomecat']==2 && $rowbbuacpt['idtype']==7 )    {  $v_System_Voltage_ref_2_7 = $rowbbuacpt['v_double']; $V_Battery_Charger_Voltage_ref_2_7 = $rowbbuacpt['v_double'];  }	
		
					if ( $rowbbuacpt['idfasoutcomecat']==11 && $rowbbuacpt['idtype']==27 ) { $v_Board_Temperature_value= $rowbbuacpt['v_integer']; }	
					if ( $rowbbuacpt['idfasoutcomecat']==11 && $rowbbuacpt['idtype']==168 ) { $v_ExternalTemperature_value= $rowbbuacpt['v_integer']; }	
					if ( $rowbbuacpt['idfasoutcomecat']==2 && $rowbbuacpt['idtype']==31 ) { $v_Board_Temperature_ref_2_31= $rowbbuacpt['v_integer']; }	
					if ( $rowbbuacpt['idfasoutcomecat']==2 && $rowbbuacpt['idtype']==1 ) { $v_Board_Temperature_ref_2_1= $rowbbuacpt['v_integer']; }	
					if ( $rowbbuacpt['idfasoutcomecat']==2 && $rowbbuacpt['idtype']==15 ) { $v_Board_Temperature_ref_2_15= $rowbbuacpt['v_integer']; }	
		
					if (   $rowbbuacpt['instancem']=='10810B' ) { $v_System_Voltage_status= $rowbbuacpt['v_boolean'];  }	
					if (   $rowbbuacpt['instancem']=='0DC' ) {    $V_Battery_Charger_Voltage_status= $rowbbuacpt['v_boolean'];    }	

				 
 
					if (   $rowbbuacpt['instancem']=='0DC' ) {    $v_Board_Temperature_status= $rowbbuacpt['v_boolean'];    }	
					if (   $rowbbuacpt['instancem']=='0DC' ) {    $v_ExternalTemperature_status= $rowbbuacpt['v_boolean'];    }	

				}
 
				
	

		$elsqlvalue2="
			select *, '' as instancem from fas_outcome_integral where reference in 
				(
				select id_outcome from fas_outcome_integral where reference in 
								(
										select id_outcome from fas_outcome_integral where reference in 
										(
											select id_outcome from fas_outcome_integral where v_bigint in (
													select iduniqueop
													  from 
													(
														select * from fnt_select_allfas_routines_process_sn_maxrev('".$vparam_vnrounitsn."') as dd 
													) as fas_routines_process_sn
													inner join fas_routines_steps
													on fas_routines_steps.idstep = fas_routines_process_sn.idstep
													inner join fas_step
													on fas_step.instance = fas_routines_steps.instance
													where idruninfodb = ". $idruninfom." and iduniqueop > 0
												and 
												fas_step.instance  in('10C10F110')											 
											)
										)
								)	
				)
				and  idfasoutcomecat= 11 and idtype in (169)
				union 
				select * , '' as instancem from fas_outcome_integral where reference in 
				(				
					select id_outcome from fas_outcome_integral 
					where v_bigint in (
									select iduniqueop
									from 
									(
										select * from fnt_select_allfas_routines_process_sn_maxrev('".$vparam_vnrounitsn."') as dd 
									) as fas_routines_process_sn
									inner join fas_routines_steps
									on fas_routines_steps.idstep = fas_routines_process_sn.idstep
									inner join fas_step
									on fas_step.instance = fas_routines_steps.instance
									where idruninfodb =  ". $idruninfom." and iduniqueop > 0
								and 
								fas_step.instance  in('10C10F110' )		
										) 
				) and  idfasoutcomecat= 2 and idtype in (0,1,5)
				union
				select  fas_outcome_integral.*,lostotalpass.instance
					from 
					(
						select iduniqueop,fas_step.instance
						from 
						(
							select * from fnt_select_allfas_routines_process_sn_maxrev('".$vparam_vnrounitsn."') as dd 
						) as fas_routines_process_sn
						inner join fas_routines_steps
						on fas_routines_steps.idstep = fas_routines_process_sn.idstep
						inner join fas_step
						on fas_step.instance = fas_routines_steps.instance
						where idruninfodb =  ". $idruninfom." and iduniqueop > 0 and 
						fas_step.instance  in('10C10F110')		
					) as lostotalpass
					inner join fas_outcome_integral
					on fas_outcome_integral.reference = lostotalpass.iduniqueop


			";

		//	echo "cccccccccccccccc".$elsqlvalue2."<br><br>";
		$sqldscpp = $connect->prepare($elsqlvalue2);	 
			$sqldscpp->execute();
			$resultdescmc2 = $sqldscpp->fetchAll();

			$v_batt_current_sensor_voltage_status="";
			$v_batt_current_sensor_voltage_ref_2_0="";
			$v_batt_current_sensor_voltage_ref_2_1="";
			$v_batt_current_sensor_voltage_value="";

		

		foreach ($resultdescmc2 as $rowbbuacpt2) 
		{
			 
			if ( $rowbbuacpt2['idfasoutcomecat']==11 && $rowbbuacpt2['idtype']==169 ) { $v_batt_current_sensor_voltage_value = ($rowbbuacpt2['v_integer']/1000) ;}
			
			if ( $rowbbuacpt2['idfasoutcomecat']==2 && $rowbbuacpt2['idtype']==0 )    {  $v_batt_current_sensor_voltage_ref_2_0 = $rowbbuacpt2['v_double'];  }	
			if ( $rowbbuacpt2['idfasoutcomecat']==2 && $rowbbuacpt2['idtype']==1 )    {  $v_batt_current_sensor_voltage_ref_2_1 = $rowbbuacpt2['v_double'];  }	
			if (   $rowbbuacpt2['instancem']=='10C10F110' ) {    $v_batt_current_sensor_voltage_status = $rowbbuacpt2['v_boolean'];    }	
		
		}
	 
		$v_Battery_Current_Sensor_Residual_Current_status="";
		$v_Battery_Current_Sensor_Residual_Current_ref_2_5="";
		$v_Battery_Current_Sensor_Residual_Current_ref_2_1="";
		$v_Battery_Current_Sensor_Residual_Current_value="";

		$elsqlvalue3="
		select *, '' as instancem from fas_outcome_integral where reference in 
			(
			select id_outcome from fas_outcome_integral where reference in 
							(
									select id_outcome from fas_outcome_integral where reference in 
									(
										select id_outcome from fas_outcome_integral where v_bigint in (
												select iduniqueop
												from 
												(
													select * from fnt_select_allfas_routines_process_sn_maxrev('".$vparam_vnrounitsn."') as dd 
												) as fas_routines_process_sn
												inner join fas_routines_steps
												on fas_routines_steps.idstep = fas_routines_process_sn.idstep
												inner join fas_step
												on fas_step.instance = fas_routines_steps.instance
												where idruninfodb = ". $idruninfom." and iduniqueop > 0
											and 
											fas_step.instance  in('10C10D10E')											 
										)
									)
							)	
			)
			and  idfasoutcomecat= 11 and idtype in (139)
			union 
			select * , '' as instancem from fas_outcome_integral where reference in 
			(				
				select id_outcome from fas_outcome_integral 
				where v_bigint in (
								select iduniqueop
								from 
								(
									select * from fnt_select_allfas_routines_process_sn_maxrev('".$vparam_vnrounitsn."') as dd 
								) as fas_routines_process_sn
								inner join fas_routines_steps
								on fas_routines_steps.idstep = fas_routines_process_sn.idstep
								inner join fas_step
								on fas_step.instance = fas_routines_steps.instance
								where idruninfodb =  ". $idruninfom." and iduniqueop > 0
							and 
							fas_step.instance  in('10C10D10E' )		
									) 
			) and  idfasoutcomecat= 2 and idtype in (0,1,5)
			union
			select  fas_outcome_integral.*,lostotalpass.instance
				from 
				(
					select iduniqueop,fas_step.instance
					from 
					(
						select * from fnt_select_allfas_routines_process_sn_maxrev('".$vparam_vnrounitsn."') as dd 
					) as fas_routines_process_sn
					inner join fas_routines_steps
					on fas_routines_steps.idstep = fas_routines_process_sn.idstep
					inner join fas_step
					on fas_step.instance = fas_routines_steps.instance
					where idruninfodb =  ". $idruninfom." and iduniqueop > 0 and 
					fas_step.instance  in('10C10D10E')		
				) as lostotalpass
				inner join fas_outcome_integral
				on fas_outcome_integral.reference = lostotalpass.iduniqueop


		";
	//	echo "ddddddd".$elsqlvalue3."<br><br>";
		$sqldscpp = $connect->prepare($elsqlvalue3);	 
			$sqldscpp->execute();
			$resultdescmc3 = $sqldscpp->fetchAll();

			foreach ($resultdescmc3 as $rowbbuacpt3) 
			{
				 
				if ( $rowbbuacpt3['idfasoutcomecat']==11 && $rowbbuacpt3['idtype']==139 ) { $v_Battery_Current_Sensor_Residual_Current_value = ($rowbbuacpt3['v_double']) ;}
				///////////las referencias se guardarn en MiliAmpers.
				if ( $rowbbuacpt3['idfasoutcomecat']==2 && $rowbbuacpt3['idtype']==5 )    {  $v_Battery_Current_Sensor_Residual_Current_ref_2_5 = ($rowbbuacpt3['v_double']*1000);  }	
				if ( $rowbbuacpt3['idfasoutcomecat']==2 && $rowbbuacpt3['idtype']==1 )    {  $v_Battery_Current_Sensor_Residual_Current_ref_2_1 = ($rowbbuacpt3['v_double']*1000);  }	
				if (   $rowbbuacpt3['instancem']=='10C10D10E' ) {    $v_Battery_Current_Sensor_Residual_Current_status = $rowbbuacpt3['v_boolean'];    }	
			
			}

	

///fas_step.instance  in('0850A2104','0850A2105','0850890F7','0850E50F9','0850880FB','0850870F5','085113114','10C10D10E','0850C8112','0850C8106','0850A2104','085113115','0850870F6','0850880FC','0850E50FA','0850890F8')											 
		$elsqlvalue3="
		 
select fas_outcome_integral.*,  instancem , v_boolean::integer as v_booleanm from fas_outcome_integral
inner join 
(
	
select fas_outcome_integral.id_outcome , instancem
		from fas_outcome_integral
inner join 
(
	
		select fas_outcome_integral.id_outcome , instancem
		from fas_outcome_integral
		inner join  (
		 
				select fas_outcome_integral.*  , instancem
				from fas_outcome_integral 
				inner join 
				(
					select fas_outcome_integral.* ,   instancem
					from fas_outcome_integral 
					inner join (
						   select iduniqueop, fas_step.instance as instancem
						   from 
						   (
							   select * from fnt_select_allfas_routines_process_sn_maxrev('".$vparam_vnrounitsn."') as dd 
						   ) as fas_routines_process_sn
						   inner join fas_routines_steps
						   on fas_routines_steps.idstep = fas_routines_process_sn.idstep
						   inner join fas_step
						   on fas_step.instance = fas_routines_steps.instance
						   where idruninfodb = ". $idruninfom."   and iduniqueop > 0
						   and 
					 
						fas_step.instance  in('0850A2104','0850A2105','0850890F7','0850E50F9','0850880FB','0850870F5','085113114','10C10D10E','0850C8112','0850C8106','0850A2104','085113115','0850870F6','0850880FC','0850E50FA','0850890F8')
					) as tdosmm
					on tdosmm.iduniqueop = fas_outcome_integral.reference
						  
				) as todosma
				on fas_outcome_integral.v_bigint =     todosma.reference				 
	 
		) as todom2
		on fas_outcome_integral.reference =     todom2.id_outcome
					
		

	) as todosm3
	on fas_outcome_integral.reference =     todosm3.id_outcome
) as todosm4
on fas_outcome_integral.reference =     todosm4.id_outcome
where  idfasoutcomecat= 11  

 
	 
		";
//		echo "eeeeeee".$elsqlvalue3."<br><br>";

		$v_alarm_normal_ac_power_forced_on ="";		
		$v_alarm_normal_ac_power_forced_off ="";		
		$v_alarm_lossnormal_ac_power_forced_on ="";
		$v_alarm_lossnormal_ac_power_forced_off ="";

		$v_DonorAntennaDisconnection_forced_on = "";
		$v_DonorAntennaDisconnection_forced_off ="";

		$v_DonorAntennaMalfunction_forced_on = "";
		$v_DonorAntennaMalfunction_forced_off ="";

		$v_active_rf_mailfnt_forced_on ="";
		$v_active_rf_mailfnt_forced_off="";

		$v_System_Component_Malfunction_forced_off="";
		$v_System_Component_Malfunction_forced_on="";

		$v_system_high_temp_forced_on ="";
		$v_system_high_temp_forced_off ="";

		$v_BatteryDisconect_forced_on ="";
		$v_BatteryDisconect_forced_off ="";

		$v_remotecommuerror_forced_on ="";
		$v_remotecommuerror_forced_off ="";
		
		

	$sqldscpp3 = $connect->prepare($elsqlvalue3);	 
			$sqldscpp3->execute();
			$resultdescmc3a = $sqldscpp3->fetchAll();

			foreach ($resultdescmc3a as $rowbbuacpt3a) 
			{
				 
				if (   $rowbbuacpt3a['instancem']=='0850A2105' && $rowbbuacpt3a['idfasoutcomecat']==11 && $rowbbuacpt3a['idtype']==144 ) {  $v_alarm_normal_ac_power_forced_on = $rowbbuacpt3a['v_booleanm'] ;}
				if (   $rowbbuacpt3a['instancem']=='0850A2104' && $rowbbuacpt3a['idfasoutcomecat']==11 && $rowbbuacpt3a['idtype']==144 ) {  $v_alarm_normal_ac_power_forced_off = $rowbbuacpt3a['v_booleanm'] ;}
				
				if (   $rowbbuacpt3a['instancem']=='0850A2104' && $rowbbuacpt3a['idfasoutcomecat']==11 && $rowbbuacpt3a['idtype']==145 ) {  $v_alarm_lossnormal_ac_power_forced_on = $rowbbuacpt3a['v_booleanm'] ;}
				if (   $rowbbuacpt3a['instancem']=='0850A2105' && $rowbbuacpt3a['idfasoutcomecat']==11 && $rowbbuacpt3a['idtype']==145 ) {  $v_alarm_lossnormal_ac_power_forced_off = $rowbbuacpt3a['v_booleanm'] ;}

				if (   $rowbbuacpt3a['instancem']=='0850A2104' && $rowbbuacpt3a['idfasoutcomecat']==11 && $rowbbuacpt3a['idtype']==147 ) {  $v_BatteryChargerFail_forced_on = $rowbbuacpt3a['v_booleanm'] ;}
				if (   $rowbbuacpt3a['instancem']=='0850A2105' && $rowbbuacpt3a['idfasoutcomecat']==11 && $rowbbuacpt3a['idtype']==147 ) {  $v_BatteryChargerFail_forced_off = $rowbbuacpt3a['v_booleanm'] ;}

				if (   $rowbbuacpt3a['instancem']=='0850890F7' && $rowbbuacpt3a['idfasoutcomecat']==11 && $rowbbuacpt3a['idtype']==148 ) {  $v_DonorAntennaDisconnection_forced_on = $rowbbuacpt3a['v_booleanm'] ;}
				if (   $rowbbuacpt3a['instancem']=='0850890F8' && $rowbbuacpt3a['idfasoutcomecat']==11 && $rowbbuacpt3a['idtype']==148 ) {  $v_DonorAntennaDisconnection_forced_off = $rowbbuacpt3a['v_booleanm'] ;}

				if (   $rowbbuacpt3a['instancem']=='0850E50F9' && $rowbbuacpt3a['idfasoutcomecat']==11 && $rowbbuacpt3a['idtype']==149 ) {  $v_DonorAntennaMalfunction_forced_on = $rowbbuacpt3a['v_booleanm'] ;}
				if (   $rowbbuacpt3a['instancem']=='0850E50FA' && $rowbbuacpt3a['idfasoutcomecat']==11 && $rowbbuacpt3a['idtype']==149 ) {  $v_DonorAntennaMalfunction_forced_off = $rowbbuacpt3a['v_booleanm'] ;}

				if (   $rowbbuacpt3a['instancem']=='0850880FB' && $rowbbuacpt3a['idfasoutcomecat']==11 && $rowbbuacpt3a['idtype']==150 ) {  $v_active_rf_mailfnt_forced_on = $rowbbuacpt3a['v_booleanm'] ;}
				if (   $rowbbuacpt3a['instancem']=='0850880FC' && $rowbbuacpt3a['idfasoutcomecat']==11 && $rowbbuacpt3a['idtype']==150 ) {  $v_active_rf_mailfnt_forced_off = $rowbbuacpt3a['v_booleanm'] ;}

				if (   $rowbbuacpt3a['instancem']=='0850870F5' && $rowbbuacpt3a['idfasoutcomecat']==11 && $rowbbuacpt3a['idtype']==151 ) {  $v_System_Component_Malfunction_forced_on = $rowbbuacpt3a['v_booleanm'] ;}
				if (   $rowbbuacpt3a['instancem']=='0850870F6' && $rowbbuacpt3a['idfasoutcomecat']==11 && $rowbbuacpt3a['idtype']==151 ) {  $v_System_Component_Malfunction_forced_off = $rowbbuacpt3a['v_booleanm'] ;}

				if (   $rowbbuacpt3a['instancem']=='085113114' && $rowbbuacpt3a['idfasoutcomecat']==11 && $rowbbuacpt3a['idtype']==152 ) {  $v_system_high_temp_forced_on = $rowbbuacpt3a['v_booleanm'] ;}
				if (   $rowbbuacpt3a['instancem']=='085113115' && $rowbbuacpt3a['idfasoutcomecat']==11 && $rowbbuacpt3a['idtype']==152 ) {  $v_system_high_temp_forced_off = $rowbbuacpt3a['v_booleanm'] ;}

				if (   $rowbbuacpt3a['instancem']=='10C10D10E' && $rowbbuacpt3a['idfasoutcomecat']==11 && $rowbbuacpt3a['idtype']==155 ) {  $v_BatteryDisconect_forced_on = $rowbbuacpt3a['v_booleanm'] ;}
				if (   $rowbbuacpt3a['instancem']=='0850A2104' && $rowbbuacpt3a['idfasoutcomecat']==11 && $rowbbuacpt3a['idtype']==155 ) {  $v_BatteryDisconect_forced_off = $rowbbuacpt3a['v_booleanm'] ;}

				if (   $rowbbuacpt3a['instancem']=='0850C8112' && $rowbbuacpt3a['idfasoutcomecat']==11 && $rowbbuacpt3a['idtype']==159 ) {  $v_remotecommuerror_forced_on = $rowbbuacpt3a['v_booleanm'] ;}
				if (   $rowbbuacpt3a['instancem']=='0850C8106' && $rowbbuacpt3a['idfasoutcomecat']==11 && $rowbbuacpt3a['idtype']==159 ) {  $v_remotecommuerror_forced_off = $rowbbuacpt3a['v_booleanm'] ;}

			
			}

		if ( count($v_System_Voltage_value ) == 0)
		{
			echo "Missing information";
			exit();
		}
   

?>
<tr>
<td style="text-align: left" >System Voltage</td>
<td style="text-align: center">
<?php if ( $v_System_Voltage_status ==1)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-red">Not Pass</span><?php
}
?></td>
 
<td style="text-align: left">> <?php echo $v_System_Voltage_ref_2_6; ?> V 
&nbsp;
&&nbsp;
< <?php echo $v_System_Voltage_ref_2_7; ?> V</td>
 
<td style="text-align: left"><?php echo $v_System_Voltage_value;?> V</td>

</tr>


<tr>
<td style="text-align: left" >Battery Charger Voltage</td>
<td style="text-align: center"><?php if ( $V_Battery_Charger_Voltage_status ==1)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-red">Not Pass</span><?php
}
?></td>
 
 <td style="text-align: left">> <?php echo $v_System_Voltage_ref_2_6; ?> V 
 &nbsp;
  &&nbsp;
 < <?php echo $v_System_Voltage_ref_2_7; ?> V</td>
 <td style="text-align: left"><?php echo $V_Battery_Charger_Voltage_value;?> V</td>
</tr>

 
 
<tr>
	<td colspan=4> <p class='colorazulfiplex' style='font-size:16px'><br> <b>TEMPERATURE<b> </p></td>
</tr>	
<tr class="thead-dark">
<th style="text-align: left">Measures:</th>
<th style="text-align: center">Status</th>
 
<th style="text-align: left">Reference:</th>
 <th style="text-align: left">Value Readed</th>
</tr>
 
 
<tr>
<td style="text-align: left" >Board Temperature</td>

<td style="text-align: center"><?php if ( $v_Board_Temperature_status ==1)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-red">Not Pass</span><?php
}
?></td>

<td style="text-align: left">> <?php echo $v_Board_Temperature_ref_2_31; ?> °C 
 	 
	  &nbsp;& &nbsp;< <?php echo $v_Board_Temperature_ref_2_15; ?> °C &nbsp;&&nbsp;
  Δ < <?php echo $v_Board_Temperature_ref_2_1; ?> °C</td>
  
   
  <td style="text-align: left"><?php echo $v_Board_Temperature_value ;?> °C</td>
 
</tr>

<tr>
<td style="text-align: left" >External Temperature</td>
<td style="text-align: center"><?php if ( $v_ExternalTemperature_status ==1)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-red">Not Pass</span><?php
}
?></td>
   <td style="text-align: left"> > <?php echo $v_Board_Temperature_ref_2_31; ?> °C 
 &nbsp;&&nbsp;
  < <?php echo $v_Board_Temperature_ref_2_15; ?> °C  &nbsp;&&nbsp; Δ < <?php echo $v_Board_Temperature_ref_2_1; ?> °C </td>
 
 <td style="text-align: left"><?php echo $v_ExternalTemperature_value;?> °C</td>
</tr>

 

<tr>	
	<td colspan=4> <p class='colorazulfiplex' style='font-size:16px'> <br><b>BATTERY CURRENT SENSOR<b> </p></td>
</tr>	

<tr class="thead-dark">
<th style="text-align: left">Measures:</th>
<th style="text-align: center">Status</th>
 
<th style="text-align: left">Reference:</th>
 <th style="text-align: left">Value Readed</th>
</tr>
 
<tr>
<td style="text-align: left" >Battery Current Sensor Voltage</td>
<td style="text-align: center"><?php if ( $v_batt_current_sensor_voltage_status ==1)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-red">Not Pass</span><?php
}
?></td>
 
<td style="text-align: left"><?php echo ($v_batt_current_sensor_voltage_ref_2_0 ); ?>  +/-  <?php echo ($v_batt_current_sensor_voltage_ref_2_1 ); ?> V</td>
 
<td style="text-align: left"><?php echo $v_batt_current_sensor_voltage_value;?> V</td>
</tr>

<tr>
<td style="text-align: left" ><br>Battery Current Sensor Residual Current </td>
<td style="text-align: center"><?php if ( $v_Battery_Current_Sensor_Residual_Current_status ==1)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-red">Not Pass</span><?php
}
?></td>
 
<td style="text-align: left"><?php echo ($v_Battery_Current_Sensor_Residual_Current_ref_2_5 ); ?>  +/-  <?php echo ($v_Battery_Current_Sensor_Residual_Current_ref_2_1 ); ?> mA</td>
 
<td style="text-align: left"><?php echo $v_Battery_Current_Sensor_Residual_Current_value;?> mA</td>
</tr>
 
 
 
 
<tr>
	 
	<td colspan=4> <p class='colorazulfiplex' style='font-size:16px'><br> <b>ALARMS<b> </p></td>
</tr>	

<tr class="thead-dark">
<th style="text-align: left">Measures:</th>
<th style="text-align: center">Status</th>
 
<th style="text-align: center">Forced On</th>
 <th style="text-align: center">Forced Off</th>
</tr>
 
<tr>
<td style="text-align: left" >Normal AC Power</td>
<td style="text-align: center"><?php if ( $v_alarm_normal_ac_power_forced_on ==1 && $v_alarm_normal_ac_power_forced_off==0 )
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-red">Not Pass</span><?php
}
?></td>
 
<td style="text-align: center">
<?php if ( $v_alarm_normal_ac_power_forced_on ==1   )
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
<?php if (   $v_alarm_normal_ac_power_forced_off==0 )
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
<td style="text-align: left" >Loss Normal AC Power</td>
<td style="text-align: center"><?php if ( $v_alarm_lossnormal_ac_power_forced_on ==1 && $v_alarm_lossnormal_ac_power_forced_off ==0)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-red">Not Pass</span><?php
}
?></td>
 
 <td style="text-align: center">
<?php if ( $v_alarm_lossnormal_ac_power_forced_on ==1   )
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
<?php if (   $v_alarm_lossnormal_ac_power_forced_off==0 )
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
<td style="text-align: left" >Battery Charger Fail</td>
<td style="text-align: center"><?php if ( $v_BatteryChargerFail_forced_on ==1 && $v_BatteryChargerFail_forced_off ==0)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-red">Not Pass</span><?php
}
?></td>
 
 <td style="text-align: center">
<?php if ( $v_BatteryChargerFail_forced_on ==1   )
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
<?php if (   $v_BatteryChargerFail_forced_off==0 )
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
<td style="text-align: left" >Donor Antenna Disconnection</td>
<td style="text-align: center"><?php if ( $v_DonorAntennaDisconnection_forced_on ==1 && $v_DonorAntennaDisconnection_forced_off ==0)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-red">Not Pass</span><?php
}
?></td>
 
 <td style="text-align: center">
<?php if ( $v_DonorAntennaDisconnection_forced_on ==1   )
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
<?php if (   $v_DonorAntennaDisconnection_forced_off==0 )
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
<td style="text-align: left" >Donor Antenna Malfunction </td>
<td style="text-align: center"><?php if ( $v_DonorAntennaMalfunction_forced_on ==1 && $v_DonorAntennaMalfunction_forced_off ==0)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-red">Not Pass</span><?php
}
?></td>
 
 <td style="text-align: center">
<?php if ( $v_DonorAntennaMalfunction_forced_on ==1   )
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
<?php if (   $v_DonorAntennaMalfunction_forced_off==0 )
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
<td style="text-align: left" >Active RF Malfunction</td>
<td style="text-align: center"><?php if ( $v_active_rf_mailfnt_forced_on ==1 && $v_active_rf_mailfnt_forced_off ==0)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-red">Not Pass</span><?php
}
?></td>
 
 <td style="text-align: center">
<?php if ( $v_active_rf_mailfnt_forced_on ==1   )
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
<?php if (   $v_active_rf_mailfnt_forced_off==0 )
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
<td style="text-align: left" >System Component Malfunction</td>
<td style="text-align: center"><?php if ( $v_System_Component_Malfunction_forced_on ==1 && $v_System_Component_Malfunction_forced_off ==0)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-red">Not Pass</span><?php
}
?></td>
 
 <td style="text-align: center">
<?php if ( $v_System_Component_Malfunction_forced_on ==1   )
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
<?php if (   $v_System_Component_Malfunction_forced_off==0 )
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
<td style="text-align: left" >System High Temperature </td>
<td style="text-align: center"><?php if ( $v_system_high_temp_forced_on ==1 && $v_system_high_temp_forced_off ==0)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-red">Not Pass</span><?php
}
?></td>
 
 <td style="text-align: center">
<?php if ( $v_system_high_temp_forced_on ==1   )
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
<?php if (   $v_system_high_temp_forced_off==0 )
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
<td style="text-align: left" >Battery Disconnection </td>
<td style="text-align: center"><?php if ( $v_BatteryDisconect_forced_on ==1 && $v_BatteryDisconect_forced_off ==0)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-red">Not Pass</span><?php
}
?></td>
 
 <td style="text-align: center">
<?php if ( $v_BatteryDisconect_forced_on ==1   )
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
<?php if (   $v_BatteryDisconect_forced_off==0 )
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
<td style="text-align: left" >Remote Communication Error  </td>
<td style="text-align: center"><?php if ( $v_remotecommuerror_forced_on ==1 && $v_remotecommuerror_forced_off ==0)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-red">Not Pass</span><?php
}
?></td>
 
 <td style="text-align: center">
<?php if ( $v_remotecommuerror_forced_on ==1   )
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

if (   $v_remotecommuerror_forced_off==0 )
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
 
	 
	<td colspan=4> <p class='colorazulfiplex' style='font-size:16px'><br> <b>LEDS<b> </p></td>
</tr>	

<tr class="thead-dark">
<th style="text-align: left">Measures:</th>
<th style="text-align: center">Status</th>
 
<th style="text-align: center">Forced On</th>
 <th style="text-align: center">Forced Off</th>
</tr>
 
 

<?php
 
 $elsqlvalue4="
		 
 select fas_outcome_integral.*,  instancem , v_boolean::integer as v_booleanm from fas_outcome_integral
 inner join 
 (
	 
 select fas_outcome_integral.id_outcome , instancem
		 from fas_outcome_integral
 inner join 
 (
	 
		 select fas_outcome_integral.id_outcome , instancem
		 from fas_outcome_integral
		 inner join  (
		  
				 select fas_outcome_integral.*  , instancem
				 from fas_outcome_integral 
				 inner join 
				 (
					 select fas_outcome_integral.* ,   instancem
					 from fas_outcome_integral 
					 inner join (
							select iduniqueop, fas_step.instance as instancem
							from fas_routines_process_sn
							inner join fas_routines_steps
							on fas_routines_steps.idstep = fas_routines_process_sn.idstep
							inner join fas_step
							on fas_step.instance = fas_routines_steps.instance
							where idruninfodb = ". $idruninfom."   and iduniqueop > 0
							and 
					  
						 fas_step.instance  in('0850A2105','0850A2104','08509F101','08509F102','0850890F7','0850890F8','0850E50F9','0850E50FA','0850870F5','0850870F6','08509C0FE','08509C0FF')
					 ) as tdosmm
					 on tdosmm.iduniqueop = fas_outcome_integral.reference
						   
				 ) as todosma
				 on fas_outcome_integral.v_bigint =     todosma.reference				 
	  
		 ) as todom2
		 on fas_outcome_integral.reference =     todom2.id_outcome
					 
		 
 
	 ) as todosm3
	 on fas_outcome_integral.reference =     todosm3.id_outcome
 ) as todosm4
 on fas_outcome_integral.reference =     todosm4.id_outcome
 where  idfasoutcomecat= 11  
 
  
	  
		 ";
	////	 echo "<br>a verrrrrr 44444 -----". $elsqlvalue4;
 
		 $sqldscpp4 = $connect->prepare($elsqlvalue4);	 
		 $sqldscpp4->execute();
		 $resultdescmc44a = $sqldscpp4->fetchAll();

		 $v_led_NormalAPower_forced_on="";
		 $v_led_NormalAPower_forced_off="";

		 $v_led_ACFailBatteryActive_forced_on="";
		 $v_led_ACFailBatteryActive_forced_off="";

		 $v_led_BatteryCapacityUnder30forced_on="";				
		 $v_led_BatteryCapacityUnder30forced_off="";	
		 
		 $v_led_BatteryChargerFailforced_on="";	
		 $v_led_BatteryChargerFailforced_off="";	
		 
		 $v_led_DonorAntennaDisconnection_forced_on="";				
		 $v_led_DonorAntennaDisconnection_forced_off="";				

		 $v_led_DonorAntennaMalfunction_forced_on="";				
		 $v_led_DonorAntennaMalfunction_forced_off="";				

		 $v_led_VSWRRFEmitterFail_forced_on="";				
		 $v_led_VSWRRFEmitterFail_forced_off="";			


		 $v_led_SystemComponentFail_forced_on="";				
		 $v_led_SystemComponentFail_forced_off="";				



		 foreach ($resultdescmc44a as $rowbbuacpt4a) 
		 {
			  
			 if (   $rowbbuacpt4a['instancem']=='0850A2105' && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==160 ) {  $v_led_NormalAPower_forced_on = $rowbbuacpt4a['v_booleanm'] ;}
			 if (   $rowbbuacpt4a['instancem']=='0850A2104' && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==160 ) {  $v_led_NormalAPower_forced_off = $rowbbuacpt4a['v_booleanm'] ;}

			 if (   $rowbbuacpt4a['instancem']=='0850A2104' && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==161 ) {  $v_led_ACFailBatteryActive_forced_on = $rowbbuacpt4a['v_booleanm'] ;}
			 if (   $rowbbuacpt4a['instancem']=='0850A2105' && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==161 ) {  $v_led_ACFailBatteryActive_forced_off = $rowbbuacpt4a['v_booleanm'] ;}

			 if (   $rowbbuacpt4a['instancem']=='08509F101' && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==162 ) {  $v_led_BatteryCapacityUnder30forced_on = $rowbbuacpt4a['v_booleanm'] ;}
			 if (   $rowbbuacpt4a['instancem']=='08509F102' && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==162 ) {  $v_led_BatteryCapacityUnder30forced_off = $rowbbuacpt4a['v_booleanm'] ;}

			 if (   $rowbbuacpt4a['instancem']=='0850A2104' && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==163 ) {  $v_led_BatteryChargerFailforced_on = $rowbbuacpt4a['v_booleanm'] ;}
			 if (   $rowbbuacpt4a['instancem']=='0850A2105' && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==163 ) {  $v_led_BatteryChargerFailforced_off = $rowbbuacpt4a['v_booleanm'] ;}

			 if (   $rowbbuacpt4a['instancem']=='0850890F7' && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==164 ) {  $v_led_DonorAntennaDisconnection_forced_on = $rowbbuacpt4a['v_booleanm'] ;}
			 if (   $rowbbuacpt4a['instancem']=='0850890F8' && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==164 ) {  $v_led_DonorAntennaDisconnection_forced_off = $rowbbuacpt4a['v_booleanm'] ;}

			 if (   $rowbbuacpt4a['instancem']=='0850E50F9' && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==165 ) {  $v_led_DonorAntennaMalfunction_forced_on = $rowbbuacpt4a['v_booleanm'] ;}
			 if (   $rowbbuacpt4a['instancem']=='0850E50FA' && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==165 ) {  $v_led_DonorAntennaMalfunction_forced_off = $rowbbuacpt4a['v_booleanm'] ;}

			 if (   $rowbbuacpt4a['instancem']=='0850870F5' && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==166 ) {  $v_led_VSWRRFEmitterFail_forced_on = $rowbbuacpt4a['v_booleanm'] ;}
			 if (   $rowbbuacpt4a['instancem']=='0850870F6' && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==166 ) {  $v_led_VSWRRFEmitterFail_forced_off = $rowbbuacpt4a['v_booleanm'] ;}

			 if (   $rowbbuacpt4a['instancem']=='08509C0FE' && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==167 ) {  $v_led_SystemComponentFail_forced_on = $rowbbuacpt4a['v_booleanm'] ;}
			 if (   $rowbbuacpt4a['instancem']=='08509C0FF' && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==167 ) {  $v_led_SystemComponentFail_forced_off = $rowbbuacpt4a['v_booleanm'] ;}
		 
		 
		 }

?>


<tr>
<td style="text-align: left" >Normal AC Power </td>
<td style="text-align: center"><?php if ( $v_led_NormalAPower_forced_on ==1 && $v_led_NormalAPower_forced_off ==0)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-red">Not Pass</span><?php
}
?></td>
 
 <td style="text-align: center">
<?php if ( $v_led_NormalAPower_forced_on ==1   )
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

if (   $v_led_NormalAPower_forced_off==0 )
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
<td style="text-align: left" >AC Fail Battery Active </td>
<td style="text-align: center"><?php if ( $v_led_ACFailBatteryActive_forced_on ==1 && $v_led_ACFailBatteryActive_forced_off ==0)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-red">Not Pass</span><?php
}
?></td>
 
 <td style="text-align: center">
<?php if ( $v_led_ACFailBatteryActive_forced_on ==1   )
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

if (   $v_led_ACFailBatteryActive_forced_off==0 )
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
<td style="text-align: left" >Battery Capacity Under 30% </td>
<td style="text-align: center"><?php if ( $v_led_BatteryCapacityUnder30forced_on ==1 && $v_led_BatteryCapacityUnder30forced_off ==0)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-red">Not Pass</span><?php
}
?></td>
 
 <td style="text-align: center">
<?php if ( $v_led_BatteryCapacityUnder30forced_on ==1   )
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

if (   $v_led_BatteryCapacityUnder30forced_off==0 )
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
<td style="text-align: left" >Battery Charger Fail </td>
<td style="text-align: center"><?php if ( $v_led_BatteryChargerFailforced_on ==1 && $v_led_BatteryChargerFailforced_off ==0)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-red">Not Pass</span><?php
}
?></td>
 
 <td style="text-align: center">
<?php if ( $v_led_BatteryChargerFailforced_on ==1   )
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

if (   $v_led_BatteryChargerFailforced_off==0 )
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
<td style="text-align: left" >Donor Antenna Disconnection
 </td>
<td style="text-align: center"><?php if ( $v_led_DonorAntennaDisconnection_forced_on ==1 && $v_led_DonorAntennaDisconnection_forced_off ==0)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-red">Not Pass</span><?php
}
?></td>
 
 <td style="text-align: center">
<?php if ( $v_led_DonorAntennaDisconnection_forced_on ==1   )
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

if (   $v_led_DonorAntennaDisconnection_forced_off==0 )
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
<td style="text-align: left" >Donor Antenna Malfunction  </td>
<td style="text-align: center"><?php if ( $v_led_DonorAntennaMalfunction_forced_on ==1 && $v_led_DonorAntennaMalfunction_forced_off ==0)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-red">Not Pass</span><?php
}
?></td>
 
 <td style="text-align: center">
<?php if ( $v_led_DonorAntennaMalfunction_forced_on ==1   )
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

if (   $v_led_DonorAntennaMalfunction_forced_off==0 )
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
<td style="text-align: left" >RF Emitter Fail   </td>
<td style="text-align: center"><?php if ( $v_led_VSWRRFEmitterFail_forced_on ==1 && $v_led_VSWRRFEmitterFail_forced_off ==0)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-red">Not Pass</span><?php
}
?></td>
 
 <td style="text-align: center">
<?php if ( $v_led_VSWRRFEmitterFail_forced_on ==1   )
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

if (   $v_led_VSWRRFEmitterFail_forced_off==0 )
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
<td style="text-align: left" >System Component Fail  </td>
<td style="text-align: center"><?php if ( $v_led_SystemComponentFail_forced_on ==1 && $v_led_SystemComponentFail_forced_off ==0)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-red">Not Pass</span><?php
}
?></td>
 
 <td style="text-align: center">
<?php if ( $v_led_SystemComponentFail_forced_on ==1   )
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

if (   $v_led_SystemComponentFail_forced_off==0 )
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


  
<tr colspan=4><td><br></td> </tr>
<tr>
<th colspan=4 style="text-align: left">
<h5 style="text-decoration: underline;font-size:18px "><br>Power Stress: </h5>
</th>
</tr>
</table>
			
			 </div> 
			 <br><br><br><br><br>

<div name="divallgraphstress" id="divallgraphstress" class='divallgraphstress'>
	 
  <div class="container-fluid " id="divgrafico700mp" name="divgrafico700mp" >
     
       <div class="col-12">
       <hr style=" border: 1px solid #007bff;">
       <div class="col-12   " id="divgraf_current_pwr" name="divgraf_current_pwr">
             
             <div class="chart">
               <canvas id="graf_current_pwr" height="280" style="height: 280;"></canvas>
             </div>
         </div>

         <div class="row"> 

		 <div class="col-12   " id="divgraf_current_read" name="divgraf_current_read">
          
		  <div class="chart">
			<canvas id="graf_current_read" height="280" style="height: 280;" ></canvas>
		  </div>
	</div>

		
		 <div class="col-12    " id="divgraf_volt_readsepa" name="divgraf_volt_readsepa">
          
			<div class="chart">
				<canvas id="graf_volt_readsepa" height="280" style="height: 280;"></canvas>
			</div>
      	</div>
	

         <div class="col-12    " id="divgraf_volt_read" name="divgraf_volt_read">
          
			<div class="chart">
				<canvas id="graf_volt_read" height="280" style="height: 280;"></canvas>
			</div>
      	</div>

		  <div class="col-12    " id="divgraf_volt_read2" name="divgraf_volt_read2">
          
			<div class="chart">
				<canvas id="graf_volt_read2" height="280" style="height: 280;"></canvas>
			</div>
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
          url: 'ajax_graph_reportstressbbuhp.php?unitsn='+params.get('unitsn')+'&idrun='+params.get('idrun'),
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
			   var graf_volt_readsepa = $('#graf_volt_readsepa').get(0).getContext('2d'); 
               var graf_volt_read   = $('#graf_volt_read').get(0).getContext('2d'); 
			   var graf_volt_read2   = $('#graf_volt_read2').get(0).getContext('2d'); 
                var graf_current_pwr  = $('#graf_current_pwr').get(0).getContext('2d'); 
  

            

                          datos_values_pacurrent_voltread = data.values_pacurrent_voltread.split(",");  
                          datos_values_pacurrent_system_volt = data.values_System_Voltage.split(",");  
						  datos_values_pacurrent_battery1 = data.values_Battery_Voltage_1.split(",");  
						  datos_values_pacurrent_battery2 = data.values_Battery_Voltage_2.split(",");  
						  datos_values_pacurrent_battery3 = data.values_Battery_Voltage_3.split(",");  
						  datos_values_pacurrent_battery4 = data.values_Battery_Voltage_4.split(",");  

                          label_values_pacurrent_voltread = data.label_pacurrent_voltread.split(",");
                          
                          
                          datos_values_pacurrent_read = data.values_pacurrent_read.split(",");  
                          datos_values_pacurrent_readsensor =  data.values_Battery_Current_Sensor_Current.split(",");  
						  datos_values_pacurrent_batterycharger = data.values_Battery_Charger_Current.split(","); 

                          label_values_pacurrent_read = data.label_pacurrent_read.split(",");  

                          datos_values_pacurrent_pwr = data.values_pacurrent_pwr.split(",");  
                          label_values_pacurrent_pwr = data.label_pacurrent_pwr.split(",");  

						  for ( var i = 0, j = datos_values_pacurrent_battery1.length ; i < j; i++ ) {
                              if ( datos_values_pacurrent_battery1[ i ] == '' ) {
                                datos_values_pacurrent_battery1.splice( i, 1 );
                              i--;
                              }
                            }

							for ( var i = 0, j = datos_values_pacurrent_battery2.length ; i < j; i++ ) {
                              if ( datos_values_pacurrent_battery2[ i ] == '' ) {
                                datos_values_pacurrent_battery2.splice( i, 1 );
                              i--;
                              }
                            }

							for ( var i = 0, j = datos_values_pacurrent_battery3.length ; i < j; i++ ) {
                              if ( datos_values_pacurrent_battery3[ i ] == '' ) {
                                datos_values_pacurrent_battery3.splice( i, 1 );
                              i--;
                              }
                            }

							for ( var i = 0, j = datos_values_pacurrent_battery4.length ; i < j; i++ ) {
                              if ( datos_values_pacurrent_battery4[ i ] == '' ) {
                                datos_values_pacurrent_battery4.splice( i, 1 );
                              i--;
                              }
                            }

                            for ( var i = 0, j = datos_values_pacurrent_voltread.length ; i < j; i++ ) {
                              if ( datos_values_pacurrent_voltread[ i ] == '' ) {
                                datos_values_pacurrent_voltread.splice( i, 1 );
                              i--;
                              }
                            }

                            for ( var i = 0, j = datos_values_pacurrent_system_volt.length ; i < j; i++ ) {
                              if ( datos_values_pacurrent_system_volt[ i ] == '' ) {
                                datos_values_pacurrent_system_volt.splice( i, 1 );
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

						 
							for ( var i = 0, j = datos_values_pacurrent_batterycharger.length ; i < j; i++ ) {
                              if ( datos_values_pacurrent_batterycharger[ i ] == '' ) {
                                datos_values_pacurrent_batterycharger.splice( i, 1 );
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
					   var datos_grafico_allband_temp_sep = {
                                        labels  : nuevolabeltemp_0_0_temp,
                                                datasets: [
                                                {
                                                  label               :  'LOAD Voltage  ',
                                                    backgroundColor     : 'rgba(60,141,188,0.1)',
                                                    borderColor         : 'rgba(60,141,188,1)',
                                                    pointRadius          : false,
                                                    pointColor          : '#3b8bba',
                                                    pointStrokeColor    : 'rgba(60,141,188,1)',
                                                    pointHighlightFill  : '#fff',
                                                    pointHighlightStroke: 'rgba(60,141,188,1)',
                                                  data                :  datos_values_pacurrent_voltread                                
                                                  } 
												   
                                                  
                                                
                                          ]
                                        };

                                   var datos_grafico_allband_temp = {
                                        labels  : nuevolabeltemp_0_0_temp,
                                                datasets: [                                             
                                                  {
                                                  label               :  'System Voltage  ',
                                                  backgroundColor     : 'rgba(255, 99, 132, 0.5)',
                                                  borderColor         : 'rgba(255, 99, 132, 1)',
                                                  pointRadius         : false,
                                                  pointColor          : 'rgba(255, 99, 132, 1)',
                                                  pointStrokeColor    : '#c1c7d1',
                                                  pointHighlightFill  : '#fff',
                                                  pointHighlightStroke: 'rgba(255, 99, 132, 1)',		
                                                  data                :  datos_values_pacurrent_system_volt
                                                  }
												   
                                                  
                                                
                                          ]
                                        };
										
										var datos_grafico_allband_temp2 = {
                                        labels  : nuevolabeltemp_0_0_temp,
                                                datasets: [                                               
                                                  {
                                                  label               :  'Battery Voltage 1   ',
                                                  backgroundColor     : 'rgba(72, 176, 106, 0.5)',
                                                  borderColor         : 'rgba(72, 176, 106, 1)',
                                                  pointRadius         : false,
                                                  pointColor          : 'rgba(72, 176, 106, 1)',
                                                  pointStrokeColor    : '#c1c7d1',
                                                  pointHighlightFill  : '#fff',
                                                  pointHighlightStroke: 'rgba(72, 176, 106, 1)',		
                                                  data                :  datos_values_pacurrent_battery1
                                                  },
                                                  {
                                                  label               :  'Battery Voltage 2   ',
                                                  backgroundColor     : 'rgba(255, 255, 0, 0.5)',
                                                  borderColor         : 'rgba(255, 255, 0, 1)',
                                                  pointRadius         : false,
                                                  pointColor          : 'rgba(255, 255, 0, 1)',
                                                  pointStrokeColor    : '#c1c7d1',
                                                  pointHighlightFill  : '#fff',
                                                  pointHighlightStroke: 'rgba(255, 255, 0, 1)',		
                                                  data                :  datos_values_pacurrent_battery2
                                                  },
                                                  {
                                                  label               :  'Battery Voltage 3  ',
                                                  backgroundColor     : 'rgba(178, 102, 255, 0.5)',
                                                  borderColor         : 'rgba(178, 102, 255, 1)',
                                                  pointRadius         : false,
                                                  pointColor          : 'rgba(178, 102, 255, 1)',
                                                  pointStrokeColor    : '#c1c7d1',
                                                  pointHighlightFill  : '#fff',
                                                  pointHighlightStroke: 'rgba(178, 102, 255, 1)',		
                                                  data                :  datos_values_pacurrent_battery3
                                                  },
                                                  {
                                                  label               :  'Battery Voltage  4  ',
                                                  backgroundColor     : 'rgba(102,0,51, 0.5)',
                                                  borderColor         : 'rgba(102,0,51, 1)',
                                                  pointRadius         : false,
                                                  pointColor          : 'rgba(102,0,51, 1)',
                                                  pointStrokeColor    : '#c1c7d1',
                                                  pointHighlightFill  : '#fff',
                                                  pointHighlightStroke: 'rgba(102,0,51, 1)',		
                                                  data                :  datos_values_pacurrent_battery4
                                                  }
                                                  
                                                
                                          ]
                                        };
                                        var datos_grafico_pacurrent_read = {
                                        labels  : nuevolabeltemp_0_0_temp,
                                                datasets: [
                                                {
                                                  label               :  'LOAD Current',
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
                                                  label               :  'Battery Current Sensor  ',
                                                  backgroundColor     : 'rgba(255, 99, 132, 0.5)',
                                                  borderColor         : 'rgba(255, 99, 132, 1)',
                                                  pointRadius         : false,
                                                  pointColor          : 'rgba(255, 99, 132, 1)',
                                                  pointStrokeColor    : '#c1c7d1',
                                                  pointHighlightFill  : '#fff',
                                                  pointHighlightStroke: 'rgba(255, 99, 132, 1)',		
                                                  data                :  datos_values_pacurrent_readsensor                                
                                                  },
                                                  {
                                                  label               :  'Battery Charger Current  ',
                                                  backgroundColor     : 'rgba(0, 153,0, 0.5)',
                                                  borderColor         : 'rgba(0, 153,0, 1)',
                                                  pointRadius         : false,
                                                  pointColor          : 'rgba(0, 153,0, 1)',
                                                  pointStrokeColor    : '#c1c7d1',
                                                  pointHighlightFill  : '#fff',
                                                  pointHighlightStroke: 'rgba(0, 153,0, 1)',		
                                                  data                :  datos_values_pacurrent_batterycharger                                
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

										var optiontemp2 = {                             
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
                                
                                                suggestedMin: 0,
                                                 suggestedMax: 20
                                              }
                                        
                                          
                                            }]
                                          }
                                        }

                      var rpt_grafico700imdstress01 = new Chart(graf_volt_read, { 
                              type: 'line', 	
                              data: datos_grafico_allband_temp, 	 
                              options: optiontemp 
                            });

							var rpt_grafico700imdstress01separ = new Chart(graf_volt_readsepa, { 
                              type: 'line', 	
                              data: datos_grafico_allband_temp_sep, 	 
                              options: optiontemp 
                            });
		

							var rpt_grafico700imdstress012 = new Chart(graf_volt_read2, { 
                              type: 'line', 	
                              data: datos_grafico_allband_temp2, 	 
                              options: optiontemp2 
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

<!DOCTYPE html>
<?php 

// Desactivar toda notificación de error
///error_reporting(0);
// Notificar todos los errores de PHP (ver el registro de cambios)
//error_reporting(E_ALL);
 include("db_conectbypdf.php"); 
 
 
 	session_start();
	
 
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
        color: #ffffff;
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
	$idruninfomreq = $_REQUEST['idrun']; ///// " ";	
	$idr = $_REQUEST['idr']; ///// " ";	

?>
                    <section class="content">

                        <div class="container-fluid"><br>
                            <div class="row">

                                <section class="col-lg-12 connectedSortable ui-sortable">
                                    <div class="rowmm fondoblanco">

                                        <div class="col-lg-12">

                                            <!-- inicio cuadro resumen  --->
                                            <?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				   ///// *********************** Init SEARCH FIRMWARE
	 /*
DiB 446
[04D0B5][10702013946][0,8]        FPGA
[04D0B5][10702013946][0,9]     uC
[04D0B5][10702013946][0,10]     Rabbit

 

FiP 519
[04D0B6][10702013948][0,9]        uC FW
[04D0B6][10702013948][0,36]    HW
	 */
	 ////// FW uC:9
	
	 
$v_so="";
$_ciu="";
$_userfas="";
$_Fw_uC="";
$_Fw_fpga="";
$$_Fw_eth="";
$fas_version="";
$descriptionmm="";
	 ///// *********************** END SEARCH FIRMWARE
	 $sqlnvosearfw="select * from fas_outcome_integral
	 where reference in (
	 select id_outcome 
	 from fas_outcome_integral
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
	 where sn = '".$vparam_vnrounitsn."' and fas_step.description = 'GF_checkFWsDiB'
	  and idruninfodb =".$idr." )
		 ) and idfasoutcomecat = 0 
		 
		 
		 ";

		 $sqlnvosearfw="select * from fas_outcome_integral
		 where reference in (
		 select id_outcome 
		 from fas_outcome_integral
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
		 where sn = '".$vparam_vnrounitsn."' and fas_step.description = 'GF_checkFWsDiB'
		  and idruninfodb =".$idr." )
			 ) and idfasoutcomecat = 0 
		union 
		select * from fas_outcome_integral
		where reference in ( 
			select iduniqueop from ( 
									select * from fnt_select_allfas_routines_process_sn_maxrev('".$vparam_vnrounitsn."') as dd
								   ) as fas_routines_process_sn 
				inner join fas_routines_steps on fas_routines_steps.idstep = fas_routines_process_sn.idstep 
				inner join fas_step on fas_step.instance = fas_routines_steps.instance 
				where sn = '".$vparam_vnrounitsn."' and fas_step.description = 'GF_checkFWsDiB' and idruninfodb =".$idr."  )
		and idfasoutcomecat = 0
		  
			 
			 ";

	///	 echo $sqlnvosearfw;
		 $sqlnewfw = $connect->prepare($sqlnvosearfw);
 
	 
		 $sqlnewfw->execute();
		 $resulnerfwww = $sqlnewfw->fetchAll();
		 foreach ($resulnerfwww as $rownewfwww) 
			 {

                ////echo $v_dib_0_5." - ".$v_dib_0_6." - R:".$v_dib_0_30." - B:".$v_dib_0_38;      
				if( $rownewfwww['idtype'] ==9)
				{
				   $_Fw_uC=$rownewfwww['v_string'];
				}
				 ////// FW EthuC:10
				 if( $rownewfwww['idtype'] ==10)
				 {
					$_Fw_eth=$rownewfwww['v_string'];
				 }
				  ////// FW FPGA:8
				if( $rownewfwww['idtype'] ==8)
				{
				   $_Fw_fpga=$rownewfwww['v_string'];
				}

				 
				 
			 }
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////			 
$sqlnvosearfw="select * from fas_outcome_integral
where reference in (
select id_outcome 
from fas_outcome_integral
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
where sn = '".$vparam_vnrounitsn."' and fas_step.description = 'GF_checkFWsFiP'
 and idruninfodb =".$idr." )
	) and idfasoutcomecat = 0
	union 

	  
	select * from fas_outcome_integral
	where reference in ( 
		select iduniqueop from ( 
								select * from fnt_select_allfas_routines_process_sn_maxrev('".$vparam_vnrounitsn."') as dd
							   ) as fas_routines_process_sn 
			inner join fas_routines_steps on fas_routines_steps.idstep = fas_routines_process_sn.idstep 
			inner join fas_step on fas_step.instance = fas_routines_steps.instance 
			where sn = '".$vparam_vnrounitsn."' and fas_step.description = 'GF_checkFWsFiP' and idruninfodb =".$idr."  )
	and idfasoutcomecat = 0

	";

	//echo $sqlnvosearfw;
	$sqlnewfw = $connect->prepare($sqlnvosearfw);


	$sqlnewfw->execute();
	$resulnerfwww = $sqlnewfw->fetchAll();
	foreach ($resulnerfwww as $rownewfwww) 
		{
		   if( $rownewfwww['idtype'] ==9)
		   {
			  $_Fw_fip519_uc=$rownewfwww['v_string'];
		   }
			////// FW HW Version
			if( $rownewfwww['idtype'] ==36)
			{
			   $_Fw_fip519_hw =$rownewfwww['v_string'];
			}
		 

			
			
		}
///////////////////////////////////////////////////////////////////////////////////////////////		
		 
 
	 
 
					$sql = $connect->prepare("select fas_outcome_integral.* , fasoutcometypename from fas_outcome_integral
					inner join fas_outcome_category_type
					on  fas_outcome_category_type.idfasoutcomecat	=	fas_outcome_integral.idfasoutcomecat and
						fas_outcome_category_type.idtype			=	fas_outcome_integral.idtype
					where fas_outcome_integral.reference in ( 
						select reference from fnt_select_maxidrun_fas_outcome_integral_byidscrip('".$vparam_vnrounitsn."',62) 
 							)
								 ");

/// $sql->bindParam(':vvidsndib', $vparam_vnrounitsn);
$sql->execute();
$resultado3 = $sql->fetchAll();


foreach ($resultado3 as $row2) 
{
	////// SO : 2
	$v_datetimeidrun=$row2['datetimeref'];
	$idruninfom = $row2['reference'];
	 if( $row2['idtype'] ==2 and $row2['idfasoutcomecat'] == 0)
	 {
		$v_so=$row2['v_string'];
	 }
	 ////// CIU:3
	 if( $row2['idtype'] ==3 and $row2['idfasoutcomecat'] == 0)
	 {
		$_ciu=$row2['v_string'];
	 }
	 ////// userFAS:16
	 if( $row2['idtype'] ==16)
	 {
		$_userfas=$row2['v_string'];
	 }
	

	 //////FasVersion: 7 
	 if( $row2['idtype'] ==7)
	 {
		$fas_version=$row2['v_string'];
	 }

     if( $row2['idtype'] ==57)
	 {
		$_fw_version0_57=$row2['v_string'];
	 }
     if( $row2['idtype'] ==36)
	 {
		$_fw_version0_36=$row2['v_string'];
	 }
     if( $row2['idtype'] ==37)
	 {
		$_fw_version0_37=$row2['v_string'];
	 }
     if( $row2['idtype'] ==49)
	 {
		$_fw_version0_49=$row2['v_string'];
	 }

	 if( $row2['idtype'] ==36)
	 {
		$fas_hw_version=$row2['v_string'];
	 }

	 if( $row2['idtype'] ==5)
	 {
		
		$Fip_DiBCIU_0_5=$row2['v_string'];
		
	 }

     if( $row2['idtype'] ==6)
	 {
		
		$SNFip_DiBCIU_0_6=$row2['v_string'];
		
	 }

     if( $row2['idtype'] ==41)
	 {
		
		$battery_charger_0_41=$row2['v_string'];
		
	 }
     if( $row2['idtype'] ==30)
	 {
		
		$v_dib_0_30=$row2['v_integer'];
		
	 }
     if( $row2['idtype'] ==38)
	 {
		
		$v_dib_0_38=$row2['v_integer'];
		
	 }
    


	 if( $row2['idtype'] ==48)
	 {
		
		$battery_current_sensor=$row2['v_string'];
			$sqldscbatt = $connect->prepare("select * from fnt_select_allproducts_maxrev() where   modelciu = '".$battery_current_sensor."' ");
			$sqldscbatt->execute();
			$resultdescbatt = $sqldscbatt->fetchAll();
			foreach ($resultdescbatt as $rowdesbattc) 
			{
				$Temperature_Sensor_0_48 = $rowdesbattc['description'];
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
		$sqldscpp = $connect->prepare("select * from orders_sn where idproduct = ".$vvidprod." and    wo_serialnumber = '".$vparam_vnrounitsn."' and typeregister = 'WO' ");
 
	 
			$sqldscpp->execute();
			$resultdescmc = $sqldscpp->fetchAll();
			foreach ($resultdescmc as $rowdescmm) 
				{
					$v_so_soft_external=$rowdescmm['so_soft_external'];
					
				}
 
}

?>
                                            <br>
                        <!-- Init  TABLE INFO SKU SN WO SO -->
                                            <table
                                                class="table table-sm table-hover table-striped table-bordered text-center textotabla10">
                                                <tr>
                                                    <td colspan="3" class="table-dark "> </td>

                                                </tr>
                                                <tr>
                                                    <td colspan="3" class="  text-center"><br>
                                                        <h4><b> REPORT NG BBU<b></h4>
                                                    </td>


                                                </tr>
                                                <tr>
                                                    <td style='text-align: left'>MFG: 
                                                        <strong><?php echo $v_so_soft_external;?></strong>
                                                    </td>
                                                   
                                                </tr>
                                                <tr>
                                                    <td style='text-align: left'>CIU:
                                                        <strong><?php echo $_ciu;?></strong>
                                                    </td>
                                                    </tr>
                                                <tr>
                                                    <td style='text-align: left'>SN:
                                                        <strong><?php echo $vparam_vnrounitsn;?></strong>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td colspan="2" style='text-align: left'>DESCRIPTION: <b>
                                                            <?php echo $descriptionmm ; ?></b>
                                                    </td>
                                                </tr>

                                            </table>

                    <!-- END  TABLE INFO SKU SN WO SO -->
                    <!-- TABLE init RUN -->
                                            <table
                                                class="table table-sm table-hover table-striped table-bordered text-center textotabla10">
                                                <tr>
                                                    <td style='width: 20%;text-align: left'>Calibrator:
                                                        <strong><?php echo $_userfas;?></strong>
                                                    </td>
                                                    <td style='width: 20%;text-align: left'>Datime:
                                                        <strong><?php echo substr($v_datetimeidrun,0,21);?></strong>
                                                    </td>
                                                    <td style='width: 20%;text-align: left'>FAS Version:
                                                        <strong><?php echo 	$fas_version;?></strong>
                                                        </td>
                                                        <td style='width: 20%;text-align: left'>    
                                                    RunInfo: # <strong><?php if ($idruninfomreq=="") { 
	echo $idruninfom;
} else {
	echo $idruninfomreq;

} ?></strong></td>
                                                </tr>
                    <!-- TABLE End RUN -->
                    <!-- TABLE init Componentes -->
</table>
                     <table
                     class="table table-sm table-hover table-striped table-bordered text-center textotabla10">
                                                <tr>
                                                    <td style='text-align: left'>DiB:  <strong>
                                                    <?php echo $Fip_DiBCIU_0_5." - ".$SNFip_DiBCIU_0_6." - R:".$v_dib_0_30." - B:".$v_dib_0_38;      ?>
                                                     </strong>
                                                     </td>
                                                    

                                                </tr>
                                                <tr>
                                                    <td style='text-align: left'> Battery Charger: <strong>
                                                   <?php echo  $battery_charger_0_41;?>   </strong>
                                                    </td>
                                                  
                                                </tr>

                                                <tr>

                                                    <td style='text-align: left'>Temperature Sensor: <strong>
                                                    <?php echo  $Temperature_Sensor_0_48;?>     </strong></td>
                                               

                                                </tr>


                                            </table>
                                         
                                            <table
                                                class="table table-sm table-hover table-striped table-bordered text-center textotabla10">
                                                <tr>
                                                    <td style='width: 20%;text-align: left'>FW Version:
                                                    
                                                   
                                                    <strong><?php echo $_fw_version0_57;?></strong>
                                                    </td>
                                                    <td style='width: 20%;text-align: left'>HW Version:
                                                      
                                                         
                                                   <strong><?php echo $_fw_version0_36; ?></strong></td>
                                                </tr>
                                                <tr>
                                                    <td style='width: 20%;text-align: left'>FW Name:
                                                    
                                                 
                                                   <strong><?php echo $_fw_version0_49; ?></strong>
                                                    </td>
                                                    <td style='width: 20%;text-align: left'>HW Name:
                                                      
                                                  <strong><?php echo $_fw_version0_37; ?></strong></td>
                                                </tr>
                   
</table>
                                            <?php
						 
					//////////////////////////////////////////	 


						 ?>


                                            <table
                                                class="table table-sm table-hover table-striped table-bordered text-center textotabla10">
                                                <tbody>
                                                  
                                                    <tr>
                                                        <td colspan=4>
                                                            <p class='colorazulfiplex' style='font-size:16px'>
                                                                <br><b>SYSTEM STATUS*<b>
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    <tr class="thead-dark">
                                                        <th style="text-align: left">Measurement:</th>
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
												fas_step.instance  in('11B11C11D' )											 
											)
										)
								)	
				)
				and  idfasoutcomecat in (11,5) and idtype in (201,202,204,203,200,207,101,102,11,100,141,140)
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
								fas_step.instance  in('11B11C11D' )
										) 
				) and  idfasoutcomecat= 2 and idtype in (63,65,6,17,44,64,66,7,61,1,31)
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
						fas_step.instance  in('11B11C11D')
					) as lostotalpass
					inner join fas_outcome_integral
					on fas_outcome_integral.reference = lostotalpass.iduniqueop


			";

			$elsqlvaluetemp="
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
												fas_step.instance  in('0DC')											 
											)
										)
								)	
				)
				and  idfasoutcomecat in (11,5) and idtype in (201,202,204,203,200,207,101,102,11,100,27,199)
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
								fas_step.instance  in('0DC')
										) 
				) and  idfasoutcomecat= 2 and idtype in (63,65,6,17,44,64,66,7,61,1,31,15)
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
						fas_step.instance  in('0DC')
					) as lostotalpass
					inner join fas_outcome_integral
					on fas_outcome_integral.reference = lostotalpass.iduniqueop


			";

			$elsqlvalue3="
		
			select fas_outcome_integral.*,  instancem , v_boolean::integer as v_booleanm 
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
			 
				   fas_step.instance  in('0850A2104','0850A2105','085117118','085117119','0850C8112','0850C8106','122123')	
				) as tdosmm
			on tdosmm.iduniqueop = fas_outcome_integral.reference

			union				
			select fas_outcome_integral.*,  instancem , v_boolean::integer as v_booleanm 
			from fas_outcome_integral
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
								 
									   fas_step.instance  in('0850A2104','0850A2105','085117118','085117119','0850C8112','0850C8106')	
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
			where  idfasoutcomecat in(11)  and idtype in (0,58,7,12,21,97,140,141,144,145,147,155,154)
			
			 
				 
					";
			///		echo "eeeeeee".$elsqlvalue."<br><br>";
			
			//			fas_step.instance  in('0850A2104','0850A2105','085117118','085117119','0850C8112','0850C8106')		
				
	//		$elsqlvalue="select * from fas_outcome_integral limit 10  ";
	 	//	$sqlSystemVoltage = $connect->prepare($elsqlvalue);
		//	echo "<hr><br>SYSTEM STATUS:<br>".$elsqlvalue."<br><br>";

			
		$v_VSYS_status="";
		$v_VSYS_ref_2_63="";
		$v_VSYS_ref_2_64 ="";
		$v_VSYS_value_11_202 ="";

		$v_VIN_status="";
		$v_VIN_ref_2_63="";
		$v_VIN_ref_2_64 ="";
		$v_VIN_value_11_201 ="";

		
		$v_VBANK_status ="";
		$v_VBANK_ref_2_6 ="";
		$v_VBANK_ref_2_7 ="";
		$v_VBANK_value_11_207 ="";

		$v_IIN_status="";
		$v_IIN_ref_2_65="";
		$v_IIN_ref_2_66 ="";
		$v_IIN_value_11_204 ="";

		$v_VBAT_status ="";
		$v_VBAT_ref_2_6 ="";
		$v_VBAT_ref_2_7 ="";
		$v_VBAT_value_11_200 ="";

		$v_IBAT_status ="";
		$v_IBAT_ref_2_17 ="";		
		$v_IBAT_value_11_203 ="";

		$v_VBAT1_status ="";
		$v_VBAT1_ref_2_44 ="";		
		$v_VBAT1_ref_2_61 ="";		
		$v_VBAT1_value_5_101 ="";
        $v_VBAT1_value_11_140="";
		
		$v_VBAT2_status ="";
		$v_VBAT2_ref_2_44 ="";		
		$v_VBAT2_ref_2_61 ="";		
		$v_VBAT2_value_5_102 ="";
        $v_VBAT2_value_11_141="";

		$v_Alarm_boardtemp_status="";
		$v_Alarm_boardtemp_2_31="";
		$v_Alarm_boardtemp_2_15="";
		$v_Alarm_boardtemp_2_1="";
		$v_Alarm_boardtemp_value_5_11="";
        $v_Alarm_boardtemp_value_11_27="";
        
		$v_Alarm_batterytemp_status="";
		$v_Alarm_batterytemp_2_31="";
		$v_Alarm_batterytemp_2_15="";
		$v_Alarm_batterytemp_2_1="";
		$v_Alarm_batterytemp_value_5_100="";
        $v_Alarm_batterytemp_value_11_199="";

			$sqldscpp = $connect->prepare($elsqlvalue);	 
			$sqldscpp->execute();
			$resultdescmc = $sqldscpp->fetchAll();
			foreach ($resultdescmc as $rowbbuacpt) 
				{
									
                    
                 //   echo  "<br>-cat".$rowbbuacpt['idfasoutcomecat']." --idtype: ".$rowbbuacpt['idtype']."-valorr-".$rowbbuacpt['v_double'];

					if (   $rowbbuacpt['instancem']=='11B11C11D' && $rowbbuacpt['idfasoutcomecat']==1 && $rowbbuacpt['idtype']==0 ) {    $v_VSYS_status= $rowbbuacpt['v_boolean'];    }	
					if ( $rowbbuacpt['idfasoutcomecat']==2 && $rowbbuacpt['idtype']==63 ) { $v_VSYS_ref_2_63= $rowbbuacpt['v_double']; }	
					if ( $rowbbuacpt['idfasoutcomecat']==2 && $rowbbuacpt['idtype']==64 ) { $v_VSYS_ref_2_64= $rowbbuacpt['v_double']; }	
					if ( $rowbbuacpt['idfasoutcomecat']==11 && $rowbbuacpt['idtype']==202 ) {    $v_VSYS_value_11_202= $rowbbuacpt['v_double']; }	

					if (   $rowbbuacpt['instancem']=='11B11C11D' && $rowbbuacpt['idfasoutcomecat']==1 && $rowbbuacpt['idtype']==0 ) {    $v_VIN_status= $rowbbuacpt['v_boolean'];    }	
					if ( $rowbbuacpt['idfasoutcomecat']==2 && $rowbbuacpt['idtype']==63 ) { $v_VIN_ref_2_63= $rowbbuacpt['v_double']; }	
					if ( $rowbbuacpt['idfasoutcomecat']==2 && $rowbbuacpt['idtype']==64 ) { $v_VIN_ref_2_64= $rowbbuacpt['v_double']; }	
					if ( $rowbbuacpt['idfasoutcomecat']==11 && $rowbbuacpt['idtype']==201 ) { $v_VIN_value_11_201= $rowbbuacpt['v_double']; }	

					if (   $rowbbuacpt['instancem']=='11B11C11D' && $rowbbuacpt['idfasoutcomecat']==1 && $rowbbuacpt['idtype']==0 ) {    $v_IIN_status = $rowbbuacpt['v_boolean'];    }	
					if ( $rowbbuacpt['idfasoutcomecat']==2 && $rowbbuacpt['idtype']==65 ) { $v_IIN_ref_2_65= $rowbbuacpt['v_double']; }	
					if ( $rowbbuacpt['idfasoutcomecat']==2 && $rowbbuacpt['idtype']==66 ) { $v_IIN_ref_2_66= $rowbbuacpt['v_double']; }	
					if ( $rowbbuacpt['idfasoutcomecat']==11 && $rowbbuacpt['idtype']==204 ) { $v_IIN_value_11_204= $rowbbuacpt['v_double']; }	

					if (   $rowbbuacpt['instancem']=='11B11C11D' && $rowbbuacpt['idfasoutcomecat']==1 && $rowbbuacpt['idtype']==0 ) {    $v_VBANK_status = $rowbbuacpt['v_boolean'];    }	
					if ( $rowbbuacpt['idfasoutcomecat']==2 && $rowbbuacpt['idtype']==6 ) { $v_VBANK_ref_2_6= $rowbbuacpt['v_double']; }	
					if ( $rowbbuacpt['idfasoutcomecat']==2 && $rowbbuacpt['idtype']==7 ) { $v_VBANK_ref_2_7= $rowbbuacpt['v_double']; }	
					if ( $rowbbuacpt['idfasoutcomecat']==11 && $rowbbuacpt['idtype']==207 ) { $v_VBANK_value_11_207= $rowbbuacpt['v_double']; }	

					if (   $rowbbuacpt['instancem']=='11B11C11D' && $rowbbuacpt['idfasoutcomecat']==1 && $rowbbuacpt['idtype']==0 ) {    $v_VBAT_status = $rowbbuacpt['v_boolean'];    }	
					if ( $rowbbuacpt['idfasoutcomecat']==2 && $rowbbuacpt['idtype']==6 ) { $v_VBAT_ref_2_6= $rowbbuacpt['v_double']; }	
					if ( $rowbbuacpt['idfasoutcomecat']==2 && $rowbbuacpt['idtype']==7 ) { $v_VBAT_ref_2_7= $rowbbuacpt['v_double']; }	
					if ( $rowbbuacpt['idfasoutcomecat']==11 && $rowbbuacpt['idtype']==200 ) { $v_VBAT_value_11_200= $rowbbuacpt['v_double']; }	
			 
					if (   $rowbbuacpt['instancem']=='11B11C11D' && $rowbbuacpt['idfasoutcomecat']==1 && $rowbbuacpt['idtype']==0 ) {    $v_IBAT_status = $rowbbuacpt['v_boolean'];    }	
					if ( $rowbbuacpt['idfasoutcomecat']==2 && $rowbbuacpt['idtype']==17 ) { $v_IBAT_ref_2_17= $rowbbuacpt['v_double']; }						
					if ( $rowbbuacpt['idfasoutcomecat']==11 && $rowbbuacpt['idtype']==203 ) { $v_IBAT_value_11_203= $rowbbuacpt['v_double']; }	

					if (   $rowbbuacpt['instancem']=='11B11C11D' && $rowbbuacpt['idfasoutcomecat']==1 && $rowbbuacpt['idtype']==0 ) {    $v_VBAT1_status = $rowbbuacpt['v_boolean'];    }	
					if ( $rowbbuacpt['idfasoutcomecat']==2 && $rowbbuacpt['idtype']==44 ) { $v_VBAT1_ref_2_44 = $rowbbuacpt['v_double']; }	
					if ( $rowbbuacpt['idfasoutcomecat']==2 && $rowbbuacpt['idtype']==61 ) { $v_VBAT1_ref_2_61 = $rowbbuacpt['v_double']; }	
					//if ( $rowbbuacpt['idfasoutcomecat']==5 && $rowbbuacpt['idtype']==101 ) { $v_VBAT1_value_5_101 = $rowbbuacpt['v_double']; }	
                    ////
                    if ( $rowbbuacpt['idfasoutcomecat']==11 && $rowbbuacpt['idtype']==140 ) { $v_VBAT1_value_11_140 = $rowbbuacpt['v_double'];    }	

					if (   $rowbbuacpt['instancem']=='11B11C11D' && $rowbbuacpt['idfasoutcomecat']==1 && $rowbbuacpt['idtype']==0 ) {    $v_VBAT2_status = $rowbbuacpt['v_boolean'];    }	
					if ( $rowbbuacpt['idfasoutcomecat']==2 && $rowbbuacpt['idtype']==44 ) { $v_VBAT2_ref_2_44 = $rowbbuacpt['v_double']; }	
					if ( $rowbbuacpt['idfasoutcomecat']==2 && $rowbbuacpt['idtype']==61 ) { $v_VBAT2_ref_2_61 = $rowbbuacpt['v_double']; }	
					//if ( $rowbbuacpt['idfasoutcomecat']==5 && $rowbbuacpt['idtype']==102 ) { $v_VBAT2_value_5_102 = $rowbbuacpt['v_double']; }	
                    if ( $rowbbuacpt['idfasoutcomecat']==11 && $rowbbuacpt['idtype']==141 ) { $v_VBAT2_value_11_141 = $rowbbuacpt['v_double'];  }	

				}

	    ///echo "TEMP::::::::::::::::::<br>".$elsqlvaluetemp;

				$sqldscpp = $connect->prepare($elsqlvaluetemp);	 
				$sqldscpp->execute();
				$resultdescmc = $sqldscpp->fetchAll();
				foreach ($resultdescmc as $rowbbuacpt) 
					{
						
						if (   $rowbbuacpt['instancem']=='0DC' && $rowbbuacpt['idfasoutcomecat']==1 && $rowbbuacpt['idtype']==0 ) {    $v_Alarm_boardtemp_status= $rowbbuacpt['v_boolean'];    }	
						if ( $rowbbuacpt['idfasoutcomecat']==2 && $rowbbuacpt['idtype']==31 ) { $v_Alarm_boardtemp_2_31= $rowbbuacpt['v_integer']; }	
						if ( $rowbbuacpt['idfasoutcomecat']==2 && $rowbbuacpt['idtype']==15 ) { $v_Alarm_boardtemp_2_15= $rowbbuacpt['v_integer']; }	
						if ( $rowbbuacpt['idfasoutcomecat']==2 && $rowbbuacpt['idtype']==1 ) { $v_Alarm_boardtemp_2_1= $rowbbuacpt['v_integer']; }	
						///if ( $rowbbuacpt['idfasoutcomecat']==5 && $rowbbuacpt['idtype']==11 ) { $v_Alarm_boardtemp_value_5_11= $rowbbuacpt['v_integer']; }	
                        if ( $rowbbuacpt['idfasoutcomecat']==11 && $rowbbuacpt['idtype']==27 ) { $v_Alarm_boardtemp_value_11_27= $rowbbuacpt['v_integer']; }	
	
						if (   $rowbbuacpt['instancem']=='0DC' && $rowbbuacpt['idfasoutcomecat']==1 && $rowbbuacpt['idtype']==0 ) {    $v_Alarm_batterytemp_status= $rowbbuacpt['v_boolean'];    }	
						if ( $rowbbuacpt['idfasoutcomecat']==2 && $rowbbuacpt['idtype']==15 ) { $v_Alarm_batterytemp_2_15= $rowbbuacpt['v_integer']; }	
						if ( $rowbbuacpt['idfasoutcomecat']==2 && $rowbbuacpt['idtype']==31 ) { $v_Alarm_batterytemp_2_31= $rowbbuacpt['v_integer']; }	
						if ( $rowbbuacpt['idfasoutcomecat']==2 && $rowbbuacpt['idtype']==1 ) { $v_Alarm_batterytemp_2_1= $rowbbuacpt['v_integer']; }	
						//if ( $rowbbuacpt['idfasoutcomecat']==5 && $rowbbuacpt['idtype']==100 ) { $v_Alarm_batterytemp_value_5_100= $rowbbuacpt['v_integer']; }	
                        if ( $rowbbuacpt['idfasoutcomecat']==11 && $rowbbuacpt['idtype']==199 ) { $v_Alarm_batterytemp_value_11_199= $rowbbuacpt['v_integer']; }	

 					}


				$v_alarm_normal_acpower_status_on="";	 
				$v_alarm_normal_acpower_status_off="";	 
				$v_alarm_normal_acpower_on="";	 
				$v_alarm_normal_acpower_off="";	 

				$v_alarm_lossnormal_acpower_status_on="";	 
				$v_alarm_lossnormal_acpower_status_off="";	 
				$v_alarm_lossnormal_acpower_on="";	 
				$v_alarm_lossnormal_acpower_off="";	 

				$v_alarm_lbatt_chr_fail_status_on="";	 
				$v_alarm_lbatt_chr_fail_status_off="";	 
				$v_alarm_lbatt_chr_fail_on="";	 
				$v_alarm_lbatt_chr_fail_off="";
				
				$v_alarm_battdisconect_status_on="";	 
				$v_alarm_battdisconect_status_off="";	 
				$v_alarm_battdisconect_on="";	 
				$v_alarm_battdisconect_off="";
				
				$v_alarm_annun_status_on="";	 
				$v_alarm_annun_status_off="";	 
				$v_alarm_annun_on="";	 
				$v_alarm_annun_off="";	 

                $v_bda_comunnicaction="";

		////		echo "<br>ALARMS".$elsqlvalue3;

					 $sqldscppbat = $connect->prepare($elsqlvalue3);	 
				$sqldscppbat->execute();
				$resultdescmcbatt = $sqldscppbat->fetchAll();
				foreach ($resultdescmcbatt as $rowalarm) 
					{
						
                        if (   $rowalarm['instancem']=='122123' && $rowalarm['idfasoutcomecat']==1 && $rowalarm['idtype']==0 ) {    $v_bda_comunnicaction= $rowalarm['v_booleanm'];    }	

						if (   $rowalarm['instancem']=='0850A2104' && $rowalarm['idfasoutcomecat']==1 && $rowalarm['idtype']==0 ) {    $v_alarm_normal_acpower_status_on= $rowalarm['v_booleanm'];    }	
						if (   $rowalarm['instancem']=='0850A2105' && $rowalarm['idfasoutcomecat']==1 && $rowalarm['idtype']==0 ) {    $v_alarm_normal_acpower_status_off= $rowalarm['v_booleanm'];    }	
						if (   $rowalarm['instancem']=='0850A2104' && $rowalarm['idfasoutcomecat']==11 && $rowalarm['idtype']==144 ) {    $v_alarm_normal_acpower_off= $rowalarm['v_booleanm'];  }	
						if (   $rowalarm['instancem']=='0850A2105' && $rowalarm['idfasoutcomecat']==11 && $rowalarm['idtype']==144 ) {    $v_alarm_normal_acpower_on= $rowalarm['v_booleanm'];    }	
					 
						if (   $rowalarm['instancem']=='0850A2104' && $rowalarm['idfasoutcomecat']==1 && $rowalarm['idtype']== 0 ) {    $v_alarm_lossnormal_acpower_status_on= $rowalarm['v_booleanm'];    }	
						if (   $rowalarm['instancem']=='0850A2105' && $rowalarm['idfasoutcomecat']==1 && $rowalarm['idtype']== 0 ) {    $v_alarm_lossnormal_acpower_status_off= $rowalarm['v_booleanm'];   }
						if (   $rowalarm['instancem']=='0850A2104' && $rowalarm['idfasoutcomecat']==11 && $rowalarm['idtype']== 145 ) {    $v_alarm_lossnormal_acpower_on= $rowalarm['v_booleanm'];    }	
						if (   $rowalarm['instancem']=='0850A2105' && $rowalarm['idfasoutcomecat']==11 && $rowalarm['idtype']== 145 ) {    $v_alarm_lossnormal_acpower_off= $rowalarm['v_booleanm'];   }

						if (   $rowalarm['instancem']=='0850A2104' && $rowalarm['idfasoutcomecat']==1 && $rowalarm['idtype']== 0 ) {    $v_alarm_lbatt_chr_fail_status_on= $rowalarm['v_booleanm'];    }	
						if (   $rowalarm['instancem']=='0850A2105' && $rowalarm['idfasoutcomecat']==1 && $rowalarm['idtype']== 0 ) {    $v_alarm_lbatt_chr_fail_status_off= $rowalarm['v_booleanm'];   }
						if (   $rowalarm['instancem']=='0850A2104' && $rowalarm['idfasoutcomecat']==11 && $rowalarm['idtype']== 147 ) {    $v_alarm_lbatt_chr_fail_on= $rowalarm['v_booleanm'];    }	
						if (   $rowalarm['instancem']=='0850A2105' && $rowalarm['idfasoutcomecat']==11 && $rowalarm['idtype']== 147 ) {    $v_alarm_lbatt_chr_fail_off= $rowalarm['v_booleanm'];   }

						if (   $rowalarm['instancem']=='085117118' && $rowalarm['idfasoutcomecat']==1 && $rowalarm['idtype']== 0 ) {    $v_alarm_battdisconect_status_on= $rowalarm['v_booleanm'];    }	
						if (   $rowalarm['instancem']=='085117119' && $rowalarm['idfasoutcomecat']==1 && $rowalarm['idtype']== 0 ) {    $v_alarm_battdisconect_status_off= $rowalarm['v_booleanm'];   }
						if (   $rowalarm['instancem']=='085117118' && $rowalarm['idfasoutcomecat']==11 && $rowalarm['idtype']== 155 ) {    $v_alarm_battdisconect_on= $rowalarm['v_booleanm'];    }	
						if (   $rowalarm['instancem']=='085117119' && $rowalarm['idfasoutcomecat']==11 && $rowalarm['idtype']== 155 ) {    $v_alarm_battdisconect_off= $rowalarm['v_booleanm'];   }

						if (   $rowalarm['instancem']=='0850C8112' && $rowalarm['idfasoutcomecat']==1 && $rowalarm['idtype']== 0 ) {    $v_alarm_annun_status_on= $rowalarm['v_booleanm'];    }	
						if (   $rowalarm['instancem']=='0850C8106' && $rowalarm['idfasoutcomecat']==1 && $rowalarm['idtype']== 0 ) {    $v_alarm_annun_status_off= $rowalarm['v_booleanm'];   }
						if (   $rowalarm['instancem']=='0850C8112' && $rowalarm['idfasoutcomecat']==11 && $rowalarm['idtype']== 154 ) {    $v_alarm_annun_on= $rowalarm['v_booleanm'];    }	
						if (   $rowalarm['instancem']=='0850C8106' && $rowalarm['idfasoutcomecat']==11 && $rowalarm['idtype']== 154 ) {    $v_alarm_annun_off= $rowalarm['v_booleanm'];   }
					}
		
   

?>
                                                    <tr>
                                                        <td style="text-align: left">

                                                            <div class="row">
                                                                <div class="col-sm-1">
                                                                    VSYS
                                                                </div>
                                                                <div class="col-sm-11">
                                                                    System Voltage
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td style="text-align: center">
                                                            <?php if ( $v_VSYS_status ==1)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-red">Not Pass</span><?php
}
?></td>

                                                          <td style="text-align: left">≥ <?php echo ($v_VSYS_ref_2_63 -0.2); ?> V
                                                            &nbsp;
                                                            &&nbsp;
                                                            ≤ <?php echo ($v_VSYS_ref_2_64 +0.2); ?> V</td>

                                                        <td style="text-align: left"><?php echo $v_VSYS_value_11_202;?>
                                                            V</td>


                                                    </tr>




                                                    <tr>
                                                        <td style="text-align: left">
                                                            <div class="row">
                                                                <div class="col-sm-1">
                                                                    VIN
                                                                </div>
                                                                <div class="col-sm-11">
                                                                    Power Supply Voltage
                                                                </div>
                                                            </div>

                                                        </td>
                                                        <td style="text-align: center"><?php if ( $v_VIN_status ==1)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-red">Not Pass</span><?php
}
?></td>

                                                        <td style="text-align: left">≥ <?php echo $v_VIN_ref_2_63; ?> V
                                                            &nbsp;
                                                            &&nbsp;
                                                            ≤ <?php echo $v_VIN_ref_2_64; ?> V</td>
                                                        <td style="text-align: left"><?php echo $v_VIN_value_11_201 ;?>
                                                            V</td>
                                                    </tr>

                                                    <tr>
                                                        <td style="text-align: left">

                                                            <div class="row">
                                                                <div class="col-sm-1">
                                                                    IIN
                                                                </div>
                                                                <div class="col-sm-11">
                                                                    Power Supply Current
                                                                </div>
                                                            </div>

                                                        </td>
                                                        <td style="text-align: center"><?php if ( $v_IIN_status ==1)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-red">Not Pass</span><?php
}
?></td>

                                                        <td style="text-align: left">≥ <?php echo $v_IIN_ref_2_65; ?> A
                                                            &nbsp;
                                                            &&nbsp;
                                                            ≤ <?php echo $v_IIN_ref_2_66; ?> A</td>
                                                        <td style="text-align: left"><?php echo $v_IIN_value_11_204;?> A
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td style="text-align: left">

                                                            <div class="row">
                                                                <div class="col-sm-1">
                                                                    VBANK
                                                                </div>
                                                                <div class="col-sm-11">
                                                                    Battery Bank Voltage
                                                                </div>
                                                            </div>



                                                        </td>
                                                        <td style="text-align: center"><?php if ( $v_VBANK_status ==1)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-red">Not Pass</span><?php
}
?></td>

                                                        <td style="text-align: left">≥ <?php echo $v_VBANK_ref_2_6; ?> V
                                                            &nbsp;
                                                            &&nbsp;
                                                            ≤ <?php echo $v_VBANK_ref_2_7; ?> V</td>
                                                        <td style="text-align: left"><?php echo $v_VBANK_value_11_207;?>
                                                            V</td>
                                                    </tr>


                                                    <tr>
                                                        <td style="text-align: left">
                                                            <div class="row">
                                                                <div class="col-sm-1">
                                                                    VBAT
                                                                </div>
                                                                <div class="col-sm-11">
                                                                    Battery Voltage
                                                                </div>
                                                            </div>

                                                        </td>
                                                        <td style="text-align: center"><?php if ( $v_VBAT_status ==1)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-red">Not Pass</span><?php
}
?></td>

                                                        <td style="text-align: left"> ≥ <?php echo $v_VBAT_ref_2_6; ?> V
                                                            &nbsp;
                                                            &&nbsp;
                                                            ≤ <?php echo $v_VBAT_ref_2_7; ?> V</td>
                                                        <td style="text-align: left"><?php echo $v_VBAT_value_11_200;?>
                                                            V</td>
                                                    </tr>

                                                    <tr>
                                                        <td style="text-align: left">
                                                            <div class="row">
                                                                <div class="col-sm-1">
                                                                    IBAT
                                                                </div>
                                                                <div class="col-sm-11">
                                                                    Battery Current
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td style="text-align: center"><?php if ( $v_IBAT_status ==1)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-red">Not Pass</span><?php
}
?></td>

                                                        <td style="text-align: left"> ≤<?php echo $v_IBAT_ref_2_17; ?>
                                                            mA
                                                        </td>
                                                        <td style="text-align: left">
                                                            <?php echo ($v_IBAT_value_11_203 * 1000);?> mA</td>
                                                    </tr>

                                                    <tr>
                                                        <td style="text-align: left">
                                                            <div class="row">
                                                                <div class="col-sm-1">
                                                                    VBAT1
                                                                </div>
                                                                <div class="col-sm-11">
                                                                    Battery 1 Voltage**
                                                                </div>
                                                            </div>

                                                        </td>
                                                        <td style="text-align: center"><?php if ( $v_VBAT1_status ==1)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-red">Not Pass</span><?php
}
?></td>

                                                        <td style="text-align: left">≥ <?php echo $v_VBAT1_ref_2_44 ; ?>
                                                            V
                                                            &nbsp;
                                                            &&nbsp;
                                                            ≤ <?php echo $v_VBAT1_ref_2_61 ; ?> V</td>
                                                        <td style="text-align: left"><?php echo $v_VBAT1_value_11_140 ;?>
                                                            V</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: left">
                                                            <div class="row">
                                                                <div class="col-sm-1">
                                                                    VBAT2
                                                                </div>
                                                                <div class="col-sm-11">
                                                                    Battery 2 Voltage <B>**</B>
                                                                </div>
                                                            </div>

                                                        </td>
                                                        <td style="text-align: center"><?php if ( $v_VBAT2_status ==1)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-red">Not Pass</span><?php
}
?></td>

                                                        <td style="text-align: left">≥ <?php echo $v_VBAT2_ref_2_44 ; ?>
                                                            V
                                                            &nbsp;
                                                            &&nbsp;
                                                            ≤ <?php echo $v_VBAT2_ref_2_61 ; ?> V</td>
                                                        <td style="text-align: left"><?php echo $v_VBAT2_value_11_141 ;?>
                                                            V</td>
                                                    </tr>


                                                    <tr>
                                                        <td colspan=4>
                                                            <p class='colorazulfiplex' style='font-size:16px'><br>
                                                                <b>TEMPERATURE<b>
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    <tr class="thead-dark">
                                                        <th style="text-align: left">Measurement:</th>
                                                        <th style="text-align: center">Status</th>

                                                        <th style="text-align: left">Reference:</th>
                                                        <th style="text-align: left">Value Readed</th>
                                                    </tr>


                                                    <tr>
                                                        <td style="text-align: left">Board Temperature</td>

                                                        <td style="text-align: center"><?php if ( $v_Alarm_boardtemp_status ==1)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-red">Not Pass</span><?php
}
?></td>

                                                        <td style="text-align: left">≥
                                                            <?php echo $v_Alarm_boardtemp_2_31; ?> °C

                                                            &nbsp;& &nbsp;≤ <?php echo $v_Alarm_boardtemp_2_15; ?> °C
                                                            &nbsp;&&nbsp;
                                                            Δ ≤ <?php echo $v_Alarm_boardtemp_2_1 ; ?> °C</td>


                                                        <td style="text-align: left">
                                                            <?php echo $v_Alarm_boardtemp_value_11_27 ;?> °C</td>

                                                    </tr>

                                                    <tr>
                                                        <td style="text-align: left">External Temperature</td>
                                                        <td style="text-align: center"><?php if ( $v_Alarm_batterytemp_status ==1)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-red">Not Pass</span><?php
}
?></td>
                                                        <td style="text-align: left"> ≥
                                                            <?php echo $v_Alarm_batterytemp_2_31; ?> °C
                                                            &nbsp;&&nbsp;
                                                            ≤ <?php echo $v_Alarm_batterytemp_2_15; ?> °C &nbsp;&&nbsp;
                                                            Δ ≤ <?php echo $v_Alarm_batterytemp_2_1; ?> °C </td>

                                                        <td style="text-align: left">
                                                            <?php echo $v_Alarm_batterytemp_value_11_199;?> °C</td>
                                                    </tr>






                                                    <tr>

                                                        <td colspan=4>
                                                            <p class='colorazulfiplex' style='font-size:16px'><br>
                                                                <b>ALARMS<b>
                                                            </p>
                                                        </td>
                                                    </tr>

                                                    <tr class="thead-dark">
                                                        <th style="text-align: left">Measurement:</th>
                                                        <th style="text-align: center">Status</th>

                                                        <th style="text-align: center">Forced On</th>
                                                        <th style="text-align: center">Forced Off</th>
                                                    </tr>

                                                    <tr>




                                                        <td style="text-align: left">Normal AC Power </td>
                                                        <td style="text-align: center"><?php if ( $v_alarm_normal_acpower_on ==1 && $v_alarm_normal_acpower_off==0 )
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-red">Not Pass</span><?php
}
?></td>

                                                        <td style="text-align: center">
                                                            <?php if ( $v_alarm_normal_acpower_on ==1   )
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
                                                            <?php if (   $v_alarm_normal_acpower_off==0)
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
                                                        <td style="text-align: left">Loss Normal AC Power</td>
                                                        <td style="text-align: center"><?php if ( $v_alarm_lossnormal_acpower_on ==1 && $v_alarm_lossnormal_acpower_off ==0)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-red">Not Pass</span><?php
}
?></td>

                                                        <td style="text-align: center">
                                                            <?php if ( $v_alarm_lossnormal_acpower_on ==1   )
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
                                                            <?php if (   $v_alarm_lossnormal_acpower_off==0 )
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
                                                        <td style="text-align: left">Battery Charger Fail</td>
                                                        <td style="text-align: center"><?php if ( $v_alarm_lbatt_chr_fail_on ==1 && $v_alarm_lbatt_chr_fail_off ==0)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-red">Not Pass</span><?php
}
?></td>

                                                        <td style="text-align: center">
                                                            <?php if ( $v_alarm_lbatt_chr_fail_on ==1   )
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
                                                            <?php if (   $v_alarm_lbatt_chr_fail_off==0 )
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
                                                        <td style="text-align: left">Battery Disconnection</td>
                                                        <td style="text-align: center"><?php if ( $v_alarm_battdisconect_on ==1 && $v_alarm_battdisconect_off == 0)
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-red">Not Pass</span><?php
}
?></td>

                                                        <td style="text-align: center">
                                                            <?php if ( $v_alarm_battdisconect_on ==1   )
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
                                                            <?php if (   $v_alarm_battdisconect_off==0 )
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
                                                        <td style="text-align: left">Annunciator Communication Error
                                                        </td>
                                                        <td style="text-align: center"><?php if ( $v_alarm_annun_on ==1 && $v_alarm_annun_off == 0 )
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-red">Not Pass</span><?php
}
?></td>

                                                        <td style="text-align: center">
                                                            <?php if ( $v_alarm_annun_on ==1   )
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
                                                            <?php if (   $v_alarm_annun_off==0 )
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
                                                    <TR>
                                                    <td colspan=4>
                                                      
                                                    </td>
                                                    </tr>
                                                    <td colspan=4>
                                                        <p class='colorazulfiplex' style='font-size:16px'><br>
                                                            <b>COMMUNICATION <b>
                                                        </p>
                                                    </td>
                                                    </tr>
                                                    <tr class="thead-dark">
                                                        <th style="text-align: left"  colspan="2">Measurement:</th>
                                                        <th style="text-align: center "  colspan="2">Status</th>
                                                        
                                                    </tr>
                                                    <tr  >
                                                        <th style="text-align: left" colspan="2">BDA Communication:</th>
                                                        <th style="text-align: center" colspan="2"><?PHP 
                                                        
                                                        if (   $v_bda_comunnicaction==1 )
{
	?><span class="badge bg-green">Pass</span><?php
}
else
{
	?><span class="badge bg-red">Not Pass</span><?php
}

                                                        ?></th>
 
                                                    </tr>

                                                    <td colspan=4>
                                                      
                                                    </td>
                                                    </tr>
                                                    <td colspan=4>
                                                        <p class='colorazulfiplex' style='font-size:16px'><br>
                                                            <b>LEDS<b>
                                                        </p>
                                                    </td>
                                                    </tr>

                                                    <tr class="thead-dark">
                                                        <th style="text-align: left">Measurement:</th>
                                                        <th style="text-align: center">Status</th>

                                                        <th style="text-align: center">Forced On</th>
                                                        <th style="text-align: center">Forced Off</th>
                                                    </tr>



                                                    <?php
 	$elsqlvalueled="
		
	 select fas_outcome_integral.*,  instancem , v_boolean::integer as v_booleanm ,0 as indexmeasure
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
			and fas_step.instance  in('08A'	)
		 ) as tdosmm
	 on tdosmm.iduniqueop = fas_outcome_integral.reference

	 union		

	 select fas_outcome_integral.* , instancem,  v_boolean::integer as v_booleanm , todosm3.indexmeasure
	 from fas_outcome_integral
inner join 
(
 
	 select fas_outcome_integral.id_outcome , instancem,todom2.v_integer as indexmeasure
 
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

							fas_step.instance  in('08A')	
					 ) as tdosmm
				 on tdosmm.iduniqueop = fas_outcome_integral.v_bigint
					   
			 ) as todosma
			 on fas_outcome_integral.reference =     todosma.id_outcome				 
  
	 ) as todom2
	 on fas_outcome_integral.reference =     todom2.id_outcome
	 where  fas_outcome_integral.idfasoutcomecat in(0)  and 
			fas_outcome_integral.idtype in (28,47)	
	 

 ) as todosm3
 on fas_outcome_integral.reference =     todosm3.id_outcome
 where  idfasoutcomecat in(11)  and idtype in (209,210,211,212,213,214,215,216,217,218)
	 		  
			 ";
   
     

		 echo "<br>a LEDS  ----->>  ". $elsqlvalueled;
       
 
		 $sqldscpp4 = $connect->prepare($elsqlvalueled);	 
		 $sqldscpp4->execute();
		 $resultleds = $sqldscpp4->fetchAll();

		 $v_led_status ="";
         $v_led_1_11_209_forced_on = "";
$v_led_1_11_209_forced_off = "";
$v_led_2_11_210_forced_on = "";
$v_led_2_11_210_forced_off = "";
$v_led_3_11_211_forced_on = "";
$v_led_3_11_211_forced_off = "";
$v_led_4_11_212_forced_on = "";
$v_led_4_11_212_forced_off = "";
$v_led_5_11_210_forced_on = "";
$v_led_5_11_210_forced_off = "";
$v_led_6_11_210_forced_on = "";
$v_led_6_11_210_forced_off = "";
$v_led_7_11_210_forced_on = "";
$v_led_7_11_210_forced_off = "";
$v_led_8_11_210_forced_on = "";
$v_led_8_11_210_forced_off = "";
$v_led_9_11_210_forced_on = "";
$v_led_9_11_210_forced_off = "";
$v_led_10_11_210_forced_on = "";
$v_led_10_11_210_forced_off = "";

 	



		 foreach ($resultleds as $rowbbuacpt4a) 
		 {
			 if (   $rowbbuacpt4a['instancem']=='08A'   && $rowbbuacpt4a['idfasoutcomecat']==1 && $rowbbuacpt4a['idtype']==0)	  {  $v_led_status =$rowbbuacpt4a['v_boolean']; } ;

			 if (   $rowbbuacpt4a['instancem']=='08A'  && $rowbbuacpt4a['indexmeasure']==0  && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==209 ) { $v_led_1_11_209_forced_on = $rowbbuacpt4a['v_booleanm'] ;}
			 if (   $rowbbuacpt4a['instancem']=='08A'  && $rowbbuacpt4a['indexmeasure']==10  && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==209 ) {  $v_led_1_11_209_forced_off = $rowbbuacpt4a['v_booleanm'] ;}

             if (   $rowbbuacpt4a['instancem']=='08A'  && $rowbbuacpt4a['indexmeasure']==1  && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==210 ) {  $v_led_2_11_210_forced_on = $rowbbuacpt4a['v_booleanm'] ;}
			 if (   $rowbbuacpt4a['instancem']=='08A'  && $rowbbuacpt4a['indexmeasure']==10  && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==210 ) {  $v_led_2_11_210_forced_off = $rowbbuacpt4a['v_booleanm'] ;}

             if (   $rowbbuacpt4a['instancem']=='08A'  && $rowbbuacpt4a['indexmeasure']==2  && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==211 ) {  $v_led_3_11_211_forced_on = $rowbbuacpt4a['v_booleanm'] ;}
			 if (   $rowbbuacpt4a['instancem']=='08A'  && $rowbbuacpt4a['indexmeasure']==10  && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==211 ) {  $v_led_3_11_211_forced_off = $rowbbuacpt4a['v_booleanm'] ;}

             if (   $rowbbuacpt4a['instancem']=='08A'  && $rowbbuacpt4a['indexmeasure']==3  && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==212 ) {  $v_led_4_11_212_forced_on = $rowbbuacpt4a['v_booleanm'] ;}
			 if (   $rowbbuacpt4a['instancem']=='08A'  && $rowbbuacpt4a['indexmeasure']==10  && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==212 ) {  $v_led_4_11_212_forced_off = $rowbbuacpt4a['v_booleanm'] ;}

             if (   $rowbbuacpt4a['instancem']=='08A'  && $rowbbuacpt4a['indexmeasure']==4  && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==213 ) {  $v_led_5_11_210_forced_on = $rowbbuacpt4a['v_booleanm'] ;}
			 if (   $rowbbuacpt4a['instancem']=='08A'  && $rowbbuacpt4a['indexmeasure']==10  && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==213 ) {  $v_led_5_11_210_forced_off = $rowbbuacpt4a['v_booleanm'] ;}

             if (   $rowbbuacpt4a['instancem']=='08A'  && $rowbbuacpt4a['indexmeasure']==5  && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==214 ) {  $v_led_6_11_210_forced_on = $rowbbuacpt4a['v_booleanm'] ;}
			 if (   $rowbbuacpt4a['instancem']=='08A'  && $rowbbuacpt4a['indexmeasure']==10  && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==214 ) {  $v_led_6_11_210_forced_off = $rowbbuacpt4a['v_booleanm'] ;}

             if (   $rowbbuacpt4a['instancem']=='08A'  && $rowbbuacpt4a['indexmeasure']==6  && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==215 ) {  $v_led_7_11_210_forced_on = $rowbbuacpt4a['v_booleanm'] ;}
			 if (   $rowbbuacpt4a['instancem']=='08A'  && $rowbbuacpt4a['indexmeasure']==10  && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==215 ) {  $v_led_7_11_210_forced_off = $rowbbuacpt4a['v_booleanm'] ;}

             if (   $rowbbuacpt4a['instancem']=='08A'  && $rowbbuacpt4a['indexmeasure']==7  && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==216 ) {  $v_led_8_11_210_forced_on = $rowbbuacpt4a['v_booleanm'] ;}
			 if (   $rowbbuacpt4a['instancem']=='08A'  && $rowbbuacpt4a['indexmeasure']==10  && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==216 ) {  $v_led_8_11_210_forced_off = $rowbbuacpt4a['v_booleanm'] ;}

             if (   $rowbbuacpt4a['instancem']=='08A'  && $rowbbuacpt4a['indexmeasure']==8  && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==217 ) {  $v_led_9_11_210_forced_on = $rowbbuacpt4a['v_booleanm'] ;}
			 if (   $rowbbuacpt4a['instancem']=='08A'  && $rowbbuacpt4a['indexmeasure']==10  && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==217 ) {  $v_led_9_11_210_forced_off = $rowbbuacpt4a['v_booleanm'] ;}

             if (   $rowbbuacpt4a['instancem']=='08A'  && $rowbbuacpt4a['indexmeasure']==9  && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==218 ) {  $v_led_10_11_210_forced_on = $rowbbuacpt4a['v_booleanm'] ;}
			 if (   $rowbbuacpt4a['instancem']=='08A'  && $rowbbuacpt4a['indexmeasure']==10  && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==218 ) {  $v_led_10_11_210_forced_off = $rowbbuacpt4a['v_booleanm'] ;}
			 
			 
		 		 
		 }

?>


                                            <tr>
                                                <td style="text-align: left">Led 1 </td>
                                                <td style="text-align: center"><?php if ( $v_led_status ==1 ) {  ?><span class="badge bg-green">Pass</span><?php }  else  {	?><span class="badge bg-red">Not Pass</span><?php } ?></td>
                                                <td style="text-align: center"><?php if ( $v_led_1_11_209_forced_on ==1   ) { ?><span class="badge bg-green">Pass</span><?php } else  {	?><span class="badge bg-red">Not Pass</span><?php } ?>                                                        </td>
                                                <td style="text-align: center"><?php if (   $v_led_1_11_209_forced_off==0 ) {	?><span class="badge bg-green">Pass</span><?php }  else  { 	?><span class="badge bg-red">Not Pass</span><?php } ?></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: left">Led 2 </td>
                                                <td style="text-align: center"><?php if ( $v_led_status ==1 ) {  ?><span class="badge bg-green">Pass</span><?php }  else  {	?><span class="badge bg-red">Not Pass</span><?php } ?></td>
                                                <td style="text-align: center"><?php if ( $v_led_2_11_210_forced_on ==1   ) { ?><span class="badge bg-green">Pass</span><?php } else  {	?><span class="badge bg-red">Not Pass</span><?php } ?>                                                        </td>
                                                <td style="text-align: center"><?php if (   $v_led_2_11_210_forced_off==0 ) {	?><span class="badge bg-green">Pass</span><?php }  else  { 	?><span class="badge bg-red">Not Pass</span><?php } ?></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: left">Led 3 </td>
                                                <td style="text-align: center"><?php if ( $v_led_status ==1 ) {  ?><span class="badge bg-green">Pass</span><?php }  else  {	?><span class="badge bg-red">Not Pass</span><?php } ?></td>
                                                <td style="text-align: center"><?php if ( $v_led_3_11_211_forced_on ==1   ) { ?><span class="badge bg-green">Pass</span><?php } else  {	?><span class="badge bg-red">Not Pass</span><?php } ?>                                                        </td>
                                                <td style="text-align: center"><?php if (   $v_led_3_11_211_forced_off==0 ) {	?><span class="badge bg-green">Pass</span><?php }  else  { 	?><span class="badge bg-red">Not Pass</span><?php } ?></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: left">Led 4 </td>
                                                <td style="text-align: center"><?php if ( $v_led_status ==1 ) {  ?><span class="badge bg-green">Pass</span><?php }  else  {	?><span class="badge bg-red">Not Pass</span><?php } ?></td>
                                                <td style="text-align: center"><?php if ( $v_led_4_11_212_forced_on ==1   ) { ?><span class="badge bg-green">Pass</span><?php } else  {	?><span class="badge bg-red">Not Pass</span><?php } ?>                                                        </td>
                                                <td style="text-align: center"><?php if (   $v_led_4_11_212_forced_off==0 ) {	?><span class="badge bg-green">Pass</span><?php }  else  { 	?><span class="badge bg-red">Not Pass</span><?php } ?></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: left">Led 5 </td>
                                                <td style="text-align: center"><?php if ( $v_led_status ==1 ) {  ?><span class="badge bg-green">Pass</span><?php }  else  {	?><span class="badge bg-red">Not Pass</span><?php } ?></td>
                                                <td style="text-align: center"><?php if ( $v_led_5_11_210_forced_on ==1   ) { ?><span class="badge bg-green">Pass</span><?php } else  {	?><span class="badge bg-red">Not Pass</span><?php } ?>                                                        </td>
                                                <td style="text-align: center"><?php if (   $v_led_5_11_210_forced_off==0 ) {	?><span class="badge bg-green">Pass</span><?php }  else  { 	?><span class="badge bg-red">Not Pass</span><?php } ?></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: left">Led 6 </td>
                                                <td style="text-align: center"><?php if ( $v_led_status ==1 ) {  ?><span class="badge bg-green">Pass</span><?php }  else  {	?><span class="badge bg-red">Not Pass</span><?php } ?></td>
                                                <td style="text-align: center"><?php if ( $v_led_6_11_210_forced_on ==1   ) { ?><span class="badge bg-green">Pass</span><?php } else  {	?><span class="badge bg-red">Not Pass</span><?php } ?>                                                        </td>
                                                <td style="text-align: center"><?php if (   $v_led_6_11_210_forced_off==0 ) {	?><span class="badge bg-green">Pass</span><?php }  else  { 	?><span class="badge bg-red">Not Pass</span><?php } ?></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: left">Led 7 </td>
                                                <td style="text-align: center"><?php if ( $v_led_status ==1 ) {  ?><span class="badge bg-green">Pass</span><?php }  else  {	?><span class="badge bg-red">Not Pass</span><?php } ?></td>
                                                <td style="text-align: center"><?php if ( $v_led_7_11_210_forced_on ==1   ) { ?><span class="badge bg-green">Pass</span><?php } else  {	?><span class="badge bg-red">Not Pass</span><?php } ?>                                                        </td>
                                                <td style="text-align: center"><?php if (   $v_led_7_11_210_forced_off==0 ) {	?><span class="badge bg-green">Pass</span><?php }  else  { 	?><span class="badge bg-red">Not Pass</span><?php } ?></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: left">Led 8 </td>
                                                <td style="text-align: center"><?php if ( $v_led_status ==1 ) {  ?><span class="badge bg-green">Pass</span><?php }  else  {	?><span class="badge bg-red">Not Pass</span><?php } ?></td>
                                                <td style="text-align: center"><?php if ( $v_led_8_11_210_forced_on ==1   ) { ?><span class="badge bg-green">Pass</span><?php } else  {	?><span class="badge bg-red">Not Pass</span><?php } ?>                                                        </td>
                                                <td style="text-align: center"><?php if (   $v_led_8_11_210_forced_off==0 ) {	?><span class="badge bg-green">Pass</span><?php }  else  { 	?><span class="badge bg-red">Not Pass</span><?php } ?></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: left">Led 9 </td>
                                                <td style="text-align: center"><?php if ( $v_led_status ==1 ) {  ?><span class="badge bg-green">Pass</span><?php }  else  {	?><span class="badge bg-red">Not Pass</span><?php } ?></td>
                                                <td style="text-align: center"><?php if ( $v_led_9_11_210_forced_on ==1   ) { ?><span class="badge bg-green">Pass</span><?php } else  {	?><span class="badge bg-red">Not Pass</span><?php } ?>                                                        </td>
                                                <td style="text-align: center"><?php if (   $v_led_9_11_210_forced_off==0 ) {	?><span class="badge bg-green">Pass</span><?php }  else  { 	?><span class="badge bg-red">Not Pass</span><?php } ?></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: left">Led 10 </td>
                                                <td style="text-align: center"><?php if ( $v_led_status ==1 ) {  ?><span class="badge bg-green">Pass</span><?php }  else  {	?><span class="badge bg-red">Not Pass</span><?php } ?></td>
                                                <td style="text-align: center"><?php if ( $v_led_10_11_210_forced_on ==1   ) { ?><span class="badge bg-green">Pass</span><?php } else  {	?><span class="badge bg-red">Not Pass</span><?php } ?>                                                        </td>
                                                <td style="text-align: center"><?php if (   $v_led_10_11_210_forced_off==0 ) {	?><span class="badge bg-green">Pass</span><?php }  else  { 	?><span class="badge bg-red">Not Pass</span><?php } ?></td>
                                            </tr>
                                                  

                                                    <?php
 	$elsqlvalueledrelays="
		
	 select fas_outcome_integral.*,  instancem , v_boolean::integer as v_booleanm ,0 as indexmeasure
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
			and fas_step.instance  in( '0C9'	)
		 ) as tdosmm
	 on tdosmm.iduniqueop = fas_outcome_integral.reference

	 union		

	 select fas_outcome_integral.* , instancem,  v_boolean::integer as v_booleanm , todosm3.indexmeasure
	 from fas_outcome_integral
inner join 
(
 
	 select fas_outcome_integral.id_outcome , instancem,todom2.v_integer as indexmeasure
 
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

							fas_step.instance  in('0C9')	
					 ) as tdosmm
				 on tdosmm.iduniqueop = fas_outcome_integral.v_bigint
					   
			 ) as todosma
			 on fas_outcome_integral.reference =     todosma.id_outcome				 
  
	 ) as todom2
	 on fas_outcome_integral.reference =     todom2.id_outcome
	 where  fas_outcome_integral.idfasoutcomecat in(0)  and 
			fas_outcome_integral.idtype in (28,47)	
	 

 ) as todosm3
 on fas_outcome_integral.reference =     todosm3.id_outcome
 where  idfasoutcomecat in(11)  and idtype in (191,192,193,194,195,196,197,198,219,220)
	 
	 
	  
		  
			 ";
		//// echo "<br>a verrrrrr  RELays ----->>  ". $elsqlvalueledrelays;
 
		 $sqldscpp4relay = $connect->prepare($elsqlvalueledrelays);	 
		 $sqldscpp4relay->execute();
		 $resultleds = $sqldscpp4relay->fetchAll();

		 $v_relays_status ="";

		 $v_relays_1_on="";
		 $v_relays_1_off="";

         $v_relays_2_on="";
		 $v_relays_2_off="";

         $v_relays_3_on="";
		 $v_relays_3_off="";

         $v_relays_4_on="";
		 $v_relays_4_off="";

         $v_relays_5_on="";
		 $v_relays_5_off="";

         $v_relays_6_on="";
		 $v_relays_6_off="";

         $v_relays_7_on="";
		 $v_relays_7_off="";

         $v_relays_8_on="";
		 $v_relays_8_off="";

         $v_relays_9_on="";
		 $v_relays_9_off="";

         $v_relays_10_on="";
		 $v_relays_10_off="";
	 



		 foreach ($resultleds as $rowbbuacpt4a) 
		 {
			 if (   $rowbbuacpt4a['instancem']=='0C9'   && $rowbbuacpt4a['idfasoutcomecat']==1 && $rowbbuacpt4a['idtype']==0)	  {  $v_relays_status =$rowbbuacpt4a['v_boolean']; } ;

			 if (   $rowbbuacpt4a['instancem']=='0C9'  && $rowbbuacpt4a['indexmeasure']==0  && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==191 ) {  $v_relays_1_on = $rowbbuacpt4a['v_booleanm'] ;}
			 if (   $rowbbuacpt4a['instancem']=='0C9'  && $rowbbuacpt4a['indexmeasure']==10  && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==191 ) {  $v_relays_1_off = $rowbbuacpt4a['v_booleanm'] ;}

             if (   $rowbbuacpt4a['instancem']=='0C9'  && $rowbbuacpt4a['indexmeasure']==1  && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==192 ) {  $v_relays_2_on = $rowbbuacpt4a['v_booleanm'] ;}
			 if (   $rowbbuacpt4a['instancem']=='0C9'  && $rowbbuacpt4a['indexmeasure']==10  && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==192 ) {  $v_relays_2_off = $rowbbuacpt4a['v_booleanm'] ;}

             if (   $rowbbuacpt4a['instancem']=='0C9'  && $rowbbuacpt4a['indexmeasure']==2  && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==193 ) {  $v_relays_3_on = $rowbbuacpt4a['v_booleanm'] ;}
			 if (   $rowbbuacpt4a['instancem']=='0C9'  && $rowbbuacpt4a['indexmeasure']==10  && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==193 ) {  $v_relays_3_off = $rowbbuacpt4a['v_booleanm'] ;}

             if (   $rowbbuacpt4a['instancem']=='0C9'  && $rowbbuacpt4a['indexmeasure']==3  && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==194 ) {  $v_relays_4_on = $rowbbuacpt4a['v_booleanm'] ;}
			 if (   $rowbbuacpt4a['instancem']=='0C9'  && $rowbbuacpt4a['indexmeasure']==10  && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==194 ) {  $v_relays_4_off = $rowbbuacpt4a['v_booleanm'] ;}

             if (   $rowbbuacpt4a['instancem']=='0C9'  && $rowbbuacpt4a['indexmeasure']==4  && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==195 ) {  $v_relays_5_on = $rowbbuacpt4a['v_booleanm'] ;}
			 if (   $rowbbuacpt4a['instancem']=='0C9'  && $rowbbuacpt4a['indexmeasure']==10  && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==195 ) {  $v_relays_5_off = $rowbbuacpt4a['v_booleanm'] ;}

             if (   $rowbbuacpt4a['instancem']=='0C9'  && $rowbbuacpt4a['indexmeasure']==5  && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==196 ) {  $v_relays_6_on = $rowbbuacpt4a['v_booleanm'] ;}
			 if (   $rowbbuacpt4a['instancem']=='0C9'  && $rowbbuacpt4a['indexmeasure']==10  && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==196 ) {  $v_relays_6_off = $rowbbuacpt4a['v_booleanm'] ;}

             if (   $rowbbuacpt4a['instancem']=='0C9'  && $rowbbuacpt4a['indexmeasure']==6  && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==197 ) {  $v_relays_7_on = $rowbbuacpt4a['v_booleanm'] ;}
			 if (   $rowbbuacpt4a['instancem']=='0C9'  && $rowbbuacpt4a['indexmeasure']==10  && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==197 ) {  $v_relays_7_off = $rowbbuacpt4a['v_booleanm'] ;}

             if (   $rowbbuacpt4a['instancem']=='0C9'  && $rowbbuacpt4a['indexmeasure']==7  && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==198 ) {  $v_relays_8_on = $rowbbuacpt4a['v_booleanm'] ;}
			 if (   $rowbbuacpt4a['instancem']=='0C9'  && $rowbbuacpt4a['indexmeasure']==10  && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==198 ) {  $v_relays_8_off = $rowbbuacpt4a['v_booleanm'] ;}

             if (   $rowbbuacpt4a['instancem']=='0C9'  && $rowbbuacpt4a['indexmeasure']==8  && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==219 ) {  $v_relays_9_on = $rowbbuacpt4a['v_booleanm'] ;}
			 if (   $rowbbuacpt4a['instancem']=='0C9'  && $rowbbuacpt4a['indexmeasure']==10  && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==219 ) {  $v_relays_9_off = $rowbbuacpt4a['v_booleanm'] ;}

             if (   $rowbbuacpt4a['instancem']=='0C9'  && $rowbbuacpt4a['indexmeasure']==9  && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==220 ) {  $v_relays_10_on = $rowbbuacpt4a['v_booleanm'] ;}
			 if (   $rowbbuacpt4a['instancem']=='0C9'  && $rowbbuacpt4a['indexmeasure']==10  && $rowbbuacpt4a['idfasoutcomecat']==11 && $rowbbuacpt4a['idtype']==220 ) {  $v_relays_10_off = $rowbbuacpt4a['v_booleanm'] ;}
		 
		 		 
		 }

?>
                                                    <tr>
                                                        <td colspan=4>
                                                            <p class='colorazulfiplex' style='font-size:16px'><br>
                                                                <b>RELAYS<b>
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    <tr class="thead-dark">
                                                        <th style="text-align: left">Measurement:</th>
                                                        <th style="text-align: center">Status</th>

                                                        <th style="text-align: center">Forced On</th>
                                                        <th style="text-align: center">Forced Off</th>
                                                    </tr>

                                                    <tr>
                                                        <td style="text-align: left">Relay 1 </td>
                                                        <td style="text-align: center"><?php if ( $v_relays_status ==1 ) { ?><span class="badge bg-green">Pass</span><?php 	}   else    {?><span class="badge bg-red">Not Pass</span><?php } ?></td>
                                                        <td style="text-align: center"><?php if ( $v_relays_1_on  ==1   ) 	{ ?><span class="badge bg-green">Pass</span><?php }	else 	{ 		?><span class="badge bg-red">Not Pass</span><?php 	} ?> </td>
                                                        <td style="text-align: center"><?php if ( $v_relays_1_off ==1   ) 	{ ?><span class="badge bg-green">Pass</span><?php } else    {   	?><span class="badge bg-red">Not Pass</span><?php	} ?> </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: left">Relay 2 </td>
                                                        <td style="text-align: center"><?php if ( $v_relays_status ==1 ) { ?><span class="badge bg-green">Pass</span><?php 	}   else    {?><span class="badge bg-red">Not Pass</span><?php } ?></td>
                                                        <td style="text-align: center"><?php if ( $v_relays_2_on  ==1   ) 	{ ?><span class="badge bg-green">Pass</span><?php }	else 	{ 		?><span class="badge bg-red">Not Pass</span><?php 	} ?> </td>
                                                        <td style="text-align: center"><?php if ( $v_relays_2_off ==0   ) 	{ ?><span class="badge bg-green">Pass</span><?php } else    {   	?><span class="badge bg-red">Not Pass</span><?php	} ?> </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: left">Relay 3 </td>
                                                        <td style="text-align: center"><?php if ( $v_relays_status ==1 ) { ?><span class="badge bg-green">Pass</span><?php 	}   else    {?><span class="badge bg-red">Not Pass</span><?php } ?></td>
                                                        <td style="text-align: center"><?php if ( $v_relays_3_on  ==1   ) 	{ ?><span class="badge bg-green">Pass</span><?php }	else 	{ 		?><span class="badge bg-red">Not Pass</span><?php 	} ?> </td>
                                                        <td style="text-align: center"><?php if ( $v_relays_3_off ==0   ) 	{ ?><span class="badge bg-green">Pass</span><?php } else    {   	?><span class="badge bg-red">Not Pass</span><?php	} ?> </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: left">Relay 4 </td>
                                                        <td style="text-align: center"><?php if ( $v_relays_status ==1 ) { ?><span class="badge bg-green">Pass</span><?php 	}   else    {?><span class="badge bg-red">Not Pass</span><?php } ?></td>
                                                        <td style="text-align: center"><?php if ( $v_relays_4_on  ==1   ) 	{ ?><span class="badge bg-green">Pass</span><?php }	else 	{ 		?><span class="badge bg-red">Not Pass</span><?php 	} ?> </td>
                                                        <td style="text-align: center"><?php if ( $v_relays_4_off ==1   ) 	{ ?><span class="badge bg-green">Pass</span><?php } else    {   	?><span class="badge bg-red">Not Pass</span><?php	} ?> </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: left">Relay 5 </td>
                                                        <td style="text-align: center"><?php if ( $v_relays_status ==1 ) { ?><span class="badge bg-green">Pass</span><?php 	}   else    {?><span class="badge bg-red">Not Pass</span><?php } ?></td>
                                                        <td style="text-align: center"><?php if ( $v_relays_5_on  ==1   ) 	{ ?><span class="badge bg-green">Pass</span><?php }	else 	{ 		?><span class="badge bg-red">Not Pass</span><?php 	} ?> </td>
                                                        <td style="text-align: center"><?php if ( $v_relays_5_off ==0  ) 	{ ?><span class="badge bg-green">Pass</span><?php } else    {   	?><span class="badge bg-red">Not Pass</span><?php	} ?> </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: left">Relay 6 </td>
                                                        <td style="text-align: center"><?php if ( $v_relays_status ==1 ) { ?><span class="badge bg-green">Pass</span><?php 	}   else    {?><span class="badge bg-red">Not Pass</span><?php } ?></td>
                                                        <td style="text-align: center"><?php if ( $v_relays_6_on  ==1   ) 	{ ?><span class="badge bg-green">Pass</span><?php }	else 	{ 		?><span class="badge bg-red">Not Pass</span><?php 	} ?> </td>
                                                        <td style="text-align: center"><?php if ( $v_relays_6_off ==0   ) 	{ ?><span class="badge bg-green">Pass</span><?php } else    {   	?><span class="badge bg-red">Not Pass</span><?php	} ?> </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: left">Relay 7 </td>
                                                        <td style="text-align: center"><?php if ( $v_relays_status ==1 ) { ?><span class="badge bg-green">Pass</span><?php 	}   else    {?><span class="badge bg-red">Not Pass</span><?php } ?></td>
                                                        <td style="text-align: center"><?php if ( $v_relays_7_on  ==1   ) 	{ ?><span class="badge bg-green">Pass</span><?php }	else 	{ 		?><span class="badge bg-red">Not Pass</span><?php 	} ?> </td>
                                                        <td style="text-align: center"><?php if ( $v_relays_7_off ==0   ) 	{ ?><span class="badge bg-green">Pass</span><?php } else    {   	?><span class="badge bg-red">Not Pass</span><?php	} ?> </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: left">Relay 8 </td>
                                                        <td style="text-align: center"><?php if ( $v_relays_status ==1 ) { ?><span class="badge bg-green">Pass</span><?php 	}   else    {?><span class="badge bg-red">Not Pass</span><?php } ?></td>
                                                        <td style="text-align: center"><?php if ( $v_relays_8_on  ==1   ) 	{ ?><span class="badge bg-green">Pass</span><?php }	else 	{ 		?><span class="badge bg-red">Not Pass</span><?php 	} ?> </td>
                                                        <td style="text-align: center"><?php if ( $v_relays_8_off ==0   ) 	{ ?><span class="badge bg-green">Pass</span><?php } else    {   	?><span class="badge bg-red">Not Pass</span><?php	} ?> </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: left">Relay 9 </td>
                                                        <td style="text-align: center"><?php if ( $v_relays_status ==1 ) { ?><span class="badge bg-green">Pass</span><?php 	}   else    {?><span class="badge bg-red">Not Pass</span><?php } ?></td>
                                                        <td style="text-align: center"><?php if ( $v_relays_9_on  ==1   ) 	{ ?><span class="badge bg-green">Pass</span><?php }	else 	{ 		?><span class="badge bg-red">Not Pass</span><?php 	} ?> </td>
                                                        <td style="text-align: center"><?php if ( $v_relays_9_off ==0   ) 	{ ?><span class="badge bg-green">Pass</span><?php } else    {   	?><span class="badge bg-red">Not Pass</span><?php	} ?> </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: left">Relay 10 </td>
                                                        <td style="text-align: center"><?php if ( $v_relays_status ==1 ) { ?><span class="badge bg-green">Pass</span><?php 	}   else    {?><span class="badge bg-red">Not Pass</span><?php } ?></td>
                                                        <td style="text-align: center"><?php if ( $v_relays_10_on  ==1   ) 	{ ?><span class="badge bg-green">Pass</span><?php }	else 	{ 		?><span class="badge bg-red">Not Pass</span><?php 	} ?> </td>
                                                        <td style="text-align: center"><?php if ( $v_relays_10_off ==0   ) 	{ ?><span class="badge bg-green">Pass</span><?php } else    {   	?><span class="badge bg-red">Not Pass</span><?php	} ?> </td>
                                                    </tr>
                                                   
                                                   
                                                    <tr>
                                                        <td colspan="7" style="text-align: left">
                                                            <B> <br>* The system status values has been read under
                                                                standby condition, which means fully charged batteries
                                                                IBAT ≈ 0 .
                                                                <br>** The batteries with which this unit was accepted
                                                                do not correspond to the batteries send to the
                                                                customer.</B>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    <tr>
                                                        <td colspan="7" style="text-align: left"> </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan=4>
                                                            <p class='colorazulfiplex' style='font-size:16px'><br>
                                                                <b>POWER STRESS<b>
                                                            </p>
                                                        </td>
                                                    </tr>
                                            </table>

                                        </div>
                                        <br><br><br><br><br>

                                        <div name="divallgraphstress" id="divallgraphstress" class='divallgraphstress'>

                                            <div class="container-fluid " id="divgrafico700mp" name="divgrafico700mp">

                                                <div class="col-12">

                                                <hr style=" border: 1px solid #007bff;">

                                                <div class="col-12   " id="divgraph1a" name="divgraph1a">
                                                        <p class="colorazulfiplex"
                                                            style="font-size:14px; text-align: center;"> <b>BATTERY PORT CURRENT [A]
                                                                 </b></p>
                                                        <div class="chart">

                                                        <canvas id="graf_current_ieload2" height="280" style="height: 280;"></canvas>
                                                        </div>
                                                    </div>

                                                    <div class="col-12   " id="divgraph1a" name="divgraph1a">
                                                        <p class="colorazulfiplex"
                                                            style="font-size:14px; text-align: center;"> <b>LOAD PORT POWER [W]
                                                                 </b></p>
                                                        <div class="chart">

                                                        <canvas id="graf_current_pwr" height="280" style="height: 280;"></canvas>
                                                        </div>
                                                    </div>

                                                   

                                                 




                                                  

                                                    <div class="col-12    " id="divgraph3" name="divgraph3">
                                                            <hr style=" border: 1px solid #007bff;">
                                                            <p class="colorazulfiplex"
                                                                style="font-size:14px;  text-align: center;"> <b>CURRENT
                                                                    CONSUMPTION [A] </b></p>
                                                            <div class="chart">
                                                                <canvas id="graf_3" height="280"
                                                                    style="height: 280;"></canvas>
                                                            </div>
                                                        </div>


                                                        <hr style=" border: 1px solid #007bff;">
                                                    <div class="col-12   " id="divgraph1" name="divgraph1">
                                                        <p class="colorazulfiplex"
                                                            style="font-size:14px; text-align: center;"> <b>SYSTEM
                                                                VOLTAGE [V]</b></p>
                                                        <div class="chart">

                                                            <canvas id="graf_1" height="280"
                                                                style="height: 280;"></canvas>
                                                        </div>
                                                    </div>

                                                    <div class="row">

                                                        <div class="col-12   " id="divgraph2" name="divgraph2">
                                                            <hr style=" border: 1px solid #007bff;">
                                                            <p class="colorazulfiplex"
                                                                style="font-size:14px; text-align: center;">
                                                                <b>BATTERIES VOLTAGE [V] </b>
                                                            </p>
                                                            <div class="chart">
                                                                <canvas id="graf_2" height="280"
                                                                    style="height: 280;"></canvas>
                                                            </div>
                                                        </div>


                                                    


                                                        <div class="col-12    " id="divgraph4" name="divgraph4">
                                                            <hr style=" border: 1px solid #007bff;">
                                                            <p class="colorazulfiplex"
                                                                style="font-size:14px;  text-align: center;">
                                                                <b>INDIVIDUAL BATTERY VOLTAGE [V]</b>
                                                            </p>
                                                            <div class="chart">
                                                                <canvas id="graf_4" height="280"
                                                                    style="height: 280;"></canvas>
                                                            </div>
                                                        </div>


                                                        <BR><BR><BR><BR>




                                                    </div>
                                                </div>
                                </section>

                                <BR><BR><BR><BR>



                                <!-- /.col -->
                                <br><br>

                            </div>
                            <!-- /.timeline -->
                        </div>
                        <BR><BR><BR><BR>
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

<script src="crypto-js.js"></script>
<!-- https://github.com/brix/crypto-js/releases crypto-js.js can be download from here -->

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
$(document).ready(function() {

    var interval = setInterval(function() {

        var momentNow = moment();
        var newYork = momentNow.tz('America/New_York').format('ha z');
        $('#date-part').html(momentNow.format('YYYY/MM/DD'));
        $('#time-part').html(momentNow.format('hh:mm:ss'));
    }, 100);


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

    armar_graficos_imdstress();

});

var cant_veces_controlo = 0;
var cant_veces_controlo_limit = 15;
//var container = document.getElementById('visualization');
//var timeline = new vis.Timeline(container);
var refreshIntervalIdbuscaruninfo = 0;

var datamm = {};
var iduniqueop_band_0_uldl_0_tx = "";
var iduniqueop_band_0_uldl_1_tx = "";
var iduniqueop_band_1_uldl_0_tx = "";
var iduniqueop_band_1_uldl_1_tx = "";
var label_tx = {};
var label_tx_0_1 = {};
var label_tx2 = "";
var label_tx_1 = "";
var datax = '';
var label_700_compartir = '';

var graf_total_0_0 = "N";
var graf_rx_0_0 = "N";
var graf_tx_0_0 = "N";
var graf_total_0_1 = "N";
var graf_rx_0_1 = "N";
var graf_tx_0_1 = "N";
var graf_total_1_0 = "N";
var graf_rx_1_0 = "N";
var graf_tx_1_0 = "N";
var graf_total_1_1 = "N";
var graf_rx_1_1 = "N";
var graf_tx_1_1 = "N";

// recuperamos el querystring
const querystring = window.location.search
console.log(querystring) // '?q=pisos+en+barcelona&ciudad=Barcelona'

// usando el querystring, creamos un objeto del tipo URLSearchParams
const params = new URLSearchParams(querystring)

function window_mouseout(obj, evt, fn) {

    if (obj.addEventListener) {

        obj.addEventListener(evt, fn, false);
    } else if (obj.attachEvent) {

        obj.attachEvent('on' + evt, fn);
    }
}


function secondsToString(seconds) {
    var hour = Math.floor(seconds / 3600);
    hour = (hour < 10) ? '0' + hour : hour;
    var minute = Math.floor((seconds / 60) % 60);
    minute = (minute < 10) ? '0' + minute : minute;
    var second = seconds % 60;
    second = (second < 10) ? '0' + second : second;
    return hour + ':' + minute + ':' + second;
}



function armar_graficos_imdstress() {

    ///////////////////////
    $.ajax({
        url: 'ajax_graph_reportstressbbummsmvo2.php?unitsn=' + params.get('unitsn') + '&idrun=' + params.get( 
            'idrun'),
        data: "idns=" + params.get('idr'),
        type: 'post',
        async: true,
        cache: false,
        success: function(data) {
            ///    console.log('IMD STRESS');

            $('#msjwaitline ').hide();
            ///console.log(JSON.parse( data.label_tx ));
            //var keyssmm = Object.keys(datax);
            ///console.log(keyssmm);
            var graf_1 = $('#graf_1').get(0).getContext('2d');
            var graf_2 = $('#graf_2').get(0).getContext('2d');
            var graf_3 = $('#graf_3').get(0).getContext('2d');
            var graf_4 = $('#graf_4').get(0).getContext('2d');
            var graf_current_pwr  = $('#graf_current_pwr').get(0).getContext('2d'); 
            var graf_current_ieload2 = $('#graf_current_ieload2').get(0).getContext('2d'); 



            data_values_System_Voltage_vsys = data.values_System_Voltage_vsys.split(",");
            data_values_System_Voltage_vin = data.values_System_Voltage_vin.split(",");
            data_values_Battery_Voltage_veload =  data.values_System_vload1.split(",");
 
            data_values_Battery_Voltage_vbank = data.values_Battery_Voltage_vbank.split(",");
            data_values_Battery_Voltage_vbat = data.values_Battery_Voltage_vbat.split(",");
            data_values_Battery_Voltage_vload2 = data.values_System_vload2.split(",");

            ///temporal.
           /// 
             data_values_CurrentComsum_ibat = data.values_CurrentComsum_ibat.split(",");

            label_label_system_volt = data.label_system_volt.split(",");


            data_values_CurrentComsum_iin = data.values_CurrentComsum_iin.split(",");
            data_values_CurrentComsum_ieload = data.values_CurrentComsum_ieload.split(",");
            data_values_CurrentComsum_ieload2batt = data.values_CurrentComsum_ieload2.split(",");
            data_values_individual_batt_volt_vbat1 = data.values_individual_batt_volt_vbat1.split(",");
            data_values_individual_batt_volt_vbat2 = data.values_individual_batt_volt_vbat2.split(",");


            console.log('datos_values_pacurrent_pwr');
            var sumarmunitos = new Date('2020-01-01 00:00:00');
            var nuevolabeltemp_0_0_temp = [];
            for (let i = 0; i < label_label_system_volt.length; i++) {

                var date1 = moment("2022-01-01 " + label_label_system_volt[0]);
                var date2 = moment("2022-01-01 " + label_label_system_volt[i]);


                var diff = date2.diff(date1, 's');

                nuevolabeltemp_0_0_temp.push(secondsToString(diff));


            }

            //----------------------LOAD POWER
            datos_values_pacurrent_pwr = data.values_pacurrent_pwr.split(",");  
            label_values_pacurrent_pwr = data.label_pacurrent_pwr.split(",");  

            for ( var i = 0, j = datos_values_pacurrent_pwr.length ; i < j; i++ ) {
                              if ( datos_values_pacurrent_pwr[ i ] == '' ) {
                                datos_values_pacurrent_pwr.splice( i, 1 );
                              i--;
                              }
                            }

            var optiontemp_3loadp2load = {                             
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
                                
                                               
                                              }
                                        
                                          
                                            }]
                                          }
                                        }               

            var optiontemp_3loadp = {                             
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
                                     var datos_grafico_pacurrent_pwr = {
                                        labels  : nuevolabeltemp_0_0_temp,
                                                datasets: [
                                                {
                                                  label               :  'PELOAD1 [LOAD]',
                                                    backgroundColor     : 'rgba(60,141,188,0.1)',
                                                    borderColor         : 'rgba(60,141,188,1)',
                                                    pointRadius          : false,
                                                    pointColor          : '#3b8bba',
                                                    pointStrokeColor    : 'rgba(60,141,188,1)',
                                                    pointHighlightFill  : '#fff',
                                                    pointHighlightStroke: 'rgba(60,141,188,1)',
                                                  data                :  datos_values_pacurrent_pwr                                
                                                  }
                                                
                                          ]
                                        };


                                    


                                        var datos_grafico_pacurrent_ieload2 = {
                                        labels  : nuevolabeltemp_0_0_temp,
                                                datasets: [
                                                {
                                                  label               :  'IELOAD2 [BATTERY]',
                                                    backgroundColor     : 'rgba(60,141,188,0.1)',
                                                    borderColor         : 'rgba(60,141,188,1)',
                                                    pointRadius          : false,
                                                    pointColor          : '#3b8bba',
                                                    pointStrokeColor    : 'rgba(60,141,188,1)',
                                                    pointHighlightFill  : '#fff',
                                                    pointHighlightStroke: 'rgba(60,141,188,1)',
                                                  data                :  data_values_CurrentComsum_ieload2batt                                
                                                  }
                                                
                                          ]
                                        };

            var rpt_grafico700imdstress03 = new Chart(graf_current_pwr, { 
                              type: 'line', 	
                              data: datos_grafico_pacurrent_pwr, 	 
                              options: optiontemp_3loadp
                            });


             var rpt_graf_current_ieload2 = new Chart(graf_current_ieload2, { 
                              type: 'line', 	
                              data: datos_grafico_pacurrent_ieload2, 	 
                              options: optiontemp_3loadp2load
                            });                
           //----------------------FIN LOAD POWER

            for (var i = 0, j = data_values_System_Voltage_vsys.length; i < j; i++) {
                if (data_values_System_Voltage_vsys[i] == '') {
                    data_values_System_Voltage_vsys.splice(i, 1);
                    i--;
                }
            }

            for (var i = 0, j = data_values_System_Voltage_vin.length; i < j; i++) {
                if (data_values_System_Voltage_vin[i] == '') {
                    data_values_System_Voltage_vin.splice(i, 1);
                    i--;
                }
            }

            for (var i = 0, j = data_values_Battery_Voltage_vbank.length; i < j; i++) {
                if (data_values_Battery_Voltage_vbank[i] == '') {
                    data_values_Battery_Voltage_vbank.splice(i, 1);
                    i--;
                }
            }

            for (var i = 0, j = data_values_Battery_Voltage_vbat.length; i < j; i++) {
                if (data_values_Battery_Voltage_vbat[i] == '') {
                    data_values_Battery_Voltage_vbat.splice(i, 1);
                    i--;
                }
            }

            for (var i = 0, j = data_values_Battery_Voltage_vload2.length; i < j; i++) {
                if (data_values_Battery_Voltage_vload2[i] == '') {
                    data_values_Battery_Voltage_vload2.splice(i, 1);
                    i--;
                }
            }

            for (var i = 0, j = data_values_Battery_Voltage_veload.length; i < j; i++) {
                if (data_values_Battery_Voltage_veload[i] == '') {
                    data_values_Battery_Voltage_veload.splice(i, 1);
                    i--;
                }
            }

            for (var i = 0, j = data_values_CurrentComsum_ibat.length; i < j; i++) {
                if (data_values_CurrentComsum_ibat[i] == '') {
                    data_values_CurrentComsum_ibat.splice(i, 1);
                    i--;
                }
            }

            for (var i = 0, j = data_values_CurrentComsum_iin.length; i < j; i++) {
                if (data_values_CurrentComsum_iin[i] == '') {
                    data_values_CurrentComsum_iin.splice(i, 1);
                    i--;
                }
            }

            for (var i = 0, j = data_values_CurrentComsum_ieload.length; i < j; i++) {
                if (data_values_CurrentComsum_ieload[i] == '') {
                    data_values_CurrentComsum_ieload.splice(i, 1);
                    i--;
                }
            }
            for (var i = 0, j = data_values_CurrentComsum_ieload2batt.length; i < j; i++) {
                if (data_values_CurrentComsum_ieload2batt[i] == '') {
                    data_values_CurrentComsum_ieload2batt.splice(i, 1);
                    i--;
                }
            }


            for (var i = 0, j = data_values_individual_batt_volt_vbat1.length; i < j; i++) {
                if (data_values_individual_batt_volt_vbat1[i] == '') {
                    data_values_individual_batt_volt_vbat1.splice(i, 1);
                    i--;
                }
            }

            for (var i = 0, j = data_values_individual_batt_volt_vbat2.length; i < j; i++) {
                if (data_values_individual_batt_volt_vbat2[i] == '') {
                    data_values_individual_batt_volt_vbat2.splice(i, 1);
                    i--;
                }
            }

          



            //     console.log(nuevolabeltemp_0_0_temp); 
            var datos_grafico_graph_01 = {
                labels: nuevolabeltemp_0_0_temp,
                datasets: [{
                        label: 'VSYS',
                        backgroundColor: 'rgba(60,141,188,0.1)',
                        borderColor: 'rgba(60,141,188,1)',
                        pointRadius: false,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(60,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: data_values_System_Voltage_vsys
                    }, {
                        label: 'VIN ',
                        backgroundColor: 'rgba(255, 99, 132, 0.5)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        pointRadius: false,
                        pointColor: 'rgba(255, 99, 132, 1)',
                        pointStrokeColor: '#c1c7d1',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(255, 99, 132, 1)',
                        data: data_values_System_Voltage_vin
                    }, {
                        label: 'VELOAD1 [LOAD]',
                         backgroundColor: 'rgba(72, 176, 106, 0.5)',
                        borderColor: 'rgba(72, 176, 106, 1)',
                        pointRadius: false,
                        pointColor: 'rgba(72, 176, 106, 1)',
                        pointStrokeColor: '#c1c7d1',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(72, 176, 106, 1)',
                        data: data_values_Battery_Voltage_veload
                    } 



                ]
            };


            var datos_grafico_graph_02 = {
                labels: nuevolabeltemp_0_0_temp,
                datasets: [{
                        label: 'VBANK',
                        backgroundColor: 'rgba(72, 176, 106, 0.5)',
                        borderColor: 'rgba(72, 176, 106, 1)',
                        pointRadius: false,
                        pointColor: 'rgba(72, 176, 106, 1)',
                        pointStrokeColor: '#c1c7d1',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(72, 176, 106, 1)',
                        data: data_values_Battery_Voltage_vbank
                    },
                    {
                        label: 'VBAT',
                        backgroundColor: 'rgba(255, 255, 0, 0.5)',
                        borderColor: 'rgba(255, 255, 0, 1)',
                        pointRadius: false,
                        pointColor: 'rgba(255, 255, 0, 1)',
                        pointStrokeColor: '#c1c7d1',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(255, 255, 0, 1)',
                        data: data_values_Battery_Voltage_vbat
                    }
                   


                ]
            };

            var datos_grafico_graph_03 = {
                labels: nuevolabeltemp_0_0_temp,
                datasets: [{
                        label: 'IBAT',
                        backgroundColor: 'rgba(60,141,188,0.1)',
                        borderColor: 'rgba(60,141,188,1)',
                        pointRadius: false,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(60,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: data_values_CurrentComsum_ibat
                    },
                    {
                        label: 'IIN',
                        backgroundColor: 'rgba(255, 99, 132, 0.5)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        pointRadius: false,
                        pointColor: 'rgba(255, 99, 132, 1)',
                        pointStrokeColor: '#c1c7d1',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(255, 99, 132, 1)',
                        data: data_values_CurrentComsum_iin
                    },
                    {
                        label: 'IELOAD1 [LOAD]',
                        backgroundColor: 'rgba(0, 153,0, 0.5)',
                        borderColor: 'rgba(0, 153,0, 1)',
                        pointRadius: false,
                        pointColor: 'rgba(0, 153,0, 1)',
                        pointStrokeColor: '#c1c7d1',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(0, 153,0, 1)',
                        data: data_values_CurrentComsum_ieload
                    }


                ]
            };


            var datos_grafico_graph_04 = {
                labels: nuevolabeltemp_0_0_temp,
                datasets: [{
                        label: 'VBAT 1',
                        backgroundColor: 'rgba(60,141,188,0.1)',
                        borderColor: 'rgba(60,141,188,1)',
                        pointRadius: false,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(60,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: data_values_individual_batt_volt_vbat1
                    },
                    {
                        label: 'VBAT 2',
                        backgroundColor: 'rgba(0, 153,0, 0.5)',
                        borderColor: 'rgba(0, 153,0, 1)',
                        pointRadius: false,
                        pointColor: 'rgba(0, 153,0, 1)',
                        pointStrokeColor: '#c1c7d1',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(0, 153,0, 1)',
                        data: data_values_individual_batt_volt_vbat2
                    }

                ]
            };


            var optiontemp_4 = {
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    display: true
                },
                title: {
                    display: false,
                    text: ' '
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

            var optiontemp_3 = {
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    display: true
                },
                title: {
                    display: false,
                    text: ' '
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

            var optiontemptempp = {
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    display: true
                },
                title: {
                    display: false,
                    text: '-- '
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

            var optiontemp = {
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    display: true
                },
                title: {
                    display: false,
                    text: '-- '
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

            var optiontemp2 = {
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    display: true
                },
                title: {
                    display: false,
                    text: '-- '
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

           var rpt_grafico700imdstress01 = new Chart(graf_1, {
                type: 'line',
                data: datos_grafico_graph_01,
                options: optiontemp
            });
            console.log(datos_grafico_graph_01);

            var rpt_grafico700imdstress01separ = new Chart(graf_2, {
                type: 'line',
                data: datos_grafico_graph_02,
                options: optiontemp2
            });


            var rpt_grafico700imdstress012 = new Chart(graf_3, {
                type: 'line',
                data: datos_grafico_graph_03,
                options: optiontemp_3
            });

           var rpt_grafico700imdstress02 = new Chart(graf_4, {
                type: 'line',
                data: datos_grafico_graph_04,
                options: optiontemp_4
            });



        }
    });


}
</script>

</html>
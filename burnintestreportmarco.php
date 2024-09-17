<!DOCTYPE html>
<?php 

// Desactivar toda notificación de error
error_reporting(0);
// Notificar todos los errores de PHP (ver el registro de cambios)
//error_reporting(E_ALL);
 include("db_conect.php"); 
 
 	session_start();
 
	 if(isset($_SESSION["timeout"])){
        // Calcular el tiempo de vida de la sesión (TTL = Time To Live)
	//	echo "***********hola".time() - $_SESSION["timeout"];
        $sessionTTL = time() - $_SESSION["timeout"];
        if($sessionTTL > $inactividad){
			session_unset();
            session_destroy();
            header("Location: http://".$ipservidorapache."/index.php");
        }
			if ($_SESSION["a"] =="")
		{
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
	
		/// DETECTO PERMISOS EN PAG!
		 $sql = $connect->prepare("select bum.idmenu, menu_action.idmenu_action,  menu_action.nameaction from business_user_menu as bum inner join menu on menu.idmenu = bum.idmenu left join business_user_menu_action as buma on buma.idbusiness = bum.idbusiness and buma.iduserfas =  bum.iduserfas and buma.idmenu =  bum.idmenu left join menu_action on menu_action.idmenu_action = buma.idaction where menu.linkaccess  =  '".array_pop(explode('/', $_SERVER['PHP_SELF']))."' and bum.iduserfas = ".$_SESSION["a"]." and bum.idbusiness = ".$_SESSION["i"]);
		$sql->execute();
		$resultado = $sql->fetchAll();							
		$pag_habilitada = "N";
		
		$permiso_create_edit_po = "N";
		$permiso_param_po = "N";
		$permiso_assing_so = "N";
		$permiso_assing_sn = "N";
		
		foreach ($resultado as $row) 
		{
			$pag_habilitada = "Y";
					

		}
	
		if ($pag_habilitada == "N")
		{
			///echo "the user: ".$_SESSION["b"]." cannot access the menu: ".array_pop(explode('/', $_SERVER['PHP_SELF'])).", contact the webfas administrator";
		//	header("Location: http://".$ipservidorapache."/".$folderservidor."/permissiondenied.php?b=".$_SESSION["b"]."&c=".array_pop(explode('/', $_SERVER['PHP_SELF'])));
			//exit();
		}
	
	
	$status = $connect->getAttribute(PDO::ATTR_CONNECTION_STATUS);
	
	if ($status !="Connection OK; waiting to send.")
	{
	
		header("Location: http://".$ipservidorapache."/".$folderservidor."/errorconect.php");
		exit;
		
	}
	
			
	////////////////////////////////////////////////
	
	if (isset($_POST['poselecm']))
	{
		$vmaxid = $_POST['poselecm'];
		
		
	}
	
	////////////////////////////////////////////////
	
	
	
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

  
  <!-- AdminLTE css -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  
  
  <link href="css/tabulator_bootstrap4.css" rel="stylesheet">
  <link rel="shortcut icon" href="fiplexcirculo-01.ico" />
  
  <link rel="stylesheet" href="toastr.css">
  
  <link href="css/select2.css" rel="stylesheet" />
<link href="css/testcssselector.css" rel="stylesheet" />
  <link rel="stylesheet" href="sweetalert2/msweetalert2.min.css">
 <link href="css/tabulator_bulma.css" rel="stylesheet">
 
 
 <script src="js/jquery-1.11.1.min.js"></script>
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

<script src="crypto-js.js"></script><!-- https://github.com/brix/crypto-js/releases crypto-js.js can be download from here -->

<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="toastr.min.js"></script>

<script src="licencefiplex_mm.js"></script>
<script src="licencefiplex1.js"></script>
<script src="js/jquery.inactivityTimeout.js"></script>
<script src="js/moment-timezone-with-data.js"></script>

<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>

  <link href="css/bootstrap4-toggle.min.css" rel="stylesheet">
<script src="js/bootstrap4-toggle.min.js"></script>
<script src="js/bootstrap-typeahead.js"></script>


 <script src="js/eModal.min.js" type="text/javascript" >
<script src="js/select2.min.js"></script>
<script src="plugins/chart.js/Chart.min.js"></script>
<script src="js/dataTables.rowGroup.min.js"></script>
  
    <link rel="stylesheet" href="cssfiplex.css">
	
		<style>
	body
{
  font-family: Arial, Helvetica, sans-serif;
  font-size:12px;
}
a:link {
  color:#000000;
}

a:visited {
 color:#000000;
}

a:hover {
  color:#000000;
}

a:active {
 color:#000000;
}

.card-headermarco
{
	  font-family: Arial, Helvetica, sans-serif;
  font-size:14px;
  border-style: solid;
  border-color:#ffffff;
  border-width: 1px;
}

.example1_wrapper
{
 border-style: solid; 
  border-width: 2px;	
}

textarea.form-control {
    height: 100%;
}

.card-body.p-0 .table tbody>tr>td:first-of-type, .card-body.p-0 .table tbody>tr>th:first-of-type, .card-body.p-0 .table thead>tr>td:first-of-type, .card-body.p-0 .table thead>tr>th:first-of-type
{
	    padding-left: 0.1rem;
}
.card-body.p-0 .table tbody>tr>td:last-of-type, .card-body.p-0 .table tbody>tr>th:last-of-type, .card-body.p-0 .table thead>tr>td:last-of-type, .card-body.p-0 .table thead>tr>th:last-of-type
{
	    padding-right: 0.1rem;
}
</style>


</head>

<input type="hidden" name="uso" id="uso" value="0">
<body class="hold-transition sidebar-mini sidebar-collapse">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
 
<?php 	  
 include("menutopnotification.php"); 
 include("menu.php"); 
 include("funcionesstores.php"); 
 include ('licencefiplex_mm.php');
 
   //   $Encryption = new Encryption();
        
?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Burning Report</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home.php">Home</a></li>
              <li class="breadcrumb-item active">Burning Report</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        
        <!-- Timelime example  -->
        <div class="row">
          <section class="col-lg-3 connectedSortable ui-sortable">

            <div class="" name="divscrolllog" id="divscrolllog" style="display">
		
			  <div class="demo-container">
  
			
			
			
				<div class="card">
				<div class="container  table-responsive">
				
			<!-- aca form -->			
					<form  action="listwordorder.php" method="post" class="form-horizontal" id="myform" name="myform">	
					<input class="form-control" id="poselecm" type="hidden" name="poselecm">
					<input class="form-control" id="poselecmrev" type="hidden" name="poselecmrev">
				
					<!--- demo acordion--->

				
		
				
					<table id="tablabc" name="tablabc" class="table table-bordered table-striped  table-sm">		
                  <thead>
                    <tr>
						<th>idpetitions </th>	
						<th>Date </th>			
						<th>DibSN </th>	
						<th>Group </th>			
						<th>Component SN </th>					
					  	<th>Status SN </th>			
						
                    </tr>
                  </thead>
                  <tbody>
				  <?php
					
					$sql = $connect->prepare("

					select  COALESCE (elresumen.tpass,3) as tpassr,* ,to_char(fas_petitions_server_detailssfp.datetimedet,'YYYY/MM') as fechahoradetalle 
					from fas_petitions_server_detailssfp
					inner join fas_petitions_server
					on fas_petitions_server.idpetition = fas_petitions_server_detailssfp.idpetition
					and fas_petitions_server.status in(2,1)
					left join
					(
						select  COALESCE (fas_calibration_result.totalpass ::boolean::int ,3) as tpass , fas_tree_measure.* ,
						to_char(datetime,'YYYY/MM') as fechahorma, 
						datetime as fechahorma1 from fas_tree_measure
					inner join (
					select distinct unitsn,  max(datetime) as maxfechaxsn  from fas_tree_measure where iduniquebranch like '03F%'
					and  unitsn  <> '' and datetime >'2020/08/01'
					group by unitsn
					) as losmaxsn
					on  losmaxsn.unitsn  = fas_tree_measure.unitsn and
				
					losmaxsn.maxfechaxsn = fas_tree_measure.datetime
					left join fas_calibration_result
					on fas_calibration_result.unitsn = fas_tree_measure.unitsn 
					and fas_calibration_result.idruninfo = fas_tree_measure.idrununfo
					

					where datetime >'2020/10/22'
					order by datetime desc ,  fas_tree_measure.unitsn desc 
					) as elresumen
					on fas_petitions_server_detailssfp.sndet = elresumen.unitsn
					where fas_petitions_server_detailssfp.reference = 'burningtest'
					order by fas_petitions_server_detailssfp.idpetition desc, snsdib,idgroupby, idfasserverdetails 

");
		   
						   $sql->execute();
						   $resultado = $sql->fetchAll();
						   $idcantrow=1;
						   foreach ($resultado as $row) {
							$v_unitsn = $row['sndet'];
								 $v_idruninfo =  $row['idruninfo'];
						   
						   
							   
							   
						   ?>
						   
						   <tr>       
						   <td><b>Run # <?php echo substr($row['idpetition'],0,18); ?></b></td>             
						<td><b>Date: <i class='fas fa-calendar-alt'></i> <?php if (substr($row['fechahoradetalle'],0,20)=="")  { echo "Unfinished execution";} else { echo substr($row['fechahoradetalle'],0,20);} ?></b></td>
						<td><b> <?php
						$lasporcions = explode("#",$row['snsdib']);
						echo $lasporcions[0]; ?></b></td>
						<td><?php echo substr($row['idgroupby'],0,918); ?></td>
						 <td><a href="burnintestreport.php?sns=<?php echo  $v_unitsn."&idr=".$v_idruninfo; ?>">
						 <?php 
						 if ($v_unitsn == $_REQUEST['sns'])
						 {
							 echo  "<b><span class='colorazulfiplex'>".$v_unitsn."</b> <i class='fas fa-eye' style='color:#0053a1;' ></i></span>";
						 }
						 else
						 {
							 echo "".$v_unitsn."</b> <i class='fas fa-eye'></i>";
						 }
						 ?>
						
						 </a> </td>
						  <td><?php
						
							if (   $row['tpassr'] ==1)
								{
									?>
									<span class="badge badge-pill badge-success">Passed</span>
									<?php
								}
								else
								{
									if (   $row['tpassr'] ==3)
									{?>
									<span class="badge badge-pill badge-warning">Not Finished</span>
									<?php
									}
									else
									{
										?>
											<span class="badge badge-pill badge-danger">Failed</span>
									<?php
									}
									?>
								
									<?php
								}

						 ?> </td>
								</tr>
				   
						   <?php
				   

						   }
			   ?>
                  </tbody>
                </table>
				<div>	
				<!--	
					Pregunta al Agus.	Funciona como STOCK  ??
				
				para cada idunique operation voy a buscar a la tabla  fas_fiberoptickcheck
					
					para ver si paso o no pas . fas_calibration_result
					
					FSP.. en el CUI == 
					fas_calibration_result
					unit sn ? 
				-->
			
				
				</div>	
			</div>
			
					

        </section>
		<section class="col-lg-9 connectedSortable ui-sortable">
		

				<div class="card">
				<div class="card-header ui-sortable-handle" >
               		
				<div class="card">
            
              <!-- /.card-header -->
              <div class="card-body p-0" style="display: block;">
                <div class="d-md-flex">
                  <div class="p-1 flex-fill" style="overflow: hidden" >
                    
					
					<!--detalle so -->
					<div class="card" style="position: relative; left: 0px; top: 0px;">
              <div class="card-header ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title">
				
				
                  <i class="fas fas fa-tag mr-1"></i>               
				  <span name="podatos" id="podatos" class="d-none "></span> 
                </h3><p name="ciusnshow" id="ciusnshow" class="text-primary "><B>SN: <?php echo $_REQUEST['sns'];?></B> &nbsp;&nbsp;
				<?php
					 
					 $v_snpara =  $_REQUEST['sns'];
					 $v_idruninfopara =  $_REQUEST['idr'];
						 if($v_snpara <>"")
						 {

						
					  $sqltotalpass = $connect->prepare("select COALESCE (totalpass::boolean::int ,3) as totalpassint , * from fas_calibration_result where unitsn   = '".$v_snpara."' and idruninfo = ".$v_idruninfopara);
				 		$sqltotalpass->execute();
								$resultado = $sqltotalpass->fetchAll();
						$identro = 0;		
					 	foreach ($resultado as $rowresul)
						{
							$resultado_totalpass = $rowresul['totalpassint'];
							$identro = 1;		
						}
						//echo "ACA".$resultado_totalpass;
						if ($identro ==1)
						{
							if ( $resultado_totalpass ==1)
							{
								?>
								<span class="badge badge-pill badge-success">Passed</span>
								
								<?php
							}
							else
							{														
									?>
										<span class="badge badge-pill badge-danger">Failed</span>
									<?php
							
							}
						}
						else
						{
							?>
							<span class="badge badge-pill badge-warning">Not Finished</span>
						<?php
						}
					
					
							?>
							</p>


							<ul class="nav nav-pills ml-auto">
                    <li class="nav-item" name="divtabport1" id="divtabport1">
                      <a class="nav-link active" href="#tabport1" data-toggle="tab">SFP [Port 1]</a>
                    </li>
					<li class="nav-item" name="divtabport2" id="divtabport2">
                      <a class="nav-link" href="#tabport2" data-toggle="tab">SFP [Port 2]</a>
                    </li>
					
                    <li class="nav-item" name="divtabalarm" id="divtabalarm">
                      <a class="nav-link " href="#tabalarm" data-toggle="tab">Alarm</a>
                    </li>  
					
					
                  </ul>



               
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content p-0">


				
                  <!--TAB port 1 -->
				  <div class="chart tab-pane pre-scrollablemarco  active" id="tabport1" style="position: relative; ">
				  <div class="row">
								  <div class="col-6">	
								  
								    <div class="card">

										<!-- Sales Chart Canvas -->
										<div class="card-header">
										<h5 class="card-title colorazulfiplex"><b>TX</b></h5>
										<div class="card-tools">
										</div>
										</div>
										<div class="chart">
										 <div class="chartjs-size-monitor">
										 <div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
										<!-- Sales Chart Canvas -->

									 <canvas id="graftx1" style="height:150px; min-height:150px"></canvas>
										  </div>

										</div>
										
								 </div>
								  <div class="col-6">

  <div class="card">

										<!-- Sales Chart Canvas -->
										<div class="card-header">
										<h5 class="card-title colorazulfiplex"><b>RX</b></h5>
										<div class="card-tools">
										</div>
										</div>
										<div class="chart">
										 <div class="chartjs-size-monitor">
										 <div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
										<!-- Sales Chart Canvas -->

												<canvas id="grafrx1" style="height:150px; min-height:150px"></canvas>
										  </div>

										</div>

										</div>
								</div>
								<div class="row">
								  <div class="col-6">
								  
								  
										<div class="card">

										<!-- Sales Chart Canvas -->
										<div class="card-header">
										<h5 class="card-title colorazulfiplex"><b>Currents</b></h5>
										<div class="card-tools">
										</div>
										</div>
										<div class="chart">
										 <div class="chartjs-size-monitor">
										 <div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
										<!-- Sales Chart Canvas -->

										  <canvas id="grafcurrent1" style="height:150px; min-height:150px"></canvas>
										  </div>

										</div>
								
								</div>
								  <div class="col-6">
								  <div class="card">

										<!-- Sales Chart Canvas -->
										<div class="card-header">
										<h5 class="card-title colorazulfiplex"><b>Temperatures</b></h5>
										<div class="card-tools">
										</div>
										</div>
										<div class="chart">
										 <div class="chartjs-size-monitor">
										 <div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
										<!-- Sales Chart Canvas -->

										<canvas id="graftemp1" style="height:150px; min-height:150px"></canvas>
										  </div>

										</div>
										
										
								</div>
								  </div>
								  
								
					
				     <div class="chart tab-pane pre-scrollablemarco active " id="generalinfopo" style="position: relative; ">
					 

					
										<table id="tableresultm" name="tableresultm" class="table table-bordered table-striped  table-sm text-center">										 
										<thead class="thead-dark">										 
										
											<tr>
											  <th>#measure</th>
											  <th>Volt [V]</th>	
											  <th>Current [mA] </th>
											  <th>Temp DiB [°C]</th>											 
											  <th>Temp [°C]</th>
											  <th>Txpower [dBm]</th>
											  <th>Rxpower [dBm] </th>
											  
											  
											  <th>Volt state</th>
											  <th>Current state </th>
											  <th>Temp state</th>
											  <th>Tx power state  </th>
											  <th>Rx power state </th>
											    
											   
											
											  
											 </tr> 
											   </thead>
											 <tbody>
								<!----- INICIO LISTA PO  -->
							<?php
						  
							$sqlmediciones ="SELECT iduniqueop, idfiberopticcheck, voltage, current, temperature,temperaturedib, txpower, rxpower, voltagestate, currentstate, temperaturestate, txpowerstate, rxpowerstate, 
							rxerror::boolean::int, txerror::boolean::int, detectedmodule::boolean::int, txrxstatus::boolean::int, 
							datalockalarm::boolean::int, datasyncalarm::boolean::int, freqsyncalarm::boolean::int, 
							errorcount, sn from fas_fiberopticcheck where sn = 'Port 1' and  iduniqueop in(select iduniqueop from fas_tree_measure where iduniquebranch like '052%'  and unitsn = '".$_REQUEST['sns']."' and idrununfo = ".$_REQUEST['idr'].")";
							
						echo 	$sqlmediciones;
							
						  $resultadoSFP = $connect->query($sqlmediciones);	
						$idmedicionind=0;
						foreach ($resultadoSFP as $rowdatos) 
							{
							$idmedicionind= $idmedicionind +1;
						
							$lasmediciones = $lasmediciones."'".$idmedicionind."',";
							$las_current = $las_current."'".round($rowdatos['current'],1)."',";
							$las_temp = $las_temp."'".round($rowdatos['temperature'],1)."',";
							$las_tempdib = $las_tempdib."'".round($rowdatos['temperaturedib'],1)."',";
							
							$las_txpower = $las_txpower."'".round($rowdatos['txpower'],1)."',";
							$las_rxpower = $las_rxpower."'".round($rowdatos['rxpower'],1)."',";
							
							?>
								<tr>
											  <td><?php echo $idmedicionind; ?></td>
											  <td><?php echo round($rowdatos['voltage'],2); ?></th>	
											  <td><?php echo round($rowdatos['current'],2);  ?> </td>
											  <td><?php echo round($rowdatos['temperaturedib'],2); ?> </td>
											  <td><?php echo round($rowdatos['temperature'],2); ?> </td>
											  <td><?php echo round($rowdatos['txpower'],2)."<br>";  ?></td>
											  <td><?php echo round($rowdatos['rxpower'],2)."<br>";   ?> </td>
											 
											  
										
											  
											  <td><?php if ($rowdatos['voltagestate']==0) { echo "<span class='badge badge-pill badge-success'>Pass</span>";} 
													    if ($rowdatos['voltagestate']==1) { echo "<span class='badge badge-pill badge-warning'>Not Pass</span>";} 
														if ($rowdatos['voltagestate']==2) { echo "<span class='badge badge-pill badge-danger'>Not Pass</span>";} 	
													?> 
											  </td>
											  <td><?php if ($rowdatos['currentstate']==0) { echo "<span class='badge badge-pill badge-success'>Pass</span>";} 
													    if ($rowdatos['currentstate']==1) { echo "<span class='badge badge-pill badge-warning'>Not Pass</span>";} 
														if ($rowdatos['currentstate']==2) { echo "<span class='badge badge-pill badge-danger'>Not Pass</span>";} 	
													?> 
											  </td>
											  <td><?php if ($rowdatos['temperaturestate']==0) { echo "<span class='badge badge-pill badge-success'>Pass</span>";} 
													    if ($rowdatos['temperaturestate']==1) { echo "<span class='badge badge-pill badge-warning'>Not Pass</span>";} 
														if ($rowdatos['temperaturestate']==2) { echo "<span class='badge badge-pill badge-danger'>Not Pass</span>";} 	
													?> 
											  </td>
											  <td><?php if ($rowdatos['txpowerstate']==0) { echo "<span class='badge badge-pill badge-success'>Pass</span>";} 
													    if ($rowdatos['txpowerstate']==1) { echo "<span class='badge badge-pill badge-warning'>Not Pass</span>";} 
														if ($rowdatos['txpowerstate']==2) { echo "<span class='badge badge-pill badge-danger'>Not Pass</span>";} 	
													?> 
											  </td>
											  <td><?php if ($rowdatos['rxpowerstate']==0) { echo "<span class='badge badge-pill badge-success'>Pass</span>";} 
													    if ($rowdatos['rxpowerstate']==1) { echo "<span class='badge badge-pill badge-warning'>Not Pass</span>";} 
														if ($rowdatos['rxpowerstate']==2) { echo "<span class='badge badge-pill badge-danger'>Not Pass</span>";} 	
													?> 
											  </td>
											  
											  							  
											  
											  
											 </tr> 
							<?php
						}
						
				//	}
						  ?>
						  </tbody>
						  </table>
								
							
								
	
							<!----- fin INICIO LISTA PO
							
							
							
							
							select distinct idfastree,  fas_step.description ,  fas_tree_measure.iduniquebranch ,fas_tree_measure.iduniqueop, totalpass
                                from fas_tree_measure
                                inner join fas_tree
                                on fas_tree.iduniquebranch = fas_tree_measure.iduniquebranch
                                inner join fas_step
                                on fas_tree.idfastrepson = fas_step.idfasstep
                                and idfastree in(10)
                                where unitsn = '20106102FU' and idrununfo = 10901002479 and  fas_tree_measure.iduniquebranch like '052053%'     
							  -->
					
				   </div>
				  

				  </div>
				  <!--fin TAB port 1 -->
				     <!--TAB port 2 -->
					 <div class="chart tab-pane pre-scrollablemarco  " id="tabport2" style="position: relative; ">
					 <div class="chart tab-pane pre-scrollablemarco  active" id="tabport1" style="position: relative; ">
				  <div class="row">
								  <div class="col-6">	
								  
								    <div class="card">

										<!-- Sales Chart Canvas -->
										<div class="card-header">
										<h5 class="card-title colorazulfiplex"><b>TX</b></h5>
										<div class="card-tools">
										</div>
										</div>
										<div class="chart">
										 <div class="chartjs-size-monitor">
										 <div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
										<!-- Sales Chart Canvas -->

									 <canvas id="graftx2" style="height:150px; min-height:150px"></canvas>
										  </div>

										</div>
										
								 </div>
								  <div class="col-6">

  <div class="card">

										<!-- Sales Chart Canvas -->
										<div class="card-header">
										<h5 class="card-title colorazulfiplex"><b>RX</b></h5>
										<div class="card-tools">
										</div>
										</div>
										<div class="chart">
										 <div class="chartjs-size-monitor">
										 <div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
										<!-- Sales Chart Canvas -->

												<canvas id="grafrx2" style="height:150px; min-height:150px"></canvas>
										  </div>

										</div>

										</div>
								</div>
								<div class="row">
								  <div class="col-6">
								  
								  
										<div class="card">

										<!-- Sales Chart Canvas -->
										<div class="card-header">
										<h5 class="card-title colorazulfiplex"><b>Currents</b></h5>
										<div class="card-tools">
										</div>
										</div>
										<div class="chart">
										 <div class="chartjs-size-monitor">
										 <div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
										<!-- Sales Chart Canvas -->

										  <canvas id="grafcurrent2" style="height:150px; min-height:150px"></canvas>
										  </div>

										</div>
								
								</div>
								  <div class="col-6">
								  <div class="card">

										<!-- Sales Chart Canvas -->
										<div class="card-header">
										<h5 class="card-title colorazulfiplex"><b>Temperatures</b></h5>
										<div class="card-tools">
										</div>
										</div>
										<div class="chart">
										 <div class="chartjs-size-monitor">
										 <div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
										<!-- Sales Chart Canvas -->

										<canvas id="graftemp2" style="height:150px; min-height:150px"></canvas>
										  </div>

										</div>
										
										
								</div>
								  </div>
								  
								
					
				     <div class="chart tab-pane pre-scrollablemarco active " id="generalinfopo" style="position: relative; ">
					 

					
										<table id="tableresultm2" name="tableresultm2" class="table table-bordered table-striped  table-sm text-center">										 
										<thead class="thead-dark">										 
										
											<tr>
											  <th>#measure</th>
											  <th>Volt [V]</th>	
											  <th>Current [mA] </th>
											  <th>Temp DiB [°C]</th>											 
											  <th>Temp [°C]</th>
											  <th>Txpower [dBm]</th>
											  <th>Rxpower [dBm] </th>
											  
											  
											  <th>Volt state</th>
											  <th>Current state </th>
											  <th>Temp state</th>
											  <th>Tx power state  </th>
											  <th>Rx power state </th>
											    
											   
											
											  
											 </tr> 
											   </thead>
											 <tbody>
								<!----- INICIO LISTA PO  -->
							<?php
						  
							$sqlmediciones ="SELECT iduniqueop, idfiberopticcheck, voltage, current, temperature,temperaturedib, txpower, rxpower, voltagestate, currentstate, temperaturestate, txpowerstate, rxpowerstate, 
							rxerror::boolean::int, txerror::boolean::int, detectedmodule::boolean::int, txrxstatus::boolean::int, 
							datalockalarm::boolean::int, datasyncalarm::boolean::int, freqsyncalarm::boolean::int, 
							errorcount, sn from fas_fiberopticcheck where sn = 'Port 2' and  iduniqueop in(select iduniqueop from fas_tree_measure where iduniquebranch like '052%'  and unitsn = '".$_REQUEST['sns']."' and idrununfo = ".$_REQUEST['idr'].")";
							
					//	echo 	$sqlmediciones;
							
						  $resultadoSFP = $connect->query($sqlmediciones);	
						$idmedicionind2=0;
						foreach ($resultadoSFP as $rowdatos) 
							{
							$idmedicionind2= $idmedicionind2 +1;
						
							$lasmediciones2 = $lasmediciones2."'".$idmedicionind2."',";
							$las_current2 = $las_current2."'".round($rowdatos['current'],1)."',";
							$las_temp2 = $las_temp2."'".round($rowdatos['temperature'],1)."',";
							$las_tempdib2 = $las_tempdib2."'".round($rowdatos['temperaturedib'],1)."',";
							
							$las_txpower2 = $las_txpower2."'".round($rowdatos['txpower'],1)."',";
							$las_rxpower2 = $las_rxpower2."'".round($rowdatos['rxpower'],1)."',";
							
							?>
								<tr>
											  <td><?php echo $idmedicionind2; ?></td>
											  <td><?php echo round($rowdatos['voltage'],2); ?></th>	
											  <td><?php echo round($rowdatos['current'],2);  ?> </td>
											  <td><?php echo round($rowdatos['temperaturedib'],2); ?> </td>
											  <td><?php echo round($rowdatos['temperature'],2); ?> </td>
											  <td><?php echo round($rowdatos['txpower'],2)."<br>";  ?></td>
											  <td><?php echo round($rowdatos['rxpower'],2)."<br>";   ?> </td>
											 
											  
										
											  
											  <td><?php if ($rowdatos['voltagestate']==0) { echo "<span class='badge badge-pill badge-success'>Pass</span>";} 
													    if ($rowdatos['voltagestate']==1) { echo "<span class='badge badge-pill badge-warning'>Not Pass</span>";} 
														if ($rowdatos['voltagestate']==2) { echo "<span class='badge badge-pill badge-danger'>Not Pass</span>";} 	
													?> 
											  </td>
											  <td><?php if ($rowdatos['currentstate']==0) { echo "<span class='badge badge-pill badge-success'>Pass</span>";} 
													    if ($rowdatos['currentstate']==1) { echo "<span class='badge badge-pill badge-warning'>Not Pass</span>";} 
														if ($rowdatos['currentstate']==2) { echo "<span class='badge badge-pill badge-danger'>Not Pass</span>";} 	
													?> 
											  </td>
											  <td><?php if ($rowdatos['temperaturestate']==0) { echo "<span class='badge badge-pill badge-success'>Pass</span>";} 
													    if ($rowdatos['temperaturestate']==1) { echo "<span class='badge badge-pill badge-warning'>Not Pass</span>";} 
														if ($rowdatos['temperaturestate']==2) { echo "<span class='badge badge-pill badge-danger'>Not Pass</span>";} 	
													?> 
											  </td>
											  <td><?php if ($rowdatos['txpowerstate']==0) { echo "<span class='badge badge-pill badge-success'>Pass</span>";} 
													    if ($rowdatos['txpowerstate']==1) { echo "<span class='badge badge-pill badge-warning'>Not Pass</span>";} 
														if ($rowdatos['txpowerstate']==2) { echo "<span class='badge badge-pill badge-danger'>Not Pass</span>";} 	
													?> 
											  </td>
											  <td><?php if ($rowdatos['rxpowerstate']==0) { echo "<span class='badge badge-pill badge-success'>Pass</span>";} 
													    if ($rowdatos['rxpowerstate']==1) { echo "<span class='badge badge-pill badge-warning'>Not Pass</span>";} 
														if ($rowdatos['rxpowerstate']==2) { echo "<span class='badge badge-pill badge-danger'>Not Pass</span>";} 	
													?> 
											  </td>
											  
											  							  
											  
											  
											 </tr> 
							<?php
						}
						
					
						  ?>
						  </tbody>
						  </table>
								
							
								
	
						
					
				   </div>
				   </div>
				   </div>
				
				  <!--fin TAB port 2 -->
				     <!--TAB ALARM-->
					 <?php
					 
					 $sqlresumenalar="select  fas_step.description , array_agg( totalpass order by iduniqueop asc   ) as valoralarm 
					 from fas_tree_measure inner join fas_tree on fas_tree.iduniquebranch = fas_tree_measure.iduniquebranch inner join fas_step on
					  fas_tree.idfastrepson = fas_step.idfasstep and idfastree in(SELECT 10 FROM fas_petitions_server_detailssfp where 
					    sndet = '".$_REQUEST['sns']."'and upper(snsdib) like '%MASTER%' union SELECT 11 FROM fas_petitions_server_detailssfp where sndet ='".$_REQUEST['sns']."' and upper(snsdib) like '%REMOTE%')
					   where
					    unitsn = '".$_REQUEST['sns']."'  and idrununfo = ".$_REQUEST['idr']."  and fas_tree_measure.iduniquebranch like '052053%'
					 group by  fas_step.description ";
					 
					 ?>
					 <div class="chart tab-pane pre-scrollablemarco  " id="tabalarm" style="position: relative; ">



					 <table id="tableresultm3" name="tableresultm4" class="table table-bordered table-striped  table-sm text-center">										 
										<thead class="thead-dark">										 
										
											<tr>
											<th>#</th>	
											<?php
											$resultadoSFPres = $connect->query($sqlresumenalar);	
					  $idmedigryup=0;
					  $array_alam = array();
					  foreach ($resultadoSFPres as $rowdatosresu) 
						  {
							  $datosname = explode("_", $rowdatosresu['description']);
							  echo "<th>".$datosname[2]."</th>	";
							  array_push($array_alam,$rowdatosresu['valoralarm']);
						//	echo "la cant".count($array_alam);
						  }
						  ?>
										 </tr> 
											   </thead>
											 <tbody>
								  <?php 
								  
									$lasalarmas0 = explode(",",$array_alam[0]);
									$lasalarmas1 = explode(",",$array_alam[1]);
									$lasalarmas2 = explode(",",$array_alam[2]);
									$lasalarmas3 = explode(",",$array_alam[3]);
									$lasalarmas4 = explode(",",$array_alam[4]);
								//	echo "<br>la cant".count($lasalarmas0);
								$searchforreplace = array("{", "}");
									
									foreach ($lasalarmas0 as $clave => $valor) 
									{
										$idmedigryup = $idmedigryup + 1;
									//	echo "<br>HOLA FOR".$clave."--".$valor;
										?><tr>
											<td><?php echo $idmedigryup; ?></td>
											<?php if (count($array_alam)>1 )
											{?>
											<td><?php //echo str_replace($vowels, "", $lasalarmas0[$clave]);
												if ( str_replace($searchforreplace, "", $lasalarmas0[$clave])	=="f") { echo "<span class='badge badge-pill badge-success'>Pass</span>";} 
												if ( str_replace($searchforreplace, "", $lasalarmas0[$clave])	=="t") { echo "<span class='badge badge-pill badge-danger'>Failed</span>";} 
												 ?></td>

											<?php } ?>	 
											<td><?php //echo $lasalarmas1[$clave]; 
													if ( str_replace($searchforreplace, "", $lasalarmas1[$clave])	=="f") { echo "<span class='badge badge-pill badge-success'>Pass</span>";} 
													if ( str_replace($searchforreplace, "", $lasalarmas1[$clave])	=="t") { echo "<span class='badge badge-pill badge-danger'>Failed</span>";} 
													?></td>
											<td><?php //echo $lasalarmas2[$clave];
												if ( str_replace($searchforreplace, "", $lasalarmas2[$clave])	=="f") { echo "<span class='badge badge-pill badge-success'>Pass</span>";} 
												if ( str_replace($searchforreplace, "", $lasalarmas2[$clave])	=="t") { echo "<span class='badge badge-pill badge-danger'>Failed</span>";}  ?>
												</td>
												<?php if (count($array_alam)>3 )
											{?>
												<td><?php //echo $lasalarmas2[$clave];
												if ( str_replace($searchforreplace, "", $lasalarmas3[$clave])	=="f") { echo "<span class='badge badge-pill badge-success'>Pass</span>";} 
												if ( str_replace($searchforreplace, "", $lasalarmas3[$clave])	=="t") { echo "<span class='badge badge-pill badge-danger'>Failed</span>";}  ?>
												</td>

												<td><?php //echo $lasalarmas2[$clave];
												if ( str_replace($searchforreplace, "", $lasalarmas4[$clave])	=="f") { echo "<span class='badge badge-pill badge-success'>Pass</span>";} 
												if ( str_replace($searchforreplace, "", $lasalarmas4[$clave])	=="t") { echo "<span class='badge badge-pill badge-danger'>Failed</span>";}  ?>
												</td>
											<?php } ?>
											</tr>
										<?php
									}
								 
								 ?>
											 </tbody>
						</table>

				
				  </div>
				  <!--fin TABALARM -->



				<p name="msjwaitline" id="msjwaitline" align="center"><img src="img/waitazul.gif" width="100px" ></p>
                  <!-- Morris chart - Sales -->
				  <?php
						}
						
					
						  ?>		  
						
						 
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
					<!-- fin detalle so -->
					
					<p name="detallelog1" id="detallelog1" ></p>						
					<p name="msjwait" id="msjwait" align="center"><img src="img/waitazul.gif" width="100px" ></p>						
                  </div>
              
                  </div><!-- /.card-pane-right -->
                </div><!-- /.d-md-flex -->
              </div>
              <!-- /.card-body -->
            </div>
				  
				  
              
				</div>	
				</div>	
		 </section>
          <!-- /.col -->
        </div>
      </div>
      <!-- /.timeline -->

    </section>
    <!-- /.content -->
	
	
	
  </div>
  <!-- /.content-wrapper -->
  
  </form>

<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Server Time:</b> 

<span name="date-part" id="date-part"></span>
<span name="time-part" id="time-part"></span>
    </div>
    <strong>Copyright &copy; 2020 Admin Fas FIPLEX</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->

</body>

<script type="text/javascript">

 var tabla_cui_cant = [];
  var tabla_channel_quantity = [];
var tabla_gain_dlul= [];
var tabla_dpx =[];

function getUrlVars()
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}

   
	$( document ).ready(function() {
		
		//Inicio mostrar hora live
			$('#msjwaitline ').hide();
		 var interval = setInterval(function() {
			 
        var momentNow = moment();
		var newYork    = momentNow.tz('America/New_York').format('ha z');
        $('#date-part').html(momentNow.format('YYYY/MM/DD') 	  );
        $('#time-part').html(momentNow.format('hh:mm:ss'));
	
		}, 100);
		//FIN mostrar hora live
			console.log( "ready2!" );
			$('#msjwaitline ').hide();
			   $('.js-example-basic-single').select2();
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

				  if ($(window).height()>640)
			{
				var altor=  $(window).height() - 200+'px';
			}
			else
			{
				var altor=  "560px";
			}
			var coloresscrpit = ""
		    var vv_userruninfo="";
			var vv_station ="";
			
					

		///fin prueba de tabulator
		  $("#myInput").on("keyup", function() {
			var value = $(this).val().toLowerCase();
			$("#myTable tr").filter(function() {
			  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		  });
	
	
		///  var tablemm =   $('#tablabc').DataTable( { 	"order": [[ 0, "desc" ]],  "paging": true,  "pageLength": 100 } );

		var tablemm = 	  $('#tablabc').DataTable( {
        order: [[0, 'desc'], [1, 'asc'],[2, 'asc']],  "paging": true,  "pageLength": 10000,	
		columnDefs: [      {"className": "dt-left", "targets": "_all"}      ],	
        rowGroup: {
            dataSrc: [ 0,1,2 ]
        },
        columnDefs: [ {
            targets: [ 0,1,2 ],
            visible: false
        } ]
    } );
		
		
		
		/*
			var parametrofiltrado = (new URL(location.href)).searchParams.get('sns')
			console.log(parametrofiltrado);
			if (parametrofiltrado != null)
			{
				$( "input[type='search']").val( parametrofiltrado);
				// tablemm.search( parametrofiltrado ).draw();
			}
			*/
			
	});
	

	// controlar inactividad en la web	
	/*	$(document).inactivityTimeout({
                inactivityWait: 500,
                dialogWait: 100,
                logoutUrl: 'index.php?t=jquerytimeout'
            })*/
	// fin controlar inactividad en la web		
	
	 /* requesting data */
     		
		

	 var graficocurrent = $('#grafcurrent1').get(0).getContext('2d')
   var graftemp = $('#graftemp1').get(0).getContext('2d')
   var graftx = $('#graftx1').get(0).getContext('2d')
   var grafrx = $('#grafrx1').get(0).getContext('2d')

   var graficocurrent2 = $('#grafcurrent2').get(0).getContext('2d')
   var graftemp2 = $('#graftemp2').get(0).getContext('2d')
   var graftx2 = $('#graftx2').get(0).getContext('2d')
   var grafrx2 = $('#grafrx2').get(0).getContext('2d')
  
		
	var areaChartData = {
      labels  : [<?php echo $lasmediciones;?>],
      datasets: [
        {
          label               : 'Current',          
		  backgroundColor     : 'rgba(60,141,188,0.3)',
        borderColor         : 'rgba(60,141,188,1)',
        pointRadius          : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [<?php echo $las_current;?>]
        },
      ]
    }
	
		var areaChartDatatemp = {
      labels  : [<?php echo $lasmediciones;?>],
      datasets: [
        {
          label               : 'Temp SFP',          
		  backgroundColor     : 'rgba(60,141,188,0.3)',
        borderColor         : 'rgba(60,141,188,1)',
        pointRadius          : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [<?php echo $las_temp;?>]
        },
		{
          label               : 'Temp DiB',          
		  backgroundColor     : 'rgba(153,0,0,0.3)',
        borderColor         : 'rgba(153,0,0,1)',
        pointRadius          : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(153,0,0,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(153,0,0,1)',
          data                : [<?php echo $las_tempdib;?>]
        },
      ]
    }
	
		var areaChartDatatx = {
      labels  : [<?php echo $lasmediciones;?>],
      datasets: [
        {
          label               : 'TX',          
		  backgroundColor     : 'rgba(60,141,188,0.3)',
        borderColor         : 'rgba(60,141,188,1)',
        pointRadius          : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [<?php echo $las_txpower;?>]
        },
      ]
    }
	
			var areaChartDatarx = {
      labels  : [<?php echo $lasmediciones;?>],
      datasets: [
        {
          label               : 'RX',          
		   backgroundColor     : 'rgba(60,141,188,0.3)',
        borderColor         : 'rgba(60,141,188,1)',
        pointRadius          : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [<?php echo $las_rxpower;?>]
        },
      ]
    }
	
	
		

		
		 var areaChartOptions = {
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: true
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : false,
          }
        }],
        yAxes: [{
          gridLines : {
            display : false,
          }
        }]
      }
    }
	
	var optionesbasicasgraficotx= {
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
		ticks: {
                    suggestedMin: 3,
                    suggestedMax: 6
                },
        gridLines : {
          display : true,
		 
        }				
      }]
    }
  }  

  var optionesbasicasgraficorx= {
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
		ticks: {
                    suggestedMin: -8,
                    suggestedMax: 0
                },
        gridLines : {
          display : true,
		 
        }				
      }]
    }
  }  

  var optionesbasicasgraficocurrent= {
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
		ticks: {
                    suggestedMin: 30,
                    suggestedMax: 40
                },
        gridLines : {
          display : true,
		 
        }				
      }]
    }
  } 

  var optionesbasicasgraficotemp= {
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
		ticks: {
                    suggestedMin: 40,
                    suggestedMax: 70
                },
        gridLines : {
          display : true,
		 
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

  ///desde aca 
  var areaChartData2 = {
      labels  : [<?php echo $lasmediciones;?>],
      datasets: [
        {
          label               : 'Current',          
		  backgroundColor     : 'rgba(60,141,188,0.3)',
        borderColor         : 'rgba(60,141,188,1)',
        pointRadius          : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [<?php echo $las_current2;?>]
        },
      ]
    }
	
		var areaChartDatatemp2 = {
      labels  : [<?php echo $lasmediciones;?>],
      datasets: [
        {
          label               : 'Temp SFP',          
		  backgroundColor     : 'rgba(60,141,188,0.3)',
        borderColor         : 'rgba(60,141,188,1)',
        pointRadius          : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [<?php echo $las_temp2;?>]
        },
		{
          label               : 'Temp DiB',          
		  backgroundColor     : 'rgba(153,0,0,0.3)',
        borderColor         : 'rgba(153,0,0,1)',
        pointRadius          : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(153,0,0,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(153,0,0,1)',
          data                : [<?php echo $las_tempdib2;?>]
        },
      ]
    }
	
		var areaChartDatatx2 = {
      labels  : [<?php echo $lasmediciones;?>],
      datasets: [
        {
          label               : 'TX',          
		  backgroundColor     : 'rgba(60,141,188,0.3)',
        borderColor         : 'rgba(60,141,188,1)',
        pointRadius          : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [<?php echo $las_txpower2;?>]
        },
      ]
    }
	
			var areaChartDatarx2 = {
      labels  : [<?php echo $lasmediciones;?>],
      datasets: [
        {
          label               : 'RX',          
		   backgroundColor     : 'rgba(60,141,188,0.3)',
        borderColor         : 'rgba(60,141,188,1)',
        pointRadius          : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [<?php echo $las_rxpower2;?>]
        },
      ]
    }
	
	
		

		
		 var areaChartOptions2 = {
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: true
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : false,
          }
        }],
        yAxes: [{
          gridLines : {
            display : false,
          }
        }]
      }
    }
	
	var optionesbasicasgraficotx2= {
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
		ticks: {
                    suggestedMin: 3,
                    suggestedMax: 6
                },
        gridLines : {
          display : true,
		 
        }				
      }]
    }
  }  

  var optionesbasicasgraficorx2= {
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
		ticks: {
                    suggestedMin: -8,
                    suggestedMax: 0
                },
        gridLines : {
          display : true,
		 
        }				
      }]
    }
  }  

  var optionesbasicasgraficocurrent2= {
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
		ticks: {
                    suggestedMin: 30,
                    suggestedMax: 40
                },
        gridLines : {
          display : true,
		 
        }				
      }]
    }
  } 

  var optionesbasicasgraficotemp2= {
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
		ticks: {
                    suggestedMin: 40,
                    suggestedMax: 70
                },
        gridLines : {
          display : true,
		 
        }				
      }]
    }
  }   

   var optionesbasicasgrafico2= {
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
  /// fin desde aca 

    // This will get the first returned node in the jQuery collection.
    var areaChart       = new Chart(graficocurrent, { 
      type: 'line',
      data: areaChartData, 
      options: optionesbasicasgraficocurrent
    })

 var areaChart1       = new Chart(graftemp, { 
      type: 'line',
      data: areaChartDatatemp, 
      options: optionesbasicasgraficotemp
    })
	
	 var areaChart2      = new Chart(graftx, { 
      type: 'line',
      data: areaChartDatatx, 
      options: optionesbasicasgraficotx
    })
	
	 var areaChart4      = new Chart(grafrx, { 
      type: 'line',
      data: areaChartDatarx, 
      options: optionesbasicasgraficorx
    })

	////// TAB 2
	var areaChart       = new Chart(graficocurrent2, { 
      type: 'line',
      data: areaChartData2   , 
      options: optionesbasicasgraficocurrent
    })

 var areaChart1       = new Chart(graftemp2, { 
      type: 'line',
      data: areaChartDatatemp2, 
      options: optionesbasicasgraficotemp
    })
	
	 var areaChart2      = new Chart(graftx2, { 
      type: 'line',
      data: areaChartDatatx2, 
      options: optionesbasicasgraficotx
    })
	
	 var areaChart4      = new Chart(grafrx2, { 
      type: 'line',
      data: areaChartDatarx2, 
      options: optionesbasicasgraficorx
    })

		
		 $('#tableresultm').DataTable( {"order": [[ 0, "asc" ]],  "paging": true,  "pageLength": 100 	} );
		 $('#tableresultm2').DataTable( {"order": [[ 0, "asc" ]],  "paging": true,  "pageLength": 100 	} );
		 
		 $('#tableresultm4').DataTable( {"order": [[ 0, "asc" ]],  "paging": true,  "pageLength": 100 	} );
</script>


</html>


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
            <h1>SFP Report </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home.php">Home</a></li>
              <li class="breadcrumb-item active">SFP Report</li>
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

				
		
				
					<table id="tablabc" name="tablabc" class="table table-bordered table-striped  table-sm text-center">		
                  <thead>
                    <tr>
						<th>Date </th>			
						<th>Component SN </th>					
					  	<th>Status SN </th>			
						
                    </tr>
                  </thead>
                  <tbody>
				  <?php
					
					$sql = $connect->prepare("
select COALESCE (fas_calibration_result.totalpass ::boolean::int ,3) as tpass , fas_tree_measure.* , datetime as fechahorma from fas_tree_measure
inner join (
select distinct unitsn, max(datetime) as maxfechaxsn  from fas_tree_measure where iduniquebranch like '03F%'
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
");
		   
						   $sql->execute();
						   $resultado = $sql->fetchAll();
						   $idcantrow=1;
						   foreach ($resultado as $row) {
							$v_unitsn =  $row['unitsn'];
								 $v_idruninfo =  $row['idrununfo'];
						   
						   
							   
							   
						   ?>
						   
						   <tr>                    
						<td><?php echo substr($row['fechahorma'],0,18); ?></td>
						 <td><a href="acceptanceftpmarco.php?sns=<?php echo  $v_unitsn."&idr=".$v_idruninfo; ?>">
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
						
							if (   $row['tpass'] ==1)
								{
									?>
									<span class="badge badge-pill badge-success">Passed</span>
									<?php
								}
								else
								{
									if (   $row['tpass'] ==3)
									{?>
									<span class="badge badge-pill badge-warning">Not Finished</span>
									<?php
									}
									else
									{
										?>
											<span class="badge badge-pill badge-danger">Not Passed</span>
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
										<span class="badge badge-pill badge-danger">Not Passed</span>
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
               
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content p-0">
				<p name="msjwaitline" id="msjwaitline" align="center"><img src="img/waitazul.gif" width="100px" ></p>
                  <!-- Morris chart - Sales -->
						  
						
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

									 <canvas id="graftx" style="height:150px; min-height:150px"></canvas>
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

												<canvas id="grafrx" style="height:150px; min-height:150px"></canvas>
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

										  <canvas id="grafcurrent" style="height:150px; min-height:150px"></canvas>
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

										<canvas id="graftemp" style="height:150px; min-height:150px"></canvas>
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
						  
							$sqlmediciones ="SELECT iduniqueop, idfiberopticcheck, voltage, current, temperature, txpower, rxpower, voltagestate, currentstate, temperaturestate, txpowerstate, rxpowerstate, 
							rxerror::boolean::int, txerror::boolean::int, detectedmodule::boolean::int, txrxstatus::boolean::int, 
							datalockalarm::boolean::int, datasyncalarm::boolean::int, freqsyncalarm::boolean::int, 
							errorcount, sn from fas_fiberopticcheck where iduniqueop in(select iduniqueop from fas_tree_measure where iduniquebranch like '03F%' and iduniqueop > 8600 and unitsn = '".$_REQUEST['sns']."' and idrununfo = ".$_REQUEST['idr'].")";
							
					//	echo 	$sqlmediciones;
							
						  $resultadoSFP = $connect->query($sqlmediciones);	
						$idmedicionind=0;
						foreach ($resultadoSFP as $rowdatos) 
							{
							$idmedicionind= $idmedicionind +1;
							$lasmediciones = $lasmediciones."'".$idmedicionind."',";
							$las_current = $las_current."'".round($rowdatos['current'],1)."',";
							$las_temp = $las_temp."'".round($rowdatos['temperature'],1)."',";
							$las_txpower = $las_txpower."'".round($rowdatos['txpower'],1)."',";
							$las_rxpower = $las_rxpower."'".round($rowdatos['rxpower'],1)."',";
							
							?>
								<tr>
											  <td><?php echo $idmedicionind; ?></td>
											  <td><?php echo round($rowdatos['voltage'],2); ?></th>	
											  <td><?php echo round($rowdatos['current'],2);  ?> </td>
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
					}
						  ?>
						  </tbody>
						  </table>
								
							
								
	
							<!----- fin INICIO LISTA PO  -->
					
				   </div>
				  
				  
					
				
                  
                </div>
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

<script type="text/javascript" src="js/tabulator.min.js"></script>
  <link href="css/bootstrap4-toggle.min.css" rel="stylesheet">
<script src="js/bootstrap4-toggle.min.js"></script>
<script src="js/bootstrap-typeahead.js"></script>


 <script src="js/eModal.min.js" type="text/javascript" >
<script src="js/select2.min.js"></script>
<script src="plugins/chart.js/Chart.min.js"></script>
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
	
	
		  var tablemm =   $('#tablabc').DataTable( {	"order": [[ 0, "desc" ]],  "paging": true,  "pageLength": 100 } );
		  
		

		
			var parametrofiltrado = (new URL(location.href)).searchParams.get('sns')
			console.log(parametrofiltrado);
			if (parametrofiltrado != null)
			{
				$( "input[type='search']").val( parametrofiltrado);
				// tablemm.search( parametrofiltrado ).draw();
			}
			
	});
	

	// controlar inactividad en la web	
	/*	$(document).inactivityTimeout({
                inactivityWait: 500,
                dialogWait: 100,
                logoutUrl: 'index.php?t=jquerytimeout'
            })*/
	// fin controlar inactividad en la web		
	
	 /* requesting data */
     		
		

	 var graficocurrent = $('#grafcurrent').get(0).getContext('2d')
   var graftemp = $('#graftemp').get(0).getContext('2d')
   var graftx = $('#graftx').get(0).getContext('2d')
   var grafrx = $('#grafrx').get(0).getContext('2d')
  
		
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
          label               : 'Temp',          
		  backgroundColor     : 'rgba(60,141,188,0.3)',
        borderColor         : 'rgba(60,141,188,1)',
        pointRadius          : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [<?php echo $las_temp;?>]
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

    // This will get the first returned node in the jQuery collection.
    var areaChart       = new Chart(graficocurrent, { 
      type: 'line',
      data: areaChartData, 
      options: optionesbasicasgrafico
    })

 var areaChart1       = new Chart(graftemp, { 
      type: 'line',
      data: areaChartDatatemp, 
      options: optionesbasicasgrafico
    })
	
	 var areaChart2      = new Chart(graftx, { 
      type: 'line',
      data: areaChartDatatx, 
      options: optionesbasicasgrafico
    })
	
	 var areaChart4      = new Chart(grafrx, { 
      type: 'line',
      data: areaChartDatarx, 
      options: optionesbasicasgrafico
    })

		
		 $('#tableresultm').DataTable( {"order": [[ 0, "asc" ]],  "paging": true,  "pageLength": 100 	} );
</script>


</html>


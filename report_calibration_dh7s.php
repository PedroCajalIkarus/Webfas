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
            <h1><a href='acceptanceftpmarco.php'>Reporte Measure: FinalCheck_Measures_Gain  </a> </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home.php">Home</a></li>
              <li class="breadcrumb-item active"><a href='acceptanceftpmarco.php'>Report FinalCheck_Measures_Gain</a></li>
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
       
		<section class="col-lg-12 connectedSortable ui-sortable">
		

				<div class="card">
				<div class="card-header ui-sortable-handle" >
               		
				<div class="card">
            
              <!-- /.card-header -->
              <div class="card-body p-0" style="display: block;">
                <div class="d-md-flex">
                  <div class="p-1 flex-fill" style="overflow: hidden" >

				  <div class="container">
				  <?php
			//	 echo "Hola:". $_REQUEST['sns']; 
				  if ("" == $_REQUEST['sns'])
				  {
					  ?>
					  	<div class="">
						  <?php  }
						  else
						 {
							 ?><div class="d-none">
							 <?php
						 } 
						  ?>
							<div class="row">
								<div class="col-6">
								<div id="a" class="chart-container" sssstyle="position: ; height:10vh; width:20vw"> 
							  <canvas id="canvasgraf1"></canvas>
						 		 </div>
								</div>
								<div class="col-6"> 
									<div id="b" class="chart-container" sssstyle="position: ; height:10vh; width:20vw"> 
							  <canvas id="canvasgraf2"></canvas>
						 		 </div>
								  </div>
								  </div>
								  <br>
								
									  <br>		<div class="row">	  
								  <div class="col-6">
									  <div id="c" class="chart-container" sssstyle="position: ; height:10vh; width:20vw"> 
									  <canvas id="canvasgraf3"></canvas>
									  </div>
								  </div>
								  <div class="col-6">
								  <div id="d" class="chart-container" sssstyle="position: ; height:10vh; width:20vw"> 
									  
										<canvas id="canvasgraf4"></canvas>
									</div>
								  </div>
						</div>	 
									  <br>
									  <br>	<div class="row">	  
								  <div class="col-6">
								  <div id="e" class="chart-container" sssstyle="position: ; height:10vh; width:20vw"> 
									  
										<canvas id="canvasgraf5"></canvas>
									</div>
								  </div>
								  <div class="col-6">
										<div id="f" class="chart-container" sssstyle="position: ; height:10vh; width:20vw"> 
											<canvas id="canvasgraf6"></canvas>
										</div>
								  </div>
						 	</div>
							 <br>
							 <br>
									  <br>	<div class="row">	  
								  <div class="col-6">
								  <div id="e1" class="chart-container" sssstyle="position: ; height:10vh; width:20vw"> 
									  
										<canvas id="canvasgraf7"></canvas>
									</div>
								  </div>
								  <div class="col-6">
										<div id="f2" class="chart-container" sssstyle="position: ; height:10vh; width:20vw"> 
											<canvas id="canvasgraf8"></canvas>
										</div>
								  </div>
						 	</div>
								  <br>
								  <br>
						
							 </div> 		
						 
							 </div> 	
						
					<?php 
				    if ( $_REQUEST['sns']<>"") 
					{ ?>	 
						 
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
							errorcount, sn from fas_fiberopticcheck where iduniqueop in(select iduniqueop from fas_tree_measure where iduniquebranch like '03F%'  and unitsn = '".$_REQUEST['sns']."' and idrununfo = ".$_REQUEST['idr'].")";
							
					//	echo 	$sqlmediciones;
							
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
				  
				<?php } ?>
				  
              
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

  <link href="css/bootstrap4-toggle.min.css" rel="stylesheet">
<script src="js/bootstrap4-toggle.min.js"></script>
<script src="js/bootstrap-typeahead.js"></script>


 <script src="js/eModal.min.js" type="text/javascript" >
<script src="js/select2.min.js"></script>
<script src="plugins/chart.js/Chart.min.js"></script>
<script src="js/dataTables.rowGroup.min.js"></script>


	<script src="plugins/chart.js/utils.js"></script>
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

var color = Chart.helpers.color;
	
function generateData() {
			var data = [];
			for (var i = 0; i < 7; i++) {
				data.push({
					x: randomScalingFactor(),
					y: randomScalingFactor()
				});
			}
			return data;
		}

		 

		var attout_0_0 = [];
		var attout_0_1 = [];
		var attout_1_0 = [];
		var attout_1_1 = [];

		var var_attout_0_0_temp ="";
		var var_attout_0_1_temp ="";
		var var_attout_1_0_temp ="";
		var var_attout_1_1_temp ="";

		var gainoffset_0_0 = [];
		var gainoffset_0_1 = [];
		var gainoffset_1_0 = [];
		var gainoffset_1_1 = [];

		var var_gainoffset_0_0_temp ="";
		var var_gainoffset_0_1_temp ="";
		var var_gainoffset_1_0_temp ="";
		var var_gainoffset_1_1_temp ="";

		var gainBandOffset_0_0 = [];
		var gainBandOffset_0_1 = [];
		var gainBandOffset_1_0 = [];
		var gainBandOffset_1_1 = [];

		var var_gainBandOffset_0_0_temp ="";
		var var_gainBandOffset_0_1_temp ="";
		var var_gainBandOffset_1_0_temp ="";
		var var_gainBandOffset_1_1_temp ="";


		var leveloffset_0_0 = [];
		var leveloffset_0_1 = [];
		var leveloffset_1_0 = [];
		var leveloffset_1_1 = [];

		var var_leveloffset_0_0_temp ="";
		var var_leveloffset_0_1_temp ="";
		var var_leveloffset_1_0_temp ="";
		var var_leveloffset_1_1_temp ="";

function create_graph_scatter (sn_search_param)
{

var datashow_volt="[";
	$.ajax
			({ 
				url: 'ajax_listgraphlsgpspecialdh7s.php',
				data: "idlog=2",	
				type: 'post',
				async:true,
                cache:false,
				success: function(data)
				{
				
//////////////////////////////////////// grafico 1 ///////////////////////////////////
					var_attout_0_0_temp = data[0][3];
					var_attout_0_1_temp = data[1][3];
					var_attout_1_0_temp = data[2][3];
					var_attout_1_1_temp = data[3][3];

					var obj_var_attout_0_0_temp = JSON.parse(var_attout_0_0_temp);
					var obj_var_attout_0_1_temp = JSON.parse(var_attout_0_1_temp);
					var obj_var_attout_1_0_temp = JSON.parse(var_attout_1_0_temp);
					var obj_var_attout_1_1_temp = JSON.parse(var_attout_1_1_temp);

					$.each(obj_var_attout_0_0_temp, function(i,item){
						//console.log(i+'--sss----' +objsn[i]);

						lascoorde = item.split('#');
						console.log(i+'--graf1----' +lascoorde[0]+ '-sm:->'+lascoorde[1] );
					
						attout_0_0.push({
							x: i,
						    y: lascoorde[0]
						});
					});
					
					

					$.each(obj_var_attout_0_1_temp, function(i,item){
						//console.log(i+'--sss----' +objsn[i]);
						lascoorde = item.split('#');
						attout_0_1.push({
							x: i,
						    y: lascoorde[0]
					});
				});

					$.each(obj_var_attout_1_0_temp, function(i,item){
						//console.log(i+'--sss----' +objsn[i]);
						lascoorde = item.split('#');
						attout_1_0.push({
							x: i,
						    y: lascoorde[0]
					});
				});

					$.each(obj_var_attout_1_1_temp, function(i,item){
						//console.log(i+'--sss----' +objsn[i]);
						lascoorde = item.split('#');
						attout_1_1.push({
							x: i,
						    y: lascoorde[0]
					});
				});

					///////////////////////////////////////////////////////////////////////
					///// 1er grafico attout
					var scatterChartData = {
					datasets: [
							{
							label: 'attout 0 0 ',
							borderColor: window.chartColors.blue,
							backgroundColor: color(window.chartColors.blue).alpha(0.2).rgbString(),
							data: attout_0_0,
							},
							{
							label: 'attout 0 1 ',
							borderColor: window.chartColors.blue,
							backgroundColor: color(window.chartColors.red).alpha(0.2).rgbString(),
							data: attout_0_1,
							}
							,
							{
							label: 'attout 1 0',
							borderColor: window.chartColors.blue,
							backgroundColor: color(window.chartColors.green).alpha(0.2).rgbString(),
							data: attout_1_0,
							}
							,
							{
							label: 'attout 1 1 ',
							borderColor: window.chartColors.blue,
							backgroundColor: color(window.chartColors.yellow).alpha(0.2).rgbString(),
							data: attout_1_1,
							}
						]
					};
	

					var ctx = document.getElementById('canvasgraf1').getContext('2d');
						window.myScatter = Chart.Scatter(ctx, {
							data: scatterChartData,
							options: {
								title: {
									display: false,
									text: 'Level Off Set SN'
								},
							}
						});
					///// FIN 	1er grafico attout
					///////////////////////////////////////////////////////////////////////
//////////////////////////////////////// grafico 1 ///////////////////////////////////	
//////////////////////////////////////// grafico 2 ///////////////////////////////////
					var_gainoffset_0_0_temp = data[4][3];
					var_gainoffset_0_1_temp = data[5][3];
					var_gainoffset_1_0_temp = data[6][3];
					var_gainoffset_1_1_temp = data[7][3];

					var obj_gainoffset_0_0_temp = JSON.parse(var_gainoffset_0_0_temp);
					var obj_gainoffset_0_1_temp = JSON.parse(var_gainoffset_0_1_temp);
					var obj_gainoffset_1_0_temp = JSON.parse(var_gainoffset_1_0_temp);
					var obj_gainoffset_1_1_temp = JSON.parse(var_gainoffset_1_1_temp);

					var im  =0;
					$.each(obj_gainoffset_0_0_temp, function(i,item){
						//console.log(i+'--sss----' +objsn[i]);
						lascoorde = item.split('#');
						gainoffset_0_0.push({
							x: i,
						y: lascoorde[0]
						});
					});
					
					

					$.each(obj_gainoffset_0_1_temp, function(i,item){
					
						lascoorde = item.split('#');
						gainoffset_0_1.push({
							x: i,
						    y: lascoorde[0]
					});
				});

					$.each(obj_gainoffset_1_0_temp, function(i,item){
						console.log(i+'--Nuevo ver aqui----' +lascoorde[0]);
						lascoorde = item.split('#');
						gainoffset_1_0.push({
						x: i,
						y: lascoorde[0]
					});
				});

					$.each(obj_gainoffset_1_1_temp, function(i,item){
						//console.log(i+'--sss----' +objsn[i]);
						lascoorde = item.split('#');
						gainoffset_1_1.push({
							x: i,
						y: lascoorde[0]
					});
				});

					///////////////////////////////////////////////////////////////////////
					///// 2 grafico  
					var scatterChartData = {
					datasets: [
							{
							label: 'Gain Offset 0 0 ',
							borderColor: window.chartColors.blue,
							backgroundColor: color(window.chartColors.blue).alpha(0.2).rgbString(),
							data: gainoffset_0_0,
							},
							{
							label: 'Gain Offset 0 1 ',
							borderColor: window.chartColors.blue,
							backgroundColor: color(window.chartColors.red).alpha(0.2).rgbString(),
							data: gainoffset_0_1,
							}
							,
							{
							label: 'Gain Offset 1 0',
							borderColor: window.chartColors.blue,
							backgroundColor: color(window.chartColors.green).alpha(0.2).rgbString(),
							data: gainoffset_1_0,
							}
							,
							{
							label: 'Gain Offset 1 1 ',
							borderColor: window.chartColors.blue,
							backgroundColor: color(window.chartColors.yellow).alpha(0.2).rgbString(),
							data: gainoffset_1_1,
							}
						]
					};
	

					var ctx = document.getElementById('canvasgraf2').getContext('2d');
						window.myScatter = Chart.Scatter(ctx, {
							data: scatterChartData,
							options: {
								title: {
									display: false,
									text: 'Level Off Set SN'
								},
							}
						});
					///// FIN 	2er grafico attout
					///////////////////////////////////////////////////////////////////////
//////////////////////////////////////// grafico 2 ///////////////////////////////////		
//////////////////////////////////////// grafico 3 ///////////////////////////////////
					var_gainBandOffset_0_0_temp = data[8][3];
					var_gainBandOffset_0_1_temp = data[9][3];
					var_gainBandOffset_1_0_temp = data[10][3];
					var_gainBandOffset_1_1_temp = data[11][3];

					var obj_gainBandOffset_0_0_temp = JSON.parse(var_gainBandOffset_0_0_temp);
					var obj_gainBandOffset_0_1_temp = JSON.parse(var_gainBandOffset_0_1_temp);
					var obj_gainBandOffset_1_0_temp = JSON.parse(var_gainBandOffset_1_0_temp);
					var obj_gainBandOffset_1_1_temp = JSON.parse(var_gainBandOffset_1_1_temp);

					$.each(obj_gainBandOffset_0_0_temp, function(i,item){
						//console.log(i+'--sss----' +objsn[i]);
						lascoorde = item.split('#');
						gainBandOffset_0_0.push({
							x: i,
						    y: lascoorde[0]
						});
					});
					
					

					$.each(obj_gainBandOffset_0_1_temp, function(i,item){
					
						lascoorde = item.split('#');
						console.log(i+'--sss----' +lascoorde[0]+ '-sm:->'+lascoorde[1] );
						gainBandOffset_0_1.push({
							x: i,
						    y: lascoorde[0]
					});
				});

					$.each(obj_gainBandOffset_1_0_temp, function(i,item){
						//console.log(i+'--sss----' +objsn[i]);
						lascoorde = item.split('#');
						gainBandOffset_1_0.push({
							x: i,
						    y: lascoorde[0]
					});
				});

					$.each(obj_gainBandOffset_1_1_temp, function(i,item){
						//console.log(i+'--sss----' +objsn[i]);
						lascoorde = item.split('#');
						gainBandOffset_1_1.push({
							x: i,
						    y: lascoorde[0]
					});
				});

					///////////////////////////////////////////////////////////////////////
					/////3 grafico  
					var scatterChartData = {
					datasets: [
							{
							label: 'Gain Band Off Set 0 0 ',
							borderColor: window.chartColors.blue,
							backgroundColor: color(window.chartColors.blue).alpha(0.2).rgbString(),
							data: gainBandOffset_0_0,
							},
							{
							label: 'Gain Band Off Set 0 1 ',
							borderColor: window.chartColors.blue,
							backgroundColor: color(window.chartColors.red).alpha(0.2).rgbString(),
							data: gainBandOffset_0_1,
							}
							,
							{
							label: 'Gain Band Off Set 1 0',
							borderColor: window.chartColors.blue,
							backgroundColor: color(window.chartColors.green).alpha(0.2).rgbString(),
							data: gainBandOffset_1_0,
							}
							,
							{
							label: 'Gain Band Off Set 1 1 ',
							borderColor: window.chartColors.blue,
							backgroundColor: color(window.chartColors.yellow).alpha(0.2).rgbString(),
							data: gainBandOffset_1_1,
							}
						]
					};
	

					var ctx = document.getElementById('canvasgraf3').getContext('2d');
						window.myScatter = Chart.Scatter(ctx, {
							data: scatterChartData,
							options: {
								title: {
									display: false,
									text: 'Gain Band Off Set'
								},
							}
						});
					///// FIN 	3er grafico attout
					///////////////////////////////////////////////////////////////////////
//////////////////////////////////////// grafico 3 ///////////////////////////////////		
//////////////////////////////////////// grafico 4 ///////////////////////////////////
					var_leveloffset_0_0_temp = data[12][3];
					var_leveloffset_0_1_temp = data[13][3];
					var_leveloffset_1_0_temp = data[14][3];
					var_leveloffset_1_1_temp = data[15][3];

					var obj_leveloffset_0_0_temp = JSON.parse(var_leveloffset_0_0_temp);
					var obj_leveloffset_0_1_temp = JSON.parse(var_leveloffset_0_1_temp);
					var obj_leveloffset_1_0_temp = JSON.parse(var_leveloffset_1_0_temp);
					var obj_leveloffset_1_1_temp = JSON.parse(var_leveloffset_1_1_temp);

					$.each(obj_leveloffset_0_0_temp, function(i,item){
						//console.log(i+'--sss----' +objsn[i]);
						lascoorde = item.split('#');
						leveloffset_0_0.push({
							x: i,
						    y: lascoorde[0]
						});
					});
					
					

					$.each(obj_leveloffset_0_1_temp, function(i,item){
					
						lascoorde = item.split('#');
						console.log(i+'--m1m1m1----' +lascoorde[0]+ '-sm:->'+lascoorde[1] );
						leveloffset_0_1.push({
							x: i,
						    y: lascoorde[0]
					});
				});

					$.each(obj_leveloffset_1_0_temp, function(i,item){
						//console.log(i+'--sss----' +objsn[i]);
						lascoorde = item.split('#');
						leveloffset_1_0.push({
							x: i,
						    y: lascoorde[0]
					});
				});

					$.each(obj_leveloffset_1_1_temp, function(i,item){
						//console.log(i+'--sss----' +objsn[i]);
						lascoorde = item.split('#');
						leveloffset_1_1.push({
							x: i,
						    y: lascoorde[0]
					});
				});

					///////////////////////////////////////////////////////////////////////
					/////4 grafico  
					var scatterChartData = {
					datasets: [
							{
							label: 'Level Off Set 0 0 ',
							borderColor: window.chartColors.blue,
							backgroundColor: color(window.chartColors.blue).alpha(0.2).rgbString(),
							data: leveloffset_0_0,
							},
							{
							label: 'Level Off Set 0 1 ',
							borderColor: window.chartColors.blue,
							backgroundColor: color(window.chartColors.red).alpha(0.2).rgbString(),
							data: leveloffset_0_1,
							}
							,
							{
							label: 'Level Off Set 1 0',
							borderColor: window.chartColors.blue,
							backgroundColor: color(window.chartColors.green).alpha(0.2).rgbString(),
							data: leveloffset_1_0,
							}
							,
							{
							label: 'Level Off Set 1 1 ',
							borderColor: window.chartColors.blue,
							backgroundColor: color(window.chartColors.yellow).alpha(0.2).rgbString(),
							data: leveloffset_1_1,
							}
						]
					};
	

					var ctx = document.getElementById('canvasgraf4').getContext('2d');
						window.myScatter = Chart.Scatter(ctx, {
							data: scatterChartData,
							options: {
								title: {
									display: false,
									text: ' '
								},
							}
						});
					///// FIN 	4er grafico attout
					///////////////////////////////////////////////////////////////////////
//////////////////////////////////////// grafico 4 ///////////////////////////////////						

//////////////////////////////////////// grafico 5 ///////////////////////////////////
					var poweroffset_0_0 = [];
					var poweroffset_0_1 = [];
					var poweroffset_1_0 = [];
					var poweroffset_1_1 = [];

					var var_poweroffset_0_0_temp ="";
					var var_poweroffset_0_1_temp ="";
					var var_poweroffset_1_0_temp ="";
					var var_poweroffset_1_1_temp ="";

					var_poweroffset_0_0_temp = data[16][3];
					var_poweroffset_0_1_temp = data[17][3];
					var_poweroffset_1_0_temp = data[18][3];
					var_poweroffset_1_1_temp = data[19][3];

					var obj_poweroffset_0_0_temp = JSON.parse(var_poweroffset_0_0_temp);
					var obj_poweroffset_0_1_temp = JSON.parse(var_poweroffset_0_1_temp);
					var obj_poweroffset_1_0_temp = JSON.parse(var_poweroffset_1_0_temp);
					var obj_poweroffset_1_1_temp = JSON.parse(var_poweroffset_1_1_temp);

					$.each(obj_poweroffset_0_0_temp, function(i,item){
						//console.log(i+'--sss----' +objsn[i]);
						lascoorde = item.split('#');
						poweroffset_0_0.push({
							x: i,
						    y: lascoorde[0]
						});
					});
					
					

					$.each(obj_poweroffset_0_1_temp, function(i,item){
					
						lascoorde = item.split('#');
						console.log(i+'--m1m1m1----' +lascoorde[0]+ '-sm:->'+lascoorde[1] );
						poweroffset_0_1.push({
							x: i,
						    y: lascoorde[0]
					});
				});

					$.each(obj_poweroffset_1_0_temp, function(i,item){
						//console.log(i+'--sss----' +objsn[i]);
						lascoorde = item.split('#');
						poweroffset_1_0.push({
							x: i,
						    y: lascoorde[0]
					});
				});

					$.each(obj_poweroffset_1_1_temp, function(i,item){
						//console.log(i+'--sss----' +objsn[i]);
						lascoorde = item.split('#');
						poweroffset_1_1.push({
							x: i,
						    y: lascoorde[0]
					});
				});

					///////////////////////////////////////////////////////////////////////
					/////5 grafico  
					var scatterChartData5 = {
					datasets: [
							{
							label: 'Power Off Set 0 0 ',
							borderColor: window.chartColors.blue,
							backgroundColor: color(window.chartColors.blue).alpha(0.2).rgbString(),
							data: poweroffset_0_0,
							},
							{
							label: 'Power Off Set 0 1 ',
							borderColor: window.chartColors.blue,
							backgroundColor: color(window.chartColors.red).alpha(0.2).rgbString(),
							data: poweroffset_0_1,
							}
							,
							{
							label: 'Power Off Set 1 0',
							borderColor: window.chartColors.blue,
							backgroundColor: color(window.chartColors.green).alpha(0.2).rgbString(),
							data: poweroffset_1_0,
							}
							,
							{
							label: 'Power Off Set 1 1 ',
							borderColor: window.chartColors.blue,
							backgroundColor: color(window.chartColors.yellow).alpha(0.2).rgbString(),
							data: poweroffset_1_1,
							}
						]
					};
	

					var ctx = document.getElementById('canvasgraf5').getContext('2d');
						window.myScatter = Chart.Scatter(ctx, {
							data: scatterChartData5,
							options: {
								title: {
									display: false,
									text: ' '
								},
							}
						});
					///// FIN 	5er grafico attout
					
					///////////////////////////////////////////////////////////////////////
//////////////////////////////////////// grafico5 ///////////////////////////////////		
//////////////////////////////////////// grafico 6 ///////////////////////////////////
					var powerBandOffset_0_0 = [];
					var powerBandOffset_0_1 = [];
					var powerBandOffset_1_0 = [];
					var powerBandOffset_1_1 = [];

					var var_poweroffset_0_0_temp ="";
					var var_poweroffset_0_1_temp ="";
					var var_poweroffset_1_0_temp ="";
					var var_poweroffset_1_1_temp ="";

					var_poweroffset_0_0_temp = data[20][3];
					var_poweroffset_0_1_temp = data[21][3];
					var_poweroffset_1_0_temp = data[22][3];
					var_poweroffset_1_1_temp = data[23][3];

					var obj_poweroffset_0_0_temp = JSON.parse(var_poweroffset_0_0_temp);
					var obj_poweroffset_0_1_temp = JSON.parse(var_poweroffset_0_1_temp);
					var obj_poweroffset_1_0_temp = JSON.parse(var_poweroffset_1_0_temp);
					var obj_poweroffset_1_1_temp = JSON.parse(var_poweroffset_1_1_temp);

					$.each(obj_poweroffset_0_0_temp, function(i,item){
						//console.log(i+'--sss----' +objsn[i]);
						lascoorde = item.split('#');
						powerBandOffset_0_0.push({
						x: lascoorde[1],
						y: lascoorde[0]
						});
					});
					
					

					$.each(obj_poweroffset_0_1_temp, function(i,item){
					
						lascoorde = item.split('#');
						console.log(i+'--m1m1m1----' +lascoorde[0]+ '-sm:->'+lascoorde[1] );
						powerBandOffset_0_1.push({
							x: i,
						    y: lascoorde[0]
					});
				});

					$.each(obj_poweroffset_1_0_temp, function(i,item){
						//console.log(i+'--sss----' +objsn[i]);
						lascoorde = item.split('#');
						powerBandOffset_1_0.push({
							x: i,
						    y: lascoorde[0]
					});
				});

					$.each(obj_poweroffset_1_1_temp, function(i,item){
						//console.log(i+'--sss----' +objsn[i]);
						lascoorde = item.split('#');
						powerBandOffset_1_1.push({
							x: i,
						    y: lascoorde[0]
					});
				});

					///////////////////////////////////////////////////////////////////////
					/////6 grafico  
					var scatterChartData5 = {
					datasets: [
							{
							label: 'Power Band Off Set 0 0 ',
							borderColor: window.chartColors.blue,
							backgroundColor: color(window.chartColors.blue).alpha(0.2).rgbString(),
							data: powerBandOffset_0_0,
							},
							{
							label: 'Power Band Off Set 0 1 ',
							borderColor: window.chartColors.blue,
							backgroundColor: color(window.chartColors.red).alpha(0.2).rgbString(),
							data: powerBandOffset_0_1,
							}
							,
							{
							label: 'Power Band Off Set 1 0',
							borderColor: window.chartColors.blue,
							backgroundColor: color(window.chartColors.green).alpha(0.2).rgbString(),
							data: powerBandOffset_1_0,
							}
							,
							{
							label: 'Power Band Off Set 1 1 ',
							borderColor: window.chartColors.blue,
							backgroundColor: color(window.chartColors.yellow).alpha(0.2).rgbString(),
							data: powerBandOffset_1_1,
							}
						]
					};
	

					var ctx = document.getElementById('canvasgraf6').getContext('2d');
						window.myScatter = Chart.Scatter(ctx, {
							data: scatterChartData5,
							options: {
								title: {
									display: false,
									text: ' '
								},
							}
						});
					///// FIN 	6 grafico attout
					
					///////////////////////////////////////////////////////////////////////
//////////////////////////////////////// grafico6 ///////////////////////////////////		
//////////////////////////////////////// grafico 7 ///////////////////////////////////
					var rfoutSpecOffset_0_0 = [];
					var rfoutSpecOffset_0_1 = [];
					var rfoutSpecOffset_1_0 = [];
					var rfoutSpecOffset_1_1 = [];

					var var_poweroffset_0_0_temp ="";
					var var_poweroffset_0_1_temp ="";
					var var_poweroffset_1_0_temp ="";
					var var_poweroffset_1_1_temp ="";

					var_poweroffset_0_0_temp = data[24][3];
					var_poweroffset_0_1_temp = data[25][3];
					var_poweroffset_1_0_temp = data[26][3];
					var_poweroffset_1_1_temp = data[27][3];

					var obj_poweroffset_0_0_temp = JSON.parse(var_poweroffset_0_0_temp);
					var obj_poweroffset_0_1_temp = JSON.parse(var_poweroffset_0_1_temp);
					var obj_poweroffset_1_0_temp = JSON.parse(var_poweroffset_1_0_temp);
					var obj_poweroffset_1_1_temp = JSON.parse(var_poweroffset_1_1_temp);

					$.each(obj_poweroffset_0_0_temp, function(i,item){
						//console.log(i+'--sss----' +objsn[i]);
						lascoorde = item.split('#');
						rfoutSpecOffset_0_0.push({
							x: i,
						    y: lascoorde[0]
						});
					});
					
					

					$.each(obj_poweroffset_0_1_temp, function(i,item){
					
						lascoorde = item.split('#');
						console.log(i+'--m1m1m1----' +lascoorde[0]+ '-sm:->'+lascoorde[1] );
						rfoutSpecOffset_0_1.push({
							x: i,
						    y: lascoorde[0]
					});
				});

					$.each(obj_poweroffset_1_0_temp, function(i,item){
						//console.log(i+'--sss----' +objsn[i]);
						lascoorde = item.split('#');
						rfoutSpecOffset_1_0.push({
							x: i,
						    y: lascoorde[0]
					});
				});

					$.each(obj_poweroffset_1_1_temp, function(i,item){
						//console.log(i+'--sss----' +objsn[i]);
						lascoorde = item.split('#');
						rfoutSpecOffset_1_1.push({
							x: i,
						    y: lascoorde[0]
					});
				});

					///////////////////////////////////////////////////////////////////////
					/////7 grafico  
					var scatterChartData5 = {
					datasets: [
							{
							label: 'rf out Spec Off set 0 0 ',
							borderColor: window.chartColors.blue,
							backgroundColor: color(window.chartColors.blue).alpha(0.2).rgbString(),
							data: rfoutSpecOffset_0_0,
							},
							{
							label: 'rf out Spec Off set 0 1 ',
							borderColor: window.chartColors.blue,
							backgroundColor: color(window.chartColors.red).alpha(0.2).rgbString(),
							data: rfoutSpecOffset_0_1,
							}
							,
							{
							label: 'rf out Spec Off set 1 0',
							borderColor: window.chartColors.blue,
							backgroundColor: color(window.chartColors.green).alpha(0.2).rgbString(),
							data: rfoutSpecOffset_1_0,
							}
							,
							{
							label: 'rf out Spec Off set 1 1 ',
							borderColor: window.chartColors.blue,
							backgroundColor: color(window.chartColors.yellow).alpha(0.2).rgbString(),
							data: rfoutSpecOffset_1_1,
							}
						]
					};
	

					var ctx = document.getElementById('canvasgraf7').getContext('2d');
						window.myScatter = Chart.Scatter(ctx, {
							data: scatterChartData5,
							options: {
								title: {
									display: false,
									text: ' '
								},
							}
						});
					///// FIN 	7 grafico attout
					
					///////////////////////////////////////////////////////////////////////
//////////////////////////////////////// grafico7 ///////////////////////////////////					
				 
//////////////////////////////////////// grafico 8 ///////////////////////////////////
					var sqoffset_0_0 = [];
					var sqoffset_0_1 = [];
					var sqoffset_1_0 = [];
					var sqoffset_1_1 = [];

					var var_poweroffset_0_0_temp ="";
					var var_poweroffset_0_1_temp ="";
					var var_poweroffset_1_0_temp ="";
					var var_poweroffset_1_1_temp ="";

					var_poweroffset_0_0_temp = data[28][3];
					var_poweroffset_0_1_temp = data[29][3];
					var_poweroffset_1_0_temp = data[30][3];
					var_poweroffset_1_1_temp = data[31][3];

					var obj_poweroffset_0_0_temp = JSON.parse(var_poweroffset_0_0_temp);
					var obj_poweroffset_0_1_temp = JSON.parse(var_poweroffset_0_1_temp);
					var obj_poweroffset_1_0_temp = JSON.parse(var_poweroffset_1_0_temp);
					var obj_poweroffset_1_1_temp = JSON.parse(var_poweroffset_1_1_temp);

					$.each(obj_poweroffset_0_0_temp, function(i,item){
						//console.log(i+'--sss----' +objsn[i]);
						lascoorde = item.split('#');
						sqoffset_0_0.push({
						x: lascoorde[1],
						y: lascoorde[0]
						});
					});
					
					

					$.each(obj_poweroffset_0_1_temp, function(i,item){
					
						lascoorde = item.split('#');
						console.log(i+'--m1m1m1----' +lascoorde[0]+ '-sm:->'+lascoorde[1] );
						sqoffset_0_1.push({
							x: i,
						    y: lascoorde[0]
					});
				});

					$.each(obj_poweroffset_1_0_temp, function(i,item){
						//console.log(i+'--sss----' +objsn[i]);
						lascoorde = item.split('#');
						sqoffset_1_0.push({
							x: i,
						    y: lascoorde[0]
					});
				});

					$.each(obj_poweroffset_1_1_temp, function(i,item){
						//console.log(i+'--sss----' +objsn[i]);
						lascoorde = item.split('#');
						sqoffset_1_1.push({
							x: i,
						    y: lascoorde[0]	
					});
				});

					///////////////////////////////////////////////////////////////////////
					/////8 grafico  
					var scatterChartData5 = {
					datasets: [
							{
							label: 'Sq Off set 0 0 ',
							borderColor: window.chartColors.blue,
							backgroundColor: color(window.chartColors.blue).alpha(0.2).rgbString(),
							data: sqoffset_0_0,
							},
							{
							label: 'Sq Off set 0 1 ',
							borderColor: window.chartColors.blue,
							backgroundColor: color(window.chartColors.red).alpha(0.2).rgbString(),
							data: sqoffset_0_1,
							}
							,
							{
							label: 'Sq Off set 1 0',
							borderColor: window.chartColors.blue,
							backgroundColor: color(window.chartColors.green).alpha(0.2).rgbString(),
							data: sqoffset_1_0,
							}
							,
							{
							label: 'Sq Off set 1 1 ',
							borderColor: window.chartColors.blue,
							backgroundColor: color(window.chartColors.yellow).alpha(0.2).rgbString(),
							data: sqoffset_1_1,
							}
						]
					};
	

					var ctx = document.getElementById('canvasgraf8').getContext('2d');
						window.myScatter = Chart.Scatter(ctx, {
							data: scatterChartData5,
							options: {
								title: {
									display: false,
									text: ' '
								},
							}
						});
					///// FIN 	8 grafico attout
					
					///////////////////////////////////////////////////////////////////////
//////////////////////////////////////// grafico8 ///////////////////////////////////				
			
				}
			});


	
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
	
	
		//  var tablemm =   $('#tablabc').DataTable( {  rowGroup: {  dataSrc: [ 2, 1 ]     },	"order": [[ 0, "desc" ]],  "paging": true,  "pageLength": 100 } );

		var tablemm = 	  $('#tablabc').DataTable( {
        order: [[0, 'desc'], [1, 'asc'],[2, 'asc']],  "paging": true,  "pageLength": 10000,	
		columnDefs: [      {"className": "dt-left", "targets": "_all"}      ],	
        rowGroup: {
            dataSrc: [ 0,1 ]
        },
        columnDefs: [ {
            targets: [ 0,1 ],
            visible: false
        } ]
    } );
		
		
			var parametrofiltrado = (new URL(location.href)).searchParams.get('sns')
			console.log(parametrofiltrado);
			if (parametrofiltrado != null)
			{
				$( "input[type='search']").val( parametrofiltrado);
				// tablemm.search( parametrofiltrado ).draw();
				console.log('a' + parametrofiltrado );
				create_graph_scatter(parametrofiltrado);
			}
			else
			{
				create_graph_scatter('');
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
     		
		

	





		
		 $('#tableresultm').DataTable( {"order": [[ 0, "asc" ]],  "paging": true,  "pageLength": 100 	} );
</script>


</html>


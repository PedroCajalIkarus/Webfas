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

<style>
.highcharts-figure,
.highcharts-data-table table {
  min-width: 310px;
  max-width: 800px;
  margin: 1em auto;
}

#container {
  height: 400px;
}

.highcharts-tooltip h3 {
  margin: 0.3em 0;
}

.highcharts-data-table table {
  font-family: Verdana, sans-serif;
  border-collapse: collapse;
  border: 1px solid #ebebeb;
  margin: 10px auto;
  text-align: center;
  width: 100%;
  max-width: 500px;
}

.highcharts-data-table caption {
  padding: 1em 0;
  font-size: 1.2em;
  color: #555;
}

.highcharts-data-table th {
  font-weight: 600;
  padding: 0.5em;
}

.highcharts-data-table td,
.highcharts-data-table th,
.highcharts-data-table caption {
  padding: 0.5em;
}

.highcharts-data-table thead tr,
.highcharts-data-table tr:nth-child(even) {
  background: #f8f8f8;
}

.highcharts-data-table tr:hover {
  background: #f1f7ff;
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
            <h1><a href='acceptanceftpmarco.php'> Report OUTCOME Measures (Old Version Outcome)</a> </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home.php">Home</a></li>
              <li class="breadcrumb-item active"><a href='acceptanceftpmarco.php'>Report </a></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
     
		<section class="col-lg-12 connectedSortable ui-sortable">
		
		<table class="table">
  
	<tr><th colspan=2>Quick Filters:</th></tr>
    <tr>
      
      <td> 
	  Select DiB  : <br>	  
	  <select class="form-control form-control-sm" id="cmbdib">
	  <option value="">- Select -</option>
<?php 
 

$sql = $connect->prepare(" select distinct ppp.idproduct, modelciu
from fnt_select_allproducts_maxrev() as ppp
inner join products_attributes
on products_attributes.idproduct = ppp.idproduct
where idattribute = 0
");
 
  
	 $sql->execute();
	 
	 $resultado = $sql->fetchAll();
	 $entrotienedatos="N";
	 $pas=1;
	  foreach ($resultado as $row) 
	  {
		  ?>
   <option value="<?php echo $row['modelciu']; ?>"><?php echo $row['modelciu']; ?></option>
		  <?php
	  }
?>

    
      
    </select></td>


	<td>

			
			Select Script: <br>
			<select class="form-control form-control-sm" name="losscriptmam" id="losscriptmam" onclick="filtrartodostep(1,this.value)"  >
						<option value=""> - Select - </option>
						<?php
												 					
																

																	 $sql = $connect->prepare("   select distinct scriptname, fas_income_integral.idscript 
																	 from fas_income_integral
																	 left join fas_script_type
																	 on fas_script_type.idscripttype =  fas_income_integral.idscript order by scriptname ");
																	  
																											 $sql->execute();
																											 $resultado3 = $sql->fetchAll();
																											 foreach ($resultado3 as $row2) 
																											  {
																												 
																												// echo "*************". array_search($row2['idbusiness'], $lasempresasfiltradas);
																											  ?>
																										  <option value="<?php echo  $row2['idscript']; ?>" <?php echo $autoselect;?>>
																											  <?php echo  $row2['scriptname'] ; ?>
																											  </option>
																											  <?php
																											  }
					
																	 ?>
                        </select>
			</td> 

			<td>

			
Select Steps: <br>
<select class="form-control form-control-sm" name="losstepmmam" id="losstepmmam"     >
			<option value=""> - Select - </option>
	 
			</select>
</td>
	 
	  <td>
		  Select Measure:<br>
	  <select class="form-control form-control-sm" id="cmbidtypescritp">
	  <option value="">- Select -</option>
<?php 
 

$sql = $connect->prepare(" select  * from fas_outcome_type order by outcomedescription 
");
 
  
	 $sql->execute();
	 
	 $resultado = $sql->fetchAll();
	 $entrotienedatos="N";
	 $pas=1;
	  foreach ($resultado as $row) 
	  {
		  ?>
   <option value="<?php echo $row['idscriptoutcometype']; ?>"><?php echo $row['outcomedescription']; ?></option>
		  <?php
	  }
?>
      ?>
    </select>

	  </td>
	  <td>
		  <br>
	  <button type="button" class="btn btn-outline-primary btn-sm" onclick="buscardatos()">Search</button>

	  </td>
    </tr>
    
   
</table>

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
							  <canvas id="canvas_0_0"></canvas>
						 		 </div>
								</div>
								<div class="col-6"> 
									<div id="b" class="chart-container" sssstyle="position: ; height:10vh; width:20vw"> 
							  <canvas id="canvas_0_1"></canvas>
						 		 </div>
								  </div>
								  </div>
								  <br>
								
									  <br>		<div class="row">	  
								  <div class="col-6">
									  <div id="c" class="chart-container" sssstyle="position: ; height:10vh; width:20vw"> 
									  <canvas id="canvas_1_0"></canvas>
									  </div>
								  </div>
								  <div class="col-6">
								 	 <div id="d" class="chart-container" sssstyle="position: ; height:10vh; width:20vw"> 
										<canvas id="canvas_1_1"></canvas>
									</div>
								  </div>
						</div>	 



						<br>		<div class="row">	  
								  <div class="col-6">
									  <div id="c" class="chart-container" sssstyle="position: ; height:10vh; width:20vw"> 
								 
									  <p class="highcharts-figure">
										<div id="container"></div>
										<p class="highcharts-description">
										
										</p>
										</p>

									  </div>
								  </div>
								  <div class="col-6">
								 	 <div id="d" class="chart-container" sssstyle="position: ; height:10vh; width:20vw"> 
									 
									</div>
								  </div>
						</div>	 



					
									 
						
							 </div> 		
						 
							 </div> 	
						
					<?php 
				    if ( $_REQUEST['sns']<>"") 
					{ ?>	 
						 
					<!--detalle so -->
					<div class="card" style="position: relative; left: 0px; top: 0px;">
              <div class="card-header ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title">
				
				 
               
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
								  
								
					
				     <div class="chart tab-pane pre-scrollablemarco active " id="www" style="position: relative; ">
			
					
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
				  

				Test Bubble
 				<div id="series_chart_div" style="width: 900px; height: 500px;"></div>

			 
							<!----- fin INICIO LISTA PO  -->
              
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
 
	<!-- Load jQuery -->
     <!-- Load jQuery -->
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




	<script src="plugins/chart.js/utils.js"></script>
  
    <!-- Load Chart.js -->
    <script src="js/chart.bundle.min2-7-3.js"></script>

 
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	
  

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

		var data_volt = [];
		var data_voltcurrent = [];
		var data_volttemp=[];
		var data_volttempdelta =[];
		var data_volttetx =[];
		var data_voltterx =[];
		var data_tx =[];
		var data_rx =[];
		var data_volt_m = '';

		var data_volt_0_0 = [];
		var data_volt_0_1 = [];
		var data_volt_1_0 = [];
		var data_volt_1_1 = [];
function create_graph_scatter (mother, param_instance, para_idtype)
{

	var data_volt_0_0 = [];
		var data_volt_0_1 = [];
		var data_volt_0_1muestra = [];
		var data_volt_1_0 = [];
		var data_volt_1_1 = [];

var datashow_volt="[";
	$.ajax
			({ 
				url: 'ajax_listgrafpuntosoutcome.php',
				data: "iddigb="+mother+"&instan="+param_instance+"&idtype="+para_idtype,	
				type: 'post',
				async:true,
                cache:false,
				success: function(data)
				{
					losdatos_0_0_datosx = data[0].losdatos_0_0_datosx;
					losdatos_0_1_datosx = data[0].losdatos_0_1_datosx;
					losdatos_1_0_datosx = data[0].losdatos_1_0_datosx;
					losdatos_1_1_datosx = data[0].losdatos_1_1_datosx;

					losdatos_0_0_datosy = data[0].losdatos_0_0_datosy;
					losdatos_0_1_datosy = data[0].losdatos_0_1_datosy;
					losdatos_1_0_datosy = data[0].losdatos_1_0_datosy;
					losdatos_1_1_datosy = data[0].losdatos_1_1_datosy;

					datashow_tempdelta = data[0].resutempdib;

					data_tx = data[0].resutx;
					data_rx = data[0].resurx;
				
					var obj_0_0x = JSON.parse(losdatos_0_0_datosx);
					var obj_0_0y = JSON.parse(losdatos_0_0_datosy);
					//var objsn = JSON.parse(datashow_resusn);
				//	console.log(objsn);
					$.each(obj_0_0x, function(i,item){
					//	console.log(i+'------' +obj_0_0x[i]);
					//	lascoorde = item.split('#');
					data_volt_0_0.push({
						x: i,
						y: obj_0_0y[i]
					});

					})

					var obj_0_1x = JSON.parse(losdatos_0_1_datosx);
					var obj_0_1y = JSON.parse(losdatos_0_1_datosy);
					//var objsn = JSON.parse(datashow_resusn);
				//	console.log(objsn);
					$.each(obj_0_1x, function(i,item){
				//		console.log(i+'------' +obj_0_1x[i]);
					//	lascoorde = item.split('#');
					data_volt_0_1.push({
						x: i,
						y: obj_0_1y[i]
					});

					})


					$.each(obj_0_1x, function(i,item){
				//		console.log(i+'------' +obj_0_1x[i]);
					//	lascoorde = item.split('#');
					data_volt_0_1muestra.push({
						x: i,
						y: obj_0_1y[i],
						z: obj_0_1y[i],
						name: ' marco automatic '+obj_0_1y[i],
						country: ' marco automatic '+obj_0_1y[i]
					});

					/*
					 { x: 95, y: 95, z: 13.8, name: 'BE', country: 'Belgium' },
					*/

				 
					})



					

					var obj_1_0x = JSON.parse(losdatos_1_0_datosx);
					var obj_1_0y = JSON.parse(losdatos_1_0_datosy);
					//var objsn = JSON.parse(datashow_resusn);
				//	console.log(objsn);
					$.each(obj_1_0x, function(i,item){
			//			console.log(i+'------' +obj_1_0x[i]);
					//	lascoorde = item.split('#');
					data_volt_1_0.push({
						x: i,
						y: obj_1_0y[i]
					});

					})


					var obj_1_1x = JSON.parse(losdatos_1_1_datosx);
					var obj_1_1y = JSON.parse(losdatos_1_1_datosy);
					//var objsn = JSON.parse(datashow_resusn);
				//	console.log(objsn);
					$.each(obj_1_1x, function(i,item){
			//			console.log(i+'------' +obj_1_1x[i]);
					//	lascoorde = item.split('#');
					data_volt_1_1.push({
						x: i,
						y: obj_1_1y[i],
						status: 'aaaaaaa'
					});

					})

			 


					///////////////////////////////////////////////////////////////////////
					///// 1er grafico VOLTAGE
					var scatterChartData = {
					datasets: [{
						label: 'BAND 0 - 0',
						borderColor: window.chartColors.blue,
						backgroundColor: color(window.chartColors.blue).alpha(0.2).rgbString(),
						data: data_volt_0_0,
					}]
					};

				 
	

					var ctx = document.getElementById('canvas_0_0').getContext('2d');
						window.myScatter = Chart.Scatter(ctx, {
							data: scatterChartData,
							options: {
								showAllTooltips: true,
								title: {
									display: true,
									text: ' aaa bbcc'
								},
								onClick: function(e) {
									var element = this.getElementAtEvent(e);

									// If you click on at least 1 element ...
									if (element.length > 0) {
										// Logs it
								//		console.log(element[0]);

										// Here we get the data linked to the clicked bubble ...
										var datasetLabel = this.config.data.datasets[element[0]._datasetIndex].label;
										// data gives you `x`, `y` and `r` values
										var data = this.config.data.datasets[element[0]._datasetIndex].data[element[0]._index];

								//		console.log( datasetLabel );
									}
								}
							}
						});
						
						var ctx = document.getElementById('canvas_0_0').getContext('2d');
						window.myScatter = Chart.Scatter(ctx, {
							data: scatterChartData,
							options: {
								showAllTooltips: true,
								title: {
									display: true,
									text: ' aaa bbcc'
								},
								onClick: function(e) {
									var element = this.getElementAtEvent(e);

									// If you click on at least 1 element ...
									if (element.length > 0) {
										// Logs it
									////	console.log(element[0]);

										// Here we get the data linked to the clicked bubble ...
										var datasetLabel = this.config.data.datasets[element[0]._datasetIndex].label;
										// data gives you `x`, `y` and `r` values
										var data = this.config.data.datasets[element[0]._datasetIndex].data[element[0]._index];

									//	console.log( datasetLabel );
									}
								}
							}
						});
					///// FIN 	1er grafico VOLTAGE
					///////////////////////////////////////////////////////////////////////
					///// 2do grafico VOLTAGE
					var scatterChartData = {
					datasets: [{
						label: 'BAND 0 - 1',
						borderColor: window.chartColors.blue,
						backgroundColor: color(window.chartColors.blue).alpha(0.2).rgbString(),
						data: data_volt_0_1,
					}]
					};
	

					var ctx = document.getElementById('canvas_0_1').getContext('2d');
						window.myScatter = Chart.Scatter(ctx, {
							data: scatterChartData,
							options: {
								title: {
									display: false,
									text: ' '
								},
							}
						});
					///// FIN 	2do grafico VOLTAGE
						///////////////////////////////////////////////////////////////////////
					///// 3er grafico VOLTAGE
					var scatterChartData_1_0 = {
					datasets: [{
						label: 'BAND 1 - 0',
						borderColor: window.chartColors.blue,
						backgroundColor: color(window.chartColors.blue).alpha(0.2).rgbString(),
						data: data_volt_1_0,
					}]
					};
	

					var ctx = document.getElementById('canvas_1_0').getContext('2d');
						window.myScatter = Chart.Scatter(ctx, {
							data: scatterChartData_1_0,
							options: {
								title: {
									display: false,
									text: ' '
								},
							}
						});
					///// FIN 	3er grafico VOLTAGE
					///////////////////////////////////////////////////////////////////////
					///// 4tdo grafico VOLTAGE
					var scatterChartData_1_1 = {
					datasets: [{
						label: 'BAND 1 - 1',
						borderColor: window.chartColors.blue,
						backgroundColor: color(window.chartColors.blue).alpha(0.2).rgbString(),
						data: data_volt_1_1,
					}]
					};
	

					var ctx = document.getElementById('canvas_1_1').getContext('2d');
						window.myScatter = Chart.Scatter(ctx, {
							data: scatterChartData_1_1,
							options: {
								title: {
									display: false,
									text: ' '
								},
							}
						});
					///// FIN 	4tdo grafico VOLTAGE
				 

					var optgraftx2= {
    maintainAspectRatio : true,
    responsive : true,	
     scales: {
      xAxes: [{
        gridLines : {
          display : true,		 
        }
		
	
      }],
      yAxes: [{
		ticks: {
                    suggestedMin: 0,
                    suggestedMax: 7
                },
        gridLines : {
          display : true,
		 
        }				
      }]
    }
  }  

  var optgrafrx2= {
    maintainAspectRatio : true,
    responsive : true,	
     
      xAxes: [{
        gridLines : {
          display : true,		 
        }
		
	
      }],
      yAxes: [{
		ticks: {
                    suggestedMin: -10,
                    suggestedMax: 0	
                },
        gridLines : {
          display : true,
		 
        }				
      }]
    
  }  

				 
	

			 
				

			 
					///// FIN 	6to  grafico resutemp
					////////////////////////////////////////////////////////////////////	
				}
			});

 
// SuMO ACA MAS test del popup
 
google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawSeriesChart);

    function drawSeriesChart() {

      var datammbubble = google.visualization.arrayToDataTable([
        ['ID', 'x', 'y', 'SN', 'size'],
		['',    0,              0,      '22034048FU' ,10000 ],
        ['',    80.66,              1.67,      '22034048FU' ,100 ],
        ['',    79.84,              1.36,      '22034048FU'  ,100     ],
        ['',    78.6,               1.84,      '22034048FU'   ,1000   ],
        ['',    72.73,              2.78,      '22034049FU'   ,100 ],
        ['',    80.05,              2,         '22034049FU'  ,1000 ],
        ['',    72.49,              1.7,       '22034049FU'  ,100 ],
        ['',    68.09,              4.77,      '22034049FU'  ,100],
        ['',    81.55,              2.96,      '22034049FU'   ,100],
        ['',    68.6,               1.54,      '22034049FU'     ,1000  ],
        ['',    78.09,              2.05,      '22034049FU',100 ]
      ]);

	  console.log('Transform');
	  console.log(datammbubble);

      var optionsbubble = {
        title: 'Title example' +
          ' ssss mas text',
        hAxis: {title: ' test x'},
        vAxis: {title: 'test Y'},
        bubble: {textStyle: {fontSize: 5}}
      };

      var chart = new google.visualization.BubbleChart(document.getElementById('series_chart_div'));
      chart.draw(datammbubble, optionsbubble);
    }

console.log('aqui');
// fin SuMO ACA MAS test del popup


	

  //// fin chart

 
	
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
			//   $('.js-example-basic-single').select2();
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
			
					
 
		
		
			var parametrofiltrado = (new URL(location.href)).searchParams.get('sns')
		//	console.log(parametrofiltrado);
			if (parametrofiltrado != null)
			{
				$( "input[type='search']").val( parametrofiltrado);
				// tablemm.search( parametrofiltrado ).draw();
			}

		///	create_graph_scatter('');
			
	});


	function buscardatos()
	{
		create_graph_scatter($("#cmbdib").val(), $("#losstepmmam").val(), $("#cmbidtypescritp").val() );
	}
	

	// controlar inactividad en la web	
	/*	$(document).inactivityTimeout({
                inactivityWait: 500,
                dialogWait: 100,
                logoutUrl: 'index.php?t=jquerytimeout'
            })*/
	// fin controlar inactividad en la web		
	
	 /* requesting data */
     		
		
 	function filtrartodostep( idtyp, valuemm)
	{
	 /// 1 = script
	 if (valuemm != '')
	 {
			
			if (idtyp==1)
			{
				var armando_tabla ="";
					$.ajax({
							url: 'listinstance_cat_type_outcomeoldversion.php?idtyp='+idtyp+'&valuemm='+valuemm ,										
							cache:false,
							success: function(respuesta) {
								
								console.log('HOLa');
							

								var returnedData = JSON.parse(respuesta);
							//	console.log(returnedData);
							$('#losstepmmam').empty();
							$('#losstepmmam').append($('<option />', {
												value: '',
												text: ' - Select - '
											}));
						
								$.each(returnedData.data, function (index, value) {
											$('#losstepmmam').append($('<option />', {
												value: value.in_instance,
												text: value.description
											}));
											
										});

						
							},
							error: function() {
								console.log("No se ha podido obtener la información");
							}
							
						});
			}
			if (idtyp==2)
			{
				var armando_tabla ="";
					$.ajax({
							url: 'listinstance_cat_type_outcomeoldversion.php?idtyp='+idtyp+'&valuemm='+valuemm ,										
							cache:false,
							success: function(respuesta) {
								
								console.log('HOLa');
							

								var returnedData = JSON.parse(respuesta);
							//	console.log(returnedData);
							$('#losscriptsteps').empty();
							$('#losscriptsteps').append($('<option />', {
												value: '',
												text: ' - Select - '
											}));
						
								$.each(returnedData.data, function (index, value) {
											$('#losscriptsteps').append($('<option />', {
												value: value.in_instance,
												text: value.description
											}));
										 
										});

						
							},
							error: function() {
								console.log("No se ha podido obtener la información");
							}
							
						});
			}
			if (idtyp==3)
			{
				var armando_tabla ="";
					$.ajax({
							url: 'listinstance_cat_type_outcomeoldversion.php?idtyp='+idtyp+'&valuemm='+valuemm+'&vinstance='+$('#losstepmmam').val()   ,										
							cache:false,
							success: function(respuesta) {
								
							//	console.log('HOLa');
							

								var returnedData = JSON.parse(respuesta);
							//	console.log(returnedData);lascategoriastipos
							$('#lascategoriastipos').empty();
							$('#lascategoriastipos').append($('<option />', {
												value: '',
												text: ' - Select - '
											}));
							
								$.each(returnedData.data, function (index, value) {
											$('#lascategoriastipos').append($('<option />', {
												value: value.in_instance,
												text: value.description
											}));
										 
										});

						
							},
							error: function() {
								console.log("No se ha podido obtener la información");
							}
							
						});
			}
	 }


									
									
									
	}


 function pepegrafgoogle()
 {
	 
	
 }
 
</script>


</html>


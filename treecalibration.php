<!DOCTYPE html>
<?php 

// Desactivar toda notificación de error
error_reporting(0);
// Notificar todos los errores de PHP (ver el registro de cambios)
//error_reporting(E_ALL);
 include("db_conect.php"); 
 
 	session_start();
 
 /*
  if(isset($_SESSION["timeout"])){
        // Calcular el tiempo de vida de la sesión (TTL = Time To Live)
	//	echo "***********hola".time() - $_SESSION["timeout"];
        $sessionTTL = time() - $_SESSION["timeout"];
        if($sessionTTL > $inactividad){
			session_unset();
            session_destroy();
            header("Location: http://".$ipservidorapache."/index.php?t=timeoutinactivity");
        }
    }
	else
	{
			session_unset();
            session_destroy();
            header("Location: http://".$ipservidorapache."/index.php?t=notcookietimeout");
        
	}
	*/
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
	
	/*	if ($pag_habilitada == "N")
		{
			///echo "the user: ".$_SESSION["b"]." cannot access the menu: ".array_pop(explode('/', $_SERVER['PHP_SELF'])).", contact the webfas administrator";
			header("Location: http://".$ipservidorapache."/".$folderservidor."/permissiondenied.php?b=".$_SESSION["b"]."&c=".array_pop(explode('/', $_SERVER['PHP_SELF'])));
			exit();
		}*/
	/// FIN DETECTO PERMISOS EN PAG!
	
	$status = $connect->getAttribute(PDO::ATTR_CONNECTION_STATUS);
	
	if ($status !="Connection OK; waiting to send.")
	{
	
		header("Location: http://".$ipservidorapache."/".$folderservidor."/errorconect.php");
		exit;
		
	}

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
  
 <link href="css/tabulator_bulma.css" rel="stylesheet">
 
  
    <link rel="stylesheet" href="cssfiplex.css">
	
		<style>
	body
{
  font-family: Arial, Helvetica, sans-serif;
  font-size:14px;
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

.responsive-iframe {
  position: absolute;
  top: 60px;
  left: 0;
  border:0;
  bottom: 0;
  right: 0;
  width: 100%;
  height: 700px;
}
</style>


</head>

<input type="hidden" name="uso" id="uso" value="0">
<body class="hold-transition sidebar-mini sidebar-collapse">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="http://srv-pgsql.fiplex.com/index.php" class="nav-link">Home</a>
      </li>
      
    </ul>

 

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu --> 
   <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">      
         
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge"></span>
        </a>
      
      </li>
    	  
      <!-- Notifications Dropdown Menu -->
    </ul>
  </nav>
  <!-- /.navbar -->
<?php 	  

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
            <h1>Tree steps for calibration</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Stock WO</li>
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

            <div class="" name="divscrolllog" id="divscrolllog" style="display.">
			
			  <div class="demo-container">
										
			
					
							
						
			<p name="msjwaitline" id="msjwaitline" align="center"><img src="img/waitazul.gif" width="100px" ></p>	
				<div class="card">
				<div class="card-body">
							
				<!-- aca tree				-->
				<div class="container">
				<b>Search:</b> <input type="search" name="txtacceptbusca"  onchange="filtraplacas()" id="txtacceptbusca" class="form-control form-control-sm" placeholder="Search" >
    <div class="row">
        <div class="">
            <ul id="treeview">
			<li data-icon-cls="fa fa-inbox" ><b>Tree steps for calibration</b>			  
			<ul id="mm">
							<?php		


							$query_lista = "SELECT fas_tree.*, fas_step.description, fas_step2.description
from fas_tree
inner join fas_step
on fas_step.idfasstep = fas_tree.idfasstepfather
inner join fas_step as fas_step2
on fas_step2.idfasstep = fas_tree.idfastrepson
			
			";	
			//and orders_sn.wo_serialnumber not like '%DV%'
							//	echo $query_lista;									   
							$data = $connect->query($query_lista)->fetchAll();		

$search  = array('{', '}');
$replace = array('', '');


						$temonombretypeaccep="";
							//echo  $query_lista;
							foreach ($data as $row) 
							{
												$qporc=$row['ccstock'];
											
												$bgclass="bg-secondary";
												  $bgclass="bg-warning";
												  if ($qporc < 3)
												  {
													    $bgclass="bg-danger";
												  }
											      if ($qporc >= 5)
												  {
													    $bgclass="bg-warning";
												  }
												  if ($qporc >= 10)
												  {
													    $bgclass="bg-green";
												  }
												 
									//Antes de mostrar pregunto si tiene mas ramas.
								?>
								<li class="esramahijo " id="<?php echo $row['modelciu'];  ?>"><?php echo $row['modelciu'];  ?>
								<span data-toggle="tooltip" title="" class="badge <?php echo $bgclass; ?> ">										
																   <?php echo " [ ".$row['ccstock']; ?> SN ]			 
																</span> 
									<?php 
									$lossn = $array = explode(",", $row['groupxsn']);
									if ( count($lossn) >0)
									{
									?>
									<ul>
									<?php
										for($i = 0; $i < count($lossn); $i++){
											echo "<li value='".str_replace($search, $replace, $lossn[$i])."' id='".str_replace($search, $replace, $lossn[$i])."' class='esramahijo '>SN:".  str_replace($search, $replace, $lossn[$i])." ";
											
										//	echo "<a data-ancla='anclamyTabledib' href='stockwo.php?dibsn=".str_replace($search, $replace, $lossn[$i])."' aria-expanded='true' ><i class='fas fa-eye'></i> </a>";
											echo "</li>";
										}
										
									}
									echo "</ul>";
									?>
								</li>
								<?php	
								
								
							}
							?>
					</ul>
				</li>
			
				
				
            </ul>
        </div>
    </div>
</div>
				<!-- fin aca tree -->
				
					
				</div>	
				</div>
			
					

        </section>
		<section class="col-lg-9 connectedSortable ui-sortable">
		
			

				<div class="card">
				<div class="card-header ui-sortable-handle" >
				<b>Calibration Details: <label id="lblsn" name="lblsn"> <?php echo $_REQUEST['dibsn']; ?> </label><b>
				</div>	
				<br>	<br>			
               	
						

				<!-- Styles -->
<style>
#chartdiv {
  width: 100%;
  height: 600px;
}
</style>

<!-- Resources -->
<script src="https://www.amcharts.com/lib/4/core.js"></script>
<script src="https://www.amcharts.com/lib/4/charts.js"></script>
<script src="https://www.amcharts.com/lib/4/plugins/timeline.js"></script>
<script src="https://www.amcharts.com/lib/4/plugins/bullets.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>

<!-- Chart code -->
<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

var chart = am4core.create("chartdiv", am4plugins_timeline.SerpentineChart);
chart.curveContainer.padding(100, 20, 50, 20);
chart.levelCount = 3;
chart.yAxisRadius = am4core.percent(20);
chart.yAxisInnerRadius = am4core.percent(2);
chart.maskBullets = false;

var colorSet = new am4core.ColorSet();

chart.dateFormatter.inputDateFormat = "yyyy-MM-dd HH:mm";
chart.dateFormatter.dateFormat = "HH";

chart.data = [{
    "category": "",
    "start": "2019-01-10 06:00",
    "end": "2019-01-10 07:00",
    "color": colorSet.getIndex(15),
    "text": "I will have\na healthy day today!",
    "textDisabled": false,
    "icon": "/wp-content/uploads/assets/timeline/timeline0.svg"
}, {
    "category": "",
    "start": "2019-01-10 07:00",
    "end": "2019-01-10 08:00",
    "color": colorSet.getIndex(14),
    "icon": "/wp-content/uploads/assets/timeline/timeline1.svg"
},
{
    "category": "",
    "start": "2019-01-10 08:00",
    "end": "2019-01-10 09:00",
    "color": colorSet.getIndex(13),
    "icon": "/wp-content/uploads/assets/timeline/timeline2.svg"
},
{
    "category": "",
    "start": "2019-01-10 09:00",
    "end": "2019-01-10 10:00",
    "color": colorSet.getIndex(12),
    "icon": "/wp-content/uploads/assets/timeline/timeline2.svg"
},
{
    "category": "",
    "start": "2019-01-10 10:00",
    "end": "2019-01-10 12:00",
    "color": colorSet.getIndex(11),
    "icon": "/wp-content/uploads/assets/timeline/timeline2.svg"
},
{
    "category": "",
    "start": "2019-01-10 12:00",
    "end": "2019-01-10 13:00",
    "color": colorSet.getIndex(10),
    "icon": "/wp-content/uploads/assets/timeline/timeline1.svg"
},
{
    "category": "",
    "start": "2019-01-10 13:00",
    "end": "2019-01-10 14:00",
    "color": colorSet.getIndex(9),
    "text": "One beer doesn't count.",
    "textDisabled": false,
    "icon": "/wp-content/uploads/assets/timeline/timeline3.svg"
},
{
    "category": "",
    "start": "2019-01-10 14:00",
    "end": "2019-01-10 16:00",
    "color": colorSet.getIndex(8),
    "icon": "/wp-content/uploads/assets/timeline/timeline2.svg"
},
{
    "category": "",
    "start": "2019-01-10 16:00",
    "end": "2019-01-10 17:00",
    "color": colorSet.getIndex(7),
    "icon": "/wp-content/uploads/assets/timeline/timeline4.svg"
},
{
    "category": "",
    "start": "2019-01-10 17:00",
    "end": "2019-01-10 20:00",
    "color": colorSet.getIndex(6),
    "icon": "/wp-content/uploads/assets/timeline/timeline2.svg"
},
{
    "category": "",
    "start": "2019-01-10 20:00",
    "end": "2019-01-10 20:30",
    "color": colorSet.getIndex(5),
    "icon": "/wp-content/uploads/assets/timeline/timeline3.svg"
},
{
    "category": "",
    "start": "2019-01-10 20:30",
    "end": "2019-01-10 21:30",
    "color": colorSet.getIndex(4),
    "icon": "/wp-content/uploads/assets/timeline/timeline3.svg"
},
{
    "category": "",
    "start": "2019-01-10 21:30",
    "end": "2019-01-10 22:00",
    "color": colorSet.getIndex(3),
    "icon": "/wp-content/uploads/assets/timeline/dance.svg"
},
{
    "category": "",
    "start": "2019-01-10 22:00",
    "end": "2019-01-10 23:00",
    "color": colorSet.getIndex(2),
    "icon": "/wp-content/uploads/assets/timeline/timeline5.svg"
},
{
    "category": "",
    "start": "2019-01-10 23:00",
    "end": "2019-01-11 00:00",
    "color": colorSet.getIndex(1),
    "icon": "/wp-content/uploads/assets/timeline/timeline6.svg"
},
{
    "category": "",
    "start": "2019-01-11 00:00",
    "end": "2019-01-11 01:00",
    "color": colorSet.getIndex(0),
    "text": "Damn...",
    "textDisabled": false,
    "icon": "/wp-content/uploads/assets/timeline/timeline7.svg"
}];

chart.fontSize = 10;
chart.tooltipContainer.fontSize = 10;

var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "category";
categoryAxis.renderer.grid.template.disabled = true;
categoryAxis.renderer.labels.template.paddingRight = 25;
categoryAxis.renderer.minGridDistance = 10;

var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
dateAxis.renderer.minGridDistance = 70;
dateAxis.baseInterval = { count: 30, timeUnit: "minute" };
dateAxis.renderer.tooltipLocation = 0;
dateAxis.renderer.line.strokeDasharray = "1,4";
dateAxis.renderer.line.strokeOpacity = 0.5;
dateAxis.tooltip.background.fillOpacity = 0.2;
dateAxis.tooltip.background.cornerRadius = 5;
dateAxis.tooltip.label.fill = new am4core.InterfaceColorSet().getFor("alternativeBackground");
dateAxis.tooltip.label.paddingTop = 7;
dateAxis.endLocation = 0;
dateAxis.startLocation = -0.5;

var labelTemplate = dateAxis.renderer.labels.template;
labelTemplate.verticalCenter = "middle";
labelTemplate.fillOpacity = 0.4;
labelTemplate.background.fill = new am4core.InterfaceColorSet().getFor("background");
labelTemplate.background.fillOpacity = 1;
labelTemplate.padding(7, 7, 7, 7);

var series = chart.series.push(new am4plugins_timeline.CurveColumnSeries());
series.columns.template.height = am4core.percent(15);

series.dataFields.openDateX = "start";
series.dataFields.dateX = "end";
series.dataFields.categoryY = "category";
series.baseAxis = categoryAxis;
series.columns.template.propertyFields.fill = "color"; // get color from data
series.columns.template.propertyFields.stroke = "color";
series.columns.template.strokeOpacity = 0;
series.columns.template.fillOpacity = 0.6;

var imageBullet1 = series.bullets.push(new am4plugins_bullets.PinBullet());
imageBullet1.locationX = 1;
imageBullet1.propertyFields.stroke = "color";
imageBullet1.background.propertyFields.fill = "color";
imageBullet1.image = new am4core.Image();
imageBullet1.image.propertyFields.href = "icon";
imageBullet1.image.scale = 0.5;
imageBullet1.circle.radius = am4core.percent(100);
imageBullet1.dy = -5;


var textBullet = series.bullets.push(new am4charts.LabelBullet());
textBullet.label.propertyFields.text = "text";
textBullet.disabled = true;
textBullet.propertyFields.disabled = "textDisabled";
textBullet.label.strokeOpacity = 0;
textBullet.locationX = 1;
textBullet.dy = - 100;
textBullet.label.textAlign = "middle";

chart.scrollbarX = new am4core.Scrollbar();
chart.scrollbarX.align = "center"
chart.scrollbarX.width = am4core.percent(75);
chart.scrollbarX.opacity = 0.5;

var cursor = new am4plugins_timeline.CurveCursor();
chart.cursor = cursor;
cursor.xAxis = dateAxis;
cursor.yAxis = categoryAxis;
cursor.lineY.disabled = true;
cursor.lineX.strokeDasharray = "1,4";
cursor.lineX.strokeOpacity = 1;

dateAxis.renderer.tooltipLocation2 = 0;
categoryAxis.cursorTooltipEnabled = false;


var label = chart.createChild(am4core.Label);
label.text = "Another unlucky day in the office."
label.isMeasured = false;
label.y = am4core.percent(40);
label.x = am4core.percent(50);
label.horizontalCenter = "middle";
label.fontSize = 20;

}); // end am4core.ready()
</script>

<!-- HTML -->
<div id="chartdiv"></div>
				
              
				
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
  
  <a href="#" class="ancla" data-ancla="anclamyTabledib"></a>
  

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
<script src="<?php echo $folderservidor; ?>plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo $folderservidor; ?>plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>

<script type="text/javascript" src="js/tabulator.min.js"></script>

	<script type="text/javascript" src="js/shieldui-all.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/treeviewall.min.css" />
<script src="plugins/chart.js/Chart.min.js"></script>


<!-- Ion Slider -->
<script src="plugins/ion-rangeslider/js/ion.rangeSlider.min.js"></script>

<script type="text/javascript" src="js/tabulator.min.js"></script>
<script src="js/viewer.js"></script>



</body>

<script type="text/javascript">

  var treeview2;
   
	$( document ).ready(function() {
		
		//Inicio mostrar hora live
		 var interval = setInterval(function() {
			 
        var momentNow = moment();
			var newYork    = momentNow.tz('America/New_York').format('ha z');
			$('#date-part').html(momentNow.format('YYYY/MM/DD') 	  );
			$('#time-part').html(momentNow.format('hh:mm:ss'));
			}, 100);
		//FIN mostrar hora live
		//	console.log( "ready!" );
			$('#msjwaitline ').hide();
			$('#divscrolllog').show(); 
			$('#p-b0').hide();
			$('#p-b0').CardWidget('toggle');		
			$("#detallelog").hide();
			$("#detallelog").text("");
			$("#msjwait").hide();		


  
	 
				$("#divgeneralinfo").addClass('d-none');
				$("#divgeneralinfoparam").addClass('d-none');
				$("#divdetinfolog").addClass('d-none');
				
				$("#diveq").addClass('d-none');
				$("#divfactory").addClass('d-none');
				$("#divfinalcheck").addClass('d-none');
				$("#divgroupbyciu").addClass('d-none');
				
					$("#divgeneralinfo").removeClass('d-none');
				$("#divgeneralinfoparam").removeClass('d-none');
				$("#divdetinfolog").removeClass('d-none');

				

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

				$('#closebusqueda').show();
				$('#openbusqueda').hide();
				
				
	
    
	//iniciamos el Treeview
	   ///$("#treeview").shieldTreeView();
		/*var treeview = $("#treeview").shieldTreeView().swidget();
				
			treeview.load([0]);
			 treeview.expanded(true, [0]);
			 
			treeview.load([1]);
			 treeview.expanded(true, [1]);
			
				

			//treeview.load([3]);
		    for (var i = 0; i < 200; i ++) {
				 treeview.load([0,i]);
				  treeview.load([1,i]);
				   
			}*/
			
			/// mostramos div de calibration
const urlParams = new URLSearchParams(window.location.search);
const vvidsndib = urlParams.get('dibsn');
console.log("hola" + vvidsndib);
	 if (vvidsndib != '')
	 {
		// $("#txtacceptbusca").val(vvidsndib);
		// filtraplacas();
		// treeview.expanded(true, [1]);
	 }

///agregamos los graficos
	var areaChartCanvas = $('#areaChart').get(0).getContext('2d');

 var areaChartData = {
      labels  : [<?php echo $lasfamlias;?>],
      datasets: [
        {
          label               : 'Stock by Product Family',          
		     backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius         : true,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [<?php echo $cantxfamilia;?>]
        }
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

    // This will get the first returned node in the jQuery collection.
    var areaChart       = new Chart(areaChartCanvas, { 
      type: 'bar',
      data: areaChartData, 
      options: areaChartOptions
    })
		
		var ipservidorapache= '<?php echo $ipservidorapache; ?>';	
		$("#treeview").shieldTreeView({
            events: {
                select: function(e) {
                    //console.log(  "selecting  " + this.getPath(e.element) + '**');
					//console.log('aaa' + this.getItem(e.element).text.substr(3,10));
				//	$("#lblsn").text(this.getItem(e.element).text);
					//console.log(this.getItem(e.element).text.substr(0,2));
					if (this.getItem(e.element).text.substr(0,2) =="SN")
					{
							$("#lblsn").text(this.getItem(e.element).text);
						$('#iframem').attr("src", 'http://'+ipservidorapache+'/equalizeriir.php?idsndib=' +this.getItem(e.element).text.substr(3,10));
					}
					else
					{
							$("#lblsn").text('');
						   $('#iframem').attr("src", '');
					}
					 
				//	console.log(this.getItem([this.getPath(e.element)]).text);
					
                },
				
            },
			
        });
		
		
		
			
	});
	


	$(function () {
  			$('.knob').knob({ 
			})

	})
  
	function habilitarbusqueda()
	{		
		$('#openbusqueda').hide();
		$('#closebusqueda').show();
		$("#example1").DataTable({
					 "destroy": true,
						 "paging": true,
					  "lengthChange": false,
					  "searching": true,						  
					  "ordering": false,
					  "info": true,
					  "autoWidth": false,
					  "iDisplayLength": 10
					}
			);
					
					
	}
   
	function dehabilitarbusqueda()
	{

			$('#closebusqueda').hide();
			$('#openbusqueda').show();
			$("#example1").DataTable({
						 "destroy": true,
							 "paging": true,
						  "lengthChange": false,
						  "searching": false,						  
						  "ordering": false,
						  "info": true,
						  "autoWidth": false,
						  "iDisplayLength": 10
						}
				);
		
				
				
	} 
	
	
   


function json2array(json){
    var result = [];
    var keys = Object.keys(json);
    keys.forEach(function(key){
        result.push(json[key]);
    });
    return result;
}

		
		function filtraplacas()
		{
		//	 $("#txtacceptbusca").val();
		
		
		  // Declare variables
		  var input, filter, ul, li, a, i, txtValue;
		  input = $("#txtacceptbusca").val();
		  filter = $("#txtacceptbusca").val();
	
		  li = document.getElementsByClassName('sui-treeview-item');
		 
		 
		  // Loop through all list items, and hide those who don't match the search query
		 
		  for (i = 0; i < li.length; i++) {
			a = li[i];
			txtValue = a.textContent || a.innerText;
			
		  
			if (txtValue.toUpperCase().indexOf(filter) > -1) {
			  li[i].style.display = "";
			  console.log( i +'ok' + txtValue +'a verrr:'+ a.style.display);
			} else {
				//console.log('none' + txtValue + '--'+a.css+"otr:"+ a.style.display);
			  li[i].style.display = "none";
			}
			
		  } 
		
		
					//$('[class="treeview"]:not(li:contains("6092"))').remove();

		}
		
	
	
   
</script>

</html>

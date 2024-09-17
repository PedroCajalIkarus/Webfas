<!DOCTYPE html>
<?php 

// Desactivar toda notificación de error
error_reporting(0);
// Notificar todos los errores de PHP (ver el registro de cambios)
//error_reporting(E_ALL);
 	include "db_conect.php";
 
 	session_start();
	
	
	
   /*if(isset($_SESSION["timeout"])){
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
	
		if ($pag_habilitada == "N")
		{
			///echo "the user: ".$_SESSION["b"]." cannot access the menu: ".array_pop(explode('/', $_SERVER['PHP_SELF'])).", contact the webfas administrator";
			//header("Location: http://".$ipservidorapache."/".$folderservidor."/permissiondenied.php?b=".$_SESSION["b"]."&c=".array_pop(explode('/', $_SERVER['PHP_SELF'])));
			//exit();
		}
	/// FIN DETECTO PERMISOS EN PAG!
	

?>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIPLEX - Locker Log</title>
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
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  
  <link href="css/tabulator_bootstrap4.css" rel="stylesheet">
  <link rel="shortcut icon" href="fiplexcirculo-01.ico" />
  
  <link rel="stylesheet" href="toastr.css">
  
 <link href="css/tabulator_bulma.css" rel="stylesheet">
 
  
    <link rel="stylesheet" href="cssfiplex.css">
</head>
<form name="frma" id="frma">
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
            <h1>Locker Log</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home.php">Home</a></li>
              <li class="breadcrumb-item active">Locker Log</li>
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
		  
	  <!-- inicio box search marco -->
		  	 
                   
		
		
            <!-- The time line -->
            
			<p name="msjwaitline" id="msjwaitline" align="center"><img src="img/waitazul.gif" width="100px" ></p>
			
            	
			  <?php		  
					try{   
						// Sacar todos los resultados de la base de datos
						//echo $elwhere;
						?>	
<div class="row">						
						     <div class="col-md-6">
							  <div class="card card-primary">
								<div class="card-header">
								<h3 class="card-title">Units Processed per Day</h3>

								<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
								</button>
								<button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
								</div>
								</div>
								<div class="card-body">
								<div class="chart">
								<canvas id="areaChart" style="height:150px; min-height:150px"></canvas>
								</div>
								</div>
								<!-- /.card-body -->
								</div>
								</div>
								  <div class="col-md-6">
							  <div class="card card-primary">
								<div class="card-header">
								<h3 class="card-title">Units Processed per Month</h3>

								<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
								</button>
								<button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
								</div>
								</div>
								<div class="card-body">
								<div class="chart">
								<canvas id="areaChartmes" style="height:150px; min-height:150px"></canvas>
								</div>
								</div>
								<!-- /.card-body -->
								</div>
								</div>
						</div>		
						<div id="example-table" class="example-table-theme-bootstrap4"></div>			 
						<?php
 
					}catch(PDOException $e){
						echo "ERROR: " . $e->getMessage();
					}
				?>     
             
			 
			
			 
           
       
		
			

        </section>


          <!-- /.col -->
        </div>
      </div>
      <!-- /.timeline -->

    </section>
    <!-- /.content -->
	
	
	</div>
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


<script type="text/javascript" src="js/tabulator.min.js"></script>
<script src="plugins/chart.js/Chart.min.js"></script>
</body>

<script type="text/javascript">

   /////a pedido de fer.
		$(document).inactivityTimeout({
                inactivityWait: 100,
                dialogWait: 2,
                logoutUrl: 'lockerlogresu.php?a=refreshbyinactivityWait' 
            })
   
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
		//	console.log( " FIN ready!" );
		
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
				
		
					
									
		////aca vamos a probar el tablulator
		/*
		y el orden de columnas ponele de izq a derecha
		parmanent lock --- [11:35 a. m., 2/3/2020] Agustín Corigliano Fiplex: el permanent lock
							[11:35 a. m., 2/3/2020] Agustín Corigliano Fiplex: indica si le deja un bloqueo permanente, o uno temporal
							[11:36 a. m., 2/3/2020] Agustín Corigliano Fiplex: el desbloqueo temporal, si apagas y prendes el equipo
							[11:36 a. m., 2/3/2020] Agustín Corigliano Fiplex: se bloequea de nuevo
		previously locked?  -Previously locked, es para ver el estado que venia antes
		Lock command es el comando que le tiras, a ver si lo bloqueas o lo desbloquear  
		Y final lock status, es el checkeo final, que tiene que coincidir con el lock command
*/
		
		
					
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
			var table = new Tabulator("#example-table", {
					height:altor,					
					layout : "fitDataFill" ,					
					ajaxURL:"getlockerloginforesum.php",
					responsiveLayout : "collapse" ,
					ajaxProgressiveLoad:"scroll",					
					selectable:1,				
					selectableRollingSelection:true,
					 selectablePersistence:false,
					 responsiveLayoutCollapseUseFormatters : true ,	
					 responsiveLayoutCollapseStartOpen:false,
					paginationSize:20,
					placeholder:"No Data Set",					
					columns:[
					     
							{title:" <i class='fa fa-fw fa-calendar'></i> Date", field:"datelocket", sorter:"string", headerFilter:"input" , responsive : 0 },							
							{title:" <i class='fa fa-fw fa-file-alt'></i> UnitSN ", field:"unitsn", sorter:"string",  headerFilter:"input", responsive : 0  },
								{title:" <i class='fa fa-fw fa-file-alt'></i> FPGA ID ", field:"fpga", sorter:"string", headerFilter:"input",responsive : 10  },
							{title:" <i class='fa fa-fw fa-tv'></i>  IP/MAC", field:"ip_mac", sorter:"string" ,headerFilter:"input" ,  responsive : 10 },
							{title:" <i class='fa fa-fw fa-tv'></i>  Script", field:"idtypescript", sorter:"string" ,headerFilter:"input" ,responsive : 0,
							formatter:function(cell, formatterParams){
							var vj_typescript = cell.getValue();
							var nom_typescript ="unknown";
							///if(value.indexOf("") > 0){
							coloresscrpit="bg-secondary";
								if (vj_typescript ==0  )							
								{
									coloresscrpit= "bg-warning";
									nom_typescript="DIG. MOD.";
									
								}
								if (vj_typescript ==1  )							
								{
									coloresscrpit= "bg-info";
									nom_typescript="CALIB.";
									
								}
								if (vj_typescript ==2  )					
								{
									coloresscrpit= "bg-primary";
									nom_typescript="FINAL CHK.";
								}
							
								return " <span class='badge "+coloresscrpit+"'>" + nom_typescript + "</span>";
								
								
							}},	
								{title:" <i class='fa fa-fw fa-eye'></i> Permanent Lock Cmd", field:"permanentlock", sorter:"string",  headerFilter:"input" ,responsive : 0,
							formatter:function(cell, formatterParams){
							var vj_permanentlock = cell.getValue();
							///if(value.indexOf("") > 0){
							coloresscrpit="bg-info";
								if (vj_permanentlock =="TRUE"  )							
								{
									coloresscrpit= "bg-green";
									
								}
								if (vj_permanentlock =="FALSE"  )					
								{
									coloresscrpit= "bg-danger";
								}
							
								return " <span class='badge "+coloresscrpit+"'>" + vj_permanentlock + "</span>";
								
								
							}},						
									
							{title:" <i class='fa fa-fw fa-eye'></i> Previously Locked? ", field:"lookstatus", sorter:"string",  headerFilter:"input" ,responsive : 0,
							formatter:function(cell, formatterParams){
							var vj_lookstatus = cell.getValue();
							///if(value.indexOf("") > 0){
							coloresscrpit="bg-info";
								if (vj_lookstatus =="TRUE"  )							
								{
									coloresscrpit= "bg-green";
									
								}
								if (vj_lookstatus =="FALSE"  )					
								{
									coloresscrpit= "bg-danger";
								}
							
								return " <span class='badge "+coloresscrpit+"'>" + vj_lookstatus + "</span>";
								
								
							}},	
								{title:" <i class='fa fa-fw fa-eye'></i> Lock command", field:"crc", sorter:"string",  headerFilter:"input" , responsive : 0 ,
							formatter:function(cell, formatterParams){
							var vj_crcchk3 = cell.getValue();
							///if(value.indexOf("") > 0){
								coloresscrpit="bg-info";
								if (vj_crcchk3 =="TRUE"  )							
								{
									coloresscrpit= "bg-green";
									
								}
								if (vj_crcchk3 =="FALSE"  )								
								{
									coloresscrpit= "bg-danger";
								}
							
								return " <span class='badge "+coloresscrpit+"'>" + vj_crcchk3 + "</span>";
								
								
							}},	
						
{title:" <i class='fa fa-fw fa-eye'></i> Final Lock Check ", field:"statuscheck", sorter:"string",  headerFilter:"input" ,responsive : 0,
							formatter:function(cell, formatterParams){
							var vj_statusCheck = cell.getValue();
							///if(value.indexOf("") > 0){
							coloresscrpit="bg-info";
								if (vj_statusCheck =="TRUE"  )							
								{
									coloresscrpit= "bg-green";
									
								}
								if (vj_statusCheck =="FALSE"  )					
								{
									coloresscrpit= "bg-danger";
								}
							
								return " <span class='badge "+coloresscrpit+"'>" + vj_statusCheck + "</span>";
								
								
							}},									
						
						
					   
					]
					
					});
				
					

		///fin prueba de tabulator
	});
	
  var areaChartCanvas = $('#areaChart').get(0).getContext('2d')
   var areaChartCanvasmes = $('#areaChartmes').get(0).getContext('2d')
  
  <?php 
  
 	$query_lista = "select losdias.*, losfinalchk.cc as ccfinalchk, COALESCE(loscalibration.cc,0) as cccalib
from (
select distinct date_part('month',datelocket) as elmes , date_part('year',datelocket) as elanio, date_part('day',datelocket) as eldia
from lockerlog 
inner join (
select unitsn, max(datelocket) as maxdatelocket from lockerlog
group by unitsn) as maxestadoxunitsn
on lockerlog.unitsn =  maxestadoxunitsn.unitsn and 
   lockerlog.datelocket =  maxestadoxunitsn.maxdatelocket
 	order by  elanio, elmes desc ,eldia  desc
limit 7   
	) as losdias
	left join (
	select  date_part('month',datelocket) as elmes , date_part('year',datelocket) as elanio, date_part('day',datelocket) as eldia ,count(lockerlog.unitsn) as cc
from lockerlog 
inner join (
select unitsn, max(datelocket) as maxdatelocket from lockerlog
group by unitsn) as maxestadoxunitsn
on lockerlog.unitsn =  maxestadoxunitsn.unitsn and 
   lockerlog.datelocket =  maxestadoxunitsn.maxdatelocket
		where typescript= 2
		group by  elanio, elmes, eldia ,typescript
	) as losfinalchk
	on losfinalchk.elanio = losdias.elanio and
	   losfinalchk.elmes = losdias.elmes and 
	   losfinalchk.eldia = losdias.eldia
	   left join (
	select  date_part('month',datelocket) as elmes , date_part('year',datelocket) as elanio, date_part('day',datelocket) as eldia ,count(lockerlog.unitsn) as cc
from lockerlog 
inner join (
select unitsn, max(datelocket) as maxdatelocket from lockerlog
group by unitsn) as maxestadoxunitsn
on lockerlog.unitsn =  maxestadoxunitsn.unitsn and 
   lockerlog.datelocket =  maxestadoxunitsn.maxdatelocket
		where typescript= 1
		group by  elanio, elmes, eldia ,typescript
	) as loscalibration
	on loscalibration.elanio = losdias.elanio and
	   loscalibration.elmes = losdias.elmes and 
	   loscalibration.eldia = losdias.eldia	";
    $return_arr = array();
 	
		$months = array (1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'May',6=>'Jun',7=>'Jul',8=>'Aug',9=>'Sep',10=>'Oct',11=>'Nov',12=>'Dec');
	
	$data = $connect->query($query_lista)->fetchAll();	
	foreach ($data as $row) 
	{
		$lasfechas=$lasfechas."'".$row['eldia']."-".$months[(int)$row['elmes']]."',";
		$losfinalchk=$losfinalchk."'".$row['ccfinalchk']."',";
		$lascalib=$lascalib."'".$row['cccalib']."',";
    }
	

 	$query_lista = "select losdias.*, losfinalchk.cc as ccfinalchk, COALESCE(loscalibration.cc,0) as cccalib
from (
select distinct date_part('month',datelocket) as elmes , date_part('year',datelocket) as elanio
from lockerlog 
inner join (
select unitsn, max(datelocket) as maxdatelocket from lockerlog
group by unitsn) as maxestadoxunitsn
on lockerlog.unitsn =  maxestadoxunitsn.unitsn and 
   lockerlog.datelocket =  maxestadoxunitsn.maxdatelocket
 	order by  elanio, elmes desc   
limit 7   
	) as losdias
	left join (
	select  date_part('month',datelocket) as elmes , date_part('year',datelocket) as elanio
		,count(lockerlog.unitsn) as cc
from lockerlog 
inner join (
select unitsn, max(datelocket) as maxdatelocket from lockerlog
group by unitsn) as maxestadoxunitsn
on lockerlog.unitsn =  maxestadoxunitsn.unitsn and 
   lockerlog.datelocket =  maxestadoxunitsn.maxdatelocket
		where typescript= 2
		group by  elanio, elmes, typescript
	) as losfinalchk
	on losfinalchk.elanio = losdias.elanio and
	   losfinalchk.elmes = losdias.elmes
	   left join (
	select  date_part('month',datelocket) as elmes , date_part('year',datelocket) as elanio	   ,count(lockerlog.unitsn) as cc
from lockerlog 
inner join (
select unitsn, max(datelocket) as maxdatelocket from lockerlog
group by unitsn) as maxestadoxunitsn
on lockerlog.unitsn =  maxestadoxunitsn.unitsn and 
   lockerlog.datelocket =  maxestadoxunitsn.maxdatelocket
		where typescript= 1
		group by  elanio, elmes, typescript
	) as loscalibration
	on loscalibration.elanio = losdias.elanio and
	   loscalibration.elmes = losdias.elmes";
    $return_arr = array();
 	
	
	$data = $connect->query($query_lista)->fetchAll();	
	foreach ($data as $row) 
	{
		$lasfechasmesagrup=$lasfechasmesagrup."'".$months[(int)$row['elmes']]."',";
		$losfinalchkagrup=$losfinalchkagrup."'".$row['ccfinalchk']."',";
		$lascalibagrup=$lascalibagrup."'".$row['cccalib']."',";
    }
	

	
	  ?>

 var areaChartData = {
      labels  : [<?php echo $lasfechas;?>],
      datasets: [
        {
          label               : 'Calibration',          
		   backgroundColor     : 'rgba(210, 214, 222, 1)',
          borderColor         : 'rgba(210, 214, 222, 1)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [<?php echo $lascalib;?>]
        },
        {
          label               : 'Final Chk',
         backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius         : false,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [<?php echo $losfinalchk;?>]
        },
      ]
    }
	
    var areaChartDataMES = {
      labels  : [<?php echo $lasfechasmesagrup;?>],
      datasets: [
        {
          label               : 'Calibration',          
		   backgroundColor     : 'rgba(210, 214, 222, 1)',
          borderColor         : 'rgba(210, 214, 222, 1)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [<?php echo $lascalibagrup;?>]
        },
        {
          label               : 'Final Chk',
         backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius         : false,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [<?php echo $losfinalchkagrup;?>]
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

    // This will get the first returned node in the jQuery collection.
    var areaChart       = new Chart(areaChartCanvas, { 
      type: 'bar',
      data: areaChartData, 
      options: areaChartOptions
    })

	var areaChart2       = new Chart(areaChartCanvasmes, { 
      type: 'bar',
      data: areaChartDataMES, 
      options: areaChartOptions
    })

	
</script>
 
</html>
<?php
	/////////////////////////////////////////////////////////////////////////////////////
				//////AUDITAMOS///////////////////////////////////////////////////////////////////////////////
				$vuserfas = $_SESSION["b"];
				$vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
				$vaccionweb="visitweb";
					$vdescripaudit="visitweb#".$_SERVER['SERVER_ADDR'];
				$vtextaudit="";
				
				$sentenciach = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
								$sentenciach->bindParam(':userfas', $vuserfas);								
								$sentenciach->bindParam(':menuweb', $vmenufas);
								$sentenciach->bindParam(':actionweb', $vaccionweb);
								$sentenciach->bindParam(':descripaudit', $vdescripaudit);
								$sentenciach->bindParam(':textaudit', $vtextaudit);
								$sentenciach->execute();
								
							
				/////////////////////////////////////////////////////////////////////////////////////
				/////////////////////////////////////////////////////////////////////////////////////
?>
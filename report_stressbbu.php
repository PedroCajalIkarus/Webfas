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
	//		exit();
		}
	
	
	$status = $connect->getAttribute(PDO::ATTR_CONNECTION_STATUS);
	
	if ($status !="Connection OK; waiting to send.")
	{
	
		header("Location: http://".$ipservidorapache."/".$folderservidor."/errorconect.php");
		exit;
		
	}
	




 
//****************************************************************	
	function marco_encrypt($string, $key) {
   $result = '';
   for($i=0; $i<strlen($string); $i++) {
      $char = substr($string, $i, 1);
      $keychar = substr($key, ($i % strlen($key))-1, 1);
      $char = chr(ord($char)+ord($keychar));
      $result.=$char;
   }
   return base64_encode($result);
}

function marco_decrypt($string, $key) {
   $result = '';
   $string = base64_decode($string);
   for($i=0; $i<strlen($string); $i++) {
      $char = substr($string, $i, 1);
      $keychar = substr($key, ($i % strlen($key))-1, 1);
      $char = chr(ord($char)-ord($keychar));
      $result.=$char;
   }
   return $result;
}

$hidmenu = $_REQUEST['hidmenu'];
//****************************************************************	
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

<?php 	  
if ($hidmenu=="")
{
  ?>
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="http://webfas.honeywell.com/index.php" class="nav-link">Home</a>
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
    }
  ?>

<?php 	  
if ($hidmenu=="")
{
  include("menu.php"); 
}
 
 include("funcionesstores.php"); 
 include ('licencefiplex_mm.php');
 
   //   $Encryption = new Encryption();
        
?>


  <!-- Content Wrapper. Contains page content -->
  <?php 	  
if ($hidmenu=="")
{
  ?>
    <div class="content-wrapper">
  <?php
}
else
{
  ?>
    <div class=" ">
  <?php
}
?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Report Stress BBU</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Report Stress BBU </li>
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
       
            <div class="" name="divscrolllog" id="divscrolllog" style="display.">
			<p name="msjwaitline" id="msjwaitline" align="center"><img src="img/waitazul.gif" width="100px" ></p>	
				<div class="card">
					 
        <script src="jstimeline/vis-timeline-graph2d.min.js"></script>
  <link href="jstimeline/vis-timeline-graph2d.min.css" rel="stylesheet" type="text/css" />
  <style type="text/css">
   
 
 
  </style>
 
 <?php
 if ($_REQUEST['unitsn']=="")
 {
?>
<br>
<div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-gradient-danger">
              <span class="info-box-icon"><i class="fas fa-exclamation-triangle"></i></span>

              <div class="info-box-content">

              <span class="progress-description">
                  Error..
                </span>

                
                <div class="progress">
                  <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="info-box-text">missing input parameters</span>
             
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
<?php
  exit();
 }
 $v_sn = $_REQUEST['unitsn'];
 ?>
 
<!-- Timeline horiz -->
<div class='container-fluid'> 
<?php


?>
<div class="card-header">
						<h6 class="card-title colorazulfiplex" id="totalpassarriba" name="totalpassarriba">
            </h6>
		 

					</div>
<br>
 

 
<!-- fin timeline horiz -->
 
<!-- GRAFICOS ecualización -->
<div id="grafgralecump" name="grafgralecump" class=""   >

<section class="col-lg-12 connectedSortable ui-sortable">
 
 
 
<br>

  <div class="row  " id="divgrafico700mp" name="divgrafico700mp" >
     
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


      </div>
      <div class="col-12">
       <hr style=" border: 1px solid #007bff;">
         <div class="row">
     
         
          


          
              <div class="col-12  " id="divgrafico700strimdlbl01" name="divgrafico700strimdlbl01">
              
                    <div class="chart">
                      <canvas id="grafico700strimdlbl01" height="280" style="height: 280;"></canvas>
                    </div>
                </div>

         </div>
      </div>



   </div>

  

 
</section>
    
   
</div>
<!-- fin GRAFICOS ecualización -->
 
<hr>
 
				</div>
			</div>
					
      <?php // echo  $textoamostrar ; ?>
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
<script src="js/eModal.min.js" type="text/javascript" />

<script type="text/javascript" src="js/tabulator.min.js"></script>

<style type="text/css">


.horizontal-scroll-contenedor {
    width: auto;
    height: 100px;
    overflow-y: hidden;
    overflow-x: auto;
    padding: 10px;   
    white-space: nowrap;
}

.horizontal-scroll-contenedor > div {
       
       
        margin: 0 10px 0 0;
        padding: 0;
        display: inline-block;
        text-align: center;
        line-height: 22px;
    }

    .step_borde_verde
    {

      border-radius: 20px 20px 0px 2px;
-moz-border-radius: 20px 20px 0px 2px;
-webkit-border-radius: 20px 20px 0px 2px;
border: 2px solid #0d913b;
    }
    
    .step_borde_rojo
    {

      border-radius: 20px 20px 0px 2px;
-moz-border-radius: 20px 20px 0px 2px;
-webkit-border-radius: 20px 20px 0px 2px;
border: 2px solid #ff0303;
    }
    .step_borde_gris
    {

      border-radius: 20px 20px 0px 2px;
-moz-border-radius: 20px 20px 0px 2px;
-webkit-border-radius: 20px 20px 0px 2px;
border: 2px solid #696969;
    }

 
 .vis-item.orange
    {
         border-color: orange;
         color:black;
         background-color: orange;
    }

    .vis-item.red
    {
         border-color: red;
         color:white;
         background-color: red;
    }
    /*  'Unit Calibration' */
    .vis-item.mm5c6bc0
    {
         border-color: #5c6bc0;
         color:white;
         background-color: #5c6bc0;
    }
      /*  'Accept DigitalBoard' */
      .vis-item.mm202020
    {
         border-color: #202020;
         color:white;
         background-color: #202020;
    }
      /*  'Total Pass */
      .vis-item.mmdb4437
    {
         border-color: #db4437;
         color:white;
         background-color: #db4437;
    }
      /*  'Printer Services StandAlone'' */
      .vis-item.mme06055
    {
         border-color: #e06055;
         color:white;
         background-color: #e06055;
    }
      /*  'Unit Final Check'' */
      .vis-item.mme06055
    {
         border-color: #9e9d24;
         color:white;
         background-color: #9e9d24;
    }
       /*  'Print Label'' */
       .vis-item.mme4776e
    {
         border-color: #e4776e;
         color:white;
         background-color: #e4776e;
    }
    /* 'Accept DiB Flex', */
    .vis-item.mmf5bf26
    {
         border-color: #f5bf26;
         color:white;
         background-color: #f5bf26;
    }
     /* 'Accept Module', */
     .vis-item.mm51b886
    {
         border-color: #51b886;
         color:white;
         background-color: #51b886;
    }
     /* Digital Module', */
     .vis-item.mmab47bc
    {
         border-color: #ab47bc;
         color:white;
         background-color: #ab47bc;
    }
     /* Unit Final Check', */
    .vis-item.mm9e9d24
    {
         border-color: #9e9d24;
         color:white;
         background-color: #9e9d24;
    }
        /*'Unlock DiB, */
        .vis-item.mmf06292
    {
         border-color: #f06292;
         color:white;
         background-color: #f06292;
    }
        /* Instruments GUI, */
        .vis-item.mmacab44
    {
         border-color: #acab44;
         color:white;
         background-color: #acab44;
    }

   /* alternating column backgrounds */
   .vis-time-axis .vis-grid.vis-odd {
      background: #f5f5f5;
    }

    /* gray background in weekends, white text color */
    .vis-time-axis .vis-grid.vis-saturday,
    .vis-time-axis .vis-grid.vis-sunday {
      background: gray;
    }
    .vis-time-axis .vis-text.vis-saturday,
    .vis-time-axis .vis-text.vis-sunday {
      color: white;
    }
    
    

    .vis-item.red
    {
        border-color: red;
        color:white;
         background-color: red;
    }
    .vis-item.yellow
    {
        border-color: yellow;
         background-color: yellow;
    }
    .vis-item.orange
    {
        border-color: orange;
         background-color: orange;
    }

    .history-tl-container{
 
}
.history-tl-container ul.tl{
    margin:20px 0;
    padding:0;
    display:inline-block;

}
.history-tl-container ul.tl li{
    list-style: none;
    margin:auto;
    margin-left:15px;
    min-height:50px;
    /*background: rgba(255,255,0,0.1);*/
    border-left:1px dashed #86D6FF;
    padding:0 0 50px 30px;
    position:relative;
}
.history-tl-container ul.tl li:last-child{ border-left:0;}
.history-tl-container ul.tl li::before{
    position: absolute;
    left: -12px;
    top: -5px;
    content: " ";
    border: 8px solid rgba(255, 255, 255, 0.74);
    border-radius: 500%;
    background: #258CC7;
    height: 20px;
    width: 20px;
    transition: all 500ms ease-in-out;

}
.history-tl-container ul.tl li:hover::before{
    border-color:  #258CC7;
    transition: all 1000ms ease-in-out;
}
ul.tl li .item-title{
}
ul.tl li .item-detail{
    color:rgba(0,0,0,0.5);
    font-size:12px;
}
ul.tl li .timestamp{
    color: #8D8D8D;
    position: absolute;
  width:100px;
    left: -60%;
    text-align: right;
    font-size: 12px;
}
 /*
 
		'#f06292' =>',
		'#acab44' =>''
*/

.htimeline { list-style: none; padding: 0; margin: 20px 0 0; }

.htimeline .step { float: left; border-top-style: solid; border-top-width: 5px; position: relative; margin-bottom: 25px; text-align: left; padding: 3px 0 5px 10px; background-color: #ddd; color: #333;  vertical-align: middle; border-right: solid 1px #bbb; transition: all 0.5s ease;}
.htimeline .step:nth-child(odd) { background-color: #eee; }
.htimeline .step:first-child { border-left: solid 1px #bbb; }
.htimeline .step:hover { background-color: #ccc; border-bottom-width: 6px; }

.htimeline .step > div { margin: 0 5px; font-size: 14px; vertical-align: top; padding: 0;}

.htimeline .step.green { border-top-color: #348F50;}
.htimeline .step.orange { border-top-color: #F09819;}
.htimeline .step.red { border-top-color: #C04848;}
.htimeline .step.blue { border-top-color: #49a09d;}

.htimeline .step::before { width: 15px; height: 15px; border-radius: 50px; content: ' '; background-color: white; position: absolute; top: -10px; left: 0px; border-style: solid; border-width: 3px; transition: all 0.5s ease;}
.htimeline .step:hover::before { width: 18px; height: 18px; bottom: -12px; }
.htimeline .step.green::before {border-color: #348F50;}
.htimeline .step.orange::before {border-color: #F09819;}
.htimeline .step.red::before {border-color: #C04848;}
.htimeline .step.blue::before {border-color: #49a09d;}

.htimeline .step::after { content: attr(data-date); position: absolute; top: -20px; left: 17px; font-size: 11px; font-style: italic; color: #888}

/*TASKS*/
.htimeline .step .tasks { margin-top: 10px; }
.htimeline .step .tasks .resource {position: relative; height: 40px;}
.htimeline .step .tasks .resource::before { position: absolute; bottom: 2px; left: -5px; content: attr(data-name); font-size: 10px; font-style: italic; color: #888}
.htimeline .step .tasks .task { overflow: hidden; font-size: 10px; padding: 3px; border: solid 1px white; border-radius: 4px; min-height: 20px;}
.htimeline .step.green .tasks .task { background-color: #348F50; color: white; }
.htimeline .step.orange .tasks .task { background-color: #F09819; color: white; }
.htimeline .step.red .tasks .task { background-color: #C04848; color: white; }
.htimeline .step.blue .tasks .task { background-color: #49a09d; color: white; }


  </style>


</body>
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
  <link rel="stylesheet" href="plugins/sweetalert2/sweetalert2.min.css">
  <script src="plugins/chart.js/Chart.min.js"></script>

<script type="text/javascript">
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


 
   
	$( document ).ready(function() {
		
		//Inicio mostrar hora live
 
   var idrunrun = params.get('idr');
     console.log('idrun:'+params.get('idr'));

		 var interval = setInterval(function() {
			 
        var momentNow = moment();
		var newYork    = momentNow.tz('America/New_York').format('ha z');
        $('#date-part').html(momentNow.format('YYYY/MM/DD') 	  );
        $('#time-part').html(momentNow.format('hh:mm:ss'));
		}, 100);
		//FIN mostrar hora live
			console.log( "ready!" );
     

 
 
	
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
	

	// controlar inactividad en la web	
		$(document).inactivityTimeout({
                inactivityWait: 10000,
                dialogWait: 10,
                logoutUrl: 'logout.php'
            })
	// fin controlar inactividad en la web		
 
 
 


   
  
  function sumArray(a, b) {
      var c = [];
      for (var i = 0; i < Math.max(a.length, b.length); i++) {
        c.push( parseFloat(a[i] || 0) + parseFloat(b[i] || 0));
      }
      return c;
  }

  function buscarycentrartimeline()
{
  
  

  armar_graficos_imdstress();
  

}
 
 


  function saludame(nombtr)
  {
  
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
          url: 'ajax_graph_reportstressbbu.php?unitsn='+params.get('unitsn'),
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
                                                  label               :  'Voltage Read FIP485  ',
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
                                                  label               :  'Load Power',
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
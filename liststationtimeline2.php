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
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="http://webfas.fiplex.com/index.php" class="nav-link">Home</a>
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
            <h1>Activity Log TimeLine</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Activity Log TimeLine</li>
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
					 
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
  google.charts.load("current", {packages:["timeline"]});
  google.charts.setOnLoadCallback(drawChart);
  function drawChart() {

    var container = document.getElementById('example3.1');
    var chart = new google.visualization.Timeline(container);
    var dataTable = new google.visualization.DataTable();
    dataTable.addColumn({ type: 'string', id: 'Position' });
    dataTable.addColumn({ type: 'string', id: 'Name' });
    dataTable.addColumn({ type: 'date', id: 'Start' });
    dataTable.addColumn({ type: 'date', id: 'End' });
    dataTable.addRows([

      <?php
        
        $sqlmm="select *, dateinfom + totaltime as totaltimesum, dateinfom + totalparcial as totaltimeparcial, datetimeend
        from (
          select station ,userruninfo, runinfodb.script , dateinfom,  dateserver ,runinfodb.idruninfo ,  max (fas_times.duration) as totaltime, 
        sum(fas_times_typett.duration) as totalparcial, max(datetimeend) as datetimeend
        from runinfodb
        left join fas_times
        on fas_times.idruninfo = runinfodb.idruninfo and
        fas_times.idtimetype = 0
        left join fas_times as fas_times_typett
        on fas_times_typett.idruninfo = runinfodb.idruninfo and
        fas_times_typett.idtimetype > 0
    		left join fas_stats_bugs as fas_stats_bugs
        on fas_stats_bugs.idruninfo = runinfodb.idruninfo
        where dateserver > CURRENT_DATE 
        and userruninfo not in ('fasserver')
        and userruninfo not in ('fasserver')
        and runinfodb.script  not like '%Print%'
			  and runinfodb.script  not like '%Test%'
        group by station,  userruninfo, runinfodb.script , dateinfom,  dateserver, runinfodb.idruninfo
        order by station ,userruninfo
        ) as  ttt  order by userruninfo , dateserver
        
        ";

        $datalineality = $connect->query($sqlmm)->fetchAll();
        $usu="";
        $ususation="";
        $cantusarios=0;
							foreach ($datalineality as $row) 
							{
            //    echo "aaaaaaaaaaaaaaaa".$row['userruninfo'];
                if ( trim($usu) <> trim($row['userruninfo']))
                {
                   $usu = trim($row['userruninfo']);
                   $ususation = trim($row['station']);
                   $cantusarios=$cantusarios + 1;
                   ?>
                         [ '<?php echo  trim($ususation); ?>', '', new Date("<?php echo substr($row['dateinfom'], 0, 10); ?>T07:00:00.000"), new Date("<?php echo substr($row['dateinfom'], 0, 10); ?>T07:00:00.100") ],
                         [ '<?php echo  $ususation; ?>', '', new Date("<?php echo substr($row['dateinfom'], 0, 10); ?>T18:00:00.000"), new Date("<?php echo substr($row['dateinfom'], 0, 10); ?>T18:00:00.100") ],
                   <?php

                }
            //    else
            //    {
                  $fechafin="";
                  $duracioinfo="";
                  if ($row['datetimeend'] ==NULL  )
                  {
                    if ($row['totaltimesum'] ==NULL )
                    {
                      if ($row['totaltimeparcial'] ==NULL )
                      {
                        $fechafin=$row['dateinfom'];
                        $duracioinfo="0";  
                      }
                      else
                      {
                        $fechafin=$row['totaltimeparcial'];
                        $duracioinfo=$row['totalparcial'];  
                      }
                    }
                    else
                    {
                      $fechafin=$row['totaltimesum'];
                      $duracioinfo=$row['totaltime'];  
                    }
                  }
                  else
                  {
                    $fechafin=$row['dateinfom'];
                    $duracioinfo="0";  
                  }
                     
                  ?>
                  [ '<?php echo  $ususation; ?>', '<?php echo  trim($row['script'])."-".trim($row['idruninfo'])  ; ?>', new Date("<?php echo $row['dateinfom']; ?>"), new Date("<?php echo $fechafin; ?>") ],
                  <?php
                  $textoamostrar =  $textoamostrar ."usu:".$usu."-Script:".trim($row['script'])." -> FI:".$row['dateinfom']."-FF:".$fechafin."<br>";
               // }
                
               
              }
        
        
        ?>
    /*  [ 'Station 03', '', new Date("2020-04-12T07:00:00.000"), new Date("2020-04-12T07:00:01.000") ],
      [ 'Station 03', 'George Washington', new Date("2020-04-12T03:00:00.000"), new Date("2020-04-12T04:00:00.000") ],
      [ 'Station 03', 'John Adams', new Date("2020-04-12T11:01:00.000"), new Date("2020-04-12T11:04:00.000") ],
      [ 'Station 03', '', new Date("2020-04-12T17:00:00.000"), new Date("2020-04-12T17:00:01.000") ],*/
 
    ]);

    chart.draw(dataTable);
  }
</script>
<br>
<b>&nbsp; <i class='fas fa-calendar-alt' style='font-size:14px'></i> Date: <?php echo date('Y-m-d', mktime(0, 0, 0, date("m"), date("d"), date("Y"))); // 2016-03-21
 ?></b><br>
<div id="example3.1" style="height: 400px;"></div>

<!-- inicio timeline dia -->
<script type="text/javascript">
  google.charts.load("current", {packages:["timeline"]});
  google.charts.setOnLoadCallback(drawChart);
  function drawChart() {

    var container1 = document.getElementById('example1');
    var chart1 = new google.visualization.Timeline(container1);
    var dataTable1 = new google.visualization.DataTable();
    dataTable1.addColumn({ type: 'string', id: 'Position' });
    dataTable1.addColumn({ type: 'string', id: 'Name' });
    dataTable1.addColumn({ type: 'date', id: 'Start' });
    dataTable1.addColumn({ type: 'date', id: 'End' });
    dataTable1.addRows([

      <?php
        
        $sqlmm="select *, dateinfom + totaltime as totaltimesum, dateinfom + totalparcial as totaltimeparcial, datetimeend
        from (
          select station ,userruninfo, runinfodb.script , dateinfom,  dateserver ,runinfodb.idruninfo ,  max (fas_times.duration) as totaltime, 
        sum(fas_times_typett.duration) as totalparcial, max(datetimeend) as datetimeend
        from runinfodb
        left join fas_times
        on fas_times.idruninfo = runinfodb.idruninfo and
        fas_times.idtimetype = 0
        left join fas_times as fas_times_typett
        on fas_times_typett.idruninfo = runinfodb.idruninfo and
        fas_times_typett.idtimetype = 0
	    	left join fas_stats_bugs as fas_stats_bugs
        on fas_stats_bugs.idruninfo = runinfodb.idruninfo
        where dateserver > (CURRENT_DATE -INTERVAL '1 day')   and  dateserver < CURRENT_DATE  
        and userruninfo not in ('fasserver')
        
			  and runinfodb.script  not like '%Test%'
        group by station,  userruninfo, runinfodb.script , dateinfom,  dateserver, runinfodb.idruninfo
        order by station ,userruninfo
        ) as  ttt  order by userruninfo , dateserver
        
        ";

        $datalineality = $connect->query($sqlmm)->fetchAll();
        $usu="";
        $ususation="";
        $textoamostrar = "";
        $cantusarios=0;
							foreach ($datalineality as $row) 
							{
            //    echo "aaaaaaaaaaaaaaaa".$row['userruninfo'];
                if ( trim($usu) <> trim($row['userruninfo']))
                {
                   $usu = trim($row['userruninfo']);
                   $cantusarios=$cantusarios+1;
                   $ususation = trim($row['station']);
                   ?>
                         [ '<?php echo  trim($ususation); ?>', '', new Date("<?php echo substr($row['dateinfom'], 0, 10); ?>T07:00:00.000"), new Date("<?php echo substr($row['dateinfom'], 0, 10); ?>T07:00:00.100") ],
                         [ '<?php echo  $ususation; ?>', '', new Date("<?php echo substr($row['dateinfom'], 0, 10); ?>T18:00:00.000"), new Date("<?php echo substr($row['dateinfom'], 0, 10); ?>T18:00:00.100") ],
                   <?php



                }
               // else
              //  {
                  $fechafin="";
                  $duracioinfo="";
                  if ($row['datetimeend'] ==NULL  )
                  {
                    if ($row['totaltimesum'] ==NULL )
                    {
                      if ($row['totaltimeparcial'] ==NULL )
                      {
                        $fechafin=$row['dateinfom'];
                        $duracioinfo="0";  
                      }
                      else
                      {
                        $fechafin=$row['totaltimeparcial'];
                        $duracioinfo=$row['totalparcial'];  
                      }
                    }
                    else
                    {
                      $fechafin=$row['totaltimesum'];
                      $duracioinfo=$row['totaltime'];  
                    }
                  }
                  else
                  {
                    $fechafin=$row['datetimeend'];
                    $duracioinfo="0";  
                  }
                     
                  ?>
                  [ '<?php echo  $ususation; ?>', '<?php echo  trim($row['script'])."-".trim($row['idruninfo'])  ; ?>', new Date("<?php echo $row['dateinfom']; ?>"), new Date("<?php echo $fechafin; ?>") ],
                  <?php
                  $textoamostrar =  $textoamostrar ."usu:".$usu."-Script:".trim($row['script'])." -> FI:".$row['dateinfom']."-FF:".$fechafin."<br>";
              //  }
                
               
              }
        
        
        ?>
 
    ]);

    chart1.draw(dataTable1);
  }
</script>
<br><hr><br>
<b>&nbsp; <i class='fas fa-calendar-alt' style='font-size:14px'></i> Date: <?php echo date('Y-m-d', mktime(0, 0, 0, date("m"), date("d")-1, date("Y"))); // 2016-03-21
 ?></b><br>
<div id="example1" style="height: 500px;"></div>
<!-- Fin timeline dia -->

<!-- inicio timeline dia -->
<script type="text/javascript">
  google.charts.load("current", {packages:["timeline"]});
  google.charts.setOnLoadCallback(drawChart2);
  function drawChart2() {

    var container2 = document.getElementById('example2');
    var chart2 = new google.visualization.Timeline(container2);
    var dataTable2 = new google.visualization.DataTable();
    dataTable2.addColumn({ type: 'string', id: 'Position' });
    dataTable2.addColumn({ type: 'string', id: 'Name' });
    dataTable2.addColumn({ type: 'date', id: 'Start' });
    dataTable2.addColumn({ type: 'date', id: 'End' });
    dataTable2.addRows([

      <?php
        
        $sqlmm="select *, dateinfom + totaltime as totaltimesum, dateinfom + totalparcial as totaltimeparcial, datetimeend
        from (
          select station ,userruninfo, runinfodb.script , dateinfom,  dateserver ,runinfodb.idruninfo ,  max (fas_times.duration) as totaltime, 
        sum(fas_times_typett.duration) as totalparcial, max(datetimeend) as datetimeend
        from runinfodb
        left join fas_times
        on fas_times.idruninfo = runinfodb.idruninfo and
        fas_times.idtimetype = 0
        left join fas_times as fas_times_typett
        on fas_times_typett.idruninfo = runinfodb.idruninfo and
        fas_times_typett.idtimetype > 0
	    	left join fas_stats_bugs as fas_stats_bugs
        on fas_stats_bugs.idruninfo = runinfodb.idruninfo
        where dateserver > (CURRENT_DATE -INTERVAL '2 day')   and  dateserver <  (CURRENT_DATE -INTERVAL '1 day')   
        and userruninfo not in ('fasserver')
        
			  and runinfodb.script  not like '%Test%'
        group by station,  userruninfo, runinfodb.script , dateinfom,  dateserver, runinfodb.idruninfo
        order by station ,userruninfo
        ) as  ttt  order by userruninfo , dateserver
        
        ";

          $datalineality = $connect->query($sqlmm)->fetchAll();
          $usu="";
          $ususation="";
          $textoamostrar = "";
                foreach ($datalineality as $row) 
							{
            //    echo "aaaaaaaaaaaaaaaa".$row['userruninfo'];
                if ( trim($usu) <> trim($row['userruninfo']))
                {
                   $usu = trim($row['userruninfo']);
                   $ususation = trim($row['station']);
                   ?>
                         [ '<?php echo  trim($ususation); ?>', '', new Date("<?php echo substr($row['dateinfom'], 0, 10); ?>T07:00:00.000"), new Date("<?php echo substr($row['dateinfom'], 0, 10); ?>T07:00:00.100") ],
                         [ '<?php echo  $ususation; ?>', '', new Date("<?php echo substr($row['dateinfom'], 0, 10); ?>T18:00:00.000"), new Date("<?php echo substr($row['dateinfom'], 0, 10); ?>T18:00:00.100") ],
                   <?php



                }
               // else
              //  {
                  $fechafin="";
                  $duracioinfo="";
                  if ($row['datetimeend'] ==NULL  )
                  {
                    if ($row['totaltimesum'] ==NULL )
                    {
                      if ($row['totaltimeparcial'] ==NULL )
                      {
                        $fechafin=$row['dateinfom'];
                        $duracioinfo="0";  
                      }
                      else
                      {
                        $fechafin=$row['totaltimeparcial'];
                        $duracioinfo=$row['totalparcial'];  
                      }
                    }
                    else
                    {
                      $fechafin=$row['totaltimesum'];
                      $duracioinfo=$row['totaltime'];  
                    }
                  }
                  else
                  {
                    $fechafin=$row['datetimeend'];
                    $duracioinfo="0";  
                  }
                     
                  ?>
                  [ '<?php echo  $ususation; ?>', '<?php echo  trim($row['script'])."-".trim($row['idruninfo'])  ; ?>', new Date("<?php echo $row['dateinfom']; ?>"), new Date("<?php echo $fechafin; ?>") ],
                  <?php
                  $textoamostrar =  $textoamostrar ."usu:".$usu."-Script:".trim($row['script'])." -> FI:".$row['dateinfom']."-FF:".$fechafin."<br>";
              //  }
                
               
              }
        
        
        ?>
 
    ]);

    chart2.draw(dataTable2);
  }
</script>
<br><hr><br>
<b>&nbsp; <i class='fas fa-calendar-alt' style='font-size:14px'></i> Date: <?php echo date('Y-m-d', mktime(0, 0, 0, date("m"), date("d")-2, date("Y"))); // 2016-03-21
 ?></b><br>
<div id="example2" style="height: 600px;"></div>
<!-- Fin timeline dia -->
 
 

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

<script type="text/javascript" src="js/tabulator.min.js"></script>

</body>

<script type="text/javascript">

   
   
	$( document ).ready(function() {
		
		//Inicio mostrar hora live
		 var interval = setInterval(function() {
			 
        var momentNow = moment();
		var newYork    = momentNow.tz('America/New_York').format('ha z');
        $('#date-part').html(momentNow.format('YYYY/MM/DD') 	  );
        $('#time-part').html(momentNow.format('hh:mm:ss'));
		}, 100);
		//FIN mostrar hora live
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
			
	});
	

	// controlar inactividad en la web	
		$(document).inactivityTimeout({
                inactivityWait: 10000,
                dialogWait: 10,
                logoutUrl: 'logout.php'
            })
	// fin controlar inactividad en la web		
	
	 /* requesting data */
     		
		
	  
   
   function show_log(idlog_view)
   {
	 	   
	 $("#detallelog").fadeOut('fast');  
	  $("#msjwait").fadeIn('slow');   
		
		 $("#uso").val(1);
		 
	    $.ajax
			({ 
				url: 'readlogbyruninfo.php',
				data: "idlog="+idlog_view,	
				type: 'post',
				async:true,
                cache:false,
				success: function(data)
				{
					var datax = JSON.parse(data)
				//	console.log(datax);
                 //   console.log(datax.vuser);
					
					//detallelog
					 $("#msjwait").hide();
					 	$("#detallelog").fadeIn(100);						
						//var re = /<TERM>/g; 						
						$("#detallelog").html(datax.data.replace(/<br>/g,' \r\n'));
						
						if ($( window ).height()>800)
						{
							$("#detallelog").height(585);
						}
						
						
						$( window ).height();
						
						$('#lblvuser').text(datax.vuser.replace("#"," "));
						$('#lblvdevice').text(datax.vdecice.replace("#"," "));
						var anex = "'"+idlog_view+"'" ;
						
						$('#lblvstationr').html(datax.vstation.replace("#"," ") +' <a href="#" onclick="show_log2('+anex	+')") ><i class="fas fa-bug" style="color:blue"></i></a>');
					
				}
			});
   }
     function show_log2(idlog_view)
   {
	 	   
	 	 	   
	 $("#detallelog").fadeOut('fast');  
	  $("#msjwait").fadeIn('slow');   
		
		 $("#uso").val(1);
		 
	    $.ajax
			({ 
				url: 'readlogbyruninfodebug.php',
				data: "idlog="+idlog_view,	
				type: 'post',
				async:true,
                cache:false,
				success: function(data)
				{
					var datax = JSON.parse(data)
				//	console.log(datax);
                 //   console.log(datax.vuser);
					
					//detallelog
					 $("#msjwait").hide();
					 	$("#detallelog").fadeIn(100);						
						//var re = /<TERM>/g; 						
						$("#detallelog").html(datax.data.replace(/<br>/g,' \r\n'));
						$('#lblvuser').text(datax.vuser.replace("#"," "));
						$('#lblvdevice').text(datax.vdecice.replace("#"," "));
						var anex = "'"+idlog_view+"'" ;
						
						$('#lblvstationr').html(datax.vstation.replace("#"," ") +' <a href="#" onclick="show_log('+anex	+')") ><i class="fas fa-bug" style="color:green"></i></a>');
					
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
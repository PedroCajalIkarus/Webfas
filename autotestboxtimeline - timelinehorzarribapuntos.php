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
            <h1>Auto Calibrate FLEX - TimeLine</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Auto Calibrate FLEX </li>
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
 if ($_REQUEST['idr']=="")
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
 
 ?>

 

<section class="cd-horizontal-timeline">
  <div class="timeline">
    <div class="events-wrapper">
      <div class="events">
        <ol>
          <li><a href="#0" data-date="00/00/00" class="selected">Calibration_EQ_Calibration_Rx</a></li>
          <li><a href="#0" data-date="01/00/00">Calibration_EQ_Calibration_Tx</a></li>
          <li><a href="#0" data-date="02/00/00">Calibration_EQ_Check_Rx</a></li>
          <li><a href="#0" data-date="03/00/00">Calibration_EQ_Check_Tx</a></li>
          <li><a href="#0" data-date="04/00/00">04:00</a></li>
          <li><a href="#0" data-date="05/00/00">05:00</a></li>
          <li><a href="#0" data-date="06/00/00">06:00</a></li>
          <li><a href="#0" data-date="07/00/00">07:00</a></li>
          <li><a href="#0" data-date="08/00/00">08:00</a></li>
          <li><a href="#0" data-date="09/00/00">09:00</a></li>
          <li><a href="#0" data-date="10/00/00">10:00</a></li>
          <li><a href="#0" data-date="11/00/00">11:00</a></li>
          <li><a href="#0" data-date="12/00/00">12:00</a></li>
          <li><a href="#0" data-date="13/00/00">13:00</a></li>
          <li><a href="#0" data-date="14/00/00">14:00</a></li>
          <li><a href="#0" data-date="15/00/00">15:00</a></li>
          <li><a href="#0" data-date="16/00/00">16:00</a></li>
          <li><a href="#0" data-date="17/00/00">17:00</a></li>
          <li><a href="#0" data-date="18/00/00">18:00</a></li>
          <li><a href="#0" data-date="19/00/00">19:00</a></li>
          <li><a href="#0" data-date="20/00/00">20:00</a></li>
          <li><a href="#0" data-date="21/00/00">21:00</a></li>
          <li><a href="#0" data-date="22/00/00">22:00</a></li>
          <li><a href="#0" data-date="23/00/00">23:00</a></li>
        </ol>

        <span class="filling-line" aria-hidden="true"></span>
      </div>
      <!-- .events -->
      </div>
    <!-- .events-wrapper -->

    <ul class="cd-timeline-navigation">
      <li><a href="#0" class="prev inactive">Prev</a></li>
      <li><a href="#0" class="next">Next</a></li>
    </ul>
    <!-- .cd-timeline-navigation -->
  </div>
  <!-- .timeline -->

  <div class="events-content">
    <ol>
      <li class="selected" data-date="00/00/00">

        <p>Consectetur adipisicing elit.
        </p>
      </li>
      <li data-date="01/00/00">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
        </p>
      </li>
      <li data-date="02/00/00">
        <p>Dolor sit amet, consectetur adipisicing elit.
        </p>
      </li>

      <li data-date="03/00/00">
        <p>Lorem ipsum dolor sit amet
        </p>
      </li>

      <li data-date="04/00/00">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
        </p>
      </li>

      <li data-date="05/00/00">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
        </p>
      </li>

      <li data-date="06/00/00">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
        </p>
      </li>

      <li data-date="07/00/00">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
        </p>
      </li>

      <li data-date="08/00/00">
        	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. 
				</p>
      </li>

      <li data-date="09/00/00">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
        </p>
      </li>

      <li data-date="10/00/00">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
        </p>
      </li>

      <li data-date="11/00/00">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
        </p>
      </li>
      <li data-date="12/00/00">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
        </p>
      </li>
      <li data-date="13/00/00">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
        </p>
      </li>
      <li data-date="14/00/00">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
        </p>
      </li>
      <li data-date="15/00/00">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
        </p>
      </li>
      <li data-date="16/00/00">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
        </p>
      </li>
      <li data-date="17/00/00">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
        </p>
      </li>
      <li data-date="18/00/00">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
        </p>
      </li>
      <li data-date="19/00/00">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
        </p>
      </li>
      <li data-date="20/00/00">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
        </p>
      </li>
      <li data-date="21/00/00">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
        </p>
      </li>
      <li data-date="22/00/00">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
        </p>
      </li>
      <li data-date="23/00/00">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
        </p>
      </li>
    </ol>
  </div>
  <!-- .events-content -->
</section>
 <!-- fin -->
 ****************aaaaaaaaaaaaaaa***************
 

<!-- GRAFICOS ecualización -->
<div id="grafgralecu" name="visualization"   >
    <section class="col-lg-12 connectedSortable ui-sortable">
  <br>  <h5>Equalization</h5>
  
      <div class="row">
     
          <div class="col-6">
          <hr style=" border: 1px solid #007bff;">
          <p class="  colorazulfiplex" style="font-size: 1.25rem"><b>700 UpLink</b></p> 
             <div class="row">
          
              <div class="col-12">
              <b>TOTAL RIPPLE</b> 
                <div class="chart">
                  <canvas id="grafico700uptotal00" height="280" style="height: 280;"></canvas>
                </div>
              </div>
              <div class="col-6">
              <b>RX RIPPLE</b>
                <div class="chart">
                    <canvas id="grafico700uprx00" height="280" style="height: 280;"></canvas>
                  </div>
              </div>
              <div class="col-6">
              <b>TX RIPPLE</b>
                <div class="chart">
                    <canvas id="grafico700uptx00" height="280" style="height: 280;"></canvas>
                  </div>
              </div>
            </div>


          </div>
          <div class="col-6">   
          <hr style=" border: 1px solid #007bff;">
           <p class="  colorazulfiplex" style="font-size: 1.25rem"><b>700 DownLink</b></p> 
          <div class="row">
              <div class="col-12">
              <b>TOTAL RIPPLE</b> 
                <div class="chart">
                  <canvas id="grafico700uptotal01" height="280" style="height: 280;"></canvas>
                </div>
              </div>
              <div class="col-6">
              <b>RX RIPPLE</b>
                <div class="chart">
                    <canvas id="grafico700uprx01" height="280" style="height: 280;"></canvas>
                  </div>
              </div>
              <div class="col-6">
              <b>TX RIPPLE</b>
                <div class="chart">
                    <canvas id="grafico700uptx01" height="280" style="height: 280;"></canvas>
                  </div>
              </div>
            </div>

          </div>

      </div>
    </section> 
    <section class="col-lg-12 connectedSortable ui-sortable">
    <div class="row">
    <div class="col-6">
    <hr style=" border: 1px solid #007bff;">
    <p class="  colorazulfiplex" style="font-size: 1.25rem"><b>800 UpLink</b></p> 
    <div class="row">
              <div class="col-12">
              TOTAL RIPPLE 
                <div class="chart">
                  <canvas id="grafico800uptotal10" height="280" style="height: 280;"></canvas>
                </div>
              </div>
              <div class="col-6">
              RX RIPPLE
                <div class="chart">
                    <canvas id="grafico800uprx10" height="280" style="height: 280;"></canvas>
                  </div>
              </div>
              <div class="col-6">
              TX RIPPLE
                <div class="chart">
                    <canvas id="grafico800uptx10" height="280" style="height: 280;"></canvas>
                  </div>
              </div>
            </div>
          </div>
          <div class="col-6">
          <hr style=" border: 1px solid #007bff;">
          <p class="  colorazulfiplex" style="font-size: 1.25rem"><b>800 DownLink</b></p> 
           
          <div class="row">
              <div class="col-12">
              TOTAL RIPPLE 
                <div class="chart">
                  <canvas id="grafico800uptotal11" height="280" style="height: 280;"></canvas>
                </div>
              </div>
              <div class="col-6">
              RX RIPPLE
                <div class="chart">
                    <canvas id="grafico800uprx11" height="280" style="height: 280;"></canvas>
                  </div>
              </div>
              <div class="col-6">
              TX RIPPLE
                <div class="chart">
                    <canvas id="grafico800uptx11" height="280" style="height: 280;"></canvas>
                  </div>
              </div>
            </div>
          </div>
      </div>
    </section> 
</div>
<!-- fin GRAFICOS ecualización -->
<section class="col-lg-12 connectedSortable ui-sortable">
<br>  <h5>TimeLine</h5>
  <hr style=" border: 1px solid #007bff;">
<div id="visualization" name="visualization"   ></div>
</section> 

<hr>

<div class="container-fluid">
<h4> List routine :: DH7S-A
</h4>


<div id="archivosPreview" style="width: 500px; height: 400px; overflow-y: scroll;">

<div class="history-tl-container">
  <ul class="tl">

<?php
  $sql = $connect->prepare("	select distinct branchname as script,    fas_times_type.timename, min(datetimelog) as datetimelog , min(datetimelog+fas_times.duration::time) as datetimelogresta ,
	userruninfo, station, device, runinfodb.idruninfo ,
	bandnuevo, listroutime.uldl
	from fas_tree_measure 
	inner join
	(
		select fas_routines_product.*,fas_step.description as branchname, CASE fas_routines_product.idband
  WHEN 0  THEN 0
  WHEN 3  THEN 0
  WHEN 4  THEN 1
  WHEN 8  THEN 1
  WHEN 7  THEN 1
  WHEN 1  THEN 1
  WHEN 6  THEN 1
  ELSE NULL
  END AS bandnuevo from  fas_routines_product 
		inner join fas_tree_product 
		on fas_tree_product.idproduct = fas_routines_product.idproduct
		inner join fas_tree
		on fas_tree.iduniquebranch = fas_routines_product.iduniquebranch
		and fas_tree.idfastree = fas_tree_product.idfastree
		inner join fas_step
		on fas_tree.idfastrepson = fas_step.idfasstep
		where fas_routines_product.idproduct = (SELECT idproduct from fnt_select_allproducts_maxrev() where modelciu like 'DH7S-A') 
		 
		and fas_routines_product.active = 'Y'
		order by idorden
	) as listroutime
	on listroutime.iduniquebranch =  fas_tree_measure.iduniquebranch
	inner join runinfodb
	on runinfodb.idruninfodb = fas_tree_measure.idrununfo
	inner join fas_times
	on fas_times.iduniqueop   = fas_tree_measure.iduniqueop 
	and fas_times.idsinglemeasure is null 
	and fas_times.idsameasures is null
	and fas_times.iducmeasure is null
	
	inner join fas_times_type
	on fas_times_type.idtimetype = fas_times.idtimetype
	where idrununfo = 10901032323
	group by branchname ,  fas_times_type.timename,	userruninfo, station, device, runinfodb.idruninfo  ,bandnuevo, listroutime.uldl

 ");
				//		 echo $sql;
			
					$sql->execute();
					
					$resultado = $sql->fetchAll();
          $pas=1;
					 foreach ($resultado as $row) {
            //  echo "* -".$row['branchname']."<br>";
              ?>
                <li class="tl-item" ng-repeat="item in retailer_history">
                  <div class="timestamp">
                  <!--  3rd March 2015<br> 7:00 PM -->
                  </div>
                  <div class="item-title">
                  <?php
                  if ($row['sn'] <> "")
                  {
                    ?>
                       <b><?php echo $row['script']." [ Band: ".$row['idbandperson']." - ULDL: ".$row['uldl']." ]";?></b> 
                     <?php
                   }
                   else
                   {
                     ?><?php echo $row['script'];?>
                     <?php
                   }   ?> 
                  </div>
                  <?php
                  if ($row['sn'] <> "")
                  {

                      
                      ?>
                      <div class="item-detail">
                      <?php if ( $row['totalpass']==1)
                      {
                        $pas=0;
                        ?><span class="badge bg-green">Pass</span><br>
                        <?php
                      }
                      else                  
                      {
                        $pas=1;
                        ?>
                          <span class="badge bg-red">Fail</span><br>
                        <?php
                      }
                      ?>                
                      Duration: <i class='far fa-clock'></i> <?php echo $row['duration'];?><br>
                      </div>
                    </li>
      
                  <?php
                   }
           }


            ?>


  
  </ul>

</div>
 
</div>


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
<script src="js/eModal.min.js" type="text/javascript" />

<script type="text/javascript" src="js/tabulator.min.js"></script>

<style type="text/css">
 
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
 

    /* -------------------------------- 
Main Components 
-------------------------------- */
.cd-horizontal-timeline {
  opacity: 0;
  margin: 2em auto;
  -webkit-transition: opacity 0.2s;
  -moz-transition: opacity 0.2s;
  transition: opacity 0.2s;
}
.cd-horizontal-timeline::before {
  /* never visible - this is used in jQuery to check the current MQ */
  content: 'mobile';
  display: none;
}
.cd-horizontal-timeline.loaded {
  opacity: 1;
}
.cd-horizontal-timeline .timeline {
  position: relative;
  height: 100px;
  width: 1200px;
  max-width: 1200px;
  margin: 0 auto;
}
.cd-horizontal-timeline .events-wrapper {
  position: relative;
  height: 100%;
  margin: 0 40px;
  overflow: hidden;
}
.cd-horizontal-timeline .events-wrapper::after, .cd-horizontal-timeline .events-wrapper::before {
  /* these are used to create a shadow effect at the sides of the timeline */
  content: '';
  position: absolute;
  z-index: 2;
  top: 0;
  height: 100%;
  width: 20px;
}
.cd-horizontal-timeline .events-wrapper::before {
  left: 0;
  background-image: -webkit-linear-gradient( left , #f8f8f8, rgba(248, 248, 248, 0));
  background-image: linear-gradient(to right, #f8f8f8, rgba(248, 248, 248, 0));
}
.cd-horizontal-timeline .events-wrapper::after {
  right: 0;
  background-image: -webkit-linear-gradient( right , #f8f8f8, rgba(248, 248, 248, 0));
  background-image: linear-gradient(to left, #f8f8f8, rgba(248, 248, 248, 0));
}
.cd-horizontal-timeline .events {
  /* this is the grey line/timeline */
  position: absolute;
  z-index: 1;
  left: 0;
  top: 49px;
  height: 2px;
  /* width will be set using JavaScript */
  background: #dfdfdf;
  -webkit-transition: -webkit-transform 0.4s;
  -moz-transition: -moz-transform 0.4s;
  transition: transform 0.4s;
}
.cd-horizontal-timeline .filling-line {
  /* this is used to create the green line filling the timeline */
  position: absolute;
  z-index: 1;
  left: 0;
  top: 0;
  height: 100%;
  width: 100%;
  background-color: #7b9d6f;
  -webkit-transform: scaleX(0);
  -moz-transform: scaleX(0);
  -ms-transform: scaleX(0);
  -o-transform: scaleX(0);
  transform: scaleX(0);
  -webkit-transform-origin: left center;
  -moz-transform-origin: left center;
  -ms-transform-origin: left center;
  -o-transform-origin: left center;
  transform-origin: left center;
  -webkit-transition: -webkit-transform 0.3s;
  -moz-transition: -moz-transform 0.3s;
  transition: transform 0.3s;
}
.cd-horizontal-timeline .events a {
  position: absolute;
  bottom: 0;
  z-index: 2;
  text-align: center;
  font-size: 1.3rem;
  padding-bottom: 15px;
  color: #383838;
  /* fix bug on Safari - text flickering while timeline translates */
  -webkit-transform: translateZ(0);
  -moz-transform: translateZ(0);
  -ms-transform: translateZ(0);
  -o-transform: translateZ(0);
  transform: translateZ(0);
}
.cd-horizontal-timeline .events a::after {
  /* this is used to create the event spot */
  content: '';
  position: absolute;
  left: 50%;
  right: auto;
  -webkit-transform: translateX(-50%);
  -moz-transform: translateX(-50%);
  -ms-transform: translateX(-50%);
  -o-transform: translateX(-50%);
  transform: translateX(-50%);
  bottom: -5px;
  height: 12px;
  width: 12px;
  border-radius: 50%;
  border: 2px solid #dfdfdf;
  background-color: #f8f8f8;
  -webkit-transition: background-color 0.3s, border-color 0.3s;
  -moz-transition: background-color 0.3s, border-color 0.3s;
  transition: background-color 0.3s, border-color 0.3s;
}
.no-touch .cd-horizontal-timeline .events a:hover::after {
  background-color: #7b9d6f;
  border-color: #7b9d6f;
}
.cd-horizontal-timeline .events a.selected {
  pointer-events: none;
}
.cd-horizontal-timeline .events a.selected::after {
  background-color: #7b9d6f;
  border-color: #7b9d6f;
}
.cd-horizontal-timeline .events a.older-event::after {
  border-color: #7b9d6f;
}
@media only screen and (min-width: 1100px) {
  .cd-horizontal-timeline {
    margin: 6em auto;
  }
  .cd-horizontal-timeline::before {
    /* never visible - this is used in jQuery to check the current MQ */
    content: 'desktop';
  }
}

.cd-timeline-navigation a {
  /* these are the left/right arrows to navigate the timeline */
  position: absolute;
  z-index: 1;
  top: 50%;
  bottom: auto;
  -webkit-transform: translateY(-50%);
  -moz-transform: translateY(-50%);
  -ms-transform: translateY(-50%);
  -o-transform: translateY(-50%);
  transform: translateY(-50%);
  height: 34px;
  width: 34px;
  border-radius: 50%;
  border: 2px solid #dfdfdf;
  /* replace text with an icon */
  overflow: hidden;
  color: transparent;
  text-indent: 100%;
  white-space: nowrap;
  -webkit-transition: border-color 0.3s;
  -moz-transition: border-color 0.3s;
  transition: border-color 0.3s;
}
.cd-timeline-navigation a::after {
  /* arrow icon */
  content: '';
  position: absolute;
  height: 16px;
  width: 16px;
  left: 50%;
  top: 50%;
  bottom: auto;
  right: auto;
  -webkit-transform: translateX(-50%) translateY(-50%);
  -moz-transform: translateX(-50%) translateY(-50%);
  -ms-transform: translateX(-50%) translateY(-50%);
  -o-transform: translateX(-50%) translateY(-50%);
  transform: translateX(-50%) translateY(-50%);
  background: url(../img/cd-arrow.svg) no-repeat 0 0;
}
.cd-timeline-navigation a.prev {
  left: 0;
  -webkit-transform: translateY(-50%) rotate(180deg);
  -moz-transform: translateY(-50%) rotate(180deg);
  -ms-transform: translateY(-50%) rotate(180deg);
  -o-transform: translateY(-50%) rotate(180deg);
  transform: translateY(-50%) rotate(180deg);
}
.cd-timeline-navigation a.next {
  right: 0;
}
.no-touch .cd-timeline-navigation a:hover {
  border-color: #7b9d6f;
}
.cd-timeline-navigation a.inactive {
  cursor: not-allowed;
}
.cd-timeline-navigation a.inactive::after {
  background-position: 0 -16px;
}
.no-touch .cd-timeline-navigation a.inactive:hover {
  border-color: #dfdfdf;
}

.cd-horizontal-timeline .events-content {
  position: relative;
  width:100%;
  margin: 2em 0;
  overflow: hidden;
  -webkit-transition: height 0.4s;
  -moz-transition: height 0.4s;
  transition: height 0.4s;
}
.cd-horizontal-timeline .events-content li {
  position: absolute;
  z-index: 1;
 
  left: 0;
  top: 0;
  
  padding: 0 5%;
  opacity: 0;
  -webkit-animation-duration: 0.4s;
  -moz-animation-duration: 0.4s;
  animation-duration: 0.4s;
  -webkit-animation-timing-function: ease-in-out;
  -moz-animation-timing-function: ease-in-out;
  animation-timing-function: ease-in-out;
}
.cd-horizontal-timeline .events-content li.selected {
  /* visible event content */
  position: relative;
  z-index: 2;
  opacity: 1;
}
.cd-horizontal-timeline .events-content li.enter-right, .cd-horizontal-timeline .events-content li.leave-right {
  -webkit-animation-name: cd-enter-right;
  -moz-animation-name: cd-enter-right;
  animation-name: cd-enter-right;
}
.cd-horizontal-timeline .events-content li.enter-left, .cd-horizontal-timeline .events-content li.leave-left {
  -webkit-animation-name: cd-enter-left;
  -moz-animation-name: cd-enter-left;
  animation-name: cd-enter-left;
}
.cd-horizontal-timeline .events-content li.leave-right, .cd-horizontal-timeline .events-content li.leave-left {
  -webkit-animation-direction: reverse;
  -moz-animation-direction: reverse;
  animation-direction: reverse;
}
.cd-horizontal-timeline .events-content li > * {
  max-width: 800px;
  margin: 0 auto;
}
.cd-horizontal-timeline .events-content h2 {
  font-weight: bold;
  font-size: 2.6rem;
  font-family: "Playfair Display", serif;
  font-weight: 700;
  line-height: 1.2;
}
.cd-horizontal-timeline .events-content em {
  display: block;
  font-style: italic;
  margin: 10px auto;
}
.cd-horizontal-timeline .events-content em::before {
  content: '- ';
}
.cd-horizontal-timeline .events-content p {
  font-size: 1.4rem;
  color: #959595;
}
.cd-horizontal-timeline .events-content em, .cd-horizontal-timeline .events-content p {
  line-height: 1.6;
}
@media only screen and (min-width: 768px) {
  .cd-horizontal-timeline .events-content h2 {
    font-size: 7rem;
  }
  .cd-horizontal-timeline .events-content em {
    font-size: 2rem;
  }
  .cd-horizontal-timeline .events-content p {
    font-size: 1.8rem;
  }
}

 /*
 
		'#f06292' =>',
		'#acab44' =>''
*/

  </style>


</body>

<script src="timelinehorizjs/util.js"></script> <!-- util functions included in the CodyHouse framework -->
  <script src="timelinehorizjs/swipe-content.js"></script> <!-- A Vanilla JavaScript plugin to detect touch interactions -->
  
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
  <link rel="stylesheet" href="plugins/sweetalert2/sweetalert2.min.css">
  <script src="plugins/chart.js/Chart.min.js"></script>

<script type="text/javascript">
 
var container = document.getElementById('visualization');
var timeline = new vis.Timeline(container);

// recuperamos el querystring
const querystring = window.location.search
console.log(querystring) // '?q=pisos+en+barcelona&ciudad=Barcelona'

// usando el querystring, creamos un objeto del tipo URLSearchParams
const params = new URLSearchParams(querystring)


//prueba 

//finpruena

   
	$( document ).ready(function() {
		
		//Inicio mostrar hora live
   
     //console.log('idrun:'+params.get('idrun'));

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

        timeline_rutimes(   );

       


 //iniio
 var timelines = $('.cd-horizontal-timeline'),
		eventsMinDistance = 60;

	(timelines.length > 0) && initTimeline(timelines);

	function initTimeline(timelines) {
		timelines.each(function(){
			var timeline = $(this),
				timelineComponents = {};
			//cache timeline components 
			timelineComponents['timelineWrapper'] = timeline.find('.events-wrapper');
			timelineComponents['eventsWrapper'] = timelineComponents['timelineWrapper'].children('.events');
			timelineComponents['fillingLine'] = timelineComponents['eventsWrapper'].children('.filling-line');
			timelineComponents['timelineEvents'] = timelineComponents['eventsWrapper'].find('a');
			timelineComponents['timelineDates'] = parseDate(timelineComponents['timelineEvents']);
			timelineComponents['eventsMinLapse'] = minLapse(timelineComponents['timelineDates']);
			timelineComponents['timelineNavigation'] = timeline.find('.cd-timeline-navigation');
			timelineComponents['eventsContent'] = timeline.children('.events-content');

			//assign a left postion to the single events along the timeline
			setDatePosition(timelineComponents, eventsMinDistance);
			//assign a width to the timeline
			var timelineTotWidth = setTimelineWidth(timelineComponents, eventsMinDistance);
			//the timeline has been initialize - show it
			timeline.addClass('loaded');

			//detect click on the next arrow
			timelineComponents['timelineNavigation'].on('click', '.next', function(event){
				event.preventDefault();
				updateSlide(timelineComponents, timelineTotWidth, 'next');
			});
			//detect click on the prev arrow
			timelineComponents['timelineNavigation'].on('click', '.prev', function(event){
				event.preventDefault();
				updateSlide(timelineComponents, timelineTotWidth, 'prev');
			});
			//detect click on the a single event - show new event content
			timelineComponents['eventsWrapper'].on('click', 'a', function(event){
				event.preventDefault();
				timelineComponents['timelineEvents'].removeClass('selected');
				$(this).addClass('selected');
				updateOlderEvents($(this));
				updateFilling($(this), timelineComponents['fillingLine'], timelineTotWidth);
				updateVisibleContent($(this), timelineComponents['eventsContent']);
			});

			//on swipe, show next/prev event content
			timelineComponents['eventsContent'].on('swipeleft', function(){
				var mq = checkMQ();
				( mq == 'mobile' ) && showNewContent(timelineComponents, timelineTotWidth, 'next');
			});
			timelineComponents['eventsContent'].on('swiperight', function(){
				var mq = checkMQ();
				( mq == 'mobile' ) && showNewContent(timelineComponents, timelineTotWidth, 'prev');
			});

			//keyboard navigation
			$(document).keyup(function(event){
				if(event.which=='37' && elementInViewport(timeline.get(0)) ) {
					showNewContent(timelineComponents, timelineTotWidth, 'prev');
				} else if( event.which=='39' && elementInViewport(timeline.get(0))) {
					showNewContent(timelineComponents, timelineTotWidth, 'next');
				}
			});
		});
	}

	function updateSlide(timelineComponents, timelineTotWidth, string) {
		//retrieve translateX value of timelineComponents['eventsWrapper']
		var translateValue = getTranslateValue(timelineComponents['eventsWrapper']),
			wrapperWidth = Number(timelineComponents['timelineWrapper'].css('width').replace('px', ''));
		//translate the timeline to the left('next')/right('prev') 
		(string == 'next') 
			? translateTimeline(timelineComponents, translateValue - wrapperWidth + eventsMinDistance, wrapperWidth - timelineTotWidth)
			: translateTimeline(timelineComponents, translateValue + wrapperWidth - eventsMinDistance);
	}

	function showNewContent(timelineComponents, timelineTotWidth, string) {
		//go from one event to the next/previous one
		var visibleContent =  timelineComponents['eventsContent'].find('.selected'),
			newContent = ( string == 'next' ) ? visibleContent.next() : visibleContent.prev();

		if ( newContent.length > 0 ) { //if there's a next/prev event - show it
			var selectedDate = timelineComponents['eventsWrapper'].find('.selected'),
				newEvent = ( string == 'next' ) ? selectedDate.parent('li').next('li').children('a') : selectedDate.parent('li').prev('li').children('a');
			
			updateFilling(newEvent, timelineComponents['fillingLine'], timelineTotWidth);
			updateVisibleContent(newEvent, timelineComponents['eventsContent']);
			newEvent.addClass('selected');
			selectedDate.removeClass('selected');
			updateOlderEvents(newEvent);
			updateTimelinePosition(string, newEvent, timelineComponents, timelineTotWidth);
		}
	}

	function updateTimelinePosition(string, event, timelineComponents, timelineTotWidth) {
		//translate timeline to the left/right according to the position of the selected event
		var eventStyle = window.getComputedStyle(event.get(0), null),
			eventLeft = Number(eventStyle.getPropertyValue("left").replace('px', '')),
			timelineWidth = Number(timelineComponents['timelineWrapper'].css('width').replace('px', '')),
			timelineTotWidth = Number(timelineComponents['eventsWrapper'].css('width').replace('px', ''));
		var timelineTranslate = getTranslateValue(timelineComponents['eventsWrapper']);

        if( (string == 'next' && eventLeft > timelineWidth - timelineTranslate) || (string == 'prev' && eventLeft < - timelineTranslate) ) {
        	translateTimeline(timelineComponents, - eventLeft + timelineWidth/2, timelineWidth - timelineTotWidth);
        }
	}

	function translateTimeline(timelineComponents, value, totWidth) {
		var eventsWrapper = timelineComponents['eventsWrapper'].get(0);
		value = (value > 0) ? 0 : value; //only negative translate value
		value = ( !(typeof totWidth === 'undefined') &&  value < totWidth ) ? totWidth : value; //do not translate more than timeline width
		setTransformValue(eventsWrapper, 'translateX', value+'px');
		//update navigation arrows visibility
		(value == 0 ) ? timelineComponents['timelineNavigation'].find('.prev').addClass('inactive') : timelineComponents['timelineNavigation'].find('.prev').removeClass('inactive');
		(value == totWidth ) ? timelineComponents['timelineNavigation'].find('.next').addClass('inactive') : timelineComponents['timelineNavigation'].find('.next').removeClass('inactive');
	}

	function updateFilling(selectedEvent, filling, totWidth) {
		//change .filling-line length according to the selected event
		var eventStyle = window.getComputedStyle(selectedEvent.get(0), null),
			eventLeft = eventStyle.getPropertyValue("left"),
			eventWidth = eventStyle.getPropertyValue("width");
		eventLeft = Number(eventLeft.replace('px', '')) + Number(eventWidth.replace('px', ''))/2;
		var scaleValue = eventLeft/totWidth;
		setTransformValue(filling.get(0), 'scaleX', scaleValue);
	}

	function setDatePosition(timelineComponents, min) {
		for (i = 0; i < timelineComponents['timelineDates'].length; i++) { 
		    var distance = daydiff(timelineComponents['timelineDates'][0], timelineComponents['timelineDates'][i]),
		    	distanceNorm = Math.round(distance/timelineComponents['eventsMinLapse']) + 2;
		    timelineComponents['timelineEvents'].eq(i).css('left', distanceNorm*min+'px');
		}
	}

	function setTimelineWidth(timelineComponents, width) {
		var timeSpan = daydiff(timelineComponents['timelineDates'][0], timelineComponents['timelineDates'][timelineComponents['timelineDates'].length-1]),
			timeSpanNorm = timeSpan/timelineComponents['eventsMinLapse'],
			timeSpanNorm = Math.round(timeSpanNorm) + 4,
			totalWidth = timeSpanNorm*width;
		timelineComponents['eventsWrapper'].css('width', totalWidth+'px');
		updateFilling(timelineComponents['timelineEvents'].eq(0), timelineComponents['fillingLine'], totalWidth);
	
		return totalWidth;
	}

	function updateVisibleContent(event, eventsContent) {
		var eventDate = event.data('date'),
			visibleContent = eventsContent.find('.selected'),
			selectedContent = eventsContent.find('[data-date="'+ eventDate +'"]'),
			selectedContentHeight = selectedContent.height();

		if (selectedContent.index() > visibleContent.index()) {
			var classEnetering = 'selected enter-right',
				classLeaving = 'leave-left';
		} else {
			var classEnetering = 'selected enter-left',
				classLeaving = 'leave-right';
		}

		selectedContent.attr('class', classEnetering);
		visibleContent.attr('class', classLeaving).one('webkitAnimationEnd oanimationend msAnimationEnd animationend', function(){
			visibleContent.removeClass('leave-right leave-left');
			selectedContent.removeClass('enter-left enter-right');
		});
		eventsContent.css('height', selectedContentHeight+'px');
	}

	function updateOlderEvents(event) {
		event.parent('li').prevAll('li').children('a').addClass('older-event').end().end().nextAll('li').children('a').removeClass('older-event');
	}

	function getTranslateValue(timeline) {
		var timelineStyle = window.getComputedStyle(timeline.get(0), null),
			timelineTranslate = timelineStyle.getPropertyValue("-webkit-transform") ||
         		timelineStyle.getPropertyValue("-moz-transform") ||
         		timelineStyle.getPropertyValue("-ms-transform") ||
         		timelineStyle.getPropertyValue("-o-transform") ||
         		timelineStyle.getPropertyValue("transform");

        if( timelineTranslate.indexOf('(') >=0 ) {
        	var timelineTranslate = timelineTranslate.split('(')[1];
    		timelineTranslate = timelineTranslate.split(')')[0];
    		timelineTranslate = timelineTranslate.split(',');
    		var translateValue = timelineTranslate[4];
        } else {
        	var translateValue = 0;
        }

        return Number(translateValue);
	}

	function setTransformValue(element, property, value) {
		element.style["-webkit-transform"] = property+"("+value+")";
		element.style["-moz-transform"] = property+"("+value+")";
		element.style["-ms-transform"] = property+"("+value+")";
		element.style["-o-transform"] = property+"("+value+")";
		element.style["transform"] = property+"("+value+")";
	}

	//based on http://stackoverflow.com/questions/542938/how-do-i-get-the-number-of-days-between-two-dates-in-javascript
	function parseDate(events) {
		var dateArrays = [];
		events.each(function(){
			var dateComp = $(this).data('date').split('/'),
				newDate = new Date(dateComp[2], dateComp[1]-1, dateComp[0]);
			dateArrays.push(newDate);
		});
	    return dateArrays;
	}

	function parseDate2(events) {
		var dateArrays = [];
		events.each(function(){
			var singleDate = $(this),
				dateComp = singleDate.data('date').split('T');
			if( dateComp.length > 1 ) { //both DD/MM/YEAR and time are provided
				var dayComp = dateComp[0].split('/'),
					timeComp = dateComp[1].split(':');
			} else if( dateComp[0].indexOf(':') >=0 ) { //only time is provide
				var dayComp = ["2000", "0", "0"],
					timeComp = dateComp[0].split(':');
			} else { //only DD/MM/YEAR
				var dayComp = dateComp[0].split('/'),
					timeComp = ["0", "0"];
			}
			var	newDate = new Date(dayComp[2], dayComp[1]-1, dayComp[0], timeComp[0], timeComp[1]);
			dateArrays.push(newDate);
		});
	    return dateArrays;
	}

	function daydiff(first, second) {
	    return Math.round((second-first));
	}

	function minLapse(dates) {
		//determine the minimum distance among events
		var dateDistances = [];
		for (i = 1; i < dates.length; i++) { 
		    var distance = daydiff(dates[i-1], dates[i]);
		    dateDistances.push(distance);
		}
		return Math.min.apply(null, dateDistances);
	}

	/*
		How to tell if a DOM element is visible in the current viewport?
		http://stackoverflow.com/questions/123999/how-to-tell-if-a-dom-element-is-visible-in-the-current-viewport
	*/
	function elementInViewport(el) {
		var top = el.offsetTop;
		var left = el.offsetLeft;
		var width = el.offsetWidth;
		var height = el.offsetHeight;

		while(el.offsetParent) {
		    el = el.offsetParent;
		    top += el.offsetTop;
		    left += el.offsetLeft;
		}

		return (
		    top < (window.pageYOffset + window.innerHeight) &&
		    left < (window.pageXOffset + window.innerWidth) &&
		    (top + height) > window.pageYOffset &&
		    (left + width) > window.pageXOffset
		);
	}

	function checkMQ() {
		//check if mobile or desktop device
		return window.getComputedStyle(document.querySelector('.cd-horizontal-timeline'), '::before').getPropertyValue('content').replace(/'/g, "").replace(/"/g, "");
	}
/// fin
       
	});
	

	// controlar inactividad en la web	
		$(document).inactivityTimeout({
                inactivityWait: 10000,
                dialogWait: 10,
                logoutUrl: 'logout.php'
            })
	// fin controlar inactividad en la web		
	
	 /* requesting data */

  function timeline_rutimes()
  {
       ///Agregamos el timeline 1.

       // create visualization
 



var options = {
// option groupOrder can be a property name or a sort function
// the sort function must compare two groups and return a value
//     > 0 when a > b
//     < 0 when a < b
//       0 when a == b
groupOrder: function (a, b) {
  return a.value - b.value;
},
groupOrderSwap: function (a, b, groups) {
  var v = a.value;
  a.value = b.value;
  b.value = v;
},
groupTemplate: function(group){
  var container = document.createElement('div');
  var label = document.createElement('span');
  label.innerHTML = group.content + ' ';
  container.insertAdjacentElement('afterBegin',label);
  var hide = document.createElement('button');
  hide.innerHTML = 'hide';
  hide.style.fontSize = 'small';
  hide.addEventListener('click',function(){
    groups.update({id: group.id, visible: false});
  });
//  container.insertAdjacentElement('beforeEnd',hide);
  return container;
},
orientation: 'both',
editable: false,
groupEditable: false,
start: new Date(Date.UTC(2021, 05, 21, 11, 44, 0)),
end: new Date(Date.UTC(2021, 05, 21, 15, 0, 0)),
locale : 'en',
zoomKey:'ctrlKey',
maxHeight:'500px',
minHeight:'500px'
};

        
       var items = new vis.DataSet();
        var groups = new vis.DataSet();
 

      $.ajax
        ({ 
          url: 'ajax_timelinejsonautotestbox.php?idruninfo='+params.get('idr'),
          data: "idlog=",	
          type: 'post',
          async:true,
          cache:false,
          success: function(data)
          {
          ////  console.log(data);

          $('#msjwaitline ').hide();

            var datax =  data.items;
            var losgroupx =data.grupos;
          //			console.log(datax);
          //     console.log(losgroupx);
            items.add(datax);
            groups.clear();
            groups.add( losgroupx) ;

            timeline.setOptions(options);
  timeline.setGroups(groups);
  timeline.setItems(items);
  //console.log('mostrar -1');

  
  timeline.fit('linear');
 
  //console.log('mostrar -1a');
  setTimeout('buscarycentrartimeline()', 1000);

            document.getElementById('visualization').onclick = function (event)
              {
                var props = timeline.getEventProperties(event)
                console.log(props);
                console.log(props.item);
                      if(props.item != null && props.item != '') {
                        saludame(props.item);
                    // do something
                  }
                
              }
              

    
  
          }
        });

 
  

  // function to make all groups visible again
  function showAllGroups(){
    groups.forEach(function(group){
      groups.update({id: group.id, visible: true});
    })
  };
 


        ////fin test 2
       //
     
      // $("#visualization").removeClass('d-none');
       
    
  }   
  
  function sumArray(a, b) {
      var c = [];
      for (var i = 0; i < Math.max(a.length, b.length); i++) {
        c.push( parseFloat(a[i] || 0) + parseFloat(b[i] || 0));
      }
      return c;
}

  function buscarycentrartimeline()
{
  armar_graficos_eq();
  timeline.fit('linear');
  timeline.focus(75);
 // console.log('aca marc');    
  timeline.fit('linear');
}
 
 
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

  function saludame(nombtr)
  {
    //alert('a' + nombtr);/
    //eModal.iframe('labelprintermultisn.php?vciu='+1+'&vsn='+1+'&vidord='+1,'Label printing');

    Swal.fire({
  title: '<strong>HTML <u>example</u></strong>',
  icon: 'info',
  html:
    'You can use <b>bold text</b>, ' +
    '<a href="//sweetalert2.github.io">links</a> ' +
    'and other HTML tags',
  showCloseButton: true,
  showCancelButton: true,
  focusConfirm: false,
  confirmButtonText:
    '<i class="fa fa-thumbs-up"></i> Great!',
  confirmButtonAriaLabel: 'Thumbs up, great!',
  cancelButtonText:
    '<i class="fa fa-thumbs-down"></i>',
  cancelButtonAriaLabel: 'Thumbs down'
})

  }       
		
  function armar_graficos_eq()
  {
 /// console.log('aca ver'+params.get('idrun'));

    var salesChartOptions = {
    maintainAspectRatio : false,
    responsive : true,	
    legend: {
      display: true
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


  
        $.ajax
        ({ 
          url: 'ajax_graph_eq.php?idruninfo='+params.get('idr'),
          data: "idruninfo="+params.get('idr'),	
          type: 'post',
          async:true,
          cache:false,
          success: function(data)
          {
        //    console.log(data.iduniqueop_band_0_uldl_0_tx);
          
              ///console.log(JSON.parse( data.label_tx ));
              //var keyssmm = Object.keys(datax);
              ///console.log(keyssmm);
              
//echo(json_encode(["label_tx_calib"=>$label_tx_calib,"iduniqueop_band_0_uldl_0_tx_calib"=>$iduniqueop_band_0_uldl_0_tx_calib,  "iduniqueop_band_0_uldl_1_tx_calib"=>$iduniqueop_band_0_uldl_1_tx_calib,"iduniqueop_band_1_uldl_0_tx_calib"=>$iduniqueop_band_1_uldl_0_tx_calib,  "iduniqueop_band_1_uldl_1_tx_calib"=>$iduniqueop_band_1_uldl_1_tx,"iduniqueop_band_0_uldl_0_rx_calib"=>$iduniqueop_band_0_uldl_0_rx_calib,  "iduniqueop_band_0_uldl_1_rx_calib"=>$iduniqueop_band_0_uldl_1_rx_calib,"iduniqueop_band_1_uldl_0_rx_calib"=>$iduniqueop_band_1_uldl_0_rx_calib,  "iduniqueop_band_1_uldl_1_rx_calib"=>$iduniqueop_band_1_uldl_1_rx,"iduniqueop_band_0_uldl_0_rx"=>$iduniqueop_band_0_uldl_0_rx,  "iduniqueop_band_0_uldl_1_rx"=>$iduniqueop_band_0_uldl_1_rx,"iduniqueop_band_1_uldl_0_rx"=>$iduniqueop_band_1_uldl_0_rx,  "iduniqueop_band_1_uldl_1_rx"=>$iduniqueop_band_1_uldl_1_rx_check ]));
            
                        var grafico700uptotal00 = $('#grafico700uptotal00').get(0).getContext('2d');
                        var grafico700uprx00 = $('#grafico700uprx00').get(0).getContext('2d'); 
                        var grafico700uptx00 = $('#grafico700uptx00').get(0).getContext('2d'); 

                        var grafico700uptotal01 = $('#grafico700uptotal01').get(0).getContext('2d');
                        var grafico700uprx01 = $('#grafico700uprx01').get(0).getContext('2d'); 
                        var grafico700uptx01= $('#grafico700uptx01').get(0).getContext('2d');

                         

                        var grafico800uptotal10 = $('#grafico800uptotal10').get(0).getContext('2d');
                        var grafico800uprx10 = $('#grafico800uprx10').get(0).getContext('2d'); 
                        var grafico800uptx10 = $('#grafico800uptx10').get(0).getContext('2d'); 
                            
                        var grafico800uptotal11 = $('#grafico800uptotal11').get(0).getContext('2d');
                        var grafico800uprx11 = $('#grafico800uprx11').get(0).getContext('2d'); 
                        var grafico800uptx11 = $('#grafico800uptx11').get(0).getContext('2d');  

            console.log('graf_tx_0_0:'+ graf_tx_0_0);
            
            if(data.iduniqueop_band_1_uldl_0_tx_calib != null && data.iduniqueop_band_1_uldl_0_tx_calib != '') 
            {
              iduniqueop_band_0_uldl_0_tx_calib= data.iduniqueop_band_0_uldl_0_tx_calib.split(",");  
              label_tx_calib_0_0= data.label_tx_calib_0_0.split(",");  
              graf_tx_0_0="Y";
            } 
            if(data.iduniqueop_band_0_uldl_1_tx_calib != null && data.iduniqueop_band_0_uldl_1_tx_calib != '') 
            {
              iduniqueop_band_0_uldl_1_tx_calib = data.iduniqueop_band_0_uldl_1_tx_calib.split(",");  
              label_tx_calib_0_1= data.label_tx_calib_0_1.split(",");  
              graf_tx_0_1="Y";
            } 
            if(data.iduniqueop_band_1_uldl_0_tx_calib != null && data.iduniqueop_band_1_uldl_0_tx_calib != '') 
            {
              iduniqueop_band_1_uldl_0_tx_calib = data.iduniqueop_band_1_uldl_0_tx_calib.split(",");   
              label_tx_calib_1_0= data.label_tx_calib_1_0.split(",");  
              graf_tx_1_0="Y";
            } 
            if(data.iduniqueop_band_1_uldl_1_tx_calib != null && data.iduniqueop_band_1_uldl_1_tx_calib != '') 
            {
              iduniqueop_band_1_uldl_1_tx_calib = data.iduniqueop_band_1_uldl_1_tx_calib.split(","); 
              label_tx_calib_1_1= data.label_tx_calib_1_1.split(",");   
              graf_tx_1_1="Y";
            }

            iduniqueop_band_0_uldl_0_rx_calib= data.iduniqueop_band_0_uldl_0_rx_calib.split(",");  
            label_tx_calib_1_1= data.label_tx_calib_1_1.split(","); 

            iduniqueop_band_0_uldl_1_rx_calib = data.iduniqueop_band_0_uldl_1_rx_calib.split(",");  
            label_tx_calib_1_1= data.label_tx_calib_1_1.split(","); 

            iduniqueop_band_1_uldl_0_rx_calib = data.iduniqueop_band_1_uldl_0_rx_calib.split(",");  
            label_tx_calib_1_1= data.label_tx_calib_1_1.split(","); 

            iduniqueop_band_1_uldl_1_rx_calib = data.iduniqueop_band_1_uldl_1_rx_calib.split(","); 
            label_tx_calib_1_1= data.label_tx_calib_1_1.split(",");  

            iduniqueop_band_0_uldl_0_rx_check= data.iduniqueop_band_0_uldl_0_rx_check.split(",");  
            label_tx_calib_1_1= data.label_tx_calib_1_1.split(","); 

            iduniqueop_band_0_uldl_1_rx_check = data.iduniqueop_band_0_uldl_1_rx_check.split(",");  
            label_tx_calib_1_1= data.label_tx_calib_1_1.split(","); 

            iduniqueop_band_1_uldl_0_rx_check = data.iduniqueop_band_0_uldl_0_rx_check.split(",");  
            label_tx_calib_1_1= data.label_tx_calib_1_1.split(","); 

            iduniqueop_band_1_uldl_1_rx_check = data.iduniqueop_band_1_uldl_1_rx_check.split(","); 
            label_tx_calib_1_1= data.label_tx_calib_1_1.split(","); 


            iduniqueop_band_0_uldl_0_tx_check= data.iduniqueop_band_0_uldl_0_tx_check.split(",");  
            label_tx_calib_1_1= data.label_tx_calib_1_1.split(","); 

            iduniqueop_band_0_uldl_1_tx_check = data.iduniqueop_band_0_uldl_1_tx_check.split(",");  
            label_tx_calib_1_1= data.label_tx_calib_1_1.split(","); 

            iduniqueop_band_1_uldl_0_tx_check = data.iduniqueop_band_1_uldl_0_tx_check.split(",");  
            label_tx_calib_1_1= data.label_tx_calib_1_1.split(","); 

            iduniqueop_band_1_uldl_1_tx_check = data.iduniqueop_band_1_uldl_1_tx_check.split(",");  
            label_tx_calib_1_1= data.label_tx_calib_1_1.split(",");  

            console.log(iduniqueop_band_0_uldl_0_tx_calib);
            console.log(iduniqueop_band_0_uldl_0_rx_calib);
            console.log( label_tx );
         
         /////////////////////////// band 0 y uldl = 0 /////////////////////////////////////////////
            if (graf_tx_0_0=='Y')
            {
              var grafico700uptx_datos_0_0_calib = {
                            labels  :  label_tx_calib_0_0,
                            datasets: [
                            {
                                label               : 'Equalized',
                                backgroundColor     : 'rgba(60,141,188,0.3)',
                                borderColor         : 'rgba(60,141,188,1)',
                                pointRadius          : false,
                                pointColor          : '#3b8bba',
                                pointStrokeColor    : 'rgba(60,141,188,1)',
                                pointHighlightFill  : '#fff',
                                pointHighlightStroke: 'rgba(60,141,188,1)',
                              data                :  iduniqueop_band_0_uldl_0_tx_check                                
                              },
                            {
                                label               : 'Not Equalized',		
                              backgroundColor     : 'rgba(255, 99, 132, 0.5)',
                                borderColor         : 'rgba(255, 99, 132, 1)',
                                pointRadius         : false,
                                pointColor          : 'rgba(255, 99, 132, 1)',
                                pointStrokeColor    : '#c1c7d1',
                                pointHighlightFill  : '#fff',
                                pointHighlightStroke: 'rgba(255, 99, 132, 1)',		
                              data          :  iduniqueop_band_0_uldl_0_tx_calib  
                              },
                            ]
                          };

                          var grafico700uprx_datos_0_0_check = {
                            labels  :  label_tx_calib_0_0,
                            datasets: [
                            {
                                label               : 'Equalized',
                                backgroundColor     : 'rgba(60,141,188,0.3)',
                                borderColor         : 'rgba(60,141,188,1)',
                                pointRadius          : false,
                                pointColor          : '#3b8bba',
                                pointStrokeColor    : 'rgba(60,141,188,1)',
                                pointHighlightFill  : '#fff',
                                pointHighlightStroke: 'rgba(60,141,188,1)',
                              data                :  iduniqueop_band_0_uldl_0_rx_check
                                
                              },
                            {
                                label               : 'Not Equalized',		
                              backgroundColor     : 'rgba(255, 99, 132, 0.5)',
                                borderColor         : 'rgba(255, 99, 132, 1)',
                                pointRadius         : false,
                                pointColor          : 'rgba(255, 99, 132, 1)',
                                pointStrokeColor    : '#c1c7d1',
                                pointHighlightFill  : '#fff',
                                pointHighlightStroke: 'rgba(255, 99, 132, 1)',		
                              data          : iduniqueop_band_0_uldl_0_rx_calib
                              },
                            ]
                          };
                          
                          iduniqueop_band_0_uldl_0_tx_check_total = sumArray(iduniqueop_band_0_uldl_0_tx_check,iduniqueop_band_0_uldl_0_rx_check);
                          iduniqueop_band_0_uldl_0_rx_check_total  = sumArray(iduniqueop_band_0_uldl_0_tx_calib,iduniqueop_band_0_uldl_0_rx_calib);
                        //  console.log('sumArray');
                        //  console.log(iduniqueop_band_0_uldl_0_tx_check_total);

                          var grafico700uprx_datos_0_0_total = {
                            labels  :  label_tx_calib_0_0,
                            datasets: [
                            {
                                label               : 'Equalized',
                                backgroundColor     : 'rgba(60,141,188,0.3)',
                                borderColor         : 'rgba(60,141,188,1)',
                                pointRadius          : false,
                                pointColor          : '#3b8bba',
                                pointStrokeColor    : 'rgba(60,141,188,1)',
                                pointHighlightFill  : '#fff',
                                pointHighlightStroke: 'rgba(60,141,188,1)',
                              data                :  iduniqueop_band_0_uldl_0_tx_check_total
                                
                              },
                            {
                                label               : 'Not Equalized',		
                              backgroundColor     : 'rgba(255, 99, 132, 0.5)',
                                borderColor         : 'rgba(255, 99, 132, 1)',
                                pointRadius         : false,
                                pointColor          : 'rgba(255, 99, 132, 1)',
                                pointStrokeColor    : '#c1c7d1',
                                pointHighlightFill  : '#fff',
                                pointHighlightStroke: 'rgba(255, 99, 132, 1)',		
                              data          : iduniqueop_band_0_uldl_0_rx_check_total 
                              },
                            ]
                          };

                          var armograf_grafico700uptx00 = new Chart(grafico700uptx00, { 
                          type: 'line', 	
                          data: grafico700uptx_datos_0_0_calib, 	 
                          options: salesChartOptions
                        });

                        var armograf_grafico700uprx = new Chart(grafico700uprx00, { 
                          type: 'line', 	
                          data: grafico700uprx_datos_0_0_check, 	 
                          options: salesChartOptions
                        });

                        var armograf_grafico700uptotal = new Chart(grafico700uptotal00, { 
                            type: 'line', 	
                            data: grafico700uprx_datos_0_0_total, 	 
                            options: salesChartOptions
                          });
            }
                          

                      
              /////////////////////////// band 0 y uldl = 0 /////////////////////////////////////////////  
               /////////////////////////// band 0 y uldl = 1 /////////////////////////////////////////////
               if (graf_tx_0_1 =='Y')
              {    
                   var grafico700uprx_datos_0_1_calib = {
                            labels  :  label_tx_calib_0_1,
                            datasets: [
                            {
                                label               : 'Equalized',
                                backgroundColor     : 'rgba(60,141,188,0.3)',
                                borderColor         : 'rgba(60,141,188,1)',
                                pointRadius          : false,
                                pointColor          : '#3b8bba',
                                pointStrokeColor    : 'rgba(60,141,188,1)',
                                pointHighlightFill  : '#fff',
                                pointHighlightStroke: 'rgba(60,141,188,1)',
                              data                :  iduniqueop_band_0_uldl_1_tx_check                                
                              },
                            {
                                label               : 'Not Equalized',		
                              backgroundColor     : 'rgba(255, 99, 132, 0.5)',
                                borderColor         : 'rgba(255, 99, 132, 1)',
                                pointRadius         : false,
                                pointColor          : 'rgba(255, 99, 132, 1)',
                                pointStrokeColor    : '#c1c7d1',
                                pointHighlightFill  : '#fff',
                                pointHighlightStroke: 'rgba(255, 99, 132, 1)',		
                              data          : iduniqueop_band_0_uldl_1_tx_calib
                              },
                            ]
                          };
                       
                          var grafico700uptx_datos_0_1_check = {
                            labels  :  label_tx_calib_0_1,
                            datasets: [
                            {
                                label               : 'Equalized',
                                backgroundColor     : 'rgba(60,141,188,0.3)',
                                borderColor         : 'rgba(60,141,188,1)',
                                pointRadius          : false,
                                pointColor          : '#3b8bba',
                                pointStrokeColor    : 'rgba(60,141,188,1)',
                                pointHighlightFill  : '#fff',
                                pointHighlightStroke: 'rgba(60,141,188,1)',
                              data                :  iduniqueop_band_0_uldl_1_tx_check
                                
                              },
                            {
                                label               : 'Not Equalized',		
                              backgroundColor     : 'rgba(255, 99, 132, 0.5)',
                                borderColor         : 'rgba(255, 99, 132, 1)',
                                pointRadius         : false,
                                pointColor          : 'rgba(255, 99, 132, 1)',
                                pointStrokeColor    : '#c1c7d1',
                                pointHighlightFill  : '#fff',
                                pointHighlightStroke: 'rgba(255, 99, 132, 1)',		
                              data          : iduniqueop_band_0_uldl_1_tx_calib
                              },
                            ]
                          };

                          iduniqueop_band_0_uldl_1_tx_check_total = sumArray(iduniqueop_band_0_uldl_1_tx_check,iduniqueop_band_0_uldl_1_rx_check);
                          iduniqueop_band_0_uldl_1_rx_check_total  = sumArray(iduniqueop_band_0_uldl_1_tx_calib,iduniqueop_band_0_uldl_1_rx_calib);
                        //  console.log('sumArray');
                        //  console.log(iduniqueop_band_0_uldl_0_tx_check_total);

                          var grafico700uprx_datos_0_1_total = {
                            labels  :  label_tx_calib_0_1,
                            datasets: [
                            {
                                label               : 'Equalized',
                                backgroundColor     : 'rgba(60,141,188,0.3)',
                                borderColor         : 'rgba(60,141,188,1)',
                                pointRadius          : false,
                                pointColor          : '#3b8bba',
                                pointStrokeColor    : 'rgba(60,141,188,1)',
                                pointHighlightFill  : '#fff',
                                pointHighlightStroke: 'rgba(60,141,188,1)',
                              data                :  iduniqueop_band_0_uldl_1_tx_check_total
                                
                              },
                            {
                                label               : 'Not Equalized',		
                              backgroundColor     : 'rgba(255, 99, 132, 0.5)',
                                borderColor         : 'rgba(255, 99, 132, 1)',
                                pointRadius         : false,
                                pointColor          : 'rgba(255, 99, 132, 1)',
                                pointStrokeColor    : '#c1c7d1',
                                pointHighlightFill  : '#fff',
                                pointHighlightStroke: 'rgba(255, 99, 132, 1)',		
                              data          : iduniqueop_band_0_uldl_1_rx_check_total 
                              },
                            ]
                          };

                          var armograf_grafico700uptx01 = new Chart(grafico700uptx01, { 
                          type: 'line', 	
                          data: grafico700uptx_datos_0_1_check, 	 
                          options: salesChartOptions
                        });

                        var armograf_grafico700dwrx01 = new Chart(grafico700uprx01, { 
                          type: 'line', 	
                          data: grafico700uprx_datos_0_1_calib,                           	 
                          options: salesChartOptions
                        });

                        var armograf_grafico700dwrx01 = new Chart(grafico700uptotal01, { 
                          type: 'line', 	
                          data: grafico700uprx_datos_0_1_total, 	 
                          options: salesChartOptions
                        });
                        


              }
              /////////////////////////// band 0 y uldl = 1 /////////////////////////////////////////////   
                /////////////////////////// band 1 y uldl = 0 /////////////////////////////////////////////
                if (graf_tx_1_0 =='Y')
                {      
                          var grafico800uptx_datos_1_0_calib = {
                            labels  :  label_tx_calib_1_0,
                            datasets: [
                            {
                                label               : 'Equalized',
                                backgroundColor     : 'rgba(60,141,188,0.3)',
                                borderColor         : 'rgba(60,141,188,1)',
                                pointRadius          : false,
                                pointColor          : '#3b8bba',
                                pointStrokeColor    : 'rgba(60,141,188,1)',
                                pointHighlightFill  : '#fff',
                                pointHighlightStroke: 'rgba(60,141,188,1)',
                              data                :  iduniqueop_band_1_uldl_0_tx_check                                
                              },
                            {
                                label               : 'Not Equalized',		
                              backgroundColor     : 'rgba(255, 99, 132, 0.5)',
                                borderColor         : 'rgba(255, 99, 132, 1)',
                                pointRadius         : false,
                                pointColor          : 'rgba(255, 99, 132, 1)',
                                pointStrokeColor    : '#c1c7d1',
                                pointHighlightFill  : '#fff',
                                pointHighlightStroke: 'rgba(255, 99, 132, 1)',		
                              data          : iduniqueop_band_1_uldl_0_tx_calib
                              },
                            ]
                          };


                          var grafico800uptx_datos_1_0_check = {
                            labels  :  label_tx_calib_1_0,
                            datasets: [
                            {
                                label               : 'Equalized',
                                backgroundColor     : 'rgba(60,141,188,0.3)',
                                borderColor         : 'rgba(60,141,188,1)',
                                pointRadius          : false,
                                pointColor          : '#3b8bba',
                                pointStrokeColor    : 'rgba(60,141,188,1)',
                                pointHighlightFill  : '#fff',
                                pointHighlightStroke: 'rgba(60,141,188,1)',
                              data                :  iduniqueop_band_1_uldl_0_tx_check
                                
                              },
                            {
                                label               : 'Not Equalized',		
                              backgroundColor     : 'rgba(255, 99, 132, 0.5)',
                                borderColor         : 'rgba(255, 99, 132, 1)',
                                pointRadius         : false,
                                pointColor          : 'rgba(255, 99, 132, 1)',
                                pointStrokeColor    : '#c1c7d1',
                                pointHighlightFill  : '#fff',
                                pointHighlightStroke: 'rgba(255, 99, 132, 1)',		
                              data          : iduniqueop_band_1_uldl_0_tx_calib
                              },
                            ]
                          };

                          iduniqueop_band_1_uldl_0_tx_check_total = sumArray(iduniqueop_band_1_uldl_0_tx_check,iduniqueop_band_1_uldl_0_rx_check);
                          iduniqueop_band_1_uldl_0_rx_check_total  = sumArray(iduniqueop_band_1_uldl_0_tx_calib,iduniqueop_band_1_uldl_0_rx_calib);

                          var grafico800uprx_datos_1_0_total = {
                            labels  :  label_tx_calib_1_0,
                            datasets: [
                            {
                                label               : 'Equalized',
                                backgroundColor     : 'rgba(60,141,188,0.3)',
                                borderColor         : 'rgba(60,141,188,1)',
                                pointRadius          : false,
                                pointColor          : '#3b8bba',
                                pointStrokeColor    : 'rgba(60,141,188,1)',
                                pointHighlightFill  : '#fff',
                                pointHighlightStroke: 'rgba(60,141,188,1)',
                              data                :  iduniqueop_band_1_uldl_0_tx_check_total
                                
                              },
                            {
                                label               : 'Not Equalized',		
                              backgroundColor     : 'rgba(255, 99, 132, 0.5)',
                                borderColor         : 'rgba(255, 99, 132, 1)',
                                pointRadius         : false,
                                pointColor          : 'rgba(255, 99, 132, 1)',
                                pointStrokeColor    : '#c1c7d1',
                                pointHighlightFill  : '#fff',
                                pointHighlightStroke: 'rgba(255, 99, 132, 1)',		
                              data          : iduniqueop_band_1_uldl_0_rx_check_total 
                              },
                            ]
                          };

                          var armograf_grafico800uptx10 = new Chart(grafico800uptx10, { 
                          type: 'line', 	
                          data: grafico800uptx_datos_1_0_calib, 	 
                          options: salesChartOptions
                        });

                        var armograf_grafico800dwrx10 = new Chart(grafico800uprx10, { 
                          type: 'line', 	
                          data: grafico800uptx_datos_1_0_check,                           	 
                          options: salesChartOptions
                        });

                        var armograf_grafico800dwrx10 = new Chart(grafico800uptotal10, { 
                          type: 'line', 	
                          data: grafico800uprx_datos_1_0_total, 	 
                          options: salesChartOptions
                        });

                 }
                 /////////////////////////// band 1 y uldl = 0 /////////////////////////////////////////////                
                 /////////////////////////// band 1 y uldl = 1 /////////////////////////////////////////////                

                          if (graf_tx_1_1 =='Y')
                    { 
                          var grafico800uptx_datos_1_1_check = {
                            labels  :  label_tx_calib_1_0 ,
                            datasets: [
                            {
                                label               : 'Equalized',
                                backgroundColor     : 'rgba(60,141,188,0.3)',
                                borderColor         : 'rgba(60,141,188,1)',
                                pointRadius          : false,
                                pointColor          : '#3b8bba',
                                pointStrokeColor    : 'rgba(60,141,188,1)',
                                pointHighlightFill  : '#fff',
                                pointHighlightStroke: 'rgba(60,141,188,1)',
                              data                :  iduniqueop_band_1_uldl_1_tx_check
                                
                              },
                            {
                                label               : 'Not Equalized',		
                              backgroundColor     : 'rgba(255, 99, 132, 0.5)',
                                borderColor         : 'rgba(255, 99, 132, 1)',
                                pointRadius         : false,
                                pointColor          : 'rgba(255, 99, 132, 1)',
                                pointStrokeColor    : '#c1c7d1',
                                pointHighlightFill  : '#fff',
                                pointHighlightStroke: 'rgba(255, 99, 132, 1)',		
                              data          : iduniqueop_band_1_uldl_1_tx_calib
                              },
                            ]
                          };

                          //99
                          var grafico800uptx_datos_1_1_check = {
                            labels  :  label_tx_calib_1_0,
                            datasets: [
                            {
                                label               : 'Equalized',
                                backgroundColor     : 'rgba(60,141,188,0.3)',
                                borderColor         : 'rgba(60,141,188,1)',
                                pointRadius          : false,
                                pointColor          : '#3b8bba',
                                pointStrokeColor    : 'rgba(60,141,188,1)',
                                pointHighlightFill  : '#fff',
                                pointHighlightStroke: 'rgba(60,141,188,1)',
                              data                :  iduniqueop_band_1_uldl_1_tx_check
                                
                              },
                            {
                                label               : 'Not Equalized',		
                              backgroundColor     : 'rgba(255, 99, 132, 0.5)',
                                borderColor         : 'rgba(255, 99, 132, 1)',
                                pointRadius         : false,
                                pointColor          : 'rgba(255, 99, 132, 1)',
                                pointStrokeColor    : '#c1c7d1',
                                pointHighlightFill  : '#fff',
                                pointHighlightStroke: 'rgba(255, 99, 132, 1)',		
                              data          : iduniqueop_band_1_uldl_1_tx_calib
                              },
                            ]
                          };

                          iduniqueop_band_1_uldl_1_tx_check_total = sumArray(iduniqueop_band_1_uldl_1_tx_check,iduniqueop_band_1_uldl_1_rx_check);
                          iduniqueop_band_1_uldl_1_rx_check_total  = sumArray(iduniqueop_band_1_uldl_1_tx_calib,iduniqueop_band_1_uldl_1_rx_calib);

                          var grafico800uprx_datos_1_1_total = {
                            labels  :  label_tx_calib_1_0,
                            datasets: [
                            {
                                label               : 'Equalized',
                                backgroundColor     : 'rgba(60,141,188,0.3)',
                                borderColor         : 'rgba(60,141,188,1)',
                                pointRadius          : false,
                                pointColor          : '#3b8bba',
                                pointStrokeColor    : 'rgba(60,141,188,1)',
                                pointHighlightFill  : '#fff',
                                pointHighlightStroke: 'rgba(60,141,188,1)',
                              data                :  iduniqueop_band_1_uldl_1_tx_check_total
                                
                              },
                            {
                                label               : 'Not Equalized',		
                              backgroundColor     : 'rgba(255, 99, 132, 0.5)',
                                borderColor         : 'rgba(255, 99, 132, 1)',
                                pointRadius         : false,
                                pointColor          : 'rgba(255, 99, 132, 1)',
                                pointStrokeColor    : '#c1c7d1',
                                pointHighlightFill  : '#fff',
                                pointHighlightStroke: 'rgba(255, 99, 132, 1)',		
                              data          : iduniqueop_band_1_uldl_1_rx_check_total 
                              },
                            ]
                          };

                          var armograf_grafico800uptx11 = new Chart(grafico800uptx11, { 
                          type: 'line', 	
                          data: grafico800uptx_datos_1_1_check, 	 
                          options: salesChartOptions
                        });

                        var armograf_grafico800dwrx11 = new Chart(grafico800uprx11, { 
                          type: 'line', 	
                          data: grafico800uptx_datos_1_1_check,                           	 
                          options: salesChartOptions
                        });

                        var armograf_grafico800dwrx11 = new Chart(grafico800uptotal11, { 
                          type: 'line', 	
                          data: grafico800uprx_datos_1_1_total, 	 
                          options: salesChartOptions
                        });

                    }
              /////////////////////////// band 1 y uldl = 1 /////////////////////////////////////////////                

 
                      
          }
        });


     
  // console.log(armograf_grafico700uptotal.data.labels);
   // armograf_grafico700uptotal.data.labels.length = 0;
   // armograf_grafico700uptotal.data.datasets.length = 0;  
 
   //armograf_grafico700uptotal.data.labels.push(label_tx);
    

  }
   
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
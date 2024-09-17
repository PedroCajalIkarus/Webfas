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
  <div class="container-fluid">
  <hr>
  <b>Band 0 - UpLink</b>

  <h6>
  <?php
  	$sqlmm="
    select distinct branchname as script,    fas_times_type.timename, fas_tree_measure.datetime as datetimelog , (fas_tree_measure.datetime+ max(fas_times.duration)::time) as datetimelogresta ,
  userruninfo, station, device, runinfodb.idruninfo ,
  bandnuevo, listroutime.uldl, fas_tree_measure.iduniquebranch , max(fas_times.duration) as durationmm
  
  
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
  on listroutime.iduniquebranch =  fas_tree_measure.iduniquebranch and
  listroutime.bandnuevo =  fas_tree_measure.band and
  listroutime.uldl =  fas_tree_measure.uldl 
  
  inner join runinfodb
  on runinfodb.idruninfodb = fas_tree_measure.idrununfo
  inner join fas_times
  on fas_times.iduniqueop   = fas_tree_measure.iduniqueop 
  and fas_times.idsinglemeasure is null 
  and fas_times.idsameasures is null
  and fas_times.iducmeasure is null
  
  inner join fas_times_type
  on fas_times_type.idtimetype = fas_times.idtimetype
  where idrununfo = 10901032323   and bandnuevo= 0 and  listroutime.uldl=0
  group by branchname ,  fas_times_type.timename,	userruninfo, station, device, runinfodb.idruninfo  ,bandnuevo, listroutime.uldl, fas_tree_measure.iduniquebranch,fas_tree_measure.datetime
  order by bandnuevo, uldl  , datetimelog desc, script 
    
    ";
    $datalineality = $connect->query($sqlmm)->fetchAll();
   
  
    $usu="";
    $cantusarios=0;
    $cantitem=1;
    foreach ($datalineality as $row) 
    {
      $mystring = $row['script'];
$findme   = 'FinalCheck';
$pos = strpos($mystring, $findme);
if ($pos === false) 
  {
    ?>
    <span class="badge bg-warning"><?php echo  $cantitem." - ".$row['script']."  Duration: <i class='far fa-clock'></i> ".$row['durationmm'];?><br> </span>
    <?php
  }
  else
  {
    ?>
    <span class="badge bg-info"><?php echo  $cantitem." - ".$row['script']."  Duration: <i class='far fa-clock'></i> ".$row['durationmm'];?><br> </span>
    <?php
  }


$cantitem = $cantitem +1;
    }
  ?>
  </h6>
  </div>
 
  <div class="container-fluid">
 
  <b>Band 0 - Downlink</b>

  <h6>
  <?php
  	$sqlmm="
    select distinct branchname as script,    fas_times_type.timename, fas_tree_measure.datetime as datetimelog , (fas_tree_measure.datetime+ max(fas_times.duration)::time) as datetimelogresta ,
  userruninfo, station, device, runinfodb.idruninfo ,
  bandnuevo, listroutime.uldl, fas_tree_measure.iduniquebranch , max(fas_times.duration) as durationmm
  
  
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
  on listroutime.iduniquebranch =  fas_tree_measure.iduniquebranch and
  listroutime.bandnuevo =  fas_tree_measure.band and
  listroutime.uldl =  fas_tree_measure.uldl 
  
  inner join runinfodb
  on runinfodb.idruninfodb = fas_tree_measure.idrununfo
  inner join fas_times
  on fas_times.iduniqueop   = fas_tree_measure.iduniqueop 
  and fas_times.idsinglemeasure is null 
  and fas_times.idsameasures is null
  and fas_times.iducmeasure is null
  
  inner join fas_times_type
  on fas_times_type.idtimetype = fas_times.idtimetype
  where idrununfo = 10901032323   and bandnuevo= 0 and  listroutime.uldl=1
  group by branchname ,  fas_times_type.timename,	userruninfo, station, device, runinfodb.idruninfo  ,bandnuevo, listroutime.uldl, fas_tree_measure.iduniquebranch,fas_tree_measure.datetime
  order by bandnuevo, uldl  , datetimelog desc, script 
    
    ";
    $datalineality = $connect->query($sqlmm)->fetchAll();
   
  
    $usu="";
    $cantusarios=0;
    $cantitem=1;
    foreach ($datalineality as $row) 
    {
      $mystring = $row['script'];
$findme   = 'FinalCheck';
$pos = strpos($mystring, $findme);
if ($pos === false) 
  {
    ?>
    <span class="badge bg-warning"><?php echo  $cantitem." - ".$row['script']."  Duration: <i class='far fa-clock'></i> ".$row['durationmm'];?><br> </span>
    <?php
  }
  else
  {
    ?>
    <span class="badge bg-info"><?php echo  $cantitem." - ".$row['script']."  Duration: <i class='far fa-clock'></i> ".$row['durationmm'];?><br> </span>
    <?php
  }
$cantitem = $cantitem +1;
    }
  ?>
  </h6>
  </div>
  <hr>
  <div class="container-fluid">
 
 <b>Band 1 - UpLink</b>
 
 <?php
   $sqlmm="
   select distinct branchname as script,    fas_times_type.timename, fas_tree_measure.datetime as datetimelog , (fas_tree_measure.datetime+ max(fas_times.duration)::time) as datetimelogresta ,
 userruninfo, station, device, runinfodb.idruninfo ,
 bandnuevo, listroutime.uldl, fas_tree_measure.iduniquebranch , max(fas_times.duration) as durationmm
 
 
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
 on listroutime.iduniquebranch =  fas_tree_measure.iduniquebranch and
 listroutime.bandnuevo =  fas_tree_measure.band and
 listroutime.uldl =  fas_tree_measure.uldl 
 
 inner join runinfodb
 on runinfodb.idruninfodb = fas_tree_measure.idrununfo
 inner join fas_times
 on fas_times.iduniqueop   = fas_tree_measure.iduniqueop 
 and fas_times.idsinglemeasure is null 
 and fas_times.idsameasures is null
 and fas_times.iducmeasure is null
 
 inner join fas_times_type
 on fas_times_type.idtimetype = fas_times.idtimetype
 where idrununfo = 10901032323   and bandnuevo= 0 and  listroutime.uldl=1
 group by branchname ,  fas_times_type.timename,	userruninfo, station, device, runinfodb.idruninfo  ,bandnuevo, listroutime.uldl, fas_tree_measure.iduniquebranch,fas_tree_measure.datetime
 order by bandnuevo, uldl  , datetimelog desc, script 
   
   ";
   $datalineality = $connect->query($sqlmm)->fetchAll();
  
 
   $usu="";
   $cantusarios=0;
   $cantitem=1;
   $espacio="";
   foreach ($datalineality as $row) 
   {
     $mystring = $row['script'];
$findme   = 'FinalCheck';
$pos = strpos($mystring, $findme);
if ($pos === false) 
 {
 // echo $espacio;
   ?> 
     <a class=" " data-toggle="collapse" href="#multiCollapseExample<?php echo $cantitem; ?>" role="button" aria-expanded="false" aria-controls="multiCollapseExample<?php echo $cantitem; ?>">
   <span class="badge bg-warning"><?php echo  $cantitem." - ".$espacio.$row['script']."  Duration: <i class='far fa-clock'></i> ".$row['durationmm'];?></span> </a><br> 
   <div class="collapse multi-collapse" id="multiCollapseExample<?php echo $cantitem; ?>">
      <div class="card card-body">
        <?php echo $row['script']; ?>
      </div>
    </div>
  </div>

   <?php
 }
 else
 {
  // echo $espacio;
   ?>
   <span class="badge bg-info"><?php echo  $cantitem." - ".$espacio.$row['script']."  Duration: <i class='far fa-clock'></i> ".$row['durationmm'];?>  </span><br> 
   <?php
 }
$cantitem = $cantitem +1;
$espacio=$espacio."&nbsp;";
   }
 ?>
 
 </div>
 <hr>


<div id="visualization" name="visualization"   ></div>


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
  </style>


</body>
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
  <link rel="stylesheet" href="plugins/sweetalert2/sweetalert2.min.css">

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

        timeline_rutimes();

       
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
 


       var container = document.getElementById('visualization');
var timeline = new vis.Timeline(container);

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
          url: 'ajax_timelinejsonautotestbox.php',
          data: "idlog=",	
          type: 'post',
          async:true,
          cache:false,
          success: function(data)
          {
          ////  console.log(data);

        

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
  console.log('mostrar -1');
  timeline.fit('linear');

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
       console.log('mostrar-2');
    
  }   		

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
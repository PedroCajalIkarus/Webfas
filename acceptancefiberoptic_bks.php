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
		//	exit();
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
            <h1>Fiber Optic Acceptances</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Fiber Optic Acceptances</li>
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
          <section class="col-lg-6 connectedSortable ui-sortable">
		  
		  <?php
		  
		  
		   $sql = $connect->prepare("select * from business_station_userfas inner join business_station
on business_station.idbusiness = business_station_userfas.idbusiness and
business_station.idstation =  business_station_userfas.idstation where business_station_userfas.active = 'true' and  business_station_userfas.iduserfas = ".$_SESSION["a"]." and business_station_userfas.idbusiness = ".$_SESSION["i"]);
		   
		$sql->execute();
		$resultado_station = $sql->fetchAll();							
		$usuario_con_idstation = "N";
		
		foreach ($resultado_station as $rowstation) 
		{
			$usuario_con_idstation = "Y";
			$v_id_userfas = $_SESSION["a"];		
			$v_id_business = $_SESSION["i"];		
			$v_id_station = 7;	
			$v_namestation = "Station Fiplex Argentina (Leandro)";
			$v_namebusiness= $_SESSION["h"];
			

		}
	
		//datos de leandro de ejemplo
			$usuario_con_idstation = "Y";
			$usuario_con_idstation = "Y";
			$v_id_userfas = $_SESSION["a"];		
			$v_id_business = $_SESSION["i"];		
			$v_id_station = 7;	
			$v_namestation = "Station Fiplex Argentina (Leandro)";
			$v_namebusiness= $_SESSION["h"];
			 $v_fasclient_connect= "N";
		
		  ?>

            <div class="" name="divscrolllog" id="divscrolllog" style="display.">
			
				<div class="card">	
								<div class="card-header">
								
								<?php
								
								if ($usuario_con_idstation == "N")
								{
								?>
								<div class="callout callout-danger">
												  <p><i class='far fa-times-circle' style='font-size:24px'></i>&nbsp;&nbsp;<b>Attention, user without assigned station</b><br><br>
Please inform the administrator</p>
									</div>
								<?php
								}
								else
								{

								
								?>
									<button type="button" onclick="scan_device('<?php echo $v_id_business; ?>','<?php echo $v_id_station; ?>','<?php echo $v_id_userfas;?>')" class="btn btn-outline-info right-align">    <i class="fas fa-search"></i> Scan Device</button>									
										
									<div class="card-tools colorazulfiplex">
									<span name="msjwaitline" id="msjwaitline" align="center"><img src="img/waitazul.gif" width="40px" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
									<i class="fa fa-fw fa-tv"></i>&nbsp;<b>UserStation: <?php echo $v_namestation; ?> - <i class='fas fa-building'></i>  Business: <?php echo $v_namebusiness; ?></b>
									</div>
								<?php } ?>			
												
				
								</div>									
							   <div class="card-body form-row">	
									<div class="form-group col-md-3 ">
									<label for="exampleInputEmail1">Measure Interval: (min)</label>
									<input type="number" name="txtmeasuretime" id="txtmeasuretime" class="form-control" value=1 placeholder="Enter Measure Time (min)" required="" oninvalid="setCustomValidity('Measure Time is required.')" oninput="setCustomValidity('')">
									</div>
									<div class="form-group col-md-3 ">
									<label for="exampleInputEmail1">Script Duration: (min)</label>
									<input type="number" name="txtscripttime" id="txtscripttime" class="form-control" value=240 placeholder="Enter Script Time (Min)" required="" oninvalid="setCustomValidity('Script Time is required.')" oninput="setCustomValidity('')">
									</div>
									
									
									<div class="form-group col-md-6 ">
									
									<?php if( $v_fasclient_connect == 'N')
										{
									?>
									<div class="callout callout-danger">
												  <p><i class='far fa-times-circle' style='font-size:24px'></i><br><b>FasClient disconnected</b></p>
									</div>
									<?php } ?>
								    </div>
									
									
									
									<div class="form-group col-md-6  ">
									
									
											<div class="form-group col-xs-6 bordediv " >
											
											<label for="exampleInputEmail1" class="divconfondoazul">&nbsp;Device A:</label>
												<select class="form-control">
												<option value="">-Select-</option>
												</select>
												<hr>
												<div class="row">
													<div class="col-md-2 text-center texto10">
													SN 1:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" class="form-control form-control-sm texto10" placeholder="">
													</div>
													<div class="col-md-2 text-center texto10">
													SN 2:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" class="form-control form-control-sm texto10" placeholder="">
													</div>
												 </div><div class="row">
													<div class="col-md-2 text-center texto10">
													SN 3:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" class="form-control form-control-sm texto10" placeholder="">
													</div>
													<div class="col-md-2 text-center texto10">
													SN 4:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" class="form-control form-control-sm texto10" placeholder="">
													</div>
												 </div><div class="row">
													<div class="col-md-2 text-center texto10">
													SN 5:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" class="form-control form-control-sm texto10" placeholder="">
													</div>
													<div class="col-md-2 text-center texto10">
													SN 6:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" class="form-control form-control-sm texto10" placeholder="">
													</div>
												 </div><div class="row">
													<div class="col-md-2 text-center texto10">
													SN 7:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" class="form-control form-control-sm texto10" placeholder="">
													</div>
													<div class="col-md-2 text-center texto10">
													SN 8:													
													</div>	
													<div class="col-md-4 text-left texto10">
													<input type="text" class="form-control form-control-sm" placeholder="">
													</div>
												 </div>
												
												
											</div>
											<div class="form-group col-xs-6 bordedivb">
												<label for="exampleInputEmail1" class="divconfondoazul">&nbsp;Device C:</label>
												<select class="form-control">
													<option value="">-Select-</option>
												</select>
												<hr>
													<div class="row">
													<div class="col-md-2 text-center texto10">
													SN 1:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" class="form-control form-control-sm texto10" placeholder="">
													</div>
													<div class="col-md-2 text-center texto10">
													SN 2:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" class="form-control form-control-sm texto10" placeholder="">
													</div>
												 </div><div class="row">
													<div class="col-md-2 text-center texto10">
													SN 3:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" class="form-control form-control-sm texto10" placeholder="">
													</div>
													<div class="col-md-2 text-center texto10">
													SN 4:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" class="form-control form-control-sm texto10" placeholder="">
													</div>
												 </div><div class="row">
													<div class="col-md-2 text-center texto10">
													SN 5:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" class="form-control form-control-sm texto10" placeholder="">
													</div>
													<div class="col-md-2 text-center texto10">
													SN 6:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" class="form-control form-control-sm texto10" placeholder="">
													</div>
												 </div><div class="row">
													<div class="col-md-2 text-center texto10">
													SN 7:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" class="form-control form-control-sm texto10" placeholder="">
													</div>
													<div class="col-md-2 text-center texto10">
													SN 8:													
													</div>	
													<div class="col-md-4 text-left texto10">
													<input type="text" class="form-control form-control-sm" placeholder="">
													</div>
												 </div>
											</div>
									</div>
									
										<div class="form-group col-md-6 ">
										<div class="form-group col-xs-6  bordedivb">
											<label for="exampleInputEmail1" class="divconfondoazul">&nbsp;Device B:</label>
											<select class="form-control">
												<option value="">-Select-</option>
											</select>
											<hr>
												<div class="row">
													<div class="col-md-2 text-center texto10">
													SN 1:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" class="form-control form-control-sm texto10" placeholder="">
													</div>
													<div class="col-md-2 text-center texto10">
													SN 2:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" class="form-control form-control-sm texto10" placeholder="">
													</div>
												 </div><div class="row">
													<div class="col-md-2 text-center texto10">
													SN 3:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" class="form-control form-control-sm texto10" placeholder="">
													</div>
													<div class="col-md-2 text-center texto10">
													SN 4:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" class="form-control form-control-sm texto10" placeholder="">
													</div>
												 </div><div class="row">
													<div class="col-md-2 text-center texto10">
													SN 5:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" class="form-control form-control-sm texto10" placeholder="">
													</div>
													<div class="col-md-2 text-center texto10">
													SN 6:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" class="form-control form-control-sm texto10" placeholder="">
													</div>
												 </div><div class="row">
													<div class="col-md-2 text-center texto10">
													SN 7:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" class="form-control form-control-sm texto10" placeholder="">
													</div>
													<div class="col-md-2 text-center texto10">
													SN 8:													
													</div>	
													<div class="col-md-4 text-left texto10">
													<input type="text" class="form-control form-control-sm" placeholder="">
													</div>
												 </div>
										</div>
										<div class="form-group col-xs-6 bordediv">
											<label for="exampleInputEmail1" class="divconfondoazul">&nbsp;Device D:</label>
											<select class="form-control">
												<option value="">-Select-</option>
												
											</select>
											<hr>
												<div class="row">
													<div class="col-md-2 text-center texto10">
													SN 1:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" class="form-control form-control-sm texto10" placeholder="">
													</div>
													<div class="col-md-2 text-center texto10">
													SN 2:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" class="form-control form-control-sm texto10" placeholder="">
													</div>
												 </div><div class="row">
													<div class="col-md-2 text-center texto10">
													SN 3:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" class="form-control form-control-sm texto10" placeholder="">
													</div>
													<div class="col-md-2 text-center texto10">
													SN 4:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" class="form-control form-control-sm texto10" placeholder="">
													</div>
												 </div><div class="row">
													<div class="col-md-2 text-center texto10">
													SN 5:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" class="form-control form-control-sm texto10" placeholder="">
													</div>
													<div class="col-md-2 text-center texto10">
													SN 6:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" class="form-control form-control-sm texto10" placeholder="">
													</div>
												 </div><div class="row">
													<div class="col-md-2 text-center texto10">
													SN 7:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" class="form-control form-control-sm texto10" placeholder="">
													</div>
													<div class="col-md-2 text-center texto10">
													SN 8:													
													</div>	
													<div class="col-md-4 text-left texto10">
													<input type="text" class="form-control form-control-sm" placeholder="">
													</div>
												 </div>
										</div>
									</div>
									
										<div class="card-footer text-right form-group col-md-12 ">
							
								  
								  <button name="btnrun" id="btnrun" type="button" onclick="fnt_btn_run()" class="btn btn-outline-success right-align"> <i class="fas fa-play"></i> Run</button>
								  <button name="btnstop" id="btnstop" type="button" onclick="fnt_btn_stop()" class="btn btn-outline-danger right-align"> <i class="fas fa-times"></i> Cancel</button>
								  
								  
										</div>
								
									 </div>
								<!-- /.card-body -->
							
		
        
				
			</div>
			</div>
					

        </section>
		<section class="col-lg-6 connectedSortable ui-sortable">
		

				<div class="card">
				<div class="card-header ui-sortable-handle" style="cursor: move;">
               		
					
					<div class="callout callout-success">
					  <i class='fas fa-info'></i> <b>Running</b>
					</div>
					<div class="callout callout-warning">
					 <i class='fas fa-info'></i>  <b>waiting for results</b>
					</div>
					
				<div class="card">
              <div class="card-header">
                <h3 class="card-title"> <i class="fa fa-fw fa-list-alt"></i>Log Details :: </h3>
							<i class="fa fa-fw fa-user"></i> <label  name="lblvuser" id="lblvuser"> </label>
					
							<i class="fa fa-fw fa-inbox"></i> <label  name="lblvstationr" id="lblvstationr"> </label>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0" style="display: block;">
                <div class="d-md-flex">
                  <div class="p-1 flex-fill" >
                    <textarea class="form-control form-controltamanio" rows="18" id="detallelog" name="detallelog"></textarea>
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
			$("#msjwait").hide();	
			$('#msjwaitline ').hide();
			
			$("#btnrun").prop('disabled', true);
			$("#btnstop").prop('disabled', true);
			/*
			$('#divscrolllog').show(); 
			$('#p-b0').hide();
			$('#p-b0').CardWidget('toggle');		
			$("#detallelog").hide();
			$("#detallelog").text("");
				*/	

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
	
	var cant_veces_controlo = 0;
	var cant_veces_controlo_limit = 50;
	var req = new XMLHttpRequest();
	
	function get_result_fasclient(vv_p_idb, vv_p_ids, vv_p_idu) {
		return new Promise(function(resolve, reject) {
			
			
				var formData = new FormData();

			//consulta si devolvio el Scan Device
			formData.append("idb", vv_p_idb);
			formData.append("ids", vv_p_ids);
			formData.append("idu", vv_p_idu);
			formData.append("idaccionweb", 2);
			
			
			///req.open('GET', 'fasclient_query.php');
			req.open("POST", "fasclient_query.php");
			req.send(formData);
			
			req.onload = function() {
			  if (req.status == 200) {
					//console.log('aaaaaaaaaaaa'+ req.response) ;
					if ( req.response != 0)
					{
							///alert('s'+ req.response );
							
							var snjsron = JSON.parse(req.response);
							$.each(snjsron, function(i, item) {
							console.log(item);
							});
													
							// aca reject solo para cortar
							reject();
							
							$('#msjwaitline ').hide();
					}
					else
					{
						
						// setTimeout(get_result_fasclient(), 3000) ;
						 //setInterval(get_result_fasclient(),3000);
							if (cant_veces_controlo <= cant_veces_controlo_limit)
							{
								
							cant_veces_controlo = cant_veces_controlo + 1 ;
							
						 	setTimeout(function(){
								///console.log("status in a:" );
								///req.property = "value";
								 req.abort();
								//this should trigger calling a or not?
									get_result_fasclient(vv_p_idb, vv_p_ids, vv_p_idu);
									},2000);
									
							}	
							else
							{
								$('#msjwaitline ').hide();
								 req.abort();
								alert('server does not respond');
								reject();
									
							}
		
					}
					
					
				
			  }
			  else {
				reject();
			  }
			};

			req.send();
		})
	}
	
	function scan_device(vv_p_idb, vv_p_ids, vv_p_idu)
	{
		
		$("#btnrun").prop('disabled', true);
		$("#btnstop").prop('disabled', true);
		$('#msjwaitline ').show();
		////Insertamos el pedido de SCAN para el user, Station
			var formData = new FormData();

			formData.append("idb", vv_p_idb);
			formData.append("ids", vv_p_ids);
			formData.append("idu", vv_p_idu);
			formData.append("idaccionweb", 1);
			/// idaccionweb 1 - Inserto SCAN Device

			var xhr = new XMLHttpRequest();
			xhr.open("POST", "fasclient_query.php");
			xhr.send(formData);
			xhr.abort();
		///
		
		
		
		var promises = [			
			get_result_fasclient(vv_p_idb, vv_p_ids, vv_p_idu)
		];

		Promise.all(promises).then(results => {
			console.log('llenar combos');
			console.log(results);
		})

	}

	// controlar inactividad en la web	
		$(document).inactivityTimeout({
                inactivityWait: 10000,
                dialogWait: 10,
                logoutUrl: 'logout.php'
            })
	// fin controlar inactividad en la web		
	
	 /* requesting data */
     		
		
	  function get_device() {
    return new Promise(function(resolve, reject) {
    var req = new XMLHttpRequest();
        req.open('GET', 'https://jsonplaceholder.typicode.com/posts');

        req.onload = function() {
          if (req.status == 200) {
            resolve(JSON.parse(req.response));
          }
          else {
            reject();
          }
        };

        req.send();
    })
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
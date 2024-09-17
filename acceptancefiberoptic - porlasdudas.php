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
		if ($v_namestation =="")
		{
			$usuario_con_idstation = "Y";
			$usuario_con_idstation = "Y";
			$v_id_userfas = 2;	
			$v_id_business = $_SESSION["i"];		
			$v_id_station = 7;	
			$v_namestation = "Station Fiplex Argentina (Leandro)";
			$v_namebusiness= $_SESSION["h"];
			 $v_fasclient_connect= "N";
		}
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
									<button id="scandevice" name="scandevice" type="button" onclick="scan_device('<?php echo $v_id_business; ?>','<?php echo $v_id_station; ?>','<?php echo $v_id_userfas;?>')" class="btn btn-outline-info right-align">    <i class="fas fa-search"></i> Scan Device</button>									
										
									<div class="card-tools colorazulfiplex">
									<span name="msjwaitline" id="msjwaitline" align="center"><img src="img/waitazul.gif" width="40px" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
									<span name="msjwaitlineok" id="msjwaitlineok" align="center"><i class='far fa-check-circle' style='font-size:24px;color:green'></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
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
												<select class="form-control" name="devicea" id="devicea" onchange="control_uso('A')">
												<option value="">-Select-</option>
												</select>
												<hr>
												<div class="row">
													<div class="col-md-2 text-center texto10">
													SN 1:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" id="devicean1" name="devicean1" class="form-control form-control-sm texto10" placeholder="">
													</div>
													<div class="col-md-2 text-center texto10">
													SN 2:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" id="devicean2" name="devicean2" class="form-control form-control-sm texto10" placeholder="">
													</div>
												 </div><div class="row">
													<div class="col-md-2 text-center texto10">
													SN 3:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" id="devicean3" name="devicean3" class="form-control form-control-sm texto10" placeholder="">
													</div>
													<div class="col-md-2 text-center texto10">
													SN 4:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" id="devicean4" name="devicean4" class="form-control form-control-sm texto10" placeholder="">
													</div>
												 </div><div class="row">
													<div class="col-md-2 text-center texto10">
													SN 5:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" id="devicean5" name="devicean5" class="form-control form-control-sm texto10" placeholder="">
													</div>
													<div class="col-md-2 text-center texto10">
													SN 6:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" id="devicean6" name="devicean6" class="form-control form-control-sm texto10" placeholder="">
													</div>
												 </div><div class="row">
													<div class="col-md-2 text-center texto10">
													SN 7:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" id="devicean7" name="devicean7" class="form-control form-control-sm texto10" placeholder="">
													</div>
													<div class="col-md-2 text-center texto10">
													SN 8:													
													</div>	
													<div class="col-md-4 text-left texto10">
													<input type="text"  id="devicean8" name="devicean8" class="form-control form-control-sm" placeholder="">
													</div>
												 </div>
												
												
											</div>
											<div class="form-group col-xs-6 bordedivb">
												<label for="exampleInputEmail1" class="divconfondoazul">&nbsp;Device C:</label>
												<select class="form-control" name="devicec" id="devicec" onchange="control_uso('C')">
													<option value="">-Select-</option>
												</select>
												<hr>
													<div class="row">
													<div class="col-md-2 text-center texto10">
													SN 1:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" id="devicecn1" name="devicecn1" class="form-control form-control-sm texto10" placeholder="">
													</div>
													<div class="col-md-2 text-center texto10">
													SN 2:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" id="devicecn2" name="devicecn2" class="form-control form-control-sm texto10" placeholder="">
													</div>
												 </div><div class="row">
													<div class="col-md-2 text-center texto10">
													SN 3:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" id="devicecn3" name="devicecn3" class="form-control form-control-sm texto10" placeholder="">
													</div>
													<div class="col-md-2 text-center texto10">
													SN 4:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" id="devicecn4" name="devicecn4" class="form-control form-control-sm texto10" placeholder="">
													</div>
												 </div><div class="row">
													<div class="col-md-2 text-center texto10">
													SN 5:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" id="devicecn5" name="devicecn5" class="form-control form-control-sm texto10" placeholder="">
													</div>
													<div class="col-md-2 text-center texto10">
													SN 6:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" id="devicecn6" name="devicecn6" class="form-control form-control-sm texto10" placeholder="">
													</div>
												 </div><div class="row">
													<div class="col-md-2 text-center texto10">
													SN 7:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" id="devicecn7" name="devicecn7" class="form-control form-control-sm texto10" placeholder="">
													</div>
													<div class="col-md-2 text-center texto10">
													SN 8:													
													</div>	
													<div class="col-md-4 text-left texto10">
													<input type="text" id="devicecn8" name="devicecn8" class="form-control form-control-sm" placeholder="">
													</div>
												 </div>
											</div>
									</div>
									
										<div class="form-group col-md-6 ">
										<div class="form-group col-xs-6  bordedivb">
											<label for="exampleInputEmail1" class="divconfondoazul">&nbsp;Device B:</label>
											<select class="form-control" name="deviceb" id="deviceb" onchange="control_uso('B')">
												<option value="">-Select-</option>
											</select>
											<hr>
												<div class="row">
													<div class="col-md-2 text-center texto10">
													SN 1:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" id="devicebn1" name="devicebn1" class="form-control form-control-sm texto10" placeholder="">
													</div>
													<div class="col-md-2 text-center texto10">
													SN 2:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" id="devicebn2" name="devicebn2" class="form-control form-control-sm texto10" placeholder="">
													</div>
												 </div><div class="row">
													<div class="col-md-2 text-center texto10">
													SN 3:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" id="devicebn3" name="devicebn3" class="form-control form-control-sm texto10" placeholder="">
													</div>
													<div class="col-md-2 text-center texto10">
													SN 4:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" id="devicebn4" name="devicebn4" class="form-control form-control-sm texto10" placeholder="">
													</div>
												 </div><div class="row">
													<div class="col-md-2 text-center texto10">
													SN 5:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" id="devicebn5" name="devicebn5" class="form-control form-control-sm texto10" placeholder="">
													</div>
													<div class="col-md-2 text-center texto10">
													SN 6:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" id="devicebn6" name="devicebn6" class="form-control form-control-sm texto10" placeholder="">
													</div>
												 </div><div class="row">
													<div class="col-md-2 text-center texto10">
													SN 7:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" id="devicebn7" name="devicebn7" class="form-control form-control-sm texto10" placeholder="">
													</div>
													<div class="col-md-2 text-center texto10">
													SN 8:													
													</div>	
													<div class="col-md-4 text-left texto10">
													<input type="text" id="devicebn8" name="devicebn8" class="form-control form-control-sm" placeholder="">
													</div>
												 </div>
										</div>
										<div class="form-group col-xs-6 bordediv">
											<label for="exampleInputEmail1" class="divconfondoazul">&nbsp;Device D:</label>
											<select class="form-control" name="deviced" id="deviced" onchange="control_uso('D')">
												<option value="">-Select-</option>
												
											</select>
											<hr>
												<div class="row">
													<div class="col-md-2 text-center texto10">
													SN 1:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" id="devicedn1" name="devicedn1" class="form-control form-control-sm texto10" placeholder="">
													</div>
													<div class="col-md-2 text-center texto10">
													SN 2:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" id="devicedn2" name="devicedn2" class="form-control form-control-sm texto10" placeholder="">
													</div>
												 </div><div class="row">
													<div class="col-md-2 text-center texto10">
													SN 3:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" id="devicedn3" name="devicedn3" class="form-control form-control-sm texto10" placeholder="">
													</div>
													<div class="col-md-2 text-center texto10">
													SN 4:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" id="devicedn4" name="devicedn4" class="form-control form-control-sm texto10" placeholder="">
													</div>
												 </div><div class="row">
													<div class="col-md-2 text-center texto10">
													SN 5:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" id="devicedn5" name="devicedn5" class="form-control form-control-sm texto10" placeholder="">
													</div>
													<div class="col-md-2 text-center texto10">
													SN 6:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" id="devicedn6" name="devicedn6" class="form-control form-control-sm texto10" placeholder="">
													</div>
												 </div><div class="row">
													<div class="col-md-2 text-center texto10">
													SN 7:													
													</div>	
													<div class="col-md-4 text-left">
													<input type="text" id="devicedn7" name="devicedn7" class="form-control form-control-sm texto10" placeholder="">
													</div>
													<div class="col-md-2 text-center texto10">
													SN 8:													
													</div>	
													<div class="col-md-4 text-left texto10">
													<input type="text" id="devicedn8" name="devicedn8" class="form-control form-control-sm" placeholder="">
													</div>
												 </div>
										</div>
									</div>
									
										<div class="card-footer text-right form-group col-md-12 ">
							
										<select class="d-none" name="devicem" id="devicem">
												<option value="">-Select-</option>
											</select>
								  
								  <button name="btnrun" id="btnrun" type="button" onclick="fnt_btn_run('<?php echo $v_id_business; ?>','<?php echo $v_id_station; ?>','<?php echo $v_id_userfas;?>')" class="btn btn-outline-success right-align"> <i class="fas fa-play"></i> Run</button>
								  <button name="btnstop" id="btnstop" type="button" onclick="fnt_btn_stop('<?php echo $v_id_business; ?>','<?php echo $v_id_station; ?>','<?php echo $v_id_userfas;?>')" class="btn btn-outline-danger right-align"> <i class="fas fa-times"></i> Cancel</button>
								  <input type="hidden" value="" name="idpetitionrun" id="idpetitionrun">
								  
										</div>
								
									 </div>
								<!-- /.card-body -->
							
		
        
				
			</div>
			</div>
					

        </section>
		<section class="col-lg-6 connectedSortable ui-sortable">
		

				<div class="card">
				<div class="card-header ui-sortable-handle" style="cursor: move;">
               		
					
					<div class="callout callout-success d-none" name="iddivrun" id="iddivrun">
					  <i class='fas fa-info'></i> <b>Running</b>
					</div>
					
					
				<div class="card">
              <div class="card-header">
                <h3 class="card-title"> <i class="fa fa-fw fa-list-alt"></i>Log Details :: </h3>
						<i class="fa fa-fw fa-user"></i> <label  name="lblvuser" id="lblvuser"> </label>
							<i class="fa fa-fw fa-tv"></i> <label  name="lblvdevice" id="lblvdevice"> </label>
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

   
   var refreshIntervalId  =0;
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
			$('#msjwaitline').hide();
			$('#msjwaitlineok').hide();
			
			
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
	
	function fnt_btn_run(vv_p_idb, vv_p_ids, vv_p_idu) 
	{
		
			var v_devicea = $('#devicea').val();
			var v_deviceb = $('#deviceb').val();
			var v_devicec = $('#devicec').val();
			var v_deviced = $('#deviced').val();
			
			if ( v_devicea =='' && v_deviceb =='' && v_devicec =='' && v_deviced == ''  )
			{
				alert('You must select a device');
			}
			else
			{
				
				$("#scandevice").prop('disabled', true);
			
		var myObject = new Object();
		var lossnarray_todos = [];	
		var lossnarray_a = [];
		var lossnarray_b = [];
		var lossnarray_c = [];
		var lossnarray_d = [];

		myObject.measuretime = $('#txtmeasuretime').val();
		myObject.scripttime = $('#txtscripttime').val();

		var lossnarray = [];
		if (v_devicea != '')
		{
				lossnarray.push(v_devicea);
				
					lossnarray_a.push( $("#devicean1").val()==''?null:$("#devicean1").val() );
					lossnarray_a.push( $("#devicean2").val()==''?null:$("#devicean2").val() );
					lossnarray_a.push( $("#devicean3").val()==''?null:$("#devicean3").val() );
					lossnarray_a.push( $("#devicean4").val()==''?null:$("#devicean4").val() );
					lossnarray_a.push( $("#devicean5").val()==''?null:$("#devicean5").val() );
					lossnarray_a.push( $("#devicean6").val()==''?null:$("#devicean6").val() );
					lossnarray_a.push( $("#devicean7").val()==''?null:$("#devicean7").val() );
					lossnarray_a.push( $("#devicean5").val()==''?null:$("#devicean8").val() );
						lossnarray_todos.push(lossnarray_a);
		}
		if (v_deviceb != '')
		{
				lossnarray.push(v_deviceb);
				lossnarray_b.push( $("#devicebn1").val()==''?null:$("#devicebn1").val() );
				lossnarray_b.push( $("#devicebn2").val()==''?null:$("#devicebn2").val() );
				lossnarray_b.push( $("#devicebn3").val()==''?null:$("#devicebn3").val() );
				lossnarray_b.push( $("#devicebn4").val()==''?null:$("#devicebn4").val() );
				lossnarray_b.push( $("#devicebn5").val()==''?null:$("#devicebn5").val() );
				lossnarray_b.push( $("#devicebn6").val()==''?null:$("#devicebn6").val() );
				lossnarray_b.push( $("#devicebn7").val()==''?null:$("#devicebn7").val() );
				lossnarray_b.push( $("#devicebn8").val()==''?null:$("#devicebn8").val() );
				
				
		lossnarray_todos.push(lossnarray_b);  
		}
		if (v_devicec != '')
		{
				lossnarray.push(v_devicec);
				
				lossnarray_c.push( $("#devicecn1").val()==''?null:$("#devicecn1").val() );
				lossnarray_c.push( $("#devicecn2").val()==''?null':$("#devicecn2").val() );
				lossnarray_c.push( $("#devicecn3").val()==''?null:$("#devicecn3").val() );
				lossnarray_c.push( $("#devicecn4").val()==''?null:$("#devicecn4").val() );
				lossnarray_c.push( $("#devicecn5").val()==''?null:$("#devicecn5").val() );
				lossnarray_c.push( $("#devicecn6").val()==''?null:$("#devicecn6").val() );
				lossnarray_c.push( $("#devicecn7").val()==''?null:$("#devicecn7").val() );
				lossnarray_c.push( $("#devicecn8").val()==''?null:$("#devicecn8").val() );
				
		lossnarray_todos.push(lossnarray_c);
				
		}
		if (v_deviced != '')
		{
			lossnarray.push(v_deviced);
			
			lossnarray_d.push( $("#devicedn1").val()==''?null:$("#devicedn1").val() );
			lossnarray_d.push( $("#devicedn2").val()==''?null:$("#devicedn2").val() );
			lossnarray_d.push( $("#devicedn3").val()==''?null:$("#devicedn3").val() );
			lossnarray_d.push( $("#devicedn4").val()==''?null:$("#devicedn4").val() );
			lossnarray_d.push( $("#devicedn5").val()==''?null:$("#devicedn5").val() );
			lossnarray_d.push( $("#devicedn6").val()==''?null:$("#devicedn6").val() );
			lossnarray_d.push( $("#devicedn7").val()==''?null:$("#devicedn7").val() );
			lossnarray_d.push( $("#devicedn8").val()==''?null:$("#devicedn8").val() );
			lossnarray_todos.push(lossnarray_d);
		}

	
			}
	
		myObject.snsdib = lossnarray;
	
		myObject.sns = lossnarray_todos;

		var myString = JSON.stringify(myObject);
		console.log (myString);
		
		//Enviamos los datos a procesar
			 return new Promise(function(resolve, reject) {
					var formData = new FormData();
			var req = new XMLHttpRequest();
			//consulta si devolvio el Scan Device
			formData.append("idb", vv_p_idb);
			formData.append("ids", vv_p_ids);
			formData.append("idu", vv_p_idu);
			formData.append("pjson", myString);
			
			formData.append("idaccionweb", 3);
			
			
			///req.open('GET', 'fasclient_query.php');
			req.open("POST", "fasclient_query.php");
			req.send(formData);
			
			$("#iddivrun").removeClass('d-none');
			
			
				req.onload = function() {
				  if (req.status == 200) {
					//alert( req.response.substring(1, 2));
					//  if (  req.response.substring(1, 2) =="ok" )
					//  {
						 //   alert(req.response);
						 var losresultado = req.response.split("#");
							$('#idpetitionrun').val(losresultado[1].replace('"',''));
							//mostrar_log(req.response.substring(4, 12));
							mostrar_log(losresultado[2].replace('"',''));
					//  }
					resolve(JSON.parse(req.response));
					
				  }
				  else {
					reject();
				  }
				};

			
			})
		//fin enviar datos a procesar
				
				
				
			}
			
			
	}
	
	function mostrar_log(idlog)
	{
	 refreshIntervalId = setInterval(function() {
				// Código a ejecutar
					show_log2(idlog);
					}, 5000);
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
						
						$('#lblvstationr').html(datax.vstation.replace("#"," ") +' <a href="#" onclick="show_log('+anex	+')") ><i class="fas fa-bug" style="color:green"></i></a> -');
					
				}
			});
			
   }
   
   
		function fnt_btn_stop(vv_p_idb, vv_p_ids, vv_p_idu) 
		{
			 return new Promise(function(resolve, reject) {
					var formData = new FormData();
			var req = new XMLHttpRequest();
			
			$("#scandevice").prop('disabled', false);
			
			//consulta si devolvio el Scan Device
			formData.append("idb", vv_p_idb);
			formData.append("ids", vv_p_ids);
			formData.append("idu", vv_p_idu);
				var var_local_petition = $('#idpetitionrun').val();
				formData.append("idpp", var_local_petition);
		///	formData.append("pjson", vv_p_idu);
			
			formData.append("idaccionweb", 4);
			
			clearInterval(refreshIntervalId);
			//Stop Timer
			
			$("#iddivrun").addClass('d-none');
			///req.open('GET', 'fasclient_query.php');
			req.open("POST", "fasclient_query.php");
			req.send(formData);
			
				req.onload = function() {
				  if (req.status == 200) {
					resolve(JSON.parse(req.response));
				  }
				  else {
					reject();
				  }
				};

			
			})
		
		}
	
	function control_uso(tipodecombo)
	{
		var enuso='N';	
			//controlo
			var v_devicea = $('#devicea').val();
			var v_deviceb = $('#deviceb').val();
			var v_devicec = $('#deviced').val();
			var v_deviced = $('#deviced').val();
						
			//$("#deviceb option[value='"+$('#devicea').val()+"']").remove();
			if (tipodecombo =='A')
			{
				v_deviceb==''? 	$("#deviceb option[value='"+$('#devicea').val()+"']").remove():'';
				v_devicec==''? 	$("#devicec option[value='"+$('#devicea').val()+"']").remove():'';
				v_deviced==''? 	$("#deviced option[value='"+$('#devicea').val()+"']").remove():'';
			}
			if (tipodecombo =='B')
			{
				v_devicea==''? 	$("#devicea option[value='"+$('#deviceb').val()+"']").remove():'';
				v_devicec==''? 	$("#devicec option[value='"+$('#deviceb').val()+"']").remove():'';
				v_deviced==''? 	$("#deviced option[value='"+$('#deviceb').val()+"']").remove():'';
			}
			if (tipodecombo =='C')
			{
				v_devicea==''? 	$("#devicea option[value='"+$('#devicec').val()+"']").remove():'';
				v_deviceb==''? 	$("#deviceb option[value='"+$('#devicec').val()+"']").remove():'';
				v_deviced==''? 	$("#deviced option[value='"+$('#devicec').val()+"']").remove():'';
			}
			if (tipodecombo =='D')
			{
				v_devicea==''? 	$("#devicea option[value='"+$('#deviced').val()+"']").remove():'';
				v_deviceb==''? 	$("#deviceb option[value='"+$('#deviced').val()+"']").remove():'';
				v_devicec==''? 	$("#devicec option[value='"+$('#deviced').val()+"']").remove():'';
			}
				
			if (enuso !='N')
			{
				alert('SN in use');
				$("#devicea").focus();
			}	
			// ok armamos json para insertar.


/*
{
"measuretime":1,
"scripttime":3,
"snsdib":["21210000FU","21210001FU"],
"sns": [
		[
			  "1215FI1547743",
			  "13451111111FU",
			  "95135332714FU",
			  "14782345236FU",
			  "22245622222FU",
			  "25956537FN157",
			  "36148515FN745",
			  "45698345523FU"
			],
			[
			  "33376533333FU",
			  "951357484FN12",
			  "32185495FN745",
			  "20323424107FU",
			  "44444123444FU",
			  "754896FN12478",
			  "12365FN749584",
			  "95632532874FU"
			]
		  ]
}
*/			
			
		
	}
	

	function get_result_fasclient(vv_p_idb, vv_p_ids, vv_p_idu) {
		return new Promise(function(resolve, reject) {
			
			
				var formData = new FormData();
			var req = new XMLHttpRequest();
			var var_local_petition = $('#idpetitionrun').val();
			console.log('ver' + var_local_petition);
			//consulta si devolvio el Scan Device
			formData.append("idb", vv_p_idb);
			formData.append("ids", vv_p_ids);
			formData.append("idu", vv_p_idu);
			formData.append("idpp", var_local_petition);
			
			formData.append("idaccionweb", 2);
			
			
			
			///req.open('GET', 'fasclient_query.php');
			req.open("POST", "fasclient_query.php");
			req.send(formData);
			
			req.onload = function() {
			  if (req.status == 200) {
					//console.log('aaaaaaaaaaaa'+ req.response) ;
					if ( req.response != 0)
					{
							//alert('s'+ req.response );
							
							     //resolve(req.response);
								 resolve(JSON.parse(req.response));
							$('#msjwaitline').hide();
							
							$('#msjwaitlineok').show();
							setTimeout(function(){ $('#msjwaitlineok').hide(); }, 10000);
							
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
								
								//this should trigger calling a or not?
								//	get_result_fasclient(vv_p_idb, vv_p_ids, vv_p_idu);
									
										get_result_fasclient(vv_p_idb, vv_p_ids, vv_p_idu).then(results => {
			console.log('llenar combos 1');
			
			const lossnrecibidos = results;
		//	console.log(lossnrecibidos);
			var objmarc = JSON.parse(lossnrecibidos);
				
						$('#devicea').append('<option value=""> - select -</option>');
						$('#deviceb').append('<option value=""> - select -</option>');
						$('#devicec').append('<option value=""> - select -</option>');
						$('#deviced').append('<option value=""> - select -</option>');
						// para BKS
						$('#devicem').append('<option value=""> - select -</option>');
						
					for(var k in objmarc) {
						console.log('hola'+k +'cant:'+ objmarc[k]);
						
						$.each(objmarc[k], function (ind, elem) { 
					//  console.log('¡Hola :'+elem+'!'); 
						$('#devicea').append('<option value="'+elem+'">'+elem+'</option>');
						$('#deviceb').append('<option value="'+elem+'">'+elem+'</option>');
						$('#devicec').append('<option value="'+elem+'">'+elem+'</option>');
						$('#deviced').append('<option value="'+elem+'">'+elem+'</option>');
						// para BKS
						$('#devicem').append('<option value="'+elem+'">'+elem+'</option>');
						
						
						
					}); 
											
						$("#btnrun").prop('disabled', false);
					 $("#btnstop").prop('disabled', false);						
						
					}
			/*$.each(results, function(i, item) {
							console.log(item);
							});*/
							
		})
									
									
								
									},5000);
									
							}	
							else
							{
								$('#msjwaitline ').hide();
								
								
								alert('server does not respond');
								reject();
									
							}
		
					}
					
					
				
			  }
			  else {
				reject();
			  }
			};

		
		})
	}
	
	function scan_device(vv_p_idb, vv_p_ids, vv_p_idu)
	{
		
		$("#devicea").empty();
		$("#deviceb").empty();
		$("#devicec").empty();
		$("#deviced").empty();
		
		
			$("#scandevice").prop('disabled', true);
		$("#btnrun").prop('disabled', true);
		$("#btnrun").prop('disabled', true);
		$("#btnstop").prop('disabled', true);
		$('#msjwaitline').show();
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
			
				xhr.onload = function() {
				  if (xhr.status == 200) {
					  
					$('#idpetitionrun').val(xhr.response.substring(4, 12).replace('"',''));
					 	$("#scandevice").prop('disabled', false);
				
					
				  }
				 
				};



		
		///
		
		

		get_result_fasclient(vv_p_idb, vv_p_ids, vv_p_idu).then(results => {
			console.log('llenar combos');
			console.log(results);
			
			const lossnrecibidos = results;
		//	console.log(lossnrecibidos);
			var objmarc = JSON.parse(lossnrecibidos);
				
						$('#devicea').append('<option value=""> - select -</option>');
						$('#deviceb').append('<option value=""> - select -</option>');
						$('#devicec').append('<option value=""> - select -</option>');
						$('#deviced').append('<option value=""> - select -</option>');
						// para BKS
						$('#devicem').append('<option value=""> - select -</option>');
						
					for(var k in objmarc) {
						console.log('hola'+k +'cant:'+ objmarc[k]);
						
						$.each(objmarc[k], function (ind, elem) { 
					//  console.log('¡Hola :'+elem+'!'); 
						$('#devicea').append('<option value="'+elem+'">'+elem+'</option>');
						$('#deviceb').append('<option value="'+elem+'">'+elem+'</option>');
						$('#devicec').append('<option value="'+elem+'">'+elem+'</option>');
						$('#deviced').append('<option value="'+elem+'">'+elem+'</option>');
						// para BKS
						$('#devicem').append('<option value="'+elem+'">'+elem+'</option>');
						
						
						
					}); 
					}
											
						$("#btnrun").prop('disabled', false);
					 $("#btnstop").prop('disabled', false);		
							
		})
		
		/*var promises = [			
			get_result_fasclient(vv_p_idb, vv_p_ids, vv_p_idu)
		];

		Promise.all(promises).then(results => {
			console.log('llenar combos');
			console.log(results);
			
			$.each(results, function(i, item) {
							console.log(item);
							});
							
		})*/

	}

	// controlar inactividad en la web	
	/*	$(document).inactivityTimeout({
                inactivityWait: 10000,
                dialogWait: 10,
                logoutUrl: 'logout.php'
            })
			*/
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
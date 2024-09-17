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
            <h1>Burnin Test</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Burnin Test</li>
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
business_station.idstation =  business_station_userfas.idstation where business_station_userfas.active = 'true' and 
 business_station_userfas.iduserfas = ".$_SESSION["a"]." and business_station_userfas.idbusiness = ".$_SESSION["i"]);
		 
	 
		$sql->execute();
		$resultado_station = $sql->fetchAll();							
		$usuario_con_idstation = "N";
		
		foreach ($resultado_station as $rowstation) 
		{
			$usuario_con_idstation = "Y";
			$v_id_userfas = $_SESSION["a"];		
			$v_id_business = $_SESSION["i"];		
			$v_id_station = $rowstation["idstation"];		
			$v_namestation = $rowstation["namestation"];		
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
			$v_namestation = "Station Fiplex Argentina TESTINGGG ***** (Leandro- MARCO TEST)";
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
								<div class="callout callout-danger" >
												  <p><i class='far fa-times-circle' style='font-size:24px'></i>&nbsp;&nbsp;
												  <b>Attention, user without assigned station</b><br><br>
Please inform the administrator</p>
									</div>
								<?php
								}
								else
								{
									//controlamos si tenemos algo en ejecutcion
								/*	$respuestaidruninfo = 0;
									$respuesta  =0;
									 $sql2 = $connect->prepare("select idpetition as madidpp,  idruninfo from fas_petitions_server where petitiontype = 2 and status = 1 and iduserfrom = ".$v_id_userfas." ");
									$sql2->execute();
									$resultado_station = $sql2->fetchAll();				
									
										foreach ($resultado_station as $rowstation) 
										{
											$idpetitionresp =$rowstation['madidpp'];
											$respuestaidruninfo =$rowstation['idruninfo'];
										}
										if ($respuestaidruninfo !=0)
										{
											
										}
										else
										{*/
											?>
											<button id="scandevice" name="scandevice" type="button" onclick="scan_device('<?php echo $v_id_business; ?>','<?php echo $v_id_station; ?>','<?php echo $v_id_userfas;?>')" class="btn btn-outline-info right-align">    <i class="fas fa-search"></i> Scan Device</button>									
									
											<?php
									///	}
									?>
								
								
								
										
									<div class="card-tools colorazulfiplex">
									<span name="msjwaitline" id="msjwaitline" align="center"><img src="img/waitazul.gif" width="40px" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
									<span name="msjwaitlineok" id="msjwaitlineok" align="center"><i class='far fa-check-circle' style='font-size:24px;color:green'></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
									<i class="fa fa-fw fa-tv"></i>&nbsp;<b>UserStation: <?php echo $v_namestation; ?> - <i class='fas fa-building'></i>  Business: <?php echo $v_namebusiness; ?></b>
									</div>
								<?php } ?>			
												
				
								</div>									
							   <div class="card-body form-row">	
							   <div class="form-group col-md-6 ">
									<label for="exampleInputEmail1">Measure Interval: (min)</label>
									<input type="number" name="txtmeasuretime" id="txtmeasuretime" class="form-control" value=1 placeholder="Enter Measure Time (min)" required="" oninvalid="setCustomValidity('Measure Time is required.')" oninput="setCustomValidity('')">
									</div>
									<div class="form-group col-md-6 ">
									<label for="exampleInputEmail1">Script Duration: (min)</label>
									<input type="number" name="txtscripttime" id="txtscripttime" class="form-control" value=240 placeholder="Enter Script Time (Min)" required="" oninvalid="setCustomValidity('Script Time is required.')" oninput="setCustomValidity('')">
									</div>
								
								   <div class="form-group col-md-3 ">
									<label for="exampleInputEmail1">COM:</label>
										<select class="form-control" name="devicecoms" id="devicecoms"  onchange="loading_sn(this.value)">
											
												</select>
									</div>


								
									<div class="form-group col-md-3 ">
									<label for="exampleInputEmail1">CIU: </label>
									<input type="text" name="txtelciu" id="txtelciu" class="form-control" value="" placeholder="Enter CIU " required="" oninvalid="setCustomValidity('CIU is required.')" oninput="setCustomValidity('')">
									</div>
									<div class="form-group col-md-3 ">
									<label for="exampleInputEmail1">SN:</label>
									<input type="text" name="txtsnadd" id="txtsnadd" class="form-control" value="" placeholder="Enter SN" required="" oninvalid="setCustomValidity('SN is required.')" oninput="setCustomValidity('')">
									</div>
								


									<div class="form-group col-md-3 ">
									<label for="exampleInputEmail1" style="color:#ffffff"> . </label><br>
									<button name="btnrunadd" id="btnrunadd" type="button" onclick="addlist_to_run()" class="btn btn-outline-info right-align"> <i class="fas fa-play"></i> Add to List</button>
									</div>
									
									<div class="form-group col-md-12 "><br>
												
												<div class="col-sm-12" id="listagainuldl" name="listagainuldl">
												<table class="table table-striped table-sm ">
												<thead>
												<tr>
													<th style="width: 10px">#</th>
													<th>COMs </th>
													<th>CIU </th>
													<th>SN </th>
													<th style="width: 40px">Action</th>
												</tr>
												</thead>
												<tbody>
												</tbody>
												</table>
												</div>
									</div>
									<div class="form-group col-md-12 ">
										
									

									<?php if( $v_fasclient_connect == 'N')
										{
									?>
									<div class="callout callout-danger" id="diverror" name="diverror">
												  <p><i class='far fa-times-circle' style='font-size:24px'></i><br>
												  <span id="txterror" id="txterror"><b>FasClient disconnected</b></span></p>
									</div>
									<?php } 
									else
									{
										?>
											<div class="callout callout-danger d-none" id="diverror" name="diverror">
												  <p><i class='far fa-times-circle' style='font-size:24px'></i><br>
												  <span id="txterror" id="txterror"></span></p>
									</div>
										<?php
									}?>
								    </div>
									
									
									
									<div class="form-group col-md-12  ">
									
									
									
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
					  <i class='fas fa-info'></i> <b>Running</b><br>waiting for result ...
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
var tabla_json_tosend= [];
   
   var refreshIntervalId  =0;
   var refreshIntervalIdbuscaruninfo= 0;
	$( document ).ready(function() {
		
		//Inicio mostrar hora live
		 var interval = setInterval(function() {
			
        var momentNow = moment();
		var newYork    = momentNow.tz('America/New_York').format('ha z');
        $('#date-part').html(momentNow.format('YYYY/MM/DD') 	  );
        $('#time-part').html(momentNow.format('hh:mm:ss'));
		}, 100);
		//FIN mostrar hora live
	//		console.log( "ready!" );
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
	var cant_veces_controlo_limit = 15;

	function checkValueinarraysn(value,arr){
  var status = 'Not exist';
 
  for(var i=0; i<tabla_json_tosend.length; i++){
    var name = tabla_json_tosend[i].sn;
    if(name == value){
      status = 'Exist';
      break;
    }
  }
  return status;
}

  function checkValueinarraycoms(value,arr){
  var status = 'Not exist';
 
  for(var i=0; i<tabla_json_tosend.length; i++){
    var name = tabla_json_tosend[i].devicecoms;
    if(name == value){
      status = 'Exist';
      break;
    }
  }

  return status;
}
	
	function fnt_btn_run(vv_p_idb, vv_p_ids, vv_p_idu) 
	{
		var ejecutar_run ='yes';	
		$("#scandevice").prop('disabled', true);
			
			
		var myObject = new Object();
		var lossnarray_todos = [];	
		var lossnarray_a = [];
	

		myObject.measuretime = $('#txtmeasuretime').val();
		myObject.scripttime = $('#txtscripttime').val();

		var lossnarray = [];
		var losdevicearray = [];
		var losdevicearraycomall =[];
		//	lossnarray.push(v_devicea);				
			//lossnarray_a.push( $("#devicean1").val()==''?null:$("#devicean1").val() );
		//	lossnarray_todos.push(lossnarray_a);
			

		
		
		
			for( var i = 0; i < tabla_json_tosend.length; i++) {
			
			//	console.log (tabla_json_tosend[i]);
				lossnarray.push(tabla_json_tosend[i].sn);
				losdevicearray.push(tabla_json_tosend[i].ciu);
				losdevicearraycomall.push(tabla_json_tosend[i].devicecompleto);
			}

			myObject.sns = lossnarray;	
			myObject.cius = losdevicearray;
			myObject.comall = losdevicearraycomall;

			var myString = JSON.stringify(myObject);
			console.log (myString);

		if (ejecutar_run =='yes')
		{
			
			$("#btnrun").prop('disabled', true);
				// Código a ejecutar
					
				
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
			req.open("POST", "fasclient_queryberning.php");
			req.send(formData);
			
			$("#iddivrun").removeClass('d-none');
			
			
				req.onload = function() {
				  if (req.status == 200) {
					//alert( req.response.substring(1, 2));
					//  if (  req.response.substring(1, 2) =="ok" )
					//  {
						 //   alert(req.response);
						 var losresultado = req.response.split("#");
						// console.log('resultado del RUN:'+ req.response+'--'+losresultado[2]);
							$('#idpetitionrun').val(losresultado[1].replace('"',''));
							//mostrar_log(req.response.substring(4, 12));
							if (losresultado[2].replace('"','') !='')
							{
								mostrar_log(losresultado[2].replace('"',''), losresultado[1].replace('"',''));
							}
							else
							{
							//	console.log('no recibo idruninfo');
								esperar_runinfo(vv_p_idu, losresultado[1].replace('"','') );
							}
							
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
			//fin if control si ejecuto
				
				
			
			
			
	}
	
	function esperar_runinfo(pp_idusu,idppetiio )
	{
			 refreshIntervalIdbuscaruninfo = setInterval(function() {
				 
			//	 console.log('espero resultado del id_petition:'+$('#idpetitionrun').val());
				 
				 //Enviamos los datos a procesar
			 return new Promise(function(resolve, reject) {
					var formData = new FormData();
			var req = new XMLHttpRequest();
			//consulta si devolvio el Scan Device
			//formData.append("idb", vv_p_idb);
		//	formData.append("ids", vv_p_ids);
			formData.append("idu", pp_idusu);
			formData.append("idpp", idppetiio);			
			formData.append("idaccionweb", 5);
			
			$("#txterror").html('');
									$("#diverror").hide();
			
			req.open("POST", "fasclient_queryberning.php");
			req.send(formData);
			
			$("#iddivrun").removeClass('d-none');
			
			
				req.onload = function() {
				  if (req.status == 200) {
					//alert( req.response.substring(1, 2));
					//  if (  req.response.substring(1, 2) =="ok" )
					//  {
						 //   alert(req.response);
						 var losresultado = req.response.split("#");
					//	 console.log('desde esperando resultado del RUN:'+ req.response+'--'+losresultado[2]);
						///	$('#idpetitionrun').val(losresultado[1].replace('"',''));
							//mostrar_log(req.response.substring(4, 12));
							if (losresultado[2].replace('"','') !='')
							{
								mostrar_log(losresultado[2].replace('"',''),idppetiio );
								
								clearInterval(refreshIntervalIdbuscaruninfo);
								console.log('Result -> erro:'+ losresultado[3].replace('"',''));
								if ( losresultado[3].replace('"','') != '')
								{
									$("#diverror").show();
									$("#txterror").html(losresultado[3]);
										
										$("#scandevice").prop('disabled', false);
											$("#btnrun").prop('disabled', false);
										clearInterval(refreshIntervalId);
			
								}
								
								
							}
							else
							{
								console.log('not rec idruninfo,  wait');
								
							}
							
					//  }
					resolve(JSON.parse(req.response));
					
				  }
				  else {
					reject();
				  }
				};

			
			})
		//fin enviar datos a procesar
				 
				 
				 
			}, 15000);	
	}
	
	function mostrar_log(idlog, idpettparam)
	{
		// desactivo el boton
		//verelproceso
		$("#verelproceso").prop('disabled', true);
			$("#iddivrun").removeClass('d-none');
				refreshIntervalId = setInterval(function() {
				// Código a ejecutar
					show_log2(idlog,idpettparam);
					}, 10000);
	}
	
	 function show_log2(idlog_view, idpettparam)
   {
	 	   
	 	 	   
	 $("#detallelog").fadeOut('fast');  
	  $("#msjwait").fadeIn('slow');   
		
		// $("#uso").val(1);
	//	 console.log('a' + idlog_view +'#b'+ idpettparam);
			//buscar datoss
			$.ajax
			({ 
				url: 'readlogbyruninfofibra.php',
				data: "idlog="+idlog_view+'&idpett='+idpettparam,	
				type: 'post',
				async:true,
                cache:false,
				success: function(data)
				{
					var datax = JSON.parse(data)
				//	console.log(datax);
               //     console.log(datax.petitiostatus);
					if ( datax.petitiostatus ==2)
					{
						clearInterval(refreshIntervalIdbuscaruninfo);
						clearInterval(refreshIntervalId);
						$("#iddivrun").addClass('d-none');
							$("#msjwait").hide();
					 	$("#detallelog").fadeIn(100);						
						//var re = /<TERM>/g; 						
						$("#detallelog").html(datax.data.replace(/<br>/g,' \r\n'));
						$('#lblvuser').text(datax.vuser.replace("#"," "));
						$('#lblvdevice').text(datax.vdecice.replace("#"," "));
						var anex = "'"+idlog_view+"'" ;
							$("#scandevice").prop('disabled', false);
											$("#btnrun").prop('disabled', false);
						$('#lblvstationr').html(datax.vstation.replace("#"," ") +' -');
						alert('Process Finished');
					}
					else
					{
						
						//detallelog
						$("#msjwait").hide();
					 	$("#detallelog").fadeIn(100);						
						//var re = /<TERM>/g; 						
						$("#detallelog").html(datax.data.replace(/<br>/g,' \r\n'));
						$('#lblvuser').text(datax.vuser.replace("#"," "));
						$('#lblvdevice').text(datax.vdecice.replace("#"," "));
						var anex = "'"+idlog_view+"'" ;
						
						$('#lblvstationr').html(datax.vstation.replace("#"," ") +' -');
					}
					
					
				}
			});
			///fin buscar datos.
			
   }
   
	function fnt_btn_stop_again(vv_p_idb, vv_p_ids, vv_p_idu, var_local_petition2)
	{
		 return new Promise(function(resolve, reject) {
					var formData = new FormData();
			var req = new XMLHttpRequest();
		
			//verelprocesostop
			$("#verelprocesostop").prop('disabled', true);
			
			$("#txterror").html('');
									$("#diverror").hide();
									
			$("#scandevice").prop('disabled', false);
			clearInterval(refreshIntervalId);
			
			//consulta si devolvio el Scan Device
			formData.append("idb", vv_p_idb);
			formData.append("ids", vv_p_ids);
			formData.append("idu", vv_p_idu);
			//	var var_local_petition = $('#idpetitionrun').val();
				formData.append("idpp", var_local_petition2);
		///	formData.append("pjson", vv_p_idu);
			
			formData.append("idaccionweb", 4);
			
			clearInterval(refreshIntervalId);
			clearInterval(refreshIntervalIdbuscaruninfo);
			//Stop Timer
			
			$("#iddivrun").addClass('d-none');
			
			req.open("POST", "fasclient_queryberning.php");
			req.send(formData);
			
				req.onload = function() {
				  if (req.status == 200) {
					resolve(JSON.parse(req.response));
					//alert('refresco');
					
					
					 refreshIntervalIdstop = setInterval(function() {
				// Código a ejecutar
					window.location.href='burnintest.php';
					
					}, 10000);
					
					
				  }
				  else {
					reject();
				  }
				};

			
			})
	}
   
		function fnt_btn_stop(vv_p_idb, vv_p_ids, vv_p_idu) 
		{
			 return new Promise(function(resolve, reject) {
					var formData = new FormData();
			var req = new XMLHttpRequest();
			
						$("#txterror").html('');
									$("#diverror").hide();
									
		
			clearInterval(refreshIntervalId);
			
			//consulta si devolvio el Scan Device
			formData.append("idb", vv_p_idb);
			formData.append("ids", vv_p_ids);
			formData.append("idu", vv_p_idu);
				var var_local_petition = $('#idpetitionrun').val();
				formData.append("idpp", var_local_petition);
		///	formData.append("pjson", vv_p_idu);
			
			formData.append("idaccionweb", 4);
			
			clearInterval(refreshIntervalId);
			clearInterval(refreshIntervalIdbuscaruninfo);
			//Stop Timer
			
			$("#iddivrun").addClass('d-none');
			
			req.open("POST", "fasclient_queryberning.php");
			req.send(formData);
			
				req.onload = function() {
				  if (req.status == 200) {
					resolve(JSON.parse(req.response));
						alert('Process stopped ');
						$("#scandevice").prop('disabled', false);
						$("#btnrun").prop('disabled', false);
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
			if (tipodecombo =='A' && v_devicea !='')
			{
				v_deviceb==''? 	$("#deviceb option[value='"+$('#devicea').val()+"']").remove():'';
				v_devicec==''? 	$("#devicec option[value='"+$('#devicea').val()+"']").remove():'';
				v_deviced==''? 	$("#deviced option[value='"+$('#devicea').val()+"']").remove():'';
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
		//	console.log('ver' + var_local_petition);
			//consulta si devolvio el Scan Device
			formData.append("idb", vv_p_idb);
			formData.append("ids", vv_p_ids);
			formData.append("idu", vv_p_idu);
			formData.append("idpp", var_local_petition);
			
			formData.append("idaccionweb", 2);
			
			
			
			
			req.open("POST", "fasclient_queryberning.php");
			req.send(formData);
			
			req.onload = function() {
			  if (req.status == 200) {
				//	console.log('aaaaaaaaaaaa'+ req.response) ;
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
		//	console.log('llenar combos 1');
				const lossnrecibidos2 = results;
		//	console.log(lossnrecibidos2.length);
		
			if (results.length =0 ) 
			{
									$("#txterror").html('no devices found');
									$("#diverror").show();
			}
			else
			{
			
			var objmarc = JSON.parse(lossnrecibidos2);
			var lacantdevice2 ='N';	00
					
						
						$('#devicecoms').append('<option value="" > - select -</option>');
					
							//console.log('hola'+k +'cant:'+ objmarc[k]);
							
								if (objmarc.COMs =='')
							{
										$("#txterror").html('no devices found');
										$("#diverror").show();
										
											
							}
							
							$.each(objmarc.COMs, function (ind, elem) { 
							lacantdevice2 ='S';
							
							
							
						  console.log('¡Hola :'+elem+'!'); 
							$('#devicecoms').append('<option value="'+elem+'#'+objmarc.SNsDiB[ind]+'">'+elem+' ['+objmarc.SNsDiB[ind]+']</option>');
						
							
							
						}); 
						
						
							if ( lacantdevice2  =='N')
							{
										$("#txterror").html('No devices found');
										$("#diverror").removeClass('d-none');
										$("#diverror").show();
										
											
							}
							else
							{
									//	$("#btnrun").prop('disabled', false);
							         //	$("#btnstop").prop('disabled', false);						
							
							}
											
					
					
				}
				//fin else de null en respuesta			
		})
									
									
								
									},5000);
									
							}	
							else
							{
								$('#msjwaitline ').hide();
								// Envio para Frenar lo pendiente..
								
								var formDatacerrartodo = new FormData();

									formDatacerrartodo.append("idb", vv_p_idb);
									formDatacerrartodo.append("ids", vv_p_ids);
									formDatacerrartodo.append("idu", vv_p_idu);
									formDatacerrartodo.append("idpp", var_local_petition);
									formDatacerrartodo.append("idaccionweb", 6);
									/// idaccionweb 6
								//	console.log('cerrar todo'+ var_local_petition)
									var xhr_cerrar = new XMLHttpRequest();
									xhr_cerrar.open("POST", "fasclient_queryberning.php");
									xhr_cerrar.send(formDatacerrartodo);
									
										xhr_cerrar.onload = function() 
										{
										  if (xhr_cerrar.status == 200) {
											  	alert('server does not respond');
													$("#txterror").html('Server does not respond');
													$("#scandevice").prop('disabled', false);
												$("#diverror").removeClass('d-none');
												$("#diverror").show();
											}
										};
								
							
							//	reject();
									
							}
		
					}
					
					
				
			  }
			  else {
				reject();
			  }
			};

		
		})
	}

	function loading_sn(valor_select)
	{
		var elsplit = valor_select.split("#");
		$("#txtsnadd").val(elsplit[1].trim());
	}
	
	function scan_device(vv_p_idb, vv_p_ids, vv_p_idu)
	{
		//scan_device = 0;
		$("#txterror").html('');
									$("#diverror").hide();
		



	
		
		
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
			xhr.open("POST", "fasclient_queryberning.php");
			xhr.send(formData);
			
				xhr.onload = function() {
				  if (xhr.status == 200) {
					  
					$('#idpetitionrun').val(xhr.response.substring(4, 12).replace('"',''));
					
					
				//	console.log('devolvio el idaccionweb 1:' + xhr.response);
					//aca
							get_result_fasclient(vv_p_idb, vv_p_ids, vv_p_idu).then(results => {
		//	console.log('llenar combos');
		//	console.log(results);
			
			const lossnrecibidos = results;
		//	console.log(lossnrecibidos);
			var objmarc = JSON.parse(lossnrecibidos);
			var trajodevice ='N';
				
						$('#devicecoms').append('<option value=""> - select -</option>');
										
							
								if (objmarc.COMs =='')
							{
										$("#txterror").html('no devices found');
										$("#diverror").show();
										
											
							}
							
							$.each(objmarc.COMs, function (ind, elem) { 
							trajodevice ='S';
							
							
							
						  console.log('¡Hola :'+elem+'!'); 
							$('#devicecoms').append('<option value="'+objmarc.SNsDiB[ind]+'">'+elem+' ['+objmarc.SNsDiB[ind]+']</option>');
						
							
							
						}); 
						
						
									
						if (trajodevice =='N')
						{
						        	$("#txterror").html('No devices found');
									$("#diverror").removeClass('d-none');
									$("#diverror").show();
									
										
						}
						else
						{
							//	$("#btnrun").prop('disabled', false);
						//	$("#btnstop").prop('disabled', false);		
						}
											
						$("#scandevice").prop('disabled', false);
							
		})
					//finaca
					
				  }
				 
				};


	}


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

function splitLines(t) { return t.split(/\r\n|\r|\n/); }




  function addlist_to_run()
  {
	  var v_com = $("#devicecoms").val();
	  var v_ciu = $("#txtelciu").val().toUpperCase();
	  var v_sn = $("#txtsnadd").val().toUpperCase();
	  var v_interval = $("#txtmeasuretime").val();
	  var v_duration = $("#txtscripttime").val();

      var v_comsplit = v_com.split('-');
	  var v_comsplitrefcom = v_com.split('#');

	if (v_comsplit[0]!= "" && v_ciu != "" && v_sn != "" && v_interval != "" && v_duration != "" &&  v_sn.length == 10 ) 
  	{
						//Bscamos el SN Y CIU en el Array.
				//		checkValueinarraysn(v_sn, tabla_json_tosend);
					
					if (checkValueinarraysn(v_sn, tabla_json_tosend)=='Exist')
					{
							alert('Error, SN Exist in the List');
					}
					else
					{
						if (checkValueinarraycoms(v_com, tabla_json_tosend)=='Exist')
						{
							alert('Error, COM Exist in the List');
						}
						else
						{
							tabla_json_tosend.push({	
									devicecoms: v_comsplit[0].trim(),		
									devicecompleto: v_comsplitrefcom[0].trim(), 				   
									ciu:v_ciu,
									sn: v_sn,
									measureinterval: parseFloat(v_interval),
									scriptduration: parseFloat(v_duration)
						   });

						   tabla_json_list();

						   $("#devicecoms").find('[value="'+$("#devicecoms").val()+'"]').remove();
						   $("#devicecoms").val('');
					 $("#devicecoms").focus();
						$("#txtelciu").val('');
						$("#txtsnadd").val('');
					
						///Habilitamos botones
								$("#btnrun").prop('disabled', false);
							$("#btnstop").prop('disabled', false);		
						}

					}
						
				

	  }
	  else
	  {
		toastr["error"]("Incomplete parameters...", "");	
	  }


						   
  }
 
  function tabla_json_list()
	{
		var jname ="";
		var v_templistchannel="";
			var html = '<table class="table  table-striped table-sm ">';
				 html += '<tr>';
				 var cantcabez = tabla_json_tosend[0];
				 
				 for( var j in  cantcabez) {
					 
					 jname= j
					 if (j=='devicecoms')
					 {
						 jname='COM';
					 }
					 if (j=='ciu')
					 {
						 jname='CIU';
					 }
					 if (j=='sn')
					 {
						 jname='SN';
					 }
					 if (j=='devicecompleto')
					 {
						 jname='COM REF';
					 }

					 
					
					
					 
				  html += '<th>' + jname + '</th>';
				
				 }
				//  html += '<th>Action</th>';
				 html += '</tr>';
				 for( var i = 0; i < tabla_json_tosend.length; i++) {
				  html += '<tr>';
				  
				  if (v_templistchannel != '')
				  {
					v_templistchannel = v_templistchannel + "#";  
				  }
				  
				  for( var j in tabla_json_tosend[i] ) {
					 
					
					   html += '<td>' + tabla_json_tosend[i][j]  +' </td>';	   
					 
						
						v_templistchannel = v_templistchannel  + tabla_json_tosend[i][j] + "|"
					
					
				  }
				//  html += '<td>  <a href="#" onclick="borrar_array_uldl('+i+')"> <i class="fas fa-trash-alt"></i> Del</a> </td>';	  
				  html += '</tr>';
				 }
				 html += '</table>';
				 v_templistchannel = v_templistchannel + "#";  
				 console.log(v_templistchannel);
				 	$('#listagainuldl').html(html);
					$('#listagainuldltext').val(v_templistchannel);
				
		
	}
   
	$('#txtelciu').keypress(function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
		$('#txtsnadd').focus();
        alert('You pressed a "enter" key in textbox');  
    }
});

	$('#txtsnadd').keypress(function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
		addlist_to_run();
        //alert('You pressed a "enter" key in textbox');  
    }


});


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
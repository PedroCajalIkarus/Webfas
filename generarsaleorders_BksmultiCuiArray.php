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
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  
  <link href="css/tabulator_bootstrap4.css" rel="stylesheet">
  <link rel="shortcut icon" href="fiplexcirculo-01.ico" />
  
  <link rel="stylesheet" href="toastr.css">
  
 <link href="css/tabulator_bulma.css" rel="stylesheet">
 
  
    <link rel="stylesheet" href="cssfiplexsintextareaslog.css">
	
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
            <h1>Create Sale Orders</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Create SO </li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
   
		<section class="col-lg-12 connectedSortable ui-sortable">
		

				<div class="card">
				<div class="card-header ui-sortable-handle" >
               		
			
				  
				  
				  				<div class="row">
					 
		  
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-cog"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">PO CheckList </span>   
<span class="info-box-number">Diego</span>				
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
         

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-cogs"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">CIU Parameters Configuration</span>
                <span class="info-box-number">Alberto</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-barcode"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Create SO</span>
               <span class="info-box-number">Luiciana</span>					
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
		   <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-clipboard"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">SNs Assignments</span>
               <span class="info-box-number">Christian</span>					
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
        </div>
				  
			<!-- aca form -->
			
			      <form action="changeuserfasdata.php" method="post" class="form-horizontal" name="frmpass" id="frmpass">
	
      </form>
		
	 
			 <form class="needs-validation" action="generarsaleorders.php" method="post" class="form-horizontal" id="myform" name="myform">
  <!-- NUEVO RENGLON FORM  -->
  <div class="form-group row">
    <label for="statiCustomer" class="col-sm-2 col-form-label">Customer</label>
    <div class="col-sm-10">
        
			
			<input id="txtlistcustomers" name="txtlistcustomers" type="text" class="form-control" autocomplete="off" required>
			<input id="idtxtlistcustomers" name="idtxtlistcustomers" type="hidden">

    </div>
  </div>
  <!-- NUEVO RENGLON FORM  -->
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">PO Number</label>
    <div class="col-sm-4	">
      <input type="text" class="form-control" id="txtponumber" name="txtponumber" required placeholder="PO Number">
    </div>
	<label for="inputPassword" class="col-sm-2 col-form-label">SO Number</label>
	<div class="col-sm-4">
      <input type="text" class="form-control" id="txtsonumber" name="txtsonumber"  placeholder="SO Number">
    </div>
  </div>
  <!-- NUEVO RENGLON FORM  -->
    <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">Approved by:</label>
    <div class="col-sm-4	">
      <input type="text" class="form-control" id="txtapproved" name="txtapproved" placeholder="--">
    </div>
	<label for="inputPassword" class="col-sm-2 col-form-label">Approved Date:</label>
	<div class="col-sm-4">
      <input type="text" class="form-control" id="txtapproveddate" name="txtapproveddate" placeholder="--	">
    </div>
  </div>

  		<br>
		<div class="progress progress-xxs">
             <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
             </div>
        </div>
		<br>
    <!-- NUEVO RENGLON FORM  -->
    <div class="form-group row" >
    <label for="inputPassword" class="col-sm-2 col-form-label">Ciu Model:</label>
    <div class="col-sm-4	">
	
			<input id="txtlistcius" name="txtlistcius" type="text" class="form-control" autocomplete="off">
			<input id="idtxtlistcius" name="idtxtlistcius" type="hidden">
	
	
	    </div>
	<label for="inputPassword" class="col-sm-2 col-form-label">Quantity</label>
	<div class="col-sm-4">
    <input type="number" class="form-control col-3" id="txtcant" name="txtcant" placeholder="quantity ciu">	
	<button type="button" class="btn btn-smk btn-outline-primary btn-flat" onclick="add_cui_SO()">Add to List</button>
	
	<input type="hidden" class="form-control col-3" id="txtcuicant" name="txtcuicant" >	
    </div>
  </div>
    <!-- NUEVO RENGLON FORM  -->

    <div class="form-group row">
	
    <label for="inputPassword" class="col-sm-2 col-form-label">List Ciu</label>
    <div class="col-sm-8" id="listacium" name="listacium">
     <table class="table table-striped table-sm " >
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>CIU</th>
                      <th>Quantity</th>
                      <th style="width: 40px">Action</th>
                    </tr>
                  </thead>
                
                </table>
				  
    </div>
	
  </div>
  
  <div class="progress progress-xxs">
             <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
             </div>
        </div>
		<br>
		
    <!-- NUEVO RENGLON FORM  -->
    <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">Description:</label>
    <div class="col-sm-8	">
				  <textarea class="form-control" id="txtdescripso" name="txtdescripso" rows="4"></textarea>
    </div>
	<label for="inputPassword" class="col-sm-2 col-form-label"></label>
	<div class="col-sm-4">
		
    </div>
  </div>
 
    <!-- NUEVO RENGLON FORM  -->
	<!-- NUEVO RENGLON FORM  -->
    <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">POWER SUPPLY TYPE:</label>
    <div class="col-sm-2">
				<select  id="txtpwrsupply" name="txtpwrsupply" class="custom-select my-1 mr-sm-2 form-control" required>
				<option>AC/DC</option>
				<option>DC/DC</option>
		
				</select>
    </div>
	<label for="inputPassword" class="col-sm-1 col-form-label">RC-G for BWA:</label>
	<div class="col-sm-1">
		
		<input type="checkbox"  data-toggle="toggle"  data-off="NO" data-on="YES" id="txtrcgbwa" name="txtrcgbwa">
    </div>
	<label for="inputPassword" class="col-sm-1 col-form-label">Moden for Digital:</label>
	<div class="col-sm-1">
		<input type="checkbox"  data-toggle="toggle" data-on="YES" data-off="NO" id="txtmoden" name="txtmoden">
		

    </div>
  </div>
    <!-- NUEVO RENGLON FORM  -->
	
	  <!-- NUEVO RENGLON FORM  -->
    <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">DL gain (dB)</label>
    <div class="col-sm-4	">
      <input type="number" class="form-control" id="txtdlgain" name="txtdlgain" placeholder="DL GAIN (dB)" required>
    </div>
	<label for="inputPassword" class="col-sm-2 col-form-label">UL gain (dB)</label>
	<div class="col-sm-4">
      <input type="number" class="form-control" id="txtulgain" name="txtulgain" placeholder="UL GAIN (dB)" required>
    </div>
  </div>
  
    <!-- NUEVO RENGLON FORM  -->
	  <!-- NUEVO RENGLON FORM  -->
    <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">DL Max Pwr Out (dBm)</label>
    <div class="col-sm-4	">
      <input type="number" class="form-control" id="txtdlmaxpwr" name="txtdlmaxpwr" placeholder="DL Max Pwr Out (dBm)" required>
    </div>
	<label for="inputPassword" class="col-sm-2 col-form-label">UL Max Pwr Out (dBm)</label>
	<div class="col-sm-4">
      <input type="number" class="form-control" id="txtulmaxpwr" name="txtulmaxpwr" placeholder="UL Max Pwr Out (dBm)" required>
    </div>
  </div>
  
    <!-- NUEVO RENGLON FORM  -->
  	  <!-- NUEVO RENGLON FORM  -->
    <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">Unit DL start (MHZ):</label>
    <div class="col-sm-4	">
      <input type="text" class="form-control" id="txtunitdlstart" name="txtunitdlstart" placeholder="000.000/000.000" required>
	  
    </div>
	<label for="inputPassword" class="col-sm-2 col-form-label">Unit UL start (MHZ):</label>
	<div class="col-sm-4">
      <input type="text" class="form-control" id="txtunitulstart" name="txtunitulstart" placeholder="000.000/000.000" required>
    </div>
  </div>
  
    <!-- NUEVO RENGLON FORM  -->
		  <!-- NUEVO RENGLON FORM  -->
    <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">Unit DL stop (MHZ):</label>
    <div class="col-sm-4	">
      <input type="text" class="form-control" id="txtunitdlstop" name="txtunitdlstop" placeholder="000.000/000.000" required>
	  
    </div>
	<label for="inputPassword" class="col-sm-2 col-form-label">Unit UL stop (MHZ):</label>
	<div class="col-sm-4">
      <input type="text" class="form-control" id="txtunitulstop" name="txtunitulstop" placeholder="000.000/000.000" required>
    </div>
  </div>
  
    <!-- NUEVO RENGLON FORM  -->
			  <!-- NUEVO RENGLON FORM  -->
    <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">DPX low pass start (MHZ):</label>
    <div class="col-sm-4	">
      <input type="text" class="form-control" id="dpxlowpassstart" name="dpxlowpassstart" placeholder="000.000/000.000" required>
	  
    </div>
	<label for="inputPassword" class="col-sm-2 col-form-label">DPX high pass start (MHZ):</label>
	<div class="col-sm-4">
      <input type="text" class="form-control" id="dpxhighpassstart" name="dpxhighpassstart" placeholder="000.000/000.000" required>
    </div>
  </div>
  
    <!-- NUEVO RENGLON FORM  -->
	<!-- NUEVO RENGLON FORM  -->
    <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">DPX low pass stop (MHZ):</label>
    <div class="col-sm-4	">
      <input type="text" class="form-control" id="dpxlowpassstop" name="dpxlowpassstop" placeholder="000.000/000.000" required>
	  
    </div>
	<label for="inputPassword" class="col-sm-2 col-form-label">DPX high pass stop (MHZ):</label>
	<div class="col-sm-4">
      <input type="text" class="form-control" id="dpxhighpassstop" name="dpxhighpassstop" placeholder="000.000/000.000" required>
    </div>
  </div>  
    <!-- NUEVO RENGLON FORM  -->
	<div class="progress progress-xxs">
             <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
             </div>
        </div>
		<br>
	
	
	<!-- NUEVO RENGLON FORM  -->
    <div class="form-group row">
  
	
    <div class="col-sm-6	">
       <label  class="col-sm-2 col-form-label">DL Channels (MHZ):</label>  <input type="number" class="form-control" id="txtchud" name="txtchud" placeholder="000.000">
	  <label  class="col-sm-2 col-form-label">UL Channels (MHZ):	</label>    <input type="number" class="form-control" id="txtchul" name="txtchul" placeholder="000.000"> 
	    <button type="button" class="btn btn-smk btn-outline-primary btn-flat" onclick="add_channels()">Add to Channel List</button>
    </div>
	
	<div class="col-sm-6">
		<div class="col-sm-8" id="listachannel" name="listachannel" >
	    <table class="table table-striped table-sm " >
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Channels List</th>
                   
                      <th style="width: 40px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  
               
                  </tbody>
                </table>
		</div>
    </div>
  </div>  
    <!-- NUEVO RENGLON FORM  -->
	
	
	<br>
	<div class="progress progress-xxs">
             <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
             </div>
        </div>
		<br>
		<!-- NUEVO RENGLON FORM  -->
    <div class="form-group row">
		<label for="inputPassword" class="col-sm-1 col-form-label">Yes,changes described in the box to the rigth:</label>
			<div class="col-sm-2">		
			<input type="checkbox"  data-toggle="toggle"  data-off="NO" data-on="YES" id="txtchkrigth" name="txtchkrigth" >
			</div>
			<label for="inputPassword" class="col-sm-1 col-form-label">Training required for PP-ASSY</label>
			<div class="col-sm-2">
			<input type="checkbox"  data-toggle="toggle" data-on="YES" data-off="NO" id="txtppassy" name="txtppassy" >
			</div>  
			<label for="inputPassword" class="col-sm-1 col-form-label">Training required for Calibration</label>
			<div class="col-sm-2">
			<input type="checkbox"  data-toggle="toggle" data-on="YES" data-off="NO" id="txtreqcalib" name="txtreqcalib" >
			</div>  
			<label for="inputPassword" class="col-sm-1 col-form-label">Special Material required</label>
			<div class="col-sm-2">
			<input type="checkbox"  data-toggle="toggle" data-on="YES" data-off="NO" id="txtmatespecial" name="txtmatespecial" >
			</div>  
		</div>  
    <!-- NUEVO RENGLON FORM  -->
				  <!-- NUEVO RENGLON FORM  -->
    <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">Description of Resources Required:</label>
    <div class="col-sm-4	">
       <textarea class="form-control" id="txtdescripmatesp" name="txtdescripmatesp" rows="4"></textarea>
	  
    </div>
	<label for="inputPassword" class="col-sm-2 col-form-label">Notes:</label>
	<div class="col-sm-4">
      <textarea class="form-control"  id="txtnote" name="txtnote"  rows="4"></textarea>
    </div>
  </div>
  
     <div class="form-group row">
  
    <div class="col-sm-4	">
    
	  
    </div>
	
	<div class="col-sm-4">
        <button type="button" class="btn btn-primary btn-block" id="btnchangep" name="btnchangep">Create New SO</button>
    </div>
  </div>
  
    <!-- NUEVO RENGLON FORM  -->  
		
	
</form>

	 			 
		
				  
              
				</div>	
				</div>	
		 </section>
          <!-- /.col -->
        </div>
   

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
  <link href="css/bootstrap4-toggle.min.css" rel="stylesheet">
<script src="js/bootstrap4-toggle.min.js"></script>
<script src="js/bootstrap-typeahead.js"></script>
</body>



<script type="text/javascript">

//variable Global
 var tabla_cui_cant = [];
  var tabla_channel_quantity = [];
	
/*	$('#txtlistcustomers').on('change', function() {
      	//  $('#idtxtlistcustomers').val('');
   
    });
	$('#txtlistcustomers').on('focusout', function() {
		if (  $('#txtlistcustomers').val()!="")
		{
			if (  $('#idtxtlistcustomers').val()=="")
			{
				  alert('Please, select a customer');
				  
				 
				  $('#idtxtlistcustomers').val('');
				   $('#txtlistcustomers').val('');
				  //  $('#txtlistcustomers').focus();
			}
		}
    });
	*/

 // AutoComplete de Customers
$('#txtlistcius').typeahead({
  // data source
  source: [],
  // how many items to display
  items: 10,
  // enable scrollbar
  scrollBar: false,
  // equalize the dropdown width
  alignWidth: true,
  // typeahead dropdown template
  menu: '<ul class="typeahead dropdown-menu"></ul>',
  item: '<li><a href="#"></a></li>',
  // The object property that is returned when an item is selected.
  valueField: 'id',
  // The object property to match the query against and highlight in the results.
  displayField: 'name',
  // auto select
	autoSelect: true,
  // callback

	onSelect: function (item) {
	  console.log(item.value);	  
	  $('#idtxtlistcius').val(item.value);
  },
  // ajax options
  ajax: {
  url:'ajax_list_cuis.php',
    timeout: 300,
    method: 'get',
    triggerLength: 1,
    loadingClass: null,
    preDispatch: null,
    preProcess: null
  },
 
  
});
// fin AutoComplete de Customers
 // AutoComplete de Customers
$('#txtlistcustomers').typeahead({
  // data source
  source: [],
  // how many items to display
  items: 10,
  // enable scrollbar
  scrollBar: false,
  // equalize the dropdown width
  alignWidth: true,
  // typeahead dropdown template
  menu: '<ul class="typeahead dropdown-menu"></ul>',
  item: '<li><a href="#"></a></li>',
  // The object property that is returned when an item is selected.
  valueField: 'id',
  // The object property to match the query against and highlight in the results.
  displayField: 'name',
  // auto select
	autoSelect: true,
  // callback

	onSelect: function (item) {
	  console.log(item.value);	  
	  $('#idtxtlistcustomers').val(item.value);
  },
  // ajax options
  ajax: {
  url:'ajax_list_customers.php',
    timeout: 300,
    method: 'get',
    triggerLength: 1,
    loadingClass: null,
    preDispatch: null,
    preProcess: null
  },
 
  
});
// fin AutoComplete de Customers
   
	$( document ).ready(function() {
		
		   //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()
		
		//Inicio mostrar hora live
		 var interval = setInterval(function() {
			 
        var momentNow = moment();
		var newYork    = momentNow.tz('America/New_York').format('ha z');
        $('#date-part').html(momentNow.format('YYYY/MM/DD') 	  );
        $('#time-part').html(momentNow.format('hh:mm:ss'));
		}, 100);
		//FIN mostrar hora live
			console.log( "ready!" );
		

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
	 function borrar_array_channel(idborrarch)
	 {
		    tabla_channel_quantity.splice(idborrarch, 1); 
			
			$('body,html').stop(true,true).animate({				
				scrollTop: $("#listachannel").offset().top
			},1);
			
			tabla_channels();
			$('body,html').stop(true,true).animate({				
				scrollTop: $("#listachannel").offset().top
			},1);
	 }
	 
	 function borrar_array(idborrar)
	 	{
		 
		   tabla_cui_cant.splice(idborrar, 1); 
		 
		 	var html = '<table class="table  table-striped table-sm ">';
				 html += '<tr>';
				 var cantcabez = tabla_cui_cant[0];
				 for( var j in  cantcabez) {
				  html += '<th>' + j + '</th>';
				  if (j==='cant')
				  {
					    html += '<th>Action</th>';
					  break;
				  }
				 }
				 html += '</tr>';
				 for( var i = 0; i < tabla_cui_cant.length; i++) {
				  html += '<tr>';
				  for( var j in tabla_cui_cant[i] ) {
					  if ('idcui' != j)
					  {
						html += '<td>' + tabla_cui_cant[i][j]  +'</td>';	  
					  }
					
				  }
				  html += '<td>  <a href="#" onclick="borrar_array('+i+')"> <i class="fas fa-trash-alt"></i> Del</a> </td>';	  
				  html += '</tr>';
				 }
				 html += '</table>';
				 
				 console.log(html);
				 	$('#listacium').html(html);
		 
		}
    
	function tabla_channels()
	{
		var jname ="";
			var html = '<table class="table  table-striped table-sm ">';
				 html += '<tr>';
				 var cantcabez = tabla_channel_quantity[0];
				 
				 for( var j in  cantcabez) {
					 
					 jname= j
					 if (j =='channeldl')
					 {
						 jname="DL Channels (Mhz)";
					 }
					  if (j =='channelul')
					 {
						 jname="UL Channels (Mhz)";
					 }
					 
				  html += '<th>' + jname + '</th>';
				
				 }
				  html += '<th>Action</th>';
				 html += '</tr>';
				 for( var i = 0; i < tabla_channel_quantity.length; i++) {
				  html += '<tr>';
				  for( var j in tabla_channel_quantity[i] ) {
					 
						html += '<td>' + tabla_channel_quantity[i][j]  +'</td>';	  
					
					
				  }
				  html += '<td>  <a href="#" onclick="borrar_array_channel('+i+')"> <i class="fas fa-trash-alt"></i> Del</a> </td>';	  
				  html += '</tr>';
				 }
				 html += '</table>';
				 
				 console.log(html);
				 	$('#listachannel').html(html);
		
	}
	
	function add_channels()
	{
		//tabla_channel_quantity
		var v_dl_channel = $('#txtchud').val();
		var v_ul_channel = $('#txtchul').val();
		
		if (v_dl_channel=="" || v_ul_channel =="" )
		  {
			  ///|| v_ul_channel ==""
				 var v_loencontre_ch = 0;
		  }
		  else
		  {
			  
			 var v_loencontre_ch = 0;
					
				
					 $.each(tabla_channel_quantity, function (i, value) {
						if (value.channeldl == v_dl_channel)
						{
							// Lo encontre actualizo datos.
							v_loencontre_ch = 1;							
						}
						if (value.channelul == v_ul_channel)
						{
							// Lo encontre actualizo datos.
							v_loencontre_ch = 1;						
						}
					
					}); 
					if ( v_loencontre_ch == 0)
					{
						  tabla_channel_quantity.push({						
							channeldl: v_dl_channel,
							channelul: v_ul_channel						
							});
							tabla_channels();
					}
		  }	 
	}
	
	
	function add_cui_SO()
	{
		 // $('#idtxtlistcustomers').val('');
		 // $('#txtcant').val('');
		///	 idtxtlistcius txtlistcius
		var v_idtxtlistcius = $('#idtxtlistcius').val();
		var v_txtcuicant = $('#txtcant').val();
		
		  if (v_idtxtlistcius=="")
		  {
				
		  }
		  else
		  {
			 if ( eval(v_txtcuicant)>0 )
			 {
				//  $('#txtcuicant').val( $('#idtxtlistcius').val() + '#'+  $('#txtcant').val());
				//  tabla_cui_cant
				//  tabla_cui_cant.includes( $('#txtlistcius').val()  ); 
				var v_loencontre = 0;
					
//				tabla_cui_cant.length
					 $.each(tabla_cui_cant, function (i, value) {
						if (value.namecui == $('#txtlistcius').val())
						{
							// Lo encontre actualizo datos.
							v_loencontre = 1;
							tabla_cui_cant[i].cant = eval($('#txtcant').val()) + eval(tabla_cui_cant[i].cant); 
						}
						console.log ("aaaaa" + i + '-' + value.idcui+ '--'+ value.namecui);
					}); 
					if ( v_loencontre == 0)
					{
						  tabla_cui_cant.push({						
						namecui: $('#txtlistcius').val() ,
						cant: $('#txtcant').val(),
						idcui: $('#idtxtlistcius').val() 
					});
					}
				 
   
					var html = '<table class="table  table-striped table-sm ">';
				 html += '<tr>';
				 var cantcabez = tabla_cui_cant[0];
				 for( var j in  cantcabez) {
					 jname="";
					 if (j=='namecui')	
					 {
						 jname="CIU";
					 }	
					if (j=='cant')	
					 {
						 jname="Quantity";
					 }						 
					 
				  html += '<th>' + jname + '</th>';
				  if (j==='cant')
				  {
					    html += '<th>Action</th>';
					  break;
				  }
				 }
				 html += '</tr>';
				 for( var i = 0; i < tabla_cui_cant.length; i++) {
				  html += '<tr>';
				  for( var j in tabla_cui_cant[i] ) {
					  if ('idcui' != j)
					  {
						html += '<td>' + tabla_cui_cant[i][j]  +'</td>';	  
					  }
					
				  }
				  html += '<td>  <a href="#" onclick="borrar_array('+i+')"> <i class="fas fa-trash-alt"></i> Del</a></td>';	  
				  html += '</tr>';
				 }
				 html += '</table>';
				 
			//	 console.log(html);
				 	$('#listacium').html(html);
					 
					 $('#idtxtlistcustomers').val('');
					$('#txtcant').val('');
					$('#txtlistcius').val('');
				
				
			 }
		  }
			  
	}
   
</script>

<link rel="stylesheet" href="css/validator_marco.css">
<script src="js/jquery.validate.js"></script>

<script>
// just for the demos, avoids form submit
jQuery.validator.setDefaults({
  debug: true,
  success: "valid"
});
var form = $( "#myform" );
form.validate();
$("#btnchangep").click(function() {
	
	if (form.valid())
	{
		if (tabla_cui_cant.length>= 1)
		{
		//	alert( "post Valid: ");		
			if (tabla_channel_quantity.length >= 1)
			{
				
			}
			else
			{
				alert( "Channel List is required. ");	
			}
		}
		else
		{
			alert( "Ciu List is required. ");		
		}
			
		
	}
});
</script>


</html>

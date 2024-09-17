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
            <h1>Create CUI</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Activity Log</li>
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
          <section class="col-lg-2 connectedSortable ui-sortable">
		  
	  <!-- inicio box search marco -->
		  	
			<div class="card-group">
		
            <!-- The time line -->
            <div class="" name="divscrolllog" id="divscrolllog" style="display.">
			<p name="msjwaitline" id="msjwaitline" align="center"><img src="img/waitazul.gif" width="100px" ></p>
			
            	
			  <?php		  
					try{   
						// Sacar todos los resultados de la base de datos
						//echo $elwhere;
						?>
							
			 <div id="example-table" class="example-table-theme-bootstrap4"></div>
			 
			 <!--- inicio card --->			
				<div class="card border-success mb-3" style="max-width: 18rem;">
				  <div class="card-header bg-transparent border-success colorazulfiplex"><b>DIB Component </b>
					<div class="card-tools"><button id="btn1" type="button" class="btn  btn-sm" data-card-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fas fa-minus"></i></button> </div>
				  </div>
				   
				  <div class="card-body ">
					<div id="example-table-sender" class="example-table-theme-bootstrap4"></div>
				  </div> 
				</div>
				<!--- FIN inicio card --->	
				 <!--- inicio card --->			
				<div class="card border-success mb-3" style="max-width: 18rem;">
				  <div class="card-header bg-transparent border-success colorazulfiplex"><b>PA Component </b>
					<div class="card-tools"><button type="button" class="btn  btn-sm" data-card-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fas fa-minus"></i></button> </div>
				  </div>
				   
				  <div class="card-body ">
					<div id="example-table-senderpa" class="example-table-theme-bootstrap4"></div>
				  </div> 
				</div>
				<!--- FIN inicio card --->	
				 <!--- inicio card --->			
				<div class="card border-success mb-3" style="max-width: 18rem;">
				  <div class="card-header bg-transparent border-success  colorazulfiplex"><b>Power Supply AC/DC Component</b>
				  
					<div class="card-tools"><button type="button" class="btn  btn-sm" data-card-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fas fa-minus"></i></button> </div>
				  </div>
				   
				  <div class="card-body ">
						<div id="example-table-senderpwrsupply" class="example-table-theme-bootstrap4"></div>
				  </div> 
				</div>
				<!--- FIN inicio card --->	
				 <!--- inicio card --->			
				<div class="card border-success mb-3" style="max-width: 18rem;">
				  <div class="card-header bg-transparent border-success colorazulfiplex"><b>Branching Component</b>
					<div class="card-tools"><button type="button" class="btn  btn-sm" data-card-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fas fa-minus"></i></button> </div>
				  </div>
				   
				  <div class="card-body ">
						<div id="example-table-senderpBranching" class="example-table-theme-bootstrap4"></div>
				  </div> 
				</div>
				<!--- FIN inicio card --->	
			
			
			
			</div>
		
			 
			 
						<?php
 
					}catch(PDOException $e){
						echo "ERROR: " . $e->getMessage();
					}
				?>     
             
			 
			
			 
           
            </div>
			
		


        </section>
		<section class="col-lg-4 connectedSortable ui-sortable">
 <div id="example-table-receiver" class="example-table-theme-bootstrap4"></div>
 <div class="card-footer text-right">
								  
								</div>
		 </section>
		 	<section class="col-lg-5 connectedSortable ui-sortable">
<form>
  <div class="form-group">
    <div class="form-group">
    <label for="exampleFormControlSelect1">Family</label>
    <select class="form-control" id="exampleFormControlSelect1">
      <option>BDA</option>
      <option>DAS</option>
      <option>SCA</option>
      <option>AMP</option>
      <option>BBU</option>
	  

    </select>
  </div>
    <div class="form-group">
    <label for="exampleFormControlSelect1">Type Product</label>
    <select class="form-control" id="exampleFormControlSelect1">
      <option>DIGITAL BDA</option>
	    <option>ANALOG BDA</option>
		  <option>MASTER</option>
		    <option>REMOTE</option>
 
 
    </select>
  </div>
  
    <label for="exampleFormControlInput1">Ciu Model</label>
    <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="New Ciu Model">
  </div>
  <div class="form-group">
    <label for="exampleFormControlSelect1">Power in dBm</label>
    <select class="form-control" id="exampleFormControlSelect1">
      <option>11</option>
      <option>24</option>
      <option>45</option>
      <option>44</option>
      <option>55</option>
    </select>
  </div>
  <div class="form-group">
    <label for="exampleFormControlSelect2">Band</label>
    <select class="form-control" id="exampleFormControlSelect2">
      <option>137-164</option>
      <option>155-174</option>
      <option>380-398</option>
      
      
    </select>
  </div>
  <div class="form-group">
    <label for="exampleFormControlTextarea1">Description</label>
    <textarea class="form-control" id="exampleFormControlTextarea1" rows="2"></textarea>
  </div>
</form>
 <div class="card-footer text-right">
								  <button type="submit" onclick="save_new_registro()" class="btn btn-primary right-align">Create New CIU</button>
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

  var tabledata = [
   {id:1, name:"DigitalBoard01-026" },
    {id:2, name:"DigitalBoard01-025"},
    {id:3, name:"DigitalBoard01-005"}   ];
   
   
   	 var tabledatapa = [
    {id:1, name:"PAHP02-001" },
    {id:2, name:"PAHP02-002"},
    {id:3, name:"PAHP01-003"}    
    ];
   
   var tabledatapwrs = [
    {id:1, name:"AC/DC - HLG-240H-48C " },    
    {id:3, name:"DC/DC - PSY01-002"}    
    ];
	
	 var tabledatapwrs = [
    {id:1, name:"AC/DC - HLG-240H-48C " },    
    {id:3, name:"DC/DC - PSY01-002"}    
    ];
	
	var tabledatabran = [
    {id:1, name:"DPX-405-6-SMB + ISOLATOR " },    
    {id:3, name:"PR15-8-SMB-LP + PR15-8-SMB-HP + ISOL"}    
    ];
   
	$( document ).ready(function() {
		
			if ($(window).height()>640)
			{
				var altor=  $(window).height() - 200+'px';
			}
			else
			{
				var altor=  "560px";
			}
			
			var table = new Tabulator("#example-table-sender", {
							
							layout:"fitColumns",
							movableRows:true,
							movableRowsConnectedTables:"#example-table-receiver",
							movableRowsReceiver: "add",
							
							placeholder:"All Rows Moved",
							data:tabledata,
							columns:[
								{title:"Name", field:"name"},
							],
						});
						
						var tablepa = new Tabulator("#example-table-senderpa", {
							
							layout:"fitColumns",
							movableRows:true,
							movableRowsConnectedTables:"#example-table-receiver",
							movableRowsReceiver: "add",
						
							placeholder:"All Rows Moved",
							data:tabledatapa,
							columns:[
								{title:"Name", field:"name"},
							],
						});
						
						
							var tablepwrs = new Tabulator("#example-table-senderpwrsupply", {
							
							layout:"fitColumns",
							movableRows:true,
							movableRowsConnectedTables:"#example-table-receiver",
							movableRowsReceiver: "add",
							
							placeholder:"All Rows Moved",
							data:tabledatapwrs,
							columns:[
								{title:"Name", field:"name"},
							],
						});
						
						var tablepwrs = new Tabulator("#example-table-senderpBranching", {
							
							layout:"fitColumns",
							movableRows:true,
							movableRowsConnectedTables:"#example-table-receiver",
							movableRowsReceiver: "add",
							
							placeholder:"All Rows Moved",
							data:tabledatabran,
							columns:[
								{title:"Name", field:"name"},
							],
						});
						
						
						
						//Table to move rows to
						var table = new Tabulator("#example-table-receiver", {
							height:311,
							layout:"fitColumns",
							placeholder:"Drag Rows Here",
							data:[],
							columns:[
								{title:"Ciu Component ", field:"name"},
							],
						});
						
			
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

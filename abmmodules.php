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
		
        $sessionTTL = time() - $_SESSION["timeout"];
		//echo $_SESSION["a"]."***********hola". $sessionTTL;
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
		///	exit();
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
  <link href="css/smart_wizard_all.min.css" rel="stylesheet" type="text/css" />
 <link href="css/tabulator_bulma.css" rel="stylesheet">
 
  
    <link rel="stylesheet" href="cssfiplex.css">
	  <link rel="stylesheet" href="themestreecss/default2/style.css">
	

</head>
<form name="frma" id="frma" action="abmmodules.php" method="post" class="form-horizontal">
<input type="hidden" name="uso" id="uso" value="0">
<input type="hidden" name="radbuttypeprod" id="radbuttypeprod" value="0">

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
        <a href="index.php" class="nav-link">Home</a>
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
            <h1>Wizard module creator</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Wizard to create modules / units </li>
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
		
			<div class="col-lg-3">
			  <div class="card">
			    <div class="card-header border-0">
					 <div class="d-flex justify-content-between">
					  <h3 class="card-title">Configure Unit / Module</h3>
					
					</div>
				  </div>
						
						
						
						   <div class="container-fluid">
					 <br>
  <input id="search-input" name="search-input" class="form-control form-control-sm" placeholder="Quick search" />
  <br>
						<div class="ui-widget">
						  <div class="ui-widget-header">
							<b>Family Tree Products</b>
						  </div>
						 
						
						  <div id="tree">
						  </div>
						</div>
					</div>
					
					<hr>
				  
		
		
			  <!-- fin inicio arbol -->
			</div>
			</div>
			<div class="col-lg-9">
	
<!--  START TAB --->	
						<div class="col-12">
            <!-- Custom Tabs -->
            <div class="card">
              <div class="card-header d-flex p-0">
			  
                <h3 class="card-title p-3 colorazulfiplex " id="idtablabel" name="idtablabel"></h3>
				<input type="hidden" name="idtablabelbranch" id="idtablabelbranch" value="">
                <ul class="nav nav-pills ml-auto p-2">
                  <li class="nav-item"><a class="nav-link active " href="#tab_1list" data-toggle="tab">List</a></li>
				  <?php 
				  
				 if 	($_SESSION["g"] == "develop" ||  $_SESSION["g"] == "director" ) 
				  
				  {?>
                  <li class="nav-item"><a class="nav-link" href="#tab_2edit" data-toggle="tab">Edit</a></li>
                  <li class="nav-item"><a class="nav-link " href="#tab_3add" data-toggle="tab">Add</a></li>
				  <?php }?>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane active" id="tab_1list" name="tab_1list">
								
								<div class="alert alert-info alert-dismissible">
                  
								  <h5><i class="icon fas fa-info"></i> Attention </h5>
								select a branch of the tree 
								</div>
								
								
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="tab_2edit" name="tab_2edit">
					<div class="alert alert-info alert-dismissible">
                  
								  <h5><i class="icon fas fa-info"></i> Attention </h5>
								select a branch of the tree 
								</div>
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane " id="tab_3add" name="tab_3add">
                  <div class="alert alert-info alert-dismissible">
                  
								  <h5><i class="icon fas fa-info"></i> Attention </h5>
								select a branch of the tree 
								</div>
					
					
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- ./card -->
          </div>

<!--  CLOSE TAB --->
							
							
							
				
		
	
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


<script src="js/jQueryv1-10-2.min.js"></script>
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
 <script src="js/jquery.smartWizard.min.js" type="text/javascript"></script>
   <script type="text/javascript" src="js/jstree.min.js"></script>
    <link href="css/tabulator_modern12.css" rel="stylesheet">
  <script type="text/javascript" src="js/tabulator.min.js"></script>
</body>

<script type="text/javascript">

	var tabla_gain_rf= []; 


   
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

		$('#1_7_6_Coupler').addClass('d-none');
		$('#1_7_7_Duplexer').addClass('d-none');
		$('#1_7_8_Preselector').addClass('d-none');
		$('#1_7_10_Splitter').addClass('d-none');
		
		$('#divfasobjband').addClass('d-none');
		$('#divfasfw').addClass('d-none');
		$('#divfasfinalchkref').addClass('d-none');
		$('#divfasinstrumetsparameters').addClass('d-none');
		
   	   $('#btnfin').prop('disabled', true);
		  tabla_gain_rf.length=0;
		
		////cargamos arbol
		var jsonTreeData = "";

					$.ajax({
								url: 'ajax_list_tree_branchproducts.php',			
								type: 'post',				
								datatype:'JSON',				
								cache:false,					
								success: function(data, status, xhr) {
									jsonTreeData= data ;
							//	console.log(jsonTreeData);
								//	console.log(exData);
									 $('#tree').jstree({
					core: {
					  check_callback: true,
					  data: jsonTreeData
					},
					types: {
					  root: {
						icon: "fa fa-globe-o"
					  }
					},
					plugins: ["core", "html_data", "themes", "ui","dnd","search"]
					
					
				  });
  
				
			return false;	
				
				},
				error: function(xhr, status, error) {
					 console.log(status);
				}
				});
				
				
				
				 $("#search-input").keyup(function () {
					 console.log( $(this).val());
                var searchString = $(this).val();
                $('#tree').jstree('search', searchString);
            });
		////fin cargar arbol
 
 });
 
 
 	$('#tree').on("select_node.jstree", function (e, data) { 
	//alert("node_id: " + data.node.id);
	
	
		$('#1_7_6_Coupler').addClass('d-none');
		$('#1_7_7_Duplexer').addClass('d-none');
		$('#1_7_8_Preselector').addClass('d-none');
		$('#1_7_10_Splitter').addClass('d-none');
		$('#divfasobjband').addClass('d-none');
		$('#divfasfw').addClass('d-none');
		$('#divfasfinalchkref').addClass('d-none');
		$('#divfasinstrumetsparameters').addClass('d-none');
		
	//console.log( data.node);
	//console.log('a verrr...'+ data.node.name);
	$("#idtablabel").html(data.node.text);
	$("#idtablabelbranch").val(data.node.id);
	
	primerpaso(data.node.id);
	
	
///			mostrar_datos_fw(data.node.id, data.node.text);

	});
 
	// controlar inactividad en la web	
		$(document).inactivityTimeout({
                inactivityWait: 10000,
                dialogWait: 10,
                logoutUrl: 'logout.php'
            })
	// fin controlar inactividad en la web		
	
	 /* requesting data */
     function habilitarsiguiente()
	 {
		// console.log('valiar'+ $("#txtnewprod").val());
		
	 }	 
	 
	 function mostrarfwselectr(elstring)
	 {
		 var losdatosamostrarfw = elstring.split("#");
		 console.log(elstring);
		 $("#txtfpga").val(losdatosamostrarfw[4]);
		 $("#txtuc").val(losdatosamostrarfw[5]);
		 $("#txtether").val(losdatosamostrarfw[6]);
		 $("#txtfpgacus").val(losdatosamostrarfw[1]);
		 $("#txtuccus").val(losdatosamostrarfw[2]);
		 $("#txtethercus").val(losdatosamostrarfw[2]);
	 }

	 function buscadatos(eldatopasado,typodemodu)
	 {
		 alert('Test- Show Data:' + typodemodu+' --' + eldatopasado);
		 
		 if (typodemodu =='Migration')
		 {
			$('#divtipomod').removeClass('d-none'); 
		 }
		 
		 ///// BUSCAR DATOS DEL Module
		  return new Promise(function(resolve, reject) {
					var formData = new FormData();
					var req = new XMLHttpRequest();
			
					//consulta si devolvio el Scan Device
					
				formData.append("typodemodu", typodemodu);
				formData.append("idprod", eldatopasado);
			
				req.open("POST", "abmmodulesinfo.php");
				req.send(formData);
			
				req.onload = function() {
				  if (req.status == 200) {
							resolve(JSON.parse(req.response));
							
							console.log(JSON.parse(req.response));
							console.log('INFORMACION RECIBIDA  ');
							var objrespuesta = JSON.parse(req.response);
							console.log (objrespuesta.dreturn_coupler);
							
							
							console.log (objrespuesta.dreturn_coupler[0]['coupfstart']);
							console.log (objrespuesta.dreturn_product[0]['modelciu']);
							
							//objrespuesta.dreturn_product[0]['modelciu']
							//objrespuesta.dreturn_product[0]['description']
							//objrespuesta.dreturn_product[0]['idbusiness']
							//Blanqueamos datos	//Blanquear datos.
						$("#txtbusiness").val(objrespuesta.dreturn_product[0]['idbusiness']);
						$("#txtmadein").val('');
						$("#txtflia").val('');
						$("#txtrohsimg").val('');
						$("#txtmadeinimg").val('');
						
						$("#txtnewprod").val(objrespuesta.dreturn_product[0]['modelciu']);
						$("#txtnewproddescr").val(	objrespuesta.dreturn_product[0]['description']);
						$("#txtcoupling").val(objrespuesta.dreturn_coupler[0]['coupling']);
						$("#txtcouplinginserloss").val(objrespuesta.dreturn_coupler[0]['couplinginsertloss']);
						
						$("#txtcouplingisolat").val(objrespuesta.dreturn_coupler[0]['couplingisolation']); 
						$("#txtcouplingfreqstart").val(objrespuesta.dreturn_coupler[0]['coupfstart']);
						$("#txtcouplingfreqstop").val('');
						
						$("#duplextxrx").val('');
						$("#duplextxrxinserlosstx").val('');
						$("#duplextxrxinserlossrx").val('');
						$("#duplexnoiserx").val('');
						$("#duplexisolarxtx").val('');
						$("#duplexfreqstop").val('');
						
						$("#duplexfreqstart").val('');
						
						$("#txtbandwidth").val('');
						$("#txtbandwidthinserloss").val('');
						$("#txtbandwidthfreqstart").val('');
						$("#txtbandwidthfreqstop").val('');
						$("#txtsplitloss").val('');
						$("#txtsplitinserloss").val('');
						$("#txtsplitnroway").val('');
						$("#txtsplitfreqstart").val('');
						$("#txtsplitfreqstop").val('');
						
						
						/*	$("#txtbusiness").val('');
						$("#txtmadein").val('');
						$("#txtflia").val('');
						$("#txtrohsimg").val('');
						$("#txtmadeinimg").val('');
						
						$("#txtnewprod").val('');
						$("#txtnewproddescr").val('');
						$("#txtcoupling").val('');
						$("#txtcouplinginserloss").val('');
						
						$("#txtcouplingisolat").val('');
						$("#txtcouplingfreqstart").val(objrespuesta.dreturn_coupler.coupfstart);
						$("#txtcouplingfreqstop").val('');
						
						$("#duplextxrx").val('');
						$("#duplextxrxinserlosstx").val('');
						$("#duplextxrxinserlossrx").val('');
						$("#duplexnoiserx").val('');
						$("#duplexisolarxtx").val('');
						$("#duplexfreqstop").val('');
						
						$("#duplexfreqstart").val('');
						
						$("#txtbandwidth").val('');
						$("#txtbandwidthinserloss").val('');
						$("#txtbandwidthfreqstart").val('');
						$("#txtbandwidthfreqstop").val('');
						$("#txtsplitloss").val('');
						$("#txtsplitinserloss").val('');
						$("#txtsplitnroway").val('');
						$("#txtsplitfreqstart").val('');
						$("#txtsplitfreqstop").val('');
						*/
						
						//fin llenado de datos
					
				  }
				  else {
					reject();
				  }
				};

			
			})
		 ///// FIN BUSCAR DATOS DEL MODULE
		 	
	 }
		
	function habilitarfin(qtipodemodulocargaron)	
	{
		console.log('habilitarfin' + qtipodemodulocargaron);
		if (qtipodemodulocargaron=='auto')
		{
			//if ($("#radbuttypeprod").val()=='0_5_2_700/800 DualBand')
			if ($("#radbuttypeprod").val()=='a00000000101600140012')
			{
				qtipodemodulocargaron='BDA';
			}
			if ($("#radbuttypeprod").val()=='0_5_3_High Capacity')
			{
				qtipodemodulocargaron='BDA';
			}
			if ($("#radbuttypeprod").val()=='coupler')
			{
				qtipodemodulocargaron='coupler';
			}
			if ($("#radbuttypeprod").val()=='1_7_7_Duplexer')
			{
				qtipodemodulocargaron='duplexer';
			}
			if ($("#radbuttypeprod").val()=='1_7_8_Preselector')
			{
				qtipodemodulocargaron='preselector';
			}
			if ($("#radbuttypeprod").val()=='1_7_10_Splitter')
			{
				qtipodemodulocargaron='splitter';
			}
			//
		console.log('seteo1:' +qtipodemodulocargaron);
	
		}
		
	
		
		contadordefaltantes = 0;
		// inicio control coupler
		if ($("#txtnewprod").val()=="") {contadordefaltantes=1;}
		
		console.log('llamo a habilitarfin:' + contadordefaltantes+'-qtipodemodulocargaron:'+qtipodemodulocargaron);
		
	
		if(qtipodemodulocargaron =='BDA')
		{
			
			if ($("#txtgaintolerancebda").val()=="") {contadordefaltantes=1;}
			if ($("#txtgaintolerancebda").val()=="") {contadordefaltantes=1;}
			if ($("#txtmaxprwtolbda").val()=="") {contadordefaltantes=1;}
			if ($("#txtimdlibda").val()=="") {contadordefaltantes=1;}
			if ($("#txtnoisefbda").val()=="") {contadordefaltantes=1;}
			if ($("#txtspuriosbda").val()=="") {contadordefaltantes=1;}
			
			if (tabla_gain_rf.length==0) {contadordefaltantes=1;}
			
			
			if ($("#txtflia").val()=="") {contadordefaltantes=1;}
			if ($("#txtmadein").val()=="") {contadordefaltantes=1;}
			if ($("#txtrohsimg").val()=="") {contadordefaltantes=1;}
			if ($("#txtmadeinimg").val()=="") {contadordefaltantes=1;}
			if ($("#txtupwr").val()=="") {contadordefaltantes=1;}
			if ($("#txtfcc").val()=="") {contadordefaltantes=1;}
			if ($("#txtic").val()=="") {contadordefaltantes=1;}
			if ($("#txtetsi").val()=="") {contadordefaltantes=1;}
			if ($("#txtfccimg").val()=="") {contadordefaltantes=1;}
			if ($("#txulimg").val()=="") {contadordefaltantes=1;}
			if ($("#txtintertek").val()=="") {contadordefaltantes=1;}
			if ($("#txtetlnumber").val()=="") {contadordefaltantes=1;}
						


		}
		
		if(qtipodemodulocargaron =='coupler')
		{				
			if ($("#txtcoupling").val()=="") {contadordefaltantes=1;}
			if ($("#txtcouplinginserloss").val()=="") {contadordefaltantes=1;}
			if ($("#txtcouplingisolat").val()=="") {contadordefaltantes=1;}
			if ($("#txtcouplingfreqstart").val()=="") {contadordefaltantes=1;}
			if ($("#txtcouplingfreqstop").val()=="") {contadordefaltantes=1;}
			if ($("#txtflia").val()=="") {contadordefaltantes=1;}
			if ($("#txtmadein").val()=="") {contadordefaltantes=1;}
			if ($("#txtrohsimg").val()=="") {contadordefaltantes=1;}
			if ($("#txtmadeinimg").val()=="") {contadordefaltantes=1;}
		}
		// fin control coupler
		// inicio control duplexer		
		if(qtipodemodulocargaron =='duplexer')
		{				
			if ($("#duplextxrx").val()=="") {contadordefaltantes=1;}
			if ($("#duplextxrxinserlosstx").val()=="") {contadordefaltantes=1;}
			if ($("#duplextxrxinserlossrx").val()=="") {contadordefaltantes=1;}
			if ($("#duplexfreqstart").val()=="") {contadordefaltantes=1;}
			if ($("#duplexfreqstop").val()=="") {contadordefaltantes=1;}
			if ($("#duplexnoiserx").val()=="") {contadordefaltantes=1;}
			if ($("#duplexisolarxtx").val()=="") {contadordefaltantes=1;}
			if ($("#txtflia").val()=="") {contadordefaltantes=1;}
			if ($("#txtmadein").val()=="") {contadordefaltantes=1;}
			if ($("#txtrohsimg").val()=="") {contadordefaltantes=1;}
			if ($("#txtmadeinimg").val()=="") {contadordefaltantes=1;}
		}
		// fin control duplexer
		// inicio control preselector		
		if(qtipodemodulocargaron =='preselector')
		{				
			if ($("#txtbandwidth").val()=="") {contadordefaltantes=1;}
			if ($("#txtbandwidthinserloss").val()=="") {contadordefaltantes=1;}			
			if ($("#txtbandwidthfreqstart").val()=="") {contadordefaltantes=1;}
			if ($("#txtbandwidthfreqstop").val()=="") {contadordefaltantes=1;}	
			if ($("#txtflia").val()=="") {contadordefaltantes=1;}
			if ($("#txtmadein").val()=="") {contadordefaltantes=1;}
			if ($("#txtrohsimg").val()=="") {contadordefaltantes=1;}
			if ($("#txtmadeinimg").val()=="") {contadordefaltantes=1;}			
		
		}
		// fin control preselector
		// inicio control splitter		
		if(qtipodemodulocargaron =='splitter')
		{				
			if ($("#txtsplitloss").val()=="") {contadordefaltantes=1;}
			if ($("#txtsplitinserloss").val()=="") {contadordefaltantes=1;}			
			if ($("#txtsplitnroway").val()=="") {contadordefaltantes=1;}
			if ($("#txtsplitfreqstart").val()=="") {contadordefaltantes=1;}	
			if ($("#txtsplitfreqstop").val()=="") {contadordefaltantes=1;}	
			if ($("#txtflia").val()=="") {contadordefaltantes=1;}
			if ($("#txtmadein").val()=="") {contadordefaltantes=1;}
			if ($("#txtrohsimg").val()=="") {contadordefaltantes=1;}
			if ($("#txtmadeinimg").val()=="") {contadordefaltantes=1;}			
		
		}
		// fin control splitter
		console.log('validar:' + contadordefaltantes);
		if (contadordefaltantes == 0)
		{
				$('#btnfin').removeClass('disabled');
				  $('#btnfin').prop('disabled', false);
		}
		else
		{
			
				  $('#btnfin').prop('disabled', true);
		}
	}
		
	function primerpaso(vvalor)
	{
	//	var losdatosamotrar = vvalor.split("_");
		console.log('Primer paso: parametro recibido:' + vvalor);
		
		//Search the pag where list table by branch.
			var armando_tabla_bybranch= '';
				toastr["info"]("Information search...", "");	
								$.ajax({
										url: 'listajax_'+vvalor+'.php?p0='+vvalor,										
										 cache:false,
										success: function(respuesta) {
											
											armando_tabla_bybranch=armando_tabla_bybranch+respuesta;

											$('#tab_1list').html(""+armando_tabla_bybranch);
											return false;
										},
										error: function() {
											console.log("No se ha podido obtener la información");
											$('#tab_1list').html("<p class='text-danger'>No information found for the tree branch</p>");
										}
									});
									
		
		//end search table list..
		//TAB Edit -> pag where list table by branch.
			var armando_tabla_bybranchedit= '';
			//	toastr["info"]("Information search for edit", "");	
								$.ajax({
										url: 'editajax_'+vvalor+'.php?p0='+vvalor,										
										 cache:false,
										success: function(respuesta) {
											
											armando_tabla_bybranchedit=armando_tabla_bybranchedit+respuesta;

											$('#tab_2edit').html(""+respuesta);
											console.log('edit . console.'+respuesta);
										
										//	$('#tab_2edit').html(respuesta);
											return false;
										},
										error: function() {
											console.log("No se ha podido obtener la información");
											$('#tab_2edit').html(" <p class='text-danger'>No information found for the tree branch</p>");
										}
									});
		
		//TAB Edit END  -> pag where list table by branch.
			//TAB ADD -> pag where list table by branch.
			var armando_tabla_bybranchadd= '';
			//	toastr["info"]("Create Module", "");	
								$.ajax({
										url: 'addajax_'+vvalor+'.php?p0='+vvalor,										
										 cache:false,
										success: function(respuesta) {
											
										//	armando_tabla_bybranchedit=armando_tabla_bybranchedit+respuesta;
									
											$('#tab_3add').html(""+respuesta);
										//	console.log(respuesta);
											return false;
										},
										error: function() {
											console.log("No se ha podido obtener la información");
											$('#tab_3add').html("<p class='text-danger'>No information found for the tree branch</p>");
										}
									});
		
		//TAB ADD END  -> pag where list table by branch.
		
		
		 $("#radbuttypeprod").val(vvalor);
	/*	$('#1_7_6_Coupler').addClass('d-none');
		$('#1_7_7_Duplexer').addClass('d-none');
		$('#1_7_8_Preselector').addClass('d-none');
		$('#1_7_10_Splitter').addClass('d-none');
		$('#divfasobjband').addClass('d-none');
		$('#divfasfw').addClass('d-none');
		$('#divfasfinalchkref').addClass('d-none');
		$('#divfasinstrumetsparameters').addClass('d-none');
		
		$('.labelpformodule').addClass('d-none');
			$('.labelforunit').addClass('d-none');*/
		
		var nvovalor = vvalor;
		///	console.log('Nvo valor button' + nvovalor);
			
	//	if(losdatosamotrar[0]==0)
		//{
			
			
			// Buscamos los FW del tpye de producto
			    $("#txtfpga").val('');
				$("#txtuc").val('');
				$("#txtether").val('');
			
				$("#txtfpgacus").val('');
				$("#txtuccus").val('');
				$("#txtethercus").val('');
			/*	
				///1_7_6_Coupler
				if('a0000000020006'==vvalor)
				{
						$('#1_7_6_Coupler').removeClass('d-none');
							$('.labelpformodule').removeClass('d-none');
				}
				
				///Digital Board
				if('a000000002013'==vvalor)
				{
						$('#divfasfinalchkref').removeClass('d-none');
						$('#divfasinstrumetsparameters').removeClass('d-none');
						$('.labelpformodule').removeClass('d-none');
						$('.labelforunit').removeClass('d-none');
							$('#divfasfw').removeClass('d-none');
							$('#divfasobjband').removeClass('d-none');
				}
			
				///Digital Board- FLEX y sus ramas
				///console.log('cortado:'+ vvalor.substr(0,13));
				if('a000000002013'==vvalor.substr(0,13))
				{
						$('#divfasfinalchkref').removeClass('d-none');
						$('#divfasinstrumetsparameters').removeClass('d-none');
						$('.labelpformodule').removeClass('d-none');
						$('.labelforunit').removeClass('d-none');
							$('#divfasfw').removeClass('d-none');
							$('#divfasobjband').removeClass('d-none');
				}
				
				if('a00000000101600140012'== vvalor )
			//	if ('0_5_2_700/800 DualBand' == vvalor )
				{
					
					$('#divfasobjband').removeClass('d-none');
						$('#divfasfw').removeClass('d-none');
						$('#divfasfinalchkref').removeClass('d-none');
						$('#divfasinstrumetsparameters').removeClass('d-none');
						
						$('.labelpformodule').removeClass('d-none');
						$('.labelforunit').removeClass('d-none');
			
			
					console.log('si 0_5_2_700/800 DualBand');
					$("#txtfpga").val('1.2');
					$("#txtuc").val('1.05');
					$("#txtether").val('1.0.5');
				
					$("#txtfpgacus").val('ver_1_02_01.mcs');
					$("#txtuccus").val('fip446_bda_pic32_v1.05.hex');
					$("#txtethercus").val('fip446_bda_rabbit_v1.0.5.bin');
				}
				//1_7_6_Coupler
				if('a00000000101600140003'== vvalor )
			//	if ('0_5_2_700/800 DualBand' == vvalor )
				{
					
					$('#divfasobjband').removeClass('d-none');
					$('#divfasfw').removeClass('d-none');
					$('#divfasfinalchkref').removeClass('d-none');
					$('#divfasinstrumetsparameters').removeClass('d-none');
					
					$('.labelpformodule').removeClass('d-none');
					$('.labelforunit').removeClass('d-none');
					
			
					console.log('si 0_5_2_700/800 DualBand');
					$("#txtfpga").val('1.2');
					$("#txtuc").val('1.05');
					$("#txtether").val('1.0.5');
				
					$("#txtfpgacus").val('ver_1_02_01.mcs');
					$("#txtuccus").val('fip446_bda_pic32_v1.05.hex');
					$("#txtethercus").val('fip446_bda_rabbit_v1.0.5.bin');
				}
			*/
			// fin Buscamos los FW del tpye de producto

	//	}
	//	else
	//	{
	//		$('.labelpformodule').removeClass('d-none');
	//		$('#'+nvovalor).removeClass('d-none');
	//	}
		
		$("#lbltitulo").html("<b>CIU Specs :: "+vvalor+"</b>");
		
		if ( $("#txtnewprod").val() !='')
		{
				
		}
	}	
	
	
	
	
	function habilitarfirmware(nvovalorfw)
	{
		if (nvovalorfw == 'firmwarestand')
		{
			/*
			txtfpga
txtuc
txtether
*/
		

			$("#txtfpga").prop( "disabled", true );
			$("#txtuc").prop( "disabled", true );
			$("#txtether").prop( "disabled", true );
			
			$("#txtfpgacus").prop( "disabled", true );
			$("#txtuccus").prop( "disabled", true );
			$("#txtethercus").prop( "disabled", true );
				if ($("#radbuttypeprod").val()=='0_5_2_700/800 DualBand')
			{
			
			}
			
		}
		else
		{
			$("#txtfpga").prop( "disabled", false );
			$("#txtuc").prop( "disabled", false );
			$("#txtether").prop( "disabled", false );
			
			$("#txtfpgacus").prop( "disabled", false );
			$("#txtuccus").prop( "disabled", false );
			$("#txtethercus").prop( "disabled", false );
			
			/*	$("#txtfpga").val('');
				$("#txtuc").val('');
				$("#txtether").val('');
			
				$("#txtfpgacus").val('');
				$("#txtuccus").val('');
				$("#txtethercus").val('');*/

		}
	}
	
	function save_new_registro()
	{
		
		
		//Enviamos los datos a procesar
			 return new Promise(function(resolve, reject) {
					var formData = new FormData();
			var req = new XMLHttpRequest();
			//consulta si devolvio el Scan Device
			formData.append("idmoduleprodflia",  $("#radbuttypeprod").val());
			formData.append("txtbusiness",  $("#txtbusiness").val());
			
			
			
			formData.append("txtmadein",  $("#txtmadein").val());
			formData.append("txtflia",  $("#txtflia").val());
			formData.append("txtrohsimg",  $("#txtrohsimg").val());
			formData.append("txtmadeinimg",  $("#txtmadeinimg").val());
			
			//agregamos datos para Label
			formData.append("txtupwr",  $("#txtupwr").val());
			formData.append("txtfcc",  $("#txtfcc").val());
			formData.append("txtic",  $("#txtic").val());
			formData.append("txtetsi",  $("#txtetsi").val());
			formData.append("txtfccimg",  $("#txtfccimg").val());
			
			formData.append("txtintertek",  $("#txtintertek").val());
			formData.append("txtetlnumber",  $("#txtetlnumber").val());
			//fin agregamos datos para Label
			//txtetsi
			
			///// Firmware Specs:
			
			formData.append("txttypeclassfw",  $("#txttypeclassfw").val());
			formData.append("txtfpga",  $("#txtfpga").val());
			formData.append("txtulimg",  $("#txtulimg").val());
			formData.append("txtuc",  $("#txtuc").val());
			formData.append("txtether",  $("#txtether").val());
			formData.append("txtfpgacus",  $("#txtfpgacus").val());
			formData.append("txtuccus",  $("#txtuccus").val());
			formData.append("txtethercus",  $("#txtethercus").val());
			///// fin Firmware Specs:
			
			//Final Check Reference:
			formData.append("txtgaintolerancebda",  $("#txtgaintolerancebda").val());
			formData.append("txtmaxprwtolbda",  $("#txtmaxprwtolbda").val());
			formData.append("txtimdlibda",  $("#txtimdlibda").val());
			formData.append("txtnoisefbda",  $("#txtnoisefbda").val());
			formData.append("txtspuriosbda",  $("#txtspuriosbda").val());
			// fin Final Check Reference:
			
						
			// inicio Band & RF Specs:
			formData.append("divlist_tabla_gain_rftexto",  $("#divlist_tabla_gain_rftexto").val());
			// fin Band & RF Specs:
			
			//inicio script specs
			var idmediacionaaasociar="";
			$(".custom-control-inputmm").each(function(){
				if ($(this).prop('checked')==true)
				{
					 console.log($(this).val()+'- '+ $(this).prop('checked'));
					 idmediacionaaasociar = idmediacionaaasociar + '#' + $(this).val();
				}
        	   
        	});
			 console.log('Mediciones:'+idmediacionaaasociar);
			formData.append("idmediacionaaasociar", idmediacionaaasociar);
			// fin script specs
			
			
			formData.append("v_namemod", $("#txtnewprod").val());
			formData.append("v_namemoddescrip", $("#txtnewproddescr").val());
			///module passive coupler
			formData.append("vcouple_coupling", $("#txtcoupling").val());
			formData.append("vcouple_insertloss", $("#txtcouplinginserloss").val());
			formData.append("vcouple_isolation", $("#txtcouplingisolat").val());
			formData.append("vcouple_freqstart", $("#txtcouplingfreqstart").val());
			formData.append("vcouple_freqstop", $("#txtcouplingfreqstop").val());
			
			///module passive duplexer
			formData.append("vduplexer_txrxsep", $("#duplextxrx").val());
			formData.append("vduplexer_insertlosstx", $("#duplextxrxinserlosstx").val());
			formData.append("vduplexer_insertlossrx", $("#duplextxrxinserlossrx").val());
			formData.append("vduplexer_txnoise", $("#duplexnoiserx").val());
			formData.append("vduplexer_isolationrxtx", $("#duplexisolarxtx").val());
			formData.append("vduplexer_freqstart", $("#duplexfreqstart").val());
			formData.append("vduplexer_freqstop", $("#duplexfreqstop").val());
			
			///module passive Preselector
			formData.append("vpreselector_bandwitdh", $("#txtbandwidth").val());
			formData.append("vpreselector_insertloss", $("#txtbandwidthinserloss").val());
			formData.append("vpreselector_freqstart", $("#txtbandwidthfreqstart").val());
			formData.append("vpreselector_freqstop", $("#txtbandwidthfreqstop").val());
			
			///module passive splitter
			formData.append("vsplitter_splitloss", $("#txtsplitloss").val());
			formData.append("vsplitter_insertloss", $("#txtsplitinserloss").val());
			formData.append("vsplitter_nroways", $("#txtsplitnroway").val());
			formData.append("vsplitter_freqstart", $("#txtsplitfreqstart").val());
			formData.append("vsplitter_freqstop", $("#txtsplitfreqstop").val());
					
			//0_5_2 es BDA FLEX
		
			if ($("#txtmodiftypemodule").val() =='0_5_2')
			{
				req.open("POST", "ajax_insert_modules_bda.php");
			}
			//0_5_3_High Capacity
			if ($("#txtmodiftypemodule").val() =='DIGBOARDFLEX')
			{
				req.open("POST", "ajax_insert_modules_dib.php");
			}
			// Module -Passive
			if ($("#txtmodiftypemodule").val() =='coupler')
			{
				req.open("POST", "ajax_insert_modules_passives.php");
			}
			console.log('paso por el post');
		///	req.open("POST", "ajax_insert_modules_passives.php");
		
			req.send(formData);
			toastr["success"]("Save OK!", "");	
			req.onload = function() {
				  if (req.status == 200) {
					
					//alert(req.response);
					var losresultado = req.response.split("#");
					resolve(JSON.parse(req.response));
					
						//location.reload();
					
					
					//Blanquear datos.
						$("#txtbusiness").val('');
						$("#txtmadein").val('');
						$("#txtflia").val('');
						$("#txtrohsimg").val('');
						$("#txtmadeinimg").val('');
						
						$("#txtnewprod").val('');
						$("#txtnewproddescr").val('');
						$("#txtcoupling").val('');
						$("#txtcouplinginserloss").val('');
						
						$("#txtcouplingisolat").val('');
						$("#txtcouplingfreqstart").val('');
						$("#txtcouplingfreqstop").val('');
						
						$("#duplextxrx").val('');
						$("#duplextxrxinserlosstx").val('');
						$("#duplextxrxinserlossrx").val('');
						$("#duplexnoiserx").val('');
						$("#duplexisolarxtx").val('');
						$("#duplexfreqstop").val('');
						
						$("#duplexfreqstart").val('');
						
						$("#txtbandwidth").val('');
						$("#txtbandwidthinserloss").val('');
						$("#txtbandwidthfreqstart").val('');
						$("#txtbandwidthfreqstop").val('');
						$("#txtsplitloss").val('');
						$("#txtsplitinserloss").val('');
						$("#txtsplitnroway").val('');
						$("#txtsplitfreqstart").val('');
						$("#txtsplitfreqstop").val('');
						primerpaso(	$("#idtablabelbranch").val());					
									
				  }
				  else {
					reject();
					toastr["error"]("Error when storing data...", "");	
				  }
				};

			
			})
		//fin enviar datos a procesar
		
		
	}
   
 function add_list_bandrf()
 {
	 
	/* txtbandrf
txttypeclass
cmbportinul
cmbportindl
cmbportoutdl
txtulgainband
txtdlgainband
txtulmaxpwrband */ 

var idbandrf = $('#txtbandrf').val();
var vtxtbandrf  = $.trim($('#txtbandrf option:selected').text());
var vtxttypeclass = $('#txttypeclass').val();
var vcmbportinul = parseFloat($('#cmbportinul').val());
var vcmbportindl = parseFloat($('#cmbportindl').val());
var vcmbportoutdl = parseFloat($('#cmbportoutdl').val());
var vcmbportoutul = parseFloat($('#cmbportoutul').val());


var vcmbportinulnom = $.trim($('#cmbportinul option:selected').text());
var vcmbportindlnom = $.trim($('#cmbportindl option:selected').text());
var vcmbportoutdlnom = $.trim($('#cmbportoutdl option:selected').text());
var vcmbportoutulnom = $.trim($('#cmbportoutul option:selected').text());

var vtxtulgainband = parseFloat($('#txtulgainband').val());
var vtxtdlgainband = parseFloat($('#txtdlgainband').val());

var vtxtulmaxpwrband = parseFloat($('#txtulmaxpwrband').val());

var vtxtdlmaxpwrband = parseFloat($('#txtdlmaxpwrband').val());

	
		 if (idbandrf=="" || vtxttypeclass=="" || vcmbportinul=="" || vcmbportindl=="" || vcmbportoutdl=="" || vtxtulgainband=="" || vtxtdlgainband=="" || vtxtulmaxpwrband=="" || vcmbportoutul==""  )
		 //||  isNaN(vtxtbandrf)==true  || isNaN(vtxttypeclass)==true  || isNaN(vcmbportinul)==true  || isNaN(vcmbportindl)==true || isNaN(vcmbportoutdl)==true || isNaN(vtxtulgainband)==true || isNaN(vtxtdlgainband)==true || isNaN(vtxtulmaxpwrband)==true  || isNaN(vcmbportoutul)==true    )
		  {
				alert('missing complete data');
		  }
		  else
		  {
			 
					tabla_gain_rf.push({						
									txtbandrf: vtxtbandrf,									
									txttypeclass: vtxttypeclass,								
									cmbportinulnom: (vcmbportinulnom),
									cmbportoutulnom: (vcmbportoutulnom),
									txtulgainband: parseFloat(vtxtulgainband),
									txtulmaxpwrband: parseFloat(vtxtulmaxpwrband),
									cmbportindlnom: (vcmbportindlnom),									
									cmbportoutdlnom: (vcmbportoutulnom),								
									txtdlgainband: parseFloat(vtxtdlgainband),									
									txtdlmaxpwrband: parseFloat(vtxtdlmaxpwrband),
									idbandrf: idbandrf,									
									cmbportinul: parseFloat(vcmbportinul),
									cmbportoutul: parseFloat(vcmbportoutul),								
									cmbportindl: parseFloat(vcmbportindl),									
									cmbportoutdl: parseFloat(vcmbportoutdl)	
									
									
						   });
						
							list_tabla_gain_rf();
						   
						   /// Limpia variables
						   
							$('#txtbandrf').val('');
							$('#txttypeclass').val('');
							$('#cmbportinul').val('');
							$('#cmbportindl').val('');
							
							$('#cmbportoutdl').val('');
							$('#cmbportoutul').val('');
							
								
							$('#txtulgainband').val('');
							$('#txtdlgainband').val('');
							
							$('#txtulmaxpwrband').val('');
							$('#txtdlmaxpwrband').val('');
							
		  }
 }
 
 function list_tabla_gain_rf()
 {
	
		var jname ="";
		var v_templistchannel="";
			//var html = '<table class="table  table-striped table-sm ">';
			
			
			var html = '<table class="table table-bordered  table-striped table-sm text-center "><tbody>';
												
				 html += '<tr>';
				 var cantcabez = tabla_gain_rf[0];
				 
				 for( var j in  cantcabez) {
					 
					 jname= j
					 if (j=='txtbandrf')
					 {
						 jname='Band';
					 }
					 if (j=='txttypeclass')
					 {
						 jname='Class';
					 }
					 if (j=='cmbportinulnom')
					 {
						 jname='Port IN UL';
					 }
					  if (j=='cmbportoutulnom')
					 {
						 jname='Port Out UL';
					 }
					 if (j=='txtulgainband')
					 {
						 jname='UL Gain';
					 }
					  if (j=='txtulmaxpwrband')
					 {
						 jname='UL Max Pwr';
					 }
					 
					 
					  if (j=='cmbportindlnom')
					 {
						 jname='Port In DL';
					 }
					  if (j=='cmbportoutdlnom')
					 {
						 jname='Port Out DL';
					 }
					 if (j=='txtdlgainband')
					 {
						 jname='DL Gain';
					 }
					  if (j=='txtdlmaxpwrband')
					 {
						 jname='DL Max Pwr';
					 }
					
					 if (j == "idbandrf" || j == "cmbportinul"   || j == "cmbportoutul" || j == "cmbportindl" || j == "cmbportoutdl")
					 {
						 // html += '<th>' + jname + '</th>';
					 }
					 else
					 {
						   html += '<th>' + jname + '</th>';
					 }	 
								
					 
				
				
				 }
				  html += '<th>Action</th>';
				 html += '</tr>';
				 for( var i = 0; i < tabla_gain_rf.length; i++) {
				  html += '<tr>';
				  
				  if (v_templistchannel != '')
				  {
					v_templistchannel = v_templistchannel + "#";  
				  }
				  console.log(tabla_gain_rf[i]);
				  for( var j in tabla_gain_rf[i] ) {
					 
					
						 if (j == "idbandrf" || j == "cmbportinul"   || j == "cmbportoutul" || j == "cmbportindl" || j == "cmbportoutdl")
						 {
							
						 }
						 else
						 {
							   	html += '<td>' + tabla_gain_rf[i][j]  +' </td>';	  
								
						 }	 
						 v_templistchannel = v_templistchannel  + tabla_gain_rf[i][j] + "|";		
					
					
					
				  }
				  html += '<td>  <a href="#" onclick="borrar_array_bandrf('+i+')"> <i class="fas fa-trash-alt"></i> Del</a> </td>';	  
				  html += '</tr>';
				 }
				 html += '</table>';
				 v_templistchannel = v_templistchannel + "#";  
				 console.log(v_templistchannel);
				 	$('#divlist_tabla_gain_rf').html(html);
					$('#divlist_tabla_gain_rftexto').val(v_templistchannel);
				
		
	
 }
 
 	 function borrar_array_bandrf	 (idborrarch)
	 {
		    tabla_gain_rf.splice(idborrarch, 1); 
			
			$('body,html').stop(true,true).animate({				
				scrollTop: $("#divlist_tabla_gain_rf").offset().top
			},1);
			
			list_tabla_gain_rf();
			$('body,html').stop(true,true).animate({				
				scrollTop: $("#divlist_tabla_gain_rf").offset().top
			},1);
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
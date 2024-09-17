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


	///////////////////////////////////////////////////////////////////////////////////////////
	if($_POST)
	{

		//levantamos los valores ingresamos para modificar
		$v_elciuselect= $_REQUEST['txtlistcius'];
		$v_select_script = $_REQUEST['losscriptmam'];
		$v_select_steps = $_REQUEST['losstepmmam'];
		$v_select_category = $_REQUEST['losscriptsteps'];
		$v_select_categorytipe = $_REQUEST['lascategoriastipos'];

		$v_select_band = $_REQUEST['lasbandas'];
		$v_select_uldl = $_REQUEST['losuldl'];
 
		////txtfpgafile alias de V_integer
 		$v_txtfpgafile = $_REQUEST['txtfpgafile'];
        //// txtmicrofile alias v_double
		$v_txtmicrofile = $_REQUEST['txtmicrofile'];
		// txtethfile - alias v_string
		$v_txtethfile = $_REQUEST['txtethfile'];
		/// txtfpgafas -- alias v_boolena
		$v_txtfpgafas = $_REQUEST['txtfpgafas'];
		/// txtfpgafas -- alias v_boolena
	 
/*
		if ($v_txtfpgafile=="")
		{
			$v_txtfpgafile="NULL";
		}
		if ($v_txtmicrofile=="")
		{
			$v_txtmicrofile="NULL";
		}
		if ($v_txtethfile=="")
		{
			$v_txtethfile="NULL";
		}
		if ($v_txtfpgafas=="")
		{
			$v_txtfpgafas="NULL";
		}
	 
	 
 
		$vidrefparameter = "NULL";

		if ($v_select_band == "" && $v_select_uldl == "" )
		{


			$query_lista = "select distinct idreference from  fas_tree_product_references where idproduct = ".$v_elciuselect." and idscripttype=".$v_select_script." and fas_tree_product_references.iduniquebranch = '".$v_select_steps."' ";
			$data = $connect->query($query_lista)->fetchAll();	
			foreach ($data as $rowmf) {			
				$vidrefparameter = $rowmf['idreference'];
			 }

			 $armoquery=" call sp_insert_fas_income_integral_sinidbanuldl_sinref(".$v_elciuselect.",".$v_select_script.",'".$v_select_steps."',".$v_select_category.",".$v_select_categorytipe.",".$v_txtfpgafile.",".$v_txtmicrofile.",'".$v_txtethfile."',null,".$v_txtfpgafas.") ";
				
			
		}
		else
		{

			$query_lista = "select distinct idreference from  fas_tree_product_references where idproduct = ".$v_elciuselect." and idscripttype=".$v_select_script." and fas_tree_product_references.iduniquebranch = '".$v_select_steps."' and fas_tree_product_references.idband = ".$v_select_band." and uldl = ".$v_select_uldl;
			$data = $connect->query($query_lista)->fetchAll();	
			foreach ($data as $rowmf) {			
				$vidrefparameter = $rowmf['idreference'];
			 }

			$armoquery=" call sp_insert_fas_income_integral_by_idbanuldl_sinref(".$v_elciuselect.",".$v_select_script.",'".$v_select_steps."',".$v_select_category.",".$v_select_categorytipe.",".$v_select_band.",". $v_select_uldl.",".$v_txtfpgafile.",".$v_txtmicrofile.",'".$v_txtethfile."',null,".$v_txtfpgafas.") ";
			
		}

		echo "------------------------------<br>El Query a Ejecutar:".$armoquery;
		echo "<br>------------------------------<br>";
		$connect->query($armoquery); 
	 
*/
		/*

		$vuserfas = $_SESSION["b"];
		
		$vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
		$vaccionweb="INSERT Income";
		$vdescripaudit="NEW Income integral".$vuserfas;
		$sentenciaudit = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
		$sentenciaudit->bindParam(':userfas', $vuserfas);								
		$sentenciaudit->bindParam(':menuweb', $vmenufas);
		$sentenciaudit->bindParam(':actionweb', $vaccionweb);
		$sentenciaudit->bindParam(':descripaudit', $vdescripaudit);
		$sentenciaudit->bindParam(':textaudit', $armoquery);
		$sentenciaudit->execute();
		*/

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
<form name="frma" id="frma"  method="post" class="form-horizontal"  >
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
            <h1>Part Number Information </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Part Number Information</li>
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
		  <div class="container-fluid card">
			<br>
		  <div class=" row" > 
				<div class="  col-md-6 " > 
					 Part Number Model:<br>
				 
          				  <select class="js-example-basic-single col-sm-8" required  id="txtlistcius" name="txtlistcius">
						  </select> 
				 </div>

			   <div class="  col-md-6 " > 
				   
					 
						 
			   Part number Model to compare:<br>


								<select class="js-example-basic-single col-sm-8" required  id="txtlistciusorig" name="txtlistciusorig">
								</select>
						 
				</div>
			</div>
			<br>	
			</div>	


         

        </section>
	 
          <!-- /.col -->
        </div>
      </div>
      <!-- /.timeline -->

    </section>
    <!-- /.content -->
	
	<section class="content">
    <div class="container-fluid">
      <div class="row">

       
	  <div class="container-fluid card">
			<br>
		  <div class=" row" > 
				<div class="  col-md-6 " > 
					<div id='divinfo1' name= 'divinfo1'>
				 		 
					</div>
					<div id='divinfo2' name= 'divinfo2'>
				 		 
					</div>	
					<div id='divinfo3' name= 'divinfo3'>
				 		 
					</div>	
					<div id='divinfo4' name= 'divinfo4'>
				 		 
					</div>		
					<div id='divinfo5' name= 'divinfo5'>
				 	 
					</div>		
					<div id='divinfo6' name= 'divinfo6'>
				 		 
					</div>		
				 </div>

			   <div class="  col-md-6 " > 
			   <div id='divinfo1comp' name= 'divinfo1comp'>
				 		 
					</div>
					<div id='divinfo2comp' name= 'divinfo2comp'>
				 	 
					</div>	
					<div id='divinfo3comp' name= 'divinfo3comp'>
				 		 
					</div>	
					<div id='divinfo4comp' name= 'divinfo4comp'>
				 		 
					</div>	
					<div id='divinfo5comp' name= 'divinfo5comp'>
				 		 
					</div>	
					<div id='divinfo6comp' name= 'divinfo6comp'>
				 	 
					</div>			 
						 
				</div>
			</div>
			<br>	

 	  </div>
	</div>	
	</section>	
  <!-- /.content-wrapper -->
  </div>	
  </section>	
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

<script src="plugins/datatables/jquery.dataTables.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>

<link href="css/select2.css" rel="stylesheet" />
<link href="css/testcssselector.css" rel="stylesheet" />
   <script src="plugins/sweetalert2/sweetalert2.min.js"></script>

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
function replicame_income()
{
	 var envioareplicar = 'S';
	if ($("#txtlistcius").val() == '')
	{
		envioareplicar = 'N';
		toastr.warning("need to select product where to replicate");
	}
	if ($("#txtlistciusorig").val() == '')
	{
		envioareplicar = 'N';
		toastr.warning("missing select product: origin ");
	}
	if (($("#txtlistciusorig").val()  != $("#txtlistcius").val()))
	{
		if (envioareplicar == 'S')
		{
			/// AJAX para REPLICAR
			//console.log('Replicando');
			toastr.info("Starting replica");
			$.ajax
			({ 
				url: 'repliincomeintegral.php?idfrom='+$("#txtlistciusorig").val()+'&idto='+ $("#txtlistcius").val(),			
				type: 'post',
				async:true,
                cache:false,
				success: function(data)
				{
					toastr.success("replicated ok.!");
				}
			});
			//// fin
		}
	}
	else
	{
		toastr.warning("missing select product ");
	}
}
	 

function formatRepo (repo) {
	
  if (repo.loading) {
    return repo.text;
  }

  var $container = $(
    "<div class='select2-result-repository clearfix'>" +
      "<div class='select2-result-repository__avatar'><img src='img/imgciu.jpg' /></div>" +
      "<div class='select2-result-repository__meta'>" +
        "<div class='select2-result-repository__title'></div>" +
        "<div class='select2-result-repository__description'></div>" +      
      "</div>" +
    "</div>"
  );

  $container.find(".select2-result-repository__title").text(repo.text);
  $container.find(".select2-result-repository__description").html(repo.description+' ** ' + repo.link);
  $container.find(".select2-result-repository__forks").append("101" + " Forks");
  $container.find(".select2-result-repository__stargazers").append("102" + " Stars");
  $container.find(".select2-result-repository__watchers").append("103" + " Watchers");
//  console.log(repo.text);
  return $container;
}

function formatRepoSelection (repo) {
	// console.log('1' + repo.text);
  return repo.full_name || repo.text;
}	
		
	  	 // AutoComplete de CUIS version TOP

$('#txtlistcius').select2({
 ajax: {
    url: "ajax_list_cuisbyaddciucustom.php",
    dataType: 'json',
    delay: 2,
    data: function (params) {
      return {
        q: params.term, // search term
        page: params.page
      };
    },
    processResults: function (data) {
      // Transforms the top-level key of the response object from 'items' to 'results'
      return {
        results: data.items
      };    
    },
    cache: false
  },
  placeholder: 'Search CIU',
  minimumInputLength: 1 ,
  templateResult: formatRepo,
  templateSelection: formatRepoSelection
});

$('#txtlistciusorig').select2({
 ajax: {
    url: "ajax_list_cuisbyaddciucustom.php",
    dataType: 'json',
    delay: 2,
    data: function (params) {
      return {
        q: params.term, // search term
        page: params.page
      };
    },
    processResults: function (data) {
      // Transforms the top-level key of the response object from 'items' to 'results'
      return {
        results: data.items
      };    
    },
    cache: false
  },
  placeholder: 'Search CIU',
  minimumInputLength: 1 ,
  templateResult: formatRepo,
  templateSelection: formatRepoSelection
});

 

// fin// AutoComplete de CUIS version TOP

   
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

   function filtrartodostep( idtyp, valuemm)
	{
	 /// 1 = script
	 if (valuemm != '')
	 {
			
			if (idtyp==1)
			{
				var armando_tabla ="";
					$.ajax({
							url: 'listinstance_cat_type_income_addref.php?idtyp='+idtyp+'&valuemm='+valuemm ,										
							cache:false,
							success: function(respuesta) {
								
						//		console.log('HOLa');
							

								var returnedData = JSON.parse(respuesta);
							//	console.log(returnedData);
							$('#lascategoriastipos').empty();
							$('#lascategoriastipos').append($('<option />', {
												value: '',
												text: ' - Select - '
											}));
						
								$.each(returnedData.data, function (index, value) {
											$('#lascategoriastipos').append($('<option />', {
												value: value.in_instance,
												text: value.description
											}));
											
										});

						
							},
							error: function() {
								console.log("No se ha podido obtener la información");
							}
							
						});
			}
		 
	 }


									
									
									
	}


   
function hablitame(qcontrol)
{
	
	var qcontroltel = qcontrol.replace("div", "");
	if ($("#"+qcontrol).hasClass("d-none")==true)
	{
		$("#"+qcontrol).removeClass('d-none');
	
		$("#"+ qcontroltel+'r').removeAttr("disabled");
		$("#btn"+qcontroltel).removeClass('btn-default');
		$("#btn"+qcontroltel).addClass('btn-primary');
	}
	else
	{
		$("#"+qcontrol).addClass('d-none');
		////$("#"+ qcontroltel).prop('disabled', 'disabled');
		$("#btn"+qcontroltel).removeClass('btn-primary');
		$("#btn"+qcontroltel).addClass('btn-default');
	}
}

function update_selected_ciu()
{
  if ( $("#txtlistcius").val() !='' && $("#lascategoriastipos").val() !='' && $("#losscriptsteps").val() !='' && $("#losstepmmam").val() !='' && $("#losscriptmam").val() !=''   )
  {
    $('#frma').submit();
  }
  else
  {
     toastr.warning("missing complete data ");
  }
	
}
   
$("#txtlistcius").change(function() 
	{
		console.log('a_b_c' + + $("#txtlistcius").val());
		show_information_product('divinfo2', $("#txtlistcius").val());
		show_information_product_objband('divinfo1', $("#txtlistcius").val());

		show_information_product_label('divinfo3', $("#txtlistcius").val());

		show_information_product_attribut('divinfo4', $("#txtlistcius").val());

		show_information_product_measu('divinfo5', $("#txtlistcius").val());
		show_information_product_instru('divinfo6', $("#txtlistcius").val());
	}
);

///////txtlistciusorig
$("#txtlistciusorig").change(function() 
	{
		console.log('a_b_c compara:' + + $("#txtlistciusorig").val());
		show_information_product('divinfo2comp', $("#txtlistciusorig").val());
		show_information_product_objband('divinfo1comp', $("#txtlistciusorig").val());

		show_information_product_label('divinfo3comp', $("#txtlistciusorig").val());

		show_information_product_attribut('divinfo4comp', $("#txtlistciusorig").val());

		show_information_product_measu('divinfo5comp', $("#txtlistciusorig").val());
		show_information_product_instru('divinfo6comp', $("#txtlistciusorig").val());

		
	}
);




function show_information_product_attribut(v_tempdiv, v_idproduct)
{


	var armando_tabla= '';
	var laurl='crudproducts_ajaxattribut.php?filtmm=Y&p0='+v_idproduct ;
	console.log(laurl);
								$.ajax({
										url: laurl,										
										 cache:false,
										success: function(respuesta) {
																				
											console.log(respuesta);
										$('#msjwaitline ').hide();
											$('#'+v_tempdiv).html(""+respuesta);
											return false;
										},
										error: function() {
											console.log("No se ha podido obtener la información");
											$('#'+v_tempdiv).html("");
										}
									});
									
									return false;
}


function show_information_product_instru(v_tempdiv, v_idproduct)
{


	var armando_tabla= '';
	var laurl='crudproducts_ajaxinfoprodlinstru.php?filtmm=Y&p0='+v_idproduct ;
	console.log(laurl);
								$.ajax({
										url: laurl,										
										 cache:false,
										success: function(respuesta) {
																				
											console.log(respuesta);
										$('#msjwaitline ').hide();
											$('#'+v_tempdiv).html(""+respuesta);
											return false;
										},
										error: function() {
											console.log("No se ha podido obtener la información");
											$('#'+v_tempdiv).html("");
										}
									});
									
									return false;
}

function show_information_product_measu(v_tempdiv, v_idproduct)
{


	var armando_tabla= '';
	var laurl='crudproducts_ajaxinfoprodmesasurint.php?filtmm=Y&p0='+v_idproduct ;
	console.log(laurl);
								$.ajax({
										url: laurl,										
										 cache:false,
										success: function(respuesta) {
																				
											console.log(respuesta);
										$('#msjwaitline ').hide();
											$('#'+v_tempdiv).html(""+respuesta);
											return false;
										},
										error: function() {
											console.log("No se ha podido obtener la información");
											$('#'+v_tempdiv).html("");
										}
									});
									
									return false;
}

function show_information_product_label(v_tempdiv, v_idproduct)
{


	var armando_tabla= '';
	var laurl='crudproducts_ajaxinfoprodlbl.php?filtmm=Y&p0='+v_idproduct ;
	console.log(laurl);
								$.ajax({
										url: laurl,										
										 cache:false,
										success: function(respuesta) {
																				
											console.log(respuesta);
										$('#msjwaitline ').hide();
											$('#'+v_tempdiv).html(""+respuesta);
											return false;
										},
										error: function() {
											console.log("No se ha podido obtener la información");
											$('#'+v_tempdiv).html("");
										}
									});
									
									return false;
}

function show_information_product(v_tempdiv, v_idproduct)
{


	var armando_tabla= '';
	var laurl='crudproducts_ajaxinfoprod.php?filtmm=Y&p0='+v_idproduct ;
	console.log(laurl);
								$.ajax({
										url: laurl,										
										 cache:false,
										success: function(respuesta) {
																				
											console.log(respuesta);
										$('#msjwaitline ').hide();
											$('#'+v_tempdiv).html(""+respuesta);
											return false;
										},
										error: function() {
											console.log("No se ha podido obtener la información");
											$('#'+v_tempdiv).html("");
										}
									});
									
									return false;
}

function show_information_product_objband(v_tempdiv, v_idproduct)
{


	var armando_tabla= '';
	var laurl='crudproducts_ajaxinfoprodobjb.php?filtmm=Y&p0='+v_idproduct ;
	console.log(laurl);
								$.ajax({
										url: laurl,										
										 cache:false,
										success: function(respuesta) {
																				
											console.log(respuesta);
										$('#msjwaitline ').hide();
											$('#'+v_tempdiv).html(""+respuesta);
											return false;
										},
										error: function() {
											console.log("No se ha podido obtener la información");
											$('#'+v_tempdiv).html("");
										}
									});
									
									return false;
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
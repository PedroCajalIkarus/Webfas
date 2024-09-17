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
	//		echo "***********hola".time() - $_SESSION["timeout"]."----".$sessionTTL."--inactividad:".$inactividad."-timeout". $_SESSION["timeout"] ;
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
	
	
   <link rel="stylesheet" href="themestreecss/default2/style.css">
	
		<style>
	body
{
  font-family: Arial, Helvetica, sans-serif;
  font-size:12px;
}
a:link {
  color:#000000;
}

a:visited {
 color:#000000;
}

a:hover {
  color:#000000;
}

a:active {
 color:#000000;
}

.card-headermarco
{
	  font-family: Arial, Helvetica, sans-serif;
  font-size:14px;
  border-style: solid;
  border-color:#ffffff;
  border-width: 1px;
}

.example1_wrapper
{
 border-style: solid; 
  border-width: 2px;	
}

textarea.form-control {
    height: 100%;
}


.tree
{ 
    margin: 6px;
    margin-left: -20px;
}

.tree li {
    list-style-type:none;
    margin:0;
    padding:6px 5px 0 5px;
    position:relative
}
.tree li::before, 
.tree li::after {
    content:'';
    left:-20px;
    position:absolute;
    right:auto
}
.tree li::before {
    border-left:1px solid #000;
    bottom:50px;
    height:100%;
    top:0;
    width:1px
}
.tree li::after {
    border-top:1px solid #000;
    height:20px;
    top:25px;
    width:25px
}

.tree li span {
    -moz-border-radius:5px;
    -webkit-border-radius:5px;
    border:1px solid #000;
    border-radius:1px;
    display:inline-block;
    padding:1px 5px;
    text-decoration:none;
    cursor:pointer;
}
.tree>ul>li::before,
.tree>ul>li::after {
    border:0
}
.tree li:last-child::before {
    height:27px
}

.tooltipmarco {
    background-color: #0053a1;
    color:  #ffffff;
    padding: 5px 10px;
    border-radius: 4px;
    font-size: 12px;
	 opacity: 0.9;
  }
  
.clasenegrita
{
	font-weight: bold;
}  
</style>

</head>


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
<form name="frmlabeling" id="frmlabeling"  method="post"  class="form-horizontal needs-validation"  >							
				

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Firmware List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">
Firmware List</li>
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
          <section class="col-lg-3 connectedSortable ui-sortable">
			<div class="card">
     		   <!-- inicio arbol -->
			  
			  
			   <div class="container-fluid">
					 <br>
  <input id="search-input" name="search-input" class="form-control form-control-sm" placeholder="Quick search" />
  <br>
						<div class="ui-widget">
						  <div class="ui-widget-header">
							<b>Family Tree Products</b>
						  </div>
						 
							<br />
						  <div id="tree">
						  </div>
						</div>
					</div>
					
					
			
			  <!-- fin inicio arbol -->
			 
			
			

        </section>
		<section class="col-lg-9 connectedSortable ui-sortable">
		
		<div class="card ">							
			 <div class="container-fluid">
			         <div class="card-header border-0">
						   <h3 class="card-title"> <span name="iconolog" id="iconolog"><i class="fa fa-fw fa-list-alt"></i></span>&nbsp;Firmware History <span id="lblproductsearch" name="lblproductsearch"> </span></h3>
									
						
					</div>
				  <div class="card-body">
				  <p name="msjwaitline" id="msjwaitline" align="center"><img src="img/waitazul.gif" width="100px" ></p>
			
				 	<div id="viewfirmwarelist" name="viewfirmwarelist" class=" " style="">
														
																											
						</div>
						</div>
			</div>
		</div>		
				
				
		 </section>
		 
		 </div>	
		 
		 
          <!-- /.col -->
        </div>
      </div>
      <!-- /.timeline -->

    </section>
    <!-- /.content -->
	
		</form>	
	
  </div>
  <!-- /.content-wrapper -->
  


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
<script src="js/popperparacalibratio.min.js"></script>
  <script type="text/javascript" src="js/jstree.min.js"></script>
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

			
			
			var jsonTreeData = "";

	$.ajax({
				url: 'ajax_list_tree_branchproducts_fw.php',			
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
				
	/////fin document ready			
	});
	
	$('#tree').on("select_node.jstree", function (e, data) { 
	//alert("node_id: " + data.node.id);
//	console.log(data.node);
			mostrar_datos_fw(data.node.id, data.node.text);

	});


	// controlar inactividad en la web	
		$(document).inactivityTimeout({
                inactivityWait: 10000,
                dialogWait: 10,
                logoutUrl: 'logout.php'
            })
	// fin controlar inactividad en la web		
	
	
	 
	function abrirparacrearfirware()
	{
		$("#lbladdbtn").removeClass('d-none');
	}	
   
 
   
   function copyToClipboard(element) {
 var $temp = $("<input>");
 $("body").append($temp);
 $temp.val($(element).html()).select();
 document.execCommand("copy");
 $temp.remove();
}
   
   function copy_caltring(vparamcalstring)
   {
	   var copyTextarea = vparamcalstring;
copyTextarea.select(); //select the text area
document.execCommand("copy"); //copy to clipboard
   }
   
   function habilitar_sitiene_fw(valor_select)
   {
	 //  classfw
	   if( valor_select == 'N')
	   {
		   	$(".classfw").each(function(){
				$(this).attr("disabled", true);
       	   	});
	   }
	   else
	   {
		  $(".classfw").each(function(){
				$(this).attr("disabled", false);
       	   	}); 
	   }
			
			
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
   
   function mostrar_tooltip(iddivamostrar)
{
//console.log('mostrar #tooltipfreq'+iddivamostrar );
			  const reference = document.querySelector('.tooltipmarcolink'+iddivamostrar);
			const popper = document.querySelector('#tooltipfreq'+iddivamostrar);

	//  var button = document.querySelector('#link'+iddivamostrar);
  //var tooltip = document.querySelector('#tooltipfreq'+iddivamostrar);
  
  $('#tooltipfreq'+iddivamostrar).removeClass('d-none');

 Popper.createPopper(reference , popper , {
    placement: 'right',
  });
  

 
}

function ocultar_tooltip(iddivamostrar)
{
//	console.log('ocultar #tooltipfreq'+iddivamostrar );
	  $('#tooltipfreq'+iddivamostrar).addClass('d-none');
}

function buscadatos(qbuscamos)
{
	
}

function save_add_registro_type_fw()
	 {
		
		  ///////// Crear nuevo type de flia de productos
		 var faltandatosflia = 0;
if ($("#txtfpgafasfwadd").val()=="") {contadordefaltantes=1;}
if ($("#txtfpgafwadd").val()=="") {contadordefaltantes=1;}
if ($("#txtucfasfwadd").val()=="") {contadordefaltantes=1;}
if ($("#txtucfwadd").val()=="") {contadordefaltantes=1;}
if ($("#txtetherfwadd").val()=="") {contadordefaltantes=1;}
if ($("#txtetherfasfwadd").val()=="") {contadordefaltantes=1;}
if ($("#txtetherfasfwadd").val()=="") {contadordefaltantes=1;}
	
	
	if (faltandatosflia == 0)
	{		
		$('#lbldatoserrrflia').html("");
		
		 var txtfliaprodtype = $('#idramon').val();		 
	
	
			 var txtfpgafw = $('#txtfpgafasfwadd').val().trim();
			 var txtfpgafasfw = $('#txtfpgafwadd').val().trim();
			 var txtucfw = $('#txtucfasfwadd').val().trim();
			 var txtucfasfw = $('#txtucfwadd').val().trim();
			 var txtetherfw = $('#txtetherfwadd').val().trim();
			 var txtetherfasfw = $('#txtetherfasfwadd').val().trim();
			 var calstringfw = $('#calstringfw').val().trim();
			 
			   var txtfpgacusdescrip = $('#txtfpgacusdescripupg').val().trim();
		   var txtuccusdescrip = $('#txtuccusdescripupg').val().trim();
		   var txtethercusdescrip = $('#txtethercusdescripupg').val().trim();
			
					
				toastr["success"]("processing information..", "");	
		
				$.ajax({
				url: 'ajax_addfw_fasfamilytype.php', 				
				data: "txtfliaprodtype="+txtfliaprodtype+'&txtfpgafw='+txtfpgafw+'&txtfpgafasfw='+txtfpgafasfw+'&txtucfw='+txtucfw+'&txtucfasfw='+txtucfasfw+'&txtetherfasfw='+txtetherfasfw+'&txtetherfw='+txtetherfw+'&calstringfw='+calstringfw+'&txtfpgacusdescrip='+txtfpgacusdescrip+'&txtuccusdescrip='+txtuccusdescrip+'&txtethercusdescrip='+txtethercusdescrip,		
				type: 'post',				
				datatype:'JSON',				
				cache:false,					
				success: function(data, status, xhr) {
					var resultadom = data.resultiu;
					var resulterr = data.erromsj;
				
					if (resultadom =="ok" )
					{
						toastr["success"]("Save OK!", "");	
						//location.reload();
						mostrar_datos_fw( $('#idramon').val()+' ::'+ $("#lblproductsearch").html()) ;
						$("#lbladdbtn").removeClass('d-none');
						$('#lbldatoserrrflia').val("");
						 
					
					}
					else	
					{
						toastr["error"]("Error when storing data..."+resulterr, "");	
						
						$('#lbldatoserrrflia').html("ERROR: <br>"+resulterr);
					}
					return false;	
				
				},
				error: function(xhr, status, error) {
					 console.log(status);
				}
				});
		}	
		else
		{
				toastr["error"]("Error, Data is missing.", "");	
		}
		 ///////////////////////////////////////////////
	 }

function mostrar_datos_fw(splt_a_filtrar, labelshowinfo)
{
	//console.log('recibido:'+ splt_a_filtrar);
	var ressultspli = splt_a_filtrar.split('#');
		$('#msjwaitline ').show();
	$("#lblproductsearch").html(' :: '+labelshowinfo)
	var armando_tabla= '';
								$.ajax({
										url: 'listfirmware_ajaxbks.php?p0='+splt_a_filtrar,										
										 cache:false,
										success: function(respuesta) {
											
											armando_tabla=armando_tabla+respuesta;
											
											armando_tabla=armando_tabla+"</tbody></table>";						
									
						//console.log('abrir div'+idsnaver);
							$('#msjwaitline ').hide();
											$('#viewfirmwarelist').html(""+armando_tabla);
											return false;
										},
										error: function() {
											console.log("No se ha podido obtener la información");
											$('#viewfirmwarelist').html("");
										}
									});
									
	
}
   
</script>
   
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
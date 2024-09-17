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
 <style>
.checkbox  {

    font-size: 14px;
}
.texto8 {
    font-size: 10px;
}
 </style>


  <!-- Content Wrapper. Contains page content -->
  <div class="content">
    <!-- Content Header (Page header) -->
   

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <br>
        <!-- Timelime example  -->
        <div class="row">
		<!-- col-lg-6 connectedSortable ui-sortable -->
          <section class="container-fluid ">

           		<div class="card">
				<div class="card-header ui-sortable-handle" >
               		
				<div class="card">
				  <div class="card-header">
					<h3 class="card-title"> <i class="fa fa-fw fa-list-alt"></i>File Listing </h3>
				

				  
				  <br><br>
				  	<form name="frmlabeling" id="frmlabeling" action="" method="post"  class="form-horizontal needs-validation"  >	


  <div class="form-group row">
    
    <div class="col-sm-5">
      <h3 class="card-title colorazulfiplex"><?php
		if($_REQUEST['vso'] ==""   )
		{
			echo "[]QueryString Error. ";
			exit();
		}
//http://davidstutz.de/bootstrap-multiselect/#templates
	//  echo $_REQUEST['vciu']." -- SN:".$_REQUEST['vsn']; ?>	
 
	
	  
									</h3> 	
					 
    </div>
  </div>
   
   <div class="form-group row">

<table class="table table-striped">
				<?php
				$vso = $_REQUEST['vso'];
			if (	$vso <> "")
			{

				$sql = $connect->prepare("		select distinct idordersfileat,  orders_fileattach.namefileattach from orders_fileattach
				inner join orders_sn on orders_sn.idorders  =  orders_fileattach.idorders 	where so_soft_external   = '".	$vso."'  " );

				 
			
						 //SUMAS FILTRO ESTANDAR
				   //	$sql->bindParam(':vvidpresales', $vvidpo);
					   $sql->execute();
					   $resultadolbl = $sql->fetchAll();
					   $vtiene=0;
						foreach ($resultadolbl as $rowlbl) 
					   {
						$vtiene=1;
						  ?>
						<tr><th>
					 	<?php echo  $rowlbl['namefileattach'];?>
						
						</th>
						<td>  
						<a href='#' onclick="downloafilemm()">
						<i class='fas fa-file-download' style='font-size:20px'></i>
						</a>
						&nbsp;&nbsp;
						<a href='#' onclick="downloafilemm()"><i class='far fa-eye' style='font-size:20px'></i>
					   </a>
							 </td>
						</tr>
						  <?php

					   }
				 
					  
					 
			}


			
				
				?>
				</table>
<br><hr>
    
 
  </div>	
 
 
						
								</form>			
				 
				  
				  
				  </div>
              <!-- /.card-header -->
				  <div class="card-body p-0" style="display: block;">
					<div class="d-md-flex">
						
						
					</div><!-- /.d-md-flex -->
				  </div>
              <!-- /.card-body -->
               </div>
				  
				  
              
				</div>	
				</div>	
					

        </section>
		<section class="col-lg-6 connectedSortable ui-sortable d-none">
		

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
<script type="text/javascript" src="js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="css/bootstrap-multiselect.css" type="text/css"/>	
</body>

<script type="text/javascript">

   
   var refreshIntervalId  =0;
   var refreshIntervalIdbuscaruninfo= 0;
   var tabla_temp_freq= [];
   	var lasfreq_array = [];	
	 	var todasfreq_array = [];	


		 function funcx()
   {
   // your code here
   // break out here if needed
   setTimeout(funcx, 1000);
   }

   
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
			
			 $('#example-getting-started').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true
        });
			 
			 
			
 
   
        $('#example-selectAll-all').on('click', function() {
            $('#example-getting-started').multiselect('selectAll', false);
            $('#example-getting-started').multiselect('updateButtonText');
        });
		
		
		  $('#example-selectAll-deselect').on('click', function() {
            
			 $('#example-getting-started').multiselect('deselectAll', false);
            $('#example-getting-started').multiselect('updateButtonText');
        });
		
		
		$("#txtcant").val(1);
		
	});
	

	// controlar inactividad en la web	
		$(document).inactivityTimeout({
                inactivityWait: 10000,
                dialogWait: 10,
                logoutUrl: 'logout.php'
            })
	// fin controlar inactividad en la web		
	
	 /* requesting data */
     		
	function send_to_print(idusercreator)
	{
		var controlador ='S';
		
		if (  $("#txtispassive").val() =="S" && $("#templistagainuldl").val()  =='' )
		{
			//	alert('missing complete frequencies');
				toastr["error"]("Missing complete frequencies...", "");		
				controlador ='N';
		}			
		
		if (controlador ='S')
		{
				$("#b4").addClass('d-none');
				
				if ( $("#cmbstationuser").val() != "" )
				{
				// listar para grabarrr
					$("#btnsendprint").prop('disabled', true);
					$("#b1").removeClass('d-none');
					// Código a ejecutar
						
					var res = $("#cmbstationuser").val().split("#");
			

					$("input[name=chklbl]:checked").each(function() {

					////  alert($(this).val());
						/// verificamos la cantida de et a imprimir
						var elchksele = $(this).val();
						var elchkinstancecant=0;
						if ($("#txtcant"+elchksele).val()>0)
						{
							//alert( $("#txtcant"+elchksele).val());
							/// Procesamos cada SN....
							elchkinstancecant= $("#txtcant"+elchksele).val();
							/// comienzo a recorrer los SN
							$.each($('#example-getting-started').val(), function(index, value)
							{
							//	console.log(value);
									var vbrach=elchksele;				
									
									var vv_param_json1 = '{"sn":"'+value+'","ciu":"'+$('#txtciu').val()+'","quantity":'+elchkinstancecant+'}';
									var myObject = new Object();
								
									myObject.sn = value; ///$('#txtsn').val();
									myObject.ciu = $('#txtciu').val();
									myObject.quantity = elchkinstancecant;
									
									if (  $("#txtispassive").val() =="S" )
									{
										myObject.freq = todasfreq_array ;
									//	vbrach='032033035';
									}
									else
									{
									///	vbrach='032033034';
									}
												
									var myString = JSON.stringify(myObject);
									console.log (myString);
								
									//Enviamos los datos a procesar
										return new Promise(function(resolve, reject) {
												var formData = new FormData();
										var req = new XMLHttpRequest();
										//consulta si devolvio el Scan Device
										formData.append("idb", res[0]);
										formData.append("ids", res[1]);
										formData.append("idu", idusercreator );
										
										formData.append("iduserto", res[2]);
										formData.append("idbranch", vbrach);
										
										formData.append("idquantitybybranh", elchkinstancecant);
										formData.append("idsnbybranh", value);
										formData.append("idciubybranh", $('#txtciu').val());

										//accion 7. enviar para imprimir.
										formData.append("idaccionweb", 7);
										req.open("POST", "fasclient_query.php");
										req.send(formData);
										
										$("#iddivrun").removeClass('d-none');
										
										
											req.onload = function() {
											if (req.status == 200) {
														$("#b2").removeClass('d-none');
														$("#b3").removeClass('d-none');
															
														$("#b2").removeClass('d-none');
														setTimeout(function() {
															$("#b2").fadeOut(1500);
														},1500);
							//	setTimeout(function(){ $('#msjwaitlineok').hide(); }, 10000);
													
														$("#b1").addClass('d-none');
													var losresultado = req.response.split("#");
													console.log('resultado del RUN:'+ req.response+'--'+losresultado[0].replace('"',''));		
														if(losresultado[0]=='"error"')
														{
															$("#iddivrun").html('<p class="text-danger"><b>Json string error.</b></p>');
														}
														else
														{
														esperar_runinfo(idusercreator, losresultado[1]);	
														}
														
														resolve(JSON.parse(req.response));
													 
														//funcx(); es un delap de 300miliseg
												
											}
											else {
												reject();
												$("#b1").addClass('d-none');
											}
											};

										
										})
									//fin enviar datos a procesar
									});
									// FIN IF de sn
							
						}


					});
				
				
					
					
					}
					//fin controlador					
					else
					{
						//alert('select station and quantity');
						toastr["error"]("select station and quantity...", "");		
					}	
		}
	}	


function add_freq()
	{
		var v_txtfstart = parseFloat($('#txtfstart').val());
		var v_txtfstop = parseFloat($('#txtfstop').val());
	
		
		 if (v_txtfstart=="" || v_txtfstop=="" || isNaN(v_txtfstart)==true  || isNaN(v_txtfstop)==true   )
		  {
				alert('error');
		  }
		  else
		  {
			  // Agredo los 4 al Array.
			  
			   var v_loencontre_ch = 0;				
					 $.each(tabla_temp_freq, function (i, value) {
						if (value.freqstart == v_txtfstart)
						{
							// Lo encontre actualizo datos.
							v_loencontre_ch = 1;							
						}
						if (value.freqstop == v_txtfstop)
						{
							// Lo encontre actualizo datos.
							v_loencontre_ch = 1;						
						}
					
					
					}); 
					if ( v_loencontre_ch == 0)
					{
						
						   tabla_temp_freq.push({						
									freqstart: parseFloat(v_txtfstart),
									freqstop: parseFloat(v_txtfstop)
						   });
						   tabla_temp_freq_list();
						   
						   /// Limpia variables
						   
							$('#txtfstart').val('');
							$('#txtfstop').val('');
							
							  $("#txtfstop").focus();
							
		
					}
			  
		  }
		
	}

function tabla_temp_freq_list()
	{
		var jname ="";
			
		var v_templistchannel="";
			var html = '<br><table class="table  table-striped table-sm ">';
			 
				 html += '<tr><th colspan=2><b>List of frequencies</b></th></tr><tr>';
				 var cantcabez = tabla_temp_freq[0];
				 
				 for( var j in  cantcabez) {
					 
					 jname= j
					 if (j=='freqstart')
					 {
						 jname='Freq Start';
					 }
					 if (j=='freqstop')
					 {
						 jname='Freq Stop';
					 }
								
					 
				  html += '<th>' + jname + '</th>';
				
				 }
				//  html += '<th>Action</th>';
				 html += '</tr>';
				 for( var i = 0; i < tabla_temp_freq.length; i++) {
				  html += '<tr>';
				  
				  if (v_templistchannel != '')
				  {
					v_templistchannel = v_templistchannel + "#";  
				  }
				   	var lasfreq_array = [];	
				
				  for( var j in tabla_temp_freq[i] ) {
					 
						html += '<td>' + tabla_temp_freq[i][j]  +' MHz</td>';	  
						v_templistchannel = v_templistchannel  + tabla_temp_freq[i][j] + "|"
						lasfreq_array.push( tabla_temp_freq[i][j] ==''?null:tabla_temp_freq[i][j]  );
					
					
				  }
				//  html += '<td>  <a href="#" onclick="borrar_array_uldl('+i+')"> <i class="fas fa-trash-alt"></i> Del</a> </td>';	  
				  html += '</tr>';
				 }
				 html += '</table>';
				 v_templistchannel = v_templistchannel + "#";  
				 console.log(v_templistchannel);
				 	$('#tablatempfreq').html(html);
					$('#templistagainuldl').val(v_templistchannel);
					todasfreq_array.push (lasfreq_array);
		
	}

	function habilitarcantidad(idnamechkbox)
	{
		//if chklbl
	//	console.log( idnamechkbox);
	//	$("#txtcant"+idnamechkbox).removeClass('d-none');
		if ($("#chklbl"+idnamechkbox).is(':checked'))	
	{
		///	console.log("S") ;
			$("#txtcant"+idnamechkbox).removeClass('d-none');
		}
		else
		{
	//		console.log("N") ;
			$("#txtcant"+idnamechkbox).addClass('d-none');
		}
		
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
			formData.append("idaccionweb", 8);
			
			$("#txterror").html('');
									$("#diverror").hide();
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
						 console.log('desde esperando resultado del RUN:'+ req.response+'--'+losresultado[2]);
						///	$('#idpetitionrun').val(losresultado[1].replace('"',''));
							//mostrar_log(req.response.substring(4, 12));
							if (losresultado[2].replace('"','') !='')
							{
								$("#btnsendprint").prop('disabled', false);
								$("#b4").removeClass('d-none');
								
							
							  setTimeout(function() {
								$("#b3").fadeOut(1500);
							},1500);
							
							  setTimeout(function() {
								$("#b4").fadeOut(1500);
							},4500);
							
								
								clearInterval(refreshIntervalIdbuscaruninfo);
								
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
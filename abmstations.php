<!DOCTYPE html>
<?php 

// Desactivar toda notificación de error
//error_reporting(0);
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
	/// FIN DETECTO PERMISOS EN PAG!
	
	
	$status = $connect->getAttribute(PDO::ATTR_CONNECTION_STATUS);
	
	if ($status !="Connection OK; waiting to send.")
	{
	
		header("Location: http://".$ipservidorapache."/".$folderservidor."/errorconect.php");
		exit;
		
	}
	
	
	$vviduser =$_REQUEST["iduser"];
	$vvidbusi= $_REQUEST["idb"];
	$vvnameiser= $_REQUEST["nn"];
		$habilitnewuser= $_REQUEST["newu"]; 

		$idstationsamodificar= $_REQUEST["id"]; 
		if ($idstationsamodificar != "")
		{
						$sql = $connect->prepare("select * from business_station where idstation =  ".$idstationsamodificar);
						$sql->execute();
						
						$resultadomodif = $sql->fetchAll();
						 foreach ($resultadomodif as $rowmm) 
						 {
							$v_idbusiness 		=	$rowmm['idbusiness'];
							$v_idstation		=	$rowmm['idstation'];
							$v_ipgen1 			=	$rowmm['ipgen1'];
							$v_ipgen2			=	$rowmm['ipgen2'];
							$v_ipstation		=	$rowmm['ipstation'];
							$v_namestation 		=	$rowmm['namestation'];				
							$v_printerzebra 	=	$rowmm['printerzebra'];
							$v_bs_mac_address 	=	$rowmm['bs_mac_address'];
						 }
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
 

  
  <!-- AdminLTE css -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  
  <link rel="shortcut icon" href="fiplexcirculo-01.ico" />
  
  <link rel="stylesheet" href="toastr.css">
 
    <link rel="stylesheet" href="cssfiplex.css">
	
	<style>
	


.users-list>li {
    /* float: left; */
    /* padding: 10px; */
    text-align: center;
    width: 25%;
} 

</style>
	
	
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
            <h1>Station Manager</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Station Manager</li>
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

            <div class="" name="divscrolllog" id="divscrolllog" style="display.">
			<p name="msjwaitline" id="msjwaitline" align="center"><img src="img/waitazul.gif" width="100px" ></p>	
				<div class="card">
                  <div class="card-header">
                    <h3 class="card-title">List Station</h3>

                    <div class="card-tools">
                      <a class="users-list-name" href="abmstations.php?newu=y"> <span class="badge badge-danger">Create New Station</span>
                       </a>
                    </div>
                  </div>
                  <!-- /.card-header -->

                  <div class="card-body p-0">
                    
				  <div class="col-lg-12 connectedSortable ui-sortable">
				  <table id="tablabc" name="tablabc" class="table table-bordered table-striped  table-sm">	
                    <thead>
                    <tr>
                      
                  
					  <th>Name</th>
                      <th >IP</th>
					  <th>Mac Address</th>
					  <th aling="center" ><i class='fa fa-print'></i> Zebra?</th>
					  <th >Action</th>
                      
                    </tr>
                    </thead>
                    <tbody>
					<?php
					
					$sql = $connect->prepare("select * from business_station where active = 'true' order by namestation	");
						$sql->execute();
						$resultado = $sql->fetchAll();
						
						
							
							
							
						 foreach ($resultado as $row) {
							 
						?>
						<tr>
							
							<td> 		<a class="users-list-name" href="abmstations.php?newu=y&id=<?php echo $row['idstation'];?>">
							<?php echo $row['namestation'];?>							</a></td>
							<td ><?php echo $row['ipstation']."";?></td>
							<td>  <?php   echo $row['bs_mac_address'];		?>	</td>
							<td align="center"><?php if ($row['printerzebra'] =="Y") {  echo "<i class='fa fa-print'></i>";} ;?></td>
							<td> <a class="users-list-name" href="abmstations.php?newu=y&id=<?php echo $row['idstation'];?>"> 
									<i class="fa fa-edit"></i>
						 		</a></td>
						</tr>	 
					
						<?php
						 }
				
					
					?>
                     
           
                    </body>
					</table>
					</div>
                    <!-- /.users-list -->
                  </div>
                  <!-- /.card-body -->
                 
                  <!-- /.card-footer -->
                </div>
			</div>
					

        </section>
		<section class="col-lg-6 connectedSortable ui-sortable">
		

				<div class="card">
				<div class="card-header ui-sortable-handle">
               		
					<?php if ($habilitnewuser=="y")
							{
								?>
								<div class="card ">
								<div class="card-header bg-info">
								<h3 class="card-title ">Create New Station</h3>


								<!-- /.card-tools -->
								</div>
								<!-- /.card-header -->
								<div class="card-body">

										<form name="frmlabeling" id="frmlabeling" action="" method="post"  class="form-horizontal needs-validation"  >							

									   <div class="card-body form-row">							   
											<div class="form-group col-md-6 ">
											<label for="exampleInputEmail1">Stations Name:</label>
											<input type="text" value="<?php echo $v_namestation; ?>" name="txtstationame" id="txtstationame" class="form-control" placeholder="Enter Stations Name"  required data-required-message="Stations Name is required.">
										
										 
						 								 			
						 					</div>
											<div class="form-group col-md-6 ">
											<label for="exampleInputEmail1">MAC Address:</label>
											<input type="text" value="<?php echo $v_bs_mac_address; ?>" name="txtmacadd" id="txtmacadd" class="form-control" placeholder="Enter MAC Address"  required data-required-message="MAC Address is required.">
										


											</div>

											<div class="form-group col-md-6 ">
											<label for="exampleInputEmail1">IpStation:</label>
											<input type="text" value="<?php echo $v_ipstation; ?>" name="txxipsation" id="txxipsation" class="form-control" placeholder="Enter IpStation" required oninvalid="setCustomValidity('IpStation required.')" 
								oninput="setCustomValidity('')">
											</div>

											<div class="form-group col-md-6 ">
											<label for="exampleInputEmail1">Ip Generator 1:</label>
											<input type="text" value="<?php echo $v_ipgen1; ?>" name="txtipgen1" id="txtipgen1" class="form-control" placeholder="Enter IpGen1" required oninvalid="setCustomValidity('IpGen1 required.')" 
								oninput="setCustomValidity('')">
											</div>

											<div class="form-group col-md-6 ">
											<label for="exampleInputEmail1">Ip Generator 2:</label>
											<input type="text" value="<?php echo $v_ipgen2; ?>" name="txtipgen2" id="txtipgen2" class="form-control" placeholder="Enter IpGen2" required oninvalid="setCustomValidity('IpGen2 required.')" 
								oninput="setCustomValidity('')">
											</div>
										
										 
											
											 <div class="form-group col-md-6">
											<label for="exampleInputEmail1">Printer Zebra:</label>
											 <select class="form-control" name="txtcategory" id="txtcategory" required oninvalid="setCustomValidity('Category is required.')" oninput="setCustomValidity('')">
												 <option value=""> - Select - </option>
												  <option value="Y" <?php if ( $v_printerzebra=="Y") { echo "selected"; }?>>Yes</option>
											      <option value="N" <?php if ( $v_printerzebra !="Y") { echo "selected"; }?>>No</option>
												   
												  
												  
												  
											</select>
												
										   </div>	
									 
										
										<!-- /.card-body -->
										<div class="card-footer text-right">
										 <?php 
										 	if ($idstationsamodificar == "")
											 {
										 	?>
										  <button type="button" onclick="save_new_registro()" class="btn btn-primary right-align">Create New Station</button>
										  <input type="hidden" value="nuevo" id="txtidmodif" name="txtidmodif">
										  <?php 
										  } 
										  else
										 {
											?>
											<button type="button" onclick="save_new_registro()" class="btn btn-primary right-align">Modify Station</button>
											<input type="hidden" value="<?php echo $idstationsamodificar; ?>" id="txtidmodif" name="txtidmodif">
											<?php 
										 } 
										  ?>
										  
										</div>
											<p class="text-danger" id="lbldatoserrr" id="lbldatoserrr">


								</p>
								</form>			
								</div>
								<hr>
							</div>
								<?php
							}
					
					
					?>
					
					
			 
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
<script src="plugins/datatables/jquery.dataTables.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>

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
			$("#msjwait").hide();		

				 $('#tablabc').DataTable( { "order": [[ 0, "desc" ]], pageLength: 100  } );	

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
	
	
			var tamanyo_password				=	10;			// definimos el tamaño que tendrá nuestro password

			var caracteres_conseguidos			=	0;			// contador de los caracteres que hemos conseguido
			var caracter_temporal				=	'';
			
			var array_caracteres				=	new Array();// array para guardar los caracteres de forma temporal
				
				for(var i = 0; i < tamanyo_password; i++){		// inicializamos el array con el valor null
					array_caracteres[i]	=	null;
				}

			var password_definitivo				=	'';

			var numero_minimo_letras_minusculas	=	1;			// en ésta y las siguientes variables definimos cuántos 
			var numero_minimo_letras_mayusculas	=	1;			// caracteres de cada tipo queremos en cada 
			var numero_minimo_numeros			=	1;
			var numero_minimo_simbolos			=	1;

			var letras_minusculas_conseguidas 	=	0;
			var	letras_mayusculas_conseguidas	=	0;
			var	numeros_conseguidos				=	0;
			var	simbolos_conseguidos			=	0;


			// función que genera un número aleatorio entre los límites superior e inferior pasados por parámetro
			function genera_aleatorio(i_numero_inferior, i_numero_superior) {
			    var     i_aleatorio  =   Math.floor((Math.random() * (i_numero_superior - i_numero_inferior + 1)) + i_numero_inferior);
			    return  i_aleatorio;
			}


			// función que genera un tipo de caracter en base al tipo que se le pasa por parámetro (mayúscula, minúscula, número, símbolo o aleatorio)
			function genera_caracter(tipo_de_caracter){
				// hemos creado una lista de caracteres específica, que además no tiene algunos caracteres como la "i" mayúscula ni la "l" minúscula para evitar errores de transcripción
			//	var lista_de_caracteres	=	'$+=?@_23456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz';
				var lista_de_caracteres	=	'98765423456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz';
				var caracter_generado	=	'';
				var valor_inferior		=	0;
				var valor_superior		=	0;

				switch (tipo_de_caracter){
					case 'minúscula':
						valor_inferior	=	38;
						valor_superior	=	61;
						break;
					case 'mayúscula':
						valor_inferior	=	14;
						valor_superior	=	37;
						break;
					case 'número':
						valor_inferior	=	6;
						valor_superior	=	13;
						break;
					case 'símbolo':	
						valor_inferior	=	0;
						valor_superior	=	5;
						break;
					case 'aleatorio':
						valor_inferior	=	0;
						valor_superior	=	61;

				} // fin del switch

				caracter_generado	=	lista_de_caracteres.charAt(genera_aleatorio(valor_inferior, valor_superior));
				return caracter_generado;
			} // fin de la función genera_caracter()


			// función que guarda en una posición vacía aleatoria el caracter pasado por parámetro
			function guarda_caracter_en_posicion_aleatoria(caracter_pasado_por_parametro){
				var guardado_en_posicion_vacia	=	false;
				var posicion_en_array			=	0;

				while(guardado_en_posicion_vacia	!=	true){
					posicion_en_array	=	genera_aleatorio(0, tamanyo_password-1);	// generamos un aleatorio en el rango del tamaño del password

					// el array ha sido inicializado con null en sus posiciones. Si es una posición vacía, guardamos el caracter
					if(array_caracteres[posicion_en_array] == null){
						array_caracteres[posicion_en_array]	=	caracter_pasado_por_parametro;
						guardado_en_posicion_vacia			=	true;
					}
				}
			}


			// función que se inicia una vez que la página se ha cargado
			function generar_contrasenya(){
				password_definitivo =""
				// generamos los distintos tipos de caracteres y los metemos en un password_temporal
				while (letras_minusculas_conseguidas < numero_minimo_letras_minusculas){
					caracter_temporal	=	genera_caracter('minúscula');
					guarda_caracter_en_posicion_aleatoria(caracter_temporal);
					letras_minusculas_conseguidas++;
					caracteres_conseguidos++;
				}

				while (letras_mayusculas_conseguidas < numero_minimo_letras_mayusculas){
					caracter_temporal	=	genera_caracter('mayúscula');
					guarda_caracter_en_posicion_aleatoria(caracter_temporal);
					letras_mayusculas_conseguidas++;
					caracteres_conseguidos++;
				}

				while (numeros_conseguidos < numero_minimo_numeros){
					caracter_temporal	=	genera_caracter('número');
					guarda_caracter_en_posicion_aleatoria(caracter_temporal);
					numeros_conseguidos++;
					caracteres_conseguidos++;
				}

				while (simbolos_conseguidos < numero_minimo_simbolos){
					caracter_temporal	=	genera_caracter('símbolo');
					guarda_caracter_en_posicion_aleatoria(caracter_temporal);
					simbolos_conseguidos++;
					caracteres_conseguidos++;
				}

				// si no hemos generado todos los caracteres que necesitamos, de forma aleatoria añadimos los que nos falten
				// hasta llegar al tamaño de password que nos interesa
				while (caracteres_conseguidos < tamanyo_password){
					caracter_temporal	=	genera_caracter('aleatorio');
					guarda_caracter_en_posicion_aleatoria(caracter_temporal);
					caracteres_conseguidos++;
				}

				// ahora pasamos el contenido del array a la variable password_definitivo
				for(var i=0; i < array_caracteres.length; i++){
					password_definitivo	=	password_definitivo + array_caracteres[i];
				}

				// indicamos los parámetros con los que hemos generado la contraseña
				/*document.write('Tamaño total de la contraseña: ' 	+ tamanyo_password + '<br>');
				document.write('Cantidad de minúsculas: '			+ numero_minimo_letras_minusculas + '<br>');
				document.write('Cantidad de mayúsculas: ' 			+ numero_minimo_letras_mayusculas + '<br>');
				document.write('Cantidad de números: ' 				+ numero_minimo_numeros + '<br>');
				document.write('Cantidad de símbolos: ' 			+ numero_minimo_simbolos + '<br>');
				document.write('El resto de caracteres hasta llegar al tamaño de la contraseña se completa con caracteres aleatorios.<br>');
*/
				// y ahora simplemente lo mostramos por pantalla
			//	alert('Password generado: <strong>' + password_definitivo + '</strong><br>');
				return password_definitivo;
			}
	// controlar inactividad en la web	
		$(document).inactivityTimeout({
                inactivityWait: 10000,
                dialogWait: 10,
                logoutUrl: 'logout.php'
            })
	// fin controlar inactividad en la web		
	
	 /* requesting data */
	 function cambiarestado_menuaction(iduser,idmenu, idaction , action, idempresa)
	 {
		$.ajax
			({ 
				url: 'updatepermisosuseraction.php',
				data: "iduser="+iduser+'&idmenu='+idmenu+'&accion='+$('#customSwitch'+idmenu).prop("checked")+'&idb='+idempresa+'&idactionm='+idaction,	
				type: 'post',
			     cache:false,
				success: function(data)
				{
					var datax = JSON.parse(data)
				//	console.log(datax);
                 //   console.log(datax.vuser);
					
			
				},
				error: function() {
					alert('error')
					console.log("No se ha podido obtener la información");
				}

			});	
	 }

	 function cambiarestadocategoriatk(iduser, idcategory, idempresa)
	 {
				
			
		$.ajax
			({ 
				url: 'updatepermisosuserbytkmanager.php',
				data: "iduser="+iduser+'&idmenu='+idcategory+'&accion='+$('#customSwitchtk'+idcategory).prop("checked")+'&idb='+idempresa,	
				type: 'post',
			     cache:false,
				success: function(data)
				{
					var datax = JSON.parse(data)
				//	console.log(datax);
                 //   console.log(datax.vuser);
					
			
				},
				error: function() {
					alert('error')
					console.log("No se ha podido obtener la información");
				}

			}); 
	 }
     		
	function cambiarestado(iduser, idmenu,idempresa, accion)	
	{
		//alert(iduser +'-'+idmenu+'-accion'+accion);
	//console.log(	$('#customSwitch'+idmenu).prop("checked");
		
		$.ajax
			({ 
				url: 'updatepermisosuser.php',
				data: "iduser="+iduser+'&idmenu='+idmenu+'&accion='+$('#customSwitch'+idmenu).prop("checked")+'&idb='+idempresa,	
				type: 'post',
			     cache:false,
				success: function(data)
				{
					var datax = JSON.parse(data)
				//	console.log(datax);
                 //   console.log(datax.vuser);
					
			
				},
				error: function() {
					alert('error')
					console.log("No se ha podido obtener la información");
				}

			});
		
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
   
   
     function save_modify_registro(tipoaccion)
   {
	   /// Solo modif info del usuarios
	   toastr["warning"]("Processing information!", "");	
	   if (tipoaccion ==1)
	   {
		   
		   
		   $('#lbldatoserrr').html("");
		 var v_idcliselect = $('#idcliselect').val();
		  var v_idcliempreselect = $('#idcliempreselect ').val();
		 var v_txtupwd = $('#txtupwdmodif').val();
		 var v_txtnameuser = $('#txtnameusermodif').val();
		 var v_txtcategory = $('#txtcategorymodif').val();		 
		 var v_txtemail = $('#txtemailmodif').val();
		 
		   toastr["success"]("processing information..", "");	
		
				$.ajax({
				url: 'ajax_updateinfo_user.php', 				
				data: "qaccem=1&idcliselect="+v_idcliselect+'&idcliempreselect='+v_idcliempreselect+'&txtupwdmodif='+v_txtupwd+'&txtnameusermodif='+v_txtnameuser+'&txtcategorymodif='+v_txtcategory+'&txtemailmodif='+v_txtemail,	
				type: 'post',				
				datatype:'JSON',				
				cache:false,					
				success: function(data, status, xhr) {
					var resultadom = data.resultiu;
					var resulterr = data.erromsj;
		
					if (resultadom =="ok" )
					{
						toastr["success"]("Save OK!", "");	
						alert('Save OK!');
						location.reload(); 
		 
					
					}
					else	
					{
						toastr["error"]("Error when storing data...", "");	
						
						$('#lbldatoserrr').html("ERROR: <br>"+resulterr);
					}
					return false;	
				
				},
				error: function(xhr, status, error) {
					 console.log(status);
				}
				});
				
	   }
	     /// Solo cambia clave
	   if (tipoaccion ==2)
	   {
		     $('#lbldatoserrr').html("");
		  var v_idcliselect = $('#idcliselect').val();
		  var v_idcliempreselect = $('#idcliempreselect ').val();
	 	  var v_txtupwd = $('#txtupwdmodif').val();
		   var v_txtemail = $('#txtemailmodif').val();
		  
		 
		   var fff = generar_contrasenya();
			$('#divnewpass').show();
			$('#txtnewpassgenerada').html('<b>'+fff+'</b>');
			
		  
		   	$.ajax({
				url: 'ajax_updateinfo_user.php', 				
				data: "qaccem=2&v_txtupwd="+fff+'&idcliempreselect='+v_idcliempreselect+'&idcliselect='+v_idcliselect+'&txtemailmodif='+v_txtemail,	
				type: 'post',				
				datatype:'JSON',				
				cache:false,					
				success: function(data, status, xhr) {
					var resultadom = data.resultiu;
					var resulterr = data.erromsj;
		
					if (resultadom =="ok" )
					{
						toastr["success"]("Save OK, New Password!", "");	
						alert('Save OK, New Password!');
					//	location.reload(); 
		 
					
					}
					else	
					{
						toastr["error"]("Error when storing data...", "");	
						
						$('#lbldatoserrr').html("ERROR: <br>"+resulterr);
					}
					return false;	
				
				},
				error: function(xhr, status, error) {
					 console.log(status);
				}
				});
	   }
	     ///  cambia clave y envia al email
	   if (tipoaccion ==3)
	   {
		      $('#lbldatoserrr').html("");
		  var v_idcliselect = $('#idcliselect').val();
		  var v_idcliempreselect = $('#idcliempreselect ').val();
	 	  var v_txtupwd = $('#txtupwdmodif').val();
		   var v_txtemail = $('#txtemailmodif').val();
		   var vtxtusernamehideen =  $('#txtusernamehideen').val(); 
		 
		   var fff = generar_contrasenya();
			$('#divnewpass').show();
			$('#txtnewpassgenerada').html('<b>'+fff+'</b>');
			
		  
		   	$.ajax({
				url: 'ajax_updateinfo_user.php', 				
				data: "qaccem=3&v_txtupwd="+fff+'&idcliempreselect='+v_idcliempreselect+'&idcliselect='+v_idcliselect+'&txtemailmodif='+v_txtemail+'&vtxtusernamehideen='+vtxtusernamehideen,	
				type: 'post',				
				datatype:'JSON',				
				cache:false,					
				success: function(data, status, xhr) {
					var resultadom = data.resultiu;
					var resulterr = data.erromsj;
		
					if (resultadom =="ok" )
					{
						toastr["success"]("Save OK, New Password!", "");	
						alert('Save OK, New Password!');
					//	location.reload(); 
		 
					
					}
					else	
					{
						toastr["error"]("Error when storing data...", "");	
						
						$('#lbldatoserrr').html("ERROR: <br>"+resulterr);
					}
					return false;	
				
				},
				error: function(xhr, status, error) {
					 console.log(status);
				}
				});
	   }
   }
     function save_new_registro()
   {
	 	   
	 	 	   

	////Controlamos campos vacios
		if ($('#txtstationame')[0].checkValidity() == false)
		{
			toastr["error"]("Error, Station Name is required..", "");	
			return false;
		}	
		if ($('#txtmacadd')[0].checkValidity() == false)
		{
			toastr["error"]("Error, MAC Address is required..", "");	
			return false;
		}	
		
		if ($('#txxipsation')[0].checkValidity() == false)
		{
			toastr["error"]("Error, IP Station  is required..", "");	
			return false;
		}	
		 				
		$('#lbldatoserrr').html("");
		 var txtstationame = $('#txtstationame').val();
		 var txtmacadd = $('#txtmacadd').val();
		 
		 var txxipsation = $('#txxipsation').val();
		 var txtipgen1 = $('#txtipgen1').val();
		 var txtipgen2 = $('#txtipgen2').val();
		  var txtprintzebra = $('#txtcategory').val();
		  var txtidmodif= $('#txtidmodif').val();
		 
		 	
					
		toastr["success"]("processing information..", "");	
		
				$.ajax({
				url: 'ajax_createnew_stations.php', 				
				data: "txtstationame="+txtstationame+"&txtmacadd="+txtmacadd+'&txxipsation='+txxipsation+'&txtipgen1='+txtipgen1+'&txtipgen2='+txtipgen2+'&txtprintzebra='+txtprintzebra+'&txtidmodif='+txtidmodif,	
				type: 'post',				
				datatype:'JSON',				
				cache:false,					
				success: function(data, status, xhr) {
					var resultadom = data.resultiu;
					var resulterr = data.erromsj;
					console.log("Error");
					console.log("Exec: " + resulterr);
					if (resultadom =="ok" )
					{
						toastr["success"]("Save OK!", "");	
						alert('Save OK!');
						location.reload(); 
		 
					
					}
					else	
					{
						toastr["error"]("Error when storing data...", "");	
						
						$('#lbldatoserrr').html("ERROR: <br>"+resulterr);
					}
					return false;	
				
				},
				error: function(xhr, status, error) {
					 console.log(status);
				}
				});
			
   }
   
</script>

</html>

<!DOCTYPE html>
<?php 

// Desactivar toda notificación de error
error_reporting(0);
// Notificar todos los errores de PHP (ver el registro de cambios)
//error_reporting(E_ALL);
 include("db_conect.php"); 
 
 
 	session_start();
	

//	echo "<br>".isset($_SESSION["timeout"]);
//	exit();
	
// echo "***********hola".time() - $_SESSION["timeout"];
  if(isset($_SESSION["timeout"])){
        // Calcular el tiempo de vida de la sesión (TTL = Time To Live)
		//echo "***********hola".time() - $_SESSION["timeout"];
        $sessionTTL = time() - $_SESSION["timeout"];
	//	echo $sessionTTL."-".$inactividad; 
        if($sessionTTL > $inactividad){
			session_unset();
            session_destroy();
            header("Location: http://".$ipservidorapache."/index.php?t=timeoutinactivityhome");
        }
	
    }
	else
	{
			session_unset();
            session_destroy();
            header("Location: http://".$ipservidorapache."/index.php?t=notcookietimeouthome");
        
	}
	
	$status = $connect->getAttribute(PDO::ATTR_CONNECTION_STATUS);
	
	if ($status !="Connection OK; waiting to send.")
	{
	
		header("Location: http://".$ipservidorapache."/".$folderservidor."/errorconect.php");
		exit();
		
	}
	
	//	echo "Hola:".$_SESSION["timeout"];
			
	
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
	
		<style>
	
body
{
	  font-family: Arial, Helvetica, sans-serif;
	      background:#eee;		  
  font-size:12px;
  font-size:12px;
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

</style>

</head>
<form name="frma" id="frma">
<input type="hidden" name="uso" id="uso" value="0">
<body class="hold-transition sidebar-mini sidebar-collapse">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->

  <!-- /.navbar -->
<?php 	  

  
   
 include("menutopnotification.php"); 

 include("menu.php"); 
 ///    echo "bbbbsssssssssssssssssssssssssssssssssbbbbaaaaaaaaaaaaa";
 include("funcionesstores.php"); 
// include ('licencefiplex_mm.php');
 
   ////   $Encryption = new Encryption();
   
?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>DashBoard</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active"> <?php echo $_SESSION["h"]; ?></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

<?php
			$eluserlogin = $_SESSION["a"];
			 $query_lista="select distinct menu.* from menu inner join business_user_menu on business_user_menu.idmenu = menu.idmenu  where menu.active = 'Y' and sector = 'homeheader' and iduserfas=$eluserlogin  and namegroup = 'head' order by ordershow ,  namemenu  ";
			
			$resultado = $connect->query($query_lista);	
			$cantregistros = $resultado->rowCount();
			if ($cantregistros >=1)
			{
?>

	<section class="content">
      <div class="row">
	  <!-- /.inicio row botones menu rapido content -->	
	
	
		
			<?php
			
			
			
				foreach ($resultado as $row) {
					$stylecolor = $row['menustyle'];
					$iconomenu = $row['iconmenu'];
					
					$namemenu = $row['namemenu'];
					$linkmenu = $row['linkaccess'];
					
					?>
					<!-- autogenerado:0 BOTON MENU-->		
						<div class="col-12 col-sm-6 col-md-3">
						  <div class="info-box">
							<span class="info-box-icon <?php echo $stylecolor;?> elevation-1"><i class="<?php echo $iconomenu;?>"></i></span>
								<div class="info-box-content"><a href="<?php echo $linkmenu;?>"><span class="info-box-number"><?php echo $namemenu;?></span></a></div>
						  </div>
					   
						 </div>
					<!-- autogenerado:0 BOTON MENU-->
					<?php
				}
			?>
			
		<!-- 11 BOTON MENU-->		
			
			 <!-- 11 BOTON MENU-->						 
		   
		
		<!-- /. fin row botones menu rapido  content -->		 
       
	   
	   <!----- CUI BOX  -->
	 <?php
		
			
			 $query_lista="select distinct menu.* from menu inner join business_user_menu on business_user_menu.idmenu = menu.idmenu  where menu.active = 'Y' and sector = 'homecenter' and iduserfas=$eluserlogin  order by ordershow , sector,  namemenu  ";
			
		//	echo 	$query_lista;
				$resultado = $connect->query($query_lista)->fetchAll();	
				
				$temp_namegroup = "";
			
				foreach ($resultado as $row) {
					$stylecolor = $row['menustyle'];
					$iconomenu = $row['iconmenu'];
					$iconmenuhead = $row['iconmenuhead'];
					$headnamemenu = $row['namegroup'];
					$namemenu = $row['namemenu'];
					$linkmenu = $row['linkaccess'];
					
					if ($headnamemenu != $temp_namegroup)
					{
						if ($temp_namegroup != "")
						{
							?>
									  </div>        
									</div>		
								</div>
							<?php
						}
							$temp_namegroup = $headnamemenu;
						?>
						<div class="col-12 col-sm-6 col-md-3">
						   <div class="card card-default color-palette-box ">
							  <div class="card-header">
								<h3 class="card-title"> <i class="<?php echo $iconmenuhead; ?>"></i> <?php echo $headnamemenu; ?> </h3>
							  </div>
							  <div class="card-body">
						<?php
					}
					?>
					<!-- autogenerado:0 BOTON MENU-->		
						
								<i class='<?php echo $iconomenu; ?>' style='font-size:24px'></i>	<a href="<?php echo $linkmenu; ?>"><?php echo $namemenu; ?></a><br>
							                   
							 
					<!-- autogenerado:0 BOTON MENU-->
					<?php
				}
				if ($temp_namegroup !="")
				{
					?>
						</div>        
							</div>		
						</div>
		
					<?php
				}
			?>
							
		
					</div>
		 <?php } ?>
	   <!----- FIN CUI BOX -->
	   
	   
	   
	
  <div class="row">
    <div class="col-lg-4">
	<?php 
	
		if ($_SESSION["g"] == "develop" || $_SESSION["g"] == "director" )
		{
			
		?>
			 
		 <div class="callout callout-warning">
              <h5><i class="fas fas fa-wrench"></i></i> Cloud Srvr Backup:</h5>
			  <?php
			  
			//  http://webfas.fiplex.com/ajaxultibksnube.php
		

			  ?>
			               <span class="badge badge-success"> Created</span> 
			<span class='texto10'> File: <?php 	$cc = curl_init("http://webfas.fiplex.com/ajaxultibksnube.php");  
			$url_content =  curl_exec($cc);  
			curl_close($cc); ?> </span> 
			<?php 
			
			/*$path  = '/var/backups/pgsql'; 
			$ultdiaconbks_srvusa="";
			// Arreglo con todos los nombres de los archivos
			$files = array_diff(scandir($path), array('.', '..')); 
			
			foreach($files as $file){
					// Divides en dos el nombre de tu archivo utilizando el . 
					$data          = explode(".", $file);
					// Nombre del archivo
					$fileName      = $data[0];
					// Extensión del archivo 
					$fileExtension = $data[1];

					 $ultdiaconbks_srvusa= $fileName;
						// Realizamos un break para que el ciclo se interrumpa
					
				}*/

			?>
	
         </div>
	<?php 	
		}
	?>	 
	
	
 
 	<div class="card">
          
              <!-- /.card-header -->
          
				<?php 
				
				if 	($_SESSION["g"] == "develop"  || $_SESSION["g"] == "director"  ) 
					{
				
				?>
				
				
                   
                <div id="accordion">
				<!--iNICIO DIV FAS SERVER -->
				<div class="card collapsed-card" id="divfasserver" name="divfasserver" data-parent="divfasserver">
					  <div class="card-header border-0 ui-sortable-handle"  style="cursor: move;">
						<h3 class="card-title">
						  <i class="fas fa-th mr-1"></i>
						  FAS SERVER - LogInfo
						</h3>

							<div class="card-tools">
							  <button type="button" class="btn btn-sm" data-card-widget="collapse">
								<i class="fas fa-plus"></i>
							  </button>
						   
							</div>
					  </div>
					<div class="card-body" style="display: none;" aria-labelledby="divfasserver" data-parent="#accordion">
		
		      
				 <div class="col-12 table-responsive  align-items-center">
                  <table class="table table-striped table-sm  table-bordered">
                    <thead>
                    <tr>
                      <th>ID</th>
                      <th>Date</th>
                      <th colspan=3>Log Info Srv</th>
                      
                    </tr>
                    </thead>
                    <tbody>
					
					<?php 
					
					$sql = "  SELECT idserverinfo, cast(dateinfo as date) as eldia, loginfo,dateinfo FROM public.fas_server_log   order by  dateinfo desc limit 20";
						
					
						
							$resultsupport = $connect->query($sql)->fetchAll();				
		
							foreach ($resultsupport as $rowdatos) {
								?>
								 <tr class="texto10">
								
								 <td><?php echo str_replace("###","<BR>",$rowdatos['idserverinfo']); ?></td>
								 <td><?php echo str_replace("###","<BR>",$rowdatos['eldia']); ?></td>
								  <td><?php echo str_replace("###","<BR>",$rowdatos['loginfo']); ?></td>
								 
								</tr>
								<?php
							}

					?>
					
                   
                   
                   
                    </tbody>
                  </table>
                </div>
             
              </div>
              <!-- /.card-body -->
          
              <!-- /.card-footer -->
            </div>
			<!--FIN DIV FAS SERVER -->
			<!--iNICIO DIV FAS SERVER -->
				<div class="card collapsed-card" id="divfasserveraudit" name="divfasserveraudit" data-parent="divfasserveraudit">
					  <div class="card-header border-0 ui-sortable-handle"  style="cursor: move;">
						<h3 class="card-title">
						  <i class="fas fa-th mr-1"></i>
						  WEBFAS - Audit
						</h3>

							<div class="card-tools">
							  <button type="button" class="btn btn-sm" data-card-widget="collapse">
								<i class="fas fa-plus"></i>
							  </button>
						   
							</div>
					  </div>
					<div class="card-body" style="display: none;" aria-labelledby="divfasserveraudit" data-parent="#accordion">
		
		      
				 <div class="col-12 table-responsive  align-items-center">
                  <table class="table table-striped table-sm  table-bordered">
                    <thead>
                    <tr>
                      <th>Date</th>
                      <th>User</th>
					  <th>WebPag</th>
                      <th >quantity</th>
                      
                    </tr>
                    </thead>
                    <tbody>
					
					<?php 
					
					$sql = " SELECT cast(dateaudit as date) as eldia,userfas,menuweb, count(dateaudit) as ccreg from auditwebfas  where menuweb <> 'logdb.php' group by  cast(dateaudit as date),userfas,menuweb  order by  eldia desc, menuweb, count(dateaudit)  desc limit 60";
								
				
						
							$resultsupport = $connect->query($sql)->fetchAll();				
		
							foreach ($resultsupport as $rowdatos) {
								?>
								 <tr class="texto10">
								
								 <td><?php echo str_replace("###","<BR>",$rowdatos['eldia']); ?></td>
								 <td><?php echo str_replace("###","<BR>",$rowdatos['userfas']); ?></td>
								  <td><?php echo str_replace("###","<BR>",$rowdatos['menuweb']); ?></td>
								  <td><?php echo str_replace("###","<BR>",$rowdatos['ccreg']); ?></td>
								 
								</tr>
								<?php
							}

					?>
					
                   
                   
                   
                    </tbody>
                  </table>
                </div>
             
              </div>
              <!-- /.card-body -->
          
              <!-- /.card-footer -->
            </div>
			<!--FIN DIV FAS SERVER -->
			
			
				  </div>
				  
				  
				  
				  <?php 
				  // SELECT cast(dateinfo as date) as eldia, loginfo FROM public.fas_server_log   order by  eldia desc limit 20
				  
				  
				  } ?>
           
         
            </div>
			<!--     To Do List   -->
		
			
			
    </div>
    <div class="col">	
			<div class="card">
           
            </div>
    </div>
  </div>
	
	
  <!-- /.content-wrapper -->
   
   </div>
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
 <script src="js/eModal.min.js" type="text/javascript" />
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
    function openpopupframe(idtksupport)
	{
		eModal.iframe('edittksuppor.php?idt='+idtksupport,'Tech Support FAS - Ticket Manager ');
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
   
   function mostrar_todo_ticket()
   {
	   var losdatos="";
	   losdatos =   $("#mostrartdo").html();
	 //  $(".table-success").removeClass('d-none');
	
	   if (losdatos.indexOf("all") >= 0)
	   {
		   		$("#mostrartdo").html('<i class="fas fa-eye-slash"></i> See pending / in process');
				   $(".table-success").removeClass('d-none');
	   }
	   else
	   {
		   		$("#mostrartdo").html('<i class="far fa-eye"></i> View all');
				   $(".table-success").addClass('d-none');
	   }

	   
   }
   
</script>

</html>
<?php

	/// Enviamos Aviso soprote
		/// Enviamos Aviso soprote
					 include("configsendmail.php"); 
					//Set who the message is to be sent to
					

					  //Asignamos asunto y cuerpo del mensaje
					  //El cuerpo del mensaje lo ponemos en formato html, haciendo 
					  //que se vea en negrita
				
							
				

					  //Asignamos asunto y cuerpo del mensaje
					  //El cuerpo del mensaje lo ponemos en formato html, haciendo 
					  //que se vea en negrita
					  
// Buscamos TK sin Reportar
//echo "bbbbbbbbbbbbbbbbbbbbbb";
$sqlbuscar = "select * from fas_techsupport where idruninfo = 1 and idcategory <> 9 and sendnotice ='N' ";
$resultado = $connect->query($sqlbuscar);	
$mandemail = "N";
	foreach ($resultado as $rowdatopmail) {
		
		$mail->addAddress('marco.moretti@fiplex.com', 'marco ');
					$mail->addCC('agustin.corigliano@fiplex.com', 'Agus');
					$mail->addCC('leandro.julian@fiplex.com', 'Agus');
					
		// Updateamos y mandamos email
		$sqlbuscar = "update fas_techsupport set sendnotice ='Y' ,  idruninfo = 0 where idruninfo = 1 and idfas_techsupport = ".$rowdatopmail['idfas_techsupport'];
		$resultado2 = $connect->query($sqlbuscar);	
		
			  $mail->Subject = "Tech Support::New Ticket #".$rowdatopmail['idfas_techsupport']." - UserReported:".$rowdatopmail['userreported'];
					  $mail->Body = "<b>New Support Ticket:</b> ".$rowdatopmail['idfas_techsupport']."<br><b>UserReported:</b> ".$rowdatopmail['userreported']."<br><br><b> Issue:</b> ".$rowdatopmail['issue']."<br><b>Log:</b><br>";
                    //Definimos AltBody por si el destinatario del correo no admite email con formato html 
					  $mail->AltBody = "New Support Ticket:".$rowdatopmail['idfas_techsupport']." --  UserReported:".$rowdatopmail['userreported']." -- Issue: ".$rowdatopmail['issue'];
$mandemail = "S";
						$mail->Send();
					
					
		
	}
	
	
						  //Asignamos asunto y cuerpo del mensaje
					  //El cuerpo del mensaje lo ponemos en formato html, haciendo 
					  //que se vea en negrita
			if ($mandemail == "S")
			{
					$mail->smtpClose();
					
				//		echo "1 despues close  aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa".$sqlbuscar;		
						
					 require ("configsendmail.php"); 
			//	echo "<br>despues del incliudeeee<br>";
			}
				
				
					//Set who the message is to be sent to
					$mail->addAddress('diego.maggio@fiplex.com', 'Diego Maggio ');
					$mail->addCC('marco.moretti@fiplex.com', 'Marco');
					  
// Buscamos TK sin Reportar para DIEGOO  //  idcategory = 9 Report Creation SO
$sqlbuscar = "select * from fas_techsupport where userreported <> 'ljulian' and idcategory = 9 and sendnotice ='N' ";

	
$resultado = $connect->query($sqlbuscar);	
		
	foreach ($resultado as $rowdatopmail) {
		
		
		// Updateamos y mandamos email
		$sqlbuscar = "update fas_techsupport set sendnotice ='Y' where   idfas_techsupport = ".$rowdatopmail['idfas_techsupport'];
		$resultado2 = $connect->query($sqlbuscar);	
		/// Insertamos cambio de estadoo.
		
			$sqlbuscar = "INSERT INTO public.fas_techsupport_state(	idfas_techsupport, datessupportstate, commentsupport, idstatesupport, idusersupport)
	VALUES (".$rowdatopmail['idfas_techsupport'].", CURRENT_TIMESTAMP, 'AUTOCLOSE TK FAS' , 3,".$rowdatopmail['iduserfasreport'].");"; 
		$resultado2 = $connect->query($sqlbuscar);	
		
			  $mail->Subject = "Tech Support::New Ticket #".$rowdatopmail['idfas_techsupport']." - UserReported:".$rowdatopmail['userreported'];
					$mail->Body = "<b>New Support Ticket:</b> ".$rowdatopmail['idfas_techsupport']."<br><b>UserReported:</b> ".$rowdatopmail['userreported']."<br><br><b> Info:</b> ".$rowdatopmail['issue']."<br><b></b><br>";
                    //Definimos AltBody por si el destinatario del correo no admite email con formato html 
					  $mail->AltBody = "New Support Ticket:".$rowdatopmail['idfas_techsupport']." --  UserReported:".$rowdatopmail['userreported']." -- Info: ".$rowdatopmail['issue'];
//echo "mando email";
						$mail->Send();
					
					
		
	}
	

?>
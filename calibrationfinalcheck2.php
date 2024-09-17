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
	//		header("Location: http://".$ipservidorapache."/".$folderservidor."/permissiondenied.php?b=".$_SESSION["b"]."&c=".array_pop(explode('/', $_SERVER['PHP_SELF'])));
	//		exit();
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
	    <link rel="stylesheet" href="css/viewer.min.css">
		 <style>
		 
		 .containermarco {
    width: 98%;
     padding-right: 7.5px; 
     padding-left: 7.5px; 
     margin-right: auto; 
     margin-left: auto; 
	}

    .pictures {
      list-style: none;
      margin: 0;
      max-width: 30rem;
      padding: 0;
    }

    .pictures > li {
    /*  border: 1px solid transparent;
      float: left;
      height: calc(100% / 2);
      margin: 0 31px 0px 15px;
      overflow: hidden;
      width: calc(100% / 2);*/
    }

    .pictures > li > img {
      cursor: zoom-in;
      width: 100%;
    }
	.rowmm {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
     margin-right: -1.5px; 
     margin-left: -1.5px; 
}


.card {
    box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
    margin-bottom: 5px;
}

.irs-grid_marco_verde {
    background: #28a745;
}
.irs-grid_marco_amarillo {
    background: #ffc107;
}
.irs-grid_marco_rojo {
    background: #dc3545;
}


.divmarco {
	  margin-top: 17.5px; 
}

  </style>
  
</head>
<form name="frma" id="frma">
<input type="hidden" name="uso" id="uso" value="0">
<body class="hold-transition sidebar-mini sidebar-collapse">

 <div class="">
 
<!-- Site wrapper -->
<div class="">

 <!-- Content Wrapper. Contains page content -->
  <div class="">
<br>
	  <?php
		  	$v_Levels_Offset = 0;
								$v_Squelch_Offset = 0;
								$v_Gain_Offset = 0;
								$v_Max_Pwr_Offset = 0;
								
								$v_currentminvalor = 0;
								$v_currentmaxvalor = 0;
								$v_currentminmeasurerango = 0;
								$v_currentmaxmeasurerango = 0;
								
				
							    $vparam_vnrounitsn = $_REQUEST['idsndib']; ///

					
							    
				 
				  
				  ?>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">        
        <!-- Timelime example  -->
        <div class="row">        
			<section class="col-lg-12 connectedSortable ui-sortable">
			
			<div class="table-responsive">
                  <table class="table table-sm table-hover  table-bordered text-center textotabla10 fondoblanco">
				  
				<?php 

 $Vjd=0;
 $sql="SELECT DISTINCT uldl, band , MAX(idrununfo) as idruninfo  from fas_tree_measure where fas_tree_measure.iduniquebranch like '002%' and unitsn = '".$vparam_vnrounitsn."' GROUP BY uldl,band order by band ";
							//	echo $sql."<br>";
							   $datacabez = $connect->query($sql)->fetchAll();
								$idtemp=0;
								$vejecucion = 1;
								  foreach ($datacabez as $rowheaders) 
								  {
									  
									  $vparam_vnrounitsn = $_REQUEST['idsndib']; ///// "20000000fu";	
									$vparam_band = $rowheaders['band'];
									$vaparam_uldl = $rowheaders['uldl'];
									$vparam_idruninfo = $rowheaders['idruninfo'];	
									
								  
									  
								
		  $query_lista="SELECT fas_tree_measure.totalpass,  fas_tree_measure.iduniqueop,  fas_step.description as namebranch,  fas_tree_measure.iduniquebranch, fas_tree_measure.unitsn, fas_tree_measure.dibsn, fas_tree_measure.uldl, fas_tree_measure.band
,fas_tree_measure.idrununfo
from fas_tree_measure
inner join fas_tree
on fas_tree.iduniquebranch = fas_tree_measure.iduniquebranch
inner join fas_step
on fas_step.idfasstep = fas_tree.idfastrepson
where fas_tree_measure.iduniquebranch  in('002007013','00200701B','00200701A','00200701C','00200701B02F0','002007030') and fas_tree_measure.iduniquebranch like '002%' and uldl = ".$vaparam_uldl ." and band = ".$vparam_band." and  unitsn = '".$vparam_vnrounitsn."' and  idrununfo =".$vparam_idruninfo. " order by iduniqueop";

		//echo $query_lista;
				  $dataresumen = $connect->query($query_lista)->fetchAll();
				  
				  if ( $Vjd==0)
				  {
					  
				  
				  ?>
                    <thead>
					
                    <tr class="thead-dark">
                      <th>Ref:</th>
					   <th>Calibration:</th>
					    <th>Final Chk:</th>
					  <?php
					 
					    foreach ($dataresumen as $rowresult) 
						{
							 $Vjd= $Vjd + 1;
							echo "<th> Status: ".str_replace("FinalCheck_Measures_", "", $rowresult['namebranch'])."</th>";
						}
					  ?>
                     
                    </tr>
                    </thead>
                    <tbody>
				<?php  } ?>	
                    <tr>
					<td class="text-left"><?php 
						if ($vaparam_uldl ==0)
						{
					 	    $label_ULDL_amostrar ="Uplink";
						}
						else
						{
							$label_ULDL_amostrar ="Downlink";
						}
						if ($vparam_band ==0)
						{
					 	    $label_band_amostrar ="700 FirstNet";
						}
						else
						{
							$label_band_amostrar ="800";
						}
					
					echo "".$label_band_amostrar ." - ".$label_ULDL_amostrar; ?></td>
					<td>    <i class="fas fa-search"></i></td>
					<td>    <i class="fas fa-search"></i></td>
                       <?php
					   $vi=0;
					    foreach ($dataresumen as $rowresult) 
						{
							
							if ($rowresult['totalpass'] =="")
							{
									echo "<td><span class='badge badge-pill badge-danger'>Not Passed</span></td>";
							}
							else
							{
									echo "<td><span class='badge badge-pill badge-success'>Passed</span></td>";
							}
							
						}
					  ?>
                    </tr>
                <?php 
				
				}
				?>
                    </tbody>
                  </table>
				  <br>
                </div>
				
				<?php
				$sqlagrup = "SELECT uldl, band, unitsn, max(idrununfo) as idruninfo,'Calibration' as typeejec
from fas_tree_measure where 
fas_tree_measure.iduniquebranch in('00100300A') and 
 unitsn = '".$vparam_vnrounitsn."' 
 group by  uldl, band, unitsn, typeejec
 union 
 SELECT uldl, band, unitsn, max(idrununfo) as idruninfo,'Final Check' as typeejec
from fas_tree_measure where 
fas_tree_measure.iduniquebranch in('002') and 
 unitsn = '".$vparam_vnrounitsn."' 
 group by  uldl, band, unitsn, typeejec
 order by band ,uldl";
  $dataresumen = $connect->query($sqlagrup)->fetchAll();
  
				  foreach ($dataresumen as $rowresult) 
						{
							
								if ( $rowresult['uldl'] ==0)
									{
										$label_ULDL_amostrar ="UP";
									}
									else
									{
										$label_ULDL_amostrar ="DL";
									}
									if ( $rowresult['band'] ==0)
									{
										$label_band_amostrar ="700 FirstNet";
									}
									else
									{
										$label_band_amostrar ="800";
									}
						
							?>
							 <!-- Calibration 700 UL-->
							<div class="card collapsed-card" id="<?php echo $rowresult['uldl']."".$rowresult['band'].$vparam_vnrounitsn ?>" name="<?php echo $rowresult['uldl']."".$rowresult['band'].$vparam_vnrounitsn ?>">
							<div class="card-header">
							<h3 class="card-title"><?php echo $label_band_amostrar ." - ".$label_ULDL_amostrar." - ".$rowresult['typeejec']; ?> </h3>

								<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse">
									<?php if ($rowresult['typeejec'] =="Calibration") 
									{
										?>
										<i class="fas fa-plus" onclick="abririframecalib('<?php echo $rowresult['uldl']."".$rowresult['band'].$vparam_vnrounitsn ?>')"></i>
										<?php
									}
									else
									{
									?>
									<i class="fas fa-plus" onclick="abririframefinal('<?php echo $rowresult['uldl']."".$rowresult['band'].$vparam_vnrounitsn ?>')"></i>
										<?php	
									}
								?>
									
								</button>                  
								</div>
							</div>
					<!-- /.card-header -->
						<div class="card-body p-0">
						
						<?php if ($rowresult['typeejec'] =="Calibration") 
									{
										?>
										<iframe name="iframemuldlc<?php echo $rowresult['uldl']."".$rowresult['band'].$vparam_vnrounitsn ?>" id="iframemuldlc<?php echo $rowresult['uldl']."".$rowresult['band'].$vparam_vnrounitsn; ?>" class="responsive-iframe" src="" width="100%" border=0 height="690px"></iframe>
										<?php
									}
									else
									{
									?>
									<iframe name="iframemuldlf<?php echo $rowresult['uldl']."".$rowresult['band'].$vparam_vnrounitsn ?>" id="iframemuldlf<?php echo $rowresult['uldl']."".$rowresult['band'].$vparam_vnrounitsn; ?>" class="responsive-iframe" src="" width="100%" border=0 height="690px"></iframe>
										<?php	
									}
								?>
								
						 				
						</div>
					</div>
					 <!-- Calibration 700 UL-->
							<?php
						}
						
				
				?>
				
			       
					
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

</div>
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

   
   
	$( document ).ready(function() {
		
		//Inicio mostrar hora live
		 var interval = setInterval(function() {
			 
        var momentNow = moment();
		var newYork    = momentNow.tz('America/New_York').format('ha z');
        $('#date-part').html(momentNow.format('YYYY/MM/DD') 	  );
        $('#time-part').html(momentNow.format('hh:mm:ss'));
		}, 100);
		//FIN mostrar hora live
			var ipservidorapache= '<?php echo $ipservidorapache; ?>';	
			
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
     		
		
	function abririframecalib(div_a_abrir)
	{
			var ipservidorapache= '<?php echo $ipservidorapache; ?>';	
	//	alert('a' +div_a_abrir);
console.log('http://'+ipservidorapache+'/equalizeriir.php?idsndib=' +div_a_abrir.substr(2,10)+'&iduldl='+div_a_abrir.substr(0,1)+'&idmb='+div_a_abrir.substr(1,1));
		$('#iframemuldlc'+div_a_abrir).attr("src", 'http://'+ipservidorapache+'/equalizeriir.php?idsndib=' +div_a_abrir.substr(2,10)+'&iduldl='+div_a_abrir.substr(0,1)+'&idmb='+div_a_abrir.substr(1,1));
	}
	function abririframefinal(div_a_abrir)
	{
			var ipservidorapache= '<?php echo $ipservidorapache; ?>';	
	console.log('http://'+ipservidorapache+'/finalchk.php?idsndib=' +div_a_abrir.substr(2,10)+'&iduldl='+div_a_abrir.substr(0,1)+'&idmb='+div_a_abrir.substr(1,1));
		$('#iframemuldlf'+div_a_abrir).attr("src", 'http://'+ipservidorapache+'/finalchk.php?idsndib=' +div_a_abrir.substr(2,10)+'&iduldl='+div_a_abrir.substr(0,1)+'&idmb='+div_a_abrir.substr(1,1));
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
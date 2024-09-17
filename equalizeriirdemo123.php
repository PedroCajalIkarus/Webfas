<!DOCTYPE html>
<?php 

// Desactivar toda notificación de error
error_reporting(0);
// Notificar todos los errores de PHP (ver el registro de cambios)
//error_reporting(E_ALL);
 include("db_conect.php"); 
 
 	session_start();
	
 /*
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
	*/
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
    width: 90%;
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
      border: 1px solid transparent;
      float: left;
      height: calc(100% / 2);
      margin: 0 31px 0px 15px;
      overflow: hidden;
      width: calc(100% / 2);
    }

    .pictures > li > img {
      cursor: zoom-in;
      width: 100%;
    }
  </style>
  
</head>
<form name="frma" id="frma">
<input type="hidden" name="uso" id="uso" value="0">
<body class="hold-transition sidebar-mini sidebar-collapse">

  <div class="containermarco">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
 



  <!-- Content Wrapper. Contains page content -->
  <div class="">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Equalizer IIR </h1>
			<?php
 $sql="SELECT ideqiir, unitsn, dibsn, band, uldl,  array_agg(iditeration) as arrayiterat
FROM public.equalizeriir
group by ideqiir, unitsn, dibsn, band, uldl";
 $data = $connect->query($sql)->fetchAll();
				
				  foreach ($data as $rowheaders) 
				  {
					//  echo "<a href=''><small class='btn btn-info btn-sm'>".$rowheaders['unitsn']." - Band:".$rowheaders['band']." - Iteration:".$rowheaders['arrayiterat']."</small></a> ";
				  }
?>
				
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">template web</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content 
	
	levelsplot -> TotalRipplePlot -- nuevo titulo del gráfico: Total Ripple
Powersplot -> TxRipplePlot -- nuevo titulo del gráfico: Rx Ripple
RxRipplePlot es el nuevo campo -- nuevo titulo del gráfico: Tx Ripple
-->

    <section class="content">
      <div class="container-fluid">
        
        <!-- Timelime example 

Primero buscamos TRUE y luego FALSE
		-->
      		
		        <div class="row">
				
          <section class="col-lg-4 connectedSortable ui-sortable">

            <div class="" name="divscrolllog" id="divscrolllog" style="display.">
			<p name="msjwaitline" id="msjwaitline" align="center"><img src="img/waitazul.gif" width="100px" ></p>	
				<div class="card">
					
				     <!-- Sales Chart Canvas -->
                  	<div class="card-header">
						<h5 class="card-title colorazulfiplex"><b>TOTAL RIPPLE</b></h5>
						<div class="card-tools">						
						<span class="badge badge-pill badge-success">Pass</span>
							<span class="badge badge-pill badge-danger">Not Passed</span>
						</div>
					</div>
				   <div class="chart">
                      <!-- Sales Chart Canvas -->
                     
					    <canvas id="salesCharttxripple" height="280" style="height: 280;"></canvas>
					   </div>
					
				   	  
				  <?php
				  
				  $query_lista ="select loseqmaxit.freq ,
loseqmaxit.levels as levels0, loseqmaxitmenosuno.levels as levels1,
loseqmaxit.powers as powers0, loseqmaxitmenosuno.powers as powers1,
loseqmaxit.levelsplot as levelsplot0, loseqmaxitmenosuno.levelsplot as levelsplot1,
loseqmaxit.powersplot as powersplot0, loseqmaxitmenosuno.powersplot as powersplot1 ,
loseqmaxit.totalrippleplot as totalrippleplot0, loseqmaxitmenosuno.totalrippleplot as totalrippleplot1,
replace(loseqmaxit.levelsimgs,'\\192.168.60.14\digboardlog\Source\Plots\','') as levelsimgs0, 
replace(loseqmaxitmenosuno.levelsimgs,'\\192.168.60.14\digboardlog\Source\Plots\','') as levelsimgs1,
replace(loseqmaxit.powersimgs,'\\192.168.60.14\digboardlog\Source\Plots\','') as powersimgs0, 
replace(loseqmaxitmenosuno.powersimgs,'\\192.168.60.14\digboardlog\Source\Plots\','') as powersimgs1 

from
(
	select ideqiir,unitsn, dibsn, band,uldl,  max(iditeration) as maxiditeration from  equalizeriir where ideqiir <> 10921001060
	group by  ideqiir,unitsn, dibsn, band,uldl
)as todoseq
inner join equalizeriir
on equalizeriir.ideqiir	= todoseq.ideqiir and  
equalizeriir.unitsn		= todoseq.unitsn and
equalizeriir.dibsn		= todoseq.dibsn and 
equalizeriir.band       = todoseq.band and 
equalizeriir.uldl       = todoseq.uldl and 
equalizeriir.iditeration = todoseq.maxiditeration
inner join 
(
select equalizeriir_ref.ideqiir, equalizeriir_ref.unitsn, equalizeriir_ref.dibsn,  0  as iditeration, equalizeriir_ref.band, 
	equalizeriir_ref.uldl, equalizeriir_ref.freq, equalizeriir_ref.levels, equalizeriir_ref.powers, equalizeriir_ref.levelsplot, 
	equalizeriir_ref.powersplot, equalizeriir_ref.agc, equalizeriir_ref.levelsimgs, equalizeriir_ref.powersimgs, 
	equalizeriir_ref.totalrippleplot 
from equalizeriir_ref
inner join 
(select ideqiir,unitsn, dibsn, band,uldl,  max(iditeration) as maxiditeration from  equalizeriir where ideqiir <> 10921001060
group by  ideqiir,unitsn, dibsn, band,uldl
) as equalizeriirmaxit
on equalizeriir_ref.ideqiir	= equalizeriirmaxit.ideqiir and  
equalizeriir_ref.unitsn		= equalizeriirmaxit.unitsn and
equalizeriir_ref.dibsn		= equalizeriirmaxit.dibsn and 
equalizeriir_ref.band       = equalizeriirmaxit.band and 
equalizeriir_ref.uldl       = equalizeriirmaxit.uldl and 
equalizeriir_ref.iditeration = equalizeriirmaxit.maxiditeration
	) as loseqmaxit
on todoseq.ideqiir	= loseqmaxit.ideqiir and  
todoseq.unitsn		= loseqmaxit.unitsn and
todoseq.dibsn		= loseqmaxit.dibsn and 
todoseq.band       = loseqmaxit.band and 
todoseq.uldl       = loseqmaxit.uldl 

inner join (
select equalizeriir_ref.ideqiir, equalizeriir_ref.unitsn, equalizeriir_ref.dibsn,  0  as iditeration, equalizeriir_ref.band, 
	equalizeriir_ref.uldl, equalizeriir_ref.freq, equalizeriir_ref.levels, equalizeriir_ref.powers, equalizeriir_ref.levelsplot, 
	equalizeriir_ref.powersplot, equalizeriir_ref.agc, equalizeriir_ref.levelsimgs, equalizeriir_ref.powersimgs,
		equalizeriir_ref.totalrippleplot
from equalizeriir_ref
inner join 
(select ideqiir,unitsn, dibsn, band,uldl,  max(iditeration) -1 as maxiditeration from  equalizeriir where ideqiir <> 10921001060
group by  ideqiir,unitsn, dibsn, band,uldl
) as equalizeriirmaxitmenosuno
on equalizeriir_ref.ideqiir	= equalizeriirmaxitmenosuno.ideqiir and  
equalizeriir_ref.unitsn		= equalizeriirmaxitmenosuno.unitsn and
equalizeriir_ref.dibsn		= equalizeriirmaxitmenosuno.dibsn and 
equalizeriir_ref.band       = equalizeriirmaxitmenosuno.band and 
equalizeriir_ref.uldl       = equalizeriirmaxitmenosuno.uldl and 
equalizeriir_ref.iditeration = equalizeriirmaxitmenosuno.maxiditeration
)as loseqmaxitmenosuno
on todoseq.ideqiir	= loseqmaxitmenosuno.ideqiir and  
todoseq.unitsn		= loseqmaxitmenosuno.unitsn and
todoseq.dibsn		= loseqmaxitmenosuno.dibsn and 
todoseq.band       = loseqmaxitmenosuno.band and 
todoseq.uldl       = loseqmaxitmenosuno.uldl 
where
loseqmaxit.freq       = loseqmaxitmenosuno.freq 


";
				  $data = $connect->query($query_lista)->fetchAll();
				  $datapowers = $data;
				 
				  foreach ($data as $row) 
				  {
					  $arrayfreq[] = $row['freq'];
					  $arraylevel0[] = $row['levelsplot1'];
					  $arraylevel1[] = $row['levelsplot0'];
					  $arraypowers0[] = $row['powersplot1'];
					   $arraypowers1[] = $row['powersplot0'];
					   
					     $arraytotalrippleplot0[] = $row['totalrippleplot1'];
					   $arraytotalrippleplot1[] = $row['totalrippleplot0'];
					   
					  $freqlabel =  $freqlabel."".$row['freq'].",";
					  
					  $graflevels0 =  $graflevels0."".$row['levelsplot0'].",";
					  $graflevels1 =  $graflevels1."".$row['levelsplot1'].",";
					  
					  $grafpower0 =  $grafpower0."".$row['powersplot0'].",";
					  $grafpower1 =  $grafpower1."".$row['powersplot1'].",";
					  
					  $graftotal0 =  $graftotal0."".$row['totalrippleplot0'].",";
					  $graftotal1 =  $graftotal1."".$row['totalrippleplot1'].",";
					  
					  
					  ?>
					 
					  <?php
				  }
				  
				  
				  ?>
                 
                  
			
			 </div> 
			 

        </section>
		<section class="col-lg-4 connectedSortable ui-sortable">
		

				<div class="card">
					<div class="card-header">
					
					
						<h5 class="card-title colorazulfiplex"><b>RX RIPPLE</b></h5>
						
						
					</div>
			<div class="chart">
                      <!-- Sales Chart Canvas -->
					   
                       <canvas id="salesChartlevel" height="280" style="height: 280;"></canvas>
					   </div>
					
			
				</div>
		 </section>
		 <section class="col-lg-4 connectedSortable ui-sortable">
		

				<div class="card">
					<div class="card-header">
						<h5 class="card-title colorazulfiplex"><b>TX RIPPLE</b></h5>
						
					
					</div>
			<div class="chart">
                      <!-- Sales Chart Canvas -->
					   <canvas id="salesChartpowers" height="280" style="height: 280;"></canvas>
                    
					   </div>
					
				
				</div>
		 </section>
		
		 <section class="col-lg-3	 connectedSortable ui-sortable "> 
		 	<div class="card">
				<div class="card-header colorazulfiplex  "><b>Plots</b>
				</div>
				<div class="card-body">
					<table class="table table-sm table-hover table-striped table-bordered textotabla10">
					 
					  <tbody>
						<tr>
						  <td style="width: 60%" class="">Not Equalized WITHOUT AGC</td>
						  <td>
							<div id="galley">
								  <ul class="pictures">
								  <?php
								  $vt=0;
									  foreach ($datapowers as $rowd) 
											  {
												  ?>
												<li>
													<img   data-original="../plotsimg/<?php echo trim($rowd['levelsimgs0']);?>.png" src="../plotsimg/<?php echo trim($rowd['levelsimgs0']);?>.png" > 
													
												</li>
												  <?php
												  $vt= $vt + 1;
												if ($vt ==1)
												{
													   break;
												}
											  }
											?>

								  </ul>
								</div>
						  </td>						 
						</tr>
							<tr>
						  <td style="width: 60%" class="colorazulfiplex"> Equalized WITHOUT AGC</td>
						  <td><div id="galley">
								  <ul class="pictures">
								  <?php
								  $vt=0;
									  foreach ($datapowers as $rowd) 
											  {
												  ?>
												<li>
													<img   data-original="../plotsimg/<?php echo trim($rowd['levelsimgs0']);?>.png" src="../plotsimg/<?php echo trim($rowd['levelsimgs0']);?>.png" width="10%"> 
													
												</li>
												  <?php
												  $vt= $vt + 1;
												if ($vt ==1)
												{
													   break;
												}
											  }
											?>

								  </ul>
								</div></td>
						  
						</tr>
						<tr>
						   <td style="width: 60%" class="colorazulfiplex">Not Equalized  AGC</td>
						  <td><div id="galley">
								  <ul class="pictures">
								  <?php
								  $vt=0;
									  foreach ($datapowers as $rowd) 
											  {
												  ?>
												<li>
													<img   data-original="../plotsimg/<?php echo trim($rowd['levelsimgs0']);?>.png" src="../plotsimg/<?php echo trim($rowd['levelsimgs0']);?>.png" width="10%"> 
													
												</li>
												  <?php
												  $vt= $vt + 1;
												if ($vt ==1)
												{
													   break;
												}
											  }
											?>

								  </ul>
								</div></td>	
						</tr>
						<tr>
						   <td style="width: 60%" class="colorazulfiplex">Equalized  AGC</td>
						  <td><div id="galley">
								  <ul class="pictures">
								  <?php
								  $vt=0;
									  foreach ($datapowers as $rowd) 
											  {
												  ?>
												<li>
													<img   data-original="../plotsimg/<?php echo trim($rowd['levelsimgs0']);?>.png" src="../plotsimg/<?php echo trim($rowd['levelsimgs0']);?>.png" width="10%"> 
													
												</li>
												  <?php
												  $vt= $vt + 1;
												if ($vt ==1)
												{
													   break;
												}
											  }
											?>

								  </ul>
								</div></td>	
						</tr>
						
					  </tbody>
					</table>
				</div>
			
					          
				</div>
  		
		  </section>
		
		
		 <section class="col-lg-9 connectedSortable ui-sortable ">   
		 <div class="card">
		
		  	<div class="card-body">
		  <table class="table table-sm table-hover table-striped table-bordered text-center textotabla10">
                
                     <thead class="thead-dark">
                    <tr>
                      <th class="table-dark text-left">Freq - [MHz]</th>
					  <?php
					  $mi=0;
					   foreach($arrayfreq as $fec) 
							{
								echo "<th>" . $fec . "</th>";
								$mi=$mi+1;
								if($mi==11)
								{
									break;
								}
							}
					?>                     
                    </tr>
                  </thead>
                  <tbody>
				  	<tr>
                      <td class="table-dark text-left">Total Ripple not eq</td>
                      <?php
					   $mi=0;
					   foreach($arraytotalrippleplot0 as $leveldat) 
							{
								echo "<td>" . $leveldat . "</td>";
								$mi=$mi+1;
								if($mi==11)
								{
									break;
								}
							}
					?>   		  					  
                    </tr> 	
					<tr>
                      <td class="table-dark text-left">Total Ripple eq</td>
                      <?php
					   $mi=0;
					   foreach($arraytotalrippleplot1 as $leveldat) 
							{
								echo "<td>" . $leveldat . "</td>";
								$mi=$mi+1;
								if($mi==11)
								{
									break;
								}
							}
					?>   		  					  
                    </tr>
					 	<tr>
                      <td class="table-dark text-left">Rx Ripple not eq</td>
                      <?php
					   $mi=0;
					   foreach($arraylevel0 as $leveldat) 
							{
								echo "<td>" . $leveldat . "</td>";
								$mi=$mi+1;
								if($mi==11)
								{
									break;
								}
							}
					?>   		  					  
                    </tr>
					 	<tr>
                      <td class="table-dark text-left">Rx Ripple eq</td>
                      <?php
					    $mi=0;
					   foreach($arraylevel1 as $leveldat) 
							{
								echo "<td>" . $leveldat . "</td>";
								$mi=$mi+1;
								if($mi==11)
								{
									break;
								}
							}
					?>   		  					  
                    </tr>
					 	<tr>
                      <td class="table-dark text-left">Tx Ripple not eq</td>
                      <?php
					    $mi=0;
					   foreach($arraypowers0 as $leveldat) 
							{
								echo "<td>" . $leveldat . "</td>";
								
								$mi=$mi+1;
								if($mi==11)
								{
									break;
								}
							}
					?>   		  					  
                    </tr>
					 	<tr>
                      <td class="table-dark text-left">Tx Ripple eq</td>
                      <?php
					    $mi=0;
					   foreach($arraypowers1 as $leveldat) 
							{
								echo "<td>" . $leveldat . "</td>";
								$mi=$mi+1;
								if($mi==11)
								{
									break;
								}
							}
							
						//	levelsplot -> TotalRipplePlot -- nuevo titulo del gráfico: Total Ripple
						//  Powersplot -> TxRipplePlot -- nuevo titulo del gráfico: Rx Ripple
						//  RxRipplePlot es el nuevo campo -- nuevo titulo del gráfico: Tx Ripple

					?>   		  					  
                    </tr>
					    <br>
                     
                  </tbody>
				    </table>
					
					 </div>
					</section>
					 </div>
          <!-- /.col -->
        		
		
      </div>
      <!-- /.timeline -->
  </div>
    </section>
    <!-- /.content -->
	

<!-- The end Modal para el zoom de las imagenes plot -->
	
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
</div>

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
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>

<script type="text/javascript" src="js/tabulator.min.js"></script>
<script src="js/viewer.js"></script>
</body>

<script>

function makerzoommarquieto(imgruta)
{
	   // Get the modal
var modal_zoom = document.getElementById("myModalzoom");

// Get the image and insert it inside the modal - use its "alt" text as a caption
var img = document.getElementById("myImg");
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");

 modal.style.display = "block";
  modalImg.src = imgruta;
 
	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("close")[0];

	// When the user clicks on <span> (x), close the modal
	
}
   
   // Get the modal
var modal = document.getElementById("myModalzoom");

// Get the image and insert it inside the modal - use its "alt" text as a caption
var img = document.getElementById("myImg");
img.style.display = "none";
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
img.onclick = function(){
  modal.style.display = "block";
  modalImg.src = this.src;
  captionText.innerHTML = this.alt;
}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() { 
  modal.style.display = "none";
}

$( document ).on( 'keydown', function ( e ) {
    if ( e.keyCode === 27 ) { // ESC
       modal.style.display = "none";
    }
});

   
   
</script>

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
     		
	//  var salesChartCanvas = $('#salesChart').get(0).getContext('2d');
	  var salesChartlevel = $('#salesChartlevel').get(0).getContext('2d');
	  var salesChartpowers = $('#salesChartpowers').get(0).getContext('2d'); 
	  var salesCharttxripple = $('#salesCharttxripple').get(0).getContext('2d'); 
	  

    var salesChartDatatotales = {
    labels  : [<?php echo  $freqlabel;?>],
    datasets: [
	  {
        label               : 'Equalized',
		     backgroundColor     : 'rgba(60,141,188,0.3)',
        borderColor         : 'rgba(60,141,188,1)',
        pointRadius          : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
     	 data                : [<?php echo  $graftotal0;?>]
			  
      },
	   {
        label               : 'Not Equalized',		
		backgroundColor     : 'rgba(255, 99, 132, 0.5)',
        borderColor         : 'rgba(255, 99, 132, 1)',
        pointRadius         : false,
        pointColor          : 'rgba(255, 99, 132, 1)',
        pointStrokeColor    : '#c1c7d1',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(255, 99, 132, 1)',		
     	 data          :[<?php echo  $graftotal1;?>]
      },
    ]
  };
  
  var salesChartDatalevels = {
    labels  : [<?php echo  $freqlabel;?>],
    datasets: [
	  {
        label               : 'Equalized',
		     backgroundColor     : 'rgba(60,141,188,0.3)',
        borderColor         : 'rgba(60,141,188,1)',
        pointRadius          : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
     	 data                : [<?php echo  $graflevels0;?>]
			  
      },
	   {
        label               : 'Not Equalized',		
		backgroundColor     : 'rgba(255, 99, 132, 0.5)',
        borderColor         : 'rgba(255, 99, 132, 1)',
        pointRadius         : false,
        pointColor          : 'rgba(255, 99, 132, 1)',
        pointStrokeColor    : '#c1c7d1',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(255, 99, 132, 1)',		
     	 data          :[<?php echo  $graflevels1;?>]
      },
    ]
  };
  
   var salesChartDatalpowees = {
    labels  : [<?php echo  $freqlabel;?>],
    datasets: [
	  {
        label               : 'Equalized',
		     backgroundColor     : 'rgba(60,141,188,0.3)',
        borderColor         : 'rgba(60,141,188,1)',
        pointRadius          : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
     	 data                : [<?php echo  $grafpower0;?>]
			  
      },
	   {
        label               : 'Not Equalized',		
		backgroundColor     : 'rgba(255, 99, 132, 0.5)',
        borderColor         : 'rgba(255, 99, 132, 1)',
        pointRadius         : false,
        pointColor          : 'rgba(255, 99, 132, 1)',
        pointStrokeColor    : '#c1c7d1',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(255, 99, 132, 1)',		
     	 data          :[<?php echo  $grafpower1;?>]
      },
    ]
  }
;


  var salesChartOptions = {
    maintainAspectRatio : false,
    responsive : true,	
    legend: {
      display: true
    },
	
    scales: {
      xAxes: [{
        gridLines : {
          display : true,		 
        }
		
	
      }],
      yAxes: [{
        gridLines : {
          display : true,
		 
        }
	
		
      }]
    }
  }

  // This will get the first returned node in the jQuery collection.
 /* var salesChart = new Chart(salesChartCanvas, { 
      type: 'line', 	
      data: salesChartData, 	 
      options: salesChartOptions
    });*/
	
	  var salesChart2 = new Chart(salesChartlevel, { 
      type: 'line', 	
      data: salesChartDatalevels, 	 
      options: salesChartOptions
    });
	
	
	  var salesChart3 = new Chart(salesChartpowers, { 
      type: 'line', 	
      data: salesChartDatalpowees, 	 
      options: salesChartOptions
    });
	
	  var salesChart4 = new Chart(salesCharttxripple, { 
      type: 'line', 	
      data: salesChartDatatotales, 	 
      options: salesChartOptions
    });
  
      window.addEventListener('DOMContentLoaded', function () {
      var galley = document.getElementById('galley');
      var viewer = new Viewer(galley, {
        url: 'data-original',
        title: function (image) {
          return image.alt + ' (' + (this.index + 1) + '/' + this.length + ')';
        },
      });
    });
	
	 window.addEventListener('DOMContentLoaded', function () {
      var galley = document.getElementById('galley2');
      var viewer = new Viewer(galley, {
        url: 'data-original',
        title: function (image) {
          return image.alt + ' (' + (this.index + 1) + '/' + this.length + ')';
        },
      });
    });

   
</script>

</html>

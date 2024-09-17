<!DOCTYPE html>
<?php 

// Desactivar toda notificación de error
//error_reporting(0);
// Notificar todos los errores de PHP (ver el registro de cambios)
//error_reporting(E_ALL);
 include("db_conectbypdf.php"); 
 
 	session_start();
	
	 
 require 'aws/aws-autoloader.php';
 require 'aws/fplmm.php';


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
  <link rel="stylesheet" href="plugins/ion-rangeslider/css/ion.rangeSlider.css">
  
  <!-- AdminLTE css -->
  <link rel="stylesheet" href="dist/css/adminlte.css">
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

.card-title {
    float: left;
    font-size: 14px;
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


.tooltipmarco {
    background-color: #0053a1;
    color:  #ffffff;
    padding: 5px 10px;
    border-radius: 4px;
    font-size: 14px;
	 opacity: 0.9;
  }

p {
    margin-top: 6px;
}
  </style>
  
</head>
<form name="frma" id="frma">



<input type="hidden" name="uso" id="uso" value="0">
<body class="hold-transition sidebar-mini sidebar-collapse">

  <div class="">
  


<!-- Site wrapper -->
<div class="	">
  <!-- Navbar -->
 


  <!-- Content Wrapper. Contains page content -->
  <div class="">
    <!-- Content Header (Page header) -->



    <!-- Main content 
	
	levelsplot -> TotalRipplePlot -- nuevo titulo del gráfico: Total Ripple
Powersplot -> TxRipplePlot -- nuevo titulo del gráfico: Rx Ripple
RxRipplePlot es el nuevo campo -- nuevo titulo del gráfico: Tx Ripple
-->
<?php
	$vparam_vnrounitsn = $_REQUEST['unitsn']; ///// "20000000fu";	
	$vparam_vidrun = $_REQUEST['idrun']; ///// "20000000fu";	

?>
    <section class="content">
	
	 <div class="container-fluid"><br>
 	        <div class="row">
	
		 <section class="col-lg-12 connectedSortable ui-sortable">
		  <div class="rowmm fondoblanco">
				 
				 <div class="col-lg-12">

				  <!-- inicio cuadro resumen  --->
				  <?php
		
  

 
	/*$sql = $connect->prepare("select fas_outcome_integral.* , fasoutcometypename from fas_outcome_integral
	inner join fas_outcome_category_type
	on  fas_outcome_category_type.idfasoutcomecat	=	fas_outcome_integral.idfasoutcomecat and
		fas_outcome_category_type.idtype			=	fas_outcome_integral.idtype
	where fas_outcome_integral.reference in ( 
					select reference from fas_outcome_integral
					where datetimeref in (
										select max(datetimeref) from fas_outcome_integral
										where idfasoutcomecat = 0 AND idtype = 4 and v_string =  '".$vparam_vnrounitsn."' 
										 )
					and idfasoutcomecat = 0 AND idtype = 4 and v_string = '".$vparam_vnrounitsn."') ");*/

					$sql = $connect->prepare("select fas_outcome_integral.* , fasoutcometypename from fas_outcome_integral
					inner join fas_outcome_category_type
					on  fas_outcome_category_type.idfasoutcomecat	=	fas_outcome_integral.idfasoutcomecat and
						fas_outcome_category_type.idtype			=	fas_outcome_integral.idtype
					where fas_outcome_integral.reference =".$vparam_vidrun."
								 ");

/// $sql->bindParam(':vvidsndib', $vparam_vnrounitsn);
$sql->execute();
$resultado3 = $sql->fetchAll();


$v_so="";
$_ciu="";
$_userfas="";
$_Fw_uC="";
$_Fw_fpga="";
$$_Fw_eth="";
$fas_version="";
$descriptionmm="";
foreach ($resultado3 as $row2) 
{
	////// SO : 2
	$idruninfom = $row2['reference'];
	 if( $row2['idtype'] ==2)
	 {
		$v_so=$row2['v_string'];
	 }
	 ////// CIU:3
	 if( $row2['idtype'] ==3)
	 {
		$_ciu=$row2['v_string'];
	 }
	 ////// userFAS:16
	 if( $row2['idtype'] ==16)
	 {
		$_userfas=$row2['v_string'];
	 }
	 ////// FW uC:9
	 if( $row2['idtype'] ==9)
	 {
		$_Fw_uC=$row2['v_string'];
	 }
	  ////// FW EthuC:10
	  if( $row2['idtype'] ==10)
	  {
		 $_Fw_eth=$row2['v_string'];
	  }
	   ////// FW FPGA:8
	 if( $row2['idtype'] ==8)
	 {
		$_Fw_fpga=$row2['v_string'];
	 }
	 //////FasVersion: 7 
	 if( $row2['idtype'] ==7)
	 {
		$fas_version=$row2['v_string'];
	 }
	 // buscamos descripcion

	 $sqldsc = $connect->prepare("select * from fnt_select_allproducts_maxrev() where   modelciu = '".$_ciu."' ");
 
	 $descriptionmm="";
 	 $sqldsc->execute();
     $resultdescc = $sqldsc->fetchAll();
	 foreach ($resultdescc as $rowdesc) 
		{
			$descriptionmm=$rowdesc['description'];
			$idbusineesdelproducto=$rowdesc['idbusiness'];

			
			
		}
	 
 
}

?>


<table class="table table-sm table-hover table-striped table-bordered text-center textotabla10">
<tr>
<td class="table-dark text-center"> </td>
<td class="table-dark text-center"> </td>

</tr>
<tr>
<td style='text-align: left'>CIU: <strong><?php echo $_ciu;?></strong></td>
<td style='text-align: right'>SN: <strong><?php echo $vparam_vnrounitsn;?></strong></td>

</tr>
<tr>
<td colspan="2" style='text-align: left'>DESCRIPTION: <b>
<?php echo $descriptionmm ; ?></b>
</td>
</tr>

</table>

 

<table class="table table-sm table-hover table-striped table-bordered text-center textotabla10">
<tr>
<td style='width: 30%;text-align: left'>Calibrator: <strong><?php echo $_userfas;?></strong></td>
<td style='width: 30%;text-align: left'> </td>
<td style='width: 30%;text-align: right'>FAS Version: <strong><?php echo 	$fas_version;?></strong></td>

</tr>
 
	<tr>
<td  style='text-align: left'>FW uC: <strong> <?php echo 	$_Fw_uC;?> </strong></td>
<td style='width: 30%;text-align: left'> </td>
<td style='width: 30%;text-align: right'>RunInfo# <strong><?php echo $idruninfom;?></strong></td>

</tr>
 

</table>

						  <?php
						 
					//////////////////////////////////////////	 


						 ?>



<h5 style="text-decoration: underline;font-size:18px ">Parameters:</h5>
			
			 </div> 
			 <br><br><br><br><br>

	 
  <div class="container-fluid " id="divgrafico700mp" name="divgrafico700mp" >
     
       <div class="col-12">
       <hr style=" border: 1px solid #007bff;">
       <div class="col-12   " id="divgraf_current_pwr" name="divgraf_current_pwr">
             
             <div class="chart">
               <canvas id="graf_current_pwr" height="280" style="height: 280;"></canvas>
             </div>
         </div>

         <div class="row">
         <div class="col-12    " id="divgraf_volt_read" name="divgraf_volt_read">
          
          <div class="chart">
            <canvas id="graf_volt_read" height="280" style="height: 280;"></canvas>
          </div>
      </div>
         
          <div class="col-12   " id="divgraf_current_read" name="divgraf_current_read">
          
                <div class="chart">
                  <canvas id="graf_current_read" height="280" style="height: 280;" ></canvas>
                </div>
          </div>
                    
         
         
     </div>
			
        </section>

	 
		 
		
					
          <!-- /.col -->
        		<br><br>
		
      </div>
      <!-- /.timeline -->
  </div>
    </section>
    <!-- /.content -->
	<br><br>
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

<script src="plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>

<script src="crypto-js.js"></script><!-- https://github.com/brix/crypto-js/releases crypto-js.js can be download from here -->

<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="toastr.min.js"></script>

<script src="licencefiplex_mm.js"></script>
<script src="licencefiplex1.js"></script>
<script src="js/jquery.inactivityTimeout.js"></script>

<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
 <script src="js/eModal.min.js" type="text/javascript" />
<!-- Ion Slider -->
<script src="plugins/ion-rangeslider/js/ion.rangeSlider.min.js"></script>

<script type="text/javascript" src="js/tabulator.min.js"></script>
<script src="js/viewer.js"></script>
<script src="js/popperparacalibratio.min.js"></script>
<script src="plugins/moment/moment.min.js"></script>
<script src="js/moment-timezone-with-data.js"></script>
</body>



<script type="text/javascript">


	$( document ).ready(function() {
		
		var interval = setInterval(function() {
			 
			 var momentNow = moment();
			 var newYork    = momentNow.tz('America/New_York').format('ha z');
			 $('#date-part').html(momentNow.format('YYYY/MM/DD') 	  );
			 $('#time-part').html(momentNow.format('hh:mm:ss'));
			 }, 100);


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
			
				armar_graficos_imdstress();
  
	});
	
	var cant_veces_controlo = 0;
	var cant_veces_controlo_limit = 15;
//var container = document.getElementById('visualization');
//var timeline = new vis.Timeline(container);
var refreshIntervalIdbuscaruninfo =0;

var   datamm={};
var iduniqueop_band_0_uldl_0_tx ="";
var			iduniqueop_band_0_uldl_1_tx ="";
	var		iduniqueop_band_1_uldl_0_tx ="";
	var		iduniqueop_band_1_uldl_1_tx ="";
  var   label_tx={};
  var   label_tx_0_1={};
  var   label_tx2="";
  var label_tx_1="";
  var datax ='';
  var label_700_compartir= '';

var graf_total_0_0="N";
var graf_rx_0_0="N";
var graf_tx_0_0="N";
var graf_total_0_1="N";
var graf_rx_0_1="N";
var graf_tx_0_1="N";
var graf_total_1_0="N";
var graf_rx_1_0="N";
var graf_tx_1_0="N";
var graf_total_1_1="N";
var graf_rx_1_1="N";
var graf_tx_1_1="N";

// recuperamos el querystring
const querystring = window.location.search
console.log(querystring) // '?q=pisos+en+barcelona&ciudad=Barcelona'

// usando el querystring, creamos un objeto del tipo URLSearchParams
const params = new URLSearchParams(querystring)

function window_mouseout( obj, evt, fn ) {

if ( obj.addEventListener ) {

    obj.addEventListener( evt, fn, false );
}
else if ( obj.attachEvent ) {

    obj.attachEvent( 'on' + evt, fn );
}
}


function secondsToString(seconds) {
  var hour = Math.floor(seconds / 3600);
  hour = (hour < 10)? '0' + hour : hour;
  var minute = Math.floor((seconds / 60) % 60);
  minute = (minute < 10)? '0' + minute : minute;
  var second = seconds % 60;
  second = (second < 10)? '0' + second : second;
  return hour + ':' + minute + ':' + second;
}



	function armar_graficos_imdstress()
{


	var   data_volt_limit_lower=[];
	var   data_volt_limit_upper=[];
        ///////////////////////
        $.ajax
        ({ 
          url: 'ajax_graph_reportstressbbucharger.php?unitsn='+params.get('unitsn')+'&idrun='+params.get('idrun'),
          data: "idns="+params.get('idr'),	          type: 'post',
          async:true,
          cache:false,
          success: function(data)
          {
        ///    console.log('IMD STRESS');
              
          $('#msjwaitline ').hide();
              ///console.log(JSON.parse( data.label_tx ));
              //var keyssmm = Object.keys(datax);
              ///console.log(keyssmm);
               var graf_current_read = $('#graf_current_read').get(0).getContext('2d'); 
               var graf_volt_read   = $('#graf_volt_read').get(0).getContext('2d'); 
                var graf_current_pwr  = $('#graf_current_pwr').get(0).getContext('2d'); 
  

         //   console.log('Lower Limit:::: '+ data.volt_lower_limit  );
		//	console.log('upper Limit:::: '+ data.volt_upeer_limit  );

                          datos_values_pacurrent_voltread = data.values_pacurrent_voltread.split(",");  
                      //    datos_values_pacurrent_voltreadFIP485 = data.values_pacurrent_voltreadFIP485.split(",");  
                          label_values_pacurrent_voltread = data.label_pacurrent_voltread.split(",");
                          
                          
                          datos_values_pacurrent_read = data.values_pacurrent_read.split(",");  
                  //        datos_values_pacurrent_readsensor = data.values_pacurrent_readcurrentsendor.split(",");  

                          label_values_pacurrent_read = data.label_pacurrent_read.split(",");  

                          datos_values_pacurrent_pwr = data.values_pacurrent_pwr.split(",");  
                          label_values_pacurrent_pwr = data.label_pacurrent_pwr.split(",");  

                            for ( var i = 0, j = datos_values_pacurrent_voltread.length ; i < j; i++ ) {
                              if ( datos_values_pacurrent_voltread[ i ] == '' ) {
                                datos_values_pacurrent_voltread.splice( i, 1 );
                              i--;
                              }

							  data_volt_limit_lower.push(data.volt_lower_limit);
						      data_volt_limit_upper.push(data.volt_upeer_limit);

                            }

                         /*   for ( var i = 0, j = datos_values_pacurrent_voltreadFIP485.length ; i < j; i++ ) {
                              if ( datos_values_pacurrent_voltreadFIP485[ i ] == '' ) {
                                datos_values_pacurrent_voltreadFIP485.splice( i, 1 );
                              i--;
                              }
                            }*/

                            for ( var i = 0, j = datos_values_pacurrent_read.length ; i < j; i++ ) {
                              if ( datos_values_pacurrent_read[ i ] == '' ) {
                                datos_values_pacurrent_read.splice( i, 1 );
                              i--;
                              }
                            }

                           /* for ( var i = 0, j = datos_values_pacurrent_readsensor.length ; i < j; i++ ) {
                              if ( datos_values_pacurrent_readsensor[ i ] == '' ) {
                                datos_values_pacurrent_readsensor.splice( i, 1 );
                              i--;
                              }
                            }*/

                            for ( var i = 0, j = datos_values_pacurrent_pwr.length ; i < j; i++ ) {
                              if ( datos_values_pacurrent_pwr[ i ] == '' ) {
                                datos_values_pacurrent_pwr.splice( i, 1 );
                              i--;
                              }
                            }
                             
                           console.log(datos_values_pacurrent_pwr); 
                           var    sumarmunitos = new Date('2020-01-01 00:00:00');
                          var nuevolabeltemp_0_0_temp = [];
                                           for (let i = 0; i < label_values_pacurrent_voltread.length; i++) 
                                                  {
                                              
                                                  var date1 = moment("2022-01-01 " + label_values_pacurrent_voltread[0]);
                                                  var date2 = moment("2022-01-01 " +label_values_pacurrent_voltread[i]);
                                                
                                          
                                                  var diff = date2.diff(date1,'s');
 
                                                    nuevolabeltemp_0_0_temp.push(secondsToString(diff));
                                        
                                                  
                                                  }

                         var nuevolabepacurrent_read = [];
                                           for (let i = 0; i < label_values_pacurrent_read.length; i++) 
                                                  {
                                              
                                                  var date1 = moment("2022-01-01 " + label_values_pacurrent_read[0]);
                                                  var date2 = moment("2022-01-01 " +label_values_pacurrent_read[i]);
                                                
                                          
                                                  var diff = date2.diff(date1,'s');
 
                                                  nuevolabepacurrent_read.push(secondsToString(diff));
                                        
                                                  
                                                  }

                        var nuevolabepacurrent_pwr = [];
                                           for (let i = 0; i < label_values_pacurrent_pwr.length; i++) 
                                                  {
                                              
                                                  var date1 = moment("2022-01-01 " + label_values_pacurrent_pwr[0]);
                                                  var date2 = moment("2022-01-01 " +label_values_pacurrent_pwr[i]);
                                                
                                          
                                                  var diff = date2.diff(date1,'s');
 
                                                  nuevolabepacurrent_pwr.push(secondsToString(diff));
                                        
                                                  
                                                  }
                            
                       //     console.log(nuevolabeltemp_0_0_temp); 

                                   var datos_grafico_allband_temp = {
                                        labels  : nuevolabeltemp_0_0_temp,
                                                datasets: [
                                                {
                                                  label               :  'Voltage Read ELOAD  ',                                                  
                                                    borderColor         : 'rgba(60,141,188,1)',
													backgroundColor     : 'rgba(60,141,188,0.1)',
                                                    pointRadius          : false,
                                                    pointColor          : '#3b8bba',
                                                    pointHighlightFill  : '#fff',
                                                
                                                  data                :  datos_values_pacurrent_voltread                                
                                                  },
                                                  {
                                                  label               :  'Voltage Lower Limit [' +  parseFloat( data.volt_lower_limit).toFixed(2)  +'V]',                                               
                                                  borderColor         : 'rgba(255, 99, 132, 1)',
												  backgroundColor     : 'rgba(60,141,188,0)',
                                                  pointRadius         : false,
                                                  pointColor          : 'rgba(255, 99, 132, 1)',
                                                   pointHighlightFill  : '#fff',
                                                    data                :  data_volt_limit_lower                                
                                                  },
                                                  {
                                                  label               :  'Voltage Upper Limit [' + parseFloat( data.volt_upeer_limit).toFixed(2)   + 'V]',                                                 
												  borderColor         : 'rgba(255, 99, 132, 1)',
												  backgroundColor     : 'rgba(60,141,188,0)',
                                                  pointRadius         : false,
                                                  pointColor          : 'rgba(255, 0, 132, 1)',
                                                   pointHighlightFill  : '#fff',
                                                   data                :  data_volt_limit_upper                        
                                                  }
                                                  
                                                
                                          ]
                                        };

                                        var datos_grafico_pacurrent_read = {
                                        labels  : nuevolabeltemp_0_0_temp,
                                                datasets: [
                                                {
                                                  label               :  'Current Read ELOAD',
                                                    backgroundColor     : 'rgba(60,141,188,0.1)',
                                                    borderColor         : 'rgba(60,141,188,1)',
                                                    pointRadius          : false,
                                                    pointColor          : '#3b8bba',
                                                    pointStrokeColor    : 'rgba(60,141,188,1)',
                                                    pointHighlightFill  : '#fff',
                                                    pointHighlightStroke: 'rgba(60,141,188,1)',
                                                  data                :  datos_values_pacurrent_read                                
                                                  }/*,
                                                  {
                                                  label               :  'Main Current Sensor Read  ',
                                                  backgroundColor     : 'rgba(255, 99, 132, 0.5)',
                                                  borderColor         : 'rgba(255, 99, 132, 1)',
                                                  pointRadius         : false,
                                                  pointColor          : 'rgba(255, 99, 132, 1)',
                                                  pointStrokeColor    : '#c1c7d1',
                                                  pointHighlightFill  : '#fff',
                                                  pointHighlightStroke: 'rgba(255, 99, 132, 1)',		
                                                  data                :  datos_values_pacurrent_readsensor                                
                                                  }*/
                                                  
                                                
                                          ]
                                        };

                                        
                                        var datos_grafico_pacurrent_pwr = {
                                        labels  : nuevolabeltemp_0_0_temp,
                                                datasets: [
                                                {
                                                  label               :  'Load Power [W]',
                                                    backgroundColor     : 'rgba(60,141,188,0.1)',
                                                    borderColor         : 'rgba(60,141,188,1)',
                                                    pointRadius          : false,
                                                    pointColor          : '#3b8bba',
                                                    pointStrokeColor    : 'rgba(60,141,188,1)',
                                                    pointHighlightFill  : '#fff',
                                                    pointHighlightStroke: 'rgba(60,141,188,1)',
                                                  data                :  datos_values_pacurrent_pwr                                
                                                  },
                                                
                                          ]
                                        };

                                        var optiontemp_2 = {                             
                                          maintainAspectRatio : false,
                                          responsive : true,	
                                          legend: {
                                            display: true
                                          },
                                          title: {
                                              display: false,
                                              text: ' '
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
                                          
                                              } ,ticks: {
                                
                                                suggestedMin: -1,
                                                 suggestedMax: 3
                                              }
                                        
                                          
                                            }]
                                          }
                                        }

                                        var optiontemp_3 = {                             
                                          maintainAspectRatio : false,
                                          responsive : true,	
                                          legend: {
                                            display: true
                                          },
                                          title: {
                                              display: false,
                                              text: ' '
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
                                          
                                              } ,ticks: {
                                
                                                suggestedMin: 0,
                                                 suggestedMax: 100
                                              }
                                        
                                          
                                            }]
                                          }
                                        }

                                        var optiontemp = {                             
                                          maintainAspectRatio : false,
                                          responsive : true,	
                                          legend: {
                                            display: true
                                          },
                                          title: {
                                              display: false,
                                              text: '-- '
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
                                          
                                              } ,ticks: {
                                
                                                suggestedMin: 27,
                                                 suggestedMax: 29
                                              }
                                        
                                          
                                            }]
                                          }
                                        }

                      var rpt_grafico700imdstress01 = new Chart(graf_volt_read, { 
                              type: 'line', 	
                              data: datos_grafico_allband_temp, 	 
                              options: optiontemp 
                            });

                       var rpt_grafico700imdstress02 = new Chart(graf_current_read, { 
                              type: 'line', 	
                              data: datos_grafico_pacurrent_read, 	 
                              options: optiontemp_2
                            });
                          
                            var rpt_grafico700imdstress03 = new Chart(graf_current_pwr, { 
                              type: 'line', 	
                              data: datos_grafico_pacurrent_pwr, 	 
                              options: optiontemp_3
                            });
                       


            }
        });


}

   
  

</script>

</html>

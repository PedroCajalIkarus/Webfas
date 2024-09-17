
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
      font-size:10px;
    }
    table { font-size: 12px}

    
    </style>
    
</head>
<form name="frma" id="frma" action="show_tracking_polypaste.php" method="post" class="form-horizontal">
<?php 

	
// Desactivar toda notificación de error
//error_reporting(0);
// Notificar todos los errores de PHP (ver el registro de cambios)
error_reporting(E_ALL);
 include("db_conect.php"); 
 

 function url_exists( $url = NULL ) {
 
  if( empty( $url ) ){
      return false;
  }

  $options['http'] = array(
      'method' => "HEAD",
      'ignore_errors' => 1,
      'max_redirects' => 0
  );
  $body = @file_get_contents( $url, NULL, stream_context_create( $options ) );
  
  // Ver http://php.net/manual/es/reserved.variables.httpresponseheader.php
  if( isset( $http_response_header ) ) {
      sscanf( $http_response_header[0], 'HTTP/%*d.%*d %d', $httpcode );

      // Aceptar solo respuesta 200 (Ok), 301 (redirección permanente) o 302 (redirección temporal)
      $accepted_response = array( 200, 301, 302 );
      if( in_array( $httpcode, $accepted_response ) ) {
          return true;
      } else {
          return false;
      }
   } else {
       return false;
   }
}
			
 
 	session_start();

     $sanitized_n = filter_var($_REQUEST['soparam'], FILTER_SANITIZE_STRING);
     if (filter_var($sanitized_n, FILTER_SANITIZE_STRING)) {
        $soparam = $_REQUEST['soparam']; ///
     }
     $sanitized_nso = filter_var($_REQUEST['snparam'], FILTER_SANITIZE_STRING);
     if (filter_var($sanitized_n, FILTER_SANITIZE_STRING)) {
        $snparam = $_REQUEST['snparam']; ///
     }
///elnomso 
     
   
$sql= "select distinct orders_sn.*, modelciu, so_soft_external,  quantity ,products.description descripcionciu from orders_sn 
inner join orders on orders_sn.idorders = orders.idorders
inner join products on products.idproduct = orders.idproduct
where orders_sn.idorders =". $soparam."  and idnroserie =0 order by idrev desc limit 1";

       


							   $datacabez = $connect->query($sql)->fetchAll();
								$idtemp=0;
								$vejecucion = 1;
             
          $v_idproduct = 0;                     
								  foreach ($datacabez as $rowheaders) 
								  {
                    $v_idproduct = $rowheaders['idproduct'];
                    $vv_modelciu = $rowheaders['modelciu'];  
                    $vv_so = $rowheaders['so_soft_external']; 
                            

									  ?>
                                        
                                       
                                       
        <br>
            <div class="card" data-select2-id="10">
               
         

            
                                      <?php			 
								  }

                              
								  ?>
                      <div class="container-fluid">
                  
                
                    
  
</p>
<div class="row">
  <div class="col-12">
    <div class="collapse multi-collapse show   " id="multiCollapseExample1">

    <?php

     
      
$Sql_polypaste = $connect->prepare("select reference from fas_outcome_integral where datetimeref in( 
 select max(datetimeref) from fas_outcome_integral where reference in( select reference from fas_outcome_integral where idtype = 4 and v_string= '".$snparam."' )
       and fas_outcome_integral.idfasoutcomecat =12 and idtype = 14 ) and fas_outcome_integral.idfasoutcomecat =12 and idtype=14  ");                                 
$Sql_polypaste->execute();
$result_ifautotestpp = $Sql_polypaste->fetchAll();	
foreach ($result_ifautotestpp as $row_autotestpp)
{
  $idruninfoautoburning= $row_autotestpp['reference'] ; 
}   
//echo "HOLA".  $idruninfoautoburning;

$classocultar="";
if ($idruninfoautoburning =="")
{
 $classocultar="";
}
else
{
 $classocultar=" d-none ";
  ?>
  
  <div id="frmmsjrojo" name ="frmmsjrojo">
  <div class="info-box bg-info">
              <span class="info-box-icon"><i class="fas fa-1x fa-sync-alt"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">
                  <h5>Poly paste already done</h5></span>
                

                <div class="progress">
                  <div class="progress-bar" style="width: 100%"></div>
                </div>
                <span class="progress-description">
                <h6>  Want to do it again?</h6>
                
                </span>
                
              </div>
              <!-- /.info-box-content -->
              
            </div>
            <hr>
            <button type="button" class="btn btn-block btn-outline-success btn-xs" onclick="habilitarfrm()">Re Run</button>

            <br>
    </div>
  <?php
}
?>

      <div class="card card-body <?php echo $classocultar;?>" id="frm1" name="frm1">
      <p align="center">  

  
       <span style="font-size:14pt;"><b> Find the PP-SHEET shown below and scan the barcode. </b></span>
     
        <div class=" row" >
                
                <div class="col-sm-4">
                </div>	        
                <div class="col-sm-4">	
                  <input type="text" id="txtbuscapp" name="txtbuscapp" class="form-control form-control-sm">
                  
                </div>
                <div class="col-sm-4">	
                <button type="button" class="btn btn-outline-primary btn-xs float-left" onclick="controlarppsheet();">Check</button>

                </div>
           
        <hr>    
        </div>  
        </p>  

        <?php
              
              $sql= "select distinct  * from fas_products_documentation  where   idtypedocu  in(1,2) and idproduct = ". $v_idproduct."  ";

   ///    echo  $sql;


							   $datacabez = $connect->query($sql)->fetchAll();
								$idtemp=0;
								$vejecucion = 1;
             
                    $link_ppsheet="";           
                    $link_pppoly="";           
								  foreach ($datacabez as $rowheaders) 
								  {
                    ////1 = PP POLY -- 2 = PP-SHEET
                    
                    if ( $rowheaders['idtypedocu'] == 2)
                    {
                      $link_ppsheet=$rowheaders['linkdocu'];     
                    }
                      
                    if ( $rowheaders['idtypedocu'] == 1)
                    {
                      $link_pppoly=$rowheaders['linkdocu'];      
                    }
                      
                  }
                  
                  $url = "HTTPS://webfas.honeywell.com/Source/PP-SHEET/".$link_ppsheet.".pdf";
                  // Use get_headers() function
                  $headers = @get_headers($url);
                    
                  // Use condition to check the existence of URL
                  if($headers && strpos( $headers[0], '200')) {
                      $status = "URL Exist";
                  }
                  else {
                      $status = "URL Doesn't Exist";
                  }

  


               
              if($headers && strpos( $headers[0], '200')) {
                    ?>
                      
                    <?php
                  }
                  else
                  {
                ///    echo "NO::::". url_exists( "HTTPS://webfas.honeywell.com/Source/PP-SHEET/".$link_ppsheet.".pdf" );
                    ?>
                    <div class="error-page">
                        <h2 class="headline text-warning"> 404  </h2>

                        <div class="error-content">
                          <h3><i class="fas fa-exclamation-triangle text-warning"></i> PP-SHET not found..</h3>

                          <p>
                          <h5>Please contact the WEBFAS Team.</h5> <br>
                          Ref: # <?php echo "https://webfas.honeywell.com/Source/PP-SHEET/".$link_ppsheet.".pdf"; ?>
                          </p>
 
                        </div>
                        <!-- /.error-content -->
                      </div>
                    <?php
                  }
              ?>
            <div class="embed-responsive embed-responsive-21by9">
                  <?php
                  if($headers && strpos( $headers[0], '200')) {
                      ?>
                        <iframe class="embed-responsive-item" width="100%" height="100%" src="Source/PP-SHEET/<?php echo   $link_ppsheet;?>.pdf#toolbar=0&pagemode=bookmarks"></iframe>
                        
                      <?php
                    }
                  ?>
              
            </div>

           
          
      </div>
    </div>
  </div>
  <div class="col-12">
    <div class="collapse multi-collapse" id="multiCollapseExample2">
      <div class="card card-body">
               <div class="row" data-select2-id="10">

               <div class="col-sm-4">
                </div>	
                <div class="col-sm-4 text-center">
                <button class="btn btn-primary btn-block" id="btnfin" name="btnfin" type="button"  onclick="finished_poly();">
                Once finished the polys paste, Click here
                </button>
                <br>
              </div>	
                <div class="col-sm-4">
                </div>	
                <br>
                </div>    
                
                <?php 

$url2 = "HTTPS://webfas.honeywell.com/Source/PP-POLY/".$link_pppoly.".pdf";
//echo $url2 ;
// Use get_headers() function
$headers2 = @get_headers($url2);

// Use condition to check the existence of URL
if($headers2 && strpos( $headers2[0], '200')) {
$status = "URL Exist";
}
else {
$status = "URL Doesn't Exist";
}



              if($headers2 && strpos( $headers2[0], '200')) {
              }
              else
              {
                
                  ?>
                  <div class="error-page">
                      <h2 class="headline text-warning"> 404  </h2>

                      <div class="error-content">
                        <h3><i class="fas fa-exclamation-triangle text-warning"></i> PP-POLY not found..</h3>

                        <p>
                        <h5>Please contact the WEBFAS Team.</h5> <br>
                        Ref: # <?php echo $link_pppoly; ?>
                        </p>

                      </div>
                      <!-- /.error-content -->
                    </div>
                  <?php
                }
            ?>

          <div class="embed-responsive embed-responsive-21by9">
            <?php 
                if($headers2 && strpos( $headers2[0], '200')) {
                  ?>
                    <iframe class="embed-responsive-item" src="Source/PP-POLY/<?php echo   $link_pppoly;?>.pdf#toolbar=0&pagemode=bookmarks"></iframe>
                  <?php
                }
            ?>
              
            </div>


            
      </div>
    </div>
  </div>
</div>

</div>
                
                
            </div>        

         
         
<input type="hidden" name="vppsheet" id="vppsheet" value="<?php echo   $link_ppsheet;?>">
<input type="hidden" name="vpppoly" id="vpppoly" value="<?php echo   $link_pppoly;?>">
<input type="hidden" name="vidso" id="vidso" value="<?php echo   $soparam;?>">
<input type="hidden" name="vsn" id="vsn" value="<?php echo   $snparam;?>">

<?php
  $vuserfas = $_SESSION["b"];
			//////outcome integral///////////////////////////////////////////////////////////////////////////////
      $sqlooutcome="select fnt_create_newid_xbusiness_station_user('".$vuserfas."','')";            
      $datacabez_out = $connect->query($sqlooutcome)->fetchAll();
   
      $_idruninfo_reference =0;
        foreach ($datacabez_out as $rowheaders_out) 
        {
        //  echo "<br>".$rowheaders_out[0];  
          $_idruninfo_reference =$rowheaders_out[0];  
        }
        ?>
        <input type="hidden" name="vv_idruninfo" id="vv_idruninfo" value="<?php echo   $_idruninfo_reference;?>">

        <?php

        $vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
				$vaccionweb="visitweb";
					$vdescripaudit="visitweb#".$_SERVER['SERVER_ADDR'];     


  $v_stringdata=  $vuserfas."|".$vmenufas."|".$soparam."|".$v_idproduct."|".$vv_modelciu."|".$snparam."|".$_SERVER['SERVER_ADDR'];
  //echo $v_stringdata."-------".$_idruninfo_reference;
  $v_categoryoutcome= 0;
  $v_catidtype= 0;
  error_reporting(E_ALL);
      $sentenciach = $connect->prepare("INSERT INTO public.fas_outcome_integral(idfasoutcomecat, idtype, datetimeref, reference, v_boolean, v_integer, v_double, v_string, v_date, id_outcome, v_bigint) VALUES (:idfasoutcomecat, :idtype, now(), :reference, null, null, null, :v_string, now(), 0, null);");
              $sentenciach->bindParam(':idfasoutcomecat', $v_categoryoutcome);			
              $sentenciach->bindParam(':idtype', $v_catidtype);			
              $sentenciach->bindParam(':reference', $_idruninfo_reference);								
              $sentenciach->bindParam(':v_string', $v_stringdata); 
              $sentenciach->execute();
               
              //////////  0 - 3 CIU
              $v_stringdata=   $vv_modelciu;
              $v_categoryoutcome= 0;
              $v_catidtype= 3;
                  $sentenciach = $connect->prepare("INSERT INTO public.fas_outcome_integral(idfasoutcomecat, idtype, datetimeref, reference, v_boolean, v_integer, v_double, v_string, v_date, id_outcome, v_bigint)  VALUES (:idfasoutcomecat, :idtype, now(), :reference, null, null, null, :v_string, now(), 0, null);");
                          $sentenciach->bindParam(':idfasoutcomecat', $v_categoryoutcome);			
                          $sentenciach->bindParam(':idtype', $v_catidtype);			
                          $sentenciach->bindParam(':reference', $_idruninfo_reference);								
                          $sentenciach->bindParam(':v_string', $v_stringdata); 
                          $sentenciach->execute();
            
                
     //////////  0 - 2 SO
              $v_stringdata=   $vv_so;
              $v_categoryoutcome= 0;
              $v_catidtype= 2;
                  $sentenciach = $connect->prepare("INSERT INTO public.fas_outcome_integral(idfasoutcomecat, idtype, datetimeref, reference, v_boolean, v_integer, v_double, v_string, v_date, id_outcome, v_bigint) VALUES (:idfasoutcomecat, :idtype, now(), :reference, null, null, null, :v_string, now(), 0, null);");
                          $sentenciach->bindParam(':idfasoutcomecat', $v_categoryoutcome);			
                          $sentenciach->bindParam(':idtype', $v_catidtype);			
                          $sentenciach->bindParam(':reference', $_idruninfo_reference);								
                          $sentenciach->bindParam(':v_string', $v_stringdata); 
                          $sentenciach->execute();

              //////////  0 - 4 SN
              $v_stringdata=   $snparam;
              $v_categoryoutcome= 0;
              $v_catidtype= 4;
                  $sentenciach = $connect->prepare("INSERT INTO public.fas_outcome_integral(idfasoutcomecat, idtype, datetimeref, reference, v_boolean, v_integer, v_double, v_string, v_date, id_outcome, v_bigint)  VALUES (:idfasoutcomecat, :idtype, now(), :reference, null, null, null, :v_string, now(), 0, null);");
                          $sentenciach->bindParam(':idfasoutcomecat', $v_categoryoutcome);			
                          $sentenciach->bindParam(':idtype', $v_catidtype);			
                          $sentenciach->bindParam(':reference', $_idruninfo_reference);								
                          $sentenciach->bindParam(':v_string', $v_stringdata); 
                          $sentenciach->execute();

                             //////////  0 - 4 SN
              $v_stringdata=   $snparam;
              $v_categoryoutcome= 12;
              $v_catidtype= 12;
                  $sentenciach = $connect->prepare("INSERT INTO public.fas_outcome_integral(idfasoutcomecat, idtype, datetimeref, reference, v_boolean, v_integer, v_double, v_string, v_date, id_outcome, v_bigint) VALUES (:idfasoutcomecat, :idtype, now(), :reference, null, null, null, :v_string, now(), 0, null);");
                          $sentenciach->bindParam(':idfasoutcomecat', $v_categoryoutcome);			
                          $sentenciach->bindParam(':idtype', $v_catidtype);			
                          $sentenciach->bindParam(':reference', $_idruninfo_reference);								
                          $sentenciach->bindParam(':v_string', $v_stringdata); 
                          $sentenciach->execute();

              

            
      /////////////////////////////////////////////////////////////////////////////////////
?>
            
 </form>
		
                       <!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->

<!-- Toastr -->
<script src="toastr.min.js"></script>


<!-- AdminLTE for daterangepickers -->
<script src="plugins/select2/js/select2.full.min.js"></script>
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>


<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="toastr.min.js"></script>

<script src="licencefiplex_mm.js"></script>
<script src="licencefiplex1.js"></script>
<script src="js/jquery.inactivityTimeout.js"></script>
<script src="js/moment-timezone-with-data.js"></script>

<script src="plugins/jquery-knob/jquery.knob.min.js"></script>


<link rel="stylesheet" href="sweetalert2/msweetalert2.min.css">
					<script src="sweetalert2/msweetalert2.min.js"></script>
<script src="js/select2.min.js"></script>

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
	


   $("#txtbuscapp").keypress(function(e) {
  if(e.which == 13) {
     // Acciones a realizar, por ej: enviar formulario.
     ///$('#frm').submit();
     if ( $("#txtbuscapp").val() != '')
     {
      controlarppsheet();
     }
     console.log('search..'+ $("#txtbuscapp").val() );
  }
  
  });

function habilitarfrm()
{
  $("#frm1").removeClass("d-none");
  $("#frmmsjrojo").addClass("d-none");
}

  function finished_poly()
  {
    save_steps_outcome_integral($("#vv_idruninfo").val(), 12,14,'Y');
  }

   function  controlarppsheet()
   {
    console.log(' directo search..'+ $("#txtbuscapp").val() );
    if ( $("#txtbuscapp").val() != '')
     {
      //// BUSCAMOS
      if ( $("#txtbuscapp").val().trim() == $("#vppsheet").val().trim())
      {
        //// TODO OK
        toastr["info"]("PP-Poly to Show", "Searching")
        $("#multiCollapseExample1").removeClass("show");
        $("#multiCollapseExample2").addClass("show");
        document.querySelector("#btnfin").removeAttribute("disabled");
        save_steps_outcome_integral($("#vv_idruninfo").val(), 12,13,'N');
      }
      else
      {
        toastr["error"]("the scanned pp-sheet does not correspond to the CIU of the SO: ", "Attention")
      }
      
     }
     return false;
   }

        function save_steps_outcome_integral(vvv_refence, vcatt,cccatttype, redirecciono,vvsn)
  {
 
    $.ajax
											({ 
												url: 'ajax_create_runinfooutcome.php',
												data: "vvv_refence="+vvv_refence+'&vcatt='+vcatt+'&cccatttype='+cccatttype+'&vsn='+$("#vsn").val(),	
												type: 'post',				
												datatype:'JSON',                    
												success: function(data)
												{
													// 
														if(data.result=="ok")
														{
                              if (redirecciono=='Y')
                              {								
                                  Swal.fire({
                                title: 'Saved!',							  
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',							  
                                confirmButtonText: 'Ok',							  
                                }).then((result) => {
                                  
                                
                                    window.parent.location='trackingordersmm.php?isdo='+$("#vidso").val()+'&typeisdo=SO&encont='+$("#vsn").val(); 
                                  
                                  
                              
                                })	
                              }
                      
														}											
												
													///alert(data.result);
												}
											});	

  }

    




   
</script>
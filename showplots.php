<?php

// Desactivar toda notificación de error
error_reporting(0);
// Notificar todos los errores de PHP (ver el registro de cambios)
//error_reporting(E_ALL);
 include("db_conect.php"); 
 
 	session_start();

     require 'aws/aws-autoloader.php';
     require 'aws/fplmm.php';
     
?>
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
		 
    .pictures {
      list-style: none;
      margin: 0;
    
    }

</style>
    <script src="plugins/jquery/jquery.min.js"></script>
    
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- DataTables -->
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>


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
    <script src="js/viewer.js"></script>
<p align="center">
<div id="galley<?php

///idsn='+vsn+'&vbranch='+vbranch+'&vidruninfo=' +vidruninfo 
$idmedicionind=0;
$idsn = $_REQUEST['idsn'];
$vbranch = $_REQUEST['vbranch'];
$vidruninfo = $_REQUEST['vidruninfo'];
$idbband =  $_REQUEST['idbband'];
echo $idmedicionind;?>" style="  text-align: center;">
                                      <ul class="pictures">
                                      <?php
                                      $vt=0;
                                     /// Busvamos todos los plotsss

                                    $sqlplot="select distinct filename from fas_sameasures where iduniqueop in
                                    (
                                      select iduniqueop from fas_tree_measure where iduniquebranch = '".$vbranch."' and unitsn = '".$idsn."' and idrununfo = ".$vidruninfo." and band = ".$idbband."                                      

                                    )
                                    union
                                    select replace(vv_string,'.png.png','.png') from select_outcome_integral_band_uldl_iduniop_idsin_idsa(".$vidruninfo.") where v_idtype= 5 and v_idfasoutcomecat= 4 
                                    and v_iduniqueop in(  select iduniqueop from fas_tree_measure where iduniquebranch = '".$vbranch."' and unitsn = '".$idsn."' and idrununfo = ".$vidruninfo." and band = ".$idbband." )
                                    union 
                                    
                                          select replace(v_string,'.png.png','.png') 
                                          from fas_outcome_integral	
                                          inner join ( 
                                                      
                                          select   fas_outcome_integral.id_outcome, fas_outcome_integral.v_bigint as idsameasure ,  fas_outcome_integral.idfasoutcomecat, fas_outcome_integral.idtype
                                          from fas_outcome_integral	
                                          inner join ( 
                                                      
                                                    select fas_outcome_integral.*
                                                          from fas_outcome_integral	
                                                          inner join ( 
                                                                                                                          
                                          select    fas_outcome_integral.id_outcome                       
                                          from fnt_select_allfas_routines_process_sn_maxrev_byscript_byidrun('".$idsn."',0 ,".$vidruninfo." ) as  losdd
                                          inner join fas_routines_steps
                                          on fas_routines_steps.idstep = losdd.idstep 
                                          inner join fas_step
                                          on fas_step.instance = fas_routines_steps.instance 
                                          and fas_routines_steps.instance= '".$vbranch."'
                                          inner join fas_outcome_integral 
                                          on fas_outcome_integral.v_bigint = losdd.iduniqueop
                                          left join fas_outcome_integral as outcomeband
                                          on outcomeband.reference = fas_outcome_integral.id_outcome and
                                          outcomeband.idfasoutcomecat = 1 and
                                          outcomeband.idtype          = 1 and 
                                          outcomeband.v_integer = ".$idbband."
                                                          
                                                      ) as lossinglemeasure
                                                    on lossinglemeasure.id_outcome = fas_outcome_integral.reference
                                                        where idfasoutcomecat = 0 and idtype =27
                                                  ) as lossinglemeasure
                                          on lossinglemeasure.id_outcome = fas_outcome_integral.reference
                                          where fas_outcome_integral.idfasoutcomecat = 0 and fas_outcome_integral.idtype =29
                                            
                                          ) as lossameasure
                                          on lossameasure.id_outcome = fas_outcome_integral.reference
                                          where fas_outcome_integral.idtype= 5 and fas_outcome_integral.idfasoutcomecat= 4 


";
                      //      echo  $sqlplot;
                                 
                                     $resultadoplot = $connect->query($sqlplot);	
                                   
                                     foreach ($resultadoplot as $rowplot) 
                                      {
                                    //  echo trim($rowplot['filename'])."<br>";
                                      $pngtemp2 = "plots/".trim($rowplot['filename']).".png";
                                      $pngtemp2 = trim($rowplot['filename']);
                                    	echo $pngtemp;
                                     
                                      $cmd2 = $clientS3AWS->getCommand('GetObject', [
                                        'Bucket' => 'fpxwebfas',
                                        'Key'    => $pngtemp2
                                      ]);

                                      //The period of availability
                                      $request2 = $clientS3AWS->createPresignedRequest($cmd2, '+20 minutes');

                                      //echo var_dump($request);
                                      //Get the pre-signed URL
                                      $signedUrl2 = (string) $request2->getUri();
                             //       echo "<br>a ver aqui:".$signedUrl;

                                        if ($vt ==0)
                                        {
                                        ?>
                                      <li>
                                        <img  id="imgmc<?php echo $idmedicionind; ?>" name="imgmc<?php echo $idmedicionind; ?>" data-original="<?php echo $signedUrl2;?>" src="<?php echo $signedUrl2;?>" width="30%" class="sd-none"> 
                                        
                                      </li>
                                        <?php
                                        }
                                        else
                                        {
                                            ?>
                                          <li>
                                            <img  data-original="<?php echo $signedUrl2;?>" src="<?php echo $signedUrl2;?>" width="30%" class="md-none" > 
                                            
                                          </li>
                                        <?php
                                        }
                                        $vt= $vt + 1;
                                          

                                      }
                                      ?>

                                      </ul>
                                      </div>
                                      </p>
                                      <script type="text/javascript">
                                        window.addEventListener('DOMContentLoaded', function () {
                                          var idmedicion= <?php echo $idmedicionind;  ?>;
                                        var galley = document.getElementById('galley'+idmedicion);
                                        var viewer = new Viewer(galley, {
                                          url: 'data-original',
                                          title: function (image) {
                                            return image.alt + ' (' + (this.index + 1) + '/' + this.length + ')';
                                          },
                                        });
                                      });
                                      </script>
                                       
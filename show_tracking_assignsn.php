
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
<?php 

	
// Desactivar toda notificación de error
error_reporting(0);
// Notificar todos los errores de PHP (ver el registro de cambios)
//error_reporting(E_ALL);
 include("db_conect.php"); 
 

			
 
 	session_start();

     $sanitized_n = filter_var($_REQUEST['idso'], FILTER_SANITIZE_STRING);
     if (filter_var($sanitized_n, FILTER_SANITIZE_STRING)) {
        $soparam = $_REQUEST['idso']; ///
     }
     $sanitized_nso = filter_var($_REQUEST['elnomso'], FILTER_SANITIZE_STRING);
     if (filter_var($sanitized_n, FILTER_SANITIZE_STRING)) {
        $elnomso = $_REQUEST['elnomso']; ///
     }
///elnomso 
     
   
        $sql= "select distinct orders_sn.*, modelciu,  quantity  from orders_sn 
        inner join orders on orders_sn.idorders = orders.idorders
        inner join products on products.idproduct = orders.idproduct
        where orders_sn.idorders =". $soparam."  and idnroserie =0";



							   $datacabez = $connect->query($sql)->fetchAll();
								$idtemp=0;
								$vejecucion = 1;
                               
								  foreach ($datacabez as $rowheaders) 
								  {
                                      $v_ppasy =  $rowheaders['req_ppassy'];
                                      $v_reqcalib =  $rowheaders['req_calibration'];
                                      $v_specialmat =  $rowheaders['req_spec'];
                                      $v_others =  $rowheaders['req_other'];

									  ?>
                                          <h5 class='colorazulfiplex'>&nbsp;&nbsp;Order details</h5>
                                          <hr>
                                      	<table class="table table-striped ">
            <tbody>
            <tr>    
                <td> <b>CIU: </b></td><td><?php echo $rowheaders['modelciu'];?></td>
                <td> <b>Quantity: </b></td><td><?php echo $rowheaders['quantity'];?></td>
                <td><b>PO Numbre:</b><td ><?php echo $rowheaders['ponumber'];?></td>
            </tr>
            <tr><td><b>POWER SUPPLY TYPE:</b></td><td><?php echo $rowheaders['pwrsupplytype'];?></td><td><b>RC-G for BWA:</b></td><td> 
            <?php if ( $rowheaders['rcgfbwa'] == true )
            {
                ?><span class='btn btn-outline-success btn-xs'>Yes</span>
                <?php
            }
            else
            {
                ?><span class='btn btn-outline-danger btn-xs'>No</span>
                <?php
            }
            
            ?>
        
            </td>
            <td><b>Moden for Digital:</b></td><td>
            <?php if ( $rowheaders['moden_dig']  == true )
            {
                ?><span class='btn btn-outline-success btn-xs'>Yes</span>
                <?php
            }
            else
            {
                ?><span class='btn btn-outline-danger btn-xs'>No</span>
                <?php
            }
            
            ?>
             </td></tr>

            <tr>
            <th>Description PO:<br></th><td colspan="5"> <?php echo $rowheaders['descripcion'];?></td>
            </tr>
            <tr><th>Notes PO:<br></th><td colspan="5"> <?php echo $rowheaders['notes'];?></td></tr>

            </table>
            <hr>
          <h5 class='colorazulfiplex'>&nbsp;&nbsp;Stock SN by CIU Family</h5>
            <table class="table table-striped ">
        

            
                                      <?php			 
								  }

                                  $sql = $connect->prepare("select  distinct orders_sn.idorders as idorderswo, 
                                  orders_sn.idproduct, products.modelciu,   orders_sn.wo_serialnumber, so_soft_external
                                 from orders_sn
                                 inner join orders
                                 on orders.idorders = orders_sn.idorders
                                 inner join products on products.idproduct = orders_sn.idproduct
                                 and products.classproduct in  (select classproduct from orders inner join products on products.idproduct = orders.idproduct where idorders = ".$soparam." )	
                                 where orders.active ='Y' and orders.processfasserver = true and
                                 orders_sn.processfasserver = true and orders.typeregister='WO' and length(trim(wo_serialnumber)) >0 			
                                 and orders_sn.so_associed = '' and  orders_sn.wo_serialnumber <> '' and orders_sn.availablesn = true
                                 ");
                                           //SUMAS FILTRO ESTANDAR
                                     //	$sql->bindParam(':vvidpresales', $vvidpo);
                                         $sql->execute();
                                         $resultadostock = $sql->fetchAll();
                                          foreach ($resultadostock as $rowstock) 
                                         {
                                             $return_arr_stock_det[] = array("idproduct" => $rowstock['idproduct'],
                                                     "modelciu" => $rowstock['modelciu'],
                                                     "wo_serialnumber" => $rowstock['wo_serialnumber'], 
                                                     "so_soft_external"=> $rowstock['so_soft_external']				
                                                     );
                                            ?>
                                          <tr><th>SN available: <?php echo  $rowstock['wo_serialnumber'];?>
                                          <button type="button" onclick="savechristian('<?php echo  $rowstock['wo_serialnumber'].'|'.$rowstock['so_soft_external'].'#'; ?>',<?php echo  $rowstock['idorderswo'];?>,<?php echo   $soparam;   ?>)" class="btn  btn-outline-primary btn-xs">Assign to <?php echo   $elnomso;?> </button>
                                          </th><td colspan="5"> <?php echo "Ciu:<b>".$rowstock['modelciu']."</b> - SO: <b> ".$rowstock['so_soft_external'];?></b></td></tr>
                                            <?php

                                         }
								  ?>
		
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
   
   

        function savechristian(paramsndewo, numeroso,vidpo)
  {
 
    $.ajax
											({ 
												url: 'ajax_update_po_so_sn.php',
												data: "idpo="+vidpo+'&so='+numeroso+'&lossn='+paramsndewo+'&cantasing=1',	
												type: 'post',				
												datatype:'JSON',                    
												success: function(data)
												{
													// 
														if(data.result=="ok")
														{
																									
												Swal.fire({
											title: 'Saved!',							  
											icon: 'success',
											showCancelButton: false,
											confirmButtonColor: '#3085d6',							  
											confirmButtonText: 'Ok',							  
											}).then((result) => {
										
												window.parent.location='trackingorders.php?isdo='+vidpo+'&typeisdo=SO&encont='+paramsndewo; 
										
											})		
														}											
												
													///alert(data.result);
												}
											});	

  }

    




   
</script>
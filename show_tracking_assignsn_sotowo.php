
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
          background:#ffffff;
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

     $sanitized_n = filter_var($_REQUEST['soparam'], FILTER_SANITIZE_STRING);
     if (filter_var($sanitized_n, FILTER_SANITIZE_STRING)) {
        $soparam = $_REQUEST['soparam']; ///
     }
     $sanitized_nso = filter_var($_REQUEST['sn'], FILTER_SANITIZE_STRING);
     if (filter_var($sanitized_n, FILTER_SANITIZE_STRING)) {
        $elsn = $_REQUEST['sn']; ///
     }
///elnomso 
     
   
        $sql= "select distinct orders_sn.*, modelciu,  quantity ,classproduct from orders_sn 
        inner join orders on orders_sn.idorders = orders.idorders
        inner join products on products.idproduct = orders.idproduct
        where orders_sn.idorders =". $soparam."  and idnroserie =0";

//echo $sql;

$sqlqq= "select count(distinct orders.idorders) as ccm from orders_sn 
inner join orders on orders_sn.idorders = orders.idorders
inner join products on products.idproduct = orders.idproduct
where orders_sn.idorders =". $soparam."   ";

$datacabez = $connect->query($sqlqq)->fetchAll();
foreach ($datacabez as $rowheadersm) 
{
  $quantity_enabled = $rowheadersm['ccm'];
}

 

 

							   $datacabez = $connect->query($sql)->fetchAll();
								$idtemp=0;
								$vejecucion = 1;
                               
								  foreach ($datacabez as $rowheaders) 
								  {
                                      $v_ppasy =  $rowheaders['req_ppassy'];
                                      $v_reqcalib =  $rowheaders['req_calibration'];
                                      $v_specialmat =  $rowheaders['req_spec'];
                                      $v_others =  $rowheaders['req_other'];
                                      $v_classproduct = $rowheaders['classproduct'];

                                      $v_so_soft_external_wo= $rowheaders['so_soft_external'];

									  ?>
                    <br>
                                          <h5 class='colorazulfiplex'>&nbsp;&nbsp;Order SO [<?php echo $v_so_soft_external_wo; ?>] </h5>
                                          <hr>
                                      	<table class="table table-striped ">
            <tbody>
            <tr>    
                <td> <b>CIU: </b></td><td><?php echo $rowheaders['modelciu'];?></td>
                <td> <b>SN Used / Quantity: </b></td><td><?php echo  $quantity_enabled." / ".$rowheaders['quantity'];?></td>
             </tr>
     
 
            </table>
            <hr>
         
          <div class="row">
    <div class="col">
      
    </div>
    <div class="col-8">
    <table class="table table-striped table-sm" name="tblfilter0" id="tblfilter0">
    <thead class="thead-dark">
        <tr>
            <th>Actions:</th>
             <th>SO   </th>
             <th>PART NUMBER   </th>
             <th>SN   </th>

        </tr>          
    </thead>
    <tbody>

            
        <?php			 
}


    $sql = $connect->prepare("select distinct orders_sn.idorders , ponumber, quantity , quantity-count(distinct idnroserie) as disponibles,max(idnroserie)+1 as proxnnroserie,
    orders_sn.idproduct, products.modelciu, 
    orders_sn.wo_serialnumber, so_soft_external
   from orders_sn
   inner join orders
   on orders.idorders = orders_sn.idorders
   inner join products on products.idproduct = orders_sn.idproduct
   and products.classproduct = '". $v_classproduct."'
   where orders.active ='Y' and length(trim(wo_serialnumber)) >0 			 and so_associed <> ''
   and products.modelciu not like '%LIC%' and so_soft_external like '%WO'
   group by orders_sn.idorders , ponumber, quantity , 
orders_sn.idproduct, products.modelciu, 
orders_sn.wo_serialnumber, so_soft_external 
order by so_soft_external, modelciu
   ");

  

        //SUMAS FILTRO ESTANDAR
       //	$sql->bindParam(':vvidpresales', $vvidpo);
           $sql->execute();
           $resultadostock = $sql->fetchAll();
            foreach ($resultadostock as $rowstock) 
           {
              /* $return_arr_stock_det[] = array("idproduct" => $rowstock['idproduct'],
                       "modelciu" => $rowstock['modelciu'],
                       "wo_serialnumber" => $rowstock['wo_serialnumber'], 
                       "so_soft_external"=> $rowstock['so_soft_external']				
                       );*/
              if ($rowstock['disponibles']>=0)
              {

                      
              ?>
            <tr><td>
            <button type="button" onclick="asinngwotoso_sn(<?php echo  $rowstock['idorders']?>,'<?php echo $rowstock['so_soft_external'] ?>',' <?php echo trim($rowstock['wo_serialnumber']) ?>',<?php echo $soparam; ?>,'<?php echo $v_so_soft_external_wo;?>',<?php echo $rowstock['proxnnroserie'] ?>)" class="btn  btn-outline-primary btn-xs">Assign to <?php echo   $v_so_soft_external_wo;?> </button>
            </td>
            <td>            <?php echo "<b> ".$rowstock['so_soft_external'];?></b></td>
            <td>            <?php echo "<b>".$rowstock['modelciu']."</b>";?></b></td>
            <td>            <?php echo "<b>".$rowstock['wo_serialnumber']."</b>";?></b></td>
          
          </tr>
              <?php
              } 

           }
?>
 </tbody>
</table>
    </div>
    <div class="col">
    <p name="msjwaitline" id="msjwaitline" align="center"><img src="img/waitazul.gif" width="100px" > Send Information ....</p>	
    </div>
  </div>
          
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

<script src="plugins/datatables/jquery.dataTables.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
  
  <link href="css/tabulator_bootstrap4.css" rel="stylesheet">

<link rel="stylesheet" href="sweetalert2/msweetalert2.min.css">
					<script src="sweetalert2/msweetalert2.min.js"></script>
<script src="js/select2.min.js"></script>

</body>

<script type="text/javascript">
   
   $('#msjwaitline').hide();

        function asinngwotoso_sn(pp_idso, pp_so,pp_sn, pp_idwo, pp_wo,pp_idnroserie)
  {
 
    $('#msjwaitline').show();
    $.ajax
											({ 
												url: 'ajax_update_sn_fromwotoso.php',
												data: "pp_idwo="+pp_idwo+'&pp_sn='+pp_sn+'&pp_idso='+pp_idso+'&pp_so='+pp_so+'&pp_wo='+pp_wo+'&pp_idnroserie='+pp_idnroserie,	
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
										
										 
										
											})	

                      $('#msjwaitline').hide();
                  $("#msjwaitline").addClass('d-none');
                      window.parent.location='trackingorders.php?isdo='+pp_idwo+'&typeisdo=WO&encont='+pp_sn.trim(); 

														}											
												
													///alert(data.result);
												}
											});	

  }

    

  $('#tblfilter0').DataTable({searching: true, paging: true, info: false, pageLength: 500000, } );
										 


   
</script>

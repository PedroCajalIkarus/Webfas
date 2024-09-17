4<html>

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
    body {
        font-family: Arial, Helvetica, sans-serif;
        background: #ffffff;
        font-size: 12px;
        font-size: 10px;
    }

    table {
        font-size: 12px
    }
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
where orders_sn.idorders =". $soparam."   and so_original <> ' '";

$datacabez = $connect->query($sqlqq)->fetchAll();
foreach ($datacabez as $rowheadersm) 
{
  $quantity_enabled = $rowheadersm['ccm'];
}

$sqlqqsn= "select distinct wo_serialnumber, classproduct   from orders_sn 
inner join orders on orders_sn.idorders = orders.idorders
inner join products on products.idproduct = orders.idproduct
where orders_sn.idorders =". $soparam." and wo_serialnumber ='". $elsn."'  and so_original <> ' ' and  availablesn is true";

$sqlqqsn= "select distinct wo_serialnumber   from orders_sn 
inner join orders on orders_sn.idorders = orders.idorders
inner join products on products.idproduct = orders.idproduct
where orders_sn.idorders =". $soparam." and wo_serialnumber ='". $elsn."'  and so_original <> ' ' ";
 

$datacabezm = $connect->query($sqlqqsn)->fetchAll();
foreach ($datacabezm as $rowheadersfm) 
{
  $sn_enabled = $rowheadersfm['wo_serialnumber'];
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
                                  }
									  ?>
<br>
<h5 class='colorazulfiplex'>&nbsp;&nbsp;Order WO [<?php echo $v_so_soft_external_wo; ?>] </h5>
<hr>
<table class="table table-striped ">
    <tbody>
        <tr>
            <td> <b>CIU: </b></td>
            <td><?php echo $rowheaders['modelciu'];?></td>
            <td> <b>SN Used / Quantity: </b></td>
            <td><?php echo  $quantity_enabled." / ".$rowheaders['quantity'];?></td>
        </tr>


</table>
<hr>
<h5 class='colorazulfiplex'>&nbsp;&nbsp;Assign SN: <?php echo  $sn_enabled;?> </h5>

<div class="row">
    <div class="col">

    </div>
    <div class="col-8">
        <input type="hidden" id="soparam" name="soparam" value='<?php echo $soparam;?>'>
        <input type="hidden" id="woparam" name="woparam" value='<?php echo $v_so_soft_external_wo;?>'>
        <input type="hidden" id="snoaram" name="snoaram" value='<?php echo $elsn;?>'>
        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">PO/MFG:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control form-control-sm" id="nroposap" name="nroposap">
            </div>
        </div>
        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">SO:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control form-control-sm" id="nrososap" name="nrososap">
            </div>
        </div>
        <div class="card-footer" id="btn1" name="btn1">

            <button type="button" onclick="associarSNSOSAP()" id="btnassososap" name="btnassososap"
                class="btn btn-block btn-outline-primary btn-xs float-right">Associate</button>
        </div>
    </div>
    <div class="col">
        <p name="msjwaitline" id="msjwaitline" align="center"><img src="img/waitazul.gif" width="100px"> Search
            Information ....</p>
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
$('#btnassososap').hide();


$('#nroposap').keypress(function(event) {
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if (keycode == '13') {
        $('#nrososap').focus();
    }
});
$('#nrososap').keypress(function(event) {
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if (keycode == '13') {
        if ($("#nroposap").val().trim() != "" && $("#nrososap").val().trim() != "") {
            controlaSAP_po();
            console.log("entro 1");
        }
    }
});



$("#nroposap").focusout(function() {

    $('#btnassososap').hide();
    // console.log("entro 1 controlo");
    if ($("#nroposap").val().trim() != "" && $("#nrososap").val().trim() != "") {
        controlaSAP_po();
        console.log("entro 1");
    }

});

$("#nrososap").focusout(function() {
    $('#btnassososap').hide();
    //  console.log("entro 2 controlo");
    if ($("#nroposap").val().trim() != "" && $("#nrososap").val().trim() != "") {
        controlaSAP_po();
        console.log("entro 2");
    }
});

function controlaSAP_po() {


    /*$vv_po = $_REQUEST['po'];   
		$vv_so = trim($_REQUEST['so']);   
		$vv_idorders = $_REQUEST['idorders']; 
        */

    var vv_po = $("#nroposap").val();
    var vv_so = $("#nrososap").val();
    var vv_idorders = $("#soparam").val();
    var vv_snoaram = $("#snoaram").val();
    var vv_woparam = $("#woparam").val();


    $('#msjwaitline').show();
    $.ajax({
        url: 'ajax_check_so_sn_po_sap.php',
        data: "po=" + vv_po + '&so=' + vv_so + '&idorders=' + vv_idorders + '&sn=' + vv_snoaram + '&wo=' +
            vv_woparam,
        type: 'post',
        datatype: 'JSON',
        success: function(data) {
            // 
            //btn1
            $('#msjwaitline').hide();
            $("#btn1").html(data);

        }
    });



}


$('#msjwaitline').hide();

function asinngwotoso_snsap(pp_idso, pp_so, pp_sn, pp_idwo, pp_wo, pp_idnroserie, pp_posap) {

    $('#msjwaitline').show();

    const botones = document.querySelectorAll('button');

    botones.forEach(boton => {
        boton.disabled = true;
    });

    $.ajax({
        url: 'ajax_update_sn_fromwotoso.php',
        data: "pp_idwo=" + pp_idwo + '&pp_sn=' + pp_sn + '&pp_idso=' + pp_idso + '&pp_so=' + pp_so + '&pp_wo=' +
            pp_wo + '&pp_idnroserie=' + pp_idnroserie + '&pp_posap=' + pp_posap,
        type: 'post',
        datatype: 'JSON',
        success: function(data) {
            // 
            if (data.result == "ok") {

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
                //    window.parent.location = 'trackingorderssaprouting.php?isdo=' + pp_idwo +                    '&typeisdo=WO&encont=' +
                window.parent.refrescardatos();
                window.parent.eModal.close();
                pp_sn.trim();

            }

            ///alert(data.result);
        }
    });

}

function testmarco() {
    window.parent.refrescardatos();
    window.parent.eModal.close();

}

function asinngwotoso_sn(pp_idso, pp_so, pp_sn, pp_idwo, pp_wo, pp_idnroserie) {

    $('#msjwaitline').show();
    $.ajax({
        url: 'ajax_update_sn_fromwotoso.php',
        data: "pp_idwo=" + pp_idwo + '&pp_sn=' + pp_sn + '&pp_idso=' + pp_idso + '&pp_so=' + pp_so + '&pp_wo=' +
            pp_wo + '&pp_idnroserie=' + pp_idnroserie,
        type: 'post',
        datatype: 'JSON',
        success: function(data) {
            // 
            if (data.result == "ok") {

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
                window.parent.location = 'trackingorders.php?isdo=' + pp_idwo + '&typeisdo=WO&encont=' +
                    pp_sn.trim();

            }

            ///alert(data.result);
        }
    });

}
</script>
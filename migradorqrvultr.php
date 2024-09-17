<!DOCTYPE html>
<?php 

// Desactivar toda notificación de error
//error_reporting(0);
// Notificar todos los errores de PHP (ver el registro de cambios)
error_reporting(E_ALL);
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
			if ($_SESSION["a"] =="")
		{
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
	
	
	$status = $connect->getAttribute(PDO::ATTR_CONNECTION_STATUS);
	
	if ($status !="Connection OK; waiting to send.")
	{
	
		header("Location: http://".$ipservidorapache."/".$folderservidor."/errorconect.php");
		exit;
		
	}
	
//****************************************************************	
	function marco_encrypt($string, $key) {
   $result = '';
   for($i=0; $i<strlen($string); $i++) {
      $char = substr($string, $i, 1);
      $keychar = substr($key, ($i % strlen($key))-1, 1);
      $char = chr(ord($char)+ord($keychar));
      $result.=$char;
   }
   return base64_encode($result);
}

function marco_decrypt($string, $key) {
   $result = '';
   $string = base64_decode($string);
   for($i=0; $i<strlen($string); $i++) {
      $char = substr($string, $i, 1);
      $keychar = substr($key, ($i % strlen($key))-1, 1);
      $char = chr(ord($char)-ord($keychar));
      $result.=$char;
   }
   return $result;
}
//****************************************************************	

 

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
                        <a href="http://webfas.fiplex.com/index.php" class="nav-link">Home</a>
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
                                <h1>Migrador QR tio Vultr</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">Migrador QR tio Vultr</li>
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
                            <section class="col-lg-12 connectedSortable ui-sortable">



                                <div class="card">
                                    <div class="card-header ui-sortable-handle" style="cursor: move;">
                                        Control de Migraciones.



                                        <?php	
			$temp_namegroup	="";
			$eluserlogin = $_SESSION["a"];
			$query_lista="select * 
      from orders_sn
      inner join fas_unitkeys
        on fas_unitkeys.sn = orders_sn.wo_serialnumber
      inner join products
        on products.idproduct = orders_sn.idproduct
      where idorders in (
      select idorders  from orders
      where processday >= CURRENT_DATE - INTERVAL '1 months'); ";		

      $query_lista="select orders_sn.* ,fas_unitkeys.*, products.* ,products_attributes.v_string as manualsku,
      products_attributes157.v_string as pfomszip,
      products_attributes158.v_string as fpczip
      from orders_sn
      inner join fas_unitkeys
        on fas_unitkeys.sn = orders_sn.wo_serialnumber
        inner join fnt_select_allproducts_maxrevithsap() as products
        on products.idproduct = orders_sn.idproduct

        left join products_attributes
        on products_attributes.idproduct = orders_sn.idproduct
        and products_attributes.idattribute = 159
    
        left join products_attributes as products_attributes158
        on products_attributes158.idproduct = orders_sn.idproduct
        and products_attributes158.idattribute = 158
    
        left join products_attributes as products_attributes157
        on products_attributes157.idproduct = orders_sn.idproduct
        and products_attributes157.idattribute = 157

      where idorders in (
      select idorders  from orders
      where processday >= CURRENT_DATE - INTERVAL '1 day') limit 1; ";		
		//	echo "444444444444444444444444444444444".$query_lista; 
			$resultado = $connect->query($query_lista);		
			
				$cantregistros = $resultado->rowCount();
			if ($cantregistros>=1)
			{  
				foreach ($resultado as $row) {
				  
                    $vv_idorders = $row['idorders'];
                    echo "<br>aaaaa:". $vv_idorders;
                    $vv_idcustomers = $row['idcustomers'];
                    $vv_idfamilyprod = $row['idfamilyprod'];
                    $vv_idtypeband = $row['idtypeband'];
                    $vv_idtypeproduct = $row['idtypeproduct'];
                    $vv_idproduct = $row['idproduct'];
                    $vv_idconfiguration = $row['idconfiguration'];
                    $vv_idrev = $row['idrev'];
                    $vv_idnroserie = $row['idnroserie'];
                    $vv_so_soft_external = $row['so_soft_external'];
                    $vv_wo_serialnumber = $row['wo_serialnumber'];
                    $vv_idruninfo = $row['idruninfo'];
                    $vv_ponumber = $row['ponumber'];
                    $vv_pwrsupplytype = $row['pwrsupplytype'];
                    $vv_rcgfbwa = $row['rcgfbwa'];
                    $vv_moden_dig = $row['moden_dig'];
                    $vv_date_approved = $row['date_approved'];
                    $vv_descripcion = $row['descripcion'];
                    $vv_nameapproved = $row['nameapproved'];
                    $vv_typeregister = $row['typeregister'];
                    $vv_processday = $row['processday'];
                    $vv_processfasserver = $row['processfasserver'];
                    $vv_so_original = $row['so_original'];
                    $vv_so_associed = $row['so_associed'];
                    $vv_availablesn = $row['availablesn'];
                    $vv_idorders_nxt_trk = $row['idorders_nxt_trk'];
                    $vv_idnroserie_nxt_trk = $row['idnroserie_nxt_trk'];
                    $vv_sn = $row['sn'];
                    $vv_band0key = $row['band0key'];
                    $vv_band1key = $row['band1key'];
                    $vv_maxpwrkey = $row['maxpwrkey'];
                    $vv_classkey = $row['classkey'];
                    $vv_datetimesn = $row['datetimesn'];
                    $vv_qrcustomer = $row['qrcustomer'];
                    $vv_idtypeproduct = $row['idtypeproduct'];
                    $vv_idconfiguration = $row['idconfiguration'];
                    $vv_powersupply = $row['powersupply'];
                    $vv_modelciu = $row['modelciu'];
                    $vv_description = $row['description'];
                    $vv_classproduct = $row['classproduct'];
                    $vv_active = $row['active'];
                    $vv_usermodif = $row['usermodif'];
                    $vv_datelastmodif = $row['datelastmodif'];
                    $vv_woparam = $row['woparam'];
                    $vv_showdpxreport = $row['showdpxreport'];

                    $vv_idbusiness = $row['idbusiness'];
                    $vv_iduniquebranchsonprod = $row['iduniquebranchsonprod'];
                    $vv_idbandgroup = $row['idbandgroup'];
                    $vv_idtypeproductaux = $row['idtypeproductaux'];

                    $vv_idrevproduct = $row['idrevproduct'];
                    $vv_fiplexsku = $row['fiplexsku'];
                    $vv_typeproduct = $row['typeproduct'];

                    $manualsku = $row['manualsku'];
                    $pfomszip = $row['pfomszip'];
                    $fpczip = $row['fpczip'];

                                 

                    $jsonoutcome_data = [];
               

                                echo "---------------------------------------------------------<br>";

                                $curl = curl_init();

                                $url = 'https://www.flexbda.com/customersqr/migradorqrvultr_ajax.php';

                                $jsonData = ['parametro1' => 'valor1', 'parametro2' => 'MORETTI'];

                                $jsondatamm=["vv_idorders"=> $vv_idorders,
                                "vv_idcustomers"=> $vv_idcustomers ,
                                 "vv_idfamilyprod"=> $vv_idfamilyprod,
                                 "vv_idtypeband"=> $vv_idtypeband ,
                                 "vv_idtypeproduct"=> $vv_idtypeproduct,
                                 "vv_idproduct"=> $vv_idproduct ,
                                 "vv_idconfiguration"=> $vv_idconfiguration,
                                 "vv_idrev"=> $vv_idrev ,
                                 "vv_idnroserie"=> $vv_idnroserie,
                                 "vv_so_soft_external"=> $vv_so_soft_external ,
                                 "vv_wo_serialnumber"=> $vv_wo_serialnumber,
                                 "vv_idruninfo"=> $vv_idruninfo ,
                                 "vv_ponumber"=> $vv_ponumber,
                                 "vv_pwrsupplytype"=> $vv_pwrsupplytype ,
                                 "vv_rcgfbwa"=> $vv_rcgfbwa,
                                 "vv_moden_dig"=> $vv_moden_dig ,
                                 "vv_date_approved"=> $vv_date_approved,
                                 "vv_descripcion"=> $vv_descripcion ,
                                 "vv_nameapproved"=> $vv_nameapproved,
                                 "vv_typeregister"=> $vv_typeregister ,
                                 "vv_processday"=> $vv_processday,
                                 "vv_processfasserver"=> $vv_processfasserver ,
                                 "vv_so_original"=> $vv_so_original,
                                 "vv_so_associed"=> $vv_so_associed ,
                                 "vv_availablesn"=> $vv_availablesn,
                                 "vv_idorders_nxt_trk"=> $vv_idorders_nxt_trk ,
                                 "vv_idnroserie_nxt_trk"=> $vv_idnroserie_nxt_trk,
                                 "vv_sn"=> $vv_sn ,
                                 "vv_band0key"=> $vv_band0key,
                                 "vv_band1key"=> $vv_band1key ,
                                 "vv_maxpwrkey"=> $vv_maxpwrkey,
                                 "vv_classkey"=> $vv_classkey ,
                                 "vv_datetimesn"=> $vv_datetimesn,
                                 "vv_qrcustomer"=> $vv_qrcustomer ,
                                 "vv_idtypeproduct"=> $vv_idtypeproduct,
                                 "vv_idconfiguration"=> $vv_idconfiguration ,
                                 "vv_powersupply"=> $vv_powersupply,
                                 "vv_modelciu"=> $vv_modelciu ,
                                 "vv_description"=> $vv_description,
                                 "vv_classproduct"=> $vv_classproduct ,
                                 "vv_active"=> $vv_active,
                                 "vv_usermodif"=> $vv_usermodif ,
                                 "vv_datelastmodif"=> $vv_datelastmodif,
                                 "vv_woparam"=> $vv_woparam ,
                                 "vv_showdpxreport"=> $vv_showdpxreport,
                                 "vv_idbusiness"=> $vv_idbusiness ,
                                 "vv_iduniquebranchsonprod"=> $vvvv_iduniquebranchsonprod_idbandgroup,
                                 "vv_idtypeproductaux"=> $vv_idtypeproductaux ,
                                 "manualsku" =>$manualsku,
                                 "pfomszip" => $pfomszip,
                                 "fpczip"=> $fpczip,
                                 "vv_idrevproduct"=> $vv_idrevproduct, "vv_fiplexsku"=> $vv_fiplexsku];
                              
                             //   echo "<hr>";
                           //     var_dump($jsonData);
                              $jsonString = json_encode($jsonData);

                                $jsonoutcome_datamm = json_encode($jsonoutcome_data);
                                var_dump($jsonoutcome_datamm);

                                curl_setopt($curl, CURLOPT_URL, $url);
                                curl_setopt($curl, CURLOPT_POST, true);
                                //curl_setopt($curl, CURLOPT_POSTFIELDS, 'param1=marco&param2=moretti');
                                curl_setopt($curl, CURLOPT_POSTFIELDS, $jsondatamm);


                                curl_setopt($curl, CURLOPT_TIMEOUT, 10);
                                $curlResponse = curl_exec($curl);

                                if ($curlResponse === false) {
                                echo 'Error de cURL: ' . curl_error($curl);
                                } else {
                                echo 'Respuesta de la API: ' . $curlResponse;
                                }

                                curl_close($curl);
                                
                        
                   
			 
        }
      }


      ?>


                                    </div>
                                    <!-- /.card-body -->


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

<script src="crypto-js.js"></script>
<!-- https://github.com/brix/crypto-js/releases crypto-js.js can be download from here -->

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
$(document).ready(function() {

    //Inicio mostrar hora live
    var interval = setInterval(function() {

        var momentNow = moment();
        var newYork = momentNow.tz('America/New_York').format('ha z');
        $('#date-part').html(momentNow.format('YYYY/MM/DD'));
        $('#time-part').html(momentNow.format('hh:mm:ss'));
    }, 100);
    //FIN mostrar hora live

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




function show_log(idlog_view) {

    $("#detallelog").fadeOut('fast');
    $("#msjwait").fadeIn('slow');

    $("#uso").val(1);

    $.ajax({
        url: 'readlogbyruninfo.php',
        data: "idlog=" + idlog_view,
        type: 'post',
        async: true,
        cache: false,
        success: function(data) {
            var datax = JSON.parse(data)
            //	console.log(datax);
            //   console.log(datax.vuser);

            //detallelog
            $("#msjwait").hide();
            $("#detallelog").fadeIn(100);
            //var re = /<TERM>/g; 						
            $("#detallelog").html(datax.data.replace(/<br>/g, ' \r\n'));

            if ($(window).height() > 800) {
                $("#detallelog").height(585);
            }


            $(window).height();

            $('#lblvuser').text(datax.vuser.replace("#", " "));
            $('#lblvdevice').text(datax.vdecice.replace("#", " "));
            var anex = "'" + idlog_view + "'";

            $('#lblvstationr').html(datax.vstation.replace("#", " ") + ' <a href="#" onclick="show_log2(' +
                anex + ')") ><i class="fas fa-bug" style="color:blue"></i></a>');

        }
    });
}

function show_log2(idlog_view) {


    $("#detallelog").fadeOut('fast');
    $("#msjwait").fadeIn('slow');

    $("#uso").val(1);

    $.ajax({
        url: 'readlogbyruninfodebug.php',
        data: "idlog=" + idlog_view,
        type: 'post',
        async: true,
        cache: false,
        success: function(data) {
            var datax = JSON.parse(data)
            //	console.log(datax);
            //   console.log(datax.vuser);

            //detallelog
            $("#msjwait").hide();
            $("#detallelog").fadeIn(100);
            //var re = /<TERM>/g; 						
            $("#detallelog").html(datax.data.replace(/<br>/g, ' \r\n'));
            $('#lblvuser').text(datax.vuser.replace("#", " "));
            $('#lblvdevice').text(datax.vdecice.replace("#", " "));
            var anex = "'" + idlog_view + "'";

            $('#lblvstationr').html(datax.vstation.replace("#", " ") + ' <a href="#" onclick="show_log(' +
                anex + ')") ><i class="fas fa-bug" style="color:green"></i></a>');

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
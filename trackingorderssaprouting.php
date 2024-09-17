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
	//		exit();
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
    <link rel="stylesheet" href="cssfiplexsintextareaslog.css">

    <link href="css/select2.css" rel="stylesheet" />
    <link href="css/testcssselector.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="cssfiplex.css">
    <style>
    .track {
        position: relative;
        background-color: #ddd;
        height: 7px;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        margin-bottom: 80px;
        margin-top: 50px
    }

    .track .step {
        -webkit-box-flex: 1;
        -ms-flex-positive: 1;
        flex-grow: 1;
        width: 25%;
        margin-top: -18px;
        text-align: center;
        position: relative
    }

    .track .step.active:before {
        background: #FF5722
    }

    .track .step::before {
        height: 7px;
        position: absolute;
        content: "";
        width: 100%;
        left: 0;
        top: 18px
    }

    .track .step.active .icon {
        background: #ee5435;
        color: #fff
    }

    .track .icon {
        display: inline-block;
        width: 40px;
        height: 40px;
        line-height: 40px;
        position: relative;
        border-radius: 100%;
        background: #ddd
    }

    .track .step.active .text {
        font-weight: 400;
        color: #000
    }

    /** ** stepverde */
    .track .stepverde {
        -webkit-box-flex: 1;
        -ms-flex-positive: 1;
        flex-grow: 1;
        width: 25%;
        margin-top: -18px;
        text-align: center;
        position: relative
    }

    .track .stepverde.active:before {
        background: #28a745;
    }

    .track .stepverde::before {
        height: 7px;
        position: absolute;
        content: "";
        width: 100%;
        left: 0;
        top: 18px
    }

    .track .stepverde.active .icon {
        background: #28a745;
        color: #fff
    }

    .track .icon {
        display: inline-block;
        width: 40px;
        height: 40px;
        line-height: 40px;
        position: relative;
        border-radius: 100%;
        background: #ddd
    }

    .track .stepverde.active .text {
        font-weight: 400;
        color: #000
    }

    /** ** fin stepverde */

    .track .stepazulyamarillo {
        -webkit-box-flex: 1;
        -ms-flex-positive: 1;
        flex-grow: 1;
        width: 25%;
        margin-top: -18px;
        text-align: center;

        position: relative
    }

    .track .stepazulyamarillo.active .icon {
        background: #ffc107;
        color: #fff
    }

    .track .stepazulyamarillo::before {
        height: 7px;
        position: absolute;
        content: "";
        width: 100%;
        left: 0;
        top: 18px
    }



    /*///step azul//*/
    .track .stepazul {
        -webkit-box-flex: 1;
        -ms-flex-positive: 1;
        flex-grow: 1;
        width: 25%;
        margin-top: -18px;
        text-align: center;
        position: relative
    }




    .track .stepazul.active:before {
        background: #0053a1;
    }

    .track .stepazul::before {
        height: 7px;
        position: absolute;
        content: "";
        width: 100%;
        left: 0;
        top: 18px
    }

    .track .stepazul.active .icon {
        background: #0053a1;
        ;
        color: #fff
    }

    .track .icon {
        display: inline-block;
        width: 40px;
        height: 40px;
        line-height: 40px;
        position: relative;
        border-radius: 100%;
        background: #ddd
    }

    .track .stepazul.active .text {
        font-weight: 400;
        color: #000
    }

    /*///fin step azul//*/

    .track .text {
        display: block;
        margin-top: 7px
    }

    .itemside {
        position: relative;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        width: 100%
    }

    .itemside .aside {
        position: relative;
        -ms-flex-negative: 0;
        flex-shrink: 0
    }

    .img-sm {
        width: 80px;
        height: 80px;
        padding: 7px
    }

    ul.row,
    ul.row-sm {
        list-style: none;
        padding: 0
    }

    .itemside .info {
        padding-left: 15px;
        padding-right: 7px
    }

    .itemside .title {
        display: block;
        margin-bottom: 5px;
        color: #212529
    }


    .vertical-timeline {
        width: 100%;
        position: relative;
        padding: 1.5rem 0 1rem
    }

    .vertical-timeline::before {
        content: '';
        position: absolute;
        top: 0;
        left: 67px;
        height: 100%;
        width: 4px;
        background: #e9ecef;
        border-radius: .25rem
    }

    .vertical-timeline-element {
        position: relative;
        margin: 0 0 1rem
    }

    .vertical-timeline--animate .vertical-timeline-element-icon.bounce-in {
        visibility: visible;
        animation: cd-bounce-1 .8s
    }

    .vertical-timeline-element-icon {
        position: absolute;
        top: 0;
        left: 60px
    }

    .vertical-timeline-element-icon .badge-dot-xl {
        box-shadow: 0 0 0 5px #fff
    }

    .badge-dot-xl {
        width: 18px;
        height: 18px;
        position: relative
    }

    .badge:empty {
        display: none
    }

    .badge-dot-xl::before {
        content: '';
        width: 10px;
        height: 10px;
        border-radius: .25rem;
        position: absolute;
        left: 50%;
        top: 50%;
        margin: -5px 0 0 -5px;
        background: #fff
    }

    .vertical-timeline-element-content {
        position: relative;
        margin-left: 90px;
        font-size: .8rem
    }

    .vertical-timeline-element-content .timeline-title {
        font-size: .8rem;
        text-transform: uppercase;
        margin: 0 0 .5rem;
        padding: 2px 0 0;
        font-weight: bold
    }

    .vertical-timeline-element-content .vertical-timeline-element-date {
        display: block;
        position: absolute;
        left: -90px;
        top: 0;
        padding-right: 10px;
        text-align: right;
        color: #adb5bd;
        font-size: .7619rem;
        white-space: nowrap
    }

    .vertical-timeline-element-content:after {
        content: "";
        display: table;
        clear: both
    }

    h2 {
        display: block;
        font-size: 1.5em;
        margin-block-start: 0.83em;
        margin-block-end: 0.83em;
        margin-inline-start: 0px;
        margin-inline-end: 0px;
        font-weight: bold;
    }

    h3 {
        display: block;
        font-size: 1.17em;
        margin-block-start: 1em;
        margin-block-end: 1em;
        margin-inline-start: 0px;
        margin-inline-end: 0px;
        font-weight: bold;
    }

    .modal-xl {
        max-width: 1500px;
    }
    </style>
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
                        <a href="http://webfas.honeywell.com/index.php" class="nav-link">Home</a>
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

 

        
?>


            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Tracking Orders SAP </h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">Tracking Orders</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="" name="divscrolllog" id="divscrolllog" style="display.">
                            <!-- Timelime example  -->
                            <div class="row">
                                <section class="col-lg-12 connectedSortable ui-sortable">
                                    <p name="msjwaitline" id="msjwaitline" align="center"><img src="img/waitazul.gif"
                                            width="100px"></p>
                                    <div class="card">
                                        <div class="container-fluid">
                                            <br>
                                            <div class="form-group row">

                                                <label for="inputPassword"
                                                    class="col-sm-1 col-form-label">Search:</label>
                                                <div class="col-sm-12">

                                                    <select class="js-example-basic-single col-sm-8" id="txtlistcius"
                                                        name="txtlistcius">

                                                    </select>

                                                    &nbsp; &nbsp; <a href='#' onclick='refrescardatos()'><i
                                                            class="fa fa-refresh" style="font-size:26px"></i> </a>

                                                </div>



                                            </div>

                                            <p algin="right" class="col-4">
                                                <button class="btn btn-primary btn-lg btn-block btn-sm" type="button"
                                                    data-toggle="collapse" data-target="#collapseExample"
                                                    aria-expanded="false" aria-controls="collapseExample">
                                                    Custom Search
                                                </button>

                                            </p>
                                            <div class="col-4 collapse" id="collapseExample">
                                                <div class="card card-body">
                                                    <b>Step Activity </b>
                                                    <br>
                                                    Steps:
                                                    <select class="form-control form-control-sm" name="filterstep"
                                                        id="filterstep">
                                                        <option value="">All</option>
                                                        <option value="finalcheckso">Final Check</option>
                                                        <option value="finalinspection">Final Inspection</option>
                                                    </select>
                                                    <br>
                                                    <b>Date Range:</b> <input id="daterangem" name="daterangem">
                                                    <hr>
                                                    <b>Picking:</b>
                                                    <div class="form-group row">
                                                        <label for="inputEmail3"
                                                            class="col-sm-2 col-form-label">CIU:</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" id="txtsearchtxtciu"
                                                                name="txtsearchtxtciu"
                                                                class="form-control form-control-sm">
                                                        </div>
                                                        <label for="inputEmail3"
                                                            class="col-sm-2 col-form-label">SN:</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" id="txtsearchtxtsn" name="txtsearchtxtsn"
                                                                class="form-control form-control-sm">
                                                        </div>
                                                        <label for="inputEmail3"
                                                            class="col-sm-2 col-form-label">Rev:</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" id="txtsearchtxtrev"
                                                                name="txtsearchtxtrev"
                                                                class="form-control form-control-sm">
                                                        </div>

                                                    </div>
                                                    <div class="card-footer">

                                                        <button type="submit"
                                                            class="btn btn-block btn-outline-primary btn-xs float-right">Search</button>
                                                    </div>
                                                </div>
                                            </div>


                                            <p align="right">
                                                <a class=" " data-toggle="collapse" href="#reportsap" role="button"
                                                    aria-expanded="false" aria-controls="reportsap">
                                                    View Report Information sent to SAP
                                                </a>

                                            </p>
                                            <div class="collapse" id="reportsap">

                                                <div class="card " id="cuadrototalesfran" name="cuadrototalesfran">
                                                    ...
                                                </div>
                                            </div>

                                            <hr>


                                            <div class="card " id="artSO" name="artSO">


                                                <div class="card-header">
                                                    <h3 class="card-title">
                                                        <h3 class="card-title">:: Tracking :: </h3>


                                                        <div class="card-tools">
                                                            <button type="button" class="btn btn-tool"
                                                                data-card-widget="collapse">
                                                                <i class="fas fa-minus"></i>
                                                            </button>

                                                        </div>
                                                </div>
                                                <div class="card-body">

                                                    <div>
                                                        <?php
                  //////////////////////////// //////////////////////////////
    
                  $wheredaterange="";
                  $wherefiltroporpasos ="";
                  $wherefiltroporpasosfinalinspection ="";
                  $jsondatarange = $_REQUEST['daterangem'];
                  $filtroporpasos = $_REQUEST['filterstep'];           
                  //////////////////////////// //////////////////////////////
                       $v_idp = $_REQUEST['isdo'];
                       $filtrar_xsn = substr($_REQUEST['encont'],-2);
                       $snafiltrar =  $_REQUEST['encont'];
                       $typeisdo =  $_REQUEST['typeisdo'];

                      ///////// ACA CAMBIAMOS LA BUSQUEDA SI ES RM
                  //////////////////////////// //////////////////////////////
                  //////////////////////////// //////////////////////////////
                      ////NUEVO SAP
            $filtrar_xsn = substr($_REQUEST['encont'],-2);
            $where_sn_add ="";
            if ($filtrar_xsn=="FU")
            {
              $where_sn_add ="  and orders_sn.wo_serialnumber ='".$_REQUEST['encont']."' ";    
            }
                    if ( $typeisdo =="UP")
                      {
                                    $sqlbusco="  select distinct 1 as orr, orders.idorders , orders.processfasserver::int as processfasserver, 
                                     products.modelciu,so_associed,  orders_sn.so_soft_external as  tienesoasociada, 
                                     orders.quantity,orders_sn.so_soft_external, orders_sn.wo_serialnumber 
                                     from orders
                                     inner join orders_sn 
                                     on orders_sn.idorders = orders.idorders
                                     inner join products
                                     on products.idproduct = orders.idproduct
                                  
                            
                             
                                     where orders.idorders in (
                                      select distinct idorders from orders_sn
                                       inner join 
                                      (  select so_associed ,wo_serialnumber from orders_sn where idorders= ".$v_idp." and idnroserie>0) as ttm
                                      on ttm.so_associed = orders_sn.so_soft_external and
                                         ttm.wo_serialnumber = orders_sn.wo_serialnumber
            
                                    )    and orders_sn.idnroserie >0 and orders.typeregister <> 'UP'    ".$where_sn_add;
                      }
                      else
                      {
                              $sqlbusco="  select distinct 1 as orr, orders.idorders , orders.processfasserver::int as processfasserver, 
                              products.modelciu,so_associed,  orders_sn.so_soft_external as  tienesoasociada, 
                            orders.quantity,orders_sn.so_soft_external, orders_sn.wo_serialnumber 
                                                 from orders
                                                 inner join orders_sn 
                                                 on orders_sn.idorders = orders.idorders
                                                 inner join products
                                                 on products.idproduct = orders.idproduct
                                              
                                        
                                         
                                   where orders.idorders =".$v_idp."     and orders_sn.idnroserie >0    ".$where_sn_add;
                      }
           
                    //  echo  $sqlbusco;
                  ?>
                                                    </div>
                                                    <div class="track1" name="track1" id="track1">
                                                    </div>


                                                </div>
                                            </div>
                                        </div>


                                        <br>
                                        <br>
                                        <br>


                                    </div>
                                    <br>
                                    <br>
                                    <hr>
                                    <br>
                                    <br>
                                </section>

                                <!-- /.col -->
                            </div>
                        </div>
                        <!-- /.timeline -->

                </section>
                <!-- /.content -->

            </div>

            <?php

  
  ?>
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


<script src="plugins/moment/moment.min.js"></script>



<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="toastr.min.js"></script>




<script src="js/eModal.min.js" type="text/javascript">
< script src = "plugins/jquery-knob/jquery.knob.min.js" >
</script>


<script src="jsdaterange/jquery.min183.js"></script>


<link href="jsdaterange/jquery-ui.min.css" rel="stylesheet">
<script src="jsdaterange/jquery-ui.js"></script>
<script src="js/jquery.inactivityTimeout.js"></script>
<script src="js/moment-timezone-with-data.js"></script>

<link href="jsdaterange/jquery.comiseo.daterangepicker.css" rel="stylesheet">
<script src="jsdaterange/jquery.comiseo.daterangepicker.js"></script>

<script src="js/select2.min.js"></script>





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
    console.log("ready!");
    $('#msjwaitline ').hide();
    $('#divscrolllog').show();


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

    $('.js-example-basic-single').select2();

    $(function() {
        $("#daterangem").daterangepicker({
            dateFormat: "(yy-mm-dd)"
        });
    });
    // AutoComplete de CUIS version TOP



    function formatRepo(repo) {

        if (repo.loading) {
            return repo.text;
        }

        var $container = $(
            "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__avatar'><img src='img/imgciu.jpg' /></div>" +
            "<div class='select2-result-repository__meta'>" +
            "<div class='select2-result-repository__title'></div>" +
            "<div class='select2-result-repository__description'></div>" +
            "</div>" +
            "</div>"
        );

        $container.find(".select2-result-repository__title").text(repo.text);
        $container.find(".select2-result-repository__description").html(repo.description);
        $container.find(".select2-result-repository__avatar").html('<h2><b>' + repo.img + '</b></h2>');
        $container.find(".select2-result-repository__forks").append("101" + " Forks");
        $container.find(".select2-result-repository__stargazers").append("102" + " Stars");
        $container.find(".select2-result-repository__watchers").append("103" + " Watchers");
        //  console.log(repo.text);
        return $container;
    }

    function formatRepoSelection(repo) {
        // console.log('1' + repo.text);
        return repo.full_name || repo.text;
    }


    $('#txtlistcius').select2({
        ajax: {
            url: "ajax_list_searchalltracking.php",
            dataType: 'json',
            delay: 2,
            data: function(params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function(data) {
                // Transforms the top-level key of the response object from 'items' to 'results'
                return {
                    results: data.items
                };
            },
            cache: false
        },
        placeholder: 'Search WO / SO / SN',
        minimumInputLength: 1,
        templateResult: formatRepo,
        templateSelection: formatRepoSelection
    });

    // fin// AutoComplete de CUIS version TOP	

});


// controlar inactividad en la web	
$(document).inactivityTimeout({
    inactivityWait: 30000,
    dialogWait: 100,
    logoutUrl: 'logout.php'
})
// fin controlar inactividad en la web		

/* requesting data */



function refrescardatos() {
    var datosmm = $("#txtlistcius").val().split("#");
    console.log($("#txtlistcius").val());
    ///    window.location = 'trackingorderssaprouting.php?isdo='+datosmm[0]+'&typeisdo='+datosmm[1]+'&encont='+datosmm[2];
    mostrar_tracking(datosmm[0], datosmm[1], datosmm[2]);
}

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


$("#txtlistcius").change(function() {
    var datosmm = $("#txtlistcius").val().split("#");
    console.log($("#txtlistcius").val());
    ///    window.location = 'trackingorderssaprouting.php?isdo='+datosmm[0]+'&typeisdo='+datosmm[1]+'&encont='+datosmm[2];
    mostrar_tracking(datosmm[0], datosmm[1], datosmm[2])
});

function mostrar_tracking(vvisdo, vvtypeisdo, vvencont) {
    ////// REPORTE FRANCESCO
    $.ajax({
        url: 'ajax_tracking_reporteresumen.php',
        data: "idorders=" + vvisdo,
        type: 'post',
        success: function(data) {

            $('#cuadrototalesfran').html(data);

        }
    });
    ///// fin REPORTE FRANCESCO

    ////// BUSCAMOS LOS SN PARA RECORRER
    $('#track1').html('Searching...');
    $.ajax({
        url: 'ajax_tracking_search_sns.php',
        data: "vvisdo=" + vvisdo + '&vvtypeisdo=' + vvtypeisdo + '&vvencont=' + vvencont,
        type: 'post',
        datatype: 'JSON',
        success: function(data) {
            // 
            // console.log(data.isdigunit);
            var objm = JSON.parse(data);
            var lostracking = '';
            console.log(objm.isdigunit);
            $('#track1').html(lostracking);
            $.each(objm.itemallan, function(i, itemsn) {
                // console.log(itemsn.wo_serialnumber ); 
                lostracking = lostracking + '<div class="track" name="track' + itemsn
                    .wo_serialnumber + '" id="track' + itemsn.wo_serialnumber +
                    '"> <div class="stepazul   active">  ' + itemsn.wo_serialnumber +
                    ' </div> </div><br><br>';
                ///// BUSCAR DATOS DEL Module

            });
            $('#track1').html(lostracking);
            $.each(objm.itemallan, function(i, itemsn) {

                console.log(itemsn.wo_serialnumber);
                return new Promise(function(resolve, reject) {
                    var formData = new FormData();
                    var req = new XMLHttpRequest();
                    //consulta si devolvio el Scan Device                                                        
                    formData.append("idorders", itemsn.idorders);
                    formData.append("sn", itemsn.wo_serialnumber);
                    formData.append("so", itemsn.so_soft_external);
                    formData.append("modelciu", itemsn.modelciu);
                    formData.append("so_soft_external", itemsn.so_soft_external);
                    formData.append("tienesoasociada", itemsn.tienesoasociada);
                    req.open("POST", "ajax_createtrackingbysn.php");
                    req.send(formData);

                    req.onload = function() {
                        if (req.status == 200) {
                            //  resolve(JSON.parse(req.response));
                            console.log(req.response);
                            //  console.log('INFORMACION RECIBIDA  ');
                            //  var objrespuesta = JSON.parse(req.response);
                            //  console.log (objrespuesta.dreturn_coupler);
                            $("#track" + itemsn.wo_serialnumber).html(req.response);


                        } else {
                            reject();
                        }
                    };


                });
                ///// FIN BUSCAR DATOS DEL MODULE

            });


            ///alert(data.result);
            // track1



        }
    });
    ////// FIN BUSCAMOS LOS SN PARA RECORRER                
}

function popuplogdb(idrunifno) {
    eModal.iframe('logdbonlydet.php?idab=' + idrunifno, 'Log Activity');
}

function attachanalogbda(vidord, lasemillita, vtempsn) {
    eModal.iframe('attachfileprojectsoaddmoreanalogbda.php?idt=' + lasemillita + '&idord=' + vidord + '&vvsn=' +
        vtempsn, 'Attach files to SN	  ');
}


function show_info_stepidsap(desdedonde, snparam, soparam, sotextoamostrar, idruninfoparam, idparamafterburning,
    stepidsap) {
    ///aca tenia un error
    ///   $("#artSO").CardWidget('collapse');
    //    $("#artSO").Widget("collapse"); 
    //     $("#artSO").collapse("hide"); 
    var armando_tabla_info = '';
    $('#titudetalle').html('Searching');
    $('#divdetalles').html("");
    toastr["info"]("SN: " + snparam, "Searching")


    ///////////////////////////////////////////////////////////////////////////////////////
    ///show_info('calibrationyburchk','21076433FU','623','Calibration :: SN: 21076433FU','10954067627')
    if (desdedonde == 'calibrationentermater') {
        eModal.iframe('https://webfas.honeywell.com/calibrationentermastermth.php?sn=' + snparam +
            '&hidmenu=Y&idruninfo=' + idruninfoparam + '&stepidsap=' + stepidsap, 'Calibration Enterprise Master ');
    }

    if (desdedonde == 'calibrationyburchk') {
        eModal.iframe('https://webfas.honeywell.com/autotestboxtimeline.php?hidmenu=Y&idr=' + idruninfoparam +
            '&stepidsap=' + stepidsap,
            'Calibration & Burnin Check ');

    }
    ////////////////////////////////////////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////////////////////////////////////
    if (desdedonde == 'PrecheckBBUANN') {
        eModal.iframe('calibrationqualitychecklisallsurvery.php?elsn=' + snparam + '&elso=' + soparam + '&elciu=' +
            sotextoamostrar + '&stepidsap=' + stepidsap + '&typeworkm=' + idparamafterburning,
            'BBU ANN Acceptance Test');

    }
    ////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////
    if (desdedonde == 'picking') {
        eModal.iframe('wopickingsteps.php?elso=' + soparam + '&elsn=' + snparam + '&elciu=' + sotextoamostrar +
            '&typeworkc=ASSY' + '&stepidsap=' + stepidsap, ' ' + snparam + ' || ' + soparam + ' || ' +
            sotextoamostrar);
    }
    ////////////////////////////////////////////////////////////////////////////////////////
    if (desdedonde == 'orderinfo') {

        eModal.iframe('show_tracking_orderinfo.php?soparam=' + soparam + '&snparam=' + snparam + '&stepidsap=' +
            stepidsap, sotextoamostrar);



    }

    if (desdedonde == 'polypaste') {
        ////show_tracking_polypaste.php?soparam=160&snparam=21036195FU
        eModal.iframe('show_tracking_polypaste.php?soparam=' + soparam + '&snparam=' + snparam + '&stepidsap=' +
            stepidsap, 'Poly Paste');
    }
    ////////////////////////////////////////////////////////////////////////////////////////
    if (desdedonde == 'acceptance') {
        eModal.iframe('acceptflex.php?idsndib=' + snparam + '&logo=N' + '&stepidsap=' + stepidsap, sotextoamostrar);


    }
    //////////////////////////////////////////////////////////////////////////////////////////////////
    if (desdedonde == 'finalchk') {
        eModal.iframe('finalchkallband.php?dnd=WO&idsndib=' + snparam + '&idmb=9&iduldl=9&idruninfo=' + idruninfoparam +
            '&stepidsap=' + stepidsap,
            sotextoamostrar);


    }
    ////////////////////////////////////////////////////////////////////////////////////////
    if (desdedonde == 'finalchkenterpriseremoto') {
        eModal.iframe('autotestcalibrationenterremotemthafterbur.php?hidmenu=Y&sn=' + snparam +
            '&idmb=0&iduldl=0&&idruninfo=' + idruninfoparam + '&stepidsap=' + stepidsap, sotextoamostrar);
    }
    //////////////////////////////////////////////////////////////////////////////////////////////////
    if (desdedonde == 'finalchkenterprisemaster') {
        eModal.iframe('finalchkentermastermth.php?hidmenu=Y&sn=' + snparam + '&idmb=0&iduldl=0&&idruninfo=' +
            idruninfoparam + '&stepidsap=' + stepidsap, sotextoamostrar);
    }
    //////////////////////////////////////////////////////////////////////////////////////////////////
    if (desdedonde == 'calibration') {
        eModal.iframe('equalizeriir.php?idsndib=' + snparam + '&idmb=0&iduldl=0&idruninfo=' + idruninfoparam +
            '&stepidsap=' + stepidsap,
            sotextoamostrar);


    }

    if (desdedonde == 'calibrationentremmth') {
        eModal.iframe('autotestcalibrationenterremotemth.php?hidmenu=Y&sn=' + snparam + '&idmb=0&iduldl=0&&idruninfo=' +
            idruninfoparam + '&stepidsap=' + stepidsap, sotextoamostrar);


    }

    if (desdedonde == 'finalchksorma_enterprisemater') {

        eModal.iframe('https://webfas.honeywell.com/finalchkentermastermth.php?sn=' + snparam +
            '&hidmenu=Y&idruninfo=' + idruninfoparam + '&stepidsap=' + stepidsap, 'Final Check Enterprise Master ');

    }


    ////////////////////////////////////////////////////////////////////////////////////////

    //////////////////////////////////////////////////////////////////////////////////////////////////
    if (desdedonde == 'finalchkso') {

        eModal.iframe('finalchkallband.php?dnd=SO&idsndib=' + snparam + '&idmb=9&iduldl=9&idruninfo=' + idruninfoparam +
            '&idrunaferbur=' + idparamafterburning + '&stepidsap=' + stepidsap, sotextoamostrar);

    }

    if (desdedonde == 'finalchksotemp') {

        eModal.iframe('finalchkallband.php?dnd=SO&tempso=OO&idsndib=' + snparam + '&idmb=9&iduldl=9&idruninfo=' +
            idparamafterburning + '&idrunaferbur=' + idparamafterburning + '&stepidsap=' + stepidsap,
            sotextoamostrar);

    }
    ////////////////////////////////////////////////////////////////////////////////////////
    if (desdedonde == 'Precheck') {

        eModal.iframe('calibrationqualitychecklist.php?elsn=' + snparam + '&elso=' + soparam + '&elciu=' +
            sotextoamostrar + '&typeworkm=wo_PRECHECK' + '&stepidsap=' + stepidsap, 'Quality precheck');

    }

    if (desdedonde == 'PrecheckBBUscs') {

        eModal.iframe('calibrationqualitychecklistbbuscs.php?elsn=' + snparam + '&elso=' + soparam + '&elciu=' +
            sotextoamostrar + '&stepidsap=' + stepidsap, 'BBU Integration Checklist');

    }

    ////////////////////////////////////////////////////////////////////////////////////////
    if (desdedonde == 'Precheckultest') {

        eModal.iframe('electricstrengthchecklist.php?elsn=' + snparam + '&elso=' + soparam + '&elciu=' +
            sotextoamostrar + '&stepidsap=' + stepidsap + '&typeworkm=' + idparamafterburning, 'Quality UlTest');

    }

    if (desdedonde == 'Precheckfinalcheck') {

        eModal.iframe('surveyfinalcheck.php?elsn=' + snparam + '&elso=' + soparam + '&elciu=' + sotextoamostrar +
            '&stepidsap=' + stepidsap,
            'Final Inspection');

    }

    //reportburnin
    if (desdedonde == 'reportburnin') {

        //eModal.iframe('report_burnin.php?hidmenu=Y&idr='+idruninfoparam,'Report Burning');
        eModal.iframe('burningtestreport.php?hidmenu=Y&sn=' + snparam + '&idruninfo=' + idruninfoparam + '&stepidsap=' +
            stepidsap,
            'Report Burning');

    }

    if (desdedonde == 'orderinfoupgrade') {
        //// show_info(desdedonde,snparam, soparam, sotextoamostrar, idruninfoparam, idparamafterburning)
        //eModal.iframe('report_burnin.php?hidmenu=Y&idr='+idruninfoparam,'Report Burning');
        eModal.iframe('show_upgrade_orderinfo.php?hidmenu=Y&sn=' + snparam + '&soparam=' + soparam +
            '&sotextoamostrar=' + sotextoamostrar + '&stepidsap=' + stepidsap, 'Upgrade Info');

    }
    /////asingsnwotoso
    if (desdedonde == 'asingsnwotoso') {
        //// show_info(desdedonde,snparam, soparam, sotextoamostrar, idruninfoparam, idparamafterburning)
        //eModal.iframe('report_burnin.php?hidmenu=Y&idr='+idruninfoparam,'Report Burning');
        eModal.iframe('show_tracking_assignsn_wotoso.php?hidmenu=Y&sn=' + snparam + '&soparam=' + soparam +
            '&sotextoamostrar=' + sotextoamostrar + '&stepidsap=' + stepidsap, 'Assing SN ');

    }





    //   $("#artSO").CardWidget('collapse');

}

function show_info(desdedonde, snparam, soparam, sotextoamostrar, idruninfoparam, idparamafterburning) {
    ///aca tenia un error
    ///   $("#artSO").CardWidget('collapse');
    //    $("#artSO").Widget("collapse"); 
    //     $("#artSO").collapse("hide"); 
    var armando_tabla_info = '';
    $('#titudetalle').html('Searching');
    $('#divdetalles').html("");
    toastr["info"]("SN: " + snparam, "Searching")


    ///////////////////////////////////////////////////////////////////////////////////////
    ///show_info('calibrationyburchk','21076433FU','623','Calibration :: SN: 21076433FU','10954067627')
    if (desdedonde == 'calibrationentermater') {
        eModal.iframe('https://webfas.honeywell.com/calibrationentermastermth.php?sn=' + snparam +
            '&hidmenu=Y&idruninfo=' + idruninfoparam, 'Calibration Enterprise Master ');
    }

    if (desdedonde == 'calibrationyburchk') {
        eModal.iframe('https://webfas.honeywell.com/autotestboxtimeline.php?hidmenu=Y&idr=' + idruninfoparam,
            'Calibration & Burnin Check ');

    }
    ////////////////////////////////////////////////////////////////////////////////////////
    /////calibbburepot_mms_bbu
    if (desdedonde == 'accept_bburepot_mms_bbu_rf') {

        /// report viejo
        //eModal.iframe('https://webfas.honeywell.com/autotestboxtimeline_mms.php?hidmenu=Y&idr=' + idruninfoparam,            'MMS BBU RF ');
        /// REPORT NUEVO MAS COMPLETO    
        eModal.iframe('https://webfas.honeywell.com/autotestboxtimelinerepfinal.php?hidmenu=Y&idr=' + idruninfoparam,
            'MMS BBU RF ');

    }

    /////calibbburepot_bbumvo2_bbu
    if (desdedonde == 'calibbburepot_bbumvo2_bbu') {

 ///https://webfas.honeywell.com/calibbburepot_bbumvo2_bbu.php?hidmenu=Y&idr=10920200001928&unitsn=20056018DV 
eModal.iframe('https://webfas.honeywell.com/calibbburepot_bbumvo2_bbu.php?hidmenu=Y&idr=' + idruninfoparam + '&unitsn='+snparam,
    'BBU NVO2');

}


    if (desdedonde == 'accep_repot_mms_bbu') {
        eModal.iframe('https://webfas.honeywell.com/calibbburepot_mms_bbu.php?hidmenu=Y&idr=' + idruninfoparam +
            '&unitsn=' +
            snparam, 'MMS BBU Acceptance ');

    }

    ////calibbburepot_hp -- BBU HP
    if (desdedonde == 'accep_repot_mms_bbu_hp') {
        eModal.iframe('https://webfas.honeywell.com/calibbburepot_hp.php?hidmenu=Y&idrun=' + idruninfoparam +
            '&unitsn=' +
            snparam, 'HP BBU Acceptance ');

    }


    ///////////////////////////////////////////////////////////////////////////////////////
    if (desdedonde == 'PrecheckBBUANN') {
        eModal.iframe('calibrationqualitychecklisallsurvery.php?elsn=' + snparam + '&elso=' + soparam + '&elciu=' +
            sotextoamostrar, 'BBU ANN Acceptance Test');

    }
    ////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////
    if (desdedonde == 'picking') {
        eModal.iframe('wopickingsteps.php?elso=' + soparam + '&elsn=' + snparam + '&elciu=' + sotextoamostrar +
            '&typeworkc=' + idparamafterburning + '&idruninfoparam=' + idruninfoparam, ' ' + snparam + ' || ' +
            soparam + ' || ' + sotextoamostrar);
    }
    ////////////////////////////////////////////////////////////////////////////////////////
    if (desdedonde == 'orderinfo') {

        eModal.iframe('show_tracking_orderinfo.php?soparam=' + soparam + '&snparam=' + snparam, sotextoamostrar);



    }

    if (desdedonde == 'polypaste') {
        ////show_tracking_polypaste.php?soparam=160&snparam=21036195FU
        eModal.iframe('show_tracking_polypaste.php?soparam=' + soparam + '&snparam=' + snparam, 'Poly Paste');
    }
    ////////////////////////////////////////////////////////////////////////////////////////
    if (desdedonde == 'acceptance') {
        eModal.iframe('acceptflex.php?idsndib=' + snparam + '&logo=N', sotextoamostrar);


    }
    //////////////////////////////////////////////////////////////////////////////////////////////////
    if (desdedonde == 'finalchk') {
        eModal.iframe('finalchkallband.php?dnd=WO&idsndib=' + snparam + '&idmb=9&iduldl=9&idruninfo=' + idruninfoparam,
            sotextoamostrar);


    }
    ////////////////////////////////////////////////////////////////////////////////////////
    if (desdedonde == 'finalchkenterpriseremoto') {
        eModal.iframe('autotestcalibrationenterremotemthafterbur.php?hidmenu=Y&sn=' + snparam +
            '&idmb=0&iduldl=0&&idruninfo=' + idruninfoparam, sotextoamostrar);
    }
    //////////////////////////////////////////////////////////////////////////////////////////////////
    if (desdedonde == 'finalchkenterprisemaster') {
        eModal.iframe('finalchkentermastermth.php?hidmenu=Y&sn=' + snparam + '&idmb=0&iduldl=0&&idruninfo=' +
            idruninfoparam, sotextoamostrar);
    }
    //////////////////////////////////////////////////////////////////////////////////////////////////
    if (desdedonde == 'calibration') {
        eModal.iframe('equalizeriir.php?idsndib=' + snparam + '&idmb=0&iduldl=0&idruninfo=' + idruninfoparam,
            sotextoamostrar);
    }

    if (desdedonde == 'calibrationmms') {
        eModal.iframe('autotestboxtimeline.php?hidmenu=Y&idr=' + idruninfoparam, sotextoamostrar);
    }

    if (desdedonde == 'calibrationentremmth') {
        eModal.iframe('autotestcalibrationenterremotemth.php?hidmenu=Y&sn=' + snparam + '&idmb=0&iduldl=0&&idruninfo=' +
            idruninfoparam, sotextoamostrar);


    }

    if (desdedonde == 'finalchksorma_enterprisemater') {

        eModal.iframe('https://webfas.honeywell.com/finalchkentermastermth.php?sn=' + snparam +
            '&hidmenu=Y&idruninfo=' + idruninfoparam, 'Final Check Enterprise Master ');

    }


    ////////////////////////////////////////////////////////////////////////////////////////

    //////////////////////////////////////////////////////////////////////////////////////////////////
    if (desdedonde == 'finalchkso') {

        eModal.iframe('finalchkallband.php?dnd=SO&idsndib=' + snparam + '&idmb=9&iduldl=9&idruninfo=' + idruninfoparam +
            '&idrunaferbur=' + idparamafterburning, sotextoamostrar);

    }

    if (desdedonde == 'finalchksotemp') {

        eModal.iframe('finalchkallband.php?dnd=SO&tempso=OO&idsndib=' + snparam + '&idmb=9&iduldl=9&idruninfo=' +
            idparamafterburning + '&idrunaferbur=' + idparamafterburning, sotextoamostrar);

    }
    ////////////////////////////////////////////////////////////////////////////////////////
    if (desdedonde == 'Precheck') {

        eModal.iframe('calibrationqualitychecklist.php?elsn=' + snparam + '&elso=' + soparam + '&elciu=' +
            sotextoamostrar + '&typeworkm=' + idparamafterburning, 'Quality precheck');

    }

    if (desdedonde == 'PrecheckBBUscs') {

        eModal.iframe('calibrationqualitychecklistbbuscs.php?elsn=' + snparam + '&elso=' + soparam + '&elciu=' +
            sotextoamostrar, 'BBU Integration Checklist');

    }

    ////////////////////////////////////////////////////////////////////////////////////////
    if (desdedonde == 'Precheckultest') {

        eModal.iframe('electricstrengthchecklist.php?elsn=' + snparam + '&elso=' + soparam + '&elciu=' +
            sotextoamostrar, 'Quality UlTest');

    }

    if (desdedonde == 'Precheckfinalcheck') {

        eModal.iframe('surveyfinalcheck.php?elsn=' + snparam + '&elso=' + soparam + '&elciu=' + sotextoamostrar,
            'Final Inspection');

    }

    //reportburnin
    if (desdedonde == 'reportburnin') {

        //eModal.iframe('report_burnin.php?hidmenu=Y&idr='+idruninfoparam,'Report Burning');
        eModal.iframe('burningtestreport.php?hidmenu=Y&sn=' + snparam + '&idruninfo=' + idruninfoparam,
            'Report Burning');

    }

    if (desdedonde == 'orderinfoupgrade') {
        //// show_info(desdedonde,snparam, soparam, sotextoamostrar, idruninfoparam, idparamafterburning)
        //eModal.iframe('report_burnin.php?hidmenu=Y&idr='+idruninfoparam,'Report Burning');
        eModal.iframe('show_upgrade_orderinfo.php?hidmenu=Y&sn=' + snparam + '&soparam=' + soparam +
            '&sotextoamostrar=' + sotextoamostrar, 'Upgrade Info');

    }
    /////asingsnwotoso
    if (desdedonde == 'asingsnwotoso') {

        eModal.iframe('show_tracking_assignsn_wotoso.php?hidmenu=Y&sn=' + snparam + '&soparam=' + soparam +
            '&sotextoamostrar=' + sotextoamostrar, 'Assing SN ');
        //  show_tracking_assignsn_wotososap.php
        eModal.iframe('show_tracking_assignsn_wotososap.php?hidmenu=Y&sn=' + snparam + '&soparam=' + soparam +
            '&sotextoamostrar=' + sotextoamostrar, 'Assing SN ');

    }
    if (desdedonde == 'asingsnsotowo') {
        //// show_info(desdedonde,snparam, soparam, sotextoamostrar, idruninfoparam, idparamafterburning)
        //eModal.iframe('report_burnin.php?hidmenu=Y&idr='+idruninfoparam,'Report Burning');
        eModal.iframe('show_tracking_assignsn_sotowo.php?idso=' + soparam, 'Assing SN From SO ');

    }





    //   $("#artSO").CardWidget('collapse');

}

function Assign_sn(idorders_a_setear, elsoamostrar) {

    eModal.iframe('show_tracking_assignsn.php?idso=' + idorders_a_setear + '&elnomso=' + elsoamostrar,
        'Assign SN to SO:' + elsoamostrar);

    ///show_tracking_assignsn.php

}

function Call_printlabel(vpara_ciu, vparam_sn, vparamidorders) {
    var ipservidorapache = '<?php echo $ipservidorapache; ?>';
    eModal.iframe('https://' + ipservidorapache + '/labelprintermultisn.php?vciu=' + vpara_ciu + '&vsn=' + vparam_sn +
        '&vidord=' + vparamidorders, 'Label printing');
    $('.embed-responsive-item').height(380);
    //	console.log('si');


    setTimeout(function() {
        $('.embed-responsive-item').height(620);
    }, 300);


}

function Call_printlabel_upgrade(vpara_ciu, vparam_sn, vparamidorders) {
    var ipservidorapache = '<?php echo $ipservidorapache; ?>';
    eModal.iframe('https://' + ipservidorapache + '/labelprintermultisn.php?isup=Y&vciu=' + vpara_ciu + '&vsn=' +
        vparam_sn + '&vidord=' + vparamidorders, 'Label printing');
    $('.embed-responsive-item').height(380);
    //	console.log('si');


    setTimeout(function() {
        $('.embed-responsive-item').height(620);
    }, 300);


}

function savechristian(paramsndewo, numeroso) {
    alert('aaaaa');
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
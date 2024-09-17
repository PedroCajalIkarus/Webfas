<!DOCTYPE html>
<?php 

// Desactivar toda notificaci�n de error
error_reporting(0);
// Notificar todos los errores de PHP (ver el registro de cambios)
//error_reporting(E_ALL);
 include("db_conect.php"); 
 
 	session_start();
 
  if(isset($_SESSION["timeout"])){
        // Calcular el tiempo de vida de la sesi�n (TTL = Time To Live)
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


    <link rel="stylesheet" href="cssfiplex.css">
    <style>
    .track {
        position: relative;
        background-color: #ddd;
        height: 7px;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        margin-bottom: 60px;
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
                                <h1>Tracking Orders</h1>
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
           /*       echo "<br>daterangem:".$_REQUEST['daterangem'];
                  echo "<br>txtsearchtxtciu:".$_REQUEST['txtsearchtxtciu'];
                  echo "<br>txtsearchtxtsn:".$_REQUEST['txtsearchtxtsn'];
                  echo "<br>txtsearchtxtrev:".$_REQUEST['txtsearchtxtrev'];
                  echo "<br>txtlistcius:".$_REQUEST['txtlistcius'];*/
                  $wheredaterange="";
                  $wherefiltroporpasos ="";
                  $wherefiltroporpasosfinalinspection ="";
                  $jsondatarange = $_REQUEST['daterangem'];
                  $filtroporpasos = $_REQUEST['filterstep'];
          //        echo "a ver jsondatarange".$jsondatarange;
                  if ( $jsondatarange <>"")
                  {
             //      echo "SIIIIIIIII";
                    $objfecha = json_decode($jsondatarange);
              //      echo "<br>start:marco:".$objfecha->{'start'};
              //      echo "<br>end:marco:".$objfecha->{'end'};
                    echo "<b>    Custom Search: ".  $jsondatarange."</b>";

                    $wheredaterange=" and runinfodb.dateserver  BETWEEN '".$objfecha->{'start'}."' AND '".$objfecha->{'end'}." 23:59:00' ";
                     
                    if ( $filtroporpasos =="finalcheckso")
                      {
                        $wherefiltroporpasos =" and tienefinalchk.idruninfo in (select distinct fas_calibration_result.idruninfo
                        from fas_calibration_result
                        inner join runinfodb
                        on runinfodb.idruninfodb = fas_calibration_result.idruninfo
                        where  runinfodb.idruninfodb <30000000000 
                        and modelciu not in (select modelciu from products where idproduct in (select idproduct from products_attributes where idattribute = 0) ) 
                        and calibrationscript=FALSE and runinfodb.dateserver  BETWEEN '".$objfecha->{'start'}."' AND '".$objfecha->{'end'}." 23:59:00' ) "; 
                      }
                      if ( $filtroporpasos =="finalinspection")
                      {
                        $wherefiltroporpasosfinalinspection =" inner join fas_survey_responses_bysn on  fas_survey_responses_bysn.idsurvey = 3 and  
                        fas_survey_responses_bysn.sn =  fas_calibration_result.unitsn and                        
                        fas_survey_responses_bysn.modelciu = fas_calibration_result.modelciu "; 
                      }
                    
                  }
                  $wherecompo="";
                  if ( $_REQUEST['txtsearchtxtciu'] <>"" || $_REQUEST['txtsearchtxtsn'] <>"" || $_REQUEST['txtsearchtxtrev'] <>"" )
                  {
                    $wherecompo=" inner join orders_sn_components
                    on  orders_sn_components.idorders			=	orders_sn.idorders and
                    orders_sn_components.idproduct				=	orders_sn.idproduct and
                    orders_sn_components.wo_serialnumber		=	orders_sn.wo_serialnumber and
                    (
                    orders_sn_components.components_sn like '%".$_REQUEST['txtsearchtxtsn']."%' or
                      orders_sn_components.components_ciu like '%".$_REQUEST['txtsearchtxtciu']."%' or
                      orders_sn_components.components_rev like '%".$_REQUEST['txtsearchtxtrev']."%' 
                    )	";
                  }
                
                 


                  //////////////////////////// //////////////////////////////

                  $sqlrange="select distinct  1 as orr, orders.idorders  ,
                  orders.processfasserver::int as processfasserver,  orders_sn_SOassociada.idorders as idordersso,  
                 coalesce(productsso.modelciu,'') as tienesomodelciuso, coalesce(orders_sn_SOassociada.so_soft_external,'') as tienesoasociada, 
                 products.modelciu,  orders.quantity,orders_sn.so_soft_external, orders_sn.wo_serialnumber, tienecalibracion.dibsn
                 ,        tienecalibracion.totalpass::int as tienecalibration_totalpass, tienecalibracion.calibrationscript::int as tienecalibration_calibrationscript,
                                           tienefinalchk.totalpass::int as tienefinalchk_totalpass, tienefinalchk.calibrationscript::int as tienefinalchk_calibrationscript,
                                           coalesce(tienecalibracion.idruninfo,0)  as tienecalibracion_idruninfo  , coalesce(tienefinalchk.idruninfo,0)  as tienefinalchk_idruninfo 
                                           from orders
                                           inner join orders_sn 
                                           on orders_sn.idorders = orders.idorders
                                           inner join products
                                           on products.idproduct = orders.idproduct
                                       
                                       left join 
                                       (
                                         
                                           select fas_calibration_result.*
                                           from fas_calibration_result
                                           inner join runinfodb
                                               on runinfodb.idruninfodb = fas_calibration_result.idruninfo  
                                           inner join
                                           (	
                                             select fas_calibration_result.unitsn,  max(dateserver) as maxfecha
                                               from orders
                                               inner join orders_sn 
                                               on orders_sn.idorders = orders.idorders   
                                               inner join fas_calibration_result
                                               on fas_calibration_result.unitsn = orders_sn.wo_serialnumber 
                                               inner join runinfodb
                                               on runinfodb.idruninfodb = fas_calibration_result.idruninfo          
                                               where   modelciu in( select distinct  modelciu from products where  idproduct in (select distinct idproduct from products_attributes where v_boolean= true and idattribute = 0) ) 
                                              ".$wheredaterange."
                                               group by fas_calibration_result.unitsn
                                           )  as  tienecalibracionadentro
                                           on tienecalibracionadentro.unitsn	=	fas_calibration_result.unitsn and
                                             tienecalibracionadentro.maxfecha	=	runinfodb.dateserver 
                                             where modelciu in( select distinct  modelciu from products where  idproduct in (select distinct idproduct from products_attributes where v_boolean= true and idattribute = 0) ) 
                                             and calibrationscript = true 
                                       
                                       
                                       ) as tienecalibracion
                                         on tienecalibracion.unitsn	=	orders_sn.wo_serialnumber 
                                       left join 
                                       (
                                      
                                           select fas_calibration_result.*
                                           from fas_calibration_result
                                           inner join runinfodb
                                               on runinfodb.idruninfodb = fas_calibration_result.idruninfo  
                                           inner join
                                           (	
                                             select fas_calibration_result.unitsn,  max(dateserver) as maxfecha
                                               from orders
                                               inner join orders_sn 
                                               on orders_sn.idorders = orders.idorders   
                                               inner join fas_calibration_result
                                               on fas_calibration_result.unitsn = orders_sn.wo_serialnumber 
                                               inner join runinfodb
                                               on runinfodb.idruninfodb = fas_calibration_result.idruninfo          
                                               where   calibrationscript = false
                                               ".$wheredaterange."
                                               and modelciu in( select distinct  modelciu from products where  idproduct in (select distinct idproduct from products_attributes where v_boolean= true and idattribute = 0) ) 
                                               group by fas_calibration_result.unitsn
                                           )  as  tienefinalchkadentro
                                           on tienefinalchkadentro.unitsn	=	fas_calibration_result.unitsn and                                         
                                             tienefinalchkadentro.maxfecha	=	runinfodb.dateserver
                                             where modelciu in( select distinct  modelciu from products where  idproduct in (select distinct idproduct from products_attributes where v_boolean= true and idattribute = 0) ) 
                                             and calibrationscript = false 

                                           
                                                                                     
                                       
                                       ) as tienefinalchk
                                         on tienefinalchk.unitsn	=	orders_sn.wo_serialnumber 
                                         left join orders_sn as orders_sn_SOassociada
                                         on orders_sn_SOassociada.wo_serialnumber   = orders_sn.wo_serialnumber and
                                         orders_sn_SOassociada.typeregister = 'SO'
                                         left join  products as productsso
                                         on productsso.idproduct = orders_sn_SOassociada.idproduct
                                   
                             where orders.idorders in (select idorders from orders_sn where so_associed in (select so_soft_external from orders_sn where idorders in
                             
                             (
                              select distinct orders_sn.idorders
                              from orders_sn
                              ".$wherecompo."                                 
                              where orders_sn.wo_serialnumber in (
                              select distinct unitsn
                              from fas_tree_measure
                              where idrununfo in(
                              select idruninfodb from runinfodb where runinfodb.dateserver  BETWEEN '".$objfecha->{'start'}."' AND '".$objfecha->{'end'}."' 
                              ) and unitsn like '%FU'
                              ) and so_soft_external like '%WO'
                             )

                             )) 
                                           and orders_sn.idnroserie >0 and  orders.idorders <> orders_sn_SOassociada.idorders   
                                           and orders_sn.typeregister not like '%UP%'    
                                           
                          union
                          select distinct 2,  orders.idorders  ,
                  orders.processfasserver::int as processfasserver,  orders_sn_SOassociada.idorders as idordersso,  
                 coalesce(productsso.modelciu,'') as tienesomodelciuso, coalesce(orders_sn_SOassociada.so_soft_external,'') as tienesoasociada, 
                 products.modelciu,  orders.quantity,orders_sn.so_soft_external, orders_sn.wo_serialnumber, tienecalibracion.dibsn
                 ,        tienecalibracion.totalpass::int as tienecalibration_totalpass, tienecalibracion.calibrationscript::int as tienecalibration_calibrationscript,
                                           tienefinalchk.totalpass::int as tienefinalchk_totalpass, tienefinalchk.calibrationscript::int as tienefinalchk_calibrationscript,
                                           coalesce(tienecalibracion.idruninfo,0)  as tienecalibracion_idruninfo  , coalesce(tienefinalchk.idruninfo,0)  as tienefinalchk_idruninfo 
                                           from orders
                                           inner join orders_sn 
                                           on orders_sn.idorders = orders.idorders
                                           inner join products
                                           on products.idproduct = orders.idproduct
                                       
                                       left join 
                                       (
                                         
                                           select fas_calibration_result.*
                                           from fas_calibration_result
                                           inner join runinfodb
                                               on runinfodb.idruninfodb = fas_calibration_result.idruninfo  
                                           inner join
                                           (	
                                             select fas_calibration_result.unitsn,  max(dateserver) as maxfecha
                                               from orders
                                               inner join orders_sn 
                                               on orders_sn.idorders = orders.idorders   
                                               inner join fas_calibration_result
                                               on fas_calibration_result.unitsn = orders_sn.wo_serialnumber 
                                               inner join runinfodb
                                               on runinfodb.idruninfodb = fas_calibration_result.idruninfo          
                                               where orders.idorders in
                                               
                                               (
                                                select distinct orders_sn.idorders
                                                from orders_sn
                                                ".$wherecompo."     
                                                  
                                                  
                                                
                                                where orders_sn.wo_serialnumber in (
                                                select distinct unitsn
                                                from fas_tree_measure
                                                where idrununfo in(
                                                select idruninfodb from runinfodb where runinfodb.dateserver BETWEEN '".$objfecha->{'start'}."' AND '".$objfecha->{'end'}."' 
                                                ) and unitsn like '%FU'
                                                ) and so_soft_external like '%WO'
                                               )

                                               and calibrationscript = true 
                                               and modelciu in( select distinct  modelciu from products where  idproduct in (select distinct idproduct from products_attributes where v_boolean= true and idattribute = 0) ) 
                                               group by fas_calibration_result.unitsn
                                           )  as  tienecalibracionadentro
                                           on tienecalibracionadentro.unitsn	=	fas_calibration_result.unitsn and
                                             tienecalibracionadentro.maxfecha	=	runinfodb.dateserver 
                                             where modelciu in( select distinct  modelciu from products where  idproduct in (select distinct idproduct from products_attributes where v_boolean= true and idattribute = 0) ) 
                                             and calibrationscript = true 
                                     
                                       
                                       ) as tienecalibracion
                                         on tienecalibracion.unitsn	=	orders_sn.wo_serialnumber 
                                       left join 
                                       (
                                      
                                           select fas_calibration_result.*
                                           from fas_calibration_result
                                           inner join runinfodb
                                               on runinfodb.idruninfodb = fas_calibration_result.idruninfo  
                                           inner join
                                           (	
                                             select fas_calibration_result.unitsn,  max(dateserver) as maxfecha
                                               from orders
                                               inner join orders_sn 
                                               on orders_sn.idorders = orders.idorders   
                                               inner join fas_calibration_result
                                               on fas_calibration_result.unitsn = orders_sn.wo_serialnumber 
                                               inner join runinfodb
                                               on runinfodb.idruninfodb = fas_calibration_result.idruninfo          
                                               where orders.idorders in
                                               
                                               (
                                                select distinct orders_sn.idorders
                                                from orders_sn
                                                ".$wherecompo."     
                                                  
                                                
                                                where orders_sn.wo_serialnumber in (
                                                select distinct unitsn
                                                from fas_tree_measure
                                                where idrununfo in(
                                                select idruninfodb from runinfodb where runinfodb.dateserver  BETWEEN '".$objfecha->{'start'}."' AND '".$objfecha->{'end'}."' 
                                                ) and unitsn like '%FU'
                                                ) and so_soft_external like '%WO'
                                               )
                                               
                                               and calibrationscript = false
                                               and modelciu in( select distinct  modelciu from products where  idproduct in (select distinct idproduct from products_attributes where v_boolean= true and idattribute = 0) ) 
                                               group by fas_calibration_result.unitsn
                                           )  as  tienefinalchkadentro
                                           on tienefinalchkadentro.unitsn	=	fas_calibration_result.unitsn and                                         
                                             tienefinalchkadentro.maxfecha	=	runinfodb.dateserver
                                             where modelciu in( select distinct  modelciu from products where  idproduct in (select distinct idproduct from products_attributes where v_boolean= true and idattribute = 0) ) 
                                             and calibrationscript = false 
                                        
                                         
                                       
                                       ) as tienefinalchk
                                         on tienefinalchk.unitsn	=	orders_sn.wo_serialnumber 
                                         left join orders_sn as orders_sn_SOassociada
                                         on orders_sn_SOassociada.wo_serialnumber   = orders_sn.wo_serialnumber and
                                         orders_sn_SOassociada.typeregister = 'SO'
                                         left join  products as productsso
                                         on productsso.idproduct = orders_sn_SOassociada.idproduct
                                   
                             where orders.idorders in


                             (
                              select distinct orders_sn.idorders
                              from orders_sn
                              ".$wherecompo."     
                                
                              
                              where orders_sn.wo_serialnumber in (
                              select distinct unitsn
                              from fas_tree_measure
                              where idrununfo in(
                              select idruninfodb from runinfodb where runinfodb.dateserver  BETWEEN '".$objfecha->{'start'}."' AND '".$objfecha->{'end'}."' 
                              ) and unitsn like '%FU'
                              ) and so_soft_external like '%WO'
                             )


                                           and orders_sn.idnroserie >0  and orders_sn.so_soft_external not like '%SO%'  and orders_sn.typeregister not like '%UP%'
                                          
                              order by orr desc, wo_serialnumber   
                          ";
                      
                      
                          $sqlrange="TEMP";
 
                       $v_idp = $_REQUEST['isdo'];
                       $filtrar_xsn = substr($_REQUEST['encont'],-2);
                       $snafiltrar =  $_REQUEST['encont'];
                       $typeisdo =  $_REQUEST['typeisdo'];

                      ///////// ACA CAMBIAMOS LA BUSQUEDA SI ES RMA
                      if ( $filtrar_xsn =="RM" ||  $typeisdo =="RM" ||  $typeisdo =="UP" )
                      {
                     //   echo "ENTRO A RMA FILTER";
                            if ( $typeisdo =="UP" )
                            {
                              $sqlbuscarrma= "  
                              select orders_sn.idorders , orders_sn.typeregister   
                              from orders_sn
                              inner join 
                              (
                                select orders_sn.idorders , typeregister,  so_associed  from orders_sn
                                inner join (SELECT  wo_serialnumber as wo_serialnumberrma, so_original as so_originalasoorma  FROM orders_sn os  WHERE (wo_serialnumber  = '". $snafiltrar."' and typeregister = 'UP') ) as losrma
                                on     losrma.wo_serialnumberrma     =  orders_sn.wo_serialnumber where typeregister not like '%UP%' and so_soft_external not like '%RM%' and typeregister = 'SO' and wo_serialnumber  = '". $snafiltrar."' 
                              ) as ttt
                              on ttt.so_associed   = orders_sn.so_soft_external
                              where orders_sn.wo_serialnumber  = '". $snafiltrar."' and orders_sn.typeregister = 'WO'
                              ";
                            }
                            else
                            {
                              $sqlbuscarrma= "       select orders_sn.idorders , typeregister   from orders_sn
                              inner join (SELECT  wo_serialnumber as wo_serialnumberrma, so_original as so_originalasoorma  FROM orders_sn os  WHERE (wo_serialnumber  = '". $snafiltrar."' and so_soft_external  like '%RM%') ) as losrma
                              on     losrma.wo_serialnumberrma     =  orders_sn.wo_serialnumber and so_soft_external not like '%RM%' typeregister not like '%UP%' and ";
                            }
                           //   echo  $sqlbuscarrma;
                              $sqlrma = $connect->prepare($sqlbuscarrma);
                           
                              $sqlrma->execute();
                              
                              foreach ($sqlrma as $rowrma) 
                              {
                                $v_idp =$rowrma['idorders'];
                                if ( $typeisdo =="UP")
                                {
                                  $filtrar_xsn =$rowrma['typeregister'];
                                  $v_idp  =$rowrma['idorders'];
                                }
                                else
                                {
                                  $filtrar_xsn =$rowrma['typeregister'];
                                }
                                
                                $sumaelwherewo="  and orders_sn.wo_serialnumber = '".$snafiltrar."'   and  products.modelciu not like '%LIC%' ";

                              }
                              ////Buscamos el nuevo ID.. 
                             
                          //    echo "rmanuevoid".$v_idp."----". $filtrar_xsn;
                              
                      }   

                       if (  $filtrar_xsn =="FU")
                       {
                      
   
                      
                         
                        $sqlbusco ="select distinct  1 as orr, orders.idorders  ,
                             orders.processfasserver::int as processfasserver,  orders_sn_SOassociada.idorders as idordersso,  
                            coalesce(productsso.modelciu,'') as tienesomodelciuso, coalesce(orders_sn_SOassociada.so_soft_external,'') as tienesoasociada, 
                            products.modelciu,  orders.quantity,orders_sn.so_soft_external, orders_sn.wo_serialnumber, tienecalibracion.dibsn
                            ,        tienecalibracion.totalpass::int as tienecalibration_totalpass, tienecalibracion.calibrationscript::int as tienecalibration_calibrationscript,
                                                      tienefinalchk.totalpass::int as tienefinalchk_totalpass, tienefinalchk.calibrationscript::int as tienefinalchk_calibrationscript,
                                                      coalesce(tienecalibracion.idruninfo,0)  as tienecalibracion_idruninfo  , coalesce(tienefinalchk.idruninfo,0)  as tienefinalchk_idruninfo 
                                                      from orders
                                                      inner join orders_sn 
                                                      on orders_sn.idorders = orders.idorders
                                                      inner join products
                                                      on products.idproduct = orders.idproduct
                                                   
                                                  left join 
                                                  (
                                                   
                                                      select fas_calibration_result.*
                                                      from fas_calibration_result
                                                      inner join runinfodb
                                                          on runinfodb.idruninfodb = fas_calibration_result.idruninfo  
                                                      inner join
                                                      (	
                                                        select fas_calibration_result.unitsn,  max(dateserver) as maxfecha
                                                          from orders
                                                          inner join orders_sn 
                                                          on orders_sn.idorders = orders.idorders   
                                                          inner join fas_calibration_result
                                                          on fas_calibration_result.unitsn = orders_sn.wo_serialnumber 
                                                          inner join runinfodb
                                                          on runinfodb.idruninfodb = fas_calibration_result.idruninfo          
                                                          where orders.idorders in (select idorders from orders_sn where  so_associed in (select so_soft_external from orders_sn where idorders = ".$v_idp."))  and calibrationscript = true 
                                                          and modelciu in( select distinct  modelciu from products where  idproduct in (select distinct idproduct from products_attributes where v_boolean= true and idattribute = 0) ) 
                                                          group by fas_calibration_result.unitsn
                                                      )  as  tienecalibracionadentro
                                                      on tienecalibracionadentro.unitsn	=	fas_calibration_result.unitsn and
                                                        tienecalibracionadentro.maxfecha	=	runinfodb.dateserver 
                                                        where modelciu in( select distinct  modelciu from products where  idproduct in (select distinct idproduct from products_attributes where v_boolean= true and idattribute = 0) ) 
                                                        and calibrationscript = true 
                                                   
                                                  
                                                  ) as tienecalibracion
                                                    on tienecalibracion.unitsn	=	orders_sn.wo_serialnumber 
                                                  left join 
                                                  (
                                                    
                                                      select fas_calibration_result.*
                                                      from fas_calibration_result
                                                      inner join runinfodb
                                                          on runinfodb.idruninfodb = fas_calibration_result.idruninfo  
                                                      inner join
                                                      (	
                                                        select fas_calibration_result.unitsn,  max(dateserver) as maxfecha
                                                          from orders
                                                          inner join orders_sn 
                                                          on orders_sn.idorders = orders.idorders   
                                                          inner join fas_calibration_result
                                                          on fas_calibration_result.unitsn = orders_sn.wo_serialnumber 
                                                          inner join runinfodb
                                                          on runinfodb.idruninfodb = fas_calibration_result.idruninfo          
                                                          where orders.idorders in (select idorders from orders_sn where so_associed in (select so_soft_external from orders_sn where idorders = ".$v_idp."))
                                                           and calibrationscript = false
                                                          and modelciu in( select distinct  modelciu from products where  idproduct in (select distinct idproduct from products_attributes where v_boolean= true and idattribute = 0) ) 
                                                          group by fas_calibration_result.unitsn
                                                      )  as  tienefinalchkadentro
                                                      on tienefinalchkadentro.unitsn	=	fas_calibration_result.unitsn and                                         
                                                        tienefinalchkadentro.maxfecha	=	runinfodb.dateserver
                                                        where modelciu in( select distinct  modelciu from products where  idproduct in (select distinct idproduct from products_attributes where v_boolean= true and idattribute = 0) ) 
                                                        and calibrationscript = false 
   
                                                       
                                                  
                                                  ) as tienefinalchk
                                                    on tienefinalchk.unitsn	=	orders_sn.wo_serialnumber 
                                                    left join orders_sn as orders_sn_SOassociada
                                                    on orders_sn_SOassociada.wo_serialnumber   = orders_sn.wo_serialnumber and
                                                    orders_sn_SOassociada.typeregister = 'SO'
                                                    left join  products as productsso
                                                    on productsso.idproduct = orders_sn_SOassociada.idproduct
                                              
                                        where orders.idorders in (select idorders  
                                                                    from orders_sn 
                                                                    where so_soft_external in (
                                                                      select  so_associed  from orders_sn where idorders = ".$v_idp."
                                                                    ) and typeregister = 'WO'
                                                                  ) 
                                         
                                                      and orders_sn.idnroserie >0 and  orders.idorders <> orders_sn_SOassociada.idorders and
                                                      orders_sn_SOassociada.so_soft_external not like '%RM%' 
                                                      and  products.modelciu not like '%LIC%'    and orders_sn.wo_serialnumber = '".$snafiltrar."'
                                     union
                                     select distinct 2,  orders.idorders  ,
                             orders.processfasserver::int as processfasserver,  orders_sn_SOassociada.idorders as idordersso,  
                            coalesce(productsso.modelciu,'') as tienesomodelciuso, coalesce(orders_sn_SOassociada.so_soft_external,'') as tienesoasociada, 
                            products.modelciu,  orders.quantity,orders_sn.so_soft_external, orders_sn.wo_serialnumber, tienecalibracion.dibsn
                            ,        tienecalibracion.totalpass::int as tienecalibration_totalpass, tienecalibracion.calibrationscript::int as tienecalibration_calibrationscript,
                                                      tienefinalchk.totalpass::int as tienefinalchk_totalpass, tienefinalchk.calibrationscript::int as tienefinalchk_calibrationscript,
                                                      coalesce(tienecalibracion.idruninfo,0)  as tienecalibracion_idruninfo  , coalesce(tienefinalchk.idruninfo,0)  as tienefinalchk_idruninfo 
                                                      from orders
                                                      inner join orders_sn 
                                                      on orders_sn.idorders = orders.idorders
                                                      inner join products
                                                      on products.idproduct = orders.idproduct
                                                   
                                                  left join 
                                                  (
                                                    
                                                      select fas_calibration_result.*
                                                      from fas_calibration_result
                                                      inner join runinfodb
                                                          on runinfodb.idruninfodb = fas_calibration_result.idruninfo  
                                                      inner join
                                                      (	
                                                        select fas_calibration_result.unitsn,  max(dateserver) as maxfecha
                                                          from orders
                                                          inner join orders_sn 
                                                          on orders_sn.idorders = orders.idorders   
                                                          inner join fas_calibration_result
                                                          on fas_calibration_result.unitsn = orders_sn.wo_serialnumber 
                                                          inner join runinfodb
                                                          on runinfodb.idruninfodb = fas_calibration_result.idruninfo          
                                                          where orders.idorders = ".$v_idp." and calibrationscript = true 
                                                          and modelciu in( select distinct  modelciu from products where  idproduct in (select distinct idproduct from products_attributes where v_boolean= true and idattribute = 0) ) 
                                                          group by fas_calibration_result.unitsn
                                                      )  as  tienecalibracionadentro
                                                      on tienecalibracionadentro.unitsn	=	fas_calibration_result.unitsn and
                                                        tienecalibracionadentro.maxfecha	=	runinfodb.dateserver 
                                                        where modelciu in( select distinct  modelciu from products where  idproduct in (select distinct idproduct from products_attributes where v_boolean= true and idattribute = 0) ) 
                                                        and calibrationscript = true 
                                              
                                                  
                                                  ) as tienecalibracion
                                                    on tienecalibracion.unitsn	=	orders_sn.wo_serialnumber 
                                                  left join 
                                                  (
                                                  
                                                      select fas_calibration_result.*
                                                      from fas_calibration_result
                                                      inner join runinfodb
                                                          on runinfodb.idruninfodb = fas_calibration_result.idruninfo  
                                                      inner join
                                                      (	
                                                        select fas_calibration_result.unitsn,  max(dateserver) as maxfecha
                                                          from orders
                                                          inner join orders_sn 
                                                          on orders_sn.idorders = orders.idorders   
                                                          inner join fas_calibration_result
                                                          on fas_calibration_result.unitsn = orders_sn.wo_serialnumber 
                                                          inner join runinfodb
                                                          on runinfodb.idruninfodb = fas_calibration_result.idruninfo          
                                                          where orders.idorders = ".$v_idp." and calibrationscript = false
                                                          and modelciu in( select distinct  modelciu from products where  idproduct in (select distinct idproduct from products_attributes where v_boolean= true and idattribute = 0) ) 
                                                          group by fas_calibration_result.unitsn
                                                      )  as  tienefinalchkadentro
                                                      on tienefinalchkadentro.unitsn	=	fas_calibration_result.unitsn and                                         
                                                        tienefinalchkadentro.maxfecha	=	runinfodb.dateserver
                                                        where modelciu in( select distinct  modelciu from products where  idproduct in (select distinct idproduct from products_attributes where v_boolean= true and idattribute = 0) ) 
                                                        and calibrationscript = false 
                                                   
                                             
                                                  
                                                  ) as tienefinalchk
                                                    on tienefinalchk.unitsn	=	orders_sn.wo_serialnumber 
                                                    left join orders_sn as orders_sn_SOassociada
                                                    on orders_sn_SOassociada.wo_serialnumber   = orders_sn.wo_serialnumber and
                                                    orders_sn_SOassociada.typeregister = 'SO'
                                                    left join  products as productsso
                                                    on productsso.idproduct = orders_sn_SOassociada.idproduct
                                              
                                        where orders.idorders = ".$v_idp."    and orders_sn.wo_serialnumber = '".$snafiltrar."'   and  products.modelciu not like '%LIC%'
                                                      and orders_sn.idnroserie >0  and orders_sn.so_soft_external not like '%SO%'  

                                         union

                                         select distinct 3, orders.idorders , orders.processfasserver::int as processfasserver, orders_sn_SOassociada.idorders as idordersso,
                                         coalesce(productsso.modelciu,'') as tienesomodelciuso, coalesce(orders_sn_SOassociada.so_soft_external,'') as tienesoasociada, 
                                         products.modelciu, orders.quantity,orders_sn.so_soft_external, orders_sn.wo_serialnumber, tienecalibracion.dibsn , 
                                         tienecalibracion.totalpass::int as tienecalibration_totalpass, tienecalibracion.calibrationscript::int as tienecalibration_calibrationscript, 
                                         tienefinalchk.totalpass::int as tienefinalchk_totalpass, tienefinalchk.calibrationscript::int as tienefinalchk_calibrationscript, 
                                         coalesce(tienecalibracion.idruninfo,0) as tienecalibracion_idruninfo , coalesce(tienefinalchk.idruninfo,0) as tienefinalchk_idruninfo 
                                         from orders inner join orders_sn on orders_sn.idorders = orders.idorders 
                                         inner join fnt_select_allproducts_maxrev() as products on products.idproduct = orders.idproduct 
                                         and products.idproduct in (select distinct idproduct from  fnt_select_allproducts_maxrev() where iduniquebranchsonprod like '%000100010038%' or iduniquebranchsonprod like '%000100010094%' or iduniquebranchsonprod like '%00010091%' )
                                         left join ( 
                                         
                                          select maxfechaxsn.* , sn as unitsn, fas_outcome_runinfo.idruninfo as calibrationscript  , 0 as totalpass,idruninfo ,'' as dibsn 
                                                                 from fas_outcome_runinfo
                                                                 inner join (
                                                                 select orders_sn.so_soft_external,  v_string as sn,  max(datetime_run) as maxfechaxsn
                                                                 from fas_outcome_runinfo
                                                                 inner join orders_sn
                                                                 on orders_sn.wo_serialnumber = fas_outcome_runinfo.v_string
                                                                 where   idtyperun = 4 and orders_sn.idorders = ".$v_idp."
                                           and idproduct in (select distinct idproduct from  fnt_select_allproducts_maxrev() where iduniquebranchsonprod like '%000100010038%' or iduniquebranchsonprod like '%000100010094%' or iduniquebranchsonprod like '%00010091%' )
                                           group by orders_sn.so_soft_external,  v_string
                                                                 ) as maxfechaxsn
                                                                 on  maxfechaxsn.sn = fas_outcome_runinfo.v_string and
                                                                 maxfechaxsn.maxfechaxsn = fas_outcome_runinfo.datetime_run
                                                                 where   idtyperun = 12  /*idtyperun= 12= IdScriptType*/
                                                                 and v_integer = 1  /*  DigitalUnit */
                                                         
                                                        ) as tienecalibracion on tienecalibracion.unitsn = orders_sn.wo_serialnumber 
                                                        left join ( 
                                                          
                                      
                                         select maxfechaxsn.* , sn as unitsn, fas_outcome_runinfo.idruninfo as calibrationscript  , 0 as totalpass,idruninfo 
                                                                 from fas_outcome_runinfo
                                                                 inner join (
                                                                 select orders_sn.so_soft_external,  v_string as sn,  max(datetime_run) as maxfechaxsn
                                                                 from fas_outcome_runinfo
                                                                 inner join orders_sn
                                                                 on orders_sn.wo_serialnumber = fas_outcome_runinfo.v_string
                                                                 where   idtyperun = 4 and orders_sn.idorders = ".$v_idp."
                                           and idproduct in (select distinct idproduct from fnt_select_allproducts_maxrev() where iduniquebranchsonprod like '%000100010038%' or iduniquebranchsonprod like '%000100010094%' or iduniquebranchsonprod like '%00010091%' )
                                           group by orders_sn.so_soft_external,  v_string
                                                                 ) as maxfechaxsn
                                                                 on  maxfechaxsn.sn = fas_outcome_runinfo.v_string and
                                                                 maxfechaxsn.maxfechaxsn = fas_outcome_runinfo.datetime_run
                                                                 where   idtyperun = 12  /*idtyperun= 12= IdScriptType*/
                                                                 and v_integer = 2  /*  DigitalUnit */
                                      
                                      
                                                        ) as tienefinalchk on tienefinalchk.unitsn = orders_sn.wo_serialnumber
                                         left join orders_sn as orders_sn_SOassociada on orders_sn_SOassociada.wo_serialnumber = orders_sn.wo_serialnumber 
                                         
                                         left join products as productsso on productsso.idproduct = orders_sn_SOassociada.idproduct 
                                         where orders.idorders = ".$v_idp."    and orders_sn.wo_serialnumber = '".$snafiltrar."'  and orders_sn.idnroserie >0 and 
                                         orders_sn.so_soft_external like '%SO%'    and  products.modelciu not like '%LIC%'
                                        

                                         union 
                                         select distinct  44 as orr, orders.idorders  ,
                                         orders.processfasserver::int as processfasserver,  0 as idordersso,  
                                         coalesce(products.modelciu,'') as tienesomodelciuso, so_soft_external as tienesoasociada, 
                                        products.modelciu,  orders.quantity,orders_sn.so_soft_external, orders_sn.wo_serialnumber, '' as dibsn
                                        ,       0 as tienecalibration_totalpass, 0 as tienecalibration_calibrationscript,
                                                                0 as tienefinalchk_totalpass,0 as tienefinalchk_calibrationscript,
                                                                 0  as tienecalibracion_idruninfo  ,0  as tienefinalchk_idruninfo 

                                         from orders inner join orders_sn on orders_sn.idorders = orders.idorders 
                                         inner join products on products.idproduct = orders.idproduct 
                                         and products.idproduct in (select distinct idproduct from fnt_select_allproducts_maxrev() where iduniquebranchsonprod like '%001000010094%' or  iduniquebranchsonprod like '%00020007%'  )
                                      
                                 
                                         where orders.idorders = ".$v_idp."  and orders_sn.idnroserie >0 and 
                                         orders_sn.so_soft_external  like '%SO%'  
										                      and  orders_sn.typeregister not like '%UP%' 
                                         and  products.modelciu not like '%LIC%'
                        
                                         order by orr desc, wo_serialnumber
                                     ";
                                          ///// and  orders.idorders <> orders_sn_SOassociada.idorders
                                   
   
                       }
                       if (  $filtrar_xsn =="WO")
                       {
                        $sqlbusco ="select distinct  orders.idorders  ,
                             orders.processfasserver::int as processfasserver,  orders_sn_SOassociada.idorders as idordersso,  
                            coalesce(productsso.modelciu,'') as tienesomodelciuso, coalesce(orders_sn_SOassociada.so_soft_external,'') as tienesoasociada, 
                            products.modelciu,  orders.quantity,orders_sn.so_soft_external, orders_sn.wo_serialnumber, tienecalibracion.dibsn
                            ,        tienecalibracion.totalpass::int as tienecalibration_totalpass, tienecalibracion.calibrationscript::int as tienecalibration_calibrationscript,
                                                      tienefinalchk.totalpass::int as tienefinalchk_totalpass, tienefinalchk.calibrationscript::int as tienefinalchk_calibrationscript,
                                                      coalesce(tienecalibracion.idruninfo,0)  as tienecalibracion_idruninfo  , coalesce(tienefinalchk.idruninfo,0)  as tienefinalchk_idruninfo 
                                                      from orders
                                                      inner join orders_sn 
                                                      on orders_sn.idorders = orders.idorders
                                                      inner join products
                                                      on products.idproduct = orders.idproduct
                                                   
                                                  left join 
                                                  (
                                                    ---------------------sub select de tiene calibracion
                                                      select fas_calibration_result.*
                                                      from fas_calibration_result
                                                      inner join runinfodb
                                                          on runinfodb.idruninfodb = fas_calibration_result.idruninfo  
                                                      inner join
                                                      (	
                                                        select fas_calibration_result.unitsn,  max(dateserver) as maxfecha
                                                          from orders
                                                          inner join orders_sn 
                                                          on orders_sn.idorders = orders.idorders   
                                                          inner join fas_calibration_result
                                                          on fas_calibration_result.unitsn = orders_sn.wo_serialnumber 
                                                          inner join runinfodb
                                                          on runinfodb.idruninfodb = fas_calibration_result.idruninfo          
                                                          where orders.idorders = ".$v_idp." and calibrationscript = true 
                                                          and modelciu in( select distinct  modelciu from products where  idproduct in (select distinct idproduct from products_attributes where v_boolean= true and idattribute = 0) ) 
                                                          group by fas_calibration_result.unitsn
                                                      )  as  tienecalibracionadentro
                                                      on tienecalibracionadentro.unitsn	=	fas_calibration_result.unitsn and
                                                        tienecalibracionadentro.maxfecha	=	runinfodb.dateserver 
                                                        where modelciu in( select distinct  modelciu from products where  idproduct in (select distinct idproduct from products_attributes where v_boolean= true and idattribute = 0)) 
                                                        and calibrationscript = true 
                                                    --------------------------------------------
                                                  
                                                  ) as tienecalibracion
                                                    on tienecalibracion.unitsn	=	orders_sn.wo_serialnumber 
                                                  left join 
                                                  (
                                                    ---------------------sub select de tiene finalcheck
                                                      select fas_calibration_result.*
                                                      from fas_calibration_result
                                                      inner join runinfodb
                                                          on runinfodb.idruninfodb = fas_calibration_result.idruninfo  
                                                      inner join
                                                      (	
                                                        select fas_calibration_result.unitsn,  max(dateserver) as maxfecha
                                                          from orders
                                                          inner join orders_sn 
                                                          on orders_sn.idorders = orders.idorders   
                                                          inner join fas_calibration_result
                                                          on fas_calibration_result.unitsn = orders_sn.wo_serialnumber 
                                                          inner join runinfodb
                                                          on runinfodb.idruninfodb = fas_calibration_result.idruninfo          
                                                          where orders.idorders = ".$v_idp." and calibrationscript = false 
                                                          and modelciu in( select distinct  modelciu from products where  idproduct in (select distinct idproduct from products_attributes where v_boolean= true and idattribute = 0)) 
                                                          group by fas_calibration_result.unitsn
                                                      )  as  tienefinalchkadentro
                                                      on tienefinalchkadentro.unitsn	=	fas_calibration_result.unitsn and                                         
                                                        tienefinalchkadentro.maxfecha	=	runinfodb.dateserver
                                                        where modelciu in( select distinct  modelciu from products where  idproduct in (select distinct idproduct from products_attributes where v_boolean= true and idattribute = 0) ) 
                                                        and calibrationscript = false 
                                                    -------------------------------------------- fin finalcheck
                                                  
                                                  ) as tienefinalchk
                                                    on tienefinalchk.unitsn	=	orders_sn.wo_serialnumber 
                                                    left join orders_sn as orders_sn_SOassociada
                                                    on orders_sn_SOassociada.wo_serialnumber   = orders_sn.wo_serialnumber and
                                                    orders_sn_SOassociada.typeregister = 'SO'
                                                    left join  products as productsso
                                                    on productsso.idproduct = orders_sn_SOassociada.idproduct
                                              
                                        where orders.idorders = ".$v_idp.$sumaelwherewo." and (orders_sn_SOassociada.so_soft_external not like '%RM' or orders_sn_SOassociada.so_soft_external is null ) 
                                                      and orders_sn.idnroserie >0 
                                         order by orders_sn.wo_serialnumber ";
                       }
                       if (  $filtrar_xsn =="SO" || $filtrar_xsn =="RM"  )
                       {
                        $sqlbusco ="select distinct 1 as orr,  orders.idorders  ,
                             orders.processfasserver::int as processfasserver,  orders_sn_SOassociada.idorders as idordersso,  
                            coalesce(productsso.modelciu,'') as tienesomodelciuso, coalesce(orders_sn_SOassociada.so_soft_external,'') as tienesoasociada, 
                            products.modelciu,  orders.quantity,orders_sn.so_soft_external, orders_sn.wo_serialnumber, tienecalibracion.dibsn
                            ,        tienecalibracion.totalpass::int as tienecalibration_totalpass, tienecalibracion.calibrationscript::int as tienecalibration_calibrationscript,
                                                      tienefinalchk.totalpass::int as tienefinalchk_totalpass, tienefinalchk.calibrationscript::int as tienefinalchk_calibrationscript,
                                                      coalesce(tienecalibracion.idruninfo,0)  as tienecalibracion_idruninfo  , coalesce(tienefinalchk.idruninfo,0)  as tienefinalchk_idruninfo 
                                                      from orders
                                                      inner join orders_sn 
                                                      on orders_sn.idorders = orders.idorders
                                                      inner join products
                                                      on products.idproduct = orders.idproduct
                                                   
                                                  left join 
                                                  (
                                                    ---------------------sub select de tiene calibracion
                                                      select fas_calibration_result.*
                                                      from fas_calibration_result
                                                      inner join runinfodb
                                                          on runinfodb.idruninfodb = fas_calibration_result.idruninfo  
                                                      inner join
                                                      (	
                                                        select fas_calibration_result.unitsn,  max(dateserver) as maxfecha
                                                          from orders
                                                          inner join orders_sn 
                                                          on orders_sn.idorders = orders.idorders   
                                                          inner join fas_calibration_result
                                                          on fas_calibration_result.unitsn = orders_sn.wo_serialnumber 
                                                          inner join runinfodb
                                                          on runinfodb.idruninfodb = fas_calibration_result.idruninfo          
                                                          where orders.idorders in (select idorders from orders_sn where so_associed in (select so_soft_external from orders_sn where idorders = ".$v_idp."))  and calibrationscript = true 
                                                          and modelciu in( select distinct  modelciu from products where  idproduct in (select distinct idproduct from products_attributes where v_boolean= true and idattribute = 0) ) 
                                                          group by fas_calibration_result.unitsn
                                                      )  as  tienecalibracionadentro
                                                      on tienecalibracionadentro.unitsn	=	fas_calibration_result.unitsn and
                                                        tienecalibracionadentro.maxfecha	=	runinfodb.dateserver 
                                                        where modelciu in( select distinct  modelciu from products where  idproduct in (select distinct idproduct from products_attributes where v_boolean= true and idattribute = 0) ) 
                                                        and calibrationscript = true 
                                                    --------------------------------------------
                                                  
                                                  ) as tienecalibracion
                                                    on tienecalibracion.unitsn	=	orders_sn.wo_serialnumber 
                                                  left join 
                                                  (
                                                    ---------------------sub select de tiene finalcheck
                                                      select fas_calibration_result.*
                                                      from fas_calibration_result
                                                      inner join runinfodb
                                                          on runinfodb.idruninfodb = fas_calibration_result.idruninfo  
                                                      inner join
                                                      (	
                                                        select fas_calibration_result.unitsn,  max(dateserver) as maxfecha
                                                          from orders
                                                          inner join orders_sn 
                                                          on orders_sn.idorders = orders.idorders   
                                                          inner join fas_calibration_result
                                                          on fas_calibration_result.unitsn = orders_sn.wo_serialnumber 
                                                          inner join runinfodb
                                                          on runinfodb.idruninfodb = fas_calibration_result.idruninfo          
                                                          where orders.idorders in (select idorders from orders_sn where so_associed in (select so_soft_external from orders_sn where idorders = ".$v_idp.")) and calibrationscript = false
                                                          and modelciu in( select distinct  modelciu from products where  idproduct in (select distinct idproduct from products_attributes where v_boolean= true and idattribute = 0) ) 
                                                          group by fas_calibration_result.unitsn
                                                      )  as  tienefinalchkadentro
                                                      on tienefinalchkadentro.unitsn	=	fas_calibration_result.unitsn and                                         
                                                        tienefinalchkadentro.maxfecha	=	runinfodb.dateserver
                                                        where modelciu in( select distinct  modelciu from products where  idproduct in (select distinct idproduct from products_attributes where v_boolean= true and idattribute = 0) ) 
                                                        and calibrationscript = false
                                              
                                                    -------------------------------------------- fin finalcheck
                                                  
                                                  ) as tienefinalchk
                                                    on tienefinalchk.unitsn	=	orders_sn.wo_serialnumber 
                                                    inner join orders_sn as orders_sn_SOassociada
                                                    on orders_sn_SOassociada.wo_serialnumber   = orders_sn.wo_serialnumber and
                                                    orders_sn_SOassociada.typeregister = 'SO'
                                                    and orders_sn_SOassociada.idorders = ".$v_idp."
                                                    left join  products as productsso
                                                    on productsso.idproduct = orders_sn_SOassociada.idproduct
                                              
                                        where orders.idorders in (select idorders from orders_sn where so_associed in (select so_soft_external from orders_sn where idorders = ".$v_idp.")) 
                                                      and orders_sn.idnroserie >0  and orders_sn_SOassociada.so_soft_external not  like '%RM'
                                                      and  products.modelciu not like '%LIC%'
                                                      and orders_sn.so_soft_external not  like '%RM'  and  orders_sn.typeregister not like '%UP%' 
                                          
                                         union

                                         select distinct 3, orders.idorders , orders.processfasserver::int as processfasserver, orders_sn_SOassociada.idorders as idordersso,
                                         coalesce(productsso.modelciu,'') as tienesomodelciuso, coalesce(orders_sn_SOassociada.so_soft_external,'') as tienesoasociada, 
                                         products.modelciu, orders.quantity,orders_sn.so_soft_external, orders_sn.wo_serialnumber, tienecalibracion.dibsn , 
                                         tienecalibracion.totalpass::int as tienecalibration_totalpass, tienecalibracion.calibrationscript::int as tienecalibration_calibrationscript, 
                                         tienefinalchk.totalpass::int as tienefinalchk_totalpass, tienefinalchk.calibrationscript::int as tienefinalchk_calibrationscript, 
                                         coalesce(tienecalibracion.idruninfo,0) as tienecalibracion_idruninfo , coalesce(tienefinalchk.idruninfo,0) as tienefinalchk_idruninfo 
                                         from orders inner join orders_sn on orders_sn.idorders = orders.idorders 
                                         inner join products on products.idproduct = orders.idproduct 
                                         and products.idproduct in (select distinct idproduct from fnt_select_allproducts_maxrev() where iduniquebranchsonprod like '%000100010038%'  or iduniquebranchsonprod like '%000100010094%' or iduniquebranchsonprod like '%00010091%'  or iduniquebranchsonprod like '%00010037%')
                                         left join ( 
                                         
                                          select maxfechaxsn.* , sn as unitsn, fas_outcome_runinfo.idruninfo as calibrationscript  , 0 as totalpass,idruninfo ,'' as dibsn 
                                                                 from fas_outcome_runinfo
                                                                 inner join (
                                                                 select orders_sn.so_soft_external,  v_string as sn,  max(datetime_run) as maxfechaxsn
                                                                 from fas_outcome_runinfo
                                                                 inner join orders_sn
                                                                 on orders_sn.wo_serialnumber = fas_outcome_runinfo.v_string
                                                                 where   idtyperun = 4 and orders_sn.idorders = ".$v_idp."
                                           and idproduct in (select distinct idproduct from fnt_select_allproducts_maxrev() where iduniquebranchsonprod like '%000100010038%' or iduniquebranchsonprod like '%000100010094%' or iduniquebranchsonprod like '%00010091%'  or iduniquebranchsonprod like '%00010037%')
                                           group by orders_sn.so_soft_external,  v_string
                                                                 ) as maxfechaxsn
                                                                 on  maxfechaxsn.sn = fas_outcome_runinfo.v_string and
                                                                 maxfechaxsn.maxfechaxsn = fas_outcome_runinfo.datetime_run
                                                                 where   idtyperun = 12  /*idtyperun= 12= IdScriptType*/
                                                                 and v_integer = 1  /*  DigitalUnit */
                                                         
                                                        ) as tienecalibracion on tienecalibracion.unitsn = orders_sn.wo_serialnumber 
                                                        left join ( 
                                                          
                                      
                                         select maxfechaxsn.* , sn as unitsn, fas_outcome_runinfo.idruninfo as calibrationscript  , 0 as totalpass,idruninfo 
                                                                 from fas_outcome_runinfo
                                                                 inner join (
                                                                 select orders_sn.so_soft_external,  v_string as sn,  max(datetime_run) as maxfechaxsn
                                                                 from fas_outcome_runinfo
                                                                 inner join orders_sn
                                                                 on orders_sn.wo_serialnumber = fas_outcome_runinfo.v_string
                                                                 where   idtyperun = 4 and orders_sn.idorders = ".$v_idp."
                                           and idproduct in (select distinct idproduct from fnt_select_allproducts_maxrev() where iduniquebranchsonprod like '%000100010038%' or iduniquebranchsonprod like '%000100010094%' or iduniquebranchsonprod like '%00010091%' )
                                           group by orders_sn.so_soft_external,  v_string
                                                                 ) as maxfechaxsn
                                                                 on  maxfechaxsn.sn = fas_outcome_runinfo.v_string and
                                                                 maxfechaxsn.maxfechaxsn = fas_outcome_runinfo.datetime_run
                                                                 where   idtyperun = 12  /*idtyperun= 12= IdScriptType*/
                                                                 and v_integer = 2  /*  DigitalUnit */
                                      
                                      
                                                        ) as tienefinalchk on tienefinalchk.unitsn = orders_sn.wo_serialnumber
                                         left join orders_sn as orders_sn_SOassociada on orders_sn_SOassociada.wo_serialnumber = orders_sn.wo_serialnumber  
                                         and
                                                    orders_sn_SOassociada.typeregister = 'SO'
                                                   
                                         left join products as productsso on productsso.idproduct = orders_sn_SOassociada.idproduct 
                                         where orders.idorders = ".$v_idp."   and orders_sn.idnroserie >0 and 
                                         orders_sn.so_soft_external not like '%SO%'  and orders_sn_SOassociada.so_soft_external not like '%RM%'  and  orders_sn.typeregister not like '%UP%' 
                                         and  products.modelciu not like '%LIC%'

                                          
                                         union 
                                         select distinct  44 as orr, orders.idorders  ,
                                         orders.processfasserver::int as processfasserver,  0 as idordersso,  
                                         coalesce(products.modelciu,'') as tienesomodelciuso, so_soft_external as tienesoasociada, 
                                        products.modelciu,  orders.quantity,orders_sn.so_soft_external, orders_sn.wo_serialnumber, '' as dibsn
                                        ,       0 as tienecalibration_totalpass, 0 as tienecalibration_calibrationscript,
                                                                0 as tienefinalchk_totalpass,0 as tienefinalchk_calibrationscript,
                                                                 0  as tienecalibracion_idruninfo  ,0  as tienefinalchk_idruninfo 

                                         from orders inner join orders_sn on orders_sn.idorders = orders.idorders 
                                         inner join products on products.idproduct = orders.idproduct 
                                         and products.idproduct in (select distinct idproduct from fnt_select_allproducts_maxrev() where iduniquebranchsonprod like '%001000010094%' union 
                                         select distinct idproduct from fnt_select_allproducts_maxrev() where iduniquebranchsonprod like '%00010038%' union 
                                         select distinct idproduct from fnt_select_allproducts_maxrev() where iduniquebranchsonprod like '%00020007%'  )                                 
                                         where orders.idorders = ".$v_idp."  and orders_sn.idnroserie >0 and 
                                         orders_sn.so_soft_external  like '%SO%'  
										                      and  orders_sn.typeregister not like '%UP%' 
                                         and  products.modelciu not like '%LIC%'
                        
                                         order by orr desc, wo_serialnumber
                                          ";
                       }
                             
                  //////////////////////////// //////////////////////////////
                  //////////////////////////// //////////////////////////////
                  ?>

                                                    </div>

                                                    <div class="track1">
                                                        <?php

       //    echo  $sqlbusco;
              
                  if ( $jsondatarange <>"" || $sqlbusco <>"" )
                  {
                    if ( $jsondatarange <>"")
                    {
                      $sqllosso = $connect->prepare( $sqlrange);
                    }
                    if (  $sqlbusco <>"" )
                    {    
                    
                      $sqllosso = $connect->prepare( $sqlbusco);
                    }
                    
                      echo  $sqlbusco;
                      $_if_auto_test_box_calibration = "N";
                      $sqllosso->execute();
                      $resultadoslosso = $sqllosso->fetchAll();							
                     
                      foreach ($resultadoslosso as $rowbuscawo) 
                      {
                  //      echo "<br>SO".$rowbuscawo['modelciu'];
                  ?><br><br>
                                                        <div class="track">
                                                            <?php
                              ////// VAMOS con el armado dinamico de pasos
                              $modelcui_mostrarerror =trim($rowbuscawo['modelciu']);
                           $armosqlpasos="select * 
                           from business_tracking_steps
                           inner join tracking_steps
                           on tracking_steps.idtrackingsteps = business_tracking_steps.idtrackingstep
                               where business_tracking_steps.actvie = 'Y' and iduniquebranchprodson in (select distinct iduniquebranchsonprod from   fnt_select_allproducts_maxrev()  where active = 'Y' and  modelciu = '".trim($rowbuscawo['modelciu'])."' ) order by orderlist ";
   // echo "<br>pasos:<br>".$armosqlpasos;
 
                              $sqlpasos = $connect->prepare($armosqlpasos);
                              $eslegacy ="N";
                              $sqlpasos->execute();
                              $resultadospasoss = $sqlpasos->fetchAll();							
                             $tienepasos=0;
                             $steps_so_final_inspection ="N";
                              foreach ($resultadospasoss as $rowpasos) 
                              {
                                $tienepasos=1;
                                $encontroalgoenlos3select = "S";
                                $cant_sn= $rowbuscawo['quantity'];
                                $cant_sn_assign= $cant_sn_assign + 1;
                                $ciutemp=$rowbuscawo['modelciu'];
                               $sotemp=$rowbuscawo['so_soft_external'];
                               $nombre_a_mostrar_en_dvi ='Order Detail :: WO:'.$sotemp." - SN: ".$rowbuscawo['wo_serialnumber'];
                               
                               $nombre_a_mostrar_en_dvi_acept ='Digital Board :: Acceptance :: SN: '.$rowbuscawo['wo_serialnumber'];
                               $nombre_a_mostrar_en_dvi_calib ='Calibration :: SN: '.$rowbuscawo['wo_serialnumber'];
                               $nombre_a_mostrar_en_dvi_finalchk ='Final Check:: SN: '.$rowbuscawo['wo_serialnumber'];
                               $nombre_a_mostrar_en_dvi_sinsn ='Order Detail ::'.$sotemp;
                                $v_idp=$rowbuscawo["idorders"];
                               $activo_paso1_processfasserver ="";
                                  if ($rowbuscawo["processfasserver"] ==1 )
                                  {
                                  $activo_paso1_processfasserver  = "<span class='badge bg-success'>FasClient Processed</span>";
                                  }
                                  else
                                  {
                                  $activo_paso1_processfasserver = "<span class='badge bg-warning'>FasClient Pending </span>";
                                  }

                                          ///////////////// wo_info_step1 //////////////////////////  
                                          if ($rowpasos['stepfunction']=="wo_info_step1")
                                          {
                                            ?>

                                                            <div class="stepazul   active">

                                                                <a href="#"
                                                                    onclick="show_info('orderinfo','<?php echo $rowbuscawo['wo_serialnumber']; ?>','<?php echo $v_idp; ?>','<?php echo $nombre_a_mostrar_en_dvi; ?>',0,0)">

                                                                    <span class="icon"> <i class="fa fa-check"></i>
                                                                    </span>
                                                                    <span class="text text-left">

                                                                        <b> <?php echo "".$rowpasos['nametrackingstepsshow']."<br>"; ?>
                                                                            WO:
                                                                            [<?php echo $rowbuscawo['so_soft_external']; ?>]<br>CIU:
                                                                            [<?php echo $rowbuscawo['modelciu']; ?>]</b>
                                                                        <br><b> SN Generated:
                                                                            [<?php echo $rowbuscawo['wo_serialnumber']; ?>]</b><br><?php echo  $activo_paso1_processfasserver;?>
                                                                </a>
                                                                <span class='text text-left'>
                                                                    <a href="#"
                                                                        onclick="Call_printlabel('<?php echo $rowbuscawo['modelciu']; ?>', '<?php echo $rowbuscawo['wo_serialnumber']; ?>' ,'<?php echo $v_idp; ?>')">&nbsp;
                                                                        <i class="fas fa-print"></i> - Print Label
                                                                        <br><br>
                                                                    </a>
                                                                </span>
                                                                </span>

                                                            </div>
                                                            <?php
                                          }


                                          /////////////////CALCULOS VARIOS ///////////////////////

                                                    $activo_paso2="active";
                                                    $activo_paso2_totalpass ="";
                                                    $activo_paso2_totalpass_temp="";
                                                    if ($rowbuscawo['dibsn']=="")
                                                    {
                                                    $activo_paso2 = "";                
                                
                                                    }
                                                    else
                                                    {
                                
                                                      //////controlamos si la acceptacion Paso o no paso
                                                      $sqacceptl = $connect->prepare("  select 
                                                      fas_calibration_result.totalpass::int as tieneaccept_totalpass, fas_calibration_result.modelciu as modelciudibb,  fas_calibration_result.idruninfo   
                                                    from  fas_calibration_result                         
                                                  inner join runinfodb
                                                  on runinfodb.idruninfodb = fas_calibration_result.idruninfo          
                                                  where unitsn ='".$rowbuscawo['dibsn']."' order by dateserver asc ");
                                
                                             
                                                        $sqacceptl->execute();
                                                        $resultaccept = $sqacceptl->fetchAll();	
                                                        $modelcuidibboard="";	
                                                        $cant_idrunacceptance= 0;
                                              //         echo "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";
                                                        foreach ($resultaccept as $rowaceptt) 
                                                        {
                                                          ///echo "a verrr".$rowaceptt["tieneaccept_totalpass"];
                                                            $activo_paso2_totalpass_temp =$rowaceptt["tieneaccept_totalpass"];
                                                            $modelcuidibboard =$rowaceptt["modelciudibb"];
                                                            $ultruninfoacceptance =$rowaceptt["idruninfo"];
                                                            $cant_idrunacceptance= $cant_idrunacceptance +1;
                                                        }
                                
                                
                                                        if ( $cant_idrunacceptance>0)
                                                        {
                                                      
                                                          if ( $activo_paso2_totalpass_temp ==1)
                                                          {
                                                          $activo_paso2_totalpass  = "<span class='badge bg-success'>Passed [".$cant_idrunacceptance."]</span><br><a href='#' onclick='popuplogdb(".$ultruninfoacceptance.")'  style='color:#f39323;'>View Log <i class='fas fa-eye'></i></a>";
                                                          }
                                                          else
                                                          {
                                                          $activo_paso2_totalpass = "<span class='badge bg-danger'>Not Passed [".$cant_idrunacceptance."]</span><br><a href='#' onclick='popuplogdb(".$ultruninfoacceptance.")'  style='color:#f39323;'>View Log <i class='fas fa-eye'></i></a>";
                                                          }
                                                        
                                                            
                                                        }
                                                      
                                
                                
                                                    }
                                                    $activo_paso3="";
                                                    if ($rowbuscawo['tienecalibracion_idruninfo']>0)
                                                    {
                                                    $activo_paso3 = "active";
                                                    $activo_paso3_totalpass ="";
                                                      if ($rowbuscawo['tienecalibration_totalpass']==1)
                                                      {
                                                        
                                                          $activo_paso3_totalpass = "<span class='badge bg-success'>Passed</span><br><a href='#' onclick='popuplogdb(".$rowbuscawo['tienecalibracion_idruninfo'].")'  style='color:#f39323;'>View Log <i class='fas fa-eye'> </i></a>";
                                                      
                                                      
                                                      
                                                      }
                                                      if ($rowbuscawo['tienecalibration_totalpass']==0)
                                                      {
                                                        
                                                          $activo_paso3_totalpass = "<span class='badge bg-danger'>Not Passed</span><br><a href='#' onclick='popuplogdb(".$rowbuscawo['tienecalibracion_idruninfo'].")'  style='color:#f39323;'>View Log <i class='fas fa-eye'></i></a>";
                                                      
                                                      }
                                                    
                                                    }
                                
                                                    $activo_paso4="";
                                                    if ( $rowbuscawo['tienefinalchk_idruninfo'] >0)
                                                    {
                                                      $activo_paso4 = "active";
                                                      $activo_paso4_totalpass ="";
                                                      if ($rowbuscawo['tienefinalchk_totalpass']==1)
                                                      {
                                                        
                                                          $activo_paso4_totalpass = "<span class='badge bg-success'>Passed</span><br><a href='#' onclick='popuplogdb(".$rowbuscawo['tienefinalchk_idruninfo'].")'  style='color:#f39323;'>View Log <i class='fas fa-eye'></i></a>";
                                                    
                                                      
                                                      
                                                      }
                                                      if ($rowbuscawo['tienefinalchk_totalpass']==0)
                                                      {
                                                      
                                                          $activo_paso4_totalpass = "<span class='badge bg-danger'>Not Passed</span><br><a href='#' onclick='popuplogdb(".$rowbuscawo['tienefinalchk_idruninfo'].")'  style='color:#f39323;'>View Log <i class='fas fa-eye'></i></a>";
                                                      
                                                      
                                                      }
                                                    }

                                                     //////// DAS ENTERPRICE REMOTE NO MOSTRARRR //////
                                                    /////**************************************************** 
                                                  ///Detectamos CIU
                                                  /////**************************************************** 
                                                  /////**************************************************** 
                                                  $ciuisbda="N";
                                                  $ciuisenterprice="N";
                                                  $ciuisremote="N";
                                                  $ciuismaster="N";
                                                  $ciuisdas="N";
                                                  $sqldetect="select fnt_select_detect_bysn_isbda_isdas('".$rowbuscawo['wo_serialnumber']."','WO') ";
                                               
                                                  $datadetect = $connect->query($sqldetect)->fetchAll();
                                                  foreach ($datadetect as $rowdetect) 
                                                              {	
                                                            //	  echo "****.....".$rowdetect[0];
                                                                $resulm = json_decode($rowdetect[0]);
                                                              ///  echo "****".$resulm->{'isdba'};
                                                                if( $resulm->{'isdba'} >0 )
                                                                {
                                                                $ciuisbda="Y";
                                                                }
                                                                if( $resulm->{'isdas'} >0 )
                                                                {
                                                                $ciuisdas="Y";
                                                                }
                                                                if( $resulm->{'isenterprise'} >0 )
                                                                {
                                                                $ciuisenterprice="Y";
                                                                }
                                                                if( $resulm->{'isremote'} >0 )
                                                                {
                                                                $ciuisremote="Y";
                                                                }
                                                                if( $resulm->{'ismaster'} >0 )
                                                                {
                                                                $ciuismaster="Y";
                                                                }


                                                               
                                                              } 
                                                          
                                                          
                                                  /////**************************************************** 								
                                                  //fin detectamos CIU


                                          /////////////////FIN CALCULOS VARIOS //////////////////////
                                          ///////////////// wo_picking //////////////////////////                                         
                                          if ($rowpasos['stepfunction']=="wo_picking")
                                          {
                                            /////************** INICIO PICKING ************************************** 
                                                          ///if temporal pedido x matias
                                                        /// echo "00".$rowbuscawo['modelciu']."00";

                                              /*          if ($rowbuscawo['modelciu']=="DH7S-A" || $rowbuscawo['modelciu']=="DH7S-D"  || $rowbuscawo['modelciu']=="BTTY-100" || $rowbuscawo['modelciu'] =="ANN4-MTHR" || $rowbuscawo['modelciu'] =="ANN3-MTHR" )
                                                        {
                                                        */

                                                        


                                                        $sqldetectchkeopicki="SELECT distinct   orders_sn_components.wo_serialnumber 
                                                        FROM public.orders_sn_components_xml as orders_sn_components 
                                                     
                                                      inner join orders_sn
                                                      on orders_sn.idorders = orders_sn_components.idorders and 
                                                      orders_sn.idproduct = orders_sn_components.idproduct and
                                                      orders_sn.so_soft_external = '".$rowbuscawo['so_soft_external']."'  where orders_sn_components.wo_serialnumber= '".$rowbuscawo['wo_serialnumber']."'";
                                                        
                                                      ///  	echo "test:".$sqldetectchkeopicki;
                                                          $datapicking = $connect->query($sqldetectchkeopicki)->fetchAll();
                                                          $tienepicking=0;
                                                          
                                                          foreach ($datapicking as $rowchequeo) 
                                                          {
                                                            $tienepicking=1;
                                                          }
                                                          ?>
                                                            <?php if ( $tienepicking==1) 
                                                          {
                                                            ?>
                                                            <div class="stepverde  active">
                                                                <?php
                                                          }
                                                          else
                                                          {
                                                          ?>
                                                                <div class="step  ">
                                                                    <?php
                                                          }
                                                          ?>

                                                                    <a href="#"
                                                                        onclick="show_info('picking','<?php echo $rowbuscawo['wo_serialnumber']; ?>','<?php echo $rowbuscawo['so_soft_external']; ?>','<?php echo $rowbuscawo['modelciu']; ?>','Quality Calibration Precheck',0)">
                                                                        <span class="icon"> <i class="fas fa-tasks"></i>
                                                                        </span>
                                                                        <span class="text"> <b>Assy Walkthrough <br>SN
                                                                                [<?php echo $rowbuscawo['wo_serialnumber']; ?>]
                                                                                <br></b></span>


                                                                </div>
                                                                </a>
                                                                <?php
                                                      //    }
                                                          /////**************************************************** 
                                                        /////************** FIN PICKING ************************************** 
                                          }
                                          ///////////////// wo_picking //////////////////////////  
                                          ///////////////// wo_quality_precheck //////////////////////////
                                          if ($rowpasos['stepfunction']=="wo_quality_precheck")
                                          {
                                              /////**************************************************** 
                                              /////**************PRE CHEQUEO************************************** 
                                              //// sumamos un paso aqui prechech  Precheck
                                              $sqldetectchkeo="SELECT   status_sn  FROM public.fas_survey_responses_bysn where  idsurvey = 1 and sn = '".$rowbuscawo['wo_serialnumber']."' and  so = '".$rowbuscawo['so_soft_external']."' and modelciu = '".$rowbuscawo['modelciu']."'
                                              order by datetimecheck desc limit 1 ";

                                              //	echo "test:".$sqldetectchkeo;
                                              $datadetectprecheko = $connect->query($sqldetectchkeo)->fetchAll();
                                              $tieneprecheck=0;

                                              foreach ($datadetectprecheko as $rowchequeo) 
                                              {
                                              $tieneprecheck=1;
                                              }
                                              ?>
                                                                <?php if ( $tieneprecheck==1) 
                                              {
                                              ?>
                                                                <div class="stepverde  active">
                                                                    <?php
                                              }
                                              else
                                              {
                                              ?>
                                                                    <div class="step  ">
                                                                        <?php
                                              }
                                              ?>

                                                                        <a href="#"
                                                                            onclick="show_info('Precheck','<?php echo $rowbuscawo['wo_serialnumber']; ?>','<?php echo $rowbuscawo['so_soft_external']; ?>','<?php echo $rowbuscawo['modelciu']; ?>','Quality Calibration Precheck',0)">
                                                                            <span class="icon"> <i
                                                                                    class="fas fa-tasks"></i> </span>
                                                                            <span class="text"> <b>Quality Precheck
                                                                                    <br>SN
                                                                                    [<?php echo $rowbuscawo['wo_serialnumber']; ?>]
                                                                                    <br></b></span>
                                                                            <?php
                                              $sqldetectchkeo="SELECT   status_sn  FROM public.fas_survey_responses_bysn where idsurvey = 1 and  sn = '".$rowbuscawo['wo_serialnumber']."' and  so = '".$rowbuscawo['so_soft_external']."' and modelciu = '".$rowbuscawo['modelciu']."'
                                              order by datetimecheck desc limit 1 ";

                                             //	echo "test:".$sqldetectchkeo;

                                              $datadetectprecheko = $connect->query($sqldetectchkeo)->fetchAll();
                                              foreach ($datadetectprecheko as $rowchequeo) 
                                              {
                                                  if ($rowchequeo['status_sn']=="PASS")
                                                  {
                                                      echo "    <span class='badge bg-success'>Passed</span><br>";
                                                  }
                                                  else
                                                  {
                                                    echo "    <span class='badge bg-danger'>Fail</span><br>";
                                                  }
                                              }
                                              ?>
                                                                        </a>
                                                                        <?php
                                                  
                                                  
                                                  $sqlmaxhistory = " select * from fas_to_sap_xml where v_sn ='".$rowbuscawo['wo_serialnumber']."' and v_workcenetr = 'PRECHECK' and
                                                  runprocessdate in (
                                            select max(runprocessdate) from fas_to_sap_xml where v_sn ='".$rowbuscawo['wo_serialnumber']."' and v_workcenetr = 'PRECHECK')

                                            ";
                                                //   echo $sqlmaxhistory;
                                                    $datahist = $connect->query($sqlmaxhistory)->fetchAll();	
                                                    foreach ($datahist as $row2hh) 
                                                    {
                                                        //echo $row2hh['v_state']."<br>".$row2hh['v_state_result'];
                                                        if ($row2hh['v_state']==0)
                                                        {
                                                          echo "<span class='badge bg-secondary' title='".$row2hh['v_state_result']."'>SAP::Pending RESORD</span>";
                                                        }
                                                        if ($row2hh['v_state']==1)
                                                        {
                                                          echo "<span class='badge bg-warning' title='".$row2hh['v_state_result']."'>SAP::Run</span>";
                                                        }
                                                        if ($row2hh['v_state']==2)
                                                        {
                                                          echo "<span class='badge bg-warning' title='".$row2hh['v_state_result']."'>SAP::Pending ACK</span>";
                                                        }
                                                        if ($row2hh['v_state']==3)
                                                        {
                                                          echo "<span class='badge bg-danger' title='".$row2hh['v_state_result']."'>SAP::Error </span>";
                                                        }
                                                        if ($row2hh['v_state']==4)
                                                        {
                                                            echo "<span class='badge bg-info' title='".$row2hh['v_state_result']."'>SAP::OK ACK</span>";
                                                        }
                                                        if ($row2hh['v_state']==5)
                                                        {
                                                            echo "<span class='badge bg-danger' title='".$row2hh['v_state_result']."'>SAP::Error ACK</span>";
                                                        }
                                                        /// echo "<br>".$row2hh['v_state_result'];
                                                    }  
                                                  ?>


                                                                    </div>
                                                                    </a>
                                                                    <?php
                                              /////**************************************************** 
                                          }

                                          ///////////////// wo_quality_precheck //////////////////////////  
                                          ///////////////// wo_quality_ultest //////////////////////////
                                          if ($rowpasos['stepfunction']=="wo_quality_ultest")
                                          {
                                              /////**************2 PRECHEQUEO UL TEST************************************** 
                                              //// sumamos un paso aqui prechech  Precheck
                                              $sqldetectchkeo="SELECT   status_sn  FROM public.fas_survey_responses_bysn where idsurvey = 2 and  sn = '".$rowbuscawo['wo_serialnumber']."' and  so = '".$rowbuscawo['so_soft_external']."' and modelciu = '".$rowbuscawo['modelciu']."'
                                              order by datetimecheck desc limit 1 ";
                                              
                                              //	echo "test:".$sqldetectchkeo;
                                                $datadetectprecheko = $connect->query($sqldetectchkeo)->fetchAll();
                                                $tieneprecheck=0;
                                                
                                                foreach ($datadetectprecheko as $rowchequeo) 
                                                {
                                                  $tieneprecheck=1;
                                                }
                                              ?>
                                                                    <?php if ( $tieneprecheck==1) 
                                              {
                                                  ?>
                                                                    <div class="stepverde  active">
                                                                        <?php
                                              }
                                              else
                                              {
                                                ?>
                                                                        <div class="step  ">
                                                                            <?php
                                              }
                                              ?>

                                                                            <a href="#"
                                                                                onclick="show_info('Precheckultest','<?php echo $rowbuscawo['wo_serialnumber']; ?>','<?php echo $rowbuscawo['so_soft_external']; ?>','<?php echo $rowbuscawo['modelciu']; ?>','Quality Calibration Precheck',0)">
                                                                                <span class="icon"> <i
                                                                                        class="fas fa-tasks"></i>
                                                                                </span>
                                                                                <span class="text"> <b>UL Test <br>SN
                                                                                        [<?php echo $rowbuscawo['wo_serialnumber']; ?>]
                                                                                        <br></b></span>
                                                                                <?php
                                                $sqldetectchkeo="SELECT   status_sn  FROM public.fas_survey_responses_bysn where  idsurvey = 2 and  sn = '".$rowbuscawo['wo_serialnumber']."' and  so = '".$rowbuscawo['so_soft_external']."' and modelciu = '".$rowbuscawo['modelciu']."'
                                                order by datetimecheck desc limit 1 ";
                                                
                                                //	echo "test:".$sqldetectchkeo;
                                                  $datadetectprecheko = $connect->query($sqldetectchkeo)->fetchAll();
                                                  foreach ($datadetectprecheko as $rowchequeo) 
                                                  {
                                                      if ($rowchequeo['status_sn']=="PASS")
                                                      {
                                                        echo "    <span class='badge bg-success'>Passed</span><br>";
                                                      }
                                                      else
                                                      {
                                                        echo "    <span class='badge bg-danger'>Fail</span><br>";
                                                      }
                                                  }
                                              ?>


                                                                        </div>
                                                                        </a>



                                                                        <?php
                                              /////**************************************************** 
                                          }

                                          ///////////////// wo_quality_ultest //////////////////////////  
                                          ///////////////// wo_calibration //////////////////////////
                                          $_if_auto_test_box_calibration = "N";
                                          if ($rowpasos['stepfunction']=="wo_calibration")
                                          {
                                             /////**************************************************** 
                                              
                                             $Sql_ifautotest = $connect->prepare("
                                             
                                             select idruninfodb from runinfodb where idruninfodb = ".$rowbuscawo['tienecalibracion_idruninfo']." and script = 'Auto Calibrate Flex' ");                                 
                                             $Sql_ifautotest->execute();
                                             $result_ifautotest = $Sql_ifautotest->fetchAll();	
                                             foreach ($result_ifautotest as $row_autotest)
                                             {
                                              $_if_auto_test_box_calibration = "Y";
                                             }
                                            /////**************************************************** 
                                  //           echo   "aaaaa".$_if_auto_test_box_calibration;
                                                if ( $rowbuscawo['tienecalibracion_idruninfo'] >0)
                                                {
                                                      if( $_if_auto_test_box_calibration == "N"  )
                                                      {
                                                              if(  $ciuisenterprice=="Y" &&  $ciuisremote=="Y")
                                                              {
                                                                ?>
                                                                        <div class="step <?php echo  $activo_paso3; ?>">
                                                                            <a href="#"
                                                                                onclick="show_info('finalchk','<?php echo $rowbuscawo['wo_serialnumber']; ?>','<?php echo $v_idp; ?>','<?php echo $nombre_a_mostrar_en_dvi_calib; ?>','<?php echo $rowbuscawo['tienecalibracion_idruninfo']; ?>',0)">
                                                                                <span class="icon"> <i
                                                                                        class="fa fa-box"></i> </span>
                                                                                <span class="text"><b>Calibration <br>
                                                                                        <?php echo $activo_paso3_totalpass; ?></span></a></b>
                                                                        </div>
                                                                        <?php
                                                              }
                                                              else
                                                              {
                                                                  //acamarcoenterprisemaster
                                                                  if(  $ciuisenterprice=="Y" &&  $ciuismaster=="Y")
                                                                  {
                                                                    ?>
                                                                        <div class="step <?php echo  $activo_paso3; ?>">
                                                                            <a href="#"
                                                                                onclick="show_info('calibrationentermater','<?php echo $rowbuscawo['wo_serialnumber']; ?>','<?php echo $v_idp; ?>','<?php echo $nombre_a_mostrar_en_dvi_calib; ?>','<?php echo $rowbuscawo['tienecalibracion_idruninfo']; ?>')">
                                                                                <span class="icon"> <i
                                                                                        class="fa fa-box"></i> </span>
                                                                                <span class="text"><b>Calibration <br>
                                                                                        <?php echo $activo_paso3_totalpass; ?></span></a></b>
                                                                        </div>
                                                                        <?php
                                                                  }
                                                                  else
                                                                  {
                                                                  ?>
                                                                        <div class="step <?php echo  $activo_paso3; ?>">
                                                                            <a href="#"
                                                                                onclick="show_info('calibration','<?php echo $rowbuscawo['wo_serialnumber']; ?>','<?php echo $v_idp; ?>','<?php echo $nombre_a_mostrar_en_dvi_calib; ?>','<?php echo $rowbuscawo['tienecalibracion_idruninfo']; ?>')">
                                                                                <span class="icon"> <i
                                                                                        class="fa fa-box"></i> </span>
                                                                                <span class="text"><b>Calibration <br>
                                                                                        <?php echo $activo_paso3_totalpass; ?></span></a></b>
                                                                        </div>
                                                                        <?php
                                                                  }
                                                              }
                                                      }
                                                      else
                                                      {
                                                              if ($ciuisbda =="Y") 
                                                              {
                                                                ?>
                                                                        <div class="step <?php echo  $activo_paso3; ?>">
                                                                            <a href="#"
                                                                                onclick="show_info('calibrationyburchk','<?php echo $rowbuscawo['wo_serialnumber']; ?>','<?php echo $v_idp; ?>','<?php echo $nombre_a_mostrar_en_dvi_calib; ?>','<?php echo $rowbuscawo['tienecalibracion_idruninfo']; ?>')">
                                                                                <span class="icon"> <i
                                                                                        class="fa fa-box"></i> </span>
                                                                                <span class="text"><b>Calibration &
                                                                                        Burnin Check<br>
                                                                                        <?php echo $activo_paso3_totalpass; ?></span></a></b>
                                                                            <br> <a
                                                                                href="calibrationtopdfconimg.php?idsndib=<?php echo  $rowbuscawo['wo_serialnumber']; ?>&amp;iduldl=0&amp;idmb=0"
                                                                                target="_blank"> <i
                                                                                    class='fas fa-file-pdf'></i> - View
                                                                                Report</a>
                                                                            <br>

                                                                        </div>
                                                                        <?php
                                                              }
                                                              else
                                                              {
                                                                ?>
                                                                        <div class="step <?php echo  $activo_paso3; ?>">
                                                                            <a href="#"
                                                                                onclick="show_info('calibration','<?php echo $rowbuscawo['wo_serialnumber']; ?>','<?php echo $v_idp; ?>','<?php echo $nombre_a_mostrar_en_dvi_calib; ?>','<?php echo $rowbuscawo['tienecalibracion_idruninfo']; ?>')">
                                                                                <span class="icon"> <i
                                                                                        class="fa fa-box"></i> </span>
                                                                                <span class="text"><b>Calibration<br>
                                                                                        <?php echo $activo_paso3_totalpass; ?></span></a></b>
                                                                        </div>
                                                                        <?php
                                                              }
                                                        ?>


                                                                        <?php
                                                      }
                                                        
                                                      
                                                      }
                                                      else
                                                      {
                                                        ?>
                                                                        <div class="step "> <span class="icon"> <i
                                                                                    class="fa fa-box"></i> </span> <span
                                                                                class="text">Calibration<br></span>
                                                                        </div>
                                                                        <?php
                                                      }

                                                  
                                                
                                                ///////////////////////////////////////////////////////
                                          }

                                           ///////////////// wo_calibrationent_analogbda //////////////////////////  

                                           if ($rowpasos['stepfunction']=="wo_calibrationent_analogbda")
                                           {
                                              $_tiene_attach_analogbda="";
                                            
                                              $sql_attaanalogbda = $connect->prepare(" select * from orders_fileattach
                                               where idorders = ".$v_idp." and seedtemp like 'ANALOGBDA%' ");   
                                           
                                             
                                               $sql_attaanalogbda->execute();
                                               $result_attaanbda = $sql_attaanalogbda->fetchAll();	
                                               foreach ($result_attaanbda as $rownobdaaa)
                                               {
                                                // echo "aaaaaaaaaaaaaaaaaaaaaa";
                                                 $_tiene_attach_analogbda =  $rownobdaaa['seedtemp'];

                                               }
                                               
                                               if ( $_tiene_attach_analogbda=="")
                                               {
                                                $psswdtkkey = substr( md5(microtime()), 1, 8);
                                            ?>
                                                                        <div class="step ">
                                                                            <a href='#'
                                                                                onclick='attachanalogbda(<?php echo  $v_idp ?>,"ANALOGBDA_<?php echo  $psswdtkkey;?>","<?php echo $rowbuscawo['wo_serialnumber']; ?>")'>

                                                                                <span class="icon">
                                                                                    <i class="fa fa-file"></i> </span>
                                                                                <span class="text">Calibration
                                                                                    <br></span>
                                                                            </a>
                                                                        </div>
                                                                        <?php
                                               }
                                               else
                                               {

                                                ?>
                                                                        <div class="stepverde  active ">
                                                                            <a href='#'
                                                                                onclick='attachanalogbda(<?php echo  $v_idp ?>,"<?php echo $_tiene_attach_analogbda;?>","<?php echo $rowbuscawo['wo_serialnumber']; ?>")'>

                                                                                <span class="icon"> <i
                                                                                        class="fa fa-file"></i> </span>
                                                                                <span class="text">Calibration
                                                                                    AnalogBDA<br></span>
                                                                            </a>
                                                                        </div>
                                                                        <?php
                                               }
                                           }
                                            ///////////////// wo_calibrationent_analogbda //////////////////////////  

                                          ///////////////// wo_calibration //////////////////////////  
                                              ///////////////// wo_calibrationent_remoto_mth //////////////////////////
                                              $_if_auto_test_box_calibrationent_remoto_mth = "N";
                                              $_if_auto_test_box_calibrationent_remoto_mth_totalpass = "";
                                              if ($rowpasos['stepfunction']=="wo_calibrationent_remoto_mth")
                                              {
                                                 /////**************************************************** 
                                                
                                                 $Sql_ifautotest = $connect->prepare(" select * from fas_outcome_integral where reference in ( 
                                                  select reference from fas_outcome_integral where v_string = '". $rowbuscawo['wo_serialnumber']."'  ) and idtype =12 and v_integer = 32
                                                  order by datetimeref asc");   
                                             
                                               
                                                 $Sql_ifautotest->execute();
                                                 $result_ifautotest = $Sql_ifautotest->fetchAll();	
                                                 foreach ($result_ifautotest as $row_autotestm)
                                                 {
                                                  // echo "aaaaaaaaaaaaaaaaaaaaaa";
                                                  $_if_auto_test_box_calibrationent_remoto_mth = "Y";
                                                  $idrun_ent_remoto_mth =  $row_autotestm['reference'];

                                                 }
                                                /////**************************************************** 
                                      //           echo   "aaaaa".$_if_auto_test_box_calibration;
                                                  
                                                       if( $_if_auto_test_box_calibrationent_remoto_mth == "Y")
                                                       {

                                                        // Pregunto si es totalpass true
                                                          
                                                        $Sql_ifautotesttotalpass = $connect->prepare(" select v_boolean::integer as vbooleanint  from fas_outcome_integral where reference in ( 
                                                          select reference from fas_outcome_integral where v_string = '". $rowbuscawo['wo_serialnumber']."'  ) and idtype =13 
                                                          order by datetimeref asc");   
                                                     
                                                       
                                                         $Sql_ifautotesttotalpass->execute();
                                                         $result_ifautotesttotalpass = $Sql_ifautotesttotalpass->fetchAll();	
                                                         $activo_pasoeth_calib="    <span class='badge bg-danger'>Fail</span><br>";
                                                         foreach ($result_ifautotesttotalpass as $row_autotestmtotalpass)
                                                         {
                                                         //  echo "aaaaaaaaaaaaaaaaaaaaaa".$row_autotestmtotalpass['vbooleanint'];
                                                         
                                                            if ($row_autotestmtotalpass['vbooleanint']==1)
                                                            {
                                                              
                                                              $activo_pasoeth_calib = "    <span class='badge bg-success'>Passed</span><br>";
                                                            }
                                                            else
                                                            {
                                                              
                                                              $activo_pasoeth_calib="    <span class='badge bg-danger'>Fail</span><br>";
                                                            }

        
                                                         }

                                                              ?>
                                                                        <div class="step  active"> <a href="#"
                                                                                onclick="show_info('calibrationentremmth','<?php echo $rowbuscawo['wo_serialnumber']; ?>','<?php echo $v_idp; ?>','<?php echo $nombre_a_mostrar_en_dvi_calib; ?>','<?php echo   $idrun_ent_remoto_mth; ?>',0)">
                                                                                <span class="icon"> <i
                                                                                        class="fa fa-box"></i> </span>
                                                                                <span class="text"><b>Calibration <br>
                                                                                        <?php echo $activo_pasoeth_calib; ?></span></a></b>


                                                                            <?php
                                                                
                                                  $sqlmaxhistory = " select * from fas_to_sap_xml where v_sn ='".$rowbuscawo['wo_serialnumber']."' and v_workcenetr = 'ENG-CAL' and
                                                  runprocessdate in (
                                            select max(runprocessdate) from fas_to_sap_xml where v_sn ='".$rowbuscawo['wo_serialnumber']."' and v_workcenetr = 'ENG-CAL')

                                            ";
                                                //   echo $sqlmaxhistory;
                                                    $datahist = $connect->query($sqlmaxhistory)->fetchAll();	
                                                    foreach ($datahist as $row2hh) 
                                                    {
                                                        //echo $row2hh['v_state']."<br>".$row2hh['v_state_result'];
                                                        if ($row2hh['v_state']==0)
                                                        {
                                                          echo "<span class='badge bg-secondary' title='".$row2hh['v_state_result']."'>SAP::Pending RESORD</span>";
                                                        }
                                                        if ($row2hh['v_state']==1)
                                                        {
                                                          echo "<span class='badge bg-warning' title='".$row2hh['v_state_result']."'>SAP::Run</span>";
                                                        }
                                                        if ($row2hh['v_state']==2)
                                                        {
                                                          echo "<span class='badge bg-warning' title='".$row2hh['v_state_result']."'>SAP::Pending ACK</span>";
                                                        }
                                                        if ($row2hh['v_state']==3)
                                                        {
                                                          echo "<span class='badge bg-danger' title='".$row2hh['v_state_result']."'>SAP::Error </span>";
                                                        }
                                                        if ($row2hh['v_state']==4)
                                                        {
                                                            echo "<span class='badge bg-info' title='".$row2hh['v_state_result']."'>SAP::OK ACK</span>";
                                                        }
                                                        if ($row2hh['v_state']==5)
                                                        {
                                                            echo "<span class='badge bg-danger' title='".$row2hh['v_state_result']."'>SAP::Error ACK</span>";
                                                        }
                                                        /// echo "<br>".$row2hh['v_state_result'];
                                                    } 
                                                      ?>
                                                                        </div>
                                                                        <?php
                                                            
                                                         
                                                       }
                                                                          
                                                   
                                                    else
                                                    {
                                                      ?>
                                                                        <div class="step "> <span class="icon"> <i
                                                                                    class="fa fa-box"></i> </span> <span
                                                                                class="text">Calibration<br> </span>
                                                                        </div>
                                                                        <?php
                                                    }
    
                                                      
                                                    
                                                    ///////////////////////////////////////////////////////
                                              }
    
                                              ///////////////// wo_calibrationent_remoto_mth ////////////////////////// 
                                            ///////////////// digital_module_legacy //////////////////////////
                                            $digital_module_legacy = "N";
                                            
                                       
                                            $activo_paso_digital_module_legacy = "";
                                            if ($rowpasos['stepfunction']=="digital_module_legacy")
                                            {
                                                  /////**************************************************** 
                                                  $eslegacy ="Y";
                                                  $Sql_ifautotest = $connect->prepare(" select idruninfo from fas_outcome_runinfo where idruninfo = ".$rowbuscawo['tienecalibracion_idruninfo']." and idtyperun = 12  AND v_integer = 1 ");                                 
                                                  $Sql_ifautotest->execute();
                                                  $result_ifautotest = $Sql_ifautotest->fetchAll();	
                                                  foreach ($result_ifautotest as $row_autotest)
                                                  {
                                                    $digital_module_legacy = "Y";
                                                    $activo_paso_digital_module_legacy = "active";
                                                  }
                                                  /////**************************************************** 
                                        //           echo   "aaaaa".$_if_auto_test_box_calibration;
                                                      if ( $rowbuscawo['tienecalibracion_idruninfo'] >0)
                                                      {
                                                        if( $digital_module_legacy == "N")
                                                        {
                                                            
                                                                ?>
                                                                        <div
                                                                            class="step <?php echo  $activo_paso_digital_module_legacy; ?>">
                                                                            <span class="icon"> <i
                                                                                    class="fa fa-box"></i> </span> <span
                                                                                class="text"><b>Digital Module <br>
                                                                            </span></a></b>
                                                                        </div>
                                                                        <?php
                                                              
                                                        }
                                                        else
                                                        {
                                                          ?>

                                                                        <div
                                                                            class="step <?php echo  $activo_paso_digital_module_legacy; ?>">
                                                                            <span class="icon"> <i
                                                                                    class="fa fa-box"></i> </span> <span
                                                                                class="text"><b>Digital Module <br>
                                                                            </span></a></b>
                                                                            <a href='#'
                                                                                onclick='popuplogdb(<?php echo  $rowbuscawo['tienecalibracion_idruninfo']; ?>)'
                                                                                style='color:#f39323;'> <i
                                                                                    class='fas fa-eye'></i> - View Log
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <br>
                                                                </div>
                                                                <?php
                                                        }
                                                          
                                                      
                                                      }
                                                      else
                                                      {
                                                        ?>
                                                                <div
                                                                    class="step <?php echo  $activo_paso_digital_module_legacy; ?> ">
                                                                    <span class="icon"> <i class="fa fa-box"></i>
                                                                    </span> <span class="text">Digital Module<br></span>
                                                                </div>
                                                                <?php
                                                      }
  
                                                    
                                                  
                                                  ///////////////////////////////////////////////////////
                                            }

  
                                            ///////////////// digital_module_legacy //////////////////////////  
                                                ///////////////// wo_calibration_legacy //////////////////////////
                                             
                                       
                                                $activo_paso_calib_legacy = "  ";
                                                if ($rowpasos['stepfunction']=="wo_calibration_legacy")
                                                {
                                                      /////**************************************************** 
                                                      $eslegacy ="Y";
                                                      $Sql_ifautotest = $connect->prepare(" select idruninfo from fas_outcome_runinfo where idruninfo = ".$rowbuscawo['tienecalibracion_idruninfo']." and idtyperun = 12  AND v_integer = 2 ");                                 
                                                      $Sql_ifautotest->execute();
                                                      $result_ifautotest = $Sql_ifautotest->fetchAll();	
                                                      foreach ($result_ifautotest as $row_autotest)
                                                      {
                                                         
                                                        $activo_paso_calib_legacy = "active";
                                                      }
                                                      /////**************************************************** 
                                            //           echo   "aaaaa".$_if_auto_test_box_calibration;
                                                          if ( $rowbuscawo['tienecalibracion_idruninfo'] >0)
                                                          {
                                                            if( $activo_paso_calib_legacy == "")
                                                            {
                                                                
                                                                    ?>
                                                                <div class="step  "> <span class="icon"> <i
                                                                            class="fa fa-box"></i> </span> <span
                                                                        class="text"><b>Calibration 2 <br>
                                                                    </span></a></b> </div>
                                                                <?php
                                                                  
                                                            }
                                                            else
                                                            {
                                                              ?>

                                                                <div class="step active"> <span class="icon"> <i
                                                                            class="fa fa-box"></i> </span> <span
                                                                        class="text"><b>Calibration <br> </span></a></b>
                                                                    <a href='#'
                                                                        onclick='popuplogdb(<?php echo  $rowbuscawo['tienecalibracion_idruninfo']; ?>)'
                                                                        style='color:#f39323;'> <i
                                                                            class='fas fa-eye'></i> - View Log </a>
                                                                </div>
                                                                <br>
                                                            </div>
                                                            <?php
                                                            }
                                                              
                                                          
                                                          }
                                                          else
                                                          {
                                                            ?>
                                                            <div class="step "> <span class="icon"> <i
                                                                        class="fa fa-box"></i> </span> <span
                                                                    class="text">Calibration<br></span> </div>
                                                            <?php
                                                          }
      
                                                        
                                                      
                                                      ///////////////////////////////////////////////////////
                                                }
    
      
                                                ///////////////// wo_calibration_legacy //////////////////////////  
                                             //   echo "<br>*******".$rowpasos['stepfunction'];
                                              ///////////////// auto_burnin //////////////////////////
                                             if ($rowpasos['stepfunction']=="upgradeso" )
                                             {

                                              $esupgrade ="N";
                                              $Sql_ifupgrade = $connect->prepare(" select distinct modelciu, idorders from orders_sn inner join  fnt_select_allproducts_maxrev() as ppp on ppp.idproduct = orders_sn.idproduct   where wo_serialnumber = '".$rowbuscawo['wo_serialnumber']."' and typeregister = 'UP' ");                                 
                                              $Sql_ifupgrade->execute();
                                              $result_ifup = $Sql_ifupgrade->fetchAll();	
                                              foreach ($result_ifup as $row_up)
                                              {
                                                $esupgrade ="Y";
                                                $elmodelcuiupgrade = $row_up['modelciu'];
                                                $idorders_upgrde =  $row_up['idorders']; 
                                                
                                              }
                                              if ( $esupgrade =="Y")
                                              {

                                             
                                          ///      echo " select * from fnt_select_upgrade_finalsku_ia_detect_lic('".$nombre_ciu_amostrar."','".$elmodelcuiupgrade."') ";
                                              $Sql_ifupgrade2 = $connect->prepare(" select * from fnt_select_upgrade_finalsku_ia_detect_lic('".$nombre_ciu_amostrar."','".$elmodelcuiupgrade."') ");                                 
                                              $Sql_ifupgrade2->execute();
                                              $result_ifup2 = $Sql_ifupgrade2->fetchAll();	
                                              foreach ($result_ifup2 as $row_up2)
                                              {
                                               $skucalculado = $row_up2['v_fsku'];
                                              }

                                               
                                              ?>
                                                            <div class="stepazul active">
                                                                <a href="#"
                                                                    onclick="show_info('orderinfoupgrade','<?php echo $rowbuscawo['wo_serialnumber']; ?>','<?php echo $idorders_upgrde; ?>','<?php echo $skucalculado; ?>',0,0)">
                                                                    <span class="icon"><i class="fa fa-box"></i> </span>
                                                                    <span class="text"><b>Upgrade PN<br>
                                                                            <?php echo  $elmodelcuiupgrade;?>
                                                                            <?php
                                               echo "<br>".$skucalculado ;

                                              ?>

                                                                            <span class='text text-left'>
                                                                                <a href="#"
                                                                                    onclick="Call_printlabel_upgrade('<?php echo $skucalculado; ?>', '<?php echo $rowbuscawo['wo_serialnumber']; ?>' ,'<?php echo $idorders_upgrde; ?>')">&nbsp;
                                                                                    <i class="fas fa-print"></i> - Print
                                                                                    Label</a>
                                                                                <br><a
                                                                                    href="printokeyupgrade.php?vido=<?php echo $idorders_upgrde; ?>&sn=<?php echo $rowbuscawo['wo_serialnumber']; ?>"
                                                                                    target='_blank'>&nbsp; <i
                                                                                        class="fas fa-file-pdf"></i> -
                                                                                    View PDF</a>
                                                                                <br>
                                                                                <br> </span> </b>
                                                                </a>
                                                                </span>
                                                            </div>
                                                            <?php
                                               }

                                             } 
                                             ///////////////// auto_burnin //////////////////////////
                                                    ///////////////// auto_burnin //////////////////////////
                                             if ($rowpasos['stepfunction']=="auto_burnin" )
                                             {

                                              $activo_paso_autoburn="";
                                              $Sql_polypaste = $connect->prepare("
                                              select reference from fas_outcome_integral
                                              where  datetimeref in(
                                                           select max(datetimeref) from fas_outcome_integral where reference in(
                                                           select reference from fas_outcome_integral
                                                           where idtype = 4 and v_string= '".$rowbuscawo['wo_serialnumber']."'							
                                                           ) and fas_outcome_integral.idtype =12 and v_integer=21
                                                      ) and fas_outcome_integral.idtype =12 and v_integer=21 ");                                 
                                              $Sql_polypaste->execute();
                                              $result_ifautotestpp = $Sql_polypaste->fetchAll();	
                                              foreach ($result_ifautotestpp as $row_autotestpp)
                                              {
                                                $idruninfoautoburning= $row_autotestpp['reference'] ; 
                                              }    

                                                ///////////////////////////////////////////////////////
                                                $sqlautoburnin="SELECT distinct   idtype, v_boolean::integer as v_booleaninteger  FROM fas_outcome_integral where reference = ".$idruninfoautoburning."  and idfasoutcomecat = 0 and idtype in(13)";
                                                
                                                if ($idruninfoautoburning <>"")
                                                {

                                                          
                                                        ///  	echo "test:".$sqldetectchkeopicki;
                                                            $databurnin = $connect->query($sqlautoburnin)->fetchAll();
                                                            $activo_paso66="";
                                                            
                                                            foreach ($databurnin as $rowburnin) 
                                                            {
                                                              
                                                                if ( $rowburnin['v_booleaninteger'] == 1  && $rowburnin['idtype'] == 13)
                                                                {
                                                                  $activo_paso66="active";
                                                                  $activo_paso66_totalpass=" <span class='badge bg-success'>Passed</span><br>";
                                                                }
                                                                else
                                                                {
                                                                  $activo_paso66="active";
                                                                  $activo_paso66_totalpass=" <span class='badge bg-danger'>Fail</span><br>";
                                                                }
                                                              
                                                              
                                                            }
                                                }
                                           
                     
                                                 if ($idruninfoautoburning <>"")
                                                 {

                                                
                                                  

                                                
                                                 ?>
                                                            <div class="step    <?php echo  $activo_paso66; ?>">
                                                                <a href="#"
                                                                    onclick="show_info('reportburnin','<?php echo $rowbuscawo['wo_serialnumber']; ?>','<?php echo $v_idp; ?>','<?php echo $nombre_a_mostrar_en_dvi_finalchk; ?>','<?php echo $idruninfoautoburning; ?>',0)"><span
                                                                        class="icon"><i class="fa fa-box"></i> </span>
                                                                    <span class="text"><b>Auto Burnin<br>
                                                                            <?php echo $activo_paso66_totalpass; ?></span></a>
                                                                </b>
                                                                <a href='#'
                                                                    onclick='popuplogdb(<?php echo $idruninfoautoburning; ?>)'
                                                                    style='color:#f39323;'> <i class='fas fa-eye'></i> -
                                                                    View Log </a> </a><br>

                                                            </div>
                                                            <?php
                                               }
                                               else
                                               {
                                                   ?>
                                                            <div class="step  "> <span class="icon"><i
                                                                        class="fa fa-box"></i> </span> <span
                                                                    class="text">Auto Burnin<br> </span></div>
                                                            <?php  
                                               }
   
                                             }
   
                                             ///////////////// auto_burnin //////////////////////////  
                                          ///////////////// wo_afterburning //////////////////////////
                                          if ($rowpasos['stepfunction']=="wo_afterburning" &&  $_if_auto_test_box_calibration == "N" &&   $eslegacy =="N")
                                          {
                                            $linkreportafter_burning_check="calibrationtopdfconimg.php";
                                             ///////////////////////////////////////////////////////
                                             //Control si es Enterprise Remoto
                                         

                                          
                                             ///

                                              if ( $rowbuscawo['tienefinalchk_idruninfo'] >0)
                                              {
                                                $idruninfoAfertburnung= $rowbuscawo['tienefinalchk_idruninfo'] ; 
                                              ?>
                                                            <div class="step <?php echo  $activo_paso4; ?>">
                                                                <?php 
                                           
                                           $sqlpassentremoto_totalpass="SELECT distinct   idtype, v_boolean::integer as v_booleaninteger  FROM fas_outcome_integral where reference = ".$rowbuscawo['tienefinalchk_idruninfo']."  and idfasoutcomecat = 0 and idtype in(13)";
 
                                                     

                                           $dataentrem = $connect->query($sqlpassentremoto_totalpass)->fetchAll();
                                         //  $activo_paso4_totalpass="";
                                           
                                           foreach ($dataentrem as $rowentree) 
                                           {
                                             
                                               if ( $rowentree['v_booleaninteger'] == 1  && $rowentree['idtype'] == 13)
                                               {
                                                
                                                 $activo_paso4_totalpass = "<span class='badge bg-success'>Passed</span><br><a href='#' onclick='popuplogdb(".$rowbuscawo['tienefinalchk_idruninfo'].")'  style='color:#f39323;'>View Log <i class='fas fa-eye'></i></a>";
                                             
                                               }
                                               else
                                               {
                                                 
                                                 $activo_paso4_totalpass = "<span class='badge bg-danger'>Not Passed</span><br><a href='#' onclick='popuplogdb(".$rowbuscawo['tienefinalchk_idruninfo'].")'  style='color:#f39323;'>View Log <i class='fas fa-eye'></i></a>";
                                               
                                               }                                                       
                                             
                                           }

                                              if ( $ciuisenterprice =='Y')
                                                    {
                                                      ////Buscamos si el runinfo pasoo o no..para el ENT REM
                                                      $linkreportafter_burning_check="reportafbcoutcome.php";
                                                    

                                                        if ( $ciuisremote =="Y")
                                                        {
                                                          ?>
                                                                <a href="#"
                                                                    onclick="show_info('finalchkenterpriseremoto','<?php echo $rowbuscawo['wo_serialnumber']; ?>','<?php echo $v_idp; ?>','<?php echo $nombre_a_mostrar_en_dvi_finalchk; ?>','<?php echo $rowbuscawo['tienefinalchk_idruninfo']; ?>',0)"><span
                                                                        class="icon"><i class="fa fa-box"></i> </span>
                                                                    <span class="text"><b>After Burning Check <br>
                                                                            <?php
                                                        }
                                                        if ( $ciuismaster =="Y")
                                                        {
                                                          ?>
                                                                            <a href="#"
                                                                                onclick="show_info('finalchkenterprisemaster','<?php echo $rowbuscawo['wo_serialnumber']; ?>','<?php echo $v_idp; ?>','<?php echo $nombre_a_mostrar_en_dvi_finalchk; ?>','<?php echo $rowbuscawo['tienefinalchk_idruninfo']; ?>',0)"><span
                                                                                    class="icon"><i
                                                                                        class="fa fa-box"></i> </span>
                                                                                <span class="text"><b>After Burning
                                                                                        Check <br>
                                                                                        <?php
                                                        }
                                                      ?>

                                                                                        <?php
                                                    }
                                                    else
                                                    {
                                                    
                                                      ?>
                                                                                        <a href="#"
                                                                                            onclick="show_info('finalchk','<?php echo $rowbuscawo['wo_serialnumber']; ?>','<?php echo $v_idp; ?>','<?php echo $nombre_a_mostrar_en_dvi_finalchk; ?>','<?php echo $rowbuscawo['tienefinalchk_idruninfo']; ?>',0)"><span
                                                                                                class="icon"><i
                                                                                                    class="fa fa-box"></i>
                                                                                            </span> <span
                                                                                                class="text"><b>After
                                                                                                    Burning Check <br>
                                                                                                    <?php
                                                    }?>


                                                                                                    <?php echo $activo_paso4_totalpass; ?></span></a>
                                                                                    </b>
                                                                                    <br> <a
                                                                                        href="<?php echo  $linkreportafter_burning_check; ?>?idsndib=<?php echo  $rowbuscawo['wo_serialnumber']; ?>&iduldl=0&idmb=0&idrun=<?php echo $rowbuscawo['tienefinalchk_idruninfo'];?>"
                                                                                        target="_blank"> <i
                                                                                            class='fas fa-file-pdf'></i>
                                                                                        - View Report</a>
                                                                            </a><br>

                                                            </div>
                                                            <?php
                                            }
                                            else
                                            {
                                                ?>
                                                            <div class="step <?php echo  $activo_paso4; ?>"> <span
                                                                    class="icon"><i class="fa fa-box"></i> </span> <span
                                                                    class="text">After Burning Check<br> </span></div>
                                                            <?php  
                                            }

                                          }

                                          ///////////////// wo_afterburning //////////////////////////  
                                          $v_sn_have_rma ="N";
                                          ///Buscamos si el SN.. tiene RMA
                                          $Sql_elsntinerma = $connect->prepare("   select idproduct from orders_sn where so_soft_external like '%RM%' and     wo_serialnumber= '".$rowbuscawo['wo_serialnumber']."'  ");   
                                          $Sql_elsntinerma->execute();
                                          $result_tienesnrma = $Sql_elsntinerma->fetchAll();	
                                          foreach ($result_tienesnrma as $row_tienesnchkrma)
                                          {
                                            $v_sn_have_rma ="Y";
                                          }
                                         
                                          //////////////////FinalCheckRMA/////////////////////
                                          if ($rowpasos['stepfunction']=="finalcheckrma" &&  $v_sn_have_rma =="Y")
                                          {

                                              $Sql_finalcheckrma = $connect->prepare("   select reference from fas_outcome_integral
                                                        where  datetimeref in(
                                                                    select max(datetimeref) from fas_outcome_integral where reference in(
                                                                    select reference from fas_outcome_integral
                                                                    where idtype = 4 and v_string= '".$rowbuscawo['wo_serialnumber']."'		
                                                                    and reference in( select reference from fas_outcome_integral
                                                                    where idtype =2 and v_string= '". $rma_nro."'		 )					
                                                                    ) and ((fas_outcome_integral.idtype =12and v_integer=22) or  (fas_outcome_integral.idtype =13 and v_boolean = true) )
                                                                ) and ((fas_outcome_integral.idtype =12and v_integer=22) or  (fas_outcome_integral.idtype =13 and v_boolean = true) )  ");    

                                                                
 
                                                                $idruninfo_rma_finalchk = "";                 
                                                 $Sql_finalcheckrma->execute();
                                                 $result_chkrma = $Sql_finalcheckrma->fetchAll();	
                                                 foreach ($result_chkrma as $row_chkrma)
                                                 {
                                                   $idruninfo_rma_finalchk = $row_chkrma['reference'];
                                                   $activo_paso_Final_Check  = "active";
                                                   $nombre_a_mostrar_en_dvi_finalchkso="Final Check RMA: ". $rma_nro." -- SN: ".$row_chkrma['wo_serialnumber'];
                                                   $namephprma="calibrationtopdfconimgsaleorders.php";
                                                   $tipolinkweb="finalchkso";
                                                   ///preguntamos si el ciu es familia ENTERPRISE MASTER. 000100010037004000490052
                                                        $Sql_modelciuisentermaster = $connect->prepare("   select modelciu from fnt_select_allproducts_maxrev() where modelciu = '".$rma_nro."' and iduniquebranchsonprod like '%00010037004000490052%'");
                                                        $Sql_modelciuisentermaster->execute();
                                                        $result_cuimodelenter = $Sql_modelciuisentermaster->fetchAll();	
                                                        foreach ($result_cuimodelenter as $row_ciuisentermast)
                                                        {
                                                          
                                                          $tipolinkweb="finalchksorma_enterprisemater";
                                                        }


                                                
                                                 
                                                 }

                                                  if ($idruninfo_rma_finalchk =="")
                                                  {

                                                  
                                            ?>
                                                            <div class="step "> <span class="icon"><i
                                                                        class="fa fa-box"></i> </span> <span
                                                                    class="text">Final Check <br> </span></div>
                                                            <?php
                                                  }
                                                  else
                                                  {
                                                  ?>
                                                            <div class="step active  ">
                                                                <a href="#"
                                                                    onclick="show_info('<?php echo  $tipolinkweb; ?>','<?php echo  $rowbuscawo['wo_serialnumber']; ?>','<?php echo  $idorders_rma ; ?>','<?php echo $nombre_a_mostrar_en_dvi_finalchkso; ?>','<?php echo $idruninfo_rma_finalchk; ?>','<?php echo  "0";?>')">
                                                                    <span class="icon"> <i class="fa fa-box"></i>
                                                                    </span> <span class="text">Final Check </span>
                                                                    <!-- <span class='badge bg-danger'>Not Passed</span> <br> -->

                                                                    <a href='#'
                                                                        onclick='popuplogdb(<?php echo $idruninfo_rma_finalchk; ?>)'
                                                                        style='color:#f39323;'> <i
                                                                            class='fas fa-eye'></i>- View Log </a>
                                                                    <br> <a
                                                                        href="<?php echo $namephprma;?>?idsndib=<?php echo  $rowbuscawo['wo_serialnumber']; ?>&amp;iduldl=0&amp;idmb=0"
                                                                        target="_blank"> <i class='fas fa-file-pdf'></i>
                                                                        - View Report</a>
                                                                </a><br>
                                                            </div>
                                                            <?php
                                                  }
                                                ?>


                                                            <?php 
                                          }
                                          /////////// fin FinalCheckRMA //////////////////////////

                                          //////////////////Final Inspection RMA/////////////////////
                                          if ($rowpasos['stepfunction']=="finalinpectionrma" &&  $v_sn_have_rma =="Y")
                                          {
                                            
                                                 /////**************3  Quality Survey Final Check ************************************** 
                                              //// sumamos un paso aqui prechech  Precheck
                                              $sqldetectchkeo3="SELECT   status_sn  FROM public.fas_survey_responses_bysn where idsurvey = 3 and  sn = '".$rowbuscawo['wo_serialnumber']."' and  so = '". $rma_nro."' and modelciu = '".$nombre_ciu_amostrar_rma."'
                                              order by datetimecheck desc limit 1 ";
                                              
                                           //   echo "test:".$sqldetectchkeo3;
                                                $datadetectprecheko3 = $connect->query($sqldetectchkeo3)->fetchAll();
                                                $tieneprecheck=0;
                                                
                                                foreach ($datadetectprecheko3 as $rowchequeo) 
                                                {
                                                  $tieneprecheck=1;
                                                }
                                              ?>
                                                            <?php if ( $tieneprecheck==1) 
                                              {
                                                  ?>
                                                            <div class="stepverde  active">
                                                                <?php
                                              }
                                              else
                                              {
                                                ?>
                                                                <div class="stepverde    ">
                                                                    <?php
                                              }
                                              ?>

                                                                    <a href="#"
                                                                        onclick="show_info('Precheckfinalcheck','<?php echo $rowbuscawo['wo_serialnumber']; ?>','<?php echo  $rma_nro; ?>','<?php echo $nombre_ciu_amostrar_rma; ?>','Quality Calibration Precheck',0)">
                                                                        <span class="icon"> <i class="fas fa-tasks"></i>
                                                                        </span>
                                                                        <span class="text"> <b>Final Inspection <br>SN
                                                                                [<?php echo $rowbuscawo['wo_serialnumber']; ?>]
                                                                                <br></b></span>
                                                                        <?php
                                                $sqldetectchkeo="SELECT   status_sn  FROM public.fas_survey_responses_bysn where  idsurvey = 3 and  sn  = '".$rowbuscawo['wo_serialnumber']."' and  so = '".$rma_nro."' and modelciu = '".$nombre_ciu_amostrar_rma."'
                                                order by datetimecheck desc limit 1 ";
                                                
                                         //       	echo "test:".$sqldetectchkeo;
                                                  $datadetectprecheko = $connect->query($sqldetectchkeo)->fetchAll();
                                                  foreach ($datadetectprecheko as $rowchequeo) 
                                                  {
                                                      if ($rowchequeo['status_sn']=="PASS")
                                                      {
                                                        echo "    <span class='badge bg-success'>Passed</span><br>";
                                                      }
                                                      else
                                                      {
                                                        echo "    <span class='badge bg-danger'>Fail</span><br>";
                                                      }
                                                  }
                                              ?>


                                                                </div>
                                                                </a>

                                                                <?php 
                                          }
                                          /////////// fin Final Inspection RMA //////////////////////////

                                          ///////////////// RMA Info //////////////////////////
                                          if ($rowpasos['stepfunction']=="rma_info" &&  $v_sn_have_rma =="Y")
                                          {
                                            $tiene_rma_laSO  = "N";
                                            $sqltienerma = $connect->prepare("   select orders_sn.idorders as idordersrma, so_soft_external, modelciu  from orders_sn inner join fnt_select_allproducts_maxrev() as ppp on ppp.idproduct = orders_sn.idproduct   where  wo_serialnumber = '".$rowbuscawo['wo_serialnumber']."' and so_original = '".$rowbuscawo['tienesoasociada']."' ");                                 
                                            $sqltienerma->execute();
                                            $result_sodelrma = $sqltienerma->fetchAll();	
                                            foreach ($result_sodelrma as $row_datarma)
                                            {
                                              $rma_nro  = $row_datarma['so_soft_external'];
                                              $idorders_rma = $row_datarma['idordersrma'];
                                              $nombre_ciu_amostrar = $row_datarma['modelciu'];
                                              $nombre_ciu_amostrar_rma = $row_datarma['modelciu'];
                                              $tiene_rma_laSO  = "Y";
                                            }

                                            if(  $tiene_rma_laSO  == "Y")
                                            {
                                              $nombre_a_mostrar_en_dvi_paraSO ='Order Detail :: RMA:'. $rma_nro." - SN: ".$rowbuscawo['wo_serialnumber'];
                                            
                                              ?>
                                                                <a href="#"
                                                                    onclick="show_info('orderinfo','<?php echo $rowbuscawo['wo_serialnumber']; ?>','<?php echo $idorders_rma; ?>','<?php echo $nombre_a_mostrar_en_dvi_paraSO; ?>',0,0)">
                                                                    <div class="stepazul active "><span class="icon"> <i
                                                                                class="fa fa-check"></i> </span> <span
                                                                            class="text"><b>RMA:<?php echo   $rma_nro; ?>
                                                                                <br>CIU :
                                                                                <?php echo   $nombre_ciu_amostrar; ?><br>SN
                                                                                Assign :
                                                                                <?php echo $rowbuscawo['wo_serialnumber']; ?></b></span>
                                                                </a>
                                                                <a href="#"
                                                                    onclick="Call_printlabel('<?php echo  $nombre_ciu_amostrar; ?>', '<?php echo $rowbuscawo['wo_serialnumber']; ?>' ,'<?php echo  $idorders_rma; ?>')">&nbsp;
                                                                    <i class="fas fa-print"></i> - Print Label</a>
                                                            </div>
                                                            <?php
                                            }
                                          
                                          }
                                          ///////////////// END RMA Info //////////////////////////

                                          ///////////////// so_info-finalcheck //////////////////////////
                                          if ($rowpasos['stepfunction']=="so_info-finalcheck")
                                          {

                                             /////////////////// VAMOS POR LOS PASOS DE SO

                                              ///    tienesoasociada
                                                  $nombre_ciu_amostrar="";
                                                  if ( $rowbuscawo['tienesoasociada'] =="")
                                                  {
                                                    ?>
                                                            <div class="stepazulyamarillo active">

                                                                <span class="icon"> <i class="fa fa-check"></i> </span>
                                                                <span class="text"><b>SO:<?php //echo $rowbuscawo['tienesoasociada']; ?>
                                                                        <br>CIU : <?php //echo  $ciutemp; ?></b>
                                                                </span>
                                                                <a href="#"
                                                                    onclick="show_info('asingsnwotoso','<?php echo $rowbuscawo['wo_serialnumber']; ?>','<?php echo $rowbuscawo['idorders']; ?>','',0,0)">
                                                                    <span class="badge bg-warning"><b>Assign SN
                                                                        </b></span>
                                                                </a>
                                                            </div>
                                                            <div class="step  "> <span class="icon"> <i
                                                                        class="fa fa-box"></i> </span> <span
                                                                    class="text">Final Check </span> </div>
                                                            <?php
                                                  }
                                                  else
                                                  {
                                                    $nombre_a_mostrar_en_dvi_paraSO ='Order Detail :: SO:'.$rowbuscawo['tienesoasociada']." - SN: ".$rowbuscawo['wo_serialnumber'];
                                                    $nombre_ciu_amostrar = $rowbuscawo['tienesomodelciuso']
                                                    ?>
                                                            <a href="#"
                                                                onclick="show_info('orderinfo','<?php echo $rowbuscawo['wo_serialnumber']; ?>','<?php echo $rowbuscawo['idordersso']; ?>','<?php echo $nombre_a_mostrar_en_dvi_paraSO; ?>',0,0)">
                                                                <div class="stepazul active "><span class="icon"> <i
                                                                            class="fa fa-check"></i> </span> <span
                                                                        class="text"><b>SO:<?php echo $rowbuscawo['tienesoasociada']; ?>
                                                                            <br>CIU :
                                                                            <?php echo  $rowbuscawo['tienesomodelciuso']; ?><br>SN
                                                                            Assign :
                                                                            <?php echo $rowbuscawo['wo_serialnumber']; ?></b></span>
                                                            </a>
                                                            <a href="#"
                                                                onclick="Call_printlabel('<?php echo $rowbuscawo['tienesomodelciuso']; ?>', '<?php echo $rowbuscawo['wo_serialnumber']; ?>' ,'<?php echo $rowbuscawo['idordersso']; ?>')">&nbsp;
                                                                <i class="fas fa-print"></i> - Print Label</a>


                                                            <?php
                                                  if( $_SESSION["g"] =='develop' || 'Productionadmin' ==  $_SESSION["g"])
                                                  {
                                                    ?>
                                                            <br> <a
                                                                href='unlinksndevelop.php?snmm=<?php echo $rowbuscawo['wo_serialnumber'];?>'
                                                                target='_blank'> <span class='text-danger'>Unlink sn
                                                                </span> </a>
                                                            <?php
                                                  }
                                                 
                                                  ?>
                                                        </div>




                                                        <?php
                                                   /// echo "1,2,3,4";
                                                    //////////////////////////////////////////////////////////////////////////////////////
                                                   
                                                      if ( $steps_polypaste=="Y")
                                                      {
                                                    
                                                             //    echo " select * from fas_outcome_integral where idfasoutcomecat = 12 and idtype = 14 and  v_string = '".$rowbuscawo['wo_serialnumber']."'  ";
                                                             $activo_paso_polypaste="";
                                                             $Sql_polypaste = $connect->prepare("   select * from fas_outcome_integral where idfasoutcomecat = 12 and idtype = 14 and  v_string = '".$rowbuscawo['wo_serialnumber']."'  ");                                 
                                                             $Sql_polypaste->execute();
                                                             $result_ifautotestpp = $Sql_polypaste->fetchAll();	
                                                             foreach ($result_ifautotestpp as $row_autotestpp)
                                                             {
                                                               
                                                               $activo_paso_polypaste  = "active";
                                                             }
                                                             ?>
                                                        <div class="stepverde   <?php echo $activo_paso_polypaste;?>  ">
                                                            <a href="#"
                                                                onclick="show_info('polypaste','<?php echo $rowbuscawo['wo_serialnumber']; ?>','<?php echo $rowbuscawo['idordersso']; ?>','Poly Paste','<?php echo $rowbuscawo['tienefinalchk_idruninfo']; ?>',0)">

                                                                <span class="icon"> <i class="fa fa-box"></i> </span>
                                                                <span class="text">Poly Paste</span>
                                                            </a>
                                                        </div>
                                                        <?php
                                                       }
                                                    //////////////////////////////////////////////////////////////////////////////////////
                                                      if ($steps_so_final_inspection  == "Y")
                                                      {
    /////**************3  Quality Survey Final Check ************************************** 
                                              //// sumamos un paso aqui prechech  Precheck
                                              $sqldetectchkeo3="SELECT   status_sn  FROM public.fas_survey_responses_bysn where idsurvey = 3 and  sn = '".$rowbuscawo['wo_serialnumber']."' and  so = '".$rowbuscawo['so_soft_external']."' and modelciu = '".$rowbuscawo['modelciu']."'
                                              order by datetimecheck desc limit 1 ";
                                              
                                              //	echo "test:".$sqldetectchkeo;
                                                $datadetectprecheko3 = $connect->query($sqldetectchkeo3)->fetchAll();
                                                $tieneprecheck=0;
                                                
                                                foreach ($datadetectprecheko3 as $rowchequeo) 
                                                {
                                                  $tieneprecheck=1;
                                                }
                                              ?>
                                                        <?php if ( $tieneprecheck==1) 
                                              {
                                                  ?>
                                                        <div class="stepverde  active">
                                                            <?php
                                              }
                                              else
                                              {
                                                ?>
                                                            <div class="stepverde    ">
                                                                <?php
                                              }
                                              ?>

                                                                <a href="#"
                                                                    onclick="show_info('Precheckfinalcheck','<?php echo $rowbuscawo['wo_serialnumber']; ?>','<?php echo $rowbuscawo['so_soft_external']; ?>','<?php echo $rowbuscawo['modelciu']; ?>','Quality Calibration Precheck',0)">
                                                                    <span class="icon"> <i class="fas fa-tasks"></i>
                                                                    </span>
                                                                    <span class="text"> <b>Final Inspection <br>SN
                                                                            [<?php echo $rowbuscawo['wo_serialnumber']; ?>]
                                                                            <br></b></span>
                                                                    <?php
                                                $sqldetectchkeo="SELECT   status_sn  FROM public.fas_survey_responses_bysn where  idsurvey = 3 and  sn = '".$rowbuscawo['wo_serialnumber']."' and  so = '".$rowbuscawo['so_soft_external']."' and modelciu = '".$rowbuscawo['modelciu']."'
                                                order by datetimecheck desc limit 1 ";
                                                
                                                //	echo "test:".$sqldetectchkeo;
                                                  $datadetectprecheko = $connect->query($sqldetectchkeo)->fetchAll();
                                                  foreach ($datadetectprecheko as $rowchequeo) 
                                                  {
                                                      if ($rowchequeo['status_sn']=="PASS")
                                                      {
                                                        echo "    <span class='badge bg-success'>Passed</span><br>";
                                                      }
                                                      else
                                                      {
                                                        echo "    <span class='badge bg-danger'>Fail</span><br>";
                                                      }
                                                  }
                                              ?>


                                                            </div>
                                                            </a> <?php

                                                      } 
                                                    /// Si tiene SO asociada.. vamos a ver el Final Check
                                                  ///  idordersso
 
                                                  $sqltieneSOfinalchk = $connect->prepare("  select fas_calibration_result.totalpass::int as totalpassso , fas_calibration_result.idruninfo  
                                                  from fas_calibration_result
                                                  inner join runinfodb
                                                      on runinfodb.idruninfodb = fas_calibration_result.idruninfo  
                                                  inner join
                                                  (	
                                                    select fas_calibration_result.unitsn,   max(dateserver) as maxfecha
                                                      from orders
                                                      inner join orders_sn 
                                                      on orders_sn.idorders = orders.idorders   
                                                      inner join fas_calibration_result
                                                      on fas_calibration_result.unitsn = orders_sn.wo_serialnumber 
                                                      inner join runinfodb
                                                      on runinfodb.idruninfodb = fas_calibration_result.idruninfo          
                                                      where orders.idorders = ".$rowbuscawo['idordersso']." and calibrationscript = false and orders_sn.wo_serialnumber= '".$rowbuscawo['wo_serialnumber']."'
                                                      and modelciu not in( select distinct  modelciu from products where  idproduct  in (select distinct idproduct from products_attributes where v_boolean= true and idattribute = 0)) 
                                                      group by fas_calibration_result.unitsn 
                                                  )  as  tienecalibracionadentro
                                                  on tienecalibracionadentro.unitsn	=	fas_calibration_result.unitsn and
                                                    
                                                    tienecalibracionadentro.maxfecha	=	runinfodb.dateserver ");

                                                    

                                      
                                                  $sqltieneSOfinalchk->execute();
                                                  $resultsofinalchk = $sqltieneSOfinalchk->fetchAll();	
                                                  $modelcuidibboard="";	
                                                  $nombre_a_mostrar_en_dvi_finalchkso ='Final Check SO:: SN: '.$rowbuscawo['wo_serialnumber'];
                                          //         echo "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";

                                          //////////////////////////////////////////////////////
                                          /////// parcheee
                                          $tipolinkweb="";
//                                         echo "a ver".$nombre_ciu_amostrar;
                                          if (substr($nombre_ciu_amostrar ,0,3)=="DH7" )
                                          {
                                          /// $idruninfoAfertburnung=0;

                                          $tipolinkweb="finalchkso";
                                      

                                          if ( $ciuisenterprice=="Y" &&   $ciuismaster=="Y" )
                                          {
                                            
                                            $idruninfoAfertburnung=99;  
                                            $tipolinkweb=" ";
                                            $namephp="reportfinchhcoutcome.php";
                                           
                                          }
                                          else
                                          {
                                            $idruninfoAfertburnung=0;
                                          
                                            $namephp="calibrationtopdfconimgsaleorders.php";
                                          }                        


                                                ///preguntamos si el ciu es familia ENTERPRISE MASTER. 000100010037004000490052
                                                $Sql_modelciuisentermaster = $connect->prepare("   select modelciu from fnt_select_allproducts_maxrev() where modelciu = '".$nombre_ciu_amostrar."' and iduniquebranchsonprod like '%00010037004000490052%'");
                                                $Sql_modelciuisentermaster->execute();
                                                $result_cuimodelenter = $Sql_modelciuisentermaster->fetchAll();	
                                           
                                                foreach ($result_cuimodelenter as $row_ciuisentermast)
                                                {
                                            //      echo "a ver".$nombre_ciu_amostrar;       
                                                  $tipolinkweb="";
                                                }

                                       
                                          }
                                          else
                                          {
                                            if ( $ciuisenterprice=="Y" &&   $ciuisremote=="Y" )
                                            {
                                                 $tipolinkweb="finalchksoentremoto";
                                                 $namephp="calibrationtopdfconimgsaleordersentrem.php";
                                            }
                                            else
                                            {

                                              if ( $ciuisenterprice=="Y" &&   $ciuismaster=="Y" )
                                              {
                                                
                                                $idruninfoAfertburnung=99;  
                                                $tipolinkweb=" ";
                                                $namephp="reportfinchhcoutcome.php";
                                               
                                              }
                                              else
                                              {
                                                $idruninfoAfertburnung=0;
                                                $tipolinkweb="finalchksotemp";
                                                $namephp="calibrationtopdfconimgsaleorders.php";
                                              }                                              
                                             
                                            }
                                            
                                          }
                      
                                        
                                          ///////////////////////////////////////////////////////
                                                  $entroaverfinalch=0;
                                                  foreach ($resultsofinalchk as $rowspfinalchk)
                                                  {
                                                    $entroaverfinalch=1;
                                                    if ( $rowspfinalchk['totalpassso'] ==1)
                                                    {
                                                      if ( $idruninfoAfertburnung ==99)
                                                      {
                                                        $idruninfoAfertburnung= $rowspfinalchk['idruninfo'];  
                                                      }
                                                      ?>
                                                            <div class="step active  ">
                                                                <a href="#"
                                                                    onclick="show_info('<?php echo  $tipolinkweb; ?>','<?php echo $rowbuscawo['wo_serialnumber']; ?>','<?php echo $rowbuscawo['idordersso']; ?>','<?php echo $nombre_a_mostrar_en_dvi_finalchkso; ?>','<?php echo $rowspfinalchk['idruninfo']; ?>','<?php echo  $idruninfoAfertburnung;?>')">
                                                                    <span class="icon"> <i class="fa fa-box"></i>
                                                                    </span> <span class="text">Final Check </span> <span
                                                                        class='badge bg-success'>Passed</span>
                                                                    <br><a href='#'
                                                                        onclick='popuplogdb(<?php echo $rowspfinalchk['idruninfo']; ?>)'
                                                                        style='color:#f39323;'> <i
                                                                            class='fas fa-eye'></i> - View Log </a>
                                                                </a>
                                                                <br><a
                                                                    href="<?php echo $namephp;?>?idsndib=<?php echo  $rowbuscawo['wo_serialnumber']; ?>&amp;iduldl=0&amp;idmb=0&idrunaferbur=<?php echo $idruninfoAfertburnung;?>"
                                                                    target="_blank"> <i class='fas fa-file-pdf'></i> -
                                                                    View Report </a>
                                                                <br>
                                                            </div>
                                                            <?php
                                                    }
                                                    else
                                                    {
                                                      ?>
                                                            <div class="step active  ">
                                                                <a href="#"
                                                                    onclick="show_info('<?php echo  $tipolinkweb; ?>','<?php echo  $rowbuscawo['wo_serialnumber']; ?>','<?php echo $rowbuscawo['idordersso']; ?>','<?php echo $nombre_a_mostrar_en_dvi_finalchkso; ?>','<?php echo $rowspfinalchk['idruninfo']; ?>','<?php echo  $idruninfoAfertburnung;?>')">
                                                                    <span class="icon"> <i class="fa fa-box"></i>
                                                                    </span> <span class="text">Final Check </span>
                                                                    <!-- <span class='badge bg-danger'>Not Passed</span> <br> -->

                                                                    <a href='#'
                                                                        onclick='popuplogdb(<?php echo $rowspfinalchk['idruninfo']; ?>)'
                                                                        style='color:#f39323;'> <i
                                                                            class='fas fa-eye'></i>- View Log </a>
                                                                    <br> <a
                                                                        href="<?php echo $namephp;?>?idsndib=<?php echo  $rowbuscawo['wo_serialnumber']; ?>&amp;iduldl=0&amp;idmb=0"
                                                                        target="_blank"> <i class='fas fa-file-pdf'></i>
                                                                        - View Report</a>
                                                                </a><br>
                                                            </div>
                                                            <?php
                                                    }
                                                    break;
                                                  } 

                                                  if ($entroaverfinalch==0)
                                                  {
                                                    ?>

                                                            <div class="step  "> <span class="icon"> <i
                                                                        class="fa fa-box"></i> </span> <span
                                                                    class="text">Final Check </span> </div>
                                                            <?php
                                                  }

                                                




                                                  ?>
                                                            <?php
                                                  }


                                          }

                                          ///////////////// so_info-finalcheck //////////////////////////  

                                          ////////////////// POLY PASTE ///////////////////////////////////
                                      if ($rowpasos['stepfunction'] =="polypaste")
                                            {
                                              $steps_polypaste="Y";
                                              
                                              //// lo metimosss adentro de so_info-finalcheck
                                     
                                     /*
                                              //    echo " select * from fas_outcome_integral where idfasoutcomecat = 12 and idtype = 14 and  v_string = '".$rowbuscawo['wo_serialnumber']."'  ";
                                              $activo_paso_polypaste="";
                                              $Sql_polypaste = $connect->prepare("   select * from fas_outcome_integral where idfasoutcomecat = 12 and idtype = 14 and  v_string = '".$rowbuscawo['wo_serialnumber']."'  ");                                 
                                              $Sql_polypaste->execute();
                                              $result_ifautotestpp = $Sql_polypaste->fetchAll();	
                                              foreach ($result_ifautotestpp as $row_autotestpp)
                                              {
                                                
                                                $activo_paso_polypaste  = "active";
                                              }
                                              ?>
                                                            <div
                                                                class="stepverde   <?php echo $activo_paso_polypaste;?>  ">
                                                                <a href="#"
                                                                    onclick="show_info('polypaste','<?php echo $rowbuscawo['wo_serialnumber']; ?>','<?php echo $rowbuscawo['idordersso']; ?>','Poly Paste','<?php echo $rowbuscawo['tienefinalchk_idruninfo']; ?>',0)">

                                                                    <span class="icon"> <i class="fa fa-box"></i>
                                                                    </span> <span class="text">Poly Paste</span>
                                                                </a>
                                                            </div>
                                                            <?php
                                        */
                                            }
                                        ////////////////// POLY PASTE ///////////////////////////////////
                                      
                                               
                                            ///////////////// bbu_fas_calibration //////////////////////////
                                            if ($rowpasos['stepfunction']=="bbu_fas_calibration")
                                            {
                                              $activo_paso_Final_Check  = "";
                                            
                                                 /////**************************************************** 3- FinalCheck ::fas_script_type
                                                 $eslegacy ="Y";
                                                 
                                             /*    $Sql_ifautotest = $connect->prepare("   select reference from fas_outcome_integral
                                                 where  datetimeref in(
                                                              select max(datetimeref) from fas_outcome_integral 
                                                              where reference in(
                                                                  select reference from fas_outcome_integral
                                                                     where idtype = 4 and v_string= '".$rowbuscawo['wo_serialnumber']."'  						
                                                                                )
                                                                     and ((fas_outcome_integral.idtype =12and v_integer=22) or  (fas_outcome_integral.idtype =13 and v_boolean = true) )
                                                         ) and ((fas_outcome_integral.idtype =12and v_integer=22) or  (fas_outcome_integral.idtype =13 and v_boolean = true) )  
                                                         ");   
                                                          */
                                                        
                                                         $Sql_ifautotest = $connect->prepare("   select reference from fas_outcome_integral
                                                         where  datetimeref in(
                                                                      select max(datetimeref) from fas_outcome_integral 
                                                                      where reference in(

                                                                        select reference from fas_outcome_integral where reference in (
                                                                          select reference  from fas_outcome_integral where v_string  = '".$rowbuscawo['wo_serialnumber']."') and idtype = 16 and idfasoutcomecat  = 0 and v_string not in ('ljulian','acorigliano')
                                              			                             )
                                                                             and ((fas_outcome_integral.idtype =12and v_integer=22) or  (fas_outcome_integral.idtype =13 and v_boolean = true) )
                                                                 ) and ((fas_outcome_integral.idtype =12and v_integer=22) or  (fas_outcome_integral.idtype =13 and v_boolean = true) )  
                                                                 ");    
                                                         
                                                                 
                                                         

                                                 $Sql_ifautotest->execute();
                                                 $result_ifautotest = $Sql_ifautotest->fetchAll();	
                                                 foreach ($result_ifautotest as $row_autotest)
                                                 {
                                                   $idruninfobbu = $row_autotest['reference'];
                                                   $activo_paso_Final_Check  = "active";
                                                 }
                                                 /////**************************************************** 
                                       //           echo   "aaaaa".$_if_auto_test_box_calibration;
                                                     
                                                       if( $activo_paso_Final_Check == "")
                                                       {
                                                           
                                                               ?>
                                                            <div class="step "> <span class="icon"> <i
                                                                        class="fa fa-box"></i> </span> <span
                                                                    class="text"><b>BBU FAS Calibration<br>
                                                                </span></a></b> </div>
                                                            <?php
                                                             
                                                       }                                                 
                                                        else
                                                        {
                                                            $sqlbbustatus = "select v_boolean::integer as statusrun from fas_outcome_integral
                                                            where reference in(
                                                            select reference from fas_outcome_integral where datetimeref in( select max(datetimeref) 
                                                            from fas_outcome_integral where reference in( select reference 
                                                            from fas_outcome_integral where idtype = 4 and v_string= '".$rowbuscawo['wo_serialnumber']."' ) and fas_outcome_integral.idtype =12 and v_integer=22 )
                                                            and fas_outcome_integral.idtype =12 and v_integer=22 )
                                                          and fas_outcome_integral.idtype =13";
                                                          
                                                            $databbusta = $connect->query($sqlbbustatus)->fetchAll();
                                                            foreach ($databbusta as $rowchequeobbu) 
                                                            {
                                                                if ($rowchequeobbu['statusrun']==1)
                                                                {
                                                                    $bbU_pass= "    <span class='badge bg-success'>Passed</span><br>";
                                                                }
                                                                else
                                                                {
                                                                  $bbU_pass= "    <span class='badge bg-danger'>Fail</span><br>";
                                                                }
                                                            }


                                                            ?>
                                                            <div class="step active "> <span class="icon"> <i
                                                                        class="fa fa-box"></i> </span> <span
                                                                    class="text">BBU FAS Calibration <br></span>
                                                                <?php echo $bbU_pass;?>
                                                                <a href='#'
                                                                    onclick='popuplogdb(<?php echo $idruninfobbu; ?>)'
                                                                    style='color:#f39323;'> <i class='fas fa-eye'></i>-
                                                                    View Log </a><br>
                                                                <a href="calibbburepot.php?unitsn=<?php echo  $rowbuscawo['wo_serialnumber']; ?>&amp;iduldl=0&amp;idmb=0"
                                                                    target="_blank"> <i class='fas fa-file-pdf'></i> -
                                                                    View Report</a>
                                                            </div>
                                                            <?php
                                                        }
 
  
  
                                            }
  
                                            ///////////////// bbu_fas_calibration //////////////////////////  


                                            ///////////////// finalcheck_legacy //////////////////////////
                                            if ($rowpasos['stepfunction']=="finalcheck_legacy")
                                            {
                                              $activo_paso_Final_Check  = "";
                                            
                                                 /////**************************************************** 3- FinalCheck ::fas_script_type
                                                 $eslegacy ="Y";
                                                 
                                             
                                                 $Sql_ifautotest = $connect->prepare("   select reference from fas_outcome_integral
                                                 where  datetimeref in(
                                                              select max(datetimeref) from fas_outcome_integral where reference in(
                                                              select reference from fas_outcome_integral
                                                              where idtype = 4 and v_string= '".$rowbuscawo['wo_serialnumber']."'							
                                                              ) and fas_outcome_integral.idtype =12 and v_integer=3
                                                         ) and fas_outcome_integral.idtype =12 and v_integer=3  ");      

                                                 $Sql_ifautotest->execute();
                                                 $result_ifautotest = $Sql_ifautotest->fetchAll();	
                                                 foreach ($result_ifautotest as $row_autotest)
                                                 {
                                                   
                                                   $activo_paso_Final_Check  = "active";
                                                 }
                                                 /////**************************************************** 
                                       //           echo   "aaaaa".$_if_auto_test_box_calibration;
                                                     
                                                       if( $activo_paso_Final_Check == "")
                                                       {
                                                           
                                                               ?>
                                                            <div class="step "> <span class="icon"> <i
                                                                        class="fa fa-box"></i> </span> <span
                                                                    class="text"><b>Final Check <br> </span></a></b>
                                                            </div>
                                                            <?php
                                                             
                                                       }                                                 
                                                        else
                                                        {
                                                          ?>
                                                            <div class="step active "> <span class="icon"> <i
                                                                        class="fa fa-box"></i> </span> <span
                                                                    class="text">Final Check <br></span>
                                                                <a href="calibrationtopdfconimg.php?idsndib=<?php echo  $rowbuscawo['wo_serialnumber']; ?>&amp;iduldl=0&amp;idmb=0"
                                                                    target="_blank"> <i class='fas fa-file-pdf'></i> -
                                                                    View Report</a>
                                                            </div>
                                                            <?php
                                                        }
 
  
  
                                            }
  
                                            ///////////////// finalcheck_legacy //////////////////////////  
                                            ///////////////// so_info_legacy //////////////////////////
                                            if ($rowpasos['stepfunction']=="so_info_legacy")
                                            {
  
                                               /////////////////// VAMOS POR LOS PASOS DE SO
  
                                                ///    tienesoasociada
                                                    $nombre_ciu_amostrar="";
                                                    if ( $rowbuscawo['tienesoasociada'] =="")
                                                    {
                                                      ?>
                                                            <div class="stepazul">

                                                                <span class="icon"> <i class="fa fa-check"></i> </span>
                                                                <span class="text"><b>SO:<?php //echo $rowbuscawo['tienesoasociada']; ?>
                                                                        <br>CIU : <?php //echo  $ciutemp; ?></b>
                                                                </span>
                                                            </div>

                                                            <?php
                                                    }
                                                    else
                                                    {


                                                      $_tiene_attach_legacy="";
                                            
                                                      $sql_attaanalogbda = $connect->prepare(" select * from orders_fileattach
                                                       where idorders = ".$v_idp." and seedtemp like 'soinfolegacy%' and sn = '".$rowbuscawo['wo_serialnumber']."' ");   
                                                   
                                                     
                                                       $sql_attaanalogbda->execute();
                                                       $result_attaanbda = $sql_attaanalogbda->fetchAll();	
                                                       foreach ($result_attaanbda as $rownobdaaa)
                                                       {
                                                        // echo "aaaaaaaaaaaaaaaaaaaaaa";
                                                         $_tiene_attach_legacy =  $rownobdaaa['seedtemp'];
        
                                                       }


                                                      $psswdtkkey = substr( md5(microtime()), 1, 8);
                                                      $nombre_a_mostrar_en_dvi_paraSO ='Order Detail :: SO:'.$rowbuscawo['tienesoasociada']." - SN: ".$rowbuscawo['wo_serialnumber'];
                                                      $nombre_ciu_amostrar = $rowbuscawo['tienesomodelciuso']
                                                      ?>
                                                            <a href="#"
                                                                onclick="show_info('orderinfo','<?php echo $rowbuscawo['wo_serialnumber']; ?>','<?php echo $rowbuscawo['idordersso']; ?>','<?php echo $nombre_a_mostrar_en_dvi_paraSO; ?>',0,0)">
                                                                <div class="stepazul active "><span class="icon"> <i
                                                                            class="fa fa-check"></i> </span> <span
                                                                        class="text"><b>SO:<?php echo $rowbuscawo['tienesoasociada']; ?>
                                                                            <br>CIU :
                                                                            <?php echo  $rowbuscawo['tienesomodelciuso']; ?><br>SN
                                                                            Assign :
                                                                            <?php echo $rowbuscawo['wo_serialnumber']; ?></b></span>
                                                            </a>
                                                            <a href="#"
                                                                onclick="Call_printlabel('<?php echo $rowbuscawo['tienesomodelciuso']; ?>', '<?php echo $rowbuscawo['wo_serialnumber']; ?>' ,'<?php echo $rowbuscawo['idordersso']; ?>')">&nbsp;
                                                                <i class="fas fa-print"></i> - Print Label</a>
                                                            <br>


                                                            <?php
                                                     if ($_tiene_attach_legacy=="")
                                                     {
                                                      ?>
                                                            <a href='#'
                                                                onclick='attachanalogbda(<?php echo  $v_idp ?>,"soinfolegacy_<?php echo  $psswdtkkey;?>","<?php echo $rowbuscawo['wo_serialnumber']; ?>")'>
                                                                <?php
                                                     }
                                                     else
                                                     {
                                                      ?>
                                                                <a href='#'
                                                                    onclick='attachanalogbda(<?php echo  $v_idp ?>,"<?php echo  $_tiene_attach_legacy;?>","<?php echo $rowbuscawo['wo_serialnumber']; ?>")'>
                                                                    <?php
                                                     }
                                                     ?>
                                                                    <i class="fa fa-paperclip" aria-hidden="true"></i>
                                                                    Attach Files
                                                                </a>


                                                        </div>


                                                        <?php
                                                    }
  
  
                                            }
  
                                            ///////////////// so_info_legacy //////////////////////////  
                                            ///////////////// so_info_bbu   //////////////////////////
                                            if ($rowpasos['stepfunction']=="so_info_bbu")
                                            {
  
                                               /////////////////// VAMOS POR LOS PASOS DE SO
  
                                                ///    tienesoasociada
                                                    $nombre_ciu_amostrar="";
                                                    if ( $rowbuscawo['tienesoasociada'] =="")
                                                    {
                                                      ?>
                                                        <div class="stepazul">

                                                            <span class="icon"> <i class="fa fa-check"></i> </span>
                                                            <span class="text"><b>SO:<?php //echo $rowbuscawo['tienesoasociada']; ?>
                                                                    <br>CIU : <?php //echo  $ciutemp; ?></b>
                                                            </span>
                                                        </div>

                                                        <?php
                                                    }
                                                    else
                                                    {
                                                      $nombre_a_mostrar_en_dvi_paraSO ='Order Detail :: SO:'.$rowbuscawo['tienesoasociada']." - SN: ".$rowbuscawo['wo_serialnumber'];
                                                      $nombre_ciu_amostrar = $rowbuscawo['tienesomodelciuso']
                                                      ?>
                                                        <a href="#"
                                                            onclick="show_info('orderinfo','<?php echo $rowbuscawo['wo_serialnumber']; ?>','<?php echo $rowbuscawo['idordersso']; ?>','<?php echo $nombre_a_mostrar_en_dvi_paraSO; ?>',0,0)">
                                                            <div class="stepazul active "><span class="icon"> <i
                                                                        class="fa fa-check"></i> </span> <span
                                                                    class="text"><b>SO:<?php echo $rowbuscawo['tienesoasociada']; ?>
                                                                        <br>CIU :
                                                                        <?php echo  $rowbuscawo['tienesomodelciuso']; ?><br>SN
                                                                        Assign :
                                                                        <?php echo $rowbuscawo['wo_serialnumber']; ?></b></span>
                                                        </a>
                                                        <a href="#"
                                                            onclick="Call_printlabel('<?php echo $rowbuscawo['tienesomodelciuso']; ?>', '<?php echo $rowbuscawo['wo_serialnumber']; ?>' ,'<?php echo $rowbuscawo['idordersso']; ?>')">&nbsp;
                                                            <i class="fas fa-print"></i> - Print Label</a>
                                                        <?php
                                                  if( $_SESSION["g"] =='develop' || 'Productionadmin' ==  $_SESSION["g"])
                                                  {
                                                    ?>
                                                        <br> <a
                                                            href='unlinksndevelop.php?snmm=<?php echo $rowbuscawo['wo_serialnumber'];?>'
                                                            target='_blank'> <span class='text-danger'>Unlink sn </span>
                                                        </a>
                                                        <?php
                                                  }
                                                 
                                                  ?>
                                                    </div>
                                                    <?php
                                                    }
  
                                                    if ( $steps_polypaste=="Y")
                                                    {

                                                          //    echo " select * from fas_outcome_integral where idfasoutcomecat = 12 and idtype = 14 and  v_string = '".$rowbuscawo['wo_serialnumber']."'  ";
                                                          $activo_paso_polypaste="";
                                                          $Sql_polypaste = $connect->prepare("   select * from fas_outcome_integral where idfasoutcomecat = 12 and idtype = 14 and  v_string = '".$rowbuscawo['wo_serialnumber']."'  ");                                 
                                                          $Sql_polypaste->execute();
                                                          $result_ifautotestpp = $Sql_polypaste->fetchAll();	
                                                          foreach ($result_ifautotestpp as $row_autotestpp)
                                                          {
                                                            
                                                            $activo_paso_polypaste  = "active";
                                                          }
                                                          ?>
                                                    <div class="stepverde   <?php echo $activo_paso_polypaste;?>  ">
                                                        <a href="#"
                                                            onclick="show_info('polypaste','<?php echo $rowbuscawo['wo_serialnumber']; ?>','<?php echo $rowbuscawo['idordersso']; ?>','Poly Paste','<?php echo $rowbuscawo['tienefinalchk_idruninfo']; ?>',0)">

                                                            <span class="icon"> <i class="fa fa-box"></i> </span> <span
                                                                class="text">Poly Paste</span>
                                                        </a>
                                                    </div>
                                                    <?php
                                                    }
  
                                            }
  
                                            ///////////////// so_info_bbu //////////////////////////  
                                         ///////////////// so_final_inspection //////////////////////////
                                         if ($rowpasos['stepfunction']=="so_final_inspection")
                                         {
                                          $steps_so_final_inspection ="Y";
                                         }
                                         if ($rowpasos['stepfunction']=="finalinspection_legacy")
                                         {
                                            /////**************************************************** 
                                              /////**************3  Quality Survey Final Check ************************************** 
                                              //// sumamos un paso aqui prechech  Precheck
                                              
                                              $sqldetectchkeo3="SELECT   status_sn  FROM public.fas_survey_responses_bysn where idsurvey = 3 and  sn = '".$rowbuscawo['wo_serialnumber']."' and  so = '".$rowbuscawo['so_soft_external']."' and modelciu = '".$rowbuscawo['modelciu']."'
                                              order by datetimecheck desc limit 1 ";
                                              
                                              //	echo "test:".$sqldetectchkeo;
                                                $datadetectprecheko3 = $connect->query($sqldetectchkeo3)->fetchAll();
                                                $tieneprecheck=0;
                                                
                                                foreach ($datadetectprecheko3 as $rowchequeo) 
                                                {
                                                  $tieneprecheck=1;
                                                }
                                              ?>
                                                    <?php if ( $tieneprecheck==1) 
                                              {
                                                  ?>
                                                    <div class="stepverde  active">
                                                        <?php
                                              }
                                              else
                                              {
                                                ?>
                                                        <div class="stepverde    ">
                                                            <?php
                                              }
                                              ?>

                                                            <a href="#"
                                                                onclick="show_info('Precheckfinalcheck','<?php echo $rowbuscawo['wo_serialnumber']; ?>','<?php echo $rowbuscawo['so_soft_external']; ?>','<?php echo $rowbuscawo['modelciu']; ?>','Quality Calibration Precheck',0)">
                                                                <span class="icon"> <i class="fas fa-tasks"></i> </span>
                                                                <span class="text"> <b>Final Inspection <br>SN
                                                                        [<?php echo $rowbuscawo['wo_serialnumber']; ?>]
                                                                        <br></b></span>
                                                                <?php
                                                $sqldetectchkeo="SELECT   status_sn  FROM public.fas_survey_responses_bysn where  idsurvey = 3 and  sn = '".$rowbuscawo['wo_serialnumber']."' and  so = '".$rowbuscawo['so_soft_external']."' and modelciu = '".$rowbuscawo['modelciu']."'
                                                order by datetimecheck desc limit 1 ";
                                                
                                                //	echo "test:".$sqldetectchkeo;
                                                  $datadetectprecheko = $connect->query($sqldetectchkeo)->fetchAll();
                                                  foreach ($datadetectprecheko as $rowchequeo) 
                                                  {
                                                      if ($rowchequeo['status_sn']=="PASS")
                                                      {
                                                        echo "    <span class='badge bg-success'>Passed</span><br>";
                                                      }
                                                      else
                                                      {
                                                        echo "    <span class='badge bg-danger'>Fail</span><br>";
                                                      }
                                                  }
                                              ?>


                                                        </div>
                                                        </a>
                                                        <?php
                                              
                                         }

                                         ///////////////// so_final_inspection //////////////////////////
                                         ///////////////// bbu_precheck //////////////////////////
                                         if ($rowpasos['stepfunction']=="bbu_precheck")
                                         {
                                            /////**************************************************** 
                                              /////************** BBU PRE CHEQUEO************************************** 
                                              //// sumamos un paso aqui prechech  Precheck
                                              $sqldetectchkeo="SELECT   status_sn  FROM public.fas_survey_responses_bysn where  idsurvey = 1 and sn = '".$rowbuscawo['wo_serialnumber']."' and  so = '".$rowbuscawo['so_soft_external']."' and modelciu = '".$rowbuscawo['modelciu']."'
                                              order by datetimecheck desc limit 1 ";

                                              //	echo "test:".$sqldetectchkeo;
                                              $datadetectprecheko = $connect->query($sqldetectchkeo)->fetchAll();
                                              $tieneprecheck=0;

                                              foreach ($datadetectprecheko as $rowchequeo) 
                                              {
                                              $tieneprecheck=1;
                                              }
                                              ?>
                                                        <?php if ( $tieneprecheck==1) 
                                              {
                                              ?>
                                                        <div class="stepverde  active">
                                                            <?php
                                              }
                                              else
                                              {
                                              ?>
                                                            <div class="step  ">
                                                                <?php
                                              }
                                              ?>

                                                                <a href="#"
                                                                    onclick="show_info('Precheck','<?php echo $rowbuscawo['wo_serialnumber']; ?>','<?php echo $rowbuscawo['so_soft_external']; ?>','<?php echo $rowbuscawo['modelciu']; ?>','Quality Calibration Precheck',0)">
                                                                    <span class="icon"> <i class="fas fa-tasks"></i>
                                                                    </span>
                                                                    <span class="text"> <b>Quality Precheck <br>SN
                                                                            [<?php echo $rowbuscawo['wo_serialnumber']; ?>]
                                                                            <br></b></span>
                                                                    <?php
                                              $sqldetectchkeo="SELECT   status_sn  FROM public.fas_survey_responses_bysn where idsurvey = 1 and  sn = '".$rowbuscawo['wo_serialnumber']."' and  so = '".$rowbuscawo['so_soft_external']."' and modelciu = '".$rowbuscawo['modelciu']."'
                                              order by datetimecheck desc limit 1 ";

                                            //  	echo "test:".$sqldetectchkeo;
                                              $datadetectprecheko = $connect->query($sqldetectchkeo)->fetchAll();
                                              foreach ($datadetectprecheko as $rowchequeo) 
                                              {
                                                  if ($rowchequeo['status_sn']=="PASS")
                                                  {
                                                      echo "    <span class='badge bg-success'>Passed</span><br>";
                                                  }
                                                  else
                                                  {
                                                    echo "    <span class='badge bg-danger'>Fail</span><br>";
                                                  }
                                              }
                                              ?>


                                                            </div>
                                                            </a>
                                                            <?php
                                              /////**************************************************** 
                                         }

                                         ///////////////// bbu_precheck //////////////////////////
                                         ///////////////// bbu_calibration //////////////////////////
                                         if ($rowpasos['stepfunction']=="bbu_calibration")
                                         {
                                                /////************** QUALITY_CALIBRATION_BBU************************************** 
                                              //// sumamos un paso aqui prechech  Precheck
                                              $sqldetectchkeo="SELECT   status_sn  FROM public.fas_survey_responses_bysn where  idsurvey = 4 and sn = '".$rowbuscawo['wo_serialnumber']."' and  so = '".$rowbuscawo['so_soft_external']."' and modelciu = '".$rowbuscawo['modelciu']."'
                                              order by datetimecheck desc limit 1 ";

                                           //   	echo "test:".$sqldetectchkeo;
                                              $datadetectprecheko = $connect->query($sqldetectchkeo)->fetchAll();
                                              $tieneprecheck=0;

                                              foreach ($datadetectprecheko as $rowchequeo) 
                                              {
                                              $tieneprecheck=1;
                                              }
                                              ?>
                                                            <?php if ( $tieneprecheck==1) 
                                              {
                                              ?>
                                                            <div class="stepverde  active">
                                                                <?php
                                              }
                                              else
                                              {
                                              ?>
                                                                <div class="step  ">
                                                                    <?php
                                              }
                                              ?>

                                                                    <a href="#"
                                                                        onclick="show_info('PrecheckBBUscs','<?php echo $rowbuscawo['wo_serialnumber']; ?>','<?php echo $rowbuscawo['so_soft_external']; ?>','<?php echo $rowbuscawo['modelciu']; ?>','Quality Calibration Precheck',0)">
                                                                        <span class="icon"> <i class="fas fa-tasks"></i>
                                                                        </span>
                                                                        <span class="text"> <b>BBU Integration Checklist
                                                                                <br>SN
                                                                                [<?php echo $rowbuscawo['wo_serialnumber']; ?>]
                                                                                <br></b></span>
                                                                        <?php
                                              $sqldetectchkeo="SELECT   status_sn  FROM public.fas_survey_responses_bysn where idsurvey = 4 and  sn = '".$rowbuscawo['wo_serialnumber']."' and  so = '".$rowbuscawo['so_soft_external']."' and modelciu = '".$rowbuscawo['modelciu']."'
                                              order by datetimecheck desc limit 1 ";

                                              //	echo "test:".$sqldetectchkeo;
                                              $datadetectprecheko = $connect->query($sqldetectchkeo)->fetchAll();
                                              foreach ($datadetectprecheko as $rowchequeo) 
                                              {
                                                  if ($rowchequeo['status_sn']=="PASS")
                                                  {
                                                      echo "    <span class='badge bg-success'>Passed</span><br>";
                                                  }
                                                  else
                                                  {
                                                    echo "    <span class='badge bg-danger'>Fail</span><br>";
                                                  }
                                              }
                                              ?>


                                                                </div>
                                                                </a>
                                                                <?php
                                              /////**************************************************** 
                                         }

                                         ///////////////// bbu_calibration //////////////////////////
                                          ///////////////// so_final_inspection //////////////////////////
                                          if ($rowpasos['stepfunction']=="so_final_inspection_bbu")
                                          {
                                             /////**************************************************** 
                                               /////**************3  Quality Survey Final Check ************************************** 
                                               //// sumamos un paso aqui prechech  Precheck
                                               $sqldetectchkeo3="SELECT   status_sn  FROM public.fas_survey_responses_bysn where idsurvey = 3 and  sn = '".$rowbuscawo['wo_serialnumber']."' and  so = '".$rowbuscawo['so_soft_external']."' and modelciu = '".$rowbuscawo['modelciu']."'
                                               order by datetimecheck desc limit 1 ";
                                               
                                               //	echo "test:".$sqldetectchkeo;
                                                 $datadetectprecheko3 = $connect->query($sqldetectchkeo3)->fetchAll();
                                                 $tieneprecheck=0;
                                                 
                                                 foreach ($datadetectprecheko3 as $rowchequeo) 
                                                 {
                                                   $tieneprecheck=1;
                                                 }
                                               ?>
                                                                <?php if ( $tieneprecheck==1) 
                                               {
                                                   ?>
                                                                <div class="stepverde  active">
                                                                    <?php
                                               }
                                               else
                                               {
                                                 ?>
                                                                    <div class="step  ">
                                                                        <?php
                                               }
                                               ?>

                                                                        <a href="#"
                                                                            onclick="show_info('Precheckfinalcheck','<?php echo $rowbuscawo['wo_serialnumber']; ?>','<?php echo $rowbuscawo['so_soft_external']; ?>','<?php echo $rowbuscawo['modelciu']; ?>','Quality Calibration Precheck',0)">
                                                                            <span class="icon"> <i
                                                                                    class="fas fa-tasks"></i> </span>
                                                                            <span class="text"> <b>Final Inspection
                                                                                    <br>SN
                                                                                    [<?php echo $rowbuscawo['wo_serialnumber']; ?>]
                                                                                    <br></b></span>
                                                                            <?php
                                                 $sqldetectchkeo="SELECT   status_sn  FROM public.fas_survey_responses_bysn where  idsurvey = 3 and  sn = '".$rowbuscawo['wo_serialnumber']."' and  so = '".$rowbuscawo['so_soft_external']."' and modelciu = '".$rowbuscawo['modelciu']."'
                                                 order by datetimecheck desc limit 1 ";
                                                 
                                                 //	echo "test:".$sqldetectchkeo;
                                                   $datadetectprecheko = $connect->query($sqldetectchkeo)->fetchAll();
                                                   foreach ($datadetectprecheko as $rowchequeo) 
                                                   {
                                                       if ($rowchequeo['status_sn']=="PASS")
                                                       {
                                                         echo "    <span class='badge bg-success'>Passed</span><br>";
                                                       }
                                                       else
                                                       {
                                                         echo "    <span class='badge bg-danger'>Fail</span><br>";
                                                       }
                                                   }
                                               ?>


                                                                    </div>
                                                                    </a>
                                                                    <?php

                                                       

                                          }
 
                                          ///////////////// so_final_inspection //////////////////////////
                                          ///////////////// BBU ANNU Form //////////////////////////
                                          if ($rowpasos['stepfunction']=="bbu_ann_forms")
                                          {
                                                  /////************** QUALITY_CALIBRATION_BBU************************************** 
                                                //// sumamos un paso aqui prechech  Precheck
                                                $sqldetectchkeo="SELECT   status_sn  FROM public.fas_survey_responses_bysn where  idsurvey in (5,6) and sn = '".$rowbuscawo['wo_serialnumber']."' and  so = '".$rowbuscawo['so_soft_external']."' and modelciu = '".$rowbuscawo['modelciu']."'
                                                order by datetimecheck desc limit 1 ";

                                            //   	echo "test:".$sqldetectchkeo;
                                                $datadetectprecheko = $connect->query($sqldetectchkeo)->fetchAll();
                                                $tieneprecheck=0;

                                                foreach ($datadetectprecheko as $rowchequeo) 
                                                {
                                                $tieneprecheck=1;
                                                }
                                                ?>
                                                                    <?php if ( $tieneprecheck==1) 
                                                {
                                                ?>
                                                                    <div class="stepverde  active">
                                                                        <?php
                                                }
                                                else
                                                {
                                                ?>
                                                                        <div class="step  ">
                                                                            <?php
                                                }
                                                ?>

                                                                            <a href="#"
                                                                                onclick="show_info('PrecheckBBUANN','<?php echo $rowbuscawo['wo_serialnumber']; ?>','<?php echo $rowbuscawo['so_soft_external']; ?>','<?php echo $rowbuscawo['modelciu']; ?>','Quality Calibration Precheck',0)">
                                                                                <span class="icon"> <i
                                                                                        class="fas fa-tasks"></i>
                                                                                </span>
                                                                                <span class="text"> <b>BBU ANN
                                                                                        Acceptance Test <br>SN
                                                                                        [<?php echo $rowbuscawo['wo_serialnumber']; ?>]
                                                                                        <br></b></span>
                                                                                <?php
                                                $sqldetectchkeo="SELECT   status_sn  FROM public.fas_survey_responses_bysn where idsurvey in(5,6) and  sn = '".$rowbuscawo['wo_serialnumber']."' and  so = '".$rowbuscawo['so_soft_external']."' and modelciu = '".$rowbuscawo['modelciu']."'
                                                order by datetimecheck desc limit 1 ";

                                                //	echo "test:".$sqldetectchkeo;
                                                $datadetectprecheko = $connect->query($sqldetectchkeo)->fetchAll();
                                                foreach ($datadetectprecheko as $rowchequeo) 
                                                {
                                                    if ($rowchequeo['status_sn']=="PASS")
                                                    {
                                                        echo "    <span class='badge bg-success'>Passed</span><br>";
                                                    }
                                                    else
                                                    {
                                                      echo "    <span class='badge bg-danger'>Fail</span><br>";
                                                    }
                                                }
                                                ?>


                                                                        </div>
                                                                        </a>
                                                                        <?php
                                                /////**************************************************** 
                                          }

                                          ///////////////// BBU ANNU Form //////////////////////////
                        
                        /////  cierro for de Los pasos
                              }
                         //     echo  "tienepasos:".$tienepasos;
                       //  $modelcui_mostrarerror

                         
                         $pos = strpos($modelcui_mostrarerror, "LIC");
                         
                         // The !== operator can also be used.  Using != would not work as expected
                         // because the position of 'a' is 0. The statement (0 != false) evaluates
                         // to false.
                         if ($pos !== false) {
                              
                         } else {
                              
                          if(  $tienepasos==0)
                          {
                         //   echo "<br><div class='small-box bg-danger'></div>";
                            ?>
                                                                    </div>
                                                                    <div class="col-md-3">
                                                                        <div class="card bg-gradient-danger">
                                                                            <div class="card-header">
                                                                                <h3 class="card-title">Atention</h3>
                                                                            </div>
                                                                            <div class="card-body">
                                                                                CIU
                                                                                [<?php echo   $modelcui_mostrarerror; ?>]
                                                                                without preloaded steps <br>
                                                                                Please report this situation to the fas
                                                                                team.
                                                                            </div>
                                                                            <!-- /.card-body -->
                                                                        </div>
                                                                    </div>
                                                                    <?php
                          }
                        //// cierro for de los WO -SN - SO
                        echo "</div>   
                        <br><br>";
                        }


                         }


                      
                           
                      }
                ?>
                                                                </div>
                                                                <br><br><br>
                                                                <hr>
                                                                <br><br><br><br>
                                                                <?php




                  $sanitized_n = filter_var($_REQUEST['isdo'], FILTER_SANITIZE_STRING);
                  if (filter_var($sanitized_n, FILTER_SANITIZE_STRING)) {
                    $v_idp = $_REQUEST['isdo'];
                   
                    $filtrar_xsn ="";
                    $sanitized_na = filter_var($_REQUEST['encont'], FILTER_SANITIZE_STRING);
                    if (filter_var($sanitized_na, FILTER_SANITIZE_STRING)) {
                      $filtrar_xsn = substr($_REQUEST['encont'],-2);
                      $snafiltrar =  $_REQUEST['encont'];
                    }

              

         
     

        }
      

        ?>


                                                            </div>
                                                        </div>




                                                    </div>
                                                </div>

                                                <hr>


                                </section>

                                <!-- /.col -->
                            </div>
                        </div>
                        <!-- /.timeline -->



                </section>
                <!-- /.content -->



            </div>


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
    window.location = 'trackingorders.php?isdo=' + datosmm[0] + '&typeisdo=' + datosmm[1] + '&encont=' +
        datosmm[2];
});


function popuplogdb(idrunifno) {
    eModal.iframe('logdbonlydet.php?idab=' + idrunifno, 'Log Activity');
}

function attachanalogbda(vidord, lasemillita, vvsn) {
    eModal.iframe('attachfileprojectsoaddmoreanalogbda.php?idt=' + lasemillita + '&idord=' + vidord + '&vvsn=' + vvsn,
        'Attach files to SN	' + vvsn);
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

    ///////////////////////////////////////////////////////////////////////////////////////
    if (desdedonde == 'PrecheckBBUANN') {
        eModal.iframe('calibrationqualitychecklisallsurvery.php?elsn=' + snparam + '&elso=' + soparam + '&elciu=' +
            sotextoamostrar, 'BBU ANN Acceptance Test');

    }
    ////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////
    if (desdedonde == 'picking') {
        eModal.iframe('wopickingsteps.php?elso=' + soparam + '&elsn=' + snparam + '&elciu=' + sotextoamostrar +
            '&typeworkc=ASSY', ' ' + snparam + ' || ' + soparam + ' || ' + sotextoamostrar);
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
            sotextoamostrar + '&typeworkm=wo_PRECHECK', 'Quality precheck');

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
        //// show_info(desdedonde,snparam, soparam, sotextoamostrar, idruninfoparam, idparamafterburning)
        //eModal.iframe('report_burnin.php?hidmenu=Y&idr='+idruninfoparam,'Report Burning');
        eModal.iframe('show_tracking_assignsn_wotososap.php?hidmenu=Y&sn=' + snparam + '&soparam=' + soparam +
            '&sotextoamostrar=' + sotextoamostrar, 'Assing SN ');

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
    alert('Test 98654.21Bis');
}


function refrescame_mm() {
    window.location.reload();
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
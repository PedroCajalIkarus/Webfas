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
     background:#28a745;
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
     background: #0053a1;;
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

.modal-xl 
    {
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
            <h1>Tracking Orders MM TEST</h1>
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
          <p name="msjwaitline" id="msjwaitline" align="center"><img src="img/waitazul.gif" width="100px" ></p>	
				<div class="card">
             <div class="container-fluid">
             <br>
                <div class="form-group row" >
                
                            <label for="inputPassword" class="col-sm-1 col-form-label">Search:</label>
                            <div class="col-sm-12">	
                         				
                                <select class="js-example-basic-single col-sm-8"    id="txtlistcius" name="txtlistcius">

                                </select>	
                                
                         

                            </div>
                       
                            
                
                </div>     
                
                <p algin="right" class="col-4">
                 <button class="btn btn-primary btn-lg btn-block btn-sm" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                 Custom Search
                </button>

                </p>
<div class="col-4 collapse" id="collapseExample">
  <div class="card card-body">
   <b>Step Activity </b> 
   <br>
   Steps:
      <select class="form-control form-control-sm" name="filterstep" id="filterstep">
         <option value="">All</option>
          <option value="finalcheckso">Final Check</option>
          <option value="finalinspection">Final Inspection</option>
      </select>
   <br>
  <b>Date Range:</b>  <input id="daterangem" name="daterangem">
  <hr>
  <b>Picking:</b> 
  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">CIU:</label>
                    <div class="col-sm-10">
                           <input type="text" id="txtsearchtxtciu" name="txtsearchtxtciu" class="form-control form-control-sm">
                    </div>
                    <label for="inputEmail3" class="col-sm-2 col-form-label">SN:</label>
                    <div class="col-sm-10">
                    <input type="text" id="txtsearchtxtsn" name="txtsearchtxtsn" class="form-control form-control-sm">
                    </div>
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Rev:</label>
                    <div class="col-sm-10">
                     <input type="text" id="txtsearchtxtrev" name="txtsearchtxtrev" class="form-control form-control-sm"> 
                    </div>

    </div>
    <div class="card-footer">
                 
                  <button type="submit" class="btn btn-block btn-outline-primary btn-xs float-right">Search</button>
                </div>
 </div>
</div>

           

       <hr>
   
                                                 
            <div class="card " id="artSO" name="artSO">
            
         
                  <div class="card-header">
                       <h3 class="card-title">  <h3 class="card-title">:: Tracking ::  </h3> 
					

                    <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
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
              //    echo "a ver".$jsondatarange;
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
                  //    echo  $sqlrange;
 
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
                              $sqlbuscarrma= "       select orders_sn.idorders , typeregister   from orders_sn
                              inner join (SELECT  wo_serialnumber as wo_serialnumberrma, so_original as so_originalasoorma  FROM orders_sn os  WHERE (wo_serialnumber  = '". $snafiltrar."' and typeregister = 'UP') ) as losrma
                              on     losrma.wo_serialnumberrma     =  orders_sn.wo_serialnumber where typeregister not like '%UP%' and so_soft_external not like '%RM%' and typeregister = 'SO' and wo_serialnumber  = '". $snafiltrar."' ";
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
                                {}
                                else
                                {
                                  $filtrar_xsn =$rowrma['typeregister'];
                                }
                                
                                $sumaelwherewo="  and orders_sn.wo_serialnumber = '".$snafiltrar."'   and  products.modelciu not like '%LIC%' ";

                              }
                              ////Buscamos el nuevo ID.. 
                           //   echo "rmanuevoid".$v_idp."----". $filtrar_xsn;
                              
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
                                              
                                        where orders.idorders in (select idorders from orders_sn where so_associed in (select so_soft_external from orders_sn where idorders = ".$v_idp.")) 
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
                                         order by orr desc, wo_serialnumber
                                     ";
                                          ///// and  orders.idorders <> orders_sn_SOassociada.idorders
                                   
                     //   echo "<br>HOLA::::::".   $sqlbusco;
                       }
                       if (  $filtrar_xsn =="WO")
                       {
                      //  echo "aaaaaaaaaaaaaaaaaaaaaaaaa 1164";
                         
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
                    ///   echo "bbbbbbbbbbbbbbbbbbbbbbb".$filtrar_xsn;
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
                                         and products.idproduct in (select distinct idproduct from fnt_select_allproducts_maxrev() where iduniquebranchsonprod like '%000100010038%'  or iduniquebranchsonprod like '%000100010094%' or iduniquebranchsonprod like '%00010091%' or iduniquebranchsonprod like '%00010037%')
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
                                                                 and v_integer = 1  /*  DigitalUnit3 */
                                                         
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
                                                                 and v_integer = 2  /*  DigitalUnit4 */
                                      
                                      
                                                        ) as tienefinalchk on tienefinalchk.unitsn = orders_sn.wo_serialnumber
                                         left join orders_sn as orders_sn_SOassociada on orders_sn_SOassociada.wo_serialnumber = orders_sn.wo_serialnumber  
                                         and
                                                    orders_sn_SOassociada.typeregister = 'SO'
                                                   
                                         left join products as productsso on productsso.idproduct = orders_sn_SOassociada.idproduct 
                                         where orders.idorders = ".$v_idp."   and orders_sn.idnroserie >0 and 
                                         orders_sn.so_soft_external not like '%SO%'  and orders_sn_SOassociada.so_soft_external not like '%RM%'  and  orders_sn.typeregister not like '%UP%' 
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

         //   echo  $sqlbusco;
              
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
                    
            ///      echo  $sqlbusco;
                      $_if_auto_test_box_calibration = "N";
                      $sqllosso->execute();
                      $resultadoslosso = $sqllosso->fetchAll();							
                     
                      foreach ($resultadoslosso as $rowbuscawo) 
                      {
                  //      echo "<br>SO".$rowbuscawo['modelciu'];
                  
                  ?>
                  <div class="track">
               <?php
                  ///// STEP BY XML INIT
                  $query_xml ="

                  select v_integer , json_agg( JSON_BUILD_OBJECT('idattribute_orders',idattribute_orders,'attributedescription', attributedescription,'v_double',v_double,'v_string',v_string)) as jsonmm
                  
                  FROM public.orders_attributes
                  INNER JOIN orders_attributes_type
                  ON orders_attributes_type.idattribute = orders_attributes.idattribute_orders
                  where idorders = ".$v_idp." and  active like 'XML2_WO_OP%'
                  group by v_integer
                  ";
              
                
            //   echo $query_xml;
                 
                $qq_components_xml = 0;
                $partnumber_components_xml = '';
                $partnumberdescrip_components_xml = '';
                $nroitempositio = 100;
                $data_xml = $connect->query($query_xml)->fetchAll();	
                foreach ($data_xml as $rowxml) 
                {
                  ///echo  substr($rowxml['jsonmm'],1,-1);
                  //$arrmm = json_decode( substr($rowxml['jsonmm'],1,-1) , true);
                  $arrmm = json_decode( $rowxml['jsonmm'] , true);  
                
                  //saco el numero de elementos
                    $longitud = count($arrmm);
                 
                  //Recorro todos los elementos
                  $vvsn="";
                      for($imm=0; $imm<=$longitud; $imm++)
                      {
                 
                        $arrmmobj = $arrmm[$imm];    
                        if ( $arrmmobj['idattribute_orders'] == 21)
                        {
                          //echo "<br>la Cantidad es: ".$arrmmobj['v_double'];
                          $steps_name =$arrmmobj['v_string'];
                        }
                
                        if ( $arrmmobj['idattribute_orders'] == 22)
                        {
                          //echo "<br>la Cantidad es: ".$arrmmobj['v_double'];
                          $steps_name_descrip =$arrmmobj['v_string'];
                        }
                        $qq_components_xml =1;
                      
                
                      
                       
                      //  echo "<br>fin puede ejecutar";
                      }
                      ?>
                     
                     
                      <?php
                     
                
                      for($immt=0; $immt< $qq_components_xml; $immt++)
                      {
                      
                          if ($_REQUEST['typeisdo']=="WO")
                          {
                         //    echo "WO-SO".$rowbuscawo['so_soft_external']."<br><br>";
                             $elsowomarco = $rowbuscawo['so_soft_external'];
                             $elmodelciu = $rowbuscawo['modelciu'];
                      //       echo "WO-SO".   $elmodelciu."<br><br>";
                          }
                          if ($_REQUEST['typeisdo']=="SO")
                          {
                       //      echo "WO-SO".$rowbuscawo['tienesoasociada']."<br><br>";
                             $elsowomarco = $rowbuscawo['tienesoasociada'];
                             $elmodelciu = $rowbuscawo['tienesomodelciuso'];
                        //     echo "WO-SO".   $elmodelciu."<br><br>";
                          }

                        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                ///////////////// wo_info_step1 //////////////////////////  
                                if  ($steps_name =="ASSY")
                                {
                                  ?>
                    
                                  <div class="stepazul   active"> 
                                
                                  <a href="#" onclick="show_info('orderinfo','<?php echo $rowbuscawo['wo_serialnumber']; ?>','<?php echo $v_idp; ?>','<?php echo $nombre_a_mostrar_en_dvi; ?>',0,0)">
                                
                                  <span class="icon"> <i class="fa fa-check"></i> </span>
                                      <span class="text text-left">
                                    
                                      <b>  <?php echo "".$rowpasos['nametrackingstepsshow']."<br>"; ?>   
                                      WO: [<?php echo $rowbuscawo['so_soft_external']; ?>]<br>CIU: [<?php echo $rowbuscawo['modelciu']; ?>]</b> 
                                      <br><b> SN Generated: [<?php echo $rowbuscawo['wo_serialnumber']; ?>]</b><br><?php echo  $activo_paso1_processfasserver;?>
                                    </a>
                                    <span class='text text-left'>
                                  <a href="#"  onclick="Call_printlabel('<?php echo $rowbuscawo['modelciu']; ?>', '<?php echo $rowbuscawo['wo_serialnumber']; ?>' ,'<?php echo $v_idp; ?>')">&nbsp; <i class="fas fa-print"></i> - Print Label
                                  <br><br>
                                  </a>
                                </span>
                                  </span> 
                              
                                  </div>
                                  <?php
                                    $sqldetectchkeopicki="SELECT distinct   orders_sn_components.wo_serialnumber 
                                    FROM public.orders_sn_components_xml as orders_sn_components 
                                 
                                  inner join orders_sn
                                  on orders_sn.idorders = orders_sn_components.idorders and 
                                  orders_sn.idproduct = orders_sn_components.idproduct and
                                  orders_sn.so_soft_external = '".$elsowomarco."'  where orders_sn_components.wo_serialnumber= '".$rowbuscawo['wo_serialnumber']."'";
                                    
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
                                    
                                      <a href="#" onclick="show_info('picking','<?php echo $rowbuscawo['wo_serialnumber']; ?>','<?php echo $elsowomarco; ?>','<?php echo $elmodelciu; ?>','Quality Calibration Precheck',   '<?php echo $steps_name; ?>'  )">
                                      <span class="icon"> <i class="fas fa-tasks"></i> </span> 
                                      <span class="text">  <b>Assy Walkthrough  <br>SN [<?php echo $rowbuscawo['wo_serialnumber']; ?>] <br></b></span>
                                    
                                                            
                                      </div>             
                                      </a>     
                                      <?php
                                }
                                else
                                {
                                  if  ($steps_name =="PRECHECK")
                                  {
                                       /////**************PRE CHEQUEO************************************** 
                                              //// sumamos un paso aqui prechech  Precheck
                                              $sqldetectchkeo="SELECT   status_sn  FROM public.fas_survey_responses_bysn where  idsurvey = 1 and sn = '".$rowbuscawo['wo_serialnumber']."' and  so = '". $elsowomarco ."' and modelciu = '".$elmodelciu."'
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

                                              <a href="#" onclick="show_info('Precheck','<?php echo $rowbuscawo['wo_serialnumber']; ?>','<?php echo  $elsowomarco; ?>','<?php echo $elmodelciu; ?>','Quality Calibration Precheck',0)">
                                              <span class="icon"> <i class="fas fa-tasks"></i> </span> 
                                              <span class="text">  <b>Quality Precheck   <br>SN [<?php echo $rowbuscawo['wo_serialnumber']; ?>] <br></b></span>
                                              <?php
                                              $sqldetectchkeo="SELECT   status_sn  FROM public.fas_survey_responses_bysn where idsurvey = 1 and  sn = '".$rowbuscawo['wo_serialnumber']."' and  so = '". $elsowomarco."' and modelciu = '".$elmodelciu."'
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
                                  else
                                  {

                                  

                              //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                            // echo $steps_name." - ".$steps_name_descrip  ;
                                //                        Create_vinculation_sn_componetns($nroitempositio.$immt,$vvsn,$partnumber_components_xml,$partnumberdescrip_components_xml  );
                                ?>
                                        <div class="stepazul "> 

                                        <a href="#" onclick="show_info('picking','<?php echo $rowbuscawo['wo_serialnumber']; ?>','<?php echo  $elsowomarco; ?>','<?php echo $elmodelciu; ?>','Quality Calibration Precheck','<?php echo $steps_name; ?>')">
                                        

                                        <span class="icon"> <i class="fa fa-check"></i> </span>
                                          <span class="text text-center">

                                            <?php echo "".$steps_name."<br>"; ?>   
                                    
                                        
                                    
                                        </a>
                                        </span>
                                        </span> 

                                        </div>
                                        <?php
                                        }
                                        //cierra if de PREcheck
                                      }
                              $nroitempositio = $nroitempositio+1;
                      }
                      ?>
                        
                       
                      <?php
                 
                
                }
                
                  ////// STEP BY XML end1
                  
                  ?>
                  
                  </div>
                  
                  <br><br> 
                  <br><hr><br>  
                  <?php
                         
                     


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




<script src="js/eModal.min.js" type="text/javascript" >
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>


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

                  $(function() { $("#daterangem").daterangepicker({ dateFormat: "(yy-mm-dd)"}); });
                  	 // AutoComplete de CUIS version TOP

     

function formatRepo (repo) {
	
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
    $container.find(".select2-result-repository__avatar").html('<h2><b>'+repo.img+'</b></h2>');
    $container.find(".select2-result-repository__forks").append("101" + " Forks");
    $container.find(".select2-result-repository__stargazers").append("102" + " Stars");
    $container.find(".select2-result-repository__watchers").append("103" + " Watchers");
  //  console.log(repo.text);
    return $container;
  }
  
  function formatRepoSelection (repo) {
      // console.log('1' + repo.text);
    return repo.full_name || repo.text;
  }
  

     $('#txtlistcius').select2({
 ajax: {
    url: "ajax_list_searchalltracking.php",
    dataType: 'json',
    delay: 2,
    data: function (params) {
      return {
        q: params.term, // search term
        page: params.page
      };
    },
    processResults: function (data) {
      // Transforms the top-level key of the response object from 'items' to 'results'
      return {
        results: data.items
      };    
    },
    cache: false
  },
  placeholder: 'Search WO / SO / SN',
  minimumInputLength: 1 ,
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
     		

		
	  
   
   function show_log(idlog_view)
   {
	 	   
	 $("#detallelog").fadeOut('fast');  
	  $("#msjwait").fadeIn('slow');   
		
		 $("#uso").val(1);
		 
	    $.ajax
			({ 
				url: 'readlogbyruninfo.php',
				data: "idlog="+idlog_view,	
				type: 'post',
				async:true,
                cache:false,
				success: function(data)
				{
					var datax = JSON.parse(data)
				//	console.log(datax);
                 //   console.log(datax.vuser);
					
					//detallelog
					 $("#msjwait").hide();
					 	$("#detallelog").fadeIn(100);						
						//var re = /<TERM>/g; 						
						$("#detallelog").html(datax.data.replace(/<br>/g,' \r\n'));
						
						if ($( window ).height()>800)
						{
							$("#detallelog").height(585);
						}
						
						
						$( window ).height();
						
						$('#lblvuser').text(datax.vuser.replace("#"," "));
						$('#lblvdevice').text(datax.vdecice.replace("#"," "));
						var anex = "'"+idlog_view+"'" ;
						
						$('#lblvstationr').html(datax.vstation.replace("#"," ") +' <a href="#" onclick="show_log2('+anex	+')") ><i class="fas fa-bug" style="color:blue"></i></a>');
					
				}
			});
   }
     function show_log2(idlog_view)
   {
	 	   
	 	 	   
	 $("#detallelog").fadeOut('fast');  
	  $("#msjwait").fadeIn('slow');   
		
		 $("#uso").val(1);
		 
	    $.ajax
			({ 
				url: 'readlogbyruninfodebug.php',
				data: "idlog="+idlog_view,	
				type: 'post',
				async:true,
                cache:false,
				success: function(data)
				{
					var datax = JSON.parse(data)
				//	console.log(datax);
                 //   console.log(datax.vuser);
					
					//detallelog
					 $("#msjwait").hide();
					 	$("#detallelog").fadeIn(100);						
						//var re = /<TERM>/g; 						
						$("#detallelog").html(datax.data.replace(/<br>/g,' \r\n'));
						$('#lblvuser').text(datax.vuser.replace("#"," "));
						$('#lblvdevice').text(datax.vdecice.replace("#"," "));
						var anex = "'"+idlog_view+"'" ;
						
						$('#lblvstationr').html(datax.vstation.replace("#"," ") +' <a href="#" onclick="show_log('+anex	+')") ><i class="fas fa-bug" style="color:green"></i></a>');
					
				}
			});
			
   }


   $("#txtlistcius").change(function(){
				var datosmm = $("#txtlistcius").val().split("#");	
            console.log( $("#txtlistcius").val());
            window.location = 'trackingorders.php?isdo='+datosmm[0]+'&typeisdo='+datosmm[1]+'&encont='+datosmm[2];
   });


   function popuplogdb(idrunifno)
   {
    eModal.iframe('logdbonlydet.php?idab='+idrunifno,'Log Activity');
   }

  function attachanalogbda(vidord,lasemillita )
  {
    eModal.iframe('attachfileprojectsoaddmoreanalogbda.php?idt='+lasemillita+'&idord='+vidord,'Attach files to SN	  ');
  }

   function show_info(desdedonde,snparam, soparam, sotextoamostrar, idruninfoparam, idparamafterburning)
   {
     ///aca tenia un error
 ///   $("#artSO").CardWidget('collapse');
  //    $("#artSO").Widget("collapse"); 
 //     $("#artSO").collapse("hide"); 
    var armando_tabla_info='';
    $('#titudetalle').html('Searching');
    $('#divdetalles').html("");
    toastr["info"]("SN: "+snparam, "Searching")

    
       ///////////////////////////////////////////////////////////////////////////////////////
       ///show_info('calibrationyburchk','21076433FU','623','Calibration :: SN: 21076433FU','10954067627')
    if (desdedonde =='calibrationentermater')
    {
      eModal.iframe('https://webfas.honeywell.com/calibrationentermastermth.php?sn='+snparam+'&hidmenu=Y&idruninfo='+idruninfoparam,'Calibration Enterprise Master ');
    }

       if (desdedonde =='calibrationyburchk')
    {
      eModal.iframe('https://webfas.honeywell.com/autotestboxtimeline.php?hidmenu=Y&idr='+idruninfoparam,'Calibration & Burnin Check ');
     
    }
    ////////////////////////////////////////////////////////////////////////////////////////

     ///////////////////////////////////////////////////////////////////////////////////////
     if (desdedonde =='PrecheckBBUANN')
    {
      eModal.iframe('calibrationqualitychecklisallsurvery.php?elsn='+snparam+'&elso='+soparam+'&elciu='+sotextoamostrar,'BBU ANN Acceptance Test');
     
    }
    ////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////
    if (desdedonde =='picking')
    {
      eModal.iframe('wopickingsteps.php?elso='+soparam+'&elsn='+snparam+'&elciu='+sotextoamostrar+'&typeworkc='+idparamafterburning,' ' + snparam + ' || ' + soparam + ' || ' + sotextoamostrar );
    }
    ////////////////////////////////////////////////////////////////////////////////////////
     if (desdedonde =='orderinfo')
     {

      eModal.iframe('show_tracking_orderinfo.php?soparam='+soparam+'&snparam='+snparam,sotextoamostrar);
    
        
        
     }

     if (desdedonde =='polypaste')
     {
////show_tracking_polypaste.php?soparam=160&snparam=21036195FU
        eModal.iframe('show_tracking_polypaste.php?soparam='+soparam+'&snparam='+snparam,'Poly Paste');
     }
     ////////////////////////////////////////////////////////////////////////////////////////
     if (desdedonde =='acceptance')
     {
      eModal.iframe('acceptflex.php?idsndib='+snparam+'&logo=N',sotextoamostrar);
    
         
     }
//////////////////////////////////////////////////////////////////////////////////////////////////
if (desdedonde =='finalchk')
     {
      eModal.iframe('finalchkallband.php?dnd=WO&idsndib='+snparam+'&idmb=9&iduldl=9&idruninfo='+idruninfoparam,sotextoamostrar);
    
     
     }
     ////////////////////////////////////////////////////////////////////////////////////////
   if (desdedonde =='finalchkenterpriseremoto')
   {
    eModal.iframe('autotestcalibrationenterremotemthafterbur.php?hidmenu=Y&sn='+snparam+'&idmb=0&iduldl=0&&idruninfo='+idruninfoparam,sotextoamostrar);
   }  
//////////////////////////////////////////////////////////////////////////////////////////////////
   if (desdedonde =='finalchkenterprisemaster')
   {
    eModal.iframe('finalchkentermastermth.php?hidmenu=Y&sn='+snparam+'&idmb=0&iduldl=0&&idruninfo='+idruninfoparam,sotextoamostrar);
   }  
//////////////////////////////////////////////////////////////////////////////////////////////////
if (desdedonde =='calibration')
     {
      eModal.iframe('equalizeriir.php?idsndib='+snparam+'&idmb=0&iduldl=0&idruninfo='+idruninfoparam,sotextoamostrar);
     
       
     }

     if (desdedonde =='calibrationentremmth')
     {
      eModal.iframe('autotestcalibrationenterremotemth.php?hidmenu=Y&sn='+snparam+'&idmb=0&iduldl=0&&idruninfo='+idruninfoparam,sotextoamostrar);
     
       
     }
     
     if (desdedonde =='finalchksorma_enterprisemater')
     {
       
      eModal.iframe('https://webfas.honeywell.com/finalchkentermastermth.php?sn='+snparam+'&hidmenu=Y&idruninfo='+idruninfoparam,'Final Check Enterprise Master ');
       
     }
     
     
     ////////////////////////////////////////////////////////////////////////////////////////
     
     //////////////////////////////////////////////////////////////////////////////////////////////////
if (desdedonde =='finalchkso')
     {

      eModal.iframe('finalchkallband.php?dnd=SO&idsndib='+snparam+'&idmb=9&iduldl=9&idruninfo='+idruninfoparam+'&idrunaferbur='+idparamafterburning,sotextoamostrar);
     
     }

     if (desdedonde =='finalchksotemp')
     {

      eModal.iframe('finalchkallband.php?dnd=SO&tempso=OO&idsndib='+snparam+'&idmb=9&iduldl=9&idruninfo='+idparamafterburning+'&idrunaferbur='+idparamafterburning,sotextoamostrar);
     
     }
     ////////////////////////////////////////////////////////////////////////////////////////
     if (desdedonde =='Precheck')
     {

      eModal.iframe('calibrationqualitychecklist.php?elsn='+snparam+'&elso='+soparam+'&elciu='+sotextoamostrar,'Quality precheck');
     
     }
      
     if (desdedonde =='PrecheckBBUscs')
     {

      eModal.iframe('calibrationqualitychecklistbbuscs.php?elsn='+snparam+'&elso='+soparam+'&elciu='+sotextoamostrar,'BBU Integration Checklist');
     
     }

      ////////////////////////////////////////////////////////////////////////////////////////
      if (desdedonde =='Precheckultest')
     {

      eModal.iframe('electricstrengthchecklist.php?elsn='+snparam+'&elso='+soparam+'&elciu='+sotextoamostrar,'Quality UlTest');
     
     }
     
     if (desdedonde =='Precheckfinalcheck')
     {

      eModal.iframe('surveyfinalcheck.php?elsn='+snparam+'&elso='+soparam+'&elciu='+sotextoamostrar,'Final Inspection');
     
     }

     //reportburnin
     if (desdedonde =='reportburnin')
     {

      //eModal.iframe('report_burnin.php?hidmenu=Y&idr='+idruninfoparam,'Report Burning');
      eModal.iframe('burningtestreport.php?hidmenu=Y&sn='+snparam+'&idruninfo='+idruninfoparam,'Report Burning');
     
     }

     if (desdedonde =='orderinfoupgrade')
     {
//// show_info(desdedonde,snparam, soparam, sotextoamostrar, idruninfoparam, idparamafterburning)
      //eModal.iframe('report_burnin.php?hidmenu=Y&idr='+idruninfoparam,'Report Burning');
      eModal.iframe('show_upgrade_orderinfo.php?hidmenu=Y&sn='+snparam+'&soparam='+soparam+'&sotextoamostrar='+sotextoamostrar,'Upgrade Info');
     
     }
     /////asingsnwotoso
     if (desdedonde =='asingsnwotoso')
     {
//// show_info(desdedonde,snparam, soparam, sotextoamostrar, idruninfoparam, idparamafterburning)
      //eModal.iframe('report_burnin.php?hidmenu=Y&idr='+idruninfoparam,'Report Burning');
      eModal.iframe('show_tracking_assignsn_wotoso.php?hidmenu=Y&sn='+snparam+'&soparam='+soparam+'&sotextoamostrar='+sotextoamostrar,'Assing SN ');
     
     }
     


      
           
  //   $("#artSO").CardWidget('collapse');

   }

function Assign_sn(idorders_a_setear, elsoamostrar)
{

eModal.iframe('show_tracking_assignsn.php?idso='+idorders_a_setear+'&elnomso='+elsoamostrar,'Assign SN to SO:' +elsoamostrar);
     
///show_tracking_assignsn.php

}

   function Call_printlabel(vpara_ciu,vparam_sn, vparamidorders)
	{
			var ipservidorapache= '<?php echo $ipservidorapache; ?>';	
		eModal.iframe('https://'+ipservidorapache+'/labelprintermultisn.php?vciu='+vpara_ciu+'&vsn='+vparam_sn+'&vidord='+vparamidorders,'Label printing');
		$('.embed-responsive-item').height(380);
	//	console.log('si');
		

				setTimeout(function() {
								$('.embed-responsive-item').height(620);
							},300);
							
							
	}	

  function Call_printlabel_upgrade(vpara_ciu,vparam_sn, vparamidorders)
	{
			var ipservidorapache= '<?php echo $ipservidorapache; ?>';	
		eModal.iframe('https://'+ipservidorapache+'/labelprintermultisn.php?isup=Y&vciu='+vpara_ciu+'&vsn='+vparam_sn+'&vidord='+vparamidorders,'Label printing');
		$('.embed-responsive-item').height(380);
	//	console.log('si');
		

				setTimeout(function() {
								$('.embed-responsive-item').height(620);
							},300);
							
							
	}	

  function savechristian(paramsndewo, numeroso)
  {
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
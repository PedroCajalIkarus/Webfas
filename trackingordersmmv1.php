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
                  $jsondatarange = $_REQUEST['daterangem'];
                  if ( $jsondatarange <>"")
                  {
                   
                    $objfecha = json_decode($jsondatarange);
              //      echo "<br>start:marco:".$objfecha->{'start'};
              //      echo "<br>end:marco:".$objfecha->{'end'};
                    echo "<b>    Custom Search: ".  $jsondatarange."</b>";

                    $wheredaterange=" and runinfodb.dateserver  BETWEEN '".$objfecha->{'start'}."' AND '".$objfecha->{'end'}." 23:59:00' ";
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


                                           and orders_sn.idnroserie >0  and orders_sn.so_soft_external not like '%SO%'
                              order by orr desc, wo_serialnumber   
                          ";
                     //         echo  $sqlrange;
 
                       $v_idp = $_REQUEST['isdo'];
                       $filtrar_xsn = substr($_REQUEST['encont'],-2);
                       $snafiltrar =  $_REQUEST['encont'];
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
                                                          where orders.idorders in (select idorders from orders_sn where  so_associed in (select so_soft_external from orders_sn where idorders = ".$v_idp."))  and calibrationscript = true 
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
                                                          where orders.idorders in (select idorders from orders_sn where so_associed in (select so_soft_external from orders_sn where idorders = ".$v_idp."))
                                                           and calibrationscript = false
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
                                                    left join orders_sn as orders_sn_SOassociada
                                                    on orders_sn_SOassociada.wo_serialnumber   = orders_sn.wo_serialnumber and
                                                    orders_sn_SOassociada.typeregister = 'SO'
                                                    left join  products as productsso
                                                    on productsso.idproduct = orders_sn_SOassociada.idproduct
                                              
                                        where orders.idorders in (select idorders from orders_sn where so_associed in (select so_soft_external from orders_sn where idorders = ".$v_idp.")) 
                                                      and orders_sn.idnroserie >0 and  orders.idorders <> orders_sn_SOassociada.idorders    and orders_sn.wo_serialnumber = '".$snafiltrar."'
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
                                                          where orders.idorders = ".$v_idp." and calibrationscript = false
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
                                                    left join orders_sn as orders_sn_SOassociada
                                                    on orders_sn_SOassociada.wo_serialnumber   = orders_sn.wo_serialnumber and
                                                    orders_sn_SOassociada.typeregister = 'SO'
                                                    left join  products as productsso
                                                    on productsso.idproduct = orders_sn_SOassociada.idproduct
                                              
                                        where orders.idorders = ".$v_idp."    and orders_sn.wo_serialnumber = '".$snafiltrar."' 
                                                      and orders_sn.idnroserie >0  and orders_sn.so_soft_external not like '%SO%'
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
                                              
                                        where orders.idorders = ".$v_idp." --- and orders_sn.wo_serialnumber = '21016087FU'
                                                      and orders_sn.idnroserie >0 
                                         order by orders_sn.wo_serialnumber ";
                       }
                       if (  $filtrar_xsn =="SO" || $filtrar_xsn =="RM"  )
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
                                                      and orders_sn.idnroserie >0  
                                         order by orders_sn.wo_serialnumber ";
                       }
                             
                  //////////////////////////// //////////////////////////////
                  //////////////////////////// //////////////////////////////
                  ?>

                  </div>

                  <div class="track1">
                  <?php
              
                  if ( $jsondatarange <>"" || $sqlbusco <>"" )
                  {
                    if ( $jsondatarange <>"")
                    {
                      $sqllosso = $connect->prepare( $sqlrange);
                    }
                    if (  $sqlbusco <>"" )
                    {    
                     // echo $sqlbusco;
                      $sqllosso = $connect->prepare( $sqlbusco);
                    }
                    

                      $sqllosso->execute();
                      $resultadoslosso = $sqllosso->fetchAll();							
                     
                      foreach ($resultadoslosso as $rowbuscawo) 
                      {
                  //      echo "<br>SO".$rowbuscawo['modelciu'];
                  ?>
                  <div class="track">
                 <?php
                              ////// VAMOS con el armado dinamico de pasos
                              $modelcui_mostrarerror =trim($rowbuscawo['modelciu']);
                           $armosqlpasos="select * 
                           from business_tracking_steps
                           inner join tracking_steps
                           on tracking_steps.idtrackingsteps = business_tracking_steps.idtrackingstep
                               where iduniquebranchprodson in (select distinct iduniquebranchsonprod from   fnt_select_allproducts_maxrev()  where active = 'Y' and  modelciu = '".trim($rowbuscawo['modelciu'])."' ) ";
//echo "<br>".$armosqlpasos;
                              $sqlpasos = $connect->prepare($armosqlpasos);

                              $sqlpasos->execute();
                              $resultadospasoss = $sqlpasos->fetchAll();							
                             $tienepasos=0;
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
                                                  $ciuisdas="N";
                                                  $sqldetect="select fnt_select_detect_bysn_isbda_isdas('".$rowbuscawo['wo_serialnumber']."','WO') ";
                                                //	echo "test:".$sqldetect;
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

                                                        if ($rowbuscawo['modelciu']=="DH7S-A" || $rowbuscawo['modelciu']=="DH7S-D"  || $rowbuscawo['modelciu']=="BTTY-100" )
                                                        {

                                                        


                                                        $sqldetectchkeopicki="SELECT distinct   orders_sn_components.wo_serialnumber 
                                                        FROM public.orders_sn_components
                                                      inner join components_types
                                                      on components_types.idtypecomponets = orders_sn_components.idtypecomponets
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
                                                        
                                                          <a href="#" onclick="show_info('picking','<?php echo $rowbuscawo['wo_serialnumber']; ?>','<?php echo $rowbuscawo['so_soft_external']; ?>','<?php echo $rowbuscawo['modelciu']; ?>','Quality Calibration Precheck',0)">
                                                          <span class="icon"> <i class="fas fa-tasks"></i> </span> 
                                                          <span class="text">  <b>Picking  <br>SN [<?php echo $rowbuscawo['wo_serialnumber']; ?>] <br></b></span>
                                                        
                                                                                
                                                          </div>             
                                                          </a>     
                                                          <?php
                                                          }
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

                                              <a href="#" onclick="show_info('Precheck','<?php echo $rowbuscawo['wo_serialnumber']; ?>','<?php echo $rowbuscawo['so_soft_external']; ?>','<?php echo $rowbuscawo['modelciu']; ?>','Quality Calibration Precheck',0)">
                                              <span class="icon"> <i class="fas fa-tasks"></i> </span> 
                                              <span class="text">  <b>Quality Precheck   <br>SN [<?php echo $rowbuscawo['wo_serialnumber']; ?>] <br></b></span>
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
                                              
                                              <a href="#" onclick="show_info('Precheckultest','<?php echo $rowbuscawo['wo_serialnumber']; ?>','<?php echo $rowbuscawo['so_soft_external']; ?>','<?php echo $rowbuscawo['modelciu']; ?>','Quality Calibration Precheck',0)">
                                                <span class="icon"> <i class="fas fa-tasks"></i> </span> 
                                              <span class="text">  <b>UL Test   <br>SN [<?php echo $rowbuscawo['wo_serialnumber']; ?>] <br></b></span>
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
                                          if ($rowpasos['stepfunction']=="wo_calibration")
                                          {
                                             /////**************************************************** 

                                                if ( $rowbuscawo['tienecalibracion_idruninfo'] >0)
                                                {
                                                    if(  $ciuisenterprice=="Y" &&  $ciuisremote=="Y")
                                                    {
                                                      ?>
                                                  <div class="step <?php echo  $activo_paso3; ?>">  <a href="#" onclick="show_info('finalchk','<?php echo $rowbuscawo['wo_serialnumber']; ?>','<?php echo $v_idp; ?>','<?php echo $nombre_a_mostrar_en_dvi_calib; ?>','<?php echo $rowbuscawo['tienecalibracion_idruninfo']; ?>',0)"> <span class="icon">  <i class="fa fa-box"></i> </span> <span class="text"><b>Calibration <br> <?php echo $activo_paso3_totalpass; ?></span></a></b> </div>
                                                  <?php
                                                    }
                                                    else
                                                    {
                                                      ?>
                                                      <div class="step <?php echo  $activo_paso3; ?>">  <a href="#" onclick="show_info('calibration','<?php echo $rowbuscawo['wo_serialnumber']; ?>','<?php echo $v_idp; ?>','<?php echo $nombre_a_mostrar_en_dvi_calib; ?>','<?php echo $rowbuscawo['tienecalibracion_idruninfo']; ?>')"> <span class="icon">  <i class="fa fa-box"></i> </span> <span class="text"><b>Calibration <br> <?php echo $activo_paso3_totalpass; ?></span></a></b> </div>
                                                      <?php
                                                    }
                                                
                                                }
                                                else
                                                {
                                                  ?>
                                                  <div class="step ">  <span class="icon">  <i class="fa fa-box"></i> </span> <span class="text">Calibration<br></span> </div>
                                                  <?php
                                                }

                                                  
                                                
                                                ///////////////////////////////////////////////////////
                                          }

                                          ///////////////// wo_calibration //////////////////////////  
                                          ///////////////// wo_afterburning //////////////////////////
                                          if ($rowpasos['stepfunction']=="wo_calibration")
                                          {
                                             ///////////////////////////////////////////////////////
                  
                                              if ( $rowbuscawo['tienefinalchk_idruninfo'] >0)
                                              {
                                                $idruninfoAfertburnung= $rowbuscawo['tienefinalchk_idruninfo'] ; 
                                              ?>
                                              <div class="step <?php echo  $activo_paso4; ?>">
                                              <a href="#" onclick="show_info('finalchk','<?php echo $rowbuscawo['wo_serialnumber']; ?>','<?php echo $v_idp; ?>','<?php echo $nombre_a_mostrar_en_dvi_finalchk; ?>','<?php echo $rowbuscawo['tienefinalchk_idruninfo']; ?>',0)"><span class="icon"><i class="fa fa-box"></i> </span> <span class="text"><b>After Burning Check<br>
                                                <?php echo $activo_paso4_totalpass; ?></span></a> </b>
                                                <br> <a href="calibrationtopdfconimg.php?idsndib=<?php echo  $rowbuscawo['wo_serialnumber']; ?>&amp;iduldl=0&amp;idmb=0" target="_blank">  <i class='fas fa-file-pdf'></i> - View Report</a>
                                                </a><br> 
                                                
                                                </div>
                                              <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <div class="step <?php echo  $activo_paso4; ?>"> <span class="icon"><i class="fa fa-box"></i> </span> <span class="text">After Burning Check<br> </span></div>
                                                <?php  
                                            }

                                          }

                                          ///////////////// wo_afterburning //////////////////////////  
                                          ///////////////// so_info-finalcheck //////////////////////////
                                          if ($rowpasos['stepfunction']=="so_info-finalcheck")
                                          {

                                             /////////////////// VAMOS POR LOS PASOS DE SO

                                              ///    tienesoasociada
                                                  $nombre_ciu_amostrar="";
                                                  if ( $rowbuscawo['tienesoasociada'] =="")
                                                  {
                                                    ?>
                                                    <div class="stepazul">
                                                    
                                                    <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text"><b>SO:<?php //echo $rowbuscawo['tienesoasociada']; ?> <br>CIU : <?php //echo  $ciutemp; ?></b>
                                                    </span> </div>
                                                    <div class="step  "> <span class="icon"> <i class="fa fa-box"></i> </span> <span class="text">Final Check</span> </div>
                                                    <?php
                                                  }
                                                  else
                                                  {
                                                    $nombre_a_mostrar_en_dvi_paraSO ='Order Detail :: SO:'.$rowbuscawo['tienesoasociada']." - SN: ".$rowbuscawo['wo_serialnumber'];
                                                    $nombre_ciu_amostrar = $rowbuscawo['tienesomodelciuso']
                                                    ?>
                                                    <a href="#" onclick="show_info('orderinfo','<?php echo $rowbuscawo['wo_serialnumber']; ?>','<?php echo $rowbuscawo['idordersso']; ?>','<?php echo $nombre_a_mostrar_en_dvi_paraSO; ?>',0,0)">
                                                    <div class="stepazul active "><span class="icon"> <i class="fa fa-check"></i> </span> <span class="text"><b>SO:<?php echo $rowbuscawo['tienesoasociada']; ?> <br>CIU : <?php echo  $rowbuscawo['tienesomodelciuso']; ?><br>SN Assign :  <?php echo $rowbuscawo['wo_serialnumber']; ?></b></span>
                                                    </a>  
                                                    <a href="#" onclick="Call_printlabel('<?php echo $rowbuscawo['tienesomodelciuso']; ?>', '<?php echo $rowbuscawo['wo_serialnumber']; ?>' ,'<?php echo $rowbuscawo['idordersso']; ?>')">&nbsp; <i class="fas fa-print"></i> - Print Label</a>
                                                    </div>
                                                    <?php
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
                                                      and modelciu not in( select distinct  modelciu from products where  idproduct in (select distinct idproduct from products_attributes where v_boolean= true and idattribute = 0)) 
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
                                        ///  echo "a ver".$nombre_ciu_amostrar;
                                          if (substr($nombre_ciu_amostrar ,0,3)=="DH7")
                                          {
                                          /// $idruninfoAfertburnung=0;
                                          $tipolinkweb="finalchkso";
                                          }
                                          else
                                          {
                                            $idruninfoAfertburnung=0;
                                            $tipolinkweb="finalchksotemp";
                                          }
                                          ///////////////////////////////////////////////////////
                                                  $entroaverfinalch=0;
                                                  foreach ($resultsofinalchk as $rowspfinalchk)
                                                  {
                                                    $entroaverfinalch=1;
                                                    if ( $rowspfinalchk['totalpassso'] ==1)
                                                    {
                                                      ?>
                                                      <div class="step active  ">
                                                      <a href="#" onclick="show_info('<?php echo  $tipolinkweb; ?>','<?php echo $rowbuscawo['wo_serialnumber']; ?>','<?php echo $rowbuscawo['idordersso']; ?>','<?php echo $nombre_a_mostrar_en_dvi_finalchkso; ?>','<?php echo $rowspfinalchk['idruninfo']; ?>','<?php echo  $idruninfoAfertburnung;?>')">
                                                        <span class="icon"> <i class="fa fa-box"></i> </span> <span class="text">Final Check </span> <span class='badge bg-success'>Passed</span>
                                                        <br><a href='#' onclick='popuplogdb(<?php echo $rowspfinalchk['idruninfo']; ?>)'  style='color:#f39323;'> <i class='fas fa-eye'></i> - View Log </a>
                                                        </a>
                                                        <br><a href="calibrationtopdfconimgsaleorders.php?idsndib=<?php echo  $rowbuscawo['wo_serialnumber']; ?>&amp;iduldl=0&amp;idmb=0&idrunaferbur=<?php echo $idruninfoAfertburnung;?>" target="_blank">  <i class='fas fa-file-pdf'></i> -  View Report </a>
                                                        <br>
                                                        </div>
                                                      <?php
                                                    }
                                                    else
                                                    {
                                                      ?>
                                                      <div class="step active  ">
                                                      <a href="#" onclick="show_info('<?php echo  $tipolinkweb; ?>','<?php echo  $rowbuscawo['wo_serialnumber']; ?>','<?php echo $rowbuscawo['idordersso']; ?>','<?php echo $nombre_a_mostrar_en_dvi_finalchkso; ?>','<?php echo $rowspfinalchk['idruninfo']; ?>','<?php echo  $idruninfoAfertburnung;?>')">
                                                      <span class="icon"> <i class="fa fa-box"></i> </span> <span class="text">Final Check </span> <!-- <span class='badge bg-danger'>Not Passed</span> <br> -->
                                                      
                                                      <a href='#' onclick='popuplogdb(<?php echo $rowspfinalchk['idruninfo']; ?>)'  style='color:#f39323;'> <i class='fas fa-eye'></i>-  View Log </a>
                                                      <br> <a href="calibrationtopdfconimgsaleorders.php?idsndib=<?php echo  $rowbuscawo['wo_serialnumber']; ?>&amp;iduldl=0&amp;idmb=0" target="_blank">  <i class='fas fa-file-pdf'></i> - View Report</a>
                                                      </a><br> </div>
                                                      <?php
                                                    }
                                                    break;
                                                  } 

                                                  if ($entroaverfinalch==0)
                                                  {
                                                    ?>
                                                    
                                                    <div class="step  "> <span class="icon"> <i class="fa fa-box"></i> </span> <span class="text">Final Check</span> </div>
                                                    <?php
                                                  }

                                                




                                                  ?>
                                                  <?php
                                                  }


                                          }

                                          ///////////////// so_info-finalcheck //////////////////////////  
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
                                                      
                                                      <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text"><b>SO:<?php //echo $rowbuscawo['tienesoasociada']; ?> <br>CIU : <?php //echo  $ciutemp; ?></b>
                                                      </span> </div>
                                                     
                                                      <?php
                                                    }
                                                    else
                                                    {
                                                      $nombre_a_mostrar_en_dvi_paraSO ='Order Detail :: SO:'.$rowbuscawo['tienesoasociada']." - SN: ".$rowbuscawo['wo_serialnumber'];
                                                      $nombre_ciu_amostrar = $rowbuscawo['tienesomodelciuso']
                                                      ?>
                                                      <a href="#" onclick="show_info('orderinfo','<?php echo $rowbuscawo['wo_serialnumber']; ?>','<?php echo $rowbuscawo['idordersso']; ?>','<?php echo $nombre_a_mostrar_en_dvi_paraSO; ?>',0,0)">
                                                      <div class="stepazul active "><span class="icon"> <i class="fa fa-check"></i> </span> <span class="text"><b>SO:<?php echo $rowbuscawo['tienesoasociada']; ?> <br>CIU : <?php echo  $rowbuscawo['tienesomodelciuso']; ?><br>SN Assign :  <?php echo $rowbuscawo['wo_serialnumber']; ?></b></span>
                                                      </a>  
                                                      <a href="#" onclick="Call_printlabel('<?php echo $rowbuscawo['tienesomodelciuso']; ?>', '<?php echo $rowbuscawo['wo_serialnumber']; ?>' ,'<?php echo $rowbuscawo['idordersso']; ?>')">&nbsp; <i class="fas fa-print"></i> - Print Label</a>
                                                      </div>
                                                    <?php
                                                    }
  
  
                                            }
  
                                            ///////////////// so_info_bbu //////////////////////////  
                                         ///////////////// so_final_inspection //////////////////////////
                                         if ($rowpasos['stepfunction']=="so_final_inspection")
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
                                              
                                              <a href="#" onclick="show_info('Precheckfinalcheck','<?php echo $rowbuscawo['wo_serialnumber']; ?>','<?php echo $rowbuscawo['so_soft_external']; ?>','<?php echo $rowbuscawo['modelciu']; ?>','Quality Calibration Precheck',0)">
                                                <span class="icon"> <i class="fas fa-tasks"></i> </span> 
                                              <span class="text">  <b>Final Inspection   <br>SN [<?php echo $rowbuscawo['wo_serialnumber']; ?>] <br></b></span>
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
                                              $sqldetectchkeo="SELECT   status_sn  FROM public.fas_survey_responses_bysn where  idsurvey = 4 and sn = '".$rowbuscawo['wo_serialnumber']."' and  so = '".$rowbuscawo['so_soft_external']."' and modelciu = '".$rowbuscawo['modelciu']."'
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

                                              <a href="#" onclick="show_info('Precheck','<?php echo $rowbuscawo['wo_serialnumber']; ?>','<?php echo $rowbuscawo['so_soft_external']; ?>','<?php echo $rowbuscawo['modelciu']; ?>','Quality Calibration Precheck',0)">
                                              <span class="icon"> <i class="fas fa-tasks"></i> </span> 
                                              <span class="text">  <b>Quality Precheck   <br>SN [<?php echo $rowbuscawo['wo_serialnumber']; ?>] <br></b></span>
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

                                              <a href="#" onclick="show_info('PrecheckBBUscs','<?php echo $rowbuscawo['wo_serialnumber']; ?>','<?php echo $rowbuscawo['so_soft_external']; ?>','<?php echo $rowbuscawo['modelciu']; ?>','Quality Calibration Precheck',0)">
                                              <span class="icon"> <i class="fas fa-tasks"></i> </span> 
                                              <span class="text">  <b>BBU Integration Checklist   <br>SN [<?php echo $rowbuscawo['wo_serialnumber']; ?>] <br></b></span>
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
                                               
                                               <a href="#" onclick="show_info('Precheckfinalcheck','<?php echo $rowbuscawo['wo_serialnumber']; ?>','<?php echo $rowbuscawo['so_soft_external']; ?>','<?php echo $rowbuscawo['modelciu']; ?>','Quality Calibration Precheck',0)">
                                                 <span class="icon"> <i class="fas fa-tasks"></i> </span> 
                                               <span class="text">  <b>Final Inspection   <br>SN [<?php echo $rowbuscawo['wo_serialnumber']; ?>] <br></b></span>
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

                        
                        /////  cierro for de Los pasos
                              }
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
                                    CIU [<?php echo   $modelcui_mostrarerror; ?>] without preloaded steps <br>
                                    Please report this situation to the fas team.
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
                ?>
                </div>
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
            window.location = 'trackingordersmmv1.php?isdo='+datosmm[0]+'&typeisdo='+datosmm[1]+'&encont='+datosmm[2];
   });


   function popuplogdb(idrunifno)
   {
    eModal.iframe('logdbonlydet.php?idab='+idrunifno,'Log Activity');
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
    if (desdedonde =='picking')
    {
      eModal.iframe('wopicking.php?elso='+soparam+'&elsn='+snparam+'&elciu='+sotextoamostrar,'Picking SN:' + snparam);
    }
    ////////////////////////////////////////////////////////////////////////////////////////
     if (desdedonde =='orderinfo')
     {

      eModal.iframe('show_tracking_orderinfo.php?soparam='+soparam+'&snparam='+snparam,sotextoamostrar);
    
        
        
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
//////////////////////////////////////////////////////////////////////////////////////////////////
if (desdedonde =='calibration')
     {
      eModal.iframe('equalizeriir.php?idsndib='+snparam+'&idmb=0&iduldl=0&idruninfo='+idruninfoparam,sotextoamostrar);
     
       
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
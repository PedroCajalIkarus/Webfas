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
            <h1>Tracking Orders SAP  </h1>
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
                
                
                 


                  //////////////////////////// //////////////////////////////

               
                  //    echo  $sqlrange;
 
                       $v_idp = $_REQUEST['isdo'];
                       $filtrar_xsn = substr($_REQUEST['encont'],-2);
                       $snafiltrar =  $_REQUEST['encont'];
                       $typeisdo =  $_REQUEST['typeisdo'];

                      ///////// ACA CAMBIAMOS LA BUSQUEDA SI ES RMA
                    
                             
                  //////////////////////////// //////////////////////////////
                  //////////////////////////// //////////////////////////////
                  ?>

                  </div>

                  <?php if (  $typeisdo <> "")
                  {

              
                  ?>
                  <div class="track1">

               
                  <?php
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
                    
                          echo "<br>mmmmm".$sqlbusco."<br>";
                      //   echo "<br><hr>";
                      $_if_auto_test_box_calibration = "N";
                      $sqllosso->execute();
                      $resultadoslosso = $sqllosso->fetchAll();							
                     
                      foreach ($resultadoslosso as $rowbuscawo) 
                      {
                        echo " </div><br><br><br> <div class='track1'>";
                        //echo "<br><br>SO".$rowbuscawo['modelciu']."-<br>".$rowbuscawo['wo_serialnumber'];
                  
                       ?>
                       <div class="track">
                       <?php
                              ///// STEP BY XML INIT
                              $filtrammeeee = substr( $rowbuscawo['so_associed'] ,-2);
                          
                              $tiene_so_assoc = $rowbuscawo['so_associed'];
                              if ($rowbuscawo['so_associed'] =="")
                              {
                                $tiene_so_assoc = $rowbuscawo['so_soft_external'];
                              }
                                $query_wo=" select distinct 1 as orr, orders.idorders , orders.processfasserver::int as processfasserver, 
                                  products.modelciu,so_associed,
                                  orders.quantity,orders_sn.so_soft_external, orders_sn.wo_serialnumber 
                                                        from orders
                                                        inner join orders_sn 
                                                        on orders_sn.idorders = orders.idorders
                                                        inner join products
                                                        on products.idproduct = orders.idproduct
                                                      
                                                
                                            
                                      where  orders.typeregister not in ('SO','UP') and orders_sn.so_soft_external = '".$tiene_so_assoc."' and wo_serialnumber ='". $rowbuscawo['wo_serialnumber']."'"; 
                                
                          

                   
                             //          echo "<br> 22 Query Principal:".$query_wo."<br><hr>";
                                $data_wo = $connect->query($query_wo)->fetchAll();	
                                $ejecuto_solucionador = 0;
                                $idorderwo="";
                                foreach ($data_wo as $rowwo) 
                                {
                                
                                    $idorderwo =  $rowwo['idorders'];

                                    $ref_wo = $rowwo['so_soft_external'];
                                    $ref_so = $rowwo['so_associed'];
                                    $model_ciu_wo = $rowwo['modelciu'];
                                    $model_ciu =  $rowbuscawo['modelciu'];

                              ///          echo "<hr><br>ref_wo:".$ref_wo."<br>-ref_so:".$ref_so."<br>-model_ciu_wo".$model_ciu_wo."<br>-model_ciu".$model_ciu."<hr><br>";

                                    /// Busco SO.
                                    $query_woso="select idorders from orders_sn where so_soft_external = '".$rowwo['so_associed']."' and wo_serialnumber = '".$rowwo['wo_serialnumber']."' and  typeregister not in ('UP')  ";
                              ///     echo "<br>***query_woso:".$query_woso;
                                    $data_woso = $connect->query($query_woso)->fetchAll();	
                                    foreach ($data_woso as $rowso) 
                                    {
                                      $v_idp =  $rowso['idorders'];
                                    }


                                }
                      
                          ///  echo "--Sali DO.".$idorderwo."--<br>";
                              if ($idorderwo=="")
                              {

                                $idorderwo=0;
                                /////////////////////////////////////////////////////////////////////////////////////////////////
                                $query_wo=" select distinct 1 as orr, orders.idorders , orders.processfasserver::int as processfasserver, 
                                    products.modelciu,so_associed,
                                    orders.quantity,orders_sn.so_soft_external, orders_sn.wo_serialnumber 
                                                        from orders
                                                        inner join orders_sn 
                                                        on orders_sn.idorders = orders.idorders
                                                        inner join products
                                                        on products.idproduct = orders.idproduct
                                                      
                                                
                                              
                                        where  orders.typeregister not in ( 'UP') and orders_sn.so_soft_external = '".$rowbuscawo['so_associed']."' and wo_serialnumber ='". $rowbuscawo['wo_serialnumber']."'"; 
                                  
                            
        
                            
                                // echo "<br> 2 Query Principal:".$query_wo."<br><hr>";
                                  $data_wo = $connect->query($query_wo)->fetchAll();	
                                  $ejecuto_solucionador = 0;
                                  $idorderwo="";
                                  foreach ($data_wo as $rowwo) 
                                  {
                                  
                                      
                                      $v_idp =  $rowwo['idorders'];
                                      $ref_so = $rowwo['so_soft_external'];
                                      $ref_wo = $rowwo['so_associed'];
                                      
                                      $model_ciu =  $rowwo['modelciu'];
        
                                      
        
                                      /// Busco SO.
                                      $query_woso="select idorders from orders_sn  inner join products
                                      on products.idproduct = orders_sn.idproduct where so_soft_external = '".$rowwo['so_associed']."' and wo_serialnumber = '".$rowwo['wo_serialnumber']."' and  typeregister not in ('UP')  ";
                                ///     echo "<br>***query_woso:".$query_woso;
                                      $data_woso = $connect->query($query_woso)->fetchAll();	
                                      foreach ($data_woso as $rowso) 
                                      {
                                        $idorderwo =  $rowso['idorders'];
                                        $model_ciu_wo = $rowso['modelciu'];
                                      }
                                //     echo "<hr><br>ref_wo:".$ref_wo."<br>-ref_so:".$ref_so."<br>-model_ciu_wo".$model_ciu_wo."<br>-model_ciu".$model_ciu."<hr><br>";
        
                                  }

                                /////////////////////////////////////////////////////////////////////////////////////////////////
                                
                              }
                             echo "<br>HOLA HOLA".$v_idp."<-->".$idorderwo."<br><br>";
                            if ( $v_idp ==$idorderwo)
                            {
                              $v_idp="0";
                            }
                            if ( "" ==$idorderwo)
                            {
                              $idorderwo="0";
                            }
                            

                            if ( $filtrar_xsn =="RM" ||  $typeisdo =="SO"   )
                            {

                            $query_xml ="

                            select 22 as ordermm,v_integer ,'so' as typeord , json_agg( JSON_BUILD_OBJECT('idattribute_orders',idattribute_orders,'attributedescription', attributedescription,'v_double',v_double,'v_string',v_string)) as jsonmm
                            
                            from (
                              SELECT  distinct   idorders, idattribute_orders,  v_boolean, v_integer, v_double, v_string, 
                              idattribute, attributedescription, attributename, attdatatype, active 

                            FROM public.orders_attributes
                            INNER JOIN orders_attributes_type
                            ON orders_attributes_type.idattribute = orders_attributes.idattribute_orders
                            where idorders = ".$v_idp." and  active like 'XML2_WO_OP%' and idorders in (select idorders from orders  where idorders = ".$v_idp." and typeregister= 'SO' )
                            ) as fsubselect22
                            group by v_integer,typeord

                            union all select 33, 33,'so'as typeord, '[
                              {
                                \"idattribute_orders\": 21,
                                \"attributedescription\": \"Xml File - Operationes - WorkCenter\",
                                \"v_double\": null,
                                \"v_string\": \"UPGRADELIC\"
                              }
                            ]'::json

                            union all
                            select 11, v_integer  ,'wo' as typeord, json_agg( JSON_BUILD_OBJECT('idattribute_orders',idattribute_orders,'attributedescription', attributedescription,'v_double',v_double,'v_string',v_string)) as jsonmm
                            
                            from (
                              SELECT  distinct   idorders, idattribute_orders,  v_boolean, v_integer, v_double, v_string, 
                              idattribute, attributedescription, attributename, attdatatype, active 

                            FROM public.orders_attributes
                            INNER JOIN orders_attributes_type
                            ON orders_attributes_type.idattribute = orders_attributes.idattribute_orders
                            where idorders = ".$idorderwo." and  active like 'XML2_WO_OP%'  and idorders in (select idorders from orders  where idorders = ".$idorderwo." and typeregister= 'WO' )
                            ) as fsubselect11
                            group by v_integer ,typeord order by ordermm asc ,v_integer
                            ";
                            }
                            else
                            {
                        //     $v_idp = $rowbuscawo['idorders'];
                              $query_xml ="
                              select 33 as ordermm,v_integer ,'wo' as typeord, json_agg( JSON_BUILD_OBJECT('idattribute_orders',idattribute_orders,'attributedescription', attributedescription,'v_double',v_double,'v_string',v_string)) as jsonmm
                              
                              from (
                              SELECT  distinct   idorders, idattribute_orders,  v_boolean, v_integer, v_double, v_string, 
                              idattribute, attributedescription, attributename, attdatatype, active 

                              FROM public.orders_attributes
                              INNER JOIN orders_attributes_type
                              ON orders_attributes_type.idattribute = orders_attributes.idattribute_orders
                              where idorders = ".$v_idp." and  active like 'XML2_WO_OP%'   and idorders in (select idorders from orders  where idorders = ".$v_idp." and typeregister= 'WO' )
                              ) as fsubselect33
                              group by v_integer,typeord

                              union all

                              select 22 as ordermm,v_integer ,'so' as typeord, json_agg( JSON_BUILD_OBJECT('idattribute_orders',idattribute_orders,'attributedescription', attributedescription,'v_double',v_double,'v_string',v_string)) as jsonmm
                              
                              from (
                                SELECT  distinct   idorders, idattribute_orders,  v_boolean, v_integer, v_double, v_string, 
                                idattribute, attributedescription, attributename, attdatatype, active 

                              FROM public.orders_attributes
                              INNER JOIN orders_attributes_type
                              ON orders_attributes_type.idattribute = orders_attributes.idattribute_orders
                              where idorders = ".$v_idp." and  active like 'XML2_WO_OP%'   and idorders in (select idorders from orders  where idorders = ".$v_idp." and typeregister= 'SO' )
                              ) as fsubselect22
                              group by v_integer,typeord
                        
                              union all select 33, 33,'so'as typeord, '[
                                {
                                  \"idattribute_orders\": 21,
                                  \"attributedescription\": \"Xml File - Operationes - WorkCenter\",
                                  \"v_double\": null,
                                  \"v_string\": \"UPGRADELIC\"
                                }
                              ]'::json

                              union all
                              select 11, v_integer ,'wo' as typeord, json_agg( JSON_BUILD_OBJECT('idattribute_orders',idattribute_orders,'attributedescription', attributedescription,'v_double',v_double,'v_string',v_string)) as jsonmm
                              
                              from (
                                SELECT  distinct   idorders, idattribute_orders,  v_boolean, v_integer, v_double, v_string, 
                                idattribute, attributedescription, attributename, attdatatype, active 

                              FROM public.orders_attributes
                              INNER JOIN orders_attributes_type
                              ON orders_attributes_type.idattribute = orders_attributes.idattribute_orders
                              where idorders in (
                                ".$idorderwo."  

                              ) and  active like 'XML2_WO_OP%'  and idorders in (select idorders from orders  where idorders = ".$idorderwo." and typeregister= 'WO' )
                              ) as fsubselect11
                              group by v_integer ,typeord  

                              union all
                              select 44, v_integer ,'so' as typeord, json_agg( JSON_BUILD_OBJECT('idattribute_orders',idattribute_orders,'attributedescription', attributedescription,'v_double',v_double,'v_string',v_string)) as jsonmm
                              
                              FROM public.orders_attributes
                              INNER JOIN orders_attributes_type
                              ON orders_attributes_type.idattribute = orders_attributes.idattribute_orders
                              where idorders in (
                                ".$idorderwo."  

                              ) and  active like 'XML2_WO_OP%'  and idorders in (select idorders from orders  where idorders = ".$idorderwo." and typeregister= 'SO' )
                              group by v_integer ,typeord order by ordermm asc ,v_integer
                              ";
                            }
                      


               
                  


                        /////////////////////////////////////////////////
                        ///   echo "------------>>>>>>>>>>>".$rowbuscawo['modelciu'];
                        $query_woattach ="select * from products_attributes where idattribute = 127 and idproduct in (select idproduct from fnt_select_allproducts_maxrev() as ppp where modelciu = '".$rowbuscawo['modelciu']."')  ";
                        $data_wo = $connect->query($query_woattach)->fetchAll();	
                        $enabled_attachfile_step = 'N';
                        foreach ($data_wo as $rowwo) 
                        {
                          $enabled_attachfile_step = 'Y';
                      
                        }

                        ///  echo "TIENE ATTACHA".$enabled_attachfile_step;

                  
                        ////////////////////////////////////////////////
                     ///   echo "<br>query_xml".$query_xml;
                        $qq_components_xml = 0;
                        $partnumber_components_xml = '';
                        $partnumberdescrip_components_xml = '';
                        $nroitempositio = 100;
                        $data_xml = $connect->query($query_xml)->fetchAll();	
                        $ejecuto_solucionador = 0;
                        $ejecuto_solucionador_fixer = 0;
                        $haveSOasing="N";
                        if ($data_xml)
                        {
                        foreach ($data_xml as $rowxml) 
                          {
                                    $ejecuto_solucionador = 1;
                                  ///       echo  "<hr><br>a::".$rowxml['jsonmm'];
                                  
                                  // exit();
                                    //$arrmm = json_decode( substr($rowxml['jsonmm'],1,-1) , true);
                                    $arrmm = json_decode( $rowxml['jsonmm'] , true);  
                              
                                    $ttypesomref = $rowxml['typeord'];
                                  
                                    //saco el numero de elementos
                                      $longitud = count($arrmm);

                                //   echo "ojo aca la cant es;".$longitud;
                                
                                    //Recorro todos los elementos
                                    $vvsn="";
                                
                                    $arraysteps_name = array();
                                    $arraysteps_name_refso = array();
                                    $arraysteps_name_sn = array();
                                    $qq_components_xml =0;
                                        for($imm=0; $imm<=$longitud; $imm++)
                                        {
                                  
                                          $arrmmobj = $arrmm[$imm];    
                                          if ( $arrmmobj['idattribute_orders'] == 21)
                                          {
                                        
                                            $steps_name =$arrmmobj['v_string'];
                                            array_push($arraysteps_name, $ttypesomref."_".$arrmmobj['v_string']);
                                        
                                          

                                            $qq_components_xml =  $qq_components_xml +1;
                                  ///        echo "<br>la Cantidad ". $qq_components_xml."es: ".$arrmmobj['v_string']."->".$ttypesomref;
                                          }
                                  
                                          if ( $arrmmobj['idattribute_orders'] == 22)
                                          {
                                          /// echo "<br>la Cantidad es: ".$arrmmobj['v_double'];
                                          array_push($arraysteps_name_sn,$arrmmobj['v_string']);
                                          array_push($arraysteps_name_refso, $rowxml['typeord'] );
                                            $steps_name_descrip =$arrmmobj['v_string'];
                                          }
                                          
                                        }

                              
                                
                                rsort($arraysteps_name);
                                //    print_r($arraysteps_name);

                          
                          
                              
                              ?>
                            
                
                          
                          
                    
                            <?php
                                
                            
                        }
                        }
                        else
                        {
                          echo "SIN DATOS";
                        }
                 
                        ////out for,now chk if have SO ?
                          if ($haveSOasing == "N")
                          {
                            $haveSOasing= "P";
                              ?>
                            <div class="stepazulyamarillo active">
                                                      
                              <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text"><b>SO:<?php //echo $rowbuscawo['tienesoasociada']; ?> <br>CIU : <?php //echo  $ciutemp; ?></b>
                              </span> 
                              <a href="#" onclick="show_info('asingsnwotoso','<?php echo $rowbuscawo['wo_serialnumber']; ?>','<?php echo $rowbuscawo['idorders']; ?>','',0,0)">
                              <span class="badge bg-warning"><b>Assign SN </b></span>
                            </a>
                            </div>
                          <?php

                          }
                   echo "</div>";

                   echo "*********************aca********************************";
                   
                  }

                  echo "*********************FIN FIN 111*********************";
                  exit();

               

                }
                echo "*********************FIN FIN 22*********************";
                exit();

                  
            ?>
                   
         
                
            <?php
                  $cantrefres = $_REQUEST['nroref'];


                  if ( $idorderwo =="0")
                  {
                    $sqlsoIF_old ="
                    
                   select  1 as q1, count(*) as q2
                    from (
                          select date_approved, orders.*
                          from orders 
                          where idorders  = ".$v_idp." and date_approved > '2023-02-10'
                          ) as sggdf
                   ";
                  }
                  else
                  {
                    $sqlsoIF_old ="
                    select  2 as q1, count(*) as q2
                    from (
                        select date_approved, orders.*
                        from orders 
                        where idorders  = ".$v_idp." and date_approved > '2023-02-10'
                        union
                        select date_approved, orders.*
                        from orders 
                        where idorders  = ".$idorderwo." and date_approved > '2023-02-10'
                        ) as sggdf
                    
                    ";
                  }
           echo  "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa<hr>".$sqlsoIF_old."<hr>";


                  $data_woqq = $connect->query($sqlsoIF_old)->fetchAll();	
     
                  foreach ($data_woqq as $rowwoqq) 
                  {
                    if ($rowwoqq['q1'] != $rowwoqq['q2'] && $v_idp >0)
                    {
                      $cantrefres =1; 
                    }
                    
                
                  } 


                  if ($cantrefres ==1 )
                  {
              //      echo "HAGO SUBMIT";
                    ?>
                       <script type="text/javascript">
                    var nuevoref =  window.location.href;
                    nuevoref = nuevoref.replace("trackingorderssap", "trackingorders");  
                    console.log('nuevoref'+  nuevoref);
               ///     window.location.href= nuevoref;
                    </script>

                    <?php

                  }
                if ($ejecuto_solucionador_fixer==0)
                {
              //    echo "HOlaaa FIN".$ejecuto_solucionador;
                 /// $filtrar_xsnsoworma = substr($_REQUEST['encont'],0,-2);
               //   echo "<br>".$filtrar_xsnsoworma;
                //  $sqlsoluciona=" call a_solucionador_orders_attributes_byidorder_so(".$v_idp.",'".$filtrar_xsnsoworma."')";
            //      echo $sqlsoluciona; 
               //   $dataack = $connect->query($sqlsoluciona)->fetchAll();	
                  ?>
                 <script type="text/javascript">
                  ///   window.location.href= window.location.href+'&nroref=1';
                  console.log('AutoSubmit');


                  window.location.href= window.location.href+'&nroref=1';
                  ///window.location.reload();
                  </script>
                  <?php

                  
                }
              }
 
                ?>
            
    

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

/////////////////////////////////////////////////////////////////////////
function crear_steps_so_UPGRADELIC($vv_worcenter,$vv_sn, $vv_idp,$vvnombre_a_mostrar_en_dvi,$vv_soworam,$vv_modelciu,$temp, $v_enable_attachfile)
{
  include("db_conect.php"); 

  $psswdtkkey = substr( md5(microtime()), 1, 8);
  $esupgrade ="N";
  $Sql_ifupgrade = $connect->prepare(" select distinct modelciu, idorders from orders_sn inner join  fnt_select_allproducts_maxrev() as ppp on ppp.idproduct = orders_sn.idproduct  
   where wo_serialnumber = '".$vv_sn."' and typeregister = 'UP' ");                                 
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

 
    //echo " select * from fnt_select_upgrade_finalsku_ia_detect_lic('".$vv_modelciu."','".$elmodelcuiupgrade."') ";
   
      $Sql_ifupgrade2 = $connect->prepare(" select * from fnt_select_upgrade_finalsku_ia_detect_lic('".$vv_modelciu."','".$elmodelcuiupgrade."') ");                                 
      $Sql_ifupgrade2->execute();
      $result_ifup2 = $Sql_ifupgrade2->fetchAll();	
      foreach ($result_ifup2 as $row_up2)
      {
      $skucalculado = $row_up2['v_fsku'];
      }

   
  ?>
  <div class="stepazul active">
  <a href="#" onclick="show_info('orderinfoupgrade','<?php echo $vv_sn; ?>','<?php echo $idorders_upgrde; ?>','<?php echo $skucalculado; ?>',0,0)">
  <span class="icon"><i class="fa fa-box"></i> </span> <span class="text"><b>Upgrade PN<br>
  <?php echo  $elmodelcuiupgrade;?>
  <?php
   echo "<br>".$skucalculado ;

  ?>
 
    <span class='text text-left'>
<a href="#"  onclick="Call_printlabel_upgrade('<?php echo $skucalculado; ?>', '<?php echo $vv_sn; ?>' ,'<?php echo $idorders_upgrde; ?>')">&nbsp; <i class="fas fa-print"></i> - Print Label</a>
<br><a href="printokeyupgrade.php?vido=<?php echo $idorders_upgrde; ?>&sn=<?php echo $vv_sn; ?>" target='_blank' >&nbsp; <i class="fas fa-file-pdf"></i> - View PDF</a>
<br>
<br>   </span> </b>
</a>
</span>
    </div> 
    <?php
  }
}

function crear_steps_crear_steps_so_ENGCAL($vv_worcenter,$vv_sn, $vv_idp,$vvnombre_a_mostrar_en_dvi,$vv_soworam,$vv_modelciu,$temp, $v_enable_attachfile)
{
  include("db_conect.php"); 

  $psswdtkkey = substr( md5(microtime()), 1, 8);

    if ($have_finalcal == 'Y')
    {

    }
    else
    {
      
      ?>
            <div class="step  "> <span class="icon"><i class="fa fa-box"></i> </span> <span class="text"><?php echo substr($vv_worcenter,3,12); ?>  <br>
            
            <?php if ( $v_enable_attachfile=="Y") { ?>
                                              <a href="#" onclick="attachanalogbda(<?php echo $vv_idp; ?>,'<?php echo  $vv_worcenter.'_'.$psswdtkkey;?>','<?php echo $vv_sn; ?>')">
                                                                                                                <i class="fa fa-paperclip" aria-hidden="true"></i>      Attach Files
                                                        </a> <br>
                                                <?php } ?>    
            </span></div>
            <?php  
    }
 
}


function crear_steps_so_BURNING($vv_worcenter,$vv_sn, $vv_idp,$vvnombre_a_mostrar_en_dvi,$vv_soworam,$vv_modelciu,$temp, $v_enable_attachfile)
{
  include("db_conect.php"); 

  $psswdtkkey = substr( md5(microtime()), 1, 8);

    if ($have_finalcal == 'Y')
    {

    }
    else
    {
      
      ?>
            <div class="step  "> <span class="icon"><i class="fa fa-box"></i> </span> <span class="text"><?php echo substr($vv_worcenter,3,12); ?>  <br>
            
            <?php if ( $v_enable_attachfile=="NO_Y") { ?>
                                              <a href="#" onclick="attachanalogbda(<?php echo $vv_idp; ?>,'<?php echo  $vv_worcenter.'_'.$psswdtkkey;?>','<?php echo $vv_sn; ?>')">
                                                                                                                <i class="fa fa-paperclip" aria-hidden="true"></i>      Attach Files
                                                        </a> <br>
                                                <?php } ?>    
            </span></div>
            <?php  
    }
 
}


function crear_steps_so_FINALCAL($vv_worcenter,$vv_sn, $vv_idp,$vvnombre_a_mostrar_en_dvi,$vv_soworam,$vv_modelciu,$temp, $v_enable_attachfile)
{
  include("db_conect.php"); 

  $psswdtkkey = substr( md5(microtime()), 1, 8);

//////////////////////////////////////////////////////////

$vv_worcenter_show = substr(trim($vv_worcenter),3,10);
$no_idruninfowo_ENGCAL=0;
$v_idp = $vv_idp;



if (substr($vv_worcenter,0,2)=="wo" || substr($vv_worcenter,0,2)=="WO")
{
   //// Buscamos datos de la WO
   $query_wo=" select distinct 1 as orr,  orders.idproduct, orders.idorders , orders.processfasserver::int as processfasserver, 
   products.modelciu,so_associed,
   orders.quantity,orders_sn.so_soft_external, orders_sn.wo_serialnumber 
                             from orders
                             inner join orders_sn 
                             on orders_sn.idorders = orders.idorders
                             inner join products
                             on products.idproduct = orders.idproduct
               where orders_sn.so_soft_external = '".$vv_soworam."' and wo_serialnumber ='". $vv_sn."'"; 
}
else
{
        //// Buscamos datos de la WO
        $query_wo=" select distinct 1 as orr, orders.idproduct, orders.idorders , orders.processfasserver::int as processfasserver, 
        products.modelciu,so_associed,
        orders.quantity,orders_sn.so_soft_external, orders_sn.wo_serialnumber 
                                  from orders
                                  inner join orders_sn 
                                  on orders_sn.idorders = orders.idorders
                                  inner join products
                                  on products.idproduct = orders.idproduct
                    where orders_sn.so_associed = '".$vv_soworam."' and wo_serialnumber ='". $vv_sn."'"; 
}


 //echo "<hr>".$query_wo."<hr>";
$data_wo = $connect->query($query_wo)->fetchAll();	

foreach ($data_wo as $rowwo) 
{
$modelciuwo = $rowwo['modelciu'];
$idorderwo =  $rowwo['idorders'];
$wo_info = $rowwo['so_soft_external'];
$vtempidproduct =  $rowwo['idproduct'];

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
                                                 $sqldetect="select fnt_select_detect_bysn_isbda_isdas('".$vv_sn."','WO') ";
                                        //      echo  $sqldetect;
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

                                             
$Sql_ifautotest = $connect->prepare("  
 select idscript, fas_outcome_integral.v_boolean::integer as tienecalibration_totalpass, fas_outcome_integral.reference
from fas_outcome_integral
inner join ( select reference, v_integer as idscript from fas_outcome_integral 
         where reference in ( select reference from fas_outcome_integral 
                   where reference in (select reference from fas_outcome_integral
                             where v_string ='".$vv_sn."' 
                              ) 
                   and v_string =  '".$wo_info."'
                    ) 
         and idfasoutcomecat = 0 and idtype= 12 and v_integer in( 3,35,39 )
          ) as lossub
on lossub.reference = fas_outcome_integral.reference
where fas_outcome_integral.idfasoutcomecat = 0 and 
fas_outcome_integral.idtype= 13

             ");        
             
      
$Sql_ifautotest->execute();
$_if_auto_test_box_calibration = "N";
$activo_paso3_totalpass = "";
$activo_paso3 ="";
$result_ifautotest = $Sql_ifautotest->fetchAll();	
foreach ($result_ifautotest as $row_autotest)
{
 //echo "<br>aaaaaaaaaaaaaa".$row_autotest['idscript'];
 if ( $row_autotest['idscript']<> 2)
 {
   $_if_auto_test_box_calibration = "Y";
 }
 
 $idruninfowo_ENG = $row_autotest['reference'];
 $no_idruninfowo_ENGCAL=1;
    if ($row_autotest['tienecalibration_totalpass']==1 && $idruninfowo_ENG <>"")
      {
        
          $activo_paso3_totalpass = "<span class='badge bg-success'>Passed</span><br><a href='#' onclick='popuplogdb(".$idruninfowo_ENG.")'  style='color:#f39323;'>View Log <i class='fas fa-eye'> </i></a>";
      
      
      
      }
      if ($rowbuscawo['tienecalibration_totalpass']==0 && $idruninfowo_ENG <>"")
      {
        
          $activo_paso3_totalpass = "<span class='badge bg-danger'>Not Passed</span><br><a href='#' onclick='popuplogdb(".$idruninfowo_ENG.")'  style='color:#f39323;'>View Log <i class='fas fa-eye'></i></a>";
      
      }

}

$nombre_a_mostrar_en_dvi_calib ='Calibration :: SN: '.$vv_sn;
/////**************************************************** 
//           echo   "aaaaa".$_if_auto_test_box_calibration;
if ( $idruninfowo_ENG <>"")
{
 $activo_paso3 = "active";
 $activo_paso3_totalpass ="";
 $activo_paso3_totalpass = "<span class='badge bg-success'>Passed</span><br><a href='#' onclick='popuplogdb(".$idruninfowo_ENG.")'  style='color:#f39323;'>View Log <i class='fas fa-eye'> </i></a>";
 
}

/////
/////Buscamos el tipo de reporte para el SKU

$Sql_typeproducrepor = $connect->prepare(" select reporttype from products_webfas_report  where idproduct =  ".$vtempidproduct);        
           
$name_js_report = '';    
$Sql_typeproducrepor->execute();

$result_typrepor = $Sql_typeproducrepor->fetchAll();	
foreach ($result_typrepor as $row_typerepo)
{
 $name_js_report = $row_typerepo['reporttype'];    
}

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
if ($no_idruninfowo_ENGCAL>0)
{
?>
<div class="step <?php echo  $activo_paso3; ?>">  

 

<a href="#" onclick="show_info('<?php echo  $tipolinkweb; ?>','<?php echo $vv_sn; ?>','<?php echo $idorderwo; ?>','<?php echo $nombre_a_mostrar_en_dvi_calib; ?>','<?php echo $idruninfowo_ENG; ?>',0)"> 
<span class="icon">  <i class="fa fa-box"></i> </span> <span class="text"><b>
<?php echo $vv_worcenter_show; ?>  
<br> <?php echo $activo_paso3_totalpass; ?></span></a></b> 
<br><a href="<?php echo $namephp;?>?idsndib=<?php echo  $vv_sn; ?>&amp;iduldl=0&amp;idmb=0&idrunaferbur=<?php echo $idruninfowo_ENG;?>" target="_blank">  <i class='fas fa-file-pdf'></i> -  View Report </a>
                                                        <br>

<?php
//////

}
         
        if ($no_idruninfowo_ENGCAL==0)
         {
           ?>
           <div class="step ">  <span class="icon">  <i class="fa fa-box"></i> </span> <span class="text"><?php echo $vv_worcenter_show; ?><br>
         
           <?php if ( $v_enable_attachfile=="Y") { ?>
                <a href="#" onclick="attachanalogbda(<?php echo $vv_idp; ?>,'<?php echo  $vv_worcenter.'_'.$psswdtkkey;?>','<?php echo $vv_sn; ?>')">
                                                                                                           <i class="fa fa-paperclip" aria-hidden="true"></i>      Attach Files
                                                    </a> <br>
                                                    <?php } ?> 
         </span> <br>
           <?php
         }

    
         
     
           
         $sqlmaxhistory = " select * from fas_to_sap_xml where v_sn ='".$vv_sn."' and v_workcenetr = '".substr($vv_worcenter,3,22)."'  and v_sku = '".$modelciuwo."' and
         runprocessdate in (
   select max(runprocessdate) from fas_to_sap_xml where v_sn ='".$vv_sn."' and v_workcenetr = '".substr($vv_worcenter,3,22)."' and v_sku = '".$modelciuwo."' )

   ";
      ///   echo $sqlmaxhistory;
           $datahist = $connect->query($sqlmaxhistory)->fetchAll();	
           foreach ($datahist as $row2hh) 
           {
               //echo $row2hh['v_state']."<br>".$row2hh['v_state_result'];
               if ($row2hh['v_state']==0)
               {
                 echo "<br><span class='badge bg-secondary' title='".$row2hh['v_state_result']."'>SAP::Pending RESORD</span>";
               }
               if ($row2hh['v_state']==1)
               {
                 echo "<br><span class='badge bg-warning' title='".$row2hh['v_state_result']."'>SAP::Run</span>";
               }
               if ($row2hh['v_state']==2)
               {
                 echo "<br><span class='badge bg-warning' title='".$row2hh['v_state_result']."'>SAP::Pending ACK</span>";
               }
               if ($row2hh['v_state']==3)
               {
                 echo "<br><span class='badge bg-danger' title='".$row2hh['v_state_result']."'>SAP::Error </span>";
               }
               if ($row2hh['v_state']==4)
               {
                   echo "<br><span class='badge bg-info' title='".$row2hh['v_state_result']."'>SAP::OK ACK</span>";
               }
               if ($row2hh['v_state']==5)
               {
                   echo "<br><span class='badge bg-danger' title='".$row2hh['v_state_result']."'>SAP::Error ACK</span>";
               }
               /// echo "<br>".$row2hh['v_state_result'];
           }  
       
    ///este div cierra ambos casos OJO       
   ?>
   </div>
   <?php
   ///////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
 
}

function crear_steps_wo_AFTERBURNING($vv_worcenter,$vv_sn, $vv_idp,$vvnombre_a_mostrar_en_dvi,$vv_soworam,$vv_modelciu , $v_enable_attachfile)
{
    ////////////////////////inio WO BURNING
    $nombre_a_mostrar_en_dvi_finalchk ='Final Check:: SN: '.$vv_sn;
    $v_idp =  $vv_idp;
   ///////////////// wo_afterburning //////////////////////////
   include("db_conect.php"); 

   if (substr($vv_worcenter,0,2)=="wo")
   {
      //// Buscamos datos de la WO
      $query_wo=" select distinct 1 as orr, orders.idorders , orders.processfasserver::int as processfasserver, 
      products.modelciu,so_associed,
      orders.quantity,orders_sn.so_soft_external, orders_sn.wo_serialnumber 
                                from orders
                                inner join orders_sn 
                                on orders_sn.idorders = orders.idorders
                                inner join products
                                on products.idproduct = orders.idproduct
                  where orders_sn.so_associed = '".$vv_soworam."' and wo_serialnumber ='". $vv_sn."'"; 
   }
   else
   {
           //// Buscamos datos de la WO
           $query_wo=" select distinct 1 as orr, orders.idorders , orders.processfasserver::int as processfasserver, 
           products.modelciu,so_associed,
           orders.quantity,orders_sn.so_soft_external, orders_sn.wo_serialnumber 
                                     from orders
                                     inner join orders_sn 
                                     on orders_sn.idorders = orders.idorders
                                     inner join products
                                     on products.idproduct = orders.idproduct
                       where orders_sn.so_soft_external = '".$vv_soworam."' and wo_serialnumber ='". $vv_sn."'"; 
   }

   


       //   echo $query_wo;
           /// exit();
 $data_wo = $connect->query($query_wo)->fetchAll();	
 $ejecuto_solucionador = 0;
 foreach ($data_wo as $rowwo) 
 {
   $modelciuwo = $rowwo['modelciu'];
   $idorderwo =  $rowwo['idorders'];
   $wo_info = $rowwo['so_soft_external'];

 }

  $psswdtkkey = substr( md5(microtime()), 1, 8);
     $linkreportafter_burning_check="calibrationtopdfconimg.php";
      ///////////////////////////////////////////////////////
      //Control si es Enterprise Remoto
 

      $Sql_ifautotest = $connect->prepare("  
      select idscript, fas_outcome_integral.v_boolean::integer as tienecalibration_totalpass, fas_outcome_integral.reference
    from fas_outcome_integral
    inner join ( select reference, v_integer as idscript from fas_outcome_integral 
              where reference in ( select reference from fas_outcome_integral 
                        where reference in (select reference from fas_outcome_integral
                                  where v_string ='".$vv_sn."' 
                                   ) 
                        and v_string =  '".$wo_info."'
                         ) 
              and idfasoutcomecat = 0 and idtype= 12 and v_integer in( 3,35,39 )
               ) as lossub
    on lossub.reference = fas_outcome_integral.reference
    where fas_outcome_integral.idfasoutcomecat = 0 and 
    fas_outcome_integral.idtype= 13    
                  ");                                 
     $Sql_ifautotest->execute();
     $idruninfoAfertburnung = 0;
     $result_ifautotest = $Sql_ifautotest->fetchAll();	
     foreach ($result_ifautotest as $row_autotest)
     {
            
        $idruninfoAfertburnung = $row_autotest['reference'];

        if ( $row_autotest['tienecalibration_totalpass'] == 1  )
        {
          $activo_paso4 = "active";
          $activo_paso4_totalpass = "<span class='badge bg-success'>Passed</span><br><a href='#' onclick='popuplogdb(".$idruninfoAfertburnung.")'  style='color:#f39323;'>View Log <i class='fas fa-eye'></i></a>";
      
        }
        else
        {
          
          $activo_paso4_totalpass = "<span class='badge bg-danger'>Not Passed</span><br><a href='#' onclick='popuplogdb(".$idruninfoAfertburnung.")'  style='color:#f39323;'>View Log <i class='fas fa-eye'></i></a>";
        
        }     
  
     }
   
      ///

       if (  $idruninfoAfertburnung >0)
       {
         $idruninfoAfertburnung= $rowbuscawo['tienefinalchk_idruninfo'] ; 
       ?>
       <div class="step <?php echo  $activo_paso4; ?>">
       <?php 
    
                                             
 

       if ( $ciuisenterprice =='Y')
             {
               ////Buscamos si el runinfo pasoo o no..para el ENT REM
               $linkreportafter_burning_check="reportafbcoutcome.php";
             

                 if ( $ciuisremote =="Y")
                 {
                   ?>
                   <a href="#" onclick="show_info('finalchkenterpriseremoto','<?php echo $vv_sn; ?>','<?php echo $v_idp; ?>','<?php echo $nombre_a_mostrar_en_dvi_finalchk; ?>','<?php echo   $idruninfoAfertburnung; ?>',0)"><span class="icon"><i class="fa fa-box"></i> </span> <span class="text"><b><?php echo substr($vv_worcenter,3,12); ?> <br>
                   <?php
                 }
                 if ( $ciuismaster =="Y")
                 {
                   ?>
                   <a href="#" onclick="show_info('finalchkenterprisemaster','<?php echo $vv_sn; ?>','<?php echo $v_idp; ?>','<?php echo $nombre_a_mostrar_en_dvi_finalchk; ?>','<?php echo   $idruninfoAfertburnung; ?>',0)"><span class="icon"><i class="fa fa-box"></i> </span> <span class="text"><b><?php echo substr($vv_worcenter,3,12); ?><br>
                   <?php
                 }
               ?>
               
               <?php
             }
             else
             {
             
               ?>
               <a href="#" onclick="show_info('finalchk','<?php echo $vv_sn; ?>','<?php echo $v_idp; ?>','<?php echo $nombre_a_mostrar_en_dvi_finalchk; ?>','<?php echo $rowbuscawo['tienefinalchk_idruninfo']; ?>',0)"><span class="icon"><i class="fa fa-box"></i> </span> <span class="text"><b> <?php echo substr($vv_worcenter,3,12); ?> <br>
               <?php
             }?>    
       

         <?php echo $activo_paso4_totalpass; ?></span></a> </b>
         <br> <a href="<?php echo  $linkreportafter_burning_check; ?>?idsndib=<?php echo  $vv_sn; ?>&iduldl=0&idmb=0&idrun=<?php echo $rowbuscawo['tienefinalchk_idruninfo'];?>" target="_blank">  <i class='fas fa-file-pdf'></i> - View Report</a>
         </a><br> 
         <?php if ( $v_enable_attachfile=="Y") { ?>
                 <a href="#" onclick="attachanalogbda(<?php echo $vv_idp; ?>,'<?php echo  $vv_worcenter.'_'.$psswdtkkey;?>','<?php echo $vv_sn; ?>')">
                                                                                                            <i class="fa fa-paperclip" aria-hidden="true"></i>      Attach Files
                                                     </a> <br>
                                                     <?php } ?> 
         </div>
       <?php
     }
     else
     {
         ?>
         <div class="step <?php echo  $activo_paso4; ?>"> <span class="icon"><i class="fa fa-box"></i> </span> <span class="text"><?php echo substr($vv_worcenter,3,12); ?>  <br>
        
         <?php if ( $v_enable_attachfile=="Y") { ?>
                                          <a href="#" onclick="attachanalogbda(<?php echo $vv_idp; ?>,'<?php echo  $vv_worcenter.'_'.$psswdtkkey;?>','<?php echo $vv_sn; ?>')">
                                                                                                            <i class="fa fa-paperclip" aria-hidden="true"></i>      Attach Files
                                                     </a> <br>
                                             <?php } ?>    
        </span></div>
         <?php  
     }

   
   ////////////////////////FIN WO BURNING
}

  ////////////////////////////////////////////////////////////////////////////////////////
  
function crear_steps_soinfo_FINALINSPEC($vv_worcenter,$vv_sn, $vv_idp,$vvnombre_a_mostrar_en_dvi,$vv_soworam,$vv_modelciu,$emp,$v_enable_attachfile)
{ 
  include("db_conect.php"); 

  $psswdtkkey = substr( md5(microtime()), 1, 8);
      /////**************3  Quality Survey Final Check ************************************** 
                                              //// sumamos un paso aqui prechech  Precheck
                                              $sqldetectchkeo3="SELECT   status_sn , datetimecheck, so, modelciu FROM public.fas_survey_responses_bysn where idsurvey = 3 and  sn = '".$vv_sn."' and  so = '". $vv_soworam."' and modelciu = '".$vv_modelciu."'
                                              union 
                                              SELECT   status_sn , datetimecheck, so, modelciu  FROM public.fas_survey_responses_bysn where idsurvey = 3 and  sn = '".$vv_sn."' 
                                              order by datetimecheck desc limit 1 ";
                                     
                                       ///      echo "test:".$sqldetectchkeo3;
                                                $datadetectprecheko3 = $connect->query($sqldetectchkeo3)->fetchAll();
                                                $tieneprecheck=0;
                                                
                                                foreach ($datadetectprecheko3 as $rowchequeo) 
                                                {
                                                  $tieneprecheck=1;
                                                  $vv_soworam_tempsurvey3 =$rowchequeo['so'];
                                                  $vv_modelciu_tempsurvey3=$rowchequeo['modelciu'];

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
                                                 
                                              <a href="#" onclick="show_info('Precheckfinalcheck','<?php echo $vv_sn; ?>','<?php echo  $vv_soworam_tempsurvey3; ?>','<?php echo $vv_modelciu_tempsurvey3; ?>','Quality Calibration Precheck',0)">
                                                <span class="icon"> <i class="fas fa-tasks"></i> </span> 
                                              <span class="text">  <b>PRECHECK  <br>SN [<?php echo $vv_sn; ?>] <br></b></span>
                                              <?php
                                               $sqldetectchkeo="SELECT   status_sn  FROM public.fas_survey_responses_bysn where  idsurvey = 3 and  sn  = '".$vv_sn."' and  so = '".$vv_soworam."' and modelciu = '".$vv_modelciu."'
                                                order by datetimecheck desc limit 1 ";
                                                
                                             //  	echo "test:".$sqldetectchkeo;
                                                  $datadetectprecheko = $connect->query($sqldetectchkeo)->fetchAll();
                                                  $fix_cambiotrackin='Y';
                                                  foreach ($datadetectprecheko as $rowchequeo) 
                                                  {
                                                    $fix_cambiotrackin='N';
                                                      if ($rowchequeo['status_sn']=="PASS")
                                                      {
                                                        echo "    <span class='badge bg-success'>Passed</span><br>";
                                                      }
                                                      else
                                                      {
                                                        echo "    <span class='badge bg-danger'>Fail</span><br>";
                                                      }
                                                  }

                                                  if ($fix_cambiotrackin=='Y')
                                                  {
                                                    $sqldetectchkeo="SELECT   status_sn  FROM public.fas_survey_responses_bysn where  idsurvey = 3 and  sn  = '".$vv_sn."' order by datetimecheck desc limit 1 ";
                                                
                                                    
                                                     $datadetectprecheko = $connect->query($sqldetectchkeo)->fetchAll();
                                                     $fix_cambiotrackin='Y';
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
                                                  }
                                              ?>
                                          </a>
                                          <?php

                                          
$sqlmaxhistory = " select * from fas_to_sap_xml where v_sn ='".$vv_sn."' and v_workcenetr = '".substr($vv_worcenter,3,22)."' and v_sku = '".$vv_modelciu."' and
runprocessdate in (
select max(runprocessdate) from fas_to_sap_xml where v_sn ='".$vv_sn."' and v_workcenetr = '".substr($vv_worcenter,3,22)
."' and v_sku = '".$vv_modelciu."' )

";
 //  echo "b:::".$sqlmaxhistory;
  $datahist = $connect->query($sqlmaxhistory)->fetchAll();	
  foreach ($datahist as $row2hh) 
  {
    $statemm =$row2hh['v_state'];
      //echo $row2hh['v_state']."<br>".$row2hh['v_state_result'];
      if ($row2hh['v_state']==0)
      {
        $statemm_html= "<span class='badge bg-secondary' title='".$row2hh['v_state_result']."'>SAP::Pending RESORD</span>";
      }
      if ($row2hh['v_state']==1)
      {
        $statemm_html= "<span class='badge bg-warning' title='".$row2hh['v_state_result']."'>SAP::Run</span>";
      }
      if ($row2hh['v_state']==2)
      {
        $statemm_html= "<span class='badge bg-warning' title='".$row2hh['v_state_result']."'>SAP::Pending ACK</span>";
      }
      if ($row2hh['v_state']==3)
      {
        $statemm_html= "<span class='badge bg-danger' title='".$row2hh['v_state_result']."'>SAP::Error </span>";     
      }
      if ($row2hh['v_state']==4)
      {
        $statemm_html= "<span class='badge bg-info' title='".$row2hh['v_state_result']."'>SAP::OK ACK</span>";
      }
      if ($row2hh['v_state']==5)
      {
        $statemm_html= "<span class='badge bg-danger' title='".$row2hh['v_state_result']."'>SAP::Error ACK</span>";
      }
     /// echo "<br>".$row2hh['v_state_result'];


     ////
     $idrunhiss ="";
     $isbypass="N";
     $sqlmaxhistory = "select * from fas_to_sap_xml_history where idruninfo =".$row2hh['idruninfo']." order by  runprocessdate asc";
 //  echo "<br>".$sqlmaxhistory;
     $datahist = $connect->query($sqlmaxhistory)->fetchAll();	
     foreach ($datahist as $row2hh) 
     {
           $idrunhiss = $row2hh['idruninfoack'];
           $msjhistory= $row2hh['state_result'];
       //  } 
           if ( $idrunhiss =="")
           {

           }
           else
           {
             //// Buscamos el ACK del ultRun
             $tooltipamostrar ="";
               $sqlackresult = "select v_string, POSITION('is already being processed by' in v_string) as isbypass, POSITION('Characteristic with confirmation number' in v_string) as isbypass2  from fas_sap_filesxml_attribute where idruninfo =".$idrunhiss." and idattributeord in (56,57,59) ";
            ///   echo $sqlackresult;
               $dataack = $connect->query($sqlackresult)->fetchAll();	
               foreach ($dataack as $rowackm) 
               {
                 
                   if ($rowackm['v_string'] <> '')
                   {
                       $tooltipamostrar =   $tooltipamostrar.$rowackm['v_string']."\r\n";
                       if ($rowackm['isbypass'] > 0 || $rowackm['isbypass2'] > 0 )
                       {
                         $isbypass="Y";
                       }
                   }
                   
               } 
   
             }

     }

     if ($isbypass=="Y")
     {
       echo "<span class='badge bg-warning'>ByPass OK</span>";
     }
     else
     {
         echo $statemm_html; 
         
        
     }

     ////
  }  

                                        
                                          if ( $v_enable_attachfile=="Y") { ?>
                                          <a href="#" onclick="attachanalogbda(<?php echo $vv_idp; ?>,'<?php echo  'SO_PRECHECK_'.$psswdtkkey;?>','<?php echo $vv_sn; ?>')">
                                                                                                            <i class="fa fa-paperclip" aria-hidden="true"></i>      Attach Files
                                                     </a> <br>
                                             <?php } ?>                           
                                                </div> 
                                                <?php 
                                                
       
                                                  
                                                

}

   ///////////////////////////////////
   function crear_steps_woinfo_PRECHECK($vv_worcenter,$vv_sn, $vv_idp,$vvnombre_a_mostrar_en_dvi,$vv_soworam,$vv_modelciu,$vtemp, $v_enable_attachfile)
 { 
     include("db_conect.php"); 

     $psswdtkkey = substr( md5(microtime()), 1, 8);
              //echo "<br>Averrr--> ", substr($vv_worcenter,0,2);
              if ( substr($vv_soworam,-2)=="wo" || substr($vv_soworam,-2)=="WO")
              {
                 //// Buscamos datos de la WO
                 $query_wo=" select distinct 1 as orr, orders.idorders , orders.processfasserver::int as processfasserver, 
                 products.modelciu,so_associed,
                 orders.quantity,orders_sn.so_soft_external, orders_sn.wo_serialnumber 
                                           from orders
                                           inner join orders_sn 
                                           on orders_sn.idorders = orders.idorders
                                           inner join products
                                           on products.idproduct = orders.idproduct
                             where orders_sn.so_soft_external = '".$vv_soworam."' and wo_serialnumber ='". $vv_sn."'"; 
              }
              else
              {
                      //// Buscamos datos de la WO
                      $query_wo=" select distinct 1 as orr, orders.idorders , orders.processfasserver::int as processfasserver, 
                      products.modelciu,so_associed,
                      orders.quantity,orders_sn.so_soft_external, orders_sn.wo_serialnumber 
                                                from orders
                                                inner join orders_sn 
                                                on orders_sn.idorders = orders.idorders
                                                inner join products
                                                on products.idproduct = orders.idproduct
                                  where orders_sn.so_associed = '".$vv_soworam."' and wo_serialnumber ='". $vv_sn."' and orders.typeregister <>'UP'"; 
              }
     
 

     ///     echo $query_wo;
             /// exit();
    $data_wo = $connect->query($query_wo)->fetchAll();	
    $ejecuto_solucionador = 0;
    foreach ($data_wo as $rowwo) 
    {
      $modelciuwo = $rowwo['modelciu'];
      $idorderwo =  $rowwo['idorders'];
      $wo_info = $rowwo['so_soft_external'];

    }
          /////**************PRE CHEQUEO************************************** 
                 //// sumamos un paso aqui prechech  Precheck
                 $sqldetectchkeo="SELECT   status_sn  FROM public.fas_survey_responses_bysn 
                 where  idsurvey = 1 and sn = '".$vv_sn."' and  so = '". $wo_info ."' and modelciu = '".$modelciuwo."'
                 order by datetimecheck desc limit 1 ";

          ///     	echo "<br>test:".$sqldetectchkeo;
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
             //    echo $vv_worcenter."--".$vv_sn."--".$vv_idp."--".$vvnombre_a_mostrar_en_dvi."--".$vv_soworam."--".$vv_modelciu."--<br>";
                 ?>

                 <a href="#" onclick="show_info('Precheck','<?php echo $vv_sn; ?>','<?php echo  $wo_info; ?>','<?php echo $modelciuwo; ?>','Quality Calibration Precheck','<?php echo $vv_worcenter; ?>')">
                 <span class="icon"> <i class="fas fa-tasks"></i> </span> 
                 <span class="text">  <b><?php echo  substr($vv_worcenter,3,12);?>   <br>SN [<?php echo $vv_sn; ?>] <br></b>
                
                 <?php 
             ///   echo "HOLAGOLA".$v_enable_attachfile;
                 if ( $v_enable_attachfile=="Y") { ?>
                 <a href="#" onclick="attachanalogbda(<?php echo $vv_idp; ?>,'<?php echo  $vv_worcenter.'_'.$psswdtkkey;?>','<?php echo $vv_sn; ?>')">
                                                                                                            <i class="fa fa-paperclip" aria-hidden="true"></i>      Attach Files
                                                     </a> <br>
                                                     <?php } ?> 
                </span>
                 <?php
                 $sqldetectchkeo="SELECT   status_sn  FROM public.fas_survey_responses_bysn where idsurvey = 1 and  sn = '".$vv_sn."' and  so = '". $wo_info."' and modelciu = '".$modelciuwo."'
                 order by datetimecheck desc limit 1 ";

              //  	echo "test:".$sqldetectchkeo;
                 $datadetectprecheko = $connect->query($sqldetectchkeo)->fetchAll();
                 foreach ($datadetectprecheko as $rowchequeo) 
                 {
                     if ($rowchequeo['status_sn']=="PASS")
                     {
                         echo "    <span class='badge bg-success'>FAS::Passed</span><br>";
                     }
                     else
                     {
                       echo "    <span class='badge bg-danger'>FAS::Fail</span><br>";
                     }
                 }


                 
                 ?>
      <?php
            
            
            $sqlmaxhistory = " select * from fas_to_sap_xml where v_sn ='".$vv_sn."' and v_workcenetr = '".substr($vv_worcenter,3,22)."'  and v_sku = '".$modelciuwo."' and
            runprocessdate in (
      select max(runprocessdate) from fas_to_sap_xml where v_sn ='".$vv_sn."' and v_workcenetr = '".substr($vv_worcenter,3,22)."' and v_sku = '".$modelciuwo."' )

      ";
       //      echo $sqlmaxhistory;
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
          
 
   }
   ///////////////////////////////////
  ///////////////////////////////////
  function crear_steps_woinfo_2NDASSY($vv_worcenter,$vv_sn, $vv_idp,$vvnombre_a_mostrar_en_dvi,$vv_soworam,$vv_modelciu, $vtemp, $v_enable_attachfile)
  { 
    include("db_conect.php"); 

    $modelciuwo = $vv_modelciu;
    $idorderwo =  $vv_idp;
    $wo_info = $vv_soworam;

    $psswdtkkey = substr( md5(microtime()), 1, 8);

    ?>
    
    <div class="stepazul   active"> 
   
   <a href="#" onclick="show_info('orderinfo','<?php echo $vv_sn; ?>','<?php echo $vv_idp; ?>','<?php echo $vvnombre_a_mostrar_en_dvi; ?>',0,0)">
 
   <span class="icon"> <i class="fa fa-check"></i> </span>
       <span class="text text-center">
     
     
     <b>  SO: [<?php echo $vv_soworam; ?>]<br>CIU: [<?php echo  $vv_modelciu; ?>]</b> 
       <br><b> SN Generated: [<?php echo $vv_sn; ?>]</b><br>
     </a>
     <p class='  text-center'>
       <a href="#"  onclick="Call_printlabel('<?php echo  $vv_modelciu; ?>', '<?php echo $vv_sn; ?>' ,'<?php echo  $vv_idp ; ?>')"><i class="fas fa-print"></i> - Print Label
  </a> 
  
  <?php
  //echo "HOLA_ABC".$v_enable_attachfile;
  if ( $v_enable_attachfile=="Y") { ?><br>  
  <a href="#" onclick="attachanalogbda(<?php echo $vv_idp; ?>,'<?php echo  'so_SO-INFO'.'_'.$psswdtkkey;?>','<?php echo $vv_sn; ?>')">
                                                                                                            <i class="fa fa-paperclip" aria-hidden="true"></i>      Attach Files
                                                     </a> 
                                                     <?php } ?>                                              
       <?php
                                                  if( $_SESSION["g"] =='develop' || 'Productionadmin' ==  $_SESSION["g"])
                                                  {
                                                    ?>
                                                   <br> <a href='unlinksndevelop.php?snmm=<?php echo $rowbuscawo['wo_serialnumber'];?>' target='_blank'> <span class='text-danger'>Unlink sn </span> </a> 
                                                    <?php
                                                  }
                                                 
                                                  ?>
  <br>  <br>
 <br>
   
   <br>
 </p>
   </span> 

   </div>
    <?php
   
        $sqldetectchkeopicki="SELECT distinct   orders_sn_components.wo_serialnumber 
       FROM public.orders_sn_components_xml as orders_sn_components 
    
     inner join orders_sn
     on orders_sn.idorders = orders_sn_components.idorders and 
     orders_sn.idproduct = orders_sn_components.idproduct and
     orders_sn.so_soft_external = '".$vv_soworam."'  where orders_sn_components.wo_serialnumber= '".$vv_sn."'";
       
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
       
         <a href="#" onclick="show_info('picking','<?php echo $vv_sn; ?>','<?php echo $wo_info; ?>','<?php echo $modelciuwo; ?>','Quality Calibration Precheck',   '<?php echo $vv_worcenter ; ?>'  )">
         <span class="icon"> <i class="fas fa-tasks"></i> </span> 
         <span class="text">  <b><?php echo substr($vv_worcenter,3,12);  ?>  <br>SN [<?php echo $vv_sn; ?>] <br></b></span>
         <?php if ( $v_enable_attachfile=="Y") { ?>
         <a href="#" onclick="attachanalogbda(<?php echo $vv_idp; ?>,'<?php echo  $vv_worcenter.'_'.$psswdtkkey;?>','<?php echo $vv_sn; ?>')">
                                                                                                            <i class="fa fa-paperclip" aria-hidden="true"></i>      Attach Files
                                                     </a> 
                                                     <?php } ?> 
       <?php
       $sqlmaxhistory = " select * from fas_to_sap_xml where v_sn ='".$vv_sn."' and v_workcenetr = '".substr($vv_worcenter,3,22)."' and
       runinfodate in (
select max(runinfodate) from fas_to_sap_xml where v_sn ='".$vv_sn."' and v_workcenetr = '".substr($vv_worcenter,3,22)."')

";
  ///     echo $sqlmaxhistory;
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
   

  }

///////// inicio

function crear_steps_wo_BURNING($vv_worcenter,$vv_sn, $vv_idp,$vvnombre_a_mostrar_en_dvi,$vv_soworam,$vv_modelciu,$refSowo, $v_enable_attachfile)
{
 /////**************************************************** 
 /////**** receive $refSowo = IDRUNIFNO !!!!!!! */
 include("db_conect.php"); 

 $vv_worcenter_show = substr(trim($vv_worcenter),3,10);
 $no_idruninfowo_ENGCAL=0;
 $v_idp = $vv_idp;


 
 if (substr($vv_worcenter,0,2)=="wo" || substr($vv_worcenter,0,2)=="WO")
 {
    //// Buscamos datos de la WO
    $query_wo=" select distinct 1 as orr,  orders.idproduct, orders.idorders , orders.processfasserver::int as processfasserver, 
    products.modelciu,so_associed,
    orders.quantity,orders_sn.so_soft_external, orders_sn.wo_serialnumber 
                              from orders
                              inner join orders_sn 
                              on orders_sn.idorders = orders.idorders
                              inner join products
                              on products.idproduct = orders.idproduct
                where orders_sn.so_soft_external = '".$vv_soworam."' and wo_serialnumber ='". $vv_sn."'"; 
 }
 else
 {
         //// Buscamos datos de la WO
         $query_wo=" select distinct 1 as orr, orders.idproduct, orders.idorders , orders.processfasserver::int as processfasserver, 
         products.modelciu,so_associed,
         orders.quantity,orders_sn.so_soft_external, orders_sn.wo_serialnumber 
                                   from orders
                                   inner join orders_sn 
                                   on orders_sn.idorders = orders.idorders
                                   inner join products
                                   on products.idproduct = orders.idproduct
                     where orders_sn.so_associed = '".$vv_soworam."' and wo_serialnumber ='". $vv_sn."'"; 
 }

 
  //echo "<hr>".$query_wo."<hr>";
$data_wo = $connect->query($query_wo)->fetchAll();	

foreach ($data_wo as $rowwo) 
{
$modelciuwo = $rowwo['modelciu'];
$idorderwo =  $rowwo['idorders'];
$wo_info = $rowwo['so_soft_external'];
$vtempidproduct =  $rowwo['idproduct'];

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
                                                  $sqldetect="select fnt_select_detect_bysn_isbda_isdas('".$vv_sn."','WO') ";
                                         //      echo  $sqldetect;
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
 
                                              
 $Sql_ifautotest = $connect->prepare("  
  select idscript, fas_outcome_integral.v_boolean::integer as tienecalibration_totalpass, fas_outcome_integral.reference
from fas_outcome_integral
inner join ( select reference, v_integer as idscript from fas_outcome_integral 
					where reference in ( select reference from fas_outcome_integral 
										where reference in (select reference from fas_outcome_integral
															where v_string ='".$vv_sn."' 
														   ) 
										and v_string =  '".$wo_info."'
									   ) 
					and idfasoutcomecat = 0 and idtype= 12 and v_integer in( 999 )
				   ) as lossub
on lossub.reference = fas_outcome_integral.reference
where fas_outcome_integral.idfasoutcomecat = 0 and 
fas_outcome_integral.idtype= 13

              ");        
              
       
 $Sql_ifautotest->execute();
 $_if_auto_test_box_calibration = "N";
 $activo_paso3_totalpass = "";
 $activo_paso3 ="";
 $result_ifautotest = $Sql_ifautotest->fetchAll();	
 foreach ($result_ifautotest as $row_autotest)
 {
  //echo "<br>aaaaaaaaaaaaaa".$row_autotest['idscript'];
  if ( $row_autotest['idscript']<> 2)
  {
    $_if_auto_test_box_calibration = "Y";
  }
  
  $idruninfowo_ENG = $row_autotest['reference'];
  $no_idruninfowo_ENGCAL=1;
    if ($row_autotest['tienecalibration_totalpass']==1 && $idruninfowo_ENG <>"")
  {
    
      $activo_paso3_totalpass = "<span class='badge bg-success'>Passed</span><br><a href='#' onclick='popuplogdb(".$idruninfowo_ENG.")'  style='color:#f39323;'>View Log <i class='fas fa-eye'> </i></a>";
  
  
  
  }
  if ($rowbuscawo['tienecalibration_totalpass']==0 && $idruninfowo_ENG <>"")
  {
    
      $activo_paso3_totalpass = "<span class='badge bg-danger'>Not Passed</span><br><a href='#' onclick='popuplogdb(".$idruninfowo_ENG.")'  style='color:#f39323;'>View Log <i class='fas fa-eye'></i></a>";
  
  }

 }

 $nombre_a_mostrar_en_dvi_calib ='Calibration :: SN: '.$vv_sn;
/////**************************************************** 
//           echo   "aaaaa".$_if_auto_test_box_calibration;
if ( $idruninfowo_ENG <>"")
{
  $activo_paso3 = "active";
  $activo_paso3_totalpass ="";
  $activo_paso3_totalpass = "<span class='badge bg-success'>Passed</span><br><a href='#' onclick='popuplogdb(".$idruninfowo_ENG.")'  style='color:#f39323;'>View Log <i class='fas fa-eye'> </i></a>";
  
}

/////
/////Buscamos el tipo de reporte para el SKU
 
$Sql_typeproducrepor = $connect->prepare(" select reporttype from products_webfas_report  where idproduct =  ".$vtempidproduct);        
            
 $name_js_report = '';    
$Sql_typeproducrepor->execute();

$result_typrepor = $Sql_typeproducrepor->fetchAll();	
foreach ($result_typrepor as $row_typerepo)
{
  $name_js_report = $row_typerepo['reporttype'];    
}

?>
<div class="step <?php echo  $activo_paso3; ?>">  <a href="#" onclick="show_info('<?php echo $name_js_report;?>','<?php echo $vv_sn; ?>','<?php echo $idorderwo; ?>','<?php echo $nombre_a_mostrar_en_dvi_calib; ?>','<?php echo $idruninfowo_ENG; ?>',0)"> <span class="icon">  <i class="fa fa-box"></i> </span> <span class="text"><b>BURNING <br> <?php echo $activo_paso3_totalpass; ?></span></a></b> </div>
<?php
//////

}

///////// fin


  ///////////////////////////////////
function crear_steps_wo_ENG($vv_worcenter,$vv_sn, $vv_idp,$vvnombre_a_mostrar_en_dvi,$vv_soworam,$vv_modelciu,$refSowo, $v_enable_attachfile)
{
 /////**************************************************** 
 /////**** receive $refSowo = IDRUNIFNO !!!!!!! */
 include("db_conect.php"); 

 $vv_worcenter_show = substr(trim($vv_worcenter),3,10);
 $no_idruninfowo_ENGCAL=0;
 $v_idp = $vv_idp;


 
 if (substr($vv_worcenter,0,2)=="wo" || substr($vv_worcenter,0,2)=="WO")
 {
    //// Buscamos datos de la WO
    $query_wo=" select distinct 1 as orr,  orders.idproduct, orders.idorders , orders.processfasserver::int as processfasserver, 
    products.modelciu,so_associed,
    orders.quantity,orders_sn.so_soft_external, orders_sn.wo_serialnumber 
                              from orders
                              inner join orders_sn 
                              on orders_sn.idorders = orders.idorders
                              inner join products
                              on products.idproduct = orders.idproduct
                where orders_sn.so_soft_external = '".$vv_soworam."' and wo_serialnumber ='". $vv_sn."'"; 
 }
 else
 {
         //// Buscamos datos de la WO
         $query_wo=" select distinct 1 as orr, orders.idproduct, orders.idorders , orders.processfasserver::int as processfasserver, 
         products.modelciu,so_associed,
         orders.quantity,orders_sn.so_soft_external, orders_sn.wo_serialnumber 
                                   from orders
                                   inner join orders_sn 
                                   on orders_sn.idorders = orders.idorders
                                   inner join products
                                   on products.idproduct = orders.idproduct
                     where orders_sn.so_associed = '".$vv_soworam."' and wo_serialnumber ='". $vv_sn."'"; 
 }

 
  //echo "<hr>".$query_wo."<hr>";
$data_wo = $connect->query($query_wo)->fetchAll();	

  foreach ($data_wo as $rowwo) 
  {
  $modelciuwo = $rowwo['modelciu'];
  $idorderwo =  $rowwo['idorders'];
  $wo_info = $rowwo['so_soft_external'];
  $vtempidproduct =  $rowwo['idproduct'];

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
                                                  $sqldetect="select fnt_select_detect_bysn_isbda_isdas('".$vv_sn."','WO') ";
                                         //      echo  $sqldetect;
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
 
                                              
 $Sql_ifautotest = $connect->prepare("  
  select idscript, fas_outcome_integral.v_boolean::integer as tienecalibration_totalpass, fas_outcome_integral.reference
from fas_outcome_integral
inner join ( select reference, v_integer as idscript from fas_outcome_integral 
					where reference in ( select reference from fas_outcome_integral 
										where reference in (select reference from fas_outcome_integral
															where v_string ='".$vv_sn."' 
														   ) 
										and v_string =  '".$wo_info."'
									   ) 
					and idfasoutcomecat = 0 and idtype= 12 and v_integer in( 27,2,32,37 )
				   ) as lossub
on lossub.reference = fas_outcome_integral.reference
where fas_outcome_integral.idfasoutcomecat = 0 and 
fas_outcome_integral.idtype= 13

              ");        
              
       
 $Sql_ifautotest->execute();
 $_if_auto_test_box_calibration = "N";
 $activo_paso3_totalpass = "";
 $activo_paso3 ="";
 $result_ifautotest = $Sql_ifautotest->fetchAll();	
 foreach ($result_ifautotest as $row_autotest)
 {
  //echo "<br>aaaaaaaaaaaaaa".$row_autotest['idscript'];
  if ( $row_autotest['idscript']<> 2)
  {
    $_if_auto_test_box_calibration = "Y";
  }
  
  $idruninfowo_ENG = $row_autotest['reference'];
  $no_idruninfowo_ENGCAL=1;
    if ($row_autotest['tienecalibration_totalpass']==1 && $idruninfowo_ENG <>"")
  {
    
      $activo_paso3_totalpass = "<span class='badge bg-success'>Passed</span><br><a href='#' onclick='popuplogdb(".$idruninfowo_ENG.")'  style='color:#f39323;'>View Log <i class='fas fa-eye'> </i></a>";
  
  
  
  }
  if ($rowbuscawo['tienecalibration_totalpass']==0 && $idruninfowo_ENG <>"")
  {
    
      $activo_paso3_totalpass = "<span class='badge bg-danger'>Not Passed</span><br><a href='#' onclick='popuplogdb(".$idruninfowo_ENG.")'  style='color:#f39323;'>View Log <i class='fas fa-eye'></i></a>";
  
  }

 }

 $nombre_a_mostrar_en_dvi_calib ='Calibration :: SN: '.$vv_sn;
/////**************************************************** 
//           echo   "aaaaa".$_if_auto_test_box_calibration;
if ( $idruninfowo_ENG <>"")
{
  $activo_paso3 = "active";
  $activo_paso3_totalpass ="";
  $activo_paso3_totalpass = "<span class='badge bg-success'>Passed</span><br><a href='#' onclick='popuplogdb(".$idruninfowo_ENG.")'  style='color:#f39323;'>View Log <i class='fas fa-eye'> </i></a>";
  
}

/////
/////Buscamos el tipo de reporte para el SKU
 
$Sql_typeproducrepor = $connect->prepare(" select reporttype from products_webfas_report  where idproduct =  ".$vtempidproduct);        
            
 $name_js_report = '';    
$Sql_typeproducrepor->execute();

$result_typrepor = $Sql_typeproducrepor->fetchAll();	
foreach ($result_typrepor as $row_typerepo)
{
  $name_js_report = $row_typerepo['reporttype'];    
}

if ($no_idruninfowo_ENGCAL >0)
{
?>
<div class="step <?php echo  $activo_paso3; ?>"> 
 <a href="#" onclick="show_info('<?php echo $name_js_report;?>','<?php echo $vv_sn; ?>','<?php echo $idorderwo; ?>','<?php echo $nombre_a_mostrar_en_dvi_calib; ?>','<?php echo $idruninfowo_ENG; ?>',0)"> <span class="icon"> 
   <i class="fa fa-box"></i> </span> <span class="text"><b>ENG-CAL <br> <?php echo $activo_paso3_totalpass; ?></span></a></b> 

<?php
//////
}
 
          
         if ($no_idruninfowo_ENGCAL==0)
          {
            ?>
            <div class="step ">  <span class="icon">  <i class="fa fa-box"></i> </span> <span class="text">ENG-CAL<br>
          
            <?php if ( $v_enable_attachfile=="Y") { ?>
                 <a href="#" onclick="attachanalogbda(<?php echo $vv_idp; ?>,'<?php echo  $vv_worcenter.'_'.$psswdtkkey;?>','<?php echo $vv_sn; ?>')">
                                                                                                            <i class="fa fa-paperclip" aria-hidden="true"></i>      Attach Files
                                                     </a> <br>
                                                     <?php } ?> 
          </span> <br>
            <?php
          }

     
          
      
            
          $sqlmaxhistory = " select * from fas_to_sap_xml where v_sn ='".$vv_sn."' and v_workcenetr = '".substr($vv_worcenter,3,22)."'  and v_sku = '".$modelciuwo."' and
          runprocessdate in (
    select max(runprocessdate) from fas_to_sap_xml where v_sn ='".$vv_sn."' and v_workcenetr = '".substr($vv_worcenter,3,22)."' and v_sku = '".$modelciuwo."' )

    ";
       ///   echo $sqlmaxhistory;
            $datahist = $connect->query($sqlmaxhistory)->fetchAll();	
            foreach ($datahist as $row2hh) 
            {
                //echo $row2hh['v_state']."<br>".$row2hh['v_state_result'];
                if ($row2hh['v_state']==0)
                {
                  echo "<br><span class='badge bg-secondary' title='".$row2hh['v_state_result']."'>SAP::Pending RESORD</span>";
                }
                if ($row2hh['v_state']==1)
                {
                  echo "<br><span class='badge bg-warning' title='".$row2hh['v_state_result']."'>SAP::Run</span>";
                }
                if ($row2hh['v_state']==2)
                {
                  echo "<br><span class='badge bg-warning' title='".$row2hh['v_state_result']."'>SAP::Pending ACK</span>";
                }
                if ($row2hh['v_state']==3)
                {
                  echo "<br><span class='badge bg-danger' title='".$row2hh['v_state_result']."'>SAP::Error </span>";
                }
                if ($row2hh['v_state']==4)
                {
                    echo "<br><span class='badge bg-info' title='".$row2hh['v_state_result']."'>SAP::OK ACK</span>";
                }
                if ($row2hh['v_state']==5)
                {
                    echo "<br><span class='badge bg-danger' title='".$row2hh['v_state_result']."'>SAP::Error ACK</span>";
                }
                /// echo "<br>".$row2hh['v_state_result'];
            }  
        
     ///este div cierra ambos casos OJO       
    ?>
    </div>
    <?php
    ///////////////////////////////////////////////////////
}


function crear_steps_woinfo_ASSY($vv_worcenter,$vv_sn, $vv_idp,$vvnombre_a_mostrar_en_dvi,$vv_soworam,$vv_modelciu,$refSowo, $v_enable_attachfile)
  { 
    include("db_conect.php"); 

    $vv_worcenter_show = substr(trim($vv_worcenter),3,10);

     //// Buscamos datos de la WO
  /*   $query_wo=" select distinct 1 as orr, orders.idorders , orders.processfasserver::int as processfasserver, 
     products.modelciu,so_associed,
    orders.quantity,orders_sn.so_soft_external, orders_sn.wo_serialnumber 
                              from orders
                              inner join orders_sn 
                              on orders_sn.idorders = orders.idorders
                              inner join products
                              on products.idproduct = orders.idproduct
                           
                     
                      
                where ( orders_sn.so_associed = '".$vv_soworam."' or  orders_sn.so_soft_external = '".$vv_soworam."') and wo_serialnumber ='". $vv_sn."'"; 
                */


                if ( substr($vv_soworam,-2)=="wo" || substr($vv_soworam,-2)=="WO")
                {
                   //// Buscamos datos de la WO
                   $query_wo=" select distinct 1 as orr, orders.idorders , orders.processfasserver::int as processfasserver, 
                   products.modelciu,so_associed,
                   orders.quantity,orders_sn.so_soft_external, orders_sn.wo_serialnumber 
                                             from orders
                                             inner join orders_sn 
                                             on orders_sn.idorders = orders.idorders
                                             inner join products
                                             on products.idproduct = orders.idproduct
                               where orders_sn.so_soft_external = '".$vv_soworam."' and wo_serialnumber ='". $vv_sn."'"; 
                }
                else
                {
                        //// Buscamos datos de la WO
                        $query_wo=" select distinct 1 as orr, orders.idorders , orders.processfasserver::int as processfasserver, 
                        products.modelciu,so_associed,
                        orders.quantity,orders_sn.so_soft_external, orders_sn.wo_serialnumber 
                                                  from orders
                                                  inner join orders_sn 
                                                  on orders_sn.idorders = orders.idorders
                                                  inner join products
                                                  on products.idproduct = orders.idproduct
                                    where orders_sn.so_associed = '".$vv_soworam."' and wo_serialnumber ='". $vv_sn."' and orders.typeregister <>'UP'"; 
                }
           
                
  ///  echo    $vv_soworam."<br>Query ASSY:".$query_wo;
     $data_wo = $connect->query($query_wo)->fetchAll();	
     
     foreach ($data_wo as $rowwo) 
     {
       $modelciuwo = $rowwo['modelciu'];
       $idorderwo =  $rowwo['idorders'];
       $wo_info = $rowwo['so_soft_external'];

     }
     $vvnombre_a_mostrar_en_dvi ='Order Detail :: '.$wo_info." - SN: ".$vv_sn;        
$tienewo = "Y";
     if ($modelciuwo=="" && substr($vv_soworam,-2)=="SO")
     {
   //  echo "SI,entre aca";
        $query_wo=" select distinct 1 as orr, orders.idorders , orders.processfasserver::int as processfasserver, 
        products.modelciu,so_associed,
        orders.quantity,orders_sn.so_soft_external, orders_sn.wo_serialnumber 
                                  from orders
                                  inner join orders_sn 
                                  on orders_sn.idorders = orders.idorders
                                  inner join products
                                  on products.idproduct = orders.idproduct
                    where orders_sn.so_soft_external = '".$vv_soworam."' and wo_serialnumber ='". $vv_sn."'"; 

                 ///   echo $query_wo;

                    $data_wo = $connect->query($query_wo)->fetchAll();	
     
                    foreach ($data_wo as $rowwo) 
                    {
                      $modelciuwo = $rowwo['modelciu'];
                      $idorderwo =  $rowwo['idorders'];
                      $wo_info = $rowwo['so_soft_external'];
                      $tienewo = "N";
                    }

     }

     $elsowomarco = $vv_soworam;
     $elmodelciu = $vv_modelciu;

   //  echo "SI,entre aca".  $wo_info ;

     $psswdtkkey = substr( md5(microtime()), 1, 8);  
    if  ($vv_worcenter =="wo_ASSY" || $vv_worcenter =="so_ASSY"   )
    {
	
   ///////////////// wo_info_step1 //////////////////////////  

    
     ?>

     <div class="stepazul   active"> 
   
     <a href="#" onclick="show_info('orderinfo','<?php echo $vv_sn; ?>','<?php echo  $idorderwo ; ?>','<?php echo $vvnombre_a_mostrar_en_dvi; ?>',0,0)">
   
     <span class="icon"> <i class="fa fa-check"></i> </span>
         <span class="text text-left">
       
         <b> <?php if ($tienewo == "Y")
         {
   //       echo "WO:";
         }
         else
         {
      //    echo "SO:";
         }
         ?>
          [<?php echo $wo_info; ?>]<br> [<?php echo  $modelciuwo; ?>]</b> 
         <br><b> SN Generated: [<?php echo $vv_sn; ?>]</b><br>
       </a>
       <p class='  text-left'>
       <span class='  text-success'>
     FAS-SAP Automated
   </span>   <br>
   
    
     <a href="#"  onclick="Call_printlabel('<?php echo  $modelciuwo; ?>', '<?php echo $vv_sn; ?>' ,'<?php echo  $idorderwo ; ?>')"><i class="fas fa-print"></i> - Print Label
    
    <br> 

     <br>
   <br>
     <br>
     <br>
     </a>
   </p>
     </span> 
 
     </div>


     <?php
  ////////////// fin wo steps
    }

          $sqldetectchkeopicki="SELECT distinct   orders_sn_components.wo_serialnumber 
          FROM public.orders_sn_components_xml as orders_sn_components 
        
        inner join orders_sn
        on orders_sn.idorders = orders_sn_components.idorders and 
        orders_sn.idproduct = orders_sn_components.idproduct and
        orders_sn.so_soft_external = '".$wo_info."'  where orders_sn_components.wo_serialnumber= '".$vv_sn."'";
       
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
       
         <a href="#" onclick="show_info('picking','<?php echo $vv_sn; ?>','<?php echo $wo_info; ?>','<?php echo $modelciuwo; ?>','Quality Calibration Precheck',   '<?php echo $vv_worcenter ; ?>'  )">
         <span class="icon"> <i class="fas fa-tasks"></i> </span> 
         <span class="text">  <b><?php echo  $vv_worcenter_show;?>  <br>SN [<?php echo $vv_sn; ?>] <br></b>
        
         <?php if ( $v_enable_attachfile=="NO_Y") { ?>
        <a href="#" onclick="attachanalogbda(<?php echo $vv_idp; ?>,'<?php echo  $vv_worcenter.'_'.$psswdtkkey;?>','<?php echo $vv_sn; ?>')">
                                                                                                            <i class="fa fa-paperclip" aria-hidden="true"></i>      Attach Files
                                                     </a> <br>
        <?php } ?>                                             
        </span>
       <?php
       $sqlmaxhistory = " select * from fas_to_sap_xml where v_sn ='".$vv_sn."' and v_workcenetr = '".substr($vv_worcenter,3,22)."' and
       runinfodate in (
select max(runinfodate) from fas_to_sap_xml where v_sn ='".$vv_sn."' and v_workcenetr = '".substr($vv_worcenter,3,22)."')

";
  ///     echo $sqlmaxhistory;
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
   

  }
        ///////////////////////////////////
        function section_create_graph_VNA_by_idrun_sn2($vp_runinfo,$v_sn,$idscript, $idinstance, $v_enable_attachfile)
        { 

        include("db_conect.php"); 
        
        }
        ///////////////////////////////////
        function section_create_graph_VNA_by_idrun_sn3($vp_runinfo,$v_sn,$idscript, $idinstance, $v_enable_attachfile)
        { 

        include("db_conect.php"); 
        
        }
        ///////////////////////////////////
        ///////////////////////////////////
  
  ///////////////////////////////////
  ///////////////////////////////////
  
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
            window.location = 'trackingorderssap.php?isdo='+datosmm[0]+'&typeisdo='+datosmm[1]+'&encont='+datosmm[2];
   });


   function popuplogdb(idrunifno)
   {
    eModal.iframe('logdbonlydet.php?idab='+idrunifno,'Log Activity');
   }

  function attachanalogbda(vidord,lasemillita, vtempsn )
  {
    eModal.iframe('attachfileprojectsoaddmoreanalogbda.php?idt='+lasemillita+'&idord='+vidord+'&vvsn='+vtempsn,'Attach files to SN	  ');
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

     if (desdedonde =='calibrationmms')
     {
      eModal.iframe('autotestboxtimeline.php?hidmenu=Y&idr='+idruninfoparam,sotextoamostrar);           
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

      eModal.iframe('calibrationqualitychecklist.php?elsn='+snparam+'&elso='+soparam+'&elciu='+sotextoamostrar+'&typeworkm='+idparamafterburning,'Quality precheck');
     
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
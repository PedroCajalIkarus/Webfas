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
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="plugins/datatables/jquery.dataTables.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>

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
</form>
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
                    <h1>SAP TO FAS / FAS TO SAP</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">SAP TO FAS / FAS TO SAP</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <form action="conector2reportikarus.php" method="post" class="form-horizontal" id="myform" name="myform">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <!-- Default box -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><b>Report of XML Files Processed / Reported</b></h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        data-toggle="tooltip" title="Collapse">
                                        <i class="fas fa-minus"></i></button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove"
                                        data-toggle="tooltip" title="Remove">
                                        <i class="fas fa-times"></i></button>
                                </div>
                            </div>
                            <div class="card-body">
                                <!--  init report grahp head  -->
                                <div class="row">
                                    <div class="col-md-12">

                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-1">

                                                    <div class="container">
                                                        <div class="row">

                                                            <p align='left'>
                                                                <b>Reference:</b>
                                                                <hr>
                                                            </p>
                                                            <hr>
                                                            <p align='left'>
                                                                <span class="badge bg-warning">XML Processed</span><br>
                                                                <span class="badge bg-info">XML Received</span><br>
                                                                <span class="badge bg-red">XMl received with
                                                                    errors</span><br>
                                                                <span class="badge bg-success">XML WO-SO Already
                                                                    Created</span><br>


                                                            </p>

                                                        </div>

                                                    </div>


                                                    <!-- /.chart-responsive -->

                                                </div>

                                                <div class="col-md-6">
                                                    <p class="text-center">
                                                        <strong>This Week</strong>
                                                    </p>

                                                    <?php
      $query_listagraf = "select  EXTRACT( DOW FROM datetimeref) AS diadelasemana, status, count(distinct idruninfo) as qqq
      from fas_sap_filesxml
      inner join fas_outcome_integral_sap
      on fas_outcome_integral_sap.reference  = fas_sap_filesxml.idruninfo  and 
      fas_outcome_integral_sap.idfasoutcomecat  = 0 and
      fas_outcome_integral_sap.idtype = 12    where datetimeref > (current_date  -17 )  
	  group by diadelasemana,  status
	  ";
      $datagraf = $connect->query($query_listagraf)->fetchAll();	
      $ref =0;

      $tot_lunes_received = 0;
      $tot_lunes_procesd = 0;
      $tot_lunes_error = 0;
      $tot_lunes_send= 0;
      $tot_lunes_acesap= 0;

      $tot_martes_received = 0;
      $tot_martes_procesd = 0;
      $tot_martes_error = 0;
      $tot_martes_send= 0;
      $tot_martes_acesap= 0;
      
      $tot_mierc_received = 0;
      $tot_mierc_procesd = 0;
      $tot_mierc_error = 0;
      $tot_mierc_send= 0;
      $tot_mierc_acesap= 0;

      $tot_jueves_received = 0;
      $tot_jueves_procesd = 0;
      $tot_jueves_error = 0;
      $tot_jueves_send= 0;
      $tot_jueves_acesap= 0;

      $tot_viernes_received = 0;
      $tot_viernes_procesd = 0;
      $tot_viernes_error = 0;
      $tot_viernes_send= 0;
      $tot_viernes_acesap= 0;
      
      foreach ($datagraf as $row2graf) 
      {
          
              //Inicio Lunes
              if ( $row2graf['diadelasemana'] ==1 )
              {
               
                if ( $row2graf['status'] >1 )
                  {
                    $tot_lunes_procesd = $tot_lunes_procesd + $row2graf['qqq'];
                    $tot_lunes_received = $tot_lunes_received + $row2graf['qqq'];
                  }
                  if ( $row2graf['status'] ==3 )
                  {
                      $tot_lunes_error = $tot_lunes_error + $row2graf['qqq'];
                  }
                  if ( $row2graf['status'] ==4 )
                  {
                      $tot_lunes_send = $tot_lunes_send + $row2graf['qqq'];
                  }
                  if ( $row2graf['status'] ==5 )
                  {
                      $tot_lunes_acesap = $tot_lunes_acesap + $row2graf['qqq'];
                  }
                }
              ///fin lunes
              //Inicio martes
              if ( $row2graf['diadelasemana'] ==2 )
              {
                       
                        if ( $row2graf['status'] >1 )
                        {
                          $tot_martes_procesd = $tot_martes_procesd + $row2graf['qqq'];
                          $tot_martes_received = $tot_martes_received + $row2graf['qqq'];
                        }
                        if ( $row2graf['status'] ==3 )
                        {
                            $tot_martes_error = $tot_martes_error + $row2graf['qqq'];
                        }
                        if ( $row2graf['status'] ==4 )
                        {
                            $tot_martes_send = $tot_martes_send + $row2graf['qqq'];
                        }
                        if ( $row2graf['status'] ==5 )
                        {
                            $tot_martes_acesap = $tot_martes_acesap + $row2graf['qqq'];
                        }
              }
          ///fin martes
            //Inicio miercoles
            if ( $row2graf['diadelasemana'] ==3 )
            {
             
                if ( $row2graf['status'] >1 )
                {
                  $tot_mierc_procesd = $tot_mierc_procesd + $row2graf['qqq'];
                  $tot_mierc_received = $tot_mierc_received + $row2graf['qqq'];
                }
                if ( $row2graf['status'] ==3 )
                {
                    $tot_mierc_error = $tot_mierc_error + $row2graf['qqq'];
                }
                if ( $row2graf['status'] ==4 )
                {
                    $tot_mierc_send = $tot_mierc_send + $row2graf['qqq'];
                }
                if ( $row2graf['status'] ==5 )
                {
                    $tot_mierc_acesap = $tot_mierc_acesap + $row2graf['qqq'];
                }
            }
        ///fin miercoles
        //Inicio Jueves
        if ( $row2graf['diadelasemana'] ==4 )
        {
         
              if ( $row2graf['status'] >1 )
              {
                $tot_jueves_procesd = $tot_jueves_procesd + $row2graf['qqq'];
                $tot_jueves_received = $tot_jueves_received + $row2graf['qqq'];
              }
              if ( $row2graf['status'] ==3 )
              {
                  $tot_jueves_error = $tot_jueves_error + $row2graf['qqq'];
              }
              if ( $row2graf['status'] ==4 )
              {
                  $tot_jueves_send = $tot_jueves_send + $row2graf['qqq'];
              }
              if ( $row2graf['status'] ==5 )
              {
                  $tot_jueves_acesap = $tot_jueves_acesap + $row2graf['qqq'];
              }
          }
          ///fin jueves
          //Inicio Viernes
          if ( $row2graf['diadelasemana'] ==5 )
          {
            
            if ( $row2graf['status'] >1 )
            {
              $tot_viernes_procesd = $tot_viernes_procesd + $row2graf['qqq'];
              $tot_viernes_received = $tot_viernes_received + $row2graf['qqq'];
            }
              if ( $row2graf['status'] ==3 )
              {
                  $tot_viernes_error = $tot_viernes_error + $row2graf['qqq'];
              }
              if ( $row2graf['status'] ==4 )
              {
                  $tot_viernes_send = $tot_viernes_send + $row2graf['qqq'];
              }
              if ( $row2graf['status'] ==5 )
              {
                  $tot_viernes_acesap = $tot_viernes_acesap + $row2graf['qqq'];
              }
          }
          ///fin lunes

         
  }
      ?>

                                                    <script src="plugins/chart.js/Chart.min.js"></script>
                                                    <div class="chart">
                                                        <!-- Sales Chart Canvas -->
                                                        <canvas id="grafprogr1" name="grafprogr1" height="180"
                                                            style="height: 180px;"></canvas>

                                                        <script type="text/javascript">
                                                        var ticksStyle = {
                                                            fontColor: '#495057',
                                                            fontStyle: 'bold'
                                                        }

                                                        var mode = 'index'
                                                        var intersect = true

                                                        var $salesChart = $('#grafprogr1')
                                                        var salesChart = new Chart($salesChart, {
                                                            type: 'bar',
                                                            data: {
                                                                labels: ['Monday', 'Thuesday', 'Wednesday',
                                                                    'Thursday', 'Friday'
                                                                ],
                                                                datasets: [{
                                                                        backgroundColor: '#edb100',
                                                                        borderColor: '#edb100',
                                                                        data: [
                                                                            <?php echo $tot_lunes_procesd.",".$tot_martes_procesd.",".$tot_mierc_procesd.",".$tot_jueves_procesd.",".$tot_viernes_procesd; ?>]
                                                                    },
                                                                    {
                                                                        backgroundColor: '#007bff',
                                                                        borderColor: '#007bff',
                                                                        data: [
                                                                            <?php echo $tot_lunes_received.",".$tot_martes_received.",".$tot_mierc_received.",".$tot_jueves_received.",".$tot_viernes_received; ?>]
                                                                    },
                                                                    {
                                                                        backgroundColor: '#dc3545',
                                                                        borderColor: '#dc3545',
                                                                        data: [
                                                                            <?php echo $tot_lunes_error.",".$tot_martes_error.",".$tot_mierc_error.",".$tot_jueves_error.",".$tot_viernes_error; ?>]
                                                                    },
                                                                    {
                                                                        backgroundColor: '#28a745',
                                                                        borderColor: '#28a745',
                                                                        data: [
                                                                            <?php echo $tot_lunes_send.",".$tot_martes_send.",".$tot_mierc_send.",".$tot_jueves_send.",".$tot_viernes_send; ?>]
                                                                    },
                                                                    {
                                                                        backgroundColor: '#e9ecef',
                                                                        borderColor: '#e9ecef',
                                                                        data: [
                                                                            <?php echo $tot_lunes_acesap.",".$tot_martes_acesap.",".$tot_mierc_acesap.",".$tot_jueves_acesap.",".$tot_viernes_acesap; ?>]
                                                                    }
                                                                ]
                                                            },
                                                            options: {
                                                                maintainAspectRatio: false,
                                                                tooltips: {
                                                                    mode: mode,
                                                                    intersect: intersect
                                                                },
                                                                hover: {
                                                                    mode: mode,
                                                                    intersect: intersect
                                                                },
                                                                legend: {
                                                                    display: false
                                                                },
                                                                scales: {
                                                                    yAxes: [{
                                                                        display: false,
                                                                        gridLines: {
                                                                            display: true,
                                                                            lineWidth: '4px',
                                                                            color: 'rgba(0, 0, 0, .2)',
                                                                            zeroLineColor: 'transparent'
                                                                        },

                                                                    }],
                                                                    xAxes: [{
                                                                        display: true,
                                                                        gridLines: {
                                                                            display: false
                                                                        },
                                                                        ticks: ticksStyle
                                                                    }]
                                                                }
                                                            }
                                                        })
                                                        </script>

                                                    </div>
                                                    <!-- /.chart-responsive -->
                                                </div>
                                                <!-- /.col -->
                                                <div class="col-md-5">
                                                    <p class="text-center">
                                                        <strong>This Week</strong>
                                                    </p>
                                                    <div class=" " id="grafprogr2" name="grafprogr2">


                                                        <?php
      $query_listagraf = "select status, count(distinct idruninfo) as qqq
      from fas_sap_filesxml
      inner join fas_outcome_integral_sap
      on fas_outcome_integral_sap.reference  = fas_sap_filesxml.idruninfo  and 
      fas_outcome_integral_sap.idfasoutcomecat  = 0 and
      fas_outcome_integral_sap.idtype = 12    where datetimeref > (current_date  -17 )  
	  group by status ";
 ////   echo $query_listagraf;
      $datagraf = $connect->query($query_listagraf)->fetchAll();	
      $ref =0;

      $tot_xml = 0;
      $tot_xml_pend = 0;
      $tot_xml_procesad = 0;
      $tot_xml_witherr = 0;
      $tot_xml_confirsap = 0;
      $tot_xml_aceptsap =0;
      foreach ($datagraf as $row2graf) 
      {
          $tot_xml = $tot_xml + $row2graf['qqq'];
         if ( $row2graf['status'] <2 )
         {
            $tot_xml_pend = $tot_xml_pend + $row2graf['qqq'];
         }
         if ( $row2graf['status'] >1 )
         {
            $tot_xml_procesad = $tot_xml_procesad + $row2graf['qqq'];
         }
         if ( $row2graf['status'] ==3 )
         {
            $tot_xml_witherr = $tot_xml_witherr + $row2graf['qqq'];
         }
         if ( $row2graf['status'] ==4 )
         {
            $tot_xml_confirsap = $tot_xml_confirsap + $row2graf['qqq'];
         }
         if ( $row2graf['status'] ==5 )
         {
            $tot_xml_aceptsap = $tot_xml_aceptsap + $row2graf['qqq'];
         }

         
      }

      
      
      $porc_barra1 = round(( $tot_xml_procesad * 100) /  $tot_xml );
      $porc_barra2 = round(( $tot_xml_witherr * 100) /  $tot_xml );
      $porc_barra3 = round(( $tot_xml_confirsap * 100) /  $tot_xml );
      $porc_barra4 = round(( $tot_xml_aceptsap * 100) /  $tot_xml );
      
        ?>

                                                        <div class="progress-group">
                                                            XML Processed / Received
                                                            <span
                                                                class="float-right"><b><?php echo  $tot_xml_procesad; ?></b>/
                                                                <?php echo  $tot_xml; ?></span>
                                                            <div class="progress progress-sm">
                                                                <div class="progress-bar bg-primary"
                                                                    style="width: <?php echo   $porc_barra1; ?>%"></div>
                                                            </div>
                                                        </div>
                                                        <!-- /.progress-group -->

                                                        <div class="progress-group">
                                                            Xml received with errors
                                                            <span
                                                                class="float-right"><b><?php echo $tot_xml_witherr;?></b>
                                                            </span>
                                                            <div class="progress progress-sm">
                                                                <div class="progress-bar bg-danger"
                                                                    style="width:  <?php echo   $porc_barra2; ?>%">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- /.progress-group -->
                                                        <div class="progress-group">
                                                            <span class="progress-text">XMl WO-SO Already Created
                                                            </span>
                                                            <span
                                                                class="float-right"><b><?php echo $tot_xml_confirsap;?></b>
                                                            </span>
                                                            <div class="progress progress-sm">
                                                                <div class="progress-bar bg-success"
                                                                    style="width: <?php echo   $porc_barra3; ?>%"></div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                    <!-- /.progress-group -->
                                                </div>
                                                <!-- /.col -->
                                            </div>
                                            <!-- /.row -->

                                            <!-- /.card -->
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <!-- /.row -->
                                    <!-- end repor grahp head -->
                                </div>
                                <!-- /.card-body -->

                                <!-- /.card-footer-->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </div>
    </section>



    <hr class="colornaranajafiplex">
    <div class="card-body">

        <div class="chart">

            <h4 class='colornaranajafiplex'><strong>Custom Search</strong></h4>

            <!-- Sales Chart Canvas -->
            <div class="container-fluid ">
                <div class="input-group input-group-sm">
                    <input type="text" class="form-control" placeholder="custom search" name="txtbusqcustom"
                        id="txtbusqcustom">
                    <span class="input-group-append">
                        <br><button type="button" name="btn2" id="btn2" class="btn  btn-outline-primary btn-flat "
                            onclick="search_custom()"><i class="fas fa-search-plus"></i> Search</button>
                        <button type="button" name="btn1" id="btn1" class="btn btn-flat d-none"
                            onclick="search_custom()"><i class="fas fas fa-search" title="custom search"
                                alt="custom search"></i></button>

                    </span>
                </div>
                <?php
                            if ($_POST['txtbusqcustom'] <> '')
                            {
                            echo  "<br><div class='alert alert-success' role='alert'><b>Custom Search: ".$_POST['txtbusqcustom']."</b></div>";
                            }

                            ?>
            </div>

        </div>
        <hr>
        <div class="row">
            <div class="col-6">
                <b> <button type="button" onclick="showjsondata('divsapfas')"
                        class="btn btn-block btn-outline-primary btn-sm">SAP <i class="fa fa-solid fa-arrow-right"></i>
                        FAS <i class="fa fa-solid fa-check"></i> </b></button>
            </div>
            <div class="col-6">
                <b> <button type="button" onclick="showjsondata('divfassap')"
                        class="btn btn-block btn-outline-primary btn-sm">FAS <i class="fa fa-solid fa-arrow-right"></i>
                        SAP <i class="fa fa-solid fa-check"></i> </b> </button>
            </div>
        </div>

    </div>
    <section class="content">

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Default box -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">SAP <i class="fa fa-solid fa-arrow-right"></i> FAS</h3>


                        </div>
                        <div class="card-body" id="divsapfas" name="divsapfas">

                            <?php
         if (isset($_POST['txtbusqcustom']))
         {
          $query_lista = "select datetimeref - interval '3 hours' AS datetimeref2, fas_sap_filesxml.* , fas_outcome_integral_sap.datetimeref
          from fas_sap_filesxml
          inner join fas_outcome_integral_sap
          on fas_outcome_integral_sap.reference  = fas_sap_filesxml.idruninfo  and 
          fas_outcome_integral_sap.idfasoutcomecat  = 0 and
          fas_outcome_integral_sap.idtype = 12
          
          inner join fas_sap_filesxml_attribute  
          on fas_sap_filesxml_attribute.idruninfo  = fas_sap_filesxml.idruninfo and
          fas_sap_filesxml_attribute.v_string like  '%".$_POST['txtbusqcustom']."%'   limit 50

      
          
            ";

         
         }
         else
         {

          $query_lista = "select datetimeref - interval '3 hours' AS datetimeref2,
             fas_sap_filesxml.* , datetimeref,
          from fas_sap_filesxml
          inner join fas_outcome_integral_sap
          on fas_outcome_integral_sap.reference  = fas_sap_filesxml.idruninfo  and 
          fas_outcome_integral_sap.idfasoutcomecat  = 0 and
          fas_outcome_integral_sap.idtype = 12    where datetimeref > (current_date  - 1 )  limit 50  ";

          
         }
      $data = $connect->query($query_lista)->fetchAll();	
      $ref =0;
    
        ?>

                            <table class="table table-striped table-bordered table-sm dataTable no-footer"
                                style="font-size:12px;" name="tblfilter0" id="tblfilter0" role="grid"
                                aria-describedby="tblfilter0_info">
                                <thead>
                                    <tr>
                                        <th class="bg-primary "> Idruninfo </th>
                                        <th class="bg-primary "> Datetime </th>
                                        <th class="bg-primary "> Status </th>
                                        <th class="bg-primary "> Description Status </th>

                                        <th class="bg-primary "> SAP_FileName </th>
                                        <th class="bg-primary "> SAP_Wosoramup </th>
                                        <th class="bg-primary "> SAP_Partnumber </th>
                                        <th class="bg-primary "> SAP_Po </th>
                                        <th class="bg-primary "> SAP_Posnr </th>
                                        <th class="bg-primary "> SAP_Quantity </th>
                                        <th class="bg-primary "> Json Attributes </th>


                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

   foreach ($data as $row2) 
   {
	$indxtablaadd=0;
      
 // $decode = json_decode($row2['ffd']);

  $sap_filename="";
  $sap_action="";
  $sap_wosormaup="";
  $sap_partnumber="";
  $sap_po="";
  $sap_posnr="";
  $sap_quantity="";

   // $datajson = json_decode($row2['ffd'],true); 
  //  echo var_dump($row2['ffd']);
   $sap_filename= "";
   $SAP_Action= "";
   $SAP_Wosoramup= "";
   $SAP_Partnumber= "";
   $SAP_Po= "";
   $SAP_Posnr= "";
   $SAP_Quantity= "";
   $sap_filename= "";
   $SAP_Result_descrption_fnt="";
   
     
   $SAP_totalpass

	   ?>
                                    <td> <?php echo  $row2['idruninfo'];  ?> <a href='#'
                                            onclick='popuplogdb(<?php echo  $row2['idruninfo'];  ?>)'
                                            style='color:#f39323;'> <i class='fas fa-eye'></i></a> </td>

                                    <td> <?php echo  substr($row2['datetimeref2'],0,19);  ?></td>
                                    <?php
      echo "<td>"; 
      if ($row2['status']==0)
      {
        echo "<span class='badge bg-secondary'>Pending</span>";
      }
      if ($row2['status']==1)
      {
        echo "<span class='badge bg-warning'>Run</span>";
      }
      if ($row2['status']==2)
      {
        echo "<span class='badge bg-green'>OK</span>";
      }
      if ($row2['status']==4)
      {
        echo "<span class='badge bg-info'>Bypass</span>";
      }
      if ($row2['status']==3)
      {
         // echo "<span class='badge bg-danger'>Error</span>";
            echo "<span class='badge bg-info'>Bypass</span>";
      }
     echo "</td>";
       echo "<td>".$row2['statusresult']."</td>";


     if ($row2['typefilesanem'] =="WO")
     {

     }
     else
     {

     }
       echo "<td>".$row2['filexmlname']."</td>";
       echo "<td>".$row2['sowormaup']."</td>";
       echo "<td>".$row2['partnumber']."</td>";   
       echo "<td>".$row2['ponumber']."</td>";
       echo "<td>".$row2['posnr']."</td>";
       echo "<td>".$row2['quantity']."</td>";
       
      // echo "<td>" ;
      ?>
                                    <td><a href='#' onclick="showjsondata('jsonlbl<?php echo $row2['idruninfo']; ?>')"
                                            style="color:#f39323"> <i class="fas fa-eye"></i></a>
                                        <span id="jsonlbl<?php echo $row2['idruninfo']; ?>"
                                            name="jsonlbl<?php echo $row2['idruninfo']; ?>" class=" jsonlbl">
                                            <?php
       $sqljsonattr = "SELECT json_agg ( JSON_BUILD_OBJECT('idattribute_orders',idattribute,'attributedescription', attributedescription,
       'attributename', attributename, 'attdatatype', attdatatype, 
'v_boolean',v_boolean, 'v_integer',v_integer, 'v_double',v_double, 
'v_string',v_string)::jsonb) AS v_parametersjson 
FROM public.fas_sap_filesxml_attribute
INNER JOIN orders_attributes_type
ON fas_sap_filesxml_attribute.idattributeord = orders_attributes_type.idattribute
where fas_sap_filesxml_attribute.idruninfo = ".$row2['idruninfo'];

 
 
 
$dataJSOMSML = $connect->query($sqljsonattr)->fetchAll();	
 
foreach ($dataJSOMSML as $rowDATA2) 
{
 // echo  $rowDATA2['v_parametersjson'];
  $decoded_json = json_decode($rowDATA2['v_parametersjson'], true);

   
  foreach($decoded_json as $country) {
  //  echo var_dump($country);
      echo '<b>'.$country['attributename'].'</b> -> '.$country['v_string']."|".$country['v_integer']."|".$country['v_double'].'<br>';
  }

 
  
}



echo "</span></td>"; 
    ///   echo "</td>";

       
                echo " </tr>";      

   }

?>
                                </tbody>
                            </table>

                            <script type="text/javascript">
                            $('#tblfilter0').DataTable({
                                searching: true,
                                paging: true,
                                info: false,
                                pageLength: 500000,
                                order: [
                                    [1, 'desc']
                                ],
                            });
                            </script>


                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">

                        </div>
                        <!-- /.card-footer-->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>

    <section class="content">

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Default box -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">FAS <i class="fa fa-solid fa-arrow-right"></i> SAP</h3>


                        </div>
                        <div class="card-body" id="divfassap" name="divfassap">
                            <?php
          if (isset($_POST['txtbusqcustom']))
          {
            $query_lista = " select  
            runinfodate - interval '3 hours' AS runinfodate2,
      runprocessdate - interval '3 hours' AS runprocessdate2,
            fas_to_sap_xml.*, fas_outcome_integral.v_string as wosorma
            from fas_to_sap_xml  
        left join fas_outcome_integral on fas_outcome_integral.reference = fas_to_sap_xml.idruninfo
            and       fas_outcome_integral.idtype = 2
        and       fas_outcome_integral.idfasoutcomecat =0
        where  ( v_sn like  '%".$_POST['txtbusqcustom']."%' or
              v_sku like  '%".$_POST['txtbusqcustom']."%' or
              v_String like  '%".$_POST['txtbusqcustom']."%' )
              and v_state <9    order by runinfodate desc 
        
        ";
          }
          else
          {
      $query_lista = " select 
      runinfodate - interval '3 hours' AS runinfodate2,
      runprocessdate - interval '3 hours' AS runprocessdate2,
      fas_to_sap_xml.*, fas_outcome_integral.v_string as wosorma
      from fas_to_sap_xml  
  left join fas_outcome_integral on fas_outcome_integral.reference = fas_to_sap_xml.idruninfo
      and       fas_outcome_integral.idtype = 2
  and       fas_outcome_integral.idfasoutcomecat =0
  where  runinfodate > (current_date -1) and v_state <9      order by runinfodate desc 
  
  ";
          }
  //echo $query_lista;
      $data = $connect->query($query_lista)->fetchAll();	
      $ref =0;
    
        ?>

                            <table class="table table-striped table-bordered table-sm dataTable no-footer"
                                style="font-size:12px;" name="tblfilter1" id="tblfilter1" role="grid"
                                aria-describedby="tblfilter1_info">
                                <thead>
                                    <tr>
                                        <th class="bg-primary "> Idruninfo </th>
                                        <th class="bg-primary "> Datetime </th>
                                        <th class="bg-primary "> Datetime Process</th>
                                        <th class="bg-primary "> Status </th>
                                        <th class="bg-primary "> Description Status </th>
                                        <th class="bg-primary "> WO / SO / RMA </th>
                                        <th class="bg-primary "> PO </th>
                                        <th class="bg-primary "> SN </th>
                                        <th class="bg-primary "> PArt Number </th>
                                        <th class="bg-primary "> WorkCenter </th>
                                        <th class="bg-primary "> Json </th>


                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

   foreach ($data as $row2) 
   {
	$indxtablaadd=0;
      
 // $decode = json_decode($row2['ffd']);

  $sap_filename="";
  $sap_action="";
  $sap_wosormaup="";
  $sap_partnumber="";
  $sap_po="";
  $sap_posnr="";
  $sap_quantity="";

   // $datajson = json_decode($row2['ffd'],true); 
  //  echo var_dump($row2['ffd']);
   $sap_filename= "";
   $SAP_Action= "";
   $SAP_Wosoramup= "";
   $SAP_Partnumber= "";
   $SAP_Po= "";
   $SAP_Posnr= "";
   $SAP_Quantity= "";
   $sap_filename= "";
   $SAP_Result_descrption_fnt="";
   
    
   $SAP_totalpass

	   ?>
                                    <td> <?php echo  $row2['idruninfo'];  ?> <a href='#'
                                            onclick='popuplogdb(<?php echo  $row2['idruninfo'];  ?>)'
                                            style='color:#f39323;'> <i class='fas fa-eye'></i></a> </td>
                                    <td> <?php echo  $row2['runinfodate2'];  ?></td>
                                    <td> <?php echo  $row2['runprocessdate2'];  ?></td>
                                    <?php
       echo "<td>";
       $statemm = $row2['v_state'];
     
     
            $idrunhiss ="";
            $isbypass="N";
            $sqlmaxhistory = "select * from fas_to_sap_xml_history where idruninfo =".$row2['idruninfo']." order by  runprocessdate asc";
         //   echo $sqlmaxhistory;
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
                      $sqlackresult = "select v_string, POSITION('is already being processed by' in v_string) as isbypass, POSITION('Characteristic with confirmation number' in v_string) as isbypass2, POSITION('blocked' in v_string) as isbypass2  from fas_sap_filesxml_attribute where idruninfo =".$idrunhiss." and idattributeord in (56,57,59) ";
                   //   echo "<br>".$sqlackresult3;
                      $dataack = $connect->query($sqlackresult)->fetchAll();	
                      foreach ($dataack as $rowackm) 
                      {
                        
                          if ($rowackm['v_string'] <> '')
                          {
                              $tooltipamostrar =   $tooltipamostrar.$rowackm['v_string']."\r\n";
                              if (($rowackm['isbypass'] > 0 || $rowackm['isbypass2'] > 0) &&  $rowackm['isbypass2'] == 0 )
                              {
                                $isbypass="Y";
                              }
                          }
                          
                      } 
                          
                          
                      


                    ?>
                                    <a href='#' title="**<?php echo $tooltipamostrar;?>**"
                                        onclick='popuplogdb(<?php echo  $idrunhiss;  ?>)' style='color:#f39323;'>
                                        <?php echo $msjhistory; ?> <i class='fas fa-eye'></i></a>
                                    || <a href='viewxmlgenerate.php?idr=<?php echo  $idrunhiss; ?>' target='_blank'>
                                        <i class='fas fa-file'></i></a>
                                    </a><br>
                                    <?php
                    }

            }

            if ($isbypass=="Y" && $statemm <> 4)
            {
              echo "<span class='badge bg-warning'>ByPass OK</span>";
            }
            else
            {
                if ($statemm==0)
                {
                  echo "<span class='badge bg-secondary'>Pending RESORD</span>";
                }
                if ($statemm ==1)
                {
                  echo "<span class='badge bg-warning'>Run</span>";
                }
                if ($statemm ==2)
                {
                  echo "<span class='badge bg-warning'>Pending ACK</span>";
                }
                if ($statemm ==3)
                {
                  echo "<span class='badge bg-danger'>Error </span>";
                }
                if ( $statemm ==4)
                {
                    echo "<span class='badge bg-info'>OK ACK</span>";
                }
                if ($statemm ==5)
                {
                    echo "<span class='badge bg-danger'>Error ACK</span>";
                }
            }
            

       echo "</td>";
       echo "<td>".$row2['v_state_result'];
       /// Buscamos el ultimo run.
       echo "</td>";
       echo "<td>".$row2['wosorma']."</td>";
       echo "<td>".$row2['v_po']."</td>";
       echo "<td>".$row2['v_sn']."</td>";
       echo "<td>".$row2['v_sku']."</td>";

       echo "<td>".$row2['v_workcenetr']."</td>";
  //    echo "<td>".$row2['v_parametersjson']."</td>"; 
    ?>
                                    <td><a href='#'
                                            onclick="showjsondata('jsonlbl<?php echo $row2['idruninfo'].$row2['v_workcenetr']; ?>')"
                                            style="color:#f39323"> <i class="fas fa-eye"></i></a>
                                        <span id="jsonlbl<?php echo $row2['idruninfo'].$row2['v_workcenetr']; ?>"
                                            name="jsonlbl<?php echo $row2['idruninfo'].$row2['v_workcenetr']; ?>"
                                            class=" jsonlbl">
                                            <?php
       $parsed_json = json_decode($row2['v_parametersjson'], true);
//$parsed_json = $parsed_json['forecast']['txt_forecast']['forecastday'];
//pr($parsed_json);

$decoded_json = json_decode($row2['v_parametersjson'], true);
$name = $decoded_json['name'];
$countries = $decoded_json['countries'];
 
foreach($decoded_json as $country) {
    echo '<b>'.$country['attributename'].'</b> -> '.$country['v_string']."|".$country['v_integer'].'<br>';
}

echo "</span></td>"; 
       
                echo " </tr>";      

   }

?>
                                </tbody>
                            </table>

                            <script type="text/javascript">
                            $('#tblfilter1').DataTable({
                                searching: true,
                                paging: true,
                                info: false,
                                pageLength: 500000,
                                order: [
                                    [1, 'desc']
                                ],
                            });
                            </script>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">

                        </div>
                        <!-- /.card-footer-->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
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

<!-- ChartJS -->


<script src="js/eModal.min.js" type="text/javascript"></script>
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

    $(".jsonlbl").addClass("d-none");

});


// controlar inactividad en la web	
$(document).inactivityTimeout({
    inactivityWait: 10000,
    dialogWait: 10,
    logoutUrl: 'logout.php'
})
// fin controlar inactividad en la web		

/* requesting data */

function showjsondata(refatrabajar) {
    console.log(refatrabajar);
    //  $('#'+refatrabajar).removeClass( "d-none" );

    const divm = document.querySelector('#' + refatrabajar);
    ///divm.classList.contains('d-none'); // false
    if (divm.classList.contains('d-none') == false) {
        $('#' + refatrabajar).addClass("d-none");
    } else {
        $('#' + refatrabajar).removeClass("d-none");
    }

}


function popuplogdb(idrunifno) {
    eModal.iframe('logdbonlydet.php?idab=' + idrunifno, 'Log Activity');
}

$('#reportrange').on('apply.daterangepicker', function(ev, picker) {
    console.log(picker.startDate.format('YYYY-MM-DD'));
    $("#txtfechad").val(picker.startDate.format('YYYY-MM-DD'));
    $("#txtfechah").val(picker.endDate.format('YYYY-MM-DD'));
    console.log(picker.endDate.format('YYYY-MM-DD'));
});



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


var input = document.getElementById("txtbusqcustom");

// Execute a function when the user presses a key on the keyboardrm
input.addEventListener("keypress", function(event) {
    // If the user presses the "Enter" key on the keyboard
    if (event.key === "Enter") {
        // Cancel the default action, if needed
        event.preventDefault();
        // Trigger the button element with a click
        search_custom();
    }
});


function search_custom() {
    if ($('#txtbusqcustom').val() == '') {
        toastr["warning"]("enter the text to search...", "Alert.!");
    } else {
        toastr["success"]("Search...", "");
        document.getElementById("myform").submit();
    }
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
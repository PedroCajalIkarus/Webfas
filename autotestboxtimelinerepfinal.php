<!DOCTYPE html>
<?php 

// Desactivar toda notificación de error
error_reporting(0);
// Notificar todos los errores de PHP (ver el registro de cambios)
//error_reporting(E_ALL);
 include("db_conect.php"); 
 
 	session_start();
 
 
 
	
	
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

$hidmenu = $_REQUEST['hidmenu'];
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

            <?php 	  
if ($hidmenu=="")
{
  ?>
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
    }
  ?>

            <?php 	  
if ($hidmenu=="")
{
  include("menu.php"); 
}
 
 include("funcionesstores.php"); 
 include ('licencefiplex_mm.php');
 
   //   $Encryption = new Encryption();
        
?>


            <!-- Content Wrapper. Contains page content -->
            <?php 	  
if ($hidmenu=="")
{
  ?>
            <div class="content-wrapper">
                <?php
}
else
{
  ?>
                <div class=" ">
                    <?php
}
?>

                    <!-- Content Header (Page header) -->
                    <section class="content-header">
                        <div class="container-fluid">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <h1>Calibration Report</h1>
                                </div>
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-sm-right">
                                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                                        <li class="breadcrumb-item active">Calibration Report </li>
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

                                    <div class="" name="divscrolllog" id="divscrolllog" style="display.">
                                        <p name="msjwaitline" id="msjwaitline" align="center"><img
                                                src="img/waitazul.gif" width="100px"></p>
                                        <div class="card">

                                            <script src="jstimeline/vis-timeline-graph2d.min.js"></script>
                                            <link href="jstimeline/vis-timeline-graph2d.min.css" rel="stylesheet"
                                                type="text/css" />
                                            <style type="text/css">



                                            </style>

                                            <?php
 if ($_REQUEST['idr']=="")
 {
?>
                                            <br>
                                            <div class="col-md-3 col-sm-6 col-12">
                                                <div class="info-box bg-gradient-danger">
                                                    <span class="info-box-icon"><i
                                                            class="fas fa-exclamation-triangle"></i></span>

                                                    <div class="info-box-content">

                                                        <span class="progress-description">
                                                            Error..
                                                        </span>


                                                        <div class="progress">
                                                            <div class="progress-bar" style="width: 70%"></div>
                                                        </div>
                                                        <span class="info-box-text">missing input parameters</span>

                                                    </div>
                                                    <!-- /.info-box-content -->
                                                </div>
                                                <!-- /.info-box -->
                                            </div>
                                            <?php
  exit();
 }
 
 ?>

                                            <!-- Timeline horiz -->
                                            <div class='container-fluid'>
                                                <?php


?>
                                                <div class="card-header">
                                                    <br>
                                                    <h6 class="card-title colorazulfiplex" id="totalpassarriba"
                                                        name="totalpassarriba">
                                                    </h6>


                                                </div>
                                                <br>

                                                <!-- fin timeline horiz -->

                                                <!-- GRAFICOS ecualización -->
                                                <div id="grafgralecump" name="grafgralecump" class="">

                                                    <section class="col-lg-12 connectedSortable ui-sortable">
                                                        <br>
                                                        <h5>RF Parameters</h5>
                                                        <br><br>
                                                        <div class="row  " id="divgrafico700mp" name="divgrafico700mp">

                                                            <div class="col-6">
                                                                <hr style=" border: 1px solid #007bff;">
                                                                <p class="  colorazulfiplex" style="font-size: 1.25rem">
                                                                    <b>700 UpLink</b>
                                                                </p>
                                                                <div class="row">


                                                                    <div class="col-6  " id="divgrafico700maxpwr00"
                                                                        name="divgrafico700maxpwr00">

                                                                        <div class="chart">
                                                                            <canvas id="grafico700maxpwr00" height="250"
                                                                                width="250"
                                                                                style="height: 250;    width:250"></canvas>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6  " id="divgrafico700levelread00"
                                                                        name="divgrafico700levelread00">

                                                                        <div class="chart">
                                                                            <canvas id="grafico700levelread00"
                                                                                height="250" width="250"
                                                                                style="height: 250;width:250"></canvas>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">


                                                                    <div class="col-12   " id="divgrafico700strimd00"
                                                                        name="divgrafico700strimd00">
                                                                        <br><br>
                                                                        <!-- IMD -->

                                                                        <div class="col-12    "
                                                                            id="divgrafico700oip3mm00"
                                                                            name="divgrafico700oip3mm00">

                                                                        </div>
                                                                        <br><br>
                                                                        <div class="chart">
                                                                            <canvas id="grafico700strimd00" height="280"
                                                                                width="500"
                                                                                style="height: 280;width:500"></canvas>
                                                                        </div>

                                                                        <div class="col-12    "
                                                                            id="divgrafico700strimdlbl00"
                                                                            name="divgrafico700strimdlbl00">
                                                                            <br><br>
                                                                            <div class="chart">
                                                                                <canvas id="grafico700strimdlbl00"
                                                                                    height="280" width="500"
                                                                                    style="height: 280; width:500"></canvas>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-12    " id="divgrafico700nf00"
                                                                            name="divgrafico700nf00">
                                                                            <br><br>
                                                                            <div class="chart">
                                                                                <canvas id="grafico700nf00" height="280"
                                                                                    width="500"
                                                                                    style="height: 280; width:500"></canvas>
                                                                            </div>
                                                                        </div>








                                                                    </div>
                                                                </div>


                                                            </div>
                                                            <div class="col-6">
                                                                <hr style=" border: 1px solid #007bff;">
                                                                <p class="  colorazulfiplex" style="font-size: 1.25rem">
                                                                    <b>700 DownLink</b>
                                                                </p>
                                                                <div class="row">


                                                                    <div class="col-6  " id="divgrafico700maxpwr01"
                                                                        name="divgrafico700maxpwr01">

                                                                        <div class="chart">
                                                                            <canvas id="grafico700maxpwr01" height="250"
                                                                                width="250"
                                                                                style="height: 250;width:250"></canvas>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6  " id="divgrafico700levelread01"
                                                                        name="divgrafico700levelread01">

                                                                        <div class="chart">
                                                                            <canvas id="grafico700levelread01"
                                                                                height="250" width="250"
                                                                                style="height: 250;width:250"></canvas>
                                                                        </div>
                                                                    </div>



                                                                    <div class="col-12   " id="divgrafico700strimd01"
                                                                        name="divgrafico700strimd01">

                                                                        <!-- IMD -->
                                                                        <br><br>
                                                                        <div class="col-12    "
                                                                            id="divgrafico700oip3mm01"
                                                                            name="divgrafico700oip3mm01">

                                                                        </div>
                                                                        <br><br>

                                                                        <div class="chart">
                                                                            <canvas id="grafico700strimd01" height="280"
                                                                                width="500"
                                                                                style="height: 280;width:500"></canvas>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12  " id="divgrafico700strimdlbl01"
                                                                        name="divgrafico700strimdlbl01">
                                                                        <br><br>
                                                                        <div class="chart">
                                                                            <canvas id="grafico700strimdlbl01"
                                                                                height="280" width="500"
                                                                                style="height: 280;width:500"></canvas>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-12    " id="divgrafico700oip3mm01"
                                                                        name="divgrafico700oip3m01">

                                                                    </div>

                                                                    <div class="col-12    " id="divgrafico700nf01"
                                                                        name="divgrafico700nf01">
                                                                        <br><br>
                                                                        <div class="chart">
                                                                            <canvas id="grafico700nf01" height="280"
                                                                                width="500"
                                                                                style="height: 280; width:500"></canvas>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>



                                                        </div>
                                                        <br><br> <br><br> <br><br><br><br>
                                                        <div class="row " id="divgrafico800mp" name="divgrafico800mp">

                                                            <div class="col-6">
                                                                <hr style=" border: 1px solid #007bff;">
                                                                <p class="  colorazulfiplex" style="font-size: 1.25rem">
                                                                    <b>800 UpLink</b>
                                                                </p>
                                                                <div class="row">


                                                                    <div class="col-6" id="divgrafico800maxpwr10"
                                                                        name="divgrafico800maxpwr10">

                                                                        <div class="chart">
                                                                            <canvas id="grafico800maxpwr10" height="250"
                                                                                width="250"
                                                                                style="height: 250;width:250"></canvas>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6" id="divgrafico800levelread10"
                                                                        name="divgrafico800levelread10">

                                                                        <div class="chart">
                                                                            <canvas id="grafico800levelread10"
                                                                                height="250" width="250"
                                                                                style="height: 250;width:250"></canvas>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-12   " id="divgrafico800strimd10"
                                                                        name="divgrafico800strimd10">
                                                                        <br><br>
                                                                        <div class="col-12    "
                                                                            id="divgrafico800oip3mm00"
                                                                            name="divgrafico800oip3mm00">

                                                                        </div>

                                                                        <div class="chart">
                                                                            <canvas id="grafico800strimd10" height="280"
                                                                                width="500"
                                                                                style="height: 280;width:500"></canvas>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12   " id="divgrafico800strimdlbl10"
                                                                        name="divgrafico800strimdlbl10">
                                                                        <br><br>
                                                                        <div class="chart">
                                                                            <canvas id="grafico800strimdlbl10"
                                                                                height="280" width="500"
                                                                                style="height: 280;width:500"></canvas>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-12    " id="divgrafico800nf00"
                                                                        name="divgrafico800nf00">
                                                                        <br><br>
                                                                        <div class="chart">
                                                                            <canvas id="grafico800nf00" height="280"
                                                                                width="500"
                                                                                style="height: 280; width:500"></canvas>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>

                                                            <div class="col-6">

                                                                <hr style=" border: 1px solid #007bff;">
                                                                <p class="  colorazulfiplex" style="font-size: 1.25rem">
                                                                    <b>800 DownLink</b>
                                                                </p>
                                                                <div class="row">


                                                                    <div class="col-6" id="divgrafico800maxpwr11"
                                                                        name="divgrafico800maxpwr11">

                                                                        <div class="chart">
                                                                            <canvas id="grafico800maxpwr11" height="250"
                                                                                width="250"
                                                                                style="height: 250;width:250"></canvas>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6" id="divgrafico800levelread11"
                                                                        name="divgrafico800levelread11">



                                                                        <div class="chart">
                                                                            <canvas id="grafico800levelread11"
                                                                                height="250" width="250"
                                                                                style="height: 250;width:250"></canvas>
                                                                        </div>
                                                                        <br><br>
                                                                    </div>

                                                                    <div class="col-12    " id="divgrafico800oip3mm01"
                                                                        name="divgrafico800oip3mm01">

                                                                    </div>

                                                                    <div class="col-12   " id="divgrafico800strimd11"
                                                                        name="divgrafico800strimd11">

                                                                        <div class="chart">
                                                                            <canvas id="grafico800strimd11" height="280"
                                                                                width="500"
                                                                                style="height: 280;width:500"></canvas>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12    "
                                                                        id="divgrafico800strimdlbl11"
                                                                        name="divgrafico800strimdlbl11">
                                                                        <br><br>
                                                                        <div class="chart">
                                                                            <canvas id="grafico800strimdlbl11"
                                                                                height="280" width="500"
                                                                                style="height: 280;  width:500"></canvas>
                                                                        </div>
                                                                    </div>


                                                                    <div class="col-12    " id="divgrafico800nf01"
                                                                        name="divgrafico800nf01">
                                                                        <br><br>
                                                                        <div class="chart">
                                                                            <canvas id="grafico800nf01" height="280"
                                                                                width="500"
                                                                                style="height: 280; width:500"></canvas>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>



                                                        </div>
                                                    </section>
                                                    <section class="col-lg-12 connectedSortable ui-sortable">
                                                        <br>
                                                        <h5>Equalization</h5>

                                                        <div class="row " id="divgrafico700" name="divgrafico700">

                                                            <div class="col-6">
                                                                <hr style=" border: 1px solid #007bff;">
                                                                <p class="  colorazulfiplex" style="font-size: 1.25rem">
                                                                    <b>700 UpLink</b>
                                                                </p>
                                                                <div class="row">

                                                                    <div class="col-12 " id="divgrafico700uptotal00"
                                                                        name="divgrafico700uptotal00">
                                                                        <b>TOTAL RIPPLE</b>
                                                                        <div class="chart">
                                                                            <canvas id="grafico700uptotal00"
                                                                                height="280"
                                                                                style="height: 280;"></canvas>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6" id="divgrafico700uprx00"
                                                                        name="divgrafico700uprx00">
                                                                        <b>RX RIPPLE</b>
                                                                        <div class="chart">
                                                                            <canvas id="grafico700uprx00" height="280"
                                                                                style="height: 280;"></canvas>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6" id="divgrafico700uptx00"
                                                                        name="divgrafico700uptx00">
                                                                        <b>TX RIPPLE</b>
                                                                        <div class="chart">
                                                                            <canvas id="grafico700uptx00" height="280"
                                                                                style="height: 280;"></canvas>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                            </div>
                                                            <div class="col-6">
                                                                <hr style=" border: 1px solid #007bff;">
                                                                <p class="  colorazulfiplex" style="font-size: 1.25rem">
                                                                    <b>700 DownLink</b>
                                                                </p>
                                                                <div class="row">
                                                                    <div class="col-12" id="divgrafico700uptotal01"
                                                                        name="divgrafico700uptotal01">
                                                                        <b>TOTAL RIPPLE</b>
                                                                        <div class="chart">
                                                                            <canvas id="grafico700uptotal01"
                                                                                height="280"
                                                                                style="height: 280;"></canvas>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6" id="divgrafico700uptotal01"
                                                                        name="divgrafico700uptotal01">
                                                                        <b>RX RIPPLE</b>
                                                                        <div class="chart">
                                                                            <canvas id="grafico700uprx01" height="280"
                                                                                style="height: 280;"></canvas>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6" id="divgrafico700uptotal01"
                                                                        name="divgrafico700uptotal01">
                                                                        <b>TX RIPPLE</b>
                                                                        <div class="chart">
                                                                            <canvas id="grafico700uptx01" height="280"
                                                                                style="height: 280;"></canvas>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </div>
                                                    </section>
                                                    <section class="col-lg-12 connectedSortable ui-sortable">
                                                        <div class="row " id="divgrafico800" name="divgrafico800">
                                                            <div class="col-6">
                                                                <hr style=" border: 1px solid #007bff;">
                                                                <p class="  colorazulfiplex" style="font-size: 1.25rem">
                                                                    <b>800 UpLink</b>
                                                                </p>
                                                                <div class="row">
                                                                    <div class="col-12 " id="divgrafico800uptotal10"
                                                                        name="divgrafico800uptotal10">
                                                                        <b> TOTAL RIPPLE</b>
                                                                        <div class="chart">
                                                                            <canvas id="grafico800uptotal10"
                                                                                height="280"
                                                                                style="height: 280;"></canvas>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6 " id="divgrafico800uprx10"
                                                                        name="divgrafico800uprx10">
                                                                        <b>RX RIPPLE</b>
                                                                        <div class="chart">
                                                                            <canvas id="grafico800uprx10" height="280"
                                                                                style="height: 280;"></canvas>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6 " id="divgrafico800uptx10"
                                                                        name="divgrafico800uptx10">
                                                                        <b> TX RIPPLE</b>
                                                                        <div class="chart">
                                                                            <canvas id="grafico800uptx10" height="280"
                                                                                style="height: 280;"></canvas>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-6  ">
                                                                <hr style=" border: 1px solid #007bff;">
                                                                <p class="  colorazulfiplex" style="font-size: 1.25rem">
                                                                    <b>800 DownLink</b>
                                                                </p>

                                                                <div class="row">
                                                                    <div class="col-12 " id="divgrafico800uptotal11"
                                                                        name="divgrafico800uptotal11">
                                                                        <b> TOTAL RIPPLE </b>
                                                                        <div class="chart">
                                                                            <canvas id="grafico800uptotal11"
                                                                                height="280"
                                                                                style="height: 280;"></canvas>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6  " id="divgrafico800uprx11"
                                                                        name="divgrafico800uprx11">
                                                                        <b>RX RIPPLE</b>
                                                                        <div class="chart">
                                                                            <canvas id="grafico800uprx11" height="280"
                                                                                style="height: 280;"></canvas>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6  " id="divgrafico800uptx11"
                                                                        name="divgrafico800uptx11">
                                                                        <b> TX RIPPLE </b>
                                                                        <div class="chart">
                                                                            <canvas id="grafico800uptx11" height="280"
                                                                                style="height: 280;"></canvas>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12  " id="idreturnloss" name="idreturnloss">



                                                            </div>

                                                        </div>
                                                    </section>
                                                </div>
                                                <!-- fin GRAFICOS ecualización -->
                                                <div class='d-none'>
                                                    <section class="col-lg-12 connectedSortable ui-sortable ">
                                                        <br>
                                                        <h5>TimeLine</h5>
                                                        <hr style=" border: 1px solid #007bff;">
                                                        <div id="visualization" name="visualization"></div>
                                                    </section>
                                                </div>

                                                <hr>
                                                <br>


                                                <section class="col-lg-12 connectedSortable ui-sortable ">


                                                    <?php
                                                        include("funcionesgraphgeneric.php"); 
                                                      
                                                        $sqlnf ="
                                                        select reference, v_string  from fas_outcome_integral
                                                        where reference in (
                                                        
                                                          select reference from fas_outcome_integral
                                                         where v_string in (
                                                        select components_sn from orders_sn_components_xml where  wo_serialnumber in (
                                                          select v_string  from fas_outcome_integral
                                                          where reference = ".$_REQUEST['idr']."  and idfasoutcomecat=0 and idtype =4

                                                        ) and components_ciu like '%FCR023%')
                                                        and datetimeref in (
                                                          select max(datetimeref) as datetimeref from fas_outcome_integral where v_string in (
                                                        select components_sn from orders_sn_components_xml where  wo_serialnumber in (

                                                          select v_string  from fas_outcome_integral
where reference = ".$_REQUEST['idr']."  and idfasoutcomecat=0 and idtype =4
                                                        ) and components_ciu like '%FCR023%')
                                                        
                                                        )
                                                          
                                                        ) and idfasoutcomecat=0 and idtype =4
                                                        
                                                        ";
                                                          $dataheadr1 = $connect->query($sqlnf)->fetchAll();
                                                          
                                                          foreach ($dataheadr1 as $rowheanfd) 
                                                          {
                                                            $v_sn_fcr = $rowheanfd['v_string']; //'20211369FCR023-001E903';
                                                            $vv_idrununfo_fcr = $rowheanfd['reference']; // '106010600038288';
                                                          }

                                                        //  $v_sn_fcr="";
                                                          if ($v_sn_fcr !='')
                                                          {

                                                            ?>
                                                    <h5>Passive Filters Response</h5>
                                                    <hr style=" border: 1px solid #007bff;">
                                                    <?php
                                                            section_create_graph_VNA_by_idrun_sn_withoutplots($vv_idrununfo_fcr, $v_sn_fcr,29,'011093' ) ;
                                                            ?>
                                                </section>

                                                <?php
                                                          }
                                                     
                                                        

                                                ?>

                                            </div>
                                        </div>

                                        <?php // echo  $textoamostrar ; ?>
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
<script src="js/eModal.min.js" type="text/javascript" />

<script type="text/javascript" src="js/tabulator.min.js"></script>

<style type="text/css">
.horizontal-scroll-contenedor {
    width: auto;
    height: 100px;
    overflow-y: hidden;
    overflow-x: auto;
    padding: 10px;
    white-space: nowrap;
}

.horizontal-scroll-contenedor>div {


    margin: 0 10px 0 0;
    padding: 0;
    display: inline-block;
    text-align: center;
    line-height: 22px;
}

.step_borde_verde {

    border-radius: 20px 20px 0px 2px;
    -moz-border-radius: 20px 20px 0px 2px;
    -webkit-border-radius: 20px 20px 0px 2px;
    border: 2px solid #0d913b;
}

.step_borde_rojo {

    border-radius: 20px 20px 0px 2px;
    -moz-border-radius: 20px 20px 0px 2px;
    -webkit-border-radius: 20px 20px 0px 2px;
    border: 2px solid #ff0303;
}

.step_borde_gris {

    border-radius: 20px 20px 0px 2px;
    -moz-border-radius: 20px 20px 0px 2px;
    -webkit-border-radius: 20px 20px 0px 2px;
    border: 2px solid #696969;
}


.vis-item.orange {
    border-color: orange;
    color: black;
    background-color: orange;
}

.vis-item.red {
    border-color: red;
    color: white;
    background-color: red;
}

/*  'Unit Calibration' */
.vis-item.mm5c6bc0 {
    border-color: #5c6bc0;
    color: white;
    background-color: #5c6bc0;
}

/*  'Accept DigitalBoard' */
.vis-item.mm202020 {
    border-color: #202020;
    color: white;
    background-color: #202020;
}

/*  'Total Pass */
.vis-item.mmdb4437 {
    border-color: #db4437;
    color: white;
    background-color: #db4437;
}

/*  'Printer Services StandAlone'' */
.vis-item.mme06055 {
    border-color: #e06055;
    color: white;
    background-color: #e06055;
}

/*  'Unit Final Check'' */
.vis-item.mme06055 {
    border-color: #9e9d24;
    color: white;
    background-color: #9e9d24;
}

/*  'Print Label'' */
.vis-item.mme4776e {
    border-color: #e4776e;
    color: white;
    background-color: #e4776e;
}

/* 'Accept DiB Flex', */
.vis-item.mmf5bf26 {
    border-color: #f5bf26;
    color: white;
    background-color: #f5bf26;
}

/* 'Accept Module', */
.vis-item.mm51b886 {
    border-color: #51b886;
    color: white;
    background-color: #51b886;
}

/* Digital Module', */
.vis-item.mmab47bc {
    border-color: #ab47bc;
    color: white;
    background-color: #ab47bc;
}

/* Unit Final Check', */
.vis-item.mm9e9d24 {
    border-color: #9e9d24;
    color: white;
    background-color: #9e9d24;
}

/*'Unlock DiB, */
.vis-item.mmf06292 {
    border-color: #f06292;
    color: white;
    background-color: #f06292;
}

/* Instruments GUI, */
.vis-item.mmacab44 {
    border-color: #acab44;
    color: white;
    background-color: #acab44;
}

/* alternating column backgrounds */
.vis-time-axis .vis-grid.vis-odd {
    background: #f5f5f5;
}

/* gray background in weekends, white text color */
.vis-time-axis .vis-grid.vis-saturday,
.vis-time-axis .vis-grid.vis-sunday {
    background: gray;
}

.vis-time-axis .vis-text.vis-saturday,
.vis-time-axis .vis-text.vis-sunday {
    color: white;
}



.vis-item.red {
    border-color: red;
    color: white;
    background-color: red;
}

.vis-item.yellow {
    border-color: yellow;
    background-color: yellow;
}

.vis-item.orange {
    border-color: orange;
    background-color: orange;
}

.history-tl-container {}

.history-tl-container ul.tl {
    margin: 20px 0;
    padding: 0;
    display: inline-block;

}

.history-tl-container ul.tl li {
    list-style: none;
    margin: auto;
    margin-left: 15px;
    min-height: 50px;
    /*background: rgba(255,255,0,0.1);*/
    border-left: 1px dashed #86D6FF;
    padding: 0 0 50px 30px;
    position: relative;
}

.history-tl-container ul.tl li:last-child {
    border-left: 0;
}

.history-tl-container ul.tl li::before {
    position: absolute;
    left: -12px;
    top: -5px;
    content: " ";
    border: 8px solid rgba(255, 255, 255, 0.74);
    border-radius: 500%;
    background: #258CC7;
    height: 20px;
    width: 20px;
    transition: all 500ms ease-in-out;

}

.history-tl-container ul.tl li:hover::before {
    border-color: #258CC7;
    transition: all 1000ms ease-in-out;
}

ul.tl li .item-title {}

ul.tl li .item-detail {
    color: rgba(0, 0, 0, 0.5);
    font-size: 12px;
}

ul.tl li .timestamp {
    color: #8D8D8D;
    position: absolute;
    width: 100px;
    left: -60%;
    text-align: right;
    font-size: 12px;
}

/*
 
		'#f06292' =>',
		'#acab44' =>''
*/

.htimeline {
    list-style: none;
    padding: 0;
    margin: 20px 0 0;
}

.htimeline .step {
    float: left;
    border-top-style: solid;
    border-top-width: 5px;
    position: relative;
    margin-bottom: 25px;
    text-align: left;
    padding: 3px 0 5px 10px;
    background-color: #ddd;
    color: #333;
    vertical-align: middle;
    border-right: solid 1px #bbb;
    transition: all 0.5s ease;
}

.htimeline .step:nth-child(odd) {
    background-color: #eee;
}

.htimeline .step:first-child {
    border-left: solid 1px #bbb;
}

.htimeline .step:hover {
    background-color: #ccc;
    border-bottom-width: 6px;
}

.htimeline .step>div {
    margin: 0 5px;
    font-size: 14px;
    vertical-align: top;
    padding: 0;
}

.htimeline .step.green {
    border-top-color: #348F50;
}

.htimeline .step.orange {
    border-top-color: #F09819;
}

.htimeline .step.red {
    border-top-color: #C04848;
}

.htimeline .step.blue {
    border-top-color: #49a09d;
}

.htimeline .step::before {
    width: 15px;
    height: 15px;
    border-radius: 50px;
    content: ' ';
    background-color: white;
    position: absolute;
    top: -10px;
    left: 0px;
    border-style: solid;
    border-width: 3px;
    transition: all 0.5s ease;
}

.htimeline .step:hover::before {
    width: 18px;
    height: 18px;
    bottom: -12px;
}

.htimeline .step.green::before {
    border-color: #348F50;
}

.htimeline .step.orange::before {
    border-color: #F09819;
}

.htimeline .step.red::before {
    border-color: #C04848;
}

.htimeline .step.blue::before {
    border-color: #49a09d;
}

.htimeline .step::after {
    content: attr(data-date);
    position: absolute;
    top: -20px;
    left: 17px;
    font-size: 11px;
    font-style: italic;
    color: #888
}

/*TASKS*/
.htimeline .step .tasks {
    margin-top: 10px;
}

.htimeline .step .tasks .resource {
    position: relative;
    height: 40px;
}

.htimeline .step .tasks .resource::before {
    position: absolute;
    bottom: 2px;
    left: -5px;
    content: attr(data-name);
    font-size: 10px;
    font-style: italic;
    color: #888
}

.htimeline .step .tasks .task {
    overflow: hidden;
    font-size: 10px;
    padding: 3px;
    border: solid 1px white;
    border-radius: 4px;
    min-height: 20px;
}

.htimeline .step.green .tasks .task {
    background-color: #348F50;
    color: white;
}

.htimeline .step.orange .tasks .task {
    background-color: #F09819;
    color: white;
}

.htimeline .step.red .tasks .task {
    background-color: #C04848;
    color: white;
}

.htimeline .step.blue .tasks .task {
    background-color: #49a09d;
    color: white;
}
</style>


</body>
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<link rel="stylesheet" href="plugins/sweetalert2/sweetalert2.min.css">
<script src="plugins/chart.js/Chart.min.js"></script>

<script type="text/javascript">
var cant_veces_controlo = 0;
var cant_veces_controlo_limit = 15;
var container = document.getElementById('visualization');
var timeline = new vis.Timeline(container);
var refreshIntervalIdbuscaruninfo = 0;

var datamm = {};
var iduniqueop_band_0_uldl_0_tx = "";
var iduniqueop_band_0_uldl_1_tx = "";
var iduniqueop_band_1_uldl_0_tx = "";
var iduniqueop_band_1_uldl_1_tx = "";
var label_tx = {};
var label_tx_0_1 = {};
var label_tx2 = "";
var label_tx_1 = "";
var datax = '';
var label_700_compartir = '';

var graf_total_0_0 = "N";
var graf_rx_0_0 = "N";
var graf_tx_0_0 = "N";
var graf_total_0_1 = "N";
var graf_rx_0_1 = "N";
var graf_tx_0_1 = "N";
var graf_total_1_0 = "N";
var graf_rx_1_0 = "N";
var graf_tx_1_0 = "N";
var graf_total_1_1 = "N";
var graf_rx_1_1 = "N";
var graf_tx_1_1 = "N";

// recuperamos el querystring
const querystring = window.location.search
console.log(querystring) // '?q=pisos+en+barcelona&ciudad=Barcelona'

// usando el querystring, creamos un objeto del tipo URLSearchParams
const params = new URLSearchParams(querystring)

function window_mouseout(obj, evt, fn) {

    if (obj.addEventListener) {

        obj.addEventListener(evt, fn, false);
    } else if (obj.attachEvent) {

        obj.attachEvent('on' + evt, fn);
    }
}




$(document).ready(function() {

    //Inicio mostrar hora live

    var idrunrun = params.get('idr');
    console.log('idrun:' + params.get('idr'));

    var interval = setInterval(function() {

        var momentNow = moment();
        var newYork = momentNow.tz('America/New_York').format('ha z');
        $('#date-part').html(momentNow.format('YYYY/MM/DD'));
        $('#time-part').html(momentNow.format('hh:mm:ss'));
    }, 100);
    //FIN mostrar hora live
    console.log("ready!");



    /*
    window_mouseout( document, 'mouseout', event => {

    event = event ? event : window.event;

    var from         = event.relatedTarget || event.toElement;

    // Si quieres que solo salga una vez el mensaje borra lo comentado
    // y así se guarda en localStorage

    // let leftWindow   = localStorage.getItem( 'leftWindow' ) || false;

    if (  (!from || from.nodeName === 'HTML') ) {

        console.log('¿Quieres abandonar mi página?');
        
    }
    } );
    */

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


    $('#msjwaitline ').hide();

    /// 1|primer linea de tiempo con DIV Horizontales
    //timeline_listrutines_init(idrunrun);
    //  timeline_listrutines(idrunrun); // no se usa mas
    buscarycentrartimeline();
    /// 2| segundo timeline con js.
    timeline_rutimes();

    //funcion vieja solo para el LOAD
    //  timeline_autocall(idrunrun);
    ///fin autorefresh del timeline


});


// controlar inactividad en la web	
$(document).inactivityTimeout({
    inactivityWait: 10000,
    dialogWait: 10,
    logoutUrl: 'logout.php'
})
// fin controlar inactividad en la web		

function timeline_listrutines_init(idrunaconsultar) {


    var formData = new FormData();
    var req = new XMLHttpRequest();

    formData.append("idr", idrunaconsultar);

    formData.append("btnt1v", $('#btnt1v').val());
    formData.append("btnt2v", $('#btnt2v').val());
    formData.append("btnt3v", $('#btnt3v').val());
    formData.append("btnt4v", $('#btnt4v').val());
    formData.append("btnt5v", $('#btnt5v').val());
    formData.append("btnt6v", $('#btnt6v').val());




    ///req.open('GET', 'fasclient_query.php');
    req.open("POST", "ajax_html_timelinerutinelist.php");
    req.send(formData);



    req.onload = function() {
        if (req.status == 200) {

            //  console.log(req.response);
            //     console.log('refresco div horiz init');
            $("#timelinerutines").html('');

            $("#timelinerutines").html(req.response);
            //   var losresultado = req.response.split("#");

            //  clearInterval(refreshIntervalIdbuscaruninfo);                 
            //  clearInterval(refreshIntervalId);         


            $('#msjwaitline1').hide();
            $("#msjwaitline1").addClass('d-none');

        }

    };



}


function timeline_listrutines(idrunaconsultar) {
    //  console.log('refresco  horiz postaaa');
    //  refreshIntervalIdbuscaruninfo = setInterval(function() {

    //	 console.log('espero resultado del id_petition:'+$('#idpetitionrun').val());

    //Enviamos los datos a procesar
    return new Promise(function(resolve, reject) {
        var formData = new FormData();
        var req = new XMLHttpRequest();

        formData.append("idr", idrunaconsultar);

        formData.append("btnt1v", $('#btnt1v').val());
        formData.append("btnt2v", $('#btnt2v').val());
        formData.append("btnt3v", $('#btnt3v').val());
        formData.append("btnt4v", $('#btnt4v').val());
        formData.append("btnt5v", $('#btnt5v').val());
        formData.append("btnt6v", $('#btnt6v').val());




        ///req.open('GET', 'fasclient_query.php');
        req.open("POST", "ajax_html_timelinerutinelist.php");
        req.send(formData);



        req.onload = function() {
            if (req.status == 200) {

                //  console.log(req.response);
                //      console.log('refresco div horiz postaaa');
                $("#timelinerutines").html('');

                $("#timelinerutines").html(req.response);
                //   var losresultado = req.response.split("#");

                //  clearInterval(refreshIntervalIdbuscaruninfo);                 
                //  clearInterval(refreshIntervalId);         

                resolve(1);
                $('#msjwaitline1').hide();
                $("#msjwaitline1").addClass('d-none');

            } else {
                reject();
            }
        };


    })
    //fin enviar datos a procesar
    //   }, 10000);	    


}


function posicionarme_div(divaposicionar) {

    var current = $('#timelinerutines').scrollLeft();
    var left = $('#' + divaposicionar).position().left;

    event.preventDefault();

    $('#timelinerutines').animate({
        scrollLeft: current + left - 100
    }, 200);

}

///filtrarme_list_rutine(1,'TOTAL',1);

function filtrarme_list_rutine(idbtn, tipobtn, valor) {

    // msjwaitline1
    $("#msjwaitline1").removeClass('d-none');
    $('#msjwaitline1').show();
    $("#timelinerutines").html('');


    if (idbtn == 1) {
        if ($('#btnt' + idbtn).html().includes('far fa-check-circle') == false) {
            $('#btnt' + idbtn).html('');
            $('#btnt' + idbtn).html(' <i class=\"far fa-check-circle\"></i> Passed');
            $('#btnt' + idbtn + 'v').val('true');

        } else {
            $('#btnt' + idbtn).html('');
            $('#btnt' + idbtn).html(' Passed');
            $('#btnt' + idbtn + 'v').val('false');
        }
    }
    if (idbtn == 2) {
        if ($('#btnt' + idbtn).html().includes('far fa-check-circle') == false) {
            $('#btnt' + idbtn).html('');
            $('#btnt' + idbtn).html(' <i class=\"far fa-check-circle\"></i> Not Passed');
            $('#btnt' + idbtn + 'v').val('true');
        } else {
            $('#btnt' + idbtn).html('');
            $('#btnt' + idbtn).html(' Not Passed');
            $('#btnt' + idbtn + 'v').val('false');
        }
    }
    if (idbtn == 3) {
        if ($('#btnt' + idbtn).html().includes('far fa-check-circle') == false) {
            $('#btnt' + idbtn).html('');
            $('#btnt' + idbtn).html(' <i class=\"far fa-check-circle\"></i> BAND 0');
            $('#btnt' + idbtn + 'v').val(1);
        } else {
            $('#btnt' + idbtn).html('');
            $('#btnt' + idbtn).html(' BAND 0');
            $('#btnt' + idbtn + 'v').val(0);
        }
    }
    if (idbtn == 4) {
        if ($('#btnt' + idbtn).html().includes('far fa-check-circle') == false) {
            $('#btnt' + idbtn).html('');
            $('#btnt' + idbtn).html(' <i class=\"far fa-check-circle\"></i> BAND 1');
            $('#btnt' + idbtn + 'v').val(1);
        } else {
            $('#btnt' + idbtn).html('');
            $('#btnt' + idbtn).html(' BAND 1');
            $('#btnt' + idbtn + 'v').val(0);
        }
    }
    if (idbtn == 5) {
        if ($('#btnt' + idbtn).html().includes('far fa-check-circle') == false) {
            $('#btnt' + idbtn).html('');
            $('#btnt' + idbtn).html(' <i class=\"far fa-check-circle\"></i> ULDL 0');
            $('#btnt' + idbtn + 'v').val(1);
        } else {
            $('#btnt' + idbtn).html('');
            $('#btnt' + idbtn).html(' ULDL 0');
            $('#btnt' + idbtn + 'v').val(0);
        }
    }
    if (idbtn == 6) {
        if ($('#btnt' + idbtn).html().includes('far fa-check-circle') == false) {
            $('#btnt' + idbtn).html('');
            $('#btnt' + idbtn).html(' <i class=\"far fa-check-circle\"></i> ULDL 1');
            $('#btnt' + idbtn + 'v').val(1);
        } else {
            $('#btnt' + idbtn).html('');
            $('#btnt' + idbtn).html(' ULDL 1');
            $('#btnt' + idbtn + 'v').val(0);
        }
    }
    var idrunrun = params.get('idr');
    //console.log('btn refresca rapido ' + idrunrun );
    timeline_listrutines(idrunrun);

}

function stop_rutinas_autorerefresh() {
    clearInterval(refreshIntervalIdbuscaruninfo);
    $("#btntref1").removeClass("btn-outline-primary");
    $("#btntref2").removeClass("btn-outline-primary");
    $("#btntref3").removeClass("btn-outline-primary");
    $("#btntref1").addClass("btn-outline-secondary");
    $("#btntref2").addClass("btn-outline-secondary");
    $("#btntref3").addClass("btn-outline-secondary");
}

function rutinas_autorerefresh(cant_milisegundos) {

    $("#btntref1").removeClass("btn-outline-primary");
    $("#btntref2").removeClass("btn-outline-primary");
    $("#btntref3").removeClass("btn-outline-primary");
    $("#btntref1").addClass("btn-outline-secondary");
    $("#btntref2").addClass("btn-outline-secondary");
    $("#btntref3").addClass("btn-outline-secondary");


    if (cant_milisegundos == 10000) {
        $("#btntref1").removeClass("btn-outline-secondary");
        $("#btntref1").addClass("btn-outline-primary");
    }
    if (cant_milisegundos == 30000) {
        $("#btntref2").removeClass("btn-outline-secondary");
        $("#btntref2").addClass("btn-outline-primary");
    }
    if (cant_milisegundos == 60000) {
        $("#btntref3").removeClass("btn-outline-secondary");
        $("#btntref3").addClass("btn-outline-primary");
    }



    //  console.log('refresco  horiz postaaa');
    refreshIntervalIdbuscaruninfo = setInterval(function() {

        //	 console.log('espero resultado del id_petition:'+$('#idpetitionrun').val());

        //Enviamos los datos a procesar
        return new Promise(function(resolve, reject) {
            var formData = new FormData();
            var req = new XMLHttpRequest();
            var idrunaconsultar = params.get('idr');
            formData.append("idr", idrunaconsultar);

            formData.append("btnt1v", $('#btnt1v').val());
            formData.append("btnt2v", $('#btnt2v').val());
            formData.append("btnt3v", $('#btnt3v').val());
            formData.append("btnt4v", $('#btnt4v').val());
            formData.append("btnt5v", $('#btnt5v').val());
            formData.append("btnt6v", $('#btnt6v').val());




            ///req.open('GET', 'fasclient_query.php');
            req.open("POST", "ajax_html_timelinerutinelist.php");
            req.send(formData);



            req.onload = function() {
                if (req.status == 200) {

                    //  console.log(req.response);
                    //      console.log('refresco div horiz postaaa');
                    $("#timelinerutines").html('');

                    $("#timelinerutines").html(req.response);
                    //   var losresultado = req.response.split("#");

                    //  clearInterval(refreshIntervalIdbuscaruninfo);                 
                    //  clearInterval(refreshIntervalId);         

                    resolve(1);
                    $('#msjwaitline1').hide();
                    $("#msjwaitline1").addClass('d-none');

                } else {
                    reject();
                }
            };


        })
        //fin enviar datos a procesar
    }, cant_milisegundos);


}

function timeline_autocall(idrunaconsultar) {
    $('#msjwaitline').hide();
    cant_veces_controlo = cant_veces_controlo + 1;

    var options = {
        // option groupOrder can be a property name or a sort function
        // the sort function must compare two groups and return a value
        //     > 0 when a > b
        //     < 0 when a < b
        //       0 when a == b
        groupOrder: function(a, b) {
            return a.value - b.value;
        },
        groupOrderSwap: function(a, b, groups) {
            var v = a.value;
            a.value = b.value;
            b.value = v;
        },
        groupTemplate: function(group) {
            var container = document.createElement('div');
            var label = document.createElement('span');
            label.innerHTML = group.content + ' ';
            container.insertAdjacentElement('afterBegin', label);
            var hide = document.createElement('button');
            hide.innerHTML = 'hide';
            hide.style.fontSize = 'small';
            hide.addEventListener('click', function() {
                groups.update({
                    id: group.id,
                    visible: false
                });
            });
            //  container.insertAdjacentElement('beforeEnd',hide);
            return container;
        },
        orientation: 'both',
        editable: false,
        groupEditable: false,
        locale: 'en',
        zoomKey: 'ctrlKey',
        maxHeight: '500px',
        minHeight: '500px'
    };


    var items = new vis.DataSet();
    var groups = new vis.DataSet();

    buscarycentrartimeline();

    /*

        refreshIntervalIdbuscaruninfo = setInterval(function() {
    				 
             //	 console.log('espero resultado del id_petition:'+$('#idpetitionrun').val());
                
                //Enviamos los datos a procesar
              return new Promise(function(resolve, reject) {
                 var formData = new FormData();
             var req = new XMLHttpRequest();        
             formData.append("idr", idrunaconsultar);   
             ///req.open('GET', 'fasclient_query.php');
             req.open("POST", "ajax_timelinejsonautotestbox2.php");
             req.send(formData);
             
           
             
               req.onload = function() {
                 if (req.status == 200) {
              
                    //   console.log(req.response);
                         
                      
                          
                          //      console.log(JSON.parse( req.response ));
                          //     console.log(losgroupx);
                          var data = JSON.parse( req.response );
                          var datax =  data.items;
                          var losgroupx =data.grupos;
                          var lostitulo =data.titulo[0];
                          var data_returnloss =data.returnloss[0];
                          console.log('return loss');
                          			console.log(data_returnloss);
                            items.clear();
                          items.add(datax);
                          groups.clear();
                          groups.add( losgroupx) ;
                      //    timeline.destroy();
                        //var  timeline = new vis.Timeline(container);
                          timeline.setOptions(options);
                          timeline.setGroups(groups);
                          timeline.setItems(items);
                          timeline.redraw();
                          //console.log('mostrar -1');

                          
                          timeline.fit('linear');
                    //      console.log('nodeberia salir esto:'+lostitulo);
                          console.log(lostitulo.totalpass);
                          var laduracionamostrar='';
                          var titulo_time='';
                          if ( lostitulo.duration == '00:00:00')
                          {
                            laduracionamostrar= lostitulo.durationpartial;
                            titulo_time='Execution time: ';
                          }
                          else
                          {
                            laduracionamostrar= lostitulo.duration;
                            titulo_time='Total run time: ';
                          }
                          if (lostitulo.totalpass =="1")
                          {
                            //aca marco
                              //$('#totalpassarriba').html('<b>'+  lostitulo.modelciu+ ' :: '+  lostitulo.sn +' </b> || \t\t<span class=\"badge badge-pill badge-success\">Passed</span> ||  <i class=\"far fa-clock\" style=\"font-size:24px\"></i> '+  titulo_time + laduracionamostrar +' &nbsp;&nbsp; <i class=\"far fa-calendar-alt\" style=\"font-size:24px\"></i>  Date: '+ lafechaamostrar +'');
                              $('#totalpassarriba').html('<b>'+  lostitulo.modelciu+ ' :: '+  lostitulo.sn +' </b> || '+  titulo_time + laduracionamostrar +' &nbsp;&nbsp; <i class=\"far fa-clock\" style=\"font-size:24px\"></i>&nbsp;&nbsp; Date: '+ lostitulo.datetimelogtotal+'<br><span style=\"font-size:24px\"> <span class=\"badge badge-pill badge-success\">Passed</span></span>');
                          }
                          if (lostitulo.totalpass =="0")
                          {
                          //  $('#totalpassarriba').html('<b>'+  lostitulo.modelciu+ ' :: '+  lostitulo.sn +' </b> || \t\t <i class=\"far fa-clock\" style=\"font-size:24px\"></i> '+  titulo_time + laduracionamostrar +' &nbsp;&nbsp; <i class=\"far fa-calendar-alt\" style=\"font-size:24px\"></i> Date: '+ lafechaamostrar+'');
                            $('#totalpassarriba').html('<b>'+  lostitulo.modelciu+ ' :: '+  lostitulo.sn +' </b> || '+  titulo_time + laduracionamostrar +' &nbsp;&nbsp; <i class=\"far fa-clock\" style=\"font-size:24px\"></i>&nbsp;&nbsp; Date: '+ lostitulo.datetimelogtotal+'<br><span style=\"font-size:24px\"> <span class=\"badge badge-pill badge-danger\">Not Passed</span></span>');
                          }
                          if (lostitulo.totalpass =='')
                          { 
                            $('#totalpassarriba').html('<b>'+  lostitulo.modelciu + ' :: '+  lostitulo.sn +' </b> || '+  titulo_time + laduracionamostrar +'  <i class=\"far fa-clock\" style=\"font-size:24px\"></i>&nbsp;&nbsp; Date: '+ lafechaamostrar +' ');
                            
                          }


                          ////mostramos Calibration_Threshold_ReturnLoss_Loaded Calibration_Threshold_ReturnLoss_Unloaded
                          
                      //    $('#idreturnloss').html('');
                          //var amostrar_table = '<table class="table"><thead class="thead-dark"><tr><th scope="col">700 DL</th><th scope="col">Value</th><th scope="col">800 DL</th><th scope="col">Value</th></tr></thead><tbody>              <tr><th >Loaded</th><td>'+data_returnloss.700_Loaded+'</td><td>Loaded</td><td>'+data_returnloss.800_Loaded+'</td></tr><tr><th >Unloaded</th><td>'+data_returnloss.700_UnLoaded+'</td><td>Unloaded</td><td>'+data_returnloss.800_UnLoaded+'</td></tr><tr><th >Threshold</th><td>'+data_returnloss.700_Threshold+'</td><td>Threshold</td><td>'+data_returnloss.800_Threshold+'</td></tr></tbody></table>';
                      //    $('#idreturnloss').html(amostrar_table);


                          ////fin  mostramos Calibration_Threshold_ReturnLoss_Loaded Calibration_Threshold_ReturnLoss_Unloaded


                         
                          //console.log('mostrar -1a');
                          setTimeout('buscarycentrartimeline()', 1000);

                                    document.getElementById('visualization').onclick = function (event)
                                      {
                                        var props = timeline.getEventProperties(event)
                                   //     console.log(props);
                                     //   console.log(props.item);
                                              if(props.item != null && props.item != '') {
                                                saludame(props.item);
                                            // do something
                                          }
                                        
                                      }
                     
                      resolve(1);
                 
                 }
                 else {
                     reject();
                 }
               };
       
             
             })
           //fin enviar datos a procesar
          }, 200000);	  
          */


}


///funciona andandno
function timeline_rutimes() {
    ///Agregamos el timeline 1.



    cant_veces_controlo = cant_veces_controlo + 1;

    var options = {
        // option groupOrder can be a property name or a sort function
        // the sort function must compare two groups and return a value
        //     > 0 when a > b
        //     < 0 when a < b
        //       0 when a == b
        groupOrder: function(a, b) {
            return a.value - b.value;
        },
        groupOrderSwap: function(a, b, groups) {
            var v = a.value;
            a.value = b.value;
            b.value = v;
        },
        groupTemplate: function(group) {
            var container = document.createElement('div');
            var label = document.createElement('span');
            label.innerHTML = group.content + ' ';
            container.insertAdjacentElement('afterBegin', label);
            var hide = document.createElement('button');
            hide.innerHTML = 'hide';
            hide.style.fontSize = 'small';
            hide.addEventListener('click', function() {
                groups.update({
                    id: group.id,
                    visible: false
                });
            });
            //  container.insertAdjacentElement('beforeEnd',hide);
            return container;
        },
        orientation: 'both',
        editable: false,
        groupEditable: false,
        start: new Date(Date.UTC(2021, 05, 21, 11, 44, 0)),
        end: new Date(Date.UTC(2021, 05, 21, 15, 0, 0)),
        locale: 'en',
        zoomKey: 'ctrlKey',
        maxHeight: '500px',
        minHeight: '500px'
    };


    var items = new vis.DataSet();
    var groups = new vis.DataSet();


    $.ajax({
        url: 'ajax_timelinejsonautotestbox.php?idruninfo=' + params.get('idr'),
        data: "idlog=",
        type: 'post',
        async: true,
        cache: false,
        success: function(data) {
            ////  console.log(data);

            $('#msjwaitline').hide();

            var datax = data.items;
            var losgroupx = data.grupos;
            var lostitulo = data.titulo[0];
            var data_returnloss = data.returnloss[0];
            console.log('return loss');
            console.log(data_returnloss);
            //			console.log(datax);
            //     console.log(lostitulo);

            /*  items.add(datax);
               groups.clear();
               groups.add( losgroupx) ;

               timeline.setOptions(options);
               timeline.setGroups(groups);
               timeline.setItems(items);*/

            //  console.log('mostrar totalpass'+lostitulo.totalpass );


            //   timeline.fit('linear');

            var laduracionamostrar = '';
            var titulo_time = '';
            if (lostitulo.duration == '00:00:00') {
                laduracionamostrar = lostitulo.durationpartial;
                titulo_time = 'Execution time: ';
                lafechaamostrar = lostitulo.datetimelogparcial;
            } else {
                laduracionamostrar = lostitulo.duration;
                titulo_time = 'Total run time: ';
                lafechaamostrar = lostitulo.datetimelogtotal;
            }
            if (lostitulo.totalpass == "1") {
                //aca marco
                //$('#totalpassarriba').html('<b>'+  lostitulo.modelciu+ ' :: '+  lostitulo.sn +' </b> || \t\t<span class=\"badge badge-pill badge-success\">Passed</span> ||  <i class=\"far fa-clock\" style=\"font-size:24px\"></i> '+  titulo_time + laduracionamostrar +' &nbsp;&nbsp; <i class=\"far fa-calendar-alt\" style=\"font-size:24px\"></i>  Date: '+ lafechaamostrar +'');
                $('#totalpassarriba').html('<b>' + lostitulo.modelciu_so + ' :: ' + lostitulo.sn +
                    ' </b> ||' +
                    '  <i class=\"far fa-clock\" style=\"font-size:24px\"></i>&nbsp;&nbsp; Date: ' +
                    lostitulo.datetimelogtotal +
                    '<br><span style=\"font-size:24px\"> <span class=\"badge badge-pill badge-success\">Passed</span></span>'
                );
            }
            if (lostitulo.totalpass == "0") {
                //  $('#totalpassarriba').html('<b>'+  lostitulo.modelciu+ ' :: '+  lostitulo.sn +' </b> || \t\t <i class=\"far fa-clock\" style=\"font-size:24px\"></i> '+  titulo_time + laduracionamostrar +' &nbsp;&nbsp; <i class=\"far fa-calendar-alt\" style=\"font-size:24px\"></i> Date: '+ lafechaamostrar+'');
                $('#totalpassarriba').html('<b>' + lostitulo.modelciu_so + ' :: ' + lostitulo.sn +
                    ' </b> ||' +
                    '   <i class=\"far fa-clock\" style=\"font-size:24px\"></i>&nbsp;&nbsp; Date: ' +
                    lostitulo.datetimelogtotal +
                    '<br><span style=\"font-size:24px\"> <span class=\"badge badge-pill badge-danger\">Not Passed</span></span>'
                );
            }
            if (lostitulo.totalpass == '') {
                $('#totalpassarriba').html('<b>' + lostitulo.modelciu_so + ' :: ' + lostitulo.sn +
                    ' </b> || ' + titulo_time + laduracionamostrar +
                    '  <i class=\"far fa-clock\" style=\"font-size:24px\"></i>&nbsp;&nbsp; Date: ' +
                    lafechaamostrar + ' ');

            }


            $('#idreturnloss').html('');
            var amostrar_table =
                '<br>  <h5>Calibration Values</h5><hr style=" border: 1px solid #007bff;"><table class="table"><thead class="thead-dark"><tr><th scope="col">700 DL</th><th scope="col">Value</th><th scope="col">800 DL</th><th scope="col">Value</th></tr></thead><tbody>              <tr><th >Return Loss Loaded</th><td>' +
                data_returnloss.v700_Loaded + ' dB</td><th>Return Loss Loaded</th><td>' + data_returnloss
                .v800_Loaded + ' dB</td></tr><tr><th >Return Loss Unloaded</th><td>' + data_returnloss
                .v700_UnLoaded + ' dB</td><th>Return Loss Unloaded</th><td>' + data_returnloss
                .v800_UnLoaded + ' dB</td></tr><tr><th >Return LossThreshold</th><td>' + data_returnloss
                .v700_Threshold + ' dB</td><th> Return Loss Threshold</th><td>' + data_returnloss
                .v800_Threshold + ' dB</td></tr></tbody></table>';
            $('#idreturnloss').html(amostrar_table);


            //console.log('mostrar -1a');
            setTimeout('buscarycentrartimeline()', 1000);

            /*   document.getElementById('visualization').onclick = function (event)
                 {
                   var props = timeline.getEventProperties(event)
              //     console.log(props);
                //   console.log(props.item);
                         if(props.item != null && props.item != '') {
                           saludame(props.item);
                       // do something
                     }
                   
                 }*/

        }
    });




    // function to make all groups visible again
    function showAllGroups() {
        groups.forEach(function(group) {
            groups.update({
                id: group.id,
                visible: true
            });
        })
    };

}

function sumArray(a, b) {
    var c = [];
    for (var i = 0; i < Math.max(a.length, b.length); i++) {
        c.push(parseFloat(a[i] || 0) + parseFloat(b[i] || 0));
    }
    return c;
}

function buscarycentrartimeline() {

    /*
  ----ult grafic timeline
  timeline.fit('linear');
  timeline.focus(75);
 // console.log('aca marc');    
  timeline.fit('linear');
  */

    armar_graficos_eq();
    armar_graficos_maxprw();
    //armar_graficos_levelread(); lo meti dentro de la funcion maxpwr porq depende de muchas lbl compartidos

    armar_graficos_imdstress();


}




function saludame(nombtr) {
    //alert('a' + nombtr);/
    //eModal.iframe('labelprintermultisn.php?vciu='+1+'&vsn='+1+'&vidord='+1,'Label printing');
    /*
        Swal.fire({
      title: '<strong>HTML <u>example</u></strong>',
      icon: 'info',
      html:
        'You can use <b>bold text</b>, ' +
        '<a href="//sweetalert2.github.io">links</a> ' +
        'and other HTML tags',
      showCloseButton: true,
      showCancelButton: true,
      focusConfirm: false,
      confirmButtonText:
        '<i class="fa fa-thumbs-up"></i> Great!',
      confirmButtonAriaLabel: 'Thumbs up, great!',
      cancelButtonText:
        '<i class="fa fa-thumbs-down"></i>',
      cancelButtonAriaLabel: 'Thumbs down'
    })
    */
}

function armar_graficos_stresslevelread() {
    ///////////////////////
    $.ajax({
        url: 'ajax_graph_stresslevelread.php?idruninfo=' + params.get('idr'),
        data: "idruninfo=" + params.get('idr'),
        type: 'post',
        async: true,
        cache: false,
        success: function(data) {
            //   console.log(' STRESS Level READ');
            //marco

            ///console.log(JSON.parse( data.label_tx ));
            //////////////////////////////////////////////////////////////////////////////////////
            var grafico700strelevelread00 = $('#grafico700strimdlbl00').get(0).getContext('2d');

            var grafico700strelevelread01 = $('#grafico700strimdlbl01').get(0).getContext('2d');

            var grafico800strelevelread10 = $('#grafico800strimdlbl10').get(0).getContext('2d');

            var grafico800strelevelread11 = $('#grafico800strimdlbl11').get(0).getContext('2d');

            var grafico700nf00 = $('#grafico700nf00').get(0).getContext('2d');
            var grafico800nf00 = $('#grafico800nf00').get(0).getContext('2d');

            var grafico700nf01 = $('#grafico700nf01').get(0).getContext('2d');
            var grafico800nf01 = $('#grafico800nf01').get(0).getContext('2d');

            if (data.iduniqueop_band_0_uldl_0_lblread != null && data.iduniqueop_band_0_uldl_0_lblread !=
                '') {
                iduniqueop_band_0_uldl_0_lblread = data.iduniqueop_band_0_uldl_0_lblread.split(",");
                label_tx_lblread_0_0 = label_700_compartir; // data.label_lblread_calib_0_0.split(",");  
                ref_titulo_0_0 = data.freq_ref_0_0;
                // data.label_lblread_calib_0_0.split(",");  
                //////////////level read 0_0 //////////////////////////////////
                //      console.log( iduniqueop_band_0_uldl_0_lblread ); 
                //      console.log('aca'+ label_tx_lblread_0_0 ); 


                var optionlevelread_700_00 = {
                    maintainAspectRatio: false,
                    responsive: true,
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Stress Level Read @ ' + ref_titulo_0_0 + ' dBm'
                    },
                    scales: {
                        xAxes: [{
                            gridLines: {
                                display: true,
                            }


                        }],
                        yAxes: [{
                            gridLines: {
                                display: true,

                            },
                            ticks: {


                                suggestedMin: (Math.min.apply(Math,
                                    iduniqueop_band_0_uldl_0_lblread) - Math.abs(Math
                                    .min.apply(Math, iduniqueop_band_0_uldl_0_lblread) *
                                    0.1)),
                                suggestedMax: (Math.max.apply(Math,
                                    iduniqueop_band_0_uldl_0_lblread) + Math.abs(Math
                                    .max.apply(Math, iduniqueop_band_0_uldl_0_lblread) *
                                    0.1))


                            }


                        }]
                    }
                };

                var stresslablenuevolabel_0_0 = 0;
                for (let i = 0; i < iduniqueop_band_0_uldl_0_lblread.length; i++) {
                    stresslablenuevolabel_0_0 = stresslablenuevolabel_0_0 + i + ',';
                }

                stresslablenuevolabel_0_0_s = stresslablenuevolabel_0_0.split(',');

                var datos_grafico700stresslevelread00 = {
                    labels: stresslablenuevolabel_0_0_s,
                    datasets: [

                        {
                            label: 'Equalized',
                            backgroundColor: 'rgba(60,141,188,0.3)',
                            borderColor: 'rgba(60,141,188,1)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: iduniqueop_band_0_uldl_0_lblread
                        },
                    ]
                };
                //////////////MAX PRW 0_0 //////////////////////////////////

                var rpt_grafico700strelevelread00 = new Chart(grafico700strelevelread00, {
                    type: 'line',
                    data: datos_grafico700stresslevelread00,
                    options: optionlevelread_700_00
                });


            }

            ////////////////////////////////////// 0_1
            if (data.iduniqueop_band_0_uldl_1_lblread != null && data.iduniqueop_band_0_uldl_1_lblread !=
                '') {
                iduniqueop_band_0_uldl_1_lblread = data.iduniqueop_band_0_uldl_1_lblread.split(",");
                label_tx_lblread_0_1 = label_700_compartir; // data.label_lblread_calib_0_0.split(",");  
                ref_titulo_0_1 = data.freq_ref_0_1;
                // data.label_lblread_calib_0_0.split(",");  
                //////////////MAX PRW 0_0 //////////////////////////////////



                var optionlevelread_700_01 = {
                    maintainAspectRatio: false,
                    responsive: true,
                    legend: {
                        display: false
                    },

                    title: {
                        display: true,
                        text: 'Stress Level Read @ ' + ref_titulo_0_1 + ' dBm'
                    },
                    scales: {
                        xAxes: [{
                            gridLines: {
                                display: true,
                            }


                        }],
                        yAxes: [{
                            gridLines: {
                                display: true,

                            },
                            ticks: {

                                suggestedMin: (Math.min.apply(Math,
                                    iduniqueop_band_0_uldl_1_lblread) - Math.abs(Math
                                    .min.apply(Math, iduniqueop_band_0_uldl_1_lblread) *
                                    0.1)),
                                suggestedMax: (Math.max.apply(Math,
                                    iduniqueop_band_0_uldl_1_lblread) + Math.abs(Math
                                    .max.apply(Math, iduniqueop_band_0_uldl_1_lblread) *
                                    0.1))

                            }


                        }]
                    }
                };

                var stresslablenuevolabel_0_1 = 0;
                for (let i = 0; i < iduniqueop_band_0_uldl_1_lblread.length; i++) {
                    stresslablenuevolabel_0_1 = stresslablenuevolabel_0_1 + i + ',';
                }

                stresslablenuevolabel_0_1_s = stresslablenuevolabel_0_1.split(',');

                var datos_grafico700levelread01 = {
                    labels: stresslablenuevolabel_0_1_s,
                    datasets: [

                        {
                            label: 'Equalized',
                            backgroundColor: 'rgba(60,141,188,0.3)',
                            borderColor: 'rgba(60,141,188,1)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: iduniqueop_band_0_uldl_1_lblread
                        },
                    ]
                };
                //////////////LEvel READ 0_1 //////////////////////////////////

                var rpt_grafico700strelevelread01 = new Chart(grafico700strelevelread01, {
                    type: 'line',
                    data: datos_grafico700levelread01,
                    options: optionlevelread_700_01
                });


            }
            ///////////////////////////////////////

            ////////////////////////////////////// 1_0
            if (data.iduniqueop_band_1_uldl_0_lblread != null && data.iduniqueop_band_1_uldl_0_lblread !=
                '') {
                iduniqueop_band_1_uldl_0_lblread = data.iduniqueop_band_1_uldl_0_lblread.split(",");
                label_tx_lblread_1_0 = label_800_compartir; // data.label_lblread_calib_0_0.split(",");  
                ref_titulo_1_0 = data.freq_ref_1_0;

                // data.label_lblread_calib_0_0.split(",");  
                ///////////// //////////////////////////////////


                var optionlevelread_800_10 = {
                    maintainAspectRatio: false,
                    responsive: true,
                    legend: {
                        display: false
                    },

                    title: {
                        display: true,
                        text: 'Stress Level Read @ ' + ref_titulo_1_0 + ' dBm'
                    },
                    scales: {
                        xAxes: [{
                            gridLines: {
                                display: true,
                            }


                        }],
                        yAxes: [{
                            gridLines: {
                                display: true,

                            },
                            ticks: {

                                suggestedMin: (Math.min.apply(Math,
                                    iduniqueop_band_1_uldl_0_lblread) - Math.abs(Math
                                    .min.apply(Math, iduniqueop_band_1_uldl_0_lblread) *
                                    0.1)),
                                suggestedMax: (Math.max.apply(Math,
                                    iduniqueop_band_1_uldl_0_lblread) + Math.abs(Math
                                    .max.apply(Math, iduniqueop_band_1_uldl_0_lblread) *
                                    0.1))

                            }


                        }]
                    }
                };


                var stresslablenuevolabel_1_0 = 0;
                for (let i = 0; i < iduniqueop_band_1_uldl_0_lblread.length; i++) {
                    stresslablenuevolabel_1_0 = stresslablenuevolabel_1_0 + i + ',';
                }

                stresslablenuevolabel_1_0_s = stresslablenuevolabel_1_0.split(',');
                var datos_grafico800levelread10 = {
                    labels: stresslablenuevolabel_1_0_s,
                    datasets: [

                        {
                            label: 'Equalized',
                            backgroundColor: 'rgba(60,141,188,0.3)',
                            borderColor: 'rgba(60,141,188,1)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: iduniqueop_band_1_uldl_0_lblread
                        },
                    ]
                };
                //////////////LEvel READ 0_1 //////////////////////////////////

                var rpt_grafico800strelevelread10 = new Chart(grafico800strelevelread10, {
                    type: 'line',
                    data: datos_grafico800levelread10,
                    options: optionlevelread_800_10
                });


            }
            /////////////////////////////////////// 1 _0
            ////////////////////////////////////// 1_1
            if (data.iduniqueop_band_1_uldl_1_lblread != null && data.iduniqueop_band_1_uldl_1_lblread !=
                '') {
                iduniqueop_band_1_uldl_1_lblread = data.iduniqueop_band_1_uldl_1_lblread.split(",");
                label_tx_lblread_1_1 = label_800_compartir; // data.label_lblread_calib_0_0.split(",");  
                ref_titulo_1_1 = data.freq_ref_1_1;

                // data.label_lblread_calib_0_0.split(",");  


                var optionlevelread_800_11 = {
                    maintainAspectRatio: false,
                    responsive: true,
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Stress Level Read @ ' + ref_titulo_1_1 + ' dBm'
                    },
                    scales: {
                        xAxes: [{
                            gridLines: {
                                display: true,
                            }


                        }],
                        yAxes: [{
                            gridLines: {
                                display: true,

                            },
                            ticks: {

                                suggestedMin: (Math.min.apply(Math,
                                    iduniqueop_band_1_uldl_1_lblread) - Math.abs(Math
                                    .min.apply(Math, iduniqueop_band_1_uldl_1_lblread) *
                                    0.1)),
                                suggestedMax: (Math.max.apply(Math,
                                    iduniqueop_band_1_uldl_1_lblread) + Math.abs(Math
                                    .max.apply(Math, iduniqueop_band_1_uldl_1_lblread) *
                                    0.1))

                            }


                        }]
                    }
                };

                var stresslablenuevolabel_1_1 = 0;
                for (let i = 0; i < iduniqueop_band_1_uldl_1_lblread.length; i++) {
                    stresslablenuevolabel_1_1 = stresslablenuevolabel_1_1 + i + ',';
                }

                stresslablenuevolabel_1_1_s = stresslablenuevolabel_1_1.split(',');
                var datos_grafico800levelread11 = {
                    labels: stresslablenuevolabel_1_1_s,
                    datasets: [

                        {
                            label: 'Equalized',
                            backgroundColor: 'rgba(60,141,188,0.3)',
                            borderColor: 'rgba(60,141,188,1)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: iduniqueop_band_1_uldl_1_lblread
                        },
                    ]
                };
                //////////////LEvel READ 0_1 //////////////////////////////////

                var rpt_grafico800strelevelread11 = new Chart(grafico800strelevelread11, {
                    type: 'line',
                    data: datos_grafico800levelread11,
                    options: optionlevelread_800_11
                });


                var optionNF_700_00 = {
                    maintainAspectRatio: false,
                    responsive: true,
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Noise Figure 700 UPLINK '
                    },
                    scales: {
                        xAxes: [{
                            gridLines: {
                                display: true,
                            }


                        }],
                        yAxes: [{
                            gridLines: {
                                display: true,

                            },
                            ticks: {

                                suggestedMin: 0,
                                suggestedMax: 5

                            }


                        }]
                    }
                };

                var optionNF_700_01 = {
                    maintainAspectRatio: false,
                    responsive: true,
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Noise Figure 700 DOWNLINK '
                    },
                    scales: {
                        xAxes: [{
                            gridLines: {
                                display: true,
                            }


                        }],
                        yAxes: [{
                            gridLines: {
                                display: true,

                            },
                            ticks: {

                                suggestedMin: 0,
                                suggestedMax: 5

                            }


                        }]
                    }
                };

                var optionNF_800_00 = {
                    maintainAspectRatio: false,
                    responsive: true,
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Noise Figure 800 UPLINK '
                    },
                    scales: {
                        xAxes: [{
                            gridLines: {
                                display: true,
                            }


                        }],
                        yAxes: [{
                            gridLines: {
                                display: true,

                            },
                            ticks: {

                                suggestedMin: 5,
                                suggestedMax: 10
                            }


                        }]
                    }
                };

                var optionNF_800_01 = {
                    maintainAspectRatio: false,
                    responsive: true,
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Noise Figure 800 DOWNLINK '
                    },
                    scales: {
                        xAxes: [{
                            gridLines: {
                                display: true,
                            }


                        }],
                        yAxes: [{
                            gridLines: {
                                display: true,

                            },
                            ticks: {

                                suggestedMin: 5,
                                suggestedMax: 10
                            }


                        }]
                    }
                };

                var datos_grafico700nf00 = {
                    labels: label_700_compartir,
                    datasets: [

                        {
                            label: 'Equalized',
                            backgroundColor: 'rgba(60,141,188,0.3)',
                            borderColor: 'rgba(60,141,188,1)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: iduniqueop_band_1_uldl_700nf
                        },
                    ]
                };

                var datos_grafico700nf01 = {
                    labels: label_700_compartir,
                    datasets: [

                        {
                            label: 'Equalized',
                            backgroundColor: 'rgba(60,141,188,0.3)',
                            borderColor: 'rgba(60,141,188,1)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: iduniqueop_band_1_uldl_700nf_down
                        },
                    ]
                };

                var datos_grafico800nf00 = {
                    labels: label_800_compartir,
                    datasets: [

                        {
                            label: 'Equalized',
                            backgroundColor: 'rgba(60,141,188,0.3)',
                            borderColor: 'rgba(60,141,188,1)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: iduniqueop_band_1_uldl_800nf
                        },
                    ]
                };

                var datos_grafico800nf01 = {
                    labels: label_800_compartir,
                    datasets: [

                        {
                            label: 'Equalized',
                            backgroundColor: 'rgba(60,141,188,0.3)',
                            borderColor: 'rgba(60,141,188,1)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: iduniqueop_band_1_uldl_800nf_down
                        },
                    ]
                };



                //// NOISE FIFURE 700
                var rpt_grafico700nf00 = new Chart(grafico700nf00, {
                    type: 'line',
                    data: datos_grafico700nf00,
                    options: optionNF_700_00
                });

                //// NOISE FIFURE 700
                var rpt_grafico800nf00 = new Chart(grafico800nf00, {
                    type: 'line',
                    data: datos_grafico800nf00,
                    options: optionNF_800_00
                });

                //// NOISE FIFURE 700
                var rpt_grafico700nf01 = new Chart(grafico700nf01, {
                    type: 'line',
                    data: datos_grafico700nf01,
                    options: optionNF_700_01
                });

                //// NOISE FIFURE 700
                var rpt_grafico800nf01 = new Chart(grafico800nf01, {
                    type: 'line',
                    data: datos_grafico800nf01,
                    options: optionNF_800_01
                });



            }
            /////////////////////////////////////// 1 _1


            //////////////////////////////////////////////////////////////////////////////////////
        }
    });
}

function armar_graficos_imdstress() {

    ///////////////////////
    $.ajax({
        url: 'ajax_graph_imgstress.php?idruninfo=' + params.get('idr'),
        data: "idruninfo=" + params.get('idr'),
        type: 'post',
        async: true,
        cache: false,
        success: function(data) {
            ///    console.log('IMD STRESS');


            ///console.log(JSON.parse( data.label_tx ));
            //var keyssmm = Object.keys(datax);
            ///console.log(keyssmm);
            var grafico700strimd00 = $('#grafico700strimd00').get(0).getContext('2d');

            var grafico700strimd01 = $('#grafico700strimd01').get(0).getContext('2d');

            var grafico800strimd10 = $('#grafico800strimd10').get(0).getContext('2d');

            var grafico800strimd11 = $('#grafico800strimd11').get(0).getContext('2d');

            if (data.label_imdstress_calib_0_0 != null && data.label_imdstress_calib_0_0 != '') {
                label_imdstress_calib_0_0 = data.label_imdstress_calib_0_0.split(",");
                label_imdstress_calib_0_1 = data.label_imdstress_calib_0_1.split(",");
                label_imdstress_calib_1_0 = data.label_imdstress_calib_1_0.split(",");
                label_imdstress_calib_1_1 = data.label_imdstress_calib_1_1.split(",");

                iduniqueop_band_0_uldl_0_imdstress_0 = data.iduniqueop_band_0_uldl_0_imdstress_0.split(",");
                iduniqueop_band_0_uldl_0_imdstress_1 = data.iduniqueop_band_0_uldl_0_imdstress_1.split(",");
                iduniqueop_band_0_uldl_0_imdstress_2 = data.iduniqueop_band_0_uldl_0_imdstress_2.split(",");
                iduniqueop_band_0_uldl_0_imdstress_3 = data.iduniqueop_band_0_uldl_0_imdstress_3.split(",");

                ref_IMDstree_duration_0_0 = data.dura_0_0;
                // data.label_lblread_calib_0_0.split(",");  
                //////////////level read 0_0 //////////////////////////////////
                // console.log('label_imdstress_calib_0_0:'+ label_imdstress_calib_0_0 ); 



                var optionimdstress_700_00 = {
                    maintainAspectRatio: false,
                    responsive: true,
                    legend: {
                        display: true
                    },
                    title: {
                        display: true,
                        text: 'Stress IMD :: Duration: ' + ref_IMDstree_duration_0_0 + ' '
                    },

                    scales: {
                        xAxes: [{
                            gridLines: {
                                display: true,
                            }


                        }],
                        yAxes: [{
                            gridLines: {
                                display: true,

                            }


                        }]
                    }
                }


                var nuevolabel_0_0 = 0;
                for (let i = 0; i < iduniqueop_band_0_uldl_0_imdstress_0.length; i++) {
                    nuevolabel_0_0 = nuevolabel_0_0 + i + ',';
                }

                nuevolabel_0_0_s = nuevolabel_0_0.split(',');


                ////////////////////////////////////////////////////////////////////////////////////////////////////////////
                console.log('aca largamos con el OIP3');

                let sum = 0;
                for (let i = 0; i < iduniqueop_band_0_uldl_0_imdstress_0.length; i++) {
                    sum += Number(iduniqueop_band_0_uldl_0_imdstress_0[i]);
                    // console.log(iduniqueop_band_0_uldl_0_imdstress_0[i]);
                }
                let imd3_a = sum / Number(iduniqueop_band_0_uldl_0_imdstress_0.length);
                console.log(sum + 'avg:' + imd3_a);

                sum = 0;
                for (let i = 0; i < iduniqueop_band_0_uldl_0_imdstress_1.length; i++) {
                    sum += Number(iduniqueop_band_0_uldl_0_imdstress_1[i]);
                    //  console.log(iduniqueop_band_0_uldl_0_imdstress_1[i]);
                }
                let imd3_b = sum / Number(iduniqueop_band_0_uldl_0_imdstress_1.length);
                console.log(sum + 'avg:' + imd3_b);

                sum = 0;
                for (let i = 0; i < iduniqueop_band_0_uldl_0_imdstress_2.length; i++) {
                    sum += Number(iduniqueop_band_0_uldl_0_imdstress_2[i]);
                    //  console.log(iduniqueop_band_0_uldl_0_imdstress_1[i]);
                }
                let imd3_c = sum / Number(iduniqueop_band_0_uldl_0_imdstress_2.length);
                console.log(sum + 'avg:' + imd3_c);

                sum = 0;
                for (let i = 0; i < iduniqueop_band_0_uldl_0_imdstress_3.length; i++) {
                    sum += Number(iduniqueop_band_0_uldl_0_imdstress_3[i]);
                    //  console.log(iduniqueop_band_0_uldl_0_imdstress_1[i]);
                }
                let imd3_d = sum / Number(iduniqueop_band_0_uldl_0_imdstress_3.length);
                console.log(sum + 'avg:' + imd3_d);

                ///mostramos tabla IMD OIP3
                let calculo_a = Number(Number(imd3_a + imd3_d) / 2);
                let calculo_b = Number(Number(imd3_b + imd3_c) / 2);
                let calculo_c = Number(calculo_b) + ((Number(calculo_b) - Number(calculo_a)) / 2);
                console.log('calculo_a' + calculo_a + '-calculo_b' + calculo_b + 'calculo_c' + calculo_c);

                let tablaimd3 =
                    '   <table class="table table-sm table-bordered"> <thead class="thead-dark"><tr><th scope="row" colspan="3" style="text-align:center"> IMD</th></tr></thead>';
                tablaimd3 = tablaimd3 +
                    '<tbody><tr class="table-info" style="text-align:center"><th>2-channels Output Pwr</th><th>IMD 3rd Order</th> <th>OIP3</th></tr><tr>';
                tablaimd3 = tablaimd3 +
                    '<td  style="text-align:center">' + calculo_b.toFixed(2) +
                    ' dBm </td><td  style="text-align:center">' + calculo_a
                    .toFixed(2) + ' dBm</td><td  style="text-align:center">' + calculo_c.toFixed(2) +
                    ' dBm </td></tr> </tbody> </table>';


                //    divgrafico700oip3mm00
                document.getElementById("divgrafico700oip3mm00").innerHTML = tablaimd3;
                ////////   700 UP FIN


                var datos_grafico700imdstress00 = {
                    labels: nuevolabel_0_0_s,
                    datasets: [{
                            label: label_imdstress_calib_0_0[0] + ' MHz',
                            backgroundColor: 'rgba(60,141,188,0.1)',
                            borderColor: 'rgba(60,141,188,1)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: iduniqueop_band_0_uldl_0_imdstress_0
                        },
                        {
                            label: label_imdstress_calib_0_0[1] + ' MHz',
                            backgroundColor: 'rgba(255, 99, 132, 0.1)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            pointRadius: false,
                            pointColor: 'rgba(255, 99, 132, 1)',
                            pointStrokeColor: '#c1c7d1',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(255, 99, 132, 1)',
                            data: iduniqueop_band_0_uldl_0_imdstress_1
                        },

                        {
                            label: label_imdstress_calib_0_0[2] + ' MHz',
                            backgroundColor: 'rgba(160,141,188,0.1)',
                            borderColor: 'rgba(160,141,188,1)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: iduniqueop_band_0_uldl_0_imdstress_2
                        },
                        {
                            label: label_imdstress_calib_0_0[3] + ' MHz',
                            backgroundColor: 'rgba(200, 99, 132, 0.1)',
                            borderColor: 'rgba(200, 99, 132, 1)',
                            pointRadius: false,
                            pointColor: 'rgba(255, 99, 132, 1)',
                            pointStrokeColor: '#c1c7d1',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(255, 99, 132, 1)',
                            data: iduniqueop_band_0_uldl_0_imdstress_3
                        },
                    ]
                };

                //////////////MAX PRW 0_0 //////////////////////////////////

                var rpt_grafico700imdstress00 = new Chart(grafico700strimd00, {
                    type: 'line',
                    data: datos_grafico700imdstress00,
                    options: optionimdstress_700_00
                });


            }
            /////////////////////////////////////////////////////////////////////////////
            if (data.label_imdstress_calib_0_1 != null && data.label_imdstress_calib_0_1 != '') {
                label_imdstress_calib_0_1 = data.label_imdstress_calib_0_1.split(",");


                iduniqueop_band_0_uldl_1_imdstress_0 = data.iduniqueop_band_0_uldl_1_imdstress_0.split(",");
                iduniqueop_band_0_uldl_1_imdstress_1 = data.iduniqueop_band_0_uldl_1_imdstress_1.split(",");
                iduniqueop_band_0_uldl_1_imdstress_2 = data.iduniqueop_band_0_uldl_1_imdstress_2.split(",");
                ref_IMDstree_duration_0_1 = data.dura_0_1;
                //   console.log('el3'+ data.iduniqueop_band_0_uldl_1_imdstress_3);  

                ///   iduniqueop_band_0_uldl_1_imdstress_3 = data.iduniqueop_band_0_uldl_1_imdstress_3.split(",");  
                if (data.iduniqueop_band_0_uldl_1_imdstress_3 == null) {
                    iduniqueop_band_0_uldl_1_imdstress_3 = '';
                } else {

                    iduniqueop_band_0_uldl_1_imdstress_3 = data.iduniqueop_band_0_uldl_1_imdstress_3.split(
                        ",");

                }



                // data.label_lblread_calib_0_0.split(",");  
                //////////////level read 0_0 //////////////////////////////////
                ///  console.log('label_imdstress_calib_0_1:'+ label_imdstress_calib_0_1 ); 

                ////////   700 DOWN inicio 
                ////////////////////////////////////////////////////////////////////////////////////////////////////////////


                let sum1 = 0;
                for (let i = 0; i < iduniqueop_band_0_uldl_1_imdstress_0.length; i++) {
                    sum1 += Number(iduniqueop_band_0_uldl_1_imdstress_0[i]);
                    // console.log(iduniqueop_band_0_uldl_0_imdstress_0[i]);
                }
                let imd3_a1 = sum1 / Number(iduniqueop_band_0_uldl_1_imdstress_0.length);
                console.log(sum1 + 'avg:' + imd3_a1);

                sum1 = 0;
                for (let i = 0; i < iduniqueop_band_0_uldl_1_imdstress_1.length; i++) {
                    sum1 += Number(iduniqueop_band_0_uldl_1_imdstress_1[i]);
                    //  console.log(iduniqueop_band_0_uldl_0_imdstress_1[i]);
                }
                let imd3_b1 = sum1 / Number(iduniqueop_band_0_uldl_1_imdstress_1.length);
                console.log(sum1 + 'avg:' + imd3_b1);

                sum1 = 0;
                for (let i = 0; i < iduniqueop_band_0_uldl_1_imdstress_2.length; i++) {
                    sum1 += Number(iduniqueop_band_0_uldl_1_imdstress_2[i]);
                    //  console.log(iduniqueop_band_0_uldl_1_imdstress_2[i]);
                }
                let imd3_c1 = sum1 / Number(iduniqueop_band_0_uldl_1_imdstress_2.length);
                console.log(sum1 + 'avg:' + imd3_c1);

                sum1 = 0;
                for (let i = 0; i < iduniqueop_band_0_uldl_1_imdstress_3.length; i++) {
                    sum1 += Number(iduniqueop_band_0_uldl_1_imdstress_3[i]);
                    //  console.log(iduniqueop_band_0_uldl_1_imdstress_3[i]);
                }
                let imd3_d1 = sum1 / Number(iduniqueop_band_0_uldl_1_imdstress_3.length);
                console.log(sum1 + 'avg:' + imd3_d1);

                ///mostramos tabla IMD OIP3
                let calculo_a1 = Number(Number(imd3_a1 + imd3_d1) / 2);
                let calculo_b1 = Number(Number(imd3_b1 + imd3_c1) / 2);
                let calculo_c1 = Number(calculo_b1) + ((Number(calculo_b1) - Number(calculo_a1)) / 2);
                console.log('calculo_a' + calculo_a1 + '-calculo_b' + calculo_b1 + 'calculo_c' +
                    calculo_c1);
                tablaimd3 = '';
                tablaimd3 =
                    '   <table class="table table-sm table-bordered"> <thead class="thead-dark"><tr><th scope="row" colspan="3" style="text-align:center"> IMD</th></tr></thead>';
                tablaimd3 = tablaimd3 +
                    '<tbody><tr class="table-info" style="text-align:center"><th>2-channels Output Pwr</th><th>IMD 3rd Order</th> <th>OIP3</th></tr><tr>';
                tablaimd3 = tablaimd3 +
                    '<td  style="text-align:center">' + calculo_b1.toFixed(2) +
                    ' dBm </td><td  style="text-align:center">' +
                    calculo_a1
                    .toFixed(2) + ' dBm</td><td  style="text-align:center">' + calculo_c1.toFixed(2) +
                    ' dBm </td></tr> </tbody> </table>';


                //    divgrafico700oip3mm01
                document.getElementById("divgrafico700oip3mm01").innerHTML = tablaimd3;
                ////////   700 UP FIN
                /////////////////////////////////////////////////////////////////////

                var optionimdstress_700_01 = {
                    maintainAspectRatio: false,
                    responsive: true,
                    legend: {
                        display: true
                    },
                    title: {
                        display: true,
                        text: 'Stress IMD :: Duration: ' + ref_IMDstree_duration_0_1 + ' '
                    },
                    scales: {
                        xAxes: [{
                            gridLines: {
                                display: true,
                            }


                        }],
                        yAxes: [{
                            gridLines: {
                                display: true,

                            }


                        }]
                    }
                }

                var nuevolabel_0_1 = 0;
                for (let i = 0; i < iduniqueop_band_0_uldl_1_imdstress_0.length; i++) {
                    nuevolabel_0_1 = nuevolabel_0_1 + i + ',';
                }

                nuevolabel_0_1_s = nuevolabel_0_1.split(',');

                var datos_grafico700imdstress01 = {
                    labels: nuevolabel_0_1_s,
                    datasets: [{
                            label: label_imdstress_calib_0_1[0] + ' MHz',
                            backgroundColor: 'rgba(60,141,188,0.1)',
                            borderColor: 'rgba(60,141,188,1)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: iduniqueop_band_0_uldl_1_imdstress_0
                        },
                        {
                            label: label_imdstress_calib_0_1[1] + ' MHz',
                            backgroundColor: 'rgba(255, 99, 132, 0.1)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            pointRadius: false,
                            pointColor: 'rgba(255, 99, 132, 1)',
                            pointStrokeColor: '#c1c7d1',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(255, 99, 132, 1)',
                            data: iduniqueop_band_0_uldl_1_imdstress_1
                        },

                        {
                            label: label_imdstress_calib_0_1[2] + ' MHz',
                            backgroundColor: 'rgba(160,141,188,0.1)',
                            borderColor: 'rgba(160,141,188,1)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: iduniqueop_band_0_uldl_1_imdstress_2
                        },
                        {
                            label: label_imdstress_calib_0_1[3] + ' MHz',
                            backgroundColor: 'rgba(200, 99, 132, 0.1)',
                            borderColor: 'rgba(200, 99, 132, 1)',
                            pointRadius: false,
                            pointColor: 'rgba(255, 99, 132, 1)',
                            pointStrokeColor: '#c1c7d1',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(255, 99, 132, 1)',
                            data: iduniqueop_band_0_uldl_1_imdstress_3
                        },
                    ]
                };

                ////////////// //////////////////////////////////

                var rpt_grafico700imdstress01 = new Chart(grafico700strimd01, {
                    type: 'line',
                    data: datos_grafico700imdstress01,
                    options: optionimdstress_700_01
                });


            }
            ///////////////////////////////////////////////////////////////////////// 
            if (data.label_imdstress_calib_1_0 != null && data.label_imdstress_calib_1_0 != '') {
                label_imdstress_calib_1_0 = data.label_imdstress_calib_1_0.split(",");


                iduniqueop_band_1_uldl_0_imdstress_0 = data.iduniqueop_band_1_uldl_0_imdstress_0.split(",");
                iduniqueop_band_1_uldl_0_imdstress_1 = data.iduniqueop_band_1_uldl_0_imdstress_1.split(",");
                iduniqueop_band_1_uldl_0_imdstress_2 = data.iduniqueop_band_1_uldl_0_imdstress_2.split(",");
                ref_IMDstree_duration_1_0 = data.dura_1_0;

                if (data.iduniqueop_band_1_uldl_0_imdstress_3 == '') {
                    iduniqueop_band_1_uldl_0_imdstress_3 = '';
                } else {

                    iduniqueop_band_1_uldl_0_imdstress_3 = data.iduniqueop_band_1_uldl_0_imdstress_3.split(
                        ",");

                }
                // data.label_lblread_calib_0_0.split(",");  
                //////////////level read 0_0 //////////////////////////////////
                //   console.log('label_imdstress_calib_0_1:'+ label_imdstress_calib_1_0 ); 



                var optionimdstress_700_10 = {
                    maintainAspectRatio: false,
                    responsive: true,
                    legend: {
                        display: true
                    },
                    title: {
                        display: true,
                        text: 'Stress IMD :: Duration: ' + ref_IMDstree_duration_1_0 + ' '
                    },
                    scales: {
                        xAxes: [{
                            gridLines: {
                                display: true,
                            }


                        }],
                        yAxes: [{
                            gridLines: {
                                display: true,

                            }


                        }]
                    }
                }

                var nuevolabel_1_0 = 0;
                for (let i = 0; i < iduniqueop_band_1_uldl_0_imdstress_0.length; i++) {
                    nuevolabel_1_0 = nuevolabel_1_0 + i + ',';
                }

                nuevolabel_1_0_s = nuevolabel_1_0.split(',');

                var datos_grafico700imdstress10 = {
                    labels: nuevolabel_1_0_s,
                    datasets: [{
                            label: label_imdstress_calib_1_0[0] + ' MHz',
                            backgroundColor: 'rgba(60,141,188,0.1)',
                            borderColor: 'rgba(60,141,188,1)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: iduniqueop_band_1_uldl_0_imdstress_0
                        },
                        {
                            label: label_imdstress_calib_1_0[1] + ' MHz',
                            backgroundColor: 'rgba(255, 99, 132, 0.1)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            pointRadius: false,
                            pointColor: 'rgba(255, 99, 132, 1)',
                            pointStrokeColor: '#c1c7d1',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(255, 99, 132, 1)',
                            data: iduniqueop_band_1_uldl_0_imdstress_1
                        },

                        {
                            label: label_imdstress_calib_1_0[2] + ' MHz',
                            backgroundColor: 'rgba(160,141,188,0.1)',
                            borderColor: 'rgba(160,141,188,1)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: iduniqueop_band_1_uldl_0_imdstress_2
                        },
                        {
                            label: label_imdstress_calib_1_0[3] + ' MHz',
                            backgroundColor: 'rgba(200, 99, 132, 0.1)',
                            borderColor: 'rgba(200, 99, 132, 1)',
                            pointRadius: false,
                            pointColor: 'rgba(255, 99, 132, 1)',
                            pointStrokeColor: '#c1c7d1',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(255, 99, 132, 1)',
                            data: iduniqueop_band_1_uldl_0_imdstress_3
                        },
                    ]
                };

                //////////////  //////////////////////////////////

                var rpt_grafico700imdstress10 = new Chart(grafico800strimd10, {
                    type: 'line',
                    data: datos_grafico700imdstress10,
                    options: optionimdstress_700_10
                });


            }
            ///////////////////////////////////////////////////////////////////////// 
            ///////////////////////////////////////////////////////////////////////// 
            if (data.label_imdstress_calib_1_1 != null && data.label_imdstress_calib_1_1 != '') {
                label_imdstress_calib_1_1 = data.label_imdstress_calib_1_1.split(",");


                iduniqueop_band_1_uldl_1_imdstress_0 = data.iduniqueop_band_1_uldl_1_imdstress_0.split(",");
                iduniqueop_band_1_uldl_1_imdstress_1 = data.iduniqueop_band_1_uldl_1_imdstress_1.split(",");
                iduniqueop_band_1_uldl_1_imdstress_2 = data.iduniqueop_band_1_uldl_1_imdstress_2.split(",");
                ref_IMDstree_duration_1_1 = data.dura_1_1;
                //   iduniqueop_band_1_uldl_1_imdstress_3 = data.iduniqueop_band_1_uldl_1_imdstress_3.split(",");  
                if (data.iduniqueop_band_1_uldl_1_imdstress_3 == null) {
                    iduniqueop_band_1_uldl_1_imdstress_3 = '';
                } else {

                    iduniqueop_band_1_uldl_1_imdstress_3 = data.iduniqueop_band_1_uldl_1_imdstress_3.split(
                        ",");

                }
                // data.label_lblread_calib_0_0.split(",");  
                //////////////level read 0_0 //////////////////////////////////
                //    console.log('label_imdstress_calib_0_1:'+ label_imdstress_calib_1_1 ); 


                ////////   800 UP inicio 
                ////////////////////////////////////////////////////////////////////////////////////////////////////////////


                let sum1 = 0;
                for (let i = 0; i < iduniqueop_band_1_uldl_0_imdstress_0.length; i++) {
                    sum1 += Number(iduniqueop_band_1_uldl_0_imdstress_0[i]);
                    // console.log(iduniqueop_band_0_uldl_0_imdstress_0[i]);
                }
                let imd3_a1 = sum1 / Number(iduniqueop_band_1_uldl_0_imdstress_0.length);
                console.log(sum1 + 'avg:' + imd3_a1);

                sum1 = 0;
                for (let i = 0; i < iduniqueop_band_1_uldl_0_imdstress_1.length; i++) {
                    sum1 += Number(iduniqueop_band_1_uldl_0_imdstress_1[i]);
                    //  console.log(iduniqueop_band_0_uldl_0_imdstress_1[i]);
                }
                let imd3_b1 = sum1 / Number(iduniqueop_band_1_uldl_0_imdstress_1.length);
                console.log(sum1 + 'avg:' + imd3_b1);

                sum1 = 0;
                for (let i = 0; i < iduniqueop_band_1_uldl_0_imdstress_2.length; i++) {
                    sum1 += Number(iduniqueop_band_1_uldl_0_imdstress_2[i]);
                    //  console.log(iduniqueop_band_0_uldl_1_imdstress_2[i]);
                }
                let imd3_c1 = sum1 / Number(iduniqueop_band_1_uldl_0_imdstress_2.length);
                console.log(sum1 + 'avg:' + imd3_c1);

                sum1 = 0;
                for (let i = 0; i < iduniqueop_band_1_uldl_0_imdstress_3.length; i++) {
                    sum1 += Number(iduniqueop_band_1_uldl_0_imdstress_3[i]);
                    //  console.log(iduniqueop_band_0_uldl_1_imdstress_3[i]);
                }
                let imd3_d1 = sum1 / Number(iduniqueop_band_1_uldl_0_imdstress_3.length);
                console.log(sum1 + 'avg:' + imd3_d1);

                ///mostramos tabla IMD OIP3
                let calculo_a1 = Number(Number(imd3_a1 + imd3_d1) / 2);
                let calculo_b1 = Number(Number(imd3_b1 + imd3_c1) / 2);
                let calculo_c1 = Number(calculo_b1) + ((Number(calculo_b1) - Number(calculo_a1)) / 2);
                console.log('calculo_a' + calculo_a1 + '-calculo_b' + calculo_b1 + 'calculo_c' +
                    calculo_c1);
                tablaimd3 = '';
                tablaimd3 =
                    '   <table class="table table-sm table-bordered"> <thead class="thead-dark"><tr><th scope="row" colspan="3" style="text-align:center"> IMD</th></tr></thead>';
                tablaimd3 = tablaimd3 +
                    '<tbody><tr class="table-info" style="text-align:center"><th>2-channels Output Pwr</th><th>IMD 3rd Order</th> <th>OIP3</th></tr><tr>';
                tablaimd3 = tablaimd3 +
                    '<td  style="text-align:center">' + calculo_b1.toFixed(2) +
                    ' dBm </td><td  style="text-align:center">' +
                    calculo_a1
                    .toFixed(2) + ' dBm</td><td  style="text-align:center">' + calculo_c1.toFixed(2) +
                    ' dBm </td></tr> </tbody> </table>';


                //    divgrafico700oip3mm01
                document.getElementById("divgrafico800oip3mm00").innerHTML = tablaimd3;
                ////////   800 UP FIN
                /////////////////////////////////////////////////////////////////////

                var optionimdstress_700_11 = {
                    maintainAspectRatio: false,
                    responsive: true,
                    legend: {
                        display: true
                    },
                    title: {
                        display: true,
                        text: 'Stress IMD :: Duration: ' + ref_IMDstree_duration_1_1 + ' '
                    },
                    scales: {
                        xAxes: [{
                            gridLines: {
                                display: true,
                            }


                        }],
                        yAxes: [{
                            gridLines: {
                                display: true,

                            }


                        }]
                    }
                }
                var nuevolabel_1_1 = 0;
                for (let i = 0; i < iduniqueop_band_1_uldl_1_imdstress_0.length; i++) {
                    nuevolabel_1_1 = nuevolabel_1_1 + i + ',';
                }

                nuevolabel_1_1_s = nuevolabel_1_1.split(',');

                var datos_grafico700imdstress11 = {
                    labels: nuevolabel_1_1_s,
                    datasets: [{
                            label: label_imdstress_calib_1_1[0] + ' MHz',
                            backgroundColor: 'rgba(60,141,188,0.1)',
                            borderColor: 'rgba(60,141,188,1)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: iduniqueop_band_1_uldl_1_imdstress_0
                        },
                        {
                            label: label_imdstress_calib_1_1[1] + ' MHz',
                            backgroundColor: 'rgba(255, 99, 132, 0.1)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            pointRadius: false,
                            pointColor: 'rgba(255, 99, 132, 1)',
                            pointStrokeColor: '#c1c7d1',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(255, 99, 132, 1)',
                            data: iduniqueop_band_1_uldl_1_imdstress_1
                        },

                        {
                            label: label_imdstress_calib_1_1[2] + ' MHz',
                            backgroundColor: 'rgba(160,141,188,0.1)',
                            borderColor: 'rgba(160,141,188,1)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: iduniqueop_band_1_uldl_1_imdstress_2
                        },
                        {
                            label: label_imdstress_calib_1_1[3] + ' MHz',
                            backgroundColor: 'rgba(200, 99, 132, 0.1)',
                            borderColor: 'rgba(200, 99, 132, 1)',
                            pointRadius: false,
                            pointColor: 'rgba(255, 99, 132, 1)',
                            pointStrokeColor: '#c1c7d1',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(255, 99, 132, 1)',
                            data: iduniqueop_band_1_uldl_1_imdstress_3
                        },
                    ]
                };

                //////////////  //////////////////////////////////

                ////////   800 UP inicio 
                ////////////////////////////////////////////////////////////////////////////////////////////////////////////


                let sum2 = 0;
                for (let i = 0; i < iduniqueop_band_1_uldl_1_imdstress_0.length; i++) {
                    sum2 += Number(iduniqueop_band_1_uldl_1_imdstress_0[i]);
                    // console.log(iduniqueop_band_1_uldl_1_imdstress_0[i]);
                }
                let imd3_a2 = sum2 / Number(iduniqueop_band_1_uldl_1_imdstress_0.length);
                console.log(sum2 + 'avg:' + imd3_a1);

                sum2 = 0;
                for (let i = 0; i < iduniqueop_band_1_uldl_1_imdstress_1.length; i++) {
                    sum2 += Number(iduniqueop_band_1_uldl_1_imdstress_1[i]);
                    //  console.log(iduniqueop_band_1_uldl_1_imdstress_1[i]);
                }
                let imd3_b2 = sum2 / Number(iduniqueop_band_1_uldl_1_imdstress_1.length);
                console.log(sum2 + 'avg:' + imd3_b1);

                sum2 = 0;
                for (let i = 0; i < iduniqueop_band_1_uldl_1_imdstress_2.length; i++) {
                    sum2 += Number(iduniqueop_band_1_uldl_1_imdstress_2[i]);
                    //  console.log(iduniqueop_band_1_uldl_1_imdstress_2[i]);
                }
                let imd3_c2 = sum2 / Number(iduniqueop_band_1_uldl_1_imdstress_2.length);
                console.log(sum2 + 'avg:' + imd3_c1);

                sum2 = 0;
                for (let i = 0; i < iduniqueop_band_1_uldl_1_imdstress_3.length; i++) {
                    sum2 += Number(iduniqueop_band_1_uldl_1_imdstress_3[i]);
                    //  console.log(iduniqueop_band_1_uldl_1_imdstress_3[i]);
                }
                let imd3_d2 = sum2 / Number(iduniqueop_band_1_uldl_1_imdstress_3.length);
                console.log(sum2 + 'avg:' + imd3_d1);

                ///mostramos tabla IMD OIP3
                let calculo_a2 = Number(Number(imd3_a2 + imd3_d2) / 2);
                let calculo_b2 = Number(Number(imd3_b2 + imd3_c2) / 2);
                let calculo_c2 = Number(calculo_b2) + ((Number(calculo_b2) - Number(calculo_a2)) / 2);
                console.log('calculo_a' + calculo_a2 + '-calculo_b' + calculo_b2 + 'calculo_c' +
                    calculo_c1);
                tablaimd3 = '';
                tablaimd3 =
                    '   <table class="table table-sm table-bordered"> <thead class="thead-dark"><tr><th scope="row" colspan="3" style="text-align:center"> IMD</th></tr></thead>';
                tablaimd3 = tablaimd3 +
                    '<tbody><tr class="table-info" style="text-align:center"><th>2-channels Output Pwr</th><th>IMD 3rd Order</th> <th>OIP3</th></tr><tr>';
                tablaimd3 = tablaimd3 +
                    '<td  style="text-align:center">' + calculo_b2.toFixed(2) +
                    ' dBm </td><td  style="text-align:center">' +
                    calculo_a2
                    .toFixed(2) + ' dBm</td><td  style="text-align:center">' + calculo_c2.toFixed(2) +
                    ' dBm </td></tr> </tbody> </table>';


                //    divgrafico700oip3mm01
                document.getElementById("divgrafico800oip3mm01").innerHTML = tablaimd3;
                ////////   800 UP FIN
                /////////////////////////////////////////////////////////////////////

                var rpt_grafico700imdstress11 = new Chart(grafico800strimd11, {
                    type: 'line',
                    data: datos_grafico700imdstress11,
                    options: optionimdstress_700_11
                });


            }
            ///////////////////////////////////////////////////////////////////////// 








        }
    });


}

function armar_graficos_levelread() {




    ///////////////////////
    $.ajax({
        url: 'ajax_graph_lelveread.php?idruninfo=' + params.get('idr'),
        data: "idruninfo=" + params.get('idr'),
        type: 'post',
        async: true,
        cache: false,
        success: function(data) {
            //     console.log('Level read');


            ///console.log(JSON.parse( data.label_tx ));
            //var keyssmm = Object.keys(datax);
            ///console.log(keyssmm);
            var grafico700levelread00 = $('#grafico700levelread00').get(0).getContext('2d');

            var grafico700levelread01 = $('#grafico700levelread01').get(0).getContext('2d');

            var grafico800levelread10 = $('#grafico800levelread10').get(0).getContext('2d');

            var grafico800levelread11 = $('#grafico800levelread11').get(0).getContext('2d');

            if (data.iduniqueop_band_0_uldl_0_lblread != null && data.iduniqueop_band_0_uldl_0_lblread !=
                '') {
                iduniqueop_band_0_uldl_0_lblread = data.iduniqueop_band_0_uldl_0_lblread.split(",");
                label_tx_lblread_0_0 = label_700_compartir; // data.label_lblread_calib_0_0.split(",");  
                ref_titulo_0_0 = data.freq_ref_0_0;
                // data.label_lblread_calib_0_0.split(",");  
                //////////////level read 0_0 //////////////////////////////////
                //      console.log( iduniqueop_band_0_uldl_0_lblread ); 
                //      console.log('aca'+ label_tx_lblread_0_0 ); 


                var optionlevelread_700_00 = {
                    maintainAspectRatio: false,
                    responsive: true,
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Level Read @ ' + ref_titulo_0_0 + ' dBm'
                    },
                    scales: {
                        xAxes: [{
                            gridLines: {
                                display: true,
                            }


                        }],
                        yAxes: [{
                            gridLines: {
                                display: true,

                            },
                            ticks: {


                                suggestedMin: (Math.min.apply(Math,
                                    iduniqueop_band_0_uldl_0_lblread) - Math.abs(Math
                                    .min.apply(Math, iduniqueop_band_0_uldl_0_lblread) *
                                    0.1)),
                                suggestedMax: (Math.max.apply(Math,
                                    iduniqueop_band_0_uldl_0_lblread) + Math.abs(Math
                                    .max.apply(Math, iduniqueop_band_0_uldl_0_lblread) *
                                    0.1))


                            }


                        }]
                    }
                };

                var datos_grafico700levelread00 = {
                    labels: label_700_compartir,
                    datasets: [

                        {
                            label: 'Equalized',
                            backgroundColor: 'rgba(60,141,188,0.3)',
                            borderColor: 'rgba(60,141,188,1)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: iduniqueop_band_0_uldl_0_lblread
                        },
                    ]
                };
                //////////////MAX PRW 0_0 //////////////////////////////////

                var rpt_grafico700levelread00 = new Chart(grafico700levelread00, {
                    type: 'line',
                    data: datos_grafico700levelread00,
                    options: optionlevelread_700_00
                });


            }
            ////////////////////////////////////// 0_1
            if (data.iduniqueop_band_0_uldl_1_lblread != null && data.iduniqueop_band_0_uldl_1_lblread !=
                '') {
                iduniqueop_band_0_uldl_1_lblread = data.iduniqueop_band_0_uldl_1_lblread.split(",");
                label_tx_lblread_0_1 = label_700_compartir; // data.label_lblread_calib_0_0.split(",");  
                ref_titulo_0_1 = data.freq_ref_0_1;
                // data.label_lblread_calib_0_0.split(",");  
                //////////////MAX PRW 0_0 //////////////////////////////////



                var optionlevelread_700_01 = {
                    maintainAspectRatio: false,
                    responsive: true,
                    legend: {
                        display: false
                    },

                    title: {
                        display: true,
                        text: 'Level Read @ ' + ref_titulo_0_1 + ' dBm'
                    },
                    scales: {
                        xAxes: [{
                            gridLines: {
                                display: true,
                            }


                        }],
                        yAxes: [{
                            gridLines: {
                                display: true,

                            },
                            ticks: {

                                suggestedMin: (Math.min.apply(Math,
                                    iduniqueop_band_0_uldl_1_lblread) - Math.abs(Math
                                    .min.apply(Math, iduniqueop_band_0_uldl_1_lblread) *
                                    0.1)),
                                suggestedMax: (Math.max.apply(Math,
                                    iduniqueop_band_0_uldl_1_lblread) + Math.abs(Math
                                    .max.apply(Math, iduniqueop_band_0_uldl_1_lblread) *
                                    0.1))

                            }


                        }]
                    }
                };

                var datos_grafico700levelread01 = {
                    labels: label_700_compartir,
                    datasets: [

                        {
                            label: 'Equalized',
                            backgroundColor: 'rgba(60,141,188,0.3)',
                            borderColor: 'rgba(60,141,188,1)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: iduniqueop_band_0_uldl_1_lblread
                        },
                    ]
                };
                //////////////LEvel READ 0_1 //////////////////////////////////

                var rpt_grafico700levelread01 = new Chart(grafico700levelread01, {
                    type: 'line',
                    data: datos_grafico700levelread01,
                    options: optionlevelread_700_01
                });


            }
            ///////////////////////////////////////
            ////////////////////////////////////// 1_0
            if (data.iduniqueop_band_1_uldl_0_lblread != null && data.iduniqueop_band_1_uldl_0_lblread !=
                '') {
                iduniqueop_band_1_uldl_0_lblread = data.iduniqueop_band_1_uldl_0_lblread.split(",");
                label_tx_lblread_1_0 = label_800_compartir; // data.label_lblread_calib_0_0.split(",");  
                ref_titulo_1_0 = data.freq_ref_1_0;

                // data.label_lblread_calib_0_0.split(",");  
                ///////////// //////////////////////////////////


                var optionlevelread_800_10 = {
                    maintainAspectRatio: false,
                    responsive: true,
                    legend: {
                        display: false
                    },

                    title: {
                        display: true,
                        text: 'Level Read @ ' + ref_titulo_1_0 + ' dBm'
                    },
                    scales: {
                        xAxes: [{
                            gridLines: {
                                display: true,
                            }


                        }],
                        yAxes: [{
                            gridLines: {
                                display: true,

                            },
                            ticks: {

                                suggestedMin: (Math.min.apply(Math,
                                    iduniqueop_band_1_uldl_0_lblread) - Math.abs(Math
                                    .min.apply(Math, iduniqueop_band_1_uldl_0_lblread) *
                                    0.1)),
                                suggestedMax: (Math.max.apply(Math,
                                    iduniqueop_band_1_uldl_0_lblread) + Math.abs(Math
                                    .max.apply(Math, iduniqueop_band_1_uldl_0_lblread) *
                                    0.1))

                            }


                        }]
                    }
                };

                var datos_grafico800levelread10 = {
                    labels: label_800_compartir,
                    datasets: [

                        {
                            label: 'Equalized',
                            backgroundColor: 'rgba(60,141,188,0.3)',
                            borderColor: 'rgba(60,141,188,1)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: iduniqueop_band_1_uldl_0_lblread
                        },
                    ]
                };
                //////////////LEvel READ 0_1 //////////////////////////////////

                var rpt_grafico800levelread10 = new Chart(grafico800levelread10, {
                    type: 'line',
                    data: datos_grafico800levelread10,
                    options: optionlevelread_800_10
                });


            }


            /////////////////////////////////////// 1 _0
            //// NF
            if (data.iduniqueop_band_1_uldl_700nf00 != null) {
                iduniqueop_band_1_uldl_700nf = data.iduniqueop_band_1_uldl_700nf00.split(",");
            }
            if (data.iduniqueop_band_1_uldl_800nf10 != null) {
                iduniqueop_band_1_uldl_800nf = data.iduniqueop_band_1_uldl_800nf10.split(",");
            }

            if (data.iduniqueop_band_1_uldl_700nf01 != null) {
                iduniqueop_band_1_uldl_700nf_down = data.iduniqueop_band_1_uldl_700nf01.split(",");
            }
            if (data.iduniqueop_band_1_uldl_800nf11 != null) {
                iduniqueop_band_1_uldl_800nf_down = data.iduniqueop_band_1_uldl_800nf11.split(",");
            }


            //// fin FN
            ////////////////////////////////////// 1_1
            if (data.iduniqueop_band_1_uldl_1_lblread != null && data.iduniqueop_band_1_uldl_1_lblread !=
                '') {
                iduniqueop_band_1_uldl_1_lblread = data.iduniqueop_band_1_uldl_1_lblread.split(",");
                label_tx_lblread_1_1 = label_800_compartir; // data.label_lblread_calib_0_0.split(",");  
                ref_titulo_1_1 = data.freq_ref_1_1;

                // data.label_lblread_calib_0_0.split(",");  


                var optionlevelread_800_11 = {
                    maintainAspectRatio: false,
                    responsive: true,
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Level Read @ ' + ref_titulo_1_1 + ' dBm'
                    },
                    scales: {
                        xAxes: [{
                            gridLines: {
                                display: true,
                            }


                        }],
                        yAxes: [{
                            gridLines: {
                                display: true,

                            },
                            ticks: {

                                suggestedMin: (Math.min.apply(Math,
                                    iduniqueop_band_1_uldl_1_lblread) - Math.abs(Math
                                    .min.apply(Math, iduniqueop_band_1_uldl_1_lblread) *
                                    0.1)),
                                suggestedMax: (Math.max.apply(Math,
                                    iduniqueop_band_1_uldl_1_lblread) + Math.abs(Math
                                    .max.apply(Math, iduniqueop_band_1_uldl_1_lblread) *
                                    0.1))

                            }


                        }]
                    }
                };



                var datos_grafico800levelread11 = {
                    labels: label_800_compartir,
                    datasets: [

                        {
                            label: 'Equalized',
                            backgroundColor: 'rgba(60,141,188,0.3)',
                            borderColor: 'rgba(60,141,188,1)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: iduniqueop_band_1_uldl_1_lblread
                        },
                    ]
                };






                //////////////LEvel READ 0_1 //////////////////////////////////

                var rpt_grafico800levelread11 = new Chart(grafico800levelread11, {
                    type: 'line',
                    data: datos_grafico800levelread11,
                    options: optionlevelread_800_11
                });


            }
            /////////////////////////////////////// 1 _1









        }
    });

}

function armar_graficos_maxprw() {



    ///////////////////////
    $.ajax({
        url: 'ajax_graph_maxpwr.php?idruninfo=' + params.get('idr'),
        data: "idruninfo=" + params.get('idr'),
        type: 'post',
        async: true,
        cache: false,
        success: function(data) {
            //  console.log(data.label_maxpwr_calib_0_0);

            ///console.log(JSON.parse( data.label_tx ));
            //var keyssmm = Object.keys(datax);
            ///console.log(keyssmm);
            var grafico700maxpwr00 = $('#grafico700maxpwr00').get(0).getContext('2d');
            var grafico700levelread00 = $('#grafico700levelread00').get(0).getContext('2d');

            var grafico700maxpwr01 = $('#grafico700maxpwr01').get(0).getContext('2d');
            var grafico700levelread01 = $('#grafico700levelread01').get(0).getContext('2d');

            var grafico800maxpwr10 = $('#grafico800maxpwr10').get(0).getContext('2d');
            var grafico800levelread10 = $('#grafico800levelread10').get(0).getContext('2d');

            var grafico800maxpwr11 = $('#grafico800maxpwr11').get(0).getContext('2d');
            var grafico800levelread11 = $('#grafico800levelread11').get(0).getContext('2d');

            if (data.iduniqueop_band_0_uldl_0_maxpwr != null && data.iduniqueop_band_0_uldl_0_maxpwr !=
                '') {
                iduniqueop_band_0_uldl_0_maxpwr = data.iduniqueop_band_0_uldl_0_maxpwr.split(",");
                label_tx_maxpwr_0_0 = data.label_maxpwr_calib_0_0.split(",");
                label_700_compartir = data.label_maxpwr_calib_0_0.split(",");
                ref_titulo_0_0 = data.freq_ref_0_0;

                //////////////MAX PRW 0_0 //////////////////////////////////
                //   console.log( Math.min.apply(Math, label_tx_maxpwr_0_0)  ); 
                //    console.log('min parseInt'+   Math.min.apply(Math, iduniqueop_band_0_uldl_0_maxpwr)*0.1);
                //    console.log(parseInt( (Math.min.apply(Math, iduniqueop_band_0_uldl_0_maxpwr)) - (Math.abs(   Math.min.apply(Math, iduniqueop_band_0_uldl_0_maxpwr)*0.1))));
                //     console.log('max parseInt');
                //     console.log(parseInt(Math.max.apply(Math, iduniqueop_band_0_uldl_0_maxpwr) + Math.abs(   Math.max.apply(Math, iduniqueop_band_0_uldl_0_maxpwr)*0.1)));
                //
                /*           $("#grafgralecump").removeClass('d-none');
                           $("#divgrafico700mp").removeClass('d-none');
                           $("#divgrafico700maxpwr00").removeClass('d-none');
                           */
                //     

                var configOptions_maxpwr_00 = {
                    maintainAspectRatio: false,
                    responsive: true,
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Max Power @ ' + ref_titulo_0_0 + ' dBm'
                    },
                    scales: {
                        xAxes: [{
                            gridLines: {
                                display: true,
                            }


                        }],
                        yAxes: [{
                            gridLines: {
                                display: true,

                            },

                            ticks: {

                                suggestedMin: (Math.min.apply(Math,
                                    iduniqueop_band_0_uldl_0_maxpwr) - Math.abs(Math.min
                                    .apply(Math, iduniqueop_band_0_uldl_0_maxpwr) * 0.1
                                )),
                                suggestedMax: (Math.max.apply(Math,
                                    iduniqueop_band_0_uldl_0_maxpwr) + Math.abs(Math.max
                                    .apply(Math, iduniqueop_band_0_uldl_0_maxpwr) * 0.1
                                ))
                            }
                        }]
                    }
                }

                var datos_grafico700maxpwr00 = {
                    labels: label_tx_maxpwr_0_0,
                    datasets: [

                        {
                            label: 'Equalized',
                            backgroundColor: 'rgba(60,141,188,0.3)',
                            borderColor: 'rgba(60,141,188,1)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: iduniqueop_band_0_uldl_0_maxpwr
                        },
                    ]
                };
                //////////////MAX PRW 0_0 //////////////////////////////////
                console.log(datos_grafico700maxpwr00);

                var rpt_grafico700maxpwr00 = new Chart(grafico700maxpwr00, {
                    type: 'line',
                    data: datos_grafico700maxpwr00,
                    options: configOptions_maxpwr_00
                });


            }
            if (data.iduniqueop_band_0_uldl_1_maxpwr != null && data.iduniqueop_band_0_uldl_1_maxpwr !=
                '') {
                iduniqueop_band_0_uldl_1_maxpwr = data.iduniqueop_band_0_uldl_1_maxpwr.split(",");
                label_tx_maxpwr_0_1 = data.label_maxpwr_calib_0_1.split(",");
                ref_titulo_0_1 = data.freq_ref_0_1;
                /*  $("#grafgralecump").removeClass('d-none');
                        $("#divgrafico700mp").removeClass('d-none');
                  $("#divgrafico700maxpwr01").removeClass('d-none');
                  */

                // graf_tx_0_0="Y";
                //////////////MAX PRW 0_1 //////////////////////////////////

                var configOptions_maxpwr_01 = {
                    maintainAspectRatio: false,
                    responsive: true,
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Max Power @ ' + ref_titulo_0_1 + ' dBm'
                    },
                    scales: {
                        xAxes: [{
                            gridLines: {
                                display: true,
                            }


                        }],
                        yAxes: [{
                            gridLines: {
                                display: true,

                            },

                            ticks: {
                                suggestedMin: (Math.min.apply(Math,
                                    iduniqueop_band_0_uldl_1_maxpwr) - Math.abs(Math.min
                                    .apply(Math, iduniqueop_band_0_uldl_1_maxpwr) * 0.1
                                )),
                                suggestedMax: (Math.max.apply(Math,
                                    iduniqueop_band_0_uldl_1_maxpwr) + Math.abs(Math.max
                                    .apply(Math, iduniqueop_band_0_uldl_1_maxpwr) * 0.1
                                ))

                            }
                        }]
                    }
                }

                var datos_grafico700maxpwr01 = {
                    labels: label_tx_maxpwr_0_1,
                    datasets: [

                        {
                            label: 'Equalized',
                            backgroundColor: 'rgba(60,141,188,0.3)',
                            borderColor: 'rgba(60,141,188,1)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: iduniqueop_band_0_uldl_1_maxpwr
                        },
                    ]
                };
                //////////////MAX PRW 0_1 //////////////////////////////////
                var rpt_grafico700maxpwr01 = new Chart(grafico700maxpwr01, {
                    type: 'line',
                    data: datos_grafico700maxpwr01,
                    options: configOptions_maxpwr_01
                });



            }
            if (data.iduniqueop_band_1_uldl_0_maxpwr != null && data.iduniqueop_band_1_uldl_0_maxpwr !=
                '') {
                iduniqueop_band_1_uldl_0_maxpwr = data.iduniqueop_band_1_uldl_0_maxpwr.split(",");
                label_800tx_maxpwr_1_0 = data.label_maxpwr_calib_1_0.split(",");
                label_tx_maxpwr_1_0 = data.label_maxpwr_calib_1_0.split(",");
                label_800_compartir = data.label_maxpwr_calib_1_0.split(",");
                ref_titulo_1_0 = data.freq_ref_1_0;
                // graf_tx_0_0="Y";
                //////////////MAX PRW 0_1 //////////////////////////////////
                /*  $("#grafgralecump").removeClass('d-none');
                       $("#divgrafico800mp").removeClass('d-none');
                     $("#divgrafico800maxpwr10").removeClass('d-none');*/


                var configOptions_maxpwr_10 = {
                    maintainAspectRatio: false,
                    responsive: true,
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Max Power @ ' + ref_titulo_1_0 + ' dBm'
                    },
                    scales: {
                        xAxes: [{
                            gridLines: {
                                display: true,
                            }

                        }],
                        yAxes: [{
                            gridLines: {
                                display: true,

                            },

                            ticks: {
                                suggestedMin: (Math.min.apply(Math,
                                    iduniqueop_band_1_uldl_0_maxpwr) - Math.abs(Math.min
                                    .apply(Math, iduniqueop_band_1_uldl_0_maxpwr) * 0.1
                                )),
                                suggestedMax: (Math.max.apply(Math,
                                    iduniqueop_band_1_uldl_0_maxpwr) + Math.abs(Math.max
                                    .apply(Math, iduniqueop_band_1_uldl_0_maxpwr) * 0.1
                                ))

                            }
                        }]
                    }
                }

                var datos_grafico800maxpwr10 = {
                    labels: label_800tx_maxpwr_1_0,
                    datasets: [

                        {
                            label: 'Equalized',
                            backgroundColor: 'rgba(60,141,188,0.3)',
                            borderColor: 'rgba(60,141,188,1)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: iduniqueop_band_1_uldl_0_maxpwr
                        },
                    ]
                };
                //////////////MAX PRW 1_0 //////////////////////////////////
                var rpt_grafico800maxpwr10 = new Chart(grafico800maxpwr10, {
                    type: 'line',
                    data: datos_grafico800maxpwr10,
                    options: configOptions_maxpwr_10
                });



            }
            if (data.iduniqueop_band_1_uldl_1_maxpwr != null && data.iduniqueop_band_1_uldl_1_maxpwr !=
                '') {
                iduniqueop_band_1_uldl_1_maxpwr = data.iduniqueop_band_1_uldl_1_maxpwr.split(",");
                label_800tx_maxpwr_1_1 = data.label_maxpwr_calib_1_1.split(",");
                label_tx_maxpwr_1_1 = data.label_maxpwr_calib_1_1.split(",");
                ref_titulo_1_1 = data.freq_ref_1_1;
                // graf_tx_0_0="Y";
                //////////////MAX PRW 1_1 //////////////////////////////////
                /*      $("#grafgralecump").removeClass('d-none');
                      $("#divgrafico800mp").removeClass('d-none');
                      $("#divgrafico800maxpwr11").removeClass('d-none');
                      */

                var configOptions_maxpwr_11 = {
                    maintainAspectRatio: false,
                    responsive: true,
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Max Power @ ' + ref_titulo_1_1 + ' dBm'
                    },
                    scales: {
                        xAxes: [{
                            gridLines: {
                                display: true,
                            }


                        }],
                        yAxes: [{
                            gridLines: {
                                display: true,

                            },

                            ticks: {
                                suggestedMin: (Math.min.apply(Math,
                                    iduniqueop_band_1_uldl_1_maxpwr) - Math.abs(Math.min
                                    .apply(Math, iduniqueop_band_1_uldl_1_maxpwr) * 0.1
                                )),
                                suggestedMax: (Math.max.apply(Math,
                                    iduniqueop_band_1_uldl_1_maxpwr) + Math.abs(Math.max
                                    .apply(Math, iduniqueop_band_1_uldl_1_maxpwr) * 0.1
                                ))

                            }
                        }]
                    }
                }

                var datos_grafico800maxpwr11 = {
                    labels: label_800tx_maxpwr_1_1,
                    datasets: [

                        {
                            label: 'Equalized',
                            backgroundColor: 'rgba(60,141,188,0.3)',
                            borderColor: 'rgba(60,141,188,1)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: iduniqueop_band_1_uldl_1_maxpwr
                        },
                    ]
                };
                //////////////MAX PRW 1_0 //////////////////////////////////
                var rpt_grafico800maxpwr11 = new Chart(grafico800maxpwr11, {
                    type: 'line',
                    data: datos_grafico800maxpwr11,
                    options: configOptions_maxpwr_11
                });



            }





            /*     var salesChartOptionslevelread= {
                   maintainAspectRatio : false,
                   responsive : true,	
                   legend: {
                     display: false
                   },
                 
                   scales: {
                     xAxes: [{
                       gridLines : {
                         display : true,		 
                       }
                   
                 
                     }],
                     yAxes: [{
                       gridLines : {
                         display : true,
                   
                       },
                   ticks: {
                                 
                           suggestedMin: -71,
                                   suggestedMax: -60
                             }
                 
                   
                     }]
                   }
                 };
                 */




            armar_graficos_levelread();
            armar_graficos_stresslevelread();



        }
    });




}

function armar_graficos_eq() {
    /// console.log('aca ver'+params.get('idrun'));

    var salesChartOptions = {
        maintainAspectRatio: false,
        responsive: true,
        legend: {
            display: true
        },

        scales: {
            xAxes: [{
                gridLines: {
                    display: true,
                }


            }],
            yAxes: [{
                gridLines: {
                    display: true,

                },
                ticks: {

                    suggestedMin: -5,
                    suggestedMax: 5
                }


            }]
        }
    }



    $.ajax({
        url: 'ajax_graph_eq.php?idruninfo=' + params.get('idr'),
        data: "idruninfo=" + params.get('idr'),
        type: 'post',
        async: true,
        cache: false,
        success: function(data) {
            //    console.log(data.iduniqueop_band_0_uldl_0_tx);

            ///console.log(JSON.parse( data.label_tx ));
            //var keyssmm = Object.keys(datax);
            ///console.log(keyssmm);

            //echo(json_encode(["label_tx_calib"=>$label_tx_calib,"iduniqueop_band_0_uldl_0_tx_calib"=>$iduniqueop_band_0_uldl_0_tx_calib,  "iduniqueop_band_0_uldl_1_tx_calib"=>$iduniqueop_band_0_uldl_1_tx_calib,"iduniqueop_band_1_uldl_0_tx_calib"=>$iduniqueop_band_1_uldl_0_tx_calib,  "iduniqueop_band_1_uldl_1_tx_calib"=>$iduniqueop_band_1_uldl_1_tx,"iduniqueop_band_0_uldl_0_rx_calib"=>$iduniqueop_band_0_uldl_0_rx_calib,  "iduniqueop_band_0_uldl_1_rx_calib"=>$iduniqueop_band_0_uldl_1_rx_calib,"iduniqueop_band_1_uldl_0_rx_calib"=>$iduniqueop_band_1_uldl_0_rx_calib,  "iduniqueop_band_1_uldl_1_rx_calib"=>$iduniqueop_band_1_uldl_1_rx,"iduniqueop_band_0_uldl_0_rx"=>$iduniqueop_band_0_uldl_0_rx,  "iduniqueop_band_0_uldl_1_rx"=>$iduniqueop_band_0_uldl_1_rx,"iduniqueop_band_1_uldl_0_rx"=>$iduniqueop_band_1_uldl_0_rx,  "iduniqueop_band_1_uldl_1_rx"=>$iduniqueop_band_1_uldl_1_rx_check ]));


            var grafico700uptotal00 = $('#grafico700uptotal00').get(0).getContext('2d');
            var grafico700uprx00 = $('#grafico700uprx00').get(0).getContext('2d');
            var grafico700uptx00 = $('#grafico700uptx00').get(0).getContext('2d');

            var grafico700uptotal01 = $('#grafico700uptotal01').get(0).getContext('2d');
            var grafico700uprx01 = $('#grafico700uprx01').get(0).getContext('2d');
            var grafico700uptx01 = $('#grafico700uptx01').get(0).getContext('2d');



            var grafico800uptotal10 = $('#grafico800uptotal10').get(0).getContext('2d');
            var grafico800uprx10 = $('#grafico800uprx10').get(0).getContext('2d');
            var grafico800uptx10 = $('#grafico800uptx10').get(0).getContext('2d');

            var grafico800uptotal11 = $('#grafico800uptotal11').get(0).getContext('2d');
            var grafico800uprx11 = $('#grafico800uprx11').get(0).getContext('2d');
            var grafico800uptx11 = $('#grafico800uptx11').get(0).getContext('2d');

            //    console.log('graf_tx_0_0:'+ graf_tx_0_0);

            if (data.iduniqueop_band_1_uldl_0_tx_calib != null && data.iduniqueop_band_1_uldl_0_tx_calib !=
                '') {
                iduniqueop_band_0_uldl_0_tx_calib = data.iduniqueop_band_0_uldl_0_tx_calib.split(",");
                label_tx_calib_0_0 = data.label_tx_calib_0_0.split(",");
                graf_tx_0_0 = "Y";
            }
            if (data.iduniqueop_band_0_uldl_1_tx_calib != null && data.iduniqueop_band_0_uldl_1_tx_calib !=
                '') {
                iduniqueop_band_0_uldl_1_tx_calib = data.iduniqueop_band_0_uldl_1_tx_calib.split(",");
                label_tx_calib_0_1 = data.label_tx_calib_0_1.split(",");
                graf_tx_0_1 = "Y";
            }
            if (data.iduniqueop_band_1_uldl_0_tx_calib != null && data.iduniqueop_band_1_uldl_0_tx_calib !=
                '') {
                iduniqueop_band_1_uldl_0_tx_calib = data.iduniqueop_band_1_uldl_0_tx_calib.split(",");
                label_tx_calib_1_0 = data.label_tx_calib_1_0.split(",");
                graf_tx_1_0 = "Y";
            }
            if (data.iduniqueop_band_1_uldl_1_tx_calib != null && data.iduniqueop_band_1_uldl_1_tx_calib !=
                '') {
                iduniqueop_band_1_uldl_1_tx_calib = data.iduniqueop_band_1_uldl_1_tx_calib.split(",");
                label_tx_calib_1_1 = data.label_tx_calib_1_1.split(",");
                graf_tx_1_1 = "Y";
            }

            if (data.iduniqueop_band_0_uldl_0_rx_calib != null && data.iduniqueop_band_0_uldl_0_rx_calib !=
                '') {
                iduniqueop_band_0_uldl_0_rx_calib = data.iduniqueop_band_0_uldl_0_rx_calib.split(",");
                label_tx_calib_1_1 = data.label_tx_calib_1_1.split(",");
            }
            if (data.iduniqueop_band_0_uldl_1_rx_calib != null && data.iduniqueop_band_0_uldl_1_rx_calib !=
                '') {
                iduniqueop_band_0_uldl_1_rx_calib = data.iduniqueop_band_0_uldl_1_rx_calib.split(",");
                label_tx_calib_1_1 = data.label_tx_calib_1_1.split(",");
            }
            if (data.iduniqueop_band_1_uldl_0_rx_calib != null && data.iduniqueop_band_1_uldl_0_rx_calib !=
                '') {
                iduniqueop_band_1_uldl_0_rx_calib = data.iduniqueop_band_1_uldl_0_rx_calib.split(",");
                label_tx_calib_1_1 = data.label_tx_calib_1_1.split(",");
            }
            if (data.iduniqueop_band_1_uldl_1_rx_calib != null && data.iduniqueop_band_1_uldl_1_rx_calib !=
                '') {
                iduniqueop_band_1_uldl_1_rx_calib = data.iduniqueop_band_1_uldl_1_rx_calib.split(",");
                label_tx_calib_1_1 = data.label_tx_calib_1_1.split(",");
            }
            if (data.iduniqueop_band_0_uldl_0_rx_check != null && data.iduniqueop_band_0_uldl_0_rx_check !=
                '') {
                iduniqueop_band_0_uldl_0_rx_check = data.iduniqueop_band_0_uldl_0_rx_check.split(",");
                label_tx_calib_1_1 = data.label_tx_calib_1_1.split(",");
            }
            if (data.iduniqueop_band_0_uldl_1_rx_check != null && data.iduniqueop_band_0_uldl_1_rx_check !=
                '') {
                iduniqueop_band_0_uldl_1_rx_check = data.iduniqueop_band_0_uldl_1_rx_check.split(",");
                label_tx_calib_1_1 = data.label_tx_calib_1_1.split(",");
            }
            if (data.iduniqueop_band_0_uldl_0_rx_check != null && data.iduniqueop_band_0_uldl_0_rx_check !=
                '') {
                iduniqueop_band_1_uldl_0_rx_check = data.iduniqueop_band_0_uldl_0_rx_check.split(",");
                label_tx_calib_1_1 = data.label_tx_calib_1_1.split(",");
            }
            if (data.iduniqueop_band_1_uldl_1_rx_check != null && data.iduniqueop_band_1_uldl_1_rx_check !=
                '') {
                iduniqueop_band_1_uldl_1_rx_check = data.iduniqueop_band_1_uldl_1_rx_check.split(",");
                label_tx_calib_1_1 = data.label_tx_calib_1_1.split(",");
            }
            if (data.iduniqueop_band_0_uldl_0_tx_check != null && data.iduniqueop_band_0_uldl_0_tx_check !=
                '') {
                iduniqueop_band_0_uldl_0_tx_check = data.iduniqueop_band_0_uldl_0_tx_check.split(",");
                label_tx_calib_1_1 = data.label_tx_calib_1_1.split(",");
            }
            if (data.iduniqueop_band_0_uldl_1_tx_check != null && data.iduniqueop_band_0_uldl_1_tx_check !=
                '') {
                iduniqueop_band_0_uldl_1_tx_check = data.iduniqueop_band_0_uldl_1_tx_check.split(",");
                label_tx_calib_1_1 = data.label_tx_calib_1_1.split(",");
            }
            if (data.iduniqueop_band_1_uldl_0_tx_check != null && data.iduniqueop_band_1_uldl_0_tx_check !=
                '') {
                iduniqueop_band_1_uldl_0_tx_check = data.iduniqueop_band_1_uldl_0_tx_check.split(",");
                label_tx_calib_1_1 = data.label_tx_calib_1_1.split(",");
            }
            if (data.iduniqueop_band_1_uldl_1_tx_check != null && data.iduniqueop_band_1_uldl_1_tx_check !=
                '') {

                iduniqueop_band_1_uldl_1_tx_check = data.iduniqueop_band_1_uldl_1_tx_check.split(",");
                label_tx_calib_1_1 = data.label_tx_calib_1_1.split(",");
            }

            //    console.log(iduniqueop_band_0_uldl_0_tx_calib);
            //    console.log(iduniqueop_band_0_uldl_0_rx_calib);
            //   console.log( label_tx );

            /////////////////////////// band 0 y uldl = 0 /////////////////////////////////////////////
            if (graf_tx_0_0 == 'Y') {
                /* 
                 $("#grafgralecu").removeClass('d-none');
                 $("#divgrafico700").removeClass('d-none');
                 $("#divgrafico700uptotal00").removeClass('d-none');
                 $("#divgrafico700uprx00").removeClass('d-none');
                 $("#divgrafico700uptx00").removeClass('d-none');
                 */

                var grafico700uptx_datos_0_0_calib = {
                    labels: label_tx_calib_0_0,
                    datasets: [{
                            label: 'Equalized',
                            backgroundColor: 'rgba(60,141,188,0.3)',
                            borderColor: 'rgba(60,141,188,1)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: iduniqueop_band_0_uldl_0_tx_check
                        },
                        {
                            label: 'Not Equalized',
                            backgroundColor: 'rgba(255, 99, 132, 0.5)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            pointRadius: false,
                            pointColor: 'rgba(255, 99, 132, 1)',
                            pointStrokeColor: '#c1c7d1',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(255, 99, 132, 1)',
                            data: iduniqueop_band_0_uldl_0_tx_calib
                        },
                    ]
                };

                var grafico700uprx_datos_0_0_check = {
                    labels: label_tx_calib_0_0,
                    datasets: [{
                            label: 'Equalized',
                            backgroundColor: 'rgba(60,141,188,0.3)',
                            borderColor: 'rgba(60,141,188,1)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: iduniqueop_band_0_uldl_0_rx_check

                        },
                        {
                            label: 'Not Equalized',
                            backgroundColor: 'rgba(255, 99, 132, 0.5)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            pointRadius: false,
                            pointColor: 'rgba(255, 99, 132, 1)',
                            pointStrokeColor: '#c1c7d1',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(255, 99, 132, 1)',
                            data: iduniqueop_band_0_uldl_0_rx_calib
                        },
                    ]
                };

                iduniqueop_band_0_uldl_0_tx_check_total = sumArray(iduniqueop_band_0_uldl_0_tx_check,
                    iduniqueop_band_0_uldl_0_rx_check);
                iduniqueop_band_0_uldl_0_rx_check_total = sumArray(iduniqueop_band_0_uldl_0_tx_calib,
                    iduniqueop_band_0_uldl_0_rx_calib);
                //  console.log('sumArray');
                console.log(iduniqueop_band_0_uldl_0_rx_check);
                console.log(iduniqueop_band_0_uldl_0_rx_calib);
                console.log(iduniqueop_band_0_uldl_0_tx_check_total);

                var grafico700uprx_datos_0_0_total = {
                    labels: label_tx_calib_0_0,
                    datasets: [{
                            label: 'Equalized',
                            backgroundColor: 'rgba(60,141,188,0.3)',
                            borderColor: 'rgba(60,141,188,1)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: iduniqueop_band_0_uldl_0_tx_check_total

                        },
                        {
                            label: 'Not Equalized',
                            backgroundColor: 'rgba(255, 99, 132, 0.5)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            pointRadius: false,
                            pointColor: 'rgba(255, 99, 132, 1)',
                            pointStrokeColor: '#c1c7d1',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(255, 99, 132, 1)',
                            data: iduniqueop_band_0_uldl_0_rx_check_total
                        },
                    ]
                };

                var armograf_grafico700uptx00 = new Chart(grafico700uptx00, {
                    type: 'line',
                    data: grafico700uptx_datos_0_0_calib,
                    options: salesChartOptions
                });

                var armograf_grafico700uprx = new Chart(grafico700uprx00, {
                    type: 'line',
                    data: grafico700uprx_datos_0_0_check,
                    options: salesChartOptions
                });

                var armograf_grafico700uptotal = new Chart(grafico700uptotal00, {
                    type: 'line',
                    data: grafico700uprx_datos_0_0_total,
                    options: salesChartOptions
                });
            }



            /////////////////////////// band 0 y uldl = 0 /////////////////////////////////////////////  
            /////////////////////////// band 0 y uldl = 1 /////////////////////////////////////////////
            if (graf_tx_0_1 == 'Y') {
                /*
                $("#grafgralecu").removeClass('d-none');
                $("#divgrafico700").removeClass('d-none');
                $("#divgrafico700uptotal01").removeClass('d-none');
                $("#divgrafico700uprx01").removeClass('d-none');
                $("#divgrafico700uptx01").removeClass('d-none');
                */

                var grafico700uprx_datos_0_1_calib = {
                    labels: label_tx_calib_0_1,
                    datasets: [{
                            label: 'Equalized',
                            backgroundColor: 'rgba(60,141,188,0.3)',
                            borderColor: 'rgba(60,141,188,1)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: iduniqueop_band_0_uldl_1_tx_check
                        },
                        {
                            label: 'Not Equalized',
                            backgroundColor: 'rgba(255, 99, 132, 0.5)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            pointRadius: false,
                            pointColor: 'rgba(255, 99, 132, 1)',
                            pointStrokeColor: '#c1c7d1',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(255, 99, 132, 1)',
                            data: iduniqueop_band_0_uldl_1_tx_calib
                        },
                    ]
                };

                var grafico700uptx_datos_0_1_check = {
                    labels: label_tx_calib_0_1,
                    datasets: [{
                            label: 'Equalized',
                            backgroundColor: 'rgba(60,141,188,0.3)',
                            borderColor: 'rgba(60,141,188,1)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: iduniqueop_band_0_uldl_1_tx_check

                        },
                        {
                            label: 'Not Equalized',
                            backgroundColor: 'rgba(255, 99, 132, 0.5)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            pointRadius: false,
                            pointColor: 'rgba(255, 99, 132, 1)',
                            pointStrokeColor: '#c1c7d1',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(255, 99, 132, 1)',
                            data: iduniqueop_band_0_uldl_1_tx_calib
                        },
                    ]
                };

                iduniqueop_band_0_uldl_1_tx_check_total = sumArray(iduniqueop_band_0_uldl_1_tx_check,
                    iduniqueop_band_0_uldl_1_rx_check);
                iduniqueop_band_0_uldl_1_rx_check_total = sumArray(iduniqueop_band_0_uldl_1_tx_calib,
                    iduniqueop_band_0_uldl_1_rx_calib);
                //  console.log('sumArray');
                //  console.log(iduniqueop_band_0_uldl_0_tx_check_total);

                var grafico700uprx_datos_0_1_total = {
                    labels: label_tx_calib_0_1,
                    datasets: [{
                            label: 'Equalized',
                            backgroundColor: 'rgba(60,141,188,0.3)',
                            borderColor: 'rgba(60,141,188,1)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: iduniqueop_band_0_uldl_1_tx_check_total

                        },
                        {
                            label: 'Not Equalized',
                            backgroundColor: 'rgba(255, 99, 132, 0.5)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            pointRadius: false,
                            pointColor: 'rgba(255, 99, 132, 1)',
                            pointStrokeColor: '#c1c7d1',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(255, 99, 132, 1)',
                            data: iduniqueop_band_0_uldl_1_rx_check_total
                        },
                    ]
                };

                var armograf_grafico700uptx01 = new Chart(grafico700uptx01, {
                    type: 'line',
                    data: grafico700uptx_datos_0_1_check,
                    options: salesChartOptions
                });

                var armograf_grafico700dwrx01 = new Chart(grafico700uprx01, {
                    type: 'line',
                    data: grafico700uprx_datos_0_1_calib,
                    options: salesChartOptions
                });

                var totalarmograf_grafico700dwrx01 = new Chart(grafico700uptotal01, {
                    type: 'line',
                    data: grafico700uprx_datos_0_1_total,
                    options: salesChartOptions
                });



            }
            /////////////////////////// band 0 y uldl = 1 /////////////////////////////////////////////   
            /////////////////////////// band 1 y uldl = 0 /////////////////////////////////////////////
            if (graf_tx_1_0 == 'Y') {
                /*   $("#grafgralecu").removeClass('d-none');
                   $("#divgrafico800").removeClass('d-none');
                 $("#divgrafico800uptotal10").removeClass('d-none');
                 $("#divgrafico800uprx10").removeClass('d-none');
                 $("#divgrafico800uptx10").removeClass('d-none');*/

                var grafico800uptx_datos_1_0_calib = {
                    labels: label_tx_calib_1_0,
                    datasets: [{
                            label: 'Equalized',
                            backgroundColor: 'rgba(60,141,188,0.3)',
                            borderColor: 'rgba(60,141,188,1)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: iduniqueop_band_1_uldl_0_tx_check
                        },
                        {
                            label: 'Not Equalized',
                            backgroundColor: 'rgba(255, 99, 132, 0.5)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            pointRadius: false,
                            pointColor: 'rgba(255, 99, 132, 1)',
                            pointStrokeColor: '#c1c7d1',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(255, 99, 132, 1)',
                            data: iduniqueop_band_1_uldl_0_tx_calib
                        },
                    ]
                };


                var grafico800uptx_datos_1_0_check = {
                    labels: label_tx_calib_1_0,
                    datasets: [{
                            label: 'Equalized',
                            backgroundColor: 'rgba(60,141,188,0.3)',
                            borderColor: 'rgba(60,141,188,1)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: iduniqueop_band_1_uldl_0_tx_check

                        },
                        {
                            label: 'Not Equalized',
                            backgroundColor: 'rgba(255, 99, 132, 0.5)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            pointRadius: false,
                            pointColor: 'rgba(255, 99, 132, 1)',
                            pointStrokeColor: '#c1c7d1',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(255, 99, 132, 1)',
                            data: iduniqueop_band_1_uldl_0_tx_calib
                        },
                    ]
                };

                iduniqueop_band_1_uldl_0_tx_check_total = sumArray(iduniqueop_band_1_uldl_0_tx_check,
                    iduniqueop_band_1_uldl_0_rx_check);
                iduniqueop_band_1_uldl_0_rx_check_total = sumArray(iduniqueop_band_1_uldl_0_tx_calib,
                    iduniqueop_band_1_uldl_0_rx_calib);

                var grafico800uprx_datos_1_0_total = {
                    labels: label_tx_calib_1_0,
                    datasets: [{
                            label: 'Equalized',
                            backgroundColor: 'rgba(60,141,188,0.3)',
                            borderColor: 'rgba(60,141,188,1)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: iduniqueop_band_1_uldl_0_tx_check_total

                        },
                        {
                            label: 'Not Equalized',
                            backgroundColor: 'rgba(255, 99, 132, 0.5)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            pointRadius: false,
                            pointColor: 'rgba(255, 99, 132, 1)',
                            pointStrokeColor: '#c1c7d1',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(255, 99, 132, 1)',
                            data: iduniqueop_band_1_uldl_0_rx_check_total
                        },
                    ]
                };

                var armograf_grafico800uptx10 = new Chart(grafico800uptx10, {
                    type: 'line',
                    data: grafico800uptx_datos_1_0_calib,
                    options: salesChartOptions
                });

                var armograf_grafico800dwrx10 = new Chart(grafico800uprx10, {
                    type: 'line',
                    data: grafico800uptx_datos_1_0_check,
                    options: salesChartOptions
                });

                var torarmograf_grafico800dwrx10 = new Chart(grafico800uptotal10, {
                    type: 'line',
                    data: grafico800uprx_datos_1_0_total,
                    options: salesChartOptions
                });

            }
            /////////////////////////// band 1 y uldl = 0 /////////////////////////////////////////////                
            /////////////////////////// band 1 y uldl = 1 /////////////////////////////////////////////                

            if (graf_tx_1_1 == 'Y') {
                /*   $("#grafgralecu").removeClass('d-none');
                      $("#divgrafico800").removeClass('d-none');
                $("#divgrafico800uptotal11").removeClass('d-none');
                $("#divgrafico800uprx11").removeClass('d-none');
                $("#divgrafico800uptx11").removeClass('d-none');
*/

                var grafico800uptx_datos_1_1_check = {
                    labels: label_tx_calib_1_0,
                    datasets: [{
                            label: 'Equalized',
                            backgroundColor: 'rgba(60,141,188,0.3)',
                            borderColor: 'rgba(60,141,188,1)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: iduniqueop_band_1_uldl_1_tx_check

                        },
                        {
                            label: 'Not Equalized',
                            backgroundColor: 'rgba(255, 99, 132, 0.5)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            pointRadius: false,
                            pointColor: 'rgba(255, 99, 132, 1)',
                            pointStrokeColor: '#c1c7d1',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(255, 99, 132, 1)',
                            data: iduniqueop_band_1_uldl_1_tx_calib
                        },
                    ]
                };

                //99
                var grafico800uptx_datos_1_1_check = {
                    labels: label_tx_calib_1_0,
                    datasets: [{
                            label: 'Equalized',
                            backgroundColor: 'rgba(60,141,188,0.3)',
                            borderColor: 'rgba(60,141,188,1)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: iduniqueop_band_1_uldl_1_tx_check

                        },
                        {
                            label: 'Not Equalized',
                            backgroundColor: 'rgba(255, 99, 132, 0.5)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            pointRadius: false,
                            pointColor: 'rgba(255, 99, 132, 1)',
                            pointStrokeColor: '#c1c7d1',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(255, 99, 132, 1)',
                            data: iduniqueop_band_1_uldl_1_tx_calib
                        },
                    ]
                };

                iduniqueop_band_1_uldl_1_tx_check_total = sumArray(iduniqueop_band_1_uldl_1_tx_check,
                    iduniqueop_band_1_uldl_1_rx_check);
                iduniqueop_band_1_uldl_1_rx_check_total = sumArray(iduniqueop_band_1_uldl_1_tx_calib,
                    iduniqueop_band_1_uldl_1_rx_calib);

                var grafico800uprx_datos_1_1_total = {
                    labels: label_tx_calib_1_0,
                    datasets: [{
                            label: 'Equalized',
                            backgroundColor: 'rgba(60,141,188,0.3)',
                            borderColor: 'rgba(60,141,188,1)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: iduniqueop_band_1_uldl_1_tx_check_total

                        },
                        {
                            label: 'Not Equalized',
                            backgroundColor: 'rgba(255, 99, 132, 0.5)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            pointRadius: false,
                            pointColor: 'rgba(255, 99, 132, 1)',
                            pointStrokeColor: '#c1c7d1',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(255, 99, 132, 1)',
                            data: iduniqueop_band_1_uldl_1_rx_check_total
                        },
                    ]
                };

                var armograf_grafico800uptx11 = new Chart(grafico800uptx11, {
                    type: 'line',
                    data: grafico800uptx_datos_1_1_check,
                    options: salesChartOptions
                });

                var armograf_grafico800dwrx11 = new Chart(grafico800uprx11, {
                    type: 'line',
                    data: grafico800uptx_datos_1_1_check,
                    options: salesChartOptions
                });

                var totlarmograf_grafico800dwrx11 = new Chart(grafico800uptotal11, {
                    type: 'line',
                    data: grafico800uprx_datos_1_1_total,
                    options: salesChartOptions
                });

            }
            /////////////////////////// band 1 y uldl = 1 /////////////////////////////////////////////                



        }
    });



    // console.log(armograf_grafico700uptotal.data.labels);
    // armograf_grafico700uptotal.data.labels.length = 0;
    // armograf_grafico700uptotal.data.datasets.length = 0;  

    //armograf_grafico700uptotal.data.labels.push(label_tx);


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
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
            header("Location: http://".$ipservidorapache."/index.php?t=timeoutinactivity");
        }
    }
	else
	{
			session_unset();
            session_destroy();
            header("Location: http://".$ipservidorapache."/index.php?t=notcookietimeout");
        
	}
	
	$status = $connect->getAttribute(PDO::ATTR_CONNECTION_STATUS);
	
	if ($status !="Connection OK; waiting to send.")
	{
	
		header("Location: http://".$ipservidorapache."/".$folderservidor."/errorconect.php");
		exit;
		
	}

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
  
  
  <link href="css/tabulator_bootstrap4.css" rel="stylesheet">
  <link rel="shortcut icon" href="fiplexcirculo-01.ico" />
  
  <link rel="stylesheet" href="toastr.css">
  
 <link href="css/tabulator_bulma.css" rel="stylesheet">
 
  
    <link rel="stylesheet" href="cssfiplex.css">
	
		<style>
	body
{
  font-family: Arial, Helvetica, sans-serif;
  font-size:14px;
}
a:link {
  color:#000000;
}

a:visited {
 color:#000000;
}

a:hover {
  color:#000000;
}

a:active {
 color:#000000;
}

.card-headermarco
{
	  font-family: Arial, Helvetica, sans-serif;
  font-size:14px;
  border-style: solid;
  border-color:#ffffff;
  border-width: 1px;
}

.example1_wrapper
{
 border-style: solid; 
  border-width: 2px;	
}

textarea.form-control {
    height: 100%;
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
        <a href="http://srv-pgsql.fiplex.com/index.php" class="nav-link">Home</a>
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
            <h1>Sales Orders </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Sales Orders</li>
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
          <section class="col-lg-6 connectedSortable ui-sortable">

            <div class="" name="divscrolllog" id="divscrolllog" style="display.">
			
			  <div class="demo-container">
  
			
			
			<p name="msjwaitline" id="msjwaitline" align="center"><img src="img/waitazul.gif" width="100px" ></p>	
				<div class="card">
						<div id="accordion">
					<br>			
					<table id="example1" class="table table-sm table-striped">
						<thead>
						<tr style="background-color:#3c3c3b;color:#aaaaaa">                  
						  <th>SO - Customers
						 <span name="openbusqueda" id="openbusqueda" > &nbsp; &nbsp; &nbsp;<a href="#" onclick="habilitarbusqueda();"><i class="fas fas fa-search-plus mr-1" style='color:#aaaaaa' ></i></a></span>
						 <span name="closebusqueda" id="closebusqueda"> &nbsp; &nbsp; &nbsp;<a href="#" onclick="dehabilitarbusqueda();"><i class="fas fas  fa-search-minus mr-1" style='color:#aaaaaa' ></i></a></span>
						  </th>   
						</tr>
						</thead>
						<tbody>
					  
							
								<?php		

							
							  		   $query_lista = list_SO_count_report1();	
									//	echo $query_lista;									   
										$data = $connect->query($query_lista)->fetchAll();		

   
  
									//echo  $query_lista;
										foreach ($data as $row) 
										{
											$qporc=round(($row[3]*100)/$row[2]);
												  $bgclass="bg-warning";
												  if ($qporc < 40)
												  {
													    $bgclass="bg-danger";
												  }
											      if ($qporc >= 40)
												  {
													    $bgclass="bg-warning";
												  }
												  if ($qporc >= 85)
												  {
													    $bgclass="bg-green";
												  }
												  $v_show_SO_CIU = $row[1];
											?>
												<tr>                  
												  <td>
													
														                   
															<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $row[0]; ?>" class="" aria-expanded="true" onclick="show_ciu('<?php echo $row[0]; ?>','<?php echo $v_show_SO_CIU; ?>')">
																
															  <i class="nav-icon fas fa-list-alt"></i>
															<?php
																$xnom = str_replace('#', ' ', substr($row[4],0,30)); 
																 //echo  " ".$row[1]." - ".substr($row[4],0,30); 
																 echo  " ".$row[1]." - ".$xnom;
																if ( strlen($row[4])>31) 
															    { 
																 echo "...";
																}  
																?> 
																
																
																</a>
														  
														
														  
																<span data-toggle="tooltip" title="" class="badge <?php echo $bgclass; ?>  mb-2 labelsom ">										
																   <?php echo " [ ".$row[2]; ?> CIU ]
																																
																</span> 			
																<a href="#"><i class="nav-icon fas fa-chart-line"></i>	</a>																
																			
														
														<div id="collapse<?php echo $row[0]; ?>" class="panel-collapse in collapse" style="background-color:#ffffff">
														<span class="textooculto" style="display:none">
															<?php echo "###".$row['groupxciu']."###".$row['groupxsn']."###".$row[0]."###".$row[1]."###"; ?>
															</span>
														<table id="example3" class="table table-bordered table-striped table-sm">
														<tbody><tr><td>
															<div class="card-headermarco">
															
																
														    </div>
														</td></tr>	</tbody></table>
														</div>
															
														
												  </td>	
												</tr>														
											<?php
										}
											
								?>			
							
                  <!-- we are adding the .class so bootstrap.js collapse plugin detects it -->
							
						</tbody>
					  </table>
					</div>				  
				</div>	
				</div>
			
					

        </section>
		<section class="col-lg-6 connectedSortable ui-sortable">
		

				<div class="card">
				<div class="card-header ui-sortable-handle" >
               		
				<div class="card">
            
              <!-- /.card-header -->
              <div class="card-body p-0" style="display: block;">
                <div class="d-md-flex">
                  <div class="p-1 flex-fill" style="overflow: hidden" >
                    
					
					<!--detalle so -->
					<div class="card" style="position: relative; left: 0px; top: 0px;">
              <div class="card-header ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title">
                  <i class="fas fas fa-tag mr-1"></i>
                  General Info - Details: 
				  <p name="ciusnshowbks" id="ciusnshowbks" class="d-none "> 
                </h3><p name="ciusnshow" id="ciusnshow" class="text-primary ">  </p>
                <div class="card-tools">
                  <ul class="nav nav-pills ml-auto">
                    <li class="nav-item" name="divgeneralinfo" id="divgeneralinfo">
                      <a class="nav-link active" href="#generalinfo" id="generalinfo" data-toggle="tab">General Info</a>
                    </li>
					<li class="nav-item" name="divgeneralinfoparam" id="divgeneralinfoparam">
                      <a class="nav-link" href="#generalinfoul"  id="generalinfoul" data-toggle="tab">Parameters</a>
                    </li>
					
                    <li class="nav-item" name="divdetinfolog" id="divdetinfolog">
                      <a class="nav-link " href="#infolog" data-toggle="tab">Details Log</a>
                    </li>  
					
					 <li class="nav-item" name="diveq" id="diveq">
                      <a class="nav-link " href="#div_calib_eq" data-toggle="tab">EQ</a>
                    </li> 
					<li class="nav-item" name="divfactory" id="divfactory">
                      <a class="nav-link " href="#div_calib_fact" data-toggle="tab">Factory</a>
                    </li> 
					<li class="nav-item" name="divfinalcheck" id="divfinalcheck">
                      <a class="nav-link " href="#div_calib_finalcheck" data-toggle="tab">Final Check</a>
                    </li> 
						
					<li class="nav-item" name="divgroupbyciu" id="divgroupbyciu">
                      <a class="nav-link " href="#infogroupbyciu" data-toggle="tab">Group by CIU</a>
                    </li>
                  </ul>
                </div>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content p-0">
                  <!-- Morris chart - Sales -->
				  <div class="chart tab-pane pre-scrollablemarco  " id="infogroupbyciu" style="position: relative; ">
				  
				  
					--
				  </div>
				   <div class="chart tab-pane pre-scrollablemarco " id="generalinfoul" style="position: relative; ">
				     <table id="myTableul"  border="1" class="table table-bordered table-sm texto10 scrolltablemarco table-striped  d-none">							
							  <tr data-rowul="0" >
								<td data-rowul="0" data-colul="0" align='center'><B>PARAMETERS<B> </td>								
							  </tr>
							  <tr data-rowdl="1">
								<td data-rowul="1" data-colul="0"><b>Gain:</b> </td>								
							  </tr>
							  <tr data-rowul="2">
								<td data-rowul="2" data-colul="0"><b>Max Pwr:</b> </td>								
							  </tr>
							  <tr data-rowul="3">
								<td data-rowul="3" data-colul="0"><b>Freq Start:</b> </td>								
							  </tr>
							  <tr data-rowul="4">
								<td data-rowul="4" data-colul="0"><b>Freq Stop:</b> </td>								
							  </tr> 
							   
							</table>
							
							<table id='myTablesubband' border='1' class='table table-bordered table-sm texto10 table-striped  scrolltablemarco d-none'>
							<tr data-rowsubband='0'><td data-rowsubband='0' data-colsubband='0'><B>SUB BAND<B> </td></tr>
							<tr data-rowsubband='1'><td data-rowsubband='1' data-colsubband='0'><b>Start:</b></td></tr>
							<tr data-rowsubband='2'><td data-rowsubband='2' data-colsubband='0'><b>Center:</b></td></tr>
							<tr data-rowsubband='3'><td data-rowsubband='3' data-colsubband='0'><b>Stop:</b></td></tr>
							
							</table>
							
							<table id='myTablechanel' border='1' class='table table-bordered table-sm texto10 table-striped  scrolltablemarco d-none'>
							<tr data-rowchanel='0'><td data-rowchanel='0' data-colchanel='0'><B>FREC. CH.<B></td></tr>
							<tr data-rowchanel='1'><td data-rowchanel='1' data-colchanel='0'><b>FCh[0]:</b></td></tr>
							<tr data-rowchanel='2'><td data-rowchanel='2' data-colchanel='0'><b>FCh[1]:</b></td></tr>
							<tr data-rowchanel='3'><td data-rowchanel='3' data-colchanel='0'><b>FCh[2]:</b></td></tr>
							<tr data-rowchanel='4'><td data-rowchanel='4' data-colchanel='0'><b>FCh[3]:</b></td></tr>
							<tr data-rowchanel='5'><td data-rowchanel='5' data-colchanel='0'><b>FCh[4]:</b></td></tr>
							<tr data-rowchanel='6'><td data-rowchanel='6' data-colchanel='0'><b>FCh[5]:</b></td></tr>
							<tr data-rowchanel='7'><td data-rowchanel='7' data-colchanel='0'><b>FCh[6]:</b></td></tr>
							<tr data-rowchanel='8'><td data-rowchanel='8' data-colchanel='0'><b>FCh[7]:</b></td></tr>
							<tr data-rowchanel='9'><td data-rowchanel='9' data-colchanel='0'><b>FCh[8]:</b></td></tr>
							<tr data-rowchanel='10'><td data-rowchanel='10' data-colchanel='0'><b>FCh[9]:</b></td></tr>
							<tr data-rowchanel='11'><td data-rowchanel='11' data-colchanel='0'><b>FCh[11]:</b></td></tr>							
							<tr data-rowchanel='12'><td data-rowchanel='12' data-colchanel='0'><b>FCh[12]:</b></td></tr>
							<tr data-rowchanel='13'><td data-rowchanel='13' data-colchanel='0'><b>FCh[13]:</b></td></tr>
							<tr data-rowchanel='14'><td data-rowchanel='14' data-colchanel='0'><b>FCh[14]:</b></td></tr>
							<tr data-rowchanel='15'><td data-rowchanel='15' data-colchanel='0'><b>FCh[15]:</b></td></tr>
							<tr data-rowchanel='16'><td data-rowchanel='16' data-colchanel='0'><b>FCh[16]:</b></td></tr>
							<tr data-rowchanel='17'><td data-rowchanel='17' data-colchanel='0'><b>FCh[17]:</b></td></tr>
							<tr data-rowchanel='18'><td data-rowchanel='18' data-colchanel='0'><b>FCh[18]:</b></td></tr>
							<tr data-rowchanel='19'><td data-rowchanel='19' data-colchanel='0'><b>FCh[19]:</b></td></tr>
							<tr data-rowchanel='20'><td data-rowchanel='20' data-colchanel='0'><b>FCh[20]:</b></td></tr>
							<tr data-rowchanel='21'><td data-rowchanel='21' data-colchanel='0'><b>FCh[21]:</b></td></tr>
							<tr data-rowchanel='22'><td data-rowchanel='22' data-colchanel='0'><b>FCh[22]:</b></td></tr>
							<tr data-rowchanel='23'><td data-rowchanel='23' data-colchanel='0'><b>FCh[23]:</b></td></tr>
							<tr data-rowchanel='24'><td data-rowchanel='24' data-colchanel='0'><b>FCh[24]:</b></td></tr>
							<tr data-rowchanel='25'><td data-rowchanel='25' data-colchanel='0'><b>FCh[25]:</b></td></tr>
							<tr data-rowchanel='26'><td data-rowchanel='26' data-colchanel='0'><b>FCh[26]:</b></td></tr>
							<tr data-rowchanel='27'><td data-rowchanel='27' data-colchanel='0'><b>FCh[27]:</b></td></tr>
							<tr data-rowchanel='28'><td data-rowchanel='28' data-colchanel='0'><b>FCh[28]:</b></td></tr>
							<tr data-rowchanel='29'><td data-rowchanel='29' data-colchanel='0'><b>FCh[29]:</b></td></tr>
							<tr data-rowchanel='30'><td data-rowchanel='30' data-colchanel='0'><b>FCh[30]:</b></td></tr>
							
							</table>
							
							
				   </div>
				
                  <div class="chart tab-pane active pre-scrollablemarco " id="generalinfo" style="position: relative;">
                  	
							<table id='myTable'  class='table table-bordered table-sm texto10 scrolltablemarco table-striped  d-none'><tr data-row='0'><td data-row='0' data-col='0'></td></tr><tr data-row='1'><td data-row='1' data-col='0'><b>Approved:</b> </td></tr><tr data-row='2'><td data-row='2' data-col='0'><b>Power Supply:PO:</b> </td> </tr><tr data-row='3'><td data-row='3' data-col='0'><b>PO:</b></td></tr><tr data-row='4'><td data-row='4' data-col='0'><b>RC-G for BWA:</b> </td></tr><tr data-row='5'><td data-row='5' data-col='0'><b>Moden Digital:</b></td></tr><tr data-row='6'><td data-row='6' data-col='0'><b>Descripcion:</b> </td></tr></table>
							
							<table id='myTabledib' border='1' class='table table-bordered table-sm texto10 scrolltablemarco table-striped  d-none'>
							<tr data-rowdib='0'><td data-rowdib='0' data-coldib='0' class='table-info'><b>GENERAL INFO</b> </td></tr>
							<tr data-rowdib='1'><td data-rowdib='1' data-coldib='0'>Date</td></tr>
							<tr data-rowdib='2'><td data-rowdib='2' data-coldib='0'>TotalTime </td></tr>
							<tr data-rowdib='3'><td data-rowdib='3' data-coldib='0'>Calibratior </td></tr>
							<tr data-rowdib='4'><td data-rowdib='4' data-coldib='0'>Station</td></tr>
							<tr data-rowdib='5'><td data-rowdib='5' data-coldib='0'>FAS</td></tr>
							<tr data-rowdib='6'><td data-rowdib='6' data-coldib='0'>Total Pass </td></tr>	
														
							</table>
							<table id='myTabledibfw' border='1' class='table table-bordered table-sm texto10 scrolltablemarco table-striped  d-none'>
							<tr data-rowdibfw='0'><td data-rowdibfw='0' data-coldibfw='0' class="table-info"><b>FWs</b> </td></tr>
							<tr data-rowdibfw='1'><td data-rowdibfw='1' data-coldibfw='0'>FW FPGA</td></tr>
							<tr data-rowdibfw='2'><td data-rowdibfw='2' data-coldibfw='0'>FW uC </td></tr>
							<tr data-rowdibfw='3'><td data-rowdibfw='3' data-coldibfw='0'>FW Rabb </td></tr>							
							</table>
							<table id='myTabledibsn' border='1' class='table table-bordered table-sm texto10 scrolltablemarco table-striped  d-none '>
							<tr data-rowdibsn='0'><td data-rowdibsn='0' data-coldibsn='0' class="table-info"><b>SNs</b> </td></tr>
							<tr data-rowdibsn='1'><td data-rowdibsn='1' data-coldibsn='0'>SN DB</td></tr>
							<tr data-rowdibsn='2'><td data-rowdibsn='2' data-coldibsn='0'>SN Unit </td></tr>							
							</table>
							<table id='myTabledibciu' border='1' class='table table-bordered table-sm texto10 scrolltablemarco table-striped  d-none'>
							<tr data-rowdibciu='0'><td data-rowdibciu='0' data-coldibciu='0' class="table-info"><b>CIUs</b> </td></tr>
							<tr data-rowdibciu='1'><td data-rowdibciu='1' data-coldibciu='0'>CIU DB</td></tr>
							<tr data-rowdibciu='2'><td data-rowdibciu='2' data-coldibciu='0'>CIU Unit </td></tr>							
							</table>
							
							<table id='myTablecaliffw' border='1' class='table table-bordered table-sm texto10 scrolltablemarco table-striped  d-none'>
							<tr data-rowcaliffw='0'><td data-rowcaliffw='0' data-colcaliffw='0' class="table-info"><b>FWs</b> </td></tr>
							<tr data-rowcaliffw='1'><td data-rowcaliffw='1' data-colcaliffw='0'>FW FPGA</td></tr>
							<tr data-rowcaliffw='2'><td data-rowcaliffw='2' data-colcaliffw='0'>FW uC </td></tr>
							<tr data-rowcaliffw='3'><td data-rowcaliffw='3' data-colcaliffw='0'>FW Rabb </td></tr>
							<tr data-rowcaliffw='4'><td data-rowcaliffw='4' data-colcaliffw='0'>FW PAHP </td></tr>														
							</table>
							
							<table id='myTablecalifsn' border='1' class='table table-bordered table-sm texto10 scrolltablemarco table-striped  d-none '>
							<tr data-rowcalifsn='0'><td data-rowcalifsn='0' data-colcalifsn='0' class="table-info"><b>SNs</b> </td></tr>
							<tr data-rowcalifsn='1'><td data-rowcalifsn='1' data-colcalifsn='0'>SN DB</td></tr>
							<tr data-rowcalifsn='2'><td data-rowcalifsn='2' data-colcalifsn='0'>SN Unit </td></tr>							
							<tr data-rowcalifsn='3'><td data-rowcalifsn='3' data-colcalifsn='0'>SN PALP </td></tr>							
							<tr data-rowcalifsn='4'><td data-rowcalifsn='4' data-colcalifsn='0'>SN PAHP </td></tr>							
							</table>
							
							<table id='myTablecalifciu' border='1' class='table table-bordered table-sm texto10 scrolltablemarco table-striped  d-none'>
							<tr data-rowcalifciu='0'><td data-rowcalifciu='0' data-colcalifciu='0' class="table-info"><b>CIUs</b> </td></tr>
							<tr data-rowcalifciu='1'><td data-rowcalifciu='1' data-colcalifciu='0'>CIU DB</td></tr>
							<tr data-rowcalifciu='2'><td data-rowcalifciu='2' data-colcalifciu='0'>CIU Unit </td></tr>	
							<tr data-rowcalifciu='3'><td data-rowcalifciu='3' data-colcalifciu='0'>CIU PALP</td></tr>
							<tr data-rowcalifciu='4'><td data-rowcalifciu='4' data-colcalifciu='0'>CIU PAHP </td></tr>								
							</table>
							
							<table id='myTablecaliffreq' border='1' class='table table-bordered table-sm texto10 scrolltablemarco table-striped d-none '>
							<tr data-rowccaliffreq='0'><td data-rowcaliffreq='0' data-colcaliffreq='0' class="table-info"><b>Freqs</b> </td></tr>
							<tr data-rowcaliffreq='1'><td data-rowcaliffreq='1' data-colcaliffreq='0'>UL Start</td></tr>
							<tr data-rowcaliffreq='2'><td data-rowcaliffreq='2' data-colcaliffreq='0'>UL Stop </td></tr>	
							<tr data-rowcaliffreq='3'><td data-rowcaliffreq='3' data-colcaliffreq='0'>DL Start</td></tr>
							<tr data-rowcaliffreq='4'><td data-rowcaliffreq='4' data-colcaliffreq='0'>DL Stop </td></tr>								
							</table>
											
                   </div>
                  <div class="chart tab-pane pre-scrollablemarco d-none" id="infolog" style="position: relative;">
				  <button type="button" class="btn btn-sm "><i class="fas fa-search"></i> Rev 0</button>	  
				    
				  
				  
				  <textarea class="form-control" rows="18" id="detallelog" name="detallelog"></textarea>
                    
                  </div>  
				  <div class="chart tab-pane pre-scrollablemarco d-none" id="div_calib_eq" style="position: relative;">			
                   
                  </div> 
				 <div class="chart tab-pane pre-scrollablemarco d-none" id="div_calib_fact" style="position: relative;">			
                    
                  </div>  				  
                </div>
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
					<!-- fin detalle so -->
					
					<p name="detallelog1" id="detallelog1" ></p>						
					<p name="msjwait" id="msjwait" align="center"><img src="img/waitazul.gif" width="100px" ></p>						
                  </div>
              
                  </div><!-- /.card-pane-right -->
                </div><!-- /.d-md-flex -->
              </div>
              <!-- /.card-body -->
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

<script src="crypto-js.js"></script><!-- https://github.com/brix/crypto-js/releases crypto-js.js can be download from here -->

<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="toastr.min.js"></script>

<script src="licencefiplex_mm.js"></script>
<script src="licencefiplex1.js"></script>
<script src="js/jquery.inactivityTimeout.js"></script>
<script src="js/moment-timezone-with-data.js"></script>

<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- DataTables -->
<script src="<?php echo $folderservidor; ?>plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo $folderservidor; ?>plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>

<script type="text/javascript" src="js/tabulator.min.js"></script>

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
		//	console.log( "ready!" );
			$('#msjwaitline ').hide();
			$('#divscrolllog').show(); 
			$('#p-b0').hide();
			$('#p-b0').CardWidget('toggle');		
			$("#detallelog").hide();
			$("#detallelog").text("");
			$("#msjwait").hide();		


				$("#divgeneralinfo").addClass('d-none');
				$("#divgeneralinfoparam").addClass('d-none');
				$("#divdetinfolog").addClass('d-none');
				
				$("#diveq").addClass('d-none');
				$("#divfactory").addClass('d-none');
				$("#divfinalcheck").addClass('d-none');
				$("#divgroupbyciu").addClass('d-none');
				
					$("#divgeneralinfo").removeClass('d-none');
				$("#divgeneralinfoparam").removeClass('d-none');
				$("#divdetinfolog").removeClass('d-none');

				

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

				$('#closebusqueda').show();
				$('#openbusqueda').hide();
				
				$("#example1").DataTable({
							 "paging": true,
						  "lengthChange": false,
						  "searching": true,
						  "ordering": false,
						  "info": true,
						  "autoWidth": false,
						  "iDisplayLength": 12,
							language: {
								searchPlaceholder: "Search	",
								search: "",
							  },
							  "drawCallback": function( settings ) {
        var api = this.api();
 
        // Output the data for the visible rows to the browser's console
		//console.log('HOla Si' + $("[type=search]" ).val());
		
		if ($("[type=search]" ).val() !="" && $("[type=search]" ).val().length>8)
		{
			  //console.log( api.rows( {page:'current'} ).data() );
			$.each(api.rows( {page:'current'} ).data(), function(index, value){
			//console.log(index + " ----- " + value + '<br>');
				var str = ''+value;
				var res = str.split("###");
			//	console.log("Encontre"+ res[3]+"---"+res[4]);
				//$("#collapse"+ res[3]).collapse('toggle');
				show_ciu_search(res[3], res[4]);
				
				setTimeout(function(){
							if ($('#collapse'+res[3]).is(":hidden") == true)
							{
									$("#collapse"+ res[3]).collapse('toggle');
							}
				 //	console.log("Collapose IdSO:"+ res[3]);
				}, 1000);
				
			
			
			
			});
		}
      
    }
						}
				);				
				
			
	});
	

	// controlar inactividad en la web	
		$(document).inactivityTimeout({
                inactivityWait: 500,
                dialogWait: 100,
                logoutUrl: 'index.php?t=jquerytimeout'
            })
	// fin controlar inactividad en la web		
	
	 /* requesting data */
     		
		
	 	var table = $('#example2').DataTable();
 
	table.on( 'draw', function () { 
	//	console.log( 'Redraw occurred at: '+new Date().getTime() );
		$('.knob').knob({ 	})	
	} );
	
	$(function () {
  			$('.knob').knob({ 
			})

	})
  
	function habilitarbusqueda()
	{		
		$('#openbusqueda').hide();
		$('#closebusqueda').show();
		$("#example1").DataTable({
					 "destroy": true,
						 "paging": true,
					  "lengthChange": false,
					  "searching": true,						  
					  "ordering": false,
					  "info": true,
					  "autoWidth": false,
					  "iDisplayLength": 10
					}
			);
					
					
	}
   
	function dehabilitarbusqueda()
	{

			$('#closebusqueda').hide();
			$('#openbusqueda').show();
			$("#example1").DataTable({
						 "destroy": true,
							 "paging": true,
						  "lengthChange": false,
						  "searching": false,						  
						  "ordering": false,
						  "info": true,
						  "autoWidth": false,
						  "iDisplayLength": 10
						}
				);
		
				
				
	} 
	
	 function show_info_log(vciu,cciu_sn,vso,cuantomuestro)
  {
			$("#msjwait").fadeIn('slow');   
		   var myTable = $('#myTable');
		   $("#myTable").addClass('d-none');
		   $("#myTabledib").addClass('d-none');
		   
		   $("#myTabledibsn").addClass('d-none');
		   $("#myTabledibfw").addClass('d-none');
		   $("#myTabledib").addClass('d-none');
		   $("#myTabledibciu").addClass('d-none');
		   $("#myTablecaliffw").addClass('d-none');
		   $("#myTablecalifsn").addClass('d-none');
		   $("#myTablecalifciu").addClass('d-none');
		   $("#myTablecaliffreq").addClass('d-none');
		   
		   var nuevo_cuantoamost=0;
		   var msjlabel="";
				if( cuantomuestro ==1)
			    { 
					nuevo_cuantoamost=2;
					msjlabel="View all Rev";
				}
				else
				{
					nuevo_cuantoamost=1;
					msjlabel="See last Rev";
				}
		   //show_CIU_SN_details(idsaleorders, vciu, vciunomdiv,cciu_sn, name_show_customerSO,cuantoamuestro)
		   //show_info_log(vciu,cciu_sn,name_show_customerSO,cuantoamuestro)
		   myTable.html('<h6><a href="#" onclick="show_info_log('+"'"+vciu+"','"+cciu_sn+"','"+vso+"'"+','+nuevo_cuantoamost+')"><span class="badge badge-primary">'+msjlabel+'</span></a></h6><table id="myTable"  class="table table-bordered table-sm texto10 scrolltablemarco"><tr data-row="0" class="table-info" ><td data-row="0" data-col="0"></td></tr><tr data-row="1"><td data-row="1" data-col="0"><b>Approved:</b> </td></tr><tr data-row="2"><td data-row="2" data-col="0"><b>Power Supply:PO:</b> </td> </tr><tr data-row="3"><td data-row="3" data-col="0"><b>PO:</b></td></tr><tr data-row="4"><td data-row="4" data-col="0"><b>RC-G for BWA:</b> </td></tr><tr data-row="5"><td data-row="5" data-col="0"><b>Moden Digital:</b></td></tr><tr data-row="6"><td data-row="6" data-col="0"><b>Descripcion:</b> </td></tr><tr data-row="7"><td data-row="7" data-col="0"><b>Approved by:</b> </td></tr></table> ');
		   
		   var myTablesubband = $("#myTablesubband");
		   myTablesubband.html("<table id='myTablesubband' border='1' class='table table-bordered table-sm texto10 table-striped  scrolltablemarco'><tr data-rowsubband='0' class='table-info'><td data-rowsubband='0' data-colsubband='0'><B>SUB.BAND<B> </td></tr><tr data-rowsubband='1'><td data-rowsubband='1' data-colsubband='0'><b>Start:</b></td></tr><tr data-rowsubband='2'><td data-rowsubband='2' data-colsubband='0'><b>Center:</b></td></tr><tr data-rowsubband='3'><td data-rowsubband='3' data-colsubband='0'><b>Stop:</b></td></tr></table>");
		   
		   var myTablechanel = $("#myTablechanel");
		   myTablechanel.html("<table id='myTablechanel' border='1' class='table table-bordered table-sm texto10 scrolltablemarco'> <tr data-rowchanel='0' class='table-info'><td data-rowchanel='0' data-colchanel='0'><B>FREC. CH.<B></td></tr><tr data-rowchanel='1'><td data-rowchanel='1' data-colchanel='0'><b>FCh[0]:</b></td></tr><tr data-rowchanel='2'><td data-rowchanel='2' data-colchanel='0'><b>FCh[1]:</b></td></tr><tr data-rowchanel='3'><td data-rowchanel='3' data-colchanel='0'><b>FCh[2]:</b></td></tr><tr data-rowchanel='4'><td data-rowchanel='4' data-colchanel='0'><b>FCh[3]:</b></td></tr>							<tr data-rowchanel='5'><td data-rowchanel='5' data-colchanel='0'><b>FCh[4]:</b></td></tr>							<tr data-rowchanel='6'><td data-rowchanel='6' data-colchanel='0'><b>FCh[5]:</b></td></tr>							<tr data-rowchanel='7'><td data-rowchanel='7' data-colchanel='0'><b>FCh[6]:</b></td></tr>							<tr data-rowchanel='8'><td data-rowchanel='8' data-colchanel='0'><b>FCh[7]:</b></td></tr>							<tr data-rowchanel='9'><td data-rowchanel='9' data-colchanel='0'><b>FCh[8]:</b></td></tr>							<tr data-rowchanel='10'><td data-rowchanel='10' data-colchanel='0'><b>FCh[9]:</b></td></tr>	<tr data-rowchanel='11'><td data-rowchanel='11' data-colchanel='0'><b>FCh[11]:</b></td></tr><tr data-rowchanel='12'><td data-rowchanel='12' data-colchanel='0'><b>FCh[12]:</b></td></tr><tr data-rowchanel='13'><td data-rowchanel='13' data-colchanel='0'><b>FCh[13]:</b></td></tr>							<tr data-rowchanel='14'><td data-rowchanel='14' data-colchanel='0'><b>FCh[14]:</b></td></tr><tr data-rowchanel='15'><td data-rowchanel='15' data-colchanel='0'><b>FCh[15]:</b></td></tr><tr data-rowchanel='16'><td data-rowchanel='16' data-colchanel='0'><b>FCh[16]:</b></td></tr><tr data-rowchanel='17'><td data-rowchanel='17' data-colchanel='0'><b>FCh[17]:</b></td></tr> 							<tr data-rowchanel='18'><td data-rowchanel='18' data-colchanel='0'><b>FCh[18]:</b></td></tr><tr data-rowchanel='19'><td data-rowchanel='19' data-colchanel='0'><b>FCh[19]:</b></td></tr><tr data-rowchanel='20'><td data-rowchanel='20' data-colchanel='0'><b>FCh[20]:</b></td></tr><tr data-rowchanel='21'><td data-rowchanel='21' data-colchanel='0'><b>FCh[21]:</b></td></tr><tr data-rowchanel='22'><td data-rowchanel='22' data-colchanel='0'><b>FCh[22]:</b></td></tr><tr data-rowchanel='23'><td data-rowchanel='23' data-colchanel='0'><b>FCh[23]:</b></td></tr><tr data-rowchanel='24'><td data-rowchanel='24' data-colchanel='0'><b>FCh[24]:</b></td></tr><tr data-rowchanel='25'><td data-rowchanel='25' data-colchanel='0'><b>FCh[25]:</b></td></tr>							<tr data-rowchanel='26'><td data-rowchanel='26' data-colchanel='0'><b>FCh[26]:</b></td></tr><tr data-rowchanel='27'><td data-rowchanel='27' data-colchanel='0'><b>FCh[27]:</b></td></tr><tr data-rowchanel='28'><td data-rowchanel='28' data-colchanel='0'><b>FCh[28]:</b></td></tr><tr data-rowchanel='29'><td data-rowchanel='29' data-colchanel='0'><b>FCh[29]:</b></td></tr><tr data-rowchanel='30'><td data-rowchanel='30' data-colchanel='0'><b>FCh[30]:</b></td></tr>");
		   var myTableul = $('#myTableul');
		   myTableul.html('<h6><a href="#" onclick="show_info_log('+"'"+vciu+"','"+cciu_sn+"','"+vso+"'"+','+nuevo_cuantoamost+')"><span class="badge badge-primary">'+msjlabel+'</span></a></h6>'+"<table id='myTableul' border='1' class='table table-bordered table-sm texto10 scrolltablemarco'><tr data-rowul='0'  class='table-info' ><td data-rowul='0' data-colul='0'><B>PARAMETERS<B></td></tr><tr data-rowul='1'><td data-rowul='1' data-colul='0'><b>Gain:</b></td></tr><tr data-rowul='2'><td data-rowul='2' data-colul='0'><b>Max Pwr:</b></td></tr><tr data-rowul='3'><td data-rowul='3' data-colul='0'><b>Freq Start:</b></td></tr><tr data-rowul='4'><td data-rowul='4' data-colul='0'><b>Freq Stop:</b> </td></tr></table>");
			$.ajax
			({ 
				url: 'ajax_show_info_sn.php',
				data: "idciu="+vciu+'&ciusn='+cciu_sn+"&cuantomuestro="+cuantomuestro,	
				type: 'post',	
				async:true,
                cache:false,				
				datatype:'JSON',
				success: function(data)
				{
					//detallelog
				///	console.log('TT:'+data.gi);
					
						$.each(data.gi, function(i, item) {
						//	console.log('muestro:'+item);
							AddNewCol(1,item);
						});
						/// Los chanes
						var loschannel = 0;
						var arramch = [];		
						$.each(data.ch, function(ich, itemch) {			
								
								var arramch = [];							
								arramch.push( json2array(itemch));
							
									//console.log('d1:'+arramch[0][1]+'-d0:'+arramch[0][0]+'-d2:'+arramch[0][2]+'-d3:'+arramch[0][3]+'-d4:'+arramch[0][4]);
								AddNewColchanel(1,itemch,'chanel');
								//AddNewRowchanel	 (1,itemch,'chanel');								
														
						});
						$.each(data.uldl, function(iud, itemud) {
						//	console.log('muestro:'+item);
							AddNewColdl(1,itemud,'ul');
						});
						$.each(data.uldlsubband, function(isubband, itemsubband) {
						//	console.log('muestro:'+item);
							AddNewColdl(1,itemsubband,'subband');
						});
						var losbuttons="";
						$.each(data.lg, function(ilg, itemlg) {
							//console.log('Log:'+itemlg);
							var arram = [];
							
							arram.push( json2array(itemlg));
						//	console.log('array:'+arram[0][1]+'-band'+arram[0][0]+'-runinfoid'+arram[0][2]);
							if (arram[0][0]==0)
							{
								losbuttons = losbuttons + '<a href="#"  onclick="show_log('+arram[0][2]+')"><span class="badge badge-primary" ><i class="fas fa-search"></i> Rev '+arram[0][1]+'</span></a> - ';
							}
							else
							{
								losbuttons = losbuttons + '<span class="badge badge-primary" onclick="show_log('+arram[0][2]+')"><i class="fas fa-search"></i> Band:'+arram[0][0]+' - Rev '+arram[0][1]+'</span> - ';	
							}
							
						});
						
						losbuttons = losbuttons + '<textarea class="form-control" rows="18" id="detallelog" name="detallelog"></textarea>';
						$('#infolog').html(losbuttons); 
					$("#msjwait").hide();	
					$("#myTable").removeClass('d-none');
					$("#myTablechanel").removeClass('d-none');
					$("#myTableul").removeClass('d-none');
					$("#myTablesubband").removeClass('d-none');
					$("#infolog").removeClass('d-none');
					
					$("#msjwait").hide();	
					$("#myTable").removeClass('d-none');
					$("#myTablechanel").removeClass('d-none');
					$("#myTableul").removeClass('d-none');
					$("#myTablesubband").removeClass('d-none');
					
														
					
					$("#myTabledibfw").addClass('d-none');
					$("#myTabledibciu").addClass('d-none');
					$("#myTablecaliffw").addClass('d-none');
					
					$("#myTablecalifsn").addClass('d-none');
					$("#myTablecalifciu").addClass('d-none');
					$("#myTablecaliffreq").addClass('d-none');
					
					
					//mostramos datos del SN y CIU selecionado.
				    $('#ciusnshow').html(' &nbsp; '+vso+' <i class="fas fa-minus"></i> '+vciu +' <i class="fas fa-minus"></i> '+ cciu_sn); 
					$('#ciusnshowbks').html(' &nbsp; '+vso+' <i class="fas fa-minus"></i> '+vciu +' <i class="fas fa-minus"></i> '+ cciu_sn); 
					

					
							
				}
			});
  }
  
   
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
   
    function show_ciu(idsaleorders, nameSO_Customers)
   {
		//alert('hi' + $('#collapse'+idsaleorders).is(":hidden"));
		if ($('#collapse'+idsaleorders).is(":hidden") == true)
		{
		
			$('#collapse'+idsaleorders).html("<p name='msjwaitparticular' id='msjwaitparticular' align='center'><img src='img/waitazul.gif' width='100px' ></p>");
			//	console.log(idsaleorders);
				toastr.options = {
				  "closeButton": false,
				  "debug": false,
				  "newestOnTop": false,
				  "progressBar": true,
				  "positionClass": "toast-bottom-right",
				  "preventDuplicates": false,
				  "onclick": null,
				  "showDuration": "600",
				  "hideDuration": "600",
				  "timeOut": "600",
				  "extendedTimeOut": "600",
				  "showEasing": "swing",
				  "hideEasing": "linear",
				  "showMethod": "fadeIn",
				  "hideMethod": "fadeOut"
				};	
				toastr["success"]("Wait....Search Results", "Attention :: Sales Orders ");
				$.ajax
				({ 
					url: 'ajax_show_CIU.php',
					data: "idsaleorders="+idsaleorders,	
					type: 'post',				
					datatype:'JSON',
				
					success: function(data)
					{
						 $("#msjwait").hide();	
						// console.log("devolvio"+ idsaleorders+ data);
						  var eTable="<div class='card-headermarco'>";					
						  for(var i=0; i<data.length;i++)
						  {
							
						
							
							eTable += "<a data-toggle='collapse' data-parent='#accordion' onclick="+"show_CIU_SN("+idsaleorders+",'"+data[i].ciu+"','"+idsaleorders+data[i].ciu_sincara+"','"+nameSO_Customers.trim()+"') href='#collapse"+idsaleorders+data[i].ciu_sincara+"' aria-expanded='true'><img src='img/imgciu.jpg' width='40px' > "+data[i].ciu+"&nbsp;<span data-toggle='tooltip' class='badge bg-warning mb-2 labelsom'> &nbsp;[ &nbsp;"+data[i].cant_sn+" SN &nbsp;] &nbsp; </span></a>&nbsp;<a href='#' ><i class='nav-icon fas fa-chart-line'> </i>	</a> <br><div id='collapse"+idsaleorders+data[i].ciu_sincara+"' name id='collapse"+idsaleorders+data[i].ciu_sincara+"' class='panel-collapse in collapse'> ... </div>";
							
																			
						  }
						  eTable +="</div>";
						  $('#collapse'+idsaleorders).html(eTable);
					}
					/* error: function (xhr, ajaxOptions, thrownError) {
						console.log(xhr.status);
						console.log(thrownError);
						$('#collapse'+idsaleorders).html("<p name='msjwaitparticular' id='msjwaitparticular' align='center'>Error by Ajax Conector</p>");
					  }*/
				});
			}	
   }
   
   function show_ciu_search(idsaleorders, nameSO_Customers)
   {
	   
				/*$("#divgeneralinfo").addClass('d-none');
				$("#divgeneralinfoparam").addClass('d-none');
				$("#divdetinfolog").addClass('d-none');
				
				$("#diveq").addClass('d-none');
				$("#divfactory").addClass('d-none');
				$("#divfinalcheck").addClass('d-none');
				$("#divgroupbyciu").addClass('d-none');
				
					$("#divgeneralinfo").removeClass('active');
				$("#divgeneralinfoparam").removeClass('active');
				$("#divdetinfolog").removeClass('active');
				$("#generalinfoul").removeClass('active'); */
				
				
		//alert('hi' + $('#collapse'+idsaleorders).is(":hidden"));
	//	if ($('#collapse'+idsaleorders).is(":hidden") == true)
	//	{
		
			$('#collapse'+idsaleorders).html("<p name='msjwaitparticular' id='msjwaitparticular' align='center'><img src='img/waitazul.gif' width='100px' ></p>");
			//	console.log(idsaleorders);
			/*	toastr.options = {
				  "closeButton": false,
				  "debug": false,
				  "newestOnTop": false,
				  "progressBar": true,
				  "positionClass": "toast-bottom-right",
				  "preventDuplicates": false,
				  "onclick": null,
				  "showDuration": "600",
				  "hideDuration": "600",
				  "timeOut": "600",
				  "extendedTimeOut": "600",
				  "showEasing": "swing",
				  "hideEasing": "linear",
				  "showMethod": "fadeIn",
				  "hideMethod": "fadeOut"
				};	
				toastr["success"]("Wait....Search Results", "Attention :: Sales Orders ");*/
				$.ajax
				({ 
					url: 'ajax_show_CIU.php',
					data: "idsaleorders="+idsaleorders,	
					type: 'post',				
					datatype:'JSON',				
                   cache:false,
					success: function(data)
					{
						 $("#msjwait").hide();	
						 	// console.log("devolvio"+ idsaleorders+ data);
						  var eTable="<div class='card-headermarco'>";					
						  for(var i=0; i<data.length;i++)
						  {
							
							if ($("[type=search]" ).val() !="")
								{
									///estamos en busqueda..
									//console.log(  data[i].arraysn );
									var testStr = data[i].arraysn;
									var testStr1 = data[i].ciu;
									
								//	console.log( "VAMos x SN  testStr:" + testStr );
									var textoabuscar= $("[type=search]" ).val().toUpperCase().trim();
									if(testStr.includes(textoabuscar) || testStr1.includes(textoabuscar) ){
								////	console.log( "testStr encontrado:" + testStr );
									eTable += "<a data-toggle='collapse' data-parent='#accordion' onclick="+"show_CIU_SN_search("+idsaleorders+",'"+data[i].ciu+"','"+idsaleorders+data[i].ciu_sincara+"','"+nameSO_Customers.trim()+"') href='#collapse"+idsaleorders+data[i].ciu_sincara+"' aria-expanded='true'><img src='img/imgciu.jpg' width='40px' > "+data[i].ciu+"&nbsp;<span data-toggle='tooltip' class='badge bg-warning mb-2 labelsom'> &nbsp;[ &nbsp;"+data[i].cant_sn+" SN &nbsp;] &nbsp; </span></a>&nbsp;<a href='#' ><i class='nav-icon fas fa-chart-line'> </i>	</a> <br><div id='collapse"+idsaleorders+data[i].ciu_sincara+"' name id='collapse"+idsaleorders+data[i].ciu_sincara+"' class='panel-collapse in collapse'> ... </div>";	
																		
										show_CIU_SN_search(idsaleorders,data[i].ciu, idsaleorders+data[i].ciu_sincara,nameSO_Customers.trim());
										var collapse_snaabrir= idsaleorders+data[i].ciu_sincara;
										setTimeout(function(){
											if ($('#collapse'+collapse_snaabrir	).is(":hidden") == true)
											{
												$("#collapse"+ collapse_snaabrir).collapse('toggle');
											}
									//		console.log("Collapose IdSO Nro:"+ collapse_snaabrir);
										}, 1500);
				
									
									}
									
								}
							else
							{
							eTable += "<a data-toggle='collapse' data-parent='#accordion' onclick="+"show_CIU_SN_search("+idsaleorders+",'"+data[i].ciu+"','"+idsaleorders+data[i].ciu_sincara+"','"+nameSO_Customers.trim()+"') href='#collapse"+idsaleorders+data[i].ciu_sincara+"' aria-expanded='true'><img src='img/imgciu.jpg' width='40px' > "+data[i].ciu+"&nbsp;<span data-toggle='tooltip' class='badge bg-warning mb-2 labelsom'> &nbsp;[ &nbsp;"+data[i].cant_sn+" SN &nbsp;] &nbsp; </span></a>&nbsp;<a href='#' ><i class='nav-icon fas fa-chart-line'> </i>	</a> <br><div id='collapse"+idsaleorders+data[i].ciu_sincara+"' name id='collapse"+idsaleorders+data[i].ciu_sincara+"' class='panel-collapse in collapse'> ... </div>";	
							}
							//eTable += "<a data-toggle='collapse' data-parent='#accordion' href='#collapse"+idsaleorders+data[i].ciu_sincara+"' aria-expanded='true'><img src='img/imgciu.jpg' width='40px' > "+data[i].ciu+"<span data-toggle='tooltip' class='badge bg-warning mb-2 labelsom'> &nbsp;[ &nbsp;"+data[i].cant_sn+" SN &nbsp;] &nbsp; </span></a><a href='#' onclick='show_CIU_SN("+idsaleorders+","+data[i].ciu+","+idsaleorders+data[i].ciu_sincara+"')'><i class='nav-icon fas fa-chart-line'> </i>	</a> <br><div id='collapse"+idsaleorders+data[i].ciu_sincara+"' class='panel-collapse in collapse'> </div>";
							
							
																			
						  }
						  eTable +="</div>";
						  $('#collapse'+idsaleorders).html(eTable);
						 // console.log("agrego table"+ eTable);
					}
					/* error: function (xhr, ajaxOptions, thrownError) {
						console.log(xhr.status);
						console.log(thrownError);
						$('#collapse'+idsaleorders).html("<p name='msjwaitparticular' id='msjwaitparticular' align='center'>Error by Ajax Conector</p>");
					  }*/
				});
		//	}	
   }
   
   function show_CIU_SN_details(idsaleorders, vciu, vciunomdiv,cciu_sn, name_show_customerSO,cuantoamuestro)
   {
	  // console.log(idsaleorders+vciu+vciunomdiv+cciu_sn);
	   //if ($('#collapse'+vciunomdiv).is(":hidden") == true)
		//{
			//mostramos los datos del SN band
		//console.log("es aca");
		$("#divgeneralinfoparam").removeClass('d-none');
		$("#generalinfo").removeClass('d-none');
		
		$("generalinfoul").addClass('d-none');
		$("generalinfo").addClass('d-none');
		$("infolog").addClass('d-none');
		$("generalinfoul").removeClass('active');
		$("generalinfo").removeClass('active');
		$("infolog").removeClass('active');
		
		
		$("#generalinfo").addClass('active');
		
			show_info_log(vciu,cciu_sn,name_show_customerSO,cuantoamuestro)
	//	}	
   }
   
  function show_CIU_SN(idsaleorders, vciu, vciunomdiv,name_show_customerSO,cuantasrev)
   {
	   var ifdualband="";
	   if ($('#collapse'+vciunomdiv).is(":hidden") == true)
		{

 
		//	console.log(idsaleorders);
			toastr.options = {
			  "closeButton": false,
			  "debug": false,
			  "newestOnTop": false,
			  "progressBar": true,
			  "positionClass": "toast-bottom-right",
			  "preventDuplicates": false,
			  "onclick": null,
			  "showDuration": "600",
			  "hideDuration": "600",
			  "timeOut": "600",
			  "extendedTimeOut": "600",
			  "showEasing": "swing",
			  "hideEasing": "linear",
			  "showMethod": "fadeIn",
			  "hideMethod": "fadeOut"
			};	
			toastr["success"]("Wait....Search Results", "Attention :: State of Sale Orders ");
	   
			$.ajax
			({ 
				url: 'ajax_show_CIU_SN.php',
				data: "idsaleorders="+idsaleorders+"&vciu="+vciu+"&qs="+cuantasrev,	
				type: 'post',				
				datatype:'JSON',
				success: function(data)
				{
				//	alert(data);
					
					//detallelog
					 $("#msjwait").hide();				 
					
					  var eTable="<div class='container'><table class='table  table-bordered table-striped table-sm'><tbody>";
					  var det_modules="";
					  var detband = "0";
					
					  for(var i=0; i<data.length;i++)
					  {
						
						
						//<span data-toggle='tooltip'  class='float-right'> &nbsp; <span data-toggle='tooltip' title='1 Calibration' class='badge bg-warning'>Dig. Mod</span>&nbsp;
						//<span data-toggle='tooltip' title='3 Calibration' class='badge bg-primary'>Calib [3]</span>&nbsp;
						//<span data-toggle='tooltip' title='3 Calibration' class='badge bg-success'>Acept [1] </span>
						//<span data-toggle='tooltip' title='3 Calibration' class='badge bg-danger'>Final Chk</span></span> <div id='collapse"+idsaleorders+vciu+data[i].sn+"' name id='collapse"+idsaleorders+vciu+data[i].sn+"' class='panel-collapse in collapse'> ... </div>
						if (data[i].ifdualband ==1)
						{
							ifdualband="";
						
						}
						else
						{
							if (data[i].idband==1)
							{
								ifdualband = "&nbsp;<i class='fas fa-grip-lines-vertical'></i> Band: 700 " ;
								var detband = "700";
							}
							if (data[i].idband==2)							
							{
								var detband = "800";
							ifdualband = "&nbsp;<i class='fas fa-grip-lines-vertical'></i> Band: 800 " ;	
							}
							
						
						}
						eTable += "<tr >";
						eTable += "<td> <a data-toggle='collapse' data-parent='#accordion' onclick="+"show_CIU_SN_details("+idsaleorders+",'"+vciu+"','"+idsaleorders+vciu+data[i].sn+data[i].idband+"','"+data[i].sn+"','"+name_show_customerSO+"',1) href='#collapse"+idsaleorders+vciu+data[i].sn+data[i].idband+"' aria-expanded='true'><i class='nav-icon fas fa-th'></i> "+data[i].sn+ifdualband+"</a> ";	
						if (data[i].sn_modulo !="")
						{
							det_modules+= '<i  class="fas fa-sliders-h"></i> Digital Module '+data[i].sn_modulo+' [Band '+detband+'] <a href="#" onclick="mostrar_digmod('+"'"+data[i].sn_modulo.trim()+"','"+data[i].sn+"'"+')"> <i class="fas fa-eye"></i></a><br>';
							eTable +="<span data-toggle='tooltip'  class='float-right'> &nbsp; <span data-toggle='tooltip' class='badge badge-pill bg-warning'>Dig. Mod ["+data[i].countdigm+"]&nbsp;"
							
							if (data[i].totalpassdig == "true") 
							{
								eTable+= " <i class='fas fa-check'></i></span>" ; 
							} 
							else
							{
								eTable+= "</span>";
							}
							
							if (data[i].sn_modulocalif !="")
							{
								det_modules+= '<i class="fas fa-tools"></i> Calibration '+data[i].sn_modulocalif+' [Band '+detband+'] <a href="#"  onclick="mostrar_digmodcalib('+"'"+data[i].sn_modulo.trim()+"','"+data[i].sn+"'"+')"> &nbsp;<i class="fas fa-eye"></i>&nbsp;</a><br>';
								eTable +="&nbsp;&nbsp;<span data-toggle='tooltip' class='badge bg-primary'>Calib ["+data[i].countdigmcalif+"]&nbsp;"	
								if (data[i].totalpassdigcalif == "true") 
								{
									eTable+= " <i class='fas fa-check'></i></span>"; 
								} 
								else
								{
									eTable+= "</span>";
								}
								
								
							}
							if (data[i].sn_modulocaliffnchk !="")
							{
								
								det_modules+= "<i class='far fa-check-square'></i> Final Check "+data[i].sn_modulocaliffnchk+" [Band "+detband+"] <a href='#'>&nbsp;<i class='fas fa-eye'></i>&nbsp;</a><br>";
								eTable +="&nbsp;&nbsp;<span data-toggle='tooltip' title='3 ' class='badge bg-danger'>Final Chk ["+data[i].countdigmcaliffnchk+"]&nbsp;"	
								if (data[i].totalpassdigcaliffnchk == "true") 
								{
									eTable+= " <i class='fas fa-check'></i></span>"; 
								} 
								else
								{
									eTable+= "</span>";
								}
								
								
							}
																							
						}
						else
						{
							eTable +="<span data-toggle='tooltip'  class='float-right'> &nbsp; <span data-toggle='tooltip' class='badge  badge-pill badge-secondary'>Dig. Mod []&nbsp;</span>"
						}
						
						
						
						
						
						
						eTable += " </span><div id='collapse"+idsaleorders+vciu+data[i].sn+data[i].idband+"' name='collapse"+idsaleorders+vciu+data[i].sn+data[i].idband+"' class='panel-collapse in collapse container ' style='background-color:#E1F5FE'> "+det_modules+" </div>";	
						eTable += "</tr>";
						 det_modules="";
					  }
					  eTable +="</tbody></table></div>";
					 
					//  console.log ('collapse'+vciunomdiv);
					  $('#collapse'+vciunomdiv).html(eTable);
					 
					
				}
			});
		}
   }
   
    function show_CIU_SN_search(idsaleorders, vciu, vciunomdiv,name_show_customerSO,cuantasrev)
   {
	   var ifdualband="";
	  // if ($('#collapse'+vciunomdiv).is(":hidden") == true)
		//{

 
		//	console.log(idsaleorders);
		/*	toastr.options = {
			  "closeButton": false,
			  "debug": false,
			  "newestOnTop": false,
			  "progressBar": true,
			  "positionClass": "toast-bottom-right",
			  "preventDuplicates": false,
			  "onclick": null,
			  "showDuration": "600",
			  "hideDuration": "600",
			  "timeOut": "600",
			  "extendedTimeOut": "600",
			  "showEasing": "swing",
			  "hideEasing": "linear",
			  "showMethod": "fadeIn",
			  "hideMethod": "fadeOut"
			};	
			toastr["success"]("Wait....Search Results", "Attention :: State of Sale Orders ");*/
	   
			$.ajax
			({ 
				url: 'ajax_show_CIU_SN.php',
				data: "idsaleorders="+idsaleorders+"&vciu="+vciu+"&qs="+cuantasrev,	
				type: 'post',				
				datatype:'JSON',
				success: function(data)
				{
				//	alert(data);
					
					//detallelog
					 $("#msjwait").hide();				 
					
					  var eTable="<div class='container'><table class='table  table-bordered table-striped table-sm'><tbody>";
					  var det_modules="";
					  var detband = "0";
					
					  for(var i=0; i<data.length;i++)
					  {
						
						
						//<span data-toggle='tooltip'  class='float-right'> &nbsp; <span data-toggle='tooltip' title='1 Calibration' class='badge bg-warning'>Dig. Mod</span>&nbsp;
						//<span data-toggle='tooltip' title='3 Calibration' class='badge bg-primary'>Calib [3]</span>&nbsp;
						//<span data-toggle='tooltip' title='3 Calibration' class='badge bg-success'>Acept [1] </span>
						//<span data-toggle='tooltip' title='3 Calibration' class='badge bg-danger'>Final Chk</span></span> <div id='collapse"+idsaleorders+vciu+data[i].sn+"' name id='collapse"+idsaleorders+vciu+data[i].sn+"' class='panel-collapse in collapse'> ... </div>
						if (data[i].ifdualband ==1)
						{
							ifdualband="";
						
						}
						else
						{
							if (data[i].idband==1)
							{
								ifdualband = "&nbsp;<i class='fas fa-grip-lines-vertical'></i> Band: 700 " ;
								var detband = "700";
							}
							if (data[i].idband==2)							
							{
								var detband = "800";
							ifdualband = "&nbsp;<i class='fas fa-grip-lines-vertical'></i> Band: 800 " ;	
							}
							
						
						}
						var mostrarelsn="N";
						if ($("[type=search]" ).val() !="")
								{
									// buscamos x el dato ingresado.
									var testStr = data[i].sn;
									var testStr1 = vciu;
									
									//console.log( "testStr:" + testStr );
									var textoabuscar= $("[type=search]").val().toUpperCase().trim() ;
									if(testStr.includes(textoabuscar) || testStr1.includes(textoabuscar)){
										mostrarelsn="S";
									}
								}
						eTable += "<tr >";
						if (mostrarelsn=="S")
						{
						eTable += "<td> <a data-toggle='collapse' data-parent='#accordion' onclick="+"show_CIU_SN_details("+idsaleorders+",'"+vciu+"','"+idsaleorders+vciu+data[i].sn+data[i].idband+"','"+data[i].sn+"','"+name_show_customerSO+"',1) href='#collapse"+idsaleorders+vciu+data[i].sn+data[i].idband+"' aria-expanded='true'><i class='nav-icon fas fa-th'></i> "+data[i].sn+ifdualband+"</a> ";	
						
						if (data[i].sn_modulo !="")
						{
							//det_modules+= "<i  class='fas fa-sliders-h'></i> Digital Module "+data[i].sn_modulo+" [Band "+detband+"] <a href='#'>&nbsp;<i class='fas fa-eye'></i>&nbsp;</a><br>";
							det_modules+= '<i  class="fas fa-sliders-h"></i> Digital Module '+data[i].sn_modulo+' [Band '+detband+'] <a href="#" onclick="mostrar_digmod('+"'"+data[i].sn_modulo.trim()+"','"+data[i].sn+"'"+')"> <i class="fas fa-eye"></i></a><br>';
							
								eTable +="<span data-toggle='tooltip'  class='float-right'> &nbsp; <span data-toggle='tooltip' class='badge badge-pill bg-warning'>Dig. Mod ["+data[i].countdigm+"]&nbsp;"
								
								
								if (data[i].totalpassdig == "true") 
								{
									eTable+= " <i class='fas fa-check'></i></span>" ; 
								} 
								else
								{
									eTable+= "</span>";
								}
							
							
							if (data[i].sn_modulocalif !="")
							{
								det_modules+= '<i class="fas fa-tools"></i> Calibration '+data[i].sn_modulocalif+' [Band '+detband+'] <a href="#"  onclick="mostrar_digmodcalib('+"'"+data[i].sn_modulo.trim()+"','"+data[i].sn+"'"+')"> &nbsp;<i class="fas fa-eye"></i>&nbsp;</a><br>';	
								
								eTable +="&nbsp;&nbsp;<span data-toggle='tooltip' class='badge bg-primary'>Calib ["+data[i].countdigmcalif+"]&nbsp;"	
								if (data[i].totalpassdigcalif == "true") 
								{
									eTable+= " <i class='fas fa-check'></i></span>"; 
								} 
								else
								{
									eTable+= "</span>";
								}
								
								
							}
							if (data[i].sn_modulocaliffnchk !="")
							{
								det_modules+= "<i class='far fa-check-square'></i> Final Check "+data[i].sn_modulocaliffnchk+" [Band "+detband+"] <a href='#'>&nbsp;<i class='fas fa-eye'></i>&nbsp;</a><br>";
								eTable +="&nbsp;&nbsp;<span data-toggle='tooltip' title='3 Calibration' class='badge bg-danger'>Final Chk ["+data[i].countdigmcaliffnchk+"]&nbsp;"	
								if (data[i].totalpassdigcaliffnchk == "true") 
								{
									eTable+= " <i class='fas fa-check'></i></span>"; 
								} 
								else
								{
									eTable+= "</span>";
								}
								
								
							}
																							
						}
						else
						{
							eTable +="<span data-toggle='tooltip'  class='float-right'> &nbsp; <span data-toggle='tooltip' class='badge  badge-pill badge-secondary'>Dig. Mod []&nbsp;</span>"
						}
						//fin if mostrar
						}
						
						
						
						
						
						eTable += " </span><div id='collapse"+idsaleorders+vciu+data[i].sn+data[i].idband+"' name='collapse"+idsaleorders+vciu+data[i].sn+data[i].idband+"' class='panel-collapse in collapse container ' style='background-color:#E1F5FE'> "+det_modules+" </div>";	
						eTable += "</tr>";
						 det_modules="";
					  }
					  eTable +="</tbody></table></div>";
					 
					//  console.log ('collapse'+vciunomdiv);
					  $('#collapse'+vciunomdiv).html(eTable);
					 
					
				}
			});
		//}
   }



function json2array(json){
    var result = [];
    var keys = Object.keys(json);
    keys.forEach(function(key){
        result.push(json[key]);
    });
    return result;
}
/////auto add column
		function AddNewCol(colNum, datos)
        {
            var myTable = $('#myTable');
            var colCount = myTable.find('td[data-row=0]').length;
            var rowCount = $("#myTable tr").length;
 
            //incriment id numbers to make room for the new column
            myTable_IncrimentColIdNumber(colNum, 1);
			
			var arram = [];
			 arram.push( json2array(datos));
			//console.log ("arraycolumno"+arram[0][2]);
			
            //add new column by adding a new cell to each row
            for (row = 0; row < rowCount; row++) {
                //add a new cell after the cell for the previous column
				//console.log ("arraycolumno"+arram[0][row]);
                $('td[data-row=' + row + '][data-col=' + (parseInt(colNum)-1) + ']').after('<td data-row="'+ row +'" data-col="' +colNum+ '"> '+arram[0][row]+'</td>');
            }
        }
		
		function myTable_DelRow(row) {
				$('tr[data-row=' + row + ']').remove();
			 
				myTable_IncrimentRowIdNumber(row, -1);
			}
			
			function myTable_DelRowchanel(row) {
				$('tr[data-rowchanel=' + row + ']').remove();
			 
				myTable_IncrimentRowIdNumber(row, -1);
			}
			
			
 
		function myTable_DelCol(col) {
			$('td[data-col=' + parseInt(col) + ']').remove();
			myTable_IncrimentColIdNumber(col, -1);
		}
		
		function myTable_DelColchanel(col) {
			$('td[data-colchanel=' + parseInt(col) + ']').remove();
			myTable_IncrimentColIdNumber(col, -1);
		}
 
		function myTable_IncrimentColIdNumber(startPosition, increment) {
 
            //increment column id's
            var cells = $('myTable td[data-col]');
 
            //foreach cell
            for (i = 0; i < cells.length ; i++) {
 
                var colNum = parseInt(cells.eq(i).attr('data-col'));
 
                //for every column beyond the insertion point, increment the column number
                if (colNum >= startPosition) {
                    var newId = colNum + parseInt(increment);
                    cells.eq(i).attr('data-col', newId);
                }
            }
        }
		
		function myTable_IncrimentRowIdNumber(startPosition, increment) {
            //get all the items with the data-row attr. - this will include tr and td
            var items = $('[data-row]');
 
            //for each item with a data-row attr. increment the value
            for (i = 0; i < items.length; i++) {
                //get the current value
                var rowNum = parseInt(items.eq(i).attr('data-row'));
 
                //only update the rows that are after the new inserted row
                if (rowNum >= startPosition) {
                    //generate the new value and update the item
                    var newId = rowNum + parseInt(increment);
                    items.eq(i).attr('data-row', newId);
                }
            }
        }
		
		function AddNewRow(row) {
            //using jquery, grab a reference to the html table
            var myTable = $('#myTable');
            //get the number of rows and columns
            var colCount = myTable.find('generalinfo, td[data-row=0]').length;
            var rowCount = $("#myTable tr").length;
 
            //incriment position numbers to make room for the new row
            //this is required to keep things working after we change the table
            myTable_IncrimentRowIdNumber(row, 1);
 
            //add row
            var newRow = '<tr data-row="' + row + '">';
            //add cells into the row
            for (addCol = 0; addCol < colCount; addCol++) {
                newRow += '<td data-row="'+ row +'" data-col="' +addCol+ '"> </td>';
            }
            //close the row
            newRow += '</tr>';
            //add the new row after the previous row in the table - the magic of jquery :)
            $(newRow).insertAfter('generalinfo, tr[data-row=' + (parseInt(row) - 1) + ']');
        }
		
			function AddNewRowchanel(row,datos,addnomtablemodif) {
            //using jquery, grab a reference to the html table
            var myTable = $('#myTablechanel');
            //get the number of rows and columns
            var colCount = myTable.find('td[data-rowchanel=0]').length;
            var rowCount = $("#myTablechanel tr").length;
 
            //incriment position numbers to make room for the new row
            //this is required to keep things working after we change the table
            myTable_IncrimentRowIdNumber(row, 1);
			//console.log("nuevo row CHANEL");
			var arramch = [];
			 arramch.push( json2array(datos));
            //add row
            var newRow = '<tr data-rowchanel="' + row + '">';
            //add cells into the row
            for (addCol = 0; addCol < colCount; addCol++) {
                newRow += '<td data-rowchanel="'+ row +'" data-colchanel="' +addCol+ '">'+arramch[0][row]+' </td>';
            }
            //close the row
            newRow += '</tr>';
            //add the new row after the previous row in the table - the magic of jquery :)
            $(newRow).insertAfter('tr[data-rowchanel=' + (parseInt(row) - 1) + ']');
        }
		
		
		///funciones para DL
		/////auto add column
function AddNewColdl(colNum, datos,addnomtablemodif)
        {
            var myTable = $('#myTable'+addnomtablemodif);
            var colCount = myTable.find('td[data-row'+addnomtablemodif+'=0]').length;
            var rowCount = $("#myTable"+addnomtablemodif+" tr").length;
 
            //incriment id numbers to make room for the new column
            myTable_IncrimentColIdNumberdl(colNum, 1,addnomtablemodif);
			
			var arram = [];
			 arram.push( json2array(datos));
			///console.log ('aaaa:'+arram[0][2]);
			
            //add new column by adding a new cell to each row
            for (row = 0; row < rowCount; row++) {
                //add a new cell after the cell for the previous column
				if (row==0)
				{
				$('td[data-row'+addnomtablemodif+'=' + row + '][data-col'+addnomtablemodif+'=' + (parseInt(colNum)-1) + ']').after('<td data-row'+addnomtablemodif+'="'+ row +'" data-col'+addnomtablemodif+'="' +colNum+ '" class="table-info"> '+arram[0][row]+'</td>');	
				}
				else
				{
				$('td[data-row'+addnomtablemodif+'=' + row + '][data-col'+addnomtablemodif+'=' + (parseInt(colNum)-1) + ']').after('<td data-row'+addnomtablemodif+'="'+ row +'" data-col'+addnomtablemodif+'="' +colNum+ '" > '+arram[0][row]+'</td>');	
				}
                
            }
        }
		
		function AddNewColchanel(colNum, datos,addnomtablemodif)
        {
            var myTable = $('#myTable'+addnomtablemodif);
            var colCount = myTable.find('td[data-row'+addnomtablemodif+'=0]').length;
            var rowCount = $("#myTable"+addnomtablemodif+" tr").length;
 
            //incriment id numbers to make room for the new column
            myTable_IncrimentColIdNumberdl(colNum, 1,addnomtablemodif);
			
			var arram = [];
			var cantvacios=0;
			 arram.push( json2array(datos));
			//console.log ('new ro chanel:'+arram[0][2]+'-ch'+arram[0][1]);
			
            //add new column by adding a new cell to each row
            for (row = 0; row < rowCount; row++) {
                //add a new cell after the cell for the previous column
				//console.log('DAto a mostrar:'+arram[0][row]);
				if (arram[0][row]!= '')
				{
                $('td[data-row'+addnomtablemodif+'=' + row + '][data-col'+addnomtablemodif+'=' + (parseInt(colNum)-1) + ']').after('<td data-row'+addnomtablemodif+'="'+ row +'" data-col'+addnomtablemodif+'="' +colNum+ '"> '+arram[0][row]+'</td>');
				}
				else
				{
					cantvacios=cantvacios+1;
					myTable_DelRowchanel(row);
				}
            }
			
        }
		
		function AddNewColchanelsindato(colNum, datos,addnomtablemodif)
		{
			 var myTable = $('#myTable'+addnomtablemodif);
            var colCount = myTable.find('td[data-row'+addnomtablemodif+'=0]').length;
            var rowCount = $("#myTable"+addnomtablemodif+" tr").length;
 
            //incriment id numbers to make room for the new column
            myTable_IncrimentColIdNumberdl(colNum, 1,addnomtablemodif);
			
			var arram = [];
			 arram.push( json2array(datos));
			console.log ('new ro chanel:'+arram[0][2]+'-ch'+arram[0][1]);
			
            //add new column by adding a new cell to each row
            for (row = 0; row < rowCount; row++) {
                //add a new cell after the cell for the previous column
                $('td[data-row'+addnomtablemodif+'=' + row + '][data-col'+addnomtablemodif+'=' + (parseInt(colNum)-1) + ']').after('<td data-row'+addnomtablemodif+'="'+ row +'" data-col'+addnomtablemodif+'="' +colNum+ '">  </td>');
            }
		}
 
		function myTable_IncrimentColIdNumberdl(startPosition, increment,addnomtablemodif2) {
 
            //increment column id's
            var cells = $('myTable'+addnomtablemodif2+' td[data-col'+addnomtablemodif2+' ]');
 
            //foreach cell
            for (i = 0; i < cells.length ; i++) {
 
                var colNum = parseInt(cells.eq(i).attr('data-col'+addnomtablemodif2+' '));
 
                //for every column beyond the insertion point, increment the column number
                if (colNum >= startPosition) {
                    var newId = colNum + parseInt(increment);
                    cells.eq(i).attr('data-col'+addnomtablemodif2, newId);
                }
            }
        }
		
		function mostrar_digmodcalib (param_sn_modulo,param_sn_unit )
		{
			//habilitamos los div de los TAB
				$("#divgeneralinfo").addClass('d-none');
				$("#divgeneralinfoparam").addClass('d-none');
				$("#divdetinfolog").addClass('d-none');
				
				$("#diveq").addClass('d-none');
				$("#divfactory").addClass('d-none');
				$("#divfinalcheck").addClass('d-none');
				$("#divgroupbyciu").addClass('d-none');
				
					$("#divgeneralinfo").removeClass('d-none');
					$("#diveq").removeClass('d-none');
					$("#divfactory").removeClass('d-none');
					$("#divfinalcheck").removeClass('d-none');
					$("#divdetinfolog").removeClass('d-none');
						
					$('#infolog').html(""); 
					var losbuttons= "";	
				
			
					$("#myTable").addClass('d-none');
					$("#myTablechanel").addClass('d-none');
					$("#myTableul").addClass('d-none');
					$("#myTablesubband").addClass('d-none');
				
					
					$("#myTabledib").addClass('d-none');
					$("#myTabledibciu").addClass('d-none');
					$("#myTabledibfw").addClass('d-none');
					$("#myTabledibsn").addClass('d-none');
					$("#myTabledibsn").addClass('d-none');
					$("#myTablecaliffw").addClass('d-none');
					$("#myTablecalifsn").addClass('d-none');
					$("#myTablecalifciu").addClass('d-none');
					$("#myTablecaliffreq").addClass('d-none');
					   
					
				
					var myTabledib = $("#myTabledib");
					myTabledib.html("<table id='myTabledib' border='1' class='table table-bordered table-sm texto10 scrolltablemarco table-striped  d-none'><tr data-rowdib='0'><td data-rowdib='0' data-coldib='0' class='table-info'><b>GENERAL INFO</b> </td></tr><tr data-rowdib='1'><td data-rowdib='1' data-coldib='0'>Date</td></tr><tr data-rowdib='2'><td data-rowdib='2' data-coldib='0'>TotalTime </td></tr><tr data-rowdib='3'><td data-rowdib='3' data-coldib='0'>Calibratior </td></tr><tr data-rowdib='4'><td data-rowdib='4' data-coldib='0'>Station</td></tr><tr data-rowdib='5'><td data-rowdib='5' data-coldib='0'>FAS</td></tr><tr data-rowdib='6'><td data-rowdib='6' data-coldib='0'>Total Pass </td></tr></table>");
					
			$.ajax
			({ 
				url: 'aja_show_digmodcalif.php',
				data: "iddib_sn_modulo="+param_sn_modulo+"&idsunit="+param_sn_unit,	
				type: 'post',
				async:true,
                cache:false,
				success: function(data)
				{
					
					//var datax = JSON.parse(data)
					$('#ciusnshow').html( $('#ciusnshowbks').html() + ' &nbsp; Calib:  '+ param_sn_modulo); 
				    $("#msjwait").hide();
				 	
						$.each(data.gicalif, function(i, itemdib) {
							console.log('muestro CALIB...itemdib:'+itemdib.totalpass);
							AddNewColdl(1,itemdib,'dib');				
						});
					//	myTablecaliffw
						$.each(data.gicaliffw, function(i, itemcaliffw) {
							//console.log('muestro itemdibfw:'+itemdibfw.totalpass);
							AddNewColdl(1,itemcaliffw,'califfw');							
						});
						$.each(data.gicalisn, function(i, itemcalifsn) {
							//console.log('muestro itemdibfw:'+itemdibfw.totalpass);
							AddNewColdl(1,itemcalifsn,'califsn');							
						});
						$.each(data.gicaliciu, function(i, itemcalifciu) {
							//console.log('muestro itemdibfw:'+itemdibfw.totalpass);
							AddNewColdl(1,itemcalifciu,'califciu');							
						});
						$.each(data.gicalifreq, function(i, itemcaliffreq) {
							//console.log('muestro itemdibfw:'+itemdibfw.totalpass);
							AddNewColdl(1,itemcaliffreq,'califfreq');							
						});
						
						$.each(data.gilogcalif, function(i, itemlog) {
							console.log('muestro  califlog:'+itemlog.idlog);
							losbuttons = losbuttons + '<span class="badge badge-primary" onclick="show_log('+itemlog.idlog+')"><i class="fas fa-search"></i> Log DigMod: ('+itemlog.idlog+') </span> - ';	
													
						});
						
						//List to EQ
					//	console.log("Buscando eq");
						$('#div_calib_eq').html(""); 
							$.ajax
							({ 
								url: 'aja_show_digmodcalif_eq.php',
								data: "iddib_sn_modulo="+param_sn_modulo+"&idsunit="+param_sn_unit,	
								type: 'post',
								async:true,
								cache:false,
								success: function(data2)
								{
									//console.log(data2);
									$("#div_calib_eq").removeClass('d-none');
									$('#div_calib_eq').html(data2); 
									
								}	
							});	
							
							$('#div_calib_fact').html(""); 
							$.ajax
							({ 
								url: 'aja_show_digmodcalif_factory.php',
								data: "iddib_sn_modulo="+param_sn_modulo+"&idsunit="+param_sn_unit,	
								type: 'post',
								async:true,
								cache:false,
								success: function(data3)
								{
									//console.log(data2);
									$("#div_calib_fact").removeClass('d-none');
									$('#div_calib_fact').html(data3); 
									
								}	
							});	
						
						
						
						losbuttons = losbuttons + '<textarea class="form-control" rows="18" id="detallelog" name="detallelog"></textarea>';
						$('#infolog').html(losbuttons); 
						
						
						
					$("#myTabledib").removeClass('d-none');
					$("#myTablecaliffw").removeClass('d-none');
					$("#myTablecalifsn").removeClass('d-none');
					$("#myTablecalifciu").removeClass('d-none');
					$("#myTablecalifciu").removeClass('d-none');
					$("#myTablecaliffreq").removeClass('d-none');
					
				}
			});
			
		}
		
		function mostrar_digmod(param_sn_modulo,param_sn_unit ) 
		{
			//console.log("mostrar DIG MOD" +  param_sn_modulo+ '-'+ param_sn_unit );
			$("#divgeneralinfo").addClass('d-none');
			$("#divgeneralinfoparam").addClass('d-none');
			$("#divdetinfolog").addClass('d-none');

			$("#diveq").addClass('d-none');
			$("#divfactory").addClass('d-none');
			$("#divfinalcheck").addClass('d-none');
			$("#divgroupbyciu").addClass('d-none');

			$("#divgeneralinfo").removeClass('d-none');
			$("#divdetinfolog").removeClass('d-none');
			$("#divfactory").removeClass('d-none');
				
									
			//Ocultamos DIV de Gralinfo
					$("#myTable").addClass('d-none');
					$("#myTablechanel").addClass('d-none');
					$("#myTableul").addClass('d-none');
					$("#myTablesubband").addClass('d-none');
					
					$('#infolog').html(""); 
			
			var myTabledib = $("#myTabledib");
			var myTabledibciu = $("#myTabledibciu");
			var myTabledibfw = $("#myTabledibfw");
			var myTabledibsn = $("#myTabledibsn");
			
			myTabledib.html("<table id='myTabledib' border='1' class='table table-bordered table-sm texto10 scrolltablemarco table-striped  d-none'><tr data-rowdib='0'><td data-rowdib='0' data-coldib='0' class='table-info'><b>GENERAL INFO</b> </td></tr><tr data-rowdib='1'><td data-rowdib='1' data-coldib='0'>Date</td></tr><tr data-rowdib='2'><td data-rowdib='2' data-coldib='0'>TotalTime </td></tr><tr data-rowdib='3'><td data-rowdib='3' data-coldib='0'>Calibratior </td></tr><tr data-rowdib='4'><td data-rowdib='4' data-coldib='0'>Station</td></tr><tr data-rowdib='5'><td data-rowdib='5' data-coldib='0'>FAS</td></tr><tr data-rowdib='6'><td data-rowdib='6' data-coldib='0'>Total Pass </td></tr></table>");
			myTabledibciu.html("<table id='myTabledibciu' border='1' class='table table-bordered table-sm texto10 scrolltablemarco table-striped  d-none'><tr data-rowdibciu='0'><td data-rowdibciu='0' data-coldibciu='0' class='table-info'><b>CIUs</b> </td></tr><tr data-rowdibciu='1'><td data-rowdibciu='1' data-coldibciu='0'>CIU DB</td></tr><tr data-rowdibciu='2'><td data-rowdibciu='2' data-coldibciu='0'>CIU Unit </td></tr></table>");
			myTabledibfw.html("<table id='myTabledibfw' border='1' class='table table-bordered table-sm texto10 scrolltablemarco table-striped  d-none'>				 <tr data-rowdibfw='0'><td data-rowdibfw='0' data-coldibfw='0' class='table-info'><b>FWs</b> </td></tr><tr data-rowdibfw='1'><td data-rowdibfw='1' data-coldibfw='0'>FW FPGA</td></tr><tr data-rowdibfw='2'><td data-rowdibfw='2' data-coldibfw='0'>FW uC </td></tr><tr data-rowdibfw='3'><td data-rowdibfw='3' data-coldibfw='0'>FW Rabb </td></tr></table>");
			myTabledibsn.html("	<table id='myTabledibsn' border='1' class='table table-bordered table-sm texto10 scrolltablemarco table-striped  d-none '><tr data-rowdibsn='0'><td data-rowdibsn='0' data-coldibsn='0' class='table-info'><b>SNs</b> </td></tr><tr data-rowdibsn='1'><td data-rowdibsn='1' data-coldibsn='0'>SN DB</td></tr><tr data-rowdibsn='2'><td data-rowdibsn='2' data-coldibsn='0'>SN Unit </td></tr></table>");
			
			
			
			var losbuttons= "";			
							
							
			
			$.ajax
			({ 
				url: 'aja_show_digmod.php',
				data: "iddib_sn_modulo="+param_sn_modulo+"&idsunit="+param_sn_unit,	
				type: 'post',
				async:true,
                cache:false,
				success: function(data)
				{
					//alert(data);
					//var datax = JSON.parse(data)
				    $("#msjwait").hide();
				 	$('#ciusnshow').html( $('#ciusnshowbks').html() + ' &nbsp; DigMod:  '+ param_sn_modulo); 
						$.each(data.gi, function(i, itemdib) {
							//console.log('muestro itemdib:'+itemdib.totalpass);
							AddNewColdl(1,itemdib,'dib');				
						});
						$.each(data.gifw, function(i, itemdibfw) {
							//console.log('muestro itemdibfw:'+itemdibfw.totalpass);
							AddNewColdl(1,itemdibfw,'dibfw');							
						});
						$.each(data.gisn, function(i, itemdibsn) {
							//console.log('muestro itemdibsn:'+itemdibsn.totalpass);
							AddNewColdl(1,itemdibsn,'dibsn');							
						});
						$.each(data.giciu, function(i, itemdibciu) {
							//console.log('muestro itemdibsn:'+itemdibciu.totalpass);
							AddNewColdl(1,itemdibciu,'dibciu');							
						});
						$.each(data.gilog, function(i, itemlog) {
							console.log('muestro log:'+itemlog.idlog);
							losbuttons = losbuttons + '<span class="badge badge-primary" onclick="show_log('+itemlog.idlog+')"><i class="fas fa-search"></i> Log DigMod: ('+itemlog.idlog+') </span> - ';	
													
						});
						
						losbuttons = losbuttons + '<textarea class="form-control" rows="18" id="detallelog" name="detallelog"></textarea>';
						$('#infolog').html(losbuttons); 
						
						
					$("#myTabledib").removeClass('d-none');
					$("#myTabledibciu").removeClass('d-none');
					$("#myTabledibfw").removeClass('d-none');
					$("#myTabledibsn").removeClass('d-none');
				}
			});
			
		}
   
</script>

</html>

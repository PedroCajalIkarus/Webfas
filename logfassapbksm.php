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

  <script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

  <script src="plugins/datatables/jquery.dataTables.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
  
  <link href="css/tabulator_bootstrap4.css" rel="stylesheet">
  <link rel="shortcut icon" href="fiplexcirculo-01.ico" />
  

  <link rel="stylesheet" href="toastr.css">
  
 <link href="css/tabulator_bulma.css" rel="stylesheet">


 <!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- DataTables -->
<script src="plugins/chart.js/Chart.min.js"></script>


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

 
<script src="js/eModal.min.js" type="text/javascript" ></script>
 
  
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
</form>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>XML Logger </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">XML Logger </li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <form  action="logfassap.php" method="post" class="form-horizontal" id="myform" name="myform">	
    <!-- Main content -->
    <section class="content">
    <div class="row">
      <div class="container-fluid">
        
        <!-- Timelime example  -->
        <div class="row">
          <section class="col-lg-12 connectedSortable ui-sortable">
     
            <div class="container-fluid" name="divscrolllog" id="divscrolllog" style="display.">
			<p name="msjwaitline" id="msjwaitline" align="center"><img src="img/waitazul.gif" width="100px" ></p>	
				<div class="card">
					<br>
           <div class='container-fluid col-sm-8'>
           <br>
              <div class="input-group input-group-sm">
                  <input type="text" class="form-control" placeholder="custom search" name="txtbusqcustom" id="txtbusqcustom">
                  <span class="input-group-append">
                  <button type="button" name="btn2" id="btn2" class="btn btn-flat" onclick="search_custom()"><i class="fas fa-search-plus"></i></button>
                  <button type="button" name="btn1" id="btn1" class="btn btn-flat d-none" onclick="search_custom()"><i class="fas fas fa-search" title="custom search" alt="custom search"></i></button>
                  
                  </span>
                </div>
                </div>
          
           <div class='container-fluid col-sm-12'>
           <hr>
        <?php
 include("db_conect.php"); 
	
 
 $v_lasempresas = $_REQUEST['lasempresas'];
 $v_lasbandas = $_REQUEST['lasbandas'];
 $v_losbranchs = $_REQUEST['losbranchs'];
 $v_losatributos =  $_REQUEST['losatributos'];
 include("db_conect.php"); 

 $sumowhere ="";
 if (isset($_POST['txtbusqcustom']))
 {
  echo  "<div class='alert alert-success' role='alert'><b>Custom Search: ".$_POST['txtbusqcustom']."</b></div><hr><br>";
  $query_lista = "

  select fas_outcome_integral.reference ,fas_outcome_integral.datetimeref,  fas_outcome_integral.idtype , fasoutcometypename,  fas_outcome_integral.v_boolean::integer as v_booleanconvert, fas_outcome_integral2.v_string
  
  from fas_outcome_integral
  inner join (
      select reference
      from fas_outcome_integral 
      where   v_string like '%".$_POST['txtbusqcustom']."%' 
      ) as losrun
      on losrun.reference = fas_outcome_integral.reference
      and fas_outcome_integral.idfasoutcomecat in(0) and fas_outcome_integral.idtype=13
  
  inner join fas_outcome_category_type
  on fas_outcome_category_type.idfasoutcomecat = fas_outcome_integral.idfasoutcomecat and
    fas_outcome_category_type.idtype          = fas_outcome_integral.idtype
  
  left join fas_outcome_integral as fas_outcome_integral2
  on  fas_outcome_integral2.reference       = losrun.reference and
      fas_outcome_integral2.idfasoutcomecat = 0 and
      fas_outcome_integral2.idtype          = 43
  
      order by fas_outcome_integral.datetimeref desc  
  "; 
       
 }
 else
 {

  echo "<div class='alert alert-warning' role='alert'> (*) - Show last 3 days</div>";
      $query_lista = "

      select fas_outcome_integral.reference ,fas_outcome_integral.datetimeref,  fas_outcome_integral.idtype , fasoutcometypename,  fas_outcome_integral.v_boolean::integer as v_booleanconvert, fas_outcome_integral2.v_string
      , fas_outcome_integral.v_integer as v_integeconvert
      ,   fas_outcome_integral.v_double as v_doubleconvert
      
      from fas_outcome_integral
      inner join (
          select reference
          from fas_outcome_integral 
          where idfasoutcomecat = 0  and 
                fas_outcome_integral.idtype =16 and 
                v_string = 'Connector SAP-WEBFAS' and datetimeref > now() - interval '2 day'
          ) as losrun
          on losrun.reference = fas_outcome_integral.reference
          and fas_outcome_integral.idfasoutcomecat in(0) and fas_outcome_integral.idtype=13
      
      inner join fas_outcome_category_type
      on fas_outcome_category_type.idfasoutcomecat = fas_outcome_integral.idfasoutcomecat and
        fas_outcome_category_type.idtype          = fas_outcome_integral.idtype
      
      left join fas_outcome_integral as fas_outcome_integral2
      on  fas_outcome_integral2.reference       = losrun.reference and
          fas_outcome_integral2.idfasoutcomecat = 0 and
          fas_outcome_integral2.idtype          = 43
      
          order by fas_outcome_integral.datetimeref desc          "; 
 }

 $data = $connect->query($query_lista)->fetchAll();	
 $ref =0;
 ?>
 <table class="table table-striped table-bordered table-sm dataTable no-footer" style="font-size:12px;" name="tblfilter0" id="tblfilter0" role="grid" aria-describedby="tblfilter0_info">
  <thead>
 <tr>
   <th class="bg-primary "> Idruninfo </th>
   <th class="bg-primary "> Datetime </th>
 <th class="bg-primary "> Status </th>
  <th class="bg-primary "> Error Description </th>  


  <th class="bg-primary "> SAP_Action </th>  
  <th class="bg-primary "> SAP_Wosoramup </th>  
  <th class="bg-primary "> SAP_Partnumber	 </th>  
  <th class="bg-primary "> SAP_Po </th>  
  <th class="bg-primary "> SAP_Posnr </th>  
  <th class="bg-primary "> SAP_Quantity </th>  


  </tr>
 </thead>
 <tbody>
 <?php

   foreach ($data as $row2) 
   {
	$indxtablaadd=0;
      
	   ?>
	<td> <?php echo  $row2['reference'];  ?> <a href='#' onclick='popuplogdb(<?php echo  $row2['reference'];  ?>)'  style='color:#f39323;'> <i class='fas fa-eye'></i></a> </td>
  <td> <?php echo  $row2['datetimeref'];  ?></td>
		<?php						
	   echo "<td>";
     if ( $row2['v_booleanconvert'] ==1)
     {
      if (  $row2['v_integeconvert'] ==1 && $row2['v_doubleconvert'] ==2  )
        {
          echo "<span class='badge bg-info'>Pass</span>";
          echo "</td>";  	   
          echo "<td>  <span class='text-secondary'> ".$row2['v_string']." </span> </td>";
        }
        else
        {
          echo "<span class='badge bg-green'>Pass</span>";
          echo "</td>";  	   
          echo "<td>  <span class='text-secondary'> ".$row2['v_string']." </span> </td>";
        }
      
     }
     else
     {
      echo "<span class='badge bg-red'>Fail</span>";
      echo "</td>";  	   
      echo "<td>  <span class='text-danger'> ".$row2['v_string']." </span> </td>";
     }
     
   
	   

        /////SAP_Action
          $sqlcelda ="select v_string from fas_outcome_integral where reference = ".$row2['reference']." and idfasoutcomecat = 17 and idtype = 0 limit 1 ";
       //   echo  $sqlcelda;
          $datacelda = $connect->query($sqlcelda)->fetchAll();	
          $vtienedata = 0;
          foreach ($datacelda as $rowm2) 
          {
            echo "<td>".$rowm2['v_string']."</td>";
            $vtienedata = 1;
          }
          if ($vtienedata == 0)
                {
                 echo "<td></td>";
                }

               
            /////SAP_Wosoramup
            $sqlcelda ="select v_string from fas_outcome_integral where reference = ".$row2['reference']." and idfasoutcomecat = 17 and idtype = 3 limit 1";
            $datacelda = $connect->query($sqlcelda)->fetchAll();	
            $vtienedata = 0;
            foreach ($datacelda as $rowm2) 
            {
              echo "<td>".$rowm2['v_string']."</td>";
              $vtienedata = 1;
            }
            if ($vtienedata == 0)
                {
                 echo "<td></td>";
                }
          /////SAP_Partnumber
          $sqlcelda ="select v_string from fas_outcome_integral where reference = ".$row2['reference']." and idfasoutcomecat = 17 and idtype = 2 limit 1";
          $datacelda = $connect->query($sqlcelda)->fetchAll();	
          $vtienedata = 0;
          foreach ($datacelda as $rowm2) 
          {
            echo "<td>".$rowm2['v_string']."</td>";
            $vtienedata = 1;
          }
          if ($vtienedata == 0)
                {
                 echo "<td></td>";
                }
           /////SAP_Po
           $sqlcelda ="select v_string from fas_outcome_integral where reference = ".$row2['reference']." and idfasoutcomecat = 17 and idtype = 4 limit 1";
           $datacelda = $connect->query($sqlcelda)->fetchAll();	
           $vtienedata = 0;
           foreach ($datacelda as $rowm2) 
           {
            $vtienedata = 1;
             if ( $rowm2['v_string'] =="")
             {
              echo "<td> <span class='text-danger'>Missing Parameters</span>  </td>";
             }
             else
             {
                echo "<td>".$rowm2['v_string']."</td>";
             }
             
           }
           if ($vtienedata == 0)
                {
                 echo "<td></td>";
                }
             /////SAP_Posnr
             $sqlcelda ="select v_integer from fas_outcome_integral where reference = ".$row2['reference']." and idfasoutcomecat = 17 and idtype = 7 limit 1";
             $datacelda = $connect->query($sqlcelda)->fetchAll();	
             $vtienedata = 0;
             foreach ($datacelda as $rowm2) 
             {
              $vtienedata = 1;
               echo "<td>".$rowm2['v_integer']."</td>";
             }
             if ($vtienedata == 0)
                {
                 echo "<td></td>";
                }
               /////SAP_Quantity
               $sqlcelda ="select v_integer from fas_outcome_integral where reference = ".$row2['reference']." and idfasoutcomecat = 17 and idtype = 5 limit 1";
               $datacelda = $connect->query($sqlcelda)->fetchAll();	
               $vtienedata = 0;
               foreach ($datacelda as $rowm2) 
               {
                $vtienedata = 1;
                 echo "<td>".$rowm2['v_integer']."</td>";
               }
               if ($vtienedata == 0)
                {
                 echo "<td></td>";
                }

                echo " </tr>";      

   }

?>
	</tbody>
</table>
</div>

<script type="text/javascript">
												///		$('#tblfilter0').DataTable({searching: true, paging: true, info: false, pageLength: 500000,  order: [[1, 'desc']],} );
										 
																</script>
			
        </section>

        <section class="col-lg-4  ui-sortable">
       
        <div class="col">
          <br>
          <div class="container-fluid" name="divscrolllog" id="divscrolllog" style="display.">
              <div class="container-fluid card">  
              <br>
              <p class='colorazulfiplex' style="font-size:14px"><b>Report  </b></p>
              <hr>
              Select Range:
                <div id="reportrange" name="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                  <i class="fa fa-calendar"></i>&nbsp;
                  <span></span> <i class="fa fa-caret-down"></i>
                </div>
              <input type="hidden" id="txtfechad" name="txtfechad">
              <input type="hidden" id="txtfechah" name="txtfechah">
              
          <hr>

          <p align="right"><br>
						<button class="btn btn-info btn-sm btn-secondary" onclick="reportarme()"> View </button>
						</p>
						<div name="grafdetalle" id="grafdetalle">
						<div name="grafdetalle1" id="grafdetalle1">
						<canvas id="grafico-chart1" height="200"></canvas>

						<?php

							$query_listagraf = " 
							select  coalesce(fas_outcome_integral_tp.v_boolean::integer,3) as tpsnrun, fas_outcome_integral.* 
							from fas_outcome_integral
							inner join (
								select losdatos.*
								from (
									select scriptname,  fas_outcome_integral.reference  
															from fas_outcome_integral
															inner join fas_script_type
															on fas_script_type.idscripttype = fas_outcome_integral.v_integer
															where idfasoutcomecat = 0 and idtype = 12 and 
															v_integer in(select idscripttype from fas_script_type 
																		 where scriptname LIKE '%Accept%'    )
									 ) losdatos
									inner join fas_outcome_integral
									on fas_outcome_integral.reference = losdatos.reference
									where fas_outcome_integral.idtype = 16 and v_string not in (  

										select username from userfas where iduserfas in(
											select iduserfas
											from userfas_attributes
											where idattribute_user = 1)
																	)
									   ) as losrun
							on losrun.reference 	=   fas_outcome_integral.reference and
							   fas_outcome_integral.idfasoutcomecat = 0 and 
							   fas_outcome_integral.idtype = 4
                             inner join (
                             
                                   select fas_outcome_integral.v_string, max(fas_outcome_integral.datetimeref) as maxfecha
                                      from (
                                    select  * 
                                    from fas_outcome_integral
                                    inner join fas_script_type
                                    on fas_script_type.idscripttype = fas_outcome_integral.v_integer
                                    where idfasoutcomecat = 0 and idtype = 12 and 
                                    v_integer in(select idscripttype from fas_script_type 
                                    where scriptname LIKE '%Accept%'    )
                                 ) as losruntodos 
                              inner join fas_outcome_integral
                              	on losruntodos.reference 	=   fas_outcome_integral.reference and
							   fas_outcome_integral.idfasoutcomecat = 0 and 
							   fas_outcome_integral.idtype = 4
                           group by fas_outcome_integral.v_string    
                                 
                             ) as losmasnfecha  
                             on losmasnfecha.v_string  =    fas_outcome_integral.v_string and
                                losmasnfecha.maxfecha  =    fas_outcome_integral.datetimeref
							left join fas_outcome_integral as fas_outcome_integral_tp
							on fas_outcome_integral_tp.reference 	=   fas_outcome_integral.reference and
							   fas_outcome_integral_tp.idfasoutcomecat = 0 and 
							   fas_outcome_integral_tp.idtype =13   
							where 'AcceptBatteryCharger'   = scriptname  
							";

							// echo $query_lista ;

							$data = $connect->query($query_listagraf)->fetchAll();	
							
							$v_tp_true =0;
							$v_tp_false =0;
							$v_tp_abort =0;

							foreach ($data as $row3) 
							{
								if ( $row3['tpsnrun']==1)
								{
									$v_tp_true = $v_tp_true +1;
								}
								else
								{
									if ( $row3['tpsnrun']==0)
									{
										$v_tp_false = $v_tp_false +1;
									}
									if ( $row3['tpsnrun']==3)								
									{
										$v_tp_abort = $v_tp_abort +1;
										
									}
								}
							
							}
						
						?>
							 
						</div>
						<script type="text/javascript">
 

    var grafico1chart = $('#grafico-chart1').get(0).getContext('2d'); 
   

  //  var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
  /*
   $vlblgraf1=$vlblgraf1.",Others";
    $vdatgraf1=$vdatgraf1.",".$lodemas;
    */
    var donutData1        = {
      labels: ['Pass [<?php echo $v_tp_true; ?>] ','No Pass [<?php echo $v_tp_false; ?>]','Abort [<?php echo $v_tp_abort; ?>]'],
      datasets: [
        {
          data: [<?php echo $v_tp_true.",".$v_tp_false.",".$v_tp_abort; ?>],
          backgroundColor : [  '#28a745', '#dc3545', '#ffc107', '#993333'],
        }
      ]
    }

   
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var donutChart = new Chart(grafico1chart, {
      type: 'doughnut',
      data: donutData1,
      options: donutOptions      
    })
   
 
						</script>
<br><br><br><br><br>
          </div>  
        </section>
        </div>
			</div>
      </div>

     
      </section>
       
          <!-- /.col -->
        </div>
      </div>
      <!-- /.timeline -->
     
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

   var input = document.getElementById("txtbusqcustom");

// Execute a function when the user presses a key on the keyboard
input.addEventListener("keypress", function(event) {
  // If the user presses the "Enter" key on the keyboard
  if (event.key === "Enter") {
    // Cancel the default action, if needed
    event.preventDefault();
    // Trigger the button element with a click
    search_custom();
  }
});

     		
		function search_custom()
    {
        if ( $('#txtbusqcustom').val()=='')
        {
          toastr["warning"]("enter the text to search...", "Alert.!");		
        }
        else
        {
          toastr["success"]("Search...", "");		
          document.getElementById("myform").submit();
        }
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

   function popuplogdb(idrunifno)
   {
    eModal.iframe('logdbonlydet.php?idab='+idrunifno,'Log Activity');
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
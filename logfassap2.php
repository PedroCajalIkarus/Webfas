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
            <h1>XML Logger ver 1.2 </h1>
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
    <form  action="logfassap2.php" method="post" class="form-horizontal" id="myform" name="myform">	
    <!-- Main content -->
    <section class="content">
    <div class="row">
      <div class="container-fluid">
        
        <!-- Timelime example  -->
        <div class="row">
          <section class="col-lg-8 connectedSortable ui-sortable">

            <div class="container-fluid" name="divscrolllog" id="divscrolllog" style="display.">
			<p name="msjwaitline" id="msjwaitline" align="center"><img src="img/waitazul.gif" width="100px" ></p>	
				<div class="card">
        <br>
           <div class='container-fluid col-sm-12'>
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
      select losxmlsap.reference, losxmlsap.id_outcomemm , losxmlsap.datetimeref,  COALESCE (vertotolpass.v_boolean::integer,99) as v_booleanconvert, array_to_json(array_agg(fas_outcome_integral_sap)) as ffd
	
		  from 
		  (
			  select reference, id_outcome as id_outcomemm , datetimeref
			  from fas_outcome_integral_sap
			  where  idfasoutcomecat = 0 and idtype = 23 and v_bigint in (
			  select reference
			  from fas_outcome_integral_sap
			  where idfasoutcomecat = 0 and idtype = 12 and v_integer= 46)
		  ) as losxmlsap
		  inner join fas_outcome_integral_sap
		  on fas_outcome_integral_sap.reference = losxmlsap.id_outcomemm
		  left join fas_outcome_integral_sap as vertotolpass
		  on vertotolpass.reference = losxmlsap.id_outcomemm and vertotolpass.idfasoutcomecat = 0 and vertotolpass.idtype = 12
      where  fas_outcome_integral_sap.v_string like '%".$_POST['txtbusqcustom']."%' 
		
		  group by losxmlsap.reference, losxmlsap.id_outcomemm , losxmlsap.datetimeref, vertotolpass.v_boolean

  "; 

  $query_lista ="   select losxmlsap.reference, losxmlsap.id_outcomemm , losxmlsap.datetimeref, 
	COALESCE (vertotolpass.v_boolean::integer,99) as v_booleanconvert, 
	jsonb_agg( (fas_outcome_integral_sap)) as ffd
	
		  from 
		  (
			  select reference, id_outcome as id_outcomemm , datetimeref
			  from fas_outcome_integral_sap
			  where  idfasoutcomecat = 0 and idtype = 23 
        and    id_outcome in(select reference  from fas_outcome_integral_sap 
        where  fas_outcome_integral_sap.v_string like '%".$_POST['txtbusqcustom']."%')  
        and v_bigint in (
			  select reference
			  from fas_outcome_integral_sap
			  where idfasoutcomecat = 0 and idtype = 12 and v_integer= 46)
		  ) as losxmlsap
		  inner join fas_outcome_integral_sap
		  on fas_outcome_integral_sap.reference = losxmlsap.id_outcomemm
		  left join fas_outcome_integral_sap as vertotolpass
		  on vertotolpass.reference = losxmlsap.id_outcomemm and vertotolpass.idfasoutcomecat = 0 and vertotolpass.idtype = 12
	 
		  group by losxmlsap.reference, losxmlsap.id_outcomemm , losxmlsap.datetimeref, vertotolpass.v_boolean
		  
		  union all 
		    select distinct fas_outcome_integral.reference ,fas_outcome_integral.idtype , fas_outcome_integral.datetimeref,
  COALESCE (fas_outcome_integral.v_boolean::integer,99) as v_booleanconvert ,jsonb_agg( (fas_outcome_integral23))  
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
  inner join fas_outcome_integral as fas_outcome_integral23
  on fas_outcome_integral23.reference= fas_outcome_integral.reference 
  
  left join fas_outcome_integral as fas_outcome_integral2
  on  fas_outcome_integral2.reference       = losrun.reference and
      fas_outcome_integral2.idfasoutcomecat = 0 and
      fas_outcome_integral2.idtype          = 43
  group by fas_outcome_integral.reference ,fas_outcome_integral.idtype , fas_outcome_integral.datetimeref,
  fas_outcome_integral.v_boolean   order by datetimeref desc  ";
       
       
 }
 else
 {

  echo "<div class='alert alert-warning' role='alert'> (*) - Show last 3 days</div>";
      $query_lista = "

      select losxmlsap.reference, losxmlsap.id_outcomemm , losxmlsap.datetimeref,  COALESCE (vertotolpass.v_boolean::integer,99) as v_booleanconvert, array_to_json(array_agg(fas_outcome_integral_sap)) as ffd
	
		  from 
		  (
			  select reference, id_outcome as id_outcomemm , datetimeref
			  from fas_outcome_integral_sap
			  where  idfasoutcomecat = 0 and idtype = 23 and v_bigint in (
			  select reference
			  from fas_outcome_integral_sap
			  where idfasoutcomecat = 0 and idtype = 12 and v_integer= 46) and datetimeref > now() - interval '2 hour'
		  ) as losxmlsap
		  inner join fas_outcome_integral_sap
		  on fas_outcome_integral_sap.reference = losxmlsap.id_outcomemm
		  left join fas_outcome_integral_sap as vertotolpass
		  on vertotolpass.reference = losxmlsap.id_outcomemm and vertotolpass.idfasoutcomecat = 0 and vertotolpass.idtype = 12
		  
		
		  group by losxmlsap.reference, losxmlsap.id_outcomemm , losxmlsap.datetimeref, vertotolpass.v_boolean
    
      "; 
 }

//echo   $query_lista;

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

  <th class="bg-primary "> SAP_FileName </th>  
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
      
  $decode = json_decode($row2['ffd']);

  $sap_filename="";
  $sap_action="";
  $sap_wosormaup="";
  $sap_partnumber="";
  $sap_po="";
  $sap_posnr="";
  $sap_quantity="";

    $datajson = json_decode($row2['ffd'],true); 
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
   
    foreach ($datajson as $key=> $data1) 
    {
       
 //    echo $key, " : ";
  //   echo  $decoded_json[$key]["datetimeref"]."-";  
   //  echo "<br>pp:".$data1['idfasoutcomecat']."||".$data1['idtype']."||".$data1['v_string']."<br>";
 


        if ( $data1['idfasoutcomecat'] == 17 && $data1['idtype'] == 21) { $sap_filename= $data1['v_string'] ;  }
        if ( $data1['idfasoutcomecat'] == 17 && $data1['idtype'] == 0) { $SAP_Action= $data1['v_string'] ;  }
        if ( $data1['idfasoutcomecat'] == 17 && $data1['idtype'] == 12 && $data1['v_string'] == 'ZREN' ) { $SAP_Action = $SAP_Action."-RMA" ;  }
        if ( $data1['idfasoutcomecat'] == 17 && $data1['idtype'] == 3) { $SAP_Wosoramup= $data1['v_string'] ;  }
        if ( $data1['idfasoutcomecat'] == 17 && $data1['idtype'] == 18 ) { $SAP_Wosoramup= $data1['v_string'] ;  }
        if ( $data1['idfasoutcomecat'] == 17 && $data1['idtype'] == 2) { $SAP_Partnumber = $data1['v_string'] ;  }
        if ( $data1['idfasoutcomecat'] == 17 && $data1['idtype'] == 19) { $SAP_Partnumber = $data1['v_string'] ;  }
        if ( $data1['idfasoutcomecat'] == 17 && $data1['idtype'] == 17) { $SAP_Po = $data1['v_string'] ;  }
        if ( $data1['idfasoutcomecat'] == 17 && $data1['idtype'] == 7) { $SAP_Posnr = $data1['v_integer'] ;  }
        if ( $data1['idfasoutcomecat'] == 17 && $data1['idtype'] == 5) { $SAP_Quantity = $data1['v_integer'] ;  }
        if ( $data1['idfasoutcomecat'] == 0 && $data1['idtype'] == 13) { $SAP_totalpass = $data1['v_boolean'] ;  }
        if ( $data1['idfasoutcomecat'] == 17 && $data1['idtype'] == 23) { $SAP_Result_descrption_fnt = $data1['v_string'] ;  }
        if ( $data1['idfasoutcomecat'] == 0 && $data1['idtype'] == 43) { $SAP_Result_descrption_fnt = $data1['v_string'] ;  }

        


  
     }


	   ?>
	<td> <?php echo  $row2['reference'];  ?> <a href='#' onclick='popuplogdb(<?php echo  $row2['reference'];  ?>)'  style='color:#f39323;'> <i class='fas fa-eye'></i></a> </td>
  <td> <?php echo  $row2['datetimeref'];  ?></td>
		<?php						
	   echo "<td>";
    //echo $SAP_totalpass;
     if ( $SAP_totalpass=="true")
     {

       if (strpos(  $SAP_Result_descrption_fnt, 'Already ') !== false) 
        {
          echo "<span class='badge bg-info'>Bypass</span>";
          echo "</td>";  	   
          
        }
        else
        {
          echo "<span class='badge bg-green'>OK</span>";
          echo "</td>";  	   
          
        }
      
     }
     else
     {

          if (strpos(  $SAP_Result_descrption_fnt, 'Already ') !== false) 
          {
            echo "<span class='badge bg-info'>Bypass</span>";
            echo "</td>";  
          }
          else
          {
                if ($row2['v_string'] =="The SKU is not Mother")
                {
                  echo "<span class='badge bg-info'>Bypass</span>";
                echo "</td>";  	   
                
                }
                else
                {
                  echo "<span class='badge bg-red'>Fail</span>";
                  echo "</td>";  	   
                  
                }
          
        }
    }
     
     
                echo "<td>".$SAP_Result_descrption_fnt."</td>";
                echo "<td>".$sap_filename."</td>";
                echo "<td>".$SAP_Action."</td>";
                echo "<td>".$SAP_Wosoramup."</td>";
                echo "<td>".$SAP_Partnumber."</td>";
                echo "<td>".$SAP_Po."</td>";
                echo "<td>".$SAP_Posnr."</td>";
                echo "<td>".$SAP_Quantity."</td>";
               

                echo " </tr>";      

   }

?>
	</tbody>
</table>
</div>
<script type="text/javascript">
														$('#tblfilter0').DataTable({searching: true, paging: true, info: false, pageLength: 500000,  order: [[1, 'desc']],} );
										 
																</script>
		 
        </section>
 
        <section class="col-lg-4  ui-sortable">
       
        <div class="col">
        
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
						<button class="btn btn-info btn-sm btn-secondary" onclick="reportarme(0);return false;"> View </button>
						</p>
						<div name="grafdetalle" id="grafdetalle">
						<div name="grafdetalle1" id="grafdetalle1">
						<canvas id="grafico-chart1" height="200"></canvas>

						 
          </div>  
        </section>
        </div>
			</div>
      </div>

        </section>
	 
     

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

 
<script src="js/eModal.min.js" type="text/javascript" ></script>
</body>

<script type="text/javascript">

   
   
	$( document ).ready(function() {


    $(function() {

//----var start = moment().subtract(29, 'days');
var start = moment();
var end = moment();

function cb(start, end) {
	$('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
}

$('#reportrange').daterangepicker({
	startDate: start,
	endDate: end,
	ranges: {
	   'Today': [moment(), moment()],
	   'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
	   'Last 7 Days': [moment().subtract(6, 'days'), moment()],
	   'Last 30 Days': [moment().subtract(29, 'days'), moment()],
	   'This Month': [moment().startOf('month'), moment().endOf('month')],
	   'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
	}
}, cb);

cb(start, end);

});

		
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
			

        reportarme(1);

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

   $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
  console.log(picker.startDate.format('YYYY-MM-DD'));
  $("#txtfechad").val(picker.startDate.format('YYYY-MM-DD'));
  $("#txtfechah").val(picker.endDate.format('YYYY-MM-DD'));
  console.log(picker.endDate.format('YYYY-MM-DD'));
});
   

function reportarme(idparam)
{
	 
	var txtfechad = $("#txtfechad").val();
	var txtfechah = $("#txtfechah").val();
  if (idparam ==1)
  {

    let date = new Date();
let output =date.getFullYear()  + '/' + String(date.getMonth() + 1).padStart(2, '0') + '/' +  String(  date.getDate()).padStart(2, '0');
console.log(output);

    txtfechad = output;
    txtfechah = output;
  }
	if (txtfechah =='' || txtfechad == '' )
	{
		toastr["error"]("Missing select parameters to generate the report", "Error...");	
	}
	else
	{
		toastr["success"]("...Wait..", "Working");		

		var armando_tabla ="";
		$.ajax({
				url: 'ajax_logfassap_graphallsnrun2.php?pfd='+txtfechad+'&pfh='+txtfechah ,										
				 cache:false,
				success: function(respuesta) {
					
					armando_tabla=respuesta;
					
									
			
			//console.log('abrir div'+respuesta);
					$('#grafdetalle').html("");
					$('#grafdetalle').html(""+armando_tabla);
					$('#msjwait').hide();
          return false;
				},
				error: function() {
					console.log("No se ha podido obtener la información");
					$('grafdetalle').html("");
				}
			});


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
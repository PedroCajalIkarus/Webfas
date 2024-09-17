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
<?php
  $V_fechadesde = $_REQUEST['txtfechad'];
  $V_fechaha =  $_REQUEST['txtfechah'];
  $v_ispowerh = $_REQUEST['chkispower'];
?>

<form name="frma" id="frma" method="post"  >
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Sales Report - <?php echo  $V_fechadesde." - ".$V_fechaha;?> </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Sales Report</li>
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
        <div class="row">
<?php
  $V_fechadesde = $_REQUEST['txtfechad'];
  $V_fechaha =  $_REQUEST['txtfechah'];
  $v_ispowerh = $_REQUEST['chkispower'];
?>

        Select Range:
						 <div id="reportrange" name="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
							<i class="fa fa-calendar"></i>&nbsp;
							<span></span> <i class="fa fa-caret-down"></i>
						</div>
            <div>  <input type="checkbox" id="chkispower" name="chkispower" value="true" <?php      $v_ispowerh = $_REQUEST['chkispower'];
             if ($v_ispowerh =="true")
             { echo "checked"; }?>>
  <label for=""> Is High Power</label><br>
            </div>
						<input type="hidden" id="txtfechad" name="txtfechad">
						<input type="hidden" id="txtfechah" name="txtfechah">
						<p aling="right"><br>
						<button class="btn btn-info btn-sm btn-secondary" onclick="reportarme()"> Generate Report  </button>
						</p>
      </div>   
        </section>                  	
                               
                           


          <section class="col-lg-4 connectedSortable ui-sortable">
                                
            <div class="" name="divscrolllog" id="divscrolllog" style="display.">
			<p name="msjwaitline" id="msjwaitline" align="center"><img src="img/waitazul.gif" width="100px" ></p>	
				<div class="card">
					<?php
 $sumowhere2 = " ";
          $V_fechadesde = $_REQUEST['txtfechad'];
          $V_fechaha =  $_REQUEST['txtfechah'];
          $v_ispowerh = $_REQUEST['chkispower'];
       //   echo "<br>is power".$v_ispowerh;
          if ($v_ispowerh =="true")
          {
         ///   echo "aaaaaaaaaaaaaaaaaaaaaaaa";
              $sumowhere = " and orders.idproduct in (select distinct idproduct from products_attributes where idattribute in (22) )";
          }
    //      exit();
          if ( $V_fechadesde =="")
          {
            $query_listagraf = " 
            select namecustomers, sum(quantity) as cantt, count(distinct idproduct) as cantt2
            from (
            select distinct orders.idcustomers, customers.namecustomers,   orders.idproduct ,   quantity
                      from orders
                      inner join orders_sn
                      on orders.idorders = orders_sn.idorders
                      inner join customers
                      on customers.idcustomers = orders.idcustomers
                      where orders.typeregister='SO' ". $sumowhere."
               -----and namecustomers like '%HONEYWELL%'
             ) as tttt
             group by namecustomers
            order by cantt desc
             ";
          }
          else
          {

            $sumowhere2 = "  and orders.processday between '".$V_fechadesde."' AND  '".$V_fechaha." 23:59:59' ";
            $query_listagraf = " 
select namecustomers, sum(quantity) as cantt, count(distinct idproduct) as cantt2
from (
select distinct orders.idcustomers, customers.namecustomers,   orders.idproduct ,   quantity
          from orders
          inner join orders_sn
          on orders.idorders = orders_sn.idorders
          inner join customers
          on customers.idcustomers = orders.idcustomers
          where orders.active = 'Y' and  orders.typeregister='SO' ". $sumowhere." 
           and orders.processday between '".$V_fechadesde."' AND  '".$V_fechaha." 23:59:59'
   
 ) as tttt
 group by namecustomers
order by cantt desc
 ";

          }



 //echo $query_listagraf ;

$data = $connect->query($query_listagraf)->fetchAll();	
$vi=1;
$vlblgraf1="";
$vdatgraf1="";
$lodemas =0;



foreach ($data as $row3) 
{
  if ($vi<8)
  {
    $vlblgraf1=$vlblgraf1."'".$row3['namecustomers']."',";
    $vdatgraf1=$vdatgraf1."".$row3['cantt'].",";
  }
  else
  {
    $lodemas =  $lodemas+ $row3['cantt'];
  }
  $vi=$vi+1;
}
    $vlblgraf1=$vlblgraf1."'Others'";
    $vdatgraf1=$vdatgraf1."".$lodemas;


    $query_listagraf2a = "select modelciu, sum(distinct quantity) as cantt
    from 
    (
      select distinct orders.idorders, modelciu, quantity 
               from orders         
               inner join fnt_select_allproducts_maxrev() as  products
               on products.idproduct = orders.idproduct
               where orders.active = 'Y' and  orders.typeregister='SO'  ". $sumowhere.$sumowhere2."
    ) as ssss
    group by modelciu
    order by cantt desc,modelciu ";
//  echo $query_listagraf2a ;

$data2 = $connect->query($query_listagraf2a)->fetchAll();	

    $vlblgraf2="";
    $vdatgraf2="";
    $lodemas2 =0;   
    $vi=1;
    foreach ($data2 as $row4) 
      {
        if ($vi<8)
        {
          $vlblgraf2=$vlblgraf2."'".$row4['modelciu']."',";
          $vdatgraf2=$vdatgraf2."".$row4['cantt'].",";
        }
        else
        {
          $lodemas2 =  $lodemas2+ $row4['cantt'];
        }
        $vi=$vi+1;
      }
      $vlblgraf2=$vlblgraf2."'Others'";
      $vdatgraf2=$vdatgraf2."".$lodemas2;

           $query_lista = " 
           select namecustomers, sum(quantity) as cantt, count(distinct idproduct) as cantt2, sum( distinct quantity) as cant3
          from (
           select distinct orders.idcustomers, customers.namecustomers,   orders.idproduct ,   quantity
                     from orders
                     inner join orders_sn
                     on orders.idorders = orders_sn.idorders
                     inner join customers
                     on customers.idcustomers = orders.idcustomers
                     where  orders.active = 'Y' and  orders.typeregister='SO' ". $sumowhere.$sumowhere2."  
             
            ) as tttt
            group by namecustomers
          order by cantt desc";
          
           // echo $query_lista ;
           
           $data = $connect->query($query_lista)->fetchAll();	
           ?>
           	<div class="container">
             <h5 class="mt-4 mb-2"> <b>Sales by Customers</b></h5>
             <div  >
																	  <canvas id="grafico-chart1" height="200"></canvas>
																	</div>
            <br>
           <table class="table table-striped table-bordered table-sm dataTable no-footer" name="tblfilter0" id="tblfilter0" role="grid" aria-describedby="tblfilter0_info">
           
           <thead>
           <tr>
           <th class="bg-primary "> Customers </th>
           <th class="bg-primary "> CIU </th>
           <th class="bg-primary "> Quantity </th>
 
            
           </tr>
           </thead>
           <tbody>
           <?php
             foreach ($data as $row2) 
             {
            $indxtablaadd=0;
               ?>
          
              <?php						
               echo "<tr><td>".$row2['namecustomers'] ."</td>";  
               echo "<td>".$row2['cantt2']."</td>";
               echo "<td>".$row2['cantt']."</td>  </tr>";
             }
          
          ?>
            </tbody>
          </table>
          </div>
				</div>
			</div>
					

        </section>
		<section class="col-lg-4 connectedSortable ui-sortable">
                                  

				<div class="card">
				<div class="card-header ui-sortable-handle"  >
               		
		 
        <?php
           $query_listaaaa = "select namebranch , modelciu, sum(quantity) as cantt
           from 
           (
             select  distinct public.full_tree_namever_allbusiness(iduniquebranchsonprod, '') as namebranch,  orders.idorders, modelciu, quantity 
                      from orders         
                      inner join fnt_select_allproducts_maxrev() as  products
                      on products.idproduct = orders.idproduct
                      where orders.active = 'Y' and  orders.typeregister='SO' ". $sumowhere.$sumowhere2." 
                    
           ) as ssss
           where namebranch<>''
           group by namebranch, modelciu
           order by cantt desc,modelciu";
          
         //   echo $query_listaaaa ;
           $vlblgraf3="";
           $vdatgraf3="";
           $data22 = $connect->query($query_listaaaa)->fetchAll();	
           ?>
           	<div class="container">
             <h5 class="mt-4 mb-2"> <b>Quantity Units by CIU</b></h5>
             <div >
																	  <canvas id="grafico-chart2" height="200"></canvas>
																	</div>
            <br>
           <table class="table table-striped table-bordered table-sm  " name="tblfilter1" id="tblfilter1" role="grid" >
           
           <thead>
           <tr>
           <th class="bg-primary "> Branchs </th>
           <th class="bg-primary "> Units </th>
           <th class="bg-primary "> Quantity </th>
 
            
           </tr>
           </thead>
           <tbody>
           <?php
             foreach ($data22 as $row2) 
             {
            $indxtablaadd=0;
               ?>
          
              <?php						
               echo "<tr><td>".$row2['namebranch'] ."</td>";  
               echo "<td>".$row2['modelciu'] ."</td>";  
               echo "<td>".$row2['cantt']."</td>  </tr>";
             }
          
          ?>
            </tbody>
          </table>
          </div>
           
				  
              
				</div>	
				</div>	
		 </section>

     <section class="col-lg-4 connectedSortable ui-sortable">
                                  

                                  <div class="card">
                                  <div class="card-header ui-sortable-handle"  >
                                             
                               
                                  <?php
                                     $query_lista5 = "select namebranch,  count(distinct modelciu) as cantt, 
                                     sum(  quantity) as cant2t
                                     from 
                                     (
                                       select distinct public.full_tree_namever_allbusiness(iduniquebranchsonprod, '') as namebranch, orders.idorders, modelciu, quantity 
                                                from orders         
                                                inner join fnt_select_allproducts_maxrev() as products
                                                on products.idproduct = orders.idproduct
                                                where orders.active = 'Y' and  orders.typeregister='SO'  ". $sumowhere.$sumowhere2." 
                                           
                                     ) as ssss
									 where namebranch<>''
                                     group by namebranch 
                                     order by cantt desc
                                     ";
                                    
                         //            echo "Ojo.".$query_lista5 ;
                                     
                                     $data5 = $connect->query($query_lista5)->fetchAll();	
                                     ?>
                                       <div class="container">
                                       <h5 class="mt-4 mb-2"> <b>Quantity Units By Branch</b></h5>
                                       <div >
                                                              <canvas id="grafico-chart3" height="200"></canvas>
                                                            </div>
                                      <br>
                                     <table class="table table-striped table-bordered table-sm  " name="tblfilter2" id="tblfilter2" role="grid" >
                                     
                                     <thead>
                                     <tr>
                                     <th class="bg-primary "> Branch </th>
                                  
                                     <th class="bg-primary "> Quantity </th>
                           
                                      
                                     </tr>
                                     </thead>
                                     <tbody>
                                     <?php
                                      $vlblgraf3="";
                                      $vdatgraf3="";
                                      $lodemas3="";
                                      $vi=1;
                                       foreach ($data5 as $row5) 
                                       {
                                      $indxtablaadd=0;

                                      if ($vi<5)
                                      {
                                        $vlblgraf3=$vlblgraf3."'".$row5['namebranch']."',";
                                        $vdatgraf3=$vdatgraf3."".$row5['cant2t'].",";
                                      }
                                      else
                                      {
                                        $lodemas3 =  $lodemas3+ $row5['cant2t'];
                                      }
                                      $vi=$vi+1;
                                         ?>
                                    
                                        <?php						
                                         echo "<tr><td>".$row5['namebranch'] ."</td>";  
                                  
                                         echo "<td>".$row5['cant2t']."</td>  </tr>";
                                       }
                                       $vlblgraf3=$vlblgraf3."'Others'";
                                       $vdatgraf3=$vdatgraf3."".$lodemas3;
                                    
                                    ?>
                                      </tbody>
                                    </table>
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

<script type="text/javascript" src="js/tabulator.min.js"></script>

<script src="plugins/datatables/jquery.dataTables.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script src="plugins/chart.js/Chart.min.js"></script>
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

        $(function() {

var start = moment().subtract(29, 'days');
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

       $('#tblfilter0').DataTable({searching: true, paging: true, info: false, pageLength: 20,  order: [[ 2, "desc" ]]} );
       $('#tblfilter1').DataTable({searching: true, paging: true, info: false, pageLength: 20,  order: [[ 2, "desc" ]]} );
       $('#tblfilter2').DataTable({searching: true, paging: true, info: false, pageLength: 20,  order: [[ 1, "desc" ]]} );
                                	
       grafica1();
	});
	

	// controlar inactividad en la web	
		$(document).inactivityTimeout({
                inactivityWait: 10000,
                dialogWait: 10,
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

 

   function grafica1()
   {

 

    var grafico1chart = $('#grafico-chart1').get(0).getContext('2d'); 
    var grafico2chart = $('#grafico-chart2').get(0).getContext('2d');
    var grafico3chart = $('#grafico-chart3').get(0).getContext('2d');
    

  //  var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
  /*
   $vlblgraf1=$vlblgraf1.",Others";
    $vdatgraf1=$vdatgraf1.",".$lodemas;
    */
    var donutData1        = {
      labels: [<?php echo $vlblgraf1; ?> ],
      datasets: [
        {
          data: [<?php echo $vdatgraf1; ?>],
          backgroundColor : [ '#f39c12', '#00c0ef', '#3c8dbc','#f56954', '#00a65a', '#d2d6de', '#3399ff', '#993333'],
        }
      ]
    }

    var donutData2        = {
      labels: [<?php echo $vlblgraf2; ?> ],
      datasets: [
        {
          data: [<?php echo $vdatgraf2; ?>],
          backgroundColor : ['#00c0ef', '#f56954', '#00a65a', '#f39c12', '#3c8dbc', '#d2d6de', '#3399ff', '#993333'],
        }
      ]
    }

    
    var donutData3       = {
      labels: [<?php echo $vlblgraf3; ?> ],
      datasets: [
        {
          data: [<?php echo $vdatgraf3; ?>],
          backgroundColor : ['#00c0ef', '#f56954', '#00a65a', '#f39c12', '#3c8dbc', '#d2d6de', '#3399ff', '#993333'],
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
    var donutChart2 = new Chart(grafico2chart, {
      type: 'doughnut',
      data: donutData2,
      options: donutOptions      
    })

    var donutChart3 = new Chart(grafico3chart, {
      type: 'doughnut',
      data: donutData3,
      options: donutOptions      
    })


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


   function reportarme()
{
	var elscr = $("#losscripts").val();
	var txtfechad = $("#txtfechad").val();
	var txtfechah = $("#txtfechah").val();
	if (elscr =='' || txtfechad == '' )
	{
		toastr["error"]("Missing select parameters to generate the report", "Error...");	
	}
	else
	{
		toastr["success"]("...Wait..", "Working");		
    document.getElementById("frma").submit();

  }
}

$('#reportrange').on('apply.daterangepicker', function(ev, picker) {
  console.log(picker.startDate.format('YYYY-MM-DD'));
  $("#txtfechad").val(picker.startDate.format('YYYY-MM-DD'));
  $("#txtfechah").val(picker.endDate.format('YYYY-MM-DD'));
  console.log(picker.endDate.format('YYYY-MM-DD'));
});
   
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
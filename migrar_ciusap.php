<!DOCTYPE html>
<?php 

// Desactivar toda notificación de error
//error_reporting(0);
// Notificar todos los errores de PHP (ver el registro de cambios)
error_reporting(E_ALL);
 include("db_conect.php"); 
 error_reporting(E_ALL);
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


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Template web</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">template web</li>
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
			<p name="msjwaitline" id="msjwaitline" align="center"><img src="img/waitazul.gif" width="100px" ></p>	
				<div class="card">
          Migrandooo.....<br>
          1 - Replicamos los CIU Faltantes...<br>
					<?php

///Primero migramos todos los I.. para completar los Ciu faltantes..
/*

$sql = $connect->prepare("  select * from tmp_ciu_partnumber where iguales = 'I' ");
      
$sql->execute();
$resultado = $sql->fetchAll();
$idcantrow=1;
foreach ($resultado as $row)
 {
 echo "<br>-->".$row['skufiplex']." -Replico a: ".$row['modelciu'];
 $modelciu_from=$row['skufiplex'];
 $modelciu_to=$row['modelciu'];

 $idbusiness = $row['idbusiness'];


          try {
            $query_1=" call sp_replica_ciu_sapmarco('".$modelciu_from."','".$modelciu_to."',".$idbusiness.") ; ";
            echo $query_1."<br>";
            $dataiscuu = $connect->query($query_1)->fetchAll();		


            $query_1=" call sp_replica_ciu_fas_routines_references('".$modelciu_from."','".$modelciu_to."') ";
            $dataiscuu = $connect->query($query_1)->fetchAll();		


          //   echo "<br>".$query_1;
            $query_2=" call sp_replica_ciu_fas_routines_process('".$modelciu_from."','".$modelciu_to."') ";
            $dataiscuu = $connect->query($query_2)->fetchAll();		
          //   echo "<br>".$query_2;

            $query_2=" call sp_replica_ciu_fas_confidential_fw('".$modelciu_from."','".$modelciu_to."') ";
            $dataiscuu = $connect->query($query_2)->fetchAll();		
          //    echo "<br>".$query_2;
            $query_2=" call sp_replica_ciu_fas_routines_product('".$modelciu_from."','".$modelciu_to."') ";
            $dataiscuu = $connect->query($query_2)->fetchAll();		
          //   echo "<br>".$query_2;
            $query_2=" call sp_replica_ciu_fas_script_setup('".$modelciu_from."','".$modelciu_to."') ";
            $dataiscuu = $connect->query($query_2)->fetchAll();		
          //    echo "<br>".$query_2;
            $query_2=" call sp_replica_ciu_fas_tree_product('".$modelciu_from."','".$modelciu_to."') ";
          //   echo "<br>".$query_2;
            $dataiscuu = $connect->query($query_2)->fetchAll();		

            $query_2=" call sp_replica_ciu_objectband('".$modelciu_from."','".$modelciu_to."') ";
            $dataiscuu = $connect->query($query_2)->fetchAll();		
          //   echo "<br>".$query_2;
            $query_2=" call sp_replica_ciu_products_attributes('".$modelciu_from."','".$modelciu_to."') ";
            $dataiscuu = $connect->query($query_2)->fetchAll();		
          //   echo "<br>".$query_2;
            $query_2=" call sp_replica_ciu_products_label('".$modelciu_from."','".$modelciu_to."') ";
            $dataiscuu = $connect->query($query_2)->fetchAll();		
          //    echo "<br>".$query_2;
            $query_2=" call sp_replica_ciu_products_printlbl('".$modelciu_from."','".$modelciu_to."') ";
            $dataiscuu = $connect->query($query_2)->fetchAll();		
          //    echo "<br>".$query_2;
            $query_2=" call sp_replica_ciu_tree_ref_instrum('".$modelciu_from."','".$modelciu_to."') ";
            $dataiscuu = $connect->query($query_2)->fetchAll();		
          //    echo "<br>".$query_2;
            

              $sqlciu1 = $connect->prepare("  select * from products where modelciu in ('".$modelciu_from."','".$modelciu_to."')	");
          
              $sqlciu1->execute();
              $resultadocuis = $sqlciu1->fetchAll();
              $idcantrow=1;
              $idciufrom =  0;
              $idciuto=0;
              foreach ($resultadocuis as $rowcius)
              {
                if ( $rowcius['modelciu']== $modelciu_from)
                {
                    $idciufrom =  $rowcius['idproduct'];
                }
                if ( $rowcius['modelciu']== $modelciu_to)
                {
                  $idciuto =  $rowcius['idproduct'];
                }
              }

          ////////////// REPLICAMOS OUT COME
            $query_2recursive=" select replicate_income_integral_allidtype0(0,". $idciufrom.",".  $idciuto.",0) ";
            $dataiscuu = $connect->query($query_2recursive)->fetchAll();		
            echo "<br>".$query_2recursive;


            $query_res1="update tmp_ciu_partnumber set resultmigration='ok' where modelciu='".$modelciu_from."'   ";

            $dataiscuu = $connect->query($query_res1)->fetchAll();		

          } catch (Exception $e) {
            echo '<br>Caught exception: ',  $e->getMessage(), "\n";

            $vowels = array("'", "<", ">", "/",'"');
            $error_details = str_replace($vowels, "", $e->getMessage());          


            $query_res1="update tmp_ciu_partnumber set resultmigration='".$error_details."' where modelciu='".$modelciu_from."'   "; 
            echo $query_res1;                   
            $dataiscuu = $connect->query($query_res1)->fetchAll();	
          }
        }
        */
        
echo "<br><br>2. Paso.. replicamos para los part number SAP<br>";
     
     $sql = $connect->prepare("select * from tmp_ciu_partnumber where modelciu<>partnumbersap and partnumbersap <> '' and idbusiness is not null and resultmigration is null limit 500	");
      
                     $sql->execute();
                     $resultado = $sql->fetchAll();
                     $idcantrow=1;
                     foreach ($resultado as $row)
                      {
                      echo "<br>-->".$row['modelciu']." -Replico a: ".$row['partnumbersap'];
                      $modelciu_from=$row['modelciu'];
                      $modelciu_to=$row['partnumbersap'];

                      $idbusiness = $row['idbusiness'];
                    

                      try {
                        $query_1=" call sp_replica_ciu_sapmarco('".$modelciu_from."','".$modelciu_to."',".$idbusiness.") ; ";
                        echo $query_1."<br>";
                        $dataiscuu = $connect->query($query_1)->fetchAll();		

                        $query_1=" call sp_replica_ciu_fas_routines_references('".$modelciu_from."','".$modelciu_to."') ";
                        $dataiscuu = $connect->query($query_1)->fetchAll();		
                  
              
                     //   echo "<br>".$query_1;
                        $query_2=" call sp_replica_ciu_fas_routines_process('".$modelciu_from."','".$modelciu_to."') ";
                       $dataiscuu = $connect->query($query_2)->fetchAll();		
                     //   echo "<br>".$query_2;
                   
                        $query_2=" call sp_replica_ciu_fas_confidential_fw('".$modelciu_from."','".$modelciu_to."') ";
                        $dataiscuu = $connect->query($query_2)->fetchAll();		
                    //    echo "<br>".$query_2;
                        $query_2=" call sp_replica_ciu_fas_routines_product('".$modelciu_from."','".$modelciu_to."') ";
                        $dataiscuu = $connect->query($query_2)->fetchAll();		
                     //   echo "<br>".$query_2;
                        $query_2=" call sp_replica_ciu_fas_script_setup('".$modelciu_from."','".$modelciu_to."') ";
                        $dataiscuu = $connect->query($query_2)->fetchAll();		
                    //    echo "<br>".$query_2;
                        $query_2=" call sp_replica_ciu_fas_tree_product('".$modelciu_from."','".$modelciu_to."') ";
                     //   echo "<br>".$query_2;
                        $dataiscuu = $connect->query($query_2)->fetchAll();		
                     
                        $query_2=" call sp_replica_ciu_objectband('".$modelciu_from."','".$modelciu_to."') ";
                        $dataiscuu = $connect->query($query_2)->fetchAll();		
                     //   echo "<br>".$query_2;
                        $query_2=" call sp_replica_ciu_products_attributes('".$modelciu_from."','".$modelciu_to."') ";
                        $dataiscuu = $connect->query($query_2)->fetchAll();		
                     //   echo "<br>".$query_2;
                        $query_2=" call sp_replica_ciu_products_label('".$modelciu_from."','".$modelciu_to."') ";
                        $dataiscuu = $connect->query($query_2)->fetchAll();		
                    //    echo "<br>".$query_2;
                        $query_2=" call sp_replica_ciu_products_printlbl('".$modelciu_from."','".$modelciu_to."') ";
                        $dataiscuu = $connect->query($query_2)->fetchAll();		
                    //    echo "<br>".$query_2;
                        $query_2=" call sp_replica_ciu_tree_ref_instrum('".$modelciu_from."','".$modelciu_to."') ";
                        $dataiscuu = $connect->query($query_2)->fetchAll();		
                    //    echo "<br>".$query_2;
                        
              
              ////////////// REPLICAMOS OUT COME

              $sqlciu1 = $connect->prepare("  select * from products where modelciu in ('".$modelciu_from."','".$modelciu_to."')	");
          
              $sqlciu1->execute();
              $resultadocuis = $sqlciu1->fetchAll();
              $idcantrow=1;
              $idciufrom =  0;
              $idciuto=0;
              foreach ($resultadocuis as $rowcius)
              {
                if ( $rowcius['modelciu']== $modelciu_from)
                {
                    $idciufrom =  $rowcius['idproduct'];
                }
                if ( $rowcius['modelciu']== $modelciu_to)
                {
                  $idciuto =  $rowcius['idproduct'];
                }
              }


                        $query_2recursive=" select replicate_income_integral_allidtype0(0,".$idciufrom.",".$idciuto.",0) ";
                        $dataiscuu = $connect->query($query_2recursive)->fetchAll();		
                        echo "<br>".$query_2recursive;


                        $query_res1="update tmp_ciu_partnumber set resultmigration='ok' where modelciu='".$modelciu_from."'   ";
                    
                        $dataiscuu = $connect->query($query_res1)->fetchAll();		

                    } catch (Exception $e) 
                    {
                        echo '<br>Caught exception: ',  $e->getMessage(), "\n";

                        $vowels = array("'", "<", ">", "/",'"');
                        $error_details = str_replace($vowels, "", $e->getMessage());

                   

                        $query_res1="update tmp_ciu_partnumber set resultmigration='".$error_details."' where modelciu='".$modelciu_from."'   "; 
                        echo $query_res1;                   
                        $dataiscuu = $connect->query($query_res1)->fetchAll();	
                    }



                     }
 
          
          ?>
				</div>
			</div>
					

        </section>
		<section class="col-lg-6 connectedSortable ui-sortable">
		

				<div class="card">
				<div class="card-header ui-sortable-handle" style="cursor: move;">
               		
				<div class="card">
              <div class="card-header">
                <h3 class="card-title"> <i class="fa fa-fw fa-list-alt"></i>Log Details :: </h3>
							<i class="fa fa-fw fa-user"></i> <label  name="lblvuser" id="lblvuser"> </label>
							<i class="fa fa-fw fa-tv"></i> <label  name="lblvdevice" id="lblvdevice"> </label>
							<i class="fa fa-fw fa-inbox"></i> <label  name="lblvstationr" id="lblvstationr"> </label>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0" style="display: block;">
                <div class="d-md-flex">
                  <div class="p-1 flex-fill" style="overflow: hidden" >
                    <textarea class="form-control form-controltamanio" rows="18" id="detallelog" name="detallelog"></textarea>
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
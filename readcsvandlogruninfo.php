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
                                <h1>Read CSV - Search LOG</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">Read CSV - Search LOG</li>
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
                                    <p name="msjwaitline" id="msjwaitline" align="center"><img src="img/waitazul.gif"
                                            width="100px"></p>
                                    <div class="card">



                                        <?php

                                        // Debemos incluir la libreria
                                        require_once 'PHPExcel/Classes/PHPExcel.php';
                                        $archivo = "WMATA10192023.xlsx";
                                        $inputFileType = PHPExcel_IOFactory::identify($archivo);
                                        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                                        $objPHPExcel = $objReader->load($archivo);
                                        $sheet = $objPHPExcel->getSheet(0); 
                                        $highestRow = $sheet->getHighestRow(); 
                                        $highestColumn = $sheet->getHighestColumn();                                  

                                      ?>
                                        File: <?php echo  $archivo;
                                        
                                        ?>
                                        <table class="table table-bordered table-sm">
                                            <thead>
                                                <tr>
                                                    <th>#</th>


                                                    <?php
                                          
                                     
                                                ?>

                                                    <?php
                                                $num=0;
                                                $letras=65;
                                                $arrayheaders = array();
                                                for ($row = 1; $row <= 1; $row++)
                                                { 
                                                     

                                                      for($col = 'A'; $col <= $highestColumn; $col++){
                                                        $cell = $sheet->getCellByColumnAndRow($col, $row);
                                                        $colIndex = PHPExcel_Cell::columnIndexFromString($cell->getColumn());
                                                      //   echo "<br>".chr($letras);
                                                       //  echo "a:".$sheet->getCell(chr($letras)."1")->getValue();
                                                     
                                                         echo "  <th>".$sheet->getCell(chr($letras)."1")->getValue()."</th>";
                                                         array_push($arrayheaders, $sheet->getCell(chr($letras)."1")->getValue());
                                                         $letras = $letras + 1;
                                                   }

                                                }
                                                ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php

                                           //     var_dump($arrayheaders);
                                            //   exit();

                                            /*    foreach ($arrayheaders as &$value) {
                                                   echo "<br>array:".$value;
                                              }*/


                                           
                                                for ($row = 2; $row <= $highestRow; $row++){ $num++;?>
                                                <tr>
                                                    <th scope='row'><?php echo $num;?></th>
                                                    <?php
                                                    $letras=65;

//echo "8888 insert into matiaswmata19102023 values (". $num.",'".$sheet->getCell("A".$row)->getValue()."','".$sheet->getCell("B".$row)->getValue()."','".$sheet->getCell("C".$row)->getValue()."','".$sheet->getCell("D".$row)->getValue()."','".$sheet->getCell("E".$row)->getValue()."','".$sheet->getCell("F".$row)->getValue()."','".$sheet->getCell("H".$row)->getValue()."','','')";
//$callsqlii = " insert into matiaswmata19102023 values (". $num.",'".$sheet->getCell("A".$row)->getValue()."','".$sheet->getCell("B".$row)->getValue()."','".$sheet->getCell("C".$row)->getValue()."','".$sheet->getCell("D".$row)->getValue()."','".$sheet->getCell("E".$row)->getValue()."','".$sheet->getCell("F".$row)->getValue()."','".$sheet->getCell("H".$row)->getValue()."','','');";
//echo $callsqlii;
 // $connect->query($callsqlii)->fetchAll();
 




                                                    foreach ($arrayheaders as &$value) {
                                                   //   echo "<br>array:".$value;
                                                      $pos = strpos($value, "#");
                                                      if ($pos === false) {
                                                        ?>
                                                    <td><?php   echo $sheet->getCell(chr($letras).$row)->getValue();?>
                                                    </td>
                                                    <?php
                                                             $letras = $letras + 1;
                                                    } else {
                                                        //// Buscamoss cat y type
                                                      
                                                                $letras = $letras + 1;
                                                                 $splicattipo = explode("#", $value  );

                                                        
                                                                      $callsql= " select fnt_select_excel_info_by_textinlog ('".$sheet->getCell("F".$row)->getValue() ."','".$sheet->getCell("H".$row)->getValue() ."','". $splicattipo[1]."')";
                                                        //         echo "<br>".$callsql;
                                                        
                                                        
                                                                     $datadetect = $connect->query($callsql)->fetchAll();
                                                                     $datos="";
                                                                     $infoamostrar="";
                                                                      foreach ($datadetect as $rowdetect) 
                                                                      {
                                                                          //  echo " ".$rowdetect[0]." ";
                                                                            $datos = json_decode($rowdetect[0]);
                                                                          //  echo "<br>aaaaaaaaaaaa".$datos->positionfw;
                                                                            //echo "<br>aaaaaaaaaaaa".substr($datos->loginfo,$datos->positionfw-1,25);
                                                                            $infoamostrar =substr($datos->loginfo,$datos->positionfw-1,15);
                                                                            
                                                                      }
                                                                      
                                                                      ?>
                                                    <td><?php  
                                                     if ( $splicattipo[1]=="FPGA")
                                                     {
                                                     
                                                         //   $infoamostrar = str_replace("FPGA FW:", "",  $infoamostrar);
                                                            $sqlupdatetable= "update matiaswmata19102023 set  fpgafw  = '". trim($infoamostrar)."' where idwmata = ".$num;
                                                          //  echo  $sqlupdatetable;
                                                            $connect->query($sqlupdatetable)->fetchAll();
                                                       
                                                     }
                                                     if ( $splicattipo[1]=="uC")
                                                     {
                                                     
                                                      //      $infoamostrar = str_replace("uC FW:", "",  $infoamostrar);
                                                            $sqlupdatetable= "update matiaswmata19102023 set  ucfw  = '". trim($infoamostrar)."' where idwmata = ".$num;
                                                        //    echo  $sqlupdatetable;
                                                            $connect->query($sqlupdatetable)->fetchAll();
                                                       
                                                     }

                                                    echo $infoamostrar;

                                                 ?>
                                                    </td>
                                                    <?php
                                                    }


                                                    }
                                                  
                                                  ?>


                                                </tr>
                                                <?php 
                                          //    exit();
                                                } 
                                                ?>
                                            </tbody>
                                        </table>

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

});


// controlar inactividad en la web	
$(document).inactivityTimeout({
    inactivityWait: 10000,
    dialogWait: 10,
    logoutUrl: 'logout.php'
})
// fin controlar inactividad en la web		

/* requesting data */
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
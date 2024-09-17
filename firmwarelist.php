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

          $sessionTTL = time() - $_SESSION["timeout"];
    //		echo "***********hola".time() - $_SESSION["timeout"]."----".$sessionTTL."--inactividad:".$inactividad."-timeout". $_SESSION["timeout"] ;
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
	
	
   <link rel="stylesheet" href="themestreecss/default2/style.css">

   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
	
<style>
	body
  {
    font-family: Arial, Helvetica, sans-serif;
    font-size:12px;
  }

  .contenedorFirmware {
      overflow: auto;
      height: 400px;
      border: 10px solid #ccc;
  }

  .contenidoFirmware {
    width: 100%;
      display: inline-block;
      padding: 0px 10px 10px 10px;
  }


  .expandable td {
      padding: 10px;
      border-top: 1px solid #ddd;
  }
  #rowsFirmware:hover{
      background-color: #fff;
      cursor: pointer;
  }
  .menu-desplegable {
      margin-bottom: 20px;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 5px;
  }

  .menu-desplegable h3 {
      margin-top: 0;
  }

  .menu-desplegable form {
      margin-bottom: 10px;
  }

  .box {
    background: white;
    margin: auto;
    width: 80%;
    border: 20px solid #ddd;
  }

  .actionfinish {
    padding-left: 15px;
    padding-right: 15px;
    border: none;
    height: 50px;
    font-size: 20px;
    background: #2d6eac;
    color: white;
    border-radius: 30px;
  }

  .Addinput{
    width: 200px;
  }

  .inputT {
      font-size: 20px;
      font-weight: bold;
      margin-bottom: 0px;

  }

  .inputD{
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 10px;
  }

  .addTitle{
    margin-top: 50px;
  }

  .modinput{
    width: 200px;
    background: #ccc;
  }

  .modinput.modified {
    background-color: white;
  }

  .files, .fases, .description {
    display: flex;
    flex-direction: row;
    justify-content: center;
    gap: 10px;
  }

  #headertable {
    height: 30px;
    position: -webkit-sticky;
    position: sticky;
    background-color: #fff;
    top: 0;
    z-index: 1;
    font-size: 16px;
  }

  .barra{
    gap: 30%;
    display: flex;
    flex-direction: row;
    justify-content: space-around;
    align-items: center;
    height: 50px;
  }

  #searchbar{
    margin-left: -50%;
    padding-left: 60%;
    padding-right: 10%;
    height: 30px;
  }

  .check {
    margin-top: 5px;
    height: 15px;
    width: 15px;
  }

  .extra {
      padding-top: 10px;
      display: flex;
      align-items: center;
  }

  .extracomp {
      margin-right: 20px;
  }

  .extracomp:last-child {
      margin-right: 0;
  }

  #modifyblock {
    display: none;
  }

  #addblock {
    display: none;
  }

  .mypopup {
      display: inline;
      flex-direction: column;
      justify-content: center;
      align-items: center;
  }

  .swal2-validation-message{
    display: none;
  }

  .swal2-container{
    background: #cccccca0;
  }
</style>
</head>
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
<form name="frmlabeling" id="frmlabeling"  method="post"  class="form-horizontal needs-validation"  >							
				

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Firmware List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">
Firmware List</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <?php
        // History of Firmware
        //FIXME: Change connection
        $connection = pg_connect("host=localhost dbname=dbfiplex user=postgres password=Cajal69709901");
        if(!$connection){
          echo "Connection error<br>";
          exit;
        }
        $viewFirm = pg_query($connection, "SELECT * FROM fas_firmwarelist ORDER BY idfas_firmwarelist, idrev;");
        if(!$viewFirm){
          echo "Table error<br>";
          exit;
        }
        ?>
		
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<div class="card ">							
			 <div class="container-fluid">
			         <div class="barra  border-0">
                <div>
                  <h3 class="card-title"><span name="iconolog" id="iconolog"><i class="fa fa-fw fa-list-alt"></i></span> Firmware History </h3>
                </div>
                <div>
                  <form action="" method="post">
                    <input type="text" id="searchbar" placeholder=" &#128269; Search " onkeyup="searchFirmware()">
                  </form>
                </div>
                <div id="agregarboton">
                  <form action="" method="post">
                    <input type="button" class="btn btn-outline-primary btn-sm" id="addbutton" value=" Add Firmware ">
                  </form>
                </div>
                
						
									
						
					</div>
          <div id="firmwareTable">
				  <div class="contenedorFirmware">
            <div class="contenidoFirmware">
              <table class="table table-bordered table-striped table-sm">
                <thead>
                  <tr id="headertable">
                    <th>ID</th>
                    <th>Version</th>
                    <th>Firmware name</th>
                    <th>Fpga file</th>
                    <th>Micro file</th>
                    <th>Ethernet file</th>
                    <th>Fpga fas</th>
                    <th>Micro fas</th>
                    <th>Ethernet fas</th>
                    <th>Active</th>
                  </tr>
                </thead>
                <tbody>
                      <?php
                        while($row = pg_fetch_assoc($viewFirm)){
                          $id = is_numeric($row['idfas_firmwarelist']) ? htmlspecialchars($row['idfas_firmwarelist']) : 'N/A';
                          $namefirmware = !empty($row['namefirmware']) ? htmlspecialchars($row['namefirmware']) : 'N/A';
                          $idrev = is_numeric($row['idrev']) ? htmlspecialchars($row['idrev']) : 'N/A';
                          $fpga_file = !empty($row['fpga_file']) ? htmlspecialchars($row['fpga_file']) : 'N/A';
                          $micro_file = !empty($row['micro_file']) ? htmlspecialchars($row['micro_file']) : 'N/A';
                          $eth_file = !empty($row['eth_file']) ? htmlspecialchars($row['eth_file']) : 'N/A';
                          $fpga_fas = !empty($row['fpga_fas']) ? htmlspecialchars($row['fpga_fas']) : 'N/A';
                          $micro_fas = !empty($row['micro_fas']) ? htmlspecialchars($row['micro_fas']) : 'N/A';
                          $eth_fas = !empty($row['eth_fas']) ? htmlspecialchars($row['eth_fas']) : 'N/A';
                          $active = !empty($row['active']) ? htmlspecialchars($row['active']) : 'N/A';
                          $calrstring = !empty($row['calrstring']) ? htmlspecialchars($row['calrstring']) : '';
                          $fpga_description = !empty($row['fpga_description']) ? htmlspecialchars($row['fpga_description']) : '';
                          $uc_description = !empty($row['uc_description']) ? htmlspecialchars($row['uc_description']) : '';
                          $eth_description = !empty($row['eht_description']) ? htmlspecialchars($row['eht_description']) : '';
                          echo "
                          <tr id='rowsFirmware' ondblclick='toggleRow(this)'>
                          <th scope='row'>{$id}</th>
                            <td>{$idrev}</td>
                            <td>{$namefirmware}</td>
                            <td>{$fpga_file}</td>
                            <td>{$micro_file}</td>
                            <td>{$eth_file}</td>
                            <td>{$fpga_fas}</td>
                            <td>{$micro_fas}</td>
                            <td>{$eth_fas}</td>
                            <td>{$active}</td>
                          </tr>
                          <tr class='expandable' style='display: none;'>
                          <td colspan='11'>
                          <strong>Extra Information</strong><br>
                          Calibration string : {$calrstring}<br>
                          Datetime created: {$row['datetimemodif']}<br>";
                          if(!empty($fpga_description)){
                            echo "Fpga description: {$fpga_description}<br>"; 
                            }
                            if(!empty($uc_description)){
                              echo "Uc description: {$uc_description}<br>"; 
                              }
                              if(!empty($eth_description)){
                                echo "Ethernet description: {$eth_description}<br>"; 
                                }
                                
                                echo "
                                <div id='expanddelete' class='extra'>
                                <div class='extracomp'>
                                <form id='delete' action='delfirmwarelist.php' method='POST' data_name='{$namefirmware}' data_idrev='{$idrev}'>
                                <input type='button' class='deletebutton btn btn-outline-danger btn-sm' value=' Delete '>
                                </form>
                                </div>
                                <div class='extracomp'>
                                <form id='modify' action='modfirmwarelist.php' method='POST' 
                                data_name='{$namefirmware}' data_idrev='{$idrev}' 
                                data_idfirm='{$id}' data_fpga_file='{$fpga_file}' 
                                data_micro_file='{$micro_file}' data_eth_file='{$eth_file}' 
                                data_fpga_fas='{$fpga_fas}' data_micro_fas='{$micro_fas}' 
                                data_eth_fas='{$eth_fas}' data_active='{$active}' 
                                data_calrstring='{$calrstring}' data_fpga_description='{$fpga_description}' 
                                data_uc_description='{$uc_description}' data_eth_description='{$eth_description}'>
                                <input type='button' class='modifybutton btn btn-outline-info btn-sm' value=' Modify '>
                                </form>
                                </div>
                                </div>
                                </td>
                                </tr>
                                <tr></tr>
                                ";
                              }
                              ?>
                </tbody>
              </table>															
            </div>
					</div>
        </div>
      </div>
    </div>
    <div id="modifyblock"></div>
    <div id="addblock"></div>
    <?php
            // ADD RUN

            if(isset($_POST['add_confirm'])){
              $addnameFirmware = isset($_POST['nameFirmware']) ? trim(filter_input(INPUT_POST, 'nameFirmware', FILTER_SANITIZE_SPECIAL_CHARS)) : '';
              $addfpga_file = isset($_POST['fpga_file']) ? trim(filter_input(INPUT_POST, 'fpga_file', FILTER_SANITIZE_SPECIAL_CHARS)) : '';
              $addmicro_file = isset($_POST['micro_file']) ? trim(filter_input(INPUT_POST, 'micro_file', FILTER_SANITIZE_SPECIAL_CHARS)) : '';
              $addeth_file = isset($_POST['eth_file']) ? trim(filter_input(INPUT_POST, 'eth_file', FILTER_SANITIZE_SPECIAL_CHARS)) : '';
              $addfpga_fas = isset($_POST['fpga_fas']) ? trim(filter_input(INPUT_POST, 'fpga_fas', FILTER_SANITIZE_SPECIAL_CHARS)) : '';
              $addmicro_fas = isset($_POST['micro_fas']) ? trim(filter_input(INPUT_POST, 'micro_fas', FILTER_SANITIZE_SPECIAL_CHARS)) : '';
              $addeth_fas = isset($_POST['eth_fas']) ? trim(filter_input(INPUT_POST, 'eth_fas', FILTER_SANITIZE_SPECIAL_CHARS)) : '';
              $addcalrstring = isset($_POST['calrstring']) ? trim(filter_input(INPUT_POST, 'calrstring', FILTER_SANITIZE_SPECIAL_CHARS)) : '';
              $addfpga_description = isset($_POST['fpga_description']) ? trim(filter_input(INPUT_POST, 'fpga_description', FILTER_SANITIZE_SPECIAL_CHARS)) : '';
              $adduc_description = isset($_POST['uc_description']) ? trim(filter_input(INPUT_POST, 'uc_description', FILTER_SANITIZE_SPECIAL_CHARS)) : '';
              $addeth_description = isset($_POST['eth_description']) ? trim(filter_input(INPUT_POST, 'eth_description', FILTER_SANITIZE_SPECIAL_CHARS)) : '';
              $addactive = isset($_POST['active']) ? 'Y' : 'N';

              $errors = [];
              if (empty($addnameFirmware)) {
                  $errors[] = "The firmware name is required.<br>";
              }
              if (empty($addfpga_file)) {
                  $errors[] = "The FPGA file is required.<br>";
              }
              if (empty($addmicro_file)) {
                  $errors[] = "The Micro file is required.<br>";
              }
              if (empty($addeth_file)) {
                  $errors[] = "The Ethernet file is required.<br>";
              }
              if (empty($addfpga_fas)) {
                $errors[] = "The FPGA fas is required.<br>";
              }
              if (empty($addmicro_fas)) {
                  $errors[] = "The Micro fas is required.<br>";
              }
              if (empty($addeth_fas)) {
                  $errors[] = "The Ethernet fas is required.<br>";
              }
              if (empty($addcalrstring)) {
                $errors[] = "The calibration string required.<br>";
              }

              if (!empty($errors)) {
                $errorMessages = implode("\\n", $errors);
                echo "<script>Swal.fire({
                          title: 'Missing Information',
                          html: 'The following information is missing:<br>{$errorMessages}',
                          icon: 'error',
                          showConfirmButton: false,
                        });</script>";
              } else {
                  $query = "	INSERT INTO fas_firmwarelist
                  VALUES ((SELECT COALESCE(MAX(idfas_firmwarelist), 0)+1 FROM fas_firmwarelist), 0, '$addnameFirmware', NOW(),
                  '$addfpga_file', '$addmicro_file', '$addeth_file', '$addfpga_fas', '$addmicro_fas', '$addeth_fas', '$addcalrstring',
                  '$addfpga_description', '$adduc_description', '$addeth_description', 0, '$addactive');";
                  
                  $save = pg_query($connection, $query);
                  if ($save) {
                    echo "<script>
                          Swal.fire({
                          title: 'Firmware Added',
                          text: 'The Firmware was added correctly',
                          icon: 'success',
                          showConfirmButton: false,
                        });
                          setTimeout(function() {
                          window.location.href = 'Firmwarelist.php';
                          }, 2000);
                        </script>";
                        $vuserfas = $_SESSION["b"];
                        $vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
                        $vaccionweb="addfirmware";
                          $vdescripaudit="addfirmware-Name:".$addnameFirmware;
                        $vtextaudit="";
                        
                        $sentenciach = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
                                $sentenciach->bindParam(':userfas', $vuserfas);								
                                $sentenciach->bindParam(':menuweb', $vmenufas);
                                $sentenciach->bindParam(':actionweb', $vaccionweb);
                                $sentenciach->bindParam(':descripaudit', $vdescripaudit);
                                $sentenciach->bindParam(':textaudit', $vtextaudit);
                                $sentenciach->execute();
                } else {
                  echo "<script>Swal.fire({
                          title: 'Database Error',
                          text: 'There was an error with the data base',
                          icon: 'error',
                          showConfirmButton: false,
                  });
                    setTimeout(function() {
                      window.location.href = 'Firmwarelist.php';
                      }, 2000);
                  </script>";
                }
              }
            }

            // MODIFY RUN

            if(isset($_POST['modify_confirm'])){
              $idfas = (int) $_POST['idfas'];
              $idrev = (int) $_POST['idrev'];
              $modnamefirmware = isset($_POST['modnamefirmware']) ? $_POST['modnamefirmware'] : "";
              $modfpga_file = isset($_POST['modfpga_file']) ? trim(filter_input(INPUT_POST, 'modfpga_file', FILTER_SANITIZE_SPECIAL_CHARS)) : '';
              $modmicro_file = isset($_POST['modmicro_file']) ? trim(filter_input(INPUT_POST, 'modmicro_file', FILTER_SANITIZE_SPECIAL_CHARS)) : '';
              $modeth_file = isset($_POST['modeth_file']) ? trim(filter_input(INPUT_POST, 'modeth_file', FILTER_SANITIZE_SPECIAL_CHARS)) : '';
              $modfpga_fas = isset($_POST['modfpga_fas']) ? trim(filter_input(INPUT_POST, 'modfpga_fas', FILTER_SANITIZE_SPECIAL_CHARS)) : '';
              $modmicro_fas = isset($_POST['modmicro_fas']) ? trim(filter_input(INPUT_POST, 'modmicro_fas', FILTER_SANITIZE_SPECIAL_CHARS)) : '';
              $modeth_fas = isset($_POST['modeth_fas']) ? trim(filter_input(INPUT_POST, 'modeth_fas', FILTER_SANITIZE_SPECIAL_CHARS)) : '';
              $modcalrstring = isset($_POST['modcalrstring']) ? trim(filter_input(INPUT_POST, 'modcalrstring', FILTER_SANITIZE_SPECIAL_CHARS)) : '';
              $modfpga_description = isset($_POST['modfpga_description']) ? trim(filter_input(INPUT_POST, 'modfpga_description', FILTER_SANITIZE_SPECIAL_CHARS)) : '';
              $moduc_description = isset($_POST['moduc_description']) ? trim(filter_input(INPUT_POST, 'moduc_description', FILTER_SANITIZE_SPECIAL_CHARS)) : '';
              $modeth_description = isset($_POST['modeth_description']) ? trim(filter_input(INPUT_POST, 'modeth_description', FILTER_SANITIZE_SPECIAL_CHARS)) : '';
              $modactive = isset($_POST['active']) ? 'Y' : 'N';

              $errors = [];
              if (empty($modnamefirmware)) {
                  $errors[] = "The firmware name is required.<br>";
              }
              if (empty($modfpga_file)) {
                  $errors[] = "The FPGA file is required.<br>";
              }
              if (empty($modmicro_file)) {
                  $errors[] = "The Micro file is required.<br>";
              }
              if (empty($modeth_file)) {
                  $errors[] = "The Ethernet file is required.<br>";
              }
              if (empty($modfpga_fas)) {
                $errors[] = "The FPGA fas is required.<br>";
              }
              if (empty($modmicro_fas)) {
                  $errors[] = "The Micro fas is required.<br>";
              }
              if (empty($modeth_fas)) {
                  $errors[] = "The Ethernet fas is required.<br>";
              }
              if (empty($modcalrstring)) {
                $errors[] = "The calibration string required.<br>";
              }

              if (!empty($errors)) {
                $errorMessages = implode("\\n", $errors);
                echo "<script>Swal.fire({
                          title: 'Missing Information',
                          html: 'The following information is missing:<br>{$errorMessages}',
                          icon: 'error',
                          showConfirmButton: false,
                        });</script>";
              } else {
                  $query = "	INSERT INTO fas_firmwarelist
                  VALUES ($idfas, (
                  SELECT COALESCE(MAX(idrev), 0)+1 FROM fas_firmwarelist WHERE idfas_firmwarelist = '$idfas'), '$modnamefirmware', NOW(),
                  '$modfpga_file', '$modmicro_file', '$modeth_file', '$modfpga_fas', '$modmicro_fas', '$modeth_fas', '$modcalrstring',
                  '$modfpga_description', '$moduc_description', '$modeth_description', 0, '$modactive');";
                  
                  $save = pg_query($connection, $query);
                  

                  if ($save) {
                    echo "<script>
                          Swal.fire({
                          title: 'Firmware Modified',
                          text: 'The Firmware was modified correctly',
                          icon: 'success',
                          showConfirmButton: false,
                        });
                          setTimeout(function() {
                          window.location.href = 'Firmwarelist.php';
                          }, 2000);
                        </script>";
                        $vuserfas = $_SESSION["b"];
                        $vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
                        $vaccionweb="modifyfirmware";
                          $vdescripaudit="modifyfirmware-Name:".$modnamefirmware."-Id:".$idfas;
                        $vtextaudit="";
                        
                        $sentenciach = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
                                $sentenciach->bindParam(':userfas', $vuserfas);								
                                $sentenciach->bindParam(':menuweb', $vmenufas);
                                $sentenciach->bindParam(':actionweb', $vaccionweb);
                                $sentenciach->bindParam(':descripaudit', $vdescripaudit);
                                $sentenciach->bindParam(':textaudit', $vtextaudit);
                                $sentenciach->execute();
                } else {
                  echo "<script>Swal.fire({
                          title: 'Database Error',
                          text: 'There was an error with the data base',
                          icon: 'error',
                          showConfirmButton: false,
                  });
                    setTimeout(function() {
                      window.location.href = 'Firmwarelist.php';
                      }, 2000);
                  </script>";
                }
              }
            }
    ?>	
  <script>
    
    function searchFirmware() {
      var searchValue = document.getElementById('searchbar').value;
      
      var xhr = new XMLHttpRequest();
      xhr.open('POST', 'searchfirmwarelist.php', true); 
      xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
      xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
          document.getElementById('firmwareTable').innerHTML = xhr.responseText;
          addDeleteButtonEventListeners();
          addModifyButtonEventListeners();
        }
      };
      
      xhr.send('search=' + encodeURIComponent(searchValue));
    }
    
    var which = 0;

    function toggleRow(row) {
      var nextRow = row.nextElementSibling;
      if (nextRow && nextRow.classList.contains('expandable')) {
        if (nextRow.style.display === 'none' || nextRow.style.display === '') {
          nextRow.style.display = 'table-row';
        } else {
          nextRow.style.display = 'none';
        }
      }
    }
    
    function gatherDeleteData(name, id){
      var array = [];
      var inputNameValue = 'namefirmware' + '=' + name;
      array.push(inputNameValue);
      inputNameValue = 'idrev' + '=' + id;
      array.push(inputNameValue);
      return array.join('&');
    }
    
    //DELETE
    function sendDelete(form, namefirmware, idrev) {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        animation:false,
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
        customClass: {
          popup: 'mypopup',
        },
      }).then((result) => {
        if (result.value) {
          var action = form.getAttribute('action');
          
          var form_data = gatherDeleteData(namefirmware, idrev);
          
          var xhr = new XMLHttpRequest();
          xhr.open('POST', action, true);
          xhr.setRequestHeader('Content-type',
          'application/x-www-form-urlencoded');
          xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
          xhr.onreadystatechange = function() {
            if(xhr.readyState == 4 && xhr.status == 200) {
              Swal.fire({
                customClass: {
                  popup: 'mypopup',
                  content: 'mycontent',
                },
                title: 'Firmware Deleted',
                text: 'The Firmware was deleted correctly',
                type: 'success',
                showConfirmButton: false,
              });
              setTimeout(function() {
                window.location.href = 'Firmwarelist.php';
              }, 2000);
            }
          };
          xhr.send(form_data)
        }
      });
    }
    
    document.addEventListener('DOMContentLoaded', function() {
      addDeleteButtonEventListeners();
      addModifyButtonEventListeners();
    });
    
    function addDeleteButtonEventListeners() {
      document.querySelectorAll('.deletebutton').forEach(button => {
        button.addEventListener('click', function(){
          var form = this.closest('form');
          var namefirmware = form.getAttribute('data_name');
          var idrev = form.getAttribute('data_idrev');
          sendDelete(form, namefirmware, idrev);
        });
      });
    };
    
    //MODIFY
    function sendModify(form, namefirmware, idrev, idfas_firmwarelist, fpga_file, micro_file, eth_file, fpga_fas, micro_fas, eth_fas, active, calrstring, fpga_description, uc_description, eth_description) {
      var modifyDiv = document.getElementById('modifyblock');
      var innerHTML = '';
      
      innerHTML += '<div class="box"><div class="addTitle inputD"><h3>Modify Firmware</h3>';
      innerHTML += '<h5>Make sure you complete all fields before modifying the firmware</h5></div>';
      innerHTML += '<form method="post" action="" >';
      innerHTML += `<input type="hidden" name="idfas"  value="${idfas_firmwarelist}" >`
      innerHTML += `<input type="hidden" name="idrev" value="${idrev}" >`
      console.log(idfas_firmwarelist + '   ' + idrev);
      innerHTML += `<div class='inputD'><p class='inputT'>Firmware name</p><input class="modinput" style='width: 40%;text-align: center;' type="text" name="modnamefirmware" value="${namefirmware ? namefirmware : ''}" placeholder="Name Firmware"></div><br>`;
      innerHTML += `<div class='files'><div class='inputD'><p class='inputT'>FPGA file</p><input class="modinput" type="text" name="modfpga_file" value="${fpga_file ? fpga_file : ''}" placeholder="FPGA file"></div><br>`;
      innerHTML += `<div class='inputD'><p class='inputT'>UC file</p><input class="modinput" type="text" name="modmicro_file" value="${micro_file ? micro_file : ''}" placeholder="UC file"></div><br>`;
      innerHTML += `<div class='inputD'><p class='inputT'>Ethernet file</p><input class="modinput" type="text" name="modeth_file" value="${eth_file ? eth_file : ''}" placeholder="Ethernet file"></div></div><br>`;
      innerHTML += `<div class='fases'><div class='inputD'><p class='inputT'>FPGA fas</p><input class="modinput" type="text" name="modfpga_fas" value="${fpga_fas ? fpga_fas : ''}" placeholder="FPGA fas"></div><br>`;
      innerHTML += `<div class='inputD'><p class='inputT'>UC fas</p><input class="modinput" type="text" name="modmicro_fas" value="${micro_fas ? micro_fas : ''}" placeholder="UC fas"></div><br>`;
      innerHTML += `<div class='inputD'><p class='inputT'>Ethernet fas</p><input class="modinput" type="text" name="modeth_fas" value="${eth_fas ? eth_fas : ''}" placeholder="Ethernet fas"></div></div><br>`;
      innerHTML += `<div class='inputD'><p class='inputT'>Calibration string</p><input class='modinput' style='width: 60%;text-align: center;' type="text" name="modcalrstring" value="${calrstring ? calrstring : ''}" placeholder="Calibration string"></div><br>`;
      innerHTML += `<div class='description'><div class='inputD'><p class='inputT'>FPGA description</p><input class="modinput" type="text" name="modfpga_description" value="${fpga_description ? fpga_description : ''}" placeholder="FPGA description (Can be empty)"></div><br>`;
      innerHTML += `<div class='inputD'><p class='inputT'>UC description</p><input class="modinput" type="text" name="moduc_description" value="${uc_description ? uc_description : ''}" placeholder="UC description (Can be empty)"></div><br>`;
      innerHTML += `<div class='inputD'><p class='inputT'>Ethernet description</p><input class="modinput" type="text" name="modeth_description" value="${eth_description ? eth_description : ''}" placeholder="Ethernet description (Can be empty)"></div></div><br>`;
      innerHTML += `<div class='inputD'><p class='inputT'>Active</p><input class='check' type="checkbox" name="active" ${active === 'Y' ? 'checked' : ''}></div><br>`;
      innerHTML += `<div class='inputD'><input class="btn btn-outline-info btn-sm" type="submit" name="modify_confirm" value="Modify Firmware" onclick="return confirmModify();"></div>`;
      innerHTML += '</form></div>';
      modifyDiv.style.display='block';
      modifyDiv.innerHTML = innerHTML;
      
      document.querySelectorAll('.modinput').forEach(input => {
        input.addEventListener('input', function() {
          this.classList.add('modified');
        });
      });
    }
    
    
    function addModifyButtonEventListeners(){
      document.querySelectorAll('.modifybutton').forEach(button => {
        button.addEventListener('click', function(){
          var form = this.closest('form');
          var namefirmware = form.getAttribute('data_name');
          var idrev = form.getAttribute('data_idrev');
          var id = form.getAttribute('data_idfirm');
          var fpga_file = form.getAttribute('data_fpga_file');
          var micro_file = form.getAttribute('data_micro_file');
          var eth_file = form.getAttribute('data_eth_file');
          var fpga_fas = form.getAttribute('data_fpga_fas');
          var micro_fas = form.getAttribute('data_micro_fas');
          var eth_fas = form.getAttribute('data_eth_fas');
          var active = form.getAttribute('data_active');
          var calrstring = form.getAttribute('data_calrstring');
          var fpga_description = form.getAttribute('data_fpga_description');
          var uc_description = form.getAttribute('data_uc_description');
          var eth_description = form.getAttribute('data_eth_description');
          if(which==0){
            which = 1
            sendModify(form, namefirmware, idrev, id, fpga_file,
            micro_file, eth_file, fpga_fas, micro_fas, eth_fas,
            active, calrstring, fpga_description, uc_description, eth_description);
          } else if (which == 1){
            document.getElementById('modifyblock').style.display='none';
            which = 0;
          } else {
            which = 1
            var addDiv = document.getElementById('addblock');
            addDiv.style.display='none';
            sendModify(form, namefirmware, idrev, id, fpga_file,
            micro_file, eth_file, fpga_fas, micro_fas, eth_fas,
            active, calrstring, fpga_description, uc_description, eth_description);
          }
        });
      });
    };
    
    
    // ADD
    
    function sendAdd(){
      var addDiv = document.getElementById('addblock');
      var innerHTML = '';
      
      innerHTML += '<div class="box"><div class="addTitle inputD"><h3>Add Firmware</h3>';
      innerHTML += '<h5>Make sure you complete all fields before adding the firmware</h5></div>';
      innerHTML += '<form method="post" action="">';
      innerHTML += `<div class='inputD'><p class='inputT'>Firmware name</p><input class="Addinput" style='width: 40%;text-align: center;' type="text" name="nameFirmware" placeholder="Firmware name"></div><br>`;
      innerHTML += `<div class='files'><div class='inputD'><p class='inputT'>FPGA file</p><input class="Addinput" type="text" name="fpga_file" placeholder="FPGA file"></div><br>`;
      innerHTML += `<div class='inputD'><p class='inputT'>UC file</p><input class="Addinput" type="text" name="micro_file" placeholder="UC file"></div><br>`;
      innerHTML += `<div class='inputD'><p class='inputT'>Ethernet file</p><input class="Addinput" type="text" name="eth_file" placeholder="Ethernet file"></div></div><br>`;
      innerHTML += `<div class='fases'><div class='inputD'><p class='inputT'>FPGA fas</p><input class="Addinput" type="text" name="fpga_fas" placeholder="FPGA fas"></div><br>`;
      innerHTML += `<div class='inputD'><p class='inputT'>UC fas</p><input class="Addinput" type="text" name="micro_fas" placeholder="UC fas"></div><br>`;
      innerHTML += `<div class='inputD'><p class='inputT'>Ethernet fas</p><input class="Addinput" type="text" name="eth_fas" placeholder="Ethernet fas"></div></div><br>`;
      innerHTML += `<div class='inputD'><p class='inputT'>Calibration string</p><input class='Addinput' style='width: 60%;text-align: center;' type="text" name="calrstring" placeholder="Calibration string"></div><br>`;
      innerHTML += `<div class='description'><div class='inputD'><p class='inputT'>FPGA description</p><input class="Addinput" type="text" name="fpga_description" placeholder="FPGA description (Can be empty)"></div><br>`;
      innerHTML += `<div class='inputD'><p class='inputT'>UC description</p><input class="Addinput" type="text" name="uc_description" placeholder="UC description (Can be empty)"></div><br>`;
      innerHTML += `<div class='inputD'><p class='inputT'>Ethernet description</p><input class="Addinput" type="text" name="eth_description" placeholder="Ethernet description (Can be empty)"></div></div><br>`;
      innerHTML += `<div class='inputD'><p class='inputT'>Active</p><input class='check' type="checkbox" name="active"></div><br>`;
      innerHTML += `<div class='inputD'><input class="btn btn-outline-primary btn-sm" type="submit" name="add_confirm" value="Add Firmware"></div>`;
      innerHTML += '</form></div>';
      addDiv.style.display='block';
      addDiv.innerHTML = innerHTML;
    }
    
    var button = document.getElementById('addbutton');
    button.addEventListener('click', function () {
      if(which==0){
        which = 2;
        sendAdd()
      } else if(which==2){
        document.getElementById('addblock').style.display='none';
        which = 0;
      } else{
        var modifyDiv = document.getElementById('modifyblock');
        modifyDiv.style.display='none';
        which = 2;
        sendAdd()
      }
    });
  </script>

</section>

</div>	


<!-- /.col -->
        </div>
      </div>
      <!-- /.timeline -->

    </section>
    <!-- /.content -->
	
		</form>	
	
  </div>
  <!-- /.content-wrapper -->
  


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


<script src="plugins/datatables/jquery.dataTables.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script src="js/popperparacalibratio.min.js"></script>
  <script type="text/javascript" src="js/jstree.min.js"></script>
</body>

   
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
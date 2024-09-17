<!DOCTYPE html>
<?php 

// Desactivar toda notificación de error
error_reporting(0);
// Notificar todos los errores de PHP (ver el registro de cambios)
//error_reporting(E_ALL);
 include("db_conect.php"); 
 ////
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

    <script type="text/javascript" src="js/tabulator.min.js"></script>

    <script src="plugins/datatables/jquery.dataTables.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>


    <link rel="stylesheet" href="cssfiplex.css">

    <style>
    body {
        font-family: Arial, Helvetica, sans-serif;
        background: #eee;
        font-size: 12px;
        font-size: 12px;
    }

    .tree {
        margin: 6px;
        margin-left: -20px;
    }

    .tree li {
        list-style-type: none;
        margin: 0;
        padding: 6px 5px 0 5px;
        position: relative
    }

    .tree li::before,
    .tree li::after {
        content: '';
        left: -20px;
        position: absolute;
        right: auto
    }

    .tree li::before {
        border-left: 1px solid #000;
        bottom: 50px;
        height: 100%;
        top: 0;
        width: 1px
    }

    .tree li::after {
        border-top: 1px solid #000;
        height: 20px;
        top: 25px;
        width: 25px
    }

    .tree li span {
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        border: 1px solid #000;
        border-radius: 1px;
        display: inline-block;
        padding: 1px 5px;
        text-decoration: none;
        cursor: pointer;
    }

    .tree>ul>li::before,
    .tree>ul>li::after {
        border: 0
    }

    .tree li:last-child::before {
        height: 27px
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
                                <h1>DashBoard</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active"> <?php echo $_SESSION["h"]; ?></li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <?php

 
				
?>

                <section class="content">


                    <input type="hidden" value="" name="idpetitionrun" id="idpetitionrun">
                    <?php 	 if 	($_SESSION["g"] == "develop" ) 
	{

        $macAddress_server_bd = '';
        $query_woattach ="select * from business_station where ipstation = 'webfas.honeywell.com'  ";
        $data_wo = $connect->query($query_woattach)->fetchAll();	
        $enabled_attachfile_step = 'N';
        foreach ($data_wo as $rowwo) 
        {
            $macAddress_server_bd = $rowwo['bs_mac_address'];
      
        }



$output=null;
$retval=null;
exec('ipconfig /all', $output, $retval);

 
function buscar_string_en_array_multinivel_con_array_walk($array, $string ) {
    $found = false;

    array_walk($array, function ($value, $key) use (&$found, $string) {
     ///   echo "<br>*-valor:".$value;


        $pos = strpos($value, $string);

            // Note our use of ===.  Simply == would not work as expected
            // because the position of 'a' was the 0th (first) character.
            if ($pos === false) {
            //   echo "The string '$value' NO '$string'";
            
            } else {
            //   echo "The string '$value' SII '$string'";
            //   echo " and exists at position $pos";
                $found = true;
            }
                    
             

    });

    return $found;
}


$key = buscar_string_en_array_multinivel_con_array_walk($output, $macAddress_server_bd);

//echo "El string $macAddress_server_bd se encuentra en el array en la posición $key.";
if ($key !== false) {
   // echo "<br>el string $macAddress_server_bd se encuentra en el array.";
} else {
    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-danger"><i class="far fa-flag"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">
                                        <h3 style='color:red'><b>Attention, WEBFAS Server changed MAC
                                                address</b></h3>
                                    </span>
                                    <span class="info-box-number"><b>this MAC: <?php echo  $macAddress_server_bd; ?> is
                                            not
                                            correct.</b></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                        </div>
                    </div>
                    <?php
  //  echo "<br>el string $macAddress_server_bd no se encuentra en el array.";
}

		?>

                    <!-- inicio grafico de reportes -->
                    <div class="row">
                        <div class="col-md-6">

                            <!-- inicio grafico 1 -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title colorazulfiplex ">FAS execution </h3>
                                    <input type="hidden" id="graf2anio1" name="graf2anio1" value="">
                                    <div class="card-tools">
                                        <span class='float-right'>
                                            &nbsp;YEAR: <span id="nombmes" name="nombmes" class='colorazulfiplex'><b>
                                                    <?php echo  date("Y") ; ?></b></span>
                                        </span>

                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="chart">
                                        <div class="position-relative mb-4">
                                            <canvas id="visitors-chart2" height="200"></canvas>
                                        </div>
                                        <div class="d-flex flex-row justify-content-end">
                                            <span class="mr-2">
                                                <i class="fas fa-square text-primary"></i> [FIPLEX]
                                            </span>

                                            <span class="mr-2" style="color:#00994C">
                                                <i class="fas fa-square"></i> [SPINNAKER]
                                            </span>



                                            <span class="mr-2" style="color:#CC0000">
                                                <i class="fas fa-square"></i> [WESTELL]
                                            </span>

                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- fin grafico 1 -->

                        </div>
                        <div class="col-md-6">
                            <!-- inicio grafico 2 -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title colorazulfiplex ">FAS execution script</h3>

                                    <div class="card-tools">
                                        <span class='float-right'>
                                            &nbsp;YEAR: <span id="nombmesgrafico2" name="nombmesgrafico2"
                                                class='colorazulfiplex'><b> <?php echo  date("Y") ; ?></b></span>
                                        </span>
                                        <input type="hidden" id="graf2anio" name="graf2anio" value="">
                                        <input type="hidden" id="graf2anioidbusiness" name="graf2anioidbusiness"
                                            value="0">

                                        <ul class="pagination pagination-sm">
                                            <li class="page-item"><a href="#" id="btntodass" name="btntodass"
                                                    class="page-link" onclick="setbusiness(0,'btntodass');"> ALL <i
                                                        class='far fa-check-circle'></i> </a></li>
                                            <li class="page-item"><a href="#" id="btntodassf" name="btntodassf"
                                                    class="page-link" onclick="setbusiness(1,'btntodassf');"> FIPLEX
                                                </a></li>
                                            <li class="page-item"><a href="#" id="btntodasss" name="btntodasss"
                                                    class="page-link" onclick="setbusiness(3,'btntodasss');"> SPINNAKER
                                                </a></li>
                                            <li class="page-item"><a href="#" id="btntodassw" name="btntodassw"
                                                    class="page-link" onclick="setbusiness(2,'btntodassw');"> WESTELL
                                                </a></li>
                                            <li class="page-item">&nbsp;</li>

                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="chart">
                                        <div class="position-relative mb-4">
                                            <canvas id="visitors-chart" height="200"></canvas>
                                        </div>
                                        <div class="d-flex flex-row justify-content-end" id="lblgrafico"
                                            name="lblgrafico">

                                        </div>
                                    </div>
                                </div>
                                <!-- fin grafico 2 -->

                            </div>
                        </div>

                    </div>
                    <!-- fin grafico de reportes -->
                    <?php } 
	?>
                    <div class="row">
                        <!-- /.inicio row botones menu rapido content -->



                        <?php
			
			
			///Borramos lso accesos directos a pedido de agus.
			///acamarco
				foreach ($resultado22 as $row) {
					$stylecolor = $row['menustyle'];
					$iconomenu = $row['iconmenu'];
					
					$namemenu = $row['namemenu'];
					$linkmenu = $row['linkaccess'];
					
					?>
                        <!-- autogenerado:0 BOTON MENU-->
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon <?php echo $stylecolor;?> elevation-1"><i
                                        class="<?php echo $iconomenu;?>"></i></span>
                                <div class="info-box-content"><a href="<?php echo $linkmenu;?>"><span
                                            class="info-box-number"><?php echo $namemenu;?></span></a></div>
                            </div>

                        </div>
                        <!-- autogenerado:0 BOTON MENU-->
                        <?php
				}
			?>

                        <!-- 11 BOTON MENU-->

                        <!-- 11 BOTON MENU-->


                        <!-- /. fin row botones menu rapido  content -->


                        <!----- CUI BOX  -->
                        <?php
		
			
			 $query_lista="select distinct menu.* from menu inner join business_user_menu on business_user_menu.idmenu = menu.idmenu  where menu.active = 'Y' and sector = 'homecenter' and iduserfas=$eluserlogin  order by ordershow , sector,  namemenu  ";
			
		//	echo 	$query_lista;
				$resultado = $connect->query($query_lista)->fetchAll();	
				
				$temp_namegroup = "";
			
				foreach ($resultado as $row) {
					$stylecolor = $row['menustyle'];
					$iconomenu = $row['iconmenu'];
					$iconmenuhead = $row['iconmenuhead'];
					$headnamemenu = $row['namegroup'];
					$namemenu = $row['namemenu'];
					$linkmenu = $row['linkaccess'];
					
					if ($headnamemenu != $temp_namegroup)
					{
						if ($temp_namegroup != "")
						{
							?>
                    </div>
            </div>
        </div>
        <?php
						}
							$temp_namegroup = $headnamemenu;
						?>
        <div class="col-12 col-sm-6 col-md-3">
            <div class="card card-default color-palette-box ">
                <div class="card-header">
                    <h3 class="card-title"> <i class="<?php echo $iconmenuhead; ?>"></i> <?php echo $headnamemenu; ?>
                    </h3>
                </div>
                <div class="card-body">
                    <?php
					}
					?>
                    <!-- autogenerado:0 BOTON MENU-->

                    <i class='<?php echo $iconomenu; ?>' style='font-size:24px'></i> <a
                        href="<?php echo $linkmenu; ?>"><?php echo $namemenu; ?></a><br>


                    <!-- autogenerado:0 BOTON MENU-->
                    <?php
				}
				if ($temp_namegroup !="")
				{
					?>
                </div>
            </div>
        </div>

        <?php
				}
			?>


        </div>




        <div class="row">

            <?php 
	
	//if ($_SESSION["g"] == "develop" || $_SESSION["g"] == "director" )
	//{
		
	?>

            <div class="col-12">
                <!-- init FAS TO SAP -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">FAS <i class="fa fa-solid fa-arrow-right"></i> SAP</h3>


                    </div>
                    <div class="card-body" id="divfassap" name="divfassap">
                        <?php
        
		if ($_SESSION["g"] == "develop" || $_SESSION["g"] == "director" || $_SESSION["a"]==8  || $_SESSION["a"]==109 || $_SESSION["a"]==107 || $_SESSION["a"]==7 )
		{

            echo "<a href='buscarerroressapconfir.php'> Buscar operaciones para reenviar </a>";
      			$query_lista = " select    fas_to_sap_xml.*, fas_outcome_integral.v_string as wosorma
						from fas_to_sap_xml  
					left join fas_outcome_integral on fas_outcome_integral.reference = fas_to_sap_xml.idruninfo
						and       fas_outcome_integral.idtype = 2
					and       fas_outcome_integral.idfasoutcomecat =0
					where  runinfodate > (current_date -7) and v_state <9 
					and not (v_workcenetr = 'MODULE' and v_sku is  null )
					order by runinfodate desc 
					
					";

                 $query_lista = "select  distinct  todos.*,v_string
                 from (
                    select   distinct  idruninfo, v_status_script, v_po, v_sn, v_sku, v_state, v_state_result, v_workcenetr,  runinfodate, runprocessdate,  v_sowo, fas_outcome_integral.v_string as wosorma
                    from fas_to_sap_xml  
                                     left join fas_outcome_integral on fas_outcome_integral.reference = fas_to_sap_xml.idruninfo
                                         and       fas_outcome_integral.idtype = 2
                                     and       fas_outcome_integral.idfasoutcomecat =0
                                     where  runinfodate > (current_date -37) and v_state <9  	and not (v_workcenetr = 'MODULE' and v_sku is  null )
                 ) as todos
                 inner join fas_outcome_integral
                 on fas_outcome_integral.reference= todos.idruninfo 	and
                    fas_outcome_integral.idtype = 16 and
                    fas_outcome_integral.idfasoutcomecat =0  where (wosorma not like '%RM' or wosorma is null)  order by runinfodate desc ";   
		}
		else
		{


            if ( $_SESSION["a"]==96 || $_SESSION["a"]==15 || $_SESSION["a"]==33  || $_SESSION["a"]==81  || $_SESSION["a"]==60   )  /// ONLY QUALITY view PRECHECK +   Maibe yJonahtan
          
		    {
                $query_lista = "select  distinct  todos.*,v_string
                from (
                    select   distinct  idruninfo, v_status_script, v_po, v_sn, v_sku, v_state, v_state_result, v_workcenetr,  runinfodate, runprocessdate,  v_sowo, fas_outcome_integral.v_string as wosorma
                    from fas_to_sap_xml  
                                    left join fas_outcome_integral on fas_outcome_integral.reference = fas_to_sap_xml.idruninfo
                                        and       fas_outcome_integral.idtype = 2
                                    and       fas_outcome_integral.idfasoutcomecat =0
                                    where  runinfodate > (current_date -7) and v_state <9  
                ) as todos
                inner join fas_outcome_integral
                on fas_outcome_integral.reference= todos.idruninfo 	and
                   fas_outcome_integral.idtype = 16 and
                   fas_outcome_integral.idfasoutcomecat =0   where (wosorma not like '%RM' or wosorma is null) and v_po <> 'NOXML' order by runinfodate desc  
                        ";
            }
            else
            {
                $query_lista = "select  distinct  todos.*, v_string
                from (
                                select     idruninfo, v_status_script, v_po, v_sn, v_sku, v_state, v_state_result, v_workcenetr,  runinfodate, runprocessdate,  v_sowo, fas_outcome_integral.v_string as wosorma
                                        from fas_to_sap_xml  
                                    left join fas_outcome_integral on fas_outcome_integral.reference = fas_to_sap_xml.idruninfo
                                        and       fas_outcome_integral.idtype = 2
                                    and       fas_outcome_integral.idfasoutcomecat =0
                                    where  runinfodate > (current_date -17) and v_state <9  	and not (v_workcenetr = 'MODULE' and v_sku is  null )
                ) as todos
                inner join fas_outcome_integral
                on fas_outcome_integral.reference= todos.idruninfo 	and
                   fas_outcome_integral.idtype = 16 and
                   fas_outcome_integral.idfasoutcomecat =0 and
                   fas_outcome_integral.v_string = '".$_SESSION["b"]."'    where (wosorma not like '%RM' or wosorma is null) and  v_po <> 'NOXML'  order by runinfodate desc  
                        ";
            }
		
            
			//		echo $query_lista;
		}
         
 // echo $query_lista;
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
                                    <th class="bg-primary "> User </th>


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
                                <td> <?php echo  $row2['runinfodate'];  ?></td>
                                <td> <?php echo  $row2['runprocessdate'];  ?></td>
                                <?php
       echo "<td>";
	   $statemm = $row2['v_state'];
     
     
            $idrunhiss ="";
			$isbypass="N";
            $sqlmaxhistory = "select * from fas_to_sap_xml_history where idruninfo =".$row2['idruninfo']." order by  runprocessdate asc";
          //  echo $sqlmaxhistory;
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
                    //  $sqlackresult = "select * from fas_sap_filesxml_attribute where idruninfo =".$idrunhiss." and idattributeord in (56,57,59) ";
					  $sqlackresult = "select v_string, POSITION('is already being processed by' in v_string) as isbypass, POSITION('Characteristic with confirmation number' in v_string) as isbypass2  from fas_sap_filesxml_attribute where idruninfo =".$idrunhiss." and idattributeord in (56,57,59) ";
                  
                      //echo $sqlackresult;
                     /* $dataack = $connect->query($sqlackresult)->fetchAll();	
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
                          */
                          
					   }          
					}

				
                   

					

          

			if ($isbypass=="Y")
					{
					  echo "<span class='badge bg-success'>Ok ByPass - Confirmed in SAP </span>";
					}
					else
					{
						if ($statemm==0)
						{
						  echo "<span class='badge bg-secondary'> Pending generation</span>";
                          if ($_SESSION["g"] == "develop" || $_SESSION["g"] == "director" || $_SESSION["a"]==8   || $_SESSION["a"]==109 || $_SESSION["a"]==107  )
                          {
						  echo "<br><a href='#' onclick='reenviarxml(".$row2['idruninfo'].")' ><i class='fa fa-retweet' style='font-size:16px'></i> Resend confirmation</a>";
                          }
                        }
						if ($statemm ==1)
						{
						  echo "<span class='badge bg-warning'>Run</span>";
						}
						if ($statemm ==2)
						{
						  echo "<span class='badge bg-warning'>Waiting for confirmation in SAP</span>";
                          if ($_SESSION["g"] == "develop" || $_SESSION["g"] == "director" || $_SESSION["a"]==8  || $_SESSION["a"]==109 || $_SESSION["a"]==107  )
                          {
						  echo "<br><a href='#' onclick='reenviarxml(".$row2['idruninfo'].")' ><i class='fa fa-retweet' style='font-size:16px'></i> Resend confirmation</a>";
                          }
                        }
						if ($statemm ==3)
						{
						  echo "<span class='badge bg-danger'>Error </span>";
						  echo "<p style='color:red'>".$tooltipamostrar."</p>";
						 
                          if ($_SESSION["g"] == "develop" || $_SESSION["g"] == "director" || $_SESSION["a"]==8   || $_SESSION["a"]==109 || $_SESSION["a"]==107  )
                          {
                          echo "<a href='#' onclick='reenviarxml(".$row2['idruninfo'].")' ><i class='fa fa-retweet' style='font-size:16px'></i> Resend confirmation</a>";
                          }
                        }
						if ( $statemm ==4)
						{
							echo "<span class='badge bg-success'>OK - Confirmed in SAP </span>";
						}
						if ($statemm ==5)
						{
							echo "<span class='badge bg-danger'>Error - an error occurred while confirming </span>";
							echo "<p style='color:red'>".$tooltipamostrar."</p>";
						
                        	if ($_SESSION["g"] == "develop" || $_SESSION["g"] == "director" || $_SESSION["a"]==8   || $_SESSION["a"]==109 || $_SESSION["a"]==107  )
		                        {
                            echo "<a href='#' onclick='reenviarxml(".$row2['idruninfo'].")' ><i class='fa fa-retweet' style='font-size:16px'></i> Resend confirmation</a>";
                                }
                            
						}

                        if ($statemm ==8)
						{
                            echo "<span class='badge bg-success'>Ok - Manually confirmed in SAP</span>";
						 
                            
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
      echo "<td>".$row2['v_string']."</td>"; 
    ?>

                                <?php 	 

 
       
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
                    <!--  end FAS TO SAP -->
                </div>

            </div>
            <?php
	//}
?>




            <div class="col-lg-4">
                <?php 
	
		if ($_SESSION["g"] == "develop" || $_SESSION["g"] == "director" )
		{
			
		?>

                <div class="callout callout-warning">
                    <h5><i class="fas fas fa-wrench"></i></i> Backup Files:</h5><br>
                    - Format: Database-Day-Hr.7z<br>
                    <?php
			  
			//  http://webfas.honeywell.com/ajaxultibksnube.php
		

			  ?>
                    <?php 
			//	$cc = curl_init("https://webfas.honeywell.com/ajaxultibksnube.php");  
		//	$url_content =  curl_exec($cc);  
		//	curl_close($cc); ?> </span>
                    <?php 
		//	echo "aaaaaaaaaaaaa".	$url_content ;
		$ultdiaconbks_srvusa="";
		// Arreglo con todos los nombres de los archivos
		$path  = 'D:/Bks_Psql_FULL/'; 
		//	$files = array_diff(scandir($path), array('.', '..')); 
			$bksamostrar="";
		/*	foreach($files as $file){
				echo '<br><i class="nav-icon 	far fa-file-alt"></i> '.$file;
				///" - ".filesize($file)." Bytes -- ". date('Ymd H:i:s', filemtime($file));;

			 

				}*/
				//echo  $bksamostrar;

				$myDirectory = opendir($path);
// get each entry
while($entryName = readdir($myDirectory)) {
    $dirArray[] = $entryName;
}
// close directory
closedir($myDirectory);
//  count elements in array
$indexCount = count($dirArray);
//Print ("$indexCount files<br>\n");
//echo "</span> <br>";
// sort 'em
sort($dirArray);
// print 'em
print("<TABLE class='table table-striped' cellpadding=5 cellspacing=0  >\n");
print("<TR><TH>Filename</TH><th>Filetype</th><th>Filesize</th></TR>\n");
// loop through the array of files and print them all
for($index=0; $index < $indexCount; $index++) {
        if (substr("$dirArray[$index]", 0, 1) != "."){ // don't list hidden files
			 

			$posicion_coincidencia = strpos($dirArray[$index], "7z");
		if ($posicion_coincidencia === false) {
			}
			else
			{
				print("<TR><TD>$dirArray[$index]</td>");
				print("<td>");  print(filetype($path."/".$dirArray[$index])); print("</td>");
				print("<td>");  print(filesize($path."/".$dirArray[$index])); print("</td>");
				print("</TR>\n");
			}
        
    }
}
print("</TABLE>\n");
			?>

                </div>
                <?php 	
		}
	?>




            </div>



            <div class="col">
                <div class="card">



                    <?php 
if 	($_SESSION["g"] == "develop"    ) 
{
?>

                    <?php

function get_server_cpu_usage(){

    $load = sys_getloadavg();
//echo	var_dump(sys_getloadavg());
    return $load[0];

}
				  
			//	  $file = fopen("/var/log/php-fpm/www-error.log","r");
			//	  echo fgets($file);
			//  fclose($file);
			//	  echo "<hr>";
				//  $output = shell_exec('top -n 1 ');
				//	echo $output;

			//		echo 'get_server_cpu_usage'.get_server_cpu_usage() ;

				 ?>
                    <br>

                    <a class="btn btn-app" href="dashboardmarcosap.php">

                        <i class="fas fa-bullhorn"></i> Check Status WO - SO -> Attributes
                    </a>


                    <br>

                    <div class="card-header border-0 ui-sortable-handle" style="cursor: move;">
                        <h3 class="card-title colorazulfiplex "> <i class='fas fa-user-nurse'></i> Developers only </h3>
                    </div>
                    <hr>
                    <?php
$sql2 = " SELECT * from fas_petitions_server where instance  = '04D0E6' and exitstatus  = 'Error executing the request' and status <>2 and fas_petitions_server.date >'2022-10-24'";

$result_petiti = $connect->query($sql2)->fetchAll();				
$nropetitipend=0;
$losdatosamostrar ="";
foreach ($result_petiti as $rowdatospp) {

	$sql2 = " update fas_petitions_server set status = 0,exitstatus =''  where instance  = '04D0E6' and exitstatus  = 'Error executing the request' and status <>2 and fas_petitions_server.date >'2022-10-24'";
	$result_petiti = $connect->query($sql2)->fetchAll();	

	?>
                    <div class="card-body">
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class='fas fa-file-medical-alt'></i> Alert!</h5>
                            Pending Alert Email Sendings
                            <hr>



                        </div>
                    </div>
                    <?php
	break;
}

///////////////////////////////////////////////////

$path  = 'D:/Digboardlog/Source/SAPXML'; 
$files = array_diff(scandir($path), array('.', '..')); 
$qq_file_pending=0;
foreach($files as $file){
		// Divides en dos el nombre de tu archivo utilizando el . 
		$qq_file_pending=$qq_file_pending+1;		 
	}

if ($qq_file_pending>3)
{
	?>
                    <div class="card-body">
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class='fas fa-file-medical-alt'></i> Alert!</h5>
                            Pending XML File <?php echo $qq_file_pending - 3; ?>
                            <hr>



                        </div>
                    </div>
                    <?php
}	

////////////////////////////////////////////////////

$sql2 = " SELECT * from fas_petitions_server where  iduserto = 22 and status =0";
								
				
						
$result_petiti = $connect->query($sql2)->fetchAll();				
$nropetitipend=0;
$losdatosamostrar ="";
foreach ($result_petiti as $rowdatospp) {
	$nropetitipend=$nropetitipend+1;
	$losdatosamostrar = $losdatosamostrar."*&nbsp;".$rowdatospp['parameters1']."<br>";
	
}


				  
				 
					?>
                    <hr>
                    <div class="col-3" id="fasclientrespond" name="fasclientrespond">
                    </div>
                    <div class="col-5" id="fasusuconect" name="fasusuconect">
                        <div class="card-body">
                            <?php 
				 	$sqlcantusus = "select count(*) as ccu from pg_stat_activity where  usename <> ''";

					 $datausuconect = $connect->query($sqlcantusus)->fetchAll();
					 
					  foreach ($datausuconect as $rowusu) 
						   {
							   echo "  <i class='fas fa-user-alt' style='font-size:20px'></i> [". $rowusu['ccu']."] Users connected to the base.";
						   }
						   	echo "<hr>";

						   $sqlcontrol=" SELECT usename, application_name, count(*) as cc FROM pg_stat_activity where usename<>''
						   group by usename, application_name order by cc desc";
						    $datausuconect = $connect->query($sqlcontrol)->fetchAll();
					 
							foreach ($datausuconect as $rowusudet) 
								 {
									 echo "<br>  <i class='fas fa-user-alt' style='color:green '></i> [".$rowusudet['usename']."] ".$rowusudet['application_name']." - Number of connections: ".$rowusudet['cc']."<br>" ;
								 }
				 ?>
                        </div>
                    </div>
                    <hr>
                    <div class="col-3 text-center">





                    </div>

                    <?php
				/*  if ($qporcentaje>59)
				  {

				
				 $sqlqpasa = "SELECT usename, client_addr, backend_start,  query, backend_start::TIMESTAMP - now()::TIMESTAMP as tiempo from pg_stat_activity where query <> '' AND usename <> ''"; 
				 
					 $datausuconect = $connect->query($sqlqpasa)->fetchAll();
					 
					  foreach ($datausuconect as $rowusu) 
						   {
							   echo "<i class='fas fa-database'></i> [".$rowusu['usename']."] {".$rowusu['client_addr']."} -Start: ".$rowusu['backend_start']." -- Duration:".$rowusu['tiempo']."<br>Query:".$rowusu['query']."<hr>";
						   }
						
						}*/
				  ?>


                    <?php
}
?>
                </div>
            </div>
        </div>


        <!-- /.content-wrapper -->

        </div>
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
<script src="js/eModal.min.js" type="text/javascript"></script>

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


function reenviarxml(idrunfin) {
    $.ajax({
        url: 'reprocesarxmlsendsap.php',
        data: "idrunfin=" + idrunfin,
        type: 'post',
        async: true,
        cache: false,
        success: function(data) {
            window.location.reload(true);

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
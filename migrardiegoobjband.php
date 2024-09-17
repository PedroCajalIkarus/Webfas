<!DOCTYPE html>
<?php 

// Desactivar toda notificación de error

use Aws\Waiter;

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
            <h1>Migrar Obj Band Diego</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Migrar Obj Band Diego</li>
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
			<p name="msjwaitline" id="msjwaitline" align="center"><img src="img/waitazul.gif" width="100px" ></p>	
				<div class="card">
					<?php
          
          $query_diego="select * from tmpcuidiegofreq where procesado ='1' and VHF <> 'VHF'   ";
          
          $datadiego = $connect->query($query_diego)->fetchAll();	
          foreach ($datadiego as $rowmigrar) 
          {
            echo "<hr>".$rowmigrar['honpnnew'];
            ////////Buscamos info para el producto
            $productexiste = 'N';
            $query_diego2="select * from fnt_select_allproducts_maxrev() where modelciu= '".$rowmigrar['honpnnew']."'";
            $datadiegow2 = $connect->query($query_diego2)->fetchAll();	
           echo "Buscando.....".$rowmigrar['honpnnew']."<br>";
          
            foreach ($datadiegow2 as $rowdiegow2) 
            {
              $idproductpublico=$rowdiegow2['idproduct'];
              $productexiste = 'Y';
              $vidproduct = $rowdiegow2['idproduct'];
              echo " ||Active: ".$rowdiegow2['active']." || Usermodif:".$rowdiegow2['usermodif']."----";
              echo "La definicion: [".$rowmigrar['idbandtemp']."] - idband2: [".$rowmigrar['idbandtemp2']."] - idband3: [".$rowmigrar['idbandtemp3']."] -Subband:";
              echo " [".$rowmigrar['idsubbandtemp']."] - idsubbandtemp2: [".$rowmigrar['idsubband2temp']."] - idsubband2temp: [".$rowmigrar['idsubband3temp']."] :";

              ///idbandtemp, idbandtemp2, idsubbandtemp, idsubband2temp, procesado, idbandtemp3, idsubband3temp
            }
            $sqlband="select * from fnt_select_objectband_maxrev() where  ciu= '".$rowmigrar['honpnnew']."'";
            $datadiegow2band = $connect->query($sqlband)->fetchAll();	
            $tienebandobjband='N';
            foreach ($datadiegow2band as $rowdiegow2band) 
            {
              $idbandobjband = $rowdiegow2band['idband'];
              if ($idbandobjband == 8 || $idbandobjband == 1 || $idbandobjband == 6 || $idbandobjband == 7)
              {
                $idbandobjband= 8;
              }
              

        //      echo "<br>(*)Objband||Idband: ".$rowdiegow2band['idband']."-Transformado:".$idbandobjband."-lo comparo con : ".$rowmigrar['idbandtemp'];
               if ( trim($idbandobjband)== trim($rowmigrar['idbandtemp']))
               {
                $tienebandobjband='Y';
               }
            }
            if ($tienebandobjband=='N')
            {
              echo "<span style='color:red'>tienebandobjband->".$tienebandobjband."</span>";  
            }
            else
            {

                  $sqlborrarattt ="delete from products_attributes where idproduct = ".$idproductpublico." and idattribute in (72,107)";
               echo "<br>".$sqlborrarattt;
                  $connect->query($sqlborrarattt)->fetchAll();
        

            //  echo "<br>tienebandobjband->".$tienebandobjband;

              $query_diego2attr="select * from products_attributes where idattribute= 72 and   idproduct= ".  $vidproduct;
           ///   echo $query_diego2attr;
              $datadiegow2attri = $connect->query($query_diego2attr)->fetchAll();	
         //    echo "<>brBuscando attributos.....<br>";
              foreach ($datadiegow2attri as $rowdiegow2atri) 
              {
          //        echo "v_integer:".$rowdiegow2atri['v_integer']." - v_double: ".$rowdiegow2atri['v_double']."<br>";
          //        echo "<br>****--> Vamos a Insertar 1 idband: ".$rowmigrar['idbandtemp']." - fijo datos de ".$rowmigrar['idsubbandtemp'];
          //        echo "<br>****--> Vamos a Insertar 2 idband: ".$rowmigrar['idbandtemp2']." - fijo datos de ".$rowmigrar['idsubband2temp'];
          //        echo "<br>****--> Vamos a Insertar 3 idband: ".$rowmigrar['idbandtemp3']." - fijo datos de ".$rowmigrar['idsubband3temp'];
                  //$cantband=0;
                  //if ()
              }
              echo "<br>** controlando bandas para attributos";
              if ($rowmigrar['idbandtemp'] <> ''  && $rowmigrar['idbandtemp2'] =='')
              {
                 ////// Tiene 1 Band 
                 $cantsubband=0;
                 if ($rowmigrar['idsubbandtemp'] <> '') {  $cantsubband=$cantsubband + 1; }
                 if ($rowmigrar['idsubband2temp'] <> '') {  $cantsubband=$cantsubband + 1; }
                 if ($rowmigrar['idsubband3temp'] <> '') {  $cantsubband=$cantsubband + 1; }
                 
                  echo "<br>Updateo a band:".$rowmigrar['idbandtemp']." - Cant subband:".$cantsubband;
                  $sqlinseratt2 ="INSERT INTO public.products_attributes (idproduct, idattribute, datemodif, v_boolean, v_integer, v_double, v_string, v_date)
                  VALUES($idproductpublico, 72, now(), true, ".$rowmigrar['idbandtemp'].", ".$cantsubband.", null,null);";
                  echo "<br>".$sqlinseratt2;
                  if ($cantsubband ==1)
                  {
                    echo "<br>nuevo attributo  [".$rowmigrar['idsubbandtemp']."]";
                   

                      $sqlinseratt ="INSERT INTO public.products_attributes (idproduct, idattribute, datemodif, v_boolean, v_integer, v_double, v_string, v_date)
                      VALUES($idproductpublico, 107, now(), null, ".$rowmigrar['idbandtemp'].", ".$rowmigrar['idsubbandtemp'].", null,null);";
                      echo "<br>".$sqlinseratt;
                  }
                  else
                  {
                    echo "<br>nuevo attributo  [".$rowmigrar['idsubbandtemp']."] - idsubbandtemp2: [".$rowmigrar['idsubband2temp']."]";
                  


                    $sqlinseratt ="INSERT INTO public.products_attributes (idproduct, idattribute, datemodif, v_boolean, v_integer, v_double, v_string, v_date)
                    VALUES($idproductpublico, 107, now(), null, ".$rowmigrar['idbandtemp'].", ".$rowmigrar['idsubbandtemp'].", null,null);";
                    echo "<br>".$sqlinseratt;
                    $connect->query($sqlinseratt)->fetchAll();
                    if ($rowmigrar['idsubband2temp'] !="")
                    {
                      $sqlinseratt2 ="INSERT INTO public.products_attributes (idproduct, idattribute, datemodif, v_boolean, v_integer, v_double, v_string, v_date)
                      VALUES($idproductpublico, 72, now(), true, ".$rowmigrar['idsubband2temp'].",1, null,null);";
                      echo "<br>".$sqlinseratt2;
                      $connect->query($sqlinseratt2)->fetchAll();

                      $sqlinseratt ="INSERT INTO public.products_attributes (idproduct, idattribute, datemodif, v_boolean, v_integer, v_double, v_string, v_date)
                      VALUES($idproductpublico, 107, now(), null, ".$rowmigrar['idbandtemp'].", ".$rowmigrar['idsubband2temp'].", null,null);";
                      echo "<br>".$sqlinseratt;
                      $connect->query($sqlinseratt)->fetchAll();
                    }
     
                  }
              }
              if ($rowmigrar['idbandtemp'] <> ''  && $rowmigrar['idbandtemp2'] <> '' && $rowmigrar['idbandtemp3'] =='')
              {
                 ////// Tiene 1 Band 
                 $cantsubband=0;
                 if ($rowmigrar['idbandtemp']== $rowmigrar['idbandtemp2'])
                 {
                    if ($rowmigrar['idsubbandtemp'] <> '') {  $cantsubband=$cantsubband + 1; }
                    if ($rowmigrar['idsubband2temp'] <> '') {  $cantsubband=$cantsubband + 1; }
                    if ($rowmigrar['idsubband3temp'] <> '') {  $cantsubband=$cantsubband + 1; }
                    echo "<br>Updateo a band:".$rowmigrar['idbandtemp']." - Cant subband:".$cantsubband;
                    $sqlinseratt2 ="INSERT INTO public.products_attributes (idproduct, idattribute, datemodif, v_boolean, v_integer, v_double, v_string, v_date)
                    VALUES($idproductpublico, 72, now(), true, ".$rowmigrar['idbandtemp'].", ".$cantsubband.", null,null);";
                    echo "<br>".$sqlinseratt2;
                    $connect->query($sqlinseratt2)->fetchAll();
                     
                    if ($cantsubband ==1)
                  {
                    echo "<br>2nuevo attributo  [".$rowmigrar['idsubbandtemp']."]";
                    $sqlinseratt ="INSERT INTO public.products_attributes (idproduct, idattribute, datemodif, v_boolean, v_integer, v_double, v_string, v_date)
                    VALUES($idproductpublico, 107, now(), null, ".$rowmigrar['idbandtemp'].", ".$rowmigrar['idsubbandtemp'].", null,null);";
                    echo "<br>".$sqlinseratt;
                    $connect->query($sqlinseratt)->fetchAll();
                   
                    if ($rowmigrar['idsubband2temp'] !="")
                    {
                      $sqlinseratt2 ="INSERT INTO public.products_attributes (idproduct, idattribute, datemodif, v_boolean, v_integer, v_double, v_string, v_date)
                      VALUES($idproductpublico, 72, now(), true, ".$rowmigrar['idsubband2temp'].", 1, null,null);";
                      echo "<br>".$sqlinseratt2;
                      $connect->query($sqlinseratt2)->fetchAll();

                      $sqlinseratt ="INSERT INTO public.products_attributes (idproduct, idattribute, datemodif, v_boolean, v_integer, v_double, v_string, v_date)
                      VALUES($idproductpublico, 107, now(), null, ".$rowmigrar['idbandtemp'].", ".$rowmigrar['idsubband2temp'].", null,null);";
                      echo "<br>".$sqlinseratt;
                      $connect->query($sqlinseratt)->fetchAll();
                    }

                  }
                  else
                  {
                    echo "<br>2nuevo attributo  [".$rowmigrar['idsubbandtemp']."] - idsubbandtemp2: [".$rowmigrar['idsubband2temp']."]";
                    $sqlinseratt ="INSERT INTO public.products_attributes (idproduct, idattribute, datemodif, v_boolean, v_integer, v_double, v_string, v_date)
                    VALUES($idproductpublico, 107, now(), null, ".$rowmigrar['idbandtemp'].", ".$rowmigrar['idsubbandtemp'].", null,null);";
                    echo "<br>".$sqlinseratt;
                    $connect->query($sqlinseratt)->fetchAll();
                  

                    if ($rowmigrar['idsubband2temp'] !="")
                    {
                      $sqlinseratt ="INSERT INTO public.products_attributes (idproduct, idattribute, datemodif, v_boolean, v_integer, v_double, v_string, v_date)
                      VALUES($idproductpublico, 107, now(), null, ".$rowmigrar['idbandtemp'].", ".$rowmigrar['idsubband2temp'].", null,null);";
                      echo "<br>".$sqlinseratt;
                      $connect->query($sqlinseratt)->fetchAll();
                    }
                  }
                  
                 }
                 else
                {

                  echo "<br>Updateo a band:".$rowmigrar['idbandtemp']." - Cant subband: 1";
                  echo "<br>Updateo a band:".$rowmigrar['idbandtemp2']." - Cant subband: 1";
                  $sqlinseratt2 ="INSERT INTO public.products_attributes (idproduct, idattribute, datemodif, v_boolean, v_integer, v_double, v_string, v_date)
                  VALUES($idproductpublico, 72, now(), true, ".$rowmigrar['idbandtemp'].", 1, null,null);";
                  echo "<br>".$sqlinseratt2;
                  $connect->query($sqlinseratt2)->fetchAll();
                 

                  if ($cantsubband ==1)
                  {
                    echo "<br>nuevo attributo  [".$rowmigrar['idsubbandtemp']."]";
                    $sqlinseratt ="INSERT INTO public.products_attributes (idproduct, idattribute, datemodif, v_boolean, v_integer, v_double, v_string, v_date)
                    VALUES($idproductpublico, 107, now(), null, ".$rowmigrar['idbandtemp'].", ".$rowmigrar['idsubbandtemp'].", null,null);";
                    echo "<br>".$sqlinseratt;
                    $connect->query($sqlinseratt)->fetchAll();
                    if ($rowmigrar['idsubband2temp'] !="")
                    {
                      $sqlinseratt ="INSERT INTO public.products_attributes (idproduct, idattribute, datemodif, v_boolean, v_integer, v_double, v_string, v_date)
                      VALUES($idproductpublico, 107, now(), null, ".$rowmigrar['idbandtemp'].", ".$rowmigrar['idsubband2temp'].", null,null);";
                      echo "<br>".$sqlinseratt;
                      $connect->query($sqlinseratt)->fetchAll();
                    }
                  }
                  else
                  {
                    echo "<br>nuevo attributo  [".$rowmigrar['idsubbandtemp']."] - idsubbandtemp2: [".$rowmigrar['idsubband2temp']."]";
                    $sqlinseratt ="INSERT INTO public.products_attributes (idproduct, idattribute, datemodif, v_boolean, v_integer, v_double, v_string, v_date)
                    VALUES($idproductpublico, 107, now(), null, ".$rowmigrar['idbandtemp'].", ".$rowmigrar['idsubbandtemp'].", null,null);";
                    echo "<br>".$sqlinseratt;
                    $connect->query($sqlinseratt)->fetchAll();
                  
                    if ($rowmigrar['idsubband2temp'] !="")
                    {
                      $sqlinseratt ="INSERT INTO public.products_attributes (idproduct, idattribute, datemodif, v_boolean, v_integer, v_double, v_string, v_date)
                      VALUES($idproductpublico, 107, now(), null, ".$rowmigrar['idbandtemp'].", ".$rowmigrar['idsubband2temp'].", null,null);";
                      echo "<br>".$sqlinseratt;
                      $connect->query($sqlinseratt)->fetchAll();
                    }
                  }

                }
            
              }
              if ($rowmigrar['idbandtemp'] <> ''  && $rowmigrar['idbandtemp2'] <> '' && $rowmigrar['idbandtemp3'] <> '')
              {
                echo "<br>Updateo a band:".$rowmigrar['idbandtemp']." - Cant subband: 2";
                echo "<br>Updateo a band:".$rowmigrar['idbandtemp3']." - Cant subband: 1";
                $sqlinseratt2 ="INSERT INTO public.products_attributes (idproduct, idattribute, datemodif, v_boolean, v_integer, v_double, v_string, v_date)
                VALUES($idproductpublico, 72, now(), true, ".$rowmigrar['idbandtemp'].", 2, null,null);";
                echo "<br>".$sqlinseratt2;
                $connect->query($sqlinseratt2)->fetchAll();
                $sqlinseratt2 ="INSERT INTO public.products_attributes (idproduct, idattribute, datemodif, v_boolean, v_integer, v_double, v_string, v_date)
                VALUES($idproductpublico, 72, now(), true, ".$rowmigrar['idbandtemp3'].", 1, null,null);";
                echo "<br>".$sqlinseratt2;
                $connect->query($sqlinseratt)->fetchAll();

                if ($cantsubband ==1)
                  {
                    echo "<br>3nuevo attributo  [".$rowmigrar['idsubbandtemp']."]";
                    $sqlinseratt ="INSERT INTO public.products_attributes (idproduct, idattribute, datemodif, v_boolean, v_integer, v_double, v_string, v_date)
                    VALUES($idproductpublico, 107, now(), null, ".$rowmigrar['idbandtemp'].", ".$rowmigrar['idsubbandtemp'].", null,null);";
                    echo "<br>".$sqlinseratt;
                    $connect->query($sqlinseratt)->fetchAll();
                    if ($rowmigrar['idsubband2temp'] !="")
                    {
                      $sqlinseratt ="INSERT INTO public.products_attributes (idproduct, idattribute, datemodif, v_boolean, v_integer, v_double, v_string, v_date)
                      VALUES($idproductpublico, 107, now(), null, ".$rowmigrar['idbandtemp'].", ".$rowmigrar['idsubband2temp'].", null,null);";
                      echo "<br>".$sqlinseratt;
                      $connect->query($sqlinseratt)->fetchAll();
                    }
                  }
                  else
                  {
                    echo "<br>3nuevo attributo  [".$rowmigrar['idsubbandtemp']."] - idsubbandtemp2: [".$rowmigrar['idsubband2temp']."]";
                    $sqlinseratt ="INSERT INTO public.products_attributes (idproduct, idattribute, datemodif, v_boolean, v_integer, v_double, v_string, v_date)
                    VALUES($idproductpublico, 107, now(), null, ".$rowmigrar['idbandtemp'].", ".$rowmigrar['idsubbandtemp'].", null,null);";
                    echo "<br>".$sqlinseratt;
                    $connect->query($sqlinseratt)->fetchAll();
                    if ($rowmigrar['idsubband2temp'] !="")
                    {
                      $sqlinseratt ="INSERT INTO public.products_attributes (idproduct, idattribute, datemodif, v_boolean, v_integer, v_double, v_string, v_date)
                      VALUES($idproductpublico, 107, now(), null, ".$rowmigrar['idbandtemp'].", ".$rowmigrar['idsubband2temp'].", null,null);";
                      echo "<br>".$sqlinseratt;
                      $connect->query($sqlinseratt)->fetchAll();
                    }
                  }
              } 


            }
            
            ///////////////////
            
            ///////////////////////////
            if($productexiste == 'N')
            {
          
                ?>
                <span class='text text-danger'>Missing Product </span>
                <?php
            }


          }
          
          
          ?>
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
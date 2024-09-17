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
	//		exit();
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
            <h1>Calibration Enterprise - TimeLine</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Calibration Enterprise </li>
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
					 
        <script src="jstimeline/vis-timeline-graph2d.min.js"></script>
  <link href="jstimeline/vis-timeline-graph2d.min.css" rel="stylesheet" type="text/css" />
  <style type="text/css">
   
 
 
  </style>
 
 <?php
 if ($_REQUEST['idruninfo']=="")
 {
?>
<br>
<div class="col-md-3 col-sm-6 col-12">
            <div class="info-box bg-gradient-danger">
              <span class="info-box-icon"><i class="fas fa-exclamation-triangle"></i></span>

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
						<h6 class="card-title colorazulfiplex" id="totalpassarriba" name="totalpassarriba">
            </h6>
		 

					</div>
<br>
<p><b>List of Executed Steps:  </b>

</p>
<p name="msjwaitline1" id="msjwaitline1" class=" " align="center"><img src="img/waitazul.gif" width="100px" ></p>	
 <div class="horizontal-scroll-contenedor" id="timelinerutines" name="timelinerutines">
 
</div>
 
<!-- fin timeline horiz -->
 
<!-- GRAFICOS ecualización -->
<div id="grafgralecump" name="grafgralecump" class=""   >

<section class="col-lg-12 connectedSortable ui-sortable">
  <br>  <h5 class="colorazulfiplex" ><b>RF Parameters</b></h5>



  <?php
  /// Comenzamos a cargar las variables de los graficos.

  $elsn=$_REQUEST['sn'];
  $elruninfo=$_REQUEST['idruninfo'];

  $laquery="  select distinct sn ,idorder , fas_routines_steps.instance , titlestep  as script,  fas_routines_process_sn.iduniqueop , fas_times.duration as duration,   fas_times_type.timename,
  fas_outcome_integral.v_boolean as totalpass ,'*-*-*',lasmediciones.*
    from fas_routines_process_sn 
    inner join fas_routines_steps
    on fas_routines_steps.idstep = fas_routines_process_sn.idstep
  inner join fas_step
  on fas_step.instance =  fas_routines_steps.instance

    left join fas_times
    on fas_times.iduniqueop   = fas_routines_process_sn.iduniqueop 
    and fas_times.idsinglemeasure is null 
    and fas_times.idsameasures is null
    and fas_times.iducmeasure is null

    left join fas_times_type
    on fas_times_type.idtimetype = fas_times.idtimetype

    left join fas_outcome_integral
    on fas_outcome_integral.reference=  fas_routines_process_sn.iduniqueop  
    AND idfasoutcomecat = 1 AND idtype = 0 and fas_outcome_integral.v_boolean is not null
  
  inner join 
  (
     
    
select *
from (

  select 'ADVALUE_ALLVER' as tipocalculo, idband , uldl, iduniqueop, nomband, fas_outcome_integral.idfasoutcomecat, fas_outcome_integral.idtype ,  ARRAY_AGG(fas_outcome_integral.v_double order by fas_outcome_integral.datetimeref) as arraydoublem,  ARRAY_AGG(fas_outcome_integral.v_integer order by fas_outcome_integral.datetimeref) as  arrayintegerm
from fas_outcome_integral
inner join ( 

  select vv_id_outcome as id_outcome  , vv_idsinglemeasure as idsinglemeasure ,vv_iduniqueop as iduniqueop,  vv_uldl as uldl , 
	vv_idband as idband, vv_nomband as nomband, vv_idtype as  idtype
	 
	from select_outcome_integral_singlem_band_uldl_iduniqueop(".$elruninfo.") as tt

) as losiduniqueop
on losiduniqueop.id_outcome = fas_outcome_integral.reference
inner join fas_outcome_category
on fas_outcome_category.idcategory = fas_outcome_integral.idfasoutcomecat
inner join fas_outcome_category_type
on fas_outcome_category_type.idfasoutcomecat = fas_outcome_integral.idfasoutcomecat and 
fas_outcome_category_type.idtype			 = fas_outcome_integral.idtype

left join fas_outcome_integral as fas_outcome_integralband on fas_outcome_integralband.reference= losiduniqueop.iduniqueop AND 
fas_outcome_integralband.idfasoutcomecat = 1 AND fas_outcome_integralband.idtype = 1 

left join fas_outcome_integral as fas_outcome_integraluldl on fas_outcome_integraluldl.reference= losiduniqueop.iduniqueop AND 
fas_outcome_integraluldl.idfasoutcomecat = 1 AND fas_outcome_integraluldl.idtype = 1 

where fas_outcome_integral.idfasoutcomecat in (11) and fas_outcome_integral.idtype in (36,37)
group by idband , uldl, iduniqueop, nomband, fas_outcome_integral.idfasoutcomecat, fas_outcome_integral.idtype 

union
 
select 'ADVALUE' as tipocalculo, idband , uldl, iduniqueop, nomband, fas_outcome_integral.idfasoutcomecat, fas_outcome_integral.idtype ,  ARRAY_AGG(fas_outcome_integral.v_double order by fas_outcome_integral.datetimeref) as arraydoublem,  ARRAY_AGG(fas_outcome_integral.v_integer order by fas_outcome_integral.datetimeref) as  arrayintegerm
from fas_outcome_integral
inner join ( 
 
  select vv_id_outcome as id_outcome  , vv_idsinglemeasure as idsinglemeasure ,vv_iduniqueop as iduniqueop,  vv_uldl as uldl , 
	vv_idband as idband, vv_nomband as nomband, vv_idtype as  idtype
	 
	from select_outcome_integral_singlem_band_uldl_iduniqueop(".$elruninfo.") as tt

) as losiduniqueop
on losiduniqueop.id_outcome = fas_outcome_integral.reference
inner join fas_outcome_category
on fas_outcome_category.idcategory = fas_outcome_integral.idfasoutcomecat
inner join fas_outcome_category_type
on fas_outcome_category_type.idfasoutcomecat = fas_outcome_integral.idfasoutcomecat and 
fas_outcome_category_type.idtype			 = fas_outcome_integral.idtype

left join fas_outcome_integral as fas_outcome_integralband on fas_outcome_integralband.reference= losiduniqueop.iduniqueop AND 
fas_outcome_integralband.idfasoutcomecat = 1 AND fas_outcome_integralband.idtype = 1 

left join fas_outcome_integral as fas_outcome_integraluldl on fas_outcome_integraluldl.reference= losiduniqueop.iduniqueop AND 
fas_outcome_integraluldl.idfasoutcomecat = 1 AND fas_outcome_integraluldl.idtype = 1 

where fas_outcome_integral.idfasoutcomecat in (11) and fas_outcome_integral.idtype in (36,37,15,16)
group by idband , uldl, iduniqueop, nomband, fas_outcome_integral.idfasoutcomecat, fas_outcome_integral.idtype 

union
 
select 'AGC_ACTING', idband , uldl, iduniqueop, nomband, fas_outcome_integral.idfasoutcomecat, fas_outcome_integral.idtype ,  ARRAY_AGG(fas_outcome_integral.v_double order by fas_outcome_integral.datetimeref),  ARRAY_AGG(fas_outcome_integral.v_integer order by fas_outcome_integral.datetimeref)
from fas_outcome_integral
inner join ( 
 
  select vv_id_outcome as id_outcome  , vv_idsinglemeasure as idsinglemeasure ,vv_iduniqueop as iduniqueop,  vv_uldl as uldl , 
	vv_idband as idband, vv_nomband as nomband, vv_idtype as  idtype
	 
	from select_outcome_integral_singlem_band_uldl_iduniqueop(".$elruninfo.") as tt

) as losiduniqueop
on losiduniqueop.id_outcome = fas_outcome_integral.reference
inner join fas_outcome_category
on fas_outcome_category.idcategory = fas_outcome_integral.idfasoutcomecat
inner join fas_outcome_category_type
on fas_outcome_category_type.idfasoutcomecat = fas_outcome_integral.idfasoutcomecat and 
fas_outcome_category_type.idtype			 = fas_outcome_integral.idtype
where fas_outcome_integral.idfasoutcomecat in (11) and fas_outcome_integral.idtype in (7,8,3,4)
group by idband , uldl, iduniqueop, nomband, fas_outcome_integral.idfasoutcomecat, fas_outcome_integral.idtype 
union 

select 'FREQ_PWR_IN', idband , uldl, iduniqueop, nomband, fas_outcome_integral.idfasoutcomecat, fas_outcome_integral.idtype ,  ARRAY_AGG(fas_outcome_integral.v_double order by fas_outcome_integral.datetimeref),  ARRAY_AGG(fas_outcome_integral.v_integer order by fas_outcome_integral.datetimeref)
from fas_outcome_integral
inner join ( 
  
  select vv_id_outcome as id_outcome  , vv_idsinglemeasure as idsinglemeasure ,vv_iduniqueop as iduniqueop,  vv_uldl as uldl , 
	vv_idband as idband, vv_nomband as nomband, vv_idtype as  idtype
	 
	from select_outcome_integral_singlem_band_uldl_iduniqueop(".$elruninfo.") as tt


) as losiduniqueop
on losiduniqueop.id_outcome = fas_outcome_integral.reference
inner join fas_outcome_category
on fas_outcome_category.idcategory = fas_outcome_integral.idfasoutcomecat
inner join fas_outcome_category_type
on fas_outcome_category_type.idfasoutcomecat = fas_outcome_integral.idfasoutcomecat and 
fas_outcome_category_type.idtype			 = fas_outcome_integral.idtype
where fas_outcome_integral.idfasoutcomecat in (6,7) and fas_outcome_integral.idtype in (0,1,2)
group by idband , uldl, iduniqueop, nomband, fas_outcome_integral.idfasoutcomecat, fas_outcome_integral.idtype 

union 
 

select 'PWR_OUT_MEASURE', idband , uldl, iduniqueop, nomband, fas_outcome_integral.idfasoutcomecat, fas_outcome_integral.idtype ,  ARRAY_AGG(fas_outcome_integral.v_double order by fas_outcome_integral.datetimeref),  ARRAY_AGG(fas_outcome_integral.v_integer order by fas_outcome_integral.datetimeref)
from fas_outcome_integral
inner join ( 
  
  select vv_id_outcome as id_outcome  , vv_idsinglemeasure as idsinglemeasure ,vv_iduniqueop as iduniqueop,  vv_uldl as uldl , 
	vv_idband as idband, vv_nomband as nomband, vv_idtype as  idtype
	 
	from select_outcome_integral_singlem_band_uldl_iduniqueop(".$elruninfo.") as tt
  
) as losiduniqueop
on losiduniqueop.id_outcome = fas_outcome_integral.reference
inner join fas_outcome_category
on fas_outcome_category.idcategory = fas_outcome_integral.idfasoutcomecat
inner join fas_outcome_category_type
on fas_outcome_category_type.idfasoutcomecat = fas_outcome_integral.idfasoutcomecat and 
fas_outcome_category_type.idtype			 = fas_outcome_integral.idtype
where fas_outcome_integral.idfasoutcomecat in (7)
and fas_outcome_integral.idtype in (1)
group by idband , uldl, iduniqueop, nomband, fas_outcome_integral.idfasoutcomecat, fas_outcome_integral.idtype 
) as todosss 

union
  

select 'PWR_OUT', idband , uldl, iduniqueop, nomband, fas_outcome_integral.idfasoutcomecat, fas_outcome_integral.idtype ,  ARRAY_AGG(fas_outcome_integral.v_double order by fas_outcome_integral.datetimeref),  ARRAY_AGG(fas_outcome_integral.v_integer order by fas_outcome_integral.datetimeref)
 from (

  
  select vv_id_outcome as id_outcome  , vv_idsinglemeasure as idsinglemeasure ,vv_iduniqueop as iduniqueop,  vv_uldl as uldl , 
	vv_idband as idband, vv_nomband as nomband, vv_idtype as  idtype
	 
	from select_outcome_integral_singlem_band_uldl_iduniqueop(".$elruninfo.") as tt
	  

) as losiduniqueop
inner join fas_outcome_integral
on losiduniqueop.iduniqueop = fas_outcome_integral.reference
where 
fas_outcome_integral.idfasoutcomecat =2 and fas_outcome_integral.idtype in(19,24)
group by idband , uldl, iduniqueop, nomband, fas_outcome_integral.idfasoutcomecat, fas_outcome_integral.idtype 
     
  ) as lasmediciones
  on lasmediciones.iduniqueop =  fas_routines_process_sn.iduniqueop
  
  

    where sn = '".$elsn."' and idruninfodb = ".$elruninfo." 

     
   
    order by idorder";

    
    /*

    
    and ( tipocalculo = 'ADVALUE_ALLVER' or     idrev in (select max(idrev) from fas_routines_process_sn 
    where sn = '".$elsn."' and idruninfodb =  ".$elruninfo.") )
      and 
    idrev in (select max(idrev) from fas_routines_process_sn 
          where sn = '".$elsn."' and idruninfodb =  ".$elruninfo.")
    
          */

   echo $laquery;
    $datacabez = $connect->query($laquery)->fetchAll();							

    $agc_band_0_0="";
    $agc_band_0_1="";
    $agc_band_1_0="";
    $agc_band_0_1="";

    $_band_0_0="";
    $_band_0_1="";
    $_band_1_0="";
    $_band_0_1="";

    $simbolosareemplazar = array("{", "}");
   ///example__ $onlyconsonants = str_replace($vowels, "", "Hello World of PHP");

    foreach ($datacabez as $rowdatos)     
    {

       /////Lineality Check
            if("002007031" ==$rowdatos['instance'])
            {
                /*
                category 11. idtype 15 para band 0 - lineality
                category 11. idtype 16 para band 1 - lineality  - valor esperado

                category 7. idtype 1 para band 1 - lineality - valor medido
                category 11. idtype 7 para band 1 - lineality - ejex x  - ok


                */
                if ($rowdatos['idfasoutcomecat'] == 11 && $rowdatos['idtype'] ==7)
                {
                  if ($rowdatos['idband'] == 0 && $rowdatos['uldl'] ==0)
                  {
                     
                      $table_lineality_ejex_0_0= $rowdatos['arrayintegerm'];                      
                      $table_lineality_ejex_0_0=  str_replace($simbolosareemplazar, "", $table_lineality_ejex_0_0);
                  }
                  if ($rowdatos['idband'] == 0 && $rowdatos['uldl'] ==1)
                  {
                       
                      $table_lineality_ejex_0_1= $rowdatos['arrayintegerm'];                      
                      $table_lineality_ejex_0_1=  str_replace($simbolosareemplazar, "", $table_lineality_ejex_0_1);
                  }
                }
                if ($rowdatos['idfasoutcomecat'] == 11 && $rowdatos['idtype'] ==8)
                {
                  if ($rowdatos['idband'] == 1 && $rowdatos['uldl'] ==0)
                  {
                       
                      $table_lineality_ejex_1_0= $rowdatos['arrayintegerm'];                      
                      $table_lineality_ejex_1_0=  str_replace($simbolosareemplazar, "", $table_lineality_ejex_1_0);
                  }
                  if ($rowdatos['idband'] == 1 && $rowdatos['uldl'] ==1)
                  {
                       
                      $table_lineality_ejex_1_1= $rowdatos['arrayintegerm'];                      
                      $table_lineality_ejex_1_1=  str_replace($simbolosareemplazar, "", $table_lineality_ejex_1_1);
                  }
                }
                ////lineality valor esperado
                if ($rowdatos['idfasoutcomecat'] == 7 && $rowdatos['idtype'] ==1)
                {
                    if("FREQ_PWR_IN" ==$rowdatos['tipocalculo'])
                    {
                      if ($rowdatos['idband'] == 0 && $rowdatos['uldl'] ==0)
                      {
                        $lineality_graf_totalpass_0_0  =  $rowdatos['totalpass'];
                        $table_lineality_MkrPeakSearch_0_0= $rowdatos['arraydoublem'];                      
                        $table_lineality_MkrPeakSearch_0_0=  str_replace($simbolosareemplazar, "", $table_lineality_MkrPeakSearch_0_0);
                      }
                      if ($rowdatos['idband'] == 0 && $rowdatos['uldl'] ==1)
                      {
                        $lineality_graf_totalpass_0_1  =  $rowdatos['totalpass'];
                        $table_lineality_MkrPeakSearch_0_1= $rowdatos['arraydoublem'];                      
                        $table_lineality_MkrPeakSearch_0_1=  str_replace($simbolosareemplazar, "", $table_lineality_MkrPeakSearch_0_1);
                      }
                      if ($rowdatos['idband'] == 1 && $rowdatos['uldl'] ==0)
                      {
                        $lineality_graf_totalpass_1_0  =  $rowdatos['totalpass'];
                        $table_lineality_MkrPeakSearch_1_0= $rowdatos['arraydoublem'];                      
                        $table_lineality_MkrPeakSearch_1_0=  str_replace($simbolosareemplazar, "", $table_lineality_MkrPeakSearch_1_0);
                      }
                      if ($rowdatos['idband'] == 1 && $rowdatos['uldl'] == 1)
                      {
                        $lineality_graf_totalpass_1_1  =  $rowdatos['totalpass'];
                        $table_lineality_MkrPeakSearch_1_1= $rowdatos['arraydoublem'];                      
                        $table_lineality_MkrPeakSearch_1_1=  str_replace($simbolosareemplazar, "", $table_lineality_MkrPeakSearch_1_1);
                      }
                    }
                }  

                /////lineality valor medido
                 
                    if("ADVALUE" ===$rowdatos['tipocalculo'])
                    {
                      if ($rowdatos['idband'] == 0 && $rowdatos['uldl'] ==0 && $rowdatos['idfasoutcomecat'] == 11 && $rowdatos['idtype'] ==15 )
                      {
                        $table_lineality_uCPwrForward_0_0= $rowdatos['arraydoublem'];                      
                        $table_lineality_uCPwrForward_0_0=  str_replace($simbolosareemplazar, "", $table_lineality_uCPwrForward_0_0);
                      }
                      if ($rowdatos['idband'] == 0 && $rowdatos['uldl'] ==1 && $rowdatos['idfasoutcomecat'] == 11 && $rowdatos['idtype'] ==15)
                      {
                        $table_lineality_uCPwrForward_0_1= $rowdatos['arraydoublem'];                      
                        $table_lineality_uCPwrForward_0_1=  str_replace($simbolosareemplazar, "", $table_lineality_uCPwrForward_0_1);
                      }
                      if ($rowdatos['idband'] == 1 && $rowdatos['uldl'] ==0 && $rowdatos['idfasoutcomecat'] == 11 && $rowdatos['idtype'] ==16)
                      {
                        $table_lineality_uCPwrForward_1_0= $rowdatos['arraydoublem'];                      
                        $table_lineality_uCPwrForward_1_0=  str_replace($simbolosareemplazar, "", $table_lineality_uCPwrForward_1_0);
                      }
                      if ($rowdatos['idband'] == 1 && $rowdatos['uldl'] == 1 && $rowdatos['idfasoutcomecat'] == 11 && $rowdatos['idtype'] ==16)
                      {
                        $table_lineality_uCPwrForward_1_1= $rowdatos['arraydoublem'];                      
                        $table_lineality_uCPwrForward_1_1=  str_replace($simbolosareemplazar, "", $table_lineality_uCPwrForward_1_1);
                      }
                    }
                  
            }
      /////IMD3 Check
            if("00200701B" ==$rowdatos['instance'])
              {
                if ($rowdatos['idfasoutcomecat'] == 7 && $rowdatos['idtype'] ==0)
                {
                  if ($rowdatos['idband'] == 0 && $rowdatos['uldl'] ==0)
                  {
                      $tabla_imd3_totalpass_0_0 = $rowdatos['totalpass'];
                      $table_imd3_freq_0_0= $rowdatos['arraydoublem'];                      
                      $table_imd3_freq_0_0=  str_replace($simbolosareemplazar, "", $table_imd3_freq_0_0);
                  }
                  if ($rowdatos['idband'] == 0 && $rowdatos['uldl'] ==1)
                  {
                    $table_imd3_freq_0_1= $rowdatos['arraydoublem'];                      
                    $table_imd3_freq_0_1=  str_replace($simbolosareemplazar, "", $table_imd3_freq_0_1);
                    $tabla_imd3_totalpass_0_1 = $rowdatos['totalpass'];
                  }
                  if ($rowdatos['idband'] == 1 && $rowdatos['uldl'] ==0)
                  {
                    $table_imd3_freq_1_0= $rowdatos['arraydoublem'];                      
                    $table_imd3_freq_1_0=  str_replace($simbolosareemplazar, "", $table_imd3_freq_1_0);
                    $tabla_imd3_totalpass_1_0 = $rowdatos['totalpass'];
                  }
                  if ($rowdatos['idband'] == 1 && $rowdatos['uldl'] ==1)
                  {
                    $table_imd3_freq_1_1= $rowdatos['arraydoublem'];                      
                    $table_imd3_freq_1_1=  str_replace($simbolosareemplazar, "", $table_imd3_freq_1_1);
                    $tabla_imd3_totalpass_1_1 = $rowdatos['totalpass'];
                  }
                  
                }
                if ($rowdatos['idfasoutcomecat'] == 7 && $rowdatos['idtype'] ==1)
                {

                  if ($rowdatos['idband'] == 0 && $rowdatos['uldl'] ==0)
                  {
                      $table_imd3_values_0_0= $rowdatos['arraydoublem'];                      
                      $table_imd3_values_0_0=  str_replace($simbolosareemplazar, "", $table_imd3_values_0_0);
                  }
                  if ($rowdatos['idband'] == 0 && $rowdatos['uldl'] ==1)
                  {
                    $table_imd3_values_0_1= $rowdatos['arraydoublem'];                      
                    $table_imd3_values_0_1=  str_replace($simbolosareemplazar, "", $table_imd3_values_0_1);
                  }
                  if ($rowdatos['idband'] == 1 && $rowdatos['uldl'] ==0)
                  {
                    $table_imd3_values_1_0= $rowdatos['arraydoublem'];                      
                    $table_imd3_values_1_0=  str_replace($simbolosareemplazar, "", $table_imd3_values_1_0);
                  }
                  if ($rowdatos['idband'] == 1 && $rowdatos['uldl'] ==1)
                  {
                    $table_imd3_values_1_1= $rowdatos['arraydoublem'];                      
                    $table_imd3_values_1_1=  str_replace($simbolosareemplazar, "", $table_imd3_values_1_1);
                  }
                }

              }     
              
              ///**************** */
              if ($rowdatos['idfasoutcomecat'] == 2 && $rowdatos['idtype'] ==19)
              {
                  if("PWR_OUT" ==$rowdatos['tipocalculo'])
                  {
                    if ($rowdatos['idband'] == 0 && $rowdatos['uldl'] ==0)
                    {
                      $pwr_out_exp_band_qq_maxp_0_0=$rowdatos['arraydoublem'];
                      $pwr_out_exp_band_qq_maxp_0_0=  str_replace($simbolosareemplazar, "", $pwr_out_exp_band_qq_maxp_0_0);
                      $maxpwr_graf_totalpass_0_0  = $rowdatos['totalpass'];
                    }
                    if ($rowdatos['idband'] == 0 && $rowdatos['uldl'] ==1)
                    {
                      $pwr_out_exp_band_qq_maxp_0_1=$rowdatos['arraydoublem'];
                      $pwr_out_exp_band_qq_maxp_0_1=  str_replace($simbolosareemplazar, "", $pwr_out_exp_band_qq_maxp_0_1);
                      $maxpwr_graf_totalpass_0_1  = $rowdatos['totalpass'];
                    }
                    if ($rowdatos['idband'] == 1 && $rowdatos['uldl'] ==0)
                    {
                      $pwr_out_exp_band_qq_maxp_1_0=$rowdatos['arraydoublem'];
                      $pwr_out_exp_band_qq_maxp_1_0=  str_replace($simbolosareemplazar, "", $pwr_out_exp_band_qq_maxp_1_0);
                      $maxpwr_graf_totalpass_1_0  = $rowdatos['totalpass'];
                    }
                    if ($rowdatos['idband'] == 1 && $rowdatos['uldl'] ==1)
                    {
                      $pwr_out_exp_band_qq_maxp_1_1=$rowdatos['arraydoublem'];
                      $pwr_out_exp_band_qq_maxp_1_1=  str_replace($simbolosareemplazar, "", $pwr_out_exp_band_qq_maxp_1_1);
                      $maxpwr_graf_totalpass_1_1  = $rowdatos['totalpass'];
                    }
                  }
               }

                 //*****MAX PWR Check  */
            if("00200701A" ==$rowdatos['instance'])   
            {

              if("FREQ_PWR_IN" ==$rowdatos['tipocalculo'])
              {
                  
                  if ($rowdatos['idfasoutcomecat'] == 7 && $rowdatos['idtype'] ==1)
                  {
                 ///   echo "<br>666666-->CAT::".$rowdatos['idfasoutcomecat']." - tipo:".$rowdatos['idtype']."-tipocal:".$rowdatos['tipocalculo']."--".$rowdatos['idband']."--".$rowdatos['uldl']."--".$rowdatos['arraydoublem']."--".$rowdatos['instance']."--".$rowdatos['tipocalculo']."--";
            
                      if ($rowdatos['idband'] == 0 && $rowdatos['uldl'] ==0)
                      {
                        $datos_maxpwr_0_0=$rowdatos['arraydoublem'];
                        $datos_maxpwr_0_0=  str_replace($simbolosareemplazar, "", $datos_maxpwr_0_0);
                      }
                      if ($rowdatos['idband'] == 0 && $rowdatos['uldl'] ==1)
                      {
                        $datos_maxpwr_0_1=$rowdatos['arraydoublem'];
                        $datos_maxpwr_0_1=  str_replace($simbolosareemplazar, "", $datos_maxpwr_0_1);
                      } 
                      if ($rowdatos['idband'] == 1 && $rowdatos['uldl'] == 0)
                      {
                        $datos_maxpwr_1_0=$rowdatos['arraydoublem'];
                        $datos_maxpwr_1_0=  str_replace($simbolosareemplazar, "", $datos_maxpwr_1_0);
                      } 
                      if ($rowdatos['idband'] == 1 && $rowdatos['uldl'] ==1)
                      {
                        $datos_maxpwr_1_1=$rowdatos['arraydoublem'];
                        $datos_maxpwr_1_1=  str_replace($simbolosareemplazar, "", $datos_maxpwr_1_1);
                      } 
                  }
                  if ($rowdatos['idfasoutcomecat'] == 7 && $rowdatos['idtype'] ==0)
                  {
                    if ($rowdatos['idband'] == 0 && $rowdatos['uldl'] ==0)
                    {
                      $fre_maxpoprw_0_0=$rowdatos['arraydoublem'];
                      $fre_maxpoprw_0_0=  str_replace($simbolosareemplazar, "", $fre_maxpoprw_0_0);
                    }
                    if ($rowdatos['idband'] == 0 && $rowdatos['uldl'] ==1)
                    {
                      $fre_maxpoprw_0_1=$rowdatos['arraydoublem'];
                      $fre_maxpoprw_0_1=  str_replace($simbolosareemplazar, "", $fre_maxpoprw_0_1);
                    }
                    if ($rowdatos['idband'] == 1 && $rowdatos['uldl'] ==0)
                    {
                      $fre_maxpoprw_1_0=$rowdatos['arraydoublem'];
                      $fre_maxpoprw_1_0=  str_replace($simbolosareemplazar, "", $fre_maxpoprw_1_0);
                    }
                    if ($rowdatos['idband'] == 1 && $rowdatos['uldl'] == 1)
                    {
                      $fre_maxpoprw_1_1=$rowdatos['arraydoublem'];
                      $fre_maxpoprw_1_1=  str_replace($simbolosareemplazar, "", $fre_maxpoprw_1_1);
                    }
                  }

                 
              }
            }

       //*****FIN MAX PWR Check  */

       //*****Gain Check  */
       
       if("002007013" ==$rowdatos['instance'])
       {
        
        
            if("FREQ_PWR_IN" ==$rowdatos['tipocalculo'])
            {

            //  echo "<br>555555555555-->CAT::".$rowdatos['idfasoutcomecat']." - tipo:".$rowdatos['idtype']."-tipocal:".$rowdatos['tipocalculo']."--".$rowdatos['idband']."--".$rowdatos['uldl']."--".$rowdatos['arraydoublem']."--".$rowdatos['instance']."--".$rowdatos['tipocalculo']."--";
                  if ($rowdatos['idfasoutcomecat'] == 6 && $rowdatos['idtype'] ==0)
                  {
                    
           
                      if ($rowdatos['idband'] == 0 && $rowdatos['uldl'] ==0)
                      {
                        $freq_gainymaxpwr_0_0=$rowdatos['arraydoublem'];
                        $freq_gainymaxpwr_0_0=  str_replace($simbolosareemplazar, "", $freq_gainymaxpwr_0_0);
                        $gain_graf_totalpass_0_0 = $rowdatos['totalpass'];
                  //    echo "<br><br>aca entre 0-0: ****************** Gain Check : ".$rowdatos['arraydoublem'];
                      } 
                      if ($rowdatos['idband'] == 0 && $rowdatos['uldl'] ==1)
                      {
                        $freq_gainymaxpwr_0_1=$rowdatos['arraydoublem'];
                        $freq_gainymaxpwr_0_1=  str_replace($simbolosareemplazar, "", $freq_gainymaxpwr_0_1);
                        $gain_graf_totalpass_0_1 = $rowdatos['totalpass'];
                 //     echo "<br><br>aca entre 0 - 1 :lbl gain: ".$rowdatos['arraydoublem'];
                      } 
                      if ($rowdatos['idband'] == 1 && $rowdatos['uldl'] ==0)
                      {
                        $freq_gainymaxpwr_1_0=$rowdatos['arraydoublem'];
                        $freq_gainymaxpwr_1_0=  str_replace($simbolosareemplazar, "", $freq_gainymaxpwr_1_0);
                        $gain_graf_totalpass_1_0 = $rowdatos['totalpass'];
                  //    echo "<br><br>aca entre 1 - 0 :lbl gain: ".$rowdatos['arraydoublem'];
                      } 
                      if ($rowdatos['idband'] == 1 && $rowdatos['uldl'] == 1)
                      {
                        $freq_gainymaxpwr_1_1=$rowdatos['arraydoublem'];
                        $freq_gainymaxpwr_1_1=  str_replace($simbolosareemplazar, "", $freq_gainymaxpwr_1_1);
                        $gain_graf_totalpass_1_1 = $rowdatos['totalpass'];
                   //   echo "<br><br>aca entre 1 - 1 :lbl gain: ".$rowdatos['arraydoublem'];
                      } 

                  }
                  if ($rowdatos['idfasoutcomecat'] == 6 && $rowdatos['idtype'] ==2)
                  {
                      if ($rowdatos['idband'] == 0 && $rowdatos['uldl'] ==0)
                      {
                        $datos_gain_0_0=$rowdatos['arraydoublem'];
                        $datos_gain_0_0=  str_replace($simbolosareemplazar, "", $datos_gain_0_0);
                  //    echo "<br><br>aca entre datos gain 0-0:".$rowdatos['arraydoublem'];
                      }
                      if ($rowdatos['idband'] == 0 && $rowdatos['uldl'] ==1)
                      {
                        $datos_gain_0_1=$rowdatos['arraydoublem'];
                        $datos_gain_0_1=  str_replace($simbolosareemplazar, "", $datos_gain_0_1);
                  //     echo "<br><br>aca entre datos gain 0-1:".$rowdatos['arraydoublem'];
                      }
                      if ($rowdatos['idband'] == 1 && $rowdatos['uldl'] ==0)
                      {
                        $datos_gain_1_0=$rowdatos['arraydoublem'];
                        $datos_gain_1_0=  str_replace($simbolosareemplazar, "", $datos_gain_1_0);
                  //  echo "<br><br>aca entre datos gain 1-0:".$rowdatos['arraydoublem'];
                      }
                      if ($rowdatos['idband'] == 1 && $rowdatos['uldl'] == 1)
                      {
                        $datos_gain_1_1=$rowdatos['arraydoublem'];
                        $datos_gain_1_1=  str_replace($simbolosareemplazar, "", $datos_gain_1_1);
                  //    echo "<br><br>aca entre datos gain 1-1:".$rowdatos['arraydoublem'];
                      } 

                  }
            }
        
            if("PWR_OUT" ==$rowdatos['tipocalculo'])
            {
            
              if ($rowdatos['idfasoutcomecat'] == 2 && $rowdatos['idtype'] ==24)
              {
                  if ($rowdatos['idband'] == 0 && $rowdatos['uldl'] ==0)
                  {
                    $datos_gainreachi_0_0=$rowdatos['arraydoublem'];
                    $datos_gainreachi_0_0=  str_replace($simbolosareemplazar, "", $datos_gainreachi_0_0);
                  }
                  if ($rowdatos['idband'] == 0 && $rowdatos['uldl'] ==1)
                  {
                    $datos_gainreachi_0_1=$rowdatos['arraydoublem'];
                    $datos_gainreachi_0_1=  str_replace($simbolosareemplazar, "", $datos_gainreachi_0_1);
                  }
                  if ($rowdatos['idband'] == 1 && $rowdatos['uldl'] ==0)
                  {
                    $datos_gainreachi_1_0=$rowdatos['arraydoublem'];
                    $datos_gainreachi_1_0=  str_replace($simbolosareemplazar, "", $datos_gainreachi_1_0);
                  }
                  if ($rowdatos['idband'] == 1 && $rowdatos['uldl'] ==1)
                  {
                    $datos_gainreachi_1_1=$rowdatos['arraydoublem'];
                    $datos_gainreachi_1_1=  str_replace($simbolosareemplazar, "", $datos_gainreachi_1_1);
                  } 
                

              }
           

            }
      }
    
       //*****LSGP Check Power  */
       if("001004015027" ==$rowdatos['instance'])
       {
        if ($rowdatos['idfasoutcomecat'] == 11 && $rowdatos['idtype'] ==36 & "ADVALUE" ==$rowdatos['tipocalculo'])
        {
              if ($rowdatos['idband'] == 0 && $rowdatos['uldl'] ==0)
              {
                $lsgp_puntos_graf_despues_0_0 = "";
                  $querypuntos ="SELECT * FROM fas_calibration_enterprise_references_measures WHERE idtypereference = 0 and band = 0 and uldl = 0 AND iduniqueop =".$rowdatos['iduniqueop'];
                  $datagrafpunt = $connect->query($querypuntos)->fetchAll();		
                    foreach ($datagrafpunt as $rowiduniqpuntos)     
                      {
                        $lsgp_puntos_graf_despues_0_0= $lsgp_puntos_graf_despues_0_0."#".$rowiduniqpuntos["0db"]."#".$rowiduniqpuntos["3db"]."#".$rowiduniqpuntos["6db"]."#".$rowiduniqpuntos["9db"]."#".$rowiduniqpuntos["12db"];
                      }

              }
              if ($rowdatos['idband'] == 0 && $rowdatos['uldl'] ==1)
              {
                $lsgp_puntos_graf_despues_0_1 = "";
                $querypuntos ="SELECT * FROM fas_calibration_enterprise_references_measures WHERE idtypereference = 0 and band = 0 and uldl = 1  AND iduniqueop =".$rowdatos['iduniqueop'];
                $datagrafpunt = $connect->query($querypuntos)->fetchAll();		
                foreach ($datagrafpunt as $rowiduniqpuntos)     
                  {
                    $lsgp_puntos_graf_despues_0_1= $lsgp_puntos_graf_despues_0_1."#".$rowiduniqpuntos["0db"]."#".$rowiduniqpuntos["3db"]."#".$rowiduniqpuntos["6db"]."#".$rowiduniqpuntos["9db"]."#".$rowiduniqpuntos["12db"];
                  }

               //     echo "<br>***DESPUES-->".$rowdatos['iduniqueop']."-->datos:";
               //     echo $rowdatos['tipocalculo']."--".$rowdatos['idband']."--".$rowdatos['uldl']."#".$rowiduniqpuntos["0db"]."#".$rowiduniqpuntos["3db"]."#".$rowiduniqpuntos["6db"]."#".$rowiduniqpuntos["9db"]."#".$rowiduniqpuntos["12db"];
              

              }
              if ($rowdatos['idband'] == 1 && $rowdatos['uldl'] ==0)
              {
                $lsgp_puntos_graf_despues_1_0 ="";
                $querypuntos ="SELECT * FROM fas_calibration_enterprise_references_measures WHERE idtypereference = 0 and band = 1 and uldl = 0 AND iduniqueop =".$rowdatos['iduniqueop'];
                $datagrafpunt = $connect->query($querypuntos)->fetchAll();		
                foreach ($datagrafpunt as $rowiduniqpuntos)     
                  {
                    $lsgp_puntos_graf_despues_1_0= $lsgp_puntos_graf_despues_1_0."#".$rowiduniqpuntos["0db"]."#".$rowiduniqpuntos["3db"]."#".$rowiduniqpuntos["6db"]."#".$rowiduniqpuntos["9db"]."#".$rowiduniqpuntos["12db"];
                  }
              }
              if ($rowdatos['idband'] == 1 && $rowdatos['uldl'] ==1)
              {
                $lsgp_puntos_graf_despues_1_1 = "";
                $querypuntos ="SELECT * FROM fas_calibration_enterprise_references_measures WHERE idtypereference = 0 and band = 1 and uldl = 1 AND iduniqueop =".$rowdatos['iduniqueop'];
                $datagrafpunt = $connect->query($querypuntos)->fetchAll();		
                foreach ($datagrafpunt as $rowiduniqpuntos)     
                  {
                    $lsgp_puntos_graf_despues_1_1= $lsgp_puntos_graf_despues_1_1."#".$rowiduniqpuntos["0db"]."#".$rowiduniqpuntos["3db"]."#".$rowiduniqpuntos["6db"]."#".$rowiduniqpuntos["9db"]."#".$rowiduniqpuntos["12db"];
                  }
              }
          }
       }
        //*****LSGP Check Power  */
      if("001004015027" ==$rowdatos['instance'])
      {
        //***** ACA vamos a filtrar id idband -- uldl  */
            if("ADVALUE_ALLVER" ==$rowdatos['tipocalculo'])
            {
              if ($rowdatos['idband'] == 0 && $rowdatos['uldl'] ==0)
              {
                if ($lsgp_puntos_graf_antes_0_0 =="")
                {
                  $lsgp_puntos_graf_antes_0_0 = $rowdatos['iduniqueop'];
                  $querypuntos ="SELECT * FROM fas_calibration_enterprise_references_measures WHERE idtypereference = 0 and band = 0 and uldl =0 AND iduniqueop =".$rowdatos['iduniqueop'];
                  $datagrafpunt = $connect->query($querypuntos)->fetchAll();		
                   foreach ($datagrafpunt as $rowiduniqpuntos)     
                     {
                       $lsgp_puntos_graf_antes_0_0= $lsgp_puntos_graf_antes_0_0."#".$rowiduniqpuntos["0db"]."#".$rowiduniqpuntos["3db"]."#".$rowiduniqpuntos["6db"]."#".$rowiduniqpuntos["9db"]."#".$rowiduniqpuntos["12db"];
                     }
                //     echo "<br>***ANTES-->".$rowdatos['iduniqueop']."-->datos:";
                //     echo $rowdatos['tipocalculo']."--".$rowdatos['idband']."--".$rowdatos['uldl']."#".$rowiduniqpuntos["0db"]."#".$rowiduniqpuntos["3db"]."#".$rowiduniqpuntos["6db"]."#".$rowiduniqpuntos["9db"]."#".$rowiduniqpuntos["12db"];
                }
              }

              if ($rowdatos['idband'] == 0 && $rowdatos['uldl'] ==1)
              {
                if ($lsgp_puntos_graf_antes_0_1 =="")
                {
                  $lsgp_puntos_graf_antes_0_1 = $rowdatos['iduniqueop'];
                  $querypuntos ="SELECT * FROM fas_calibration_enterprise_references_measures WHERE idtypereference = 0 and band = 0 and uldl =1 AND iduniqueop =".$rowdatos['iduniqueop'];
                  $datagrafpunt = $connect->query($querypuntos)->fetchAll();		
                   foreach ($datagrafpunt as $rowiduniqpuntos)     
                     {
                       $lsgp_puntos_graf_antes_0_1= $lsgp_puntos_graf_antes_0_1."#".$rowiduniqpuntos["0db"]."#".$rowiduniqpuntos["3db"]."#".$rowiduniqpuntos["6db"]."#".$rowiduniqpuntos["9db"]."#".$rowiduniqpuntos["12db"];
                     }
                //     echo "<br>***ANTES-->".$rowdatos['iduniqueop']."-->datos:";
                 //    echo $rowdatos['tipocalculo']."--".$rowdatos['idband']."--".$rowdatos['uldl']."#".$rowiduniqpuntos["0db"]."#".$rowiduniqpuntos["3db"]."#".$rowiduniqpuntos["6db"]."#".$rowiduniqpuntos["9db"]."#".$rowiduniqpuntos["12db"];
                }
              }

              if ($rowdatos['idband'] == 1 && $rowdatos['uldl'] ==0)
              {
                if ($lsgp_puntos_graf_antes_1_0 =="")
                {
                  $lsgp_puntos_graf_antes_1_0 = $rowdatos['iduniqueop'];
                  $querypuntos ="SELECT * FROM fas_calibration_enterprise_references_measures WHERE idtypereference = 0 and band = 1 and uldl = 0 AND iduniqueop =".$rowdatos['iduniqueop'];
                  $datagrafpunt = $connect->query($querypuntos)->fetchAll();		
                   foreach ($datagrafpunt as $rowiduniqpuntos)     
                     {
                       $lsgp_puntos_graf_antes_1_0= $lsgp_puntos_graf_antes_1_0."#".$rowiduniqpuntos["0db"]."#".$rowiduniqpuntos["3db"]."#".$rowiduniqpuntos["6db"]."#".$rowiduniqpuntos["9db"]."#".$rowiduniqpuntos["12db"];
                     }
                 //    echo "<br>***ANTES-->".$rowdatos['iduniqueop']."-->datos:";
                 //    echo $rowdatos['tipocalculo']."--".$rowdatos['idband']."--".$rowdatos['uldl']."#".$rowiduniqpuntos["0db"]."#".$rowiduniqpuntos["3db"]."#".$rowiduniqpuntos["6db"]."#".$rowiduniqpuntos["9db"]."#".$rowiduniqpuntos["12db"];
                }
              }
              if ($rowdatos['idband'] == 1 && $rowdatos['uldl'] ==1)
              {
                if ($lsgp_puntos_graf_antes_1_1 =="")
                {
                  $lsgp_puntos_graf_antes_1_1 = $rowdatos['iduniqueop'];
                  $querypuntos ="SELECT * FROM fas_calibration_enterprise_references_measures WHERE idtypereference = 0 and band = 1 and uldl = 1 AND iduniqueop =".$rowdatos['iduniqueop'];
                  $datagrafpunt = $connect->query($querypuntos)->fetchAll();		
                   foreach ($datagrafpunt as $rowiduniqpuntos)     
                     {
                       $lsgp_puntos_graf_antes_1_1= $lsgp_puntos_graf_antes_1_1."#".$rowiduniqpuntos["0db"]."#".$rowiduniqpuntos["3db"]."#".$rowiduniqpuntos["6db"]."#".$rowiduniqpuntos["9db"]."#".$rowiduniqpuntos["12db"];
                     }
                 //    echo "<br>***ANTES-->".$rowdatos['iduniqueop']."-->datos:";
                 //    echo $rowdatos['tipocalculo']."--".$rowdatos['idband']."--".$rowdatos['uldl']."#".$rowiduniqpuntos["0db"]."#".$rowiduniqpuntos["3db"]."#".$rowiduniqpuntos["6db"]."#".$rowiduniqpuntos["9db"]."#".$rowiduniqpuntos["12db"];
                }
              }

            }
        
         ////AGC Acting ->uCMeasureEnt(11)- idtype(7)= band 0 -1 downlink // idtype(8)= band 1-1 downlink // idtype(3)= band 0-0 uplink// idtype(4)= band 1-0 uplink// //
           if("AGC_ACTING" ==$rowdatos['tipocalculo'])
            { 

                if ($rowdatos['idfasoutcomecat'] == 11 && $rowdatos['idtype'] ==3)
                {
                  if ($rowdatos['idband'] == 0 && $rowdatos['uldl'] ==0)
                  {
                    $agc_band_0_0=$rowdatos['arrayintegerm'];

                    $LSGP_graf_totalpass_0_0= $rowdatos['totalpass'];
                    $agc_band_0_0=  str_replace($simbolosareemplazar, "", $agc_band_0_0);

                   
                  
                /*    echo "<br>*****";
                    echo $rowdatos['tipocalculo']."--".$rowdatos['idband']."--".$rowdatos['uldl']."--".$rowdatos['arrayintegerm']."--".$rowdatos['instance']."--".$rowdatos['tipocalculo']."--";
                    echo "<br>*****";*/
               //     echo "<br><br>aca entre lbl lsgp 0-0:".$rowdatos['arrayintegerm'];
                  } 
                }
                if ($rowdatos['idfasoutcomecat'] == 11 && $rowdatos['idtype'] ==7)
                {
                  if ($rowdatos['idband'] == 0 && $rowdatos['uldl'] ==1)
                  {
                    $agc_band_0_1=$rowdatos['arrayintegerm'];
                    $LSGP_graf_totalpass_0_1= $rowdatos['totalpass'];
                    $agc_band_0_1=  str_replace($simbolosareemplazar, "", $agc_band_0_1);
                   
                 //   echo "<br><br>aca entre lbl lsgp 0-1:".$rowdatos['arrayintegerm'];
                  } 
                }
                if ($rowdatos['idfasoutcomecat'] == 11 && $rowdatos['idtype'] ==4)
                {
                  if ($rowdatos['idband'] == 1 && $rowdatos['uldl'] ==0)
                  {
                    $agc_band_1_0=$rowdatos['arrayintegerm'];
                    $LSGP_graf_totalpass_1_0= $rowdatos['totalpass'];
                    $agc_band_1_0=  str_replace($simbolosareemplazar, "", $agc_band_1_0);
                     
                 //   echo "<br><br>aca entre lbl lsgp 1-0:".$rowdatos['arrayintegerm'];
                  } 
                }
                if ($rowdatos['idfasoutcomecat'] == 11 && $rowdatos['idtype'] ==8)
                {
                  if ($rowdatos['idband'] == 1 && $rowdatos['uldl'] ==1)
                  {
                    $agc_band_1_1=$rowdatos['arrayintegerm'];
                    $LSGP_graf_totalpass_1_1= $rowdatos['totalpass'];
                    $agc_band_1_1=  str_replace($simbolosareemplazar, "", $agc_band_1_1);
            //        echo "<br><br>aca entre lbl lsgp 1-1:".$rowdatos['arrayintegerm'];
                           
                  } 
                }
              
              

            }
          
            if("PWR_OUT_MEASURE" ==$rowdatos['tipocalculo'])
            {

              

              if ($rowdatos['idband'] == 0 && $rowdatos['uldl'] ==0)
                {
                  $pwr_out_measure_band_0_0=$rowdatos['arraydoublem'];        
                  $pwr_out_measure_band_0_0=  str_replace($simbolosareemplazar, "", $pwr_out_measure_band_0_0);
               //   echo "<br><br>aca entre datos lsgp PWR_OUT_MEASURE 0-0:".$rowdatos['arraydoublem'];
                } 
                if ($rowdatos['idband'] == 0 && $rowdatos['uldl'] ==1)
                {
                  $pwr_out_measure_band_0_1=$rowdatos['arraydoublem'];        
                  $pwr_out_measure_band_0_1=  str_replace($simbolosareemplazar, "", $pwr_out_measure_band_0_1);
              //    echo "<br><br>aca entre datos lsgp PWR_OUT_MEASURE 0-1:".$rowdatos['arraydoublem'];
                } 
                if ($rowdatos['idband'] == 1 && $rowdatos['uldl'] ==0)
                {
                  $pwr_out_measure_band_1_0=$rowdatos['arraydoublem'];        
                  $pwr_out_measure_band_1_0=  str_replace($simbolosareemplazar, "", $pwr_out_measure_band_1_0);
              //    echo "<br><br>aca entre datos lsgp PWR_OUT_MEASURE 1-0:".$rowdatos['arraydoublem'];
                } 
                if ($rowdatos['idband'] == 1 && $rowdatos['uldl'] == 1)
                {
                  $pwr_out_measure_band_1_1=$rowdatos['arraydoublem'];        
                  $pwr_out_measure_band_1_1=  str_replace($simbolosareemplazar, "", $pwr_out_measure_band_1_1);
             //     echo "<br><br>aca entre datos lsgp PWR_OUT_MEASURE 1-1:".$rowdatos['arraydoublem'];
                } 
                

       
            }
          
            if("PWR_OUT" ==$rowdatos['tipocalculo'])
            {

              if ($rowdatos['idband'] == 0 && $rowdatos['uldl'] ==0)
              {
                $pwr_out_exp_band_0_0=$rowdatos['arraydoublem'];
                $pwr_out_exp_band_0_0=  str_replace($simbolosareemplazar, "", $pwr_out_exp_band_0_0); 
              //  echo "<br><br>aca entre datos lsgp PWR_OUT 0-0:".$rowdatos['arraydoublem'];
              }
              if ($rowdatos['idband'] == 0 && $rowdatos['uldl'] ==1)
              {
                $pwr_out_exp_band_0_1=$rowdatos['arraydoublem'];
                $pwr_out_exp_band_0_1=  str_replace($simbolosareemplazar, "", $pwr_out_exp_band_0_1); 
             ////   echo "<br><br>aca entre datos lsgp PWR_OUT 0-1:".$rowdatos['arraydoublem'];
              }
              if ($rowdatos['idband'] == 1 && $rowdatos['uldl'] ==0)
              {
                $pwr_out_exp_band_1_0=$rowdatos['arraydoublem'];
                $pwr_out_exp_band_1_0=  str_replace($simbolosareemplazar, "", $pwr_out_exp_band_1_0); 
           //     echo "<br><br>aca entre datos lsgp PWR_OUT 1-0:".$rowdatos['arraydoublem'];
              }
              if ($rowdatos['idband'] == 1 && $rowdatos['uldl'] == 1)
              {
                $pwr_out_exp_band_1_1=$rowdatos['arraydoublem'];
                $pwr_out_exp_band_1_1=  str_replace($simbolosareemplazar, "", $pwr_out_exp_band_1_1); 
            //    echo "<br><br>aca entre datos lsgp PWR_OUT 1-1:".$rowdatos['arraydoublem'];
              }            
                      
            }
          

          
          if(31 ==$rowdatos['idorder'])
          {
             
          }
          if(43 ==$rowdatos['idorder'])
          {
            
          }
      }
    }
/*
      /////LSGP
    $agc_band_0_0="0,3,6,9,12";
    $agc_band_0_1="0,3,6,9,12";
    $agc_band_1_0="0,3,6,9,12";
    $agc_band_1_1="0,3,6,9,12";


    $pwr_out_exp_band_0_0_qq="-10,-13,-16,-19,-22";

    $pwr_out_exp_band_0_1_qq="37,34, 31,28,25";
    $pwr_out_exp_band_1_0_qq="-10,-13,-16,-19,-22";
    $pwr_out_exp_band_1_1_qq="37,34, 31,28,25";

    /////LSGP
    $pwr_out_measure_band_0_0="-10.9,-13.9,-16.9,-20,-22.9";
    $pwr_out_measure_band_0_1="36.2,33.2,30.1,27.2,24.1";
    
    $pwr_out_measure_band_1_0="-10.9,-13.9,-16.9,-20,-22.9";
    $pwr_out_measure_band_1_1=" 36.1,33.1,30.1,27.1,24.1";*/

     ////calculos especiales al salir del FOR

     $pwr_out_exp_band_0_0_qq ="";
    $qq_measures = explode(",", $agc_band_0_0);
    foreach ($qq_measures as $variable => $tk) {
     
          $rrrr=($tk)-$pwr_out_exp_band_0_0;
          $rrrr=$pwr_out_exp_band_0_0-($tk);
          if ( $pwr_out_exp_band_0_0_qq=="")
          {
            $pwr_out_exp_band_0_0_qq = "".$rrrr;
          }
          else
          {
            $pwr_out_exp_band_0_0_qq = $pwr_out_exp_band_0_0_qq.",". $rrrr;
          }         
        
      }

      $pwr_out_exp_band_0_1_qq ="";
      $qq_measures = explode(",", $agc_band_0_1);
      foreach ($qq_measures as $variable => $tk) {
       
            $rrrr=($tk)-$pwr_out_exp_band_0_1;
            $rrrr=$pwr_out_exp_band_0_1-($tk);
            if ( $pwr_out_exp_band_0_1_qq=="")
            {
              $pwr_out_exp_band_0_1_qq = "".$rrrr;
            }
            else
            {
              $pwr_out_exp_band_0_1_qq = $pwr_out_exp_band_0_1_qq.",". $rrrr;
            }         
          
        }

        $pwr_out_exp_band_1_0_qq ="";
        $qq_measures = explode(",", $agc_band_1_0);
        foreach ($qq_measures as $variable => $tk) {
         
              $rrrr=($tk)-$pwr_out_exp_band_1_0;
              $rrrr=$pwr_out_exp_band_1_0-($tk);
              if ( $pwr_out_exp_band_1_0_qq=="")
              {
                $pwr_out_exp_band_1_0_qq = "".$rrrr;
              }
              else
              {
                $pwr_out_exp_band_1_0_qq = $pwr_out_exp_band_1_0_qq.",". $rrrr;
              }         
            
          }

          $pwr_out_exp_band_1_1_qq ="";
          $qq_measures = explode(",", $agc_band_1_1);
          foreach ($qq_measures as $variable => $tk) {
           
                $rrrr=($tk)-$pwr_out_exp_band_1_1;
                $rrrr=$pwr_out_exp_band_1_1-($tk);
                if ( $pwr_out_exp_band_1_1_qq=="")
                {
                  $pwr_out_exp_band_1_1_qq = "".$rrrr;
                }
                else
                {
                  $pwr_out_exp_band_1_1_qq = $pwr_out_exp_band_1_1_qq.",". $rrrr;
                }         
              
            }

              ////MAX PWR
             //// pwr_out_exp_band_qq_maxp_0_0

              $pwr_out_exp_band_qq_maxp_0_0_array ="";
              $qq_measures = explode(",", $datos_maxpwr_0_0);
              foreach ($qq_measures as $variable => $tk) {
               
                    
                    $rrrr=$pwr_out_exp_band_qq_maxp_0_0;
                    if ( $pwr_out_exp_band_qq_maxp_0_0_array=="")
                    {
                      $pwr_out_exp_band_qq_maxp_0_0_array = "".$rrrr;
                    }
                    else
                    {
                      $pwr_out_exp_band_qq_maxp_0_0_array = $pwr_out_exp_band_qq_maxp_0_0_array.",". $rrrr;
                    }         
                  
                }

                $pwr_out_exp_band_qq_maxp_0_1_array ="";
                $qq_measures = explode(",", $datos_maxpwr_0_1);
                foreach ($qq_measures as $variable => $tk) {
                 
                      
                      $rrrr=$pwr_out_exp_band_qq_maxp_0_1;
                      if ( $pwr_out_exp_band_qq_maxp_0_1_array=="")
                      {
                        $pwr_out_exp_band_qq_maxp_0_1_array = "".$rrrr;
                      }
                      else
                      {
                        $pwr_out_exp_band_qq_maxp_0_1_array = $pwr_out_exp_band_qq_maxp_0_1_array.",". $rrrr;
                      }         
                    
                  }

                  $pwr_out_exp_band_qq_maxp_1_0_array ="";
                  $qq_measures = explode(",", $datos_maxpwr_1_0);
                  foreach ($qq_measures as $variable => $tk) {
                   
                        
                        $rrrr=$pwr_out_exp_band_qq_maxp_1_0;
                        if ( $pwr_out_exp_band_qq_maxp_1_0_array=="")
                        {
                          $pwr_out_exp_band_qq_maxp_1_0_array = "".$rrrr;
                        }
                        else
                        {
                          $pwr_out_exp_band_qq_maxp_1_0_array = $pwr_out_exp_band_qq_maxp_1_0_array.",". $rrrr;
                        }         
                      
                    }

                    $pwr_out_exp_band_qq_maxp_1_1_array ="";
                    $qq_measures = explode(",", $datos_maxpwr_1_1);
                    foreach ($qq_measures as $variable => $tk) {
                     
                          
                          $rrrr=$pwr_out_exp_band_qq_maxp_1_1;
                          if ( $pwr_out_exp_band_qq_maxp_1_1_array=="")
                          {
                            $pwr_out_exp_band_qq_maxp_1_1_array = "".$rrrr;
                          }
                          else
                          {
                            $pwr_out_exp_band_qq_maxp_1_1_array = $pwr_out_exp_band_qq_maxp_1_1_array.",". $rrrr;
                          }         
                        
                      }
/*
            echo "<br> table_lineality_ejex_0_0".  $table_lineality_ejex_0_0;        
            echo "<br> table_lineality_ejex_0_1".  $table_lineality_ejex_0_1;        
            echo "<br> table_lineality_ejex_1_0".  $table_lineality_ejex_1_0;        
            echo "<br> table_lineality_ejex_1_1".  $table_lineality_ejex_1_1;      
            
            echo "<br>table_lineality_MkrPeakSearch_0_0:".$table_lineality_MkrPeakSearch_0_0;
            echo "<br>table_lineality_MkrPeakSearch_0_1:".$table_lineality_MkrPeakSearch_0_1;
            echo "<br>table_lineality_MkrPeakSearch_1_0:".$table_lineality_MkrPeakSearch_1_0;
            echo "<br>table_lineality_MkrPeakSearch_1_1:".$table_lineality_MkrPeakSearch_1_1;

            echo "<br>table_lineality_uCPwrForward_0_0:".$table_lineality_uCPwrForward_0_0;
            echo "<br>table_lineality_uCPwrForward_0_1:".$table_lineality_uCPwrForward_0_1;
            echo "<br>table_lineality_uCPwrForward_1_0:".$table_lineality_uCPwrForward_1_0;
            echo "<br>table_lineality_uCPwrForward_1_1:".$table_lineality_uCPwrForward_1_1;
*/
                /*

echo "<br>pwr_out_exp_band_qq_maxp_0_0_array".$pwr_out_exp_band_qq_maxp_0_0_array;
echo "<br>pwr_out_exp_band_qq_maxp_0_1_array".$pwr_out_exp_band_qq_maxp_0_1_array;
echo "<br>pwr_out_exp_band_qq_maxp_1_0_array".$pwr_out_exp_band_qq_maxp_1_0_array;
echo "<br>pwr_out_exp_band_qq_maxp_1_1_array".$pwr_out_exp_band_qq_maxp_1_1_array;


    echo "<br>agc_band_0_0:::::".$agc_band_0_0;
    echo "<br>agc_band_0_1:::::".$agc_band_0_1;
    echo "<br>agc_band_1_0:::::".$agc_band_1_0;
    echo "<br>agc_band_1_1:::::".$agc_band_1_1;

    echo "<br>pwr_out_measure_band_0_0:::::".$pwr_out_measure_band_0_0;
    echo "<br>pwr_out_measure_band_0_1:::::".$pwr_out_measure_band_0_1;
    echo "<br>pwr_out_measure_band_1_0:::::".$pwr_out_measure_band_1_0;
    echo "<br>pwr_out_measure_band_1_1:::::".$pwr_out_measure_band_1_1;

    echo "<br>pwr_out_exp_band_0_0 colado".$pwr_out_exp_band_0_0;
    echo "<br>pwr_out_exp_band_0_0 colado".$pwr_out_exp_band_0_1;
    echo "<br>pwr_out_exp_band_0_0 colado".$pwr_out_exp_band_1_0;
    echo "<br>pwr_out_exp_band_0_0 colado".$pwr_out_exp_band_1_1;

    echo "<br>pwr_out_exp_band_0_0_qq:::::".$pwr_out_exp_band_0_0_qq;
    echo "<br>pwr_out_exp_band_0_1_qq:::::".$pwr_out_exp_band_0_1_qq;
    echo "<br>pwr_out_exp_band_1_0_qq:::::".$pwr_out_exp_band_1_0_qq;
    echo "<br>pwr_out_exp_band_1_1_qq:::::".$pwr_out_exp_band_1_1_qq;
    
*/
      /////GAIN
      /*
    $freq_gainymaxpwr_0_0="788.0, 792.25, 796.5, 800.75, 805.0";
    $freq_gainymaxpwr_0_1="758.0, 762.25, 766.5, 770.75, 775.0";
    $freq_gainymaxpwr_1_0="788.0, 792.25, 796.5, 800.75, 805.0";
    $freq_gainymaxpwr_1_1="851.0, 855.5, 860.0, 864.5, 869.0";
    

    $datos_gainreachi_0_0="39,39,39,39,39";
    $datos_gainreachi_0_1="48,48,48,48,48";

    $datos_gainreachi_1_0="39,39,39,39,39";
    $datos_gainreachi_1_1="48,48,48,48,48";

     /////GAIN
    $datos_gain_0_0="37.7,37.8,37.7,37.7,37.6";
    $datos_gain_0_1="49.6,49.8,49.7,49.4,47.6";

    $datos_gain_1_0="37.7,37.8,37.7,37.7,37.6";
    $datos_gain_1_1="46.0,47.3,46.6,45.9,45.9";
*/
  /*
    echo "<br>freq_gainymaxpwr_0_0:::::".$freq_gainymaxpwr_0_0;
    echo "<br>freq_gainymaxpwr_0_1:::::".$freq_gainymaxpwr_0_1;
    echo "<br>freq_gainymaxpwr_1_0:::::".$freq_gainymaxpwr_1_0;
    echo "<br>freq_gainymaxpwr_1_1:::::".$freq_gainymaxpwr_1_1;

    echo "<br>datos_gainreachi_0_0:::::".$datos_gainreachi_0_0;
    echo "<br>datos_gainreachi_0_1:::::".$datos_gainreachi_0_1;
    echo "<br>datos_gainreachi_1_0:::::".$datos_gainreachi_1_0;
    echo "<br>datos_gainreachi_1_1:::::".$datos_gainreachi_1_1;


    echo "<br>datos_gain_0_0:::::".$datos_gain_0_0;
    echo "<br>datos_gain_0_1:::::".$datos_gain_0_1;
    echo "<br>datos_gain_1_0:::::".$datos_gain_1_0;
    echo "<br>datos_gain_1_1:::::".$datos_gain_1_1;
  
*/
/*
   


    $fre_maxpoprw_0_0="788.0, 792.25, 796.5, 800.75, 805.0";
    $fre_maxpoprw_0_1="758.0, 762.25, 766.5, 770.75, 775.0";
    $fre_maxpoprw_1_0="806.0, 810.5, 815.0, 819.5, 824.0";
    $fre_maxpoprw_1_1="851.0, 855.5, 860.0, 864.5, 869.0";


    $datos_maxpwr_0_0="-10.9,-10.9,-10.9,-11,-11";
    $datos_maxpwr_0_1="37,37,37,37,37";
    $datos_maxpwr_1_0="-11.1,-11.1,-11.1,-11.1,-11.2";
    $datos_maxpwr_1_1="37,37,37,37,37";

    $pwr_out_exp_band_qq_maxp_0_0="-10,-10,-10,-10,-10";
    $pwr_out_exp_band_qq_maxp_0_1="36.1,36.4,36.2,36.1,35.8";
    $pwr_out_exp_band_qq_maxp_1_0="-10,-10,-10,-10,-10";
    $pwr_out_exp_band_qq_maxp_1_1="35.8,36.2,36.1,35.8,35.8";

    */
/*
    echo "<br>fre_maxpoprw_0_0:::::".$fre_maxpoprw_0_0;
    echo "<br>fre_maxpoprw_0_1:::::".$fre_maxpoprw_0_1;
    echo "<br>fre_maxpoprw_1_0:::::".$fre_maxpoprw_1_0;
    echo "<br>fre_maxpoprw_1_1:::::".$fre_maxpoprw_1_1;

    echo "<br>datos_maxpwr_0_0:::::".$datos_maxpwr_0_0;
    echo "<br>datos_maxpwr_0_1:::::".$datos_maxpwr_0_1;
    echo "<br>datos_maxpwr_1_0:::::".$datos_maxpwr_1_0;
    echo "<br>datos_maxpwr_1_1:::::".$datos_maxpwr_1_1;

    echo "<br>pwr_out_exp_band_qq_maxp_0_0:::::".$pwr_out_exp_band_qq_maxp_0_0;
    echo "<br>pwr_out_exp_band_qq_maxp_0_1:::::".$pwr_out_exp_band_qq_maxp_0_1;
    echo "<br>pwr_out_exp_band_qq_maxp_1_0:::::".$pwr_out_exp_band_qq_maxp_1_0;
    echo "<br>pwr_out_exp_band_qq_maxp_1_1:::::".$pwr_out_exp_band_qq_maxp_1_1;

  */ 
/*
 echo "<br>Antes*->".$lsgp_puntos_graf_antes_0_0;
 echo "<br>lsgp_puntos_graf_antes_0_1*->".$lsgp_puntos_graf_antes_0_1;
 echo "<br>lsgp_puntos_graf_antes_1_0*->".$lsgp_puntos_graf_antes_1_0;
 echo "<br>lsgp_puntos_graf_antes_1_1*->".$lsgp_puntos_graf_antes_1_1;

 echo "<br>Despues*lsgp_puntos_graf_despues_0_0->".$lsgp_puntos_graf_despues_0_0;
 echo "<br>Despues*lsgp_puntos_graf_despues_0_1->".$lsgp_puntos_graf_despues_0_1;
 echo "<br>Despues*lsgp_puntos_graf_despues_1_0->".$lsgp_puntos_graf_despues_1_0;
 echo "<br>Despues*lsgp_puntos_graf_despues_1_1->".$lsgp_puntos_graf_despues_1_1;
*/
 /////////////////////////// CONTROL 700 -800
 /// SUMAR CONTROL ACAA.. a0001000100370040004900530061 DAS ENTER REMOTO 700/800

 $sqltess="
 select idproduct from fnt_select_allproducts_maxrev() as pp where modelciu in(
  select v_string from fas_outcome_integral where reference in ( 
                                                select reference from fas_outcome_integral where v_string = '".$elsn."'  ) and idtype =3 and idfasoutcomecat = 0
                                                order by datetimeref asc) and iduniquebranchsonprod like '%0001000100370040004900530061%'
 ";
  $is_DAS_ENT_REMOTO_700800 ="N";
  $dataiscuu = $connect->query($sqltess)->fetchAll();		
  foreach ($dataiscuu as $rowiduniqpuntos)     
    {
      $is_DAS_ENT_REMOTO_700800 ="Y";
    }


  if ($lsgp_puntos_graf_despues_1_0 =="" && $lsgp_puntos_graf_antes_1_0=="" && $is_DAS_ENT_REMOTO_700800 =="Y" )
  {
    $lsgp_puntos_graf_despues_1_0 = $lsgp_puntos_graf_despues_0_0;
    $lsgp_puntos_graf_antes_1_0   = $lsgp_puntos_graf_antes_0_0 ;


    $agc_band_1_0 = $agc_band_0_0;
    $pwr_out_measure_band_1_0 = $pwr_out_measure_band_0_0;
    $pwr_out_exp_band_1_0 = $pwr_out_exp_band_0_0;
    $pwr_out_exp_band_1_0_qq= $pwr_out_exp_band_0_0_qq;

    $freq_gainymaxpwr_1_0 = $freq_gainymaxpwr_0_0;
    $datos_gainreachi_1_0 = $datos_gainreachi_0_0;

    $datos_gain_1_0 = $datos_gain_0_0;

    $fre_maxpoprw_1_0 = $fre_maxpoprw_0_0;
    $datos_maxpwr_1_0 = $datos_maxpwr_0_0;
    $pwr_out_exp_band_qq_maxp_1_0 = $pwr_out_exp_band_qq_maxp_0_0;


  }

  
  ?>

<h6 class="colornaranajafiplex"><b>AGC Table Calibration </b></h6> 

<div class="row">
<div class="col-3">

        <div class="card">
        <!-- Sales Chart Canvas -->
              <div class="card-header">
              <h5 class="card-title colorazulfiplex"><b>700 UL </b></h5>
                  <div class="card-tools">
                
                  <span class="badge badge-pill badge-success">Pass</span>
                      
                  </div>
               </div>
              <div class="chart">
                <canvas id="grafagccalib00" height="180" style="height: 180;"></canvas>
              </div>
        </div> 

</div>
<div class="col-3"><div class="card">
        <!-- Sales Chart Canvas -->
              <div class="card-header">
              <h5 class="card-title colorazulfiplex"><b> 700 DL</b></h5>
                  <div class="card-tools">
                
                  <span class="badge badge-pill badge-success">Pass</span>
                      
                  </div>
               </div>
              <div class="chart">
                <canvas id="grafagccalib01" height="180" style="height: 180;"></canvas>
              </div>
        </div> </div>
<div class="col-3">

<div class="card">
        <!-- Sales Chart Canvas -->
              <div class="card-header">
              <h5 class="card-title colorazulfiplex"><b>  800 UL</b></h5>
                  <div class="card-tools">
                
                  <span class="badge badge-pill badge-success">Pass</span>
                      
                  </div>
               </div>
              <div class="chart">
                <canvas id="grafagccalib10" height="180" style="height: 180;"></canvas>
              </div>
        </div> 

</div>
<div class="col-3">

<div class="card">
        <!-- Sales Chart Canvas -->
              <div class="card-header">
              <h5 class="card-title colorazulfiplex"><b>  800 DL </b></h5>
                  <div class="card-tools">
                
                  <span class="badge badge-pill badge-success">Pass</span>
                      
                  </div>
               </div>
              <div class="chart">
                <canvas id="grafagccalib11" height="180" style="height: 180;"></canvas>
              </div>
        </div> 

</div>

</div>

<h6 class="colornaranajafiplex"><b>Dynamic AGC Test</b></h6> 
  <div class="row">
  <div class="col-3">

          <div class="card">
          <!-- Sales Chart Canvas -->
                <div class="card-header">
                <h5 class="card-title colorazulfiplex"><b>700 UL </b></h5>
                    <div class="card-tools">
                  
                  
                    <?php if ($LSGP_graf_totalpass_0_0== true) 
                                {
                                  ?>
                                  <span class="badge badge-pill badge-success">Pass</span>
                                  <?php
                                }
                                else
                                {
                                  ?>
                                  <span class="badge badge-pill badge-danger">Not Passed</span>
                                  <?php
                                }
                        
                        ?>
                        
                    </div>
                 </div>
                <div class="chart">
                  <canvas id="grafpower0" height="280" style="height: 280;"></canvas>
                </div>
          </div> 

  </div>
  <div class="col-3"><div class="card">
          <!-- Sales Chart Canvas -->
                <div class="card-header">
                <h5 class="card-title colorazulfiplex"><b> 700 DL</b></h5>
                    <div class="card-tools">
                  
                    <?php if ($LSGP_graf_totalpass_0_1== true) 
                                {
                                  ?>
                                  <span class="badge badge-pill badge-success">Pass</span>
                                  <?php
                                }
                                else
                                {
                                  ?>
                                  <span class="badge badge-pill badge-danger">Not Passed</span>
                                  <?php
                                }
                        
                        ?>
                        
                    </div>
                 </div>
                <div class="chart">
                  <canvas id="grafpower1" height="280" style="height: 280;"></canvas>
                </div>
          </div> </div>
  <div class="col-3">

  <div class="card">
          <!-- Sales Chart Canvas -->
                <div class="card-header">
                <h5 class="card-title colorazulfiplex"><b>  800 UL</b></h5>
                    <div class="card-tools">
                  
                    <?php if ($LSGP_graf_totalpass_1_0== true) 
                                {
                                  ?>
                                  <span class="badge badge-pill badge-success">Pass</span>
                                  <?php
                                }
                                else
                                {
                                  ?>
                                  <span class="badge badge-pill badge-danger">Not Passed</span>
                                  <?php
                                }
                        
                        ?>
                        
                    </div>
                 </div>
                <div class="chart">
                  <canvas id="grafpower0a" height="280" style="height: 280;"></canvas>
                </div>
          </div> 

  </div>
  <div class="col-3">

  <div class="card">
          <!-- Sales Chart Canvas -->
                <div class="card-header">
                <h5 class="card-title colorazulfiplex"><b>  800 DL </b></h5>
                    <div class="card-tools">
                  
                    <?php if ($LSGP_graf_totalpass_1_1== true) 
                                {
                                  ?>
                                  <span class="badge badge-pill badge-success">Pass</span>
                                  <?php
                                }
                                else
                                {
                                  ?>
                                  <span class="badge badge-pill badge-danger">Not Passed</span>
                                  <?php
                                }
                        
                        ?>
                        
                    </div>
                 </div>
                <div class="chart">
                  <canvas id="grafpower1a" height="280" style="height: 280;"></canvas>
                </div>
          </div> 

  </div>

</div>

<!--- lineality -->
<h6 class="colornaranajafiplex"><b>Lineality  Test</b> [ Max Power Vs AGC amount ]</h6> 
  <div class="row">
  <div class="col-3 d-none">

          <div class="card ">
          <!-- Sales Chart Canvas -->
                <div class="card-header">
                <h5 class="card-title colorazulfiplex"><b>700 UL </b></h5>
                    <div class="card-tools">
                  
                  
                    <?php if ($lineality_graf_totalpass_0_0== true) 
                                {
                                  ?>
                                  <span class="badge badge-pill badge-success">Pass</span>
                                  <?php
                                }
                                else
                                {
                                  ?>
                                  <span class="badge badge-pill badge-danger">Not Passed</span>
                                  <?php
                                }
                        
                        ?>
                        
                    </div>
                 </div>
                <div class="chart">
                  <canvas id="graflineality0" height="280" style="height: 280;"></canvas>
                </div>
          </div> 

  </div>
  <div class="col-6"><div class="card">
          <!-- Sales Chart Canvas -->
                <div class="card-header">
                <h5 class="card-title colorazulfiplex"><b> 700 DL</b></h5>
                    <div class="card-tools">
                  
                    <?php if ($lineality_graf_totalpass_0_1== true) 
                                {
                                  ?>
                                  <span class="badge badge-pill badge-success">Pass</span>
                                  <?php
                                }
                                else
                                {
                                  ?>
                                  <span class="badge badge-pill badge-danger">Not Passed</span>
                                  <?php
                                }
                        
                        ?>
                        
                    </div>
                 </div>
                <div class="chart">
                  <canvas id="graflineality1" height="280" style="height: 280;"></canvas>
                </div>
          </div> </div>
  <div class="col-3 d-none">

  <div class="card">
          <!-- Sales Chart Canvas -->
                <div class="card-header">
                <h5 class="card-title colorazulfiplex"><b>  800 UL</b></h5>
                    <div class="card-tools">
                  
                    <?php if ($lineality_graf_totalpass_1_0== true) 
                                {
                                  ?>
                                  <span class="badge badge-pill badge-success">Pass</span>
                                  <?php
                                }
                                else
                                {
                                  ?>
                                  <span class="badge badge-pill badge-danger">Not Passed</span>
                                  <?php
                                }
                        
                        ?>
                        
                    </div>
                 </div>
                <div class="chart">
                  <canvas id="graflineality2" height="280" style="height: 280;"></canvas>
                </div>
          </div> 

  </div>
  <div class="col-6">

  <div class="card">
          <!-- Sales Chart Canvas -->
                <div class="card-header">
                <h5 class="card-title colorazulfiplex"><b>  800 DL </b></h5>
                    <div class="card-tools">
                  
                    <?php if ($lineality_graf_totalpass_1_1== true) 
                                {
                                  ?>
                                  <span class="badge badge-pill badge-success">Pass</span>
                                  <?php
                                }
                                else
                                {
                                  ?>
                                  <span class="badge badge-pill badge-danger">Not Passed</span>
                                  <?php
                                }
                        
                        ?>
                        
                    </div>
                 </div>
                <div class="chart">
                  <canvas id="graflineality3" height="280" style="height: 280;"></canvas>
                </div>
          </div> 

  </div>

</div>
<!--- fin lineality -->


<hr>
  <h6 class="colornaranajafiplex"><b>GAIN Check </b></h6> 
  <!-- Graficos de ganancia- ---->
      <div class="row">
      <div class="col-3">

              <div class="card">
              <!-- Sales Chart Canvas -->
                    <div class="card-header">
                    <h5 class="card-title colorazulfiplex"><b>700 UL </b></h5>
                        <div class="card-tools">
                      
                        <?php if ($gain_graf_totalpass_0_0== true) 
                                {
                                  ?>
                                  <span class="badge badge-pill badge-success">Pass</span>
                                  <?php
                                }
                                else
                                {
                                  ?>
                                  <span class="badge badge-pill badge-danger">Not Passed</span>
                                  <?php
                                }
                        
                        ?>
                        </div>
                    </div>
                    <div class="chart">
                      <canvas id="grafgain0" height="280" style="height: 280;"></canvas>
                    </div>
              </div> 

      </div>
      <div class="col-3"><div class="card">
              <!-- Sales Chart Canvas -->
                    <div class="card-header">
                    <h5 class="card-title colorazulfiplex"><b> 700 DL</b></h5>
                        <div class="card-tools">
                      
                        <?php if ($gain_graf_totalpass_0_1== true) 
                                {
                                  ?>
                                  <span class="badge badge-pill badge-success">Pass</span>
                                  <?php
                                }
                                else
                                {
                                  ?>
                                  <span class="badge badge-pill badge-danger">Not Passed</span>
                                  <?php
                                }
                        
                        ?>
                            
                        </div>
                    </div>
                    <div class="chart">
                      <canvas id="grafgain1" height="280" style="height: 280;"></canvas>
                    </div>
              </div> </div>
      <div class="col-3">

      <div class="card">
              <!-- Sales Chart Canvas -->
                    <div class="card-header">
                    <h5 class="card-title colorazulfiplex"><b>  800 UL</b></h5>
                        <div class="card-tools">
                      
                        <?php if ($gain_graf_totalpass_1_0== true) 
                                {
                                  ?>
                                  <span class="badge badge-pill badge-success">Pass</span>
                                  <?php
                                }
                                else
                                {
                                  ?>
                                  <span class="badge badge-pill badge-danger">Not Passed</span>
                                  <?php
                                }
                        
                        ?>
                            
                        </div>
                    </div>
                    <div class="chart">
                      <canvas id="grafgain0a" height="280" style="height: 280;"></canvas>
                    </div>
              </div> 

      </div>
      <div class="col-3">

      <div class="card">
              <!-- Sales Chart Canvas -->
                    <div class="card-header">
                    <h5 class="card-title colorazulfiplex"><b>  800 DL </b></h5>
                        <div class="card-tools">
                      
                        <?php if ($gain_graf_totalpass_1_1== true) 
                                {
                                  ?>
                                  <span class="badge badge-pill badge-success">Pass</span>
                                  <?php
                                }
                                else
                                {
                                  ?>
                                  <span class="badge badge-pill badge-danger">Not Passed</span>
                                  <?php
                                }
                        
                        ?>
                            
                        </div>
                    </div>
                    <div class="chart">
                      <canvas id="grafgain1a" height="280" style="height: 280;"></canvas>
                    </div>
              </div> 

      </div>

    </div>


  <!-- Fin Graficos de ganancia- ---->

  <hr>
  <h6 class="colornaranajafiplex"><b>MAX POWER Check </b></h6> 
  <!-- Graficos de max pwr- ---->
      <div class="row">
      <div class="col-3">

              <div class="card">
              <!-- Sales Chart Canvas -->
                    <div class="card-header">
                    <h5 class="card-title colorazulfiplex"><b>700 UL </b></h5>
                        <div class="card-tools">
                      
                        <?php if ($maxpwr_graf_totalpass_0_0== true) 
                                {
                                  ?>
                                  <span class="badge badge-pill badge-success">Pass</span>
                                  <?php
                                }
                                else
                                {
                                  ?>
                                  <span class="badge badge-pill badge-danger">Not Passed</span>
                                  <?php
                                }
                        
                        ?>
                            
                        </div>
                    </div>
                    <div class="chart">
                      <canvas id="grafmaxpwr0" height="280" style="height: 280;"></canvas>
                    </div>
              </div> 

      </div>
      <div class="col-3"><div class="card">
              <!-- Sales Chart Canvas -->
                    <div class="card-header">
                    <h5 class="card-title colorazulfiplex"><b> 700 DL</b></h5>
                        <div class="card-tools">
                      
                        <?php if ($maxpwr_graf_totalpass_0_1== true) 
                                {
                                  ?>
                                  <span class="badge badge-pill badge-success">Pass </span>
                                  <?php
                                }
                                else
                                {
                                  ?>
                                  <span class="badge badge-pill badge-danger">Not Passed</span>
                                  <?php
                                }
                        
                        ?>
                            
                        </div>
                    </div>
                    <div class="chart">
                      <canvas id="grafmaxpwr0a" height="280" style="height: 280;"></canvas>
                    </div>
              </div> </div>
      <div class="col-3">

      <div class="card">
              <!-- Sales Chart Canvas -->
                    <div class="card-header">
                    <h5 class="card-title colorazulfiplex"><b>  800 UL</b></h5>
                        <div class="card-tools">
                      
                        <?php if ($maxpwr_graf_totalpass_1_0== true) 
                                {
                                  ?>
                                  <span class="badge badge-pill badge-success">Pass</span>
                                  <?php
                                }
                                else
                                {
                                  ?>
                                  <span class="badge badge-pill badge-danger">Not Passed</span>
                                  <?php
                                }
                        
                        ?>
                            
                        </div>
                    </div>
                    <div class="chart">
                      <canvas id="grafmaxpwr1" height="280" style="height: 280;"></canvas>
                    </div>
              </div> 

      </div>
      <div class="col-3">

      <div class="card">
              <!-- Sales Chart Canvas -->
                    <div class="card-header">
                    <h5 class="card-title colorazulfiplex"><b>  800 DL </b></h5>
                        <div class="card-tools">
                      
                        <?php if ($maxpwr_graf_totalpass_1_1== true) 
                                {
                                  ?>
                                  <span class="badge badge-pill badge-success">Pass</span>
                                  <?php
                                }
                                else
                                {
                                  ?>
                                  <span class="badge badge-pill badge-danger">Not Passed</span>
                                  <?php
                                }
                        
                        ?>
                            
                        </div>
                    </div>
                    <div class="chart">
                      <canvas id="grafmaxpwr1a" height="280" style="height: 280;"></canvas>
                    </div>
              </div> 

      </div>

    </div>


  <!-- Fin Graficos de max pwr- ---->
  <?php
  
  $table_imd3_freq_0_0_array  = explode(",", $table_imd3_freq_0_0); 
  $table_imd3_freq_0_1_array  = explode(",", $table_imd3_freq_0_1); 
  $table_imd3_freq_1_0_array  = explode(",", $table_imd3_freq_1_0); 
  $table_imd3_freq_1_1_array  = explode(",", $table_imd3_freq_1_1); 

  $table_imd3_values_0_0_array  = explode(",", $table_imd3_values_0_0); 
  $table_imd3_values_0_1_array  = explode(",", $table_imd3_values_0_1); 
  $table_imd3_values_1_0_array  = explode(",", $table_imd3_values_1_0); 
  $table_imd3_values_1_1_array  = explode(",", $table_imd3_values_1_1); 
  ?>
  <hr>
  <h6 class="colornaranajafiplex"><b>IMD3 Check </b></h6> 
  <!-- tablas IMD3 Check ---->
  <div class="row">
      <div class="col-3">

              <div class="card">
              <!-- Sales Chart Canvas -->
                    <div class="card-header">
                    <h5 class="card-title colorazulfiplex"><b>700 UL </b></h5>
                    
                        <div class="card-tools">
                      
                        <?php if ($tabla_imd3_totalpass_0_0== true) 
                                {
                                  ?>
                                  <span class="badge badge-pill badge-success">Pass</span>
                                  <?php
                                }
                                else
                                {
                                  ?>
                                  <span class="badge badge-pill badge-danger">Not Passed</span>
                                  <?php
                                }
                        
                        ?>
                        
                         
                        </div>
                    </div>
                    <div class="chart">
                
                    <table class="table">
                    <thead class="thead-dark">
                              <tr>
                              
                                <th scope="col">IMD1 [@<?php echo $table_imd3_freq_0_0_array[0]; ?>]</th>
                                <th scope="col">Fundamental Tone [@<?php echo $table_imd3_freq_0_0_array[1]; ?>]</th>
                                <th scope="col">FundamentalTone [@<?php echo $table_imd3_freq_0_0_array[2]; ?>]</th>
                                <th scope="col">IMD2 [@<?php echo $table_imd3_freq_0_0_array[3]; ?>]</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <th scope="row"><?php echo $table_imd3_values_0_0_array[0]; ?></th>
                                <td><?php echo $table_imd3_values_0_0_array[1]; ?></td>
                                <td><?php echo $table_imd3_values_0_0_array[2]; ?></td>
                                <td><?php echo $table_imd3_values_0_0_array[3]; ?></td>
                              </tr>
                          
                            </tbody>
                          </table>
                    </div>
              </div> 

      </div>
      <div class="col-3"><div class="card">
              <!-- Sales Chart Canvas -->
                    <div class="card-header">
                    <h5 class="card-title colorazulfiplex"><b> 700 DL</b></h5>
                        <div class="card-tools">
                      
                        <?php if ($tabla_imd3_totalpass_0_1== true) 
                                {
                                  ?>
                                  <span class="badge badge-pill badge-success">Pass</span>
                                  <?php
                                }
                                else
                                {
                                  ?>
                                  <span class="badge badge-pill badge-danger">Not Passed</span>
                                  <?php
                                }
                        
                        ?>
                            
                        </div>
                    </div>
                    <div class="chart">
                    <table class="table">
                    <thead class="thead-dark">
                              <tr>
                              
                                <th scope="col">IMD1 [@<?php echo $table_imd3_freq_0_1_array[0]; ?>]</th>
                                <th scope="col">Fundamental Tone [@<?php echo $table_imd3_freq_0_1_array[1]; ?>]</th>
                                <th scope="col">FundamentalTone [@<?php echo $table_imd3_freq_0_1_array[2]; ?>]</th>
                                <th scope="col">IMD2 [@<?php echo $table_imd3_freq_0_1_array[3]; ?>]</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <th scope="row"><?php echo $table_imd3_values_0_1_array[0]; ?></th>
                                <td><?php echo $table_imd3_values_0_1_array[1]; ?></td>
                                <td><?php echo $table_imd3_values_0_1_array[2]; ?></td>
                                <td><?php echo $table_imd3_values_0_1_array[3]; ?></td>
                              </tr>
                          
                            </tbody>
                          </table>
                    </div>
              </div> </div>
      <div class="col-3">

      <div class="card">
              <!-- Sales Chart Canvas -->
                    <div class="card-header">
                    <h5 class="card-title colorazulfiplex"><b>  800 UL</b></h5>
                        <div class="card-tools">
                      
                        <?php if ($tabla_imd3_totalpass_1_0== true) 
                                {
                                  ?>
                                  <span class="badge badge-pill badge-success">Pass</span>
                                  <?php
                                }
                                else
                                {
                                  ?>
                                  <span class="badge badge-pill badge-danger">Not Passed</span>
                                  <?php
                                }
                        
                        ?>
                            
                        </div>
                    </div>
                    <div class="chart">
                    <table class="table">
                    <thead class="thead-dark">
                              <tr>
                              
                                <th scope="col">IMD1 [@<?php echo $table_imd3_freq_1_0_array[0]; ?>]</th>
                                <th scope="col">Fundamental Tone [@<?php echo $table_imd3_freq_1_0_array[1]; ?>]</th>
                                <th scope="col">FundamentalTone [@<?php echo $table_imd3_freq_1_0_array[2]; ?>]</th>
                                <th scope="col">IMD2 [@<?php echo $table_imd3_freq_1_0_array[3]; ?>]</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <th scope="row"><?php echo $table_imd3_values_1_0_array[0]; ?></th>
                                <td><?php echo $table_imd3_values_1_0_array[1]; ?></td>
                                <td><?php echo $table_imd3_values_1_0_array[2]; ?></td>
                                <td><?php echo $table_imd3_values_1_0_array[3]; ?></td>
                              </tr>
                          
                            </tbody>
                          </table>
                    </div>
              </div> 

      </div>
      <div class="col-3">

      <div class="card">
              <!-- Sales Chart Canvas -->
                    <div class="card-header">
                    <h5 class="card-title colorazulfiplex"><b>  800 DL </b></h5>
                        <div class="card-tools">
                      
                        <?php if ($tabla_imd3_totalpass_1_1== true) 
                                {
                                  ?>
                                  <span class="badge badge-pill badge-success">Pass</span>
                                  <?php
                                }
                                else
                                {
                                  ?>
                                  <span class="badge badge-pill badge-danger">Not Passed</span>
                                  <?php
                                }
                        
                        ?>
                            
                        </div>
                    </div>
                    <div class="chart">
                    <table class="table   ">
                          <thead class="thead-dark">
                              <tr>
                              
                                <th scope="col"class="thead-dark">IMD1 [@<?php echo $table_imd3_freq_1_1_array[0]; ?>]</th>
                                <th scope="col" class="thead-dark">Fundamental Tone [@<?php echo $table_imd3_freq_1_1_array[1]; ?>]</th>
                                <th scope="col" class="thead-dark">FundamentalTone [@<?php echo $table_imd3_freq_1_1_array[2]; ?>]</th>
                                <th scope="col" class="thead-dark">IMD2 [@<?php echo $table_imd3_freq_1_1_array[3]; ?>]</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <th scope="row"><?php echo $table_imd3_values_1_1_array[0]; ?></th>
                                <td><?php echo $table_imd3_values_1_1_array[1]; ?></td>
                                <td><?php echo $table_imd3_values_1_1_array[2]; ?></td>
                                <td><?php echo $table_imd3_values_1_1_array[3]; ?></td>
                              </tr>
                          
                            </tbody>
                          </table>
                    </div>
              </div> 

      </div>

    </div>
          




</section> 
</div>
<!-- fin GRAFICOS ecualización -->
<section class="col-lg-12 connectedSortable ui-sortable d-none">
<br>  <h5>TimeLine</h5>
  <hr style=" border: 1px solid #007bff;">
<div id="visualization" name="visualization"   ></div>
</section> 

<hr>
 
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

<script src="crypto-js.js"></script><!-- https://github.com/brix/crypto-js/releases crypto-js.js can be download from here -->

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

<script src="plugins/chart.js/utils.js"></script>

<style type="text/css">


.horizontal-scroll-contenedor {
    width: auto;
    /*height: 100px;*/
    overflow-y: hidden;
    overflow-x: auto;
    padding: 10px;   
    white-space: nowrap;
}

.horizontal-scroll-contenedor > div {
       
       
        margin: 0 10px 0 0;
        padding: 0;
        display: inline-block;
        text-align: center;
        line-height: 22px;
    }

    .step_borde_verde
    {

      border-radius: 20px 20px 0px 2px;
-moz-border-radius: 20px 20px 0px 2px;
-webkit-border-radius: 20px 20px 0px 2px;
border: 2px solid #0d913b;
    }
    
    .step_borde_rojo
    {

      border-radius: 20px 20px 0px 2px;
-moz-border-radius: 20px 20px 0px 2px;
-webkit-border-radius: 20px 20px 0px 2px;
border: 2px solid #ff0303;
    }
    .step_borde_gris
    {

      border-radius: 20px 20px 0px 2px;
-moz-border-radius: 20px 20px 0px 2px;
-webkit-border-radius: 20px 20px 0px 2px;
border: 2px solid #696969;
    }

 
 .vis-item.orange
    {
         border-color: orange;
         color:black;
         background-color: orange;
    }

    .vis-item.red
    {
         border-color: red;
         color:white;
         background-color: red;
    }
    /*  'Unit Calibration' */
    .vis-item.mm5c6bc0
    {
         border-color: #5c6bc0;
         color:white;
         background-color: #5c6bc0;
    }
      /*  'Accept DigitalBoard' */
      .vis-item.mm202020
    {
         border-color: #202020;
         color:white;
         background-color: #202020;
    }
      /*  'Total Pass */
      .vis-item.mmdb4437
    {
         border-color: #db4437;
         color:white;
         background-color: #db4437;
    }
      /*  'Printer Services StandAlone'' */
      .vis-item.mme06055
    {
         border-color: #e06055;
         color:white;
         background-color: #e06055;
    }
      /*  'Unit Final Check'' */
      .vis-item.mme06055
    {
         border-color: #9e9d24;
         color:white;
         background-color: #9e9d24;
    }
       /*  'Print Label'' */
       .vis-item.mme4776e
    {
         border-color: #e4776e;
         color:white;
         background-color: #e4776e;
    }
    /* 'Accept DiB Flex', */
    .vis-item.mmf5bf26
    {
         border-color: #f5bf26;
         color:white;
         background-color: #f5bf26;
    }
     /* 'Accept Module', */
     .vis-item.mm51b886
    {
         border-color: #51b886;
         color:white;
         background-color: #51b886;
    }
     /* Digital Module', */
     .vis-item.mmab47bc
    {
         border-color: #ab47bc;
         color:white;
         background-color: #ab47bc;
    }
     /* Unit Final Check', */
    .vis-item.mm9e9d24
    {
         border-color: #9e9d24;
         color:white;
         background-color: #9e9d24;
    }
        /*'Unlock DiB, */
        .vis-item.mmf06292
    {
         border-color: #f06292;
         color:white;
         background-color: #f06292;
    }
        /* Instruments GUI, */
        .vis-item.mmacab44
    {
         border-color: #acab44;
         color:white;
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
    
    

    .vis-item.red
    {
        border-color: red;
        color:white;
         background-color: red;
    }
    .vis-item.yellow
    {
        border-color: yellow;
         background-color: yellow;
    }
    .vis-item.orange
    {
        border-color: orange;
         background-color: orange;
    }

    .history-tl-container{
 
}
.history-tl-container ul.tl{
    margin:20px 0;
    padding:0;
    display:inline-block;

}
.history-tl-container ul.tl li{
    list-style: none;
    margin:auto;
    margin-left:15px;
    min-height:50px;
    /*background: rgba(255,255,0,0.1);*/
    border-left:1px dashed #86D6FF;
    padding:0 0 50px 30px;
    position:relative;
}
.history-tl-container ul.tl li:last-child{ border-left:0;}
.history-tl-container ul.tl li::before{
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
.history-tl-container ul.tl li:hover::before{
    border-color:  #258CC7;
    transition: all 1000ms ease-in-out;
}
ul.tl li .item-title{
}
ul.tl li .item-detail{
    color:rgba(0,0,0,0.5);
    font-size:12px;
}
ul.tl li .timestamp{
    color: #8D8D8D;
    position: absolute;
  width:100px;
    left: -60%;
    text-align: right;
    font-size: 12px;
}
 /*
 
		'#f06292' =>',
		'#acab44' =>''
*/

.htimeline { list-style: none; padding: 0; margin: 20px 0 0; }

.htimeline .step { float: left; border-top-style: solid; border-top-width: 5px; position: relative; margin-bottom: 25px; text-align: left; padding: 3px 0 5px 10px; background-color: #ddd; color: #333;  vertical-align: middle; border-right: solid 1px #bbb; transition: all 0.5s ease;}
.htimeline .step:nth-child(odd) { background-color: #eee; }
.htimeline .step:first-child { border-left: solid 1px #bbb; }
.htimeline .step:hover { background-color: #ccc; border-bottom-width: 6px; }

.htimeline .step > div { margin: 0 5px; font-size: 14px; vertical-align: top; padding: 0;}

.htimeline .step.green { border-top-color: #348F50;}
.htimeline .step.orange { border-top-color: #F09819;}
.htimeline .step.red { border-top-color: #C04848;}
.htimeline .step.blue { border-top-color: #49a09d;}

.htimeline .step::before { width: 15px; height: 15px; border-radius: 50px; content: ' '; background-color: white; position: absolute; top: -10px; left: 0px; border-style: solid; border-width: 3px; transition: all 0.5s ease;}
.htimeline .step:hover::before { width: 18px; height: 18px; bottom: -12px; }
.htimeline .step.green::before {border-color: #348F50;}
.htimeline .step.orange::before {border-color: #F09819;}
.htimeline .step.red::before {border-color: #C04848;}
.htimeline .step.blue::before {border-color: #49a09d;}

.htimeline .step::after { content: attr(data-date); position: absolute; top: -20px; left: 17px; font-size: 11px; font-style: italic; color: #888}

/*TASKS*/
.htimeline .step .tasks { margin-top: 10px; }
.htimeline .step .tasks .resource {position: relative; height: 40px;}
.htimeline .step .tasks .resource::before { position: absolute; bottom: 2px; left: -5px; content: attr(data-name); font-size: 10px; font-style: italic; color: #888}
.htimeline .step .tasks .task { overflow: hidden; font-size: 10px; padding: 3px; border: solid 1px white; border-radius: 4px; min-height: 20px;}
.htimeline .step.green .tasks .task { background-color: #348F50; color: white; }
.htimeline .step.orange .tasks .task { background-color: #F09819; color: white; }
.htimeline .step.red .tasks .task { background-color: #C04848; color: white; }
.htimeline .step.blue .tasks .task { background-color: #49a09d; color: white; }


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
var refreshIntervalIdbuscaruninfo =0;

var   datamm={};
var iduniqueop_band_0_uldl_0_tx ="";
var			iduniqueop_band_0_uldl_1_tx ="";
	var		iduniqueop_band_1_uldl_0_tx ="";
	var		iduniqueop_band_1_uldl_1_tx ="";
  var   label_tx={};
  var   label_tx_0_1={};
  var   label_tx2="";
  var label_tx_1="";
  var datax ='';
  var label_700_compartir= '';

var graf_total_0_0="N";
var graf_rx_0_0="N";
var graf_tx_0_0="N";
var graf_total_0_1="N";
var graf_rx_0_1="N";
var graf_tx_0_1="N";
var graf_total_1_0="N";
var graf_rx_1_0="N";
var graf_tx_1_0="N";
var graf_total_1_1="N";
var graf_rx_1_1="N";
var graf_tx_1_1="N";

// recuperamos el querystring
const querystring = window.location.search
console.log(querystring) // '?q=pisos+en+barcelona&ciudad=Barcelona'

// usando el querystring, creamos un objeto del tipo URLSearchParams
const params = new URLSearchParams(querystring)

function window_mouseout( obj, evt, fn ) {

if ( obj.addEventListener ) {

    obj.addEventListener( evt, fn, false );
}
else if ( obj.attachEvent ) {

    obj.attachEvent( 'on' + evt, fn );
}
}


 
   
	$( document ).ready(function() {
		
		//Inicio mostrar hora live
 
   var idrunrun = params.get('idruninfo');
   var vidsn = params.get('sn');
     console.log('idrun:'+params.get('idruninfo'));

		 var interval = setInterval(function() {
			 
        var momentNow = moment();
		var newYork    = momentNow.tz('America/New_York').format('ha z');
        $('#date-part').html(momentNow.format('YYYY/MM/DD') 	  );
        $('#time-part').html(momentNow.format('hh:mm:ss'));
		}, 100);
		//FIN mostrar hora live
			console.log( "ready!" );
     

 
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
         timeline_listrutines_init(idrunrun,vidsn);
         armar_graficos_maxpower();
     
   ///    timeline_rutimes(); //funcion vieja solo para el LOAD
  
   grafica_puntos()
	});
	

	// controlar inactividad en la web	
		$(document).inactivityTimeout({
                inactivityWait: 10000,
                dialogWait: 10,
                logoutUrl: 'logout.php'
            })
	// fin controlar inactividad en la web		
 
  function   timeline_listrutines_init(idrunaconsultar, vvsn)
  {

 
             var formData = new FormData();
         var req = new XMLHttpRequest();
        
         formData.append("idr", idrunaconsultar);
         formData.append("vvsn", vvsn);
         

         formData.append("btnt1v", $('#btnt1v').val());
         formData.append("btnt2v", $('#btnt2v').val());
         formData.append("btnt3v", $('#btnt3v').val());
         formData.append("btnt4v", $('#btnt4v').val());
         formData.append("btnt5v", $('#btnt5v').val());
         formData.append("btnt6v", $('#btnt6v').val());

         
       
    
         ///req.open('GET', 'fasclient_query.php');
         req.open("POST", "ajax_html_timelinerutinelistnuevo.php");
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


  function   timeline_listrutines(idrunaconsultar)
  {
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
             
             }
             else {
                 reject();
             }
           };
   
         
         })
       //fin enviar datos a procesar
   //   }, 10000);	    
      
            
  }


function posicionarme_div(divaposicionar)
{
   
        var current = $('#timelinerutines').scrollLeft();
        var left = $('#'+divaposicionar).position().left;        
 
        event.preventDefault();

        $('#timelinerutines').animate({
            scrollLeft: current + left - 100
        }, 200);
   
}

  ///filtrarme_list_rutine(1,'TOTAL',1);

function filtrarme_list_rutine(idbtn, tipobtn, valor)
{
  
 // msjwaitline1
 $("#msjwaitline1").removeClass('d-none');
  $('#msjwaitline1').show();
  $("#timelinerutines").html('');


  if (idbtn==1)
  {
    if ( $('#btnt'+idbtn).html().includes('far fa-check-circle')==false)
      {
        $('#btnt'+idbtn).html('');
        $('#btnt'+idbtn).html(' <i class=\"far fa-check-circle\"></i> Passed');
        $('#btnt'+idbtn+'v').val('true');
        
      }
      else
      {
        $('#btnt'+idbtn).html('');
        $('#btnt'+idbtn).html(' Passed');
        $('#btnt'+idbtn+'v').val('false');
      }
  }
  if (idbtn==2)
  {
    if ( $('#btnt'+idbtn).html().includes('far fa-check-circle')==false)
      {
        $('#btnt'+idbtn).html('');
        $('#btnt'+idbtn).html(' <i class=\"far fa-check-circle\"></i> Not Passed');
        $('#btnt'+idbtn+'v').val('true');
      }
      else
      {
        $('#btnt'+idbtn).html('');
        $('#btnt'+idbtn).html(' Not Passed');
        $('#btnt'+idbtn+'v').val('false');
      }
  }
  if (idbtn==3)
  {
    if ( $('#btnt'+idbtn).html().includes('far fa-check-circle')==false)
      {
        $('#btnt'+idbtn).html('');
        $('#btnt'+idbtn).html(' <i class=\"far fa-check-circle\"></i> BAND 0');
        $('#btnt'+idbtn+'v').val(1);
      }
      else
      {
        $('#btnt'+idbtn).html('');
        $('#btnt'+idbtn).html(' BAND 0');
        $('#btnt'+idbtn+'v').val(0);
      }
  }
  if (idbtn==4)
  {
    if ( $('#btnt'+idbtn).html().includes('far fa-check-circle')==false)
      {
        $('#btnt'+idbtn).html('');
        $('#btnt'+idbtn).html(' <i class=\"far fa-check-circle\"></i> BAND 1');
        $('#btnt'+idbtn+'v').val(1);
      }
      else
      {
        $('#btnt'+idbtn).html('');
        $('#btnt'+idbtn).html(' BAND 1');
        $('#btnt'+idbtn+'v').val(0);
      }
  }
  if (idbtn==5)
  {
    if ( $('#btnt'+idbtn).html().includes('far fa-check-circle')==false)
      {
        $('#btnt'+idbtn).html('');
        $('#btnt'+idbtn).html(' <i class=\"far fa-check-circle\"></i> ULDL 0');
        $('#btnt'+idbtn+'v').val(1);
      }
      else
      {
        $('#btnt'+idbtn).html('');
        $('#btnt'+idbtn).html(' ULDL 0');
        $('#btnt'+idbtn+'v').val(0);
      }
  }
  if (idbtn==6)
  {
    if ( $('#btnt'+idbtn).html().includes('far fa-check-circle')==false)
      {
        $('#btnt'+idbtn).html('');
        $('#btnt'+idbtn).html(' <i class=\"far fa-check-circle\"></i> ULDL 1');
        $('#btnt'+idbtn+'v').val(1);
      }
      else
      {
        $('#btnt'+idbtn).html('');
        $('#btnt'+idbtn).html(' ULDL 1');
        $('#btnt'+idbtn+'v').val(0);
      }
  }
  var idrunrun = params.get('idr');
  //console.log('btn refresca rapido ' + idrunrun );
  timeline_listrutines(idrunrun);

}

function stop_rutinas_autorerefresh()
{
     clearInterval(refreshIntervalIdbuscaruninfo);    
     $("#btntref1").removeClass("btn-outline-primary");
  $("#btntref2").removeClass("btn-outline-primary");
  $("#btntref3").removeClass("btn-outline-primary");  
  $("#btntref1").addClass("btn-outline-secondary");
  $("#btntref2").addClass("btn-outline-secondary");
  $("#btntref3").addClass("btn-outline-secondary");     
}

function rutinas_autorerefresh(cant_milisegundos)
{

  $("#btntref1").removeClass("btn-outline-primary");
  $("#btntref2").removeClass("btn-outline-primary");
  $("#btntref3").removeClass("btn-outline-primary");
  $("#btntref1").addClass("btn-outline-secondary");
  $("#btntref2").addClass("btn-outline-secondary");
  $("#btntref3").addClass("btn-outline-secondary");  


  if (cant_milisegundos==10000)
  {
    $("#btntref1").removeClass("btn-outline-secondary");
    $("#btntref1").addClass("btn-outline-primary");
  }
  if (cant_milisegundos==30000)
  {
      $("#btntref2").removeClass("btn-outline-secondary");
    $("#btntref2").addClass("btn-outline-primary");
  }
  if (cant_milisegundos==60000)
  {
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
        var idrunaconsultar =params.get('idr');
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
             
             }
             else {
                 reject();
             }
           };
   
         
         })
       //fin enviar datos a procesar
      }, cant_milisegundos);	    
      

}

  function   timeline_autocall(idrunaconsultar)
  {
    $('#msjwaitline').hide();
    cant_veces_controlo = cant_veces_controlo + 1 ;

var options = {
               // option groupOrder can be a property name or a sort function
               // the sort function must compare two groups and return a value
               //     > 0 when a > b
               //     < 0 when a < b
               //       0 when a == b
               groupOrder: function (a, b) {
                 return a.value - b.value;
               },
               groupOrderSwap: function (a, b, groups) {
                 var v = a.value;
                 a.value = b.value;
                 b.value = v;
               },
               groupTemplate: function(group){
                 var container = document.createElement('div');
                 var label = document.createElement('span');
                 label.innerHTML = group.content + ' ';
                 container.insertAdjacentElement('afterBegin',label);
                 var hide = document.createElement('button');
                 hide.innerHTML = 'hide';
                 hide.style.fontSize = 'small';
                 hide.addEventListener('click',function(){
                   groups.update({id: group.id, visible: false});
                 });
               //  container.insertAdjacentElement('beforeEnd',hide);
                 return container;
               },
               orientation: 'both',
               editable: false,
               groupEditable: false,            
               locale : 'en',
               zoomKey:'ctrlKey',
               maxHeight:'500px',
               minHeight:'500px'
             };

       
     var items = new vis.DataSet();
       var groups = new vis.DataSet();


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
      
            
  }


  ///funciona andandno
  function timeline_rutimes()
  {
       ///Agregamos el timeline 1.

    
								
							cant_veces_controlo = cant_veces_controlo + 1 ;

       var options = {
                      // option groupOrder can be a property name or a sort function
                      // the sort function must compare two groups and return a value
                      //     > 0 when a > b
                      //     < 0 when a < b
                      //       0 when a == b
                      groupOrder: function (a, b) {
                        return a.value - b.value;
                      },
                      groupOrderSwap: function (a, b, groups) {
                        var v = a.value;
                        a.value = b.value;
                        b.value = v;
                      },
                      groupTemplate: function(group){
                        var container = document.createElement('div');
                        var label = document.createElement('span');
                        label.innerHTML = group.content + ' ';
                        container.insertAdjacentElement('afterBegin',label);
                        var hide = document.createElement('button');
                        hide.innerHTML = 'hide';
                        hide.style.fontSize = 'small';
                        hide.addEventListener('click',function(){
                          groups.update({id: group.id, visible: false});
                        });
                      //  container.insertAdjacentElement('beforeEnd',hide);
                        return container;
                      },
                      orientation: 'both',
                      editable: false,
                      groupEditable: false,
                      start: new Date(Date.UTC(2021, 05, 21, 11, 44, 0)),
                      end: new Date(Date.UTC(2021, 05, 21, 15, 0, 0)),
                      locale : 'en',
                      zoomKey:'ctrlKey',
                      maxHeight:'500px',
                      minHeight:'500px'
                    };

              
            var items = new vis.DataSet();
              var groups = new vis.DataSet();
      

            $.ajax
              ({ 
                    url: 'ajax_timelinejsonautotestbox.php?idruninfo='+params.get('idr'),
                    data: "idlog=",	
                    type: 'post',
                    async:true,
                    cache:false,
                    success: function(data)
                    {
                    ////  console.log(data);

                      $('#msjwaitline').hide();

                      var datax =  data.items;
                      var losgroupx =data.grupos;
                      var lostitulo =data.titulo[0];
                      var data_returnloss =data.returnloss[0];
                      console.log('return loss');
                      			console.log(data_returnloss);
                      //			console.log(datax);
                     //     console.log(lostitulo);
                      items.add(datax);
                      groups.clear();
                      groups.add( losgroupx) ;

                      timeline.setOptions(options);
                      timeline.setGroups(groups);
                      timeline.setItems(items);
                    //  console.log('mostrar totalpass'+lostitulo.totalpass );

                      
                      timeline.fit('linear');

                      var laduracionamostrar='';
                      var titulo_time='';
                      if ( lostitulo.duration == '00:00:00')
                      {
                        laduracionamostrar= lostitulo.durationpartial;
                        titulo_time='Execution time: ';
                        lafechaamostrar =lostitulo.datetimelogparcial;
                      }
                      else
                      {
                        laduracionamostrar= lostitulo.duration;
                        titulo_time='Total run time: ';
                        lafechaamostrar = lostitulo.datetimelogtotal;
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


                      $('#idreturnloss').html('');
                      var amostrar_table = '<br>  <h5>Calibration Values</h5><hr style=" border: 1px solid #007bff;"><table class="table"><thead class="thead-dark"><tr><th scope="col">700 DL</th><th scope="col">Value</th><th scope="col">800 DL</th><th scope="col">Value</th></tr></thead><tbody>              <tr><th >ReturnLoss Loaded</th><td>'+data_returnloss.v700_Loaded+' dB</td><th>ReturnLoss Loaded</th><td>'+data_returnloss.v800_Loaded+' dB</td></tr><tr><th >ReturnLoss Unloaded</th><td>'+data_returnloss.v700_UnLoaded+' dB</td><th>ReturnLoss Unloaded</th><td>'+data_returnloss.v800_UnLoaded+' dB</td></tr><tr><th >ReturnLossThreshold</th><td>'+data_returnloss.v700_Threshold+' dB</td><th> ReturnLoss Threshold</th><td>'+data_returnloss.v800_Threshold+' dBd</td></tr></tbody></table>';
                      $('#idreturnloss').html(amostrar_table);
	
                    
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
                                
                    }
               });

 
  

              // function to make all groups visible again
              function showAllGroups(){
                groups.forEach(function(group){
                  groups.update({id: group.id, visible: true});
                })
              };
  
  }   
  
  function sumArray(a, b) {
      var c = [];
      for (var i = 0; i < Math.max(a.length, b.length); i++) {
        c.push( parseFloat(a[i] || 0) + parseFloat(b[i] || 0));
      }
      return c;
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

   function armar_graficos_maxpower()
   {
      var grafpower0 = $('#grafpower0').get(0).getContext('2d'); 
      var grafpower1 = $('#grafpower1').get(0).getContext('2d'); 
      var grafpower0a = $('#grafpower0a').get(0).getContext('2d'); 
      var grafpower1a = $('#grafpower1a').get(0).getContext('2d'); 


      var grafgain0 = $('#grafgain0').get(0).getContext('2d'); 
      var grafgain0a = $('#grafgain1').get(0).getContext('2d'); 
      var grafgain0a = $('#grafgain0a').get(0).getContext('2d'); 
      var grafgain1a = $('#grafgain1a').get(0).getContext('2d'); 

      var grafmaxpwr0 = $('#grafmaxpwr0').get(0).getContext('2d'); 
      var grafmaxpwr0a = $('#grafmaxpwr0a').get(0).getContext('2d'); 
      var grafmaxpwr1 = $('#grafmaxpwr1').get(0).getContext('2d'); 
      var grafmaxpwr1a = $('#grafmaxpwr1a').get(0).getContext('2d'); 

      var graflineality0 = $('#graflineality0').get(0).getContext('2d'); 
      var graflineality1 = $('#graflineality1').get(0).getContext('2d'); 
      var graflineality2 = $('#graflineality2').get(0).getContext('2d'); 
      var graflineality3 = $('#graflineality3').get(0).getContext('2d'); 

       /*
      console.log('$agc_band_0_0');
    console.log(<?php echo  $agc_band_0_0;?>);
    console.log('$pwr_out_measure_band_0_0');
    console.log(<?php echo  $pwr_out_measure_band_0_0;?>);
    console.log('$pwr_out_exp_band_0_0_qq');
    console.log(<?php echo  $pwr_out_exp_band_0_0_qq;?>);
*/
  

    
        
                      

      var losdatos_lsgp_0_0 = {
    labels  : [<?php echo  $agc_band_0_0;?>],
    datasets: [
	  {
        label               : 'Pwr Out Measured ',
		     backgroundColor     : 'rgba(60,141,188,0.3)',
        borderColor         : 'rgba(60,141,188,1)',
        pointRadius          : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
     	 data                : [<?php echo  $pwr_out_measure_band_0_0;?>]
			  
      },
	   {
        label               : 'PwrOut Expecting',		
		backgroundColor     : 'rgba(255, 99, 132, 0.5)',
        borderColor         : 'rgba(255, 99, 132, 1)',
        pointRadius         : false,
        pointColor          : 'rgba(255, 99, 132, 1)',
        pointStrokeColor    : '#c1c7d1',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(255, 99, 132, 1)',		
     	 data          :[<?php echo  $pwr_out_exp_band_0_0_qq;?>]
      },
    ]
  };
 
  var losdatos_lsgp_0_1 = {
    labels  : [<?php echo  $agc_band_0_1;?>],
    datasets: [
	  {
        label               : 'Pwr Out Measured',
		     backgroundColor     : 'rgba(60,141,188,0.3)',
        borderColor         : 'rgba(60,141,188,1)',
        pointRadius          : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
     	 data                : [<?php echo  $pwr_out_measure_band_0_1;?>]
			  
      },
	   {
        label               : 'PwrOut Expecting',		
		backgroundColor     : 'rgba(255, 99, 132, 0.5)',
        borderColor         : 'rgba(255, 99, 132, 1)',
        pointRadius         : false,
        pointColor          : 'rgba(255, 99, 132, 1)',
        pointStrokeColor    : '#c1c7d1',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(255, 99, 132, 1)',		
     	 data          :[<?php echo  $pwr_out_exp_band_0_1_qq;?>]
      },
    ]
  };
  var losdatos_lsgp_1_0 = {
    labels  : [<?php echo  $agc_band_1_0;?>],
    datasets: [
	  {
        label               : 'Pwr Out Measured',
		     backgroundColor     : 'rgba(60,141,188,0.3)',
        borderColor         : 'rgba(60,141,188,1)',
        pointRadius          : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
     	 data                : [<?php echo  $pwr_out_measure_band_1_0;?>]
			  
      },
	   {
        label               : 'PwrOut Expecting',		
		backgroundColor     : 'rgba(255, 99, 132, 0.5)',
        borderColor         : 'rgba(255, 99, 132, 1)',
        pointRadius         : false,
        pointColor          : 'rgba(255, 99, 132, 1)',
        pointStrokeColor    : '#c1c7d1',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(255, 99, 132, 1)',		
     	 data          :[<?php echo  $pwr_out_exp_band_1_0_qq;?>]
      },
    ]
  };
  var losdatos_lsgp_1_1 = {
    labels  : [<?php echo  $agc_band_1_1;?>],
    datasets: [
	  {
        label               : 'Pwr Out Measured ',
		     backgroundColor     : 'rgba(60,141,188,0.3)',
        borderColor         : 'rgba(60,141,188,1)',
        pointRadius          : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
     	 data                : [<?php echo  $pwr_out_measure_band_1_1;?>]
			  
      },
	   {
        label               : 'PwrOut Expecting',		
		backgroundColor     : 'rgba(255, 99, 132, 0.5)',
        borderColor         : 'rgba(255, 99, 132, 1)',
        pointRadius         : false,
        pointColor          : 'rgba(255, 99, 132, 1)',
        pointStrokeColor    : '#c1c7d1',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(255, 99, 132, 1)',		
     	 data          :[<?php echo  $pwr_out_exp_band_1_1_qq;?>]
      },
    ]
  };

<?php


 
$datos_gainreachi_0_0_array = "";
$datos_gain_0_0splt  = explode(",", $datos_gain_0_0);
foreach ($datos_gain_0_0splt as &$value) {
  
  $datos_gainreachi_0_0_array = $datos_gainreachi_0_0_array.$datos_gainreachi_0_0.",";
 /// echo "<br>aaaaaa".$datos_gainreachi_0_0;
}
 
$datos_gainreachi_0_1_array = "";
$datos_gain_0_1splt  = explode(",", $datos_gain_0_1);
foreach ($datos_gain_0_1splt as &$value) {
  
  $datos_gainreachi_0_1_array = $datos_gainreachi_0_1_array.$datos_gainreachi_0_1.",";
 /// echo "<br>aaaaaa".$datos_gainreachi_0_0;
}
 
$datos_gainreachi_1_0_array = "";
$datos_gain_0_1splt  = explode(",", $datos_gain_1_0);
foreach ($datos_gain_1_0splt as &$value) {
  
  $datos_gainreachi_1_0_array = $datos_gainreachi_1_0_array.$datos_gainreachi_1_0.",";
 /// echo "<br>aaaaaa".$datos_gainreachi_0_0;
}

$datos_gainreachi_1_1_array = "";
$datos_gain_1_1splt  = explode(",", $datos_gain_1_1);
foreach ($datos_gain_1_1splt as &$value) {
  
  $datos_gainreachi_1_1_array = $datos_gainreachi_1_1_array.$datos_gainreachi_1_1.",";
 /// echo "<br>aaaaaa".$datos_gainreachi_0_0;
}

?>
 

  var datosgraficogain_0_0 = {
    labels  : [<?php echo  $freq_gainymaxpwr_0_0;?>],
    datasets: [
	  {
        label               : 'Gain Measured ',
		     backgroundColor     : 'rgba(60,141,188,0.3)',
        borderColor         : 'rgba(60,141,188,1)',
        pointRadius          : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
     	 data                : [<?php echo  $datos_gain_0_0 ; ?>]
			  
      } ,
	   {
        label               : 'Gain  Reference',		
		backgroundColor     : 'rgba(255, 99, 132, 0.5)',
        borderColor         : 'rgba(255, 99, 132, 1)',
        pointRadius         : false,
        pointColor          : 'rgba(255, 99, 132, 1)',
        pointStrokeColor    : '#c1c7d1',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(255, 99, 132, 1)',		
     	 data          :[<?php echo  $datos_gainreachi_0_0_array; ?>]
      },
    ]
  };
  

  var datosgraficogain_0_1 = {
    labels  : [<?php echo  $freq_gainymaxpwr_0_1;?>],
    datasets: [
	  {
        label               : 'Gain Measured ',
		     backgroundColor     : 'rgba(60,141,188,0.3)',
        borderColor         : 'rgba(60,141,188,1)',
        pointRadius          : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
     	 data                : [<?php echo  $datos_gain_0_1; ?>]
			  
      } ,
	   {
        label               : 'Gain Reference ',		
		backgroundColor     : 'rgba(255, 99, 132, 0.5)',
        borderColor         : 'rgba(255, 99, 132, 1)',
        pointRadius         : false,
        pointColor          : 'rgba(255, 99, 132, 1)',
        pointStrokeColor    : '#c1c7d1',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(255, 99, 132, 1)',		
     	 data          :[<?php echo  $datos_gainreachi_0_1_array ; ?>]
      },
    ]
  };

  var datosgraficogain_1_0 = {
    labels  : [<?php echo  $freq_gainymaxpwr_1_0;?>],
    datasets: [
	  {
        label               : 'Gain Measured ',
		     backgroundColor     : 'rgba(60,141,188,0.3)',
        borderColor         : 'rgba(60,141,188,1)',
        pointRadius          : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
     	 data                : [<?php echo  $datos_gain_1_0; ?>]
			  
      } ,
	   {
        label               : 'Gain Reference',		
		backgroundColor     : 'rgba(255, 99, 132, 0.5)',
        borderColor         : 'rgba(255, 99, 132, 1)',
        pointRadius         : false,
        pointColor          : 'rgba(255, 99, 132, 1)',
        pointStrokeColor    : '#c1c7d1',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(255, 99, 132, 1)',		
     	 data          :[<?php echo  $datos_gainreachi_0_0_array ; ?>]
      },
    ]
  };

  
  var datosgraficogain_1_1 = {
    labels  : [<?php echo  $freq_gainymaxpwr_1_1;?>],
    datasets: [
	  {
        label               : 'Gain Measured ',
		     backgroundColor     : 'rgba(60,141,188,0.3)',
        borderColor         : 'rgba(60,141,188,1)',
        pointRadius          : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
     	 data                : [<?php echo  $datos_gain_1_1; ?>]
			  
      } ,
	   {
        label               : 'Gain Reference',		
		backgroundColor     : 'rgba(255, 99, 132, 0.5)',
        borderColor         : 'rgba(255, 99, 132, 1)',
        pointRadius         : false,
        pointColor          : 'rgba(255, 99, 132, 1)',
        pointStrokeColor    : '#c1c7d1',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(255, 99, 132, 1)',		
     	 data          :[<?php echo  $datos_gainreachi_1_1_array ; ?>]
      },
    ]
  };
    /* console.log('$datos_gain_0_0');
    console.log( <?php echo  $datos_gain_0_0;?>);

    console.log('$datos_gainreachi_0_0_array');
    console.log( <?php echo  $datos_gainreachi_0_0_array;?>);

    console.log('$freq_gainymaxpwr_0_0');
    console.log(<?php echo  $freq_gainymaxpwr_0_0;?>);
*/
    
var datosgrafilinwality_0_0 = {
    labels  : [<?php echo  $table_lineality_ejex_0_0;?>],
    datasets: [
	  {
        label               : 'uC Pwr Out',
		     backgroundColor     : 'rgba(60,141,188,0.3)',
        borderColor         : 'rgba(60,141,188,1)',
        pointRadius          : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
     	 data                : [<?php echo  $table_lineality_uCPwrForward_0_0;?>]
			  
      },
	   {
        label               : 'SA Mkr Power',		
		backgroundColor     : 'rgba(255, 99, 132, 0.5)',
        borderColor         : 'rgba(255, 99, 132, 1)',
        pointRadius         : false,
        pointColor          : 'rgba(255, 99, 132, 1)',
        pointStrokeColor    : '#c1c7d1',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(255, 99, 132, 1)',		
     	 data          :[<?php echo  $table_lineality_MkrPeakSearch_0_0 ?>]
      },
    ]
  };

  var datosgrafilinwality_0_1 = {
    labels  : [<?php echo  $table_lineality_ejex_0_1;?>],
    datasets: [
	  {
        label               : 'uC Pwr Out',
		     backgroundColor     : 'rgba(60,141,188,0.3)',
        borderColor         : 'rgba(60,141,188,1)',
        pointRadius          : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
     	 data                : [<?php echo  $table_lineality_uCPwrForward_0_1;?>]
			  
      },
	   {
        label               : 'SA Mkr Power',		
		backgroundColor     : 'rgba(255, 99, 132, 0.5)',
        borderColor         : 'rgba(255, 99, 132, 1)',
        pointRadius         : false,
        pointColor          : 'rgba(255, 99, 132, 1)',
        pointStrokeColor    : '#c1c7d1',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(255, 99, 132, 1)',		
     	 data          :[<?php echo  $table_lineality_MkrPeakSearch_0_1 ?>]
      },
    ]
  };

  var datosgrafilinwality_1_0 = {
    labels  : [<?php echo  $table_lineality_ejex_1_0;?>],
    datasets: [
	  {
        label               : 'uC Pwr Out',
		     backgroundColor     : 'rgba(60,141,188,0.3)',
        borderColor         : 'rgba(60,141,188,1)',
        pointRadius          : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
     	 data                : [<?php echo  $table_lineality_uCPwrForward_1_0;?>]
			  
      },
	   {
        label               : 'SA Mkr Power',		
		backgroundColor     : 'rgba(255, 99, 132, 0.5)',
        borderColor         : 'rgba(255, 99, 132, 1)',
        pointRadius         : false,
        pointColor          : 'rgba(255, 99, 132, 1)',
        pointStrokeColor    : '#c1c7d1',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(255, 99, 132, 1)',		
     	 data          :[<?php echo  $table_lineality_MkrPeakSearch_1_0 ?>]
      },
    ]
  };

  var datosgrafilinwality_1_1 = {
    labels  : [<?php echo  $table_lineality_ejex_1_1;?>],
    datasets: [
	  {
        label               : 'uC Pwr Out',
		     backgroundColor     : 'rgba(60,141,188,0.3)',
        borderColor         : 'rgba(60,141,188,1)',
        pointRadius          : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
     	 data                : [<?php echo  $table_lineality_uCPwrForward_1_1;?>]
			  
      },
	   {
        label               : 'SA Mkr Power',		
		backgroundColor     : 'rgba(255, 99, 132, 0.5)',
        borderColor         : 'rgba(255, 99, 132, 1)',
        pointRadius         : false,
        pointColor          : 'rgba(255, 99, 132, 1)',
        pointStrokeColor    : '#c1c7d1',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(255, 99, 132, 1)',		
     	 data          :[<?php echo  $table_lineality_MkrPeakSearch_1_1 ?>]
      },
    ]
  };



  var datosgraficomaxpwe_0_0 = {
    labels  : [<?php echo  $freq_gainymaxpwr_0_0;?>],
    datasets: [
	  {
        label               : 'Pwr Out Measured',
		     backgroundColor     : 'rgba(60,141,188,0.3)',
        borderColor         : 'rgba(60,141,188,1)',
        pointRadius          : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
     	 data                : [<?php echo  $datos_maxpwr_0_0;?>]
			  
      },
	   {
        label               : 'PwrOut Expecting',		
		backgroundColor     : 'rgba(255, 99, 132, 0.5)',
        borderColor         : 'rgba(255, 99, 132, 1)',
        pointRadius         : false,
        pointColor          : 'rgba(255, 99, 132, 1)',
        pointStrokeColor    : '#c1c7d1',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(255, 99, 132, 1)',		
     	 data          :[<?php echo  $pwr_out_exp_band_qq_maxp_0_0_array;?>]
      },
    ]
  };

  var datosgraficomaxpwe_0_1 = {
    labels  : [<?php echo  $freq_gainymaxpwr_0_1;?>],
    datasets: [
	  {
        label               : 'Pwr Out Measured',
		     backgroundColor     : 'rgba(60,141,188,0.3)',
        borderColor         : 'rgba(60,141,188,1)',
        pointRadius          : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
     	 data                : [<?php echo  $datos_maxpwr_0_1;?>]
			  
      },
	   {
        label               : 'PwrOut Expecting',		
		backgroundColor     : 'rgba(255, 99, 132, 0.5)',
        borderColor         : 'rgba(255, 99, 132, 1)',
        pointRadius         : false,
        pointColor          : 'rgba(255, 99, 132, 1)',
        pointStrokeColor    : '#c1c7d1',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(255, 99, 132, 1)',		
     	 data          :[<?php echo  $pwr_out_exp_band_qq_maxp_0_1_array;?>]
      },
    ]
  };


  var datosgraficomaxpwe_1_0 = {
    labels  : [<?php echo  $freq_gainymaxpwr_1_0;?>],
    datasets: [
	  {
        label               : 'Pwr Out Measured ',
		     backgroundColor     : 'rgba(60,141,188,0.3)',
        borderColor         : 'rgba(60,141,188,1)',
        pointRadius          : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
     	 data                : [<?php echo  $datos_maxpwr_1_0;?>]
			  
      },
	   {
        label               : 'PwrOut Expecting',		
		backgroundColor     : 'rgba(255, 99, 132, 0.5)',
        borderColor         : 'rgba(255, 99, 132, 1)',
        pointRadius         : false,
        pointColor          : 'rgba(255, 99, 132, 1)',
        pointStrokeColor    : '#c1c7d1',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(255, 99, 132, 1)',		
     	 data          :[<?php echo  $pwr_out_exp_band_qq_maxp_0_0_array;?>]
      },
    ]
  };

  var datosgraficomaxpwe_1_1 = {
    labels  : [<?php echo  $freq_gainymaxpwr_1_1;?>],
    datasets: [
	  {
        label               : 'Pwr Out Measured ',
		     backgroundColor     : 'rgba(60,141,188,0.3)',
        borderColor         : 'rgba(60,141,188,1)',
        pointRadius          : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
     	 data                : [<?php echo  $datos_maxpwr_1_1;?>]
			  
      },
	   {
        label               : 'PwrOut Expecting',		
		backgroundColor     : 'rgba(255, 99, 132, 0.5)',
        borderColor         : 'rgba(255, 99, 132, 1)',
        pointRadius         : false,
        pointColor          : 'rgba(255, 99, 132, 1)',
        pointStrokeColor    : '#c1c7d1',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(255, 99, 132, 1)',		
     	 data          :[<?php echo  $pwr_out_exp_band_qq_maxp_1_1_array;?>]
      },
    ]
  };


/////////////////////////////////////////////////////////

  var salesChartOptions = {
    maintainAspectRatio : false,
    responsive : true,	
    legend: {
      display: true
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
		 
        } 
	
	
		
      }]
    }
  }

  var salesChartOptions_maxpwr800 = {
    maintainAspectRatio : false,
    responsive : true,	
    legend: {
      display: true
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
		 
        } ,
		 ticks: {
                   
				    suggestedMin: 33,
                    suggestedMax: 41
               },
			    plugins: {
            zoom: {
                // Container for pan options
                pan: {
                    // Boolean to enable panning
                    enabled: true,

                    // Panning directions. Remove the appropriate direction to disable 
                    // Eg. 'y' would only allow panning in the y direction
                    mode: 'xy'
                },

                // Container for zoom options
                zoom: {
                    // Boolean to enable zooming
                    enabled: true,

                    // Zooming directions. Remove the appropriate direction to disable 
                    // Eg. 'y' would only allow zooming in the y direction
                    mode: 'xy',
                }
            }
        }
	
	
		
      }]
    }
  }

var salesChartOptions_gain700= {
    maintainAspectRatio : false,
    responsive : true,	
    legend: {
      display: true
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
                   
				    suggestedMin: 35,
                    suggestedMax: 41
               },
			    plugins: {
            zoom: {
                // Container for pan options
                pan: {
                    // Boolean to enable panning
                    enabled: true,

                    // Panning directions. Remove the appropriate direction to disable 
                    // Eg. 'y' would only allow panning in the y direction
                    mode: 'xy'
                },

                // Container for zoom options
                zoom: {
                    // Boolean to enable zooming
                    enabled: true,

                    // Zooming directions. Remove the appropriate direction to disable 
                    // Eg. 'y' would only allow zooming in the y direction
                    mode: 'xy',
                }
            }
        }
	
		
      }]
    }
  }


  var salesChartOptions_gain800= {
    maintainAspectRatio : false,
    responsive : true,	
    legend: {
      display: true
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
                   
				    suggestedMin: 34,
                    suggestedMax: 50
               },
			    plugins: {
            zoom: {
                // Container for pan options
                pan: {
                    // Boolean to enable panning
                    enabled: true,

                    // Panning directions. Remove the appropriate direction to disable 
                    // Eg. 'y' would only allow panning in the y direction
                    mode: 'xy'
                },

                // Container for zoom options
                zoom: {
                    // Boolean to enable zooming
                    enabled: true,

                    // Zooming directions. Remove the appropriate direction to disable 
                    // Eg. 'y' would only allow zooming in the y direction
                    mode: 'xy',
                }
            }
        }
	
		
      }]
    }
  }

  var salesChartOptions_maxpwr700 = {
    maintainAspectRatio : false,
    responsive : true,	
    legend: {
      display: true
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
                   
				    suggestedMin: -14,
                    suggestedMax: -7
               },
			    plugins: {
            zoom: {
                // Container for pan options
                pan: {
                    // Boolean to enable panning
                    enabled: true,

                    // Panning directions. Remove the appropriate direction to disable 
                    // Eg. 'y' would only allow panning in the y direction
                    mode: 'xy'
                },

                // Container for zoom options
                zoom: {
                    // Boolean to enable zooming
                    enabled: true,

                    // Zooming directions. Remove the appropriate direction to disable 
                    // Eg. 'y' would only allow zooming in the y direction
                    mode: 'xy',
                }
            }
        }
	
		
      }]
    }
  }

      var salesChart4 = new Chart(grafpower0, { 
      type: 'line', 	
      data: losdatos_lsgp_0_0, 	 
      options: salesChartOptions
    });

    var salesChart5 = new Chart(grafpower1, { 
      type: 'line', 	
      data: losdatos_lsgp_0_1, 	 
      options: salesChartOptions
    });
    var salesChart6 = new Chart(grafpower0a, { 
      type: 'line', 	
      data: losdatos_lsgp_1_0, 	 
      options: salesChartOptions
    });

    var salesChart7 = new Chart(grafpower1a, { 
      type: 'line', 	
      data: losdatos_lsgp_1_1, 	 
      options: salesChartOptions_gain700
    });

    //////////////////////////
    var salesChart8 = new Chart(grafgain0, { 
      type: 'line', 	
      data: datosgraficogain_0_0, 	 
      options: salesChartOptions_gain700
    });

    var salesChart9 = new Chart(grafgain1, { 
      type: 'line', 	
      data: datosgraficogain_0_1, 	 
      options: salesChartOptions_gain800
    });
    var salesChart10 = new Chart(grafgain0a, { 
      type: 'line', 	
      data: datosgraficogain_1_0, 	 
      options: salesChartOptions_gain700
    });

    var salesChart11 = new Chart(grafgain1a, { 
      type: 'line', 	
      data: datosgraficogain_1_1, 	 
      options: salesChartOptions_gain800
    });
    //////////////////////////////////////////////
    var salesChart12 = new Chart(grafmaxpwr0, { 
      type: 'line', 	
      data: datosgraficomaxpwe_0_0, 	 
      options: salesChartOptions_maxpwr700
    });

    var salesChart13 = new Chart(grafmaxpwr0a, { 
      type: 'line', 	
      data: datosgraficomaxpwe_0_1, 	 
      options: salesChartOptions_maxpwr800
    });
    var salesChart14 = new Chart(grafmaxpwr1, { 
      type: 'line', 	
      data: datosgraficomaxpwe_1_0, 	 
      options: salesChartOptions_maxpwr700 
    });

    var salesChart15 = new Chart(grafmaxpwr1a, { 
      type: 'line', 	
      data: datosgraficomaxpwe_1_1, 	 
      options: salesChartOptions_maxpwr800
    });


     /////////////////// LINEALITY ///////////////////////////
     var salesChart12 = new Chart(graflineality0, { 
      type: 'line', 	
      data: datosgrafilinwality_0_0, 	 
      options: salesChartOptions_maxpwr700
    });

    var salesChart13 = new Chart(graflineality1, { 
      type: 'line', 	
      data: datosgrafilinwality_0_1, 	 
      options: salesChartOptions_maxpwr800
    });
    var salesChart14 = new Chart(graflineality2, { 
      type: 'line', 	
      data: datosgrafilinwality_1_0, 	 
      options: salesChartOptions_maxpwr700 
    });

    var salesChart15 = new Chart(graflineality3, { 
      type: 'line', 	
      data: datosgrafilinwality_1_1, 	 
      options: salesChartOptions_maxpwr800
    });

    

   }


   function grafica_puntos()
   {
     
////////////////////////////// GRAF PUNTOS LSGP
///////////////////////////////////////////////////////////////////////
var  lsgp_puntos_graf_despues_0_0 = '<?php echo $lsgp_puntos_graf_despues_0_0;?>';
var  lsgp_puntos_graf_despues_0_1 = '<?php echo $lsgp_puntos_graf_despues_0_1;?>';
var  lsgp_puntos_graf_despues_1_0 = '<?php echo $lsgp_puntos_graf_despues_1_0;?>';
var  lsgp_puntos_graf_despues_1_1 = '<?php echo $lsgp_puntos_graf_despues_1_1;?>';


var  lsgp_puntos_graf_antes_0_0 = '<?php echo $lsgp_puntos_graf_antes_0_0 ;?>';
var  lsgp_puntos_graf_antes_0_1 = '<?php echo $lsgp_puntos_graf_antes_0_1 ;?>';
var  lsgp_puntos_graf_antes_1_0 = '<?php echo $lsgp_puntos_graf_antes_1_0 ;?>';
var  lsgp_puntos_graf_antes_1_1 = '<?php echo $lsgp_puntos_graf_antes_1_1 ;?>';

console.log('sipaso-lsgp_puntos_graf_despues_0_0');
console.log(lsgp_puntos_graf_despues_0_0.split("#"));

const array_lsgp_puntos_graf_despues_0_0  = lsgp_puntos_graf_despues_0_0.split("#");
const array_lsgp_puntos_graf_despues_0_1  = lsgp_puntos_graf_despues_0_1.split("#");
const array_lsgp_puntos_graf_despues_1_0  = lsgp_puntos_graf_despues_1_0.split("#");
const array_lsgp_puntos_graf_despues_1_1  = lsgp_puntos_graf_despues_1_1.split("#");

const array_lsgp_puntos_graf_antes_0_0  = lsgp_puntos_graf_antes_0_0.split("#");
const array_lsgp_puntos_graf_antes_0_1  = lsgp_puntos_graf_antes_0_1.split("#");
const array_lsgp_puntos_graf_antes_1_0  = lsgp_puntos_graf_antes_1_0.split("#");
const array_lsgp_puntos_graf_antes_1_1  = lsgp_puntos_graf_antes_1_1.split("#");


var data_lsgp_puntos_0_0_antes = [];
              data_lsgp_puntos_0_0_antes.push({x: 0, y: array_lsgp_puntos_graf_antes_0_0[1]});
              data_lsgp_puntos_0_0_antes.push({x: 3, y: array_lsgp_puntos_graf_antes_0_0[2]});
              data_lsgp_puntos_0_0_antes.push({x: 6, y: array_lsgp_puntos_graf_antes_0_0[3]});
              data_lsgp_puntos_0_0_antes.push({x: 9, y: array_lsgp_puntos_graf_antes_0_0[4]});
              data_lsgp_puntos_0_0_antes.push({x: 12, y: array_lsgp_puntos_graf_antes_0_0[5]});
              var data_lsgp_puntos_0_0_despues = [];
              data_lsgp_puntos_0_0_despues.push({x: 0, y: array_lsgp_puntos_graf_despues_0_0[1]});
              data_lsgp_puntos_0_0_despues.push({x: 3, y: array_lsgp_puntos_graf_despues_0_0[2]});
              data_lsgp_puntos_0_0_despues.push({x: 6, y: array_lsgp_puntos_graf_despues_0_0[3]});
              data_lsgp_puntos_0_0_despues.push({x: 9, y: array_lsgp_puntos_graf_despues_0_0[4]});
              data_lsgp_puntos_0_0_despues.push({x: 12, y: array_lsgp_puntos_graf_despues_0_0[5]});


              var data_lsgp_puntos_0_1_antes = [];
              data_lsgp_puntos_0_1_antes.push({x: 0, y: array_lsgp_puntos_graf_antes_0_1[1]});
              data_lsgp_puntos_0_1_antes.push({x: 3, y: array_lsgp_puntos_graf_antes_0_1[2]});
              data_lsgp_puntos_0_1_antes.push({x: 6, y: array_lsgp_puntos_graf_antes_0_1[3]});
              data_lsgp_puntos_0_1_antes.push({x: 9, y: array_lsgp_puntos_graf_antes_0_1[4]});
              data_lsgp_puntos_0_1_antes.push({x: 12, y: array_lsgp_puntos_graf_antes_0_1[5]});
              var data_lsgp_puntos_0_1_despues = [];
              data_lsgp_puntos_0_1_despues.push({x: 0, y: array_lsgp_puntos_graf_despues_0_1[1] });
              data_lsgp_puntos_0_1_despues.push({x: 3, y: array_lsgp_puntos_graf_despues_0_1[2] });
              data_lsgp_puntos_0_1_despues.push({x: 6, y:  array_lsgp_puntos_graf_despues_0_1[3] });
              data_lsgp_puntos_0_1_despues.push({x: 9, y: array_lsgp_puntos_graf_despues_0_1[4] });
              data_lsgp_puntos_0_1_despues.push({x: 12, y: array_lsgp_puntos_graf_despues_0_1[5] });

              var data_lsgp_puntos_1_0_antes = [];
              data_lsgp_puntos_1_0_antes.push({x: 0, y: array_lsgp_puntos_graf_antes_1_0[1]});
              data_lsgp_puntos_1_0_antes.push({x: 3, y: array_lsgp_puntos_graf_antes_1_0[2]});
              data_lsgp_puntos_1_0_antes.push({x: 6, y: array_lsgp_puntos_graf_antes_1_0[3]});
              data_lsgp_puntos_1_0_antes.push({x: 9, y: array_lsgp_puntos_graf_antes_1_0[4]});
              data_lsgp_puntos_1_0_antes.push({x: 12, y: array_lsgp_puntos_graf_antes_1_0[5]});
              var data_lsgp_puntos_1_0_despues = [];
              data_lsgp_puntos_1_0_despues.push({x: 0, y: array_lsgp_puntos_graf_despues_1_0[1]});
              data_lsgp_puntos_1_0_despues.push({x: 3, y: array_lsgp_puntos_graf_despues_1_0[2]});
              data_lsgp_puntos_1_0_despues.push({x: 6, y: array_lsgp_puntos_graf_despues_1_0[3]});
              data_lsgp_puntos_1_0_despues.push({x: 9, y: array_lsgp_puntos_graf_despues_1_0[4]});
              data_lsgp_puntos_1_0_despues.push({x: 12, y: array_lsgp_puntos_graf_despues_1_0[5]});

              var data_lsgp_puntos_1_1_antes = [];
              data_lsgp_puntos_1_1_antes.push({x: 0, y: array_lsgp_puntos_graf_antes_1_1[1]});
              data_lsgp_puntos_1_1_antes.push({x: 3, y: array_lsgp_puntos_graf_antes_1_1[2]});
              data_lsgp_puntos_1_1_antes.push({x: 6, y: array_lsgp_puntos_graf_antes_1_1[3]});
              data_lsgp_puntos_1_1_antes.push({x: 9, y: array_lsgp_puntos_graf_antes_1_1[4]});
              data_lsgp_puntos_1_1_antes.push({x: 12, y: array_lsgp_puntos_graf_antes_1_1[5]});
              var data_lsgp_puntos_1_1_despues = [];
              data_lsgp_puntos_1_1_despues.push({x: 0, y: array_lsgp_puntos_graf_despues_1_1[1]});
              data_lsgp_puntos_1_1_despues.push({x: 3, y: array_lsgp_puntos_graf_despues_1_1[2]});
              data_lsgp_puntos_1_1_despues.push({x: 6, y: array_lsgp_puntos_graf_despues_1_1[3]});
              data_lsgp_puntos_1_1_despues.push({x: 9, y: array_lsgp_puntos_graf_despues_1_1[4]});
              data_lsgp_puntos_1_1_despues.push({x: 12, y: array_lsgp_puntos_graf_despues_1_1[5]});



              
              var color = Chart.helpers.color;
					///// 1er grafico puntso LSGP
					var scatterChartData = {
					datasets: [{
						label: 'Default Values',
						borderColor: window.chartColors.blue,
						backgroundColor: color(window.chartColors.blue).alpha(0.2).rgbString(),
						data: data_lsgp_puntos_0_0_antes,
					},{
						label: 'Calibrated Values',
						borderColor: window.chartColors.red,
						backgroundColor: color(window.chartColors.red).alpha(0.2).rgbString(),
						data: data_lsgp_puntos_0_0_despues,
					},
          
          ]
					};
	

					var ctx = document.getElementById('grafagccalib00').getContext('2d');
						window.myScatter = Chart.Scatter(ctx, {
							data: scatterChartData,
							options: {
								title: {
									display: false,
									text: 'After '
								},
							}
						});
					///// FIN 	1er grafico puntso LSGP
          		///// 2er grafico puntso LSGP
					var scatterChartData01 = {
					datasets: [{
						label: 'Default Values',
						borderColor: window.chartColors.blue,
						backgroundColor: color(window.chartColors.blue).alpha(0.2).rgbString(),
						data: data_lsgp_puntos_0_1_antes,
					},{
						label: 'Calibrated Values',
						borderColor: window.chartColors.red,
						backgroundColor: color(window.chartColors.red).alpha(0.2).rgbString(),
						data: data_lsgp_puntos_0_1_despues,
					},
          
          ]
					};
	

					var ctx = document.getElementById('grafagccalib01').getContext('2d');
						window.myScatter = Chart.Scatter(ctx, {
							data: scatterChartData01,
							options: {
								title: {
									display: false,
									text: 'After '
								},
							}
						});
					///// FIN 	2er grafico puntso LSGP
           		///// 3er grafico puntso LSGP
					var scatterChartData10 = {
					datasets: [{
						label: 'Default Values',
						borderColor: window.chartColors.blue,
						backgroundColor: color(window.chartColors.blue).alpha(0.2).rgbString(),
						data: data_lsgp_puntos_1_0_antes,
					},{
						label: 'Calibrated Values',
						borderColor: window.chartColors.red,
						backgroundColor: color(window.chartColors.red).alpha(0.2).rgbString(),
						data: data_lsgp_puntos_1_0_despues,
					},
          
          ]
					};
	

					var ctx = document.getElementById('grafagccalib10').getContext('2d');
						window.myScatter = Chart.Scatter(ctx, {
							data: scatterChartData10,
							options: {
								title: {
									display: false,
									text: 'After '
								},
							}
						});
					///// FIN 	3er grafico puntso LSGP
    		///// 4er grafico puntso LSGP
        var scatterChartData11 = {
					datasets: [{
						label: 'Default Values',
						borderColor: window.chartColors.blue,
						backgroundColor: color(window.chartColors.blue).alpha(0.2).rgbString(),
						data: data_lsgp_puntos_1_1_antes,
					},{
						label: 'Calibrated Values',
						borderColor: window.chartColors.red,
						backgroundColor: color(window.chartColors.red).alpha(0.2).rgbString(),
						data: data_lsgp_puntos_1_1_despues,
					},
          
          ]
					};
	

					var ctx = document.getElementById('grafagccalib11').getContext('2d');
						window.myScatter = Chart.Scatter(ctx, {
							data: scatterChartData11,
							options: {
								title: {
									display: false,
									text: 'After '
								},
							}
						});
					///// FIN 	4er grafico puntso LSGP 
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
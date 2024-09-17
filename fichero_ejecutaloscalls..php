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
					<?php
          /*
              SELECT   concat('call sp_insert_fas_income_integral(',idproduct,',2,''00200701A'',0,11,3,0,100,null,'''','''',null)' ) AS mma 
          FROM fnt_select_allproducts_maxrev() as pproducts
          where iduniquebranchsonprod like '%0001003700390043%'
          union 

               SELECT   concat('call sp_insert_fas_income_integral(',idproduct,',2,''00200701A'',0,11,3,1,100,null,'''','''',null)' ) AS mma 
          FROM fnt_select_allproducts_maxrev() as pproducts
          where iduniquebranchsonprod like '%0001003700390043%'
           union 
              SELECT   concat('call sp_insert_fas_income_integral(',idproduct,',2,''00200701A'',0,12,3,0,500,null,'''','''',null)' ) AS mma 
          FROM fnt_select_allproducts_maxrev() as pproducts
          where iduniquebranchsonprod like '%0001003700390043%'
            union 
           SELECT   concat('call sp_insert_fas_income_integral(',idproduct,',2,''00200701A'',0,12,3,1,600,null,'''','''',null)' ) AS mma 
          FROM fnt_select_allproducts_maxrev() as pproducts
          where iduniquebranchsonprod like '%0001003700390043%'
       
          union 
              SELECT   concat('call sp_insert_fas_income_integral(',idproduct,',2,''00200701A'',0,11,4,0,100,null,'''','''',null)' ) AS mma 
         FROM fnt_select_allproducts_maxrev() as pproducts
         where iduniquebranchsonprod like '%0001003700390043%'
         union
           SELECT   concat('call sp_insert_fas_income_integral(',idproduct,',2,''00200701A'',0,11,4,1,200,null,'''','''',null)' ) AS mma 
         FROM fnt_select_allproducts_maxrev() as pproducts
         where iduniquebranchsonprod like '%0001003700390043%'
         union
            
           SELECT   concat('call sp_insert_fas_income_integral(',idproduct,',2,''00200701A'',0,12,4,0,400,null,'''','''',null)' ) AS mma 
         FROM fnt_select_allproducts_maxrev() as pproducts
         where iduniquebranchsonprod like '%0001003700390043%'
                union
           SELECT   concat('call sp_insert_fas_income_integral(',idproduct,',2,''00200701A'',0,12,4,1,600,null,'''','''',null)' ) AS mma 
         FROM fnt_select_allproducts_maxrev() as pproducts
         where iduniquebranchsonprod like '%0001003700390043%' 
          
         --------------------------DH14
     
    SELECT   concat('call sp_insert_fas_income_integral(',idproduct,',2,''00200701A'',0,11,0,0,200,null,'''','''',null)' ) AS mma 
 
          FROM fnt_select_allproducts_maxrev() as pproducts
           where iduniquebranchsonprod like '%000100370039%' and modelciu like '%DH14%'
           union 
            SELECT   concat('call sp_insert_fas_income_integral(',idproduct,',2,''00200701A'',0,11,0,1,200,null,'''','''',null)' ) 
           FROM fnt_select_allproducts_maxrev() as pproducts
           where iduniquebranchsonprod like '%000100370039%' and modelciu like '%DH14%'
            union 
            SELECT   concat('call sp_insert_fas_income_integral(',idproduct,',2,''00200701A'',0,12,0,0,600,null,'''','''',null)' ) 
           FROM fnt_select_allproducts_maxrev() as pproducts
           where iduniquebranchsonprod like '%000100370039%' and modelciu like '%DH14%'
             union 
            SELECT   concat('call sp_insert_fas_income_integral(',idproduct,',2,''00200701A'',0,12,0,1,600,null,'''','''',null)' ) 
           FROM fnt_select_allproducts_maxrev() as pproducts
           where iduniquebranchsonprod like '%000100370039%' and modelciu like '%DH14%'
            union 
            SELECT   concat('call sp_insert_fas_income_integral(',idproduct,',2,''00200701A'',0,11,8,0,200,null,'''','''',null)' ) 
           FROM fnt_select_allproducts_maxrev() as pproducts
           where iduniquebranchsonprod like '%000100370039%' and modelciu like '%DH14%'
           union
             SELECT   concat('call sp_insert_fas_income_integral(',idproduct,',2,''00200701A'',0,11,8,1,200,null,'''','''',null)' ) 
           FROM fnt_select_allproducts_maxrev() as pproducts
           where iduniquebranchsonprod like '%000100370039%' and modelciu like '%DH14%'
           union
             SELECT   concat('call sp_insert_fas_income_integral(',idproduct,',2,''00200701A'',0,12,8,0,1000,null,'''','''',null)' ) 
           FROM fnt_select_allproducts_maxrev() as pproducts
           where iduniquebranchsonprod like '%000100370039%' and modelciu like '%DH14%'
           union
             SELECT   concat('call sp_insert_fas_income_integral(',idproduct,',2,''00200701A'',0,12,8,1,1100,null,'''','''',null)' ) 
           FROM fnt_select_allproducts_maxrev() as pproducts
           where iduniquebranchsonprod like '%000100370039%'   and modelciu like '%DH14%'

           ----para el idproduct 438 (FIP467) tmb le va esas referencias

             SELECT   concat('call sp_insert_fas_income_integral(',idproduct,',2,''00200701A'',0,11,0,0,200,null,'''','''',null)' ) AS mma 
 
          FROM fnt_select_allproducts_maxrev() as pproducts
           where idproduct = 438 
           union 
            SELECT   concat('call sp_insert_fas_income_integral(',idproduct,',2,''00200701A'',0,11,0,1,200,null,'''','''',null)' ) 
           FROM fnt_select_allproducts_maxrev() as pproducts
           where idproduct = 438 
            union 
            SELECT   concat('call sp_insert_fas_income_integral(',idproduct,',2,''00200701A'',0,12,0,0,600,null,'''','''',null)' ) 
           FROM fnt_select_allproducts_maxrev() as pproducts
           where idproduct = 438 
             union 
            SELECT   concat('call sp_insert_fas_income_integral(',idproduct,',2,''00200701A'',0,12,0,1,600,null,'''','''',null)' ) 
           FROM fnt_select_allproducts_maxrev() as pproducts
           where idproduct = 438 
            union 
            SELECT   concat('call sp_insert_fas_income_integral(',idproduct,',2,''00200701A'',0,11,8,0,200,null,'''','''',null)' ) 
           FROM fnt_select_allproducts_maxrev() as pproducts
           where idproduct = 438 
           union
             SELECT   concat('call sp_insert_fas_income_integral(',idproduct,',2,''00200701A'',0,11,8,1,200,null,'''','''',null)' ) 
           FROM fnt_select_allproducts_maxrev() as pproducts
           where idproduct = 438 
           union
             SELECT   concat('call sp_insert_fas_income_integral(',idproduct,',2,''00200701A'',0,12,8,0,1000,null,'''','''',null)' ) 
           FROM fnt_select_allproducts_maxrev() as pproducts
           where idproduct = 438 
           union
             SELECT   concat('call sp_insert_fas_income_integral(',idproduct,',2,''00200701A'',0,12,8,1,1100,null,'''','''',null)' ) 
           FROM fnt_select_allproducts_maxrev() as pproducts
           where idproduct = 438 
           
          -----idscrpot 27 
           SELECT   concat('call sp_insert_fas_income_integral(',idproduct,',27,''00200701A'',0,11,3,0,100,null,'''','''',null)' ) AS mma 
          FROM fnt_select_allproducts_maxrev() as pproducts
          where  idproduct in (400,401)
          union 

               SELECT   concat('call sp_insert_fas_income_integral(',idproduct,',27,''00200701A'',0,11,3,1,100,null,'''','''',null)' ) AS mma 
          FROM fnt_select_allproducts_maxrev() as pproducts
          where  idproduct in (400,401)
           union 
              SELECT   concat('call sp_insert_fas_income_integral(',idproduct,',27,''00200701A'',0,12,3,0,500,null,'''','''',null)' ) AS mma 
          FROM fnt_select_allproducts_maxrev() as pproducts
          where  idproduct in (400,401)
            union 
           SELECT   concat('call sp_insert_fas_income_integral(',idproduct,',27,''00200701A'',0,12,3,1,600,null,'''','''',null)' ) AS mma 
          FROM fnt_select_allproducts_maxrev() as pproducts
          where  idproduct in (400,401)
       
          union 
              SELECT   concat('call sp_insert_fas_income_integral(',idproduct,',27,''00200701A'',0,11,4,0,100,null,'''','''',null)' ) AS mma 
         FROM fnt_select_allproducts_maxrev() as pproducts
         where  idproduct in (400,401)
         union
           SELECT   concat('call sp_insert_fas_income_integral(',idproduct,',27,''00200701A'',0,11,4,1,200,null,'''','''',null)' ) AS mma 
         FROM fnt_select_allproducts_maxrev() as pproducts
         where  idproduct in (400,401)
         union
            
           SELECT   concat('call sp_insert_fas_income_integral(',idproduct,',27,''00200701A'',0,12,4,0,400,null,'''','''',null)' ) AS mma 
         FROM fnt_select_allproducts_maxrev() as pproducts
         where  idproduct in (400,401)
                union
           SELECT   concat('call sp_insert_fas_income_integral(',idproduct,',27,''00200701A'',0,12,4,1,600,null,'''','''',null)' ) AS mma 
         FROM fnt_select_allproducts_maxrev() as pproducts
         where  idproduct in (400,401)


   ********************************************
   
          SELECT concat('call sp_insert_fas_income_integral_by_idbanuldl(',pproducts.idproduct,',2,''00200701A'',0,11,3,0,100,null,'''','''',null,', fas_tree_product_references.idreference,')' ) AS mma 
          FROM fnt_select_allproducts_maxrev() as pproducts
		  inner join fas_tree_product_references
		  on fas_tree_product_references.idproduct = pproducts.idproduct and 
		 fas_tree_product_references.idscripttype=2 and fas_tree_product_references.iduniquebranch = '00200701A'
		 and fas_tree_product_references.idband = 3 and uldl = 0
          where iduniquebranchsonprod like '%000100370040004900520054%'  
		  
          union 

               SELECT    concat('call sp_insert_fas_income_integral_by_idbanuldl(',pproducts.idproduct,',2,''00200701A'',0,11,3,1,100,null,'''','''',null,', fas_tree_product_references.idreference,')'  ) AS mma 
          FROM fnt_select_allproducts_maxrev() as pproducts
		   inner join fas_tree_product_references
		  on fas_tree_product_references.idproduct = pproducts.idproduct and 
		 fas_tree_product_references.idscripttype=2 and fas_tree_product_references.iduniquebranch = '00200701A'
		 and fas_tree_product_references.idband = 3 and uldl = 1
          where iduniquebranchsonprod like '%000100370040004900520054%'  
 
           union 
              SELECT   concat('call sp_insert_fas_income_integral_by_idbanuldl(',pproducts.idproduct,',2,''00200701A'',0,12,3,0,500,null,'''','''',null,', fas_tree_product_references.idreference,')'  ) AS mma 
          FROM fnt_select_allproducts_maxrev() as pproducts
        inner join fas_tree_product_references
		  on fas_tree_product_references.idproduct = pproducts.idproduct and 
		 fas_tree_product_references.idscripttype=2 and fas_tree_product_references.iduniquebranch = '00200701A'
		 and fas_tree_product_references.idband = 3 and uldl = 0
          where iduniquebranchsonprod like '%000100370040004900520054%'  
		  
            union 
           SELECT   concat('call sp_insert_fas_income_integral_by_idbanuldl(',pproducts.idproduct,',2,''00200701A'',0,12,3,1,600,null,'''','''',null,', fas_tree_product_references.idreference,')'  ) AS mma 
          FROM fnt_select_allproducts_maxrev() as pproducts
           inner join fas_tree_product_references
		  on fas_tree_product_references.idproduct = pproducts.idproduct and 
		 fas_tree_product_references.idscripttype=2 and fas_tree_product_references.iduniquebranch = '00200701A'
		 and fas_tree_product_references.idband = 3 and uldl = 1
          where iduniquebranchsonprod like '%000100370040004900520054%'  
       
          union 
              SELECT   concat('call sp_insert_fas_income_integral_by_idbanuldl(',pproducts.idproduct,',2,''00200701A'',0,11,4,0,100,null,'''','''',null,', fas_tree_product_references.idreference,')'  ) AS mma 
         FROM fnt_select_allproducts_maxrev() as pproducts
           inner join fas_tree_product_references
		  on fas_tree_product_references.idproduct = pproducts.idproduct and 
		 fas_tree_product_references.idscripttype=2 and fas_tree_product_references.iduniquebranch = '00200701A'
		 and fas_tree_product_references.idband = 4 and uldl = 0
          where iduniquebranchsonprod like '%000100370040004900520054%'  
      
	  union
           SELECT   concat('call sp_insert_fas_income_integral_by_idbanuldl(',pproducts.idproduct,',2,''00200701A'',0,11,4,1,200,null,'''','''',null,', fas_tree_product_references.idreference,')'  ) AS mma 
         FROM fnt_select_allproducts_maxrev() as pproducts
         inner join fas_tree_product_references
		  on fas_tree_product_references.idproduct = pproducts.idproduct and 
		 fas_tree_product_references.idscripttype=2 and fas_tree_product_references.iduniquebranch = '00200701A'
		 and fas_tree_product_references.idband = 4 and uldl =1
          where iduniquebranchsonprod like '%000100370040004900520054%'   
         union
            
           SELECT   concat('call sp_insert_fas_income_integral_by_idbanuldl(',pproducts.idproduct,',2,''00200701A'',0,12,4,0,400,null,'''','''',null,', fas_tree_product_references.idreference,')'  ) AS mma 
         FROM fnt_select_allproducts_maxrev() as pproducts
          inner join fas_tree_product_references
		  on fas_tree_product_references.idproduct = pproducts.idproduct and 
		 fas_tree_product_references.idscripttype=2 and fas_tree_product_references.iduniquebranch = '00200701A'
		 and fas_tree_product_references.idband = 4 and uldl = 0
          where iduniquebranchsonprod like '%000100370040004900520054%'  
                union
           SELECT   concat('call sp_insert_fas_income_integral_by_idbanuldl(',pproducts.idproduct,',2,''00200701A'',0,12,4,1,600,null,'''','''',null,', fas_tree_product_references.idreference,')'  ) AS mma 
         FROM fnt_select_allproducts_maxrev() as pproducts
            inner join fas_tree_product_references
		  on fas_tree_product_references.idproduct = pproducts.idproduct and 
		 fas_tree_product_references.idscripttype=2 and fas_tree_product_references.iduniquebranch = '00200701A'
		 and fas_tree_product_references.idband = 4 and uldl =1
          where iduniquebranchsonprod like '%000100370040004900520054%'  
      
          
	
	******* DAS ENTERPRISE MASTER 700-800 ****
       select 
 concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',0,13,null,',reference1,','''','''',null,',lsodatos.idreference,')' ) AS mma 
from
(
select distinct  modelciu , fas_script_type.scriptname, fas_routines_process.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
 
from fas_routines_process
inner join fas_routines_steps
on fas_routines_steps.idstep = fas_routines_process.idstep
inner join products
on products.idproduct = fas_routines_process.idproduct
inner join fas_script_type
on fas_script_type.idscripttype = fas_routines_process.idscript
inner join fas_step
on fas_step.instance = fas_routines_steps.instance
 
where
modelciu LIKE '%BTTY%'  and modelciu not in('BTTY-100100','BTTY-100','GWBDA-BTTY-100100')
 
) as lsodatos
inner join fas_tree_product_references
on  fas_tree_product_references.idreference = lsodatos.idreference::integer
where fas_stepname = 'AcceptBBU_Check_PwrSourceVoltage'
union
select 
 concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',0,21,null,',reference2,','''','''',null,',lsodatos.idreference,')' ) AS mma 
from
(
select distinct  modelciu , fas_script_type.scriptname, fas_routines_process.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
 
from fas_routines_process
inner join fas_routines_steps
on fas_routines_steps.idstep = fas_routines_process.idstep
inner join products
on products.idproduct = fas_routines_process.idproduct
inner join fas_script_type
on fas_script_type.idscripttype = fas_routines_process.idscript
inner join fas_step
on fas_step.instance = fas_routines_steps.instance
 
where
modelciu LIKE '%BTTY%'  and modelciu not in('BTTY-100100','BTTY-100','GWBDA-BTTY-100100')
 
) as lsodatos
inner join fas_tree_product_references
on  fas_tree_product_references.idreference = lsodatos.idreference::integer
where fas_stepname = 'AcceptBBU_Check_PwrSourceVoltage'
union
select 
 concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',0,17,null,',reference1,','''','''',null,',lsodatos.idreference,')' ) AS mma 
from
(
select distinct  modelciu , fas_script_type.scriptname, fas_routines_process.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
 
from fas_routines_process
inner join fas_routines_steps
on fas_routines_steps.idstep = fas_routines_process.idstep
inner join products
on products.idproduct = fas_routines_process.idproduct
inner join fas_script_type
on fas_script_type.idscripttype = fas_routines_process.idscript
inner join fas_step
on fas_step.instance = fas_routines_steps.instance
 
where
modelciu LIKE '%BTTY%'  and modelciu not in('BTTY-100100','BTTY-100','GWBDA-BTTY-100100')
 
) as lsodatos
inner join fas_tree_product_references
on  fas_tree_product_references.idreference = lsodatos.idreference::integer
where fas_stepname = 'AcceptBBU_Check_Current'
union
select 
 concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',0,21,null,',reference2,','''','''',null,',lsodatos.idreference,')' ) AS mma 
from
(
select distinct  modelciu , fas_script_type.scriptname, fas_routines_process.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
 
from fas_routines_process
inner join fas_routines_steps
on fas_routines_steps.idstep = fas_routines_process.idstep
inner join products
on products.idproduct = fas_routines_process.idproduct
inner join fas_script_type
on fas_script_type.idscripttype = fas_routines_process.idscript
inner join fas_step
on fas_step.instance = fas_routines_steps.instance
 
where
modelciu LIKE '%BTTY%'   and modelciu not in('BTTY-100100','BTTY-100','GWBDA-BTTY-100100')
 
) as lsodatos
inner join fas_tree_product_references
on  fas_tree_product_references.idreference = lsodatos.idreference::integer
where fas_stepname = 'AcceptBBU_Check_Current'



union
select 
 concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',0,23,null,',reference1,','''','''',null,',lsodatos.idreference,')' ) AS mma 
from
(
select distinct  modelciu , fas_script_type.scriptname, fas_routines_process.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
 
from fas_routines_process
inner join fas_routines_steps
on fas_routines_steps.idstep = fas_routines_process.idstep
inner join products
on products.idproduct = fas_routines_process.idproduct
inner join fas_script_type
on fas_script_type.idscripttype = fas_routines_process.idscript
inner join fas_step
on fas_step.instance = fas_routines_steps.instance
 
where
modelciu LIKE '%BTTY%'  and modelciu not in('BTTY-100100','BTTY-100','GWBDA-BTTY-100100')
 
) as lsodatos
inner join fas_tree_product_references
on  fas_tree_product_references.idreference = lsodatos.idreference::integer
where fas_stepname = 'AcceptBBU_Check_Voltage'


union
select 
 concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',0,13,null,',reference2,','''','''',null,',lsodatos.idreference,')' ) AS mma 
from
(
select distinct  modelciu , fas_script_type.scriptname, fas_routines_process.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
 
from fas_routines_process
inner join fas_routines_steps
on fas_routines_steps.idstep = fas_routines_process.idstep
inner join products
on products.idproduct = fas_routines_process.idproduct
inner join fas_script_type
on fas_script_type.idscripttype = fas_routines_process.idscript
inner join fas_step
on fas_step.instance = fas_routines_steps.instance
 
where
modelciu LIKE '%BTTY%' and modelciu not in('BTTY-100100','BTTY-100','GWBDA-BTTY-100100')
 
) as lsodatos
inner join fas_tree_product_references
on  fas_tree_product_references.idreference = lsodatos.idreference::integer
where fas_stepname = 'AcceptBBU_Check_Voltage'


union
select 
 concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',0,21,null,',reference3,','''','''',null,',lsodatos.idreference,')' ) AS mma 
from
(
select distinct  modelciu , fas_script_type.scriptname, fas_routines_process.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
 
from fas_routines_process
inner join fas_routines_steps
on fas_routines_steps.idstep = fas_routines_process.idstep
inner join products
on products.idproduct = fas_routines_process.idproduct
inner join fas_script_type
on fas_script_type.idscripttype = fas_routines_process.idscript
inner join fas_step
on fas_step.instance = fas_routines_steps.instance
 
where
modelciu LIKE '%BTTY%'  and modelciu not in('BTTY-100100','BTTY-100','GWBDA-BTTY-100100')
 
) as lsodatos
inner join fas_tree_product_references
on  fas_tree_product_references.idreference = lsodatos.idreference::integer
where fas_stepname = 'AcceptBBU_Check_Voltage'

union
select 
 concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',0,16,null,',reference4,','''','''',null,',lsodatos.idreference,')' ) AS mma 
from
(
select distinct  modelciu , fas_script_type.scriptname, fas_routines_process.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
 
from fas_routines_process
inner join fas_routines_steps
on fas_routines_steps.idstep = fas_routines_process.idstep
inner join products
on products.idproduct = fas_routines_process.idproduct
inner join fas_script_type
on fas_script_type.idscripttype = fas_routines_process.idscript
inner join fas_step
on fas_step.instance = fas_routines_steps.instance
 
where
modelciu LIKE '%BTTY%'  and modelciu not in('BTTY-100100','BTTY-100','GWBDA-BTTY-100100')
 
) as lsodatos
inner join fas_tree_product_references
on  fas_tree_product_references.idreference = lsodatos.idreference::integer
where fas_stepname = 'AcceptBBU_Check_Voltage'

union
select 
 concat('call   (',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',0,16,null,',reference1,','''','''',null,',lsodatos.idreference,')' ) AS mma 
from
(
select distinct  modelciu , fas_script_type.scriptname, fas_routines_process.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
 
from fas_routines_process
inner join fas_routines_steps
on fas_routines_steps.idstep = fas_routines_process.idstep
inner join products
on products.idproduct = fas_routines_process.idproduct
inner join fas_script_type
on fas_script_type.idscripttype = fas_routines_process.idscript
inner join fas_step
on fas_step.instance = fas_routines_steps.instance
 
where
modelciu LIKE '%BTTY%'  and modelciu not in('BTTY-100100','BTTY-100','GWBDA-BTTY-100100')
 
) as lsodatos
inner join fas_tree_product_references
on  fas_tree_product_references.idreference = lsodatos.idreference::integer
where fas_stepname in('AcceptBBU_Check_Alarm_BDA_OFF','AcceptBBU_Check_Alarm_SystemComponentsFail_OFF','AcceptBBU_Check_Alarm_AC_OFF','AcceptBBU_Check_Alarm_AC_ON','AcceptBBU_Check_Alarm_FirePanel_ON','AcceptBBU_Check_Alarm_BatteryCapacity_ON','AcceptBBU_Check_Alarm_SystemComponentsFail_ON','AcceptBBU_Check_Alarm_BDA_ON','AcceptBBU_Check_Alarm_FirePanel_OFF','AcceptBBU_Check_Alarm_BatteryCapacity_OFF' ) 

**************************************************************
**** PCS MASTER 700-800
   SELECT   concat('call sp_insert_fas_income_integral(',pproducts.idproduct,',2,''00200701A'',0,11,3,0,100,null,'''','''',null,', fas_tree_product_references.idreference,')' ) AS mma 
          FROM fnt_select_allproducts_maxrev() as pproducts
		  inner join fas_tree_product_references
		  on fas_tree_product_references.idproduct = pproducts.idproduct and 
		 fas_tree_product_references.idscripttype=2 and fas_tree_product_references.iduniquebranch = '00200701A'
		 and fas_tree_product_references.idband = 3 and uldl = 0
          where iduniquebranchsonprod like '%0001003700400048%'  
		  
         
           union 
              SELECT   concat('call sp_insert_fas_income_integral(',pproducts.idproduct,',2,''00200701A'',0,12,3,0,500,null,'''','''',null', fas_tree_product_references.idreference,')'  ) AS mma 
          FROM fnt_select_allproducts_maxrev() as pproducts
        inner join fas_tree_product_references
		  on fas_tree_product_references.idproduct = pproducts.idproduct and 
		 fas_tree_product_references.idscripttype=2 and fas_tree_product_references.iduniquebranch = '00200701A'
		 and fas_tree_product_references.idband = 3 and uldl = 0
          where iduniquebranchsonprod like '%0001003700400048%'  
		  
           
       
          union 
              SELECT   concat('call sp_insert_fas_income_integral(',pproducts.idproduct,',2,''00200701A'',0,11,4,0,100,null,'''','''',null', fas_tree_product_references.idreference,')'  ) AS mma 
         FROM fnt_select_allproducts_maxrev() as pproducts
           inner join fas_tree_product_references
		  on fas_tree_product_references.idproduct = pproducts.idproduct and 
		 fas_tree_product_references.idscripttype=2 and fas_tree_product_references.iduniquebranch = '00200701A'
		 and fas_tree_product_references.idband = 4 and uldl = 0
          where iduniquebranchsonprod like '%0001003700400048%'  
      
  
         union
            
           SELECT   concat('call sp_insert_fas_income_integral(',pproducts.idproduct,',2,''00200701A'',0,12,4,0,400,null,'''','''',null', fas_tree_product_references.idreference,')'  ) AS mma 
	   FROM fnt_select_allproducts_maxrev() as pproducts
          inner join fas_tree_product_references
		  on fas_tree_product_references.idproduct = pproducts.idproduct and 
		 fas_tree_product_references.idscripttype=2 and fas_tree_product_references.iduniquebranch = '00200701A'
		 and fas_tree_product_references.idband = 4 and uldl = 0
          where iduniquebranchsonprod like '%0001003700400048%'  
.***********************************************************
***** PCS MASTER  VHF- UHF
    	
            SELECT   concat('call sp_insert_fas_income_integral_by_idbanuldl(',pproducts.idproduct,',2,''00200701A'',0,11,3,0,100,null,'''','''',null,', fas_tree_product_references.idreference,')' ) AS mma 
            FROM fnt_select_allproducts_maxrev() as pproducts
        inner join fas_tree_product_references
        on fas_tree_product_references.idproduct = pproducts.idproduct and 
      fas_tree_product_references.idscripttype=2 and fas_tree_product_references.iduniquebranch = '00200701A'
      and fas_tree_product_references.idband = 0 and uldl = 0
            where iduniquebranchsonprod like '%00010037004000480050%'  
        
          
            union 
                SELECT   concat('call sp_insert_fas_income_integral_by_idbanuldl(',pproducts.idproduct,',2,''00200701A'',0,12,3,0,500,null,'''','''',null,  ', fas_tree_product_references.idreference,')'  ) AS mma 
            FROM fnt_select_allproducts_maxrev() as pproducts
          inner join fas_tree_product_references
        on fas_tree_product_references.idproduct = pproducts.idproduct and 
      fas_tree_product_references.idscripttype=2 and fas_tree_product_references.iduniquebranch = '00200701A'
      and fas_tree_product_references.idband = 0 and uldl = 0
            where iduniquebranchsonprod like '%00010037004000480050%'  
        
            
        
            union 
                SELECT   concat('call sp_insert_fas_income_integral_by_idbanuldl(',pproducts.idproduct,',2,''00200701A'',0,11,4,0,100,null,'''','''',null,', fas_tree_product_references.idreference,')'  ) AS mma 
          FROM fnt_select_allproducts_maxrev() as pproducts
            inner join fas_tree_product_references
        on fas_tree_product_references.idproduct = pproducts.idproduct and 
      fas_tree_product_references.idscripttype=2 and fas_tree_product_references.iduniquebranch = '00200701A'
      and fas_tree_product_references.idband = 8 and uldl = 0
            where iduniquebranchsonprod like '%00010037004000480050%'  
        
    
          union
              
            SELECT   concat('call sp_insert_fas_income_integral_by_idbanuldl(',pproducts.idproduct,',2,''00200701A'',0,12,4,0,400,null,'''','''',null,', fas_tree_product_references.idreference,')'  ) AS mma 
      FROM fnt_select_allproducts_maxrev() as pproducts
            inner join fas_tree_product_references
        on fas_tree_product_references.idproduct = pproducts.idproduct and 
      fas_tree_product_references.idscripttype=2 and fas_tree_product_references.iduniquebranch = '00200701A'
      and fas_tree_product_references.idband = 8 and uldl = 0
            where iduniquebranchsonprod like '%00010037004000480050%'  
      
********************************************************
***** PCS REMOTE todas las bandas
       SELECT   concat('call sp_insert_fas_income_integral_by_idbanuldl(',pproducts.idproduct,',2,''00200701A'',0,11,3,1,100,null,'''','''',null,', fas_tree_product_references.idreference,')' ) AS mma 
         
          FROM fnt_select_allproducts_maxrev() as pproducts
       inner join fas_tree_product_references
       on fas_tree_product_references.idproduct = pproducts.idproduct and 
     fas_tree_product_references.idscripttype=2 and fas_tree_product_references.iduniquebranch = '00200701A'
     and fas_tree_product_references.idband = 3  
           where iduniquebranchsonprod like '%00010037004000480051%'  
     and pproducts.idproduct not in (select idproduct from products_attributes where   idattribute = 2)
       
         union 

              SELECT   concat('call sp_insert_fas_income_integral_by_idbanuldl(',pproducts.idproduct,',2,''00200701A'',0,11,0,1,200,null,'''','''',null,', fas_tree_product_references.idreference,')' ) AS mma 
        
         FROM fnt_select_allproducts_maxrev() as pproducts
       inner join fas_tree_product_references
       on fas_tree_product_references.idproduct = pproducts.idproduct and 
     fas_tree_product_references.idscripttype=2 and fas_tree_product_references.iduniquebranch = '00200701A'
     and fas_tree_product_references.idband = 0  
           where iduniquebranchsonprod like '%000100010037004000480051%'  
     and pproducts.idproduct not in (select idproduct from products_attributes where   idattribute = 2)
       
          union 
             SELECT   concat('call sp_insert_fas_income_integral_by_idbanuldl(',pproducts.idproduct,',2,''00200701A'',0,12,3,0,600,null,'''','''',null,', fas_tree_product_references.idreference,')' ) AS mma 
        
          FROM fnt_select_allproducts_maxrev() as pproducts
       inner join fas_tree_product_references
       on fas_tree_product_references.idproduct = pproducts.idproduct and 
     fas_tree_product_references.idscripttype=2 and fas_tree_product_references.iduniquebranch = '00200701A'
     and fas_tree_product_references.idband = 3  
           where iduniquebranchsonprod like '%000100010037004000480051%'  
     and pproducts.idproduct not in (select idproduct from products_attributes where   idattribute = 2)
       
           union 
          SELECT   concat('call sp_insert_fas_income_integral_by_idbanuldl(',pproducts.idproduct,',2,''00200701A'',0,12,0,1,600,null,'''','''',null,', fas_tree_product_references.idreference,')' ) AS mma 
        
           FROM fnt_select_allproducts_maxrev() as pproducts
       inner join fas_tree_product_references
       on fas_tree_product_references.idproduct = pproducts.idproduct and 
     fas_tree_product_references.idscripttype=2 and fas_tree_product_references.iduniquebranch = '00200701A'
     and fas_tree_product_references.idband = 0  
           where iduniquebranchsonprod like '%000100010037004000480051%'  
     and pproducts.idproduct not in (select idproduct from products_attributes where   idattribute = 2)
       
      
         union 
             SELECT   concat('call sp_insert_fas_income_integral_by_idbanuldl(',pproducts.idproduct,',2,''00200701A'',0,11,4,1,200,null,'''','''',null,', fas_tree_product_references.idreference,')' ) AS mma 
        
          FROM fnt_select_allproducts_maxrev() as pproducts
       inner join fas_tree_product_references
       on fas_tree_product_references.idproduct = pproducts.idproduct and 
     fas_tree_product_references.idscripttype=2 and fas_tree_product_references.iduniquebranch = '00200701A'
     and fas_tree_product_references.idband = 4  
           where iduniquebranchsonprod like '%000100010037004000480051%'  
     and pproducts.idproduct not in (select idproduct from products_attributes where   idattribute = 2)
       
        union
          SELECT   concat('call sp_insert_fas_income_integral_by_idbanuldl(',pproducts.idproduct,',2,''00200701A'',0,11,8,1,200,null,'''','''',null,', fas_tree_product_references.idreference,')' ) AS mma 
        
          FROM fnt_select_allproducts_maxrev() as pproducts
       inner join fas_tree_product_references
       on fas_tree_product_references.idproduct = pproducts.idproduct and 
     fas_tree_product_references.idscripttype=2 and fas_tree_product_references.iduniquebranch = '00200701A'
     and fas_tree_product_references.idband = 8  
           where iduniquebranchsonprod like '%000100010037004000480051%'  
     and pproducts.idproduct not in (select idproduct from products_attributes where   idattribute = 2)
       
        union
           
          SELECT   concat('call sp_insert_fas_income_integral_by_idbanuldl(',pproducts.idproduct,',2,''00200701A'',0,12,4,1,600,null,'''','''',null,', fas_tree_product_references.idreference,')' ) AS mma 
        
          FROM fnt_select_allproducts_maxrev() as pproducts
       inner join fas_tree_product_references
       on fas_tree_product_references.idproduct = pproducts.idproduct and 
     fas_tree_product_references.idscripttype=2 and fas_tree_product_references.iduniquebranch = '00200701A'
     and fas_tree_product_references.idband = 4  
           where iduniquebranchsonprod like '%000100010037004000480051%'  
     and pproducts.idproduct not in (select idproduct from products_attributes where   idattribute = 2)
       
               union
          SELECT   concat('call sp_insert_fas_income_integral_by_idbanuldl(',pproducts.idproduct,',2,''00200701A'',0,12,8,1,1100,null,'''','''',null,', fas_tree_product_references.idreference,')' ) AS mma 
        
          FROM fnt_select_allproducts_maxrev() as pproducts
       inner join fas_tree_product_references
       on fas_tree_product_references.idproduct = pproducts.idproduct and 
     fas_tree_product_references.idscripttype=2 and fas_tree_product_references.iduniquebranch = '00200701A'
     and fas_tree_product_references.idband = 8  
           where iduniquebranchsonprod like '%000100010037004000480051%'  
       and pproducts.idproduct not in (select idproduct from products_attributes where   idattribute = 2)
    
		 
*******************************************************
****btty*****
  
 select modelciu,
 concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,11,null,',relay1,','''','''',null,',lsodatos.idrelays,')' ) AS mma 
from
(
select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
 
from fas_routines_process
inner join fas_routines_steps
on fas_routines_steps.idstep = fas_routines_process.idstep
inner join products
on products.idproduct = fas_routines_process.idproduct
inner join fas_script_type
on fas_script_type.idscripttype = fas_routines_process.idscript 
inner join fas_step
on fas_step.instance = fas_routines_steps.instance
  inner join fas_tree_product_references
       on fas_tree_product_references.idproduct = products.idproduct 
	   inner join fas_autotest_states
	   on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
	   fas_autotest_states.idband			=	fas_tree_product_references.idband and
	   fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
	   fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
	   fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
 
where
modelciu LIKE '%BTTY%'   
 
) as lsodatos
inner join fas_tree_product_references
on  fas_tree_product_references.idreference = lsodatos.idreference::integer
where fas_stepname = 'AcceptBBU_Check_PwrSourceVoltage'
-------------------------relay1
union 
  
 select modelciu,
 concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,12,null,',relay2 	,','''','''',null,',lsodatos.idrelays,')' ) AS mma 
from
(
select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
 
from fas_routines_process
inner join fas_routines_steps
on fas_routines_steps.idstep = fas_routines_process.idstep
inner join products
on products.idproduct = fas_routines_process.idproduct
inner join fas_script_type
on fas_script_type.idscripttype = fas_routines_process.idscript
inner join fas_step
on fas_step.instance = fas_routines_steps.instance
  inner join fas_tree_product_references
       on fas_tree_product_references.idproduct = products.idproduct 
	   inner join fas_autotest_states
	   on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
	   fas_autotest_states.idband			=	fas_tree_product_references.idband and
	   fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
	   fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
	   fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
 
where
modelciu LIKE '%BTTY%'   
 
) as lsodatos
inner join fas_tree_product_references
on  fas_tree_product_references.idreference = lsodatos.idreference::integer
where fas_stepname = 'AcceptBBU_Check_PwrSourceVoltage'
-------------------------relay2
union 
  
 select modelciu,
 concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,13,null,',relay3 	,','''','''',null,',lsodatos.idrelays,')' ) AS mma 
from
(
select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
 
from fas_routines_process
inner join fas_routines_steps
on fas_routines_steps.idstep = fas_routines_process.idstep
inner join products
on products.idproduct = fas_routines_process.idproduct
inner join fas_script_type
on fas_script_type.idscripttype = fas_routines_process.idscript
inner join fas_step
on fas_step.instance = fas_routines_steps.instance
  inner join fas_tree_product_references
       on fas_tree_product_references.idproduct = products.idproduct 
	   inner join fas_autotest_states
	   on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
	   fas_autotest_states.idband			=	fas_tree_product_references.idband and
	   fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
	   fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
	   fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
 
where
modelciu LIKE '%BTTY%'   
 
) as lsodatos
inner join fas_tree_product_references
on  fas_tree_product_references.idreference = lsodatos.idreference::integer
where fas_stepname = 'AcceptBBU_Check_PwrSourceVoltage'
-------------------------relay3
union 
  
 select modelciu,
 concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,14,null,',relay4 	,','''','''',null,',lsodatos.idrelays,')' ) AS mma 
from
(
select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
 
from fas_routines_process
inner join fas_routines_steps
on fas_routines_steps.idstep = fas_routines_process.idstep
inner join products
on products.idproduct = fas_routines_process.idproduct
inner join fas_script_type
on fas_script_type.idscripttype = fas_routines_process.idscript
inner join fas_step
on fas_step.instance = fas_routines_steps.instance
  inner join fas_tree_product_references
       on fas_tree_product_references.idproduct = products.idproduct 
	   inner join fas_autotest_states
	   on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
	   fas_autotest_states.idband			=	fas_tree_product_references.idband and
	   fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
	   fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
	   fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
 
where
modelciu LIKE '%BTTY%'   
 
) as lsodatos
inner join fas_tree_product_references
on  fas_tree_product_references.idreference = lsodatos.idreference::integer
where fas_stepname = 'AcceptBBU_Check_PwrSourceVoltage'
-------------------------relay4
union 
  
 select modelciu,
 concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,15,null,',relay5 	,','''','''',null,',lsodatos.idrelays,')' ) AS mma 
from
(
select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
 
from fas_routines_process
inner join fas_routines_steps
on fas_routines_steps.idstep = fas_routines_process.idstep
inner join products
on products.idproduct = fas_routines_process.idproduct
inner join fas_script_type
on fas_script_type.idscripttype = fas_routines_process.idscript
inner join fas_step
on fas_step.instance = fas_routines_steps.instance
  inner join fas_tree_product_references
       on fas_tree_product_references.idproduct = products.idproduct 
	   inner join fas_autotest_states
	   on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
	   fas_autotest_states.idband			=	fas_tree_product_references.idband and
	   fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
	   fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
	   fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
 
where
modelciu LIKE '%BTTY%'   
 
) as lsodatos
inner join fas_tree_product_references
on  fas_tree_product_references.idreference = lsodatos.idreference::integer
where fas_stepname = 'AcceptBBU_Check_PwrSourceVoltage'
-------------------------relay4
union 
  
 select modelciu,
 concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,16,null,',relay6 	,','''','''',null,',lsodatos.idrelays,')' ) AS mma 
from
(
select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
 
from fas_routines_process
inner join fas_routines_steps
on fas_routines_steps.idstep = fas_routines_process.idstep
inner join products
on products.idproduct = fas_routines_process.idproduct
inner join fas_script_type
on fas_script_type.idscripttype = fas_routines_process.idscript
inner join fas_step
on fas_step.instance = fas_routines_steps.instance
  inner join fas_tree_product_references
       on fas_tree_product_references.idproduct = products.idproduct 
	   inner join fas_autotest_states
	   on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
	   fas_autotest_states.idband			=	fas_tree_product_references.idband and
	   fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
	   fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
	   fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
 
where
modelciu LIKE '%BTTY%'   
 
) as lsodatos
inner join fas_tree_product_references
on  fas_tree_product_references.idreference = lsodatos.idreference::integer
where fas_stepname = 'AcceptBBU_Check_PwrSourceVoltage'
-------------------------relay4 - AcceptBBU_Check_PwrSourceVoltage
union 
  
 select modelciu,
 concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,11,null,',relay1,','''','''',null,',lsodatos.idrelays,')' ) AS mma 
from
(
select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
 
from fas_routines_process
inner join fas_routines_steps
on fas_routines_steps.idstep = fas_routines_process.idstep
inner join products
on products.idproduct = fas_routines_process.idproduct
inner join fas_script_type
on fas_script_type.idscripttype = fas_routines_process.idscript
inner join fas_step
on fas_step.instance = fas_routines_steps.instance
  inner join fas_tree_product_references
       on fas_tree_product_references.idproduct = products.idproduct 
	   inner join fas_autotest_states
	   on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
	   fas_autotest_states.idband			=	fas_tree_product_references.idband and
	   fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
	   fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
	   fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
 
where
modelciu LIKE '%BTTY%'   
 
) as lsodatos
inner join fas_tree_product_references
on  fas_tree_product_references.idreference = lsodatos.idreference::integer
where fas_stepname = 'AcceptBBU_Check_Current'
-------------------------relay1
union 
  
 select modelciu,
 concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,12,null,',relay2 	,','''','''',null,',lsodatos.idrelays,')' ) AS mma 
from
(
select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
 
from fas_routines_process
inner join fas_routines_steps
on fas_routines_steps.idstep = fas_routines_process.idstep
inner join products
on products.idproduct = fas_routines_process.idproduct
inner join fas_script_type
on fas_script_type.idscripttype = fas_routines_process.idscript
inner join fas_step
on fas_step.instance = fas_routines_steps.instance
  inner join fas_tree_product_references
       on fas_tree_product_references.idproduct = products.idproduct 
	   inner join fas_autotest_states
	   on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
	   fas_autotest_states.idband			=	fas_tree_product_references.idband and
	   fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
	   fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
	   fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
 
where
modelciu LIKE '%BTTY%'   
 
) as lsodatos
inner join fas_tree_product_references
on  fas_tree_product_references.idreference = lsodatos.idreference::integer
where fas_stepname = 'AcceptBBU_Check_Current'
-------------------------relay2
union 
  
 select modelciu,
 concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,13,null,',relay3 	,','''','''',null,',lsodatos.idrelays,')' ) AS mma 
from
(
select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
 
from fas_routines_process
inner join fas_routines_steps
on fas_routines_steps.idstep = fas_routines_process.idstep
inner join products
on products.idproduct = fas_routines_process.idproduct
inner join fas_script_type
on fas_script_type.idscripttype = fas_routines_process.idscript
inner join fas_step
on fas_step.instance = fas_routines_steps.instance
  inner join fas_tree_product_references
       on fas_tree_product_references.idproduct = products.idproduct 
	   inner join fas_autotest_states
	   on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
	   fas_autotest_states.idband			=	fas_tree_product_references.idband and
	   fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
	   fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
	   fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
 
where
modelciu LIKE '%BTTY%'   
 
) as lsodatos
inner join fas_tree_product_references
on  fas_tree_product_references.idreference = lsodatos.idreference::integer
where fas_stepname = 'AcceptBBU_Check_Current'
-------------------------relay3
union 
  
 select modelciu,
 concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,14,null,',relay4 	,','''','''',null,',lsodatos.idrelays,')' ) AS mma 
from
(
select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
 
from fas_routines_process
inner join fas_routines_steps
on fas_routines_steps.idstep = fas_routines_process.idstep
inner join products
on products.idproduct = fas_routines_process.idproduct
inner join fas_script_type
on fas_script_type.idscripttype = fas_routines_process.idscript
inner join fas_step
on fas_step.instance = fas_routines_steps.instance
  inner join fas_tree_product_references
       on fas_tree_product_references.idproduct = products.idproduct 
	   inner join fas_autotest_states
	   on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
	   fas_autotest_states.idband			=	fas_tree_product_references.idband and
	   fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
	   fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
	   fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
 
where
modelciu LIKE '%BTTY%'   
 
) as lsodatos
inner join fas_tree_product_references
on  fas_tree_product_references.idreference = lsodatos.idreference::integer
where fas_stepname = 'AcceptBBU_Check_Current'
-------------------------relay4
union 
  
 select modelciu,
 concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,15,null,',relay5 	,','''','''',null,',lsodatos.idrelays,')' ) AS mma 
from
(
select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
 
from fas_routines_process
inner join fas_routines_steps
on fas_routines_steps.idstep = fas_routines_process.idstep
inner join products
on products.idproduct = fas_routines_process.idproduct
inner join fas_script_type
on fas_script_type.idscripttype = fas_routines_process.idscript
inner join fas_step
on fas_step.instance = fas_routines_steps.instance
  inner join fas_tree_product_references
       on fas_tree_product_references.idproduct = products.idproduct 
	   inner join fas_autotest_states
	   on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
	   fas_autotest_states.idband			=	fas_tree_product_references.idband and
	   fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
	   fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
	   fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
 
where
modelciu LIKE '%BTTY%'   
 
) as lsodatos
inner join fas_tree_product_references
on  fas_tree_product_references.idreference = lsodatos.idreference::integer
where fas_stepname = 'AcceptBBU_Check_Current'
-------------------------relay4
union 
  
 select modelciu,
 concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,16,null,',relay6 	,','''','''',null,',lsodatos.idrelays,')' ) AS mma 
from
(
select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
 
from fas_routines_process
inner join fas_routines_steps
on fas_routines_steps.idstep = fas_routines_process.idstep
inner join products
on products.idproduct = fas_routines_process.idproduct
inner join fas_script_type
on fas_script_type.idscripttype = fas_routines_process.idscript
inner join fas_step
on fas_step.instance = fas_routines_steps.instance
  inner join fas_tree_product_references
       on fas_tree_product_references.idproduct = products.idproduct 
	   inner join fas_autotest_states
	   on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
	   fas_autotest_states.idband			=	fas_tree_product_references.idband and
	   fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
	   fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
	   fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
 
where
modelciu LIKE '%BTTY%'   
 
) as lsodatos
inner join fas_tree_product_references
on  fas_tree_product_references.idreference = lsodatos.idreference::integer
where fas_stepname = 'AcceptBBU_Check_Current'
-------------------------relay4 - AcceptBBU_Check_Current
union
  
 select modelciu,
 concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,11,null,',relay1,','''','''',null,',lsodatos.idrelays,')' ) AS mma 
from
(
select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
 
from fas_routines_process
inner join fas_routines_steps
on fas_routines_steps.idstep = fas_routines_process.idstep
inner join products
on products.idproduct = fas_routines_process.idproduct
inner join fas_script_type
on fas_script_type.idscripttype = fas_routines_process.idscript
inner join fas_step
on fas_step.instance = fas_routines_steps.instance
  inner join fas_tree_product_references
       on fas_tree_product_references.idproduct = products.idproduct 
	   inner join fas_autotest_states
	   on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
	   fas_autotest_states.idband			=	fas_tree_product_references.idband and
	   fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
	   fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
	   fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
 
where
modelciu LIKE '%BTTY%'   
 
) as lsodatos
inner join fas_tree_product_references
on  fas_tree_product_references.idreference = lsodatos.idreference::integer
where fas_stepname = 'AcceptBBU_Check_Voltage'
-------------------------relay1
union 
  
 select modelciu,
 concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,12,null,',relay2 	,','''','''',null,',lsodatos.idrelays,')' ) AS mma 
from
(
select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
 
from fas_routines_process
inner join fas_routines_steps
on fas_routines_steps.idstep = fas_routines_process.idstep
inner join products
on products.idproduct = fas_routines_process.idproduct
inner join fas_script_type
on fas_script_type.idscripttype = fas_routines_process.idscript
inner join fas_step
on fas_step.instance = fas_routines_steps.instance
  inner join fas_tree_product_references
       on fas_tree_product_references.idproduct = products.idproduct 
	   inner join fas_autotest_states
	   on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
	   fas_autotest_states.idband			=	fas_tree_product_references.idband and
	   fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
	   fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
	   fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
 
where
modelciu LIKE '%BTTY%'   
 
) as lsodatos
inner join fas_tree_product_references
on  fas_tree_product_references.idreference = lsodatos.idreference::integer
where fas_stepname = 'AcceptBBU_Check_Voltage'
-------------------------relay2
union 
  
 select modelciu,
 concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,13,null,',relay3 	,','''','''',null,',lsodatos.idrelays,')' ) AS mma 
from
(
select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
 
from fas_routines_process
inner join fas_routines_steps
on fas_routines_steps.idstep = fas_routines_process.idstep
inner join products
on products.idproduct = fas_routines_process.idproduct
inner join fas_script_type
on fas_script_type.idscripttype = fas_routines_process.idscript
inner join fas_step
on fas_step.instance = fas_routines_steps.instance
  inner join fas_tree_product_references
       on fas_tree_product_references.idproduct = products.idproduct 
	   inner join fas_autotest_states
	   on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
	   fas_autotest_states.idband			=	fas_tree_product_references.idband and
	   fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
	   fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
	   fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
 
where
modelciu LIKE '%BTTY%'   
 
) as lsodatos
inner join fas_tree_product_references
on  fas_tree_product_references.idreference = lsodatos.idreference::integer
where fas_stepname = 'AcceptBBU_Check_Voltage'
-------------------------relay3
union 
  
 select modelciu,
 concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,14,null,',relay4 	,','''','''',null,',lsodatos.idrelays,')' ) AS mma 
from
(
select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
 
from fas_routines_process
inner join fas_routines_steps
on fas_routines_steps.idstep = fas_routines_process.idstep
inner join products
on products.idproduct = fas_routines_process.idproduct
inner join fas_script_type
on fas_script_type.idscripttype = fas_routines_process.idscript
inner join fas_step
on fas_step.instance = fas_routines_steps.instance
  inner join fas_tree_product_references
       on fas_tree_product_references.idproduct = products.idproduct 
	   inner join fas_autotest_states
	   on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
	   fas_autotest_states.idband			=	fas_tree_product_references.idband and
	   fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
	   fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
	   fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
 
where
modelciu LIKE '%BTTY%'   
 
) as lsodatos
inner join fas_tree_product_references
on  fas_tree_product_references.idreference = lsodatos.idreference::integer
where fas_stepname = 'AcceptBBU_Check_Voltage'
-------------------------relay4
union 
  
 select modelciu,
 concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,15,null,',relay5 	,','''','''',null,',lsodatos.idrelays,')' ) AS mma 
from
(
select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
 
from fas_routines_process
inner join fas_routines_steps
on fas_routines_steps.idstep = fas_routines_process.idstep
inner join products
on products.idproduct = fas_routines_process.idproduct
inner join fas_script_type
on fas_script_type.idscripttype = fas_routines_process.idscript
inner join fas_step
on fas_step.instance = fas_routines_steps.instance
  inner join fas_tree_product_references
       on fas_tree_product_references.idproduct = products.idproduct 
	   inner join fas_autotest_states
	   on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
	   fas_autotest_states.idband			=	fas_tree_product_references.idband and
	   fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
	   fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
	   fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
 
where
modelciu LIKE '%BTTY%'   
 
) as lsodatos
inner join fas_tree_product_references
on  fas_tree_product_references.idreference = lsodatos.idreference::integer
where fas_stepname = 'AcceptBBU_Check_Voltage'
-------------------------relay4
union 
  
 select modelciu,
 concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,16,null,',relay6 	,','''','''',null,',lsodatos.idrelays,')' ) AS mma 
from
(
select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
 
from fas_routines_process
inner join fas_routines_steps
on fas_routines_steps.idstep = fas_routines_process.idstep
inner join products
on products.idproduct = fas_routines_process.idproduct
inner join fas_script_type
on fas_script_type.idscripttype = fas_routines_process.idscript
inner join fas_step
on fas_step.instance = fas_routines_steps.instance
  inner join fas_tree_product_references
       on fas_tree_product_references.idproduct = products.idproduct 
	   inner join fas_autotest_states
	   on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
	   fas_autotest_states.idband			=	fas_tree_product_references.idband and
	   fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
	   fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
	   fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
 
where
modelciu LIKE '%BTTY%'   
 
) as lsodatos
inner join fas_tree_product_references
on  fas_tree_product_references.idreference = lsodatos.idreference::integer
where fas_stepname = 'AcceptBBU_Check_Voltage'
-------------------------relay4 - AcceptBBU_Check_Voltage
union 
  
 select modelciu,
 concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,11,null,',relay1,','''','''',null,',lsodatos.idrelays,')' ) AS mma 
from
(
select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
 
from fas_routines_process
inner join fas_routines_steps
on fas_routines_steps.idstep = fas_routines_process.idstep
inner join products
on products.idproduct = fas_routines_process.idproduct
inner join fas_script_type
on fas_script_type.idscripttype = fas_routines_process.idscript
inner join fas_step
on fas_step.instance = fas_routines_steps.instance
  inner join fas_tree_product_references
       on fas_tree_product_references.idproduct = products.idproduct 
	   inner join fas_autotest_states
	   on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
	   fas_autotest_states.idband			=	fas_tree_product_references.idband and
	   fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
	   fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
	   fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
 
where
modelciu LIKE '%BTTY%'   
 
) as lsodatos
inner join fas_tree_product_references
on  fas_tree_product_references.idreference = lsodatos.idreference::integer
where fas_stepname = 'AcceptBBU_Check_Alarm_BDA_OFF'
-------------------------relay1
union 
  
 select modelciu,
 concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,12,null,',relay2 	,','''','''',null,',lsodatos.idrelays,')' ) AS mma 
from
(
select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
 
from fas_routines_process
inner join fas_routines_steps
on fas_routines_steps.idstep = fas_routines_process.idstep
inner join products
on products.idproduct = fas_routines_process.idproduct
inner join fas_script_type
on fas_script_type.idscripttype = fas_routines_process.idscript
inner join fas_step
on fas_step.instance = fas_routines_steps.instance
  inner join fas_tree_product_references
       on fas_tree_product_references.idproduct = products.idproduct 
	   inner join fas_autotest_states
	   on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
	   fas_autotest_states.idband			=	fas_tree_product_references.idband and
	   fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
	   fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
	   fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
 
where
modelciu LIKE '%BTTY%'   
 
) as lsodatos
inner join fas_tree_product_references
on  fas_tree_product_references.idreference = lsodatos.idreference::integer
where fas_stepname = 'AcceptBBU_Check_Alarm_BDA_OFF'
-------------------------relay2
union 
  
 select modelciu,
 concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,13,null,',relay3 	,','''','''',null,',lsodatos.idrelays,')' ) AS mma 
from
(
select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
 
from fas_routines_process
inner join fas_routines_steps
on fas_routines_steps.idstep = fas_routines_process.idstep
inner join products
on products.idproduct = fas_routines_process.idproduct
inner join fas_script_type
on fas_script_type.idscripttype = fas_routines_process.idscript
inner join fas_step
on fas_step.instance = fas_routines_steps.instance
  inner join fas_tree_product_references
       on fas_tree_product_references.idproduct = products.idproduct 
	   inner join fas_autotest_states
	   on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
	   fas_autotest_states.idband			=	fas_tree_product_references.idband and
	   fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
	   fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
	   fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
 
where
modelciu LIKE '%BTTY%'   
 
) as lsodatos
inner join fas_tree_product_references
on  fas_tree_product_references.idreference = lsodatos.idreference::integer
where fas_stepname = 'AcceptBBU_Check_Alarm_BDA_OFF'
-------------------------relay3
union 
  
 select modelciu,
 concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,14,null,',relay4 	,','''','''',null,',lsodatos.idrelays,')' ) AS mma 
from
(
select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
 
from fas_routines_process
inner join fas_routines_steps
on fas_routines_steps.idstep = fas_routines_process.idstep
inner join products
on products.idproduct = fas_routines_process.idproduct
inner join fas_script_type
on fas_script_type.idscripttype = fas_routines_process.idscript
inner join fas_step
on fas_step.instance = fas_routines_steps.instance
  inner join fas_tree_product_references
       on fas_tree_product_references.idproduct = products.idproduct 
	   inner join fas_autotest_states
	   on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
	   fas_autotest_states.idband			=	fas_tree_product_references.idband and
	   fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
	   fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
	   fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
 
where
modelciu LIKE '%BTTY%'   
 
) as lsodatos
inner join fas_tree_product_references
on  fas_tree_product_references.idreference = lsodatos.idreference::integer
where fas_stepname = 'AcceptBBU_Check_Alarm_BDA_OFF'
-------------------------relay4
union 
  
 select modelciu,
 concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,15,null,',relay5 	,','''','''',null,',lsodatos.idrelays,')' ) AS mma 
from
(
select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
 
from fas_routines_process
inner join fas_routines_steps
on fas_routines_steps.idstep = fas_routines_process.idstep
inner join products
on products.idproduct = fas_routines_process.idproduct
inner join fas_script_type
on fas_script_type.idscripttype = fas_routines_process.idscript
inner join fas_step
on fas_step.instance = fas_routines_steps.instance
  inner join fas_tree_product_references
       on fas_tree_product_references.idproduct = products.idproduct 
	   inner join fas_autotest_states
	   on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
	   fas_autotest_states.idband			=	fas_tree_product_references.idband and
	   fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
	   fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
	   fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
 
where
modelciu LIKE '%BTTY%'   
 
) as lsodatos
inner join fas_tree_product_references
on  fas_tree_product_references.idreference = lsodatos.idreference::integer
where fas_stepname = 'AcceptBBU_Check_Alarm_BDA_OFF'
-------------------------relay4
union 
  
 select modelciu,
 concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,16,null,',relay6 	,','''','''',null,',lsodatos.idrelays,')' ) AS mma 
from
(
select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
 
from fas_routines_process
inner join fas_routines_steps
on fas_routines_steps.idstep = fas_routines_process.idstep
inner join products
on products.idproduct = fas_routines_process.idproduct
inner join fas_script_type
on fas_script_type.idscripttype = fas_routines_process.idscript
inner join fas_step
on fas_step.instance = fas_routines_steps.instance
  inner join fas_tree_product_references
       on fas_tree_product_references.idproduct = products.idproduct 
	   inner join fas_autotest_states
	   on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
	   fas_autotest_states.idband			=	fas_tree_product_references.idband and
	   fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
	   fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
	   fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
 
where
modelciu LIKE '%BTTY%'   
 
) as lsodatos
inner join fas_tree_product_references
on  fas_tree_product_references.idreference = lsodatos.idreference::integer
where fas_stepname = 'AcceptBBU_Check_Alarm_BDA_OFF'
-------------------------relay4 - AcceptBBU_Check_Alarm_BDA_OFF
union 
  
 select modelciu,
 concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,11,null,',relay1,','''','''',null,',lsodatos.idrelays,')' ) AS mma 
from
(
select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
 
from fas_routines_process
inner join fas_routines_steps
on fas_routines_steps.idstep = fas_routines_process.idstep
inner join products
on products.idproduct = fas_routines_process.idproduct
inner join fas_script_type
on fas_script_type.idscripttype = fas_routines_process.idscript
inner join fas_step
on fas_step.instance = fas_routines_steps.instance
  inner join fas_tree_product_references
       on fas_tree_product_references.idproduct = products.idproduct 
	   inner join fas_autotest_states
	   on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
	   fas_autotest_states.idband			=	fas_tree_product_references.idband and
	   fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
	   fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
	   fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
 
where
modelciu LIKE '%BTTY%'   
 
) as lsodatos
inner join fas_tree_product_references
on  fas_tree_product_references.idreference = lsodatos.idreference::integer
where fas_stepname in('AcceptBBU_Check_Alarm_BDA_OFF','AcceptBBU_Check_Alarm_SystemComponentsFail_OFF','AcceptBBU_Check_Alarm_AC_OFF','AcceptBBU_Check_Alarm_AC_ON','AcceptBBU_Check_Alarm_FirePanel_ON','AcceptBBU_Check_Alarm_BatteryCapacity_ON','AcceptBBU_Check_Alarm_SystemComponentsFail_ON','AcceptBBU_Check_Alarm_BDA_ON','AcceptBBU_Check_Alarm_FirePanel_OFF','AcceptBBU_Check_Alarm_BatteryCapacity_OFF' ) 
-------------------------relay1
union 
  
 select modelciu,
 concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,12,null,',relay2 	,','''','''',null,',lsodatos.idrelays,')' ) AS mma 
from
(
select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
 
from fas_routines_process
inner join fas_routines_steps
on fas_routines_steps.idstep = fas_routines_process.idstep
inner join products
on products.idproduct = fas_routines_process.idproduct
inner join fas_script_type
on fas_script_type.idscripttype = fas_routines_process.idscript
inner join fas_step
on fas_step.instance = fas_routines_steps.instance
  inner join fas_tree_product_references
       on fas_tree_product_references.idproduct = products.idproduct 
	   inner join fas_autotest_states
	   on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
	   fas_autotest_states.idband			=	fas_tree_product_references.idband and
	   fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
	   fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
	   fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
 
where
modelciu LIKE '%BTTY%'   
 
) as lsodatos
inner join fas_tree_product_references
on  fas_tree_product_references.idreference = lsodatos.idreference::integer
where fas_stepname in('AcceptBBU_Check_Alarm_BDA_OFF','AcceptBBU_Check_Alarm_SystemComponentsFail_OFF','AcceptBBU_Check_Alarm_AC_OFF','AcceptBBU_Check_Alarm_AC_ON','AcceptBBU_Check_Alarm_FirePanel_ON','AcceptBBU_Check_Alarm_BatteryCapacity_ON','AcceptBBU_Check_Alarm_SystemComponentsFail_ON','AcceptBBU_Check_Alarm_BDA_ON','AcceptBBU_Check_Alarm_FirePanel_OFF','AcceptBBU_Check_Alarm_BatteryCapacity_OFF' ) 
-------------------------relay2
union 
  
 select modelciu,
 concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,13,null,',relay3 	,','''','''',null,',lsodatos.idrelays,')' ) AS mma 
from
(
select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
 
from fas_routines_process
inner join fas_routines_steps
on fas_routines_steps.idstep = fas_routines_process.idstep
inner join products
on products.idproduct = fas_routines_process.idproduct
inner join fas_script_type
on fas_script_type.idscripttype = fas_routines_process.idscript
inner join fas_step
on fas_step.instance = fas_routines_steps.instance
  inner join fas_tree_product_references
       on fas_tree_product_references.idproduct = products.idproduct 
	   inner join fas_autotest_states
	   on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
	   fas_autotest_states.idband			=	fas_tree_product_references.idband and
	   fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
	   fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
	   fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
 
where
modelciu LIKE '%BTTY%'   
 
) as lsodatos
inner join fas_tree_product_references
on  fas_tree_product_references.idreference = lsodatos.idreference::integer
where fas_stepname in('AcceptBBU_Check_Alarm_BDA_OFF','AcceptBBU_Check_Alarm_SystemComponentsFail_OFF','AcceptBBU_Check_Alarm_AC_OFF','AcceptBBU_Check_Alarm_AC_ON','AcceptBBU_Check_Alarm_FirePanel_ON','AcceptBBU_Check_Alarm_BatteryCapacity_ON','AcceptBBU_Check_Alarm_SystemComponentsFail_ON','AcceptBBU_Check_Alarm_BDA_ON','AcceptBBU_Check_Alarm_FirePanel_OFF','AcceptBBU_Check_Alarm_BatteryCapacity_OFF' ) 
-------------------------relay3
union 
  
 select modelciu,
 concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,14,null,',relay4 	,','''','''',null,',lsodatos.idrelays,')' ) AS mma 
from
(
select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
 
from fas_routines_process
inner join fas_routines_steps
on fas_routines_steps.idstep = fas_routines_process.idstep
inner join products
on products.idproduct = fas_routines_process.idproduct
inner join fas_script_type
on fas_script_type.idscripttype = fas_routines_process.idscript
inner join fas_step
on fas_step.instance = fas_routines_steps.instance
  inner join fas_tree_product_references
       on fas_tree_product_references.idproduct = products.idproduct 
	   inner join fas_autotest_states
	   on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
	   fas_autotest_states.idband			=	fas_tree_product_references.idband and
	   fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
	   fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
	   fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
 
where
modelciu LIKE '%BTTY%'   
 
) as lsodatos
inner join fas_tree_product_references
on  fas_tree_product_references.idreference = lsodatos.idreference::integer
where fas_stepname in('AcceptBBU_Check_Alarm_BDA_OFF','AcceptBBU_Check_Alarm_SystemComponentsFail_OFF','AcceptBBU_Check_Alarm_AC_OFF','AcceptBBU_Check_Alarm_AC_ON','AcceptBBU_Check_Alarm_FirePanel_ON','AcceptBBU_Check_Alarm_BatteryCapacity_ON','AcceptBBU_Check_Alarm_SystemComponentsFail_ON','AcceptBBU_Check_Alarm_BDA_ON','AcceptBBU_Check_Alarm_FirePanel_OFF','AcceptBBU_Check_Alarm_BatteryCapacity_OFF' ) 
-------------------------relay4
union 
  
 select modelciu,
 concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,15,null,',relay5 	,','''','''',null,',lsodatos.idrelays,')' ) AS mma 
from
(
select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
 
from fas_routines_process
inner join fas_routines_steps
on fas_routines_steps.idstep = fas_routines_process.idstep
inner join products
on products.idproduct = fas_routines_process.idproduct
inner join fas_script_type
on fas_script_type.idscripttype = fas_routines_process.idscript
inner join fas_step
on fas_step.instance = fas_routines_steps.instance
  inner join fas_tree_product_references
       on fas_tree_product_references.idproduct = products.idproduct 
	   inner join fas_autotest_states
	   on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
	   fas_autotest_states.idband			=	fas_tree_product_references.idband and
	   fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
	   fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
	   fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
 
where
modelciu LIKE '%BTTY%'   
 
) as lsodatos
inner join fas_tree_product_references
on  fas_tree_product_references.idreference = lsodatos.idreference::integer
where fas_stepname in('AcceptBBU_Check_Alarm_BDA_OFF','AcceptBBU_Check_Alarm_SystemComponentsFail_OFF','AcceptBBU_Check_Alarm_AC_OFF','AcceptBBU_Check_Alarm_AC_ON','AcceptBBU_Check_Alarm_FirePanel_ON','AcceptBBU_Check_Alarm_BatteryCapacity_ON','AcceptBBU_Check_Alarm_SystemComponentsFail_ON','AcceptBBU_Check_Alarm_BDA_ON','AcceptBBU_Check_Alarm_FirePanel_OFF','AcceptBBU_Check_Alarm_BatteryCapacity_OFF' ) 
-------------------------relay4
union 
  
 select modelciu,
 concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,16,null,',relay6 	,','''','''',null,',lsodatos.idrelays,')' ) AS mma 
from
(
select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
 
from fas_routines_process
inner join fas_routines_steps
on fas_routines_steps.idstep = fas_routines_process.idstep
inner join products
on products.idproduct = fas_routines_process.idproduct
inner join fas_script_type
on fas_script_type.idscripttype = fas_routines_process.idscript
inner join fas_step
on fas_step.instance = fas_routines_steps.instance
  inner join fas_tree_product_references
       on fas_tree_product_references.idproduct = products.idproduct 
	   inner join fas_autotest_states
	   on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
	   fas_autotest_states.idband			=	fas_tree_product_references.idband and
	   fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
	   fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
	   fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
 
where
modelciu LIKE '%BTTY%'   
 
) as lsodatos
inner join fas_tree_product_references
on  fas_tree_product_references.idreference = lsodatos.idreference::integer
where fas_stepname in('AcceptBBU_Check_Alarm_BDA_OFF','AcceptBBU_Check_Alarm_SystemComponentsFail_OFF','AcceptBBU_Check_Alarm_AC_OFF','AcceptBBU_Check_Alarm_AC_ON','AcceptBBU_Check_Alarm_FirePanel_ON','AcceptBBU_Check_Alarm_BatteryCapacity_ON','AcceptBBU_Check_Alarm_SystemComponentsFail_ON','AcceptBBU_Check_Alarm_BDA_ON','AcceptBBU_Check_Alarm_FirePanel_OFF','AcceptBBU_Check_Alarm_BatteryCapacity_OFF' ) 
-------------------------relay4 -  in('AcceptBBU_Check_Alarm_BDA_OFF','AcceptBBU_Check_Alarm_SystemComponentsFail_OFF','AcceptBBU_Check_Alarm_AC_OFF','AcceptBBU_Check_Alarm_AC_ON','AcceptBBU_Check_Alarm_FirePanel_ON','AcceptBBU_Check_Alarm_BatteryCapacity_ON','AcceptBBU_Check_Alarm_SystemComponentsFail_ON','AcceptBBU_Check_Alarm_BDA_ON','AcceptBBU_Check_Alarm_FirePanel_OFF','AcceptBBU_Check_Alarm_BatteryCapacity_OFF' ) 
*************************************************************
****************************RELAY ULTIMO,P**************************************
   select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,11,null,null,'''','''',',relay1::text ,',',lsodatos.idrelays,')' ) AS mma 
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname = 'AcceptBBU_Check_PwrSourceVoltage'
          -------------------------relay1
          union 
            select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,12,null,null,'''','''',',relay2::text ,',',lsodatos.idrelays,')' ) AS mma  
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname = 'AcceptBBU_Check_PwrSourceVoltage'
          -------------------------relay2
          union 
            
           
           select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,13,null,null,'''','''',',relay3::text ,',',lsodatos.idrelays,')' ) AS mma  
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname = 'AcceptBBU_Check_PwrSourceVoltage'
          -------------------------relay3
          union 
            select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,14,null,null,'''','''',',relay4::text ,',',lsodatos.idrelays,')' ) AS mma  
           
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname = 'AcceptBBU_Check_PwrSourceVoltage'
          -------------------------relay4
          union 
              select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,15,null,null,'''','''',',relay5::text ,',',lsodatos.idrelays,')' ) AS mma  
             
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname = 'AcceptBBU_Check_PwrSourceVoltage'
          -------------------------relay4
          union 
            select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,16,null,null,'''','''',',relay6::text ,',',lsodatos.idrelays,')' ) AS mma  
           from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname = 'AcceptBBU_Check_PwrSourceVoltage'
          -------------------------relay4 - AcceptBBU_Check_PwrSourceVoltage
          union 
            select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,11,null,null,'''','''',',relay1::text ,',',lsodatos.idrelays,')' ) AS mma  
           
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname = 'AcceptBBU_Check_Current'
          -------------------------relay1
          union 
            select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,12,null,null,'''','''',',relay2::text ,',',lsodatos.idrelays,')' ) AS mma  
           
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname = 'AcceptBBU_Check_Current'
          -------------------------relay2
          union 
            select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,13,null,null,'''','''',',relay3::text ,',',lsodatos.idrelays,')' ) AS mma  
           
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname = 'AcceptBBU_Check_Current'
          -------------------------relay3
          union 
            select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,14,null,null,'''','''',',relay4::text ,',',lsodatos.idrelays,')' ) AS mma  
            
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname = 'AcceptBBU_Check_Current'
          -------------------------relay4
          union 
              select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,15,null,null,'''','''',',relay5::text ,',',lsodatos.idrelays,')' ) AS mma  
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname = 'AcceptBBU_Check_Current'
          -------------------------relay4
          union 
            select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,16,null,null,'''','''',',relay6::text ,',',lsodatos.idrelays,')' ) AS mma  
           
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname = 'AcceptBBU_Check_Current'
          -------------------------relay4 - AcceptBBU_Check_Current
          union
              select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,11,null,null,'''','''',',relay1::text ,',',lsodatos.idrelays,')' ) AS mma  
             
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname = 'AcceptBBU_Check_Voltage'
          -------------------------relay1
          union 
            select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,12,null,null,'''','''',',relay2::text ,',',lsodatos.idrelays,')' ) AS mma  
           
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname = 'AcceptBBU_Check_Voltage'
          -------------------------relay2
          union 
              select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,13,null,null,'''','''',',relay3::text ,',',lsodatos.idrelays,')' ) AS mma  
            
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname = 'AcceptBBU_Check_Voltage'
          -------------------------relay3
          union 
               select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,14,null,null,'''','''',',relay4::text ,',',lsodatos.idrelays,')' ) AS mma  
           
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname = 'AcceptBBU_Check_Voltage'
          -------------------------relay4
          union 
            select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,15,null,null,'''','''',',relay5::text ,',',lsodatos.idrelays,')' ) AS mma  
           
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname = 'AcceptBBU_Check_Voltage'
          -------------------------relay4
          union 
            select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,16,null,null,'''','''',',relay6::text ,',',lsodatos.idrelays,')' ) AS mma  
           
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname = 'AcceptBBU_Check_Voltage'
          -------------------------relay4 - AcceptBBU_Check_Voltage
          union 
            select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,11,null,null,'''','''',',relay1::text ,',',lsodatos.idrelays,')' ) AS mma  
           
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname = 'AcceptBBU_Check_Alarm_BDA_OFF'
          -------------------------relay1
          union 
              select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,12,null,null,'''','''',',relay2::text ,',',lsodatos.idrelays,')' ) AS mma  
           
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname = 'AcceptBBU_Check_Alarm_BDA_OFF'
          -------------------------relay2
          union 
               select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,13,null,null,'''','''',',relay3::text ,',',lsodatos.idrelays,')' ) AS mma  
            
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname = 'AcceptBBU_Check_Alarm_BDA_OFF'
          -------------------------relay3
          union 
                select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,14,null,null,'''','''',',relay4::text ,',',lsodatos.idrelays,')' ) AS mma  
             
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname = 'AcceptBBU_Check_Alarm_BDA_OFF'
          -------------------------relay4
          union 
               select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,15,null,null,'''','''',',relay5::text ,',',lsodatos.idrelays,')' ) AS mma  
           
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname = 'AcceptBBU_Check_Alarm_BDA_OFF'
          -------------------------relay4
          union 
               select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,16,null,null,'''','''',',relay6::text ,',',lsodatos.idrelays,')' ) AS mma  
           
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname = 'AcceptBBU_Check_Alarm_BDA_OFF'
          -------------------------relay4 - AcceptBBU_Check_Alarm_BDA_OFF
          union 
                select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,11,null,null,'''','''',',relay1::text ,',',lsodatos.idrelays,')' ) AS mma  
           
           
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname in('AcceptBBU_Check_Alarm_BDA_OFF','AcceptBBU_Check_Alarm_SystemComponentsFail_OFF','AcceptBBU_Check_Alarm_AC_OFF','AcceptBBU_Check_Alarm_AC_ON','AcceptBBU_Check_Alarm_FirePanel_ON','AcceptBBU_Check_Alarm_BatteryCapacity_ON','AcceptBBU_Check_Alarm_SystemComponentsFail_ON','AcceptBBU_Check_Alarm_BDA_ON','AcceptBBU_Check_Alarm_FirePanel_OFF','AcceptBBU_Check_Alarm_BatteryCapacity_OFF' ) 
          -------------------------relay1
          union 
                  select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,12,null,null,'''','''',',relay2::text ,',',lsodatos.idrelays,')' ) AS mma  
           
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname in('AcceptBBU_Check_Alarm_BDA_OFF','AcceptBBU_Check_Alarm_SystemComponentsFail_OFF','AcceptBBU_Check_Alarm_AC_OFF','AcceptBBU_Check_Alarm_AC_ON','AcceptBBU_Check_Alarm_FirePanel_ON','AcceptBBU_Check_Alarm_BatteryCapacity_ON','AcceptBBU_Check_Alarm_SystemComponentsFail_ON','AcceptBBU_Check_Alarm_BDA_ON','AcceptBBU_Check_Alarm_FirePanel_OFF','AcceptBBU_Check_Alarm_BatteryCapacity_OFF' ) 
          -------------------------relay2
          union 
            select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,13,null,null,'''','''',',relay3::text ,',',lsodatos.idrelays,')' ) AS mma  
           
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname in('AcceptBBU_Check_Alarm_BDA_OFF','AcceptBBU_Check_Alarm_SystemComponentsFail_OFF','AcceptBBU_Check_Alarm_AC_OFF','AcceptBBU_Check_Alarm_AC_ON','AcceptBBU_Check_Alarm_FirePanel_ON','AcceptBBU_Check_Alarm_BatteryCapacity_ON','AcceptBBU_Check_Alarm_SystemComponentsFail_ON','AcceptBBU_Check_Alarm_BDA_ON','AcceptBBU_Check_Alarm_FirePanel_OFF','AcceptBBU_Check_Alarm_BatteryCapacity_OFF' ) 
          -------------------------relay3
          union 
             select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,14,null,null,'''','''',',relay4::text ,',',lsodatos.idrelays,')' ) AS mma  
           
           
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname in('AcceptBBU_Check_Alarm_BDA_OFF','AcceptBBU_Check_Alarm_SystemComponentsFail_OFF','AcceptBBU_Check_Alarm_AC_OFF','AcceptBBU_Check_Alarm_AC_ON','AcceptBBU_Check_Alarm_FirePanel_ON','AcceptBBU_Check_Alarm_BatteryCapacity_ON','AcceptBBU_Check_Alarm_SystemComponentsFail_ON','AcceptBBU_Check_Alarm_BDA_ON','AcceptBBU_Check_Alarm_FirePanel_OFF','AcceptBBU_Check_Alarm_BatteryCapacity_OFF' ) 
          -------------------------relay4
          union 
             select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,15,null,null,'''','''',',relay5::text ,',',lsodatos.idrelays,')' ) AS mma  
           
           
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname in('AcceptBBU_Check_Alarm_BDA_OFF','AcceptBBU_Check_Alarm_SystemComponentsFail_OFF','AcceptBBU_Check_Alarm_AC_OFF','AcceptBBU_Check_Alarm_AC_ON','AcceptBBU_Check_Alarm_FirePanel_ON','AcceptBBU_Check_Alarm_BatteryCapacity_ON','AcceptBBU_Check_Alarm_SystemComponentsFail_ON','AcceptBBU_Check_Alarm_BDA_ON','AcceptBBU_Check_Alarm_FirePanel_OFF','AcceptBBU_Check_Alarm_BatteryCapacity_OFF' ) 
          -------------------------relay4
          union 
             select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,16,null,null,'''','''',',relay6::text ,',',lsodatos.idrelays,')' ) AS mma  
           
           
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname in('AcceptBBU_Check_Alarm_BDA_OFF','AcceptBBU_Check_Alarm_SystemComponentsFail_OFF','AcceptBBU_Check_Alarm_AC_OFF','AcceptBBU_Check_Alarm_AC_ON','AcceptBBU_Check_Alarm_FirePanel_ON','AcceptBBU_Check_Alarm_BatteryCapacity_ON','AcceptBBU_Check_Alarm_SystemComponentsFail_ON','AcceptBBU_Check_Alarm_BDA_ON','AcceptBBU_Check_Alarm_FirePanel_OFF','AcceptBBU_Check_Alarm_BatteryCapacity_OFF' ) 
          -------------------------relay4 -  in('AcceptBBU_Check_Alarm_BDA_OFF','AcceptBBU_Check_Alarm_SystemComponentsFail_OFF','AcceptBBU_Check_Alarm_AC_OFF','AcceptBBU_Check_Alarm_AC_ON','AcceptBBU_Check_Alarm_FirePanel_ON','AcceptBBU_Check_Alarm_BatteryCapacity_ON','AcceptBBU_Check_Alarm_SystemComponentsFail_ON','AcceptBBU_Check_Alarm_BDA_ON','AcceptBBU_Check_Alarm_FirePanel_OFF','AcceptBBU_Check_Alarm_BatteryCapacity_OFF' ) 
          
*************************** FIN RELAY ***************************************


          select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,11,null,null,'''','''',',relay1::text ,',',lsodatos.idrelays,')' ) AS mma 
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname = 'AcceptBBU_Check_PwrSourceVoltage'
          -------------------------relay1
          union 
            select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,12,null,null,'''','''',',relay2::text ,',',lsodatos.idrelays,')' ) AS mma  
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname = 'AcceptBBU_Check_PwrSourceVoltage'
          -------------------------relay2
          union 
            
           
           select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,13,null,null,'''','''',',relay3::text ,',',lsodatos.idrelays,')' ) AS mma  
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname = 'AcceptBBU_Check_PwrSourceVoltage'
          -------------------------relay3
          union 
            select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,14,null,null,'''','''',',relay4::text ,',',lsodatos.idrelays,')' ) AS mma  
           
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname = 'AcceptBBU_Check_PwrSourceVoltage'
          -------------------------relay4
          union 
              select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,15,null,null,'''','''',',relay5::text ,',',lsodatos.idrelays,')' ) AS mma  
             
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname = 'AcceptBBU_Check_PwrSourceVoltage'
          -------------------------relay4
          union 
            select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,16,null,null,'''','''',',relay6::text ,',',lsodatos.idrelays,')' ) AS mma  
           from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname = 'AcceptBBU_Check_PwrSourceVoltage'
          -------------------------relay4 - AcceptBBU_Check_PwrSourceVoltage
          union 
            select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,11,null,null,'''','''',',relay1::text ,',',lsodatos.idrelays,')' ) AS mma  
           
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname = 'AcceptBBU_Check_Current'
          -------------------------relay1
          union 
            select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,12,null,null,'''','''',',relay2::text ,',',lsodatos.idrelays,')' ) AS mma  
           
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname = 'AcceptBBU_Check_Current'
          -------------------------relay2
          union 
            select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,13,null,null,'''','''',',relay3::text ,',',lsodatos.idrelays,')' ) AS mma  
           
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname = 'AcceptBBU_Check_Current'
          -------------------------relay3
          union 
            select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,14,null,null,'''','''',',relay4::text ,',',lsodatos.idrelays,')' ) AS mma  
            
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname = 'AcceptBBU_Check_Current'
          -------------------------relay4
          union 
              select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,15,null,null,'''','''',',relay5::text ,',',lsodatos.idrelays,')' ) AS mma  
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname = 'AcceptBBU_Check_Current'
          -------------------------relay4
          union 
            select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,16,null,null,'''','''',',relay6::text ,',',lsodatos.idrelays,')' ) AS mma  
           
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname = 'AcceptBBU_Check_Current'
          -------------------------relay4 - AcceptBBU_Check_Current
          union
              select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,11,null,null,'''','''',',relay1::text ,',',lsodatos.idrelays,')' ) AS mma  
             
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname = 'AcceptBBU_Check_Voltage'
          -------------------------relay1
          union 
            select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,12,null,null,'''','''',',relay2::text ,',',lsodatos.idrelays,')' ) AS mma  
           
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname = 'AcceptBBU_Check_Voltage'
          -------------------------relay2
          union 
              select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,13,null,null,'''','''',',relay3::text ,',',lsodatos.idrelays,')' ) AS mma  
            
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname = 'AcceptBBU_Check_Voltage'
          -------------------------relay3
          union 
               select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,14,null,null,'''','''',',relay4::text ,',',lsodatos.idrelays,')' ) AS mma  
           
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname = 'AcceptBBU_Check_Voltage'
          -------------------------relay4
          union 
            select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,15,null,null,'''','''',',relay5::text ,',',lsodatos.idrelays,')' ) AS mma  
           
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname = 'AcceptBBU_Check_Voltage'
          -------------------------relay4
          union 
            select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,16,null,null,'''','''',',relay6::text ,',',lsodatos.idrelays,')' ) AS mma  
           
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname = 'AcceptBBU_Check_Voltage'
          -------------------------relay4 - AcceptBBU_Check_Voltage
          union 
            select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,11,null,null,'''','''',',relay1::text ,',',lsodatos.idrelays,')' ) AS mma  
           
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname = 'AcceptBBU_Check_Alarm_BDA_OFF'
          -------------------------relay1
          union 
              select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,12,null,null,'''','''',',relay2::text ,',',lsodatos.idrelays,')' ) AS mma  
           
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname = 'AcceptBBU_Check_Alarm_BDA_OFF'
          -------------------------relay2
          union 
               select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,13,null,null,'''','''',',relay3::text ,',',lsodatos.idrelays,')' ) AS mma  
            
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname = 'AcceptBBU_Check_Alarm_BDA_OFF'
          -------------------------relay3
          union 
                select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,14,null,null,'''','''',',relay4::text ,',',lsodatos.idrelays,')' ) AS mma  
             
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname = 'AcceptBBU_Check_Alarm_BDA_OFF'
          -------------------------relay4
          union 
               select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,15,null,null,'''','''',',relay5::text ,',',lsodatos.idrelays,')' ) AS mma  
           
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname = 'AcceptBBU_Check_Alarm_BDA_OFF'
          -------------------------relay4
          union 
               select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,16,null,null,'''','''',',relay6::text ,',',lsodatos.idrelays,')' ) AS mma  
           
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname = 'AcceptBBU_Check_Alarm_BDA_OFF'
          -------------------------relay4 - AcceptBBU_Check_Alarm_BDA_OFF
          union 
                select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,11,null,null,'''','''',',relay1::text ,',',lsodatos.idrelays,')' ) AS mma  
           
           
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname in('AcceptBBU_Check_Alarm_BDA_OFF','AcceptBBU_Check_Alarm_SystemComponentsFail_OFF','AcceptBBU_Check_Alarm_AC_OFF','AcceptBBU_Check_Alarm_AC_ON','AcceptBBU_Check_Alarm_FirePanel_ON','AcceptBBU_Check_Alarm_BatteryCapacity_ON','AcceptBBU_Check_Alarm_SystemComponentsFail_ON','AcceptBBU_Check_Alarm_BDA_ON','AcceptBBU_Check_Alarm_FirePanel_OFF','AcceptBBU_Check_Alarm_BatteryCapacity_OFF' ) 
          -------------------------relay1
          union 
                  select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,12,null,null,'''','''',',relay2::text ,',',lsodatos.idrelays,')' ) AS mma  
           
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname in('AcceptBBU_Check_Alarm_BDA_OFF','AcceptBBU_Check_Alarm_SystemComponentsFail_OFF','AcceptBBU_Check_Alarm_AC_OFF','AcceptBBU_Check_Alarm_AC_ON','AcceptBBU_Check_Alarm_FirePanel_ON','AcceptBBU_Check_Alarm_BatteryCapacity_ON','AcceptBBU_Check_Alarm_SystemComponentsFail_ON','AcceptBBU_Check_Alarm_BDA_ON','AcceptBBU_Check_Alarm_FirePanel_OFF','AcceptBBU_Check_Alarm_BatteryCapacity_OFF' ) 
          -------------------------relay2
          union 
            select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,13,null,null,'''','''',',relay3::text ,',',lsodatos.idrelays,')' ) AS mma  
           
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname in('AcceptBBU_Check_Alarm_BDA_OFF','AcceptBBU_Check_Alarm_SystemComponentsFail_OFF','AcceptBBU_Check_Alarm_AC_OFF','AcceptBBU_Check_Alarm_AC_ON','AcceptBBU_Check_Alarm_FirePanel_ON','AcceptBBU_Check_Alarm_BatteryCapacity_ON','AcceptBBU_Check_Alarm_SystemComponentsFail_ON','AcceptBBU_Check_Alarm_BDA_ON','AcceptBBU_Check_Alarm_FirePanel_OFF','AcceptBBU_Check_Alarm_BatteryCapacity_OFF' ) 
          -------------------------relay3
          union 
             select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,14,null,null,'''','''',',relay4::text ,',',lsodatos.idrelays,')' ) AS mma  
           
           
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname in('AcceptBBU_Check_Alarm_BDA_OFF','AcceptBBU_Check_Alarm_SystemComponentsFail_OFF','AcceptBBU_Check_Alarm_AC_OFF','AcceptBBU_Check_Alarm_AC_ON','AcceptBBU_Check_Alarm_FirePanel_ON','AcceptBBU_Check_Alarm_BatteryCapacity_ON','AcceptBBU_Check_Alarm_SystemComponentsFail_ON','AcceptBBU_Check_Alarm_BDA_ON','AcceptBBU_Check_Alarm_FirePanel_OFF','AcceptBBU_Check_Alarm_BatteryCapacity_OFF' ) 
          -------------------------relay4
          union 
             select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,15,null,null,'''','''',',relay5::text ,',',lsodatos.idrelays,')' ) AS mma  
           
           
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname in('AcceptBBU_Check_Alarm_BDA_OFF','AcceptBBU_Check_Alarm_SystemComponentsFail_OFF','AcceptBBU_Check_Alarm_AC_OFF','AcceptBBU_Check_Alarm_AC_ON','AcceptBBU_Check_Alarm_FirePanel_ON','AcceptBBU_Check_Alarm_BatteryCapacity_ON','AcceptBBU_Check_Alarm_SystemComponentsFail_ON','AcceptBBU_Check_Alarm_BDA_ON','AcceptBBU_Check_Alarm_FirePanel_OFF','AcceptBBU_Check_Alarm_BatteryCapacity_OFF' ) 
          -------------------------relay4
          union 
             select concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,16,null,null,'''','''',',relay6::text ,',',lsodatos.idrelays,')' ) AS mma  
           
           
          from
          (
          select distinct  modelciu , fas_script_type.scriptname, fas_autotest_states.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
           
          from fas_routines_process
          inner join fas_routines_steps
          on fas_routines_steps.idstep = fas_routines_process.idstep
          inner join products
          on products.idproduct = fas_routines_process.idproduct
          inner join fas_script_type
          on fas_script_type.idscripttype = fas_routines_process.idscript
          inner join fas_step
          on fas_step.instance = fas_routines_steps.instance
            inner join fas_tree_product_references
                 on fas_tree_product_references.idproduct = products.idproduct 
               inner join fas_autotest_states
               on fas_autotest_states.idproduct		=	fas_tree_product_references.idproduct  and
               fas_autotest_states.idband			=	fas_tree_product_references.idband and
               fas_autotest_states.uldl				=	fas_tree_product_references.uldl and
               fas_autotest_states.iduniquebranch	=	fas_tree_product_references.iduniquebranch	and
               fas_autotest_states.iduniquebranch	= fas_routines_steps.instance
           
          where
          modelciu LIKE '%BTTY%'   
           
          ) as lsodatos
          inner join fas_tree_product_references
          on  fas_tree_product_references.idreference = lsodatos.idreference::integer
          where fas_stepname in('AcceptBBU_Check_Alarm_BDA_OFF','AcceptBBU_Check_Alarm_SystemComponentsFail_OFF','AcceptBBU_Check_Alarm_AC_OFF','AcceptBBU_Check_Alarm_AC_ON','AcceptBBU_Check_Alarm_FirePanel_ON','AcceptBBU_Check_Alarm_BatteryCapacity_ON','AcceptBBU_Check_Alarm_SystemComponentsFail_ON','AcceptBBU_Check_Alarm_BDA_ON','AcceptBBU_Check_Alarm_FirePanel_OFF','AcceptBBU_Check_Alarm_BatteryCapacity_OFF' ) 
          -------------------------relay4 -  in('AcceptBBU_Check_Alarm_BDA_OFF','AcceptBBU_Check_Alarm_SystemComponentsFail_OFF','AcceptBBU_Check_Alarm_AC_OFF','AcceptBBU_Check_Alarm_AC_ON','AcceptBBU_Check_Alarm_FirePanel_ON','AcceptBBU_Check_Alarm_BatteryCapacity_ON','AcceptBBU_Check_Alarm_SystemComponentsFail_ON','AcceptBBU_Check_Alarm_BDA_ON','AcceptBBU_Check_Alarm_FirePanel_OFF','AcceptBBU_Check_Alarm_BatteryCapacity_OFF' ) 
     
       
*****************************************************************************
 select 
 concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',0,16,null,',reference1,','''','''',null,',lsodatos.idreference,')' ) AS mma 
from
(
select distinct  modelciu , fas_script_type.scriptname, fas_routines_process.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
 
from fas_routines_process
inner join fas_routines_steps
on fas_routines_steps.idstep = fas_routines_process.idstep
inner join products
on products.idproduct = fas_routines_process.idproduct
inner join fas_script_type
on fas_script_type.idscripttype = fas_routines_process.idscript
inner join fas_step
on fas_step.instance = fas_routines_steps.instance
 
where
modelciu LIKE '%BTTY%'  
 
) as lsodatos
inner join fas_tree_product_references
on  fas_tree_product_references.idreference = lsodatos.idreference::integer
where fas_stepname = 'AcceptBBU_Check_Alarm_AnnunciatorCommunication_OFF'
union
     select 
 concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',0,23,null,',reference1,','''','''',null,',lsodatos.idreference,')' ) AS mma 
from
(
select distinct  modelciu , fas_script_type.scriptname, fas_routines_process.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
 
from fas_routines_process
inner join fas_routines_steps
on fas_routines_steps.idstep = fas_routines_process.idstep
inner join products
on products.idproduct = fas_routines_process.idproduct
inner join fas_script_type
on fas_script_type.idscripttype = fas_routines_process.idscript
inner join fas_step
on fas_step.instance = fas_routines_steps.instance
 
where
modelciu LIKE '%BTTY%'  
 
) as lsodatos
inner join fas_tree_product_references
on  fas_tree_product_references.idreference = lsodatos.idreference::integer
where fas_stepname = 'AcceptBBU_Check_PowerStress'
union
     select 
 concat('call sp_insert_fas_income_integral(' ,lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',0,24,null,',reference2,','''','''',null,',lsodatos.idreference,')' ) AS mma 
from
(
select distinct  modelciu , fas_script_type.scriptname, fas_routines_process.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
 
from fas_routines_process
inner join fas_routines_steps
on fas_routines_steps.idstep = fas_routines_process.idstep
inner join products
on products.idproduct = fas_routines_process.idproduct
inner join fas_script_type
on fas_script_type.idscripttype = fas_routines_process.idscript
inner join fas_step
on fas_step.instance = fas_routines_steps.instance
 
where
modelciu LIKE '%BTTY%'  
 
) as lsodatos
inner join fas_tree_product_references
on  fas_tree_product_references.idreference = lsodatos.idreference::integer
where fas_stepname = 'AcceptBBU_Check_PowerStress'
union
     select 
 concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',0,25,null,',reference3,','''','''',null,',lsodatos.idreference,')' ) AS mma 
from
(
select distinct  modelciu , fas_script_type.scriptname, fas_routines_process.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
 
from fas_routines_process
inner join fas_routines_steps
on fas_routines_steps.idstep = fas_routines_process.idstep
inner join products
on products.idproduct = fas_routines_process.idproduct
inner join fas_script_type
on fas_script_type.idscripttype = fas_routines_process.idscript
inner join fas_step
on fas_step.instance = fas_routines_steps.instance
 
where
modelciu LIKE '%BTTY%'  
 
) as lsodatos
inner join fas_tree_product_references
on  fas_tree_product_references.idreference = lsodatos.idreference::integer
where fas_stepname = 'AcceptBBU_Check_PowerStress'
union
     select 
 concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',0,13,null,',reference4,','''','''',null,',lsodatos.idreference,')' ) AS mma 
from
(
select distinct  modelciu , fas_script_type.scriptname, fas_routines_process.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
 
from fas_routines_process
inner join fas_routines_steps
on fas_routines_steps.idstep = fas_routines_process.idstep
inner join products
on products.idproduct = fas_routines_process.idproduct
inner join fas_script_type
on fas_script_type.idscripttype = fas_routines_process.idscript
inner join fas_step
on fas_step.instance = fas_routines_steps.instance
 
where
modelciu LIKE '%BTTY%'  
 
) as lsodatos
inner join fas_tree_product_references
on  fas_tree_product_references.idreference = lsodatos.idreference::integer
where fas_stepname = 'AcceptBBU_Check_PowerStress'
union
     select 
 concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',0,21,null,',reference5,','''','''',null,',lsodatos.idreference,')' ) AS mma 
from
(
select distinct  modelciu , fas_script_type.scriptname, fas_routines_process.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
 
from fas_routines_process
inner join fas_routines_steps
on fas_routines_steps.idstep = fas_routines_process.idstep
inner join products
on products.idproduct = fas_routines_process.idproduct
inner join fas_script_type
on fas_script_type.idscripttype = fas_routines_process.idscript
inner join fas_step
on fas_step.instance = fas_routines_steps.instance
 
where
modelciu LIKE '%BTTY%'  
 
) as lsodatos
inner join fas_tree_product_references
on  fas_tree_product_references.idreference = lsodatos.idreference::integer
where fas_stepname = 'AcceptBBU_Check_PowerStress'
union
     select 
 concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',0,26,null,',reference6,','''','''',null,',lsodatos.idreference,')' ) AS mma 
from
(
select distinct  modelciu , fas_script_type.scriptname, fas_routines_process.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
 
from fas_routines_process
inner join fas_routines_steps
on fas_routines_steps.idstep = fas_routines_process.idstep
inner join products
on products.idproduct = fas_routines_process.idproduct
inner join fas_script_type
on fas_script_type.idscripttype = fas_routines_process.idscript
inner join fas_step
on fas_step.instance = fas_routines_steps.instance
 
where
modelciu LIKE '%BTTY%'  
 
) as lsodatos
inner join fas_tree_product_references
on  fas_tree_product_references.idreference = lsodatos.idreference::integer
where fas_stepname = 'AcceptBBU_Check_PowerStress'
*************************************************************************

    	   
select distinct
concat('call sp_insert_fas_income_integral  (',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',0,13,null,',reference1,','''','''',null,',lsodatos.idreference,')' ) AS mma 
from
(
select distinct fas_routines_process.idstep as idstepppp,  modelciu , fas_script_type.scriptname, fas_routines_process.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference

from fas_routines_process
inner join fas_routines_steps
on fas_routines_steps.idstep = 13
inner join products
on products.idproduct = fas_routines_process.idproduct
inner join fas_script_type
on fas_script_type.idscripttype = fas_routines_process.idscript
inner join fas_step
on fas_step.instance = fas_routines_steps.instance

where
modelciu LIKE '%BTTY%'  

) as lsodatos
inner join fas_tree_product_references
on  fas_tree_product_references.idreference = lsodatos.idreference::integer
union

select distinct
concat('call sp_insert_fas_income_integral  (',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',0,21,null,',reference2,','''','''',null,',lsodatos.idreference,')' ) AS mma 
from
(
select distinct fas_routines_process.idstep as idstepppp,  modelciu , fas_script_type.scriptname, fas_routines_process.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference

from fas_routines_process
inner join fas_routines_steps
on fas_routines_steps.idstep = 13
inner join products
on products.idproduct = fas_routines_process.idproduct
inner join fas_script_type
on fas_script_type.idscripttype = fas_routines_process.idscript
inner join fas_step
on fas_step.instance = fas_routines_steps.instance

where
modelciu LIKE '%BTTY%'  

) as lsodatos
inner join fas_tree_product_references
on  fas_tree_product_references.idreference = lsodatos.idreference::integer
union

select distinct
concat('call sp_insert_fas_income_integral  (',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',0,22,null,',reference3,','''','''',null,',lsodatos.idreference,')' ) AS mma 
from
(
select distinct fas_routines_process.idstep as idstepppp,  modelciu , fas_script_type.scriptname, fas_routines_process.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference

from fas_routines_process
inner join fas_routines_steps
on fas_routines_steps.idstep = 13
inner join products
on products.idproduct = fas_routines_process.idproduct
inner join fas_script_type
on fas_script_type.idscripttype = fas_routines_process.idscript
inner join fas_step
on fas_step.instance = fas_routines_steps.instance

where
modelciu LIKE '%BTTY%'  

) as lsodatos
inner join fas_tree_product_references
on  fas_tree_product_references.idreference = lsodatos.idreference::integer
-----******************************* 14
union
select distinct
concat('call sp_insert_fas_income_integral  (',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',0,13,null,',reference1,','''','''',null,',lsodatos.idreference,')' ) AS mma 
from
(
select distinct fas_routines_process.idstep as idstepppp,  modelciu , fas_script_type.scriptname, fas_routines_process.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference

from fas_routines_process
inner join fas_routines_steps
on fas_routines_steps.idstep = 14
inner join products
on products.idproduct = fas_routines_process.idproduct
inner join fas_script_type
on fas_script_type.idscripttype = fas_routines_process.idscript
inner join fas_step
on fas_step.instance = fas_routines_steps.instance

where
modelciu LIKE '%BTTY%'  

) as lsodatos
inner join fas_tree_product_references
on  fas_tree_product_references.idreference = lsodatos.idreference::integer
union

select distinct
concat('call sp_insert_fas_income_integral  (',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',0,21,null,',reference2,','''','''',null,',lsodatos.idreference,')' ) AS mma 
from
(
select distinct fas_routines_process.idstep as idstepppp,  modelciu , fas_script_type.scriptname, fas_routines_process.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference

from fas_routines_process
inner join fas_routines_steps
on fas_routines_steps.idstep = 14
inner join products
on products.idproduct = fas_routines_process.idproduct
inner join fas_script_type
on fas_script_type.idscripttype = fas_routines_process.idscript
inner join fas_step
on fas_step.instance = fas_routines_steps.instance

where
modelciu LIKE '%BTTY%'  

) as lsodatos
inner join fas_tree_product_references
on  fas_tree_product_references.idreference = lsodatos.idreference::integer


*************************************************************************

     select 
          concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',0,16,null,',reference1,','''','''',null,',lsodatos.idreference,')' ) AS mma 
         from
         (
         select distinct  modelciu , fas_script_type.scriptname, fas_routines_process.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
          
         from fas_routines_process
         inner join fas_routines_steps
         on fas_routines_steps.idstep = fas_routines_process.idstep
         inner join products
         on products.idproduct = fas_routines_process.idproduct
         inner join fas_script_type
         on fas_script_type.idscripttype = fas_routines_process.idscript
         inner join fas_step
         on fas_step.instance = fas_routines_steps.instance
          
         where
         modelciu LIKE '%BTTY%'  
          
         ) as lsodatos
         inner join fas_tree_product_references
         on  fas_tree_product_references.idreference = lsodatos.idreference::integer
         where fas_stepname = 'AcceptBBU_Check_Alarm_AnnunciatorCommunication_OFF'
         union
              select 
          concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',0,23,null,',reference1,','''','''',null,',lsodatos.idreference,')' ) AS mma 
         from
         (
         select distinct  modelciu , fas_script_type.scriptname, fas_routines_process.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
          
         from fas_routines_process
         inner join fas_routines_steps
         on fas_routines_steps.idstep = fas_routines_process.idstep
         inner join products
         on products.idproduct = fas_routines_process.idproduct
         inner join fas_script_type
         on fas_script_type.idscripttype = fas_routines_process.idscript
         inner join fas_step
         on fas_step.instance = fas_routines_steps.instance
          
         where
         modelciu LIKE '%BTTY%'  
          
         ) as lsodatos
         inner join fas_tree_product_references
         on  fas_tree_product_references.idreference = lsodatos.idreference::integer
         where fas_stepname = 'AcceptBBU_Check_PowerStress'
         union
              select 
          concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',0,24,null,',reference2,','''','''',null,',lsodatos.idreference,')' ) AS mma 
         from
         (
         select distinct  modelciu , fas_script_type.scriptname, fas_routines_process.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
          
         from fas_routines_process
         inner join fas_routines_steps
         on fas_routines_steps.idstep = fas_routines_process.idstep
         inner join products
         on products.idproduct = fas_routines_process.idproduct
         inner join fas_script_type
         on fas_script_type.idscripttype = fas_routines_process.idscript
         inner join fas_step
         on fas_step.instance = fas_routines_steps.instance
          
         where
         modelciu LIKE '%BTTY%'  
          
         ) as lsodatos
         inner join fas_tree_product_references
         on  fas_tree_product_references.idreference = lsodatos.idreference::integer
         where fas_stepname = 'AcceptBBU_Check_PowerStress'
         union
              select 
          concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',0,25,null,',reference3,','''','''',null,',lsodatos.idreference,')' ) AS mma 
         from
         (
         select distinct  modelciu , fas_script_type.scriptname, fas_routines_process.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
          
         from fas_routines_process
         inner join fas_routines_steps
         on fas_routines_steps.idstep = fas_routines_process.idstep
         inner join products
         on products.idproduct = fas_routines_process.idproduct
         inner join fas_script_type
         on fas_script_type.idscripttype = fas_routines_process.idscript
         inner join fas_step
         on fas_step.instance = fas_routines_steps.instance
          
         where
         modelciu LIKE '%BTTY%'  
          
         ) as lsodatos
         inner join fas_tree_product_references
         on  fas_tree_product_references.idreference = lsodatos.idreference::integer
         where fas_stepname = 'AcceptBBU_Check_PowerStress'
         union
              select 
          concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',0,13,null,',reference4,','''','''',null,',lsodatos.idreference,')' ) AS mma 
         from
         (
         select distinct  modelciu , fas_script_type.scriptname, fas_routines_process.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
          
         from fas_routines_process
         inner join fas_routines_steps
         on fas_routines_steps.idstep = fas_routines_process.idstep
         inner join products
         on products.idproduct = fas_routines_process.idproduct
         inner join fas_script_type
         on fas_script_type.idscripttype = fas_routines_process.idscript
         inner join fas_step
         on fas_step.instance = fas_routines_steps.instance
          
         where
         modelciu LIKE '%BTTY%'  
          
         ) as lsodatos
         inner join fas_tree_product_references
         on  fas_tree_product_references.idreference = lsodatos.idreference::integer
         where fas_stepname = 'AcceptBBU_Check_PowerStress'
         union
              select 
          concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',0,21,null,',reference5,','''','''',null,',lsodatos.idreference,')' ) AS mma 
         from
         (
         select distinct  modelciu , fas_script_type.scriptname, fas_routines_process.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
          
         from fas_routines_process
         inner join fas_routines_steps
         on fas_routines_steps.idstep = fas_routines_process.idstep
         inner join products
         on products.idproduct = fas_routines_process.idproduct
         inner join fas_script_type
         on fas_script_type.idscripttype = fas_routines_process.idscript
         inner join fas_step
         on fas_step.instance = fas_routines_steps.instance
          
         where
         modelciu LIKE '%BTTY%'  
          
         ) as lsodatos
         inner join fas_tree_product_references
         on  fas_tree_product_references.idreference = lsodatos.idreference::integer
         where fas_stepname = 'AcceptBBU_Check_PowerStress'
         union
              select 
          concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',0,26,null,',reference6,','''','''',null,',lsodatos.idreference,')' ) AS mma 
         from
         (
         select distinct  modelciu , fas_script_type.scriptname, fas_routines_process.* ,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idreference' as idreference
          
         from fas_routines_process
         inner join fas_routines_steps
         on fas_routines_steps.idstep = fas_routines_process.idstep
         inner join products
         on products.idproduct = fas_routines_process.idproduct
         inner join fas_script_type
         on fas_script_type.idscripttype = fas_routines_process.idscript
         inner join fas_step
         on fas_step.instance = fas_routines_steps.instance
          
         where
         modelciu LIKE '%BTTY%'  
          
         ) as lsodatos
         inner join fas_tree_product_references
         on  fas_tree_product_references.idreference = lsodatos.idreference::integer
         where fas_stepname = 'AcceptBBU_Check_PowerStress'

*****************************************************************************
relay mejorado
          select  
          concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,11,null,null,null,null,',relay1::text,',',lsodatos.idrelays,')' ) AS mma 
          from
         (
         select distinct  modelciu , fas_routines_process.idproduct,fas_routines_process.idscript , fas_script_type.scriptname,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idrelays' as idrelays
         
           
         from fas_routines_process
         inner join fas_routines_steps
         on fas_routines_steps.idstep = fas_routines_process.idstep
         inner join products
         on products.idproduct = fas_routines_process.idproduct
         inner join fas_script_type
         on fas_script_type.idscripttype = fas_routines_process.idscript 
         inner join fas_step
         on fas_step.instance = fas_routines_steps.instance
          
         where modelciu LIKE '%BTTY%'   
          
         ) as lsodatos
            inner join fas_autotest_states
              on fas_autotest_states.idrelays		=	 lsodatos.idrelays::integer 
         union
            select  
          concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,12,null,null,null,null,',relay2::text,',',lsodatos.idrelays,')' ) AS mma 
          from
         (
         select distinct  modelciu , fas_routines_process.idproduct,fas_routines_process.idscript , fas_script_type.scriptname,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idrelays' as idrelays
         
           
         from fas_routines_process
         inner join fas_routines_steps
         on fas_routines_steps.idstep = fas_routines_process.idstep
         inner join products
         on products.idproduct = fas_routines_process.idproduct
         inner join fas_script_type
         on fas_script_type.idscripttype = fas_routines_process.idscript 
         inner join fas_step
         on fas_step.instance = fas_routines_steps.instance
          
         where modelciu LIKE '%BTTY%'   
          
         ) as lsodatos
            inner join fas_autotest_states
              on fas_autotest_states.idrelays		=	 lsodatos.idrelays::integer 
          union
            select  
          concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,13,null,null,null,null,',relay3::text,',',lsodatos.idrelays,')' ) AS mma 
          from
         (
         select distinct  modelciu , fas_routines_process.idproduct,fas_routines_process.idscript , fas_script_type.scriptname,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idrelays' as idrelays
         
           
         from fas_routines_process
         inner join fas_routines_steps
         on fas_routines_steps.idstep = fas_routines_process.idstep
         inner join products
         on products.idproduct = fas_routines_process.idproduct
         inner join fas_script_type
         on fas_script_type.idscripttype = fas_routines_process.idscript 
         inner join fas_step
         on fas_step.instance = fas_routines_steps.instance
          
         where modelciu LIKE '%BTTY%'   
          
         ) as lsodatos
            inner join fas_autotest_states
              on fas_autotest_states.idrelays		=	 lsodatos.idrelays::integer 
              union
            select  
          concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,14,null,null,null,null,',relay4::text,',',lsodatos.idrelays,')' ) AS mma 
          from
         (
         select distinct  modelciu , fas_routines_process.idproduct,fas_routines_process.idscript , fas_script_type.scriptname,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idrelays' as idrelays
         
           
         from fas_routines_process
         inner join fas_routines_steps
         on fas_routines_steps.idstep = fas_routines_process.idstep
         inner join products
         on products.idproduct = fas_routines_process.idproduct
         inner join fas_script_type
         on fas_script_type.idscripttype = fas_routines_process.idscript 
         inner join fas_step
         on fas_step.instance = fas_routines_steps.instance
          
         where modelciu LIKE '%BTTY%'   
          
         ) as lsodatos
            inner join fas_autotest_states
              on fas_autotest_states.idrelays		=	 lsodatos.idrelays::integer 
         union
            select  
          concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,15,null,null,null,null,',relay5::text,',',lsodatos.idrelays,')' ) AS mma 
          from
         (
         select distinct  modelciu , fas_routines_process.idproduct,fas_routines_process.idscript , fas_script_type.scriptname,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idrelays' as idrelays
         
           
         from fas_routines_process
         inner join fas_routines_steps
         on fas_routines_steps.idstep = fas_routines_process.idstep
         inner join products
         on products.idproduct = fas_routines_process.idproduct
         inner join fas_script_type
         on fas_script_type.idscripttype = fas_routines_process.idscript 
         inner join fas_step
         on fas_step.instance = fas_routines_steps.instance
          
         where modelciu LIKE '%BTTY%'   
          
         ) as lsodatos
            inner join fas_autotest_states
              on fas_autotest_states.idrelays		=	 lsodatos.idrelays::integer 
         
         union
            select  
          concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,16,null,null,null,null,',relay6::text,',',lsodatos.idrelays,')' ) AS mma 
          from
         (
         select distinct  modelciu , fas_routines_process.idproduct,fas_routines_process.idscript , fas_script_type.scriptname,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idrelays' as idrelays
         
           
         from fas_routines_process
         inner join fas_routines_steps
         on fas_routines_steps.idstep = fas_routines_process.idstep
         inner join products
         on products.idproduct = fas_routines_process.idproduct
         inner join fas_script_type
         on fas_script_type.idscripttype = fas_routines_process.idscript 
         inner join fas_step
         on fas_step.instance = fas_routines_steps.instance
          
         where modelciu LIKE '%BTTY%'   
          
         ) as lsodatos
            inner join fas_autotest_states
              on fas_autotest_states.idrelays		=	 lsodatos.idrelays::integer 
         
          ************************************************
             
          select  
          concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,11,null,null,null,null,',relay1::text,',',lsodatos.idrelays,')' ) AS mma 
          from
         (
         select distinct  modelciu , fas_routines_process.idproduct,fas_routines_process.idscript , fas_script_type.scriptname,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idrelays' as idrelays
         
           
         from fas_routines_process
         inner join fas_routines_steps
         on fas_routines_steps.idstep = fas_routines_process.idstep
         inner join products
         on products.idproduct = fas_routines_process.idproduct
         inner join fas_script_type
         on fas_script_type.idscripttype = fas_routines_process.idscript 
         inner join fas_step
         on fas_step.instance = fas_routines_steps.instance
          
         where iduniquebranchsonprod like '%000100370041%' 
          
         ) as lsodatos
            inner join fas_autotest_states
              on fas_autotest_states.idrelays		=	 lsodatos.idrelays::integer 
         union
            select  
          concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,12,null,null,null,null,',relay2::text,',',lsodatos.idrelays,')' ) AS mma 
          from
         (
         select distinct  modelciu , fas_routines_process.idproduct,fas_routines_process.idscript , fas_script_type.scriptname,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idrelays' as idrelays
         
           
         from fas_routines_process
         inner join fas_routines_steps
         on fas_routines_steps.idstep = fas_routines_process.idstep
         inner join products
         on products.idproduct = fas_routines_process.idproduct
         inner join fas_script_type
         on fas_script_type.idscripttype = fas_routines_process.idscript 
         inner join fas_step
         on fas_step.instance = fas_routines_steps.instance
          
         where iduniquebranchsonprod like '%000100370041%' 
          
         ) as lsodatos
            inner join fas_autotest_states
              on fas_autotest_states.idrelays		=	 lsodatos.idrelays::integer 
          union
            select  
          concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,13,null,null,null,null,',relay3::text,',',lsodatos.idrelays,')' ) AS mma 
          from
         (
         select distinct  modelciu , fas_routines_process.idproduct,fas_routines_process.idscript , fas_script_type.scriptname,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idrelays' as idrelays
         
           
         from fas_routines_process
         inner join fas_routines_steps
         on fas_routines_steps.idstep = fas_routines_process.idstep
         inner join products
         on products.idproduct = fas_routines_process.idproduct
         inner join fas_script_type
         on fas_script_type.idscripttype = fas_routines_process.idscript 
         inner join fas_step
         on fas_step.instance = fas_routines_steps.instance
          
         where iduniquebranchsonprod like '%000100370041%' 
          
         ) as lsodatos
            inner join fas_autotest_states
              on fas_autotest_states.idrelays		=	 lsodatos.idrelays::integer 
              union
            select  
          concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,14,null,null,null,null,',relay4::text,',',lsodatos.idrelays,')' ) AS mma 
          from
         (
         select distinct  modelciu , fas_routines_process.idproduct,fas_routines_process.idscript , fas_script_type.scriptname,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idrelays' as idrelays
         
           
         from fas_routines_process
         inner join fas_routines_steps
         on fas_routines_steps.idstep = fas_routines_process.idstep
         inner join products
         on products.idproduct = fas_routines_process.idproduct
         inner join fas_script_type
         on fas_script_type.idscripttype = fas_routines_process.idscript 
         inner join fas_step
         on fas_step.instance = fas_routines_steps.instance
          
         where iduniquebranchsonprod like '%000100370041%' 
          
         ) as lsodatos
            inner join fas_autotest_states
              on fas_autotest_states.idrelays		=	 lsodatos.idrelays::integer 
         union
            select  
          concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,15,null,null,null,null,',relay5::text,',',lsodatos.idrelays,')' ) AS mma 
          from
         (
         select distinct  modelciu , fas_routines_process.idproduct,fas_routines_process.idscript , fas_script_type.scriptname,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idrelays' as idrelays
         
           
         from fas_routines_process
         inner join fas_routines_steps
         on fas_routines_steps.idstep = fas_routines_process.idstep
         inner join products
         on products.idproduct = fas_routines_process.idproduct
         inner join fas_script_type
         on fas_script_type.idscripttype = fas_routines_process.idscript 
         inner join fas_step
         on fas_step.instance = fas_routines_steps.instance
          
         where iduniquebranchsonprod like '%000100370041%' 
          
         ) as lsodatos
            inner join fas_autotest_states
              on fas_autotest_states.idrelays		=	 lsodatos.idrelays::integer 
         
         union
            select  
          concat('call sp_insert_fas_income_integral(',lsodatos.idproduct,',',lsodatos.idscript,',''',lsodatos.instance,''',4,16,null,null,null,null,',relay6::text,',',lsodatos.idrelays,')' ) AS mma 
          from
         (
         select distinct  modelciu , fas_routines_process.idproduct,fas_routines_process.idscript , fas_script_type.scriptname,fas_routines_steps.instance ,fas_step.description as fas_stepname , fas_routines_steps.parameters->>'idrelays' as idrelays
         
           
         from fas_routines_process
         inner join fas_routines_steps
         on fas_routines_steps.idstep = fas_routines_process.idstep
         inner join products
         on products.idproduct = fas_routines_process.idproduct
         inner join fas_script_type
         on fas_script_type.idscripttype = fas_routines_process.idscript 
         inner join fas_step
         on fas_step.instance = fas_routines_steps.instance
          
               where iduniquebranchsonprod like '%000100370041%' 
          
         ) as lsodatos
            inner join fas_autotest_states
              on fas_autotest_states.idrelays		=	 lsodatos.idrelays::integer 
         
          
         
          ************************************************
	
          select 	concat('call sp_insert_fas_income_integral(',losprodbbtty.idproduct,',22,''',ssss.instance,''',4,11,null,null,null,null,',relay1::text,',',ssss.idrelays,')' ) AS mma 
          from 
          (
            select distinct idproduct
           from fas_routines_process		 
          where idscript = 22  
          
          ) as losprodbbtty
          left join 
          (
            select fas_routines_steps.parameters->>'idrelays' as idrelays,
            instance
            from fas_routines_steps where idstep = 39
          ) as ssss
          on ssss.instance <> losprodbbtty.idproduct::TEXt
         inner join fas_autotest_states
                    on fas_autotest_states.idrelays		=	 ssss.idrelays::integer 
        union 
          select 	concat('call sp_insert_fas_income_integral(',losprodbbtty.idproduct,',22,''',ssss.instance,''',4,12,null,null,null,null,',relay2::text,',',ssss.idrelays,')' ) AS mma 
          from 
          (
            select distinct idproduct
           from fas_routines_process		 
          where idscript = 22  
          
          ) as losprodbbtty
          left join 
          (
            select fas_routines_steps.parameters->>'idrelays' as idrelays,
            instance
            from fas_routines_steps where idstep = 39
          ) as ssss
          on ssss.instance <> losprodbbtty.idproduct::TEXt
         inner join fas_autotest_states
                    on fas_autotest_states.idrelays		=	 ssss.idrelays::integer 
          
            union 
          select 	concat('call sp_insert_fas_income_integral(',losprodbbtty.idproduct,',22,''',ssss.instance,''',4,13,null,null,null,null,',relay3::text,',',ssss.idrelays,')' ) AS mma 
          from 
          (
            select distinct idproduct
           from fas_routines_process		 
          where idscript = 22  
          
          ) as losprodbbtty
          left join 
          (
            select fas_routines_steps.parameters->>'idrelays' as idrelays,
            instance
            from fas_routines_steps where idstep = 39
          ) as ssss
          on ssss.instance <> losprodbbtty.idproduct::TEXt
         inner join fas_autotest_states
                    on fas_autotest_states.idrelays		=	 ssss.idrelays::integer 
                union 
          select 	concat('call sp_insert_fas_income_integral(',losprodbbtty.idproduct,',22,''',ssss.instance,''',4,14,null,null,null,null,',relay4::text,',',ssss.idrelays,')' ) AS mma 
          from 
          (
            select distinct idproduct
           from fas_routines_process		 
          where idscript = 22  
          
          ) as losprodbbtty
          left join 
          (
            select fas_routines_steps.parameters->>'idrelays' as idrelays,
            instance
            from fas_routines_steps where idstep = 39
          ) as ssss
          on ssss.instance <> losprodbbtty.idproduct::TEXt
         inner join fas_autotest_states
                    on fas_autotest_states.idrelays		=	 ssss.idrelays::integer 
                union 
          select 	concat('call sp_insert_fas_income_integral(',losprodbbtty.idproduct,',22,''',ssss.instance,''',4,15,null,null,null,null,',relay5::text,',',ssss.idrelays,')' ) AS mma 
          from 
          (
            select distinct idproduct
           from fas_routines_process		 
          where idscript = 22  
          
          ) as losprodbbtty
          left join 
          (
            select fas_routines_steps.parameters->>'idrelays' as idrelays,
            instance
            from fas_routines_steps where idstep = 39
          ) as ssss
          on ssss.instance <> losprodbbtty.idproduct::TEXt
         inner join fas_autotest_states
                    on fas_autotest_states.idrelays		=	 ssss.idrelays::integer 
               union 
          select 	concat('call sp_insert_fas_income_integral(',losprodbbtty.idproduct,',22,''',ssss.instance,''',4,16,null,null,null,null,',relay6::text,',',ssss.idrelays,')' ) AS mma 
          from 
          (
            select distinct idproduct
           from fas_routines_process		 
          where idscript = 22  
          
          ) as losprodbbtty
          left join 
          (
            select fas_routines_steps.parameters->>'idrelays' as idrelays,
            instance
            from fas_routines_steps where idstep = 39
          ) as ssss
          on ssss.instance <> losprodbbtty.idproduct::TEXt
         inner join fas_autotest_states
                    on fas_autotest_states.idrelays		=	 ssss.idrelays::integer 
         
                    *******************************************************
     select 	concat('call sp_insert_fas_income_integral(',losprodbbtty.idproduct,',22,''',ssss.instance,''',0,13,null,',reference1,',null,null,null,',ssss.idreference,')' ) AS mma 
            from 
            (
              select distinct idproduct
             from fas_routines_process		 
            where idscript = 22  
            
            ) as losprodbbtty
            left join 
            (
              select fas_routines_steps.parameters->>'idreference' as idreference,
              instance
              from fas_routines_steps where idstep = 38
            ) as ssss
            on ssss.instance <> losprodbbtty.idproduct::TEXt
           inner join fas_tree_product_references
                      on fas_tree_product_references.idreference		=	 ssss.idreference::integer  
                union
                select 	concat('call sp_insert_fas_income_integral(',losprodbbtty.idproduct,',22,''',ssss.instance,''',0,21,null,',reference2,',null,null,null,',ssss.idreference,')' ) AS mma 
            from 
            (
              select distinct idproduct
             from fas_routines_process		 
            where idscript = 22  
            
            ) as losprodbbtty
            left join 
            (
              select fas_routines_steps.parameters->>'idreference' as idreference,
              instance
              from fas_routines_steps where idstep = 38
            ) as ssss
            on ssss.instance <> losprodbbtty.idproduct::TEXt
           inner join fas_tree_product_references
                      on fas_tree_product_references.idreference		=	 ssss.idreference::integer  
          union 
          
            
          select 	concat('call sp_insert_fas_income_integral(',losprodbbtty.idproduct,',22,''',ssss.instance,''',0,17,null,',reference1,',null,null,null,',ssss.idreference,')' ) AS mma 
            from 
            (
              select distinct idproduct
             from fas_routines_process		 
            where idscript = 22  
            
            ) as losprodbbtty
            left join 
            (
              select fas_routines_steps.parameters->>'idreference' as idreference,
              instance
              from fas_routines_steps where idstep = 39
            ) as ssss
            on ssss.instance <> losprodbbtty.idproduct::TEXt
           inner join fas_tree_product_references
                      on fas_tree_product_references.idreference		=	 ssss.idreference::integer  
                union
                select 	concat('call sp_insert_fas_income_integral(',losprodbbtty.idproduct,',22,''',ssss.instance,''',0,21,null,',reference2,',null,null,null,',ssss.idreference,')' ) AS mma 
            from 
            (
              select distinct idproduct
             from fas_routines_process		 
            where idscript = 22  
            
            ) as losprodbbtty
            left join 
            (
              select fas_routines_steps.parameters->>'idreference' as idreference,
              instance
              from fas_routines_steps where idstep = 39
            ) as ssss
            on ssss.instance <> losprodbbtty.idproduct::TEXt
           inner join fas_tree_product_references
                      on fas_tree_product_references.idreference		=	 ssss.idreference::integer  
                      ****************************************************************
                      
                      SELECT   concat('call sp_insert_fas_income_integral_sinref(',idproduct,',21,''0520BF0C00C1'',0,26,0,10800,null,null,null,null)' ) AS mma 
                      FROM fnt_select_allproducts_maxrev() as pproducts
                        where iduniquebranchsonprod like '%000100370039%' and modelciu like 'DH14%'
                    and idproduct in (select idproduct from products_attributes where idattribute = 0)
               union
                   SELECT   concat('call sp_insert_fas_income_integral_sinref(',idproduct,',21,''0520BF0C00C1'',0,21,0,3,null,null,null,null)' ) AS mma 
                
                       FROM fnt_select_allproducts_maxrev() as pproducts
                        where iduniquebranchsonprod like '%000100370039%' and modelciu like 'DH14%'
                    and idproduct in (select idproduct from products_attributes where idattribute = 0)
               union
                   SELECT   concat('call sp_insert_fas_income_integral_sinref(',idproduct,',21,''0520BF0C00C1'',0,27,0,50,null,null,null,null)' ) AS mma 
                
                       FROM fnt_select_allproducts_maxrev() as pproducts
                        where iduniquebranchsonprod like '%000100370039%' and modelciu like 'DH14%'
                    and idproduct in (select idproduct from products_attributes where idattribute = 0)
                
                    

                    ----------------------- MAS BTTY 216 - 217 fijo
                    
select distinct concat(aaa, fas_routines_process.idproduct,b)  as elque
from fas_routines_process
inner join products
on products.idproduct = fas_routines_process.idproduct
inner join 
(
	
select 'call sp_insert_fas_income_integral(' as aaa,',22,"09B09C09E",4,5,217,null,'','',null,217)' as b
			  
union 
select 'call sp_insert_fas_income_integral(' as aaa,',22,"09B09C09D",4,5,216,null,'','',null,216)' as b
union
select 'call sp_insert_fas_income_integral(' as aaa,',22,"09B09C09E",4,11,null,null,null,null,TRUE,217)' as b
union
select 'call sp_insert_fas_income_integral(' as aaa,',22,"09B09C09D",4,11,null,null,null,null,TRUE,216)' as b
union
select 'call sp_insert_fas_income_integral(' as aaa,',22,"09B09C09E",4,12,null,null,null,null,false,217)' as b
union
select 'call sp_insert_fas_income_integral(' as aaa,',22,"09B09C09D",4,12,null,null,null,null,false,216)' as b
union
select 'call sp_insert_fas_income_integral(' as aaa,',22,"09B09C09E",4,13,null,null,null,null,false,217)' as b
union
select 'call sp_insert_fas_income_integral(' as aaa,',22,"09B09C09D",4,13,null,null,null,null,false,216)' as b
union
select 'call sp_insert_fas_income_integral(' as aaa,',22,"09B09C09E",4,14,null,null,null,null,false,217)' as b
union
select 'call sp_insert_fas_income_integral(' as aaa,',22,"09B09C09D",4,14,null,null,null,null,false,216)' as b
union
select 'call sp_insert_fas_income_integral(' as aaa,',22,"09B09C09E",4,15,null,null,null,null,false,217)' as b
union
select 'call sp_insert_fas_income_integral(' as aaa,',22,"09B09C09D",4,15,null,null,null,null,false,216)' as b
union
select 'call sp_insert_fas_income_integral(' as aaa,',22,"09B09C09E",4,16,null,null,null,null,false,217)' as b
union
select 'call sp_insert_fas_income_integral(' as aaa,',22,"09B09C09D",4,16,null,null,null,null,false,216)' as b
) as losins
on losins.b <>modelciu
where 
modelciu LIKE '%BTTY%'  and 1239 <> fas_routines_process.idproduct
 
 
 
          */


          $fp = fopen("fichero.txt", "r");

while(!feof($fp)) {

$linea = fgets($fp);

echo "Run:". $linea . "<br />";


  
        //  $sql = $connect->prepare("");

          //$sql = $connect->prepare($linea.";");     
          $sql = $connect->prepare($linea);     
   //$sql = $connect->prepare(" select ".$linea);     
       $sql->execute();
       echo "s:<br>";
     //   $resultado = $sql->fetchAll();
      // $return_arr = array();
       $mmm=0;
}

                        /*
"AcceptBBU_Check_PwrSourceVoltage" (2 REF) 09B09F0AD - reference1 - (double)  (0-13) // reference2 - (double)  (0-21)
"AcceptBBU_Check_Current" 09B09F0AE - (2 REF) - reference1 - (double)  (0-17) // reference2 - (double)  (0-21)
"AcceptBBU_Check_Voltage" 09B09F0A0  (4 REF)  - reference1 - (double)  (0-23) // reference2 - (double)  (0-13) // reference3 - (double)  (0-21) // reference4 - (double)  (0-16)
"AcceptBBU_Check_Alarm_BDA_OFF"  09B09F0A10AF - (1 REF)- reference1 - (double)  (0-16)
"AcceptBBU_Check_Alarm_SystemComponentsFail_OFF" 09B09F0A10B0 (1 REF) - reference1 - (double)  (0-16)
"AcceptBBU_Check_Alarm_BatteryCapacity_OFF"  09B09F0A10B1 (1 REF) - reference1 - (double)  (0-16)
"AcceptBBU_Check_Alarm_FirePanel_OFF" 09B09F0A10B2 -(1 REF) reference1 - (double)  (0-16)
"AcceptBBU_Check_Alarm_BDA_ON" 09B09F0A10A2 -(1 REF) reference1 - (double)  (0-16)
"AcceptBBU_Check_Alarm_SystemComponentsFail_ON" - 09B09F0A10A5 -(1 REF) reference1 - (double)  (0-16)
"AcceptBBU_Check_Alarm_BatteryCapacity_ON" 09B09F0A10A6- (1 REF) reference1 - (double)  (0-16)
"AcceptBBU_Check_Alarm_FirePanel_ON" 09B09F0A10A7 (1 REF)- reference1 - (double)  (0-16)
"AcceptBBU_Check_Alarm_AC_ON" - 09B09F0A10A3- (1 REF) reference1 - (double)  (0-16)
"AcceptBBU_Check_Alarm_AC_OFF" - 09B09F0A10A4 (1 REF)- reference1 - (double)  (0-16)	



**AcceptBBU_Calibration_PwrSourceVoltage (09B09C09D) (3 REF) //idstep = 13//   --  reference1 - double (0,13) // reference2 - double (0,21) //  // reference3 - double (0,22)
**AcceptBBU_Calibration_Current (09B09C09E) (2 REF) //idstep = 14//--  --  reference1 - double (0,13) // reference2 - double (0,21) //

**AcceptBBU_Check_Alarm_AnnunciatorCommunication_OFF (09B09F0A10B7) (1 REF) --  reference1 - double (0,16) 
**AcceptBBU_Check_PowerStress (09B09F0B8) (6 REF) --  reference1 - double (0,23) //  reference2 - double (0,24) // reference3 - double (0,25) /  reference4 - double (0,13) // reference5 - double (0,21) // reference6 - double (0,26) //



                               */
    
    /*   foreach ($resultado as $row) 
       {
         echo  $mmm."-Exec:".$row['mma']."<br>";
         $mmm =  $mmm + 1;
                $sqlmma = $connect->prepare($row['mma'].";");
                $sqlmma->execute();

       }*/
          
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
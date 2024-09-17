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
		<style>
	
body
{
	  font-family: Arial, Helvetica, sans-serif;
	      background:#eee;		  
  font-size:12px;
  font-size:12px;
}
.tree
{ 
    margin: 6px;
    margin-left: -35px;
}

.tree li {
    list-style-type:none;
    margin:0;
    padding:6px 5px 0 5px;
    position:relative
}
.tree li::before, 
.tree li::after {
    content:'';
    left:-20px;
    position:absolute;
    right:auto
}
.tree li::before {
    border-left:1px solid #000;
    bottom:50px;
    height:100%;
    top:0;
    width:1px
}
.tree li::after {
    border-top:1px solid #000;
    height:20px;
    top:25px;
    width:25px
}

.tree li span {
    -moz-border-radius:5px;
    -webkit-border-radius:5px;
    border:1px solid #000;
    border-radius:1px;
    display:inline-block;
    padding:1px 5px;
    text-decoration:none;
    cursor:pointer;
}
.tree>ul>li::before,
.tree>ul>li::after {
    border:0
}
.tree li:last-child::before {
    height:27px
}


textarea.form-controlm {
	    display: block;
    width: 100%;
    height: calc(2.25rem + 2px);
    padding: .375rem .75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: .25rem;
    box-shadow: inset 0 0 0 transparent;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    height: 238px;
    font-size: 13px;

}

.btn-smm {
    display: inline-block;
    font-weight: 400;
    color: #212529;
    text-align: center;
    vertical-align: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-color: transparent;
    border: 1px solid transparent;
    padding: .375rem .75rem;
     font-size: 10px;
    line-height: 1.5;
    border-radius: .25rem;

}

</style>

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
 
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link rel="stylesheet" href="css/dropzone.css" type="text/css">
	
	
    <link rel="stylesheet" href="cssfiplex.css">
	<link rel="stylesheet" href="css/bootstrap-datetimepicker2.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="js/jquery2-2-4.min.js"></script>
	<script src="js/jquery-ui.min.js"></script>
	<script src="js/jquery.plugin.min.js"></script>
  <script src="js/jquery.countdown.js"></script>
	
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
            <h1><a href="ticketmanagerfiplex.php">Ticket Manager</a></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Ticket Manager</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


  
  
  <!-- inicia pagina -->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        
        <!-- Timelime example  -->
        <div class="row">
		<section class="col-lg-2 connectedSortable ui-sortable">
				
				  <div class="card" name="" id="" style="display">
				  <br>  
				  <div class="container input-group input-group-sm">
				  <br>
					<input class="form-control form-control-navbar" id="searcquickmm" name="searcquickmm" value="<?php echo $_REQUEST['qs'];?>" type="search" placeholder="Search" aria-label="Search">
					<div class="input-group-append">
					  <button class="btn btn-navbar" type="button" onclick="send_searchquickmm()">
						<i class="fas fa-search"></i>
					  </button>
					</div>
				  </div>
	  
	  
					<br>
			 <!-- aca arbol de TK manager -->
			  <div class="tree">
						<ul>
							<li><span><a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#Web" aria-expanded="true" aria-controls="Web"><i class="collapsed"></i>
							<i class="expanded"><i class="far fa-folder-open"></i></i> Ticket tree manager by category</a></span>
							<div id="Web" class="collapse show">
							<ul>
							
							
			
			
			
			<?php	

		$iduserlogeado = $_SESSION["a"] ;	
		///|| $_SESSION["g"] == "production"
				if 	($_SESSION["g"] == "develop" || $_SESSION["g"] == "director" || $_SESSION["g"] == "calibrator"  || $_SESSION["g"] == "quality" || "csanada"==  	$_SESSION["b"]  || "h482865"==  	$_SESSION["b"]   ) 
					{
						//// only "csanada" - manager tk
						if ("csanada"==  	$_SESSION["b"]  || $_SESSION["g"] == "calibrator"  || "h482865"==  	$_SESSION["b"] || "h482865"==  	$_SESSION["b"]  || $_SESSION["g"] == "quality"   )
						{
							//echo "SIIIIIIIIIIIIII";
							$query_lista = "
							select fas_techsupport.idcategory, namecategory,  array_agg( DISTINCT coalesce( CONCAT(fas_techsupport.idtkreason,'#',replace(namereason,',','.'),'#' ),'')) as groupbutypeflia  ,count(issue) as cc

							from (
								select fas_techsupport.idfas_techsupport, max(datessupportstate) as maxdia
								from fas_techsupport
								inner join fas_techsupport_state
								on fas_techsupport.idfas_techsupport = fas_techsupport_state.idfas_techsupport
															
								group by fas_techsupport.idfas_techsupport
							) as maxestadoxtk
								inner join fas_techsupport
								on maxestadoxtk.idfas_techsupport = fas_techsupport.idfas_techsupport
									left join fas_techsupport_reason
							on fas_techsupport_reason.idtechsupport_reason = fas_techsupport.idtkreason
								inner join fas_techsupport_state
								on maxestadoxtk.idfas_techsupport = fas_techsupport_state.idfas_techsupport and
								maxestadoxtk.maxdia = fas_techsupport_state.datessupportstate 
								inner join fas_techsupport_category_byuserfas
								on fas_techsupport_category_byuserfas.idtechsupport_category =   fas_techsupport.idcategory  
								
								inner join fas_techsupport_typestate
								on fas_techsupport_typestate.idtypestate = fas_techsupport_state.idstatesupport	
								left join userfas
								on userfas.iduserfas = fas_techsupport_state.idusersupport
								inner join fas_techsupport_category
								on fas_techsupport_category.idtechsupport_category = fas_techsupport.idcategory
								and fas_techsupport_category.active = 'Y' and fas_techsupport.idcategory <> 3
								inner join business_area
								on business_area.idbusiness  = fas_techsupport.idbusiness and 
								business_area.idarea =  fas_techsupport.idarea
								where fas_techsupport_typestate.idtypestate <> 3 and fas_techsupport_category_byuserfas.iduserfas				 = ".$iduserlogeado."
									
							group by fas_techsupport.idcategory, namecategory
													order by namecategory ";
						}
						else
						{

							$query_lista = "
							select fas_techsupport.idcategory, namecategory,  array_agg( DISTINCT coalesce( CONCAT(fas_techsupport.idtkreason,'#',replace(namereason,',','.'),'#' ),'')) as groupbutypeflia  ,count(issue) as cc

							from (
								select fas_techsupport.idfas_techsupport, max(datessupportstate) as maxdia
								from fas_techsupport
								inner join fas_techsupport_state
								on fas_techsupport.idfas_techsupport = fas_techsupport_state.idfas_techsupport
															
								group by fas_techsupport.idfas_techsupport
							) as maxestadoxtk
								inner join fas_techsupport
								on maxestadoxtk.idfas_techsupport = fas_techsupport.idfas_techsupport
									left join fas_techsupport_reason
							on fas_techsupport_reason.idtechsupport_reason = fas_techsupport.idtkreason
								inner join fas_techsupport_state
								on maxestadoxtk.idfas_techsupport = fas_techsupport_state.idfas_techsupport and
								maxestadoxtk.maxdia = fas_techsupport_state.datessupportstate 
								inner join fas_techsupport_category_byuserfas
								on fas_techsupport_category_byuserfas.idtechsupport_category =   fas_techsupport.idcategory   
							
								inner join fas_techsupport_typestate
								on fas_techsupport_typestate.idtypestate = fas_techsupport_state.idstatesupport	
								left join userfas
								on userfas.iduserfas = fas_techsupport_state.idusersupport
								inner join fas_techsupport_category
								on fas_techsupport_category.idtechsupport_category = fas_techsupport.idcategory
								and fas_techsupport_category.active = 'Y' and fas_techsupport.idcategory <> 3
								inner join business_area
								on business_area.idbusiness  = fas_techsupport.idbusiness and 
								business_area.idarea =  fas_techsupport.idarea
								where fas_techsupport_typestate.idtypestate <> 3 and 	fas_techsupport_category_byuserfas.iduserfas				 = ".$iduserlogeado."
									
							group by fas_techsupport.idcategory, namecategory
													order by namecategory ";

						}
					
					}
				else					
				{
								$query_lista = "select fas_techsupport.idcategory, namecategory,  array_agg( DISTINCT coalesce( CONCAT(fas_techsupport_typestate.idtypestate,'#',replace(issue,',','.'),'#',fas_techsupport.idfas_techsupport ),'')) as groupbutypeflia  ,count(issue) as cc
	from (
		select fas_techsupport.idfas_techsupport, max(datessupportstate) as maxdia
		from fas_techsupport
		inner join fas_techsupport_state
		on fas_techsupport.idfas_techsupport = fas_techsupport_state.idfas_techsupport
		inner join fas_techsupport_category_byuserfas 
		on fas_techsupport_category_byuserfas.idtechsupport_category = fas_techsupport.idcategory 

							where fas_techsupport.userreported = '".$_SESSION["b"]."' or fas_techsupport.iduserto	= ".$_SESSION["a"]."   OR fas_techsupport_category_byuserfas.iduserfas =  ".$_SESSION["a"]." 	
		group by fas_techsupport.idfas_techsupport
	) as maxestadoxtk
		inner join fas_techsupport
		on maxestadoxtk.idfas_techsupport = fas_techsupport.idfas_techsupport
			left join fas_techsupport_reason
	on fas_techsupport_reason.idtechsupport_reason = fas_techsupport.idtkreason
		inner join fas_techsupport_state
		on maxestadoxtk.idfas_techsupport = fas_techsupport_state.idfas_techsupport and
		maxestadoxtk.maxdia = fas_techsupport_state.datessupportstate 
		inner join fas_techsupport_category_byuserfas
		on fas_techsupport_category_byuserfas.idtechsupport_category =   fas_techsupport.idcategory  
		
		inner join fas_techsupport_typestate
		on fas_techsupport_typestate.idtypestate = fas_techsupport_state.idstatesupport	
		left join userfas
		on userfas.iduserfas = fas_techsupport_state.idusersupport
		inner join fas_techsupport_category
		on fas_techsupport_category.idtechsupport_category = fas_techsupport.idcategory
		and fas_techsupport_category.active = 'Y' and fas_techsupport.idcategory <> 3
		inner join business_area
		on business_area.idbusiness  = fas_techsupport.idbusiness and 
		business_area.idarea =  fas_techsupport.idarea
	
		 AND fas_techsupport.idcategory <> 3
		and ( fas_techsupport.userreported = '".$_SESSION["b"]."' or fas_techsupport.iduserto	= ".$_SESSION["a"]." OR fas_techsupport_category_byuserfas.iduserfas				 = ".$iduserlogeado."  )
	
	group by fas_techsupport.idcategory, namecategory
							order by namecategory ";
				}
												//	echo $query_lista;									   
													$data = $connect->query($query_lista)->fetchAll();		

						$search  = array('{', '}','"');
						$replace = array('', '','');

							//	echo $query_lista;									   
						$data = $connect->query($query_lista)->fetchAll();		

						


						$temonombretypeaccep="";
						$iddatos=0;
							//echo  $query_lista;
							foreach ($data as $row) 
							{
								?>
								<li><span><a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#folder<?php echo $iddatos;?>" aria-expanded="false" aria-controls="folder<?php echo $iddatos;?>"><i class="collapsed"></i>
		
								<?php
								
												
											
												$bgclass="bg-secondary";
												  $bgclass="bg-warning";
											
												 
									//Antes de mostrar pregunto si tiene mas ramas.
								?>
								<i class="expanded"><i class="fa fa-inbox"></i></i> <?php echo $row['namecategory']." [".$row['cc']."]";  ?>
							</a> -  <a href="ticketmanagerfiplex.php?idc=<?php echo $row['idcategory']; ?>&n=<?php echo $row['namecategory']; ?>"><i class="far fa-eye"></i>
							 </a> </span>	
							
						 
									<?php 
									$lasclassdelarbol="";
									$lossn = $array = explode(",", $row['groupbutypeflia']);
									if ( count($lossn) >0)
									{
									?>
									<ul><div id="folder<?php echo $iddatos;?>" class="collapse marcoopen">
									<?php
										for($i = 0; $i < count($lossn); $i++){
											$porciones = explode("#",  $lossn[$i]);
											$lasclassdelarbol="";
											if (str_replace($search, $replace, $porciones[0])==1)
											{
												$lasclassdelarbol="btn btn-outline-danger btn-sm texto10";
											}
											if (str_replace($search, $replace, $porciones[0])!=1)
											{
												$lasclassdelarbol="btn btn-outline-warning btn-sm texto10";
											}
										
											echo "<li class='treemm'><span class=''>";
										
										  //	echo ''.substr(str_replace($search, $replace, $porciones[1]),0,70).' --	<a href="#" >'.' 8<i class="far fa-eye"></i> </a>';
											//	echo "</span>";
											echo ''.substr(str_replace($search, $replace, $porciones[1]),0,70).' </a> -';
										?>
										<a href="ticketmanagerfiplex.php?idc=<?php echo $row['idcategory']; ?>&idr=<?php echo str_replace($search, $replace, $porciones[0]); ?>&n=<?php echo $row['namecategory']." - ".str_replace($search, $replace, $porciones[1]); ?>"><i class="far fa-eye"></i>
										<?php
											echo "</a></span>";
											?>
									
											<?php
											echo "</li>";
											//echo "<li class='treemm'><span><button class='btn btn-sm' onclick='mostrar_calibrarion(this.value)' value='".str_replace($search, $replace, $lossn[$i])."'> SN:".  str_replace($search, $replace, $lossn[$i])."</button></span></li>";
											
											echo "</li>";
										}
										echo "</div></ul>";
									}
									
									?>
							</li> 
								<?php	
								$iddatos = $iddatos + 1 ;
								
							}
							?>
		
		    
   
							
							
							</ul>
							</div>
							</li>	
						</ul>    
					</div>
			   
			
				
		
				<!-- fin aca tree -->
			  <!-- fin inicio arbol -->
			  <!--fin arbol tk manager -->
			     </div>
	
			
		 </section>
          <section class="col-lg-10 connectedSortable ui-sortable">

          	<div class="card">
              <div class="card-header border-transparent">
				<div class="card">
				    <div class="card-header border-transparent">
							 <h3 class="card-title">Tech Support FAS - Operations
							 <?php if ($_REQUEST['idc'] !='') {?>
							 :: Category filter applied: <?php echo $_REQUEST['n']; }
										if ($_REQUEST['qs'] !='') {?>
							 :: Quick search by keyword: <?php echo $_REQUEST['qs']; }							 ?>
					</h3>
					&nbsp;&nbsp;&nbsp; <a href="#" onclick="mostrar_todo_ticket()" style="color:#0053a1;"><span id="mostrartdo" name="mostrartdo"><i class='far fa-eye'></i> View all</span></a>
                <div class="card-tools">
                    <p class="text-right">
					    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="collapsed" aria-expanded="false">
                          <b> <i class='fas fa-pencil-alt'></i>&nbsp; Create ticket</b> 
                        </a>
					  </p>
                </div>
              </div>
			    </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
			  
			  
			  
			    <div id="accordion">
                  <!-- we are adding the .class so bootstrap.js collapse plugin detects it -->
                  <div class="container">
                   
                    <div id="collapseOne" class="panel-collapse collapse in">
                      <div class="">
					  
					  
					  
					  
								<div class="card card-info">
								
								<!-- /.card-header -->
								<!-- form start -->
								<form class="form-horizontal">
								<div class="card-body">
								<div class="form-group row">
								<label for="inputEmail3" class="col-sm-2 col-form-label">Category:</label>
								<div class="col-sm-10">
								
									<input type="hidden" id="tstuser" name="tstuser" value="<?php echo $_SESSION["b"];?>">
										
												<div class="row">
												<div class="col-sm-6">
												
													<select id='idtipoproblemagroup' name='idtipoproblemagroup' onchange="filtrarcmb(this.value)" class='form-control form-control-sm'>
													<option value=''> - Select - </option>
												<?php
												$idbusiness=	$_SESSION["i"];
												  $sql = $connect->prepare("	select distinct grouper,ARRAY_AGG (idfas_techsupport_category) as arrayid  from fas_techsupport_category 
				inner join fas_techsupport_category_business 
				on fas_techsupport_category_business.idfas_techsupport_category = fas_techsupport_category.idtechsupport_category 
				where fas_techsupport_category.active = 'Y' and fas_techsupport_category_business.idbusiness= ".$idbusiness." group by grouper  order by grouper");
				 
														$sql->execute();
														$resultado3 = $sql->fetchAll();
														foreach ($resultado3 as $row2) 
														 {
															
														 ?>
														 <option value="<?php echo  $row2['arrayid']; ?>">
														 <?php echo  $row2['grouper']; ?>
														 </option>
														 <?php
														 }
														 
												?>
													</select>
															
												</div>
												<div class="col-sm-6">
												
														<select id='idtipoproblema' name='idtipoproblema' class='form-control form-control-sm'>
										<option value=''> - Select - </option>
									<?php
									$idbusiness=	$_SESSION["i"];
									  $sql = $connect->prepare("	select fas_techsupport_category.* from fas_techsupport_category 
	inner join fas_techsupport_category_business 
	on fas_techsupport_category_business.idfas_techsupport_category = fas_techsupport_category.idtechsupport_category 
	where fas_techsupport_category.active = 'Y' and fas_techsupport_category_business.idbusiness= ".$idbusiness." order by namecategory");
	 
											$sql->execute();
											$resultado3 = $sql->fetchAll();
											foreach ($resultado3 as $row2) 
											 {
												
											 ?>
											 <option value="<?php echo  $row2['idtechsupport_category']."#".$row2['iduserfastorepor']; ?>">
											 <?php echo  $row2['namecategory']; ?>
											 </option>
											 <?php
											 }
											 
									?>
										</select>
								</div>
												
												</div>
												</div>
										
										
									
								</div>
								<div class="form-group row">
								<label for="inputEmail3" class="col-sm-2 col-form-label">Reason:</label>
								<div class="col-sm-10">
									
										<select id='cmbreason' name='cmbreason' class='form-control form-control-sm'>
										<option value=''> - Select - </option>
									<?php
									$idbusiness=	$_SESSION["i"];
									  $sql = $connect->prepare("	select  * from fas_techsupport_reason where active = 'Y' order by namereason");
	 
											$sql->execute();
											$resultado3 = $sql->fetchAll();
											foreach ($resultado3 as $row2) 
											 {
												
											 ?>
											 <option value="<?php echo  $row2['idtechsupport_reason']; ?>">
											 <?php echo  $row2['namereason']; ?>
											 </option>
											 <?php
											 }
											 
									?>
										</select>
								</div>
								
								</div>
									<div class="form-group row">
								<label for="inputPassword3" class="col-sm-2 col-form-label">Deadline: </label>
								<div class="col-sm-10">
								   <input type='text' class="form-control form-control-sm" id='datetimepicker1' />
								   
								   
								   
								</div>
								</div>
								
								<div class="form-group row">
								<label for="inputPassword3" class="col-sm-2 col-form-label">Document Name: </label>
								<div class="col-sm-10">
									<input id='txtdocname' name='txtdocname' class="form-control form-control-sm" type="text" placeholder="Document Name">
								</div>
								</div>

									<div class="form-group row">
								<label for="inputPassword3" class="col-sm-2 col-form-label">CIU: </label>
								<div class="col-sm-10">
									<input id='txtwordsquick' name='txtwordsquick' class="form-control form-control-sm" type="text" placeholder="CIU">
								</div>
								</div>
								
								<div class="form-group row">
								<label for="inputPassword3" class="col-sm-2 col-form-label">Issue: </label>
								<div class="col-sm-10">
									<textarea class="form-controlm" rows="3" id='txtissue' name='txtissue'  placeholder="Message ..."></textarea>
								</div>
								</div>
									<div class="form-group row">
								<label for="inputPassword3" class="col-sm-2 col-form-label">Attached: </label>
								<div class="col-sm-10">
									   <div class="container">
										<div class="dropzone dz-clickable" id="myDrop">
											<div class="dz-default dz-message" data-dz-message="">
												<span>Drop files here to upload</span>
											</div>
										</div>
										<input type="button" id="add_file" value="add to ticket" class="btn btn-block btn-outline-primary btn-xs float-right d-none">
										<?php 
										
										$psswdtkkey = substr( md5(microtime()), 1, 8);

										
										?>
										<input type="hidden" name="tkkeymarco" id="tkkeymarco" value="<?php echo  $psswdtkkey; ?>">
									</div>
								</div>
								</div>
								
									<div class="form-group row">
								<label for="inputPassword3"  class="col-sm-2 col-form-label">Associate this tickect with an execution of the FAS (Idruninfo)?: </label>
								<div class="col-sm-10">
									<input class="form-control form-control-sm" id='txttkidruninfo' name='txttkidruninfo'  type="text" placeholder="Idruninfo">
								</div>
								</div>
								
							
								</div>
								<!-- /.card-body -->
								<div class="card-footer">
								
								<button type="button" onclick="createtksupport()" class="btn btn-block btn-outline-primary btn-xs float-right">Create Ticket</button>
								</div>
								<!-- /.card-footer -->
								</form>
								</div>
			
					
               
                      </div>
                    </div>
                  </div>
                  
                </div>
			  
			  
			  
			  
                <div class="table table-sm table-responsive table-bordered texto10">
                  <table class="table m-0">
                    <thead  class="thead-dark">
                    <tr>
					 <th>#</th> 
                      <th>Order ID</th>
					  <th>Reason</th>
					  <th>Category</th>
                      <th>Issue</th>
                      <th>Status</th>
                      <th width="80px">DateTime</th>
					   <th width="80px">Deadline</th>
					  <th>Ticket By</th>
					   <th>Area - Business</th>
					  <th>User Support</th>
					 
                    </tr>
                    </thead>
                    <tbody>
					<?php 
					//echo $_SESSION["g"];
					

					 
						////h482865 -> estefany.arocha@honeywell.com

					if 	($_SESSION["g"] == "develop" || $_SESSION["g"] == "director"  || $_SESSION["g"] == "calibrator"  || $_SESSION["g"] == "production" ||  $_SESSION["g"] == "quality" || "csanada"==  	$_SESSION["b"] || "h482865"==  	$_SESSION["b"]    ) 
					{
						
									$sumowhere ="";
									if($_REQUEST['idc']!="")
									{
											$sumowhere =" where fas_techsupport.idcategory=".$_REQUEST['idc'];
									}
									if($_REQUEST['qs']!="")
									{
											$sumowhere =" where keywordref like '%".$_REQUEST['qs']."%' ";
									}
									if($_REQUEST['idr']!="")
									{
											$sumowhere =$sumowhere." and  fas_techsupport.idtkreason =  ".$_REQUEST['idr']." ";
									}
									$wherecsanada="";
									if ("csanada"==  	$_SESSION["b"] || "h482865"==  	$_SESSION["b"] ||  $_SESSION["g"] == "quality"  || $_SESSION["g"] == "calibrator"   )
									{
										 $wherecsanada="  and fas_techsupport.idcategory <> 3";
									}
						
						
						
									$sql = "	select distinct now() as ff,  fas_techsupport.*,fas_techsupport_typestate.*, userfas.username, namecategory, namearea, userfas_to.username as usernametoaa, userfas_to.nameuserfas as usernameto, userfas_to_history.nameuserfas as usernametohistory,fas_techsupport_messages.idfas_techsupport as hacechat, namereason, age(now(),deadline)  as resta
													from (
														select fas_techsupport.idfas_techsupport, max(datessupportstate) as maxdia
														from fas_techsupport
														inner join fas_techsupport_state
														on fas_techsupport.idfas_techsupport = fas_techsupport_state.idfas_techsupport
																			
														group by fas_techsupport.idfas_techsupport
													) as maxestadoxtk
														inner join fas_techsupport
														on maxestadoxtk.idfas_techsupport = fas_techsupport.idfas_techsupport
																left join fas_techsupport_reason
													on fas_techsupport_reason.idtechsupport_reason = fas_techsupport.idtkreason
														inner join fas_techsupport_state
														on maxestadoxtk.idfas_techsupport = fas_techsupport_state.idfas_techsupport and
														maxestadoxtk.maxdia = fas_techsupport_state.datessupportstate 
														inner join fas_techsupport_typestate
														on fas_techsupport_typestate.idtypestate = fas_techsupport_state.idstatesupport	
														inner join fas_techsupport_category_byuserfas
														on fas_techsupport_category_byuserfas.idtechsupport_category =   fas_techsupport.idcategory  
														
														left join userfas
														on userfas.iduserfas = fas_techsupport_state.idusersupport
														left join userfas as userfas_to
														on userfas_to.iduserfas = fas_techsupport.iduserto
														left join userfas as userfas_to_history
														on userfas_to_history.iduserfas = fas_techsupport_state.idusertohistory
														inner join fas_techsupport_category
														on fas_techsupport_category.idtechsupport_category = fas_techsupport.idcategory
														and fas_techsupport_category.active = 'Y' and fas_techsupport.idcategory <> 3  ".$wherecsanada."
														inner join business_area
														on business_area.idbusiness  = fas_techsupport.idbusiness and 
														business_area.idarea =  fas_techsupport.idarea
														left join fas_techsupport_messages
														on fas_techsupport_messages.idfas_techsupport = fas_techsupport.idfas_techsupport 
														".$sumowhere."
																			order by priority asc, datereported desc , namecategory, issue
													";

												//	echo "a".$sql ;
					}
						else
					{
							$sumowhere ="";
						if($_REQUEST['idc']!="")
						{
								$sumowhere =" and  fas_techsupport.idcategory=".$_REQUEST['idc'];
						}
							if($_REQUEST['qs']!="")
						{
								$sumowhere =" and  keywordref like '%".$_REQUEST['qs']."%' ";
						}
						if($_REQUEST['idr']!="")
						{
								$sumowhere =$sumowhere." and  fas_techsupport.idtkreason =  ".$_REQUEST['idr']." ";
						}
						
						
						
							// Filtrado x userlogin
							$sql = "	select distinct now() as ff, fas_techsupport.*,fas_techsupport_typestate.*, userfas.username , namecategory, namearea,  userfas_to.username as usernametoaa, userfas_to.nameuserfas as usernameto, userfas_to_history.nameuserfas as usernametohistory, fas_techsupport_messages.idfas_techsupport as hacechat, namereason, age(now(),deadline)  as resta
								from (
									select fas_techsupport.idfas_techsupport, max(datessupportstate) as maxdia
									from fas_techsupport
									inner join fas_techsupport_state
									on fas_techsupport.idfas_techsupport = fas_techsupport_state.idfas_techsupport
									inner join fas_techsupport_category_byuserfas 
									on fas_techsupport_category_byuserfas.idtechsupport_category = fas_techsupport.idcategory 
									where  fas_techsupport_state.idstatesupport	<>3 AND fas_techsupport.userreported = '".$_SESSION["b"]."' or fas_techsupport.iduserto	= ".$_SESSION["a"]."   OR fas_techsupport_category_byuserfas.iduserfas =  ".$_SESSION["a"]."  				
									group by fas_techsupport.idfas_techsupport
								) as maxestadoxtk
									inner join fas_techsupport
									on maxestadoxtk.idfas_techsupport = fas_techsupport.idfas_techsupport
											left join fas_techsupport_reason
								on fas_techsupport_reason.idtechsupport_reason = fas_techsupport.idtkreason
									inner join fas_techsupport_state
									on maxestadoxtk.idfas_techsupport = fas_techsupport_state.idfas_techsupport and
									maxestadoxtk.maxdia = fas_techsupport_state.datessupportstate 
									inner join fas_techsupport_category_byuserfas
									on fas_techsupport_category_byuserfas.idtechsupport_category =   fas_techsupport.idcategory  
									
									inner join fas_techsupport_typestate
									on fas_techsupport_typestate.idtypestate = fas_techsupport_state.idstatesupport	
								
									inner join fas_techsupport_category
									on fas_techsupport_category.idtechsupport_category = fas_techsupport.idcategory
									and fas_techsupport_category.active = 'Y'
									inner join business_area
									on business_area.idbusiness  = fas_techsupport.idbusiness and 
									business_area.idarea =  fas_techsupport.idarea
									left join userfas
									on userfas.iduserfas = fas_techsupport_state.idusersupport
									left join userfas as userfas_to
									on userfas_to.iduserfas = fas_techsupport.iduserto
									left join userfas as userfas_to_history
									on userfas_to_history.iduserfas = fas_techsupport_state.idusertohistory
										left join fas_techsupport_messages
									on fas_techsupport_messages.idfas_techsupport = fas_techsupport.idfas_techsupport 
									
									where fas_techsupport.idcategory <> 3 AND (  fas_techsupport.userreported = '".$_SESSION["b"]."' OR fas_techsupport_category_byuserfas.iduserfas				 = ".$iduserlogeado."  or fas_techsupport.iduserto	= ".$_SESSION["a"].") ".$sumowhere."  		
														order by priority asc, datereported desc , namecategory, issue
								";
						}
						
						/*
						conect cloud
						*/
						
					
					//		echo "a:".$sql;
								$resultsupport = $connect->query($sql)->fetchAll();
						$idcontador=0;
		
							foreach ($resultsupport as $rowdatos) {
								$classmm="";
								if ($rowdatos['idtypestate']==3)
								{
								$classmm="d-none";	
								}
								?>
								 <tr class="<?php echo $rowdatos['nameclass']." ".$classmm; ?>">
								   <th>
									<?php if ($rowdatos['idgrouper'] >0 && $rowdatos['idtypestate']==7) { ?>
												<a href="#" onclick="openfilatable(<?php echo  $rowdatos['idgrouper']; ?>)"><i class='fas fa-share-square' style='font-size:16px'></i></i>
									<?php } ?>
								  </th>
								  <th><a href="#" onclick="openpopupframe(<?php echo  $rowdatos['idfas_techsupport']; ?>)"><?php echo $rowdatos['idfas_techsupport']; ?> <i class='far fa-eye'></i>

									<?php if ($rowdatos['hacechat'] >0) { echo '<i class="far fa-comments"></i> ';}?>
								  </a></th>
								 
								 <th><?php echo $rowdatos['namereason'] 	;   ?></th>
									<th><?php echo $rowdatos['namecategory'] 	;   ?> 
									
									</th>
								 <th><?php 
										if($rowdatos['idtypestate']==7)
										{
										//	usernameto
										echo "TK Delegate to:".$rowdatos['usernametohistory']."<br>";
										}
										if($rowdatos['idtypestate']==8)
										{
										//	usernameto
										echo "TK Resend to :".$rowdatos['usernametohistory']."<br>";
										}
										echo substr($rowdatos['issue'],0,100);  
										$dateff=date_create($rowdatos['datereported']);


//echo "<br>NOW:".$rowdatos['ff']."<br>"; 
//echo "FCR :".$rowdatos['deadline']."<br> "; 
//echo "Resta :".$rowdatos['resta']."<br> "; 
$porcionresta = explode(".", $rowdatos['resta']);
$posicion_coincidencia = strpos($porcionresta[0], "d");

$porcionresdia = explode(" ",$porcionresta[0]);
 if ($posicion_coincidencia === false) 
 {
$porcionreshoras = explode(":",$porcionresdia[0]);
 }
 else
 {
	$porcionreshoras = explode(":",$porcionresdia[2]); 
 }
//echo "eldia:".$porcionresta[0]."<br>";
//echo $porcionresdia[0]."<br>";
//echo "hr".$porcionreshoras[2]."<br>";
//echo "hr".$porcionreshoras[0]."<br>";
										?></th>
								  <th><?php echo $rowdatos['namestate']; ?></th> 
								  <th><?php echo date_format($dateff, 'm-d-Y')."&nbsp;<br>".date_format($dateff, 'H:i:s'); ?>&nbsp;</th>
								  <th> 
									<?php if($rowdatos['deadline'] <> null )  
									{
										if($rowdatos['deadline'] < $rowdatos['ff'] ) 
										{
										//	echo $rowdatos['deadline']	;
											$dateffdeadline=date_create($rowdatos['deadline']);
											if($rowdatos['idtypestate']!=3)
											{
											echo "<span class='text-danger'>".date_format($dateffdeadline, 'm-d-Y')."&nbsp;<br>".date_format($dateffdeadline, 'H:i:s')."</span>";
											}
											else
											{
												echo "".date_format($dateffdeadline, 'm-d-Y')."&nbsp;<br>".date_format($dateffdeadline, 'H:i:s')."";
											}
										}	
										else
										{
	
										
										?>
										<div id="defaultCountdown<?php echo $idcontador;  ?>"></div>
									<script type="text/javascript">
									<?php  if ($posicion_coincidencia === false) { ?>
									$('#defaultCountdown<?php echo $idcontador;  ?>').countdown({until: '<?php echo abs($porcionreshoras[0])."h ".$porcionreshoras[1]."m";  ?>', compact: true,});
									<?php } else { ?>
									$('#defaultCountdown<?php echo $idcontador;  ?>').countdown({until: '<?php echo abs($porcionresdia[0])."d ".abs($porcionreshoras[0])."h ".$porcionreshoras[1]."m";  ?>', compact: true,});
									<?php } ?>
										
									</script>
										<?php
										}
									}										
										?>
									
									</th>
								  <th><?php 
$idcontador = $idcontador + 1;
									if (  strlen($rowdatos['userreported'])==0)
									{
										echo  ".".$rowdatos['username']; 
									}
									else
								{
									echo $rowdatos['userreported']; 
								}
								 ?></th>
								   <th><?php echo $rowdatos['namearea']; ?></th>
								  <th><?php if ( $rowdatos['usernametoaa']  !="") { echo  $rowdatos['usernametoaa'] ;  } else { echo $rowdatos['username']; } ?></th>
								</tr>
								<?php
								$tieneqagrupar = 'N';
								if ( $rowdatos['idtypestate']==7)
								{
									$tieneqagrupar = 'S';
								}
								if ( $rowdatos['idtypestate']==9)
								{
								//	$tieneqagrupar = 'S';
								}
							
								
								if ($tieneqagrupar == 'S')
								{
									//Busca info del TK reenviado
									$sql2 = "select distinct fas_techsupport.*,fas_techsupport_typestate.*, userfas.username , namecategory, namearea, userfas_to.username as usernameto2username, userfas_to.nameuserfas as usernameto, fas_techsupport_messages.idfas_techsupport as hacechat
									from fas_techsupport 	inner join fas_techsupport_state
		on fas_techsupport.idfas_techsupport = fas_techsupport_state.idfas_techsupport
		inner join fas_techsupport_typestate
		on fas_techsupport_typestate.idtypestate = fas_techsupport_state.idstatesupport	
		inner join fas_techsupport_category
		on fas_techsupport_category.idtechsupport_category = fas_techsupport.idcategory
		inner join business_area
		on business_area.idbusiness  = fas_techsupport.idbusiness and 
		business_area.idarea =  fas_techsupport.idarea
		left join userfas
		on userfas.iduserfas = fas_techsupport_state.idusersupport
		left join userfas as userfas_to
		on userfas_to.iduserfas = fas_techsupport.iduserto
			left join fas_techsupport_messages
		on fas_techsupport_messages.idfas_techsupport = fas_techsupport.idfas_techsupport 
		where fas_techsupport.idfas_techsupport = ".$rowdatos['idgrouper'];
	//	echo $sql2;
									$resultsupporttkreasign = $connect->query($sql2)->fetchAll();
						
		
										foreach ($resultsupporttkreasign as $rowdatosreasign)
										{
									?>
									 <tr id="tknro<?php echo $rowdatos['idgrouper']; ?>" name="tknro<?php echo $rowdatos['idgrouper']; ?>" class="<?php echo $rowdatos['nameclass']." ".$classmm." d-none"; ?>">
									  <th></th>
								  <th><a href="#" onclick="openpopupframe(<?php echo  $rowdatos['idgrouper']; ?>)"><?php echo $rowdatos['idgrouper']; ?> <i class='far fa-eye'></i>

									<?php if ($rowdatosreasign['hacechat'] >0) { echo '<i class="far fa-comments"></i> ';}?>
								  </a></th>
								 
									<th><?php echo $rowdatosreasign['namecategory'] 	;   ?></th>
								 <th><?php 
										if($rowdatosreasign['idtypestate']==7)
										{
										//	usernameto
										echo "TK Delegate to:".$rowdatosreasign['usernameto']."<br>";
										}
										if($rowdatosreasign['idtypestate']==8)
										{
										//	usernameto
										echo "TK Resend to :".$rowdatosreasign['usernameto']."<br>";
										}
										echo $rowdatosreasign['issue'];  $dateff=date_create($rowdatosreasign['datereported']);  ?></th>
								  <th><?php echo $rowdatosreasign['namestate']; ?></th>
								  <th><?php echo date_format($dateff, 'm-d-Y')."&nbsp;<br>".date_format($dateff, 'H:i:s'); ?>&nbsp;</th>
								  <th><?php echo $rowdatos['userreported']; ?></th>
								   <th><?php echo $rowdatosreasign['namearea']; ?></th>
								  <th><?php echo $rowdatosreasign['usernameto2username']; ?></th>
								  
								   <th><?php echo $rowdatosreasign['usernameto2username']; ?></th>
								    <th><?php echo $rowdatosreasign['usernameto2username']; ?></th>
								</tr>
									<?php
										}
								}
							}

					?>
                   
                   
                    </tbody>
                  </table>
                </div>
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
  <!-- fin pagina -->
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

<!-- jQuery -->

  
    <script src="js/popperparacalibratio.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <script src="js/dropzone.js"></script>
 <!--  <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js222" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" /> -->
	

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
 <script src="js/eModal.min.js" type="text/javascript" />
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>

<script type="text/javascript" src="js/tabulator.min.js"></script>
<script type="text/javascript" src="pushjs/bin/push.js"></script>
  <script src="js/bootstrap-datetimepicker.min.js"></script>
  </style>


 
</body>

<script type="text/javascript">

   
   
	$( document ).ready(function() {
		


/*
Push.create("WEBAS Notifications!", {
    body: "have a new support ticket",
    icon: 'img/fiplexcirculo-01.png',
    timeout: 40000,
    onClick: function () {
        window.focus();
        this.close();
    }
});
*/


 //// Levanto datos. de jsqon
 
 /* $('#datetimepicker1').datetimepicker( {   todayBtn: "linked",
   todayHighlight : true,
   orientation: "left",
   autoclose: true }  );
*/
////////////////////////////////////////////////////////
		$('#datetimepicker1').datetimepicker(  {
     minDate: new Date()
});
/////////////////////////////////////////////////////
			
var austDay = new Date();
var austDay2 = new Date();
	austDay = new Date( austDay.getFullYear()+1, 1 - 1, 26);
//	$('#defaultCountdown0').countdown({until: '+50d', compact: true,});
//	$('#defaultCountdown1').countdown({until: '+1d', compact: true, });
//	$('#defaultCountdown2').countdown({until: '+2m', compact: true, });

			
	});
	

	
		$(function() {
			  $("#myDrop").sortable({
				items: '.dz-preview',
				cursor: 'move',
				opacity: 0.5,
				containment: '#myDrop',
				distance: 20,
				tolerance: 'pointer',
			  });
		 
			  $("#myDrop").disableSelection();
			});
			 
			//Dropzone script
			Dropzone.autoDiscover = false;
			 
			var myDropzone = new Dropzone("div#myDrop", 
			{ 
				 paramName: "files", // The name that will be used to transfer the file
				 addRemoveLinks: true,
				 uploadMultiple: true,
				 autoProcessQueue: false,
				 parallelUploads: 50,
				 maxFilesize: 5, // MB
				 acceptedFiles: ".png, .jpeg, .jpg, .gif",
				 url: "ajaxinsert_supportitbyarea.php?tkkey="+$('#tkkeymarco').val(),
			});
			 
			myDropzone.on("sending", function(file, xhr, formData) {
			  var filenames = [];
			   
			  $('.dz-preview .dz-filename').each(function() {
				filenames.push($(this).find('span').text());
			  });
			 
			  formData.append('filenames', filenames);
			
			});
			 
			/* Add Files Script*/
			myDropzone.on("success", function(file, message){
				$("#msg").html(message);
				toastr["warning"]("attaching file, please wait ", "");	
				//setTimeout(function(){window.location.href="index.php"},200);
						//console.log('Subido 1 o todos');
			});
			  
			myDropzone.on("error", function (data) {
				 $("#msg").html('<div class="alert alert-danger">There is some thing wrong, Please try again!</div>');
			});
			  
			   myDropzone.on("queuecomplete", function (file) {
					//console.log('queuecomplete:Subido 1 o todos');
					
					idlog_view2=$("#txttkidruninfo").val();
				if(idlog_view2 =="")
				{
					idlog_view2=0;
				}
				input=$("#txtissue").val();
				txtquickkey=$("#txtwordsquick").val();
				txttkkeyref=$("#tkkeymarco").val();
				txtcmbreason=$("#cmbreason").val();
			
				txtfechadealline=$("#datetimepicker1").val();
				
				userregistred=$("#tstuser").val();
				typecategory=$("#idtipoproblema").val();
					//enviamos para crear TK
						$.ajax({
						url: 'ajaxinsert_supportitbyarea.php', 				
						data: "idruninfodb="+idlog_view2+'&v_issue='+input+'-Ref:'+idlog_view2+'&vuser='+userregistred+'&tp='+typecategory+'&keyd='+txtquickkey+'&tkkey='+txttkkeyref+'&txtcmbreason='+txtcmbreason+'&txtdechadl='+txtfechadealline,					
						type: 'post',				
						datatype:'JSON',				
						cache:false,					
						success: function(data, status, xhr) {
						console.log('a verr');	
						console.log(data);
							if (data =="ok" )
							{
								toastr["success"]("Save OK!", "");	
								
								
								
								
								location.reload();
							}
							else	
							{
								toastr["error"]("Error when storing data...", "");						
							
							}
							return false;	
						
						},
						error: function(xhr, status, error) {
							 console.log(status);
						}
						});
					///fin enviamos crear tk	
					
			});
			  
			  
			myDropzone.on("complete", function(file) {
				myDropzone.removeFile(file);
			//	console.log('Subido');
			});
			  
			$("#add_file").on("click",function (){
				myDropzone.processQueue();
			});
				
	
	
	$('#tree').on("select_node.jstree", function (e, data) { 
	//alert("node_id: " + data.node.id);
	console.log(data.node.text.indexOf('cat') );
		console.log(data.node.text.indexOf('Cat') );
		if (data.node.text.indexOf('Cat') == -1 )
		{
				mostrar_datos_tktree(data.node.id.replace('a',''));
		}
		
	

	});

	// controlar inactividad en la web	
	
	// fin controlar inactividad en la web		
	function mostrar_datos_tktree(aidtk)
	{
		eModal.iframe('edittksuppor.php?idt='+aidtk,'Tech Support FAS - Ticket Manager ');
	}
	 /* requesting data */
    function openpopupframe(idtksupport)
	{
		eModal.iframe('edittksuppor.php?idt='+idtksupport,'Tech Support FAS - Ticket Manager ');
	} 		
		
	

	function createtksupport()
	{
		
		 var faltandatosflia = 0;

		if ($('#idtipoproblema').val() == '')
		{
			toastr["error"]("Error, Category is required..", "");	
			faltandatosflia = 1;
		}	
		if ($('#txtwordsquick').val() == '')
		{
			toastr["error"]("Error, Keywords for quick search is required..", "");	
			faltandatosflia = 1;
		}	
		if ($('#cmbreason').val() == '')
		{
			toastr["error"]("Error, reason is required..", "");	
			faltandatosflia = 1;
		}	
			if ($('#txtissue').val() == '')
		{
			toastr["error"]("Error, Issue is required..", "");	
			faltandatosflia = 1;
		}	
		////////
		
		if ($('idtipoproblemagroup').val() == '{12,11,15}')
		{
			if ($('#txtdocname').val() == '')
			{
				toastr["error"]("Error,Document Name is required..", "");	
				faltandatosflia = 1;
			}	
		}
		
		
		


		if  (faltandatosflia == 0)
		{
				toastr["success"]("Creating ticket, Please wait!", "");			
			
				idlog_view2=$("#txttkidruninfo").val();
				if(idlog_view2 =="")
				{
					idlog_view2=0;
				}
				input=$("#txtissue").val();
				docname = $("#txtdocname").val();
				txtquickkey=$("#txtwordsquick").val()+'|'+docname;
				

				txttkkeyref=$("#tkkeymarco").val();
				txtcmbreason=$("#cmbreason").val();
			
				txtfechadealline=$("#datetimepicker1").val();
				
				userregistred=$("#tstuser").val();
				typecategory=$("#idtipoproblema").val();

				txtwordsquick
				
				if (myDropzone.getQueuedFiles().length >0)
				{
							//attachamos y enviamos datos
							myDropzone.processQueue();
				}
				else
				{
					//enviamos para crear TK
					///RECORDAR Q TENGO 2 AJAX para envio de infoo 
					console.log('a');
						$.ajax({
						url: 'ajaxinsert_supportitbyarea.php', 				
						data: "idruninfodb="+idlog_view2+'&v_issue='+input+'-Ref:'+idlog_view2+'&vuser='+userregistred+'&tp='+typecategory+'&keyd='+txtquickkey+'&tkkey='+txttkkeyref+'&txtcmbreason='+txtcmbreason+'&txtdechadl='+txtfechadealline,					
						type: 'post',				
						datatype:'JSON',				
						cache:false,					
						success: function(data, status, xhr) {
						console.log('a verr');	
						console.log(data);
							if (data =="ok" )
							{
								toastr["success"]("Save OK!", "");	
								
								location.reload();
							}
							else	
							{
								toastr["error"]("Error when storing data...", "");						
							
							}
							return false;	
						
						},
						error: function(xhr, status, error) {
							 console.log(status);
						}
						});
				
				}
				
	
				
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
   
   function mostrar_todo_ticket()
   {
	   var losdatos="";
	   losdatos =   $("#mostrartdo").html();
	 //  $(".table-success").removeClass('d-none');
	
	   if (losdatos.indexOf("all") >= 0)
	   {
		   		$("#mostrartdo").html('<i class="fas fa-eye-slash"></i> See pending / in process');
				   $(".table-success").removeClass('d-none');
	   }
	   else
	   {
		   		$("#mostrartdo").html('<i class="far fa-eye"></i> View all');
				   $(".table-success").addClass('d-none');
	   }

	   
   }
   
	function openfilatable(idfilatk)
	{
	var estadofilatabla= 1;
		var classList = $("#tknro"+idfilatk).attr("class").split(/\s+/);
		for (var i = 0; i < classList.length; i++) {
			if (classList[i] === 'd-none') {
				//do something
				estadofilatabla = 0;
			}
		}

		if(estadofilatabla==1)
		{
			$("#tknro"+idfilatk).addClass('d-none');
		}
		else
		{
			$("#tknro"+idfilatk).removeClass('d-none');
		}
		
	}
	
	function filtrarcmb(info_to_active)
	{
		var info_slplit="";
		var datosacontrolar="";
		info_slplit = info_to_active.replace('{','');
		info_slplit = info_slplit.replace('}','');
	//	console.log(info_slplit);
		var res = info_slplit.split(",");
	
		 $("#idtipoproblema").children().hide();	
		for (var i=0; i<res.length; i++) 
		{ 
		//	console.log (res[i] ); }

		 
		 $("#idtipoproblema option").each(function (index, val) {
         //       console.log(val.value);
				datosacontrolar = val.value.split("#");
		//		console.log(datosacontrolar[0] +' -- '+res[i]);
				if(  parseInt(datosacontrolar[0]) == parseInt(res[i]))
				{
				//	$("#idtipoproblema option[value=" + datosacontrolar[0] + "]").show();
					 $("#idtipoproblema").children("option[value='"+val.value +"']").show();
					// 	console.log(datosacontrolar[0] +' -- '+res[i]);
				}
				
				
            });
			
		}
	}
	
	function send_searchquickmm()
	{
		  if ( $("#searcquickmm").val() != '')
		  {
			  // Enviamos busqueda..
			  window.location = 'ticketmanagerfiplex.php?qs='+$("#searcquickmm").val() ; 
		  }
	}
   
   $('#searcquickmm').keypress(function (e) {
    if(e.which ==13)
	{
        console.log("pressed enter");
	 if ( $("#searcquickmm").val() != '')
		  {
			  // Enviamos busqueda..
			  window.location = 'ticketmanagerfiplex.php?qs='+$("#searcquickmm").val() ; 
		  }
	}	  
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
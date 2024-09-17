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
            header("Location: http://".$ipservidorapache."/index.php?t=timeoutinactivity");
        }
    }
	else
	{
			session_unset();
            session_destroy();
            header("Location: http://".$ipservidorapache."/index.php?t=notcookietimeout");
        
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
			//exit();
		}
	/// FIN DETECTO PERMISOS EN PAG!
	
	$status = $connect->getAttribute(PDO::ATTR_CONNECTION_STATUS);
	
	if ($status !="Connection OK; waiting to send.")
	{
	
		header("Location: http://".$ipservidorapache."/".$folderservidor."/errorconect.php");
		exit;
		
	}

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
  
  
  <link href="css/tabulator_bootstrap4.css" rel="stylesheet">
  <link rel="shortcut icon" href="fiplexcirculo-01.ico" />
  
  <link rel="stylesheet" href="toastr.css">
  
 <link href="css/tabulator_bulma.css" rel="stylesheet">
 
  
    <link rel="stylesheet" href="cssfiplex.css">
	
		<style>
	body
{
  font-family: Arial, Helvetica, sans-serif;
  font-size:12px;
}
a:link {
  color:#000000;
}

a:visited {
 color:#000000;
}

a:hover {
  color:#000000;
}

a:active {
 color:#000000;
}

.card-headermarco
{
	  font-family: Arial, Helvetica, sans-serif;
  font-size:14px;
  border-style: solid;
  border-color:#ffffff;
  border-width: 1px;
}

.example1_wrapper
{
 border-style: solid; 
  border-width: 2px;	
}

textarea.form-control {
    height: 100%;
}

.responsive-iframe {
  position: absolute;
  top: 60px;
  left: 0;
  border:0;
  bottom: 0;
  right: 0;
  width: 100%;
  height: 700px;
}

.tree
{ 
    margin: 6px;
    margin-left: -40px;
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
    border-left:2px solid #000;
    bottom:50px;
    height:100%;
    top:0;
    width:1px
}
.tree li::after {
    border-top:2px solid #000;
    height:20px;
    top:25px;
    width:25px
}
.tree li span {
    -moz-border-radius:5px;
    -webkit-border-radius:5px;
    border:2px solid #000;
    border-radius:3px;
    display:inline-block;
    padding:3px 8px;
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
.tree li span:hover {
    background: #f39323;
    border:2px solid #94a0b4;
    }

[aria-expanded="false"] > .expanded,
[aria-expanded="true"] > .collapsed {
  display: none;
}

.direct-chat-img {
    border-radius: 50%;
    float: left;
    margin-top: -4px;
	
}
</style>


</head>

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


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Stock WO by CIU Family</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Stock WO</li>
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
          <section class="col-lg-3 connectedSortable ui-sortable">

            <div class="" name="divscrolllog" id="divscrolllog" style="display.">
			
			  <div class="demo-container">
										
					<?php
					$querygrafico="select distinct products.classproduct typeaccept,	 
			 coalesce(count( distinct orders_sn.wo_serialnumber),0)   as ccstock 
			from orders_sn
			inner join orders
			on orders.idorders = orders_sn.idorders
			inner join products on products.idproduct = orders_sn.idproduct 
		
			where orders.active ='Y' and orders.processfasserver = true and
			orders_sn.processfasserver = true and orders.typeregister='WO' and length(trim(wo_serialnumber)) >0 
			and orders_sn.so_associed = '' and orders_sn.availablesn = true
		
			group by typeaccept";
			
		
					
					$data = $connect->query($querygrafico)->fetchAll();	
					$tengostok=0;
				foreach ($data as $row) 
				{
					$lasfamlias=$lasfamlias."'".$row['typeaccept']."',";
					$cantxfamilia=$cantxfamilia."'".$row['ccstock']."',";					
					
					
					$tengostok=1;
					
				}
				
				if( $tengostok==0)
				{
					//echo "Out of Stock";
					?>
					<div class="alert alert-danger alert-dismissible">
                 
                  <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                 Out of Stock	
                </div>
					<?php
					//exit();
				}
					?>
					
							
						
			<p name="msjwaitline" id="msjwaitline" align="center"><img src="img/waitazul.gif" width="100px" ></p>	
				<div class="card">
				<div class="card-body">
								<div class="chart">
								<?php
								$vv=0;
									foreach ($data as $row) 
										{
											$lasfamlias=$lasfamlias."'".$row['typeaccept']."',";
											$cantxfamilia=$cantxfamilia."'".$row['ccstock']."',";	
										//	echo $row['typeaccept']." - Stock:".$row['ccstock']."<br>";		
?>
						<div class="direct-chat-msg">
                        
                        <!-- /.direct-chat-infos -->
						
						<?php if ($vv==0)
						{
							?>
							<img class="direct-chat-img" src="img/dh7Sisometric50pxx50px.png" alt="message user image">
							<?php
							$vv=1;
						}	
						else
						{
							?>
							<img class="direct-chat-img" src="img/dh7Sisometric50pxx50px.png" alt="message user image">
							<?php
							$vv=0;
						}
						?>
                        
						 
                        <!-- /.direct-chat-img -->
                        <div class="direct-chat-text colorazulfiplex">
                         <?php
						  
						  echo $row['typeaccept']." - Stock: <b>".$row['ccstock']."</b><br>";		
						  ?>
                        </div>
                        <!-- /.direct-chat-text -->
                      </div>
                          
                       
<?php											
											
										}
								?>
								
								</div>
								</div>
				<!-- aca tree				-->
				<div class="container">
				<b>Search:</b> <input type="search" name="txtacceptbusca"  onchange="filtraplacas()" id="txtacceptbusca" class="form-control form-control-sm" placeholder="Search" >
    <div class="row">
        <div class="">
		
		
		 <div class="tree ">
<ul>

<li><span><a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#Web" aria-expanded="true" aria-controls="Web"><i class="collapsed"><i class="fas fa-folder"></i></i>
<i class="expanded"><i class="far fa-folder-open"></i></i> Stock</a></span>
<div id="Web" class="collapse show">
<ul>

<?php 

if 	($_SESSION["g"] == "develop"  ) 
		{

							$query_lista = "select distinct 'DH7S-A' as typeaccept,	 
			 orders_sn.idproduct, products.modelciu, coalesce(count( distinct orders_sn.wo_serialnumber),0)   as ccstock ,array_agg( DISTINCT  coalesce(orders_sn.wo_serialnumber,'')) as groupxsn
			from orders_sn
			inner join orders
			on orders.idorders = orders_sn.idorders
			inner join products on products.idproduct = orders_sn.idproduct 
			and products.classproduct ='DH7S-A' 
			where orders.active ='Y' and orders.processfasserver = true and
			orders_sn.processfasserver = true and orders.typeregister='WO' and length(trim(wo_serialnumber)) >0 
			and orders_sn.so_associed = '' and orders_sn.availablesn = true
		
			group by typeaccept,  orders_sn.idproduct, products.modelciu
			
			";
		}
		else
		{
							$query_lista = "select distinct 'DH7S-A' as typeaccept,	 
			 orders_sn.idproduct, products.modelciu, coalesce(count( distinct orders_sn.wo_serialnumber),0)   as ccstock ,array_agg( DISTINCT  coalesce(orders_sn.wo_serialnumber,'')) as groupxsn
			from orders_sn
			inner join orders
			on orders.idorders = orders_sn.idorders
			inner join products on products.idproduct = orders_sn.idproduct 
			and products.classproduct ='DH7S-A' 
			where orders.active ='Y' and orders.processfasserver = true and
			orders_sn.processfasserver = true and orders.typeregister='WO' and length(trim(wo_serialnumber)) >0 
			and orders_sn.so_associed = '' and orders_sn.availablesn = true
			and orders_sn.wo_serialnumber not like '%DV%'
			group by typeaccept,  orders_sn.idproduct, products.modelciu
			
			";
		}
			//and orders_sn.wo_serialnumber not like '%DV%'
							//	echo $query_lista;									   
						$data = $connect->query($query_lista)->fetchAll();	
					
						if( count($data) >0)
							{
								
?>


<li><span><a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#Page2" aria-expanded="false" aria-controls="Page2"><i class="collapsed"><i class="fas fa-folder"></i></i>
<i class="expanded"><i class="far fa-folder-open"></i></i> DH7S-A</a></span>
  <ul>
	<div id="Page2" class="collapse show">
		<li><span><a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#folder1a" aria-expanded="false" aria-controls="folder1a"><i class="collapsed"><i class="fas fa-folder"></i></i>
			
			
			
			<?php		
		
							

						$search  = array('{', '}');
						$replace = array('', '');


						$temonombretypeaccep="";
							//echo  $query_lista;
							foreach ($data as $row) 
							{
												$qporc=$row['ccstock'];
											
												$bgclass="bg-secondary";
												  $bgclass="bg-warning";
												  if ($qporc < 3)
												  {
													    $bgclass="bg-danger";
												  }
											      if ($qporc >= 5)
												  {
													    $bgclass="bg-warning";
												  }
												  if ($qporc >= 10)
												  {
													    $bgclass="bg-green";
												  }
												 
									//Antes de mostrar pregunto si tiene mas ramas.
								?>
								<i class="expanded"><i class="far fa-folder-open"></i></i> <?php echo $row['modelciu'];  ?></a> <span data-toggle="tooltip" title="" class="badge <?php echo $bgclass; ?> ">										
																   <?php echo " [ ".$row['ccstock']; ?> SN ]			 
																</span> </span>
							
									<?php 
									$lossn = $array = explode(",", $row['groupxsn']);
									if ( count($lossn) >0)
									{
									?>
									<ul><div id="folder1a" class="collapse show">
									<?php
										for($i = 0; $i < count($lossn); $i++){
										//	echo "<li value='".str_replace($search, $replace, $lossn[$i])."' id='".str_replace($search, $replace, $lossn[$i])."' class='esramahijo '>SN:".  str_replace($search, $replace, $lossn[$i])." ";
											
											echo "<li class='treemm'><span><button class='btn btn-sm' onclick='mostrar_calibrarion(this.value)' value='".str_replace($search, $replace, $lossn[$i])."'> SN:".  str_replace($search, $replace, $lossn[$i])."</button></span></li>";
											echo "</li>";
										}
										
									}
									echo "</div></ul>";
									?>
								</li>
								<?php	
								
								
							}
							?>
		
		</li>     



<!-- lod  -->
				<?php	
							}				

if 	($_SESSION["g"] == "develop"  ) 
		{
							$query_lista = "select distinct 'DH7S-A' as typeaccept,	 
			 orders_sn.idproduct, products.modelciu, coalesce(count( distinct orders_sn.wo_serialnumber),0)   as ccstock ,array_agg( DISTINCT  coalesce(orders_sn.wo_serialnumber,'')) as groupxsn
			from orders_sn
			inner join orders
			on orders.idorders = orders_sn.idorders
			inner join products on products.idproduct = orders_sn.idproduct 
			and products.classproduct ='DH7S-D' 
			where orders.active ='Y' and orders.processfasserver = true and
			orders_sn.processfasserver = true and orders.typeregister='WO' and length(trim(wo_serialnumber)) >0 
			and orders_sn.so_associed = '' and orders_sn.availablesn = true
		
			group by typeaccept,  orders_sn.idproduct, products.modelciu
			
			";
		}
		else
		{
							$query_lista = "select distinct 'DH7S-A' as typeaccept,	 
			 orders_sn.idproduct, products.modelciu, coalesce(count( distinct orders_sn.wo_serialnumber),0)   as ccstock ,array_agg( DISTINCT  coalesce(orders_sn.wo_serialnumber,'')) as groupxsn
			from orders_sn
			inner join orders
			on orders.idorders = orders_sn.idorders
			inner join products on products.idproduct = orders_sn.idproduct 
			and products.classproduct ='DH7S-A' 
			where orders.active ='Y' and orders.processfasserver = true and
			orders_sn.processfasserver = true and orders.typeregister='WO' and length(trim(wo_serialnumber)) >0 
			and orders_sn.so_associed = '' and orders_sn.availablesn = true
			and orders_sn.wo_serialnumber not like '%DV%'
			group by typeaccept,  orders_sn.idproduct, products.modelciu
			
			";
		}			
			//and orders_sn.wo_serialnumber not like '%DV%'
						//		echo $query_lista;									   
							$datadd = $connect->query($query_lista)->fetchAll();	

							//echo "la cant. ".count($data);
							if( count($datadd) >0)
							{
							
							?>

<li><span><a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#Page2a" aria-expanded="false" aria-controls="Page2a"><i class="collapsed"><i class="fas fa-folder"></i></i>
<i class="expanded"><i class="far fa-folder-open"></i></i> DH7S-D</a></span>
  <ul>
	<div id="Page2a" class="collapse show">
		<li><span><a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#folder1b" aria-expanded="false" aria-controls="folder1b"><i class="collapsed"><i class="fas fa-folder"></i></i>
			
<?php

						$search  = array('{', '}');
						$replace = array('', '');


						$temonombretypeaccep="";
							//echo  $query_lista;
							foreach ($datadd as $row) 
							{
												$qporc=$row['ccstock'];
											
												$bgclass="bg-secondary";
												  $bgclass="bg-warning";
												  if ($qporc < 3)
												  {
													    $bgclass="bg-danger";
												  }
											      if ($qporc >= 5)
												  {
													    $bgclass="bg-warning";
												  }
												  if ($qporc >= 10)
												  {
													    $bgclass="bg-green";
												  }
												 
									//Antes de mostrar pregunto si tiene mas ramas.
								?>
								<i class="expanded"><i class="far fa-folder-open"></i></i> <?php echo $row['modelciu'];  ?></a> <span data-toggle="tooltip" title="" class="badge <?php echo $bgclass; ?> ">										
																   <?php echo " [ ".$row['ccstock']; ?> SN ]			 
																</span> </span>
							
									<?php 
									$lossn = $array = explode(",", $row['groupxsn']);
									if ( count($lossn) >0)
									{
									?>
									<ul><div id="folder1b" class="collapse show">
									<?php
										for($i = 0; $i < count($lossn); $i++){
										//	echo "<li value='".str_replace($search, $replace, $lossn[$i])."' id='".str_replace($search, $replace, $lossn[$i])."' class='esramahijo '>SN:".  str_replace($search, $replace, $lossn[$i])." ";
											echo "<li class='treemm'><span><button class='btn btn-sm' onclick='mostrar_calibrarion(this.value)' value='".str_replace($search, $replace, $lossn[$i])."'> SN:".  str_replace($search, $replace, $lossn[$i])."</button></span></li>";
											//echo "<li><span><i class='far fa-file'></i><a href='#!'> SN:".  str_replace($search, $replace, $lossn[$i])."</a></span></li>";
											echo "</li>";
										}
										
									}
									echo "</div></ul>";
									?>
								</li>
								<?php	
								
								
							}
							?>
							</li>
		</ul>     
     </div>
  </ul>
</li>

<!--fin lod  -->

<!-- lod DH14CA -->
<?php	
							}				

if 	($_SESSION["g"] == "develop"  ) 
		{
							$query_lista = "select distinct 'DH14CA' as typeaccept,	 
			 orders_sn.idproduct, products.modelciu, coalesce(count( distinct orders_sn.wo_serialnumber),0)   as ccstock ,array_agg( DISTINCT  coalesce(orders_sn.wo_serialnumber,'')) as groupxsn
			from orders_sn
			inner join orders
			on orders.idorders = orders_sn.idorders
			inner join products on products.idproduct = orders_sn.idproduct 
			and products.classproduct ='DH14CA' 
			where orders.active ='Y' and orders.processfasserver = true and
			orders_sn.processfasserver = true and orders.typeregister='WO' and length(trim(wo_serialnumber)) >0 
			and orders_sn.so_associed = '' and orders_sn.availablesn = true
		
			group by typeaccept,  orders_sn.idproduct, products.modelciu
			
			";
		}
		else
		{
							$query_lista = "select distinct 'DH14CA' as typeaccept,	 
			 orders_sn.idproduct, products.modelciu, coalesce(count( distinct orders_sn.wo_serialnumber),0)   as ccstock ,array_agg( DISTINCT  coalesce(orders_sn.wo_serialnumber,'')) as groupxsn
			from orders_sn
			inner join orders
			on orders.idorders = orders_sn.idorders
			inner join products on products.idproduct = orders_sn.idproduct 
			and products.classproduct ='DH14CA' 
			where orders.active ='Y' and orders.processfasserver = true and
			orders_sn.processfasserver = true and orders.typeregister='WO' and length(trim(wo_serialnumber)) >0 
			and orders_sn.so_associed = '' and orders_sn.availablesn = true
			and orders_sn.wo_serialnumber not like '%DV%'
			group by typeaccept,  orders_sn.idproduct, products.modelciu
			
			";
		}			
			//and orders_sn.wo_serialnumber not like '%DV%'
						//		echo $query_lista;									   
							$datadd = $connect->query($query_lista)->fetchAll();	

							//echo "la cant. ".count($data);
							if( count($datadd) >0)
							{
							
							?>

<li><span><a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#Page2a" aria-expanded="false" aria-controls="Page2a"><i class="collapsed"><i class="fas fa-folder"></i></i>
<i class="expanded"><i class="far fa-folder-open"></i></i>DH14CA</a></span>
  <ul>
	<div id="Page2a" class="collapse show">
		<li><span><a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#folder1b" aria-expanded="false" aria-controls="folder1b"><i class="collapsed"><i class="fas fa-folder"></i></i>
			
<?php

						$search  = array('{', '}');
						$replace = array('', '');


						$temonombretypeaccep="";
							//echo  $query_lista;
							foreach ($datadd as $row) 
							{
												$qporc=$row['ccstock'];
											
												$bgclass="bg-secondary";
												  $bgclass="bg-warning";
												  if ($qporc < 3)
												  {
													    $bgclass="bg-danger";
												  }
											      if ($qporc >= 5)
												  {
													    $bgclass="bg-warning";
												  }
												  if ($qporc >= 10)
												  {
													    $bgclass="bg-green";
												  }
												 
									//Antes de mostrar pregunto si tiene mas ramas.
								?>
								<i class="expanded"><i class="far fa-folder-open"></i></i> <?php echo $row['modelciu'];  ?></a> <span data-toggle="tooltip" title="" class="badge <?php echo $bgclass; ?> ">										
																   <?php echo " [ ".$row['ccstock']; ?> SN ]			 
																</span> </span>
							
									<?php 
									$lossn = $array = explode(",", $row['groupxsn']);
									if ( count($lossn) >0)
									{
									?>
									<ul><div id="folder1b" class="collapse show">
									<?php
										for($i = 0; $i < count($lossn); $i++){
										//	echo "<li value='".str_replace($search, $replace, $lossn[$i])."' id='".str_replace($search, $replace, $lossn[$i])."' class='esramahijo '>SN:".  str_replace($search, $replace, $lossn[$i])." ";
											echo "<li class='treemm'><span><button class='btn btn-sm' onclick='mostrar_calibrarion(this.value)' value='".str_replace($search, $replace, $lossn[$i])."'> SN:".  str_replace($search, $replace, $lossn[$i])."</button></span></li>";
											//echo "<li><span><i class='far fa-file'></i><a href='#!'> SN:".  str_replace($search, $replace, $lossn[$i])."</a></span></li>";
											echo "</li>";
										}
										
									}
									echo "</div></ul>";
									?>
								</li>
								<?php	
								
								
							}
							?>
							</li>
		</ul>     
     </div>
  </ul>
</li>

<!--fin lod DH14CA -->
<!-- lod DH14ED -->
<?php	
							}				

if 	($_SESSION["g"] == "develop"  ) 
		{
							$query_lista = "select distinct 'DH14ED' as typeaccept,	 
			 orders_sn.idproduct, products.modelciu, coalesce(count( distinct orders_sn.wo_serialnumber),0)   as ccstock ,array_agg( DISTINCT  coalesce(orders_sn.wo_serialnumber,'')) as groupxsn
			from orders_sn
			inner join orders
			on orders.idorders = orders_sn.idorders
			inner join products on products.idproduct = orders_sn.idproduct 
			and products.classproduct ='DH14ED' 
			where orders.active ='Y' and orders.processfasserver = true and
			orders_sn.processfasserver = true and orders.typeregister='WO' and length(trim(wo_serialnumber)) >0 
			and orders_sn.so_associed = '' and orders_sn.availablesn = true
		
			group by typeaccept,  orders_sn.idproduct, products.modelciu
			
			";
		}
		else
		{
							$query_lista = "select distinct 'DH14ED' as typeaccept,	 
			 orders_sn.idproduct, products.modelciu, coalesce(count( distinct orders_sn.wo_serialnumber),0)   as ccstock ,array_agg( DISTINCT  coalesce(orders_sn.wo_serialnumber,'')) as groupxsn
			from orders_sn
			inner join orders
			on orders.idorders = orders_sn.idorders
			inner join products on products.idproduct = orders_sn.idproduct 
			and products.classproduct ='DH14ED' 
			where orders.active ='Y' and orders.processfasserver = true and
			orders_sn.processfasserver = true and orders.typeregister='WO' and length(trim(wo_serialnumber)) >0 
			and orders_sn.so_associed = '' and orders_sn.availablesn = true
			and orders_sn.wo_serialnumber not like '%DV%'
			group by typeaccept,  orders_sn.idproduct, products.modelciu
			
			";
		}			
			//and orders_sn.wo_serialnumber not like '%DV%'
						//		echo $query_lista;									   
							$datadd = $connect->query($query_lista)->fetchAll();	

							//echo "la cant. ".count($data);
							if( count($datadd) >0)
							{
							
							?>

<li><span><a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#Page2a" aria-expanded="false" aria-controls="Page2a"><i class="collapsed"><i class="fas fa-folder"></i></i>
<i class="expanded"><i class="far fa-folder-open"></i></i>DH14ED</a></span>
  <ul>
	<div id="Page2a" class="collapse show">
		<li><span><a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#folder1b" aria-expanded="false" aria-controls="folder1b"><i class="collapsed"><i class="fas fa-folder"></i></i>
			
<?php

						$search  = array('{', '}');
						$replace = array('', '');


						$temonombretypeaccep="";
							//echo  $query_lista;
							foreach ($datadd as $row) 
							{
												$qporc=$row['ccstock'];
											
												$bgclass="bg-secondary";
												  $bgclass="bg-warning";
												  if ($qporc < 3)
												  {
													    $bgclass="bg-danger";
												  }
											      if ($qporc >= 5)
												  {
													    $bgclass="bg-warning";
												  }
												  if ($qporc >= 10)
												  {
													    $bgclass="bg-green";
												  }
												 
									//Antes de mostrar pregunto si tiene mas ramas.
								?>
								<i class="expanded"><i class="far fa-folder-open"></i></i> <?php echo $row['modelciu'];  ?></a> <span data-toggle="tooltip" title="" class="badge <?php echo $bgclass; ?> ">										
																   <?php echo " [ ".$row['ccstock']; ?> SN ]			 
																</span> </span>
							
									<?php 
									$lossn = $array = explode(",", $row['groupxsn']);
									if ( count($lossn) >0)
									{
									?>
									<ul><div id="folder1b" class="collapse show">
									<?php
										for($i = 0; $i < count($lossn); $i++){
										//	echo "<li value='".str_replace($search, $replace, $lossn[$i])."' id='".str_replace($search, $replace, $lossn[$i])."' class='esramahijo '>SN:".  str_replace($search, $replace, $lossn[$i])." ";
											echo "<li class='treemm'><span><button class='btn btn-sm' onclick='mostrar_calibrarion(this.value)' value='".str_replace($search, $replace, $lossn[$i])."'> SN:".  str_replace($search, $replace, $lossn[$i])."</button></span></li>";
											//echo "<li><span><i class='far fa-file'></i><a href='#!'> SN:".  str_replace($search, $replace, $lossn[$i])."</a></span></li>";
											echo "</li>";
										}
										
									}
									echo "</div></ul>";
									?>
								</li>
								<?php	
								
								
							}
							?>
							</li>
		</ul>     
     </div>
  </ul>
</li>

<!--fin lod DH14ED -->
<!-- lod DH14EA -->
<?php	
							}				

if 	($_SESSION["g"] == "develop"  ) 
		{
							$query_lista = "select distinct 'DH14EA' as typeaccept,	 
			 orders_sn.idproduct, products.modelciu, coalesce(count( distinct orders_sn.wo_serialnumber),0)   as ccstock ,array_agg( DISTINCT  coalesce(orders_sn.wo_serialnumber,'')) as groupxsn
			from orders_sn
			inner join orders
			on orders.idorders = orders_sn.idorders
			inner join products on products.idproduct = orders_sn.idproduct 
			and products.classproduct ='DH14EA' 
			where orders.active ='Y' and orders.processfasserver = true and
			orders_sn.processfasserver = true and orders.typeregister='WO' and length(trim(wo_serialnumber)) >0 
			and orders_sn.so_associed = '' and orders_sn.availablesn = true
		
			group by typeaccept,  orders_sn.idproduct, products.modelciu
			
			";
		}
		else
		{
							$query_lista = "select distinct 'DH14EA' as typeaccept,	 
			 orders_sn.idproduct, products.modelciu, coalesce(count( distinct orders_sn.wo_serialnumber),0)   as ccstock ,array_agg( DISTINCT  coalesce(orders_sn.wo_serialnumber,'')) as groupxsn
			from orders_sn
			inner join orders
			on orders.idorders = orders_sn.idorders
			inner join products on products.idproduct = orders_sn.idproduct 
			and products.classproduct ='DH14EA' 
			where orders.active ='Y' and orders.processfasserver = true and
			orders_sn.processfasserver = true and orders.typeregister='WO' and length(trim(wo_serialnumber)) >0 
			and orders_sn.so_associed = '' and orders_sn.availablesn = true
			and orders_sn.wo_serialnumber not like '%DV%'
			group by typeaccept,  orders_sn.idproduct, products.modelciu
			
			";
		}			
			//and orders_sn.wo_serialnumber not like '%DV%'
						//		echo $query_lista;									   
							$datadd = $connect->query($query_lista)->fetchAll();	

							//echo "la cant. ".count($data);
							if( count($datadd) >0)
							{
							
							?>

<li><span><a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#Page2a" aria-expanded="false" aria-controls="Page2a"><i class="collapsed"><i class="fas fa-folder"></i></i>
<i class="expanded"><i class="far fa-folder-open"></i></i>DH14EA</a></span>
  <ul>
	<div id="Page2a" class="collapse show">
		<li><span><a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#folder1b" aria-expanded="false" aria-controls="folder1b"><i class="collapsed"><i class="fas fa-folder"></i></i>
			
<?php

						$search  = array('{', '}');
						$replace = array('', '');


						$temonombretypeaccep="";
							//echo  $query_lista;
							foreach ($datadd as $row) 
							{
												$qporc=$row['ccstock'];
											
												$bgclass="bg-secondary";
												  $bgclass="bg-warning";
												  if ($qporc < 3)
												  {
													    $bgclass="bg-danger";
												  }
											      if ($qporc >= 5)
												  {
													    $bgclass="bg-warning";
												  }
												  if ($qporc >= 10)
												  {
													    $bgclass="bg-green";
												  }
												 
									//Antes de mostrar pregunto si tiene mas ramas.
								?>
								<i class="expanded"><i class="far fa-folder-open"></i></i> <?php echo $row['modelciu'];  ?></a> <span data-toggle="tooltip" title="" class="badge <?php echo $bgclass; ?> ">										
																   <?php echo " [ ".$row['ccstock']; ?> SN ]			 
																</span> </span>
							
									<?php 
									$lossn = $array = explode(",", $row['groupxsn']);
									if ( count($lossn) >0)
									{
									?>
									<ul><div id="folder1b" class="collapse show">
									<?php
										for($i = 0; $i < count($lossn); $i++){
										//	echo "<li value='".str_replace($search, $replace, $lossn[$i])."' id='".str_replace($search, $replace, $lossn[$i])."' class='esramahijo '>SN:".  str_replace($search, $replace, $lossn[$i])." ";
											echo "<li class='treemm'><span><button class='btn btn-sm' onclick='mostrar_calibrarion(this.value)' value='".str_replace($search, $replace, $lossn[$i])."'> SN:".  str_replace($search, $replace, $lossn[$i])."</button></span></li>";
											//echo "<li><span><i class='far fa-file'></i><a href='#!'> SN:".  str_replace($search, $replace, $lossn[$i])."</a></span></li>";
											echo "</li>";
										}
										
									}
									echo "</div></ul>";
									?>
								</li>
								<?php	
								
								
							}
							?>
							</li>
		</ul>     
     </div>
  </ul>
</li>

<!--fin lod DH14EA -->
<!-- lod DH14CD -->
<?php	
							}				

if 	($_SESSION["g"] == "develop"  ) 
		{
							$query_lista = "select distinct 'DH14CD' as typeaccept,	 
			 orders_sn.idproduct, products.modelciu, coalesce(count( distinct orders_sn.wo_serialnumber),0)   as ccstock ,array_agg( DISTINCT  coalesce(orders_sn.wo_serialnumber,'')) as groupxsn
			from orders_sn
			inner join orders
			on orders.idorders = orders_sn.idorders
			inner join products on products.idproduct = orders_sn.idproduct 
			and products.classproduct ='DH14CD' 
			where orders.active ='Y' and orders.processfasserver = true and
			orders_sn.processfasserver = true and orders.typeregister='WO' and length(trim(wo_serialnumber)) >0 
			and orders_sn.so_associed = '' and orders_sn.availablesn = true
		
			group by typeaccept,  orders_sn.idproduct, products.modelciu
			
			";
		}
		else
		{
							$query_lista = "select distinct 'DH14CD' as typeaccept,	 
			 orders_sn.idproduct, products.modelciu, coalesce(count( distinct orders_sn.wo_serialnumber),0)   as ccstock ,array_agg( DISTINCT  coalesce(orders_sn.wo_serialnumber,'')) as groupxsn
			from orders_sn
			inner join orders
			on orders.idorders = orders_sn.idorders
			inner join products on products.idproduct = orders_sn.idproduct 
			and products.classproduct ='DH14CD' 
			where orders.active ='Y' and orders.processfasserver = true and
			orders_sn.processfasserver = true and orders.typeregister='WO' and length(trim(wo_serialnumber)) >0 
			and orders_sn.so_associed = '' and orders_sn.availablesn = true
			and orders_sn.wo_serialnumber not like '%DV%'
			group by typeaccept,  orders_sn.idproduct, products.modelciu
			
			";
		}			
			//and orders_sn.wo_serialnumber not like '%DV%'
						//		echo $query_lista;									   
							$datadd = $connect->query($query_lista)->fetchAll();	

							//echo "la cant. ".count($data);
							if( count($datadd) >0)
							{
							
							?>

<li><span><a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#Page2a" aria-expanded="false" aria-controls="Page2a"><i class="collapsed"><i class="fas fa-folder"></i></i>
<i class="expanded"><i class="far fa-folder-open"></i></i>DH14CD</a></span>
  <ul>
	<div id="Page2a" class="collapse show">
		<li><span><a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#folder1b" aria-expanded="false" aria-controls="folder1b"><i class="collapsed"><i class="fas fa-folder"></i></i>
			
<?php

						$search  = array('{', '}');
						$replace = array('', '');


						$temonombretypeaccep="";
							//echo  $query_lista;
							foreach ($datadd as $row) 
							{
												$qporc=$row['ccstock'];
											
												$bgclass="bg-secondary";
												  $bgclass="bg-warning";
												  if ($qporc < 3)
												  {
													    $bgclass="bg-danger";
												  }
											      if ($qporc >= 5)
												  {
													    $bgclass="bg-warning";
												  }
												  if ($qporc >= 10)
												  {
													    $bgclass="bg-green";
												  }
												 
									//Antes de mostrar pregunto si tiene mas ramas.
								?>
								<i class="expanded"><i class="far fa-folder-open"></i></i> <?php echo $row['modelciu'];  ?></a> <span data-toggle="tooltip" title="" class="badge <?php echo $bgclass; ?> ">										
																   <?php echo " [ ".$row['ccstock']; ?> SN ]			 
																</span> </span>
							
									<?php 
									$lossn = $array = explode(",", $row['groupxsn']);
									if ( count($lossn) >0)
									{
									?>
									<ul><div id="folder1b" class="collapse show">
									<?php
										for($i = 0; $i < count($lossn); $i++){
										//	echo "<li value='".str_replace($search, $replace, $lossn[$i])."' id='".str_replace($search, $replace, $lossn[$i])."' class='esramahijo '>SN:".  str_replace($search, $replace, $lossn[$i])." ";
											echo "<li class='treemm'><span><button class='btn btn-sm' onclick='mostrar_calibrarion(this.value)' value='".str_replace($search, $replace, $lossn[$i])."'> SN:".  str_replace($search, $replace, $lossn[$i])."</button></span></li>";
											//echo "<li><span><i class='far fa-file'></i><a href='#!'> SN:".  str_replace($search, $replace, $lossn[$i])."</a></span></li>";
											echo "</li>";
										}
										
									}
									echo "</div></ul>";
									?>
								</li>
								<?php	
								
								
							}
							?>
							</li>
		</ul>     
     </div>
  </ul>
</li>
</div>
  </ul>
</li>
<!--fin lod DH14CD -->

<?php } ?>





</ul>
</div>
</li>
</ul>

</div>

		
         
        </div>
    </div>
</div>
				<!-- fin aca tree -->
				
					
				</div>	
				</div>
			
					

        </section>
		<section class="col-lg-9 connectedSortable ui-sortable">
		
			

				<div class="card">
				<div class="card-header ui-sortable-handle" >
				<b>Calibration Details: <label id="lblsn" name="lblsn"> <?php echo $_REQUEST['dibsn']; ?> </label><b>
				</div>	
				<br>	<br>			
               	
						
				<iframe name="iframem" id="iframem" class="responsive-iframe" src=""></iframe>
				
				
              
				
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
  
  <a href="#" class="ancla" data-ancla="anclamyTabledib"></a>
  

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
<!-- DataTables -->
<script src="<?php echo $folderservidor; ?>plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo $folderservidor; ?>plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>

<script type="text/javascript" src="js/tabulator.min.js"></script>

<script src="plugins/chart.js/Chart.min.js"></script>


<!-- Ion Slider -->
<script src="plugins/ion-rangeslider/js/ion.rangeSlider.min.js"></script>

<script type="text/javascript" src="js/tabulator.min.js"></script>
<script src="js/viewer.js"></script>



</body>

<script type="text/javascript">

  var treeview2;
   
	$( document ).ready(function() {
		
		//Inicio mostrar hora live
		 var interval = setInterval(function() {
			 
        var momentNow = moment();
			var newYork    = momentNow.tz('America/New_York').format('ha z');
			$('#date-part').html(momentNow.format('YYYY/MM/DD') 	  );
			$('#time-part').html(momentNow.format('hh:mm:ss'));
			}, 100);
		//FIN mostrar hora live
		//	console.log( "ready!" );
			$('#msjwaitline ').hide();
			$('#divscrolllog').show(); 
			$('#p-b0').hide();
			$('#p-b0').CardWidget('toggle');		
			$("#detallelog").hide();
			$("#detallelog").text("");
			$("#msjwait").hide();		


  
	 
				$("#divgeneralinfo").addClass('d-none');
				$("#divgeneralinfoparam").addClass('d-none');
				$("#divdetinfolog").addClass('d-none');
				
				$("#diveq").addClass('d-none');
				$("#divfactory").addClass('d-none');
				$("#divfinalcheck").addClass('d-none');
				$("#divgroupbyciu").addClass('d-none');
				
					$("#divgeneralinfo").removeClass('d-none');
				$("#divgeneralinfoparam").removeClass('d-none');
				$("#divdetinfolog").removeClass('d-none');

				

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

				$('#closebusqueda').show();
				$('#openbusqueda').hide();
				
				
	
    

			
			/// mostramos div de calibration
const urlParams = new URLSearchParams(window.location.search);
const vvidsndib = urlParams.get('dibsn');
console.log("hola" + vvidsndib);
	 if (vvidsndib != '')
	 {
		// $("#txtacceptbusca").val(vvidsndib);
		// filtraplacas();
		// treeview.expanded(true, [1]);
	 }

///agregamos los graficos
	/*var areaChartCanvas = $('#areaChart').get(0).getContext('2d');

 var areaChartData = {
      labels  : [<?php echo $lasfamlias;?>],
      datasets: [
        {
          label               : 'Stock by Product Family',          
		     backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius         : true,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [<?php echo $cantxfamilia;?>]
        }
      ]
    }
	var areaChartOptions = {
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
          stepSize: 1	,
		    beginAtZero: true
        }
        }]
      }
    }

    // This will get the first returned node in the jQuery collection.
    var areaChart       = new Chart(areaChartCanvas, { 
      type: 'bar',
      data: areaChartData, 
      options: areaChartOptions
    })
		
		var ipservidorapache= '<?php echo $ipservidorapache; ?>';	
	*/			
			
	});



	$(function () {
  			$('.knob').knob({ 
			})

	})
  
	function habilitarbusqueda()
	{		
		$('#openbusqueda').hide();
		$('#closebusqueda').show();
		$("#example1").DataTable({
					 "destroy": true,
						 "paging": true,
					  "lengthChange": false,
					  "searching": true,						  
					  "ordering": false,
					  "info": true,
					  "autoWidth": false,
					  "iDisplayLength": 10
					}
			);
					
					
	}
   
   function mostrar_calibrarion(sn_param)
   {
	   	var ipservidorapache= '<?php echo $ipservidorapache; ?>';	
	   $("#lblsn").text('');
						   $('#iframem').attr("src", '');
		console.log('http://'+ipservidorapache+'/finalchk.php?idsndib=' +sn_param+'&idmb=0&iduldl=0');				   
	   		$("#lblsn").text(sn_param);
						$('#iframem').attr("src", 'http://'+ipservidorapache+'/finalchk.php?idsndib=' +sn_param+'&idmb=0&iduldl=0');
   }
	function dehabilitarbusqueda()
	{

			$('#closebusqueda').hide();
			$('#openbusqueda').show();
			$("#example1").DataTable({
						 "destroy": true,
							 "paging": true,
						  "lengthChange": false,
						  "searching": false,						  
						  "ordering": false,
						  "info": true,
						  "autoWidth": false,
						  "iDisplayLength": 10
						}
				);
		
				
				
	} 
	
	
   


function json2array(json){
    var result = [];
    var keys = Object.keys(json);
    keys.forEach(function(key){
        result.push(json[key]);
    });
    return result;
}

		
		function filtraplacas()
		{
		//	 $("#txtacceptbusca").val();
		
		
			
		  // Declare variables
		  var input, filter, ul, li, a, i, txtValue;
		  input = $("#txtacceptbusca").val();
		  filter = $("#txtacceptbusca").val();
	
		  li = document.getElementsByClassName('treemm');
		 
		 
		  // Loop through all list items, and hide those who don't match the search query
		 
		  for (i = 0; i < li.length; i++) {
			a = li[i];
			txtValue = a.textContent || a.innerText;
			 console.log( '****'+ txtValue +'****' );
		  
			if (txtValue.toUpperCase().indexOf(filter) > -1) {
			  li[i].style.display = "";
		//	  console.log( i +'ok' + txtValue +'a verrr:'+ a.style.display);
			} else {
			//	console.log('none' + txtValue + '--'+a.css+"otr:"+ a.style.display);
			  li[i].style.display = "none";
			}
			
		  } 
		
		
					//$('[class="treeview"]:not(li:contains("6092"))').remove();

		}
		
	
	
   
</script>

</html>

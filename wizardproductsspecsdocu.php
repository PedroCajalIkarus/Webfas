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
			header("Location: http://".$ipservidorapache."/".$folderservidor."/permissiondenied.php?b=".$_SESSION["b"]."&c=".array_pop(explode('/', $_SERVER['PHP_SELF'])));
			exit();
		}
	
	
	$status = $connect->getAttribute(PDO::ATTR_CONNECTION_STATUS);
	
	if ($status !="Connection OK; waiting to send.")
	{
	
		header("Location: http://".$ipservidorapache."/".$folderservidor."/errorconect.php");
		exit;
		
	}
	

$msjdegrabo="";	
 
if($_POST)
	{

		//levantamos los valores ingresamos para modificar
 		$v_txtusermanu = $_REQUEST['txtusermanu'];
		$v_txtpppacklist = $_REQUEST['txtpppacklist'];
		$v_txtppassy = $_REQUEST['txtppassy'];
		$v_txtppwire = $_REQUEST['txtppwire'];
		$v_txtpppoly = $_REQUEST['txtpppoly'];
		$v_txtpplabel = $_REQUEST['txtpplabel'];
 
		$v_chkprod = $_REQUEST['chkprod'];

		$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connect->beginTransaction();
		try {

				foreach ($v_chkprod as $clave2=>$valor2)
				{
					///	$row2['idbusiness']."#".$row2['idproduct']."#".$row2['idbandnn']."#".$row2['iduniquebranch']."#".$row2['uldl']
				//	echo "<br>chkprod valor de ".$clave2." es: ".$valor2;
					$losvalores = explode("#",$valor2);
					$idbusiness =$losvalores[0];
					$idproduct = $losvalores[1];
					$idrev = $losvalores[2];
				 
					//UPDATE
					$setear_sql1="";
					$setear_sql2="";
					$setear_sql3="";
					$setear_sql4="";
					$setear_sql5="";
					$setear_sql6="";
					$setear_sql7="";
				 
					 
					$sumocoma="N";
					if ($v_txtusermanu <> "")
					{
					//	echo "1";
						$setear_sql1= " usermanual='".$v_txtusermanu ."' ";
						$sumocoma="S";
					}
					if ($v_txtpppacklist <> "")
					{
						//echo "2";
						if ($sumocoma=="S")
						{
							$setear_sql2=$setear_sql2.",";
							$sumocoma="N";
						}
						$setear_sql2= $setear_sql2." pp_packinglist='".$v_txtpppacklist ."' ";
						$sumocoma="S";
					}
					if ($v_txtppassy <> "")
					{
						//echo "2";
						if ($sumocoma=="S")
						{
							$setear_sql3=$setear_sql3.",";
							$sumocoma="N";
						}
						$setear_sql3= $setear_sql3." pp_assy='".$v_txtppassy ."' ";
						$sumocoma="S";
					}
					if ($v_txtppwire <> "")
					{
						//echo "2";
						if ($sumocoma=="S")
						{
							$setear_sql4=$setear_sql4.",";
							$sumocoma="N";
						}
						$setear_sql4= $setear_sql4." pp_wire='".$v_txtppwire ."' ";
						$sumocoma="S";
					}
					if ($v_txtpppoly <> "")
					{
						//echo "2";
						if ($sumocoma=="S")
						{
							$setear_sql5=$setear_sql5.",";
							$sumocoma="N";
						}
						$setear_sql5= $setear_sql5." pp_poly='".$v_txtpppoly ."' ";
						$sumocoma="S";
					}
					if ($v_txtpplabel <> "")
					{
						//echo "2";
						if ($sumocoma=="S")
						{
							$setear_sql6=$setear_sql6.",";
							$sumocoma="N";
						}
						$setear_sql6= $setear_sql6." pp_label='".$v_txtpplabel ."' ";
						$sumocoma="S";
					}
				 
				 	 
					
					$vuserfas = $_SESSION["b"];
					$sqlreplico="insert into fas_documentation 
					SELECT idproduct, idrev + 1, datedocumentation, usermanual, pp_packinglist, pp_assy, pp_wire, pp_poly, pp_label
						FROM public.fas_documentation
						where idproduct = ".$idproduct."  and idrev = ".$idrev;
					 	$connect->query($sqlreplico);
						$idrevnew=$idrev+1;	
				///	echo "<br>1|replico fas_documentation::::".	$sqlreplico;
					$slqbandupd ="UPDATE public.fas_documentation set ".$setear_sql1.$setear_sql2.$setear_sql3.$setear_sql4.$setear_sql5.$setear_sql6." where idproduct = ".$idproduct." and  idrev =  ".$idrevnew  ;
				///	echo "<br>2° updateo lo necesario: ".$slqbandupd ;
					
					  	$connect->query($slqbandupd);
					$msjdegrabo= "Update OK.!";
						/////////////////////////////////////////////////////////////////////////////////////
							//////AUDITAMOS///////////////////////////////////////////////////////////////////////////////
							$vuserfas = $_SESSION["b"];
							$typeregister="PO";
							$vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
							$vaccionweb="Repli fas_documentation";
							$vdescripaudit="Replicate fas_documentation -".$valor2;
							$vtextaudit=$slqband."***".	$sqlreplico." -- ".$slqbandupd; 
						
					
									$sentenciaudit = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
									$sentenciaudit->bindParam(':userfas', $vuserfas);								
									$sentenciaudit->bindParam(':menuweb', $vmenufas);
									$sentenciaudit->bindParam(':actionweb', $vaccionweb);
									$sentenciaudit->bindParam(':descripaudit', $vdescripaudit);
									$sentenciaudit->bindParam(':textaudit', $vtextaudit);
									$sentenciaudit->execute();
									
					/////////////////////////////////////////////////////////////////////////////////////
					/////////////////////////////////////////////////////////////////////////////////////



				}
			
			$connect->commit();
		} 
		catch (PDOException $e) 
		{
			$connect->rollBack();
			$return_result_insert="error".$e->getMessage();
			$msjdegrabo= "Syntax Error MM: ".$e->getMessage();
		//	echo $msjerr;
		}

 
	}
//****************************************************************	

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
 <link rel="stylesheet" href="cssfiplexsintextareaslog.css">
 

<link href="css/select2.css" rel="stylesheet" />
<link href="css/testcssselector.css" rel="stylesheet" />
<link rel="stylesheet" href="themestreecss/default2/style.css">
  
    <link rel="stylesheet" href="cssfiplex.css">
</head>
<style>
textarea.form-control { height: 238px;}
</style>
<form name="frma" id="frma" action="wizardproductsspecsdocu.php" method="post" class="form-horizontal">
 
	

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
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- DataTables -->

<link href="css/select2.css" rel="stylesheet" />
<link href="css/testcssselector.css" rel="stylesheet" />

    <link href="smoke/css/smoke.css" rel="stylesheet">

<script src="plugins/moment/moment.min.js"></script>

<script src="js/eModal.min.js" type="text/javascript" />

<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="toastr.min.js"></script>

<script src="js/jquery.inactivityTimeout.js"></script>
<script src="js/moment-timezone-with-data.js"></script>

<script src="plugins/jquery-knob/jquery.knob.min.js"></script>

<script src="plugins/datatables/jquery.dataTables.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Wizard Products Documentation</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Wizard Products Documentation</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid card">
	  
	  <?php // echo $msjdegrabo; 
	 	if ( $msjdegrabo <> "")
		 {
			?>
			<br>
			<div class="col-12 col-sm-6 col-md-3" id="divok" name="divok">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="far fa-check-circle"></i></span>

              <div class="info-box-content">
                <span class="info-box-text"><b><?php echo $msjdegrabo; ?></b></span>
               
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
		  <script type="text/javascript">
			  $("#divok").fadeOut(7000);
		  </script>
			<?php
		 } 
	  ?>

	  <div class="container-fluid">
        
        <!-- Timelime example  -->
        <div class="row" id="informationciu" name="informationciu">
          <section class="col-lg-2 connectedSortable ui-sortable">

			<p name="msjwaitline" id="msjwaitline" align="center" style="display: none;"><img src="img/waitazul.gif" width="100px"></p>	
				<div class="card">
					
					 <div class="container-fluid">
					 <br>

						<div class="ui-widget">
							<div id="tree" class="jstree jstree-1 jstree-default" role="tree" aria-multiselectable="true" tabindex="0" aria-activedescendant="ajax_ciu_adddoc*239" aria-busy="false">
								<ul class="jstree-container-ul jstree-children" role="group">
								
								<li role="presentation" aria-selected="false" aria-level="1" aria-labelledby="a1122330_anchor" aria-expanded="true" id="a1122330" class="jstree-node  jstree-open jstree-last"><i class="jstree-icon jstree-ocl" role="presentation"></i>
								  <a class="jstree-anchor" href="#" tabindex="-1" role="treeitem" aria-selected="false" aria-level="1" aria-expanded="true" id="a1122330_anchor"><i class="jstree-icon jstree-themeicon" role="presentation"></i>Category</a>
								  	<ul role="group" class="jstree-children">
									  <?php
									 /* <li role="presentation" aria-selected="false" aria-level="2" aria-labelledby="ajax_ciu_addhead*1129_anchor" id="ajax_ciu_addhead*1129" class="jstree-node  jstree-leaf"><i class="jstree-icon jstree-ocl" role="presentation"></i>
									  <a class="jstree-anchor" href="#" tabindex="-1" role="treeitem" aria-selected="false" aria-level="2" id="ajax_ciu_addhead*1129_anchor"><i class="jstree-icon jstree-themeicon fas fa-check jstree-themeicon-custom" role="presentation">
									  </i>Heads</a></li>
									  */ ?>
									  <li role="presentation" aria-selected="false" aria-level="2" aria-labelledby="ajax_ciu_adddoc*1129_anchor" id="ajax_ciu_adddoc*1129" class="jstree-node  jstree-leaf"><i class="jstree-icon jstree-ocl" role="presentation"></i>
									  <a class="jstree-anchor" href="wizardproductsspecsdocu.php" tabindex="-1" role="treeitem" aria-selected="false" aria-level="2" id="ajax_ciu_adddoc*1129_anchor"><i class="jstree-icon jstree-themeicon fas fa-check jstree-themeicon-custom" role="presentation"></i>
									  <b>	Documentation</b> </a></li>
									  <li role="presentation" aria-selected="false" aria-level="2" aria-labelledby="ajax_ciu_addband*1129_anchor" id="ajax_ciu_addband*1129" class="jstree-node  jstree-leaf"><i class="jstree-icon jstree-ocl" role="presentation"></i>
									  <a class="jstree-anchor" href="wizardproductsspecs.php" tabindex="-1" role="treeitem" aria-selected="false" aria-level="2" id="ajax_ciu_addband*1129_anchor"><i class="jstree-icon jstree-themeicon fas fa-check jstree-themeicon-custom" role="presentation"></i>
									 Bands</a></li>
									  <li role="presentation" aria-selected="false" aria-level="2" aria-labelledby="ajax_ciu_addlbl*1129_anchor" id="ajax_ciu_addlbl*1129" class="jstree-node  jstree-leaf jstree-last"><i class="jstree-icon jstree-ocl" role="presentation"></i>
									  <a class="jstree-anchor" href="wizardproductsspecslabel.php" tabindex="-1" role="treeitem" aria-selected="false" aria-level="2" id="ajax_ciu_addlbl*1129_anchor"><i class="jstree-icon jstree-themeicon fas fa-check jstree-themeicon-custom" role="presentation">
									  </i>  Labels</a></li>
									  <li role="presentation" aria-selected="false" aria-level="2" aria-labelledby="ajax_ciu_addlbl*1129_anchor" id="ajax_ciu_addlbl*1129" class="jstree-node  jstree-leaf jstree-last">
									    <i class="jstree-icon jstree-ocl" role="presentation"></i>
										<a class="jstree-anchor" href="wizardproductsspecsinstr.php" tabindex="-1" role="treeitem" aria-selected="false" aria-level="2" id="ajax_ciu_addlbl*1129_anchor">
										  <i class="jstree-icon jstree-themeicon fas fa-check jstree-themeicon-custom" role="presentation">
									      </i>  Measures Instruments</a></li>

										  <li role="presentation" aria-selected="false" aria-level="2" aria-labelledby="ajax_ciu_addlbl*1129_anchor" id="ajax_ciu_addlbl*1129" class="jstree-node  jstree-leaf jstree-last">
									    <i class="jstree-icon jstree-ocl" role="presentation"></i>
										<a class="jstree-anchor" href="wizardproductsspecsref.php" tabindex="-1" role="treeitem" aria-selected="false" aria-level="2" id="ajax_ciu_addlbl*1129_anchor">
										  <i class="jstree-icon jstree-themeicon fas fa-check jstree-themeicon-custom" role="presentation">
									      </i>  Measures References </a></li>

										  <li role="presentation" aria-selected="false" aria-level="2" aria-labelledby="ajax_ciu_addlbl*1129_anchor" id="ajax_ciu_addlbl*1129" class="jstree-node  jstree-leaf jstree-last">
									    <i class="jstree-icon jstree-ocl" role="presentation"></i>
										<a class="jstree-anchor" href="wizardproductsspecsfrw.php" tabindex="-1" role="treeitem" aria-selected="false" aria-level="2" id="ajax_ciu_addlbl*1129_anchor">
										  <i class="jstree-icon jstree-themeicon fas fa-check jstree-themeicon-custom" role="presentation">
									      </i> Firmware  </a></li>


								</ul></li>
								
								</ul></div>
						</div>
					</div>
					<br><br><br>
					
					<br><br>
			</div>
		
		
			<div class="card d-none">
		
			</div>
		

        </section>
		<section class="col-lg-10 connectedSortable ui-sortable">
		

				
					  <!-- /.3div de ramas -->
			  
			  		<div class="card">
				<div class=" ">
               		
				<div class=" ">
         
              <!-- /.card-header -->
              <div class=" " style="display: block;">
                <div class=" ">
			    	 <div class=" ">
					 <br>
					 
					
					  <div class=" " id="detcatacargar" name="detcatacargar">


					 <div class=" ">
							<div class=" ">
							
					
								  
									  
					<!-- Start Definition of bands  -->
					<div class=" " id="divfasobjband" name="divfasobjband">

					<!-- ---COMPONENTE FILTRADORRRRR----------------------------->
					<div class="form-group col-md-12 ">
			<b>Quick filters:</b>
			<table class="table table-striped">
				 <tr>
				 <td>
                        <label>Select Business</label>
                        <select multiple="" class="form-control form-control-sm" name="lasempresas" id="lasempresas"    >
						<option value="" >ALL Business</option>
						<?php
												 					
																

																	 $sql = $connect->prepare("select * from business where active= 'true' order by namebusiness");
																	  
																											 $sql->execute();
																											 $resultado3 = $sql->fetchAll();
																											 foreach ($resultado3 as $row2) 
																											  {
																												  $autoselect = '';
																												  if ( array_search($row2['idbusiness'], $lasempresasfiltradas)>=0 )
																												  {
																												//	$autoselect = 'selected';
																												  }
																												// echo "*************". array_search($row2['idbusiness'], $lasempresasfiltradas);
																											  ?>
																											  <option value="<?php echo  $row2['idbusiness']; ?>" <?php echo $autoselect;?>>
																											  <?php echo  $row2['namebusiness']; ?>
																											  </option>
																											  <?php
																											  }
					
																	 ?>
                        </select>
                </td>
				<td>
                        <label>Select Bands</label>
                        <select multiple="" class="form-control form-control-sm" name="lasbandas" id="lasbandas"    >
						<option value="" >ALL Bands</option>
						<?php
												 					
																

																	 $sql = $connect->prepare("select * from idband where active= 'Y' order by description");
																	  
																											 $sql->execute();
																											 $resultado3 = $sql->fetchAll();
																											 foreach ($resultado3 as $row2) 
																											  {
																												  $autoselect = '';
																												  if ( array_search($row2['idband'], $lasempresasfiltradas)>=0 )
																												  {
																												//	$autoselect = 'selected';
																												  }
																												// echo "*************". array_search($row2['idbusiness'], $lasempresasfiltradas);
																											  ?>
																											  <option value="<?php echo  $row2['idband']; ?>" <?php echo $autoselect;?>>
																											  <?php echo  $row2['description']; ?>
																											  </option>
																											  <?php
																											  }
					
																	 ?>
                        </select>
                </td>
			 
                        <select multiple="" class="form-control form-control-sm d-none" name="losuldl" id="losuldl"    >

					


						<option value=""> All </option>
						<option value="0"> UL </option>
						<option value="1"> DL </option>
							 
                        </select>
					 
				 
				<td>
                        <label>Select Branchs</label>
					

                        <select multiple="" class="form-control form-control-sm " name="losbranchs" id="losbranchs"     >
					  				 <option value=""> All Branchs </option>
																	 <?php
																	 
																
					
																	 $sql = $connect->prepare("
																	 select * from
																	 (
																	 select  public.full_tree_namever(iduniquebranchprodson, '') as stringtree, iduniquebranchprodson
																	 from (
																		 select  distinct iduniquebranchprodson
																													  from business_branch_tree
																													  inner join products_branch
																													  on products_branch.idproductsbranch = business_branch_tree.idprodbranchson 
																													  inner join products_branch as products_branchpp
																													  on products_branchpp.idproductsbranch = business_branch_tree.idprodbranchfather  
																											  where products_branch.active='Y' and idbusiness =1 
																		  
																											  
																	 ) as viewtree
																	 ) as alltree
																	 where stringtree like '%XXXXXXXUNIT%' and
																	 stringtree not like '%700%' and
																	 stringtree not like '%800%' and
																	 stringtree not like '%HF%' and
																	  stringtree not like '%RACK%' and
																	 ( stringtree like '%BDA%' or stringtree like '%DAS%' ) 
																	 order by stringtree
																	  ");
																	  
																											 $sql->execute();
																											 $resultado3 = $sql->fetchAll();
																											 foreach ($resultado3 as $row2) 
																											  {
																												 if ( $row2['stringtree'] != '')
																												 {
																											  ?>
																											  <option value="<?php echo  $row2['iduniquebranchprodson']; ?>">
																											  <?php
																												 $nomfather =   $row2['stringtree'];
																											 
					
																											  echo  $nomfather; ?>
																											  </option>
																											  <?php
																												 }
																											  }
					
																	 ?>
																
								
<option value="000100370039">
UNIT --&gt; FLEX --&gt; BDA																											  </option>
<option value="0001003700390043">
UNIT --&gt; FLEX --&gt; BDA --&gt; 700/800																											  </option>
<option value="00010037003900430045">
UNIT --&gt; FLEX --&gt; BDA --&gt; 700/800 --&gt;  DUAL BAND																											  </option>
<option value="00010037003900430046">
UNIT --&gt; FLEX --&gt; BDA --&gt; 700/800 --&gt; SINGLE 700																											  </option>
<option value="00010037003900430047">
UNIT --&gt; FLEX --&gt; BDA --&gt; 700/800 --&gt;  SINGLE 800																											  </option>
<option value="000100370040">
UNIT --&gt; FLEX --&gt; DAS																											  </option>
<option value="0001003700400049">
UNIT --&gt; FLEX --&gt; DAS --&gt; ENTERPRISE																											  </option>
<option value="00010037004000490052">
UNIT --&gt; FLEX --&gt; DAS --&gt; ENTERPRISE --&gt; MASTER																											  </option>
<option value="000100370040004900520054">
UNIT --&gt; FLEX --&gt; DAS --&gt; ENTERPRISE --&gt; MASTER --&gt; 700/800																											  </option>
<option value="00010037004000490053">
UNIT --&gt; FLEX --&gt; DAS --&gt; ENTERPRISE --&gt; REMOTE																											  </option>
<option value="000100370040004900530061">
UNIT --&gt; FLEX --&gt; DAS --&gt; ENTERPRISE --&gt; REMOTE --&gt; 700/800																											  </option>
<option value="0001003700400048">
UNIT --&gt; FLEX --&gt; DAS --&gt; PSC																											  </option>
<option value="00010037004000480050">
UNIT --&gt; FLEX --&gt; DAS --&gt; PSC --&gt; MASTER																											  </option>
<option value="000100370040004800500057">
UNIT --&gt; FLEX --&gt; DAS --&gt; PSC --&gt; MASTER --&gt; 700/800																											  </option>
<option value="00010037004000480051">
UNIT --&gt; FLEX --&gt; DAS --&gt; PSC --&gt; REMOTE																											  </option>
<option value="000100370040004800510059">
UNIT --&gt; FLEX --&gt; DAS --&gt; PSC --&gt; REMOTE --&gt; 700/800																											  </option>								
<option value="00010038">
UNIT --&gt; LEGACY																											  </option>	
                        </select>
						</td>
				<td>
                        <label>Select Attributes</label>
                        <select multiple="" class="form-control form-control-sm" name="losatributos" id="losatributos"    >

					


						<option value=""> All Attributes </option>
												 <?php
												 					
																	 list_all_attributes_wizard();

												 ?>
                        </select>
						</td>
					 
					
		
				</tr>
				<tr>
				<td colspan="6"> <button type="button" class="btn btn-block btn-outline-primary btn-xs" onclick="filtrartodo()" >Apply Filters</button> </td>
				</tr>
				</table>	
					 

					  </div>	
              
			  </section></div>	
			  <!-- tabla band a updatear 222222  -->  
			  <div class="card">
			  <?php if ( $_SESSION["g"] == "develop" ) 
									{
										?>
			  <p align="right">
						<button name="btnopenrf" id="btnopenrf" type="button" class="btn btn-smk btn-block btn-outline-primary btn-flat" onclick="opendiv('dibbandyrf')">Modify Specifications</button>
					</p>
					<?php } ?>
				  <div class="form-group col-md-12 d-none" id="dibbandyrf" name="dibbandyrf">
				
				  
				  	<br>

				  <table class="table   table-bordered table-sm ">
						<tr>
					  	    <td>	<label for="exampleInputEmail1">User Manual:</label>   <button type="button" class="btn btn-xs btn-default" onclick="hablitame('divtxtusermanu')" name="btntxtusermanu" id="btntxtusermanu"> <i class="fas fa-edit"></i> Edit </button> </td>
							  <td>	<label for="exampleInputEmail1">PP Pack List:</label>   <button type="button" class="btn btn-xs btn-default" onclick="hablitame('divtxtpppacklist')" name="btntxtpppacklist" id="btntxtpppacklist"> <i class="fas fa-edit"></i> Edit </button> </td>
							  <td>	<label for="exampleInputEmail1">PP Assy:</label>   <button type="button" class="btn btn-xs btn-default" onclick="hablitame('divtxtppassy')" name="btntxtppassy" id="btntxtppassy"> <i class="fas fa-edit"></i> Edit </button> </td>
							  <td>	<label for="exampleInputEmail1">PP Wire:</label>   <button type="button" class="btn btn-xs btn-default" onclick="hablitame('divtxtppwire')" name="btntxtppwire" id="btntxtppwire"> <i class="fas fa-edit"></i> Edit </button> </td>
							  <td>	<label for="exampleInputEmail1">PP Poly:</label>   <button type="button" class="btn btn-xs btn-default" onclick="hablitame('divtxtpppoly')" name="btntxtpppoly" id="btntxtpppoly"> <i class="fas fa-edit"></i> Edit </button> </td>
							  <td>	<label for="exampleInputEmail1">PP Label:</label>   <button type="button" class="btn btn-xs btn-default" onclick="hablitame('divtxtpplabel')" name="btntxtpplabel" id="btntxtpplabel"> <i class="fas fa-edit"></i> Edit </button> </td>
					   </tr>
				  </table>
									
				  					<div class="row">

									  <div class="form-group col-md-6 d-none" id="divtxtusermanu" name="divtxtusermanu">
										<label for="exampleInputEmail1">User Manual:</label> 
										<input type="text" name="txtusermanu"   id="txtusermanu" class="form-control form-control-sm  " value="">		
									  </div>
									  <div class="form-group col-md-6 d-none" id="divtxtpppacklist" name="divtxtpppacklist">
										<label for="exampleInputEmail1">PP Pack List:</label> 
										<input type="text" name="txtpppacklist"   id="txtpppacklist" class="form-control form-control-sm  " value="">		
									  </div>
									  <div class="form-group col-md-6 d-none" id="divtxtppassy" name="divtxtppassy">
										<label for="exampleInputEmail1">PP Assy:</label> 
										<input type="text" name="txtppassy"   id="txtppassy" class="form-control form-control-sm  " value="">		
									  </div>
									  <div class="form-group col-md-6 d-none" id="divtxtppwire" name="divtxtppwire">
										<label for="exampleInputEmail1">PP Wire:</label> 
										<input type="text" name="txtppwire"   id="txtppwire" class="form-control form-control-sm  " value="">		
									  </div>
									  <div class="form-group col-md-6 d-none" id="divtxtpppoly" name="divtxtpppoly">
										<label for="exampleInputEmail1">PP Poly:</label> 
										<input type="text" name="txtpppoly"   id="txtpppoly" class="form-control form-control-sm  " value="">		
									  </div>
									  <div class="form-group col-md-6 d-none" id="divtxtpplabel" name="divtxtpplabel">
										<label for="exampleInputEmail1">PP Label:</label> 
										<input type="text" name="txtpplabel"   id="txtpplabel" class="form-control form-control-sm  " value="">		
									  </div>
 
							 
									
									<div class="form-group col-md-12">
											<p align="right">
												<button name="btnaddband" id="btnaddband" type="button" class="btn btn-smk btn-block btn-outline-primary btn-flat" onclick="update_selected_ciu(); ">Update selected CIU</button>
											</p>
											<div id="divlist_tabla_gain_rf" name="divlist_tabla_gain_rf">
											</div>
											<input type="hidden" name="divlist_tabla_gain_rftexto" id="divlist_tabla_gain_rftexto" value="">
									</div>
									
							</div>
					</div>
						<!-- end  - Definition of bands  -->					  	

				  </div>
			   </div>
			   <!--  fintabla band a updatear 222222  -->

			  <div class="card">
				  <div class="form-group col-md-12">
							<!-- tabla producto a updatear 3333  -->
							<div id="tblfilterdiv" name="tblfilterdiv">
						 
							<!-- fin tabla producto a updatear 3333-->
							</div>	
						</div>
					</div>	
			</div>
			
					<!-- --FIN COMPONENTE FILTRADORRR------------------------------>

												
				 
														
							</div>
						
						
					 </div>	
			</div>
				</div>
              
                  </div><!-- /.card-pane-right -->
                </div><!-- /.d-md-flex -->
              </div>
              <!-- /.card-body -->
            </div>
			    <!-- /.fin 3div de ramas-->
				  
				     
				</div>	
              
				</section></div>	
				
				
				

				
				
				
				
				
				
				</div>

	 
          
           
       
	
	
  </div>
  <!-- /.content-wrapper -->
 <!-- Main content -->
 <section class="content">
      <div class="container-fluid">
        
        <!-- Timelime example  -->
        <div class="row d-none" id="informationciu" name="informationciu">
          <section class="col-lg-2 connectedSortable ui-sortable">

			<p name="msjwaitline" id="msjwaitline" align="center"><img src="img/waitazul.gif" width="100px" ></p>	
				<div class="card">
					
					 <div class="container-fluid">
					 <br>

						<div class="ui-widget">
							
						<b>
						 <span id="ciuselectspan" name="ciuselectspan"> </span>
							</b>
					


							<div id="tree">
							</div>
						</div>
					</div>
					<br><br><br>
			</div>
		
		
			<div class="card d-none">
		
			</div>
		

        </section>
		<section class="col-lg-10 connectedSortable ui-sortable">
		

				
					  <!-- /.3div de ramas -->
			  
			  		<div class="card">
				<div class="card-header ui-sortable-handle" >
               		
				<div class="card">
              <div class="card-header">
                <h3 class="card-title"> <i class="fa fa-fw fa-list-alt"></i> selected category:</h3>
						
<div class="card-tools">
                  <button type="button" class="btn btn-sm" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                 
                </div>
              
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0" style="display: block;">
                <div class="d-md-flex">
			    	 <div class="container-fluid">
					 <br>
					
					
					  <div class="card-body form-row" id="detcatacargar" name="detcatacargar">		
							   
								
		
					
					</div>
				</div>
              
                  </div><!-- /.card-pane-right -->
                </div><!-- /.d-md-flex -->
              </div>
              <!-- /.card-body -->
            </div>
			    <!-- /.fin 3div de ramas-->
				  
				     
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

<script src="js/select2.min.js"></script>
<script type="text/javascript" src="js/jstree.min.js"></script>
</body>

<script type="text/javascript">

 
 
function load_tree_products(ciupram)
{
	$("#tree").jstree("destroy"); 
var jsonTreeData = "";

	$.ajax({
				url: 'ajax_list_tree_category_addciu.php?ciupram='+ciupram,			
				type: 'post',				
				datatype:'JSON',				
				cache:false,					
				success: function(data, status, xhr) {
					jsonTreeData= data ;
				//console.log(jsonTreeData);
				//	console.log(exData);
				var myTree = 	 $('#tree').jstree({
    core: {
      check_callback: 
			function (op, node, par, pos, more) {
				console.log(more);
					/*if ((op === "move_node" || op === "copy_node") && node.type && node.type == "root") {
						return false;
					}
					if((op === "move_node" || op === "copy_node") && more && more.core && !confirm('Are you sure ...')) {
					return false;
				
				   }*/
				   if((op === "move_node" || op === "copy_node")   && more && more.core &&  !confirm('Are you sure to add '+node.text.trim()+' to ' + par.text.trim()) ) {
					//	console.log(more);
					////	console.log(more.core);
					
						//console.log('Are you sure to add '+node.text.trim()+' to ' + par.text.trim())
					return false;
					
				   }
				   else
				   {
					   
					}
			
				},
      data: jsonTreeData
    },
    types: {
      root: {
        icon: "fa fa-globe-o"
      }
    },
    plugins: ["core", "html_data", "themes", "ui","dnd"]
	
	
  });



  myTree.bind("select_node.jstree", function (event, data) 
  {
	  console.log(data);
	//  console.log(data.selected[0]);
	// alert('branch:' + data.selected[0]);
	var resdatps = data.selected[0].split("*");

	  						$.ajax({
										url: 'https://webfas.fiplex.com/'+ resdatps[0]+'.php?id='+resdatps[1],										
										 cache:false,
										success: function(respuesta) {
											
										//	armando_tabla_bybranchedit=armando_tabla_bybranchedit+respuesta;
											console.log('a');
										
											$('#detcatacargar').html(""+respuesta);
										//	console.log(respuesta);
											return false;
										},
										error: function() {
											console.log("No se ha podido obtener la información");
											$('#detcatacargar').html("<p class='text-danger'>No information found for the tree branch</p>");
										}
									});

	   });


 
				
			return false;	
				
				},
				error: function(xhr, status, error) {
					 console.log(status);
				}
				});
				
/////
console.log('open tree marco');

setInterval('open_tree_all()',1000);
///
}

function open_tree_all()
{
	$("#tree").jstree("open_all");
}
 


function filtrartodo()
	{
		$("#tblfilterdiv").html(' 	<p name="msjwaitline" id="msjwaitline" align="center"><img src="img/waitazul.gif" width="100px" ><b> Searching... </b></p>	 ');	 
	var lasempresas = $("#lasempresas").val().toString();
	var lasbandas = $("#lasbandas").val().toString();
	var losbranchs = $("#losbranchs").val().toString();
	var losatributos = $("#losatributos").val().toString();
	var losuldl =  $("#losuldl").val().toString();
	///var lasmediciones =  $("#lasmediciones").val().toString();

	console.log('filtramos'+ lasempresas);
	console.log('lasbandas'+ lasbandas);

	console.log('losbranchs'+ losbranchs);
	console.log('losatributos'+ losatributos);
			var formData = new FormData();
			toastr["info"](" ", "Searching");
			formData.append("lasempresas", lasempresas);
			formData.append("lasbandas", lasbandas);
			formData.append("losbranchs", losbranchs);
			formData.append("losatributos", losatributos);
			formData.append("losuldl", losuldl);
		//	formData.append("lasmediciones", lasmediciones);
		 

			var xhr2 = new XMLHttpRequest();
			xhr2.open("POST", "searchcuicomponentfiltersdocu.php");
			xhr2.send(formData);
			
			xhr2.onload = function() {
				  if (xhr2.status == 200) {  
					
					//	console.log('devolvio el idaccionweb 1:' + xhr2.response);	
						$("#tblfilterdiv").html(xhr2.response);		 
					
				  }
				 
				};

	}

function hablitame(qcontrol)
{
	
	var qcontroltel = qcontrol.replace("div", "");
	if ($("#"+qcontrol).hasClass("d-none")==true)
	{
		$("#"+qcontrol).removeClass('d-none');
	
		$("#"+ qcontroltel+'r').removeAttr("disabled");
		$("#btn"+qcontroltel).removeClass('btn-default');
		$("#btn"+qcontroltel).addClass('btn-primary');
	}
	else
	{
		$("#"+qcontrol).addClass('d-none');
	////	$("#"+ qcontroltel).prop('disabled', 'disabled');
		$("#btn"+qcontroltel).removeClass('btn-primary');
		$("#btn"+qcontroltel).addClass('btn-default');
	}
}

function open_div_createnewcui()
 {
	 //	detcatacargar
	$("#detcatacargar").html('');

	if ($("#divaddciu").hasClass("d-none")==true)
	{
		$("#divaddciu").removeClass('d-none');
	}
	else
	{
		$("#divaddciu").addClass('d-none');
	}


 }  

 function save_new_registro_lbl()
	{
		
		////Controlamos campos vacios
		////Controlamos campos vacios
		if ($('#txtciu')[0].checkValidity() == false)
		{
			toastr["error"]("Error, Ciu is required..", "");	
			return false;
		}	
		
		if ($('#txtmadein')[0].checkValidity() == false)
		{
			toastr["error"]("Error, Made In is required..", "");	
			return false;
		}	
		if ($('#txtflia')[0].checkValidity() == false)
		{
			toastr["error"]("Error, Model is required..", "");	
			return false;
		}
	
	
		if ($('#txtetsi')[0].checkValidity() == false)
		{
			toastr["error"]("Error, IsETSI Img is required..", "");	
			return false;
		}		
	
		
	/*	if ($('#txtfccimg')[0].checkValidity() == false)
		{
			toastr["error"]("Error, IsETSI Img is required..", "");	
			return false;
		}	*/
				
		
		/*if ($('#txtulimg')[0].checkValidity() == false)
		{
			toastr["error"]("Error, UL Img is required..", "");	
			return false;
		}*/

		if ($('#txtmadeinimg')[0].checkValidity() == false)
		{
				toastr["error"]("Error, Made In Img is required..", "");	
			return false;
		}
	
		if ($('#txtrohsimg')[0].checkValidity() == false)
		{
				toastr["error"]("Error, ROSH Img is required..", "");	
			return false;
		}
			
			
		
		$('#lbldatoserrr').html("");
		 var v_txtciu = $('#txtidprod').val();
		 var v_txtupwr = $('#txtupwr').val();
		 var v_txtmadein = $('#txtmadein').val();
		 var v_txtflia = $('#txtflia').val();
		 var v_txtfcc = $('#txtfcc').val();
		 var v_txtic = $('#txtic').val();
		 var v_txtetsi = $('#txtetsi').val();
		 
		 var v_txtfccimg = $('#txtfccimg').val();
		 var v_txtrohsimg = $('#txtrohsimg').val();
		 var v_txtmadeinimg= $('#txtmadeinimg').val();
		 var v_txtulimg = $('#txtulimg').val();
		 var v_txtdescript = $('#txtdescript').val();
		 
		 var v_txtetlnumber = $('#txtetlnumber').val();
		 var v_txtintertek = $('#txtintertek').val();
		 
					
		toastr["success"]("processing information..", "");	
		
				$.ajax({
				url: 'ajax_createnew_ciulabel.php', 				
				data: "v_txtidprod="+v_txtciu+'&v_txtupwr='+v_txtupwr+'&v_txtmadein='+v_txtmadein+'&v_txtflia='+v_txtflia+'&v_txtfcc='+v_txtfcc+'&v_txtic='+v_txtic+'&v_txtetsi='+v_txtetsi+"&v_txtfccimg="+v_txtfccimg+"&v_txtrohsimg="+v_txtrohsimg+"&v_txtmadeinimg="+v_txtmadeinimg+"&v_txtulimg="+v_txtulimg+"&v_txtdescript="+v_txtdescript+"&v_txtetlnumber="+v_txtetlnumber+"&v_txtintertek="+v_txtintertek,	
				type: 'post',				
				datatype:'JSON',				
				cache:false,					
				success: function(data, status, xhr) {
					var resultadom = data.resultiu;
					var resulterr = data.erromsj;
					console.log("Error");
					console.log("Exec: " + resulterr);
					if (resultadom =="ok" )
					{
						toastr["success"]("Save OK!", "");	
						tabla_list();	
						$("#lbladdbtn").removeClass('d-none');
						$('#txtciu').val("");
						$('#txtupwr').val("");
			            $('#txtmadeinusa').val("");
						$('#txtflia').val("");
						$('#txtfcc').val("");
						$('#txtic').val("");
						$('#txtetsi').val("");
						
						$('#txtfccimg').val('');
						$('#txtrohsimg').val('');
						$('#txtmadeinimg').val('');
						$('#txtulimg').val('');
						
						
						$('#txtdescript').val("");
		 
					
					}
					else	
					{
						toastr["error"]("Error when storing data...", "");	
						
						$('#lbldatoserrr').html("ERROR: <br>"+resulterr);
					}
					return false;	
				
				},
				error: function(xhr, status, error) {
					 console.log(status);
				}
				});
			
				
	}

function opendiv(div_to_open)
{
/////	$('#'+div_to_open).removeClass('d-none');

	if ($('#'+div_to_open).hasClass("d-none")==true)
	{
		$('#'+div_to_open).removeClass('d-none');
	}
	else
	{
		$('#'+div_to_open).addClass('d-none');
	}


}

function update_selected_ciu()
{
	$('#frma').submit();
}

 function save_new_registro_ciu()
 {
	//Enviamos los datos a procesar
	return new Promise(function(resolve, reject) {
					var formData = new FormData();
			var req = new XMLHttpRequest();
			//consulta si devolvio el Scan Device
			
			formData.append("txtbusiness",  $("#txtbusiness").val());			
			formData.append("txtnewprod",  $("#txtnewprod").val().toUpperCase() );
			formData.append("txtnewproddescr",  $("#txtnewproddescr").val().toUpperCase() );		
			//txtrefmother
			formData.append("txtrefmother",  $("#txtrefmother").val().toUpperCase() );		
			//txtfiplexsku
			formData.append("txtfiplexsku",  $("#txtfiplexsku").val().toUpperCase() );		


			console.log('paso por el post');
			req.open("POST", "ajax_insert_basic_products.php");
		
			req.send(formData);
			toastr["success"]("Save OK!", "Now you can continue completing the following categories");	
			req.onload = function() {
				  if (req.status == 200) {
					
					$("#divaddciu").addClass('d-none');		
					$("#ciuselectspan").html(  $("#txtnewprod").val().toUpperCase()  );
					load_tree_products( $("#txtnewprod").val().toUpperCase() );
									
				  }
				  else {
					reject();
					toastr["error"]("Error when storing data...", "");	
				  }
				};

			
			})
		//fin enviar datos a procesar
 }
   
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

                  
				$("#lasempresas").val(1);
				
                  	 // AutoComplete de CUIS version TOP

     

 

// fin// AutoComplete de CUIS version TOP	

			
	});
	

	// controlar inactividad en la web	
		$(document).inactivityTimeout({
                inactivityWait: 10000,
                dialogWait: 10,
                logoutUrl: 'logout.php'
            })
	// fin controlar inactividad en la web		
	
	 /* requesting data */
     		

		
	  

   $("#txtlistcius").change(function(){
				var datosmm = $("#txtlistcius").val().split("#");	
            console.log( $("#txtlistcius").val());
			$("#ciuselectspan").html(datosmm[1]);
			load_tree_products(datosmm[1] );
           // window.location = 'wizardaddciu.php?a='+datosmm[0]+'&b='+datosmm[1]+'&c='+datosmm[2];
		   $('#informationciu').removeClass('d-none');

   });



   function selectallmarco()
{
	$(".chkclassmarco").prop('checked', true);
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
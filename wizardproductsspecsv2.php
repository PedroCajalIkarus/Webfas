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
	

$msjdegrabo="";	
 
if($_POST)
	{

		//levantamos los valores ingresamos para modificar
		$v_cmbportinul = $_REQUEST['cmbportinul'];
		$v_txttypeclass = $_REQUEST['txttypeclass'];
		$v_cmbportindl = $_REQUEST['cmbportindl'];
		$v_cmbportoutul = $_REQUEST['cmbportoutul'];
		$v_cmbportoutdl = $_REQUEST['cmbportoutdl'];
		$v_txtulgainband = $_REQUEST['txtulgainband'];
		$v_txtdlgainband = $_REQUEST['txtdlgainband'];
		$v_txtulmaxpwrband = $_REQUEST['txtulmaxpwrband'];
		$v_txtdlmaxpwrband = $_REQUEST['txtdlmaxpwrband'];
		$v_chkprod = $_REQUEST['chkprod'];

		$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connect->beginTransaction();
		try {

				foreach ($v_chkprod as $clave2=>$valor2)
				{
				//	echo "<br>chkprod valor de ".$clave2." es: ".$valor2;
					$losvalores = explode("#",$valor2);
					$maxidrevmasuno = intval($losvalores[2]) + 1;
					$idbandselect = $losvalores[3];

				/*	$slqband ="insert into objectband
					SELECT ciu, idband, idportinul, idportoutul, idportindl, idportoutdl, dlgain, ulgain, dlmaxpwr, ulmaxpwr, class, ismodule, idproduct, ".$maxidrevmasuno."
						FROM public.objectband
						where idproduct = ".$losvalores[1]." and idrev =  ".$losvalores[2]." and idband=  ".$idbandselect;
----------------------- MEJORAMOS 
					tenemos generar una nueva rev para todo el ciu.y no solo para la bandaaa  -2022-04-13
				*/
						$slqband ="insert into objectband
						SELECT ciu, idband, idportinul, idportoutul, idportindl, idportoutdl, dlgain, ulgain, dlmaxpwr, ulmaxpwr, class, ismodule, idproduct, ".$maxidrevmasuno."
							FROM public.objectband
							where idproduct = ".$losvalores[1]." and idrev =  ".$losvalores[2]." and not exists (select idrev from objectband where idproduct = ".$losvalores[1]."  and idrev =".$maxidrevmasuno." )";
				//		echo "<br>".$slqband."<hr>";
					$connect->query($slqband);

					//UPDATE
					$setear_sql1="";
					$setear_sql2="";
					$setear_sql3="";
					$setear_sql4="";
					$setear_sql5="";
					$setear_sql6="";
					$setear_sql7="";
					$setear_sql8="";
					$setear_sql9="";

					$sumocoma="N";
					if ($v_txttypeclass<> "")
					{
						$setear_sql1= $setear_sql1." class='".$v_txttypeclass."' ";
						$sumocoma="S";
					}
					if ($v_cmbportinul <>"")
					{
						if ($sumocoma=="S")
						{
							$setear_sql2=$setear_sql2.",";
							$sumocoma="N";
						}
						$setear_sql2=$setear_sql2." idportinul=".$v_cmbportinul." ";
						$sumocoma="S";
					}				

					if ($v_cmbportindl <>"")
					{
						if ($sumocoma=="S")
						{
							$setear_sql3=$setear_sql3.",";
							$sumocoma="N";
						}
						$setear_sql3= $setear_sql3." idportindl=".$v_cmbportindl."";
						$sumocoma="S";
					}
					if ($v_cmbportoutul<> "")
					{
						if ($sumocoma=="S")
						{
							$setear_sql4=$setear_sql4.",";
							$sumocoma="N";
						}
						$setear_sql4= $setear_sql4." idportoutul=".$v_cmbportoutul." ";
						$sumocoma="S";
					}
					if ($v_cmbportoutdl<> "")
					{
						if ($sumocoma=="S")
						{
							$setear_sql5=$setear_sql5.",";
							$sumocoma="N";
						}
						$setear_sql5=$setear_sql5." idportoutdl=".$v_cmbportoutdl." ";
						$sumocoma="S";
					}
					if ($v_txtulgainband <> "")
					{
						if ($sumocoma=="S")
						{
							$setear_sql6=$setear_sql6.",";
							$sumocoma="N";
						}
						$setear_sql6= $setear_sql6." ulgain=".$v_txtulgainband." ";
						$sumocoma="S";
					}
					if ($v_txtdlgainband <>"")
					{
						if ($sumocoma=="S")
						{
							$setear_sql7=$setear_sql7.",";
							$sumocoma="N";
						}
						$setear_sql7=$setear_sql7." dlgain=".$v_txtdlgainband." ";
						$sumocoma="S";
					}
					if ($v_txtulmaxpwrband <> "")
					{
						if ($sumocoma=="S")
						{
							$setear_sql8=$setear_sql8.",";
							$sumocoma="N";
						}
						$setear_sql8=$setear_sql8." ulmaxpwr=".$v_txtulmaxpwrband." ";
						$sumocoma="S";
					}
					if ($v_txtdlmaxpwrband <> "")
					{
						if ($sumocoma=="S")
						{
							$setear_sql9=$setear_sql9.",";
							$sumocoma="N";
						}
						$setear_sql9=$setear_sql9." dlmaxpwr=".$v_txtdlmaxpwrband." ";
						$sumocoma="S";
					}

					$slqbandupd ="UPDATE public.objectband set ".$setear_sql1.$setear_sql2.$setear_sql3.$setear_sql4.$setear_sql5.$setear_sql5.$setear_sql6.$setear_sql7.$setear_sql8.$setear_sql9."	where idproduct = ".$losvalores[1]." and  idrev =  ".$maxidrevmasuno." and idband = ".$idbandselect;
				///	echo "<br>".$slqbandupd ;
					
					$connect->query($slqbandupd);
					$msjdegrabo= "Update OK.!";
						/////////////////////////////////////////////////////////////////////////////////////
							//////AUDITAMOS///////////////////////////////////////////////////////////////////////////////
							$vuserfas = $_SESSION["b"];
							$typeregister="PO";
							$vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
							$vaccionweb="Repli objectband";
							$vdescripaudit="Replicate objectband -".$valor2;
							$vtextaudit=$slqband."***".$slqbandupd; 
						
					
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
	font-size:10px;
textarea.form-control { height: 238px;}

 

			select.form-control[multiple], select.form-control[size] {
    height: 140px;
}

div.scrollmm {
             
        height: 737px;
        overflow: auto;
        text-align: justify;
        padding: 20px;
      }

</style>
<form name="frma" id="frma" action="wizardproductsspecsv2.php" method="post" class="form-horizontal">
 
	

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
            <h1>Wizard Products Spec</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Wizard Products Spec</li>
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
          <section class="col-lg-3 connectedSortable ui-sortable">

			<p name="msjwaitline" id="msjwaitline" align="center" style="display: none;"><img src="img/waitazul.gif" width="100px"></p>	
			<br>
		
			<div class="card  ">
<br>
			<!-- ---COMPONENTE FILTRADORRRRR----------------------------->
					<div class="form-group col-md-12 " style="font-size:10px;">
			<p class="colorazulfiplex"><b>Quick filters:</b></p>
			<table class="table" border="0">

			<td colspan="4">
			<button type="button" class="btn btn-block btn-outline-primary btn-xs" style="font-size:10px;" onclick="filtrartodo()" >Apply Filters</button> 	<br> </td>
				</tr>
				 <tr>
				 <td>

		 				 <table class="table">
						  <tr>
		 					  <td>          <label>Select Business:</label>
                        <select multiple="" class="form-control form-control-sm" name="lasempresas" id="lasempresas" style="font-size:10px;"  >
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
																											  <?php echo  $row2['namebusiness']." - [".$row2['idbusiness']."]";; ?>
																											  </option>
																											  <?php
																											  }
					
																	 ?>
                        </select></td>
							   <td>
							   <label>Select Bands:</label>
                        <select multiple="" class="form-control form-control-sm" name="lasbandas" id="lasbandas" style="font-size:10px;"  >
						<option value="" >ALL BANDS</option>
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
																											  <?php echo  strtoupper($row2['description'])." - [".$row2['idband']."]"; ?>
																											  </option>
																											  <?php
																											  }
					
																	 ?>
                        </select></td>
						  </tr>
						 </table>
              <hr>
                </td>
				</tr>
				 
				<tr>
				<td> <label>Select Branchs:</label>
						<table class="table  table-sm">																					  		
                       
						<td>
						<select  class="form-control form-control-sm" name="losbranchsquick" id="losbranchsquick"  style="font-size:10px;" onchange="filtrabranchmm(this.value)"   >
					  				 <option value="00010002">MODULE </option>
									 <option value="00010091">PASSIVES </option>  
							
									 <option value="0001000100370039" selected>UNIT BDA </option>  
									 <option value="0001000100370040" >UNIT DAS </option>  
									 <option value="000100010094">UNIT INLINE BOOSTER </option>  
									 <option value="000100010038">UNIT LEGACY </option>  
									 <option value="000100010107">UNIT ANALOG BDA </option>  

                        </select>
						</td></tr>
						</table>						
                        <select multiple="" class="form-control form-control-sm" name="losbranchs" id="losbranchs"  style="font-size:10px;"   >
					  				 <option value=""> All Branchs </option>
																 
<?php 
		$indxtablaadd=0;
		$sql = $connect->prepare("
		select * from
																		   (
																		   select  public.full_tree_namever2_fullbusiness(iduniquebranchprodson, '') as stringtree, iduniquebranchprodson
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
																	    where iduniquebranchprodson like '%0001000100370039%' or  iduniquebranchprodson like '%000100010107%'
																		   order by stringtree");

									$sql->execute();
									$resultado3 = $sql->fetchAll();
									foreach ($resultado3 as $row2) 
									 {
										 $autoselect = '';
										 $autoselect = '';
										 if ( array_search($row2['iduniquebranchprodson'], $lasatribufiltradas)>=0 )
										 {
									   //	$autoselect = 'selected';
										 }
										
									 ?>
									 <option value="<?php echo  $row2['iduniquebranchprodson']; ?>" <?php echo $autoselect;?>>
									 <?php echo  strtoupper( $row2['stringtree'])." - [".substr($row2['iduniquebranchprodson'],4,100)."]"; ?>
									 </option>
									 <?php
									 }
?>
																
                        </select>
						</td>
						</tr>
				<tr>
				<td><hr>
                        <label>Select Attributes:</label>
                        <select multiple="" class="form-control form-control-sm" name="losatributos" id="losatributos" style="font-size:10px;"    >

					


						<option value=""> ALL ATTRIBUTES </option>
												 <?php
												 					
										 echo "select * from products_attributes_type where idattribute in (select idrel  from menu_wizard_options_filters where typetable = 'products_attributes_type'  and idmenu in ( select idmenu from menu where linkaccess = '".array_pop(explode('/', $_SERVER['PHP_SELF']))."') )  order by attributename";
									 		
																	 $indxtablaadd=0;
																	 $sql = $connect->prepare("select * from products_attributes_type where idattribute in (select idrel  from menu_wizard_options_filters where typetable = 'products_attributes_type'  and idmenu in ( select idmenu from menu where linkaccess = '".array_pop(explode('/', $_SERVER['PHP_SELF']))."') )  order by attributename");
														  
																								 $sql->execute();
																								 $resultado3 = $sql->fetchAll();
																								 foreach ($resultado3 as $row2) 
																								  {
																									  $autoselect = '';
																									  $autoselect = '';
																									  if ( array_search($row2['idattribute'], $lasatribufiltradas)>=0 )
																									  {
																									//	$autoselect = 'selected';
																									  }
																									 
																								  ?>
																								  <option value="<?php echo  $row2['idattribute']; ?>" <?php echo $autoselect;?>>
																								  <?php echo  strtoupper($row2['attributename'])." - [".$row2['idattribute']."]"; ?>
																								  </option>
																								  <?php
																								  }
													 

												 ?>
                        </select>
						</td>
		
				</tr>
				<tr>
				<td colspan="4">
				<br> <button type="button" class="btn btn-block btn-outline-primary btn-xs" style="font-size:10px;" onclick="filtrartodo()" >Apply Filters</button> </td>
				</tr>
				</table>	
		
			</div>
		

        </section>
		<section class="col-lg-9 connectedSortable ui-sortable">
		
							<div class="form-group col-md-12  " >
								<!-- tabla producto a updatear 3333  -->
								<div id="tblfilterdiv" name="tblfilterdiv" class="scrollmm">
							
								<!-- fin tabla producto a updatear 3333-->
								</div>	
								<HR>
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
			  <!--  222 Start Definition of bands  -->

			 <div class=" ">
					<div class=" ">
					
			
						  
							  
	
			<div class=" " id="divfasobjband" name="divfasobjband">

		
			 

			  </div>	

			  <div class="container-fluid">
	  <div class="card">
				<?php  if 	($_SESSION["g"] == "develop"    )
				{ ?>
			<p align="right">
				<button name="btnopenrf" id="btnopenrf" type="button" class="btn btn-smk btn-block btn-outline-primary btn-flat" onclick="opendiv('dibbandyrf')">Modify Specifications</button>
			</p>
			<?php } ?>
		  <div class="form-group col-md-12 d-none" id="dibbandyrf" name="dibbandyrf">
		
		  <span class="colorazulfiplex"><b>Band & RF Specs:</b> </span>	<br><br>

		  <table class="table   table-bordered table-sm ">
				<tr>
				<td>	<label for="exampleInputEmail1">Class:</label>   <button type="button" class="btn btn-xs btn-default" onclick="hablitame('divtxttypeclass')" name="btntxttypeclass" id="btntxttypeclass"> <i class="fas fa-edit"></i> Edit </button> </td>
				<td> <label for="exampleInputEmail1">Port IN UL:</label>   <button type="button" class="btn btn-xs btn-default" onclick="hablitame('divcmbportinul')" name="btncmbportinul" id="btncmbportinul"> <i class="fas fa-edit"></i> Edit </button> </td>
				<td> <label for="exampleInputEmail1">Port IN DL:</label>   <button type="button" class="btn btn-xs btn-default" onclick="hablitame('divcmbportindl')" name="btncmbportindl" id="btncmbportindl"> <i class="fas fa-edit"></i> Edit </button>  </td>
				<td> <label for="exampleInputEmail1">Port OUT UL:</label>   <button type="button" class="btn btn-xs btn-default" onclick="hablitame('divcmbportoutul')" name="btncmbportoutul" id="btncmbportoutul"> <i class="fas fa-edit"></i> Edit </button>  </td>
				<td> <label for="exampleInputEmail1">Port OUT DL:</label>   <button type="button" class="btn btn-xs btn-default" onclick="hablitame('divcmbportoutdl')" name="btncmbportoutdl" id="btncmbportoutdl"> <i class="fas fa-edit"></i> Edit </button>  </td>
				
				<td> <label for="exampleInputEmail1">UL Gain:</label>   <button type="button" class="btn btn-xs btn-default" onclick="hablitame('divtxtulgainband')" name="btntxtulgainband" id="btntxtulgainband"> <i class="fas fa-edit"></i> Edit </button>  </td>
				<td> <label for="exampleInputEmail1">DL Gain:</label>   <button type="button" class="btn btn-xs btn-default" onclick="hablitame('divtxtdlgainband')" name="btntxtdlgainband" id="btntxtdlgainband"> <i class="fas fa-edit"></i> Edit </button>  </td>
				<td> <label for="exampleInputEmail1">UL Max Pwr:</label>   <button type="button" class="btn btn-xs btn-default" onclick="hablitame('divtxtulmaxpwrband')" name="btntxtulmaxpwrband" id="btntxtulmaxpwrband"> <i class="fas fa-edit"></i> Edit </button>  </td>
				<td> <label for="exampleInputEmail1">DL Max Pwr:</label>   <button type="button" class="btn btn-xs btn-default" onclick="hablitame('divtxtdlmaxpwrband')" name="btntxtdlmaxpwrband" id="btntxtdlmaxpwrband"> <i class="fas fa-edit"></i> Edit </button>  </td>
			
				</tr>
		  </table>
					<div class="row">
					 
							<div class="form-group col-md-6 d-none" id="divtxttypeclass" name="divtxttypeclass">
								<label for="exampleInputEmail1">Class:</label>  
								
								
								 
									 <select class="form-control form-control-sm "  disabled  name="txttypeclass" id="txttypeclass" required oninvalid="setCustomValidity('Class is required.')" oninput="setCustomValidity('')">
									   <option value=""> - Select - </option>
									  <option value="A">Class A</option>
									  <option value="B">Class B</option>
									
								</select>	
							</div>	
						
							
							<!--aca los ports -->
							<div class="form-group col-md-6  d-none" id="divcmbportinul" name="divcmbportinul">
								
								<label for="exampleInputEmail1">Port IN UL:</label>
									 <select class="form-control form-control-sm  " disabled name="cmbportinul" id="cmbportinul" required oninvalid="setCustomValidity('Port IN UL is required.')" oninput="setCustomValidity('')">
									  
									   <option value=""> - Select - </option>
									<?php
									$sql = $connect->prepare("select * from idport order by description");

									$sql->execute();
									$resultado3 = $sql->fetchAll();
									foreach ($resultado3 as $row2) 
									 {
										
									 ?>
									 <option value="<?php echo  $row2['idport']; ?>">
									 <?php echo  $row2['description']; ?>
									 </option>
									 <?php
									 }
									
									?>
										 
									
								</select>		
								
							</div>
						
							<div class="form-group col-md-6 d-none" id="divcmbportindl" name="divcmbportindl">
								
								<label for="exampleInputEmail1">Port IN DL :</label>
								 <select class="form-control form-control-sm " disabled name="cmbportindl" id="cmbportindl" required oninvalid="setCustomValidity('Port IN DL is required.')" oninput="setCustomValidity('')">
									  <option value=""> - Select - </option>
									<?php
									$sql = $connect->prepare("select * from idport order by description");

									$sql->execute();
									$resultado3 = $sql->fetchAll();
									foreach ($resultado3 as $row2) 
									 {
										
									 ?>
									 <option value="<?php echo  $row2['idport']; ?>">
									 <?php echo  $row2['description']; ?>
									 </option>
									 <?php
									 }
									
									?>
										  
									
								</select>	
								
							</div>
								<div class="form-group col-md-6 d-none" id="divcmbportoutul" name="divcmbportoutul">
							
							<label for="exampleInputEmail1">Port OUT UL :</label>
									  <select class="form-control form-control-sm " disabled  name="cmbportoutul" id="cmbportoutul" required oninvalid="setCustomValidity('Port OUT UL is required.')" oninput="setCustomValidity('')">
										<option value=""> - Select - </option>
									<?php
									$sql = $connect->prepare("select * from idport order by description");

									$sql->execute();
									$resultado3 = $sql->fetchAll();
									foreach ($resultado3 as $row2) 
									 {
										
									 ?>
									 <option value="<?php echo  $row2['idport']; ?>">
									 <?php echo  $row2['description']; ?>
									 </option>
									 <?php
									 }
									
									?>
									
								</select>	
							</div>
							<div class="form-group col-md-6 d-none" id="divcmbportoutdl" name="divcmbportoutdl">
								
								<label for="exampleInputEmail1">Port OUT DL :</label>
									 <select class="form-control form-control-sm  " disabled  name="cmbportoutdl" id="cmbportoutdl" required oninvalid="setCustomValidity('Port OUT DL is required.')" oninput="setCustomValidity('')">
									  <option value=""> - Select - </option>
									<?php
									$sql = $connect->prepare("select * from idport order by description");

									$sql->execute();
									$resultado3 = $sql->fetchAll();
									foreach ($resultado3 as $row2) 
									 {
										
									 ?>
									 <option value="<?php echo  $row2['idport']; ?>">
									 <?php echo  $row2['description']; ?>
									 </option>
									 <?php
									 }
									
									?>
								</select>	
								
							</div>
								<div class="form-group col-md-6 d-none" id="divtxtulgainband" name="divtxtulgainband">
								<label for="exampleInputEmail1">UL Gain:</label>
									  <input type="text" name="txtulgainband" disabled id="txtulgainband" class="form-control form-control-sm  " placeholder="UL Gain" required oninvalid="setCustomValidity('UL Gain is required.')" 
		   oninput="setCustomValidity('')" value="">			   
							
							</div>
						
							<div class="form-group col-md-6 d-none" id="divtxtdlgainband" name="divtxtdlgainband">
							
							<label for="exampleInputEmail1">DL Gain :</label>
								  <input type="text" name="txtdlgainband" id="txtdlgainband" disabled class="form-control form-control-sm   " placeholder="DL Gain " required oninvalid="setCustomValidity('DL Gain is required.')" 
		   oninput="setCustomValidity('')" value=" ">	
							</div>
								<div class="form-group col-md-6 d-none" id="divtxtulmaxpwrband" name="divtxtulmaxpwrband">
								
								<label for="exampleInputEmail1">UL Max Pwr:</label>
									 <input type="text" name="txtulmaxpwrband" id="txtulmaxpwrband" disabled class="form-control form-control-sm  " placeholder="UL Max Pwr" required oninvalid="setCustomValidity('UL Max Pwr is required.')" 
		   oninput="setCustomValidity('')" value="">		
								
							</div>
							<div class="form-group col-md-6 d-none" id="divtxtdlmaxpwrband" name="divtxtdlmaxpwrband">
								
								<label for="exampleInputEmail1">DL Max Pwr :</label>
									 <input type="text" name="txtdlmaxpwrband" id="txtdlmaxpwrband" disabled class="form-control form-control-sm " placeholder="DL Max Pwr " required oninvalid="setCustomValidity('DL Max Pwr is required.')" 
		   oninput="setCustomValidity('')" value="">	
								
							</div>
							
							<div class="form-group col-md-12">
							<?php if ( $_SESSION["g"] == "develop" ) 
							{
								?>
									<p align="right">
										<button name="btnaddband" id="btnaddband" type="button" class="btn btn-smk btn-block btn-outline-primary btn-flat" onclick="update_selected_ciu()">Update selected CIU</button>
									</p>
									<?php } ?>
									<div id="divlist_tabla_gain_rf" name="divlist_tabla_gain_rf">
									</div>
									<input type="hidden" name="divlist_tabla_gain_rftexto" id="divlist_tabla_gain_rftexto" value="">
							</div>
							
					</div>
			</div>
				<!-- end  - Definition of bands  -->					  	

		  </div>
	   </div>
	   </div>
	   <!--  fintabla band a updatear 222222  -->

 
	
		
	  
	  </section></div>	
	  <!-- tabla band a updatear 222222  -->  
	

										
		 
												
					</div>
				
				
			 </div>	
	</div>
		</div>

		<!-- --FIN2222 COMPONENTE FILTRADORRR------------------------------>
	  
		  </div><!-- /.card-pane-right -->
		</div><!-- /.d-md-flex -->
	  </div>
	  <!-- /.card-body -->
	  <!-- /.fin 3div de ramas-->


							</div>
						</div>	
				
			

            </div>
		
				  
				     
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
          <section class="col-lg-3 connectedSortable ui-sortable">

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
		<section class="col-lg-9 connectedSortable ui-sortable">
		

				
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
		 

			var xhr2 = new XMLHttpRequest();
			xhr2.open("POST", "searchcuicomponentfiltersv2.php");
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
	
		$("#"+ qcontroltel).removeAttr("disabled");
		$("#btn"+qcontroltel).removeClass('btn-default');
		$("#btn"+qcontroltel).addClass('btn-primary');
	}
	else
	{
		$("#"+qcontrol).addClass('d-none');
		$("#"+ qcontroltel).prop('disabled', 'disabled');
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
			//	  filtrartodo();
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

function filtrabranchmm(qfiltramosmm)
{
	console.log('q filtramos' +qfiltramosmm );
//	$('#losbranchsquick').empty();
//$('#msjwaitline').show();
var xma = document.getElementById("losbranchs");
			$.ajax
            ({ 
				url: "ajax_list_branchbusiness.php?searc="+qfiltramosmm,              
              type: 'post',				
              datatype:'JSON',                
              success: function(data)
              {
				console.log( data.losbranch.length);
              console.log(data);
	  
              $("#losbranchs").empty();
                  for(var i=0; i< data.losbranch.length ;i++)
                {
                    console.log(data.losbranch[i].iduniquebranchprodson );
                    
                  //  myDrop1
				 	 var option = document.createElement("option");
  							option.value = data.losbranch[i].iduniquebranchprodson;
  							console.log('girando' + option.value);
  						option.text = data.losbranch[i].stringtree ;
  						xma.add(option);

              ///      $("#losbranchsquick").append("<i class='fas fa-file'></i> "+data.attachlist[i].fileattach+" <a href='#' onclick='delattach('"+ data.attachlist[i].idnroattach +","+data.attachlist[i].fileattach+"')'><i class='far fa-times-circle' style='color:red'></i></a><br>" );
                } 
				//$('#msjwaitline').hide();
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
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
	//		header("Location: http://".$ipservidorapache."/".$folderservidor."/permissiondenied.php?b=".$_SESSION["b"]."&c=".array_pop(explode('/', $_SERVER['PHP_SELF'])));
	//		exit();
		}
	
	
	$status = $connect->getAttribute(PDO::ATTR_CONNECTION_STATUS);
	
	if ($status !="Connection OK; waiting to send.")
	{
	
		header("Location: http://".$ipservidorapache."/".$folderservidor."/errorconect.php");
		exit;
		
	}
	

$msjdegrabo="";	
$lasempresasfiltradas = "";
$lasbandasfiltradas = "";
 
if($_POST)
	{

		//levantamos los valores ingresamos para modificar
		////txtfpgafile alias de V_integer
 		$v_txtfpgafile = $_REQUEST['txtfpgafile'];
        //// txtmicrofile alias v_double
		$v_txtmicrofile = $_REQUEST['txtmicrofile'];
		// txtethfile - alias v_string
		$v_txtethfile = $_REQUEST['txtethfile'];
		/// txtfpgafas -- alias v_boolena
		$v_txtfpgafas = $_REQUEST['txtfpgafas'];

	 
	 
		echo "HOla v_txtrfon1: ".$v_txtfpgafile;
		 


		$v_chkprod = $_REQUEST['chkprod'];
	//	echo 	"hola_".$v_chkprod;

	//	$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	//	$connect->beginTransaction();
		try {


			foreach ($v_chkprod as $clave2=>$valor2)
			{
			
				$losvalores = explode("#",$valor2);
			//	$maxidrevmasuno = intval($losvalores[2]) + 1;
				$idoutcomeaupdateear = str_replace("chkprod", "", $losvalores[1]);  
			//	echo "<br>chkprod valor de ".$clave2." es: ".$valor2."-->".$idoutcomeaupdateear;
				$setear_sql1="";
				$setear_sql2="";
				$setear_sql3="";
				$setear_sql4="";
				
					$sumocoma="N";
					if ($v_txtfpgafile <> "")
					{
					//	echo "1";
						$setear_sql1= " v_integer=".$v_txtfpgafile ." ";
						$sumocoma="S";
					}
					if ($v_txtmicrofile <> "")
					{
						//echo "2";
						if ($sumocoma=="S")
						{
							$setear_sql2=$setear_sql2.",";
							$sumocoma="N";
						}
						$setear_sql2= $setear_sql2." v_double=".$v_txtmicrofile ." ";
						$sumocoma="S";
					}
					if ($v_txtethfile <> "")
					{
						//echo "2";
						if ($sumocoma=="S")
						{
							$setear_sql3=$setear_sql3.",";
							$sumocoma="N";
						}
						$setear_sql3= $setear_sql3." v_string='".$v_txtethfile ."' ";
						$sumocoma="S";
					}
					if ($v_txtfpgafas <> "")
					{
						//echo "2";
						if ($sumocoma=="S")
						{
							$setear_sql4=$setear_sql4.",";
							$sumocoma="N";
						}
						$setear_sql4= $setear_sql4." v_boolean=".$v_txtfpgafas ." ";
						$sumocoma="S";
					}
				 
					
					$slqbandupd ="";
				
					$slqbandupd ="UPDATE fas_income_integral set ".$setear_sql1.$setear_sql2.$setear_sql3.$setear_sql4." where id_income = ".$idoutcomeaupdateear;
				//	echo "<br>".$slqbandupd ;
				
				 	$connect->query($slqbandupd);
					$msjdegrabo= "Update OK.!";
				}


						/////////////////////////////////////////////////////////////////////////////////////
							//////AUDITAMOS///////////////////////////////////////////////////////////////////////////////
							$vuserfas = $_SESSION["b"];
							$typeregister="PO";
							$vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
							$vaccionweb="update fas_income_integral";
							$vdescripaudit="update fas_income_integral -".$valor2;
							$vtextaudit= $slqbandupd; 
						
					
									$sentenciaudit = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
									$sentenciaudit->bindParam(':userfas', $vuserfas);								
									$sentenciaudit->bindParam(':menuweb', $vmenufas);
									$sentenciaudit->bindParam(':actionweb', $vaccionweb);
									$sentenciaudit->bindParam(':descripaudit', $vdescripaudit);
									$sentenciaudit->bindParam(':textaudit', $vtextaudit);
										$sentenciaudit->execute();
									
									
					/////////////////////////////////////////////////////////////////////////////////////
					/////////////////////////////////////////////////////////////////////////////////////



				
			
		//	$connect->commit();
		//	exit();
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
<form name="frma" id="frma" action="wizardoutincome.php" method="post" class="form-horizontal">
 
	

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
            <h1>Wizard Products IN OUT COME </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Wizard Products IN OUT COME</li>
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
        
		<section class="col-lg-12 connectedSortable ui-sortable">
		

				
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

					<div class="form-group col-md-12 ">
			<b>Mandatory filters :</b>
			<table class="table table-striped" >

			<tr><td>

			
			Select Script: <br>
			<select class="form-control form-control-sm" name="losscriptmam" id="losscriptmam" onclick="filtrartodostep(1,this.value)"  >
						<option value=""> - Select - </option>
						<?php
												 					
																

																	 $sql = $connect->prepare("   select distinct scriptname, fas_income_integral.idscript 
																	 from fas_income_integral
																	 left join fas_script_type
																	 on fas_script_type.idscripttype =  fas_income_integral.idscript 	 where scriptname is not null  order by scriptname ");
																	  
																											 $sql->execute();
																											 $resultado3 = $sql->fetchAll();
																											 foreach ($resultado3 as $row2) 
																											  {
																												 
																												// echo "*************". array_search($row2['idbusiness'], $lasempresasfiltradas);
																											  ?>
																										  <option value="<?php echo  $row2['idscript']; ?>" <?php echo $autoselect;?>>
																											  <?php echo  $row2['scriptname']." - [".$row2['idscript']."]" ; ?>
																											  </option>
																											  <?php
																											  }
					
																	 ?>
                        </select>
			</td> <td>

			
Select Steps: <br>
<select class="form-control form-control-sm" name="losstepmmam" id="losstepmmam"  onclick="filtrartodostep(2,this.value)"  >
			<option value=""> - Select - </option>
	 
			</select>
</td></tr>


				 <tr>
			
				<td>
                        <label>Select Category</label>
                        <select   class="form-control form-control-sm" name="losscriptsteps" id="losscriptsteps" onclick="filtrartodostep(3,this.value)"  >
						 
					 
                        </select>
                </td>
				<td>
                        <label>Select  Category Type </label>
                        <select  class="form-control form-control-sm" name="lascategoriastipos" id="lascategoriastipos" onclick="filtrartodo()"  >
					 
					 
                        </select>
                </td>
				</table>
				</div>																							  

					<!-- ---COMPONENTE FILTRADORRRRR----------------------------->
					<div class="form-group col-md-12 ">
					<b>Quick filters:</b>
			<table class="table table-striped">
				 <tr>
				 <td>
                        <label>Select Business</label>
                        <select multiple="" class="form-control form-control-sm" name="lasempresas" id="lasempresas"    >
						<option value="" >ALL Business </option>
						<?php
												 					
																

																	 $sql = $connect->prepare("select * from business where active= 'true' order by namebusiness");
																	  
																											 $sql->execute();
																											 $resultado3 = $sql->fetchAll();
																											 foreach ($resultado3 as $row2) 
																											  {
																												  $autoselect = '';
																												//  echo $lasempresasfiltradas."a ver".array_search($row2['idbusiness'], $lasempresasfiltradas);																												  
																												  if(strlen($lasempresasfiltradas) >0)
																												  {
																													 	
																													if ( array_search($row2['idbusiness'], $lasempresasfiltradas)>=0 )
																													{
																											//		  $autoselect = 'selected';
																													}
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
																												  if ( array_search($row2['idband'], $lasbandasfiltradas)>=0 )
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
				 
				<td>
                        <label>Select Branchs</label>
					

                        <select multiple="" class="form-control form-control-sm" name="losbranchs" id="losbranchs"     >
					  				 <option value=""> All Branchs </option>
																	 <?php
																	 
																
																	/// BRANCHS GENERICOS A MANO OJOO
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
																	 where stringtree like '%TddETRA%'  
																 
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
UNIT --&gt; FLEX --&gt; DAS --&gt; PCS																											  </option>
<option value="00010037004000480050">
UNIT --&gt; FLEX --&gt; DAS --&gt; PCS --&gt; MASTER																											  </option>
<option value="000100370040004800500057">
UNIT --&gt; FLEX --&gt; DAS --&gt; PCS --&gt; MASTER --&gt; 700/800																											  </option>
<option value="00010037004000480051">
UNIT --&gt; FLEX --&gt; DAS --&gt; PCS --&gt; REMOTE																											  </option>
<option value="000100370040004800510059">
UNIT --&gt; FLEX --&gt; DAS --&gt; PCS --&gt; REMOTE --&gt; 700/800																											  </option>

<option value="00010037003900440108">
UNIT --> FLEX --> BDA --> VHF/UHF --> TETRA																									  </option>
<option value="0001003700400048005000580111">
UNIT --> FLEX --> DAS --> PSC --> MASTER --> RACK MOUNT --> TETRA																								  </option>
<option value="0001003700400048005000560109">
UNIT --> FLEX --> DAS --> PSC --> MASTER --> VHF/UHF --> TETRA																								  </option>
<option value="0001003700400048005100600110">
UNIT --> FLEX --> DAS --> PSC --> REMOTE --> VHF/UHF --> TETRA																							  </option>
																
<option value="00010002001300350068">
MODULE --&gt; DIGITAL BOARD --&gt; FLEX --&gt; BDA																										  </option>
<option value="00010002001300350036">
MODULE --&gt; DIGITAL BOARD --&gt; FLEX --&gt; DAS																										  </option>
																
<option value="000200130035006800340112">
MODULE --&gt; DIGITAL BOARD --&gt; FLEX --&gt; BDA --&gt; VHF/UHF --&gt; TETRA																									  </option>
                        </select>
						</td>
				<td>
                        <label>Select Attributes</label>
                        <select multiple="" class="form-control form-control-sm" name="losatributos" id="losatributos"    >

					


						<option value=""> All Attributes </option>
												 <?php
												 					
																	 $indxtablaadd=0;
												 $sql = $connect->prepare("select * from products_attributes_type    order by attributename");
												  
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
																							  if ($row2['idattribute']==0)
																							 {
																								?>
																								<option value="NOT<?php echo  $row2['idattribute']; ?>" <?php echo $autoselect;?>>
																								 Is Final SKU 
																								</option>
																								<option value=" <?php echo  $row2['idattribute']; ?>" <?php echo $autoselect;?>>
																								 <?php echo  $row2['attributename']; ?>
																								</option>
																								<?php
																							 }
																							 else
																							 {
																								?>
																								<option value="<?php echo  $row2['idattribute']; ?>" <?php echo $autoselect;?>>
																								<?php echo  $row2['attributename']; ?>
																								</option>
																								<?php
																							 }
																						
																							 
																						  ?>
																					 
																						  <?php
																						  }

																						  $sql = $connect->prepare("select * from products_attributes_type    order by attributename");
												  
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
																							   if ($row2['idattribute'] == 0)
																							  {
																								  
																							  }
																							  else
																							  {
																								 ?>
																								 <option value="NOT<?php echo  $row2['idattribute']; ?>" <?php echo $autoselect;?>>
																								 <?php echo  "NOT -> ". $row2['attributename']; ?>
																								 </option>
																								 <?php
																							  }
																						 
																							  
																						   ?>
																					  
																						   <?php
																						   }
 

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
			  <p align="right">
						<button name="btnopenrf" id="btnopenrf" type="button" class="btn btn-smk btn-block btn-outline-primary btn-flat" onclick="opendiv('dibbandyrf')">Modify Specifications</button>
					</p>
				  <div class="form-group col-md-12 d-none" id="dibbandyrf" name="dibbandyrf">
				
			

				  <table class="table   table-bordered table-sm ">
						<tr>
					  	    <td>	<label for="exampleInputEmail1">Integer Value:</label>   <button type="button" class="btn btn-xs btn-default" onclick="hablitame('divtxtfpgafile')" name="btntxtfpgafile" id="btntxtfpgafile"> <i class="fas fa-edit"></i> Edit </button> </td>
							<td>	<label for="exampleInputEmail1">Double Value:</label>   <button type="button" class="btn btn-xs btn-default" onclick="hablitame('divtxtmicrofile')" name="btntxtmicrofile" id="btntxtmicrofile"> <i class="fas fa-edit"></i> Edit </button> </td>
							<td>	<label for="exampleInputEmail1">String Value:</label>   <button type="button" class="btn btn-xs btn-default" onclick="hablitame('divtxtethfile')" name="btntxtethfile" id="btntxtethfile"> <i class="fas fa-edit"></i> Edit </button> </td>
							<td>	<label for="exampleInputEmail1">Boolean Value:</label>   <button type="button" class="btn btn-xs btn-default" onclick="hablitame('divtxtfpgafas')" name="btntxtfpgafas" id="btntxtfpgafas"> <i class="fas fa-edit"></i> Edit </button> </td>
					     </tr>
				  </table>
							<div class="row">
						 	
									<div class="form-group col-md-6 d-none" id="divtxtfpgafile" name="divtxtfpgafile">
										<label for="exampleInputEmail1">Integer Value:</label> 										
										<input type="text" name="txtfpgafile"   id="txtfpgafile" class="form-control form-control-sm  " value="">	
										<input type="hidden" name="txtfpgafiler"     id="txtfpgafiler" class="form-control form-control-sm  " value="">	
									</div>	
									<div class="form-group col-md-6 d-none" id="divtxtmicrofile" name="divtxtmicrofile">
										<label for="exampleInputEmail1">Double Value:</label> 										
										<input type="text" name="txtmicrofile"   id="txtmicrofile" class="form-control form-control-sm  " value="">	
										<input type="hidden" name="txtmicrofiler"     id="txtmicrofiler" class="form-control form-control-sm  " value="">	
									</div>
									<div class="form-group col-md-6 d-none" id="divtxtethfile" name="divtxtethfile">
										<label for="exampleInputEmail1">String Value:</label> 										
										<input type="text" name="txtethfile"   id="txtethfile" class="form-control form-control-sm  " value="">	
										<input type="hidden" name="txtethfiler"     id="txtethfiler" class="form-control form-control-sm  " value="">	
									</div>		
									<div class="form-group col-md-6 d-none" id="divtxtfpgafas" name="divtxtfpgafas">
										<label for="exampleInputEmail1">Boolean Value:</label> 										
										<select name="txtfpgafas" id="txtfpgafas"  class="form-control form-control-sm">
                            <option value=""> - Select - </option>
                            <option value="TRUE"> True</option>
                            <option value="FALSE"> False</option>
                          </select>
									</div>
								 
							 
									
									<div class="form-group col-md-12">
									<?php if ( $_SESSION["g"] == "develop" ) 
									{
										?>
											<p align="right">
												<button name="btnaddband" id="btnaddband" type="button" class="btn btn-smk btn-block btn-outline-primary btn-flat" onclick="update_selected_ciu(); ">Update selected  </button>
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
							   
            <li role="presentation" aria-selected="false" aria-level="2" aria-labelledby="ajax_ciu_adddoc*1129_anchor" id="ajax_ciu_adddoc*1129" class="jstree-node  jstree-leaf"><i class="jstree-icon jstree-ocl" role="presentation"></i>
									  <a class="jstree-anchor" href="wizardproductsspecsdocu.php" tabindex="-1" role="treeitem" aria-selected="false" aria-level="2" id="ajax_ciu_adddoc*1129_anchor"><i class="jstree-icon jstree-themeicon fas fa-check jstree-themeicon-custom" role="presentation"></i>
									  	Documentation</a></li>
		
					
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

                  
		           	 // AutoComplete de CUIS version TOP

     
                  load_tree_categorytype (0 );
                  load_tree_scriptsteps(0);
 

// fin// AutoComplete de CUIS version TOP	

			
	});
	

	// controlar inactividad en la web	
		$(document).inactivityTimeout({
                inactivityWait: 10000,
                dialogWait: 10,
                logoutUrl: 'logout.php'
            })
	// fin controlar inactividad en la web		
	
 


  function load_tree_scriptsteps(idinoutt )
{
	
var jsonTreeData = "";

	$.ajax({
				url: 'ajax_list_tree_scriptsteps.php?idinout='+idinoutt ,			
				type: 'post',				
				datatype:'JSON',				
				cache:false,					
				success: function(data, status, xhr) {
					jsonTreeData= data ;
				//console.log(jsonTreeData);
				//	console.log(exData);
					 $('#treescriptsteps').jstree({
    core: {
      check_callback: 
			function (op, node, par, pos, more) {
			
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
					      if((op === "move_node" || op === "copy_node")   && more && more.core  ) {
							   console.log(node.idm);
							   console.log(node.id);
								console.log(par.id);
															
						    }
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
  
				
			return false;	
				
				},
				error: function(xhr, status, error) {
					 console.log(status);
				}
				});
				
/////
 
 
///
}

  function load_tree_categorytype(idinoutt )
{
	
var jsonTreeData = "";

	$.ajax({
				url: 'ajax_list_tree_categorytypeinoutcome.php?idinout='+idinoutt ,			
				type: 'post',				
				datatype:'JSON',				
				cache:false,					
				success: function(data, status, xhr) {
					jsonTreeData= data ;
				//console.log(jsonTreeData);
				//	console.log(exData);
					 $('#treecategory').jstree({
    core: {
      check_callback: 
			function (op, node, par, pos, more) {
			
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
					      if((op === "move_node" || op === "copy_node")   && more && more.core  ) {
							   console.log(node.idm);
							   console.log(node.id);
								console.log(par.id);
															
						    }
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
  
				
			return false;	
				
				},
				error: function(xhr, status, error) {
					 console.log(status);
				}
				});
				
 
 
///
}


function filtrartodo()
	{
		$("#tblfilterdiv").html(' 	<p name="msjwaitline" id="msjwaitline" align="center"><img src="img/waitazul.gif" width="100px" ><b> Searching... </b></p>	 ');	 
	var lasempresas = $("#lasempresas").val().toString();
	var lasbandas = $("#lasbandas").val().toString();
	var losbranchs = $("#losbranchs").val().toString();
	var losatributos = $("#losatributos").val().toString();
//	var losuldl =  $("#losuldl").val().toString();
	///var lasmediciones =  $("#lasmediciones").val().toString();
     var lascategorias =  $("#losscriptsteps").val().toString();
	 var lascategoriastypes =  $("#lascategoriastipos").val().toString();
	 var losscript =  $("#losstepmmam").val().toString();

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
			formData.append("lascategorias", lascategorias);
			formData.append("lascategoriastype", lascategoriastypes);

		 
			formData.append("losscript", losscript);
		//	formData.append("losuldl", losuldl);
		//	formData.append("lasmediciones", lasmediciones);
		 

			var xhr2 = new XMLHttpRequest();
			xhr2.open("POST", "searchcuicomponentfiltersinoutcome.php");
			xhr2.send(formData);
			
			xhr2.onload = function() {
				  if (xhr2.status == 200) {  
					
					//	console.log('devolvio el idaccionweb 1:' + xhr2.response);	
						$("#tblfilterdiv").html(xhr2.response);		 
					
				  }
				 
				};

	}

	function selectallmarco()
{
	$(".chkclassmarco").prop('checked', true);
}

	function filtrartodostep( idtyp, valuemm)
	{
	 /// 1 = script
	 if (valuemm != '')
	 {
			
			if (idtyp==1)
			{
				var armando_tabla ="";
					$.ajax({
							url: 'listinstance_cat_type_income.php?idtyp='+idtyp+'&valuemm='+valuemm ,										
							cache:false,
							success: function(respuesta) {
								
								console.log('HOLa');
							

								var returnedData = JSON.parse(respuesta);
							//	console.log(returnedData);
							$('#losstepmmam').empty();
							$('#losstepmmam').append($('<option />', {
												value: '',
												text: ' - Select - '
											}));
						
								$.each(returnedData.data, function (index, value) {
											$('#losstepmmam').append($('<option />', {
												value: value.in_instance,
												text: value.description
											}));
											
										});

						
							},
							error: function() {
								console.log("No se ha podido obtener la información");
							}
							
						});
			}
			if (idtyp==2)
			{
				var armando_tabla ="";
					$.ajax({
							url: 'listinstance_cat_type_income.php?idtyp='+idtyp+'&valuemm='+valuemm ,										
							cache:false,
							success: function(respuesta) {
								
								console.log('HOLa');
							

								var returnedData = JSON.parse(respuesta);
							//	console.log(returnedData);
							$('#losscriptsteps').empty();
							$('#losscriptsteps').append($('<option />', {
												value: '',
												text: ' - Select - '
											}));
						
								$.each(returnedData.data, function (index, value) {
											$('#losscriptsteps').append($('<option />', {
												value: value.in_instance,
												text: value.description
											}));
										 
										});

						
							},
							error: function() {
								console.log("No se ha podido obtener la información");
							}
							
						});
			}
			if (idtyp==3)
			{
				var armando_tabla ="";
					$.ajax({
							url: 'listinstance_cat_type_income.php?idtyp='+idtyp+'&valuemm='+valuemm+'&vinstance='+$('#losstepmmam').val()   ,										
							cache:false,
							success: function(respuesta) {
								
							//	console.log('HOLa');
							

								var returnedData = JSON.parse(respuesta);
							//	console.log(returnedData);lascategoriastipos
							$('#lascategoriastipos').empty();
							$('#lascategoriastipos').append($('<option />', {
												value: '',
												text: ' - Select - '
											}));
							
								$.each(returnedData.data, function (index, value) {
											$('#lascategoriastipos').append($('<option />', {
												value: value.in_instance,
												text: value.description
											}));
										 
										});

						
							},
							error: function() {
								console.log("No se ha podido obtener la información");
							}
							
						});
			}
	 }


									
									
									
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
		////$("#"+ qcontroltel).prop('disabled', 'disabled');
		$("#btn"+qcontroltel).removeClass('btn-primary');
		$("#btn"+qcontroltel).addClass('btn-default');
	}
}

function update_selected_ciu()
{
	$('#frma').submit();
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
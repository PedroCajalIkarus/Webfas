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


	///////////////////////////////////////////////////////////////////////////////////////////
	if($_POST)
	{

		//levantamos los valores ingresamos para modificar
		$v_elciuselect= $_REQUEST['txtlistcius'];
		$v_select_script = $_REQUEST['losscriptmam'];
		$v_select_steps = $_REQUEST['losstepmmam'];
		$v_select_category = $_REQUEST['losscriptsteps'];
		$v_select_categorytipe = $_REQUEST['lascategoriastipos'];

		$v_select_band = $_REQUEST['lasbandas'];
		$v_select_uldl = $_REQUEST['losuldl'];
	 

	/*	echo "<br>v_elciuselect:".$v_elciuselect;
		echo "<br>v_select_script:".$v_select_script;
		echo "<br>v_select_steps:".$v_select_steps;
		echo "<br>v_select_category:".$v_select_category;
		echo "<br>v_select_categorytipe:".$v_select_categorytipe;


		echo "<br>v_select_band:".$v_select_band;
		echo "<br>v_select_uldl:".$v_select_uldl;*/

		////txtfpgafile alias de V_integer
 		$v_txtfpgafile = $_REQUEST['txtfpgafile'];
        //// txtmicrofile alias v_double
		$v_txtmicrofile = $_REQUEST['txtmicrofile'];
		// txtethfile - alias v_string
		$v_txtethfile = $_REQUEST['txtethfile'];
		/// txtfpgafas -- alias v_boolena
		$v_txtfpgafas = $_REQUEST['txtfpgafas'];
		/// txtfpgafas -- alias v_boolena
	 

		if ($v_txtfpgafile=="")
		{
			$v_txtfpgafile="NULL";
		}
		if ($v_txtmicrofile=="")
		{
			$v_txtmicrofile="NULL";
		}
		if ($v_txtethfile=="")
		{
			$v_txtethfile="NULL";
		}
		if ($v_txtfpgafas=="")
		{
			$v_txtfpgafas="NULL";
		}
	 
	 
	/*	echo "<br>HOla v_txtrfon: ".$v_txtfpgafile;
		echo "<br>HOla v_txtmicrofile: ".$v_txtmicrofile;
		echo "<br>HOla v_txtethfile: ".$v_txtethfile;
		echo "<br>HOla v_txtfpgafas: ".$v_txtfpgafas;
		echo "<br>HOla txtethfilebigint: ".$txtethfilebigint;
*/

		$v_chkprod = $_REQUEST['chkprod'];


		foreach ($v_chkprod as $clave2=>$valor2)
		{
			//	echo "<br>chkprod valor de ".$clave2." es: ".$valor2;
			$losvalores = explode("#",$valor2);
			$maxidrevmasuno = intval($losvalores[2]) + 1;
			$idbandselect = $losvalores[3];
		//	echo "<br>---------------idprduct". $losvalores[1];

			$vidrefparameter = "NULL";
			$v_elciuselect =  $losvalores[1];

			if ($v_select_band == "" && $v_select_uldl == "" )
			{
	
	
				$query_lista = "select distinct idreference from  fas_tree_product_references where idproduct = ".$v_elciuselect." and idscripttype=".$v_select_script." and fas_tree_product_references.iduniquebranch = '".$v_select_steps."' ";
				$data = $connect->query($query_lista)->fetchAll();	
				foreach ($data as $rowmf) {			
					$vidrefparameter = $rowmf['idreference'];
				 }
	
	
			///	$armoquery=" call sp_insert_fas_income_integral(".$v_elciuselect.",".$v_select_script.",'".$v_select_steps."',".$v_select_category.",".$v_select_categorytipe.",".$v_txtfpgafile.",".$v_txtmicrofile.",'".$v_txtethfile."',null,".$v_txtfpgafas.",".$vidrefparameter.") ";
				////cambiamos todo a sin ref
				$armoquery=" call sp_insert_fas_income_integral_sinidbanuldl_sinref(".$v_elciuselect.",".$v_select_script.",'".$v_select_steps."',".$v_select_category.",".$v_select_categorytipe.",".$v_txtfpgafile.",".$v_txtmicrofile.",'".$v_txtethfile."',null,".$v_txtfpgafas.") ";
				
				 
			}
			else
			{
	
				/*$query_lista = "select distinct idreference from  fas_tree_product_references where idproduct = ".$v_elciuselect." and idscripttype=".$v_select_script." and fas_tree_product_references.iduniquebranch = '".$v_select_steps."' and fas_tree_product_references.idband = ".$v_select_band." and uldl = ".$v_select_uldl;
				$data = $connect->query($query_lista)->fetchAll();	
				foreach ($data as $rowmf) {			
					$vidrefparameter = $rowmf['idreference'];
				 }*/
	
				///$armoquery=" call sp_insert_fas_income_integral_by_idbanuldl(".$v_elciuselect.",".$v_select_script.",'".$v_select_steps."',".$v_select_category.",".$v_select_categorytipe.",".$v_select_band.",". $v_select_uldl.",".$v_txtfpgafile.",".$v_txtmicrofile.",'".$v_txtethfile."',null,".$v_txtfpgafas.",".$vidrefparameter.") ";
				////cambiamos todo a sin ref
				$armoquery=" call sp_insert_fas_income_integral_by_idbanuldl_sinref(".$v_elciuselect.",".$v_select_script.",'".$v_select_steps."',".$v_select_category.",".$v_select_categorytipe.",".$v_select_band.",". $v_select_uldl.",".$v_txtfpgafile.",".$v_txtmicrofile.",'".$v_txtethfile."',null,".$v_txtfpgafas.") ";
			
			}
	
		///	echo "a";
			echo "------------------------------<br>El Query a Ejecutar:".$armoquery;
			echo "<br>------------------------------<br>";
			$connect->query($armoquery); 
			/*
			call sp_insert_fas_income_integral(612,21,'0520BF0C00C1',0,27,0,50,null,null,null,9728)
			-------------------------
			call sp_insert_fas_income_integral_by_idbanuldl(611,21,'0520BF0C00C1',0,28,0,0,0,-30,null,null,null,9729)
			*/
			$vuserfas = $_SESSION["b"];
		
			$vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
			$vaccionweb="INSERT Income";
			$vdescripaudit="NEW Income integral".$vuserfas;
			$sentenciaudit = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
			$sentenciaudit->bindParam(':userfas', $vuserfas);								
			$sentenciaudit->bindParam(':menuweb', $vmenufas);
			$sentenciaudit->bindParam(':actionweb', $vaccionweb);
			$sentenciaudit->bindParam(':descripaudit', $vdescripaudit);
			$sentenciaudit->bindParam(':textaudit', $armoquery);
			$sentenciaudit->execute();

		}
 

	
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
<form name="frma" id="frma"  method="post" class="form-horizontal"  >
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

<form name="frma" id="frma" action="addreference_income_addbygroup.php" method="post" class="form-horizontal">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add measurement references in a category and type of a CIU LIST</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add measurement references</li>
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

     
            <div class="" name="divscrolllog" id="divscrolllog"  >
			<p name="msjwaitline" id="msjwaitline" align="center"><img src="img/waitazul.gif" width="100px" ></p>	
				<div class="card container-fluid">
					  

        
			   

 		<!-- Start Definition of bands  -->
		 <div class=" " id="divfasobjband" name="divfasobjband">

<!-- ---COMPONENTE FILTRADORRRRR----------------------------->
<div class="form-group col-md-12 ">
<b>Quick filters:</b>
<table class="table table-striped">
<tr>
<td>
	<label>Select Business</label>
	<select multiple="" class="form-control form-control-sm" name="lasempresas" id="lasempresas"   >
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
                        <select multiple="" class="form-control form-control-sm" name="lasbandas" id="lasbandas"  >
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
<td>
	<label>Select Branchs</label>


	<select multiple="" class="form-control form-control-sm" name="losbranchs" id="losbranchs"    >
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
												 where stringtree like '%UNIT%' and
												 stringtree not like '%700%' and
												 stringtree not like '%800%' and
												 stringtree not like '%HF%' and
												  stringtree not like '%RACK%' and
												 ( stringtree like '%BDA%' or stringtree like '%DAS%' ) 
												 order by stringtree
												  ");
												  
																						 $sql->execute();
																						 $resultado3 = $sql->fetchAll();
																					/*	 foreach ($resultado3 as $row2) 
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
																						  }*/

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
<option value="00010002001300350068">
MODULE --&gt; DIGITAL BOARD --&gt; FLEX --&gt; BDA																										  </option>
<option value="00010002001300350036">
MODULE --&gt; DIGITAL BOARD --&gt; FLEX --&gt; DAS																										  </option>
<option value="00010038">
UNIT --&gt; LEGACY																											  </option>	
											
	</select>
	</td>
<td>
	<label>Select Attributes</label>
	<select multiple="" class="form-control form-control-sm" name="losatributos" id="losatributos"    >




	<option value=""> All Attributes </option>
							 <?php
												 
												 $indxtablaadd=0;
							 $sql = $connect->prepare("select * from products_attributes_type where datatype= 'boolean'    order by attributename");
							  
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
																	  <?php echo  $row2['attributename']; ?>
																	  </option>
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
<td colspan="7"> <button type="button" class="btn btn-block btn-outline-primary btn-xs" onclick="filtrartodo()" >Apply Filters</button> </td>
</tr>
</table>	
 

  </div>	


           <hr>
            <div class="form-group col-md-12 ">
			<b>Mandatory filters :</b>
			<table class="table table-striped" >

			<tr><td>

			
			Select Script: <br>
			<select class="form-control form-control-sm" name="losscriptmam" id="losscriptmam"    >
						<option value=""> - Select - </option>
						<?php
												 					
																

																	 $sql = $connect->prepare("  select distinct scriptname, idscripttype from fas_script_type order by scriptname  ");
																	  
																											 $sql->execute();
																											 $resultado3 = $sql->fetchAll();
																											 foreach ($resultado3 as $row2) 
																											  {
																												 
																												// echo "*************". array_search($row2['idbusiness'], $lasempresasfiltradas);
																											  ?>
																										  <option value="<?php echo  $row2['idscripttype']; ?>" <?php echo $autoselect;?>>
																											  <?php echo  $row2['scriptname']." - [".$row2['idscripttype']."]" ; ?>
																											  </option>
																											  <?php
																											  }
					
																	 ?>
                        </select>


			

			</td> <td>

			
Select Steps: <br>
<select class="form-control form-control-sm" name="losstepmmam" id="losstepmmam"     >
			<option value=""> - Select - </option>
      <?php
												 					
																

																	 $sql = $connect->prepare(" select distinct fas_step.instance, description from fas_step   where description not like '%Print%' order by description  ");
																	  
																											 $sql->execute();
																											 $resultado3 = $sql->fetchAll();
																											 foreach ($resultado3 as $row2) 
																											  {
																												 
																												// echo "*************". array_search($row2['idbusiness'], $lasempresasfiltradas);
																											  ?>
																										  <option value="<?php echo  $row2['instance']; ?>" <?php echo $autoselect;?>>
																											  <?php echo  $row2['description']." - [".$row2['instance']."]" ;  ; ?>
																											  </option>
																											  <?php
																											  }
					
																	 ?>
			</select>


			
</td></tr>


				 <tr>
			
				<td>
                        <label>Select Category</label>
                        <select   class="form-control form-control-sm" name="losscriptsteps" id="losscriptsteps" onclick="filtrartodostep(1,this.value)"   >
                        <option value=""> - Select - </option>
      <?php
												 					
																

																	 $sql = $connect->prepare(" select distinct idcategory, nameoutcomecat  description
                                   from  fas_income_category
                                   order by nameoutcomecat
                                   ");
																	  
																											 $sql->execute();
																											 $resultado3 = $sql->fetchAll();
																											 foreach ($resultado3 as $row2) 
																											  {
																												 
																												// echo "*************". array_search($row2['idbusiness'], $lasempresasfiltradas);
																											  ?>
																										  <option value="<?php echo  $row2['idcategory']; ?>" <?php echo $autoselect;?>>
																											  <?php echo  $row2['description']." - [".$row2['idcategory']."]" ; ; ?>
																											  </option>
																											  <?php
																											  }
					
																	 ?>
					 
                        </select>
                </td>
				<td>
                        <label>Select  Category Type </label>
                        <select  class="form-control form-control-sm" name="lascategoriastipos" id="lascategoriastipos"    >
                        <option value=""> - Select - </option>
      
                        </select>
                </td>
        </tr>   
        <tr>
			
      <td>
                      <label>Select Band</label>
                      <select   class="form-control form-control-sm" name="lasbandas" id="lasbandas"     >
                      <option value=""> No Band Required  </option>
    <?php
                                 
                              

                                 $sql = $connect->prepare(" select * from idband
                                 order by description
                                 ");
                                  
                                                     $sql->execute();
                                                     $resultado3 = $sql->fetchAll();
                                                     foreach ($resultado3 as $row2) 
                                                      {
                                                       
                                                      // echo "*************". array_search($row2['idbusiness'], $lasempresasfiltradas);
                                                      ?>
                                                    <option value="<?php echo  $row2['idband']; ?>" <?php echo $autoselect;?>>
                                                      <?php echo  $row2['description'] ; ?>
                                                      </option>
                                                      <?php
                                                      }
        
                                 ?>
         
                      </select>
              </td>
      <td>
                      <label>Select  UpLink / DownLink  </label>
                      <select  class="form-control form-control-sm" name="losuldl" id="losuldl"    >
                      <option value=""> No UpLink / DownLink Required  </option>
                      <option value="0"> UpLink  </option>
                      <option value="1"> DownLink  </option>
    
                      </select>
              </td>
      </tr>   
				</table>
				</div>						
				
				
				<div class="card">
				  <div class="form-group col-md-12"> 
							<!-- tabla producto a updatear 3333  -->
							<div id="tblfilterdiv" name="tblfilterdiv">
						 
							<!-- fin tabla producto a updatear 3333-->
							</div>	
						</div>
					</div>	

					
            
				</div>

        +
        <div class="card">
			 
				  <div class="form-group col-md-12" id="dibbandyrf" name="dibbandyrf">
				
			
          <div class="container-fluid">
<br>
<b>Information to load the reference: </b><br>
<hr>
                                      </div>
			 
							<div class="row container-fluid">
            
									<div class="form-group col-md-2 " id="divtxtfpgafile" name="divtxtfpgafile">
										<label for="exampleInputEmail1">Integer Value:</label> 										
										<input type="text" name="txtfpgafile" id="txtfpgafile" class="form-control form-control-sm  " value="">	
										
									</div>	
									<div class="form-group col-md-2 " id="divtxtmicrofile" name="divtxtmicrofile">
										<label for="exampleInputEmail1">Double Value:</label> 										
										<input type="text" name="txtmicrofile" id="txtmicrofile" class="form-control form-control-sm  " value="">	
										
									</div>
									<div class="form-group col-md-2 " id="divtxtethfile" name="divtxtethfile">
										<label for="exampleInputEmail1">String Value:</label> 										
										<input type="text" name="txtethfile" id="txtethfile" class="form-control form-control-sm  " value="">	
										
									</div>		
									<div class="form-group col-md-2  " id="divtxtfpgafas" name="divtxtfpgafas">
										<label for="exampleInputEmail1">Boolean Value:</label> 										
									 
                          <select name="txtfpgafas" id="txtfpgafas"  class="form-control form-control-sm">
                            <option value=""> - Select - </option>
                            <option value="TRUE"> True</option>
                            <option value="FALSE"> False</option>
                          </select>
									</div>
                  <div class="form-group col-md-2   id="divtxtethfilebigint" name="divtxtethfilebigint">
										<label for="exampleInputEmail1">Bigint Value:</label> 										
										<input type="text" name="txtethfilebigint" id="txtethfilebigint" class="form-control form-control-sm  " value="">	
										
									</div>	
							 
									
									<div class="form-group col-md-12">
																				<p align="right">
												<button name="btnaddband" id="btnaddband" type="button" class="btn btn-smk btn-block btn-outline-primary btn-flat" onclick="update_selected_ciu(); ">Create References  </button>
											</p>
																						<div id="divlist_tabla_gain_rf" name="divlist_tabla_gain_rf">
											</div>
											<input type="hidden" name="divlist_tabla_gain_rftexto" id="divlist_tabla_gain_rftexto" value="">
									</div>
									
							</div>
					</div>
						<!-- end  - Definition of bands  -->					  	

				  </div>
        +
			</div>

		
					
	</form>
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
<script src="plugins/datatables/jquery.dataTables.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>


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


<link href="css/select2.css" rel="stylesheet" />
<link href="css/testcssselector.css" rel="stylesheet" />
   <script src="plugins/sweetalert2/sweetalert2.min.js"></script>

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
 
	 

function formatRepo (repo) {
	
  if (repo.loading) {
    return repo.text;
  }

  var $container = $(
    "<div class='select2-result-repository clearfix'>" +
      "<div class='select2-result-repository__avatar'><img src='img/imgciu.jpg' /></div>" +
      "<div class='select2-result-repository__meta'>" +
        "<div class='select2-result-repository__title'></div>" +
        "<div class='select2-result-repository__description'></div>" +      
      "</div>" +
    "</div>"
  );

  $container.find(".select2-result-repository__title").text(repo.text);
  $container.find(".select2-result-repository__description").html(repo.description+' ** ' + repo.link);
  $container.find(".select2-result-repository__forks").append("101" + " Forks");
  $container.find(".select2-result-repository__stargazers").append("102" + " Stars");
  $container.find(".select2-result-repository__watchers").append("103" + " Watchers");
//  console.log(repo.text);
  return $container;
}

function formatRepoSelection (repo) {
	// console.log('1' + repo.text);
  return repo.full_name || repo.text;
}	
		
	  	 // AutoComplete de CUIS version TOP
 

		   function selectallmarco()
{
	$(".chkclassmarco").prop('checked', true);
}
// fin// AutoComplete de CUIS version TOP
function filtrartodo()
	{
		$("#tblfilterdiv").html(' 	<p name="msjwaitline" id="msjwaitline" align="center"><img src="img/waitazul.gif" width="100px" ><b> Searching... </b></p>	 ');	 
	var lasempresas = $("#lasempresas").val().toString();
 
	var losatributos = $("#losatributos").val().toString();
	var losuldl =  $("#losuldl").val().toString();
	var losbranchs = $("#losbranchs").val().toString();
	console.log('filtramos'+ lasempresas);
	console.log('lasbandas'+ lasbandas);
	var lasbandas = $("#lasbandas").val().toString();

	console.log('losbranchs'+ losbranchs);
	console.log('losatributos'+ losatributos);
			var formData = new FormData();
			toastr["info"](" ", "Searching");
			formData.append("lasempresas", lasempresas);
	 
			formData.append("losatributos", losatributos);
			formData.append("losuldl", losuldl);
			formData.append("lasbandas", lasbandas);
			formData.append("losbranchs", losbranchs);
		 
	 
		 

			var xhr2 = new XMLHttpRequest();
			xhr2.open("POST", "searchcuicomponentfiltersincomealllist.php");
			xhr2.send(formData);
			
			xhr2.onload = function() {
				  if (xhr2.status == 200) {  
					
					//	console.log('devolvio el idaccionweb 1:' + xhr2.response);	
						$("#tblfilterdiv").html(xhr2.response);		 
					
				  }
				 
				};

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

   function filtrartodostep( idtyp, valuemm)
	{
	 /// 1 = script
	 if (valuemm != '')
	 {
			
			if (idtyp==1)
			{
				var armando_tabla ="";
					$.ajax({
							url: 'listinstance_cat_type_income_addref.php?idtyp='+idtyp+'&valuemm='+valuemm ,										
							cache:false,
							success: function(respuesta) {
								
						//		console.log('HOLa');
							

								var returnedData = JSON.parse(respuesta);
							//	console.log(returnedData);
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
  if ( $("#txtlistcius").val() !='' && $("#lascategoriastipos").val() !='' && $("#losscriptsteps").val() !='' && $("#losstepmmam").val() !='' && $("#losscriptmam").val() !=''   )
  {
    $('#frma').submit();
  }
  else
  {
     toastr.warning("missing complete data ");
  }
	
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
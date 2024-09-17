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

        $sessionTTL = time() - $_SESSION["timeout"];
	//		echo "***********hola".time() - $_SESSION["timeout"]."----".$sessionTTL."--inactividad:".$inactividad."-timeout". $_SESSION["timeout"] ;
        if($sessionTTL > $inactividad){
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
 
  
    <link rel="stylesheet" href="cssfiplex.css">
	
	
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


.tree
{ 
    margin: 6px;
    margin-left: -20px;
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

.tooltipmarco {
    background-color: #0053a1;
    color:  #ffffff;
    padding: 5px 10px;
    border-radius: 4px;
    font-size: 14px;
	 opacity: 0.9;
  }
</style>

</head>


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
<form name="frmlabeling" id="frmlabeling" action="abmfamilyprodtype.php" method="post"  class="form-horizontal needs-validation"  >							
				

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Family Group -  Family Products - Family Products Type</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Family Products type</li>
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
          <section class="col-lg-4 connectedSortable ui-sortable">

            <div class="" name="divscrolllog" id="divscrolllog" style="display.">
			<p name="msjwaitline" id="msjwaitline" align="center"><img src="img/waitazul.gif" width="100px" ></p>	
				
							
							<!-- INICIO2 GROUP  Family  -->
								<div class="card">	
									<div class="card-header">
									<h3 class="card-title colorazulfiplex"> Create:Family Group</h3>							   
									</div>									
									<div class="card-body form-row">						   	
									
										
									
										<div class="form-group col-md-6 ">
											<label for="exampleInputEmail1">New Family Group:</label>
											<input type="text" name="txtnewfliagroup" id="txtnewfliagroup" class="form-control" placeholder="Enter new Family Group" required oninvalid="setCustomValidity('FPGA is required.')" 
											oninput="setCustomValidity('')">
										</div>
										<div class="form-group col-md-12 ">
											<div class="card-footer text-right">							
											  <button type="button" onclick="save_new_registro_fliagroup()" class="btn btn-primary right-align">Create New Family Group</button>
											</div>
											<p class="text-danger" id="lbldatoserrrfliagroup" id="lbldatoserrrfliagroup">
											 </p>
										</div>					
									</div>
								</div>			
							<!-- FIN INICIO2 Group  Family > -->
							<!-- INICIO2  Family Products -->
								<div class="card">	
									<div class="card-header">
									<h3 class="card-title colorazulfiplex"> Create:Family Products </h3>							   
									</div>									
									<div class="card-body form-row">	

<div class="form-group col-md-6 ">
									<label for="exampleInputEmail1">Family Group:</label>
									<br>									
									<select class="js-example-basic-single col-sm-12 form-control" required  id="txtfliaprod" name="txtfliaprod">
									 <option value="">-select- </option>
									<?php 
										  $sql = $connect->prepare("select * from familygroup where active = 'Y' order by namefamilygroup");
	 
											$sql->execute();
											$resultado3 = $sql->fetchAll();
											foreach ($resultado3 as $row2) 
											 {
												
											 ?>
											 <option value="<?php echo  $row2['idfamilygroup']; ?>">
											 <?php echo  $row2['namefamilygroup']; ?>
											 </option>
											 <?php
											 }
									
									?>
									
									</select>
									
									</div>									
									
										<div class="form-group col-md-6 ">
											<label for="exampleInputEmail1">New Family:</label>
											<input type="text" name="txtnewflia" id="txtnewflia" class="form-control" placeholder="Enter new Family" required oninvalid="setCustomValidity('FPGA is required.')" 
											oninput="setCustomValidity('')">
										</div>
										<div class="form-group col-md-12 ">
											<div class="card-footer text-right">							
											  <button type="button" onclick="save_new_registro_flia()" class="btn btn-primary right-align">Create New Family</button>
											</div>
											<p class="text-danger" id="lbldatoserrrflia" id="lbldatoserrrflia">
											 </p>
										</div>					
									</div>
								</div>			
							<!-- FIN INICIO2  Family Products> -->
			
			<div class="card">
					<div class="card-header">
					<h3 class="card-title colorazulfiplex"> Create:Family Products Type </h3>
					</div>
							   <div class="card-body form-row">		
							   
									<div class="form-group col-md-6 ">
									<label for="exampleInputEmail1">Family Product:</label>
									<br>									
									<select class="js-example-basic-single col-sm-12 form-control" required  id="txtfliaprodtype" name="txtfliaprodtype">
									<option value="">-select- </option>
									<?php 
										  $sql = $connect->prepare("select familyproducts.* , familygroup.namefamilygroup
from familyproducts
inner join familygroup
on familygroup.idfamilygroup = familyproducts.idfamilygroup 
where familyproducts.active = 'Y' and familygroup.active = 'Y' 
order by namefamilygroup, namefamily");
 
 
	 
											$sql->execute();
											$resultado3 = $sql->fetchAll();
											foreach ($resultado3 as $row2) 
											 {
												
											 ?>
											 <option value="<?php echo  $row2['idfamilygroup']."#".$row2['idfamilyprod']; ?>">
											 <?php echo  $row2['namefamilygroup']." -> ".$row2['namefamily']; ?>
											 </option>
											 <?php
											 }
									
									?>
									
									</select>
									
									</div>
									<div class="form-group col-md-6 ">
									<label for="exampleInputEmail1">Do you have firmware?:</label>
									<br>									
									<select class="js-example-basic-single col-sm-12 form-control" onclick="habilitar_sitiene_fw(this.value)" required  id="cmbtxthavefw" name="cmbtxthavefw">
										<option value="">-select- </option>
							  	        <option value="Y">Yes</option>
									    <option value="N">No</option>
									</select>
									
									</div>
									<div class="form-group col-md-12 ">
									<label for="exampleInputEmail1">Type Name:</label>
									<input type="text" name="txttypeflia" id="txttypeflia" class="form-control" placeholder="Enter new name" required oninvalid="setCustomValidity('FPGA is required.')" 
                   oninput="setCustomValidity('')">
									</div>
								
									<div class="form-group col-md-6 ">
									<label for="exampleInputEmail1">Fpga Version filename :</label>
									<input type="text" name="txtfpga" id="txtfpga" class="form-control classfw" placeholder="Enter FPGA Version" required oninvalid="setCustomValidity('FPGA is required.')" 
                   oninput="setCustomValidity('')">
									<label for="exampleInputEmail1">Fpga Version fas :</label>
									<input type="text" name="txtfpgafas" id="txtfpgafas" class="form-control classfw" placeholder="Enter FPGA Version Fas" required oninvalid="setCustomValidity('FPGA is required.')" 
                   oninput="setCustomValidity('')">
									</div>
								 
								
									<div class="form-group col-md-6 ">
									<label for="exampleInputEmail1">Uc Version filename :</label>
									<input type="text" name="txtuc" id="txtuc" class="form-control classfw" placeholder="Enter Uc Version" required oninvalid="setCustomValidity('FPGA is required.')" 
                   oninput="setCustomValidity('')">
									<label for="exampleInputEmail1">Uc Version fas :</label>
									<input type="text" name="txtucfas" id="txtucfas" class="form-control classfw" placeholder="Enter Uc Version fas" required oninvalid="setCustomValidity('FPGA is required.')" 
                   oninput="setCustomValidity('')">
									</div>
								    <div class="form-group col-md-6 ">
									<label for="exampleInputEmail1">Ethernet Version filename :</label>
									<input type="text" name="txtether" id="txtether" class="form-control classfw" placeholder="Enter Ethernet version" required oninvalid="setCustomValidity('FPGA is required.')" 
                   oninput="setCustomValidity('')">
									<label for="exampleInputEmail1">Ethernet Version fas :</label>
									<input type="text" name="txtetherfas" id="txtetherfas" class="form-control classfw" placeholder="Enter Ethernet version fas" required oninvalid="setCustomValidity('FPGA is required.')" 
                   oninput="setCustomValidity('')">
									</div>
									
									
									  <div class="form-group col-md-6 ">
									<label for="exampleInputEmail1">Cal String  :</label>
									<input type="text" name="calstring" id="calstring" class="form-control classfw" placeholder="Enter Cal String" required oninvalid="setCustomValidity('FPGA is required.')" 
                   oninput="setCustomValidity('')">
								
									</div>
									
								<!-- /.card-body -->
								<div class="row" id="firmwarecustom" name="firmwarecustom">	
															<div class="form-group col-md-12">
															
															<label for="exampleInputEmail1">FPGA Upgrade Description:</label>
																	<input type="text" name="txtfpgacusdescrip"  id="txtfpgacusdescrip" class="form-control form-control-sm classfw" placeholder="FPGA upgrade description" required="" oninvalid="setCustomValidity('FPGA is required Custom.')" oninput="setCustomValidity('')" value="">	
															</div>
															<div class="form-group col-md-12">
																
																<label for="exampleInputEmail1">Uc Upgrade Description:</label>
																	<input type="text" name="txtuccusdescrip"  id="txtuccusdescrip" class="form-control form-control-sm classfw" placeholder="Uc upgrade description" required="" oninvalid="setCustomValidity(uC is required Custom.')" oninput="setCustomValidity('')" value="">	
																
															</div>
															<div class="form-group col-md-12">
															
															<label for="exampleInputEmail1">Ethernet Upgrade Descriptione:</label>
																	<input type="text" name="txtethercusdescrip"  id="txtethercusdescrip" class="form-control form-control-sm classfw" placeholder="Ethernet upgrade description" required="" oninvalid="setCustomValidity('Ether is required Custom.')" oninput="setCustomValidity('')" value="">	
															</div>
															
															
														</div>
								
								
								
								
								<div class="form-group col-md-12 ">
								<div class="card-footer text-right">
							
								  <button type="button" onclick="save_new_registro_type()" class="btn btn-primary right-align">Create New Type</button>
								  
								  
								</div>
									<p class="text-danger" id="lbldatoserrr" id="lbldatoserrr">
									 </p>
								</div>
		
        
					
				</div>
				</div>
				
				<!-- AGREGAR Type Prduct FW--->
			
				<!-- fin Type Prduct FW--->
			

        </section>
		<section class="col-lg-8 connectedSortable ui-sortable">
		
		<div class="card ">
				<div class="card-header ui-sortable-handle" >
				
		
		<div class="card ">
				<div class="card-header ui-sortable-handle" >
               		
				<div class="card collapsed-card">
                <div class="card-header">
                <h3 class="card-title"> <i class="fa fa-fw fa-list-alt"></i>List Family Group</h3>


                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-plus"></i>
                  </button>
                
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="d-md-flex">
                  <div class="p-1 flex-fill" style="overflow: hidden" >
                    
			
					<table id="fliproduct" class="table table-striped">
                    <thead>
                    <tr>
                     
                      <th>Name Family Group</th>                  
                    
					 
                    
                    </tr>
                    </thead>
                    <tbody>					
					<?php 
										  $sql = $connect->prepare("select * from familygroup where active = 'Y' order by namefamilygroup");
	 
											$sql->execute();
											$resultado3 = $sql->fetchAll();
											foreach ($resultado3 as $row2) 
											 {
												
											 ?>
											 
											 <tr>
											  
											  <td><?php echo  $row2['namefamilygroup']; ?></td>                    
											
											</tr>
					
											
											 <?php
											 }
									
									?>
					
					
                    
                  
                    </tbody>
                  </table>
					
                  </div>
           
                  </div><!-- /.card-pane-right -->
                </div><!-- /.d-md-flex -->
				
				
              </div>
              <!-- /.card-body -->
            
			
			
				
               		
				<div class="card collapsed-card">
                <div class="card-header">
                <h3 class="card-title"> <i class="fa fa-fw fa-list-alt"></i>List Product Family</h3>


                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                   <i class="fas fa-plus"></i>
                  </button>
                 
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0"  style="display: none;">
                <div class="d-md-flex">
                  <div class="p-1 flex-fill" style="overflow: hidden" >
                    
			
					<table id="fliproduct" class="table table-striped">
                    <thead>
                    <tr>
						<th>Family Group</th>                  
                        <th>Name Family</th>                  
                    
					
                    </tr>
                    </thead>
                    <tbody>					
					<?php 
										  $sql = $connect->prepare("select familyproducts.* , familygroup.namefamilygroup
from familyproducts
inner join familygroup
on familygroup.idfamilygroup = familyproducts.idfamilygroup 
where familyproducts.active = 'Y' and familygroup.active = 'Y' 
order by namefamilygroup, namefamily");
	 
											$sql->execute();
											$resultado3 = $sql->fetchAll();
											foreach ($resultado3 as $row2) 
											 {
												
											 ?>
											 
											 <tr>
											  <td><?php echo  $row2['namefamilygroup']; ?></td>                    
											  <td><?php echo  $row2['namefamily']; ?></td>                    
											
											</tr>
					
											
											 <?php
											 }
									
									?>
					
					
                    
                  
                    </tbody>
                  </table>
					
                  </div>
              
                  </div><!-- /.card-pane-right -->
                </div><!-- /.d-md-flex -->
              </div>
              <!-- /.card-body -->
            
				  
				  
              
			
				
				
				<!--   2da seccion otra lista -->
				
				<div class="card ">
                <div class="card-header">
                <h3 class="card-title"> <i class="fa fa-fw fa-list-alt"></i>List Family Products Type and associated Firmware </h3>


                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                   <i class="fas fa-plus"></i>
                  </button>
                 
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-1" style="display: none;">
                <div class="d-md-flex">                  
				  
                     <div class="p-1 flex-fill" style="overflow: hidden" >   				
					<table id="fliproducttype" class="table table-striped table-bordered table-sm">
                    <thead>
                    <tr>
                     
                      <th>Family Group / Product</th>  
					    <th>Firmware?</th>
                      <th>Fpga (Version)</th>
					   <th>Fpga FAS (Version)</th>
					    <th>Uc (Version)</th>
						 <th>Uc FAS (Version)</th>
						  <th>Eth (Version)</th>
						 <th>Eth FAS (Version)</th>
						  <th>CalString </th>
					  
                    
                    </tr>
                    </thead>
                    <tbody>
                 <?php 
										  $sql = $connect->prepare("select * from typeproducts inner join familyproducts on familyproducts.idfamilyprod = typeproducts.idfamilyprod 
inner join familygroup
on familygroup.idfamilygroup = familyproducts.idfamilygroup 
left join typeproducts_fw
on typeproducts_fw.idfamilygroup = typeproducts.idfamilygroup and
typeproducts_fw.idfamilyprod = typeproducts.idfamilyprod and 
typeproducts_fw.idtypeproducts = typeproducts.idtypeproducts
										  where typeproducts.active = 'Y' and familyproducts.active = 'Y' order by namefamily, description");
	 
											$sql->execute();
											$resultado3 = $sql->fetchAll();
											foreach ($resultado3 as $row2) 
											 {
												
											 ?>
											 
											 <tr>
											  
											  <td><?php echo   $row2['namefamilygroup']." - ".$row2['namefamily']."<br>&nbsp;<b>-".$row2['description']; ?></b></td> 
											<td><?php 
												if ($row2['havefw'] == "N")
												{
													?><span class="badge bg-danger">No</span>
													<?php
												}
												else
												{
													?><span class="badge bg-success">Yes</span>
													<?php
												}
											//echo  $row2['havefw']; 
											?></td>  
											<td><?php echo  $row2['fpga_file']; ?></td>  											  
											<td><?php echo  $row2['fpga_fas']; ?></td>
											<td><?php echo  $row2['micro_file']; ?></td>
											<td><?php echo  $row2['micro_fas']; ?></td>
											<td><?php echo  $row2['eth_file']; ?></td>
											<td><?php echo  $row2['eth_fas']; ?></td>
											<td>
											<?php if  ($row2['calrstring'] !="") 
											{ 
										?>
											 <span class="d-none" id="spanm<?php echo $row2['idfamilygroup'].$row2['idfamilyprod'].$row2['idtypeproducts']."li"; ?>" name="spanm<?php echo $row2['idfamilygroup'].$row2['idfamilyprod'].$row2['idtypeproducts']."li" ?>">
											 <?php echo $row2['calrstring']; ?>
											 </span>
											<a href="#" onclick="copyToClipboard('#spanm<?php echo $row2['idfamilygroup'].$row2['idfamilyprod'].$row2['idtypeproducts']."li"; ?>')">
											  <i class='far fa-copy'></i>copy to clipboard
											</a>
											<?php } ?>
											</td>
											
											</tr>
					
											
											 <?php
											 }
									
									?>
					
                  
                    </tbody>
                  </table>
					
                  </div>
              
                  </div><!-- /.card-pane-right -->
                </div><!-- /.d-md-flex -->
              </div>
              <!-- /.card-body -->
            </div>
				  
				  </div>
              
				<!--   fin 2da seccion otra lista -->
					</div>	
					
					
					
					   <!-- inicio arbol -->
			  
			   <div class="tree">
						<ul>
							<li><span><a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#Web" aria-expanded="true" aria-controls="Web"><i class="collapsed"></i>
							<i class="expanded"><i class="far fa-folder-open"></i></i> Family Tree firmware</a></span>
							<div id="Web" class="collapse show">
							<ul>
											
			<?php	
				$query_listagroup = "select familyproducts.idfamilygroup , namefamilygroup,  array_agg( DISTINCT coalesce(namefamily,'')) as namefamilygroup2 
						from familyproducts
						inner join typeproducts
						on typeproducts.idfamilyprod = familyproducts.idfamilyprod and 
							 typeproducts.idfamilygroup = familyproducts.idfamilygroup and
						typeproducts.active='Y' 
						inner join familygroup
on familygroup.idfamilygroup = familyproducts.idfamilygroup 
						 where familyproducts.active='Y' 
						 and typeproducts.havefw = 'Y'
						group by familyproducts.idfamilygroup ,namefamilygroup
						order by namefamilygroup2 ";	
													//	echo $query_lista;									   
						$datagroup = $connect->query($query_listagroup)->fetchAll();
						$searchgroup  = array('{', '}','"');
						$replacegroup = array('', '','');
						$iddatosgroup = 0;
						foreach ($datagroup as $rowgroup) 
							{	
							?>
							<li><span>
							<a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#foldergroup<?php echo $rowgroup['idfamilygroup'];?>" aria-expanded="false" aria-controls="foldergroup<?php echo $rowgroup['idfamilygroup'];?>">
							<i class="collapsed"></i>
							<i class="expanded"><i class="fa fa-inbox"></i></i> <?php echo $rowgroup['namefamilygroup'];  ?></a> </span>
							
								<div id="foldergroup<?php echo  $rowgroup['idfamilygroup'];?>" class="collapse marcoopen">
									<ul>
									<!-- mostrar por cada grupo de familia --->
								
	<?php	
			
				$query_lista = "select namefamily, 				
				array_agg( concat(familyproducts.idfamilygroup,'#',typeproducts.idfamilyprod,'#',idtypeproducts, '#',coalesce(description,'')) order by description asc) as groupbutypeflia
						from familyproducts
						inner join typeproducts
						on typeproducts.idfamilyprod = familyproducts.idfamilyprod and 
						typeproducts.active='Y'  and typeproducts.havefw = 'Y' 
						 where familyproducts.active='Y' and familyproducts.idfamilygroup = ".$rowgroup['idfamilygroup']."
						group by namefamily 
						order by namefamily";	
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
								<li><span><a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#folder<?php echo $rowgroup['idfamilygroup'].$iddatos;?>" aria-expanded="false" aria-controls="folder<?php echo $iddatos;?>"><i class="collapsed"></i>
		
								<?php
								
												
											
												$bgclass="bg-secondary";
												  $bgclass="bg-warning";
											
												 
									//Antes de mostrar pregunto si tiene mas ramas.
								?>
								<i class="expanded"> <i class="fa fa-inbox"></i></i> <?php echo $row['namefamily'];  ?>  </a> </span>
							
									<?php 
									$lossn = $array = explode(",", $row['groupbutypeflia']);
									if ( count($lossn) >0)
									{
									?>
									<ul><div id="folder<?php echo $rowgroup['idfamilygroup'].$iddatos;?>" class="collapse marcoopen">
									<?php
										for($i = 0; $i < count($lossn); $i++)
										{
											
											$losdatos = explode("#", str_replace($search, $replace, $lossn[$i]));
										
												?>
											<li><span>
												<a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#afolder<?php echo $rowgroup['idfamilygroup'].$losdatos[0].$losdatos[1].$losdatos[2];?>" aria-expanded="false" aria-controls="folder<?php echo $iddatos;?>">
												<i class="collapsed"></i>
		
											<?php
											//echo "<li class='treemm'><span>";
											if ($losdatos[3] == "Migration")
											{
												echo '<i class="fa fa-inbox"></i></i> &nbsp;<label class="text-danger">'.$losdatos[3].'</label></a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
											}
											else
											{
												if ($losdatos[0] ==0)
												{
													echo '<i class="fa fa-inbox"></i></i> &nbsp;'.$losdatos[3].' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="form-check-label colorazulfiplex" for="exampleCheck1">[add Firmware to this branch]</label></a>';
												}
												else
												{
													echo '<i class="fa fa-inbox"></i></i> &nbsp;'.$losdatos[3].' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>';
												}
										
												?>
												
												<?php
											}
								
											
												echo "</span>";
											?>
												
													<ul>
													<div id="afolder<?php echo $rowgroup['idfamilygroup'].$losdatos[0].$losdatos[1].$losdatos[2];?>" class="collapse marcoopen">
														<?php
														
														$querysearchmodelus = "select * from products where idfamilygroup = ".$losdatos[0]." and idfamilyprod = ".$losdatos[1]." and idtypeproduct = ".$losdatos[2]."  order by modelciu";
														$data_busca_modelos = $connect->query($querysearchmodelus)->fetchAll();	
														$haveproductassocied="N";
														foreach ($data_busca_modelos as $rowencontrados) 
														{
															$haveproductassocied="Y";
															if ($losdatos[3] == "Migration")
															{
																?>
															<li class='treemm'> <span onclick="buscadatos('<?php echo $rowencontrados['idproduct'];?> ','<?php echo $losdatos[3];?>')" class="text-danger"><i class="fa fa-eye"></i>&nbsp;  <?php echo $rowencontrados['modelciu'];?> </span>	</li>															
															<?php
															}
															else
															{
																?>
															<li class='treemm' > <span onclick="buscadatos('<?php echo $rowencontrados['idproduct'];?> ','<?php echo $losdatos[3];?>')"> <i class="fa fa-eye"></i>&nbsp;<?php echo $rowencontrados['modelciu'];?> </span>	</li>															
															<?php
															}
															
														}
														
															if ($losdatos[0] ==0)
															{
																
															
														?>
														<br>
														<b>Firmware versions</b>
														<table class="table table-striped table-bordered table-sm">
														  <thead>
															<tr>
															  <th class="bg-primary">#Rev</th>
															  <th class="bg-primary">Fpga Filename</th>
															  <th class="bg-primary">Fpga FAS</th>
															  <th class="bg-primary">uC Filename</th>
															  <th class="bg-primary">uC FAS</th>
															   <th class="bg-primary">Eth Filename</th>
															  <th class="bg-primary">Eth FAS</th>
															    <th class="bg-primary">CalString</th>
															 
															</tr>
														  </thead>
														  <tbody>
														
															<?php
																	
																		$vvfpga_file =""; 
																							$vvfpga_fas ="";
																							$vvmicro_file ="";
																							$vvmicro_fas="";
																							$vveth_file="";
																							$vveth_fas ="";
																							
															 $sql = $connect->prepare("select * 
																 from typeproducts 
																 inner join familyproducts on familyproducts.idfamilyprod = typeproducts.idfamilyprod and
																 familyproducts.idfamilygroup = typeproducts.idfamilygroup 
											inner join familygroup
											on familygroup.idfamilygroup = familyproducts.idfamilygroup 
											inner join typeproducts_fw
											on typeproducts_fw.idfamilygroup = typeproducts.idfamilygroup and
											typeproducts_fw.idfamilyprod = typeproducts.idfamilyprod and 
											typeproducts_fw.idtypeproducts = typeproducts.idtypeproducts
																					  where typeproducts.active = 'Y' and familyproducts.active = 'Y'
												and familygroup.idfamilygroup = ".$losdatos[0]." and familyproducts.idfamilyprod = ".$losdatos[1]." and 
												typeproducts.idtypeproducts =".$losdatos[2]."
																					  order by idrev desc ");
												 
																					$sql->execute();
																						$resultado3 = $sql->fetchAll();
																						foreach ($resultado3 as $row2) 
																						 {
																							$vvfpga_file = $row2['fpga_file']; 
																							$vvfpga_fas = $row2['fpga_fas'];
																							$vvmicro_file =  $row2['micro_file']; 
																							$vvmicro_fas =  $row2['micro_fas']; 
																							$vveth_file = $row2['eth_file'];
																							$vveth_fas =$row2['eth_fas']; 
																							$vvvcalstring =$row2['calrstring']; 
																						 ?>
																						 
																						 <tr>
																						  
																						  <td><?php echo   $row2['idrev']; ?></b></td> 
																					
																						<td>																						
																						<a href="#" class="tooltipmarcolink<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']; ?>"  onmouseout="ocultar_tooltip('<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']; ?>')" onmouseover="mostrar_tooltip('<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']; ?>')" ><?php echo  $row2['fpga_file']; ?></a>
																									<div id="tooltipfreq<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']; ?>" name="tooltipfreq<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']; ?>" class='d-none tooltipmarco text-left' role='tooltip'> Description: <?php echo  $row2['fpga_description']; ?> </div>
																						</td>  											  
																						<td><?php echo  $row2['fpga_fas']; ?></td>
																						<td>
																						<a href="#" class="tooltipmarcolink<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."uc"; ?>"  onmouseout="ocultar_tooltip('<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."uc"; ?>')" onmouseover="mostrar_tooltip('<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."uc"; ?>')" ><?php echo  $row2['micro_file']; ?></a>
																									<div id="tooltipfreq<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."uc"; ?>" name="tooltipfreq<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."uc"; ?>" class='d-none tooltipmarco text-left' role='tooltip'> Description: <?php echo  $row2['uc_description']; ?> </div>
																									</td>
																						<td><?php echo  $row2['micro_fas']; ?></td>
																						<td>
																						<a href="#" class="tooltipmarcolink<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."eth"; ?>"  onmouseout="ocultar_tooltip('<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."eth"; ?>')" onmouseover="mostrar_tooltip('<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."eth"; ?>')" ><?php echo  $row2['eth_file']; ?></a>
																									<div id="tooltipfreq<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."eth"; ?>" name="tooltipfreq<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."eth"; ?>" class='d-none tooltipmarco text-left' role='tooltip'> Description: <?php echo  $row2['eht_description']; ?> </div>
																									</td>
																						<td><?php echo  $row2['eth_fas']; ?></td>
																						
																						<td>
																							<?php if  ($row2['calrstring'] !="") 
																							{ 
																						?>
																							 <span class="d-none" id="spanm<?php echo $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev'].$row2['idtypeproducts']."fw"; ?>" name="spanm<?php echo $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev'].$row2['idtypeproducts']."fw"; ?>"><?php echo trim($row2['calrstring']); ?></span>
																							<a href="#" onclick="copyToClipboard('#spanm<?php echo $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev'].$row2['idtypeproducts']."fw"; ?>')">
																							  <i class='far fa-copy'></i>copy to clipboard
																							</a>
																							<?php } ?>
																							</td>
																						</tr>
																
																						
																						 <?php
																							  break; 
																						 } 
																						 ?>
														
														  </tbody>
														</table>
														<hr>
														<!--start load firmware -->
														<div class="container-fluid" id="divfasfw<?php echo $rowgroup['idfamilygroup'].$iddatos.$iddatos.$losdatos[0].$losdatos[1].$losdatos[2];?>" name="divfasfw<?php echo $rowgroup['idfamilygroup'].$iddatos.$losdatos[0].$losdatos[1].$losdatos[2];?>">					  
													<hr>	
													<label class="colorazulfiplex"><b>Add Firmware Specs:</b> </label>	<br><br>

														<div class="row " id="firmwarestand" name="firmwarestand">	
															<div class="form-group col-md-4">
															
															<label for="exampleInputEmail1">FPGA FAS:</label>
																	<input type="text" name="txtfpgafwadd<?php echo  $losdatos[0].$losdatos[1].$losdatos[2]; ?>"  id="txtfpgafwadd<?php echo  $losdatos[0].$losdatos[1].$losdatos[2]; ?>" class="form-control form-control-sm" placeholder="FPGA version " required="" oninvalid="setCustomValidity('FPGA Number is required.')" oninput="setCustomValidity('')" value="<?php echo $vvfpga_fas;?>">	
															</div>
															<div class="form-group col-md-4">
																
																<label for="exampleInputEmail1">uC FAS:</label>
																	<input type="text" name="txtucfwadd<?php echo  $losdatos[0].$losdatos[1].$losdatos[2]; ?>"  id="txtucfwadd<?php echo  $losdatos[0].$losdatos[1].$losdatos[2]; ?>" class="form-control form-control-sm" placeholder="uC version" required="" oninvalid="setCustomValidity('uC Number is required.')" oninput="setCustomValidity('')" value="<?php echo $vvmicro_fas;?>">	
																
															</div>
															
															
																
																							
															<div class="form-group col-md-4">
															
															<label for="exampleInputEmail1">Ethernet FAS:</label>
																	<input type="text" name="txtetherfasfwadd<?php echo  $losdatos[0].$losdatos[1].$losdatos[2]; ?>"  id="txtetherfasfwadd<?php echo  $losdatos[0].$losdatos[1].$losdatos[2]; ?>" class="form-control form-control-sm" placeholder="Eth version " required="" oninvalid="setCustomValidity('Eth Number is required.')" oninput="setCustomValidity('')" value="<?php echo $vveth_fas;?>">	
															</div>
															
														</div>
														<div class="row" id="firmwarecustom" name="firmwarecustom">	
															<div class="form-group col-md-4">
															
															<label for="exampleInputEmail1">FPGA File Name:</label>
																	<input type="text" name="txtfpgafasfwadd<?php echo  $losdatos[0].$losdatos[1].$losdatos[2]; ?>"  id="txtfpgafasfwadd<?php echo  $losdatos[0].$losdatos[1].$losdatos[2]; ?>" class="form-control form-control-sm" placeholder="FPGA File Name Custom" required="" oninvalid="setCustomValidity('FPGA is required Custom.')" oninput="setCustomValidity('')" value="<?php echo $vvfpga_file;?>">	
															</div>
															<div class="form-group col-md-4">
																
																<label for="exampleInputEmail1">Uc File Name :</label>
																	<input type="text" name="txtucfasfwadd<?php echo  $losdatos[0].$losdatos[1].$losdatos[2]; ?>"  id="txtucfasfwadd<?php echo  $losdatos[0].$losdatos[1].$losdatos[2]; ?>" class="form-control form-control-sm" placeholder="Uc File Name Custom" required="" oninvalid="setCustomValidity(uC is required Custom.')" oninput="setCustomValidity('')" value="<?php echo $vvmicro_file;?>">	
																
															</div>
															<div class="form-group col-md-4">
															
															<label for="exampleInputEmail1">Ethernet File Name:</label>
																	<input type="text" name="txtetherfwadd<?php echo  $losdatos[0].$losdatos[1].$losdatos[2]; ?>"  id="txtetherfwadd<?php echo  $losdatos[0].$losdatos[1].$losdatos[2]; ?>" class="form-control form-control-sm" placeholder="Ethernet File Name Custom" required="" oninvalid="setCustomValidity('Ether is required Custom.')" oninput="setCustomValidity('')" value="<?php echo $vveth_file;?>">	
															</div>
														
														</div>
														<div class="row" id="firmwarecustom" name="firmwarecustom">	
															<div class="form-group col-md-4">
															
															<label for="exampleInputEmail1">FPGA Upgrade Description:</label>
																	<input type="text" name="txtfpgacusdescripupg<?php echo  $losdatos[0].$losdatos[1].$losdatos[2]; ?>"  id="txtfpgacusdescripupg<?php echo  $losdatos[0].$losdatos[1].$losdatos[2]; ?>" class="form-control form-control-sm" placeholder="FPGA upgrade description" required="" oninvalid="setCustomValidity('FPGA is required Custom.')" oninput="setCustomValidity('')" value="">	
															</div>
															<div class="form-group col-md-4">
																
																<label for="exampleInputEmail1">Uc Upgrade Description:</label>
																	<input type="text" name="txtuccusdescripupg<?php echo  $losdatos[0].$losdatos[1].$losdatos[2]; ?>"  id="txtuccusdescripupg<?php echo  $losdatos[0].$losdatos[1].$losdatos[2]; ?>" class="form-control form-control-sm" placeholder="Uc upgrade description" required="" oninvalid="setCustomValidity(uC is required Custom.')" oninput="setCustomValidity('')" value="">	
																
															</div>
															<div class="form-group col-md-4">
															
															<label for="exampleInputEmail1">Ethernet Upgrade Description:</label>
																	<input type="text" name="txtethercusdescripupg<?php echo  $losdatos[0].$losdatos[1].$losdatos[2]; ?>"  id="txtethercusdescripupg<?php echo  $losdatos[0].$losdatos[1].$losdatos[2]; ?>" class="form-control form-control-sm" placeholder="Ethernet upgrade description" required="" oninvalid="setCustomValidity('Ether is required Custom.')" oninput="setCustomValidity('')" value="">	
															</div>
															<div class="form-group col-md-12 ">
															<label for="exampleInputEmail1">Cal String  :</label>
									<input type="text" name="calstringfw<?php echo  $losdatos[0].$losdatos[1].$losdatos[2]; ?>" id="calstringfw<?php echo  $losdatos[0].$losdatos[1].$losdatos[2]; ?>" class="form-control " placeholder="Enter Cal String" required oninvalid="setCustomValidity('FPGA is required.')" 
                   oninput="setCustomValidity('')" value="<?php echo $vvvcalstring;?>">
																
															</div>
															
																<div class="form-group col-md-12 ">
																<input type="hidden" name="idramon<?php echo  $losdatos[0].$losdatos[1].$losdatos[2]; ?>" id="idramon<?php echo  $losdatos[0].$losdatos[1].$losdatos[2]; ?>" value="<?php echo str_replace($search, $replace, $lossn[$i]);?>">
																<button name="btnaddband<?php echo  $losdatos[0].$losdatos[1].$losdatos[2]; ?>" id="btnaddband<?php echo  $losdatos[0].$losdatos[1].$losdatos[2]; ?>" type="button" class="btn btn-smk btn-block btn-outline-primary btn-flat btn-sm" onclick="save_add_registro_type_fw('<?php echo  $losdatos[0].$losdatos[1].$losdatos[2]; ?>')">Upgrade Firmware</button>
																
																
															</div>
															
														</div>
															</div>
															<!--end load firmware -->
														<?php  }  ?>
													
													</div>
													</ul>
												
											<?php
												echo "</li>";
										
											//echo "<li class='treemm'><span><button class='btn btn-sm' onclick='mostrar_calibrarion(this.value)' value='".str_replace($search, $replace, $lossn[$i])."'> SN:".  str_replace($search, $replace, $lossn[$i])."</button></span></li>";
											
											//echo "</li>";
										}
										echo "</div></ul>";
									}
									
									?>
							</li> 
								<?php	
								$iddatos = $iddatos + 1 ;
								
							}
							?>
									<!-- fin mostrar por cada grupo de familia  --->
									
									</ul>
								</div>
													
							</li>
						<?php	
						//----BUSCAMOS POR FLIA
						
				
							}
					?>
							
							
							
					</ul>	
					</div>
					</li>
					
					</ul>	
					</div>

				<!-- fin aca tree -->
			  <!-- fin inicio arbol -->
			  
				</div>	
				
				
				
		 </section>
          <!-- /.col -->
        </div>
      </div>
      <!-- /.timeline -->

    </section>
    <!-- /.content -->
	
		</form>	
	
  </div>
  <!-- /.content-wrapper -->
  


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


<script src="plugins/datatables/jquery.dataTables.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script src="js/popperparacalibratio.min.js"></script>
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


document.getElementById("txtfpga").addEventListener("keyup", function(event) {
    if (event.keyCode === 13) {
    save_new_registro();
		return false;
    }
});


document.getElementById("txtnewflia").addEventListener("keyup", function(event) {
    if (event.keyCode === 13) {
    save_new_registro_flia();
		return false;
    }
});

  $('#fliproducttype').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
    });
	
	  $('#fliproduct').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
    });
				
			
	});
	
	


	// controlar inactividad en la web	
		$(document).inactivityTimeout({
                inactivityWait: 10000,
                dialogWait: 10,
                logoutUrl: 'logout.php'
            })
	// fin controlar inactividad en la web		
	
	 /* requesting data */
	 function save_new_registro_fliagroup()
	 {
		 var faltandatosflia = 0;

		if ($('#txtnewfliagroup')[0].checkValidity() == false)
		{
			toastr["error"]("Error, Name is required..", "");	
			faltandatosflia = 1;
		}	
		
		/////////////////////
			if (faltandatosflia == 0)
		{		
		$('#lbldatoserrrfliagroup').html("");
		 var txtnewfliagroup = $('#txtnewfliagroup').val();
		
					
		toastr["success"]("processing information..", "");	
		
				$.ajax({
				url: 'ajax_createnew_fasfamilygroup.php', 				
				data: "txtnewflia="+txtnewfliagroup,	
				type: 'post',				
				datatype:'JSON',				
				cache:false,					
				success: function(data, status, xhr) {
					var resultadom = data.resultiu;
					var resulterr = data.erromsj;
				
					if (resultadom =="ok" )
					{
						toastr["success"]("Save OK!", "");	
						location.reload();
						$("#lbladdbtn").removeClass('d-none');
						$('#lbldatoserrrfliagroup').val("");
						 
					
					}
					else	
					{
						toastr["error"]("Error when storing data..."+resulterr, "");	
						
						$('#lbldatoserrrfliagroup').html("ERROR: <br>"+resulterr);
					}
					return false;	
				
				},
				error: function(xhr, status, error) {
					 console.log(status);
				}
				});
		}	
		///////////////////////
		
	 }
	 
	 function save_add_registro_type_fw(idramon)
	 {
		 console.log('idramon'+idramon)
		  ///////// Crear nuevo type de flia de productos
		 var faltandatosflia = 0;
		console.log( $('#idramon'+idramon).val()		);
	
	
	if (faltandatosflia == 0)
	{		
		$('#lbldatoserrrflia').html("");
		
		 var txtfliaprodtype = $('#idramon'+idramon).val();		 
	
			 var txtfpgafw = $('#txtfpgafasfwadd'+idramon).val();
			 var txtfpgafasfw = $('#txtfpgafwadd'+idramon).val();
			 var txtucfw = $('#txtucfasfwadd'+idramon).val();
			 var txtucfasfw = $('#txtucfwadd'+idramon).val();
			 var txtetherfw = $('#txtetherfwadd'+idramon).val();
			 var txtetherfasfw = $('#txtetherfasfwadd'+idramon).val();
			 var calstringfw = $('#calstringfw'+idramon).val();
			 
			   var txtfpgacusdescrip = $('#txtfpgacusdescripupg'+idramon).val();
		   var txtuccusdescrip = $('#txtuccusdescripupg'+idramon).val();
		   var txtethercusdescrip = $('#txtethercusdescripupg'+idramon).val();
			
					
				toastr["success"]("processing information..", "");	
		
				$.ajax({
				url: 'ajax_addfw_fasfamilytype.php', 				
				data: "txtfliaprodtype="+txtfliaprodtype+'&txtfpgafw='+txtfpgafw+'&txtfpgafasfw='+txtfpgafasfw+'&txtucfw='+txtucfw+'&txtucfasfw='+txtucfasfw+'&txtetherfasfw='+txtetherfasfw+'&txtetherfw='+txtetherfw+'&calstringfw='+calstringfw+'&txtfpgacusdescrip='+txtfpgacusdescrip+'&txtuccusdescrip='+txtuccusdescrip+'&txtethercusdescrip='+txtethercusdescrip,		
				type: 'post',				
				datatype:'JSON',				
				cache:false,					
				success: function(data, status, xhr) {
					var resultadom = data.resultiu;
					var resulterr = data.erromsj;
				
					if (resultadom =="ok" )
					{
						toastr["success"]("Save OK!", "");	
						location.reload();
						$("#lbladdbtn").removeClass('d-none');
						$('#lbldatoserrrflia').val("");
						 
					
					}
					else	
					{
						toastr["error"]("Error when storing data..."+resulterr, "");	
						
						$('#lbldatoserrrflia').html("ERROR: <br>"+resulterr);
					}
					return false;	
				
				},
				error: function(xhr, status, error) {
					 console.log(status);
				}
				});
		}	
		 ///////////////////////////////////////////////
	 }
	 
	 function save_new_registro_type()
	 {
		 ///////// Crear nuevo type de flia de productos
		 var faltandatosflia = 0;
		////Controlamos campos vacios
		////Controlamos campos vacios
		if ($('#txtfliaprodtype')[0].checkValidity() == false)
		{
			toastr["error"]("Error, Family Product required..", "");	
			faltandatosflia = 1;
		}
		if ($('#txttypeflia')[0].checkValidity() == false)
		{
			toastr["error"]("Error, Type Name required..", "");	
			faltandatosflia = 1;
		}	
	
	
	
	if (faltandatosflia == 0)
	{		
		$('#lbldatoserrrflia').html("");
		
		 var txtfliaprodtype = $('#txtfliaprodtype').val();		 
		 var txttypeflia = $('#txttypeflia').val();
		 var txtfpga = $('#txtfpga').val();
		 var txtfpgafas = $('#txtfpgafas').val();
		 var txtuc = $('#txtuc').val();
		 var txtucfas = $('#txtucfas').val();
		 var txtether = $('#txtether').val();
		 var txtetherfas = $('#txtetherfas').val();
		 var calstring = $('#calstring').val();
		 
		  var havefw = $('#cmbtxthavefw').val();
		  
		  
		   var txtfpgacusdescrip = $('#txtfpgacusdescrip').val();
		   var txtuccusdescrip = $('#txtuccusdescrip').val();
		   var txtethercusdescrip = $('#txtethercusdescrip').val();
		
					
				toastr["success"]("processing information..", "");	
		
				$.ajax({
				url: 'ajax_createnew_fasfamilytype.php', 				
				data: "txtfliaprodtype="+txtfliaprodtype+'&txttypeflia='+txttypeflia+'&txtfpga='+txtfpga+'&txtfpgafas='+txtfpgafas+'&txtuc='+txtuc+'&txtucfas='+txtucfas+'&txtether='+txtether+'&txtetherfas='+txtetherfas+'&calstring='+calstring+'&havefw='+havefw+'&txtfpgacusdescrip='+txtfpgacusdescrip+'&txtuccusdescrip='+txtuccusdescrip+'&txtethercusdescrip='+txtethercusdescrip,	
				type: 'post',				
				datatype:'JSON',				
				cache:false,					
				success: function(data, status, xhr) {
					var resultadom = data.resultiu;
					var resulterr = data.erromsj;
				
					if (resultadom =="ok" )
					{
						toastr["success"]("Save OK!", "");	
						location.reload();
						$("#lbladdbtn").removeClass('d-none');
						$('#lbldatoserrrflia').val("");
						 
					
					}
					else	
					{
						toastr["error"]("Error when storing data..."+resulterr, "");	
						
						$('#lbldatoserrrflia').html("ERROR: <br>"+resulterr);
					}
					return false;	
				
				},
				error: function(xhr, status, error) {
					 console.log(status);
				}
				});
		}	
		 ///////////////////////////////////////////////
	 }
     		
	function save_new_registro_flia()
	{
		var faltandatosflia = 0;
		////Controlamos campos vacios
		////Controlamos campos vacios
		if ($('#txtnewflia')[0].checkValidity() == false)
		{
			toastr["error"]("Error, Name Family required..", "");	
			faltandatosflia = 1;
		}
		if ($('#txtfliaprod')[0].checkValidity() == false)
		{
			toastr["error"]("Error, Family Group required..", "");	
			faltandatosflia = 1;
		}			
		///txtfliaprod
		
	
	
	if (faltandatosflia == 0)
	{		
		$('#lbldatoserrrflia').html("");
		 var txtnewflia = $('#txtnewflia').val();
		var txtfliaprod = $('#txtfliaprod').val();
					
		toastr["success"]("processing information..", "");	
		
				$.ajax({
				url: 'ajax_createnew_fasfamily.php', 				
				data: "txtnewflia="+txtnewflia+'&txtfliaprod='+txtfliaprod,	
				type: 'post',				
				datatype:'JSON',				
				cache:false,					
				success: function(data, status, xhr) {
					var resultadom = data.resultiu;
					var resulterr = data.erromsj;
				
					if (resultadom =="ok" )
					{
						toastr["success"]("Save OK!", "");	
						location.reload();
						$("#lbladdbtn").removeClass('d-none');
						$('#lbldatoserrrflia').val("");
						 
					
					}
					else	
					{
						toastr["error"]("Error when storing data..."+resulterr, "");	
						
						$('#lbldatoserrrflia').html("ERROR: <br>"+resulterr);
					}
					return false;	
				
				},
				error: function(xhr, status, error) {
					 console.log(status);
				}
				});
		}	
	}

function save_new_registro()
	{
		var faltandatos = 0;
		////Controlamos campos vacios
		////Controlamos campos vacios
		if ($('#txtfliaprod')[0].checkValidity() == false)
		{
			toastr["error"]("Error, Family Product is required..", "");	
			faltandatos = 1;
		}	
		
		if ($('#txtfpga')[0].checkValidity() == false)
		{
			toastr["error"]("Error, Type Name In is required..", "");	
				faltandatos = 1;
		}	
		
	
	
	if (faltandatos == 0)
	{		
		$('#lbldatoserrr').html("");
		 var v_txttxtfliaprod = $('#txtfliaprod').val();
		 var v_txtnewname = $('#txtfpga').val();
					
		toastr["success"]("processing information..", "");	
		
				$.ajax({
				url: 'ajax_createnew_fasfamilytype.php', 				
				data: "v_txttxtfliaprod="+v_txttxtfliaprod+'&v_txtnewname='+v_txtnewname,	
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
						location.reload();
						$("#lbladdbtn").removeClass('d-none');
						$('#txtciu').val("");
						$('#txtfpga').val("");
			            $('#txtmicro').val("");
						$('#txtehter').val("");
						
		 
					
					}
					else	
					{
						toastr["error"]("Error when storing data..."+resulterr, "");	
						
						$('#lbldatoserrr').html("ERROR: <br>"+resulterr);
					}
					return false;	
				
				},
				error: function(xhr, status, error) {
					 console.log(status);
				}
				});
		}	
				
	}	
	 
	function abrirparacrearfirware()
	{
		$("#lbladdbtn").removeClass('d-none');
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
   
   function copyToClipboard(element) {
 var $temp = $("<input>");
 $("body").append($temp);
 $temp.val($(element).html()).select();
 document.execCommand("copy");
 $temp.remove();
}
   
   function copy_caltring(vparamcalstring)
   {
	   var copyTextarea = vparamcalstring;
copyTextarea.select(); //select the text area
document.execCommand("copy"); //copy to clipboard
   }
   
   function habilitar_sitiene_fw(valor_select)
   {
	 //  classfw
	   if( valor_select == 'N')
	   {
		   	$(".classfw").each(function(){
				$(this).attr("disabled", true);
       	   	});
	   }
	   else
	   {
		  $(".classfw").each(function(){
				$(this).attr("disabled", false);
       	   	}); 
	   }
			
			
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
   
   function mostrar_tooltip(iddivamostrar)
{
//console.log('mostrar #tooltipfreq'+iddivamostrar );
			  const reference = document.querySelector('.tooltipmarcolink'+iddivamostrar);
			const popper = document.querySelector('#tooltipfreq'+iddivamostrar);

	//  var button = document.querySelector('#link'+iddivamostrar);
  //var tooltip = document.querySelector('#tooltipfreq'+iddivamostrar);
  
  $('#tooltipfreq'+iddivamostrar).removeClass('d-none');

 Popper.createPopper(reference , popper , {
    placement: 'right',
  });
  

 
}

function ocultar_tooltip(iddivamostrar)
{
//	console.log('ocultar #tooltipfreq'+iddivamostrar );
	  $('#tooltipfreq'+iddivamostrar).addClass('d-none');
}
   
</script>
   
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
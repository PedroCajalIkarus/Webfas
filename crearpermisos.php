<!DOCTYPE html>
<?php 

// Desactivar toda notificación de error
//error_reporting(0);
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
			header("Location: http://".$ipservidorapache."/".$folderservidor."/permissiondenied.php?b=".$_SESSION["b"]."&c=".array_pop(explode('/', $_SERVER['PHP_SELF'])));
			exit();
		}
	/// FIN DETECTO PERMISOS EN PAG!
	
	
	$status = $connect->getAttribute(PDO::ATTR_CONNECTION_STATUS);
	
	if ($status !="Connection OK; waiting to send.")
	{
	
		header("Location: http://".$ipservidorapache."/".$folderservidor."/errorconect.php");
		exit;
		
	}
	
	
	$vviduser =$_REQUEST["iduser"];
	$vvidbusi= $_REQUEST["idb"];
	$vvnameiser= $_REQUEST["nn"];
		$habilitnewuser= $_REQUEST["newu"]; 
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
 

  
  <!-- AdminLTE css -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  
  <link rel="shortcut icon" href="fiplexcirculo-01.ico" />
  
  <link rel="stylesheet" href="toastr.css">
 
    <link rel="stylesheet" href="cssfiplex.css">
	
	<style>
	


.users-list>li {
    /* float: left; */
    /* padding: 10px; */
    text-align: center;
    width: 25%;
} 

</style>
	
	
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
            <h1>User Manager</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">User Manager</li>
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
                  <div class="card-header">
                    <h3 class="card-title">List User</h3>

                    <div class="card-tools">
                      <a class="users-list-name" href="crearpermisos.php?newu=y"> <span class="badge badge-danger">Create New Users</span>
                       </a>
                    </div>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body p-0">
                    
				  <div class="col-lg-12 connectedSortable ui-sortable">
				  <table id="tablabc" name="tablabc" class="table table-bordered table-striped  table-sm">	
                    <thead>
                    <tr>
                      <th>#</th>
                    
					  <th>User</th>
					  <th>HID</th> 
					  <th>Business</th>
                      <th >Profile</th>
                      
                    </tr>
                    </thead>
                    <tbody>
					<?php
					
					$sql = $connect->prepare("select 1 as prioridad,  userfas.* ,business.namebusiness,business_userfas.idbusiness, development  from userfas left join business_userfas on business_userfas.iduserfas = userfas.iduserfas left join business on business.idbusiness	 = business_userfas.idbusiness where business_userfas.idbusiness =1  and  userfas.active ='true' union  select 2 , userfas.* ,business.namebusiness,business_userfas.idbusiness,development  from userfas left join business_userfas on business_userfas.iduserfas = userfas.iduserfas left join business on business.idbusiness	 = business_userfas.idbusiness where business_userfas.idbusiness in (2,3) and userfas.iduserfas <> 1  and  userfas.active ='true' order by prioridad,  nameuserfas asc");
						$sql->execute();
						$resultado = $sql->fetchAll();
						
						
							
							
							
						 foreach ($resultado as $row) {
							  $categoria_user="";
							 
							 if ($row["development"]=="true")
							 {
								$categoria_user="Development";
							 }
							 if ($row["development"]=="false")
							 {
								$categoria_user="Basic profile";
							 }
							  if ($row["development"]=="director")
							 {
								$categoria_user="Director";
							 }
							  if ($row["development"]=="production")
							 {
								$categoria_user="Production";
							 }
							  if ($row["development"]=="assembler")
							 {
								$categoria_user="Assembler";
							 }
							  if ($row["development"]=="calibrator")
							 {
								$categoria_user="Calibrator";
							 }
							  if ($row["development"]=="quality")
							 {
								$categoria_user="Quality";
							 }
						?>
						<tr>
							<td width="100px">
							<a class="users-list-name" href="crearpermisos.php?iduser=<?php echo $row['iduserfas']."&idb=".$row['idbusiness']."&nn=".$row['nameuserfas'];?>">
					  	  <?php if ($row["userphoto"]=="true")
							  {
								?>  <img src="imgusers/user<?php echo $row["iduserfas"]; ?>.jpg" 
								class="img-circle" alt="<?php echo $row['nameuserfas'];?>" width="60%">
								<?php
							  }
							  else
							  {
								  ?>
								  <img src="imgusers/0.jpg" class="img-circle" alt="<?php echo $row['nameuserfas'];?>" width="60%">
								  <?php			  
							  }
							echo "</a>"  ;
							?>
							</td>
							<td> 		<a class="users-list-name" href="crearpermisos.php?iduser=<?php echo $row['iduserfas']."&idb=".$row['idbusiness']."&nn=".$row['nameuserfas'];?>">
							<?php echo $row['nameuserfas'];?>
							
							</a></td>
							<td><?php echo $row['hid'];?></td>
							<td><?php echo $row['namebusiness']."";?></b></td>
							<td><?php echo "<b>".$categoria_user;?></b></td>
						</tr>	 
					
						<?php
						 }
				
					
					?>
                     
           
                    </body>
					</table>
					</div>
                    <!-- /.users-list -->
                  </div>
                  <!-- /.card-body -->
                 
                  <!-- /.card-footer -->
                </div>
			</div>
					

        </section>
		<section class="col-lg-6 connectedSortable ui-sortable">
		

				<div class="card">
				<div class="card-header ui-sortable-handle">
               		
					<?php if ($habilitnewuser=="y")
							{
								?>
								<div class="card ">
								<div class="card-header bg-info">
								<h3 class="card-title ">Create New User</h3>


								<!-- /.card-tools -->
								</div>
								<!-- /.card-header -->
								<div class="card-body">

										<form name="frmlabeling" id="frmlabeling" action="" method="post"  class="form-horizontal needs-validation"  >							

									   <div class="card-body form-row">							   
											<div class="form-group col-md-6 ">
											<label for="exampleInputEmail1">UserName:</label>
											<input type="text" name="txtusername" id="txtusername" class="form-control" placeholder="Enter Username"  required data-required-message="Username is required.">
										


											</div>
											<div class="form-group col-md-6 ">
											<label for="exampleInputEmail1">HID:</label>
											<input type="text" name="txthidm" id="txthidm" class="form-control" placeholder="Enter HID"  required data-required-message="HID is required.">
										


											</div>

											<div class="form-group col-md-6 ">
											<label for="exampleInputEmail1">Password:</label>
											<input type="text" name="txtupwd" id="txtupwd" class="form-control" placeholder="Enter Password" required oninvalid="setCustomValidity('Passwordis required.')" 
								oninput="setCustomValidity('')">
											</div>
										
										   <div class="form-group col-md-6">
											<label for="exampleInputEmail1">E-Mail:</label>
											<input type="text" name="txtemail" id="txtemail" class="form-control" placeholder="E-Mail" required oninvalid="setCustomValidity('E-Mail is required.')" 
								oninput="setCustomValidity('')">
										   </div>
										   <div class="form-group col-md-6">
											<label for="exampleInputEmail1">Full Name:</label>
											<input type="text" name="txtnameuser" id="txtnameuser" class="form-control" placeholder="Full name" required oninvalid="setCustomValidity('Name Full is required.')" 
								oninput="setCustomValidity('')">
										   </div>
										
											
											 <div class="form-group col-md-6">
											<label for="exampleInputEmail1">Category:</label>
											 <select class="form-control" name="txtcategory" id="txtcategory" required oninvalid="setCustomValidity('Category is required.')" oninput="setCustomValidity('')">
												 <option value=""> - Select - </option>
												  <option value="assembler">Assembler</option>
											      <option value="false">Basic</option>
												   <option value="calibrator">Calibrator</option>
												 <option value="director">Director</option>
												  <option value="production">Production</option>
												  <option value="quality">Quality</option>
												  
												  
												  
											</select>
												
										   </div>	
										 <div class="form-group col-md-6">
											<label for="exampleInputEmail1">Business:</label>
											 <select class="form-control" name="txtbusiness" id="txtbusiness" required oninvalid="setCustomValidity('Business is required.')" oninput="setCustomValidity('')">
												 <option value=""> - Select - </option>
												 <option value="1">FIPLEX US</option>
												  <option value="2">WESTELL</option>
												  <option value="3">SPINNAKER</option>
											    
											</select>
												
										   </div>	
										   <div class="form-group col-md-6">
											<label for="exampleInputEmail1">Area:</label>
											 <select class="form-control" name="txtbarea" id="txtbarea" required oninvalid="setCustomValidity('Area is required.')" oninput="setCustomValidity('')">
												 <option value=""> - Select - </option>
													<?php
														$sql = $connect->prepare("select business_area.*,  business.namebusiness
														from business_area 
														inner join business
														on business.idbusiness = business_area.idbusiness 
														where business.active= 'true'
														order by namebusiness, namearea");
														$sql->execute();
														
														$resultado = $sql->fetchAll();
														foreach ($resultado as $row) {
															?>
															 <option value="<?php echo $row['idarea'];  ?>"><?php echo  $row['namebusiness']." - ".$row['namearea'] ;  ?></option> 
															<?php
														}
													?>
											    
											</select>
												
										   </div>	
										
										<!-- /.card-body -->
										<div class="card-footer text-right">
										
										  <button type="button" onclick="save_new_registro()" class="btn btn-primary right-align">Create New User</button>
										  
										  
										</div>
											<p class="text-danger" id="lbldatoserrr" id="lbldatoserrr">


								</p>
								</form>			
								</div>
								<hr>
							</div>
								<?php
							}
					
					
					?>
					
					
				<div class="card">
				
				 <?php
					 if ($vvidbusi != "") 
					 {
						 ?>
              <div class="card-header">
                <h3 class="card-title"> <i class="fa fa-fw fa-list-alt"></i> Details User: <?php echo $vvnameiser; ?> - Menu : </h3>
						

                <div class="card-tools">
              
                </div>
              </div>
			  <?php 
					 }
			  ?>
              <!-- /.card-header -->
              <div class="card-body p-0" style="display: block;">
			    <?php
					 if ($vvidbusi != "") 
					 {
						 ?>
                <div class="d-md-flex">
                  <div class="p-1 flex-fill" style="overflow: hidden" >
                    <textarea class="form-control form-controltamanio" rows="18" id="detallelog" name="detallelog"></textarea>
					<p name="detallelog1" id="detallelog1" ></p>						
					<p name="msjwait" id="msjwait" align="center"><img src="img/waitazul.gif" width="100px" ></p>	
					<?php
					 if ($vvidbusi != "") 
					 {
						 
					 
						$sql = $connect->prepare("select menu.* , business_user_menu.iduserfas as permisoiduserfas
							from menu
							left join business_user_menu
							on business_user_menu.idmenu = menu.idmenu and 
							 business_user_menu.idbusiness= ".$vvidbusi." and business_user_menu.iduserfas=  ".$vviduser. " where menu.active ='Y' order by namemenu asc");
						$sql->execute();
						
						$resultado = $sql->fetchAll();
						 foreach ($resultado as $row) {
						//	echo $row['namemenu']."<br>";
							if ( $row['permisoiduserfas'] == $vviduser)
							{
															?>
								<div class="form-group">
								<div class="custom-control custom-switch custom-switch-on-success custom-switch-off-danger">
								  <input type="checkbox" class="custom-control-input" onchange="cambiarestado(<?php echo $vviduser.",".$row['idmenu'].",".$vvidbusi;?>,'B')" id="customSwitch<?php echo  $row['idmenu'];?>" checked>
								  <label class="custom-control-label" for="customSwitch<?php echo  $row['idmenu'];?>"><?php echo  $row['namemenu'];?></label>

									<?php
									$sqlxmenu = $connect->prepare("select distinct menu_action.nameaction,coalesce(business_user_menu_action.idaction,0) as tienemenuaction, menu_action_rel.*
									from menu_action_rel
									inner join menu_action
									on menu_action.idmenu_action = menu_action_rel.idmenu_action

									left join business_user_menu_action
									on business_user_menu_action.idmenu = menu_action_rel.idmenu and 
									business_user_menu_action.idaction = menu_action_rel.idmenu_action and 
									    business_user_menu_action.idbusiness= ".$vvidbusi." and business_user_menu_action.iduserfas=  ".$vviduser. "
									where 	menu_action_rel.idmenu = ".$row['idmenu']."
									  order by nameaction asc");
								 
									$sqlxmenu->execute();

										
										$resultado2 = $sqlxmenu->fetchAll();
										foreach ($resultado2 as $row2) {
											if ($row2['tienemenuaction']==0)
											{
												?>
											<div class="custom-control custom-switch custom-switch-on-success custom-switch-off-danger">
											<input type="checkbox" class="custom-control-input" onchange="cambiarestado_menuaction(<?php echo $vviduser.",".$row['idmenu'].",".$row2['idmenu_action'];?>,'A',<?php echo $vvidbusi; ?>)" id="customSwitch<?php echo  $row['idmenu'].$row2['idmenu_action'];?>" >
											<label class="custom-control-label" for="customSwitch<?php echo  $row['idmenu'].$row2['idmenu_action'];?>"><?php echo  $row['namemenu']." -> ". $row2['nameaction']  ;?></label>
											</div>

											<?php
											}
											else
											{

											
											?>
											<div class="custom-control custom-switch custom-switch-on-success custom-switch-off-danger">
											<input type="checkbox" class="custom-control-input" onchange="cambiarestado_menuaction(<?php echo $vviduser.",".$row['idmenu'].",".$row2['idmenu_action'];?>,'B',<?php echo $vvidbusi; ?>)" id="customSwitch<?php echo  $row['idmenu'].$row2['idmenu_action'];?>" checked>
											<label class="custom-control-label" for="customSwitch<?php echo  $row['idmenu'].$row2['idmenu_action'];?>"><?php echo  $row['namemenu']." -> ". $row2['nameaction']  ;?></label>
											</div>

											<?php
											}
										}
									
									?>

								</div>
								
							  </div>
							 <?php
							}
							else
							{
								?>
								<div class="form-group">
								<div class="custom-control custom-switch custom-switch-on-success custom-switch-off-danger">
								  <input type="checkbox" class="custom-control-input" onchange="cambiarestado(<?php echo  $vviduser.",".$row['idmenu'].",".$vvidbusi;?>,'A')"  id="customSwitch<?php echo  $row['idmenu'];?>">
								  <label class="custom-control-label" for="customSwitch<?php echo  $row['idmenu'];?>"><?php echo  $row['namemenu'];?></label>


								  <?php
									$sqlxmenu = $connect->prepare("select distinct menu_action.nameaction,coalesce(business_user_menu_action.idaction,0) as tienemenuaction, menu_action_rel.*
									from menu_action_rel
									inner join menu_action
									on menu_action.idmenu_action = menu_action_rel.idmenu_action

									left join business_user_menu_action
									on business_user_menu_action.idmenu = menu_action_rel.idmenu and 
									business_user_menu_action.idaction = menu_action_rel.idmenu_action and 
									    business_user_menu_action.idbusiness= ".$vvidbusi." and business_user_menu_action.iduserfas=  ".$vviduser. "
									where 	menu_action_rel.idmenu = ".$row['idmenu']."
									  order by nameaction asc");
							 
									$sqlxmenu->execute();
										
										$resultado2 = $sqlxmenu->fetchAll();
										foreach ($resultado2 as $row2) {

											if ($row2['tienemenuaction']==0)
											{
												?>
											<div class="custom-control custom-switch custom-switch-on-success custom-switch-off-danger">
											<input type="checkbox" class="custom-control-input" onchange="cambiarestado_menuaction(<?php echo $vviduser.",".$row['idmenu'].",".$row2['idmenu_action'];?>,'A')" id="customSwitch<?php echo  $row['idmenu'].$row2['idmenu_action'];?>" >
											<label class="custom-control-label" for="customSwitch<?php echo  $row['idmenu'].$row2['idmenu_action'];?>"><?php echo  $row['namemenu']." -> ". $row2['nameaction']  ;?></label>
											</div>

											<?php
											}
											else
											{

											
											?>
											<div class="custom-control custom-switch custom-switch-on-success custom-switch-off-danger">
											<input type="checkbox" class="custom-control-input" onchange="cambiarestado_menuaction(<?php echo $vviduser.",".$row['idmenu'].",".$row2['idmenu_action'];?>,'B')" id="customSwitch<?php echo  $row['idmenu'].$row2['idmenu_action'];?>" checked>
											<label class="custom-control-label" for="customSwitch<?php echo  $row['idmenu'].$row2['idmenu_action'];?>"><?php echo  $row['namemenu']." -> ". $row2['nameaction']  ;?></label>
											</div>

											<?php
											}
										}
									
									?>


								</div>
							  </div>
							 <?php
							}
							
						 }
					
					}
					?>
					
                  </div>
				  <?php
				 //// PERMIOSS para VER CATEGORIAS DE TK 
				  ?>
            </div>
			   <div class="card-header">
                <h3 class="card-title"> <i class="fa fa-fw fa-list-alt"></i> 	Assign permissions to view ticket categories
			   </div> </h3>
					<div class="card-tools">
<br>
					<?php
						$sql = $connect->prepare("select fas_techsupport_category.* , fas_techsupport_category_byuserfas.iduserfas as permisoiduserfas 
						from fas_techsupport_category 
						left join fas_techsupport_category_byuserfas
						on fas_techsupport_category.idtechsupport_category = fas_techsupport_category_byuserfas.idtechsupport_category and idbusiness= ".$vvidbusi." and iduserfas=  ".$vviduser. "
						 where fas_techsupport_category.active = 'Y'  order by namecategory");
				//		 echo $sql;
			
					$sql->execute();
					
					$resultado = $sql->fetchAll();
					 foreach ($resultado as $row) {
					//	echo $row['namemenu']."<br>";
						if ( $row['permisoiduserfas'] == $vviduser)
						{
														?>
							<div class="form-group">
							<div class="custom-control custom-switch custom-switch-on-success custom-switch-off-danger">
							  <input type="checkbox" class="custom-control-input" onchange="cambiarestadocategoriatk(<?php echo $vviduser.",".$row['idtechsupport_category'].",".$vvidbusi;?>,'B')" id="customSwitchtk<?php echo  $row['idtechsupport_category'];?>" checked>
							  <label class="custom-control-label" for="customSwitchtk<?php echo  $row['idtechsupport_category'];?>"><?php echo  $row['namecategory']."--".$row['grouper'];?></label>
							</div>
							
						  </div>
						 <?php
						}
						else
						{
							?>
							<div class="form-group">
							<div class="custom-control custom-switch custom-switch-on-success custom-switch-off-danger">
							  <input type="checkbox" class="custom-control-input" onchange="cambiarestadocategoriatk(<?php echo  $vviduser.",".$row['idtechsupport_category'].",".$vvidbusi;?>,'A')"  id="customSwitchtk<?php echo  $row['idtechsupport_category'];?>">
							  <label class="custom-control-label" for="customSwitchtk<?php echo  $row['idtechsupport_category'];?>"><?php echo  $row['namecategory']."--".$row['grouper'];?></label>
							</div>
						  </div>
						 <?php
						}
						
					 }
					?>
				  
					</div>				
				</div>
			 
              </div>
			  <?php
					 }
					 if ($vvidbusi != "") 
					 {
						 
						 	$sql = $connect->prepare("select * from userfas where iduserfas=  ".$vviduser. "");
						$sql->execute();
						
						$resultado = $sql->fetchAll();
						 foreach ($resultado as $row2) {
							 $vv_txtmail = $row2['usermail'];
							  $vv_txtnamefull = $row2['nameuserfas'];
							  $txtnombreusuariohidden=  $row2['username'];
							    $vv_categoria = $row2['development'];
								
						 }
							 
						 ?>
			  <hr>
			    <div class="card-header">
                <h3 class="card-title"> <i class="fa fa-fw fa-list-alt"></i> Info User: <?php echo $vvnameiser; ?> : </h3>
					<div class="card-tools">
				  
					</div>				
				</div>
				   <div class="card-body p-0" style="display: block;">
					<div class="d-md-flex">
								<form name="frmlabeling" id="frmlabeling" action="" method="post"  class="form-horizontal needs-validation"  >							

									   <div class="card-body form-row">							   
																															
										   <div class="form-group col-md-6">
											<label for="exampleInputEmail1">E-Mail:</label>
											<input type="text" name="txtemailmodif" id="txtemailmodif" class="form-control" placeholder="E-Mail" required oninvalid="setCustomValidity('E-Mail is required.')" 
								oninput="setCustomValidity('')" value="<?php echo $vv_txtmail; ?>">
										   </div>
										   <div class="form-group col-md-6">
											<label for="exampleInputEmail1">Full Name:</label>
											<input type="text" name="txtnameusermodif" id="txtnameusermodif" class="form-control" placeholder="Full name" required oninvalid="setCustomValidity('Name Full is required.')" 
								oninput="setCustomValidity('')" value="<?php echo $vv_txtnamefull; ?>">
								<input type="hidden" name="txtusernamehideen" id="txtusernamehideen" class="form-control"  value="<?php echo $txtnombreusuariohidden; ?>">
										   </div>
										
											
											 <div class="form-group col-md-6">
											<label for="exampleInputEmail1">Category: <?php echo  $vv_categoria; ?></label>
											 <select class="form-control" name="txtcategorymodif" id="txtcategorymodif" required oninvalid="setCustomValidity('Category is required.')" oninput="setCustomValidity('')">
												 <option value=""> - Select - </option>
												 <?php
												  $loencontre = "";
												 if (  $vv_categoria == "assembler")
												 {
													 $loencontre = "selected";
												 }
												 ?>
												  <option value="assembler" <?php echo  $loencontre; ?>>Assembler</option>
												   <?php
												  $loencontre = "";
												 if (  $vv_categoria == "false")
												 {
													 $loencontre = "selected";
												 }
												 ?>
											      <option value="false" <?php echo  $loencontre; ?>>Basic</option>
												   <?php
												  $loencontre = "";
												 if (  $vv_categoria == "calibrator")
												 {
													 $loencontre = "selected";
												 }
												 ?>
												   <option value="calibrator" <?php echo  $loencontre; ?>>Calibrator</option>
												    <?php
												  $loencontre = "";
												 if (  $vv_categoria == "director")
												 {
													 $loencontre = "selected";
												 }
												 ?>
												 <option value="director" <?php echo  $loencontre; ?>>Director</option>
												  <?php
												  $loencontre = "";
												 if (  $vv_categoria == "production")
												 {
													 $loencontre = "selected";
												 }
												 ?>
												  <option value="production" <?php echo  $loencontre; ?>>Production</option>
												   <?php
												  $loencontre = "";
												 if (  $vv_categoria == "quality")
												 {
													 $loencontre = "selected";
												 }
												 ?>
												  <option value="quality" <?php echo  $loencontre; ?>>Quality</option>
												     <?php
												  $loencontre = "";
												 if (  $vv_categoria == "true")
												 {
													 $loencontre = "selected";
												 }
												 ?>
												  <option value="true" <?php echo  $loencontre; ?>>Development</option>
												  
												  
											</select>
												
										   </div>	
										   <div class="form-group col-md-6" id="divnewpass" name ="divnewpass" style="display: none;">
											<label for="exampleInputEmail1"> New Password:</label>
											<p id="txtnewpassgenerada" name="txtnewpassgenerada"></p>
											
												
										   </div>	
										 
										 <input type="hidden" name="idcliselect" id="idcliselect" value="<?php echo  $vviduser; ?>">
										 <input type="hidden" name="idcliempreselect" id="idcliempreselect" value="<?php echo $vvidbusi;  ?>">
									
										<!-- /.card-body -->
										<div class="card-footer text-right">
										
										  <button type="button" onclick="save_modify_registro(1)" class="btn btn-primary right-align">Modify info User</button>
										  
										    <button type="button" onclick="save_modify_registro(2)" class="btn btn-primary right-align">Create new password </button>
											<br><br>
											  <button type="button" onclick="save_modify_registro(3)" class="btn btn-info right-align">Create new password and send it to e-mail</button>
										  
										  
										</div>
											<p class="text-danger" id="lbldatoserrr" id="lbldatoserrr">


								</p>
								</form>			
					</div>				
				</div>
				  <?php
					 }
						 ?>
				
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
<script src="plugins/datatables/jquery.dataTables.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>

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

				 $('#tablabc').DataTable( { "order": [[ 0, "desc" ]]   } );	

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
	
	
			var tamanyo_password				=	10;			// definimos el tamaño que tendrá nuestro password

			var caracteres_conseguidos			=	0;			// contador de los caracteres que hemos conseguido
			var caracter_temporal				=	'';
			
			var array_caracteres				=	new Array();// array para guardar los caracteres de forma temporal
				
				for(var i = 0; i < tamanyo_password; i++){		// inicializamos el array con el valor null
					array_caracteres[i]	=	null;
				}

			var password_definitivo				=	'';

			var numero_minimo_letras_minusculas	=	1;			// en ésta y las siguientes variables definimos cuántos 
			var numero_minimo_letras_mayusculas	=	1;			// caracteres de cada tipo queremos en cada 
			var numero_minimo_numeros			=	1;
			var numero_minimo_simbolos			=	1;

			var letras_minusculas_conseguidas 	=	0;
			var	letras_mayusculas_conseguidas	=	0;
			var	numeros_conseguidos				=	0;
			var	simbolos_conseguidos			=	0;


			// función que genera un número aleatorio entre los límites superior e inferior pasados por parámetro
			function genera_aleatorio(i_numero_inferior, i_numero_superior) {
			    var     i_aleatorio  =   Math.floor((Math.random() * (i_numero_superior - i_numero_inferior + 1)) + i_numero_inferior);
			    return  i_aleatorio;
			}


			// función que genera un tipo de caracter en base al tipo que se le pasa por parámetro (mayúscula, minúscula, número, símbolo o aleatorio)
			function genera_caracter(tipo_de_caracter){
				// hemos creado una lista de caracteres específica, que además no tiene algunos caracteres como la "i" mayúscula ni la "l" minúscula para evitar errores de transcripción
			//	var lista_de_caracteres	=	'$+=?@_23456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz';
				var lista_de_caracteres	=	'98765423456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz';
				var caracter_generado	=	'';
				var valor_inferior		=	0;
				var valor_superior		=	0;

				switch (tipo_de_caracter){
					case 'minúscula':
						valor_inferior	=	38;
						valor_superior	=	61;
						break;
					case 'mayúscula':
						valor_inferior	=	14;
						valor_superior	=	37;
						break;
					case 'número':
						valor_inferior	=	6;
						valor_superior	=	13;
						break;
					case 'símbolo':	
						valor_inferior	=	0;
						valor_superior	=	5;
						break;
					case 'aleatorio':
						valor_inferior	=	0;
						valor_superior	=	61;

				} // fin del switch

				caracter_generado	=	lista_de_caracteres.charAt(genera_aleatorio(valor_inferior, valor_superior));
				return caracter_generado;
			} // fin de la función genera_caracter()


			// función que guarda en una posición vacía aleatoria el caracter pasado por parámetro
			function guarda_caracter_en_posicion_aleatoria(caracter_pasado_por_parametro){
				var guardado_en_posicion_vacia	=	false;
				var posicion_en_array			=	0;

				while(guardado_en_posicion_vacia	!=	true){
					posicion_en_array	=	genera_aleatorio(0, tamanyo_password-1);	// generamos un aleatorio en el rango del tamaño del password

					// el array ha sido inicializado con null en sus posiciones. Si es una posición vacía, guardamos el caracter
					if(array_caracteres[posicion_en_array] == null){
						array_caracteres[posicion_en_array]	=	caracter_pasado_por_parametro;
						guardado_en_posicion_vacia			=	true;
					}
				}
			}


			// función que se inicia una vez que la página se ha cargado
			function generar_contrasenya(){
				password_definitivo =""
				// generamos los distintos tipos de caracteres y los metemos en un password_temporal
				while (letras_minusculas_conseguidas < numero_minimo_letras_minusculas){
					caracter_temporal	=	genera_caracter('minúscula');
					guarda_caracter_en_posicion_aleatoria(caracter_temporal);
					letras_minusculas_conseguidas++;
					caracteres_conseguidos++;
				}

				while (letras_mayusculas_conseguidas < numero_minimo_letras_mayusculas){
					caracter_temporal	=	genera_caracter('mayúscula');
					guarda_caracter_en_posicion_aleatoria(caracter_temporal);
					letras_mayusculas_conseguidas++;
					caracteres_conseguidos++;
				}

				while (numeros_conseguidos < numero_minimo_numeros){
					caracter_temporal	=	genera_caracter('número');
					guarda_caracter_en_posicion_aleatoria(caracter_temporal);
					numeros_conseguidos++;
					caracteres_conseguidos++;
				}

				while (simbolos_conseguidos < numero_minimo_simbolos){
					caracter_temporal	=	genera_caracter('símbolo');
					guarda_caracter_en_posicion_aleatoria(caracter_temporal);
					simbolos_conseguidos++;
					caracteres_conseguidos++;
				}

				// si no hemos generado todos los caracteres que necesitamos, de forma aleatoria añadimos los que nos falten
				// hasta llegar al tamaño de password que nos interesa
				while (caracteres_conseguidos < tamanyo_password){
					caracter_temporal	=	genera_caracter('aleatorio');
					guarda_caracter_en_posicion_aleatoria(caracter_temporal);
					caracteres_conseguidos++;
				}

				// ahora pasamos el contenido del array a la variable password_definitivo
				for(var i=0; i < array_caracteres.length; i++){
					password_definitivo	=	password_definitivo + array_caracteres[i];
				}

				// indicamos los parámetros con los que hemos generado la contraseña
				/*document.write('Tamaño total de la contraseña: ' 	+ tamanyo_password + '<br>');
				document.write('Cantidad de minúsculas: '			+ numero_minimo_letras_minusculas + '<br>');
				document.write('Cantidad de mayúsculas: ' 			+ numero_minimo_letras_mayusculas + '<br>');
				document.write('Cantidad de números: ' 				+ numero_minimo_numeros + '<br>');
				document.write('Cantidad de símbolos: ' 			+ numero_minimo_simbolos + '<br>');
				document.write('El resto de caracteres hasta llegar al tamaño de la contraseña se completa con caracteres aleatorios.<br>');
*/
				// y ahora simplemente lo mostramos por pantalla
			//	alert('Password generado: <strong>' + password_definitivo + '</strong><br>');
				return password_definitivo;
			}
	// controlar inactividad en la web	
		$(document).inactivityTimeout({
                inactivityWait: 10000,
                dialogWait: 10,
                logoutUrl: 'logout.php'
            })
	// fin controlar inactividad en la web		
	
	 /* requesting data */
	 function cambiarestado_menuaction(iduser,idmenu, idaction , action, idempresa)
	 {
		$.ajax
			({ 
				url: 'updatepermisosuseraction.php',
				data: "iduser="+iduser+'&idmenu='+idmenu+'&accion='+$('#customSwitch'+idmenu).prop("checked")+'&idb='+idempresa+'&idactionm='+idaction,	
				type: 'post',
			     cache:false,
				success: function(data)
				{
					var datax = JSON.parse(data)
				//	console.log(datax);
                 //   console.log(datax.vuser);
					
			
				},
				error: function() {
					alert('error')
					console.log("No se ha podido obtener la información");
				}

			});	
	 }

	 function cambiarestadocategoriatk(iduser, idcategory, idempresa)
	 {
				
			
		$.ajax
			({ 
				url: 'updatepermisosuserbytkmanager.php',
				data: "iduser="+iduser+'&idmenu='+idcategory+'&accion='+$('#customSwitchtk'+idcategory).prop("checked")+'&idb='+idempresa,	
				type: 'post',
			     cache:false,
				success: function(data)
				{
					var datax = JSON.parse(data)
				//	console.log(datax);
                 //   console.log(datax.vuser);
					
			
				},
				error: function() {
					alert('error')
					console.log("No se ha podido obtener la información");
				}

			}); 
	 }
     		
	function cambiarestado(iduser, idmenu,idempresa, accion)	
	{
		//alert(iduser +'-'+idmenu+'-accion'+accion);
	//console.log(	$('#customSwitch'+idmenu).prop("checked");
		
		$.ajax
			({ 
				url: 'updatepermisosuser.php',
				data: "iduser="+iduser+'&idmenu='+idmenu+'&accion='+$('#customSwitch'+idmenu).prop("checked")+'&idb='+idempresa,	
				type: 'post',
			     cache:false,
				success: function(data)
				{
					var datax = JSON.parse(data)
				//	console.log(datax);
                 //   console.log(datax.vuser);
					
			
				},
				error: function() {
					alert('error')
					console.log("No se ha podido obtener la información");
				}

			});
		
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
   
   
     function save_modify_registro(tipoaccion)
   {
	   /// Solo modif info del usuarios
	   toastr["warning"]("Processing information!", "");	
	   if (tipoaccion ==1)
	   {
		   
		   
		   $('#lbldatoserrr').html("");
		 var v_idcliselect = $('#idcliselect').val();
		  var v_idcliempreselect = $('#idcliempreselect ').val();
		 var v_txtupwd = $('#txtupwdmodif').val();
		 var v_txtnameuser = $('#txtnameusermodif').val();
		 var v_txtcategory = $('#txtcategorymodif').val();		 
		 var v_txtemail = $('#txtemailmodif').val();
		 
		   toastr["success"]("processing information..", "");	
		
				$.ajax({
				url: 'ajax_updateinfo_user.php', 				
				data: "qaccem=1&idcliselect="+v_idcliselect+'&idcliempreselect='+v_idcliempreselect+'&txtupwdmodif='+v_txtupwd+'&txtnameusermodif='+v_txtnameuser+'&txtcategorymodif='+v_txtcategory+'&txtemailmodif='+v_txtemail,	
				type: 'post',				
				datatype:'JSON',				
				cache:false,					
				success: function(data, status, xhr) {
					var resultadom = data.resultiu;
					var resulterr = data.erromsj;
		
					if (resultadom =="ok" )
					{
						toastr["success"]("Save OK!", "");	
						alert('Save OK!');
						location.reload(); 
		 
					
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
	     /// Solo cambia clave
	   if (tipoaccion ==2)
	   {
		     $('#lbldatoserrr').html("");
		  var v_idcliselect = $('#idcliselect').val();
		  var v_idcliempreselect = $('#idcliempreselect ').val();
	 	  var v_txtupwd = $('#txtupwdmodif').val();
		   var v_txtemail = $('#txtemailmodif').val();
		  
		 
		   var fff = generar_contrasenya();
			$('#divnewpass').show();
			$('#txtnewpassgenerada').html('<b>'+fff+'</b>');
			
		  
		   	$.ajax({
				url: 'ajax_updateinfo_user.php', 				
				data: "qaccem=2&v_txtupwd="+fff+'&idcliempreselect='+v_idcliempreselect+'&idcliselect='+v_idcliselect+'&txtemailmodif='+v_txtemail,	
				type: 'post',				
				datatype:'JSON',				
				cache:false,					
				success: function(data, status, xhr) {
					var resultadom = data.resultiu;
					var resulterr = data.erromsj;
		
					if (resultadom =="ok" )
					{
						toastr["success"]("Save OK, New Password!", "");	
						alert('Save OK, New Password!');
					//	location.reload(); 
		 
					
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
	     ///  cambia clave y envia al email
	   if (tipoaccion ==3)
	   {
		      $('#lbldatoserrr').html("");
		  var v_idcliselect = $('#idcliselect').val();
		  var v_idcliempreselect = $('#idcliempreselect ').val();
	 	  var v_txtupwd = $('#txtupwdmodif').val();
		   var v_txtemail = $('#txtemailmodif').val();
		   var vtxtusernamehideen =  $('#txtusernamehideen').val(); 
		 
		   var fff = generar_contrasenya();
			$('#divnewpass').show();
			$('#txtnewpassgenerada').html('<b>'+fff+'</b>');
			
		  
		   	$.ajax({
				url: 'ajax_updateinfo_user.php', 				
				data: "qaccem=3&v_txtupwd="+fff+'&idcliempreselect='+v_idcliempreselect+'&idcliselect='+v_idcliselect+'&txtemailmodif='+v_txtemail+'&vtxtusernamehideen='+vtxtusernamehideen,	
				type: 'post',				
				datatype:'JSON',				
				cache:false,					
				success: function(data, status, xhr) {
					var resultadom = data.resultiu;
					var resulterr = data.erromsj;
		
					if (resultadom =="ok" )
					{
						toastr["success"]("Save OK, New Password!", "");	
						alert('Save OK, New Password!');
					//	location.reload(); 
		 
					
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
   }
     function save_new_registro()
   {
	 	   
	 	 	   

	////Controlamos campos vacios
		if ($('#txtusername')[0].checkValidity() == false)
		{
			toastr["error"]("Error, Useranme is required..", "");	
			return false;
		}	
		if ($('#txthidm')[0].checkValidity() == false)
		{
			toastr["error"]("Error, HID is required..", "");	
			return false;
		}	
		
		if ($('#txtupwd')[0].checkValidity() == false)
		{
			toastr["error"]("Error, Password is required..", "");	
			return false;
		}	
		if ($('#txtnameuser')[0].checkValidity() == false)
		{
			toastr["error"]("Error, Name Full is required..", "");	
			return false;
		}
	
	
		if ($('#txtcategory')[0].checkValidity() == false)
		{
			toastr["error"]("Error, Category is required..", "");	
			return false;
		}	
		
	if ($('#txtbusiness')[0].checkValidity() == false)
		{
			toastr["error"]("Error, Business is required..", "");	
			return false;
		}	
		if ($('#txtbarea')[0].checkValidity() == false)
		{
			toastr["error"]("Error, Area is required..", "");	
			return false;
		}			
	
	
				
		$('#lbldatoserrr').html("");
		 var v_txtusername = $('#txtusername').val();
		 var v_txthidm = $('#txthidm').val();
		 
		 var v_txtupwd = $('#txtupwd').val();
		 var v_txtnameuser = $('#txtnameuser').val();
		 var v_txtcategory = $('#txtcategory').val();
		  var v_txtbusiness = $('#txtbusiness').val();
		  var v_txtbarea = $('#txtbarea').val();
		 
		 var v_txtemail = $('#txtemail').val();
		 
		
					
		toastr["success"]("processing information..", "");	
		
				$.ajax({
				url: 'ajax_createnew_user.php', 				
				data: "v_txthidm="+v_txthidm+"&v_txtusername="+v_txtusername+'&v_txtupwd='+v_txtupwd+'&v_txtnameuser='+v_txtnameuser+'&v_txtcategory='+v_txtcategory+'&v_txtbusiness='+v_txtbusiness+'&v_txtemail='+v_txtemail+'&v_txtbarea='+v_txtbarea,	
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
						alert('Save OK!');
						location.reload(); 
		 
					
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
   
</script>

</html>

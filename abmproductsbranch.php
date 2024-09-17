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
		//pero s	exit();
		}
	
	
	$status = $connect->getAttribute(PDO::ATTR_CONNECTION_STATUS);
	
	if ($status !="Connection OK; waiting to send.")
	{
	
		header("Location: http://".$ipservidorapache."/".$folderservidor."/errorconect.php");
		exit;
		
	}
	
	
	////////////////////////////////////////////////////////////////////////////
	
	

////////////////////////////////////////////////////////////////////////////


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
  
  .wj-treeview {
    display:block;
    height: 350px;
    font-size: 120%;
    margin-bottom: 8px;
    padding: 6px;
    background: #f0f0f0;
    box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
}


#tagList ul {
  margin: 0;
  padding: 0;
  list-style: none;
}

#tagList ul li {
  background: #fff;
  border: 1px solid #ccc;
  width: auto;
  display: inline-block;
  padding: .125em .2em;
  margin: 3px 2px;
}


</style>
 
    <link rel="stylesheet" href="cssfiplex.css">
	
	
  <link rel="stylesheet" href="themestreecss/default2/style.css">



  
  
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

 include("menu.php"); 
 include("funcionesstores.php"); 
 include ('licencefiplex_mm.php');
 
   //   $Encryption = new Encryption();
   
  /*  $tree_array_products = array();  
   
   function create_tree_products($branch_show)
		{		
				 include("db_conect.php"); 
				$query_lista ="select fnt_select_fas_tree('".$branch_show."')";				 
				 //  echo $query_lista;
						$data = $connect->query($query_lista)->fetchAll();		
						
					//	echo "Len".count($data);
					if ( count($data) >0)	
					{
				
						foreach ($data as $row2) 
						 {
							// echo $row2[0]."<br>";
				
							$obj = json_decode($row2[0]);

							$tree_array_products = array("id" => $obj->{'iduniquebranch'}, "name" => $obj->{'nameidfasstepson'});
									 create_tree_products($obj->{'iduniquebranch'});
								echo "<br>".$obj->{'iduniquebranch'};
						 }
					 		
					}	

	//	echo "<br>llamado:".var_dump($tree_array_products);					
		}	
*/

  
 // unset($arr[5]); // Esto elimina el elemento del array
//unset($arr);    // Esto elimina el array completo
  
?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>FAS Product Branch Type</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">FAS Product Branch Type</li>
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

			<p name="msjwaitline" id="msjwaitline" align="center"><img src="img/waitazul.gif" width="100px" ></p>	
				<div class="card">
				<br>
					<div class="container form-group">
											<label>Select Business:</label>
					 
												<select class="form-control form-control-sm" name="txtbusiness" id="txtbusiness" onchange="refresh_tree(this.value);" >
												<option value=""> - Select - </option>
												 <?php
												 
											

												 $sql = $connect->prepare("select * from business order by namebusiness ");
												  
																						 $sql->execute();
																						 $resultado3 = $sql->fetchAll();
																						 foreach ($resultado3 as $row2) 
																						  {
																							  $autoselect = '';
																							  if ($row2['idbusiness']==10)
																							  {
																								$autoselect = 'selected';
																							  }
																							 
																						  ?>
																						  <option value="<?php echo  $row2['idbusiness']; ?>" <?php echo $autoselect;?>>
																						  <?php echo  $row2['namebusiness']; ?>
																						  </option>
																						  <?php
																						  }

												 ?>
											  </select>
					</div>						  

					<hr>
					 <div class="container-fluid">
					 <br>

						<div class="ui-widget">
						  <div class="ui-widget-header">
							<b>Family Tree Products</b>
						  </div>
						  <div id="tree">
						  </div>
						</div>
					</div>
					<br><br><br>
			</div>
		
		
			<div class="card d-none">
		
			</div>
		

        </section>
		<section class="col-lg-6 connectedSortable ui-sortable">
		

				<div class="card">
				<div class="card-header ui-sortable-handle" style="cursor: move;">
               		
				<div class="card">
              <div class="card-header">
                <h3 class="card-title"> <i class="fa fa-fw fa-list-alt"></i> List of Products without associated tree</h3>
						

              
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0" style="display: block;">
                <div class="d-md-flex">
			    	 <div class="container-fluid">
					 <br>
					 <p class="text-primary">You must drag a product to the branch of the tree you want</p>
					 
							<div id="tagList">
							<ul>
							  
							  	<?php
								  $sql = $connect->prepare("select *  from products where active = 'Y' limit 10 ");
	 
											$sql->execute();
											$resultado3 = $sql->fetchAll();
											$i=1;
											foreach ($resultado3 as $row2) 
											 {
												
											 ?>
											 
											
											                      
											<li data-tag="<?php echo $i; ?>" id="p#<?php echo  $row2['idproduct']; ?>"> <i class='fas fa-paperclip'></i>&nbsp;&nbsp;<?php echo  $row2['modelciu']."-".$row2['idproduct']; ?></li>
					
											
											 <?php
											 $i = $i + 1 ;
											 }
									
							
							
							?>
						
							</ul>
						  </div>
						  <br>
					</div>
				</div>
              
                  </div><!-- /.card-pane-right -->
                </div><!-- /.d-md-flex -->
              </div>
              <!-- /.card-body -->
            </div>
			
			  <!-- /.2div de ramas -->
			  
			  		<div class="card">
				<div class="card-header ui-sortable-handle" style="cursor: move;">
               		
				<div class="card">
              <div class="card-header">
                <h3 class="card-title"> <i class="fa fa-fw fa-list-alt"></i> Branch list</h3>
						

              
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0" style="display: block;">
                <div class="d-md-flex">
			    	 <div class="container-fluid">
					 <br>
					 <p class="text-primary">You must drag a level to the branch of the tree you want</p>
					 
							<div id="tagList">
							<ul>
							<?php
								  $sql = $connect->prepare("select *  from products_branch where active = 'Y'  ");
	 
											$sql->execute();
											$resultado3 = $sql->fetchAll();
											$i=100;
											foreach ($resultado3 as $row2) 
											 {
												
											 ?>
											<li data-tag="<?php echo $i; ?>" id="b#<?php echo  $row2['codeproductbranch']; ?>"> <i class='fas fa-paperclip'></i>&nbsp;&nbsp;<?php echo  $row2['description']; ?></li>
											<?php
											 $i = $i + 1 ;
											 }
																
							?>
						
							</ul>
						  </div>
						  <br>
					</div>
				</div>
              
                  </div><!-- /.card-pane-right -->
                </div><!-- /.d-md-flex -->
              </div>
              <!-- /.card-body -->
            </div>
			    <!-- /.fin 2div de ramas-->
					  <!-- /.3div de ramas -->
			  
			  		<div class="card">
				<div class="card-header ui-sortable-handle" style="cursor: move;">
               		
				<div class="card">
              <div class="card-header">
                <h3 class="card-title"> <i class="fa fa-fw fa-list-alt"></i> Create new branch</h3>
						
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
					
					
					  <div class="card-body form-row">		
							   
									
									<div class="form-group col-md-12 ">
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
							
								  <button type="button" onclick="save_new_registro_type()" class="btn btn-primary right-align">Create New Branch</button>
								  
								  
								</div>
									<p class="text-danger" id="lbldatoserrr" id="lbldatoserrr">
									 </p>
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
<script src="js/jquery-1.11.1.min.js"></script>

<script src="js/jquery-ui.js"></script>
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

  <script type="text/javascript" src="js/jstree.min.js"></script>

</body>

<script type="text/javascript">

var exData = [{
  id: "loc1",
  parent: "#",
  text: "UNIT"
}, {
  id: "loc2",
  parent: "#",
  text: "MODULE"
}, {
  id: "italy-1",
  parent: "loc2",
  text: "PR45-4C-2",
  icon: "fa fa-inbox"
}, {
  id: "poland-1",
  parent: "loc2",
  text: "DCL9533B1N-M",
  icon: "fa fa-inbox"
}];


function load_tree_products(idtree_business, namebusiness)
{
	
var jsonTreeData = "";

	$.ajax({
				url: 'ajax_list_tree_branchproducts.php?idbu='+idtree_business+'&nmbu='+namebusiness,			
				type: 'post',				
				datatype:'JSON',				
				cache:false,					
				success: function(data, status, xhr) {
					jsonTreeData= data ;
				//console.log(jsonTreeData);
				//	console.log(exData);
					 $('#tree').jstree({
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
							
							
							/// Enviamos datos del chat!
								 return new Promise(function(resolve, reject) {
								var formData = new FormData();
								var req = new XMLHttpRequest();

									
								//consulta si devolvio el Scan Device
								
								formData.append("idbusiness", $("#txtbusiness").val() );
								formData.append("nodoprodadd", node.idm );
								formData.append("nodobranchadd", node.idm );
								formData.append("nodobranchmove", node.id );
								formData.append("nodobranchfrom", par.id );


								req.open("POST", "ajaxinsert_brachprodtree.php");
								req.send(formData);

								req.onload = function() {
								if (req.status == 200) {
									resolve(JSON.parse(req.response));
									toastr["success"]("Save OK!", "");		
									 $("#tree").jstree("destroy");
									toastr["success"]("reindexing tree....", "");		 
									 load_tree_products( $("#txtbusiness").val() ,$('#txtbusiness option:selected').html());
									// $("#tree").jstree("open_all");
									// $("#tree").jstree("open_all");
									return true;
									
									
								}
								else {
								reject();
										toastr["error"]("Error when storing data...", "");			
										return false;										
								}
								};


								})


								//fin enviamos datos chat
							
							
							
								
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
console.log('open tree marco');

setInterval('open_tree_all()',1000);
///
}

function open_tree_all()
{

	$("#tree").jstree("open_all");
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


 //// Levanto datos. de jsqon

	     load_tree_products(10, $('#txtbusiness option:selected').html());
		// load_tree_productsvaci();




  
 // console.log('agrego funcion a botones');
  
  $('#tagList li').draggable({
    cursor: 'move',
    helper: 'clone',
    start: function(e, ui) {
      var item = $("<div>", {
        id: "jstree-dnd",
        class: "jstree-default"
      });
      $("<i>", {
        class: "jstree-icon jstree-er"
      }).appendTo(item);
      item.append($(this).text());
   //   var idRoot = $(this).attr("id").slice(0, -2);
	   var idRoot = $(this).attr("id").slice(0, -2);
	 // console.log('HOLA'+idRoot+'-era:'+ $(this).id);
	 
	 ///linea: 1369 --    obj: makeTreeItem(this),
      var newId = idRoot + "-" + ($("#tree [id|='" + idRoot + "'][class*='jstree-node']").length + 1);
      return $.vakata.dnd.start(e, {
        jstree: true,
        obj: makeTreeItem(this),
        nodes: [{
          id: newId,
          text: $(this).text(),
		  idm: $(this).attr("id"),
          icon: "fas fa-check"
        }]
      }, item);
    }
  });
  
  
  
  
  
  
  

});
	 

function makeTreeItem(el) {
  return $("<a>", {
    id: $(el).attr("id") + "_anchor",
    class: "jstree-anchor",
    href: "#"
  });
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

   function refresh_tree(idbusiness_filter)
   {
	$("#tree").jstree("destroy");
	load_tree_products(idbusiness_filter,  $('#txtbusiness option:selected').html());
   }
   
    function save_new_registro_type()
	 {
		 ///////// Crear nuevo type de flia de productos
		 var faltandatosflia = 0;
		////Controlamos campos vacios
		
		if ($('#txttypeflia')[0].checkValidity() == false)
		{
			toastr["error"]("Error, Type Name required..", "");	
			faltandatosflia = 1;
		}	
	
		///txtfliaprod
		
	
	
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
		 var cmbtxthavefw = $('#cmbtxthavefw').val();
		 
		 		 
		 var txtfpgacusdescrip = $('#txtfpgacusdescrip').val();
		 var txtuccusdescrip = $('#txtuccusdescrip').val();
		 var txtethercusdescrip = $('#txtethercusdescrip').val();
		
					
				toastr["success"]("processing information..", "");	
		
				$.ajax({
				url: 'ajax_createnew_fasbranch.php', 				
				data: 'txttypeflia='+txttypeflia+'&txtfpga='+txtfpga+'&txtfpgafas='+txtfpgafas+'&txtuc='+txtuc+'&txtucfas='+txtucfas+'&txtether='+txtether+'&txtetherfas='+txtetherfas+'&calstring='+calstring+'&txtethercusdescrip='+txtethercusdescrip+'&txtuccusdescrip='+txtuccusdescrip+'&txtethercusdescrip='+txtethercusdescrip+'&cmbtxthavefw='+cmbtxthavefw,	
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
		//		echo "HOLA".str_pad("1", 3, "0", STR_PAD_LEFT);
		//	echo "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa".bin2hex("001")."-<br>".bin2hex("999");
# 74686174277320616c6c20796f75206e656564
//echo hex2bin('303031');
# that's all you need

?>
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
	//		header("Location: http://".$ipservidorapache."/".$folderservidor."/permissiondenied.php?b=".$_SESSION["b"]."&c=".array_pop(explode('/', $_SERVER['PHP_SELF'])));
	//		exit();
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
 <link rel="stylesheet" href="cssfiplexsintextareaslog.css">

<link href="css/select2.css" rel="stylesheet" />
<link href="css/testcssselector.css" rel="stylesheet" />
<link rel="stylesheet" href="themestreecss/default2/style.css">
  
    <link rel="stylesheet" href="cssfiplex.css">
</head>
<style>
textarea.form-control { height: 238px;}
</style>
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
            <h1>Wizard Unit creator</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active"> Wizard Unit creator</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid card">
        
        <!-- Mostramos los datos..  -->
        <div class="row "  >
        <section class="col-lg-12 connectedSortable ui-sortable">

        <div class="" name="s2" id="s2" style="display.">
                <div class="form-group row" >
                        
                        <label for="inputPassword" class="col-sm-12 col-form-label">Select the product you want to use as replica template.:</label>
                        <div class="col-sm-12">	                     
                          <select class="js-example-basic-single col-sm-8" required  id="txtlistcius" name="txtlistcius">
                          </select> &nbsp;&nbsp;		
						
                        </div>
                     
                </div>    
        </div>
        </div>
   

        <!-- /.mostramos si existe CIU -->
        <div class="row " id="divaddciu" name="divaddciu" >
									   <hr>
									   <hr>
									   <div class="col-sm-6">
										  <!-- text input -->
										  <div class="form-group">
											<label>New CIU name:</label>
											<input type="text" name="txtnewprod" placeholder="new CIU name" id="txtnewprod" class="form-control" >
										  </div>
										</div>
									   <div class="col-sm-6">
										  <!-- text input -->
										  <div class="form-group">
											<label>Select Business:</label>
												<select class="form-control form-control-sm" name="txtbusiness" id="txtbusiness" required="" oninvalid="setCustomValidity('Business is required.')" oninput="setCustomValidity('')">
												<option value=""> - Select - </option>
												 <?php
												 
											

												 $sql = $connect->prepare("select * from business order by namebusiness ");
												  
																						 $sql->execute();
																						 $resultado3 = $sql->fetchAll();
																						 foreach ($resultado3 as $row2) 
																						  {
																							 
																						  ?>
																						  <option value="<?php echo  $row2['idbusiness']; ?>">
																						  <?php echo  $row2['namebusiness']; ?>
																						  </option>
																						  <?php
																						  }

												 ?>
											  </select>
										  </div>
										</div>
									 
										<div class="col-sm-6">
										  <div class="form-group">
											<label>Select the Items to Replicate	:</label>
													
											<div class="card-body">
                <ul class="todo-list ui-sortable" data-widget="todo-list">
                
                  <li class="done">
					  <div class="form-group row">
						  <label for="inputEmail3" class="col-sm-3 col-form-label">											
							<input type="checkbox" value="" name="todo2" id="todoCheck2" checked="">     	
							Object Band  <i class="fa fa-eye"></i> </label>
								<div class="col-sm-9">												   
									<select class="js-example-basic-single col-sm-12 " name="cmbrepli_objband" id="cmbrepli_objband" required="" oninvalid="setCustomValidity('is required.')" oninput="setCustomValidity('')">
									<option value=""> - Select - </option>

									</select>
								</div>
						</div> 
 
                  
                  </li>
				  <li class="done">
				 
				  <div class="form-group row">
						  <label for="inputEmail3" class="col-sm-3 col-form-label">											
							<input type="checkbox" value="" name="todo2" id="todoCheck2" checked="">     	
							Routines Process  <i class="fa fa-eye"></i> </label>
								<div class="col-sm-9">												   
									<select class="js-example-basic-single col-sm-12 " name="cmbrepli_routpro" id="cmbrepli_routpro" required="" oninvalid="setCustomValidity('is required.')" oninput="setCustomValidity('')">
									<option value=""> - Select - </option>

									</select>
								</div>
						</div> 
 

							 
					 
				                 
                  </li>
				  <li class="done">
						  <div class="form-group row">
							<label for="inputEmail3" class="col-sm-3 col-form-label">											
								<input type="checkbox" value="" name="todo2" id="todoCheck2" checked="">     	
							Firmware  <i class="fa fa-eye"></i> </label>
								<div class="col-sm-9">												   
									<select  class="js-example-basic-single col-sm-12 " name="cmbrepli_firm" id="cmbrepli_firm" required="" oninvalid="setCustomValidity('  is required.')" oninput="setCustomValidity('')">
									<option value=""> - Select - </option>

									</select>
								</div>
						</div> 
			     </li>
				  <li class="done">
					  <div class="form-group row">
						  <label for="inputEmail3" class="col-sm-3 col-form-label">											
						<input type="checkbox" value="" name="todo2" id="todoCheck2" checked="">     	
						Routines Product  <i class="fa fa-eye"></i> </label>
							<div class="col-sm-9">												   
								<select class="js-example-basic-single col-sm-12 " name="cmbrepli_routine" id="cmbrepli_routine" required="" oninvalid="setCustomValidity('  is required.')" oninput="setCustomValidity('')">
								<option value=""> - Select - </option>

								</select>
							</div>
					</div> 
			     </li>
				  <li class="done">

				  <div class="form-group row">
					  <label for="inputEmail3" class="col-sm-3 col-form-label">											
						<input type="checkbox" value="" name="todo2" id="todoCheck2" checked="">     	
						Script Setup  <i class="fa fa-eye"></i> </label>
							<div class="col-sm-9">												   
								<select  class="js-example-basic-single col-sm-12 " name="cmbrepli_scriptsetup" id="cmbrepli_scriptsetup" required="" oninvalid="setCustomValidity('  is required.')" oninput="setCustomValidity('')">
								<option value=""> - Select - </option>

								</select>
							</div>
					</div> 
			     </li>
				  <li class="done">
					  <div class="form-group row">
						  <label for="inputEmail3" class="col-sm-3 col-form-label">											
						<input type="checkbox" value="" name="todo2" id="todoCheck2" checked="">     	
						Attibutes  <i class="fa fa-eye"></i> </label>
							<div class="col-sm-9">												   
								<select class="js-example-basic-single col-sm-12" name="cmbrepli_attribute" id="cmbrepli_attribute" required="" oninvalid="setCustomValidity('  is required.')" oninput="setCustomValidity('')">
								<option value=""> - Select - </option>

								</select>
							</div>
					</div> 

				              
                  </li>
				  <li class="done">
					  <div class="form-group row">
						  <label for="inputEmail3" class="col-sm-3 col-form-label">											
						<input type="checkbox" value="" name="todo2" id="todoCheck2" checked="">     	
						Tree Product   <i class="fa fa-eye"></i> </label>
							<div class="col-sm-9">												   
								<select class="js-example-basic-single col-sm-12 " name="cmbrepli_tree" id="cmbrepli_tree" required="" oninvalid="setCustomValidity('  is required.')" oninput="setCustomValidity('')">
								<option value=""> - Select - </option>

								</select>
							</div>
					</div> 

			    </li>
				  <li class="done">
				  <div class="form-group row">
						
						<label for="inputEmail3" class="col-sm-3 col-form-label">											
						<input type="checkbox" value="" name="todo2" id="todoCheck2" checked="">     	
						Label Print   <i class="fa fa-eye"></i> </label>
							<div class="col-sm-9">												   
								<select  class="js-example-basic-single col-sm-12 " name="cmbrepli_lblprint" id="cmbrepli_lblprint" required="" oninvalid="setCustomValidity('  is required.')" oninput="setCustomValidity('')">
								<option value=""> - Select - </option>

								</select>
							</div>
					</div> 
				                
                  </li>
				  <li class="done">				

					<div class="form-group row">
						
						<label for="inputEmail3" class="col-sm-3 col-form-label">											
						<input type="checkbox" value="" name="todo2" id="todoCheck2" checked="">     	
						Measures   <i class="fa fa-eye"></i> </label> 
							<div class="col-sm-9">												   
								<select class="js-example-basic-single col-sm-12 " name="cmbrepli_measures" id="cmbrepli_measures" required="" oninvalid="setCustomValidity('  is required.')" oninput="setCustomValidity('')">
								<option value=""> - Select - </option>

								</select>
							</div>
					</div> 

                  </li>
               
                </ul>
              </div>

			  <hr>
			  <div class="form-group ">
				  
											<label>New description:</label>
													
													<textarea class="form-control form-controltamanio" rows="2" id="txtnewproddescr" name="txtnewproddescr" ></textarea>
										  </div>
													
										  </div>
										</div>
										
										<div class="col-sm-6">
										<hr>
										 <b>Information to Replicate</b>
										<br>
											<div class="container-fluid">


											<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">First</th>
      <th scope="col">Last</th>
      <th scope="col">Handle</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Jacob</td>
      <td>Thornton</td>
      <td>@fat</td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td>Larry</td>
      <td>the Bird</td>
      <td>@twitter</td>
    </tr>
  </tbody>
</table>

<table class="table">
  <thead class="thead-light">
    <tr>
      <th scope="col">#</th>
      <th scope="col">First</th>
      <th scope="col">Last</th>
      <th scope="col">Handle</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Jacob</td>
      <td>Thornton</td>
      <td>@fat</td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td>Larry</td>
      <td>the Bird</td>
      <td>@twitter</td>
    </tr>
  </tbody>
</table>

											</div>
											
										</div>
									
                    <br>
                    <hr>
                    <div class="col-sm-12">
							<div class="card-footer text-right">
							
								  <button type="button" onclick="save_new_registro_ciu()" name="btnfin" id="btnfin" class="btn btn-primary btn-block right-align">Create New Unit</button>
								  
								  
								</div>
						</div>
					

          <!-- /. finmostramos si existe CIU-->
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

                  $('.js-example-basic-single').select2();		


                  	 // AutoComplete de CUIS version TOP

     


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


     $('#txtlistcius').select2({
			ajax: {
				url: "ajax_list_cuisbyaddciu.php",
				dataType: 'json',
				delay: 2,
				data: function (params) {
				return {
					q: params.term, // search term
					page: params.page
				};
				},
				processResults: function (data) {
				// Transforms the top-level key of the response object from 'items' to 'results'
				return {
					results: data.items
				};    
				},
				cache: false
			},
			placeholder: 'Search CIU',
			minimumInputLength: 1 ,
			templateResult: formatRepo,
			templateSelection: formatRepoSelection
			});

// fin// AutoComplete de CUIS version TOP	

/// objabdn ////
$('#cmbrepli_objband').select2({
			ajax: {
				url: "ajax_list_cuisbyaddciu.php",
				dataType: 'json',
				delay: 2,
				data: function (params) {
				return {
					q: params.term, // search term
					page: params.page
				};
				},
				processResults: function (data) {
				// Transforms the top-level key of the response object from 'items' to 'results'
				return {
					results: data.items
				};    
				},
				cache: false
			},
			placeholder: 'Search CIU',
			minimumInputLength: 1 ,
			templateResult: formatRepo,
			templateSelection: formatRepoSelection
			});
/// fin objban ///
///// cmbrepli_measures/////
$('#cmbrepli_measures').select2({
			ajax: {
				url: "ajax_list_cuisbyaddciu.php",
				dataType: 'json',
				delay: 2,
				data: function (params) {
				return {
					q: params.term, // search term
					page: params.page
				};
				},
				processResults: function (data) {
				// Transforms the top-level key of the response object from 'items' to 'results'
				return {
					results: data.items
				};    
				},
				cache: false
			},
			placeholder: 'Search CIU',
			minimumInputLength: 1 ,
			templateResult: formatRepo,
			templateSelection: formatRepoSelection
			});
///// fin cmbrepli_measures ////

/////////////////////////////////////////////////////
/////////////////////////////////////////////////////
$('#cmbrepli_routpro').select2({
			ajax: {
				url: "ajax_list_cuisbyaddciu.php",
				dataType: 'json',
				delay: 2,
				data: function (params) {
				return {
					q: params.term, // search term
					page: params.page
				};
				},
				processResults: function (data) {
				// Transforms the top-level key of the response object from 'items' to 'results'
				return {
					results: data.items
				};    
				},
				cache: false
			},
			placeholder: 'Search CIU',
			minimumInputLength: 1 ,
			templateResult: formatRepo,
			templateSelection: formatRepoSelection
			});
/////////////////////////////////////////////////////
/////////////////////////////////////////////////////
$('#cmbrepli_firm').select2({
			ajax: {
				url: "ajax_list_cuisbyaddciu.php",
				dataType: 'json',
				delay: 2,
				data: function (params) {
				return {
					q: params.term, // search term
					page: params.page
				};
				},
				processResults: function (data) {
				// Transforms the top-level key of the response object from 'items' to 'results'
				return {
					results: data.items
				};    
				},
				cache: false
			},
			placeholder: 'Search CIU',
			minimumInputLength: 1 ,
			templateResult: formatRepo,
			templateSelection: formatRepoSelection
			});
/////////////////////////////////////////////////////
/////////////////////////////////////////////////////
$('#cmbrepli_routine').select2({
			ajax: {
				url: "ajax_list_cuisbyaddciu.php",
				dataType: 'json',
				delay: 2,
				data: function (params) {
				return {
					q: params.term, // search term
					page: params.page
				};
				},
				processResults: function (data) {
				// Transforms the top-level key of the response object from 'items' to 'results'
				return {
					results: data.items
				};    
				},
				cache: false
			},
			placeholder: 'Search CIU',
			minimumInputLength: 1 ,
			templateResult: formatRepo,
			templateSelection: formatRepoSelection
			});
/////////////////////////////////////////////////////
/////////////////////////////////////////////////////
$('#cmbrepli_scriptsetup').select2({
			ajax: {
				url: "ajax_list_cuisbyaddciu.php",
				dataType: 'json',
				delay: 2,
				data: function (params) {
				return {
					q: params.term, // search term
					page: params.page
				};
				},
				processResults: function (data) {
				// Transforms the top-level key of the response object from 'items' to 'results'
				return {
					results: data.items
				};    
				},
				cache: false
			},
			placeholder: 'Search CIU',
			minimumInputLength: 1 ,
			templateResult: formatRepo,
			templateSelection: formatRepoSelection
			});
/////////////////////////////////////////////////////
/////////////////////////////////////////////////////
$('#cmbrepli_attribute').select2({
			ajax: {
				url: "ajax_list_cuisbyaddciu.php",
				dataType: 'json',
				delay: 2,
				data: function (params) {
				return {
					q: params.term, // search term
					page: params.page
				};
				},
				processResults: function (data) {
				// Transforms the top-level key of the response object from 'items' to 'results'
				return {
					results: data.items
				};    
				},
				cache: false
			},
			placeholder: 'Search CIU',
			minimumInputLength: 1 ,
			templateResult: formatRepo,
			templateSelection: formatRepoSelection
			});
/////////////////////////////////////////////////////
/////////////////////////////////////////////////////
$('#cmbrepli_tree').select2({
			ajax: {
				url: "ajax_list_cuisbyaddciu.php",
				dataType: 'json',
				delay: 2,
				data: function (params) {
				return {
					q: params.term, // search term
					page: params.page
				};
				},
				processResults: function (data) {
				// Transforms the top-level key of the response object from 'items' to 'results'
				return {
					results: data.items
				};    
				},
				cache: false
			},
			placeholder: 'Search CIU',
			minimumInputLength: 1 ,
			templateResult: formatRepo,
			templateSelection: formatRepoSelection
			});
/////////////////////////////////////////////////////
/////////////////////////////////////////////////////
$('#cmbrepli_lblprint').select2({
			ajax: {
				url: "ajax_list_cuisbyaddciu.php",
				dataType: 'json',
				delay: 2,
				data: function (params) {
				return {
					q: params.term, // search term
					page: params.page
				};
				},
				processResults: function (data) {
				// Transforms the top-level key of the response object from 'items' to 'results'
				return {
					results: data.items
				};    
				},
				cache: false
			},
			placeholder: 'Search CIU',
			minimumInputLength: 1 ,
			templateResult: formatRepo,
			templateSelection: formatRepoSelection
			});
/////////////////////////////////////////////////////
/////////////////////////////////////////////////////
$('#cmbrepli_lblprint').select2({
			ajax: {
				url: "ajax_list_cuisbyaddciu.php",
				dataType: 'json',
				delay: 2,
				data: function (params) {
				return {
					q: params.term, // search term
					page: params.page
				};
				},
				processResults: function (data) {
				// Transforms the top-level key of the response object from 'items' to 'results'
				return {
					results: data.items
				};    
				},
				cache: false
			},
			placeholder: 'Search CIU',
			minimumInputLength: 1 ,
			templateResult: formatRepo,
			templateSelection: formatRepoSelection
			});
/////////////////////////////////////////////////////
/////////////////////////////////////////////////////

/////////////////////////////////////////////////////
/////////////////////////////////////////////////////

			
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
		///	$("#ciuselectspan").html(datosmm[1]);
		 console.log('cargar nuevos combos aqui');
        

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
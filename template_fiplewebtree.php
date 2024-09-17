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
	
	
  <link rel="stylesheet" href="themestreecss/default/style.css">



  
  
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
   
    $tree_array_products = array();  
   
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
            <h1>Template web</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">template web</li>
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
			<div class="card">
			
			  <div class="container-fluid">
			    <b>TEST   Family Tree Products</b>
			
			
	<div class="well" id="treeview_json">
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
							  <li data-tag="1" id="aaaaaa-1"> <i class='fas fa-paperclip'></i> &nbsp;&nbsp;DH7S-A-733A </li>
							  <li data-tag="2" id="bbbbbb-1"> <i class='fas fa-paperclip'></i>&nbsp;&nbsp; MBC70-270-001</li>
							  <li data-tag="3" id="cccccc-1"> <i class='fas fa-paperclip'></i>&nbsp;&nbsp; PR45-4C-2</li>
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
                <h3 class="card-title"> <i class="fa fa-fw fa-list-alt"></i> Tree levels list</h3>
						

              
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0" style="display: block;">
                <div class="d-md-flex">
			    	 <div class="container-fluid">
					 <br>
					 <p class="text-primary">You must drag a level to the branch of the tree you want</p>
					 
							<div id="tagList">
							<ul>
							  <li data-tag="1" id="bdalegacy"> <i class='fas fa-paperclip'></i>&nbsp;&nbsp;BDA Legacy</li>
							  <li data-tag="2" id="passive"> <i class='fas fa-paperclip'></i>&nbsp;&nbsp;PASSIVE</li>
							  <li data-tag="3" id="bdaflex"> <i class='fas fa-paperclip'></i>&nbsp;&nbsp;BDA FLEX</li>
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


  var jsonTreeData = [{"id":"1","name":"Electronics","icon":"fa fa-inbox","text":"Electronics","parent_id":"0","children":[{"id":"2","name":"Mobile","text":"Mobile","icon":"fa fa-inbox","parent_id":"1","children":[{"id":"7","name":"Samsung","icon":"fa fa-inbox","text":"Samsung","parent_id":"2","children":[],"data":{},"a_attr":{"href":"google.com"}},{"id":"8","name":"Apple","text":"Apple","parent_id":"2","children":[],"data":{},"a_attr":{"href":"google.com"}}],"data":{},"a_attr":{"href":"google.com"}},{"id":"3","name":"Laptop","text":"Laptop","parent_id":"1","children":[{"id":"4","name":"Keyboard","text":"Keyboard","parent_id":"3","children":[],"data":{},"a_attr":{"href":"google.com"}},{"id":"5","name":"Computer Peripherals","text":"Computer Peripherals","parent_id":"3","children":[{"id":"6","name":"Printers","text":"Printers","parent_id":"5","children":[],"data":{},"a_attr":{"href":"google.com"}},{"id":"10","name":"Monitors","text":"Monitors","parent_id":"5","children":[],"data":{},"a_attr":{"href":"google.com"}}],"data":{},"a_attr":{"href":"google.com"}},{"id":"11","name":"Dell","text":"Dell","parent_id":"3","children":[],"data":{},"a_attr":{"href":"google.com"}}],"data":{},"a_attr":{"href":"google.com"}}],"data":{},"a_attr":{"href":"google.com"}}];
 
   
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
 
 	$.ajax({
				url: 'ajax_list_tree_products.php',			
				type: 'post',				
				datatype:'JSON',				
				cache:false,					
				success: function(data, status, xhr) {
					jsonTreeData= data ;
				
				
					$('#treeview_json').jstree({
							'core' : {
							'data' : jsonTreeData,
							'themes' : {      'variant' : 'large'}
							},
							"checkbox" : {
							"keep_selected_style" : false
							},
							"plugins" : [ "wholerow", "checkbox" ]
							
							
				
							});
					
					return false;	
				
				},
				error: function(xhr, status, error) {
					 console.log(status);
				}
				});
				
 

       
	   


	
/////////////////////////////////////////////////////
/*
$('#treeview_json')
  .jstree({
  core: {
    data: jsonTreeData
  },
  types: {
    "root": {
      "icon" : "far fa-folder-open"
    },
    "child": {
      "icon" : "fa fa-inboxf"
    },
    "default" : {
    }
  },
  plugins: ["search", "themes", "types"]
}).on('open_node.jstree', function (e, data) { data.instance.set_icon(data.node, "fas fa-minus-circle"); 
}).on('close_node.jstree', function (e, data) { data.instance.set_icon(data.node, "fas fa-plus-circle"); 
}).bind('loaded.jstree"', function (e, data) { data.instance.set_icon(data.node, "fa fa-inbox"); 

});
*/

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
 $('#tree').jstree({
    core: {
      check_callback: true,
      data: exData
    },
    types: {
      root: {
        icon: "fa fa-globe-o"
      }
    },
    plugins: ["core", "html_data", "themes", "ui","dnd"]
	
	
  });
  
 $(document).on('dnd_stop.vakata', function (e, data) {
       console.log('dnd_stop.vakata');
	//   console.log(data);
	   // console.log("Drop node " + data.element.id + " to " + data.parent);
	       ref = $('#tree').jstree(true);
		parents = ref.get_node(data.element).parent;
	
	   console.log('Agrego el Elemeto:'+ data.element.id+ ' a la rama de:' + parents);
	   if(parents !=  'undefined')
	   {
		   console.log('oculto:'+ data.element.id );
	//	$('#'+data.element.id).addClass('d-none');
	   }
});
  

  
  
  
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
      var idRoot = $(this).attr("id").slice(0, -2);
      var newId = idRoot + "-" + ($("#tree [id|='" + idRoot + "'][class*='jstree-node']").length + 1);
      return $.vakata.dnd.start(e, {
        jstree: true,
        obj: makeTreeItem(this),
        nodes: [{
          id: newId,
          text: $(this).text(),
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
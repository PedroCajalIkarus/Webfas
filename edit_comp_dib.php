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
	
	$status = $connect->getAttribute(PDO::ATTR_CONNECTION_STATUS);
	
	if ($status !="Connection OK; waiting to send.")
	{
	
		header("Location: http://".$ipservidorapache."/".$folderservidor."/errorconect.php");
		exit;
		
	}
?>
<html lang="en">
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
	<link rel="stylesheet" href="cssfiplexautocomplete.css">
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
            <h1>Components DigitalBoard </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home.php">Home</a></li>
              <li class="breadcrumb-item active"> <a href="edit_comp_dib.php"> Components DigitalBoard </a></li>
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

            <div class="" name="divscrolllog" id="divscrolllog" style="display.">
			<p name="msjwaitline" id="msjwaitline" align="center"><img src="img/waitazul.gif" width="100px" ></p>	
				<div class="card" >
				
				<!-- inicio tabla add labeling -->
				<div id="tableladdrow" class="d-none form-group ">		
			
			
			
					<div class="card ">
					  <div class="card-header bg-info">
						<h3 class="card-title ">Create New Components DIB</h3>

						
						<!-- /.card-tools -->
					  </div>
					  <!-- /.card-header -->
					  <div class="card-body">
								<form name="frmlabeling" id="frmlabeling" action="" method="post"  class="form-horizontal needs-validation"  >							
				
							  
								</div>
								<!-- /.card-body -->
								<div class="card-footer text-right">
								  <button type="submit" onclick="save_new_registro()" class="btn btn-primary right-align">Create New Components</button>
								</div>
									<p class="text-danger" id="lbldatoserrr" id="lbldatoserrr">
			
									</p>
								</form>			
					  </div>
					  <!-- /.card-body -->
					</div>
			
			
			 
	
				<!-- fin tabla add labeling -->
			
					<div class="card" id="tablelabelingcabe" >
						<div class="row">						
							  <div class="col-3">
								<button name="lbladdbtn" id="lbladdbtn" type="button" class="btn btn-success btn-sm float-left" onclick="nuevo_registro();" ><i class="fas fa-plus-square" ></i> Add Components</button> &nbsp;&nbsp;
							  <button name="lbleditbtn2" id="lbleditbtn2" type="button" class="btn btn-info btn-sm " onclick="cambiar_a_modo_edit(0);" ><i class="fas fa-pencil-alt" ></i> Enter Edit Mode</button>
							  </div>						 
						 </div>
				
						<div name="lbleditdiv" id="lbleditdiv" class="alert alert-warning alert-dismissible d-none" >
						  
						  <h5><i class="icon fas fa-exclamation-triangle"></i> Edit Mode!</h5>                  
						</div>						
						
					</div>	
					<div id="tablelabeling">
					
						
					
					
					</div>
				
			
				
			
		
				</div>
					<span>Reference:	</span>
					 
					  <span class="badge" style="background-color:#ffcccc;" >Components Inactive</span>
					   <span class="badge" style="background-color:#FF6565;">Components Deleted </span>
							
							
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

</body>

<script type="text/javascript">

var allcuis="";

function autocomplete(inp, arr) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
      for (i = 0; i < arr.length; i++) {
        /*check if the item starts with the same letters as the text field value:*/
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
          /*make the matching letters bold:*/
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          /*execute a function when someone clicks on the item value (DIV element):*/
              b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value;
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
          });
          a.appendChild(b);
        }
      }
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
      x[i].parentNode.removeChild(x[i]);
    }
  }
}
/*execute a function when someone clicks in the document:*/
document.addEventListener("click", function (e) {
    closeAllLists(e.target);
});
}


var dateEditor = function(cell, onRendered, success, cancel){
    //cell - the cell component for the editable cell
    //onRendered - function to call when the editor has been rendered
    //success - function to call to pass the successfuly updated value to Tabulator
    //cancel - function to call to abort the edit and return to a normal cell

    //create and style input
    var cellValue = moment(cell.getValue(), "DD/MM/YYYY").format("YYYY-MM-DD"),
    input = document.createElement("input");

    input.setAttribute("type", "date");

    input.style.padding = "4px";
    input.style.width = "100%";
    input.style.boxSizing = "border-box";

    input.value = cellValue;

    onRendered(function(){
        input.focus();
        input.style.height = "100%";
    });

    function onChange(){
		console.log('a vercambio');
        if(input.value != cellValue){
            success(moment(input.value, "YYYY-MM-DD").format("DD/MM/YYYY"));
			console.log('cambio');
        }else{
            cancel();
			console.log(' no cambio');
        }
    }

    //submit new value on blur or change
    input.addEventListener("blur", onChange);

    //submit new value on enter
    input.addEventListener("keydown", function(e){
        if(e.keyCode == 13){
            onChange();
			
        }

        if(e.keyCode == 27){
            cancel();
			console.log('cancelado');
        }
    });

    return input;
};
   
   
   
	$( document ).ready(function() {
		
		//Inicio mostrar hora live
		 var interval = setInterval(function() {
		
		
        var momentNow = moment();
		var newYork    = momentNow.tz('America/New_York').format('ha z');
        $('#date-part').html(momentNow.format('YYYY/MM/DD') 	  );
        $('#time-part').html(momentNow.format('hh:mm:ss'));
		}, 100);
		
			if ($(window).height()>640)
			{
				var altor=  $(window).height() - 200+'px';
			}
			else
			{
				var altor=  "560px";
			}
			
		//FIN mostrar hora live
			console.log( "ready!" );
			$('#msjwaitline').hide();
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
			
			tabla_list();	
			
	});
	
	function cambiar_a_modo_edit(tipoedicion )
	{
		
			tabla_editor(tipoedicion);
	}
	
	
	function save_new_registro( )
	{
		
		////Controlamos campos vacios
		if ($('#txtciu')[0].checkValidity() == false)
		{
			return false;
		}	
		if ($('#txtupwr')[0].checkValidity() == false)
		{
			return false;
		}	
		if ($('#txtmadeinusa')[0].checkValidity() == false)
		{
			return false;
		}	
		if ($('#txtflia')[0].checkValidity() == false)
		{
			return false;
		}
		if ($('#txtfcc')[0].checkValidity() == false)
		{
			return false;
		}	
		if ($('#txtic')[0].checkValidity() == false)
		{
			return false;
		}
		if ($('#txtetsi')[0].checkValidity() == false)
		{
			return false;
		}			
				
		
		
		$('#lbldatoserrr').html("");
		 var v_txtciu = $('#txtciu').val();
		 var v_txtupwr = $('#txtupwr').val();
		 var v_txtmadeinusa = $('#txtmadeinusa').val();
		 var v_txtflia = $('#txtflia').val();
		 var v_txtfcc = $('#txtfcc').val();
		 var v_txtic = $('#txtic').val();
		 var v_txtetsi = $('#txtetsi').val();
					
		toastr["success"]("processing information..", "");	
		
				$.ajax({
				url: 'ajax_createnew_ciulabeling.php', 				
				data: "v_txtciu="+v_txtciu+'&v_txtupwr='+v_txtupwr+'&v_txtmadeinusa='+v_txtmadeinusa+'&v_txtflia='+v_txtflia+'&v_txtfcc='+v_txtfcc+'&v_txtic='+v_txtic+'&v_txtetsi='+v_txtetsi,	
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
					
					}
					else	
					{
						toastr["error"]("Error when storing data...", "");	
						
						$('#lbldatoserrr').html("ERROR: <br>"+resulterr);
					}
						
				
				},
				error: function(xhr, status, error) {
					 console.log(status);
				}
				});
	
			
				
	}
	
	function nuevo_registro( )
	{
	
			$.ajax({
				url: 'ajax_list_ciulabeling.php', 
				dataType: 'json',				
				success: function(data, status, xhr) {
					var allcuis = data.ciu;
					autocomplete(document.getElementById("txtciu"), allcuis);
						var allulpwrrat = data.ulpwrrat;
					autocomplete(document.getElementById("txtupwr"), allulpwrrat);
					var allmadein = data.madein;
					autocomplete(document.getElementById("txtmadeinusa"), allmadein);
					var allfliat = data.flia;
					autocomplete(document.getElementById("txtflia"), allfliat);
					var allfcc = data.fcc;
					autocomplete(document.getElementById("txtfcc"), allfcc);
					var allic = data.ic;
					autocomplete(document.getElementById("txtic"), allic);
					var alletsi = data.etsi;
					autocomplete(document.getElementById("txtetsi"), alletsi);
				
				},
				error: function(xhr, status, error) {
					 console.log(status);
				}
				});
		
				//$("#tablelabeling").addClass('d-none');
					$("#lbladdbtn").addClass('d-none');
				$("#tableladdrow").removeClass('d-none');
				
	}
	
	function tabla_editor(tipoedicion)
	{
		
		
		
	    	$("#lbleditbtn").addClass('d-none');
		//	$("#lbladdbtn").addClass('d-none');
			
			$("#tableladdrow").addClass('d-none');
			
			
			$("#lbleditdiv").removeClass('d-none');	
			toastr["warning"]("Wait....Change to Edit Mode", "Attention");		
			
			$("#tablelabeling").removeClass('d-none');
			$("#lbladdbtn").removeClass('d-none');
						
		
		var table = new Tabulator("#tablelabeling", {													
					ajaxURL:"getdata_comp_dib.php",
					ajaxProgressiveLoad:"scroll",										
					paginationSize:200,
					placeholder:"No Data Set",	
					ajaxProgressiveLoad:"scroll",	
					clipboard : true , 
					clipboardPasteAction : "replace" , 					
					height:"500px",
					layout:"fitColumns",  
						 rowFormatter:function(row){
								if(row.getData().active.toLowerCase()  == "no"){
									console.log ("aaaa" + row.getData().active);
									row.getElement().style.backgroundColor = "#ffcccc";
								}
								if(row.getData().active.toLowerCase()  == "erase"){
								
									row.getElement().style.backgroundColor = "#FF6565";
								}
							},
					columns:[										     
							{title:"Name", field:"namedib", sorter:"string" ,headerFilter:"input",editor:"autocomplete", editorParams:{ showListOnEmpty:true,freetext:true, 
																						listItemFormatter:function(value, title){ //prefix all titles with the work "Mr"
																							return "" + title;
																						},
																						values:true, //create list of values from all values contained in this column
																					},  
								cellEdited :function(datofila)
								{
									//data - the updated table data				
							    	console.log(datofila);	
								    console.log(datofila._cell.column.definition.field);
									console.log(' dato value:'+datofila._cell.value+' idregistro:'+datofila._cell.row.data.idcompdib);	

									/// Pregu si es nuevo o modif
									
										$.ajax({
											
											url: 'ajax_update_compdib.php',
											data: "idcompdib="+datofila._cell.row.data.idcompdib+'&lblname='+datofila._cell.column.definition.field+'&dataso='+datofila._cell.value,	
											type: 'post',				
											datatype:'JSON',				
										    cache:false,											
											success: function(respuesta) {
												toastr["success"]("Save!", "");	
											//	tabla_editor();																																																												
											},
											error: function() {
												console.log("Error...UPDATE");
											}
										});
									
										
									
									
								},
							},									
							{title:"Description", field:"descriptiondib", sorter:"string", headerFilter:"input",editor:"autocomplete", editorParams:{ showListOnEmpty:true,freetext:true, 
																						listItemFormatter:function(value, title){ //prefix all titles with the work "Mr"
																							return "" + title;
																						},
																						values:true, //create list of values from all values contained in this column
																					},  
								cellEdited :function(datofila)
								{
									//data - the updated table data				
							    	console.log(datofila);	
								    console.log(datofila._cell.column.definition.field);
									console.log(' dato value:'+datofila._cell.value+' idregistro:'+datofila._cell.row.data.idcompdib);	

									/// Pregu si es nuevo o modif
									
										$.ajax({
											
											url: 'ajax_update_compdib.php',
											data: "idcompdib="+datofila._cell.row.data.idcompdib+'&lblname='+datofila._cell.column.definition.field+'&dataso='+datofila._cell.value,	
											type: 'post',				
											datatype:'JSON',				
										    cache:false,											
											success: function(respuesta) {
												toastr["success"]("Save!", "");	
												//tabla_editor();																																																																								
											},
											error: function() {
												console.log("Error...UPDATE");
											}
										});
									
										
									
									
								},
							},			
							{title:"Gain UL", field:"gainul", sorter:"string",  headerFilter:"input" ,editor:"autocomplete", editorParams:{ showListOnEmpty:true,freetext:true, 
																						listItemFormatter:function(value, title){ //prefix all titles with the work "Mr"
																							return "" + title;
																						},
																						values:true, //create list of values from all values contained in this column
																					},  
								cellEdited :function(datofila)
								{
									//data - the updated table data				
							    	console.log(datofila);	
								    console.log(datofila._cell.column.definition.field);
									console.log(' dato value:'+datofila._cell.value+' idregistro:'+datofila._cell.row.data.idcompdib);	

									/// Pregu si es nuevo o modif
									
										$.ajax({
											
											url: 'ajax_update_compdib.php',
											data: "idcompdib="+datofila._cell.row.data.idcompdib+'&lblname='+datofila._cell.column.definition.field+'&dataso='+datofila._cell.value,	
											type: 'post',				
											datatype:'JSON',				
										    cache:false,											
											success: function(respuesta) {
												toastr["success"]("Save!", "");	
											//	tabla_editor();																																																																							
											},
											error: function() {
												console.log("Error...UPDATE");
											}
										});
									
										
									
									
								},
							},			
							{title:"Gain DL", field:"gaindl", sorter:"string",  headerFilter:"input" ,editor:"autocomplete", editorParams:{ showListOnEmpty:true,freetext:true, 
																						listItemFormatter:function(value, title){ //prefix all titles with the work "Mr"
																							return "" + title;
																						},
																						values:true, //create list of values from all values contained in this column
																					},  
								cellEdited :function(datofila)
								{
									//data - the updated table data				
							    	console.log(datofila);	
								    console.log(datofila._cell.column.definition.field);
									console.log(' dato value:'+datofila._cell.value+' idregistro:'+datofila._cell.row.data.idcompdib);	

									/// Pregu si es nuevo o modif
									
										$.ajax({
											
											url: 'ajax_update_compdib.php',
											data: "idcompdib="+datofila._cell.row.data.idcompdib+'&lblname='+datofila._cell.column.definition.field+'&dataso='+datofila._cell.value,	
											type: 'post',				
											datatype:'JSON',				
										    cache:false,											
											success: function(respuesta) {
												toastr["success"]("Save!", "");	
											tabla_editor();																																																																							
											},
											error: function() {
												console.log("Error...UPDATE");
											}
										});
									
										
									
									
								},
							},															
							{title:"Gain Tolerance", field:"gaintolerance", sorter:"string",  headerFilter:"input",editor:"autocomplete", editorParams:{ showListOnEmpty:true,freetext:true, 
																						listItemFormatter:function(value, title){ //prefix all titles with the work "Mr"
																							return "" + title;
																						},
																						values:true, //create list of values from all values contained in this column
																					},  
								cellEdited :function(datofila)
								{
									//data - the updated table data				
							    	console.log(datofila);	
								    console.log(datofila._cell.column.definition.field);
									console.log(' dato value:'+datofila._cell.value+' idregistro:'+datofila._cell.row.data.idcompdib);	

									/// Pregu si es nuevo o modif
									
										$.ajax({
											
											url: 'ajax_update_compdib.php',
											data: "idcompdib="+datofila._cell.row.data.idcompdib+'&lblname='+datofila._cell.column.definition.field+'&dataso='+datofila._cell.value,	
											type: 'post',				
											datatype:'JSON',				
										    cache:false,											
											success: function(respuesta) {
												toastr["success"]("Save!", "");	
												tabla_editor();																																																																								
											},
											error: function() {
												console.log("Error...UPDATE");
											}
										});
									
										
									
									
								},
							},			
							{title:"Max Pwr UL", field:"maxpwrul", sorter:"string",  headerFilter:"input",editor:"autocomplete", editorParams:{ showListOnEmpty:true,freetext:true, 
																						listItemFormatter:function(value, title){ //prefix all titles with the work "Mr"
																							return "" + title;
																						},
																						values:true, //create list of values from all values contained in this column
																					},  
								cellEdited :function(datofila)
								{
									//data - the updated table data				
							    	console.log(datofila);	
								    console.log(datofila._cell.column.definition.field);
									console.log(' dato value:'+datofila._cell.value+' idregistro:'+datofila._cell.row.data.idcompdib);	

									/// Pregu si es nuevo o modif
									
										$.ajax({
											
											url: 'ajax_update_compdib.php',
											data: "idcompdib="+datofila._cell.row.data.idcompdib+'&lblname='+datofila._cell.column.definition.field+'&dataso='+datofila._cell.value,	
											type: 'post',				
											datatype:'JSON',				
										    cache:false,											
											success: function(respuesta) {
												toastr["success"]("Save!", "");	
												tabla_editor();																																																																							
											},
											error: function() {
												console.log("Error...UPDATE");
											}
										});
									
										
									
									
								},
							},			
							{title:"Max Pwr DL", field:"maxpwrdl", sorter:"string",  headerFilter:"input",editor:"autocomplete", editorParams:{ showListOnEmpty:true,freetext:true, 
																						listItemFormatter:function(value, title){ //prefix all titles with the work "Mr"
																							return "" + title;
																						},
																						values:true, //create list of values from all values contained in this column
																					},  
								cellEdited :function(datofila)
								{
									//data - the updated table data				
							    	console.log(datofila);	
								    console.log(datofila._cell.column.definition.field);
									console.log(' dato value:'+datofila._cell.value+' idregistro:'+datofila._cell.row.data.idcompdib);	

									/// Pregu si es nuevo o modif
									
										$.ajax({
											
											url: 'ajax_update_compdib.php',
											data: "idcompdib="+datofila._cell.row.data.idcompdib+'&lblname='+datofila._cell.column.definition.field+'&dataso='+datofila._cell.value,	
											type: 'post',				
											datatype:'JSON',				
										    cache:false,											
											success: function(respuesta) {
												toastr["success"]("Save!", "");	
												tabla_editor();																																																																							
											},
											error: function() {
												console.log("Error...UPDATE");
											}
										});
									
										
									
									
								},
							},			
							{title:"Max Riple", field:"maxriple", sorter:"string",  headerFilter:"input",editor:"autocomplete", editorParams:{ showListOnEmpty:true,freetext:true, 
																						listItemFormatter:function(value, title){ //prefix all titles with the work "Mr"
																							return "" + title;
																						},
																						values:true, //create list of values from all values contained in this column
																					},  
								cellEdited :function(datofila)
								{
									//data - the updated table data				
							    	console.log(datofila);	
								    console.log(datofila._cell.column.definition.field);
									console.log(' dato value:'+datofila._cell.value+' idregistro:'+datofila._cell.row.data.idcompdib);	

									/// Pregu si es nuevo o modif
									
										$.ajax({
											
											url: 'ajax_update_compdib.php',
											data: "idcompdib="+datofila._cell.row.data.idcompdib+'&lblname='+datofila._cell.column.definition.field+'&dataso='+datofila._cell.value,	
											type: 'post',				
											datatype:'JSON',				
										    cache:false,											
											success: function(respuesta) {
												toastr["success"]("Save!", "");		
												tabla_editor();																																																																							
											},
											error: function() {
												console.log("Error...UPDATE");
											}
										});
									
										
									
									
								},
							},	
							{title:"idcompdib", field:"idcompdib", headerFilter:"input",visible:true,sorter:"number"  },	
							{title:"Acceptance Calr", field:"acceptance", headerFilter:"input",visible:true,editor:"autocomplete", editorParams:{ showListOnEmpty:true,freetext:true, 
																						listItemFormatter:function(value, title){ //prefix all titles with the work "Mr"
																							return "" + title;
																						},
																						values:false, //create list of values from all values contained in this column
																					},  
								cellEdited :function(datofila)
								{
									//data - the updated table data				
							    	console.log(datofila);	
								    console.log(datofila._cell.column.definition.field);
									console.log(' dato value:'+datofila._cell.value+' idregistro:'+datofila._cell.row.data.idcompdib);	

									/// Pregu si es nuevo o modif
									
										$.ajax({
											
											url: 'ajax_update_compdib.php',
											data: "idcompdib="+datofila._cell.row.data.idcompdib+'&lblname='+datofila._cell.column.definition.field+'&dataso='+datofila._cell.value,	
											type: 'post',				
											datatype:'JSON',				
										    cache:false,											
											success: function(respuesta) {
												toastr["success"]("Save!", "");	
												tabla_editor();																																															
											},
											error: function() {
												console.log("Error...UPDATE");
											}
										});
									
										
									
									
								},
							},										
							{title:"Active ", field:"active", sorter:"string",  headerFilter:"input",editor:"autocomplete", editorParams:{ showListOnEmpty:true,freetext:true, 
																						listItemFormatter:function(value, title){ //prefix all titles with the work "Mr"
																							return "" + title;
																						},
																						values:true, //create list of values from all values contained in this column
																					},  
								cellEdited :function(datofila)
								{
									//data - the updated table data				
							    	console.log(datofila);	
								    console.log(datofila._cell.column.definition.field);
									console.log(' dato value:'+datofila._cell.value+' idregistro:'+datofila._cell.row.data.idcompdib);	

									/// Pregu si es nuevo o modif
									
										$.ajax({
											
											url: 'ajax_update_compdib.php',
											data: "idcompdib="+datofila._cell.row.data.idcompdib+'&lblname='+datofila._cell.column.definition.field+'&dataso='+datofila._cell.value,	
											type: 'post',				
											datatype:'JSON',				
										    cache:false,											
											success: function(respuesta) {
												toastr["success"]("Save!", "");		
												tabla_editor();																																				
											},
											error: function() {
												console.log("Error...UPDATE");
											}
										});
									
										
									
									
								},
							},			
					]						
					});
		
	}
	
	function tabla_list()
	{
			$("#tablelabeling").removeClass('d-none');
			$("#tablelabelingcabe").removeClass('d-none');
			$("#tableladdrow").addClass('d-none');
			
			
		var table = new Tabulator("#tablelabeling", {													
					ajaxURL:"getdata_comp_dib.php",
					ajaxProgressiveLoad:"scroll",										
					paginationSize:200,
					placeholder:"No Data Set",	
					ajaxProgressiveLoad:"scroll",		
					height:"500px",
					layout:"fitColumns",  
						 rowFormatter:function(row){
								if(row.getData().active.toLowerCase()  == "no"){
									console.log ("aaaa" + row.getData().active);
									row.getElement().style.backgroundColor = "#ffcccc";
								}
								if(row.getData().active.toLowerCase()  == "erase"){
								
									row.getElement().style.backgroundColor = "#FF6565";
								}
							},
					columns:[										     
							{title:"Name", field:"namedib", sorter:"string" ,headerFilter:"input",editor:false},							
							{title:"Description", field:"descriptiondib", sorter:"string", headerFilter:"input",editor:false	 },
							{title:"Gain UL", field:"gainul", sorter:"string",  headerFilter:"input" ,editor:false},
							{title:"Gain DL", field:"gaindl", sorter:"string",  headerFilter:"input" ,editor:false	},													
							{title:"Gain Tolerance", field:"gaintolerance", sorter:"string",  headerFilter:"input",editor:false },
							{title:"Max Pwr UL", field:"maxpwrul", sorter:"string",  headerFilter:"input",editor:false},
							{title:"Max Pwr DL", field:"maxpwrdl", sorter:"string",  headerFilter:"input",editor:false},
							{title:"Max Riple", field:"maxriple", sorter:"string",  headerFilter:"input",editor:false },
							{title:"Rev", field:"idcompdib2", headerFilter:"input",visible:true,sorter:"number"  },	
							{title:"Acceptance Calr", field:"acceptance", headerFilter:"input",visible:true,sorter:"string"  },	
							{title:"Active ", field:"active", sorter:"string",  headerFilter:"input",editor:false },
					]						
					});
				
	}

	// controlar inactividad en la web	
		$(document).inactivityTimeout({
                inactivityWait: 10000,
                dialogWait: 10,
                logoutUrl: 'logout.php'
            })
	// fin controlar inactividad en la web		
	
	 /* requesting data */
     		
		
	  
   
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
   
</script>

</html>

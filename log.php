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
	

?>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIPLEX - LOG</title>
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
            <h1>Activity Log</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Activity Log</li>
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
		  
	  <!-- inicio box search marco -->
		  	
			
		
            <!-- The time line -->
            <div class="" name="divscrolllog" id="divscrolllog" style="display.">
			<p name="msjwaitline" id="msjwaitline" align="center"><img src="img/waitazul.gif" width="100px" ></p>
			
            	
			  <?php		  
					try{   
						// Sacar todos los resultados de la base de datos
						//echo $elwhere;
						?>
					
			 <div id="example-table" class="example-table-theme-bootstrap4"></div>
			 
						<?php
 
					}catch(PDOException $e){
						echo "ERROR: " . $e->getMessage();
					}
				?>     
             
			 
			
			 
           
            </div>
		
			

        </section>
		<section class="col-lg-6 connectedSortable ui-sortable">
		

				<div class="card">
				<div class="card-header ui-sortable-handle" style="cursor: move;">
               		
				<div class="card">
              <div class="card-header">
                <h3 class="card-title"> <i class="fa fa-fw fa-list-alt"></i>Log Details :: </h3>
							<i class="fa fa-fw fa-user"></i> <label  name="lblvuser" id="lblvuser"> </label>
							<i class="fa fa-fw fa-tv"></i> <label  name="lblvdevice" id="lblvdevice"> </label>
							<i class="fa fa-fw fa-inbox"></i> <label  name="lblvstationr" id="lblvstationr"> </label>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0" style="display: block;">
                <div class="d-md-flex">
                  <div class="p-1 flex-fill" style="overflow: hidden" >
                    <textarea class="form-control form-controltamanio" rows="18" id="detallelog" name="detallelog"></textarea>
					<p name="detallelog1" id="detallelog1" ></p>						
					<p name="msjwait" id="msjwait" align="center"><img src="img/waitazul.gif" width="100px" ></p>						
                  </div>
              
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


<script type="text/javascript" src="js/tabulator.min.js"></script>

</body>

<script type="text/javascript">

   
   
	$( document ).ready(function() {
		
		
		 var interval = setInterval(function() {
			 
        var momentNow = moment();
		var newYork    = momentNow.tz('America/New_York').format('ha z');
        $('#date-part').html(momentNow.format('YYYY/MM/DD') 	  );
        $('#time-part').html(momentNow.format('hh:mm:ss'));
    }, 100);
	
			console.log( "ready!" );
			$('#msjwaitline ').hide();
			$('#divscrolllog').show(); 
			$('#p-b0').hide();
			$('#p-b0').CardWidget('toggle');
		//	console.log( " FIN ready!" );
		
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
				
		
				
					
					$('#datesearch').daterangepicker({
						"startDate":  moment().subtract(10, 'days'),
						"endDate":  moment().subtract(0, 'days')
					}, function(start, end, label) {
					  console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
					});
										
									
		////aca vamos a probar el tablulator
		
			//Custom filter example
					//Custom filter example
					//custom max min header filter
					var minMaxFilterEditor = function(cell, onRendered, success, cancel, editorParams){

						var end;

						var container = document.createElement("span");

						//create and style inputs
						var start = document.createElement("input");
						start.setAttribute("type", "number");
						start.setAttribute("placeholder", "Min");
						start.setAttribute("min", 0);
						start.setAttribute("max", 100);
						start.style.padding = "4px";
						start.style.width = "50%";
						start.style.boxSizing = "border-box";

						start.value = cell.getValue();

						function buildValues(){
							success({
								start:start.value,
								end:end.value,
							});
						}

						function keypress(e){
							if(e.keyCode == 13){
								buildValues();
							}

							if(e.keyCode == 27){
								cancel();
							}
						}

						end = start.cloneNode();
						end.setAttribute("placeholder", "Max");

						start.addEventListener("change", buildValues);
						start.addEventListener("blur", buildValues);
						start.addEventListener("keydown", keypress);

						end.addEventListener("change", buildValues);
						end.addEventListener("blur", buildValues);
						end.addEventListener("keydown", keypress);


						container.appendChild(start);
						container.appendChild(end);

						return container;
					 }

					//custom max min filter function
					function minMaxFilterFunction(headerValue, rowValue, rowData, filterParams){
						//headerValue - the value of the header filter element
						//rowValue - the value of the column in this row
						//rowData - the data for the row being filtered
						//filterParams - params object passed to the headerFilterFuncParams property

							if(rowValue){
								if(headerValue.start != ""){
									if(headerValue.end != ""){
										return rowValue >= headerValue.start && rowValue <= headerValue.end;
									}else{
										return rowValue >= headerValue.start;
									}
								}else{
									if(headerValue.end != ""){
										return rowValue <= headerValue.end;
									}
								}
							}

						return false; //must return a boolean, true if it passes the filter.
					}

					
			if ($(window).height()>640)
			{
				var altor=  $(window).height() - 200+'px';
			}
			else
			{
				var altor=  "560px";
			}
			
		    var vv_userruninfo="";
			var vv_station ="";
			var table = new Tabulator("#example-table", {
					height:altor,
					layout:"fitColumns",									
					ajaxURL:"getruninfojsontabultor.php",
					ajaxProgressiveLoad:"scroll",					
					selectable:1,
					selectableRollingSelection:true,
					 selectablePersistence:false,
					paginationSize:20,
					placeholder:"No Data Set",					
					columns:[
					     
							{title:" <i class='fa fa-fw fa-calendar'></i> Date", field:"fechacorta", sorter:"date", width:150,headerFilter:"input"},							
							{title:" <i class='fa fa-fw fa-user'></i> User", field:"userruninfo", sorter:"string", width:100, headerFilter:"input" },
							{title:" <i class='fa fa-fw fa-tv'></i>  Station", field:"station", sorter:"string", width:110 ,headerFilter:"input" },
							{title:" <i class='fa fa-fw fa-cog'></i> Script", field:"script", sorter:"string", width:120, headerFilter:"input" ,
							formatter:function(cell, formatterParams){
							var vj_scriptn = cell.getValue();
							///if(value.indexOf("") > 0){
								if (vj_scriptn =="Accept DigitalBoard" || "Accept Module" == vj_scriptn  || "Unit Final Check" == vj_scriptn  )							
								{
									coloresscrpit= "bg-green";
									
								}
								if (vj_scriptn =="Digital Module" ||  vj_scriptn=="Digital Unit" ||  vj_scriptn=="TXPA220")  							
								{
									coloresscrpit= "bg-yellow";
								}
								if (vj_scriptn =="Calibration Splitter" ||  vj_scriptn =="Calibration Generator" ||  vj_scriptn =="Unit Calibration") 							
								{
										coloresscrpit= "bg-info";
								}
								if (vj_scriptn =="SOFUSA Generator" ||  vj_scriptn=="Calibration Generator")							
								{
									coloresscrpit= "bg-warning";
								}	
								return " <span class='badge "+coloresscrpit+"'>" + vj_scriptn + "</span>";
								
								
							}},	
												
							{title:" <i class='fa fa-fw fa-tv'></i> Device", field:"device", sorter:"string", headerFilter:"input" },
							{title:" <i class='fa fa-fw fa-eye'></i> Id", field:"idruninfo", sorter:"integer", width:90, headerFilter:"input",cellClick:function(e, cell){

							//show_log(cell.getValue(),vv_userruninfo,vv_station,'');
							},

							formatter:function(cell, formatterParams){
								 var celldato = cell.getValue();
								return " <a href='#'  onclick=show_log("+celldato+") >"+  celldato + " <i class='fas fa-eye'></i></<>";
							}},	
						
					   
					]
					,
					/*	rowClick:function(e, row){
							table.deselectRow();
						},
						rowContext:function(e, row){
							alert("Row " + row.getIndex() + " Context Clicked!!!!")
						},*/
					});
				
					

		///fin prueba de tabulator
	});
	

	
	
	
	
	
		$(document).inactivityTimeout({
                inactivityWait: 10000,
                dialogWait: 10,
                logoutUrl: 'logout.php'
            })
	
	 /* requesting data */
     		
		function getData_spec_by_search(){	
			//window.location='log.php?p=fiplexlog2&SADwedASDsdASDÑlkjsñdlKJSÑDKjñskldjÑLSKDJÑlaskdjÑLASKJDdLKALSD=ASDFASDWERTRGSFDS&t1='+$('#datesearch').val()+'&t2='+$('#listuserm').val()+'&t3='+$('#liststation').val()+'&t4='+$('#listscrip').val();        			
			var vparam ="fiplexlog2";
			var vt1 = $('#datesearch').val();
			var vt2 = $('#listuserm').val();
			var vt3 = $('#liststation').val();
			var vt4 = $('#listscrip').val();
			$('#divmarcobusco').css({'background-color':'#ffffff'});
			
			toastr.options = {
						  "closeButton": false,
						  "debug": false,
						  "newestOnTop": false,
						  "progressBar": true,
						  "positionClass": "toast-bottom-right",
						  "preventDuplicates": false,
						  "onclick": null,
						  "showDuration": "600",
						  "hideDuration": "1000",
						  "timeOut": "5000",
						  "extendedTimeOut": "1000",
						  "showEasing": "swing",
						  "hideEasing": "linear",
						  "showMethod": "fadeIn",
						  "hideMethod": "fadeOut"
						};
				
			toastr["success"]("Wait....Search Results", "Attention :: Log Activity");
			console.log('getData_spec_by_search  fiplexlog2 Mostramos:'+$('#datesearch').val() + '--'+ $('#listuserm').val()+'&t3='+$('#liststation').val()+'&t4='+$('#listscrip').val() );
            $.ajax({
                url:'getruninfojson.php',
                type:'post',
                data:{rowid:2000,rowperpage:0,p:vparam, t1:vt1, t2:vt2,t3:vt3,t4:vt4},
                dataType:'json',
                success:function(response){
					console.log(response.length);
					if (response.length>1)
					{
						
						$('#p-b0').CardWidget('toggle');
						
						
						$('#divmarcobusco').css({'background-color':'#02BD41'});
						 $("#emp_table tr:not(:first)").remove();
						  createTablerowmarco(response, 0);					
					}
					else
					{
						//Msj sin datos.borro table;
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
						
						  $("#emp_table tr:not(:first)").remove();
						toastr["warning"]("No Search Results!", "Attention :: Log Activity");

						
						
						
					}
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
						
						$('#lblvstationr').html(datax.vstation.replace("#"," ") +' <a href="#" onclick="show_log2('+anex	+')") ><i class="fas fa-bug" style="color:blue"></i> '+idlog_view+'</a>');
					
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

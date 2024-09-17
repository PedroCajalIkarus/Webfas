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
	
		<style>
	
body
{
	  font-family: Arial, Helvetica, sans-serif;
	      background:#eee;		  
  font-size:12px;
  font-size:12px;
}
.form-controltamanio
{
/*white-space: nowrap;*/
white-space: pre;
	
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
              <li class="breadcrumb-item"><a href="home.php">Home</a></li>
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
                <h3 class="card-title"> <span name="iconolog" id="iconolog"><i class="fa fa-fw fa-list-alt"></i></span>Log Details :: </h3>
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
 <script src="js/eModal.min.js" type="text/javascript" />
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

   var table;
   var autscrollmarcosuma =1;
   var cantllamadasjson =30;
   
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
			 
				$("#detallelog1").text("");
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
			var coloresscrpit = ""
		    var vv_userruninfo="";
			const urlParams = new URLSearchParams(window.location.search);
			var pepe = urlParams.get('idab');
		
			var vv_station ="";
			var table = new Tabulator("#example-table", {
					height:altor,
					layout:"fitDataFill",									
					ajaxURL:"getruninfojsontabultorm.php?idab="+pepe,
					/*responsiveLayout : "collapse" , */
					ajaxProgressiveLoad:"scroll",					
					selectable:1,
					selectableRollingSelection:true,
					 selectablePersistence:false,
					   responsiveLayoutCollapseUseFormatters : true ,					
					paginationSize:20,
					placeholder:"No Data Set",					
					columns:[
					     
							{title:" <i class='fa fa-fw fa-calendar'></i> Date", field:"fechacorta", sorter:"date", width:140,headerFilter:"input"},							
							{title:" <i class='fa fa-fw fa-user'></i> User", field:"userruninfo", sorter:"string", width:90, headerFilter:"input" },
							{title:" <i class='fa fa-fw fa-tv'></i>  Station", field:"station", sorter:"string", width:90 ,headerFilter:"input" },
							{title:" <i class='fa fa-fw fa-cog'></i> Script", field:"script", sorter:"string", width:100, headerFilter:"input" ,
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
								if (vj_scriptn =="Calibration Splitter" ||  vj_scriptn =="Calibration Generator" ||  vj_scriptn =="unit calibration") 							
								{
										coloresscrpit= "bg-info";
								}
								if (vj_scriptn =="SOFUSA Generator" ||  vj_scriptn=="Calibration Generator")							
								{
									coloresscrpit= "bg-warning";
								}
								if (coloresscrpit=="")
								{
									coloresscrpit= "bg-secondary";
								}

								return " <span class='badge "+coloresscrpit+"'>" + vj_scriptn + "</span>";
								
								
							}},	
												
							{title:" <i class='fa fa-fw fa-tv'></i> Device", field:"device", sorter:"string", width:100, headerFilter:"input" },
							{title:" <i class='fa fa-fw fa-tv'></i> FasVer", field:"fasversion", sorter:"string", headerFilter:"input" , width:70 },
							{title:" <i class='fa fa-fw fa-eye'></i> Id", field:"idruninfo", sorter:"number", width:130, headerFilter:"input",cellClick:function(e, cell){

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
		
		//alert('fin');
		//console.log('pep tiene:'+ pepe);
		if ( pepe != null)
		{
			//	console.log('entreeee tiene:'+ pepe);
			toastr["success"]("Wait....Search Results by IDrunInfo", "Attention ::Activity Log");
			setTimeout('muestra_log_filtrado_xidrun()',3000);
		}
		
		
		
	});
	

	var  indcantllamdas =0;
 
	function marco_call_list()
{
 	autscrollmarcosuma =  1000000 * 2 * indcantllamdas ;
	indcantllamdas= indcantllamdas+ 10;
	

	$(".tabulator-tableHolder").scrollTop(autscrollmarcosuma);
	console.log(autscrollmarcosuma+':inicio autoscroll:'+indcantllamdas);
	$(".tabulator-tableHolder").scrollTop(1000000);
	if (indcantllamdas <120)
	{
		console.log('si');
		///$(".tabulator-tableHolder").scrollTop(0);
		setTimeout('marco_call_list()',4000);
	
	
	}
	else
	{
		console.log('fin');
	}
 
 
}
	
	
	
		$(document).inactivityTimeout({
                inactivityWait: 10000,
                dialogWait: 10,
                logoutUrl: 'logout.php'
            })
	
	 /* requesting data */
	 
	 
		function show_log_bs(id_business)
		{
			var iswamataproyect='N';
			if ($(window).height()>640)
			{
				var altor=  $(window).height() - 200+'px';
			}
			else
			{
				var altor=  "560px";
			}
			if (id_business > 10)
			{
				id_business =1;
				iswamataproyect='Y';
			}
			
			var coloresscrpit = ""
		    var vv_userruninfo="";
			var vv_station ="";
			
					var table = new Tabulator("#example-table", {
					height:altor,
					layout:"fitColumns",									
					ajaxURL:"getruninfojsontabultorm.php?idb="+id_business+"&wp="+iswamataproyect+"&scustom="+$("#txtbusqcustom").val(),
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
							{title:" <i class='fa fa-fw fa-eye'></i> Id", field:"idruninfo", sorter:"number", width:90, headerFilter:"input",cellClick:function(e, cell){

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
				
		}
     		
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
	  $("#detallelog1").html('');
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
					 
						$("#detallelog1").html(datax.dataoutcome);
						
						$( window ).height();
						
						$('#lblvuser').text(datax.vuser.replace("#"," "));
						$('#lblvdevice').text(datax.vdecice.replace("#"," "));
						var anex = "'"+idlog_view+"'" ;
						 var ifdebuger = <?php echo "'".$_SESSION["g"]."'";?>;
						
						if( datax.tienesupport == 0)
						{
							
							 $('#iconolog').html('<i class="fa fa-fw fa-list-alt"></i> ');
						}
						else
						{
							 $('#iconolog').html('<a href="#" onclick="openpopupframe('+datax.tienesupport	+')"><i class="fas fa-tools" style="color:green"></i> Open Support Ticket</a> ::  ');
						}
					
					
						 if (ifdebuger == "develop")
						 {
							 $('#lblvstationr').html(datax.vstation.replace("#"," ") +' <a href="#" onclick="show_log2('+anex	+')") ><i class="fas fa-bug" style="color:blue"></i> '+idlog_view+'</a> - <a href="#" onclick="callsupportit('+anex	+')") > <i class="fas fa-question-circle"></i>Require Support</a>&nbsp;&nbsp;<a href="#" onclick="open_plots('+idlog_view+')"><i class="far fa-file-image"></i> Plots </a> ');
						 }
						 else
						 {
							$('#lblvstationr').html(datax.vstation.replace("#"," ") +' <a href="#" onclick="callsupportit('+anex	+')") > <i class="fas fa-question-circle"></i>Require Support</a>&nbsp;&nbsp;<a href="#" onclick="open_plots('+idlog_view+')"><i class="far fa-file-image"></i> Plots </a> '); 
						 }
						
					
				}
			});
   }
   
       function openpopupframe(idtksupport)
	{
		var ipsrv= <?php echo "'".$ipservidorapache."'";?>;;
		eModal.iframe('edittksuppor.php?idt='+idtksupport,'Tech Support FAS - Ticket Manager ');
	} 		
		
		
 function  callsupportit (idlog_view2)
 {
	// alert(idlog_view2);

			$.ajax
			({ 
				url: 'listcategoryxtkajax.php',			
				type: 'post',
				async:true,
                cache:false,
				success: function(data)
				{
					var datax = JSON.parse(data)
					console.log(datax);
					$.each(data, function(index) {
						console.log(data[index].namecategory);
						
					});
        		
				}
			});


	 
	 var userregistred = <?php echo "'".$_SESSION["b"]."'";?>;
	 var options = {
       	message: " <div class='form-group'>Type: <select id='idtipoproblema' name='idtipoproblema' class='form-control form-control-sm'> <option value='1'>Reference Parameter</option><option value='2'>Engineering Issue</option>	<option value='3'>FAS Script</option><option value='4'>HW Issue</option><option value='5'>SO Creation</option><option value='8'>WEBFAS Page</option></select></div> Issue:?  ",		         
	  title: 'Tech Support FAS',
        size: eModal.size.lg,
        subtitle: 'open an error ticket: Ref. IdRunInfo: ' + idlog_view2
       
    };
	
		/*eModal.prompt(options)
      .then(callback, callbackCancel);*/
	  
	     return eModal
                .prompt(options)
                .then(
                    function (input) {
					//alert(input);
				///	toastr["info"]("Sending information...", "");
toastr["info"]("Generating support ticket.<br><b> WAIT</b> for the save confirmation.", "");						
					$.ajax({
				url: 'ajaxinsert_supportit.php', 				
				data: "idruninfodb="+idlog_view2+'&v_issue='+input+'-Ref:'+idlog_view2+'&vuser='+userregistred+'&tp='+$('#idtipoproblema').val()+'&keyd='+idlog_view2,					
				type: 'post',				
				datatype:'JSON',				
				cache:false,					
				success: function(data, status, xhr) {
					
				
					if (data =="ok" )
					{
						toastr["success"]("Save OK!", "");						
					}
					else	
					{
						toastr["error"]("Error when storing data...", "");						
					
					}
					return false;	
				
				},
				error: function(xhr, status, error) {
					 console.log(status);
				}
				});
					
					},
                    function (/**/) { $('#lbldatoserrr').html("ERROR: <br>"+resulterr); });
	 
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
				async:false,
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
						
						$('#lblvstationr').html(datax.vstation.replace("#"," ") +' <a href="#" onclick="show_log('+anex	+')") ><i class="fas fa-bug" style="color:green"></i></a> -');
					
				},
				   timeout: 15000 // sets timeout to 3 seconds
			});
			
   }
   
   function search_custom(tipodehab, idparambusiness)
   {
	   if (tipodehab==1)
	   {
		   //show  txtbusqcustom
			$("#txtbusqcustom").removeClass('d-none'); 
			$("#btn2").removeClass('d-none'); 
			$("#btn1").addClass('d-none'); 
		   
	   }
	   else
	   {
		   console.log('buscar'); 
		//   $("#btn2").addClass('d-none'); 
		   toastr["warning"]("Searching...", "");				
		   show_log_bs(idparambusiness);
		   $("#btn2").removeClass('d-none'); 
	   }
   }

   function open_plots (vvidruninfo)
   {
	//console.log('Hola' + vvidruninfo );
	var win = window.open('https://webfas.honeywell.com/plost_by_runinfo.php?idr='+vvidruninfo, '_blank');
		if (win) {
			//Browser has allowed it to be opened
			win.focus();
		} else {
			//Browser has blocked it
			alert('Please allow popups for this website');
		}

   }
   
</script>

</html>

<!DOCTYPE html>
<?php 

// Desactivar toda notificación de error
error_reporting(0);
// Notificar todos los errores de PHP (ver el registro de cambios)
//error_reporting(E_ALL);
	include("db_conect.php"); 
	$status = $connect->getAttribute(PDO::ATTR_CONNECTION_STATUS);
	
	if ($status !="Connection OK; waiting to send.")
	{
	
		header("Location: http://".$ipservidorapache."/errorconect.php");
		exit;
		
	}
	
	include("menu.php"); 
	include("funcionesstores.php"); 
	include ('licencefiplex_mm.php');
 
    //   $Encryption = new Encryption();
		  
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
        <a href="http://192.168.70.216/log.php" class="nav-link">Home</a>
      </li>
      
    </ul>

 

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->    
	
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">2</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Agustin
              
                </h3>
                <p class="text-sm">New SO</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Marco
                 
                </h3>
                <p class="text-sm">ADD SN TO SO</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 8 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
         
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">1</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">1 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 2 new SOFUSA Generator
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
       
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
    
   
      <!-- Notifications Dropdown Menu -->
    </ul>
  </nav>
  <!-- /.navbar -->


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  
    <!-- Main content -->
    <section class="content">
      <div class="row">
	  
	    <section class=" col-lg-6">
			
			<div class="card container-fluid">
			   <div class="card card-primary">
            <!-- /.card-header -->
			
				<div id="accordion">
					  <table id="example1" class="table 	 table-sm">
						<thead>
						<tr>                  
						  <th>State of Sale Orders    
						 <span name="openbusqueda" id="openbusqueda" > &nbsp; &nbsp; &nbsp;<a href="#" onclick="habilitarbusqueda();"><i class="fas fas fa-search-plus mr-1" ></i></a></span>
						 <span name="closebusqueda" id="closebusqueda"> &nbsp; &nbsp; &nbsp;<a href="#" onclick="dehabilitarbusqueda();"><i class="fas fas  fa-search-minus mr-1" ></i></a></span>
						  </th>   
						</tr>
						</thead>
						<tbody>
					  
							
								<?php		

	

								
							  		   $query_lista = list_SO_count_report1();						
										$data = $connect->query($query_lista)->fetchAll();		

   
  
									//echo  $query_lista;
										foreach ($data as $row) 
										{
											$qporc=round(($row[3]*100)/$row[2]);
												  $bgclass="bg-danger";
												  if ($qporc < 40)
												  {
													    $bgclass="bg-danger";
												  }
											      if ($qporc >= 40)
												  {
													    $bgclass="bg-warning";
												  }
												  if ($qporc >= 85)
												  {
													    $bgclass="bg-green";
												  }
											?>
												<tr>                  
												  <td>
													
														                   
															<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $row[0]; ?>" class="" aria-expanded="true">
															  <i class="nav-icon fas fa-list-alt"></i>
															<?php
																$v_show_SO_CIU = " ".$row[1]." - ".$row[4];
																echo  " ".$row[1]." - ".substr($row[4],0,30); 
																if ( strlen($row[4])>31) 
															    { 
																 echo "...";
																}  
																?>  </a>
														  
														
														  
																<span data-toggle="tooltip" title="" class="badge <?php echo $bgclass; ?>  mb-2 labelsom ">										
																 <b>  <?php echo " [ ".$row[2]; ?> CIU ]</b> -<?php echo $qporc;?><sup style="font-size: 10px">%</sup>
																																
																</span> 			
																<a href="#"><i class="nav-icon fas fa-chart-line"></i>	</a>																
																			
														
														<div id="collapse<?php echo $row[0]; ?>" class="panel-collapse in collapse" style="">
														<table id="example3" class="table table-bordered table-striped table-sm">
														<tbody><tr><td>
															<div class="card-headermarco">
																<?php
																	$query_lista = list_show_CIU_by_SO( $row[0]);
																//	echo $query_lista;
																	$data = $connect->query($query_lista)->fetchAll();						
																	foreach ($data as $rowciu) 
																	{																	
																	
																	//	echo $row[0]."<br>";
																	$letrasbuscadas = array("/", ".", ",", "-", );
																	$rowciu_sincaractraros = str_replace($letrasbuscadas, "", $rowciu[0]);
																		?>
																		<a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $row[0]."-".$rowciu_sincaractraros;?>" class="" aria-expanded="true">
										  							    <i class="nav-icon fas fa-ths"></i>
																		<img src="img/imgciu.jpg" width="40px" >
																		<?php echo $rowciu[0]; ?></a>
																	    <span data-toggle="tooltip" title="" class="badge bg-warning mb-2 labelsom">										
																	     <b> &nbsp;[ &nbsp;<?php echo $rowciu[1]; ?> SN &nbsp;] &nbsp;</b> <b>...calc.. <sup style="font-size: 10px">%</sup></b></span>
																		<a href="#"><i class="nav-icon fas fa-chart-line"> </i>	</a>																																		
																		<br>
																		 <div id="collapse<?php echo $row[0]."-".$rowciu_sincaractraros;?>" class="panel-collapse in collapse" style="">
																			<div class="card-body">
																				<table id="example3" class="table table-bordered table-striped table-sm">
																				<tbody>
																				<?php
																					$query_lista = list_show_CIU_SN( $row[0],$rowciu[0]);
																					//echo $query_lista;
																					$data = $connect->query($query_lista)->fetchAll();						
																					foreach ($data as $rowciu_sn) 
																					{	
																				?>
																												
																				<tr><td><a href="#" onclick="show_info_log('<?php echo $rowciu[0];?>','<?php echo $rowciu_sn[0];?>','<?php echo $v_show_SO_CIU; ?>')"><i class="nav-icon fas fa-th"></i><?php echo $rowciu_sn[0];?></a> 
																				<span data-toggle="tooltip"  class="float-right">								  
																				   <span data-toggle="tooltip" title="1 Calibration" class="badge bg-warning">Dig. Mod <i class="fas fa-check"></i></span>
																					<span data-toggle="tooltip" title="3 Calibration" class="badge bg-primary">Calib [3]</span>											
																					 <span data-toggle="tooltip" title="3 Calibration" class="badge bg-success">Acept [1] </span>
																					 <span data-toggle="tooltip" title="3 Calibration" class="badge bg-danger">Final Chk</span>
																					 </span>
																				  </td>
																				</tr>
																					<?php } ?>
																				</table>
																			</div>
																		</div>	
																		<?php
																	 }
																?>
																
														    </div>
														</td></tr>	</tbody></table>
														</div>
															
														
												  </td>	
												</tr>														
											<?php
										}
											
								?>			
							
                  <!-- we are adding the .class so bootstrap.js collapse plugin detects it -->
							
						</tbody>
					  </table>
 </div>				  
				</div>		

          </div>
          <!-- /.card -->
       	
		  </section>
        
		<section class=" col-lg-6">
			<!-- Box Details -->
			 <div class="card" style="position: relative; left: 0px; top: 0px;">
              <div class="card-header ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title">
                  <i class="fas fas fa-tag mr-1"></i>
                  General Info - Details Logs
                </h3><br><br>
                <div class="card-tools">
                  <ul class="nav nav-pills ml-auto">
                    <li class="nav-item">
                      <a class="nav-link active" href="#generalinfo" data-toggle="tab">General Info</a>
                    </li>
					<li class="nav-item">
                      <a class="nav-link" href="#generalinfoul" data-toggle="tab">UL</a>
                    </li>
					<li class="nav-item">
                      <a class="nav-link" href="#generalinfodl" data-toggle="tab">DL</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link " href="#infolog" data-toggle="tab">Details Log</a>
                    </li>
					<li class="nav-item">
                      <a class="nav-link " href="#infogroupbyciu" data-toggle="tab">Group by CIU</a>
                    </li>
                  </ul>
                </div>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content p-0">
				<p name="ciusnshow" id="ciusnshow" class="text-primary ">  </p>
				<p name="msjwait" id="msjwait" align="center"><img src="img/waitazul.gif" width="100px" ></p>
                  <!-- Morris chart - Sales -->
				  <div class="chart tab-pane pre-scrollable " id="infogroupbyciu" style="position: relative; height: 500px;overflow-x: auto;font-size: 14px;">
					--
				  </div>
				   <div class="chart tab-pane pre-scrollable " id="generalinfoul" style="position: relative; height: 500px;overflow-x: auto;font-size: 14px;">
				    
				   </div>
				    <div class="chart tab-pane pre-scrollable" id="generalinfodl" style="position: relative; height: 500px;overflow-x: auto;font-size: 14px;">
					  
					</div>
                  <div class="chart tab-pane active pre-scrollable" id="generalinfo" style="position: relative;height: 500px;overflow-x: auto;font-size: 14px;">
                  
				  
						 
					
                   </div>
                  <div class="chart tab-pane" id="infolog" style="position: relative; height: 500px;">
				 
				  
				  
                    <textarea class="form-control form-controltamanio" rows="20" id="detallelog" name="detallelog"></textarea>
				
                    
                  </div>  
                </div>
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->

		
			
			<!-- Edn box details -->
		
		
		  </section>
		
		 
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 1.0.0
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
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="../../plugins/datatables/jquery.dataTables.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>


<script src="/plugins/jquery-knob/jquery.knob.min.js"></script>

<!-- Sparkline -->

<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- page script -->
<script>

  $( document ).ready(function() {
				$('#closebusqueda').hide();
				$("#msjwait").hide();
				$("#example1").DataTable({
							 "paging": true,
						  "lengthChange": false,
						  "searching": false,
						  "ordering": false,
						  "info": true,
						  "autoWidth": false,
						  "iDisplayLength": 12
						}
				);
				
				
	
	});
	
	var table = $('#example2').DataTable();
 
	table.on( 'draw', function () { 
		console.log( 'Redraw occurred at: '+new Date().getTime() );
		$('.knob').knob({ 	})	
	} );
	
	$(function () {
  			$('.knob').knob({ 
			})

	})
  
	function habilitarbusqueda()
	{		
		$('#openbusqueda').hide();
		$('#closebusqueda').show();
		$("#example1").DataTable({
					 "destroy": true,
						 "paging": true,
					  "lengthChange": false,
					  "searching": true,						  
					  "ordering": false,
					  "info": true,
					  "autoWidth": false,
					  "iDisplayLength": 10
					}
			);
					
					
	}
   
	function dehabilitarbusqueda()
	{

			$('#closebusqueda').hide();
			$('#openbusqueda').show();
			$("#example1").DataTable({
						 "destroy": true,
							 "paging": true,
						  "lengthChange": false,
						  "searching": false,						  
						  "ordering": false,
						  "info": true,
						  "autoWidth": false,
						  "iDisplayLength": 10
						}
				);
				
				
	}
  function show_info_log(vciu,cciu_sn,vso)
  {
	 $("#msjwait").fadeIn('slow');   
	   
		$.ajax
			({ 
				url: 'ajax_show_info_sn.php',
				data: "idciu="+vciu+'&ciusn='+cciu_sn,	
				type: 'post',				
				datatype:'JSON',
				success: function(data)
				{
				//	alert(data);
					
					//detallelog
					 $("#msjwait").hide();	
					//mostramos datos del SN y CIU selecionado.
				      $('#ciusnshow').html(vso+' -> '+vciu +' -> '+ cciu_sn); 

					var array_rev = [];
					var array_rev_nombrefila= [];
					var array_rev_datos= [];
					var array_gralinfo= [];
					
					var array_gral_ch= [];
					
					
					/// 1° array datos - general info
					var eTable="<table class='table text_table_info' ><thead> ";	
					eTable += "<tr>";
					eTable += "<th> </th>";
					
							array_gralinfo[0] = data[0].gi;	
							var cant_rev=0;
							 $.each(array_gralinfo[0], function(index, value){
							 // console.log('array_gralinfo[0] contiene: '+index+ '-----#'+ value.Band+'#---'+array_gralinfo[0].length);
									nomcolum = array_gralinfo[0].length-1-cant_rev;
									cant_rev = cant_rev + 1;
									eTable += "<th> Band "+value.Band+"<br>Rev "+value.Rev+" </th>";
								});	
							eTable += "</tr></thead><tbody>";								  
							array_rev_datos[0] =  array_gralinfo[0][0];							
							$.each(array_rev_datos[0], function(index, value){							
									if (index != "Band" && index !="Rev")
									{
										eTable += "<tr><th>  "+index+" </th>";		
											for(var i=0; i< cant_rev;i++)
											{
												array_rev[0] = array_gralinfo[0][i];
												eTable += "<td>  "+array_rev[0][index]+" </td>";										
											}
										 eTable += "</tr>";	
									 }
								});
							eTable +="</tbody></table>";
						    $('#generalinfo').html(eTable);	
							
							// vamos con el div generalinfoul
							var eTableul="<table class='table' ><thead> ";	
							//console.log(eTableul);
							eTableul += "<tr>";								
							eTableul += "<th> </th>";	
						
							array_gralinfo[0] = data[1].ul;	
							cant_rev = 0
							
							 $.each(array_gralinfo[0], function(index, value){
							//   console.log('array_gralinfo[0] contiene: '+index+ '------'+ value.PO+'---'+array_gralinfo[0].length);
									nomcolum = array_gralinfo[0].length-1-cant_rev;
									cant_rev = cant_rev + 1;
								//	eTableul += "<th> Rev "+nomcolum+" </th>";
								    eTableul += "<th> Band "+value.Band+"<br>Rev "+value.Rev+" </th>";
								//	console.log(eTableul);
								});	
							eTableul += "</tr></thead><tbody>";								  
															  
								array_rev_datos[0] =  array_gralinfo[0][0];							
								$.each(array_rev_datos[0], function(index, value){							
									if (index != "Band" && index !="Rev")
									{
										eTableul += "<tr><th>  "+index+" </th>";		
										for(var i=0; i< cant_rev;i++)
										{
											array_rev[0] = array_gralinfo[0][i];
											eTableul += "<td>  "+array_rev[0][index]+" </td>";										
										}
										 eTableul += "</tr>";
									}										 
								});
							
							eTableul +="</tbody></table>";
							
							//// Tabla de Channel.
							eTableul +="<br><hr><table class='table'><thead><th>Fch</th> ";
							eTabledl_anexar="<br><hr><table class='table'><thead><th>Fch</th> ";
							
							cant_rev=0;
							var cant_rev_ch=0;
							var vtemp_cab_ch ='';
							array_gral_ch[0] = data[4].ch;	
							 $.each(array_gral_ch[0], function(index, value){
							   //  console.log('array_gral_ch[0] contiene: '+index+ '------'+ value.Rev+'---'+array_gral_ch[0].length);							
								    cant_rev_ch = cant_rev_ch + 1;
									if (vtemp_cab_ch !=value.Band+value.Rev)
									{
											cant_rev = cant_rev + 1;
											    eTableul += "<th> Band "+value.Band+"<br>Rev "+value.Rev+" </th>";	
												eTabledl_anexar+= "<th> Band "+value.Band+"<br>Rev "+value.Rev+" </th>";	
												vtemp_cab_ch =value.Band+value.Rev
									//	console.log('distintos');
									}
															
								});	
							eTableul +="<thead><tbody>";
							eTabledl_anexar  +="<thead><tbody>";
							vtemp_cab_ch="";
							vtemp_cab_ch_actual="";
							for(var ives=0; ives< cant_rev_ch;ives++)
							{
								array_rev_datos[0] =  array_gral_ch[0][ives];							
								$.each(array_rev_datos[0], function(index, value){	
								console.log( 'ver band contiene: '+index+ '------'+ value);	
								vtemp_cab_ch_actual=index+value;
							
										
									if (index != "Band" && index !="Rev" )
									{
										
										//console.log(cant_rev_ch+ 'array_gral_ch[0] contiene: '+index+ '------'+ value);												
										for(var i=0; i< cant_rev_ch;i++)
										{
										//	eTableul += "<tr><th>  "+index+" </th>";
											array_rev[0] = array_gral_ch[0][i];
											
											eTableul += "<tr><th>  "+array_rev[0].idch+" </th>";
											eTableul += "<td>  "+array_rev[0].idchul+" </td>";	
											eTableul += "</tr>";
											
											eTabledl_anexar += "<tr><th>  "+array_rev[0].idch+" </th>";
											eTabledl_anexar += "<td>  "+array_rev[0].idchdl+" </td>";	
											eTabledl_anexar += "</tr>";
																			
										}
										 
									}										 
								});
								}
							
							eTableul +="</tbody></table>";
							eTabledl_anexar+="</tbody></table>";
							
								//console.log(eTableul);
							$('#generalinfoul').html(eTableul);	
							
							// vamos con el div generalinfodl
							var eTabledl="<table class='table' ><thead> ";	
							//console.log(eTabledl);
							eTabledl += "<tr>";
								
							eTabledl += "<th> </th>";
					
						
							array_gralinfo[0] = data[2].ud;	
							
							
							cant_rev = 0
							
							 $.each(array_gralinfo[0], function(index, value){
							//   console.log('array_gralinfo[0] contiene: '+index+ '------'+ value.PO+'---'+array_gralinfo[0].length);
									nomcolum = array_gralinfo[0].length-1-cant_rev;
									cant_rev = cant_rev + 1;
								//	eTabledl += "<th> Rev "+nomcolum+" </th>";
									eTabledl += "<th> Band "+value.Band+"<br>Rev "+value.Rev+" </th>";
								//	console.log(eTabledl);
								});	
							eTabledl += "</tr></thead><tbody>";								  
															  
								array_rev_datos[0] =  array_gralinfo[0][0];							
								$.each(array_rev_datos[0], function(index, value){							
									if (index != "Band" && index !="Rev")
									{
										eTabledl += "<tr><th>  "+index+" </th>";		
										for(var i=0; i< cant_rev;i++)
										{
											array_rev[0] = array_gralinfo[0][i];
											eTabledl += "<td>  "+array_rev[0][index]+" </td>";										
										}
										 eTabledl += "</tr>";	
									}	 
								});
							
							eTabledl +="</tbody></table>";
							eTabledl +="</tbody></table>";
							//	console.log(eTabledl);
							
							eTabledl +=eTabledl_anexar;
							$('#generalinfodl').html(eTabledl);	
							
							/// armamos menu botones log.
							var ebtuttonslog="";
							array_gralinfo[0] = data[3].lg;	
							array_rev_datos[0] =  array_gralinfo[0][0];	
							 $.each(array_gralinfo[0], function(index, value){
							   //console.log('ebtuttonslog contiene: '+index+ '------'+ value.idruninfo);
								  ebtuttonslog +="  <button type='button' class='btn btn-sm btn-primary' style='background-color:#fff;color:#000000' onclick='show_log("+value.idruninfo+")'><i class='fas fa-search'></i> Rev "+ index + "</button> ";
								});	
								 ebtuttonslog +=" <textarea class='form-control form-controltamanio' rows='20' id='detallelog' name='detallelog'></textarea>";
							
							$('#infolog').html(ebtuttonslog);	
							
					 
							
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
				url: 'readlogbyruninfosale.php',
				data: "idlog="+idlog_view,	
				type: 'post',
				async:true,
                cache:false,
				success: function(data)
				{			
					 $("#msjwait").hide();
					 $("#detallelog").fadeIn(100);					
					$("#detallelog").html(data.replace(/<br>/g,' \r\n'));									
				}
			});
   }
   
  function show_CIU_SN(idsaleorders)
   {

	   $("#detallelog").fadeOut('fast');  
	   $("#msjwait").fadeIn('slow');   
	   
		$.ajax
			({ 
				url: 'ajax_show_CIU_SN.php',
				data: "idsaleorders="+idsaleorders,	
				type: 'post',				
				datatype:'JSON',
				success: function(data)
				{
				//	alert(data);
					
					//detallelog
					 $("#msjwait").hide();				 
					
					  var eTable="<table><thead><th>Ciu - Serial Number</th>  </thead><tbody>";
					
					  for(var i=0; i<data.length;i++)
					  {
						eTable += "<tr>";
						eTable += "<td> <a href='#'><i class='nav-icon fas fa-th'></i> "+data[i].ciu+" - "+data[i].sn_unit+"</a> -- <input type='text' class='knob' value='30' data-width='40' data-height='40' data-fgColor='#f56954'><span data-toggle='tooltip'  class='float-right'> <span data-toggle='tooltip' title='1 Calibration' class='badge bg-warning'>Dig. Mod</span><span data-toggle='tooltip' title='3 Calibration' class='badge bg-primary'>Calib [3]</span><span data-toggle='tooltip' title='3 Calibration' class='badge bg-success'>Acept [1] </span><span data-toggle='tooltip' title='3 Calibration' class='badge bg-danger'>Final Chk</span></span></td>";
						
						eTable += "</tr>";
					  }
					  eTable +="</tbody></table>";
					  $('#example2').html(eTable);
					  $('#example2').DataTable({
					  "paging": true,
					  "destroy": true,
					  "lengthChange": false,
					  "searching": true,
					  "ordering": true,
					  "info": true,
					  "autoWidth": false,
					  "iDisplayLength": 5
					})
					
						$('.knob').knob({ 
						})

 									
					
				}
			});
   }


</script>
</body>
</html>

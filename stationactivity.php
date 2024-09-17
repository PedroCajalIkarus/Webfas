<!DOCTYPE html>
<?php 

// Desactivar toda notificación de error
error_reporting(0);
// Notificar todos los errores de PHP (ver el registro de cambios)
//error_reporting(E_ALL);
 include("db_conect.php"); 
 
 	session_start();
 
 	session_start();
	 if(isset($_SESSION["timeout"])){
        // Calcular el tiempo de vida de la sesión (TTL = Time To Live)
	//	echo "***********hola".time() - $_SESSION["timeout"];
        $sessionTTL = time() - $_SESSION["timeout"];
        if($sessionTTL > $inactividad){
			session_unset();
            session_destroy();
            header("Location: http://".$ipservidorapache."/index.php?t=timeoutinactivityhome");
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
            header("Location: http://".$ipservidorapache."/index.php?t=notcookietimeouthome");
        
	}
	
	$status = $connect->getAttribute(PDO::ATTR_CONNECTION_STATUS);
	
	if ($status !="Connection OK; waiting to send.")
	{
	
		header("Location: http://".$ipservidorapache."/".$folderservidor."/errorconect.php");
		exit();
		
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
  
  
  <link href="css/tabulator_bootstrap4.css" rel="stylesheet">
  <link rel="shortcut icon" href="fiplexcirculo-01.ico" />
  
  <link rel="stylesheet" href="toastr.css">
  
 <link href="css/tabulator_bulma.css" rel="stylesheet">
 
  
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

progress {
    vertical-align: baseline;
    width: 600px;
}

</style>


</head>
<form name="frma" id="frma" method="post" onsubmit="return validateMyForm();">
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
            <h1>Station Activity </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Station Activity</li>
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
			
			  <div class="demo-container">
  
			
						
			<p name="msjwaitline" id="msjwaitline" align="center"><img src="img/waitazul.gif" width="100px" ></p>	
				<div class="card">
				
				<!-- aca tree				-->
				<div class="container">
				
    <div class="row">
        <div class="">
            <div class="tree ">
<ul>

<li><span><a style="color:#000; text-decoration:none;"  data-toggle="collapse" href="#Web" aria-expanded="true" aria-controls="Web"><i class="collapsed"></i>
<i class="expanded"><i class="far fa-folder-open"></i></i> Weeks with activity</a> &nbsp;&nbsp;
<a href="#" onclick="armar_graficos_xrun(this.getAttribute('aria-expanded') ,'na','na','na','na')" ><i class="far fa-eye"></i></a></span>
<div id="Web" class="collapse show">
<ul>


<?php

$query_lista = "	select distinct  extract(week from dateserver::date) as nrosemana 						
from fas_routines_product_sn
inner join runinfodb
on fas_routines_product_sn.idruninfo = runinfodb.idruninfo 
left join fas_calibration_result
on fas_calibration_result.idruninfo = fas_routines_product_sn.idruninfo and
fas_calibration_result.unitsn = fas_routines_product_sn.sn and
fas_calibration_result.totalpass is true
left join fas_calibration_result as fas_calibration_result_f
on fas_calibration_result_f.idruninfo = fas_routines_product_sn.idruninfo and
fas_calibration_result_f.unitsn = fas_routines_product_sn.sn and
fas_calibration_result_f.totalpass is false
where dateserver  > NOW() - INTERVAL '15 DAY'  
and (fas_calibration_result_f.unitsn is not null or fas_calibration_result.unitsn is not null )
order by nrosemana desc
							";
						
$data = $connect->query($query_lista)->fetchAll();	
foreach ($data as $rowcab) 
{
	?>
			<li><span><a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#Pagemm<?php echo  trim($rowcab['nrosemana']);?>" 
			
			aria-expanded="false" aria-controls="Pagemm<?php echo trim($rowcab['nrosemana']);?>"><i class="collapsed"></i>
			<i class="expanded"><i class="far fa-calendar-alt "></i></i> Week <?php echo $rowcab['nrosemana'] ;?> </a>
		
			&nbsp;&nbsp;
<a href="#" onclick="armar_graficos_xrun(this.getAttribute('aria-expanded') ,'na','na','na','<?php echo $rowcab['nrosemana'];?>')" ><i class="far fa-eye"></i></a>
		</span>
				<ul>
					<div id="Pagemm<?php echo trim($rowcab['nrosemana']);?>" class="collapse">

					<?php		
						//////////////////// S 
		
							$query_lista2 = "	select distinct  to_char(dateserver, 'YYYY-MM-DD') as diarun ,
							count(distinct fas_calibration_result.unitsn) as cctrue, 
													count(distinct fas_calibration_result_f.unitsn) as ccfalse
											
				 			from fas_routines_product_sn
							inner join runinfodb
							on fas_routines_product_sn.idruninfo = runinfodb.idruninfo 
							left join fas_calibration_result
							on fas_calibration_result.idruninfo = fas_routines_product_sn.idruninfo and
							fas_calibration_result.unitsn = fas_routines_product_sn.sn and
							 fas_calibration_result.totalpass is true
							left join fas_calibration_result as fas_calibration_result_f
							on fas_calibration_result_f.idruninfo = fas_routines_product_sn.idruninfo and
							fas_calibration_result_f.unitsn = fas_routines_product_sn.sn and
							 fas_calibration_result_f.totalpass is false
							where dateserver  > NOW() - INTERVAL '15 DAY' 
							and  extract(week from dateserver::date) = ".$rowcab['nrosemana']."
							group by   to_char(dateserver, 'YYYY-MM-DD') 
							order by   diarun desc ";
 							   $elnrodesemana = $rowcab['nrosemana'];
						//	echo "a<br>".$query_lista2;
							$data2 = $connect->query($query_lista2)->fetchAll();		
 
							foreach ($data2 as $rowcab) 
							{
								if ($rowcab['cctrue'] ==0 && $rowcab['ccfalse']==0 )
								{}
								else
								{

								
								?>
								<li><span><a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#Page<?php echo  trim($rowcab['diarun']);?>" 
									
									aria-expanded="false" aria-controls="Page<?php echo trim($rowcab['diarun']);?>"><i class="collapsed"></i>
									<i class="expanded"><i class="far fa-calendar-alt "></i></i> <?php echo $rowcab['diarun'] ;?> </a>
								
			&nbsp;&nbsp;
<a href="#" onclick="armar_graficos_xrun(this.getAttribute('aria-expanded') ,'<?php echo $rowcab['diarun']; ?>','na','na','<?php echo $elnrodesemana;?>')" ><i class="far fa-eye"></i></a>
								</span>
										<ul>
											<div id="Page<?php echo trim($rowcab['diarun']);?>" class="collapse">

											<?php		
												//////////////////// S 
								
													$query_lista32 = "	select userruninfo, runinfodb.station, to_char(dateserver, 'YYYY-MM-DD') as diarun,  
													count(distinct fas_calibration_result.unitsn) as cctrue, 
													count(distinct fas_calibration_result_f.unitsn) as ccfalse ,  extract(week from dateserver::date) as nrosemana 
													from fas_routines_product_sn
													inner join runinfodb
													on fas_routines_product_sn.idruninfo = runinfodb.idruninfo 
													left join fas_calibration_result
													on fas_calibration_result.idruninfo = fas_routines_product_sn.idruninfo and
													fas_calibration_result.unitsn = fas_routines_product_sn.sn and
													fas_calibration_result.totalpass is true
													left join fas_calibration_result as fas_calibration_result_f
													on fas_calibration_result_f.idruninfo = fas_routines_product_sn.idruninfo and
													fas_calibration_result_f.unitsn = fas_routines_product_sn.sn and
													(fas_calibration_result_f.totalpass is false or fas_calibration_result_f.totalpass is null )
													where dateserver  > NOW() - INTERVAL '15 DAY' 
													and to_char(dateserver, 'YYYY-MM-DD') = '".$rowcab['diarun']."'
													group by userruninfo, runinfodb.station , to_char(dateserver, 'YYYY-MM-DD') ,extract(week from dateserver::date)
													order by station,  diarun desc ";
													
											//	echo $query_lista32;
													$data2 = $connect->query($query_lista32)->fetchAll();		
						
													foreach ($data2 as $row) 
													{
														if ($row['cctrue'] ==0 && $row['ccfalse']==0 )
														{}
														else
														{

														
														?>
														<li><span><a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#folder<?php echo trim($row['userruninfo']).$row['diarun'];?>" aria-expanded="false" aria-controls="folder<?php echo trim($row['userruninfo']).$row['diarun'];?>"><i class="collapsed"></i>
								
														<?php

																		
															//Antes de mostrar pregunto si tiene mas ramas.
														?>
																	<i class="expanded"><i class="	fas fa-laptop"></i></i> <?php echo $row['station'];  ?></a> 
																						<span data-toggle="tooltip" title="" class="badge  bg-green ">										
																						<?php echo " [ ".$row['cctrue']; ?> SN ]			 
																						</span> 
																						||
																						<span data-toggle="tooltip" title="" class="badge  bg-danger ">										
																						<?php echo " [ ".$row['ccfalse']; ?> SN ]			 
																						</span> 
																					
																					</span> 
																					<a href="#" onclick="armar_graficos_xrun(this.getAttribute('aria-expanded') ,'<?php echo $row['diarun']; ?>','<?php echo trim($row['userruninfo']) ;?>','<?php echo trim($row['station']) ;?>','<?php echo $row['nrosemana'];?>')">  <i class='far fa-eye'></i></a>
													
														
													</li> 
														<?php	
														}
														$iddatos = $iddatos + 1 ;
														
													}
													?>


											</div>
										</ul>
									</li>	
								<?php
								}	
								 
								$iddatos = $iddatos + 1 ;
								
							}
							?>


					</div>
				</ul>
			</li>	 
				

	<?php
}	

?>

 
		
         
        </div>
    </div>
</div>
				<!-- fin aca tree -->
				
					
				</div>	
				</div>
			
					

        </section>
		<section class="col-lg-8 connectedSortable ui-sortable">
		

				<div class="card">
				<div class="card-header ui-sortable-handle" >
               		
				<div class="card">
            
              <!-- /.card-header -->
              <div class="card-body p-0" style="display: block;">
                <div class="d-md-flex">
                  <div class="p-1 flex-fill" style="overflow: hidden" >
                    
					
					<!--detalle so -->
					<div class="card" style="position: relative; left: 0px; top: 0px;">
              <div class="card-header ui-sortable-handle"  >
                <h3 class="card-title">
                  <i class="fas fas fa-tag mr-1"></i>
                  General Info - Details: 
				  <p name="ciusnshowbks" id="ciusnshowbks" class="d-none "> 
                </h3><p name="ciusnshow" id="ciusnshow" class="text-primary ">  </p>
                <div class="card-tools">
                  <ul class="nav nav-pills ml-auto">
                    <li class="nav-item" name="divgeneralinfo" id="divgeneralinfo">
                      <a class="nav-link active" href="#generalinfo" data-toggle="tab">General Info</a>
                    </li>
				 
                  </ul>
                </div>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content p-0">
                  <!-- Morris chart - Sales -->
				
                  <div class="chart tab-pane active pre-scrollablemarco " id="generalinfo" style="position: relative;">	
                <A name="anclamyTabledib" id="anclamyTabledib"></A>
				 
				
				<p name="msjwaitsn" id="msjwaitsn" align="center"><img src="img/waitazul.gif" width="100px" ></p>	

						<div id="divlossn" name="divlossn"  style=" height:200px; overflow-y: scroll;">
							
							</div>
						  
                </div>

				<br>
				<hr>
				<br>
				
				

              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
					<!-- fin detalle so -->
					
					<p name="detallelog1" id="detallelog1" ></p>		
					
				<!-- inicio tab -->
				<div class="card" style="position: relative; left: 0px; top: 0px;">
              <div class="card-header ui-sortable-handle" style="cursor: move;">
                <h3 class="card-title">
                  <i class="fas fa-chart-pie mr-1"></i>
                  Statistics
                </h3>
                <div class="card-tools">
                  <ul class="nav nav-pills ml-auto">
                    <li class="nav-item">
                      <a class="nav-link active" href="#revenue-chart" data-toggle="tab">Factory</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link " href="#sales-chart" data-toggle="tab">Eq</a>
                    </li>
					<li class="nav-item">
                      <a class="nav-link " href="#sales-3" data-toggle="tab">RF parameters</a>
                    </li>
                  </ul>
                </div>
              </div><!-- /.card-header -->
                <div class="tab-content p-0">

				<p name="msjwait" id="msjwait" align="center"><img src="img/waitazul.gif" width="100px" ></p>	
					<div class="progress" id="divhtml5" name="divhtml5">
						<br>
						<progress id="html5" max="100" value="0"></progress>
						<span>0%</span>
						<hr>
						<br>
					</div>


                  <!-- Morris chart - Sales -->
                  <div class="chart tab-pane active" id="revenue-chart" style="position: relative; "><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                    
				  		<!-- TAB 1 -->

						  <div class="row">
				 
								<div class="col-6  " id="divgrafico800uprx11" name="divgrafico800uprx11">
							
									<div class="chart" name="divGraph1" id="divGraph1">
										<canvas id="Graph1" height="280" style="height: 280;"></canvas>
									</div>
								</div>
								<div class="col-6  " id="divgrafico800uptx11" name="divgrafico800uptx11">
							
									<div class="chart" name="divGraph2" id="divGraph2">
										<canvas id="Graph2" height="280" style="height: 280;"></canvas>
									</div>
								</div>
								
									<div class="col-6  " id="divgrafico800uprx11" name="divgrafico800uprx11">
							
										<div class="chart" name="divGraph3" id="divGraph3">
											<canvas id="Graph3" height="280" style="height: 280;"></canvas>
										</div>
									</div>
									<div class="col-6  " id="divgrafico800uptx11" name="divgrafico800uptx11">

										<div class="chart" name="divGraph4" id="divGraph4">
											<canvas id="Graph4" height="280" style="height: 280;"></canvas>
										</div>
									</div>

							</div>

						    <div class="row">
								<div class="col-6  " id="divgrafico800uprx11" name="divgrafico800uprx11">
							
									<div class="chart" name="divGraph5" id="divGraph5">
										<canvas id="Graph5" height="280" style="height: 280;"></canvas>
									</div>
								</div>
								<div class="col-6  " id="divgrafico800uptx11" name="divgrafico800uptx11">

									<div class="chart" name="divGraph6" id="divGraph6">
										<canvas id="Graph6" height="280" style="height: 280;"></canvas>
									</div>
								</div>
						    </div>
							 
		 	 
						  <!-- FIN TAB 1 -->

                   </div>
                  <div class="chart tab-pane " id="sales-chart" style="position: relative; "><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>

				  	<!-- TAB 2 -->

					  <div class="row">
				 
								<div class="col-6  " id="divgrafico800uprx11" name="divgrafico800uprx11">
							
									<div class="chart" name="divGraph7" id="divGraph7">
										<canvas id="Graph7" height="280" style="height: 280;"></canvas>
									</div>
								</div>
								<div class="col-6  " id="divgrafico800uptx11" name="divgrafico800uptx11">
							
									<div class="chart" name="divGraph8" id="divGraph8">
										<canvas id="Graph8" height="280" style="height: 280;"></canvas>
									</div>
								</div>
								
									<div class="col-6  " id="divgrafico800uprx11" name="divgrafico800uprx11">
							
										<div class="chart" name="divGraph9" id="divGraph9">
											<canvas id="Graph9" height="280" style="height: 280;"></canvas>
										</div>
									</div>
									<div class="col-6  " id="divgrafico800uptx11" name="divgrafico800uptx11">

										<div class="chart" name="divGraph10" id="divGraph10">
											<canvas id="Graph10" height="280" style="height: 280;"></canvas>
										</div>
									</div>

					   </div>
					   <div class="row">
				 
								<div class="col-6  " id="divgrafico800uprx11" name="divgrafico800uprx11">
							
									<div class="chart" name="divGraph11" id="divGraph11">
										<canvas id="Graph11" height="280" style="height: 280;"></canvas>
									</div>
								</div>
								<div class="col-6  " id="divgrafico800uptx11" name="divgrafico800uptx11">
							
									<div class="chart" name="divGraph12" id="divGraph12">
										<canvas id="Graph12" height="280" style="height: 280;"></canvas>
									</div>
								</div>
								
									<div class="col-6  " id="divgrafico800uprx11" name="divgrafico800uprx11">
							
										<div class="chart" name="divGraph13" id="divGraph13">
											<canvas id="Graph13" height="280" style="height: 280;"></canvas>
										</div>
									</div>
									<div class="col-6  " id="divgrafico800uptx11" name="divgrafico800uptx11">

										<div class="chart" name="divGraph14" id="divGraph14">
											<canvas id="Graph14" height="280" style="height: 280;"></canvas>
										</div>
									</div>

						</div>
						<div class="row">
				 
								<div class="col-6  " id="divgrafico800uprx15" name="divgrafico800uprx15">
							
									<div class="chart" name="divGraph15" id="divGraph15">
										<canvas id="Graph15" height="280" style="height: 280;"></canvas>
									</div>
								</div>
								<div class="col-6  " id="divgrafico800uptx11" name="divgrafico800uptx11">
							
									<div class="chart" name="divGraph16" id="divGraph16">
										<canvas id="Graph16" height="280" style="height: 280;"></canvas>
									</div>
								</div>
								
									<div class="col-6  " id="divgrafico800uprx11" name="divgrafico800uprx11">
							
										<div class="chart" name="divGraph17" id="divGraph17">
											<canvas id="Graph17" height="280" style="height: 280;"></canvas>
										</div>
									</div>
									<div class="col-6  " id="divgrafico800uptx11" name="divgrafico800uptx11">

										<div class="chart" name="divGraph18" id="divGraph18">
											<canvas id="Graph18" height="280" style="height: 280;"></canvas>
										</div>
									</div>
									

									
						</div>		
				</div>		
					<div class="chart tab-pane " id="sales-3" style="position: relative; "><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>

<!-- TAB 3 --><div class="row">
									<div class="col-6  " id="divgrafico800uptx11" name="divgrafico800uptx11">
										<div class="chart" name="divGraph19" id="divGraph19">
											<canvas id="Graph19" height="280" style="height: 280;"></canvas>
										</div>
									</div>
									<div class="col-6  " id="divgrafico800uptx11" name="divgrafico800uptx11">
											<div class="chart" name="divGraph20" id="divGraph20">
												<canvas id="Graph20" height="280" style="height: 280;"></canvas>
											</div>
									</div>
								<div class="col-6  " id="divgrafico800uptx11" name="divgrafico800uptx11">

									<div class="chart" name="divGraph21" id="divGraph21">
										<canvas id="Graph21" height="280" style="height: 280;"></canvas>
									</div>
								</div>
								</div>
						</div>
			 <!-- FIN TAB 3 -->


                  </div>  
                </div>
              </div><!-- /.card-body -->
            </div>
				<!-- Fin tab -- >	

					
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
  
  <a href="#" class="ancla" data-ancla="anclamyTabledib"></a>
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


<!-- Toastr -->
<script src="toastr.min.js"></script>

<script src="licencefiplex_mm.js"></script>
<script src="licencefiplex1.js"></script>
<script src="js/jquery.inactivityTimeout.js"></script>
<script src="js/moment-timezone-with-data.js"></script>

<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- DataTables -->
<script src="<?php echo $folderservidor; ?>plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo $folderservidor; ?>plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script src="js/viewer.js"></script>
<script type="text/javascript" src="js/tabulator.min.js"></script>

<script src="js/popperparacalibratio.min.js"></script>
<script src="js/eModal.min.js" type="text/javascript" />
<script src="plugins/chart.js/Chart.min.js"></script>
<script src="plugins/chart.js/utils.js"></script>
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.4.1/chart.js" integrity="sha512-lUsN5TEogpe12qeV8NF4cxlJJatTZ12jnx9WXkFXOy7yFbuHwYRTjmctvwbRIuZPhv+lpvy7Cm9o8T9e+9pTrg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="js/animateprogress.js"></script>

<script src="js/viewer.js"></script>
	 <style>
		 
.tooltipmarco {
    background-color: #0053a1;
    color:  #ffffff;
    padding: 5px 10px;
    border-radius: 4px;
    font-size: 14px;
	 opacity: 0.9;
  }

  </style>
</body>

<script type="text/javascript">

var color = Chart.helpers.color;
 
 var data_volt = [];
   
	$( document ).ready(function() {
		
		//Inicio mostrar hora live
		 var interval = setInterval(function() {
			 
        var momentNow = moment();
			var newYork    = momentNow.tz('America/New_York').format('ha z');
			$('#date-part').html(momentNow.format('YYYY/MM/DD') 	  );
			$('#time-part').html(momentNow.format('hh:mm:ss'));
			}, 100);
		//FIN mostrar hora live
		//	console.log( "ready!" );
			$('#msjwaitline').hide();
			$("#msjwaitsn").hide();	
			$('#divscrolllog').show(); 
			$('#p-b0').hide();
			$('#p-b0').CardWidget('toggle');		
			$("#detallelog").hide();
			$("#detallelog").text("");
			$("#msjwait").hide();		
			$('#revenue-chart').removeClass('active');
			$('#sales-chart').removeClass('active');
			$('#divhtml5').addClass('d-none');

  
	 
				$("#divgeneralinfo").addClass('d-none');
				$("#divgeneralinfoparam").addClass('d-none');
				$("#divdetinfolog").addClass('d-none');
				
				$("#diveq").addClass('d-none');
				$("#divfactory").addClass('d-none');
				$("#divfinalcheck").addClass('d-none');
				$("#divgroupbyciu").addClass('d-none');
				
					$("#divgeneralinfo").removeClass('d-none');
				$("#divgeneralinfoparam").removeClass('d-none');
				$("#divdetinfolog").removeClass('d-none');

					$('#divFIP446').html("");
					$('#divFIP467').html("");
					$('#divFIP488').html("");

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

				$('#closebusqueda').show();
				$('#openbusqueda').hide();
				
				
	
    
	//iniciamos el Treeview


	 
		
///agregamos tree viewport
			
			
	});
	

	// controlar inactividad en la web	
	/*	$(document).inactivityTimeout({
                inactivityWait: 500,
                dialogWait: 100,
                logoutUrl: 'index.php?t=jquerytimeout'
            })
			*/
	// fin controlar inactividad en la web		
	
	 /* requesting data */
     		
		
	 	var table = $('#example2').DataTable();
 
	table.on( 'draw', function () { 
	//	console.log( 'Redraw occurred at: '+new Date().getTime() );
		$('.knob').knob({ 	})	
	} );
	
	$(function () {
  			$('.knob').knob({ 
			})

	})
	
	function promesa_busca_datos_returnloss (eldivgraph, elgraph, lainstancia, elidscripruntume, fechaabuscar,userruninfo,station, fechadenuevo, titlegraph)
	{
		$('#msjwait').show();
		$('#divhtml5').removeClass('d-none');
		var data_0_0=[];
	var data_0_1=[];
	var data_1_0=[];
	var data_1_1=[];

	var mediadata_0_0=[];
	var mediadata_0_1=[];
	var mediadata_1_0=[];
	var mediadata_1_1=[];

		return new Promise(function(resolve, reject) {
					var formData = new FormData();
					var req = new XMLHttpRequest();

					formData.append("lains", lainstancia);
					formData.append("idscrptp", elidscripruntume);
					formData.append("fb", fechaabuscar);
					formData.append("us", userruninfo);
					formData.append("wk", fechadenuevo);

			 
			req.open("POST", 'ajax_stationactivity1.php');
			req.send(formData);
			
				req.onload = function() {
				  if (req.status == 200) {

					porcentale = porcentale + 7;
					if (porcentale>100)
					{
					 
						
							$('#msjwait').hide();
							$('#divhtml5').addClass('d-none');
							$('#divlossn').removeClass('d-none');
							$('#revenue-chart').addClass('active');
							esta_buscando = 0;
						
					}
					else
					{
						if (porcentale<=100)
						{
							animateprogress("#html5",porcentale);
						}
					
						
					//	$('#divlossn').addClass('d-none');
						$('#revenue-chart').removeClass('active');
						$('#sales-chart').removeClass('active');
						$('#msjwait').show();
						

						
					}
					
						///	console.log(req.response);
						resolve(JSON.parse(req.response));
						///////
						var data =JSON.parse(req.response);

						band_0_0 = data[0].band_0_1;
					band_0_1 = data[0].band_0_1;

					band_1_0 = data[0].band_0_1;
					band_1_1 = data[0].band_0_1;
					
					band_0_0_min=data[0].band_0_1min;
					band_0_0_max=data[0].band_0_1max;

					band_0_1_min=data[0].band_0_1min;
					band_0_1_max=data[0].band_0_1max;

					band_1_0_min=data[0].band_0_1min;
					band_1_0_max=data[0].band_0_1max;

					band_1_1_min=data[0].band_0_1min;
					band_1_1_max=data[0].band_0_1max;
				
					losv_band_0_0 = band_0_0.split(',');
				//	console.log('elidscripruntume:' + elidscripruntume);
				//	console.log(losv_band_0_0);	
					losv_band_0_0.forEach(function(elvalordelarray, indexarray) {
						if ( parseFloat(elvalordelarray) === parseFloat(band_0_0_min)) { 
							losv_band_0_0.splice(indexarray, 1); 
						//	console.log('borrandoo' + elvalordelarray );
						}
						if ( parseFloat(elvalordelarray) === parseFloat(band_0_0_max)) 
						{ 
							losv_band_0_0.splice(indexarray, 1); 
						}
					});
/*					console.log('band_0_0_min'+ parseFloat(band_0_0_min));	
					console.log('band_0_0_max'+ parseFloat(band_0_0_max));	*/

					suma_losv_band_0_0=0;
					cant_losv_band_0_0=0;

					suma_losv_band_0_1=0;
					cant_losv_band_0_1=0;

					suma_losv_band_1_0=0;
					cant_losv_band_1_0=0;

					suma_losv_band_1_1=0;
					cant_losv_band_1_1=0;

				//	console.log(losv_band_0_0);	

					
					 losv_band_0_0.forEach(function(elvalordelarray, indexarray) {
						suma_losv_band_0_0 = parseFloat(suma_losv_band_0_0) + parseFloat(elvalordelarray);
						cant_losv_band_0_0 = cant_losv_band_0_0 + 1;
					});
					
					lamedia_0_0 = parseFloat(suma_losv_band_0_0)/cant_losv_band_0_0;
								
					

					var tot = losv_band_0_0.length ;
				 
					for (let i = 0; i < tot; i++) 
						{
						 
								data_0_0.push({
								y: losv_band_0_0[i],
								x: i
								});

								mediadata_0_0.push({
								y: lamedia_0_0,
								x: i
								});

							

						}
					
					losv_band_0_1 = band_0_1.split(',');
					//console.log(losv_band_0_1);	
					losv_band_0_1.forEach(function(elvalordelarray, indexarray) {
						if ( parseFloat(elvalordelarray) === parseFloat(band_0_1_min)) { 
							losv_band_0_1.splice(indexarray, 1); 
						//	console.log('borrandoo' + elvalordelarray );
						}
						if ( parseFloat(elvalordelarray) === parseFloat(band_0_1_max)) 
						{ 
							losv_band_0_1.splice(indexarray, 1); 
						}
					});

 
					losv_band_0_1.forEach(function(elvalordelarray, indexarray) {
						suma_losv_band_0_1 = parseFloat(suma_losv_band_0_1) + parseFloat(elvalordelarray);
						cant_losv_band_0_1 = cant_losv_band_0_1 + 1;
					});
					
					lamedia_0_1 = parseFloat(suma_losv_band_0_1)/cant_losv_band_0_1;

				//	console.log(losv_band_0_1);	
					var tot = losv_band_0_1.length ;
				 
					for (let i = 0; i < tot; i++) 
						{
						 
								data_0_1.push({
								y: losv_band_0_1[i],
								x: i
							});

							mediadata_0_1.push({
								y: lamedia_0_1,
								x: i
								});

						}

						losv_band_1_0 = band_1_0.split(',');
					//	console.log(losv_band_1_0);	
						losv_band_1_0.forEach(function(elvalordelarray, indexarray) {
						if ( parseFloat(elvalordelarray) === parseFloat(band_1_0_min)) { 
							losv_band_1_0.splice(indexarray, 1); 
						//	console.log('borrandoo' + elvalordelarray );
						}
						if ( parseFloat(elvalordelarray) === parseFloat(band_1_0_max)) 
						{ 
							losv_band_1_0.splice(indexarray, 1); 
						}
					});
				//	console.log(losv_band_1_0);	

				losv_band_1_0.forEach(function(elvalordelarray, indexarray) {
						suma_losv_band_1_0 = parseFloat(suma_losv_band_1_0) + parseFloat(elvalordelarray);
						cant_losv_band_1_0 = cant_losv_band_1_0 + 1;
					});
					
					lamedia_1_0 = parseFloat(suma_losv_band_1_0)/cant_losv_band_1_0;

						var tot = losv_band_1_0.length ;

				 for (let i = 0; i < tot; i++) 
					 {
					  
							 data_1_0.push({
							 y: losv_band_1_0[i],
							 x: i
						 });

						 mediadata_1_0.push({
								y: lamedia_1_0,
								x: i
								});

					 }

					 losv_band_1_1 = band_1_1.split(',');
					// console.log(losv_band_1_1);	
					 losv_band_1_1.forEach(function(elvalordelarray, indexarray) {
						if ( parseFloat(elvalordelarray) === parseFloat(band_1_1_min)) { 
							losv_band_1_1.splice(indexarray, 1); 
						//	console.log('borrandoo' + elvalordelarray );
						}
						if ( parseFloat(elvalordelarray) === parseFloat(band_1_1_max)) 
						{ 
							losv_band_1_1.splice(indexarray, 1); 
						}
					});
				//	console.log(losv_band_1_1);	

				losv_band_1_1.forEach(function(elvalordelarray, indexarray) {
						suma_losv_band_1_1 = parseFloat(suma_losv_band_1_1) + parseFloat(elvalordelarray);
						cant_losv_band_1_1 = cant_losv_band_1_1 + 1;
					});
					
			var	lamedia_1_1 = parseFloat(suma_losv_band_1_1)/cant_losv_band_1_1;

					 var tot = losv_band_1_1.length ;
				 
				 for (let i = 0; i < tot; i++) 
					 {
					  
							 data_1_1.push({
							 y: losv_band_1_1[i],
							 x: i
						 });

						 mediadata_1_1.push({
								y: lamedia_1_1,
								x: i
								});

					 }

				 
				 
					


					///////////////////////////////////////////////////////////////////////
					///// 1er grafico VOLTAGE
					var scatterChartData = {
					datasets: [
					 
						{
						type: 'scatter',
						label: 'Band',
						borderColor:'#001883',
						backgroundColor: color('#001883').alpha(0.9).rgbString(),
						data: data_0_0,
					} 
					  

					]
					};
	
					$('#'+eldivgraph).html(''); // this is my <canvas> element
  					$('#'+eldivgraph).append('	<canvas id="'+elgraph+'" height="280" style="height: 280;"></canvas>');
					var ctx = document.getElementById(elgraph).getContext('2d');

					if(myChart != null){
						myChart.destroy();
						}
					 
					///ctx.clearRect(0,0, ctx.canvas.width, ctx.canvas.height);

						///window.myScatter = Chart.Scatter(ctx, {
							var myChart = new Chart(ctx, {
							
							data: scatterChartData,
							options: {
								plugins: {
									title: {
										display: true,
										text: titlegraph
									}
								}
								
							}
						});
						

				 
 
							

					//	$('#msjwait').hide();
					///// FIN 	1er grafico VOLTAGE
					///////////////////////////////////////////////////////////////////////	
						///////////////////////////
					 
			 
				  }
				  else {
					reject();
				  }
				};

			
			});
	}	
	function promesa_busca_datos (eldivgraph, elgraph, lainstancia, elidscripruntume, fechaabuscar,userruninfo,station, fechadenuevo, titlegraph)
	{
		$('#msjwait').show();
		$('#divhtml5').removeClass('d-none');
		var data_0_0=[];
	var data_0_1=[];
	var data_1_0=[];
	var data_1_1=[];

	var mediadata_0_0=[];
	var mediadata_0_1=[];
	var mediadata_1_0=[];
	var mediadata_1_1=[];

		return new Promise(function(resolve, reject) {
					var formData = new FormData();
					var req = new XMLHttpRequest();

					formData.append("lains", lainstancia);
					formData.append("idscrptp", elidscripruntume);
					formData.append("fb", fechaabuscar);
					formData.append("us", userruninfo);
					formData.append("wk", fechadenuevo);

			 
			req.open("POST", 'ajax_stationactivity1.php');
			req.send(formData);
			
				req.onload = function() {
				  if (req.status == 200) {

					porcentale = porcentale + 7;
					if (porcentale>100)
					{
					 
						
							$('#msjwait').hide();
							$('#divhtml5').addClass('d-none');
							$('#divlossn').removeClass('d-none');
							$('#revenue-chart').addClass('active');
							esta_buscando = 0;
						
					}
					else
					{
						if (porcentale<=100)
						{
							animateprogress("#html5",porcentale);
						}
					
						
					//	$('#divlossn').addClass('d-none');
						$('#revenue-chart').removeClass('active');
						$('#sales-chart').removeClass('active');
						$('#msjwait').show();
						

						
					}
					
						///	console.log(req.response);
						resolve(JSON.parse(req.response));
						///////
						var data =JSON.parse(req.response);

						band_0_0 = data[0].band_0_0;
					band_0_1 = data[0].band_0_1;

					band_1_0 = data[0].band_1_0;
					band_1_1 = data[0].band_1_1;
					
					band_0_0_min=data[0].band_0_0min;
					band_0_0_max=data[0].band_0_0max;

					band_0_1_min=data[0].band_0_1min;
					band_0_1_max=data[0].band_0_1max;

					band_1_0_min=data[0].band_1_0min;
					band_1_0_max=data[0].band_1_0max;

					band_1_1_min=data[0].band_1_1min;
					band_1_1_max=data[0].band_1_1max;
				
					losv_band_0_0 = band_0_0.split(',');
				//	console.log('elidscripruntume:' + elidscripruntume);
				//	console.log(losv_band_0_0);	
					losv_band_0_0.forEach(function(elvalordelarray, indexarray) {
						if ( parseFloat(elvalordelarray) === parseFloat(band_0_0_min)) { 
							losv_band_0_0.splice(indexarray, 1); 
						//	console.log('borrandoo' + elvalordelarray );
						}
						if ( parseFloat(elvalordelarray) === parseFloat(band_0_0_max)) 
						{ 
							losv_band_0_0.splice(indexarray, 1); 
						}
					});
/*					console.log('band_0_0_min'+ parseFloat(band_0_0_min));	
					console.log('band_0_0_max'+ parseFloat(band_0_0_max));	*/

					suma_losv_band_0_0=0;
					cant_losv_band_0_0=0;

					suma_losv_band_0_1=0;
					cant_losv_band_0_1=0;

					suma_losv_band_1_0=0;
					cant_losv_band_1_0=0;

					suma_losv_band_1_1=0;
					cant_losv_band_1_1=0;

				//	console.log(losv_band_0_0);	

					
					 losv_band_0_0.forEach(function(elvalordelarray, indexarray) {
						suma_losv_band_0_0 = parseFloat(suma_losv_band_0_0) + parseFloat(elvalordelarray);
						cant_losv_band_0_0 = cant_losv_band_0_0 + 1;
					});
					
					lamedia_0_0 = parseFloat(suma_losv_band_0_0)/cant_losv_band_0_0;
								
					

					var tot = losv_band_0_0.length ;
				 
					for (let i = 0; i < tot; i++) 
						{
						 
								data_0_0.push({
								y: losv_band_0_0[i],
								x: i
								});

								mediadata_0_0.push({
								y: lamedia_0_0,
								x: i
								});

							

						}
					
					losv_band_0_1 = band_0_1.split(',');
					//console.log(losv_band_0_1);	
					losv_band_0_1.forEach(function(elvalordelarray, indexarray) {
						if ( parseFloat(elvalordelarray) === parseFloat(band_0_1_min)) { 
							losv_band_0_1.splice(indexarray, 1); 
						//	console.log('borrandoo' + elvalordelarray );
						}
						if ( parseFloat(elvalordelarray) === parseFloat(band_0_1_max)) 
						{ 
							losv_band_0_1.splice(indexarray, 1); 
						}
					});

 
					losv_band_0_1.forEach(function(elvalordelarray, indexarray) {
						suma_losv_band_0_1 = parseFloat(suma_losv_band_0_1) + parseFloat(elvalordelarray);
						cant_losv_band_0_1 = cant_losv_band_0_1 + 1;
					});
					
					lamedia_0_1 = parseFloat(suma_losv_band_0_1)/cant_losv_band_0_1;

				//	console.log(losv_band_0_1);	
					var tot = losv_band_0_1.length ;
				 
					for (let i = 0; i < tot; i++) 
						{
						 
								data_0_1.push({
								y: losv_band_0_1[i],
								x: i
							});

							mediadata_0_1.push({
								y: lamedia_0_1,
								x: i
								});

						}

						losv_band_1_0 = band_1_0.split(',');
					//	console.log(losv_band_1_0);	
						losv_band_1_0.forEach(function(elvalordelarray, indexarray) {
						if ( parseFloat(elvalordelarray) === parseFloat(band_1_0_min)) { 
							losv_band_1_0.splice(indexarray, 1); 
						//	console.log('borrandoo' + elvalordelarray );
						}
						if ( parseFloat(elvalordelarray) === parseFloat(band_1_0_max)) 
						{ 
							losv_band_1_0.splice(indexarray, 1); 
						}
					});
				//	console.log(losv_band_1_0);	

				losv_band_1_0.forEach(function(elvalordelarray, indexarray) {
						suma_losv_band_1_0 = parseFloat(suma_losv_band_1_0) + parseFloat(elvalordelarray);
						cant_losv_band_1_0 = cant_losv_band_1_0 + 1;
					});
					
					lamedia_1_0 = parseFloat(suma_losv_band_1_0)/cant_losv_band_1_0;

						var tot = losv_band_1_0.length ;

				 for (let i = 0; i < tot; i++) 
					 {
					  
							 data_1_0.push({
							 y: losv_band_1_0[i],
							 x: i
						 });

						 mediadata_1_0.push({
								y: lamedia_1_0,
								x: i
								});

					 }

					 losv_band_1_1 = band_1_1.split(',');
					// console.log(losv_band_1_1);	
					 losv_band_1_1.forEach(function(elvalordelarray, indexarray) {
						if ( parseFloat(elvalordelarray) === parseFloat(band_1_1_min)) { 
							losv_band_1_1.splice(indexarray, 1); 
						//	console.log('borrandoo' + elvalordelarray );
						}
						if ( parseFloat(elvalordelarray) === parseFloat(band_1_1_max)) 
						{ 
							losv_band_1_1.splice(indexarray, 1); 
						}
					});
				//	console.log(losv_band_1_1);	

				losv_band_1_1.forEach(function(elvalordelarray, indexarray) {
						suma_losv_band_1_1 = parseFloat(suma_losv_band_1_1) + parseFloat(elvalordelarray);
						cant_losv_band_1_1 = cant_losv_band_1_1 + 1;
					});
					
			var	lamedia_1_1 = parseFloat(suma_losv_band_1_1)/cant_losv_band_1_1;

					 var tot = losv_band_1_1.length ;
				 
				 for (let i = 0; i < tot; i++) 
					 {
					  
							 data_1_1.push({
							 y: losv_band_1_1[i],
							 x: i
						 });

						 mediadata_1_1.push({
								y: lamedia_1_1,
								x: i
								});

					 }

				 
				 
					


					///////////////////////////////////////////////////////////////////////
					///// 1er grafico VOLTAGE
					var scatterChartData = {
					datasets: [
					 
						{
						type: 'scatter',
						label: 'Band:0::0',
						borderColor:'#001883',
						backgroundColor: color('#001883').alpha(0.9).rgbString(),
						data: data_0_0,
					}, 
					{
						type: 'scatter',
						label: 'Band:0::1',					
						borderColor: '#1B2631',
						backgroundColor: color('#1B2631').alpha(0.9).rgbString(),	
						data: data_0_1,
					}, 
					
					{
						type: 'scatter',
						label: 'Band:1::0',
						borderColor: '#E8041F',
						backgroundColor: color('#E8041F').alpha(0.9).rgbString(),				
						data: data_1_0,
					}, 
					 
					{
						type: 'scatter',
						label: 'Band:1::1',
						borderColor: '#0E9E43',
						backgroundColor: color('#0E9E43').alpha(0.9).rgbString(),
						data: data_1_1,
					}, 					
					 {
						type: 'line',
						label: 'Mean_0_0',
						data: mediadata_0_0,
						fill: false,
						borderColor: '#001883'
					}, 					
					 {
						type: 'line',
						label: 'Mean_0_1',
						data: mediadata_0_1,
						fill: false,
						borderColor: '#1B2631'
					}, 					
					 {
						type: 'line',
						label: 'Mean_1_0',
						data: mediadata_1_0,
						fill: false,
						borderColor: '#E8041F'
					}, 					
					 {
						type: 'line',
						label: 'Mean_1_1',
						data: mediadata_1_1,
						fill: false,
						borderColor: '#0E9E43'
					}

					]
					};
	
					$('#'+eldivgraph).html(''); // this is my <canvas> element
  					$('#'+eldivgraph).append('	<canvas id="'+elgraph+'" height="280" style="height: 280;"></canvas>');
					var ctx = document.getElementById(elgraph).getContext('2d');

					if(myChart != null){
						myChart.destroy();
						}
					 
					///ctx.clearRect(0,0, ctx.canvas.width, ctx.canvas.height);

						///window.myScatter = Chart.Scatter(ctx, {
							var myChart = new Chart(ctx, {
							
							data: scatterChartData,
							options: {
								plugins: {
									title: {
										display: true,
										text: titlegraph
									}
								}
								
							}
						});
						

				 
 
							

					//	$('#msjwait').hide();
					///// FIN 	1er grafico VOLTAGE
					///////////////////////////////////////////////////////////////////////	
						///////////////////////////
					 
			 
				  }
				  else {
					reject();
				  }
				};

			
			});

	}	
	
	function abrirgaleria(qimgsendclick)
{
	document.getElementById(qimgsendclick).click();
}
  
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
	
	function validateMyForm()
		{
			return false;
		}

		var porcentale = 0;
		var esta_buscando = 0;
 function armar_graficos_xrun(objelemnt, fechaabuscar,userruninfo, station, fechadenuevo )
 {
	porcentale = 0;

		console.log('a ver'+ objelemnt  );

			if (esta_buscando ==0 )
				{
					esta_buscando = 1;

					listarsn(fechaabuscar,userruninfo,station, fechadenuevo);
			
					promesa_busca_datos('divGraph1','Graph1','002007030',24, fechaabuscar,userruninfo,station, fechadenuevo, 'Level OffSet');
					promesa_busca_datos('divGraph1','Graph1','002007030',24, fechaabuscar,userruninfo,station, fechadenuevo, 'Level OffSet');
					promesa_busca_datos('divGraph2','Graph2','002007030',25, fechaabuscar,userruninfo,station, fechadenuevo, 'Sq offset');
					promesa_busca_datos('divGraph3','Graph3','002007030',26, fechaabuscar,userruninfo,station, fechadenuevo, 'Gain offset');
					promesa_busca_datos('divGraph4','Graph4','002007030',27, fechaabuscar,userruninfo,station, fechadenuevo, 'Power offset');

					promesa_busca_datos('divGraph5','Graph5','002007030',39, fechaabuscar,userruninfo,station, fechadenuevo, 'paCurrentMin');
					promesa_busca_datos('divGraph6','Graph6','002007030',40, fechaabuscar,userruninfo,station, fechadenuevo, 'paCurrentMax');

					promesa_busca_datos('divGraph7','Graph7','002007030',0, fechaabuscar,userruninfo,station, fechadenuevo, 'EQ Rx Real coef0');
					promesa_busca_datos('divGraph8','Graph8','002007030',1, fechaabuscar,userruninfo,station, fechadenuevo, 'EQ Rx Real coef1');
					promesa_busca_datos('divGraph9','Graph9','002007030',2, fechaabuscar,userruninfo,station, fechadenuevo, 'EQ Rx Real coef2');
					promesa_busca_datos('divGraph10','Graph10','002007030',3, fechaabuscar,userruninfo,station, fechadenuevo, 'EQ Rx Real coef3');

					promesa_busca_datos('divGraph11','Graph11','002007030',4, fechaabuscar,userruninfo,station, fechadenuevo, 'EQ Rx Real coef4');
					promesa_busca_datos('divGraph12','Graph12','002007030',5, fechaabuscar,userruninfo,station, fechadenuevo, 'EQ Rx Real coef5');
					promesa_busca_datos('divGraph13','Graph13','002007030',18, fechaabuscar,userruninfo,station, fechadenuevo, 'EQ Tx Imag coef0');
					promesa_busca_datos('divGraph14','Graph14','002007030',19, fechaabuscar,userruninfo,station, fechadenuevo, 'EQ Tx Imag coef1');

					promesa_busca_datos('divGraph15','Graph15','002007030',20, fechaabuscar,userruninfo,station, fechadenuevo, 'EQ Tx Imag coef2');
					promesa_busca_datos('divGraph16','Graph16','002007030',21, fechaabuscar,userruninfo,station, fechadenuevo, 'EQ Tx Imag coef3');
					promesa_busca_datos('divGraph17','Graph17','002007030',22, fechaabuscar,userruninfo,station, fechadenuevo, 'EQ Tx Imag coef4');
					promesa_busca_datos('divGraph18','Graph18','002007030',23, fechaabuscar,userruninfo,station, fechadenuevo, 'EQ Tx Imag coef5');


					promesa_busca_datos_returnloss('divGraph19','Graph19','00108F090091',48, fechaabuscar,userruninfo,station, fechadenuevo, 'ReturnLoss Loaded');
					promesa_busca_datos_returnloss('divGraph20','Graph20','00108F090092',57, fechaabuscar,userruninfo,station, fechadenuevo, 'Return Loss Threshold');
					promesa_busca_datos_returnloss('divGraph121','Graph21','00108F090092',48, fechaabuscar,userruninfo,station, fechadenuevo, 'ReturnLoss Unloaded');



					
				}
				else
				{
					alert('Search not finished, please wait a moment');
				}
		
		
			
 }


    
 function create_graph_dispersion(eldivgraph, elgraph, lainstancia, elidscripruntume, fechaabuscar,userruninfo,station, fechadenuevo, titlegraph)
{
	
	var ctx = document.getElementById(elgraph).getContext('2d');
					ctx.clearRect(0,0, ctx.canvas.width, ctx.canvas.height);
// listarsn
	var data_0_0=[];
	var data_0_1=[];
	var data_1_0=[];
	var data_1_1=[];

	var mediadata_0_0=[];
	var mediadata_0_1=[];
	var mediadata_1_0=[];
	var mediadata_1_1=[];

		$('#msjwait').show();
			$("#divlossn").removeClass('d-none');   

 var datashow_volt="[";
	$.ajax
			({ 
				url: 'ajax_stationactivity.php?lains='+lainstancia+'&idscrptp='+elidscripruntume+'&fb='+fechaabuscar+'&us='+userruninfo+'&wk='+fechadenuevo,
				data: "idlog=2",	
				type: 'post',
				async:true,
                cache:false,
				success: function(data)
				{
					

					band_0_0 = data[0].band_0_0;
					band_0_1 = data[0].band_0_1;

					band_1_0 = data[0].band_1_0;
					band_1_1 = data[0].band_1_1;
					
					band_0_0_min=data[0].band_0_0min;
					band_0_0_max=data[0].band_0_0max;

					band_0_1_min=data[0].band_0_1min;
					band_0_1_max=data[0].band_0_1max;

					band_1_0_min=data[0].band_1_0min;
					band_1_0_max=data[0].band_1_0max;

					band_1_1_min=data[0].band_1_1min;
					band_1_1_max=data[0].band_1_1max;
				
					losv_band_0_0 = band_0_0.split(',');
					console.log('elidscripruntume:' + elidscripruntume);
					console.log(losv_band_0_0);	
					losv_band_0_0.forEach(function(elvalordelarray, indexarray) {
						if ( parseFloat(elvalordelarray) === parseFloat(band_0_0_min)) { 
							losv_band_0_0.splice(indexarray, 1); 
						//	console.log('borrandoo' + elvalordelarray );
						}
						if ( parseFloat(elvalordelarray) === parseFloat(band_0_0_max)) 
						{ 
							losv_band_0_0.splice(indexarray, 1); 
						}
					});
/*					console.log('band_0_0_min'+ parseFloat(band_0_0_min));	
					console.log('band_0_0_max'+ parseFloat(band_0_0_max));	*/

					suma_losv_band_0_0=0;
					cant_losv_band_0_0=0;

					suma_losv_band_0_1=0;
					cant_losv_band_0_1=0;

					suma_losv_band_1_0=0;
					cant_losv_band_1_0=0;

					suma_losv_band_1_1=0;
					cant_losv_band_1_1=0;

					console.log(losv_band_0_0);	

					
					 losv_band_0_0.forEach(function(elvalordelarray, indexarray) {
						suma_losv_band_0_0 = parseFloat(suma_losv_band_0_0) + parseFloat(elvalordelarray);
						cant_losv_band_0_0 = cant_losv_band_0_0 + 1;
					});
					
					lamedia_0_0 = parseFloat(suma_losv_band_0_0)/cant_losv_band_0_0;
								
					

					var tot = losv_band_0_0.length ;
				 
					for (let i = 0; i < tot; i++) 
						{
						 
								data_0_0.push({
								y: losv_band_0_0[i],
								x: i
								});

								mediadata_0_0.push({
								y: lamedia_0_0,
								x: i
								});

							

						}
					
					losv_band_0_1 = band_0_1.split(',');
					//console.log(losv_band_0_1);	
					losv_band_0_1.forEach(function(elvalordelarray, indexarray) {
						if ( parseFloat(elvalordelarray) === parseFloat(band_0_1_min)) { 
							losv_band_0_1.splice(indexarray, 1); 
						//	console.log('borrandoo' + elvalordelarray );
						}
						if ( parseFloat(elvalordelarray) === parseFloat(band_0_1_max)) 
						{ 
							losv_band_0_1.splice(indexarray, 1); 
						}
					});

 
					losv_band_0_1.forEach(function(elvalordelarray, indexarray) {
						suma_losv_band_0_1 = parseFloat(suma_losv_band_0_1) + parseFloat(elvalordelarray);
						cant_losv_band_0_1 = cant_losv_band_0_1 + 1;
					});
					
					lamedia_0_1 = parseFloat(suma_losv_band_0_1)/cant_losv_band_0_1;

				//	console.log(losv_band_0_1);	
					var tot = losv_band_0_1.length ;
				 
					for (let i = 0; i < tot; i++) 
						{
						 
								data_0_1.push({
								y: losv_band_0_1[i],
								x: i
							});

							mediadata_0_1.push({
								y: lamedia_0_1,
								x: i
								});

						}

						losv_band_1_0 = band_1_0.split(',');
					//	console.log(losv_band_1_0);	
						losv_band_1_0.forEach(function(elvalordelarray, indexarray) {
						if ( parseFloat(elvalordelarray) === parseFloat(band_1_0_min)) { 
							losv_band_1_0.splice(indexarray, 1); 
						//	console.log('borrandoo' + elvalordelarray );
						}
						if ( parseFloat(elvalordelarray) === parseFloat(band_1_0_max)) 
						{ 
							losv_band_1_0.splice(indexarray, 1); 
						}
					});
				//	console.log(losv_band_1_0);	

				losv_band_1_0.forEach(function(elvalordelarray, indexarray) {
						suma_losv_band_1_0 = parseFloat(suma_losv_band_1_0) + parseFloat(elvalordelarray);
						cant_losv_band_1_0 = cant_losv_band_1_0 + 1;
					});
					
					lamedia_1_0 = parseFloat(suma_losv_band_1_0)/cant_losv_band_1_0;

						var tot = losv_band_1_0.length ;

				 for (let i = 0; i < tot; i++) 
					 {
					  
							 data_1_0.push({
							 y: losv_band_1_0[i],
							 x: i
						 });

						 mediadata_1_0.push({
								y: lamedia_1_0,
								x: i
								});

					 }

					 losv_band_1_1 = band_1_1.split(',');
					// console.log(losv_band_1_1);	
					 losv_band_1_1.forEach(function(elvalordelarray, indexarray) {
						if ( parseFloat(elvalordelarray) === parseFloat(band_1_1_min)) { 
							losv_band_1_1.splice(indexarray, 1); 
						//	console.log('borrandoo' + elvalordelarray );
						}
						if ( parseFloat(elvalordelarray) === parseFloat(band_1_1_max)) 
						{ 
							losv_band_1_1.splice(indexarray, 1); 
						}
					});
				//	console.log(losv_band_1_1);	

				losv_band_1_1.forEach(function(elvalordelarray, indexarray) {
						suma_losv_band_1_1 = parseFloat(suma_losv_band_1_1) + parseFloat(elvalordelarray);
						cant_losv_band_1_1 = cant_losv_band_1_1 + 1;
					});
					
			var	lamedia_1_1 = parseFloat(suma_losv_band_1_1)/cant_losv_band_1_1;

					 var tot = losv_band_1_1.length ;
				 
				 for (let i = 0; i < tot; i++) 
					 {
					  
							 data_1_1.push({
							 y: losv_band_1_1[i],
							 x: i
						 });

						 mediadata_1_1.push({
								y: lamedia_1_1,
								x: i
								});

					 }

				 
				 
					


					///////////////////////////////////////////////////////////////////////
					///// 1er grafico VOLTAGE
					var scatterChartData = {
					datasets: [
					 
						{
						type: 'scatter',
						label: 'Band:0::0',
						borderColor:'#001883',
						backgroundColor: color('#001883').alpha(0.9).rgbString(),
						data: data_0_0,
					}, 
					{
						type: 'scatter',
						label: 'Band:0::1',					
						borderColor: '#1B2631',
						backgroundColor: color('#1B2631').alpha(0.9).rgbString(),	
						data: data_0_1,
					}, 
					
					{
						type: 'scatter',
						label: 'Band:1::0',
						borderColor: '#E8041F',
						backgroundColor: color('#E8041F').alpha(0.9).rgbString(),				
						data: data_1_0,
					}, 
					 
					{
						type: 'scatter',
						label: 'Band:1::1',
						borderColor: '#0E9E43',
						backgroundColor: color('#0E9E43').alpha(0.9).rgbString(),
						data: data_1_1,
					}, 					
					 {
						type: 'line',
						label: 'Mean_0_0',
						data: mediadata_0_0,
						fill: false,
						borderColor: '#001883'
					}, 					
					 {
						type: 'line',
						label: 'Mean_0_1',
						data: mediadata_0_1,
						fill: false,
						borderColor: '#1B2631'
					}, 					
					 {
						type: 'line',
						label: 'Mean_1_0',
						data: mediadata_1_0,
						fill: false,
						borderColor: '#E8041F'
					}, 					
					 {
						type: 'line',
						label: 'Mean_1_1',
						data: mediadata_1_1,
						fill: false,
						borderColor: '#0E9E43'
					}

					]
					};
	
					$('#'+eldivgraph).html(''); // this is my <canvas> element
  					$('#'+eldivgraph).append('	<canvas id="'+elgraph+'" height="280" style="height: 280;"></canvas>');
					var ctx = document.getElementById(elgraph).getContext('2d');

					if(myChart != null){
						myChart.destroy();
						}
					 
					///ctx.clearRect(0,0, ctx.canvas.width, ctx.canvas.height);

						///window.myScatter = Chart.Scatter(ctx, {
							var myChart = new Chart(ctx, {
							
							data: scatterChartData,
							options: {
								plugins: {
									title: {
										display: true,
										text: titlegraph
									}
								}
								
							}
						});
						

				 
 
							

					//	$('#msjwait').hide();
					///// FIN 	1er grafico VOLTAGE
					///////////////////////////////////////////////////////////////////////			
				}
			});

}

   


function json2array(json){
    var result = [];
    var keys = Object.keys(json);
    keys.forEach(function(key){
        result.push(json[key]);
    });
    return result;
}
/////auto add column
		function AddNewCol(colNum, datos)
        {
            var myTable = $('#myTable');
            var colCount = myTable.find('td[data-row=0]').length;
            var rowCount = $("#myTable tr").length;
 
            //incriment id numbers to make room for the new column
            myTable_IncrimentColIdNumber(colNum, 1);
			
			var arram = [];
			 arram.push( json2array(datos));
			//console.log ("arraycolumno"+arram[0][2]);
			
            //add new column by adding a new cell to each row
            for (row = 0; row < rowCount; row++) {
                //add a new cell after the cell for the previous column
				//console.log ("arraycolumno"+arram[0][row]);
                $('td[data-row=' + row + '][data-col=' + (parseInt(colNum)-1) + ']').after('<td data-row="'+ row +'" data-col="' +colNum+ '"> '+arram[0][row]+'</td>');
            }
        }
		
		function myTable_DelRow(row) {
				$('tr[data-row=' + row + ']').remove();
			 
				myTable_IncrimentRowIdNumber(row, -1);
			}
			
			function myTable_DelRowchanel(row) {
				$('tr[data-rowchanel=' + row + ']').remove();
			 
				myTable_IncrimentRowIdNumber(row, -1);
			}
			
			
 
		function myTable_DelCol(col) {
			$('td[data-col=' + parseInt(col) + ']').remove();
			myTable_IncrimentColIdNumber(col, -1);
		}
		
		function myTable_DelColchanel(col) {
			$('td[data-colchanel=' + parseInt(col) + ']').remove();
			myTable_IncrimentColIdNumber(col, -1);
		}
 
		function myTable_IncrimentColIdNumber(startPosition, increment) {
 
            //increment column id's
            var cells = $('myTable td[data-col]');
 
            //foreach cell
            for (i = 0; i < cells.length ; i++) {
 
                var colNum = parseInt(cells.eq(i).attr('data-col'));
 
                //for every column beyond the insertion point, increment the column number
                if (colNum >= startPosition) {
                    var newId = colNum + parseInt(increment);
                    cells.eq(i).attr('data-col', newId);
                }
            }
        }
		
		function myTable_IncrimentRowIdNumber(startPosition, increment) {
            //get all the items with the data-row attr. - this will include tr and td
            var items = $('[data-row]');
 
            //for each item with a data-row attr. increment the value
            for (i = 0; i < items.length; i++) {
                //get the current value
                var rowNum = parseInt(items.eq(i).attr('data-row'));
 
                //only update the rows that are after the new inserted row
                if (rowNum >= startPosition) {
                    //generate the new value and update the item
                    var newId = rowNum + parseInt(increment);
                    items.eq(i).attr('data-row', newId);
                }
            }
        }
		
		function AddNewRow(row) {
            //using jquery, grab a reference to the html table
            var myTable = $('#myTable');
            //get the number of rows and columns
            var colCount = myTable.find('generalinfo, td[data-row=0]').length;
            var rowCount = $("#myTable tr").length;
 
            //incriment position numbers to make room for the new row
            //this is required to keep things working after we change the table
            myTable_IncrimentRowIdNumber(row, 1);
 
            //add row
            var newRow = '<tr data-row="' + row + '">';
            //add cells into the row
            for (addCol = 0; addCol < colCount; addCol++) {
                newRow += '<td data-row="'+ row +'" data-col="' +addCol+ '"> </td>';
            }
            //close the row
            newRow += '</tr>';
            //add the new row after the previous row in the table - the magic of jquery :)
            $(newRow).insertAfter('generalinfo, tr[data-row=' + (parseInt(row) - 1) + ']');
        }
		
			function AddNewRowchanel(row,datos,addnomtablemodif) {
            //using jquery, grab a reference to the html table
            var myTable = $('#myTable'+addnomtablemodif);
            //get the number of rows and columns
            var colCount = myTable.find('td[data-rowacffreq=0]').length;
            var rowCount = $("#myTable"+addnomtablemodif+" tr").length;
 
            //incriment position numbers to make room for the new row
            //this is required to keep things working after we change the table
            myTable_IncrimentRowIdNumber(row, 1);
			//console.log("nuevo row CHANEL");
			var arramch = [];
			 arramch.push( json2array(datos));
            //add row
            var newRow = '<tr data-rowacffreq="' + row + '">';
            //add cells into the row
            for (addCol = 0; addCol < colCount; addCol++) {
				//console.log('a'+addCol+'--'+arramch[0][row]+'****' +arramch[0][addCol] );			
                newRow += '<td data-rowacffreq="'+ row +'" data-colacffreq="' +addCol+ '">'+arramch[0][row]+' </td>';
            }
            //close the row
            newRow += '</tr>';
            //add the new row after the previous row in the table - the magic of jquery :)
            $(newRow).insertAfter('tr[data-rowacffreq=' + (parseInt(row) - 1) + ']');
        }
		
		function AddNewRowchanelacf(row,datos,addnomtablemodif) {
            //using jquery, grab a reference to the html table
            var myTable = $('#myTable'+addnomtablemodif);
            //get the number of rows and columns
            var colCount = myTable.find('td[data-rowacffreq=0]').length;
            var rowCount = $("#myTable"+addnomtablemodif+" tr").length;
 
            //incriment position numbers to make room for the new row
            //this is required to keep things working after we change the table
            myTable_IncrimentRowIdNumber(row, 1);
			//console.log("nuevo row CHANEL");
			var arramch = [];
			 arramch.push( json2array(datos));
            //add row
            var newRow = '<tr data-rowacffreq="' + row + '">';
            //add cells into the row
            for (addCol = 0; addCol < colCount; addCol++) {
				//console.log('a'+addCol+'--'+arramch[0][row]+'****' +arramch[0][addCol] );			
                newRow += '<td data-rowacffreq="'+ row +'" data-colacffreq="' +addCol+ '">'+arramch[0][addCol]+' </td>';
            }
            //close the row
            newRow += '</tr>';
            //add the new row after the previous row in the table - the magic of jquery :)
            $(newRow).insertAfter('tr[data-rowacffreq=' + (parseInt(row) - 1) + ']');
        }
		
		
		///funciones para DL
		/////auto add column
function AddNewColdl(colNum, datos,addnomtablemodif)
        {
            var myTable = $('#myTable'+addnomtablemodif);
            var colCount = myTable.find('td[data-row'+addnomtablemodif+'=0]').length;
            var rowCount = $("#myTable"+addnomtablemodif+" tr").length;
 
            //incriment id numbers to make room for the new column
            myTable_IncrimentColIdNumberdl(colNum, 1,addnomtablemodif);
			
			var arram = [];
			 arram.push( json2array(datos));
			///console.log ('aaaa:'+arram[0][2]);
			
            //add new column by adding a new cell to each row
            for (row = 0; row < rowCount; row++) {
                //add a new cell after the cell for the previous column
				if (row==0)
				{
				$('td[data-row'+addnomtablemodif+'=' + row + '][data-col'+addnomtablemodif+'=' + (parseInt(colNum)-1) + ']').after('<td data-row'+addnomtablemodif+'="'+ row +'" data-col'+addnomtablemodif+'="' +colNum+ '" class="table-info"> '+arram[0][row]+'</td>');	
				}
				else
				{
				$('td[data-row'+addnomtablemodif+'=' + row + '][data-col'+addnomtablemodif+'=' + (parseInt(colNum)-1) + ']').after('<td data-row'+addnomtablemodif+'="'+ row +'" data-col'+addnomtablemodif+'="' +colNum+ '" > '+arram[0][row]+'</td>');	
				}
                
            }
        }
		
		function print_r(printthis, returnoutput) {
    var output = '';

    if($.isArray(printthis) || typeof(printthis) == 'object') {
        for(var i in printthis) {
            output += i + ' : ' + print_r(printthis[i], true) + '\n';
        }
    }else {
        output += printthis;
    }
    if(returnoutput && returnoutput == true) {
        return output;
    }else {
        alert(output);
    }
}
		
		function AddNewColchanel(colNum, datos,addnomtablemodif)
        {
            var myTable = $('#myTable'+addnomtablemodif);
            var colCount = myTable.find('td[data-row'+addnomtablemodif+'=0]').length;
            var rowCount = $("#myTable"+addnomtablemodif+" tr").length;
 
            //incriment id numbers to make room for the new column
            myTable_IncrimentColIdNumberdl(colNum, 1,addnomtablemodif);
			
			var arram = [];
			var cantvacios=0;
			 arram.push( json2array(datos));
			//console.log ('new ro chanel:'+arram[0][2]+'-ch'+arram[0][1]);
			
            //add new column by adding a new cell to each row
            for (row = 0; row < rowCount; row++) {
                //add a new cell after the cell for the previous column
				//console.log('DAto a mostrar:'+arram[0][row]);
				if (arram[0][row]!= '')
				{
                $('td[data-row'+addnomtablemodif+'=' + row + '][data-col'+addnomtablemodif+'=' + (parseInt(colNum)-1) + ']').after('<td data-row'+addnomtablemodif+'="'+ row +'" data-col'+addnomtablemodif+'="' +colNum+ '"> '+arram[0][row]+'</td>');
				}
				else
				{
					cantvacios=cantvacios+1;
					myTable_DelRowchanel(row);
				}
            }
			
        }
		
		function AddNewColchanelsindato(colNum, datos,addnomtablemodif)
		{
			 var myTable = $('#myTable'+addnomtablemodif);
            var colCount = myTable.find('td[data-row'+addnomtablemodif+'=0]').length;
            var rowCount = $("#myTable"+addnomtablemodif+" tr").length;
 
            //incriment id numbers to make room for the new column
            myTable_IncrimentColIdNumberdl(colNum, 1,addnomtablemodif);
			
			var arram = [];
			 arram.push( json2array(datos));
			//console.log ('new ro chanel:'+arram[0][2]+'-ch'+arram[0][1]);
			
            //add new column by adding a new cell to each row
            for (row = 0; row < rowCount; row++) {
                //add a new cell after the cell for the previous column
                $('td[data-row'+addnomtablemodif+'=' + row + '][data-col'+addnomtablemodif+'=' + (parseInt(colNum)-1) + ']').after('<td data-row'+addnomtablemodif+'="'+ row +'" data-col'+addnomtablemodif+'="' +colNum+ '">  </td>');
            }
		}
 
		function myTable_IncrimentColIdNumberdl(startPosition, increment,addnomtablemodif2) {
 
            //increment column id's
            var cells = $('myTable'+addnomtablemodif2+' td[data-col'+addnomtablemodif2+' ]');
 
            //foreach cell
            for (i = 0; i < cells.length ; i++) {
 
                var colNum = parseInt(cells.eq(i).attr('data-col'+addnomtablemodif2+' '));
 
                //for every column beyond the insertion point, increment the column number
                if (colNum >= startPosition) {
                    var newId = colNum + parseInt(increment);
                    cells.eq(i).attr('data-col'+addnomtablemodif2, newId);
                }
            }
        }
		
		function filtraplacas()
		{
		//	 $("#txtacceptbusca").val();
		
			$("#Page2").addClass('show');
			$("#Page3").addClass('show');
			$("#Page4").addClass('show');
			$("#Page5").addClass('show');
			$("#Page5").addClass('show');
			
			$(".marcoopen").addClass('show');
			
		  // Declare variables
		  var input, filter, ul, li, a, i, txtValue;
		  input = $("#txtacceptbusca").val();
		  filter = $("#txtacceptbusca").val();
	
		//  li = document.getElementsByClassName('sui-treeview-item');
		  	  li = document.getElementsByClassName('treemm');
		 
		 var cantencontrado = 0;
		  // Loop through all list items, and hide those who don't match the search query
		 
		  for (i = 0; i < li.length; i++) 
		  {
				a = li[i];
				txtValue = a.textContent || a.innerText;		  
				if (txtValue.toUpperCase().indexOf(filter) > -1) 
				{
				li[i].style.display = "";
			//	console.log('ok' + txtValue +'a verrr:'+ a.style.display);
				cantencontrado= cantencontrado+ 1 ;
				} else 
				{
				//	console.log('none' + txtValue + '--'+a.css+"otr:"+ a.style.display);
				li[i].style.display = "none";
				}
			
		  } 
		   if(cantencontrado >0)
		   {
			toastr["success"](cantencontrado +" Results found", "");
		   }
		   else
		   {
			toastr["warning"]("0 Results found", "");

		   }
	
					$('[class="treeview"]:not(li:contains("6092"))').remove();

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
		
			function openpopupframe2( sncomponet)
	{
		
		var ipservidorapache= '<?php echo $ipservidorapache; ?>';	
		eModal.iframe('https://'+ipservidorapache+'/acceptflex.php?idsndib='+sncomponet,'Information');
		
	}
	function openpopupframe448( sncomponet)
	{
		
		var ipservidorapache= '<?php echo $ipservidorapache; ?>';	
		eModal.iframe('https://'+ipservidorapache+'/acceptflex488.php?idsndib='+sncomponet,'Information');
		
	}
	
	
	function listarsn( parafecha, parastation, stationamosrar, idrunrun)
	{
		$('#divlossn').html("");
			$('#msjwaitsn').show();
			$('#msjwaitsn').removeClass('d-none');
			$("#divlossn").removeClass('d-none');   


			var armando_tabla ="";
		$.ajax({
				url: 'stationactivity_ajax_sn.php?pf='+parafecha+'&pst='+parastation+'&station='+stationamosrar+'&idrun='+idrunrun,										
				 cache:false,
				success: function(respuesta) {
					
					armando_tabla=respuesta;
					
									
			
			//console.log('abrir div'+respuesta);
					$('#divlossn').html("");
					$('#divlossn').html(""+armando_tabla);
					$("#divlossn").removeClass('d-none'); 
					$('#msjwaitsn').addClass('d-none'); 

				//	$('#msjwait').hide();
				},
				error: function() {
					console.log("No se ha podido obtener la información");
					$('divlossn').html("");
				}
			});
									
									
									
	}
	
	 function  callsupportit (idlog_view2, datosref)
 {
	// alert(datosref);
	 
	 
	 var userregistred = <?php echo "'".$_SESSION["b"]."'";?>;
	 var options = {
        message: " <div class='form-group'>Type: <select id='idtipoproblema' name='idtipoproblema' class='form-control form-control-sm'><option value='1'>CIU Confidential</option><option value='2'>Engineering Issue</option>	<option value='3'>FAS Bug</option><option value='4'>HW Issue</option><option value='5'>SO Issue</option><option value='6'>SOSPEC Issue</option><option value='7'>Specs issue</option><option value='8'>Webfas Bug</option></select></div> Issue:?  ",		
        title: 'Tech Support FAS',
        size: eModal.size.lg,
        subtitle: 'open an error ticket:  ' 
       
    };
	
		
	  
	     return eModal
                .prompt(options)
                .then(
                    function (input) {
					//alert(input);
					toastr["info"]("Sending information...", "");			
					$.ajax({
				url: 'ajaxinsert_supportit.php', 				
				data: "idruninfodb="+idlog_view2+'&v_issue='+input+'-Ref:'+datosref+'&vuser='+userregistred+'&tp='+$('#idtipoproblema').val()+'&keyd='+datosref,	
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
                    function (
					) { $('#lbldatoserrr').html("ERROR: <br>"+resulterr); });
					
	 
 }


 function Call_printlabel_todos(vpara_ciu, vparamidorders, snunit)
	{
				console.log('si' + vpara_ciu);
				var ipservidorapache= '<?php echo $ipservidorapache; ?>';	
		eModal.iframe('https://'+ipservidorapache+'/labelprintermultisn.php?vciu='+vpara_ciu+'&vidord='+vparamidorders+'&snunit='+snunit,'Label printing');
		$('.embed-responsive-item').height(380);
	//	console.log('si');
		

				setTimeout(function() {
								$('.embed-responsive-item').height(620);
							},300);
							
	}	
   
</script>

</html>

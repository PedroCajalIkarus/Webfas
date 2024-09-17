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
            header("Location: http://".$ipservidorapache."/index.php?t=timeoutinactivity");
        }
    }
	else
	{
			session_unset();
            session_destroy();
            header("Location: http://".$ipservidorapache."/index.php?t=notcookietimeout");
        
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

  <!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- DataTables -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- DataTables -->
<script src="<?php echo $folderservidor; ?>plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo $folderservidor; ?>plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script src="js/dataTables.rowGroup.min.js"></script>
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
            <h1>Acceptance </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Acceptance</li>
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
			
			  <div class="demo-container">
  
			
						
			<p name="msjwaitline" id="msjwaitline" align="center"><img src="img/waitazul.gif" width="100px" ></p>	
				<div class="card">
				
				<!-- aca tree				-->
				<div class="container">
					<br>
					<p class='colorazulfiplex' style="font-size:14px"><b>Search </b></p>
			  <input type="search" name="txtacceptbusca"  onchange="filtraplacas()" id="txtacceptbusca" class="form-control form-control-sm" placeholder="Search" >
    <div class="row">
        <div class="">
            <div class="tree ">
<ul>

 

<?php

 
?>

<li><span><a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#Page2" aria-expanded="false" aria-controls="Page2"><i class="collapsed"></i>
<i class="expanded"><i class="fa fa-inbox"></i></i> All Script Run</a></span>
  <ul>
	<div id="Page2" class="collapse ">
			
			
			
			<?php		
		
			
				$query_lista = "select scriptname,  count(distinct fas_outcome_integral.v_string)  as cc, array_agg(   coalesce(fas_outcome_integral.v_string,'')) as groupxsn, 
				array_agg(  coalesce(fas_outcome_integral.reference::character varying,'')) as groupxsnrun
				, array_agg(  coalesce(fas_outcome_integral_tp.v_boolean::integer,2)) as groupxsnruntp
				from fas_outcome_integral
				inner join (
					select losdatos.*
					from (
						select scriptname,  fas_outcome_integral.reference  
												from fas_outcome_integral
												inner join fas_script_type
												on fas_script_type.idscripttype = fas_outcome_integral.v_integer
												where idfasoutcomecat = 0 and idtype = 12 and 
												v_integer in(select idscripttype from fas_script_type 
															 where scriptname LIKE '%Accept%'    )
						 ) losdatos
						inner join fas_outcome_integral
						on fas_outcome_integral.reference = losdatos.reference
						where fas_outcome_integral.idtype = 16 and v_string not in (  

																			select username from userfas where iduserfas in(
																				select iduserfas
																				from userfas_attributes
																				where idattribute_user = 1)
																					)
						   ) as losrun
				on losrun.reference 	=   fas_outcome_integral.reference and
				   fas_outcome_integral.idfasoutcomecat = 0 and 
				   fas_outcome_integral.idtype = 4
				left join fas_outcome_integral as fas_outcome_integral_tp
				on fas_outcome_integral_tp.reference 	=   fas_outcome_integral.reference and
				   fas_outcome_integral_tp.idfasoutcomecat = 0 and 
				   fas_outcome_integral_tp.idtype =13   
				   
				   group by scriptname
				   order by scriptname
				  
				  
				
				  ";	
													//	echo $query_lista;									   
													$data = $connect->query($query_lista)->fetchAll();		

						$search  = array('{', '}');
						$replace = array('', '');

							//	echo $query_lista;									   
						$data = $connect->query($query_lista)->fetchAll();		

						$search  = array('{', '}');
						$replace = array('', '');


						$temonombretypeaccep="";
						$iddatos=0;
							//echo  $query_lista;
							foreach ($data as $row) 
							{
								?>
								<li><span><a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#folder<?php echo $iddatos;?>" aria-expanded="false" aria-controls="folder<?php echo $iddatos;?>"><i class="collapsed"></i>
		
								<?php
								
												$qporc=$row['cc'];
											
												$bgclass="bg-secondary";
												 
												 
									//Antes de mostrar pregunto si tiene mas ramas.

									$lossn = $array = explode(",", $row['groupxsn']);
									$lossn_run = $array = explode(",", $row['groupxsnrun']);
									$lossn_totalp = $array = explode(",", $row['groupxsnruntp']);

												$cant_pass=0;
												$cant_nopass=0;
												$cant_Abort=0;
											for($if = 0; $if < count($lossn); $if++)
											{
												//echo "<br>a".$lossn_totalp[$if];
												if(str_replace($search, $replace, $lossn_totalp[$if])==1)
												{
													$cant_pass= $cant_pass + 1;
												}
												if(str_replace($search, $replace, $lossn_totalp[$if])==0)
												{
													$cant_nopass= $cant_nopass + 1;
												}
												if(str_replace($search, $replace, $lossn_totalp[$if])==2)
												{
													$cant_Abort= $cant_Abort + 1;
												}
											}
										 
								?>
								<i class="expanded"><i class="fa fa-inbox"></i></i> <?php echo $row['scriptname'];  ?></a> <span data-toggle="tooltip" title="" class="badge <?php echo $bgclass; ?> ">										
																   <?php echo " [ ".$row['cc']; ?> SN ]		 </span> ||  <span data-toggle="tooltip"  class="badge bg-success">[Pass {<?php echo $cant_pass;  ?>}</span>  -   <span data-toggle="tooltip"  class="badge bg-danger">No Pass {<?php echo 	$cant_nopass;  ?>} </span> -  <span data-toggle="tooltip"  class="badge bg-warning"> Abort{<?php echo $cant_Abort;  ?>} </span>		 
															
																   </span>
									<?php 
								

									if ( count($lossn) >0)
									{
									?>
									<ul><div id="folder<?php echo $iddatos;?>" class="collapse marcoopen">
									<?php
										for($i = 0; $i < count($lossn); $i++){
											
											echo "<li class='treemm'><span>";
											if(str_replace($search, $replace, $lossn_totalp[$i])==0)
											{
												echo '<a data-ancla="anclamyTabledib" href="#" aria-expanded="true" onclick="mostrar_runaccept('."'".str_replace($search, $replace, $lossn_run[$i])."'".','."'".$row['scriptname']."','".str_replace($search, $replace, $lossn[$i])."'".')">SN:'.str_replace($search, $replace, $lossn[$i]).' <span class="badge bg-danger">No Pass</span> <i class="fas fa-eye"></i> </a>';
											}
											if(str_replace($search, $replace, $lossn_totalp[$i])==1)
											{
												echo '<a data-ancla="anclamyTabledib" href="#" aria-expanded="true" onclick="mostrar_runaccept('."'".str_replace($search, $replace, $lossn_run[$i])."'".','."'".$row['scriptname']."','".str_replace($search, $replace, $lossn[$i])."'".')">SN:'.str_replace($search, $replace, $lossn[$i]).' <span class="badge bg-success">Pass</span> <i class="fas fa-eye"></i> </a>';
												
											}
											if(str_replace($search, $replace, $lossn_totalp[$i])==2)
											{
												echo '<a data-ancla="anclamyTabledib" href="#" aria-expanded="true" onclick="mostrar_runaccept('."'".str_replace($search, $replace, $lossn_run[$i])."'".','."'".$row['scriptname']."','".str_replace($search, $replace, $lossn[$i])."'".')">SN:'.str_replace($search, $replace, $lossn[$i]).' <span class="badge bg-warning">Abort</span> <i class="fas fa-eye"></i> </a>';
												
											}
											
											
											
											echo "</span></li>";
											//echo "<li class='treemm'><span><button class='btn btn-sm' onclick='mostrar_calibrarion(this.value)' value='".str_replace($search, $replace, $lossn[$i])."'> SN:".  str_replace($search, $replace, $lossn[$i])."</button></span></li>";
											
											echo "</li>";
										}
										echo "</div></ul>";
									}
									
									?>
							</li> 
								<?php	
								$iddatos = $iddatos + 1 ;
								
							}
							?>
		
		    
     </div>
  </ul>
</li>




 

		
         
        </div>
    </div>
</div>
				<!-- fin aca tree -->
				
					
				</div>	
				</div>
			
					

        </section>
		<section class="col-lg-6 connectedSortable ui-sortable">
		

				<div class="card">
				<div class="card-header ui-sortable-handle" >
               		
				<div class="card">
            
              <!-- /.card-header -->
              <div class="card-body p-0" style="display: block;">
                <div class="d-md-flex">
                  <div class="p-1 flex-fill" style="overflow: hidden" >
                    
					
					<!--detalle so -->
					<div class="card" style="position: relative; left: 0px; top: 0px;">
            
              <div class="card-body">

         				<p class='colorazulfiplex' style="font-size:14px"><b>Report </b></p>
						<hr>
						Select Script:<br>
						<select  class="form-control form-control-sm" name="losscripts" id="losscripts">
						<option value="" > - Select - </option>
							<?php
						$sql = $connect->prepare("select * from fas_script_type   order by scriptname	");
						$sql->execute();
						$resultado3 = $sql->fetchAll();
						foreach ($resultado3 as $row2) 
						{
							$autoselect = '';
							$autoselect = '';
							 
							
						?>

							<option value="<?php echo  $row2['idscripttype']; ?>" <?php echo $autoselect;?>>
							<?php echo  strtoupper($row2['idscripttype'])." - [".$row2['scriptname']."]"; ?>
							</option>
						<?php
						}
						?>	
						</select>	<br>
						 Select Range:
						 <div id="reportrange" name="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
							<i class="fa fa-calendar"></i>&nbsp;
							<span></span> <i class="fa fa-caret-down"></i>
						</div>
						<input type="hidden" id="txtfechad" name="txtfechad">
						<input type="hidden" id="txtfechah" name="txtfechah">
						<p align="right"><br>
						<button class="btn btn-info btn-sm btn-secondary" onclick="reportarme()"> View </button>
						</p>
						<div name="grafdetalle" id="grafdetalle">
						<div name="grafdetalle1" id="grafdetalle1">
						<canvas id="grafico-chart1" height="200"></canvas>

						<?php

							$query_listagraf = " 
							select  coalesce(fas_outcome_integral_tp.v_boolean::integer,3) as tpsnrun, fas_outcome_integral.* 
							from fas_outcome_integral
							inner join (
								select losdatos.*
								from (
									select scriptname,  fas_outcome_integral.reference  
															from fas_outcome_integral
															inner join fas_script_type
															on fas_script_type.idscripttype = fas_outcome_integral.v_integer
															where idfasoutcomecat = 0 and idtype = 12 and 
															v_integer in(select idscripttype from fas_script_type 
																		 where scriptname LIKE '%Accept%'    )
									 ) losdatos
									inner join fas_outcome_integral
									on fas_outcome_integral.reference = losdatos.reference
									where fas_outcome_integral.idtype = 16 and v_string not in (  

										select username from userfas where iduserfas in(
											select iduserfas
											from userfas_attributes
											where idattribute_user = 1)
																	)
									   ) as losrun
							on losrun.reference 	=   fas_outcome_integral.reference and
							   fas_outcome_integral.idfasoutcomecat = 0 and 
							   fas_outcome_integral.idtype = 4
                             inner join (
                             
                                   select fas_outcome_integral.v_string, max(fas_outcome_integral.datetimeref) as maxfecha
                                      from (
                                    select  * 
                                    from fas_outcome_integral
                                    inner join fas_script_type
                                    on fas_script_type.idscripttype = fas_outcome_integral.v_integer
                                    where idfasoutcomecat = 0 and idtype = 12 and 
                                    v_integer in(select idscripttype from fas_script_type 
                                    where scriptname LIKE '%Accept%'    )
                                 ) as losruntodos 
                              inner join fas_outcome_integral
                              	on losruntodos.reference 	=   fas_outcome_integral.reference and
							   fas_outcome_integral.idfasoutcomecat = 0 and 
							   fas_outcome_integral.idtype = 4
                           group by fas_outcome_integral.v_string    
                                 
                             ) as losmasnfecha  
                             on losmasnfecha.v_string  =    fas_outcome_integral.v_string and
                                losmasnfecha.maxfecha  =    fas_outcome_integral.datetimeref
							left join fas_outcome_integral as fas_outcome_integral_tp
							on fas_outcome_integral_tp.reference 	=   fas_outcome_integral.reference and
							   fas_outcome_integral_tp.idfasoutcomecat = 0 and 
							   fas_outcome_integral_tp.idtype =13   
							where 'AcceptBatteryCharger'   = scriptname  
							";

							// echo $query_lista ;

							$data = $connect->query($query_listagraf)->fetchAll();	
							
							$v_tp_true =0;
							$v_tp_false =0;
							$v_tp_abort =0;

							foreach ($data as $row3) 
							{
								if ( $row3['tpsnrun']==1)
								{
									$v_tp_true = $v_tp_true +1;
								}
								else
								{
									if ( $row3['tpsnrun']==0)
									{
										$v_tp_false = $v_tp_false +1;
									}
									if ( $row3['tpsnrun']==3)								
									{
										$v_tp_abort = $v_tp_abort +1;
										
									}
								}
							
							}
						
						?>
							 
						</div>
						<script type="text/javascript">
 

    var grafico1chart = $('#grafico-chart1').get(0).getContext('2d'); 
   

  //  var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
  /*
   $vlblgraf1=$vlblgraf1.",Others";
    $vdatgraf1=$vdatgraf1.",".$lodemas;
    */
    var donutData1        = {
      labels: ['Pass [<?php echo $v_tp_true; ?>] ','No Pass [<?php echo $v_tp_false; ?>]','Abort [<?php echo $v_tp_abort; ?>]'],
      datasets: [
        {
          data: [<?php echo $v_tp_true.",".$v_tp_false.",".$v_tp_abort; ?>],
          backgroundColor : [  '#28a745', '#dc3545', '#ffc107', '#993333'],
        }
      ]
    }

   
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var donutChart = new Chart(grafico1chart, {
      type: 'doughnut',
      data: donutData1,
      options: donutOptions      
    })
   
 
						</script>


<table class="table table-striped table-bordered table-sm  " name="tblfilter1" id="tblfilter1" role="grid" >
           
           <thead>
           <tr>
           <th class="bg-primary "> SN </th>
           <th class="bg-primary "> Datetime  </th>
		   <th class="bg-primary "> Runinfo  </th>
           <th class="bg-primary "> Status Run </th>
 
            
           </tr>
           </thead>
           <tbody>
           <?php

$query_listagraf = " 
select distinct  coalesce(fas_outcome_integral_tp.v_boolean::integer,3) as tpsnrun, fas_outcome_integral.* 
from fas_outcome_integral
inner join (
	select losdatos.*
	from (
		select distinct scriptname,  fas_outcome_integral.reference  
								from fas_outcome_integral
								inner join fas_script_type
								on fas_script_type.idscripttype = fas_outcome_integral.v_integer
								where idfasoutcomecat = 0 and idtype = 12 and 
								v_integer in(select idscripttype from fas_script_type 
											 where scriptname LIKE '%Accept%'    )
		 ) losdatos
		inner join fas_outcome_integral
		on fas_outcome_integral.reference = losdatos.reference
		where fas_outcome_integral.idtype = 16 and   v_string not in (  

			select username from userfas where iduserfas in(
				select iduserfas
				from userfas_attributes
				where idattribute_user = 1)
										)
		   ) as losrun
on losrun.reference 	=   fas_outcome_integral.reference and
   fas_outcome_integral.idfasoutcomecat = 0 and 
   fas_outcome_integral.idtype = 4
left join fas_outcome_integral as fas_outcome_integral_tp
on fas_outcome_integral_tp.reference 	=   fas_outcome_integral.reference and
   fas_outcome_integral_tp.idfasoutcomecat = 0 and 
   fas_outcome_integral_tp.idtype =13   
where 'AcceptBatteryCharger'   = scriptname  
";

// echo $query_lista ;

$data = $connect->query($query_listagraf)->fetchAll();	

             foreach ($data as $row2) 
             {
            $indxtablaadd=0;
               ?>
          
              <?php						
               echo "<tr><td><b><i class='fas fa-file-alt'></i> SN:".$row2['v_string'] ."</b></td>"; 
			   echo "<td>&nbsp;&nbsp;&bull;&nbsp;&nbsp;".substr($row2['datetimeref'],0,19) ."</td>";  
               echo "<td>".$row2['reference']." &nbsp;";  
			   ?>
			   <a data-ancla="anclamyTabledib" href="#"  aria-expanded="true" onclick="mostrar_runaccept('<?php echo $row2['reference']; ?>','AcceptBatteryCharger','<?php echo $row2['v_string']; ?>')">
			   
			   <i class="fas fa-eye"></i>
			</a>
		 
			 </td>  
			   <?php
               
			   if ($row2['tpsnrun']==1)
			   {
				 ?><td>
				<span data-toggle="tooltip" title="" class="badge  bg-green ">										
				<?php echo "Pass"; ?>			 
				</span></td>
				<?php 
			   }
			   if ($row2['tpsnrun']==0)
			   {
				 ?><td>
				   <span data-toggle="tooltip" title="" class="badge  bg-red ">										
				   <?php echo "Not Pass"; ?>		 
				 </span></td>
				 <?php
			   }
			   if ($row2['tpsnrun']==3)
			   {
				 ?><td>
				   <span data-toggle="tooltip" title="" class="badge  bg-warning ">										
				   <?php echo "Abort"; ?>		 
				 </span></td>
				 <?php
			   }

			   echo "  </tr>";
             }
          
          ?>
            </tbody>
          </table>

		  <script type="text/javascript">
			///$('#tblfilter1').DataTable({searching: true, paging: true, info: false, pageLength: 20,  order: [[ 2, "desc" ]]} );

			var tablemm = 	  $('#tblfilter1').DataTable( {
        order: [[1, 'desc'],[0, 'ASC']],  "paging": true,  "pageLength": 50,	
		columnDefs: [      {"className": "dt-left", "targets": "_all"}      ],	
        rowGroup: {
            dataSrc: [ 0 ]
        },
        columnDefs: [ {
            targets: [ 0 ],
            visible: false
        } ]
    } );
		  </script>

				</div>
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
					<!-- fin detalle so -->
					
					<p name="detallelog1" id="detallelog1" ></p>						
					
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
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>


<script src="js/viewer.js"></script>
<script type="text/javascript" src="js/tabulator.min.js"></script>
<script src="js/dataTables.rowGroup.min.js"></script>

<script src="js/popperparacalibratio.min.js"></script>
<script src="js/eModal.min.js" type="text/javascript" />
<script src="plugins/chart.js/Chart.min.js"></script>

<script src="js/viewer.js"></script>
 


<script type="text/javascript" src="jsdatapickerrange/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="jsdatapickerrange/daterangepicker.css" />

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

   
   
	$( document ).ready(function() {
		

		$(function() {

var start = moment().subtract(29, 'days');
var end = moment();

function cb(start, end) {
	$('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
}

$('#reportrange').daterangepicker({
	startDate: start,
	endDate: end,
	ranges: {
	   'Today': [moment(), moment()],
	   'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
	   'Last 7 Days': [moment().subtract(6, 'days'), moment()],
	   'Last 30 Days': [moment().subtract(29, 'days'), moment()],
	   'This Month': [moment().startOf('month'), moment().endOf('month')],
	   'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
	}
}, cb);

cb(start, end);

});
		
		//Inicio mostrar hora live
		 var interval = setInterval(function() {
			 
        var momentNow = moment();
			var newYork    = momentNow.tz('America/New_York').format('ha z');
			$('#date-part').html(momentNow.format('YYYY/MM/DD') 	  );
			$('#time-part').html(momentNow.format('hh:mm:ss'));
			}, 100);
		//FIN mostrar hora live
		//	console.log( "ready!" );
			$('#msjwaitline ').hide();
			$('#divscrolllog').show(); 
			$('#p-b0').hide();
			$('#p-b0').CardWidget('toggle');		
			$("#detallelog").hide();
			$("#detallelog").text("");
			$("#msjwait").hide();		


  
	 
				$("#divgeneralinfo").addClass('d-none');
				$("#divgeneralinfoparam").addClass('d-none');
				$("#divdetinfolog").addClass('d-none');
				
				$("#diveq").addClass('d-none');
				$("#divfactory").addClass('d-none');
				$("#divfinalcheck").addClass('d-none');
				$("#divgroupbyciu").addClass('d-none');
				
		 
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
		
	function mostrar_calibrarion_flex(sndib)
	{
		//generalinfo
		//url: 'acceptflex.php?idsndib='+sndib,	
		 $("#msjwait").fadeIn('slow');   
			$.ajax({
										
										url:'acceptflex.php?idsndib='+sndib	,								
										 cache:false,
										success: function(respuesta) {									
										
											//$('#viewcalib'+idsnaver).html(""+respuesta);
											$('#generalinfo').height(2400);
											//$('#generalinfo').html(respuesta);
											  $("#msjwait").hide();
											$('#generalinfo').html(respuesta);
										},
										error: function() {
											console.log("No se ha podido obtener la información");
											
										}
									});
									
		
		
	}	
   
    function show_DB_sn(idplaca, nameplaca, nomplacasincaracrlocos)
   {
	//alert(idplaca + 'aaaaa '+ nameplaca )
	  var sn_active_style = '';
	   	$('#collapse'+idplaca).html("<p name='msjwaitparticular' id='msjwaitparticular' align='center'><img src='img/waitazul.gif' width='100px' ></p>");
			//	console.log(idsaleorders);
				toastr.options = {
				  "closeButton": false,
				  "debug": false,
				  "newestOnTop": false,
				  "progressBar": true,
				  "positionClass": "toast-bottom-right",
				  "preventDuplicates": false,
				  "onclick": null,
				  "showDuration": "600",
				  "hideDuration": "600",
				  "timeOut": "600",
				  "extendedTimeOut": "600",
				  "showEasing": "swing",
				  "hideEasing": "linear",
				  "showMethod": "fadeIn",
				  "hideMethod": "fadeOut"
				};	
				toastr["success"]("Wait....Search Results", "Attention :: Sales Orders ");
				$.ajax
				({ 
					url: 'ajax_show_DBSN.php',
					data: "idtipoclac="+idplaca+'&dbciu='+nameplaca,	
					type: 'post',				
					datatype:'JSON',
				
					success: function(data)
					{
						 $("#msjwait").hide();	
						 console.log(nomplacasincaracrlocos+'<----'+idplaca+"-devolvio"+ nameplaca+ data);
						  var eTable="<div class='card-headermarco'>";					
						  for(var i=0; i<data.length;i++)
						  {
							// console.log("devolvio"+ nameplaca.trim()+'----'+ data[i].sn);
							
								if (idplaca=="DB")
								{
									if (data[i].snactive=='N')
									{
										eTable += '<a  data-ancla="anclamyTabledib"  href="#" aria-expanded="true" onclick="mostrar_acceptdb(1,'+"'"+nameplaca.trim()+"','"+data[i].sn+"'"+');"><img src="img/imgdb.png" width="40px" ><del>'+data[i].sn+'</del>&nbsp;<i class="fas fa-eye"></i	> </a><br>';		
									}
									else
									{  
										eTable += '<a  data-ancla="anclamyTabledib"  href="#" aria-expanded="true" onclick="mostrar_acceptdb(1,'+"'"+nameplaca.trim()+"','"+data[i].sn+"'"+');"><img src="img/imgdb.png" width="40px" >'+data[i].sn+'&nbsp;<i class="fas fa-eye"></i	> </a><br>';		
									}
						
									
								}
								if (idplaca=="PA")
								{
									eTable += '<a  data-ancla="anclamyTabledib"  href="#" aria-expanded="true" onclick="mostrar_acceptpa(2,'+"'"+nameplaca.trim()+"','"+data[i].sn+"'"+');"><img src="img/imgpa.png" width=40px" >'+data[i].sn+'&nbsp; <i class="fas fa-eye"	></i> </a><br>';	
								}									
								if (idplaca=="ACF")
								{
									eTable += '<a  data-ancla="anclamyTabledib"  href="#" aria-expanded="true" onclick="mostrar_acceptacf(3,'+"'"+nameplaca.trim()+"','"+data[i].sn+"'"+');"><img src="img/imgdb.png" width="40px" >'+data[i].sn+'&nbsp; <i class="fas fa-eye"	></i> </a><br>';	
								}	
									//eTable += "<a data-toggle='collapse' data-parent='#accordion' href='#' aria-expanded='true'><img src='img/imgdb.png' width='40px' > "+data[i].sn+"&nbsp;<i class='fas fa-eye'	></i> </a><br>";		
								
							
																			
							
						  }
						  eTable +="</div>";
						  console.log(eTable);
						  $('#collapse'+nomplacasincaracrlocos).html(eTable);
					}
					/* error: function (xhr, ajaxOptions, thrownError) {
						console.log(xhr.status);
						console.log(thrownError);
						$('#collapse'+idsaleorders).html("<p name='msjwaitparticular' id='msjwaitparticular' align='center'>Error by Ajax Conector</p>");
					  }*/
				});
				
			
   }
    function show_DB_sn_search(idplaca, nameplaca)
   {
	//alert(idplaca + 'aaaaa '+ nameplaca )
	   	$('#collapse'+idplaca).html("<p name='msjwaitparticular' id='msjwaitparticular' align='center'><img src='img/waitazul.gif' width='100px' ></p>");
			//	console.log(idsaleorders);
				toastr.options = {
				  "closeButton": false,
				  "debug": false,
				  "newestOnTop": false,
				  "progressBar": true,
				  "positionClass": "toast-bottom-right",
				  "preventDuplicates": false,
				  "onclick": null,
				  "showDuration": "600",
				  "hideDuration": "600",
				  "timeOut": "600",
				  "extendedTimeOut": "600",
				  "showEasing": "swing",
				  "hideEasing": "linear",
				  "showMethod": "fadeIn",
				  "hideMethod": "fadeOut"
				};	
				toastr["success"]("Wait....Search Results", "Attention :: Sales Orders ");
				$.ajax
				({ 
					url: 'ajax_show_DBSN.php',
					data: "idtipoclac="+idplaca+'&dbciu='+nameplaca,	
					type: 'post',				
					datatype:'JSON',
				
					success: function(data)
					{
						 $("#msjwait").hide();	
						// console.log("devolvio"+ nameplaca+ data);
						  var eTable="<div class='card-headermarco'>";					
						  for(var i=0; i<data.length;i++)
						  {
							
								if ($("[type=search]" ).val() !="")
								{
									
									var testStr = data[i].sn;
								
									
								var textoabuscar= $("[type=search]" ).val().toUpperCase().trim();
									if(testStr.includes(textoabuscar) )
									{
								
										if (idplaca=="DB")
										{
																			
											if (data[i].snactive=='N')
											{
												
												eTable += '<a  data-ancla="anclamyTabledib"  href="#" aria-expanded="true" onclick="mostrar_acceptdb(1,'+"'"+nameplaca.trim()+"','"+data[i].sn+"'"+');"><img src="img/imgdb.png" width="40px" ><del>'+data[i].sn+'</del>&nbsp;<i class="fas fa-eye"></i	> </a><br>';		
											}
											else
											{  
												eTable += '<a  data-ancla="anclamyTabledib"  href="#" aria-expanded="true" onclick="mostrar_acceptdb(1,'+"'"+nameplaca.trim()+"','"+data[i].sn+"'"+');"><img src="img/imgdb.png" width="40px" >'+data[i].sn+'&nbsp;<i class="fas fa-eye"></i	> </a><br>';		
											}
										}
										if (idplaca=="PA")
										{
											eTable += '<a   href="#anclamyTabledib" aria-expanded="true" onclick="mostrar_acceptpa(2,'+"'"+nameplaca.trim()+"','"+data[i].sn+"'"+');"><img src="img/imgpa.png" width="40px" >'+data[i].sn+'&nbsp; <i class="fas fa-eye"	></i> </a><br>';	
										}									
										if (idplaca=="ACF")
										{
											eTable += '<a   href="#anclamyTabledib" aria-expanded="true" onclick="mostrar_acceptacf(3,'+"'"+nameplaca.trim()+"','"+data[i].sn+"'"+');"><img src="img/imgdb.png" width="40px" >'+data[i].sn+'&nbsp; <i class="fas fa-eye"	></i> </a><br>';	
										}	
										//eTable += "<a data-toggle='collapse' data-parent='#accordion' href='#' aria-expanded='true'><img src='img/imgdb.png' width='40px' > "+data[i].sn+"&nbsp;<i class='fas fa-eye'></i></a><br>";
								
									}
								}
								else
								{
									
										if (idplaca=="DB")
										{
											eTable += '<a  data-ancla="anclamyTabledib"  href="#" aria-expanded="true" onclick="mostrar_acceptdb(1,'+"'"+nameplaca.trim()+"','"+data[i].sn+"'"+');"><img src="img/imgdb.png" width="40px" >'+data[i].sn+'&nbsp;<i class="fas fa-eye"></i	> </a><br>';		
										}
										if (idplaca=="PA")
										{
											eTable += '<a  data-ancla="anclamyTabledib"  href="#" aria-expanded="true" onclick="mostrar_acceptpa(2,'+"'"+nameplaca.trim()+"','"+data[i].sn+"'"+');"><img src="img/imgpa.png" width="40px" >'+data[i].sn+'&nbsp; <i class="fas fa-eye"	></i> </a><br>';	
										}									
										if (idplaca=="ACF")
										{
											eTable += '<a  data-ancla="anclamyTabledib"  href="#" aria-expanded="true" onclick="mostrar_acceptacf(3,'+"'"+nameplaca.trim()+"','"+data[i].sn+"'"+');"><img src="img/imgdb.png" width="40px" >'+data[i].sn+'&nbsp; <i class="fas fa-eye"	></i> </a><br>';	
										}	
									//eTable += "<a data-toggle='collapse' data-parent='#accordion' href='#' aria-expanded='true'><img src='img/imgdb.png' width='40px' > "+data[i].sn+"&nbsp;<i class='fas fa-eye'	></i> </a><br>";		
									
								}
							
																			
							
						  }
						  eTable +="</div>";
						  $('#collapse'+nameplaca).html(eTable);
					}
					/* error: function (xhr, ajaxOptions, thrownError) {
						console.log(xhr.status);
						console.log(thrownError);
						$('#collapse'+idsaleorders).html("<p name='msjwaitparticular' id='msjwaitparticular' align='center'>Error by Ajax Conector</p>");
					  }*/
				});
				
			
   }

   function mostrar_runaccept (idrun, nomscript, idsn)
   {
	   if ('AcceptBatteryCharger'==nomscript)
	   {

		var ipservidorapache= '<?php echo $ipservidorapache; ?>';	
		eModal.iframe('https://'+ipservidorapache+'/calibbbureportcharger.php?unitsn='+idsn+'&idrun='+idrun,'Information');
	   }
	   if ('AcceptPassive'==nomscript)
	   {

		var ipservidorapache= '<?php echo $ipservidorapache; ?>';	
		eModal.iframe('https://'+ipservidorapache+'/reportefrc.php?hidmenu=Y&sn='+idsn+'&idmb=0&iduldl=0&&idruninfo='+idrun,'Information');
	   }
	   if (ipservidorapache=='')
	   {
		toastr["info"]("Error....undefined event", "Error ");
	   }
   }

 function mostrar_acceptacf(placadb, placadbciu, dbsn)
  {
			$("#myTableacf").addClass('d-none');
			$("#myTableacffreq").addClass('d-none');
			$("#divgeneralinfo").removeClass('d-none');				
			$("#divdetinfolog").removeClass('d-none');	
			$("#divgeneralinfo").removeClass('d-none');				
			$("#divdetinfolog").removeClass('d-none');	
		
			$('#divFIP446').html("");			
			$('#divFIP467').html("");			
			$('#divFIP488').html("");			
				
			var myTableginfo = $("#myTablepa");
			var myTableacf = $("#myTableacf");	
			var myTableacffreq = $("#myTableacffreq");	
			
			//myTableginfo.html("");
			myTableacf.html("");
			myTableacf.html("<table id='myTableacf' border='1' class='table table-bordered table-sm texto10 scrolltablemarco table-striped  d-none'><tr data-rowacf='0'><td  data-rowacf='0' data-colacf='0' class='table-info'><b>GENERAL INFO ACF</b> </td></tr>							<tr data-rowacf='1'><td  data-rowacf='1' data-colacf='0'><b>Date</b></td></tr><tr data-rowacf='2'><td  data-rowacf='2' data-colacf='0'><b>TotalTime</b> </td></tr><tr data-rowacf='3'><td  data-rowacf='3' data-colacf='0'><b>Calibratior </b></td></tr><tr data-rowacf='4'><td  data-rowacf='4' data-colacf='0'><b>Station </b></td></tr><tr data-rowacf='5'><td  data-rowacf='5' data-colacf='0'><b>FAS </b></td></tr>							<tr data-rowacf='7'><td  data-rowacf='7' data-colacf='0'><b>Fw</b></td></tr><tr data-rowacf='8'><td  data-rowacf='8' data-colacf='0'><b>Freq</b> </td></tr>	<tr data-rowacf='9'><td  data-rowacf='9'  data-colacf='0'><b>Gain </b> </td></tr>							<tr data-rowacf='10'><td  data-rowacf='10' data-colacf='0'><br></td></tr><tr data-rowacf='11'><td data-rowacf='11' data-colacf='0'><b>CIU Parameters Pass </b> </td></tr>	<tr data-rowacf='12'><td data-rowacf='12' data-colacf='0'><b>Calibration Pass </b> </td></tr>	<tr data-rowacf='13'><td data-rowacf='13' data-colacf='0'><b>Detector Pass </b> </td></tr>	<tr data-rowacf='14'><td data-rowacf='14' data-colacf='0'><b>In Band Gain Pass </b> </td></tr>	<tr data-rowacf='15'><td data-rowacf='15' data-colacf='0'><b>Out Channel Gain Pass </b> </td></tr>	<tr data-rowacf='16'><td data-rowacf='16' data-colacf='0'><b>Channel Ripple Pass </b> </td></tr>	<tr data-rowacf='17'><td data-rowacf='17' data-colacf='0'><b>Max Power Overload Pass </b> </td></tr>	<tr data-rowacf='18'><td data-rowacf='18' data-colacf='0'><b>Alarm Total Pass </b> </td></tr><tr data-rowacf='19'><td  data-rowacf='19' data-colacf='0'><b>Total Pass<b></td></tr>							<tr data-rowacf='20'><td  data-rowacf='20' data-colacf='0'><br></td></tr>	<tr data-rowacf='21'><td  data-rowacf='21' data-colacf='0'><b>Gain Ripple</b></td></tr>	<tr data-rowacf='22'><td  data-rowacf='22' data-colacf='0'><br></td></tr><tr data-rowacf='23'><td  data-rowacf='23' data-colacf='0'><b>Out Channel Gain</b></td></tr>								<tr data-rowacf='24'><td  data-rowacf='24' data-colacf='0'><br><br> </td></tr>							<tr data-rowacf='25'><td  data-rowacf='25' data-colacf='0'><b>Channel Ripple <b></td></tr>							<tr data-rowacf='26'><td  data-rowacf='26' data-colacf='0'><b> </b></td></tr>								<tr data-rowacf='27'><td  data-rowacf='27' data-colacf='0'><br> <br></td></tr>							<tr data-rowacf='28'><td  data-rowacf='28' data-colacf='0'><b>Max Out Power <b></td></tr>							<tr data-rowacf='29'><td  data-rowacf='29' data-colacf='0'><b></b><br></td></tr>	<tr data-rowacf='30'><td  data-rowacf='30' data-colacf='0'><BR><b>ALARM PASS</b></td></tr>								<tr data-rowacf='31'><td  data-rowacf='31' data-colacf='0'><b>Max Power Output	</b></td></tr><tr data-rowacf='32'><td  data-rowacf='32' data-colacf='0'><b>Max Power Input	</b></td></tr>								<tr data-rowacf='33'><td  data-rowacf='33' data-colacf='0'><b>LNA	</b></td></tr><tr data-rowacf='34'><td  data-rowacf='34' data-colacf='0'><b>Main Power Source 	</b></td></tr>								<tr data-rowacf='35'><td  data-rowacf='35' data-colacf='0'><b>Backup Power Source 	</b></td></tr>	<tr data-rowacf='36'><td  data-rowacf='36' data-colacf='0'><b></b><br></td></tr>	<tr data-rowacf='37'><td  data-rowacf='37' data-colacf='0'><BR><b>LEDS PASS</b></td></tr>								<tr data-rowacf='38'><td  data-rowacf='38' data-colacf='0'><b>Max Power Output	</b></td></tr><tr data-rowacf='39'><td  data-rowacf='39' data-colacf='0'><b>Max Power Input	</b></td></tr>								<tr data-rowacf='40'><td  data-rowacf='40' data-colacf='0'><b>LNA	</b></td></tr><tr data-rowacf='41'><td  data-rowacf='41' data-colacf='0'><b>Main Power Source 	</b></td></tr>						<tr data-rowacf='42'><td  data-rowacf='42' data-colacf='0'><b>Backup Power Source 	</b></td></tr><tr data-rowacf='43'><td  data-rowacf='43' data-colacf='0'>  </td></tr></table>");
			myTableacffreq.html("");
			myTableacffreq.html("<table id='myTableacffreq' border='1' class='table table-bordered table-sm texto10 table-striped  scrolltablemarco  d-none '><tr data-rowacffreq='0' class='table-info'><td data-rowacffreq='0' data-colacffreq='0' ><B>Gain Measures<B> </td><td data-rowacffreq='0' data-colacffreq='1'><B><B> </td></tr></table>");
			var losbuttons= "";			
										
			
			$.ajax
			({ 
				url: 'aja_show_acceptdatadb.php',
				data: "tipodb="+placadb+"&ciu="+placadbciu+"&sn="+dbsn,	
				type: 'post',
				async:true,
                cache:false,
				success: function(data)
				{
					//alert(data);
					//var datax = JSON.parse(data)
				    $("#msjwait").hide();
				 	$('#ciusnshow').html( $('#ciusnshowbks').html() + ' &nbsp; '+ placadbciu + ' -SN: ' + dbsn ); 
						
						$.each(data.gi, function(i, itemdib) {
							//console.log('muestro itemd pa :'+itemdib.totalpass);
							AddNewColdl(1,itemdib,'acf');				
						});
						
						$.each(data.gifreqgain, function(i, itemdibref) {
							//console.log('muestro itemd pa :'+itemdibref.totalpass);
							AddNewRowchanelacf(1,itemdibref,'acffreq');				
						});
						
						
					
								
						$.each(data.gilog, function(ilg, itemlg) {
								console.log('Log:'+itemlg.idlog);
							
						
								losbuttons = losbuttons + '<a href="#"  onclick="show_log('+itemlg.idlog+')"><span class="badge badge-primary" ><i class="fas fa-search"></i> Iteration: '+itemlg.idit+' ->'+itemlg.idlog+'</span></a> - ';
							
							
							
						});							
						losbuttons = losbuttons + '<textarea class="form-control" rows="18" id="detallelog" name="detallelog"></textarea>';
						$('#infolog').html(losbuttons); 
						
						
					$("#myTableacf").removeClass('d-none');
					$("#myTableacffreq").removeClass('d-none');
					
					$("#myTabledib").addClass('d-none');
					$("#myTabledibciu").removeClass('d-none');
					
				}
			});
			
  }
   function mostrar_acceptpa(placadb, placadbciu, dbsn)
  {
	  	$('#divFIP446').html("");
		  $('#divFIP467').html("");
		  $('#divFIP488').html("");
			$("#myTableacf").addClass('d-none');
			$("#myTableacffreq").addClass('d-none');
			$("#divgeneralinfo").removeClass('d-none');				
			$("#divdetinfolog").removeClass('d-none');				
				
			var myTableginfo = $("#myTablepa");
			var myTableaccepinfo = $("#myTabledibciu");		
				var myTablepa = $("#myTablepa");	
			
			
			//myTableginfo.html("");
			myTablepa.html("");
			myTablepa.html("<table id='myTablepa' border='1' class='table table-bordered table-sm texto10 scrolltablemarco table-striped  d-none'><tr data-rowpa='0'><td  data-rowpa='0' data-colpa='0' class='table-info'><b>GENERAL INFO PA</b> </td></tr>							<tr data-rowpa='1'><td  data-rowpa='1' data-colpa='0'><b>Date</b></td></tr><tr data-rowpa='2'><td  data-rowpa='2' data-colpa='0'><b>TotalTime</b> </td></tr><tr data-rowpa='3'><td  data-rowpa='3' data-colpa='0'><b>Calibratior </b></td></tr><tr data-rowpa='4'><td  data-rowpa='4' data-colpa='0'><b>Station </b></td></tr><tr data-rowpa='5'><td  data-rowpa='5' data-colpa='0'><b>FAS </b></td></tr><tr data-rowpa='6'><td  data-rowpa='6' data-colpa='0'><b>Total Pass </b> </td></tr>						<tr data-rowpa='7'><td  data-rowpa='7' data-colpa='0'><br> <br></td></tr>	<tr data-rowpa='8'><td  data-rowpa='8' data-colpa='0'><b>GainPass </b> </td></tr>	<tr data-rowpa='9'><td  data-rowpa='9'  data-colpa='0'><b>IMDPass </b> </td></tr>	<tr data-rowpa='10'><td data-rowpa='10' data-colpa='0'><b>CurrentPass </b> </td></tr>	<tr data-rowpa='11'><td data-rowpa='11' data-colpa='0'><b>Retuned </b> </td></tr>	<tr data-rowpa='12'><td data-rowpa='12' data-colpa='0'><b>LinealityPass </b> </td></tr>	<tr data-rowpa='13'><td data-rowpa='13' data-colpa='0'><b>ForcedPass </b> </td></tr>	<tr data-rowpa='14'><td data-rowpa='14' data-colpa='0'><br><br> </td></tr>	<tr data-rowpa='15'><td data-rowpa='15' data-colpa='0'><b>Referemces </b> </td></tr>	<tr data-rowpa='16'><td data-rowpa='16' data-colpa='0'><b>Gain </b> </td></tr>	<tr data-rowpa='17'><td data-rowpa='17' data-colpa='0'><b>MaxPwr1 </b> </td></tr>	<tr data-rowpa='18'><td data-rowpa='18' data-colpa='0'><b>IMD1 </b> </td></tr>	<tr data-rowpa='19'><td data-rowpa='19' data-colpa='0'><b>MaxPwr2 </b> </td></tr>	<tr data-rowpa='20'><td data-rowpa='20' data-colpa='0'><b>IMD2 </b> </td></tr>	<tr data-rowpa='21'><td data-rowpa='21' data-colpa='0'><b>Voltage </b> </td></tr>	<tr data-rowpa='22'><td data-rowpa='22' data-colpa='0'><b>Current </b> </td></tr>	<tr data-rowpa='23'><td data-rowpa='23' data-colpa='0'><br><br> </td></tr>	<tr data-rowpa='24'><td data-rowpa='24' data-colpa='0'><b>Power </b> </td></tr>	<tr data-rowpa='25'><td data-rowpa='25' data-colpa='0'><b>Standy </b> </td></tr>	<tr data-rowpa='26'><td data-rowpa='26' data-colpa='0'><b>1x-60In </b> </td></tr>	<tr data-rowpa='27'><td data-rowpa='27' data-colpa='0'><b>2x37 </b> </td></tr>	<tr data-rowpa='28'><td data-rowpa='28' data-colpa='0'><b>2x39 </b> </td></tr>	<tr data-rowpa='29'><td data-rowpa='29' data-colpa='0'><br><b>IMD3</b> </td></tr>	<tr data-rowpa='30'><td data-rowpa='30' data-colpa='0'>-PWR1 </td></tr>	<tr data-rowpa='31'><td data-rowpa='31' data-colpa='0'>---FSTART </td></tr>	<tr data-rowpa='32'><td data-rowpa='32' data-colpa='0'>---IMD1 </td></tr>	<tr data-rowpa='33'><td data-rowpa='33' data-colpa='0'>---Cent1 </td></tr>	<tr data-rowpa='34'><td data-rowpa='34' data-colpa='0'>---Cent2 </td></tr>	<tr data-rowpa='35'><td data-rowpa='35' data-colpa='0'>---IMD2 </td></tr>					<tr data-rowpa='36'><td data-rowpa='36' data-colpa='0'>---FCENTER </td></tr>	<tr data-rowpa='37'><td data-rowpa='37' data-colpa='0'>---IMD1 </td></tr>	<tr data-rowpa='38'><td data-rowpa='38' data-colpa='0'>---Cent1 </td></tr>	<tr data-rowpa='39'><td data-rowpa='39' data-colpa='0'>---Cent2 </td></tr>	<tr data-rowpa='40'><td data-rowpa='40' data-colpa='0'>---IMD2 </td></tr>								<tr data-rowpa='41'><td data-rowpa='41' data-colpa='0'>---FSTOP </td></tr>	<tr data-rowpa='42'><td data-rowpa='42' data-colpa='0'>---IMD1 </td></tr>	<tr data-rowpa='43'><td data-rowpa='43' data-colpa='0'>---Cent1 </td></tr>	<tr data-rowpa='44'><td data-rowpa='44' data-colpa='0'>---Cent2 </td></tr>	<tr data-rowpa='45'><td data-rowpa='45' data-colpa='0'>---IMD2 </td></tr>	<tr data-rowpa='46'><td data-rowpa='46' data-colpa='0'>-PWR2 </td></tr>	<tr data-rowpa='47'><td data-rowpa='47' data-colpa='0'>---FSTART </td></tr>	<tr data-rowpa='48'><td data-rowpa='48' data-colpa='0'>---IMD1 </td></tr>	<tr data-rowpa='49'><td data-rowpa='49' data-colpa='0'>---Cent1 </td></tr>	<tr data-rowpa='50'><td data-rowpa='50' data-colpa='0'>---Cent2 </td></tr>	<tr data-rowpa='51'><td data-rowpa='51' data-colpa='0'>---IMD2 </td></tr>					<tr data-rowpa='52'><td data-rowpa='52' data-colpa='0'>---FCENTER </td></tr>	<tr data-rowpa='53'><td data-rowpa='53' data-colpa='0'>---IMD1 </td></tr>	<tr data-rowpa='54'><td data-rowpa='54' data-colpa='0'>---Cent1 </td></tr>	<tr data-rowpa='55'><td data-rowpa='55' data-colpa='0'>---Cent2 </td></tr>	<tr data-rowpa='56'><td data-rowpa='56' data-colpa='0'>---IMD2 </td></tr>	<tr data-rowpa='57'><td data-rowpa='57' data-colpa='0'>---FSTOP </td></tr>	<tr data-rowpa='58'><td data-rowpa='58' data-colpa='0'>---IMD1 </td></tr>	<tr data-rowpa='59'><td data-rowpa='57' data-colpa='0'>---Cent1 </td></tr>	<tr data-rowpa='60'><td data-rowpa='60' data-colpa='0'>---Cent2 </td></tr>	<tr data-rowpa='61'><td data-rowpa='61' data-colpa='0'>---IMD2 </td></tr>	<tr data-rowpa='62'><td data-rowpa='62' data-colpa='0'><br><br> </td></tr>	<tr data-rowpa='63'><td data-rowpa='63' data-colpa='0'><b>Gain </b> </td></tr>	<tr data-rowpa='64'><td data-rowpa='64' data-colpa='0'><b>---Fstart </b> </td></tr><tr data-rowpa='65'><td data-rowpa='65' data-colpa='0'><b>---Fcenter </b> </td></tr><tr data-rowpa='66'><td data-rowpa='66' data-colpa='0'><b>---Fstop </b> </td></tr><tr data-rowpa='67'><td data-rowpa='67' data-colpa='0'><br><br> </td></tr>	<tr data-rowpa='68'><td data-rowpa='68' data-colpa='0'><b>Freq </b> </td></tr>	<tr data-rowpa='69'><td data-rowpa='69' data-colpa='0'><b>---Fstart </b> </td></tr><tr data-rowpa='70'><td data-rowpa='70' data-colpa='0'><b>---Fcenter </b> </td></tr><tr data-rowpa='71'><td data-rowpa='71' data-colpa='0'><b>---Fstop </b> </td></tr><tr data-rowpa='72'><td data-rowpa='72' data-colpa='0'><br><br> </td></tr>	<tr data-rowpa='73'><td data-rowpa='73' data-colpa='0'><b>Current </b> </td></tr>	<tr data-rowpa='74'><td data-rowpa='74' data-colpa='0'><b>---Standy </b> </td></tr><tr data-rowpa='75'><td data-rowpa='75' data-colpa='0'><b>---1x-60In</b> </td></tr><tr data-rowpa='76'><td data-rowpa='76' data-colpa='0'><b>---2x30 </b> </td></tr><tr data-rowpa='77'><td data-rowpa='77' data-colpa='0'><b>---2x32 </b> </td></tr>		<tr data-rowpa='78'><td data-rowpa='78' data-colpa='0'><br><br> </td></tr>	<tr data-rowpa='79'><td data-rowpa='79' data-colpa='0'><b>NFPA </b> </td></tr>	<tr data-rowpa='80'><td data-rowpa='80' data-colpa='0'><b>---Powermin </b> </td></tr><tr data-rowpa='81'><td data-rowpa='81' data-colpa='0'><b>---ADMin </b> </td></tr><tr data-rowpa='82'><td data-rowpa='82' data-colpa='0'><b>---Powermax </b> </td></tr><tr data-rowpa='83'><td data-rowpa='83' data-colpa='0'><b>---ADMax </b> </td></tr><tr data-rowpa='84'><td data-rowpa='84' data-colpa='0'><b>---Multiplier </b> </td></tr></table>");
			
			
			//myTableginfo.html("");
			myTableaccepinfo.html("");
			var losbuttons= "";			
										
			
			$.ajax
			({ 
				url: 'aja_show_acceptdatadb.php',
				data: "tipodb="+placadb+"&ciu="+placadbciu+"&sn="+dbsn,	
				type: 'post',
				async:true,
                cache:false,
				success: function(data)
				{
					//alert(data);
					//var datax = JSON.parse(data)
				    $("#msjwait").hide();
				 	$('#ciusnshow').html( $('#ciusnshowbks').html() + ' &nbsp; '+ placadbciu + ' -SN: ' + dbsn ); 
						$.each(data.gi, function(i, itemdib) {
							console.log('muestro itemd pa :'+itemdib.totalpass);
							AddNewColdl(1,itemdib,'pa');				
						});						
								
						$.each(data.gilog, function(ilg, itemlg) {
								console.log('Log:'+itemlg.idlog);
							
						
								losbuttons = losbuttons + '<a href="#"  onclick="show_log('+itemlg.idlog+')"><span class="badge badge-primary" ><i class="fas fa-search"></i> Iteration: '+itemlg.idit+' ->'+itemlg.idlog+'</span></a> - ';
							
							
							
						});							
						losbuttons = losbuttons + '<textarea class="form-control" rows="18" id="detallelog" name="detallelog"></textarea>';
						$('#infolog').html(losbuttons); 
						
						
					$("#myTablepa").removeClass('d-none');
					$("#myTabledib").addClass('d-none');
					$("#myTabledibciu").removeClass('d-none');
					
				}
			});
			
  }
  
   
  function mostrar_acceptdb(placadb, placadbciu, dbsn)
  {
	  	$('#divFIP446').html("");
		  $('#divFIP467').html("");
		  $('#divFIP488').html("");
		
		
				$("#myTableacf").addClass('d-none');
			$("#myTableacffreq").addClass('d-none');
			$("#divgeneralinfo").removeClass('d-none');				
			$("#divdetinfolog").removeClass('d-none');	
					
			$("#divgeneralinfo").removeClass('d-none');				
			$("#divdetinfolog").removeClass('d-none');				
				
			var myTableginfo = $("#myTabledib");
			var myTableaccepinfo = $("#myTabledibciu");		
			myTableginfo.html("");			
			myTableginfo.html("<table id='myTabledib' border='1' class='table table-bordered table-sm texto10 scrolltablemarco table-striped  mmd-none'><tr data-rowdib='0'><td data-rowdib='0' data-coldib='0' class='table-info'><b>GENERAL INFO</b> </td></tr><tr data-rowdib='1'><td data-rowdib='1' data-coldib='0'><b>Date</b></td></tr><tr data-rowdib='2'><td data-rowdib='2' data-coldib='0'><b>TotalTime</b> </td></tr><tr data-rowdib='3'><td data-rowdib='3' data-coldib='0'><b>Calibratior </b></td></tr><tr data-rowdib='4'><td data-rowdib='4' data-coldib='0'><b>Station </b></td></tr><tr data-rowdib='5'><td data-rowdib='5' data-coldib='0'><b>FAS </b></td></tr><tr data-rowdib='6'><td data-rowdib='6' data-coldib='0'><b>Total Pass </b> </td></tr><tr data-rowdib='6'><td data-rowdib='7' data-coldib='0'><br> <br></td></tr><tr data-rowdib='6'><td data-rowdib='8' data-coldib='0'><b>GainPass </b> </td></tr><tr data-rowdib='6'><td data-rowdib='9' data-coldib='0'>UL </td></tr><tr data-rowdib='6'><td data-rowdib='10' data-coldib='0'>DL </td></tr><tr data-rowdib='6'><td data-rowdib='11' data-coldib='0'><b>MaxPwrPass </b></td></tr><tr data-rowdib='6'><td data-rowdib='12' data-coldib='0'><b>TemperaturePass</b> </td></tr><tr data-rowdib='6'><td data-rowdib='13' data-coldib='0'><b>HWFailPass </b></td></tr><tr data-rowdib='6'><td data-rowdib='14' data-coldib='0'><b>ForcedPass </b></td></tr><tr data-rowdib='6'><td data-rowdib='15' data-coldib='0'><b>RabbitPass </b></td></tr><tr data-rowdib='6'><td data-rowdib='16' data-coldib='0'> <br> <br></td></tr><tr data-rowdib='6'><td data-rowdib='17' data-coldib='0'><b>Gain</b> </td></tr><tr data-rowdib='6'><td data-rowdib='18' data-coldib='0'>UL </td></tr><tr data-rowdib='6'><td data-rowdib='19' data-coldib='0'>DL </td></tr><tr data-rowdib='6'><td data-rowdib='20' data-coldib='0'> <br> <br></td></tr><tr data-rowdib='6'><td data-rowdib='21' data-coldib='0'><b>MaxPwr</b> </td></tr><tr data-rowdib='6'><td data-rowdib='22' data-coldib='0'>UL </td></tr><tr data-rowdib='6'><td data-rowdib='23' data-coldib='0'>DL </td></tr><tr data-rowdib='6'><td data-rowdib='24' data-coldib='0'><br> <br> </td></tr><tr data-rowdib='6'><td data-rowdib='25' data-coldib='0'><b>Ripple</b> </td></tr><tr data-rowdib='6'><td data-rowdib='26' data-coldib='0'>UL </td></tr><tr data-rowdib='6'><td data-rowdib='27' data-coldib='0'> DL </td></tr><tr data-rowdib='6'><td data-rowdib='28' data-coldib='0'> <br> <br></td></tr><tr data-rowdib='6'><td data-rowdib='29' data-coldib='0'><b>RabbitIP</b> </td></tr></table>");
			myTableaccepinfo.html("");
			var losbuttons= "";			
										
			
			$.ajax
			({ 
				url: 'aja_show_acceptdatadb.php',
				data: "tipodb="+placadb+"&ciu="+placadbciu+"&sn="+dbsn,	
				type: 'post',
				async:true,
                cache:false,
				success: function(data)
				{
					//alert(data);
					//var datax = JSON.parse(data)
				    $("#msjwait").hide();
				 	$('#ciusnshow').html( $('#ciusnshowbks').html() + ' &nbsp; '+ placadbciu + ' -SN: ' + dbsn ); 
						$.each(data.gi, function(i, itemdib) {
							console.log('muestro itemdib:'+itemdib.totalpass);
							AddNewColdl(1,itemdib,'dib');				
						});						
								
						$.each(data.gilog, function(ilg, itemlg) {
								console.log('Log:'+itemlg.idlog);
							
						
								losbuttons = losbuttons + '<a href="#"  onclick="show_log('+itemlg.idlog+')"><span class="badge badge-primary" ><i class="fas fa-search"></i> Iteration: '+itemlg.idit+' ->'+itemlg.idlog+'</span></a> - ';
							
							
							
						});							
						losbuttons = losbuttons + '<textarea class="form-control" rows="18" id="detallelog" name="detallelog"></textarea>';
						$('#infolog').html(losbuttons); 
						
					$("#myTablepa").addClass('d-none');	
					$("#myTabledib").removeClass('d-none');
					$("#myTabledibciu").removeClass('d-none');
					
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
			console.log ('new ro chanel:'+arram[0][2]+'-ch'+arram[0][1]);
			
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
	
	
	function listarsn( paramciu)
	{
		console.log('listar' + paramciu)
	//	divFIP446
	$('#msjwait').show();
		$("#divgeneralinfo").addClass('d-none');
				$("#divgeneralinfoparam").addClass('d-none');
				$("#divdetinfolog").addClass('d-none');
				
				$("#diveq").addClass('d-none');
				$("#divfactory").addClass('d-none');
				$("#divfinalcheck").addClass('d-none');
				$("#divgroupbyciu").addClass('d-none');
				
					$("#myTablepa").addClass('d-none');
					$("#myTabledib").addClass('d-none');
					$("#myTabledibciu").addClass('d-none');
				


	var armando_tabla ="";
		$.ajax({
				url: 'acceptancelistsn.php?pciu='+paramciu,										
				 cache:false,
				success: function(respuesta) {
					
					armando_tabla=respuesta;
					
									
			
			//console.log('abrir div'+idsnaver);
			$('#divFIP446').html("");
			$('#divFIP467').html("");
		    $('#divFIP488').html("");

					$('#div'+paramciu).html(""+armando_tabla);
					$('#msjwait').hide();
				},
				error: function() {
					console.log("No se ha podido obtener la información");
					$('#viewcalib'+paramciu).html("");
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

function reportarme()
{
	var elscr = $("#losscripts").val();
	var txtfechad = $("#txtfechad").val();
	var txtfechah = $("#txtfechah").val();
	if (elscr =='' || txtfechad == '' )
	{
		toastr["error"]("Missing select parameters to generate the report", "Error...");	
	}
	else
	{
		toastr["success"]("...Wait..", "Working");		



		var armando_tabla ="";
		$.ajax({
				url: 'ajax_acceptance_graphallsnrun.php?pfd='+txtfechad+'&pfh='+txtfechah+'&elscr='+elscr ,										
				 cache:false,
				success: function(respuesta) {
					
					armando_tabla=respuesta;
					
									
			
			//console.log('abrir div'+respuesta);
					$('#grafdetalle').html("");
					$('#grafdetalle').html(""+armando_tabla);
					$('#msjwait').hide();
				},
				error: function() {
					console.log("No se ha podido obtener la información");
					$('grafdetalle').html("");
				}
			});


	}

}	

$('#reportrange').on('apply.daterangepicker', function(ev, picker) {
  console.log(picker.startDate.format('YYYY-MM-DD'));
  $("#txtfechad").val(picker.startDate.format('YYYY-MM-DD'));
  $("#txtfechah").val(picker.endDate.format('YYYY-MM-DD'));
  console.log(picker.endDate.format('YYYY-MM-DD'));
});
   
</script>

</html>

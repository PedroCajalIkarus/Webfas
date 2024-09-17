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
		///	exit();
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
  <link href="css/smart_wizard_all.min.css" rel="stylesheet" type="text/css" />
 <link href="css/tabulator_bulma.css" rel="stylesheet">
 
  
    <link rel="stylesheet" href="cssfiplex2.css">
	
	<style>
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
<form name="frma" id="frma" action="abmmodules.php" method="post">
<input type="hidden" name="uso" id="uso" value="0">
<input type="hidden" name="radbuttypeprod" id="radbuttypeprod" value="0">

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
        <a href="index.php" class="nav-link">Home</a>
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
            <h1>Wizard module creator</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Wizard module creator </li>
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
		
			<div class="col-lg-4">
			  <div class="card">
			    <div class="card-header border-0">
					 <div class="d-flex justify-content-between">
					  <h3 class="card-title">Step 1 - Configure Module</h3>
					
					</div>
				  </div>
			  
			  
		
				 <div class="tree">
						<ul>
							<li><span><a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#Web" aria-expanded="true" aria-controls="Web"><i class="collapsed"></i>
							<i class="expanded"><i class="far fa-folder-open"></i></i> Family Tree</a></span>
							<div id="Web" class="collapse show">
							<ul>
											
			<?php	
				$query_listagroup = "select familyproducts.idfamilygroup , namefamilygroup,  array_agg( DISTINCT coalesce(namefamily,'')) as namefamilygroup2 
						from familyproducts
						inner join typeproducts
						on typeproducts.idfamilyprod = familyproducts.idfamilyprod and 
							 typeproducts.idfamilygroup = familyproducts.idfamilygroup and
						typeproducts.active='Y' 
						inner join familygroup
on familygroup.idfamilygroup = familyproducts.idfamilygroup 
						 where familyproducts.active='Y' and familyproducts.idfamilygroup = 1
						group by familyproducts.idfamilygroup ,namefamilygroup
						order by namefamilygroup2 ";	
													//	echo $query_lista;									   
						$datagroup = $connect->query($query_listagroup)->fetchAll();
						$searchgroup  = array('{', '}','"');
						$replacegroup = array('', '','');
						$iddatosgroup = 0;
						foreach ($datagroup as $rowgroup) 
							{	
							?>
							<li><span>
							<a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#foldergroup<?php echo $rowgroup['idfamilygroup'];?>" aria-expanded="false" aria-controls="folder<?php echo $iddatosgroup;?>">
							<i class="collapsed"></i>
							<i class="expanded"><i class="fa fa-inbox"></i></i> <?php echo $rowgroup['namefamilygroup'];  ?></a> </span>
							
								<div id="foldergroup<?php echo  $rowgroup['idfamilygroup'];?>" class="collapse marcoopen">
									<ul>
									<!-- mostrar por cada grupo de familia --->
								
	<?php	
			
				$query_lista = "select namefamily, 				
				array_agg( concat(familyproducts.idfamilygroup,'#',typeproducts.idfamilyprod,'#',idtypeproducts, '#',coalesce(description,'')) order by description asc) as groupbutypeflia
						from familyproducts
						inner join typeproducts
						on typeproducts.idfamilyprod = familyproducts.idfamilyprod and 
						typeproducts.active='Y' 
						 where familyproducts.active='Y' and familyproducts.idfamilygroup = ".$rowgroup['idfamilygroup']."
						group by namefamily 
						order by namefamily";	
													//	echo $query_lista;									   
													$data = $connect->query($query_lista)->fetchAll();		

						$search  = array('{', '}','"');
						$replace = array('', '','');

							//	echo $query_lista;									   
						$data = $connect->query($query_lista)->fetchAll();		

						


						$temonombretypeaccep="";
						$iddatos=0;
							//echo  $query_lista;
							foreach ($data as $row) 
							{
								?>
								<li><span><a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#folder<?php echo $rowgroup['idfamilygroup'].$iddatos;?>" aria-expanded="false" aria-controls="folder<?php echo $iddatos;?>"><i class="collapsed"></i>
		
								<?php
								
												
											
												$bgclass="bg-secondary";
												  $bgclass="bg-warning";
											
												 
									//Antes de mostrar pregunto si tiene mas ramas.
								?>
								<i class="expanded"> <i class="fa fa-inbox"></i></i> <?php echo $row['namefamily'];  ?>  </a> </span>
							
									<?php 
									$lossn = $array = explode(",", $row['groupbutypeflia']);
									if ( count($lossn) >0)
									{
									?>
									<ul><div id="folder<?php echo $rowgroup['idfamilygroup'].$iddatos;?>" class="collapse marcoopen">
									<?php
										for($i = 0; $i < count($lossn); $i++){
											
											$losdatos = explode("#", str_replace($search, $replace, $lossn[$i]));
										
											echo "<li class='treemm'><span>";
											echo ''.$losdatos[3].' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small> <input type="radio" class="form-check-input" onclick="primerpaso(this.value)" name="qramaes" id="qramaes'.$losdatos[2].'" value="'.str_replace("#","_",str_replace($search, $replace, $lossn[$i])).'">  <label class="form-check-label" for="exampleCheck1">[add module to this branch]</label></small> ';
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
									<!-- fin mostrar por cada grupo de familia  --->
									
									</ul>
								</div>
													
							</li>
						<?php	
						//----BUSCAMOS POR FLIA
						
				
							}
					?>
							
							
							
					</ul>	
					</div>
					</li>
					
					</ul>	
					</div>

				<!-- fin aca tree -->
			  <!-- fin inicio arbol -->
			</div>
			</div>
			<div class="col-lg-8">
					 <div class="card">
						<div class="card-header border-0">
							<div class="d-flex justify-content-between">
							<h3 class="card-title">   Step 2 - Module Parameters</h3>
					
							</div>
						</div>
						
							<div class="card-body">
							
							
									   <div class="row">
										<div class="col-sm-6">
										  <!-- text input -->
										  <div class="form-group">
											<label>new module name</label>
										<input type="text" name="txtnewprod" id="txtnewprod" class="form-control" onkeypress="habilitarsiguiente()" onblur="habilitarsiguiente()" >
										  </div>
										</div>
										<div class="col-sm-6">
										  <div class="form-group">
											<label>new description:</label>
												<textarea class="form-control" rows="10" cols="50" placeholder="Enter ..."></textarea>
										  </div>
										</div>
										
										<!-- parte formu para PASSIVE Coupler 
				Coupling(dB)
				Insertion Loss(dB)
				Isolation(dB)
				Freq start(MHz)
				Freq stop(MHz)
				-->
				
				<div id="1_7_6_Coupler" name="1_7_6_Coupler" class="a">
					<span class="colorazulfiplex">Module::Coupler</span><span id="newnamelabel" name="newnamelabel" class="colorazulfiplex"></span><hr>				
					<div class="row">
					<div class="col-sm-4"> 	<label >	Coupling(dB):</label><br>
						<input type="number" class="form-control  col-sm-2" onkeypress="habilitarfin('coupler')" id="txtcoupling" data-validate="false" name="txtcoupling" >
					</div>
					<div class="col-sm-4">	<label >Insertion Loss(dB):</label><br>
						<input type="number" class="form-control  col-sm-2" onkeypress="habilitarfin('coupler')" id="txtcouplinginserloss" data-validate="false" name="txtcouplinginserloss" ></div>
					<div class="col-sm-4"> 	<label >Isolation(dB):</label><br>
						<input type="number" class="form-control  col-sm-2" onkeypress="habilitarfin('coupler')" id="txtcouplingisolat" data-validate="false" name="txtcouplingisolat" ></div>
				   </div>
				   <div class="row">
					<div class="col-sm-4"> 	<label >	Freq start(MHz):<br>
						<input type="text" class="form-control  col-sm-6" onkeypress="habilitarfin('coupler')" id="txtcouplingfreqstart" data-validate="false" name="txtcouplingfreqstart" ></label></div>
					<div class="col-sm-4">	<label >Freq stop(MHz):<br>
						<input type="text" class="form-control  col-sm-6" onkeypress="habilitarfin('coupler')" id="txtcouplingfreqstop" data-validate="false" name="txtcouplingfreqstop" ></label></div>
					<div class="col-sm-4"> 	</div>
				   </div>				   
				</div>
			<!-- fin parte formu para PASSIVE Coupler -->
			
			<!-- parte formu para PASSIVE DUPLEXER  
				freq start(MHz)
				freq stop(MHz)
				Tx-Rx Separation(dB)
				Insertion Loss Tx - Antenna(dB)
				Insertion Loss Antenna - Rx(dB)
				Tx Noise Rejection at Rx Freq(dB)
				Rx-Tx Isolation at Tx Freq(dB)
				-->
				
				<div id="1_7_7_Duplexer" name ="1_7_7_Duplexer">
						<span class="colorazulfiplex">Module::Duplexer</span><span id="newnamelabel" name="newnamelabel" class="colorazulfiplex"></span><hr>			
					<div class="row">
					<div class="col-sm-4"> 	<label >Tx-Rx Separation(dB):</label><br>
						<input type="number" class="form-control  col-sm-2" id="duplextxrx" data-validate="false" name="duplextxrx" >
					</div>
					<div class="col-sm-4">	<label >Insertion Loss Tx(dB) Antenna:</label><br>
						<input type="number" class="form-control  col-sm-2" id="duplextxrxinserlosstx" data-validate="false" name="duplextxrxinserlosstx" ></div>
					<div class="col-sm-4">	<label >Insertion Loss Rx(dB) Antenna:</label><br>
						<input type="number" class="form-control  col-sm-2" id="duplextxrxinserlossrx" data-validate="false" name="duplextxrxinserlossrx" ></div>
						
					
				   </div>
				 
				   <div class="row">
					<div class="col-sm-4"> 	<label >	Freq start(MHz):<br>
						<input type="text" class="form-control  col-sm-6" id="duplexfreqstart" data-validate="false" name="duplexfreqstart" ></label></div>
					<div class="col-sm-4">	<label >Freq stop(MHz):<br>
						<input type="text" class="form-control  col-sm-6" id="duplexfreqstop" data-validate="false" name="duplexfreqstop" ></label></div>
					<div class="col-sm-4"> 	<label >Tx Noise Rejection at Rx Freq(dB):</label><br>
						<input type="number" class="form-control  col-sm-2" id="duplexnoiserx" data-validate="false" name="duplexnoiserx" ></div>
				   </div>
				
					<div class="row">
						<div class="col-sm-4"> 	<label >Rx-Tx Isolation at Tx Freq(dB):</label><br>
						<input type="number" class="form-control  col-sm-2" id="duplexisolarxtx" data-validate="false" name="duplexisolarxtx" ></div>
					</div>	
  
				</div>
			<!-- fin parte formu para PASSIVE DUPLEXER   -->
			
				<!-- parte formu para PASSIVE Preselector   
				frequency start(MHz)
				frequency stop(MHz)
				BandWidth (MHz)
				Insertion loss(dB)
				-->
			
				<div id="1_7_8_Preselector" name="1_7_8_Preselector">
				<span class="colorazulfiplex">Module::Preselector</span><span id="newnamelabel" name="newnamelabel" class="colorazulfiplex"></span><hr>			 				
					<div class="row">
					<div class="col-sm-4"> 	<label >	BandWidth (MHz):</label><br>
						<input type="number" class="form-control  col-sm-2" id="txtbandwidth" data-validate="false" name="txtbandwidth" >
					</div>
					<div class="col-sm-4">	<label >Insertion Loss(dB):</label><br>
						<input type="number" class="form-control  col-sm-2" id="txtbandwidthinserloss" data-validate="false" name="txtbandwidthinserloss" ></div>
				
				   </div>
				   <div class="row">
					<div class="col-sm-4"> 	<label >	Freq start(MHz):<br>
						<input type="text" class="form-control  col-sm-6" id="txtbandwidthfreqstart" data-validate="false" name="txtbandwidthfreqstart" ></label></div>
					<div class="col-sm-4">	<label >Freq stop(MHz):<br>
						<input type="text" class="form-control  col-sm-6" id="txtbandwidthfreqstop" data-validate="false" name="txtbandwidthfreqstop" ></label></div>
					<div class="col-sm-4"> 	</div>
				   </div>				   
				</div>
			<!-- fin parte formu para PASSIVE Preselector    -->
					
				<!-- parte formu para PASSIVE Splitter 
			freq start
			freq stop
			Split Loss
			Insertion Loss
			Numbers of ways
				-->
				
				<div id="1_7_5_Splitter" name = "1_7_5_Splitter">			
					<div class="row">
				<span class="colorazulfiplex">Module :: Splitter </span><span id="newnamelabel" name="newnamelabel" class="colorazulfiplex"></span><hr>			 				 	
					<div class="col-sm-4"> 	<label >	Split Loss:</label><br>
						<input type="number" class="form-control  col-sm-2" id="txtsplitloss" data-validate="false" name="txtsplitloss" >
					</div>
					<div class="col-sm-4">	<label >Insertion Loss(dB):</label><br>
						<input type="number" class="form-control  col-sm-2" id="txtsplitinserloss" data-validate="false" name="txtsplitinserloss" ></div>
				  <div class="col-sm-4">	<label >Numbers of ways:</label><br>
						<input type="number" class="form-control  col-sm-2" id="txtsplitnroway" data-validate="false" name="txtsplitnroway" ></div>
				
				   </div>
				   <div class="row">
					<div class="col-sm-4"> 	<label >	Freq start(MHz):<br>
						<input type="text" class="form-control  col-sm-6" id="txtsplitfreqstart" data-validate="false" name="txtsplitfreqstart" ></label></div>
					<div class="col-sm-4">	<label >Freq stop(MHz):<br>
						<input type="text" class="form-control  col-sm-6" id="txtsplitfreqstop" data-validate="false" name="txtsplitfreqstop" ></label></div>
					<div class="col-sm-4"> 	</div>
				   </div>				   
				</div>
			<!-- fin parte formu para PASSIVE Splitter  -->
									  </div>
				  
														
							</div>
						
						
					 </div>	
			</div>
			
			Version nueva
		
		
          <section class="col-lg-12 connectedSortable ui-sortable">

            <div class="" name="divscrolllog" id="divscrolllog" style="display.">
			<p name="msjwaitline" id="msjwaitline" align="center"><img src="img/waitazul.gif" width="100px" ></p>	
				<div class="card">
				
			
				
				
				
					  <!-- SmartWizard html -->
  <div id="smartwizard">

    <ul class="nav">
        <li class="nav-item">
          <a class="nav-link" href="#step-1">
            Step 1 - Configure Module
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#step-2">
            Step 2 - Module Parameters
          </a>
        </li>
      
    </ul>

    <div class="tab-content">
        <div id="step-1" class="tab-pane" role="tabpanel" aria-labelledby="step-1">
					<div class="card-body form-row">	
						<div class="form-group col-md-6 ">
									
									
									 <div class="tree">
						<ul>
							<li><span><a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#Web" aria-expanded="true" aria-controls="Web"><i class="collapsed"></i>
							<i class="expanded"><i class="far fa-folder-open"></i></i> Family Tree</a></span>
							<div id="Web" class="collapse show">
							<ul>
											
			<?php	
				$query_listagroup = "select familyproducts.idfamilygroup , namefamilygroup,  array_agg( DISTINCT coalesce(namefamily,'')) as namefamilygroup2 
						from familyproducts
						inner join typeproducts
						on typeproducts.idfamilyprod = familyproducts.idfamilyprod and 
							 typeproducts.idfamilygroup = familyproducts.idfamilygroup and
						typeproducts.active='Y' 
						inner join familygroup
on familygroup.idfamilygroup = familyproducts.idfamilygroup 
						 where familyproducts.active='Y' and familyproducts.idfamilygroup = 1
						group by familyproducts.idfamilygroup ,namefamilygroup
						order by namefamilygroup2 ";	
													//	echo $query_lista;									   
						$datagroup = $connect->query($query_listagroup)->fetchAll();
						$searchgroup  = array('{', '}','"');
						$replacegroup = array('', '','');
						$iddatosgroup = 0;
						foreach ($datagroup as $rowgroup) 
							{	
							?>
							<li><span>
							<a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#foldergroup<?php echo $rowgroup['idfamilygroup'];?>" aria-expanded="false" aria-controls="folder<?php echo $iddatosgroup;?>">
							<i class="collapsed"></i>
							<i class="expanded"><i class="fa fa-inbox"></i></i> <?php echo $rowgroup['namefamilygroup'];  ?></a> </span>
							
								<div id="foldergroup<?php echo  $rowgroup['idfamilygroup'];?>" class="collapse marcoopen">
									<ul>
									<!-- mostrar por cada grupo de familia --->
								
	<?php	
			
				$query_lista = "select namefamily, 				
				array_agg( concat(familyproducts.idfamilygroup,'#',typeproducts.idfamilyprod,'#',idtypeproducts, '#',coalesce(description,'')) order by description asc) as groupbutypeflia
						from familyproducts
						inner join typeproducts
						on typeproducts.idfamilyprod = familyproducts.idfamilyprod and 
						typeproducts.active='Y' 
						 where familyproducts.active='Y' and familyproducts.idfamilygroup = ".$rowgroup['idfamilygroup']."
						group by namefamily 
						order by namefamily";	
													//	echo $query_lista;									   
													$data = $connect->query($query_lista)->fetchAll();		

						$search  = array('{', '}','"');
						$replace = array('', '','');

							//	echo $query_lista;									   
						$data = $connect->query($query_lista)->fetchAll();		

						


						$temonombretypeaccep="";
						$iddatos=0;
							//echo  $query_lista;
							foreach ($data as $row) 
							{
								?>
								<li><span><a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#folder<?php echo $rowgroup['idfamilygroup'].$iddatos;?>" aria-expanded="false" aria-controls="folder<?php echo $iddatos;?>"><i class="collapsed"></i>
		
								<?php
								
												
											
												$bgclass="bg-secondary";
												  $bgclass="bg-warning";
											
												 
									//Antes de mostrar pregunto si tiene mas ramas.
								?>
								<i class="expanded"> <i class="fa fa-inbox"></i></i> <?php echo $row['namefamily'];  ?>  </a> </span>
							
									<?php 
									$lossn = $array = explode(",", $row['groupbutypeflia']);
									if ( count($lossn) >0)
									{
									?>
									<ul><div id="folder<?php echo $rowgroup['idfamilygroup'].$iddatos;?>" class="collapse marcoopen">
									<?php
										for($i = 0; $i < count($lossn); $i++){
											
											$losdatos = explode("#", str_replace($search, $replace, $lossn[$i]));
										
											echo "<li class='treemm'><span>";
											echo ''.$losdatos[3].' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small> <input type="radio" class="form-check-input" onclick="primerpaso(this.value)" name="qramaes" id="qramaes'.$losdatos[2].'" value="'.str_replace("#","_",str_replace($search, $replace, $lossn[$i])).'">  <label class="form-check-label" for="exampleCheck1">[add module to this branch]</label></small> ';
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
									<!-- fin mostrar por cada grupo de familia  --->
									
									</ul>
								</div>
													
							</li>
						<?php	
						//----BUSCAMOS POR FLIA
						
				
							}
					?>
							
							
							
					</ul>	
					</div>
					</li>
					
					</ul>	
					</div>

				<!-- fin aca tree -->
			  <!-- fin inicio arbol -->
									
						</div>	
						<div class="form-group col-md-6 ">
							<label >new module name:</label>
									<br>									
									<input type="text" name="txtnewprod" id="txtnewprod" class="form-control" onkeypress="habilitarsiguiente()" onblur="habilitarsiguiente()" >
									<hr>
										<label >new description:</label>
									<br>									
									<textarea class="form-control" rows="10" cols="50" placeholder="Enter ..."></textarea>
										
									
								
									
						</div>
						
						</div>							
        </div>
        <div id="step-2" class="tab-pane" role="tabpanel" aria-labelledby="step-2">
		
				ssssssssssssssssssssss
			
        </div>
     
    </div>
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

<script src="js/jquery-3.3.1.min.js"></script>
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
 <script src="js/jquery.smartWizard.min.js" type="text/javascript"></script>

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


 // Smart Wizard
 
   // Toolbar extra buttons
          var btnFinish = $('<button name="btnfin" id="btnfin"></button>').text('Finish')
                                           .addClass('btn btn-info disabled ')
                                           .on('click', function(){ alert('Finish Clicked'); });
										   
        $('#smartwizard').smartWizard({
  selected: 0, // Initial selected step, 0 = first step
  theme: 'arrows', // theme for the wizard, related css need to include for other than default theme
  justified: true, // Nav menu justification. true/false
  autoAdjustHeight: true, // Automatically adjust content height
  cycleSteps: false, // Allows to cycle the navigation of steps
  backButtonSupport: true, // Enable the back button support
  enableURLhash: true, // Enable selection of the step based on url hash
  transition: {
      animation: 'none', // Effect on navigation, none/fade/slide-horizontal/slide-vertical/slide-swing
      speed: '400', // Transion animation speed
      easing:'' // Transition animation easing. Not supported without a jQuery easing plugin
  },
   keyboardSettings: {
      keyNavigation: true, // Enable/Disable keyboard navigation(left and right keys are used if enabled)
      keyLeft: [37], // Left key code
      keyRight: [39] // Right key code
  },
  lang: { // Language variables for button
      next: 'Next',
      previous: 'Previous'
  },
  disabledSteps: [], // Array Steps disabled
  errorSteps: [], // Highlight step with errors
    toolbarSettings: {
                   toolbarExtraButtons: [btnFinish]
              },
  hiddenSteps: [] // Hidden steps
});
			
			
			$('.sw-btn-next').addClass('disabled');
			$('.sw-btn-next').prop('disabled', true);
			     
			
	});
	

	// controlar inactividad en la web	
		$(document).inactivityTimeout({
                inactivityWait: 10000,
                dialogWait: 10,
                logoutUrl: 'logout.php'
            })
	// fin controlar inactividad en la web		
	
	 /* requesting data */
     function habilitarsiguiente()
	 {
		// console.log('valiar'+ $("#txtnewprod").val());
		 $('.sw-btn-next').addClass('disabled');
		if ( $("#txtnewprod").val() !='')
		{
			if ( $("#radbuttypeprod").val() !='')
			{
						$('.sw-btn-next').removeClass('disabled');
				   $('.sw-btn-next').prop('disabled', false);
			}
				
		}
	 }	 
		
	function habilitarfin(qtipodemodulocargaron)	
	{
		contadordefaltantes = 0;
		// inicio control coupler
		console.log('validar2:' + contadordefaltantes);
		if(qtipodemodulocargaron =='coupler')
		{				
			if ($("#txtcoupling").val()=="") {contadordefaltantes=1;}
			if ($("#txtcouplinginserloss").val()=="") {contadordefaltantes=1;}
			if ($("#txtcouplingisolat").val()=="") {contadordefaltantes=1;}
			if ($("#txtcouplingfreqstart").val()=="") {contadordefaltantes=1;}
			if ($("#txtcouplingfreqstop").val()=="") {contadordefaltantes=1;}
		}
		// fin control coupler
		console.log('validar:' + contadordefaltantes);
		if (contadordefaltantes == 0)
		{
				$('#btnfin').removeClass('disabled');
				  $('#btnfin').prop('disabled', false);
		}
		else
		{
			
				  $('#btnfin').prop('disabled', true);
		}
	}
		
	function primerpaso(vvalor)
	{
		console.log('radio button' + vvalor);
		 $("#radbuttypeprod").val(vvalor);
		$('#1_7_6_Coupler').addClass('d-none');
		$('#1_7_7_Duplexer').addClass('d-none');
		$('#1_7_8_Preselector').addClass('d-none');
		$('#1_7_5_Splitter').addClass('d-none');
		
	
		var nvovalor = vvalor;
		console.log('Nvo valor button' + nvovalor);
		$('#'+nvovalor).removeClass('d-none');
		if ( $("#txtnewprod").val() !='')
		{
					$('.sw-btn-next').removeClass('disabled');
				   $('.sw-btn-next').prop('disabled', false);
		}
	}	
	
	
   
   $("#smartwizard").on("stepContent",function(e, anchorObject, stepIndex, stepDirection) {
	 
	$('.sw-btn-next').addClass('disabled');
		console.log('Step:' +stepIndex);
		$('.sw-btn-next').addClass('disabled');
		if (stepIndex >0)
		{
			
			//alert('a' + stepIndex + '-' + $('#radbuttypeprod').val()); //los stepIndex comienzan en 0 
		if ($('#radbuttypeprod').val() =='0')			
			{
					toastr["warning"]("", "Attention ::Wizard Module");
					
					
				$('#1_7_6_Coupler').addClass('d-none');
				$('#1_7_7_Duplexer').addClass('d-none');
				$('#1_7_8_Preselector').addClass('d-none');
				$('#1_7_5_Splitter').addClass('d-none');
		
					return false;
			}
		else
			{	
			
			
				if (stepIndex == 1)
				{
					
					
	
					if( $("#radbuttypeprod").val() ==0) 
					{
						$('#smartwizard').smartWizard("reset");
					}
					else
					{
					console.log('a');
						// completo el nombre del Tipo de Modulo a crear.
						//newnamelabel
						$("#newnamelabel").html('::' + $("#txtnewprod").val() );
					}
				
					/*if ($('#idbw').val() !='')			
					{
						$('#smartwizard').smartWizard("stepState", [2], "enable");
						$('#smartwizard').smartWizard("stepState", [3], "enable");
							$('.sw-btn-next').addClass('disabled');
							$('.sw-btn-next').prop('disabled', true);
					}
					if ($('#idbwclassb').val() !='')			
					{
						$('#smartwizard').smartWizard("stepState", [2], "enable");
						$('#smartwizard').smartWizard("stepState", [3], "enable");
							$('.sw-btn-next').addClass('disabled');
							$('.sw-btn-next').prop('disabled', true);
					}*/
				}
		}	
		//Fin if control radio button
		}
		//Fin if control step mayor 1
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
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
		
        $sessionTTL = time() - $_SESSION["timeout"];
		echo "***********hola". $sessionTTL;
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

label:not(.form-check-label):not(.custom-file-label) {
    font-weight: 100; 
}

.
{
	border-color: #0053a1;
}
.
{
	border-color: #f39323;
}

</style>
</head>
<form name="frma" id="frma" action="abmmodules.php" method="post" class="form-horizontal">
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
            <h1>Wizard to create modules / units</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Wizard to create modules / units </li>
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
					  <h3 class="card-title">Configure Unit / Module</h3>
					
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
						 where familyproducts.active='Y' 
						 ---and familyproducts.idfamilygroup = 1
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
							<a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#foldergroup<?php echo $rowgroup['idfamilygroup'];?>" aria-expanded="false" aria-controls="foldergroup<?php echo $rowgroup['idfamilygroup'];?>">
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
										for($i = 0; $i < count($lossn); $i++)
										{
											
											$losdatos = explode("#", str_replace($search, $replace, $lossn[$i]));
										
												?>
											<li><span>
												<a style="color:#000; text-decoration:none;" data-toggle="collapse" href="#afolder<?php echo $rowgroup['idfamilygroup'].$iddatos.$losdatos[3];?>" aria-expanded="false" aria-controls="folder<?php echo $iddatos;?>">
												<i class="collapsed"></i>
		
		
		
											<?php
											//echo "<li class='treemm'><span>";
											if ($losdatos[3] == "Migration")
											{
												echo '<i class="fa fa-inbox"></i></i> &nbsp;<label class="text-danger">'.$losdatos[3].'</label></a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
											}
											else
											{
												echo '<i class="fa fa-inbox"></i></i> &nbsp;'.$losdatos[3].'</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<small> <input type="radio" class="form-check-input" onclick="primerpaso(this.value)" name="qramaes'.$losdatos[2].'" id="qramaes'.$losdatos[2].'" value="'.str_replace(" ","*",str_replace("#","_",str_replace($search, $replace, $lossn[$i]))).'">  <label class="form-check-label" for="exampleCheck1">[add module to this branch]</label></small> ';
											}
								
											
												echo "</span>";
											?>
												
													<ul>
													<div id="afolder<?php echo $rowgroup['idfamilygroup'].$iddatos.$losdatos[3];?>" class="collapse marcoopen">
														<?php
														
														$querysearchmodelus = "select * from products where idfamilygroup = ".$losdatos[0]." and idfamilyprod = ".$losdatos[1]." and idtypeproduct = ".$losdatos[2]."  order by modelciu";
														$data_busca_modelos = $connect->query($querysearchmodelus)->fetchAll();	

														foreach ($data_busca_modelos as $rowencontrados) 
														{
															if ($losdatos[3] == "Migration")
															{
																?>
															<li class='treemm'> <span onclick="buscadatos('<?php echo $rowencontrados['idproduct'];?> ','<?php echo $losdatos[3];?>')" class="text-danger"><i class="fa fa-eye"></i>&nbsp;  <?php echo $rowencontrados['modelciu'];?> </span>	</li>															
															<?php
															}
															else
															{
																?>
															<li class='treemm' > <span onclick="buscadatos('<?php echo $rowencontrados['idproduct'];?> ','<?php echo $losdatos[3];?>')"> <i class="fa fa-eye"></i>&nbsp;<?php echo $rowencontrados['modelciu'];?> </span>	</li>															
															<?php
															}
															
														}
														
														?>
														
													
													</div>
													</ul>
												
											<?php
												echo "</li>";
										
											//echo "<li class='treemm'><span><button class='btn btn-sm' onclick='mostrar_calibrarion(this.value)' value='".str_replace($search, $replace, $lossn[$i])."'> SN:".  str_replace($search, $replace, $lossn[$i])."</button></span></li>";
											
											//echo "</li>";
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
							<h3 class="card-title colorazulfiplex " id="lbltitulo" name="lbltitulo"><b>  CIU Specs :: XXXXXX</b></h3>
					
							</div>
						</div>
						
							<div class="card-body">
							
							
									   <div class="row">
									   
									   <div class="col-sm-6">
										  <!-- text input -->
										  <div class="form-group">
											<label>Select Business:</label>
												<select class="form-control form-control-sm" name="txtbusiness" id="txtbusiness" required oninvalid="setCustomValidity('Business is required.')" oninput="setCustomValidity('')">
												 <option value=""> - Select - </option>
												 <option value="1" selected>FIPLEX US</option>
												
												  <option value="3">SPINNAKER</option>
												    <option value="2">WESTELL</option>
											    
											  </select>
										  </div>
										</div>
										
										
										<div class="col-sm-6">
										  <!-- text input -->
										  <div class="form-group">
											<label>New module name</label>
											<input type="text" name="txtnewprod" placeholder="new module name" id="txtnewprod" class="form-control" onkeypress="habilitarsiguiente()" onblur="habilitarsiguiente()" >
										  </div>
										</div>
										<div class="col-sm-6">
										  <div class="form-group">
											<label>New description:</label>
													<input type="text" placeholder="new description" name="txtnewproddescr" id="txtnewproddescr" class="form-control" >
										  </div>
										</div>
										<div class="col-sm-6 d-none" id="divtipomod" name="divtipomod">
										  <div class="form-group">
											<label>Type Module :</label>
													<select class="form-control form-control-sm" onChange="primerpaso(this.value)" name="txtmodiftypemodule" id="txtmodiftypemodule" required oninvalid="setCustomValidity('Business is required.')" oninput="setCustomValidity('')">
												 <option value=""> - Select - </option>
												 <option value="1_7_6_Coupler">COUPLER</option>
												
												  <option value="1_7_7_Duplexer">DUPLEXER</option>
												    <option value="1_7_8_Preselector">PRESELECTOR</option>
													<option value="1_7_10_Splitter">SPLITTER</option>
											    
											  </select>
										  </div>
										</div>
							</div>
										<!-- parte formu para PASSIVE Coupler 
				Coupling(dB)
				Insertion Loss(dB)
				Isolation(dB)
				Freq start(MHz)
				Freq stop(MHz)
				-->
				
				<div id="1_7_6_Coupler" name="1_7_6_Coupler" class="col-sm-12">
					<span class="colorazulfiplex"><b><hr>Power Specs (dB)</b></span><span id="newnamelabel" name="newnamelabel" class="colorazulfiplex"></span><br>	<br>				
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
							<label >	Coupling(dB):</label><br>
							<input type="text" class="form-control" placeholder="Coupling" onblur="habilitarfin('coupler')" id="txtcoupling" data-validate="false" name="txtcoupling" >
							</div>
						</div>
						<div class="col-sm-6">	
							<div class="form-group"><label >Insertion Loss(dB):</label><br>
							<input type="text" class="form-control  " placeholder="Insertion Loss" onblur="habilitarfin('coupler')" id="txtcouplinginserloss" data-validate="false" name="txtcouplinginserloss" >
							</div>
						</div>
					</div>	
					<div class="row">	
						 
					
						 <div class="col-sm-6"> 	
							<div class="form-group">
							<label >Isolation(dB):</label><br>
							<input type="text" class="form-control " placeholder="Isolation" onblur="habilitarfin('coupler')" id="txtcouplingisolat" data-validate="false" name="txtcouplingisolat" >
							</div>
						</div>		
						
					 </div>
					<br>
					<hr>
					<span class="colorazulfiplex"><b>Frequency Specs: (MHz) </b></span><br><br>
					<div class="row">	
							<div class="col-sm-6"> 
							<div class="form-group">
							<label >Start: (MHz)</label>
							<input type="text" class="form-control  " placeholder="Freq start" onblur="habilitarfin('coupler')" id="txtcouplingfreqstart" data-validate="false" name="txtcouplingfreqstart" >
							
						 </div>	
						 </div>						 
						<div class="col-sm-6">	
							<div class="form-group">
							<label >Stop: (MHz)</label>
							<input type="text" class="form-control " placeholder="Freq stop" onblur="habilitarfin('coupler')" id="txtcouplingfreqstop" data-validate="false" name="txtcouplingfreqstop" >
							</div>
						</div>
				
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
				
				<div id="1_7_7_Duplexer" name ="1_7_7_Duplexer" class="col-sm-12">
			
					   <span class="colorazulfiplex"><hr><b>Power Specs</b></span><span id="newnamelabel" name="newnamelabel" class="colorazulfiplex"></span><br>	<br>
									
					<div class="row">
					
					
						<div class="col-sm-6"> 
							<div class="form-group">	<label >Rx-Tx Isolation at Tx Freq(dB):</label><br>
							<input type="text" class="form-control" placeholder="Rx-Tx Isolation at Tx Freq"  onblur="habilitarfin('duplexer')" id="duplexisolarxtx" data-validate="false" name="duplexisolarxtx" >
							</div>
						</div>
						
						
					
					<div class="col-sm-6"><div class="form-group">	<label >Insertion Loss Tx(dB) Antenna:</label><br>
						<input type="text" class="form-control  " placeholder="Insertion Loss Tx" onblur="habilitarfin('duplexer')" id="duplextxrxinserlosstx" data-validate="false" name="duplextxrxinserlosstx" ></div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">	
							<div class="form-group">	<label >Insertion Loss Rx(dB) Antenna:</label><br>
						<input type="text" class="form-control  " placeholder="Insertion Loss Rx" onblur="habilitarfin('duplexer')" id="duplextxrxinserlossrx" data-validate="false" name="duplextxrxinserlossrx" >
						</div>
						</div>
						<div class="col-sm-6"> 
								<div class="form-group">	<label >Tx Noise Rejection at Rx Freq(dB):</label><br>
									<input type="text" class="form-control" placeholder="Tx Noise Rejection at Rx Freq" onblur="habilitarfin('duplexer')" id="duplexnoiserx" data-validate="false" name="duplexnoiserx" >
								</div>
							</div>
					
				   </div>
				 
				 
							<br>
							<hr>
				
						<span class="colorazulfiplex"><b>Frequency Specs: (MHz) </b></span><br><br>
				   <div class="row">
					<div class="col-sm-6"> 		<div class="form-group"><label >Start(MHz):<br></label>
						<input type="text" class="form-control " placeholder="Freq start" onblur="habilitarfin('duplexer')" id="duplexfreqstart" data-validate="false" name="duplexfreqstart" >
						</div></div>
					<div class="col-sm-6">	<div class="form-group">	<label > Stop(MHz):<br></label>
						<input type="text" class="form-control" placeholder="Freq spot" onblur="habilitarfin('duplexer')" id="duplexfreqstop" data-validate="false" name="duplexfreqstop" >
						</div></div>
					</div>
					  <div class="row">
							
<div class="col-sm-6"><div class="form-group"> 	<label >Tx-Rx Separation(MHz):</label><br>
						<input type="text" class="form-control  " placeholder="Tx-Rx Separation" onblur="habilitarfin('duplexer')" id="duplextxrx" data-validate="false" name="duplextxrx" >
						</div>
					</div>

						</div>	
					
					
  
				</div>
			<!-- fin parte formu para PASSIVE DUPLEXER   -->
			
				<!-- parte formu para PASSIVE Preselector   
				frequency start(MHz)
				frequency stop(MHz)
				BandWidth (MHz)
				Insertion loss(dB)
				-->
			
				<div id="1_7_8_Preselector" name="1_7_8_Preselector" class="col-sm-12">
				<span class="colorazulfiplex"><hr><b>Power Specs</b></span><span id="newnamelabel" name="newnamelabel" class="colorazulfiplex"></span><br>	<br>	
				
					<div class="row">
						
						<div class="col-sm-12"><div class="form-group"> 	<label >Insertion Loss(dB):</label><br>
						<input type="text" class="form-control  " placeholder="Insertion Loss" onblur="habilitarfin('preselector')"  id="txtbandwidthinserloss" data-validate="false" name="txtbandwidthinserloss" >
						</div>
						</div>
				   </div>
				   <br>
				   <hr>
						
						<span class="colorazulfiplex"><b>Frequency Specs: (MHz) </b></span><br><br>
				   <div class="row">
						<div class="col-sm-6"><div class="form-group">  	<label >	Start(MHz):<br></label>
						<input type="text" class="form-control " placeholder="Freq start"  onblur="habilitarfin('preselector')"  id="txtbandwidthfreqstart" data-validate="false" name="txtbandwidthfreqstart" >
						</div>
						</div>
						
						<div class="col-sm-6">
						<div class="form-group"> 	<label > stop(MHz):<br></label>
						<input type="text" class="form-control" placeholder="Freq spot"  onblur="habilitarfin('preselector')"  id="txtbandwidthfreqstop" data-validate="false" name="txtbandwidthfreqstop" >
						</div>
						 </div>
				
				<div class="col-sm-12">
						<div class="form-group">  	<label >	BandWidth (MHz):</label><br>
						<input type="text" class="form-control  " placeholder="BandWidth " onblur="habilitarfin('preselector')" id="txtbandwidth" data-validate="false" name="txtbandwidth" >
						</div></div>
						
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
				
		
				
				<div id="1_7_10_Splitter" name = "1_7_10_Splitter" class="col-sm-12">			

						
				<span class="colorazulfiplex"><hr><b>Power Specs</b></span><span id="newnamelabel" name="newnamelabel" class="colorazulfiplex"></span><br><br>		
				 <div class="row">		 	
					<div class="col-sm-6"> 
						<div class="form-group">  	<label >	Split Loss:</label><br>
						<input type="text" class="form-control  " placeholder="Split Loss"  onblur="habilitarfin('splitter')"  id="txtsplitloss" data-validate="false" name="txtsplitloss" >
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">  	<label >Insertion Loss(dB):</label><br>
						<input type="text" class="form-control  " placeholder="Insertion Loss" onblur="habilitarfin('splitter')"  id="txtsplitinserloss" data-validate="false" name="txtsplitinserloss" ></div>
						</div>
					</div>
				
				
				  <div class="row">
					<div class="col-sm-6">
						<div class="form-group"> 	<label >Numbers of ways:</label><br>
						<input type="text" class="form-control  " placeholder="Numbers of ways" onblur="habilitarfin('splitter')"  id="txtsplitnroway" data-validate="false" name="txtsplitnroway" >
						</div>
					</div>
				   </div>
				    <br>
					<hr>
						
						<span class="colorazulfiplex"><b>Frequency Specs: (MHz) </b></span><br><br>
				   <div class="row">
					<div class="col-sm-6"><div class="form-group"> 	<label >	Start(MHz):<br></label>
						<input type="text" class="form-control " placeholder="Freq start" onblur="habilitarfin('splitter')"  id="txtsplitfreqstart" data-validate="false" name="txtsplitfreqstart" ></div>
						</div>
					<div class="col-sm-6"><div class="form-group">	<label >Stop(MHz):<br></label>
						<input type="text" class="form-control " placeholder="Freq stop" onblur="habilitarfin('splitter')"  id="txtsplitfreqstop" data-validate="false" name="txtsplitfreqstop" >
						</div>
					</div>
				   </div>				   
				</div>
			<!-- fin parte formu para PASSIVE Splitter  aca estava aca abajo  -->
									  
									  
									  
					<!-- Start Definition of bands  -->
					<div class="container-fluid" id="divfasobjband" name="divfasobjband">					  
									 <hr>	
						<span class="colorazulfiplex"><b>Band & RF Specs:</b> </span>	<br><br>
							<div class="row">
									<div class="form-group col-md-6">
									<label for="exampleInputEmail1">Band:</label>
										 <select class="form-control" name="txtbandrf" id="txtbandrf" required oninvalid="setCustomValidity('Band is required.')" oninput="setCustomValidity('')">
											   <option value=""> - Select - </option>
											<?php
											$sql = $connect->prepare("select * from idband order by description");
	 
											$sql->execute();
											$resultado3 = $sql->fetchAll();
											foreach ($resultado3 as $row2) 
											 {
												
											 ?>
											 <option value="<?php echo  $row2['idband']; ?>">
											 <?php echo  $row2['description']; ?>
											 </option>
											 <?php
											 }
											
											?>
										</select>	
									</div>	
									<div class="form-group col-md-6">
										<label for="exampleInputEmail1">Class:</label>
									 		<select class="form-control" name="txttypeclass" id="txttypeclass" required oninvalid="setCustomValidity('Class is required.')" oninput="setCustomValidity('')">
											   <option value=""> - Select - </option>
											  <option value="A">Class A</option>
											  <option value="B">Class B</option>
											
										</select>	
									</div>	
								
									
									<!--aca los ports -->
									<div class="form-group col-md-6">
										
										<label for="exampleInputEmail1">Port IN UL:</label>
									 		<select class="form-control " name="cmbportinul" id="cmbportinul" required oninvalid="setCustomValidity('Port IN UL is required.')" oninput="setCustomValidity('')">
											  
											   <option value=""> - Select - </option>
											<?php
											$sql = $connect->prepare("select * from idport order by description");
	 
											$sql->execute();
											$resultado3 = $sql->fetchAll();
											foreach ($resultado3 as $row2) 
											 {
												
											 ?>
											 <option value="<?php echo  $row2['idport']; ?>">
											 <?php echo  $row2['description']; ?>
											 </option>
											 <?php
											 }
											
											?>
												 
											
										</select>		
										
									</div>
								
									<div class="form-group col-md-6">
										
										<label for="exampleInputEmail1">Port IN DL :</label>
									 	<select class="form-control " name="cmbportindl" id="cmbportindl" required oninvalid="setCustomValidity('Port IN DL is required.')" oninput="setCustomValidity('')">
											  <option value=""> - Select - </option>
											<?php
											$sql = $connect->prepare("select * from idport order by description");
	 
											$sql->execute();
											$resultado3 = $sql->fetchAll();
											foreach ($resultado3 as $row2) 
											 {
												
											 ?>
											 <option value="<?php echo  $row2['idport']; ?>">
											 <?php echo  $row2['description']; ?>
											 </option>
											 <?php
											 }
											
											?>
												  
											
										</select>	
										
									</div>
										<div class="form-group col-md-6">
									
									<label for="exampleInputEmail1">Port OUT UL :</label>
									 		<select class="form-control " name="cmbportoutul" id="cmbportoutul" required oninvalid="setCustomValidity('Port OUT UL is required.')" oninput="setCustomValidity('')">
											    <option value=""> - Select - </option>
											<?php
											$sql = $connect->prepare("select * from idport order by description");
	 
											$sql->execute();
											$resultado3 = $sql->fetchAll();
											foreach ($resultado3 as $row2) 
											 {
												
											 ?>
											 <option value="<?php echo  $row2['idport']; ?>">
											 <?php echo  $row2['description']; ?>
											 </option>
											 <?php
											 }
											
											?>
											
										</select>	
									</div>
									<div class="form-group col-md-6">
										
										<label for="exampleInputEmail1">Port OUT DL :</label>
									 		<select class="form-control " name="cmbportoutdl" id="cmbportoutdl" required oninvalid="setCustomValidity('Port OUT DL is required.')" oninput="setCustomValidity('')">
											  <option value=""> - Select - </option>
											<?php
											$sql = $connect->prepare("select * from idport order by description");
	 
											$sql->execute();
											$resultado3 = $sql->fetchAll();
											foreach ($resultado3 as $row2) 
											 {
												
											 ?>
											 <option value="<?php echo  $row2['idport']; ?>">
											 <?php echo  $row2['description']; ?>
											 </option>
											 <?php
											 }
											
											?>
										</select>	
										
									</div>
										<div class="form-group col-md-6">
										<label for="exampleInputEmail1">UL Gain:</label>
									 		<input type="text" name="txtulgainband" id="txtulgainband" class="form-control " placeholder="UL Gain" required oninvalid="setCustomValidity('UL Gain is required.')" 
                   oninput="setCustomValidity('')" value="85">			   
									
									</div>
								
									<div class="form-group col-md-6">
									
									<label for="exampleInputEmail1">DL Gain :</label>
									 		<input type="text" name="txtdlgainband" id="txtdlgainband" class="form-control " placeholder="DL Gain " required oninvalid="setCustomValidity('DL Gain is required.')" 
                   oninput="setCustomValidity('')" value="85">	
									</div>
										<div class="form-group col-md-6">
										
										<label for="exampleInputEmail1">UL Max Pwr:</label>
									 		<input type="text" name="txtulmaxpwrband" id="txtulmaxpwrband" class="form-control " placeholder="UL Max Pwr" required oninvalid="setCustomValidity('UL Max Pwr is required.')" 
                   oninput="setCustomValidity('')" value="33">		
										
									</div>
									<div class="form-group col-md-6">
										
										<label for="exampleInputEmail1">DL Max Pwr :</label>
									 		<input type="text" name="txtdlmaxpwrband" id="txtdlmaxpwrband" class="form-control " placeholder="DL Max Pwr " required oninvalid="setCustomValidity('DL Max Pwr is required.')" 
                   oninput="setCustomValidity('')" value="24">	
										
									</div>
									
									<div class="form-group col-md-12">
											<p align="right">
												<button name="btnaddband" id="btnaddband" type="button" class="btn btn-smk btn-block btn-outline-primary btn-flat" onclick="add_list_bandrf()">Add band</button>
											</p>
											<div id="divlist_tabla_gain_rf" name="divlist_tabla_gain_rf">
											</div>
											<input type="hidden" name="divlist_tabla_gain_rftexto" id="divlist_tabla_gain_rftexto" value="">
									</div>
									
							</div>
					</div>
						<!-- end  - Definition of bands  -->					  
							<!-- inicio de FW --->		

							
				  	<div class="container-fluid" id="divfasfw" name="divfasfw">					  
									 <hr>	
						<span class="colorazulfiplex"><b>Firmware Specs:</b> </span>	<br><br>
							<div class="row">
							
							
										<div class="form-group col-md-12">
										
										<label for="exampleInputEmail1">Firmware Type:</label>
									 			<select class="form-control" onClick="habilitarfirmware(this.value)" name="txttypeclass" id="txttypeclass" required oninvalid="setCustomValidity('Class is required.')" oninput="setCustomValidity('')">
										
											  <option value="firmwarestand">Standard</option>
											  <option value="firmwarecustom">Custom</option>
											
										</select>	
								
									</div>	
										</div>	
								<div class="row " id="firmwarestand" name="firmwarestand" >	
									<div class="form-group col-md-4">
									
									<label for="exampleInputEmail1">FPGA:</label>
									 		<input type="text" name="txtfpga" disabled id="txtfpga" class="form-control" placeholder="FPGA version " required oninvalid="setCustomValidity('ETL Number is required.')" 
                   oninput="setCustomValidity('')" value="1.0">	
									</div>
									<div class="form-group col-md-4">
										
										<label for="exampleInputEmail1">uC :</label>
									 		<input type="text" name="txtuc" disabled id="txtuc" class="form-control" placeholder="uC version" required oninvalid="setCustomValidity('ETL Number is required.')" 
                   oninput="setCustomValidity('')" value="1.1">	
										
									</div>
									<div class="form-group col-md-4">
									
									<label for="exampleInputEmail1">Ethernet:</label>
									 		<input type="text" name="txtether" disabled id="txtether" class="form-control" placeholder="Eth version " required oninvalid="setCustomValidity('ETL Number is required.')" 
                   oninput="setCustomValidity('')" value="1.0">	
									</div>
									
								</div>
								<div class="row" id="firmwarecustom" name="firmwarecustom" >	
									<div class="form-group col-md-4">
									
									<label for="exampleInputEmail1">FPGA File Name:</label>
									 		<input type="text" name="txtfpgacus" disabled id="txtfpgacus" class="form-control" placeholder="FPGA File Name Custom" required oninvalid="setCustomValidity('ETL Number is required Custom.')" 
                   oninput="setCustomValidity('')" value="">	
									</div>
									<div class="form-group col-md-4">
										
										<label for="exampleInputEmail1">Uc File Name :</label>
									 		<input type="text" name="txtuccus" disabled id="txtuccus" class="form-control" placeholder="Uc File Name Custom" required oninvalid="setCustomValidity('ETL Number is required Custom.')" 
                   oninput="setCustomValidity('')" value="">	
										
									</div>
									<div class="form-group col-md-4">
									
									<label for="exampleInputEmail1">Ethernet File Name:</label>
									 		<input type="text" name="txtethercus" disabled id="txtethercus" class="form-control" placeholder="Ethernet File Name Custom" required oninvalid="setCustomValidity('ETL Number is required Custom.')" 
                   oninput="setCustomValidity('')" value="">	
									</div>
									<div class="form-group col-md-3">
										
										
										
									</div>
								</div>
					   </div>			
						<!-- fin de FW --->		


					<!-- inicio de Final Check Reference--->						  
				  	<div class="container-fluid" id="divfasfinalchkref" name="divfasfinalchkref">					  
									 <hr>	
						<span class="colorazulfiplex"><b>Final Check Reference:</b> </span>	<br><br>
							<div class="row">
							
							
									<div class="form-group col-md-6">
										
										<label for="exampleInputEmail1">Gain Tolerance:</label>
									 		<input type="text" name="txtgaintolerancebda" id="txtgaintolerancebda" onblur="habilitarfin('BDAflex')"   class="form-control " placeholder="UL Gain" required oninvalid="setCustomValidity('ETL Number is required.')" 
                   oninput="setCustomValidity('')" value="2">		
										
									</div>
									<div class="form-group col-md-6">
										
										<label for="exampleInputEmail1">Max Power Tolerance :</label>
									 		<input type="text" name="txtmaxprwtolbda" id="txtmaxprwtolbda" onblur="habilitarfin('BDAflex')" class="form-control " placeholder="UL Max Pwr " required oninvalid="setCustomValidity('ETL Number is required.')" 
                   oninput="setCustomValidity('')" value="2">	
										
									</div>
								</div>	
								<div class="row " id="ad" name="ad" >	
									<div class="form-group col-md-4">
									
									<label for="exampleInputEmail1">IMD Limit:</label>
									 		<input type="text" name="txtimdlibda"  id="txtimdlibda" onblur="habilitarfin('BDAflex')"  class="form-control" placeholder="FPGA version " required oninvalid="setCustomValidity('ETL Number is required.')" 
                   oninput="setCustomValidity('')" value="-13">	
									</div>
									<div class="form-group col-md-4">
										
										<label for="exampleInputEmail1">Noise Figure Ref. :</label>
									 		<input type="text" name="txtnoisefbda"  id="txtnoisefbda" onblur="habilitarfin('BDAflex')"  class="form-control" placeholder="uC version" required oninvalid="setCustomValidity('ETL Number is required.')" 
                   oninput="setCustomValidity('')" value="9">	
										
									</div>
									<div class="form-group col-md-4">
									
									<label for="exampleInputEmail1">Spurious Ref.:</label>
									 		<input type="text" name="txtspuriosbda"  id="txtspuriosbda" onblur="habilitarfin('BDAflex')"  class="form-control" placeholder="Eth version " required oninvalid="setCustomValidity('ETL Number is required.')" 
                   oninput="setCustomValidity('')" value="-13">	
									</div>
									
								</div>
								
					   </div>			
						<!-- fin de Final Check Reference --->		
					
							<!-- inicio de fas instruments parameters --->						  
				  	<div class="container-fluid" id="divfasinstrumetsparameters" name="divfasinstrumetsparameters">					  
									 <hr>	
						<span class="colorazulfiplex"><b>Script Specs:</b> </span>	<br><br>
								
														
								<div class="form-group col-md-12">
											
											<table class="table table-bordered  table-striped table-sm  ">
											<tbody>
												<tr css="text-center">
													<th >Associate?</th>
												<th >Measure type</th>
												<th >RBW</th>
												<th >Span</th>
												<th >Ref Level</th>
												<th>Scale Offset</th>		
												<th>Avg Count</th>
												<th>Avg On</th>
												<th>Prw In</th>												
												<th>Quantity measures</th>												
												</tr>
												
												
											<?php
											
											  $sql = $connect->prepare("select * from fas_step where  idfasstep in (3,11, 4,21,5,6,26,25,23,19,27,49,26,28,48)  order by description  ");
	 
											$sql->execute();
											$resultado3 = $sql->fetchAll();
											foreach ($resultado3 as $row2) 
											 {
												
											 ?>
											
												<tr>
												<td css="text-left">
												
												<div class="custom-control custom-switch custom-switch-on-success custom-switch-off-danger">
											  <input type="checkbox" class="custom-control-input custom-control-inputmm" value="<?php echo  $row2['idfasstep'];?>"    id="customSwitch<?php echo  $row2['idfasstep'];?>" checked>
											  <label class="custom-control-label" for="customSwitch<?php echo  $row2['idfasstep'];?>"></label>
											</div>
												
												</td>
													<td ><?php echo  $row2['description'];?></td>
												<td >1</td>
												<td >1</td>
												<td >0</td>
												<td>20</td>		
												<td>5</td>
												<td>
												
												
												
								<div class="custom-control custom-switch custom-switch-on-success custom-switch-off-danger">
								  <input type="checkbox" class="custom-control-input"   id="customSwitchb<?php echo  $row2['idfasstep'];?>" checked>
								  <label class="custom-control-label" for="customSwitchb<?php echo  $row2['idfasstep'];?>"></label>
								</div>
							
												
												</td>
												<td>-70</td>												
												<td>1</td>												
												</tr>
											
											 <?php
											 }
											
											?>
												
												
												</tbody></table>
									</div>
							<!--este -->	
					   </div>			
						<!-- fin de fas instruments parameters  --->		





						
			<!-- inicio de label --->						  
				  	<div class="container-fluid">					  
									 <hr>	
						<span class="colorazulfiplex"><b>Label Specs:</b> </span>	<br><br>
						
					
			
					<div class="row">
						
							<!-- inicio lable -->
									<div class="form-group col-md-6">
									<label for="exampleInputEmail1" class="labelpformodule">Model:</label>
									<input type="text" name="txtflia" onblur="habilitarfin('auto')" id="txtflia" class="labelpformodule form-control" placeholder="Model" required oninvalid="setCustomValidity('Family is required.')" 
                   oninput="setCustomValidity('')">
								   </div> 								
								   <div class="form-group col-md-6">
									<label for="exampleInputEmail1" class="labelpformodule">Made in:</label>
									<input type="text" name="txtmadein" onblur="habilitarfin('auto')" id="txtmadein" class="labelpformodule form-control" placeholder="Made In" required oninvalid="setCustomValidity('Made In USA is required.')" 
                   oninput="setCustomValidity('')">
								   </div>
								   <div class="form-group col-md-6">
									<label for="exampleInputEmail1" class="labelpformodule">ROHS IMG:</label>
									 <select class="form-control labelpformodule" onblur="habilitarfin('auto')" name="txtrohsimg" id="txtrohsimg" required oninvalid="setCustomValidity('rohsimg is required.')" oninput="setCustomValidity('')">
										   <option value="FALSE"> - Select - </option>
										  <option value="TRUE">Yes</option>
										  <option value="FALSE">No</option>
									</select>										
								   </div>
								  <div class="form-group col-md-6">
									<label for="exampleInputEmail1" class="labelpformodule">Made In IMG:</label>
									 <select class="form-control labelpformodule" onblur="habilitarfin('auto')" name="txtmadeinimg" id="txtmadeinimg" required oninvalid="setCustomValidity('madeusa is required.')" oninput="setCustomValidity('')">
										   <option value="FALSE"> - Select - </option>
										  <option value="TRUE">Yes</option>
										  <option value="FALSE">No</option>
									</select>										
								   </div>	
						

						
					   
								 	<div class="form-group col-md-6 ">
									<label for="exampleInputEmail1" class="labelforunit">UL Power Rating:</label>
									<input type="text" name="txtupwr" onblur="habilitarfin('auto')" id="txtupwr" class="form-control labelforunit" placeholder="Enter UL Power Rating" required oninvalid="setCustomValidity('UL Power Rating is required.')" 
                   oninput="setCustomValidity('')">
									</div>
								
								      <div class="form-group col-md-6">
									<label for="exampleInputEmail1" class="labelforunit">FCC:</label>
									<input type="text" name="txtfcc" onblur="habilitarfin('auto')" id="txtfcc" class="form-control labelforunit" placeholder="FCC" required oninvalid="setCustomValidity('FCC is required.')" 
                   oninput="setCustomValidity('')">
								   </div>
								     <div class="form-group col-md-6">
									<label for="exampleInputEmail1" class="labelforunit">IC:</label>
									<input type="text" name="txtic" onblur="habilitarfin('auto')" id="txtic" class="form-control labelforunit" placeholder="IC" required oninvalid="setCustomValidity('IC is required.')" 
                   oninput="setCustomValidity('')">
								   </div>
								
								     <div class="form-group col-md-6">
									<label for="exampleInputEmail1" class="labelforunit">ETSI:</label>
									 <select class="form-control labelforunit" onblur="habilitarfin('auto')" name="txtetsi" id="txtetsi" required oninvalid="setCustomValidity('ETSI is required.')" oninput="setCustomValidity('')">
										 <option value="FALSE"> - Select - </option>
										 <option value="TRUE">Yes</option>
										  <option value="FALSE">No</option>
									</select>
										
								   </div>	
								<div class="form-group col-md-6">
									<label for="exampleInputEmail1" class="labelforunit">FCC IMG:</label>
									 <select class="form-control labelforunit" onblur="habilitarfin('auto')" name="txtfccimg" id="txtfccimg" required oninvalid="setCustomValidity('fccimg is required.')" oninput="setCustomValidity('')">
										   <option value="FALSE"> - Select - </option>
										  <option value="TRUE">Yes</option>
										  <option value="FALSE">No</option>
									</select>
										
								   </div>
								<div class="form-group col-md-6">
									<label for="exampleInputEmail1" class="labelforunit">UL IMG:</label>
									 <select class="form-control labelforunit" onblur="habilitarfin('auto')" name="txulimg" id="txtulimg" required oninvalid="setCustomValidity('ulimg is required.')" oninput="setCustomValidity('')">
										   <option value="FALSE"> - Select - </option>
										  <option value="TRUE">Yes</option>
										  <option value="FALSE">No</option>
									</select>
										
								   </div>	
														   
								
								<div class="form-group col-md-6">
									<label for="exampleInputEmail1" class="labelforunit">Intertek IMG:</label>
									 <select class="form-control labelforunit" onblur="habilitarfin('auto')" name="txtintertek" id="txtintertek" required oninvalid="setCustomValidity('Intertek is required.')" oninput="setCustomValidity('')">
										   <option value="FALSE"> - Select - </option>
										  <option value="TRUE">Yes</option>
										  <option value="FALSE">No</option>
									</select>										
								  								   
								</div>
									<div class="form-group col-md-6">
									<label for="exampleInputEmail1" class="labelforunit">Etl Number:</label>
									 		<input type="text" name="txtetlnumber" onblur="habilitarfin('auto')" id="txtetlnumber" class="form-control labelforunit" placeholder="Etl" required oninvalid="setCustomValidity('ETL Number is required.')" 
                   oninput="setCustomValidity('')">								
								   </div>	
							<!-- fin label  -->
						</div>			
						
							
						
					</div>
				
					
				  	<div class="row">
						<div class="col-sm-12">
							<div class="card-footer text-right">
							
								  <button type="button" onclick="save_new_registro()" name="btnfin" id="btnfin" class="btn btn-primary btn-block right-align">Create New</button>
								  
								  
								</div>
						</div>
					</div>
														
							</div>
						
						
					 </div>	
			</div>
			
		
	
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

	var tabla_gain_rf= []; 
			
   
   
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

		$('#1_7_6_Coupler').addClass('d-none');
		$('#1_7_7_Duplexer').addClass('d-none');
		$('#1_7_8_Preselector').addClass('d-none');
		$('#1_7_10_Splitter').addClass('d-none');
		
		$('#divfasobjband').addClass('d-none');
		$('#divfasfw').addClass('d-none');
		$('#divfasfinalchkref').addClass('d-none');
		$('#divfasinstrumetsparameters').addClass('d-none');
		
		


	


		  $('#btnfin').prop('disabled', true);
		
 
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
		
	 }	 
	 
	 function buscadatos(eldatopasado,typodemodu)
	 {
		 alert('Test- Show Data:' + typodemodu+' --' + eldatopasado);
		 
		 if (typodemodu =='Migration')
		 {
			$('#divtipomod').removeClass('d-none'); 
		 }
		 
		 ///// BUSCAR DATOS DEL Module
		  return new Promise(function(resolve, reject) {
					var formData = new FormData();
					var req = new XMLHttpRequest();
			
					//consulta si devolvio el Scan Device
					
				formData.append("typodemodu", typodemodu);
				formData.append("idprod", eldatopasado);
			
				req.open("POST", "abmmodulesinfo.php");
				req.send(formData);
			
				req.onload = function() {
				  if (req.status == 200) {
							resolve(JSON.parse(req.response));
							
							console.log(JSON.parse(req.response));
							console.log('INFORMACION RECIBIDA  ');
							var objrespuesta = JSON.parse(req.response);
							console.log (objrespuesta.dreturn_coupler);
							
							
							console.log (objrespuesta.dreturn_coupler[0]['coupfstart']);
							console.log (objrespuesta.dreturn_product[0]['modelciu']);
							
							//objrespuesta.dreturn_product[0]['modelciu']
							//objrespuesta.dreturn_product[0]['description']
							//objrespuesta.dreturn_product[0]['idbusiness']
							//Blanqueamos datos	//Blanquear datos.
						$("#txtbusiness").val(objrespuesta.dreturn_product[0]['idbusiness']);
						$("#txtmadein").val('');
						$("#txtflia").val('');
						$("#txtrohsimg").val('');
						$("#txtmadeinimg").val('');
						
						$("#txtnewprod").val(objrespuesta.dreturn_product[0]['modelciu']);
						$("#txtnewproddescr").val(	objrespuesta.dreturn_product[0]['description']);
						$("#txtcoupling").val(objrespuesta.dreturn_coupler[0]['coupling']);
						$("#txtcouplinginserloss").val(objrespuesta.dreturn_coupler[0]['couplinginsertloss']);
						
						$("#txtcouplingisolat").val(objrespuesta.dreturn_coupler[0]['couplingisolation']); 
						$("#txtcouplingfreqstart").val(objrespuesta.dreturn_coupler[0]['coupfstart']);
						$("#txtcouplingfreqstop").val('');
						
						$("#duplextxrx").val('');
						$("#duplextxrxinserlosstx").val('');
						$("#duplextxrxinserlossrx").val('');
						$("#duplexnoiserx").val('');
						$("#duplexisolarxtx").val('');
						$("#duplexfreqstop").val('');
						
						$("#duplexfreqstart").val('');
						
						$("#txtbandwidth").val('');
						$("#txtbandwidthinserloss").val('');
						$("#txtbandwidthfreqstart").val('');
						$("#txtbandwidthfreqstop").val('');
						$("#txtsplitloss").val('');
						$("#txtsplitinserloss").val('');
						$("#txtsplitnroway").val('');
						$("#txtsplitfreqstart").val('');
						$("#txtsplitfreqstop").val('');
						
						
						/*	$("#txtbusiness").val('');
						$("#txtmadein").val('');
						$("#txtflia").val('');
						$("#txtrohsimg").val('');
						$("#txtmadeinimg").val('');
						
						$("#txtnewprod").val('');
						$("#txtnewproddescr").val('');
						$("#txtcoupling").val('');
						$("#txtcouplinginserloss").val('');
						
						$("#txtcouplingisolat").val('');
						$("#txtcouplingfreqstart").val(objrespuesta.dreturn_coupler.coupfstart);
						$("#txtcouplingfreqstop").val('');
						
						$("#duplextxrx").val('');
						$("#duplextxrxinserlosstx").val('');
						$("#duplextxrxinserlossrx").val('');
						$("#duplexnoiserx").val('');
						$("#duplexisolarxtx").val('');
						$("#duplexfreqstop").val('');
						
						$("#duplexfreqstart").val('');
						
						$("#txtbandwidth").val('');
						$("#txtbandwidthinserloss").val('');
						$("#txtbandwidthfreqstart").val('');
						$("#txtbandwidthfreqstop").val('');
						$("#txtsplitloss").val('');
						$("#txtsplitinserloss").val('');
						$("#txtsplitnroway").val('');
						$("#txtsplitfreqstart").val('');
						$("#txtsplitfreqstop").val('');
						*/
						
						//fin llenado de datos
					
				  }
				  else {
					reject();
				  }
				};

			
			})
		 ///// FIN BUSCAR DATOS DEL MODULE
		 	
	 }
		
	function habilitarfin(qtipodemodulocargaron)	
	{
		if (qtipodemodulocargaron=='auto')
		{
			if ($("#radbuttypeprod").val()=='0_5_2_700/800 DualBand')
			{
				qtipodemodulocargaron='BDA';
			}
			if ($("#radbuttypeprod").val()=='0_5_3_High Capacity')
			{
				qtipodemodulocargaron='BDA';
			}
			if ($("#radbuttypeprod").val()=='1_7_6_Coupler')
			{
				qtipodemodulocargaron='coupler';
			}
			if ($("#radbuttypeprod").val()=='1_7_7_Duplexer')
			{
				qtipodemodulocargaron='duplexer';
			}
			if ($("#radbuttypeprod").val()=='1_7_8_Preselector')
			{
				qtipodemodulocargaron='preselector';
			}
			if ($("#radbuttypeprod").val()=='1_7_10_Splitter')
			{
				qtipodemodulocargaron='splitter';
			}
			//
		
			
		}
		
	
		
		contadordefaltantes = 0;
		// inicio control coupler
		if ($("#txtnewprod").val()=="") {contadordefaltantes=1;}
		
		console.log('validar2:' + contadordefaltantes);
		
	
		if(qtipodemodulocargaron =='BDA')
		{
			
			if ($("#txtgaintolerancebda").val()=="") {contadordefaltantes=1;}
			if ($("#txtgaintolerancebda").val()=="") {contadordefaltantes=1;}
			if ($("#txtmaxprwtolbda").val()=="") {contadordefaltantes=1;}
			if ($("#txtimdlibda").val()=="") {contadordefaltantes=1;}
			if ($("#txtnoisefbda").val()=="") {contadordefaltantes=1;}
			if ($("#txtspuriosbda").val()=="") {contadordefaltantes=1;}
			
			if (tabla_gain_rf.length==0) {contadordefaltantes=1;}
			
			
			if ($("#txtflia").val()=="") {contadordefaltantes=1;}
			if ($("#txtmadein").val()=="") {contadordefaltantes=1;}
			if ($("#txtrohsimg").val()=="") {contadordefaltantes=1;}
			if ($("#txtmadeinimg").val()=="") {contadordefaltantes=1;}
			if ($("#txtupwr").val()=="") {contadordefaltantes=1;}
			if ($("#txtfcc").val()=="") {contadordefaltantes=1;}
			if ($("#txtic").val()=="") {contadordefaltantes=1;}
			if ($("#txtetsi").val()=="") {contadordefaltantes=1;}
			if ($("#txtfccimg").val()=="") {contadordefaltantes=1;}
			if ($("#txulimg").val()=="") {contadordefaltantes=1;}
			if ($("#txtintertek").val()=="") {contadordefaltantes=1;}
			if ($("#txtetlnumber").val()=="") {contadordefaltantes=1;}
						


		}
		
		if(qtipodemodulocargaron =='coupler')
		{				
			if ($("#txtcoupling").val()=="") {contadordefaltantes=1;}
			if ($("#txtcouplinginserloss").val()=="") {contadordefaltantes=1;}
			if ($("#txtcouplingisolat").val()=="") {contadordefaltantes=1;}
			if ($("#txtcouplingfreqstart").val()=="") {contadordefaltantes=1;}
			if ($("#txtcouplingfreqstop").val()=="") {contadordefaltantes=1;}
			if ($("#txtflia").val()=="") {contadordefaltantes=1;}
			if ($("#txtmadein").val()=="") {contadordefaltantes=1;}
			if ($("#txtrohsimg").val()=="") {contadordefaltantes=1;}
			if ($("#txtmadeinimg").val()=="") {contadordefaltantes=1;}
		}
		// fin control coupler
		// inicio control duplexer		
		if(qtipodemodulocargaron =='duplexer')
		{				
			if ($("#duplextxrx").val()=="") {contadordefaltantes=1;}
			if ($("#duplextxrxinserlosstx").val()=="") {contadordefaltantes=1;}
			if ($("#duplextxrxinserlossrx").val()=="") {contadordefaltantes=1;}
			if ($("#duplexfreqstart").val()=="") {contadordefaltantes=1;}
			if ($("#duplexfreqstop").val()=="") {contadordefaltantes=1;}
			if ($("#duplexnoiserx").val()=="") {contadordefaltantes=1;}
			if ($("#duplexisolarxtx").val()=="") {contadordefaltantes=1;}
			if ($("#txtflia").val()=="") {contadordefaltantes=1;}
			if ($("#txtmadein").val()=="") {contadordefaltantes=1;}
			if ($("#txtrohsimg").val()=="") {contadordefaltantes=1;}
			if ($("#txtmadeinimg").val()=="") {contadordefaltantes=1;}
		}
		// fin control duplexer
		// inicio control preselector		
		if(qtipodemodulocargaron =='preselector')
		{				
			if ($("#txtbandwidth").val()=="") {contadordefaltantes=1;}
			if ($("#txtbandwidthinserloss").val()=="") {contadordefaltantes=1;}			
			if ($("#txtbandwidthfreqstart").val()=="") {contadordefaltantes=1;}
			if ($("#txtbandwidthfreqstop").val()=="") {contadordefaltantes=1;}	
			if ($("#txtflia").val()=="") {contadordefaltantes=1;}
			if ($("#txtmadein").val()=="") {contadordefaltantes=1;}
			if ($("#txtrohsimg").val()=="") {contadordefaltantes=1;}
			if ($("#txtmadeinimg").val()=="") {contadordefaltantes=1;}			
		
		}
		// fin control preselector
		// inicio control splitter		
		if(qtipodemodulocargaron =='splitter')
		{				
			if ($("#txtsplitloss").val()=="") {contadordefaltantes=1;}
			if ($("#txtsplitinserloss").val()=="") {contadordefaltantes=1;}			
			if ($("#txtsplitnroway").val()=="") {contadordefaltantes=1;}
			if ($("#txtsplitfreqstart").val()=="") {contadordefaltantes=1;}	
			if ($("#txtsplitfreqstop").val()=="") {contadordefaltantes=1;}	
			if ($("#txtflia").val()=="") {contadordefaltantes=1;}
			if ($("#txtmadein").val()=="") {contadordefaltantes=1;}
			if ($("#txtrohsimg").val()=="") {contadordefaltantes=1;}
			if ($("#txtmadeinimg").val()=="") {contadordefaltantes=1;}			
		
		}
		// fin control splitter
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
		var losdatosamotrar = vvalor.split("_");
		console.log('radio button' + vvalor);
	/*	 $("#radbuttypeprod").val(vvalor);
		$('#1_7_6_Coupler').addClass('d-none');
		$('#1_7_7_Duplexer').addClass('d-none');
		$('#1_7_8_Preselector').addClass('d-none');
		$('#1_7_10_Splitter').addClass('d-none');
		$('#divfasobjband').addClass('d-none');
		$('#divfasfw').addClass('d-none');
		$('#divfasfinalchkref').addClass('d-none');
		$('#divfasinstrumetsparameters').addClass('d-none');
		
		$('.labelpformodule').addClass('d-none');
			$('.labelforunit').addClass('d-none');
		
		var nvovalor = vvalor;
			console.log('Nvo valor button' + nvovalor);
			
		if(losdatosamotrar[0]==0)
		{
			$('#divfasobjband').removeClass('d-none');
			$('#divfasfw').removeClass('d-none');
			$('#divfasfinalchkref').removeClass('d-none');
			$('#divfasinstrumetsparameters').removeClass('d-none');
			
			$('.labelpformodule').removeClass('d-none');
			$('.labelforunit').removeClass('d-none');
			
			// Buscamos los FW del tpye de producto
			$("#txtfpga").val('');
				$("#txtuc").val('');
				$("#txtether").val('');
			
				$("#txtfpgacus").val('');
				$("#txtuccus").val('');
				$("#txtethercus").val('');
				
				if ('0_5_2_700/800 DualBand' == vvalor )
				{
					console.log('si 0_5_2_700/800 DualBand');
					$("#txtfpga").val('1.2');
					$("#txtuc").val('1.05');
					$("#txtether").val('1.0.5');
				
					$("#txtfpgacus").val('ver_1_02_01.mcs');
					$("#txtuccus").val('fip446_bda_pic32_v1.05.hex');
					$("#txtethercus").val('fip446_bda_rabbit_v1.0.5.bin');
				}
			
			// fin Buscamos los FW del tpye de producto

		}
		else
		{
			$('.labelpformodule').removeClass('d-none');
			$('#'+nvovalor).removeClass('d-none');
		}
		
		$("#lbltitulo").html("<b>CIU Specs :: "+losdatosamotrar[3]+"</b>");
		
		if ( $("#txtnewprod").val() !='')
		{
				
		}*/
	}	
	
	
	
	
	function habilitarfirmware(nvovalorfw)
	{
		if (nvovalorfw == 'firmwarestand')
		{
			/*
			txtfpga
txtuc
txtether
*/
		

			$("#txtfpga").prop( "disabled", true );
			$("#txtuc").prop( "disabled", true );
			$("#txtether").prop( "disabled", true );
			
			$("#txtfpgacus").prop( "disabled", true );
			$("#txtuccus").prop( "disabled", true );
			$("#txtethercus").prop( "disabled", true );
				if ($("#radbuttypeprod").val()=='0_5_2_700/800 DualBand')
			{
					$("#txtfpga").val('1.2');
				$("#txtuc").val('1.05');
				$("#txtether").val('1.0.5');
			
				$("#txtfpgacus").val('ver_1_02_01.mcs');
				$("#txtuccus").val('fip446_bda_pic32_v1.05.hex');
				$("#txtethercus").val('fip446_bda_rabbit_v1.0.5.bin');
			}
			
		}
		else
		{
			$("#txtfpga").prop( "disabled", false );
			$("#txtuc").prop( "disabled", false );
			$("#txtether").prop( "disabled", false );
			
			$("#txtfpgacus").prop( "disabled", false );
			$("#txtuccus").prop( "disabled", false );
			$("#txtethercus").prop( "disabled", false );
			
			$("#txtfpga").val('');
				$("#txtuc").val('');
				$("#txtether").val('');
			
				$("#txtfpgacus").val('');
				$("#txtuccus").val('');
				$("#txtethercus").val('');

		}
	}
	
	function save_new_registro()
	{
		
		
		//Enviamos los datos a procesar
			 return new Promise(function(resolve, reject) {
					var formData = new FormData();
			var req = new XMLHttpRequest();
			//consulta si devolvio el Scan Device
			formData.append("idmoduleprodflia",  $("#radbuttypeprod").val());
			formData.append("txtbusiness",  $("#txtbusiness").val());
			
			formData.append("txtmadein",  $("#txtmadein").val());
			formData.append("txtflia",  $("#txtflia").val());
			formData.append("txtrohsimg",  $("#txtrohsimg").val());
			formData.append("txtmadeinimg",  $("#txtmadeinimg").val());
			
			//agregamos datos para Label
			formData.append("txtupwr",  $("#txtupwr").val());
			formData.append("txtfcc",  $("#txtfcc").val());
			formData.append("txtic",  $("#txtic").val());
			formData.append("txtetsi",  $("#txtetsi").val());
			formData.append("txtfccimg",  $("#txtfccimg").val());
			formData.append("txulimg",  $("#txulimg").val());
			formData.append("txtintertek",  $("#txtintertek").val());
			formData.append("txtetlnumber",  $("#txtetlnumber").val());
			//fin agregamos datos para Label
			
			
			///// Firmware Specs:
			formData.append("txtfpga",  $("#txtfpga").val());
			formData.append("txtuc",  $("#txtuc").val());
			formData.append("txtether",  $("#txtether").val());
			formData.append("txtfpgacus",  $("#txtfpgacus").val());
			formData.append("txtuccus",  $("#txtuccus").val());
			formData.append("txtethercus",  $("#txtethercus").val());
			///// fin Firmware Specs:
			
			//Final Check Reference:
			formData.append("txtgaintolerancebda",  $("#txtgaintolerancebda").val());
			formData.append("txtmaxprwtolbda",  $("#txtmaxprwtolbda").val());
			formData.append("txtimdlibda",  $("#txtimdlibda").val());
			formData.append("txtnoisefbda",  $("#txtnoisefbda").val());
			formData.append("txtspuriosbda",  $("#txtspuriosbda").val());
			// fin Final Check Reference:
			
			
			
			/*var idmediacionaaasociar="";
			$(".custom-control-inputmm").each(function(){
				if ($(this).prop('checked')==true)
				{
					 console.log($(this).val()+'- '+ $(this).prop('checked'));
					 idmediacionaaasociar = idmediacionaaasociar + '#' + $(this).val();
				}
        	   
        	});*/
			 console.log('Mediciones:'+idmediacionaaasociar);
			 
			// inicio Band & RF Specs:
			formData.append("divlist_tabla_gain_rftexto",  $("#divlist_tabla_gain_rftexto").val());
			// fin Band & RF Specs:
			
			//inicio script specs
			var idmediacionaaasociar="";
			$(".custom-control-inputmm").each(function(){
				if ($(this).prop('checked')==true)
				{
					 console.log($(this).val()+'- '+ $(this).prop('checked'));
					 idmediacionaaasociar = idmediacionaaasociar + '#' + $(this).val();
				}
        	   
        	});
			 console.log('Mediciones:'+idmediacionaaasociar);
			formData.append("idmediacionaaasociar", idmediacionaaasociar);
			// fin script specs
			
			formData.append("v_namemod", $("#txtnewprod").val());
			formData.append("v_namemoddescrip", $("#txtnewproddescr").val());
			///module passive coupler
			formData.append("vcouple_coupling", $("#txtcoupling").val());
			formData.append("vcouple_insertloss", $("#txtcouplinginserloss").val());
			formData.append("vcouple_isolation", $("#txtcouplingisolat").val());
			formData.append("vcouple_freqstart", $("#txtcouplingfreqstart").val());
			formData.append("vcouple_freqstop", $("#txtcouplingfreqstop").val());
			
			///module passive duplexer
			formData.append("vduplexer_txrxsep", $("#duplextxrx").val());
			formData.append("vduplexer_insertlosstx", $("#duplextxrxinserlosstx").val());
			formData.append("vduplexer_insertlossrx", $("#duplextxrxinserlossrx").val());
			formData.append("vduplexer_txnoise", $("#duplexnoiserx").val());
			formData.append("vduplexer_isolationrxtx", $("#duplexisolarxtx").val());
			formData.append("vduplexer_freqstart", $("#duplexfreqstart").val());
			formData.append("vduplexer_freqstop", $("#duplexfreqstop").val());
			
			///module passive Preselector
			formData.append("vpreselector_bandwitdh", $("#txtbandwidth").val());
			formData.append("vpreselector_insertloss", $("#txtbandwidthinserloss").val());
			formData.append("vpreselector_freqstart", $("#txtbandwidthfreqstart").val());
			formData.append("vpreselector_freqstop", $("#txtbandwidthfreqstop").val());
			
			///module passive splitter
			formData.append("vsplitter_splitloss", $("#txtsplitloss").val());
			formData.append("vsplitter_insertloss", $("#txtsplitinserloss").val());
			formData.append("vsplitter_nroways", $("#txtsplitnroway").val());
			formData.append("vsplitter_freqstart", $("#txtsplitfreqstart").val());
			formData.append("vsplitter_freqstop", $("#txtsplitfreqstop").val());
						
			//0_5_2 es BDA FLEX
			f ($("#radbuttypeprod").val().substr(0,5) =='0_5_3')
			{
				req.open("POST", "ajax_insert_modules_bda.php");
			}
			//0_5_3_High Capacity
			if ($("#radbuttypeprod").val().substr(0,5) =='0_5_3')
			{
				req.open("POST", "ajax_insert_modules_bda.php");
			}
			// 1_7 Module -Passive
			if ($("#radbuttypeprod").val().substr(0,3) =='1_7')
			{
				req.open("POST", "ajax_insert_modules_passives.php");
			}
			req.open("POST", "ajax_insert_modules_passives.php");
			req.send(formData);
			req.onload = function() {
				  if (req.status == 200) {
					
					//alert(req.response);
					var losresultado = req.response.split("#");
					resolve(JSON.parse(req.response));
						toastr["success"]("Save OK!", "");	
						location.reload();
					
					
					//Blanquear datos.
						$("#txtbusiness").val('');
						$("#txtmadein").val('');
						$("#txtflia").val('');
						$("#txtrohsimg").val('');
						$("#txtmadeinimg").val('');
						
						$("#txtnewprod").val('');
						$("#txtnewproddescr").val('');
						$("#txtcoupling").val('');
						$("#txtcouplinginserloss").val('');
						
						$("#txtcouplingisolat").val('');
						$("#txtcouplingfreqstart").val('');
						$("#txtcouplingfreqstop").val('');
						
						$("#duplextxrx").val('');
						$("#duplextxrxinserlosstx").val('');
						$("#duplextxrxinserlossrx").val('');
						$("#duplexnoiserx").val('');
						$("#duplexisolarxtx").val('');
						$("#duplexfreqstop").val('');
						
						$("#duplexfreqstart").val('');
						
						$("#txtbandwidth").val('');
						$("#txtbandwidthinserloss").val('');
						$("#txtbandwidthfreqstart").val('');
						$("#txtbandwidthfreqstop").val('');
						$("#txtsplitloss").val('');
						$("#txtsplitinserloss").val('');
						$("#txtsplitnroway").val('');
						$("#txtsplitfreqstart").val('');
						$("#txtsplitfreqstop").val('');
												
									
				  }
				  else {
					reject();
					toastr["error"]("Error when storing data...", "");	
				  }
				};

			
			})
		//fin enviar datos a procesar
		
		
	}
   
 function add_list_bandrf()
 {
	 
	/* txtbandrf
txttypeclass
cmbportinul
cmbportindl
cmbportoutdl
txtulgainband
txtdlgainband
txtulmaxpwrband */ 

var idbandrf = $('#txtbandrf').val();
var vtxtbandrf  = $.trim($('#txtbandrf option:selected').text());
var vtxttypeclass = $('#txttypeclass').val();
var vcmbportinul = parseFloat($('#cmbportinul').val());
var vcmbportindl = parseFloat($('#cmbportindl').val());
var vcmbportoutdl = parseFloat($('#cmbportoutdl').val());
var vcmbportoutul = parseFloat($('#cmbportoutul').val());


var vcmbportinulnom = $.trim($('#cmbportinul option:selected').text());
var vcmbportindlnom = $.trim($('#cmbportindl option:selected').text());
var vcmbportoutdlnom = $.trim($('#cmbportoutdl option:selected').text());
var vcmbportoutulnom = $.trim($('#cmbportoutul option:selected').text());

var vtxtulgainband = parseFloat($('#txtulgainband').val());
var vtxtdlgainband = parseFloat($('#txtdlgainband').val());

var vtxtulmaxpwrband = parseFloat($('#txtulmaxpwrband').val());

var vtxtdlmaxpwrband = parseFloat($('#txtdlmaxpwrband').val());

	
		 if (vtxtbandrf=="" || vtxttypeclass=="" || vcmbportinul=="" || vcmbportindl=="" || vcmbportoutdl=="" || vtxtulgainband=="" || vtxtdlgainband=="" || vtxtulmaxpwrband=="" || vcmbportoutul==""  )
		 //||  isNaN(vtxtbandrf)==true  || isNaN(vtxttypeclass)==true  || isNaN(vcmbportinul)==true  || isNaN(vcmbportindl)==true || isNaN(vcmbportoutdl)==true || isNaN(vtxtulgainband)==true || isNaN(vtxtdlgainband)==true || isNaN(vtxtulmaxpwrband)==true  || isNaN(vcmbportoutul)==true    )
		  {
				alert('missing complete data');
		  }
		  else
		  {
			 
					tabla_gain_rf.push({						
									txtbandrf: vtxtbandrf,									
									txttypeclass: vtxttypeclass,								
									cmbportinulnom: (vcmbportinulnom),
									cmbportoutulnom: (vcmbportoutulnom),
									txtulgainband: parseFloat(vtxtulgainband),
									txtulmaxpwrband: parseFloat(vtxtulmaxpwrband),
									cmbportindlnom: (vcmbportindlnom),									
									cmbportoutdlnom: (vcmbportoutulnom),								
									txtdlgainband: parseFloat(vtxtdlgainband),									
									txtdlmaxpwrband: parseFloat(vtxtdlmaxpwrband),
									idbandrf: idbandrf,									
									cmbportinul: parseFloat(vcmbportinul),
									cmbportoutul: parseFloat(vcmbportoutul),								
									cmbportindl: parseFloat(vcmbportindl),									
									cmbportoutdl: parseFloat(vcmbportoutdl)	
									
									
						   });
						
							list_tabla_gain_rf();
						   
						   /// Limpia variables
						   
							$('#txtbandrf').val('');
							$('#txttypeclass').val('');
							$('#cmbportinul').val('');
							$('#cmbportindl').val('');
							
							$('#cmbportoutdl').val('');
							$('#cmbportoutul').val('');
							
								
							$('#txtulgainband').val('');
							$('#txtdlgainband').val('');
							
							$('#txtulmaxpwrband').val('');
							$('#txtdlmaxpwrband').val('');
							
		  }
 }
 
 function list_tabla_gain_rf()
 {
	
		var jname ="";
		var v_templistchannel="";
			//var html = '<table class="table  table-striped table-sm ">';
			
			
			var html = '<table class="table table-bordered  table-striped table-sm text-center "><tbody>';
												
				 html += '<tr>';
				 var cantcabez = tabla_gain_rf[0];
				 
				 for( var j in  cantcabez) {
					 
					 jname= j
					 if (j=='txtbandrf')
					 {
						 jname='Band';
					 }
					 if (j=='txttypeclass')
					 {
						 jname='Class';
					 }
					 if (j=='cmbportinulnom')
					 {
						 jname='Port IN UL';
					 }
					  if (j=='cmbportoutulnom')
					 {
						 jname='Port Out UL';
					 }
					 if (j=='txtulgainband')
					 {
						 jname='UL Gain';
					 }
					  if (j=='txtulmaxpwrband')
					 {
						 jname='UL Max Pwr';
					 }
					 
					 
					  if (j=='cmbportindlnom')
					 {
						 jname='Port In DL';
					 }
					  if (j=='cmbportoutdlnom')
					 {
						 jname='Port Out DL';
					 }
					 if (j=='txtdlgainband')
					 {
						 jname='DL Gain';
					 }
					  if (j=='txtdlmaxpwrband')
					 {
						 jname='DL Max Pwr';
					 }
					
					 if (j == "idbandrf" || j == "cmbportinul"   || j == "cmbportoutul" || j == "cmbportindl" || j == "cmbportoutdl")
					 {
						 // html += '<th>' + jname + '</th>';
					 }
					 else
					 {
						   html += '<th>' + jname + '</th>';
					 }	 
								
					 
				
				
				 }
				  html += '<th>Action</th>';
				 html += '</tr>';
				 for( var i = 0; i < tabla_gain_rf.length; i++) {
				  html += '<tr>';
				  
				  if (v_templistchannel != '')
				  {
					v_templistchannel = v_templistchannel + "#";  
				  }
				  console.log(tabla_gain_rf[i]);
				  for( var j in tabla_gain_rf[i] ) {
					 
					
						 if (j == "idbandrf" || j == "cmbportinul"   || j == "cmbportoutul" || j == "cmbportindl" || j == "cmbportoutdl")
						 {
							 
						 }
						 else
						 {
							   	html += '<td>' + tabla_gain_rf[i][j]  +' </td>';	  
								v_templistchannel = v_templistchannel  + tabla_gain_rf[i][j] + "|";
						 }	 
								
					
					
					
				  }
				  html += '<td>  <a href="#" onclick="borrar_array_bandrf('+i+')"> <i class="fas fa-trash-alt"></i> Del</a> </td>';	  
				  html += '</tr>';
				 }
				 html += '</table>';
				 v_templistchannel = v_templistchannel + "#";  
				 console.log(v_templistchannel);
				 	$('#divlist_tabla_gain_rf').html(html);
					$('#divlist_tabla_gain_rftexto').val(v_templistchannel);
				
		
	
 }
 
 	 function borrar_array_bandrf	 (idborrarch)
	 {
		    tabla_gain_rf.splice(idborrarch, 1); 
			
			$('body,html').stop(true,true).animate({				
				scrollTop: $("#divlist_tabla_gain_rf").offset().top
			},1);
			
			list_tabla_gain_rf();
			$('body,html').stop(true,true).animate({				
				scrollTop: $("#divlist_tabla_gain_rf").offset().top
			},1);
	 }
	 


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
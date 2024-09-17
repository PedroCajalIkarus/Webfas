<!DOCTYPE html>
<?php 

// Desactivar toda notificación de error
error_reporting(0);
// Notificar todos los errores de PHP (ver el registro de cambios)
//error_reporting(E_ALL);
 include("db_conect.php"); 
 
 
 	session_start();
	

//	echo "<br>".isset($_SESSION["timeout"]);
//	exit();
	
// echo "***********hola".time() - $_SESSION["timeout"];
  if(isset($_SESSION["timeout"])){
        // Calcular el tiempo de vida de la sesión (TTL = Time To Live)
		//echo "***********hola".time() - $_SESSION["timeout"];
        $sessionTTL = time() - $_SESSION["timeout"];
	//	echo $sessionTTL."-".$inactividad; 
        if($sessionTTL > $inactividad){
			session_unset();
            session_destroy();
            header("Location: http://".$ipservidorapache."/index.php?t=timeoutinactivityhome");
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
	
	//	echo "Hola:".$_SESSION["timeout"];
			
	
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
 
  
    <link rel="stylesheet" href="cssfiplex.css">
	
		<style>
	
body
{
	  font-family: Arial, Helvetica, sans-serif;
	      background:#eee;		  
  font-size:12px;
  font-size:12px;
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
<form name="frma" id="frma">
<input type="hidden" name="uso" id="uso" value="0">
<body class="hold-transition sidebar-mini sidebar-collapse">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->

  <!-- /.navbar -->
<?php 	  

  
   
 include("menutopnotification.php"); 

 include("menu.php"); 
 ///    echo "bbbbsssssssssssssssssssssssssssssssssbbbbaaaaaaaaaaaaa";
 include("funcionesstores.php"); 
// include ('licencefiplex_mm.php');
 
   ////   $Encryption = new Encryption();
   
?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>DashBoard</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active"> <?php echo $_SESSION["h"]; ?></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

<?php

  $meses =['','January', 'February', 'March','April', 'May',    'June',    'July ',    'August',    'September',    'October',    'November', 'December'];
  
		
		
			$eluserlogin = $_SESSION["a"];
			 $query_lista="select distinct menu.* from menu inner join business_user_menu on business_user_menu.idmenu = menu.idmenu  where menu.active = 'Y' and sector = 'homeheader' and iduserfas=$eluserlogin  and namegroup = 'head' order by ordershow ,  namemenu  ";
			
			$resultado = $connect->query($query_lista);	
			$cantregistros = $resultado->rowCount();
			if ($cantregistros >=1)
			{
				$fiplex_last_week1="";
				$fiplex_this_week1="";
				
				$westell_last_week2="";
				$westell_this_week2="";
				
				$spinnaker_last_week3="";
				$spinnaker_this_week3="";
				
					$query_lista_repor =" select * from fnt_select_runinfo_by_business_count_bydaywithparambyyear(0,".date("m").",".date("Y")."); ";
				//	echo $query_lista_repor;
				//		$query_lista_repor =" select * from runinfodb limit 1; ";
					$resultadorepor = $connect->query($query_lista_repor);	
					$cantregistros = $resultadorepor->rowCount();
					/*foreach ($resultadorepor as $rowa) {
						echo var_dump($rowa);
					}*/

					foreach ($resultadorepor as $rowreport) 
					{
					//	echo "<br>b:".$rowreport[0];
					 
						$arraydatos  = json_decode($rowreport[0], true);			

					//	echo "<br>ididbusiness?".$arraydatos['idbusiness']; 
						$temparray =  $arraydatos['sss'];
					//	echo "<br>vardump".$arraydatos['nroweek'];
					//		echo "<br>ccc".implode(",",$arraydatos['ccc']);
					//cho "<br>idccc?".implode("*", $temparray[0]); 
								
						
						  $nombredelmes =  $meses[$arraydatos['monthdd']]; 
						
							if( $arraydatos['idbusiness']=="1" )
								{
										$fiplex_this_label = implode(",",$arraydatos['dayofweekagg']);
										$fiplex_this_week1 = implode(",",$arraydatos['ccc']);
									
								}
								if( $arraydatos['idbusiness']=="2" )
								{
									
										$westell_this_week2 = implode(",",$arraydatos['ccc']);
								}
								if( $arraydatos['idbusiness']=="3" )
								{
									
										$spinnaker_this_week3 = implode(",",$arraydatos['ccc']);
									
								}
						///////////////////////////////////////
				 
					
					}
					
				//	echo "-----------abc1:".$fiplex_this_label."----------------".$fiplex_this_week1;
				//	echo "<br>---abc1:".$westell_last_week2."----".$westell_this_week2;
				//	echo "<br>---abc1:".$spinnaker_last_week3."----".$spinnaker_this_week3;
				
?>

	<section class="content">
	<input type="hidden" value="" name="idpetitionrun" id="idpetitionrun">
	<?php 	 if 	($_SESSION["g"] == "develop" ) 
	{
		?>
		<!-- inicio grafico de reportes -->
	<div class="row">						
						     <div class="col-md-6">
							
								 <!-- inicio grafico 1 -->
										<div class="card card-primary">
													<div class="card-header">
													<h3 class="card-title colorazulfiplex ">FAS execution </h3>
														 <input type="hidden" id="graf2anio1" name="graf2anio1" value="">
															<div class="card-tools">
															<span class='float-right'>
																 &nbsp;YEAR: <span id="nombmes" name="nombmes" class='colorazulfiplex'><b> <?php echo  date("Y") ; ?></b></span>
																 </span>
																	
																</div>
													</div>
													<div class="card-body">
													<div class="chart">
																	<div class="position-relative mb-4">
																	  <canvas id="visitors-chart2" height="200"></canvas>
																	</div>
																	<div class="d-flex flex-row justify-content-end">
																	  <span class="mr-2">
																		<i class="fas fa-square text-primary"></i> [FIPLEX]
																	  </span>

																	   <span class="mr-2" style="color:#00994C">
																		<i class="fas fa-square"></i> [SPINNAKER] 
																	  </span>

																	 
																	  
																	  <span class="mr-2" style="color:#CC0000">
																		<i class="fas fa-square"></i> [WESTELL] 
																	  </span>

																	</div>
													</div>
													</div>
								<!-- /.card-body -->
								</div>
										 <!-- fin grafico 1 -->		
								
								</div>
								  <div class="col-md-6">
											 <!-- inicio grafico 2 -->
							  <div class="card card-primary">
											<div class="card-header">
											<h3 class="card-title colorazulfiplex ">FAS execution script</h3>

													<div class="card-tools">
														<span class='float-right'>
														 &nbsp;YEAR: <span id="nombmesgrafico2" name="nombmesgrafico2" class='colorazulfiplex'><b> <?php echo  date("Y") ; ?></b></span>
														 </span>
														 <input type="hidden" id="graf2anio" name="graf2anio" value="">
														 <input type="hidden" id="graf2anioidbusiness" name="graf2anioidbusiness" value="0">
													
														<ul class="pagination pagination-sm">
														 <li class="page-item"><a href="#" id="btntodass" name="btntodass" class="page-link" onclick="setbusiness(0,'btntodass');"> ALL <i class='far fa-check-circle'></i> </a></li>
														 <li class="page-item"><a href="#" id="btntodassf" name="btntodassf" class="page-link" onclick="setbusiness(1,'btntodassf');"> FIPLEX </a></li>
														 <li class="page-item"><a href="#" id="btntodasss" name="btntodasss"class="page-link" onclick="setbusiness(3,'btntodasss');"> SPINNAKER </a></li>
														 <li class="page-item"><a href="#" id="btntodassw" name="btntodassw"  class="page-link" onclick="setbusiness(2,'btntodassw');"> WESTELL </a></li>
														 <li class="page-item">&nbsp;</li>
														
														  </ul>	
													</div>
											</div>
											<div class="card-body">
												<div class="chart">
																<div class="position-relative mb-4">
																  <canvas id="visitors-chart" height="200"></canvas>
																</div>
																<div class="d-flex flex-row justify-content-end" id="lblgrafico" name="lblgrafico">
																 
																</div>
												</div>
											</div>
										<!-- fin grafico 2 -->
														   
										</div>
								</div>		
						
			</div>			
	<!-- fin grafico de reportes -->
	<?php } 
	?>		
      <div class="row">
	  <!-- /.inicio row botones menu rapido content -->	
	
	
		
			<?php
			
			
			///Borramos lso accesos directos a pedido de agus.
			///acamarco
				foreach ($resultado22 as $row) {
					$stylecolor = $row['menustyle'];
					$iconomenu = $row['iconmenu'];
					
					$namemenu = $row['namemenu'];
					$linkmenu = $row['linkaccess'];
					
					?>
					<!-- autogenerado:0 BOTON MENU-->		
						<div class="col-12 col-sm-6 col-md-3">
						  <div class="info-box">
							<span class="info-box-icon <?php echo $stylecolor;?> elevation-1"><i class="<?php echo $iconomenu;?>"></i></span>
								<div class="info-box-content"><a href="<?php echo $linkmenu;?>"><span class="info-box-number"><?php echo $namemenu;?></span></a></div>
						  </div>
					   
						 </div>
					<!-- autogenerado:0 BOTON MENU-->
					<?php
				}
			?>
			
		<!-- 11 BOTON MENU-->		
			
			 <!-- 11 BOTON MENU-->						 
		   
		
		<!-- /. fin row botones menu rapido  content -->		 
       
	   
	   <!----- CUI BOX  -->
	 <?php
		
			
			 $query_lista="select distinct menu.* from menu inner join business_user_menu on business_user_menu.idmenu = menu.idmenu  where menu.active = 'Y' and sector = 'homecenter' and iduserfas=$eluserlogin  order by ordershow , sector,  namemenu  ";
			
		//	echo 	$query_lista;
				$resultado = $connect->query($query_lista)->fetchAll();	
				
				$temp_namegroup = "";
			
				foreach ($resultado as $row) {
					$stylecolor = $row['menustyle'];
					$iconomenu = $row['iconmenu'];
					$iconmenuhead = $row['iconmenuhead'];
					$headnamemenu = $row['namegroup'];
					$namemenu = $row['namemenu'];
					$linkmenu = $row['linkaccess'];
					
					if ($headnamemenu != $temp_namegroup)
					{
						if ($temp_namegroup != "")
						{
							?>
									  </div>        
									</div>		
								</div>
							<?php
						}
							$temp_namegroup = $headnamemenu;
						?>
						<div class="col-12 col-sm-6 col-md-3">
						   <div class="card card-default color-palette-box ">
							  <div class="card-header">
								<h3 class="card-title"> <i class="<?php echo $iconmenuhead; ?>"></i> <?php echo $headnamemenu; ?> </h3>
							  </div>
							  <div class="card-body">
						<?php
					}
					?>
					<!-- autogenerado:0 BOTON MENU-->		
						
								<i class='<?php echo $iconomenu; ?>' style='font-size:24px'></i>	<a href="<?php echo $linkmenu; ?>"><?php echo $namemenu; ?></a><br>
							                   
							 
					<!-- autogenerado:0 BOTON MENU-->
					<?php
				}
				if ($temp_namegroup !="")
				{
					?>
						</div>        
							</div>		
						</div>
		
					<?php
				}
			?>
							
		
					</div>
		 <?php } ?>
	   <!----- FIN CUI BOX -->
	   
	   
	   
	
  <div class="row">
    <div class="col-lg-4">
	<?php 
	
		if ($_SESSION["g"] == "develop" || $_SESSION["g"] == "director" )
		{
			
		?>
			 
		 <div class="callout callout-warning">
              <h5><i class="fas fas fa-wrench"></i></i> Backup Files:</h5><br>
			  - Format: Database-Day-Hr.7z<br>
			  <?php
			  
			//  http://webfas.honeywell.com/ajaxultibksnube.php
		

			  ?>
			                 <?php 
			//	$cc = curl_init("https://webfas.honeywell.com/ajaxultibksnube.php");  
		//	$url_content =  curl_exec($cc);  
		//	curl_close($cc); ?> </span> 
			<?php 
		//	echo "aaaaaaaaaaaaa".	$url_content ;
		$ultdiaconbks_srvusa="";
		// Arreglo con todos los nombres de los archivos
		$path  = 'D:/Bks_Psql_FULL/'; 
		//	$files = array_diff(scandir($path), array('.', '..')); 
			$bksamostrar="";
		/*	foreach($files as $file){
				echo '<br><i class="nav-icon 	far fa-file-alt"></i> '.$file;
				///" - ".filesize($file)." Bytes -- ". date('Ymd H:i:s', filemtime($file));;

			 

				}*/
				//echo  $bksamostrar;

				$myDirectory = opendir($path);
// get each entry
while($entryName = readdir($myDirectory)) {
    $dirArray[] = $entryName;
}
// close directory
closedir($myDirectory);
//  count elements in array
$indexCount = count($dirArray);
//Print ("$indexCount files<br>\n");
//echo "</span> <br>";
// sort 'em
sort($dirArray);
// print 'em
print("<TABLE class='table table-striped' cellpadding=5 cellspacing=0  >\n");
print("<TR><TH>Filename</TH><th>Filetype</th><th>Filesize</th></TR>\n");
// loop through the array of files and print them all
for($index=0; $index < $indexCount; $index++) {
        if (substr("$dirArray[$index]", 0, 1) != "."){ // don't list hidden files
			 

			$posicion_coincidencia = strpos($dirArray[$index], "7z");
		if ($posicion_coincidencia === false) {
			}
			else
			{
				print("<TR><TD>$dirArray[$index]</td>");
				print("<td>");  print(filetype($path."/".$dirArray[$index])); print("</td>");
				print("<td>");  print(filesize($path."/".$dirArray[$index])); print("</td>");
				print("</TR>\n");
			}
        
    }
}
print("</TABLE>\n");
			?>
	
         </div>
	<?php 	
		}
	?>	 
	

	  <!-- /.LIST -->

	    <!-- /.card-header -->
	
 
 	<div class="card">
          
              <!-- /.card-header -->
          
				<?php 
				
				if 	($_SESSION["g"] == "developMM"  || $_SESSION["g"] == "directorMM"  ) 
					{
				
				?>
				
				
                   
                <div id="accordion">
				<br>
				<!--iNICIO DIV FAS SERVER -->
				<div class="card collapsed-card" id="divfasserver" name="divfasserver" data-parent="divfasserver">
					  <div class="card-header border-0 ui-sortable-handle"  style="cursor: move;">
						<h3 class="card-title">
						  <i class="fas fa-th mr-1"></i>
						  FAS SERVER - LogInfo
						</h3>

							<div class="card-tools">
							  <button type="button" class="btn btn-sm" data-card-widget="collapse">
								<i class="fas fa-plus"></i>
							  </button>
						   
							</div>
					  </div>
					<div class="card-body" style="display: none;" aria-labelledby="divfasserver" data-parent="#accordion">
		
		      
				 <div class="col-12 table-responsive  align-items-center">
                  <table class="table table-striped table-sm  table-bordered">
                    <thead>
                    <tr>
                      <th>ID</th>
                      <th>Date</th>
                      <th colspan=3>Log Info Srv</th>
                      
                    </tr>
                    </thead>
                    <tbody>
					
					<?php 
					
					$sql = "  SELECT idserverinfo, cast(dateinfo as date) as eldia, loginfo,dateinfo FROM public.fas_server_log   order by  dateinfo desc limit 20";
						
					
						
							$resultsupport = $connect->query($sql)->fetchAll();				
		
							foreach ($resultsupport as $rowdatos) {
								?>
								 <tr class="texto10">
								
								 <td><?php echo str_replace("###","<BR>",$rowdatos['idserverinfo']); ?></td>
								 <td><?php echo str_replace("###","<BR>",$rowdatos['eldia']); ?></td>
								  <td><?php echo str_replace("###","<BR>",$rowdatos['loginfo']); ?></td>
								 
								</tr>
								<?php
							}

					?>
					
                   
                   
                   
                    </tbody>
                  </table>
                </div>
             
              </div>
              <!-- /.card-body -->
          
              <!-- /.card-footer -->
            </div>
			<!--FIN DIV FAS SERVER -->
			<br>
			<!--iNICIO DIV FAS SERVER -->
				<div class="card collapsed-card" id="divfasserveraudit" name="divfasserveraudit" data-parent="divfasserveraudit">
					  <div class="card-header border-0 ui-sortable-handle"  style="cursor: move;">
						<h3 class="card-title">
						  <i class="fas fa-th mr-1"></i>
						  WEBFAS - Audit
						</h3>

							<div class="card-tools">
							  <button type="button" class="btn btn-sm" data-card-widget="collapse">
								<i class="fas fa-plus"></i>
							  </button>
						   
							</div>
					  </div>
					<div class="card-body" style="display: none;" aria-labelledby="divfasserveraudit" data-parent="#accordion">
		
		      
				 <div class="col-12 table-responsive  align-items-center">
                  <table class="table table-striped table-sm  table-bordered">
                    <thead>
                    <tr>
                      <th>Date</th>
                      <th>User</th>
					  <th>WebPag</th>
                      <th >quantity</th>
                      
                    </tr>
                    </thead>
                    <tbody>
					
					<?php 
					
					$sql = " SELECT cast(dateaudit as date) as eldia,userfas,menuweb, count(dateaudit) as ccreg from auditwebfas  where menuweb NOT IN ('logdb.php','FlexDBA:index.php','ajax_listproject.php','attachfileproject.php','FlexDBA:ajax_changepassuser.php','FlexDBA:ajaxdelitembudget.php','delattachprojflexbda.php','FlexDBA:ajainactiveproject.php')  group by  cast(dateaudit as date),userfas,menuweb  order by  eldia desc, menuweb, count(dateaudit)  desc limit 60";
								
				
						
							$resultsupport = $connect->query($sql)->fetchAll();				
		
							foreach ($resultsupport as $rowdatos) {
								?>
								 <tr class="texto10">
								
								 <td><?php echo str_replace("###","<BR>",$rowdatos['eldia']); ?></td>
								 <td><?php echo str_replace("###","<BR>",$rowdatos['userfas']); ?></td>
								  <td><?php echo str_replace("###","<BR>",$rowdatos['menuweb']); ?></td>
								  <td><?php echo str_replace("###","<BR>",$rowdatos['ccreg']); ?></td>
								 
								</tr>
								<?php
							}

					?>
					
                   
                   
                   
                    </tbody>
                  </table>
                </div>
             
              </div>
              <!-- /.card-body -->
          
              <!-- /.card-footer -->
            </div>
			<!--FIN DIV FAS SERVER -->
			
			
				  </div>
				  
				  
				  
				  <?php 
				  // SELECT cast(dateinfo as date) as eldia, loginfo FROM public.fas_server_log   order by  eldia desc limit 20
				  
				  
				  } ?>
           
         
            </div>
			<!--     To Do List   -->
		
			
			
    </div>
    <div class="col">	
			<div class="card">
           


<?php 
if 	($_SESSION["g"] == "develop"    ) 
{
?>

<?php

function get_server_cpu_usage(){

    $load = sys_getloadavg();
//echo	var_dump(sys_getloadavg());
    return $load[0];

}
				  
			//	  $file = fopen("/var/log/php-fpm/www-error.log","r");
			//	  echo fgets($file);
			//  fclose($file);
			//	  echo "<hr>";
				//  $output = shell_exec('top -n 1 ');
				//	echo $output;

			//		echo 'get_server_cpu_usage'.get_server_cpu_usage() ;

				 ?>
				 <br> <div class="card-header border-0 ui-sortable-handle"  style="cursor: move;">
				 <h3 class="card-title colorazulfiplex "> <i class='fas fa-user-nurse'></i> Developers only </h3>
				 </div>
				  <hr>
				  <?php
$sql2 = " SELECT * from fas_petitions_server where instance  = '04D0E6' and exitstatus  = 'Error executing the request' and status <>2 and fas_petitions_server.date >'2022-10-24'";

$result_petiti = $connect->query($sql2)->fetchAll();				
$nropetitipend=0;
$losdatosamostrar ="";
foreach ($result_petiti as $rowdatospp) {

	$sql2 = " update fas_petitions_server set status = 0,exitstatus =''  where instance  = '04D0E6' and exitstatus  = 'Error executing the request' and status <>2 and fas_petitions_server.date >'2022-10-24'";
	$result_petiti = $connect->query($sql2)->fetchAll();	

	?>
	  <div class="card-body">
						<div class="alert alert-danger alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<h5><i class='fas fa-file-medical-alt'></i> Alert!</h5>
						Pending Alert Email Sendings<hr>
				 


						</div>
					</div>
	<?php
	break;
}

///////////////////////////////////////////////////

$path  = 'D:/Digboardlog/Source/SAPXML'; 
$files = array_diff(scandir($path), array('.', '..')); 
$qq_file_pending=0;
foreach($files as $file){
		// Divides en dos el nombre de tu archivo utilizando el . 
		$qq_file_pending=$qq_file_pending+1;		 
	}

if ($qq_file_pending>3)
{
	?>
	  <div class="card-body">
						<div class="alert alert-danger alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<h5><i class='fas fa-file-medical-alt'></i> Alert!</h5>
						Pending XML File <?php echo $qq_file_pending - 3; ?><hr>
				 


						</div>
					</div>
	<?php
}	

////////////////////////////////////////////////////

$sql2 = " SELECT * from fas_petitions_server where  iduserto = 22 and status =0";
								
				
						
$result_petiti = $connect->query($sql2)->fetchAll();				
$nropetitipend=0;
$losdatosamostrar ="";
foreach ($result_petiti as $rowdatospp) {
	$nropetitipend=$nropetitipend+1;
	$losdatosamostrar = $losdatosamostrar."*&nbsp;".$rowdatospp['parameters1']."<br>";
	
}


				  
				 if ($nropetitipend >0)
				 {

				 
				 ?>
				  <div class="card-body">
						<div class="alert alert-danger alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<h5><i class='fas fa-file-medical-alt'></i> Alert!</h5>
						Requests pending processing on the server for the user: <b>fasserver</b><hr>
						<?php echo $losdatosamostrar; ?>


						</div>
					</div>
					<?php
					}
					?>
				  <hr>
				  <div class="col-3" id="fasclientrespond" name="fasclientrespond">				 
				 </div>
				 <div class="col-5" id="fasusuconect" name="fasusuconect">				 
				 <div class="card-body">
				 <?php 
				 	$sqlcantusus = "select count(*) as ccu from pg_stat_activity where  usename <> ''";

					 $datausuconect = $connect->query($sqlcantusus)->fetchAll();
					 
					  foreach ($datausuconect as $rowusu) 
						   {
							   echo "  <i class='fas fa-user-alt' style='font-size:20px'></i> [". $rowusu['ccu']."] Users connected to the base.";
						   }
						   	echo "<hr>";

						   $sqlcontrol=" SELECT usename, application_name, count(*) as cc FROM pg_stat_activity where usename<>''
						   group by usename, application_name order by cc desc";
						    $datausuconect = $connect->query($sqlcontrol)->fetchAll();
					 
							foreach ($datausuconect as $rowusudet) 
								 {
									 echo "<br>  <i class='fas fa-user-alt' style='color:green '></i> [".$rowusudet['usename']."] ".$rowusudet['application_name']." - Number of connections: ".$rowusudet['cc']."<br>" ;
								 }
				 ?> 
				  </div> </div>
				 <hr>
				 <div class="col-3 text-center">
					

                     
		 
                   
                  </div>

				  <?php
				/*  if ($qporcentaje>59)
				  {

				
				 $sqlqpasa = "SELECT usename, client_addr, backend_start,  query, backend_start::TIMESTAMP - now()::TIMESTAMP as tiempo from pg_stat_activity where query <> '' AND usename <> ''"; 
				 
					 $datausuconect = $connect->query($sqlqpasa)->fetchAll();
					 
					  foreach ($datausuconect as $rowusu) 
						   {
							   echo "<i class='fas fa-database'></i> [".$rowusu['usename']."] {".$rowusu['client_addr']."} -Start: ".$rowusu['backend_start']." -- Duration:".$rowusu['tiempo']."<br>Query:".$rowusu['query']."<hr>";
						   }
						
						}*/
				  ?>
				

<?php
}
?>
            </div>
    </div>
  </div>
	
	
  <!-- /.content-wrapper -->
   
   </div>
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

 
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="toastr.min.js"></script>

<script src="licencefiplex_mm.js"></script>
<script src="licencefiplex1.js"></script>
<script src="js/jquery.inactivityTimeout.js"></script>
<script src="js/moment-timezone-with-data.js"></script>
 <script src="js/eModal.min.js" type="text/javascript" />
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
 
 
</body>

<script type="text/javascript">

   const monthNames = ["","January", "February", "March", "April", "May", "June",
  "July", "August", "September", "October", "November", "December"
];

   
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

			var cant_veces_controlo = 0;
	var cant_veces_controlo_limit = 15;	

		//	scan_device('17','22','13');

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


var f = new Date();
 $('#graf2anio').val(f.getFullYear() + "/" + (f.getMonth() +1) + "/" + f.getDate());
 $('#graf2anio1').val(f.getFullYear() + "/" + (f.getMonth() +1) + "/" + f.getDate());
 
 
		var elmes = (f.getMonth() +1) ;
		console.log('el mes'+ elmes+ '--' + monthNames[elmes] );
		Graficosxscritp(0, elmes,f.getFullYear());			
		Graficosxscritpjson_1ergraf(0, elmes,f.getFullYear());	

		$("#nombmes").html('<b>' + f.getFullYear()+'</b>'	);		
		$("#nombmesgrafico2").html('<b>' + f.getFullYear()+'</b>'	);	
			
	});
	




	// controlar inactividad en la web	
		$(document).inactivityTimeout({
                inactivityWait: 10000,
                dialogWait: 10,
                logoutUrl: 'logout.php'
            })
	// fin controlar inactividad en la web		
	
	 /* requesting data */
    function openpopupframe(idtksupport)
	{
		eModal.iframe('edittksuppor.php?idt='+idtksupport,'Tech Support FAS - Ticket Manager ');
	} 		
		


	 	function scan_device(vv_p_idb, vv_p_ids, vv_p_idu)
	{
		
		////Insertamos el pedido de SCAN para el user, Station
			var formData = new FormData();

			formData.append("idb", vv_p_idb);
			formData.append("ids", vv_p_ids);
			formData.append("idu", vv_p_idu);
			formData.append("idaccionweb", 0);
			/// idaccionweb 1 - Inserto SCAN Device

			var xhr = new XMLHttpRequest();
			xhr.open("POST", "fasclient_query.php");
			xhr.send(formData);
			
				xhr.onload = function() {
				  if (xhr.status == 200) {					  
						///$('#idpetitionrun').val(xhr.response.substring(4, 12).replace('"',''));
						var eldatoaver = xhr.response.split("#");
						$('#idpetitionrun').val(eldatoaver[1]);				
						console.log('devolvio el idaccionweb 1:' + xhr.response+ '----:'+ eldatoaver[0]+'---->'+eldatoaver[1]);
					
						get_result_fasclient(vv_p_idb, vv_p_ids, vv_p_idu).then(results => {
											const lossnrecibidos = results;
											console.log(lossnrecibidos);							
							})
							///	$("#fasclientrespond").html('<i class="fas fa-tachometer-alt" style="font-size:20px;color:green"></i> FASClient responds. <br>');						
							//$("#fasclientrespond").html('<i class="fas fa-tachometer-alt" style="font-size:20px;color:red"></i> FASClient is not responding. <br>');												
					}				 
					
				  };
				 
				
 

	} 
   

	function get_result_fasclient(vv_p_idb, vv_p_ids, vv_p_idu) {
		return new Promise(function(resolve, reject) {
			
			
				var formData = new FormData();
			var req = new XMLHttpRequest();
			var var_local_petition = $('#idpetitionrun').val() ;
			console.log('ver' + var_local_petition+'----'+  $('#idpetitionrun').val());
			//consulta si devolvio el Scan Device
			formData.append("idb", vv_p_idb);
			formData.append("ids", vv_p_ids);
			formData.append("idu", vv_p_idu);
			formData.append("idpp", var_local_petition);
			
			formData.append("idaccionweb", 2);
			
			
			
			///req.open('GET', 'fasclient_query.php');
			req.open("POST", "fasclient_query.php");
			req.send(formData);
			
			req.onload = function() {
			  if (req.status == 200) {
					//console.log('aaaaaaaaaaaa'+ req.response) ;
					if ( req.response != 0)
					{
							//alert('s'+ req.response );
						//	console.log('AAA devolvio el idaccionweb 2 :' + req.response);
				//	console.log('devolvio el idaccionweb 1:' + xhr.response.substring(4, 12).replace('"',''));
							     //resolve(req.response);
								 resolve(JSON.parse(req.response));
							$('#msjwaitline').hide();
							
							$('#msjwaitlineok').show();
							setTimeout(function(){ $('#msjwaitlineok').hide(); }, 10000);
							
					}
					else
					{
						
						// setTimeout(get_result_fasclient(), 3000) ;
						 //setInterval(get_result_fasclient(),3000);
							if (cant_veces_controlo <= cant_veces_controlo_limit)
							{
								
							cant_veces_controlo = cant_veces_controlo + 1 ;
							
						 	setTimeout(function(){
					 
												
													get_result_fasclient(vv_p_idb, vv_p_ids, vv_p_idu).then(results => {
														console.log('llenar combos 1');
														const lossnrecibidos2 = results;
														console.log(lossnrecibidos2.length);
													})
												
									
								
											},5000);
									
							}	
							else
							{
								$('#msjwaitline ').hide();
								// Envio para Frenar lo pendiente..
								
								var formDatacerrartodo = new FormData();

									formDatacerrartodo.append("idb", vv_p_idb);
									formDatacerrartodo.append("ids", vv_p_ids);
									formDatacerrartodo.append("idu", vv_p_idu);
									formDatacerrartodo.append("idpp", var_local_petition);
									formDatacerrartodo.append("idaccionweb", 6);
									/// idaccionweb 6
								//	console.log('cerrar todo'+ var_local_petition)
									var xhr_cerrar = new XMLHttpRequest();
									xhr_cerrar.open("POST", "fasclient_query.php");
									xhr_cerrar.send(formDatacerrartodo);
									
										xhr_cerrar.onload = function() 
										{
										  if (xhr_cerrar.status == 200) {
											  	alert('server does not respond');
											
											}
										};
								
							
							//	reject();
									
							}
		
					}
					
					
				
			  }
			  else {
				reject();
			  }
			};

		
		})
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
   
   function generarNumero(numero){
	return (Math.random()*numero).toFixed(0);
}

function colorRGB(){
	var coolor = "("+generarNumero(255)+"," + generarNumero(255) + "," + generarNumero(255) +")";
	return "rgb" + coolor;
}

///Funcion para 1er GRAfico
function Graficosxscritpjson_1ergraf(idempresa,  mes, anio)
   {
	    var salesGraphChartOptions = {
					maintainAspectRatio : false,
					responsive : true,
					legend: {
					  display: false,
					},
					scales: {
					  xAxes: [{
						ticks : {
						  fontColor: '#000000',
						},
						gridLines : {
						  display : false,
						  color: '#ffffff',
						  drawBorder: false,
						}
					  }],
					  yAxes: [{
						ticks : {
						 fontColor: '#efefef',
						},
						gridLines : {
						  display : true,
						  color: '#efefef',
						  drawBorder: false,
						}
					  }]
					}
				  }

var canvas = document.getElementById("visitors-chart2");
var context = canvas.getContext('2d');
context.clearRect(0, 0, canvas.width, canvas.height); 
	      ////////////////////GRAFICOS x dia
		  var salesGraphChartCanvas1er = $('#visitors-chart2').get(0).getContext('2d');  
		
		  $.ajax({
				url: 'ajaxdatosgraficos2year.php', 				
				data: "idempresa="+idempresa+'&anio='+anio+'&mes='+mes,					
				type: 'post',	
				dataType:'json',				
				cache:false,					
				success: function(dataresultm, status, xhr) {
				//// REcorremos resultados
				
				if (dataresultm.c =="")
						{
							 var salesGraphChartData1xdia = {    								
								 	labels:['No Data'],
									datasets:[]
								  }	
								  
							var salesGraphChart = new Chart(salesGraphChartCanvas1er, { 
							  type: 'line', 
							  data: salesGraphChartData1xdia, 
							  options: salesGraphChartOptions
							}	);							  
							
							
							
							
						}
						else
						{	
			   eval("var salesGraphChartData1xdia = { labels  :["+ dataresultm.b + "] , datasets: [" +dataresultm.a + " ]}");
					//console.log("var salesGraphChartData1 = { labels  :["+ dataresultm.b + "] , datasets: [" +dataresultm.a + " ]}");
					  // This will get the first returned node in the jQuery collection.0
						
					  // This will get the first returned node in the jQuery collection.
					  var salesGraphChart = new Chart(salesGraphChartCanvas1er, { 
						  type: 'line', 
						  data: salesGraphChartData1xdia, 
						  options: salesGraphChartOptions
						}
						)
					
						
						}
  
				
				},
				error: function(xhr, status, error) {
					 console.log(status);
				}
				});
				
					$("#nombmes").html('<b>'+monthNames[mes]+ ' / '+ anio+'</b>'	);		
				 

				
		
   }





///Funcion para el 2do grafico

 function Graficosxscritpjson(idempresa, anio, mes)
   {
	 //  console.log('call');
	   var salesGraphChartData2  = '';
	//   alert('a');
	      ////////////////////GRAFICOS
		  var canvas = document.getElementById("visitors-chart");
var context = canvas.getContext('2d');
context.clearRect(0, 0, canvas.width, canvas.height); 

		  var salesGraphChartCanvas = $('#visitors-chart').get(0).getContext('2d');  
		
		  $.ajax({
				url: 'ajaxdatosgraficos0year.php', 				
				data: "idempresa="+idempresa+'&anio='+anio+'&mes='+mes,					
				type: 'post',	
				dataType:'json',				
				cache:false,					
				success: function(dataresultm, status, xhr) {
					
				//	console.log(dataresultm.b);
				//	var objm = JSON.parse( dataresultm.a );
				//	console.log(dataresultm.a);
			/*		 var salesGraphChartData1 = {    								
								 	 labels  : dataresultm.b,
									 datasets: eval(dataresultm.a) 
								  }								
						*/	
					//	console.log( dataresultm.a.length )
						if (dataresultm.c =="")
						{
							 var salesGraphChartData1 = {    								
								 	labels:['No Data'],
									datasets:[]
								  }	
								  
var salesGraphChart = new Chart(salesGraphChartCanvas, { 
							  type: 'line', 
							  data: salesGraphChartData1, 
							  options: salesGraphChartOptions
							}	);							  
						}
						else
						{	
					       eval("var salesGraphChartData1 = { labels  :["+ dataresultm.b + "] , datasets: [" +dataresultm.a + " ]}");
					//console.log("var salesGraphChartData1 = { labels  :["+ dataresultm.b + "] , datasets: [" +dataresultm.a + " ]}");
					  // This will get the first returned node in the jQuery collection.0
						  var salesGraphChart = new Chart(salesGraphChartCanvas, { 
							  type: 'line', 
							  data: salesGraphChartData1, 
							  options: salesGraphChartOptions
							}
						  );
								
						}		
						$("#lblgrafico").html(dataresultm.c);	
						$("#nombmesgrafico2").html('<b>'+monthNames[mes]+ ' / '+ anio+'</b>'	);							

					
				
				},
				error: function(xhr, status, error) {
					 console.log(status);
				}
				});
				
				
				  var salesGraphChartOptions = {
					maintainAspectRatio : false,
					responsive : true,
					legend: {
					  display: false,
					},
					scales: {
					  xAxes: [{
						ticks : {
						  fontColor: '#000000',
						},
						gridLines : {
						  display : false,
						  color: '#ffffff',
						  drawBorder: false,
						}
					  }],
					  yAxes: [{
						ticks : {
						 fontColor: '#efefef',
						},
						gridLines : {
						  display : true,
						  color: '#efefef',
						  drawBorder: false,
						}
					  }]
					}
				  }


				
		
   }

   function Graficosxscritp(idempresa, anio, mes)
   {
	      ////////////////////GRAFICOS
		   var salesGraphChartCanvas = $('#visitors-chart').get(0).getContext('2d');
		    var salesGraphChartData = {
    
    datasets: [
		  <?php
		  
		  function color_rand() {
 return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
 }
		  
					$query_lista_repor =" select * from fnt_select_runinfo_by_business_count_byscriptyear(); ";
				//		$query_lista_repor =" select * from runinfodb limit 1; ";
					$resultadorepor = $connect->query($query_lista_repor);	
					$loslabels="";
					foreach ($resultadorepor as $rowreport) 
					{
					//	echo "<br>b:".$rowreport[0];
					 
						$arraydatos  = json_decode($rowreport[0], true);		
						$elcolorrandow = color_rand();

						$nomb= $arraydatos['nobmrescript']; 
						$diames =  implode(",",$arraydatos['diames']); 
						$valorxdia =  implode(",",$arraydatos['ccc']);
						$loslabels=$loslabels." <span class='mr-2'><i class='fas fa-square' style='color:$elcolorrandow;'></i>[".$nomb."]</span> ";
					//	$loslabels= " <span class='mr-2'><i class='fas fa-square text-primary'></i>[".$nomb."]</span> ";
						
						?>
						   {
							label               : '<?php echo $nomb;   ?>',
							fill                : false,
							borderWidth         : 2,
							lineTension         : 0,
							spanGaps : true,
							borderColor         : '<?php echo $elcolorrandow;  ?>',
							pointRadius         : 3,
							pointHoverRadius    : 7,
							pointColor          : '#efefef',
							pointBackgroundColor: '#efefef',
							data                : [<?php echo $valorxdia;   ?>]
						  },
						<?php
						
					}	
					?>
					
					 
  //$('#revenue-chart').get(0).getContext('2d');

 
   
				
    ],
	labels  : [<?php echo $diames ; ?>],
  }
 // console.log('<?php echo $loslabels; ?>');
  $("#lblgrafico").html("<?php echo $loslabels ?>");
 
  var salesGraphChartOptions = {
    maintainAspectRatio : false,
    responsive : true,
    legend: {
      display: false,
    },
    scales: {
      xAxes: [{
        ticks : {
          fontColor: '#000000',
        },
        gridLines : {
          display : false,
          color: '#ffffff',
          drawBorder: false,
        }
      }],
      yAxes: [{
        ticks : {
         fontColor: '#efefef',
        },
        gridLines : {
          display : true,
          color: '#efefef',
          drawBorder: false,
        }
      }]
    }
  }

  // This will get the first returned node in the jQuery collection.
  var salesGraphChart = new Chart(salesGraphChartCanvas, { 
      type: 'line', 
      data: salesGraphChartData, 
      options: salesGraphChartOptions
    }
  )
  
  
  
   ///////////////////FIN GRAFICOS
   }
   
   function mostrar_todo_ticket()
   {
	   var losdatos="";
	   losdatos =   $("#mostrartdo").html();
	 //  $(".table-success").removeClass('d-none');
	
	   if (losdatos.indexOf("all") >= 0)
	   {
		   		$("#mostrartdo").html('<i class="fas fa-eye-slash"></i> See pending / in process');
				   $(".table-success").removeClass('d-none');
	   }
	   else
	   {
		   		$("#mostrartdo").html('<i class="far fa-eye"></i> View all');
				   $(".table-success").addClass('d-none');
	   }

	   
   }
   
   

      ////////////////////GRAFICOS2

  


   ///////////////////FIN GRAFICOS
   //
   function restomes1()
   {
	 var sssb = new Date($("#graf2anio1").val());
		
			var f = new Date(restarDias(sssb ,30));
	$('#graf2anio1').val(f.getFullYear() + "/" + (f.getMonth() +1) + "/" + f.getDate());
 
	var elmes = (f.getMonth() +1) ;
		$('#graf2anio1').val(f.getFullYear() + "/" + elmes + "/" + f.getDate());
 
		Graficosxscritpjson_1ergraf( 0,elmes,f.getFullYear());
 
   }
   
   function sumomes1()
   {

		var sssb = new Date($("#graf2anio1").val());
		
		var f = new Date(sumarDias(sssb ,30));
var elmes = (f.getMonth() +1) ;
		$('#graf2anio1').val(f.getFullYear() + "/" + elmes + "/" + f.getDate());
 
	Graficosxscritpjson_1ergraf( 0,elmes,f.getFullYear());
 
	 //    $("#graf2anio").val( sumarDias(sssb ,30) );
	   //  $("#graf2mes").val(fecha.getMonth()); 
   }
   
   
   function restomes()
   {
	 var sssb = new Date($("#graf2anio").val());
		
			var f = new Date(restarDias(sssb ,30));
		var elmes = (f.getMonth() +1) ;
		$('#graf2anio').val(f.getFullYear() + "/" + elmes + "/" + f.getDate());
 
		Graficosxscritpjson(  $('#graf2anioidbusiness').val(),f.getFullYear(),elmes);
   }
   
   function setbusiness(elvaloraset,idbutton)
   {
	   $('#graf2anioidbusiness').val(elvaloraset);
	    $('#btntodass').html("ALL");
		$('#btntodassf').html("FIPLEX");
		$('#btntodasss').html("SPINNAKER");
		$('#btntodassw').html("WESTELL");		
	
		$('#'+idbutton).append("  <i class='far fa-check-circle'></i>");
		
		var sssb = new Date($("#graf2anio").val());
			var elmes = (sssb.getMonth() +1) ;
			Graficosxscritpjson(  $('#graf2anioidbusiness').val(),sssb.getFullYear(),elmes);
	   
   }
   
   function sumomes()
   {

		var sssb = new Date($("#graf2anio").val());
		
		var f = new Date(sumarDias(sssb ,30));
		var elmes = (f.getMonth() +1) ;
	  $('#graf2anio').val(f.getFullYear() + "/" + elmes + "/" + f.getDate());
 
		///Graficosxscritp(idempresa, anio, mes)
		Graficosxscritpjson(  $('#graf2anioidbusiness').val(),f.getFullYear(),elmes);
 
	 //    $("#graf2anio").val( sumarDias(sssb ,30) );
	   //  $("#graf2mes").val(fecha.getMonth()); 
   }
   
   function sumarDias(fecha, dias){
  fecha.setDate(fecha.getDate() + dias);
  return fecha;
}
   function restarDias(fecha, dias){
  fecha.setDate(fecha.getDate() - dias);
  return fecha;
}
   
</script>

<script type="text/javascript">
    $(function() {
        $(".knob").knob();
    });
</script>

</html>
 
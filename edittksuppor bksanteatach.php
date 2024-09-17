<!DOCTYPE html>
<?php 

// Desactivar toda notificación de error
error_reporting(0);
// Notificar todos los errores de PHP (ver el registro de cambios)
//error_reporting(E_ALL);
 include("db_conect.php"); 
 
 	session_start();
	
	
	$vidtksuppor = $_REQUEST['idt'];
	
	if( isset($_POST['detalletk']) )
{
     $vvdetalletk = $_POST['detalletk'];
	 $vvidestado = $_POST['idestado'];
	$vvidtksupport = $_POST['idtksupport'];	 
//    echo "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa:".$vvdetalletk;
	 
	 	$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$connect->beginTransaction();
			 try {
					//$connect->query($sql);
					$lafecha="now()";
					$sentencia = $connect->prepare("INSERT INTO public.fas_techsupport_state(
	idfas_techsupport, datessupportstate, commentsupport, idstatesupport, idusersupport)
	VALUES (:idfas_techsupport, CURRENT_TIMESTAMP, :commentsupport, :idstatesupport, :idusersupport);");
					
					
					$sentencia->bindParam(':idfas_techsupport', $vvidtksupport);
					$sentencia->bindParam(':commentsupport', $vvdetalletk);
					$sentencia->bindParam(':idstatesupport', $vvidestado);
					$sentencia->bindParam(':idusersupport', $_SESSION["a"] );
			
					
					$sentencia->execute();
					$return_result_insert="ok";
				    $connect->commit();
					
					$nomusersupport="";
					if( $_SESSION["a"] =="1")
					{
						$nomusersupport="Agustin Corigliano";
					}
					if( $_SESSION["a"] =="2")
					{ 
						$nomusersupport="Leandro Julian";
					}
					if( $_SESSION["a"] =="17")
					{
						$nomusersupport="Marco Moretti";
					}
				
					//Avisos..!
					
						/// Enviamos Aviso soprote
					 include("configsendmail.php"); 
				

					  //Asignamos asunto y cuerpo del mensaje
					  //El cuerpo del mensaje lo ponemos en formato html, haciendo 
					  //que se vea en negrita
					
						
						
								$ipservercloud="107.191.42.48";
								$ipservercloud="fas01.fiplex.com";
								
						$vuserdbcloud="bucardo";
						$vpassdbcloud="EUT$Y6VdwvZx6-KJ";
						$vdbnamecloud="dbfiplexrepli";
						
						   $vuserdbcloud="wfeibpulseexr";
						$vpassdbcloud="d-VcL{3D[Wef7pH=";
						$vdbname="dbfiplexrepli";
						
							if ( $_SERVER['SERVER_ADDR'] =="192.168.60.262")
						{
						/// SRv Test Fiplex 
						 try {
												$connectNUBE = new PDO('pgsql:host='.$ipservercloud.';port=5432;dbname='.$vdbnamecloud.';user='.$vuserdbcloud.';password='.$vpassdbcloud.'');
													 $connectNUBE->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
													 
							} catch (PDOException $e) {
								echo 'Falló la conexión: ' . $e->getMessage();
							}
							$sql = $connectNUBE->prepare("select fas_techsupport.*, userfas.usermail, userfas.nameuserfas  from  fas_techsupport INNER JOIN userfas  ON userfas.username = fas_techsupport.userreported where idfas_techsupport = ".$vvidtksupport." ");
						}
						else
						{
							$sql = $connect->prepare("select fas_techsupport.*, userfas.usermail, userfas.nameuserfas  from  fas_techsupport INNER JOIN userfas  ON userfas.username = fas_techsupport.userreported where idfas_techsupport = ".$vvidtksupport." ");
						}
						
						
						
					
					  $vemail_dondeavisar="";
					   $vnombre_dondeavisar="";
					  
							
								$sql->execute();
							$resultadostock = $sql->fetchAll();
								 foreach ($resultadostock as $rowstock) 
								{			
									  $vemail_dondeavisar =  $rowstock['usermail'];
									  $vnombre_dondeavisar=  $rowstock['nameuserfas'];
									   $viisue=  $rowstock['issue'];
										
								}
								//echo "a quine".$vemail_dondeavisar;
						if ($vemail_dondeavisar <>"")
						{
								$mail->addAddress($vemail_dondeavisar,  $vnombre_dondeavisar);
								$mail->addBCC('marco.moretti@fiplex.com', 'marco ');
								//$mail->addBCC('agustin.corigliano@fiplex.com', 'Agus');
								//$mail->addBCC('leandro.julian@fiplex.com', 'Agus');
		
							  $mail->Subject = "Tech Support::New Solution #".$vvidtksupport." -- Issue: ".$viisue;
							  $mail->Body = "<b>New Solution:</b> ".$vvidtksupport."<br><b>UserReported:</b> ".$vnombre_dondeavisar."<br><b> Issue:</b> ".$viisue." -<br><br>Report status:".$vvdetalletk."<br><b>User Support:</b>".$nomusersupport."<br><br><br>Enter <a href='http://webfas.fiplex.com' target='_blank'> webfas.fiplex.com </a> to see more information about the ticket";
							//Definimos AltBody por si el destinatario del correo no admite email con formato html 
							  $mail->AltBody = "New Solution:".$vvidtksupport." -- From: - UserReported:".$vnombre_dondeavisar." -- Issue: ".$viisue;

								$mail->Send();
						}
					
					
					
					
					
				} 
				catch (PDOException $e) 
				{
					$connect->rollBack();
					$return_result_insert="error";
					$msjerr= "Syntax Error MM: ".$e->getMessage();
				}
	 
	
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
  <link rel="stylesheet" href="plugins/ion-rangeslider/css/ion.rangeSlider.css">
  
  <!-- AdminLTE css -->
  <link rel="stylesheet" href="dist/css/adminlte.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  
  <link href="css/tabulator_bootstrap4.css" rel="stylesheet">
  <link rel="shortcut icon" href="fiplexcirculo-01.ico" />
  
  <link rel="stylesheet" href="toastr.css">
  
 <link href="css/tabulator_bulma.css" rel="stylesheet">
 
  
    <link rel="stylesheet" href="cssfiplex2.css">
	    <link rel="stylesheet" href="css/viewer.min.css">
		 <style>
		 
		 .containermarco {
    width: 98%;
     padding-right: 7.5px; 
     padding-left: 7.5px; 
     margin-right: auto; 
     margin-left: auto; 
	}

    .pictures {
      list-style: none;
      margin: 0;
      max-width: 30rem;
      padding: 0;
    }

    .pictures > li {
    /*  border: 1px solid transparent;
      float: left;
      height: calc(100% / 2);
      margin: 0 31px 0px 15px;
      overflow: hidden;
      width: calc(100% / 2);*/
    }

    .pictures > li > img {
      cursor: zoom-in;
      width: 100%;
    }
	.rowmm {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
     margin-right: -1.5px; 
     margin-left: -1.5px; 
}


.card {
    box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
    margin-bottom: 5px;
}

.irs-grid_marco_verde {
    background: #28a745;
}
.irs-grid_marco_amarillo {
    background: #ffc107;
}
.irs-grid_marco_rojo {
    background: #dc3545;
}


.divmarco {
	  margin-top: 17.5px; 
}


form-control
{
	 height:638px;
	 /*height:644px;*/
	 font-size: 13px;
}

.form-controlmsjtk
{
	 height:338px;
	 /*height:644px;*/
	 font-size: 13px;
}

  </style>
  
</head>
<form name="frma" id="frma"  action="edittksuppor.php?idt=<?php echo $vidtksuppor; ?>" method="post"  class="form-horizontal needs-validation"  >							
				



<input type="hidden" name="uso" id="uso" value="0">
<body class="hold-transition sidebar-mini sidebar-collapse">

  <div class="containermarco">
  


<!-- Site wrapper -->
<div class="wrapper">
  <div class="">

  <section class="content">
	
	 <div class="container-fluid">
	
	   <br>
	   <div class="row invoice-info">
                <div class="col-sm-4 invoice-col texto10">
             

                  <address>
				  <?php
						if 	($return_result_insert=="ok")
					{
						?>
						
							<div class="alert alert-success alert-dismissible">
							
							   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h5><i class="icon fas fa-check"></i> Saved!</h5>
                
							  <!-- /.info-box-content -->
							</div>
							<!-- /.info-box -->
						
						
						  
						  
						<?php
					}	
					if 	($return_result_insert=="error")
					{
						?>
						<div class="alert alert-success alert-dismissible">
							
							   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h5><i class="icon fas fa-exclamation-triangle"></i> Error!</h5>
								<?php echo $msjerr;?>		
							  <!-- /.info-box-content -->
							</div>
							
						
						
						<?php
					}			
					?>
					
					
					
					<?php
									
					
					?>
					<div class="callout callout-info">
					<?php
						$vidtksuppor = $_REQUEST['idt'];
					
							$sqlvertk = "select *  from fas_techsupport where idfas_techsupport=".$vidtksuppor;
							
								if ( $_SERVER['SERVER_ADDR'] =="192.168.60.2226")
						{
						/// SRv Test Fiplex 
										
	
							$ipservercloud="107.191.42.48";
								$ipservercloud="fas01.fiplex.com";
								
						$vuserdbcloud="bucardo";
						$vpassdbcloud="EUT$Y6VdwvZx6-KJ";
						$vdbnamecloud="dbfiplexrepli";
						
						   $vuserdbcloud="wfeibpulseexr";
						$vpassdbcloud="d-VcL{3D[Wef7pH=";
						$vdbname="dbfiplexrepli";
						
						
						 try {
					$connect = new PDO('pgsql:host='.$ipservercloud.';port=5432;dbname='.$vdbnamecloud.';user='.$vuserdbcloud.';password='.$vpassdbcloud.'');
						 $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						 
} catch (PDOException $e) {
    echo 'Falló la conexión: ' . $e->getMessage();
}
	
							
								
						}
						
						
						$resultk = $connect->query($sqlvertk)->fetchAll();		
									
		
							foreach ($resultk as $rowtk) {
								$vvidruninfo = $rowtk['idruninfo'];
								$vvidruninfodateinfo = $rowtk['dateinfo'];
								$vvissue = $rowtk['issue'];
								$vvuserreported = $rowtk['userreported'];
								$quickref = $rowtk['keywordref'];
								$vvdatereported = substr($rowtk['datereported'],0,19);
								
							}
							
							$sqlvertk = "select *  from runinfodb where idruninfodb=".$vvidruninfo;
							$resultk = $connect->query($sqlvertk)->fetchAll();	
							foreach ($resultk as $rowtk) {
								$vvdetlog =  $rowtk['loginfo'];  
							}
							if ($vvdetlog ==  "null")
							{
								$vvdetlog="";
							}
								
					?>
					  <strong>User Report: <?php echo $vvuserreported;  ?></strong>
					  <br><b>IdRuninfo:</b> <?php echo $vvidruninfo;  ?><br>
					  <b>Reference keywords:</b> <?php echo $quickref;  ?><br>
					  
					  <span class="texto10"><b> Date:</b> <?php echo $vvdatereported;  ?> <br>
					<b>Issue</b> <?php echo $vvissue;  ?> <br></span>
					<hr>
					
					
					<!-- mosramos aca el historial -->
			

					<?php if ($_SESSION["g"] == "develop") {  ?>
					  <h6><i class="fas fa-info"></i> Inform User Status :</h6>
						<textarea class="form-control form-controlmsjtk" rows="12" id="detalletk" name="detalletk"></textarea>
						<br>
						
					<div class="btn-group">
                    <button type="button" class="btn btn-default">Action</button>
                    <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                      <span class="sr-only">Toggle Dropdown</span>
                      <div class="dropdown-menu" role="menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-1px, 37px, 0px);">
                       <input type="hidden" name="idestado" id="idestado" value="">
					    <input type="hidden" name="idtksupport" id="idtksupport" value="<?php echo $vidtksuppor;  ?>">
					   
						<?php
						//SELECT * from fas_techsupport_typestate
						$sqlvertk = "SELECT * from fas_techsupport_typestate where priority>1";
							$resultk = $connect->query($sqlvertk)->fetchAll();	
							foreach ($resultk as $rowtk) {
								echo "<a class='dropdown-item ".str_replace("table","text",$rowtk['nameclass'])."' href='#' onclick='savetkestate(".$rowtk['idtypestate'].")'>". $rowtk['namestate']."</a>";
							}
							
							
					
						?>
					
                      </div>
                    </button>
                  </div>
					<?php } ?>
					</div>
                  </address>
               
				  </div>
                <!-- /.col -->
                <div class="col-sm-8 invoice-col">
              
                  <address>
                    <div class="d-md-flex">
                  <div class="p-1 flex-fill" style="overflow: hidden" >
				  <span class="colornaranajafiplex"><b>State History:</b></span>
					<table class="table table-sm">
					  <thead>
    <tr>
      <th scope="col">Date</th>
      <th scope="col">User Support</th>
      <th scope="col">Comment</th>
     
    </tr>
  </thead>
					<?php
					$vvtienehistorial =0;
					
					$sqlvertk = "select distinct fas_techsupport_state.*, username, fas_techsupport_typestate.*   from fas_techsupport_state
	inner join fas_techsupport_typestate
	on fas_techsupport_typestate.idtypestate = fas_techsupport_state.idstatesupport	
	inner join userfas
	on userfas.iduserfas= fas_techsupport_state.idusersupport
	where fas_techsupport_state.idfas_techsupport  =".$vidtksuppor." 	order by datessupportstate desc";
		//echo $sqlvertk;
						$resultk = $connect->query($sqlvertk)->fetchAll();				
		
							foreach ($resultk as $rowtk) {

								$vvtienehistorial =1;
									echo "<tr><td class=".$rowtk['nameclass'].">". substr($rowtk['datessupportstate'],0,19)."</td>" ;
									echo "<td class=".$rowtk['nameclass'].">".$rowtk['username']."</td>" ;
	
									echo "<td class=".$rowtk['nameclass'].">".$rowtk['commentsupport']."</td></tr>" ;
							
								
							}
							
							if ($vvtienehistorial==0)
							{
								echo "<tr><td class='text-info'>no support states</td></tr>";
							}
					
					?>
					</table>
				  <b>Log Details </b>
				  <?php if ($_SESSION["g"] == "develop") {  ?>
                    <textarea class="form-control form-controltksupoer" rows="18" id="detallelog" name="detallelog"><?php echo $vvdetlog;  ?></textarea>
				  <?php } else  {


						$porciones = explode("\n", $vvdetlog);
							
								//echo "".trim(substr($row[0],0,10))."\r\n";
							$vmostrar = "".trim(substr($vvidruninfodateinfo,0,10))."\r\n";
								foreach ($porciones as &$valor) {
								//	$pos = 	strstr($valor, '###',true);
									$pos =substr_count($valor, '###');
									
									//$pos2 = strstr($valor, '$$$',true);
									$pos2 =substr_count($valor, '$$$');
									
									
									//	if ($pos =="" &&  $pos2 =="" )	
										if ($pos ==0 &&  $pos2 ==0 )							
											{
										//	echo "".trim(substr($row[0],0,10))."\r\n".$valor;
											//echo "".$valor."\r\n";
											//$vmostrar = $vmostrar."-mm".$pos."mm-".$valor." *finlinea*\r\n";
											$posbr = 	strstr($valor, '<br>',true);
											if ($posbr =="")
											{
												
												$vmostrar = $vmostrar." ".$valor."\r\n";
											}
											else
											{
											
												$vmostrar = $vmostrar." ".$valor;
												
											}
											
										//	$vmostrar = $vmostrar."".$valor."";
										} 
										///echo "-array:info:".$valor."\r\n";
										//$vmostrar = $vmostrar."".$valor."\r\n";
							}



					  ?>
				<textarea class="form-control form-controltksupoer" rows="18" id="detallelog" name="detallelog"><?php echo $vmostrar;  ?></textarea>
				  <?php } ?>				  
                  </div>
            
                  </div><!-- /.card-pane-right -->
                  </address>
                </div>
             
              </div>
			  
	
		
      </div>
  
  </div>
    </section>

  </div>

  </form>



  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
</div>

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



</body>

<script type="text/javascript">

function savetkestate(idnewestate)
{
	if ($('#detalletk').val()=="")
	{
		alert('enter a detail of the solution');
	}
	else
	{
		//ajax por info.
		$('#idestado').val(idnewestate);
		$('#frma').submit();
		
	}
	
	
	
}

</script>

</html>

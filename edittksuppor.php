<!DOCTYPE html>
<?php 

// Desactivar toda notificación de error
//error_reporting(0);
// Notificar todos los errores de PHP (ver el registro de cambios)
error_reporting(E_ALL);
 include("db_conect.php"); 
 
 	session_start();
	
	
	$vidtksuppor = $_REQUEST['idt'];
	$permitirgrabar = $_REQUEST['abm'];
	
	if( isset($_POST['detalletk']) && $_POST['uso']==1 )
{
     $vvdetalletk = $_POST['detalletk'];
	 $vvidestado = $_POST['txtnewaction'];
	$vvidtksupport = $_POST['idtksupport'];	 
		$vv_userreported = trim($_SESSION["b"]);
		

	 	$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
			 try {
					//$connect->query($sql);
					$lafecha="now()";
			
					
					///		activamos el reenvio..			
					if( $vvidestado == 7 || $vvidestado == 8 )
					{
						// copiamos el TK y se lo asociamos al userenviado.
						// creamos nuestao estado Open del tk
						
						/*
					sp_insert_techsupport_asinguser(
	v_idtksuupor integer,
	v_userreported character varying,
	v_iduserto integer,
	v_idareato integer,
	v_descripcion character varying,
	v_idcategory integer)
						*/
						
						
						$txtreenviar = $_POST['txtreenviar'];	 
						$porciones_aquieenvio = explode("#", $txtreenviar);	
			
							$query_lista = "CALL sp_insert_techsupport_asinguser(".$vvidtksupport.",'".$vv_userreported."',".$porciones_aquieenvio[0].",".$porciones_aquieenvio[2].",'".$vvdetalletk."',".$vvidestado.");";
				///echo "ejecuto de nuevo<br>".$query_lista;
							$connect->query($query_lista);
							
						$vuserfas = $_SESSION["b"];
						$vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
						$vaccionweb="INSERT";
						$vdescripaudit=" INSERT TK STATUS ";	
						$vtextaudit=$query_lista;
					
						$sentenciaudit = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
								$sentenciaudit->bindParam(':userfas', $vuserfas);								
								$sentenciaudit->bindParam(':menuweb', $vmenufas);
								$sentenciaudit->bindParam(':actionweb', $vaccionweb);
								$sentenciaudit->bindParam(':descripaudit', $vdescripaudit);
								$sentenciaudit->bindParam(':textaudit', $vtextaudit);
								$sentenciaudit->execute();		
						
						///	echo "---ejecutoooooooo";
					}
					else
					{
					//	$connect->beginTransaction();
								$sentencia = $connect->prepare("INSERT INTO public.fas_techsupport_state(
	idfas_techsupport, datessupportstate, commentsupport, idstatesupport, idusersupport, idusertohistory)
	VALUES (:idfas_techsupport, CURRENT_TIMESTAMP, :commentsupport, :idstatesupport, :idusersupport, :idusertohistory);");
					
					
					$sentencia->bindParam(':idfas_techsupport', $vvidtksupport);
					$sentencia->bindParam(':commentsupport', $vvdetalletk);
					$sentencia->bindParam(':idstatesupport', $vvidestado);
					$sentencia->bindParam(':idusersupport', $_SESSION["a"] );
						$sentencia->bindParam(':idusertohistory', $_SESSION["a"] );
						$sentencia->execute();
					$return_result_insert="ok";
					
					

					$vuserfas = $_SESSION["b"];
						$vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
						$vaccionweb="INSERT";
						$vdescripaudit=" INSERT TK STATUS ";	
						$vtextaudit="INSERT INTO public.fas_techsupport_state(
	idfas_techsupport, datessupportstate, commentsupport, idstatesupport, idusersupport, idusertohistory)
	VALUES (".$vvidtksupport.", CURRENT_TIMESTAMP, ".$vvdetalletk.", ".$vvidestado.",".$_SESSION["a"] .", ".$_SESSION["a"].");";
					
						$sentenciaudit = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
								$sentenciaudit->bindParam(':userfas', $vuserfas);								
								$sentenciaudit->bindParam(':menuweb', $vmenufas);
								$sentenciaudit->bindParam(':actionweb', $vaccionweb);
								$sentenciaudit->bindParam(':descripaudit', $vdescripaudit);
								$sentenciaudit->bindParam(':textaudit', $vtextaudit);
								$sentenciaudit->execute();					
				//	  $connect->commit();
					//  	echo "---ejecutoooooooo";
					  
								  if( $vvidestado ==3 )
								{
								  // Buscamos si el TK es TK reenviado.
								  //SI es reenviado insertamos ESTADO DE AVISO Q se Finalizo.
									$sql2="	select idfas_techsupport  from  fas_techsupport where   idgrouper = ".$vvidtksupport."  ";
									
									$result_max_tkxusuario = $connect->query($sql2)->fetchAll();
										foreach ($result_max_tkxusuario as $rowdatos)
										{
										//	echo $sql2;
											$idtkfather = $rowdatos['idfas_techsupport'];
											
										//	 include("db_conect.php"); 
											$sentencia = $connect->prepare("INSERT INTO public.fas_techsupport_state( idfas_techsupport, datessupportstate, commentsupport, idstatesupport, idusersupport, idusertohistory) VALUES (:idfas_techsupport, CURRENT_TIMESTAMP, :commentsupport, :idstatesupport, :idusersupport, :idusertohistory);");
								
											$idnuevoestadod = 9;
											$sentencia->bindParam(':idfas_techsupport', $idtkfather);
											$sentencia->bindParam(':commentsupport', $vvdetalletk);
											$sentencia->bindParam(':idstatesupport', $idnuevoestadod);
											$sentencia->bindParam(':idusersupport', $_SESSION["a"] );
												$sentencia->bindParam(':idusertohistory', $_SESSION["a"] );
											//	echo "a";
												//$sentencia->execute();
											//	echo "b";
										}
								}
					
					}	
			
					
				
				  
					
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
					
						

							$sql = $connect->prepare("select fas_techsupport.*, userfas.usermail, userfas.nameuserfas,userfasfw.nameuserfas as nameuserfasfw, userfasfw.usermail as usermailfw  from  fas_techsupport INNER JOIN userfas  ON userfas.username = fas_techsupport.userreported left JOIN userfas AS userfasfw  ON userfasfw.iduserfas = fas_techsupport.iduserto  where idfas_techsupport = ".$vvidtksupport." ");
						
						
						
						
					
					  $vemail_dondeavisar="";
					   $vnombre_dondeavisar="";
					  
							
								$sql->execute();
							$resultadostock = $sql->fetchAll();
								 foreach ($resultadostock as $rowstock) 
								{			
									  $vemail_dondeavisar =  $rowstock['usermail'];
									  $vemail_dondeavisarfw =  $rowstock['usermailfw'];
									  $vnombre_dondeavisar=  $rowstock['nameuserfas'];
									  $vnombre_dondeavisarfw=  $rowstock['nameuserfasfw'];
									   $viisue=  $rowstock['issue'];
										
								}
								//echo "a quine".$vemail_dondeavisar;
								
					if( $vvidestado == 7 || $vvidestado == 8 )
					{
						if ($vnombre_dondeavisarfw <>"") 
						{
								$mail->addAddress($vemail_dondeavisar,  $vnombre_dondeavisar);
								$mail->addCC($vemail_dondeavisarfw,   $vnombre_dondeavisarfw);
								$mail->addBCC('marco.moretti@fiplex.com', 'marco ');
								
								//$mail->addBCC('leandro.julian@fiplex.com', 'Agus');
		
							  $mail->Subject = "Tech Support::Fwd Ticket #".$vvidtksupport." -- Issue: ".$viisue;
							  $mail->Body = "<b>Fwd Ticket:</b> ".$vvidtksupport."<br><b>UserReported:</b> ".$vnombre_dondeavisar."<br><b> Issue:</b> ".$viisue." -<br><br>Report status:".$vvdetalletk."<br><b>User Support:</b>".$nomusersupport."<br><br><br>Enter <a href='http://webfas.fiplex.com' target='_blank'> webfas.fiplex.com </a> to see more information about the ticket";
							//Definimos AltBody por si el destinatario del correo no admite email con formato html 
							  $mail->AltBody = "Fwd Ticket:".$vvidtksupport." -- From: - UserReported:".$vnombre_dondeavisar." -- Issue: ".$viisue;

								$mail->Send();
						}
					}
					else
					{	
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
	display: block;
    width: 100%;
    height: calc(2.25rem + 2px);
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: #ffffff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    box-shadow: inset 0 0 0 rgba(0, 0, 0, 0);
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
	 height:100px;
	 font-size: 13px;
}

.direct-chat-messages {
    -webkit-transform: translate(0, 0);
    transform: translate(0, 0);
      overflow: auto;
	   height:400px;
    padding: 10px;
}

  </style>
  
</head>
<form name="frma" id="frma"  action="edittksuppormarco.php?idt=<?php echo $vidtksuppor; ?>" method="post"  class="form-horizontal needs-validation"  >							
				



<input type="hidden" name="uso" id="uso" value="0">
<input type="hidden" name="lenmsjchat" id="lenmsjchat" value="0">
<input type="hidden" name="idtksupport" id="idtksupport" value="<?php echo $vidtksuppor;?>">
<body class="hold-transition sidebar-mini sidebar-collapse">

  <div class="containermarco">
  


<!-- Site wrapper -->
<div class="wrapper">
  <div class="">

  <section class="content">
	
	 <div class="container-fluid">
	
	   <br>
	   <div class="row invoice-info">
	   
	   
	   <div class="col-sm-4 card card-prirary cardutline direct-chat direct-chat-primary">

	   <div class="card-body" >
                <!-- Conversations are loaded here -->
                <div class="direct-chat-messages" name="divmarcochat" id="divmarcochat">
				
				<?php
						$vidtksuppor = $_REQUEST['idt'];					
						$sqlvertk = "select *  from fas_techsupport where idfas_techsupport=".$vidtksuppor;
							$resultk = $connect->query($sqlvertk)->fetchAll();		
									
		
							foreach ($resultk as $rowtk) {
								$vvidruninfo = $rowtk['idruninfo'];
								$vvissue = $rowtk['issue'];
								$vvuserreported = $rowtk['userreported'];
								$quickref = $rowtk['keywordref'];
								$vvdatereported = substr($rowtk['datereported'],0,19);
								
							}
					
							/// Buscamos los datos del log
						$sqlvertk = "select loginfo from runinfodb where idruninfodb  = ".$vvidruninfo;
							$resultk = $connect->query($sqlvertk)->fetchAll();		
									
		
							foreach ($resultk as $rowtk) {
								$vvdetlog = $rowtk['loginfo'];
							
								
							}

					
				?>			
				
                  <!-- Message. Default to the left -->
                  <div class="direct-chat-msg texto12">
				  	  <strong>User Report: <?php echo $vvuserreported;  ?></strong>
					  <br><b>IdRuninfo:</b> <?php echo $vvidruninfo;  ?><br>
					  <b>Reference keywords:</b> <?php echo $quickref;  ?><br>
					  
					  <span class="texto12"><b> Date:</b> <?php echo $vvdatereported;  ?> <br>
					<b>Issue</b> <?php echo $vvissue;  ?> <br></span>
					<hr>
					Attached files:<br>
					
					<?php
					
					$sqlvertk = "select *  from fas_techsupport_fileattach	 where idfas_techsupport=".$vidtksuppor;
					$resultkatta = $connect->query($sqlvertk)->fetchAll();		
									
		
							foreach ($resultkatta as $rowtk) {
								
								$porciones = explode("_", $rowtk['namefile']);
//echo $porciones[1]; // porción1

							
									?>	
										<a href="#" onclick="abrirgaleria('imgma<?php echo $porciones[1];?>')"><i class='fas fa-paperclip'></i><?php echo $porciones[1];?> </a><br>
						
								<?php
							}
					
				
					?>
					<hr>
					</div>
					<div id="viewmshchat" name="viewmshchat" class="texto12">
					</div>
					<?php if ($vvdatereported=="aa") { ?>
							 <div class="direct-chat-msg">	
								<div class="direct-chat-infos clearfix">
								  <span class="direct-chat-name float-left">Agustin Corigliano</span>
								  <span class="direct-chat-timestamp float-right">23 Jan 2:00 pm</span>
								</div>
								<!-- /.direct-chat-infos -->
								<img class="direct-chat-img" src="imgusers/user1.jpg" alt="Message User Image">
								<!-- /.direct-chat-img -->
								<div class="direct-chat-text">
								  Is this template really for free? That's unbelievable!
								</div>
								<!-- /.direct-chat-text -->
							  </div>
							  <!-- /.direct-chat-msg -->

							  <!-- Message to the right -->
							  <div class="direct-chat-msg right">
								<div class="direct-chat-infos clearfix">
								  <span class="direct-chat-name float-right">Leandro</span>
								  <span class="direct-chat-timestamp float-left">23 Jan 2:05 pm</span>
								</div>
								<!-- /.direct-chat-infos -->
								<img class="direct-chat-img" src="imgusers/user17.jpg" alt="Message User Image">
								<!-- /.direct-chat-img -->
								<div class="direct-chat-text">
								  You better believe it!
								</div>
								<!-- /.direct-chat-text -->
							  </div>
							  <!-- /.direct-chat-msg -->
				  
					<?php } ?>
				  
				  <div id="viewmshchatancla" name="viewmshchatancla">
					</div>
                </div>
                <!--/.direct-chat-messages-->

            
                <!-- /.direct-chat-pane -->
              </div>
			  <div class="card-footer">
                
			          <div class="input-group">
                    <input type="text" name="txtmsjchat" id="txtmsjchat" placeholder="Direct message to support ..." class="form-control form-control-sm>
                    <span class="input-group-append">
                      <button type="button" onclick="sendmsjdirect()" class="btn btn-outline-primary btn-flat btn-xs">Send</button>
                    </span>
                  </div>
                
              </div>
			  </div>
	   
	   
	   
	   
          
                <!-- /.col -->
                <div class="col-sm-8 invoice-col card card-prirary cardutline direct-chat direct-chat-primary">
              
                  <address>
                    <div class="d-md-flex">
                  <div class="p-1 flex-fill" style="overflow: hidden" >
				  <span class="colornaranajafiplex"><b>State History:</b></span>
					<table class="table table-sm texto10">
					  <thead>
    <tr>
      <th scope="col">Date</th>
      <th scope="col">User Support</th>
	   <th scope="col">State</th>
	 <th scope="col">Assigned to</th>
	   
		
      <th scope="col">Comment</th>
     
    </tr>
  </thead>
					<?php
					$vvtienehistorial =0;
					
					$sqlvertk = "select distinct fas_techsupport_state.*, userfas.username, fas_techsupport_typestate.*  ,fas_techsupport.iduserto, userfasto.username as nameuserfasto, fas_techsupport.idgrouper 
    from fas_techsupport_state
	inner join fas_techsupport
	on fas_techsupport.idfas_techsupport  = fas_techsupport_state.idfas_techsupport
	inner join fas_techsupport_typestate
	on fas_techsupport_typestate.idtypestate = fas_techsupport_state.idstatesupport	
	left join userfas
	on userfas.iduserfas= fas_techsupport_state.idusersupport
	left join userfas as userfasto
	on userfasto.iduserfas= fas_techsupport_state.idusertohistory
	where fas_techsupport_state.idfas_techsupport  =".$vidtksuppor." 	order by datessupportstate desc";
		//echo $sqlvertk;
						$resultk = $connect->query($sqlvertk)->fetchAll();				
		
							foreach ($resultk as $rowtk) {

								$vvtienehistorial =1;
									echo "<tr><td class=".$rowtk['nameclass'].">". substr($rowtk['datessupportstate'],0,19)."</td>" ;
									echo "<td class=".$rowtk['nameclass'].">".$rowtk['username']."</td>" ;
										echo "<td class=".$rowtk['nameclass'].">".$rowtk['namestate']."</td>" ;
											echo "<td class=".$rowtk['nameclass'].">".$rowtk['nameuserfasto'];
											if ( $rowtk['idgrouper']>0)
											{
											?>&nbsp;&nbsp;TK #<a href="#" onclick="openpopupframe(<?php echo  $rowtk['idgrouper']; ?>)"><?php echo $rowtk['idgrouper']; ?> <i class='far fa-eye'></i> </a>
											<?php }
											echo"</td>" ;
								
								
									
							
									echo "<td class=".$rowtk['nameclass'].">".$rowtk['commentsupport']."</td></tr>" ;
								$idmaxestado =  $rowtk['idstatesupport'];
								
							}
							
							if ($vvtienehistorial==0)
							{
								echo "<tr><td class='text-info'>no support states</td></tr>";
							}
					
					?>
					</table>
					 <h6><i class="fas fa-info"></i> Inform User Status :</h6>	
						<textarea class="form-controlmsjtk" rows="12" id="detalletk" name="detalletk"></textarea>
						<br>
						<?php 
						if($permitirgrabar == "")
						{
						 if($idmaxestado <> 3 &&  $idmaxestado  <> 8 &&  $idmaxestado <> 7)
						 {
					?>
							<div class="btn-group">
							
							
							<div class="input-group mb-3">New status:&nbsp;
					<select name="txtnewaction" id="txtnewaction" class="form-control form-control-sm " onclick="active_cmbresend(this.value)">
							<?php
						//SELECT * from fas_techsupport_typestate
						$sqlvertk = "SELECT * from fas_techsupport_typestate where priority>1 and active = true";
							$resultk = $connect->query($sqlvertk)->fetchAll();	
							foreach ($resultk as $rowtk) {
								echo "<option class='".str_replace("table","text",$rowtk['nameclass'])."' value='".$rowtk['idtypestate']."'>". $rowtk['namestate']."</option>";
							}
							
							
					
						?>
					</select>
					<select name="txtreenviar" id="txtreenviar" class="form-control form-control-sm d-none">
					<option value=""> -Select User- </option>
							<?php
						//SELECT * from fas_techsupport_typestate
						$sqlvertk = "select userfas.*, business.namebusiness,business_area_users.idarea  from userfas
inner join business_userfas
on business_userfas.iduserfas = userfas.iduserfas
inner join business
on business.idbusiness = business_userfas.idbusiness
inner join business_area_users
on business_area_users.idbusiness = business_userfas.idbusiness and
business_area_users.iduserfas = business_userfas.iduserfas
where business_userfas.active = 'true' and userfas.active = 'true' and usermobile <>'nolist' order by nameuserfas ";
							$resultk = $connect->query($sqlvertk)->fetchAll();	
							foreach ($resultk as $rowtk) {
								echo "<option value=".$rowtk['iduserfas']."#".$rowtk['usermail']."#".$rowtk['idarea']."> <i class='fas fa-user-alt'></i>".$rowtk['nameuserfas']." [".$rowtk['namebusiness']."]</option>";
							}
							
							
					
						?>
					</select>
				
					<span class="input-group-append">
                    <button type="button" onclick="savetkestatenew()" class="btn btn-block btn-outline-primary btn-sm">Save</button>
                  </span>
				  <?php 
				  
						 }
						 }
				  ?>
				  <hr>
                </div>
				<hr>
				
				
				
				
				
						
                  </div>
				  
				
						<div id="galley" class="d-none">
								  <ul class="pictures">
								  <li>
													
															<?php
					
					$sqlvertk = "select *  from fas_techsupport_fileattach	 where idfas_techsupport=".$vidtksuppor;
					$resultkatta = $connect->query($sqlvertk)->fetchAll();		
									
		
							foreach ($resultkatta as $rowtk) {
								
								$porciones = explode("_", $rowtk['namefile']);
//echo $porciones[1]; // porción1

							
									?>	
						
								<img id="imgma<?php echo $porciones[1];?>" name="imgma<?php echo $porciones[1];?>"  data-original="/uploadstk/<?php echo $porciones[1];?>" src="/uploadstk/<?php echo $porciones[1];?>" width="10%"> 
								<?php
							}
					
				
					?>
												</li>
								  </ul>
						</div>		
				  
				  <?php if ( $vvdetlog != "")
					{						
					?>
					<hr>					
						<a  data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">				
                          <b>Log Details   <a href="https://webfas.fiplex.com/logdb.php?idab=<?php echo $vvidruninfo?>" target="_blank"><i class='fas fa-eye'></i></a> </b>
                        </a>
					
					   <div class="collapse multi-collapse" id="multiCollapseExample1">
      <div class="card card-body">
        
    
	
					
					
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
				   
				   

				   
				   
				     </div>
				   
				  
					<?php 
					}
					
					?>		
					
    </div>
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
<script src="js/eModal.min.js" type="text/javascript" />

<script src="licencefiplex_mm.js"></script>
<script src="licencefiplex1.js"></script>
<script src="js/jquery.inactivityTimeout.js"></script>
<script src="js/moment-timezone-with-data.js"></script>

<script src="js/viewer.js"></script>

</body>

<script type="text/javascript">

$( document ).ready(function() {
		refresh_msj_chat($('#idtksupport').val() );
	
})

	
	      window.addEventListener('DOMContentLoaded', function () {
      var galley = document.getElementById('galley');
      var viewer = new Viewer(galley, {
        url: 'data-original',
        title: function (image) {
          return image.alt + ' (' + (this.index + 1) + '/' + this.length + ')';
        },
      });
    });
	
	
	function abrirgaleria(qimgsendclick)
{
	document.getElementById(qimgsendclick).click();
}

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

function savetkestatenew()
{
	var makesubmit=0;
	if(	$('#idestado').val()==7)
	{
		if( $('#txtreenviar').val()   =="")
		{
			makesubmit=1;
		}
		
	}
	if(	$('#idestado').val()==8)
	{
		if( $('#txtreenviar').val()   =="")
		{
			makesubmit=1;
		}
	}
	if(makesubmit==0)
	{
		
		toastr["success"]("Save OK!", "");	
		$('#uso').val(1);
		$('#frma').submit();
	}
	else
	{
		alert('you must select the user to forward');
	}
	
}

function active_cmbresend(idstate)
{
	console.log(idstate);
		$('#idestado').val(idstate);
	$('#txtreenviar').addClass('d-none');
	if (idstate == 7 )
	{
		$('#txtreenviar').removeClass('d-none');
	}
	if (idstate == 8 )
	{
		$('#txtreenviar').removeClass('d-none');
	}
}

    function openpopupframe(idtksupport)
	{
		eModal.iframe('edittksuppormarco.php?abm=n&idt='+idtksupport,'Tech Support FAS - Ticket Manager ');
	} 		
		
	function sendmsjdirect()
	{
		var makesubmitchat =0;
		if( $('#txtmsjchat').val()   =="")
		{
			makesubmitchat=1;
		}
		if(makesubmitchat==0)
			{
				/// Enviamos datos del chat!
					 return new Promise(function(resolve, reject) {
					var formData = new FormData();
			var req = new XMLHttpRequest();
			
						
			//consulta si devolvio el Scan Device
			formData.append("mshchat", $('#txtmsjchat').val() );
			formData.append("vidtksuport", $('#idtksupport').val()  );
	

			req.open("POST", "ajaxinsert_supportmsjchat.php");
			req.send(formData);
			
				req.onload = function() {
				  if (req.status == 200) {
						//resolve(JSON.parse(req.response));
						toastr["success"]("Save OK chat!", "");		
						$('#txtmsjchat').val('');
						refresh_msj_chat($('#idtksupport').val() );
				  }
				  else {
				//	reject();
							toastr["error"]("Error when storing data...", "");				
				  }
				};

			
			})
		
				
				//fin enviamos datos chat
				
			}
		
	}	
	
	function refresh_msj_chat(idtksearch)
	{
				busca_resultados_chat (idtksearch)
				
				var intervalmsjchat = setInterval(function() {	
						busca_resultados_chat (idtksearch)
				
					}, 10000);
	}
	
	function busca_resultados_chat(idtksearch)
	{
		var armando_tabla= "";
		$.ajax({
										url: 'msjchat_tksupport.php?idtk='+idtksearch,										
										 cache:false,
										success: function(respuesta) {
											
											armando_tabla=respuesta;
											
										console.log($('#lenmsjchat').val()  + '-vs'+ respuesta.length)				
											if ($('#lenmsjchat').val() < respuesta.length)
											{
												if ($('#lenmsjchat').val() >0)
												{
												toastr["info"]("new message", "");		
												}
												
											}
											$('#lenmsjchat').val(respuesta.length) 
						//console.log('abrir div'+idsnaver);
											$('#viewmshchat').html(""+armando_tabla);
												scrollToBottom('divmarcochat');		
										},
										error: function() {
											console.log("No se ha podido obtener la información");
											$('#viewmshchat').html("");
										
											
									
										}
									});
	}
	
	function scrollToBottom (id) {
   var div = document.getElementById(id);
   div.scrollTop = div.scrollHeight - div.clientHeight;
}

function scrollToTop (id) {
   var div = document.getElementById(id);
   div.scrollTop = 0;
}

//Require jQuery
function scrollSmoothToBottom (id) {
   var div = document.getElementById(id);
   $('#' + id).animate({
      scrollTop: div.scrollHeight - div.clientHeight
   }, 500);
}

//Require jQuery
function scrollSmoothToTop (id) {
   var div = document.getElementById(id);
   $('#' + id).animate({
      scrollTop: 0
   }, 500);
}
		
		
		$("#txtmsjchat").keypress(function(e) {
        if(e.which == 13) {
			toastr["success"]("Sending message", "");		
			sendmsjdirect();
        }
		
      });
	  
</script>

</html>

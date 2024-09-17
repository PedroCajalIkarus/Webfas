<?php 

	
// Desactivar toda notificación de error
error_reporting(0);
// Notificar todos los errores de PHP (ver el registro de cambios)
//error_reporting(E_ALL);
 include("db_conect.php"); 
 

			
 
 	session_start();
	    $idtk = $_REQUEST['idtk']; ///

 $Vjd=0;
 $vtemp_idruninfo=0;
 $sql="select *,  to_char(datecreate, 'DD Mon HH24:MI:SS') as datecreatef
from fas_techsupport_messages
inner join userfas
on userfas.iduserfas = fas_techsupport_messages.iduserfrom
where idfas_techsupport = ".$idtk." order by datecreate asc ";
								
?>

<?php

							   $datacabez = $connect->query($sql)->fetchAll();
								$idtempuser=0;
								$vejecucion = 1;
								  foreach ($datacabez as $rowheaders) 
								  {
									  
									  if ($idtempuser==0)
										{
											$idtempuser = $rowheaders['iduserfas'];
										}
									if ($idtempuser == $rowheaders['iduserfas'])
									{
										// mantenemos formato de chat
								
									?>
									
									<div class="direct-chat-msg">	
										<div class="direct-chat-infos clearfix">
										  <span class="direct-chat-name float-left"><?php echo $rowheaders['nameuserfas'];?></span>
										  <span class="direct-chat-timestamp float-right"><?php echo $rowheaders['datecreatef'];?></span>
										</div>
										<!-- /.direct-chat-infos -->
										
										 <?php if ( $rowheaders['userphoto']=="true")
										  {
											?>  <img src="imgusers/user<?php echo $rowheaders['iduserfas']; ?>.jpg" class="direct-chat-img" > <?php
										  }
										  else
										  {
											  ?>
											  
											  <img class="direct-chat-img" src="imgusers/0.jpg" alt="Message User <?php echo $rowheaders['nameuserfas'];?>">
											  <?php			  
										  }
										  ?>
										
										<!-- /.direct-chat-img -->
										<div class="direct-chat-text">
										<?php echo $rowheaders['messagessend'];?>
										</div>
										<!-- /.direct-chat-text -->
									</div>
									  <!-- /.direct-chat-msg -->
							  
									<?php
										}
										else
										{
										 ///Estilo respuesta de chatt
										?>
										  <!-- Message to the right -->
										  <div class="direct-chat-msg right">
											<div class="direct-chat-infos clearfix">
											  <span class="direct-chat-name float-right"><?php echo $rowheaders['nameuserfas'];?></span>
											  <span class="direct-chat-timestamp float-left"><?php echo $rowheaders['datecreatef'];?></span>
											</div>
											<!-- /.direct-chat-infos -->
											 <?php if ( $rowheaders['userphoto']=="true")
										  {
											?>  <img src="imgusers/user<?php echo $rowheaders['iduserfas']; ?>.jpg" class="direct-chat-img" > <?php
										  }
										  else
										  {
											  ?>
											  
											  <img class="direct-chat-img" src="imgusers/0.jpg" alt="Message User <?php echo $rowheaders['nameuserfas'];?>">
											  <?php			  
										  }
										  ?>
											<!-- /.direct-chat-img -->
											<div class="direct-chat-text">
												<?php echo $rowheaders['messagessend'];?>
											</div>
											<!-- /.direct-chat-text -->
										  </div>
										  <!-- /.direct-chat-msg -->
										<?php										 
										}
										
									
								
									}
									
									
								  
					
		?>
								

							
			
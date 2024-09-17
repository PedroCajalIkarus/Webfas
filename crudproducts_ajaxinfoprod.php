<?php
	include("db_conect.php"); 


 ?>
									
	   
	   <br><br>
	   <b>Firmware versions : </b>
														   <table class="table table-striped table-bordered table-sm table-responsive" name="exampledin<?php echo str_replace("a","",$_REQUEST['p0']); ?>" id="exampledin<?php echo str_replace("a","",$_REQUEST['p0']); ?>">
															 <thead>
															   <tr>
																 <th class="bg-primary">Datetime</th>
															   
																 <th class="bg-primary">Rev</th>
															   
																
																<th class="bg-primary">Fpga FAS</th>
																<th class="bg-primary">uC FAS</th>
																	  <th class="bg-primary">Eth FAS</th>
																	   <th class="bg-primary">Fpga Filename</th>															  
																 <th class="bg-primary">uC Filename</th>															  
																  <th class="bg-primary">Eth Filename</th>
																
															   </tr>
															 </thead>
															 <tbody>
														   <?php

														   $sql = $connect->prepare("
														   select fas_confidential_fw.*
														   from fas_confidential_fw
														   
														   where idciu = ".str_replace("a","",$_REQUEST['p0'])." order by idrevfw desc ");
														   
															   $sql->execute();
														   $sql->execute();
														   $resultado3 = $sql->fetchAll();
														   $cantdenegritas=0;
														   $classnegrita="";
													   
														   $indxtablaadd =0;
														   $indparamaxregxrma = 0;
													   //	echo "Holaaaaaaaaaaa".$marcar_ultimo ;
														   foreach ($resultado3 as $row2) 
														   {

																	
														?>
														
														<tr>
														 
														 <td class="<?php echo  $classnegrita; ?>"><?php echo   substr ($row2['datelastmodif'],0,19); ?></b></td> 
														 <td class="<?php echo  $classnegrita; ?>"><?php echo   $row2['idrevfw']; ?></b></td> 
												   
													   <td class="<?php echo  $classnegrita; ?>">
													   
													   <?php echo  $row2['fpga_fas']; ?>
												 
													   
													   
													   <?php //echo  $row2['fpga_fas']; ?></td>
													   <td class="<?php echo  $classnegrita; ?>"> 
													   	<?php echo  $row2['micro_fas']; ?>
														 
																   
													   <?php // echo  $row2['micro_fas']; ?></td>
													   <td class="<?php echo  $classnegrita; ?>">
													   <?php echo  $row2['eth_fas']; ?>														  
													   
													   <?php // echo  $row2['eth_fas']; ?></td>
													   <td class="<?php echo  $classnegrita; ?>">																						
													   <?php echo  $row2['fpgafilename']; ?>														  
													   </td>  											  
													   
													   <td class="<?php echo  $classnegrita; ?>">
													   <?php echo  $row2['microfilename']; ?>
														   </td>
													   
													   <td class="<?php echo  $classnegrita; ?>">

													   <?php echo  $row2['ethfilename']; ?>
														
																   </td>
													   
													   
												   
							   
													   
														<?php


														   }
														 ?>
																   																							
																					 
																   
																						   
																								
																   
																						   
																																					
															 </tbody>
														   </table>
														   <script>
															 $('#exampledin<?php  echo str_replace("a","",$_REQUEST['p0']); ?>').DataTable( {
																			   "order": [[ 0, "desc" ]]
																		   } );
																		   
															   console.log(' fin#exampledin<?php echo trim($row2['idbandgroup']); ?>')		;	
														   </script>
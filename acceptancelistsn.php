<?php 

	
// Desactivar toda notificación de error
error_reporting(0);
// Notificar todos los errores de PHP (ver el registro de cambios)
//error_reporting(E_ALL);
 include("db_conect.php"); 
 

			
 
 	session_start();
	    $vparam_ciu = $_REQUEST['pciu']; ///

?>


	
<table id="fliproduct" class="table table-sm table-striped">
                    <thead>
                    <tr>
						<th>Date Time</th>   
						<th>SN</th>                  
                                      
						               
						<th>Calibrator</th>                  
						<th>View Log</th>   
						 <th>Total Pass</th>   
						<th>Tk Support</th>   
					
                    </tr>
                    </thead>
                    <tbody>					
					<?php 
							$elmaxruninfoafiltrar = ($_SESSION["i"]* 10000000000);
							$elmaxruninfoafiltrarhasta = (($_SESSION["i"]+1)* 10000000000);
							
						if ($vparam_ciu =="FIP446")	
						{

												
							if 	($_SESSION["g"] == "develop" ) 
							{
								$sql = $connect->prepare("select  distinct 'FIP446' as ciu,fas_calibration_result.*, runinfodb.userruninfo, runinfodb.dateinfom, fas_calibration_result.totalpass::int as totalpassconvert, dateserver
								from fas_tree_measure
								inner join fas_calibration_result
								on fas_calibration_result.unitsn = fas_tree_measure.unitsn and
								modelciu = 'FIP446'
								inner join runinfodb
								on runinfodb.idruninfodb = fas_calibration_result.idruninfo
								where iduniquebranch ='00E' order by dateinfom desc ");
								}
								else
								{
								$elmaxruninfoafiltrar = ($_SESSION["i"]* 10000000000);
								$elmaxruninfoafiltrarhasta = (($_SESSION["i"]+1)* 10000000000);

								$sql = $connect->prepare("select  distinct 'FIP446' as ciu,fas_calibration_result.*, runinfodb.userruninfo, runinfodb.dateinfom, fas_calibration_result.totalpass::int as totalpassconvert, dateserver
								from fas_tree_measure
								inner join fas_calibration_result
								on fas_calibration_result.unitsn = fas_tree_measure.unitsn and
								modelciu = 'FIP446'
								inner join runinfodb
								on runinfodb.idruninfodb = fas_calibration_result.idruninfo
								where iduniquebranch ='00E' and idruninfodb >=".$elmaxruninfoafiltrar." and  idruninfodb <=".$elmaxruninfoafiltrarhasta."  order by dateinfom desc ");
									
								}
							
													$sql->execute();
													$resultado3 = $sql->fetchAll();
													foreach ($resultado3 as $row2) 
													{
														
													?>
													
													<tr>
													<td><?php echo  $row2['dateinfom']; ?></td>    
													<td><a href="#" onclick="openpopupframe2('<?php echo  $row2['unitsn']; ?>')" ><?php echo  $row2['unitsn']; ?> <i class='fas fa-search-plus'></i></a>
													<a href="#" onclick="Call_printlabel_todos('<?php echo  $row2['ciu']; ?>','','<?php echo  $row2['unitsn']; ?>')">&nbsp;<i class="fas fa-tasks"></i>&nbsp;<i class="fas fa-print"></i></a>
													</td>                    
													<td><?php echo  $row2['userruninfo']; ?></td>
													<td><a href="logdb.php?idab=<?php echo  $row2['idruninfo']; ?>" target="_blank"> <?php echo  $row2['idruninfo']; ?> <i class='far fa-eye'></i></a></td>
													<?php
													if ($row2['totalpassconvert'] =="0")
															{
																	echo "<td align='center'><span class='badge badge-pill badge-danger'>Not Passed </span></td>";
															}
															else
															{	
																
																		echo "<td align='center'><span class='badge badge-pill badge-success'>Passed</span></td>";
																}
										?>
													
													
																	
													
													
													<td><a href="#" data-info="FIP446#00000001MM" onclick="callsupportit(1, '<?php echo $row2['ciu']."#".$row2['unitsn']; ?>')" style="color:#0053a1;font-size: 12px;" )=""> <i class="fas fa-question-circle"></i>&nbsp;Require Support</a></td> 
													
													</tr>
							
													
													<?php
													}
															
															?>
								
						<?php 
									}

									if ($vparam_ciu =="FIP467")	
									{
			
															
										if 	($_SESSION["g"] == "develop" ) 
										{
											$sql = $connect->prepare("select  distinct 'FIP467' as ciu,fas_calibration_result.*, runinfodb.userruninfo, runinfodb.dateinfom, fas_calibration_result.totalpass::int as totalpassconvert, dateserver
											from fas_tree_measure
											inner join fas_calibration_result
											on fas_calibration_result.unitsn = fas_tree_measure.unitsn and
											modelciu = 'FIP467'
											inner join runinfodb
											on runinfodb.idruninfodb = fas_calibration_result.idruninfo
											where iduniquebranch ='00E' order by dateinfom desc ");
											}
											else
											{
											$elmaxruninfoafiltrar = ($_SESSION["i"]* 10000000000);
											$elmaxruninfoafiltrarhasta = (($_SESSION["i"]+1)* 10000000000);
			
											$sql = $connect->prepare("select  distinct 'FIP467' as ciu,fas_calibration_result.*, runinfodb.userruninfo, runinfodb.dateinfom, fas_calibration_result.totalpass::int as totalpassconvert, dateserver
											from fas_tree_measure
											inner join fas_calibration_result
											on fas_calibration_result.unitsn = fas_tree_measure.unitsn and
											modelciu = 'FIP467'
											inner join runinfodb
											on runinfodb.idruninfodb = fas_calibration_result.idruninfo
											where iduniquebranch ='00E' and idruninfodb >=".$elmaxruninfoafiltrar." and  idruninfodb <=".$elmaxruninfoafiltrarhasta."  order by dateinfom desc ");
												
											}
										
																$sql->execute();
																$resultado3 = $sql->fetchAll();
																foreach ($resultado3 as $row2) 
																{
																	
																?>
																
																<tr>
																<td><?php echo  $row2['dateinfom']; ?></td>    
																<td><a href="#" onclick="openpopupframe2('<?php echo  $row2['unitsn']; ?>')" ><?php echo  $row2['unitsn']; ?> <i class='fas fa-search-plus'></i></a>
																<a href="#" onclick="Call_printlabel_todos('<?php echo  $row2['ciu']; ?>','','<?php echo  $row2['unitsn']; ?>')">&nbsp; &nbsp;<i class="fas fa-print"></i></a>
																</td>                    
																<td><?php echo  $row2['userruninfo']; ?></td>
																<td><a href="logdb.php?idab=<?php echo  $row2['idruninfo']; ?>" target="_blank"> <?php echo  $row2['idruninfo']; ?> <i class='far fa-eye'></i></a></td>
																<?php
																if ($row2['totalpassconvert'] =="0")
																		{
																				echo "<td align='center'><span class='badge badge-pill badge-danger'>Not Passed </span></td>";
																		}
																		else
																		{	
																			
																					echo "<td align='center'><span class='badge badge-pill badge-success'>Passed</span></td>";
																			}
													?>
																
																
																				
																
																
																<td><a href="#" data-info="FIPFIP467#00000001MM" onclick="callsupportit(1, '<?php echo $row2['ciu']."#".$row2['unitsn']; ?>')" style="color:#0053a1;font-size: 12px;" )=""> <i class="fas fa-question-circle"></i>&nbsp;Require Support</a></td> 
																
																</tr>
										
																
																<?php
																}
																		
																		?>
											
									<?php 
												}

							if ($vparam_ciu =="FIP488")	
							{			
							$elmaxruninfoafiltrar = ($_SESSION["i"]* 10000000000);
							$elmaxruninfoafiltrarhasta = (($_SESSION["i"]+1)* 10000000000);
							
							////////////////////////////////////////////////////////////////////
							//////////////////////// FIP488 ////////////////////////////////////////////
							////////////////////////////////////////////////////////////////////
									if 	($_SESSION["g"] == "develop" ) 
									{
													$sql = $connect->prepare("select  distinct 'FIP488' as ciu,fas_calibration_result.*, runinfodb.userruninfo, runinfodb.dateinfom, fas_calibration_result.totalpass::int as totalpassconvert, dateserver
											from fas_tree_measure
											inner join fas_calibration_result
											on fas_calibration_result.unitsn = fas_tree_measure.unitsn and
											modelciu = 'FIP488'
											inner join runinfodb
											on runinfodb.idruninfodb = fas_calibration_result.idruninfo
											where iduniquebranch ='00E' order by dateinfom desc ");
									}
									else
									{
											$elmaxruninfoafiltrar = ($_SESSION["i"]* 10000000000);
										$elmaxruninfoafiltrarhasta = (($_SESSION["i"]+1)* 10000000000);
										
										$sql = $connect->prepare("select  distinct 'FIP488' as ciu,fas_calibration_result.*, runinfodb.userruninfo, runinfodb.dateinfom, fas_calibration_result.totalpass::int as totalpassconvert, dateserver
										from fas_tree_measure
										inner join fas_calibration_result
										on fas_calibration_result.unitsn = fas_tree_measure.unitsn and
										modelciu = 'FIP488'
										inner join runinfodb
										on runinfodb.idruninfodb = fas_calibration_result.idruninfo
										where iduniquebranch ='00E' and idruninfodb >=".$elmaxruninfoafiltrar." and  idruninfodb <=".$elmaxruninfoafiltrarhasta."  order by dateinfom desc ");
										
									}
	 
											$sql->execute();
											$resultado3 = $sql->fetchAll();
											foreach ($resultado3 as $row2) 
											 {
												
											 ?>
											 
											 <tr>
											   <td><?php echo  $row2['dateinfom']; ?></td>    
											  <td><a href="#" onclick="openpopupframe448('<?php echo  $row2['unitsn']; ?>')" ><?php echo  $row2['unitsn']; ?> <i class='fas fa-search-plus'></i></a>
											  <a href="#" onclick="Call_printlabel_todos('<?php echo  $row2['ciu']; ?>','','<?php echo  $row2['unitsn']; ?>')">&nbsp;&nbsp;<i class="fas fa-print"></i></a>
											  </td>                    
											  <td><?php echo  $row2['userruninfo']; ?></td>
											  <td><a href="logdb.php?idab=<?php echo  $row2['idruninfo']; ?>" target="_blank"> <?php echo  $row2['idruninfo']; ?> <i class='far fa-eye'></i></a></td>
											  <?php
											  if ($row2['totalpassconvert'] =="0")
													{
															echo "<td align='center'><span class='badge badge-pill badge-danger'>Not Passed </span></td>";
													}
													else
													{	
														
																echo "<td align='center'><span class='badge badge-pill badge-success'>Passed</span></td>";
														}
								?>
											  
											 
											                
											 
											  
											 <td><a href="#" data-info="FIP488#00000000" onclick="callsupportit(1, '<?php echo $row2['ciu']."#".$row2['unitsn']; ?>')" style="color:#0053a1;font-size: 12px;" )=""> <i class="fas fa-question-circle"></i>&nbsp;Require Support</a></td> 
											
											</tr>
					
											
											 <?php
											 }
						}
									
									?>

					
                    
                  
                    </tbody>
                  </table>
			
<script>

// variable can be an initialized DataTable, string (selector), or jQuery object...
var table = $('#fliproduct').DataTable(); 

table.destroy();

 
 $('#fliproduct').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,   
	   "order": [[ 0, "desc" ]],
      "info": true,
      "autoWidth": false,
    });
</script>	
			
			
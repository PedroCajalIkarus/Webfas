<?php


	include("db_conect.php"); 
																
																 $sql = $connect->prepare("select * 
 from products_branch 
 inner join products_branch_fw
 on products_branch_fw.idproductsbranch = products_branch.idproductsbranch
 inner join products_branch_tree
 on products_branch_tree.idprodbranchson = products_branch.idproductsbranch
 where iduniquebranchprodson= '".str_replace("a","",$_REQUEST['p0'])."'  order by idrev asc  ");
 
 	$sql->execute();
																						$resultado3 = $sql->fetchAll();
																						$cantdenegritas=0;
																						$classnegrita="";
																						$marcar_ultimo = count($resultado3);

?>	
	
	<b>Firmware versions</b>
														<table class="table table-striped table-bordered table-sm" name="example1" id="example1">
														  <thead>
															<tr>
															  <th class="bg-primary">Datetime</th>
															
														
															
															 
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
																
											
 
															
															$vvfpga_file = ""; 
															$vvfpga_fas = "";
															$vvmicro_file =  ""; 
															$vvmicro_fas =  ""; 
															$vveth_file = "";
															$vveth_fas =""; 
															$vvvcalstring =""; 															
															
															$vvfpga_file_temp = "";
															$vvfpga_fas_temp = "";
															$vvmicro_file_temp =  "";
															$vvmicro_fas_temp =  "";
															$vveth_file_temp = "";
															$vveth_fas_temp ="";
															$vvvcalstring_temp ="";													
															
															$class_colorvvfpga_file="";		
															$class_colorvvfpga_fas="";
															$class_colorvvmicro_file="";
															$class_colorvvmicro_fas="";
															$class_colorvveth_file="";
															 $class_colorvveth_fas="";
															
																								$entro="N";								 
																					$sql->execute();
																						$resultado3 = $sql->fetchAll();
																						$cantdenegritas=0;
																						$classnegrita="";
																						$marcar_ultimo = count($resultado3);
																					//	echo "Holaaaaaaaaaaa".$marcar_ultimo ;
																						foreach ($resultado3 as $row2) 
																						 {
																							 $class_colorvvfpga_file="";		
																							$class_colorvvfpga_fas="";
																							$class_colorvvmicro_file="";
																							$class_colorvvmicro_fas="";
																							$class_colorvveth_file="";
																							 $class_colorvveth_fas="";
																							 if ($vvfpga_file_temp =="")
																							 {
																									$vvfpga_file_temp = trim($row2['fpga_file']); 
																							$vvfpga_fas_temp = trim($row2['fpga_fas']);
																							$vvmicro_file_temp =  trim($row2['micro_file']); 
																							$vvmicro_fas_temp =  trim($row2['micro_fas']); 
																							$vveth_file_temp = trim($row2['eth_file']);
																							$vveth_fas_temp =trim($row2['eth_fas']); 
																						//	$vvvcalstring_temp =trim($row2['calrstring']);  
																							 }
																							 ///control para marcar los cambios
																							if ( $vvfpga_file_temp <> trim($row2['fpga_file']) ) { $class_colorvvfpga_file="text-danger"; }
																							if ( $vvfpga_fas_temp <> trim($row2['fpga_fas']) ) { $class_colorvvfpga_fas="text-danger"; }
																							if ( $vvmicro_file_temp <> trim($row2['micro_file']) ) { $class_colorvvmicro_file="text-danger"; }
																							if ( $vvmicro_fas_temp <> trim($row2['micro_fas']) ) { $class_colorvvmicro_fas="text-danger"; }
																							if ( $vveth_file_temp <> trim($row2['eth_file']) ) { $class_colorvveth_file="text-danger"; }
																							if ( $vveth_fas_temp <> trim($row2['eth_fas']) ) { $class_colorvveth_fas="text-danger"; }
																							
																							$vvfpga_file_temp = trim($row2['fpga_file']); 
																							$vvfpga_fas_temp = trim($row2['fpga_fas']);
																							$vvmicro_file_temp =  trim($row2['micro_file']); 
																							$vvmicro_fas_temp =  trim($row2['micro_fas']); 
																							$vveth_file_temp = trim($row2['eth_file']);
																							$vveth_fas_temp =trim($row2['eth_fas']); 
																						//	$vvvcalstring_temp =trim($row2['calrstring']); 
																							 
																							 
																							 
																							  $cantdenegritas= $cantdenegritas + 1;
																							 
																							 if($cantdenegritas==$marcar_ultimo)
																							 {
																								 $classnegrita="table-success clasenegrita";
																							 }
																							 else
																							 {
																								 $classnegrita="";
																							 }	 
																							 $vvidproductsbranch = $row2['idproductsbranch']; 
																							 if($entro=="N"	)
																							 {
																							$vvfpga_file = trim($row2['fpga_file']); 
																							$vvfpga_fas = trim($row2['fpga_fas']);
																							$vvmicro_file =  trim($row2['micro_file']); 
																							$vvmicro_fas =  trim($row2['micro_fas']); 
																							$vveth_file = trim($row2['eth_file']);
																							$vveth_fas =trim($row2['eth_fas']); 
																						//	$vvvcalstring =trim($row2['calrstring']); 
																							 }
																							 
																								$entro="S";			
																						 ?>
																						 
																						 <tr>
																						  
																						  <td class="<?php echo  $classnegrita; ?>"><?php echo   substr ($row2['datetimemodif'],0,19); ?></b></td> 
																					
																						<td class="<?php echo  $classnegrita; ?>">
																						
																						<a href="#" class="tooltipmarcolink<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']." ".$class_colorvvfpga_fas; ?>"  onmouseout="ocultar_tooltip('<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']; ?>')" onmouseover="mostrar_tooltip('<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']; ?>')" ><?php echo  $row2['fpga_fas']; ?></a>
																									<div id="tooltipfreq<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']; ?>" name="tooltipfreq<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']; ?>" class='d-none tooltipmarco text-left texto9' role='tooltip'>  <?php echo  $row2['fpga_description']; ?> </div>
																						
																						
																						
																						<?php //echo  $row2['fpga_fas']; ?></td>
																						<td class="<?php echo  $classnegrita; ?>"> 
																						<a href="#" class="tooltipmarcolink<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."uc"." ".$class_colorvvmicro_fas; ?>"  onmouseout="ocultar_tooltip('<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."uc"; ?>')" onmouseover="mostrar_tooltip('<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."uc"; ?>')" ><?php echo  $row2['micro_fas']; ?></a>
																									<div id="tooltipfreq<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."uc"; ?>" name="tooltipfreq<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."uc"; ?>" class='d-none tooltipmarco text-left texto9' role='tooltip'>  <?php echo  $row2['uc_description']; ?> </div>
																									
																						<?php // echo  $row2['micro_fas']; ?></td>
																						<td class="<?php echo  $classnegrita; ?>">
																						<a href="#" class="tooltipmarcolink<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."eth"." ".$class_colorvveth_fas; ?>"  onmouseout="ocultar_tooltip('<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."eth"; ?>')" onmouseover="mostrar_tooltip('<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."eth"; ?>')" ><?php echo  $row2['eth_fas']; ?></a>
																									<div id="tooltipfreq<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."eth"; ?>" name="tooltipfreq<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."eth"; ?>" class='d-none tooltipmarco text-left texto9' role='tooltip'> <?php echo  $row2['eht_description']; ?> </div>
																						
																						<?php // echo  $row2['eth_fas']; ?></td>
																						<td class="<?php echo  $classnegrita; ?>">																						
																						<a href="#" class="tooltipmarcolink<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']." ".$class_colorvvfpga_file; ?>"  onmouseout="ocultar_tooltip('<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']; ?>')" onmouseover="mostrar_tooltip('<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']; ?>')" ><?php echo  $row2['fpga_file']; ?></a>
																									<div id="tooltipfreq<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']; ?>" name="tooltipfreq<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']; ?>" class='d-none tooltipmarco text-left texto9' role='tooltip'>  <?php echo  $row2['fpga_description']; ?> </div>
																						</td>  											  
																						
																						<td class="<?php echo  $classnegrita; ?>">
																						<a href="#" class="tooltipmarcolink<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."uc"." ".$class_colorvvmicro_file; ?>"  onmouseout="ocultar_tooltip('<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."uc"; ?>')" onmouseover="mostrar_tooltip('<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."uc"; ?>')" ><?php echo  $row2['micro_file']; ?></a>
																									<div id="tooltipfreq<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."uc"; ?>" name="tooltipfreq<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."uc"; ?>" class='d-none tooltipmarco text-left texto9' role='tooltip'>  <?php echo  $row2['uc_description']; ?> </div>
																									</td>
																						
																						<td class="<?php echo  $classnegrita; ?>">
																						<a href="#" class="tooltipmarcolink<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."eth"." ".$class_colorvveth_file; ?>"  onmouseout="ocultar_tooltip('<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."eth"; ?>')" onmouseover="mostrar_tooltip('<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."eth"; ?>')" ><?php echo  $row2['eth_file']; ?></a>
																									<div id="tooltipfreq<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."eth"; ?>" name="tooltipfreq<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."eth"; ?>" class='d-none tooltipmarco text-left texto9' role='tooltip'> <?php echo  $row2['eht_description']; ?> </div>
																									</td>
																						
																						
																					
																
																						
																						 <?php
																							
																						 } 
																						 
																						 if ($entro=="N")
																						 {
																							 ?>
																							 <tr>
																								<td colspan=7 class="text-center"> No associated Fw found.
																								</td>
																							 </tr>
																							 <?php
																						 }
																						 ?>	
																
																						
																						 														
														  </tbody>
														</table>
														
														<!--start load firmware -->
														<div class="container-fluid" id="divaddfirmware" name="divaddfirmware">		

												<p>
												  <a class="btn btn-block btn-outline-primary btn-xs" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
														<label class="colorazulfiplex"><b>Add Firmware:</b> </label>	
												  </a>
												
												  </button>
												</p>
												<div class="collapse" id="collapseExample">
												  <div class="card card-body">
													
													
													
														<div class="row " id="firmwarestand" name="firmwarestand">	
															<div class="form-group col-md-4">
															
															<label for="exampleInputEmail1">FPGA FAS:</label>
																	<input type="text" name="txtfpgafwadd"  id="txtfpgafwadd" class="form-control form-control-sm" placeholder="FPGA version " required="" oninvalid="setCustomValidity('FPGA Number is required.')" oninput="setCustomValidity('')" value="<?php echo $vvfpga_fas;?>">	
															</div>
															<div class="form-group col-md-4">
																
																<label for="exampleInputEmail1">uC FAS:</label>
																	<input type="text" name="txtucfwadd"  id="txtucfwadd" class="form-control form-control-sm" placeholder="uC version" required="" oninvalid="setCustomValidity('uC Number is required.')" oninput="setCustomValidity('')" value="<?php echo $vvmicro_fas;?>">	
																
															</div>
															
															
																
																							
															<div class="form-group col-md-4">
															
															<label for="exampleInputEmail1">Ethernet FAS:</label>
																	<input type="text" name="txtetherfasfwadd"  id="txtetherfasfwadd" class="form-control form-control-sm" placeholder="Eth version " required="" oninvalid="setCustomValidity('Eth Number is required.')" oninput="setCustomValidity('')" value="<?php echo $vveth_fas;?>">	
															</div>
															
														</div>
														<div class="row" id="firmwarecustom" name="firmwarecustom">	
															<div class="form-group col-md-4">
															
															<label for="exampleInputEmail1">FPGA File Name:</label>
																	<input type="text" name="txtfpgafasfwadd"  id="txtfpgafasfwadd" class="form-control form-control-sm" placeholder="FPGA File Name Custom" required="" oninvalid="setCustomValidity('FPGA is required Custom.')" oninput="setCustomValidity('')" value="<?php echo $vvfpga_file;?>">	
															</div>
															<div class="form-group col-md-4">
																
																<label for="exampleInputEmail1">Uc File Name :</label>
																	<input type="text" name="txtucfasfwadd"  id="txtucfasfwadd" class="form-control form-control-sm" placeholder="Uc File Name Custom" required="" oninvalid="setCustomValidity(uC is required Custom.')" oninput="setCustomValidity('')" value="<?php echo $vvmicro_file;?>">	
																
															</div>
															<div class="form-group col-md-4">
															
															<label for="exampleInputEmail1">Ethernet File Name:</label>
																	<input type="text" name="txtetherfwadd"  id="txtetherfwadd" class="form-control form-control-sm" placeholder="Ethernet File Name Custom" required="" oninvalid="setCustomValidity('Ether is required Custom.')" oninput="setCustomValidity('')" value="<?php echo $vveth_file;?>">	
															</div>
														
														</div>
														<div class="row" id="firmwarecustom" name="firmwarecustom">	
															<div class="form-group col-md-4">
															
															<label for="exampleInputEmail1">FPGA Upgrade Description:</label>
																	<input type="text" name="txtfpgacusdescripupg"  id="txtfpgacusdescripupg" class="form-control form-control-sm" placeholder="FPGA upgrade description" required="" oninvalid="setCustomValidity('FPGA is required Custom.')" oninput="setCustomValidity('')" value="">	
															</div>
															<div class="form-group col-md-4">
																
																<label for="exampleInputEmail1">Uc Upgrade Description:</label>
																	<input type="text" name="txtuccusdescripupg"  id="txtuccusdescripupg" class="form-control form-control-sm" placeholder="Uc upgrade description" required="" oninvalid="setCustomValidity(uC is required Custom.')" oninput="setCustomValidity('')" value="">	
																
															</div>
															<div class="form-group col-md-4">
															
															<label for="exampleInputEmail1">Ethernet Upgrade Description:</label>
																	<input type="text" name="txtethercusdescripupg"  id="txtethercusdescripupg" class="form-control form-control-sm" placeholder="Ethernet upgrade description" required="" oninvalid="setCustomValidity('Ether is required Custom.')" oninput="setCustomValidity('')" value="">	
															</div>
													<!--		<div class="form-group col-md-12 ">
															<label for="exampleInputEmail1">Cal String  :</label>
									<input type="text" name="calstringfw" id="calstringfw" class="form-control " placeholder="Enter Cal String" required oninvalid="setCustomValidity('FPGA is required.')" 
                   oninput="setCustomValidity('')" value="<?php // echo $vvvcalstring;?>">
																
															</div>-->
															
																<div class="form-group col-md-12 ">
																<input type="hidden" name="idramon" id="idramon" value="<?php echo  $_REQUEST['p0']."#".$vvidproductsbranch; ?>">
																<button name="btnaddband" id="btnaddband" type="button" class="btn btn-smk btn-block btn-outline-primary btn-flat btn-sm" onclick="save_add_registro_type_fw()">Upgrade Firmware</button>
																
																
															</div>
													
												  </div>
												</div>


															
														</div>
															</div>
															<!--end load firmware -->
														<br>
														
														<?php if ($cantdenegritas>1)
														{
														
														?>
														<script>
														  $('#example1').DataTable( {
																			"order": [[ 0, "desc" ]]
																		} );
														</script>
														<?php
														} ?>
														
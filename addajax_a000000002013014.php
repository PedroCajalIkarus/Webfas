
<?php 

// Desactivar toda notificación de error
error_reporting(0);
// Notificar todos los errores de PHP (ver el registro de cambios)
//error_reporting(E_ALL);
 include("db_conect.php"); 
 
	 session_start();
	 
	 ?>
					 <div class="card">
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
										<div class="col-sm-6" id="divtipomod" name="divtipomod">
										  <div class="form-group">
											<label>Type Module :</label>
													<select class="form-control form-control-sm" onChange="primerpaso(this.value)" name="txtmodiftypemodule" id="txtmodiftypemodule" required oninvalid="setCustomValidity('Business is required.')" oninput="setCustomValidity('')">
												 <option value=""> - Select - </option>
												 <option value="DIGBOARDFLEX" selected >DIB FLEX</option>
												
											
											    
											  </select>
										  </div>
										</div>
							</div>
									
									  
									  
									  
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
											 <?php echo  $row2['description']."  [".$row2['fstartul']."-".$row2['fstopul']." / ".$row2['fstartdl']."-".$row2['fstopdl']."]"; ?>
											 </option>
											 <?php
											 }
											
											?>
										</select>	
									</div>	
									<div class="form-group col-md-6 ">
										<label for="exampleInputEmail1"></label>
									 		<select class="form-control d-none " name="txttypeclass" id="txttypeclass" required oninvalid="setCustomValidity('Class is required.')" oninput="setCustomValidity('')">
											   <option value="-" selected> - Select - </option>
										
											
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
			<?php 

					

					$sql = $connect->prepare("SELECT distinct bandgroups.namegroup, fpga_file, micro_file, eth_file, fpga_fas, micro_fas, eth_fas 
					FROM products_branch_fw
					inner join bandgroups
																on bandgroups.idbandgroup =  products_branch_fw.idbandgroup and 
																bandgroups.idband <> 5
					inner join
					(
					SELECT idproductsbranch, max(idrev) as maxidrev FROM products_branch_fw WHERE idunquebranchfather = '000000002013014' group by idproductsbranch
					) as maxidrevxbranch
					on maxidrevxbranch.idproductsbranch = products_branch_fw.idproductsbranch and
					maxidrevxbranch.maxidrev = products_branch_fw.idrev
					WHERE  idunquebranchfather = '000000002013014' limit 2 "  );
						
				

				?>
							
			<div class="container-fluid" id="divfasfw" name="divfasfw">					  
									 <hr>	
						<span class="colorazulfiplex"><b>Firmware Specs:</b> </span>	<br><br>
							<div class="row">
							
							
										<div class="form-group col-md-12">
										
										<label for="exampleInputEmail1">Firmware Type:</label>
									 			<select class="form-control" onClick="habilitarfirmware(this.value)" onchange="mostrarfwselectr(this.value)" name="txttypeclass" id="txttypeclass" required oninvalid="setCustomValidity('Class is required.')" oninput="setCustomValidity('')">
										
												 <option value=""> -Select -</option> 
											<?php
											
											$sql->execute();
											$resultado3 = $sql->fetchAll();
											foreach ($resultado3 as $rowfw) 
											{
											/*	$vfpga_file = trim($rowfw['fpga_file']); 
												$vmicro_file = trim($rowfw['micro_file']); 
												$veth_file = trim($rowfw['eth_file']); 
						
												$vfpga_file_fas = $rowfw['fpga_fas']; 
												$vmicro_file_fas = $rowfw['micro_fas']; 
												$veth_file_fas = $rowfw['eth_fas']; 
*/
												
											
											?>
											 <option value="<?php echo 	trim($rowfw['namegroup'])."#".trim($rowfw['fpga_file'])."#".trim($rowfw['micro_file'])."#".trim($rowfw['eth_file'])."#".trim($rowfw['fpga_fas'])."#".trim($rowfw['micro_fas'])."#".trim($rowfw['eth_fas']); ?>">  <?php echo 	trim($rowfw['namegroup']) ; ?> [Standard]</option>
											 
											 
											  <?php
											
											}
											
											?>
 <option value="firmwarecustom"> Custom</option> 
										</select>	
								
									</div>	
										</div>	
								<div class="row " id="firmwarestand" name="firmwarestand" >	
									<div class="form-group col-md-4">
									
									<label for="exampleInputEmail1">FPGA:</label>
									 		<input type="text" name="txtfpga" disabled id="txtfpga" class="form-control" placeholder="FPGA version " required oninvalid="setCustomValidity('ETL Number is required.')" 
                   oninput="setCustomValidity('')" value="<?php echo $vfpga_file_fas; ?>">	
									</div>
									<div class="form-group col-md-4">
										
										<label for="exampleInputEmail1">uC :</label>
									 		<input type="text" name="txtuc" disabled id="txtuc" class="form-control" placeholder="uC version" required oninvalid="setCustomValidity('ETL Number is required.')" 
                   oninput="setCustomValidity('')" value="<?php echo $vmicro_file_fas; ?>">	
										
									</div>
									<div class="form-group col-md-4">
									
									<label for="exampleInputEmail1">Ethernet:</label>
									 		<input type="text" name="txtether" disabled id="txtether" class="form-control" placeholder="Eth version " required oninvalid="setCustomValidity('ETL Number is required.')" 
                   oninput="setCustomValidity('')" value="<?php echo $veth_file_fas; ?>">	
									</div>
									
								</div>
								<div class="row" id="firmwarecustom" name="firmwarecustom" >	
									<div class="form-group col-md-4">
									
									<label for="exampleInputEmail1">FPGA File Name:</label>
									 		<input type="text" name="txtfpgacus" disabled id="txtfpgacus" class="form-control" placeholder="FPGA File Name Custom" required oninvalid="setCustomValidity('ETL Number is required Custom.')" 
                   oninput="setCustomValidity('')" value="<?php echo $vfpga_file; ?>">	
									</div>
									<div class="form-group col-md-4">
										
										<label for="exampleInputEmail1">Uc File Name :</label>
									 		<input type="text" name="txtuccus" disabled id="txtuccus" class="form-control" placeholder="Uc File Name Custom" required oninvalid="setCustomValidity('ETL Number is required Custom.')" 
                   oninput="setCustomValidity('')" value="<?php echo $vmicro_file; ?>">	
										
									</div>
									<div class="form-group col-md-4">
									
									<label for="exampleInputEmail1">Ethernet File Name:</label>
									 		<input type="text" name="txtethercus" disabled id="txtethercus" class="form-control" placeholder="Ethernet File Name Custom" required oninvalid="setCustomValidity('ETL Number is required Custom.')" 
                   oninput="setCustomValidity('')" value="<?php echo $veth_file ?>">	
									</div>
									<div class="form-group col-md-3">
										
										
										
									</div>
								</div>
					   </div>			
						<!-- fin de FW --->		


					
					
							<!-- inicio de fas instruments parameters --->						  
				  	<div class="container-fluid" id="divfasinstrumetsparameters" name="divfasinstrumetsparameters">					  
									 <hr>	
						<span class="colorazulfiplex"><b>Accept Script Specs:</b> </span>	<br><br>
								
														
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
												<th>Gain Tolerance</th>												
												<th>Quantity measures</th>												
												</tr>
												
												
											<?php
											
											  $sql = $connect->prepare("		select fas_steppp.treetype , fas_tree.*  , fas_steppp.description as namefasstepfather 
											  , fas_stephh.description as nameidfasstepson
											  from 	fas_tree
											  inner join fas_step as fas_steppp
											  on fas_tree.idfasstepfather  = fas_steppp.idfasstep
											  inner join fas_step as fas_stephh
											  on fas_tree.idfastrepson  = fas_stephh.idfasstep
											  where fas_tree.idfastree = 1031 ");
	 
											$sql->execute();
											$resultado3 = $sql->fetchAll();
											foreach ($resultado3 as $row2) 
											 {
												if ($row2['treetype']=='head')
												{
													?><tr class="d-none"> <?php
												}
												else
												{
													?><tr > <?php
												}
											 ?>
											
											
												<td css="text-left">
												
												<div class="custom-control custom-switch custom-switch-on-success custom-switch-off-danger">                                               
											  <input type="checkbox" class="custom-control-input custom-control-inputmm" value="<?php echo  $row2['idfastree']."#".$row2['idfasstepfather']."#".$row2['idfastrepson']."#".$row2['iduniquebranch']."*";?>"    id="customSwitch<?php echo   $row2['idfasstep'].$row2['idfasstepfather'].$row2['idfastrepson'];?>" checked>
											  <label class="custom-control-label" for="customSwitch<?php echo  $row2['idfasstep'].$row2['idfasstepfather'].$row2['idfastrepson'];?>"></label>
											</div>
												
												</td>
													<td ><?php echo  $row2['nameidfasstepson'];?></td>
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
												<td>2</td>											
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
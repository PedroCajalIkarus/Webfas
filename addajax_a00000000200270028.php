<?php
error_reporting(0);
// Notificar todos los errores de PHP (ver el registro de cambios)
//error_reporting(E_ALL);
 include("db_conect.php"); 
 
 	session_start();
 exit();
?>

													<!--  Star TAB ADD --->		
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
									 			<select class="form-control" onClick="habilitarfirmware(this.value)" name="txttypeclassfw" id="txttypeclassfw" required oninvalid="setCustomValidity('Class is required.')" oninput="setCustomValidity('')">
										
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
						<span class="colorazulfiplex"><b>Script Reference:</b> </span>	<br><br>
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
			<!--  FIN TAB ADD --->	
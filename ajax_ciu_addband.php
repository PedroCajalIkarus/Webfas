
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
							
							
									 
									
					<!-- Start Definition of bands  -->
					<div class="container-fluid" id="divfasselectdib" name="divfasselectdib">	
					<hr>	
						<span class="colorazulfiplex"><b>Module Digital Board Flex:</b> </span>	<br><br>
						<div class="row">
									<div class="form-group col-md-10">
									
										 <select class="form-control" name="txtdibflex" id="txtdibflex" required oninvalid="setCustomValidity('DiB is required.')" oninput="setCustomValidity('')">
											   <option value=""> - Select - </option>
											<?php
											$sql = $connect->prepare("SELECT distinct  idproduct, modelciu ,namegroup ,  ARRAY_AGG (distinct fstartul || ' || ' || fstopul) as lasfreq

											FROM products 
											inner join fas_confidential_fw
											on fas_confidential_fw.idciu = products.idproduct
											
											inner join bandgroups
											on bandgroups.idbandgroup =  products.idbandgroup and 
											bandgroups.idband <> 5
											inner join idband
											on idband.idband = bandgroups.idband
											where iduniquebranchsonprod = '000000002013014'
											group by idproduct, modelciu ,namegroup 
											order by modelciu");
	 
											$sql->execute();
											$resultado3 = $sql->fetchAll();
											foreach ($resultado3 as $row2) 
											 {
												
											 ?>
											 <option value="<?php echo  $row2['idproduct']; ?>">
											 <?php echo  $row2['modelciu']." - [".$row2['namegroup']."] --    ".str_replace ('"',"",$row2['lasfreq']).""; ?>
											 </option>
											 <?php
											 }
											
											?>
										</select>	
									</div>
									</div>		
					</div>			  
						<!--fin DIB  -->		
					
								  
									  
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
											$sql = $connect->prepare("select * from idband where active = 'Y' order by description");
	 
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
									<div class="form-group col-md-6">
										<label for="exampleInputEmail1">Class:</label>
									 		<select class="form-control" name="txttypeclass" id="txttypeclass" required="" oninvalid="setCustomValidity('Class is required.')" oninput="setCustomValidity('')">
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
						

		


					
					
							<!-- inicio de fas instruments parameters --->						  
				  	<div class="container-fluid" id="divfasinstrumetsparameters" name="divfasinstrumetsparameters">					  
									 <hr>	
						<span class="colorazulfiplex"><b> Script Specs:</b> </span>	<br><br>
								
														
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
											  where  fas_steppp.idfasstep in (3,11, 4,21,5,6,26,25,23,19,27,49,26,28,48)  and fas_tree.idfastree = 1 ");

											 
	 
											$sql->execute();
											$resultado3 = $sql->fetchAll();
											foreach ($resultado3 as $row2) 
											 {
												if ($row2['treetype']=='head')
												{
													?><tr class=""> <?php
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
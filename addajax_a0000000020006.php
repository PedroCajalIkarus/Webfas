
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
													<select class="form-control form-control-sm" name="txtmodiftypemodule" id="txtmodiftypemodule" required oninvalid="setCustomValidity('Business is required.')" oninput="setCustomValidity('')">
												 <option value=""> - Select - </option>
												 <option value="coupler" selected >COUPLER</option>
												
												  <option value="duplexer">DUPLEXER</option>
												    <option value="preselector">PRESELECTOR</option>
													<option value="splitter">SPLITTER</option>
											    
											  </select>
										  </div>
										</div>
							</div>
										<!-- parte formu para PASSIVE Coupler 
				Coupling(dB)
				Insertion Loss(dB)
				Isolation(dB)
				Freq start(MHz)
				Freq stop(MHz)
				-->
				
				<div id="1_7_6_Coupler" name="1_7_6_Coupler" class="col-sm-12">
					<span class="colorazulfiplex"><b><hr>Power Specs (dB)</b></span><span id="newnamelabel" name="newnamelabel" class="colorazulfiplex"></span><br>	<br>				
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
							<label >	Coupling(dB):</label><br>
							<input type="text" class="form-control" placeholder="Coupling" onblur="habilitarfin('coupler')" id="txtcoupling" data-validate="false" name="txtcoupling" >
							</div>
						</div>
						<div class="col-sm-6">	
							<div class="form-group"><label >Insertion Loss(dB):</label><br>
							<input type="text" class="form-control  " placeholder="Insertion Loss" onblur="habilitarfin('coupler')" id="txtcouplinginserloss" data-validate="false" name="txtcouplinginserloss" >
							</div>
						</div>
					</div>	
					<div class="row">	
						 
					
						 <div class="col-sm-6"> 	
							<div class="form-group">
							<label >Isolation(dB):</label><br>
							<input type="text" class="form-control " placeholder="Isolation" onblur="habilitarfin('coupler')" id="txtcouplingisolat" data-validate="false" name="txtcouplingisolat" >
							</div>
						</div>		
						
					 </div>
					<br>
					<hr>
					<span class="colorazulfiplex"><b>Frequency Specs: (MHz) </b></span><br><br>
					<div class="row">	
							<div class="col-sm-6"> 
							<div class="form-group">
							<label >Start: (MHz)</label>
							<input type="text" class="form-control  " placeholder="Freq start" onblur="habilitarfin('coupler')" id="txtcouplingfreqstart" data-validate="false" name="txtcouplingfreqstart" >
							
						 </div>	
						 </div>						 
						<div class="col-sm-6">	
							<div class="form-group">
							<label >Stop: (MHz)</label>
							<input type="text" class="form-control " placeholder="Freq stop" onblur="habilitarfin('coupler')" id="txtcouplingfreqstop" data-validate="false" name="txtcouplingfreqstop" >
							</div>
						</div>
				
				   </div>	
			
				</div>
			<!-- fin parte formu para PASSIVE Coupler -->
			
		
									  
				
					

						
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
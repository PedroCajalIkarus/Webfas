
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
					
<!-- inicio de label --->						  
<div class="container-fluid">					  
								
						<span class="colorazulfiplex"><b>Label Specs:</b> </span>	<br><br>
						
						<div class="row">
								<table class="table table-striped table-bordered table-sm" name="exampledin11" id="exampledin11">
								<thead class="thead-dark text-left">
								<tr>
								<th style="text-align: left">Model</th>
								<th class=" text-left">MadeIn</th>
								<th class=" text-left">UL Power Rating</th>
								<th class="">FCC</th>
								<th class="">IC</th>															  
								<th class="">ETSI</th>	
								<th class="">UL Contract</th>	
								<th class="">UL Standard</th>	
								<th class="">Generic Text</th>	
								<th class="">Trademark</th>	
								<th class="">Drawing Number</th>
								<th class="">Url</th>	
								<th class="">FCC IMG</th>
								<th class="">UL IMG</th>
								<th class="">ROHS IMG</th>
								<th class="">MadeIn IMG</th>
								<th class="">SGS IMG</th>
								</tr>	</thead><tbody>
					<?php
					$vv_idciu = $_REQUEST['id'];
					$query_lista = "select * from products_label where idproduct =".$vv_idciu." and  idrevlabel in( select max(idrevlabel) from products_label  where idproduct =".$vv_idciu." )" ;	
			//		echo 		$query_lista;
				$datacontrol = $connect->query($query_lista)->fetchAll();	
					foreach ($datacontrol as $rowcnotrol) 
					{
					    $v_model = $rowcnotrol['flia'];
						?><tr class='text-left'>
								<td style="text-align: left"><?php echo $rowcnotrol['flia']; ?></td>
								<td><?php echo $rowcnotrol['madein']; ?></td>
								<td><?php echo $rowcnotrol['ulpwrrat']; ?></td>
								<td><?php echo $rowcnotrol['fcc']; ?></td>
								<td><?php echo $rowcnotrol['ic']; ?></td>
								<td><?php echo $rowcnotrol['etsi']; ?></td>
								<td><?php echo $rowcnotrol['ulcontract']; ?></td>
								<td><?php echo $rowcnotrol['ulstandard']; ?></td>
								<td><?php echo $rowcnotrol['generictext']; ?></td>
								<td><?php echo $rowcnotrol['trademark']; ?></td>
								<td><?php echo $rowcnotrol['drawingnumber']; ?></td>
								<td><?php echo $rowcnotrol['url']; ?></td>

								<td><?php  
									if( $rowcnotrol['fccimg']==1)
									{
										echo "<i class='far fa-check-circle' style='font-size:20px;color:green'></i>";
									}
									else
									{
										echo "<i class='far fa-times-circle' style='font-size:20px;color:red'></i>";
									} ?></td>
								<td>
								<?php  
									if( $rowcnotrol['ulimg']==1)
									{
										echo "<i class='far fa-check-circle' style='font-size:20px;color:green'></i>";
									}
									else
									{
										echo "<i class='far fa-times-circle' style='font-size:20px;color:red'></i>";
									} ?></td>
								<td>
								<?php  
									if( $rowcnotrol['fccimg']==1)
									{
										echo "<i class='far fa-check-circle' style='font-size:20px;color:green'></i>";
									}
									else
									{
										echo "<i class='far fa-times-circle' style='font-size:20px;color:red'></i>";
									} ?></td>
								<td> 
								<?php 
									if( $rowcnotrol['madeinimg']==1)
									{
										echo "<i class='far fa-check-circle' style='font-size:20px;color:green'></i>";
									}
									else
									{
										echo "<i class='far fa-times-circle' style='font-size:20px;color:red'></i>";
									} ?></td>
								
								<td> 
								<?php  
									if( $rowcnotrol['sgsimg']==1)
									{
										echo "<i class='far fa-check-circle' style='font-size:20px;color:green'></i>";
									}
									else
									{
										echo "<i class='far fa-times-circle' style='font-size:20px;color:red'></i>";
									} ?></td>
					</tr>
						<?php
					}

					?>
					
					<tbody>	
								</table>
						</div>
						<p>
						<a class="btn btn-block btn-outline-primary btn-xs" data-toggle="collapse" href="#collapseExample00000000101600140" role="button" aria-expanded="false" aria-controls="collapseExample00000000101600140">
								<label class="colorazulfiplex"><b>Generate new revision:</b> </label>	
						</a>
						<br><br>

						
						</p>
						<div class="collapse" id="collapseExample00000000101600140">
						
									<div class="row">

											<!-- inicio lable -->
											<div class="form-group col-md-6">
											<label for="exampleInputEmail1" class="labelpformodule">Model:</label>
											<input type="text" name="txtflia" onblur="habilitarfin('auto')" id="txtflia" class="labelpformodule form-control" placeholder="Model" required oninvalid="setCustomValidity('Family is required.')" 
											oninput="setCustomValidity('')" value="<?php echo  $v_model; ?>">
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
											<label for="exampleInputEmail1" class="labelforunit">SGS IMG:</label>
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









											<div class="row">
											<div class="col-sm-12">
											<div class="card-footer text-right">
											<input type="hidden" name="txtidprod" id="txtidprod" value="<?php echo 	$vv_idciu;?>">
											<button type="button" onclick="save_new_registro_lbl()" name="btnfin" id="btnfin" class="btn btn-primary btn-block right-align">Save and Create New Revision</button>


											</div>
											</div>
											</div>
															
											</div>
								</div>	
						</div>

						
						
						
						
					
			</div>
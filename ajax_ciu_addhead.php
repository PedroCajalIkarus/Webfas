
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
												 <option value="UNITFLEX" selected >UNIT FLEX</option>
												
											
											    
											  </select>
										  </div>
										</div>
							</div>
									
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
							<!-- inicio de FW --->
			<?php 

$vfpga_file = "";
$vmicro_file = "";
$veth_file = "";

$vfpga_file_fas = "";
$vmicro_file_fas = "";
$veth_file_fas = "";
//echo "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa

	

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
WHERE  idunquebranchfather = '000000002013014' and bandgroups.idbandgroup not in( 5,9,10)  "  );
	

				
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
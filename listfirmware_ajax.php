<?php


	include("db_conect.php"); 


	function show_firmware_bybranch($idbranchtosearch,$nombrerama)
{

	include("db_conect.php"); 
	echo "<br><hr style=' border-top: 2px solid #f39323;'><h4 class='card-title colorazulfiplex'> <i class='jstree-icon jstree-themeicon fa fa-inbox jstree-themeicon-custom' ></i> ::: Branch ::: ".$nombrerama."</h4>";
	
	/*$sql = $connect->prepare("select  distinct namegroup , products_branch_fw.*  ,cc as cantxrama 
	from products_branch 
	inner join products_branch_fw
	on products_branch_fw.idproductsbranch = products_branch.idproductsbranch
	inner join business_branch_tree
	on business_branch_tree.idprodbranchson = products_branch.idproductsbranch
	inner join bandgroups
	on bandgroups.idbandgroup = products_branch_fw.idbandgroup 
	inner join 
	(
		select idbandgroup, count(idrev) as cc from products_branch_fw group by idbandgroup
	) as countbygropuband
	on products_branch_fw.idbandgroup  = countbygropuband.idbandgroup
	where idunquebranchfather= '".str_replace("a","",$idbranchtosearch)."' and havefw = 'Y'  order by namegroup ,  idrev asc  ");
	*/

	$sql = $connect->prepare("
	select fas_firmwarelist.*, namefirmware  as namegroup , 0 as cc
	from fas_firmwarelist
	inner join business_branch_tree_fw
	on fas_firmwarelist.idfas_firmwarelist = business_branch_tree_fw.idfas_firmwarelist	 
	where iduniquebranchprodson= '".str_replace("a","",$idbranchtosearch)."'  ");

 

	
		$sql->execute();
																						   $resultado3 = $sql->fetchAll();
		if (count($resultado3) ==0)
		{
			$sql = $connect->prepare("select  distinct namegroup , products_branch_fw.*  ,cc as cantxrama 
	from products_branch 
	inner join products_branch_fw
	on products_branch_fw.idproductsbranch = products_branch.idproductsbranch
	inner join business_branch_tree
	on business_branch_tree.idprodbranchson = products_branch.idproductsbranch
	inner join bandgroups
	on bandgroups.idbandgroup = products_branch_fw.idbandgroup 
	inner join 
	(
		select idbandgroup, count(idrev) as cc from products_branch_fw group by idbandgroup
	) as countbygropuband
	on products_branch_fw.idbandgroup  = countbygropuband.idbandgroup
	where idunquebranchfather like '".str_replace("a","",$idbranchtosearch)."%' and havefw = 'Y'  order by namegroup ,  idrev asc  ");
		}
																					///	   echo "HOLAAAAA cant resultado:".count($resultado3)."*****";
																						   $cantdenegritas=0;
																						   $classnegrita="";
																						   $marcar_ultimo = count($resultado3);
																						   
																							   
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
															   $tempnamegroupid=0;
												$entro="N";								 
									$sql->execute();
										$resultado3 = $sql->fetchAll();
										$cantdenegritas=0;
										$classnegrita="";
									
										$indxtablaadd =0;
										$indparamaxregxrma = 0;
								//		echo "<br>***Holaaaaaaaaaaa".$marcar_ultimo ;
										foreach ($resultado3 as $row2) 
										{
											$indparamaxregxrma = $indparamaxregxrma + 1;
											$marcar_ultimo =trim($row2['cantxrama']);

											$vvidfas_firmwarelist = $row2['idfas_firmwarelist']; 

											//echo "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa".$vvidfas_firmwarelist;
											//exit();
										

											$class_colorvvfpga_file="";		
											$class_colorvvfpga_fas="";
											$class_colorvvmicro_file="";
											$class_colorvvmicro_fas="";
											$class_colorvveth_file="";
											$class_colorvveth_fas="";
																								
															///	echo "<br>a vert". trim($row2['namegroup'])."".$tempnamegroup;
															   if ( trim($row2['namegroup']) <> $tempnamegroup )									
															   {
																   if ($tempnamegroup <>"")
																   {
																	   echo "</table>";
																	   $indparamaxregxrma = 1;
																	   $cantdenegritas = 0;
																	  ?>
																	  <!-- add fwr update-->
																	  	<!--start load firmware -->
																		<div class="container-fluid" id="divaddfirmware<?php echo  $idbranchtosearch.$indxtablaadd ; ?>" name="divaddfirmware<?php echo 	$idbranchtosearch.$indxtablaadd ; ?>">		

																				<p>
																				<a class="btn btn-block btn-outline-primary btn-xs" data-toggle="collapse" href="#collapseExample<?php echo 	$idbranchtosearch.$indxtablaadd ; ?>" role="button" aria-expanded="false" aria-controls="collapseExample<?php echo 	$idbranchtosearch.$indxtablaadd ; ?>">
																						<label class="colorazulfiplex"><b>Add Firmware:</b> </label>	
																				</a>

																				</button>
																				</p>
																				<div class="collapse" id="collapseExample<?php echo 	$idbranchtosearch.$indxtablaadd ; ?>">
																				<div class="card card-body">
																					
																					
																					
																						<div class="row " id="firmwarestand" name="firmwarestand">	
																							<div class="form-group col-md-4">
																							
																							<label for="exampleInputEmail1">FPGA FAS:</label>
																									<input type="text" name="txtfpgafwadd<?php echo 	$idbranchtosearch.$indxtablaadd ; ?>"  id="txtfpgafwadd<?php echo 	$idbranchtosearch.$indxtablaadd ; ?>" class="form-control form-control-sm" placeholder="FPGA version " required="" oninvalid="setCustomValidity('FPGA Number is required.')" oninput="setCustomValidity('')" value="<?php echo $vvfpga_fas_temp;?>">	
																							</div>
																							<div class="form-group col-md-4">
																								
																								<label for="exampleInputEmail1">uC FAS:</label>
																									<input type="text" name="txtucfwadd<?php echo 	$idbranchtosearch.$indxtablaadd ; ?>"  id="txtucfwadd<?php echo 	$idbranchtosearch.$indxtablaadd ; ?>" class="form-control form-control-sm" placeholder="uC version" required="" oninvalid="setCustomValidity('uC Number is required.')" oninput="setCustomValidity('')" value="<?php echo $vvmicro_fas_temp;?>">	
																								
																							</div>
																							
																							
																								
																															
																							<div class="form-group col-md-4">
																							
																							<label for="exampleInputEmail1">Ethernet FAS:</label>
																									<input type="text" name="txtetherfasfwadd<?php echo 	$idbranchtosearch.$indxtablaadd ; ?>"  id="txtetherfasfwadd<?php echo 	$idbranchtosearch.$indxtablaadd ; ?>" class="form-control form-control-sm" placeholder="Eth version " required="" oninvalid="setCustomValidity('Eth Number is required.')" oninput="setCustomValidity('')" value="<?php echo $vveth_fas_temp;?>">	
																							</div>
																							
																						</div>
																						<div class="row" id="firmwarecustom" name="firmwarecustom">	
																							<div class="form-group col-md-4">
																							
																							<label for="exampleInputEmail1">FPGA File Name:</label>
																									<input type="text" name="txtfpgafasfwadd<?php echo 	$idbranchtosearch.$indxtablaadd ; ?>"  id="txtfpgafasfwadd<?php echo 	$idbranchtosearch.$indxtablaadd ; ?>" class="form-control form-control-sm" placeholder="FPGA File Name Custom" required="" oninvalid="setCustomValidity('FPGA is required Custom.')" oninput="setCustomValidity('')" value="<?php echo $vvfpga_file_temp;?>">	
																							</div>
																							<div class="form-group col-md-4">
																								
																								<label for="exampleInputEmail1">Uc File Name :</label>
																									<input type="text" name="txtucfasfwadd<?php echo 	$idbranchtosearch.$indxtablaadd ; ?>"  id="txtucfasfwadd<?php echo 	$idbranchtosearch.$indxtablaadd ; ?>" class="form-control form-control-sm" placeholder="Uc File Name Custom" required="" oninvalid="setCustomValidity(uC is required Custom.')" oninput="setCustomValidity('')" value="<?php echo $vvmicro_file_temp;?>">	
																								
																							</div>
																							<div class="form-group col-md-4">
																							
																							<label for="exampleInputEmail1">Ethernet File Name:</label>
																									<input type="text" name="txtetherfwadd<?php echo 	$idbranchtosearch.$indxtablaadd ; ?>"  id="txtetherfwadd<?php echo 	$idbranchtosearch.$indxtablaadd ; ?>" class="form-control form-control-sm" placeholder="Ethernet File Name Custom" required="" oninvalid="setCustomValidity('Ether is required Custom.')" oninput="setCustomValidity('')" value="<?php echo $vveth_file_temp;?>">	
																							</div>
																						
																						</div>
																						<div class="row" id="firmwarecustom" name="firmwarecustom">	
																							<div class="form-group col-md-4">
																							
																							<label for="exampleInputEmail1">FPGA Upgrade Description:</label>
																									<input type="text" name="txtfpgacusdescripupg<?php echo 	$idbranchtosearch.$indxtablaadd ; ?>"  id="txtfpgacusdescripupg<?php echo 	$idbranchtosearch.$indxtablaadd ; ?>" class="form-control form-control-sm" placeholder="FPGA upgrade description" required="" oninvalid="setCustomValidity('FPGA is required Custom.')" oninput="setCustomValidity('')" value="">	
																							</div>
																							<div class="form-group col-md-4">
																								
																								<label for="exampleInputEmail1">Uc Upgrade Description:</label>
																									<input type="text" name="txtuccusdescripupg<?php echo 	$idbranchtosearch.$indxtablaadd ; ?>"  id="txtuccusdescripupg<?php echo 	$idbranchtosearch.$indxtablaadd ; ?>" class="form-control form-control-sm" placeholder="Uc upgrade description" required="" oninvalid="setCustomValidity(uC is required Custom.')" oninput="setCustomValidity('')" value="">	
																								
																							</div>
																							<div class="form-group col-md-4">
																							
																							<label for="exampleInputEmail1">Ethernet Upgrade Description:</label>
																									<input type="text" name="txtethercusdescripupg<?php echo 	$idbranchtosearch.$indxtablaadd ; ?>"  id="txtethercusdescripupg<?php echo 	$idbranchtosearch.$indxtablaadd ; ?>" class="form-control form-control-sm" placeholder="Ethernet upgrade description" required="" oninvalid="setCustomValidity('Ether is required Custom.')" oninput="setCustomValidity('')" value="">	
																							</div>
																					<!--		<div class="form-group col-md-12 ">
																							<label for="exampleInputEmail1">Cal String  :</label>
																				<input type="text" name="calstringfw" id="calstringfw" class="form-control " placeholder="Enter Cal String" required oninvalid="setCustomValidity('FPGA is required.')" 
																				oninput="setCustomValidity('')" value="<?php // echo $vvvcalstring;?>">
																								
																							</div>-->
																							<div class="form-group col-md-12 ">
																							ACA TABLAAAA
																							</div>
																								<div class="form-group col-md-12 ">
																								<input type="hidden" name="idramon<?php echo 	$idbranchtosearch.$indxtablaadd ; ?>" id="idramon<?php echo 	$idbranchtosearch.$indxtablaadd ; ?>" value="<?php echo  $_REQUEST['p0']."#".$vvidproductsbranch; ?>">
																								<input type="hidden" name="idfrm<?php echo 	$idbranchtosearch.$indxtablaadd ; ?>" id="idfrm<?php echo 	$idbranchtosearch.$indxtablaadd ; ?>" value="<?php echo  $_REQUEST['p0']."#".$vvidfas_firmwarelist; ?>">
																								
																								<button name="btnaddband<?php echo 	$idbranchtosearch.$indxtablaadd ; ?>" id="btnaddband<?php echo 	$idbranchtosearch.$indxtablaadd ; ?>" type="button" class="btn btn-smk btn-block btn-outline-primary btn-flat btn-sm" onclick="save_add_registro_type_fw('<?php echo 	$idbranchtosearch.$indxtablaadd ; ?>')">Upgrade Firmware <?php echo 	$idbranchtosearch.$indxtablaadd ; ?></button>
																								
																								
																							</div>
																					
																				</div>
																				</div>


																							
																						</div>
																							</div>
																							<!--end load firmware -->
																						<br>
																	  <?php
																	   
																	   
																		
																			   
																			   ?>
																			   <script>
																				/* $('#exampledin<?php echo trim($tempnamegroupid ); ?>').DataTable( {
																								   "order": [[ 0, "desc" ]]
																							   } );
																							   
																				   console.log('#exampledin<?php echo trim($tempnamegroupid ); ?>')		;
																				   */	
																			   </script>
																			   <?php
																		   

																		$indxtablaadd =  $indxtablaadd  + 1;
													   
																   }
																   $tempnamegroup = trim($row2['namegroup']);
																   $tempnamegroupid  = trim($row2['idbandgroup']);
														 // temporal				
														 
														 ?>	 	
														 <br>	
														 <hr>														
															 <h5 class="card-title colorazulfiplex"> <?php echo  trim($row2['namegroup']); ?></h5>
															 <br><br>
															 <b>Firmware versions : </b>
																												 <table class="table table-striped table-bordered table-sm" name="exampledin<?php echo trim($row2['idbandgroup']); ?>" id="exampledin<?php echo trim($row2['idbandgroup']); ?>">
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
																													 
																									 
																}
																///echo "aaaaaaaaaaaaabbbbbbcccccccccccc";
																												 
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
																																				  //	echo "HOLA".$cantdenegritas."---".$marcar_ultimo;
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
																																					  $losdatos=explode("_", 	$indxtablaadd."_".$vvfpga_file );
																																						 $entro="S";			
																																				  ?>
																																				  
																																				  <tr>
																																				   
																																				   <td class="<?php echo  $classnegrita; ?>"><?php echo   substr ($row2['datetimemodif'],0,19); ?></b></td> 
																																			 
																																				 <td class="<?php echo  $classnegrita; ?>">
																																				 
																																				 <a href="#" class="tooltipmarcolink<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']." ".$class_colorvvfpga_fas; ?>"  onmouseout="ocultar_tooltip('<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']; ?>')" onmouseover="mostrar_tooltip('<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']; ?>')" ><?php echo  $row2['fpga_fas']; ?></a>
																																					 <?php if ( $row2['fpga_description'] !="") {?>
																																							 <div id="tooltipfreq<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']; ?>" name="tooltipfreq<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']; ?>" class='d-none tooltipmarco text-left texto9' role='tooltip'>  <?php echo  $row2['fpga_description']; ?> </div>
																																					 <?php } ?>
																																				 
																																				 
																																				 <?php //echo  $row2['fpga_fas']; ?></td>
																																				 <td class="<?php echo  $classnegrita; ?>"> 
																																				 <a href="#" class="tooltipmarcolink<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."uc"." ".$class_colorvvmicro_fas; ?>"  onmouseout="ocultar_tooltip('<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."uc"; ?>')" onmouseover="mostrar_tooltip('<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."uc"; ?>')" ><?php echo  $row2['micro_fas']; ?></a>
																																					 <?php if ( $row2['uc_description'] !="") {?>																							
																																					 <div id="tooltipfreq<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."uc"; ?>" name="tooltipfreq<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."uc"; ?>" class='d-none tooltipmarco text-left texto9' role='tooltip'>  <?php echo  $row2['uc_description']; ?> </div>
																																					 <?php } ?>
																																							 
																																				 <?php // echo  $row2['micro_fas']; ?></td>
																																				 <td class="<?php echo  $classnegrita; ?>">
																																				 <a href="#" class="tooltipmarcolink<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."eth"." ".$class_colorvveth_fas; ?>"  onmouseout="ocultar_tooltip('<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."eth"; ?>')" onmouseover="mostrar_tooltip('<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."eth"; ?>')" ><?php echo  $row2['eth_fas']; ?></a>
																																					 <?php if ( $row2['eht_description'] !="") {?>																									
																																					 <div id="tooltipfreq<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."eth"; ?>" name="tooltipfreq<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."eth"; ?>" class='d-none tooltipmarco text-left texto9' role='tooltip'> <?php echo  $row2['eht_description']; ?> </div>
																																					 <?php } ?>
																																				 
																																				 <?php // echo  $row2['eth_fas']; ?></td>
																																				 <td class="<?php echo  $classnegrita; ?>">																						
																																				 <a href="#" class="tooltipmarcolink<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."det ".$class_colorvvfpga_file; ?>"  onmouseout="ocultar_tooltip('<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."det"; ?>')" onmouseover="mostrar_tooltip('<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."det"; ?>')" ><?php echo  $row2['fpga_file']; ?></a>
																																					 <?php if ( $row2['fpga_description'] !="") {?>	
																																						 <div id="tooltipfreq<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."det"; ?>" name="tooltipfreq<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."det"; ?>" class='d-none tooltipmarco text-left texto9' role='tooltip'>  <?php echo  $row2['fpga_description']; ?> </div>
																																						 <?php } ?>
																																				 </td>  											  
																																				 
																																				 <td class="<?php echo  $classnegrita; ?>">
																																				 <a href="#" class="tooltipmarcolink<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."ucdet"." ".$class_colorvvmicro_file; ?>"  onmouseout="ocultar_tooltip('<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."ucdet"; ?>')" onmouseover="mostrar_tooltip('<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."ucdet"; ?>')" ><?php echo  $row2['micro_file']; ?></a>
																																						 <?php if ( $row2['uc_description'] !="") {?>																								
																																						 <div id="tooltipfreq<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."ucdet"; ?>" name="tooltipfreq<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."ucdet"; ?>" class='d-none tooltipmarco text-left texto9' role='tooltip'>  <?php echo  $row2['uc_description']; ?> </div>
																																							 <?php } ?>
																																							 </td>
																																				 
																																				 <td class="<?php echo  $classnegrita; ?>">
														 
																																				 <a href="#" class="tooltipmarcolink<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."ethdet"." ".$class_colorvveth_file; ?>"  onmouseout="ocultar_tooltip('<?php echo  $row2['idrev']."ethdet"; ?>')" onmouseover="mostrar_tooltip('<?php echo  $row2['idrev']."ethdet"; ?>')" ><?php echo  $row2['eth_file']; ?></a>
																																								 <?php if ( $row2['eht_description'] !="") {?>	
																																							 <div id="tooltipfreq<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."ethdet"; ?>" name="tooltipfreq<?php echo  $row2['idrev']."ethdet"; ?>" class='d-none tooltipmarco text-left texto9' role='tooltip'> <?php echo  $row2['eht_description']; ?> </div>
																																							 <?php } ?>
																																							 </td>
																																				 
																																				 
																																			 
																														 
																																				 
																																				  <?php
																																					 
																																				  } 
																																				  
																																				  if ($entro=="N")
																																				  {
																																					  ?>
																																					  <tr>
																																						 <td colspan=7 class="text-center"><br><br>  No associated Fw found.
																																						 </td>
																																					  </tr>
																																					  <?php
																																				  }
																																				  ?>	
																														 
																																				 
																																																		  
																												   </tbody>
																												 </table>
																												 <?php
																								
															  
										}
														 
									
									


 

	$sql = $connect->prepare("
	select fas_firmwarelist.*, namefirmware  as namegroup , 0 as cc
	from fas_firmwarelist
	inner join business_branch_tree_fw
	on fas_firmwarelist.idfas_firmwarelist = business_branch_tree_fw.idfas_firmwarelist	 
	where iduniquebranchprodson= '".str_replace("a","",$_REQUEST['p0'])."'  ");
	
		$sql->execute();
																						   $resultado3 = $sql->fetchAll();
																						   $cantdenegritas=0;
																						   $classnegrita="";
																						   $marcar_ultimo = count($resultado3);
																						   
																							   
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
															   $tempnamegroupid=0;
												$entro="N";								 
									$sql->execute();
										$resultado3 = $sql->fetchAll();
										$cantdenegritas=0;
										$classnegrita="";
									
										$indxtablaadd =0;
										$indparamaxregxrma = 0;
									//	echo "Holaaaaaaaaaaa".$marcar_ultimo ;
										foreach ($resultado3 as $row2) 
										{
											$indparamaxregxrma = $indparamaxregxrma + 1;
											$marcar_ultimo =trim($row2['cantxrama']);

											
											$vvidfas_firmwarelist = $row2['idfas_firmwarelist']; 

											$class_colorvvfpga_file="";		
											$class_colorvvfpga_fas="";
											$class_colorvvmicro_file="";
											$class_colorvvmicro_fas="";
											$class_colorvveth_file="";
											$class_colorvveth_fas="";
																								
																								
															   if ( trim($row2['namegroup']) <> $tempnamegroup )									
															   {
																   if ($tempnamegroup <>"")
																   {
																	   echo "</table>";
																	   $indparamaxregxrma = 1;
																	   $cantdenegritas = 0;
																	  ?>
																	  <!-- add fwr update-->
																	  	<!--start load firmware -->
																		<div class="container-fluid" id="divaddfirmware<?php echo 	$indxtablaadd ; ?>" name="divaddfirmware<?php echo 	$indxtablaadd ; ?>">		

																				<p>
																				<a class="btn btn-block btn-outline-primary btn-xs" data-toggle="collapse" href="#collapseExample<?php echo 	$indxtablaadd ; ?>" role="button" aria-expanded="false" aria-controls="collapseExample<?php echo 	$indxtablaadd ; ?>">
																						<label class="colorazulfiplex"><b>Add Firmware:</b> </label>	
																				</a>

																				</button>
																				</p>
																				<div class="collapse" id="collapseExample<?php echo 	$indxtablaadd ; ?>">
																				<div class="card card-body">
																					
																					
																					
																						<div class="row " id="firmwarestand" name="firmwarestand">	
																							<div class="form-group col-md-4">
																							
																							<label for="exampleInputEmail1">FPGA FAS:</label>
																									<input type="text" name="txtfpgafwadd<?php echo 	$indxtablaadd ; ?>"  id="txtfpgafwadd<?php echo 	$indxtablaadd ; ?>" class="form-control form-control-sm" placeholder="FPGA version " required="" oninvalid="setCustomValidity('FPGA Number is required.')" oninput="setCustomValidity('')" value="<?php echo $vvfpga_fas_temp;?>">	
																							</div>
																							<div class="form-group col-md-4">
																								
																								<label for="exampleInputEmail1">uC FAS:</label>
																									<input type="text" name="txtucfwadd<?php echo 	$indxtablaadd ; ?>"  id="txtucfwadd<?php echo 	$indxtablaadd ; ?>" class="form-control form-control-sm" placeholder="uC version" required="" oninvalid="setCustomValidity('uC Number is required.')" oninput="setCustomValidity('')" value="<?php echo $vvmicro_fas_temp;?>">	
																								
																							</div>
																							
																							
																								
																															
																							<div class="form-group col-md-4">
																							
																							<label for="exampleInputEmail1">Ethernet FAS:</label>
																									<input type="text" name="txtetherfasfwadd<?php echo 	$indxtablaadd ; ?>"  id="txtetherfasfwadd<?php echo 	$indxtablaadd ; ?>" class="form-control form-control-sm" placeholder="Eth version " required="" oninvalid="setCustomValidity('Eth Number is required.')" oninput="setCustomValidity('')" value="<?php echo $vveth_fas_temp;?>">	
																							</div>
																							
																						</div>
																						<div class="row" id="firmwarecustom" name="firmwarecustom">	
																							<div class="form-group col-md-4">
																							
																							<label for="exampleInputEmail1">FPGA File Name:</label>
																									<input type="text" name="txtfpgafasfwadd<?php echo 	$indxtablaadd ; ?>"  id="txtfpgafasfwadd<?php echo 	$indxtablaadd ; ?>" class="form-control form-control-sm" placeholder="FPGA File Name Custom" required="" oninvalid="setCustomValidity('FPGA is required Custom.')" oninput="setCustomValidity('')" value="<?php echo $vvfpga_file_temp;?>">	
																							</div>
																							<div class="form-group col-md-4">
																								
																								<label for="exampleInputEmail1">Uc File Name :</label>
																									<input type="text" name="txtucfasfwadd<?php echo 	$indxtablaadd ; ?>"  id="txtucfasfwadd<?php echo 	$indxtablaadd ; ?>" class="form-control form-control-sm" placeholder="Uc File Name Custom" required="" oninvalid="setCustomValidity(uC is required Custom.')" oninput="setCustomValidity('')" value="<?php echo $vvmicro_file_temp;?>">	
																								
																							</div>
																							<div class="form-group col-md-4">
																							
																							<label for="exampleInputEmail1">Ethernet File Name:</label>
																									<input type="text" name="txtetherfwadd<?php echo 	$indxtablaadd ; ?>"  id="txtetherfwadd<?php echo 	$indxtablaadd ; ?>" class="form-control form-control-sm" placeholder="Ethernet File Name Custom" required="" oninvalid="setCustomValidity('Ether is required Custom.')" oninput="setCustomValidity('')" value="<?php echo $vveth_file_temp;?>">	
																							</div>
																						
																						</div>
																						<div class="row" id="firmwarecustom" name="firmwarecustom">	
																							<div class="form-group col-md-4">
																							
																							<label for="exampleInputEmail1">FPGA Upgrade Description:</label>
																									<input type="text" name="txtfpgacusdescripupg<?php echo 	$indxtablaadd ; ?>"  id="txtfpgacusdescripupg<?php echo 	$indxtablaadd ; ?>" class="form-control form-control-sm" placeholder="FPGA upgrade description" required="" oninvalid="setCustomValidity('FPGA is required Custom.')" oninput="setCustomValidity('')" value="">	
																							</div>
																							<div class="form-group col-md-4">
																								
																								<label for="exampleInputEmail1">Uc Upgrade Description:</label>
																									<input type="text" name="txtuccusdescripupg<?php echo 	$indxtablaadd ; ?>"  id="txtuccusdescripupg<?php echo 	$indxtablaadd ; ?>" class="form-control form-control-sm" placeholder="Uc upgrade description" required="" oninvalid="setCustomValidity(uC is required Custom.')" oninput="setCustomValidity('')" value="">	
																								
																							</div>
																							<div class="form-group col-md-4">
																							
																							<label for="exampleInputEmail1">Ethernet Upgrade Description:</label>
																									<input type="text" name="txtethercusdescripupg<?php echo 	$indxtablaadd ; ?>"  id="txtethercusdescripupg<?php echo 	$indxtablaadd ; ?>" class="form-control form-control-sm" placeholder="Ethernet upgrade description" required="" oninvalid="setCustomValidity('Ether is required Custom.')" oninput="setCustomValidity('')" value="">	
																							</div>
																					<!--		<div class="form-group col-md-12 ">
																							<label for="exampleInputEmail1">Cal String  :</label>
																				<input type="text" name="calstringfw" id="calstringfw" class="form-control " placeholder="Enter Cal String" required oninvalid="setCustomValidity('FPGA is required.')" 
																				oninput="setCustomValidity('')" value="<?php // echo $vvvcalstring;?>">
																								
																							</div>-->
																							<div class="form-group col-md-12 ">
																							ACA TABLAAAA 2
																							</div>
																							
																								<div class="form-group col-md-12 ">
																								<input type="hidden" name="idramon<?php echo 	$indxtablaadd ; ?>" id="idramon<?php echo 	$indxtablaadd ; ?>" value="<?php echo  $_REQUEST['p0']."#".$vvidproductsbranch; ?>">
																								<input type="hidden" name="idfrm<?php echo 	$idbranchtosearch.$indxtablaadd ; ?>" id="idfrm<?php echo 	$idbranchtosearch.$indxtablaadd ; ?>" value="<?php echo  $vvidfas_firmwarelist; ?>">
																								<button name="btnaddband<?php echo 	$indxtablaadd ; ?>" id="btnaddband<?php echo 	$indxtablaadd ; ?>" type="button" class="btn btn-smk btn-block btn-outline-primary btn-flat btn-sm" onclick="save_add_registro_type_fw('<?php echo 	$indxtablaadd ; ?>')">Upgrade Firmware</button>
																								
																								
																							</div>
																					
																				</div>
																				</div>


																							
																						</div>
																							</div>
																							<!--end load firmware -->
																						<br>
																	  <?php
																	   
																	   
																		
																			   
																			   ?>
																			   <script>
																				 $('#exampledin<?php echo trim($tempnamegroupid ); ?>').DataTable( {
																								   "order": [[ 0, "desc" ]]
																							   } );
																							   
																				   console.log('#exampledin<?php echo trim($tempnamegroupid ); ?>')		;	
																			   </script>
																			   <?php
																		   

																		$indxtablaadd =  $indxtablaadd  + 1;
													   
																   }
																   $tempnamegroup = trim($row2['namegroup']);
																   $tempnamegroupid  = trim($row2['idbandgroup']);
   
   ?>	 	
   <br>	
   <hr>														
	   <h5 class="card-title colorazulfiplex"> <?php echo  trim($row2['namegroup']); ?></h5>
	   <br><br>
	   <b>Firmware versions : </b>
														   <table class="table table-striped table-bordered table-sm" name="exampledin<?php echo trim($row2['idbandgroup']); ?>" id="exampledin<?php echo trim($row2['idbandgroup']); ?>">
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
															   }
											   
	
														   
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
																							//	echo "HOLA".$cantdenegritas."---".$marcar_ultimo;
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
																								$losdatos=explode("_", 	$indxtablaadd."_".$vvfpga_file );
																								   $entro="S";			
																							?>
																							
																							<tr>
																							 
																							 <td class="<?php echo  $classnegrita; ?>"><?php echo   substr ($row2['datetimemodif'],0,19); ?></b></td> 
																					   
																						   <td class="<?php echo  $classnegrita; ?>">
																						   
																						   <a href="#" class="tooltipmarcolink<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']." ".$class_colorvvfpga_fas; ?>"  onmouseout="ocultar_tooltip('<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']; ?>')" onmouseover="mostrar_tooltip('<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']; ?>')" ><?php echo  $row2['fpga_fas']; ?></a>
																							   <?php if ( $row2['fpga_description'] !="") {?>
																									   <div id="tooltipfreq<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']; ?>" name="tooltipfreq<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']; ?>" class='d-none tooltipmarco text-left texto9' role='tooltip'>  <?php echo  $row2['fpga_description']; ?> </div>
																							   <?php } ?>
																						   
																						   
																						   <?php //echo  $row2['fpga_fas']; ?></td>
																						   <td class="<?php echo  $classnegrita; ?>"> 
																						   <a href="#" class="tooltipmarcolink<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."uc"." ".$class_colorvvmicro_fas; ?>"  onmouseout="ocultar_tooltip('<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."uc"; ?>')" onmouseover="mostrar_tooltip('<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."uc"; ?>')" ><?php echo  $row2['micro_fas']; ?></a>
																							   <?php if ( $row2['uc_description'] !="") {?>																							
																							   <div id="tooltipfreq<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."uc"; ?>" name="tooltipfreq<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."uc"; ?>" class='d-none tooltipmarco text-left texto9' role='tooltip'>  <?php echo  $row2['uc_description']; ?> </div>
																							   <?php } ?>
																									   
																						   <?php // echo  $row2['micro_fas']; ?></td>
																						   <td class="<?php echo  $classnegrita; ?>">
																						   <a href="#" class="tooltipmarcolink<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."eth"." ".$class_colorvveth_fas; ?>"  onmouseout="ocultar_tooltip('<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."eth"; ?>')" onmouseover="mostrar_tooltip('<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."eth"; ?>')" ><?php echo  $row2['eth_fas']; ?></a>
																							   <?php if ( $row2['eht_description'] !="") {?>																									
																							   <div id="tooltipfreq<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."eth"; ?>" name="tooltipfreq<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."eth"; ?>" class='d-none tooltipmarco text-left texto9' role='tooltip'> <?php echo  $row2['eht_description']; ?> </div>
																							   <?php } ?>
																						   
																						   <?php // echo  $row2['eth_fas']; ?></td>
																						   <td class="<?php echo  $classnegrita; ?>">																						
																						   <a href="#" class="tooltipmarcolink<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."det ".$class_colorvvfpga_file; ?>"  onmouseout="ocultar_tooltip('<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."det"; ?>')" onmouseover="mostrar_tooltip('<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."det"; ?>')" ><?php echo  $row2['fpga_file']; ?></a>
																							   <?php if ( $row2['fpga_description'] !="") {?>	
																								   <div id="tooltipfreq<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."det"; ?>" name="tooltipfreq<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."det"; ?>" class='d-none tooltipmarco text-left texto9' role='tooltip'>  <?php echo  $row2['fpga_description']; ?> </div>
																								   <?php } ?>
																						   </td>  											  
																						   
																						   <td class="<?php echo  $classnegrita; ?>">
																						   <a href="#" class="tooltipmarcolink<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."ucdet"." ".$class_colorvvmicro_file; ?>"  onmouseout="ocultar_tooltip('<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."ucdet"; ?>')" onmouseover="mostrar_tooltip('<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."ucdet"; ?>')" ><?php echo  $row2['micro_file']; ?></a>
																								   <?php if ( $row2['uc_description'] !="") {?>																								
																								   <div id="tooltipfreq<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."ucdet"; ?>" name="tooltipfreq<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."ucdet"; ?>" class='d-none tooltipmarco text-left texto9' role='tooltip'>  <?php echo  $row2['uc_description']; ?> </div>
																									   <?php } ?>
																									   </td>
																						   
																						   <td class="<?php echo  $classnegrita; ?>">
   
																						   <a href="#" class="tooltipmarcolink<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."ethdet"." ".$class_colorvveth_file; ?>"  onmouseout="ocultar_tooltip('<?php echo  $row2['idrev']."ethdet"; ?>')" onmouseover="mostrar_tooltip('<?php echo  $row2['idrev']."ethdet"; ?>')" ><?php echo  $row2['eth_file']; ?></a>
																										   <?php if ( $row2['eht_description'] !="") {?>	
																									   <div id="tooltipfreq<?php echo  $losdatos[0].$losdatos[1].$losdatos[2].$row2['idrev']."ethdet"; ?>" name="tooltipfreq<?php echo  $row2['idrev']."ethdet"; ?>" class='d-none tooltipmarco text-left texto9' role='tooltip'> <?php echo  $row2['eht_description']; ?> </div>
																									   <?php } ?>
																									   </td>
																						   
																						   
																					   
																   
																						   
																							<?php
																							   
																							} 

																							
																							
																							if ($entro=="N")
																							{
																								echo "<br>";
																								if  ($indparamaxregxrma == 0)
																								{
																									?>
																									  <table class="table table-sm" name="exampledin<?php echo trim($row2['idbandgroup']); ?>" id="exampledin<?php echo trim($row2['idbandgroup']); ?>">
																									<?php
																								}
																								?>
																								<tr>
																								   <td colspan=7 class="text-center">  No associated Fw found.
																								   </td>
																								</tr>
																								<?php
																									if  ($indparamaxregxrma == 0)
																									{
																										?>
																										  </table>
																										<?php
																									}
																									//// Buscamos las ramas.. y mostramosss
																									$sqlrecorrer = $connect->prepare(" select distinct products_branch.description, business_branch_tree.iduniquebranchprodson
																									from products_branch 
																									
																									inner join business_branch_tree
																									on business_branch_tree.idprodbranchson = products_branch.idproductsbranch
																								
																								
																									where havefw ='Y' and  business_branch_tree.iduniquebranchprod = '".str_replace("a","",str_replace("a","",$_REQUEST['p0']))."'  ");

																				
																										$sqlrecorrer->execute();
																										$resultadoramas = $sqlrecorrer->fetchAll();
																									
																										foreach ($resultadoramas as $rowramas2) 
																										{
																											 //// Si no encontramos para la rama datos.. entramos  1 nivel y buscamos datos..de FW
																											print show_firmware_bybranch(str_replace("a","",$rowramas2['iduniquebranchprodson']),$rowramas2['description']) ;
															

																//	print factorial(10);
																//	print factorial(10);
																										}
																							}
																							?>	
																   
																						   
																																					
															 </tbody>
														   </table>
														   
														   <?php
													
														   ?>
   
															   
														   </div>
															   </div>
															   <!--end load firmware -->
														   <br>
														   
														   	<!--start load firmware -->
														<!--start load firmware -->
														<div class="container-fluid" id="divaddfirmware<?php echo 	$indxtablaadd ; ?>" name="divaddfirmware<?php echo 	$indxtablaadd ; ?>">		

<p>
<?php
	if ($entro=="S")
	{
?>
<a class="btn btn-block btn-outline-primary btn-xs" data-toggle="collapse" href="#collapseExample<?php echo 	$indxtablaadd ; ?>" role="button" aria-expanded="false" aria-controls="collapseExample<?php echo 	$indxtablaadd ; ?>">
		<label class="colorazulfiplex"><b>Add Firmware :</b> </label>	
</a>



</button>
</p>
<?php

$mostrarabierto="";
$filtros=$_REQUEST['filtmm'];
if ($filtros=="Y")
{
	$mostrarabierto=" show";
}

$idfiltradoempresa=$_REQUEST['idfilidb'];
$idfultradociu=$_REQUEST['idcc'];
$filtrosidatt=$_REQUEST['idatt'];


 
$lasempresasfiltradas = explode(",", $idfiltradoempresa);
$lasciufiltradas = explode(",", $idfultradociu);
$lasatribufiltradas = explode(",", $filtrosidatt);

?>
<div class="collapse <?php echo $mostrarabierto; ?>" id="collapseExample<?php echo 	$indxtablaadd ; ?>">
<div class="card card-body">
	
	
	
		<div class="row " id="firmwarestand" name="firmwarestand">	
			<div class="form-group col-md-4">
			
			<label for="exampleInputEmail1">FPGA FAS:</label>
					<input type="text" name="txtfpgafwadd<?php echo 	$indxtablaadd ; ?>"  id="txtfpgafwadd<?php echo 	$indxtablaadd ; ?>" class="form-control form-control-sm" placeholder="FPGA version " required="" oninvalid="setCustomValidity('FPGA Number is required.')" oninput="setCustomValidity('')" value="<?php echo $vvfpga_fas_temp;?>">	
			</div>
			<div class="form-group col-md-4">
				
				<label for="exampleInputEmail1">uC FAS:</label>
					<input type="text" name="txtucfwadd<?php echo 	$indxtablaadd ; ?>"  id="txtucfwadd<?php echo 	$indxtablaadd ; ?>" class="form-control form-control-sm" placeholder="uC version" required="" oninvalid="setCustomValidity('uC Number is required.')" oninput="setCustomValidity('')" value="<?php echo $vvmicro_fas_temp;?>">	
				
			</div>
			
			
				
											
			<div class="form-group col-md-4">
			
			<label for="exampleInputEmail1">Ethernet FAS:</label>
					<input type="text" name="txtetherfasfwadd<?php echo 	$indxtablaadd ; ?>"  id="txtetherfasfwadd<?php echo 	$indxtablaadd ; ?>" class="form-control form-control-sm" placeholder="Eth version " required="" oninvalid="setCustomValidity('Eth Number is required.')" oninput="setCustomValidity('')" value="<?php echo $vveth_fas_temp;?>">	
			</div>
			
		</div>
		<div class="row" id="firmwarecustom" name="firmwarecustom">	
			<div class="form-group col-md-4">
			
			<label for="exampleInputEmail1">FPGA File Name:</label>
					<input type="text" name="txtfpgafasfwadd<?php echo 	$indxtablaadd ; ?>"  id="txtfpgafasfwadd<?php echo 	$indxtablaadd ; ?>" class="form-control form-control-sm" placeholder="FPGA File Name Custom" required="" oninvalid="setCustomValidity('FPGA is required Custom.')" oninput="setCustomValidity('')" value="<?php echo $vvfpga_file_temp;?>">	
			</div>
			<div class="form-group col-md-4">
				
				<label for="exampleInputEmail1">Uc File Name :</label>
					<input type="text" name="txtucfasfwadd<?php echo 	$indxtablaadd ; ?>"  id="txtucfasfwadd<?php echo 	$indxtablaadd ; ?>" class="form-control form-control-sm" placeholder="Uc File Name Custom" required="" oninvalid="setCustomValidity(uC is required Custom.')" oninput="setCustomValidity('')" value="<?php echo $vvmicro_file_temp;?>">	
				
			</div>
			<div class="form-group col-md-4">
			
			<label for="exampleInputEmail1">Ethernet File Name:</label>
					<input type="text" name="txtetherfwadd<?php echo 	$indxtablaadd ; ?>"  id="txtetherfwadd<?php echo 	$indxtablaadd ; ?>" class="form-control form-control-sm" placeholder="Ethernet File Name Custom" required="" oninvalid="setCustomValidity('Ether is required Custom.')" oninput="setCustomValidity('')" value="<?php echo $vveth_file_temp;?>">	
			</div>
		
		</div>
		<div class="row" id="firmwarecustom" name="firmwarecustom">	
			<div class="form-group col-md-4">
			
			<label for="exampleInputEmail1">FPGA Upgrade Description:</label>
					<input type="text" name="txtfpgacusdescripupg<?php echo 	$indxtablaadd ; ?>"  id="txtfpgacusdescripupg<?php echo 	$indxtablaadd ; ?>" class="form-control form-control-sm" placeholder="FPGA upgrade description" required="" oninvalid="setCustomValidity('FPGA is required Custom.')" oninput="setCustomValidity('')" value="">	
			</div>
			<div class="form-group col-md-4">
				
				<label for="exampleInputEmail1">Uc Upgrade Description:</label>
					<input type="text" name="txtuccusdescripupg<?php echo 	$indxtablaadd ; ?>"  id="txtuccusdescripupg<?php echo 	$indxtablaadd ; ?>" class="form-control form-control-sm" placeholder="Uc upgrade description" required="" oninvalid="setCustomValidity(uC is required Custom.')" oninput="setCustomValidity('')" value="">	
				
			</div>
			<div class="form-group col-md-4">
			
			<label for="exampleInputEmail1">Ethernet Upgrade Description:</label>
					<input type="text" name="txtethercusdescripupg<?php echo 	$indxtablaadd ; ?>"  id="txtethercusdescripupg<?php echo 	$indxtablaadd ; ?>" class="form-control form-control-sm" placeholder="Ethernet upgrade description" required="" oninvalid="setCustomValidity('Ether is required Custom.')" oninput="setCustomValidity('')" value="">	
			</div>
	<!--		<div class="form-group col-md-12 ">
			<label for="exampleInputEmail1">Cal String  :</label>
<input type="text" name="calstringfw" id="calstringfw" class="form-control " placeholder="Enter Cal String" required oninvalid="setCustomValidity('FPGA is required.')" 
oninput="setCustomValidity('')" value="<?php // echo $vvvcalstring;?>">
				
			</div>-->
			<div class="form-group col-md-12 ">
			<b>Quick filters:</b>
			<table class="table table-striped">
				 <tr>
				 <td>
                        <label>Select Business</label>
                        <select multiple="" class="form-control form-control-sm" name="lasempresas" id="lasempresas"  >
						<?php
												 					
																

																	 $sql = $connect->prepare("select * from business where active= 'true' order by namebusiness");
																	  
																											 $sql->execute();
																											 $resultado3 = $sql->fetchAll();
																											 foreach ($resultado3 as $row2) 
																											  {
																												  $autoselect = '';
																												  if ( array_search($row2['idbusiness'], $lasempresasfiltradas)>=0 )
																												  {
																													$autoselect = 'selected';
																												  }
																												 echo "*************". array_search($row2['idbusiness'], $lasempresasfiltradas);
																											  ?>
																											  <option value="<?php echo  $row2['idbusiness']; ?>" <?php echo $autoselect;?>>
																											  <?php echo  $row2['namebusiness']; ?>
																											  </option>
																											  <?php
																											  }
					
																	 ?>
                        </select>
                </td>
				<td>
                        <label>Select CIU</label>
                        <select multiple="" class="form-control form-control-sm" name="loscius" id="loscius"  >
						<?php
												 					

																	 $losarraydeempresas2 = array("a0001", "a0004", "a0005", "a0007", "a0008");
																	 $branch_to_search2 = str_replace($losarraydeempresas2, "%", $_REQUEST['p0']);
														 
																					 $sqlprod = $connect->prepare(" select distinct idproduct, modelciu
																					 from products
																					 inner join business
																					 on business.idbusiness = products.idbusiness
																					 where iduniquebranchsonprod like '".str_replace("a","",$branch_to_search2)."%' order by modelciu  ");
																				 

																											 $sqlprod->execute();
																											 $resultado3 = $sqlprod->fetchAll();
																											 foreach ($resultado3 as $row2) 
																											  {
																												  $autoselect = '';
																												  if ( array_search($row2['idproduct'], $lasciufiltradas)>=0 )
																												  {
																													$autoselect = 'selected';
																												  }
																												 
																											  ?>
																											  <option value="<?php echo  $row2['idproduct']; ?>" <?php echo $autoselect;?>>
																											  <?php echo  $row2['modelciu']; ?>
																											  </option>
																											  <?php
																											  }
					
																	 ?>
                        </select>
						</td>
				<td>
                        <label>Select Attributes</label>
                        <select multiple="" class="form-control form-control-sm" name="losatributos" id="losatributos"  ">
						 
												 <?php
												 					

												 $sql = $connect->prepare("select * from products_attributes_type where datatype= 'boolean' and idattribute in(0,2)  order by attributename");
												  
																						 $sql->execute();
																						 $resultado3 = $sql->fetchAll();
																						 foreach ($resultado3 as $row2) 
																						  {
																							  $autoselect = '';
																							  $autoselect = '';
																							  if ( array_search($row2['idattribute'], $lasatribufiltradas)>=0 )
																							  {
																								$autoselect = 'selected';
																							  }
																							 
																						  ?>
																						  <option value="<?php echo  $row2['idattribute']; ?>" <?php echo $autoselect;?>>
																						  <?php echo  $row2['attributename']; ?>
																						  </option>
																						  <?php
																						  }

												 ?>
                        </select>
						</td>
		
				</tr>
				<tr>
				<td colspan="3"> <button type="button" class="btn btn-block btn-outline-primary btn-xs" onclick="mostrar_datos_fw_confiltradoo(<?php echo 	$indxtablaadd; ?>)">Apply Filters</button> </td>
				</tr>
				</table>	
					  <hr>
					<!-- tabla producto a updatear 3333  -->
					<table class="table table-striped table-bordered table-sm" name="tblfilter<?php echo 	$indxtablaadd; ?>" id="tblfilter<?php echo 	$indxtablaadd; ?>">
					<thead>
						<tr>
						<th class="bg-primary">Business</th>
						<th class="bg-primary">CIU</th>
						<th class="bg-primary">Update Fpga</th>
						<th class="bg-primary">Update Uc</th>
						<th class="bg-primary">Update Ethernet </th>
					</thead>
					<tbody>
					<?php
			 
			 $losarraydeempresas = array("a0001", "a0004", "a0005", "a0007", "a0008");
			$branch_to_search = str_replace($losarraydeempresas, "%", $_REQUEST['p0']);
			$sumoalhere = "";
			$sumoalhere2="";
			$sumoalhere3="";
			if ($idfiltradoempresa <>"")
			{
				$sumoalhere = " and   products.idbusiness in (".$idfiltradoempresa.") ";
			}
			if ($idfultradociu <>"")
			{
				$sumoalhere2 = " and   products.idproduct in (".$idfultradociu.") ";
			}
			if ($filtrosidatt <>"")
			{
				$sumoalhere3 = " and   products.idproduct in ( select idproduct
															from products_attributes
															inner join 
															(
																selec idproduct , max(datemodif) as maxdatemodif 
																from products_attributes
																 where idattribute in (".$filtrosidatt.") group by idproduct
															) as maxxiprod
															maxxiprod.idproduct    = products_attributes.idproduct and 
															maxxiprod.maxdatemodif = products_attributes.datemodif
															where v_boolean = true ) ";
			}
		 
		 

							$sqlprod = $connect->prepare("
							select distinct idproduct, modelciu, products.idbusiness , namebusiness
							from products
							inner join business
							on business.idbusiness = products.idbusiness
							where iduniquebranchsonprod like '".str_replace("a","",$branch_to_search)."%'  ".$sumoalhere.$sumoalhere2.$sumoalhere3);

						 

							$sqlprod->execute();
							$resultadoprod = $sqlprod->fetchAll();
						    $mostramosciu =0;														  	
							foreach ($resultadoprod as $rowprod) 
							{
								$mostramosciu =1;		
								?>
										<tr>
							<td><input name="chkprod[]" id="chkprod<?php echo 	$indxtablaadd."#".$rowprod['idproduct']."#".$rowprod['idbusiness'] ; ?>" value="chkprod<?php echo 	$indxtablaadd."#".$rowprod['idproduct']."#".$rowprod['idbusiness'] ; ?>"  class="" type="checkbox" checked=""> <?php echo  $rowprod['namebusiness'];  ?></td>
							<td><?php echo  $rowprod['modelciu'];  ?></td>
							<td><input class="" type="checkbox" checked=""></td>
							<td><input class="" type="checkbox" checked=""></td>
							<td><input class="" type="checkbox" checked=""></td>
						</tr>
								<?php

							}

							if (  $mostramosciu ==1)
							{
								?>
								<script type="text/javascript">
												var	tblfilter =		 $('#tblfilter<?php echo trim($indxtablaadd); ?>').DataTable({searching: true, paging: false, info: true} );
														 /////	$('#tblfilter0').dataTable({searching: false, paging: true, info: true});  
													///	 console.log('SIIII');
													//	 buscadatos (0,'FIPLEX');
													//	$('input[type=search]').addClass('d-none');
												////	$('.dataTables_filter').addClass('d-none');
												////	dataTables_filter
														   </script>

							
								<?php

							}
					?>
				
				 
					</tbody>
					</table>
					<!-- fin tabla producto a updatear 3333-->
			</div>
				<div class="form-group col-md-12 ">
				<input type="hidden" name="idramon<?php echo 	$indxtablaadd ; ?>" id="idramon<?php echo 	$indxtablaadd ; ?>" value="<?php echo  $_REQUEST['p0']."#".$vvidproductsbranch; ?>">
				<input type="hidden" name="idfrm<?php echo 	$idbranchtosearch.$indxtablaadd ; ?>" id="idfrm<?php echo 	$idbranchtosearch.$indxtablaadd ; ?>" value="<?php echo  $vvidfas_firmwarelist; ?>">
				<button name="btnaddband<?php echo 	$indxtablaadd ; ?>" id="btnaddband<?php echo 	$indxtablaadd ; ?>" type="button" class="btn btn-smk btn-block btn-outline-primary btn-flat btn-sm" onclick="save_add_registro_type_fw('<?php echo 	$indxtablaadd ; ?>')">Upgrade Firmware</button>
				
				
			</div>
	
</div>
</div>


			
		</div>
			</div>
			<!--end load firmware -->
			<!--end load firmware -->
		<br>
														   <?php
														   if ($cantdenegritas>1)
														   {
														   
														   ?>
														   <script>
															 $('#exampledin<?php echo trim($row2['idbandgroup']); ?>').DataTable( {
																			   "order": [[ 0, "desc" ]]
																		   } );
																		   
															   console.log(' fin#exampledin<?php echo trim($row2['idbandgroup']); ?>')		;	
														   </script>
														   <?php
													   }


													/*   function  show_firmware_bybranch(idbranhcabuscar)
													   {
														   echo "HOLAAAAAAAAAAAAAA";
														  
													   }

													   
*/

	}

function factorial($v) 
{
	if ($v === 0) 
	{
		echo "1<br>";
		return 1;
	
	}
	else
	{
		echo $v."<br>";
		return $v * factorial($v-1);
		 
	}
		
}

/*
var arr = $('[name="chkprod[]"]:checked').map(function(){
      return this.value;
    }).get();
    
    var str = arr.join(',');
    
    $('#arr').text(JSON.stringify(arr));
    
    $('#str').text(str);
	*/
														?>
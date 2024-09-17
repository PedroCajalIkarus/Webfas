<?php
	include("db_conect.php"); 

	$v_param = $_REQUEST['p0'];
	 $v_param = str_replace('a','', $v_param);
	 

	$query_lista="select * from sap_operations where idoperation=  ".$v_param;
	 $data = $connect->query($query_lista)->fetchAll();	
	foreach ($data as $rowmm) 
	{
		echo "<b>Description: ".$rowmm['descripoperation']."</b>";
		$nombre_ope  = $rowmm['nameoperation'];
	}		

?>
  
<div class="row">
	
    <div class="col-4">

		<div id="viewfirmwarelist" name="viewfirmwarelist" class=" " style="">
     
			<div class="custom-control custom-switch custom-switch-on-success custom-switch-off-danger">
										<input type="checkbox" class="custom-control-input" onchange="cambiarestado(1,4,1,'B')" id="customSwitch4" checked="">
										<label class="custom-control-label" for="customSwitch4">Active</label>

											
				</div>	 
				<hr>  
				<div class="custom-control custom-switch custom-switch-on-success custom-switch-off-danger">
										<input type="checkbox" class="custom-control-input" onchange="cambiarestado(1,4,1,'B')" id="customSwitch4" checked="">
										<label class="custom-control-label" for="customSwitch4">Export XML to SAP</label>

											
				</div>	
		</div>	
	</div>
    <div class="col-8">
		<p aling='left'><h5>List of groups associated with an operation </h5></p>
	<table class="table table-striped   table-sm" name="exampledin24" id="exampledin24">
		<thead>
	 	<tr>
			<th class="bg-primary">Operation</th>
			<th class="bg-primary">BRP Groups</th>
			<th class="bg-primary">Actions</th>
		</tr>	
		</thead>
		<body>
<?php
	$Sql_ifupgrade2 = $connect->prepare(" select * from sap_brp_operations where idoperation =  ". $v_param );                                 
	$Sql_ifupgrade2->execute();
	$result_ifup2 = $Sql_ifupgrade2->fetchAll();	
	foreach ($result_ifup2 as $row_up2)
	{
		?>
		<tr>
			<td class=""><?php echo $nombre_ope; ?></td> 
			<td class=""><?php echo $row_up2['idbrpgroup']; ?></td> 
			<td class=" ">
			<div class="custom-control custom-switch custom-switch-on-success custom-switch-off-danger">
										<input type="checkbox" class="custom-control-input" onchange="cambiarestado(1,4,1,'B')" id="customSwitch<?php   echo $row_up2['idbrpgroup'].$row_up2['idoperation'] ?>" checked="">
										<label class="custom-control-label" for="customSwitch4">Active</label>


											
				</div>	
			 </td> 
		</tr>	

		<?php
	}	

?>
		</body>
	</table>



	</div>
  </div>




<table class="table table-sm" name="exampledin" id="exampledin">

<br><hr style=" border-top: 2px solid #f39323;"><h4 class="card-title colorazulfiplex"> 
<i class="jstree-icon jstree-themeicon fa fa-inbox jstree-themeicon-custom"></i> ::: Products Group ::: </h4>	 	
 
<table class="table table-striped table-bordered table-sm" name="exampledin24" id="exampledin24">
<thead>
<tr>
 

</tr></tbody></table>			

	<!-- ---COMPONENTE FILTRADORRRRR----------------------------->
	<div class="form-group col-md-12 ">
			<b>Quick filters:</b>
			<table class="table table-striped">
				 <tr>
				 <td>
                        <label>Select Business</label>
                        <select multiple="" class="form-control form-control-sm" name="lasempresas" id="lasempresas"    >
						<option value="" >ALL Business </option>
						<?php
												 					
																

																	 $sql = $connect->prepare("select * from business where active= 'true' order by namebusiness");
																	  
																											 $sql->execute();
																											 $resultado3 = $sql->fetchAll();
																											 foreach ($resultado3 as $row2) 
																											  {
																												  $autoselect = '';
																												//  echo $lasempresasfiltradas."a ver".array_search($row2['idbusiness'], $lasempresasfiltradas);																												  
																												  if(strlen($lasempresasfiltradas) >0)
																												  {
																													 	
																													if ( array_search($row2['idbusiness'], $lasempresasfiltradas)>=0 )
																													{
																											//		  $autoselect = 'selected';
																													}
																												  }
																												  
																												// echo "*************". array_search($row2['idbusiness'], $lasempresasfiltradas);
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
                        <label>Select Bands</label>
                        <select multiple="" class="form-control form-control-sm" name="lasbandas" id="lasbandas"   >
						<option value="" >ALL Bands</option>
						<?php
												 					
																

																	 $sql = $connect->prepare("select * from idband where active= 'Y' order by description");
																	  
																											 $sql->execute();
																											 $resultado3 = $sql->fetchAll();
																											 foreach ($resultado3 as $row2) 
																											  {
																												  $autoselect = '';
																												  if ( array_search($row2['idband'], $lasbandasfiltradas)>=0 )
																												  {
																												//	$autoselect = 'selected';
																												  }
																												// echo "*************". array_search($row2['idbusiness'], $lasempresasfiltradas);
																											  ?>
																											  <option value="<?php echo  $row2['idband']; ?>" <?php echo $autoselect;?>>
																											  <?php echo  $row2['description']; ?>
																											  </option>
																											  <?php
																											  }
					
																	 ?>
                        </select>
                </td>
				 
				<td>
                        <label>Select Branchs</label>
					

                        <select multiple="" class="form-control form-control-sm" name="losbranchs" id="losbranchs"   >
					  				 <option value=""> All Branchs </option>
																	 <?php
																	 
																
																	/// BRANCHS GENERICOS A MANO OJOO
																	 $sql = $connect->prepare("
																	 select * from
																	 (
																	 select  public.full_tree_namever(iduniquebranchprodson, '') as stringtree, iduniquebranchprodson
																	 from (
																		 select  distinct iduniquebranchprodson
																													  from business_branch_tree
																													  inner join products_branch
																													  on products_branch.idproductsbranch = business_branch_tree.idprodbranchson 
																													  inner join products_branch as products_branchpp
																													  on products_branchpp.idproductsbranch = business_branch_tree.idprodbranchfather  
																											  where products_branch.active='Y' and idbusiness =1 
																		  
																											  
																	 ) as viewtree
																	 ) as alltree
																	 where stringtree like '%XXXXXXXUNIT%' and
																--	 stringtree not like '%700%' and
																--	 stringtree not like '%800%' and
																	 stringtree not like '%HF%' and
																	  stringtree not like '%RACK%' and
																	 ( stringtree like '%BDA%' or stringtree like '%DAS%' ) 
																	 order by stringtree
																	  ");
																	  
																											 $sql->execute();
																											 $resultado3 = $sql->fetchAll();
																											 foreach ($resultado3 as $row2) 
																											  {
																												 if ( $row2['stringtree'] != '')
																												 {
																											  ?>
																											  <option value="<?php echo  $row2['iduniquebranchprodson']; ?>">
																											  <?php
																												 $nomfather =   $row2['stringtree'];
																											 
					
																											  echo  $nomfather; ?>
																											  </option>
																											  <?php
																												 }
																											  }
					
																	 ?>


<option value="000100370039">
UNIT --&gt; FLEX --&gt; BDA																											  </option>
<option value="0001003700390043">
UNIT --&gt; FLEX --&gt; BDA --&gt; 700/800																											  </option>
<option value="00010037003900430045">
UNIT --&gt; FLEX --&gt; BDA --&gt; 700/800 --&gt;  DUAL BAND																											  </option>
<option value="00010037003900430046">
UNIT --&gt; FLEX --&gt; BDA --&gt; 700/800 --&gt; SINGLE 700																											  </option>
<option value="00010037003900430047">
UNIT --&gt; FLEX --&gt; BDA --&gt; 700/800 --&gt;  SINGLE 800																											  </option>
<option value="000100370040">
UNIT --&gt; FLEX --&gt; DAS																											  </option>
<option value="0001003700400049">
UNIT --&gt; FLEX --&gt; DAS --&gt; ENTERPRISE																											  </option>
<option value="00010037004000490052">
UNIT --&gt; FLEX --&gt; DAS --&gt; ENTERPRISE --&gt; MASTER																											  </option>
<option value="000100370040004900520054">
UNIT --&gt; FLEX --&gt; DAS --&gt; ENTERPRISE --&gt; MASTER --&gt; 700/800																											  </option>
<option value="00010037004000490053">
UNIT --&gt; FLEX --&gt; DAS --&gt; ENTERPRISE --&gt; REMOTE																											  </option>
<option value="000100370040004900530061">
UNIT --&gt; FLEX --&gt; DAS --&gt; ENTERPRISE --&gt; REMOTE --&gt; 700/800																											  </option>
<option value="0001003700400048">
UNIT --&gt; FLEX --&gt; DAS --&gt; PCS																											  </option>
<option value="00010037004000480050">
UNIT --&gt; FLEX --&gt; DAS --&gt; PCS --&gt; MASTER																											  </option>
<option value="000100370040004800500057">
UNIT --&gt; FLEX --&gt; DAS --&gt; PCS --&gt; MASTER --&gt; 700/800																											  </option>
<option value="00010037004000480051">
UNIT --&gt; FLEX --&gt; DAS --&gt; PCS --&gt; REMOTE																											  </option>
<option value="000100370040004800510059">
UNIT --&gt; FLEX --&gt; DAS --&gt; PCS --&gt; REMOTE --&gt; 700/800																											  </option>

<option value="00010037003900440108">
UNIT --> FLEX --> BDA --> VHF/UHF --> TETRA																									  </option>
<option value="0001003700400048005000580111">
UNIT --> FLEX --> DAS --> PSC --> MASTER --> RACK MOUNT --> TETRA																								  </option>
<option value="0001003700400048005000560109">
UNIT --> FLEX --> DAS --> PSC --> MASTER --> VHF/UHF --> TETRA																								  </option>
<option value="0001003700400048005100600110">
UNIT --> FLEX --> DAS --> PSC --> REMOTE --> VHF/UHF --> TETRA																							  </option>
																
<option value="00010002001300350068">
MODULE --&gt; DIGITAL BOARD --&gt; FLEX --&gt; BDA																										  </option>
<option value="00010002001300350036">
MODULE --&gt; DIGITAL BOARD --&gt; FLEX --&gt; DAS																										  </option>
																
<option value="000200130035006800340112">
MODULE --&gt; DIGITAL BOARD --&gt; FLEX --&gt; BDA --&gt; VHF/UHF --&gt; TETRA																									  </option>
																
																
                        </select>
						</td>
				<td>
                        <label>Select Attributes</label>
                        <select multiple="" class="form-control form-control-sm" name="losatributos" id="losatributos"    >

					


						<option value=""> All Attributes </option>
												 <?php
												 			
									list_all_attributes_wizard();

												 ?>
                        </select>
						</td>
					 
					
		
				</tr>
				<tr>
				<td colspan="6"> <button type="button" class="btn btn-block btn-outline-primary btn-xs" onclick="filtrartodo()" >Apply Filters</button> </td>
				</tr>
				</table>	
					 

					  </div>	
              
			  </section></div>	
			  <!-- tabla band a updatear 222222  -->  
			  <div class="card">
			  <p align="right">
						<button name="btnopenrf" id="btnopenrf" type="button" class="btn btn-smk btn-block btn-outline-primary btn-flat" onclick="opendiv('dibbandyrf')">Modify Specifications</button>
					</p>
				  <div class="form-group col-md-12 d-none" id="dibbandyrf" name="dibbandyrf">
				
				  <span class="colorazulfiplex"><b> Firmware List:</b> </span>
				  <select  class="form-control form-control-sm" name="losfirmwarelist" id="losfirmwarelist" onchange="buscardatosfirmware(this.value)"   >
				  <option value=""> - Select - </option>
				  <?php
												 					
																	 $indxtablaadd=0;
												 $sql = $connect->prepare("select * from fnt_select_allfas_firmwarelist_maxrev() where active = 'Y'  order by namefirmware");
												  
																						 $sql->execute();
																						 $resultado3 = $sql->fetchAll();
																						 foreach ($resultado3 as $row2) 
																						  {
																							 
																							 
																						  ?>
																						  <option value="<?php echo  $row2['idfas_firmwarelist']; ?>" >
																						  <?php echo  $row2['namefirmware']; ?>
																						  </option>
																						  <?php
																						  }

												 ?>
					</select>							 
				  	<br><br>

				  <table class="table   table-bordered table-sm ">
						<tr>
					  	    <td>	<label for="exampleInputEmail1">Fpga File:</label>   <button type="button" class="btn btn-xs btn-default" onclick="hablitame('divtxtfpgafile')" name="btntxtfpgafile" id="btntxtfpgafile"> <i class="fas fa-edit"></i> Edit </button> </td>
							<td>	<label for="exampleInputEmail1">Micro File:</label>   <button type="button" class="btn btn-xs btn-default" onclick="hablitame('divtxtmicrofile')" name="btntxtmicrofile" id="btntxtmicrofile"> <i class="fas fa-edit"></i> Edit </button> </td>
							<td>	<label for="exampleInputEmail1">Eth File:</label>   <button type="button" class="btn btn-xs btn-default" onclick="hablitame('divtxtethfile')" name="btntxtethfile" id="btntxtethfile"> <i class="fas fa-edit"></i> Edit </button> </td>
							<td>	<label for="exampleInputEmail1">Fpga Fas:</label>   <button type="button" class="btn btn-xs btn-default" onclick="hablitame('divtxtfpgafas')" name="btntxtfpgafas" id="btntxtfpgafas"> <i class="fas fa-edit"></i> Edit </button> </td>
							<td>	<label for="exampleInputEmail1">Micro Fas:</label>   <button type="button" class="btn btn-xs btn-default" onclick="hablitame('divtxtmicrofas')" name="btntxtmicrofas" id="btntxtmicrofas"> <i class="fas fa-edit"></i> Edit </button> </td>
							<td>	<label for="exampleInputEmail1">Eth Fas:</label>   <button type="button" class="btn btn-xs btn-default" onclick="hablitame('divtxtethfas')" name="btntxtethfas" id="btntxtethfas"> <i class="fas fa-edit"></i> Edit </button> </td>
							<td>	<label for="exampleInputEmail1">Calr String:</label>   <button type="button" class="btn btn-xs btn-default" onclick="hablitame('divtxtcalrstring')" name="btntxtcalrstring" id="btntxtcalrstring"> <i class="fas fa-edit"></i> Edit </button> </td>
					    </tr>
				  </table>
							<div class="row">
						 	
									<div class="form-group col-md-6 d-none" id="divtxtfpgafile" name="divtxtfpgafile">
										<label for="exampleInputEmail1">Fpga File:</label> 										
										<input type="text" name="txtfpgafile" disabled id="txtfpgafile" class="form-control form-control-sm  " value="">	
										<input type="hidden" name="txtfpgafiler" disabled   id="txtfpgafiler" class="form-control form-control-sm  " value="">	
									</div>	
									<div class="form-group col-md-6 d-none" id="divtxtmicrofile" name="divtxtmicrofile">
										<label for="exampleInputEmail1">Micro File:</label> 										
										<input type="text" name="txtmicrofile" disabled id="txtmicrofile" class="form-control form-control-sm  " value="">	
										<input type="hidden" name="txtmicrofiler" disabled   id="txtmicrofiler" class="form-control form-control-sm  " value="">	
									</div>
									<div class="form-group col-md-6 d-none" id="divtxtethfile" name="divtxtethfile">
										<label for="exampleInputEmail1">Eth File:</label> 										
										<input type="text" name="txtethfile" disabled id="txtethfile" class="form-control form-control-sm  " value="">	
										<input type="hidden" name="txtethfiler"  disabled  id="txtethfiler" class="form-control form-control-sm  " value="">	
									</div>		
									<div class="form-group col-md-6 d-none" id="divtxtfpgafas" name="divtxtfpgafas">
										<label for="exampleInputEmail1">Fpga Fas:</label> 										
										<input type="text" name="txtfpgafas" disabled id="txtfpgafas" class="form-control form-control-sm  " value="">	
										<input type="hidden" name="txtfpgafasr" disabled  id="txtfpgafasr" class="form-control form-control-sm  " value="">	
									</div>
									<div class="form-group col-md-6 d-none" id="divtxtmicrofas" name="divtxtmicrofas">
										<label for="exampleInputEmail1">Micro Fas:</label> 										
										<input type="text" name="txtmicrofas" disabled id="txtmicrofas" class="form-control form-control-sm  " value="">	
										<input type="hidden" name="txtmicrofasr" disabled   id="txtmicrofasr" class="form-control form-control-sm  " value="">	
									</div>
									<div class="form-group col-md-6 d-none" id="divtxtethfas" name="divtxtethfas">
										<label for="exampleInputEmail1">Eth Fas:</label> 										
										<input type="text" name="txtethfas" disabled id="txtethfas" class="form-control form-control-sm  " value="">	
										<input type="hidden" name="txtethfasr" disabled  id="txtethfasr" class="form-control form-control-sm  " value="">	
									</div>
									<div class="form-group col-md-6 d-none" id="divtxtcalrstring" name="divtxtcalrstring">
										<label for="exampleInputEmail1">Calr String:</label> 										
										<input type="text" name="txtcalrstring" disabled   id="txtcalrstring" class="form-control form-control-sm  " value="">	
										<input type="hidden" name="txtcalrstringr" disabled  id="txtcalrstringr" class="form-control form-control-sm  " value="">	
									</div>
							 
									
									<div class="form-group col-md-12">
									<?php if ( $_SESSION["g"] == "develop" ) 
									{
										?>
											<p align="right">
												<button name="btnaddband" id="btnaddband" type="button" class="btn btn-smk btn-block btn-outline-primary btn-flat" onclick="update_selected_ciu(); ">Update selected CIU</button>
											</p>
											<?php } ?>
											<div id="divlist_tabla_gain_rf" name="divlist_tabla_gain_rf">
											</div>
											<input type="hidden" name="divlist_tabla_gain_rftexto" id="divlist_tabla_gain_rftexto" value="">
									</div>
									
							</div>
					</div>
						<!-- end  - Definition of bands  -->					  	

				  </div>
			   </div>
			   <!--  fintabla band a updatear 222222  -->

			  <div class="card">
				  <div class="form-group col-md-12">
							<!-- tabla producto a updatear 3333  -->
							<div id="tblfilterdiv" name="tblfilterdiv">
						 
							<!-- fin tabla producto a updatear 3333-->
							</div>	
						</div>
					</div>	
			</div>
			
					<!-- --FIN COMPONENTE FILTRADORRR------------------------------>
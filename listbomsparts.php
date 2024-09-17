<?php


	include("db_conect.php"); 
																
	$idboms = $_REQUEST['p0'];

?>	

<div class="table-responsive">
														  <table class="table table-striped table-bordered table-sm" name="example2" id="example2">
				  <thead>
					<tr>
					 <th class="bg-primary">BOMS Components</th>
					  <th class="bg-primary">Comp Description </th>
					  <th class="bg-primary">Comp Vendors</th>
					  <th class="bg-primary">Class</th>
					  
					  <th class="bg-primary">Quantity</th>
						
						
					 
										 
					</tr>
				  </thead>
				  <tbody>
														 														
													
														
		  <?php
		  
		  	$query_lista = "select distinct boms_parts.* , boms.quantity as quantity2 , boms_vendors.namebomsvendor
			  from boms
			  inner join boms_parts
			  on boms_parts.idbomsparts  = boms.idbomsparts 
			  inner join boms_vendors
			  on boms_vendors.idboms_vendor = boms_parts.vendor_id
where  boms.idboms = ".	$idboms;
$cantdenegritas = 0;
						
	$datacomp = $connect->query($query_lista)->fetchAll();	
	foreach ($datacomp as $rowcomp) {			

		$cantdenegritas = $cantdenegritas+ 1;
				?>
				<tr>
					<td  class="text-center"> <?php echo $rowcomp['partnumber'];?></td>
					<td > <?php echo $rowcomp['partdescription'];?></td>
					<td > <?php echo $rowcomp['namebomsvendor'];?></td>
					<td > <?php
					if ($rowcomp['partclass'] !='null')
					{
						echo $rowcomp['partclass'];
					}?></td>
					<td  class="text-center"><?php echo $rowcomp['quantity2'];?></td>
			
				</tr>
																							 	
<?php				

	 }
		  ?>
		  
			</tbody>
			</table>
						</div>								
														

																										
														<?php if ($cantdenegritas>1)
														{
														
														?>
														<script>
														  $('#example2').DataTable( {
																		 	"order": [[ 0, "desc" ]],  "paging": true,  "pageLength": 100
																		} );
														</script>
														<?php
														}
///////
/// Segundo TABLA
//////////////////////////

														?>
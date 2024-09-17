<?php
	include("db_conect.php"); 


 ?>
									
	   
	   <br><br>
	   <b>Measures References  : </b>
	   <?php  
 $query_lista = "SELECT distinct fas_script_type.scriptname, iduniquebranchsonprod,  public.full_tree_namever_allbusiness(iduniquebranchsonprod, '') as namebranch, business.namebusiness, products.modelciu,  
 idband.description as nameband,  products.idbusiness,  products.idproduct,   
 fas_tree_product_references.idband as idbandnn, uldl, 
 fas_tree_product_references.*
 ,fas_step.description as namemeasures 
from  fnt_select_allproducts_maxrev() as  products
inner join business
on business.idbusiness = products.idbusiness
inner join fas_tree_product_references
on products.idproduct		=	fas_tree_product_references.idproduct 

inner join idband
on idband.idband = fas_tree_product_references.idband
inner join fas_tree
on fas_tree.idfastree	= fas_tree_product_references.idfastree and
fas_tree.iduniquebranch =  fas_tree_product_references.iduniquebranch
inner join fas_script_type
on fas_tree_product_references.idscripttype = fas_script_type.idscripttype
inner join fas_step
on fas_step.idfasstep =  fas_tree.idfastrepson where  products.idproduct =".str_replace("a","",$_REQUEST['p0']);
//	  echo $query_lista;
 $data = $connect->query($query_lista)->fetchAll();	
 ?>
 <table class="table table-striped table-bordered table-sm dataTable no-footer table-responsive" name="tblfilterobjbmearef<?php echo $_REQUEST['p0'];?>" id="tblfilterobjbmearef<?php echo $_REQUEST['p0'];?>" role="grid" aria-describedby="tblfilter0_info"> 
 <thead>
 <tr>
 <th class="bg-primary "> Business </th>
 <th class="bg-primary "> Branch </th>
 <th class="bg-primary "> CIU </th>
 <th class="bg-primary "> Bands </th>
 <th class="bg-primary "> UL/DL </th>
 <th class="bg-primary "> SCRIPT TYPE </th>
 <th class="bg-primary "> MEASURES </th>
 <th class="bg-primary "> NMEASURES </th>
 <th class="bg-primary "> REFERENCE 1 </th>
 <th class="bg-primary "> REFERENCE 2 </th>
 <th class="bg-primary "> REFERENCE 3 </th>
 <th class="bg-primary "> REFERENCE 4</th>
 <th class="bg-primary "> REFERENCE 5 </th>
 <th class="bg-primary "> REFERENCE 6</th>
 <th class="bg-primary "> REFERENCE 7	</th>
 <th class="bg-primary "> REFERENCE 8  </th>
 
 </tr>
 </thead>
 <tbody>
 <?php
   foreach ($data as $row2) 
   {
	$indxtablaadd=0;
	   ?>
	<td><input name="chkprod[]" id="chkprod<?php echo 	$row2['idbusiness']."#".$row2['idproduct']."#".$row2['idbandnn']."#".$row2['iduniquebranch']."#".$row2['uldl']  ; ?>" value="chkprod<?php echo 	$row2['idbusiness']."#".$row2['idproduct']."#".$row2['idbandnn']."#".$row2['iduniquebranch']."#".$row2['uldl']  ; ?>"  class="chkclassmarco" type="checkbox"  > <?php echo  $row2['namebusiness'];  ?></td>
		<?php						
	   echo "<td>".$row2['namebranch'] ."</td>";  
	   echo "<td>".$row2['modelciu']."</td>";  
	   echo "<td>".$row2['nameband']."</td>";  
	   echo "<td>".$row2['uldl']."</td>";
	   echo "<td>".$row2['scriptname']."</td>";
	   echo "<td>".$row2['namemeasures']."</td>";
	   echo "<td>".$row2['nmeasures']."</td>";
	   echo "<td>".$row2['reference1']."</td>";
	   echo "<td>".$row2['reference2']."</td>";
	   echo "<td>".$row2['reference3']."</td>";
	   
	   echo "<td>".$row2['reference4']."</td>";
	   echo "<td>".$row2['reference5']."</td>";
	   echo "<td>".$row2['reference6']."</td>";

	   echo "<td>".$row2['reference7']."</td>";
	   echo "<td>".$row2['reference8']."</td>";
	    
	  
	   echo "</tr>";
   }

?>
	</tbody>
</table>
<script type="text/javascript">
														$('#tblfilterobjbmearef<?php echo $_REQUEST['p0'];?>').DataTable({searching: true, paging: true, info: false, pageLength: 10} );
													 
																</script>
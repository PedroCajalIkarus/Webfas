<?php
 include("db_conect.php"); 
	
 
 $v_lasempresas = $_REQUEST['lasempresas'];
 $v_lasbandas = $_REQUEST['lasbandas'];
 $v_losbranchs = $_REQUEST['losbranchs'];
 $v_losatributos =  $_REQUEST['losatributos'];

 $v_losuldl =  $_REQUEST['losuldl'];
 $v_lasmediciones =  $_REQUEST['lasmediciones'];
 include("db_conect.php"); 


					if($v_losbranchs <>"" )
					{
						$losarraydeempresas = array("a0001", "a0004", "a0005", "a0007", "a0008");
						$branch_to_search = str_replace($losarraydeempresas, "%", $v_losbranchs);

						$sumoalhere4 =" and	iduniquebranchsonprod like '%".str_replace("a","",$branch_to_search)."%' ";
					}
 					if ($v_lasempresas <>"")
					{
						$sumoalhere = " and   products.idbusiness in (".$v_lasempresas.") ";
					}
					if ($v_lasbandas <>"")
					{
						$sumoalhere2 = " and   fas_tree_product_references.idband in (".$v_lasbandas.") ";
					}
					if ($v_losuldl <>"")
					{
						$sumoalhere5 = " and  uldl in (".$v_losuldl.") ";
					}
					if ($v_lasmediciones <>"")
					{
						$sumoalhere6 = " and  fas_tree_product_references.iduniquebranch like  '%".$v_lasmediciones."%' ";
					}
					if ($v_losatributos <>"")
					{
						$sumoalhere3 = " and   products.idproduct in ( select products_attributes.idproduct
																	from products_attributes
																	inner join 
																	(
																		select products_attributes.idproduct , max(datemodif) as maxdatemodif 
																		from products_attributes
																		inner join products
																		on  products.idproduct		=	products_attributes.idproduct 
																		where idattribute in (".$v_losatributos.") ".$sumoalhere.$sumoalhere4." group by products_attributes.idproduct
																	) as maxxiprod
																	on maxxiprod.idproduct    = products_attributes.idproduct and 
																	maxxiprod.maxdatemodif = products_attributes.datemodif
																	where v_boolean = true ) ";
					}

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
on fas_step.idfasstep =  fas_tree.idfastrepson ".$sumoalhere.$sumoalhere2.$sumoalhere3.$sumoalhere4.$sumoalhere5.$sumoalhere6;
//	  echo $query_lista;
 $data = $connect->query($query_lista)->fetchAll();	
 ?>
 <table class="table table-striped table-bordered table-sm dataTable no-footer" name="tblfilter0" id="tblfilter0" role="grid" aria-describedby="tblfilter0_info"> 
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
														$('#tblfilter0').DataTable({searching: true, paging: true, info: false, pageLength: 500000} );
														$("#tblfilter0_length").html('');
														$("#tblfilter0_length").html('<br>&nbsp; <a href="#" onclick="selectallmarco()">Select All </a>');
													//	$("#tblfilter0_length").html($("#tblfilter0_filter").html());
													//	$("#tblfilter0_filter").html('');
																</script>
<?php
 include("db_conect.php"); 
	
 
 $v_lasempresas = $_REQUEST['lasempresas'];
 $v_lasbandas = $_REQUEST['lasbandas'];
 $v_losbranchs = $_REQUEST['losbranchs'];
 $v_losatributos =  $_REQUEST['losatributos'];

 $v_losuldl =  $_REQUEST['losuldl'];
 $v_lasmediciones =  $_REQUEST['lasmediciones'];
 $v_laslostypeoutcome =  $_REQUEST['laslostypeoutcome'];

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
						$sumoalhere2 = " and  fas_tree_measure.band in (".$v_lasbandas.") ";
					}
					if ($v_losuldl <>"")
					{
						$sumoalhere5 = " and  fas_tree_measure.uldl in (".$v_losuldl.") ";
					}
					if ($v_lasmediciones <>"")
					{
						$sumoalhere6 = " and  fas_tree_measure.iduniquebranch like  '%".$v_lasmediciones."%' ";
					}
					if ($v_laslostypeoutcome <>"")
					{
						$sumoalhere7 = " and fas_outcome_type.idscriptoutcometype in  (".$v_laslostypeoutcome.") ";
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

 $query_lista = "select distinct fas_tree_measure.idrev, fas_tree_measure.unitsn,  fas_step.description as branchname, fas_outcome.iduniqueop,  v_boolean, v_integer, v_double, v_string, v_date, outcomedescription ,fas_tree_measure_products.idproduct, modelciu
 , public.full_tree_namever_allbusiness(iduniquebranchsonprod, '') as namebranch, business.namebusiness, fas_tree_measure.band, fas_tree_measure.uldl , totalpass
 from fas_outcome
 inner join (select * from fnt_select_allfas_tree_measure_maxrev2()  where totalpass= true)
  as fas_tree_measure
 on fas_tree_measure.iduniqueop = fas_outcome.iduniqueop
	 inner join fas_tree
		 on fas_tree.iduniquebranch = fas_tree_measure.iduniquebranch
		 and fas_tree.idfastree = 1
		 inner join fas_step
		 on fas_tree.idfastrepson = fas_step.idfasstep
		 inner join fas_outcome_type
		 on fas_outcome_type.idscriptoutcometype = fas_outcome.idscriptoutcometype
		 inner join fas_tree_measure_products
		 on fas_tree_measure_products.sn         = 	 fas_tree_measure.unitsn and
		 fas_tree_measure_products.iduniqueop	=	 fas_tree_measure.iduniqueop and
		 fas_tree_measure_products.idruninfo	    =    fas_tree_measure.idrununfo
		 inner join fnt_select_allproducts_maxrev() as  products
		 on products.idproduct = fas_tree_measure_products.idproduct
		 inner join business
		 on business.idbusiness = products.idbusiness
		 inner join fas_instruments_parameters
		 on products.idproduct		=	fas_instruments_parameters.idproduct 
	  where totalpass = true and  fas_outcome.id_ucmeasure = 0 and  products.active= 'Y' ".$sumoalhere.$sumoalhere2.$sumoalhere3.$sumoalhere4.$sumoalhere5.$sumoalhere6.$sumoalhere7 ;
	// echo $query_lista;
	  
 $data = $connect->query($query_lista)->fetchAll();	
 ?>
 <table class="table table-striped table-bordered table-sm dataTable no-footer" name="tblfilter0" id="tblfilter0" role="grid" aria-describedby="tblfilter0_info"> 
 <thead>
 <tr>
 <th class="bg-primary "> Business </th>
 
 <th class="bg-primary "> Branch </th>
 <th class="bg-primary "> UNIT SN </th>
 <th class="bg-primary "> CIU </th>
 <th class="bg-primary "> Bands </th>
 <th class="bg-primary "> UL/DL </th>
 <th class="bg-primary "> SCRIPT TYPE </th>
 <th class="bg-primary "> MEASURES </th>
 <th class="bg-primary "> IDUniqueOP </th>
 <th class="bg-primary "> v_boolean </th>
 <th class="bg-primary "> v_integer </th>
 <th class="bg-primary "> v_double </th>
 <th class="bg-primary "> v_string </th>
 <th class="bg-primary "> v_date </th>
  
 </tr>
 </thead>
 <tbody>
 <?php
   foreach ($data as $row2) 
   {
	$indxtablaadd=0;
	   ?>
	<td><input name="chkprod[]" id="chkprod<?php echo 	$row2['idbusiness']."#".$row2['idproduct']."#".$row2['idbandnn']."#".$row2['iduniquebranch']."#".$row2['uldl']  ; ?>" value="chkprod<?php echo 	$row2['idbusiness']."#".$row2['idproduct']."#".$row2['idbandnn']."#".$row2['iduniquebranch']."#".$row2['uldl']  ; ?>"  class="chkclassmarco" type="checkbox" > <?php echo  $row2['namebusiness'];  ?></td>
		<?php						
	   echo "<td>".$row2['namebranch'] ."</td>"; 
	   echo "<td>".$row2['unitsn']."</td>";   
	   echo "<td>".$row2['modelciu']."</td>";  
	   echo "<td>".$row2['band']."</td>";  
	   echo "<td>".$row2['uldl']."</td>";
	   echo "<td>".$row2['outcomedescription']."</td>";
	   echo "<td>".$row2['branchname']." -[".$row2['idrev']."]</td>";

	   echo "<td>".$row2['iduniqueop']."</td>";
	   echo "<td>".$row2['v_boolean']."</td>";
	   echo "<td>".$row2['v_integer']."</td>";
	   echo "<td>".$row2['v_double']."</td>";
	   echo "<td>".$row2['v_string']."</td>";
	  
	   echo "<td>".$row2['v_date']."</td></tr>";
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
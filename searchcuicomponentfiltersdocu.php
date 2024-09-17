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
						$sumoalhere2 = " and   objectband.idband in (".$v_lasbandas.") ";
					}
					if ($v_losuldl <>"")
					{
						$sumoalhere5 = " and  uldl in (".$v_losuldl.") ";
						$sumoalhere5 = "   ";
					}
					if ($v_lasmediciones <>"")
					{
						/// el campo mediciones en el firmware hacen refenrecia al id de la tabla  fas_firmwarelist
						$sumoalhere6 = " and  fas_tree_product_references.iduniquebranch like  '%".$v_lasmediciones."%' ";
						$sumoalhere6 = "  ";
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
																  ) ";
					}

 $query_lista = "SELECT distinct iduniquebranchsonprod,  public.full_tree_namever_allbusiness(iduniquebranchsonprod, '') as namebranch, business.namebusiness, products.modelciu,  
 idband.description as nameband,  products.idbusiness,  products.idproduct,   
 idband.idband as idbandnn,  
 fas_documentation.idrev, datedocumentation, usermanual, pp_packinglist, pp_assy, pp_wire, pp_poly, pp_label
  
from  fnt_select_allproducts_maxrev() as  products
inner join business
on business.idbusiness = products.idbusiness
inner join fnt_select_objectband_maxrev() as objectband
  on products.idproduct		=	objectband.idproduct 
left join products_attributes
on 	products.idproduct			 = products_attributes.idproduct
 inner join fnt_select_allfas_documentation_maxrev() as  fas_documentation
 on fas_documentation.idproduct = products.idproduct  
inner join idband
on idband.idband = objectband.idband 
".$sumoalhere.$sumoalhere2.$sumoalhere3.$sumoalhere4.$sumoalhere5.$sumoalhere6;
 // echo $query_lista;
 $data = $connect->query($query_lista)->fetchAll();	
 ?>
 <table class="table table-striped table-bordered table-sm dataTable no-footer" name="tblfilter0" id="tblfilter0" role="grid" aria-describedby="tblfilter0_info"> 
 <thead>
 <tr>
 <th class="bg-primary "> Business </th>
 <th class="bg-primary "> Branch </th>
 <th class="bg-primary "> CIU [Rev.Fw] </th>
 <th class="bg-primary "> Bands </th> 

 <th class="bg-primary "> User Manual </th> 
 <th class="bg-primary "> PP Pack List </th> 
 <th class="bg-primary "> PP Assy </th> 
 <th class="bg-primary "> PP Wire </th> 
 <th class="bg-primary "> PP Poly </th> 
 <th class="bg-primary "> PP Label </th> 
 
 
 </tr>
 </thead>
 <tbody>
 <?php
   foreach ($data as $row2) 
   {
	$indxtablaadd=0;
	   ?>
	<td><input name="chkprod[]" id="chkprod<?php echo 	$row2['idbusiness']."#".$row2['idproduct']."#".$row2['idrev']    ; ?>" value="chkprod<?php echo 	$row2['idbusiness']."#".$row2['idproduct']."#".$row2['idrev']   ; ?>"  class="chkclassmarco" type="checkbox" > <?php echo  $row2['namebusiness'];  ?></td>
		<?php						
	   echo "<td>".$row2['namebranch'] ."</td>";  
	   echo "<td>".$row2['modelciu']." -[".$row2['idrev']."]"."</td>";  
	   echo "<td>".$row2['nameband']."</td>";   
	   echo "<td>".$row2['usermanual']."</td>";
	   echo "<td>".$row2['pp_packinglist']."</td>";
	   echo "<td>".$row2['pp_assy']."</td>";
	   echo "<td>".$row2['pp_wire']."</td>";
	   echo "<td>".$row2['pp_poly']."</td>";	  
	   echo "<td>".$row2['pp_label']."</td>";	  
	   echo "</tr>";
	   
  
   }

?>
	</tbody>
</table>
<script type="text/javascript">
														$('#tblfilter0').DataTable({searching: true, paging: false, info: false, pageLength: 500000} );
														$("#tblfilter0_length").html('');
														$("#tblfilter0_length").html('<br>&nbsp; <a href="#" onclick="selectallmarco()">Select All </a>');
													//	$("#tblfilter0_length").html($("#tblfilter0_filter").html());
													//	$("#tblfilter0_filter").html('');
																</script>
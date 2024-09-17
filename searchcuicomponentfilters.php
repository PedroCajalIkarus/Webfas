<?php
 include("db_conect.php"); 
	
 
 $v_lasempresas = $_REQUEST['lasempresas'];
 $v_lasbandas = $_REQUEST['lasbandas'];
 $v_losbranchs = $_REQUEST['losbranchs'];
 $v_losatributos =  $_REQUEST['losatributos'];
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

 $query_lista = "SELECT distinct iduniquebranchsonprod,  public.full_tree_namever_allbusiness(iduniquebranchsonprod, '') as namebranch, business.namebusiness, products.modelciu,  objectband.idportinul, objectband.idportoutul, objectband.idportindl, objectband.idportoutdl, dlgain, ulgain, dlmaxpwr, ulmaxpwr, class, ismodule
 ,	idport_inul.description as descriptioninul , idport_outul.description as descriptionoutul,
	 idport_indl.description as descriptionindl, idport_outdl.description as descriptionoutdl, idband.description as nameband,  products.idbusiness,  products.idproduct,  products.idrevproduct as maxidrev,
	 objectband.idband as idbandnn, objectband.idrev as idrevband
  from  fnt_select_allproducts_maxrev() as products 
  inner join business
  on business.idbusiness = products.idbusiness
  inner join fnt_select_objectband_maxrev() as objectband
  on products.idproduct		=	objectband.idproduct 
  
	  inner join idport as idport_inul
	 on idport_inul.idport = objectband.idportinul
	 inner join idport as idport_outul
	 on idport_outul.idport = objectband.idportoutul
	 
	 inner join idport as idport_indl
	 on idport_indl.idport = objectband.idportindl
	 inner join idport as idport_outdl
	 on idport_outdl.idport = objectband.idportoutdl
 	
	inner join idband
 on idband.idband = objectband.idband
	  where products.active= 'Y' ".$sumoalhere.$sumoalhere2.$sumoalhere3.$sumoalhere4;

  ///echo $query_lista ;
 
 $data = $connect->query($query_lista)->fetchAll();	
 ?>
 <table class="table table-striped table-bordered table-sm dataTable no-footer" name="tblfilter0" id="tblfilter0" role="grid" aria-describedby="tblfilter0_info">
 
 <thead>
 <tr>
 <th class="bg-primary "> Business </th>
 <th class="bg-primary "> Branch </th>
 <th class="bg-primary "> CIU </th>
 <th class="bg-primary "> Bands </th>
 <th class="bg-primary "> DL Gain </th>
 <th class="bg-primary "> Ul Gain </th>
 <th class="bg-primary "> DL MaxPwr </th>
 <th class="bg-primary "> Ul MaxPwr </th>
 <th class="bg-primary "> Class Product </th>
 
  
 </tr>
 </thead>
 <tbody>
 <?php
   foreach ($data as $row2) 
   {
	$indxtablaadd=0;
	   ?>

	<td><input name="chkprod[]" id="chkprod<?php echo 	$row2['idbusiness']."#".$row2['idproduct']."#".$row2['idrevband']."#".$row2['idbandnn']  ; ?>" value="chkprod<?php echo $row2['idbusiness']."#".$row2['idproduct']."#".$row2['idrevband']."#".$row2['idbandnn'] ; ?>"  class="chkclassmarco" type="checkbox" > <?php echo  $row2['namebusiness'];  ?></td>
		<?php						
	   echo "<td>".$row2['namebranch'] ."</td>";  
	   echo "<td>".$row2['modelciu']." - Rev [".$row2['maxidrev']."] </td>";  
	   echo "<td>".$row2['nameband']." - Rev [".$row2['idrevband']."]</td>";  
	   echo "<td>".round($row2['dlgain'])."</td>";
	   echo "<td>".round($row2['ulgain'])."</td>";
	   echo "<td>".round($row2['dlmaxpwr'])."</td>";
	   echo "<td>".round($row2['ulmaxpwr'])."</td>";
	   echo "<td>".$row2['class']."</td>";
	 
	   echo " </tr>";
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
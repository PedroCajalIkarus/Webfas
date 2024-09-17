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

						$lascomass = explode(",", $branch_to_search);
					//	echo "Hola cc".count($lascomass);
						if (count($lascomass)==1)
						{
							$sumoalhere4 =" and	iduniquebranchsonprod like '%".str_replace("a","",$branch_to_search)."%' ";
						}
						else
						{
							$sumoalhere4 =" and ( ";
							$im= 1;
							foreach ($lascomass as &$value2) {
								 if ($im < count($lascomass) )
								 {
									$sumoalhere4 = $sumoalhere4. " 	(iduniquebranchsonprod like '%".str_replace("a","",$value2)."%') or ";
								 }
								 else
								 {
									$sumoalhere4 = $sumoalhere4. " 	(iduniquebranchsonprod like '%".str_replace("a","",$value2)."%')  ";
								 }
								 $im = $im +1;
							

							}
							$sumoalhere4 = $sumoalhere4." ) ";
						}
				
						

					}
 					if ($v_lasempresas <>"")
					{
						$sumoalhere = " and   products.idbusiness in (".$v_lasempresas.") ";
					}
					if ($v_lasbandas <>"")
					{
						$sumoalhere2 = " and   objectband.idband in (".$v_lasbandas.") ";
					}
				/*	if ($v_losatributos <>"")
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
					}*/
					if ($v_losatributos <>"")
					{

						$pieces = explode(",", $v_losatributos);
						$losatributosi="";
						$losatributono="";
						/// recorremos los atributos.
						foreach ($pieces as $key => $value) {
							// $arr[3] will be updated with each value from $arr...
					//		echo "{$value} ";
							if (substr($value,0,3)=="NOT")
							{
								if ($losatributono=="")
								{
									$losatributono= $losatributono.substr($value,3,2)."";
								}
								else
								{
									$losatributono= $losatributono.substr($value,3,2).",";
								}
								
							}
							else
							{
								if ($losatributosi=="")
								{
									$losatributosi=$losatributosi.$value."";
								}
								else
								{
									$losatributosi=$losatributosi.",".$value;
								}
								
							}
							//print_r($arr);
						}
						///fin atributos
			//			echo "<br>fin SI:".$losatributosi."-Fin NO:".$losatributono ;
						if ($losatributosi <> "")
						{
							$sumoalhere3 = " and   productspp.idproduct in ( select products_attributes.idproduct
							from products_attributes
							inner join 
							(
								select products_attributes.idproduct , max(datemodif) as maxdatemodif 
								from products_attributes
								inner join products
								on  products.idproduct		=	products_attributes.idproduct 
								where idattribute in (".$losatributosi.") ".$sumoalhere.$sumoalhere4." group by products_attributes.idproduct
							) as maxxiprod
							on maxxiprod.idproduct    = products_attributes.idproduct and 
							maxxiprod.maxdatemodif = products_attributes.datemodif
						  ) ";
						}
						if ($losatributono <> "")
						{
							$sumoalhere3losno = " and   productspp.idproduct not in ( select products_attributes.idproduct
							from products_attributes
							inner join 
							(
								select products_attributes.idproduct , max(datemodif) as maxdatemodif 
								from products_attributes
								inner join products
								on  products.idproduct		=	products_attributes.idproduct 
								where idattribute in (".$losatributono.") ".$sumoalhere.$sumoalhere4." group by products_attributes.idproduct
							) as maxxiprod
							on maxxiprod.idproduct    = products_attributes.idproduct and 
							maxxiprod.maxdatemodif = products_attributes.datemodif
						  ) ";
						}
						
					}

 $query_lista = "SELECT distinct iduniquebranchsonprod,  public.full_tree_namever_allbusiness(iduniquebranchsonprod, '') as namebranch, business.namebusiness, products.modelciu,  
    products.idbusiness,  products.idproduct,  products.idrevproduct as maxidrev
	 
  from  fnt_select_allproducts_maxrev() as products 
  inner join business
  on business.idbusiness = products.idbusiness
  left join fnt_select_objectband_maxrev() as objectband
  on products.idproduct		=	objectband.idproduct 
  
  left join idport as idport_inul
	 on idport_inul.idport = objectband.idportinul
	 left join idport as idport_outul
	 on idport_outul.idport = objectband.idportoutul
	 
	 left join idport as idport_indl
	 on idport_indl.idport = objectband.idportindl
	 left join idport as idport_outdl
	 on idport_outdl.idport = objectband.idportoutdl
 	
	left join idband
 on idband.idband = objectband.idband
	  where products.active= 'Y' ".$sumoalhere.$sumoalhere2.$sumoalhere3.$sumoalhere4;

 // echo $query_lista ;
 
 $data = $connect->query($query_lista)->fetchAll();	
 ?>
 <table class="table table-striped table-bordered table-sm dataTable no-footer" name="tblfilter0" id="tblfilter0" role="grid" aria-describedby="tblfilter0_info">
 
 <thead>
 <tr>
 <th class="bg-primary "> Business </th>
 <th class="bg-primary "> Branch </th>
 <th class="bg-primary "> CIU </th>
 

  
 </tr>
 </thead>
 <tbody>
 <?php
   foreach ($data as $row2) 
   {
	$indxtablaadd=0;
	   ?>

	<td><input name="chkprod[]" id="chkprod<?php echo 	$row2['idbusiness']."#".$row2['idproduct']."#".$row2['maxidrev']."#".$row2['idbandnn']  ; ?>" value="chkprod<?php echo $row2['idbusiness']."#".$row2['idproduct']."#".$row2['idrevband']."#".$row2['idbandnn'] ; ?>"  class="chkclassmarco" type="checkbox" > <?php echo  $row2['namebusiness'];  ?></td>
		<?php						
	   echo "<td>".$row2['namebranch'] ."</td>";  
	   echo "<td>".$row2['modelciu']." - Rev [".$row2['maxidrev']."] ID:[".$row2['idproduct']."] </td>";  
	  
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
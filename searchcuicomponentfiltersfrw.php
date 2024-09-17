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
					/*if ($v_losatributos <>"")
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
						//echo "<br>fin SI:".$losatributosi."-Fin NO:".$losatributono ;
						if ($losatributosi <> "")
						{
							$sumoalhere3 = " and   products.idproduct in ( select products_attributes.idproduct
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
							$sumoalhere3losno = " and   products.idproduct not in ( select products_attributes.idproduct
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
//////aca   public.full_tree_namever_allbusiness(iduniquebranchsonprod, '') as namebranch
/*
 $query_lista = "SELECT distinct iduniquebranchsonprod,  iduniquebranchsonprod as namebranch, business.namebusiness, products.modelciu,  
 idband.description as nameband,  products.idbusiness,  products.idproduct,   
 idband.idband as idbandnn,  
 fas_confidential_fw.* ,  fas_confidential_fw.idrevfw
  
from  fnt_select_allproducts_maxrev() as  products
inner join business
on business.idbusiness = products.idbusiness ".$sumoalhere.$sumoalhere4."
inner join fnt_select_objectband_maxrev() as objectband
  on products.idproduct		=	objectband.idproduct 
left join products_attributes
on 	products.idproduct			 = products_attributes.idproduct
inner join fnt_select_fas_confidential_fw_maxrev() as fas_confidential_fw
 on fas_confidential_fw.idciu		=	objectband.idproduct 
 inner join bandgroups
on bandgroups.idband	=  objectband.idband 
inner join bandgroups AS bandgroups2
on bandgroups2.idband	=  fas_confidential_fw.idtypeband
AND  bandgroups.idbandgroup = bandgroups2.idbandgroup
inner join idband
on idband.idband = objectband.idband  and idband.idband =  fas_confidential_fw.idtypeband 
".$sumoalhere2.$sumoalhere3.	$sumoalhere3losno.$sumoalhere5.$sumoalhere6;*/
 

/////////////////mejroadoo 2
$query_lista ="
 select ultse.* , namebranch
 from (


SELECT distinct iduniquebranchsonprod,   namebusiness, modelciu, idband.description as nameband,
 idbusiness, idproduct, idband.idband as idbandnn, fas_confidential_fw.* , fas_confidential_fw.idrevfw 
from
(
	select distinct products.*,objectband.idband ,business.namebusiness
	from fnt_select_allproducts_maxrev() as products 
	inner join business on business.idbusiness = products.idbusiness   ".$sumoalhere.$sumoalhere4.$sumoalhere3.	$sumoalhere3losno."
	inner join fnt_select_objectband_maxrev() as objectband on products.idproduct = objectband.idproduct ".$sumoalhere2."
) as todosprod
 
inner join fnt_select_fas_confidential_fw_maxrev() as fas_confidential_fw on fas_confidential_fw.idciu = todosprod.idproduct  AND
fas_confidential_fw.idtypeband = todosprod.idband
left join idband on idband.idband = todosprod.idband  and  idband.idband = fas_confidential_fw.idtypeband ".$sumoalhere5.$sumoalhere6."
) as ultse
left join ( select  distinct iduniquebranchsonprod as iduniquebranchsonprodtt , public.full_tree_namever_allbusiness(iduniquebranchsonprod, '') as namebranch
			from fnt_select_allproducts_maxrev() as products    where active = 'Y'  ".$sumoalhere.$sumoalhere4.$sumoalhere3.	$sumoalhere3losno."
			) as losnamebrachsmm
on losnamebrachsmm.iduniquebranchsonprodtt	=  ultse.iduniquebranchsonprod";
 


	///echo "ult.". $query_lista;
 
 $data = $connect->query($query_lista)->fetchAll();	
 ?>
 <table class="table table-striped table-bordered table-sm dataTable no-footer" name="tblfilter0" id="tblfilter0" role="grid" aria-describedby="tblfilter0_info"> 
 <thead>
 <tr>
 <th class="bg-primary "> Business </th>
 <th class="bg-primary "> Branch </th>
 <th class="bg-primary "> CIU [Rev.Fw] </th>
 <th class="bg-primary "> Bands </th>
 
 <th class="bg-primary "> Fpga File </th>
 <th class="bg-primary "> Micro File </th>
 <th class="bg-primary "> Eth File </th>
 <th class="bg-primary "> Fpga Fas</th>
 <th class="bg-primary "> Micro Fas</th>
 <th class="bg-primary "> Eth Fas</th>
 

 
 
 
 </tr>
 </thead>
 <tbody>
 <?php
   foreach ($data as $row2) 
   {
	$indxtablaadd=0;
	   ?>
	<td><input name="chkprod[]" id="chkprod<?php echo 	$row2['idbusiness']."#".$row2['idproduct']."#".$row2['idrevfw']."#".$row2['idtypeband']   ; ?>" value="chkprod<?php echo 	$row2['idbusiness']."#".$row2['idproduct']."#".$row2['idrevfw']."#".$row2['idtypeband']  ; ?>"  class="chkclassmarco" type="checkbox" > <?php echo  $row2['namebusiness'];  ?></td>
		<?php						
	   echo "<td>".$row2['namebranch'] ."</td>";  
	   echo "<td>".$row2['modelciu']." -[".$row2['idrevfw']."]"."</td>";  
	   echo "<td>".$row2['nameband']."</td>";  
	  
	    
	   echo "<td>".$row2['fpgafilename']."</td>";
	   echo "<td>".$row2['microfilename']."</td>";
	   echo "<td>".$row2['ethfilename']."</td>";
	   echo "<td>".$row2['fpga_fas']."</td>";
	   echo "<td>".$row2['micro_fas']."</td>";
	   echo "<td>".$row2['eth_fas']."</td>";
 
	  
	    
	  
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
<?php
 include("db_conect.php"); 
 include("db_conect_srv20.php"); 
	
 
 $v_lasempresas = $_REQUEST['lasempresas'];
 $v_lasbandas = $_REQUEST['lasbandas'];
 $v_losbranchs = $_REQUEST['losbranchs'];
 $v_losatributos =  $_REQUEST['losatributos'];

 $v_losuldl =  $_REQUEST['losuldl'];
 $v_lasmediciones =  $_REQUEST['lasmediciones'];

 $v_lascategorias=  $_REQUEST['lascategorias'];
 $v_lascategoriastype=  $_REQUEST['lascategoriastype'];
 $v_losscript =  $_REQUEST['losscript'];
 

 include("db_conect.php"); 


					if($v_losbranchs <>"" )
					{
						$losarraydeempresas = array("a0001", "a0004", "a0005", "a0007", "a0008");
						$branch_to_search = str_replace($losarraydeempresas, "%", $v_losbranchs);

						$sumoalhere4 =" and	iduniquebranchsonprod like '%".str_replace("a","",$branch_to_search)."%' ";
					}
 					if ($v_lasempresas <>"")
					{
						$sumoalhere = " and   productspp.idbusiness in (".$v_lasempresas.") ";
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

					$sumoalhere7 ="";
					$sumoalhere8 ="";
					if ($v_lascategorias <>"")
					{
						 
						/// el campo mediciones en el firmware hacen refenrecia al id de la tabla  fas_firmwarelist
						$sumoalhere7 = " and  fas_income_integral.idcategory = ".  $v_lascategorias." and fas_income_integral.idtype =  ".$v_lascategoriastype;
						 
					}
					if ($v_losscript <>"")
					{
						 
						/// el campo mediciones en el firmware hacen refenrecia al id de la tabla  fas_firmwarelist
					 $sumoalhere8 = " and  fas_income_integral.in_instance = '".  $v_losscript."'";
						 
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

 $query_lista = "select idband.description as bandincome	 , fas_income_integral.reference as referencedd , fas_income_integral.v_integer as idband,  d.* from (
	select fas_income_integral.reference as referencedd , fas_income_integral.v_integer as uldl, '-----',dd.* 
	from ( 


 select distinct iduniquebranchsonprod,  namebranch, business.namebusiness, productspp.modelciu,  
 idband.description as nameband,  productspp.idbusiness,  productspp.idproduct,    fas_step.description as namefas_step  ,
 idband.idband as idbandnn,   fas_income_category.nameoutcomecat as cat, fas_income_category_type.nameoutcomecat as cattype,  fas_income_integral.*
from fas_income_integral
inner join fas_income_category_type
on fas_income_category_type.idcategory = fas_income_integral.idcategory and 
fas_income_category_type.idtype = fas_income_integral.idtype
inner join fas_income_category
on fas_income_category.idcategory = fas_income_integral.idcategory 
inner join  fnt_select_allproducts_maxrev() as  productspp
on productspp.idproduct = fas_income_integral.idproduct 
inner join business
on business.idbusiness = productspp.idbusiness
left join ( select  distinct iduniquebranchsonprod as iduniquebranchsonprodtt , public.full_tree_namever_allbusiness(iduniquebranchsonprod, '') as namebranch
			from fnt_select_allproducts_maxrev() as ppp   
			) as losnamebrachsmm
on losnamebrachsmm.iduniquebranchsonprodtt	=  productspp.iduniquebranchsonprod
left join fnt_select_objectband_maxrev() as objectband
  on productspp.idproduct		=	objectband.idproduct
  left join idband
on idband.idband = objectband.idband 
inner join fas_step
on fas_step.instance = fas_income_integral.in_instance 
left join products_attributes
on 	productspp.idproduct			 = products_attributes.idproduct
where productspp.active = 'Y' 
".$sumoalhere.$sumoalhere2.$sumoalhere3.	$sumoalhere3losno.$sumoalhere4.$sumoalhere5.$sumoalhere6.$sumoalhere7.$sumoalhere8."  

) as dd
inner join fas_income_integral
on fas_income_integral.id_income = dd.reference
) as d
inner join fas_income_integral
on fas_income_integral.id_income = d.referencedd 
left join idband on idband.idband = fas_income_integral.v_integer and
d.idbandnn = idband.idband

order by modelciu, idbandnn
 
 
 ";
//echo "1)-<br>".$query_lista;
 $data = $connect20->query($query_lista)->fetchAll();	
 $sientroaluno = 'N';
 ?>
 <table class="table table-striped table-bordered table-sm dataTable no-footer" name="tblfilter0" id="tblfilter0" role="grid" aria-describedby="tblfilter0_info"> 
 <thead>
 <tr>
 <th class="bg-primary "> Business </th>
 <th class="bg-primary "> Branch </th>
 <th class="bg-primary "> CIU [Rev.Fw] </th>
 <th class="bg-primary "> Bands </th>
 <th class="bg-primary "> Name Steps </th>
 <th class="bg-primary "> InCome Category Type </th>
 <th class="bg-primary "> InCome  BAND</th>
 <th class="bg-primary "> InCome  ULDL</th>
 
 <th class="bg-primary "> v_integer </th>
 <th class="bg-primary "> v_double </th>
 <th class="bg-primary "> v_boolean </th>
 <th class="bg-primary "> v_string </th>
 <th class="bg-primary "> v_date </th>
 

 
 
 
 </tr>
 </thead>
 <tbody>
 <?php
   foreach ($data as $row2) 
   {
	$indxtablaadd=0;
	$sientroaluno = 'S';
	   ?>
	<td><input name="chkprod[]" id="chkprod<?php echo 	$row2['idproduct']."#".$row2['id_income']   ;  ; ?>" value="chkprod<?php echo 	$row2['idproduct']."#".$row2['id_income']   ; ; ?>"  class="chkclassmarco" type="checkbox" > <?php echo  $row2['namebusiness'];  ?></td>
		<?php						
	   echo "<td>".$row2['namebranch'] ."</td>";  
	   echo "<td>".$row2['modelciu']." -[".$row2['idrevfw']."]"."</td>";  
	   echo "<td>".$row2['nameband']."</td>";  
	  
	   echo "<td>".$row2['namefas_step']."</td>";
	   echo "<td>".$row2['cat']." -- ".$row2['cattype']."</td>";
	   echo "<td>".$row2['bandincome']."</td>";
	   echo "<td>";
	    if($row2['uldl']==0) { echo "UpLink"; } else { echo "Donwlink";}
		echo "</td>";
 
	   echo "<td>".$row2['v_integer']."</td>";
	   echo "<td>".$row2['v_double']."</td>";
	   echo "<td>".$row2['v_boolean']."</td>";
	   echo "<td>".$row2['v_string']."</td>";
	   echo "<td>".$row2['v_datetime']."</td>";
 
	  
	    
	  
	   echo "</tr>";
   }

?>

<?php

if ($sientroaluno == 'N')
{
	$query_lista = " 
	select distinct iduniquebranchsonprod,  namebranch  , business.namebusiness, productspp.modelciu,  
	idband.description as nameband,  productspp.idbusiness,  productspp.idproduct,   fas_step.description as namefas_step,
	idband.idband as idbandnn,   fas_income_category.nameoutcomecat as cat, fas_income_category_type.nameoutcomecat as cattype,  fas_income_integral.*
   from fas_income_integral
   inner join fas_income_category_type
   on fas_income_category_type.idcategory = fas_income_integral.idcategory and 
   fas_income_category_type.idtype = fas_income_integral.idtype
   inner join fas_income_category
   on fas_income_category.idcategory = fas_income_integral.idcategory 
   
   inner join fas_step
   on fas_step.instance = fas_income_integral.in_instance 
 
   
   left join  fnt_select_allproducts_maxrev() as  productspp
   on productspp.idproduct = fas_income_integral.idproduct 
   left join ( select  distinct iduniquebranchsonprod as iduniquebranchsonprodtt  , public.full_tree_namever_allbusiness(iduniquebranchsonprod, '') as namebranch
   from fnt_select_allproducts_maxrev() as ppp  
   ) as losnamebrachsmm
	on losnamebrachsmm.iduniquebranchsonprodtt	=  productspp.iduniquebranchsonprod

   left join business
   on business.idbusiness = productspp.idbusiness
   left join fnt_select_objectband_maxrev() as objectband
	 on productspp.idproduct		=	objectband.idproduct
	 left join idband
   on idband.idband = objectband.idband 
   left join products_attributes
   on 	productspp.idproduct			 = products_attributes.idproduct
   where productspp.active = 'Y' 
   ".$sumoalhere.$sumoalhere2.$sumoalhere3.	$sumoalhere3losno.$sumoalhere4.$sumoalhere5.$sumoalhere6.$sumoalhere7.$sumoalhere8."  
   
   order by modelciu , idbandnn
   	
	";
	echo "2)-<br>".$query_lista;
	$data = $connect->query($query_lista)->fetchAll();	
	  foreach ($data as $row2) 
	  {
	   $indxtablaadd=0;
		  ?>
	   <td><input name="chkprod[]" id="chkprod<?php echo 	$row2['idproduct']."#".$row2['id_income']   ; ?>" value="chkprod<?php echo 	$row2['idproduct']."#".$row2['id_income'] ; ?>"  class="chkclassmarco" type="checkbox" > <?php echo  $row2['namebusiness'];  ?></td>
		   <?php						
		  echo "<td>".$row2['namebranch'] ."</td>";  
		  echo "<td>".$row2['modelciu']." -[".$row2['idrevfw']."]"."</td>";  
		  echo "<td>".$row2['nameband']."</td>";  
		
		  echo "<td>".$row2['namefas_step']."</td>";
	
		  
		  echo "<td>".$row2['cat']." -- ".$row2['cattype']."</td>";
		  echo "<td>".$row2['bandincome']."</td>";
		  echo "<td>";
		  if($row2['uldl']==0) { echo "UpLink"; } else { echo "Donwlink";}
		  echo "</td>";
	
		  echo "<td>".$row2['v_integer']."</td>";
		  echo "<td>".$row2['v_double']."</td>";
		  echo "<td>".$row2['v_boolean']."</td>";
		  echo "<td>".$row2['v_string']."</td>";
		  echo "<td>".$row2['v_datetime']."</td>";
	
		 
		   
		 
		  echo "</tr>";
	  }
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
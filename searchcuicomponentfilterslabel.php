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
						$sumoalhere2 = " inner join fnt_select_objectband_maxrev() as objectband
						on products.idproduct		=	objectband.idproduct 
						 inner join idband
						on idband.idband = objectband.idband  and   objectband.idband in (".$v_lasbandas.") ";
					}
					if ($v_losuldl <>"")
					{
						$sumoalhere5 = " and  powersupply in (".$v_losuldl.") ";
					///	$sumoalhere5 = "   ";
					}
					if ($v_lasmediciones <>"")
					{
						/// el campo mediciones en el firmware hacen refenrecia al id de la tabla  fas_firmwarelist
						$sumoalhere6 = " and  fas_tree_product_references.iduniquebranch like  '%".$v_lasmediciones."%' ";
						$sumoalhere6 = "  ";
					}
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

 $query_lista = "SELECT distinct iduniquebranchsonprod,  public.full_tree_namever_allbusiness(iduniquebranchsonprod, '') as namebranch, business.namebusiness, products.modelciu,  
   products.idbusiness,  products.idproduct,   powersupply,
   
 ulpwrrat, madein, flia, fcc, ic, products_label.active, fccimg, ulimg, rohsimg, madeinimg, etsi, idrevlabel, ulcontract, sgsimg,   generictext, ulstandard, trademark, drawingnumber, url, upc
  
from  fnt_select_allproducts_maxrev() as  products
inner join business
on business.idbusiness = products.idbusiness

left join products_attributes
on 	products.idproduct			 = products_attributes.idproduct
 inner join fnt_select_allproducts_label_maxrev() as  products_label
 on products_label.idproduct = products.idproduct and products_label.active ='Y'	

".$sumoalhere.$sumoalhere2.$sumoalhere3.$sumoalhere4.$sumoalhere5.$sumoalhere6.$sumoalhere3losno;
  
//echo $query_lista;
  
 $data = $connect->query($query_lista)->fetchAll();	
 ?>
 <table class="table table-striped table-bordered table-sm dataTable no-footer" name="tblfilter0" id="tblfilter0" role="grid" aria-describedby="tblfilter0_info"> 
 <thead>
 <tr>
 <th class="bg-primary "> Business </th>
 <th class="bg-primary "> Branch </th>
 <th class="bg-primary "> CIU [Rev.Fw] </th>
 <th class="bg-primary ">POWER SUPPLY TYPE</th>
 <th class="bg-primary "> UL PWR RAT   </th>
 <th class="bg-primary "> MADE IN</th>
 <th class="bg-primary "> FLIA </th>
 <th class="bg-primary "> FCC </th>
 <th class="bg-primary "> IC</th>
 
 <th class="bg-primary "> FCC IMG</th>
 <th class="bg-primary "> UL IMG</th>
 <th class="bg-primary "> ROHS IMG</th>
 <th class="bg-primary "> MADE IN IMG</th>
 <th class="bg-primary "> SGS IMG</th>
 <th class="bg-primary "> ETSI IMG</th>
 <th class="bg-primary "> UL CONTRACT  </th>

 <th class="bg-primary "> GENERIC TEXT  </th>
 <th class="bg-primary "> UL STANDARD  </th>
 <th class="bg-primary "> TRADEMARK  </th>
 <th class="bg-primary "> DRAWING NUMBER  </th>
 <th class="bg-primary "> URL</th>
 <th class="bg-primary "> UPC</th>
 </tr>
 </thead>
 <tbody>
 <?php
   foreach ($data as $row2) 
   {
	$indxtablaadd=0;
	   ?>
	<td><input name="chkprod[]" id="chkprod<?php echo 	$row2['idbusiness']."#".$row2['idproduct']."#".$row2['idrevlabel']    ; ?>" value="chkprod<?php echo 	$row2['idbusiness']."#".$row2['idproduct']."#".$row2['idrevlabel']   ; ?>"  class="chkclassmarco" type="checkbox" > <?php echo  $row2['namebusiness'];  ?></td>
		<?php						
	   echo "<td>".$row2['namebranch'] ."</td>";  
	   echo "<td>".$row2['modelciu']." -[".$row2['idrevlabel']."]"."</td>";  
	   echo "<td>".$row2['powersupply']."</td>";
	   echo "<td>".$row2['ulpwrrat']."</td>";
	   echo "<td>".$row2['madein']."</td>";
	   echo "<td>".$row2['flia']."</td>";
	   echo "<td>".$row2['fcc']."</td>";
	   echo "<td>".$row2['ic']."</td>";
	   
	   echo "<td>";
	 
	   if (  $row2['fccimg'] ==1)
	   {
		   echo "<i class='fas fa-check-circle' style=' color:green'></i>";
	   }  
	   else
	   {
		echo "<i class='fas fa-times-circle' style=' color:red'></i>";
	   }
	   echo "</td>";
	   echo "<td>";
	   
	   if (  $row2['ulimg'] ==1)
	   {
		   echo "<i class='fas fa-check-circle' style=' color:green'></i>";
	   }  
	   else
	   {
		echo "<i class='fas fa-times-circle' style=' color:red'></i>";
	   }
	   echo "</td>";
	   echo "<td>";
	   
	   if (  $row2['rohsimg'] ==1)
	   {
		   echo "<i class='fas fa-check-circle' style=' color:green'></i>";
	   }  
	   else
	   {
		echo "<i class='fas fa-times-circle' style=' color:red'></i>";
	   }
	   echo "</td>";
	   echo "<td>";
	   
	   if (  $row2['madeinimg'] ==1)
	   {
		   echo "<i class='fas fa-check-circle' style=' color:green'></i>";
	   }  
	   else
	   {
		echo "<i class='fas fa-times-circle' style=' color:red'></i>";
	   }
	   echo "</td>";
	   echo "<td>";
	    
	   if (  $row2['sgsimg'] ==1)
	   {
		   echo "<i class='fas fa-check-circle' style=' color:green'></i>";
	   }  
	   else
	   {
		echo "<i class='fas fa-times-circle' style=' color:red'></i>";
	   }

	   echo "</td>";
	   echo "<td>";
	   
	   if (  $row2['etsi'] ==1)
	   {
		   echo "<i class='fas fa-check-circle' style=' color:green'></i>";
	   }  
	   else
	   {
		echo "<i class='fas fa-times-circle' style=' color:red'></i>";
	   }

	   echo "</td>";
	   echo "<td>".$row2['ulcontract']."</td>";
	 
	   echo "<td>".$row2['generictext']."</td>";
	   echo "<td>".$row2['ulstandard']."</td>";

	   echo "<td>".$row2['trademark']."</td>";
	   echo "<td>".$row2['drawingnumber']."</td>";
	   echo "<td>".$row2['url']."</td>";
	   echo "<td>".$row2['upc']."</td>";
	  
	    
	  
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
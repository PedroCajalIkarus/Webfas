<?php
	include("db_conect.php"); 


 ?>
									
	   
	   <br><br>
	   <b>Labels  : </b>
	   <?php $query_lista = "SELECT distinct iduniquebranchsonprod,  public.full_tree_namever_allbusiness(iduniquebranchsonprod, '') as namebranch, business.namebusiness, products.modelciu,  
   products.idbusiness,  products.idproduct,   powersupply,
   
 ulpwrrat, madein, flia, fcc, ic, products_label.active, fccimg, ulimg, rohsimg, madeinimg, etsi, idrevlabel, ulcontract, sgsimg,   generictext, ulstandard, trademark, drawingnumber, url
  
from  fnt_select_allproducts_maxrev() as  products
inner join business
on business.idbusiness = products.idbusiness

left join products_attributes
on 	products.idproduct			 = products_attributes.idproduct
 inner join fnt_select_allproducts_label_maxrev() as  products_label
 on products_label.idproduct = products.idproduct and products_label.active ='Y'	
 where  products.idproduct =".str_replace("a","",$_REQUEST['p0']);
  
//echo $query_lista;
  
 $data = $connect->query($query_lista)->fetchAll();	
 ?>
 <table class="table table-striped table-bordered table-sm dataTable no-footer table-responsive" name="'#tblfilterlbl<?php echo $_REQUEST['p0'];?>'" id="'#tblfilterlbl<?php echo $_REQUEST['p0'];?>'" role="grid" aria-describedby="tblfilter10_info"> 
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
	  
	    
	  
	   echo "</tr>";
   }

?>
	</tbody>
</table>
<script type="text/javascript">
														$('#tblfilterlbl<?php echo $_REQUEST['p0'];?>').DataTable({searching: true, paging: true, info: false, pageLength: 10} );
														
																</script>
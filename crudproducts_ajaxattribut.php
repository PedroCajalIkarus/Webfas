<?php
	include("db_conect.php"); 


 ?>
									
	   
	   <br><br>
	   <b>Product Attribute  : </b>
	   <?php
$query_lista = "select distinct attributename,  v_boolean, v_integer, v_double, v_string
from products_attributes
inner join products_attributes_type
on products_attributes_type.idattribute = products_attributes.idattribute
where    idproduct =".str_replace("a","",$_REQUEST['p0'])." order by attributename";

 

 
 $data = $connect->query($query_lista)->fetchAll();	
 ?>
 <table class="table table-striped table-bordered table-sm dataTable no-footer table-responsive" style="font-size:12px;" name="tblfilterattrib<?php echo $_REQUEST['p0'];?>" id="tblfilterattrib<?php echo $_REQUEST['p0'];?>" role="grid" aria-describedby="tblfilter0_info">
 
 <thead>
 <tr>
 <th class="bg-primary "> Attribute </th>
 <th class="bg-primary "> Boolean </th>
 <th class="bg-primary "> Integer </th>
 <th class="bg-primary "> Double </th>
 <th class="bg-primary "> String </th>
 
  
 </tr>
 </thead>
 <tbody>
 <?php
   foreach ($data as $row2) 
   {
	$indxtablaadd=0;
	   ?>

	 <?php						
	   echo "<td>".$row2['attributename'] ."</td>";  	   
	   echo "<td>".round($row2['v_boolean'])."</td>";
	   echo "<td>".round($row2['v_integer'])."</td>";
	   echo "<td>".round($row2['v_double'])."</td>";
	   echo "<td>".round($row2['v_sting'])."</td>";
	   
	 
	   echo " </tr>";
   }

?>
	</tbody>
</table>
<script type="text/javascript">
														$('#tblfilterattrib<?php echo $_REQUEST['p0'];?>').DataTable({searching: true, paging: true, info: false, pageLength: 10} );
													 
																</script>
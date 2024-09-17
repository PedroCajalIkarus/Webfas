<?php
	include("db_conect.php"); 

$querypp="select * , public.full_tree_namever_allbusiness(iduniquebranchsonprod, '') as namebranch from fnt_select_allproducts_maxrev() where idproduct =".str_replace("a","",$_REQUEST['p0']);
$datapp = $connect->query($querypp)->fetchAll();	
foreach ($datapp as $row2p) 
{
	$descrip =  $row2p['description'];
	$mother =  $row2p['classproduct'];
	$active =  $row2p['active'];
	$Branch =  $row2p['iduniquebranchsonprod'];
	$namebranch =  $row2p['namebranch'];
}
 ?>								
	
	&bull; Description :<b> <?php echo $descrip ;?> </b><br>
	   &bull;Mother :<b> <?php echo $mother ;?> </b><br>
	   &bull;Active :<b> <?php echo $active ;?> </b><br>
	   &bull;Branch :<b> <?php echo $Branch."  ||  ".$namebranch ;?> </b><br>

	   
	   <hr><br>
	   <b>Obj Bands  : </b>
	   <?php
$query_lista = "SELECT distinct iduniquebranchsonprod,  public.full_tree_namever_allbusiness(iduniquebranchsonprod, '') as namebranch, business.namebusiness, products.modelciu,  products.description as descriptionpp, 
objectband.idportinul, objectband.idportoutul, objectband.idportindl, objectband.idportoutdl, dlgain, ulgain, dlmaxpwr, ulmaxpwr, class, ismodule,
  idband.description as nameband,  products.idbusiness,  products.idproduct,  products.idrevproduct as maxidrev,
	objectband.idband as idbandnn, objectband.idrev as idrevband, idband.fstartul, idband.fstopul, idband.fstartdl, idband.fstopdl
 from  fnt_select_allproducts_maxrev() as products 
 inner join business
 on business.idbusiness = products.idbusiness
 inner join fnt_select_objectband_maxrev() as objectband
 on products.idproduct		=	objectband.idproduct 
 	
   inner join idband
on idband.idband = objectband.idband
	 where products.active= 'Y' and products.idproduct =".str_replace("a","",$_REQUEST['p0']);


 /// echo $query_lista ;

 
 $data = $connect->query($query_lista)->fetchAll();	
 ?>
 <table class="table table-striped table-bordered table-sm dataTable no-footer table-responsive" style="font-size:12px;" name="tblfilterobjb<?php echo $_REQUEST['p0'];?>" id="tblfilterobjb<?php echo $_REQUEST['p0'];?>" role="grid" aria-describedby="tblfilter0_info">
 
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
	   echo "<td>".$row2['modelciu']." - Rev [".$row2['maxidrev']."] <span title='".$row2['descriptionpp']."'> <i class='fa fa-info-circle'></i></span> </td>";  
	   echo "<td>".$row2['nameband']." - Rev [".$row2['idrevband']."] - [".$row2['fstartul']."-".$row2['fstopul']."]</td>";  
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
														$('#tblfilterobjb<?php echo $_REQUEST['p0'];?>').DataTable({searching: true, paging: true, info: false, pageLength: 10} );
													 
																</script>
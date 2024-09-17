<!DOCTYPE html>
<html>
<body>
<?php
include "db_conect.php";
error_reporting(0);
	
	 $sql = $connect->prepare("SELECT   * from fnt_select_allproducts_maxrev() as  ppp order by idproduct  limit 15 ");
    $sql->execute();
    $resultado = $sql->fetchAll();




$employee_arr = array();
 
?>
<table >
<tr>
	<th>ID</th>
	<th>SKU</th>
</tr>	
<?php

 foreach ($resultado as $row) {
 
    
    $idruninfo = $row['idproduct'];
    $modelciu = $row['modelciu'];
 
	///echo $idruninfo.",".$modelciu;

	?>
 
<tr>
	<td><?php echo $idruninfo; ?></td>
	<td><?php echo $modelciu; ?></td>
</tr>	
<?php

    $employee_arr[] = array("idproduct" => $idruninfo,"modelciu" => $modelciu);
}

/* encoding array to JSON format */
//echo json_encode($employee_arr);
?>
</table>
</body>
</html>

<?php
include "db_conect.php";
error_reporting(0);
/* Getting post data */
$v_idtyp = $_REQUEST['idtyp'];
$v_valuemm = $_REQUEST['valuemm'];
$vvinstance = $_REQUEST['vinstance'];


 include ('licencefiplex_mm.php');
 
   //   $Encryption = new Encryption();

if ($v_idtyp ==1)
{
  $sql = $connect->prepare("select distinct fas_step.*
  from fas_tree_product_references
  inner join fas_step
  on fas_step.instance =  fas_tree_product_references.iduniquebranch 
  where idscripttype = ".$v_valuemm." order by description");
  $sql->execute();
  $resultado = $sql->fetchAll();
 foreach ($resultado as $row) {
     
      
      $listcategory[] = array
      (
        'in_instance' => $row['instance'],						
        'description' => $row['description']
      );


   }
   echo(json_encode([ "data"=>$listcategory]));

}
 



     ?>


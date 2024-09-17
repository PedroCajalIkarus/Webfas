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
  $sql = $connect->prepare("select distinct fas_income_category_type.idtype, fas_income_category_type.nameoutcomecat  description
  from  fas_income_category

  inner join fas_income_category_type
  on fas_income_category_type.idcategory = fas_income_category.idcategory  
  
  where  fas_income_category.idcategory = ".$v_valuemm. "  order by description");
  $sql->execute();
  $resultado = $sql->fetchAll();
 foreach ($resultado as $row) {
     
      
      $listcategory[] = array
      (
        'in_instance' => $row['idtype'],						
        'description' => $row['description']
      );


   }
   echo(json_encode([ "data"=>$listcategory]));

}




     ?>


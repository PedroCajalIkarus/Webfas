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
  $sql = $connect->prepare("select distinct in_instance, description
  from fas_income_integral
  inner join fas_step on fas_step.instance = fas_income_integral.in_instance
  where fas_income_integral.idscript = ".$v_valuemm);
  $sql->execute();
  $resultado = $sql->fetchAll();
 foreach ($resultado as $row) {
     
      
      $listcategory[] = array
      (
        'in_instance' => $row['in_instance'],						
        'description' => $row['description']." - [".$row['in_instance']."]"
      );


   }
   echo(json_encode([ "data"=>$listcategory]));

}

if ($v_idtyp ==2)
{
  $sql = $connect->prepare("select distinct fas_income_integral.idcategory, nameoutcomecat  description
  from fas_income_integral 
  inner join fas_income_category
  on fas_income_category.idcategory = fas_income_integral.idcategory
  where in_instance = '".$v_valuemm."'");
  $sql->execute();
  $resultado = $sql->fetchAll();
 foreach ($resultado as $row) {
     
      
      $listcategory[] = array
      (
        'in_instance' => $row['idcategory'],						
        'description' => $row['description']." - [".$row['idcategory']."]"
      );


   }
   echo(json_encode([ "data"=>$listcategory]));

}


if ($v_idtyp ==3)
{
  $sql = $connect->prepare("select distinct  fas_income_integral.idtype, nameoutcomecat  description
  from fas_income_integral 
  inner join fas_income_category_type
  on fas_income_category_type.idcategory = fas_income_integral.idcategory and
  fas_income_category_type.idtype = fas_income_integral.idtype

  where  fas_income_integral.idcategory = ".$v_valuemm. " and in_instance = '". $vvinstance."' ");
  $sql->execute();
  $resultado = $sql->fetchAll();
 foreach ($resultado as $row) {
     
      
      $listcategory[] = array
      (
        'in_instance' => $row['idtype'],						
        'description' => $row['description']." - [".$row['idtype']."]"
      );


   }
   echo(json_encode([ "data"=>$listcategory]));

}




     ?>


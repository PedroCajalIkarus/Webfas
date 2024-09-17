<?php
include "db_conect.php";
error_reporting(0);
/* Getting post data */
$nropage = $_REQUEST['page'];


 include ('licencefiplex_mm.php');
 
   //   $Encryption = new Encryption();



$sql = $connect->prepare("SELECT idtechsupport_category,  namecategory from fas_techsupport_category WHERE active='Y' AND iduserfastorepor = 1");
    $sql->execute();
    $resultado = $sql->fetchAll();
	 foreach ($resultado as $row) {
       
        
        $listcategory[] = array
        (
          'idtechsupport_category' => "a".$row['idtechsupport_category'],						
          'namecategory' => $row['namecategory']
        );


     }
     echo(json_encode([ "data"=>$listcategory]));

     ?>


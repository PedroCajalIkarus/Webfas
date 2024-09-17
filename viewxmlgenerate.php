<?php 
//header('Content-Type: application/xml');
include("db_conect.php"); 

 	session_start();

    $reqid= $_REQUEST['idr'];
     $query_listagraf = "select * from fas_outcome_integral_sap 
     where reference in ( select id_outcome from fas_outcome_integral_sap where reference = ".$reqid." and idtype= 23 and idfasoutcomecat = 0 ) limit 1";
    // echo $query_listagraf;

     $datagraf = $connect->query($query_listagraf)->fetchAll();	
     foreach ($datagraf as $row2graf) 
     {
        
        $output= htmlspecialchars( $row2graf['v_string']) ;
     }

     print ($output);

     
?>
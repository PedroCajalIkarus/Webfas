<?php
 include("db_conect.php"); 
  	session_start();
	 
	header('Content-Type: application/json');
	
	
	$idrunfin = $_REQUEST['idrunfin'];
 
	$return_arr[] = array("resultado" => "OK");


     $sql = $connect->prepare("call a_solucionador_orders_attributes_sn_resendsap(:idruninfo); ");
     $sql->bindParam(':idruninfo', $idrunfin);   
                         $sql->execute();	
                         
                         
                

     $sql = $connect->prepare("delete from fas_to_sap_xml WHERE idruninfo = :idruninfo ");
     $sql->bindParam(':idruninfo', $idrunfin);   
     $sql->execute();

     $sql = $connect->prepare("delete from fas_to_sap_xml_history WHERE idruninfo = :idruninfo ");
     $sql->bindParam(':idruninfo', $idrunfin);   
     $sql->execute();

     $sql = $connect->prepare("update   fas_to_sap set processed = 'N' WHERE idruninfo = :idruninfo ");
          $sql->bindParam(':idruninfo', $idrunfin);   
     $sql->execute();
     
	
					
 echo json_encode($return_arr);
 
 
 



?>
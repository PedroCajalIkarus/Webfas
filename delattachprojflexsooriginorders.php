<?php
error_reporting(0);
//control ataques de querystring
if( $_REQUEST['mkt_tok']<> '')
{
  echo "Error...";
  exit();
}

// Desactivar toda notificación de error
error_reporting(0);

include("db_conect.php"); 
	header('Content-Type: application/json');
	
    session_start();
     $return_result_insert="noaction";

  ///v0=2&v1=1&v2=f92e80f0
  
     $vidfile = $_REQUEST['v2'];
     
	      
	
	try {

             
					$msjerr= "  " ;
                    $sentenciahonwywell = $connect->prepare("DELETE from orders_fileattach  WHERE idordersfileat=:idnroattach");
                          
                $sentenciahonwywell->bindParam(':idnroattach', $vidfile);
                $sentenciahonwywell->execute();   
                $return_result_insert="ok"; 

                $vuserfas = $_SESSION["b"];
                $vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
                $vaccionweb="Delete File SO ";
                $vdescripaudit="Delete File SO idfile:". $vidfile;	
                $vtextaudit= "delete from orders_fileattach WHERE idordersfileat=".$vidfile;

                $sentenciaudit = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
                $sentenciaudit->bindParam(':userfas', $vuserfas);								
                $sentenciaudit->bindParam(':menuweb', $vmenufas);
                $sentenciaudit->bindParam(':actionweb', $vaccionweb);
                $sentenciaudit->bindParam(':descripaudit', $vdescripaudit);
                $sentenciaudit->bindParam(':textaudit', $vtextaudit);
                $sentenciaudit->execute();

                                     
				} 
				catch (PDOException $e) 
				{
					
				
					$msjerr= "Syntax Error MM: ".$e->getMessage();
						
					
				}
	

 echo(json_encode(["ok"=>$return_result_insert,"statusText"=>$msjerr]));

?>

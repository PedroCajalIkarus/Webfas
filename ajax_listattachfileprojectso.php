<?php
// Desactivar toda notificación de error
error_reporting(0);
//control ataques de querystring
if( $_REQUEST['mkt_tok']<> '')
{
  echo "Error...";
  exit();
}
    


include("db_conect.php"); 
	header('Content-Type: application/json');
   
    $vidseed = $_REQUEST['idtype'];
 
        $sqlproject = "SELECT * FROM orders_fileattach_draft  where   seedtemp = '".$vidseed ."' and active = 'draft'";
   //     $sqlproject = "SELECT * FROM orders_fileattach_draft  where   seedtemp = '".$vidseed ."'  ";
 ///echo  $sqlproject;
        $msjnotdata = 0;
        $resultado = $connect->query($sqlproject)->fetchAll();	
  
     foreach ($resultado as $row2) {
        
         $arr_idband[] = array("idnroattach" => $row2['idordersfileat'],
                                    "fileattach" => str_replace( $row2['seedtemp']."_"," ",$row2['namefileattach'] )
                                    );
     }



	

 echo(json_encode(["attachlist"=>$arr_idband]));

?>

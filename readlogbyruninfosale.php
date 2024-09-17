<?php
  include("db_conect.php");
  $vidlog = $_REQUEST['idlog'];
  
  
  ///Agregar control si el idruninfo es de la empresa del usuario para filtra extraccion de informacion.
	  $sql = $connect->prepare('SELECT loginfo FROM runinfo WHERE idruninfo = :vidruninfo ');
	  $sql->bindParam(':vidruninfo', $vidlog);
    $sql->execute();
    $resultado = $sql->fetchAll();
		
	$str     = "Line 1\nLine 2\rLine 3\r\nLine 4\n";
$order   = array("\\r\\n", "\\n", "\\r");
$replace = ' <br> ';

// Procesa primero \r\n así no es convertido dos veces.
//$newstr = str_replace($order, $replace, $row[0]);

	 foreach ($resultado as $row) {
		 
	//echo  str_replace("\\n", $replace, $row[0]);
  	echo $row[0];
	 }
 

?>
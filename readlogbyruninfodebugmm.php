<?php
  include("db_conect.php");
  $vidlog = $_REQUEST['idlog'];
  
   include ('licencefiplex_mm.php');
 
 //  //   $Encryption = new Encryption();
  ///Agregar control si el idruninfo es de la empresa del usuario para filtra extraccion de informacion.
  
  $vidlog = 10986131326;
 echo 'SELECT dateinfo, loginfo,userruninfo, station, device  FROM runinfodb WHERE   idruninfodb =   '. $vidlog;
///	$sql = $connect->prepare('SELECT dateinfo, loginfo,userruninfo, station, device  FROM runinfodb WHERE idruninfo = :vidruninfo  or  idruninfodb = :vidruninfo ');	  
	  $sql = $connect->prepare('SELECT dateinfo, loginfo,userruninfo, station, device  FROM runinfodb WHERE   idruninfodb = :vidruninfo ');
	  $sql->bindParam(':vidruninfo', $vidlog);
    $sql->execute();
    $resultado = $sql->fetchAll();
		
	$str     = "Line 1\nLine 2\rLine 3\r\nLine 4\n";
$order   = array("\\r\\n", "\\n", "\\r");
$replace = ' <br> ';

// Procesa primero \r\n así no es convertido dos veces.
//$newstr = str_replace($order, $replace, $row[0]);

	
/// forma vieja
$encontrodatosconbarran = 'N';
echo "<br>aaaa".$vmostrar;
exit();
foreach ($resultado as $row) 
	 {
		 $vuserruninfo = $row[2];
		$vstation = $row[3];
		$vdevice = $row[4];
		
					 
				$porciones = explode("\n", $row[1]);
		
				$vmostrar = "".trim(substr($row[0],0,10))."\r\n";
					foreach ($porciones as &$valor) {
						$encontrodatosconbarran = 'Y';
					//	$pos = 	strstr($valor, '###',true);
						
					$vmostrar = $vmostrar." ".str_replace("###","",str_replace("<br>","\r\n ",str_replace("$$$","",$valor)))."\r\n";
				}
 
	 }

	 echo "<br>bb".$vmostrar;
 
//echo(json_encode(["vuser"=>trim($vuserruninfo),"vstation"=>trim($vstation),"vdecice"=>trim($vdevice), "data"=>trim($vmostrar)]));
?>
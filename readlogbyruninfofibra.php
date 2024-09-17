<?php
  include("db_conect.php");
  $vidlog = $_REQUEST['idlog'];
  
   include ('licencefiplex_mm.php');
 
 
 //// BUSCAMOS EL ESTADO DEL PETITION
 $vidpetition = $_REQUEST['idpett'];
  $sqlpetition = $connect->prepare('select * from fas_petitions_server where idpetition = :vidruninfo	 ');
	  $sqlpetition->bindParam(':vidruninfo', $vidpetition);
   $sqlpetition->execute();
    $resultadosupportpet = $sqlpetition->fetchAll();
	 foreach ($resultadosupportpet as $row3) 
	 {
		 $vvresultadpettion= $row3['status'];
	 }
 
 //// FIN BUSCAR ESTADO DEL PETITION
 
 
 //  //   $Encryption = new Encryption();
  ///Agregar control si el idruninfo es de la empresa del usuario para filtra extraccion de informacion.
$vvtienesoporte=0;
 $sqlsuport = $connect->prepare('select fas_techsupport.idfas_techsupport 
	from (
		select fas_techsupport.idfas_techsupport, max(datessupportstate) as maxdia
		from fas_techsupport
		inner join fas_techsupport_state
		on fas_techsupport.idfas_techsupport = fas_techsupport_state.idfas_techsupport
		where fas_techsupport.idruninfo = :vidruninfo					
		group by fas_techsupport.idfas_techsupport
	) as maxestadoxtk
		inner join fas_techsupport
		on maxestadoxtk.idfas_techsupport = fas_techsupport.idfas_techsupport
		inner join fas_techsupport_state
		on maxestadoxtk.idfas_techsupport = fas_techsupport_state.idfas_techsupport and
		maxestadoxtk.maxdia = fas_techsupport_state.datessupportstate 
		inner join fas_techsupport_typestate
		on fas_techsupport_typestate.idtypestate = fas_techsupport_state.idstatesupport	and 
		fas_techsupport_typestate.idtypestate not in (19,20)
		where fas_techsupport.idruninfo = :vidruninfo	 ');
	  $sqlsuport->bindParam(':vidruninfo', $vidlog);
   $sqlsuport->execute();
    $resultadosupport = $sqlsuport->fetchAll();
	 foreach ($resultadosupport as $row) 
	 {
		 $vvtienesoporte= $row['idfas_techsupport'];
	 }
	

	  $sql = $connect->prepare('SELECT dateinfo, loginfo,userruninfo, station, device  FROM runinfodb WHERE idruninfo = :vidruninfo  or  idruninfodb = :vidruninfo');
	  $sql->bindParam(':vidruninfo', $vidlog);
    $sql->execute();
    $resultado = $sql->fetchAll();
		
	$str     = "Line 1\nLine 2\rLine 3\r\nLine 4\n";
$order   = array("<br>");
$replace = ' ';

// Procesa primero \r\n así no es convertido dos veces.
//$newstr = str_replace($order, $replace, $row[0]);
$vmostrar ="";

		$vuserruninfo = "";
		$vstation = "";
		$vdevice = "";
		$vmostrar ="log not registered";
	 foreach ($resultado as $row) 
	 {
		$vuserruninfo = $row[2];
		$vstation = $row[3];
		$vdevice = $row[4];
		
		if ($ipserver=="192.168.70.32")
		{
			$porciones = explode("\n", $row[1]);
				//echo "por \n";
		}
		else
		{
			$porciones = explode("<br> ", $row[1]);
			//echo "por br";
		}
	
		$porciones = explode("\n", $row[1]);
		
			//echo "".trim(substr($row[0],0,10))."\r\n";
		$vmostrar = "".trim(substr($row[0],0,10))."\r\n";
			foreach ($porciones as &$valor) {
			//	$pos = 	strstr($valor, '###',true);
				$pos =substr_count($valor, '###');
				
				//$pos2 = strstr($valor, '$$$',true);
				$pos2 =substr_count($valor, '$$$');
				
				
				//	if ($pos =="" &&  $pos2 =="" )	
					if ($pos ==0 &&  $pos2 ==0 )							
						{
					//	echo "".trim(substr($row[0],0,10))."\r\n".$valor;
						//echo "".$valor."\r\n";
						//$vmostrar = $vmostrar."-mm".$pos."mm-".$valor." *finlinea*\r\n";
						$posbr = 	strstr($valor, '<br>',true);
						if ($posbr =="")
						{
							
							$vmostrar = $vmostrar." ".$valor."\r\n";
						}
						else
						{
						
							$vmostrar = $vmostrar." ".$valor;
							
						}
						
					//	$vmostrar = $vmostrar."".$valor."";
					} 
					///echo "-array:info:".$valor."\r\n";
					//$vmostrar = $vmostrar."".$valor."\r\n";
		}
			
			
			
	   ///echo "TODO:".trim(substr($row[0],0,10))."\r\n".$row[1];
	 }
 
echo(json_encode(["petitiostatus"=>$vvresultadpettion, "vuser"=>trim($vuserruninfo),"tienesupport"=>trim($vvtienesoporte),"vstation"=>trim($vstation),"vdecice"=>trim($vdevice), "data"=>trim($vmostrar)]));
?>
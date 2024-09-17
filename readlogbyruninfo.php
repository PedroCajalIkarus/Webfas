<?php
  include("db_conect.php");
  $vidlog = $_REQUEST['idlog'];
  
   include ('licencefiplex_mm.php');
 
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


	 	 
	 	$datps_outcome="<br><table class='table table-striped table-sm '><tr><th>Reference</th><th>Value</th></tr><tbody>";
	  $sql = $connect->prepare("select 1 as ordersalida, fas_outcome_integral.idtype ,fasoutcometypename, concat( substring(v_date::TEXT,0,19), v_boolean::TEXT, v_integer::TEXT,v_double::TEXT,v_string) as resultado
	  ,'' as scriptname,datetimeref
	  from fas_outcome_integral 
	  inner join fas_outcome_category_type
	  on fas_outcome_category_type.idfasoutcomecat	 = fas_outcome_integral.idfasoutcomecat and	
	  fas_outcome_category_type.idtype				 = fas_outcome_integral.idtype
	  where reference = :vidruninfo  and fas_outcome_integral.idtype <> 12
	  union 
	  select 2, fas_outcome_integral.idtype, fasoutcometypename, concat( substring(v_date::TEXT,0,19), v_boolean::TEXT, v_integer::TEXT,v_double::TEXT,v_string) as resultado
	  ,fas_script_type.scriptname,datetimeref
	  from fas_outcome_integral 
	  inner join fas_outcome_category_type
	  on fas_outcome_category_type.idfasoutcomecat	 = fas_outcome_integral.idfasoutcomecat and	
	  fas_outcome_category_type.idtype				 = fas_outcome_integral.idtype
	  inner join fas_script_type
	  on fas_script_type.idscripttype = fas_outcome_integral.v_integer
	  where reference = :vidruninfo and fas_outcome_integral.idtype =12
	  order by ordersalida, datetimeref, fasoutcometypename,scriptname  	  
				  "	);
				$sql->bindParam(':vidruninfo', $vidlog);
				$sql->execute();
				$resultado_outcome = $sql->fetchAll();
				$slnsareportar ="";
					 foreach ($resultado_outcome as $row_outcome) 
	 					{
							 if ( $row_outcome['idtype'] ==12)
							 {
							 
								$datps_outcome=$datps_outcome."<tr><td> ".$row_outcome['fasoutcometypename']."</td><td> ".$row_outcome['scriptname'];
								//https://webfas.honeywell.com/calibbbureportcharger.php?unitsn=SC19166947&idrun=10993134710
								if ("AcceptBatteryCharger" == $row_outcome['scriptname'] )
								{
									if ( $slnsareportar != "")
									{
									$datps_outcome= 	$datps_outcome."&nbsp;-&nbsp; <a href='https://webfas.honeywell.com/calibbbureportcharger.php?unitsn=".$slnsareportar."&idrun=".$vidlog."' target='_blank'> <i class='nav-icon 	fas fa-chart-line'  style='	font-size:16px'></i> </a> ";	
									}
								}

								if ("AcceptPassive" == $row_outcome['scriptname'] )
								{
									if ( $slnsareportar != "")
									{
									$datps_outcome= 	$datps_outcome."&nbsp;-&nbsp; <a href='https://webfas.honeywell.com/reportefrc.php?hidmenu=Y&sn=".$slnsareportar."&idmb=0&iduldl=0&&idruninfo=".$vidlog."' target='_blank'> <i class='nav-icon 	fas fa-chart-line'  style='	font-size:16px'></i> </a> ";	
									}
								}


								$datps_outcome= 	$datps_outcome."</td></tr>";
							 
							 }
							 else
							 {
								$datps_outcome=$datps_outcome."<tr><td> ".$row_outcome['fasoutcometypename']."</td><td> ".$row_outcome['resultado']."</td></tr>";
								if ($row_outcome['fasoutcometypename'] =="SN")
								{
									$slnsareportar=$row_outcome['resultado'];
								}
							 }
							 
						}


						$datps_outcome=$datps_outcome."</table>";				
	 
	

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
$encontrodatosconbarran = 'N';

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
						$encontrodatosconbarran = 'Y';
						$posbr = 	strstr($valor, '<br>',true);
						if ($posbr =="")
						{
							
							$vmostrar = $vmostrar." ".$valor."\r\n";
						}
						else
						{
						
							$vmostrar = $vmostrar." ".$valor."\r\n";;
							
						}
					///	$vmostrar = $vmostrar."-mm".$posbr."mm-".$valor." *finlinea*\r\n";
					//	$vmostrar = $vmostrar."".$valor."";
					} 
					///echo "-array:info:".$valor."\r\n";
					//$vmostrar = $vmostrar."".$valor."\r\n";
		}
			
		if (		$encontrodatosconbarran =="N" )
		{
		///	$vmostrar ="BLANCO";

			$porciones2 = explode("<br>", $row[1]);
		
			//echo "".trim(substr($row[0],0,10))."\r\n";

			foreach ($porciones2 as &$valor) {
			//	echo $valor."a.a<br>";
			//	$pos = 	strstr($valor, '###',true);
				$pos =substr_count($valor, '###');
				
				//$pos2 = strstr($valor, '$$$',true);
				$pos2 =substr_count($valor, '$$$');
				
				//$vmostrar = $vmostrar." ".$valor."\r\n";;
				//	if ($pos =="" &&  $pos2 =="" )	
					if ( $pos2 ==0 )							
						{

							$vmostrar = $vmostrar." ".$valor."\r\n";;

	
					/*	$posbr = 	strstr($valor, '<br>',true);
						if ($posbr =="")
						{
							
							$vmostrar = $vmostrar." ".$valor."\r\n";
						}
						else
						{
						
							$vmostrar = $vmostrar." ".$valor."\r\n";;
							
						}*/
				
					} 
				
		}



		}
			
			
	   ///echo "TODO:".trim(substr($row[0],0,10))."\r\n".$row[1];
	 }
 
echo(json_encode(["vuser"=>trim($vuserruninfo),"tienesupport"=>trim($vvtienesoporte),"vstation"=>trim($vstation),"vdecice"=>trim($vdevice), "data"=>trim($vmostrar),"dataoutcome"=>$datps_outcome]));
?>
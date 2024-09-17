<?php 

	
// Desactivar toda notificación de error
error_reporting(0);
// Notificar todos los errores de PHP (ver el registro de cambios)
//error_reporting(E_ALL);
 include("db_conect.php"); 
 

			
 
 	session_start();
	    $vparam_vnrounitsn = $_REQUEST['idsndib']; ///


		$sqlnombremand ="SELECT  0+ row_number() OVER () as rnum, idband.description 
		FROM orders_sn 
		INNER JOIN orders_sn_specs
		ON orders_sn_specs.idorders = orders_sn.idorders and
		orders_sn_specs.idnroserie = orders_sn.idnroserie
		inner join idband
		on idband.idband = orders_sn_specs.idband
		 WHERE wo_serialnumber='".$vparam_vnrounitsn."' AND typeregister = 'WO' and orders_sn_specs.typedata ='UNIT'";

$datacabeznomband = $connect->query($sqlnombremand)->fetchAll();


  foreach ($datacabeznomband as $rowheadersnomband) 
  {
	  if (count($datacabeznomband )==1)
	  {
			$nombreband_0=$rowheadersnomband['description'];
			$nombreband_1=$rowheadersnomband['description'];
	  }
	  else
	  {
		if ($rowheadersnomband['rnum']==1)
		{
			$nombreband_0=$rowheadersnomband['description'];
		}
		if ($rowheadersnomband['rnum']==2)
		{
			$nombreband_1=$rowheadersnomband['description'];
		///	echo "aaaaaaaaaaaaa".$nombreband_1;
		}

	  }
	
  }

 $Vjd=0;
 $vtemp_idruninfo=0;
 $sql="SELECT DISTINCT uldl, band , MAX(idrununfo) as idruninfo  from fas_tree_measure inner join  fas_calibration_result
on 
fas_calibration_result.unitsn 	= fas_tree_measure.unitsn and
fas_calibration_result.dibsn	= fas_tree_measure.dibsn and 
fas_calibration_result.idruninfo =  fas_tree_measure.idrununfo  where fas_calibration_result.calibrationscript = true and modelciu in(select distinct  modelciu from products where   idproduct in (select distinct idproduct from products_attributes where v_boolean= true and idattribute = 0) )  and  fas_tree_measure.iduniquebranch like '002%' and fas_tree_measure.unitsn = '".$vparam_vnrounitsn."' GROUP BY uldl,band order by uldl,band ";
								
	//echo $sql."<br>";	
	/*
 $sql="
select fas_tree_measure.uldl, fas_tree_measure.band , idrununfo as idruninfo
from fas_tree_measure
inner join (
SELECT DISTINCT uldl, band , MAX(datetime) as masfechaidruninfo 
from fas_tree_measure inner join  fas_calibration_result
on 
fas_calibration_result.unitsn 	= fas_tree_measure.unitsn and
fas_calibration_result.dibsn	= fas_tree_measure.dibsn and 
fas_calibration_result.idruninfo =  fas_tree_measure.idrununfo  
where fas_calibration_result.calibrationscript = true  and 
modelciu  in('DH7S-A','DH7S-D','DH14EA','DH14CA','DH14CD','DH14ER','DH14ED')
and  fas_tree_measure.iduniquebranch like '002%'
and fas_tree_measure.unitsn = '".$vparam_vnrounitsn."' GROUP BY uldl,band order by uldl,band )
as losmasejecutados
on fas_tree_measure.uldl = losmasejecutados.uldl and
fas_tree_measure.band =  losmasejecutados.band and 
fas_tree_measure.datetime = losmasejecutados.masfechaidruninfo
where fas_tree_measure.unitsn = '".$vparam_vnrounitsn."'";	*/


	//echo $sql."<br>";	 mejoradoo
 $sql="
select fas_tree_measure.uldl, fas_tree_measure.band , idrununfo as idruninfo,  masfechaidruninfo,fas_tree_measure.unitsn, fas_tree_measure.dibsn
from fas_tree_measure
inner join (
SELECT DISTINCT uldl, band , MAX(datetime) as masfechaidruninfo 
from fas_tree_measure inner join  fas_calibration_result
on 
fas_calibration_result.unitsn 	= fas_tree_measure.unitsn and
fas_calibration_result.dibsn	= fas_tree_measure.dibsn and 
fas_calibration_result.idruninfo =  fas_tree_measure.idrununfo  
where fas_calibration_result.calibrationscript = true  and 
  modelciu  in(select distinct  modelciu from products where  idproduct in (select distinct idproduct from products_attributes where v_boolean= true and idattribute = 0) )
and  fas_tree_measure.iduniquebranch like '002%'
and fas_tree_measure.unitsn = '".$vparam_vnrounitsn."' GROUP BY uldl,band order by uldl,band )
as losmasejecutados
on fas_tree_measure.uldl = losmasejecutados.uldl and
fas_tree_measure.band =  losmasejecutados.band and 
fas_tree_measure.datetime = losmasejecutados.masfechaidruninfo
where fas_tree_measure.unitsn = '".$vparam_vnrounitsn."'";	
//echo "<br>4<br>".$sql." -- ok<br>";	


							   $datacabez = $connect->query($sql)->fetchAll();
								$idtemp=0;
								$vejecucion = 1;
								  foreach ($datacabez as $rowheaders) 
								  {
									  
									 
									  $vparam_vnrounitsn = $_REQUEST['idsndib']; ///// "20000000fu";	
									$vparam_band = $rowheaders['band'];
									$vaparam_uldl = $rowheaders['uldl'];
									
										if ( $vtemp_idruninfo <= $rowheaders['idruninfo'])
										{
											 $vtemp_idruninfo=$rowheaders['idruninfo'];
											 $vparam_idruninfo = $rowheaders['idruninfo'];
										}
										else
										{
											$vparam_idruninfo = 0;
											 $vtemp_idruninfo=$rowheaders['idruninfo'];
											 $vparam_idruninfo = $rowheaders['idruninfo'];
										}
									
								  
		
								$tablasacrear = 1;	
						
		
			///inicio tabla calibration  
			if ($tablasacrear == 1)
			{
		 /*	  $query_lista="SELECT fas_tree_measure.totalpass::int as totalpassconvert,  fas_tree_measure.iduniqueop,  fas_step.description as namebranch,  fas_tree_measure.iduniquebranch, fas_tree_measure.unitsn, fas_tree_measure.dibsn, fas_tree_measure.uldl, fas_tree_measure.band
,fas_tree_measure.idrununfo
from fas_tree_measure
inner join fas_tree
on fas_tree.iduniquebranch = fas_tree_measure.iduniquebranch  and fas_tree.idfastree =  1	
inner join fas_step
on fas_step.idfasstep = fas_tree.idfastrepson
where fas_tree_measure.iduniquebranch  in('002007013','00200701B','00200701A','00200701C','00200701B02F0','002007030') and fas_tree_measure.iduniquebranch like '002%' and uldl = ".$vaparam_uldl ." and band = ".$vparam_band." and  unitsn = '".$vparam_vnrounitsn."' and  idrununfo =".$vparam_idruninfo. " order by iduniqueop";
*/
$query_lista="SELECT fas_tree_measure.totalpass::int as totalpassconvert,  fas_tree_measure.iduniqueop,  fas_step.description as namebranch,  fas_tree_measure.iduniquebranch, fas_tree_measure.unitsn, fas_tree_measure.dibsn, fas_tree_measure.uldl, fas_tree_measure.band
,fas_tree_measure.idrununfo
from fas_tree_measure

inner join 
( select iduniquebranch, unitsn, dibsn, uldl, band, idrununfo, max(idrev) as maxidrev from fas_tree_measure
 where fas_tree_measure.iduniquebranch in('002007013','00200701B','00200701A','00200701C','00200701B02F0','002007030') and 
fas_tree_measure.iduniquebranch like '002%' and uldl = ".$vaparam_uldl ." and band = ".$vparam_band." and unitsn = '".$vparam_vnrounitsn."' and  idrununfo =".$vparam_idruninfo. "
 group by iduniquebranch, unitsn, dibsn, uldl, band, idrununfo
) as maxretry on 
maxretry.iduniquebranch	=	fas_tree_measure.iduniquebranch and
maxretry.unitsn			=	fas_tree_measure.unitsn and
maxretry.uldl			=	fas_tree_measure.uldl and 
maxretry.dibsn			=	fas_tree_measure.dibsn and 
maxretry.band 			=	fas_tree_measure.band and 
maxretry.idrununfo 		= 	fas_tree_measure.idrununfo and 
maxretry.maxidrev		=   fas_tree_measure.idrev

inner join fas_tree
on fas_tree.iduniquebranch = fas_tree_measure.iduniquebranch  and fas_tree.idfastree =  1
inner join fas_step
on fas_step.idfasstep = fas_tree.idfastrepson
where   fas_tree_measure.iduniquebranch  in('002007013','00200701B','00200701A','00200701C','00200701B02F0','002007030') and fas_tree_measure.iduniquebranch like '002%' and fas_tree_measure.uldl = ".$vaparam_uldl ." and fas_tree_measure.band = ".$vparam_band." and  fas_tree_measure.unitsn = '".$vparam_vnrounitsn."' and  fas_tree_measure.idrununfo =".$vparam_idruninfo. " order by iduniqueop";


	//		echo "<br>2::::".$query_lista."<br>";
	//	echo "<br>Unit SN: ".$rowheaders['unitsn']." - DibSn   ".$rowheaders['dibsn']." - date last Exec ".$rowheaders['masfechaidruninfo'];
				$v_control_unitns_1ertabla = $rowheaders['unitsn'];
				$v_control_dibsn_1ertabla = $rowheaders['dibsn'];
				$v_control_fecha_1ertabla = $rowheaders['masfechaidruninfo'];
									
				  $dataresumen = $connect->query($query_lista)->fetchAll();
				  
				
				  ?>
        
                    <tr>
					<td align="left"><?php 
						if ($vaparam_uldl ==0)
						{
					 	    $label_ULDL_amostrar ="Uplink";
						}
						else
						{
							$label_ULDL_amostrar ="Downlink";
						}
					
						if ($vparam_band ==0)
						{
					 	    $label_band_amostrar = $nombreband_0; //"700 FirstNet";
						}
						else
						{
							$label_band_amostrar = $nombreband_1; //"800";
						}
					
					echo "".$label_band_amostrar ." - ".$label_ULDL_amostrar; ?></td>
					<td align="center">   <a href="#" onclick="openpopupframe('<?php echo $vparam_vnrounitsn; ?>',<?php echo $vparam_band; ?>,<?php echo $vaparam_uldl; ?>,'<?php echo $vparam_idruninfo; ?>')"> <i class="fas fa-search"></i></a></td>
					<td align="center">  <a href="#" onclick="openpopupframe2('<?php echo $vparam_vnrounitsn; ?>',<?php echo $vparam_band; ?>,<?php echo $vaparam_uldl; ?>,'<?php echo $vparam_idruninfo; ?>')"> <i class="fas fa-search"></i></a> </td>
                       <?php
					   $vi=0;
					   $imgesperar = 0;
					   $tieneinfodecalibration ="N";
					    foreach ($dataresumen as $rowresult) 
						{
							 $vi= $vi + 1;
							    $tieneinfodecalibration ="S";
							if ($rowresult['totalpassconvert'] =="0")
							{
									echo "<td align='center'><span class='badge badge-pill badge-danger'>Not Passed </span></td>";
							}
							else
							{	
								if ($rowresult['totalpassconvert'] =="1")
								{
										echo "<td align='center'><span class='badge badge-pill badge-success'>Passed</span></td>";
								}
								else
								{
									
									if ($imgesperar ==0)
									{
										$imgesperar = 1;
										echo "<td align='center'> - </td>";
									}
									else
									{
										echo "<td align='center'> - </td>";
									}
										
								}
							}
							
							
						}
						if ( $vi==0)
						{
							if ($tieneinfodecalibration =="S")
									{
										$imgesperar = 1;
										echo "<td align='left'> <a href='logdb.php?idab=".$vparam_idruninfo.";' target='_blank' style='color:#f39323;'>View Log <i class='fas fa-eye'></i></a> </td>";
									}
									
							?>
							
							<td align='center'> - </td>
							<td align='center'> - </td>
							<td align='center'> - </td>
							<td align='center'> - </td>
						
							<?php
						}
					  ?>
                    </tr>
								  <?php 

			}
			 
								  }
								  
								  	if ($tieneinfodecalibration =="S")
									{
										
																		
								  
								  echo "<tr><td colspan=8 align='center'> <a href='logdb.php?idab=".$vparam_idruninfo."' target='_blank' style='color:#f39323;'>View Log <i class='fas fa-eye'></i></a> </td></tr>";
								
								  ?>
								  </table>
								  <table>
								  <thead><tr class="thead-dark"><th>Ref: </th><th>After burnin Check:</th><th>Status:<br> Gain</th><th>Status:<br>MaxPower</th><th> Status:<br> NF</th><th> Status:<br> IMD</th><th> Status:<br> Spurious</th></tr></thead>
								  <?php
								    }
									else
									{
								  echo "<tr><td colspan=8 align='center'>Calibration: no information is registered</td></tr>";
										
									}
								   
								   if  ($tieneinfodecalibration =="S")
								   {
			////inicio tabla finalchk	
			
$mostrar_errores  = 0;			
 $sql="SELECT DISTINCT uldl, band , MAX(idrununfo) as idruninfo  from fas_tree_measure inner join  fas_calibration_result
on 
fas_calibration_result.unitsn 	= fas_tree_measure.unitsn and
fas_calibration_result.dibsn	= fas_tree_measure.dibsn and 
fas_calibration_result.idruninfo =  fas_tree_measure.idrununfo  where fas_calibration_result.calibrationscript = false and  fas_tree_measure.iduniquebranch like '002%' and fas_tree_measure.unitsn = '".$vparam_vnrounitsn."' GROUP BY uldl,band order by uldl,band ";

 $sql="
select fas_tree_measure.uldl, fas_tree_measure.band , idrununfo as idruninfo , masfechaidruninfo , fas_tree_measure.unitsn, fas_tree_measure.dibsn
from fas_tree_measure
inner join fas_tree
on fas_tree.iduniquebranch = fas_tree_measure.iduniquebranch  and fas_tree.idfastree =  1
inner join (
SELECT DISTINCT uldl, band , MAX(datetime) as masfechaidruninfo 
from fas_tree_measure inner join  fas_calibration_result
on 
fas_calibration_result.unitsn 	= fas_tree_measure.unitsn and
fas_calibration_result.dibsn	= fas_tree_measure.dibsn and 
fas_calibration_result.idruninfo =  fas_tree_measure.idrununfo  
where fas_calibration_result.calibrationscript = false and   fas_calibration_result.modelciu  in(select distinct  modelciu from products where   idproduct in (select distinct idproduct from products_attributes where v_boolean= true and idattribute = 0) ) 
and fas_tree_measure.unitsn = '".$vparam_vnrounitsn."' GROUP BY uldl,band order by uldl,band )
as losmasejecutados
on fas_tree_measure.uldl = losmasejecutados.uldl and
fas_tree_measure.band =  losmasejecutados.band and 
fas_tree_measure.datetime = losmasejecutados.masfechaidruninfo
where  fas_tree_measure.unitsn = '".$vparam_vnrounitsn."'";							
	//echo "la2<br>".$sql."<br> ---- ------- ----- <br>";							
					   $datacabez = $connect->query($sql)->fetchAll();
								$idtemp=0;
								$vejecucion = 1;
								  foreach ($datacabez as $rowheaders) 
								  {
									  
									 
									 	$v_control_unitns_2ertabla = $rowheaders['unitsn'];
										$v_control_dibsn_2ertabla = $rowheaders['dibsn'];
										$v_control_fecha_2ertabla = $rowheaders['masfechaidruninfo'];
				
									 
									  $vparam_vnrounitsn = $_REQUEST['idsndib']; ///// "20000000fu";	
									$vparam_band = $rowheaders['band'];
									$vaparam_uldl = $rowheaders['uldl'];
									 $vparam_idruninfo = $rowheaders['idruninfo'];
									/*	if ( $vtemp_idruninfo <= $rowheaders['idruninfo'])
										{
											 $vtemp_idruninfo=$rowheaders['idruninfo'];
											 $vparam_idruninfo = $rowheaders['idruninfo'];
										}
										else
										{
											$vparam_idruninfo = 0;
										//	echo "ACA IDRUNINFO A 0";
										}*/
								
								  
			$queryestadoejec = "select * from fas_calibration_result where	  unitsn = '".$vparam_vnrounitsn."' and  idruninfo =".$vparam_idruninfo. "  and calibrationscript=false  "	;
			//	$queryestadoejec = "select * from fas_calibration_result where	  unitsn = '".$vparam_vnrounitsn."' and calibrationscript=true  "	;
			
		//	echo $queryestadoejec."<br> <--- aca el result<br>" ;
			  $dataresumenejec = $connect->query($queryestadoejec)->fetchAll();
			  $tablasacrear = 0;
			   foreach ($dataresumenejec as $rowresultexec) 
						{
							if ($rowresultexec['calibrationscript'] ==false)
							{
								$tablasacrear = 2;	
							}
						}	
						
			//echo "HOLA".$tablasacrear;
			//	$tablasacrear = 2;	
			
			///inicio tabla calibration  
			if ($tablasacrear == 2)
			{
		  $query_lista="SELECT fas_tree_measure.totalpass::int as totalpassconvert,  fas_tree_measure.iduniqueop,  fas_step.description as namebranch,  fas_tree_measure.iduniquebranch, fas_tree_measure.unitsn, fas_tree_measure.dibsn, fas_tree_measure.uldl, fas_tree_measure.band
,fas_tree_measure.idrununfo
from fas_tree_measure

inner join 
( select iduniquebranch, unitsn, dibsn, uldl, band, idrununfo, max(idrev) as maxidrev from fas_tree_measure
 where fas_tree_measure.iduniquebranch in('002007013','00200701B','00200701A','00200701C','00200701B02F0','002007030') and 
fas_tree_measure.iduniquebranch like '002%' and uldl = ".$vaparam_uldl ." and band = ".$vparam_band." and unitsn = '".$vparam_vnrounitsn."' and  idrununfo =".$vparam_idruninfo. "
 group by iduniquebranch, unitsn, dibsn, uldl, band, idrununfo
) as maxretry on 
maxretry.iduniquebranch	=	fas_tree_measure.iduniquebranch and
maxretry.unitsn			=	fas_tree_measure.unitsn and
maxretry.uldl			=	fas_tree_measure.uldl and 
maxretry.dibsn			=	fas_tree_measure.dibsn and 
maxretry.band 			=	fas_tree_measure.band and 
maxretry.idrununfo 		= 	fas_tree_measure.idrununfo and 
maxretry.maxidrev		=   fas_tree_measure.idrev

inner join fas_tree
on fas_tree.iduniquebranch = fas_tree_measure.iduniquebranch  and fas_tree.idfastree =  1
inner join fas_step
on fas_step.idfasstep = fas_tree.idfastrepson
where   fas_tree_measure.iduniquebranch  in('002007013','00200701B','00200701A','00200701C','00200701B02F0','002007030') and fas_tree_measure.iduniquebranch like '002%' and fas_tree_measure.uldl = ".$vaparam_uldl ." and fas_tree_measure.band = ".$vparam_band." and  fas_tree_measure.unitsn = '".$vparam_vnrounitsn."' and  fas_tree_measure.idrununfo =".$vparam_idruninfo. " order by iduniqueop";

//		echo "<br>aca en final chk<br>".$query_lista."<br>";
		
		if ( $v_control_unitns_2ertabla  ==  $v_control_unitns_1ertabla )
		{
			if ( $v_control_dibsn_2ertabla != $v_control_dibsn_1ertabla    )
			{
				if ($mostrar_errores  == 0)
				{
			//	echo "<br<p class='alert-danger'> *** Error in the calibration process and final check. <br>The digital board was changed ...!!!! </p> ";
				?>
				<div class="alert alert-danger alert-dismissible">
                  
                  <h5><i class="icon fas fa-ban"></i> Alert!... Error in the sequence of the calibration process.</h5>
                  The digital board was changed ...!!!! <br>
				  - calibrated with DibSN: <?php echo $v_control_dibsn_1ertabla;   ?><br>
				  - Final Check with DibSN : <?php echo $v_control_dibsn_2ertabla;   ?><br>
                </div>
				<?php
				$mostrar_errores  = 1;
				}
			}
		}
		
		
				  $dataresumen = $connect->query($query_lista)->fetchAll();
				  
				  ?>
        
                    <tr>
					<td align="left"><?php 
						if ($vaparam_uldl ==0)
						{
					 	    $label_ULDL_amostrar ="Uplink";
						}
						else
						{
							$label_ULDL_amostrar ="Downlink";
						}
				
						if ($vparam_band ==0)
						{
					 	    $label_band_amostrar = $nombreband_0; //"700 FirstNet";
						}
						else
						{
							$label_band_amostrar = $nombreband_1; //"800";
						}
					
					echo "".$label_band_amostrar ." - ".$label_ULDL_amostrar; ?></td>
				
					<td align="center">   <a href="#" onclick="openpopupframe2('<?php echo $vparam_vnrounitsn; ?>',<?php echo $vparam_band; ?>,<?php echo $vaparam_uldl; ?>,'<?php echo $vparam_idruninfo; ?>')"> <i class="fas fa-search"></i></a></td>
                       <?php
					   $vi=0;
					   $imgesperar = 0;
					    foreach ($dataresumen as $rowresult) 
						{
							 $vi= $vi + 1;
							if ($rowresult['totalpassconvert'] =="0")
							{
									echo "<td align='center'><span class='badge badge-pill badge-danger'>Not Passed </span></td>";
							}
							else
							{	
								if ($rowresult['totalpassconvert'] =="1")
								{
										echo "<td align='center'><span class='badge badge-pill badge-success'>Passed</span></td>";
								}
								else
								{
									
									if ($imgesperar ==0)
									{
										$imgesperar = 1;
										echo "<td align='center'> - </td>";
									}
									else
									{
										echo "<td align='center'> - </td>";
									}
										
								}
							}
							
							
						}
						if ( $vi==0)
						{
							if ($imgesperar ==0)
									{
										$imgesperar = 1;
										echo "<td align='center'> - </td>";
									}
									else
									{
										echo "<td align='center'> - </td>";
									}
							?>
							
							<td align='center'> - </td>
							<td align='center'> - </td>
							<td align='center'> - </td>
							<td align='center'> - </td>
						
							<?php
						}
					  ?>
                    </tr>
								  <?php 
							  
			}
			
			///fin tabla finalchk
				
								  
						    }
						echo "<tr><td colspan=8 align='center'> <a href='logdb.php?idab=".$vparam_idruninfo."' target='_blank' style='color:#f39323;'>View Log <i class='fas fa-eye'></i></a> </td></tr>";
						  
			} 
// FIN IF muestros la 2da tablas			
								  ?>
			
			
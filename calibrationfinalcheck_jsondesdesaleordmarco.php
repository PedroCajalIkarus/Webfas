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
		 WHERE wo_serialnumber='".$vparam_vnrounitsn."' AND typeregister = 'SO' and orders_sn_specs.typedata ='UNIT'";

$datacabeznomband = $connect->query($sqlnombremand)->fetchAll();

//echo "HOla Cant de REg".count($datacabeznomband );

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
fas_calibration_result.idruninfo =  fas_tree_measure.idrununfo  where fas_calibration_result.calibrationscript = false and modelciu not in(select distinct  modelciu from products where typeproduct =  idproduct in (select distinct idproduct from products_attributes where v_boolean= true and idattribute = 0))  and  fas_tree_measure.iduniquebranch like '002%' and fas_tree_measure.unitsn = '".$vparam_vnrounitsn."' GROUP BY uldl,band order by uldl,band ";

// Version mejorada

 $sql="
select fas_tree_measure.uldl, fas_tree_measure.band , fas_tree_measure.idrununfo as idruninfo
from fas_tree_measure
inner join (
SELECT DISTINCT uldl, band , MAX(datetime) as masfechaidruninfo 
from fas_tree_measure inner join  fas_calibration_result
on 
fas_calibration_result.unitsn 	= fas_tree_measure.unitsn and
fas_calibration_result.dibsn	= fas_tree_measure.dibsn and 
fas_calibration_result.idruninfo =  fas_tree_measure.idrununfo  
where fas_calibration_result.calibrationscript = true 
and modelciu not in(select distinct  modelciu from products where  idproduct in (select distinct idproduct from products_attributes where v_boolean= true and idattribute = 0))
and  fas_tree_measure.iduniquebranch like '002%'
and fas_tree_measure.unitsn = '".$vparam_vnrounitsn."' GROUP BY uldl,band order by uldl,band )
as losmasejecutados
on fas_tree_measure.uldl = losmasejecutados.uldl and
fas_tree_measure.band =  losmasejecutados.band and 
fas_tree_measure.datetime = losmasejecutados.masfechaidruninfo

inner join (
	select unitsn, idrununfo,  iduniquebranch, max(idrev) as maxidrev
from fas_tree_measure where
fas_tree_measure.iduniquebranch like '002%'  and unitsn = '".$vparam_vnrounitsn."' 
group by unitsn, idrununfo,iduniquebranch
) as maxretry
on maxretry.unitsn			=	fas_tree_measure.unitsn and
maxretry.idrununfo			=	fas_tree_measure.idrununfo and 
maxretry.iduniquebranch		=	fas_tree_measure.iduniquebranch and
maxretry.maxidrev 			=	fas_tree_measure.idrev



where fas_tree_measure.unitsn = '".$vparam_vnrounitsn."'";	


echo $sql;

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
						
		
			
			 
								  }
								  
								   
								
								  ?>
								 <p align="right"> <a href="calibrationtopdfconimgsaleorders.php?idsndib=<?php echo  $vparam_vnrounitsn;?>&amp;iduldl=0&amp;idmb=0" target="_blank"><img src="iconopdf.jpg" width="30px"></a>
								 </p>
								 <table class='table table-sm table-bordered textotabla10'>
								  <thead><tr class="thead-dark"><th>Ref: </th><th>Final Check:</th><th>Status:<br> Gain</th><th>Status:<br>MaxPower</th><th> Status:<br> NF</th><th> Status:<br> IMD</th><th> Status:<br> Spurious</th></tr></thead>
								  <?php
								  
			////inicio tabla finalchk	
 $sql="SELECT DISTINCT uldl, band , MAX(idrununfo) as idruninfo  from fas_tree_measure inner join  fas_calibration_result
on 
fas_calibration_result.unitsn 	= fas_tree_measure.unitsn and
fas_calibration_result.dibsn	= fas_tree_measure.dibsn and 
fas_calibration_result.idruninfo =  fas_tree_measure.idrununfo  where fas_calibration_result.calibrationscript = false and  fas_tree_measure.iduniquebranch like '002%' and fas_tree_measure.unitsn = '".$vparam_vnrounitsn."' GROUP BY uldl,band order by uldl,band ";
							
//	echo $sql."<br> ---- ------- ----- <br>";	
// Version mejorada

 $sql="
select fas_tree_measure.uldl, fas_tree_measure.band , idrununfo as idruninfo
from fas_tree_measure
inner join fas_tree
on fas_tree.iduniquebranch = fas_tree_measure.iduniquebranch  and fas_tree.idfastree =  1
inner join (
SELECT DISTINCT fas_calibration_result.modelciu, uldl, band , MAX(datetime) as masfechaidruninfo 
from fas_tree_measure inner join  fas_calibration_result
on 
fas_calibration_result.unitsn 	= fas_tree_measure.unitsn and
fas_calibration_result.dibsn	= fas_tree_measure.dibsn and 
fas_calibration_result.idruninfo =  fas_tree_measure.idrununfo  
where fas_calibration_result.calibrationscript = false and   fas_calibration_result.modelciu not in(select distinct  modelciu from products where  idproduct in (select distinct idproduct from products_attributes where v_boolean= true and idattribute = 0)) 
and fas_tree_measure.unitsn = '".$vparam_vnrounitsn."' GROUP BY fas_calibration_result.modelciu, uldl,band order by uldl,band )
as losmasejecutados
on fas_tree_measure.uldl = losmasejecutados.uldl and
fas_tree_measure.band =  losmasejecutados.band and 
fas_tree_measure.datetime = losmasejecutados.masfechaidruninfo

where  fas_tree_measure.unitsn = '".$vparam_vnrounitsn."'
and idrununfo in (  select max( idrununfo) 
from fas_tree_measure
inner join (
SELECT DISTINCT fas_calibration_result.modelciu, uldl, band , MAX(datetime) as masfechaidruninfo  
from fas_tree_measure 
inner join fas_tree
on fas_tree.iduniquebranch = fas_tree_measure.iduniquebranch  and fas_tree.idfastree =  1
inner join  fas_calibration_result
on 
fas_calibration_result.unitsn 	= fas_tree_measure.unitsn and
fas_calibration_result.dibsn	= fas_tree_measure.dibsn and 
fas_calibration_result.idruninfo =  fas_tree_measure.idrununfo
			where fas_tree_measure.iduniquebranch like '002%' and fas_calibration_result.modelciu not in(select distinct  modelciu from products where  idproduct in (select distinct idproduct from products_attributes where v_boolean= true and idattribute = 0)) 
			 and fas_tree_measure.unitsn = '".$vparam_vnrounitsn."' GROUP BY fas_calibration_result.modelciu, fas_tree_measure.uldl,fas_tree_measure.band   )
as losmasejecutados
on fas_tree_measure.uldl = losmasejecutados.uldl and
fas_tree_measure.band =  losmasejecutados.band and 
fas_tree_measure.datetime = losmasejecutados.masfechaidruninfo




where fas_tree_measure.unitsn = '".$vparam_vnrounitsn."' )";								
echo "la2<br>".$sql."<br> ---- ------- ----- <br>";							
					   $datacabez = $connect->query($sql)->fetchAll();
								$idtemp=0;
								$vejecucion = 1;
								  foreach ($datacabez as $rowheaders) 
								  {
									  
									 
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
										}*/
								
								  
			$queryestadoejec = "select * from fas_calibration_result where	  unitsn = '".$vparam_vnrounitsn."' and  idruninfo =".$vparam_idruninfo. "  and calibrationscript=false  "	;
			//	$queryestadoejec = "select * from fas_calibration_result where	  unitsn = '".$vparam_vnrounitsn."' and calibrationscript=true  "	;
			
			//echo $queryestadoejec."<br>" ;
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
				$tablasacrear = 2;	
			
			///inicio tabla calibration  
			if ($tablasacrear == 2)
			{
	/*	  $query_lista="SELECT distinct fas_tree_measure.totalpass::int as totalpassconvert,  fas_tree_measure.iduniqueop,  fas_step.description as namebranch,  fas_tree_measure.iduniquebranch, fas_tree_measure.unitsn, fas_tree_measure.dibsn, fas_tree_measure.uldl, fas_tree_measure.band
,fas_tree_measure.idrununfo
from fas_tree_measure
inner join fas_tree
on fas_tree.iduniquebranch = fas_tree_measure.iduniquebranch  and fas_tree.idfastree =  1
inner join fas_step
on fas_step.idfasstep = fas_tree.idfastrepson
where   fas_tree_measure.iduniquebranch  in('002007013','00200701B','00200701A','00200701C','00200701B02F0','002007030') and fas_tree_measure.iduniquebranch like '002%' and uldl = ".$vaparam_uldl ." and band = ".$vparam_band." and  unitsn = '".$vparam_vnrounitsn."' and  idrununfo =".$vparam_idruninfo. " order by iduniqueop";
*/
$query_lista="SELECT distinct fas_tree_measure.totalpass::int as totalpassconvert,  fas_tree_measure.iduniqueop,  fas_step.description as namebranch,  fas_tree_measure.iduniquebranch, fas_tree_measure.unitsn, fas_tree_measure.dibsn, fas_tree_measure.uldl, fas_tree_measure.band
,fas_tree_measure.idrununfo
from fas_tree_measure
inner join fas_tree
on fas_tree.iduniquebranch = fas_tree_measure.iduniquebranch  and fas_tree.idfastree =  1
inner join fas_step
on fas_step.idfasstep = fas_tree.idfastrepson

inner join (
	select unitsn, idrununfo,  iduniquebranch, max(idrev) as maxidrev
from fas_tree_measure where
iduniquebranch in('002007013','00200701B','00200701A','00200701C','00200701B02F0','002007030') and fas_tree_measure.uldl = ".$vaparam_uldl ." and fas_tree_measure.band = ".$vparam_band." and  fas_tree_measure.unitsn = '".$vparam_vnrounitsn."' and  fas_tree_measure.idrununfo =".$vparam_idruninfo. "
group by unitsn, idrununfo,iduniquebranch
) as maxretry
on maxretry.unitsn			=	fas_tree_measure.unitsn and
maxretry.idrununfo			=	fas_tree_measure.idrununfo and 	
maxretry.iduniquebranch		=	fas_tree_measure.iduniquebranch and
maxretry.maxidrev 			=	fas_tree_measure.idrev

where   fas_tree_measure.iduniquebranch  in('002007013','00200701B','00200701A','00200701C','00200701B02F0','002007030') and fas_tree_measure.iduniquebranch like '002%' and fas_tree_measure.uldl = ".$vaparam_uldl ." and fas_tree_measure.band = ".$vparam_band." and  fas_tree_measure.unitsn = '".$vparam_vnrounitsn."' and  fas_tree_measure.idrununfo =".$vparam_idruninfo. " order by iduniqueop";

		echo "<br>3:".$query_lista."<br>";
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
				
					<td align="center">   <a href="#" onclick="openpopupframe2('<?php echo $vparam_vnrounitsn; ?>',<?php echo $vparam_band; ?>,<?php echo $vaparam_uldl; ?>,'<?php echo $vparam_idruninfo; ?>','<?php echo $label_band_amostrar; ?>')"> <i class="fas fa-search"></i></a></td>
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
							
							if ( count($datacabez) >0)
									{
						echo "<tr><td colspan=8 align='center'> <a href='logdb.php?idab=".$vparam_idruninfo."' target='_blank' style='color:#f39323;'>View Log <i class='fas fa-eye'></i></a> </td></tr>";
						  
									} 
								  ?>
			
			
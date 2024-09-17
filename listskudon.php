<?php

error_reporting(0);
// Notificar todos los errores de PHP (ver el registro de cambios)
//error_reporting(E_ALL);
 include("db_conect.php"); 
 
 
 

	
	$sql = $connect->prepare("	select distinct DATE_PART('year',dateserver) as yearmm,   DATE_PART('week',dateserver) as weekmm,  to_char(dateserver,'YYYY/MM/DD') as daymm, 
	station, count( distinct fas_calibration_result.idruninfo) as cc,   ARRAY_AGG(  unitsn ) as arrayunitsn,ARRAY_AGG(  modelciu ) as arrayciu
from fas_calibration_result 
inner join runinfodb
on runinfodb.idruninfodb = fas_calibration_result.idruninfo
where fas_calibration_result.totalpass= true and calibrationscript=FALSE
and  runinfodb.dateserver > '2021-01-01'
and idruninfodb <30000000000 and station <> 'Station 02' and station <> 'Station 03 Augusto' and station <> 'Station 02 FUSA JC'
and modelciu not in (select modelciu from products where idproduct in (select idproduct from products_attributes where idattribute = 0) )
group by DATE_PART('year',dateserver)  ,   DATE_PART('week',dateserver)  ,  to_char(dateserver,'YYYY/MM/DD')  , station
 ");

 
 $sql = $connect->prepare("
select distinct DATE_PART('year',dateserver) as yearmm,   DATE_PART('week',dateserver) as weekmm,  to_char(dateserver,'YYYY/MM/DD') as daymm, 
station, count( distinct fas_calibration_result.idruninfo) as cc,   ARRAY_AGG( distinct  unitsn ) as arrayunitsn,ARRAY_AGG( distinct fas_calibration_result.modelciu ) as arrayciu
,ARRAY_AGG(distinct full_tree_namever_allbusiness(  iduniquebranchsonprod,'a') ) as arraybracn
from fas_calibration_result 
inner join runinfodb
on runinfodb.idruninfodb = fas_calibration_result.idruninfo
left join fnt_select_allproducts_maxrev() as products
on products.modelciu = fas_calibration_result.modelciu
where fas_calibration_result.totalpass= true and calibrationscript=FALSE
and  runinfodb.dateserver > '2021-01-01'
and idruninfodb <30000000000 and station <> 'Station 02' and station <> 'Station 03 Augusto' and station <> 'Station 02 FUSA JC'
and fas_calibration_result.modelciu not in (select modelciu from products where idproduct in (select idproduct from products_attributes where idattribute = 0) )

group by DATE_PART('year',dateserver)  ,   DATE_PART('week',dateserver)  ,  to_char(dateserver,'YYYY/MM/DD')  , station
");



	
		$sql->execute();
		$resultado3 = $sql->fetchAll();
	 
	 



								?>
										 <table class="table table-striped table-bordered table-sm" name="exampledin0" id="exampledin0">
																												   <thead>
																													 <tr>
																													   
																													 
																													  
																													  <th class="bg-primary">Week</th>
																													  <th class="bg-primary">Day</th>
																															<th class="bg-primary">Station</th>
																															 <th class="bg-primary">Quantities</th>	
																															 <th class="bg-primary">SN</th>	
																															 <th class="bg-primary">CIU</th>															  
																												 
																													  
																													 </tr>
																												   </thead>
																												   <tbody>
								<?php
										foreach ($resultado3 as $row2) 
										{
											$indparamaxregxrma = $indparamaxregxrma + 1;
											$marcar_ultimo =trim($row2['cantxrama']);
											$cantdenegritas=1;
											$vvidfas_firmwarelist = $row2['idfas_firmwarelist']; 
										?>
															<tr>
													 
															<td  ><?php echo  $row2['weekmm'];  ?></td>
															<td  ><?php echo  $row2['daymm'];  ?></td>
															<td  ><?php echo  $row2['station'];  ?></td>
															<td  ><?php echo  $row2['cc'];  ?></td>															  
															<td  ><?php echo  $row2['arrayunitsn'];  ?></td>															  
															<td  ><?php echo  $row2['arrayciu'];  ?></td>															  


															</tr>
																										
																												 
															 
																													 
																									  
														   <?php
										}
										
													 
 
														?>   <script>
														$('#exampledin0').DataTable( {
																		  "order": [[ 0, "desc" ]]
																	  } );
																	  
													 
													  </script>
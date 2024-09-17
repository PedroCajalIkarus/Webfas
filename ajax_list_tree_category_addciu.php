<?php
 include("db_conect.php"); 
	
	header('Content-Type: application/json');
$array = array();	


$vv_ciupram = $_REQUEST['ciupram'];

	$query_lista = "select 1 as resultado,idproduct from products_label where idproduct in (select idproduct from products where modelciu = '".$vv_ciupram."')
	union
	select 2,idproduct from fas_documentation where idproduct in (select idproduct from products where modelciu = '".$vv_ciupram."')
	union
	select 3,idproduct from objectband where idproduct in (select idproduct from products where modelciu = '".$vv_ciupram."')
	union
	select 4,idciu from fas_confidential_fw where idciu in (select idproduct from products where modelciu = '".$vv_ciupram."')
	union 
	
	select 0,idproduct from products where modelciu = '".$vv_ciupram."' ";

	$tienelabel="fas fa-times";
	
	$tienedoc="fas fa-times";
	$nomdoc="<span style='color:red'><b>Documentation</b></span>";
	$tieneban="fas fa-times";
	$nomband="<span style='color:red'><b>Bands</b></span>";
	$tienefrw="fas fa-times";
	$nomlfrw="<span style='color:red'><b>Documentation</b></span>";
	$nomlbl="<span style='color:red'><b>Labels</b></span>";

	$idproductoencontrado=0;

$datacontrol = $connect->query($query_lista)->fetchAll();	
	foreach ($datacontrol as $rowcnotrol) 
	{	
		if ( $rowcnotrol['resultado']==0)
		{
			$idproductoencontrado= $rowcnotrol['idproduct'];
		}
		if ( $rowcnotrol['resultado']==1)
		{
			$tienelabel="fas fa-check";
			$nomlbl="<b>Labels</b>";
		}
		if ( $rowcnotrol['resultado']==2)
		{
			$tienedoc="fas fa-check";
			$nomdoc=" <b>Documentation</b>";
		}
		if ( $rowcnotrol['resultado']==3)
		{
			$tieneban="fas fa-check";
			$nomband="<b>Bands</b>";
		}
		if ( $rowcnotrol['resultado']==4)
		{
			$tienefrw="fas fa-check";
		}
	}


$array[] = array
						(
						  'id' => "a1122330",						
						  'parent' => "#",
						    'text' => "Category"
						);
						$linktem="ajax_ciu_addhead*".$idproductoencontrado;
						$array[] = array
						(
						  'id' => $linktem,						
						  'parent' => "a1122330",
						    'text' => "<b>Heads</b>",
							'icon' => "fas fa-check" 
						);
						$linktem="ajax_ciu_adddoc*".$idproductoencontrado;
						$array[] = array
						(
						  'id' => $linktem,						
						  'parent' => "a1122330",
						    'text' => $nomdoc,
							'icon' => $tienedoc
						);
						$linktem="ajax_ciu_addband*".$idproductoencontrado;
						$array[] = array
						(
						  'id' => $linktem,						
						  'parent' => "a1122330",
						    'text' => $nomband,
							'icon' => $tieneban
						);
						$linktem="ajax_ciu_addlbl*".$idproductoencontrado;
					
					
						$array[] = array
						(
						  'id' => $linktem,						
						  'parent' => "a1122330",
						    'text' => $nomlbl,
							'icon' => $tienelabel
						);
						
/*						
	$data = $connect->query($query_lista)->fetchAll();	
	foreach ($data as $row) {			
				//$array['id'] =  $row['iduniquebranch'];
			//$array['name'] = $row['nameidfasstepson'];
			//	$array['icon'] = 'fa fa-inbox';
			//	$array['parent_id'] = $row['idfasstepfather'];
				
		
						

						$nuevonombre = explode("#", $row['description']);
						///		echo "cant".count($nuevonombre)."---".$row['description'];
								$txtnombre="";
								if (count($nuevonombre) ==1)
								{
									$txtnombre=$row['description'];
								}
								else
								{
									$txtnombre=$nuevonombre[1];
								}
									
									$array[] = array
											(
											  'id' => "a".$row['iduniquebranchprodson'],						
											  'parent' => "a".$row['iduniquebranchprod'],
												'text' => $txtnombre,
												'icon'=> 'fa fa-inbox'
											);
											

	 }
	$resul =  $array;
	
	 /////////////////////////////////////////////////////

	 */
	$resul =  $array;
echo(json_encode($resul));

?>
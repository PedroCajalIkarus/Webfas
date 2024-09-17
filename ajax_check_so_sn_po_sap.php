<?php
  error_reporting(0);
  include("db_conect.php");

 

		$vv_po = $_REQUEST['po'];   
		$vv_so = trim($_REQUEST['so']);   
		$vv_idorders = $_REQUEST['idorders'];
		$elsn = $_REQUEST['sn'];
		$woparam= $_REQUEST['wo'];
 

			 try {
		 

			 
							$sql = $connect->prepare("select distinct modelciu, orders_sn.idorders , ponumber, 1+ quantity , quantity-count(distinct idnroserie) as disponibles,max(idnroserie)+1 as proxnnroserie,
							orders_sn.idproduct, products.modelciu, 
							orders_sn.wo_serialnumber, so_soft_external
						from orders_sn
						inner join orders
						on orders.idorders = orders_sn.idorders
						inner join products on products.idproduct = orders_sn.idproduct
						and products.classproduct in 
						(
							select distinct  classproduct
							from orders_sn				
							inner join products on products.idproduct = orders_sn.idproduct
							where orders_sn.idorders = ".$vv_idorders." 
						)
						where orders.active <>'N' and length(trim(wo_serialnumber)) =0 			
						and orders_sn.so_associed = ''  and products.modelciu not like '%LIC%' and so_soft_external like '%SO'
						and so_soft_external like '%".$vv_so."%'   
						group by orders_sn.idorders , ponumber, quantity , 
						orders_sn.idproduct, products.modelciu, 
						orders_sn.wo_serialnumber, so_soft_external 
						order by so_soft_external, modelciu
						");		
						$sql->execute();
						$resultadostock = $sql->fetchAll();
 						$tieneparamostrar=0;
						 foreach ($resultadostock as $rowstock) 
						{
							//encontre la SO ahora vemos si tiene lugar
						//	echo "<br><hola>".$rowstock['modelciu'];
							if ($rowstock['disponibles']>=0)
							{

								$sqltienxml="
								select  distinct (idruninfo) as idruninfo, partnumber , sowormaup, idorders
								from fas_sap_filesxml
								where  typefilename= 'WO' and idruninfo in (
								
								select  (idruninfo) from fas_sap_filesxml_attribute
								where v_string  like '%".$rowstock['modelciu']."%'  and idattributeord   in(5,36)
								 and  idruninfo in ( select  (idruninfo) from fas_sap_filesxml_attribute
								where v_string  like '%".$vv_so."%'  and idattributeord   in(7,51)  )
											)";

											$sqltienxml="
											select max(todo.idruninfo), partnumber , sowormaup, idorders 
											from (
													select  distinct (idruninfo) as idruninfo, partnumber , sowormaup, idorders
													from fas_sap_filesxml
													where  typefilename= 'WO' and idruninfo in (
													
													select  (idruninfo) from fas_sap_filesxml_attribute
													where v_string  like '%".$rowstock['modelciu']."%'  and idattributeord   in(5,36)
													and  idruninfo in ( select  (idruninfo) from fas_sap_filesxml_attribute
													where v_string  like '%".$vv_so."%'  and idattributeord   in(7,51)  )
																)
												) as todo
												inner join fas_sap_filesxml_attribute
												on fas_sap_filesxml_attribute.idruninfo = todo.idruninfo and
												fas_sap_filesxml_attribute.idattributeord = 21
											group by  partnumber , sowormaup, idorders 
											";
 
											///echo "<br>".$sqltienxml;
											$sqltienepo = $connect->prepare($sqltienxml);
											$sqltienepo->execute();
											$resuttienepo = $sqltienepo->fetchAll();
											foreach ($resuttienepo as $rowitieneposap) 
											{
												if ($rowitieneposap['sowormaup'] == $vv_po)
												{
													$tieneparamostrar=1;
												$tieneparamostrar=1;
												?>
<button type="button"
    onclick="asinngwotoso_snsap(<?php echo  $rowstock['idorders']?>,'<?php echo $rowstock['so_soft_external'] ?>',' <?php echo trim($elsn) ?>',0,'<?php echo $woparam;?>',<?php echo $rowstock['proxnnroserie'] ?>,'<?php echo $vv_po;?>');this.disabled=true;"
    class="btn  btn-outline-primary btn-xs">Assign to
    <?php echo   $vv_so." - ".$rowstock['modelciu']." - MFG:".$rowitieneposap['sowormaup'];?>
</button>
<br><br>
<?php	
												}
											}
											
											
							} 
						}  
						
					
				} 
				catch (PDOException $e) 
				{
					
					$msjerr= "Syntax Error MM: ".$e->getMessage();
					echo $msjerr;
					exit();
				}
	
				if ($tieneparamostrar==0)
				{
					echo "<hr><p style='color:red'>No information was found for the PO:".$vv_so."<br>
					please FORCE the sending from SAP</p>";
				}

?>
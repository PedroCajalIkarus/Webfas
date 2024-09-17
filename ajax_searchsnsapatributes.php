<?php
  include("db_conect.php");
  $txtsearch = $_REQUEST['txtsearch'];
 
						 $sql = $connect->prepare("select * from orders_sn where wo_serialnumber like '%".trim($txtsearch)."%' ");
					//echo "select * from orders_sn where wo_serialnumber like '%". $txtsearch."%' ";

								$sql->execute();
								$resultado = $sql->fetchAll();
							 
								foreach ($resultado as $row) {

									echo "<br>&nbsp;&nbsp;* - >".$row['so_soft_external']. " - PO: ".$row['ponumber']." ->idorders".$row['idorders']." ->so_associed:".$row['so_associed'];

									/// Buscamos los Atributos de la Orden
									 
										$sql2 = $connect->prepare("select * from orders_sn_attributes left JOIN orders_attributes_type 
										ON orders_attributes_type.idattribute = orders_sn_attributes.idattribute_orders where idorders =". $row['idorders']." and sn = '". $row['wo_serialnumber']."' order by active ");
										$sql2->execute();
										$resultado2 = $sql2->fetchAll();
										echo "<br>";
										foreach ($resultado2 as $row2) 
										{
											echo '<b>&nbsp;&nbsp;&nbsp;&nbsp;+ { '.$row2['active']."}  ->".$row2['attributename'].'</b> -> '.$row2['v_string']."|".$row2['v_integer'].'<br>';
										}
										
										if ("SO"== $row['typeregister'] )
										{
											 echo  "ES SO";
										}

										echo "<hr>";
										

								}
								

	?>
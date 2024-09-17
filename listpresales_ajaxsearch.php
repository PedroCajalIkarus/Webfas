<?php
  include("db_conect.php");
  $txtsearch = $_REQUEST['txtsearch'];
  
  
?>
<table class="table table-condensed table-sm  table-striped  ">
    <thead>
        <tr>
            <th>Date</th>
            <th>Customer</th>
            <th>SO </th>
            <th>CIU </th>
            <th>Quantity </th>
            <!-- <th >ChkList</th>					
					  <th >P.Config</th>                       
					   <th>SOsAssign</th>  -->
            <th>SNsAssign</th>
            <th>Procesed</th>
        </tr>
    </thead>
    <tbody id="myTable">

        <?php
					$filtrer_date_marco =" (orders_sn.so_soft_external ilike '%".$txtsearch."%' or orders_sn.wo_serialnumber ilike '%".$txtsearch."%' or modelciu ilike '%".$txtsearch."%') " ;
			 
			//	$filtrer_date_marco ="";
 
		 
						 $sql = $connect->prepare("
 
select  distinct iduniquebranchsonprod, pre.idproduct ,  pre.idcustomers, namecustomers , pre.so_soft_external, pre.active,fassrverror, 
pre.processfasserver, pre.idorders,pre.idrev,  pre.modelciu ciu, quantity,  pre.date_approved as datestate , max(prestatus.idstate) as idstates
			, count(distinct orders_sn_asignados.wo_serialnumber) as cantsnasing ,  array_agg(coalesce(orders_sn_asignados.wo_serialnumber,'')) as groupxsn, 
			min(COALESCE(maxstatebypoparadiego.idorders,0)) as diego
			, orders_attributes.v_boolean::integer as isupgrade,
			min(products_attributes.idattribute) as idattribute , 
			COALESCE(min(products_attributes.idattribute),0) as haveupgrade
			  ,min(orders_attributesrabbit.v_boolean::integer) as 	haverabbit  ,  activeprod ,  atrib30.v_string as issoblock,
			  products_attributes_islegacy.idattribute as  idattribute_islegacy
			 
			from 
			(
				select orders_sn.*, orders.active ,products.idrevproduct as idrevpp, iduniquebranchsonprod,  products.active as activeprod,fassrverror, modelciu,quantity
				from orders_sn
				inner join orders on orders_sn.idorders = orders.idorders 
				inner join fnt_select_allproducts_maxrev_bysap() as products
				on products.idproduct = orders.idproduct  
 				where  ".$filtrer_date_marco."
 				and ( (orders.typeregister = 'PO' and orders.active <>'N' ) or (orders.typeregister = 'SO' and orders.active <>'N' ) or (orders.typeregister = 'UP' and orders.active <>'N' ) )
				or ( orders.typeregister = 'RE') 
			)	as pre
															
			inner join customers
			on customers.idcustomers = pre.idcustomers
			inner join orders_states as  prestatus 
			on prestatus.idorders = pre.idorders 
			inner join 
																(
																	select idorders, max(datestate) as maxdatestate from orders_states
																	group by idorders
																) as maxstatebypo
																on maxstatebypo.idorders  = prestatus.idorders and 
																   maxstatebypo.maxdatestate =  prestatus.datestate	
			left join 
																(
																	select distinct idorders  from orders_states
																	where idstate = 2
																	
																) as maxstatebypoparadiego
																on maxstatebypoparadiego.idorders  = prestatus.idorders 
			 inner join 
																(
																	select idorders, max(idrev) as maxiderev from orders
																	group by idorders
																) as maxidrevxpo
																on maxidrevxpo.idorders  = pre.idorders and 
																   maxidrevxpo.maxiderev =  pre.idrev	 
																   
			
			
			left join orders_sn as orders_sn_asignados
			on orders_sn_asignados.idorders = pre.idorders and 
			  orders_sn_asignados.idrev =  pre.idrev and 
			  orders_sn_asignados.idnroserie >0 and
			  orders_sn_asignados.wo_serialnumber <> ''
			 left join orders_attributes as orders_attributesrabbit
			 on orders_attributesrabbit.idorders  =  pre.idorders 
			 and  orders_attributesrabbit.idattribute_orders = 1
			 left join  orders_attributes
			 on orders_attributes.idorders  =  pre.idorders and
			 orders_attributes.idattribute_orders = 2
			 
			 left join  products_attributes as products_attributes_islegacy
			 on pre.idproduct  =  products_attributes_islegacy.idproduct and
			 products_attributes_islegacy.idattribute =30
			
			 left join products_attributes
			 on products_attributes.idproduct =pre.idproduct and products_attributes.idattribute  in (94,95,96,97)
			 left join  fnt_select_all_ordersattribute_maxrev(30) as atrib30
			 on atrib30.idorders  =  pre.idorders
			
			group by iduniquebranchsonprod, pre.idproduct , pre.idcustomers, namecustomers , pre.so_soft_external, pre.active,fassrverror, 
			pre.processfasserver, pre.idorders,pre.idrev,  pre.modelciu , quantity,  pre.date_approved ,  orders_attributes.v_boolean, pre.activeprod , atrib30.v_string
			,products_attributes_islegacy.idattribute 
			order by  datestate desc
			");

 


								$sql->execute();
								$resultado = $sql->fetchAll();
								$idcantrow=1;
								foreach ($resultado as $row) {
								 $idpresales =  $row['idorders'];
								 $vidrev =  $row['idrev'];
								 
								// $idruninfo = $Encryption->encrypt($row['idruninfo'], $semillafp); // $row['idruninfo'];
								   
								$date_approved = substr($row['datestate'],5,5);
								$date_approved_t = substr($row['datestate'],11,5);
								$ponumber =  sprintf("%'.09d\n",$row['ponumber']); 
								$ponumber = $row['ponumber'];
								$so_number = $row['so_soft_external'];
									
							
									$ciu = $row['ciu'];  
								
								
								$quantity = $row['quantity'];  
								$quantityasignados = $row['cantsnasing'];  
								$namecustomers = $row['namecustomers']; 
								$cortonamecustomers = substr($row['namecustomers'],0,8).".."; 
								$idstates = $row['idstates']; 
								if( $row['active']=="Y")	
								{
									$msjerrorfasserver ="";
										if ($row['idstates']==1 )
										{
											$statename = "PO CheckList";
										}
										if ($row['idstates']==2 )
										{
											$statename = "CIU Parameters Config";
										}
										if ($row['idstates']==3 )
										{
											$statename = "Create SO";
										}
										if ($row['idstates']==4 )
										{
											$statename = " SNs Assignments";
										}
								}
								else
								{
									if( $row['active']=="Y")
									{

									}
									else
									{
											///echo   str_replace(".", ".<br> ", $row['fassrverror']);
											if ( $row['fassrverror'] !="")
											{
												$msjerrorfasserver = " :: <label class='text-danger' alt='".$row['fassrverror']."' title='".$row['fassrverror']."'>".str_replace(".", ".<br> ", $row['fassrverror'])." </label>";  
												$msjerrorfasserver = " :: ".str_replace(".", ".<br> ", $row['fassrverror'])." ";  
											}
									}
									
										
								}
									
							
								$proximo_hab = "N";
								
								if ($so_number =="")
								{
									$so_number ="SO uninsigned";
								}
								?>

        <tr>
            <td><?php echo $date_approved." ".$date_approved_t; ?></td>
            <td data-toggle="tooltip" data-placement="top" title="<?php echo $namecustomers; ?>">
                <?php echo $cortonamecustomers; ?> </td>

            <?php 
							$habilito_editar_so= 1;
						if ($row['active']=="D")
						{
							$habilito_editar_so= 2;
						}

					//	if ($_SESSION["g"] == "develop"  )
					//	{
						if( $row['activeprod']=="Y")
						{
							if ($quantityasignados ==0)
							{?>
            <td class="font-weight-bold"><a href="#" title="View - Edit"
                    onclick="show_po(<?php echo  $idpresales; ?>, <?php echo $habilito_editar_so; ?>)"><?php echo $so_number;  ?>
                </a>&nbsp&nbsp <a href="#"
                    onclick="show_po(<?php echo  $idpresales; ?>, <?php echo $habilito_editar_so; ?>)"
                    title="View - Edit"><i class='far fa-edit' style='font-size:14px'></i></a> &nbsp&nbsp <a href="#"
                    title="Delete?" onclick="delete_po(<?php echo  $idpresales; ?>, 2)"><i class='far fa-trash-alt'
                        style='font-size:14px'></i></a>

            </td>
            <?php
							}
							else
							{
								?>
            <td class="font-weight-bold"><a href="#" title="View - Edit"
                    onclick="show_po(<?php echo  $idpresales; ?>, <?php echo $habilito_editar_so; ?>)"><?php echo $so_number;  ?>
                </a>&nbsp&nbsp <a href="#"
                    onclick="show_po(<?php echo  $idpresales; ?>, <?php echo $habilito_editar_so; ?>)"
                    title="View - Edit"><i class='far fa-edit' style='font-size:14px'></i></a>

            </td>
            <?php	
							}
						}
						else
						{
							?>
            <td class="font-weight-bold"><?php echo $so_number;  ?> &nbsp&nbsp
            </td>
            <?php	
						}
							
						
				//		}
					//	else
					//	{
						///
					//		?>

            <?php
					//	}
						?>

            <?php 
					 if( $row['activeprod']=="Y")
					 {
						?>
            <td class="font-weight-bold"><a href="#" title="View - Edit"
                    onclick="show_po(<?php echo  $idpresales; ?>, <?php echo $habilito_editar_so; ?>)"><?php echo  $ciu; ?></a>

                <?php ///echo $_SESSION["a"]; marco / diego / francesco
						if  ($_SESSION["a"]==1 ||$_SESSION["a"]==2 ||$_SESSION["a"]==17 || $_SESSION["a"]==16 || $_SESSION["a"]==8)
						{
							?>
                <a href='#' onclick="show_po(<?php echo  $idpresales; ?>, 2)"><i class="fas fa-magic"></i></a>
                <?php
						}
					 }
					 else
					 {
						//aaaaaa

						?>

            <td class="font-weight-bold"><?php echo  $ciu; ?>
                <?php

					 } 

					 
					// if (strpos($row['iduniquebranchsonprod'], '00010038') !== false) 
					if (strpos($row['iduniquebranchsonprod'], '00010038') !== false ||   strpos($row['iduniquebranchsonprod'], '001000010094') !== false ) 				 
					 {
						?>&nbsp; <a href="#" title="Label printing"
                    onclick="Call_printlabel_todos('<?php echo  $ciu; ?>',<?php echo  $idpresales; ?>)"> <i
                        class="fas fas fa-tag mr-1"></a></i>
                <?php
					 }
					  ?>

                &nbsp; <a href="#" title="Print SO Covers"
                    onclick="Call_printcovers('<?php echo  $ciu; ?>',<?php echo  $quantity; ?>,'<?php echo  $so_number; ?>','<?php echo $namecustomers;?>')">
                    <i class="fas fa-print"></a></i>


                <?php
						if( $row['issoblock']=="Yes")
						{
						   ?><span class='d-none'>CreditBlock</span>
                <i class='fas fa-exclamation-triangle' style='font-size:12px;color:red' title='Credit Block'
                    alt='Credit Block'></i>
                <?php
   
						}
						?>
            </td>
            <td class="font-weight-bold"><span class="badge badge-primary right"
                    title="Quantity - Ref: IDOrders [<?php echo $idpresales; ?>]"><?php 
					 if( $row['activeprod']=="Y")
					 {
						echo $quantityasignados." / ".$quantity;

					 }
					 else
					 {
						echo  $quantity;
					 }
					 ?></span></td>



            <td class="font-weight-bold">
                <div class="progress ">
                    <?php  
						$order_complete = "N";
						  if (  $quantityasignados == $quantity ) 
						   {
							$order_complete = "Y";
							   ?>
                    <div class="progress-bar bg-success" style="width: 100%"><b><i class='fas fa-check'></i><b></div>
                    <?php
						   }
						   else
						   {
							   if ( $quantityasignados > 0)
								{	
									$proximo_hab = "N";
							   ?>
                    <div class="progress-bar bg-secondary" style="width: 0%"><span class="text-info"> Processed /
                            Pend</span></div>
                    <?php
								}
								else
								{
									if( $row['activeprod']=="S")
									{
										?>
                    <div class="progress-bar bg-info" style="width: 0%"><span class="text-secondary"> No Further Action
                            Required</div>
                    <?php	
									}
									else
									{
										if ($row['haveupgrade']>0)
										{
											?>
                    <div class="progress-bar bg-secondary" style="width: 0%"><span class="text-warning"> Pend. SN Assign
                            for Upgrade <i class="fas fa-solid fa-bell"></i></span></div>
                    <?php
										}
										else
										{			
											if ($row['idattribute_islegacy'] !=30)
											//---- 30 ->	Is a Legacy unit
											{							
										?>
                    <div class="progress-bar bg-secondary" style="width: 0%"><span class="text-info"> Pend. SN Assign <i
                                class="fas fa-clipboard"></i></span></div>
                    <?php
											}
											else
											{
												?>
                    <div class="progress-bar bg-secondary" style="width: 0%"><span class="text-info"> SN Autogenerated
                            <i class="fas fa-clipboard"></i></span></div>
                    <?php	
											}
										}
									}
								  ?>

                    <?php	
								}
						   }	
						   ?>

                </div>
            </td>
            <td>
                <?php
					  $enabled_button_reprocess ="N";
					  	
					  //  echo $row['haverabbit']; //Estado BORRADOR
						if ($row['active']=="D")
						{
						////	echo "PENDIENTE DIEGO";
							if ($row['haverabbit'] =="" && $row['haverabbit']  < 0 )
							{
								echo '<span class="text-warning">Missing Rabbit Specs '.$row['haverabbit'] .' </span>';
							}
							else
							{
								echo '<span class="text-warning">Missing Parameters </span>';
							}
							//$enabled_button_reprocess ="Y";
							
							///echo '<a href="generarsaleorders.php?pre=Y&idcus='.$row['idcustomers'].'&po='.$row['ponumber'].'&so='.$row['so_soft_external'].'&qq='.$row['quantity'].'&idciu='.$row['idproduct'].'&ciu='.$row['ciu'].'&idso='.$row['idorders'].'&ncus='.$row['namecustomers'].'"><span class="text-danger"><b> <span  title="'.$msjerrorfasserver .'">Preloaded </b></a></span></span>';
						}
						else
						{  
					  	  if( $row['processfasserver']==true ||  $row['active']=="A")	
							{
								echo '  <div class="progress-bar bg-info" style="width: 100%"><b><i class="fas fa-check"></i><b></div>';
							}
							else
							{
								if ($msjerrorfasserver !='')
								{
									if ($row['active']=="D")
									{
										echo "<br>";
									}
									echo '<span class="text-danger">Pend <span  title="'.$msjerrorfasserver .'">Error </span></span>';
									$enabled_button_reprocess ="Y";
								}
							// echo "haveupgrade:".$row['haveupgrade'];
								
							}
						}

						if  ($_SESSION["a"]==1 ||$_SESSION["a"]==2 ||$_SESSION["a"]==17 || $_SESSION["a"]==8 )
						{
							$enabled_button_reprocess ="Y";
							if ($enabled_button_reprocess =="Y")
							{
								?>
                <a href='reprocess_so.php?dio=<?php echo $idpresales; ?>' target="_blank"><i
                        class="fa fa-cog fa-spin  fa-fw"></i></a>
                <?php
							}
						}

						////////////
						 
							$namelinkpdf="Source/".$ciu.".pdf";
							$url2 = "https://webfas.honeywell.com/".$namelinkpdf;
						//      echo "<br>".$url2 ;
							   // Use get_headers() function
							   $headers2 = @get_headers($url2);
						 //      echo "<br>headers2:". $headers2[0];
			 
							 
							   // Use condition to check the existence of URL
							   if($headers2 && strpos( $headers2[0], '200')) {
							  
							   }
							   else {
							  
							   echo " <i class='far fa-file-pdf' style='font-size:18px;color:red'></i>";
							   ?>

                <?php 
							   }
							  
						//////////

?>

            </td>
            <?php

								}
					?>




    </tbody>
</table>
<!----fin demo accordion -->
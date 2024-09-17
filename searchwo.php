<?php

    error_reporting(0);
    //control ataques de querystring
    if( $_REQUEST['mkt_tok']<> '')
    {
    echo "Error...";
    exit();
    }

    

    // Desactivar toda notificación de error
    error_reporting(0);

    include("db_conect.php"); 
        
        session_start();
            if (isset($_POST['search']) && isset($_POST['date'])) {
                $search = trim($_POST['search']);

                $filter_date_pedro = $_POST['date'];
                if(  empty($search))
                {
                    $filter_date_pedro = " ((prestatus.datestate > now() -' 1 day'::INTERVAL) ) and ";
                }

                
                
                $sql = $connect->prepare("
	select  distinct products_attributes.idattribute as generatsnauto, pre.active,fassrverror, ordwo.so_soft_external ,
		pre.processfasserver, pre.idorders,pre.idrev,  products.modelciu ciu, quantity,  pre.date_approved as datestate ,
		coalesce(count( distinct orders_sn.idnroserie),0) as countsnused, coalesce(count( distinct psn2.idnroserie),0) as psn2count, 
		array_agg(coalesce(ordwo.wo_serialnumber,'')) as groupxsn
	from (
		select distinct pre.*
	from orders as pre			
	LEFT JOIN (SELECT orders_sn.idorders FROM orders_sn  inner join orders_states as  prestatus 
	on prestatus.idorders = orders_sn.idorders 
	where ".$filter_date_pedro."   so_soft_external LIKE '%".$search."%' OR wo_serialnumber LIKE   '%".$search."%' ) as ordersn
    ON ordersn.idorders = pre.idorders 
	LEFT JOIN 	(SELECT * FROM products WHERE modelciu LIKE '%".$search."%') as productssearch
		on productssearch.idproduct = pre.idproduct
		WHERE (ordersn.idorders IS NOT NULL
		OR productssearch.idproduct IS NOT NULL)
	and  pre.typeregister='WO' and pre.idcustomers =2  and pre.active <>'N'   
	) as pre
	inner join products
	on products.idproduct = pre.idproduct  												
	inner join products_attributes as products_attributesfilt
	on pre.idproduct = products_attributesfilt.idproduct and products_attributesfilt.idattribute in (106,0,98,161)
	inner join orders_states as  prestatus 
	on prestatus.idorders = pre.idorders 													  
	left join orders_sn
	on orders_sn.idorders = pre.idorders 	and
	orders_sn.idnroserie >0 and 
	orders_sn.so_associed <> '' and
	orders_sn.idrev =  pre.idrev	
	left join orders_sn as psn2
	on psn2.idorders = pre.idorders 	and
	psn2.wo_serialnumber =' ' and
	psn2.idrev =  pre.idrev	
	inner join orders_sn as ordwo
	on ordwo.idorders = pre.idorders and
	ordwo.idrev =  pre.idrev
	left join products_attributes
	on products.idproduct = products_attributes.idproduct and products_attributes.idattribute =106
	where  ".$filter_date_pedro."  pre.typeregister='WO' and pre.idcustomers =2  and pre.active <>'N'   
	group by products_attributes.idattribute, pre.active, fassrverror, pre.processfasserver ,pre.idorders,pre.idrev, quantity, products.modelciu ,  pre.date_approved ,ordwo.so_soft_external
	order by datestate desc;");
 


                $sql->execute();
                $resultado = $sql->fetchAll();
                $idcantrow=1;
                if(empty($resultado)){

                    echo '<script>                        toastr.options = {
                            "closeButton": false,
                            "debug": false,
                            "newestOnTop": false,
                            "progressBar": true,
                            "positionClass": "toast-bottom-right",
                            "preventDuplicates": false,
                            "onclick": null,
                            "showDuration": "600",
                            "hideDuration": "1000",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000", 
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        };

                        toastr["error"](" ", "WorkOrder not Found");</script>';
                    exit();
                } else {
                foreach ($resultado as $row) {
                 $idpresales =  $row['idorders'];
                 $vidrev =  $row['idrev'];
                  $nrowo =  $row['so_soft_external'];
                 
                // $idruninfo = $Encryption->encrypt($row['idruninfo'], $semillafp); // $row['idruninfo'];
                   echo "sI";
                $date_approved = substr($row['datestate'],5,5);
                $date_approved_t = substr($row['datestate'],11,5);
                
                $ponumber =  $row['ponumber']; 
                $ponumber = $row['ponumber'];
                $ciu = $row['ciu'];  
                $quantity = $row['quantity'];  
                
                $idstates = $row['idstates'];  
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
                $proximo_hab = "N";
                ?>

                                    <tr>
                                        <td><?php echo $date_approved." ".$date_approved_t; ?></td>
                                        <td><?php echo  $nrowo;  ?> - <span
                                                class="badge badge-info right"
                                                title="Revision"><?php echo $vidrev; ?></span> </td>
                                        <td class="font-weight-bold"><a href="#"
                                                title="View Info - Edit"
                                                onclick="show_po(<?php echo  $idpresales; ?>, 1)"><?php echo $ciu;  ?>
                                                <span class="badge badge-primary right"
                                                    title="Quantity"><?php echo $quantity; ?></span>
                                            </a>&nbsp&nbsp <a href="#" title="View Info - Edit"
                                                onclick="show_po(<?php echo  $idpresales; ?>, 2)"><i
                                                    class='far fa-edit' style='font-size:14px'></i></a>

                                            <?php 

        if ($_SESSION["g"] == "develop"  )
        { ?>
                                            &nbsp&nbsp <a href="#" title="Delete?"
                                                onclick="delete_po(<?php echo  $idpresales; ?>, 2)"><i
                                                    class='far fa-trash-alt'
                                                    style='font-size:14px'></i></a>
                                            <?php
        }

        if  ($_SESSION["a"]==1 ||$_SESSION["a"]==2 ||$_SESSION["a"]==17  ||$_SESSION["a"]==44)
        {
            $enabled_button_reprocess ="Y";
            if ($enabled_button_reprocess =="Y")
            {
                ?>
                                            <a href='reprocess_so.php?dio=<?php echo $idpresales; ?>'
                                                target="_blank"><i
                                                    class="fa fa-cog fa-spin  fa-fw"></i></a>
                                            <?php
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


        }
      ?>
                                            &nbsp; <a
                                                href='woinfotopdf.php?idwop=<?php echo  $idpresales; ?>'
                                                title="View Info WO" target='_blank'><i
                                                    class='fas fa-print'></i></a>
                                            &nbsp; <a href="#" title="Label printing"
                                                onclick="Call_printlabel_todos('<?php echo  $ciu; ?>',<?php echo  $idpresales; ?>)">
                                                <i class="fas fas fa-tag mr-1"></a></i>
                                            &nbsp; <a href="#" title="Print SO Covers"
                                                onclick="Call_printcovers('<?php echo  $ciu; ?>',<?php echo  $row['quantity']; ?>,'<?php echo  $nrowo; ?>')">
                                                <i class="fas fa-print"></a></i>
                                            &nbsp; <a
                                                href="trackingorders.php?isdo=<?php echo  $idpresales; ?>&typeisdo=WO&encont=<?php echo  $nrowo; ?>"
                                                title="Tracking WO"><i class='fas fa-sitemap'></i></a>
                                            <div class="d-none">
                                                <?php  echo $row['groupxsn']; ?>
                                            </div>

                                        </td>


                                        <td>
                                            <div class="progress ">
                                                <?php 
           
           if ( $row['processfasserver'] == true)
           {							   
                $bgcolor="";
                 $calporcent= round((100 *   $row['countsnused'] ) /  $row['quantity']);
                 $vlibre =  $row['quantity'] -  $row['countsnused'];
                 
                 if ($calporcent <30)
                 {
                        $bgcolor="bg-info ";
                 }
                  if ($calporcent <=60 && $calporcent>=30 )
                 {
                        $bgcolor="bg-warning";
                 }
                  if ($calporcent >60)
                 {
                        $bgcolor="bg-danger";
                 }
                   ?><b> <?php echo $calporcent; ?> % <b>

                                                        <?php
                if ( $vlibre  >0)
                {
                    ?>
                                                        <small class="badge badge-warning">
                                                            <?php echo  $vlibre; ?> Free SN</small>
                                                        <?php
                }
                if(   $row['psn2count']  > 0   ) 
                {
                    ?>
                                                        <small class="badge badge-danger">
                                                            <?php echo  $row['psn2count']; ?> Error
                                                            SN</small>
                                                        <?php
                }								
               
           }
           else
           {
               if ( $row['active'] == "Y" && 98 == $row['generatsnauto'] )
                {
               ?><div class="badge badge-info"> To Process</div>
                                                        <?php
                }
                  if ( $row['active'] == "P")
                {
                 ?><div class="badge badge-danger" title="<?php echo $row['fassrverror']; ?>">Error To Process</div>
                                                        <?php	
                }
           }
          
           ?>

                                            </div>
                                        </td>
                                        <?php 
                                    }
                                }

        } else {
            echo '';
            exit();
        }
?>
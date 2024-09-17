<?php
// Desactivar toda notificación de error
error_reporting(0);
// Notificar todos los errores de PHP (ver el registro de cambios)
//error_reporting(E_ALL);
 include("db_conect.php"); 
 
    session_start();
 
                  $wheredaterange="";
                  $wherefiltroporpasos ="";
                  $wherefiltroporpasosfinalinspection ="";
              
                  //////////////////////////// //////////////////////////////
                       $v_idp = $_REQUEST['vvisdo'];
                       $filtrar_xsn = substr($_REQUEST['vvencont'],-2);
                       $snafiltrar =  $_REQUEST['vvencont'];
                       $typeisdo =  $_REQUEST['vvtypeisdo'];

                      ///////// ACA CAMBIAMOS LA BUSQUEDA SI ES RM
                  //////////////////////////// //////////////////////////////
                  //////////////////////////// //////////////////////////////
                      ////NUEVO SAP
            $filtrar_xsn = substr($_REQUEST['vvencont'],-2);
            $where_sn_add ="";
            if ($filtrar_xsn=="FU")
            {
              $where_sn_add ="  and orders_sn.wo_serialnumber ='".$_REQUEST['vvencont']."' ";    
            }
                    if ( $typeisdo =="UP")
                      {
                                    $sqlbusco="  select distinct 1 as orr, orders.idorders , orders.processfasserver::int as processfasserver, 
                                     products.modelciu,so_associed,  orders_sn.so_soft_external as  tienesoasociada, 
                                     orders.quantity,orders_sn.so_soft_external, orders_sn.wo_serialnumber 
                                     from orders
                                     inner join orders_sn 
                                     on orders_sn.idorders = orders.idorders
                                     inner join products
                                     on products.idproduct = orders.idproduct
                                  
                            
                             
                                     where orders.idorders in (
                                      select distinct idorders from orders_sn
                                       inner join 
                                      (  select so_associed ,wo_serialnumber from orders_sn where idorders= ".$v_idp." and idnroserie>0) as ttm
                                      on ttm.so_associed = orders_sn.so_soft_external and
                                         ttm.wo_serialnumber = orders_sn.wo_serialnumber
            
                                    )    and orders_sn.idnroserie >0 and orders.typeregister <> 'UP'    ".$where_sn_add;
                      }
                      else
                      {
                            
                                   $sqlbusco="  select distinct 1 as orr, orders.idorders , orders.processfasserver::int as processfasserver, 
                                   products.modelciu,so_associed,  orders_sn.so_soft_external as  tienesoasociada, 
                                 orders.quantity,orders_sn.so_soft_external, orders_sn.wo_serialnumber ,orders_sn.idnroserie 
                                                      from orders
                                                      inner join orders_sn 
                                                      on orders_sn.idorders = orders.idorders
                                                      inner join products
                                                      on products.idproduct = orders.idproduct
                                                   
                                             
                                              
                                        where orders.idorders =".$v_idp."   ".$where_sn_add;

                      }
           
                      $has_a_place='N';
                      $ordr_qty=0;
                      $ordr_qty_sn_asing=0;

                      $data = $connect->query($sqlbusco)->fetchAll();	
                      foreach ($data as $rowqq) {	
                         $ordr_qty= $rowqq['quantity'];
                         $ordr_qty_sn_asing=   $ordr_qty_sn_asing +1;
                      }
                //  echo "<br>ordr_qty:". $ordr_qty." - ordr_qty_sn_asing:".$ordr_qty_sn_asing; 
                 
//echo  $sqlbusco;

                      $data = $connect->query($sqlbusco)->fetchAll();	
                      foreach ($data as $row) {			
                    //    if ($row['wo_serialnumber']>0)
                    //    {
                                //	array_push($return_arr,  $row[0]);		
                                if ( $typeisdo =="WO")
                                {
                                    $return_arr[] = array("idorders" => $row['idorders'], "modelciu" => $row['modelciu'], "so_soft_external" => $row['so_soft_external'],"wo_serialnumber"=>$row['wo_serialnumber'],"tienesoasociada"=>$row['so_associed']);		
                                }
                                if ( $typeisdo =="SO")
                                {
                                    if ($row['modelciu']=="DHS00-M6-013")  
                                    {
                                      $return_arr[] = array("idorders" => $row['idorders'], "modelciu" => $row['modelciu'], "so_soft_external" => $row['tienesoasociada'],"wo_serialnumber"=>$row['wo_serialnumber'],"tienesoasociada"=>$row['tienesoasociada']);		
                                    }
                                    else
                                    {
                                      $return_arr[] = array("idorders" => $row['idorders'], "modelciu" => $row['modelciu'], "so_soft_external" => $row['so_associed'],"wo_serialnumber"=>$row['wo_serialnumber'],"tienesoasociada"=>$row['tienesoasociada']);		
                                    }
                                  //$return_arr[] = array("idorders" => $row['idorders'], "modelciu" => $row['modelciu'], "so_soft_external" => $row['so_associed'],"wo_serialnumber"=>$row['wo_serialnumber'],"tienesoasociada"=>$row['tienesoasociada']);		
                                }
                                if ( $typeisdo =="UP")
                                {
                                    $return_arr[] = array("idorders" => $row['idorders'], "modelciu" => $row['modelciu'], "so_soft_external" => $row['so_soft_external'],"wo_serialnumber"=>$row['wo_serialnumber'],"tienesoasociada"=>$row['tienesoasociada']);		
                                }
                     //   }
                     
                       }
                       /////////////////////////////////////////////////////
                       
                       $isdigunit="marco";
                  
                  /// echo(json_encode(["gi"=>$return_arr,"gifw"=>$return_arr_fw, "gisn"=>$return_arr_sn , "gilog"=>$return_arr_runinfo, "giciu"=>$return_arr_cius]));
                   echo(json_encode(["itemallan"=>$return_arr,"isdigunit"=>$isdigunit]));

                  ?>
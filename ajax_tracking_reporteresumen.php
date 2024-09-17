<?php
 include("db_conect.php");
 session_start(); 
 $v_idp = $_REQUEST['idorders'];
   ////////////////CUADRO TOTAL FRANCESCO
 

      $sqltot =" SELECT distinct 21 as typemarco, v_string , quantity, v_string as namesteps
      FROM public.orders_attributes 
      INNER JOIN orders_attributes_type 
      ON orders_attributes_type.idattribute = orders_attributes.idattribute_orders 
      inner join orders 
      on orders.idorders = orders_attributes.idorders
      where orders_attributes.idorders in ( ".$v_idp." ) and orders_attributes_type.active like 'XML2_WO_OP%' 
       and idattribute_orders= 21
       union 
       SELECT distinct 22 as typemarco,  SPLIT_PART(v_string,'-',1) , quantity, v_string as namesteps
      FROM public.orders_attributes 
      INNER JOIN orders_attributes_type 
      ON orders_attributes_type.idattribute = orders_attributes.idattribute_orders 
      inner join orders 
      on orders.idorders = orders_attributes.idorders
      where orders_attributes.idorders in ( ".$v_idp." ) and orders_attributes_type.active like 'XML2_WO_OP%' 
       and idattribute_orders= 22 and  LENGTH( split_part(v_string, '-', 1) ) =4
       "; 



if( $_SESSION["g"] =='develop' || 'Productionadmin' == $_SESSION["g"] )
                      {
      ?>
      <table class="table table-striped">
      <thead> 
        <tr>
          <th>Unit WO - Quantity: </td>
          <th><p class="text-success">Passed</p> </th>
          <th> <p class="text-danger">No Passed </p></th>
          <th><p class="text-success">ACK SAP OK</p> </th>
          <th> <p class="text-danger">ACK Error SAP </p></th>
        </tr>
   </thead>
   <tbody>
      <?php
      $data_wostep = $connect->query($sqltot)->fetchAll();	                  
      foreach ($data_wostep as $row_steps) 
      {
        ?>
        <tr>
          <td><?php echo $row_steps['namesteps']." - Q:[".$row_steps['quantity']."] "; ?></td>
         
            <?php
            $sql_sap_report=" 
            select so_soft_external , modelciu, v_workcenetr ,   state as statemm,
            count(idruninfoack) as cc
            
FROM
(

select so_soft_external , modelciu, v_workcenetr , fas_to_sap_xml_history.state, fas_to_sap_xml.idruninfo
, max(fas_to_sap_xml_history.idruninfoack) AS idruninfoack

from fas_to_sap_xml
inner join 
(
select distinct so_soft_external , modelciu
from orders_sn
inner join products as maxprod
on maxprod.idproduct = orders_sn.idproduct

where idorders =  ".$v_idp."
) as theordprod
on theordprod.so_soft_external		=	fas_to_sap_xml.v_sowo and 
theordprod.modelciu				=	fas_to_sap_xml.v_sku
inner join fas_to_sap_xml_history
on fas_to_sap_xml_history.idruninfo = fas_to_sap_xml.idruninfo
where v_workcenetr = '".$row_steps['v_string']."'    GROUP BY 
so_soft_external , modelciu, v_workcenetr , fas_to_sap_xml_history.state, fas_to_sap_xml.idruninfo


) AS LOSDA group by so_soft_external , modelciu, v_workcenetr , statemm";

 // echo "<hr>".$sql_sap_report;
         
            $data_sapreport = $connect->query($sql_sap_report)->fetchAll();	                  

            $t_passed=0;
            $t_not_passed=0;
            $t_ACKpassed=0;
            $t_ACKnot_passed=0;
            foreach ($data_sapreport as $row_rapreport) 
            {
                  ///
                  if ($row_rapreport['statemm'] ==2 ) { $t_passed= $row_rapreport['cc'];  }
                  if ($row_rapreport['statemm'] ==4 ) { $t_ACKpassed= $row_rapreport['cc'];  }
                  if ($row_rapreport['statemm'] ==3 ) { $t_ACKnot_passed= $t_ACKnot_passed+ $row_rapreport['cc'];  }
              
                 if ($row_rapreport['statemm'] ==5    )      { $t_ACKnot_passed= $t_ACKnot_passed+ $row_rapreport['cc'];  }
            }
            ?>
          <td><?php echo $t_passed; ?> </td>
          <td><?php echo $t_not_passed; ?></td>
          <td><?php echo $t_ACKpassed; ?></td>
          <td><?php echo $t_ACKnot_passed; ?></td>

        </tr>
        <?php
      }

      //////////////// fin cuadro total francesco
      ?>
       </tbody>
      </table>
      <?php
}
  
?>
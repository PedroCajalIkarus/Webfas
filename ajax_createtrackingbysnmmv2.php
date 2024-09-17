<?php
// Desactivar toda notificación de error
//error_reporting(0);
// Notificar todos los errores de PHP (ver el registro de cambios)
//error_reporting(E_ALL);
 include("db_conect.php");
 session_start(); 

 $vsn =$_REQUEST['sn'];
 $idorders = $_REQUEST['idorders'];
 $idorder_so = $_REQUEST['idorders'];
 $v_new_structure_routing ='xx';
 $typeisdo = $_REQUEST['vvtypeisdo'];

 $modelciuasigdesdecero = $_REQUEST['modelciu'];
 $soasigdedecero = $_REQUEST['tienesoasociada'];

 global  $_v_steps_WO_ASSY;
 global $_v_steps_WO_PRECHECK ;
 global $_v_steps_SO_ASSY;
 global  $_v_steps_SO_PRECHECK;

   $_v_steps_WO_ASSY='N';
  $_v_steps_WO_PRECHECK='N';
  $_v_steps_SO_ASSY='N';
   $_v_steps_SO_PRECHECK='N';


 $sqldondearranco="select typeregister from orders where  idorders  =  ".$idorders;

$rsdondearr = $connect->prepare( $sqldondearranco);
$rsdondearr->execute();
$resultcheck = $rsdondearr->fetchAll();							
$dondeinicio= "";
foreach ($resultcheck as $rowdond)
{
  $dondeinicio= $rowdond['typeregister'];
}



 
 if ( $vsn=="")
 {
   
      $vv_worcenter_showasig = substr(trim($rowmam['v_string']),3,10);
      $query_listaasig="
   
    select 4 as typestruct, v_string, '' as wo_serialnumber,v_integer, CONCAT('so_',v_string) as v_string from orders_attributes where orders_attributes.idorders = ".$idorder_so." and idattribute_orders = 21  
    and not exists 
    (
      select 2 as typestruct, v_string, '' as wo_serialnumber,v_integer,  v_string from orders_attributes where orders_attributes.idorders = ".$idorder_so." and idattribute_orders = 22 and v_string like '%-%' and LENGTH( split_part(v_string, '-', 1) ) =4 
    
    )    
    order by typestruct, v_integer    
      ";
   //  echo $query_listaasig;
   
  
      $datamm = $connect->query($query_listaasig)->fetchAll();	
      foreach ($datamm as $rowmam) 	
      {
     echo "<br>STEPS:".$rowmam['v_string'];
 

        if ($rowmam['v_string']=="so_2ND-ASSY")
        {
            $vvnombre_a_mostrar_en_dvi ='Order Detail :: '.$ref_so."  - with serial number assignment          ".$idorder_so."-".$ref_so;
          crear_steps_soinfo_ASSY("SO-2ND-ASSY" ,"missingsn", $idorder_so,$ref_so, $modelciuasigdesdecero,$idorder_so,$ref_so, $modelciuasigdesdecero ,$vvnombre_a_mostrar_en_dvi,"N");
            
          /*
            <div class="stepazulyamarillo active">
                                  
            <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text"><b>SO:<?php echo  $soasigdedecero; ?>
<br>CIU : <?php echo  $modelciuasigdesdecero; ?></b>
</span>
<a href="#"
    onclick="show_info('asingsnsotowo','<?php echo $rowmam['wo_serialnumber']; ?>','<?php echo $idorder_so; ?>','',0,0)">
    <span class="badge bg-warning"><b>Assign SN <?php // echo "a verrrrrrrr".$ref_so; ?> </b></span>
</a>
</div>
*/
?>

<?php
        }
        else
        {
          ?>
<div class="step  "> <span class="icon"><i class="fas fa-tasks"></i> </span> <span
        class="text"><?php echo $rowmam['v_string']; ?>
        <br>


    </span></div>
<?php
        }
      }


 }
 else
 {

 

 

//echo "<br>dondeinicio". $dondeinicio;

$where_sn_add ="  and orders_sn.wo_serialnumber ='". $vsn."' ";    

    if ($dondeinicio=="WO")
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
          ".$idorders."
        )    and orders_sn.idnroserie >0 and orders.typeregister <> 'UP'    ".$where_sn_add;

        //echo "<br>".$sqlbusco;
                $sqllosso = $connect->prepare( $sqlbusco);
                $sqllosso->execute();
                $resultadoslosso = $sqllosso->fetchAll();							

                foreach ($resultadoslosso as $rowbuscawo) 
                {
                $idorder_wo = $rowbuscawo['idorders'];
                $ref_wo = $rowbuscawo['so_soft_external'];
                $ref_so = $rowbuscawo['so_associed'];
                $model_ciu_wo = $rowbuscawo['modelciu'];
                
                // Ahora buscamos la SO
                    $sqlbuscoso="  select distinct 1 as orr, orders.idorders , orders.processfasserver::int as processfasserver, 
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
                    (  select so_associed ,wo_serialnumber from orders_sn where idorders= ".$idorder_wo." and idnroserie>0) as ttm
                    on ttm.so_associed = orders_sn.so_soft_external and
                        ttm.wo_serialnumber = orders_sn.wo_serialnumber

                  )    and orders_sn.idnroserie >0 and orders.typeregister <> 'UP'    ".$where_sn_add;
             //    echo "<br>SO:".$sqlbuscoso;
            //    exit();
                      $sqllossoa = $connect->prepare( $sqlbuscoso);
                      $sqllossoa->execute();
                      $resultadoslossoa= $sqllossoa->fetchAll();							
                  
                      foreach ($resultadoslossoa as $rowbuscaso) 
                      {
                        $idorder_so = $rowbuscaso['idorders'];            
                        $model_ciu_so = $rowbuscaso['modelciu'];
                  //      echo "aaaaa".$idorder_so."--". $model_ciu_so ;
                  // Comentado x los ILB
                       $nroque=" call a_solucionador_orders_attributes_idorders_sn (". $idorder_so." ,'". $vsn."' );";
                       $sqlrep = $connect->prepare( $nroque);
                       $sqlrep->execute();
                      }
                  
                //$model_ciu =  $rowbuscawo['modelciu'];
                }
    }
    else
    {


          $sqlbuscoso="  select distinct 1 as orr, orders.idorders , orders.processfasserver::int as processfasserver, 
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
          (  select so_associed ,wo_serialnumber from orders_sn where idorders= ".$idorders." and idnroserie>0
             union 
             select   so_soft_external ,wo_serialnumber from orders_sn where idorders= ".$idorders." and idnroserie>0 
             and idproduct= 4651
          ) as ttm
          on ttm.so_associed = orders_sn.so_soft_external and
              ttm.wo_serialnumber = orders_sn.wo_serialnumber

        )    and orders_sn.idnroserie >0 and orders.typeregister <> 'UP'    ".$where_sn_add ;

      //      echo "---Entrando x SO".$sqlbuscoso;
        $sqllosso = $connect->prepare( $sqlbuscoso);
        $sqllosso->execute();
        $resultadoslosso = $sqllosso->fetchAll();							

        foreach ($resultadoslosso as $rowbuscawo) 
        {
          $idorder_wo = $rowbuscawo['idorders'];
          $ref_wo = $rowbuscawo['so_soft_external'];
          $ref_so = $rowbuscawo['so_associed'];
          $model_ciu_wo = $rowbuscawo['modelciu'];

          if ("ILB4A-WMO" ==  $model_ciu_wo )
          {
            $ref_wo = $rowbuscawo['so_soft_external'];
            $ref_so = $rowbuscawo['so_soft_external'];
            $idorder_so = $rowbuscawo['idorders'];            
              $model_ciu_so =$model_ciu_wo;
          }

          // Ahora buscamos la SO
          if  ( $idorder_wo > 0)
            { 
                $sqlbuscoso="  select distinct 1 as orr, orders.idorders , orders.processfasserver::int as processfasserver, 
              products.modelciu, so_associed,  orders_sn.so_soft_external as  tienesoasociada, 
              orders.quantity,orders_sn.so_soft_external, orders_sn.wo_serialnumber 
              from orders
              inner join orders_sn 
              on orders_sn.idorders = orders.idorders
              inner join products
              on products.idproduct = orders.idproduct
          
    
    
              where orders.idorders in (
              select distinct idorders from orders_sn
                inner join 
              (  select so_associed ,wo_serialnumber from orders_sn where idorders= ".$idorder_wo." and idnroserie>0) as ttm
              on ttm.so_associed = orders_sn.so_soft_external and
                  ttm.wo_serialnumber = orders_sn.wo_serialnumber
    
            )    and orders_sn.idnroserie >0 and orders.typeregister <> 'UP'    ".$where_sn_add;
           //    echo "<br>SO adentro de la SO:".$sqlbuscoso;
                $sqllossoa = $connect->prepare( $sqlbuscoso);
                $sqllossoa->execute();
                $resultadoslossoa= $sqllossoa->fetchAll();							
            
                foreach ($resultadoslossoa as $rowbuscaso) 
                {
                  $idorder_so = $rowbuscaso['idorders'];            
                  $model_ciu_so = $rowbuscaso['modelciu'];
                }
          }
       

        }

        ///////////////////////

        if (  $ref_so=="")
        {

          $sqlbuscoso="  select distinct 1 as orr, orders.idorders , orders.processfasserver::int as processfasserver, 
          products.modelciu,so_associed,  orders_sn.so_soft_external as  tienesoasociada, 
          orders.quantity,orders_sn.so_soft_external, orders_sn.wo_serialnumber 
          from orders
          inner join orders_sn 
          on orders_sn.idorders = orders.idorders
          inner join products
          on products.idproduct = orders.idproduct
      


          where orders.idorders in ( ".$idorder_so.") 

            and orders_sn.idnroserie >0 and orders.typeregister <> 'UP'    ".$where_sn_add;
        //   echo "<br>SO2 adentro de la SO:".$sqlbuscoso;
            $sqllossoa = $connect->prepare( $sqlbuscoso);
            $sqllossoa->execute();
            $resultadoslossoa= $sqllossoa->fetchAll();							
        
            foreach ($resultadoslossoa as $rowbuscaso) 
            {
              $idorder_so = $rowbuscaso['idorders'];            
              $model_ciu_so = $rowbuscaso['modelciu'];
              $ref_so = $rowbuscaso['so_soft_external'];
            
            }

        }
        


    }
  

 //    echo "<br>lawo". $idorder_wo."<br>te".$idorder_so."tete:". $model_ciu_so;       
 

if ($idorder_so=="")
{
  $idorder_so=0;
} 
/// chk attributes in orders
 
 
/*
$query_lista=" select 0 as typestruct,* from orders_attributes inner join orders_sn on orders_sn.idorders =  orders_attributes.idorders where wo_serialnumber = '".$vsn."' and orders_attributes.idorders  = ".$idorder_wo." and idattribute_orders  = 22 and  v_string like '%-%' and  LENGTH( split_part(v_string, '-', 1) ) =4
union 
select 0 as typestruct,* from orders_attributes inner join orders_sn on orders_sn.idorders =  orders_attributes.idorders where wo_serialnumber = '".$vsn."' and orders_attributes.idorders  = ".$idorder_so." and idattribute_orders  = 22 and  v_string like '%-%' and  LENGTH( split_part(v_string, '-', 1) ) =4
  order by typestruct, v_integer  " ;
*/

if ( $idorder_wo=="")
{
  $idorder_wo=0;
}

  $query_lista="
  
  select 0 as typestruct,v_string, wo_serialnumber,v_integer,  v_string from orders_attributes inner join orders_sn on orders_sn.idorders = orders_attributes.idorders where wo_serialnumber = '".$vsn."' and orders_attributes.idorders = ".$idorder_wo." and idattribute_orders = 22 and v_string like '%-%' and LENGTH( split_part(v_string, '-', 1) ) =4 
union
select 2 as typestruct, v_string, wo_serialnumber,v_integer,  v_string from orders_attributes inner join orders_sn on orders_sn.idorders = orders_attributes.idorders where wo_serialnumber = '".$vsn."' and orders_attributes.idorders = ".$idorder_so." and idattribute_orders = 22 and  typeregister = 'SO' and v_string like '%-%' and LENGTH( split_part(v_string, '-', 1) ) =4 
union 
select 3 as typestruct, v_string, wo_serialnumber,v_integer, CONCAT('wo_',v_string) as v_string from orders_attributes inner join orders_sn on orders_sn.idorders = orders_attributes.idorders where wo_serialnumber = '".$vsn."' and orders_attributes.idorders = ".$idorder_wo." and idattribute_orders = 21  
and not exists 
(
select 0 as typestruct,v_string, wo_serialnumber,v_integer,  v_string from orders_attributes inner join orders_sn on orders_sn.idorders = orders_attributes.idorders where wo_serialnumber = '".$vsn."' and orders_attributes.idorders = ".$idorder_wo." and idattribute_orders = 22 and v_string like '%-%' and LENGTH( split_part(v_string, '-', 1) ) =4 
	
)
union 
select 4 as typestruct, v_string, wo_serialnumber,v_integer, CONCAT('so_',v_string) as v_string from orders_attributes inner join orders_sn on orders_sn.idorders = orders_attributes.idorders where wo_serialnumber = '".$vsn."' and orders_attributes.idorders = ".$idorder_so." and idattribute_orders = 21 and  typeregister = 'SO'  
and not exists 
(
	select 2 as typestruct, v_string, wo_serialnumber,v_integer,  v_string from orders_attributes inner join orders_sn on orders_sn.idorders = orders_attributes.idorders where wo_serialnumber = '".$vsn."' and orders_attributes.idorders = ".$idorder_so." and idattribute_orders = 22 and v_string like '%-%' and LENGTH( split_part(v_string, '-', 1) ) =4 

)

order by typestruct, v_integer

  ";

  $query_lista="
  
  select 0 as typestruct,v_string, wo_serialnumber,v_integer,  v_string from orders_sn_attributes as orders_attributes inner join orders_sn on orders_sn.idorders = orders_attributes.idorders and  orders_sn.wo_serialnumber = orders_attributes.sn    where wo_serialnumber = '".$vsn."' and orders_attributes.idorders = ".$idorder_wo." and idattribute_orders = 22 and v_string like '%-%' and LENGTH( split_part(v_string, '-', 1) ) =4 
union
select 2 as typestruct, v_string, wo_serialnumber,v_integer,  v_string from orders_sn_attributes as orders_attributes inner join orders_sn on orders_sn.idorders = orders_attributes.idorders and  orders_sn.wo_serialnumber = orders_attributes.sn  where wo_serialnumber = '".$vsn."' and orders_attributes.idorders = ".$idorder_so." and idattribute_orders = 22 and  typeregister = 'SO' and v_string like '%-%' and LENGTH( split_part(v_string, '-', 1) ) =4 
union 
select 3 as typestruct, v_string, wo_serialnumber,v_integer, CONCAT('wo_',v_string) as v_string from orders_sn_attributes as orders_attributes inner join orders_sn on orders_sn.typeregister='WO' and orders_sn.idorders = orders_attributes.idorders and  orders_sn.wo_serialnumber = orders_attributes.sn  where wo_serialnumber = '".$vsn."' and orders_attributes.idorders = ".$idorder_wo." and idattribute_orders = 21  
and not exists 
(
select 0 as typestruct,v_string, wo_serialnumber,v_integer,  v_string from orders_sn_attributes as orders_attributes inner join orders_sn on orders_sn.idorders = orders_attributes.idorders and  orders_sn.wo_serialnumber = orders_attributes.sn  where wo_serialnumber = '".$vsn."' and orders_attributes.idorders = ".$idorder_wo." and idattribute_orders = 22 and v_string like '%-%' and LENGTH( split_part(v_string, '-', 1) ) =4 
	
)
union 
select 4 as typestruct, v_string, wo_serialnumber,v_integer, CONCAT('so_',v_string) as v_string from orders_sn_attributes as orders_attributes inner join orders_sn on orders_sn.idorders = orders_attributes.idorders and  orders_sn.wo_serialnumber = orders_attributes.sn  where wo_serialnumber = '".$vsn."' and orders_attributes.idorders = ".$idorder_so." and idattribute_orders = 21 and  typeregister = 'SO'  
and not exists 
(
	select 2 as typestruct, v_string, wo_serialnumber,v_integer,  v_string from orders_sn_attributes as orders_attributes inner join orders_sn on orders_sn.idorders = orders_attributes.idorders and  orders_sn.wo_serialnumber = orders_attributes.sn  where wo_serialnumber = '".$vsn."' and orders_attributes.idorders = ".$idorder_so." and idattribute_orders = 22 and v_string like '%-%' and LENGTH( split_part(v_string, '-', 1) ) =4 

)

order by typestruct, v_integer

  ";
 

  $query_lista ="
  
  select 0 as typestruct, wo_serialnumber, typeregister,v_integer
,json_agg( JSON_BUILD_OBJECT('v_string',v_string,'v_integer', v_integer) ::jsonb)::jsonb as stepsarray

from orders_sn_attributes as orders_attributes 
inner join orders_sn on orders_sn.idorders = orders_attributes.idorders and orders_sn.wo_serialnumber = orders_attributes.sn 
where wo_serialnumber = '".$vsn."' and orders_attributes.idorders = ".$idorder_wo." and idattribute_orders in(20,21,22)
 and typeregister = 'WO'
		  group by typestruct, wo_serialnumber,typeregister,v_integer

      union
      select * from (	
      select 1 as typestruct, wo_serialnumber, 'SO',v_integer
      ,json_agg( JSON_BUILD_OBJECT('v_string','INFOSO','v_integer', v_integer) ::jsonb)::jsonb
     from orders_sn_attributes as orders_attributes 
     inner join orders_sn on orders_sn.idorders = orders_attributes.idorders and orders_sn.wo_serialnumber = orders_attributes.sn 
     where wo_serialnumber = '".$vsn."'  and orders_attributes.idorders = ".$idorder_so." and idattribute_orders in(20,21,22)
      and typeregister = 'SO' and orders_sn.idproduct  in (select  idproduct from  products_attributes  where idattribute =160)
       group by typestruct, wo_serialnumber,typeregister,v_integer  limit 1	) as ff
       union
      select * from (	
      select 1 as typestruct, wo_serialnumber, 'SO',v_integer
      ,json_agg( JSON_BUILD_OBJECT('v_string','INFOSO','v_integer', v_integer) ::jsonb)::jsonb
     from orders_sn_attributes as orders_attributes 
     inner join orders_sn on orders_sn.idorders = orders_attributes.idorders and orders_sn.wo_serialnumber = orders_attributes.sn 
     where wo_serialnumber = '".$vsn."' and typeregister = 'WO'  and so_soft_external like '20%' and exists( select idorders from orders_sn where wo_serialnumber = '".$vsn."' and typeregister = 'SO'  )
       group by typestruct, wo_serialnumber,typeregister,v_integer  limit 1	) as ff
       union
       select * from (	
       select 1 as typestruct, wo_serialnumber, 'SO',v_integer 
       ,json_agg( JSON_BUILD_OBJECT('v_string','INFOSO','v_integer', v_integer) ::jsonb)::jsonb
  
      from orders_sn_attributes as orders_attributes 
      inner join orders_sn on orders_sn.idorders = orders_attributes.idorders and orders_sn.wo_serialnumber = orders_attributes.sn 
      where wo_serialnumber = '".$vsn."' and typeregister = 'WO'    and orders_sn.idproduct 
    in (select  idproduct from  products_attributes  where idattribute =160)
    and exists( select idorders from orders_sn where wo_serialnumber = '".$vsn."' and typeregister = 'SO'  )
        group by typestruct, wo_serialnumber,typeregister,v_integer  limit 1	) as ff

union
select 1 as typestruct, wo_serialnumber, typeregister,v_integer
	,json_agg( JSON_BUILD_OBJECT('v_string',v_string,'v_integer', v_integer) ::jsonb)::jsonb
from orders_sn_attributes as orders_attributes 
inner join orders_sn on orders_sn.idorders = orders_attributes.idorders and orders_sn.wo_serialnumber = orders_attributes.sn 
where wo_serialnumber = '".$vsn."' and orders_attributes.idorders = ".$idorder_so." and idattribute_orders in(20,21,22)
 and typeregister = 'SO' and orders_sn.idproduct not in (select  idproduct from  products_attributes  where idattribute =160)
  group by typestruct, wo_serialnumber,typeregister,v_integer
 

 order by typestruct ,  v_integer 
  ";

  $query_lista="	select 1 as typestruct, vv_sn as wo_serialnumber, '' as  typeregister,v_integer
	,json_agg( JSON_BUILD_OBJECT('v_string',v_string,'v_integer', v_integer) ::jsonb)::jsonb
	
from recursive_search_sn_history_order(0,0,'24024642FU',0)  as ff
	inner join orders_sn_attributes
	on	orders_sn_attributes.idorders 	=	 ff.vv_idorders and 
	    orders_sn_attributes.sn 		=    ff.vv_sn and idattribute_orders in(20,21,22)
	 group by vv_idorder, vv_sn,v_integer
order by vv_idorder, v_integer asc";
  echo "<br>sql a ver".$query_lista;
 

  echo "<br><br>PARADO:".$vsn;
exit();
 
  $data = $connect->query($query_lista)->fetchAll();	
  

  
    $v_new_structure_routing ='N';

    $sqltieneso=" 	select typeregister,  count( wo_serialnumber) as cc
		from orders_sn 			
		where	wo_serialnumber = '".$vsn."' and typeregister in ('WO','SO')  group by typeregister ";
//echo $sqltieneso;

    $dataqty = $connect->query($sqltieneso)->fetchAll();	
     
    $controlo_wo ='N';
    $controlo_so ='N';

     
    
    foreach ($dataqty as $rowqty ) 	
    {
      if ( $rowqty['typeregister']=='WO' &&  $rowqty['cc']>=1 )
      {
         $controlo_wo ='Y';
        
      }
      if (  $rowqty['typeregister']=='SO' && $rowqty['cc']>=1 )
      {
         $controlo_so ='Y';
      }
        
    }

    $have_wo='N' ;
    $have_so='N';
    foreach ($data as $rowsteps ) 	
    {
   //   echo $rowsteps['v_string']."--->".substr( $rowsteps['v_string'], 0, 2)."<br>";
      if (  $rowsteps['typeregister'] =="WO"  || substr( $rowsteps['v_string'], 0, 2)=="wo"  ||  substr( $rowsteps['v_string'], 0, 4)=="AS01" ||  substr( $rowsteps['v_string'], 0, 4)=="AP01" ||  substr( $rowsteps['v_string'], 0, 4)=="SA01" )
      {
        $have_wo='Y' ;
      }
      if (  $rowsteps['typeregister'] =="SO"  ||  substr( $rowsteps['v_string'], 0, 2)=="so" )
      {
        $have_so='Y';
      }

        $v_new_structure_routing ='Y';
    }
 
     ////   echo "hola a verrrr".$v_new_structure_routing;
  //   echo "*---have_wo:".$have_wo."--controlo_wo:".$controlo_wo."--have_so:".$have_so."--controlo_so:".$controlo_so."--v_new_structure_routing:  ".$v_new_structure_routing."--*";
 
    
   
    if ($have_wo==$controlo_wo && $have_so==$controlo_so  )
    {
    }
    else
    {
        echo "<b><p style='color:red'>ERROR, SAP routing not found.</p></b><br><br>Setting up a temporary tracking. This is a SN has no sap routing sent...";
        
     /*   $query_lista=" select 0 as typestruct, v_string, wo_serialnumber,v_integer, CONCAT('wo_',v_string) as v_string from orders_attributes inner join orders_sn on orders_sn.idorders =  orders_attributes.idorders where wo_serialnumber = '".$vsn."' and orders_attributes.idorders  = ".$idorder_wo." and idattribute_orders  = 21 
union 
select 1 as typestruct, v_string, wo_serialnumber,v_integer, CONCAT('so_',v_string) as v_string from orders_attributes inner join orders_sn on orders_sn.idorders =  orders_attributes.idorders where wo_serialnumber = '".$vsn."' and orders_attributes.idorders  = ".$idorder_so." and idattribute_orders  = 21 
  order by typestruct, v_integer  " ;
    echo "<br>2sql a ver".$query_lista;          
        ///  $data = $connect->query($query_lista)->fetchAll();	
        */
    // echo "SIIIIIIIII";

    //?isdo=15737&typeisdo=WO&encont=23092584FU

    $vsn =$_REQUEST['sn'];
    $idorders = $_REQUEST['idorders'];
    $idorder_so = $_REQUEST['idorders'];
    $v_new_structure_routing ='xx';
    $typeisdo = $_REQUEST['vvtypeisdo'];
   
    $modelciuasigdesdecero = $_REQUEST['modelciu'];
    $soasigdedecero = $_REQUEST['tienesoasociada'];

    
    $validPrefixes = array("18", "19", "20", "21", "22");
    
    if (in_array(substr($vsn, 0, 2), $validPrefixes)) 
      {
        $paramurl= 'https://webfas.honeywell.com//trackingorders_onlysnoldajax.php?isdo='.$idorders.'&typeisdo='.$dondeinicio.'&encont='.$vsn;

//  
//echo "<br>aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";
//echo $response; 
///echo "<br>Setting up a temporary tracking. This is a SN has no sap routing sent.... ";

    ?>

<script type="text/javascript">
var extra = '?isdo=<?php echo $idorders; ?>&typeisdo=<?php echo $dondeinicio; ?>&encont=<?php echo $vsn; ?>';
var nuevoref = window.location.href;
nuevoref = nuevoref.replace("trackingorderssaproutingmmv2", "trackingorders_onlysnoldajax");
nuevoref = nuevoref.replace("#", "");
//console.log('nuevoref' + nuevoref + extra);
nuevoref = nuevoref + extra;

$.ajax({
        url: 'https://webfas.honeywell.com//trackingorders_onlysnoldajax.php?isdo=<?php echo $idorders; ?>&typeisdo=<?php echo $dondeinicio; ?>&encont=<?php echo $vsn; ?>',        
        type: 'post',
        datatype: 'JSON',
        success: function(data) {
            // 
            //btn1
        
            $("#track1").html(data);

        }
    });


///window.location.href = nuevoref;
</script>

<?php
      }
    }
  //  exit();

  echo  "<a href='trackingorders.php?isdo=".$idorders."&typeisdo=".$dondeinicio."&encont=".$vsn."'>&nbsp;</a><br><br>";
      
    $haveSOasing="N";
    $haveSteps='N';
    $have_2ndAssy="N";
    foreach ($data as $row_autotest) 
    {
  //   echo "<br>STEPS:".$row_autotest['stepsarray']."--typeregister->".$row_autotest['typeregister'];
      $decode_steps= json_decode($row_autotest['stepsarray'],true);
     
    //  echo "<br>1-->". ($decode_steps[0]['v_string'] );
    //  echo "<br>2-->". ($decode_steps[1]['v_string'] );
    //  echo "<br>3-->". ($decode_steps[2]['v_string'] );

      $step_nro_ary=trim($decode_steps[0]['v_string'] );
   
      $step_name_ary=strtolower($row_autotest['typeregister'])."_".trim($decode_steps[1]['v_string'] );
      echo "<br>NvoSteps:".$step_name_ary;
      $step_descr_ary=trim($decode_steps[2]['v_string'] );
      
      $tengofuncionecreada=0;
       $nvostepsrouting = explode("-",$step_descr_ary);

        $haveSteps='Y';
          $vv_tempsn = $row_autotest['wo_serialnumber'];

       //   echo "<br>NvoStepsdesc:".$step_descr_ary."->".$nvostepsrouting[0];
          
         /////////////////////////////////////////////////
                  ///   echo "------------>>>>>>>>>>>".$rowbuscawo['modelciu'];
                    $query_woattach ="select * from products_attributes where idattribute = 127 and idproduct in (select idproduct from fnt_select_allproducts_maxrev() as ppp where modelciu = '".$rowbuscawo['modelciu']."')  ";
                    $data_wo = $connect->query($query_woattach)->fetchAll();	
                    $enabled_attachfile_step = 'N';
                    foreach ($data_wo as $rowwo) 
                    {
                      $enabled_attachfile_step = 'Y';
                  
                    }

                  ///  echo "TIENE ATTACHA".$enabled_attachfile_step;

                  
                    //////////////////////////////////////
                    //////////
        
     ///  so_FINALCAL
               if  ($step_name_ary  =="so_UPGRADELIC"  )
                {
                $tengofuncionecreada=1;
                $vvnombre_a_mostrar_en_dvi ='Order Detail :: '.$ref_so." - SN: ".$rowbuscawo['wo_serialnumber'];                              
                crear_steps_so_UPGRADELIC($step_name_ary ,$row_autotest['wo_serialnumber'], $idorder_wo,$ref_wo,$model_ciu_wo,$idorder_so,$ref_so,$model_ciu_so ,$vvnombre_a_mostrar_en_dvi, $enabled_attachfile_step,$step_nro_ary);
                
                }

        //        echo "ref_wo;".$model_ciu_wo;

                if  ($step_name_ary  =="so_FINALCAL" || $step_name_ary  =="wo_FINALCAL"  )
                {
                $tengofuncionecreada=1;
                if  ($step_name_ary  =="so_FINALCAL"   )
                {
                  $haveSOasing="Y"; 
                }
      //acamm1           $haveSOasing="Y"; 
                $vvnombre_a_mostrar_en_dvi ='Order Detail :: SO:'.$ref_so." - SN: ".$rowbuscawo['wo_serialnumber'];       
           //   echo "----"."wo_".$step_name_ary."<--->".$row_autotest['wo_serialnumber']."<--->idorder_so".$idorder_so."<--->ref_so".$ref_so."<--->";
           ///     echo "idorder_wo->".$idorder_wo."ref_wo->".$ref_wo."model_ciu_wo->".$model_ciu_wo."idorder_so->".$idorder_so."ref_so->".$ref_so."model_ciu_so->".$model_ciu_so."->".$vvnombre_a_mostrar_en_dvi."->". $enabled_attachfile_step."->". $row_autotest['v_integer'];
                
                 
           //    echo "*******************-a ver".                   $nvostepsrouting[0]; 
                  if ( $nvostepsrouting[0] == "BBU" )
                  {
                    
                    if ($step_name_ary  =="wo_FINALCAL")
                    {
                      crear_steps_wo_BBUMMS_HP("so_FINCALCAL" ,$row_autotest['wo_serialnumber'], $idorder_wo,$ref_wo,$model_ciu_wo,$idorder_wo,$ref_wo,$model_ciu_so ,$vvnombre_a_mostrar_en_dvi, $enabled_attachfile_step,$step_nro_ary);
                    }
                    else
                    {
                       crear_steps_wo_BBUMMS_HP("so_FINCALCAL" ,$row_autotest['wo_serialnumber'], $idorder_wo,$ref_wo,$model_ciu_wo,$idorder_so,$ref_so,$model_ciu_so ,$vvnombre_a_mostrar_en_dvi, $enabled_attachfile_step,$step_nro_ary);
                    }

                    
                    

                  }
                  else
                  {
                    crear_steps_so_FINALCAL($step_name_ary ,$row_autotest['wo_serialnumber'], $idorder_wo,$ref_wo,$model_ciu_wo,$idorder_so,$ref_so,$model_ciu_so ,$vvnombre_a_mostrar_en_dvi, $enabled_attachfile_step, $row_autotest['v_integer'],$step_nro_ary );
                  }
                 
                
                }
              ///  echo "aaaaver::::".$nvostepsrouting[0];

                if ($step_name_ary  =="wo_FINALCAL" && $nvostepsrouting[0]=="Final Calibration"  )
                {
                  ///echo "***********************OJOidorder_wo->".$idorder_wo."ref_woA123->".$ref_wo."model_ciu_wo->".$model_ciu_wo."idorder_so->".$idorder_so."ref_so->".$ref_so."model_ciu_so->".$model_ciu_so."->".$vvnombre_a_mostrar_en_dvi."->". $enabled_attachfile_step."->". $row_autotest['v_integer'];
                  $tengofuncionecreada=1;
                  crear_steps_so_FINALCAL($step_name_ary ,$row_autotest['wo_serialnumber'], $idorder_wo,$ref_wo,$model_ciu_wo,$idorder_so,$ref_so,$model_ciu_so ,$vvnombre_a_mostrar_en_dvi, $enabled_attachfile_step, 0,$step_nro_ary );
                }
                
                if ($step_name_ary  =="wo_FINALCAL" && $nvostepsrouting[0]==""  )
                {
                  
                  crear_steps_wo_BBUMMS_HP("so_FINCALCAL" ,$row_autotest['wo_serialnumber'], $idorder_wo,$ref_wo,$model_ciu_wo,$idorder_so,$ref_so,$model_ciu_so ,$vvnombre_a_mostrar_en_dvi, $enabled_attachfile_step,$step_nro_ary);
                    
                
                }
               
                if  ($step_name_ary  =="so_ENG-CAL"  )
                {
                $tengofuncionecreada=1;

                     if   ($have_2ndAssy=="N" )
                      {
                      $tengofuncionecreada=1;
                      $haveSOasing="Y";
                      $vvnombre_a_mostrar_en_dvi ='Order Detail :: SO:'.$ref_so." - SN: ".$rowbuscawo['wo_serialnumber'];                              
                  
                        crear_steps_soinfo_only($step_name_ary ,$row_autotest['wo_serialnumber'], $idorder_wo,$ref_wo,$model_ciu_wo,$idorder_so,$ref_so,$model_ciu_so ,$vvnombre_a_mostrar_en_dvi, $enabled_attachfile_step,$step_nro_ary);
                      }


                $vvnombre_a_mostrar_en_dvi ='Order Detail :: SO:'.$ref_so." - SN: ".$rowbuscawo['wo_serialnumber'];     
                                        
               crear_steps_crear_steps_so_ENGCAL($step_name_ary ,$row_autotest['wo_serialnumber'], $idorder_wo,$ref_wo,$model_ciu_wo,$idorder_so,$ref_so,$model_ciu_so ,$vvnombre_a_mostrar_en_dvi, $enabled_attachfile_step,$step_nro_ary);
                
                }
                if  ($step_name_ary  =="so_BURNING"  )
                    {
                    $tengofuncionecreada=1;
                    $vvnombre_a_mostrar_en_dvi ='Order Detail :: sO:'.$ref_so." - SN: ".$rowbuscawo['wo_serialnumber'];                              
                    crear_steps_so_BURNING($step_name_ary ,$row_autotest['wo_serialnumber'], $idorder_wo,$ref_wo,$model_ciu_wo,$idorder_so,$ref_so,$model_ciu_so ,$vvnombre_a_mostrar_en_dvi, $enabled_attachfile_step,$step_nro_ary);                       
                    
                    }

                    if ($step_name_ary   =="wo_MODULE")
                    {
                      $tengofuncionecreada=1;
                      ///   echo "aca".$step_name_ary;   
                      $vvnombre_a_mostrar_en_dvi ='Order Detail :: WO:'.$ref_wo." - SN: ".$rowbuscawo['wo_serialnumber'];   
                  ////     echo              "*******************".$vvnombre_a_mostrar_en_dvi."*******************";               
                       crear_steps_wo_MODULE($step_name_ary ,$row_autotest['wo_serialnumber'], $idorder_wo,$ref_wo,$model_ciu_wo,$idorder_so,$ref_so,$model_ciu_so ,$vvnombre_a_mostrar_en_dvi, $enabled_attachfile_step,$step_nro_ary);                       
                      }

                    if  ($step_name_ary   =="wo_ENG-CAL" || $nvostepsrouting[0] == "EC01"  )
                    {
                    $tengofuncionecreada=1;
                    ///   echo "aca".$step_name_ary;   
                    $vvnombre_a_mostrar_en_dvi ='Order Detail :: WO:'.$ref_wo." - SN: ".$rowbuscawo['wo_serialnumber'];   
                 //    echo              "*******************".$vvnombre_a_mostrar_en_dvi."*******************";    
                //    echo "----"."wo_".$idorder_wo."<--->".$ref_wo,$model_ciu_wo."<--->".$ref_wo."<--->". $enabled_attachfile_step; 
                         

                       crear_steps_wo_ENG($step_name_ary ,$row_autotest['wo_serialnumber'], $idorder_wo,$ref_wo,$model_ciu_wo,$idorder_so,$ref_so,$model_ciu_so ,$vvnombre_a_mostrar_en_dvi, $enabled_attachfile_step,$step_nro_ary);                       
                    }

                    ///crear_steps_wo_BURNING.
                    if  ($step_name_ary =="wo_BURNING" || $nvostepsrouting[0] == "BU01"  )
                    {
                    $tengofuncionecreada=1;
                    $vvnombre_a_mostrar_en_dvi ='Order Detail :: WO:'.$ref_wo." - SN: ".$rowbuscawo['wo_serialnumber'];                              
                        crear_steps_wo_BURNING($step_name_ary ,$row_autotest['wo_serialnumber'], $idorder_wo,$ref_wo,$model_ciu_wo,$idorder_so,$ref_so,$model_ciu_so ,$vvnombre_a_mostrar_en_dvi, $enabled_attachfile_step,$step_nro_ary);                       
                    }
                
                    if  ($step_name_ary  =="wo_ASSY" || $nvostepsrouting[0] == "SA01"  | $nvostepsrouting[0] == "AS01" | $nvostepsrouting[0] == "AP01" )
                    {
                    $tengofuncionecreada=1;
                    $vvnombre_a_mostrar_en_dvi ='Order Detail :: '.$ref_wo." - SN: ".$rowbuscawo['wo_serialnumber'];
                 //    echo "<br>**************<br>";
                 //    echo "----"."wo_".$step_name_ary."<--->".$row_autotest['wo_serialnumber']."<--->".$row_autotest['idorders']."<--->".$vvnombre_a_mostrar_en_dvi."<--->".$ref_wo,$model_ciu_wo."<--->".$ref_wo."<--->". $enabled_attachfile_step; 
                     
                     crear_steps_woinfo_ASSY("wo_ASSY" ,$row_autotest['wo_serialnumber'], $idorder_wo,$ref_wo,$model_ciu_wo,$idorder_so,$ref_so,$model_ciu_so ,$vvnombre_a_mostrar_en_dvi, $enabled_attachfile_step,$step_nro_ary);
                    }

                    if  (   $nvostepsrouting[0] == "FC01" ||  $nvostepsrouting[0] == "wo_QC-FINAL" )
                    {
                    $tengofuncionecreada=1;
                    $vvnombre_a_mostrar_en_dvi ='Order Detail :: '.$ref_wo." - SN: ".$rowbuscawo['wo_serialnumber'];
                 //    echo "<br>**************<br>";
                 //    echo "----"."wo_".$step_name_ary."<--->".$row_autotest['wo_serialnumber']."<--->".$row_autotest['idorders']."<--->".$vvnombre_a_mostrar_en_dvi."<--->".$ref_wo,$model_ciu_wo."<--->".$ref_wo."<--->". $enabled_attachfile_step; 
                 
                     crear_steps_woinfo_ULTEST("wo_ULTEST" ,$row_autotest['wo_serialnumber'], $idorder_wo,$ref_wo,$model_ciu_wo,$idorder_so,$ref_so,$model_ciu_so ,$vvnombre_a_mostrar_en_dvi, $enabled_attachfile_step,$step_nro_ary);
                    }

                    if  (   $nvostepsrouting[0] == "FC02"  )
                    {
                    $tengofuncionecreada=1;
                    $vvnombre_a_mostrar_en_dvi ='Order Detail :: '.$ref_wo." - SN: ".$rowbuscawo['wo_serialnumber'];

                   
                     crear_steps_wo_BBUMMS("wo_BBUMMS" ,$row_autotest['wo_serialnumber'], $idorder_wo,$ref_wo,$model_ciu_wo,$idorder_so,$ref_so,$model_ciu_so ,$vvnombre_a_mostrar_en_dvi, $enabled_attachfile_step,$step_nro_ary);
                    
                    }

                    if  (   $nvostepsrouting[0] == "FC03"   )
                    {
                    $tengofuncionecreada=1;
                    $vvnombre_a_mostrar_en_dvi ='Order Detail :: '.$ref_wo." - SN: ".$rowbuscawo['wo_serialnumber'];
                 
                      crear_steps_wo_BBUMMSRF("wo_BBUMMSRF" ,$row_autotest['wo_serialnumber'], $idorder_wo,$ref_wo,$model_ciu_wo,$idorder_so,$ref_so,$model_ciu_so ,$vvnombre_a_mostrar_en_dvi, $enabled_attachfile_step,$step_nro_ary);
                    }

                    if  ($step_name_ary  =="so_ASSY"  )
                    {
                    $tengofuncionecreada=1;
                    $have_2ndAssy="S";
                    $haveSOasing="Y";
                  
                    
              ///         echo "sssssssssssssssssssssssssssssssssssss".$ref_so;
               //    echo "----"."wo_".$step_name_ary."<--->".$row_autotest['wo_serialnumber']."<--->idorder_so".$idorder_so."<--->ref_so".$ref_so."<--->".$ref_wo,$model_ciu_wo."<--->".$ref_wo."<--->". $enabled_attachfile_step; 
                 
                    $vvnombre_a_mostrar_en_dvi ='Order Detail :: '.$ref_so." - SN: ".$rowbuscawo['wo_serialnumber']; 
                    crear_steps_soinfo_ASSY($step_name_ary ,$row_autotest['wo_serialnumber'], $idorder_wo,$ref_wo,$model_ciu_wo,$idorder_so,$ref_so,$model_ciu_so ,$vvnombre_a_mostrar_en_dvi, $enabled_attachfile_step,$step_nro_ary);                             
                        
                   
                    }

                    if  ($step_name_ary  =="wo_RWKASSY"   | $nvostepsrouting[0] == "RWKA" )
                    {
                    $tengofuncionecreada=1;
                    $vvnombre_a_mostrar_en_dvi ='Order Detail :: WO:'.$ref_wo." - SN: ".$rowbuscawo['wo_serialnumber'];                              
                    crear_steps_woinfo_ASSY($step_name_ary ,$row_autotest['wo_serialnumber'], $idorder_wo,$ref_wo,$model_ciu_wo,$idorder_so,$ref_so,$model_ciu_so ,$vvnombre_a_mostrar_en_dvi, $enabled_attachfile_step,$step_nro_ary);
                    
                    }

                    if  ($step_name_ary  =="wo_2ND-ASSY"  )
                    {
                      $have_2ndAssy="S";
                    //   echo "idorder_wo->".$idorder_wo."ref_wo->".$ref_wo."model_ciu_wo->".$model_ciu_wo."idorder_so->".$idorder_so."ref_so->".$ref_so."model_ciu_so->".$model_ciu_so."->".$vvnombre_a_mostrar_en_dvi."->". $enabled_attachfile_step."->". $row_autotest['v_integer'];
                       $tengofuncionecreada=1;
                       $vvnombre_a_mostrar_en_dvi ='Order Detail :: '.$ref_wo." - SN: ".$rowbuscawo['wo_serialnumber'];
                    //    echo "<br>**************<br>";
                    //    echo "----"."wo_".$step_name_ary."<--->".$row_autotest['wo_serialnumber']."<--->".$row_autotest['idorders']."<--->".$vvnombre_a_mostrar_en_dvi."<--->".$ref_wo,$model_ciu_wo."<--->".$ref_wo."<--->". $enabled_attachfile_step; 
                    
                        crear_steps_woinfo_ASSY("wo_2ND-ASSY" ,$row_autotest['wo_serialnumber'], $idorder_wo,$ref_wo,$model_ciu_wo,$idorder_so,$ref_so,$model_ciu_so ,$vvnombre_a_mostrar_en_dvi, $enabled_attachfile_step,$step_nro_ary);
                       
                    }
                    
                  //  if   ($step_name_ary  =="so_2ND-ASSY"  )
                    if   ($step_name_ary  =="so_2ND-ASSY"  )
                  
                    {
                      $have_2ndAssy="S";
                    $tengofuncionecreada=1;
                    $vvnombre_a_mostrar_en_dvi ='Order Detail :: SO:'.$ref_so." - SN: ".$rowbuscawo['wo_serialnumber'];                              
                
                      crear_steps_soinfo_ASSY($step_name_ary ,$row_autotest['wo_serialnumber'], $idorder_wo,$ref_wo,$model_ciu_wo,$idorder_so,$ref_so,$model_ciu_so ,$vvnombre_a_mostrar_en_dvi, $enabled_attachfile_step,$step_nro_ary);
                    }



                    //crear_steps_soinfo_only
                    if   ($step_name_ary  =="so_INFOSO"  )
                    {
                    $tengofuncionecreada=1;
                    $vvnombre_a_mostrar_en_dvi ='Order Detail :: SO:'.$ref_so." - SN: ".$rowbuscawo['wo_serialnumber'];                              
                
                      crear_steps_soinfo_only($step_name_ary ,$row_autotest['wo_serialnumber'], $idorder_wo,$ref_wo,$model_ciu_wo,$idorder_so,$ref_so,$model_ciu_so ,$vvnombre_a_mostrar_en_dvi, $enabled_attachfile_step,$step_nro_ary);
                    }
                

                    if  ($step_name_ary  =="wo_PRECHECK" ||$step_name_ary  =="wo_RWKPRECHECK"  || $nvostepsrouting[0] == "PC01" ||$step_name_ary  =="wo_RWKPRCHK"  | $nvostepsrouting[0] == "RWKP" )
                    {
                      $name_steps_prechcl =$step_name_ary;
                        if (  $nvostepsrouting[0] == "PC01")
                        {
                          $name_steps_prechcl = "wo_PRECHECK";
                        }
                    $tengofuncionecreada=1;
                    $vvnombre_a_mostrar_en_dvi ='Order Detail :: WO:'.$ref_wo." - SN: ".$rowbuscawo['wo_serialnumber'];       
                    crear_steps_woinfo_PRECHECK( $name_steps_prechcl ,$row_autotest['wo_serialnumber'], $idorder_wo,$ref_wo,$model_ciu_wo,$idorder_so,$ref_so,$model_ciu_so ,$vvnombre_a_mostrar_en_dvi, $enabled_attachfile_step,$step_nro_ary);                       
                 
                    }
                    if  ($step_name_ary  =="so_PRECHECK"    )
                    {
                    $tengofuncionecreada=1;
                    $haveSOasing="Y";
                //      echo "ssssssss222222222222222sssssssssssssssssssssssssssss";
                //      echo $ref_so;

                    $vvnombre_a_mostrar_en_dvi ='Order Detail :: SO:'.$ref_so." - SN: ".$rowbuscawo['wo_serialnumber'];                              
                    crear_steps_soinfo_FINALINSPEC($step_name_ary ,$row_autotest['wo_serialnumber'], $idorder_wo,$ref_so,$model_ciu_so,$idorder_so,$ref_so,$model_ciu_so ,$vvnombre_a_mostrar_en_dvi, $enabled_attachfile_step,$step_nro_ary);                       
               
                  }
                    if  ($step_name_ary  =="wo_A.BURN" || $nvostepsrouting[0] == "AB01"    )
                    {
                    $tengofuncionecreada=1;
                    $vvnombre_a_mostrar_en_dvi ='Order Detail :: WO:'.$ref_wo." - SN: ".$rowbuscawo['wo_serialnumber'];                              
                    
                    crear_steps_wo_AFTERBURNING($step_name_ary ,$row_autotest['wo_serialnumber'], $idorder_wo,$ref_wo,$model_ciu_wo,$idorder_so,$ref_so,$model_ciu_so ,$vvnombre_a_mostrar_en_dvi, $enabled_attachfile_step,$step_nro_ary);                       
                    }
                    
$ojo=1;
         if (  $tengofuncionecreada==0 && $ojo==0)
         {
          ?>
<div class="stepazulyamarillo active">

    <span class="icon"> <i class="fa fa-check"></i> </span> <span
        class="text"><b>SO:<?php //echo $rowbuscawo['tienesoasociada']; ?> <br>CIU : <?php //echo  $ciutemp; ?></b>
    </span>

</div>
<?php
         }
         
            
    }     

         ////out for,now chk if have SO ?
      //   echo "ABC___ABC-->".$haveSOasing."-------".$rowbuscawo['wo_serialnumber'];
        
         if($haveSOasing == "Y" && $rowbuscawo['wo_serialnumber']<>'')
         {

      //    echo "CHECKEO UPGRADE";

          $esupgrade ="N";
          $Sql_ifupgrade = $connect->prepare(" select distinct modelciu, idorders from orders_sn inner join  fnt_select_allproducts_maxrev() as ppp on ppp.idproduct = orders_sn.idproduct   where wo_serialnumber = '".$rowbuscawo['wo_serialnumber']."' and typeregister = 'UP' ");                                 
          $Sql_ifupgrade->execute();
          $result_ifup = $Sql_ifupgrade->fetchAll();	
          foreach ($result_ifup as $row_up)
          {
            $esupgrade ="Y";
            $vvnombre_a_mostrar_en_dvi ='Order Detail :: '.$ref_so." - SN: ".$rowbuscawo['wo_serialnumber'];                              
            crear_steps_so_UPGRADELIC($step_name_ary ,$row_autotest['wo_serialnumber'], $idorder_wo,$ref_wo,$model_ciu_wo,$idorder_so,$ref_so,$model_ciu_so ,$vvnombre_a_mostrar_en_dvi, $enabled_attachfile_step,$step_nro_ary);
            
            
          }

       
         
         }
        
         if ($haveSOasing == "N" && $haveSteps=='Y'  )
         {
    //      echo "aaaaaaaaaaaaaaaaaaaa*".trim($ref_so)."*bbbbbbbbbbbbbbbbbbbb";
            if ( trim($ref_so)=='')
            {
              $haveSOasing= "P";
        ///      echo "cccccccccccc";
              ?>
<div class="stepazulyamarillo active">

    <span class="icon"> <i class="fa fa-check"></i> </span> <span
        class="text"><b>SO:<?php //echo $rowbuscawo['tienesoasociada']; ?> <br>CIU : <?php //echo  $ciutemp; ?></b>
    </span>
    <a href="#"
        onclick="show_info('asingsnwotoso','<?php echo $rowbuscawo['wo_serialnumber']; ?>','<?php echo $rowbuscawo['idorders']; ?>','',0,0)">
        <span class="badge bg-warning"><b>Assign SN <?php // echo "a verrrrrrrr".$ref_so; ?> </b></span>
    </a>
</div>
<?php
            }
            else
            {
              /*
                 <div class="stepazulyamarillo active">
                                        
                  <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text"> 
                 
                  <br><span style='color:red'><b>NO PO Parameters.</B></span>
                </div>
              */
              ?>

<?php

              $vvnombre_a_mostrar_en_dvi ='Order Detail :: '.$ref_so." - SN: ".$vv_tempsn; 
           ///   crear_steps_soinfo_parch("so_2ND-ASSY" ,$vv_tempsn, $idorder_wo,$ref_wo,$model_ciu_wo,$idorder_so,$ref_so,$model_ciu_so."" ,$vvnombre_a_mostrar_en_dvi, $enabled_attachfile_step);                             
                             
                
              
            }
        
           

         }
         if($haveSteps=='N')
         {
          ?>
<br><br>
<div class="alert alert-danger" role="alert">
    SO-SN <?php echo $rowbuscawo['wo_serialnumber']; ?> without tracking steps received.
</div>
<br><br><br><br>
<?php
         }


  //////////////
    }
    /// Cierro if de SN VACIO       


    /////////////////////////////////////////////////////////////////////////
function crear_steps_so_UPGRADELIC ($vv_worcenter,$vv_sn, $vvv_idwo,$vvv_idwo_nom,$vvv_idwo_ciu , $vvv_idso,$vvv_idso_nom,$vvv_idso_ciu, $vvnombre_a_mostrar_en_dvi, $v_enable_attachfile, $vv_step_nro_ary)
{
  include("db_conect.php"); 

  $psswdtkkey = substr( md5(microtime()), 1, 8);
  $psswdtkkey = substr( md5(microtime()), 2, 8);
  $esupgrade ="N";
  $Sql_ifupgrade = $connect->prepare(" select distinct modelciu, idorders from orders_sn inner join  fnt_select_allproducts_maxrev() as ppp on ppp.idproduct = orders_sn.idproduct  
   where wo_serialnumber = '".$vv_sn."' and typeregister = 'UP' ");       
 
  $Sql_ifupgrade->execute();
  $result_ifup = $Sql_ifupgrade->fetchAll();	
  foreach ($result_ifup as $row_up)
  {
    $esupgrade ="Y";
    $elmodelcuiupgrade = $row_up['modelciu'];
    $idorders_upgrde =  $row_up['idorders']; 
    
  }
  if ( $esupgrade =="Y")
  {

 
   // echo " select * from fnt_select_upgrade_finalsku_ia_detect_lic('".$vvv_idso_ciu."','".$elmodelcuiupgrade."') ";
   
      $Sql_ifupgrade2 = $connect->prepare(" select * from fnt_select_upgrade_finalsku_ia_detect_lic('".$vvv_idso_ciu."','".$elmodelcuiupgrade."') ");                                 
      $Sql_ifupgrade2->execute();
      $result_ifup2 = $Sql_ifupgrade2->fetchAll();	
      foreach ($result_ifup2 as $row_up2)
      {
      $skucalculado = $row_up2['v_fsku'];
      }

   
  ?>
<div class="stepazul active">
    <a href="#"
        onclick="show_info('orderinfoupgrade','<?php echo $vv_sn; ?>','<?php echo $idorders_upgrde; ?>','<?php echo $skucalculado; ?>',0,0)">
        <span class="icon"><i class="fas fa-box"></i> </span> <span class="text"><b>Upgrade PN<br>
                <?php echo  $elmodelcuiupgrade;?>
                <?php
   echo "<br>".$skucalculado ;

  ?>

                <span class='text text-left'>
                    <a href="#"
                        onclick="Call_printlabel_upgrade('<?php echo $skucalculado; ?>', '<?php echo $vv_sn; ?>' ,'<?php echo $idorders_upgrde; ?>')">&nbsp;
                        <i class="fas fa-print"></i> - Print Label</a>
                    <br><a href="printokeyupgrade.php?vido=<?php echo $idorders_upgrde; ?>&sn=<?php echo $vv_sn; ?>"
                        target='_blank'>&nbsp; <i class="fas fa-file-pdf"></i> - View PDF</a>
                    <br>
                    <br> </span> </b>
    </a>
    </span>
</div>
<?php
  }
}

function crear_steps_crear_steps_so_ENGCAL ($vv_worcenter,$vv_sn, $vvv_idwo,$vvv_idwo_nom,$vvv_idwo_ciu , $vvv_idso,$vvv_idso_nom,$vvv_idso_ciu, $vvnombre_a_mostrar_en_dvi, $v_enable_attachfile,$vv_step_nro_ary)
{
  include("db_conect.php"); 

  $psswdtkkey = substr( md5(microtime()), 1, 8);
  $psswdtkkey = substr( md5(microtime()), 2, 8);

    if ($have_finalcal == 'Y')
    {

    }
    else
    {
      
      ?>
<div class="step  "> <span class="icon"><i class="	fas fa-box"></i> </span> <span
        class="text"><?php echo  '['.$vv_step_nro_ary.'] - '.substr($vv_worcenter,3,12); ?> <br>

        <?php if ( $v_enable_attachfile=="Y") { ?>
        <a href="#"
            onclick="attachanalogbda(<?php echo $vv_idp; ?>,'<?php echo  $vv_worcenter.'_'.$psswdtkkey;?>','<?php echo $vv_sn; ?>')">
            <i class="fa fa-paperclip" aria-hidden="true"></i> Attach Files
        </a> <br>
        <?php } ?>
    </span></div>
<?php  
    }
 
}


function crear_steps_so_BURNING ($vv_worcenter,$vv_sn, $vvv_idwo,$vvv_idwo_nom,$vvv_idwo_ciu , $vvv_idso,$vvv_idso_nom,$vvv_idso_ciu, $vvnombre_a_mostrar_en_dvi, $v_enable_attachfile,$vv_step_nro_ary)
{
  include("db_conect.php"); 

  $psswdtkkey = substr( md5(microtime()), 1, 8);
  $psswdtkkey = substr( md5(microtime()), 2, 8);

    if ($have_finalcal == 'Y')
    {

    }
    else
    {
      
      ?>
<div class="step  "> <span class="icon"><i class="fas fa-box"></i> </span> <span
        class="text"><?php echo  '['.$vv_step_nro_ary.'] - '.substr($vv_worcenter,3,12); ?> <br>

        <?php if ( $v_enable_attachfile=="NO_Y") { ?>
        <a href="#"
            onclick="attachanalogbda(<?php echo $vv_idp; ?>,'<?php echo  $vv_worcenter.'_'.$psswdtkkey;?>','<?php echo $vv_sn; ?>')">
            <i class="fa fa-paperclip" aria-hidden="true"></i> Attach Files
        </a> <br>
        <?php } ?>
    </span></div>
<?php  
    }
 
}


function crear_steps_so_FINALCAL ($vv_worcenter,$vv_sn, $vvv_idwo,$vvv_idwo_nom,$vvv_idwo_ciu , $vvv_idso,$vvv_idso_nom,$vvv_idso_ciu, $vvnombre_a_mostrar_en_dvi, $v_enable_attachfile, $nroItemSteps,$vv_step_nro_ary)
{
  include("db_conect.php"); 

  $psswdtkkey = substr( md5(microtime()), 1, 8);
  $psswdtkkey = substr( md5(microtime()), 2, 8);


  //echo "HOLA3333..".$nroItemSteps."..33";

//////////////////////////////////////////////////////////
 If($nroItemSteps==0)
 {
  ?>
<div class="stepazul   active">

    <a href="#"
        onclick="show_info('orderinfo','<?php echo $vv_sn; ?>','<?php echo $vvv_idso; ?>','<?php echo $vvnombre_a_mostrar_en_dvi; ?>',0,0)">

        <span class="icon"> <i class="fa fa-check"></i> </span>
        <span class="text text-center">


            <b> SO: [<?php echo $vvv_idso_nom; ?>]<br>CIU: [<?php echo  $vvv_idso_ciu; ?>]</b>
            <br><b> SN Generated: [<?php echo $vv_sn; ?>]</b><br>
    </a>
    <p class='  text-center'>
        <a href="#"
            onclick="Call_printlabel('<?php echo  $vvv_idso_ciu; ?>', '<?php echo $vv_sn; ?>' ,'<?php echo  $vvv_idso ; ?>')"><i
                class="fas fa-print"></i> - Print Label
        </a>
</div>

<?php
 }

$vv_worcenter_show = substr(trim($vv_worcenter),3,10);
$no_idruninfowo_ENGCAL=0;
$v_idp = $vv_idp;


$modelciuwo = $vvv_idso_ciu;
$idorderwo =  $vvv_idso;
$wo_info = $vvv_idso_nom;
if ($modelciuwo =="SPAKIT-BTTY-10-INN")
{
  $wo_info= $vvv_idwo_nom;
}
//echo "marco:::".$wo_info."::::";
if ($wo_info =="")
{
  $wo_info= $vvv_idwo_nom;
}
$vtempidproduct =  $rowwo['idproduct'];


   //////// DAS ENTERPRICE REMOTE NO MOSTRARRR //////
                                                   /////**************************************************** 
                                                 ///Detectamos CIU
                                                 /////**************************************************** 
                                                 /////**************************************************** 
                                                 $ciuisbda="N";
                                                 $ciuisenterprice="N";
                                                 $ciuisremote="N";
                                                 $ciuismaster="N";
                                                 $ciuisdas="N";
                                                 $ciusannunciator="N";
                                                 $sqldetect="select fnt_select_detect_bysn_isbda_isdas('".$vv_sn."','WO') ";
                                        //      echo  $sqldetect;
                                                 $datadetect = $connect->query($sqldetect)->fetchAll();
                                                 foreach ($datadetect as $rowdetect) 
                                                             {	
                                                           //	  echo "****.....".$rowdetect[0];
                                                               $resulm = json_decode($rowdetect[0]);
                                                             ///  echo "****".$resulm->{'isdba'};
                                                               if( $resulm->{'isdba'} >0 )
                                                               {
                                                               $ciuisbda="Y";
                                                               }
                                                               if( $resulm->{'isdas'} >0 )
                                                               {
                                                               $ciuisdas="Y";
                                                               }
                                                               if( $resulm->{'isenterprise'} >0 )
                                                               {
                                                               $ciuisenterprice="Y";
                                                               }
                                                               if( $resulm->{'isremote'} >0 )
                                                               {
                                                               $ciuisremote="Y";
                                                               }
                                                               if( $resulm->{'ismaster'} >0 )
                                                               {
                                                               $ciuismaster="Y";
                                                               }

                                                               if( $resulm->{'isannunciator'} >0 )
                                                               {
                                                               $ciusannunciator="Y";
                                                               }


                                                             


                                                              
                                                             } 
                                                         
                                                         
                                                 /////**************************************************** 								
                                                 //fin detectamos CIU

                                             
$Sql_ifautotest = $connect->prepare("  
 select idscript, fas_outcome_integral.v_boolean::integer as tienecalibration_totalpass, fas_outcome_integral.reference
from fas_outcome_integral
inner join ( select reference, v_integer as idscript from fas_outcome_integral 
         where reference in ( select reference from fas_outcome_integral 
                   where reference in (select reference from fas_outcome_integral
                             where v_string ='".$vv_sn."' 
                              ) 
                   and v_string =  '".$wo_info."'
                    ) 
         and idfasoutcomecat = 0 and idtype= 12 and v_integer in( 3,35,39,22 )
          ) as lossub
on lossub.reference = fas_outcome_integral.reference
where fas_outcome_integral.idfasoutcomecat = 0 and 
fas_outcome_integral.idtype= 13 order by datetimeref desc limit 1


             ");        
             
      
$Sql_ifautotest->execute();
$_if_auto_test_box_calibration = "N";
$activo_paso3_totalpass = "";
$activo_paso3 ="";
$result_ifautotest = $Sql_ifautotest->fetchAll();	
foreach ($result_ifautotest as $row_autotest)
{
 //echo "<br>aaaaaaaaaaaaaa".$row_autotest['idscript'];
 if ( $row_autotest['idscript']<> 2)
 {
   $_if_auto_test_box_calibration = "Y";
 }
 
 $idruninfowo_ENG = $row_autotest['reference'];
 $no_idruninfowo_ENGCAL=1;
   if ($row_autotest['tienecalibration_totalpass']==1 && $idruninfowo_ENG <>"")
 {
   
     $activo_paso3_totalpass = "<span class='badge bg-success'>Passed</span><br><a href='#' onclick='popuplogdb(".$idruninfowo_ENG.")'  style='color:#f39323;'>View Log <i class='fas fa-eye'> </i></a>";
 
 
 
 }
 if ($rowbuscawo['tienecalibration_totalpass']==0 && $idruninfowo_ENG <>"")
 {
   
     $activo_paso3_totalpass = "<span class='badge bg-danger'>Not Passed</span><br><a href='#' onclick='popuplogdb(".$idruninfowo_ENG.")'  style='color:#f39323;'>View Log <i class='fas fa-eye'></i></a>";
 
 }

}

$nombre_a_mostrar_en_dvi_calib ='Calibration :: SN: '.$vv_sn;
/////**************************************************** 
//           echo   "aaaaa".$_if_auto_test_box_calibration;
if ( $idruninfowo_ENG <>"")
{
 $activo_paso3 = "active";
 $activo_paso3_totalpass ="";
 $activo_paso3_totalpass = "<span class='badge bg-success'>Passed</span><br><a href='#' onclick='popuplogdb(".$idruninfowo_ENG.")'  style='color:#f39323;'>View Log <i class='fas fa-eye'> </i></a>";
 
}

/////
/////Buscamos el tipo de reporte para el SKU

$Sql_typeproducrepor = $connect->prepare(" select reporttype from products_webfas_report  where idproduct in ( select distinct idproduct from products where modelciu = '".$modelciuwo."')   ");        
           
$name_js_report = '';    
$Sql_typeproducrepor->execute();

$result_typrepor = $Sql_typeproducrepor->fetchAll();	
foreach ($result_typrepor as $row_typerepo)
{
 $name_js_report = $row_typerepo['reporttype'];    
}

if (substr($nombre_ciu_amostrar ,0,3)=="DH7" )
{
/// $idruninfoAfertburnung=0;

       $tipolinkweb="finalchkso";


      if ( $ciuisenterprice=="Y" &&   $ciuismaster=="Y" )
      {
        
        $idruninfoAfertburnung=99;  
        $tipolinkweb=" ";
        $namephp="reportfinchhcoutcome.php";
      
      }
      else
      {
        $idruninfoAfertburnung=0;
      
        $namephp="calibrationtopdfconimgsaleorders.php";
      }                        
}
else
{
  if ( $ciuisenterprice=="Y" &&   $ciuisremote=="Y" )
  {
       $tipolinkweb="finalchksoentremoto";
       $namephp="calibrationtopdfconimgsaleordersentrem.php";
  }
  else
  {

    if ( $ciuisenterprice=="Y" &&   $ciuismaster=="Y" )
    {
      
      $idruninfoAfertburnung=99;  
      $tipolinkweb=" ";
      $namephp="reportfinchhcoutcome.php";
     
    }
    else
    {
       
        $idruninfoAfertburnung=0;
        $tipolinkweb="finalchksotemp";
        $namephp="calibrationtopdfconimgsaleorders.php";
      
     
    }                                              
    
    
  }
  
}
if ($no_idruninfowo_ENGCAL>0)
{
?>
<div class="step <?php echo  $activo_paso3; ?>">



    <a href="#"
        onclick="show_info('<?php echo  $tipolinkweb; ?>','<?php echo $vv_sn; ?>','<?php echo $idorderwo; ?>','<?php echo $nombre_a_mostrar_en_dvi_calib; ?>','<?php echo $idruninfowo_ENG; ?>',0)">
        <span class="icon"> <i class="fas fa-box"></i> </span> <span class="text"><b>
                <?php echo '['.$vv_step_nro_ary.'] - '.$vv_worcenter_show; ?>
                <br> <?php echo $activo_paso3_totalpass; ?></span></a></b>
    <br><a
        href="<?php echo $namephp;?>?unitsn=<?php  echo  $vv_sn;?>&idsndib=<?php echo  $vv_sn; ?>&amp;iduldl=0&amp;idmb=0&idrunaferbur=<?php echo $idruninfowo_ENG;?>"
        target="_blank"> <i class='fas fa-file-pdf'></i> - View Report </a>
    <br>

    <?php
//////

}
         
        if ($no_idruninfowo_ENGCAL==0)
         {
          $psswdtkkey = substr( md5(microtime()), 2, 8);

          // aca preguntamos si es ANN. para cargar una formulario particular..
      //    echo "<br>ciusannunciator".$ciusannunciator;
           if ( $ciusannunciator=="Y")
           {


            $sqldetectchkeo="SELECT   status_sn  FROM public.fas_survey_responses_bysn where idsurvey in (5,6) and  sn = '".$vv_sn."' and  so = '". $vvv_idso_nom."' and modelciu = '".$vvv_idso_ciu."'
            order by datetimecheck desc limit 1 ";

      //   	echo "test:".$sqldetectchkeo;
         $tieneregelstep ="step";
         $tienestado ="";
            $datadetectprecheko = $connect->query($sqldetectchkeo)->fetchAll();
            foreach ($datadetectprecheko as $rowchequeo) 
            {
                if ($rowchequeo['status_sn']=="PASS")
                {
                  //  echo "    <span class='badge bg-success'>FAS::Passed</span><br>";
                    $tieneregelstep ="stepverde active  ";
                    $tienestado ="<span class='badge bg-success'>FAS::Passed</span>";
                }
                else
                {
                 // echo "    <span class='badge bg-danger'>FAS::Fail</span><br>";
                    $tienestado ="<span class='badge bg-danger'>FAS::Fail</span>";
                }
            }

            ?>
    <div class="  <?php echo $tieneregelstep;?> ">
        <a href="#"
            onclick="show_info_stepidsap('PrecheckBBUANN','<?php echo $vv_sn; ?>','<?php echo $vvv_idso_nom; ?>','<?php echo $vvv_idso_ciu;?>','Quality Calibration Precheck','<?php echo $vv_worcenter_show; ?>','<?php echo $vv_step_nro_ary; ?>')">
            <span class="icon"> <i class="fas fa-box"></i> </span> <span
                class="text"><?php echo '['.$vv_step_nro_ary.'] - '.$vv_worcenter_show; ?>
        </a>
        <?php echo  $tienestado;?>




        <?php if ( $v_enable_attachfile=="Y") { ?>
        <br>
        <a href="#"
            onclick="attachanalogbda(<?php echo $vv_idp; ?>,'<?php echo  $vv_worcenter.'_'.$psswdtkkey;?>','<?php echo $vv_sn; ?>')">
            <i class="fa fa-paperclip" aria-hidden="true"></i> Attach Files
        </a> <br>
        </span> <br>
        <?php } ?>

        <?php
           }
           else
           {

            ?>
        <div class="step "> <span class="icon"> <i class="fas fa-box"></i> </span> <span
                class="text"><?php echo '['.$vv_step_nro_ary.'] - '.$vv_worcenter_show; ?><br>

                <?php if ( $v_enable_attachfile=="Y") { ?>
                <a href="#"
                    onclick="attachanalogbda(<?php echo $vv_idp; ?>,'<?php echo  $vv_worcenter.'_'.$psswdtkkey;?>','<?php echo $vv_sn; ?>')">
                    <i class="fa fa-paperclip" aria-hidden="true"></i> Attach Files
                </a> <br>
            </span> <br>
            <?php } ?>

            <?php
           }
        
         }

    
         
     
           
         $sqlmaxhistory = " select * from fas_to_sap_xml where v_sn ='".$vv_sn."' and v_workcenetr = '".substr($vv_worcenter,3,22)."'  and v_sku = '".$modelciuwo."' and
         runprocessdate in (
   select max(runprocessdate) from fas_to_sap_xml where v_sn ='".$vv_sn."' and v_workcenetr = '".substr($vv_worcenter,3,22)."' and v_sku = '".$modelciuwo."' )

   ";
      ///   echo $sqlmaxhistory;
           $datahist = $connect->query($sqlmaxhistory)->fetchAll();	
           foreach ($datahist as $row2hh) 
           {
               //echo $row2hh['v_state']."<br>".$row2hh['v_state_result'];
               if ($row2hh['v_state']==0)
               {
                 echo "<br><span class='badge bg-secondary' title='".$row2hh['v_state_result']."'>SAP::Pending RESORD</span>";
               }
               if ($row2hh['v_state']==1)
               {
                 echo "<br><span class='badge bg-warning' title='".$row2hh['v_state_result']."'>SAP::Run</span>";
               }
               if ($row2hh['v_state']==2)
               {
                 echo "<br><span class='badge bg-warning' title='".$row2hh['v_state_result']."'>SAP::Pending ACK</span>";
               }
               if ($row2hh['v_state']==3)
               {
                 echo "<br><span class='badge bg-danger' title='".$row2hh['v_state_result']."'>SAP::Error </span>";
               }
               if ($row2hh['v_state']==4)
               {
                   echo "<br><span class='badge bg-info' title='".$row2hh['v_state_result']."'>SAP::OK ACK</span>";
               }
               if ($row2hh['v_state']==5)
               {
                   echo "<br><span class='badge bg-danger' title='".$row2hh['v_state_result']."'>SAP::Error ACK</span>";
               }
               /// echo "<br>".$row2hh['v_state_result'];
           }  
       
    ///este div cierra ambos casos OJO       
   ?>
        </div>
        <?php
   ///////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
 
}

function crear_steps_wo_AFTERBURNING ($vv_worcenter,$vv_sn, $vvv_idwo,$vvv_idwo_nom,$vvv_idwo_ciu , $vvv_idso,$vvv_idso_nom,$vvv_idso_ciu, $vvnombre_a_mostrar_en_dvi, $v_enable_attachfile,$vv_step_nro_ary)
{
    ////////////////////////inio WO BURNING
    $nombre_a_mostrar_en_dvi_finalchk ='After Burning :: SN: '.$vv_sn;
    $v_idp =  $vvv_idwo;
    $vv_soworam = $vvv_idwo_nom;
   ///////////////// wo_afterburning //////////////////////////
   include("db_conect.php"); 

        /////**************************************************** 
                                                  ///Detectamos CIU
                                                  /////**************************************************** 
                                                  /////**************************************************** 
                                                  $ciuisbda="N";
                                                  $ciuisenterprice="N";
                                                  $ciuisremote="N";
                                                  $ciuismaster="N";
                                                  $ciuisdas="N";
                                                  $sqldetect="select fnt_select_detect_bysn_isbda_isdas('".$vv_sn."','WO') ";
                                         //      echo  $sqldetect;
                                                  $datadetect = $connect->query($sqldetect)->fetchAll();
                                                  foreach ($datadetect as $rowdetect) 
                                                              {	
                                                            //	  echo "****.....".$rowdetect[0];
                                                                $resulm = json_decode($rowdetect[0]);
                                                              ///  echo "****".$resulm->{'isdba'};
                                                                if( $resulm->{'isdba'} >0 )
                                                                {
                                                                $ciuisbda="Y";
                                                                }
                                                                if( $resulm->{'isdas'} >0 )
                                                                {
                                                                $ciuisdas="Y";
                                                                }
                                                                if( $resulm->{'isenterprise'} >0 )
                                                                {
                                                                $ciuisenterprice="Y";
                                                                }
                                                                if( $resulm->{'isremote'} >0 )
                                                                {
                                                                $ciuisremote="Y";
                                                                }
                                                                if( $resulm->{'ismaster'} >0 )
                                                                {
                                                                $ciuismaster="Y";
                                                                }


                                                               
                                                              } 
                                                          
                                                          
                                                  /////**************************************************** 								
                                                  //fin detectamos CIU

   $modelciuwo = $vvv_idwo_ciu;
   $idorderwo = $vvv_idwo;
   $wo_info = $vvv_idwo_nom;


  $psswdtkkey = substr( md5(microtime()), 1, 8);
  $psswdtkkey = substr( md5(microtime()), 2, 8);
     $linkreportafter_burning_check="calibrationtopdfconimg.php";
      ///////////////////////////////////////////////////////
      //Control si es Enterprise Remoto estos ud tenia 3,35,39
 

      $Sql_ifautotest = $connect->prepare("  
      select idscript, fas_outcome_integral.v_boolean::integer as tienecalibration_totalpass, fas_outcome_integral.reference
    from fas_outcome_integral
    inner join ( select reference, v_integer as idscript from fas_outcome_integral 
              where reference in ( select reference from fas_outcome_integral 
                        where reference in (select reference from fas_outcome_integral
                                  where v_string ='".$vv_sn."' 
                                   ) 
                        and v_string =  '".$wo_info."'
                         ) 
              and idfasoutcomecat = 0 and idtype= 12 and v_integer in(3, 33,38,52 )
               ) as lossub
    on lossub.reference = fas_outcome_integral.reference
    where fas_outcome_integral.idfasoutcomecat = 0 and 
    fas_outcome_integral.idtype= 13    
                  ");          
      
                  
     $Sql_ifautotest->execute();
     $idruninfoAfertburnung = 0;
     $result_ifautotest = $Sql_ifautotest->fetchAll();	
     foreach ($result_ifautotest as $row_autotest)
     {
            
        $idruninfoAfertburnung = $row_autotest['reference'];

        if ( $row_autotest['tienecalibration_totalpass'] == 1  )
        {
          $activo_paso4 = "active";
          $activo_paso4_totalpass = "<span class='badge bg-success'>Passed</span><br><a href='#' onclick='popuplogdb(".$idruninfoAfertburnung.")'  style='color:#f39323;'>View Log <i class='fas fa-eye'></i></a>";
      
        }
        else
        {
          
          $activo_paso4_totalpass = "<span class='badge bg-danger'>Not Passed</span><br><a href='#' onclick='popuplogdb(".$idruninfoAfertburnung.")'  style='color:#f39323;'>View Log <i class='fas fa-eye'></i></a>";
        
        }     
  
     }
   
      ///

       if (  $idruninfoAfertburnung >0)
       {
        $idruninfoAfertburnung = $row_autotest['reference'];

       ?>
        <div class="step <?php echo  $activo_paso4; ?>">
            <?php 
    
                                             
 

       if ( $ciuisenterprice =='Y')
             {
               ////Buscamos si el runinfo pasoo o no..para el ENT REM
               $linkreportafter_burning_check="reportafbcoutcome.php";
             

                 if ( $ciuisremote =="Y")
                 {
                   ?>
            <a href="#"
                onclick="show_info('finalchkenterpriseremoto','<?php echo $vv_sn; ?>','<?php echo $v_idp; ?>','<?php echo $nombre_a_mostrar_en_dvi_finalchk; ?>','<?php echo   $idruninfoAfertburnung; ?>',0)"><span
                    class="icon"><i class="fas fa-box"></i> </span> <span
                    class="text"><b><?php echo '['.$vv_step_nro_ary.'] - '.substr($vv_worcenter,3,12); ?> <br>
                        <?php
                 }
                 if ( $ciuismaster =="Y")
                 {
                   ?>
                        <a href="#"
                            onclick="show_info('finalchkenterprisemaster','<?php echo $vv_sn; ?>','<?php echo $v_idp; ?>','<?php echo $nombre_a_mostrar_en_dvi_finalchk; ?>','<?php echo   $idruninfoAfertburnung; ?>',0)"><span
                                class="icon"><i class="fas fa-box"></i> </span> <span
                                class="text"><b><?php echo '['.$vv_step_nro_ary.'] - '.substr($vv_worcenter,3,12); ?><br>
                                    <?php
                 }
               ?>

                                    <?php
             }
             else
             {
             
               ?>
                                    <a href="#"
                                        onclick="show_info('finalchk','<?php echo $vv_sn; ?>','<?php echo $v_idp; ?>','<?php echo $nombre_a_mostrar_en_dvi_finalchk; ?>','<?php echo $idruninfoAfertburnung; ?>',0)"><span
                                            class="icon"><i class="fas fa-box"></i> </span> <span class="text"><b>
                                                <?php echo '['.$vv_step_nro_ary.'] - '.substr($vv_worcenter,3,12); ?>
                                                <br>
                                                <?php
             }?>


                                                <?php echo $activo_paso4_totalpass; ?></span></a> </b>
                                <br> <a
                                    href="<?php echo  $linkreportafter_burning_check; ?>?idsndib=<?php echo  $vv_sn; ?>&iduldl=0&idmb=0&idrun=<?php echo $idruninfoAfertburnung;;?>"
                                    target="_blank"> <i class='fas fa-file-pdf'></i> - View Report</a>
                        </a><br>
                        <?php if ( $v_enable_attachfile=="Y") { 
                      
                      $psswdtkkey = substr( md5(microtime()), 2, 8);
                      ?>
                        <a href="#"
                            onclick="attachanalogbda(<?php echo $vv_idp; ?>,'<?php echo  $vv_worcenter.'_'.$psswdtkkey;?>','<?php echo $vv_sn; ?>')">
                            <i class="fa fa-paperclip" aria-hidden="true"></i> Attach Files
                        </a> <br>
                        <?php } ?>
        </div>
        <?php
     }
     else
     {
         ?>
        <div class="step <?php echo  $activo_paso4; ?>"> <span class="icon"><i class="fas fa-box"></i> </span> <span
                class="text"><?php echo '['.$vv_step_nro_ary.'] - '.substr($vv_worcenter,3,12); ?> <br>

                <?php if ( $v_enable_attachfile=="Y") { 
              $psswdtkkey = substr( md5(microtime()), 2, 8);
              ?>
                <a href="#"
                    onclick="attachanalogbda(<?php echo $vv_idp; ?>,'<?php echo  $vv_worcenter.'_'.$psswdtkkey;?>','<?php echo $vv_sn; ?>')">
                    <i class="fa fa-paperclip" aria-hidden="true"></i> Attach Files
                </a> <br>
                <?php } ?>
            </span></div>
        <?php  
     }

   
   ////////////////////////FIN WO BURNING
}

  ////////////////////////////////////////////////////////////////////////////////////////
  
function crear_steps_soinfo_FINALINSPEC($vv_worcenter,$vv_sn, $vvv_idwo,$vvv_idwo_nom,$vvv_idwo_ciu , $vvv_idso,$vvv_idso_nom,$vvv_idso_ciu, $vvnombre_a_mostrar_en_dvi, $v_enable_attachfile,$vv_step_nro_ary)
{ 
  global  $_v_steps_WO_ASSY;
  global $_v_steps_WO_PRECHECK ;
  global $_v_steps_SO_ASSY;
  global  $_v_steps_SO_PRECHECK;

  include("db_conect.php"); 

  $psswdtkkey = substr( md5(microtime()), 1, 8);
  $psswdtkkey = substr( md5(microtime()), 2, 8);

  $vv_soworam_tempsurvey3 =$vvv_idso_nom;
  $vv_modelciu_tempsurvey3=$vvv_idso_ciu;

      /////**************3  Quality Survey Final Check ************************************** 
                                              //// sumamos un paso aqui prechech  Precheck
                                              $sqldetectchkeo3="SELECT   status_sn , datetimecheck, so, modelciu FROM public.fas_survey_responses_bysn where idsurvey = 3 and  sn = '".$vv_sn."' and  so = '". $vvv_idso_nom."' and modelciu = '".$vvv_idso_ciu."'
                                              union 
                                              SELECT   status_sn , datetimecheck, so, modelciu  FROM public.fas_survey_responses_bysn where idsurvey = 3 and  sn = '".$vv_sn."' 
                                              order by datetimecheck desc limit 1 ";
                                              $sqldetectchkeo3="SELECT   status_sn , datetimecheck, so, modelciu FROM public.fas_survey_responses_bysn where idsurvey = 3 and  sn = '".$vv_sn."' and  so = '". $vvv_idso_nom."' and modelciu = '".$vvv_idso_ciu."'
                                                         order by datetimecheck desc limit 1 ";
                                     
                                           ////   echo "test:".$sqldetectchkeo3;
                                                $datadetectprecheko3 = $connect->query($sqldetectchkeo3)->fetchAll();
                                                $tieneprecheck=0;
                                                
                                                foreach ($datadetectprecheko3 as $rowchequeo) 
                                                {
                                                  $tieneprecheck=1;
                                                 

                                                }
                                            
                                                $vv_soworam_tempsurvey3 = $vvv_idso_nom ;
                                                $vv_modelciu_tempsurvey3= $vvv_idso_ciu;
                                              ?>
        <?php if ( $tieneprecheck==1) 
                                              {
                                                  ?>
        <div class="stepverde  active">
            <?php
                                              }
                                              else
                                              {
                                                ?>
            <div class="stepverde    ">
                <?php
                                              }
                                              //echo "<br>*-*". $vv_soworam_tempsurvey3;
                                            //  echo "<br>*-*_v_steps_SO_ASSY". $_v_steps_SO_ASSY;

                                             if ( $_v_steps_SO_ASSY=='Y')
                                             {
                                              ?>

                <a href="#"
                    onclick="show_info('Precheckfinalcheck','<?php echo $vv_sn; ?>','<?php echo  $vv_soworam_tempsurvey3; ?>','<?php echo $vv_modelciu_tempsurvey3; ?>','Quality Calibration Precheck',0)">
                 <?php } ?>   <span class="icon"> <i class="fas fa-tasks"></i> </span>
                    <span class="text"> <?php echo '['.$vv_step_nro_ary.'] - '; ?><b>PRECHECK <br>SN
                            [<?php echo $vv_sn; ?>]
                            <br></b></span>
                    <?php
                                               $sqldetectchkeo="SELECT   status_sn  FROM public.fas_survey_responses_bysn where  idsurvey = 3 and  sn  = '".$vv_sn."' and  so = '".$vvv_idso_nom."' and modelciu = '".$vvv_idso_ciu."'
                                                order by datetimecheck desc limit 1 ";
                                                
                                             //  	echo "test:".$sqldetectchkeo;
                                                  $datadetectprecheko = $connect->query($sqldetectchkeo)->fetchAll();
                                                  $fix_cambiotrackin='Y';
                                                  foreach ($datadetectprecheko as $rowchequeo) 
                                                  {
                                                    $fix_cambiotrackin='N';
                                                      if ($rowchequeo['status_sn']=="PASS")
                                                      {
                                                        echo "    <span class='badge bg-success'>Passed</span><br>";
                                                      }
                                                      else
                                                      {
                                                        echo "    <span class='badge bg-danger'>Fail</span><br>";
                                                      }
                                                  }

                                                  if ($fix_cambiotrackin=='Y')
                                                  {
                                                    $sqldetectchkeo="SELECT   status_sn  FROM public.fas_survey_responses_bysn where  idsurvey = 3 and  sn  = '".$vv_sn."' order by datetimecheck desc limit 1 ";
                                                
                                                    
                                                     $datadetectprecheko = $connect->query($sqldetectchkeo)->fetchAll();
                                                     $fix_cambiotrackin='Y';
                                                     foreach ($datadetectprecheko as $rowchequeo) 
                                                     {
                                                      
                                                         if ($rowchequeo['status_sn']=="PASS")
                                                         {
                                                           echo "    <span class='badge bg-success'>Passed</span><br>";
                                                         }
                                                         else
                                                         {
                                                           echo "    <span class='badge bg-danger'>Fail</span><br>";
                                                         }
                                                     }
                                                  }

                                                  if ( $_v_steps_SO_ASSY=='Y')
                                                  {
                                              ?>
                                            </a>
                                            <?php
                                                  }
                                           //       echo "--------------------------------<br>MARCOMM".$_v_steps_SO_ASSY."-mm";
   if ( $_v_steps_SO_ASSY=='N')
   {
    echo "    <span class='badge bg-danger'>SAP::Operation ASSY was not confirmed</span><br>";
   }
                                          
$sqlmaxhistory = " select * from fas_to_sap_xml where v_sn ='".$vv_sn."' and v_workcenetr = '".substr($vv_worcenter,3,22)."' and v_sku = '".$vvv_idso_ciu."' and
runprocessdate in (
select max(runprocessdate) from fas_to_sap_xml where v_sn ='".$vv_sn."' and v_workcenetr = '".substr($vv_worcenter,3,22)
."' and v_sku = '".$vvv_idso_ciu."' )

";
 //  echo "b:::".$sqlmaxhistory;
  $datahist = $connect->query($sqlmaxhistory)->fetchAll();	
  foreach ($datahist as $row2hh) 
  {
    $statemm =$row2hh['v_state'];
      //echo $row2hh['v_state']."<br>".$row2hh['v_state_result'];
      if ($row2hh['v_state']==0)
      {
        $statemm_html= "<span class='badge bg-secondary' title='".$row2hh['v_state_result']."'>SAP::Pending RESORD</span>";
      }
      if ($row2hh['v_state']==1)
      {
        $statemm_html= "<span class='badge bg-warning' title='".$row2hh['v_state_result']."'>SAP::Run</span>";
      }
      if ($row2hh['v_state']==2)
      {
        $statemm_html= "<span class='badge bg-warning' title='".$row2hh['v_state_result']."'>SAP::Pending ACK</span>";
      }
      if ($row2hh['v_state']==3)
      {
        $statemm_html= "<span class='badge bg-danger' title='".$row2hh['v_state_result']."'>SAP::Error </span>";     
      }
      if ($row2hh['v_state']==4)
      {
        $statemm_html= "<span class='badge bg-info' title='".$row2hh['v_state_result']."'>SAP::OK ACK</span>";
      }
      if ($row2hh['v_state']==5)
      {
        $statemm_html= "<span class='badge bg-danger' title='".$row2hh['v_state_result']."'>SAP::Error ACK</span>";
      }
     /// echo "<br>".$row2hh['v_state_result'];


     ////
     $idrunhiss ="";
     $isbypass="N";
     $sqlmaxhistory = "select * from fas_to_sap_xml_history where idruninfo =".$row2hh['idruninfo']." order by  runprocessdate asc";
 //  echo "<br>".$sqlmaxhistory;
     $datahist = $connect->query($sqlmaxhistory)->fetchAll();	
     foreach ($datahist as $row2hh) 
     {
           $idrunhiss = $row2hh['idruninfoack'];
           $msjhistory= $row2hh['state_result'];
       //  } 
           if ( $idrunhiss =="")
           {

           }
           else
           {
             //// Buscamos el ACK del ultRun
             $tooltipamostrar ="";
               $sqlackresult = "select v_string, POSITION('is already being processed by' in v_string) as isbypass, POSITION('Characteristic with confirmation number' in v_string) as isbypass2  from fas_sap_filesxml_attribute where idruninfo =".$idrunhiss." and idattributeord in (56,57,59) ";
            ///   echo $sqlackresult;
               $dataack = $connect->query($sqlackresult)->fetchAll();	
               foreach ($dataack as $rowackm) 
               {
                 
                   if ($rowackm['v_string'] <> '')
                   {
                       $tooltipamostrar =   $tooltipamostrar.$rowackm['v_string']."\r\n";
                       if ($rowackm['isbypass'] > 0 || $rowackm['isbypass2'] > 0 )
                       {
                         $isbypass="Y";
                       }
                   }
                   
               } 
   
             }

     }

     if ($isbypass=="Y")
     {
       echo "<span class='badge bg-warning'>ByPass OK</span>";
     }
     else
     {
         echo $statemm_html; 
         
        
     }

     ////
  }  

                                        
                                          if ( $v_enable_attachfile=="Y") {
                                            $psswdtkkey = substr( md5(microtime()), 2, 8);
                                            ?>
                <a href="#"
                    onclick="attachanalogbda(<?php echo $vv_idp; ?>,'<?php echo  'SO_PRECHECK_'.$psswdtkkey;?>','<?php echo $vv_sn; ?>')">
                    <i class="fa fa-paperclip" aria-hidden="true"></i> Attach Files
                </a> <br>
                <?php } ?>
            </div>
            <?php 
                                                
       
                                                  
                                                

}



/////////////////////////////////BBU MMS HP ////////
function crear_steps_wo_BBUMMS_HP ($vv_worcenter,$vv_sn, $vvv_idwo,$vvv_idwo_nom,$vvv_idwo_ciu , $vvv_idso,$vvv_idso_nom,$vvv_idso_ciu, $vvnombre_a_mostrar_en_dvi, $v_enable_attachfile,$vv_step_nro_ary)
 { 
  
  include("db_conect.php"); 

 
 
  $vv_worcenter_show = substr(trim($vv_worcenter),3,10);
  $no_idruninfowo_ENGCAL=0;
  $v_idp = $vvv_idwo;
 
  
 $modelciuwo = $vvv_idwo_ciu;
 $idorderwo = $vvv_idwo;
 $wo_info = $vvv_idso_nom;
 if ($wo_info=="")
 {
  $wo_info = $vvv_idwo_nom;
 }
 $vtempidproduct =  $rowwo['idproduct'];
 

                                               
  $Sql_ifautotest = $connect->prepare("  
   select idscript, fas_outcome_integral.v_boolean::integer as tienecalibration_totalpass, fas_outcome_integral.reference
 from fas_outcome_integral
 inner join ( select reference, v_integer as idscript from fas_outcome_integral 
           where reference in ( select reference from fas_outcome_integral 
                     where reference in (select reference from fas_outcome_integral
                               where v_string ='".$vv_sn."' 
                                ) 
                     and v_string =  '".$wo_info."' 
                      ) 
           and idfasoutcomecat = 0 and idtype= 12 and v_integer in( 53 )
            ) as lossub
 on lossub.reference = fas_outcome_integral.reference
 where fas_outcome_integral.idfasoutcomecat = 0 and 
 fas_outcome_integral.idtype= 13
 
               ");        
               
           
        
  $Sql_ifautotest->execute();
  $_if_auto_test_box_calibration = "N";
  $activo_paso3_totalpass = "";
  $activo_paso3 ="";
  $result_ifautotest = $Sql_ifautotest->fetchAll();	
  foreach ($result_ifautotest as $row_autotest)
  {
 
   if ( $row_autotest['idscript']<> 2)
   {
     $_if_auto_test_box_calibration = "Y";
   }
   
   
   $idruninfowo_ENG = $row_autotest['reference'];
   $no_idruninfowo_ENGCAL=1;
     if ($row_autotest['tienecalibration_totalpass']==1 && $idruninfowo_ENG <>"")
   {
     
       $activo_paso3_totalpass = "<span class='badge bg-success'>Passed</span><br><a href='#' onclick='popuplogdb(".$idruninfowo_ENG.")'  style='color:#f39323;'>View Log <i class='fas fa-eye'> </i></a>";
   
   
   
   }
   if ($rowbuscawo['tienecalibration_totalpass']==0 && $idruninfowo_ENG <>"")
   {
     
       $activo_paso3_totalpass = "<span class='badge bg-danger'>Not Passed</span><br><a href='#' onclick='popuplogdb(".$idruninfowo_ENG.")'  style='color:#f39323;'>View Log <i class='fas fa-eye'></i></a>";
   
   }
 
  }
 
  $nombre_a_mostrar_en_dvi_calib ='Calibration :: SN: '.$vv_sn;
 /////**************************************************** 
 //           echo   "aaaaa".$_if_auto_test_box_calibration;
 if ( $idruninfowo_ENG <>"")
 {
   $activo_paso3 = "active";
   $activo_paso3_totalpass ="";
   $activo_paso3_totalpass = "<span class='badge bg-success'>Passed</span><br><a href='#' onclick='popuplogdb(".$idruninfowo_ENG.")'  style='color:#f39323;'>View Log <i class='fas fa-eye'> </i></a>";
   
 }
 
 /////
 /////Buscamos el tipo de reporte para el SKU
             
  $name_js_report = 'accep_repot_mms_bbu_hp';    
  
 
 if ($idruninfowo_ENG >0)
 {
 ?>
            <div class="step <?php echo  $activo_paso3; ?>">
                <a href="#"
                    onclick="show_info('<?php echo $name_js_report;?>','<?php echo $vv_sn; ?>','<?php echo $idorderwo; ?>','<?php echo $nombre_a_mostrar_en_dvi_calib; ?>','<?php echo $idruninfowo_ENG; ?>',0)">
                    <span class="icon">
                        <i class="fas fa-box"></i> </span> <span class="text">
                        <?php echo  '['.$vv_step_nro_ary.'] - '; ?><b> FINALCAL<br>
                    </span></b></a>
                <?php echo $activo_paso3_totalpass;?>

                <?php
 //////
}
else
{
  ?>
                <div class="step ">

                    <span class="icon">
                        <i class="fas fa-box"></i> </span> <span class="text">
                        <?php echo  '['.$vv_step_nro_ary.'] - '; ?><b> FINALCAL MMS [BBU] <br>
                            <?php echo $activo_paso3_totalpass; ?></span>
                    </a></b>

                    <?php
}
           
       
             
           $sqlmaxhistory = " select * from fas_to_sap_xml where v_sn ='".$vv_sn."' and v_workcenetr = '".substr($vv_worcenter,3,22)."'  and v_sku = '".$modelciuwo."' and
           runprocessdate in (
     select max(runprocessdate) from fas_to_sap_xml where v_sn ='".$vv_sn."' and v_workcenetr = '".substr($vv_worcenter,3,22)."' and v_sku = '".$modelciuwo."' )
 
     ";
        ///   echo $sqlmaxhistory;
             $datahist = $connect->query($sqlmaxhistory)->fetchAll();	
             foreach ($datahist as $row2hh) 
             {
                 //echo $row2hh['v_state']."<br>".$row2hh['v_state_result'];
                 if ($row2hh['v_state']==0)
                 {
                   echo "<br><span class='badge bg-secondary' title='".$row2hh['v_state_result']."'>SAP::Pending RESORD</span>";
                 }
                 if ($row2hh['v_state']==1)
                 {
                   echo "<br><span class='badge bg-warning' title='".$row2hh['v_state_result']."'>SAP::Run</span>";
                 }
                 if ($row2hh['v_state']==2)
                 {
                   echo "<br><span class='badge bg-warning' title='".$row2hh['v_state_result']."'>SAP::Pending ACK</span>";
                 }
                 if ($row2hh['v_state']==3)
                 {
                   echo "<br><span class='badge bg-danger' title='".$row2hh['v_state_result']."'>SAP::Error </span>";
                 }
                 if ($row2hh['v_state']==4)
                 {
                     echo "<br><span class='badge bg-info' title='".$row2hh['v_state_result']."'>SAP::OK ACK</span>";
                 }
                 if ($row2hh['v_state']==5)
                 {
                     echo "<br><span class='badge bg-danger' title='".$row2hh['v_state_result']."'>SAP::Error ACK</span>";
                 }
                 /// echo "<br>".$row2hh['v_state_result'];
             }  
         
      ///este div cierra ambos casos OJO       
     ?>
                </div>
                <?php
     ///////////////////////////////////////////////////////

  }
/////////////////////////////////FIN BBU  MMS HP ////////
/////////////////////////////////BBU MMS ////////
function crear_steps_wo_BBUMMS ($vv_worcenter,$vv_sn, $vvv_idwo,$vvv_idwo_nom,$vvv_idwo_ciu , $vvv_idso,$vvv_idso_nom,$vvv_idso_ciu, $vvnombre_a_mostrar_en_dvi, $v_enable_attachfile,$vv_step_nro_ary)
 { 
  
  include("db_conect.php"); 

  $vv_worcenter_show = substr(trim($vv_worcenter),3,10);
  $no_idruninfowo_ENGCAL=0;
  $v_idp = $vvv_idwo;
 
  
  
 $modelciuwo = $vvv_idwo_ciu;
 $idorderwo = $vvv_idwo;
 $wo_info = $vvv_idwo_nom;
 $vtempidproduct =  $rowwo['idproduct'];
 
 
  
                                               
  $Sql_ifautotest = $connect->prepare("  
   select idscript, fas_outcome_integral.v_boolean::integer as tienecalibration_totalpass, fas_outcome_integral.reference
 from fas_outcome_integral
 inner join ( select reference, v_integer as idscript from fas_outcome_integral 
           where reference in ( select reference from fas_outcome_integral 
                     where reference in (select reference from fas_outcome_integral
                               where v_string ='".$vv_sn."' 
                                ) 
                     and v_string =  '".$wo_info."'
                      ) 
           and idfasoutcomecat = 0 and idtype= 12 and v_integer in( 54 )
            ) as lossub
 on lossub.reference = fas_outcome_integral.reference
 where fas_outcome_integral.idfasoutcomecat = 0 and 
 fas_outcome_integral.idtype= 13
 
               ");        
               
        
  $Sql_ifautotest->execute();
  $_if_auto_test_box_calibration = "N";
  $activo_paso3_totalpass = "";
  $activo_paso3 ="";
  $result_ifautotest = $Sql_ifautotest->fetchAll();	
  foreach ($result_ifautotest as $row_autotest)
  {
   //echo "<br>aaaaaaaaaaaaaa".$row_autotest['idscript'];
   if ( $row_autotest['idscript']<> 2)
   {
     $_if_auto_test_box_calibration = "Y";
   }
   
   $idruninfowo_ENG = $row_autotest['reference'];
   $no_idruninfowo_ENGCAL=1;
     if ($row_autotest['tienecalibration_totalpass']==1 && $idruninfowo_ENG <>"")
   {
     
       $activo_paso3_totalpass = "<span class='badge bg-success'>Passed</span><br><a href='#' onclick='popuplogdb(".$idruninfowo_ENG.")'  style='color:#f39323;'>View Log <i class='fas fa-eye'> </i></a>";
   
   
   
   }
   if ($rowbuscawo['tienecalibration_totalpass']==0 && $idruninfowo_ENG <>"")
   {
     
       $activo_paso3_totalpass = "<span class='badge bg-danger'>Not Passed</span><br><a href='#' onclick='popuplogdb(".$idruninfowo_ENG.")'  style='color:#f39323;'>View Log <i class='fas fa-eye'></i></a>";
   
   }
 
  }
 
  $nombre_a_mostrar_en_dvi_calib ='Calibration :: SN: '.$vv_sn;
 /////**************************************************** 
 //           echo   "aaaaa".$_if_auto_test_box_calibration;
 if ( $idruninfowo_ENG <>"")
 {
   $activo_paso3 = "active";
   $activo_paso3_totalpass ="";
   $activo_paso3_totalpass = "<span class='badge bg-success'>Passed</span><br><a href='#' onclick='popuplogdb(".$idruninfowo_ENG.")'  style='color:#f39323;'>View Log <i class='fas fa-eye'> </i></a>";
   
 }
 
 /////
 /////Buscamos el tipo de reporte para el SKU
             
  $name_js_report = 'accep_repot_mms_bbu';    
  
 
 if ($idruninfowo_ENG >0)
 {
 ?>
                <div class="step <?php echo  $activo_paso3; ?>">
                    <a href="#"
                        onclick="show_info('<?php echo $name_js_report;?>','<?php echo $vv_sn; ?>','<?php echo $idorderwo; ?>','<?php echo $nombre_a_mostrar_en_dvi_calib; ?>','<?php echo $idruninfowo_ENG; ?>',0)">
                        <span class="icon">
                            <i class="fas fa-box"></i> </span> <span class="text">
                            <?php echo  '['.$vv_step_nro_ary.'] - '; ?><b>FINALCAL MMS [BBU] <br>
                        </span></b></a>
                    <?php echo $activo_paso3_totalpass;?>

                    <?php
 //////
}
else
{
  ?>
                    <div class="step ">

                        <span class="icon">
                            <i class="fas fa-box"></i> </span> <span class="text">
                            <?php echo  '['.$vv_step_nro_ary.'] - '; ?><b> FINALCAL MMS [BBU] <br>
                                <?php echo $activo_paso3_totalpass; ?></span>
                        </a></b>

                        <?php
}
           
       
             
           $sqlmaxhistory = " select * from fas_to_sap_xml where v_sn ='".$vv_sn."' and v_workcenetr = 'FINALCAL'  and v_sku = '".$modelciuwo."' and
           runprocessdate in (
     select max(runprocessdate) from fas_to_sap_xml where v_sn ='".$vv_sn."' and v_workcenetr = 'FINALCAL' and v_sku = '".$modelciuwo."' )
 
     ";
        ///   echo $sqlmaxhistory;
             $datahist = $connect->query($sqlmaxhistory)->fetchAll();	
             foreach ($datahist as $row2hh) 
             {
                 //echo $row2hh['v_state']."<br>".$row2hh['v_state_result'];
                 if ($row2hh['v_state']==0)
                 {
                   echo "<br><span class='badge bg-secondary' title='".$row2hh['v_state_result']."'>SAP::Pending RESORD</span>";
                 }
                 if ($row2hh['v_state']==1)
                 {
                   echo "<br><span class='badge bg-warning' title='".$row2hh['v_state_result']."'>SAP::Run</span>";
                 }
                 if ($row2hh['v_state']==2)
                 {
                   echo "<br><span class='badge bg-warning' title='".$row2hh['v_state_result']."'>SAP::Pending ACK</span>";
                 }
                 if ($row2hh['v_state']==3)
                 {
                   echo "<br><span class='badge bg-danger' title='".$row2hh['v_state_result']."'>SAP::Error </span>";
                 }
                 if ($row2hh['v_state']==4)
                 {
                     echo "<br><span class='badge bg-info' title='".$row2hh['v_state_result']."'>SAP::OK ACK</span>";
                 }
                 if ($row2hh['v_state']==5)
                 {
                     echo "<br><span class='badge bg-danger' title='".$row2hh['v_state_result']."'>SAP::Error ACK</span>";
                 }
                 /// echo "<br>".$row2hh['v_state_result'];
             }  
         
      ///este div cierra ambos casos OJO       
     ?>
                    </div>
                    <?php
     ///////////////////////////////////////////////////////

  }
/////////////////////////////////FIN BBU  MMS ////////

/////////////////////////////////BBU MMS RF ////////
function crear_steps_wo_BBUMMSRF ($vv_worcenter,$vv_sn, $vvv_idwo,$vvv_idwo_nom,$vvv_idwo_ciu , $vvv_idso,$vvv_idso_nom,$vvv_idso_ciu, $vvnombre_a_mostrar_en_dvi, $v_enable_attachfile,$vv_step_nro_ary)
 { 
  
  
  include("db_conect.php"); 

  $vv_worcenter_show = substr(trim($vv_worcenter),3,10);
  $no_idruninfowo_ENGCAL=0;
  $v_idp = $vvv_idwo;
 
  
  
 $modelciuwo = $vvv_idwo_ciu;
 $idorderwo = $vvv_idwo;
 $wo_info = $vvv_idwo_nom;
 $vtempidproduct =  $rowwo['idproduct'];
 
 
  
                                               
  $Sql_ifautotest = $connect->prepare("  
   select idscript, fas_outcome_integral.v_boolean::integer as tienecalibration_totalpass, fas_outcome_integral.reference
 from fas_outcome_integral
 inner join ( select reference, v_integer as idscript from fas_outcome_integral 
           where reference in ( select reference from fas_outcome_integral 
                     where reference in (select reference from fas_outcome_integral
                               where v_string ='".$vv_sn."' 
                                ) 
                     and v_string =  '".$wo_info."'
                      ) 
           and idfasoutcomecat = 0 and idtype= 12 and v_integer in( 27 )
            ) as lossub
 on lossub.reference = fas_outcome_integral.reference
 where fas_outcome_integral.idfasoutcomecat = 0 and 
 fas_outcome_integral.idtype= 13
 
               ");        
               
        
  $Sql_ifautotest->execute();
  $_if_auto_test_box_calibration = "N";
  $activo_paso3_totalpass = "";
  $activo_paso3 ="";
  $result_ifautotest = $Sql_ifautotest->fetchAll();	
  foreach ($result_ifautotest as $row_autotest)
  {
   //echo "<br>aaaaaaaaaaaaaa".$row_autotest['idscript'];
   if ( $row_autotest['idscript']<> 2)
   {
     $_if_auto_test_box_calibration = "Y";
   }
   
   $idruninfowo_ENG = $row_autotest['reference'];
   $no_idruninfowo_ENGCAL=1;
     if ($row_autotest['tienecalibration_totalpass']==1 && $idruninfowo_ENG <>"")
   {
     
       $activo_paso3_totalpass = "<span class='badge bg-success'>Passed</span><br><a href='#' onclick='popuplogdb(".$idruninfowo_ENG.")'  style='color:#f39323;'>View Log <i class='fas fa-eye'> </i></a>";
   
   
   
   }
   if ($rowbuscawo['tienecalibration_totalpass']==0 && $idruninfowo_ENG <>"")
   {
     
       $activo_paso3_totalpass = "<span class='badge bg-danger'>Not Passed</span><br><a href='#' onclick='popuplogdb(".$idruninfowo_ENG.")'  style='color:#f39323;'>View Log <i class='fas fa-eye'></i></a>";
   
   }
 
  }
 
  $nombre_a_mostrar_en_dvi_calib ='Calibration :: SN: '.$vv_sn;
 /////**************************************************** 
 //           echo   "aaaaa".$_if_auto_test_box_calibration;
 if ( $idruninfowo_ENG <>"")
 {
   $activo_paso3 = "active";
   $activo_paso3_totalpass ="";
   $activo_paso3_totalpass = "<span class='badge bg-success'>Passed</span><br><a href='#' onclick='popuplogdb(".$idruninfowo_ENG.")'  style='color:#f39323;'>View Log <i class='fas fa-eye'> </i></a>";
   
 }
 
 /////
 /////Buscamos el tipo de reporte para el SKU
             
  $name_js_report = 'accept_bburepot_mms_bbu_rf';    
  
  
 
 if ($idruninfowo_ENG >0)
 {
 ?>
                    <div class="step <?php echo  $activo_paso3; ?>">
                        <a href="#"
                            onclick="show_info('<?php echo $name_js_report;?>','<?php echo $vv_sn; ?>','<?php echo $idorderwo; ?>','<?php echo $nombre_a_mostrar_en_dvi_calib; ?>','<?php echo $idruninfowo_ENG; ?>',0)">
                            <span class="icon">
                                <i class="fas fa-box"></i> </span> <span
                                class="text"><?php echo '['.$vv_step_nro_ary.'] - '; ?><b>FINALCAL MMS [RF] <br>
                                    <?php echo $activo_paso3_totalpass; ?></span></a></b>
                        <?php
 //////
}
else
{
  ?>
                        <div class="step ">

                            <span class="icon">
                                <i class="fas fa-box"></i> </span> <span class="text">
                                <?php echo '['.$vv_step_nro_ary.'] - '; ?><b> FINALCAL MMS [RF] <br>
                                </b></span>

                            </a>
                        </div>

                        <?php
}
           
       
             
           $sqlmaxhistory = " select * from fas_to_sap_xml where v_sn ='".$vv_sn."' and v_workcenetr = 'FINALCAL'  and v_sku = '".$modelciuwo."' and
           runprocessdate in (
     select max(runprocessdate) from fas_to_sap_xml where v_sn ='".$vv_sn."' and v_workcenetr = 'FINALCAL' and v_sku = '".$modelciuwo."' )
 
     ";
        ///   echo $sqlmaxhistory;
             $datahist = $connect->query($sqlmaxhistory)->fetchAll();	
             foreach ($datahist as $row2hh) 
             {
                 //echo $row2hh['v_state']."<br>".$row2hh['v_state_result'];
                 if ($row2hh['v_state']==0)
                 {
                   echo "<br><span class='badge bg-secondary' title='".$row2hh['v_state_result']."'>SAP::Pending RESORD</span>";
                 }
                 if ($row2hh['v_state']==1)
                 {
                   echo "<br><span class='badge bg-warning' title='".$row2hh['v_state_result']."'>SAP::Run</span>";
                 }
                 if ($row2hh['v_state']==2)
                 {
                   echo "<br><span class='badge bg-warning' title='".$row2hh['v_state_result']."'>SAP::Pending ACK</span>";
                 }
                 if ($row2hh['v_state']==3)
                 {
                   echo "<br><span class='badge bg-danger' title='".$row2hh['v_state_result']."'>SAP::Error </span>";
                 }
                 if ($row2hh['v_state']==4)
                 {
                     echo "<br><span class='badge bg-info' title='".$row2hh['v_state_result']."'>SAP::OK ACK</span>";
                 }
                 if ($row2hh['v_state']==5)
                 {
                     echo "<br><span class='badge bg-danger' title='".$row2hh['v_state_result']."'>SAP::Error ACK</span>";
                 }
                 /// echo "<br>".$row2hh['v_state_result'];
             }  
         
      ///este div cierra ambos casos OJO       
     ?>
                    </div>
                    <?php
     ///////////////////////////////////////////////////////

  }
/////////////////////////////////FIN BBU  MMS RF ////////

   /////////////////////////////////UL TEST//
   function crear_steps_woinfo_ULTEST ($vv_worcenter,$vv_sn, $vvv_idwo,$vvv_idwo_nom,$vvv_idwo_ciu , $vvv_idso,$vvv_idso_nom,$vvv_idso_ciu, $vvnombre_a_mostrar_en_dvi, $v_enable_attachfile,$vv_step_nro_ary)
 { 
     include("db_conect.php"); 

     $psswdtkkey = substr( md5(microtime()), 1, 8);
     $psswdtkkey = substr( md5(microtime()), 2, 8);
              //echo "<br>Averrr--> ", substr($vv_worcenter,0,2);

      $modelciuwo = $vvv_idwo_ciu;
      $idorderwo = $vvv_idwo;
      $wo_info =$vvv_idwo_nom;
    
          /////**************PRE CHEQUEO************************************** 
                 //// sumamos un paso aqui prechech  Precheck
                 $sqldetectchkeo="SELECT   status_sn  FROM public.fas_survey_responses_bysn 
                 where  idsurvey = 2 and sn = '".$vv_sn."' and  so = '". $wo_info ."' and modelciu = '".$modelciuwo."'
                 order by datetimecheck desc limit 1 ";

          ///     	echo "<br>test:".$sqldetectchkeo;
                 $datadetectprecheko = $connect->query($sqldetectchkeo)->fetchAll();
                 $tieneprecheck=0;

                 foreach ($datadetectprecheko as $rowchequeo) 
                 {
                 $tieneprecheck=1;
                 }
                 ?>
                    <?php if ( $tieneprecheck==1) 
                 {
                 ?>
                    <div class="stepverde  active">
                        <?php
                 }
                 else
                 {
                 ?>
                        <div class="step  ">
                            <?php
                 }
             //    echo $vv_worcenter."--".$vv_sn."--".$vv_idp."--".$vvnombre_a_mostrar_en_dvi."--".$vv_soworam."--".$vv_modelciu."--<br>";
                 ?>

                            <a href="#"
                                onclick="show_info_stepidsap('Precheckultest','<?php echo $vv_sn; ?>','<?php echo  $wo_info; ?>','<?php echo $modelciuwo; ?>','Quality Calibration Precheck','<?php echo $vv_worcenter; ?>','<?php echo $vv_step_nro_ary; ?>' )">
                                <span class="icon"> <i class="fas fa-tasks"></i> </span>
                                <span class="text">
                                    <b><?php echo  '['.$vv_step_nro_ary.'] - '.substr($vv_worcenter,3,12);?>
                                        <br>SN
                                        [<?php echo $vv_sn; ?>]
                                        <br></b>

                                    <?php 
             ///   echo "HOLAGOLA".$v_enable_attachfile;
                 if ( $v_enable_attachfile=="Y") {
                  $psswdtkkey = substr( md5(microtime()), 2, 8);
                  ?>
                                    <a href="#"
                                        onclick="attachanalogbda(<?php echo $vv_idp; ?>,'<?php echo  $vv_worcenter.'_'.$psswdtkkey;?>','<?php echo $vv_sn; ?>')">
                                        <i class="fa fa-paperclip" aria-hidden="true"></i> Attach Files
                                    </a> <br>
                                    <?php } ?>
                                </span>
                                <?php
                 $sqldetectchkeo="SELECT   status_sn  FROM public.fas_survey_responses_bysn where idsurvey = 2 and  sn = '".$vv_sn."' and  so = '". $wo_info."' and modelciu = '".$modelciuwo."'
                 order by datetimecheck desc limit 1 ";

              //  	echo "test:".$sqldetectchkeo;
                 $datadetectprecheko = $connect->query($sqldetectchkeo)->fetchAll();
                 foreach ($datadetectprecheko as $rowchequeo) 
                 {
                     if ($rowchequeo['status_sn']=="PASS")
                     {
                         echo "    <span class='badge bg-success'>FAS::Passed</span><br>";
                     }
                     else
                     {
                       echo "    <span class='badge bg-danger'>FAS::Fail</span><br>";
                     }
                 }


                 
                 ?>
                                <?php
            
            
            $sqlmaxhistory = " select * from fas_to_sap_xml where v_sn ='".$vv_sn."' and v_workcenetr = '".substr($vv_worcenter,3,22)."'  and v_sku = '".$modelciuwo."' and
            runprocessdate in (
      select max(runprocessdate) from fas_to_sap_xml where v_sn ='".$vv_sn."' and v_workcenetr = '".substr($vv_worcenter,3,22)."' and v_sku = '".$modelciuwo."' )

      ";
          ///   echo $sqlmaxhistory;
              $datahist = $connect->query($sqlmaxhistory)->fetchAll();	
              foreach ($datahist as $row2hh) 
              {
                  //echo $row2hh['v_state']."<br>".$row2hh['v_state_result'];
                  if ($row2hh['v_state']==0)
                  {
                    echo "<span class='badge bg-secondary' title='".$row2hh['v_state_result']."'>SAP::Pending RESORD</span>";
                  }
                  if ($row2hh['v_state']==1)
                  {
                    echo "<span class='badge bg-warning' title='".$row2hh['v_state_result']."'>SAP::Run</span>";
                  }
                  if ($row2hh['v_state']==2)
                  {
                    echo "<span class='badge bg-warning' title='".$row2hh['v_state_result']."'>SAP::Pending ACK</span>";
                  }
                  if ($row2hh['v_state']==3)
                  {
                    echo "<span class='badge bg-danger' title='".$row2hh['v_state_result']."'>SAP::Error </span>";
                  }
                  if ($row2hh['v_state']==4)
                  {
                      echo "<span class='badge bg-info' title='".$row2hh['v_state_result']."'>SAP::OK ACK</span>";
                  }
                  if ($row2hh['v_state']==5)
                  {
                      echo "<span class='badge bg-danger' title='".$row2hh['v_state_result']."'>SAP::Error ACK</span>";
                  }
                  /// echo "<br>".$row2hh['v_state_result'];
              }  
            ?>

                        </div>
                        </a>
                        <?php
          
 
   }


   ///////////////////////////////////PRECHECK


   function crear_steps_woinfo_PRECHECK ($vv_worcenter,$vv_sn, $vvv_idwo,$vvv_idwo_nom,$vvv_idwo_ciu , $vvv_idso,$vvv_idso_nom,$vvv_idso_ciu, $vvnombre_a_mostrar_en_dvi, $v_enable_attachfile,$vv_step_nro_ary)
 { 
  global  $_v_steps_WO_ASSY;
  global $_v_steps_WO_PRECHECK ;
  global $_v_steps_SO_ASSY;
  global  $_v_steps_SO_PRECHECK;
  
     include("db_conect.php"); 

        $psswdtkkey = substr( md5(microtime()), 2, 8);
        $psswdtkkey = substr( md5(microtime()), 2, 8);
     //   echo(microtime());
        ///     echo "<br>Averrr--> ".$psswdtkkey;

      $modelciuwo = $vvv_idwo_ciu;
      $idorderwo = $vvv_idwo;
      $wo_info =$vvv_idwo_nom;
    
          /////**************PRE CHEQUEO************************************** 
                 //// sumamos un paso aqui prechech  Precheck
                 $sqldetectchkeo="SELECT   status_sn  FROM public.fas_survey_responses_bysn 
                 where  idsurvey = 1 and sn = '".$vv_sn."' and  so = '". $wo_info ."' and modelciu = '".$modelciuwo."'
                 order by datetimecheck desc limit 1 ";

             
                 $datadetectprecheko = $connect->query($sqldetectchkeo)->fetchAll();
                 $tieneprecheck=0;

                 foreach ($datadetectprecheko as $rowchequeo) 
                 {
                 $tieneprecheck=1;
                 }
                 ?>
                        <?php if ( $tieneprecheck==1) 
                 {
                 ?>
                        <div class="stepverde  active">
                            <?php
                 }
                 else
                 {
                 ?>
                            <div class="step  ">
                                <?php
                 }


              ////CHEQUEAMOSSS STEP ANTERIORES CONFIRMADOS.
              $steps_020="NOCONFIRM";
              $sqlmaxhistory = " select * from fas_to_sap_xml where v_sn ='".$vv_sn."' and v_workcenetr = 'ASSY'  and v_sku = '".$modelciuwo."' and v_state in(4,8)  ";
             /// echo $sqlmaxhistory;
                $datahiststepsant = $connect->query($sqlmaxhistory)->fetchAll();	
                foreach ($datahiststepsant as $row2ant) 
                {
                 // $steps_020="CONFIRM";
                }


             //    echo $vv_worcenter."--".$vv_sn."--".$vv_idp."--".$vvnombre_a_mostrar_en_dvi."--".$vv_soworam."--".$vv_modelciu."--<br>";
           //    echo "<br>v_steps_WO_ASSY".$_v_steps_WO_ASSY;
                    if ($_v_steps_WO_ASSY=="Y")
                    {
               ?>

                                <a href="#"
                                    onclick="show_info_stepidsap('Precheck','<?php echo $vv_sn; ?>','<?php echo  $wo_info; ?>','<?php echo $modelciuwo; ?>','Quality Calibration Precheck','<?php echo $vv_worcenter; ?>','<?php echo $vv_step_nro_ary; ?>')">
                    <?php } ?>              
                                    <span class="icon"> <i class="fas fa-tasks"></i> </span>
                                    <span class="text">
                                        <b><?php echo  '['.$vv_step_nro_ary.'] - '.substr($vv_worcenter,3,12);?>
                                            <br>SN [<?php echo $vv_sn; ?>]
                                            <br></b>

                                        <?php 
             ///   echo "HOLAGOLA".$v_enable_attachfile;  
                 if ( $v_enable_attachfile=="Y") { 
                  $psswdtkkey = substr( md5(microtime()), 2, 8);
                  ?>
                                        <a href="#"
                                            onclick="attachanalogbda(<?php echo $vvv_idwo; ?>,'<?php echo  $vv_worcenter.'_'.$psswdtkkey;?>','<?php echo $vv_sn; ?>')">
                                            <i class="fa fa-paperclip" aria-hidden="true"></i> Attach Files
                                        </a> <br>
                                        <?php } ?>
                                    </span>
                                    <?php
                 $sqldetectchkeo="SELECT   status_sn  FROM public.fas_survey_responses_bysn where idsurvey = 1 and  sn = '".$vv_sn."' and  so = '". $wo_info."' and modelciu = '".$modelciuwo."'
                 order by datetimecheck desc limit 1 ";

              //  	echo "test:".$sqldetectchkeo;
                 $datadetectprecheko = $connect->query($sqldetectchkeo)->fetchAll();
                 foreach ($datadetectprecheko as $rowchequeo) 
                 {
                     if ($rowchequeo['status_sn']=="PASS")
                     {
                         echo "    <span class='badge bg-success'>FAS::Passed</span><br>";
                     }
                     else
                     {
                       echo "    <span class='badge bg-danger'>FAS::Fail</span><br>";
                     }
                 }

                 if ( $_v_steps_WO_ASSY=='N')
                 {
                  echo "    <span class='badge bg-danger'>SAP::Operation ASSY was not confirmed</span><br>";
                 }
                 
                 ?>
                                    <?php
            
            
            $sqlmaxhistory = " select * from fas_to_sap_xml where v_sn ='".$vv_sn."' and v_workcenetr = '".substr($vv_worcenter,3,22)."'  and v_sku = '".$modelciuwo."' and
            runprocessdate in (
      select max(runprocessdate) from fas_to_sap_xml where v_sn ='".$vv_sn."' and v_workcenetr = '".substr($vv_worcenter,3,22)."' and v_sku = '".$modelciuwo."' )

      ";
          ///   echo $sqlmaxhistory;
              $datahist = $connect->query($sqlmaxhistory)->fetchAll();	
              foreach ($datahist as $row2hh) 
              {

                  $sqlackresult = "select v_string, POSITION('is already being processed by' in v_string) as isbypass, POSITION('Characteristic with confirmation number' in v_string) as isbypass2  from fas_sap_filesxml_attribute where idruninfo in( select max(idruninfoack) from fas_to_sap_xml_history where idruninfo in( ".$row2hh['idruninfo'].") ) and idattributeord in (56,57,59) ";
                 //    echo "<br>".$sqlackresult;
                    $dataack = $connect->query($sqlackresult)->fetchAll();	
                    foreach ($dataack as $rowackm) 
                    {
                      
                        if ($rowackm['v_string'] <> '')
                        {
                            $tooltipamostrar =   $tooltipamostrar.$rowackm['v_string']."\r\n";
                            if ($rowackm['isbypass'] > 0 || $rowackm['isbypass2'] > 0 )
                            {
                              $isbypass="Y";
                            }
                        }
                        
                    } 

                    if ($isbypass=="Y" && $statemm <> 4)
                    {
                      echo "<span class='badge bg-warning'>ByPass OK</span>";
                    }
                    else
                    {


                        //echo $row2hh['v_state']."<br>".$row2hh['v_state_result'];
                        if ($row2hh['v_state']==0)
                        {
                          echo "<span class='badge bg-secondary' title='".$row2hh['v_state_result']."'>SAP::Pending RESORD</span>";
                        }
                        if ($row2hh['v_state']==1)
                        {
                          echo "<span class='badge bg-warning' title='".$row2hh['v_state_result']."'>SAP::Run</span>";
                        }
                        if ($row2hh['v_state']==2)
                        {
                          echo "<span class='badge bg-warning' title='".$row2hh['v_state_result']."'>SAP::Pending ACK</span>";
                        }
                        if ($row2hh['v_state']==3)
                        {
                          echo "<span class='badge bg-danger' title='".$row2hh['v_state_result']."'>SAP::Error </span>";
                        }
                        if ($row2hh['v_state']==4)
                        {
                            echo "<span class='badge bg-info' title='".$row2hh['v_state_result']."'>SAP::OK ACK</span>";
                        }
                        if ($row2hh['v_state']==5)
                        {
                            echo "<span class='badge bg-danger' title='".$row2hh['v_state_result']."'>SAP::Error ACK</span>";
                        }
                        /// echo "<br>".$row2hh['v_state_result'];
                      }
              }  
            ?>

                            </div>
                            <?php  if ($_v_steps_WO_ASSY=="Y")
                    { ?>
                            </a>
                            <?php } ?>
                            <?php
          
 
   }
   ///////////////////////////////////
  ///////////////////////////////////
  function crear_steps_woinfo_2NDASSY($vv_worcenter,$vv_sn, $vv_idp,$vvnombre_a_mostrar_en_dvi,$vv_soworam,$vv_modelciu, $vtemp, $v_enable_attachfile,$vv_step_nro_ary )
  { 
    include("db_conect.php"); 

    $modelciuwo = $vv_modelciu;
    $idorderwo =  $vv_idp;
    $wo_info = $vv_soworam;

    $psswdtkkey = substr( md5(microtime()), 1, 8);
    $psswdtkkey = substr( md5(microtime()), 2, 8);

    ?>

                            <div class="stepazul   active">

                                <a href="#"
                                    onclick="show_info('orderinfo','<?php echo $vv_sn; ?>','<?php echo $vv_idp; ?>','<?php echo $vvnombre_a_mostrar_en_dvi; ?>',0,0)">

                                    <span class="icon"> <i class="fa fa-check"></i> </span>
                                    <span class="text text-center">


                                        <b> SO: [<?php echo $vv_soworam; ?>]<br>CIU: [<?php echo  $vv_modelciu; ?>]</b>
                                        <br><b> SN Generated: [<?php echo $vv_sn; ?>]</b><br>
                                </a>
                                <p class='  text-center'>
                                    <a href="#"
                                        onclick="Call_printlabel('<?php echo  $vv_modelciu; ?>', '<?php echo $vv_sn; ?>' ,'<?php echo  $vv_idp ; ?>')"><i
                                            class="fas fa-print"></i> - Print Label
                                    </a>

                                    <?php
  //echo "HOLA_ABC".$v_enable_attachfile;
  if ( $v_enable_attachfile=="Y") {
    
    $psswdtkkey = substr( md5(microtime()), 2, 8);
    ?><br>
                                    <a href="#"
                                        onclick="attachanalogbda(<?php echo $vv_idp; ?>,'<?php echo  'so_SO-INFO'.'_'.$psswdtkkey;?>','<?php echo $vv_sn; ?>')">
                                        <i class="fa fa-paperclip" aria-hidden="true"></i> Attach Files
                                    </a>
                                    <?php } ?>
                                    <?php
                                                  if( $_SESSION["g"] =='develop' || 'Productionadmin' ==  $_SESSION["g"]|| 'Quality' ==  $_SESSION["g"] || $_SESSION["a"]==96 )
                                                  {
                                                    ?>
                                    <br> <a href='unlinksndevelop.php?snmm=<?php echo $rowbuscawo['wo_serialnumber'];?>'
                                        target='_blank'> <span class='text-danger'>Unlink sn </span> </a>
                                    <?php
                                                  }
                                                 
                                                  ?>
                                    <br> <br>
                                    <br>

                                    <br>
                                </p>
                                </span>

                            </div>
                            <?php
   
        $sqldetectchkeopicki="SELECT distinct   orders_sn_components.wo_serialnumber 
       FROM public.orders_sn_components_xml as orders_sn_components 
    
     inner join orders_sn
     on orders_sn.idorders = orders_sn_components.idorders and 
     orders_sn.idproduct = orders_sn_components.idproduct and
     orders_sn.so_soft_external = '".$vv_soworam."'  where orders_sn_components.wo_serialnumber= '".$vv_sn."'";
       
     ///  	echo "test:".$sqldetectchkeopicki;
         $datapicking = $connect->query($sqldetectchkeopicki)->fetchAll();
         $tienepicking=0;
         
         foreach ($datapicking as $rowchequeo) 
         {
           $tienepicking=1;
         }
         ?>
                            <?php if ( $tienepicking==1) 
         {
           ?>
                            <div class="stepverde  active">
                                <?php
         }
         else
         {
         ?>
                                <div class="step  ">
                                    <?php
         }
         $psswdtkkey = substr( md5(microtime()), 2, 8);
         ?>

                                    <a href="#"
                                        onclick="show_info('picking','<?php echo $vv_sn; ?>','<?php echo $wo_info; ?>','<?php echo $modelciuwo; ?>','Quality Calibration Precheck',   '<?php echo $vv_worcenter ; ?>'  )">
                                        <span class="icon"> <i class="fas fa-tasks"></i> </span>
                                        <span class="text">
                                            <b><?php echo  '['.$vv_step_nro_ary.'] - '.substr($vv_worcenter,3,12);  ?>
                                                <br>SN
                                                [<?php echo $vv_sn; ?>] <br></b></span>
                                        <?php if ( $v_enable_attachfile=="Y") { ?>
                                        <a href="#"
                                            onclick="attachanalogbda(<?php echo $vv_idp; ?>,'<?php echo  $vv_worcenter.'_'.$psswdtkkey;?>','<?php echo $vv_sn; ?>')">
                                            <i class="fa fa-paperclip" aria-hidden="true"></i> Attach Files
                                        </a>
                                        <?php } ?>
                                        <?php
       $sqlmaxhistory = " select * from fas_to_sap_xml where v_sn ='".$vv_sn."' and v_workcenetr = '".substr($vv_worcenter,3,22)."' and
       runinfodate in (
select max(runinfodate) from fas_to_sap_xml where v_sn ='".$vv_sn."' and v_workcenetr = '".substr($vv_worcenter,3,22)."')

";
  ///     echo $sqlmaxhistory;
         $datahist = $connect->query($sqlmaxhistory)->fetchAll();	
         foreach ($datahist as $row2hh) 
         {
             //echo $row2hh['v_state']."<br>".$row2hh['v_state_result'];
             if ($row2hh['v_state']==0)
             {
               echo "<span class='badge bg-secondary' title='".$row2hh['v_state_result']."'>SAP::Pending RESORD</span>";
             }
             if ($row2hh['v_state']==1)
             {
               echo "<span class='badge bg-warning' title='".$row2hh['v_state_result']."'>SAP::Run</span>";
             }
             if ($row2hh['v_state']==2)
             {
               echo "<span class='badge bg-warning' title='".$row2hh['v_state_result']."'>SAP::Pending ACK</span>";
             }
             if ($row2hh['v_state']==3)
             {
               echo "<span class='badge bg-danger' title='".$row2hh['v_state_result']."'>SAP::Error </span>";
             }
             if ($row2hh['v_state']==4)
             {
                 echo "<span class='badge bg-info' title='".$row2hh['v_state_result']."'>SAP::OK ACK</span>";
             }
             if ($row2hh['v_state']==5)
             {
                 echo "<span class='badge bg-danger' title='".$row2hh['v_state_result']."'>SAP::Error ACK</span>";
             }
            /// echo "<br>".$row2hh['v_state_result'];
         }  
       ?>

                                </div>
                                </a>
                                <?php
   

  }

///////// inicio

function crear_steps_wo_BURNING($vv_worcenter,$vv_sn, $vvv_idwo,$vvv_idwo_nom,$vvv_idwo_ciu , $vvv_idso,$vvv_idso_nom,$vvv_idso_ciu, $vvnombre_a_mostrar_en_dvi, $v_enable_attachfile,$vv_step_nro_ary)
{
 /////**************************************************** 
 /////**** receive $refSowo = IDRUNIFNO !!!!!!! */
 include("db_conect.php"); 

 $vv_worcenter_show = substr(trim($vv_worcenter),3,10);
 $no_idruninfowo_ENGCAL=0;
 $v_idp =$vvv_idwo;

$modelciuwo =$vvv_idwo_ciu;
$idorderwo =  $vvv_idwo;
$wo_info = $vvv_idwo_nom;



    //////// DAS ENTERPRICE REMOTE NO MOSTRARRR //////
                                                    /////**************************************************** 
                                                  ///Detectamos CIU
                                                  /////**************************************************** 
                                                  /////**************************************************** 
                                                  $ciuisbda="N";
                                                  $ciuisenterprice="N";
                                                  $ciuisremote="N";
                                                  $ciuismaster="N";
                                                  $ciuisdas="N";
                                                  $sqldetect="select fnt_select_detect_bysn_isbda_isdas('".$vv_sn."','WO') ";
                                         //      echo  $sqldetect;
                                                  $datadetect = $connect->query($sqldetect)->fetchAll();
                                                  foreach ($datadetect as $rowdetect) 
                                                              {	
                                                            //	  echo "****.....".$rowdetect[0];
                                                                $resulm = json_decode($rowdetect[0]);
                                                              ///  echo "****".$resulm->{'isdba'};
                                                                if( $resulm->{'isdba'} >0 )
                                                                {
                                                                $ciuisbda="Y";
                                                                }
                                                                if( $resulm->{'isdas'} >0 )
                                                                {
                                                                $ciuisdas="Y";
                                                                }
                                                                if( $resulm->{'isenterprise'} >0 )
                                                                {
                                                                $ciuisenterprice="Y";
                                                                }
                                                                if( $resulm->{'isremote'} >0 )
                                                                {
                                                                $ciuisremote="Y";
                                                                }
                                                                if( $resulm->{'ismaster'} >0 )
                                                                {
                                                                $ciuismaster="Y";
                                                                }


                                                               
                                                              } 
                                                          
                                                          
                                                  /////**************************************************** 								
                                                  //fin detectamos CIU
 
                                              
 $Sql_ifautotest = $connect->prepare("  
  select idscript, fas_outcome_integral.v_boolean::integer as tienecalibration_totalpass, fas_outcome_integral.reference
from fas_outcome_integral
inner join ( select reference, v_integer as idscript from fas_outcome_integral 
					where reference in ( select reference from fas_outcome_integral 
										where reference in (select reference from fas_outcome_integral
															where v_string ='".$vv_sn."' 
														   ) 
										and v_string =  '".$wo_info."'
									   ) 
					and idfasoutcomecat = 0 and idtype= 12 and v_integer in( 999 )
				   ) as lossub
on lossub.reference = fas_outcome_integral.reference
where fas_outcome_integral.idfasoutcomecat = 0 and 
fas_outcome_integral.idtype= 13

              ");        
              
       
 $Sql_ifautotest->execute();
 $_if_auto_test_box_calibration = "N";
 $activo_paso3_totalpass = "";
 $activo_paso3 ="";
 $result_ifautotest = $Sql_ifautotest->fetchAll();	
 foreach ($result_ifautotest as $row_autotest)
 {
  //echo "<br>aaaaaaaaaaaaaa".$row_autotest['idscript'];
  if ( $row_autotest['idscript']<> 2)
  {
    $_if_auto_test_box_calibration = "Y";
  }
  
  $idruninfowo_ENG = $row_autotest['reference'];
  $no_idruninfowo_ENGCAL=1;
    if ($row_autotest['tienecalibration_totalpass']==1 && $idruninfowo_ENG <>"")
  {
    
      $activo_paso3_totalpass = "<span class='badge bg-success'>Passed</span><br><a href='#' onclick='popuplogdb(".$idruninfowo_ENG.")'  style='color:#f39323;'>View Log <i class='fas fa-eye'> </i></a>";
  
  
  
  }
  if ($rowbuscawo['tienecalibration_totalpass']==0 && $idruninfowo_ENG <>"")
  {
    
      $activo_paso3_totalpass = "<span class='badge bg-danger'>Not Passed</span><br><a href='#' onclick='popuplogdb(".$idruninfowo_ENG.")'  style='color:#f39323;'>View Log <i class='fas fa-eye'></i></a>";
  
  }

 }

 $nombre_a_mostrar_en_dvi_calib ='Calibration :: SN: '.$vv_sn;
/////**************************************************** 
//           echo   "aaaaa".$_if_auto_test_box_calibration;
if ( $idruninfowo_ENG <>"")
{
  $activo_paso3 = "active";
  $activo_paso3_totalpass ="";
  $activo_paso3_totalpass = "<span class='badge bg-success'>Passed</span><br><a href='#' onclick='popuplogdb(".$idruninfowo_ENG.")'  style='color:#f39323;'>View Log <i class='fas fa-eye'> </i></a>";
  
}

/////
/////Buscamos el tipo de reporte para el SKU
 //
//$Sql_typeproducrepor = $connect->prepare(" select reporttype from products_webfas_report  where idproduct in ( select distinct idproduct from products where modelciu = '".$modelciuwo."')   ");        

$Sql_typeproducrepor = $connect->prepare(" select reporttype from products_webfas_report  where idproduct in ( select distinct idproduct from products where modelciu = '".$modelciuwo."')   "); 
            
 $name_js_report = '';    
$Sql_typeproducrepor->execute();

$result_typrepor = $Sql_typeproducrepor->fetchAll();	
foreach ($result_typrepor as $row_typerepo)
{
  $name_js_report = $row_typerepo['reporttype'];    
}

?>
                                <div class="step <?php echo  $activo_paso3; ?>"> <a href="#"
                                        onclick="show_info('<?php echo $name_js_report;?>','<?php echo $vv_sn; ?>','<?php echo $idorderwo; ?>','<?php echo $nombre_a_mostrar_en_dvi_calib; ?>','<?php echo $idruninfowo_ENG; ?>',0)">
                                        <span class="icon"> <i class="fas fa-box"></i> </span> <span
                                            class="text"><?php echo '['.$vv_step_nro_ary.'] - ';?><b>BURNING <br>
                                                <?php echo $activo_paso3_totalpass; ?></span></a></b> </div>
                                <?php
//////

}

///////// fin


 ///////////////////////////////////
 function crear_steps_wo_MODULE ($vv_worcenter,$vv_sn, $vvv_idwo,$vvv_idwo_nom,$vvv_idwo_ciu , $vvv_idso,$vvv_idso_nom,$vvv_idso_ciu, $vvnombre_a_mostrar_en_dvi, $v_enable_attachfile,$vv_step_nro_ary)
 {
  /////**************************************************** 
  /////**** receive $refSowo = IDRUNIFNO !!!!!!! */
  include("db_conect.php"); 
 
  $vv_worcenter_show = substr(trim($vv_worcenter),3,10);
  $no_idruninfowo_ENGCAL=0;
  $v_idp = $vvv_idwo;
 
  
  
 $modelciuwo = $vvv_idwo_ciu;
 $idorderwo = $vvv_idwo;
 $wo_info = $vvv_idwo_nom;
 $vtempidproduct =  $rowwo['idproduct'];
 

 ?>
                                <div class="stepazul   active">

                                    <a href="#"
                                        onclick="show_info('orderinfo','<?php echo $vv_sn; ?>','<?php echo  $idorderwo ; ?>','<?php echo $vvnombre_a_mostrar_en_dvi; ?>',0,0)">

                                        <span class="icon"> <i class="fa fa-check"></i> </span>
                                        <span class="text text-left">

                                            <b>
                                                [<?php echo $wo_info; ?>]<br> [<?php echo  $modelciuwo; ?>]</b>
                                            <br><b> SN Generated: [<?php echo $vv_sn; ?>]</b><br>
                                    </a>
                                    <p class='  text-left'>
                                        <span class='  text-success'>
                                            FAS-SAP Automated
                                        </span> <br>


                                        <a href="#"
                                            onclick="Call_printlabel('<?php echo  $modelciuwo; ?>', '<?php echo $vv_sn; ?>' ,'<?php echo  $idorderwo ; ?>')"><i
                                                class="fas fa-print"></i> - Print Label

                                            <br>

                                            <br>
                                            <br>
                                            <br>
                                            <br>
                                        </a>
                                    </p>
                                    </span>

                                </div>
                                <?php
  
                                               
  $Sql_ifautotest = $connect->prepare("  
   select idscript, fas_outcome_integral.v_boolean::integer as tienecalibration_totalpass, fas_outcome_integral.reference
 from fas_outcome_integral
 inner join ( select reference, v_integer as idscript from fas_outcome_integral 
           where reference in ( select reference from fas_outcome_integral 
                     where reference in (select reference from fas_outcome_integral
                               where v_string ='".$vv_sn."' 
                                ) 
             
                      ) 
           and idfasoutcomecat = 0 and idtype= 12 and v_integer in(1,24,22 )
            ) as lossub
 on lossub.reference = fas_outcome_integral.reference
 where fas_outcome_integral.idfasoutcomecat = 0 and 
 fas_outcome_integral.idtype= 13
 
               ");        
               
        
  $Sql_ifautotest->execute();
  $_if_auto_test_box_calibration = "N";
  $activo_paso3_totalpass = "";
  $activo_paso3 ="";
  $result_ifautotest = $Sql_ifautotest->fetchAll();	
  foreach ($result_ifautotest as $row_autotest)
  {
   //echo "<br>aaaaaaaaaaaaaa".$row_autotest['idscript'];
   if ( $row_autotest['idscript']<> 2)
   {
     $_if_auto_test_box_calibration = "Y";
   }
   
   $idruninfowo_ENG = $row_autotest['reference'];
   $no_idruninfowo_ENGCAL=1;
     if ($row_autotest['tienecalibration_totalpass']==1 && $idruninfowo_ENG <>"")
   {
     
       $activo_paso3_totalpass = "<span class='badge bg-success'>Passed</span><br><a href='#' onclick='popuplogdb(".$idruninfowo_ENG.")'  style='color:#f39323;'>View Log <i class='fas fa-eye'> </i></a>";
   
   
   
   }
   if ($rowbuscawo['tienecalibration_totalpass']==0 && $idruninfowo_ENG <>"")
   {
     
       $activo_paso3_totalpass = "<span class='badge bg-danger'>Not Passed</span><br><a href='#' onclick='popuplogdb(".$idruninfowo_ENG.")'  style='color:#f39323;'>View Log <i class='fas fa-eye'></i></a>";
   
   }
 
  }
 
  $nombre_a_mostrar_en_dvi_calib ='Aceptacion :: SN: '.$vv_sn;
 /////**************************************************** 
 //           echo   "aaaaa".$_if_auto_test_box_calibration;
 if ( $idruninfowo_ENG <>"")
 {
   $activo_paso3 = "active";
   $activo_paso3_totalpass ="";
   $activo_paso3_totalpass = "<span class='badge bg-success'>Passed</span><br><a href='#' onclick='popuplogdb(".$idruninfowo_ENG.")'  style='color:#f39323;'>View Log <i class='fas fa-eye'> </i></a>";
   
 }
 
 /////
 /////Buscamos el tipo de reporte para el SKU
 $msjlbl="";
 
 if ( $row_autotest['idscript'] ==22)
 {
  $name_js_report = ' ';   
  $msjlbl="Accept BBU";
 }
 else
 {
  $name_js_report = 'acceptance';   
  $msjlbl="Accept DiB";
 }         
 
 
 
 if ($no_idruninfowo_ENGCAL >0)
 {
 ?>
                                <div class="step <?php echo  $activo_paso3; ?>">
                                    <a href="#"
                                        onclick="show_info('<?php echo $name_js_report;?>','<?php echo $vv_sn; ?>','<?php echo $idorderwo; ?>','<?php echo $nombre_a_mostrar_en_dvi_calib; ?>','<?php echo $idruninfowo_ENG; ?>',0)">
                                        <span class="icon">
                                            <i class="fas fa-box"></i> </span> <span
                                            class="text"><b><?php echo  $msjlbl; ?>
                                                <br>
                                                <?php echo $activo_paso3_totalpass; ?></span></a></b>

                                    <?php
 //////
 }

 if ( $row_autotest['idscript'] ==22)
 { ?><br>
                                    <a href="calibbburepot.php?unitsn=<?php echo $vv_sn; ?>&amp;iduldl=0&amp;idmb=0"
                                        target="_blank"> <i class="fas fa-file-pdf"></i> - View Report</a>
                                    <?php
 }
  
           
          if ($no_idruninfowo_ENGCAL==0)
           {
            $psswdtkkey = substr( md5(microtime()), 2, 8);
             ?>
                                    <div class="step "> <span class="icon"> <i class="fas fa-box"></i> </span> <span
                                            class="text"><?php echo  $msjlbl; ?><br>

                                            <?php if ( $v_enable_attachfile=="Y") { ?>
                                            <a href="#"
                                                onclick="attachanalogbda(<?php echo $vv_idp; ?>,'<?php echo  $vv_worcenter.'_'.$psswdtkkey;?>','<?php echo $vv_sn; ?>')">
                                                <i class="fa fa-paperclip" aria-hidden="true"></i> Attach Files
                                            </a> <br>
                                            <?php } ?>
                                        </span> <br>
                                        <?php
           }
 
      
           
       
             
           $sqlmaxhistory = " select * from fas_to_sap_xml where v_sn ='".$vv_sn."' and v_workcenetr = '".substr($vv_worcenter,3,22)."'  and v_sku = '".$modelciuwo."' and
           runprocessdate in (
     select max(runprocessdate) from fas_to_sap_xml where v_sn ='".$vv_sn."' and v_workcenetr = '".substr($vv_worcenter,3,22)."' and v_sku = '".$modelciuwo."' )
 
     ";
        ///   echo $sqlmaxhistory;
             $datahist = $connect->query($sqlmaxhistory)->fetchAll();	
             foreach ($datahist as $row2hh) 
             {
                 //echo $row2hh['v_state']."<br>".$row2hh['v_state_result'];
                 if ($row2hh['v_state']==0)
                 {
                   echo "<br><span class='badge bg-secondary' title='".$row2hh['v_state_result']."'>SAP::Pending RESORD</span>";
                 }
                 if ($row2hh['v_state']==1)
                 {
                   echo "<br><span class='badge bg-warning' title='".$row2hh['v_state_result']."'>SAP::Run</span>";
                 }
                 if ($row2hh['v_state']==2)
                 {
                   echo "<br><span class='badge bg-warning' title='".$row2hh['v_state_result']."'>SAP::Pending ACK</span>";
                 }
                 if ($row2hh['v_state']==3)
                 {
                   echo "<br><span class='badge bg-danger' title='".$row2hh['v_state_result']."'>SAP::Error </span>";
                 }
                 if ($row2hh['v_state']==4)
                 {
                     echo "<br><span class='badge bg-info' title='".$row2hh['v_state_result']."'>SAP::OK ACK</span>";
                 }
                 if ($row2hh['v_state']==5)
                 {
                     echo "<br><span class='badge bg-danger' title='".$row2hh['v_state_result']."'>SAP::Error ACK</span>";
                 }
                 /// echo "<br>".$row2hh['v_state_result'];
             }  
         
      ///este div cierra ambos casos OJO       
     ?>
                                    </div>
                                    <?php
     ///////////////////////////////////////////////////////
 }


  ///////////////////////////////////
function crear_steps_wo_ENG ($vv_worcenter,$vv_sn, $vvv_idwo,$vvv_idwo_nom,$vvv_idwo_ciu , $vvv_idso,$vvv_idso_nom,$vvv_idso_ciu, $vvnombre_a_mostrar_en_dvi, $v_enable_attachfile,$vv_step_nro_ary)
{
 /////**************************************************** 
 /////**** receive $refSowo = IDRUNIFNO !!!!!!! */
 include("db_conect.php"); 

 $vv_worcenter_show = substr(trim($vv_worcenter),3,10);
 $no_idruninfowo_ENGCAL=0;
 $v_idp = $vvv_idwo;

 
 
$modelciuwo = $vvv_idwo_ciu;
$idorderwo = $vvv_idwo;
$wo_info = $vvv_idwo_nom;
$vtempidproduct =  $rowwo['idproduct'];



    //////// DAS ENTERPRICE REMOTE NO MOSTRARRR //////
                                                    /////**************************************************** 
                                                  ///Detectamos CIU
                                                  /////**************************************************** 
                                                  /////**************************************************** 
                                                  $ciuisbda="N";
                                                  $ciuisenterprice="N";
                                                  $ciuisremote="N";
                                                  $ciuismaster="N";
                                                  $ciuisdas="N";
                                                  $sqldetect="select fnt_select_detect_bysn_isbda_isdas('".$vv_sn."','WO') ";
                                         //      echo  $sqldetect;
                                                  $datadetect = $connect->query($sqldetect)->fetchAll();
                                                  foreach ($datadetect as $rowdetect) 
                                                              {	
                                                            //	  echo "****.....".$rowdetect[0];
                                                                $resulm = json_decode($rowdetect[0]);
                                                              ///  echo "****".$resulm->{'isdba'};
                                                                if( $resulm->{'isdba'} >0 )
                                                                {
                                                                $ciuisbda="Y";
                                                                }
                                                                if( $resulm->{'isdas'} >0 )
                                                                {
                                                                $ciuisdas="Y";
                                                                }
                                                                if( $resulm->{'isenterprise'} >0 )
                                                                {
                                                                $ciuisenterprice="Y";
                                                                }
                                                                if( $resulm->{'isremote'} >0 )
                                                                {
                                                                $ciuisremote="Y";
                                                                }
                                                                if( $resulm->{'ismaster'} >0 )
                                                                {
                                                                $ciuismaster="Y";
                                                                }


                                                               
                                                              } 
                                                          
                                                          
                                                  /////**************************************************** 								
                                                  //fin detectamos CIU
 
                                              
 $Sql_ifautotest = $connect->prepare("  
  select idscript, fas_outcome_integral.v_boolean::integer as tienecalibration_totalpass, fas_outcome_integral.reference
from fas_outcome_integral
inner join ( select reference, v_integer as idscript from fas_outcome_integral 
					where reference in ( select reference from fas_outcome_integral 
										where reference in (select reference from fas_outcome_integral
															where v_string ='".$vv_sn."' 
														   ) 
										and v_string =  '".$wo_info."'
									   ) 
					and idfasoutcomecat = 0 and idtype= 12 and v_integer in( 27,2,32,37 )
				   ) as lossub
on lossub.reference = fas_outcome_integral.reference
where fas_outcome_integral.idfasoutcomecat = 0 and 
fas_outcome_integral.idtype= 13

              ");        
              
       
 $Sql_ifautotest->execute();
 $_if_auto_test_box_calibration = "N";
 $activo_paso3_totalpass = "";
 $activo_paso3 ="";
 $result_ifautotest = $Sql_ifautotest->fetchAll();	
 foreach ($result_ifautotest as $row_autotest)
 {
  //echo "<br>aaaaaaaaaaaaaa".$row_autotest['idscript'];
  if ( $row_autotest['idscript']<> 2)
  {
    $_if_auto_test_box_calibration = "Y";
  }
  
  $idruninfowo_ENG = $row_autotest['reference'];
  $no_idruninfowo_ENGCAL=1;
    if ($row_autotest['tienecalibration_totalpass']==1 && $idruninfowo_ENG <>"")
  {
    
      $activo_paso3_totalpass = "<span class='badge bg-success'>Passed</span><br><a href='#' onclick='popuplogdb(".$idruninfowo_ENG.")'  style='color:#f39323;'>View Log <i class='fas fa-eye'> </i></a>";
  
  
  
  }
  if ($rowbuscawo['tienecalibration_totalpass']==0 && $idruninfowo_ENG <>"")
  {
    
      $activo_paso3_totalpass = "<span class='badge bg-danger'>Not Passed</span><br><a href='#' onclick='popuplogdb(".$idruninfowo_ENG.")'  style='color:#f39323;'>View Log <i class='fas fa-eye'></i></a>";
  
  }

 }

 ////// OUTCOME - 13	49	Factory String
/*
 $Sql_factorystring = $connect->prepare(" select * from fas_outcome_integral where reference = ".$idruninfowo_ENG." and fas_outcome_integral.idfasoutcomecat =13 and fas_outcome_integral.idtype= 49 ");        
 $Sql_factorystring->execute();             
  $have_factory_string= "N";
 $result_factstring = $Sql_factorystring->fetchAll();	
 foreach ($result_factstring as $row_factostring )
 {
  $have_factory_string= "Y";
 }
 ////// FIN OUTCOME - 13	49	Factory String
*/

 $nombre_a_mostrar_en_dvi_calib ='Calibration :: SN: '.$vv_sn;
/////**************************************************** 
//           echo   "aaaaa".$_if_auto_test_box_calibration;
if ( $idruninfowo_ENG <>"")
{
  $activo_paso3 = "active";
  $activo_paso3_totalpass ="";
  $activo_paso3_totalpass = "<span class='badge bg-success'>Passed</span><br><a href='#' onclick='popuplogdb(".$idruninfowo_ENG.")'  style='color:#f39323;'>View Log <i class='fas fa-eye'> </i></a>";
  
}

/////
/////Buscamos el tipo de reporte para el SKU

$Sql_typeproducrepor = $connect->prepare(" select reporttype from products_webfas_report  where idproduct in ( select distinct idproduct from products where modelciu = '".$modelciuwo."')   ");        
            
 $name_js_report = '';    
$Sql_typeproducrepor->execute();

$result_typrepor = $Sql_typeproducrepor->fetchAll();	
foreach ($result_typrepor as $row_typerepo)
{
  $name_js_report = $row_typerepo['reporttype'];    
}

if ($no_idruninfowo_ENGCAL >0)
{
?>
                                    <div class="step <?php echo  $activo_paso3; ?>">
                                        <a href="#"
                                            onclick="show_info('<?php echo $name_js_report;?>','<?php echo $vv_sn; ?>','<?php echo $idorderwo; ?>','<?php echo $nombre_a_mostrar_en_dvi_calib; ?>','<?php echo $idruninfowo_ENG; ?>',0)">
                                            <span class="icon">
                                                <i class="fas fa-box"></i> </span> <span class="text">
                                                <?php echo '['.$vv_step_nro_ary.'] - ';?> <b>ENG-CAL <br>
                                                    <?php echo $activo_paso3_totalpass; ?></span></a></b>

                                        <?php
//////
}
 
$add_btn_factory_string="";
          if ($have_factory_string=="uY")
          {
        //    echo "SIIIIIIIIIIIIIIIIIIIIIII";
                $add_btn_factory_string = "<a href='#'> <i class='fas fa-file'></i> <span class='text'><b>File Calr </span></a>";
            ?>

                                        <?php
          }
         if ($no_idruninfowo_ENGCAL==0)
          {
            $psswdtkkey = substr( md5(microtime()), 2, 8);
            ?>
                                        <div class="step "> <span class="icon"> <i class="fas fa-box"></i> </span> <span
                                                class="text"> <?php echo '['.$vv_step_nro_ary.'] - ';?> ENG-CAL<br>

                                                <?php if ( $v_enable_attachfile=="Y") { ?>
                                                <a href="#"
                                                    onclick="attachanalogbda(<?php echo $idorderwo; ?>,'<?php echo  $vv_worcenter.'_'.$psswdtkkey;?>','<?php echo $vv_sn; ?>')">
                                                    <i class="fa fa-paperclip" aria-hidden="true"></i> Attach Files
                                                </a> <br>
                                                <?php } ?>
                                            </span> <br>
                                            <?php
          }

     
          
      
            
          $sqlmaxhistory = " select * from fas_to_sap_xml where v_sn ='".$vv_sn."' and v_workcenetr = '".substr($vv_worcenter,3,22)."'  and v_sku = '".$modelciuwo."' and
          runprocessdate in (
    select max(runprocessdate) from fas_to_sap_xml where v_sn ='".$vv_sn."' and v_workcenetr = '".substr($vv_worcenter,3,22)."' and v_sku = '".$modelciuwo."' )

    ";
       ///   echo $sqlmaxhistory;
            $datahist = $connect->query($sqlmaxhistory)->fetchAll();	
            foreach ($datahist as $row2hh) 
            {
                //echo $row2hh['v_state']."<br>".$row2hh['v_state_result'];
                if ($row2hh['v_state']==0)
                {
                  echo "<br><span class='badge bg-secondary' title='".$row2hh['v_state_result']."'>SAP::Pending RESORD</span>";
                }
                if ($row2hh['v_state']==1)
                {
                  echo "<br><span class='badge bg-warning' title='".$row2hh['v_state_result']."'>SAP::Run</span>";
                }
                if ($row2hh['v_state']==2)
                {
                  echo "<br><span class='badge bg-warning' title='".$row2hh['v_state_result']."'>SAP::Pending ACK</span>";
                }
                if ($row2hh['v_state']==3)
                {
                  echo "<br><span class='badge bg-danger' title='".$row2hh['v_state_result']."'>SAP::Error </span>";
                }
                if ($row2hh['v_state']==4)
                {
                    echo "<br><span class='badge bg-info' title='".$row2hh['v_state_result']."'>SAP::OK ACK</span>";
                }
                if ($row2hh['v_state']==5)
                {
                    echo "<br><span class='badge bg-danger' title='".$row2hh['v_state_result']."'>SAP::Error ACK</span>";
                }
                /// echo "<br>".$row2hh['v_state_result'];
            }  
        
     ///este div cierra ambos casos OJO       
    ?>
                                        </div>
                                        <?php
    ///////////////////////////////////////////////////////
}

//////////////////////////////////////////////////////////////////////////////////////////////////////
function crear_steps_soinfo_parch($vv_worcenter,$vv_sn, $vvv_idwo,$vvv_idwo_nom,$vvv_idwo_ciu , $vvv_idso,$vvv_idso_nom,$vvv_idso_ciu, $vvnombre_a_mostrar_en_dvi, $v_enable_attachfile)
{
  include("db_conect.php"); 
  // echo "HOLA".$vv_worcenter."-wo".$vvv_idwo_nom."-SO".$vvv_idso_nom."-modelWO".$vvv_idwo_ciu ."-modelso".$vvv_idso_ciu;
     $vv_worcenter_show = substr(trim($vv_worcenter),3,10);
 
        $modelciuwo = $vvv_idso_ciu;
        $idorderwo =  $vvv_idso;
        $wo_info = $vvv_idso_nom;
 
      
      $vvnombre_a_mostrar_en_dvi ='Order Detail :: '.$wo_info." - SN: ".$vv_sn;        
     $tienewo = "Y";
     ?>
                                        <div class="stepazul   active">

                                            <a href="#"
                                                onclick="show_info('orderinfo','<?php echo $vv_sn; ?>','<?php echo  $idorderwo ; ?>','<?php echo $vvnombre_a_mostrar_en_dvi; ?>',0,0)">

                                                <span class="icon"> <i class="fa fa-check"></i> </span>
                                                <span class="text text-left">

                                                    <b> <?php if ($tienewo == "Y")
       {
 //       echo "WO:";
       }
       else
       {
    //    echo "SO:";
       }
       ?>
                                                        [<?php echo $wo_info; ?>]<br> [<?php echo  $modelciuwo; ?>]</b>
                                                    <br><b> SN Generated: [<?php echo $vv_sn; ?>]</b><br>
                                            </a>
                                            <p class='  text-left'>
                                                <span class='  text-success'>
                                                    FAS-SAP Automated
                                                </span> <br>


                                                <a href="#"
                                                    onclick="Call_printlabel('<?php echo  $modelciuwo; ?>', '<?php echo $vv_sn; ?>' ,'<?php echo  $idorderwo ; ?>')"><i
                                                        class="fas fa-print"></i> - Print Label


                                                </a>
                                            </p>
                                            </span>

                                        </div>
                                        <?php
}


function crear_steps_soinfo_only($vv_worcenter,$vv_sn, $vvv_idwo,$vvv_idwo_nom,$vvv_idwo_ciu , $vvv_idso,$vvv_idso_nom,$vvv_idso_ciu, $vvnombre_a_mostrar_en_dvi, $v_enable_attachfile)
{
  include("db_conect.php"); 
  // echo "HOLA".$vv_worcenter."-wo".$vvv_idwo_nom."-SO".$vvv_idso_nom."-modelWO".$vvv_idwo_ciu ."-modelso".$vvv_idso_ciu;
     $vv_worcenter_show = substr(trim($vv_worcenter),3,10);
 
        $modelciuwo = $vvv_idso_ciu;
        $idorderwo =  $vvv_idso;
        $wo_info = $vvv_idso_nom;
 
      
      $vvnombre_a_mostrar_en_dvi ='Order Detail :: '.$wo_info." - SN: ".$vv_sn;        
     $tienewo = "Y";
 
 /*
      $elsowomarco = $vv_soworam;
      $elmodelciu = $vv_modelciu;*/
    //  echo "SI,entre aca".  $wo_info ;
 
      $psswdtkkey = substr( md5(microtime()), 1, 8);  
      $psswdtkkey = substr( md5(microtime()), 2, 8);
   
    ///////////////// wo_info_step1 //////////////////////////  
 
     
      ?>

                                        <div class="stepazul   active">

                                            <a href="#"
                                                onclick="show_info('orderinfo','<?php echo $vv_sn; ?>','<?php echo  $idorderwo ; ?>','<?php echo $vvnombre_a_mostrar_en_dvi; ?>',0,0)">

                                                <span class="icon"> <i class="fa fa-check"></i> </span>
                                                <span class="text text-left">

                                                    <b>
                                                        [<?php echo $wo_info; ?>]<br> [<?php echo  $modelciuwo; ?>]</b>
                                                    <br><b> SN Generated: [<?php echo $vv_sn; ?>]</b><br>
                                            </a>
                                            <p class='  text-left'>
                                                <span class='  text-success'>
                                                    FAS-SAP Automated
                                                </span> <br>


                                                <a href="#"
                                                    onclick="Call_printlabel('<?php echo  $modelciuwo; ?>', '<?php echo $vv_sn; ?>' ,'<?php echo  $idorderwo ; ?>')"><i
                                                        class="fas fa-print"></i> - Print Label

                                                    <br>

                                                    <br>
                                                    <br>
                                                    <br>
                                                    <br>
                                                </a>
                                            </p>
                                            </span>

                                        </div>




                                    </div>
                                    </a>
                                    <?php
    
}

function crear_steps_soinfo_ASSY($vv_worcenter,$vv_sn, $vvv_idwo,$vvv_idwo_nom,$vvv_idwo_ciu , $vvv_idso,$vvv_idso_nom,$vvv_idso_ciu, $vvnombre_a_mostrar_en_dvi, $v_enable_attachfile,$vv_step_nro_ary)
  { 
    include("db_conect.php"); 
    global  $_v_steps_WO_ASSY;
    global $_v_steps_WO_PRECHECK ;
    global $_v_steps_SO_ASSY;
    global  $_v_steps_SO_PRECHECK;

 // echo "HOLA".$vv_worcenter."-wo".$vvv_idwo_nom."-SO".$vvv_idso_nom."-modelWO".$vvv_idwo_ciu ."-modelso".$vvv_idso_ciu;
    $vv_worcenter_show = substr(trim($vv_worcenter),3,10);

       $modelciuwo = $vvv_idso_ciu;
       $idorderwo =  $vvv_idso;
       $wo_info = $vvv_idso_nom;

     
     $vvnombre_a_mostrar_en_dvi ='Order Detail :: '.$wo_info." - SN: ".$vv_sn;        
    $tienewo = "Y";

/*
     $elsowomarco = $vv_soworam;
     $elmodelciu = $vv_modelciu;*/
   //  echo "SI,entre aca".  $wo_info ;

     $psswdtkkey = substr( md5(microtime()), 1, 8);  
     $psswdtkkey = substr( md5(microtime()), 2, 8);
    if  ($vv_worcenter =="so_2ND-ASSY" ||  $vv_worcenter =="so_ASSY"  )
    {
	
   ///////////////// wo_info_step1 //////////////////////////  

    
     ?>

                                    <div class="stepazul   active">

                                        <a href="#"
                                            onclick="show_info('orderinfo','<?php echo $vv_sn; ?>','<?php echo  $idorderwo ; ?>','<?php echo $vvnombre_a_mostrar_en_dvi; ?>',0,0)">

                                            <span class="icon"> <i class="fa fa-check"></i> </span>
                                            <span class="text text-left">

                                                <b> <?php if ($tienewo == "Y")
         {
   //       echo "WO:";
         }
         else
         {
      //    echo "SO:";
         }
         ?>
                                                    [<?php echo $wo_info; ?>]<br> [<?php echo  $modelciuwo; ?>]</b>
                                                <br><b> SN Generated: [<?php echo $vv_sn; ?>]</b><br>
                                        </a>
                                        <p class='  text-left'>
                                            <span class='  text-success'>
                                                FAS-SAP Automated
                                            </span> <br>


                                            <a href="#"
                                                onclick="Call_printlabel('<?php echo  $modelciuwo; ?>', '<?php echo $vv_sn; ?>' ,'<?php echo  $idorderwo ; ?>')"><i
                                                    class="fas fa-print"></i> - Print Label

                                                <br>

                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                            </a>
                                        </p>
                                        </span>

                                    </div>


                                    <?php
  ////////////// fin wo steps
    }

    $tienepicking=0;

    if ($vv_sn<> '')
    {

      $sqldetectchkeopicki="SELECT distinct   orders_sn_components.wo_serialnumber 
      FROM public.orders_sn_components_xml as orders_sn_components 
    
    inner join orders_sn
    on orders_sn.idorders = orders_sn_components.idorders and 
    orders_sn.idproduct = orders_sn_components.idproduct and
    orders_sn.so_soft_external = '".$wo_info."'  where orders_sn_components.wo_serialnumber= '".$vv_sn."'";
   
   	//echo "test:".$sqldetectchkeopicki;
     $datapicking = $connect->query($sqldetectchkeopicki)->fetchAll();
   
     
          foreach ($datapicking as $rowchequeo) 
          {
            $tienepicking=1;
          }

    }

       
         ?>
                                    <?php if ( $tienepicking==1) 
              {
                ?>
                                    <div class="stepverde  active">
                                        <?php
              }
              else
              {
              ?>
                                        <div class="step  ">
                                            <?php
              }
              $psswdtkkey = substr( md5(microtime()), 2, 8);
         ?>

                                            <a href="#"
                                                onclick="show_info('picking','<?php echo $vv_sn; ?>','<?php echo $wo_info; ?>','<?php echo $modelciuwo; ?>','<?php echo  $vvv_idso; ?>',   '<?php echo $vv_worcenter ; ?>'  )">
                                                <span class="icon"> <i class="fas fa-tasks"></i> </span>
                                                <span class="text">
                                                    <b><?php echo  '['.$vv_step_nro_ary.'] - '.$vv_worcenter_show;?>
                                                        <br>SN
                                                        [<?php echo $vv_sn; ?>] <br></b>

                                                    <?php if ( $v_enable_attachfile=="NO_Y") { ?>
                                                    <a href="#"
                                                        onclick="attachanalogbda(<?php echo $vv_idp; ?>,'<?php echo  $vv_worcenter.'_'.$psswdtkkey;?>','<?php echo $vv_sn; ?>')">
                                                        <i class="fa fa-paperclip" aria-hidden="true"></i> Attach Files
                                                    </a> <br>
                                                    <?php } ?>
                                                </span>
                                                <?php

       if ( $vv_sn <> '')
       {

        $sqlmaxhistory = " select * from fas_to_sap_xml where v_sn ='".$vv_sn."' and v_workcenetr = '".substr($vv_worcenter,3,22)."' and
        runinfodate in (
  select max(runinfodate) from fas_to_sap_xml where v_sn ='".$vv_sn."' and v_workcenetr = '".substr($vv_worcenter,3,22)."')

  ";
///    echo $sqlmaxhistory;
   $datahist = $connect->query($sqlmaxhistory)->fetchAll();	
   foreach ($datahist as $row2hh) 
   {
    $_v_steps_SO_ASSY='Y';
       //echo $row2hh['v_state']."<br>".$row2hh['v_state_result'];
       if ($row2hh['v_state']==0)
       {
         echo "<span class='badge bg-secondary' title='".$row2hh['v_state_result']."'>SAP::Pending RESORD</span>";
       }
       if ($row2hh['v_state']==1)
       {
         echo "<span class='badge bg-warning' title='".$row2hh['v_state_result']."'>SAP::Run</span>";
       }
       if ($row2hh['v_state']==2)
       {
         echo "<span class='badge bg-warning' title='".$row2hh['v_state_result']."'>SAP::Pending ACK</span>";
       }
       if ($row2hh['v_state']==3)
       {
         echo "<span class='badge bg-danger' title='".$row2hh['v_state_result']."'>SAP::Error </span>";
       }
       if ($row2hh['v_state']==4)
       {
           echo "<span class='badge bg-info' title='".$row2hh['v_state_result']."'>SAP::OK ACK</span>";
       }
       if ($row2hh['v_state']==5)
       {
           echo "<span class='badge bg-danger' title='".$row2hh['v_state_result']."'>SAP::Error ACK</span>";
       }
       if ($row2hh['v_state']==8)
       {
                       echo "<span class='badge bg-success'>Ok - Manually confirmed in SAP</span>";
        
                       
       }
      /// echo "<br>".$row2hh['v_state_result'];
   }  

       }
             
       ?>

                                        </div>
                                        </a>
                                        <?php
   

  }

/////////////////////////////////////////////////////////////////////////////////////////////////////
function crear_steps_woinfo_ASSY($vv_worcenter,$vv_sn, $vvv_idwo,$vvv_idwo_nom,$vvv_idwo_ciu , $vvv_idso,$vvv_idso_nom,$vvv_idso_ciu, $vvnombre_a_mostrar_en_dvi, $v_enable_attachfile, $vv_step_nro_ary)
  { 
    include("db_conect.php"); 

    global  $_v_steps_WO_ASSY;
    global $_v_steps_WO_PRECHECK ;
    global $_v_steps_SO_ASSY;
    global  $_v_steps_SO_PRECHECK;
//echo "HOLA".$vv_worcenter;
    $vv_worcenter_show = substr(trim($vv_worcenter),3,10);

       $modelciuwo = $vvv_idwo_ciu;
       $idorderwo =  $vvv_idwo;
       $wo_info = $vvv_idwo_nom;

     
     $vvnombre_a_mostrar_en_dvi ='Order Detail :: '.$wo_info." - SN: ".$vv_sn;        
    $tienewo = "Y";

/*
     $elsowomarco = $vv_soworam;
     $elmodelciu = $vv_modelciu;*/
   //  echo "SI,entre aca".  $wo_info ;

     $psswdtkkey = substr( md5(microtime()), 1, 8);  
     $psswdtkkey = substr( md5(microtime()), 2, 8);
     
    if  ($vv_worcenter =="wo_ASSY"   )
    {
	
   ///////////////// wo_info_step1 //////////////////////////  

    
     ?>

                                        <div class="stepazul   active">

                                            <a href="#"
                                                onclick="show_info('orderinfo','<?php echo $vv_sn; ?>','<?php echo  $idorderwo ; ?>','<?php echo $vvnombre_a_mostrar_en_dvi; ?>',0,0)">

                                                <span class="icon"> <i class="fa fa-check"></i> </span>
                                                <span class="text text-left">

                                                    <b> <?php if ($tienewo == "Y")
         {
   //       echo "WO:";
         }
         else
         {
      //    echo "SO:";
         }
         ?>
                                                        [<?php echo $wo_info; ?>]<br> [<?php echo  $modelciuwo; ?>]</b>
                                                    <br><b> SN Generated: [<?php echo $vv_sn; ?>]</b><br>
                                            </a>
                                            <p class='  text-left'>
                                                <span class='  text-success'>
                                                    FAS-SAP Automated
                                                </span> <br>


                                                <a href="#"
                                                    onclick="Call_printlabel('<?php echo  $modelciuwo; ?>', '<?php echo $vv_sn; ?>' ,'<?php echo  $idorderwo ; ?>')"><i
                                                        class="fas fa-print"></i> - Print Label

                                                    <br>

                                                    <br>
                                                    <br>
                                                    <br>
                                                    <br>
                                                </a>
                                            </p>
                                            </span>

                                        </div>


                                        <?php
  ////////////// fin wo steps
    }

          $sqldetectchkeopicki="SELECT distinct   orders_sn_components.wo_serialnumber 
          FROM public.orders_sn_components_xml as orders_sn_components 
        
        inner join orders_sn
        on orders_sn.idorders = orders_sn_components.idorders and 
        orders_sn.idproduct = orders_sn_components.idproduct and
        orders_sn.so_soft_external = '".$wo_info."'  where orders_sn_components.wo_serialnumber= '".$vv_sn."'";
       
     ///  	echo "test:".$sqldetectchkeopicki;
         $datapicking = $connect->query($sqldetectchkeopicki)->fetchAll();
         $tienepicking=0;
         
              foreach ($datapicking as $rowchequeo) 
              {
                $tienepicking=1;
              }
         ?>
                                        <?php if ( $tienepicking==1) 
              {
                ?>
                                        <div class="stepverde  active">
                                            <?php
              }
              else
              {
              ?>
                                            <div class="step  ">
                                                <?php
              }
              $psswdtkkey = substr( md5(microtime()), 2, 8);
         ?>

                                                <a href="#"
                                                    onclick="show_info('picking','<?php echo $vv_sn; ?>','<?php echo $wo_info; ?>','<?php echo $modelciuwo; ?>','Quality Calibration Precheck',   '<?php echo $vv_worcenter ; ?>'  )">
                                                    <span class="icon"> <i class="fas fa-tasks"></i> </span>
                                                    <span class="text">
                                                        <b><?php echo  '['.$vv_step_nro_ary.'] - '.$vv_worcenter_show;?>
                                                            <br>SN
                                                            [<?php echo $vv_sn; ?>] <br></b>

                                                        <?php if ( $v_enable_attachfile=="NO_Y") { ?>
                                                        <a href="#"
                                                            onclick="attachanalogbda(<?php echo $vv_idp; ?>,'<?php echo  $vv_worcenter.'_'.$psswdtkkey;?>','<?php echo $vv_sn; ?>')">
                                                            <i class="fa fa-paperclip" aria-hidden="true"></i> Attach
                                                            Files
                                                        </a> <br>
                                                        <?php } ?>
                                                    </span>
                                                    <?php
       $sqlmaxhistory = " select * from fas_to_sap_xml where v_sn ='".$vv_sn."' and v_workcenetr = '".substr($vv_worcenter,3,22)."' and
       runinfodate in (
select max(runinfodate) from fas_to_sap_xml where v_sn ='".$vv_sn."' and v_workcenetr = '".substr($vv_worcenter,3,22)."')

";
   ///    echo "<br>".$sqlmaxhistory;
         $datahist = $connect->query($sqlmaxhistory)->fetchAll();	
         foreach ($datahist as $row2hh) 
         {
          echo "<br>SETEO v_steps_WO_ASSY = Y";
          $_v_steps_WO_ASSY='Y';
             //echo $row2hh['v_state']."<br>".$row2hh['v_state_result'];
             if ($row2hh['v_state']==0)
             {
               echo "<span class='badge bg-secondary' title='".$row2hh['v_state_result']."'>SAP::Pending RESORD</span>";
             }
             if ($row2hh['v_state']==1)
             {
               echo "<span class='badge bg-warning' title='".$row2hh['v_state_result']."'>SAP::Run</span>";
             }
             if ($row2hh['v_state']==2)
             {
               echo "<span class='badge bg-warning' title='".$row2hh['v_state_result']."'>SAP::Pending ACK</span>";
             }
             if ($row2hh['v_state']==3)
             {
               echo "<span class='badge bg-danger' title='".$row2hh['v_state_result']."'>SAP::Error </span>";
             }
             if ($row2hh['v_state']==4)
             {
                 echo "<span class='badge bg-info' title='".$row2hh['v_state_result']."'>SAP::OK ACK</span>";
             }
             if ($row2hh['v_state']==8)
             {
                 echo "<span class='badge bg-info' title='".$row2hh['v_state_result']."'>SAP::OK ACK Manual</span>";
             }
             if ($row2hh['v_state']==5)
             {
                 echo "<span class='badge bg-danger' title='".$row2hh['v_state_result']."'>SAP::Error ACK</span>";
             }
            /// echo "<br>".$row2hh['v_state_result'];
         }  
       ?>

                                            </div>
                                            </a>
                                            <?php
   

  }
        ///////////////////////////////////
        function section_create_graph_VNA_by_idrun_sn2($vp_runinfo,$v_sn,$idscript, $idinstance, $v_enable_attachfile)
        { 

        include("db_conect.php"); 
        
        }
        ///////////////////////////////////
        function section_create_graph_VNA_by_idrun_sn3($vp_runinfo,$v_sn,$idscript, $idinstance, $v_enable_attachfile)
        { 

        include("db_conect.php"); 
        
        }
        ///////////////////////////////////
        ///////////////////////////////////
  
  ///////////////////////////////////
  ///////////////////////////////////

?>
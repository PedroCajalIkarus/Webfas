<?php
 
// Desactivar toda notificación de error
error_reporting(0);
// Notificar todos los errores de PHP (ver el registro de cambios)
//error_reporting(E_ALL);
 include("db_conect.php"); 
 

$btnt1v =$_POST['btnt1v'];
$btnt2v =$_POST['btnt2v'];
$btnt3v =$_POST['btnt3v'];
$btnt4v =$_POST['btnt4v'];
$btnt5v =$_POST['btnt5v'];
$btnt6v =$_POST['btnt6v'];
    if ($btnt1v=="true" && $btnt2v=="true")
    {
        $sumowhere1="";
    }
    if ($btnt1v=="false" && $btnt2v=="true")
    {
        $sumowhere1=" and fas_tree_measure.totalpass =false ";
    }
    if ($btnt1v=="true" && $btnt2v=="false")
    {
        $sumowhere1=" and fas_tree_measure.totalpass =true ";
    }
    if ($btnt1v=="false" && $btnt2v=="false")
    {
        $sumowhere1="";
    }

    //btn2
    if ($btnt3v=="1" && $btnt4v=="1")
    {
        $sumowhere2="";
    }
    if ($btnt3v=="0" && $btnt4v=="1")
    {
        $sumowhere2=" and bandnuevo =1 ";
    }
    if ($btnt3v=="1" && $btnt4v=="0")
    {
        $sumowhere2=" and bandnuevo = 0 ";
    }
    if ($btnt3v=="0" && $btnt4v=="0")
    {
        $sumowhere2="";
    }

    //btn3
    if ($btnt5v=="1" && $btnt6v=="1")
    {
        $sumowhere3="";
    }
    if ($btnt5v=="0" && $btnt6v=="1")
    {
        $sumowhere3=" and listroutime.uldl =1 ";
    }
    if ($btnt5v=="1" && $btnt6v=="0")
    {
        $sumowhere3=" and listroutime.uldl =0";
    }
    if ($btnt5v=="0" && $btnt6v=="0")
    {
        $sumowhere3="";
    }

 	session_start(); 
   
   $idrun =$_POST['idr'];

   

    $sql = $connect->prepare("	select distinct listroutime.idorden ,  max(fas_times.duration ) as duration, branchname as script,    fas_times_type.timename, 
 
    bandnuevo, listroutime.uldl, fas_routines_product_sn.sn ,fas_tree_measure.totalpass::int as totalpass 
    from 
    (
    select fas_routines_product.*,fas_step.description as branchname, CASE fas_routines_product.idband
    WHEN 0  THEN 0
    WHEN 3  THEN 0
    WHEN 4  THEN 1
    WHEN 8  THEN 1
    WHEN 7  THEN 1
    WHEN 1  THEN 1
    WHEN 6  THEN 1
    ELSE NULL
    END AS bandnuevo from  fas_routines_product 
    inner join fas_tree_product 
    on fas_tree_product.idproduct = fas_routines_product.idproduct
    inner join fas_tree
    on fas_tree.iduniquebranch = fas_routines_product.iduniquebranch
    and fas_tree.idfastree = fas_tree_product.idfastree
    inner join fas_step
    on fas_tree.idfastrepson = fas_step.idfasstep
    where fas_routines_product.idproduct in (
      
      select distinct idproduct from products where classproduct in (
        select distinct classproduct from products where idproduct in (
        select idproduct from 
          (
          SELECT idproduct ,1 as ordernmm from orders_sn where typeregister = 'SO' and  wo_serialnumber in (select unitsn from fas_tree_measure where idrununfo =".$idrun.")
          union 
          SELECT idproduct,2  from orders_sn where typeregister = 'WO' and  wo_serialnumber in (select unitsn from fas_tree_measure where idrununfo = ".$idrun.")
          ) as lasdos order by ordernmm asc limit 1))
          and idproduct in (
          select distinct idproduct from products_attributes where v_boolean= true and idattribute = 0
          )
          
      )
        
    and fas_routines_product.active = 'Y'
    order by fas_routines_product.idorden
    ) as listroutime
	
    left join fnt_select_allfas_tree_measure_maxrev2() as  fas_tree_measure 
    on listroutime.iduniquebranch =  fas_tree_measure.iduniquebranch   and
    listroutime.bandnuevo			= fas_tree_measure.band and
    listroutime.uldl			= fas_tree_measure.uldl and
	listroutime.idorden         = fas_tree_measure.idorder and 
    fas_tree_measure.idrununfo = ".$idrun."

    left  join fas_routines_product_sn
    on fas_routines_product_sn.idproduct	=	listroutime.idproduct and
    fas_routines_product_sn.idscript		=	listroutime.idscript and
    fas_routines_product_sn.iduniquebranch	=	listroutime.iduniquebranch and
    fas_routines_product_sn.idband			= listroutime.idband and
    fas_routines_product_sn.uldl			= listroutime.uldl and
    fas_routines_product_sn.idruninfo		=	fas_tree_measure.idrununfo and
    fas_routines_product_sn.sn		=	fas_tree_measure.unitsn and
	fas_routines_product_sn.idorden         = fas_tree_measure.idorder and 
    fas_routines_product_sn.idruninfo = ".$idrun."
	
    left join fas_times
    on fas_times.iduniqueop   = fas_tree_measure.iduniqueop 
    and fas_times.idsinglemeasure is null 
    and fas_times.idsameasures is null
    and fas_times.iducmeasure is null
    
    left join fas_times_type
    on fas_times_type.idtimetype = fas_times.idtimetype
	
    
    where  listroutime.idorden>=0   ".$sumowhere1. $sumowhere2. $sumowhere3."
    group by listroutime.idorden, branchname ,    fas_times_type.timename, 
      bandnuevo, listroutime.uldl, fas_routines_product_sn.sn ,fas_tree_measure.totalpass 
    order by listroutime.idorden asc
    ");
 
   
      
         $sql->execute();
         
         $resultado = $sql->fetchAll();
         $entrotienedatos="N";
         $pas=1;
          foreach ($resultado as $row) 
          {
            $entrotienedatos="Y";
            $esgris="Y";
          
            if ($row['sn']  <> '')
            {

               $ultejecucion = "divorden".$row['idorden'];

              if ($row['totalpass']  ==1)
              {
                $esgris="N";
                $tt=1;
                ?>
                	<div class="step_borde_verde" id="divorden<?php echo $row['idorden'];?>" name="divorden<?php echo $row['idorden'];?>" onclick="posicionarme_div('<?php echo "divorden".$row['idorden']; ?>')">
                  <span class="badge badge-success">Passed</span> <b> <?php echo " [ Band: ".$row['bandnuevo']." - ULDL: ".$row['uldl']." ]";?></b> <br>
                  <span class="  colorazulfiplex"><b>&nbsp; <?php echo $row['script']." &nbsp;<br>";?></b></span>
                    Duration: <b><i class='far fa-clock'></i> <?php echo $row['duration'];?> </b>        
                    <br>   
                  </div>
                <?php
                  
              }
              if ($row['totalpass']  == 0)
              {
                $esgris="N";
                $tt=0;
                ?>
                	<div class="step_borde_rojo" id="divorden<?php echo $row['idorden'];?>" name="divorden<?php echo $row['idorden'];?>"  onclick="posicionarme_div('<?php echo "divorden".$row['idorden']; ?>')">
                  <span class="badge badge-danger">Not Passed</span> <b> <?php echo " [ Band: ".$row['bandnuevo']." - ULDL: ".$row['uldl']." ]";?></b> <br>
                  <span class="  colorazulfiplex"><b>&nbsp; <?php echo $row['script']." &nbsp;<br>";?></b></span>
                    Duration: <b><i class='far fa-clock'></i> <?php echo $row['duration'];?> </b>        
                    <br>   
                  </div>

 
                <?php
              }
            }
              if ($esgris  == "Y")
              {
                
                $tt=0;
                ?>
                	<div class="step_borde_gris" id="divorden<?php echo $row['idorden'];?>" name="divorden<?php echo $row['idorden'];?>"  onclick="posicionarme_div('<?php echo "divorden".$row['idorden']; ?>')">
                    <b> <?php echo " [ Band: ".$row['bandnuevo']." - ULDL: ".$row['uldl']." ]";?></b> <br>
                  <span class="  colorazulfiplex"><b>&nbsp; <?php echo $row['script']." &nbsp;<br>";?></b></span>
                      
                    <br>   
                  </div>

 
                <?php
              }
             
          }

          if ( $entrotienedatos=="N")
          {
           
              ?>
           <div class="card-body">
                <div class="alert alert-danger alert-dismissible"> 
                  <h5><i class="icon fas fa-ban"></i> Attention!</h5>
                  No routines found for the idruninfo and applied filters
                </div>
                  
                </div>
              <?php

          }
          else
          {
            ?>

<script type="text/javascript">
 
														 posicionarme_div('<?php echo $ultejecucion;   ?>')
																</script>
 

            <?php
          }

?>
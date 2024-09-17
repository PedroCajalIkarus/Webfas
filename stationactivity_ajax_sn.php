<?php
 
// Desactivar toda notificación de error
error_reporting(0);
// Notificar todos los errores de PHP (ver el registro de cambios)
//error_reporting(E_ALL);
 include("db_conect.php"); 
 

$paramfecha =$_REQUEST['pf'];
$paramstation =$_REQUEST['pst'];
$parastation =$_REQUEST['station'];
$idrun =$_REQUEST['idrun'];
$wk= $_REQUEST['idrun'];

 	session_start(); 
    $where1="";
    $where2="";

    if ($wk=="na")
{
	$where1="";
}
else
{
	$where3=" and  extract(week from dateserver::date) =".$wk;
	$where3a=" and  extract(week from datetime::date) =".$wk;
}

    if($paramfecha =="na")
    {
      $where1="";
    }
    else
    { 
     $where1="and to_char(dateserver, 'YYYY-MM-DD') = '".$paramfecha."'";
    }

    if($paramstation =="na")
    {
      $where2="";
    }
    else
    { 
     $where2="and runinfodb.userruninfo = '".$paramstation."' ";
    }

 
 
    $sql = $connect->prepare("
    
    select distinct  losdatos.*
	from
	(

		select unitsnmostrar, max(dateserver) as maxfecha
		from (
          
          select   distinct station , fas_calibration_result_f.modelciu as modelciu_f,fas_calibration_result.modelciu as modelciu_t, 
        fas_routines_product_sn.sn as unitsnmostrar, fas_calibration_result_f.unitsn  as unintfalse, fas_calibration_result.unitsn  as unittrue, 
        fas_routines_product_sn.idruninfo , dateserver
                  
        from fas_routines_product_sn
      inner join runinfodb
      on fas_routines_product_sn.idruninfo = runinfodb.idruninfo 
      left join fas_calibration_result
      on fas_calibration_result.idruninfo = fas_routines_product_sn.idruninfo and
      fas_calibration_result.unitsn = fas_routines_product_sn.sn and
        fas_calibration_result.totalpass is true
      left join fas_calibration_result as fas_calibration_result_f
      on fas_calibration_result_f.idruninfo = fas_routines_product_sn.idruninfo and
      fas_calibration_result_f.unitsn = fas_routines_product_sn.sn and
        fas_calibration_result_f.totalpass is not true
      where dateserver  > NOW() - INTERVAL '15 DAY' ". $where1.$where2.$where3."
      
      and (fas_calibration_result_f.unitsn is not null or fas_calibration_result.unitsn is not null )
      order by dateserver

      ) as cc3
		group by unitsnmostrar
	) as losunicos
	inner join 
	(

    select   distinct station , fas_calibration_result_f.modelciu as modelciu_f,fas_calibration_result.modelciu as modelciu_t, 
    fas_routines_product_sn.sn as unitsnmostrar, fas_calibration_result_f.unitsn  as unintfalse, fas_calibration_result.unitsn  as unittrue, 
    fas_routines_product_sn.idruninfo , dateserver
              
    from fas_routines_product_sn
  inner join runinfodb
  on fas_routines_product_sn.idruninfo = runinfodb.idruninfo 
  left join fas_calibration_result
  on fas_calibration_result.idruninfo = fas_routines_product_sn.idruninfo and
  fas_calibration_result.unitsn = fas_routines_product_sn.sn and
    fas_calibration_result.totalpass is true
  left join fas_calibration_result as fas_calibration_result_f
  on fas_calibration_result_f.idruninfo = fas_routines_product_sn.idruninfo and
  fas_calibration_result_f.unitsn = fas_routines_product_sn.sn and
    fas_calibration_result_f.totalpass is not true
  where dateserver  > NOW() - INTERVAL '15 DAY' ". $where1.$where2.$where3."
  
  and (fas_calibration_result_f.unitsn is not null or fas_calibration_result.unitsn is not null )
  order by dateserver

    ) as losdatos
	on losdatos.unitsnmostrar		= losunicos.unitsnmostrar and 
	losdatos.dateserver			= losunicos.maxfecha
    ");
  

  ?>

<div class="col-md-8">
   <h6   class="colorazulfiplex "><b> Date: <?php if ($paramfecha <> "na" ) {  echo $paramfecha;  } else { echo "ALL"; } ?> || Station: <?php  if ($parastation <> "na" ) {    echo $parastation; } else { echo "ALL"; }  if ($wk <> "") { echo " - Week: ".$wk; }?></b></h6>
<div class="card-body p-0">
                <ul class="products-list product-list-in-card pl-2 pr-2">
                 
  <?php
      
         $sql->execute();
         
         $resultado = $sql->fetchAll();
         $entrotienedatos="N";
         $pas=1;
         echo "<b>Quantity:</b> ".count($resultado );
          foreach ($resultado as $row) 
          {
            $entrotienedatos="Y";
            
            $ultejecucion = "divorden".$row['idorden'];

              if ($row['unittrue']  <> "")
              {
                $esgris="N";
                $tt=1;
                ?>
                  <li class="item">
                    <div class="product-img">
                    <img src="img/dh7Sisometric50pxx50px.png" width="40px"  class="img-size-50">
                    </div>
                    <div class="product-info">
                      <a href="javascript:void(0)" class="product-title"><?php echo $row['unitsnmostrar']; ?><br>
                     <a href="logdb.php?idab=<?php echo  $row['idruninfo']; ?>" target="_blank"> <i class="far fa-eye"></i> View ActivityLog </a> &nbsp;&nbsp;||&nbsp;&nbsp;
                     <a href="autotestboxtimeline.php?idr=<?php echo  $row['idruninfo']; ?>" target="_blank"> <i class="far fa-clock"></i> View Auto Calibrate - TimeLine </a> 
                         
                        <span class="badge badge-pill badge-success float-right">PASSED</span> </a>
                      <span class="product-description">
                      <?php echo $row['modelciu_t']; ?> ::::
                      <i class='fas fa-desktop'></i>
                      <?php echo $row['station']; ?>

                      </span>
                    </div>
                  </li>
             
                <?php
                  
              }
            else
              {
                $esgris="N";
                $tt=0;
                ?>
           

                  <li class="item">
                    <div class="product-img">
                    <img src="img/dh7Sisometric50pxx50px.png" width="40px"  class="img-size-50">
                    </div>
                    <div class="product-info">
                      <a href="javascript:void(0)" class="product-title"><?php echo $row['unitsnmostrar']; ?>
                      <br>
                     <a href="logdb.php?idab=<?php echo  $row['idruninfo']; ?>" target="_blank"> <i class="far fa-eye"></i> View ActivityLog </a> &nbsp;&nbsp;||&nbsp;&nbsp;
                     <a href="autotestboxtimeline.php?idr=<?php echo  $row['idruninfo']; ?>" target="_blank"> <i class="far fa-clock"></i> View Auto Calibrate - TimeLine </a> 
                         
                     
                      <span class="badge badge-pill badge-danger float-right">NOT PASSED</span></a>
                      <span class="product-description">
                      <?php echo $row['modelciu_f']; ?> ::::
                      <i class='fas fa-desktop'></i>
                      <?php echo $row['station']; ?>
                      </span>
                    </div>
                  </li>
             
 
                <?php
              }
            }
            
              
        ?>
 
                </ul>
              </div>
        <?php     
       

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
       

?>
 </div>
 
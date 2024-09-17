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
   $id_sn =$_POST['vvsn'];
   
 

    $sql = $connect->prepare("	select distinct fas_routines_process_sn.sn ,fas_routines_process_sn.idorder , titlestep as script, fas_routines_process_sn.iduniqueop ,maxduration as duration,
    fas_times_type.timename, fas_outcome_integral.v_boolean::integer as totalpass ,
    COALESCE(fas_outcome_integralband.v_integer,9999) as idbandunniqueop,
    fas_outcome_integraluldl.v_integer as iduldluniqueop
    
    from fas_routines_process_sn 
    inner join fas_routines_steps on fas_routines_steps.idstep = fas_routines_process_sn.idstep 
    inner join fas_step on fas_step.instance = fas_routines_steps.instance 
    left join 
    (
      select  distinct sn ,idorder , fas_routines_process_sn.idscript , fas_routines_process_sn.iduniqueop , fas_times.idtimetype, max(fas_times.duration) as maxduration
    from fas_routines_process_sn 
    inner join fas_routines_steps on fas_routines_steps.idstep = fas_routines_process_sn.idstep 
    inner join fas_step on fas_step.instance = fas_routines_steps.instance 
    inner join fas_times on fas_times.iduniqueop = fas_routines_process_sn.iduniqueop and fas_times.idsinglemeasure is null  
    where sn = '".$id_sn."' and idruninfodb = ".$idrun." and 
    idrev in (select max(idrev) from fas_routines_process_sn where sn = '".$id_sn."' and idruninfodb = ".$idrun.") 
    group by  sn ,idorder ,  fas_routines_process_sn.idscript , fas_routines_process_sn.iduniqueop, fas_times.idtimetype
    
    ) as lostimes
    on 
    lostimes.sn 			=	fas_routines_process_sn.sn and
    lostimes.idorder		=	fas_routines_process_sn.idorder and 
    lostimes.idscript			=	fas_routines_process_sn.idscript and
    lostimes.iduniqueop		=	fas_routines_process_sn.iduniqueop
    left join fas_times_type on fas_times_type.idtimetype = lostimes.idtimetype 
    left join fas_outcome_integral on fas_outcome_integral.reference= fas_routines_process_sn.iduniqueop AND 
    idfasoutcomecat = 1 AND idtype = 0 and fas_outcome_integral.v_boolean is not null
    
    left join fas_outcome_integral as fas_outcome_integralband on fas_outcome_integralband.reference= fas_routines_process_sn.iduniqueop AND 
    fas_outcome_integralband.idfasoutcomecat = 1 AND fas_outcome_integralband.idtype = 1 
    
    left join fas_outcome_integral as fas_outcome_integraluldl on fas_outcome_integraluldl.reference= fas_routines_process_sn.iduniqueop AND 
    fas_outcome_integraluldl.idfasoutcomecat = 1 AND fas_outcome_integraluldl.idtype = 1 
    
     
    where fas_routines_process_sn.sn = '".$id_sn."' and idruninfodb = ".$idrun." and 
    idrev in (select max(idrev) from fas_routines_process_sn where sn = '".$id_sn."' and idruninfodb = ".$idrun.") 
    order by idorder , idbandunniqueop, iduldluniqueop
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
//echo "Totalpass:".$row['totalpass']."-".$row['script']."<br>";
              if ($row['totalpass']  ===1)
              {
                $esgris="N";
                $tt=1;
                ?>
                	<div class="step_borde_verde" id="divorden<?php echo $row['idorden'];?>" name="divorden<?php echo $row['idorden'];?>" onclick="posicionarme_div('<?php echo "divorden".$row['idorden']; ?>')">
                  <span class="badge badge-success">Passed</span>  <br>
                  <?php if ($row['idbandunniqueop'] == "9999")
                  {
                    ?>
                   <span class="  colorazulfiplex"><b>&nbsp; <?php echo $row['script']." &nbsp;<br>";?></b><br></span>
                    <?php
                  }
                  else
                  {
                      ?><span class="  colorazulfiplex"><b>&nbsp; <?php echo $row['script']." &nbsp;<br>Band:".$row['idbandunniqueop']."-ULDL:".$row['iduldluniqueop'];?></b><br></span>
                      <?php
                  }
                  ?>
                  
                    Duration: <b><i class='far fa-clock'></i> <?php echo $row['duration'];?> </b>        
                    <br>   
                  </div>
                <?php
                  
              }
              if ($row['totalpass']  === 0)
              {
                $esgris="N";
                $tt=0;
                ?>

                  <div class="step_borde_rojo" id="divorden<?php echo $row['idorden'];?>" name="divorden<?php echo $row['idorden'];?>" onclick="posicionarme_div('<?php echo "divorden".$row['idorden']; ?>')">
                  <span class="badge badge-danger">Not Passed</span> <br> 
                  <?php if ($row['idbandunniqueop'] == "9999")
                  {
                    ?>
                   <span class="  colorazulfiplex"><b>&nbsp; <?php echo $row['script']." &nbsp;<br>";?></b><br></span>
                    <?php
                  }
                  else
                  {
                      ?><span class="  colorazulfiplex"><b>&nbsp; <?php echo $row['script']." &nbsp;<br>Band:".$row['idbandunniqueop']."-ULDL:".$row['iduldluniqueop'];?></b><br></span>
                      <?php
                  }
                  ?>
                  
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
                  <span class="badge badge-warning">Not Executed</span> <br>                   
                  <?php if ($row['idbandunniqueop'] == "9999")
                  {
                    ?>
                   <span class="  colorazulfiplex"><b>&nbsp; <?php echo $row['script']." &nbsp;<br>";?></b><br></span>
                    <?php
                  }
                  else
                  {
                      ?><span class="  colorazulfiplex"><b>&nbsp; <?php echo $row['script']." &nbsp;<br>Band:".$row['idbandunniqueop']."-ULDL:".$row['iduldluniqueop'];?></b><br></span>
                      <?php
                  }
                  ?><br>
                  
                </span>
                      
                    
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
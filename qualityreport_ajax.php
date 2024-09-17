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
    $where1a="";

    if ($wk=="na")
{
	$where3="";
}
else
{
	$where3=" and  extract(week from datetimecheck::date) =".$wk;
	$where3a=" and  extract(week from datetime::date) =".$wk;
}

    if($paramfecha =="na")
    {
      $where1="";
    }
    else
    { 
     $where1="and to_char(datetimecheck, 'YYYY-MM-DD') = '".$paramfecha."'";
     $where1a="and to_char(datetime, 'YYYY-MM-DD') = '".$paramfecha."'";
    }

    if($paramstation =="na")
    {
      $where2="";
    }
    else
    { 
     $where2="  ";
    }

 
 

  

  ?>

<div class="col-md-10">
   <h6   class="colorazulfiplex "><b> Date: <?php if ($paramfecha <> "na" ) {  echo $paramfecha;  } else { echo "ALL"; }   if ($wk <> "na") { echo " - Week: ".$wk; }?></b></h6>
<div class="card-body p-0">
            
  <?php
      

      $sqlmm = $connect->prepare("    
	  
      select fas_survey.idsurvey ,  count(distinct fas_survey_responses_bysn.sn) as cc_sn, namesurvey, count(distinct lospass.sn) as lospasscc,count(distinct losnopasan.sn) as losnopasancc
      from fas_survey_responses_bysn
      inner join fas_survey
      on fas_survey.idsurvey = fas_survey_responses_bysn.idsurvey
      inner join 
      (  select distinct idsurvey, so, sn 
          from fas_survey_responses_bysn
          where  fas_survey_responses_bysn.datetimecheck  > NOW() - INTERVAL '30  DAY'  ".$where1.$where2.$where3."
          group by  idsurvey, so, sn
          having count(*) =1
           
      ) as lospass
      on lospass.idsurvey = fas_survey_responses_bysn.idsurvey
      left join 
      (  select distinct idsurvey, so, sn 
          from fas_survey_responses_bysn
          where  fas_survey_responses_bysn.datetimecheck  > NOW() - INTERVAL '30  DAY'  ".$where1.$where2.$where3."
          group by  idsurvey, so, sn
          having count(*) >1
           
      ) as losnopasan
      on losnopasan.idsurvey = fas_survey_responses_bysn.idsurvey
      where fas_survey_responses_bysn.datetimecheck  > NOW() - INTERVAL '30  DAY' ".$where1.$where2.$where3."
      group by fas_survey.idsurvey,  namesurvey
          
    
      ");
      $sqlmm->execute();
         
      $resultadom = $sqlmm->fetchAll();

      ?>
      <table class="table table-striped table-bordered table-sm "  > 
        <thead>
          <tr>
            <th class="bg-primary "> Surver </th>
            <th class="bg-primary text-center "> Total quantity </th>
            <th class="bg-primary text-center "> Passed </th>
            <th class="bg-primary text-center "> Failed </th>
            
          </tr>
        </thead>
        <tbody >
        <?php
     $total_unit_passed_finaltest=0;
     $total_faliled=0;
          foreach ($resultadom as $row2) 
          {
            ?>
            <tr><td><?php echo  $row2['namesurvey'];  ?> &nbsp;&nbsp; <a href='#' onclick="view_stat('<?php echo $wk;?>','<?php echo $paramfecha;?>')"><i class="nav-icon 	fas fa-chart-line"></i></a></td>
            <?php			
            $avg_pass= round (($row2['lospasscc'] * 100)/ $row2['cc_sn']);
            $avg_nopass= 		round(	($row2['losnopasancc'] * 100)/ $row2['cc_sn']);
                echo "<td class='text-center'>".$row2['cc_sn']."</td>";         
                echo "<td class='text-center'><b>".$row2['lospasscc']."&nbsp; <span class='float-right text-success'>  ". $avg_pass." %</span></b></td>";
                echo "<td class='text-center'><b>".$row2['losnopasancc']."&nbsp; <span class='float-right text-danger'>   ". $avg_nopass." %</span></b></td></tr>";  

                if ($row2['namesurvey'] =="FINAL INSPECTION")
                {
                  $total_unit_passed_finaltest=$row2['cc_sn'];
                  $total_faliled = $total_faliled + $row2['losnopasancc'];
                }
                else
                {
                  $total_faliled = $total_faliled + $row2['losnopasancc'];
                }
          }
          ?>
          <tr>
              <td></td>
              <td></td>
              <td colspan="2" class="text-right"><b>First pass  Yield:</b>&nbsp; <?php echo round($total_unit_passed_finaltest / ($total_unit_passed_finaltest + $total_faliled),2)*100; echo " %";
            //  echo "*----*";
             // echo $total_unit_passed_finaltest."---".$total_faliled; 
              ?></td>
          </tr>
  

          <?php 
      

      $sqlmm = $connect->prepare("    
	    select fas_survey.idsurvey ,fas_survey_responses_bysn.usercheck, fascategory,  count(distinct fas_survey_responses_bysn.sn) as cc_sn, namesurvey, count(distinct lospass.sn) as lospasscc,count(distinct losnopasan.sn) as losnopasancc
      from fas_survey_responses_bysn
      inner join fas_survey
      on fas_survey.idsurvey = fas_survey_responses_bysn.idsurvey
      inner join userfas
      on userfas.username = fas_survey_responses_bysn.usercheck
      inner join 
      (  select distinct idsurvey, so, sn ,usercheck
          from fas_survey_responses_bysn
          where  fas_survey_responses_bysn.datetimecheck  > NOW() - INTERVAL '30  DAY'     ".$where1.$where2.$where3."
          group by  idsurvey, so, sn, usercheck
          having count(*) =1
           
      ) as lospass
      on lospass.idsurvey = fas_survey_responses_bysn.idsurvey and
	  lospass.usercheck = fas_survey_responses_bysn.usercheck
      left join 
      (  select distinct idsurvey, so, sn ,usercheck
          from fas_survey_responses_bysn
          where  fas_survey_responses_bysn.datetimecheck  > NOW() - INTERVAL '30  DAY'     ".$where1.$where2.$where3."
          group by  idsurvey, so, sn, usercheck
          having count(*) >1
           
      ) as losnopasan
      on losnopasan.idsurvey = fas_survey_responses_bysn.idsurvey and
	  losnopasan.usercheck = fas_survey_responses_bysn.usercheck
      where fas_survey_responses_bysn.datetimecheck  > NOW() - INTERVAL '30  DAY'   ".$where1.$where2.$where3."
      group by fas_survey.idsurvey,fas_survey_responses_bysn.usercheck,  namesurvey, fascategory
          
    
      ");
      $sqlmm->execute();
         
      $resultadom = $sqlmm->fetchAll();

      ?>
      
          <tr>
            <th class="bg-primary "> Surver - Category </th>
            <th class="bg-primary text-center "> Total quantity </th>
            <th class="bg-primary text-center "> Passed </th>
            <th class="bg-primary text-center "> Failed </th>
          </tr>
     
        <?php
     
          foreach ($resultadom as $row2) 
          {
            ?>
            <tr><td><?php echo  $row2['namesurvey']." - ".$row2['fascategory'];  ?> </td>
            <?php			
            $avg_pass= round (($row2['lospasscc'] * 100)/ $row2['cc_sn']);
            $avg_nopass= 		round(	($row2['losnopasancc'] * 100)/ $row2['cc_sn']);
                echo "<td class='text-center'>".$row2['cc_sn']."</td>";         
                echo "<td class='text-center'><b>".$row2['lospasscc']."&nbsp; <span class='float-right text-success'>  ". $avg_pass." %</span></b></td>";
                echo "<td class='text-center'><b>".$row2['losnopasancc']."&nbsp; <span class='float-right text-danger'>   ". $avg_nopass." %</span></b></td></tr>";  
       
          }
          ?>
 <tr>
            <th class="bg-primary "> Steps </th>
            <th class="bg-primary text-center "> Total quantity </th>
            <th class="bg-primary text-center "> Passed </th>
            <th class="bg-primary text-center "> Failed </th>
          </tr>






          <?php
          /////------- 2 da tabla
            $sqlmm2 = $connect->prepare("
          select totalpass, count(unitsn) as cantsn , 
              CASE
                        WHEN losciumadres.modelciu is null  AND calibrationscript = false THEN 'FINAL_CHECK'
                        WHEN losciumadres.modelciu is null  AND calibrationscript = true THEN 'FINAL_CHECK'
                    WHEN losciumadres.modelciu is not null  AND calibrationscript = false THEN 'AFTER_BURNING'
                    WHEN losciumadres.modelciu is not null  AND calibrationscript = true THEN 'CALIBRATION'
                        
                    END tipoexec
                  
              from fas_calibration_result
              
                left join
                (select distinct  modelciu from products where  idproduct in (select distinct idproduct from products_attributes where v_boolean= true and idattribute = 0) 
                ) as losciumadres
                on losciumadres.modelciu = fas_calibration_result.modelciu
              where idruninfo in (select distinct idrununfo
                from  fas_tree_measure
                where totalpass is not null  and idrununfo < 30000000000    ".$where1a.$where3a." )
                   and totalpass is not null   and unitsn like '%FU'
                group by tipoexec, totalpass order by tipoexec ");

  
            
                $sqlmm2->execute();         
                $resultadom2 = $sqlmm2->fetchAll();
                $tempid = 'a';
                $v_total1=0;
                $v_totalpass=0;
                $v_totalfail=0;
                foreach ($resultadom2 as $row2) 
                {
                    if ($tempid != 'a' &&   $tempid != $row2['tipoexec']  )
                    {
                     
                       ?>
                       <tr><td><?php echo  $nombre;  ?></td>
                       <?php			
                       $avg_pass= round (($v_totalpass * 100)/ $v_total1);
                       $avg_nopass= 		round(	( $v_totalfail * 100)/$v_total1);
                           echo "<td class='text-center'>".$v_total1."</td>";         
                           echo "<td class='text-center'><b>".$v_totalpass."&nbsp; <span class='float-right text-success'>  ". $avg_pass." %</span></b></td>";
                           echo "<td class='text-center'><b>". $v_totalfail."&nbsp; <span class='float-right text-danger'>   ". $avg_nopass." %</span></b></td></tr>";  
                           $tempid = '';
                           $v_total1=0;
                           $v_totalpass=0;
                           $v_totalfail=0;

                           $tempid= $row2['tipoexec'];
                      $v_total1=  $v_total1 +  $row2['cantsn'];
                      $nombre =  $row2['tipoexec'];

                      if ( $row2['totalpass']   == false)
                      {
                        $v_totalfail= $row2['cantsn'];
                      }
                      else
                      {
                        $v_totalpass= $row2['cantsn'];
                      }

                    }
                    else
                    {
                      $tempid= $row2['tipoexec'];
                      $v_total1=  $v_total1 +  $row2['cantsn'];
                      $nombre =  $row2['tipoexec'];

                      if ( $row2['totalpass']   == false)
                      {
                        $v_totalfail= $row2['cantsn'];
                      }
                      else
                      {
                        $v_totalpass= $row2['cantsn'];
                      }

                 

                    }
         
             
                }
                ?>
                <tr><td><?php echo  $nombre;  ?></td>
                <?php			
                $avg_pass= round (($v_totalpass * 100)/ $v_total1);
                $avg_nopass= 		round(	( $v_totalfail * 100)/$v_total1);
                    echo "<td class='text-center'>".$v_total1."</td>";         
                    echo "<td class='text-center'><b>".$v_totalpass."&nbsp; <span class='float-right text-success'>  ". $avg_pass." %</span></b></td>";
                    echo "<td class='text-center'><b>". $v_totalfail."&nbsp; <span class='float-right text-danger'>   ". $avg_nopass." %</span></b></td></tr>";  
                
          ?>
      </table>
      <?php


      $sql = $connect->prepare("
                 select * from 
                    (
                        select  namesurvey,idsurveyresponse, sn, so, modelciu, status_sn, datetimecheck, usercheck from fas_survey_responses_bysn
                        inner join fas_survey
                        on fas_survey.idsurvey = fas_survey_responses_bysn.idsurvey
                        where datetimecheck  > NOW() - INTERVAL '30  DAY' ".$where1.$where2.$where3." order by datetimecheck

                     
                      ) as a1
                      union
                        select * from (
                        select CASE WHEN losciumadres.modelciu is null AND calibrationscript = false THEN 'FINAL_CHECK' WHEN losciumadres.modelciu is null AND calibrationscript = true 
                        THEN 'FINAL_CHECK' WHEN losciumadres.modelciu is not null AND calibrationscript = false THEN 'AFTER_BURNING' 
                        WHEN losciumadres.modelciu is not null AND calibrationscript = true THEN 'CALIBRATION' END tipoexec ,
                        0,unitsn, so_soft_external, fas_calibration_result.modelciu, 
                        
                          CASE WHEN totalpass is true  THEN 'PASS'
                          WHEN totalpass is false  THEN 'FAIL'
                          end
                          ,dateinfom, userruninfo  
                        from fas_calibration_result left join (select distinct modelciu from products
                         where idproduct in (select distinct idproduct from products_attributes where v_boolean= true and idattribute = 0) ) as losciumadres
                          on losciumadres.modelciu = fas_calibration_result.modelciu inner join runinfodb on runinfodb.idruninfodb = fas_calibration_result.idruninfo 
                          inner join orders_sn on orders_sn.wo_serialnumber = fas_calibration_result.unitsn  
                           where fas_calibration_result.idruninfo in (select distinct idrununfo from fas_tree_measure where totalpass is not null 
                           ".$where1a.$where3a." and idrununfo < 30000000000 )
                            and totalpass is not null and unitsn like '%FU'
	                    ) as a3     ");

                 
         $sql->execute();
         
         $resultado = $sql->fetchAll();
         $entrotienedatos="N";
         $pas=1;
         ?>
         <table class="table table-striped table-bordered table-sm dataTable no-footer" name="tblfilter0" id="tblfilter0" role="grid" aria-describedby="tblfilter0_info"> 
 <thead>
 <tr>
 <th class="bg-primary "> SO </th>
 <th class="bg-primary "> CIU </th>
 <th class="bg-primary "> SN </th>
 <th class="bg-primary "> Survery </th>
 
 <th class="bg-primary "> Status </th>
 <th class="bg-primary "> Datetime </th>
 <th class="bg-primary "> User </th>
 

 
 
 
 </tr>
 </thead>
 <tbody>
         <?php
     
          foreach ($resultado as $row2) 
          {
            $entrotienedatos="Y";
            
            $ultejecucion = "divorden".$row2['idorden'];
            $indxtablaadd=0;
            ?>
           <td>
              <?php echo  $row2['so'];  ?></td>
           <?php						
            echo "<td>".$row2['modelciu'] ."</td>";  
            echo "<td>".$row2['sn']."</td>";  
            echo "<td>".$row2['namesurvey']."</td>";  
           
             if ($row2['status_sn']=="PASS")
             {
               ?><td>
              <span data-toggle="tooltip" title="" class="badge  bg-green ">										
              <?php echo "PASS"; ?>			 
              </span></td>
              <?php 
             }
             else
             {
               ?><td>
                 <span data-toggle="tooltip" title="" class="badge  bg-red ">										
                 <?php echo "FAIL"; ?>		 
               </span></td>
               <?php
             }
          //  echo "<td>".$row2['status_sn']."</td>";
            echo "<td>".$row2['datetimecheck']."</td>";
            echo "<td>".$row2['usercheck']."</td>";
          
        
           
             
           
            echo "</tr>";
          }
       
       ?>
 </tbody>
        </table>   
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
 <script type="text/javascript">
														$('#tblfilter0').DataTable({searching: true, paging: true, info: false, pageLength: 500} );
														$("#tblfilter0_length").html('');
											 		//	$("#tblfilter0_length").html($("#tblfilter0_filter").html());
													//	$("#tblfilter0_filter").html('');
																</script>
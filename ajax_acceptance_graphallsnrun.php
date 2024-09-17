<!DOCTYPE html>
<?php 

// Desactivar toda notificación de error
error_reporting(0);
// Notificar todos los errores de PHP (ver el registro de cambios)
//error_reporting(E_ALL);
 include("db_conect.php"); 
 
 	session_start();
 
  if(isset($_SESSION["timeout"])){
        // Calcular el tiempo de vida de la sesión (TTL = Time To Live)
	//	echo "***********hola".time() - $_SESSION["timeout"];
        $sessionTTL = time() - $_SESSION["timeout"];
        if($sessionTTL > $inactividad){
			session_unset();
            session_destroy();
            header("Location: http://".$ipservidorapache."/index.php?t=timeoutinactivity");
        }
    }
	else
	{
			session_unset();
            session_destroy();
            header("Location: http://".$ipservidorapache."/index.php?t=notcookietimeout");
        
	}
	
 
	
	$status = $connect->getAttribute(PDO::ATTR_CONNECTION_STATUS);
	
	if ($status !="Connection OK; waiting to send.")
	{
	
		header("Location: http://".$ipservidorapache."/".$folderservidor."/errorconect.php");
		exit;
		
	}

?>
   
						<p align="center">
						<canvas id="grafico-chart1" height="200"></canvas>
</p>
						<?php

//graphallsnrun.php?pfd='+txtfechad+'&pfh='+txtfechah+'&elscr='+elscr
$V_elscript = $_REQUEST['elscr'];
$V_fechadesde = $_REQUEST['pfd'];
$V_fechaha = $_REQUEST['pfh'];


							$query_listagraf = "
							 
							select distinct  coalesce(fas_outcome_integral_tp.v_boolean::integer,3) as tpsnrun, fas_outcome_integral.* 
							from fas_outcome_integral
							inner join (
								select losdatos.*
								from (
									select distinct scriptname,  fas_outcome_integral.reference  
															from fas_outcome_integral
															inner join fas_script_type
															on fas_script_type.idscripttype = fas_outcome_integral.v_integer
															where idfasoutcomecat = 0 and idtype = 12 and 
															v_integer =".$V_elscript."
									 ) losdatos
									inner join fas_outcome_integral
									on fas_outcome_integral.reference = losdatos.reference
									where fas_outcome_integral.idtype = 16 and  v_string not in (  

										select username from userfas where iduserfas in(
											select iduserfas
											from userfas_attributes
											where idattribute_user = 1)
																	)
									   ) as losrun
							on losrun.reference 	=   fas_outcome_integral.reference and
							   fas_outcome_integral.idfasoutcomecat = 0 and 
							   fas_outcome_integral.idtype = 4
							   inner join (
                             
								select distinct fas_outcome_integral.v_string, max(fas_outcome_integral.datetimeref) as maxfecha
								   from (
								 select  * 
								 from fas_outcome_integral
								 inner join fas_script_type
								 on fas_script_type.idscripttype = fas_outcome_integral.v_integer
								 where idfasoutcomecat = 0 and idtype = 12 and 
								 v_integer =".$V_elscript." AND fas_outcome_integral.datetimeref between '".$V_fechadesde."' AND  '".$V_fechaha." 23:59:59'
							  ) as losruntodos 
						   inner join fas_outcome_integral
							   on losruntodos.reference 	=   fas_outcome_integral.reference and
							fas_outcome_integral.idfasoutcomecat = 0 and 
							fas_outcome_integral.idtype = 4
						group by fas_outcome_integral.v_string    
							  
						  ) as losmasnfecha  
						  on losmasnfecha.v_string  =    fas_outcome_integral.v_string and
							 losmasnfecha.maxfecha  =    fas_outcome_integral.datetimeref  
							left join fas_outcome_integral as fas_outcome_integral_tp
							on fas_outcome_integral_tp.reference 	=   fas_outcome_integral.reference and
							   fas_outcome_integral_tp.idfasoutcomecat = 0 and 
							   fas_outcome_integral_tp.idtype =13   
							 where     fas_outcome_integral.datetimeref between '".$V_fechadesde."' AND  '".$V_fechaha." 23:59:59' order by datetimeref
						 
							";

					 

							$data2 = $connect->query($query_listagraf)->fetchAll();	
							
							$v_tp_true =0;
							$v_tp_false =0;
							$v_tp_abort =0;

							foreach ($data2 as $row3) 
							{
								if ( $row3['tpsnrun']==1)
								{
									$v_tp_true = $v_tp_true +1;
								}
								else
								{
									if ( $row3['tpsnrun']==0)
									{
										$v_tp_false = $v_tp_false +1;
									}
									if ( $row3['tpsnrun']==3)								
									{
										$v_tp_abort = $v_tp_abort +1;
										
									}
								}
							
							}
						
						?>
							 
						</div>
						<script type="text/javascript">
 

    var grafico1chart = $('#grafico-chart1').get(0).getContext('2d'); 
   

  //  var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
  /*
   $vlblgraf1=$vlblgraf1.",Others";
    $vdatgraf1=$vdatgraf1.",".$lodemas;
    */
    var donutData1        = {
		labels: ['Pass [<?php echo $v_tp_true; ?>] ','No Pass [<?php echo $v_tp_false; ?>]','Abort [<?php echo $v_tp_abort; ?>]'],
      datasets: [
        {
          data: [<?php echo $v_tp_true.",".$v_tp_false.",".$v_tp_abort; ?>],
          backgroundColor : [  '#28a745', '#dc3545', '#ffc107', '#993333'],
        }
      ]
    }

   
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : false,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var donutChart = new Chart(grafico1chart, {
      type: 'doughnut',
      data: donutData1,
      options: donutOptions      
    })
   
 
						</script>


<table class="table table-striped table-bordered table-sm  " name="tblfilter1" id="tblfilter1" role="grid" >
           
           <thead>
           <tr>
           <th class="bg-primary "> SN </th>
           <th class="bg-primary "> Datetime  </th>
		   <th class="bg-primary "> Runinfo  </th>
           <th class="bg-primary "> Status Run </th>
 
            
           </tr>
           </thead>
		   <tbody>
           <?php

$query_listagraf = "
							 
select distinct  coalesce(fas_outcome_integral_tp.v_boolean::integer,3) as tpsnrun, fas_outcome_integral.* ,scriptname 
from fas_outcome_integral
inner join (
	select losdatos.*
	from ( 
		select  distinct scriptname,  fas_outcome_integral.reference 
								from fas_outcome_integral
								inner join fas_script_type
								on fas_script_type.idscripttype = fas_outcome_integral.v_integer
								where idfasoutcomecat = 0 and idtype = 12 and 
								v_integer =".$V_elscript."
		 ) losdatos
		inner join fas_outcome_integral
		on fas_outcome_integral.reference = losdatos.reference
		where fas_outcome_integral.idtype = 16 and v_string not in (  

			select username from userfas where iduserfas in(
				select iduserfas
				from userfas_attributes
				where idattribute_user = 1)
										)
		   ) as losrun
on losrun.reference 	=   fas_outcome_integral.reference and
   fas_outcome_integral.idfasoutcomecat = 0 and 
   fas_outcome_integral.idtype = 4
left join fas_outcome_integral as fas_outcome_integral_tp
on fas_outcome_integral_tp.reference 	=   fas_outcome_integral.reference and
   fas_outcome_integral_tp.idfasoutcomecat = 0 and 
   fas_outcome_integral_tp.idtype =13   
 where   fas_outcome_integral.datetimeref between '".$V_fechadesde."' AND  '".$V_fechaha." 23:59:59' order by datetimeref

";

//echo $query_listagraf ;

$data = $connect->query($query_listagraf)->fetchAll();	

             foreach ($data as $row2) 
             {
            $indxtablaadd=0;
               ?>
          
              <?php						
               echo "<tr><td><b><i class='fas fa-file-alt'></i> SN:".$row2['v_string'] ."</b></td>"; 
			   echo "<td>&nbsp;&nbsp;&bull;&nbsp;&nbsp;".substr($row2['datetimeref'],0,19) ."</td>";  
               echo "<td>".$row2['reference']." &nbsp;";  
			   ?>
			   <a data-ancla="anclamyTabledib" href="#"  aria-expanded="true" onclick="mostrar_runaccept('<?php echo $row2['reference']; ?>','<?php echo $row2['scriptname']; ?>','<?php echo $row2['v_string']; ?>')">
			   
			   <i class="fas fa-eye"></i>
			</a>
		 
			 </td>  
			   <?php
               
			   if ($row2['tpsnrun']==1)
			   {
				 ?><td>
				<span data-toggle="tooltip" title="" class="badge  bg-green ">										
				<?php echo "Pass"; ?>			 
				</span></td>
				<?php 
			   }
			   if ($row2['tpsnrun']==0)
			   {
				 ?><td>
				   <span data-toggle="tooltip" title="" class="badge  bg-red ">										
				   <?php echo "Not Pass";  echo  "ajax_add_outcome_totalpass.php"; ?>		 
				 </span>
				 <?php 
				  if 	($_SESSION["g"] == "develop" ) 
				  {		
				 ?>
				 || <a href='ajax_add_outcome_totalpass.php?idr=<?php echo $row2['reference'] ?>' target="_blank" ><i class="far fa-thumbs-up" style="font-size:18px;color:blue"></i></a>
				 <?php } ?>
				</td>
				 <?php
			   }
			   if ($row2['tpsnrun']==3)
			   {
				 ?><td>
				   <span data-toggle="tooltip" title="" class="badge  bg-warning ">										
				   <?php echo "Abort";   
				  
			//	   echo  "ajax_add_outcome_totalpass.php"; ?>		 
				 </span>
				
				 <?php 
				  if 	($_SESSION["g"] == "develop" ) 
				  {		
				 ?>
				 || <a href='ajax_add_outcome_totalpass.php?idr=<?php echo $row2['reference'] ?>' target="_blank" ><i class="far fa-thumbs-up" style="font-size:18px;color:blue"></i></a>
				 <?php } ?>
				</td>
				 <?php
			   }

			   echo "  </tr>";
             }
	//		 ajax_add_outcome_totalpass.php
          ?>
		
            </tbody>
          </table>

		  <script type="text/javascript">
		//	$('#tblfilter1').DataTable({searching: true, paging: true, info: false, pageLength: 20,  order: [[ 2, "desc" ]]} );

		var tablemm = 	  $('#tblfilter1').DataTable( {
        order: [[1, 'desc'],[0, 'desc']],  "paging": true,  "pageLength": 10000,	
		columnDefs: [      {"className": "dt-left", "targets": "_all"}      ],	
        rowGroup: {
            dataSrc: [ 0 ]
        },
        columnDefs: [ {
            targets: [ 0 ],
            visible: false
        } ]
    } );

		  </script>


              </div><!-- /.card-body -->
            </div>
        
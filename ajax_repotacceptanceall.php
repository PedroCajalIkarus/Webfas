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

	if ($V_elscript == "allaceip")
	{

		$query_listagraf = "
							select COUNT(todosfinal.tpsnrun) AS QTY, todosfinal.tpsnrun,
							public.full_tree_namever_allbusiness(iduniquebranchsonprod, '') as namebranch
							from
							(
							select distinct  coalesce(fas_outcome_integral_tp.v_boolean::integer,3) as tpsnrun, fas_outcome_integral.reference,
								fas_outcome_integral.v_string
														from fas_outcome_integral
														inner join (
															select losdatos.*
															from (
																select distinct scriptname,  fas_outcome_integral.reference  
																						from fas_outcome_integral
																						inner join fas_script_type
																						on fas_script_type.idscripttype = fas_outcome_integral.v_integer
																						where idfasoutcomecat = 0 and idtype = 12 and 
																						v_integer in (select idscripttype from fas_script_type where scriptname ilike '%cep%' )
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
															 v_integer in (select idscripttype from fas_script_type where scriptname ilike '%cep%' ) 																   
																   AND fas_outcome_integral.datetimeref between '".$V_fechadesde."' AND  '".$V_fechaha." 23:59:59'
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
														 where    fas_outcome_integral.datetimeref between '".$V_fechadesde."' AND  '".$V_fechaha." 23:59:59'
								) as todosfinal
								inner join fas_outcome_integral
								on todosfinal.reference = fas_outcome_integral.reference and
								 fas_outcome_integral.idfasoutcomecat = 0 and 
								 fas_outcome_integral.idtype = 3   
								INNER JOIN fnt_select_allproducts_maxrevithsap() as  products 
								on products.modelciu = fas_outcome_integral.v_string
								where public.full_tree_namever_allbusiness(iduniquebranchsonprod, '') <> '' and public.full_tree_namever_allbusiness(iduniquebranchsonprod, '')<> 'SAP'
								GROUP BY namebranch,todosfinal.tpsnrun
								order by namebranch  
							
							";


	}
	else
	{

		$query_listagraf = "
							select COUNT(todosfinal.tpsnrun) AS QTY, todosfinal.tpsnrun,
							public.full_tree_namever_allbusiness(iduniquebranchsonprod, '') as namebranch
							from
							(
							select distinct  coalesce(fas_outcome_integral_tp.v_boolean::integer,3) as tpsnrun, fas_outcome_integral.reference,
								fas_outcome_integral.v_string
														from fas_outcome_integral
														inner join (
															select losdatos.*
															from (
																select distinct scriptname,  fas_outcome_integral.reference  
																						from fas_outcome_integral
																						inner join fas_script_type
																						on fas_script_type.idscripttype = fas_outcome_integral.v_integer
																						where idfasoutcomecat = 0 and idtype = 12 and 
																						v_integer =".$V_elscript." )
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
															 v_integer =".$V_elscript."														   
																   AND fas_outcome_integral.datetimeref between '".$V_fechadesde."' AND  '".$V_fechaha." 23:59:59'
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
														 where    fas_outcome_integral.datetimeref between '".$V_fechadesde."' AND  '".$V_fechaha." 23:59:59'
								) as todosfinal
								inner join fas_outcome_integral
								on todosfinal.reference = fas_outcome_integral.reference and
								 fas_outcome_integral.idfasoutcomecat = 0 and 
								 fas_outcome_integral.idtype = 3   
								INNER JOIN fnt_select_allproducts_maxrevithsap() as  products 
								on products.modelciu = fas_outcome_integral.v_string
								where public.full_tree_namever_allbusiness(iduniquebranchsonprod, '') <> '' and public.full_tree_namever_allbusiness(iduniquebranchsonprod, '')<> 'SAP'
								GROUP BY namebranch,todosfinal.tpsnrun
								order by namebranch  
							
							";


	}
							
				

							$data2 = $connect->query($query_listagraf)->fetchAll();	
							
							$v_tp_true =0;
							$lbl_graf="";
							$lbl_graf_pass="";
							$lbl_graf_nopass="";
							$lbl_graf_abort="";

							$v_tp_false =0;
							$v_tp_abort =0;
							$tmpnamebran="";										
							foreach ($data2 as $row3) 
							{
								if ($row3['namebranch'] == $tmpnamebran )
								{
									if ( $row3['tpsnrun']==1)
									{
										$v_tp_true = $v_tp_true + $row3['qty'];
									}
									else
									{
										if ( $row3['tpsnrun']==0)
										{
											$v_tp_false = $v_tp_false + $row3['qty'];
										}
										if ( $row3['tpsnrun']==3)								
										{
											$v_tp_abort = $v_tp_abort + $row3['qty'];
											
										}
									}
								}
								else
								{
									if ($tmpnamebran != "")
									{
										//echo "  <br>  ".$tmpnamebran."  ".$v_tp_true."  ".$v_tp_false."  ".$v_tp_abort;

										$lbl_graf=$lbl_graf."'".$tmpnamebran."',";
										$lbl_graf_pass=$lbl_graf_pass."".$v_tp_true.",";
										$lbl_graf_nopass=$lbl_graf_nopass."".$v_tp_false.",";
										$lbl_graf_abort=$lbl_graf_abort."".$v_tp_abort.",";

										$cuerpotabla =$cuerpotabla."<tr>";
										$cuerpotabla =$cuerpotabla."<td>".$tmpnamebran."</td>";
										$cuerpotabla =$cuerpotabla."<td>".$v_tp_true."</td>";
										$cuerpotabla =$cuerpotabla."<td>".$v_tp_false."</td>";
										$cuerpotabla =$cuerpotabla."<td>".$v_tp_abort."</td>";
										$cuerpotabla =$cuerpotabla."</tr>";
										$v_tp_true =0;
										$v_tp_false =0;
										$v_tp_abort =0;
									}
										
									$tmpnamebran = $row3['namebranch'] ;
								
									if ( $row3['tpsnrun']==1)
									{
										$v_tp_true = $v_tp_true + $row3['qty'];
									}
									else
									{
										if ( $row3['tpsnrun']==0)
										{
											$v_tp_false = $v_tp_false + $row3['qty'];
										}
										if ( $row3['tpsnrun']==3)								
										{
											$v_tp_abort = $v_tp_abort + $row3['qty'];
											
										}
									}
								}	
							
							}
						
						?>

</div>
<script type="text/javascript">
var grafico1chart = $('#grafico-chart1').get(0).getContext('2d');
//var grafico1chart2 = $('#grafico-chart2').get(0).getContext('2d');


//  var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
/*
 $vlblgraf1=$vlblgraf1.",Others";
  $vdatgraf1=$vdatgraf1.",".$lodemas;
  */
var donutData1 = {
    labels: ['Pass [<?php echo $v_tp_true; ?>] ', 'No Pass [<?php echo $v_tp_false; ?>]',
        'Abort [<?php echo $v_tp_abort; ?>]'
    ],
    datasets: [{
        data: [<?php echo $v_tp_true.",".$v_tp_false.",".$v_tp_abort; ?>],
        backgroundColor: ['#28a745', '#dc3545', '#ffc107', '#993333'],
    }]
}


var donutOptions = {
    maintainAspectRatio: false,
    responsive: false,
}


var data = {
    labels: [<?php echo $lbl_graf; ?>],
    datasets: [{
            label: 'PASS',
            data: [<?php echo $lbl_graf_pass; ?>],
            borderColor: '#006633',
            backgroundColor: '#009900',
            borderWidth: 2,
            borderRadius: 50,
            borderSkipped: false,
            borderSkipped: false,
        },
        {
            label: 'NO PASS',
            data: [<?php echo $lbl_graf_nopass; ?>],
            borderColor: '#cc0000',
            backgroundColor: '#ff0000',
            borderWidth: 2,
            borderRadius: 5,
            borderSkipped: false,
        },
        {
            label: 'ABORT ',
            data: [<?php echo $lbl_graf_abort; ?>],
            borderColor: '#999900',
            backgroundColor: '#cccc0c',
            borderWidth: 2,
            borderRadius: 5,
            borderSkipped: false,
        }
    ]
};

//Create pie or douhnut chart
// You can switch between pie and douhnut using the method below.
var donutChart = new Chart(grafico1chart, {
    type: 'bar',
    data: data,
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: true,
                labels: {
                    color: 'rgb(255, 99, 132)'
                }
            }
        }

    },
})

donutChart.update();
/*
var donutChart2 = new Chart(grafico1chart2, {
    type: 'line',
    data: data,
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: true,
                labels: {
                    color: 'rgb(255, 99, 132)'
                }
            }
        }

    },
})*/
</script>


<table class="table table-striped table-bordered table-sm  " name="tblfilter1" id="tblfilter1" role="grid">

    <thead>
        <tr>
            <th class="bg-primary "> Family </th>
            <th class="bg-primary "> Pass </th>
            <th class="bg-primary "> NoPass </th>
            <th class="bg-primary "> Abort </th>


        </tr>
    </thead>
    <tbody>
        <?php
		 echo $cuerpotabla;
		?>
    </tbody>
</table>

<script src="plugins/datatables/jquery.dataTables.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>

<script type="text/javascript">
//	$('#tblfilter1').DataTable({searching: true, paging: true, info: false, pageLength: 20,  order: [[ 2, "desc" ]]} );

var tablemm = $('#tblfilter1').DataTable();
</script>


</div><!-- /.card-body -->
</div>
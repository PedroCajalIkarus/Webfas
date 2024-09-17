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
							select   0 as v_booleanconvert,    'WO-SO Already Created ' as v_string , null as v_integeconvert, count( distinct fas_outcome_integral.reference) as qquantity
    
      
							from fas_outcome_integral
							inner join (
								select reference
								from fas_outcome_integral 
								where idfasoutcomecat = 0  and 
									  fas_outcome_integral.idtype =16 and 
									  v_string = 'Connector SAP-WEBFAS' and datetimeref > now() - interval '2 day'
								) as losrun
								on losrun.reference = fas_outcome_integral.reference
								and fas_outcome_integral.idfasoutcomecat in(0) and fas_outcome_integral.idtype=13
							
							inner join fas_outcome_category_type
							on fas_outcome_category_type.idfasoutcomecat = fas_outcome_integral.idfasoutcomecat and
							  fas_outcome_category_type.idtype          = fas_outcome_integral.idtype
							
							left join fas_outcome_integral as fas_outcome_integral2
							on  fas_outcome_integral2.reference       = losrun.reference and
								fas_outcome_integral2.idfasoutcomecat = 0 and
								fas_outcome_integral2.idtype          = 43
							where  fas_outcome_integral.v_boolean is false   and fas_outcome_integral2.v_string like '%Created%'
							  and fas_outcome_integral.datetimeref between '".$V_fechadesde."' AND  '".$V_fechaha." 23:59:59'
					 		union 

						 select   fas_outcome_integral.v_boolean::integer as v_booleanconvert,   fas_outcome_integral2.v_string ,  fas_outcome_integral.v_integer as v_integeconvert, count( distinct fas_outcome_integral.reference) as qquantity
    
      
						 from fas_outcome_integral
						 inner join (
							 select reference
							 from fas_outcome_integral 
							 where idfasoutcomecat = 0  and 
								   fas_outcome_integral.idtype =16 and 
								   v_string = 'Connector SAP-WEBFAS' and datetimeref > now() - interval '2 day'
							 ) as losrun
							 on losrun.reference = fas_outcome_integral.reference
							 and fas_outcome_integral.idfasoutcomecat in(0) and fas_outcome_integral.idtype=13
						 
						 inner join fas_outcome_category_type
						 on fas_outcome_category_type.idfasoutcomecat = fas_outcome_integral.idfasoutcomecat and
						   fas_outcome_category_type.idtype          = fas_outcome_integral.idtype
						 
						 left join fas_outcome_integral as fas_outcome_integral2
						 on  fas_outcome_integral2.reference       = losrun.reference and
							 fas_outcome_integral2.idfasoutcomecat = 0 and
							 fas_outcome_integral2.idtype          = 43
						 where  fas_outcome_integral.v_boolean is false  and fas_outcome_integral2.v_string <> 'The SKU is not Mother'
						 and fas_outcome_integral2.v_string not like '%Created%'
						 and fas_outcome_integral.datetimeref between '".$V_fechadesde."' AND  '".$V_fechaha." 23:59:59'
						 group by   fas_outcome_integral.v_boolean::integer ,  fas_outcome_integral.v_integer  , fas_outcome_integral2.v_string
						 union 
						  select   fas_outcome_integral.v_boolean::integer as v_booleanconvert, '' ,    fas_outcome_integral.v_integer as v_integeconvert, count( distinct fas_outcome_integral.reference) as qquantity
					   
						 
						 from fas_outcome_integral
						 inner join (
							 select reference
							 from fas_outcome_integral 
							 where idfasoutcomecat = 0  and 
								   fas_outcome_integral.idtype =16 and 
								   v_string = 'Connector SAP-WEBFAS' and datetimeref > now() - interval '2 day'
							 ) as losrun
							 on losrun.reference = fas_outcome_integral.reference
							 and fas_outcome_integral.idfasoutcomecat in(0) and fas_outcome_integral.idtype=13
						 
						 inner join fas_outcome_category_type
						 on fas_outcome_category_type.idfasoutcomecat = fas_outcome_integral.idfasoutcomecat and
						   fas_outcome_category_type.idtype          = fas_outcome_integral.idtype
						 
						 left join fas_outcome_integral as fas_outcome_integral2
						 on  fas_outcome_integral2.reference       = losrun.reference and
							 fas_outcome_integral2.idfasoutcomecat = 0 and
							 fas_outcome_integral2.idtype          = 43
							  where  fas_outcome_integral.v_boolean is true and  fas_outcome_integral.v_integer is null
							  and fas_outcome_integral.datetimeref between '".$V_fechadesde."' AND  '".$V_fechaha." 23:59:59'
						 group by   fas_outcome_integral.v_boolean::integer ,  fas_outcome_integral.v_integer  

						 union 
						 select  0 as v_booleanconvert, 'SKUMother' ,    0, count( distinct fas_outcome_integral.reference) as qquantity
					  
						
						from fas_outcome_integral
						inner join (
							select reference
							from fas_outcome_integral 
							where idfasoutcomecat = 0  and 
								  fas_outcome_integral.idtype =16 and 
								  v_string = 'Connector SAP-WEBFAS' and datetimeref > now() - interval '2 day'
							) as losrun
							on losrun.reference = fas_outcome_integral.reference
							and fas_outcome_integral.idfasoutcomecat in(0) and fas_outcome_integral.idtype=13
						
						inner join fas_outcome_category_type
						on fas_outcome_category_type.idfasoutcomecat = fas_outcome_integral.idfasoutcomecat and
						  fas_outcome_category_type.idtype          = fas_outcome_integral.idtype
						
						left join fas_outcome_integral as fas_outcome_integral2
						on  fas_outcome_integral2.reference       = losrun.reference and
							fas_outcome_integral2.idfasoutcomecat = 0 and
							fas_outcome_integral2.idtype          = 43
							 where  ((fas_outcome_integral.v_boolean is true and  fas_outcome_integral.v_integer = 1)
							        or
									( fas_outcome_integral.v_boolean is false and  fas_outcome_integral2.v_string = 'The SKU is not Mother' ))
							 and fas_outcome_integral.datetimeref between '".$V_fechadesde."' AND  '".$V_fechaha." 23:59:59'
					 

						 order by v_booleanconvert desc , v_string desc
						 
							";

				//		echo $query_listagraf;
						 


							$data2 = $connect->query($query_listagraf)->fetchAll();	
							
							$v_tp_true =0;
							$v_tp_false =0;
							$v_tp_abort =0;
							$v_nomb_label="";
							$v_value_label="";
							foreach ($data2 as $row3) 
							{
								if ( $row3['v_booleanconvert']==1)
								{
									if ( $row3['v_integeconvert']==1)
									{
										if ($v_nomb_label=="")
										{
											$v_nomb_label = $v_nomb_label." 'Ok (WO-SO Already Created)' ";
											$v_value_label= $v_value_label." ".$row3['qquantity']  ;
										}
										else
										{
											$v_nomb_label = $v_nomb_label.", 'Ok (WO-SO Already Created)' ";
											$v_value_label= $v_value_label." ,".$row3['qquantity']  ;
										}
										
									}
									else
									{
										if ($v_nomb_label=="")
										{
											$v_nomb_label = $v_nomb_label." 'Ok - [".$row3['qquantity']."] ' ";
											$v_value_label= $v_value_label." ".$row3['qquantity']  ;
										}
										else
										{
											$v_nomb_label = $v_nomb_label.", 'Ok - [".$row3['qquantity']."] ' ";
											$v_value_label= $v_value_label." ,".$row3['qquantity']  ;
										}
										
									}
								}
								else
								{
									if ($row3['v_string']=="SKUMother")
									{
										if ($v_nomb_label=="")
										{
											$v_nomb_label = $v_nomb_label." 'Bypass - [".$row3['qquantity']."] ' ";
											$v_value_label= $v_value_label." ".$row3['qquantity']  ;
										}
										else
										{
											$v_nomb_label = $v_nomb_label.", 'Bypass - [".$row3['qquantity']."]' ";
											$v_value_label= $v_value_label." ,".$row3['qquantity']  ;
										}
										
									}
									else
									{

										$vowels = array("missing parameters - ");
										$txt_a_mostrar = substr( str_replace($vowels, "", $row3['v_string']),0,30);
										if ($v_nomb_label=="")
										{
											$v_nomb_label = $v_nomb_label." 'Fail (".$txt_a_mostrar.") - [".$row3['qquantity']."]' ";
											$v_value_label= $v_value_label." ".$row3['qquantity']  ;
										}
										else
										{
											$v_nomb_label = $v_nomb_label.", 'Fail (".$txt_a_mostrar.") - [".$row3['qquantity']."]' ";
											$v_value_label= $v_value_label." ,".$row3['qquantity']  ;
										}
										
									}
									
								}

							
							}
					 
						?>
							 
						</div>
						<script src="plugins/chart.js/Chart.min.js"></script>
						<script type="text/javascript">
 

    var grafico1chart = $('#grafico-chart1').get(0).getContext('2d'); 
   

  //  var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
  /*
   $vlblgraf1=$vlblgraf1.",Others";
    $vdatgraf1=$vdatgraf1.",".$lodemas;
    */
    var donutData1        = {
		labels: [<?php echo $v_nomb_label; ?>],
      datasets: [
        {
          data: [<?php echo $v_value_label; ?>],
          backgroundColor : [ '#28A745', '#66B2FF' , '#CCCC00', '#dc3545', '#ffc107', '#993333', '#FFCC99','#9999FF'],
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
 

              </div><!-- /.card-body -->
            </div>
        
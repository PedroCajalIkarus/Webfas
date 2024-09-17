<!DOCTYPE html>
<?php 

// Desactivar toda notificación de error
error_reporting(0);


// Notificar todos los errores de PHP (ver el registro de cambios)
//error_reporting(E_ALL);
 include("db_conectbypdf.php"); 
 
 	session_start();
 
	
 /*
  if(isset($_SESSION["timeout"])){
        // Calcular el tiempo de vida de la sesión (TTL = Time To Live)
	//	echo "***********hola".time() - $_SESSION["timeout"];
        $sessionTTL = time() - $_SESSION["timeout"];
        if($sessionTTL > $inactividad){
			session_unset();
            session_destroy();
            header("Location: http://".$ipservidorapache."/index.php");
        }
    }
	else
	{
			session_unset();
            session_destroy();
            header("Location: http://".$ipservidorapache."/index.php");
        
	}
	
	$status = $connect->getAttribute(PDO::ATTR_CONNECTION_STATUS);
	
	if ($status !="Connection OK; waiting to send.")
	{
	
		header("Location: http://".$ipservidorapache."/".$folderservidor."/errorconect.php");
		exit;
		
	}
	*/
?>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIPLEX</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- daterangepicker -->
   <link rel="stylesheet" href="plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
   <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="plugins/ion-rangeslider/css/ion.rangeSlider.css">
  
  <!-- AdminLTE css -->
  <link rel="stylesheet" href="dist/css/adminlte.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  
  <link href="css/tabulator_bootstrap4.css" rel="stylesheet">
  <link rel="shortcut icon" href="fiplexcirculo-01.ico" />
  
  <link rel="stylesheet" href="toastr.css">
  
 <link href="css/tabulator_bulma.css" rel="stylesheet">
 
  
    <link rel="stylesheet" href="cssfiplex.css">
	    <link rel="stylesheet" href="css/viewer.min.css">
		 <style>
		 
		 .containermarco {
    width: 98%;
     padding-right: 7.5px; 
     padding-left: 7.5px; 
     margin-right: auto; 
     margin-left: auto; 
	}

    .pictures {
      list-style: none;
      margin: 0;
      max-width: 30rem;
      padding: 0;
    }

    .pictures > li {
    /*  border: 1px solid transparent;
      float: left;
      height: calc(100% / 2);
      margin: 0 31px 0px 15px;
      overflow: hidden;
      width: calc(100% / 2);*/
    }

    .pictures > li > img {
      cursor: zoom-in;
      width: 100%;
    }
	.rowmm {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
     margin-right: -1.5px; 
     margin-left: -1.5px; 
}


.card {
    box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
    margin-bottom: 5px;
}

.card-title {
    float: left;
    font-size: 14px;
}

.irs-grid_marco_verde {
    background: #28a745;
}
.irs-grid_marco_amarillo {
    background: #ffc107;
}
.irs-grid_marco_rojo {
    background: #dc3545;
}


.divmarco {
	  margin-top: 17.5px; 
}


.tooltipmarco {
    background-color: #0053a1;
    color:  #ffffff;
    padding: 5px 10px;
    border-radius: 4px;
    font-size: 14px;
	 opacity: 0.9;
  }
  
  	.page { width: 100%; height: 100%; }
.page_break { page-break-before: always; }

  </style>
  
</head>
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->


<script src="licencefiplex_mm.js"></script>
<script src="licencefiplex1.js"></script>
<script src="js/jquery.inactivityTimeout.js"></script>

<script src="js/popperparacalibratio.min.js"></script>

<script src="plugins/chart.js/Chart.min.js"></script>

<script src="js/viewer.js"></script>
<form name="frma" id="frma">



<input type="hidden" name="uso" id="uso" value="0">
<body style="background-color:#ffffff;" class="content-header hold-transition sidebar-mini sidebar-collapse">

  <div class="container-fluid">

   
<!-- Site wrapper -->
  <!-- Navbar -->
 							 </p>
 
   <?php


	$paramfecha =$_REQUEST['vfecha'];
    $wk= $_REQUEST['vsemana'];

		if ($wk=="na")
		{
			$where3="";
		}
		else
		{
			$where3=" and  extract(week from datetimecheck::date) =".$wk;
			 
		}

    if($paramfecha =="na")
    {
      $where1="";
    }
    else
    { 
     $where1="and to_char(datetimecheck, 'YYYY-MM-DD') = '".$paramfecha."'";
    }


 	$query_lista2 = "
   select 2 as ordermm, namesurvey, fm.idsurvey, idquestion ,descriptionq , ARRAY_AGG (      concat( chr(39) , descriptiona,chr(39))  ORDER BY idanswer    ) as arraylbl ,
   ARRAY_AGG (   cc  ) as arraycc
  from (
  
   select fas_survey_responses_bysn.idsurvey, fas_survey_responses.idquestion , fas_survey_responses.idanswer,descriptionq, descriptiona, 
    count(distinct fas_survey_responses_bysn.idsurveyresponse) as cc 
	 from fas_survey_responses_bysn 	 
	 inner join fas_survey_responses
	 on fas_survey_responses.idsurveyresponse  = fas_survey_responses_bysn.idsurveyresponse
	 inner join fas_questions
	 on fas_questions.idquestion = fas_survey_responses.idquestion
	 inner join fas_answers
	 on fas_answers.idanswer = fas_survey_responses.idanswer
	 where datetimecheck  > NOW() - INTERVAL '30 DAY'   and fas_survey_responses.idquestion <> 19         ".$where1.$where2.$where3." 
	 group by fas_survey_responses_bysn.idsurvey, fas_survey_responses.idquestion , fas_survey_responses.idanswer,descriptionq, descriptiona
	 order by descriptionq , fas_survey_responses.idanswer asc
	) as fm
  inner join fas_survey
  on fas_survey.idsurvey = fm.idsurvey
  group by idquestion ,descriptionq,fm.idsurvey,namesurvey
  union 
  select 1 as ordermm, namesurvey, fm.idsurvey, idquestion ,descriptionq , ARRAY_AGG (      concat( chr(39) , descriptiona,chr(39))  ORDER BY idanswer    ) as arraylbl ,
  ARRAY_AGG (   cc  ) as arraycc
 from (
 
  select fas_survey_responses_bysn.idsurvey, fas_survey_responses.idquestion , fas_survey_responses.idanswer,descriptionq, descriptiona, 
   count(distinct fas_survey_responses_bysn.idsurveyresponse) as cc 
  from fas_survey_responses_bysn 	 
  inner join fas_survey_responses
  on fas_survey_responses.idsurveyresponse  = fas_survey_responses_bysn.idsurveyresponse
  inner join fas_questions
  on fas_questions.idquestion = fas_survey_responses.idquestion
  inner join fas_answers
  on fas_answers.idanswer = fas_survey_responses.idanswer
  where datetimecheck  > NOW() - INTERVAL '30 DAY'   and fas_survey_responses.idquestion = 19         ".$where1.$where2.$where3." 
  group by fas_survey_responses_bysn.idsurvey, fas_survey_responses.idquestion , fas_survey_responses.idanswer,descriptionq, descriptiona
  order by descriptionq , fas_survey_responses.idanswer asc
 ) as fm
 inner join fas_survey
 on fas_survey.idsurvey = fm.idsurvey
 group by  idquestion ,descriptionq,fm.idsurvey,namesurvey
  order by  ordermm, namesurvey , descriptionq 



		 ";

    
	 
	 $data2 = $connect->query($query_lista2)->fetchAll();		

 
   ?>
 
	 
  <div class="container">
  <div class="row">
<?php

$caracteresareeemplazar = array("{", "}");


  foreach ($data2 as $rowcab) 
	 {
		?>        <div class="col-md-3"   style=" border-color: #0053a1;border-width: 1px; border-style: solid;">
	            <p align="center"> <?php echo "<b><span class='colorazulfiplex'>".$rowcab['namesurvey']."</span><br> ". $rowcab['descriptionq'];?></b><br>
                <canvas id="pieChart<?php echo $rowcab['idquestion'];?>" style="height:150px; min-height:150px;width: 250px;" name="pieChart<?php echo $rowcab['idquestion'];?>"  ></canvas>
                </p>
              <br>
              </div>
            
              <?php
              $stringcolor="";
                $pos = strpos( $rowcab['arraylbl'], "Yes");
                if ($pos === false) 
                {}
                else
                {
                  $stringcolor="'#2c8208', ";
                }
                $pos = strpos( $rowcab['arraylbl'], "No");
                if ($pos === false) 
                {}
                else
                {
                  $stringcolor= $stringcolor."'#f54242', ";
                }
                $pos = strpos( $rowcab['arraylbl'], "N/A");
                if ($pos === false) 
                {}
                else
                {
                  $stringcolor= $stringcolor."'#d9d207', ";
                }


                ///para la preg 19
                $pos = strpos( $rowcab['arraylbl'], "CrossCables");
                if ($pos === false) 
                {}
                else
                {
                  $stringcolor= $stringcolor."'#fcba03', ";
                }
                $pos = strpos( $rowcab['arraylbl'], "Defectingcable");
                if ($pos === false) 
                {}
                else
                {
                  $stringcolor= $stringcolor."'#fcba03', ";
                }
                $pos = strpos( $rowcab['arraylbl'], "Inversepolarity");
                if ($pos === false) 
                {}
                else
                {
                  $stringcolor= $stringcolor."'#a11669', ";
                }
                $pos = strpos( $rowcab['arraylbl'], "Soldering");
                if ($pos === false) 
                {}
                else
                {
                  $stringcolor= $stringcolor."'#255d80', ";
                }
              ?>
              <script>

var donutData        = {
      labels: [ <?php echo str_replace($caracteresareeemplazar, "", $rowcab['arraylbl']);;?>
      ],
      datasets: [
        {
          data: [<?php echo str_replace($caracteresareeemplazar, "", $rowcab['arraycc']);?>],
          backgroundColor : [ <?php echo $stringcolor;?> ],
        }
      ]
    }
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : false,
    }


              var pieChartCanvas = $('#pieChart<?php echo $rowcab['idquestion'];?>').get(0).getContext('2d')
    var pieData        = donutData;
    var pieOptions     = {
      maintainAspectRatio : false,
      responsive : false,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var pieChart = new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions      
    })

    </script>
		<?php			

			
	 }  
   ?>
      </div>  
  </div >
  <br>
  <table class="table table-striped table-bordered table-sm "  > 
        <thead>
          <tr>
            <th class="bg-primary "> Questions </th>
            <th class="bg-primary text-center "> Answers </th>
            <th class="bg-primary text-center "> Quantities </th>
          
          </tr>
        </thead>
        <tbody >

  <?php

$query_lista2 = "
 

select fas_survey_responses_bysn.idsurvey ,namesurvey ,fas_survey_responses.idquestion , fas_survey_responses.idanswer,descriptionq, descriptiona, count(distinct fas_survey_responses_bysn.idsurveyresponse) as cc 
from fas_survey_responses_bysn 	 
inner join fas_survey_responses
on fas_survey_responses.idsurveyresponse  = fas_survey_responses_bysn.idsurveyresponse
inner join fas_questions
on fas_questions.idquestion = fas_survey_responses.idquestion
inner join fas_answers
on fas_answers.idanswer = fas_survey_responses.idanswer
inner join fas_survey
on fas_survey.idsurvey = fas_survey_responses_bysn.idsurvey

where datetimecheck  > NOW() - INTERVAL '30 DAY'         ".$where1.$where2.$where3." 
group by fas_survey_responses_bysn.idsurvey,namesurvey, fas_survey_responses.idquestion , fas_survey_responses.idanswer,descriptionq, descriptiona
order by namesurvey , descriptionq 
 


  ";
//echo $query_lista2;

$data2 = $connect->query($query_lista2)->fetchAll();		

   foreach ($data2 as $rowcab) 
	 {
    ?>
		<tr><td><?php echo  $rowcab['namesurvey']."<br>".$rowcab['descriptionq'];  ?> </td>
		<?php			
 
			echo "<td class='text-center'>".strtoupper($rowcab['descriptiona'])."</td>";         
			echo "<td class='text-center'><b>".$rowcab['cc']." </td>";
   }
   
   
  ?>
   
	</tbody >
	</table >
</body>



<script type="text/javascript">
	$( document ).ready(function() { 
	 	console.log( "ready!" );		 
	});

</script>
</html>
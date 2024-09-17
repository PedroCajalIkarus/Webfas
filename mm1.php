
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Test for jQuery.Timeline Ver.2.1.0</title>
  <!-- Bootstrap from cdn -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">  <!-- furtive -->
  <link rel="stylesheet" href="index.furtive.min.css?v=1502988515">
  <!-- Font Awesome latest 5.3.1 -->
  <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
  <!-- jQuery Timeline -->
  <link rel="stylesheet" href="jquery.timeline.min.css">
  <link rel="stylesheet" href="jquery.timeline.tester.css">
  <!-- link rel="preload" href="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js" as="script" -->
</head>
<body >
<div class="row">
<div id="myTimeline">
  <ul class="timeline-events">
   
    
    <?php
        
        
        error_reporting(0);
            include("db_conect.php"); 
            
        
        
        
          $sqlmm="
          select distinct branchname as script,    fas_times_type.timename, fas_tree_measure.datetime as datetimelog , (fas_tree_measure.datetime+ max(fas_times.duration)::time) as datetimelogresta ,
        userruninfo, station, device, runinfodb.idruninfo ,
        bandnuevo, listroutime.uldl, fas_tree_measure.iduniquebranch , max(fas_times.duration) as durationmm
        
        
        from fas_tree_measure 
        inner join
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
          where fas_routines_product.idproduct = (SELECT idproduct from fnt_select_allproducts_maxrev() where modelciu like 'DH7S-A') 
           
          and fas_routines_product.active = 'Y'
          order by idorden
        ) as listroutime
        on listroutime.iduniquebranch =  fas_tree_measure.iduniquebranch and
        listroutime.bandnuevo =  fas_tree_measure.band and
        listroutime.uldl =  fas_tree_measure.uldl 
        
        inner join runinfodb
        on runinfodb.idruninfodb = fas_tree_measure.idrununfo
        inner join fas_times
        on fas_times.iduniqueop   = fas_tree_measure.iduniqueop 
        and fas_times.idsinglemeasure is null 
        and fas_times.idsameasures is null
        and fas_times.iducmeasure is null
        
        inner join fas_times_type
        on fas_times_type.idtimetype = fas_times.idtimetype
        where idrununfo = 10901032323  
        group by branchname ,  fas_times_type.timename,	userruninfo, station, device, runinfodb.idruninfo  ,bandnuevo, listroutime.uldl, fas_tree_measure.iduniquebranch,fas_tree_measure.datetime
        order by script, bandnuevo, uldl  limit 1
          
          ";
          $datalineality = $connect->query($sqlmm)->fetchAll();
          
        
          $usu="";
          $cantusarios=0;
          $cantitem=0;
          foreach ($datalineality as $row) 
          {
        
            $label_a_mostrar_title = "Duration:".trim($row['durationmm'])." <br>".trim($row['device'])."<br>Script:". trim($row['script'])."<br>IdRuninfo: ".trim($row['idruninfo']) ."<br>FI:".$row['datetimelog']."<br>FE:".$fechafin;
          //	$label_a_mostrar_title =  "Script:". trim($row['script']);
              $nombrgrupoarmado = "T".$row['bandnuevo'].$row['uldl'];
        
            
        /*
          <li data-timeline-node="{ start:'<?php echo substr($row['datetimelog'],0,19);  ?>',end:'<?php echo substr($row['datetimelogresta'],0,19);  ?>' ,content:'<?php echo $row['script'];  ?>' }"><?php echo $row['script'];  ?></li>
       */
        ?>
        <li data-timeline-node="{ start:'<?php echo substr($row['datetimelog'],0,16);  ?>',end:'<?php echo substr($row['datetimelogresta'],0,16);  ?>' ,content:'<?php echo $row['script'];  ?>' }"><?php echo $row['script'];  ?></li>
        <?php
               
              
          }
           
        
        
                ?>
                     <li data-timeline-node="{ start:'2021-06-21 07:10:01',end:'2021-06-21 08:30:30',content:'Lodui.' }">Event Label22</li>


  </ul>
</div>

<div class="timeline-event-view"></div>
</div>
<!-- REQUIRED JS SCRIPTS -->

 
<!-- jQuery from cdn -->
<script  src="js/jquery-3.3.1.min.js"></script>
<!-- Bootstrap from cdn -->
<link href="https://cdn.jsdelivr.net/gh/ka215/jquery.timeline@main/dist/jquery.timeline.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/gh/ka215/jquery.timeline@main/dist/jquery.timeline.min.js"></script>


<script  >
$(function () {
  //  $("#myTimeline").Timeline()
  $("#myTimeline").Timeline({
  // "bar" or "point"
  type            : "bar",
  // "years" or "months" or "days"
  scale           : "days", 
  // start <a href="#!">date</a> time
  startDatetime   : "currently",
  // end date time
  endDatetime     : "auto",
  // displays headline
  headline        : {
    display     : true,
    title       : "",
    range       : true,
    locale      : "en-US",
    format      : { hour12: false }
  }, 
  // displays sidebar
  sidebar         : {
    sticky      : false,
    overlay     : false,
    list        : [], //  an array of items
  },
  // displays ruler
  ruler           : {
    top         : {
      lines      : [],
      height     : 30,
      fontSize   : 14,
      color      : "#777777",
      background : "#FFFFFF",
      locale     : "en-US",
      format     : { hour12: false }
    },
  },
  // displays footer
  footer          : {
    display     : true,
    content     : "",
    range       : false,
    locale      : "en-US",
    format      : { hour12: false }
  },
  // displays event meta
  eventMeta       : {
    display     : false,
    scale       : "day",
    locale      : "en-US",
    format      : { hour12: false },
    content     : ""
  },
  // event data
  eventData       : [],
  // enables/disables effects
  effects         : {
    presentTime : true,
    hoverEvent  : true,
    stripedGridRow : true,
    horizontalGridStyle : 'dotted',
    verticalGridStyle : 'solid',
  },
  colorScheme     : { // Added new option since v2.0.0
    event         : {
      text        : "#343A40",
      border      : "#6C757D",
      background  : "#E7E7E7"
    },
    hookEventColors : () => null, // Added instead of merging setColorEvent of PR#37 since v2.0.0
  },
  // default view range
  range           : 3, 
  // numer of timeline rows
  rows            : 5, 
  // height of row
  rowHeight       : 40, 
  // width of timeline
  width           : "auto",
  // height of timeline
  height          : "auto",
  // min size of <a href="#!">grid</a>
  minGridSize     : 30, 
  // margin size
  marginHeight    : 2,
  // "left", "center", "right", "current", "latest" or specific event id
  rangeAlign      : "latest",
  // "default", false and selector
  loader          : "default",
  // loading message
  loadingMessage  : "",
  // hides scrollbar
  
  // "session" or "local"
  storage         : "session",
  // loads cached events during reloading
  reloadCacheKeep : true,
  // zooms the scale of the timeline by double clicking
  zoom            : false,
  // wraps new scale in the timeline container when zooming
  wrapScale       : true,
  // 0: Sunday, 1: Monday, ... 6: Saturday
  firstDayOfWeek  : 0, 
  // "canvas" or "d3.js"
  engine          : "canvas",
  // debug mode
  debug           : false
  
});

})
</script>
 
</body>
</html>

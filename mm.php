
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Horizontal Bar Timeline Example</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
  <!-- Bootstrap 4.0.0-alpha.6 -->
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <!-- Font Awesome latest -->
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <!-- jQuery Timeline -->
  <link href="timeline.min.css?ver=1.0.0" rel="stylesheet">ん -->
  <!--[if lt IE 9]>
  <script src="//oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body>
<div id="jquery-script-menu">

 
<div class="jquery-script-clear"></div>
</div>
</div>
<div class="container-fluid" style="margin-top:150px;">
<h1>Horizontal Bar Timeline Example</h1>

  <section class="row">

    <div class="content-main col-lg-12">

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
order by script, bandnuevo, uldl  limit 5
	
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

		


?>
  <li data-timeline-node="{ start:'<?php echo substr($row['datetimelog'],0,19);  ?>',end:'<?php echo substr($row['datetimelogresta'],0,19);  ?>' ,content:'<?php echo $row['script'];  ?>' }"><?php echo $row['script'];  ?></li>

<?php
		   
		  
	}
	 


        ?>
             <li data-timeline-node="{ start:'2021-06-21 07:10:00',end:'2021-06-21 08:30:01',content:'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis luctus tortor nec bibendum malesuada. Etiam sed libero cursus, placerat est at, fermentum quam. In sed fringilla mauris. Fusce auctor turpis ac imperdiet porttitor. Duis vel pharetra magna, ut mollis libero. Etiam cursus in leo et viverra. Praesent egestas dui a magna eleifend, id elementum felis maximus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Vestibulum sed elit gravida, euismod nunc id, ullamcorper tellus. Morbi elementum urna faucibus tempor lacinia. Quisque pharetra purus at risus tempor hendrerit. Nam dui justo, molestie quis tincidunt sit amet, eleifend porttitor mauris. Maecenas sit amet ex vitae mi finibus pharetra. Donec vulputate leo eu vestibulum gravida. Ut in facilisis dolor, vitae iaculis dui.' }">Event Label</li>
       
        </ul>
      </div>

    </div>
    <!-- /.content-main -->

    <div class="col-lg-6 col-md-12" hidden>

      <div class="card mb-3">
        <div class"card-block">
          <h5><i class="fa fa-cog"></i> Timeline Configuration</h5>
          <div class="card-text">
            <!-- configuration content -->
          </div>
        </div>
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
    <div class="col-lg-12 col-md-12">

      <div class="card mb-3">
        <div class="card-block timeline-event-view">
          <p class="h1">Timeline Event Detail</p>
          <p class="lead">Please click on any event on the above timeline.</p>
        </div>
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->

  </section>
  <!-- /.row -->

</div>
<!-- /.container-fluid -->

<div class="modal fade" id="myModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="timeline-event-view"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- /.modal -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery (latest 3.2.1) -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<!-- tether 1.4.0 (for using bootstrap's tooltip component) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" crossorigin="anonymous"></script>
<!-- Bootstrap 4.0.0-alpha.6 -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
<!-- jQuery Timeline -->
<script src="timeline.min.js?ver=1.0.0"></script>
<!-- local scripts -->
<script>
$(function () {

  $("#myTimeline").timeline({
    startDatetime: '2021-06-21',
    rangeAlign: 'center',
    scale:'minute'
  });

  // usage bootstrap's popover
  $('.timeline-node').each(function(){
    if ( $(this).data('toggle') === 'popover' ) {
      $(this).attr( 'title', $(this).text() );
      $(this).popover({
        trigger: 'hover'
      });
    }
  });

  /*
  $('#myTimeline').timeline('openEvent', function(){
    console.info( $(this).data );
    $('.extend-params');
  });
  */


});
</script>

</body>
</html>
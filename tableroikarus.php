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
            header("Location: http://".$ipservidorapache."/index.php");
        }
			if ($_SESSION["a"] =="")
		{
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
	
		/// DETECTO PERMISOS EN PAG!
		 $sql = $connect->prepare("select bum.idmenu, menu_action.idmenu_action,  menu_action.nameaction from business_user_menu as bum inner join menu on menu.idmenu = bum.idmenu left join business_user_menu_action as buma on buma.idbusiness = bum.idbusiness and buma.iduserfas =  bum.iduserfas and buma.idmenu =  bum.idmenu left join menu_action on menu_action.idmenu_action = buma.idaction where menu.linkaccess  =  '".array_pop(explode('/', $_SERVER['PHP_SELF']))."' and bum.iduserfas = ".$_SESSION["a"]." and bum.idbusiness = ".$_SESSION["i"]);
		$sql->execute();
		$resultado = $sql->fetchAll();							
		$pag_habilitada = "N";
		
		$permiso_create_edit_po = "N";
		$permiso_param_po = "N";
		$permiso_assing_so = "N";
		$permiso_assing_sn = "N";
		
		foreach ($resultado as $row) 
		{
			$pag_habilitada = "Y";
					

		}
	
		if ($pag_habilitada == "N")
		{
			///echo "the user: ".$_SESSION["b"]." cannot access the menu: ".array_pop(explode('/', $_SERVER['PHP_SELF'])).", contact the webfas administrator";
		//	header("Location: http://".$ipservidorapache."/".$folderservidor."/permissiondenied.php?b=".$_SESSION["b"]."&c=".array_pop(explode('/', $_SERVER['PHP_SELF'])));
		//	exit();
		}
	
	
	$status = $connect->getAttribute(PDO::ATTR_CONNECTION_STATUS);
	
	if ($status !="Connection OK; waiting to send.")
	{
	
		header("Location: http://".$ipservidorapache."/".$folderservidor."/errorconect.php");
		exit;
		
	}
	
//****************************************************************	
	function marco_encrypt($string, $key) {
   $result = '';
   for($i=0; $i<strlen($string); $i++) {
      $char = substr($string, $i, 1);
      $keychar = substr($key, ($i % strlen($key))-1, 1);
      $char = chr(ord($char)+ord($keychar));
      $result.=$char;
   }
   return base64_encode($result);
}

function marco_decrypt($string, $key) {
   $result = '';
   $string = base64_decode($string);
   for($i=0; $i<strlen($string); $i++) {
      $char = substr($string, $i, 1);
      $keychar = substr($key, ($i % strlen($key))-1, 1);
      $char = chr(ord($char)-ord($keychar));
      $result.=$char;
   }
   return $result;
}
//****************************************************************	

 

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


    <!-- AdminLTE css -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <link href="css/tabulator_bootstrap4.css" rel="stylesheet">
    <link rel="shortcut icon" href="fiplexcirculo-01.ico" />

    <link rel="stylesheet" href="toastr.css">

    <link href="css/tabulator_bulma.css" rel="stylesheet">


    <link rel="stylesheet" href="cssfiplex.css">
    <style>
    .letragraftortitas {
        font-size: 6pt;

    }
    </style>

</head>
<form name="frma" id="frma">
    <input type="hidden" name="uso" id="uso" value="0">

    <body class="hold-transition sidebar-mini sidebar-collapse">
        <!-- Site wrapper -->
        <div class="wrapper">
            <!-- Navbar -->

            <!-- Content Wrapper. Contains page content -->
            <div class="">
                <!-- Content Header (Page header) -->


                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">

                        <!-- Timelime example  -->
                        <div class="row">
                            <section class="col-lg-4 connectedSortable ui-sortable">

                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title colorazulfiplex ">Monthly reports</h3>

                                    </div>
                                    <div class="card-body">
                                        <div class="chart">
                                            <div>
                                                <canvas id="myChart"></canvas>
                                            </div>

                                            <!-- ---- -->
                                            <div class="container text-center">
                                                <div class="row">
                                                    <div class="col-sm">
                                                        <input type="text" class="knob" value="80" data-skin="tron"
                                                            data-thickness="0.2" data-width="50" data-height="50"
                                                            data-fgColor="#3c8dbc" data-readonly="true">
                                                        <div class="knob-label letragraftortitas">Orders received and
                                                            started</div>
                                                    </div>
                                                    <div class="col-sm">
                                                        <input type="text" class="knob" value="50" data-skin="tron"
                                                            data-thickness="0.2" data-width="50" data-height="50"
                                                            data-fgColor="#3c8dbc" data-readonly="true">
                                                        <div class="knob-label letragraftortitas">Assembled orders</div>
                                                    </div>
                                                    <div class="col-sm">
                                                        <input type="text" class="knob" value="45" data-skin="tron"
                                                            data-thickness="0.2" data-width="50" data-height="50"
                                                            data-fgColor="#3c8dbc" data-readonly="true">
                                                        <div class="knob-label letragraftortitas">Order calibrated</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- ---- -->

                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>


                            </section>
                            <section class="col-lg-4 connectedSortable ui-sortable">

                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title colorazulfiplex ">Weekly Report </h3>

                                    </div>
                                    <div class="card-body">
                                        <div class="chart">
                                            <div>
                                                <canvas id="myChart1"></canvas>
                                            </div>
                                        </div>
                                        <!-- ---- -->
                                        <div class="container text-center">
                                            <div class="row">
                                                <div class="col-sm">
                                                    <input type="text" class="knob" value="80" data-skin="tron"
                                                        data-thickness="0.2" data-width="50" data-height="50"
                                                        data-fgColor="#3c8dbc" data-readonly="true">
                                                    <div class="knob-label letragraftortitas">Orders received and
                                                        started</div>
                                                </div>
                                                <div class="col-sm">
                                                    <input type="text" class="knob" value="50" data-skin="tron"
                                                        data-thickness="0.2" data-width="50" data-height="50"
                                                        data-fgColor="#3c8dbc" data-readonly="true">
                                                    <div class="knob-label letragraftortitas">Assembled orders</div>
                                                </div>
                                                <div class="col-sm">
                                                    <input type="text" class="knob" value="45" data-skin="tron"
                                                        data-thickness="0.2" data-width="50" data-height="50"
                                                        data-fgColor="#3c8dbc" data-readonly="true">
                                                    <div class="knob-label letragraftortitas">Order calibrated</div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ---- -->
                                    </div>
                                    <!-- /.card-body -->
                                </div>


                            </section>
                            <section class="col-lg-4 connectedSortable ui-sortable">

                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title colorazulfiplex ">Daily Report </h3>

                                    </div>
                                    <div class="card-body">
                                        <div class="chart">
                                            <div>
                                                <canvas id="myChart2"></canvas>
                                            </div>
                                            <!-- ---- -->
                                            <div class="container text-center">
                                                <div class="row">
                                                    <div class="col-sm">
                                                        <input type="text" class="knob" value="80" data-skin="tron"
                                                            data-thickness="0.2" data-width="50" data-height="50"
                                                            data-fgColor="#3c8dbc" data-readonly="true">
                                                        <div class="knob-label letragraftortitas">Orders received and
                                                            started</div>
                                                    </div>
                                                    <div class="col-sm">
                                                        <input type="text" class="knob" value="50" data-skin="tron"
                                                            data-thickness="0.2" data-width="50" data-height="50"
                                                            data-fgColor="#3c8dbc" data-readonly="true">
                                                        <div class="knob-label letragraftortitas">Assembled orders</div>
                                                    </div>
                                                    <div class="col-sm">
                                                        <input type="text" class="knob" value="45" data-skin="tron"
                                                            data-thickness="0.2" data-width="50" data-height="50"
                                                            data-fgColor="#3c8dbc" data-readonly="true">
                                                        <div class="knob-label letragraftortitas">Order calibrated</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- ---- -->
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>

                            </section>
                            <!-- /.col -->
                        </div>
                    </div>
                    <!-- /.timeline -->

                </section>
                <!-- /.content -->



            </div>
            <!-- /.content-wrapper -->

</form>


<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- DataTables -->


<!-- AdminLTE for daterangepickers -->
<script src="plugins/select2/js/select2.full.min.js"></script>
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>

<!-- Toastr -->
<script src="toastr.min.js"></script>

<script src="js/jquery.inactivityTimeout.js"></script>
<script src="js/moment-timezone-with-data.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- Sparkline -->

</body>

<script type="text/javascript">
$(document).ready(function() {

    //Inicio mostrar hora live
    var interval = setInterval(function() {

        var momentNow = moment();
        var newYork = momentNow.tz('America/New_York').format('ha z');
        $('#date-part').html(momentNow.format('YYYY/MM/DD'));
        $('#time-part').html(momentNow.format('hh:mm:ss'));
    }, 100);
    //FIN mostrar hora live

    $('#msjwaitline ').hide();
    $('#divscrolllog').show();
    $('#p-b0').hide();
    $('#p-b0').CardWidget('toggle');
    $("#detallelog").hide();
    $("#detallelog").text("");
    $("#msjwait").hide();

    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-bottom-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };



    const DATA_COUNT = 7;
    const NUMBER_CFG = {
        count: DATA_COUNT,
        min: -100,
        max: 100
    };


    const ctx = document.getElementById('myChart');
    const ctx1 = document.getElementById('myChart1');
    const ctx2 = document.getElementById('myChart2');


    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['a', 'b', 'c', 'd', 'e'],
            datasets: [{
                label: 'Assembled orders',
                fill: false,

                data: [1, 3, 5, 7, 9],
            }, {
                label: 'Orders received',
                fill: false,

                borderDash: [5, 5],
                data: [10, 5, 9, 7, 9],
            }, {
                label: 'Ordenes Calibrated',

                data: [2, 2, 3, 4, 5],
                fill: true,
            }]

        },
        options: {
            aspectRatio: 2, // Proporción áurea
            plugins: {
                legend: {
                    labels: {
                        // This more specific font property overrides the global property
                        font: {
                            size: 10
                        }
                    }
                }
            }
        }

    });
    //////////////////////////////////////////
    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: ['a', 'b', 'c', 'd', 'e'],
            datasets: [{
                label: 'Assembled orders',
                fill: false,

                data: [1, 3, 5, 7, 9],
            }, {
                label: 'Orders received',
                fill: false,

                borderDash: [5, 5],
                data: [10, 5, 9, 7, 9],
            }, {
                label: 'Ordenes Calibrated',

                data: [2, 2, 3, 4, 5],
                fill: true,
            }]

        },
        options: {
            aspectRatio: 2, // Proporción áurea
            plugins: {
                legend: {
                    labels: {
                        // This more specific font property overrides the global property
                        font: {
                            size: 10
                        }
                    }
                }
            }
        }

    });
    //////////////////////////////////////////
    new Chart(ctx2, {
        type: 'line',
        data: {
            labels: ['a', 'b', 'c', 'd', 'e'],
            datasets: [{
                label: 'Assembled orders',
                fill: false,

                data: [1, 3, 5, 7, 9],
            }, {
                label: 'Orders received',
                fill: false,

                borderDash: [5, 5],
                data: [10, 5, 9, 7, 9],
            }, {
                label: 'Ordenes Calibrated',

                data: [2, 2, 3, 4, 5],
                fill: true,
            }]

        },
        options: {
            aspectRatio: 2, // Proporción áurea
            plugins: {
                legend: {
                    labels: {
                        // This more specific font property overrides the global property
                        font: {
                            size: 10
                        }
                    }
                }
            }
        }

    });


    $('.knob').knob({
        /*change : function (value) {
         //console.log("change : " + value);
         },
         release : function (value) {
         console.log("release : " + value);
         },
         cancel : function () {
         console.log("cancel : " + this.value);
         },*/
        draw: function() {

            // "tron" case
            if (this.$.data('skin') == 'tron') {

                var a = this.angle(this.cv) // Angle
                    ,
                    sa = this.startAngle // Previous start angle
                    ,
                    sat = this.startAngle // Start angle
                    ,
                    ea // Previous end angle
                    ,
                    eat = sat + a // End angle
                    ,
                    r = true

                this.g.lineWidth = this.lineWidth

                this.o.cursor &&
                    (sat = eat - 0.3) &&
                    (eat = eat + 0.3)

                if (this.o.displayPrevious) {
                    ea = this.startAngle + this.angle(this.value)
                    this.o.cursor &&
                        (sa = ea - 0.3) &&
                        (ea = ea + 0.3)
                    this.g.beginPath()
                    this.g.strokeStyle = this.previousColor
                    this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false)
                    this.g.stroke()
                }

                this.g.beginPath()
                this.g.strokeStyle = r ? this.o.fgColor : this.fgColor
                this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false)
                this.g.stroke()

                this.g.lineWidth = 2
                this.g.beginPath()
                this.g.strokeStyle = this.o.fgColor
                this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 /
                    3, 0, 2 * Math.PI, false)
                this.g.stroke()

                return false
            }
        }
    })
    /* END JQUERY KNOB */

});
</script>

</html>
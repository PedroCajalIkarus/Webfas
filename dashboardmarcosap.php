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
	

    

    $sql1 = $connect->prepare(" call a_solucionador_orders_SO_sinascociar();" );
    $sql1->execute();
    $resultado = $sql1->fetchAll();	

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
</head>
<form name="frma" id="frma">
    <input type="hidden" name="uso" id="uso" value="0">

    <body class="hold-transition sidebar-mini sidebar-collapse">
        <!-- Site wrapper -->
        <div class="wrapper">
            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="http://webfas.fiplex.com/index.php" class="nav-link">Home</a>
                    </li>

                </ul>



                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto">
                    <!-- Messages Dropdown Menu -->
                    <!-- Messages Dropdown Menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                            <i class="far fa-comments"></i>
                            <span class="badge badge-danger navbar-badge"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

                        </div>
                    </li>
                    <!-- Notifications Dropdown Menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                            <i class="far fa-bell"></i>
                            <span class="badge badge-warning navbar-badge"></span>
                        </a>

                    </li>

                    <!-- Notifications Dropdown Menu -->
                </ul>
            </nav>
            <!-- /.navbar -->
            <?php 	  

 include("menu.php"); 
 include("funcionesstores.php"); 
 include ('licencefiplex_mm.php');
 
   //   $Encryption = new Encryption();
        
?>


            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>STATUS WO - SO --> attributes</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">STATUS WO - SO --> attributes</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">

                        <!-- Timelime example  -->
                        <div class="row">
                            <section class="col-lg-12 connectedSortable ui-sortable">

                                <div class="" name="divscrolllog" id="divscrolllog" style="display.">

                                    <div id="ds" name="ds" class="container-fluid">

                                        <!--- demo acordion--->
                                        <div id="latabla" name="latabla">
                                            <table class="table table-condensed table-sm  table-striped  ">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Customer</th>
                                                        <th>SO </th>
                                                        <th>CIU </th>
                                                        <th>Quantity </th>
                                                        <!-- <th >ChkList</th>					
<th >P.Config</th>                       
<th>SOsAssign</th>  -->
                                                        <th>Have Attrib Operation</th>

                                                        <th>Have Attrib Operation SN</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="myTable">

                                                    <?php
$filtrer_date_marco ="";


$filtrer_date_marco ="  (((prestatus.datestate > now() -' 30 day'::INTERVAL) ) or  pre.active ='D') and   ";
//$filtrer_date_marco ="  ((prestatus.datestate > now() -' 30 day'::INTERVAL) or orders_sn.processday is null) and";




$sql = $connect->prepare("
select  distinct iduniquebranchsonprod, products.idproduct ,  pre.idcustomers, namecustomers ,  orders_sn.ponumber ,orders_sn.so_soft_external, pre.active,fassrverror, pre.processfasserver, pre.idorders,pre.idrev,  products.modelciu ciu, quantity,  pre.date_approved as datestate , max(prestatus.idstate) as idstates
, count(distinct orders_sn_asignados.wo_serialnumber) as cantsnasing ,  array_agg( distinct coalesce(  orders_sn_asignados.wo_serialnumber,'')) as groupxsn, 
 
min(products_attributes.idattribute) as idattribute , 
COALESCE(min(products_attributes.idattribute),0) as haveupgrade
,count( distinct  orders_attributesrabbit.v_string) as 	cant_ope_order 
,count(distinct orders_sn_attributes.v_string) as 	cant_ope_order_sn  , products.active as activeprod ,  atrib30.v_string as issoblock,
products_attributes_islegacy.idattribute as  idattribute_islegacy
from orders as pre
inner join fnt_select_allproducts_maxrev() as products
on products.idproduct = pre.idproduct  												
inner join customers
on customers.idcustomers = pre.idcustomers
inner join orders_states as  prestatus 
on prestatus.idorders = pre.idorders 
       

inner join orders_sn
on orders_sn.idorders = pre.idorders 
inner join orders_sn as orders_sn_asignados
on orders_sn_asignados.idorders = pre.idorders and 
orders_sn_asignados.idrev =  pre.idrev and 
orders_sn_asignados.idnroserie >0 and
orders_sn_asignados.wo_serialnumber <> ''
left join orders_attributes as orders_attributesrabbit
on orders_attributesrabbit.idorders  =  orders_sn.idorders 
and  orders_attributesrabbit.idattribute_orders = 21
left join  orders_sn_attributes
on orders_sn_attributes.idorders  =  orders_sn.idorders and
orders_sn_attributes.idattribute_orders = 21

left join  products_attributes as products_attributes_islegacy
on pre.idproduct  =  products_attributes_islegacy.idproduct and
products_attributes_islegacy.idattribute =30

left join products_attributes
on products_attributes.idproduct =pre.idproduct and products_attributes.idattribute  in (94,95,96,97)
left join  fnt_select_all_ordersattribute_maxrev(30) as atrib30
on atrib30.idorders  =  orders_sn.idorders
where ".$filtrer_date_marco."  ( (pre.typeregister = 'PO' and pre.active <>'N'   ) or (pre.typeregister = 'SO' and pre.active <>'N'   ) or (pre.typeregister = 'UP' and pre.active <>'N'  )  
".$queryquefiltramos." )   
 
group by iduniquebranchsonprod, products.idproduct , pre.idcustomers, namecustomers ,  orders_sn.ponumber ,orders_sn.so_soft_external, pre.active,fassrverror, 
pre.processfasserver, pre.idorders,pre.idrev,  products.modelciu , quantity,  pre.date_approved ,   products.active , atrib30.v_string
,products_attributes_islegacy.idattribute 
order by   pre.date_approved desc,  orders_sn.so_soft_external,  products.modelciu   	");




$sql->execute();
$resultado = $sql->fetchAll();
$idcantrow=1;
foreach ($resultado as $row) {
$idpresales =  $row['idorders'];
$vidrev =  $row['idrev'];

// $idruninfo = $Encryption->encrypt($row['idruninfo'], $semillafp); // $row['idruninfo'];

$date_approved = substr($row['datestate'],5,5);
$date_approved_t = substr($row['datestate'],11,5);
$ponumber =  sprintf("%'.09d\n",$row['ponumber']); 
$ponumber = $row['ponumber'];
$so_number = $row['so_soft_external'];


$ciu = $row['ciu'];  


$quantity = $row['quantity'];  
$quantityasignados = $row['cantsnasing'];  
$namecustomers = $row['namecustomers']; 
$cortonamecustomers = substr($row['namecustomers'],0,8).".."; 
$idstates = $row['idstates']; 
if( $row['active']=="Y")	
{
$msjerrorfasserver ="";
if ($row['idstates']==1 )
{
$statename = "PO CheckList";
}
if ($row['idstates']==2 )
{
$statename = "CIU Parameters Config";
}
if ($row['idstates']==3 )
{
$statename = "Create SO";
}
if ($row['idstates']==4 )
{
$statename = " SNs Assignments";
}
}
else
{
if( $row['active']=="Y")
{

}
else
{
///echo   str_replace(".", ".<br> ", $row['fassrverror']);
if ( $row['fassrverror'] !="")
{
$msjerrorfasserver = " :: <label class='text-danger' alt='".$row['fassrverror']."' title='".$row['fassrverror']."'>".str_replace(".", ".<br> ", $row['fassrverror'])." </label>";  
$msjerrorfasserver = " :: ".str_replace(".", ".<br> ", $row['fassrverror'])." ";  
}
}


}


$proximo_hab = "N";

if ($so_number =="")
{
$so_number ="SO uninsigned";
}
?>

                                                    <tr>
                                                        <td><?php echo $date_approved." ".$date_approved_t; ?>
                                                        </td>
                                                        <td data-toggle="tooltip" data-placement="top"
                                                            title="<?php echo $namecustomers; ?>">
                                                            <?php echo $cortonamecustomers; ?> </td>

                                                        <?php 
$habilito_editar_so= 1;
if ($row['active']=="D")
{
$habilito_editar_so= 2;
}
if ($row['active']=="P")
{
$habilito_editar_so= 2;
}

//	if ($_SESSION["g"] == "develop"  )
//	{

    
if( $row['activeprod']=="Y")
{
if ($quantityasignados ==0)
{?>
                                                        <td class="font-weight-bold"> <?php echo $so_number;  ?>


                                                        </td>
                                                        <?php
}
else
{
?>
                                                        <td class="font-weight-bold"> <?php echo $so_number;  ?>

                                                        </td>
                                                        <?php	
}
}
else
{
?>
                                                        <td class="font-weight-bold"><?php echo $so_number;  ?>
                                                            &nbsp&nbsp
                                                        </td>
                                                        <?php	
}


//		}
//	else
//	{
///
//		?>

                                                        <?php
//	}
?>

                                                        <?php 
if( $row['activeprod']=="Y")
{
?>
                                                        <td class="font-weight-bold">
                                                            <?php echo  $ciu; //." -- ".$row['groupxsn']; ?>

                                                            <?php ///echo $_SESSION["a"]; marco / diego / francesco
if  ($_SESSION["a"]==1 ||$_SESSION["a"]==2 ||$_SESSION["a"]==17 || $_SESSION["a"]==16 || $_SESSION["a"]==8)
{
?>

                                                            <?php
}
}
else
{
//aaaaaa

?>

                                                        <td class="font-weight-bold"><?php echo  $ciu; ?>
                                                            <?php

} 


// if (strpos($row['iduniquebranchsonprod'], '00010038') !== false) 
if (strpos($row['iduniquebranchsonprod'], '00010038') !== false ||   strpos($row['iduniquebranchsonprod'], '001000010094') !== false ) 				 
{
?>&nbsp;
                                                            <?php
}
?>

                                                            &nbsp;


                                                            <?php
if( $row['issoblock']=="Yes")
{
?>
                                                            <?php

}
?>
                                                        </td>
                                                        <td class="font-weight-bold"><span
                                                                class="badge badge-primary right"
                                                                title="Quantity - Ref: IDOrders [<?php echo $idpresales; ?>]"><?php 
if( $row['activeprod']=="Y")
{
echo $quantityasignados." / ".$quantity;

}
else
{
echo  $quantity;
}
?></span></td>




                                                        <td class="font-weight-bold">

                                                            <?php 
                                                            
                                                            if ($quantityasignados>0 && $row['cant_ope_order'] ==0)
                                                            {
                                                                ?>
                                                            <span class="right badge badge-danger">Error
                                                                <?php echo     $row['cant_ope_order']; ?></span>
                                                            <?php
                                                            }
                                                            else
                                                            {
                                                                echo $row['cant_ope_order'];
                                                            }
                                                            
                                                            ?>
                                                        </td>
                                                        <td class="font-weight-bold">
                                                            <?php
                                                            if ($row['cant_ope_order']>=1)
                                                            {
                                                                $aproxcan = $quantityasignados * $row['cant_ope_order'];
                                                            }
                                                            
                                                            if ( $aproxcan <  $row['cant_ope_order_sn'])
                                                            {
                                                                ?>
                                                            <span class="right badge badge-danger">Error
                                                                <?php echo     $row['cant_ope_order_sn']; ?> </span>
                                                            <?php
                                                            }
                                                            else
                                                            {
                                                                echo  $row['cant_ope_order_sn'];
                                                            }
                                                            
                                                              ?>
                                                        </td>
                                                        <?php

}
?>




                                                </tbody>
                                            </table>
                                        </div>


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

<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
        <b>Server Time:</b>
        <span name="date-part" id="date-part"></span>
        <span name="time-part" id="time-part"></span>
    </div>
    <strong>Copyright &copy; 2020 Admin Fas FIPLEX</strong> All rights
    reserved.
</footer>

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
<script src="plugins/daterangepicker/daterangepicker.js"></script>

<script src="crypto-js.js"></script>
<!-- https://github.com/brix/crypto-js/releases crypto-js.js can be download from here -->

<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="toastr.min.js"></script>

<script src="licencefiplex_mm.js"></script>
<script src="licencefiplex1.js"></script>
<script src="js/jquery.inactivityTimeout.js"></script>
<script src="js/moment-timezone-with-data.js"></script>

<script src="plugins/jquery-knob/jquery.knob.min.js"></script>

<script type="text/javascript" src="js/tabulator.min.js"></script>

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

});


// controlar inactividad en la web	
$(document).inactivityTimeout({
    inactivityWait: 10000,
    dialogWait: 10,
    logoutUrl: 'logout.php'
})
// fin controlar inactividad en la web		

/* requesting data */



function search_infomm() {
    if ($('#myInput').val() == '') {
        toastr["error"]("You must enter the text to search", "Attention  ");

    } else {
        toastr["success"]("Wait....Search Results", "*-+-+-+-+-+-*");

        $.ajax({
            url: 'ajax_searchsnsapatributes.php',
            data: "txtsearch=" + $("#myInput").val(),
            type: 'post',
            async: true,
            cache: false,
            success: function(data) {
                //	var datax = JSON.parse(data)
                //		console.log(data);
                $('#latabla').html('Search.....');
                $('#latabla').html(data);
                console.log('inicio crond:' + $('#myInput').val());


            }
        });
    }
}
</script>

</html>
<?php
	/////////////////////////////////////////////////////////////////////////////////////
				//////AUDITAMOS///////////////////////////////////////////////////////////////////////////////
				$vuserfas = $_SESSION["b"];
				$vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
				$vaccionweb="visitweb";
					$vdescripaudit="visitweb#".$_SERVER['SERVER_ADDR'];
				$vtextaudit="";
				
				$sentenciach = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
								$sentenciach->bindParam(':userfas', $vuserfas);								
								$sentenciach->bindParam(':menuweb', $vmenufas);
								$sentenciach->bindParam(':actionweb', $vaccionweb);
								$sentenciach->bindParam(':descripaudit', $vdescripaudit);
								$sentenciach->bindParam(':textaudit', $vtextaudit);
								$sentenciach->execute();
								
							
				/////////////////////////////////////////////////////////////////////////////////////
				/////////////////////////////////////////////////////////////////////////////////////
?>
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
		///	header("Location: http://".$ipservidorapache."/".$folderservidor."/permissiondenied.php?b=".$_SESSION["b"]."&c=".array_pop(explode('/', $_SERVER['PHP_SELF'])));
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

////////////////////Vamos a Procesar la encuesta
$v_sn =$_REQUEST['elsn'];
$v_so =$_REQUEST['elso'];
$v_ciu =$_REQUEST['elciu'];
 

if (isset($_POST['numerador']))
	{

//   print_r($_POST);

    try {
          $v_sn =$_REQUEST['elsn'];
          $v_so =$_REQUEST['elso'];
          $v_ciu =$_REQUEST['elciu'];
          $nrorev = $_POST['nrorev'];
       
          foreach ($_POST as $clave=>$valor)
          {
          
          $loscontroleshtml = explode("_", $clave);
   //       echo "<br>---".$loscontroleshtml[0];
            if ($loscontroleshtml[0]=="nuevonamecomp")
            {
              //echo "Voy a controlar todo el ".$loscontroleshtml[1];
              //echo "El valor de $clave es: $valor .<br><br>";

              $elso= $_REQUEST['elso'];
              $elsn= $_REQUEST['elsn'];
              $elciu= $_REQUEST['elciu'];

                /*echo "<br>****SN:".$_REQUEST['nuevonamecomp_'.$loscontroleshtml[1]];
                echo "<br>****Ciu:".$_REQUEST['nuevosnciu_'.$loscontroleshtml[1]];
                echo "<br>****Rev:".$_REQUEST['nuevorev_'.$loscontroleshtml[1]];
                echo "<br>****TypeComp:".$_REQUEST['cmbtypecomp'.$loscontroleshtml[1]];
                echo "<br>****TypeComp:".$_REQUEST['nuevonamecomp_'.$loscontroleshtml[1]];
                */

                $vuserfas = $_SESSION["b"];
                                                        /*
                                                        CREATE OR REPLACE PROCEDURE public.sp_insert_orders_sn_components(
                                          v_so character varying, 
                                          v_sn character varying,
                                          v_modelciu character varying,
                                          v_idtypecomponets integer,
                                          v_components_sn character varying, 
                                          v_components_ciu character varying,
                                          v_components_rev character varying,
                                          v_components_name character varying,
                                          v_idprodcomprev integer)
                                                        */
              $typecomp =   $_REQUEST['nuevonamecomp_'.$loscontroleshtml[1]];
              $elsn_cargado = $_REQUEST['nuevonamecomp_'.$loscontroleshtml[1]];
              $elciu_cargado =   $_REQUEST['nuevosnciu_'.$loscontroleshtml[1]];
              $typecomp =   $_REQUEST['nuevonamecomp_'.$loscontroleshtml[1]];
              $elrev_cargado = $_REQUEST['nuevorev_'.$loscontroleshtml[1]];
              $eltipodecomponente = $_REQUEST['cmbtypecomp'.$loscontroleshtml[1]];
              $elnombreotro = $_REQUEST['nuevonamecompother_'.$loscontroleshtml[1]];


              $simbol = array("'");
              $elsn_cargado = str_replace($simbol, "-", $elsn_cargado);
           
              $vidprodcomp = $_REQUEST['idprodcomp'.$loscontroleshtml[1]];
             if ( $vidprodcomp=="")
              {
                $vidprodcomp=0;
              }
              if ( $elrev_cargado=="")
              {
                $elrev_cargado=0;
              }
            //  echo "<br>ssssel tipo de compomente ID es: ". $vidprodcomp;
           

               $query_lista2  = "CALL public.sp_insert_orders_sn_components('".$elso."','".$elsn."','".$elciu."',".$eltipodecomponente.",'".$elsn_cargado."','".$elciu_cargado."',".$elrev_cargado.",'".$elnombreotro."',".$nrorev.",'".$vuserfas."',". $vidprodcomp.")";
           //   echo  "<br>".$query_lista2;
                $connect->query($query_lista2);  
              
            
                $vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
                $vaccionweb="Picking Insert";
                $sentenciaudit = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
                $sentenciaudit->bindParam(':userfas', $vuserfas);								
                $sentenciaudit->bindParam(':menuweb', $vmenufas);
                $sentenciaudit->bindParam(':actionweb', $vaccionweb);
              
                $vdescripaudit="Picking - SN:".$elsn."-SO:".$elso."-CIU:".$elciu;		
    
                $sentenciaudit->bindParam(':descripaudit', $vdescripaudit);
                $sentenciaudit->bindParam(':textaudit', $query_lista2);
                $sentenciaudit->execute();	
             
              
              
                $msjok="Save OK.!";

            }
         //   echo "<br>HOLA:".$loscontroleshtml[0];
            if ($loscontroleshtml[0]=="nuevosnunit")
            {
              //echo "Voy a controlar todo el ".$loscontroleshtml[1];
              //echo "El valor de $clave es: $valor .<br><br>";

              $typecomp =   $_REQUEST['nuevonamecomp_'.$loscontroleshtml[1]];
              $elsn_cargado = $_REQUEST['nuevosnunit_'.$loscontroleshtml[1]];
              $elciu_cargado =   $_REQUEST['nuevosnciu_'.$loscontroleshtml[1]];
              $typecomp =   $_REQUEST['nuevonamecomp_'.$loscontroleshtml[1]];
              $elrev_cargado = $_REQUEST['nuevorev_'.$loscontroleshtml[1]];
              $elotrotipocargado = "O#".$_REQUEST['cmbtypecomp'.$loscontroleshtml[1]];
              $eltipodecomponente = $_REQUEST['cmbtypecomp'.$loscontroleshtml[1]];
              $elnombreotro = $_REQUEST['nuevonamecompother_'.$loscontroleshtml[1]];

              $simbol = array("'");
              $elsn_cargado = str_replace($simbol, "-", $elsn_cargado);

               
               $query_lista2  = "CALL public.sp_insert_orders_sn_components('".$elso."','".$elsn."','".$elciu."',".$eltipodecomponente.",'".$elsn_cargado."','".$elciu_cargado."','".$elrev_cargado."','".$elciu_cargado."',".$nrorev.",'".$vuserfas."',".$vidprodcomp.")";
           //   echo  "<br>".$query_lista2;
               $connect->query($query_lista2);  

               
               $vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
               $vaccionweb="Picking Insert";
               $sentenciaudit = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
               $sentenciaudit->bindParam(':userfas', $vuserfas);								
               $sentenciaudit->bindParam(':menuweb', $vmenufas);
               $sentenciaudit->bindParam(':actionweb', $vaccionweb);
             
               $vdescripaudit="Picking - SN:".$elsn."-SO:".$elso."-CIU:".$elciu;		
   
               $sentenciaudit->bindParam(':descripaudit', $vdescripaudit);
               $sentenciaudit->bindParam(':textaudit', $query_lista2);
               $sentenciaudit->execute();	
            
               
            }
           

          }
    
            $msjok="Save OK.!";
          } 
          catch (PDOException $e) 
          {
            $connect->rollBack();
            $return_result_insert="error".$e->getMessage();
            $msjerr= "Syntax Error MM: ".$e->getMessage();
            echo $msjerr;
          }
						
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
<form name="frmae" id="frmae" method="post" >
<input type="hidden" name="uso" id="uso" value="0">
<body class="hold-transition sidebar-mini sidebar-collapse">
<!-- Site wrapper -->



  <!-- Content Wrapper. Contains page content -->
  <div >

   </form>
   <?php
                  $elso = $_REQUEST['elso'];
                  $elsn = $_REQUEST['elsn'];
                  $elciu = $_REQUEST['elciu'];
                  
                  ?>
        <form name="frma" id="frma" action="wopicking.php?elsn=<?php echo $elsn; ?>&elso=<?php echo $elso; ?>&elciu=<?php echo $elciu; ?>" method="post" class="form-horizontal">
 
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        
        <!-- Timelime example  -->
        <div class="row">
          <section class="col-lg-12 connectedSortable ui-sortable">

            <div class="" name="divscrolllog" id="divscrolllog" style="display.">
			<p name="msjwaitline" id="msjwaitline" align="center"><img src="img/waitazul.gif" width="100px" ></p>	
				<div class="card">
                  <!-- tabla de preguntas  -->
                  <div class="container-fluid">
                  <br>
                 
                  <input type="hidden" name="elso" id="elso" value="<?php echo $elso; ?>">
                  <input type="hidden" name="elsn" id="elsn" value="<?php echo $elsn; ?>">
                  <input type="hidden" name="elciu" id="elciu" value="<?php echo $elciu; ?>">
                  <input type="hidden" name="statussn" id="statussn" value="">
                
                  
                  <?php
		  
		  if ($msjok <> "")
		  {
			  ?>
			  <div  id="aa1" name="aa1" class="alert alert-success alert-dismissible">
                  
                  <h5><i class="icon fas fa-check"></i> Save Ok!</h5>
                  
                </div>
		
			  <?php
        
		  }
		  ?>
     <h5 class="colorazulfiplex"> <?php echo "".$elso." || ". $elsn." || ".  $elciu ?>  </h5>
     <hr>
     
     <div class="container-fluid  ">
   <?php
   
   ///// Canti revision
$cant_Rev =0;
$query_lista="SELECT count(distinct  to_char(datetimepicking, 'YYYY-MM-DD hh:mm:ss') ) + 1 as cc
  FROM public.orders_sn_components
inner join components_types
on components_types.idtypecomponets = orders_sn_components.idtypecomponets
inner join orders_sn
on orders_sn.idorders = orders_sn_components.idorders and 
orders_sn.idproduct = orders_sn_components.idproduct and
orders_sn.so_soft_external = '".$elso."'  where orders_sn_components.wo_serialnumber= '".$elsn."'";



$datacc = $connect->query($query_lista)->fetchAll();	
$vidsurveyresponse = 0;
$colorstyle="";
foreach ($datacc as $row) 
{
  $cant_Rev = $row['cc']; 
  
}


                  $query_lista="select distinct orders_sn_components.*, nametypecomponets, maxidprodcomprev , namecabinet
                  from
                  (
                    SELECT distinct orders_sn_components.idorders, orders_sn_components.idproduct, orders_sn_components.wo_serialnumber,components_name,
                   orders_sn_components.idtypecomponets, max(idprodcomprev) as maxidprodcomprev
                  FROM public.orders_sn_components 
                  inner join components_types on components_types.idtypecomponets = orders_sn_components.idtypecomponets 
                  inner join orders_sn on orders_sn.idorders = orders_sn_components.idorders and 
                  orders_sn.idproduct = orders_sn_components.idproduct and orders_sn.so_soft_external =  '".$elso."' 
                  where orders_sn_components.wo_serialnumber= '".$elsn."'
                  group by orders_sn_components.idorders, orders_sn_components.idproduct, orders_sn_components.wo_serialnumber,
                   orders_sn_components.idtypecomponets,  components_name
                  ) as cc
                  inner join orders_sn_components
                  on orders_sn_components.idorders = cc.idorders  and
                  orders_sn_components.idproduct = cc.idproduct  and
                  orders_sn_components.wo_serialnumber = cc.wo_serialnumber  and
                  orders_sn_components.idtypecomponets = cc.idtypecomponets  and
                  orders_sn_components.components_name = cc.components_name and 
                  orders_sn_components.idprodcomprev = cc.maxidprodcomprev 
                  
                  inner join components_types 
                  on components_types.idtypecomponets = cc.idtypecomponets 
                  inner join orders_sn on orders_sn.idorders = orders_sn_components.idorders and 
                  orders_sn.idproduct = orders_sn_components.idproduct and orders_sn.so_soft_external =  '".$elso."' 
                  left join components_cabinet
              on components_cabinet.idcompcabinet::text = orders_sn_components.components_ciu
                  where orders_sn_components.wo_serialnumber= '".$elsn."' order by nametypecomponets ,  idprodcomprev desc";
                  
              //    echo $query_lista;

                         $data = $connect->query($query_lista)->fetchAll();	
                         $vidsurveyresponse = 0;
                         $colorstyle="";

                         $cant_registros_xsn = count($data );
        if($cant_registros_xsn>0)
        {
   ?>

     <section class="col-lg-12 connectedSortable ui-sortable">
       <div id="divmaxrev" name="divmaxrev">
              <p class='text-right'>  <a href="#" onclick="mostrar_tabla_picking(2)">Show history </a>
        </p>
                    <table class="table table-striped   ">
                              <thead class="thead-dark">
                                <tr>
                                  
                            
                                  <th scope="col">Rev</th>
                                  <td class="table-primary"scope="col"><b>Type Components</b></td>       
                                  <td class="table-primary"scope="col"><b>CIU</b></td>       
                                  <td class="table-primary" scope="col"><b>SN</b></td>       
                                  
                                  <td class="table-primary" scope="col"><b>Rev</b></td>       
                          
                                  <th scope="col">Date</th>       
                                  <th scope="col">User</th>      
                                  
                                </tr>
                              </thead>
                              <tbody>
                              <?php

                                  foreach ($data as $row) 
                                  {
                                    $colorstyle="black";

                                 
                                    
                                      ?>
                                      <tr>
                            
                                        <td><?php echo  $row['maxidprodcomprev']; ?>  </td>
                                        <td><?php echo  $row['nametypecomponets']; ?>  </td>
                                        <td><?php echo  $row['components_ciu']; ?>  </td>
                                        <td><?php echo  $row['components_sn']; ?>  </td>
                                        
                                        <td><?php echo  $row['components_rev']; ?>  </td>
                                      
                                        <td><?php echo  substr($row['datetimepicking'],0,19); ?>  </td>
                                        <td><?php echo  $row['userpicking']; ?>  </td>
                                      
                                      </tr>
                                      <?php
                                  }
                              ?>
                    </tbody>
                    </table>
                </div>    
                <?php
                
                
                
                $query_lista="SELECT distinct orders_sn_components.idorders, orders_sn_components.idproduct, orders_sn_components.wo_serialnumber, idprodcomp, orders_sn_components.idtypecomponets, components_sn, components_ciu, components_rev, 
                components_name, idprodcomprev, userpicking, datetimepicking , nametypecomponets 
                  FROM public.orders_sn_components
              inner join components_types
              on components_types.idtypecomponets = orders_sn_components.idtypecomponets
           
              inner join orders_sn
              on orders_sn.idorders = orders_sn_components.idorders and 
                orders_sn.idproduct = orders_sn_components.idproduct and
                orders_sn.so_soft_external = '".$elso."'  where orders_sn_components.wo_serialnumber= '".$elsn."' order by nametypecomponets ,  idprodcomprev desc" ;
 
              $datatodos = $connect->query($query_lista)->fetchAll();	
              $vidsurveyresponse = 0;
              $colorstyle="";

              $cant_registros_xsn = count($datatodos );
              if($cant_registros_xsn>0)
              {
                  $vtempanterior=0;
                ?>
                <div id="divhistorial" name="divhistorial" class="d-none">
                <p class='text-right'>     <a href="#" onclick="mostrar_tabla_picking(1)">Show Latest Reviews</a>
              </p>
                    <table class="table table-striped   ">
                              <thead class="thead-dark">
                                <tr>
                                  
                           
                                  <th scope="col">Rev</th>
                                  <td class="table-primary"scope="col"><b>Type Components</b></td>       
                                  <td class="table-primary"scope="col"><b>CIU</b></td>       
                                  <td class="table-primary" scope="col"><b>SN</b></td>       
                                  
                                  <td class="table-primary" scope="col"><b>Rev</b></td>       
                          
                                  <th scope="col">Date</th>       
                                  <th scope="col">User</th>      
                                  
                                </tr>
                              </thead>
                              <tbody>
                              <?php

                                  foreach ($datatodos as $row) 
                                  {
                                    $colorstyle="black";
                                      $estiloletra= "";
                                      if ( $row['idtypecomponets'] <> $vtempanterior)
                                      {
                                        $vtempanterior = $row['idtypecomponets'];
                                        $estiloletra= "";
                                      }
                                      else
                                      {
                                        $estiloletra= "text-danger";
                                      }

                                      
                                          
                                      
                                    
                                      ?>
                                      <tr>
                                     
                                        <td class="<?php echo $estiloletra;?>" ><?php echo  $row['idprodcomprev']; ?>  </td>
                                        <td class="<?php echo $estiloletra;?>"><?php echo  $row['nametypecomponets']; ?>  </td>
                                        <td class="<?php echo $estiloletra;?>"><?php echo $row['components_ciu'];?>  </td>
                                        <td class="<?php echo $estiloletra;?>"><?php echo  $row['components_sn']; ?>  </td>
                                        
                                        <td class="<?php echo $estiloletra;?>"><?php echo  $row['components_rev']; ?>  </td>
                                      
                                        <td class="<?php echo $estiloletra;?>"><?php echo  substr($row['datetimepicking'],0,19); ?>  </td>
                                        <td class="<?php echo $estiloletra;?>"><?php echo  $row['userpicking']; ?>  </td>
                                      
                                      </tr>
                                      <?php
                                  }
                              ?>
                    </tbody>
                    </table>
                </div>  
                <?php
              }
                ?>  
           </section>
           <?php }
           //cierrro if cant reg guardado
           ?>
<input type="hidden" id="nrorev" name="nrorev" value="<?php echo $cant_Rev;?>">
<input type="hidden" id="numerador" name="numerador" value="100">
   
 
   
  <?php
if ($cant_registros_xsn>0)
{
?>
 <p>
 <button class="btn btn-primary btn-block btn-flat" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
 
  Create New Rev
  </button>
  
</p>
  <div class="collapse" id="collapseExample">
  <div class="card card-body">
  <?php
}
  else
  {
    ?>
  Create New 
  <?php
  }
  ?>


    
<!--
    ---------------------------------------
          -->
<?php


    
if ($cant_registros_xsn>0)
{

  $query_lista="select distinct idprodcomp as dddd,  orders_sn_components.*, nametypecomponets, maxidprodcomprev 
  from
  (
    SELECT distinct orders_sn_components.idorders, orders_sn_components.idproduct, orders_sn_components.wo_serialnumber,components_name,
   orders_sn_components.idtypecomponets, max(idprodcomprev) as maxidprodcomprev
  FROM public.orders_sn_components 
  inner join components_types on components_types.idtypecomponets = orders_sn_components.idtypecomponets 
  inner join orders_sn on orders_sn.idorders = orders_sn_components.idorders and 
  orders_sn.idproduct = orders_sn_components.idproduct and orders_sn.so_soft_external =  '".$elso."' 
  where orders_sn_components.wo_serialnumber= '".$elsn."'
  group by orders_sn_components.idorders, orders_sn_components.idproduct, orders_sn_components.wo_serialnumber, components_name,
   orders_sn_components.idtypecomponets
  ) as cc
  inner join orders_sn_components
  on orders_sn_components.idorders = cc.idorders  and
  orders_sn_components.idproduct = cc.idproduct  and
  orders_sn_components.wo_serialnumber = cc.wo_serialnumber  and
  orders_sn_components.idtypecomponets = cc.idtypecomponets  and
  orders_sn_components.components_name = cc.components_name and 
  orders_sn_components.idprodcomprev = cc.maxidprodcomprev 
  
  inner join components_types 
  on components_types.idtypecomponets = cc.idtypecomponets 
  inner join orders_sn on orders_sn.idorders = orders_sn_components.idorders and 
  orders_sn.idproduct = orders_sn_components.idproduct and orders_sn.so_soft_external =  '".$elso."' 
  where orders_sn_components.wo_serialnumber= '".$elsn."' order by nametypecomponets";

}
else
{


  $query_lista="select *, modelciu as components_ciu  from products_components as products_componets 
  inner join  components_types
  on  components_types.idtypecomponets = products_componets.idtypecomponets
  left join products  on products.idproduct = products_componets.idprodcompdefault
  where products_componets.idproduct in ( select idproduct from products where modelciu = '".$elciu."' )  order by nametypecomponets";
}


      //    echo "<br>q".$query_lista;
            $data = $connect->query($query_lista)->fetchAll();	
            foreach ($data as $row) 
            {
              ?>
     
         <div class="col-6">
                    <div class="card card-info">
                    <div class="card-header card-primary">
                      <h3 class="card-title"><?php echo  $row['nametypecomponets']; ?> </h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                 
                      <div class="container">
                      <div class=" row">
                          <label for="inputEmail3" class="col-sm-2 col-form-label">CIU:</label>
                          <div class="col-sm-10">
                          <?php  if ($row['idtypecomponets'] == 2) 
                                   {
                                     //////Cabinet
                                     ?>
                                          <select name="nuevosnciu_<?php echo  $row['idtypecomponets'];   ?>" id="nuevosnciu_<?php echo  $row['idtypecomponets'];   ?>" class="form-control">
                                             <option value="">-Select-</option>

                                             <?php
                                           
                                             $sql = $connect->prepare("select idproduct, modelciu
                                             from fnt_select_allproducts_maxrev2() as ss
                                             where idproduct in (select idproduct from products_attributes where idattribute = 66)
                                             and active = 'Y' order by modelciu ");
                                             $sql->execute();
                                             $resultado = $sql->fetchAll();
                                              foreach ($resultado as $row2) 
                                              {
                                                ?>
                                          <option value="<?php echo $row2['modelciu']; ?>" <?php if ($row['components_ciu'] ==$row2['modelciu']) { echo "selected"; }?>><?php echo $row2['modelciu']; ?></option>
                                                <?php
                                              }
                                             
                                             
                                             ?>
                                             
                                       
                                           </select>
                                    <?php 
                                   }
                                   if ($row['idtypecomponets'] == 1) 
                                   {
                                     ///////DigitalBoard
                                     ?>
                                          <select  disabled name="nuevosnciu_<?php echo  $row['idtypecomponets'];   ?>" id="nuevosnciu_<?php echo  $row['idtypecomponets'];   ?>" class="form-control">
                                             <option value="">-Select-</option>

                                             <?php
                                           
                                             $sql = $connect->prepare("select idproduct, modelciu
                                             from fnt_select_allproducts_maxrev2() as ss
                                             where idproduct in (select idproduct from products_attributes where idattribute = 12)
                                             and active = 'Y' order by modelciu ");
                                             $sql->execute();
                                             $resultado = $sql->fetchAll();
                                              foreach ($resultado as $row2) 
                                              {
                                                ?>
                                          <option onblur="validarpcb(this.value,'')" value="<?php echo $row2['modelciu']; ?>" <?php if ($row['components_ciu'] ==$row2['modelciu']) { echo "selected"; }?>><?php echo $row2['modelciu']; ?></option>
                                                <?php
                                              }
                                             
                                             
                                             ?>
                                             
                                       
                                           </select>
                                    <?php 
                                   }
                                   if ($row['idtypecomponets'] == 3) 
                                   {
                                     ///////Power Supply
                                     ?>
                                          <select name="nuevosnciu_<?php echo  $row['idtypecomponets'];   ?>" id="nuevosnciu_<?php echo  $row['idtypecomponets'];   ?>" class="form-control">
                                             <option value="">-Select-</option>

                                             <?php
                                           
                                             $sql = $connect->prepare("select idproduct, modelciu
                                             from fnt_select_allproducts_maxrev2() as ss
                                             where idproduct in (select idproduct from products_attributes where idattribute = 67)
                                             and active = 'Y' order by modelciu ");
                                             $sql->execute();
                                             $resultado = $sql->fetchAll();
                                              foreach ($resultado as $row2) 
                                              {
                                                ?>
                                          <option value="<?php echo $row2['modelciu']; ?>" <?php if ($row['components_ciu'] ==$row2['modelciu']) { echo "selected"; }?>><?php echo $row2['modelciu']; ?></option>
                                                <?php
                                              }
                                             
                                             
                                             ?>
                                             
                                       
                                           </select>
                                    <?php 
                                   }
                                   if ( $row['idtypecomponets'] <> 2 && $row['idtypecomponets'] <> 1 && $row['idtypecomponets'] <> 3) 
                                   {
                                        ?>
                                      <input type="text" class="form-control" value="<?php echo  $row['components_ciu']; ?>"  id="nuevosnciu_<?php echo $row['idtypecomponets']; ?>" name="nuevosnciu_<?php echo $row['idtypecomponets']; ?>">
                              
                                       <?php
                                   }
                                   ?> 

                          </div>
                        </div>

                        <div class=" row">
                          <label for="inputEmail3" class="col-sm-2 col-form-label">SN:</label>
                          <div class="col-sm-10">
                            <?php
                             if (trim($row['dddd'])=="")
                             {
                               $vidprodcomp=0;
                             }
                             else
                             {
                              $vidprodcomp=$row['dddd'];
                             }
                            
                         //   echo "<br>mm el tipo de compomente ID es: ". $vidprodcomp;
                            ?>
                          <input type="hidden" name="idprodcomp<?php echo  $row['idtypecomponets'];   ?>" id="idprodcomp<?php echo  $row['idtypecomponets'];   ?>" value="<?php echo  $vidprodcomp; ?> ">
                               
                              
                          <?php
                          if ($row['idtypecomponets'] == 1) 
                          {
                            ?>
                            <input type="text" onblur="validarpcb(this.value,'nuevonamecomp_<?php echo  $row['idtypecomponets'];   ?>')" class="form-control" value="<?php echo  $row['components_sn']; ?>" id="nuevonamecomp_<?php echo  $row['idtypecomponets'];   ?>" name="nuevonamecomp_<?php echo $row['idtypecomponets']; ?>">
                            <?php
                          }
                          else
                          {
                            ?>
                            <input type="text" class="form-control" value="<?php echo  $row['components_sn']; ?>" id="nuevonamecomp_<?php echo  $row['idtypecomponets'];   ?>" name="nuevonamecomp_<?php echo $row['idtypecomponets']; ?>">
                            <?php
                          }
                          ?>
                          
                                      
                            <input type="hidden" name="cmbtypecomp<?php echo  $row['idtypecomponets'];   ?>" id="cmbtypecomp<?php echo  $row['idtypecomponets'];   ?>" value="<?php echo  $row['idtypecomponets']; ?> ">
                          </div>
                        </div>
                     <?php if ($row['idtypecomponets'] <> 3) 
                     {?>
                        <div class=" row">
                          <label for="inputEmail3" class="col-sm-2 col-form-label">Revision:</label>
                          <div class="col-sm-10">
                            <!-- acamarco-->
                          <input type="number" class="form-control" value="<?php echo  $row['components_rev']; ?>" id="nuevorev_<?php echo $row['idtypecomponets'];?>" name="nuevorev_<?php echo $row['idtypecomponets'];?>">
                          </div>
                        </div>
                      <?php } ?>
                        
                      </div>
                   
                 
                  </div>
            </div>

              <?php
            }
        
        
        ?>
          <div id="divotros" name="divotros">
          </div>

<div class="col-5">
                    <div class="card card-info">
                    <div class="card-header card-primary">
                      <h3 class="card-title">Add Other components </h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                      <div class="card-body">
                          <p align="center">
                          <br><br>
                          <b>Add Other Components</b>
                          <br><br>
                          <a href='#' onclick='replicadiv()'>
                           <i class='fas fa-plus-circle' style='font-size:60px;color:#ABABAB'></i>
                          </a>
                          </p>
                      </div>
                   
                    
                  </div>
            </div>
            
    </div>


<hr>
    <br>
    <button type="button" class="btn btn-block bg-gradient-primary btn-sm" id="picking" name="picking" onclick="validar_envio()">Save</button>
    <br>    <br>    <br>  
<!--
    ---------------------------------------
          -->

  </div>
</div>
 

    </form>
</div>




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

<script src="crypto-js.js"></script><!-- https://github.com/brix/crypto-js/releases crypto-js.js can be download from here -->

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

   
   
	$( document ).ready(function() {
		
		//Inicio mostrar hora live
		 var interval = setInterval(function() {
			 
        var momentNow = moment();
		var newYork    = momentNow.tz('America/New_York').format('ha z');
        $('#date-part').html(momentNow.format('YYYY/MM/DD') 	  );
        $('#time-part').html(momentNow.format('hh:mm:ss'));
		}, 100);
		//FIN mostrar hora live
			console.log( "ready!" );
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

        $(".form-control").bind('keypress', function(event) {
          var regex = new RegExp("^[a-zA-Z0-9 ' -]+$");
          var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
          if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
        });

			
	});
	

	// controlar inactividad en la web	
		$(document).inactivityTimeout({
                inactivityWait: 10000,
                dialogWait: 10,
                logoutUrl: 'logout.php'
            })
	// fin controlar inactividad en la web		
	
	 /* requesting data */

   function mostrar_tabla_picking(qhacemos)
   {
     if(qhacemos ==1)
     {
          $('#divmaxrev').removeClass('d-none');
		      $('#divhistorial').addClass('d-none');
     }
    if(qhacemos ==2)
     {
      $('#divhistorial').removeClass('d-none');
		      $('#divmaxrev').addClass('d-none');
     }
   }

function validar_envio()
{
  var hagosubmit='S';
  $("input").each(function(indice,elemento){
    //En cada elemento p escribimos el texto
    ///  console.log(elemento.id.substring(0,13));
    if (elemento.id.substring(0,5) =="nuevo")
    {
        //   console.log( 'a controlar: '+elemento.id +' - '+ indice);
        //   console.log($("#"+elemento.id).val()+'<-valor');
         if ( $("#"+elemento.id).val() == '')
         {
            hagosubmit='N';
         }
    }

  });

  if (hagosubmit=='S')
  {
    console.log('envio datos');
    toastr["success"]("Sending Picking information", "Picking");
    $("#picking").prop('disabled', true);
    document.frma.submit();

  }
  else
  {
    toastr["error"]("You must complete all the requested information", "Picking");
  }
}

function validarpcb(elsnff,nomintpu)
{
 // alert(elsnff);

 if (elsnff != '')
 {
  $.ajax
              ({ 
                url: 'ajax_ctrlmainpcb.php',
			        	data: "idmainpcb="+elsnff ,	
                    type: 'post',
                    async:true,
                    cache:false,
                    success: function(data)
                    {
                 //    alert(data);
                 console.log('1::'+data.mainpcbstring);
                 console.log('2::'+$('#nuevosnciu_1').val());
                     if (data.mainpcbstring ==$('#nuevosnciu_1').val())
                     {
                      if (data.script =="Y" && data.totalpass =="Y" )
                       {
                          console.log(data);
                          console.log($('#nuevosnciu_1').val());
                          $('#'+nomintpu).addClass('is-valid');
                          $('#'+nomintpu).removeClass('is-invalid');
                       }
                       else
                       {
                        $('#'+nomintpu).addClass('is-invalid');
                        $('#'+nomintpu).focus();
                        toastr["error"]("the scanned SN does not match with an acceptance record", "Picking");
                       }
                     }
                     else
                       {
                        $('#'+nomintpu).addClass('is-invalid');
                        $('#'+nomintpu).focus();
                        toastr["error"]("the scanned SN does not match with an acceptance record", "Picking");
                         
                       }
               
                                
                    }
               });
 }



 ///--- is-valid
 
 
}


   function replicadiv()
   {
     var elnum= $("#numerador").val();
    
              $.ajax
              ({ 
                url: 'ajaxdivotherspicking.php',
			      	data: "idoth="+elnum ,	
                    type: 'post',
                    async:true,
                    cache:false,
                    success: function(data)
                    {
                     
                      elnum=parseInt(elnum)+1;
                      $("#numerador").val(elnum);
                    $("#divotros").append(data);  
                                
                    }
               });
           
setTimeout(function() {
    //   console.log('a-b-c');
 $('html, body').animate({
scrollTop: $("#picking").offset().top
}, 200);


   },500);

   

   }

   function enviar_encu(tipostatus)
   {
     $("#statussn").val(tipostatus);
     var hagosubmit = 'S';
        var radioValue1 = $("input[name='txtpreguntas1']:checked").val();
            if(radioValue1){
              ///  alert("Your are a - " + radioValue);
            }
            else
            {
              hagosubmit = 'N';
            }
            var radioValue2 = $("input[name='txtpreguntas2']:checked").val();
            if(radioValue2){
              ///  alert("Your are a - " + radioValue);
            }
            else
            {
              hagosubmit = 'N';
            }
            var radioValue3 = $("input[name='txtpreguntas3']:checked").val();
            if(radioValue3){
              ///  alert("Your are a - " + radioValue);
            }
            else
            {
              hagosubmit = 'N';
            }
            var radioValue4 = $("input[name='txtpreguntas4']:checked").val();
            if(radioValue4){
              ///  alert("Your are a - " + radioValue);
            }
            else
            {
              hagosubmit = 'N';
            }
            var radioValue5 = $("input[name='txtpreguntas5']:checked").val();
            if(radioValue5){
              ///  alert("Your are a - " + radioValue);
            }
            else
            {
              hagosubmit = 'N';
            }
            var radioValue6 = $("input[name='txtpreguntas6']:checked").val();
            if(radioValue6){
              ///  alert("Your are a - " + radioValue);
            }
            else
            {
              hagosubmit = 'N';
            }
            var radioValue7 = $("input[name='txtpreguntas7']:checked").val();
            if(radioValue7){
              ///  alert("Your are a - " + radioValue);
            }
            else
            {
              hagosubmit = 'N';
            }
            var radioValue8 = $("input[name='txtpreguntas8']:checked").val();
            if(radioValue8){
              ///  alert("Your are a - " + radioValue);
            }
            else
            {
              hagosubmit = 'N';
            }
            var radioValue9 = $("input[name='txtpreguntas9']:checked").val();
            if(radioValue9){
              ///  alert("Your are a - " + radioValue);
            }
            else
            {
              hagosubmit = 'N';
            }
            var radioValue10 = $("input[name='txtpreguntas10']:checked").val();
            if(radioValue10){
              ///  alert("Your are a - " + radioValue);
            }
            else
            {
              hagosubmit = 'N';
            }
            var radioValue11 = $("input[name='txtpreguntas11']:checked").val();
            if(radioValue11){
              ///  alert("Your are a - " + radioValue);
            }
            else
            {
              hagosubmit = 'N';
            }
            var radioValue12 = $("input[name='txtpreguntas12']:checked").val();
            if(radioValue12){
              ///  alert("Your are a - " + radioValue);
            }
            else
            {
              hagosubmit = 'N';
            }
            var radioValue13 = $("input[name='txtpreguntas13']:checked").val();
            if(radioValue13){
              ///  alert("Your are a - " + radioValue);
            }
            else
            {
              hagosubmit = 'N';
            }
            var radioValue14 = $("input[name='txtpreguntas14']:checked").val();
            if(radioValue14){
              ///  alert("Your are a - " + radioValue);
            }
            else
            {
              hagosubmit = 'N';
            }
            var radioValue15 = $("input[name='txtpreguntas15']:checked").val();
            if(radioValue15){
              ///  alert("Your are a - " + radioValue);
            }
            else
            {
              hagosubmit = 'N';
            }

            var radioValue16 = $("input[name='txtpreguntas32']:checked").val();
            if(radioValue16){
              ///  alert("Your are a - " + radioValue);
            }
            else
            {
              hagosubmit = 'N';
            }


            if (  hagosubmit == 'S')
            {
              document.frma.submit();
            }
            else
            {
              
              toastr["error"]("must answer all questions", "Quality Calibration Precheck");
            }


   }

   function opendiv(div_to_open)
{
 
	if ($('#'+div_to_open).hasClass("d-none")==true)
	{
		$('#'+div_to_open).removeClass('d-none');
	}
	else
	{
		$('#'+div_to_open).addClass('d-none');
	}


}

function booramemarco(idaborrar)
{
 ///  alert(idaborrar);
   
   var arraydatoscargados =  $("#txtaddcatothersarray").val().split('|');
   var nuevostring = "";
   $.each(arraydatoscargados, function (ind, elem) { 
      procesar= elem.split('#');
      if ( procesar[0]==idaborrar)
      {
        delete  arraydatoscargados[ind];
        console.log('¡Hola :'+elem+'!'+ procesar[0]); 
      }
    
     
    }); 

    console.log(arraydatoscargados);

    $.each(arraydatoscargados, function (ind, elem) {
      console.log(elem);
     /// if (elem != 'undefined' || elem != '' )
      if (typeof(elem) != "undefined")
      {
        nuevostring = nuevostring + elem
      } 
      
    }); 
 $("#txtaddcatothersarray").val( nuevostring);
}

function agregaritem()
{
  
  var idcatmat = parseFloat($("#numerador").val())+1;
  $("#numerador").val(idcatmat);
    var v_lacategoria = $("#lascategorias").val();
    if (v_lacategoria=='')
    {
      toastr["error"]("You must select a category", "Quality Calibration ReWork");
    }
    else
    {
      var v_lacategoria_obs = $("#txtotherbycat").val();

$("#addpreg").append(" <div class='alert alert-warning alert-dismissible'><button type='button' class='close' onclick='booramemarco("+idcatmat+")' data-dismiss='alert' aria-hidden='true'>×</button>  <h5><i class='icon fas fa-exclamation-triangle'></i> "+v_lacategoria +'</h5> '+v_lacategoria_obs+' </div> ');
$("#txtaddcatothersarray").val( $("#txtaddcatothersarray").val().trim()+ idcatmat +'#'+ v_lacategoria +'#'+v_lacategoria_obs+'|');

$("#txtotherbycat").val('');

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
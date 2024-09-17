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
            header("Location: https://".$ipservidorapache."/index.php");
        }
			if ($_SESSION["a"] =="")
		{
			session_unset();
            session_destroy();
            header("Location: https://".$ipservidorapache."/index.php");
		}
		
    }
	else
	{
			session_unset();
            session_destroy();
            header("Location: https://".$ipservidorapache."/index.php");
        
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
		exit();
		
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


function buscarTexto($string, $needle, $sensibleMayusculas = false) {
  if (!$sensibleMayusculas) {
    $string = strtolower($string);
    $needle = strtolower($needle);
  }

  $posicion = strpos($string, $needle);

  return $posicion === false ? false : $posicion;
}


$v_ciu =$_REQUEST['elciu'];
///echo "aaaaaaaaaaaaaaa".$v_ciu;
$posicion = buscarTexto($v_ciu, "ANN-4");
//echo "----".$posicion;
//if ( $v_ciu == "ANN4-MTHR")
if ($posicion >0)
{
  $idencuestaglobal=5;
}

 
$posicion = buscarTexto($v_ciu, "ANN-3");
//if ( $v_ciu == "ANN3-MTHR")
if ($posicion >0)
{
  $idencuestaglobal=6;
}


$posicion = buscarTexto($v_ciu, "ANN-6");
//if ( $v_ciu == "ANN6-MTHR")
 
if ($posicion >0)
{
  $idencuestaglobal=5;
}



$posicion = buscarTexto($v_ciu, "ANN-5");
//if ( $v_ciu == "if ( $v_ciu == "ANN5-MTHR")")
if ($posicion >0)

{
  $idencuestaglobal=6;
}
 

$posicion = buscarTexto($v_ciu, "AP");
//if ( $v_ciu == "
if ( $v_ciu == "AP-D-UL")
{
  $idencuestaglobal=5;
}
 

/*
[3:26 PM] Corigliano, Agustin
3 y 5 mismo checklist

[3:26 PM] Corigliano, Agustin
4 y 6 mismo checklist

[3:26 PM] Moretti, Marco
Listoo!.


////BTTY-ANN-004 Acceptance Test = 5 

////BTTY-ANN-003 Acceptance Test = 6 
$idencuestaglobal = 5;
*/
 
////////////////////Vamos a Procesar la encuesta
if (isset($_POST['txtpreguntas59']) || isset($_POST['txtpreguntas73']) )
	{

  // print_r($_POST);

    try {
          $v_sn =$_REQUEST['elsn'];
          $v_so =$_REQUEST['elso'];
          $v_ciu =$_REQUEST['elciu'];
       
          if ($idencuestaglobal==5)
          {
            $v_resp1 = $_REQUEST['txtpreguntas59'];
            $v_resp2 = $_REQUEST['txtpreguntas60'];
            $v_resp3 = $_REQUEST['txtpreguntas61'];
            $v_resp4 = $_REQUEST['txtpreguntas62'];
            $v_resp5 = $_REQUEST['txtpreguntas63'];
            $v_resp6 = $_REQUEST['txtpreguntas64'];
            $v_resp7 = $_REQUEST['txtpreguntas65'];
            $v_resp8 = $_REQUEST['txtpreguntas66'];          
            $v_resp9 = $_REQUEST['txtpreguntas67'];
            $v_resp10 = $_REQUEST['txtpreguntas68'];
            $v_resp11 = $_REQUEST['txtpreguntas69'];
            $v_resp12 = $_REQUEST['txtpreguntas70'];         
            $v_resp13 = $_REQUEST['txtpreguntas71'];
            $v_resp14 = $_REQUEST['txtpreguntas72'];  
          }
          if ($idencuestaglobal==6)
          {
            $v_resp1 = $_REQUEST['txtpreguntas73'];
            $v_resp2 = $_REQUEST['txtpreguntas60'];
            $v_resp3 = $_REQUEST['txtpreguntas74'];
            $v_resp4 = $_REQUEST['txtpreguntas75'];
            $v_resp5 = $_REQUEST['txtpreguntas76'];
            $v_resp6 = $_REQUEST['txtpreguntas77'];
            $v_resp7 = $_REQUEST['txtpreguntas78'];
            $v_resp8 = $_REQUEST['txtpreguntas98'];          
            $v_resp9 = $_REQUEST['txtpreguntas79'];
            $v_resp10 = $_REQUEST['txtpreguntas99'];
            $v_resp11 = $_REQUEST['txtpreguntas80'];
            $v_resp12 = $_REQUEST['txtpreguntas89'];         
            $v_resp13 = $_REQUEST['txtpreguntas91'];
            $v_resp14 = $_REQUEST['txtpreguntas92'];  
            $v_resp15 = $_REQUEST['txtpreguntas93'];  
            $v_resp16 = $_REQUEST['txtpreguntas94'];  
            $v_resp17 = $_REQUEST['txtpreguntas95'];  
          }
               
        
          
          
          $v_statussn = $_REQUEST['statussn'];
          $v_txtother =  $_REQUEST['txtother']; 

          $v_txtcatmas =  str_replace($search, "", $_REQUEST['txtaddcatothersarray']);    

     //     echo  $v_statussn."aaaaaaaaaaaa:".$v_txtcatmas."<br>";
          
          $vuserfas = $_SESSION["b"];

          if ($idencuestaglobal==5)
          {
            $query_lista2  = "CALL public.sp_insert_survey_responses_bysn_annid5('$vuserfas','$v_sn','$v_so','$v_ciu',$idencuestaglobal,$v_resp1,$v_resp2,$v_resp3,$v_resp4,$v_resp5,$v_resp6,$v_resp7,$v_resp8,$v_resp9,$v_resp10,$v_resp11,$v_resp12,$v_resp13,$v_resp14 ,'$v_statussn','$v_txtother','$v_txtcatmas')";
            //     echo  $query_lista2;
          }
          if ($idencuestaglobal==6)
          {
            $query_lista2  = "CALL public.sp_insert_survey_responses_bysn_annid6('$vuserfas','$v_sn','$v_so','$v_ciu',$idencuestaglobal,$v_resp1,$v_resp2,$v_resp3,$v_resp4,$v_resp5,$v_resp6,$v_resp7,$v_resp8,$v_resp9,$v_resp10,$v_resp11,$v_resp12,$v_resp13,$v_resp14,$v_resp15,$v_resp16,$v_resp17 ,'$v_statussn','$v_txtother','$v_txtcatmas')";
               
          }
           
       
            $connect->query($query_lista2);  
          
        
            $vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
						$vaccionweb="PreCheck Insert";
            $sentenciaudit = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
            $sentenciaudit->bindParam(':userfas', $vuserfas);								
            $sentenciaudit->bindParam(':menuweb', $vmenufas);
            $sentenciaudit->bindParam(':actionweb', $vaccionweb);
          
            $vdescripaudit="BBUSCS - SN:".$v_sn."-SO:".$v_so."-CIU:".$v_ciu;		

            $sentenciaudit->bindParam(':descripaudit', $vdescripaudit);
            $sentenciaudit->bindParam(':textaudit', $query_lista2);
     //    $sentenciaudit->execute();	
          
          
          /////Generamos idruninfoo
          $vuserfas = $_SESSION["b"];
			//////outcome integral///////////////////////////////////////////////////////////////////////////////
            $sqlooutcome="select fnt_create_newid_xbusiness_station_user('".$vuserfas."','webfas.honeywell.com')";              
            $datacabez_out = $connect->query($sqlooutcome)->fetchAll();        
            $_idruninfo_reference =0;
              foreach ($datacabez_out as $rowheaders_out) 
              {      
                $_idruninfo_reference =$rowheaders_out[0];  
              }
              $vuserfas = $_SESSION["b"];        
              $query="INSERT INTO runinfodb (idruninfo,dateinfo,userruninfo,station,device,script,fasver,loginfo,dateinfom,dateserver, idruninfodb) VALUES (".$_idruninfo_reference .",to_char(now(), 'YYYY-MM-DD HH24:MI:SS'),'".$vuserfas."','webfas','webfas','PreCheck Web','1.0.0','  -    Execute Action PRECHECK in WEBFAS <br>', now(),now(),".$_idruninfo_reference .")";
              $connect->query($query)->fetchAll();            
              $typework= $_REQUEST['typeworkm'];  ///'PRECHECK';
              $stepidsap = $_REQUEST['stepidsap'];
              if ($typework =="")
              {
                $typework="PRECHECK";
              }
            
              $query="call sp_update_runinfo_log (".$_idruninfo_reference.",'  ----------------------------------------- \n')  "; $querySQL = $connect->prepare($query);	$querySQL->execute();
              $query="call sp_update_runinfo_log (".$_idruninfo_reference.",'  Execute Action PRECHECK in WEBFAS\n')  "; $querySQL = $connect->prepare($query);	$querySQL->execute();
              $query="call sp_update_runinfo_log (".$_idruninfo_reference.",'  ----------------------------------------- \n')  "; $querySQL = $connect->prepare($query);	$querySQL->execute();
              $query="call sp_update_runinfo_log (".$_idruninfo_reference.",'   IdRuninfo: ".$_idruninfo_reference."  \n ')"; $querySQL = $connect->prepare($query);	$querySQL->execute();
              $query="call sp_update_runinfo_log (".$_idruninfo_reference.",'   Input  Parameters \n')  "; $querySQL = $connect->prepare($query);	$querySQL->execute();
              $query="call sp_update_runinfo_log (".$_idruninfo_reference.",'   SO: ".str_replace("'", '"', $v_so)." \n')  "; $querySQL = $connect->prepare($query);	$querySQL->execute();
              $query="call sp_update_runinfo_log (".$_idruninfo_reference.",'   PART NUMBER: ".str_replace("'", '"', $v_ciu)." \n')  "; $querySQL = $connect->prepare($query);	$querySQL->execute();
              $query="call sp_update_runinfo_log (".$_idruninfo_reference.",'   SN: ".str_replace("'", '"', $v_sn)." \n')  "; $querySQL = $connect->prepare($query);	$querySQL->execute();
              $query="call sp_update_runinfo_log (".$_idruninfo_reference.",'   WORKCENTER : ".str_replace("'", '"',  $typework)." \n')  "; $querySQL = $connect->prepare($query);	$querySQL->execute();
         
              
              //////////  0 - 3 CIU
              $v_stringdata=   $v_ciu;
              $v_categoryoutcome= 0;
              $v_catidtype= 3;
                  
                  $sentenciach = $connect->prepare("select fnt_insert_return_fas_outcome_integral(:idfasoutcomecat, :idtype, :reference, null, null, null, :v_string, null);");
                          $sentenciach->bindParam(':idfasoutcomecat', $v_categoryoutcome);			
                          $sentenciach->bindParam(':idtype', $v_catidtype);			
                          $sentenciach->bindParam(':reference', $_idruninfo_reference);								
                          $sentenciach->bindParam(':v_string', $v_stringdata); 
                          $sentenciach->execute();
            
           
     //////////  0 - 2 SO
              $v_stringdata=   $v_so;
              $v_categoryoutcome= 0;
              $v_catidtype= 2;
                  
                  $sentenciach = $connect->prepare("select fnt_insert_return_fas_outcome_integral(:idfasoutcomecat, :idtype, :reference, null, null, null, :v_string, null);");
                          $sentenciach->bindParam(':idfasoutcomecat', $v_categoryoutcome);			
                          $sentenciach->bindParam(':idtype', $v_catidtype);			
                          $sentenciach->bindParam(':reference', $_idruninfo_reference);								
                          $sentenciach->bindParam(':v_string', $v_stringdata); 
                          $sentenciach->execute();

              //////////  0 - 4 SN
              $v_stringdata=   $v_sn;
              $v_categoryoutcome= 0;
              $v_catidtype= 4;
              $sentenciach = $connect->prepare("select fnt_insert_return_fas_outcome_integral(:idfasoutcomecat, :idtype, :reference, null, null, null, :v_string, null);");
                  
                          $sentenciach->bindParam(':idfasoutcomecat', $v_categoryoutcome);			
                          $sentenciach->bindParam(':idtype', $v_catidtype);			
                          $sentenciach->bindParam(':reference', $_idruninfo_reference);								
                          $sentenciach->bindParam(':v_string', $v_stringdata); 
                          $sentenciach->execute();

                 
                           //////////  0 - 16 User
              $v_stringdata=   $vuserfas;
              $v_categoryoutcome= 0;
              $v_catidtype= 16;
              $sentenciach = $connect->prepare("select fnt_insert_return_fas_outcome_integral(:idfasoutcomecat, :idtype, :reference, null, null, null, :v_string, null);");
                  
                          $sentenciach->bindParam(':idfasoutcomecat', $v_categoryoutcome);			
                          $sentenciach->bindParam(':idtype', $v_catidtype);			
                          $sentenciach->bindParam(':reference', $_idruninfo_reference);								
                          $sentenciach->bindParam(':v_string', $v_stringdata); 
                          $sentenciach->execute();

                            //////////  0 - 16 User
                            $v_categoryoutcome= 0;
                            $v_catidtype= 13;
                           if ($v_statussn =="FAIL")
                            {
                              $v_stringdatabb=  0;
                              $sentenciach = $connect->prepare("select fnt_insert_return_fas_outcome_integral(:idfasoutcomecat, :idtype, :reference, :v_boolean, null, null,null, null);");
                        //      echo "---tengo fail----".$v_statussn."hOLAAA ".$v_stringdatabb;
                              $sentenciach->bindParam(':idfasoutcomecat', $v_categoryoutcome);			
                              $sentenciach->bindParam(':idtype', $v_catidtype);			
                              $sentenciach->bindParam(':reference', $_idruninfo_reference);								
                              $sentenciach->bindParam(':v_boolean', $v_stringdatabb); 
                              $sentenciach->execute();
                            }
                            else
                            {
                              $v_stringdatabb=  1;
                              $sentenciach = $connect->prepare("select fnt_insert_return_fas_outcome_integral(:idfasoutcomecat, :idtype, :reference, :v_boolean, null, null,null, null);");
                          //    echo "---no tengo fail----".$v_statussn."hOLAAA ".$v_stringdatabb;
                              $sentenciach->bindParam(':idfasoutcomecat', $v_categoryoutcome);			
                              $sentenciach->bindParam(':idtype', $v_catidtype);			
                              $sentenciach->bindParam(':reference', $_idruninfo_reference);								
                              $sentenciach->bindParam(':v_boolean', $v_stringdatabb); 
                              $sentenciach->execute();
                            }

        

                             //////////  12-15 init picking
              $v_stringdata=   $v_sn;
              $v_categoryoutcome= 0;
              $v_catidtype= 12;
              if ( $typework=="PRECHECK")
              {
                $idscriptprecheck = 49;
              }
              else
              {
                if ($typework=="wo_PRECHECK")
                {
                    $idscriptprecheck = 49;
                }
                if ($typework=="FINALCAL")
                {
                    $idscriptprecheck = 60;
                }
                else
                {
                  $idscriptprecheck = 59;
                }
                
              }
             // $idscriptprecheck = 49;
              $sentenciach = $connect->prepare("select fnt_insert_return_fas_outcome_integral(:idfasoutcomecat, :idtype, :reference, null, :v_integer, null, :v_string, null);");                  
                          $sentenciach->bindParam(':idfasoutcomecat', $v_categoryoutcome);			
                          $sentenciach->bindParam(':idtype', $v_catidtype);			
                          $sentenciach->bindParam(':reference', $_idruninfo_reference);	
                          $sentenciach->bindParam(':v_string', $v_stringdata); 							
                          $sentenciach->bindParam(':v_integer', $idscriptprecheck); 
                          $sentenciach->execute();

            ///Steps ID SAP XML--------------------------------------------------------------------------------
                      
            $v_categoryoutcome= 0;
            $v_catidtype= 66;
            
            $v_stringdata=  $stepidsap;
            if ( $v_stringdata <> "")
            {
                $sentenciach = $connect->prepare("select fnt_insert_return_fas_outcome_integral(:idfasoutcomecat, :idtype, :reference, null,null, null, :v_string, null);");                  
                $sentenciach->bindParam(':idfasoutcomecat', $v_categoryoutcome);			
                $sentenciach->bindParam(':idtype', $v_catidtype);			
                $sentenciach->bindParam(':reference', $_idruninfo_reference);	
                $sentenciach->bindParam(':v_string', $v_stringdata); 							
                
                $sentenciach->execute();
            }
      

          /////fin idruninfo
          
            $msjok="Save OK.!";
          } 
          catch (PDOException $e) 
          {
            $connect->rollBack();
            $return_result_insert="error".$e->getMessage();
            $msjerr= "Syntax Error MM: ".$e->getMessage();
            echo $msjerr;
          }
						

    //Or:
    /*
    foreach ($_POST as $key => $value)
    {
        echo $key.'='.$value.'<br />';
    }
    */


    //sp_insert_survey_responses_bysn/

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
<form name="frmae" id="frmae" method="post">
    <input type="hidden" name="uso" id="uso" value="0">

    <body class="hold-transition sidebar-mini sidebar-collapse">
        <!-- Site wrapper -->



        <!-- Content Wrapper. Contains page content -->
        <div>

</form>
<form name="frma" id="frma" action="calibrationqualitychecklisallsurvery.php" method="post" class="form-horizontal">

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!-- Timelime example  -->
            <div class="row">
                <section class="col-lg-12 connectedSortable ui-sortable">

                    <div class="" name="divscrolllog" id="divscrolllog" style="display.">
                        <p name="msjwaitline" id="msjwaitline" align="center"><img src="img/waitazul.gif" width="100px">
                        </p>
                        <div class="card">
                            <!-- tabla de preguntas  -->
                            <div class="container-fluid">
                                <br>
                                <?php
                  $elso = $_REQUEST['elso'];
                  $elsn = $_REQUEST['elsn'];
                  $elciu = $_REQUEST['elciu'];
                  
                  ?>
                                <input type="hidden" name="elso" id="elso" value="<?php echo $elso; ?>">
                                <input type="hidden" name="elsn" id="elsn" value="<?php echo $elsn; ?>">
                                <input type="hidden" name="elciu" id="elciu" value="<?php echo $elciu; ?>">
                                <input type="hidden" name="statussn" id="statussn" value="">


                                <?php
		  
		  if ($msjok <> "")
		  {
			  ?>
                                <div id="aa1" name="aa1" class="alert alert-success alert-dismissible">

                                    <h5><i class="icon fas fa-check"></i> Save Ok!</h5>

                                </div>

                                <?php
        
		  }
		  ?>
                                <h5 class="colorazulfiplex"> <?php echo "".$elso." || ". $elsn." || ".  $elciu ?> </h5>
                                <div class="container-fluid">

                                    <?php
                  $cantderegistro=0;
                      $query_lista="select * from fas_survey_responses_bysn where idsurvey = ".$idencuestaglobal." and sn ='".$elsn."' and so='".$elso."' order by datetimecheck desc ";
                 //    echo "HOLA".$query_lista;
                      $data = $connect->query($query_lista)->fetchAll();	
                      foreach ($data as $row) 
                      {
                        $cantderegistro=1;
                      }
                    //  echo "cant regitro".$cantderegistro;
                      if ($cantderegistro==1)
                      {

                      
                  ?>
                                    <br>
                                    <button name="btnopenrf" id="btnopenrf" type="button"
                                        class="btn btn-smk btn-block btn-outline-primary btn-flat"
                                        onclick="opendiv('tablehistotyprecheck')"> Precheck history</button>
                                    <br>

                                    <div class="row <?php if($_REQUEST['eyeid']=="") { echo " "; } ?> "
                                        id="tablehistotyprecheck" name="tablehistotyprecheck">

                                        <section class="col-lg-6 connectedSortable ui-sortable">
                                            <table class="table table-striped table-responsive ">
                                                <thead class="thead-dark">
                                                    <tr>

                                                        <th scope="col">SN</th>
                                                        <th scope="col">SO</th>
                                                        <th scope="col">CIU</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col">Registered date</th>
                                                        <th scope="col">User</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                         $query_lista="select * from fas_survey_responses_bysn where idsurvey = ".$idencuestaglobal." and sn ='".$elsn."' and so='".$elso."' and modelciu = '".$elciu."' order by datetimecheck desc ";
                     
                         $data = $connect->query($query_lista)->fetchAll();	
                         $vidsurveyresponse = 0;
                         $colorstyle="";
                         foreach ($data as $row) 
                         {
                          $colorstyle="black";
                           if ($vidsurveyresponse ==0 && $_REQUEST['eyeid']=="" || $_REQUEST['eyeid']==$row['idsurveyresponse'])
                           {
                             $vidsurveyresponse =  $row['idsurveyresponse'];
                             $vfecha =  $row['datetimecheck'];
                             $ultestado = $row['status_sn'];
                             $note_others = $row['note_others'];
                             $colorstyle="blue;font-size:16px";
                           }
                            ?>
                                                    <tr>
                                                        <td><?php echo  $row['sn']; ?>
                                                            &nbsp;&nbsp; <a
                                                                href='calibrationqualitychecklisallsurvery.php?elsn=<?php echo $row['sn']; ?>&elso=<?php echo $row['so']; ?>&elciu=<?php echo $row['modelciu']; ?>&eyeid=<?php echo $row['idsurveyresponse']; ?>'><i
                                                                    class='fas fa-eye'
                                                                    style='color:<?php echo  $colorstyle;?>'></i>&nbsp;View
                                                            </a></td>
                                                        <td><?php echo  $row['so']; ?> </td>
                                                        <td><?php echo  $row['modelciu']; ?> </td>
                                                        <td><?php       if ($row['status_sn']=="FAIL")
                                              {
                                                echo "<span class='badge bg-danger'>FAIL</span>";
                                              }
                                              if ($row['status_sn']=="PASS")
                                              {
                                                  echo "<span class='badge bg-success'>PASSED</span>";
                                              }
                                              
                                  ?> </td>
                                                        <td><?php echo  substr($row['datetimecheck'],0,19); ?> </td>
                                                        <td><?php echo  $row['usercheck']; ?> </td>

                                                    </tr>
                                                    <?php
                         }
                    ?>
                                                </tbody>
                                            </table>
                                        </section>
                                        <section class="col-lg-6 connectedSortable ui-sortable">
                                            <table class="table table-striped table-responsive ">
                                                <thead class="thead-dark">
                                                    <tr>

                                                        <th scope="col">Quality Precheck : <?php echo   substr($vfecha,0,19) ."&nbsp;";   
                                              if ($ultestado=="FAIL")
                                              {
                                                echo "<span class='badge bg-danger'>FAIL</span>";
                                              }
                                              if ($ultestado=="PASS")
                                              {
                                                  echo "<span class='badge bg-success'>PASSED</span>";
                                              } ?> <br>Questions</th>
                                                        <th scope="col">Answers</th>
                                                        <th scope="col">Corrections</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                         $query_lista="select * from fas_survey_responses inner join fas_questions on fas_questions.idquestion = fas_survey_responses.idquestion inner join fas_answers on fas_answers.idanswer  = fas_survey_responses.idanswer  where idsurveyresponse =".   $vidsurveyresponse." order by fas_survey_responses.idquestion ";
    //  echo $query_lista;
                         $data = $connect->query($query_lista)->fetchAll();	
                         foreach ($data as $row) 
                         {
                            ?>
                                                    <tr>
                                                        <td><?php echo  $row['descriptionq']; 
                              $losreworks = explode(":", $row['corrections']);
                                if ( $row['idquestion'] =="19")
                                {
                                  echo  "<b>&nbsp;".$row['descriptiona']."</b>"; 
                                }
                                else
                                {
                                  echo  $row['descriptiona']; 
                                }
                                ?> </td>
                                                        <td><?php 
                                if ( $row['idquestion'] =="19")
                                {
                               //   echo  $row['descriptiona'].":".$row['corrections']; 
                               
                                }
                                else
                                {
                                  echo  $row['descriptiona']; 
                                }
                           ?> </td>
                                                        <td><?php   
                                  echo  $row['corrections'];
                                
                               ?> </td>

                                                    </tr>
                                                    <?php
                         }
                    ?>
                                                    <tr>

                                                        <td colspan="3"><b>Others:</b> <?php echo     $note_others ; ?>
                                                        </td>

                                                    </tr>
                                                </tbody>
                                            </table>
                                        </section>
                                        <br>
                                        <hr>

                                        <?php } ?>
                                    </div>



                                    <br>
                                    <button name="btnopenrf" id="btnopenrf" type="button"
                                        class="btn btn-smk btn-block btn-outline-primary btn-flat"
                                        onclick="opendiv('tableprechecknew')">
                                        <?php if ($vidsurveyresponse =="")
                  {
                     echo "Create a new BBU Integration Checklist";
                  }
                  else
                  {
                    echo "ReWork";
                  }
                  ?>
                                    </button>
                                    <br>
                                    <div class="table-responsive <?php if ($cantderegistro==0) { echo ""; } else { echo "d-none"; } ?>"
                                        id="tableprechecknew" name="tablehistotytableprechecknewprecheck">
                                        <table class="table table-striped table-responsive">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Questions</th>
                                                    <th scope="col">Answers</th>


                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
 /*   $query_lista="
    select distinct fas_questions.idquestion, descriptionq ,orderreport
    from fas_survey_questiosn_answers
    inner join fas_questions
    on fas_questions.idquestion = fas_survey_questiosn_answers.idquestion
    where fas_survey_questiosn_answers.idsurvey = 1
    order by orderreport ";*/
    if ($vidsurveyresponse == "")
    {
      $query_lista="
      select distinct fas_questions.idquestion, descriptionq ,orderreport, lasrespuesta.idanswer as laultrespuesta, lasrespuesta.corrections
  from fas_survey_questiosn_answers
  inner join fas_questions
  on fas_questions.idquestion = fas_survey_questiosn_answers.idquestion
  left join (
  select fas_survey_responses.* from fas_survey_responses inner join fas_questions on fas_questions.idquestion = fas_survey_responses.idquestion 
    inner join fas_answers on fas_answers.idanswer  = fas_survey_responses.idanswer  where idsurveyresponse = 0 order by fas_survey_responses.idquestion
  ) as lasrespuesta
  on lasrespuesta.idquestion = fas_survey_questiosn_answers.idquestion
  where fas_survey_questiosn_answers.idsurvey = ".$idencuestaglobal."
  order by orderreport ";
    }
    else
    {
      $query_lista="
      select distinct fas_questions.idquestion, descriptionq ,orderreport, lasrespuesta.idanswer as laultrespuesta, lasrespuesta.corrections
  from fas_survey_questiosn_answers
  inner join fas_questions
  on fas_questions.idquestion = fas_survey_questiosn_answers.idquestion
  left join (
  select fas_survey_responses.* from fas_survey_responses inner join fas_questions on fas_questions.idquestion = fas_survey_responses.idquestion 
    inner join fas_answers on fas_answers.idanswer  = fas_survey_responses.idanswer  where idsurveyresponse = ".   $vidsurveyresponse." order by fas_survey_responses.idquestion
  ) as lasrespuesta
  on lasrespuesta.idquestion = fas_survey_questiosn_answers.idquestion
  where fas_survey_questiosn_answers.idsurvey = ".$idencuestaglobal."
  order by orderreport ";
    }
  

//echo  $query_lista."-----".$vidsurveyresponse;
$idpreguntas= 1;
    	$data = $connect->query($query_lista)->fetchAll();	
      foreach ($data as $row) 
      {	
    
    ?> <tr>
                                                    <th scope="row">
                                                        <?php echo $idpreguntas;  $idpreguntas = $idpreguntas + 1; ////$row['idquestion']; ?>
                                                    </th>
                                                    <td><span
                                                            style="font-size:14px;"><b><?php echo $row['descriptionq']; ?></b></span>
                                                    </td>
                                                    <td>

                                                        <table class="table table-responsive">

                                                            <tr>

                                                                <?php

                  if ($row['idquestion']==5556 || $row['idquestion']==5557  || $row['idquestion']==5558)
                  {
                    ?> File Upload
                                                                <?php
                  }
                  else
                  {

                  
                    ?>
                                                                <th scope="col"><span class="form-control-sm"><input
                                                                            type="radio"
                                                                            id="txtpreguntas1<?php echo $row['idquestion']; ?>"
                                                                            name="txtpreguntas<?php echo $row['idquestion']; ?>"
                                                                            value="8"
                                                                            <?php if( "8"== $row['laultrespuesta']) { echo "checked";}?>>
                                                                        Pass </span></th>
                                                                <th scope="col"><span class="form-control-sm"><input
                                                                            type="radio"
                                                                            id="txtpreguntas2<?php echo $row['idquestion']; ?>"
                                                                            name="txtpreguntas<?php echo $row['idquestion']; ?>"
                                                                            value="9"
                                                                            <?php if( "9"== $row['laultrespuesta']) { echo "checked";}?>>
                                                                        Fail </span></th>


                                                                <?php
                  }
                    if ($row['idquestion']==51 || $row['idquestion']==52 || $row['idquestion'] ==53 || $row['idquestion']==54)
                    {
                      ?>
                                                                <th scope="col"><span class="form-control-sm"><input
                                                                            type="radio"
                                                                            id="txtpreguntas3<?php echo $row['idquestion']; ?>"
                                                                            name="txtpreguntas<?php echo $row['idquestion']; ?>"
                                                                            value="3"
                                                                            <?php if( "3"== $row['laultrespuesta']) { echo "checked";}?>>
                                                                        N/A </span></th>
                                                                <?php
                    }
                    
                    ?>
                                                            </tr>

                                                            <?php

                    if ($row['idquestion']==36 || $row['idquestion']==37 )
                    {
                      ?>
                                                            <tr>
                                                                <td colspan=3>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        name="txtcorre<?php echo $row['idquestion']; ?>"
                                                                        id="txtcorre<?php echo $row['idquestion']; ?>"
                                                                        value="<?php echo $row['corrections']; ?>">
                                                                </td>
                                                            </tr>
                                                            <?php
                    }

                ?>


                                                        </table>


                                                    </td>

                                                </tr>
                                                <?php
      }
   ?>

                                                <?php
   
      ?>
                                                <td colspan="3" class="text-right">
                                                    <input type="hidden" name="idencuestaglobal" id="idencuestaglobal"
                                                        value="<?php echo $idencuestaglobal;?>">
                                                    <?php
     //// echo "a ver:::".$vidsurveyresponse;
      if ($vidsurveyresponse =="")
      {
        if ( $elso <> "")
        {
         ?>
                                                    <button name="btnstop" id="btnstop" type="button"
                                                        onclick="enviar_encu('FAIL')"
                                                        class="btn btn-outline-danger left-align"> <i
                                                            class="fas fa-times"></i> FAIL</button>
                                                    &nbsp;&nbsp;&nbsp;

                                                    <button name="btnrun" id="btnrun" type="button"
                                                        onclick="enviar_encu('PASS')"
                                                        class="btn btn-outline-success right-align"> <i
                                                            class="fas fa-check"></i> PASS</button>

                                                    <?php
        }
      }
      else
      {
        ?>


                                                    <button name="btnrun" id="btnrun" type="button"
                                                        onclick="enviar_encu('FAIL#PASS')"
                                                        class="btn btn-outline-success right-align"> <i
                                                            class="fas fa-check"></i> OK</button>

                                                    <?php
      }
      $typework= $_REQUEST['typeworkm'];  ///'PRECHECK';
      $stepidsap= $_REQUEST['stepidsap'];  ///'PRECHECK';
       
       ?>
                                                    <input type="hidden" class="form-control form-control-sm"
                                                        name="typeworkm" id="typeworkm"
                                                        value="<?php echo $typework; ?>">

                                                    <input type="hidden" class="form-control form-control-sm"
                                                        name="stepidsap" id="stepidsap"
                                                        value="<?php echo $stepidsap; ?>">

                                                </td>

                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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
    console.log("ready!");
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

function enviar_encu(tipostatus) {
    $("#statussn").val(tipostatus);

    var qencueses = $("#idencuestaglobal").val();
    var hagosubmit = 'S';
    if (qencueses == 5) {
        var radioValue1 = $("input[name='txtpreguntas59']:checked").val();
        if (radioValue1) {
            ///  alert("Your are a - " + radioValue);
        } else {
            hagosubmit = 'N';
        }
        var radioValue2 = $("input[name='txtpreguntas60']:checked").val();
        if (radioValue2) {
            ///  alert("Your are a - " + radioValue);
        } else {
            hagosubmit = 'N';
        }
        var radioValue3 = $("input[name='txtpreguntas61']:checked").val();
        if (radioValue3) {
            ///  alert("Your are a - " + radioValue);
        } else {
            hagosubmit = 'N';
        }
        var radioValue4 = $("input[name='txtpreguntas62']:checked").val();
        if (radioValue4) {
            ///  alert("Your are a - " + radioValue);
        } else {
            hagosubmit = 'N';
        }
        var radioValue5 = $("input[name='txtpreguntas63']:checked").val();
        if (radioValue5) {
            ///  alert("Your are a - " + radioValue);
        } else {
            hagosubmit = 'N';
        }
        var radioValue6 = $("input[name='txtpreguntas64']:checked").val();
        if (radioValue6) {
            ///  alert("Your are a - " + radioValue);
        } else {
            hagosubmit = 'N';
        }
        var radioValue7 = $("input[name='txtpreguntas64']:checked").val();
        if (radioValue7) {
            ///  alert("Your are a - " + radioValue);
        } else {
            hagosubmit = 'N';
        }
        var radioValue8 = $("input[name='txtpreguntas65']:checked").val();
        if (radioValue8) {
            ///  alert("Your are a - " + radioValue);
        } else {
            hagosubmit = 'N';
        }
        var radioValue9 = $("input[name='txtpreguntas66']:checked").val();
        if (radioValue9) {
            ///  alert("Your are a - " + radioValue);
        } else {
            hagosubmit = 'N';
        }
        //// upload de file 56,57,58
        var radioValue_56 = $("input[name='txtpreguntas67']:checked").val();
        if (radioValue_56) {
            ///  alert("Your are a - " + radioValue);
        } else {
            hagosubmit = 'N';
        }
        var radioValue_57 = $("input[name='txtpreguntas68']:checked").val();
        if (radioValue_57) {
            ///  alert("Your are a - " + radioValue);
        } else {
            hagosubmit = 'N';
        }
        var radioValue_58 = $("input[name='txtpreguntas69']:checked").val();
        if (radioValue_58) {
            ///  alert("Your are a - " + radioValue);
        } else {
            hagosubmit = 'N';
        }
        var radioValue13 = $("input[name='txtpreguntas70']:checked").val();
        if (radioValue13) {
            ///  alert("Your are a - " + radioValue);
        } else {
            hagosubmit = 'N';
        }
        var radioValue14 = $("input[name='txtpreguntas71']:checked").val();
        if (radioValue14) {
            ///  alert("Your are a - " + radioValue);
        } else {
            hagosubmit = 'N';
        }
        var radioValue15 = $("input[name='txtpreguntas72']:checked").val();
        if (radioValue15) {
            ///  alert("Your are a - " + radioValue);
        } else {
            hagosubmit = 'N';
        }
    }
    /////////////////////////////////////////////////////////////////////////////////////////
    if (qencueses == 6) {
        var radioValue1 = $("input[name='txtpreguntas73']:checked").val();
        if (radioValue1) {
            ///  alert("Your are a - " + radioValue);
        } else {
            hagosubmit = 'N';
        }
        var radioValue2 = $("input[name='txtpreguntas60']:checked").val();
        if (radioValue2) {
            ///  alert("Your are a - " + radioValue);
        } else {
            hagosubmit = 'N';
        }
        var radioValue3 = $("input[name='txtpreguntas74']:checked").val();
        if (radioValue3) {
            ///  alert("Your are a - " + radioValue);
        } else {
            hagosubmit = 'N';
        }
        var radioValue4 = $("input[name='txtpreguntas75']:checked").val();
        if (radioValue4) {
            ///  alert("Your are a - " + radioValue);
        } else {
            hagosubmit = 'N';
        }
        var radioValue5 = $("input[name='txtpreguntas76']:checked").val();
        if (radioValue5) {
            ///  alert("Your are a - " + radioValue);
        } else {
            hagosubmit = 'N';
        }
        var radioValue6 = $("input[name='txtpreguntas77']:checked").val();
        if (radioValue6) {
            ///  alert("Your are a - " + radioValue);
        } else {
            hagosubmit = 'N';
        }
        var radioValue7 = $("input[name='txtpreguntas78']:checked").val();
        if (radioValue7) {
            ///  alert("Your are a - " + radioValue);
        } else {
            hagosubmit = 'N';
        }
        var radioValue8 = $("input[name='txtpreguntas98']:checked").val();
        if (radioValue8) {
            ///  alert("Your are a - " + radioValue);
        } else {
            hagosubmit = 'N';
        }
        var radioValue9 = $("input[name='txtpreguntas79']:checked").val();
        if (radioValue9) {
            ///  alert("Your are a - " + radioValue);
        } else {
            hagosubmit = 'N';
        }
        //// upload de file 56,57,58
        var radioValue_56 = $("input[name='txtpreguntas99']:checked").val();
        if (radioValue_56) {
            ///  alert("Your are a - " + radioValue);
        } else {
            hagosubmit = 'N';
        }
        var radioValue_57 = $("input[name='txtpreguntas80']:checked").val();
        if (radioValue_57) {
            ///  alert("Your are a - " + radioValue);
        } else {
            hagosubmit = 'N';
        }
        var radioValue_58 = $("input[name='txtpreguntas89']:checked").val();
        if (radioValue_58) {
            ///  alert("Your are a - " + radioValue);
        } else {
            hagosubmit = 'N';
        }
        var radioValue13 = $("input[name='txtpreguntas91']:checked").val();
        if (radioValue13) {
            ///  alert("Your are a - " + radioValue);
        } else {
            hagosubmit = 'N';
        }
        var radioValue14 = $("input[name='txtpreguntas92']:checked").val();
        if (radioValue14) {
            ///  alert("Your are a - " + radioValue);
        } else {
            hagosubmit = 'N';
        }
        var radioValue15 = $("input[name='txtpreguntas93']:checked").val();
        if (radioValue15) {
            ///  alert("Your are a - " + radioValue);
        } else {
            hagosubmit = 'N';
        }
        var radioValue15 = $("input[name='txtpreguntas94']:checked").val();
        if (radioValue15) {
            ///  alert("Your are a - " + radioValue);
        } else {
            hagosubmit = 'N';
        }
        var radioValue15 = $("input[name='txtpreguntas95']:checked").val();
        if (radioValue15) {
            ///  alert("Your are a - " + radioValue);
        } else {
            hagosubmit = 'N';
        }
    }
    /////////////////////////////////////////////////////////////////////////////////////////




    if (hagosubmit == 'S') {
        document.frma.submit();
    } else {

        toastr["error"]("must answer all questions", "BBU Integration Checklist");
    }


}

function opendiv(div_to_open) {

    if ($('#' + div_to_open).hasClass("d-none") == true) {
        $('#' + div_to_open).removeClass('d-none');
    } else {
        $('#' + div_to_open).addClass('d-none');
    }


}

function booramemarco(idaborrar) {
    ///  alert(idaborrar);

    var arraydatoscargados = $("#txtaddcatothersarray").val().split('|');
    var nuevostring = "";
    $.each(arraydatoscargados, function(ind, elem) {
        procesar = elem.split('#');
        if (procesar[0] == idaborrar) {
            delete arraydatoscargados[ind];
            console.log('¡Hola :' + elem + '!' + procesar[0]);
        }


    });

    console.log(arraydatoscargados);

    $.each(arraydatoscargados, function(ind, elem) {
        console.log(elem);
        /// if (elem != 'undefined' || elem != '' )
        if (typeof(elem) != "undefined") {
            nuevostring = nuevostring + elem
        }

    });
    $("#txtaddcatothersarray").val(nuevostring);
}

function agregaritem() {

    var idcatmat = parseFloat($("#numerador").val()) + 1;
    $("#numerador").val(idcatmat);
    var v_lacategoria = $("#lascategorias").val();
    if (v_lacategoria == '') {
        toastr["error"]("You must select a category", "Quality Calibration ReWork");
    } else {
        var v_lacategoria_obs = $("#txtotherbycat").val();

        $("#addpreg").append(
            " <div class='alert alert-warning alert-dismissible'><button type='button' class='close' onclick='booramemarco(" +
            idcatmat +
            ")' data-dismiss='alert' aria-hidden='true'>×</button>  <h5><i class='icon fas fa-exclamation-triangle'></i> " +
            v_lacategoria + '</h5> ' + v_lacategoria_obs + ' </div> ');
        $("#txtaddcatothersarray").val($("#txtaddcatothersarray").val().trim() + idcatmat + '#' + v_lacategoria + '#' +
            v_lacategoria_obs + '|');

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
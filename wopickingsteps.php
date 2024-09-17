<!DOCTYPE html>
<?php 

// Desactivar toda notificación de error
error_reporting(0);
// Notificar todos los errores de PHP (ver el registro de cambios)
//
 include("db_conect.php"); 
 //error_reporting(E_ALL);
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

////////////////////Vamos a Procesar
$v_sn =$_REQUEST['elsn'];
$v_so =$_REQUEST['elso'];
$v_ciu =$_REQUEST['elciu'];

$idorders_sinsnasign  =$_REQUEST['idruninfoparam'];
 
 
 
if (isset($_POST['numerador']))
	{

//  print_r($_POST);
 
  
 
    try {
          $v_sn =$_REQUEST['elsn'];
          $v_so =$_REQUEST['elso'];
          $v_ciu =$_REQUEST['elciu'];
          $nrorev = $_POST['nrorev'];
          $_idruninfo_reference= $_POST['vv_idruninfo'];
          $typesave = $_POST['typesave'];

    //     echo "aaaaa".$typesave;

    
          /////////// GENERATION IDRUNINFO
          $vuserfas = $_SESSION["b"];
        
          $query="INSERT INTO runinfodb (idruninfo,dateinfo,userruninfo,station,device,script,fasver,loginfo,dateinfom,dateserver, idruninfodb) VALUES (".$_idruninfo_reference .",to_char(now(), 'YYYY-MM-DD HH24:MI:SS'),'".$vuserfas."','webfas','webfas','Picking  Web','1.0.0','  -    Execute Action PICKING in WEBFAS <br>', now(),now(),".$_idruninfo_reference .")";
          $connect->query($query)->fetchAll();
    
         //  echo "INSERTO22222222".$_idruninfo_reference;
        
        
          $query="call sp_update_runinfo_log (".$_idruninfo_reference.",'  ----------------------------------------- \n')  "; $querySQL = $connect->query($query)->fetchAll();	//$querySQL->execute();
          $query="call sp_update_runinfo_log (".$_idruninfo_reference.",'  Execute Action PICKING in WEBFAS\n')  "; $querySQL = $connect->query($query)->fetchAll();	//$querySQL->execute();
          $query="call sp_update_runinfo_log (".$_idruninfo_reference.",'  ----------------------------------------- \n')  "; $querySQL = $connect->query($query)->fetchAll();	//$querySQL->execute();
          $query="call sp_update_runinfo_log (".$_idruninfo_reference.",'   Idr Runinfo: ".$_idruninfo_reference."    \n')  "; $querySQL = $connect->query($query)->fetchAll();	//$querySQL->execute();
          $query="call sp_update_runinfo_log (".$_idruninfo_reference.",'   Input  Parameters \n')  "; $querySQL = $connect->query($query)->fetchAll();//$querySQL->execute();
          $query="call sp_update_runinfo_log (".$_idruninfo_reference.",'   SO: ".str_replace("'", '"', $v_so)." \n')  "; $querySQL = $connect->query($query)->fetchAll();	//$querySQL->execute();
          $query="call sp_update_runinfo_log (".$_idruninfo_reference.",'   PART NUMBER: ".str_replace("'", '"', $v_ciu)." \n')  "; $querySQL = $connect->query($query)->fetchAll();	//$querySQL->execute();
          $query="call sp_update_runinfo_log (".$_idruninfo_reference.",'   SN: ".str_replace("'", '"', $v_sn)." \n')  "; $querySQL = $connect->query($query)->fetchAll();	//$querySQL->execute();
          
          $query="call sp_update_runinfo_log (".$_idruninfo_reference .",'   KWMENG: ".str_replace("'", '"', $KWMENG)." \n')  ";   
          $querySQL = $connect->query($query)->fetchAll();	//$querySQL->execute();

           $query="call sp_update_runinfo_log (".$_idruninfo_reference.",'   TYPE WORKCENTER: ".str_replace("'", '"',  $_REQUEST['typeworkc'])." \n')  ";
           $querySQL = $connect->query($query)->fetchAll();	//$querySQL->execute();
          
       //   $querySQL = $conn->query($query)->fetchAll();	//$querySQL->execute();
        
          $snparam = $_REQUEST['elsn']; ///
          $elso = $_REQUEST['elso'];
          $vv_so = $_REQUEST['elso']; 

          $elsn = $_REQUEST['elsn'];
          $elciu = $_REQUEST['elciu'];
          $vv_modelciu = $_REQUEST['elciu'];
          $pasos_habilitados="";
          $v_paso1=0;

         


          $vmenufas=array_pop(explode('/', $_SERVER['PHP_SELF']));
          $vaccionweb="visitweb";
          $vdescripaudit="visitweb#".$_SERVER['SERVER_ADDR'];     
     
          $typererorkmm = substr(trim($_REQUEST['typeworkc']),3,10);
      

        
          $v_stringdata=  $vuserfas."|".$vmenufas."|".$v_so."|".$v_idproduct."|".$v_ciu."|".$v_sn."|".$_SERVER['SERVER_ADDR'];
     //   echo $v_stringdata."-------".$_idruninfo_reference;
          $v_categoryoutcome= 0;
          $v_catidtype= 0;
         
              $sentenciach = $connect->prepare("select fnt_insert_return_fas_outcome_integral(:idfasoutcomecat, :idtype, :reference, null, null, null, :v_string, null);");
                      $sentenciach->bindParam(':idfasoutcomecat', $v_categoryoutcome);			
                      $sentenciach->bindParam(':idtype', $v_catidtype);			
                      $sentenciach->bindParam(':reference', $_idruninfo_reference);								
                      $sentenciach->bindParam(':v_string', $v_stringdata); 
                      $sentenciach->execute();
                      $dataresultjson = $sentenciach->fetchAll();
        
                  //   echo "Ejecuto";
                    //  var_dump($datare 
                      $array_num = count($dataresultjson);
                    //  echo "la cantd es".$array_num;
                      for ($i = 0; $i < $array_num; ++$i){
                      //    echo $dataresultjson[$i][0];
                          $objrest = json_decode($dataresultjson[$i][0]);
                     //     echo "<br>".$objrest->v_idgenerated;
                     //     echo "<hr>";
                          $idmaxoutcome = $objrest->v_idgenerated;
                      }
                 
        
                 
                      //////////  0 - 3 CIU
                      $v_stringdata=   $vv_modelciu;
                      $v_categoryoutcome= 0;
                      $v_catidtype= 3;
                          
                          $sentenciach = $connect->prepare("select fnt_insert_return_fas_outcome_integral(:idfasoutcomecat, :idtype, :reference, null, null, null, :v_string, null);");
                                  $sentenciach->bindParam(':idfasoutcomecat', $v_categoryoutcome);			
                                  $sentenciach->bindParam(':idtype', $v_catidtype);			
                                  $sentenciach->bindParam(':reference', $_idruninfo_reference);								
                                  $sentenciach->bindParam(':v_string', $v_stringdata); 
                                 $sentenciach->execute();
                    //
                   
             //////////  0 - 2 SO
                      $v_stringdata=   $vv_so;
                      $v_categoryoutcome= 0;
                      $v_catidtype= 2;
                          
                          $sentenciach = $connect->prepare("select fnt_insert_return_fas_outcome_integral(:idfasoutcomecat, :idtype, :reference, null, null, null, :v_string, null);");
                                  $sentenciach->bindParam(':idfasoutcomecat', $v_categoryoutcome);			
                                  $sentenciach->bindParam(':idtype', $v_catidtype);			
                                  $sentenciach->bindParam(':reference', $_idruninfo_reference);								
                                  $sentenciach->bindParam(':v_string', $v_stringdata); 
                                  $sentenciach->execute();
        
                      //////////  0 - 4 SN
                      $v_stringdata=   $snparam;
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
                                    if ($typesave == "Confirm")
                                    {

                                        $v_stringdata=   true;
                                        $v_categoryoutcome= 0;
                                        $v_catidtype= 13;
                                        $sentenciach = $connect->prepare("select fnt_insert_return_fas_outcome_integral(:idfasoutcomecat, :idtype, :reference, :v_boolean, null, null,null, null);");
                                            
                                                    $sentenciach->bindParam(':idfasoutcomecat', $v_categoryoutcome);			
                                                    $sentenciach->bindParam(':idtype', $v_catidtype);			
                                                    $sentenciach->bindParam(':reference', $_idruninfo_reference);								
                                                    $sentenciach->bindParam(':v_boolean', $v_stringdata); 
                                                    $sentenciach->execute();           
        
                                     //////////  12-15 init picking

                                    
                      $v_stringdata=   $snparam;
                      $v_categoryoutcome= 12;
                      $v_catidtype= 15;
                      $sentenciach = $connect->prepare("select fnt_insert_return_fas_outcome_integral(:idfasoutcomecat, :idtype, :reference, null, null, null, :v_string, null);");                  
                                  $sentenciach->bindParam(':idfasoutcomecat', $v_categoryoutcome);			
                                  $sentenciach->bindParam(':idtype', $v_catidtype);			
                                  $sentenciach->bindParam(':reference', $_idruninfo_reference);								
                                  $sentenciach->bindParam(':v_string', $v_stringdata); 
                                  $sentenciach->execute();
        
                                                //////////  0-12 ID SCRIPT
                                            //    echo "ID SCRIPT".$typererorkmm;
                                            
                                 //por defecto siempre esn ASSY
                                $v_stringdata = 48;
                                  if ( 'ASSY' ==  $typererorkmm)
			                            {
                                    $v_stringdata = 48;
                                  }

                                  if ('2ND-ASSY'==  $typererorkmm)
                                  {
                                    $v_stringdata = 50;
                                  } 
                                  if ( 'ENG-CAL'==  $typererorkmm)
                                  {                                    
                                    $v_stringdata = 51;
                                  }

                                  if ( 'A.BURN'==  $typererorkmm)
                                  {                                    
                                    $v_stringdata = 52;
                                  }
                                  if ( 'RWKASSY'==  $typererorkmm)
                                  {                                    
                                    $v_stringdata = 58;
                                  }     
                                  if ( 'RWKPRECHECK'==  $typererorkmm)                                 
                                  {                                    
                                      $v_stringdata = 48;
                                  }                                
                                   
		///	echo "--->".$typererorkmm."HOla".$v_stringdata;
                  ///    $v_stringdata=   48;
                      $v_categoryoutcome= 0;
                      $v_catidtype= 12;
                      $sentenciach = $connect->prepare("select fnt_insert_return_fas_outcome_integral(:idfasoutcomecat, :idtype, :reference, null, :v_integer, null,null, null);");                  
                                  $sentenciach->bindParam(':idfasoutcomecat', $v_categoryoutcome);			
                                  $sentenciach->bindParam(':idtype', $v_catidtype);			
                                  $sentenciach->bindParam(':reference', $_idruninfo_reference);								
                                  $sentenciach->bindParam(':v_integer', $v_stringdata); 
                                 $sentenciach->execute();
                                
                                }
          //////////  END GENERATION IDRUNINFO
     //  echo "fIN";
          foreach ($_POST as $clave=>$valor)
          {
          
          $loscontroleshtml = explode("_", $clave);
         // echo "<br>---".$loscontroleshtml[0];
            if ($loscontroleshtml[0]=="nuevonamecomp")
            {
        //      echo "Voy a controlar todo el ".$loscontroleshtml[1];
         //     echo "El valor de $clave es: $valor .<br><br>";

              $elso= $_REQUEST['elso'];
              $elsn= $_REQUEST['elsn'];
              $elciu= $_REQUEST['elciu'];


                $vuserfas = $_SESSION["b"];


                $nuevonamecomp_ciu =  substr( $_REQUEST['nuevonamecompciu_'.$loscontroleshtml[1]],0,48);
                $nuevonamecomp_sn =   $_REQUEST['nuevonamecomp_'.$loscontroleshtml[1]];
                $nuevobatch =    $_REQUEST['nuevorev_'.$loscontroleshtml[1]];
                
                $nuevobatchofi=  $_REQUEST['nuevobatch_'.$loscontroleshtml[1]];
                $nuevonamecomp_ciu_descrip = substr(  $_REQUEST['idprodcompdescrip'.$loscontroleshtml[1]],0,48);                                    
              
              //  $nuevobatch = 0;
     /*      echo "<br>HOLA:".$nuevonamecomp_ciu;     
           echo "<br>HOLA:".$nuevonamecomp_sn;   
            echo "<br>HOLA:".$nuevobatch;
            echo "<br>HOLA:".$nuevonamecomp_ciu_descrip;
            echo "<br><hr>";
          */    
                $msjok="Save OK.!";
                $vidprodcomp = 0; 
                $query_lista2  = "CALL public.sp_insert_orders_sn_components_xml('".$elso."','".$elsn."','".$elciu."',".$loscontroleshtml[1].",'".$nuevonamecomp_sn."','".$nuevonamecomp_ciu."','".$nuevobatch."','".$nuevonamecomp_ciu_descrip."',".$nrorev.",'".$vuserfas."',". $vidprodcomp.",'".$nuevobatchofi."')";
          // echo  "<br>".$query_lista2;
        
                       $connect->query($query_lista2);  
                       /*
                       IN v_so character varying,
	IN v_sn character varying,
	IN v_modelciu character varying,
	IN v_idprodcomp integer,
	IN v_components_sn character varying,
	IN v_components_ciu character varying,
	IN v_components_rev integer,
	IN v_components_name character varying,
	IN v_idprodcomprev integer,
	IN v_userpicking character varying,
	IN v_idprodcompcreado integer)
  */

            }
          }
         

               ///////ACA SUMAMOSS:.IF la PO TIENE UNA SO asociada.. y tiene lugar.. se la asociamos de pecho!
        //////////////////////////////////////////////////////////////////////////////////////////
        $proxnroserie=1;
        $el_idorders_delaso=0;
        $elsoremm=  preg_replace('/(WO|SO)/', '', $elso);

            $sqlprodu = $connect->prepare("select  distinct idproduct from products where modelciu ='".$elciu."' "); 
            $sqlprodu->execute();
                $resultaproduc = $sqlprodu->fetchAll();
                foreach ($resultaproduc as $rowpord) {
                    $elidproduct=$rowpord['idproduct'];
                 //   echo "<br>idprod:".$elidproduct."<br>";
                }
                
           //     echo "aaaaaaaaaaaa";

        $sql2 = $connect->prepare("select v_string 
        from fas_sap_filesxml_attribute
        where   idruninfo in 
            (
            select idruninfo 
            from fas_sap_filesxml_attribute
            where   idruninfo in 
                (
                select idruninfo 
                from fas_sap_filesxml_attribute
                where  v_string = '".$elsoremm."'
                ) and v_string='".$elciu."'
            ) and idattributeord=7  and v_string <>'' limit 1 ");

          
            $sql2->execute();
            $resultadoso = $sql2->fetchAll();
            foreach ($resultadoso as $rowso) 
            {
                         
                

                    $elidnroorderndelawo=0;
                    $sqlblapo = $connect->prepare("select idorders,  ponumber from orders_sn where so_soft_external ='".$elso."' and idproduct=". $elidproduct. " and wo_serialnumber='".$elsn."'  ");
                    $sqlblapo->execute();
                    $resultadolapo = $sqlblapo->fetchAll();
                    foreach ($resultadolapo as $rowsommpo) {
                        $lapodelawo=$rowsommpo['ponumber'];
                        $elidnroorderndelawo=$rowsommpo['idorders'];
                    }

                    $elsoabuscar=$rowso['v_string']."SO";
                   // echo "<br>ENTRE". $elsoabuscar;

                    $sqlbso = $connect->prepare("select idorders, max(idnroserie) as mxidnroseire from orders_sn where so_soft_external ='".$elsoabuscar."' and idproduct=". $elidproduct. " group by idorders ");
                    $sqlbso->execute();
                    $resultadosom = $sqlbso->fetchAll();
                    foreach ($resultadosom as $rowsomm) {
                        $elidproxnroserieproduct=$rowsomm['mxidnroseire']+1;
                        $el_idorders_delaso=$rowsomm['idorders'];
                 //       echo $elidproxnroserieproduct."<br>";
                 //       echo $el_idorders_delaso."<br>";
                    }

                    // controlamos si la SO esta lleno.
                    

                    $tienelugarlaSO ="Y";
                    $elsoabuscar=$rowso['v_string']."SO";
                    $sqlbsotiene = $connect->prepare("select orders.idorders ,  quantity, count(wo_serialnumber)  as qq
                    from orders 
                    left join orders_sn
                    on orders.idorders = orders_sn.idorders and orders_sn.idnroserie>0
                    where orders.idorders= ".$el_idorders_delaso."  group by orders.idorders ,quantity ");
                    $sqlbsotiene->execute();
                    $sqlbsotienevv = $sqlbsotiene->fetchAll();
                    foreach ($sqlbsotienevv as $rowsommtt)  
                    {
                        if ($rowsommtt['quantity']<= $rowsommtt['qq'])
                        {
                            $tienelugarlaSO ="N";
                       
                        }
                      
                    }
                    //echo "<br>tienelugarlaSO". $tienelugarlaSO;
                   // echo "<br>mm:select idorders  from orders_sn where idorders = ".$el_idorders_delaso." and wo_serialnumber='". $elsn. "'";
                    // controlamos que no existee ese SN para esa SO
                    $elSNYAEXISTEENLASO ="N";
                    $elsoabuscar=$rowso['v_string']."SO";
                    $sqlbsoexiste = $connect->prepare("select idorders  from orders_sn where idorders = ".$el_idorders_delaso." and wo_serialnumber='". $elsn. "' ");
                    $sqlbsoexiste->execute();
                    $resultadosomex = $sqlbsoexiste->fetchAll();
                    foreach ($resultadosomex as $rowsommes) 
                    {
                        $elSNYAEXISTEENLASO ="Y";
                    }

                 //   echo  "<br>elSNYAEXISTEENLASO".$elSNYAEXISTEENLASO."-tienelugarlaSO".$tienelugarlaSO;
                    
                    if ( $elSNYAEXISTEENLASO =="N" &&  $tienelugarlaSO =="Y")
                    {

                   
                            $sql = $connect->prepare("insert into orders_sn SELECT idorders, idcustomers, idfamilyprod, idtypeband, idtypeproduct, idproduct, idconfiguration, idrev, :vidsn, so_soft_external, :v_sn, idruninfo, :ponumber, pwrsupplytype, rcgfbwa, moden_dig, date_approved, descripcion, ul_gain, ul_max_pwr, dl_gain, dl_max_pwr, req_ppassy, req_calibration, req_spec, req_other, nameapproved, notes, reqresources, typeregister, processday, processfasserver, so_original, :v_nrowo FROM orders_sn  where idorders   = :v_idorders	and idnroserie=0 and idrev in (select max(idrev) FROM orders_sn where idorders   =:v_idorders2	 ) order by idnroserie desc limit 1;");
                            $sql->bindParam(':vidsn', $elidproxnroserieproduct);												
                            $sql->bindParam(':v_sn', $elsn);
                            $sql->bindParam(':ponumber', $lapodelawo);
                            $sql->bindParam(':v_nrowo', $elso);
                            $sql->bindParam(':v_idorders', $el_idorders_delaso);
                            $sql->bindParam(':v_idorders2', $el_idorders_delaso);
                            
                            $sql->execute();
                            echo "creo orders_sn";
                                            
                            $sql = $connect->prepare("insert into orders_sn_specs SELECT idorders, idrev, idch, :vidsn, typedata, ul_ch_fr, dl_ch_fr, dpxlowstart, dpxlowstop, dpxhihgstart, dpxhihgstop, unitdlstart, unitdlstop, unitulstart, unitulstop, notes, idband, ulgain, dlgain, ulmaxpwr, dlmaxpwr FROM orders_sn_specs where idorders   = :v_idorders and idnroserie = 0 and idrev in (select max(idrev) FROM orders_sn_specs where idorders   = :v_idorders2 );");
                            $sql->bindParam(':vidsn', $elidproxnroserieproduct);
                            $sql->bindParam(':v_idorders', $el_idorders_delaso);
                            $sql->bindParam(':v_idorders2', $el_idorders_delaso);

                            $sql->execute();
                        }
                    ////    echo "bbbbbbbbbb";
                    $vuserfas = $_SESSION["b"];
                    $vmenufas="NvaFntAutoAsingASSY";
                    $vaccionweb="WO:".$elso."-SN:".$elsn."-po:".$lapodelawo."-SO:".$elsoabuscar;
                    $sentenciaudit = $connect->prepare("INSERT INTO public.auditwebfas(dateaudit, userfas, menuweb, actionweb, descripaudit, textaudit)	VALUES (now(),  :userfas, :menuweb, :actionweb, :descripaudit, :textaudit);");
                    $sentenciaudit->bindParam(':userfas', $vuserfas);								
                    $sentenciaudit->bindParam(':menuweb', $vmenufas);
                    $sentenciaudit->bindParam(':actionweb', $vmenufas);

                    $sentenciaudit->bindParam(':descripaudit', $vaccionweb);
                    $sentenciaudit->bindParam(':textaudit', $vaccionweb);
                    $sentenciaudit->execute();	
                    //    echo "cccccccccccc";
                    //  echo "FIN;";

                
                    $sqlattt = $connect->prepare("delete from orders_sn_attributes 	where idorders   = :v_idorders  and  sn = :v_sn");
																		 
                    $sqlattt->bindParam(':v_idorders', $el_idorders_delaso);
                    $sqlattt->bindParam(':v_sn', $elsn);
                    $sqlattt->execute();

                         
                    $sqlattt2 = $connect->prepare("insert into orders_sn_attributes
                    SELECT ". $el_idorders_delaso.", idattribute_orders, datemodif,:v_sn, v_boolean, v_integer, v_double, v_string, v_date
                    FROM public.orders_attributes
                    where idorders   = :v_idorders");
                    $sqlattt2->bindParam(':v_idorders', $elidnroorderndelawo);
                    $sqlattt2->bindParam(':v_sn', $elsn);
                    $sqlattt2->execute();


                    $vuserfas = $_SESSION["b"];
                     
                    $vtextaudit="user:".$vuserfas." - ".$vaccionweb;
                    
                    $sentenciach = $connect->prepare("INSERT INTO public.audit_autoasignsotowo (datetimereceived, textxml)	VALUES (now(), textaudit );");
                            
                                    $sentenciach->bindParam(':textaudit', $vtextaudit);
                                    $sentenciach->execute();

             
            }


      
        

    //////////////////////////////////////////////////////////////////////////////////////////

         
    
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <link rel="stylesheet" href="cssfiplex.css">
    <style>
    .track {
        font-size: 12px;
        position: relative;
        background-color: #ddd;
        height: 7px;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        margin-bottom: 60px;
        margin-top: 50px
    }

    .track .step {
        -webkit-box-flex: 1;
        -ms-flex-positive: 1;
        flex-grow: 1;
        width: 25%;
        margin-top: -18px;
        text-align: center;
        position: relative
    }

    .track .step.active:before {
        background: #FF5722
    }

    .track .step::before {
        height: 7px;
        position: absolute;
        content: "";
        width: 100%;
        left: 0;
        top: 18px
    }

    .track .step.active .icon {
        background: #ee5435;
        color: #fff
    }

    .track .icon {
        display: inline-block;
        width: 40px;
        height: 40px;
        line-height: 40px;
        position: relative;
        border-radius: 100%;
        background: #ddd
    }

    .track .step.active .text {
        font-weight: 400;
        color: #000
    }

    /** ** stepverde */
    .track .stepverde {
        -webkit-box-flex: 1;
        -ms-flex-positive: 1;
        flex-grow: 1;
        width: 25%;
        margin-top: -18px;
        text-align: center;
        position: relative
    }

    .track .stepverde.active:before {
        background: #28a745;
    }

    .track .stepverde::before {
        height: 7px;
        position: absolute;
        content: "";
        width: 100%;
        left: 0;
        top: 18px
    }

    .track .stepverde.active .icon {
        background: #28a745;
        color: #fff
    }

    .track .icon {
        display: inline-block;
        width: 40px;
        height: 40px;
        line-height: 40px;
        position: relative;
        border-radius: 100%;
        background: #ddd
    }

    .track .stepverde.active .text {
        font-weight: 400;
        color: #000
    }

    /** ** fin stepverde */

    /*///step azul//*/
    .track .stepazul {
        -webkit-box-flex: 1;
        -ms-flex-positive: 1;
        flex-grow: 1;
        width: 25%;
        margin-top: -18px;
        text-align: center;
        position: relative
    }

    .track .stepazul.active:before {
        background: #0053a1;
    }

    .track .stepazul::before {
        height: 7px;
        position: absolute;
        content: "";
        width: 100%;
        left: 0;
        top: 18px
    }

    .track .stepazul.active .icon {
        background: #0053a1;
        ;
        color: #fff
    }

    .track .icon {
        display: inline-block;
        width: 40px;
        height: 40px;
        line-height: 40px;
        position: relative;
        border-radius: 100%;
        background: #ddd
    }

    .track .stepazul.active .text {
        font-weight: 400;
        color: #000
    }

    /*///fin step azul//*/

    .track .text {
        display: block;
        margin-top: 7px
    }

    .itemside {
        position: relative;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        width: 100%
    }

    .itemside .aside {
        position: relative;
        -ms-flex-negative: 0;
        flex-shrink: 0
    }

    .img-sm {
        width: 80px;
        height: 80px;
        padding: 7px
    }

    ul.row,
    ul.row-sm {
        list-style: none;
        padding: 0
    }

    .itemside .info {
        padding-left: 15px;
        padding-right: 7px
    }

    .itemside .title {
        display: block;
        margin-bottom: 5px;
        color: #212529
    }


    .vertical-timeline {
        width: 100%;
        position: relative;
        padding: 1.5rem 0 1rem
    }

    .vertical-timeline::before {
        content: '';
        position: absolute;
        top: 0;
        left: 67px;
        height: 100%;
        width: 4px;
        background: #e9ecef;
        border-radius: .25rem
    }

    .vertical-timeline-element {
        position: relative;
        margin: 0 0 1rem
    }

    .vertical-timeline--animate .vertical-timeline-element-icon.bounce-in {
        visibility: visible;
        animation: cd-bounce-1 .8s
    }

    .vertical-timeline-element-icon {
        position: absolute;
        top: 0;
        left: 60px
    }

    .vertical-timeline-element-icon .badge-dot-xl {
        box-shadow: 0 0 0 5px #fff
    }

    .badge-dot-xl {
        width: 18px;
        height: 18px;
        position: relative
    }

    .badge:empty {
        display: none
    }

    .badge-dot-xl::before {
        content: '';
        width: 10px;
        height: 10px;
        border-radius: .25rem;
        position: absolute;
        left: 50%;
        top: 50%;
        margin: -5px 0 0 -5px;
        background: #fff
    }

    .vertical-timeline-element-content {
        position: relative;
        margin-left: 90px;
        font-size: .8rem
    }

    .vertical-timeline-element-content .timeline-title {
        font-size: .8rem;
        text-transform: uppercase;
        margin: 0 0 .5rem;
        padding: 2px 0 0;
        font-weight: bold
    }

    .vertical-timeline-element-content .vertical-timeline-element-date {
        display: block;
        position: absolute;
        left: -90px;
        top: 0;
        padding-right: 10px;
        text-align: right;
        color: #adb5bd;
        font-size: .7619rem;
        white-space: nowrap
    }

    .vertical-timeline-element-content:after {
        content: "";
        display: table;
        clear: both
    }

    h2 {
        display: block;
        font-size: 1.5em;
        margin-block-start: 0.83em;
        margin-block-end: 0.83em;
        margin-inline-start: 0px;
        margin-inline-end: 0px;
        font-weight: bold;
    }

    h3 {
        display: block;
        font-size: 1.17em;
        margin-block-start: 1em;
        margin-block-end: 1em;
        margin-inline-start: 0px;
        margin-inline-end: 0px;
        font-weight: bold;
    }

    .modal-xl {
        max-width: 1500px;
    }


    .losdiv_steps {
        border: 1px solid #b8daff;
    }
    </style>
</head>
<form name="frmae" id="frmae" method="post">
    <input type="hidden" name="uso" id="uso" value="0">

    <body class="hold-transition sidebar-mini sidebar-collapse">
        <!-- Site wrapper -->



        <!-- Content Wrapper. Contains page content -->
        <div>

</form>
<?php


 
                  $snparam = $_REQUEST['elsn']; ///
                  $elso = $_REQUEST['elso'];
                  $vv_so = $_REQUEST['elso'];
                  $elsn = $_REQUEST['elsn'];
                  $elciu = $_REQUEST['elciu'];
                  $vv_modelciu = $_REQUEST['elciu'];
                  $pasos_habilitados="";
                  $v_paso1=0;
                  
                  ?>
<form name="frma" id="frma"
    action="wopickingsteps.php?elsn=<?php echo $elsn; ?>&elso=<?php echo $elso; ?>&elciu=<?php echo $elciu; ?>"
    method="post" class="form-horizontal">

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


                                <input type="hidden" name="elso" id="elso" value="<?php echo $elso; ?>">
                                <input type="hidden" name="elsn" id="elsn" value="<?php echo $elsn; ?>">
                                <input type="hidden" name="elciu" id="elciu" value="<?php echo $elciu; ?>">
                                <input type="hidden" name="statussn" id="statussn" value="">


                                <?php
		  
		  if ($msjok == "acamodifparaqnosalga")
		  {
			  ?>
                                <div id="aa1" name="aa1" class="alert alert-success alert-dismissible">

                                    <h5><i class="icon fas fa-check"></i> Save Ok!</h5>

                                </div>

                                <?php
        
		  }
		  ?>

                                <p align="right">
                                    <a href="" target="_blank">
                                        <i class="fas fa-external-link-alt"></i> Open New Tab
                                    </a>
                                </p>
                                <?php
     
        ///// Canti revision
$cant_Rev =0;
$query_lista="SELECT  max(idprodcomprev )  as cc
  FROM public.orders_sn_components_xml
inner join orders_sn
on orders_sn.idorders = orders_sn_components_xml.idorders and 
orders_sn.idproduct = orders_sn_components_xml.idproduct and
orders_sn.so_soft_external = '".$elso."'  where orders_sn_components_xml.wo_serialnumber= '".$elsn."'";

//echo $query_lista;
//echo "----<br>".$query_lista;

$datacc = $connect->query($query_lista)->fetchAll();	
$vidsurveyresponse = 0;
$colorstyle="";
foreach ($datacc as $row) 
{
  $cant_Rev = $row['cc']+1; 

  
}

$classproduct ="";
$cant_Rev =0;
$query_lista="SELECT * from products where   modelciu   ='".$v_ciu."'  ";

//echo $query_lista;
///echo "----<br>".$query_lista;

$datdataccmacc = $connect->query($query_lista)->fetchAll();	
$vidsurveyresponse = 0;
$colorstyle="";
foreach ($datdataccmacc as $rowm) 
{
  $classproduct = $rowm['classproduct']; 

  
}



     ?>

                                <div class="container-fluid  ">

                                    <input type="hidden" id="nrorev" name="nrorev" value="<?php echo $cant_Rev;?>">
                                    <input type="hidden" id="numerador" name="numerador" value="100">



                                    <div class="card-body">

                                        <div>

                                        </div>

                                        <div class="track1">
                                            <div class="track">

                                                <div class="stepazul   active">
                                                    <a href="#" onclick="opendivsteps('divstep1')">
                                                        <span class="icon">1</span>
                                                        <span class="text text-center">
                                                            <b> PICKING<br>
                                                                WO: [<?php echo $v_sn; ?>]<br>CIU:
                                                                [<?php echo $v_ciu;?>]</b>
                                                        </span>
                                                    </a>
                                                </div>
                                                <?php
                               
                                              $sqlattri=" select * from fas_products_documentation
                                              inner join fas_products_docu_type
                                              on fas_products_documentation.idtypedocu  = fas_products_docu_type.idtypedocu 
                                              where fas_products_documentation.showpicking = 'Y' and   idproduct in (select idproduct  from products where modelciu = '".$v_ciu."') order by orderlist   ";

                                        //    echo "<br>Pasos:". $sqlattri;
                                        // Frenado temporal.
                                       $sqlattri=" select 'ASSY' AS namefasdocu ";

                                              $datagrafpunt = $connect->query($sqlattri)->fetchAll();	
                                              $iddiv =2;	
                                              foreach ($datagrafpunt as $rowatt)     
                                                {
                                                  //$rowiduniqpuntos["0db"]
                                                  ?>
                                                <div class="stepazul " id="globN<?php echo $iddiv; ?>"
                                                    name="globN<?php echo $iddiv; ?>">
                                                    <span class="icon"><?php echo $iddiv;  ;?></span>
                                                    <span class="text text-center">
                                                        <b><?php echo  $rowatt['namefasdocu'];  ?> </b>
                                                    </span>

                                                </div>

                                                <div class="stepazul active d-none  " id="globY<?php echo $iddiv; ?>"
                                                    name="globY<?php echo $iddiv; ?>">
                                                    <a href="#" onclick="opendivsteps('divstep<?php echo $iddiv; ?>')">
                                                        <span
                                                            class="icon"><?php echo $iddiv; $iddiv = $iddiv + 1 ;?></span>
                                                        <span class="text text-center">
                                                            <b><?php echo  $rowatt['namefasdocu'];  ?> </b>
                                                        </span>
                                                    </a>
                                                </div>
                                                <?php                                                 
                                                }
                                              ?>











                                            </div>


                                        </div>

                                        <div class="card card-widget losdiv_steps" id="divstep1" name="divstep1">

                                            <div class="row">

                                                <div class="col-12">

                                                    <?php
                      ////////////////Agregamos aca lo q tenemos ya guardado..
                      $query_lista="select distinct orders_sn_components_xml.*
                      from fnt_select_orders_sn_components_xml_maxrev() as 
                      orders_sn_components_xml
                      inner join orders_sn on orders_sn.idorders = orders_sn_components_xml.idorders and 
                      orders_sn.idproduct = orders_sn_components_xml.idproduct and orders_sn.so_soft_external =  '".$elso."' 
                     
                      where orders_sn_components_xml.wo_serialnumber= '".$elsn."' order by   idprodcomprev desc";

                  //      echo $query_lista;
                    
                          $data = $connect->query($query_lista)->fetchAll();	
                          $vidsurveyresponse = 0;
                          $colorstyle="";

                          $cant_registros_xsn = count($data );
                      if($cant_registros_xsn>0)
                      {
                        $pasos_habilitados ="1";
                      ?>


                                                    <div id="divmaxrev" name="divmaxrev" class="container-fluid">

                                                        <br>
                                                        <table class="table table-striped   ">
                                                            <thead class="thead-dark">
                                                                <tr>



                                                                    <td class="table-primary" scope="col"><b>CIU</b>
                                                                    </td>
                                                                    <td class="table-primary" scope="col"><b>SN</b></td>

                                                                    <td class="table-primary" scope="col"><b>Rev Assy</b>
                                                                    </td>

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


                                                                    <td><?php echo  $row['components_ciu']; ?> </td>
                                                                    <?php
                                                                    $sumorevybatch="";
                                                                    if ($row['components_rev'] <> "")
                                                                    {
                                                                        $sumorevybatch= $sumorevybatch. " - [Rev:".$row['components_rev']."]";
                                                                    }
                                                                    if ($row['components_batch'] <> "")
                                                                    {
                                                                        $sumorevybatch= $sumorevybatch. " - [Batch: ".$row['components_batch']."]";
                                                                    }
                                                                    ?>
                                                                    <td><?php echo  $row['components_sn'].$sumorevybatch; ?> </td>

                                                                    <td><?php echo  $row['idprodcomprev']; ?> </td>

                                                                    <td><?php echo  substr($row['datetimepicking'],0,19); ?>
                                                                    </td>
                                                                    <td><?php echo  $row['userpicking']; ?> </td>

                                                                </tr>
                                                                <?php
                                  }
                              ?>
                                                            </tbody>
                                                        </table>

                                                        <p align="right">
                                                            <button class="btn btn-secondary btn-block btn-flat btn-sm"
                                                                type="button" onclick="habilitarrev()"> Create New Rev
                                                            </button>
                                                        </p>

                                                    </div>
                                                    <?PHP } ?>

                                                </div>


                                                <div class="col">
                                                    <!--     ZXZCZCXZ   -->


                                                    <br>

                                                    <!--
                  ---------------------------------------
                        -->
                                                    <?php

function Create_vinculation_sn_componetns($vp_runinfo,$v_sn,$partnumber, $partnumberdescri)
{
  ////////////// init function
  ////// products_attributes_type:: 142 -Product in Picking requires TotalPassChk ::
  include("db_conect.php"); 
 
    $required_chk_comp=0;
    $sqlchkattribut="select * from products_attributes where idproduct in (select idproduct from products where modelciu = '".$partnumber."') and idattribute = 142 ";
    $datachk = $connect->query($sqlchkattribut)->fetchAll();	
    foreach ($datachk as $row) 
    {
       $required_chk_comp=1;
    }

    $v_temp_sn = '';
    $v_temp_rev='00';
    $v_temp_batch='00';

    $sqlcompsndet="select * from orders_sn_components_xml where components_ciu = '".$partnumber."'  and wo_serialnumber= '".$v_sn."' order by idprodcomprev ";
    $tienecompocargado=0;
    $datacompsndet = $connect->query($sqlcompsndet)->fetchAll();	
    foreach ($datacompsndet as $rowsndet) 
    {
         $v_temp_sn = $rowsndet['components_sn'];
         $v_temp_rev = $rowsndet['components_rev'];
         $v_temp_batch = $rowsndet['components_batch'];
         $tienecompocargado=1;

    }

    if ($v_temp_rev=="")
    {
      $v_temp_rev='00';
    }
    if ($v_temp_batch=="")
    {
      $v_temp_batch='00';
    }

  ?>

                                                    <div class="form-group row col-12 ">
                                                        <a class="btn btn-primary btn-sm col-sm-4"
                                                            data-toggle="collapse"
                                                            href="#multiCollapseExample<?php echo  $vp_runinfo;   ?>"
                                                            role="button" aria-expanded="false"
                                                            aria-controls="multiCollapseExample<?php echo  $vp_runinfo;   ?>">
                                                            <?php echo $partnumber." - [".$partnumberdescri."]"; ?>
                                                        </a>&nbsp;&nbsp;
                                                        <a href="#"
                                                            onclick="abrirqrcomponet('readqr<?php echo  $vp_runinfo;   ?>');return false">
                                                            <i class='fas fa-qrcode'
                                                                style='font-size:30px;color:blue;  vertical-align: middle;'></i></a>
                                                        &nbsp;&nbsp; <input type="text"
                                                            class="form-control form-control-sm form-control-sm col-md-4 "
                                                            onkeypress="return search_data_enter_qr(event,'readqr<?php echo  $vp_runinfo;   ?>',<?php echo  $vp_runinfo.",". $required_chk_comp.",'".$partnumber."'";   ?>)"
                                                            id="readqr<?php echo  $vp_runinfo;   ?>"
                                                            name="readqr<?php echo  $vp_runinfo;   ?>"
                                                            placeholder="Read Qr">
                                                        <?php
                                                            if ( $tienecompocargado==1)
                                                            {
                                                                echo "&nbsp;&nbsp;<span style='color:#FF8000'>SN loaded in Draft mode.</span>";        
                                                            }
                                                            ?>
                                                        &nbsp;&nbsp; <i class="fa fa-check d-none"
                                                            style='  vertical-align: middle;font-size:20px;color:green'
                                                            aria-hidden="true"
                                                            id="readqr<?php echo  $vp_runinfo;   ?>ok"
                                                            name="readqr<?php echo  $vp_runinfo;   ?>ok"></i>
                                                        &nbsp;&nbsp; <i class="fa fa-times d-none"
                                                            style='  vertical-align: middle;font-size:20px;color:red'
                                                            aria-hidden="true"
                                                            id="readqr<?php echo  $vp_runinfo;   ?>okno"
                                                            name="readqr<?php echo  $vp_runinfo;   ?>okno"></i>
                                                        &nbsp;&nbsp; <i class="fa fa-hourglass-start d-none"
                                                            style='  vertical-align: middle;font-size:20px;color:#ff6600'
                                                            aria-hidden="true"
                                                            id="readqr<?php echo  $vp_runinfo;   ?>wait"
                                                            name="readqr<?php echo  $vp_runinfo;   ?>wait"></i>

                                                    </div>

                                                    <div class="col">
                                                        <div class="collapse multi-collapse"
                                                            id="multiCollapseExample<?php echo  $vp_runinfo;   ?>">
                                                            <div class="card card-body">

                                                                <div class=" col">

                                                                    <div class=" row">

                                                                        <label for="inputEmail3"
                                                                            class="col-sm-2 col-form-label">CIU:</label>
                                                                        <div class="col-sm-10">
                                                                            <input type="text"
                                                                                class="form-control bloqueomm"
                                                                                value="<?php echo  $partnumber; ?>"
                                                                                id="nuevonamecompciu_<?php echo  $vp_runinfo;   ?>"
                                                                                name="nuevonamecompciu_<?php echo $vp_runinfo; ?>">

                                                                            <input type="hidden"
                                                                                name="idprodcompdescrip<?php echo  $vp_runinfo;   ?>"
                                                                                id="idprodcompdescrip<?php echo  $vp_runinfo;   ?>"
                                                                                value="<?php echo  $partnumberdescri; ?> ">

                                                                        </div>
                                                                    </div>

                                                                    <div class=" row">
                                                                        <label for="inputEmail3"
                                                                            class="col-sm-2 col-form-label">SN:
                                                                            <?php echo $v_temp_sn;?></label>
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
                                                                            <input type="hidden"
                                                                                name="idprodcomp<?php echo  $vp_runinfo;   ?>"
                                                                                id="idprodcomp<?php echo  $vp_runinfo;   ?>"
                                                                                value="<?php echo $v_temp_sn; ?> ">



                                                                            <?php
                                        if ($vp_runinfo == 1) 
                                        {
                                          ?>
                                                                            <input type="text"
                                                                                onblur="validar_sn_uso(this.value,'nuevonamecomp_<?php echo  $vp_runinfo;   ?>')"
                                                                                class="form-control bloqueomm"
                                                                                value="<?php echo  $v_temp_sn; ?>"
                                                                                id="nuevonamecomp_<?php echo  $vp_runinfo;   ?>"
                                                                                name="nuevonamecomp_<?php echo $vp_runinfo; ?>">
                                                                            <?php
                                        }
                                        else
                                        {
                                          ?>
                                                                            <input type="text"
                                                                                class="form-control bloqueomm "
                                                                                value="<?php echo $v_temp_sn; ?>"
                                                                                onblur="validar_sn_uso(this.value,'nuevonamecomp_<?php echo  $vp_runinfo;   ?>')"
                                                                                id="nuevonamecomp_<?php echo  $vp_runinfo;   ?>"
                                                                                name="nuevonamecomp_<?php echo $vp_runinfo; ?>">
                                                                            <?php
                                        }
                                        ?>


                                                                            <input type="hidden"
                                                                                name="cmbtypecomp<?php echo  $vp_runinfo;   ?>"
                                                                                id="cmbtypecomp<?php echo  $vp_runinfo;   ?>"
                                                                                value="<?php echo  $vp_runinfo; ?> ">
                                                                        </div>
                                                                    </div>



                                                                    <div class=" row">
                                                                        <label for="inputEmail3"
                                                                            class="col-sm-2 col-form-label ">Batch:</label>
                                                                        <div class="col-sm-10">
                                                                            <!-- acamarco-->
                                                                            <input type="text"
                                                                                class="form-control bloqueomm"
                                                                                value="<?php echo $v_temp_batch; ?>"
                                                                                id="nuevobatch_<?php echo $vp_runinfo;?>"
                                                                                name="nuevobatch_<?php echo $vp_runinfo;?>">
                                                                        </div>
                                                                    </div>

                                                                    <div class=" row">
                                                                        <label for="inputEmail3"
                                                                            class="col-sm-2 col-form-label">Rev:</label>
                                                                        <div class="col-sm-10">
                                                                            <!-- acamarco-->
                                                                            <input type="text"
                                                                                class="form-control bloqueomm"
                                                                                value="<?php echo $v_temp_rev; ?>"
                                                                                id="nuevorev_<?php echo $vp_runinfo;?>"
                                                                                name="nuevorev_<?php echo $vp_runinfo;?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <?php
///////////// end funcion 
}

                        $divclassadd="";
          if ($cant_registros_xsn >0)
          {
            $divclassadd="d-none";
          }
                   //   echo "<br>aaaaaaaaaaaaaaaaaaaa".$cant_registros_xsn;
            ?>
                                                    <div class="container-fluid   <?php echo  $divclassadd; ?>"
                                                        id="divaddpicking" name="divaddpicking">
                                                        <?php      
            
//////////////////////// Carga Componentes x XML
 
if ( $elsn =="missingsn")
{

  $query_xml ="

    select '' ismother, v_integer , json_agg( JSON_BUILD_OBJECT('idattribute_orders',idattribute_orders,'attributedescription', attributedescription,'v_double',v_double,'v_string',v_string)) as jsonmm

    FROM public.orders_attributes
    INNER JOIN orders_attributes_type
    ON orders_attributes_type.idattribute = orders_attributes.idattribute_orders
    where idorders in(select idorders from orders_sn where orders_sn.idorders = '".$idorders_sinsnasign."'   ) and  active like 'XML2_WO_CP%'
    group by v_integer
    ";

}
else
{

      if ($cant_registros_xsn>0)
    {
      $query_xml ="

    select v_integer , json_agg( JSON_BUILD_OBJECT('idattribute_orders',idattribute_orders,'attributedescription', attributedescription,'v_double',v_double,'v_string',v_string)) as jsonmm

    FROM orders_sn_attributes as orders_attributes
    INNER JOIN orders_attributes_type
    ON orders_attributes_type.idattribute = orders_attributes.idattribute_orders
    where idorders in(select idorders from orders_sn where wo_serialnumber= '".$elsn."' and orders_sn.so_soft_external =  '".$elso."' ) and  active like 'XML2_WO_CP%' 
    and sn = '".$elsn."'
    group by v_integer
    ";
    }
    else
    {
      $query_xml ="

      select v_integer , json_agg( JSON_BUILD_OBJECT('idattribute_orders',idattribute_orders,'attributedescription', attributedescription,'v_double',v_double,'v_string',v_string)) as jsonmm
      
      FROM orders_sn_attributes as orders_attributes
      INNER JOIN orders_attributes_type
      ON orders_attributes_type.idattribute = orders_attributes.idattribute_orders
      where idorders in(select idorders from orders_sn where wo_serialnumber= '".$elsn."' and orders_sn.so_soft_external =  '".$elso."' ) and  active like 'XML2_WO_CP%' 
      and sn = '".$elsn."'
      group by v_integer
      ";
    }
}


 //echo $query_xml;
 
$qq_components_xml = 0;
$partnumber_components_xml = '';
$partnumberdescrip_components_xml = '';
$nroitempositio = 100;
$data_xml = $connect->query($query_xml)->fetchAll();	
$thesn_havecomponets ='N';
/*foreach ($data_xml as $rowxml) 
{
  $thesn_havecomponets ='Y';
  //echo  substr($rowxml['jsonmm'],1,-1);
  //$arrmm = json_decode( substr($rowxml['jsonmm'],1,-1) , true);
  $arrmm = json_decode( $rowxml['jsonmm'] , true);  

  //saco el numero de elementos
    $longitud = count($arrmm);
 //echo "-longitud".$longitud;
  //Recorro todos los elementos
    $vvsn="";
      for($imm=0; $imm<=$longitud; $imm++)
      {
 
        $arrmmobj = $arrmm[$imm];    
        if ( $arrmmobj['idattribute_orders'] == 25)
        {
       //   echo "<br>la Cantidad es: ".$arrmmobj['v_double'];
          $partnumber_components_xml =$arrmmobj['v_string'];
        }

        if ( $arrmmobj['idattribute_orders'] == 26)
        {
          //echo "<br>la Cantidad es: ".$arrmmobj['v_double'];
          $partnumberdescrip_components_xml =$arrmmobj['v_string'];
        }

        if ( $arrmmobj['idattribute_orders'] == 27)
        {
          //echo "<br>la Cantidad es: ".$arrmmobj['v_double'];
          $qq_components_xml =$arrmmobj['v_double'];
        }

      
       
	    //  echo "<br>fin puede ejecutar";
      }
      ?>
                                                        <div class="container-fluid">
                                                            <div class="col">
                                                                <?php
     

      for($immt=0; $immt< $qq_components_xml; $immt++)
      {
      //  echo "Create_vinculation_sn_componetns <br>";
        Create_vinculation_sn_componetns($nroitempositio.$immt,$vvsn,$partnumber_components_xml,$partnumberdescrip_components_xml  );
        $nroitempositio = $nroitempositio+1;
      }
      ?>
                                                            </div>
                                                        </div>
                                                        <?php
 

}*/
 
if (  $thesn_havecomponets =='N' )
{
    if ( ($_REQUEST['typeworkc']=="so_ASSY" && $v_ciu =="HONBDA-A-7S27B") or ($_REQUEST['typeworkc']=="so_ASSY" && $v_ciu =="HONBDA-D-7S27B")  )
    {

        //// version vieja
          $query_xm2024l ="select * from  products_components_critical where material = '".$v_ciu."' and assembly  = 'X' and component like '%DH7S%'";
          //// version nueva
          $query_xm2024l ="select distinct products_comp_critical.*, products.modelciu as component, description 
          from products_comp_critical
          inner join fnt_select_allproducts_maxrev2() as products 
          on products.idproduct = products_comp_critical.idproductcomp
          where products_comp_critical.idproduct in (select distinct idproduct from fnt_select_allproducts_maxrev2() where  modelciu = '".$v_ciu."' ) and assembly  = 'X' and products.modelciu like '%DH7S%'";
    }
    else
    {
       //// version vieja
       //// $query_xm2024l ="select * from  products_components_critical where material = '".$v_ciu."' and assembly  = 'X'";
       //// version nueva
       if ( ($_REQUEST['typeworkc']=="wo_ASSY" && $v_ciu =="HONBDA-A-7S27B") or ($_REQUEST['typeworkc']=="wo_ASSY" && $v_ciu =="HONBDA-D-7S27B")  )
        {
            $query_xm2024l ="select distinct products_comp_critical.*, products.modelciu as component, description 
            from products_comp_critical
            inner join fnt_select_allproducts_maxrevithsap() as products 
            on products.idproduct = products_comp_critical.idproductcomp
            where products_comp_critical.idproduct in (select distinct idproduct from fnt_select_allproducts_maxrevithsap() where  modelciu = '".$v_ciu."' ) and assembly  = 'X'  and products.modelciu not like '%DH7S%' ";
        }
        else
        {

            
         $query_xm2024l ="select distinct products_comp_critical.*, products.modelciu as component, description 
         from products_comp_critical
         inner join fnt_select_allproducts_maxrevithsap() as products 
         on products.idproduct = products_comp_critical.idproductcomp
         where products_comp_critical.idproduct in (select distinct idproduct from fnt_select_allproducts_maxrevithsap() where  modelciu = '".$v_ciu."' ) and assembly  = 'X'  ";
     
        }   

    }
     
     
      $data2024 = $connect->query($query_xm2024l)->fetchAll();	
    
      foreach ($data2024 as $rowxml2024) 
      {
        
        $thesn_havecomponets ='Y';
        $immt++;
        $cantidad = $rowxml2024['qty'];
        for ($imqty = 0; $imqty < $cantidad; $imqty=$imqty+1000) {
         ///   echo "<br>la cantidad es;". $imqty."----" .$cantidad;
            $immt++;
            Create_vinculation_sn_componetns($nroitempositio.$immt,$elsn,$rowxml2024['component'],$rowxml2024['description']."..."  );
        $nroitempositio = $nroitempositio+1;
          } 
        
       
        
      }
}


if ($thesn_havecomponets =='N')
{
  echo "<p style='color:red'>&nbsp; Attention!, serial number has no component attributes </p>";
}

 ?>
                                                        <input type="hidden" name="lostiposdecomparry"
                                                            id="lostiposdecomparry"
                                                            value="<?php echo   $lostipodecomp;?>">
                                                        <input type="hidden" name="lostiposdecomparrypos"
                                                            id="lostiposdecomparrypos" value="0">
                                                    </div>
                                                </div>



                                                <!-- inicio tab -->


                                                <!-- fintest tab -->



                                            </div>

                                            <?php
            
          ///    echo "<br>ULTIMOa ver".$cant_registros_xsn;
       
              ?> 


                                            <div class='container-fluid'>



                                            <?php

$have_save_sap="N";
 $sqlmaxhistorym = " select * from fas_to_sap_xml where v_sn ='".$elsn."' and v_workcenetr = '".substr( $_REQUEST['typeworkc'],3,22)."' and
 runinfodate in (
select max(runinfodate) from fas_to_sap_xml where v_sn ='".$elsn."' and v_workcenetr = '". substr( $_REQUEST['typeworkc'],3,22)."')                                          
";
 
   $datahistmm = $connect->query($sqlmaxhistorym)->fetchAll();	
   foreach ($datahistmm as $row2hh) 
   {
    $have_save_sap="Y";
   }
 if (   $have_save_sap=="N")
 {
?>
<button type="button" class="btn btn-block bg-gradient-info btn-sm"
    id="picking1" name="picking1" onclick="validar_envio('draft')">Save as
    draft and NOT CONFIRM IN SAP</button>

<button type="button" class="btn btn-block bg-gradient-primary btn-sm"
    id="picking" name="picking" onclick="validar_envio('Confirm')">Save
    &
    Confirm in SAP</button>
    <?php 
 }
 else
 {
    ?>
    <button type="button" class="btn btn-block bg-gradient-info btn-sm"
        id="picking1" name="picking1" onclick="validar_envio('draft')">Save as
       new Revision</button>

    
        <?php 
 }

    ?>
                                             
                                            </div>

                                            <br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
          /// Frenado Temporal..
          $rowatt="";
      $sqlattri="select * from fas_products_documentation where fas_products_documentation.showpicking = 'sM' ";
      $sqlattri="SELECT '".$v_ciu."' AS linkdocu, 1 as idtypedocu  ";
   //  echo "<br><br>Query link".$sqlattri;

 

       $namelinkpdf="";
          $datagrafpunt23 = $connect->query($sqlattri)->fetchAll();	
          $iddiv =2;	
        
          foreach ($datagrafpunt23 as $rowatt)     
            {

              $namelinkpdf="Source/".$rowatt['linkdocu'].".pdf";
              
              $countmonth_pdf ="";
        //     echo "<br>aca estoy:".$namelinkpdf;
              if (file_exists($namelinkpdf))
               {

                $fechamodif_file = date ("Y-m-d", filemtime($namelinkpdf));
                $todayism =  date ("F d Y H:i:s.");

          //      echo "$filename was last modified: " . date ("F d Y H:i:s.", filemtime($namelinkpdf));
           //     echo "<br> 4444 today : " . date ("F d Y H:i:s.");


                $fechaActual = date('Y-m-d'); 
            //    echo "<br>1<br>";
                $datetime1 = date_create($fechaActual);
            //    echo "<br>1<br>";
                $datetime2 = date_create($fechamodif_file);
           //     echo "<br>2<br>";
                $contador = date_diff($datetime1, $datetime2);
            
                $differenceFormat = '%m';
                $countmonth_pdf = $contador->format($differenceFormat);
                
             //  echo "<br>step_3::::".$countmonth_pdf."<br>";
                 

              }
          
            

                $url2 = "https://webfas.honeywell.com/".$namelinkpdf;
           //      echo "<br>".$url2 ;
                  // Use get_headers() function
                  $headers2 = @get_headers($url2);
            //      echo "<br>headers2:". $headers2[0];

                
                  // Use condition to check the existence of URL
                  if($headers2 && strpos( $headers2[0], '200')) {
                  $status = "URL Exist";
                  }
                  else {
                  $status = "URL Doesn't Exist";
                  ?>
                            <div class="container-fluid">
                                <div class="alert alert-warning alert-dismissible">

                                    <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                                    The PP-ASSY (<?php echo $rowatt['linkdocu'].".pdf"; ?>) does not exist in the
                                    repository.</b>
                                </div>
                            </div>
                            <?php 
                  }
                
              ?>

                            <div class="card card-widget losdiv_steps" id="divstep<?php echo $iddiv; ?>"
                                name="divstep<?php echo $iddiv; ?>">

                                <?php
                       if ($countmonth_pdf >= 0 )
                       {
                        ?>
                                <div class='container-fluid'>
                                    <br>
                                    <button type="button" class="btn btn-block bg-gradient-primary btn-sm d-none"
                                        id="picking" name="picking"
                                        onClick="save_steps_outcome_integral_idattrbute(0, 12,11, 'N','<?php echo $rowatt['linkdocu']  ?>',<?php echo $rowatt['idtypedocu']  ?>, '<?php echo $rowatt['linkdocu']  ?>',<?php echo $iddiv; ?>)">
                                        Finish </button>
                                </div>
                                <br>

                                <?php
                       if ($countmonth_pdf >5 )
                       {
                        ?>
                                <div class="container-fluid">
                                    <div class="alert alert-warning alert-dismissible">

                                        <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                                        The PP-ASSY (<?php echo $rowatt['linkdocu'].".pdf"; ?>) has not been modified
                                        for more than <b> 6 months.</b>
                                    </div>
                                </div>
                                <?php 
                      } 
                      ?>

                                <div class="btn-group btn-group-justified">
                                    <a href="#" class="btn btn-outline-success btn-sm"
                                        onclick="verifram('<?php echo $rowatt['linkdocu']; ?>')"> View PP-ASSY
                                        <?php echo $rowatt['linkdocu']; ?> <i class="	fas fa-file-pdf-o"
                                            aria-hidden="true"></i></a>
                                    <a href="#" class="btn btn-outline-info btn-sm"
                                        onclick="verifram('<?php echo $classproduct; ?>')"> View PP-ASSY
                                        <?php echo "A-".$classproduct; ?> <i class="	fas fa-file-pdf-o"
                                            aria-hidden="true"></i></a>

                                </div>
                                <br>
                                <div class="embed-responsive embed-responsive-21by9">
                                    <?php             
                              if($headers2 && strpos( $headers2[0], '200')) {
                                ?>



                                    <iframe class="embed-responsive-item" name="iframm" id="iframm"
                                        src="<?php echo   $namelinkpdf;?>"></iframe>
                                    <?php
                              } 
                              else
                              {
                                ?>
                                    <div class="container-fluid">
                                        <div class="alert alert-danger alert-dismissible">

                                            <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                                            The PP-ASSY (<?php echo $rowatt['linkdocu'].".pdf"; ?>) does not exist in
                                            the repository.</b>
                                        </div>
                                    </div>
                                    <br>
                                    <button type="button" class="btn btn-block bg-gradient-primary btn-sm" id="picking"
                                        name="picking"
                                        onClick="save_steps_outcome_integral_idattrbute(0, 12,11, 'N','<?php echo $rowatt['linkdocu']  ?>',<?php echo $rowatt['idtypedocu']  ?>, '<?php echo $rowatt['linkdocu']  ?>',<?php echo $iddiv; ?>)">Next
                                    </button>
                                    <?php
                              }                             
                          ?>
                                </div>

                                <br>
                                <button type="button" class="btn btn-block bg-gradient-primary btn-sm" id="picking"
                                    name="picking"
                                    onClick="save_steps_outcome_integral_idattrbute(0, 12,11, 'N','<?php echo $rowatt['linkdocu']  ?>',<?php echo $rowatt['idtypedocu']  ?>, '<?php echo $rowatt['linkdocu']  ?>',<?php echo $iddiv; ?>)">Finish
                                </button>

                            </div>
                            <?php
                       } 
                       else
                      {
                        ?>
                            <div class="container-fluid">
                                <div class="alert alert-danger alert-dismissible">

                                    <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                                    The PP-ASSY (<?php echo $rowatt['linkdocu'].".pdf"; ?>) does not exist in the
                                    repository.</b>
                                </div>
                            </div>
                            <br>
                            <button type="button" class="btn btn-block bg-gradient-primary btn-sm" id="picking"
                                name="picking"
                                onClick="save_steps_outcome_integral_idattrbute(0, 12,11, 'N','<?php echo $rowatt['linkdocu']  ?>',<?php echo $rowatt['idtypedocu']  ?>, '<?php echo $rowatt['linkdocu']  ?>',<?php echo $iddiv; ?>)">Next
                            </button>
                            <?php
                      }
                    ?>
                            <?php    
              
                  ////Controlamos a ver si el paso Ya fue realizado.
                  
                  if ( $pasos_habilitados  <> "")
                  {
                      $sqlcontrol="select  * from fas_outcome_integral where reference in (
                      select distinct reference
                      from fas_outcome_integral
                      where idfasoutcomecat = 12 AND v_string = '".$elsn."' and idtype = 15)
                      and  idfasoutcomecat = 12 and  idtype =11 and v_string = '".$rowatt['linkdocu']."'  limit 1  ";
                  //    echo "<br>HOLA".$sqlcontrol;
                      $daacntrol = $connect->query($sqlcontrol)->fetchAll();	
                   ///   $iddiv =2;	
                      foreach ($daacntrol as $rowctrl) 
                      {
                        $pasos_habilitados = $pasos_habilitados.','.$iddiv;
                      } 
                  }
              


                 $iddiv=  $iddiv+ 1;                                            
            }
           
         //   $iddiv=  $iddiv+ 1;      
          ?>

                            <div class="card card-widget losdiv_steps" id="divstep<?php echo $iddiv; ?>"
                                name="divstep<?php echo $iddiv; ?>">
                                <div class='container-fluid'>
                                    <br> <br>
                                    <div class="card-body">

                                        <div class="alert alert-success alert-dismissible">
                                            <button type="button" class="close" data-dismiss="alert"
                                                aria-hidden="true">×</button>
                                            <h5><i class="icon fas fa-check"></i> Finalized!</h5>

                                        </div>
                                    </div>
                                </div>
                                <br>



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


    </div>
    <!-- ./wrapper -->
    <input type="hidden" name="stephab" id="stephab" value="<?php echo  $pasos_habilitados; ?>">


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


        //    console.log(' a ver'+ $("#stephab").val())
        habilitamos_comp_qr(0);

        //////// ocultamos todos los div de los pasos
        var losdivs = document.querySelectorAll(".losdiv_steps");

        for (var i = 2; i < losdivs.length; i++) {
            console.log(losdivs[i].id);
            ///  losdivs[i].addClass('d-none');
            $("#" + losdivs[i].id).addClass('d-none');
        }


        procesador_pasos();

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
            var regex = new RegExp("^[a-zA-Z0-9 = { } : ' -]+$");
            var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
            /*    if (!regex.test(key)) {
                    event.preventDefault();
                    return false;
                }*/
        });


        ///bloqueomm
        var elementosConClase = document.getElementsByClassName("bloqueomm");
        for (var i = 0; i < elementosConClase.length; i++) {
            elementosConClase[i].addEventListener("keydown", function(event) {
                if (!validarInput(event)) {
                    event.preventDefault(); // Bloquear la tecla si no es permitida
                }
            });
        }


    });


    function validarInput(event) {
        var codigoTecla = event.keyCode;

        // Permitir solo teclas especiales
        if (
            (codigoTecla >= 35 && codigoTecla <= 40)

        ) {
            return true; // Permitir la tecla
        } else {
            return false; // Bloquear la tecla
        }
    }


    // controlar inactividad en la web	
    $(document).inactivityTimeout({
        inactivityWait: 10000,
        dialogWait: 10,
        logoutUrl: 'logout.php'
    })
    // fin controlar inactividad en la web		

    /* requesting data */

    function verifram(nombrepdf) {
        console.log('https://webfas.honeywell.com/source/' + nombrepdf + '.pdf');
        document.getElementById('iframm').src = 'https://webfas.honeywell.com/source/' + nombrepdf + '.pdf';
    }

    function mostrar_tabla_picking(qhacemos) {
        if (qhacemos == 1) {
            $('#divmaxrev').removeClass('d-none');
            $('#divhistorial').addClass('d-none');
        }
        if (qhacemos == 2) {
            $('#divhistorial').removeClass('d-none');
            $('#divmaxrev').addClass('d-none');
        }
    }

    function validar_envio(qaccionhacemos) {
        var hagosubmit = 'S';
        $("input").each(function(indice, elemento) {
            //En cada elemento p escribimos el texto
            ///  console.log(elemento.id.substring(0,13));
            if (elemento.id.substring(0, 5) == "nuevo") {
                //   console.log( 'a controlar: '+elemento.id +' - '+ indice);
                //   console.log($("#"+elemento.id).val()+'<-valor');
                if ($("#" + elemento.id).val() == '') {
                    hagosubmit = 'N';
                }
            }

        });

        $("#typesave").val(qaccionhacemos);

        if (qaccionhacemos == "draft") {
            toastr["success"]("Sending picking information for draft", "Picking");
            $("#picking").prop('disabled', true);
            $("#nuevosnciu_1").prop('disabled', false);

            $("#typesave").val(qaccionhacemos);
            save_steps_outcome_integral($("#vv_idruninfo").val(), 12, 16, 'N');

            document.frma.submit();
        } else {
            if (hagosubmit == 'S') {
                console.log('envio datos');
                toastr["success"]("Sending Picking information", "Picking");
                $("#picking").prop('disabled', true);
                $("#nuevosnciu_1").prop('disabled', false);

                $("#typesave").val(qaccionhacemos);
                save_steps_outcome_integral($("#vv_idruninfo").val(), 12, 16, 'N');

                document.frma.submit();

            } else {
                toastr["error"]("You must complete all the requested information", "Picking");
            }
        }


    }

    function validar_sn_uso(elsnff, nomintpu) {
        // alert(elsnff);

        if (elsnff != '') {
            $.ajax({
                url: ' ajax_ctrlsncompuse.php',
                data: "elsnactrl=" + elsnff,
                type: 'post',
                async: true,
                cache: false,
                success: function(data) {
                    //    alert(data);
                    //      console.log('1::'+data.mainpcbstring);
                    //   console.log('2::'+$('#nuevosnciu_1').val());
                    if (data.v_wo_serialnumber == $('#nuevosnciu_1').val()) {

                        console.log(data);
                        console.log($('#nuevosnciu_1').val());
                        $('#' + nomintpu).addClass('is-valid');

                        $('#' + nomintpu).removeClass('is-invalid');
                    } else {
                        $('#' + nomintpu).addClass('is-invalid');
                        $('#' + nomintpu).focus();
                        toastr["error"]("the scanned SN has already been used", "Picking");
                    }




                }
            });
        }



        ///--- is-valid


    }


    function replicadiv() {
        var elnum = $("#numerador").val();

        $.ajax({
            url: 'ajaxdivotherspicking.php',
            data: "idoth=" + elnum,
            type: 'post',
            async: true,
            cache: false,
            success: function(data) {

                elnum = parseInt(elnum) + 1;
                $("#numerador").val(elnum);
                $("#divotros").append(data);

            }
        });

        setTimeout(function() {
            //   console.log('a-b-c');
            $('html, body').animate({
                scrollTop: $("#picking").offset().top
            }, 200);


        }, 500);



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
                //    console.log('¡Hola :'+elem+'!'+ procesar[0]); 
            }


        });

        //  console.log(arraydatoscargados);

        $.each(arraydatoscargados, function(ind, elem) {
            //  console.log(elem);
            /// if (elem != 'undefined' || elem != '' )
            if (typeof(elem) != "undefined") {
                nuevostring = nuevostring + elem
            }

        });
        $("#txtaddcatothersarray").val(nuevostring);
    }

    function opendivsteps(v_namediv) {
        var losdivs = document.querySelectorAll(".losdiv_steps");

        for (var i = 0; i < losdivs.length; i++) {
            //     console.log(losdivs[i].id);
            ///  losdivs[i].addClass('d-none');
            $("#" + losdivs[i].id).addClass('d-none');
        }

        $("#" + v_namediv).removeClass('d-none');

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
            $("#txtaddcatothersarray").val($("#txtaddcatothersarray").val().trim() + idcatmat + '#' + v_lacategoria +
                '#' + v_lacategoria_obs + '|');

            $("#txtotherbycat").val('');

        }




    }

    function habilitarrev() {
        $("#divaddpicking").removeClass('d-none');
        $("#divotros").removeClass('d-none');
        $("#idaddextra").removeClass('d-none');

    }

    function procesador_pasos() {


        var losdivs = document.querySelectorAll(".losdiv_steps");

        for (var i = 0; i < losdivs.length; i++) {
            console.log(losdivs[i].id);
            ///  losdivs[i].addClass('d-none');
            $("#" + losdivs[i].id).addClass('d-none');
        }


        if ($("#stephab").val() != '') {
            const lospasos_a_habilitar = $("#stephab").val().split(",");
            var mmlength = lospasos_a_habilitar.length;
            for (var imm = 0; imm <= mmlength; imm++) {
                //  console.log('a'+lospasos_a_habilitar[imm]);  
                v_namediv = 1 + parseInt(lospasos_a_habilitar[imm]);
                //console.log('b'+v_namediv);  
                $("#divstep" + v_namediv).addClass('d-none');
                $("#globY" + v_namediv).removeClass('d-none');
                $("#globN" + v_namediv).addClass('d-none');


            }
            //   console.log('salio id '+imm); 
            $("#divstep" + imm).removeClass('d-none');
        } else {
            $("#divstep1").removeClass('d-none');
        }



    }

    function habilitamos_comp_qr(qpasohab_estoy) {
        /*const los_tipos_comp =$("#lostiposdecomparry").val().split(",");
        var mmttlen = los_tipos_comp.length;
        const posicion_to_open = $("#lostiposdecomparrypos").val();

          for (var imm = 0; imm < mmttlen; imm++) 
          {
           //readqr2 
           if (qpasohab_estoy==0 && imm==0 )
           {
            abrirqrcomponet('readqr'+los_tipos_comp[imm]);
            document.getElementById('readqr'+los_tipos_comp[imm]).focus();
           }
           ///lostiposdecomparrypos

           if (qpasohab_estoy==1 && imm==posicion_to_open )
           {
            abrirqrcomponet('readqr'+los_tipos_comp[imm]);
            document.getElementById('readqr'+los_tipos_comp[imm]).focus();
           }



          }

        //  console.log(posicion_to_open);
        //  console.log(mmttlen);
          if(posicion_to_open ==mmttlen)
          {
            alert('focus');
            document.getElementById('picking').focus();
          }*/
    }

    function save_steps_outcome_integral(vvv_refence, vcatt, cccatttype, redirecciono, vvsn) {

        $.ajax({
            url: 'ajax_create_runinfooutcome.php',
            data: "vvv_refence=" + vvv_refence + '&vcatt=' + vcatt + '&cccatttype=' + cccatttype + '&vsn=' + $(
                "#elsn").val() + '&typeworkc=' + $("#typeworkc").val(),
            type: 'post',
            datatype: 'JSON',
            success: function(data) {
                // 
                if (data.result == "ok") {
                    if (redirecciono == 'Y') {
                        Swal.fire({
                            title: 'Saved!',
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok',
                        }).then((result) => {


                            window.parent.location = 'trackingordersmm.php?isdo=' + $("#vidso")
                                .val() + '&typeisdo=SO&encont=' + $("#vsn").val();



                        })
                    }

                }

                ///alert(data.result);
            }
        });

    }

    function save_steps_outcome_integral_idattrbute(vvv_refence, vcatt, cccatttype, redirecciono, vvsn, idattri,
        idnameattrib, idstep) {

        $.ajax({
            url: 'ajax_create_runinfooutcome.php',
            data: "vvv_refence=" + $("#vv_idruninfo").val() + '&vcatt=' + vcatt + '&cccatttype=' + cccatttype +
                '&vsn=' + idnameattrib + '&nidattrib=' + idattri + '&iinserttype=Specf&typeworkc=' + $(
                    "#typeworkc").val(),
            type: 'post',
            datatype: 'JSON',
            success: function(data) {
                // 
                if (data.result == "ok") {
                    if (redirecciono == 'Y') {
                        Swal.fire({
                            title: 'Saved!',
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Ok',
                        }).then((result) => {


                            window.parent.location = 'trackingordersmm.php?isdo=' + $("#vidso")
                                .val() + '&typeisdo=SO&encont=' + $("#vsn").val();



                        })
                    }

                }

                ///alert(data.result);
            }
        });

        if (document.getElementById("stephab").value.search(idstep) < 0) {
            document.getElementById("stephab").value = $("#stephab").val() + ',' + idstep;
        }

        procesador_pasos();
    }

    function search_data_enter_qr(eventqr, namelemqr, idcompparam, chk_comp_sn, sku_for_check) {
        if (eventqr.keyCode == 13) {
            console.log("Enter key is pressed");
            console.log('hola' + $('#' + namelemqr).val());
            $('#' + namelemqr + 'wait').removeClass("d-none");
            var textoauditar = 'elciu_' + $('#elciu').val() + '__elsn_' + $('#elsn').val();
            ///Controlamos Qr leido
            $.ajax({
                url: 'ajax_decode_board_inf.php',
                data: "txtdecode=" + $('#' + namelemqr).val() + '&sku_for_check=' + sku_for_check +
                    '&textoauditar=' + textoauditar,
                type: 'post',
                async: true,
                cache: false,
                success: function(data) {
                    console.log(data.result);
                    const objdd = JSON.parse(data.result);
                    console.log(objdd);
                    if (objdd.status == 'ok') {

                        //cargamos datos
                        //nuevosnciu_2
                        //nuevonamecomp_2
                        //nuevorev_2
                        //nuevobatch_2


                        var encontreciu = "N";
                        var dd = document.getElementById('nuevosnciu_' + idcompparam);
                        /*   for (var i = 0; i < dd.options.length; i++) {
                               if (dd.options[i].text === objdd.t_part) {
                                   dd.selectedIndex = i;
                                   var encontreciu="S";
                                   break;
                               }
                           }*/
                        //  if (encontreciu=="N")
                        /*   {
                          $('#'+namelemqr+'okno').removeClass("d-none");
                          $('#'+namelemqr+'ok').addClass("d-none");     
                          $('#'+namelemqr).val('');
                          toastr["error"]("CIU Error ", "Picking");
                 /*       }
                        else
                        {
                          */

                        $("#nuevorev_" + idcompparam).val('');
                        $("#nuevobatch_" + idcompparam).val('');

                        console.log('a ver el rev' + objdd.t_rev);
                        $("#nuevonamecomp_" + idcompparam).val(objdd.t_set);


                        if (chk_comp_sn == 1) {

                            if (objdd.t_rev === undefined) {
                                //  $("#nuevorev_" + idcompparam).val(0);

                                if (objdd.t_rev == null) {
                                    $("#nuevorev_" + idcompparam).val('00');
                                }
                                console.log('aaaaaaaaaaaaaaaaaaaa');

                            } else {

                                if (objdd.t_rev == null) {
                                    $("#nuevorev_" + idcompparam).val('00');
                                } else {
                                    $("#nuevorev_" + idcompparam).val(objdd.t_rev);
                                }


                                // $("#nuevorev_" + idcompparam).val(objdd.t_rev);
                            }
                            if (objdd.t_lot === undefined) {
                                //  $("#nuevobatch_" + idcompparam).val(0);
                                if (objdd.t_lot == null) {
                                    $("#nuevobatch_" + idcompparam).val('00');
                                }
                            } else {
                                $("#nuevobatch_" + idcompparam).val(objdd.t_lot);

                                if (objdd.t_lot == null) {
                                    $("#nuevobatch_" + idcompparam).val('00');
                                } else {
                                    $("#nuevobatch_" + idcompparam).val(objdd.t_lot);
                                }

                            }

                            chk_idruninfo_status_sn(objdd.t_set, objdd.t_part, idcompparam, $('#elsn').val());
                        } else {



                            if (objdd.t_rev === undefined) {
                                $("#nuevorev_" + idcompparam).val('00');
                                console.log('ddd');
                            } else {
                                $("#nuevorev_" + idcompparam).val(objdd.t_rev);
                            }
                            if (objdd.t_lot === undefined) {
                                $("#nuevobatch_" + idcompparam).val('00');
                            } else {
                                $("#nuevobatch_" + idcompparam).val(objdd.t_lot);
                            }

                            console.log('bbbbbbbbbb');
                            if (objdd.t_rev == null) {
                                $("#nuevorev_" + idcompparam).val('00');
                                console.log('cccc');
                            }
                            if (objdd.t_lot == null) {
                                $("#nuevobatch_" + idcompparam).val('00');
                                console.log('cccc');
                            }

                        }


                        //   $("#nuevobatch_"+idcompparam ).val('1');


                        $('#' + namelemqr + 'ok').removeClass("d-none");
                        $('#' + namelemqr + 'okno').addClass("d-none");
                        $('#' + namelemqr).addClass("d-none");
                        $("#lostiposdecomparrypos").val(parseInt($("#lostiposdecomparrypos").val()) + 1);
                        $('#' + namelemqr + 'wait').addClass("d-none");

                        //trato de poner focus en el sigueintes
                        //acamarco
                        //$('readqr1010').
                        var nuevocompparafocus = idcompparam + 10;

                        ///  document.getElementById('readqr'+ nuevocompparafocus ).focus();
                        console.log('readqr' + nuevocompparafocus);


                        if ($('#readqr' + nuevocompparafocus).length > 0) {
                            console.log('focus en readqr' + nuevocompparafocus);

                            //   document.getElementById('readqr'+ nuevocompparafocus ).focus();
                            $('#readqr' + nuevocompparafocus).focus();
                            //   habilitamos_comp_qr(1);
                        } else {
                            //picking
                            console.log('picking');

                            document.getElementById('picking').focus();
                            $('#picking').focus();
                        }


                        //         }




                    }
                    if (objdd.status == 'error') {
                        $('#' + namelemqr + 'okno').removeClass("d-none");
                        $('#' + namelemqr + 'ok').addClass("d-none");
                        $('#' + namelemqr).val('');
                        toastr["error"](" " + data.erromsj, "Picking ALERT!");

                    }
                    $('#' + namelemqr + 'wait').addClass("d-none");



                }
            });
            //   $('#'+namelemqr+'wait').addClass("d-none");  

            return true;
        } else {
            //  return false;
        }

    }

    function chk_idruninfo_status_sn(sn, sku, idcomphtml, snequ) {
        console.log('Chk Status del SN in FAS:' + sn + '-sku:' + sku + '--idcomphtml:' + idcomphtml+ 'snequ'+snequ);


        $.ajax({
            url: 'ajax_chk_idruninfo_status_sn.php',
            data: "sn=" + sn + '&sku=' + sku + '&idcomphtml=' + idcomphtml+'&snequ='+snequ,
            type: 'post',
            async: true,
            cache: false,
            success: function(data) {
                console.log(data);
                //   const objdd = JSON.parse(data.status);
                console.log(data.status);
                if (data.status == 'ok') {
                    console.log('ok:' + idcomphtml);

                    $('#' + idcomphtml + 'okno').addClass("d-none");
                    $('#' + idcomphtml + 'ok').removeClass("d-none");
                    console.log(data.v_batch_acep);
                    console.log(data.v_rev_acep);
                    if (data.v_batch_acep == $("#nuevobatch_" + idcomphtml).val()) {
                        console.log('iguales');

                    } else {
                        $("#nuevorev_" + idcomphtml).val(data.v_rev_acep);
                        $("#nuevobatch_" + idcomphtml).val(data.v_batch_acep);
                    }

                }
                if (data.status == 'Nopass') {
                    console.log('error' + "#nuevonamecomp_" + idcomphtml);
                    toastr["error"]("SN entered was not accepted by FAS ", "Picking ALERT!");

                    $('#readqr' + idcomphtml + 'ok').hide();
                    $('#readqr' + idcomphtml + 'okno').removeClass("d-none");


                    $("#nuevonamecomp_" + idcomphtml).val('');
                    //  $("#nuevorev_" + idcomphtml).val('00');
                    //   $("#nuevobatch_" + idcomphtml).val('00');


                }
                if (data.status == 'sn_used') {
                    console.log('error' + "#nuevonamecomp_" + idcomphtml);
                    toastr["error"]("the SN entered was already used in another PO ", "Picking ALERT!");

                    $('#readqr' + idcomphtml + 'ok').hide();
                    $('#readqr' + idcomphtml + 'okno').removeClass("d-none");


                    $("#nuevonamecomp_" + idcomphtml).val('');
                    //  $("#nuevorev_" + idcomphtml).val('00');
                    //   $("#nuevobatch_" + idcomphtml).val('00');


                }
            }
        });
    }

    function abrirqrcomponet(q_qr_open) {

        //$('#'+q_qr_open).removeClass("d-none");   

        //  console.log(   $('#'+q_qr_open).className );


        var classList = document.getElementById(q_qr_open).classList;
        var qhacemos = 0;
        for (var i = 0; i < classList.length; i++) {
            //    console.log(classList[i]);
            if (classList[i] == 'd-none') {
                qhacemos = 1;
            }
        }

        if (qhacemos == 1) {
            $('#' + q_qr_open).removeClass("d-none");
        } else {
            $('#' + q_qr_open).addClass("d-none");
        }
        document.getElementById(q_qr_open).focus();

        return false;
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
<?php
  $vuserfas = $_SESSION["b"];
			//////outcome integral///////////////////////////////////////////////////////////////////////////////
      $sqlooutcome="select fnt_create_newid_xbusiness_station_user('".$vuserfas."','webfas.honeywell.com')";      
   //  echo "a ver". $sqlooutcome;      
      $datacabez_out = $connect->query($sqlooutcome)->fetchAll();
   
      $_idruninfo_reference =0;
        foreach ($datacabez_out as $rowheaders_out) 
        {
     //   echo "<br>id_idruninfo_reference".$rowheaders_out[0];  
          $_idruninfo_reference =$rowheaders_out[0];  
        }
        ?>
<input type="hidden" name="vv_idruninfo" id="vv_idruninfo" value="<?php echo   $_idruninfo_reference;?>">
<input type="hidden" name="typeworkc" id="typeworkc" value="<?php echo $_REQUEST['typeworkc'];?>">
<input type="hidden" name="typesave" id="typesave" value="confirm">


<?php

              

            
      /////////////////////////////////////////////////////////////////////////////////////
?>
</form>